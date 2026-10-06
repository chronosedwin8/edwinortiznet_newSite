<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Importer\HtmlCleaner;

/*
 * Versiones en inglés de los artículos nuevos (Grupo Logic, pasarelas de pago y análisis educativo).
 * Textos en database/seeds/en/data/recent-*.php, indexados por el slug en español. Los enlaces
 * internos se escriben con la ruta en español y aquí se cambian por la versión en inglés cuando
 * existe. Es idempotente: actualiza el texto y conserva el estado cambiado en el panel.
 */
return static function (): string {
    $articles = [];
    foreach (glob(__DIR__ . '/data/recent-*.php') ?: [] as $file) {
        $articles += require $file;
    }
    $public = dirname(__DIR__, 3) . '/public';
    $cleaner = new HtmlCleaner();

    // Mapa ES → EN de todo lo que ya tiene versión en inglés, más los artículos de este seed.
    $map = ['/sobre-mi/' => '/en/about/', '/contacto/' => '/en/contact/', '/tienda/' => '/en/shop/', '/blog/' => '/en/blog/'];
    foreach (DB::all('SELECT es.slug AS es, en.slug AS en FROM posts es JOIN posts en ON en.translation_group = es.translation_group AND en.locale = "en" WHERE es.locale = "es" AND es.type = "post"') as $r) {
        $map["/{$r['es']}/"] = "/en/{$r['en']}/";
    }
    foreach (DB::all('SELECT es.slug AS es, en.slug AS en FROM product_translations es JOIN product_translations en ON en.product_id = es.product_id AND en.locale = "en" WHERE es.locale = "es"') as $r) {
        $map["/producto/{$r['es']}/"] = "/en/product/{$r['en']}/";
    }
    foreach (DB::all('SELECT es.slug AS es, en.slug AS en FROM hub_translations es JOIN hub_translations en ON en.hub_id = es.hub_id AND en.locale = "en" WHERE es.locale = "es"') as $r) {
        $map["/{$r['es']}/"] = "/en/{$r['en']}/";
    }
    foreach ($articles as $esSlug => $a) {
        $map["/$esSlug/"] = "/en/{$a['slug']}/";
    }
    $rewrite = static fn (string $html): string => (string) preg_replace_callback('#href="(/[^"\#?]*)([^"]*)"#', static function (array $m) use ($map): string {
        $path = rtrim($m[1], '/') . '/';
        return isset($map[$path]) ? 'href="' . $map[$path] . $m[2] . '"' : $m[0];
    }, $html);

    $count = 0;
    foreach ($articles as $esSlug => $a) {
        $source = DB::one('SELECT * FROM posts WHERE locale = "es" AND slug = :s', ['s' => $esSlug]);
        if ($source === null) {
            continue;
        }
        $html = $rewrite($cleaner->sanitize($a['content_html'], ['title' => $a['title'], 'slug' => $a['slug']]));
        $text = HtmlCleaner::toText($html);
        $cover = [
            'cover_url' => $source['cover_url'], 'cover_srcset' => $source['cover_srcset'],
            'cover_width' => $source['cover_width'], 'cover_height' => $source['cover_height'],
        ];
        if (!empty($a['cover'])) {
            $size = @getimagesize($public . $a['cover'] . '-960.webp') ?: [960, 540];
            $cover = [
                'cover_url' => $a['cover'] . '-960.webp',
                'cover_srcset' => implode(', ', array_map(fn (int $w) => "{$a['cover']}-$w.webp {$w}w", [640, 960, 1440])),
                'cover_width' => $size[0], 'cover_height' => $size[1],
            ];
        }
        $data = $cover + [
            'type' => 'post',
            'locale' => 'en',
            'translation_group' => $source['translation_group'],
            'slug' => $a['slug'],
            'title' => $a['title'],
            'excerpt' => $a['excerpt'],
            'content_html' => $html,
            'content_text' => $text,
            'cover_alt' => $a['cover_alt'],
            'hub_id' => $source['hub_id'],
            'related_product_id' => $source['related_product_id'],
            'seo_title' => $a['seo_title'],
            'seo_description' => $a['seo_description'],
            'seo_auto' => 0,
            'focus_keyword' => $a['focus_keyword'],
            'reading_minutes' => HtmlCleaner::readingMinutes($text),
            'needs_review' => 0,
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];
        $existing = DB::one('SELECT id FROM posts WHERE locale = "en" AND translation_group = :g', ['g' => $source['translation_group']]);
        if ($existing === null) {
            $postId = (int) DB::insert('posts', $data + ['published_at' => $source['published_at'], 'status' => $source['status']]);
        } else {
            $postId = (int) $existing['id'];
            DB::update('posts', $data, ['id' => $postId]);
        }
        DB::run('INSERT IGNORE INTO post_category (post_id, category_id, is_primary) SELECT :n, category_id, is_primary FROM post_category WHERE post_id = :s', ['n' => $postId, 's' => (int) $source['id']]);
        $count++;
    }
    return "$count artículo(s) recientes en inglés";
};
