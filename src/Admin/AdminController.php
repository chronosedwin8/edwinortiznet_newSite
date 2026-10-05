<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\Downloads\DownloadService;

/**
 * Escritorio (ventas de 30 días, pendientes, contenido, 404, productos sin archivo) y búsqueda global (Ctrl+K).
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
        // Serie completa de 30 días (los días sin ventas cuentan como 0).
        $byDay = array_column($daily, 'orders', 'day');
        $series = [];
        for ($i = 29; $i >= 0; $i--) {
            $day = gmdate('Y-m-d', strtotime("-$i days"));
            $series[] = ['day' => $day, 'orders' => (int) ($byDay[$day] ?? 0)];
        }
        return $this->view('dashboard', [
            'sales' => $sales,
            'daily' => $series,
            'counts' => [
                'posts' => (int) DB::value('SELECT COUNT(*) FROM posts WHERE type = "post" AND status = "published"'),
                'drafts' => (int) DB::value('SELECT COUNT(*) FROM posts WHERE status = "draft" AND type = "post"'),
                'products' => (int) DB::value('SELECT COUNT(*) FROM products WHERE status = "active"'),
                'media' => (int) DB::value('SELECT COUNT(*) FROM media'),
            ],
            'recent' => DB::all('SELECT id, title, locale, status, COALESCE(updated_at, published_at) AS changed FROM posts ORDER BY COALESCE(updated_at, published_at) DESC LIMIT 6'),
            'pending' => DB::all('SELECT id, reference, email, total, currency, gateway, created_at FROM orders WHERE status = "pending" ORDER BY created_at DESC LIMIT 10'),
            'pendingCount' => (int) DB::value('SELECT COUNT(*) FROM orders WHERE status = "pending"'),
            'subscribers' => (int) DB::value('SELECT COUNT(DISTINCT email) FROM subscribers WHERE confirmed_at IS NOT NULL AND unsubscribed_at IS NULL'),
            'subscribersPending' => (int) DB::value('SELECT COUNT(DISTINCT email) FROM subscribers WHERE confirmed_at IS NULL'),
            'waitlist' => DB::all('SELECT t.title, COUNT(*) AS n FROM waitlist w JOIN product_translations t ON t.product_id = w.product_id AND t.locale = "es" GROUP BY w.product_id, t.title ORDER BY n DESC LIMIT 10'),
            'notFound' => DB::all('SELECT path, hits, last_seen FROM not_found_log WHERE resolved = 0 ORDER BY last_seen DESC LIMIT 10'),
            'missingFiles' => array_values(array_filter(DownloadService::productsWithoutLocalFile(), fn ($p) => $p['status'] !== 'hidden')),
            'toReview' => (int) DB::value('SELECT COUNT(*) FROM posts WHERE needs_review = 1') + (int) DB::value('SELECT COUNT(*) FROM product_translations WHERE needs_review = 1'),
            'seoAuto' => (int) DB::value('SELECT COUNT(*) FROM posts WHERE seo_auto = 1'),
        ], t('admin.dashboard'));
    }

    /** Búsqueda de la paleta de comandos: contenido, productos, secciones y pedidos. */
    public function search(Request $request): Response
    {
        $this->requireAdmin($request);
        $q = trim($request->str('q'));
        $items = [];
        if (mb_strlen($q) >= 2) {
            $like = '%' . $q . '%';
            foreach (DB::all('SELECT id, title, slug, locale, status, type FROM posts WHERE title LIKE :q OR slug LIKE :s ORDER BY (status = "published") DESC, COALESCE(updated_at, published_at) DESC LIMIT 8', ['q' => $like, 's' => $like]) as $p) {
                $items[] = ['group' => t('admin.posts'), 'title' => $p['title'], 'url' => "/admin/contenido/{$p['id']}/", 'meta' => strtoupper($p['locale']) . ' · ' . t('admin.status.' . $p['status']), 'public' => $p['type'] !== 'policy' && $p['status'] !== 'draft' ? ($p['locale'] === 'en' ? '/en/' : '/') . $p['slug'] . '/' : null];
            }
            foreach (DB::all('SELECT p.id, t.title, t.slug, p.status FROM products p JOIN product_translations t ON t.product_id = p.id AND t.locale = "es" WHERE t.title LIKE :q OR p.sku LIKE :s ORDER BY p.status = "active" DESC, t.title LIMIT 6', ['q' => $like, 's' => $like]) as $p) {
                $items[] = ['group' => t('admin.products'), 'title' => $p['title'], 'url' => "/admin/productos/{$p['id']}/", 'meta' => t('admin.pstatus.' . $p['status']), 'slug' => $p['slug']];
            }
            foreach (DB::all('SELECT h.id, t.title FROM hubs h JOIN hub_translations t ON t.hub_id = h.id AND t.locale = "es" WHERE t.title LIKE :q', ['q' => $like]) as $h) {
                $items[] = ['group' => t('admin.hubs'), 'title' => $h['title'], 'url' => "/admin/secciones/{$h['id']}/", 'meta' => ''];
            }
            foreach (DB::all('SELECT id, reference, email, status FROM orders WHERE reference LIKE :q OR email LIKE :e ORDER BY id DESC LIMIT 5', ['q' => $like, 'e' => $like]) as $o) {
                $items[] = ['group' => t('admin.orders'), 'title' => $o['reference'], 'url' => "/admin/pedidos/{$o['id']}/", 'meta' => $o['email'] . ' · ' . t('status.' . $o['status'])];
            }
        }
        return Response::json(['items' => $items])->header('Cache-Control', 'private, no-store');
    }
}
