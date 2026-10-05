<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Services\I18n\I18n;
use App\Services\Orders\OrderService;

final class CartController extends Controller
{
    /** /carrito/: el contenido vive en localStorage; la página lo pinta con JS y valida con /api/carrito. */
    public function show(Request $request): Response
    {
        $crumbs = [[t('nav.home'), route('home')], [t('cart.title'), route('cart')]];
        return $this->page('pages/cart', ['crumbs' => $crumbs], [
            'title' => t('cart.title'),
            'noindex' => true,
            'alternates' => ['es' => route('cart', [], 'es'), 'en' => route('cart', [], 'en')],
            'breadcrumbs' => $crumbs,
            'scripts' => ['js/cart-page.js'],
            'body_class' => 'page-cart',
        ]);
    }

    /** Valida ids del carrito y devuelve precios actuales calculados en el servidor. */
    public function validate(Request $request): Response
    {
        $data = $request->json() ?: $request->post;
        $locale = ($data['lang'] ?? 'es') === 'en' ? 'en' : 'es';
        I18n::setLocale($locale);
        $ids = is_array($data['items'] ?? null) ? $data['items'] : explode(',', (string) ($data['items'] ?? ''));
        $cart = OrderService::cart($locale, $ids);
        return Response::json([
            'currency' => $cart['currency'],
            'total' => $cart['total'],
            'total_label' => money($cart['total'], $cart['currency']),
            'removed' => $cart['removed'],
            'items' => array_map(fn ($p) => [
                'id' => (int) $p['id'],
                'title' => $p['title'],
                'url' => product_path($p, $locale),
                'img' => $p['cover_url'],
                'cop' => (int) $p['price_cop'],
                'usd' => (float) $p['price_usd'],
            ], $cart['items']),
        ]);
    }
}
