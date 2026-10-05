<?php

declare(strict_types=1);

namespace App\Services\Orders;

use App\Core\DB;
use App\Core\Logger;

/**
 * Tarea programada (cada 10 minutos): consulta en la pasarela los pedidos pendientes de más de 15 minutos
 * y anula los que llevan más de 24 horas sin pago.
 */
final class Reconciler
{
    /** @return array{checked:int, updated:int, voided:int} */
    public function run(): array
    {
        $checked = 0;
        $updated = 0;
        $pending = DB::all(
            'SELECT * FROM orders WHERE status = "pending"
               AND created_at < UTC_TIMESTAMP() - INTERVAL 15 MINUTE
               AND created_at >= UTC_TIMESTAMP() - INTERVAL 24 HOUR
             ORDER BY created_at LIMIT 200'
        );
        foreach ($pending as $order) {
            $checked++;
            $result = OrderService::refresh(OrderService::withItems($order));
            if ($result['result'] !== 'pending' && $result['result'] !== 'error') {
                $updated++;
            }
        }
        // Una última consulta antes de anular: un pago tardío aún puede aprobar el pedido.
        $voided = 0;
        foreach (DB::all('SELECT * FROM orders WHERE status = "pending" AND created_at < UTC_TIMESTAMP() - INTERVAL 24 HOUR LIMIT 500') as $order) {
            $result = OrderService::refresh(OrderService::withItems($order));
            if ($result['result'] === 'pending' || $result['result'] === 'error') {
                DB::run('UPDATE orders SET status = "voided" WHERE id = :id AND status = "pending"', ['id' => (int) $order['id']]);
                $voided++;
            }
        }
        if ($checked || $voided) {
            Logger::info('Conciliación de pedidos', compact('checked', 'updated', 'voided'));
        }
        return ['checked' => $checked, 'updated' => $updated, 'voided' => $voided];
    }
}
