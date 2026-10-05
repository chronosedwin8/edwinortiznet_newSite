<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Core\Config;
use App\Core\DB;
use App\Models\Hub;
use App\Services\Tools\ToolRegistry;

/**
 * /sitemap.xml dinámico con lastmod y alternativas hreflang (xhtml:link). Excluye noindex.
 */
final class Sitemap
{
    /** @var array<int, array{loc:string, lastmod:?string, alternates:array<string,string>}> */
    private array $urls = [];

    private function add(string $path, ?string $lastmod, array $alternates = []): void
    {
        $this->urls[] = ['loc' => url($path), 'lastmod' => $lastmod, 'alternates' => array_map('url', $alternates)];
    }

    public static function build(): string
    {
        $xml = (new self())->collect()->render();
        @file_put_contents(Config::storage('cache/sitemap.xml'), $xml);
        return $xml;
    }

    public static function cached(): string
    {
        $file = Config::storage('cache/sitemap.xml');
        if (is_file($file) && filemtime($file) > time() - 86400) {
            return (string) file_get_contents($file);
        }
        return self::build();
    }

    private function collect(): self
    {
        $lastPost = (string) DB::value('SELECT MAX(COALESCE(updated_at, published_at)) FROM posts WHERE status = "published"');
        $lastProduct = (string) DB::value('SELECT MAX(updated_at) FROM products');
        $pair = static fn (string $name, array $params = []) => ['es' => route($name, $params, 'es'), 'en' => route($name, $params, 'en')];

        foreach (['home' => $lastPost, 'blog' => $lastPost, 'shop' => $lastProduct, 'tools' => $lastPost, 'contact' => null] as $name => $mod) {
            $alts = $pair($name);
            $this->add($alts['es'], $mod, $alts);
            $this->add($alts['en'], $mod, $alts);
        }
        $this->add(route('courses', [], 'es'), $lastProduct, []);

        // Hubs
        foreach (DB::all('SELECT h.id, h.`key`, h.updated_at FROM hubs h WHERE h.`key` <> "herramientas"') as $hub) {
            $alts = Hub::alternates((int) $hub['id']);
            $alts = count($alts) === 2 ? $alts : [];
            foreach (Hub::alternates((int) $hub['id']) as $path) {
                $this->add($path, $hub['updated_at'], $alts);
            }
        }

        // Herramientas
        foreach (['qr', 'words', 'quiz'] as $key) {
            $alts = ToolRegistry::alternates($key);
            foreach ($alts as $path) {
                $this->add($path, null, count($alts) === 2 ? $alts : []);
            }
        }

        // Entradas, páginas y políticas publicadas (sin noindex ni borradores)
        $rows = DB::all('SELECT id, type, locale, slug, translation_group, COALESCE(updated_at, published_at) AS lastmod FROM posts WHERE status = "published" ORDER BY published_at DESC');
        $groups = [];
        foreach ($rows as $row) {
            $groups[$row['translation_group']][$row['locale']] = $row;
        }
        foreach ($rows as $row) {
            $path = match (true) {
                $row['type'] === 'page' && $row['slug'] === 'sobre-mi' => route('about', [], 'es'),
                $row['type'] === 'page' && $row['slug'] === 'about' && $row['locale'] === 'en' => route('about', [], 'en'),
                default => post_path($row),
            };
            if ($row['type'] === 'post' && DB::value('SELECT canonical_url FROM posts WHERE id = :id', ['id' => (int) $row['id']])) {
                continue; // su canonical apunta a otra URL
            }
            $alts = [];
            if (count($groups[$row['translation_group']]) === 2) {
                foreach ($groups[$row['translation_group']] as $lang => $r) {
                    $alts[$lang] = $r['type'] === 'page' && in_array($r['slug'], ['sobre-mi', 'about'], true) ? route('about', [], $lang) : post_path($r);
                }
            }
            $this->add($path, $row['lastmod'], $alts);
        }

        // Productos visibles
        $products = DB::all('SELECT p.id, p.updated_at, t.locale, t.slug FROM products p JOIN product_translations t ON t.product_id = p.id WHERE p.status IN ("active","coming_soon")');
        $byProduct = [];
        foreach ($products as $p) {
            $byProduct[$p['id']][$p['locale']] = $p;
        }
        foreach ($byProduct as $versions) {
            $alts = [];
            if (count($versions) === 2) {
                foreach ($versions as $lang => $v) {
                    $alts[$lang] = route('product', ['slug' => $v['slug']], $lang);
                }
            }
            foreach ($versions as $lang => $v) {
                $this->add(route('product', ['slug' => $v['slug']], $lang), $v['updated_at'], $alts);
            }
        }

        // Familias
        $fams = DB::all('SELECT family_id, locale, slug FROM product_family_translations');
        $byFamily = [];
        foreach ($fams as $f) {
            $byFamily[$f['family_id']][$f['locale']] = route('shop.family', ['slug' => $f['slug']], $f['locale']);
        }
        foreach ($byFamily as $versions) {
            foreach ($versions as $path) {
                $this->add($path, $lastProduct, count($versions) === 2 ? $versions : []);
            }
        }
        return $this;
    }

    private function render(): string
    {
        $out = '<?xml version="1.0" encoding="UTF-8"?>' . "\n"
            . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
        $seen = [];
        foreach ($this->urls as $u) {
            if (isset($seen[$u['loc']])) {
                continue;
            }
            $seen[$u['loc']] = true;
            $out .= "  <url>\n    <loc>" . htmlspecialchars($u['loc'], ENT_XML1) . "</loc>\n";
            if ($u['lastmod']) {
                $out .= '    <lastmod>' . gmdate('Y-m-d\TH:i:s\Z', (int) strtotime($u['lastmod'] . ' UTC')) . "</lastmod>\n";
            }
            if (count($u['alternates']) === 2) {
                foreach ($u['alternates'] as $lang => $href) {
                    $out .= '    <xhtml:link rel="alternate" hreflang="' . ($lang === 'es' ? 'es-CO' : 'en') . '" href="' . htmlspecialchars($href, ENT_XML1) . "\"/>\n";
                }
                $out .= '    <xhtml:link rel="alternate" hreflang="x-default" href="' . htmlspecialchars($u['alternates']['es'], ENT_XML1) . "\"/>\n";
            }
            $out .= "  </url>\n";
        }
        return $out . "</urlset>\n";
    }
}
