<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Family;
use App\Models\Post;
use App\Models\Product;
use App\Services\I18n\I18n;
use App\Services\Seo\Meta;

final class ShopController extends Controller
{
    public const AUDIENCES = ['oficina', 'docente', 'concurso'];
    public const PRICE_RANGES = ['hasta-20' => [0, 20], '20-40' => [20.01, 40], 'mas-de-40' => [40.01, 100000]];

    public function index(Request $request): Response
    {
        return $this->catalog($request, null);
    }

    public function family(Request $request, string $slug): Response
    {
        $family = Family::bySlug(I18n::locale(), $slug);
        if ($family === null) {
            $this->notFound();
        }
        return $this->catalog($request, $family);
    }

    private function catalog(Request $request, ?array $family): Response
    {
        $locale = I18n::locale();
        $audience = in_array($request->query['perfil'] ?? null, self::AUDIENCES, true) ? $request->query['perfil'] : null;
        $priceKey = isset(self::PRICE_RANGES[$request->query['precio'] ?? '']) ? $request->query['precio'] : null;
        $all = Product::catalog($locale, $family ? ['family_id' => $family['id']] : []);
        $filtered = array_values(array_filter($all, function (array $p) use ($audience, $priceKey): bool {
            if ($audience !== null && $p['audience'] !== $audience) {
                return false;
            }
            if ($priceKey !== null) {
                [$min, $max] = self::PRICE_RANGES[$priceKey];
                return (float) $p['price_usd'] >= $min && (float) $p['price_usd'] <= $max;
            }
            return true;
        }));
        $families = Family::all($locale);
        // Tabla comparativa: familias con dos o más productos activos.
        $comparison = [];
        foreach ($families as $f) {
            $items = array_values(array_filter($all, fn ($p) => (int) $p['family_id'] === (int) $f['id'] && $p['status'] === 'active'));
            if (count($items) >= 2 && ($family === null || (int) $family['id'] === (int) $f['id'])) {
                $comparison[] = ['family' => $f, 'items' => $items];
            }
        }
        $path = $family ? route('shop.family', ['slug' => $family['slug']]) : route('shop');
        $crumbs = [[t('nav.home'), route('home')], [t('nav.shop'), route('shop')]];
        if ($family) {
            $crumbs[] = [$family['name'], $path];
        }
        $listItems = [];
        foreach (array_slice($filtered, 0, 20) as $i => $p) {
            $listItems[] = ['@type' => 'ListItem', 'position' => $i + 1, 'url' => url(product_path($p)), 'name' => $p['title']];
        }
        return $this->page('pages/shop', [
            'products' => $all,
            'visibleIds' => array_map('intval', array_column($filtered, 'id')),
            'total' => count($all),
            'families' => $families,
            'family' => $family,
            'audience' => $audience,
            'priceKey' => $priceKey,
            'comparison' => $comparison,
            'crumbs' => $crumbs,
        ], [
            'title' => $family ? t('shop.family_title', ['name' => $family['name']]) : t('shop.seo_title'),
            'description' => $family ? excerpt_text($family['description_html'], 158) : t('shop.seo_description'),
            'canonical' => $path,
            'alternates' => $family ? Family::alternates((int) $family['id']) : ['es' => route('shop', [], 'es'), 'en' => route('shop', [], 'en')],
            'breadcrumbs' => $crumbs,
            'jsonld' => [['@context' => 'https://schema.org', '@type' => 'ItemList', 'itemListElement' => $listItems]],
            'scripts' => ['js/shop.js'],
            'body_class' => 'page-shop',
        ]);
    }

    /** /cursos/: productos tipo curso y listas de YouTube enlazadas en /cursos-de-informatica-y-tecnologia/. */
    public function courses(Request $request): Response
    {
        $locale = I18n::locale();
        $courses = Product::catalog($locale, ['type' => 'course']);
        $page = Post::findVisible($locale, 'cursos-de-informatica-y-tecnologia', ['page']);
        $playlists = [];
        if ($page !== null && preg_match_all('#<a[^>]+href="(https://(?:www\.)?youtube\.com/playlist\?list=[^"]+)"[^>]*>(.*?)</a>#is', (string) $page['content_html'], $m, PREG_SET_ORDER)) {
            foreach ($m as $link) {
                $href = html_entity_decode($link[1]);
                $text = trim(strip_tags($link[2]));
                $playlists[$href] = $text !== '' ? $text : t('courses.playlist');
            }
        }
        $crumbs = [[t('nav.home'), route('home')], [t('courses.title'), route('courses')]];
        $jsonld = [];
        foreach ($courses as $c) {
            $jsonld[] = [
                '@context' => 'https://schema.org', '@type' => 'Course',
                'name' => $c['title'], 'description' => excerpt_text($c['short_html'] ?: $c['description_html'], 200),
                'url' => url(product_path($c)), 'inLanguage' => I18n::meta('html'),
                'provider' => ['@type' => 'Person', 'name' => 'Edwin Ortiz Herazo', 'url' => url('/sobre-mi/')],
            ];
        }
        return $this->page('pages/courses', [
            'courses' => $courses,
            'playlists' => $playlists,
            'guide' => $page,
            'crumbs' => $crumbs,
        ], [
            'title' => t('courses.seo_title'),
            'description' => t('courses.seo_description'),
            'breadcrumbs' => $crumbs,
            'jsonld' => $jsonld,
            'body_class' => 'page-courses',
        ]);
    }
}
