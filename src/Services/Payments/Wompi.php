<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Core\Config;
use App\Core\HttpClient;
use App\Core\Logger;
use App\Core\Request;

/**
 * Wompi (COP). Checkout web por redirección con firma de integridad;
 * webhook transaction.updated con checksum SHA256(valores de signature.properties + timestamp + secreto de eventos),
 * confirmado después con GET /v1/transactions/{id}.
 */
final class Wompi implements PaymentGateway
{
    public const CHECKOUT_URL = 'https://checkout.wompi.co/p/';

    public function __construct(
        private readonly HttpClient $http,
        private readonly string $publicKey,
        private readonly string $privateKey,
        private readonly string $integritySecret,
        private readonly string $eventsSecret,
        private readonly string $mode,
        private readonly string $appUrl,
    ) {
    }

    public static function fromConfig(HttpClient $http): self
    {
        return new self(
            $http,
            (string) Config::get('WOMPI_PUBLIC_KEY', ''),
            (string) Config::get('WOMPI_PRIVATE_KEY', ''),
            (string) Config::get('WOMPI_INTEGRITY_SECRET', ''),
            (string) Config::get('WOMPI_EVENTS_SECRET', ''),
            (string) Config::get('WOMPI_MODE', 'sandbox'),
            Config::appUrl(),
        );
    }

    public function name(): string
    {
        return 'wompi';
    }

    public function checkoutId(): ?string
    {
        return null;
    }

    private function base(): string
    {
        return $this->mode === 'production' ? 'https://production.wompi.co' : 'https://sandbox.wompi.co';
    }

    public static function amountInCents(float|string $total): int
    {
        return (int) round(((float) $total) * 100);
    }

    public function integritySignature(string $reference, int $amountInCents, string $currency = 'COP'): string
    {
        return hash('sha256', $reference . $amountInCents . $currency . $this->integritySecret);
    }

    public function createCheckout(array $order): string
    {
        if ($this->publicKey === '' || $this->integritySecret === '') {
            throw new GatewayException('wompi_config');
        }
        $cents = self::amountInCents($order['total']);
        $params = [
            'public-key' => $this->publicKey,
            'currency' => 'COP',
            'amount-in-cents' => $cents,
            'reference' => $order['reference'],
            'signature:integrity' => $this->integritySignature($order['reference'], $cents),
            'redirect-url' => $this->appUrl . '/pedido/' . $order['token'] . '/',
            'customer-data:email' => $order['email'],
            'customer-data:full-name' => $order['name'],
        ];
        if (!empty($order['phone'])) {
            $params['customer-data:phone-number'] = preg_replace('/\D+/', '', (string) $order['phone']);
        }
        return self::CHECKOUT_URL . '?' . http_build_query($params);
    }

    public function verifyChecksum(array $event): bool
    {
        if ($this->eventsSecret === '') {
            return false;
        }
        $properties = $event['signature']['properties'] ?? null;
        $checksum = (string) ($event['signature']['checksum'] ?? '');
        if (!is_array($properties) || $checksum === '' || !isset($event['timestamp'])) {
            return false;
        }
        $concat = '';
        foreach ($properties as $path) {
            $value = $event['data'] ?? [];
            foreach (explode('.', (string) $path) as $key) {
                $value = is_array($value) && array_key_exists($key, $value) ? $value[$key] : null;
            }
            if (is_array($value)) {
                return false;
            }
            $concat .= is_bool($value) ? ($value ? 'true' : 'false') : (string) $value;
        }
        $concat .= (string) $event['timestamp'] . $this->eventsSecret;
        return hash_equals(strtoupper(hash('sha256', $concat)), strtoupper($checksum));
    }

    public function handleWebhook(Request $request): WebhookResult
    {
        $event = $request->json();
        if (!$this->verifyChecksum($event)) {
            return WebhookResult::invalid($event);
        }
        $tx = $event['data']['transaction'] ?? [];
        $eventId = implode(':', [$tx['id'] ?? 'x', $tx['status'] ?? 'x', $event['timestamp'] ?? '0']);
        if (($event['event'] ?? '') !== 'transaction.updated' || empty($tx['id'])) {
            return WebhookResult::ignored($eventId, $event['event'] ?? null, $event);
        }
        // Se confirma con la API: el estado y el monto salen de la consulta, no del cuerpo.
        $confirmed = $this->transaction((string) $tx['id']);
        return new WebhookResult(true, $eventId, 'transaction.updated', $confirmed, $event);
    }

    public static function map(string $status): string
    {
        return match ($status) {
            'APPROVED' => Status::APPROVED,
            'DECLINED' => Status::DECLINED,
            'ERROR' => Status::ERROR,
            'VOIDED' => Status::VOIDED,
            default => Status::PENDING,
        };
    }

    private static function fromTransaction(array $t): Status
    {
        return new Status(
            self::map((string) ($t['status'] ?? '')),
            isset($t['id']) ? (string) $t['id'] : null,
            isset($t['amount_in_cents']) ? ((int) $t['amount_in_cents']) / 100 : null,
            isset($t['currency']) ? (string) $t['currency'] : null,
            isset($t['reference']) ? (string) $t['reference'] : null,
            (string) ($t['status'] ?? ''),
            ['id' => $t['id'] ?? null, 'payment_method_type' => $t['payment_method_type'] ?? null],
        );
    }

    private function transaction(string $id): Status
    {
        $res = $this->http->request('GET', $this->base() . '/v1/transactions/' . rawurlencode($id), ['Accept' => 'application/json']);
        $t = $res['json']['data'] ?? null;
        if ($res['status'] !== 200 || !is_array($t)) {
            Logger::warning('Wompi: consulta de transacción fallida', ['status' => $res['status']]);
            return Status::unknown();
        }
        return self::fromTransaction($t);
    }

    public function fetchStatus(array $order, ?string $hint = null): Status
    {
        $id = $hint ?: ($order['gateway_id'] ?? null);
        if ($id) {
            $status = $this->transaction((string) $id);
            return $status->reference === $order['reference'] ? $status : Status::unknown();
        }
        if ($this->privateKey === '') {
            return Status::unknown();
        }
        $res = $this->http->request(
            'GET',
            $this->base() . '/v1/transactions?' . http_build_query(['reference' => $order['reference']]),
            ['Authorization' => 'Bearer ' . $this->privateKey, 'Accept' => 'application/json']
        );
        $list = $res['json']['data'] ?? [];
        if (!is_array($list) || $list === []) {
            return Status::unknown();
        }
        foreach ($list as $t) {
            if (($t['status'] ?? '') === 'APPROVED') {
                return self::fromTransaction($t);
            }
        }
        return self::fromTransaction($list[0]);
    }
}
