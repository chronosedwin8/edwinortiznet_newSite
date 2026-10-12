<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;
use App\Core\DB;
use App\Core\Request;

/**
 * Encuestas cortas dentro de los artículos. Cada una es un archivo resources/polls/<clave>.php con
 * ['es' => ['title', 'questions' => [['q' => texto, 'options' => [...]]]], 'en' => …] (mismo número de
 * preguntas y opciones en los dos idiomas: los resultados se suman). Se insertan con {{encuesta:clave}}.
 *
 * Privacidad: no se guardan IP ni datos personales; el visitante es el HMAC de una cookie aleatoria
 * (la misma cookie funcional de las reacciones). Es una muestra autoseleccionada: no representa a nadie.
 */
final class Polls
{
    public const MAX_QUESTIONS = 5;

    /** @return array{title:string, intro?:string, questions: array<int, array{q:string, options:string[]}>}|null */
    public static function definition(string $key, string $locale): ?array
    {
        if (!preg_match('/^[a-z0-9][a-z0-9-]{0,79}$/', $key)) {
            return null;
        }
        $file = Config::root('resources/polls/' . $key . '.php');
        if (!is_file($file)) {
            return null;
        }
        $all = require $file;
        $def = $all[$locale] ?? $all['es'] ?? null;
        return is_array($def) ? $def : null;
    }

    public static function visitorHash(string $visitorId, string $key): string
    {
        return hash_hmac('sha256', 'poll|' . $key . '|' . $visitorId, (string) Config::get('APP_KEY', 'dev-key'));
    }

    /**
     * Guarda las respuestas ({índice de pregunta => índice de opción}); ignora lo inválido y devuelve cuántas guardó.
     * @param array<int|string, mixed> $answers
     */
    public static function record(string $key, string $visitorHash, array $answers, string $locale): int
    {
        $def = self::definition($key, 'es');
        if ($def === null) {
            return 0;
        }
        $saved = 0;
        foreach ($answers as $q => $a) {
            if (!is_numeric($q) || !is_numeric($a)) {
                continue;
            }
            $q = (int) $q;
            $a = (int) $a;
            if (!isset($def['questions'][$q]['options'][$a])) {
                continue;
            }
            DB::run(
                'INSERT INTO poll_votes (poll_key, visitor, question, answer, locale) VALUES (?, ?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE answer = ?, locale = ?, updated_at = CURRENT_TIMESTAMP',
                [$key, $visitorHash, $q, $a, $locale, $a, $locale]
            );
            $saved++;
        }
        return $saved;
    }

    /**
     * Resultados: por pregunta, el conteo de cada opción y el total; y cuántas personas respondieron al menos una.
     * @return array{people:int, questions: array<int, array{total:int, counts:int[]}>}
     */
    public static function results(string $key): array
    {
        $def = self::definition($key, 'es');
        $out = ['people' => 0, 'questions' => []];
        if ($def === null) {
            return $out;
        }
        foreach ($def['questions'] as $i => $question) {
            $out['questions'][$i] = ['total' => 0, 'counts' => array_fill(0, count($question['options']), 0)];
        }
        foreach (DB::all('SELECT question, answer, COUNT(*) AS n FROM poll_votes WHERE poll_key = :k GROUP BY question, answer', ['k' => $key]) as $row) {
            $q = (int) $row['question'];
            $a = (int) $row['answer'];
            if (isset($out['questions'][$q]['counts'][$a])) {
                $out['questions'][$q]['counts'][$a] = (int) $row['n'];
                $out['questions'][$q]['total'] += (int) $row['n'];
            }
        }
        $out['people'] = (int) DB::value('SELECT COUNT(DISTINCT visitor) FROM poll_votes WHERE poll_key = :k', ['k' => $key]);
        return $out;
    }

    /**
     * Cruce por segmento: para la pregunta de segmentación de la encuesta (clave `segment`), cuántas personas hay en cada
     * opción y cómo respondieron las demás preguntas. Es solo para quien administra el sitio (`polls:results`).
     * @return array<int, array{people:int, questions: array<int, int[]>}> opción del segmento => datos
     */
    public static function segments(string $key): array
    {
        $def = self::definition($key, 'es');
        $seg = $def['segment'] ?? null;
        if ($def === null || $seg === null) {
            return [];
        }
        $out = [];
        foreach ($def['questions'][$seg]['options'] as $j => $_) {
            $out[$j] = ['people' => 0, 'questions' => []];
            foreach ($def['questions'] as $i => $q) {
                if ($i !== $seg) {
                    $out[$j]['questions'][$i] = array_fill(0, count($q['options']), 0);
                }
            }
        }
        foreach (DB::all('SELECT answer, COUNT(*) AS n FROM poll_votes WHERE poll_key = :k AND question = :q GROUP BY answer', ['k' => $key, 'q' => $seg]) as $row) {
            if (isset($out[(int) $row['answer']])) {
                $out[(int) $row['answer']]['people'] = (int) $row['n'];
            }
        }
        $rows = DB::all(
            'SELECT s.answer AS seg, v.question AS q, v.answer AS a, COUNT(*) AS n FROM poll_votes s
             JOIN poll_votes v ON v.poll_key = s.poll_key AND v.visitor = s.visitor AND v.question <> s.question
             WHERE s.poll_key = :k AND s.question = :q GROUP BY s.answer, v.question, v.answer',
            ['k' => $key, 'q' => $seg]
        );
        foreach ($rows as $row) {
            if (isset($out[(int) $row['seg']]['questions'][(int) $row['q']][(int) $row['a']])) {
                $out[(int) $row['seg']]['questions'][(int) $row['q']][(int) $row['a']] = (int) $row['n'];
            }
        }
        return $out;
    }

    /** Respuestas del visitante: {pregunta => opción}. @return array<int,int> */
    public static function mine(string $key, string $visitorHash): array
    {
        $out = [];
        foreach (DB::all('SELECT question, answer FROM poll_votes WHERE poll_key = :k AND visitor = :v', ['k' => $key, 'v' => $visitorHash]) as $row) {
            $out[(int) $row['question']] = (int) $row['answer'];
        }
        return $out;
    }

    public static function visitorId(Request $request): ?string
    {
        return Reactions::visitorId($request);
    }
}
