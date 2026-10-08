<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Core\Mailer;

/**
 * Cuentas conectadas (páginas de Facebook, cuentas profesionales de Instagram).
 */
final class Accounts
{
    public const NETWORKS = ['fb' => 'Facebook', 'ig' => 'Instagram'];

    public static function find(?int $id): ?array
    {
        return $id ? DB::one('SELECT * FROM social_accounts WHERE id = :id', ['id' => $id]) : null;
    }

    /** @return array<int, array> */
    public static function all(): array
    {
        return DB::all("SELECT * FROM social_accounts ORDER BY FIELD(network, 'fb', 'ig'), name");
    }

    public static function token(array $account): string
    {
        $token = TokenVault::decrypt($account['token_enc'] ?? null);
        if ($token === null || $token === '') {
            throw new MetaException('La cuenta «' . $account['name'] . '» no tiene un token válido guardado. Vuelve a conectarla.', 0, 190);
        }
        return $token;
    }

    /** Guarda (o actualiza) una cuenta con su token cifrado. Devuelve el id. */
    public static function store(string $network, string $externalId, array $data, ?string $token): int
    {
        $row = $data + ['network' => $network, 'external_id' => $externalId, 'status' => 'active', 'last_error' => null, 'alerted_at' => null, 'last_check_at' => DB::now()];
        if ($token !== null) {
            $row['token_enc'] = TokenVault::encrypt($token);
        }
        return DB::upsert('social_accounts', $row, ['network', 'external_id']);
    }

    public static function decodeInfo(array $account): array
    {
        $info = json_decode((string) ($account['info_json'] ?? ''), true);
        return is_array($info) ? $info : [];
    }

    public static function mergeInfo(int $id, array $info): void
    {
        $current = self::decodeInfo(self::find($id) ?? []);
        DB::update('social_accounts', ['info_json' => json_encode($info + $current, JSON_UNESCAPED_UNICODE)], ['id' => $id]);
    }

    /**
     * Token vencido o revocado: la cuenta queda "por reconectar" y se avisa por correo (una vez cada 24 h).
     */
    public static function tokenFailed(int $id, string $error): void
    {
        $account = self::find($id);
        if ($account === null) {
            return;
        }
        DB::update('social_accounts', ['status' => 'reconnect', 'last_error' => mb_substr($error, 0, 500), 'last_check_at' => DB::now()], ['id' => $id]);
        $last = $account['alerted_at'] ? strtotime((string) $account['alerted_at'] . ' UTC') : 0;
        if ($last > time() - 86400) {
            return;
        }
        DB::update('social_accounts', ['alerted_at' => DB::now()], ['id' => $id]);
        $network = self::NETWORKS[$account['network']] ?? $account['network'];
        $panel = Config::appUrl() . '/admin/redes/ajustes/';
        self::alert(
            "Redes sociales: reconecta {$network} «{$account['name']}»",
            "El token de {$network} «{$account['name']}» ya no es válido, así que las publicaciones programadas en esa cuenta están detenidas.\n\nDetalle: {$error}\n\nPara reanudarlas, entra a {$panel} y usa «Conectar / renovar»."
        );
    }

    /** Correo al administrador (texto plano convertido a HTML sencillo). */
    public static function alert(string $subject, string $text): void
    {
        $to = (string) Config::get('ADMIN_EMAIL', '');
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            Logger::warning('Aviso de redes sin ADMIN_EMAIL', ['subject' => $subject]);
            return;
        }
        $html = '<p>' . nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8')) . '</p>';
        Mailer::send($to, $subject, $html, $text);
    }

    /** Para el panel: ['never'|'expired'|'soon'|'ok', fecha local, días restantes]. "soon" = menos de 20 días. */
    public static function expiry(?string $expiresAt): array
    {
        if ($expiresAt === null || $expiresAt === '') {
            return ['never', null, null];
        }
        $ts = strtotime($expiresAt . ' UTC');
        $days = (int) floor(($ts - time()) / 86400);
        $state = $ts <= time() ? 'expired' : ($days < 20 ? 'soon' : 'ok');
        return [$state, Schedule::toLocal($expiresAt, 'Y-m-d'), max(0, $days)];
    }
}
