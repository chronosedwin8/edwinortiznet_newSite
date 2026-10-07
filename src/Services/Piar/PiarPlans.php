<?php

declare(strict_types=1);

namespace App\Services\Piar;

use App\Core\DB;
use App\Core\Logger;
use App\Core\RateLimiter;
use App\Services\Ai\Gemini;

/**
 * PIAR generados. Flujo: create() deja la fila "pending" (y reserva el crédito), generate() llama a Gemini
 * y la deja "done" o "error" (si falla, el crédito vuelve). Las pruebas gratis no se guardan: su contenido
 * se purga a las 2 horas y solo lo ve la misma sesión; el registro (sin contenido) queda para el contador.
 */
final class PiarPlans
{
    public const TRIAL_TTL = 7200;
    public const STALE_SECONDS = 360;
    private const MAX_TEXT = 3000;

    /** Campos de texto largo del formulario. */
    public const LONG_FIELDS = ['contexto_familiar', 'contexto_social', 'contexto_escolar', 'fortalezas', 'intereses', 'barreras', 'recursos_disponibles', 'observaciones', 'soporte_detalle'];

    // ------------------------------------------------------------------ entrada

    /** Limpia lo que envía el formulario: solo claves conocidas, listas del catálogo y textos acotados. */
    public static function sanitizeInput(array $post): array
    {
        $str = static function (mixed $v, int $max): string {
            if (!is_scalar($v)) {
                return '';
            }
            $v = str_replace("\r\n", "\n", (string) $v);
            $v = (string) preg_replace('/[^\P{C}\n]+/u', ' ', $v);
            return trim(mb_substr($v, 0, $max));
        };
        $keys = static function (mixed $v, array $allowed): array {
            $v = is_array($v) ? $v : [];
            return array_values(array_unique(array_filter(array_map('strval', array_filter($v, 'is_scalar')), fn ($k) => isset($allowed[$k]))));
        };
        $student = is_array($post['estudiante'] ?? null) ? $post['estudiante'] : [];
        $grade = $str($student['grado'] ?? '', 20);
        $age = filter_var($student['edad'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 2, 'max_range' => 30]]);
        $year = filter_var($post['anio'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 2017, 'max_range' => 2100]]);
        $period = $str($post['periodo'] ?? '', 20);
        $level = $str($post['nivel_apoyo'] ?? '', 30);
        $val = is_array($post['valoracion'] ?? null) ? $post['valoracion'] : [];
        $input = [
            'estudiante' => [
                'nombre' => $str($student['nombre'] ?? '', 60),
                'edad' => $age === false ? null : $age,
                'grado' => isset(PiarCatalog::grades()[$grade]) ? $grade : '',
                'sede' => $str($student['sede'] ?? '', 120),
                'jornada' => $str($student['jornada'] ?? '', 40),
            ],
            'institucion' => $str($post['institucion'] ?? '', 190),
            'docente' => $str($post['docente'] ?? '', 120),
            'anio' => $year === false ? (int) gmdate('Y') : $year,
            'periodo' => isset(PiarCatalog::periods()[$period]) ? $period : 'anual',
            'condiciones' => $keys($post['condiciones'] ?? [], PiarCatalog::conditionLabels()),
            'otra_condicion' => $str($post['otra_condicion'] ?? '', 300),
            'soporte_clinico' => filter_var($post['soporte_clinico'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'nivel_apoyo' => isset(PiarCatalog::supportLevels()[$level]) ? $level : '',
            'areas' => $keys($post['areas'] ?? [], PiarCatalog::areas()),
            'prioridades' => $keys($post['prioridades'] ?? [], PiarCatalog::priorities()),
            'valoracion' => [],
        ];
        foreach (self::LONG_FIELDS as $field) {
            $input[$field] = $str($post[$field] ?? '', self::MAX_TEXT);
        }
        foreach (array_keys(PiarCatalog::dimensions()) as $dim) {
            $input['valoracion'][$dim] = $str($val[$dim] ?? '', self::MAX_TEXT);
        }
        return $input;
    }

    /** Clave del error de validación (lang piar.error.*) o null. */
    public static function validate(array $input): ?string
    {
        if ($input['estudiante']['grado'] === '') {
            return 'grade';
        }
        if ($input['condiciones'] === [] && $input['otra_condicion'] === '') {
            return 'conditions';
        }
        return null;
    }

    // ------------------------------------------------------------------ creación y generación

    /**
     * Crea el PIAR "pending" consumiendo un crédito o una prueba.
     * @return array{plan: ?array, error: ?string} error: no_credits | trial_exhausted | trial_ip
     */
    public static function create(int $customerId, array $input, string $ip): array
    {
        $ipHash = hash('sha256', 'piar|' . $ip);
        return DB::transaction(function () use ($customerId, $input, $ip, $ipHash): array {
            // Serializa las creaciones de la misma cuenta (evita gastar la prueba dos veces en paralelo).
            PiarProfile::ensure($customerId);
            DB::one('SELECT customer_id FROM piar_profiles WHERE customer_id = :c FOR UPDATE', ['c' => $customerId]);

            $packageId = PiarCredits::reserve($customerId);
            $isTrial = false;
            if ($packageId === null) {
                if (PiarCredits::active($customerId) !== []) {
                    return ['plan' => null, 'error' => 'no_credits'];
                }
                if (PiarCredits::trialUsed($customerId) >= PiarCredits::TRIAL_LIMIT) {
                    return ['plan' => null, 'error' => PiarCredits::summary($customerId)['ever_paid'] ? 'no_credits' : 'trial_exhausted'];
                }
                // Disuade de abrir cuentas en serie desde la misma conexión.
                $recent = (int) DB::value(
                    'SELECT COUNT(*) FROM piar_plans WHERE ip_hash = :h AND is_trial = 1 AND status <> "error" AND created_at > :since',
                    ['h' => $ipHash, 'since' => gmdate('Y-m-d H:i:s', time() - 30 * 86400)]
                );
                if ($recent >= 8 || !RateLimiter::hit('piar-trial', $ip, 4, 86400)) {
                    return ['plan' => null, 'error' => 'trial_ip'];
                }
                $isTrial = true;
            }
            $uuid = bin2hex(random_bytes(16));
            $id = DB::insert('piar_plans', [
                'uuid' => $uuid,
                'customer_id' => $customerId,
                'package_id' => $packageId,
                'is_trial' => $isTrial ? 1 : 0,
                'status' => 'pending',
                'student_alias' => $input['estudiante']['nombre'] !== '' ? $input['estudiante']['nombre'] : null,
                'grade' => $input['estudiante']['grado'],
                'input_json' => json_encode($input, JSON_UNESCAPED_UNICODE),
                'ip_hash' => $ipHash,
                'purge_after' => $isTrial ? gmdate('Y-m-d H:i:s', time() + self::TRIAL_TTL) : null,
            ]);
            return ['plan' => DB::one('SELECT * FROM piar_plans WHERE id = :id', ['id' => $id]), 'error' => null];
        });
    }

    /** Llama a la IA y guarda el resultado. Si falla, marca el error y devuelve el crédito. */
    public static function generate(int $planId): bool
    {
        $plan = DB::one('SELECT * FROM piar_plans WHERE id = :id', ['id' => $planId]);
        if ($plan === null || $plan['status'] !== 'pending') {
            return false;
        }
        $input = json_decode((string) $plan['input_json'], true);
        if (!is_array($input)) {
            self::fail($plan, 'Sin datos de entrada.');
            return false;
        }
        try {
            $result = Gemini::generateJson(PiarPrompt::system(), PiarPrompt::user($input), PiarPrompt::schema());
        } catch (\Throwable $e) {
            self::fail($plan, $e->getMessage());
            return false;
        }
        $output = self::normalizeOutput($result['data']);
        if (trim($output['resumen']) === '' && $output['objetivos'] === [] && $output['ajustes'] === []) {
            self::fail($plan, 'La respuesta de la IA llegó vacía.');
            return false;
        }
        $done = DB::run(
            'UPDATE piar_plans SET status = "done", output_json = :o, model = :m, prompt_tokens = :pt, output_tokens = :ot, error = NULL, purge_after = :p
             WHERE id = :id AND status = "pending"',
            [
                'o' => json_encode($output, JSON_UNESCAPED_UNICODE),
                'm' => mb_substr($result['model'], 0, 60),
                'pt' => $result['prompt_tokens'],
                'ot' => $result['output_tokens'],
                'p' => (int) $plan['is_trial'] === 1 ? gmdate('Y-m-d H:i:s', time() + self::TRIAL_TTL) : null,
                'id' => $planId,
            ]
        )->rowCount();
        return $done === 1;
    }

    /** Marca el error una sola vez (transición pending → error) y devuelve el crédito. */
    public static function fail(array $plan, string $message): void
    {
        $changed = DB::run(
            'UPDATE piar_plans SET status = "error", error = :e' . ((int) $plan['is_trial'] === 1 ? ', input_json = NULL' : '') . ' WHERE id = :id AND status = "pending"',
            ['e' => mb_substr($message, 0, 250), 'id' => (int) $plan['id']]
        )->rowCount();
        if ($changed === 1 && !empty($plan['package_id'])) {
            PiarCredits::release((int) $plan['package_id']);
        }
        if ($changed === 1) {
            Logger::warning('PIAR no generado', ['plan' => (int) $plan['id'], 'error' => mb_substr($message, 0, 200)]);
        }
    }

    /** Los "pending" de más de 6 minutos se dan por fallidos (el proceso murió o la IA no respondió). */
    public static function expireStale(): int
    {
        $rows = DB::all('SELECT * FROM piar_plans WHERE status = "pending" AND created_at < :t', ['t' => gmdate('Y-m-d H:i:s', time() - self::STALE_SECONDS)]);
        foreach ($rows as $row) {
            self::fail($row, 'Tiempo de espera agotado.');
        }
        return count($rows);
    }

    /** Borra el contenido de las pruebas vencidas (queda el registro para el contador). */
    public static function purgeTrials(): int
    {
        return DB::run(
            'UPDATE piar_plans SET input_json = NULL, output_json = NULL, student_alias = NULL, purged_at = :now
             WHERE is_trial = 1 AND purged_at IS NULL AND purge_after IS NOT NULL AND purge_after < :now2 AND status <> "pending"',
            ['now' => DB::now(), 'now2' => DB::now()]
        )->rowCount();
    }

    /** Mantenimiento perezoso (también lo hace el cron piar:purge). */
    public static function housekeeping(): void
    {
        if (random_int(1, 5) === 1) {
            self::expireStale();
            self::purgeTrials();
        }
    }

    // ------------------------------------------------------------------ consulta

    public static function find(string $uuid, int $customerId): ?array
    {
        if (!preg_match('/^[a-f0-9]{32}$/', $uuid)) {
            return null;
        }
        return DB::one('SELECT * FROM piar_plans WHERE uuid = :u AND customer_id = :c', ['u' => $uuid, 'c' => $customerId]);
    }

    /** Historial: solo los PIAR pagados (las pruebas no se guardan). */
    public static function history(int $customerId): array
    {
        return DB::all(
            'SELECT id, uuid, status, student_alias, grade, created_at, edited_at FROM piar_plans
             WHERE customer_id = :c AND is_trial = 0 ORDER BY created_at DESC, id DESC LIMIT 500',
            ['c' => $customerId]
        );
    }

    public static function pending(int $customerId): ?array
    {
        return DB::one('SELECT * FROM piar_plans WHERE customer_id = :c AND status = "pending" ORDER BY id DESC LIMIT 1', ['c' => $customerId]);
    }

    /** ¿La prueba sigue visible para esta sesión? */
    public static function trialVisible(array $plan, array $sessionTrials): bool
    {
        return (int) $plan['is_trial'] === 1
            && in_array($plan['uuid'], $sessionTrials, true)
            && $plan['purged_at'] === null
            && ($plan['purge_after'] === null || strtotime($plan['purge_after'] . ' UTC') > time());
    }

    public static function input(array $plan): array
    {
        $input = json_decode((string) ($plan['input_json'] ?? ''), true);
        return is_array($input) ? $input : [];
    }

    public static function output(array $plan): array
    {
        $output = json_decode((string) ($plan['output_json'] ?? ''), true);
        return self::normalizeOutput(is_array($output) ? $output : []);
    }

    // ------------------------------------------------------------------ estructura del documento

    /** Campos de cada objeto del documento (los de lista van marcados con []). */
    public const SHAPE = [
        'contexto' => ['familiar', 'social', 'escolar'],
        'valoracion_pedagogica' => ['cognitiva', 'comunicativa', 'socioafectiva', 'corporal', 'participacion'],
        'barreras' => ['tipo', 'descripcion'],
        'objetivos' => ['area', 'objetivo', 'meta', 'indicador'],
        'ajustes' => ['area', 'categoria', 'ajuste', 'estrategias[]', 'responsable', 'frecuencia'],
        'evaluacion' => ['aspecto', 'ajuste'],
        'recursos' => ['humanos[]', 'fisicos[]', 'tecnologicos[]', 'materiales[]'],
        'compromisos' => ['docentes[]', 'familia[]', 'directivos[]', 'estudiante[]'],
        'seguimiento' => ['periodicidad', 'indicadores[]', 'momentos[]'],
    ];
    public const TEXTS = ['resumen', 'observaciones'];
    public const LISTS = ['fortalezas', 'intereses', 'proyectos', 'aula_inclusiva'];
    public const ITEM_LISTS = ['barreras', 'objetivos', 'ajustes', 'evaluacion'];

    /**
     * Lleva cualquier respuesta (de la IA o del formulario de edición) a la forma exacta del documento:
     * textos acotados, listas sin vacíos (un texto se parte por líneas) y objetos con todos sus campos.
     */
    public static function normalizeOutput(array $raw): array
    {
        $out = [];
        foreach (self::TEXTS as $key) {
            $out[$key] = self::text($raw[$key] ?? '');
        }
        foreach (self::LISTS as $key) {
            $out[$key] = self::list($raw[$key] ?? []);
        }
        foreach (self::SHAPE as $key => $fields) {
            if (in_array($key, self::ITEM_LISTS, true)) {
                $items = [];
                foreach (array_slice(is_array($raw[$key] ?? null) ? array_values($raw[$key]) : [], 0, 80) as $item) {
                    $obj = self::object(is_array($item) ? $item : [], $fields);
                    if (implode('', array_map(fn ($v) => is_array($v) ? implode('', $v) : $v, $obj)) !== '') {
                        $items[] = $obj;
                    }
                }
                $out[$key] = $items;
            } else {
                $out[$key] = self::object(is_array($raw[$key] ?? null) ? $raw[$key] : [], $fields);
            }
        }
        return $out;
    }

    private static function object(array $raw, array $fields): array
    {
        $obj = [];
        foreach ($fields as $field) {
            if (str_ends_with($field, '[]')) {
                $name = substr($field, 0, -2);
                $obj[$name] = self::list($raw[$name] ?? []);
            } else {
                $obj[$field] = self::text($raw[$field] ?? '', $field === 'categoria' || $field === 'area' || $field === 'tipo' ? 200 : 4000);
            }
        }
        return $obj;
    }

    private static function text(mixed $v, int $max = 8000): string
    {
        if (!is_scalar($v)) {
            return '';
        }
        $v = str_replace("\r\n", "\n", (string) $v);
        $v = (string) preg_replace('/[^\P{C}\n]+/u', ' ', $v);
        return trim(mb_substr($v, 0, $max));
    }

    /** @return string[] */
    private static function list(mixed $v): array
    {
        if (is_string($v)) {
            $v = explode("\n", str_replace("\r\n", "\n", $v));
        }
        if (!is_array($v)) {
            return [];
        }
        $out = [];
        foreach (array_slice(array_values($v), 0, 80) as $item) {
            // Al editar se escribe un elemento por línea; se quitan viñetas al inicio.
            $item = (string) preg_replace('/^\s*(?:[-•*·▸]|\d+[.)])\s+/u', '', self::text($item, 2000));
            if ($item !== '') {
                $out[] = $item;
            }
        }
        return $out;
    }

    /** Guarda la edición del docente (solo PIAR pagados y terminados). */
    public static function saveEdit(array $plan, array $post): array
    {
        $output = self::normalizeOutput($post);
        DB::run('UPDATE piar_plans SET output_json = :o, edited_at = :now WHERE id = :id AND is_trial = 0 AND status = "done"', [
            'o' => json_encode($output, JSON_UNESCAPED_UNICODE), 'now' => DB::now(), 'id' => (int) $plan['id'],
        ]);
        return $output;
    }

    /** PIAR-<alias>-<fecha>.pdf */
    public static function fileName(array $plan): string
    {
        $alias = (string) ($plan['student_alias'] ?? '');
        $alias = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $alias) ?: '';
        $alias = trim((string) preg_replace('/[^A-Za-z0-9]+/', '-', $alias), '-');
        return 'PIAR-' . ($alias !== '' ? mb_substr($alias, 0, 40) : 'estudiante') . '-' . substr((string) $plan['created_at'], 0, 10) . '.pdf';
    }
}
