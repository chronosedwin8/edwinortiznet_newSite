<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Services\Importer\HtmlCleaner;
use App\Services\Seo\Redirects;

/**
 * Secciones temáticas (hubs): introducción, preguntas frecuentes, SEO y guía pilar, en español e inglés.
 * Su URL es /{slug}/ (o /en/{slug}/), la misma ruta comodín de las entradas: el slug no puede repetirse
 * con una entrada ni con una ruta fija. "Mostrar en el menú" las pone en el menú principal y en la portada.
 */
final class HubsController extends AdminBase
{
    /** Secciones que el código usa por su clave (portada, herramientas, concurso, marcadores {{articulos:…}}). */
    public const CORE_KEYS = ['excel', 'ia-para-docentes', 'concurso-docente', 'herramientas'];

    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $hubs = DB::all(
            'SELECT h.id, h.`key`, h.sort, h.in_menu, es.title AS title_es, es.slug AS slug_es, en.title AS title_en, en.slug AS slug_en,
                    en.needs_review AS en_review, (SELECT COUNT(*) FROM posts p WHERE p.hub_id = h.id AND p.status = "published") AS posts
             FROM hubs h
             LEFT JOIN hub_translations es ON es.hub_id = h.id AND es.locale = "es"
             LEFT JOIN hub_translations en ON en.hub_id = h.id AND en.locale = "en"
             ORDER BY h.sort, h.id'
        );
        return $this->view('hubs/index', ['hubs' => $hubs], t('admin.hubs'));
    }

    public function create(Request $request): Response
    {
        $this->requireAdmin($request);
        $hub = ['id' => null, 'key' => '', 'sort' => (int) DB::value('SELECT COALESCE(MAX(sort), 0) + 1 FROM hubs'), 'in_menu' => 1, 'pillar_post_id' => null];
        return $this->view('hubs/edit', ['hub' => $hub, 'translations' => [], 'pillars' => [], 'postCount' => 0], t('admin.hubs.new'));
    }

    public function edit(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $hub = DB::one('SELECT * FROM hubs WHERE id = :id', ['id' => (int) $id]) ?? throw HttpException::notFound();
        $translations = [];
        foreach (DB::all('SELECT * FROM hub_translations WHERE hub_id = :id', ['id' => $hub['id']]) as $row) {
            $translations[$row['locale']] = $row;
        }
        $pillars = DB::all('SELECT id, title FROM posts WHERE locale = "es" AND type = "post" AND status <> "draft" AND hub_id = :h ORDER BY title', ['h' => $hub['id']]);
        return $this->view('hubs/edit', [
            'hub' => $hub,
            'translations' => $translations,
            'pillars' => $pillars,
            'postCount' => (int) DB::value('SELECT COUNT(*) FROM posts WHERE hub_id = :h', ['h' => $hub['id']]),
        ], t('admin.hubs.edit', ['name' => $translations['es']['title'] ?? $hub['key']]));
    }

    public function store(Request $request): Response
    {
        $this->requireAdmin($request);
        return $this->save($request, null);
    }

    public function update(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $hub = DB::one('SELECT * FROM hubs WHERE id = :id', ['id' => (int) $id]) ?? throw HttpException::notFound();
        return $this->save($request, $hub);
    }

    private function save(Request $request, ?array $hub): Response
    {
        $back = $hub ? "/admin/secciones/{$hub['id']}/" : '/admin/secciones/nueva/';
        $hubId = (int) ($hub['id'] ?? 0);
        $cleaner = new HtmlCleaner();

        // 1. Validar todo antes de escribir nada.
        $rows = [];
        foreach (['es', 'en'] as $locale) {
            $tr = $request->post[$locale] ?? null;
            if (!is_array($tr)) {
                continue;
            }
            $field = static function (string $key, int $max = 65535) use ($tr): ?string {
                $v = isset($tr[$key]) && is_string($tr[$key]) ? trim(str_replace("\r\n", "\n", $tr[$key])) : '';
                return $v === '' ? null : mb_substr($v, 0, $max);
            };
            $title = $field('title', 190);
            if ($title === null) {
                if ($locale === 'es') {
                    return $this->fail($back, t('admin.error.title'));
                }
                continue; // Sin título en inglés: la sección no tiene (o conserva) su versión en inglés.
            }
            $slug = HtmlCleaner::slugify($field('slug', 190) ?? $title);
            $current = $hubId > 0 ? DB::one('SELECT * FROM hub_translations WHERE hub_id = :h AND locale = :l', ['h' => $hubId, 'l' => $locale]) : null;
            if ($slug === '') {
                return $this->fail($back, t('admin.error.slug'));
            }
            // Un slug que no cambia no se revisa de nuevo (/herramientas/, por ejemplo, tiene su propia ruta).
            if ($slug !== ($current['slug'] ?? null)) {
                if (Slugs::hubTaken($locale, $slug, $hubId) || Slugs::postTaken($locale, $slug)) {
                    return $this->fail($back, t('admin.error.slug'));
                }
                if (Slugs::reserved($locale, $slug)) {
                    return $this->fail($back, t('admin.error.slug_route'));
                }
            }
            $rows[$locale] = ['current' => $current, 'data' => [
                'locale' => $locale,
                'slug' => $slug,
                'title' => $title,
                'menu_title' => $field('menu_title', 80),
                'intro_html' => ($intro = $field('intro_html')) !== null ? $cleaner->sanitize($intro, ['title' => $title, 'slug' => $slug]) : null,
                'faq_json' => ProductsController::parseFaq($field('faq')),
                'seo_title' => $field('seo_title', 190),
                'seo_description' => $field('seo_description', 320),
                'needs_review' => !empty($tr['needs_review']) ? 1 : 0,
            ]];
        }
        if (!isset($rows['es'])) {
            return $this->fail($back, t('admin.error.title'));
        }
        $key = $hub['key'] ?? null;
        if ($hub === null) {
            // La clave identifica la sección en el código y en los marcadores {{articulos:clave}}; no cambia después.
            $key = substr(HtmlCleaner::slugify((string) ($request->post['key'] ?? '') ?: $rows['es']['data']['slug']), 0, 60);
            if ($key === '' || DB::value('SELECT id FROM hubs WHERE `key` = :k', ['k' => $key]) !== null) {
                return $this->fail($back, t('admin.error.hub_key'));
            }
        }
        $pillar = (int) ($request->post['pillar_post_id'] ?? 0);
        $base = [
            'sort' => (int) ($request->post['sort'] ?? ($hub['sort'] ?? 0)),
            // El formulario envía in_menu=0 oculto antes de la casilla; si no llega, se conserva el valor actual.
            'in_menu' => array_key_exists('in_menu', $request->post) ? (!empty($request->post['in_menu']) ? 1 : 0) : (int) ($hub['in_menu'] ?? 1),
            'pillar_post_id' => $pillar > 0 ? $pillar : null,
        ];

        // 2. Guardar.
        $hubId = DB::transaction(function () use ($hub, $hubId, $key, $base, $rows): int {
            if ($hub === null) {
                $hubId = DB::insert('hubs', ['key' => $key] + $base);
            } else {
                DB::update('hubs', $base, ['id' => $hubId]);
            }
            foreach ($rows as $locale => ['current' => $current, 'data' => $data]) {
                $data['hub_id'] = $hubId;
                if ($current === null) {
                    DB::insert('hub_translations', $data);
                    continue;
                }
                DB::update('hub_translations', $data, ['id' => $current['id']]);
                if ($current['slug'] !== $data['slug']) {
                    $prefix = $locale === 'en' ? '/en/' : '/';
                    Redirects::add($prefix . $current['slug'] . '/', $prefix . $data['slug'] . '/', 'Cambio de slug de sección en el panel');
                }
            }
            DB::run('UPDATE hubs SET updated_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => $hubId]);
            return $hubId;
        });
        $this->saved();
        return $this->back("/admin/secciones/$hubId/", t($hub === null ? 'admin.hubs.created' : 'admin.saved'));
    }

    /**
     * Elimina una sección sin artículos (o, si se pide, quitándosela a sus artículos, que quedan "sin sección").
     * Las secciones que usa el código no se pueden eliminar. Sus URL redirigen (301) al blog si se pide.
     */
    public function destroy(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $hub = DB::one('SELECT * FROM hubs WHERE id = :id', ['id' => (int) $id]) ?? throw HttpException::notFound();
        $back = "/admin/secciones/{$hub['id']}/";
        if (in_array($hub['key'], self::CORE_KEYS, true)) {
            return $this->fail($back, t('admin.hubs.delete_core'));
        }
        $posts = (int) DB::value('SELECT COUNT(*) FROM posts WHERE hub_id = :h', ['h' => $hub['id']]);
        if ($posts > 0 && empty($request->post['unassign'])) {
            return $this->fail($back, t('admin.hubs.delete_has_posts', ['n' => $posts]));
        }
        $redirect = !empty($request->post['redirect']);
        DB::transaction(function () use ($hub, $redirect): void {
            DB::run('UPDATE posts SET hub_id = NULL WHERE hub_id = :h', ['h' => $hub['id']]);
            if ($redirect) {
                foreach (DB::all('SELECT locale, slug FROM hub_translations WHERE hub_id = :h', ['h' => $hub['id']]) as $tr) {
                    Redirects::add(($tr['locale'] === 'en' ? '/en/' : '/') . $tr['slug'] . '/', route('blog', [], $tr['locale']), 'Sección eliminada en el panel: ' . $hub['key']);
                }
            }
            DB::run('DELETE FROM hubs WHERE id = :id', ['id' => $hub['id']]);
        });
        $this->saved();
        return $this->back('/admin/secciones/', t('admin.hubs.deleted'));
    }
}
