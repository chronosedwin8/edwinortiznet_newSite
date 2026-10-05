<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Core\Config;
use App\Core\HttpClient;
use App\Core\Logger;
use App\Core\Request;

/**
 * Mercado Pago Checkout Pro (COP), por REST.
 * Webhook: x-signature = "ts=…,v1=…", v1 = HMAC-SHA256(secret, "id:{data.id};request-id:{x-request-id};ts:{ts};").
 * El estado se toma de GET /v1/payments/{id}, nunca del cuerpo recibido.
 */
final class MercadoPago implements PaymentGateway
{
    private const API = 'https://api.mercadopago.com';
    private ?string $checkoutId = null;

    public function __construct(
        private readonly HttpClient $http,
        private readonly string $accessToken,
        private readonly string $webhookSecret,
        private readonly string $mode,
        private readonly string $appUrl,
    ) {
    }

    public static function fromConfig(HttpClient $http): self
    {
        return new self(
            $http,
            (string) Config::get('MP_ACCESS_TOKEN', ''),
            (string) Config::get('MP_WEBHOOK_SECRET', ''),
            (string) Config::get('MP_MODE', 'sandbox'),
            Config::appUrl(),
        );
    }

    public function name(): string
    {
        return 'mercadopago';
    }

    public function checkoutId(): ?string
    {
        return $this->checkoutId;
    }

    private function headers(?string $idempotency = null): array
    {
        $h = ['Authorization' => 'Bearer ' . $this->accessToken, 'Content-Type' => 'application/json', 'Accept' => 'application/json'];
        if ($idempotency !== null) {
            $h['X-Idempotency-Key'] = $idempotency;
        }
        return $h;
    }

    public function createCheckout(array $order): string
    {
        $orderUrl = $this->appUrl . '/pedido/' . $order['token'] . '/';
        $items = [];
        foreach ($order['items'] as $item) {
            $items[] = [
                'id' => (string) ($item['product_id'] ?? ''),
                'title' => mb_substr((string) $item['title'], 0, 250),
                'quantity' => (int) $item['quantity'],
                'unit_price' => (float) $item['unit_price'],
                'currency_id' => 'COP',
            ];
        }
        $body = [
            'items' => $items,
            'payer' => ['email' => $order['email'], 'name' => $order['name']],
            'external_reference' => $order['reference'],
            'back_urls' => ['success' => $orderUrl, 'pending' => $orderUrl, 'failure' => $orderUrl],
            'auto_return' => 'approved',
            'notification_url' => $this->appUrl . '/webhooks/mercadopago',
            'statement_descriptor' => 'EDWINORTIZ.NET',
        ];
        $res = $this->http->request('POST', self::API . '/checkout/preferences', $this->headers($order['reference']), (string) json_encode($body));
        $json = $res['json'] ?? [];
        if ($res['status'] < 200 || $res['status'] >= 300 || empty($json['init_point'])) {
            Logger::error('Mercado Pago: no se pudo crear la preferencia', ['status' => $res['status'], 'reference' => $order['reference']]);
            throw new GatewayException('mercadopago_preference');
        }
        $this->checkoutId = (string) ($json['id'] ?? '');
        return $this->mode === 'sandbox' && !empty($json['sandbox_init_point']) ? $json['sandbox_init_point'] : $json['init_point'];
    }

    /** Lee la query cruda: PHP convierte "data.id" en "data_id". */
    private static function rawQuery(Request $request): array
    {
        $out = [];
        foreach (explode('&', (string) ($request->server['QUERY_STRING'] ?? '')) as $pair) {
            if ($pair === '') {
                continue;
            }
            [$k, $v] = array_pad(explode('=', $pair, 2), 2, '');
            $out[rawurldecode($k)] = rawurldecode($v);
        }
        return $out;
    }

    public function verifySignature(Request $request, ?string $dataId): bool
    {
        if ($this->webhookSecret === '') {
            return false;
        }
        $header = (string) $request->header('x-signature');
        $parts = [];
        foreach (explode(',', $header) as $piece) {
            [$k, $v] = array_pad(explode('=', trim($piece), 2), 2, '');
            $parts[trim($k)] = trim($v);
        }
        $ts = $parts['ts'] ?? '';
        $v1 = $parts['v1'] ?? '';
        if ($ts === '' || $v1 === '') {
            return false;
        }
        $requestId = (string) $request->header('x-request-id');
        $manifest = '';
        if ($dataId !== null && $dataId !== '') {
            $manifest .= 'id:' . (ctype_alnum($dataId) ? strtolower($dataId) : $dataId) . ';';
        }
        if ($requestId !== '') {
            $manifest .= 'request-id:' . $requestId . ';';
        }
        $manifest .= 'ts:' . $ts . ';';
        return hash_equals(hash_hmac('sha256', $manifest, $this->webhookSecret), strtolower($v1));
    }

    public function handleWebhook(Request $request): WebhookResult
    {
        $payload = $request->json();
        $query = self::rawQuery($request);
        $dataId = (string) ($query['data.id'] ?? ($payload['data']['id'] ?? ''));
        if (!$this->verifySignature($request, $dataId)) {
            return WebhookResult::invalid($payload);
        }
        $type = (string) ($payload['type'] ?? $query['type'] ?? $query['topic'] ?? '');
        $eventId = (string) ($payload['id'] ?? $request->header('x-request-id') ?? ('payment-' . $dataId));
        if ($type !== 'payment' || $dataId === '') {
            return WebhookResult::ignored($eventId, $type, $payload);
        }
        return new WebhookResult(true, $eventId, $type . '.' . ($payload['action'] ?? 'updated'), $this->payment($dataId), $payload);
    }

    public static function map(string $status): string
    {
        return match ($status) {
            'approved' => Status::APPROVED,
            'rejected', 'cancelled' => Status::DECLINED,
            'refunded', 'charged_back' => Status::REFUNDED,
            default => Status::PENDING, // pending, in_process, authorized, in_mediation
        };
    }

    private function payment(string $id): Status
    {
        $res = $this->http->request('GET', self::API . '/v1/payments/' . rawurlencode($id), $this->headers());
        $p = $res['json'] ?? null;
        if ($res['status'] !== 200 || !is_array($p)) {
            Logger::warning('Mercado Pago: consulta de pago fallida', ['status' => $res['status']]);
            return Status::unknown();
        }
        return self::fromPayment($p);
    }

    private static function fromPayment(array $p): Status
    {
        return new Status(
            self::map((string) ($p['status'] ?? '')),
            isset($p['id']) ? (string) $p['id'] : null,
            isset($p['transaction_amount']) ? (float) $p['transaction_amount'] : null,
            isset($p['currency_id']) ? (string) $p['currency_id'] : null,
            isset($p['external_reference']) ? (string) $p['external_reference'] : null,
            (string) ($p['status'] ?? ''),
            ['id' => $p['id'] ?? null, 'status_detail' => $p['status_detail'] ?? null],
        );
    }

    public function fetchStatus(array $order, ?string $hint = null): Status
    {
        if ($hint !== null && $hint !== '') {
            $status = $this->payment($hint);
            return $status->reference === $order['reference'] ? $status : Status::unknown();
        }
        $res = $this->http->request(
            'GET',
            self::API . '/v1/payments/search?' . http_build_query(['external_reference' => $order['reference'], 'sort' => 'date_created', 'criteria' => 'desc']),
            $this->headers()
        );
        $results = $res['json']['results'] ?? [];
        if (!is_array($results) || $results === []) {
            return Status::unknown();
        }
        // Si algún intento quedó aprobado, ese manda.
        foreach ($results as $p) {
            if (($p['status'] ?? '') === 'approved') {
                return self::fromPayment($p);
            }
        }
        return self::fromPayment($results[0]);
    }
}
