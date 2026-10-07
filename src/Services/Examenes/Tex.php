<?php

declare(strict_types=1);

namespace App\Services\Examenes;

use App\Core\Config;
use App\Core\Logger;

/**
 * Fórmulas LaTeX → SVG con MathJax 3 sin navegador: tools/tex2svg/dist/tex2svg.cjs (Node ≥ 12) recibe un lote
 * de fórmulas por stdin y devuelve SVG autocontenido. Cada fórmula se guarda en storage/cache/tex/ por su hash,
 * así cada documento llama a Node a lo sumo una vez y solo con lo nuevo.
 *
 * - Pantalla: el SVG va en línea (usa currentColor, sirve en modo oscuro).
 * - PDF: <img> con data URI; dompdf (php-svg-lib) escala el viewBox al tamaño del <img> en em.
 * - Si Node no está o la fórmula tiene un error de TeX, se muestra el texto original (nunca se rompe la página).
 */
final class Tex
{
    private const CACHE_VERSION = 'mj322-1';
    private const SCRIPT = 'tools/tex2svg/dist/tex2svg.cjs';
    private const TIMEOUT = 90;
    /** Interlineado del PDF (templates/examenes/pdf.php usa el mismo). */
    public const PDF_LINE_HEIGHT = 1.36;

    /** @var array<string, array{svg:?string, w:float, h:float, va:float, error:?string}> */
    private static array $memo = [];
    /** @var (callable(array): array)|null */
    private static $converter = null;
    private static ?string $node = null;

    /** Pruebas: sustituye a Node. Recibe [['tex','display'], …] y devuelve [['svg','w','h','va','error'], …]. */
    public static function fake(?callable $converter): void
    {
        self::$converter = $converter;
        self::$memo = [];
    }

    public static function reset(): void
    {
        self::$memo = [];
    }

    // ------------------------------------------------------------------ texto

    /**
     * Corrige secuencias que el JSON convirtió en caracteres de control: «\times» → TAB + «imes»,
     * «\frac» → avance de página + «rac», «\beta» → retroceso + «eta», «\neq» → salto de línea + «eq».
     */
    public static function repair(string $text): string
    {
        $text = (string) preg_replace_callback('/[\x08\x0b\x0c](?=[A-Za-z])/', fn ($m) => ['' . "\x08" => '\\b', "\x0b" => '\\v', "\x0c" => '\\f'][$m[0]], $text);
        if (!str_contains($text, '$') && !str_contains($text, '\\(') && !str_contains($text, '\\[')) {
            return str_replace("\r", '', $text);
        }
        $out = '';
        foreach (self::segments(str_replace("\r\n", "\n", $text)) as $seg) {
            if ($seg['t'] === 'text') {
                $out .= str_replace('$', '\\$', $seg['v']);
                continue;
            }
            $tex = (string) preg_replace_callback('/[\t\r\n](?=[A-Za-z]{2})/', function ($m): string {
                return ['' . "\t" => '\\t', "\r" => '\\r', "\n" => '\\n'][$m[0]];
            }, $seg['v']);
            $out .= $seg['d'] ? '$$' . $tex . '$$' : '$' . $tex . '$';
        }
        return $out;
    }

    /**
     * Parte un texto en tramos de texto y de fórmula. Delimitadores: $…$, $$…$$, \(…\), \[…\].
     * «\$» es un signo de pesos. Un $ de apertura no puede ir seguido de espacio y uno de cierre no puede ir
     * precedido de espacio ni seguido de un dígito (así «$5.000 y $3.000» se lee como dinero).
     * @return array<int, array{t:string, v:string, d?:bool}>
     */
    public static function segments(string $text): array
    {
        $out = [];
        $buf = '';
        $len = strlen($text);
        $i = 0;
        $flush = static function () use (&$buf, &$out): void {
            if ($buf !== '') {
                $out[] = ['t' => 'text', 'v' => $buf];
                $buf = '';
            }
        };
        while ($i < $len) {
            $c = $text[$i];
            if ($c === '\\' && $i + 1 < $len) {
                $n = $text[$i + 1];
                if ($n === '$') {
                    $buf .= '$';
                    $i += 2;
                    continue;
                }
                if ($n === '(' || $n === '[') {
                    $close = $n === '(' ? '\\)' : '\\]';
                    $end = strpos($text, $close, $i + 2);
                    if ($end !== false && trim(substr($text, $i + 2, $end - $i - 2)) !== '') {
                        $flush();
                        $out[] = ['t' => 'math', 'v' => trim(substr($text, $i + 2, $end - $i - 2)), 'd' => $n === '['];
                        $i = $end + 2;
                        continue;
                    }
                }
                $buf .= $c;
                $i++;
                continue;
            }
            if ($c === '$') {
                if ($i + 1 < $len && $text[$i + 1] === '$') {
                    $end = strpos($text, '$$', $i + 2);
                    if ($end !== false && trim(substr($text, $i + 2, $end - $i - 2)) !== '') {
                        $flush();
                        $out[] = ['t' => 'math', 'v' => trim(substr($text, $i + 2, $end - $i - 2)), 'd' => true];
                        $i = $end + 2;
                        continue;
                    }
                } elseif ($i + 1 < $len && !ctype_space($text[$i + 1])) {
                    $end = self::closingDollar($text, $i + 1);
                    if ($end !== null) {
                        $flush();
                        $out[] = ['t' => 'math', 'v' => substr($text, $i + 1, $end - $i - 1), 'd' => false];
                        $i = $end + 1;
                        continue;
                    }
                }
            }
            $buf .= $c;
            $i++;
        }
        $flush();
        return $out;
    }

    private static function closingDollar(string $text, int $from): ?int
    {
        $len = strlen($text);
        for ($j = $from; $j < $len; $j++) {
            $c = $text[$j];
            if ($c === '\\') {
                $j++;
                continue;
            }
            if ($c === "\n" && $j + 1 < $len && $text[$j + 1] === "\n") {
                return null;
            }
            if ($c === '$') {
                if ($j + 1 < $len && $text[$j + 1] === '$') {
                    return null;
                }
                if (ctype_space($text[$j - 1]) || ($j + 1 < $len && ctype_digit($text[$j + 1]))) {
                    return null;
                }
                return $j;
            }
        }
        return null;
    }

    public static function hasMath(string $text): bool
    {
        foreach (self::segments($text) as $seg) {
            if ($seg['t'] === 'math') {
                return true;
            }
        }
        return false;
    }

    // ------------------------------------------------------------------ conversión

    private static function key(string $tex, bool $display): string
    {
        return sha1(self::CACHE_VERSION . '|' . ($display ? 'D' : 'I') . '|' . $tex);
    }

    private static function cacheFile(string $key): string
    {
        return Config::storage('cache/tex/' . substr($key, 0, 2) . '/' . $key . '.json');
    }

    /** Convierte de una vez todas las fórmulas de estos textos (las que no estén en caché). */
    public static function prepare(iterable $texts): void
    {
        $missing = [];
        foreach ($texts as $text) {
            if (!is_string($text) || $text === '') {
                continue;
            }
            foreach (self::segments($text) as $seg) {
                if ($seg['t'] !== 'math') {
                    continue;
                }
                $key = self::key($seg['v'], (bool) $seg['d']);
                if (isset(self::$memo[$key]) || isset($missing[$key])) {
                    continue;
                }
                // Con un conversor simulado (pruebas) no se lee ni se escribe la caché en disco.
                $file = self::cacheFile($key);
                if (self::$converter === null && is_file($file)) {
                    $data = json_decode((string) file_get_contents($file), true);
                    if (is_array($data) && array_key_exists('svg', $data)) {
                        self::$memo[$key] = $data;
                        continue;
                    }
                }
                $missing[$key] = ['tex' => $seg['v'], 'display' => (bool) $seg['d']];
            }
        }
        if ($missing === []) {
            return;
        }
        foreach (array_chunk($missing, 1500, true) as $batch) {
            $results = self::convert(array_values($batch));
            $keys = array_keys($batch);
            foreach ($keys as $n => $key) {
                $r = $results[$n] ?? null;
                if (!is_array($r)) {
                    // Sin conversor: se recuerda solo en esta petición (no se guarda en caché).
                    self::$memo[$key] = ['svg' => null, 'w' => 0, 'h' => 0, 'va' => 0, 'error' => 'unavailable'];
                    continue;
                }
                $data = [
                    'svg' => is_string($r['svg'] ?? null) && str_starts_with($r['svg'], '<svg') ? $r['svg'] : null,
                    'w' => (float) ($r['w'] ?? 0), 'h' => (float) ($r['h'] ?? 0), 'va' => (float) ($r['va'] ?? 0),
                    'error' => isset($r['error']) ? mb_substr((string) $r['error'], 0, 200) : null,
                ];
                self::$memo[$key] = $data;
                if (self::$converter !== null) {
                    continue;
                }
                $file = self::cacheFile($key);
                if (!is_dir(dirname($file))) {
                    @mkdir(dirname($file), 0770, true);
                }
                @file_put_contents($file, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), LOCK_EX);
            }
        }
    }

    /** Resultado de una fórmula (la convierte si hace falta). */
    public static function formula(string $tex, bool $display = false): array
    {
        $key = self::key($tex, $display);
        if (!isset(self::$memo[$key])) {
            self::prepare([$display ? '$$' . $tex . '$$' : '$' . $tex . '$']);
        }
        return self::$memo[$key] ?? ['svg' => null, 'w' => 0, 'h' => 0, 'va' => 0, 'error' => 'unavailable'];
    }

    /**
     * @param array<int, array{tex:string, display:bool}> $items
     * @return array<int, ?array>
     */
    private static function convert(array $items): array
    {
        if (self::$converter !== null) {
            return array_values((self::$converter)($items));
        }
        $node = self::node();
        $script = Config::root(self::SCRIPT);
        if ($node === null || !is_file($script)) {
            Logger::warning('tex2svg no disponible', ['node' => $node !== null, 'script' => is_file($script)]);
            return [];
        }
        $payload = (string) json_encode(['items' => $items], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        // stdout y stderr van a archivos temporales: los pipes sin bloqueo no funcionan en Windows y así
        // tampoco hay bloqueo mutuo con salidas grandes.
        $tmpOut = (string) tempnam(sys_get_temp_dir(), 'tex');
        $tmpErr = (string) tempnam(sys_get_temp_dir(), 'tex');
        $proc = @proc_open([$node, $script], [0 => ['pipe', 'r'], 1 => ['file', $tmpOut, 'w'], 2 => ['file', $tmpErr, 'w']], $pipes);
        if (!is_resource($proc)) {
            @unlink($tmpOut);
            @unlink($tmpErr);
            Logger::warning('No se pudo iniciar tex2svg');
            return [];
        }
        fwrite($pipes[0], $payload);
        fclose($pipes[0]);
        $deadline = microtime(true) + self::TIMEOUT;
        while (($status = proc_get_status($proc)) && $status['running']) {
            if (microtime(true) > $deadline) {
                proc_terminate($proc);
                Logger::warning('tex2svg excedió el tiempo', ['items' => count($items)]);
                break;
            }
            usleep(15000);
        }
        $code = proc_close($proc);
        $out = (string) @file_get_contents($tmpOut);
        $err = (string) @file_get_contents($tmpErr);
        @unlink($tmpOut);
        @unlink($tmpErr);
        $json = json_decode($out, true);
        if (!is_array($json) || !isset($json['items']) || !is_array($json['items'])) {
            Logger::warning('tex2svg no devolvió JSON', ['code' => $code, 'stderr' => mb_substr($err, 0, 200)]);
            return [];
        }
        return $json['items'];
    }

    /** Ruta de Node: NODE_BINARY, rutas habituales o el PATH. */
    public static function node(): ?string
    {
        if (self::$node !== null) {
            return self::$node !== '' ? self::$node : null;
        }
        $candidates = array_filter([
            (string) Config::get('NODE_BINARY', ''),
            '/usr/bin/node', '/usr/local/bin/node', 'C:\\Program Files\\nodejs\\node.exe',
        ]);
        foreach ($candidates as $path) {
            if (is_file($path) && is_executable($path)) {
                return self::$node = $path;
            }
        }
        self::$node = '';
        return null;
    }

    public static function available(): bool
    {
        return self::$converter !== null || (self::node() !== null && is_file(Config::root(self::SCRIPT)));
    }

    // ------------------------------------------------------------------ HTML

    /**
     * Texto del examen → HTML: escapa, convierte fórmulas, **negrita** y saltos de línea.
     * $target: screen (SVG en línea) o pdf (<img> para dompdf). $maxEm: ancho máximo de una fórmula en em (PDF).
     */
    public static function html(string $text, string $target = 'screen', float $maxEm = 0): string
    {
        $html = '';
        foreach (self::segments($text) as $seg) {
            if ($seg['t'] === 'text') {
                $html .= self::textHtml($seg['v']);
                continue;
            }
            $html .= self::mathHtml($seg['v'], (bool) $seg['d'], $target, $maxEm);
        }
        return $html;
    }

    private static function textHtml(string $text): string
    {
        $html = e($text);
        $html = (string) preg_replace('/\*\*(?=\S)(.+?)(?<=\S)\*\*/u', '<strong>$1</strong>', $html);
        return nl2br($html, false);
    }

    public static function mathHtml(string $tex, bool $display, string $target = 'screen', float $maxEm = 0): string
    {
        $r = self::formula($tex, $display);
        if ($r['svg'] === null) {
            $raw = '<code class="ex-tex-raw">' . e(($display ? '$$' : '$') . $tex . ($display ? '$$' : '$')) . '</code>';
            return $display ? '<span class="ex-math-block">' . $raw . '</span>' : $raw;
        }
        if ($target === 'pdf') {
            $svg = (string) preg_replace(['/ style="[^"]*"/', '/ width="[^"]*"/', '/ height="[^"]*"/'], '', $r['svg'], 1);
            // ex de MathJax = 0,5 em del texto que la rodea.
            $w = $r['w'] / 2;
            $h = $r['h'] / 2;
            // dompdf mide vertical-align desde la base de la caja de línea: se resta el medio interlineado.
            $va = $r['va'] / 2 - (self::PDF_LINE_HEIGHT - 1) / 2;
            if ($maxEm > 0 && $w > $maxEm) {
                $scale = $maxEm / $w;
                [$w, $h, $va] = [$w * $scale, $h * $scale, $va * $scale];
            }
            $img = sprintf(
                '<img class="m" src="data:image/svg+xml;base64,%s" style="width:%.3fem;height:%.3fem;vertical-align:%.3fem" alt="">',
                base64_encode($svg), $w, $h, $va
            );
            return $display ? '<div class="md">' . $img . '</div>' : $img;
        }
        $svg = str_replace(' role="img" focusable="false"', ' aria-hidden="true" focusable="false"', $r['svg']);
        $label = ' role="img" aria-label="' . e($tex) . '"';
        return $display
            ? '<span class="ex-math-block"' . $label . '>' . $svg . '</span>'
            : '<span class="ex-math"' . $label . '>' . $svg . '</span>';
    }
}
