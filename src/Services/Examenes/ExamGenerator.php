<?php

declare(strict_types=1);

namespace App\Services\Examenes;

use App\Core\DB;
use App\Core\Logger;
use App\Services\Ai\Gemini;
use App\Services\Ai\GeminiException;
use RuntimeException;

/**
 * Escribe las preguntas con Gemini. Un examen se parte en bloques de hasta CHUNK_UNITS unidades
 * (pregunta × versión) que se piden en paralelo; si hay más de un bloque, antes se pide una tabla de
 * especificaciones barata (una habilidad por pregunta) para que los bloques no se repitan. Cada llamada lleva
 * un tope de salida calculado con los topes por tipo (ExamCatalog::TYPES), así el costo máximo es conocido.
 * Si una respuesta llega truncada se rescatan sus preguntas completas; las que falten se piden en un solo
 * reintento por examen.
 */
final class ExamGenerator
{
    /** Proporción mínima de preguntas válidas para dar el examen por bueno. */
    private const MIN_OK = 0.85;

    /** Tipos de las preguntas pedidas, en el orden de las secciones. */
    public static function wanted(array $types): array
    {
        $out = [];
        foreach (array_keys(ExamCatalog::TYPES) as $type) {
            for ($i = 0; $i < (int) ($types[$type] ?? 0); $i++) {
                $out[] = $type;
            }
        }
        return $out;
    }

    /** Tope de salida de una llamada: suma de los topes por tipo × versiones + razonamiento + holgura. */
    public static function outputCap(array $types, int $variants, int $thinking): int
    {
        $sum = 0;
        foreach ($types as $type) {
            $sum += ExamCredits::unitCap($type) * $variants;
        }
        return $sum + $thinking + ExamCredits::OUTPUT_MARGIN;
    }

    /** Agrupa las preguntas en bloques de hasta CHUNK_UNITS unidades. @return array<int, int[]> índices */
    public static function chunks(array $indexes, int $variants): array
    {
        $chunks = [];
        $current = [];
        foreach ($indexes as $i) {
            if ($current !== [] && (count($current) + 1) * $variants > ExamCredits::CHUNK_UNITS) {
                $chunks[] = $current;
                $current = [];
            }
            $current[] = $i;
        }
        if ($current !== []) {
            $chunks[] = $current;
        }
        return $chunks;
    }

    private static function log(int $customerId, ?int $examId, string $kind, int $questions, int $in, int $out, bool $ok): void
    {
        DB::insert('exam_ai_calls', [
            'customer_id' => $customerId,
            'exam_id' => $examId,
            'kind' => $kind,
            'questions' => $questions,
            'model' => ExamPrompt::model(),
            'prompt_tokens' => $in,
            'output_tokens' => $out,
            'ok' => $ok ? 1 : 0,
        ]);
    }

    /**
     * Convierte el resultado de una llamada (o su error) en preguntas, rescatando lo completo si vino truncada.
     * @param array<int, string> $want tipos pedidos (claves 0..n-1)
     * @return array{slots: array<int, array>, in: int, out: int, ok: bool}
     */
    private static function collect(mixed $res, array $want, int $variants, int $options, array $skills): array
    {
        if ($res instanceof GeminiException && $res->billed) {
            $data = $res->finish === 'MAX_TOKENS' ? ExamContent::salvage($res->text) : [];
            $parsed = $data !== [] ? ExamContent::fromAi($data, $want, $variants, $options, $skills) : ['slots' => []];
            return ['slots' => $parsed['slots'], 'in' => $res->promptTokens, 'out' => $res->outputTokens, 'ok' => false];
        }
        if (!is_array($res)) {
            return ['slots' => [], 'in' => 0, 'out' => 0, 'ok' => false];
        }
        $parsed = ExamContent::fromAi($res['data'], $want, $variants, $options, $skills);
        return ['slots' => $parsed['slots'], 'in' => $res['prompt_tokens'], 'out' => $res['output_tokens'], 'ok' => $parsed['invalid'] === 0];
    }

    /**
     * Genera todas las preguntas de un examen.
     * @return array{slots: array, prompt_tokens: int, output_tokens: int, model: string, missing: int}
     */
    public static function generate(array $exam, array $input): array
    {
        $examId = (int) $exam['id'];
        $customerId = (int) $exam['customer_id'];
        $variants = $input['modo'] === 'distintas' ? (int) $input['versiones'] : 1;
        $options = (int) $input['opciones'];
        $wanted = self::wanted($input['tipos']);
        if ($wanted === []) {
            throw new RuntimeException('El examen no tiene preguntas.');
        }
        $level = ExamCatalog::mathLevel($input['materia']);
        $thinking = $level === 'full' ? ExamCredits::THINKING_STEM : ($level === 'light' ? ExamCredits::THINKING_LIGHT : 0);
        $system = ExamPrompt::system($level);
        $model = ExamPrompt::model();
        $chunks = self::chunks(array_keys($wanted), $variants);
        $tokensIn = 0;
        $tokensOut = 0;

        // Tabla de especificaciones (solo si hay varios bloques): una habilidad por pregunta, sin repetir.
        $skills = [];
        if (count($chunks) > 1) {
            try {
                $plan = Gemini::generateJson(
                    $system, ExamPrompt::planUser($input, array_count_values($wanted)), ExamPrompt::planSchema(), 0.5,
                    count($wanted) * ExamCredits::PLAN_TOKENS + ExamCredits::OUTPUT_MARGIN, $model, 0
                );
                $tokensIn += $plan['prompt_tokens'];
                $tokensOut += $plan['output_tokens'];
                self::log($customerId, $examId, 'plan', count($wanted), $plan['prompt_tokens'], $plan['output_tokens'], true);
                $byType = [];
                foreach (is_array($plan['data']['plan'] ?? null) ? $plan['data']['plan'] : [] as $row) {
                    if (is_array($row) && isset($row['t'], $row['h']) && is_string($row['h'])) {
                        $byType[(string) $row['t']][] = ExamContent::text($row['h'], 200);
                    }
                }
                foreach ($wanted as $i => $type) {
                    $skills[$i] = array_shift($byType[$type]) ?? '';
                }
            } catch (\Throwable $e) {
                $billed = $e instanceof GeminiException && $e->billed;
                $tokensIn += $billed ? $e->promptTokens : 0;
                $tokensOut += $billed ? $e->outputTokens : 0;
                self::log($customerId, $examId, 'plan', count($wanted), $billed ? $e->promptTokens : 0, $billed ? $e->outputTokens : 0, false);
                Logger::warning('Examen: falló la tabla de especificaciones; se sigue sin ella', ['exam' => $examId, 'error' => $e->getMessage()]);
            }
            DB::run('UPDATE exams SET progress = 15 WHERE id = :id', ['id' => $examId]);
        }

        $request = static function (array $idx) use ($input, $wanted, $variants, $skills, $system, $thinking, $model): array {
            $slots = array_map(fn ($i) => ['type' => $wanted[$i], 'skill' => $skills[$i] ?? ''], $idx);
            return [
                'system' => $system,
                'user' => ExamPrompt::user($input, $slots, $variants),
                'schema' => ExamPrompt::schema(),
                'temperature' => 0.7,
                'maxTokens' => self::outputCap(array_column($slots, 'type'), $variants, $thinking),
                'model' => $model,
                'thinking' => $thinking,
            ];
        };
        $run = function (array $groups, string $kind) use ($request, $wanted, $variants, $options, $skills, $customerId, $examId, &$tokensIn, &$tokensOut): array {
            $got = [];
            $results = Gemini::generateJsonMany(array_map($request, $groups), 4);
            foreach ($groups as $g => $idx) {
                $want = array_map(fn ($i) => $wanted[$i], $idx);
                $r = self::collect($results[$g] ?? null, $want, $variants, $options, array_map(fn ($i) => $skills[$i] ?? '', $idx));
                $tokensIn += $r['in'];
                $tokensOut += $r['out'];
                self::log($customerId, $examId, $kind, count($idx) * $variants, $r['in'], $r['out'], $r['ok']);
                foreach ($r['slots'] as $k => $slot) {
                    $got[$idx[$k]] = $slot;
                }
            }
            return $got;
        };
        $got = $run($chunks, 'gen');

        // Un solo reintento por examen (acota el peor caso): hasta RETRY_UNITS unidades de las preguntas que faltan.
        $missing = array_values(array_diff(array_keys($wanted), array_keys($got)));
        if ($missing !== []) {
            DB::run('UPDATE exams SET progress = 70 WHERE id = :id', ['id' => $examId]);
            $retry = array_slice($missing, 0, max(1, intdiv(ExamCredits::RETRY_UNITS, $variants)));
            $got += $run([$retry], 'retry');
        }
        ksort($got);
        if (count($got) < (int) ceil(count($wanted) * self::MIN_OK)) {
            throw new RuntimeException('La IA no entregó suficientes preguntas válidas (' . count($got) . ' de ' . count($wanted) . ').');
        }
        return ['slots' => array_values($got), 'prompt_tokens' => $tokensIn, 'output_tokens' => $tokensOut, 'model' => $model, 'missing' => count($wanted) - count($got)];
    }

    /**
     * Preguntas nuevas desde el editor (adicionales o de reemplazo), con las variables que elige el docente.
     * @param array{type:string, count:int, difficulty:string, style:string, topic:string, context:string} $req
     * @return array{slots: array, prompt_tokens: int, output_tokens: int}
     */
    public static function extra(array $exam, array $input, array $content, array $req, string $kind): array
    {
        $variants = $input['modo'] === 'distintas' ? (int) $input['versiones'] : 1;
        $level = ExamCatalog::mathLevel($input['materia']);
        $thinking = $level === 'full' ? ExamCredits::THINKING_EDIT : 0;
        $want = array_fill(0, $req['count'], $req['type']);
        $avoid = [];
        foreach (ExamContent::sorted($content['slots'] ?? []) as $slot) {
            $stem = (string) ($slot['variants'][0]['stem'] ?? '');
            if ($stem !== '') {
                $avoid[] = mb_substr((string) preg_replace('/\s+/u', ' ', $stem), 0, 90);
            }
        }
        $user = ExamPrompt::user($input, array_map(fn ($t) => ['type' => $t], $want), $variants, [
            'topic' => $req['topic'],
            'difficulty' => $req['difficulty'],
            'style' => $req['style'],
            'context' => $req['context'],
            'avoid' => array_slice($avoid, 0, 30),
        ]);
        $units = $req['count'] * $variants;
        try {
            $res = Gemini::generateJson(
                ExamPrompt::system($level), $user, ExamPrompt::schema(), 0.8,
                self::outputCap($want, $variants, $thinking), ExamPrompt::model(), $thinking
            );
        } catch (\Throwable $e) {
            $res = $e;
        }
        $r = self::collect($res, $want, $variants, (int) $input['opciones'], []);
        self::log((int) $exam['customer_id'], (int) $exam['id'], $kind, $units, $r['in'], $r['out'], $r['slots'] !== []);
        if ($r['slots'] === []) {
            $billed = $res instanceof GeminiException ? $res->billed : is_array($res);
            throw new RuntimeException($billed ? 'La IA no entregó preguntas válidas.' : 'El servicio de IA no respondió (HTTP).');
        }
        return ['slots' => array_values($r['slots']), 'prompt_tokens' => $r['in'], 'output_tokens' => $r['out']];
    }
}
