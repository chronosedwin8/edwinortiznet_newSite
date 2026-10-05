<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Importer\HtmlCleaner;
use App\Services\Importer\WxrImporter;

/*
 * Serie sobre pasarelas de pago (experiencia propia): Mercado Pago y Paddle, enlazados entre sí
 * y con el artículo existente de Wompi. Es idempotente: actualiza el texto y conserva la fecha
 * de publicación y el estado que se haya cambiado en el panel.
 */
return static function (): string {
    $articles = [
        'mercado-pago' => [require __DIR__ . '/data/mercado-pago.php', '2026-10-05 15:00:00'],
        'paddle' => [require __DIR__ . '/data/paddle.php', '2026-10-05 15:30:00'],
    ];
    $public = dirname(__DIR__, 2) . '/public';
    $cleaner = new HtmlCleaner();

    foreach ($articles as $key => [$a, $publishedAt]) {
        $dir = "/assets/img/articulos/$key/";
        $html = $cleaner->sanitize($a['content_html'], ['title' => $a['title'], 'slug' => $a['slug']]);
        $text = HtmlCleaner::toText($html);
        $size = @getimagesize($public . $dir . $a['cover'] . '-960.webp') ?: [960, 540];
        $data = [
            'type' => 'post',
            'locale' => 'es',
            'translation_group' => WxrImporter::uuid('pasarelas-' . $key),
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
            'hub_id' => null,
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
            DB::insert('posts', $data + ['published_at' => $publishedAt, 'status' => 'published']);
        } else {
            DB::update('posts', $data, ['id' => (int) $existing['id']]);
        }
    }

    // El artículo de Wompi enlaza a los dos nuevos (una sola vez).
    $wompi = DB::one('SELECT id, content_html FROM posts WHERE locale = "es" AND slug = "todo-lo-que-debes-saber-sobre-wompi-bancolombia"');
    if ($wompi !== null && !str_contains((string) $wompi['content_html'], '/mercado-pago-pagos-rechazados-montos-altos/')) {
        $more = '<p class="notice"><strong>Lee también:</strong> '
            . '<a href="/mercado-pago-pagos-rechazados-montos-altos/">por qué Mercado Pago rechazó mis pagos altos</a> y '
            . '<a href="/paddle-cuenta-cerrada-verificacion-dominio-software-ia/">cómo Paddle cerró mi cuenta por sus políticas para software</a>. '
            . 'Juntos forman una guía de lo que nadie te cuenta antes de elegir pasarela de pagos.</p>';
        $html = rtrim((string) $wompi['content_html']) . "\n\n" . $more;
        DB::update('posts', ['content_html' => $html, 'content_text' => HtmlCleaner::toText($html), 'updated_at' => gmdate('Y-m-d H:i:s')], ['id' => (int) $wompi['id']]);
    }
    return '2 artículos sobre pasarelas (Mercado Pago, Paddle) enlazados con Wompi';
};
