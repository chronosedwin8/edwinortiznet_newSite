<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Acceso tipado a la configuración (.env + valores derivados).
 */
final class Config
{
    private static array $values = [];
    private static string $root = '';

    public static function load(string $root): void
    {
        self::$root = $root;
        if (is_file($root . '/.env')) {
            $dotenv = \Dotenv\Dotenv::createImmutable($root);
            $dotenv->safeLoad();
        }
        self::$values = array_merge($_SERVER, $_ENV);
    }

    /** Permite a las pruebas fijar valores sin .env. */
    public static function set(string $key, mixed $value): void
    {
        self::$values[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $value = self::$values[$key] ?? getenv($key);
        if ($value === false || $value === null || $value === '') {
            return $default;
        }
        return $value;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $value = self::get($key);
        if ($value === null) {
            return $default;
        }
        return in_array(strtolower((string) $value), ['1', 'true', 'yes', 'on'], true);
    }

    public static function int(string $key, int $default = 0): int
    {
        $value = self::get($key);
        return $value === null ? $default : (int) $value;
    }

    public static function root(string $path = ''): string
    {
        return rtrim(self::$root, '/\\') . ($path !== '' ? '/' . ltrim($path, '/') : '');
    }

    public static function storage(string $path = ''): string
    {
        return self::root('storage' . ($path !== '' ? '/' . ltrim($path, '/') : ''));
    }

    public static function appUrl(): string
    {
        return rtrim((string) self::get('APP_URL', 'http://localhost'), '/');
    }

    public static function debug(): bool
    {
        return self::bool('APP_DEBUG');
    }

    public static function isProduction(): bool
    {
        return self::get('APP_ENV', 'production') === 'production';
    }
}
