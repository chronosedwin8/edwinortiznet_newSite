<?php

declare(strict_types=1);

namespace App\Services\Importer;

use App\Core\DB;
use SimpleXMLElement;

/**
 * Importador idempotente de las exportaciones WXR 1.2 de WordPress (entradas, páginas y productos).
 * Todo entra con locale = es; las traducciones se crean con los seeds de database/seeds/en/.
 */
final class WxrImporter
{
    /** Páginas de WordPress que son rutas de la aplicación y no se importan como contenido. */
    public const APP_ROUTE_PAGES = ['tienda', 'carrito', 'finalizar-compra', 'mi-cuenta', 'blog', 'cursos'];

    public const HUB_BY_CATEGORY = [
        'concurso-docente' => ['concurso-docente'],
        'excel' => ['excel', 'oficina', 'correos-masivos'],
        'ia-para-docentes' => ['educacion', 'para-profesores', 'pensamiento-computacional', 'ciudadania-digital', 'realidad-aumentada', 'infografias'],
    ];

    private AttachmentIndex $attachments;
    /** @var array<int,string> */
    private array $productSlugs = [];
    /** @var array<string,int> */
    private array $hubIds = [];
    /** @var array<string,int> */
    private array $categoryIds = [];

    public function __construct(private readonly string $dir, private readonly \Closure $out)
    {
        $this->attachments = new AttachmentIndex();
    }

    private function say(string $line): void
    {
        ($this->out)($line);
    }

    private function locate(string $pattern): string
    {
        foreach ([$this->dir, dirname($this->dir, 2)] as $dir) {
            foreach (glob($dir . '/*.xml') ?: [] as $file) {
                if (stripos(basename($file), $pattern) !== false) {
                    return $file;
                }
            }
        }
        throw new \RuntimeException("No se encontró el XML *$pattern*.xml en {$this->dir}");
    }

    private function load(string $file): SimpleXMLElement
    {
        $xml = simplexml_load_file($file, SimpleXMLElement::class, LIBXML_NOCDATA | LIBXML_PARSEHUGE | LIBXML_NONET);
        if ($xml === false) {
            throw new \RuntimeException("XML inválido: $file");
        }
        return $xml;
    }

    /** @return array<int, array> Ítems normalizados del canal. */
    private function items(SimpleXMLElement $xml): array
    {
        $ns = $xml->getNamespaces(true);
        $items = [];
        foreach ($xml->channel->item as $item) {
            $wp = $item->children($ns['wp']);
            $meta = [];
            foreach ($wp->postmeta as $m) {
                $meta[(string) $m->meta_key] = (string) $m->meta_value;
            }
            $terms = [];
            foreach ($item->category as $c) {
                $terms[(string) $c['domain']][(string) $c['nicename']] = (string) $c;
            }
            $items[] = [
                'id' => (int) $wp->post_id,
                'type' => (string) $wp->post_type,
                'status' => (string) $wp->status,
                'slug' => rawurldecode((string) $wp->post_name),
                'title' => html_entity_decode((string) $item->title, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                'content' => (string) $item->children($ns['content'])->encoded,
                'excerpt' => (string) $item->children($ns['excerpt'])->encoded,
                'date_gmt' => (string) $wp->post_date_gmt,
                'date' => (string) $wp->post_date,
                'modified_gmt' => (string) $wp->post_modified_gmt,
                'parent' => (int) $wp->post_parent,
                'attachment_url' => (string) $wp->attachment_url,
                'meta' => $meta,
                'terms' => $terms,
            ];
        }
        return $items;
    }

    /** @return array{posts:int, pages:int, products:int, attachments:int, pages_imported:int} */
    public function run(): array
    {
        $files = [
            'products' => $this->locate('productos'),
            'posts' => $this->locate('entradas'),
            'pages' => $this->locate('paginas'),
        ];
        $items = [];
        foreach ($files as $key => $file) {
            $this->say("Leyendo " . basename($file) . '…');
            $items[$key] = $this->items($this->load($file));
        }

        // Adjuntos de los tres archivos (435 en total).
        $attachmentCount = 0;
        foreach ($items as $list) {
            foreach ($list as $it) {
                if ($it['type'] !== 'attachment') {
                    continue;
                }
                $attachmentCount++;
                $this->attachments->add(
                    $it['id'],
                    $it['attachment_url'],
                    $it['title'],
                    $it['meta']['_wp_attachment_image_alt'] ?? '',
                    $it['meta']['_wp_attached_file'] ?? null,
                    $it['meta']['_wp_attachment_metadata'] ?? null,
                );
            }
        }
        foreach ($items['products'] as $it) {
            if ($it['type'] === 'product') {
                $this->productSlugs[$it['id']] = $it['slug'];
            }
        }

        $this->ensureHubs();
        $summary = ['posts' => 0, 'pages' => 0, 'products' => 0, 'attachments' => $attachmentCount, 'pages_imported' => 0];

        DB::transaction(function () use ($items, &$summary): void {
            foreach ($items['posts'] as $it) {
                if ($it['type'] === 'post' && $it['status'] === 'publish') {
                    $this->importPost($it, 'post');
                    $summary['posts']++;
                }
            }
            foreach ($items['pages'] as $it) {
                if ($it['type'] === 'page' && $it['status'] === 'publish') {
                    $summary['pages']++;
                    if (in_array($it['slug'], self::APP_ROUTE_PAGES, true)) {
                        continue;
                    }
                    $this->importPost($it, 'page');
                    $summary['pages_imported']++;
                }
            }
            foreach ($items['products'] as $it) {
                if ($it['type'] === 'product' && $it['status'] === 'publish') {
                    $this->importProduct($it);
                    $summary['products']++;
                }
            }
        });
        return $summary;
    }

    private function ensureHubs(): void
    {
        $defaults = [
            'excel' => [1, 'Excel y automatización de oficina'],
            'ia-para-docentes' => [2, 'IA y tecnología para docentes'],
            'concurso-docente' => [3, 'Concurso Docente'],
            'herramientas' => [4, 'Herramientas gratis'],
        ];
        foreach ($defaults as $key => [$sort, $title]) {
            $id = DB::value('SELECT id FROM hubs WHERE `key` = :k', ['k' => $key]);
            if ($id === null) {
                $id = DB::insert('hubs', ['key' => $key, 'sort' => $sort]);
                DB::insert('hub_translations', ['hub_id' => $id, 'locale' => 'es', 'slug' => $key, 'title' => $title]);
            }
            $this->hubIds[$key] = (int) $id;
        }
    }

    private static function normalizeCategory(string $slug): string
    {
        return preg_replace('/-es$/', '', $slug) ?? $slug;
    }

    private function hubFor(array $categories): ?string
    {
        foreach (self::HUB_BY_CATEGORY as $hub => $cats) {
            if (array_intersect($categories, $cats)) {
                return $hub;
            }
        }
        return null;
    }

    private function categoryId(string $slug, string $name): int
    {
        if (isset($this->categoryIds[$slug])) {
            return $this->categoryIds[$slug];
        }
        $hub = $this->hubFor([$slug]);
        $id = DB::upsert('categories', ['wp_slug' => $slug, 'hub_id' => $hub ? $this->hubIds[$hub] : null], ['wp_slug']);
        $existing = DB::value('SELECT id FROM category_translations WHERE category_id = :c AND locale = "es"', ['c' => $id]);
        if ($existing === null) {
            DB::insert('category_translations', ['category_id' => $id, 'locale' => 'es', 'slug' => $slug, 'name' => $name]);
        }
        return $this->categoryIds[$slug] = $id;
    }

    public static function uuid(string $seed): string
    {
        $h = md5($seed);
        return sprintf('%s-%s-%s-%s-%s', substr($h, 0, 8), substr($h, 8, 4), substr($h, 12, 4), substr($h, 16, 4), substr($h, 20, 12));
    }

    private static function date(string $gmt, string $local): ?string
    {
        if ($gmt !== '' && !str_starts_with($gmt, '0000')) {
            return $gmt;
        }
        if ($local !== '' && !str_starts_with($local, '0000')) {
            return gmdate('Y-m-d H:i:s', strtotime($local . ' America/Bogota') ?: time());
        }
        return null;
    }

    private static function yoastTitle(string $title, string $postTitle): ?string
    {
        if (trim($title) === '') {
            return null;
        }
        $title = strtr($title, [
            '%%title%%' => $postTitle,
            '%%sep%%' => '|',
            '%%sitename%%' => 'Edwin Ortiz Herazo',
            '%%page%%' => '',
            '%%primary_category%%' => '',
            '%%category%%' => '',
        ]);
        $title = preg_replace('/%%[a-z_]+%%/', '', $title) ?? $title;
        $title = trim(preg_replace('/\s+/', ' ', $title) ?? $title, " |-");
        return $title !== '' ? $title : null;
    }

    /** Imagen destacada: fifu_image_url si existe; si no, el adjunto de _thumbnail_id. */
    private function cover(array $it): array
    {
        if (!empty($it['meta']['fifu_image_url'])) {
            $url = trim($it['meta']['fifu_image_url']);
            $alt = trim($it['meta']['fifu_image_alt'] ?? '') ?: $it['title'];
            $resolved = $this->attachments->resolve($url);
            return [
                'url' => $resolved['url'] ?? $url,
                'alt' => $alt,
                'width' => $resolved['width'] ?? null,
                'height' => $resolved['height'] ?? null,
            ];
        }
        $thumb = (int) ($it['meta']['_thumbnail_id'] ?? 0);
        $att = $thumb ? $this->attachments->get($thumb) : null;
        if ($att === null) {
            return ['url' => null, 'alt' => null, 'width' => null, 'height' => null];
        }
        // Tamaño "large" si existe (más liviano), con sus dimensiones.
        $size = $att['sizes']['large'] ?? null;
        if ($size !== null && abs($size['width'] / max(1, $size['height']) - $att['width'] / max(1, $att['height'])) < 0.05) {
            return ['url' => $size['url'], 'alt' => $att['alt'] ?: $it['title'], 'width' => $size['width'], 'height' => $size['height']];
        }
        return ['url' => $att['url'], 'alt' => $att['alt'] ?: $it['title'], 'width' => $att['width'] ?: null, 'height' => $att['height'] ?: null];
    }

    private function importPost(array $it, string $type): void
    {
        $categories = [];
        foreach (($it['terms']['category'] ?? []) as $slug => $name) {
            $categories[self::normalizeCategory($slug)] = $name;
        }
        $hubKey = $type === 'post' ? $this->hubFor(array_keys($categories)) : null;
        $cleaner = new HtmlCleaner($this->attachments, $this->productSlugs);
        $content = $cleaner->clean($it['content'], ['slug' => $it['slug'], 'title' => $it['title'], 'hub' => $hubKey]);
        $text = HtmlCleaner::toText($content);
        $excerpt = trim(HtmlCleaner::toText($it['excerpt']));
        if ($excerpt === '') {
            $excerpt = excerpt_text($text, 220);
        }
        $metaDesc = trim($it['meta']['_yoast_wpseo_metadesc'] ?? '');
        $seoAuto = 0;
        if ($metaDesc === '') {
            $metaDesc = HtmlCleaner::draftDescription($content, $excerpt);
            $seoAuto = 1;
        }
        $cover = $this->cover($it);

        $data = [
            'wp_id' => $it['id'],
            'type' => $type,
            'locale' => 'es',
            'translation_group' => self::uuid('wp-' . $it['id']),
            'slug' => $it['slug'],
            'title' => $it['title'],
            'excerpt' => $excerpt,
            'content_html' => $content,
            'content_text' => $text,
            'cover_url' => $cover['url'],
            'cover_alt' => $cover['alt'],
            'cover_width' => $cover['width'],
            'cover_height' => $cover['height'],
            'hub_id' => $hubKey ? $this->hubIds[$hubKey] : null,
            'seo_title' => self::yoastTitle($it['meta']['_yoast_wpseo_title'] ?? '', $it['title']),
            'seo_description' => mb_substr($metaDesc, 0, 320),
            'seo_auto' => $seoAuto,
            'focus_keyword' => ($kw = trim($it['meta']['_yoast_wpseo_focuskw'] ?? '')) !== '' ? $kw : null,
            'reading_minutes' => HtmlCleaner::readingMinutes($text),
            'published_at' => self::date($it['date_gmt'], $it['date']),
            'updated_at' => self::date($it['modified_gmt'], '') ?? self::date($it['date_gmt'], $it['date']),
        ];
        $existing = DB::value('SELECT id FROM posts WHERE wp_id = :w', ['w' => $it['id']]);
        if ($existing === null) {
            $data['status'] = 'published';
            $postId = DB::insert('posts', $data);
        } else {
            // En una nueva ejecución no se tocan los campos editoriales (estado, avisos, canonical…).
            $postId = (int) $existing;
            DB::update('posts', $data, ['id' => $postId]);
        }

        DB::run('DELETE FROM post_category WHERE post_id = :p', ['p' => $postId]);
        $first = true;
        foreach ($categories as $slug => $name) {
            DB::run('INSERT IGNORE INTO post_category (post_id, category_id, is_primary) VALUES (:p, :c, :pr)', [
                'p' => $postId,
                'c' => $this->categoryId($slug, $name),
                'pr' => $first ? 1 : 0,
            ]);
            $first = false;
        }
    }

    private function importProduct(array $it): void
    {
        $visibility = array_keys($it['terms']['product_visibility'] ?? []);
        $cats = array_keys($it['terms']['product_cat'] ?? []);
        $virtual = ($it['meta']['_virtual'] ?? 'no') === 'yes';
        $downloadable = ($it['meta']['_downloadable'] ?? 'no') === 'yes';
        $type = 'download';
        if (!$downloadable) {
            $type = in_array('cursos', $cats, true) ? 'course' : ($virtual ? 'service' : 'download');
        }
        $price = (float) (($it['meta']['_price'] ?? '') !== '' ? $it['meta']['_price'] : ($it['meta']['_regular_price'] ?? 0));
        $cover = $this->cover($it);
        $cleaner = new HtmlCleaner($this->attachments, $this->productSlugs);
        $short = $cleaner->clean($it['excerpt'], ['slug' => $it['slug'], 'title' => $it['title']]);
        $description = $cleaner->clean($it['content'], ['slug' => $it['slug'], 'title' => $it['title']]);

        $productData = [
            'wp_id' => $it['id'],
            'sku' => ($sku = trim($it['meta']['_sku'] ?? '')) !== '' ? $sku : null,
            'type' => $type,
            'price_usd' => $price,
            'featured' => in_array('featured', $visibility, true) ? 1 : 0,
            'cover_url' => $cover['url'],
            'cover_alt' => $cover['alt'],
            'cover_width' => $cover['width'],
            'cover_height' => $cover['height'],
            'legacy_sales' => (int) ($it['meta']['total_sales'] ?? 0),
        ];
        $existing = DB::value('SELECT id FROM products WHERE wp_id = :w', ['w' => $it['id']]);
        if ($existing === null) {
            $productData['status'] = in_array('exclude-from-catalog', $visibility, true) ? 'hidden' : 'active';
            $productId = DB::insert('products', $productData);
        } else {
            $productId = (int) $existing;
            DB::update('products', $productData, ['id' => $productId]);
        }

        $metaDesc = trim($it['meta']['_yoast_wpseo_metadesc'] ?? '');
        $textAll = HtmlCleaner::toText($short . ' ' . $description);
        DB::upsert('product_translations', [
            'product_id' => $productId,
            'locale' => 'es',
            'slug' => $it['slug'],
            'title' => $it['title'],
            'short_html' => $short,
            'description_html' => $description,
            'search_text' => $textAll,
            'seo_title' => self::yoastTitle($it['meta']['_yoast_wpseo_title'] ?? '', $it['title']),
            'seo_description' => mb_substr($metaDesc !== '' ? $metaDesc : HtmlCleaner::draftDescription($short . $description, $it['title']), 0, 320),
        ], ['product_id', 'locale']);

        // Galería
        DB::run('DELETE FROM product_images WHERE product_id = :p', ['p' => $productId]);
        $gallery = array_filter(array_map('intval', explode(',', $it['meta']['_product_image_gallery'] ?? '')));
        foreach (array_values($gallery) as $i => $attId) {
            $att = $this->attachments->get($attId);
            if ($att === null) {
                continue;
            }
            $size = $att['sizes']['large'] ?? null;
            DB::insert('product_images', [
                'product_id' => $productId,
                'url' => $size['url'] ?? $att['url'],
                'alt' => $att['alt'] ?: $it['title'],
                'width' => $size['width'] ?? ($att['width'] ?: null),
                'height' => $size['height'] ?? ($att['height'] ?: null),
                'sort' => $i,
            ]);
        }

        // Archivos descargables: se guarda la URL original; storage_path queda vacío hasta copiar el archivo.
        $files = @unserialize($it['meta']['_downloadable_files'] ?? '', ['allowed_classes' => false]);
        if (is_array($files)) {
            foreach ($files as $file) {
                $source = trim((string) ($file['file'] ?? ''));
                if ($source === '') {
                    continue;
                }
                $label = trim((string) ($file['name'] ?? '')) ?: basename(rawurldecode((string) parse_url($source, PHP_URL_PATH)));
                $id = DB::value('SELECT id FROM product_files WHERE product_id = :p AND source_url = :s', ['p' => $productId, 's' => $source]);
                if ($id === null) {
                    DB::insert('product_files', ['product_id' => $productId, 'label' => $label, 'source_url' => $source]);
                } else {
                    DB::update('product_files', ['label' => $label], ['id' => (int) $id]);
                }
            }
        }
    }
}
