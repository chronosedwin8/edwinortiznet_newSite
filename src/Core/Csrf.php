<?php

declare(strict_types=1);

namespace App\Core;

/**
 * CSRF con cookie de doble envío firmada (sin estado en servidor).
 * Las plantillas imprimen un marcador que se sustituye al enviar la respuesta,
 * así las páginas pueden guardarse en la caché de página completa.
 */
final class Csrf
{
    public const COOKIE = 'eo_csrf';
    public const FIELD = '_csrf';
    public const PLACEHOLDER = '__EO_CSRF_TOKEN__';

    private static ?string $token = null;
    private static bool $mustSetCookie = false;

    public static function reset(): void
    {
        self::$token = null;
        self::$mustSetCookie = false;
    }

    private static function sign(string $random): string
    {
        return hash_hmac('sha256', 'csrf|' . $random, (string) Config::get('APP_KEY', 'dev-key'));
    }

    public static function isValidToken(?string $token): bool
    {
        if (!is_string($token) || !preg_match('/^([a-f0-9]{32})\.([a-f0-9]{64})$/', $token, $m)) {
            return false;
        }
        return hash_equals(self::sign($m[1]), $m[2]);
    }

    public static function token(Request $request): string
    {
        if (self::$token !== null) {
            return self::$token;
        }
        $cookie = $request->cookie(self::COOKIE);
        if (self::isValidToken($cookie)) {
            self::$token = $cookie;
        } else {
            $random = bin2hex(random_bytes(16));
            self::$token = $random . '.' . self::sign($random);
            self::$mustSetCookie = true;
        }
        return self::$token;
    }

    public static function field(): string
    {
        return '<input type="hidden" name="' . self::FIELD . '" value="' . self::PLACEHOLDER . '">';
    }

    public static function check(Request $request): bool
    {
        $cookie = $request->cookie(self::COOKIE);
        $sent = $request->post[self::FIELD] ?? $request->header('X-CSRF-Token');
        return is_string($sent)
            && self::isValidToken($cookie)
            && hash_equals((string) $cookie, $sent);
    }

    /** Sustituye el marcador y fija la cookie cuando hace falta. */
    public static function apply(Request $request, Response $response): void
    {
        if (!str_contains($response->body, self::PLACEHOLDER)) {
            return;
        }
        $token = self::token($request);
        $response->body = str_replace(self::PLACEHOLDER, $token, $response->body);
        if (self::$mustSetCookie) {
            $response->headers['Set-Cookie'][] = Session::cookieHeader(self::COOKIE, $token, 0, $request->isSecure(), false);
        }
    }
}
