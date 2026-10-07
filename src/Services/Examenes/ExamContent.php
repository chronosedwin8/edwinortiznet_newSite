<?php

declare(strict_types=1);

namespace App\Services\Examenes;

/**
 * Contenido de un examen y armado de sus versiones.
 *
 * Se guarda un banco de «preguntas» (slots), cada una con sus variantes: en «versiones distintas» una variante
 * por versión; en «barajar», una sola. Las versiones no se guardan: build() las deriva de forma determinista
 * (misma semilla → mismo orden, mismas opciones y misma clave), así editar una pregunta actualiza todas.
 *
 * Formato interno de una variante: stem, options, correct (índices), tf, answer, solution, rubric, blanks,
 * pairs [{l, r}], items (en el orden correcto), words [{w, c}].
 */
final class ExamContent
{
    private const MAX_STEM = 4000;
    private const MAX_OPTION = 600;
    private const MAX_SOLUTION = 5000;
    private const LETTERS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

    /** Claves cortas de la IA → claves internas. */
    private const SHORT = ['q' => 'stem', 'o' => 'options', 'a' => 'correct', 'tf' => 'tf', 'r' => 'answer', 's' => 'solution', 'ru' => 'rubric', 'b' => 'blanks', 'p' => 'pairs', 'it' => 'items', 'w' => 'words'];

    // ------------------------------------------------------------------ limpieza

    public static function text(mixed $v, int $max = self::MAX_STEM): string
    {
        if (!is_scalar($v)) {
            return '';
        }
        $v = Tex::repair(str_replace("\r\n", "\n", (string) $v));
        $v = (string) preg_replace('/[^\P{C}\n]+/u', ' ', $v);
        $v = (string) preg_replace("/\n{3,}/", "\n\n", $v);
        return trim(mb_substr($v, 0, $max));
    }

    /** @return string[] */
    private static function lines(mixed $v, int $max = 40, int $len = self::MAX_OPTION): array
    {
        if (is_string($v)) {
            $v = explode("\n", str_replace("\r\n", "\n", $v));
        }
        if (!is_array($v)) {
            return [];
        }
        $out = [];
        foreach (array_slice(array_values($v), 0, $max) as $item) {
            $item = self::text($item, $len);
            $item = (string) preg_replace('/^\s*(?:[-•*·▸]|\d+[.)]|\(?[A-Ha-h][).]|\(?[A-Ha-h]\))\s+/u', '', $item);
            if ($item !== '') {
                $out[] = $item;
            }
        }
        return $out;
    }

    /**
     * Normaliza una variante (de la IA con claves cortas o del editor con claves internas). Null si no sirve.
     * @return array<string, mixed>|null
     */
    public static function question(string $type, array $raw, int $options = 4): ?array
    {
        foreach (self::SHORT as $short => $long) {
            if (array_key_exists($short, $raw) && !array_key_exists($long, $raw)) {
                $raw[$long] = $raw[$short];
            }
        }
        $q = ['stem' => self::text($raw['stem'] ?? '')];
        $solution = self::text($raw['solution'] ?? '', self::MAX_SOLUTION);
        $answer = self::text($raw['answer'] ?? '', 1500);
        $rubric = self::lines($raw['rubric'] ?? [], 8, 600);
        if ($q['stem'] === '') {
            return null;
        }
        switch ($type) {
            case 'unica':
            case 'multiple':
                $opts = self::lines($raw['options'] ?? [], 6);
                $opts = array_values(array_unique($opts));
                $correct = [];
                foreach ((array) ($raw['correct'] ?? []) as $i) {
                    if (is_numeric($i) && isset($opts[(int) $i])) {
                        $correct[] = (int) $i;
                    }
                }
                $correct = array_values(array_unique($correct));
                sort($correct);
                if (count($opts) < 2 || $correct === []) {
                    return null;
                }
                if ($type === 'unica') {
                    $correct = [$correct[0]];
                } elseif (count($opts) < 3) {
                    return null;
                }
                $q += ['options' => $opts, 'correct' => $correct, 'solution' => $solution];
                break;
            case 'vf':
                $tf = $raw['tf'] ?? null;
                if (is_string($tf)) {
                    $tf = in_array(mb_strtolower($tf), ['1', 'true', 'v', 'verdadero'], true) ? true : (in_array(mb_strtolower($tf), ['0', 'false', 'f', 'falso'], true) ? false : null);
                }
                if (!is_bool($tf)) {
                    return null;
                }
                $q += ['tf' => $tf, 'solution' => $solution];
                break;
            case 'corta':
                if ($answer === '') {
                    return null;
                }
                $q += ['answer' => $answer, 'solution' => $solution];
                break;
            case 'completar':
                $blanks = self::lines($raw['blanks'] ?? [], 8, 200);
                // Los espacios se marcan {{1}}, {{2}}…; si la IA usó ___, se numeran en orden.
                $n = 0;
                $stem = (string) preg_replace_callback('/\{\{\s*\d+\s*\}\}|_{3,}/', function () use (&$n): string {
                    $n++;
                    return '{{' . $n . '}}';
                }, $q['stem']);
                if ($n === 0 || count($blanks) < $n) {
                    return null;
                }
                $q = ['stem' => $stem, 'blanks' => array_slice($blanks, 0, $n), 'solution' => $solution];
                break;
            case 'relacionar':
                $pairs = [];
                foreach (self::pairsFrom($raw['pairs'] ?? []) as $p) {
                    $pairs[] = $p;
                }
                if (count($pairs) < 3) {
                    return null;
                }
                $q += ['pairs' => array_slice($pairs, 0, 8), 'solution' => $solution];
                break;
            case 'ordenar':
                $items = self::lines($raw['items'] ?? [], 8, 300);
                if (count($items) < 3) {
                    return null;
                }
                $q += ['items' => $items, 'solution' => $solution];
                break;
            case 'problema':
                if ($answer === '' && $solution === '') {
                    return null;
                }
                $q += ['answer' => $answer, 'solution' => $solution, 'rubric' => $rubric];
                break;
            case 'abierta':
            case 'larga':
                $q += ['answer' => $answer, 'rubric' => $rubric];
                break;
            case 'crucigrama':
            case 'sopa':
                $words = Puzzles::cleanWords(self::wordsFrom($raw['words'] ?? []), $type === 'crucigrama' ? 2 : 3, $type === 'crucigrama' ? 15 : 15);
                if (count($words) < 4) {
                    return null;
                }
                $q += ['words' => array_slice($words, 0, 16)];
                break;
            default:
                return null;
        }
        return $q;
    }

    /** Parejas desde la IA ([{l, r}]) o desde el editor (una por línea: «izquierda | derecha»). */
    private static function pairsFrom(mixed $raw): array
    {
        $out = [];
        if (is_string($raw)) {
            foreach (explode("\n", str_replace("\r\n", "\n", $raw)) as $line) {
                $parts = array_map('trim', explode('|', $line, 2));
                if (count($parts) === 2) {
                    $out[] = ['l' => $parts[0], 'r' => $parts[1]];
                }
            }
            $raw = $out;
            $out = [];
        }
        foreach ((array) $raw as $p) {
            if (!is_array($p)) {
                continue;
            }
            $l = self::text($p['l'] ?? '', 400);
            $r = self::text($p['r'] ?? '', 400);
            if ($l !== '' && $r !== '') {
                $out[] = ['l' => $l, 'r' => $r];
            }
        }
        return $out;
    }

    /** Palabras desde la IA ([{w, c}]) o desde el editor («PALABRA | pista» por línea). */
    private static function wordsFrom(mixed $raw): array
    {
        if (is_string($raw)) {
            $out = [];
            foreach (explode("\n", str_replace("\r\n", "\n", $raw)) as $line) {
                $parts = array_map('trim', explode('|', $line, 2));
                if ($parts[0] !== '') {
                    $out[] = ['w' => $parts[0], 'c' => $parts[1] ?? ''];
                }
            }
            return $out;
        }
        $out = [];
        foreach ((array) $raw as $p) {
            if (is_array($p)) {
                $out[] = ['w' => (string) ($p['w'] ?? ''), 'c' => self::text($p['c'] ?? '', 300)];
            }
        }
        return $out;
    }

    public static function newSlotId(): string
    {
        return 's' . bin2hex(random_bytes(4));
    }

    /**
     * Rescata de una respuesta JSON truncada (MAX_TOKENS) los elementos completos de "items".
     * Recorre el texto contando llaves fuera de las cadenas y corta después del último elemento cerrado.
     */
    public static function salvage(string $text): array
    {
        $depth = 0;
        $inString = false;
        $escape = false;
        $lastItemEnd = -1;
        $len = strlen($text);
        for ($i = 0; $i < $len; $i++) {
            $c = $text[$i];
            if ($inString) {
                if ($escape) {
                    $escape = false;
                } elseif ($c === '\\') {
                    $escape = true;
                } elseif ($c === '"') {
                    $inString = false;
                }
                continue;
            }
            if ($c === '"') {
                $inString = true;
            } elseif ($c === '{' || $c === '[') {
                $depth++;
            } elseif ($c === '}' || $c === ']') {
                $depth--;
                // Objeto 1 → arreglo items 2 → cada pregunta 3: al volver a 2 terminó una pregunta.
                if ($c === '}' && $depth === 2) {
                    $lastItemEnd = $i;
                }
            }
        }
        if ($lastItemEnd < 0) {
            return [];
        }
        $data = json_decode(substr($text, 0, $lastItemEnd + 1) . ']}', true);
        return is_array($data) ? $data : [];
    }

    /**
     * Respuesta de la IA → preguntas del banco. $want: tipos pedidos en orden.
     * Las variantes que falten se completan con la primera válida (marcadas «dup»).
     * @return array{slots: array<int, array>, invalid: int} slots con la posición pedida como clave
     */
    public static function fromAi(array $data, array $want, int $variants, int $options, array $skills = []): array
    {
        $items = is_array($data['items'] ?? null) ? array_values($data['items']) : [];
        $slots = [];
        $invalid = 0;
        foreach ($want as $i => $type) {
            $item = $items[$i] ?? null;
            if (!is_array($item)) {
                $invalid++;
                continue;
            }
            // Si la IA cambió el orden, se respeta su tipo siempre que sea uno de los pedidos.
            $t = is_string($item['t'] ?? null) && in_array($item['t'], $want, true) ? $item['t'] : $type;
            $good = [];
            foreach (array_slice(is_array($item['v'] ?? null) ? array_values($item['v']) : [], 0, $variants) as $raw) {
                $q = is_array($raw) ? self::question($t, $raw, $options) : null;
                if ($q !== null) {
                    $good[] = $q;
                }
            }
            if ($good === []) {
                $invalid++;
                continue;
            }
            while (count($good) < $variants) {
                $good[] = $good[0] + ['dup' => true];
            }
            $slots[$i] = [
                'id' => self::newSlotId(),
                'type' => $t,
                'skill' => self::text($item['h'] ?? ($skills[$i] ?? ''), 200),
                'points' => (float) ExamCatalog::TYPES[$t]['points'],
                'variants' => $good,
            ];
        }
        return ['slots' => $slots, 'invalid' => $invalid];
    }

    /** Preguntas del banco ordenadas por sección (el orden de los tipos en el catálogo). */
    public static function sorted(array $slots): array
    {
        $order = array_flip(array_keys(ExamCatalog::TYPES));
        $indexed = [];
        foreach (array_values($slots) as $i => $slot) {
            $indexed[] = [$order[$slot['type']] ?? 99, $i, $slot];
        }
        usort($indexed, fn ($a, $b) => [$a[0], $a[1]] <=> [$b[0], $b[1]]);
        return array_column($indexed, 2);
    }

    // ------------------------------------------------------------------ versiones

    /** Opciones que deben quedarse al final al barajar. */
    private static function pinned(string $option): bool
    {
        return (bool) preg_match('/^(todas|ninguna)\s+(de\s+)?(las|los)\s+anteriores|^(a|b|c)\s+y\s+(b|c|d)\b/iu', trim(strip_tags($option)));
    }

    /**
     * Arma las versiones del examen.
     * @param array{mode:string, versions:int, difficulty?:string} $meta
     * @return array<int, array{label:string, index:int, sections:array, questions:array, points:float}>
     */
    public static function build(array $content, array $meta): array
    {
        $seed = (int) ($content['seed'] ?? 1);
        $mode = $meta['mode'] === 'distintas' ? 'distintas' : 'barajar';
        $count = max(1, min(count(ExamCatalog::VERSION_LABELS), (int) $meta['versions']));
        $slots = self::sorted($content['slots'] ?? []);
        $versions = [];
        for ($v = 0; $v < $count; $v++) {
            // Agrupa por sección; en «barajar» las versiones B, C… cambian el orden dentro de cada sección.
            $bySection = [];
            foreach ($slots as $slot) {
                $bySection[$slot['type']][] = $slot;
            }
            $n = 0;
            $sections = [];
            $flat = [];
            $total = 0.0;
            foreach ($bySection as $type => $list) {
                if ($mode === 'barajar' && $v > 0) {
                    $list = (new Rng(Rng::seed($seed, 'order', $type, $v)))->shuffle($list);
                }
                $questions = [];
                foreach ($list as $slot) {
                    $variant = $slot['variants'][$mode === 'distintas' ? min($v, count($slot['variants']) - 1) : 0] ?? null;
                    if (!is_array($variant)) {
                        continue;
                    }
                    $n++;
                    $q = self::present($slot, $variant, $v, $seed, $meta) + ['n' => $n];
                    $questions[] = $q;
                    $flat[] = $q;
                    $total += $q['points'];
                }
                if ($questions !== []) {
                    $sections[] = ['type' => $type, 'questions' => $questions];
                }
            }
            $versions[] = ['label' => ExamCatalog::VERSION_LABELS[$v], 'index' => $v, 'sections' => $sections, 'questions' => $flat, 'points' => $total];
        }
        return $versions;
    }

    /** Una pregunta lista para mostrar en una versión: opciones barajadas y su clave recalculada. */
    private static function present(array $slot, array $variant, int $v, int $seed, array $meta): array
    {
        $type = $slot['type'];
        $q = $variant + [
            'slot' => $slot['id'],
            'type' => $type,
            'points' => (float) ($slot['points'] ?? ExamCatalog::TYPES[$type]['points']),
            'skill' => (string) ($slot['skill'] ?? ''),
        ];
        $rng = new Rng(Rng::seed($seed, $slot['id'], $v));
        switch ($type) {
            case 'unica':
            case 'multiple':
                $free = [];
                $fixed = [];
                foreach ($variant['options'] as $i => $opt) {
                    if (self::pinned($opt)) {
                        $fixed[] = $i;
                    } else {
                        $free[] = $i;
                    }
                }
                $perm = array_merge($rng->shuffle($free), $fixed);
                $q['shown'] = array_map(fn ($i) => $variant['options'][$i], $perm);
                $q['key'] = array_values(array_map(fn ($i) => array_search($i, $perm, true), $variant['correct']));
                sort($q['key']);
                break;
            case 'relacionar':
                $pairs = $variant['pairs'];
                $left = range(0, count($pairs) - 1);
                $right = $rng->shuffle($left);
                // Evita que la columna B quede en el mismo orden que la A.
                if ($right === $left && count($left) > 1) {
                    $right = array_merge(array_slice($right, 1), [$right[0]]);
                }
                $q['left'] = array_map(fn ($i) => $pairs[$i]['l'], $left);
                $q['right'] = array_map(fn ($i) => $pairs[$i]['r'], $right);
                $q['key'] = array_map(fn ($i) => self::LETTERS[array_search($i, $right, true)] ?? '?', $left);
                break;
            case 'ordenar':
                $idx = range(0, count($variant['items']) - 1);
                $shown = $rng->shuffle($idx);
                if ($shown === $idx) {
                    $shown = array_reverse($idx);
                }
                $q['shown'] = array_map(fn ($i) => $variant['items'][$i], $shown);
                // Clave: letras de los elementos mostrados en el orden correcto.
                $q['key'] = array_map(fn ($i) => self::letter((int) array_search($i, $shown, true), true), $idx);
                break;
            case 'crucigrama':
                $q['puzzle'] = Puzzles::crossword($variant['words'], Rng::seed($seed, $slot['id'], 'cw', $v));
                break;
            case 'sopa':
                $q['puzzle'] = Puzzles::wordSearch($variant['words'], (string) ($meta['difficulty'] ?? 'medio'), Rng::seed($seed, $slot['id'], 'ws', $v));
                break;
        }
        return $q;
    }

    public static function letter(int $i, bool $lower = false): string
    {
        $l = self::LETTERS[$i] ?? (string) ($i + 1);
        return $lower ? strtolower($l) : $l;
    }

    /**
     * Clave de respuestas de una versión (texto sin LaTeX convertido: lo pinta la plantilla).
     * @return array<int, array{n:int, type:string, key:string, math:bool}>
     */
    public static function answerKey(array $version): array
    {
        $rows = [];
        foreach ($version['questions'] as $q) {
            $key = match ($q['type']) {
                'unica', 'multiple' => implode(', ', array_map(fn ($i) => self::letter((int) $i), $q['key'])),
                'vf' => $q['tf'] ? t('examenes.pdf.true') : t('examenes.pdf.false'),
                'corta' => $q['answer'],
                'completar' => implode('; ', array_map(fn ($a, $i) => '(' . ($i + 1) . ') ' . $a, $q['blanks'], array_keys($q['blanks']))),
                'relacionar' => implode(', ', array_map(fn ($l, $i) => ($i + 1) . '-' . $l, $q['key'], array_keys($q['key']))),
                'ordenar' => implode(' → ', $q['key']),
                'problema' => $q['answer'] !== '' ? $q['answer'] : t('examenes.pdf.see_solution'),
                'abierta', 'larga' => t('examenes.pdf.see_rubric'),
                'crucigrama', 'sopa' => t('examenes.pdf.see_puzzle'),
                default => '',
            };
            $rows[] = ['n' => $q['n'], 'type' => $q['type'], 'key' => (string) $key];
        }
        return $rows;
    }

    /**
     * Equivalencias en el modo barajar: número de cada pregunta del banco en cada versión.
     * @return array<string, array<int, int>> slot => [versión => número]
     */
    public static function equivalences(array $versions): array
    {
        $map = [];
        foreach ($versions as $version) {
            foreach ($version['questions'] as $q) {
                $map[$q['slot']][$version['index']] = $q['n'];
            }
        }
        return $map;
    }

    /** Todos los textos con posibles fórmulas (para convertirlas de una vez). */
    public static function texts(array $versions): array
    {
        $texts = [];
        $add = static function (mixed $v) use (&$texts, &$add): void {
            if (is_string($v)) {
                if (str_contains($v, '$') || str_contains($v, '\\(') || str_contains($v, '\\[')) {
                    $texts[$v] = true;
                }
            } elseif (is_array($v)) {
                foreach ($v as $k => $item) {
                    if ($k !== 'puzzle') {
                        $add($item);
                    }
                }
            }
        };
        foreach ($versions as $version) {
            $add($version['questions']);
        }
        return array_keys($texts);
    }

    /** Total de preguntas por tipo en el banco (cuenta preguntas, no variantes). */
    public static function typeCounts(array $slots): array
    {
        $out = [];
        foreach ($slots as $slot) {
            $out[$slot['type']] = ($out[$slot['type']] ?? 0) + 1;
        }
        return $out;
    }
}
