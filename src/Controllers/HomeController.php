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
        $hubKeys = $locale === 'es' ? ['excel', 'ia-para-docentes', 'concurso-docente'] : ['excel', 'ia-para-docentes'];
        $hubs = [];
        foreach ($hubKeys as $key) {
            $hub = Hub::byKey($key, $locale);
            if ($hub !== null) {
                $hub['posts'] = Post::latest($locale, 3, 0, (int) $hub['id']);
                $hubs[] = $hub;
            }
        }
        if ($locale === 'en') {
            // En inglés hay pocos artículos por hub: se muestran también los últimos en general.
            $latest = Post::latest('en', 3);
        }

        return $this->page('pages/home', [
            'bestSellers' => Product::bestSellers($locale, 6),
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
