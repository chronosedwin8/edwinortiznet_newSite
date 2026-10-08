<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Models\Hub;
use App\Models\Post;
use App\Models\Product;
use App\Services\Content\ContentRenderer;
use App\Services\I18n\I18n;
use App\Services\Seo\Meta;

/**
 * Ruta comodín /{slug}/ (y /en/{slug}/): hubs, entradas y páginas importadas.
 */
final class ContentController extends Controller
{
    public function show(Request $request, string $slug): Response
    {
        $locale = I18n::locale();
        $hub = Hub::bySlug($locale, $slug);
        if ($hub !== null && $hub['key'] !== 'herramientas') {
            return $this->hub($hub);
        }
        $post = Post::findVisible($locale, $slug);
        if ($post === null) {
            $this->notFound();
        }
        return $post['type'] === 'post' ? $this->article($post) : $this->pageView($post);
    }

    private function hub(array $hub): Response
    {
        $locale = $hub['locale'];
        $pillar = $hub['pillar_post_id'] ? Post::find((int) $hub['pillar_post_id']) : null;
        if ($pillar !== null && $pillar['locale'] !== $locale) {
            $pillar = Post::translation($pillar, $locale);
        }
        $posts = Post::latest($locale, 60, 0, (int) $hub['id'], $pillar ? [(int) $pillar['id']] : []);
        $audience = ['excel' => 'oficina', 'ia-para-docentes' => 'docente', 'concurso-docente' => 'concurso'][$hub['key']] ?? null;
        $products = $audience ? array_slice(Product::catalog($locale, ['audience' => $audience]), 0, 4) : [];
        $faqs = Hub::faqs($hub);
        $path = Hub::path($hub);

        return $this->page('pages/hub', [
            'hub' => $hub, 'pillar' => $pillar, 'posts' => $posts, 'products' => $products, 'faqs' => $faqs,
        ], [
            'title' => $hub['seo_title'] ?: $hub['title'],
            'title_full' => (bool) $hub['seo_title'],
            'description' => $hub['seo_description'] ?: excerpt_text($hub['intro_html'], 158),
            'alternates' => Hub::alternates((int) $hub['id']),
            'breadcrumbs' => [[t('nav.home'), route('home')], [$hub['title'], $path]],
            'jsonld' => [Meta::faqPage($faqs), [
                '@context' => 'https://schema.org',
                '@type' => 'CollectionPage',
                'name' => $hub['title'],
                'url' => url($path),
                'inLanguage' => I18n::meta('html'),
            ]],
            'body_class' => 'page-hub',
        ]);
    }

    /** Producto que se ofrece en un artículo: el relacionado, o uno según el hub. */
    public static function relatedProduct(array $post): ?array
    {
        $locale = $post['locale'];
        if (!empty($post['related_product_id'])) {
            $product = Product::find((int) $post['related_product_id'], $locale);
            if ($product !== null && $product['status'] !== 'hidden') {
                return $product;
            }
        }
        $hubKey = $post['hub_id'] ? DB::value('SELECT `key` FROM hubs WHERE id = :id', ['id' => (int) $post['hub_id']]) : null;
        $sku = ['ia-para-docentes' => 'EO-KIT-IA'][$hubKey] ?? null;
        if ($sku !== null) {
            $id = DB::value('SELECT id FROM products WHERE sku = :s', ['s' => $sku]);
            $product = $id !== null ? Product::find((int) $id, $locale) : null;
            if ($product !== null) {
                return $product;
            }
        }
        return Product::bestSellers($locale, 1)[0] ?? null;
    }

    private function article(array $post): Response
    {
        $locale = $post['locale'];
        $hub = $post['hub_id'] ? Hub::byId((int) $post['hub_id'], $locale) : null;
        $isContest = ($hub['key'] ?? null) === 'concurso-docente';
        $product = $isContest ? null : self::relatedProduct($post);
        $inline = $isContest ? \App\Core\View::render('partials/fundales-cta', ['campaign' => 'articulo-' . substr($post['slug'], 0, 60), 'variant' => 'card']) : null;
        // Las reseñas de herramientas de Grupo Logic ya enlazan su producto: sin tarjeta de la tienda a mitad del texto.
        if ($inline === null && str_contains((string) $post['content_html'], 'grupologiclatam.com/productos/')) {
            $inline = '';
        }
        $rendered = ContentRenderer::render($post, $product, true, $inline);
        $path = post_path($post);
        $crumbs = [[t('nav.home'), route('home')]];
        $crumbs[] = $hub ? [$hub['menu_title'] ?: $hub['title'], Hub::path($hub)] : [t('nav.blog'), route('blog')];
        $crumbs[] = [$post['title'], $path];
        $image = $post['cover_url'] ?: null;
        // Las portadas propias son rutas locales; Open Graph y JSON-LD necesitan la URL completa.
        $imageAbs = $image !== null && str_starts_with($image, '/') ? url($image) : $image;
        // Para compartir: JPEG 1200×630 derivado de las portadas WebP (WhatsApp y LinkedIn no siempre muestran WebP).
        $og = \App\Services\Seo\OgImage::forCover($image, $post['cover_srcset'] ?? null);

        return $this->page('pages/article', [
            'post' => $post,
            'hub' => $hub,
            'html' => $rendered['html'],
            'toc' => $rendered['toc'],
            'product' => $product,
            'isContest' => $isContest,
            'siblings' => Post::siblings($post, 2),
            'crumbs' => $crumbs,
            // Conteos al momento de generar la página (puede quedar en caché); article.js los actualiza.
            'reactions' => \App\Services\Reactions::summary((int) $post['id']),
        ], [
            'title' => $post['seo_title'] ?: $post['title'],
            'description' => $post['seo_description'] ?: $post['excerpt'],
            'canonical' => $post['canonical_url'] ?: $path,
            'noindex' => $post['status'] === 'noindex',
            'alternates' => Post::alternates($post),
            'breadcrumbs' => $crumbs,
            'og_type' => 'article',
            'image' => $og !== null ? url($og['url']) : $imageAbs,
            'image_width' => $og['width'] ?? ($post['cover_width'] ? (int) $post['cover_width'] : null),
            'image_height' => $og['height'] ?? ($post['cover_height'] ? (int) $post['cover_height'] : null),
            'image_alt' => $image !== null ? ($post['cover_alt'] ?: $post['title']) : null,
            'article_section' => $hub ? ($hub['menu_title'] ?: $hub['title']) : null,
            'preload_image' => $image,
            'preload_srcset' => $post['cover_srcset'] ?? null,
            'preload_sizes' => \App\Services\Seo\Assets::COVER_SIZES,
            'published' => $post['published_at'] ? gmdate('c', strtotime($post['published_at'] . ' UTC')) : null,
            'modified' => $post['updated_at'] ? gmdate('c', strtotime($post['updated_at'] . ' UTC')) : null,
            'ads' => empty($post['no_ads']),
            'scripts' => ['js/article.js', ...ContentRenderer::scripts($rendered['html'])],
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@type' => 'Article',
                'headline' => mb_substr($post['title'], 0, 110),
                'description' => $post['seo_description'] ?: $post['excerpt'],
                'image' => $imageAbs ? [$imageAbs] : null,
                'datePublished' => $post['published_at'] ? gmdate('c', strtotime($post['published_at'] . ' UTC')) : null,
                'dateModified' => $post['updated_at'] ? gmdate('c', strtotime($post['updated_at'] . ' UTC')) : null,
                'inLanguage' => I18n::meta('html'),
                'author' => Meta::person(),
                'publisher' => ['@type' => 'Person', 'name' => 'Edwin Ortiz Herazo', 'url' => url('/')],
                'mainEntityOfPage' => url($path),
                'wordCount' => str_word_count((string) iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', (string) $post['content_text'])),
            ], Meta::faqPage(ContentRenderer::faqs((string) $post['content_html']))],
            'body_class' => 'page-article',
        ]);
    }

    private function pageView(array $post): Response
    {
        $path = post_path($post);
        $crumbs = [[t('nav.home'), route('home')], [$post['title'], $path]];
        $html = ContentRenderer::render($post)['html'];
        return $this->page('pages/page', [
            'post' => $post,
            'html' => $html,
            'crumbs' => $crumbs,
        ], [
            'title' => $post['seo_title'] ?: $post['title'],
            'description' => $post['seo_description'] ?: $post['excerpt'],
            'canonical' => $post['canonical_url'] ?: $path,
            'noindex' => $post['status'] === 'noindex',
            'alternates' => Post::alternates($post),
            'breadcrumbs' => $crumbs,
            'image' => $post['cover_url'] ?: null,
            'scripts' => ContentRenderer::scripts($html),
            'body_class' => 'page-page',
        ]);
    }
}
