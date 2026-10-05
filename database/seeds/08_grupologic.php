<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Importer\HtmlCleaner;
use App\Services\Importer\WxrImporter;

/*
 * Artículos descriptivos sobre las herramientas de Grupo Logic (grupologiclatam.com/productos/),
 * con ideas de uso en el aula. Textos en database/seeds/data/grupologic-*.php; imágenes en
 * public/assets/img/articulos/grupologic/. Es idempotente: al repetirlo actualiza el texto
 * pero conserva la fecha de publicación y el estado que se haya cambiado en el panel.
 */
return static function (): string {
    $articles = array_merge(
        require __DIR__ . '/data/grupologic-1.php',
        require __DIR__ . '/data/grupologic-2.php',
        require __DIR__ . '/data/grupologic-3.php',
    );
    $hubId = (int) DB::value('SELECT id FROM hubs WHERE `key` = "ia-para-docentes"');
    $dir = '/assets/img/articulos/grupologic/';
    $public = dirname(__DIR__, 2) . '/public';
    $cleaner = new HtmlCleaner();
    $start = new DateTimeImmutable('2026-10-05 13:00:00', new DateTimeZone('UTC'));
    $count = 0;

    foreach (array_values(array_keys($articles)) as $i => $key) {
        $a = $articles[$key];
        $html = $cleaner->sanitize($a['content_html'], ['title' => $a['title'], 'slug' => $a['slug']]);
        $text = HtmlCleaner::toText($html);
        $size = @getimagesize($public . $dir . $a['cover'] . '-960.webp') ?: [960, 540];
        $data = [
            'type' => 'post',
            'locale' => 'es',
            'translation_group' => WxrImporter::uuid('grupologic-' . $key),
            'slug' => $a['slug'],
            'title' => $a['title'],
            'excerpt' => $a['excerpt'],
            'content_html' => $html,
            'content_text' => $text,
            'cover_url' => $dir . $a['cover'] . '-960.webp',
            'cover_alt' => $a['cover_alt'],
            'cover_width' => $size[0],
            'cover_height' => $size[1],
            'cover_srcset' => implode(', ', array_map(fn (int $w) => "$dir{$a['cover']}-$w.webp {$w}w", [640, 960, 1440])),
            'hub_id' => $hubId ?: null,
            'seo_title' => $a['seo_title'],
            'seo_description' => $a['seo_description'],
            'seo_auto' => 0,
            'focus_keyword' => $a['focus_keyword'],
            'reading_minutes' => HtmlCleaner::readingMinutes($text),
            'needs_review' => 0,
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];
        $existing = DB::one('SELECT id FROM posts WHERE locale = "es" AND slug = :s', ['s' => $a['slug']]);
        if ($existing === null) {
            // Una por hora para que el orden del blog sea estable.
            $data['published_at'] = $start->modify("-$i hours")->format('Y-m-d H:i:s');
            $data['status'] = 'published';
            DB::insert('posts', $data);
        } else {
            DB::update('posts', $data, ['id' => (int) $existing['id']]);
        }
        $count++;
    }
    return "$count artículos de Grupo Logic";
};
