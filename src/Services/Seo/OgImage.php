<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Core\Config;
use App\Core\CurlHttpClient;
use App\Core\Logger;
use App\Services\Storage\S3;

/**
 * Imagen para compartir (Open Graph) de las portadas WebP.
 *
 * WhatsApp y LinkedIn no siempre muestran vistas previas con imágenes WebP, así que de cada portada
 * WebP (local o del bucket propio) se genera una vez un JPEG de 1200×630 (proporción 1.91:1 que usan
 * todas las redes) en public/og/. Nginx lo sirve como archivo estático. Si algo falla, se usa la portada.
 */
final class OgImage
{
    public const WIDTH = 1200;
    public const HEIGHT = 630;
    private const DIR = 'public/og';

    /** @return array{url:string, width:int, height:int}|null URL relativa al sitio */
    public static function forCover(?string $cover, ?string $srcset = null): ?array
    {
        if ($cover === null || $cover === '' || !function_exists('imagecreatefromstring') || !function_exists('imagejpeg')) {
            return null;
        }
        $source = self::largest($cover, $srcset);
        if (!preg_match('/\.webp$/i', (string) parse_url($source, PHP_URL_PATH))) {
            return null;
        }
        $name = substr(sha1($source), 0, 24) . '.jpg';
        $file = Config::root(self::DIR . '/' . $name);
        if (!is_file($file)) {
            try {
                if (!self::build($source, $file)) {
                    return null;
                }
            } catch (\Throwable $e) {
                Logger::error('No se pudo generar la imagen para compartir', ['source' => $source, 'error' => $e->getMessage()]);
                return null;
            }
        }
        $size = @getimagesize($file);
        return ['url' => '/og/' . $name, 'width' => (int) ($size[0] ?? self::WIDTH), 'height' => (int) ($size[1] ?? self::HEIGHT)];
    }

    /** La variante más ancha del srcset (las portadas propias traen 640/960/1440 o 800/1600). */
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
        return $best;
    }

    private static function read(string $source): ?string
    {
        if (str_starts_with($source, '/') && !str_starts_with($source, '//')) {
            $public = realpath(Config::root('public'));
            $path = realpath(Config::root('public' . (string) parse_url($source, PHP_URL_PATH)));
            if ($public === false || $path === false || !str_starts_with($path, $public . DIRECTORY_SEPARATOR) || filesize($path) > 15_000_000) {
                return null;
            }
            return (string) file_get_contents($path);
        }
        // Remotas: solo del bucket propio.
        if (S3::keyFromUrl($source) === null) {
            return null;
        }
        $res = (new CurlHttpClient(6))->request('GET', $source);
        return $res['status'] === 200 && $res['body'] !== '' && strlen($res['body']) < 15_000_000 ? $res['body'] : null;
    }

    private static function build(string $source, string $file): bool
    {
        $bytes = self::read($source);
        $img = $bytes !== null ? @imagecreatefromstring($bytes) : false;
        if ($img === false) {
            return false;
        }
        $w = imagesx($img);
        $h = imagesy($img);
        // Recorte centrado a 1.91:1 sin ampliar de más: si la fuente es pequeña, la salida también.
        $outW = min(self::WIDTH, $w);
        $outH = (int) round($outW * self::HEIGHT / self::WIDTH);
        $scale = max($outW / $w, $outH / $h);
        $cropW = (int) round($outW / $scale);
        $cropH = (int) round($outH / $scale);
        $dst = imagecreatetruecolor($outW, $outH);
        imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
        imagecopyresampled($dst, $img, 0, 0, (int) (($w - $cropW) / 2), (int) (($h - $cropH) / 2), $outW, $outH, $cropW, $cropH);
        imageinterlace($dst, true);
        $dir = dirname($file);
        if (!is_dir($dir) && !@mkdir($dir, 0775, true) && !is_dir($dir)) {
            return false;
        }
        $tmp = $file . '.' . uniqid('', true) . '.tmp';
        $ok = imagejpeg($dst, $tmp, 82);
        imagedestroy($dst);
        imagedestroy($img);
        return $ok && rename($tmp, $file);
    }
}
