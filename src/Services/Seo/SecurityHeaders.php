<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Core\Config;
use App\Core\Request;
use App\Core\Response;

/**
 * CSP y cabeceras de seguridad. Los scripts en línea se autorizan por hash (no hay 'unsafe-inline' en script-src).
 */
final class SecurityHeaders
{
    /** Script en línea que fija el tema antes de pintar (evita el parpadeo claro/oscuro). */
    public const THEME_SCRIPT = "(function(){var d=document.documentElement;d.classList.add('js');try{var t=localStorage.getItem('eo-theme');if(t==='dark'||t==='light'){d.dataset.theme=t}if(localStorage.getItem('eo-consent')==='all'){d.classList.add('consent-ok')}}catch(e){}})();";

    public static function scriptHash(string $script): string
    {
        return "'sha256-" . base64_encode(hash('sha256', $script, true)) . "'";
    }

    public static function csp(): string
    {
        $google = 'https://www.googletagmanager.com https://*.google-analytics.com https://pagead2.googlesyndication.com '
            . 'https://*.googlesyndication.com https://*.adtrafficquality.google https://partner.googleadservices.com https://www.google.com';
        $gateways = 'https://checkout.wompi.co https://*.mercadopago.com https://*.mercadopago.com.co https://*.mercadolibre.com '
            . 'https://www.paypal.com https://www.sandbox.paypal.com';
        $directives = [
            "default-src 'self'",
            "script-src 'self' " . self::scriptHash(self::THEME_SCRIPT) . ' ' . $google,
            "style-src 'self' 'unsafe-inline'",
            "img-src 'self' data: blob: https:",
            "font-src 'self'",
            "media-src 'self' https:",
            "connect-src 'self' https://*.google-analytics.com https://*.analytics.google.com https://www.googletagmanager.com "
                . 'https://pagead2.googlesyndication.com https://*.adtrafficquality.google',
            'frame-src https://www.youtube-nocookie.com https://www.youtube.com https://googleads.g.doubleclick.net '
                . 'https://tpc.googlesyndication.com https://www.google.com https://*.adtrafficquality.google',
            "form-action 'self' $gateways",
            "frame-ancestors 'self'",
            "base-uri 'self'",
            "object-src 'none'",
        ];
        if (Config::isProduction()) {
            $directives[] = 'upgrade-insecure-requests';
        }
        return implode('; ', $directives);
    }

    public static function apply(Request $request, Response $response): void
    {
        $h = &$response->headers;
        $type = (string) ($h['Content-Type'] ?? '');
        if (str_starts_with($type, 'text/html')) {
            $h['Content-Security-Policy'] = self::csp();
            $h['X-Frame-Options'] = 'SAMEORIGIN';
        }
        $h['X-Content-Type-Options'] = 'nosniff';
        $h['Referrer-Policy'] = 'strict-origin-when-cross-origin';
        $h['Permissions-Policy'] = 'camera=(), microphone=(), geolocation=(), payment=(), usb=(), interest-cohort=()';
        $h['Cross-Origin-Opener-Policy'] = 'same-origin-allow-popups';
        if ($request->isSecure() || Config::isProduction()) {
            $h['Strict-Transport-Security'] = 'max-age=31536000; includeSubDomains';
        }
        if (Config::bool('NOINDEX')) {
            $h['X-Robots-Tag'] = 'noindex, nofollow';
        }
        if (!isset($h['Cache-Control'])) {
            $h['Cache-Control'] = 'private, no-cache';
        }
        $h['Vary'] = 'Accept-Encoding';
    }
}
