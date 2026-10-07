<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;
use App\Core\DB;
use App\Core\Request;
use App\Core\Session;

/**
 * Reacciones de los lectores a los artículos (estilo LinkedIn): una por visitante y entrada,
 * que se puede cambiar o quitar.
 *
 * Decisiones:
 * - El conteo es por fila de `posts` (cada idioma cuenta aparte): las versiones ES/EN tienen
 *   públicos distintos y pueden diferir; sumar por translation_group contaría dos veces a quien
 *   reaccione en ambas.
 * - El visitante se identifica con una cookie funcional (eo_rx) con un id aleatorio que solo se
 *   crea al reaccionar; en la base se guarda su HMAC con APP_KEY, nunca el valor de la cookie.
 * - Sin tabla de conteos: GROUP BY sobre el índice (post_id, reaction) los da sin leer filas.
 */
final class Reactions
{
    public const COOKIE = 'eo_rx';
    public const COOKIE_MAX_AGE = 31536000;
    /** Orden de la barra; el emoji es el mismo en los dos idiomas. */
    public const TYPES = [
        'like' => '👍',
        'insightful' => '💡',
        'celebrate' => '👏',
        'love' => '❤️',
        'thoughtful' => '🤔',
    ];

    public static function isValid(?string $reaction): bool
    {
        return is_string($reaction) && isset(self::TYPES[$reaction]);
    }

    /** Solo se reacciona a artículos visibles (publicados o noindex), nunca a páginas, políticas ni borradores. */
    public static function reactable(int $postId): bool
    {
        return $postId > 0 && DB::value(
            'SELECT 1 FROM posts WHERE id = :id AND type = "post" AND status IN ("published","noindex")',
            ['id' => $postId]
        ) !== null;
    }

    /** Id del visitante (valor de la cookie) si es válido. */
    public static function visitorId(Request $request): ?string
    {
        $id = $request->cookie(self::COOKIE);
        return is_string($id) && preg_match('/^[a-f0-9]{48}$/', $id) ? $id : null;
    }

    public static function newVisitorId(): string
    {
        return bin2hex(random_bytes(24));
    }

    public static function visitorHash(string $visitorId): string
    {
        return hash_hmac('sha256', 'reactions|' . $visitorId, (string) Config::get('APP_KEY', 'dev-key'));
    }

    public static function cookieHeader(string $visitorId, Request $request): string
    {
        return Session::cookieHeader(self::COOKIE, $visitorId, self::COOKIE_MAX_AGE, $request->isSecure() || Config::isProduction(), true);
    }

    /**
     * Conteos de una entrada: ['total' => n, 'counts' => [tipo => n, …], 'top' => [tipos más usados]].
     */
    public static function summary(int $postId): array
    {
        return self::summaries([$postId])[$postId];
    }

    /**
     * Conteos de varias entradas en una sola consulta (listados y panel, sin N+1).
     *
     * @param int[] $postIds
     * @return array<int, array{total:int, counts:array<string,int>, top:string[]}>
     */
    public static function summaries(array $postIds): array
    {
        $postIds = array_values(array_unique(array_filter(array_map('intval', $postIds), fn ($id) => $id > 0)));
        $out = [];
        foreach ($postIds as $id) {
            $out[$id] = array_fill_keys(array_keys(self::TYPES), 0);
        }
        if ($postIds !== []) {
            $rows = DB::all(
                'SELECT post_id, reaction, COUNT(*) AS n FROM post_reactions WHERE post_id IN (' . DB::in($postIds) . ') GROUP BY post_id, reaction',
                $postIds
            );
            foreach ($rows as $row) {
                $out[(int) $row['post_id']][$row['reaction']] = (int) $row['n'];
            }
        }
        return array_map(static fn (array $counts): array => self::shape($counts), $out);
    }

    /** @param array<string,int> $counts */
    private static function shape(array $counts): array
    {
        $order = array_flip(array_keys(self::TYPES));
        $used = array_filter($counts);
        // Más usadas primero; en empate, el orden de la barra.
        uksort($used, static fn (string $a, string $b): int => [$used[$b], $order[$a]] <=> [$used[$a], $order[$b]]);
        return ['total' => array_sum($counts), 'counts' => $counts, 'top' => array_slice(array_keys($used), 0, 3)];
    }

    public static function mine(int $postId, string $visitorHash): ?string
    {
        $value = DB::value(
            'SELECT reaction FROM post_reactions WHERE post_id = :p AND visitor = :v',
            ['p' => $postId, 'v' => $visitorHash]
        );
        return is_string($value) ? $value : null;
    }

    /** Fija (o cambia) la reacción del visitante; null la quita. */
    public static function set(int $postId, string $visitorHash, ?string $reaction): void
    {
        if ($reaction === null) {
            DB::run('DELETE FROM post_reactions WHERE post_id = :p AND visitor = :v', ['p' => $postId, 'v' => $visitorHash]);
            return;
        }
        if (!self::isValid($reaction)) {
            throw new \InvalidArgumentException('Reacción desconocida');
        }
        // Marcadores posicionales: PDO no permite repetir un marcador con nombre en la misma consulta.
        DB::run(
            'INSERT INTO post_reactions (post_id, visitor, reaction) VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE reaction = ?, updated_at = CURRENT_TIMESTAMP',
            [$postId, $visitorHash, $reaction, $reaction]
        );
    }
}
