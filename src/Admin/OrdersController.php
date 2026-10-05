<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\HttpException;
use App\Core\Request;
use App\Core\Response;
use App\Services\Downloads\DownloadService;
use App\Services\Orders\OrderService;

/**
 * Pedidos: detalle, eventos de pago, reenvío de correo, regenerar descargas y consulta a la pasarela.
 */
final class OrdersController extends AdminBase
{
    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $where = ['1 = 1'];
        $params = [];
        $status = (string) ($request->query['status'] ?? '');
        if (in_array($status, ['pending', 'approved', 'declined', 'voided', 'refunded', 'error'], true)) {
            $where[] = 'status = :s';
            $params['s'] = $status;
        }
        $q = is_string($request->query['q'] ?? null) ? trim($request->query['q']) : '';
        if ($q !== '') {
            $where[] = '(reference LIKE :q OR email LIKE :q2 OR name LIKE :q3)';
            $params += ['q' => "%$q%", 'q2' => "%$q%", 'q3' => "%$q%"];
        }
        $orders = DB::all('SELECT * FROM orders WHERE ' . implode(' AND ', $where) . ' ORDER BY created_at DESC LIMIT 300', $params);
        return $this->view('orders/index', ['orders' => $orders, 'status' => $status, 'q' => $q], t('admin.orders'));
    }

    private function order(string $id): array
    {
        $order = OrderService::find((int) $id);
        if ($order === null) {
            throw HttpException::notFound();
        }
        return $order;
    }

    public function show(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $order = $this->order($id);
        return $this->view('orders/show', [
            'order' => $order,
            'events' => DB::all('SELECT * FROM payment_events WHERE order_id = :o ORDER BY id DESC', ['o' => (int) $order['id']]),
            'grants' => DB::all(
                'SELECT g.*, oi.title, pf.label FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id
                 LEFT JOIN product_files pf ON pf.id = g.product_file_id WHERE oi.order_id = :o ORDER BY g.id DESC',
                ['o' => (int) $order['id']]
            ),
            'log' => DB::all(
                'SELECT l.* FROM download_log l JOIN download_grants g ON g.id = l.grant_id JOIN order_items oi ON oi.id = g.order_item_id
                 WHERE oi.order_id = :o ORDER BY l.id DESC LIMIT 50',
                ['o' => (int) $order['id']]
            ),
        ], $order['reference']);
    }

    public function resend(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $order = $this->order($id);
        $template = match ($order['status']) {
            'approved' => 'order-approved',
            'declined', 'error' => 'order-declined',
            default => 'order-received',
        };
        $ok = OrderService::mail($template, $order);
        return $ok ? $this->back("/admin/pedidos/{$order['id']}/", t('admin.orders.resent')) : $this->fail("/admin/pedidos/{$order['id']}/", t('admin.orders.mail_failed'));
    }

    public function regenerate(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $order = $this->order($id);
        if ($order['status'] !== 'approved') {
            return $this->fail("/admin/pedidos/{$order['id']}/", t('admin.orders.not_approved'));
        }
        DownloadService::createGrants((int) $order['id'], true);
        return $this->back("/admin/pedidos/{$order['id']}/", t('admin.orders.regenerated'));
    }

    public function check(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        $order = $this->order($id);
        $result = OrderService::refresh($order);
        return $this->back("/admin/pedidos/{$order['id']}/", t('admin.orders.checked', ['result' => $result['result']]));
    }
}
