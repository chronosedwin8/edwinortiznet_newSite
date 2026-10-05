<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

final class Family
{
    private const SELECT = 'SELECT f.id, f.`key`, f.audience, f.sort, t.locale, t.slug, t.name, t.description_html, t.needs_review
        FROM product_families f JOIN product_family_translations t ON t.family_id = f.id';

    public static function all(string $locale): array
    {
        return DB::all(self::SELECT . ' WHERE t.locale = :l ORDER BY f.sort, f.id', ['l' => $locale]);
    }

    public static function bySlug(string $locale, string $slug): ?array
    {
        return DB::one(self::SELECT . ' WHERE t.locale = :l AND t.slug = :s', ['l' => $locale, 's' => $slug]);
    }

    public static function alternates(int $familyId): array
    {
        $out = [];
        foreach (DB::all('SELECT locale, slug FROM product_family_translations WHERE family_id = :id', ['id' => $familyId]) as $row) {
            $out[$row['locale']] = route('shop.family', ['slug' => $row['slug']], $row['locale']);
        }
        return $out;
    }
}
