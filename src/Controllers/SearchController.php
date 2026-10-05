<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\I18n\I18n;
use App\Services\Search\Search;

final class SearchController extends Controller
{
    public function page(Request $request): Response
    {
        $q = is_string($request->query['q'] ?? null) ? trim($request->query['q']) : '';
        $results = $q !== '' && RateLimiter::hit('search', $request->ip(), 120, 60)
            ? Search::run($q, I18n::locale(), 20, 12)
            : ['posts' => [], 'products' => []];
        $crumbs = [[t('nav.home'), route('home')], [t('search.title'), route('search')]];
        return $this->page('pages/search', ['q' => $q, 'results' => $results, 'crumbs' => $crumbs], [
            'title' => $q !== '' ? t('search.results_for', ['q' => $q]) : t('search.title'),
            'noindex' => true,
            'breadcrumbs' => $crumbs,
            'body_class' => 'page-search',
        ]);
    }

    /** /api/buscar?q=…&lang=es|en — resultados agrupados para el buscador instantáneo. */
    public function api(Request $request): Response
    {
        $locale = ($request->query['lang'] ?? 'es') === 'en' ? 'en' : 'es';
        I18n::setLocale($locale);
        $q = is_string($request->query['q'] ?? null) ? $request->query['q'] : '';
        if (!RateLimiter::hit('search', $request->ip(), 120, 60)) {
            return Response::json(['error' => 'rate_limited'], 429);
        }
        $results = Search::run($q, $locale);
        $posts = array_map(fn ($p) => [
            'title' => $p['title'],
            'url' => post_path($p),
            'meta' => fdate($p['published_at'], 'short'),
        ], $results['posts']);
        $products = array_map(fn ($p) => [
            'title' => $p['title'],
            'url' => route('product', ['slug' => $p['slug']], $locale),
            'meta' => $p['status'] === 'coming_soon' ? t('product.coming_soon') : ($locale === 'es' ? money($p['price_cop'], 'COP') : money($p['price_usd'], 'USD')),
        ], $results['products']);
        return Response::json(['q' => $q, 'posts' => $posts, 'products' => $products, 'all' => route('search', ['q' => $q])])
            ->header('Cache-Control', 'public, max-age=300');
    }
}
