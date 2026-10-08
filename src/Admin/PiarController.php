<?php

declare(strict_types=1);

namespace App\Admin;

use App\Core\DB;
use App\Core\Request;
use App\Core\Response;
use App\Services\AdminAccess;
use App\Services\Piar\PiarCredits;

/**
 * PIAR con IA: cuentas, pruebas usadas, paquetes vigentes y paquete manual para soporte.
 */
final class PiarController extends AdminBase
{
    public function index(Request $request): Response
    {
        $this->requireAdmin($request);
        $q = is_string($request->query['q'] ?? null) ? trim($request->query['q']) : '';
        $params = ['now' => DB::now()];
        $where = '(pp.customer_id IS NOT NULL OR EXISTS (SELECT 1 FROM piar_packages k WHERE k.customer_id = c.id))';
        if ($q !== '') {
            $where .= ' AND (c.email LIKE :q OR c.name LIKE :q2)';
            $params += ['q' => "%$q%", 'q2' => "%$q%"];
        }
        $accounts = DB::all(
            "SELECT c.id, c.email, c.name, c.created_at, pp.terms_accepted_at, pp.institution, " . AdminAccess::sql('c.id') . " AS is_admin,
                (SELECT COUNT(*) FROM piar_plans x WHERE x.customer_id = c.id AND x.is_trial = 1 AND x.status <> 'error') AS trial_used,
                (SELECT COUNT(*) FROM piar_plans x WHERE x.customer_id = c.id AND x.is_trial = 0 AND x.status = 'done') AS plans_done,
                (SELECT COALESCE(SUM(k.credits), 0) FROM piar_packages k WHERE k.customer_id = c.id AND k.revoked_at IS NULL AND k.expires_at > :now) AS credits,
                (SELECT COALESCE(SUM(k.used), 0) FROM piar_packages k WHERE k.customer_id = c.id AND k.revoked_at IS NULL AND k.expires_at > :now2) AS used,
                (SELECT MAX(k.expires_at) FROM piar_packages k WHERE k.customer_id = c.id AND k.revoked_at IS NULL) AS expires_at,
                (SELECT MAX(x.created_at) FROM piar_plans x WHERE x.customer_id = c.id) AS last_plan_at
             FROM customers c LEFT JOIN piar_profiles pp ON pp.customer_id = c.id
             WHERE $where ORDER BY COALESCE(last_plan_at, pp.created_at, c.created_at) DESC LIMIT 300",
            $params + ['now2' => DB::now()]
        );
        // Las cuentas de administrador (pruebas) no cuentan como ventas ni pruebas: se muestran aparte.
        // Los tokens sí suman todo (es el costo real) e indican cuántos fueron de administrador.
        $stats = DB::one(
            "SELECT COUNT(*) AS total, SUM(adm = 0 AND status = 'done' AND is_trial = 0) AS paid, SUM(adm = 0 AND is_trial = 1 AND status <> 'error') AS trials,
                SUM(adm = 0 AND status = 'error') AS errors, SUM(adm = 0 AND created_at > :d) AS last30,
                SUM(adm = 1 AND status = 'done') AS admin_done, COALESCE(SUM(CASE WHEN adm = 1 THEN prompt_tokens + output_tokens ELSE 0 END), 0) AS admin_tokens,
                COALESCE(SUM(prompt_tokens), 0) AS tin, COALESCE(SUM(output_tokens), 0) AS tout
             FROM (SELECT p.status, p.is_trial, p.created_at, p.prompt_tokens, p.output_tokens, " . AdminAccess::sql('p.customer_id') . " AS adm FROM piar_plans p) x",
            ['d' => gmdate('Y-m-d H:i:s', time() - 30 * 86400)]
        ) ?? [];
        $stats += DB::one(
            "SELECT COUNT(*) AS assists, COALESCE(SUM(prompt_tokens + output_tokens), 0) AS assist_tokens,
                COALESCE(SUM(CASE WHEN " . AdminAccess::sql('a.customer_id') . " THEN prompt_tokens + output_tokens ELSE 0 END), 0) AS assist_admin_tokens
             FROM piar_assists a"
        ) ?? [];
        return $this->view('piar/index', ['accounts' => $accounts, 'stats' => $stats, 'q' => $q, 'adminEmail' => (string) ($this->admin['email'] ?? '')], t('admin.piar'));
    }

    public function grant(Request $request): Response
    {
        $this->requireAdmin($request);
        $email = strtolower((string) self::str($request, 'email', 190));
        $credits = (int) ($request->post['credits'] ?? 0);
        $days = (int) ($request->post['days'] ?? 30);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $credits < 1 || $credits > 500 || $days < 1 || $days > 366) {
            return $this->fail('/admin/piar/', t('admin.piar.invalid'));
        }
        $customerId = PiarCredits::customerFor($email, self::str($request, 'name', 120));
        PiarCredits::grantManual($customerId, $credits, $days, self::str($request, 'note', 190) ?? ('Panel: ' . ($this->admin['email'] ?? '')));
        return $this->back('/admin/piar/?q=' . rawurlencode($email), t('admin.piar.granted', ['n' => $credits, 'email' => $email]));
    }
}
