<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\Config;
use App\Core\CurlHttpClient;
use App\Core\Logger;
use App\Services\Seo\OgImage;
use App\Services\Storage\S3;

/**
 * Imágenes para redes (JPEG en public/social/, servidas como archivos estáticos).
 *
 * - Facebook: la de Open Graph de 1200×630 (OgImage, la misma que muestra la vista previa del enlace); si la
 *   portada no es WebP o no hay portada, se arma aquí una de 1200×630.
 * - Instagram: 1080×1350 (4:5) con la portada arriba y una franja inferior con los colores de la marca,
 *   la sección, el título y "edwinortiz.net". Sin portada, un fondo con degradado de la marca.
 */
final class ImageMaker
{
    private const DIR = 'public/social';
    private const VERSION = 'v2';
    private const NIGHT = [7, 11, 24];
    private const BRAND = [35, 80, 240];
    private const ACCENT = [15, 184, 154];
    private const WHITE = [255, 255, 255];

    /** Pruebas: true evita generar imágenes (y descargar portadas remotas). */
    public static bool $disabled = false;

    public static function available(): bool
    {
        return !self::$disabled && function_exists('imagecreatetruecolor') && function_exists('imagettftext') && function_exists('imagejpeg');
    }

    /** @return string|null ruta relativa al sitio (/og/… o /social/…) */
    public static function facebook(array $item): ?string
    {
        if (!self::available()) {
            return null;
        }
        if (!empty($item['cover'])) {
            $og = OgImage::forCover((string) $item['cover'], $item['srcset'] ?? null);
            if ($og !== null) {
                return $og['url'];
            }
        }
        return self::cached($item, 'fb', fn (string $file) => self::draw($item, 1200, 630, $file));
    }

    /** @return string|null ruta relativa al sitio (/social/…) */
    public static function instagram(array $item): ?string
    {
        if (!self::available()) {
            return null;
        }
        return self::cached($item, 'ig', fn (string $file) => self::draw($item, 1080, 1350, $file));
    }

    private static function cached(array $item, string $kind, callable $build): ?string
    {
        $name = substr(sha1(self::VERSION . '|' . $kind . '|' . ($item['cover'] ?? '') . '|' . $item['title'] . '|' . self::kicker($item)), 0, 24) . "-$kind.jpg";
        $file = Config::root(self::DIR . '/' . $name);
        if (!is_file($file)) {
            try {
                $dir = dirname($file);
                if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
                    return null;
                }
                if (!$build($file)) {
                    return null;
                }
            } catch (\Throwable $e) {
                Logger::error('No se pudo generar la imagen para redes', ['item' => $item['key'] ?? '', 'error' => $e->getMessage()]);
                return null;
            }
        }
        return '/social/' . $name;
    }

    private static function draw(array $item, int $w, int $h, string $file): bool
    {
        $img = imagecreatetruecolor($w, $h);
        imagealphablending($img, true);
        imagefill($img, 0, 0, self::color($img, self::NIGHT));
        $photo = !empty($item['cover']) ? self::load(self::largest((string) $item['cover'], $item['srcset'] ?? null)) : null;
        $portrait = $h > $w;
        if ($portrait) {
            // Foto arriba (alto según su proporción, entre 560 y 760 px) y franja de texto abajo.
            $photoH = $photo ? (int) max(560, min(760, round($w * imagesy($photo) / max(1, imagesx($photo))))) : 600;
            $photo ? self::cover($img, $photo, 0, 0, $w, $photoH) : self::gradient($img, 0, 0, $w, $photoH);
            self::fade($img, $photoH - 140, $photoH, $w);
            $top = $photoH + 40;
            $pad = 72;
            $titleMax = 66;
            $titleMin = 40;
            $lines = 4;
        } else {
            // Horizontal sin portada (o portada no WebP): foto a la derecha o degradado, texto a la izquierda.
            if ($photo) {
                self::cover($img, $photo, 0, 0, $w, $h);
                self::shade($img, $w, $h);
            } else {
                self::gradient($img, 0, 0, $w, $h);
            }
            $top = 150;
            $pad = 72;
            $titleMax = 64;
            $titleMin = 38;
            $lines = 3;
        }
        if ($photo) {
            imagedestroy($photo);
        }
        $bold = self::font('ExtraBold');
        $semi = self::font('SemiBold');
        // Título: el tamaño más grande que quepa en $lines líneas
        $title = self::plain((string) $item['title']);
        $width = $w - 2 * $pad;
        $size = $titleMax;
        do {
            $wrapped = self::wrap($title, $bold, $size, $width);
            if (count($wrapped) <= $lines) {
                break;
            }
            $size -= 2;
        } while ($size > $titleMin);
        if (count($wrapped) > $lines) {
            $wrapped = array_slice($wrapped, 0, $lines);
            $wrapped[$lines - 1] = rtrim($wrapped[$lines - 1], ' ,.;:') . '…';
        }
        if ($portrait) {
            // Bloque de texto centrado en la franja (entre la foto y el pie).
            $block = 100 + (int) round($size * 1.05) + (count($wrapped) - 1) * (int) round($size * 1.28);
            $top += max(0, (int) ((($h - 130) - $top - $block) / 2));
        }
        // Barra de acento y sección
        imagefilledrectangle($img, $pad, $top, $pad + 88, $top + 9, self::color($img, self::ACCENT));
        imagettftext($img, 26, 0, $pad, $top + 62, self::color($img, self::ACCENT), $semi, mb_strtoupper(self::kicker($item)));
        $y = $top + 100 + (int) round($size * 1.05);
        foreach ($wrapped as $line) {
            imagettftext($img, $size, 0, $pad, $y, self::color($img, self::WHITE), $bold, $line);
            $y += (int) round($size * 1.28);
        }
        // Pie: dominio y sello "EO"
        $footY = $h - 64;
        imagettftext($img, 28, 0, $pad, $footY, self::color($img, [210, 220, 245]), $semi, 'edwinortiz.net');
        $box = 64;
        $bx = $w - $pad - $box;
        $by = $footY - 46;
        imagefilledrectangle($img, $bx, $by, $bx + $box, $by + $box, self::color($img, self::BRAND));
        $bb = imagettfbbox(24, 0, $bold, 'EO');
        imagettftext($img, 24, 0, $bx + (int) (($box - ($bb[2] - $bb[0])) / 2), $by + 44, self::color($img, self::WHITE), $bold, 'EO');

        imageinterlace($img, true);
        $tmp = $file . '.' . uniqid('', true) . '.tmp';
        $ok = imagejpeg($img, $tmp, 86);
        imagedestroy($img);
        return $ok && rename($tmp, $file);
    }

    /** Sección o tipo que encabeza la imagen. */
    public static function kicker(array $item): string
    {
        return match ($item['type']) {
            'product' => match ($item['product_type'] ?? 'download') {
                'course' => 'Curso',
                'service' => 'Servicio',
                default => 'Plantilla y descarga',
            },
            'tool' => in_array($item['id_key'] ?? '', ['piar', 'examenes'], true) ? 'Herramienta con IA' : (($item['id_key'] ?? '') === 'fundales' ? 'Concurso Docente' : 'Herramienta gratis'),
            'page' => 'Guía',
            default => (string) ($item['hub_title'] ?? 'Blog'),
        };
    }

    private static function font(string $weight): string
    {
        $own = Config::root("resources/fonts/PlusJakartaSans-$weight.ttf");
        if (is_file($own)) {
            return $own;
        }
        return Config::root('vendor/dompdf/dompdf/lib/fonts/DejaVuSans-Bold.ttf');
    }

    /** Quita emojis y caracteres fuera del plano básico (la fuente no los tiene). */
    private static function plain(string $text): string
    {
        $text = (string) preg_replace('/[\x{10000}-\x{10FFFF}\x{2600}-\x{27BF}\x{FE0F}]/u', '', html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        return trim((string) preg_replace('/\s+/u', ' ', $text));
    }

    /** @return string[] */
    private static function wrap(string $text, string $font, int $size, int $width): array
    {
        $lines = [];
        $line = '';
        foreach (explode(' ', $text) as $word) {
            $try = $line === '' ? $word : "$line $word";
            $box = imagettfbbox($size, 0, $font, $try);
            if ($line !== '' && ($box[2] - $box[0]) > $width) {
                $lines[] = $line;
                $line = $word;
            } else {
                $line = $try;
            }
        }
        if ($line !== '') {
            $lines[] = $line;
        }
        return $lines;
    }

    private static function color(\GdImage $img, array $rgb, int $alpha = 0): int
    {
        return imagecolorallocatealpha($img, $rgb[0], $rgb[1], $rgb[2], $alpha);
    }

    /** Recorte centrado que cubre el área (como object-fit: cover). */
    private static function cover(\GdImage $dst, \GdImage $src, int $x, int $y, int $w, int $h): void
    {
        $sw = imagesx($src);
        $sh = imagesy($src);
        $scale = max($w / $sw, $h / $sh);
        $cw = (int) round($w / $scale);
        $ch = (int) round($h / $scale);
        imagecopyresampled($dst, $src, $x, $y, (int) (($sw - $cw) / 2), (int) (($sh - $ch) / 2), $w, $h, $cw, $ch);
    }

    /** Degradado diagonal de la marca (azul → noche) con un brillo del acento. */
    private static function gradient(\GdImage $img, int $x, int $y, int $w, int $h): void
    {
        for ($i = 0; $i < $h; $i += 2) {
            $t = $i / max(1, $h);
            $rgb = [
                (int) round(self::BRAND[0] * (1 - $t) + self::NIGHT[0] * $t),
                (int) round(self::BRAND[1] * (1 - $t) + self::NIGHT[1] * $t),
                (int) round(self::BRAND[2] * (1 - $t) + self::NIGHT[2] * $t),
            ];
            imagefilledrectangle($img, $x, $y + $i, $x + $w, $y + $i + 1, self::color($img, $rgb));
        }
        imagefilledellipse($img, $x + (int) ($w * 0.85), $y + (int) ($h * 0.2), (int) ($w * 0.7), (int) ($w * 0.7), self::color($img, self::ACCENT, 112));
    }

    /** Transición de la foto a la franja oscura. */
    private static function fade(\GdImage $img, int $from, int $to, int $w): void
    {
        $steps = max(1, $to - $from);
        for ($i = 0; $i < $steps; $i++) {
            $alpha = (int) round(127 - 127 * ($i / $steps));
            imageline($img, 0, $from + $i, $w, $from + $i, self::color($img, self::NIGHT, max(0, min(127, $alpha))));
        }
    }

    /** Velo oscuro sobre la foto para que el texto se lea (versión horizontal). */
    private static function shade(\GdImage $img, int $w, int $h): void
    {
        imagefilledrectangle($img, 0, 0, $w, $h, self::color($img, self::NIGHT, 40));
    }

    private static function largest(string $cover, ?string $srcset): string
    {
        $best = $cover;
        $bestW = 0;
        foreach (explode(',', (string) $srcset) as $candidate) {
            if (preg_match('/^\s*(\S+)\s+(\d+)w\s*$/', $candidate, $m) && (int) $m[2] > $bestW) {
                $best = $m[1];
                $bestW = (int) $m[2];
            }
        }
        // Portadas propias: si existe la variante de 1440 px, se usa.
        if ($bestW === 0 && preg_match('#^(/assets/img/.+)-(640|960)\.webp$#', $cover, $m) && is_file(Config::root('public' . $m[1] . '-1440.webp'))) {
            return $m[1] . '-1440.webp';
        }
        return $best;
    }

    private static function load(string $source): ?\GdImage
    {
        $bytes = null;
        if (str_starts_with($source, '/') && !str_starts_with($source, '//')) {
            $public = realpath(Config::root('public'));
            $path = realpath(Config::root('public' . (string) parse_url($source, PHP_URL_PATH)));
            if ($public !== false && $path !== false && str_starts_with($path, $public . DIRECTORY_SEPARATOR) && filesize($path) < 15_000_000) {
                $bytes = (string) file_get_contents($path);
            }
        } elseif (S3::keyFromUrl($source) !== null || in_array(parse_url($source, PHP_URL_HOST), ['blogedwinortiznet.s3.amazonaws.com', 'www.edwinortiz.net', 'edwinortiz.net'], true)) {
            $res = (new CurlHttpClient(10))->request('GET', $source);
            $bytes = $res['status'] === 200 && strlen($res['body']) < 15_000_000 ? $res['body'] : null;
        }
        $img = $bytes ? @imagecreatefromstring($bytes) : false;
        if ($img === false) {
            return null;
        }
        if (!imageistruecolor($img)) {
            imagepalettetotruecolor($img);
        }
        return $img;
    }
}
