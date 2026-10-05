<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Core\Cache;
use App\Core\Config;
use App\Core\HttpClient;
use App\Core\Logger;
use App\Core\Request;

/**
 * PayPal Orders v2 (USD, solo pedidos en inglés). El pedido se aprueba con la captura servidor a servidor
 * (respuesta COMPLETED con monto y moneda correctos) o con un webhook verificado por la API de PayPal.
 */
final class PayPal implements PaymentGateway
{
    private ?string $checkoutId = null;

    public function __construct(
        private readonly HttpClient $http,
        private readonly string $clientId,
        private readonly string $secret,
        private readonly string $webhookId,
        private readonly string $mode,
        private readonly string $appUrl,
    ) {
    }

    public static function fromConfig(HttpClient $http): self
    {
        return new self(
            $http,
            (string) Config::get('PAYPAL_CLIENT_ID', ''),
            (string) Config::get('PAYPAL_CLIENT_SECRET', ''),
            (string) Config::get('PAYPAL_WEBHOOK_ID', ''),
            (string) Config::get('PAYPAL_MODE', 'sandbox'),
            Config::appUrl(),
        );
    }

    public function name(): string
    {
        return 'paypal';
    }

    public function checkoutId(): ?string
    {
        return $this->checkoutId;
    }

    private function base(): string
    {
        return $this->mode === 'production' ? 'https://api-m.paypal.com' : 'https://api-m.sandbox.paypal.com';
    }

    /** Token OAuth en caché hasta que vence. */
    private function token(): string
    {
        $key = 'paypal-token-' . $this->mode . '-' . substr(hash('sha256', $this->clientId), 0, 12);
        $cached = Cache::get($key, 32000);
        if (is_array($cached) && ($cached['expires'] ?? 0) > time() + 60) {
            return (string) $cached['token'];
        }
        $res = $this->http->request('POST', $this->base() . '/v1/oauth2/token', [
            'Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->secret),
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json',
        ], 'grant_type=client_credentials');
        $token = (string) ($res['json']['access_token'] ?? '');
        if ($res['status'] !== 200 || $token === '') {
            Logger::error('PayPal: no se obtuvo el token', ['status' => $res['status']]);
            throw new GatewayException('paypal_token');
        }
        Cache::put($key, ['token' => $token, 'expires' => time() + (int) ($res['json']['expires_in'] ?? 3000)]);
        return $token;
    }

    private function headers(?string $requestId = null): array
    {
        $h = ['Authorization' => 'Bearer ' . $this->token(), 'Content-Type' => 'application/json', 'Accept' => 'application/json'];
        if ($requestId !== null) {
            $h['PayPal-Request-Id'] = $requestId;
        }
        return $h;
    }

    private static function money(float|string $value): string
    {
        return number_format((float) $value, 2, '.', '');
    }

    public function createCheckout(array $order): string
    {
        $orderUrl = $this->appUrl . '/en/order/' . $order['token'] . '/';
        $items = [];
        foreach ($order['items'] as $item) {
            $items[] = [
                'name' => mb_substr((string) $item['title'], 0, 127),
                'quantity' => (string) (int) $item['quantity'],
                'unit_amount' => ['currency_code' => 'USD', 'value' => self::money($item['unit_price'])],
                'category' => 'DIGITAL_GOODS',
            ];
        }
        $body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'reference_id' => $order['reference'],
                'custom_id' => $order['reference'],
                'invoice_id' => $order['reference'],
                'description' => 'edwinortiz.net ' . $order['reference'],
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => self::money($order['total']),
                    'breakdown' => ['item_total' => ['currency_code' => 'USD', 'value' => self::money($order['total'])]],
                ],
                'items' => $items,
            ]],
            'payment_source' => ['paypal' => ['experience_context' => [
                'brand_name' => 'Edwin Ortiz Herazo',
                'locale' => 'en-US',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => $orderUrl,
                'cancel_url' => $orderUrl . '?cancelled=1',
            ]]],
        ];
        $res = $this->http->request('POST', $this->base() . '/v2/checkout/orders', $this->headers($order['reference']), (string) json_encode($body));
        $json = $res['json'] ?? [];
        $approve = null;
        foreach (($json['links'] ?? []) as $link) {
            if (in_array($link['rel'] ?? '', ['payer-action', 'approve'], true)) {
                $approve = (string) $link['href'];
            }
        }
        if ($res['status'] < 200 || $res['status'] >= 300 || $approve === null) {
            Logger::error('PayPal: no se pudo crear la orden', ['status' => $res['status'], 'reference' => $order['reference']]);
            throw new GatewayException('paypal_order');
        }
        $this->checkoutId = (string) ($json['id'] ?? '');
        return $approve;
    }

    /** Captura servidor a servidor tras el regreso del comprador. */
    public function capture(array $order, string $paypalOrderId): Status
    {
        $res = $this->http->request(
            'POST',
            $this->base() . '/v2/checkout/orders/' . rawurlencode($paypalOrderId) . '/capture',
            $this->headers($order['reference'] . '-capture'),
            '{}'
        );
        $json = $res['json'] ?? [];
        if (($res['status'] === 422 || $res['status'] === 400) && str_contains($res['body'], 'ORDER_ALREADY_CAPTURED')) {
            return $this->orderStatus($paypalOrderId);
        }
        if ($res['status'] < 200 || $res['status'] >= 300) {
            Logger::warning('PayPal: captura fallida', ['status' => $res['status'], 'reference' => $order['reference']]);
            return new Status(Status::PENDING, $paypalOrderId);
        }
        return self::fromOrder($json, $paypalOrderId);
    }

    private static function fromOrder(array $json, string $paypalOrderId): Status
    {
        $unit = $json['purchase_units'][0] ?? [];
        $capture = $unit['payments']['captures'][0] ?? null;
        $orderStatus = (string) ($json['status'] ?? '');
        if ($capture !== null) {
            return new Status(
                self::map((string) ($capture['status'] ?? '')),
                $paypalOrderId,
                isset($capture['amount']['value']) ? (float) $capture['amount']['value'] : null,
                $capture['amount']['currency_code'] ?? null,
                $capture['custom_id'] ?? $unit['custom_id'] ?? $capture['invoice_id'] ?? null,
                (string) ($capture['status'] ?? ''),
                ['capture_id' => $capture['id'] ?? null, 'order_status' => $orderStatus],
            );
        }
        $status = match ($orderStatus) {
            'VOIDED' => Status::VOIDED,
            default => Status::PENDING, // CREATED, SAVED, APPROVED, PAYER_ACTION_REQUIRED
        };
        return new Status($status, $paypalOrderId, null, null, $unit['custom_id'] ?? null, $orderStatus, ['order_status' => $orderStatus]);
    }

    private function orderStatus(string $paypalOrderId): Status
    {
        $res = $this->http->request('GET', $this->base() . '/v2/checkout/orders/' . rawurlencode($paypalOrderId), $this->headers());
        if ($res['status'] !== 200 || !is_array($res['json'])) {
            return new Status(Status::PENDING, $paypalOrderId);
        }
        return self::fromOrder($res['json'], $paypalOrderId);
    }

    public static function map(string $status): string
    {
        return match ($status) {
            'COMPLETED' => Status::APPROVED,
            'DENIED', 'DECLINED', 'FAILED' => Status::DECLINED,
            'REFUNDED', 'PARTIALLY_REFUNDED', 'REVERSED' => Status::REFUNDED,
            default => Status::PENDING,
        };
    }

    /** Verificación por API (POST /v1/notifications/verify-webhook-signature); solo vale "SUCCESS". */
    public function verifySignature(Request $request, string $rawBody): bool
    {
        if ($this->webhookId === '') {
            return false;
        }
        $fields = [
            'auth_algo' => $request->header('PAYPAL-AUTH-ALGO'),
            'cert_url' => $request->header('PAYPAL-CERT-URL'),
            'transmission_id' => $request->header('PAYPAL-TRANSMISSION-ID'),
            'transmission_sig' => $request->header('PAYPAL-TRANSMISSION-SIG'),
            'transmission_time' => $request->header('PAYPAL-TRANSMISSION-TIME'),
            'webhook_id' => $this->webhookId,
        ];
        foreach ($fields as $value) {
            if ($value === null || $value === '') {
                return false;
            }
        }
        // El evento se envía tal como llegó (sin re-serializar) para no alterar montos ni formatos.
        $body = substr((string) json_encode($fields, JSON_UNESCAPED_SLASHES), 0, -1) . ',"webhook_event":' . $rawBody . '}';
        try {
            $res = $this->http->request('POST', $this->base() . '/v1/notifications/verify-webhook-signature', $this->headers(), $body);
        } catch (GatewayException) {
            return false;
        }
        return $res['status'] === 200 && ($res['json']['verification_status'] ?? '') === 'SUCCESS';
    }

    public function handleWebhook(Request $request): WebhookResult
    {
        $raw = $request->body();
        $event = json_decode($raw, true);
        if (!is_array($event) || !$this->verifySignature($request, $raw)) {
            return WebhookResult::invalid(is_array($event) ? $event : []);
        }
        $eventId = (string) ($event['id'] ?? '');
        $type = (string) ($event['event_type'] ?? '');
        $r = $event['resource'] ?? [];
        $reference = $r['custom_id'] ?? $r['invoice_id'] ?? null;
        $orderId = $r['supplementary_data']['related_ids']['order_id'] ?? null;
        $amount = isset($r['amount']['value']) ? (float) $r['amount']['value'] : null;
        $currency = $r['amount']['currency_code'] ?? null;
        $status = match ($type) {
            'PAYMENT.CAPTURE.COMPLETED' => new Status(Status::APPROVED, $orderId, $amount, $currency, $reference, 'COMPLETED', ['capture_id' => $r['id'] ?? null]),
            'PAYMENT.CAPTURE.DENIED' => new Status(Status::DECLINED, $orderId, $amount, $currency, $reference, 'DENIED'),
            'PAYMENT.CAPTURE.REFUNDED', 'PAYMENT.CAPTURE.REVERSED' => new Status(Status::REFUNDED, $orderId, $amount, $currency, $reference, $type === 'PAYMENT.CAPTURE.REVERSED' ? 'REVERSED' : 'REFUNDED'),
            'PAYMENT.CAPTURE.PENDING' => new Status(Status::PENDING, $orderId, $amount, $currency, $reference, 'PENDING'),
            // El comprador aprobó pero cerró la ventana antes de volver: se captura desde el servidor.
            'CHECKOUT.ORDER.APPROVED' => new Status(Status::PENDING, (string) ($r['id'] ?? ''), null, null, $r['purchase_units'][0]['custom_id'] ?? null, 'APPROVED', ['needs_capture' => true]),
            default => null,
        };
        if ($status === null || $eventId === '') {
            return WebhookResult::ignored($eventId !== '' ? $eventId : bin2hex(random_bytes(8)), $type, $event);
        }
        return new WebhookResult(true, $eventId, $type, $status, $event);
    }

    public function fetchStatus(array $order, ?string $hint = null): Status
    {
        $id = $hint ?: ($order['gateway_id'] ?? null);
        if (!$id) {
            return Status::unknown();
        }
        $status = $this->orderStatus((string) $id);
        if (($status->raw['order_status'] ?? '') === 'APPROVED') {
            return $this->capture($order, (string) $id);
        }
        return $status;
    }
}
