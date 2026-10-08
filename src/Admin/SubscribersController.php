<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\Newsletter\Interests;
use App\Services\Subscribers;

/**
 * Suscriptores: indicadores, filtros (estado, tema, origen, búsqueda), acciones en lote y CSV.
 */
final class SubscribersController extends AdminBase
{
    private const BASE = '/admin/suscriptores/';
    private const PER_PAGE = 100;

    /** @return array{0:string, 1:array} WHERE y parámetros según los filtros */
    private static function where(array $f): array
    {
        $where = ['1 = 1'];
        $params = [];
        if ($f['status'] === 'paused') {
            $where[] = "s.status = 'active' AND s.paused_until > UTC_TIMESTAMP()";
        } elseif ($f['status'] !== '') {
            $where[] = 's.status = ?';
            $params[] = $f['status'];
        }
        if ($f['interest'] === 'none') {
            $where[] = "s.interests = ''";
        } elseif ($f['interest'] !== '') {
            $where[] = 'FIND_IN_SET(?, s.interests) > 0';
            $params[] = $f['interest'];
        }
        if ($f['source'] !== '') {
            $where[] = 's.source_type = ?';
            $params[] = $f['source'];
        }
        if ($f['q'] !== '') {
            $where[] = '(s.email LIKE ? OR s.source_title LIKE ? OR s.source_path LIKE ? OR s.utm_campaign LIKE ?)';
            $like = '%' . addcslashes($f['q'], '%_\\') . '%';
            array_push($params, $like, $like, $like, $like);
        }
        return [implode(' AND ', $where), $params];
    }

    private static function filters(Request $request): array
    {
        $q = $request->query;
        $status = is_string($q['estado'] ?? null) ? $q['estado'] : '';
        $interest = is_string($q['tema'] ?? null) ? $q['tema'] : '';
        $source = is_string($q['origen'] ?? null) ? $q['origen'] : '';
        return [
            'status' => in_array($status, [...Interests::STATUSES, 'paused'], true) ? $status : '',
            'interest' => in_array($interest, [...Interests::ALL, 'none'], true) ? $interest : '',
            'source' => in_array($source, Interests::SOURCE_TYPES, true) ? $source : '',
            'q' => is_string($q['q'] ?? null) ? mb_substr(trim($q['q']), 0, 100) : '',
            'page' => max(1, (int) ($q['pagina'] ?? 1)),
        ];
    }

    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $f = self::filters($request);
        [$where, $params] = self::where($f);
        $total = (int) DB::value("SELECT COUNT(*) FROM subscribers s WHERE $where", $params);
        $pages = max(1, (int) ceil($total / self::PER_PAGE));
        $f['page'] = min($f['page'], $pages);
        $rows = DB::all(
            "SELECT s.*, (SELECT COUNT(*) FROM subscribers x WHERE x.ip_hash = s.ip_hash) AS same_ip
             FROM subscribers s WHERE $where ORDER BY s.created_at DESC, s.id DESC LIMIT " . self::PER_PAGE . ' OFFSET ' . (($f['page'] - 1) * self::PER_PAGE),
            $params
        );
        $d30 = gmdate('Y-m-d H:i:s', time() - 30 * 86400);
        $stats = DB::one(
            "SELECT SUM(status = 'active') AS active, SUM(status = 'active' AND paused_until > UTC_TIMESTAMP()) AS paused,
                    SUM(status = 'pending') AS pending, SUM(status = 'unsubscribed') AS unsubscribed,
                    SUM(status IN ('spam','bounced')) AS blocked,
                    SUM(status <> 'spam' AND created_at >= :d1) AS new30, SUM(status = 'active' AND confirmed_at >= :d2) AS confirmed30,
                    SUM(status = 'unsubscribed' AND unsubscribed_at >= :d3) AS unsub30
             FROM subscribers",
            ['d1' => $d30, 'd2' => $d30, 'd3' => $d30]
        ) ?? [];
        $byInterest = [];
        foreach (Interests::ALL as $i) {
            $byInterest[$i] = (int) DB::value("SELECT COUNT(*) FROM subscribers WHERE status = 'active' AND FIND_IN_SET(:i, interests) > 0", ['i' => $i]);
        }
        $byInterest['none'] = (int) DB::value("SELECT COUNT(*) FROM subscribers WHERE status = 'active' AND interests = ''");
        $bySource = DB::all("SELECT source_type, COUNT(*) AS total, SUM(status = 'active') AS active FROM subscribers WHERE status <> 'spam' GROUP BY source_type ORDER BY total DESC");
        $topPages = DB::all(
            "SELECT source_type, source_path, MAX(source_title) AS source_title, COUNT(*) AS total, SUM(status = 'active') AS active
             FROM subscribers WHERE status <> 'spam' AND source_path IS NOT NULL GROUP BY source_type, source_path ORDER BY active DESC, total DESC LIMIT 8"
        );
        $waitlist = DB::all('SELECT t.title, COUNT(*) AS n FROM waitlist w JOIN product_translations t ON t.product_id = w.product_id AND t.locale = "es" GROUP BY w.product_id, t.title ORDER BY n DESC');
        return $this->view('subscribers/index', [
            'rows' => $rows,
            'filters' => $f,
            'total' => $total,
            'pages' => $pages,
            'stats' => $stats,
            'byInterest' => $byInterest,
            'bySource' => $bySource,
            'topPages' => $topPages,
            'waitlist' => $waitlist,
            'query' => array_filter(['estado' => $f['status'], 'tema' => $f['interest'], 'origen' => $f['source'], 'q' => $f['q']]),
            'returnUrl' => $request->fullPath(),
        ], t('admin.subscribers'));
    }

    public function bulk(Request $request): Response
    {
        $this->requireAdmin($request);
        $return = self::str($request, 'return', 500) ?? self::BASE;
        $return = str_starts_with($return, self::BASE) ? $return : self::BASE;
        $ids = array_values(array_filter(array_map('intval', is_array($request->post['ids'] ?? null) ? $request->post['ids'] : [])));
        if ($ids === []) {
            return $this->fail($return, t('admin.subs.none_selected'));
        }
        $action = (string) ($request->post['action'] ?? '');
        $n = 0;
        switch ($action) {
            case 'spam':
            case 'bounced':
            case 'unsubscribed':
            case 'active':
                $n = Subscribers::setStatus($ids, $action);
                break;
            case 'delete':
                $n = Subscribers::delete($ids);
                break;
            case 'interests':
                $n = Subscribers::setInterests($ids, Interests::normalize($request->post['interests'] ?? []));
                break;
            case 'resend':
                $limited = 0;
                foreach (DB::all("SELECT * FROM subscribers WHERE status = 'pending' AND id IN (" . DB::in($ids) . ')', $ids) as $row) {
                    if (Subscribers::sendConfirmation($row)) {
                        $n++;
                    } else {
                        $limited++;
                    }
                }
                if ($limited > 0) {
                    return $this->fail($return, t('admin.subs.resend_limited', ['n' => $n, 'm' => $limited]));
                }
                break;
            default:
                return $this->fail($return, t('admin.subs.bad_action'));
        }
        return $this->back($return, t('admin.subs.done', ['n' => $n]));
    }

    public function export(Request $request): Response
    {
        $this->requireAdmin($request);
        [$where, $params] = self::where(self::filters($request));
        $rows = DB::all(
            "SELECT s.email, s.status, s.interests, s.locale, s.source_type, s.source_path, s.source_title, s.source, s.tag, s.referrer,
                    s.utm_source, s.utm_medium, s.utm_campaign, s.created_at, s.confirm_sent_at, s.confirmed_at, s.unsubscribed_at, s.unsubscribed_reason,
                    s.paused_until, s.last_sent_at, s.sends_count, s.last_open_at, s.opens_count, s.last_click_at, s.clicks_count,
                    (SELECT COUNT(*) FROM subscribers x WHERE x.ip_hash = s.ip_hash) AS same_ip
             FROM subscribers s WHERE $where ORDER BY s.created_at",
            $params
        );
        $header = ['email', 'estado', 'intereses', 'idioma', 'tipo_origen', 'pagina_origen', 'titulo_origen', 'origen_antiguo', 'etiqueta', 'referencia',
            'utm_source', 'utm_medium', 'utm_campaign', 'creado_utc', 'confirmacion_enviada_utc', 'confirmado_utc', 'baja_utc', 'motivo_baja',
            'pausado_hasta_utc', 'ultimo_boletin_utc', 'boletines', 'ultima_apertura_utc', 'aperturas', 'ultimo_clic_utc', 'clics', 'altas_misma_ip'];
        return self::csv('suscriptores-' . gmdate('Ymd') . '.csv', $header, $rows);
    }

    /** CSV con BOM y protección contra inyección de fórmulas (=, +, -, @, tabulador y retorno al inicio). */
    public static function csv(string $filename, array $header, array $rows): Response
    {
        $fh = fopen('php://temp', 'r+');
        fwrite($fh, "\xEF\xBB\xBF");
        fputcsv($fh, $header, ';', '"', '');
        foreach ($rows as $row) {
            fputcsv($fh, array_map(fn ($v) => is_string($v) && preg_match('/^[=+\-@\t\r]/', $v) ? "'" . $v : $v, array_values($row)), ';', '"', '');
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
}
