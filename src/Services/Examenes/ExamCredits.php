<?php

declare(strict_types=1);

namespace App\Services\Examenes;

use App\Core\DB;
use App\Services\AdminAccess;

/**
 * Planes del Generador de exámenes: suscripciones de 30 días que se suman (cada compra crea una nueva).
 * Cada plan define exámenes por periodo, versiones por examen, preguntas únicas por examen (las que escribe
 * la IA: en «versiones distintas» cuenta preguntas × versiones) y un cupo extra por examen para pedir
 * preguntas adicionales o reemplazos con IA en el editor. Cada examen consume uno del plan vigente que vence
 * primero y admite sus límites. Borrar un examen no devuelve nada.
 *
 * El modelo de costos (worstCase) usa los mismos topes que la generación, así que el margen calculado es real.
 */
final class ExamCredits
{
    public const DAYS = 30;
    /** Generaciones fallidas que devuelven el examen al plan (después, el intento cuenta). */
    public const FAILED_REFUNDS = 2;

    /**
     * SKU => límites y precio de referencia (el precio real es el del producto en la tienda).
     * exams: exámenes por 30 días; versions: versiones por examen; questions: preguntas únicas por examen;
     * extra: preguntas adicionales o de reemplazo con IA por examen.
     */
    public const PLANS = [
        'EXAM-8' => ['exams' => 8, 'versions' => 4, 'questions' => 24, 'extra' => 6, 'cop' => 29900, 'usd' => 9.50],
        'EXAM-20' => ['exams' => 20, 'versions' => 6, 'questions' => 36, 'extra' => 8, 'cop' => 74900, 'usd' => 21.90],
        'EXAM-40' => ['exams' => 40, 'versions' => 8, 'questions' => 45, 'extra' => 10, 'cop' => 159900, 'usd' => 44.90],
    ];
    public const POPULAR = 'EXAM-20';
    /** «Exámenes disponibles» de una cuenta de administrador (no se consumen; ver AdminAccess). */
    public const ADMIN_EXAMS = 9999;

    // ---- Topes de la IA (acotan el peor caso) -------------------------------------------------
    /** Preguntas (unidades pregunta × versión) por llamada de generación. */
    public const CHUNK_UNITS = 12;
    /** Unidades del único reintento por examen (como mínimo, una pregunta con todas sus versiones). */
    public const RETRY_UNITS = 6;
    /** Razonamiento por llamada: materias con cálculos, materias con fórmulas ocasionales y llamadas del editor (STEM). */
    public const THINKING_STEM = 1280;
    public const THINKING_LIGHT = 512;
    public const THINKING_EDIT = 512;
    /** Holgura de salida por llamada (llaves del JSON, campo h…). */
    public const OUTPUT_MARGIN = 256;
    /** Salida del plan del examen por pregunta (tabla de especificaciones). */
    public const PLAN_TOKENS = 40;
    /**
     * Entrada máxima por llamada (tokens; se cuentan 3 caracteres por token, por lo alto).
     * Generación y plan: instrucciones, esquema y reglas de los tipos (≈1.800 medidos) + tema (200 caracteres)
     * + contexto (3.000 caracteres ≈ 1.000) + habilidades asignadas (≈300).
     * Editor: lo anterior + tema y contexto de la solicitud (200 + 1.500 caracteres) + 30 preguntas existentes (90 caracteres c/u).
     */
    public const INPUT_GEN = 3500;
    public const INPUT_EDIT = 5000;
    /** Solicitudes de IA en el editor por examen y preguntas por solicitud. */
    public const EDIT_REQUESTS = 5;
    public const EDIT_MAX = 5;

    // ---- Precios (USD por millón de tokens, nivel pago de Gemini) y pasarela -----------------
    public const PRICE_IN = 0.30;
    public const PRICE_OUT = 2.50;
    public const USD_COP = 4000;

    // ------------------------------------------------------------------ catálogo

    /**
     * Planes a la venta (productos con SKU EXAM-*), con su enlace al pago.
     * @return array<int, array{sku:string, exams:int, versions:int, questions:int, extra:int, price_cop:int, price_usd:float, product_id:?int, title:string, slug:?string, buyable:bool}>
     */
    public static function offers(): array
    {
        $rows = [];
        $skus = array_keys(self::PLANS);
        $in = implode(',', array_fill(0, count($skus), '?'));
        foreach (DB::all(
            "SELECT p.id, p.sku, p.price_cop, p.price_usd, p.status, t.title, t.slug FROM products p
             LEFT JOIN product_translations t ON t.product_id = p.id AND t.locale = 'es'
             WHERE p.sku IN ($in)",
            $skus
        ) as $row) {
            $rows[$row['sku']] = $row;
        }
        $out = [];
        foreach (self::PLANS as $sku => $plan) {
            $p = $rows[$sku] ?? null;
            $out[] = [
                'sku' => $sku,
                'exams' => $plan['exams'],
                'versions' => $plan['versions'],
                'questions' => $plan['questions'],
                'extra' => $plan['extra'],
                'price_cop' => $p ? (int) $p['price_cop'] : $plan['cop'],
                'price_usd' => $p ? (float) $p['price_usd'] : $plan['usd'],
                'product_id' => $p ? (int) $p['id'] : null,
                'title' => (string) ($p['title'] ?? $sku),
                'slug' => $p['slug'] ?? null,
                'buyable' => $p !== null && $p['status'] === 'active',
            ];
        }
        return $out;
    }

    public static function plan(?string $sku): ?array
    {
        return self::PLANS[strtoupper((string) $sku)] ?? null;
    }

    /** Id del cliente con ese correo; lo crea si no existe (misma tabla que la tienda y PIAR). */
    public static function customerFor(string $email, ?string $name = null, string $locale = 'es'): int
    {
        return \App\Services\Piar\PiarCredits::customerFor($email, $name, $locale);
    }

    // ------------------------------------------------------------------ pedidos

    /**
     * Pedido aprobado: una suscripción por cada ítem EXAM-* (idempotente por order_item_id).
     * Se llama dentro de la transacción de OrderService::apply. Devuelve cuántas se crearon.
     */
    public static function grantForOrder(int $orderId): int
    {
        $skus = array_keys(self::PLANS);
        $in = implode(',', array_fill(0, count($skus), '?'));
        // Planes comprados directamente o incluidos en un pack (p. ej., el Pack Docente).
        $items = DB::all(
            "SELECT oi.id, oi.quantity, p.sku FROM order_items oi JOIN products p ON p.id = oi.product_id
             WHERE oi.order_id = ? AND p.sku IN ($in)
             UNION ALL
             SELECT oi.id, oi.quantity, c.sku FROM order_items oi JOIN pack_items pi ON pi.pack_id = oi.product_id JOIN products c ON c.id = pi.product_id
             WHERE oi.order_id = ? AND c.sku IN ($in)",
            array_merge([$orderId], $skus, [$orderId], $skus)
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
            if (DB::value('SELECT id FROM exam_subscriptions WHERE order_item_id = :i', ['i' => (int) $item['id']]) !== null) {
                continue;
            }
            $plan = self::plan((string) $item['sku']);
            if ($plan === null) {
                continue;
            }
            DB::insert('exam_subscriptions', [
                'customer_id' => $customerId,
                'order_id' => $orderId,
                'order_item_id' => (int) $item['id'],
                'sku' => strtoupper((string) $item['sku']),
                'exams' => $plan['exams'] * max(1, (int) $item['quantity']),
                'max_versions' => $plan['versions'],
                'max_questions' => $plan['questions'],
                'ai_extra' => $plan['extra'],
                'starts_at' => gmdate('Y-m-d H:i:s', $start),
                'expires_at' => gmdate('Y-m-d H:i:s', $start + self::DAYS * 86400),
            ]);
            $created++;
        }
        return $created;
    }

    /** Reembolso: el cupo sin usar del pedido deja de estar disponible (los exámenes generados se conservan). */
    public static function revokeForOrder(int $orderId): int
    {
        return DB::run('UPDATE exam_subscriptions SET revoked_at = :now WHERE order_id = :o AND revoked_at IS NULL', ['now' => DB::now(), 'o' => $orderId])->rowCount();
    }

    /** Plan manual (soporte desde el panel). */
    public static function grantManual(int $customerId, string $sku, int $days = self::DAYS, ?string $note = null): int
    {
        $plan = self::plan($sku) ?? self::PLANS['EXAM-8'];
        $now = time();
        return DB::insert('exam_subscriptions', [
            'customer_id' => $customerId,
            'sku' => 'MANUAL-' . strtoupper(substr($sku, 5)),
            'exams' => $plan['exams'],
            'max_versions' => $plan['versions'],
            'max_questions' => $plan['questions'],
            'ai_extra' => $plan['extra'],
            'starts_at' => gmdate('Y-m-d H:i:s', $now),
            'expires_at' => gmdate('Y-m-d H:i:s', $now + max(1, min(366, $days)) * 86400),
            'note' => $note !== null && $note !== '' ? mb_substr($note, 0, 190) : null,
        ]);
    }

    public static function forOrder(int $orderId): array
    {
        return DB::all('SELECT * FROM exam_subscriptions WHERE order_id = :o ORDER BY id', ['o' => $orderId]);
    }

    // ------------------------------------------------------------------ cupo

    /** Suscripciones vigentes (no revocadas ni vencidas), la que vence primero arriba. */
    public static function active(int $customerId): array
    {
        return DB::all(
            'SELECT * FROM exam_subscriptions WHERE customer_id = :c AND revoked_at IS NULL AND starts_at <= :now AND expires_at > :now2 ORDER BY expires_at, id',
            ['c' => $customerId, 'now' => DB::now(), 'now2' => DB::now()]
        );
    }

    /**
     * Estado de la cuenta para el medidor de uso y los límites del asistente.
     * @return array{exams:int, used:int, remaining:int, expires_at:?string, has_active:bool, ever_paid:bool, max_versions:int, max_questions:int, ai_extra:int, subscriptions:array, admin:bool}
     */
    public static function summary(int $customerId): array
    {
        $subs = self::active($customerId);
        $withCredits = array_values(array_filter($subs, fn ($s) => (int) $s['exams_used'] < (int) $s['exams']));
        $limit = static fn (string $k): int => $withCredits ? max(array_map(fn ($s) => (int) $s[$k], $withCredits)) : 0;
        if (AdminAccess::isAdmin($customerId)) {
            // Acceso de administrador (pruebas): sin plan y sin consumir cupo, con los límites del plan más alto.
            $admin = self::adminLimits();
            return [
                'exams' => self::ADMIN_EXAMS,
                'used' => 0,
                'remaining' => self::ADMIN_EXAMS,
                'expires_at' => null,
                'has_active' => true,
                'ever_paid' => true,
                'max_versions' => $admin['versions'],
                'max_questions' => $admin['questions'],
                'ai_extra' => $admin['extra'],
                'subscriptions' => $subs,
                'admin' => true,
            ];
        }
        return [
            'exams' => array_sum(array_map(fn ($s) => (int) $s['exams'], $subs)),
            'used' => array_sum(array_map(fn ($s) => (int) $s['exams_used'], $subs)),
            'remaining' => array_sum(array_map(fn ($s) => max(0, (int) $s['exams'] - (int) $s['exams_used']), $subs)),
            'expires_at' => $withCredits[0]['expires_at'] ?? ($subs ? end($subs)['expires_at'] : null),
            'has_active' => $subs !== [],
            'ever_paid' => $subs !== [] || DB::value('SELECT id FROM exam_subscriptions WHERE customer_id = :c LIMIT 1', ['c' => $customerId]) !== null,
            'max_versions' => $limit('max_versions'),
            'max_questions' => $limit('max_questions'),
            'ai_extra' => $limit('ai_extra'),
            'subscriptions' => $subs,
            'admin' => false,
        ];
    }

    /**
     * Límites por examen de una cuenta de administrador: los más altos de los planes a la venta
     * (y todas las versiones posibles).
     * @return array{versions:int, questions:int, extra:int}
     */
    public static function adminLimits(): array
    {
        return [
            'versions' => min(count(ExamCatalog::VERSION_LABELS), max(array_column(self::PLANS, 'versions'))),
            'questions' => max(array_column(self::PLANS, 'questions')),
            'extra' => max(array_column(self::PLANS, 'extra')),
        ];
    }

    /**
     * Toma un examen de la suscripción vigente que vence primero y admite estos límites.
     * Debe llamarse dentro de una transacción. Devuelve la fila o null.
     */
    public static function reserve(int $customerId, int $versions, int $uniqueQuestions): ?array
    {
        $sub = DB::one(
            'SELECT * FROM exam_subscriptions WHERE customer_id = :c AND revoked_at IS NULL AND starts_at <= :now AND expires_at > :now2
               AND exams_used < exams AND max_versions >= :v AND max_questions >= :q
             ORDER BY expires_at, id LIMIT 1 FOR UPDATE',
            ['c' => $customerId, 'now' => DB::now(), 'now2' => DB::now(), 'v' => $versions, 'q' => $uniqueQuestions]
        );
        if ($sub === null) {
            return null;
        }
        DB::run('UPDATE exam_subscriptions SET exams_used = exams_used + 1 WHERE id = :id', ['id' => (int) $sub['id']]);
        return $sub;
    }

    /** Devuelve el examen al plan si la generación falló (máximo FAILED_REFUNDS veces por suscripción). */
    public static function release(int $subscriptionId): bool
    {
        return DB::run(
            'UPDATE exam_subscriptions SET exams_used = exams_used - 1, refunds_used = refunds_used + 1
             WHERE id = :id AND exams_used > 0 AND refunds_used < :max',
            ['id' => $subscriptionId, 'max' => self::FAILED_REFUNDS]
        )->rowCount() === 1;
    }

    // ------------------------------------------------------------------ costos

    /** Tope de salida (tokens) por pregunta y versión según su tipo. */
    public static function unitCap(string $type): int
    {
        return ExamCatalog::TYPES[$type]['cap'] ?? max(array_column(ExamCatalog::TYPES, 'cap'));
    }

    public static function maxUnitCap(): int
    {
        return max(array_column(ExamCatalog::TYPES, 'cap'));
    }

    /** Costo en COP de una llamada con esos tokens. */
    public static function callCop(int $input, int $output): float
    {
        return ($input * self::PRICE_IN + $output * self::PRICE_OUT) / 1_000_000 * self::USD_COP;
    }

    /** Comisión de Wompi con tarjeta (peor caso): 2,99 % + 600 COP, más IVA del 19 % sobre la comisión. */
    public static function gatewayFeeCop(int $price): float
    {
        return ($price * 0.0299 + 600) * 1.19;
    }

    /** PayPal (cobros internacionales en USD): 5,4 % + 0,30 USD. */
    public static function paypalFeeUsd(float $price): float
    {
        return $price * 0.054 + 0.30;
    }

    /**
     * Costo de IA de un examen. $mode: worst (todo llega al tope), heavy (máximo uso con el consumo medido) o normal.
     * @return array{cop:float, input:int, output:int, calls:int}
     */
    public static function examCost(array $plan, string $mode = 'worst'): array
    {
        $q = (int) $plan['questions'];
        $extra = (int) $plan['extra'];
        if ($mode === 'normal') {
            // Examen típico: 20 preguntas en 2 versiones distintas (40 unidades), una solicitud en el editor.
            $units = min($q, 40);
            $calls = (int) ceil($units / self::CHUNK_UNITS) + 1 + 1;
            $output = (int) ($units * 230 + ($calls - 1) * 900 + 3 * 230);
            $input = $calls * 2200;
            return ['cop' => self::callCop($input, $output), 'input' => $input, 'output' => $output, 'calls' => $calls];
        }
        $per = $mode === 'heavy' ? 300 : self::maxUnitCap();
        $thinking = $mode === 'heavy' ? 1300 : self::THINKING_STEM;
        $gen = (int) ceil($q / self::CHUNK_UNITS);
        $calls = $gen + ($gen > 1 ? 1 : 0) + self::EDIT_REQUESTS + ($mode === 'worst' ? 1 : 0);
        $output = ($q + $extra) * $per
            + $gen * ($thinking + self::OUTPUT_MARGIN)
            + ($gen > 1 ? $q * self::PLAN_TOKENS + self::OUTPUT_MARGIN : 0)
            + self::EDIT_REQUESTS * (($mode === 'heavy' ? 400 : self::THINKING_EDIT) + self::OUTPUT_MARGIN);
        if ($mode === 'worst') {
            // Un reintento facturado por examen: un bloque completo.
            $output += max(self::RETRY_UNITS, (int) ($plan['versions'] ?? 1)) * $per + $thinking + self::OUTPUT_MARGIN;
        }
        $genCalls = $calls - self::EDIT_REQUESTS;
        $input = $mode === 'worst'
            ? $genCalls * self::INPUT_GEN + self::EDIT_REQUESTS * self::INPUT_EDIT
            : $genCalls * 2600 + self::EDIT_REQUESTS * 3400;
        return ['cop' => self::callCop($input, $output), 'input' => $input, 'output' => $output, 'calls' => $calls];
    }

    /**
     * Análisis de un plan: costo de IA del mes (normal, uso máximo y peor caso, incluidos los intentos fallidos
     * devueltos), comisión de la pasarela y margen.
     * @return array<string, mixed>
     */
    public static function analysis(string $sku, ?int $priceCop = null, ?float $priceUsd = null): array
    {
        $plan = self::PLANS[$sku];
        $price = $priceCop ?? $plan['cop'];
        $usd = $priceUsd ?? $plan['usd'];
        $fee = self::gatewayFeeCop($price);
        $out = ['sku' => $sku, 'price_cop' => $price, 'price_usd' => $usd, 'fee_cop' => round($fee)];
        foreach (['normal', 'heavy', 'worst'] as $mode) {
            $exam = self::examCost($plan, $mode);
            $exams = $plan['exams'] + ($mode === 'worst' ? self::FAILED_REFUNDS : 0);
            $ai = $exam['cop'] * $exams;
            $out[$mode] = [
                'exam_cop' => round($exam['cop'], 1),
                'exam_output_tokens' => $exam['output'],
                'exam_input_tokens' => $exam['input'],
                'exam_calls' => $exam['calls'],
                'month_cop' => round($ai),
                'margin' => round(($price - $fee - $ai) / $price, 4),
                'margin_paypal' => round(($usd - self::paypalFeeUsd($usd) - $ai / self::USD_COP) / $usd, 4),
            ];
        }
        return $out;
    }
}
