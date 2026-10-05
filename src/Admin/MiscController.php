<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\Cache;
use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Models\Setting;

/**
 * Suscriptores y lista de espera (CSV), redirecciones y 404, y ajustes.
 */
final class MiscController extends AdminBase
{
    public function subscribers(Request $request): Response
    {
        $this->requireAdmin($request);
        return $this->view('misc/subscribers', [
            'subscribers' => DB::all('SELECT * FROM subscribers ORDER BY created_at DESC LIMIT 500'),
            'byTag' => DB::all('SELECT tag, COUNT(*) AS total, SUM(confirmed_at IS NOT NULL AND unsubscribed_at IS NULL) AS active FROM subscribers GROUP BY tag ORDER BY total DESC'),
            'waitlist' => DB::all('SELECT t.title, COUNT(*) AS n, MAX(w.created_at) AS last FROM waitlist w JOIN product_translations t ON t.product_id = w.product_id AND t.locale = "es" GROUP BY w.product_id, t.title ORDER BY n DESC'),
        ], t('admin.subscribers'));
    }

    private function csv(string $filename, array $header, array $rows): Response
    {
        $fh = fopen('php://temp', 'r+');
        fwrite($fh, "\xEF\xBB\xBF"); // BOM para que Excel abra bien los acentos
        fputcsv($fh, $header, ';');
        foreach ($rows as $row) {
            // Evita inyección de fórmulas al abrir en Excel.
            fputcsv($fh, array_map(fn ($v) => is_string($v) && preg_match('/^[=+\-@]/', $v) ? "'" . $v : $v, array_values($row)), ';');
        }
        rewind($fh);
        $body = (string) stream_get_contents($fh);
        fclose($fh);
        return new Response($body, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'private, no-store',
        ]);
    }

    public function exportSubscribers(Request $request): Response
    {
        $this->requireAdmin($request);
        $rows = DB::all('SELECT email, locale, tag, source, created_at, confirmed_at, unsubscribed_at FROM subscribers ORDER BY created_at');
        return $this->csv('suscriptores-' . gmdate('Ymd') . '.csv', ['email', 'idioma', 'etiqueta', 'origen', 'creado', 'confirmado', 'baja'], $rows);
    }

    public function exportWaitlist(Request $request): Response
    {
        $this->requireAdmin($request);
        $rows = DB::all('SELECT w.email, w.locale, t.title, w.created_at FROM waitlist w JOIN product_translations t ON t.product_id = w.product_id AND t.locale = "es" ORDER BY t.title, w.created_at');
        return $this->csv('lista-de-espera-' . gmdate('Ymd') . '.csv', ['email', 'idioma', 'producto', 'fecha'], $rows);
    }

    public function redirects(Request $request): Response
    {
        $this->requireAdmin($request);
        return $this->view('misc/redirects', [
            'redirects' => DB::all('SELECT * FROM redirects ORDER BY created_at DESC, id DESC'),
            'notFound' => DB::all('SELECT * FROM not_found_log WHERE resolved = 0 ORDER BY hits DESC, last_seen DESC LIMIT 100'),
            'prefill' => is_string($request->query['source'] ?? null) ? $request->query['source'] : '',
        ], t('admin.redirects'));
    }

    public function saveRedirect(Request $request): Response
    {
        $this->requireAdmin($request);
        $source = self::str($request, 'source', 255);
        $target = self::str($request, 'target', 500);
        $type = in_array($request->post['match_type'] ?? '', ['exact', 'prefix', 'regex'], true) ? $request->post['match_type'] : 'exact';
        if ($source === null || $target === null || !str_starts_with($source, $type === 'regex' ? '^' : '/') || $source === $target) {
            return $this->back('/admin/redirecciones/', t('admin.error.redirect'));
        }
        if ($type === 'regex' && @preg_match('#' . str_replace('#', '\#', $source) . '#', '') === false) {
            return $this->back('/admin/redirecciones/', t('admin.error.redirect'));
        }
        DB::upsert('redirects', [
            'source' => $source, 'target' => $target, 'match_type' => $type,
            'code' => ($request->post['code'] ?? '301') === '302' ? 302 : 301, 'note' => self::str($request, 'note', 255),
        ], ['source', 'match_type']);
        DB::run('UPDATE not_found_log SET resolved = 1 WHERE path = :p', ['p' => $source]);
        $this->saved();
        return $this->back('/admin/redirecciones/', t('admin.saved'));
    }

    public function deleteRedirect(Request $request, string $id): Response
    {
        $this->requireAdmin($request);
        DB::run('DELETE FROM redirects WHERE id = :id', ['id' => (int) $id]);
        $this->saved();
        return $this->back('/admin/redirecciones/', t('admin.deleted'));
    }

    private const SETTINGS = ['whatsapp_number', 'fundales_url', 'social_youtube', 'social_linkedin', 'refund_days', 'ads_enabled', 'adsense_max_blocks'];

    public function settings(Request $request): Response
    {
        $this->requireAdmin($request);
        $values = [];
        foreach (self::SETTINGS as $key) {
            $values[$key] = Setting::get($key, '');
        }
        return $this->view('misc/settings', ['values' => $values], t('admin.settings'));
    }

    public function saveSettings(Request $request): Response
    {
        $this->requireAdmin($request);
        foreach (self::SETTINGS as $key) {
            $value = $key === 'ads_enabled' ? (!empty($request->post[$key]) ? '1' : '0') : (self::str($request, $key, 500) ?? '');
            if (in_array($key, ['social_youtube', 'social_linkedin'], true) && $value !== '' && !preg_match('#^https://#', $value)) {
                continue;
            }
            Setting::set($key, $value);
        }
        $this->saved();
        return $this->back('/admin/ajustes/', t('admin.saved'));
    }

    public function flushCache(Request $request): Response
    {
        $this->requireAdmin($request);
        $n = Cache::flushPages();
        return $this->back('/admin/ajustes/', t('admin.cache_flushed', ['n' => $n]));
    }
}
