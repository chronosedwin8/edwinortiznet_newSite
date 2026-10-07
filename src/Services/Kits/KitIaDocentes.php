<?php

declare(strict_types=1);

namespace App\Services\Kits;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Core\View;
use App\Services\Downloads\DownloadService;
use App\Services\Storage\S3;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Kit de IA para docentes, vendido por materia: el contenido vive en database/kits/ia-docentes/{materia}.php
 * (más _comun.php) y `php bin/console kit:build` genera por materia un PDF imprimible y un prompts.txt,
 * los empaqueta en kit-ia-docentes-{materia}.zip y los registra como archivo del producto con `variant` = materia.
 */
final class KitIaDocentes
{
    public const SKU = 'EO-KIT-IA';
    public const SLUG = 'kit-de-ia-para-docentes';
    public const EDITION = 'Edición 2026';

    /** Materias en el orden en que se presentan. */
    public const SUBJECTS = ['matematicas', 'lenguaje', 'naturales', 'sociales', 'ingles', 'tecnologia'];

    public const CATEGORIES = [
        'planeacion' => 'Planeación',
        'evaluacion' => 'Evaluación',
        'adaptacion' => 'Adaptación e inclusión',
        'recursos' => 'Recursos y materiales',
        'retroalimentacion' => 'Retroalimentación',
        'gestion' => 'Gestión y comunicación',
    ];

    /** Color principal y suave de cada materia (portada, encabezados y fichas). */
    public const COLORS = [
        'matematicas' => ['#2747a8', '#e8eeff'],
        'lenguaje' => ['#7a2e8f', '#f5eaf8'],
        'naturales' => ['#1f7a3d', '#e6f4ea'],
        'sociales' => ['#a2520a', '#fbefe2'],
        'ingles' => ['#b3262e', '#fbe9ea'],
        'tecnologia' => ['#0b6e7d', '#e2f3f5'],
    ];

    public static function dir(): string
    {
        return Config::root('database/kits/ia-docentes');
    }

    public static function common(): array
    {
        return require self::dir() . '/_comun.php';
    }

    /** Contenido de una materia, o null si su archivo aún no existe. */
    public static function load(string $key): ?array
    {
        if (!in_array($key, self::SUBJECTS, true)) {
            return null;
        }
        $file = self::dir() . "/$key.php";
        if (!is_file($file)) {
            return null;
        }
        $kit = require $file;
        return is_array($kit) ? $kit : null;
    }

    /**
     * Revisa la estructura del contenido. @return string[] problemas (vacío = válido)
     */
    public static function validate(array $kit): array
    {
        $problems = [];
        foreach (['key', 'name', 'tagline', 'intro_html', 'referentes_html', 'mapa', 'recetas', 'cadenas', 'rubricas', 'errores', 'banco_contextos'] as $field) {
            if (empty($kit[$field])) {
                $problems[] = "Falta «{$field}»";
            }
        }
        $ids = [];
        foreach ($kit['recetas'] ?? [] as $i => $r) {
            $id = (string) ($r['id'] ?? "#$i");
            if (isset($ids[$id])) {
                $problems[] = "Receta repetida: $id";
            }
            $ids[$id] = true;
            foreach (['titulo', 'categoria', 'grados', 'tiempo_ahorrado', 'cuando', 'prompt'] as $field) {
                if (empty($r[$field])) {
                    $problems[] = "$id: falta «{$field}»";
                }
            }
            if (!isset(self::CATEGORIES[$r['categoria'] ?? ''])) {
                $problems[] = "$id: categoría desconocida «" . ($r['categoria'] ?? '') . '»';
            }
        }
        foreach ($kit['cadenas'] ?? [] as $c) {
            foreach ($c['pasos'] ?? [] as $paso) {
                $ref = (string) ($paso['receta'] ?? '');
                if ($ref !== '' && !isset($ids[$ref])) {
                    $problems[] = "Flujo «" . ($c['titulo'] ?? '') . "»: la receta $ref no existe";
                }
            }
        }
        return $problems;
    }

    /** Recetas agrupadas por categoría, en el orden de CATEGORIES. */
    public static function grouped(array $kit): array
    {
        $groups = array_fill_keys(array_keys(self::CATEGORIES), []);
        foreach ($kit['recetas'] as $r) {
            $groups[$r['categoria']][] = $r;
        }
        return array_filter($groups);
    }

    /** Prompts de DUA del capítulo común (acepta textos sueltos o ['titulo', 'prompt']). */
    public static function duaPrompts(array $common): array
    {
        $out = [];
        foreach ($common['dua_prompts'] ?? [] as $i => $p) {
            $out[] = is_array($p) ? ['titulo' => (string) ($p['titulo'] ?? ''), 'prompt' => (string) ($p['prompt'] ?? '')]
                : ['titulo' => 'Instrucción DUA ' . ($i + 1), 'prompt' => (string) $p];
        }
        return $out;
    }

    public static function html(array $kit, array $common, array $pages = []): string
    {
        [$color, $soft] = self::COLORS[$kit['key']] ?? ['#2747a8', '#e8eeff'];
        return View::render('kits/ia-docentes-pdf', [
            'kit' => $kit,
            'common' => $common,
            'groups' => self::grouped($kit),
            'categories' => self::CATEGORIES,
            'dua' => self::duaPrompts($common),
            'color' => $color,
            'soft' => $soft,
            'edition' => self::EDITION,
            'pages' => $pages,
        ]);
    }

    /**
     * PDF en dos pasadas: la primera anota en qué página empieza cada sección (ids "s-…" y "r-…")
     * y la segunda escribe esos números en el índice.
     */
    public static function pdf(array $kit, array $common): string
    {
        $pages = [];
        self::render(self::html($kit, $common, []), $kit, $pages);
        $again = [];
        $pdf = self::render(self::html($kit, $common, $pages), $kit, $again);
        if ($again !== $pages) {
            // El índice cambió de tamaño entre pasadas: una tercera pasada con los números definitivos.
            $pages = $again;
            $pdf = self::render(self::html($kit, $common, $pages), $kit, $again);
        }
        return $pdf;
    }

    /** @param array<string,int> $pages se llena con id => página */
    private static function render(string $html, array $kit, array &$pages): string
    {
        $tmp = Config::storage('cache/dompdf');
        if (!is_dir($tmp)) {
            mkdir($tmp, 0770, true);
        }
        $options = new Options();
        $options->setDefaultFont('DejaVu Sans');
        $options->setIsRemoteEnabled(false);
        $options->setIsPhpEnabled(false);
        $options->setIsJavascriptEnabled(false);
        $options->setTempDir($tmp);
        $options->setFontCache($tmp);
        $options->setChroot([Config::root('public')]);
        $options->setDpi(96);
        $dompdf = new Dompdf($options);
        $dompdf->setCallbacks([[
            'event' => 'begin_frame',
            'f' => static function ($frame, $canvas) use (&$pages): void {
                $node = $frame->get_node();
                if ($node instanceof \DOMElement && ($id = $node->getAttribute('id')) !== '' && preg_match('/^[sr]-/', $id) && !isset($pages[$id])) {
                    $pages[$id] = $canvas->get_page_number();
                }
            },
        ]]);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->addInfo('Title', 'Kit de IA para docentes — ' . $kit['name']);
        $dompdf->addInfo('Author', 'Edwin Ortiz Herazo · edwinortiz.net');
        $dompdf->addInfo('Subject', 'Instrucciones de IA alineadas con el currículo colombiano: ' . $kit['name']);
        $dompdf->render();

        // Pie en todas las páginas menos la portada: materia y licencia a la izquierda, número a la derecha.
        $canvas = $dompdf->getCanvas();
        $metrics = $dompdf->getFontMetrics();
        $font = $metrics->getFont('DejaVu Sans');
        $bold = $metrics->getFont('DejaVu Sans', 'bold');
        $w = $canvas->get_width();
        $h = $canvas->get_height();
        $left = 'Kit de IA para docentes · ' . $kit['name'] . '   ·   Licencia de uso personal — edwinortiz.net';
        $canvas->page_script(static function (int $page, int $count, $canvas) use ($w, $h, $font, $bold, $left, $metrics): void {
            if ($page === 1) {
                return;
            }
            $canvas->line(50, $h - 40, $w - 50, $h - 40, [0.82, 0.85, 0.9], 0.6);
            $canvas->text(50, $h - 33, $left, $font, 7, [0.42, 0.46, 0.52]);
            $label = "$page / $count";
            $canvas->text($w - 50 - $metrics->getTextWidth($label, $bold, 7.5), $h - 33.5, $label, $bold, 7.5, [0.25, 0.29, 0.36]);
        });
        return (string) $dompdf->output();
    }

    /** Todas las instrucciones en texto plano (UTF-8 con BOM y saltos CRLF para el Bloc de notas). */
    public static function promptsTxt(array $kit, array $common): string
    {
        $rule = str_repeat('=', 72);
        $thin = str_repeat('-', 72);
        $lines = [
            $rule,
            'KIT DE IA PARA DOCENTES — ' . mb_strtoupper($kit['name']),
            'Instrucciones listas para copiar · ' . self::EDITION . ' · edwinortiz.net',
            'Licencia de uso personal. No se permite redistribuir ni revender este archivo.',
            $rule,
            '',
            'Cómo usar este archivo: busca el código de la receta (por ejemplo, ' . ($kit['recetas'][0]['id'] ?? 'MAT-01') . '),',
            'copia desde «INSTRUCCIÓN» hasta antes de «SEGUIMIENTOS», reemplaza las variables entre corchetes',
            'y pégalo en tu asistente de IA. Nunca escribas datos personales de estudiantes.',
            '',
        ];
        foreach (self::grouped($kit) as $cat => $recipes) {
            $lines[] = $rule;
            $lines[] = mb_strtoupper(self::CATEGORIES[$cat]);
            $lines[] = $rule;
            $lines[] = '';
            foreach ($recipes as $r) {
                $lines[] = $thin;
                $lines[] = "{$r['id']} · {$r['titulo']}";
                $lines[] = "Grados: {$r['grados']} · Tiempo ahorrado: {$r['tiempo_ahorrado']}";
                $lines[] = $thin;
                if (!empty($r['variables'])) {
                    $lines[] = 'VARIABLES';
                    foreach ($r['variables'] as $var => $help) {
                        $lines[] = "  $var: $help";
                    }
                    $lines[] = '';
                }
                $lines[] = 'INSTRUCCIÓN';
                $lines[] = trim((string) $r['prompt']);
                $lines[] = '';
                if (!empty($r['seguimientos'])) {
                    $lines[] = 'SEGUIMIENTOS';
                    foreach (array_values($r['seguimientos']) as $i => $s) {
                        $lines[] = ($i + 1) . '. ' . trim((string) $s);
                    }
                    $lines[] = '';
                }
            }
        }
        $lines[] = $rule;
        $lines[] = 'INSTRUCCIONES DE DUA Y AJUSTES RAZONABLES (todas las materias)';
        $lines[] = $rule;
        $lines[] = '';
        foreach (self::duaPrompts($common) as $i => $p) {
            $lines[] = $thin;
            $lines[] = 'DUA-' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) . ' · ' . $p['titulo'];
            $lines[] = $thin;
            $lines[] = trim($p['prompt']);
            $lines[] = '';
        }
        $lines[] = $rule;
        $lines[] = 'PLANTILLA MAESTRA (para crear tus propias instrucciones)';
        $lines[] = $rule;
        $lines[] = trim((string) $common['plantilla_maestra']);
        $lines[] = '';
        $text = implode("\n", $lines);
        $text = (string) preg_replace("/\r\n|\r/", "\n", $text);
        return "\xEF\xBB\xBF" . str_replace("\n", "\r\n", $text);
    }

    public static function leeme(array $kit): string
    {
        $text = "KIT DE IA PARA DOCENTES — " . mb_strtoupper($kit['name']) . "\n" . self::EDITION . " · Edwin Ortiz Herazo · edwinortiz.net\n\n"
            . "Contenido:\n"
            . "1. Kit de IA para docentes - {$kit['name']}.pdf: la guía completa, lista para imprimir (tamaño carta).\n"
            . "2. Prompts - {$kit['name']}.txt: todas las instrucciones en texto plano para copiar y pegar sin errores.\n\n"
            . "Empieza por el capítulo «Cómo usar el kit» del PDF.\n\n"
            . "Licencia de uso personal: puedes usar, imprimir y adaptar este material en tus clases. No está permitido\n"
            . "redistribuirlo, publicarlo ni revenderlo. Si quieres licencias para tu institución, escribe a través de\n"
            . "https://www.edwinortiz.net/contacto/\n";
        return "\xEF\xBB\xBF" . str_replace("\n", "\r\n", $text);
    }

    public static function zipName(string $key): string
    {
        return "kit-ia-docentes-$key.zip";
    }

    public static function relativePath(string $key): string
    {
        return self::SLUG . '/' . self::zipName($key);
    }

    /**
     * Genera el PDF, el TXT y el ZIP de una materia y lo registra como archivo del producto.
     * @return array{zip:string, pdf_bytes:int, zip_bytes:int, pdf:string, disk:string}
     */
    public static function build(string $key, bool $keepPdf = false): array
    {
        $kit = self::load($key);
        if ($kit === null) {
            throw new \RuntimeException("No existe el contenido de «{$key}»");
        }
        $problems = self::validate($kit);
        if ($problems !== []) {
            throw new \RuntimeException("Contenido de «{$key}» con problemas: " . implode('; ', array_slice($problems, 0, 8)));
        }
        $common = self::common();
        $pdf = self::pdf($kit, $common);
        $dir = DownloadService::path(self::SLUG);
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $pdfPath = "$dir/kit-ia-docentes-$key.pdf";
        if ($keepPdf) {
            file_put_contents($pdfPath, $pdf);
        }
        $zip = (new ZipWriter())
            ->add("Kit de IA para docentes - {$kit['name']}.pdf", $pdf)
            ->add("Prompts - {$kit['name']}.txt", self::promptsTxt($kit, $common))
            ->add('LEEME.txt', self::leeme($kit));
        $relative = self::relativePath($key);
        $zipPath = DownloadService::path($relative);
        $bytes = $zip->save($zipPath);
        $disk = 'local';
        if (S3::enabled()) {
            // Producción: objeto privado en el bucket, igual que los archivos subidos desde el panel.
            S3::put(DownloadService::S3_PREFIX . $relative, $zipPath, 'application/zip', false);
            $disk = 's3';
        }
        self::register($key, (string) $kit['name'], $relative, $bytes, $disk);
        return ['zip' => $zipPath, 'pdf' => $pdfPath, 'pdf_bytes' => strlen($pdf), 'zip_bytes' => $bytes, 'disk' => $disk];
    }

    public static function productId(): ?int
    {
        $id = DB::value('SELECT id FROM products WHERE sku = :s', ['s' => self::SKU]);
        return $id !== null ? (int) $id : null;
    }

    /** Crea o actualiza (por producto + variante) el archivo descargable de la materia. Idempotente. */
    public static function register(string $key, string $label, string $relative, int $bytes, string $disk): void
    {
        $productId = self::productId();
        if ($productId === null) {
            throw new \RuntimeException('No existe el producto ' . self::SKU . ' (ejecuta php bin/console seed 02_shop)');
        }
        $data = [
            'label' => mb_substr($label, 0, 190),
            'storage_path' => $relative,
            'storage_disk' => $disk,
            'bytes' => $bytes,
            'version' => date('Y.m.d'),
        ];
        $existing = DB::value('SELECT id FROM product_files WHERE product_id = :p AND variant = :v ORDER BY id LIMIT 1', ['p' => $productId, 'v' => $key]);
        if ($existing !== null) {
            DB::update('product_files', $data, ['id' => (int) $existing]);
        } else {
            DB::insert('product_files', $data + ['product_id' => $productId, 'variant' => $key]);
        }
    }

    /** Materias cuyo ZIP está registrado y disponible (en S3 o en el servidor). */
    public static function ready(): array
    {
        $productId = self::productId();
        if ($productId === null) {
            return [];
        }
        $ready = [];
        foreach (DB::all('SELECT variant, storage_path, storage_disk FROM product_files WHERE product_id = :p AND variant IS NOT NULL', ['p' => $productId]) as $f) {
            if (!in_array($f['variant'], self::SUBJECTS, true) || empty($f['storage_path'])) {
                continue;
            }
            if ($f['storage_disk'] === 's3' || is_file(DownloadService::path((string) $f['storage_path']))) {
                $ready[] = $f['variant'];
            }
        }
        return array_values(array_intersect(self::SUBJECTS, $ready));
    }

    /** Activa el producto solo cuando las seis materias están listas; si no, queda «Disponible pronto». */
    public static function syncStatus(): string
    {
        $productId = self::productId();
        if ($productId === null) {
            return 'sin producto';
        }
        $ready = self::ready();
        $status = count($ready) === count(self::SUBJECTS) ? 'active' : 'coming_soon';
        $current = DB::value('SELECT status FROM products WHERE id = :id', ['id' => $productId]);
        if ($current !== 'hidden' && $current !== $status) {
            DB::update('products', ['status' => $status], ['id' => $productId]);
            Logger::info('Kit de IA para docentes: estado actualizado', ['status' => $status, 'ready' => $ready]);
        }
        return $status . ' (' . count($ready) . '/' . count(self::SUBJECTS) . ' materias: ' . ($ready ? implode(', ', $ready) : 'ninguna') . ')';
    }
}
