<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Services\Mail\MailTemplates;
use App\Services\Newsletter\Interests;

/**
 * Suscriptores del boletín con doble opt-in. Una fila por correo (migración 019).
 *
 * status: pending (falta confirmar) → active (confirmó con el botón) → unsubscribed (se dio de baja).
 * bounced y spam los pone el panel (o el ataque del 2026-10-08) y nunca reciben correos.
 * paused_until: el suscriptor pausó el boletín desde el centro de preferencias.
 */
final class Subscribers
{
    /** Etiquetas antiguas (columna `tag`, solo por compatibilidad). */
    public const TAGS = ['general', 'excel', 'ia-para-docentes', 'concurso-docente', 'concurso', 'herramientas'];

    /** Tope global de correos de confirmación (protege la reputación del remitente ante ataques). */
    public const MAIL_CAP_HOUR = 15;
    public const MAIL_CAP_DAY = 60;

    /** Condición SQL de "recibe el boletín". */
    public const RECEIVES = "status = 'active' AND (paused_until IS NULL OR paused_until <= UTC_TIMESTAMP())";

    /** HMAC de la IP con APP_KEY: sirve para detectar muchas altas desde una misma IP sin guardar la IP. */
    public static function ipHash(string $ip): string
    {
        return hash_hmac('sha256', 'ip|' . $ip, (string) Config::get('APP_KEY', 'dev-key'));
    }

    /**
     * Alta (o reactivación) pendiente de confirmar. Datos opcionales: source, tag, source_type, source_path,
     * source_title, referrer, utm_source, utm_medium, utm_campaign, interests (array) e ip.
     * Si el correo ya está activo no cambia nada; si estaba pendiente se suman los intereses; si se había dado
     * de baja vuelve a pendiente con el nuevo origen. Los marcados como spam o rebotados se quedan así.
     */
    public static function add(string $email, string $locale, array $data = []): array
    {
        $email = strtolower(trim($email));
        $interests = Interests::normalize($data['interests'] ?? []);
        $origin = self::origin($data);
        $existing = self::byEmail($email);
        if ($existing === null) {
            $tag = in_array($data['tag'] ?? '', self::TAGS, true) ? (string) $data['tag'] : 'general';
            try {
                DB::insert('subscribers', $origin + [
                    'email' => $email,
                    'locale' => $locale === 'en' ? 'en' : 'es',
                    'source' => mb_substr((string) ($data['source'] ?? $origin['source_type']), 0, 190),
                    'tag' => $tag,
                    'status' => 'pending',
                    'interests' => Interests::toSet($interests),
                    'token' => bin2hex(random_bytes(32)),
                    'ip_hash' => isset($data['ip']) ? self::ipHash((string) $data['ip']) : null,
                ]);
            } catch (\PDOException $e) {
                if ($e->getCode() !== '23000') { // dos altas simultáneas del mismo correo
                    throw $e;
                }
            }
            return self::byEmail($email) ?? [];
        }
        $id = (int) $existing['id'];
        if ($existing['status'] === 'unsubscribed') {
            DB::update('subscribers', $origin + [
                'status' => 'pending', 'confirmed_at' => null, 'unsubscribed_at' => null, 'unsubscribed_reason' => null, 'paused_until' => null,
                'locale' => $locale === 'en' ? 'en' : 'es',
                'interests' => Interests::toSet($interests !== [] ? $interests : Interests::fromSet($existing['interests'])),
                'ip_hash' => isset($data['ip']) ? self::ipHash((string) $data['ip']) : $existing['ip_hash'],
            ], ['id' => $id]);
        } elseif ($existing['status'] === 'pending' && $interests !== []) {
            DB::update('subscribers', ['interests' => Interests::toSet(array_merge(Interests::fromSet($existing['interests']), $interests))], ['id' => $id]);
        }
        return self::byId($id) ?? $existing;
    }

    /** Campos de origen saneados (la ruta debe ser interna; los textos se recortan). */
    private static function origin(array $data): array
    {
        $path = (string) ($data['source_path'] ?? '');
        $path = preg_match('#^/(?!/)[^\s<>"]{0,254}$#u', $path) ? $path : null;
        $clip = static function (mixed $v, int $max): ?string {
            $v = is_string($v) ? trim(preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $v) ?? '') : '';
            return $v === '' ? null : mb_substr($v, 0, $max);
        };
        return [
            'source_type' => Interests::sourceType($data['source_type'] ?? null),
            'source_path' => $path,
            'source_title' => $clip($data['source_title'] ?? null, 255),
            'referrer' => $clip($data['referrer'] ?? null, 255),
            'utm_source' => $clip($data['utm_source'] ?? null, 100),
            'utm_medium' => $clip($data['utm_medium'] ?? null, 100),
            'utm_campaign' => $clip($data['utm_campaign'] ?? null, 100),
        ];
    }

    public static function byEmail(string $email): ?array
    {
        return DB::one('SELECT * FROM subscribers WHERE email = :e', ['e' => strtolower(trim($email))]);
    }

    public static function byId(int $id): ?array
    {
        return DB::one('SELECT * FROM subscribers WHERE id = :id', ['id' => $id]);
    }

    public static function find(string $token): ?array
    {
        return preg_match('/^[a-f0-9]{64}$/', $token) ? DB::one('SELECT * FROM subscribers WHERE token = :t', ['t' => $token]) : null;
    }

    /**
     * Confirma (botón de la página de confirmación). $interests null = no cambiar; [] = de todo un poco.
     * Spam y rebotados no se pueden confirmar desde el enlace.
     */
    public static function confirm(string $token, ?array $interests = null, ?string $ip = null): ?array
    {
        $row = self::find($token);
        if ($row === null || in_array($row['status'], ['spam', 'bounced'], true)) {
            return null;
        }
        $set = "status = 'active', confirmed_at = COALESCE(confirmed_at, UTC_TIMESTAMP()), unsubscribed_at = NULL, unsubscribed_reason = NULL";
        $params = ['id' => (int) $row['id']];
        if ($interests !== null) {
            $set .= ', interests = :i';
            $params['i'] = Interests::toSet($interests);
        }
        if ($ip !== null) {
            $set .= ', confirmed_ip_hash = :h';
            $params['h'] = self::ipHash($ip);
        }
        DB::run("UPDATE subscribers SET $set WHERE id = :id", $params);
        return self::byId((int) $row['id']);
    }

    /** Baja (con motivo opcional). $sendId atribuye la baja a la edición del boletín de la que vino. */
    public static function unsubscribe(string $token, ?string $reason = null, ?int $sendId = null): ?array
    {
        $row = self::find($token);
        if ($row === null) {
            return null;
        }
        if (!in_array($row['status'], ['spam', 'bounced'], true)) {
            DB::run(
                "UPDATE subscribers SET status = 'unsubscribed', unsubscribed_at = COALESCE(unsubscribed_at, UTC_TIMESTAMP()), unsubscribed_reason = :r WHERE id = :id",
                ['id' => (int) $row['id'], 'r' => $reason !== null && trim($reason) !== '' ? mb_substr(trim($reason), 0, 255) : $row['unsubscribed_reason']]
            );
        }
        if ($sendId !== null && $sendId > 0) {
            DB::run('UPDATE newsletter_sends SET unsubscribed_at = COALESCE(unsubscribed_at, UTC_TIMESTAMP()) WHERE id = :s AND subscriber_id = :id', ['s' => $sendId, 'id' => (int) $row['id']]);
        }
        return self::byId((int) $row['id']);
    }

    /**
     * Centro de preferencias: temas, idioma y pausa ('' = recibir, '1m', '3m'). Si estaba dado de baja,
     * guardar lo reactiva (el enlace llegó a su correo, así que ya demostró que es suyo).
     */
    public static function savePreferences(array $row, array $interests, string $locale, string $pause): ?array
    {
        if (in_array($row['status'], ['spam', 'bounced'], true)) {
            return null;
        }
        $paused = match ($pause) {
            '1m' => gmdate('Y-m-d H:i:s', strtotime('+1 month')),
            '3m' => gmdate('Y-m-d H:i:s', strtotime('+3 months')),
            default => null,
        };
        DB::run(
            "UPDATE subscribers SET interests = :i, locale = :l, paused_until = :p, status = 'active',
                confirmed_at = COALESCE(confirmed_at, UTC_TIMESTAMP()), unsubscribed_at = NULL, unsubscribed_reason = NULL WHERE id = :id",
            ['i' => Interests::toSet($interests), 'l' => $locale === 'en' ? 'en' : 'es', 'p' => $paused, 'id' => (int) $row['id']]
        );
        return self::byId((int) $row['id']);
    }

    /**
     * Envía el correo de confirmación respetando el tope global (15/h y 60/día).
     * Devuelve false si se alcanzó el tope o falló el envío.
     */
    public static function sendConfirmation(array $row): bool
    {
        if ($row === [] || $row['status'] !== 'pending') {
            return false;
        }
        $allowed = RateLimiter::hit('subscribe-mail', 'global', self::MAIL_CAP_HOUR, 3600)
            && RateLimiter::hit('subscribe-mail-day', 'global', self::MAIL_CAP_DAY, 86400);
        if (!$allowed) {
            Logger::warning('Tope de correos de confirmación de suscripción alcanzado', ['source' => $row['source_type'] ?? '']);
            return false;
        }
        $locale = $row['locale'] === 'en' ? 'en' : 'es';
        $mail = MailTemplates::render('subscribe-confirm', $locale, [
            'confirmUrl' => url(route('subscribe.confirm', ['token' => $row['token']], $locale)),
        ]);
        $ok = Mailer::send((string) $row['email'], $mail['subject'], $mail['html'], $mail['text']);
        if ($ok) {
            DB::run('UPDATE subscribers SET confirm_sent_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => (int) $row['id']]);
        }
        return $ok;
    }

    /** Cambia el estado desde el panel (spam, rebotado, baja o activo). */
    public static function setStatus(array $ids, string $status): int
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if ($ids === [] || !in_array($status, Interests::STATUSES, true)) {
            return 0;
        }
        $extra = match ($status) {
            'active' => ', confirmed_at = COALESCE(confirmed_at, UTC_TIMESTAMP()), unsubscribed_at = NULL',
            'pending' => '',
            default => ', unsubscribed_at = COALESCE(unsubscribed_at, UTC_TIMESTAMP())',
        };
        return DB::run('UPDATE subscribers SET status = ?' . $extra . ' WHERE id IN (' . DB::in($ids) . ')', array_merge([$status], $ids))->rowCount();
    }

    /** Borra del todo (los envíos del boletín quedan para las estadísticas, sin el correo). */
    public static function delete(array $ids): int
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if ($ids === []) {
            return 0;
        }
        DB::run("UPDATE newsletter_sends SET email = CONCAT('borrado-', id) WHERE subscriber_id IN (" . DB::in($ids) . ')', $ids);
        return DB::run('DELETE FROM subscribers WHERE id IN (' . DB::in($ids) . ')', $ids)->rowCount();
    }

    public static function setInterests(array $ids, array $interests): int
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if ($ids === []) {
            return 0;
        }
        return DB::run('UPDATE subscribers SET interests = ? WHERE id IN (' . DB::in($ids) . ')', array_merge([Interests::toSet($interests)], $ids))->rowCount();
    }
}
