<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

/**
 * Entradas, páginas y políticas (tabla posts, una fila por idioma unida por translation_group).
 */
final class Post
{
    private const LIST_COLUMNS = 'p.id, p.wp_id, p.type, p.locale, p.translation_group, p.slug, p.title, p.excerpt, p.cover_url, p.cover_alt,
        p.cover_width, p.cover_height, p.hub_id, p.status, p.reading_minutes, p.published_at, p.updated_at, p.related_product_id';

    public static function find(int $id): ?array
    {
        return DB::one('SELECT * FROM posts WHERE id = :id', ['id' => $id]);
    }

    /** Entrada o página visible (publicada o noindex) por slug. */
    public static function findVisible(string $locale, string $slug, array $types = ['post', 'page']): ?array
    {
        return DB::one(
            'SELECT * FROM posts WHERE locale = ? AND slug = ? AND status IN ("published","noindex") AND type IN (' . DB::in($types) . ') LIMIT 1',
            array_merge([$locale, $slug], $types)
        );
    }

    public static function translation(array $post, string $locale): ?array
    {
        if ($post['locale'] === $locale) {
            return $post;
        }
        return DB::one(
            'SELECT * FROM posts WHERE translation_group = :g AND locale = :l AND status IN ("published","noindex") LIMIT 1',
            ['g' => $post['translation_group'], 'l' => $locale]
        );
    }

    /** Artículos publicados para listados (excluye noindex y borradores). */
    public static function latest(string $locale, int $limit = 10, int $offset = 0, ?int $hubId = null, array $excludeIds = []): array
    {
        $sql = 'SELECT ' . self::LIST_COLUMNS . ' FROM posts p WHERE p.locale = ? AND p.type = "post" AND p.status = "published"';
        $params = [$locale];
        if ($hubId !== null) {
            $sql .= ' AND p.hub_id = ?';
            $params[] = $hubId;
        }
        if ($excludeIds) {
            $sql .= ' AND p.id NOT IN (' . DB::in($excludeIds) . ')';
            $params = array_merge($params, array_map('intval', $excludeIds));
        }
        $sql .= ' ORDER BY p.published_at DESC LIMIT ' . (int) $limit . ' OFFSET ' . (int) $offset;
        return DB::all($sql, $params);
    }

    public static function countPublished(string $locale, ?int $hubId = null): int
    {
        $sql = 'SELECT COUNT(*) FROM posts WHERE locale = ? AND type = "post" AND status = "published"';
        $params = [$locale];
        if ($hubId !== null) {
            $sql .= ' AND hub_id = ?';
            $params[] = $hubId;
        }
        return (int) DB::value($sql, $params);
    }

    /** Dos artículos hermanos: mismo hub (o, sin hub, los más cercanos en fecha). */
    public static function siblings(array $post, int $limit = 2): array
    {
        $params = ['l' => $post['locale'], 'id' => (int) $post['id'], 'd' => $post['published_at'] ?? DB::now()];
        $hubFilter = '';
        if (!empty($post['hub_id'])) {
            $hubFilter = ' AND p.hub_id = :h';
            $params['h'] = (int) $post['hub_id'];
        }
        $rows = DB::all(
            'SELECT ' . self::LIST_COLUMNS . ' FROM posts p
             WHERE p.locale = :l AND p.type = "post" AND p.status = "published" AND p.id <> :id' . $hubFilter . '
             ORDER BY ABS(TIMESTAMPDIFF(DAY, p.published_at, :d)) ASC LIMIT ' . (int) $limit,
            $params
        );
        if (count($rows) < $limit) {
            $rows = array_merge($rows, self::latest($post['locale'], $limit - count($rows), 0, null, array_merge([(int) $post['id']], array_column($rows, 'id'))));
        }
        return $rows;
    }

    public static function byIds(array $ids, string $locale): array
    {
        if ($ids === []) {
            return [];
        }
        return DB::all(
            'SELECT ' . self::LIST_COLUMNS . ' FROM posts p WHERE p.id IN (' . DB::in($ids) . ') AND p.locale = ? AND p.status = "published"',
            array_merge(array_map('intval', $ids), [$locale])
        );
    }

    /** Entradas cuya ruta comparten las dos versiones (para hreflang). */
    public static function alternates(array $post): array
    {
        $rows = DB::all(
            'SELECT locale, slug, type FROM posts WHERE translation_group = :g AND status IN ("published","noindex")',
            ['g' => $post['translation_group']]
        );
        $out = [];
        foreach ($rows as $row) {
            $out[$row['locale']] = post_path($row);
        }
        return $out;
    }

    public static function categories(int $postId, string $locale): array
    {
        return DB::all(
            'SELECT c.id, ct.name, ct.slug, c.hub_id FROM post_category pc
             JOIN categories c ON c.id = pc.category_id
             JOIN category_translations ct ON ct.category_id = c.id AND ct.locale = :l
             WHERE pc.post_id = :p ORDER BY pc.is_primary DESC, ct.name',
            ['p' => $postId, 'l' => $locale]
        );
    }
}
