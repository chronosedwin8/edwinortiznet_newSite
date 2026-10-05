<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Services\Importer\HtmlCleaner;

/**
 * Secciones temáticas (hubs): introducción, preguntas frecuentes, SEO y guía pilar, en español e inglés.
 */
final class HubsController extends AdminBase
{
    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $hubs = DB::all(
            'SELECT h.id, h.`key`, h.sort, es.title AS title_es, es.slug AS slug_es, en.title AS title_en, en.slug AS slug_en,
                    en.needs_review AS en_review, (SELECT COUNT(*) FROM posts p WHERE p.hub_id = h.id AND p.status = "published") AS posts
             FROM hubs h
             LEFT JOIN hub_translations es ON es.hub_id = h.id AND es.locale = "es"
             LEFT JOIN hub_translations en ON en.hub_id = h.id AND en.locale = "en"
             ORDER BY h.sort'
        );
        return $this->view('hubs/index', ['hubs' => $hubs], t('admin.hubs'));
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
        ], t('admin.hubs.edit', ['name' => $translations['es']['title'] ?? $hub['key']]));
    }

    public function update(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $hub = DB::one('SELECT * FROM hubs WHERE id = :id', ['id' => (int) $id]) ?? throw HttpException::notFound();
        $back = "/admin/secciones/{$hub['id']}/";
        $cleaner = new HtmlCleaner();
        $pillar = (int) ($request->post['pillar_post_id'] ?? 0);
        DB::update('hubs', ['sort' => (int) ($request->post['sort'] ?? $hub['sort']), 'pillar_post_id' => $pillar > 0 ? $pillar : null], ['id' => $hub['id']]);

        foreach (['es', 'en'] as $locale) {
            $tr = $request->post[$locale] ?? null;
            if (!is_array($tr)) {
                continue;
            }
            $current = DB::one('SELECT * FROM hub_translations WHERE hub_id = :h AND locale = :l', ['h' => $hub['id'], 'l' => $locale]);
            $field = static function (string $key, int $max = 65535) use ($tr): ?string {
                $v = isset($tr[$key]) && is_string($tr[$key]) ? trim(str_replace("\r\n", "\n", $tr[$key])) : '';
                return $v === '' ? null : mb_substr($v, 0, $max);
            };
            $title = $field('title', 190);
            if ($title === null) {
                if ($locale === 'es') {
                    return $this->fail($back, t('admin.error.title'));
                }
                continue;
            }
            $slug = HtmlCleaner::slugify($field('slug', 190) ?? $title);
            $taken = DB::value('SELECT id FROM posts WHERE locale = :l AND slug = :s AND status <> "draft"', ['l' => $locale, 's' => $slug])
                ?? DB::value('SELECT id FROM hub_translations WHERE locale = :l AND slug = :s AND hub_id <> :h', ['l' => $locale, 's' => $slug, 'h' => $hub['id']]);
            if ($taken !== null) {
                return $this->fail($back, t('admin.error.slug'));
            }
            $data = [
                'hub_id' => $hub['id'],
                'locale' => $locale,
                'slug' => $slug,
                'title' => $title,
                'menu_title' => $field('menu_title', 80),
                'intro_html' => ($intro = $field('intro_html')) !== null ? $cleaner->sanitize($intro, ['title' => $title, 'slug' => $slug]) : null,
                'faq_json' => ProductsController::parseFaq($field('faq')),
                'seo_title' => $field('seo_title', 190),
                'seo_description' => $field('seo_description', 320),
                'needs_review' => !empty($tr['needs_review']) ? 1 : 0,
            ];
            if ($current === null) {
                DB::insert('hub_translations', $data);
            } else {
                DB::update('hub_translations', $data, ['id' => $current['id']]);
                if ($current['slug'] !== $slug) {
                    $prefix = $locale === 'en' ? '/en/' : '/';
                    DB::upsert('redirects', [
                        'source' => $prefix . $current['slug'] . '/', 'target' => $prefix . $slug . '/', 'code' => 301,
                        'match_type' => 'exact', 'note' => 'Cambio de slug de sección en el panel',
                    ], ['source', 'match_type']);
                }
            }
        }
        DB::run('UPDATE hubs SET updated_at = UTC_TIMESTAMP() WHERE id = :id', ['id' => $hub['id']]);
        $this->saved();
        return $this->back($back, t('admin.saved'));
    }
}
