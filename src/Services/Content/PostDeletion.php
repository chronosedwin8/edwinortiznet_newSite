<?php

declare(strict_types=1);

namespace App\Services\Content;

use App\Core\DB;
use App\Models\Hub;
use App\Services\Seo\Redirects;

/**
 * Borrado de artículos, páginas y políticas desde el panel.
 *
 * - Se borra la fila y sus relaciones (post_category por clave foránea; products.tutorial_post_id queda en NULL).
 *   Las imágenes siguen en la biblioteca de medios.
 * - La traducción solo se borra si se pide: si un grupo pierde un idioma, el otro sigue funcionando sin hreflang.
 * - Si el post era la guía principal de una sección, la sección pasa a su traducción (o queda sin guía).
 * - Lo publicado puede dejar una redirección 301: artículos → su sección o el blog; páginas y políticas → inicio.
 * - Las páginas de las que depende el sitio (sobre mí, políticas legales, cursos) no se pueden borrar.
 */
final class PostDeletion
{
    /** Páginas que el código busca por slug (rutas /sobre-mi/, /politicas/…, /cursos/, pie de página y pago). */
    public const PROTECTED = [
        'es' => ['sobre-mi', 'privacidad', 'terminos', 'reembolsos', 'cookies', 'cursos-de-informatica-y-tecnologia'],
        'en' => ['about', 'privacy', 'terms', 'refunds', 'cookies'],
    ];

    public static function isProtected(array $post): bool
    {
        return in_array($post['slug'], self::PROTECTED[$post['locale']] ?? [], true);
    }

    /** A dónde se manda a quien llegue a la URL de un post borrado. */
    public static function redirectTarget(array $post): string
    {
        $locale = $post['locale'] === 'en' ? 'en' : 'es';
        if ($post['type'] !== 'post') {
            return route('home', [], $locale);
        }
        $hub = !empty($post['hub_id']) ? Hub::byId((int) $post['hub_id'], $locale) : null;
        return $hub !== null && $hub['key'] !== 'herramientas' ? Hub::path($hub) : route('blog', [], $locale);
    }

    /**
     * @param int[] $ids
     * @return array{deleted: array<int, array>, protected: array<int, array>}
     */
    public static function delete(array $ids, bool $withTranslations, bool $redirect): array
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids), fn (int $id) => $id > 0)));
        if ($ids === []) {
            return ['deleted' => [], 'protected' => []];
        }
        $columns = 'id, type, locale, slug, title, status, hub_id, translation_group';
        $posts = DB::all("SELECT $columns FROM posts WHERE id IN (" . DB::in($ids) . ')', $ids);
        if ($withTranslations && $posts !== []) {
            $groups = array_values(array_unique(array_column($posts, 'translation_group')));
            $posts = DB::all("SELECT $columns FROM posts WHERE id IN (" . DB::in($ids) . ') OR translation_group IN (' . DB::in($groups) . ')', [...$ids, ...$groups]);
        }
        $deleted = [];
        $protected = [];
        foreach ($posts as $post) {
            if (self::isProtected($post)) {
                $protected[] = $post;
            } else {
                $deleted[] = $post;
            }
        }
        if ($deleted === []) {
            return ['deleted' => [], 'protected' => $protected];
        }

        DB::transaction(function () use ($deleted, $redirect): void {
            $gone = array_map('intval', array_column($deleted, 'id'));
            foreach ($deleted as $post) {
                // Guía principal de una sección: pasa a la traducción que sobreviva, o se quita.
                foreach (DB::column('SELECT id FROM hubs WHERE pillar_post_id = ?', [(int) $post['id']]) as $hubId) {
                    $survivor = DB::value(
                        'SELECT id FROM posts WHERE translation_group = ? AND id NOT IN (' . DB::in($gone) . ') ORDER BY locale = "es" DESC LIMIT 1',
                        [$post['translation_group'], ...$gone]
                    );
                    DB::run('UPDATE hubs SET pillar_post_id = ? WHERE id = ?', [$survivor !== null ? (int) $survivor : null, (int) $hubId]);
                }
                if ($redirect && $post['status'] !== 'draft') {
                    Redirects::add(post_path($post), self::redirectTarget($post), 'Eliminado en el panel: ' . $post['title']);
                }
            }
            DB::run('DELETE FROM posts WHERE id IN (' . DB::in($gone) . ')', $gone);
        });
        return ['deleted' => $deleted, 'protected' => $protected];
    }
}
