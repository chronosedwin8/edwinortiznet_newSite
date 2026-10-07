<?php

declare(strict_types=1);

namespace App\Services\Piar;

use App\Core\DB;

/**
 * Créditos del PIAR con IA: prueba gratis (2 por cuenta, de por vida) y paquetes mensuales
 * (5, 10 o 20 PIAR por 30 días desde el pago). Cada compra suma un paquete nuevo; cada PIAR
 * consume un crédito del paquete activo que vence primero. Los PIAR nunca se borran, así que
 * borrar no devuelve cupo.
 */
final class PiarCredits
{
    public const TRIAL_LIMIT = 1;
    public const DAYS = 30;
    /** SKU => PIAR por paquete. */
    public const SKUS = ['PIAR-5' => 5, 'PIAR-10' => 10, 'PIAR-20' => 20];
    /** Precios de referencia (el precio real es el del producto en la tienda). */
    public const PRICES = ['PIAR-5' => [30000, 7.50], 'PIAR-10' => [50000, 12.50], 'PIAR-20' => [80000, 20.00]];

    /**
     * Paquetes a la venta (productos de la tienda con SKU PIAR-*), con su enlace al pago.
     * @return array<int, array{sku:string, credits:int, price_cop:int, price_usd:float, product_id:?int, title:string, slug:?string, buyable:bool}>
     */
    public static function offers(): array
    {
        $rows = [];
        foreach (DB::all(
            'SELECT p.id, p.sku, p.price_cop, p.price_usd, p.status, t.title, t.slug FROM products p
             LEFT JOIN product_translations t ON t.product_id = p.id AND t.locale = "es"
             WHERE p.sku IN ("PIAR-5", "PIAR-10", "PIAR-20")'
        ) as $row) {
            $rows[$row['sku']] = $row;
        }
        $out = [];
        foreach (self::SKUS as $sku => $credits) {
            $p = $rows[$sku] ?? null;
            $out[] = [
                'sku' => $sku,
                'credits' => $credits,
                'price_cop' => $p ? (int) $p['price_cop'] : self::PRICES[$sku][0],
                'price_usd' => $p ? (float) $p['price_usd'] : self::PRICES[$sku][1],
                'product_id' => $p ? (int) $p['id'] : null,
                'title' => (string) ($p['title'] ?? $sku),
                'slug' => $p['slug'] ?? null,
                'buyable' => $p !== null && $p['status'] === 'active',
            ];
        }
        return $out;
    }

    public static function creditsForSku(?string $sku): int
    {
        return self::SKUS[strtoupper((string) $sku)] ?? 0;
    }

    /** Id del cliente con ese correo; lo crea si no existe. */
    public static function customerFor(string $email, ?string $name = null, string $locale = 'es'): int
    {
        $email = strtolower(trim($email));
        DB::run(
            'INSERT INTO customers (email, name, locale) VALUES (:e, :n, :l)
             ON DUPLICATE KEY UPDATE name = IF(name IS NULL OR name = "", VALUES(name), name)',
            ['e' => $email, 'n' => $name !== null && $name !== '' ? mb_substr($name, 0, 190) : null, 'l' => $locale]
        );
        return (int) DB::value('SELECT id FROM customers WHERE email = :e', ['e' => $email]);
    }

    /**
     * Pedido aprobado: un paquete por cada ítem PIAR (idempotente por order_item_id).
     * Se llama dentro de la transacción de OrderService::apply (el pedido está bloqueado).
     * Devuelve cuántos paquetes nuevos se crearon.
     */
    public static function grantForOrder(int $orderId): int
    {
        $items = DB::all(
            'SELECT oi.id, oi.quantity, p.sku FROM order_items oi JOIN products p ON p.id = oi.product_id
             WHERE oi.order_id = :o AND p.sku IN ("PIAR-5", "PIAR-10", "PIAR-20")',
            ['o' => $orderId]
        );
        if ($items === []) {
            return 0;
        }
        $order = DB::one('SELECT id, email, name, locale, paid_at FROM orders WHERE id = :id', ['id' => $orderId]);
        if ($order === null) {
            return 0;
        }
        $customerId = self::customerFor((string) $order['email'], (string) $order['name'], (string) $order['locale']);
        $start = strtotime((string) ($order['paid_at'] ?: DB::now()) . ' UTC') ?: time();
        $created = 0;
        foreach ($items as $item) {
            if (DB::value('SELECT id FROM piar_packages WHERE order_item_id = :i', ['i' => (int) $item['id']]) !== null) {
                continue;
            }
            DB::insert('piar_packages', [
                'customer_id' => $customerId,
                'order_id' => $orderId,
                'order_item_id' => (int) $item['id'],
                'sku' => (string) $item['sku'],
                'credits' => self::creditsForSku($item['sku']) * max(1, (int) $item['quantity']),
                'starts_at' => gmdate('Y-m-d H:i:s', $start),
                'expires_at' => gmdate('Y-m-d H:i:s', $start + self::DAYS * 86400),
            ]);
            $created++;
        }
        return $created;
    }

    /** Reembolso: los créditos sin usar del pedido dejan de estar disponibles (los PIAR ya generados se conservan). */
    public static function revokeForOrder(int $orderId): int
    {
        return DB::run('UPDATE piar_packages SET revoked_at = :now WHERE order_id = :o AND revoked_at IS NULL', ['now' => DB::now(), 'o' => $orderId])->rowCount();
    }

    /** Paquete manual (soporte desde el panel). */
    public static function grantManual(int $customerId, int $credits, int $days, ?string $note = null): int
    {
        $now = time();
        return DB::insert('piar_packages', [
            'customer_id' => $customerId,
            'sku' => 'MANUAL',
            'credits' => max(1, min(500, $credits)),
            'starts_at' => gmdate('Y-m-d H:i:s', $now),
            'expires_at' => gmdate('Y-m-d H:i:s', $now + max(1, min(366, $days)) * 86400),
            'note' => $note !== null && $note !== '' ? mb_substr($note, 0, 190) : null,
        ]);
    }

    public static function forOrder(int $orderId): array
    {
        return DB::all('SELECT * FROM piar_packages WHERE order_id = :o ORDER BY id', ['o' => $orderId]);
    }

    /** Paquetes vigentes (no revocados ni vencidos), el que vence primero arriba. */
    public static function active(int $customerId): array
    {
        return DB::all(
            'SELECT * FROM piar_packages WHERE customer_id = :c AND revoked_at IS NULL AND starts_at <= :now AND expires_at > :now2 ORDER BY expires_at, id',
            ['c' => $customerId, 'now' => DB::now(), 'now2' => DB::now()]
        );
    }

    /** PIAR de prueba usados (los que fallaron no cuentan). */
    public static function trialUsed(int $customerId): int
    {
        return (int) DB::value('SELECT COUNT(*) FROM piar_plans WHERE customer_id = :c AND is_trial = 1 AND status <> "error"', ['c' => $customerId]);
    }

    /**
     * Estado de la cuenta para el medidor de uso.
     * @return array{trial_used:int, trial_left:int, credits:int, used:int, remaining:int, expires_at:?string, has_active:bool, ever_paid:bool, packages:array}
     */
    public static function summary(int $customerId): array
    {
        $packages = self::active($customerId);
        $credits = array_sum(array_map(fn ($p) => (int) $p['credits'], $packages));
        $used = array_sum(array_map(fn ($p) => (int) $p['used'], $packages));
        $trialUsed = self::trialUsed($customerId);
        $withCredits = array_values(array_filter($packages, fn ($p) => (int) $p['used'] < (int) $p['credits']));
        return [
            'trial_used' => min(self::TRIAL_LIMIT, $trialUsed),
            'trial_left' => max(0, self::TRIAL_LIMIT - $trialUsed),
            'credits' => $credits,
            'used' => $used,
            'remaining' => max(0, $credits - $used),
            'expires_at' => $withCredits[0]['expires_at'] ?? ($packages ? end($packages)['expires_at'] : null),
            'last_expires_at' => $packages ? max(array_column($packages, 'expires_at')) : null,
            'has_active' => $packages !== [],
            'ever_paid' => $packages !== [] || DB::value('SELECT id FROM piar_packages WHERE customer_id = :c LIMIT 1', ['c' => $customerId]) !== null,
            'packages' => $packages,
        ];
    }

    /** Toma un crédito del paquete vigente que vence primero. Debe llamarse dentro de una transacción. */
    public static function reserve(int $customerId): ?int
    {
        $package = DB::one(
            'SELECT id FROM piar_packages WHERE customer_id = :c AND revoked_at IS NULL AND starts_at <= :now AND expires_at > :now2 AND used < credits
             ORDER BY expires_at, id LIMIT 1 FOR UPDATE',
            ['c' => $customerId, 'now' => DB::now(), 'now2' => DB::now()]
        );
        if ($package === null) {
            return null;
        }
        DB::run('UPDATE piar_packages SET used = used + 1 WHERE id = :id', ['id' => (int) $package['id']]);
        return (int) $package['id'];
    }

    /** Devuelve el crédito (la generación falló o venció). */
    public static function release(int $packageId): void
    {
        DB::run('UPDATE piar_packages SET used = used - 1 WHERE id = :id AND used > 0', ['id' => $packageId]);
    }
}
