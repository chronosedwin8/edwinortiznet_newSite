<?php

declare(strict_types=1);

namespace App\Services\Content;

use App\Core\Config;
use App\Core\Request;

/**
 * Honeypot + marca de tiempo firmada. El formulario debe tardar al menos 2 s y como mucho 1 día.
 * La marca se emite como marcador para que la página siga siendo cacheable.
 */
final class AntiSpam
{
    public const PLACEHOLDER = '__EO_FORM_TS__';
    private const MIN_SECONDS = 2;
    private const MAX_SECONDS = 86400;

    public static function stamp(?int $time = null): string
    {
        $time ??= time();
        return $time . '.' . substr(hash_hmac('sha256', 'ts|' . $time, (string) Config::get('APP_KEY', 'dev-key')), 0, 20);
    }

    public static function fields(): string
    {
        // El campo "website" es una trampa: los humanos no lo ven (oculto por CSS y aria-hidden).
        return '<div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>'
            . '<input type="hidden" name="_ts" value="' . self::PLACEHOLDER . '">';
    }

    public static function passes(Request $request): bool
    {
        if (trim((string) ($request->post['website'] ?? '')) !== '') {
            return false;
        }
        $ts = (string) ($request->post['_ts'] ?? '');
        if (!preg_match('/^(\d{9,11})\.([a-f0-9]{20})$/', $ts, $m)) {
            return false;
        }
        if (!hash_equals(self::stamp((int) $m[1]), $ts)) {
            return false;
        }
        $age = time() - (int) $m[1];
        return $age >= self::MIN_SECONDS && $age <= self::MAX_SECONDS;
    }
}
