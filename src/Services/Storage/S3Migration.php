<?php

declare(strict_types=1);

namespace App\Services\Storage;

use App\Core\Cache;
use App\Core\Config;
use App\Core\DB;
use App\Services\Downloads\DownloadService;
use App\Services\Media\MediaLibrary;
use RuntimeException;

/**
 * Mueve a S3 los archivos que todavía están en el servidor y deja el disco limpio:
 * - archivos de producto (storage/downloads) → objetos privados en descargas/…
 * - imágenes de la biblioteca (public/uploads) → objetos públicos en uploads/…
 * - imágenes rescatadas de WordPress (public/wp-content/uploads) → objetos públicos en wp-content/uploads/…
 * Cada archivo se borra del servidor solo después de comprobar en S3 que llegó completo.
 */
final class S3Migration
{
    /** Columnas con HTML o URLs donde pueden aparecer las rutas antiguas. */
    private const REFERENCES = [
        'posts' => ['content_html', 'cover_url', 'cover_srcset', 'notice_html'],
        'products' => ['cover_url', 'cover_srcset'],
        'product_images' => ['url'],
        'product_translations' => ['short_html', 'description_html', 'includes_html'],
        'product_family_translations' => ['description_html'],
        'hub_translations' => ['intro_html'],
    ];

    /** @param callable(string): void $out */
    public function __construct(private $out)
    {
        if (!S3::configured()) {
            throw new RuntimeException('Faltan AWS_S3_BUCKET, AWS_S3_KEY o AWS_S3_SECRET en el .env.');
        }
    }

    /** @return array{downloads:int, media:int, wordpress:int, references:int} */
    public function run(): array
    {
        $summary = ['downloads' => $this->downloads(), 'media' => 0, 'wordpress' => 0, 'references' => 0];
        [$summary['media'], $refs1] = $this->media();
        [$summary['wordpress'], $refs2] = $this->wordpressFiles();
        $summary['references'] = $refs1 + $refs2;
        Cache::flushPages();
        return $summary;
    }

    private function downloads(): int
    {
        $moved = 0;
        $rows = DB::all('SELECT id, storage_path FROM product_files WHERE storage_disk = "local" AND storage_path IS NOT NULL AND storage_path <> ""');
        foreach ($rows as $row) {
            $local = DownloadService::path((string) $row['storage_path']);
            if (!is_file($local)) {
                ($this->out)("  ! sin archivo local: {$row['storage_path']}");
                continue;
            }
            $key = DownloadService::S3_PREFIX . $row['storage_path'];
            $this->upload($key, $local, 'application/octet-stream', false);
            DB::update('product_files', ['storage_disk' => 's3', 'bytes' => filesize($local)], ['id' => (int) $row['id']]);
            unlink($local);
            self::removeEmptyDirs(dirname($local), Config::storage('downloads'));
            ($this->out)("  producto → s3://…/$key");
            $moved++;
        }
        return $moved;
    }

    /** @return array{0:int, 1:int} archivos movidos, referencias actualizadas */
    private function media(): array
    {
        $moved = 0;
        $map = [];
        $root = MediaLibrary::root();
        foreach (DB::all('SELECT * FROM media WHERE path LIKE "/uploads/%"') as $row) {
            $variants = json_decode((string) $row['variants'], true) ?: [['path' => $row['path'], 'width' => (int) $row['width'], 'height' => (int) $row['height']]];
            foreach ($variants as &$v) {
                if (!str_starts_with($v['path'], '/uploads/')) {
                    continue;
                }
                $local = $root . $v['path'];
                if (!is_file($local)) {
                    throw new RuntimeException('Falta el archivo ' . $v['path']);
                }
                $key = ltrim($v['path'], '/');
                $this->upload($key, $local, 'image/webp', true);
                $map[$v['path']] = S3::publicUrl($key);
                $v['path'] = $map[$v['path']];
                $moved++;
            }
            unset($v);
            DB::update('media', ['path' => $map[$row['path']] ?? $row['path'], 'variants' => json_encode($variants)], ['id' => (int) $row['id']]);
            ($this->out)('  imagen → ' . ($map[$row['path']] ?? $row['path']));
        }
        $refs = $this->replaceReferences($map);
        foreach (array_keys($map) as $path) {
            @unlink($root . $path);
            self::removeEmptyDirs(dirname($root . $path), $root . '/uploads');
        }
        return [$moved, $refs];
    }

    /** @return array{0:int, 1:int} */
    private function wordpressFiles(): array
    {
        $dir = MediaLibrary::root() . '/wp-content/uploads';
        if (!is_dir($dir)) {
            return [0, 0];
        }
        $types = ['jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif', 'webp' => 'image/webp', 'mp4' => 'video/mp4', 'svg' => 'image/svg+xml', 'pdf' => 'application/pdf'];
        $map = [];
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS));
        foreach ($files as $file) {
            $path = '/' . ltrim(str_replace('\\', '/', substr($file->getPathname(), strlen(MediaLibrary::root()))), '/');
            $key = ltrim($path, '/');
            $type = $types[strtolower($file->getExtension())] ?? 'application/octet-stream';
            $this->upload($key, $file->getPathname(), $type, true);
            $url = S3::publicUrl($key);
            $map['https://www.edwinortiz.net' . $path] = $url;
            $map['http://www.edwinortiz.net' . $path] = $url;
            $map['https://edwinortiz.net' . $path] = $url;
            $map[$path] = $url;
            ($this->out)("  WordPress → $url");
        }
        $refs = $this->replaceReferences($map);
        foreach ($map as $path => $url) {
            if (str_starts_with($path, '/')) {
                @unlink(MediaLibrary::root() . $path);
            }
        }
        self::removeEmptyDirs($dir, MediaLibrary::root(), true);
        return [count(array_filter(array_keys($map), fn ($p) => str_starts_with($p, '/'))), $refs];
    }

    private function upload(string $key, string $file, string $type, bool $public): void
    {
        S3::put($key, $file, $type, $public, $public ? 'public, max-age=31536000, immutable' : null);
        $size = S3::size($key);
        if ($size !== filesize($file)) {
            throw new RuntimeException("Verificación fallida en S3 para $key ($size de " . filesize($file) . ' bytes); no se borró el archivo local.');
        }
    }

    /**
     * Reemplaza rutas antiguas por las URL de S3 en el contenido. Solo coincide cuando la ruta no va precedida
     * de un dominio (así una URL de S3 que ya contiene "/uploads/…" no se vuelve a reemplazar).
     * @param array<string, string> $map
     */
    private function replaceReferences(array $map): int
    {
        if ($map === []) {
            return 0;
        }
        uksort($map, fn ($a, $b) => strlen($b) <=> strlen($a));
        $patterns = [];
        foreach ($map as $old => $new) {
            $patterns['#(?<![\w.:/-])' . preg_quote($old, '#') . '(?![\w.-])#'] = $new;
        }
        $updated = 0;
        foreach (self::REFERENCES as $table => $columns) {
            $where = implode(' OR ', array_map(fn ($c) => "`$c` LIKE :like", $columns));
            foreach (array_keys($map) as $old) {
                foreach (DB::all("SELECT id, " . implode(', ', array_map(fn ($c) => "`$c`", $columns)) . " FROM `$table` WHERE $where", ['like' => '%' . $old . '%']) as $row) {
                    $changes = [];
                    foreach ($columns as $c) {
                        if ($row[$c] === null) {
                            continue;
                        }
                        $value = (string) $row[$c];
                        foreach ($patterns as $re => $new) {
                            $value = (string) preg_replace($re, $new, $value);
                        }
                        if ($value !== $row[$c]) {
                            $changes[$c] = $value;
                        }
                    }
                    if ($changes !== []) {
                        DB::update($table, $changes, ['id' => (int) $row['id']]);
                        $updated++;
                    }
                }
            }
        }
        return $updated;
    }

    private static function removeEmptyDirs(string $dir, string $stop, bool $includeStop = false): void
    {
        $dir = rtrim(str_replace('\\', '/', $dir), '/');
        $stop = rtrim(str_replace('\\', '/', $stop), '/');
        if ($includeStop && is_dir($dir)) {
            // Borra subcarpetas vacías de abajo hacia arriba
            $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
            foreach ($it as $f) {
                if ($f->isDir()) {
                    @rmdir($f->getPathname());
                }
            }
            @rmdir($dir);
            @rmdir(dirname($dir));
            return;
        }
        while ($dir !== $stop && str_starts_with($dir, $stop) && is_dir($dir) && count(scandir($dir)) === 2) {
            rmdir($dir);
            $dir = dirname($dir);
        }
    }
}
