<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\DB;

/**
 * Suscriptores con doble opt-in (confirmed_at se llena al hacer clic en el correo).
 */
final class Subscribers
{
    public const TAGS = ['general', 'excel', 'ia-para-docentes', 'concurso-docente', 'concurso', 'herramientas'];

    public static function add(string $email, string $locale, string $source, string $tag): array
    {
        $tag = in_array($tag, self::TAGS, true) ? $tag : 'general';
        $existing = DB::one('SELECT * FROM subscribers WHERE email = :e AND tag = :t', ['e' => $email, 't' => $tag]);
        if ($existing !== null) {
            if ($existing['unsubscribed_at'] !== null) {
                DB::update('subscribers', ['unsubscribed_at' => null, 'confirmed_at' => null], ['id' => (int) $existing['id']]);
                $existing['confirmed_at'] = null;
            }
            return $existing;
        }
        $token = bin2hex(random_bytes(32));
        $id = DB::insert('subscribers', [
            'email' => $email,
            'locale' => $locale,
            'source' => mb_substr($source, 0, 190),
            'tag' => $tag,
            'token' => $token,
        ]);
        return DB::one('SELECT * FROM subscribers WHERE id = :id', ['id' => $id]) ?? [];
    }

    public static function find(string $token): ?array
    {
        return preg_match('/^[a-f0-9]{64}$/', $token) ? DB::one('SELECT * FROM subscribers WHERE token = :t', ['t' => $token]) : null;
    }

    public static function confirm(string $token): ?array
    {
        $row = DB::one('SELECT * FROM subscribers WHERE token = :t', ['t' => $token]);
        if ($row === null) {
            return null;
        }
        if ($row['confirmed_at'] === null) {
            DB::run('UPDATE subscribers SET confirmed_at = UTC_TIMESTAMP(), unsubscribed_at = NULL WHERE id = :id', ['id' => (int) $row['id']]);
        }
        return $row;
    }

    public static function unsubscribe(string $token): ?array
    {
        $row = DB::one('SELECT * FROM subscribers WHERE token = :t', ['t' => $token]);
        if ($row !== null) {
            DB::run('UPDATE subscribers SET unsubscribed_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => (int) $row['id']]);
        }
        return $row;
    }
}
