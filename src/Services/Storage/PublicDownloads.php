<?php

declare(strict_types=1);

namespace App\Services\Storage;

use App\Core\Config;
use RuntimeException;

/**
 * Archivos gratuitos de los artículos y herramientas (libros de Excel, scripts, ZIP de módulos VBA).
 *
 * No viven en el servidor: están en S3 bajo recursos/ con lectura pública y el sitio los enlaza como
 * /descargas/<ruta>, que redirige al objeto. resources/descargas.json (en el repositorio) es el inventario:
 * ruta => tamaño y sha256. En desarrollo, sin S3, se sirven desde storage/descargas/.
 *
 * Flujo: el generador escribe en storage/descargas/ → `downloads:manifest` actualiza el inventario →
 * commit → en el servidor, `downloads:publish <carpeta>` sube lo nuevo o cambiado y verifica.
 */
final class PublicDownloads
{
    public const PREFIX = 'recursos/';
    public const MANIFEST = 'resources/descargas.json';
    public const LOCAL_DIR = 'storage/descargas';

    private const TYPES = [
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
        'csv' => 'text/csv; charset=utf-8',
        'txt' => 'text/plain; charset=utf-8',
        'md' => 'text/markdown; charset=utf-8',
        'json' => 'application/json',
        'py' => 'text/x-python; charset=utf-8',
        'ps1' => 'text/plain; charset=utf-8',
        'bas' => 'text/plain; charset=utf-8',
        'html' => 'text/html; charset=utf-8',
    ];

    /** @var array<string, array{size:int, sha256:string}>|null */
    private static ?array $manifest = null;

    /** @return array<string, array{size:int, sha256:string}> */
    public static function manifest(): array
    {
        if (self::$manifest === null) {
            $file = Config::root(self::MANIFEST);
            $data = is_file($file) ? json_decode((string) file_get_contents($file), true) : [];
            self::$manifest = is_array($data) ? $data : [];
        }
        return self::$manifest;
    }

    /** Pruebas: sustituye el inventario (null vuelve a leer el archivo). */
    public static function setManifest(?array $manifest): void
    {
        self::$manifest = $manifest;
    }

    /** Ruta relativa válida (sin .., sin barras iniciales ni ocultos) con una extensión permitida, o null. */
    public static function normalize(string $path): ?string
    {
        $path = rawurldecode($path);
        if (!preg_match('#^[A-Za-z0-9][A-Za-z0-9._\-]*(/[A-Za-z0-9][A-Za-z0-9._\-]*)*$#', $path) || str_contains($path, '..')) {
            return null;
        }
        return isset(self::TYPES[self::extension($path)]) ? $path : null;
    }

    public static function contentType(string $path): string
    {
        return self::TYPES[self::extension($path)] ?? 'application/octet-stream';
    }

    /** Tamaño en bytes (inventario o, en desarrollo, archivo local), o null si no existe. */
    public static function size(string $path): ?int
    {
        $entry = self::manifest()[$path] ?? null;
        if ($entry !== null) {
            return (int) $entry['size'];
        }
        $local = self::localFile($path);
        return $local !== null ? (int) filesize($local) : null;
    }

    /** URL pública en S3 si el archivo está publicado y hay bucket configurado. */
    public static function remoteUrl(string $path): ?string
    {
        return isset(self::manifest()[$path]) && S3::configured() ? S3::publicUrl(self::PREFIX . $path) : null;
    }

    public static function localFile(string $path): ?string
    {
        if (self::normalize($path) === null) {
            return null;
        }
        $file = Config::root(self::LOCAL_DIR . '/' . $path);
        return is_file($file) ? $file : null;
    }

    /**
     * Inventario de una carpeta: ruta relativa => tamaño y sha256. Ignora lo que no se publica
     * (cachés de Python, ocultos, extensiones no permitidas).
     *
     * @return array<string, array{size:int, sha256:string}>
     */
    public static function scan(string $dir): array
    {
        $dir = rtrim(str_replace('\\', '/', $dir), '/');
        if (!is_dir($dir)) {
            throw new RuntimeException("No existe la carpeta $dir");
        }
        $out = [];
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS));
        foreach ($it as $file) {
            /** @var \SplFileInfo $file */
            if (!$file->isFile()) {
                continue;
            }
            $rel = substr(str_replace('\\', '/', $file->getPathname()), strlen($dir) + 1);
            if (self::normalize($rel) === null) {
                continue;
            }
            $out[$rel] = ['size' => (int) $file->getSize(), 'sha256' => hash_file('sha256', $file->getPathname())];
        }
        ksort($out, SORT_STRING);
        return $out;
    }

    /** Escribe el inventario de la carpeta en resources/descargas.json. Devuelve [añadidos, cambiados, quitados]. */
    public static function writeManifest(string $dir): array
    {
        $old = self::manifest();
        $new = self::scan($dir);
        $added = array_keys(array_diff_key($new, $old));
        $removed = array_keys(array_diff_key($old, $new));
        $changed = [];
        foreach (array_intersect_key($new, $old) as $path => $entry) {
            if ($entry['sha256'] !== $old[$path]['sha256']) {
                $changed[] = $path;
            }
        }
        file_put_contents(
            Config::root(self::MANIFEST),
            json_encode($new, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n"
        );
        self::$manifest = $new;
        return [$added, $changed, $removed];
    }

    /**
     * Sube a S3 los archivos del inventario que falten o hayan cambiado (compara el sha256 guardado como metadato)
     * y verifica cada objeto. $dir = null solo verifica. Devuelve ['uploaded' => [], 'ok' => [], 'missing' => []].
     *
     * @param callable(string): void $log
     */
    public static function publish(?string $dir, callable $log): array
    {
        if (!S3::configured()) {
            throw new RuntimeException('S3 no está configurado (AWS_S3_BUCKET, AWS_S3_KEY, AWS_S3_SECRET).');
        }
        $dir = $dir !== null ? rtrim(str_replace('\\', '/', $dir), '/') : null;
        $result = ['uploaded' => [], 'ok' => [], 'missing' => []];
        foreach (self::manifest() as $path => $entry) {
            $key = self::PREFIX . $path;
            $head = S3::head($key);
            if ($head !== null && ($head['x-amz-meta-sha256'] ?? '') === $entry['sha256']) {
                $result['ok'][] = $path;
                continue;
            }
            $file = $dir !== null ? $dir . '/' . $path : null;
            if ($file === null || !is_file($file)) {
                $result['missing'][] = $path;
                $log('  FALTA      ' . $path . ($head !== null ? ' (en S3 hay otra versión)' : ''));
                continue;
            }
            if (hash_file('sha256', $file) !== $entry['sha256']) {
                $result['missing'][] = $path;
                $log('  DISTINTO   ' . $path . ' (el archivo local no coincide con el inventario)');
                continue;
            }
            S3::put($key, $file, self::contentType($path), true, 'public, max-age=86400', [
                'content-disposition' => 'attachment; filename="' . basename($path) . '"',
                'x-amz-meta-sha256' => $entry['sha256'],
            ]);
            $check = S3::head($key);
            if ($check === null || (int) ($check['content-length'] ?? -1) !== $entry['size']) {
                $result['missing'][] = $path;
                $log('  ERROR      ' . $path . ' (no se pudo verificar después de subirlo)');
                continue;
            }
            $result['uploaded'][] = $path;
            $log('  SUBIDO     ' . $path);
        }
        return $result;
    }

    /**
     * Enlaces /descargas/... de un texto que no están en el inventario (para detectar archivos perdidos).
     *
     * @return string[]
     */
    public static function brokenLinks(string $html): array
    {
        preg_match_all('#(?:["\'(=]|edwinortiz\.net)/descargas/([A-Za-z0-9][A-Za-z0-9._/\-]*[A-Za-z0-9])#', $html, $m);
        $broken = [];
        foreach (array_unique($m[1]) as $path) {
            if (!isset(self::manifest()[$path])) {
                $broken[] = $path;
            }
        }
        return $broken;
    }

    private static function extension(string $path): string
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }
}
