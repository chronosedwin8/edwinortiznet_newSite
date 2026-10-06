<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;
use App\Services\Content\ContentRenderer;
use App\Services\Importer\HtmlCleaner;
use App\Services\Media\MediaLibrary;
use App\Services\Importer\WxrImporter;

/**
 * Artículos, páginas y políticas: editor HTML saneado, campos SEO, pestañas ES/EN y traducción.
 */
final class PostsController extends AdminBase
{
    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $where = ['1 = 1'];
        $params = [];
        $filters = [
            'locale' => in_array($request->query['locale'] ?? '', ['es', 'en'], true) ? $request->query['locale'] : '',
            'type' => in_array($request->query['type'] ?? '', ['post', 'page', 'policy'], true) ? $request->query['type'] : '',
            'status' => in_array($request->query['status'] ?? '', ['published', 'draft', 'noindex'], true) ? $request->query['status'] : '',
            'review' => !empty($request->query['review']),
            'seo' => !empty($request->query['seo']),
            'q' => is_string($request->query['q'] ?? null) ? trim($request->query['q']) : '',
        ];
        foreach (['locale', 'type', 'status'] as $f) {
            if ($filters[$f] !== '') {
                $where[] = "p.$f = :$f";
                $params[$f] = $filters[$f];
            }
        }
        if ($filters['review']) {
            $where[] = 'p.needs_review = 1';
        }
        if ($filters['seo']) {
            $where[] = 'p.seo_auto = 1';
        }
        if ($filters['q'] !== '') {
            $where[] = '(p.title LIKE :q OR p.slug LIKE :q2)';
            $params['q'] = '%' . $filters['q'] . '%';
            $params['q2'] = '%' . $filters['q'] . '%';
        }
        $posts = DB::all(
            'SELECT p.id, p.type, p.locale, p.slug, p.title, p.status, p.needs_review, p.seo_auto, p.published_at, p.translation_group, p.cover_url,
                    (SELECT COUNT(*) FROM posts x WHERE x.translation_group = p.translation_group AND x.id <> p.id) AS has_translation
             FROM posts p WHERE ' . implode(' AND ', $where) . ' ORDER BY p.published_at DESC, p.id DESC LIMIT 300',
            $params
        );
        return $this->view('posts/index', ['posts' => $posts, 'filters' => $filters], t('admin.posts'));
    }

    private function options(): array
    {
        return [
            'hubs' => DB::all('SELECT h.id, h.`key`, t.title FROM hubs h JOIN hub_translations t ON t.hub_id = h.id AND t.locale = "es" ORDER BY h.sort'),
            'products' => DB::all('SELECT p.id, t.title, t.slug FROM products p JOIN product_translations t ON t.product_id = p.id AND t.locale = "es" WHERE p.status <> "hidden" ORDER BY t.title'),
        ];
    }

    public function create(Request $request): Response
    {
        $this->requireAdmin($request);
        $post = ['id' => null, 'type' => 'post', 'locale' => $request->query['locale'] ?? 'es', 'slug' => '', 'title' => '', 'excerpt' => '', 'content_html' => '',
            'notice_html' => '', 'cover_url' => '', 'cover_alt' => '', 'hub_id' => null, 'related_product_id' => null, 'status' => 'draft',
            'seo_title' => '', 'seo_description' => '', 'seo_auto' => 0, 'focus_keyword' => '', 'canonical_url' => '', 'no_ads' => 0,
            'needs_review' => 0, 'published_at' => gmdate('Y-m-d H:i:s'), 'translation_group' => null];
        return $this->view('posts/edit', ['post' => $post, 'translation' => null] + $this->options(), t('admin.posts.new'));
    }

    public function edit(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $post = DB::one('SELECT * FROM posts WHERE id = :id', ['id' => (int) $id]);
        if ($post === null) {
            throw HttpException::notFound();
        }
        $translation = DB::one('SELECT id, locale, slug, title, needs_review FROM posts WHERE translation_group = :g AND id <> :id LIMIT 1', ['g' => $post['translation_group'], 'id' => (int) $post['id']]);
        return $this->view('posts/edit', ['post' => $post, 'translation' => $translation] + $this->options(), $post['title']);
    }

    public function store(Request $request): Response
    {
        $this->requireAdmin($request);
        return $this->save($request, null);
    }

    public function update(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $post = DB::one('SELECT * FROM posts WHERE id = :id', ['id' => (int) $id]);
        if ($post === null) {
            throw HttpException::notFound();
        }
        return $this->save($request, $post);
    }

    private function save(Request $request, ?array $post): Response
    {
        $locale = $post['locale'] ?? (($request->post['locale'] ?? 'es') === 'en' ? 'en' : 'es');
        $title = self::str($request, 'title', 255) ?? '';
        $slug = HtmlCleaner::slugify(self::str($request, 'slug', 190) ?? $title);
        $slug = $slug !== '' ? $slug : 'entrada-' . time();
        $back = $post ? "/admin/contenido/{$post['id']}/" : '/admin/contenido/nuevo/';
        if ($title === '') {
            return $this->fail($back, t('admin.error.title'));
        }
        $taken = DB::value('SELECT id FROM posts WHERE locale = :l AND slug = :s AND id <> :id', ['l' => $locale, 's' => $slug, 'id' => (int) ($post['id'] ?? 0)]);
        $hubTaken = DB::value('SELECT id FROM hub_translations WHERE locale = :l AND slug = :s', ['l' => $locale, 's' => $slug]);
        if ($taken !== null || $hubTaken !== null) {
            return $this->fail($back, t('admin.error.slug'));
        }
        $cleaner = new HtmlCleaner();
        $html = $cleaner->sanitize((string) ($request->post['content_html'] ?? ''), ['title' => $title, 'slug' => $slug]);
        $text = HtmlCleaner::toText($html);
        $notice = self::str($request, 'notice_html');
        $type = in_array($request->post['type'] ?? '', ['post', 'page', 'policy'], true) ? $request->post['type'] : 'post';
        $data = [
            'type' => $type,
            'locale' => $locale,
            'slug' => $slug,
            'title' => $title,
            'excerpt' => self::str($request, 'excerpt', 2000) ?? excerpt_text($text, 220),
            'content_html' => $html,
            'content_text' => $text,
            'notice_html' => $notice !== null ? $cleaner->sanitize($notice) : null,
            'cover_url' => self::str($request, 'cover_url', 500),
            'cover_alt' => self::str($request, 'cover_alt', 255),
            'hub_id' => ($h = (int) ($request->post['hub_id'] ?? 0)) > 0 ? $h : null,
            'related_product_id' => ($p = (int) ($request->post['related_product_id'] ?? 0)) > 0 ? $p : null,
            'status' => in_array($request->post['status'] ?? '', ['published', 'draft', 'noindex'], true) ? $request->post['status'] : 'draft',
            'seo_title' => self::str($request, 'seo_title', 190),
            'seo_description' => self::str($request, 'seo_description', 320),
            'seo_auto' => !empty($request->post['seo_auto']) ? 1 : 0,
            'focus_keyword' => self::str($request, 'focus_keyword', 190),
            'canonical_url' => self::str($request, 'canonical_url', 500),
            'no_ads' => !empty($request->post['no_ads']) ? 1 : 0,
            'needs_review' => !empty($request->post['needs_review']) ? 1 : 0,
            'reading_minutes' => HtmlCleaner::readingMinutes($text),
            'published_at' => self::str($request, 'published_at', 19) ?? gmdate('Y-m-d H:i:s'),
            'updated_at' => gmdate('Y-m-d H:i:s'),
        ];
        // Portada de la biblioteca: tamaño y srcset salen de la tabla media; si cambia a otra URL se limpian.
        $media = $data['cover_url'] !== null ? MediaLibrary::byPath($data['cover_url']) : null;
        if ($media !== null) {
            $data += ['cover_width' => $media['width'], 'cover_height' => $media['height'], 'cover_srcset' => $media['srcset'] ?: null];
        } elseif ($data['cover_url'] !== ($post['cover_url'] ?? null)) {
            $data += ['cover_width' => null, 'cover_height' => null, 'cover_srcset' => null];
        }
        if ($post === null) {
            $data['translation_group'] = WxrImporter::uuid('admin-' . bin2hex(random_bytes(8)));
            $id = DB::insert('posts', $data);
        } else {
            $id = (int) $post['id'];
            DB::update('posts', $data, ['id' => $id]);
            // Si cambia la URL de algo publicado, la antigua redirige con 301.
            if ($post['slug'] !== $slug && $post['status'] !== 'draft') {
                $old = $type === 'policy' ? route('policy', ['slug' => $post['slug']], $locale) : ($locale === 'en' ? '/en/' : '/') . $post['slug'] . '/';
                $new = $type === 'policy' ? route('policy', ['slug' => $slug], $locale) : ($locale === 'en' ? '/en/' : '/') . $slug . '/';
                DB::upsert('redirects', ['source' => $old, 'target' => $new, 'code' => 301, 'match_type' => 'exact', 'note' => 'Cambio de slug en el panel'], ['source', 'match_type']);
            }
        }
        $this->saved();
        return $this->back("/admin/contenido/$id/", t('admin.saved'));
    }

    /** Crea la versión en inglés a partir de la española (borrador, needs_review = 1). */
    public function translate(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $post = DB::one('SELECT * FROM posts WHERE id = :id AND locale = "es"', ['id' => (int) $id]);
        if ($post === null) {
            throw HttpException::notFound();
        }
        $existing = DB::value('SELECT id FROM posts WHERE translation_group = :g AND locale = "en"', ['g' => $post['translation_group']]);
        if ($existing !== null) {
            return $this->back("/admin/contenido/$existing/");
        }
        $slug = $post['slug'];
        while (DB::value('SELECT id FROM posts WHERE locale = "en" AND slug = :s', ['s' => $slug]) !== null) {
            $slug .= '-en';
        }
        $copy = $post;
        unset($copy['id'], $copy['created_at']);
        $copy['wp_id'] = null;
        $copy['locale'] = 'en';
        $copy['slug'] = $slug;
        $copy['status'] = 'draft';
        $copy['needs_review'] = 1;
        $copy['notice_html'] = null;
        $newId = DB::insert('posts', $copy);
        $this->saved();
        return $this->back("/admin/contenido/$newId/", t('admin.posts.translated'));
    }

    /** Vista previa del HTML (saneado) con los marcadores resueltos. */
    public function preview(Request $request): Response
    {
        $this->requireAdmin($request);
        $locale = ($request->post['locale'] ?? 'es') === 'en' ? 'en' : 'es';
        $cleaner = new HtmlCleaner();
        $html = $cleaner->sanitize((string) ($request->post['content_html'] ?? ''), ['title' => (string) ($request->post['title'] ?? '')]);
        $rendered = ContentRenderer::render(['id' => 0, 'locale' => $locale, 'content_html' => $html, 'no_ads' => 1]);
        $body = View::render('admin/preview', ['title' => (string) ($request->post['title'] ?? ''), 'html' => $rendered['html']]);
        return Response::html($body)->header('Cache-Control', 'private, no-store')->header('X-Robots-Tag', 'noindex');
    }
}
