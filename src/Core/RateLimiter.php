<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Límite de peticiones por clave (normalmente acción + IP) en ventanas fijas.
 */
final class RateLimiter
{
    private static bool $disabled = false;

    public static function disable(bool $disabled = true): void
    {
        self::$disabled = $disabled;
    }

    public static function hit(string $action, string $ip, int $max, int $windowSeconds): bool
    {
        if (self::$disabled) {
            return true;
        }
        $window = intdiv(time(), $windowSeconds) * $windowSeconds;
        $key = substr($action . ':' . hash('sha256', $ip), 0, 120);
        DB::run(
            'INSERT INTO rate_limits (rate_key, window_start, hits) VALUES (:k, :w, 1)
             ON DUPLICATE KEY UPDATE hits = hits + 1',
            ['k' => $key, 'w' => $window]
        );
        $hits = (int) DB::value('SELECT hits FROM rate_limits WHERE rate_key = :k AND window_start = :w', ['k' => $key, 'w' => $window]);
        if (random_int(1, 200) === 1) {
            DB::run('DELETE FROM rate_limits WHERE window_start < :old', ['old' => time() - 86400]);
        }
        return $hits <= $max;
    }
}
