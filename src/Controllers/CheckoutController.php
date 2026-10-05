<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Logger;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\I18n\I18n;
use App\Services\Orders\OrderService;
use App\Services\Payments\GatewayException;
use App\Services\Payments\GatewayResolver;

/**
 * Carrito y pago en una sola página: resumen, datos, pasarela y aceptación de términos.
 */
final class CheckoutController extends Controller
{
    private function ids(Request $request): array
    {
        $raw = $request->input('items', '');
        return is_array($raw) ? $raw : explode(',', (string) $raw);
    }

    public function show(Request $request, array $errors = [], array $old = []): Response
    {
        $locale = I18n::locale();
        $cart = OrderService::cart($locale, $this->ids($request));
        $crumbs = [[t('nav.home'), route('home')], [t('checkout.title'), route('checkout')]];
        $response = $this->page('pages/checkout', [
            'cart' => $cart,
            'gateways' => GatewayResolver::allowed($locale),
            'errors' => $errors,
            'old' => $old,
            'crumbs' => $crumbs,
        ], [
            'title' => t('checkout.title'),
            'noindex' => true,
            'alternates' => ['es' => route('checkout', [], 'es'), 'en' => route('checkout', [], 'en')],
            'breadcrumbs' => $crumbs,
            'scripts' => ['js/checkout.js'],
            'body_class' => 'page-checkout',
        ]);
        if ($errors) {
            $response->status = 422;
        }
        return $response;
    }

    public function create(Request $request): Response
    {
        $this->requireCsrf($request);
        $locale = I18n::locale();
        if (!RateLimiter::hit('checkout', $request->ip(), 15, 3600)) {
            return $this->show($request, ['form' => t('form.rate_limited')], $request->post);
        }
        $data = [
            'name' => mb_substr($request->str('name'), 0, 190),
            'email' => strtolower(mb_substr($request->str('email'), 0, 190)),
            'document' => mb_substr($request->str('document'), 0, 40),
            'phone' => mb_substr($request->str('phone'), 0, 40),
        ];
        $gateway = $request->str('gateway');
        $errors = [];
        if ($data['name'] === '') {
            $errors['name'] = t('checkout.error.name');
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = t('checkout.error.email');
        }
        if ($request->input('terms') !== '1') {
            $errors['terms'] = t('checkout.error.terms');
        }
        // El servidor rechaza cualquier pasarela que no corresponda al idioma (p. ej. PayPal en español).
        if (!GatewayResolver::isAllowed($locale, $gateway)) {
            $errors['gateway'] = t('checkout.error.gateway');
        }
        if ($errors) {
            return $this->show($request, $errors, $request->post);
        }
        try {
            $order = OrderService::create($locale, $this->ids($request), $data, $gateway, $request->ip());
        } catch (\DomainException) {
            return $this->show($request, ['form' => t('checkout.empty')], $request->post);
        }
        try {
            return $this->redirect(OrderService::checkout($order));
        } catch (GatewayException | \Throwable $e) {
            Logger::error('No se pudo iniciar el pago', ['reference' => $order['reference'], 'error' => $e->getMessage()]);
            return $this->redirect(route('order', ['token' => $order['token'], 'error' => 'gateway']));
        }
    }
}
