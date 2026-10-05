<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class Hub
{
    private const SELECT = 'SELECT h.id, h.`key`, h.sort, h.pillar_post_id, t.locale, t.slug, t.title, t.menu_title, t.intro_html,
        t.faq_json, t.seo_title, t.seo_description, t.needs_review, h.updated_at
        FROM hubs h JOIN hub_translations t ON t.hub_id = h.id';

    public static function bySlug(string $locale, string $slug): ?array
    {
        return DB::one(self::SELECT . ' WHERE t.locale = :l AND t.slug = :s', ['l' => $locale, 's' => $slug]);
    }

    public static function byKey(string $key, string $locale): ?array
    {
        return DB::one(self::SELECT . ' WHERE t.locale = :l AND h.`key` = :k', ['l' => $locale, 'k' => $key]);
    }

    public static function byId(int $id, string $locale): ?array
    {
        return DB::one(self::SELECT . ' WHERE t.locale = :l AND h.id = :id', ['l' => $locale, 'id' => $id]);
    }

    public static function all(string $locale): array
    {
        return DB::all(self::SELECT . ' WHERE t.locale = :l ORDER BY h.sort', ['l' => $locale]);
    }

    public static function path(array $hub): string
    {
        return ($hub['locale'] === 'en' ? '/en/' : '/') . $hub['slug'] . '/';
    }

    public static function alternates(int $hubId): array
    {
        $out = [];
        foreach (DB::all('SELECT locale, slug FROM hub_translations WHERE hub_id = :id', ['id' => $hubId]) as $row) {
            $out[$row['locale']] = self::path($row);
        }
        return $out;
    }

    /** @return array<int, array{q:string,a:string}> */
    public static function faqs(array $hub): array
    {
        $faqs = json_decode((string) ($hub['faq_json'] ?? '[]'), true);
        return is_array($faqs) ? $faqs : [];
    }
}
