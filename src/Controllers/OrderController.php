<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\Logger;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\Downloads\DownloadService;
use App\Services\I18n\I18n;
use App\Services\Orders\OrderService;
use App\Services\Payments\GatewayResolver;
use App\Services\Payments\PayPal;

/**
 * /pedido/{token}/: estado del pedido y descargas. Los parámetros de retorno de la pasarela solo sirven
 * como pista para consultar la API servidor a servidor; nunca aprueban el pedido por sí mismos.
 */
final class OrderController extends Controller
{
    private function load(string $token): array
    {
        $order = OrderService::byToken($token);
        if ($order === null || $order['locale'] !== I18n::locale()) {
            $this->notFound();
        }
        return $order;
    }

    public function show(Request $request, string $token): Response
    {
        $order = $this->load($token);
        if ($order['status'] === 'pending' && !isset($request->query['cancelled'])) {
            $hint = match ($order['gateway']) {
                'mercadopago' => is_string($request->query['payment_id'] ?? null) ? $request->query['payment_id'] : null,
                'wompi' => is_string($request->query['id'] ?? null) ? $request->query['id'] : null,
                'paypal' => is_string($request->query['token'] ?? null) ? $request->query['token'] : null,
                default => null,
            };
            if ($hint !== null && RateLimiter::hit('order-check', $request->ip(), 30, 600)) {
                if ($order['gateway'] === 'paypal' && $hint === $order['gateway_id']) {
                    // Regreso de PayPal: captura servidor a servidor.
                    try {
                        $gateway = GatewayResolver::make('paypal');
                        if ($gateway instanceof PayPal) {
                            OrderService::apply('paypal', $gateway->capture($order, $hint), (int) $order['id']);
                        }
                    } catch (\Throwable $e) {
                        Logger::warning('Captura de PayPal fallida', ['reference' => $order['reference'], 'error' => $e->getMessage()]);
                    }
                } elseif ($order['gateway'] !== 'paypal') {
                    OrderService::refresh($order, $hint);
                }
                $order = $this->load($token);
            }
        }
        $crumbs = [[t('nav.home'), route('home')], [t('order.title', ['ref' => $order['reference']]), route('order', ['token' => $token])]];
        return $this->page('pages/order', [
            'order' => $order,
            'downloads' => DownloadService::forOrder((int) $order['id']),
            'gateways' => GatewayResolver::allowed($order['locale']),
            'gatewayError' => isset($request->query['error']),
            'crumbs' => $crumbs,
        ], [
            'title' => t('order.seo_title'),
            'noindex' => true,
            'breadcrumbs' => $crumbs,
            'scripts' => $order['status'] === 'pending' ? ['js/order.js'] : [],
            'body_class' => 'page-order',
        ])->header('Cache-Control', 'private, no-store');
    }

    /** Estado en JSON para el sondeo cada 3 s. Consulta la pasarela como mucho cada 15 s. */
    public function status(Request $request, string $token): Response
    {
        $order = $this->load($token);
        if ($order['status'] === 'pending'
            && (empty($order['last_checked_at']) || strtotime($order['last_checked_at'] . ' UTC') < time() - 15)
            && strtotime($order['created_at'] . ' UTC') < time() - 20) {
            OrderService::refresh($order);
            $order = $this->load($token);
        }
        return Response::json(['status' => $order['status']]);
    }

    /** Reintentar el pago: crea un pedido nuevo (referencia nueva) con los mismos productos. */
    public function pay(Request $request, string $token): Response
    {
        $this->requireCsrf($request);
        $order = $this->load($token);
        if (!in_array($order['status'], ['pending', 'declined', 'error', 'voided'], true)) {
            return $this->redirect(route('order', ['token' => $token]));
        }
        $gateway = $request->str('gateway', $order['gateway']);
        if (!GatewayResolver::isAllowed($order['locale'], $gateway)) {
            return $this->redirect(route('order', ['token' => $token, 'error' => 'gateway']));
        }
        if (!RateLimiter::hit('checkout', $request->ip(), 15, 3600)) {
            return $this->redirect(route('order', ['token' => $token, 'error' => 'rate']));
        }
        $ids = OrderService::itemLines($order);
        try {
            $new = OrderService::create($order['locale'], $ids, [
                'name' => $order['name'], 'email' => $order['email'], 'document' => (string) $order['document'], 'phone' => (string) $order['phone'],
            ], $gateway, $request->ip());
            if ($order['status'] === 'pending') {
                DB::update('orders', ['status' => 'voided'], ['id' => (int) $order['id']]);
            }
            return $this->redirect(OrderService::checkout($new));
        } catch (\Throwable $e) {
            Logger::error('Reintento de pago fallido', ['reference' => $order['reference'], 'error' => $e->getMessage()]);
            return $this->redirect(route('order', ['token' => $token, 'error' => 'gateway']));
        }
    }
}
