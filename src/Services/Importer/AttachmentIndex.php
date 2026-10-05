<?php

declare(strict_types=1);

namespace App\Services\Importer;

/**
 * Índice de adjuntos del WXR: URL en S3, alt, tamaños y equivalencias de las URL locales
 * (www.edwinortiz.net/wp-content/uploads/…) con su copia en S3.
 */
final class AttachmentIndex
{
    /** @var array<int, array> */
    private array $byId = [];
    /** @var array<string, array{0:int,1:string}> "2020/09/archivo.png" => [id, tamaño] */
    private array $byPath = [];

    public function add(int $id, string $url, string $title, string $alt, ?string $attachedFile, ?string $metadata): void
    {
        $meta = [];
        if ($metadata !== null && $metadata !== '') {
            $decoded = @unserialize($metadata, ['allowed_classes' => false]);
            $meta = is_array($decoded) ? $decoded : [];
        }
        $dir = $attachedFile ? trim(dirname($attachedFile), './') : '';
        $s3Dir = substr($url, 0, (int) strrpos($url, '/'));
        $sizes = [];
        foreach (($meta['sizes'] ?? []) as $name => $size) {
            if (!is_array($size) || empty($size['file'])) {
                continue;
            }
            $sizes[$name] = [
                'file' => (string) $size['file'],
                'width' => (int) ($size['width'] ?? 0),
                'height' => (int) ($size['height'] ?? 0),
                'url' => $s3Dir . '/' . $size['file'],
            ];
        }
        $this->byId[$id] = [
            'id' => $id,
            'url' => $url,
            'title' => $title,
            'alt' => trim($alt),
            'width' => (int) ($meta['width'] ?? 0),
            'height' => (int) ($meta['height'] ?? 0),
            'sizes' => $sizes,
            's3_dir' => $s3Dir,
        ];
        $mainFile = basename($attachedFile ?: $url);
        if ($dir !== '') {
            $this->byPath["$dir/$mainFile"] = [$id, 'full'];
            if (!empty($meta['original_image'])) {
                $this->byPath["$dir/" . $meta['original_image']] = [$id, 'full'];
            }
            foreach ($sizes as $name => $size) {
                $this->byPath["$dir/{$size['file']}"] = [$id, $name];
            }
        }
        // También se indexa la URL de S3 completa (y sus tamaños) por su ruta relativa.
        $this->byPath[$this->s3Key($url)] = [$id, 'full'];
        foreach ($sizes as $name => $size) {
            $this->byPath[$this->s3Key($size['url'])] = [$id, $name];
        }
    }

    private function s3Key(string $url): string
    {
        return 's3:' . preg_replace('#^https?://#', '', $url);
    }

    public function get(int $id): ?array
    {
        return $this->byId[$id] ?? null;
    }

    public function count(): int
    {
        return count($this->byId);
    }

    /**
     * Resuelve una URL de imagen (local de WordPress o de S3).
     * @return array{attachment: array, size: string, url: string, width: int, height: int}|null
     */
    public function resolve(string $src): ?array
    {
        $src = html_entity_decode(trim($src), ENT_QUOTES);
        $hit = null;
        if (preg_match('#^(?:https?:)?//(?:www\.)?edwinortiz\.net/wp-content/uploads/(.+)$#i', $src, $m)) {
            $path = rawurldecode(preg_replace('#[?\#].*$#', '', $m[1]) ?? $m[1]);
            $hit = $this->byPath[$path] ?? null;
        } elseif (str_contains($src, 's3.amazonaws.com')) {
            $hit = $this->byPath[$this->s3Key(preg_replace('#[?\#].*$#', '', $src) ?? $src)] ?? null;
        }
        if ($hit === null) {
            return null;
        }
        [$id, $size] = $hit;
        $att = $this->byId[$id];
        if ($size === 'full' || !isset($att['sizes'][$size])) {
            return ['attachment' => $att, 'size' => 'full', 'url' => $att['url'], 'width' => $att['width'], 'height' => $att['height']];
        }
        $s = $att['sizes'][$size];
        return ['attachment' => $att, 'size' => $size, 'url' => $s['url'], 'width' => $s['width'], 'height' => $s['height']];
    }

    /** srcset con los tamaños que conservan la proporción del original. */
    public function srcset(array $att, int $maxWidth): ?string
    {
        if ($att['width'] <= 0 || $att['height'] <= 0 || $att['sizes'] === []) {
            return null;
        }
        $ratio = $att['width'] / $att['height'];
        $candidates = [$att['width'] => $att['url']];
        foreach ($att['sizes'] as $size) {
            if ($size['width'] <= 0 || $size['height'] <= 0) {
                continue;
            }
            if (abs(($size['width'] / $size['height']) - $ratio) / $ratio > 0.03) {
                continue;
            }
            $candidates[$size['width']] = $size['url'];
        }
        ksort($candidates);
        $candidates = array_filter($candidates, fn ($w) => $w <= max($maxWidth, 300) * 2, ARRAY_FILTER_USE_KEY);
        if (count($candidates) < 2) {
            return null;
        }
        $parts = [];
        foreach ($candidates as $w => $url) {
            $parts[] = str_replace(' ', '%20', $url) . " {$w}w";
        }
        return implode(', ', $parts);
    }
}
