<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\DB;
use App\Services\Tools\ToolRegistry;

/**
 * Contenido que se puede compartir: entradas y páginas publicadas en español, productos activos y herramientas.
 *
 * Cada elemento: key ("post:12"), type, id, title, summary, body (texto para la IA), path, cover, srcset,
 * hub_key, hub_title, published_at y, en productos, sku, audience y price_cop.
 */
final class Catalog
{
    /** Datos extra de las herramientas (no tienen portada propia ni fecha). */
    private const TOOL_INFO = [
        'fundales' => ['cover' => null, 'hub' => 'concurso-docente', 'summary' => 'fundales.seo_description'],
        'piar' => ['cover' => '/assets/img/productos/piar/piar-con-ia-10-planes-1440.webp', 'hub' => 'ia-para-docentes', 'summary' => 'tool.piar.summary',
            'facts' => 'Redacta el Plan Individual de Ajustes Razonables (Decreto 1421 de 2017) con inteligencia artificial: tiene prueba gratis, se edita por secciones y se descarga en PDF formal con acta de acuerdo.'],
        'examenes' => ['cover' => '/assets/img/articulos/examenes/examenes-papel-1440.webp', 'hub' => 'ia-para-docentes', 'summary' => 'tool.examenes.summary',
            'facts' => 'Genera exámenes con IA por materia y grado, hasta 8 versiones, hoja de respuestas, solucionario, fórmulas LaTeX y PDF listo para imprimir. Tiene un simulador gratuito.'],
        'qr' => ['cover' => null, 'hub' => 'excel', 'summary' => 'tool.qr.seo_description'],
        'words' => ['cover' => null, 'hub' => 'excel', 'summary' => 'tool.words.seo_description'],
    ];

    /** @return array<int, array> elementos que cumplen la regla de contenido del canal */
    public static function candidates(array $rule): array
    {
        $rule = Channels::normalizeContent($rule);
        $items = [];
        $postTypes = array_values(array_intersect($rule['types'], ['post', 'page']));
        if ($postTypes !== []) {
            foreach (self::posts($postTypes) as $item) {
                if (self::hubAllowed($item, $rule)) {
                    $items[] = $item;
                }
            }
        }
        if (in_array('product', $rule['types'], true)) {
            foreach (self::products() as $item) {
                if (self::productAllowed($item, $rule)) {
                    $items[] = $item;
                }
            }
        }
        if (in_array('tool', $rule['types'], true)) {
            foreach (self::tools() as $item) {
                if (in_array($item['id_key'], $rule['tools'], true)) {
                    $items[] = $item;
                }
            }
        }
        return $items;
    }

    public static function item(string $key): ?array
    {
        if (!preg_match('/^(post|page|product|tool):([a-z0-9_\-]{1,60})$/', $key, $m)) {
            return null;
        }
        if ($m[1] === 'tool') {
            foreach (self::tools() as $item) {
                if ($item['id_key'] === $m[2]) {
                    return $item;
                }
            }
            return null;
        }
        if ($m[1] === 'product') {
            return self::products((int) $m[2])[0] ?? null;
        }
        return self::posts([$m[1]], (int) $m[2])[0] ?? null;
    }

    private static function hubAllowed(array $item, array $rule): bool
    {
        $hub = (string) ($item['hub_key'] ?? '');
        if ($hub !== '' && in_array($hub, $rule['hubs_exclude'], true)) {
            return false;
        }
        if ($rule['hubs_include'] !== [] && $item['type'] === 'post') {
            return in_array($hub, $rule['hubs_include'], true);
        }
        // Las páginas no tienen hub: solo entran si el canal no se limita a ciertos hubs.
        return $rule['hubs_include'] === [] || $item['type'] !== 'page';
    }

    private static function productAllowed(array $item, array $rule): bool
    {
        $sku = (string) ($item['sku'] ?? '');
        foreach ($rule['exclude_skus'] as $pattern) {
            if ($sku !== '' && ($pattern === $sku || (str_ends_with($pattern, '*') && str_starts_with($sku, rtrim($pattern, '*'))))) {
                return false;
            }
        }
        if ($rule['skus'] !== []) {
            return in_array($sku, $rule['skus'], true);
        }
        return in_array($item['audience'], $rule['audiences'], true);
    }

    /** @param string[] $types */
    private static function posts(array $types, ?int $id = null): array
    {
        $params = [];
        $where = "p.locale = 'es' AND p.status = 'published' AND p.published_at <= UTC_TIMESTAMP() AND p.type IN (" . DB::in($types) . ')';
        $params = array_values($types);
        if ($id !== null) {
            $where .= ' AND p.id = ?';
            $params[] = $id;
        }
        $rows = DB::all(
            "SELECT p.id, p.type, p.locale, p.slug, p.title, p.excerpt, p.seo_description, LEFT(p.content_text, 1800) AS body, p.cover_url, p.cover_srcset, p.published_at,
                COALESCE(p.hub_id, (SELECT c.hub_id FROM post_category pc JOIN categories c ON c.id = pc.category_id
                                    WHERE pc.post_id = p.id AND c.hub_id IS NOT NULL ORDER BY pc.is_primary DESC LIMIT 1)) AS hub
             FROM posts p WHERE $where ORDER BY p.published_at DESC",
            $params
        );
        $hubs = self::hubs();
        $out = [];
        foreach ($rows as $r) {
            $hub = $r['hub'] !== null ? ($hubs[(int) $r['hub']] ?? null) : null;
            $out[] = [
                'key' => $r['type'] . ':' . $r['id'],
                'type' => $r['type'],
                'id' => (int) $r['id'],
                'id_key' => (string) $r['id'],
                'title' => (string) $r['title'],
                'summary' => excerpt_text((string) ($r['seo_description'] ?: $r['excerpt'] ?: $r['body']), 300),
                'body' => (string) $r['body'],
                'path' => post_path($r),
                'cover' => $r['cover_url'] ?: null,
                'srcset' => $r['cover_srcset'] ?: null,
                'hub_key' => $hub['key'] ?? null,
                'hub_title' => $hub['title'] ?? null,
                'published_at' => $r['published_at'],
            ];
        }
        return $out;
    }

    private static function products(?int $id = null): array
    {
        $rows = DB::all(
            "SELECT p.id, p.sku, p.type AS ptype, p.audience, p.price_cop, p.cover_url, p.cover_srcset, p.created_at, t.slug, t.title, t.short_html, t.description_html, t.seo_description
             FROM products p JOIN product_translations t ON t.product_id = p.id AND t.locale = 'es'
             WHERE p.status = 'active'" . ($id !== null ? ' AND p.id = :id' : '') . ' ORDER BY p.sort, p.id',
            $id !== null ? ['id' => $id] : []
        );
        $out = [];
        foreach ($rows as $r) {
            $out[] = [
                'key' => 'product:' . $r['id'],
                'type' => 'product',
                'id' => (int) $r['id'],
                'id_key' => (string) $r['id'],
                'title' => (string) $r['title'],
                'summary' => $r['seo_description'] ? excerpt_text((string) $r['seo_description'], 300) : product_blurb($r, 300),
                'body' => excerpt_text(strip_tags((string) $r['description_html']), 1500),
                'path' => product_path($r, 'es'),
                'cover' => $r['cover_url'] ?: null,
                'srcset' => $r['cover_srcset'] ?: null,
                'hub_key' => null,
                'hub_title' => null,
                'published_at' => $r['created_at'],
                'sku' => $r['sku'],
                'audience' => $r['audience'],
                'price_cop' => (int) $r['price_cop'],
                'product_type' => $r['ptype'],
            ];
        }
        return $out;
    }

    private static function tools(): array
    {
        $hubs = array_column(self::hubs(), 'title', 'key');
        $out = [];
        foreach (ToolRegistry::forLocale('es') as $tool) {
            $key = (string) $tool['key'];
            $info = self::TOOL_INFO[$key] ?? ['cover' => null, 'hub' => null, 'summary' => "tool.$key.summary"];
            $summary = t($info['summary'], [], 'es');
            $out[] = [
                'key' => 'tool:' . $key,
                'type' => 'tool',
                'id' => null,
                'id_key' => $key,
                'title' => t("tool.$key.name", [], 'es'),
                'summary' => $summary,
                'body' => trim($summary . ' ' . ($info['facts'] ?? '')),
                'path' => route('tool', ['slug' => $tool['slug']], 'es'),
                'cover' => $info['cover'],
                'srcset' => null,
                'hub_key' => $info['hub'],
                'hub_title' => $info['hub'] !== null ? ($hubs[$info['hub']] ?? null) : null,
                'published_at' => null,
            ];
        }
        return $out;
    }

    /** @return array<int, array{key:string, title:string}> */
    private static function hubs(): array
    {
        static $cache = null;
        if ($cache === null) {
            $cache = [];
            foreach (DB::all("SELECT h.id, h.`key`, t.title FROM hubs h LEFT JOIN hub_translations t ON t.hub_id = h.id AND t.locale = 'es'") as $h) {
                $cache[(int) $h['id']] = ['key' => (string) $h['key'], 'title' => (string) ($h['title'] ?? $h['key'])];
            }
        }
        return $cache;
    }

    /** Hubs para el formulario del canal. @return array<string, string> key => título */
    public static function hubOptions(): array
    {
        return array_column(self::hubs(), 'title', 'key');
    }

    /** Herramientas para el formulario del canal. @return array<string, string> key => nombre */
    public static function toolOptions(): array
    {
        $out = [];
        foreach (ToolRegistry::forLocale('es') as $tool) {
            $out[(string) $tool['key']] = t('tool.' . $tool['key'] . '.name', [], 'es');
        }
        return $out;
    }
}
