<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Hub;
use App\Models\Post;
use App\Models\Product;
use App\Services\I18n\I18n;
use App\Services\Seo\Meta;
use App\Services\Tools\ToolRegistry;

final class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        $locale = I18n::locale();
        // Pestañas por sección: las mismas del menú principal (Secciones → "Mostrar en el menú").
        $hubs = [];
        foreach (Hub::menu($locale) as $hub) {
            $hub['posts'] = Post::latest($locale, 3, 0, (int) $hub['id']);
            $hubs[] = $hub;
        }
        if ($locale === 'en') {
            // En inglés hay pocos artículos por hub: se muestran también los últimos en general.
            $latest = Post::latest('en', 3);
        }

        return $this->page('pages/home', [
            'bestSellers' => Product::bestSellers($locale, 6),
            'salesTotal' => (int) \App\Core\DB::value('SELECT COALESCE(SUM(legacy_sales + sales_count), 0) FROM products'),
            'productCount' => (int) \App\Core\DB::value('SELECT COUNT(*) FROM products p JOIN product_translations t ON t.product_id = p.id AND t.locale = :l WHERE p.status = "active"', ['l' => $locale]),
            'postCount' => \App\Models\Post::countPublished($locale),
            'tools' => ToolRegistry::forLocale($locale),
            'hubs' => $hubs,
            'latest' => $latest ?? [],
        ], [
            'title' => t('seo.home.title'),
            'title_full' => true,
            'description' => t('seo.home.description'),
            'alternates' => ['es' => '/', 'en' => '/en/'],
            'breadcrumbs' => [],
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@graph' => [Meta::person(), Meta::website()],
            ]],
            'body_class' => 'page-home',
        ]);
    }
}
