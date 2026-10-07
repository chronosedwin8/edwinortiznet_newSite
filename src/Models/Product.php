<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

/**
 * Productos: una fila con precio/archivos/familia y textos en product_translations.
 */
final class Product
{
    private const SELECT = 'SELECT p.*, t.locale, t.slug, t.title, t.short_html, t.description_html, t.includes_html, t.requirements,
        t.license_text, t.faq_json, t.seo_title, t.seo_description, t.needs_review,
        f.`key` AS family_key, ft.name AS family_name, ft.slug AS family_slug,
        (SELECT COUNT(*) FROM product_files pf WHERE pf.product_id = p.id) AS file_count,
        (SELECT COUNT(*) FROM product_files pf WHERE pf.product_id = p.id AND pf.storage_path IS NOT NULL AND pf.storage_path <> "") AS file_ready_count,
        (SELECT COUNT(DISTINCT pf.variant) FROM product_files pf WHERE pf.product_id = p.id AND pf.variant IS NOT NULL AND pf.variant <> "") AS variant_count
        FROM products p
        JOIN product_translations t ON t.product_id = p.id AND t.locale = :locale
        LEFT JOIN product_families f ON f.id = p.family_id
        LEFT JOIN product_family_translations ft ON ft.family_id = f.id AND ft.locale = :locale2';

    private static function q(string $where, array $params, string $order = 'p.sort, p.id', ?int $limit = null): array
    {
        $sql = self::SELECT . ' WHERE ' . $where . ' ORDER BY ' . $order . ($limit ? ' LIMIT ' . $limit : '');
        return array_map([self::class, 'hydrate'], DB::all($sql, $params));
    }

    private static function hydrate(array $row): array
    {
        $row['sales_total'] = (int) $row['legacy_sales'] + (int) $row['sales_count'];
        $row['purchasable'] = self::isPurchasable($row);
        return $row;
    }

    public static function isPurchasable(array $p): bool
    {
        if ($p['status'] !== 'active') {
            return false;
        }
        if ($p['type'] === 'download') {
            return (int) $p['file_count'] > 0 && (int) $p['file_count'] === (int) $p['file_ready_count'];
        }
        return $p['type'] !== 'pack';
    }

    public static function bySlug(string $locale, string $slug): ?array
    {
        $rows = self::q('t.slug = :slug', ['locale' => $locale, 'locale2' => $locale, 'slug' => $slug]);
        return $rows[0] ?? null;
    }

    public static function find(int $id, string $locale): ?array
    {
        $rows = self::q('p.id = :id', ['locale' => $locale, 'locale2' => $locale, 'id' => $id]);
        return $rows[0] ?? null;
    }

    public static function byWpId(int $wpId, string $locale = 'es'): ?array
    {
        $rows = self::q('p.wp_id = :w', ['locale' => $locale, 'locale2' => $locale, 'w' => $wpId]);
        return $rows[0] ?? null;
    }

    /** Catálogo visible (activos y "disponible pronto"). */
    public static function catalog(string $locale, array $filters = []): array
    {
        $where = 'p.status IN ("active","coming_soon")';
        $params = ['locale' => $locale, 'locale2' => $locale];
        if (!empty($filters['audience'])) {
            $where .= ' AND p.audience = :aud';
            $params['aud'] = $filters['audience'];
        }
        if (!empty($filters['family_id'])) {
            $where .= ' AND p.family_id = :fam';
            $params['fam'] = (int) $filters['family_id'];
        }
        if (!empty($filters['type'])) {
            $where .= ' AND p.type = :type';
            $params['type'] = $filters['type'];
        }
        return self::q($where, $params, 'p.status = "coming_soon", (p.legacy_sales + p.sales_count) DESC, p.featured DESC, p.sort, p.id');
    }

    public static function bestSellers(string $locale, int $limit = 6): array
    {
        return self::q(
            'p.status = "active" AND p.type <> "pack"',
            ['locale' => $locale, 'locale2' => $locale],
            '(p.legacy_sales + p.sales_count) DESC, p.featured DESC, p.id',
            $limit
        );
    }

    public static function byIds(array $ids, string $locale, bool $onlyVisible = true): array
    {
        $ids = array_values(array_filter(array_map('intval', $ids)));
        if ($ids === []) {
            return [];
        }
        $placeholders = [];
        $params = ['locale' => $locale, 'locale2' => $locale];
        foreach ($ids as $i => $id) {
            $placeholders[] = ":id$i";
            $params["id$i"] = $id;
        }
        $where = 'p.id IN (' . implode(',', $placeholders) . ')' . ($onlyVisible ? ' AND p.status IN ("active","coming_soon")' : '');
        $rows = self::q($where, $params);
        // Conserva el orden pedido.
        usort($rows, fn ($a, $b) => array_search((int) $a['id'], $ids, true) <=> array_search((int) $b['id'], $ids, true));
        return $rows;
    }

    public static function bySlugs(array $slugs, string $locale): array
    {
        if ($slugs === []) {
            return [];
        }
        $placeholders = [];
        $params = ['locale' => 'es', 'locale2' => 'es'];
        foreach (array_values($slugs) as $i => $slug) {
            $placeholders[] = ":s$i";
            $params["s$i"] = $slug;
        }
        // Los marcadores del contenido usan los slugs en español; se resuelven a ids y luego al idioma pedido.
        $ids = array_column(self::q('t.slug IN (' . implode(',', $placeholders) . ')', $params), 'id');
        return self::byIds($ids, $locale);
    }

    public static function sameFamily(array $product, int $limit = 3): array
    {
        if (empty($product['family_id'])) {
            return [];
        }
        return self::q(
            'p.family_id = :fam AND p.id <> :id AND p.status IN ("active","coming_soon")',
            ['locale' => $product['locale'], 'locale2' => $product['locale'], 'fam' => (int) $product['family_id'], 'id' => (int) $product['id']],
            '(p.legacy_sales + p.sales_count) DESC',
            $limit
        );
    }

    public static function images(int $productId): array
    {
        return DB::all('SELECT url, alt, width, height FROM product_images WHERE product_id = :id ORDER BY sort, id', ['id' => $productId]);
    }

    public static function files(int $productId): array
    {
        return DB::all('SELECT * FROM product_files WHERE product_id = :id ORDER BY id', ['id' => $productId]);
    }

    /**
     * Variantes que se pueden comprar (clave => nombre), según los archivos con `variant`.
     * Un producto sin archivos de variante devuelve []. Orden alfabético por nombre.
     * @return array<string, string>
     */
    public static function variants(int $productId, ?string $locale = null): array
    {
        return self::variantsFor([$productId], $locale)[$productId] ?? [];
    }

    /** @return array<int, array<string, string>> producto => [clave => nombre] */
    public static function variantsFor(array $productIds, ?string $locale = null): array
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $productIds))));
        if ($ids === []) {
            return [];
        }
        $placeholders = [];
        $params = [];
        foreach ($ids as $i => $id) {
            $placeholders[] = ":p$i";
            $params["p$i"] = $id;
        }
        $rows = DB::all(
            'SELECT product_id, variant, label FROM product_files
             WHERE product_id IN (' . implode(',', $placeholders) . ') AND variant IS NOT NULL AND variant <> "" ORDER BY id',
            $params
        );
        $out = [];
        foreach ($rows as $row) {
            $pid = (int) $row['product_id'];
            $key = (string) $row['variant'];
            $out[$pid][$key] ??= self::variantLabel($key, (string) $row['label'], $locale);
        }
        $collator = class_exists(\Collator::class) ? new \Collator($locale === 'en' ? 'en' : 'es') : null;
        foreach ($out as &$list) {
            $collator ? $collator->asort($list) : asort($list);
        }
        return $out;
    }

    /** Nombre visible de una variante: la cadena `variant.{clave}` del idioma si existe; si no, la etiqueta del archivo. */
    public static function variantLabel(string $key, string $fallback = '', ?string $locale = null): string
    {
        $locale ??= \App\Services\I18n\I18n::locale();
        if (\App\Services\I18n\I18n::has("variant.$key", $locale)) {
            return t("variant.$key", [], $locale);
        }
        return $fallback !== '' ? $fallback : $key;
    }

    public static function alternates(int $productId): array
    {
        $out = [];
        $status = DB::value('SELECT status FROM products WHERE id = :id', ['id' => $productId]);
        foreach (DB::all('SELECT locale, slug FROM product_translations WHERE product_id = :id', ['id' => $productId]) as $row) {
            $out[$row['locale']] = route('product', ['slug' => $row['slug']], $row['locale']);
        }
        return $status === 'hidden' ? [] : $out;
    }

    public static function faqs(array $product): array
    {
        $faqs = json_decode((string) ($product['faq_json'] ?? '[]'), true);
        return is_array($faqs) ? $faqs : [];
    }

    /** Precio que se cobra según el idioma: COP en español, USD en inglés. */
    public static function chargePrice(array $product, string $locale): float
    {
        return $locale === 'en' ? (float) $product['price_usd'] : (float) $product['price_cop'];
    }
}
