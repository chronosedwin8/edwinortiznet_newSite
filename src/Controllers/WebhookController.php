<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\DB;
use App\Core\Logger;
use App\Core\Request;
use App\Core\Response;
use App\Services\Orders\OrderService;
use App\Services\Payments\GatewayResolver;
use App\Services\Payments\PayPal;
use App\Services\Payments\Status;

/**
 * /webhooks/{mercadopago|wompi|paypal}: firma inválida → 401; evento duplicado → 200 sin reprocesar.
 * Cada evento queda en payment_events (único por pasarela + id de evento).
 */
final class WebhookController extends Controller
{
    public function ping(Request $request, string $gateway): Response
    {
        return Response::json(['ok' => true, 'gateway' => $gateway]);
    }

    public function handle(Request $request, string $gateway): Response
    {
        $adapter = GatewayResolver::make($gateway);
        try {
            $result = $adapter->handleWebhook($request);
        } catch (\Throwable $e) {
            Logger::error('Webhook: error al validar', ['gateway' => $gateway, 'error' => $e->getMessage()]);
            return Response::json(['error' => 'temporary'], 500);
        }
        if (!$result->valid) {
            Logger::warning('Webhook con firma inválida', ['gateway' => $gateway, 'ip' => $request->ip()]);
            return Response::json(['error' => 'invalid_signature'], 401);
        }

        $eventId = mb_substr((string) $result->eventId, 0, 190);
        $inserted = DB::run(
            'INSERT IGNORE INTO payment_events (gateway, event_id, event_type, payload, signature_ok) VALUES (:g, :e, :t, :p, 1)',
            ['g' => $gateway, 'e' => $eventId, 't' => $result->eventType, 'p' => json_encode($result->payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)]
        )->rowCount();
        if ($inserted === 0) {
            $processed = DB::value('SELECT processed_at FROM payment_events WHERE gateway = :g AND event_id = :e', ['g' => $gateway, 'e' => $eventId]);
            if ($processed !== null) {
                return Response::json(['ok' => true, 'result' => 'duplicate']);
            }
        }

        $outcome = ['result' => 'ignored', 'order_id' => null];
        if (!$result->ignored && $result->status !== null) {
            $status = $result->status;
            if (($status->raw['needs_capture'] ?? false) && $adapter instanceof PayPal && $status->reference !== null) {
                // CHECKOUT.ORDER.APPROVED: el comprador no volvió al sitio; se captura desde aquí.
                $order = OrderService::byReference($status->reference);
                $status = $order !== null ? $adapter->capture($order, (string) $status->gatewayId) : $status;
            }
            $outcome = OrderService::apply($gateway, $status);
        }
        DB::run(
            'UPDATE payment_events SET processed_at = UTC_TIMESTAMP(), result = :r, order_id = :o WHERE gateway = :g AND event_id = :e',
            ['r' => $outcome['result'], 'o' => $outcome['order_id'], 'g' => $gateway, 'e' => $eventId]
        );
        return Response::json(['ok' => true, 'result' => $outcome['result']]);
    }
}
