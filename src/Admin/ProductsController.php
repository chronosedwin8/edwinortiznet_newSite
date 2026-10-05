<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Services\Downloads\DownloadService;
use App\Services\Importer\HtmlCleaner;

/**
 * Productos (fila base + textos ES/EN), packs, familias y archivos descargables.
 */
final class ProductsController extends AdminBase
{
    private const MAX_UPLOAD = 200 * 1024 * 1024;

    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $products = DB::all(
            'SELECT p.id, p.wp_id, p.type, p.status, p.price_usd, p.price_cop, p.legacy_sales, p.sales_count, p.audience,
                    es.title, es.slug, en.title AS title_en, en.needs_review AS en_review, ft.name AS family,
                    (SELECT COUNT(*) FROM product_files f WHERE f.product_id = p.id) AS files,
                    (SELECT COUNT(*) FROM product_files f WHERE f.product_id = p.id AND f.storage_path IS NOT NULL) AS files_ready,
                    (SELECT COUNT(*) FROM waitlist w WHERE w.product_id = p.id) AS waitlist
             FROM products p
             JOIN product_translations es ON es.product_id = p.id AND es.locale = "es"
             LEFT JOIN product_translations en ON en.product_id = p.id AND en.locale = "en"
             LEFT JOIN product_family_translations ft ON ft.family_id = p.family_id AND ft.locale = "es"
             ORDER BY FIELD(p.status, "active", "coming_soon", "hidden"), p.sort, p.id'
        );
        return $this->view('products/index', ['products' => $products], t('admin.products'));
    }

    private function options(): array
    {
        return [
            'families' => DB::all('SELECT f.id, t.name FROM product_families f JOIN product_family_translations t ON t.family_id = f.id AND t.locale = "es" ORDER BY f.sort'),
            'tutorials' => DB::all('SELECT id, title FROM posts WHERE locale = "es" AND type = "post" AND status = "published" ORDER BY title'),
            'allProducts' => DB::all('SELECT p.id, t.title FROM products p JOIN product_translations t ON t.product_id = p.id AND t.locale = "es" WHERE p.type <> "pack" ORDER BY t.title'),
        ];
    }

    public function create(Request $request): Response
    {
        $this->requireAdmin($request);
        $product = ['id' => null, 'sku' => '', 'family_id' => null, 'audience' => 'oficina', 'type' => 'download', 'price_usd' => '0.00', 'price_cop' => 0,
            'status' => 'coming_soon', 'featured' => 0, 'cover_url' => '', 'cover_alt' => '', 'video_url' => '', 'has_english_version' => 0,
            'tutorial_post_id' => null, 'sort' => 50, 'legacy_sales' => 0, 'sales_count' => 0];
        return $this->view('products/edit', ['product' => $product, 'translations' => ['es' => [], 'en' => []], 'files' => [], 'packItems' => []] + $this->options(), t('admin.products.new'));
    }

    public function edit(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $product = DB::one('SELECT * FROM products WHERE id = :id', ['id' => (int) $id]);
        if ($product === null) {
            throw HttpException::notFound();
        }
        $translations = ['es' => [], 'en' => []];
        foreach (DB::all('SELECT * FROM product_translations WHERE product_id = :id', ['id' => (int) $id]) as $tr) {
            $translations[$tr['locale']] = $tr;
        }
        return $this->view('products/edit', [
            'product' => $product,
            'translations' => $translations,
            'files' => DB::all('SELECT * FROM product_files WHERE product_id = :id ORDER BY id', ['id' => (int) $id]),
            'packItems' => array_map('intval', DB::column('SELECT product_id FROM pack_items WHERE pack_id = :id', ['id' => (int) $id])),
        ] + $this->options(), $translations['es']['title'] ?? t('admin.products'));
    }

    public function store(Request $request): Response
    {
        $this->requireAdmin($request);
        return $this->save($request, null);
    }

    public function update(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        if (DB::value('SELECT id FROM products WHERE id = :id', ['id' => (int) $id]) === null) {
            throw HttpException::notFound();
        }
        return $this->save($request, (int) $id);
    }

    /** "Pregunta | Respuesta" por línea → JSON. */
    public static function parseFaq(?string $raw): ?string
    {
        if ($raw === null) {
            return null;
        }
        $faqs = [];
        foreach (preg_split('/\R/', $raw) ?: [] as $line) {
            [$q, $a] = array_pad(array_map('trim', explode('|', $line, 2)), 2, '');
            if ($q !== '' && $a !== '') {
                $faqs[] = ['q' => $q, 'a' => $a];
            }
        }
        return json_encode($faqs, JSON_UNESCAPED_UNICODE) ?: null;
    }

    public static function faqText(?string $json): string
    {
        $faqs = json_decode((string) $json, true);
        return is_array($faqs) ? implode("\n", array_map(fn ($f) => ($f['q'] ?? '') . ' | ' . ($f['a'] ?? ''), $faqs)) : '';
    }

    private function save(Request $request, ?int $id): Response
    {
        $back = $id ? "/admin/productos/$id/" : '/admin/productos/nuevo/';
        $es = $request->post['es'] ?? [];
        $en = $request->post['en'] ?? [];
        if (!is_array($es) || trim((string) ($es['title'] ?? '')) === '') {
            return $this->back($back, t('admin.error.title'));
        }
        $base = [
            'sku' => self::str($request, 'sku', 60),
            'family_id' => ($f = (int) ($request->post['family_id'] ?? 0)) > 0 ? $f : null,
            'audience' => in_array($request->post['audience'] ?? '', ['oficina', 'docente', 'concurso'], true) ? $request->post['audience'] : 'oficina',
            'type' => in_array($request->post['type'] ?? '', ['download', 'service', 'course', 'pack'], true) ? $request->post['type'] : 'download',
            'price_usd' => round(max(0, (float) ($request->post['price_usd'] ?? 0)), 2),
            'price_cop' => max(0, (int) preg_replace('/\D/', '', (string) ($request->post['price_cop'] ?? '0'))),
            'status' => in_array($request->post['status'] ?? '', ['active', 'hidden', 'coming_soon'], true) ? $request->post['status'] : 'coming_soon',
            'featured' => !empty($request->post['featured']) ? 1 : 0,
            'cover_url' => self::str($request, 'cover_url', 500),
            'cover_alt' => self::str($request, 'cover_alt', 255),
            'video_url' => self::str($request, 'video_url', 500),
            'has_english_version' => !empty($request->post['has_english_version']) ? 1 : 0,
            'tutorial_post_id' => ($t = (int) ($request->post['tutorial_post_id'] ?? 0)) > 0 ? $t : null,
            'sort' => (int) ($request->post['sort'] ?? 50),
        ];
        if ($base['sku'] !== null && DB::value('SELECT id FROM products WHERE sku = :s AND id <> :id', ['s' => $base['sku'], 'id' => (int) $id]) !== null) {
            return $this->back($back, t('admin.error.sku'));
        }
        $cleaner = new HtmlCleaner();
        $result = DB::transaction(function () use ($id, $base, $es, $en, $cleaner, $request): int|string {
            $productId = $id ?? DB::insert('products', $base);
            if ($id !== null) {
                DB::update('products', $base, ['id' => $id]);
            }
            foreach (['es' => $es, 'en' => $en] as $locale => $tr) {
                if (!is_array($tr) || trim((string) ($tr['title'] ?? '')) === '') {
                    continue;
                }
                $slug = HtmlCleaner::slugify((string) (($tr['slug'] ?? '') !== '' ? $tr['slug'] : $tr['title']));
                if (DB::value('SELECT id FROM product_translations WHERE locale = :l AND slug = :s AND product_id <> :p', ['l' => $locale, 's' => $slug, 'p' => $productId]) !== null) {
                    return 'slug';
                }
                $oldSlug = DB::value('SELECT slug FROM product_translations WHERE product_id = :p AND locale = :l', ['p' => $productId, 'l' => $locale]);
                if (is_string($oldSlug) && $oldSlug !== $slug) {
                    DB::upsert('redirects', [
                        'source' => route('product', ['slug' => $oldSlug], $locale), 'target' => route('product', ['slug' => $slug], $locale),
                        'code' => 301, 'match_type' => 'exact', 'note' => 'Cambio de slug en el panel',
                    ], ['source', 'match_type']);
                }
                $short = $cleaner->sanitize((string) ($tr['short_html'] ?? ''));
                $desc = $cleaner->sanitize((string) ($tr['description_html'] ?? ''), ['title' => (string) $tr['title']]);
                $field = static fn (string $k, int $max = 65535): ?string => ($v = trim((string) ($tr[$k] ?? ''))) !== '' ? mb_substr($v, 0, $max) : null;
                DB::upsert('product_translations', [
                    'product_id' => $productId, 'locale' => $locale, 'slug' => $slug, 'title' => mb_substr(trim((string) $tr['title']), 0, 255),
                    'short_html' => $short, 'description_html' => $desc,
                    'includes_html' => ($i = $field('includes_html')) !== null ? $cleaner->sanitize($i) : null,
                    'requirements' => $field('requirements'), 'license_text' => $field('license_text'),
                    'faq_json' => self::parseFaq($field('faq')),
                    'search_text' => HtmlCleaner::toText($tr['title'] . ' ' . $short . ' ' . $desc),
                    'seo_title' => $field('seo_title', 190), 'seo_description' => $field('seo_description', 320),
                    'needs_review' => !empty($tr['needs_review']) ? 1 : 0,
                ], ['product_id', 'locale']);
            }
            if ($base['type'] === 'pack') {
                DB::run('DELETE FROM pack_items WHERE pack_id = :p', ['p' => $productId]);
                foreach ((array) ($request->post['pack_items'] ?? []) as $item) {
                    if ((int) $item > 0 && (int) $item !== $productId) {
                        DB::run('INSERT IGNORE INTO pack_items (pack_id, product_id) VALUES (:p, :i)', ['p' => $productId, 'i' => (int) $item]);
                    }
                }
            }
            return $productId;
        });
        if ($result === 'slug') {
            return $this->back($back, t('admin.error.slug'));
        }
        $this->saved();
        return $this->back("/admin/productos/$result/", t('admin.saved'));
    }

    /** Sube el archivo descargable a storage/downloads/{slug}/ (nunca al webroot). */
    public function upload(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $productId = (int) $id;
        $slug = DB::value('SELECT slug FROM product_translations WHERE product_id = :p AND locale = "es"', ['p' => $productId]);
        $file = $request->files['file'] ?? null;
        $back = "/admin/productos/$productId/";
        if ($slug === null || !is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || (int) $file['size'] > self::MAX_UPLOAD) {
            return $this->back($back, t('admin.error.upload'));
        }
        $name = preg_replace('/[^A-Za-z0-9._+\-]/', '-', basename((string) $file['name'])) ?: 'archivo.zip';
        if (preg_match('/\.(php\d?|phtml|phar|htaccess)$/i', $name)) {
            return $this->back($back, t('admin.error.upload'));
        }
        $relative = $slug . '/' . $name;
        $target = DownloadService::path($relative);
        if (!is_dir(dirname($target))) {
            mkdir(dirname($target), 0775, true);
        }
        $moved = is_uploaded_file((string) $file['tmp_name']) ? move_uploaded_file((string) $file['tmp_name'], $target) : rename((string) $file['tmp_name'], $target);
        if (!$moved) {
            return $this->back($back, t('admin.error.upload'));
        }
        $data = ['storage_path' => $relative, 'bytes' => filesize($target), 'version' => self::str($request, 'version', 40), 'label' => self::str($request, 'label', 190) ?? $name];
        $replace = (int) ($request->post['replace_id'] ?? 0);
        if ($replace > 0 && DB::value('SELECT id FROM product_files WHERE id = :id AND product_id = :p', ['id' => $replace, 'p' => $productId]) !== null) {
            DB::update('product_files', $data, ['id' => $replace]);
        } else {
            DB::insert('product_files', $data + ['product_id' => $productId]);
        }
        $this->saved();
        return $this->back($back, t('admin.products.uploaded'));
    }

    public function families(Request $request): Response
    {
        $this->requireAdmin($request);
        $rows = DB::all(
            'SELECT f.id, f.`key`, f.audience, f.sort, es.name AS name_es, es.slug AS slug_es, en.name AS name_en, en.slug AS slug_en
             FROM product_families f
             LEFT JOIN product_family_translations es ON es.family_id = f.id AND es.locale = "es"
             LEFT JOIN product_family_translations en ON en.family_id = f.id AND en.locale = "en"
             ORDER BY f.sort'
        );
        return $this->view('products/families', ['families' => $rows], t('admin.families'));
    }

    public function saveFamilies(Request $request): Response
    {
        $this->requireAdmin($request);
        foreach ((array) ($request->post['families'] ?? []) as $id => $f) {
            if (!is_array($f)) {
                continue;
            }
            DB::update('product_families', ['sort' => (int) ($f['sort'] ?? 0)], ['id' => (int) $id]);
            foreach (['es', 'en'] as $locale) {
                $name = trim((string) ($f["name_$locale"] ?? ''));
                if ($name !== '') {
                    $slug = HtmlCleaner::slugify((string) (($f["slug_$locale"] ?? '') ?: $name));
                    DB::upsert('product_family_translations', ['family_id' => (int) $id, 'locale' => $locale, 'name' => $name, 'slug' => $slug], ['family_id', 'locale']);
                }
            }
        }
        $this->saved();
        return $this->back('/admin/familias/', t('admin.saved'));
    }
}
