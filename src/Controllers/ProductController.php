<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Models\Post;
use App\Models\Product;
use App\Services\Content\ContentRenderer;
use App\Services\I18n\I18n;
use App\Services\Seo\Meta;
use App\Services\Waitlist;

final class ProductController extends Controller
{
    public function show(Request $request, string $slug): Response
    {
        $locale = I18n::locale();
        $product = Product::bySlug($locale, $slug);
        if ($product === null) {
            $this->notFound();
        }
        $images = Product::images((int) $product['id']);
        $tutorial = null;
        if ($product['tutorial_post_id']) {
            $tutorial = Post::find((int) $product['tutorial_post_id']);
            $tutorial = $tutorial ? Post::translation($tutorial, $locale) : null;
            if ($tutorial !== null && $tutorial['status'] !== 'published') {
                $tutorial = null;
            }
        }
        $packItems = $product['type'] === 'pack'
            ? Product::byIds(DB::column('SELECT product_id FROM pack_items WHERE pack_id = :p', ['p' => (int) $product['id']]), $locale)
            : [];
        $faqs = Product::faqs($product);
        $path = product_path($product);
        $crumbs = [[t('nav.home'), route('home')], [t('nav.shop'), route('shop')]];
        if (!empty($product['family_slug'])) {
            $crumbs[] = [$product['family_name'], route('shop.family', ['slug' => $product['family_slug']])];
        }
        $crumbs[] = [$product['title'], $path];

        $currency = I18n::currency();
        $price = Product::chargePrice($product, $locale);
        $availability = $product['purchasable'] ? 'https://schema.org/InStock'
            : ($product['status'] === 'coming_soon' ? 'https://schema.org/PreOrder' : 'https://schema.org/OutOfStock');
        $image = $product['cover_url'] ?: null;
        $description = ContentRenderer::render($product + ['content_html' => $product['description_html'], 'id' => 0, 'no_ads' => 1])['html'];

        return $this->page('pages/product', [
            'product' => $product,
            'images' => $images,
            'description' => $description,
            'tutorial' => $tutorial,
            'family' => Product::sameFamily($product, 3),
            'packItems' => $packItems,
            // Variantes (p. ej. la materia del kit): el comprador debe elegir una antes de pagar.
            'variants' => $product['purchasable'] && (int) $product['variant_count'] > 0 ? Product::variants((int) $product['id'], $locale) : [],
            'faqs' => $faqs,
            'crumbs' => $crumbs,
            'waitlisted' => isset($request->query['lista']),
        ], [
            'title' => $product['seo_title'] ?: $product['title'],
            'description' => $product['seo_description'] ?: excerpt_text($product['short_html'] ?: $product['description_html'], 158),
            'noindex' => $product['status'] === 'hidden',
            'alternates' => Product::alternates((int) $product['id']),
            'breadcrumbs' => $crumbs,
            'og_type' => 'product',
            'image' => $image,
            'preload_image' => $image,
            'preload_srcset' => $product['cover_srcset'] ?? null,
            'preload_sizes' => \App\Services\Seo\Assets::PRODUCT_SIZES,
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@type' => $product['type'] === 'course' ? ['Product', 'Course'] : 'Product',
                'name' => $product['title'],
                'description' => excerpt_text($product['short_html'] ?: $product['description_html'], 300),
                'image' => array_values(array_filter(array_merge([$image], array_column($images, 'url')))),
                'sku' => $product['sku'] ?: ('EO-' . $product['id']),
                'brand' => ['@type' => 'Brand', 'name' => 'Edwin Ortiz Herazo'],
                'inLanguage' => I18n::meta('html'),
                'provider' => $product['type'] === 'course' ? ['@type' => 'Person', 'name' => 'Edwin Ortiz Herazo'] : null,
                'offers' => [
                    '@type' => 'Offer',
                    'price' => $currency === 'COP' ? (string) (int) $price : number_format($price, 2, '.', ''),
                    'priceCurrency' => $currency,
                    'availability' => $availability,
                    'url' => url($path),
                    'seller' => ['@type' => 'Person', 'name' => 'Edwin Ortiz Herazo'],
                ],
            ], Meta::faqPage($faqs)],
            'scripts' => ['js/product.js'],
            'body_class' => 'page-product',
        ]);
    }

    /** Formulario "Avísame cuando salga" → waitlist + correo de confirmación. */
    public function waitlist(Request $request): Response
    {
        $this->requireHuman($request);
        $locale = I18n::locale();
        if (!RateLimiter::hit('waitlist', $request->ip(), 10, 3600)) {
            return $this->reply($request, false, t('form.rate_limited'), 429);
        }
        $email = strtolower($request->str('email'));
        $productId = (int) $request->input('product_id');
        $product = $productId ? Product::find($productId, $locale) : null;
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $product === null) {
            return $this->reply($request, false, t('form.invalid_email'), 422);
        }
        Waitlist::add($product, $email, $locale);
        return $this->reply($request, true, t('waitlist.ok'), 200, product_path($product) . '?lista=ok#waitlist');
    }

    private function reply(Request $request, bool $ok, string $message, int $status, ?string $back = null): Response
    {
        if ($request->wantsJson()) {
            return Response::json(['ok' => $ok, 'message' => $message], $status);
        }
        return $this->redirect($back ?? $this->back($request, route('shop')));
    }
}
