<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\DB;

/**
 * Canales: qué contenido se publica, en qué cuentas y con qué horario.
 */
final class Channels
{
    /** Cuentas por defecto de cada canal (id externo de la página de Facebook y de la cuenta de Instagram). */
    public const DEFAULT_ACCOUNTS = [
        'principal' => ['fb' => '1424980334291776', 'ig' => '17841405799896866'],
        'concurso' => ['fb' => '988842070972110'],
    ];

    public const TYPES = ['post', 'page', 'product', 'tool'];
    public const AUDIENCES = ['oficina', 'docente', 'concurso'];

    /** @return array<int, array> canales con schedule y content decodificados */
    public static function all(bool $onlyActive = false): array
    {
        $rows = DB::all('SELECT * FROM social_channels' . ($onlyActive ? ' WHERE active = 1' : '') . ' ORDER BY id');
        return array_map([self::class, 'hydrate'], $rows);
    }

    public static function find(int $id): ?array
    {
        $row = DB::one('SELECT * FROM social_channels WHERE id = :id', ['id' => $id]);
        return $row ? self::hydrate($row) : null;
    }

    public static function byKey(string $key): ?array
    {
        $row = DB::one('SELECT * FROM social_channels WHERE `key` = :k', ['k' => $key]);
        return $row ? self::hydrate($row) : null;
    }

    public static function hydrate(array $row): array
    {
        $row['schedule'] = Schedule::normalize((array) json_decode((string) $row['schedule_json'], true));
        $row['content'] = self::normalizeContent((array) json_decode((string) $row['content_json'], true));
        return $row;
    }

    public static function normalizeContent(array $rule): array
    {
        $list = static fn ($v): array => array_values(array_unique(array_filter(array_map(fn ($x) => trim((string) $x), (array) $v), fn ($x) => $x !== '')));
        return [
            'types' => array_values(array_intersect(self::TYPES, $list($rule['types'] ?? self::TYPES))),
            'hubs_include' => $list($rule['hubs_include'] ?? []),   // vacío = todos los hubs (y entradas sin hub)
            'hubs_exclude' => $list($rule['hubs_exclude'] ?? []),
            'audiences' => array_values(array_intersect(self::AUDIENCES, $list($rule['audiences'] ?? self::AUDIENCES))),
            'skus' => $list($rule['skus'] ?? []),                   // vacío = todos los de los públicos elegidos
            'exclude_skus' => $list($rule['exclude_skus'] ?? []),   // admite comodín final: "PIAR-*"
            'tools' => $list($rule['tools'] ?? []),
        ];
    }

    /** Cuentas (id interno por red) de un canal, solo las conectadas y activas. @return array<string, array> */
    public static function accounts(array $channel): array
    {
        $out = [];
        foreach (['fb' => 'fb_account_id', 'ig' => 'ig_account_id'] as $network => $col) {
            $account = Accounts::find($channel[$col] !== null ? (int) $channel[$col] : null);
            if ($account !== null && $account['network'] === $network && $account['token_enc'] !== null) {
                $out[$network] = $account;
            }
        }
        return $out;
    }

    /** Asigna las cuentas por defecto a los canales que aún no tienen cuenta en esa red. */
    public static function assignDefaults(): void
    {
        foreach (self::DEFAULT_ACCOUNTS as $key => $map) {
            $channel = DB::one('SELECT * FROM social_channels WHERE `key` = :k', ['k' => $key]);
            if ($channel === null) {
                continue;
            }
            $set = [];
            foreach ($map as $network => $external) {
                $col = $network . '_account_id';
                if ($channel[$col] !== null) {
                    continue;
                }
                $id = DB::value('SELECT id FROM social_accounts WHERE network = :n AND external_id = :e', ['n' => $network, 'e' => $external]);
                if ($id !== null) {
                    $set[$col] = (int) $id;
                }
            }
            if ($set !== []) {
                DB::update('social_channels', $set, ['id' => (int) $channel['id']]);
            }
        }
    }
}
