<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Caché en disco: página completa (HTML) y valores (serializados).
 */
final class Cache
{
    private static function pageDir(): string
    {
        return Config::storage('cache/pages');
    }

    private static function dataDir(): string
    {
        return Config::storage('cache/data');
    }

    public static function pageKey(Request $request): string
    {
        $query = $request->query;
        ksort($query);
        return sha1($request->path . '?' . http_build_query($query));
    }

    public static function pageEnabled(): bool
    {
        return Config::bool('PAGE_CACHE', true);
    }

    public static function getPage(Request $request): ?Response
    {
        if (!self::pageEnabled()) {
            return null;
        }
        $file = self::pageDir() . '/' . self::pageKey($request) . '.html';
        if (!is_file($file) || filemtime($file) < time() - Config::int('PAGE_CACHE_TTL', 3600)) {
            return null;
        }
        $raw = (string) file_get_contents($file);
        $pos = strpos($raw, "\n");
        if ($pos === false) {
            return null;
        }
        $meta = json_decode(substr($raw, 0, $pos), true);
        if (!is_array($meta)) {
            return null;
        }
        $response = new Response(substr($raw, $pos + 1), (int) $meta['status'], (array) $meta['headers']);
        $response->headers['X-Cache'] = 'HIT';
        return $response;
    }

    public static function putPage(Request $request, Response $response): void
    {
        if (!self::pageEnabled()) {
            return;
        }
        $dir = self::pageDir();
        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }
        $headers = array_filter(
            $response->headers,
            fn ($k) => in_array($k, ['Content-Type', 'Content-Language', 'Link', 'X-Robots-Tag'], true),
            ARRAY_FILTER_USE_KEY
        );
        $meta = json_encode(['status' => $response->status, 'headers' => $headers, 'path' => $request->path]);
        $tmp = $dir . '/' . uniqid('tmp', true);
        file_put_contents($tmp, $meta . "\n" . $response->body);
        rename($tmp, $dir . '/' . self::pageKey($request) . '.html');
    }

    /** Se llama al guardar en el panel. */
    public static function flushPages(): int
    {
        $count = 0;
        foreach (glob(self::pageDir() . '/*.html') ?: [] as $file) {
            @unlink($file);
            $count++;
        }
        @unlink(Config::storage('cache/sitemap.xml'));
        return $count;
    }

    public static function remember(string $key, int $ttl, callable $fn): mixed
    {
        $file = self::dataDir() . '/' . sha1($key) . '.cache';
        if (is_file($file) && filemtime($file) >= time() - $ttl) {
            $data = @unserialize((string) file_get_contents($file));
            if ($data !== false) {
                return $data;
            }
        }
        $value = $fn();
        self::put($key, $value);
        return $value;
    }

    public static function get(string $key, int $ttl): mixed
    {
        $file = self::dataDir() . '/' . sha1($key) . '.cache';
        if (is_file($file) && filemtime($file) >= time() - $ttl) {
            $data = @unserialize((string) file_get_contents($file));
            return $data === false ? null : $data;
        }
        return null;
    }

    public static function put(string $key, mixed $value): void
    {
        if (!is_dir(self::dataDir())) {
            mkdir(self::dataDir(), 0775, true);
        }
        $file = self::dataDir() . '/' . sha1($key) . '.cache';
        $tmp = $file . '.' . uniqid('', true);
        file_put_contents($tmp, serialize($value));
        rename($tmp, $file);
    }

    public static function forget(string $key): void
    {
        @unlink(self::dataDir() . '/' . sha1($key) . '.cache');
    }
}
