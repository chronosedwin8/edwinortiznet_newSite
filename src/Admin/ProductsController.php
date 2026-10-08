<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Services\Downloads\DownloadService;
use App\Services\Importer\HtmlCleaner;
use App\Services\Seo\Redirects;
use App\Services\Storage\S3;
use App\Services\Waitlist;

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
                    (SELECT GROUP_CONCAT(DISTINCT f.variant ORDER BY f.variant SEPARATOR ", ") FROM product_files f WHERE f.product_id = p.id AND f.variant IS NOT NULL AND f.variant <> "") AS variants,
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
            // Todas las variantes, agrupadas: primero los archivos para todos y luego por variante.
            'files' => array_map(
                static fn (array $f): array => $f + ['available' => DownloadService::available($f)],
                DB::all('SELECT * FROM product_files WHERE product_id = :id ORDER BY (variant IS NOT NULL AND variant <> ""), variant, id', ['id' => (int) $id])
            ),
            'packItems' => array_map('intval', DB::column('SELECT product_id FROM pack_items WHERE pack_id = :id', ['id' => (int) $id])),
            // «Reemplazar» en la lista de archivos: deja elegido ese archivo en el formulario de subida.
            'replaceId' => (int) ($request->query['reemplazar'] ?? 0),
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

    /** Si el producto ya se puede comprar, avisa a su lista de espera y lo cuenta en el mensaje. */
    private static function withNotified(string $message, int $productId): string
    {
        $sent = Waitlist::notifyIfAvailable($productId);
        return $sent > 0 ? $message . ' ' . t('admin.waitlist.notified', ['n' => $sent]) : $message;
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
            return $this->fail($back, t('admin.error.title'));
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
            return $this->fail($back, t('admin.error.sku'));
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
            return $this->fail($back, t('admin.error.slug'));
        }
        $this->saved();
        return $this->back("/admin/productos/$result/", self::withNotified(t('admin.saved'), (int) $result));
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
            return $this->fail($back, t('admin.error.upload'));
        }
        $name = preg_replace('/[^A-Za-z0-9._+\-]/', '-', basename((string) $file['name'])) ?: 'archivo.zip';
        if (preg_match('/\.(php\d?|phtml|phar|htaccess)$/i', $name)) {
            return $this->fail($back, t('admin.error.upload'));
        }
        $relative = $slug . '/' . $name;
        $tmp = (string) $file['tmp_name'];
        $bytes = (int) filesize($tmp);
        if (S3::enabled()) {
            // Producción: objeto privado en el bucket; se entrega con URL firmada de pocos minutos.
            try {
                S3::put(DownloadService::S3_PREFIX . $relative, $tmp, 'application/octet-stream', false);
            } catch (\RuntimeException $e) {
                \App\Core\Logger::warning('Subida de archivo de producto a S3 fallida', ['error' => $e->getMessage()]);
                return $this->fail($back, t('admin.error.upload'));
            }
            @unlink($tmp);
            $disk = 's3';
        } else {
            $target = DownloadService::path($relative);
            if (!is_dir(dirname($target))) {
                mkdir(dirname($target), 0775, true);
            }
            $moved = is_uploaded_file($tmp) ? move_uploaded_file($tmp, $target) : rename($tmp, $target);
            if (!$moved) {
                return $this->fail($back, t('admin.error.upload'));
            }
            $disk = 'local';
        }
        $replace = (int) ($request->post['replace_id'] ?? 0);
        $replacing = $replace > 0 && DB::value('SELECT id FROM product_files WHERE id = :id AND product_id = :p', ['id' => $replace, 'p' => $productId]) !== null;
        // Nueva versión de un archivo existente: sin nombre ni variante se conservan los actuales, y sin versión se usa la fecha.
        $data = ['storage_path' => $relative, 'storage_disk' => $disk, 'bytes' => $bytes,
            'version' => self::str($request, 'version', 40) ?? ($replacing ? date('Y.m.d') : null)];
        $label = self::str($request, 'label', 190);
        if ($label !== null || !$replacing) {
            $data['label'] = $label ?? $name;
        }
        // Variante opcional (p. ej. la materia): clave en minúsculas; al reemplazar sin indicarla se conserva la actual.
        $variant = preg_replace('/[^a-z0-9_-]/', '', strtolower((string) self::str($request, 'variant', 40)));
        if ($variant !== '') {
            $data['variant'] = $variant;
        }
        if ($replacing) {
            DB::update('product_files', $data, ['id' => $replace]);
        } else {
            DB::insert('product_files', $data + ['product_id' => $productId]);
        }
        $this->saved();
        return $this->back($back, self::withNotified(t('admin.products.uploaded'), $productId));
    }

    /**
     * Descarga para el administrador cualquier archivo del producto (todas las variantes), para revisarlo antes
     * de reemplazarlo: local en streaming o redirección a una URL firmada de S3. No consume descargas de pedidos.
     */
    public function downloadFile(Request $request, string $id, string $file): Response
    {
        $this->requireAdmin($request);
        $row = DB::one('SELECT * FROM product_files WHERE id = :f AND product_id = :p', ['f' => (int) $file, 'p' => (int) $id]);
        if ($row === null) {
            throw HttpException::notFound();
        }
        if (!DownloadService::available($row)) {
            return $this->fail("/admin/productos/$id/", t('admin.files.unavailable', ['file' => $row['label']]));
        }
        return DownloadService::deliver($row);
    }

    public function families(Request $request): Response
    {
        $this->requireAdmin($request);
        $rows = DB::all(
            'SELECT f.id, f.`key`, f.audience, f.sort, es.name AS name_es, es.slug AS slug_es, en.name AS name_en, en.slug AS slug_en,
                    (SELECT COUNT(*) FROM products p WHERE p.family_id = f.id) AS products
             FROM product_families f
             LEFT JOIN product_family_translations es ON es.family_id = f.id AND es.locale = "es"
             LEFT JOIN product_family_translations en ON en.family_id = f.id AND en.locale = "en"
             ORDER BY f.sort, f.id'
        );
        return $this->view('products/families', ['families' => $rows], t('admin.families'));
    }

    public function saveFamilies(Request $request): Response
    {
        $this->requireAdmin($request);
        $rows = [];
        foreach ((array) ($request->post['families'] ?? []) as $id => $f) {
            if (!is_array($f) || (int) $id <= 0) {
                continue;
            }
            foreach (['es', 'en'] as $locale) {
                $name = mb_substr(trim((string) ($f["name_$locale"] ?? '')), 0, 190);
                if ($name !== '') {
                    $slug = HtmlCleaner::slugify((string) (($f["slug_$locale"] ?? '') ?: $name));
                    if ($slug === '' || self::familySlugTaken($locale, $slug, (int) $id)) {
                        return $this->fail('/admin/familias/', t('admin.error.slug') . ' (' . $name . ')');
                    }
                    $rows[] = [(int) $id, $locale, ['name' => $name, 'slug' => $slug]];
                }
            }
            DB::update('product_families', ['sort' => (int) ($f['sort'] ?? 0)], ['id' => (int) $id]);
        }
        foreach ($rows as [$id, $locale, $data]) {
            self::putFamilyTranslation($id, $locale, $data);
        }
        $this->saved();
        return $this->back('/admin/familias/', t('admin.saved'));
    }

    public function createFamily(Request $request): Response
    {
        $this->requireAdmin($request);
        $family = ['id' => null, 'key' => '', 'audience' => 'oficina', 'sort' => (int) DB::value('SELECT COALESCE(MAX(sort), 0) + 1 FROM product_families')];
        return $this->view('products/family', ['family' => $family, 'translations' => [], 'productCount' => 0], t('admin.families.new'));
    }

    public function editFamily(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $family = DB::one('SELECT * FROM product_families WHERE id = :id', ['id' => (int) $id]) ?? throw HttpException::notFound();
        $translations = [];
        foreach (DB::all('SELECT * FROM product_family_translations WHERE family_id = :id', ['id' => $family['id']]) as $row) {
            $translations[$row['locale']] = $row;
        }
        return $this->view('products/family', [
            'family' => $family,
            'translations' => $translations,
            'productCount' => (int) DB::value('SELECT COUNT(*) FROM products WHERE family_id = :f', ['f' => $family['id']]),
        ], t('admin.families.edit', ['name' => $translations['es']['name'] ?? $family['key']]));
    }

    public function storeFamily(Request $request): Response
    {
        $this->requireAdmin($request);
        return $this->saveFamily($request, null);
    }

    public function updateFamily(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $family = DB::one('SELECT * FROM product_families WHERE id = :id', ['id' => (int) $id]) ?? throw HttpException::notFound();
        return $this->saveFamily($request, $family);
    }

    /** Familia nueva o editada: clave (solo al crear), perfil, orden y nombre, slug y descripción por idioma. */
    private function saveFamily(Request $request, ?array $family): Response
    {
        $back = $family ? "/admin/familias/{$family['id']}/" : '/admin/familias/nueva/';
        $familyId = (int) ($family['id'] ?? 0);
        $cleaner = new HtmlCleaner();
        $rows = [];
        foreach (['es', 'en'] as $locale) {
            $tr = $request->post[$locale] ?? null;
            $name = is_array($tr) ? mb_substr(trim((string) ($tr['name'] ?? '')), 0, 190) : '';
            if ($name === '') {
                if ($locale === 'es') {
                    return $this->fail($back, t('admin.error.name'));
                }
                continue; // Sin nombre en inglés: la familia no aparece (o conserva su versión) en la tienda en inglés.
            }
            $slug = HtmlCleaner::slugify((string) (($tr['slug'] ?? '') ?: $name));
            if ($slug === '' || self::familySlugTaken($locale, $slug, $familyId)) {
                return $this->fail($back, t('admin.error.slug'));
            }
            $description = trim((string) ($tr['description_html'] ?? ''));
            $rows[$locale] = [
                'name' => $name,
                'slug' => $slug,
                'description_html' => $description !== '' ? $cleaner->sanitize($description) : null,
                'needs_review' => !empty($tr['needs_review']) ? 1 : 0,
            ];
        }
        $base = [
            'audience' => in_array($request->post['audience'] ?? '', \App\Controllers\ShopController::AUDIENCES, true) ? $request->post['audience'] : 'oficina',
            'sort' => (int) ($request->post['sort'] ?? ($family['sort'] ?? 0)),
        ];
        if ($family === null) {
            $key = substr(HtmlCleaner::slugify((string) ($request->post['key'] ?? '') ?: $rows['es']['slug']), 0, 60);
            if ($key === '' || DB::value('SELECT id FROM product_families WHERE `key` = :k', ['k' => $key]) !== null) {
                return $this->fail($back, t('admin.error.family_key'));
            }
            $base['key'] = $key;
        }
        $familyId = DB::transaction(function () use ($family, $familyId, $base, $rows): int {
            if ($family === null) {
                $familyId = DB::insert('product_families', $base);
            } else {
                DB::update('product_families', $base, ['id' => $familyId]);
            }
            foreach ($rows as $locale => $data) {
                self::putFamilyTranslation($familyId, $locale, $data);
            }
            return $familyId;
        });
        $this->saved();
        return $this->back("/admin/familias/$familyId/", t($family === null ? 'admin.families.created' : 'admin.saved'));
    }

    /** Solo se eliminan familias vacías. Sus URL (/categoria-producto/…/) redirigen (301) a la tienda. */
    public function deleteFamily(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $family = DB::one('SELECT * FROM product_families WHERE id = :id', ['id' => (int) $id]) ?? throw HttpException::notFound();
        $count = (int) DB::value('SELECT COUNT(*) FROM products WHERE family_id = :f', ['f' => $family['id']]);
        if ($count > 0) {
            return $this->fail('/admin/familias/', t('admin.families.not_empty', ['n' => $count]));
        }
        DB::transaction(function () use ($family): void {
            foreach (DB::all('SELECT locale, slug FROM product_family_translations WHERE family_id = :f', ['f' => $family['id']]) as $tr) {
                Redirects::add(route('shop.family', ['slug' => $tr['slug']], $tr['locale']), route('shop', [], $tr['locale']), 'Familia eliminada en el panel: ' . $family['key']);
            }
            DB::run('DELETE FROM product_families WHERE id = :id', ['id' => $family['id']]);
        });
        $this->saved();
        return $this->back('/admin/familias/', t('admin.families.deleted'));
    }

    private static function familySlugTaken(string $locale, string $slug, int $exceptFamily): bool
    {
        return DB::value('SELECT id FROM product_family_translations WHERE locale = ? AND slug = ? AND family_id <> ?', [$locale, $slug, $exceptFamily]) !== null;
    }

    /** Inserta o actualiza el texto de una familia; si cambia el slug, la URL anterior redirige (301). */
    private static function putFamilyTranslation(int $familyId, string $locale, array $data): void
    {
        $current = DB::one('SELECT id, slug FROM product_family_translations WHERE family_id = ? AND locale = ?', [$familyId, $locale]);
        if ($current === null) {
            DB::insert('product_family_translations', ['family_id' => $familyId, 'locale' => $locale] + $data);
            return;
        }
        DB::update('product_family_translations', $data, ['id' => (int) $current['id']]);
        if ($current['slug'] !== $data['slug']) {
            Redirects::add(route('shop.family', ['slug' => $current['slug']], $locale), route('shop.family', ['slug' => $data['slug']], $locale), 'Cambio de slug de familia en el panel');
        }
    }
}
