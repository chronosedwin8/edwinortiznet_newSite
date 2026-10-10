<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Importer\HtmlCleaner;
use App\Services\Importer\WxrImporter;

/*
 * Artículo de Concurso Docente "Constitución arts. 13, 44 y 67" (semana 14; solo español; norma + interpretación + dos casos; ficha de Excel verificada). Se inserta PROGRAMADO (status «scheduled», published_at en UTC): posts:publish-due lo publica el viernes 22 de enero de 2027 a las 7:00 a. m. de Bogotá. Idempotente: actualiza el
 * texto y conserva la fecha y el estado cambiados en el panel.
 */
return static function (): string {
    $files = ['constitucion-13-44-67'];
    $hubId = (int) DB::value('SELECT id FROM hubs WHERE `key` = "concurso-docente"');
    $productId = DB::value('SELECT id FROM products WHERE sku = "CONDOC20212022"');
    $public = dirname(__DIR__, 2) . '/public';
    $cleaner = new HtmlCleaner();
    $count = 0;

    foreach ($files as $key) {
        $a = require __DIR__ . "/data/$key.php";
        $html = $cleaner->sanitize($a['content_html'], ['title' => $a['title'], 'slug' => $a['slug']]);
        $text = HtmlCleaner::toText($html);
        $size = @getimagesize($public . $a['cover'] . '-960.webp') ?: [960, 540];
        $data = [
            'type' => 'post',
            'locale' => 'es',
            'translation_group' => WxrImporter::uuid('analisis-' . $key),
            'slug' => $a['slug'],
            'title' => $a['title'],
            'excerpt' => $a['excerpt'],
            'content_html' => $html,
            'content_text' => $text,
            'cover_url' => $a['cover'] . '-960.webp',
            'cover_alt' => $a['cover_alt'],
            'cover_width' => $size[0],
            'cover_height' => $size[1],
            'cover_srcset' => implode(', ', array_map(fn (int $w) => "{$a['cover']}-$w.webp {$w}w", [640, 960, 1440])),
            'hub_id' => $hubId ?: null,
            'related_product_id' => $productId !== null ? (int) $productId : null,
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
            DB::insert('posts', $data + ['published_at' => $a['published_at'], 'status' => 'scheduled']);
        } else {
            DB::update('posts', $data, ['id' => (int) $existing['id']]);
        }
        $count++;
    }
    return "$count artículo(s): Constitución arts. 13, 44 y 67 (programado)";
};
