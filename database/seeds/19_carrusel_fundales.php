<?php

declare(strict_types=1);

use App\Core\DB;
use App\Services\Content\CarouselConverter;
use App\Services\Importer\HtmlCleaner;

/*
 * Artículo «Concurso Docente 2026: guía definitiva…» (español): las capturas de Fundales de la sección
 * «La Mejor Herramienta de Preparación: Fundales.com» pasan a un solo carrusel de imágenes (.carousel-gallery),
 * con sus textos alternativos y pies de foto. Ubica la sección por el texto del encabezado y toma las imágenes
 * seguidas hasta el siguiente encabezado (CarouselConverter). Idempotente: si ya hay un carrusel, no cambia nada.
 * No toca updated_at (no es un cambio de contenido). En producción: php bin/console seed 19_carrusel
 */
return static function (): string {
    $slug = 'concurso-docente-2026-guia-definitiva-con-estrategias-normativa-y-simulacros-con-ia';
    $post = DB::one('SELECT id, slug, title, content_html FROM posts WHERE locale = "es" AND slug = :s', ['s' => $slug]);
    if ($post === null) {
        return 'No está el artículo del Concurso Docente 2026: sin cambios.';
    }
    $result = CarouselConverter::section(
        (string) $post['content_html'],
        ['La Mejor Herramienta de Preparación', 'Herramienta de Preparación: Fundales'],
        new HtmlCleaner(),
        ['title' => (string) $post['title'], 'slug' => (string) $post['slug']]
    );
    if (!$result['changed']) {
        return $result['message'];
    }
    DB::update('posts', [
        'content_html' => $result['html'],
        'content_text' => HtmlCleaner::toText($result['html']),
    ], ['id' => (int) $post['id']]);
    return $result['message'] . ' Textos alternativos: ' . implode(' | ', array_unique($result['alts']));
};
