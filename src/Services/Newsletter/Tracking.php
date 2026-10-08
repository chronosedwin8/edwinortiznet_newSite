<?php

declare(strict_types=1);

namespace App\Services\Newsletter;

use App\Core\Config;
use App\Core\DB;

/**
 * Aperturas (píxel) y clics (redirección firmada) del boletín.
 *
 * Los enlaces van a /n/c/{envío}/{firma}/?u={destino}; la firma es un HMAC con APP_KEY de (envío + destino),
 * así que no es una redirección abierta: solo redirige a los destinos que firmó el sitio.
 * Las aperturas no son exactas (Apple Mail las precarga, otros bloquean imágenes): son orientativas.
 */
final class Tracking
{
    public const GIF = "GIF89a\x01\x00\x01\x00\x80\x00\x00\x00\x00\x00\xff\xff\xff\x21\xf9\x04\x01\x00\x00\x00\x00\x2c\x00\x00\x00\x00\x01\x00\x01\x00\x00\x02\x02\x44\x01\x00\x3b";

    public static function sign(string $kind, int $sendId, string $url = ''): string
    {
        return substr(hash_hmac('sha256', "nl|$kind|$sendId|$url", (string) Config::get('APP_KEY', 'dev-key')), 0, 32);
    }

    public static function verify(string $kind, int $sendId, string $sig, string $url = ''): bool
    {
        return preg_match('/^[a-f0-9]{32}$/', $sig) === 1 && hash_equals(self::sign($kind, $sendId, $url), $sig);
    }

    public static function clickUrl(int $sendId, string $target): string
    {
        return url('/n/c/' . $sendId . '/' . self::sign('c', $sendId, $target) . '/') . '?u=' . rawurlencode($target);
    }

    public static function openUrl(int $sendId): string
    {
        return url('/n/o/' . $sendId . '/' . self::sign('o', $sendId) . '/');
    }

    /** Agrega las UTM del boletín a los enlaces del propio sitio. */
    public static function utm(string $url, string $campaign, ?string $content = null): string
    {
        $own = (string) parse_url(Config::appUrl(), PHP_URL_HOST);
        if ((string) parse_url($url, PHP_URL_HOST) !== $own) {
            return $url;
        }
        $params = ['utm_source' => 'newsletter', 'utm_medium' => 'email', 'utm_campaign' => $campaign];
        if ($content !== null && $content !== '') {
            $params['utm_content'] = $content;
        }
        $fragment = '';
        if (($hash = strpos($url, '#')) !== false) {
            $fragment = substr($url, $hash);
            $url = substr($url, 0, $hash);
        }
        return $url . (str_contains($url, '?') ? '&' : '?') . http_build_query($params) . $fragment;
    }

    public static function recordOpen(int $sendId): void
    {
        $send = DB::one("SELECT id, subscriber_id, opened_at FROM newsletter_sends WHERE id = :id AND status = 'sent'", ['id' => $sendId]);
        if ($send === null) {
            return;
        }
        $first = DB::run('UPDATE newsletter_sends SET opened_at = UTC_TIMESTAMP() WHERE id = :id AND opened_at IS NULL', ['id' => $sendId])->rowCount() === 1;
        DB::run('UPDATE newsletter_sends SET opens = opens + 1 WHERE id = :id', ['id' => $sendId]);
        if ($send['subscriber_id'] !== null) {
            DB::run(
                'UPDATE subscribers SET last_open_at = UTC_TIMESTAMP(), opens_count = opens_count + :n WHERE id = :s',
                ['n' => $first ? 1 : 0, 's' => (int) $send['subscriber_id']]
            );
        }
    }

    public static function recordClick(int $sendId, string $target): void
    {
        $send = DB::one("SELECT id, subscriber_id FROM newsletter_sends WHERE id = :id AND status = 'sent'", ['id' => $sendId]);
        if ($send === null) {
            return;
        }
        // Un clic implica que se abrió (aunque el cliente bloquee las imágenes).
        $firstOpen = DB::run('UPDATE newsletter_sends SET opened_at = UTC_TIMESTAMP(), opens = opens + 1 WHERE id = :id AND opened_at IS NULL', ['id' => $sendId])->rowCount() === 1;
        DB::run('UPDATE newsletter_sends SET clicked_at = COALESCE(clicked_at, UTC_TIMESTAMP()), clicks = clicks + 1 WHERE id = :id', ['id' => $sendId]);
        DB::insert('newsletter_clicks', ['send_id' => $sendId, 'url' => mb_substr($target, 0, 600)]);
        if ($send['subscriber_id'] !== null) {
            DB::run(
                'UPDATE subscribers SET last_click_at = UTC_TIMESTAMP(), clicks_count = clicks_count + 1,
                    last_open_at = IF(:o = 1, UTC_TIMESTAMP(), last_open_at), opens_count = opens_count + :o2 WHERE id = :s',
                ['o' => $firstOpen ? 1 : 0, 'o2' => $firstOpen ? 1 : 0, 's' => (int) $send['subscriber_id']]
            );
        }
    }
}
