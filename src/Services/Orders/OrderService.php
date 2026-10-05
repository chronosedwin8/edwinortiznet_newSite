<?php

declare(strict_types=1);

namespace App\Services\Orders;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Core\Mailer;
use App\Models\Product;
use App\Services\Downloads\DownloadService;
use App\Services\I18n\I18n;
use App\Services\Mail\MailTemplates;
use App\Services\Payments\GatewayResolver;
use App\Services\Payments\Status;

/**
 * Pedidos: el cliente nunca envía montos; precios y totales se calculan en el servidor según el idioma.
 */
final class OrderService
{
    /** Correos pendientes de enviar después del commit. */
    private static array $outbox = [];

    /**
     * Valida los productos del carrito (ids) para un idioma.
     * @return array{items: array, removed: bool, total: float, currency: string}
     */
    public static function cart(string $locale, array $ids): array
    {
        $ids = array_values(array_unique(array_filter(array_map('intval', $ids))));
        $ids = array_slice($ids, 0, 20);
        $products = Product::byIds($ids, $locale, false);
        $items = array_values(array_filter($products, fn ($p) => $p['purchasable']));
        $total = 0.0;
        foreach ($items as $p) {
            $total += Product::chargePrice($p, $locale);
        }
        return [
            'items' => $items,
            'removed' => count($items) < count($ids),
            'total' => $total,
            'currency' => GatewayResolver::currency($locale),
        ];
    }

    public static function newReference(): string
    {
        $alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        do {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $alphabet[random_int(0, strlen($alphabet) - 1)];
            }
            $reference = 'EO-' . gmdate('Y') . '-' . $code;
        } while (DB::value('SELECT id FROM orders WHERE reference = :r', ['r' => $reference]) !== null);
        return $reference;
    }

    /**
     * Crea el pedido "pending". Lanza \DomainException si la pasarela no corresponde al idioma.
     * @param array{name:string,email:string,document?:string,phone?:string} $customer
     */
    public static function create(string $locale, array $productIds, array $customer, string $gateway, string $ip): array
    {
        $currency = GatewayResolver::currency($locale);
        GatewayResolver::assertAllowed(['locale' => $locale, 'currency' => $currency], $gateway);
        $cart = self::cart($locale, $productIds);
        if ($cart['items'] === []) {
            throw new \DomainException('empty_cart');
        }
        $orderId = DB::transaction(function () use ($locale, $currency, $cart, $customer, $gateway, $ip): int {
            $email = strtolower(trim($customer['email']));
            DB::run(
                'INSERT INTO customers (email, name, locale) VALUES (:e, :n, :l) ON DUPLICATE KEY UPDATE name = VALUES(name)',
                ['e' => $email, 'n' => $customer['name'], 'l' => $locale]
            );
            $customerId = (int) DB::value('SELECT id FROM customers WHERE email = :e', ['e' => $email]);
            $orderId = DB::insert('orders', [
                'reference' => self::newReference(),
                'token' => bin2hex(random_bytes(32)),
                'customer_id' => $customerId,
                'email' => $email,
                'name' => mb_substr($customer['name'], 0, 190),
                'document' => ($customer['document'] ?? '') !== '' ? mb_substr((string) $customer['document'], 0, 40) : null,
                'phone' => ($customer['phone'] ?? '') !== '' ? mb_substr((string) $customer['phone'], 0, 40) : null,
                'locale' => $locale,
                'currency' => $currency,
                'subtotal' => $cart['total'],
                'total' => $cart['total'],
                'status' => 'pending',
                'gateway' => $gateway,
                'terms_accepted_at' => DB::now(),
                'ip' => $ip,
            ]);
            foreach ($cart['items'] as $p) {
                $price = Product::chargePrice($p, $locale);
                DB::insert('order_items', [
                    'order_id' => $orderId,
                    'product_id' => (int) $p['id'],
                    'title' => $p['title'],
                    'unit_price' => $price,
                    'quantity' => 1,
                    'total' => $price,
                ]);
            }
            return $orderId;
        });
        $order = self::find($orderId);
        self::mail('order-received', $order);
        self::flushOutbox();
        return $order;
    }

    public static function find(int $id): ?array
    {
        $order = DB::one('SELECT * FROM orders WHERE id = :id', ['id' => $id]);
        return $order ? self::withItems($order) : null;
    }

    public static function byToken(string $token): ?array
    {
        $order = DB::one('SELECT * FROM orders WHERE token = :t', ['t' => $token]);
        return $order ? self::withItems($order) : null;
    }

    public static function byReference(string $reference): ?array
    {
        $order = DB::one('SELECT * FROM orders WHERE reference = :r', ['r' => $reference]);
        return $order ? self::withItems($order) : null;
    }

    public static function withItems(array $order): array
    {
        $order['items'] = DB::all(
            'SELECT oi.*, p.type AS product_type, p.cover_url FROM order_items oi LEFT JOIN products p ON p.id = oi.product_id WHERE oi.order_id = :o ORDER BY oi.id',
            ['o' => (int) $order['id']]
        );
        return $order;
    }

    /** Crea la sesión de pago en la pasarela y guarda su id. */
    public static function checkout(array $order): string
    {
        GatewayResolver::assertAllowed($order, $order['gateway']);
        $gateway = GatewayResolver::make($order['gateway']);
        $url = $gateway->createCheckout($order);
        if ($gateway->checkoutId()) {
            DB::update('orders', ['gateway_id' => $gateway->checkoutId()], ['id' => (int) $order['id']]);
        }
        return $url;
    }

    /**
     * Aplica un estado verificado (webhook o consulta servidor a servidor).
     * Transacción con SELECT … FOR UPDATE; el pedido solo se aprueba si monto y moneda coinciden.
     */
    public static function apply(string $gatewayName, Status $status, ?int $orderId = null): array
    {
        $result = DB::transaction(function () use ($gatewayName, $status, $orderId): array {
            if ($orderId !== null) {
                $order = DB::one('SELECT * FROM orders WHERE id = :id FOR UPDATE', ['id' => $orderId]);
            } elseif ($status->reference !== null) {
                $order = DB::one('SELECT * FROM orders WHERE reference = :r FOR UPDATE', ['r' => $status->reference]);
            } elseif ($status->gatewayId !== null) {
                $order = DB::one('SELECT * FROM orders WHERE gateway = :g AND gateway_id = :id FOR UPDATE', ['g' => $gatewayName, 'id' => $status->gatewayId]);
            } else {
                $order = null;
            }
            if ($order === null) {
                return ['result' => 'unknown_order', 'order_id' => null];
            }
            $id = (int) $order['id'];
            if ($order['gateway'] !== $gatewayName) {
                Logger::warning('Evento de una pasarela distinta a la del pedido', ['reference' => $order['reference'], 'gateway' => $gatewayName]);
                return ['result' => 'gateway_mismatch', 'order_id' => $id];
            }
            if ($status->reference !== null && $status->reference !== $order['reference']) {
                return ['result' => 'reference_mismatch', 'order_id' => $id];
            }
            $base = ['gateway_status' => $status->rawStatus ? mb_substr($status->rawStatus, 0, 60) : $order['gateway_status'], 'last_checked_at' => DB::now()];
            if ($status->gatewayId) {
                $base['gateway_id'] = mb_substr($status->gatewayId, 0, 120);
            }

            switch ($status->status) {
                case Status::APPROVED:
                    if ($order['status'] === 'approved') {
                        DB::update('orders', $base, ['id' => $id]);
                        return ['result' => 'already_approved', 'order_id' => $id];
                    }
                    if ($status->amount === null || $status->currency === null
                        || abs($status->amount - (float) $order['total']) > 0.009
                        || strtoupper($status->currency) !== $order['currency']) {
                        DB::update('orders', $base + ['status' => 'error'], ['id' => $id]);
                        Logger::error('Monto o moneda no coinciden', [
                            'reference' => $order['reference'], 'expected' => $order['total'] . ' ' . $order['currency'],
                            'got' => $status->amount . ' ' . $status->currency,
                        ]);
                        return ['result' => 'amount_mismatch', 'order_id' => $id];
                    }
                    DB::update('orders', $base + ['status' => 'approved', 'paid_at' => DB::now()], ['id' => $id]);
                    DownloadService::createGrants($id);
                    DB::run('UPDATE products p JOIN order_items oi ON oi.product_id = p.id SET p.sales_count = p.sales_count + oi.quantity WHERE oi.order_id = :o', ['o' => $id]);
                    self::queue('order-approved', $id);
                    self::queue('admin-sale', $id);
                    return ['result' => 'approved', 'order_id' => $id];

                case Status::DECLINED:
                case Status::ERROR:
                case Status::VOIDED:
                    if ($order['status'] !== 'pending') {
                        DB::update('orders', $base, ['id' => $id]);
                        return ['result' => 'ignored_' . $status->status, 'order_id' => $id];
                    }
                    DB::update('orders', $base + ['status' => $status->status], ['id' => $id]);
                    if ($status->status !== Status::VOIDED) {
                        self::queue('order-declined', $id);
                    }
                    return ['result' => $status->status, 'order_id' => $id];

                case Status::REFUNDED:
                    DB::update('orders', $base + ['status' => 'refunded'], ['id' => $id]);
                    DownloadService::revokeGrants($id);
                    return ['result' => 'refunded', 'order_id' => $id];

                default:
                    DB::update('orders', $base, ['id' => $id]);
                    return ['result' => 'pending', 'order_id' => $id];
            }
        });
        self::flushOutbox();
        return $result;
    }

    /** Consulta servidor a servidor y aplica el resultado. */
    public static function refresh(array $order, ?string $hint = null): array
    {
        try {
            $gateway = GatewayResolver::make($order['gateway']);
            $status = $gateway->fetchStatus($order, $hint);
        } catch (\Throwable $e) {
            Logger::warning('No se pudo consultar la pasarela', ['reference' => $order['reference'], 'error' => $e->getMessage()]);
            DB::update('orders', ['last_checked_at' => DB::now()], ['id' => (int) $order['id']]);
            return ['result' => 'error', 'order_id' => (int) $order['id']];
        }
        return self::apply($order['gateway'], $status, (int) $order['id']);
    }

    private static function queue(string $template, int $orderId): void
    {
        self::$outbox[] = [$template, $orderId];
    }

    private static function flushOutbox(): void
    {
        $outbox = self::$outbox;
        self::$outbox = [];
        foreach ($outbox as [$template, $orderId]) {
            $order = self::find($orderId);
            if ($order !== null) {
                self::mail($template, $order);
            }
        }
    }

    /** Envía un correo del pedido en su idioma (el aviso al administrador va en español). */
    public static function mail(string $template, array $order): bool
    {
        $isAdmin = $template === 'admin-sale';
        $locale = $isAdmin ? 'es' : $order['locale'];
        $previous = I18n::locale();
        I18n::setLocale($locale);
        try {
            $data = [
                'order' => $order,
                'orderUrl' => url(route('order', ['token' => $order['token']], $order['locale'])),
                'downloads' => DownloadService::forOrder((int) $order['id']),
                'total' => I18n::money($order['total'], $order['currency'], $locale),
            ];
            $mail = MailTemplates::render($template, $locale, $data);
            $to = $isAdmin ? (string) Config::get('ADMIN_EMAIL', '') : $order['email'];
            return $to !== '' && Mailer::send($to, $mail['subject'], $mail['html'], $mail['text']);
        } finally {
            I18n::setLocale($previous);
        }
    }
}
