<?php

declare(strict_types=1);

namespace App\Services\Media;

use App\Core\DB;
use App\Services\Importer\HtmlCleaner;
use RuntimeException;

/**
 * Biblioteca de imágenes del panel. Cada imagen subida se vuelve a codificar en WebP (lo que también
 * descarta metadatos y cualquier contenido que no sea imagen) en dos tamaños: hasta 1600 px y 800 px.
 * Se guardan en public/uploads/AAAA/MM/ y se registran en la tabla media.
 */
final class MediaLibrary
{
    public const MAX_BYTES = 12 * 1024 * 1024;
    public const MAX_PIXELS = 40_000_000;
    public const WIDTHS = [1600, 800];
    private const QUALITY = 82;
    private const TYPES = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP, IMAGETYPE_GIF];

    public static function root(): string
    {
        return dirname(__DIR__, 3) . '/public';
    }

    /**
     * @param array{name?:string, tmp_name?:string, error?:int, size?:int} $file
     * @return array<string, mixed> fila de media con srcset
     */
    public static function store(array $file, ?string $alt = null): array
    {
        if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || !is_file((string) ($file['tmp_name'] ?? ''))) {
            throw new RuntimeException('upload');
        }
        $tmp = (string) $file['tmp_name'];
        if (filesize($tmp) > self::MAX_BYTES) {
            throw new RuntimeException('size');
        }
        $info = @getimagesize($tmp);
        if ($info === false || !in_array($info[2], self::TYPES, true) || $info[0] < 1 || $info[1] < 1 || $info[0] * $info[1] > self::MAX_PIXELS) {
            throw new RuntimeException('type');
        }
        $image = @imagecreatefromstring((string) file_get_contents($tmp));
        if ($image === false) {
            throw new RuntimeException('type');
        }
        $image = self::orient($image, $tmp, $info[2]);
        if (!imageistruecolor($image)) {
            imagepalettetotruecolor($image);
        }
        imagealphablending($image, false);
        imagesavealpha($image, true);

        $original = (string) ($file['name'] ?? 'imagen');
        $base = HtmlCleaner::slugify(pathinfo($original, PATHINFO_FILENAME)) ?: 'imagen';
        $base = substr($base, 0, 70);
        $dir = '/uploads/' . gmdate('Y/m');
        if (!is_dir(self::root() . $dir) && !mkdir(self::root() . $dir, 0775, true) && !is_dir(self::root() . $dir)) {
            throw new RuntimeException('disk');
        }
        $name = $base;
        for ($i = 2; is_file(self::root() . "$dir/$name.webp"); $i++) {
            $name = "$base-$i";
        }

        $width = imagesx($image);
        $variants = [];
        $main = null;
        foreach (self::WIDTHS as $i => $max) {
            if ($i > 0 && $width <= $max) {
                continue;
            }
            $resized = self::resize($image, min($width, $max));
            $path = $i === 0 ? "$dir/$name.webp" : "$dir/$name-$max.webp";
            if (!imagewebp($resized, self::root() . $path, self::QUALITY)) {
                throw new RuntimeException('disk');
            }
            $variant = ['path' => $path, 'width' => imagesx($resized), 'height' => imagesy($resized), 'bytes' => (int) filesize(self::root() . $path)];
            $main ??= $variant;
            $variants[] = $variant;
        }

        $id = DB::insert('media', [
            'path' => $main['path'],
            'original_name' => mb_substr($original, 0, 255),
            'width' => $main['width'],
            'height' => $main['height'],
            'bytes' => $main['bytes'],
            'variants' => json_encode($variants),
            'alt' => $alt !== null && trim($alt) !== '' ? mb_substr(trim($alt), 0, 255) : null,
        ]);
        return self::find($id) ?? throw new RuntimeException('db');
    }

    public static function find(int $id): ?array
    {
        $row = DB::one('SELECT * FROM media WHERE id = :id', ['id' => $id]);
        return $row ? self::present($row) : null;
    }

    public static function byPath(string $path): ?array
    {
        $row = DB::one('SELECT * FROM media WHERE path = :p', ['p' => $path]);
        return $row ? self::present($row) : null;
    }

    /** @return array{items: array<int, array>, total: int} */
    public static function search(string $q = '', int $page = 1, int $perPage = 48): array
    {
        $where = '';
        $params = [];
        if ($q !== '') {
            $where = 'WHERE original_name LIKE :q OR alt LIKE :q2 OR path LIKE :q3';
            $params = ['q' => "%$q%", 'q2' => "%$q%", 'q3' => "%$q%"];
        }
        $total = (int) DB::value("SELECT COUNT(*) FROM media $where", $params);
        $offset = max(0, ($page - 1) * $perPage);
        $rows = DB::all("SELECT * FROM media $where ORDER BY id DESC LIMIT $perPage OFFSET $offset", $params);
        return ['items' => array_map(self::present(...), $rows), 'total' => $total];
    }

    /** Dónde se usa la imagen (artículos, productos y hubs). */
    public static function usage(array $media): int
    {
        $like = '%' . $media['path'] . '%';
        $stem = '%' . preg_replace('/\.webp$/', '', $media['path']) . '-%';
        return (int) DB::value('SELECT COUNT(*) FROM posts WHERE content_html LIKE :a OR cover_url LIKE :b OR content_html LIKE :c', ['a' => $like, 'b' => $like, 'c' => $stem])
            + (int) DB::value('SELECT COUNT(*) FROM products WHERE cover_url LIKE :a', ['a' => $like])
            + (int) DB::value('SELECT COUNT(*) FROM product_translations WHERE description_html LIKE :a', ['a' => $like])
            + (int) DB::value('SELECT COUNT(*) FROM hub_translations WHERE intro_html LIKE :a', ['a' => $like]);
    }

    public static function delete(int $id): void
    {
        $media = self::find($id);
        if ($media === null) {
            return;
        }
        foreach ($media['variants'] as $v) {
            $file = self::root() . $v['path'];
            if (str_starts_with($v['path'], '/uploads/') && is_file($file)) {
                unlink($file);
            }
        }
        DB::run('DELETE FROM media WHERE id = :id', ['id' => $id]);
    }

    private static function present(array $row): array
    {
        $variants = json_decode((string) $row['variants'], true) ?: [['path' => $row['path'], 'width' => (int) $row['width'], 'height' => (int) $row['height']]];
        usort($variants, fn ($a, $b) => $a['width'] <=> $b['width']);
        return [
            'id' => (int) $row['id'],
            'url' => $row['path'],
            'path' => $row['path'],
            'name' => (string) $row['original_name'],
            'alt' => (string) ($row['alt'] ?? ''),
            'width' => (int) $row['width'],
            'height' => (int) $row['height'],
            'bytes' => (int) $row['bytes'],
            'thumb' => $variants[0]['path'],
            'srcset' => count($variants) > 1 ? implode(', ', array_map(fn ($v) => "{$v['path']} {$v['width']}w", $variants)) : '',
            'variants' => $variants,
            'created_at' => (string) $row['created_at'],
        ];
    }

    private static function resize(\GdImage $image, int $width): \GdImage
    {
        $w = imagesx($image);
        if ($width >= $w) {
            return $image;
        }
        $height = max(1, (int) round(imagesy($image) * $width / $w));
        $out = imagecreatetruecolor($width, $height);
        imagealphablending($out, false);
        imagesavealpha($out, true);
        imagecopyresampled($out, $image, 0, 0, 0, 0, $width, $height, $w, imagesy($image));
        return $out;
    }

    /** Las fotos de celular traen la orientación en EXIF; al recodificar se perdería. */
    private static function orient(\GdImage $image, string $path, int $type): \GdImage
    {
        if ($type !== IMAGETYPE_JPEG || !function_exists('exif_read_data')) {
            return $image;
        }
        $exif = @exif_read_data($path);
        $angle = [3 => 180, 6 => -90, 8 => 90][(int) ($exif['Orientation'] ?? 1)] ?? 0;
        if ($angle === 0) {
            return $image;
        }
        $rotated = imagerotate($image, $angle, 0);
        return $rotated === false ? $image : $rotated;
    }
}
