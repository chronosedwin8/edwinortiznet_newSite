<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

/**
 * Ajustes clave/valor editables en el panel.
 */
final class Setting
{
    private static ?array $cache = null;

    public static function all(): array
    {
        if (self::$cache === null) {
            try {
                self::$cache = [];
                foreach (DB::all('SELECT `key`, `value` FROM settings') as $row) {
                    self::$cache[$row['key']] = $row['value'];
                }
            } catch (\Throwable) {
                self::$cache = [];
            }
        }
        return self::$cache;
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = self::all()[$key] ?? null;
        return ($value === null || $value === '') ? $default : $value;
    }

    public static function set(string $key, ?string $value): void
    {
        DB::run(
            'INSERT INTO settings (`key`, `value`) VALUES (:k, :v) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)',
            ['k' => $key, 'v' => $value]
        );
        self::$cache = null;
    }

    public static function clear(): void
    {
        self::$cache = null;
    }
}
