<?php

declare(strict_types=1);

namespace App\Services\Examenes;

use App\Core\DB;
use App\Core\Logger;

/**
 * Exámenes generados. Flujo: create() reserva un examen del plan y deja la fila «pending»; generate() llama a
 * la IA y la deja «done» o «error» (si falla, el examen vuelve al plan, hasta FAILED_REFUNDS veces).
 * Borrar un examen solo lo oculta y borra su contenido: el cupo usado no se devuelve.
 */
final class Exams
{
    public const STALE_SECONDS = 900;
    /** Topes de los textos libres del docente (acotan la entrada de cada llamada a la IA). */
    public const MAX_TOPIC = 200;
    public const MAX_CONTEXT = 3000;
    public const MAX_REQUEST_CONTEXT = 1500;

    // ------------------------------------------------------------------ entrada

    private static function str(mixed $v, int $max): string
    {
        if (!is_scalar($v)) {
            return '';
        }
        $v = str_replace("\r\n", "\n", (string) $v);
        $v = (string) preg_replace('/[^\P{C}\n]+/u', ' ', $v);
        return trim(mb_substr($v, 0, $max));
    }

    /** Texto libre del docente: sin los delimitadores que usa el mensaje a la IA. */
    public static function free(mixed $v, int $max): string
    {
        return self::str(str_replace(['<<<', '>>>'], ['« « «', '» » »'], is_scalar($v) ? (string) $v : ''), $max);
    }

    private static function pick(mixed $v, array $allowed, string $default): string
    {
        return is_string($v) && in_array($v, $allowed, true) ? $v : $default;
    }

    /** Limpia lo que envía el asistente: solo claves conocidas, valores del catálogo y textos acotados. */
    public static function sanitizeInput(array $post): array
    {
        $types = [];
        $rawTypes = is_array($post['tipos'] ?? null) ? $post['tipos'] : [];
        foreach (ExamCatalog::TYPES as $type => $def) {
            $n = filter_var($rawTypes[$type] ?? 0, FILTER_VALIDATE_INT);
            $types[$type] = $n === false ? 0 : max(0, min(99, $n));
        }
        $versions = filter_var($post['versiones'] ?? 1, FILTER_VALIDATE_INT);
        $options = filter_var($post['opciones'] ?? 4, FILTER_VALIDATE_INT);
        return [
            'materia' => self::pick($post['materia'] ?? '', array_keys(ExamCatalog::SUBJECTS), ''),
            'materia_otra' => self::str($post['materia_otra'] ?? '', 80),
            'grado' => self::pick($post['grado'] ?? '', ExamCatalog::GRADES, ''),
            'tema' => self::free($post['tema'] ?? '', self::MAX_TOPIC),
            'contexto' => self::free($post['contexto'] ?? '', self::MAX_CONTEXT),
            'alcance' => self::pick($post['alcance'] ?? '', ExamCatalog::SCOPES, 'unidad'),
            'proposito' => self::pick($post['proposito'] ?? '', ExamCatalog::PURPOSES, 'sumativa'),
            'dificultad' => self::pick($post['dificultad'] ?? '', ExamCatalog::DIFFICULTIES, 'medio'),
            'estilo' => self::pick($post['estilo'] ?? '', ExamCatalog::STYLES, 'mixto'),
            'opciones' => in_array($options, ExamCatalog::OPTION_COUNTS, true) ? $options : 4,
            'tipos' => $types,
            'versiones' => $versions === false ? 1 : max(1, min(count(ExamCatalog::VERSION_LABELS), $versions)),
            'modo' => self::pick($post['modo'] ?? '', ExamCatalog::MODES, 'barajar'),
        ];
    }

    /** Encabezado y formato (asistente y editor). */
    public static function sanitizeHeader(array $post): array
    {
        $h = is_array($post['header'] ?? null) ? $post['header'] : [];
        $date = self::str($h['fecha'] ?? '', 10);
        return [
            'institucion' => self::str($h['institucion'] ?? '', 190),
            'titulo' => self::str($h['titulo'] ?? '', 160),
            'asignatura' => self::str($h['asignatura'] ?? '', 80),
            'grado' => self::str($h['grado'] ?? '', 60),
            'docente' => self::str($h['docente'] ?? '', 120),
            'duracion' => self::str($h['duracion'] ?? '', 40),
            'fecha' => preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) ? $date : '',
            'instrucciones' => self::str($h['instrucciones'] ?? '', 1200),
            'papel' => self::pick($h['papel'] ?? '', array_keys(ExamCatalog::PAPERS), 'carta'),
            'letra' => self::pick($h['letra'] ?? '', ['normal', 'grande'], 'normal'),
            'logo' => filter_var($h['logo'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'hoja' => filter_var($h['hoja'] ?? false, FILTER_VALIDATE_BOOLEAN),
            'puntaje' => filter_var($h['puntaje'] ?? false, FILTER_VALIDATE_BOOLEAN),
        ];
    }

    /** Encabezado con los valores por defecto (perfil, materia y grado) donde el docente no escribió nada. */
    public static function header(array $header, array $input): array
    {
        $subject = $input['materia'] === 'otra' && ($input['materia_otra'] ?? '') !== '' ? $input['materia_otra'] : (ExamCatalog::subjects()[$input['materia']] ?? '');
        $header += self::sanitizeHeader([]);
        if ($header['asignatura'] === '') {
            $header['asignatura'] = $subject;
        }
        if ($header['grado'] === '') {
            $header['grado'] = ExamCatalog::grades()[$input['grado']] ?? '';
        }
        if ($header['titulo'] === '') {
            $header['titulo'] = t('examenes.pdf.default_title', ['subject' => $subject]);
        }
        if ($header['instrucciones'] === '') {
            $header['instrucciones'] = t('examenes.pdf.default_instructions');
        }
        return $header;
    }

    /** Total de preguntas por versión. */
    public static function perVersion(array $input): int
    {
        return array_sum($input['tipos']);
    }

    /** Preguntas únicas que escribe la IA (en «versiones distintas» cuenta cada versión). */
    public static function unique(array $input): int
    {
        return self::perVersion($input) * ($input['modo'] === 'distintas' ? $input['versiones'] : 1);
    }

    /** Clave del error de validación (lang examenes.error.*) o null. */
    public static function validate(array $input, array $summary): ?string
    {
        if ($input['materia'] === '' || ($input['materia'] === 'otra' && $input['materia_otra'] === '')) {
            return 'subject';
        }
        if ($input['grado'] === '') {
            return 'grade';
        }
        if (mb_strlen($input['tema']) < 3) {
            return 'topic';
        }
        if (self::perVersion($input) === 0) {
            return 'types';
        }
        foreach ($input['tipos'] as $type => $n) {
            if ($n > ExamCatalog::TYPES[$type]['max']) {
                return 'type_max';
            }
        }
        if ($summary['has_active'] && $summary['remaining'] > 0) {
            if ($input['versiones'] > $summary['max_versions']) {
                return 'versions';
            }
            if (self::unique($input) > $summary['max_questions']) {
                return 'questions';
            }
        }
        return null;
    }

    // ------------------------------------------------------------------ creación y generación

    /**
     * Crea el examen «pending» reservando uno del plan.
     * @return array{exam: ?array, error: ?string} error: no_plan | no_credits | limits
     */
    public static function create(int $customerId, array $input, array $header): array
    {
        return DB::transaction(function () use ($customerId, $input, $header): array {
            ExamProfile::ensure($customerId);
            DB::one('SELECT customer_id FROM exam_profiles WHERE customer_id = :c FOR UPDATE', ['c' => $customerId]);
            $sub = ExamCredits::reserve($customerId, (int) $input['versiones'], self::unique($input));
            if ($sub === null) {
                $summary = ExamCredits::summary($customerId);
                return ['exam' => null, 'error' => !$summary['has_active'] ? 'no_plan' : ($summary['remaining'] === 0 ? 'no_credits' : 'limits')];
            }
            $uuid = bin2hex(random_bytes(16));
            $id = DB::insert('exams', [
                'uuid' => $uuid,
                'customer_id' => $customerId,
                'subscription_id' => (int) $sub['id'],
                'status' => 'pending',
                'title' => mb_substr($input['tema'], 0, 190),
                'subject' => $input['materia'],
                'grade' => $input['grado'],
                'mode' => $input['modo'],
                'versions' => (int) $input['versiones'],
                'questions' => self::perVersion($input),
                'ai_questions' => self::unique($input),
                'input_json' => json_encode($input, JSON_UNESCAPED_UNICODE),
                'header_json' => json_encode($header, JSON_UNESCAPED_UNICODE),
            ]);
            return ['exam' => DB::one('SELECT * FROM exams WHERE id = :id', ['id' => $id]), 'error' => null];
        });
    }

    /** Llama a la IA y guarda el resultado. Si falla, marca el error y devuelve el examen al plan. */
    public static function generate(int $examId): bool
    {
        $exam = DB::one('SELECT * FROM exams WHERE id = :id', ['id' => $examId]);
        if ($exam === null || $exam['status'] !== 'pending') {
            return false;
        }
        $input = self::input($exam);
        if ($input === []) {
            self::fail($exam, 'Sin datos de entrada.');
            return false;
        }
        try {
            $result = ExamGenerator::generate($exam, $input);
        } catch (\Throwable $e) {
            self::fail($exam, $e->getMessage());
            return false;
        }
        $content = ['v' => 1, 'seed' => random_int(1, 2_000_000_000), 'slots' => $result['slots'], 'missing' => $result['missing']];
        $done = DB::run(
            'UPDATE exams SET status = "done", content_json = :c, model = :m, prompt_tokens = prompt_tokens + :pt, output_tokens = output_tokens + :ot,
                progress = 100, error = NULL WHERE id = :id AND status = "pending"',
            [
                'c' => json_encode($content, JSON_UNESCAPED_UNICODE),
                'm' => mb_substr($result['model'], 0, 60),
                'pt' => $result['prompt_tokens'],
                'ot' => $result['output_tokens'],
                'id' => $examId,
            ]
        )->rowCount();
        return $done === 1;
    }

    /** Marca el error una sola vez (pending → error) y devuelve el examen al plan si aún se puede. */
    public static function fail(array $exam, string $message): void
    {
        $changed = DB::run(
            'UPDATE exams SET status = "error", error = :e WHERE id = :id AND status = "pending"',
            ['e' => mb_substr($message, 0, 250), 'id' => (int) $exam['id']]
        )->rowCount();
        if ($changed === 1) {
            $refunded = !empty($exam['subscription_id']) && ExamCredits::release((int) $exam['subscription_id']);
            Logger::warning('Examen no generado', ['exam' => (int) $exam['id'], 'refunded' => $refunded, 'error' => mb_substr($message, 0, 200)]);
        }
    }

    public static function expireStale(): int
    {
        $rows = DB::all('SELECT * FROM exams WHERE status = "pending" AND created_at < :t', ['t' => gmdate('Y-m-d H:i:s', time() - self::STALE_SECONDS)]);
        foreach ($rows as $row) {
            self::fail($row, 'Tiempo de espera agotado.');
        }
        return count($rows);
    }

    /** Borra el contenido de los exámenes eliminados hace más de 30 días (el registro queda para el contador). */
    public static function purgeDeleted(): int
    {
        return DB::run(
            'UPDATE exams SET input_json = NULL, content_json = NULL, header_json = NULL WHERE deleted_at IS NOT NULL AND deleted_at < :t AND content_json IS NOT NULL',
            ['t' => gmdate('Y-m-d H:i:s', time() - 30 * 86400)]
        )->rowCount();
    }

    public static function housekeeping(): void
    {
        if (random_int(1, 5) === 1) {
            self::expireStale();
        }
    }

    // ------------------------------------------------------------------ consulta

    public static function find(string $uuid, int $customerId): ?array
    {
        if (!preg_match('/^[a-f0-9]{32}$/', $uuid)) {
            return null;
        }
        return DB::one('SELECT * FROM exams WHERE uuid = :u AND customer_id = :c AND deleted_at IS NULL', ['u' => $uuid, 'c' => $customerId]);
    }

    public static function history(int $customerId): array
    {
        return DB::all(
            'SELECT id, uuid, status, title, subject, grade, mode, versions, questions, created_at, edited_at FROM exams
             WHERE customer_id = :c AND deleted_at IS NULL ORDER BY created_at DESC, id DESC LIMIT 500',
            ['c' => $customerId]
        );
    }

    public static function pending(int $customerId): ?array
    {
        return DB::one('SELECT * FROM exams WHERE customer_id = :c AND status = "pending" AND deleted_at IS NULL ORDER BY id DESC LIMIT 1', ['c' => $customerId]);
    }

    public static function input(array $exam): array
    {
        $input = json_decode((string) ($exam['input_json'] ?? ''), true);
        return is_array($input) ? $input : [];
    }

    public static function content(array $exam): array
    {
        $content = json_decode((string) ($exam['content_json'] ?? ''), true);
        return is_array($content) ? $content + ['slots' => [], 'seed' => 1] : ['slots' => [], 'seed' => 1];
    }

    public static function headerOf(array $exam): array
    {
        $header = json_decode((string) ($exam['header_json'] ?? ''), true);
        return self::header(is_array($header) ? $header : [], self::input($exam));
    }

    /** Versiones armadas del examen. */
    public static function versions(array $exam): array
    {
        $input = self::input($exam);
        return ExamContent::build(self::content($exam), [
            'mode' => (string) $exam['mode'],
            'versions' => (int) $exam['versions'],
            'difficulty' => (string) ($input['dificultad'] ?? 'medio'),
        ]);
    }

    /** Borrado: oculta el examen. No devuelve cupo. */
    public static function delete(array $exam): void
    {
        DB::run('UPDATE exams SET deleted_at = :now WHERE id = :id AND deleted_at IS NULL', ['now' => DB::now(), 'id' => (int) $exam['id']]);
    }

    public static function fileName(array $exam): string
    {
        // Sin tildes (normalización Unicode: iconv translitera distinto en Windows y en Linux).
        $ascii = static function (string $s): string {
            $s = (string) (\Normalizer::normalize(str_replace(['ñ', 'Ñ'], ['n', 'N'], $s), \Normalizer::FORM_D) ?: $s);
            return trim((string) preg_replace('/[^A-Za-z0-9]+/', '-', (string) preg_replace('/\p{Mn}+/u', '', $s)), '-');
        };
        $subject = $ascii(ExamCatalog::subjects()[$exam['subject']] ?? 'Examen');
        $topic = mb_substr($ascii((string) $exam['title']), 0, 40);
        return 'Examen-' . $subject . ($topic !== '' ? '-' . $topic : '') . '-' . substr((string) $exam['created_at'], 0, 10) . '.pdf';
    }

    // ------------------------------------------------------------------ edición

    /**
     * Guarda la edición manual: textos, opciones y claves de cada variante, puntaje, preguntas quitadas y encabezado.
     * Una variante que no pase la validación conserva su versión anterior.
     * @return array{errors:int}
     */
    public static function saveEdit(array $exam, array $post): array
    {
        $content = self::content($exam);
        $input = self::input($exam);
        $options = (int) ($input['opciones'] ?? 4);
        $edits = is_array($post['q'] ?? null) ? $post['q'] : [];
        $points = is_array($post['points'] ?? null) ? $post['points'] : [];
        $remove = array_flip(array_filter((array) ($post['remove'] ?? []), 'is_string'));
        $errors = 0;
        $slots = [];
        foreach ($content['slots'] as $slot) {
            if (isset($remove[$slot['id']])) {
                continue;
            }
            foreach ((array) ($edits[$slot['id']] ?? []) as $v => $raw) {
                if (!is_array($raw) || !isset($slot['variants'][(int) $v])) {
                    continue;
                }
                $raw = self::editorFields($slot['type'], $raw);
                $q = ExamContent::question($slot['type'], $raw, $options);
                if ($q === null) {
                    $errors++;
                    continue;
                }
                $slot['variants'][(int) $v] = $q;
            }
            if (isset($points[$slot['id']]) && is_numeric($points[$slot['id']])) {
                $slot['points'] = max(0, min(100, round((float) $points[$slot['id']], 2)));
            }
            $slots[] = $slot;
        }
        if ($slots === []) {
            // Un examen no puede quedar vacío.
            $slots = $content['slots'];
            $errors++;
        }
        $content['slots'] = $slots;
        $header = isset($post['header']) ? self::sanitizeHeader($post) : (json_decode((string) $exam['header_json'], true) ?: []);
        DB::run('UPDATE exams SET content_json = :c, header_json = :h, questions = :n, edited_at = :now WHERE id = :id AND status = "done"', [
            'c' => json_encode($content, JSON_UNESCAPED_UNICODE),
            'h' => json_encode($header, JSON_UNESCAPED_UNICODE),
            'n' => count($slots),
            'now' => DB::now(),
            'id' => (int) $exam['id'],
        ]);
        return ['errors' => $errors];
    }

    /** Del formulario del editor (opciones con marca de correcta, parejas y palabras por línea) a campos internos. */
    private static function editorFields(string $type, array $raw): array
    {
        $out = $raw;
        if (in_array($type, ['unica', 'multiple'], true)) {
            $opts = is_array($raw['options'] ?? null) ? array_values($raw['options']) : [];
            $correct = array_map('intval', array_filter((array) ($raw['correct'] ?? []), 'is_numeric'));
            // Se descartan las opciones vacías y se reubican los índices correctos.
            $kept = [];
            $map = [];
            foreach ($opts as $i => $o) {
                if (is_string($o) && trim($o) !== '') {
                    $map[$i] = count($kept);
                    $kept[] = $o;
                }
            }
            $out['options'] = $kept;
            $out['correct'] = array_values(array_filter(array_map(fn ($i) => $map[$i] ?? null, $correct), fn ($i) => $i !== null));
        }
        if ($type === 'vf') {
            $out['tf'] = ($raw['tf'] ?? '') === '1';
        }
        foreach (['rubric', 'blanks', 'items'] as $k) {
            if (isset($raw[$k]) && is_string($raw[$k])) {
                $out[$k] = $raw[$k];
            }
        }
        return $out;
    }

    // ------------------------------------------------------------------ IA en el editor

    /**
     * Cupo de IA del examen: preguntas que aún puede escribir la IA y solicitudes restantes.
     * @return array{ok:bool, reason:?string, left:int, requests_left:int, unique:int, unique_max:int, variants:int}
     */
    public static function aiQuota(array $exam): array
    {
        $sub = !empty($exam['subscription_id']) ? DB::one('SELECT * FROM exam_subscriptions WHERE id = :id', ['id' => (int) $exam['subscription_id']]) : null;
        $content = self::content($exam);
        $variants = $exam['mode'] === 'distintas' ? (int) $exam['versions'] : 1;
        $max = $sub ? (int) $sub['max_questions'] : 0;
        $cap = $sub ? $max + (int) $sub['ai_extra'] : 0;
        $left = max(0, $cap - (int) $exam['ai_questions']);
        $requests = max(0, ExamCredits::EDIT_REQUESTS - (int) $exam['ai_requests']);
        $reason = null;
        if ($sub === null || $sub['revoked_at'] !== null) {
            $reason = 'no_plan';
        } elseif (!ExamCredits::summary((int) $exam['customer_id'])['has_active']) {
            $reason = 'expired';
        } elseif ($requests === 0) {
            $reason = 'requests';
        } elseif ($left < $variants) {
            $reason = 'quota';
        }
        return [
            'ok' => $reason === null && $exam['status'] === 'done',
            'reason' => $reason,
            'left' => $left,
            'requests_left' => $requests,
            'unique' => count($content['slots']) * $variants,
            'unique_max' => $max,
            'variants' => $variants,
        ];
    }

    /** Limpia una solicitud del editor. */
    public static function sanitizeAiRequest(array $post, array $input): array
    {
        $count = filter_var($post['count'] ?? 1, FILTER_VALIDATE_INT);
        return [
            'type' => self::pick($post['type'] ?? '', array_keys(ExamCatalog::TYPES), 'unica'),
            'count' => $count === false ? 1 : max(1, min(ExamCredits::EDIT_MAX, $count)),
            'difficulty' => self::pick($post['difficulty'] ?? '', ExamCatalog::DIFFICULTIES, (string) ($input['dificultad'] ?? 'medio')),
            'style' => self::pick($post['style'] ?? '', ExamCatalog::STYLES, (string) ($input['estilo'] ?? 'mixto')),
            'topic' => self::free($post['topic'] ?? '', self::MAX_TOPIC),
            'context' => self::free($post['context'] ?? '', self::MAX_REQUEST_CONTEXT),
        ];
    }

    /**
     * Preguntas adicionales ($slotId null) o reemplazo de una pregunta, con IA.
     * Cuenta preguntas × versiones contra el cupo del examen y una solicitud contra EDIT_REQUESTS.
     * @return array{added:int, error:?string}
     */
    public static function aiEdit(array $exam, array $req, ?string $slotId): array
    {
        $quota = self::aiQuota($exam);
        if (!$quota['ok']) {
            return ['added' => 0, 'error' => $quota['reason'] ?? 'quota'];
        }
        $content = self::content($exam);
        $input = self::input($exam);
        $index = null;
        if ($slotId !== null) {
            foreach ($content['slots'] as $i => $slot) {
                if ($slot['id'] === $slotId) {
                    $index = $i;
                }
            }
            if ($index === null) {
                return ['added' => 0, 'error' => 'missing'];
            }
            $req['count'] = 1;
        }
        $units = $req['count'] * $quota['variants'];
        if ($slotId === null && $quota['unique'] + $units > $quota['unique_max']) {
            return ['added' => 0, 'error' => 'unique'];
        }
        if (ExamCatalog::TYPES[$req['type']]['max'] <= (ExamContent::typeCounts($content['slots'])[$req['type']] ?? 0) - ($index !== null && $content['slots'][$index]['type'] === $req['type'] ? 1 : 0) + ($slotId === null ? $req['count'] - 1 : 0)) {
            return ['added' => 0, 'error' => 'type_max'];
        }
        // Reserva atómica del cupo (dos pestañas a la vez no lo pueden exceder).
        $sub = DB::one('SELECT max_questions, ai_extra FROM exam_subscriptions WHERE id = :id', ['id' => (int) $exam['subscription_id']]);
        $cap = (int) $sub['max_questions'] + (int) $sub['ai_extra'];
        $reserved = DB::run(
            'UPDATE exams SET ai_questions = ai_questions + :u, ai_requests = ai_requests + 1
             WHERE id = :id AND ai_questions + :u2 <= :cap AND ai_requests < :max',
            ['u' => $units, 'u2' => $units, 'cap' => $cap, 'max' => ExamCredits::EDIT_REQUESTS, 'id' => (int) $exam['id']]
        )->rowCount();
        if ($reserved !== 1) {
            return ['added' => 0, 'error' => 'quota'];
        }
        try {
            $result = ExamGenerator::extra($exam, $input, $content, $req, $slotId === null ? 'add' : 'replace');
        } catch (\Throwable $e) {
            // Si la IA ni respondió (error HTTP o de red, que no se factura), se devuelven las preguntas; la solicitud cuenta.
            if (str_contains($e->getMessage(), 'HTTP') || str_contains($e->getMessage(), 'conectar')) {
                DB::run('UPDATE exams SET ai_questions = ai_questions - :u WHERE id = :id AND ai_questions >= :u2', ['u' => $units, 'u2' => $units, 'id' => (int) $exam['id']]);
            }
            return ['added' => 0, 'error' => 'ai'];
        }
        // Se vuelve a leer el contenido por si el docente guardó cambios mientras tanto.
        $fresh = DB::one('SELECT * FROM exams WHERE id = :id', ['id' => (int) $exam['id']]) ?? $exam;
        $content = self::content($fresh);
        if ($slotId !== null) {
            $new = $result['slots'][0];
            $replaced = false;
            foreach ($content['slots'] as $i => $slot) {
                if ($slot['id'] === $slotId) {
                    $new['points'] = $slot['points'] ?? $new['points'];
                    $content['slots'][$i] = $new;
                    $replaced = true;
                }
            }
            if (!$replaced) {
                $content['slots'][] = $new;
            }
        } else {
            $content['slots'] = array_merge($content['slots'], $result['slots']);
        }
        DB::run(
            'UPDATE exams SET content_json = :c, questions = :n, prompt_tokens = prompt_tokens + :pt, output_tokens = output_tokens + :ot, edited_at = :now WHERE id = :id',
            [
                'c' => json_encode($content, JSON_UNESCAPED_UNICODE),
                'n' => count($content['slots']),
                'pt' => $result['prompt_tokens'],
                'ot' => $result['output_tokens'],
                'now' => DB::now(),
                'id' => (int) $exam['id'],
            ]
        );
        return ['added' => count($result['slots']), 'error' => null];
    }
}
