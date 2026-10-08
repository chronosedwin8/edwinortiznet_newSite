<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Models\Setting;

/**
 * Conecta las cuentas a partir de un token pegado en el panel (o de .env con `social:connect`).
 *
 * Meta: el token de usuario se cambia por uno de 60 días (si META_APP_SECRET está configurado); con ese token,
 * /me/accounts entrega los tokens de página, que no vencen. Se guardan cifrados las páginas y sus cuentas de
 * Instagram vinculadas (Instagram publica con el token de su página). El token de usuario no se guarda.
 */
final class Connector
{
    /** Permisos que hay que marcar al generar el token (se muestran en el panel). */
    public const META_SCOPES = ['pages_show_list', 'pages_read_engagement', 'pages_manage_posts', 'instagram_basic', 'instagram_content_publish', 'business_management'];

    /** @return array{pages:int, instagram:int, user_expires_at:?string, names:string[]} */
    public static function connectMeta(string $userToken): array
    {
        $userToken = trim($userToken);
        if (!preg_match('/^[A-Za-z0-9_\-|.]{20,1024}$/', $userToken)) {
            throw new MetaException('El token no tiene el formato esperado. Cópialo completo desde el Explorador de la Graph API.');
        }
        $client = MetaClient::graph();
        $appId = (string) Config::get('META_APP_ID', '');
        $secret = (string) Config::get('META_APP_SECRET', '');
        $token = $userToken;
        if ($appId !== '' && $secret !== '') {
            try {
                $res = $client->get('oauth/access_token', [
                    'grant_type' => 'fb_exchange_token', 'client_id' => $appId, 'client_secret' => $secret, 'fb_exchange_token' => $userToken,
                ]);
                $token = (string) ($res['access_token'] ?? $userToken);
            } catch (MetaException $e) {
                if ($e->isTokenError()) {
                    throw $e;
                }
                Logger::warning('No se pudo cambiar el token de Meta por uno de larga duración', ['code' => $e->apiCode]);
            }
        }
        $userExpires = self::metaExpiry($client, $token, $appId, $secret);

        $pages = [];
        $after = null;
        do {
            $params = ['fields' => 'id,name,username,access_token,picture{url},instagram_business_account{id,username,name,profile_picture_url}', 'limit' => 100];
            if ($after !== null) {
                $params['after'] = $after;
            }
            $res = $client->get('me/accounts', $params, $token);
            foreach ((array) ($res['data'] ?? []) as $page) {
                $pages[] = $page;
            }
            $after = isset($res['paging']['next']) ? ($res['paging']['cursors']['after'] ?? null) : null;
        } while ($after !== null && count($pages) < 500);
        if ($pages === []) {
            throw new MetaException('El token no da acceso a ninguna página. Al generarlo, marca las páginas y los permisos pages_show_list y pages_manage_posts.');
        }

        $names = [];
        $ig = 0;
        DB::transaction(function () use ($pages, $client, $appId, $secret, &$names, &$ig): void {
            foreach ($pages as $page) {
                $pageToken = (string) ($page['access_token'] ?? '');
                if ($pageToken === '') {
                    continue;
                }
                $expires = self::metaExpiry($client, $pageToken, $appId, $secret);
                Accounts::store('fb', (string) $page['id'], [
                    'name' => mb_substr((string) $page['name'], 0, 190),
                    'username' => isset($page['username']) ? (string) $page['username'] : null,
                    'page_id' => (string) $page['id'],
                    'picture_url' => $page['picture']['data']['url'] ?? null,
                    'token_expires_at' => $expires,
                ], $pageToken);
                $names[] = (string) $page['name'];
                $insta = $page['instagram_business_account'] ?? null;
                if (is_array($insta) && !empty($insta['id'])) {
                    Accounts::store('ig', (string) $insta['id'], [
                        'name' => mb_substr((string) ($insta['name'] ?? $insta['username'] ?? $insta['id']), 0, 190),
                        'username' => isset($insta['username']) ? (string) $insta['username'] : null,
                        'page_id' => (string) $page['id'],
                        'picture_url' => $insta['profile_picture_url'] ?? null,
                        'token_expires_at' => $expires,
                    ], $pageToken);
                    $names[] = '@' . ($insta['username'] ?? $insta['id']);
                    $ig++;
                }
            }
        });
        Setting::set('social.meta_user_expires_at', $userExpires ?? 'never');
        Setting::set('social.meta_connected_at', DB::now());
        Channels::assignDefaults();
        return ['pages' => count($pages), 'instagram' => $ig, 'user_expires_at' => $userExpires, 'names' => $names];
    }

    /** Vencimiento (UTC) según debug_token; null = no vence (o no se pudo saber). */
    private static function metaExpiry(MetaClient $client, string $token, string $appId, string $secret): ?string
    {
        try {
            $app = $appId !== '' && $secret !== '' ? $appId . '|' . $secret : $token;
            $data = (array) ($client->get('debug_token', ['input_token' => $token], $app)['data'] ?? []);
            $exp = (int) ($data['expires_at'] ?? 0);
            return $exp > 0 ? gmdate('Y-m-d H:i:s', $exp) : null;
        } catch (MetaException $e) {
            Logger::warning('No se pudo consultar el vencimiento del token de Meta', ['code' => $e->apiCode]);
            return null;
        }
    }

    /**
     * Comprueba cada cuenta (o solo las indicadas): token vigente y cuota de publicación de Instagram.
     * @return array<int, array{account:string, ok:bool, detail:string}>
     */
    public static function check(?array $onlyIds = null): array
    {
        $out = [];
        foreach (DB::all('SELECT * FROM social_accounts WHERE token_enc IS NOT NULL') as $account) {
            if ($onlyIds !== null && !in_array((int) $account['id'], array_map('intval', $onlyIds), true)) {
                continue;
            }
            $id = (int) $account['id'];
            $label = (Accounts::NETWORKS[$account['network']] ?? '') . ' ' . $account['name'];
            try {
                $token = Accounts::token($account);
                $info = [];
                if ($account['network'] === 'ig') {
                    $q = MetaClient::graph()->get($account['external_id'] . '/content_publishing_limit', ['fields' => 'quota_usage,config'], $token);
                    $info = self::quota($q);
                } else {
                    MetaClient::graph()->get((string) $account['external_id'], ['fields' => 'id,name'], $token);
                }
                DB::update('social_accounts', ['status' => 'active', 'last_error' => null, 'last_check_at' => DB::now(), 'alerted_at' => null], ['id' => $id]);
                if ($info !== []) {
                    Accounts::mergeInfo($id, $info + ['quota_checked_at' => DB::now()]);
                }
                $out[] = ['account' => $label, 'ok' => true, 'detail' => isset($info['quota_usage']) ? $info['quota_usage'] . '/' . $info['quota_total'] : ''];
            } catch (MetaException $e) {
                if ($e->isTokenError()) {
                    Accounts::tokenFailed($id, $e->getMessage());
                } else {
                    DB::update('social_accounts', ['last_error' => mb_substr($e->getMessage(), 0, 500), 'last_check_at' => DB::now()], ['id' => $id]);
                }
                $out[] = ['account' => $label, 'ok' => false, 'detail' => $e->getMessage()];
            }
        }
        return $out;
    }

    /** @return array{quota_usage?:int, quota_total?:int} */
    private static function quota(array $res): array
    {
        $row = (array) ($res['data'][0] ?? []);
        if ($row === []) {
            return [];
        }
        return ['quota_usage' => (int) ($row['quota_usage'] ?? 0), 'quota_total' => (int) ($row['config']['quota_total'] ?? 0)];
    }
}
