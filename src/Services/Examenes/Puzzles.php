<?php

declare(strict_types=1);

namespace App\Services\Examenes;

/**
 * Crucigramas y sopas de letras armados en PHP a partir de las palabras y pistas que propone la IA.
 * Deterministas: la misma semilla produce la misma rejilla (vista previa, PDF y solucionario coinciden).
 */
final class Puzzles
{
    public const CROSSWORD_MAX = 17;
    private const ATTEMPTS = 40;

    /** Mayúsculas sin tildes ni signos (la Ñ se conserva). */
    public static function normalizeWord(string $word): string
    {
        $word = mb_strtoupper(trim($word), 'UTF-8');
        $word = strtr($word, ['Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'Ü' => 'U', 'À' => 'A', 'È' => 'E', 'Ì' => 'I', 'Ò' => 'O', 'Ù' => 'U', 'Ç' => 'C']);
        return (string) preg_replace('/[^A-ZÑ]/u', '', $word);
    }

    /** @return string[] letras de la palabra (la Ñ es una sola casilla) */
    public static function letters(string $word): array
    {
        return preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY) ?: [];
    }

    /**
     * Palabras válidas y únicas con su pista.
     * @param array<int, array{w?:string, c?:string}> $words
     * @return array<int, array{w:string, c:string}>
     */
    public static function cleanWords(array $words, int $min = 3, int $max = 14): array
    {
        $out = [];
        $seen = [];
        foreach ($words as $item) {
            if (!is_array($item)) {
                continue;
            }
            $w = self::normalizeWord((string) ($item['w'] ?? ''));
            $n = mb_strlen($w);
            if ($n < $min || $n > $max || isset($seen[$w])) {
                continue;
            }
            $seen[$w] = true;
            $out[] = ['w' => $w, 'c' => trim((string) ($item['c'] ?? ''))];
        }
        return $out;
    }

    // ------------------------------------------------------------------ crucigrama

    /**
     * Arma el crucigrama: varias pruebas aleatorias con colocación voraz por cruces; gana la que ubica más
     * palabras, con más cruces y en menos área. Solo se aceptan cruces válidos (sin letras pegadas).
     * @return array{width:int, height:int, cells:array<int, array<int, ?string>>, numbers:array<string,int>, across:array, down:array, unplaced:array}
     */
    public static function crossword(array $words, int $seed): array
    {
        $words = self::cleanWords($words, 2, self::CROSSWORD_MAX - 2);
        $rng = new Rng($seed);
        $best = null;
        for ($attempt = 0; $attempt < self::ATTEMPTS && $words !== []; $attempt++) {
            $order = $words;
            usort($order, fn ($a, $b) => mb_strlen($b['w']) <=> mb_strlen($a['w']));
            if ($attempt > 0) {
                // La primera prueba va de la más larga a la más corta; las demás barajan (la más larga sigue primero).
                $first = array_shift($order);
                $order = array_merge([$first], $rng->shuffle($order));
            }
            $result = self::placeAll($order, $rng);
            $score = [count($result['placed']), $result['crossings'], -$result['area']];
            if ($best === null || $score > $best['score']) {
                $best = $result + ['score' => $score];
            }
            if (count($result['placed']) === count($words) && $attempt >= 12) {
                break;
            }
        }
        if ($best === null) {
            return ['width' => 0, 'height' => 0, 'cells' => [], 'numbers' => [], 'across' => [], 'down' => [], 'unplaced' => array_column($words, 'w')];
        }
        return self::finishCrossword($best['placed'], $best['unplaced']);
    }

    /** @return array{placed:array, unplaced:array, crossings:int, area:int} */
    private static function placeAll(array $order, Rng $rng): array
    {
        $grid = [];
        $used = [];
        $placed = [];
        $crossings = 0;
        $pending = $order;
        $first = array_shift($pending);
        $letters = self::letters($first['w']);
        foreach ($letters as $i => $ch) {
            $grid["$i,0"] = $ch;
            $used["$i,0"]["across"] = true;
        }
        $placed[] = ['w' => $first['w'], 'c' => $first['c'], 'x' => 0, 'y' => 0, 'dir' => 'across'];
        // Dos pasadas: lo que no cupo al principio puede cruzarse con palabras que llegaron después.
        for ($pass = 0; $pass < 2 && $pending !== []; $pass++) {
            $left = [];
            foreach ($pending as $word) {
                $spot = self::bestSpot($grid, $used, $word['w'], $rng);
                if ($spot === null) {
                    $left[] = $word;
                    continue;
                }
                foreach (self::letters($word['w']) as $i => $ch) {
                    $x = $spot['x'] + ($spot['dir'] === 'across' ? $i : 0);
                    $y = $spot['y'] + ($spot['dir'] === 'down' ? $i : 0);
                    $grid["$x,$y"] = $ch;
                    $used["$x,$y"][$spot['dir']] = true;
                }
                $crossings += $spot['cross'];
                $placed[] = ['w' => $word['w'], 'c' => $word['c'], 'x' => $spot['x'], 'y' => $spot['y'], 'dir' => $spot['dir']];
            }
            $pending = $left;
        }
        [$minX, $minY, $maxX, $maxY] = self::bounds($grid);
        return ['placed' => $placed, 'unplaced' => array_column($pending, 'w'), 'crossings' => $crossings, 'area' => ($maxX - $minX + 1) * ($maxY - $minY + 1), 'grid' => $grid];
    }

    private static function bounds(array $grid): array
    {
        $xs = [];
        $ys = [];
        foreach (array_keys($grid) as $key) {
            [$x, $y] = array_map('intval', explode(',', (string) $key));
            $xs[] = $x;
            $ys[] = $y;
        }
        return $xs ? [min($xs), min($ys), max($xs), max($ys)] : [0, 0, 0, 0];
    }

    /** Mejor posición (más cruces, menor área; desempate aleatorio) o null. */
    private static function bestSpot(array $grid, array $used, string $word, Rng $rng): ?array
    {
        $letters = self::letters($word);
        $len = count($letters);
        [$minX, $minY, $maxX, $maxY] = self::bounds($grid);
        $candidates = [];
        foreach ($grid as $key => $ch) {
            [$gx, $gy] = array_map('intval', explode(',', (string) $key));
            foreach ($letters as $i => $letter) {
                if ($letter !== $ch) {
                    continue;
                }
                foreach (['across', 'down'] as $dir) {
                    $x = $dir === 'across' ? $gx - $i : $gx;
                    $y = $dir === 'down' ? $gy - $i : $gy;
                    $cross = self::fits($grid, $used, $letters, $x, $y, $dir);
                    if ($cross < 1) {
                        continue;
                    }
                    $nx0 = min($minX, $x);
                    $ny0 = min($minY, $y);
                    $nx1 = max($maxX, $dir === 'across' ? $x + $len - 1 : $x);
                    $ny1 = max($maxY, $dir === 'down' ? $y + $len - 1 : $y);
                    $w = $nx1 - $nx0 + 1;
                    $h = $ny1 - $ny0 + 1;
                    if ($w > self::CROSSWORD_MAX || $h > self::CROSSWORD_MAX) {
                        continue;
                    }
                    // Preferir rejillas cuadradas y compactas.
                    $candidates["$x,$y,$dir"] = ['x' => $x, 'y' => $y, 'dir' => $dir, 'cross' => $cross, 'score' => $cross * 100 - $w * $h - abs($w - $h) * 3 + $rng->int(0, 9)];
                }
            }
        }
        if ($candidates === []) {
            return null;
        }
        usort($candidates, fn ($a, $b) => $b['score'] <=> $a['score']);
        return $candidates[0];
    }

    /** Número de cruces si la palabra cabe en (x, y), o 0 si choca o queda pegada a otra. */
    private static function fits(array $grid, array $used, array $letters, int $x, int $y, string $dir): int
    {
        $dx = $dir === 'across' ? 1 : 0;
        $dy = $dir === 'down' ? 1 : 0;
        $len = count($letters);
        // Antes y después de la palabra debe haber una casilla vacía.
        if (isset($grid[($x - $dx) . ',' . ($y - $dy)]) || isset($grid[($x + $dx * $len) . ',' . ($y + $dy * $len)])) {
            return 0;
        }
        $cross = 0;
        foreach ($letters as $i => $letter) {
            $cx = $x + $dx * $i;
            $cy = $y + $dy * $i;
            $here = $grid["$cx,$cy"] ?? null;
            if ($here !== null) {
                // Solo se cruza con palabras de la otra dirección.
                if ($here !== $letter || !empty($used["$cx,$cy"][$dir])) {
                    return 0;
                }
                $cross++;
                continue;
            }
            // Casilla nueva: sus vecinas laterales deben estar vacías (si no, se formarían palabras falsas).
            if ($dir === 'across' && (isset($grid["$cx," . ($cy - 1)]) || isset($grid["$cx," . ($cy + 1)]))) {
                return 0;
            }
            if ($dir === 'down' && (isset($grid[($cx - 1) . ",$cy"]) || isset($grid[($cx + 1) . ",$cy"]))) {
                return 0;
            }
        }
        // No puede cubrir por completo una palabra ya colocada en la misma dirección.
        return $cross === $len ? 0 : $cross;
    }

    private static function finishCrossword(array $placed, array $unplaced): array
    {
        $grid = [];
        foreach ($placed as $p) {
            foreach (self::letters($p['w']) as $i => $ch) {
                $grid[($p['x'] + ($p['dir'] === 'across' ? $i : 0)) . ',' . ($p['y'] + ($p['dir'] === 'down' ? $i : 0))] = $ch;
            }
        }
        [$minX, $minY, $maxX, $maxY] = self::bounds($grid);
        $width = $maxX - $minX + 1;
        $height = $maxY - $minY + 1;
        $cells = array_fill(0, $height, array_fill(0, $width, null));
        foreach ($grid as $key => $ch) {
            [$x, $y] = array_map('intval', explode(',', (string) $key));
            $cells[$y - $minY][$x - $minX] = $ch;
        }
        $starts = [];
        foreach ($placed as $p) {
            $starts[($p['y'] - $minY) . ',' . ($p['x'] - $minX)][] = array_merge($p, ['x' => $p['x'] - $minX, 'y' => $p['y'] - $minY]);
        }
        // Numeración de lectura: fila por fila, de izquierda a derecha.
        $keys = array_keys($starts);
        usort($keys, function ($a, $b) {
            [$ay, $ax] = array_map('intval', explode(',', $a));
            [$by, $bx] = array_map('intval', explode(',', $b));
            return [$ay, $ax] <=> [$by, $bx];
        });
        $numbers = [];
        $across = [];
        $down = [];
        foreach ($keys as $n => $key) {
            foreach ($starts[$key] as $p) {
                $entry = ['n' => $n + 1, 'x' => $p['x'], 'y' => $p['y'], 'word' => $p['w'], 'clue' => $p['c'], 'len' => mb_strlen($p['w'])];
                if ($p['dir'] === 'across') {
                    $across[] = $entry;
                } else {
                    $down[] = $entry;
                }
            }
            [$y, $x] = array_map('intval', explode(',', $key));
            $numbers["$x,$y"] = $n + 1;
        }
        return ['width' => $width, 'height' => $height, 'cells' => $cells, 'numbers' => $numbers, 'across' => $across, 'down' => $down, 'unplaced' => $unplaced];
    }

    // ------------------------------------------------------------------ sopa de letras

    /** Direcciones por dificultad: [dx, dy]. */
    public static function directions(string $difficulty): array
    {
        $easy = [[1, 0], [0, 1]];
        $medium = [[1, 0], [0, 1], [1, 1], [1, -1]];
        $all = [[1, 0], [0, 1], [1, 1], [1, -1], [-1, 0], [0, -1], [-1, -1], [-1, 1]];
        return match ($difficulty) {
            'basico' => $easy,
            'avanzado' => $all,
            default => $medium,
        };
    }

    /**
     * Sopa de letras: tamaño y direcciones según la dificultad, cruces permitidos solo si la letra coincide
     * y relleno aleatorio. Si una palabra no cabe, la rejilla crece (hasta 18).
     * @return array{size:int, grid:array<int, array<int, string>>, placed:array, words:array, unplaced:array}
     */
    public static function wordSearch(array $words, string $difficulty, int $seed): array
    {
        $words = self::cleanWords($words, 3, 15);
        $rng = new Rng($seed);
        $base = match ($difficulty) {
            'basico' => 10,
            'avanzado' => 15,
            default => 12,
        };
        $longest = $words ? max(array_map(fn ($w) => mb_strlen($w['w']), $words)) : 0;
        $letters = array_sum(array_map(fn ($w) => mb_strlen($w['w']), $words));
        $size = max($base, $longest + 1, (int) ceil(sqrt($letters / 0.55)));
        $dirs = self::directions($difficulty);
        $sorted = $words;
        usort($sorted, fn ($a, $b) => mb_strlen($b['w']) <=> mb_strlen($a['w']));
        for ($try = 0; $try < 4; $try++) {
            $grid = [];
            $placed = [];
            $unplaced = [];
            foreach ($sorted as $word) {
                $spot = self::wordSearchSpot($grid, self::letters($word['w']), $size, $dirs, $rng);
                if ($spot === null) {
                    $unplaced[] = $word['w'];
                    continue;
                }
                foreach (self::letters($word['w']) as $i => $ch) {
                    $grid[($spot[0] + $spot[2] * $i) . ',' . ($spot[1] + $spot[3] * $i)] = $ch;
                }
                $placed[] = ['word' => $word['w'], 'clue' => $word['c'], 'x' => $spot[0], 'y' => $spot[1], 'dx' => $spot[2], 'dy' => $spot[3]];
            }
            if ($unplaced === [] || $size >= 18) {
                break;
            }
            $size++;
        }
        // Relleno con frecuencias aproximadas del español.
        $pool = self::letters(str_repeat('AAAAAEEEEEOOOOIIISSSRRRNNNLLLDDDTTCCUUMMPPBGVYQHFZJÑXK', 1));
        $rows = [];
        for ($y = 0; $y < $size; $y++) {
            for ($x = 0; $x < $size; $x++) {
                $rows[$y][$x] = $grid["$x,$y"] ?? $rng->pick($pool);
            }
        }
        $list = array_column($placed, 'word');
        sort($list);
        return ['size' => $size, 'grid' => $rows, 'placed' => $placed, 'words' => $list, 'unplaced' => $unplaced];
    }

    /** @return array{0:int,1:int,2:int,3:int}|null x, y, dx, dy */
    private static function wordSearchSpot(array $grid, array $letters, int $size, array $dirs, Rng $rng): ?array
    {
        $len = count($letters);
        $options = [];
        foreach ($dirs as [$dx, $dy]) {
            for ($y = 0; $y < $size; $y++) {
                for ($x = 0; $x < $size; $x++) {
                    $ex = $x + $dx * ($len - 1);
                    $ey = $y + $dy * ($len - 1);
                    if ($ex < 0 || $ey < 0 || $ex >= $size || $ey >= $size) {
                        continue;
                    }
                    $overlap = 0;
                    $ok = true;
                    foreach ($letters as $i => $ch) {
                        $cell = $grid[($x + $dx * $i) . ',' . ($y + $dy * $i)] ?? null;
                        if ($cell !== null) {
                            if ($cell !== $ch) {
                                $ok = false;
                                break;
                            }
                            $overlap++;
                        }
                    }
                    // No se permite esconder una palabra entera dentro de otra.
                    if ($ok && $overlap < $len) {
                        $options[] = [$x, $y, $dx, $dy, $overlap];
                    }
                }
            }
        }
        if ($options === []) {
            return null;
        }
        // Se prefieren posiciones con alguna letra compartida, pero con azar para repartir por la rejilla.
        $withOverlap = array_values(array_filter($options, fn ($o) => $o[4] > 0));
        $pick = $withOverlap !== [] && $rng->int(0, 2) === 0 ? $rng->pick($withOverlap) : $rng->pick($options);
        return [$pick[0], $pick[1], $pick[2], $pick[3]];
    }
}
