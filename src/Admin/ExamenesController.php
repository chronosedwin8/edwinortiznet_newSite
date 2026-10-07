<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\Examenes\ExamCredits;

/**
 * Generador de exámenes: cuentas, uso (exámenes, preguntas con IA, tokens y costo estimado) y plan manual para soporte.
 */
final class ExamenesController extends AdminBase
{
    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $q = is_string($request->query['q'] ?? null) ? trim($request->query['q']) : '';
        $params = ['now' => DB::now(), 'now2' => DB::now()];
        $where = '(ep.customer_id IS NOT NULL OR EXISTS (SELECT 1 FROM exam_subscriptions s WHERE s.customer_id = c.id))';
        if ($q !== '') {
            $where .= ' AND (c.email LIKE :q OR c.name LIKE :q2)';
            $params += ['q' => "%$q%", 'q2' => "%$q%"];
        }
        $accounts = DB::all(
            "SELECT c.id, c.email, c.name, c.created_at, ep.terms_accepted_at, ep.institution,
                (SELECT COUNT(*) FROM exams x WHERE x.customer_id = c.id AND x.status = 'done') AS exams_done,
                (SELECT COUNT(*) FROM exams x WHERE x.customer_id = c.id AND x.deleted_at IS NOT NULL) AS exams_deleted,
                (SELECT COALESCE(SUM(x.ai_questions), 0) FROM exams x WHERE x.customer_id = c.id) AS ai_questions,
                (SELECT COALESCE(SUM(s.exams), 0) FROM exam_subscriptions s WHERE s.customer_id = c.id AND s.revoked_at IS NULL AND s.expires_at > :now) AS quota,
                (SELECT COALESCE(SUM(s.exams_used), 0) FROM exam_subscriptions s WHERE s.customer_id = c.id AND s.revoked_at IS NULL AND s.expires_at > :now2) AS used,
                (SELECT MAX(s.expires_at) FROM exam_subscriptions s WHERE s.customer_id = c.id AND s.revoked_at IS NULL) AS expires_at,
                (SELECT MAX(x.created_at) FROM exams x WHERE x.customer_id = c.id) AS last_exam_at
             FROM customers c LEFT JOIN exam_profiles ep ON ep.customer_id = c.id
             WHERE $where ORDER BY COALESCE(last_exam_at, ep.created_at, c.created_at) DESC LIMIT 300",
            $params
        );
        $since = gmdate('Y-m-d H:i:s', time() - 30 * 86400);
        $stats = DB::one(
            "SELECT COUNT(*) AS total, SUM(status = 'done') AS done, SUM(status = 'error') AS errors, SUM(created_at > :d) AS last30,
                COALESCE(SUM(ai_questions), 0) AS questions FROM exams",
            ['d' => $since]
        ) ?? [];
        $tokens = DB::one(
            'SELECT COUNT(*) AS calls, COALESCE(SUM(prompt_tokens), 0) AS tin, COALESCE(SUM(output_tokens), 0) AS tout,
                COALESCE(SUM(CASE WHEN created_at > :d THEN prompt_tokens ELSE 0 END), 0) AS tin30,
                COALESCE(SUM(CASE WHEN created_at > :d2 THEN output_tokens ELSE 0 END), 0) AS tout30
             FROM exam_ai_calls',
            ['d' => $since, 'd2' => $since]
        ) ?? [];
        $cost30 = ExamCredits::callCop((int) ($tokens['tin30'] ?? 0), (int) ($tokens['tout30'] ?? 0));
        return $this->view('examenes/index', [
            'accounts' => $accounts,
            'stats' => $stats,
            'tokens' => $tokens,
            'cost30' => $cost30,
            'plans' => ExamCredits::PLANS,
            'q' => $q,
        ], t('admin.examenes'));
    }

    public function grant(Request $request): Response
    {
        $this->requireAdmin($request);
        $email = strtolower((string) self::str($request, 'email', 190));
        $sku = strtoupper((string) self::str($request, 'sku', 20));
        $days = (int) ($request->post['days'] ?? 30);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || ExamCredits::plan($sku) === null || $days < 1 || $days > 366) {
            return $this->fail('/admin/examenes/', t('admin.examenes.invalid'));
        }
        $customerId = ExamCredits::customerFor($email, self::str($request, 'name', 120));
        ExamCredits::grantManual($customerId, $sku, $days, self::str($request, 'note', 190) ?? ('Panel: ' . ($this->admin['email'] ?? '')));
        return $this->back('/admin/examenes/?q=' . rawurlencode($email), t('admin.examenes.granted', ['plan' => $sku, 'email' => $email]));
    }
}
