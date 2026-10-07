<?php

declare(strict_types=1);

namespace App\Admin;

use App\Controllers\ContentController;
use App\Core\App;
use App\Core\DB;

/**
 * Slugs que comparten la ruta comodín /{slug}/ (entradas, páginas y secciones): no pueden chocar entre sí
 * ni con una ruta fija del sitio (/blog/, /tienda/, /en/…).
 */
final class Slugs
{
    /** ¿La URL /{slug}/ (o /en/{slug}/) la atiende otra ruta antes que la comodín? */
    public static function reserved(string $locale, string $slug): bool
    {
        $path = ($locale === 'en' ? '/en/' : '/') . $slug . '/';
        $match = App::router()->match('GET', $path);
        return isset($match['route']) && $match['route']['handler'] !== [ContentController::class, 'show'];
    }

    /** ¿Lo usa ya una sección (distinta de $exceptHub)? */
    public static function hubTaken(string $locale, string $slug, int $exceptHub = 0): bool
    {
        return DB::value('SELECT id FROM hub_translations WHERE locale = ? AND slug = ? AND hub_id <> ?', [$locale, $slug, $exceptHub]) !== null;
    }

    /** ¿Lo usa ya una entrada, página o política (en cualquier estado)? */
    public static function postTaken(string $locale, string $slug, int $exceptPost = 0): bool
    {
        return DB::value('SELECT id FROM posts WHERE locale = ? AND slug = ? AND id <> ?', [$locale, $slug, $exceptPost]) !== null;
    }
}
