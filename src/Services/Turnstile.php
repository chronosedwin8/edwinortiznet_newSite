<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;
use App\Core\CurlHttpClient;
use App\Core\HttpClient;
use App\Core\Logger;
use App\Core\Request;

/**
 * Cloudflare Turnstile (alternativa gratuita y sin rompecabezas a reCAPTCHA) en los formularios públicos que
 * envían correos: suscripción, contacto, lista de espera y acceso a PIAR y exámenes.
 *
 * Solo se activa si TURNSTILE_SITE_KEY y TURNSTILE_SECRET están en .env; sin ellas todo funciona como antes
 * (honeypot + marca de tiempo + límites por IP). La CSP permite challenges.cloudflare.com solo cuando está activo.
 */
final class Turnstile
{
    public const SCRIPT = 'https://challenges.cloudflare.com/turnstile/v0/api.js';
    private const VERIFY = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';

    private static ?HttpClient $http = null;

    public static function enabled(): bool
    {
        return self::siteKey() !== '' && (string) Config::get('TURNSTILE_SECRET', '') !== '';
    }

    public static function siteKey(): string
    {
        $key = (string) Config::get('TURNSTILE_SITE_KEY', '');
        return preg_match('/^[A-Za-z0-9_\-]{10,100}$/', $key) ? $key : '';
    }

    /** Pruebas: sustituye la red. */
    public static function http(?HttpClient $client): void
    {
        self::$http = $client;
    }

    /** true si Turnstile está apagado o si el token del formulario es válido. */
    public static function passes(Request $request): bool
    {
        if (!self::enabled()) {
            return true;
        }
        $token = $request->post['cf-turnstile-response'] ?? '';
        if (!is_string($token) || $token === '' || strlen($token) > 2048) {
            return false;
        }
        $res = (self::$http ?? new CurlHttpClient(8))->request('POST', self::VERIFY, ['Content-Type' => 'application/x-www-form-urlencoded'], http_build_query([
            'secret' => (string) Config::get('TURNSTILE_SECRET'),
            'response' => $token,
            'remoteip' => $request->ip(),
        ]));
        if ($res['status'] === 0 || $res['status'] >= 500) {
            // Si Cloudflare no responde, no se bloquea a la gente: quedan el honeypot y los límites.
            Logger::warning('Turnstile no respondió; se deja pasar', ['status' => $res['status']]);
            return true;
        }
        return ($res['json']['success'] ?? false) === true;
    }
}
