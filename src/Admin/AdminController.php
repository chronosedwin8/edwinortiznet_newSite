<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\Downloads\DownloadService;

/**
 * Escritorio: ventas de 30 días, pedidos pendientes, suscriptores, 404 recientes y productos sin archivo.
 */
final class AdminController extends AdminBase
{
    public function dashboard(Request $request): Response
    {
        $this->requireAdmin($request);
        $sales = DB::all(
            'SELECT currency, COUNT(*) AS orders, SUM(total) AS total FROM orders
             WHERE status = "approved" AND paid_at >= UTC_TIMESTAMP() - INTERVAL 30 DAY GROUP BY currency'
        );
        $daily = DB::all(
            'SELECT DATE(paid_at) AS day, COUNT(*) AS orders FROM orders
             WHERE status = "approved" AND paid_at >= UTC_TIMESTAMP() - INTERVAL 30 DAY GROUP BY DATE(paid_at) ORDER BY day'
        );
        return $this->view('dashboard', [
            'sales' => $sales,
            'daily' => $daily,
            'pending' => DB::all('SELECT id, reference, email, total, currency, gateway, created_at FROM orders WHERE status = "pending" ORDER BY created_at DESC LIMIT 10'),
            'pendingCount' => (int) DB::value('SELECT COUNT(*) FROM orders WHERE status = "pending"'),
            'subscribers' => (int) DB::value('SELECT COUNT(DISTINCT email) FROM subscribers WHERE confirmed_at IS NOT NULL AND unsubscribed_at IS NULL'),
            'subscribersPending' => (int) DB::value('SELECT COUNT(DISTINCT email) FROM subscribers WHERE confirmed_at IS NULL'),
            'waitlist' => DB::all('SELECT t.title, COUNT(*) AS n FROM waitlist w JOIN product_translations t ON t.product_id = w.product_id AND t.locale = "es" GROUP BY w.product_id, t.title ORDER BY n DESC LIMIT 10'),
            'notFound' => DB::all('SELECT path, hits, last_seen FROM not_found_log WHERE resolved = 0 ORDER BY last_seen DESC LIMIT 10'),
            'missingFiles' => DownloadService::productsWithoutLocalFile(),
            'toReview' => (int) DB::value('SELECT COUNT(*) FROM posts WHERE needs_review = 1') + (int) DB::value('SELECT COUNT(*) FROM product_translations WHERE needs_review = 1'),
            'seoAuto' => (int) DB::value('SELECT COUNT(*) FROM posts WHERE seo_auto = 1'),
        ], t('admin.dashboard'));
    }
}
