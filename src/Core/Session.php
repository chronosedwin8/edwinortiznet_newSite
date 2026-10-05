<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Sesión PHP perezosa (solo panel y mi cuenta). Cookies HttpOnly, Secure (en HTTPS) y SameSite=Lax.
 */
final class Session
{
    public const NAME = 'eo_sess';
    private static bool $testing = false;
    private static array $fake = [];

    public static function fake(): void
    {
        self::$testing = true;
        self::$fake = [];
    }

    public static function start(?Request $request = null): void
    {
        if (self::$testing || session_status() === PHP_SESSION_ACTIVE) {
            return;
        }
        $secure = $request?->isSecure() ?? false;
        session_name(self::NAME);
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        ini_set('session.use_strict_mode', '1');
        ini_set('session.use_only_cookies', '1');
        ini_set('session.gc_maxlifetime', '14400');
        session_save_path(Config::storage('cache/sessions'));
        if (!is_dir(Config::storage('cache/sessions'))) {
            mkdir(Config::storage('cache/sessions'), 0770, true);
        }
        session_start();
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return self::$testing ? (self::$fake[$key] ?? $default) : ($_SESSION[$key] ?? $default);
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        if (self::$testing) {
            self::$fake[$key] = $value;
            return;
        }
        $_SESSION[$key] = $value;
    }

    public static function forget(string $key): void
    {
        self::start();
        if (self::$testing) {
            unset(self::$fake[$key]);
            return;
        }
        unset($_SESSION[$key]);
    }

    public static function regenerate(): void
    {
        if (!self::$testing && session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    public static function destroy(): void
    {
        if (self::$testing) {
            self::$fake = [];
            return;
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            $_SESSION = [];
            session_destroy();
        }
    }

    public static function flash(string $key, ?string $message = null): ?string
    {
        if ($message !== null) {
            self::set('_flash_' . $key, $message);
            return null;
        }
        $value = self::get('_flash_' . $key);
        if ($value !== null) {
            self::forget('_flash_' . $key);
        }
        return $value;
    }

    public static function cookieHeader(string $name, string $value, int $maxAge, bool $secure, bool $httpOnly = true): string
    {
        $parts = [rawurlencode($name) . '=' . rawurlencode($value), 'Path=/', 'SameSite=Lax'];
        if ($maxAge > 0) {
            $parts[] = 'Max-Age=' . $maxAge;
        } elseif ($maxAge < 0) {
            $parts[] = 'Max-Age=0';
        }
        if ($secure) {
            $parts[] = 'Secure';
        }
        if ($httpOnly) {
            $parts[] = 'HttpOnly';
        }
        return implode('; ', $parts);
    }
}
