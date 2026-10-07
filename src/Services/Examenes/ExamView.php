<?php

declare(strict_types=1);

namespace App\Services\Examenes;

/**
 * Ayudas de presentación compartidas por la vista previa (pantalla) y el PDF.
 */
final class ExamView
{
    private const ROMAN = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];

    public static function roman(int $i): string
    {
        return self::ROMAN[$i] ?? (string) ($i + 1);
    }

    /** Texto con fórmulas → HTML. En «completar», los espacios {{n}} se dibujan como líneas numeradas. */
    public static function text(string $text, string $target = 'screen', float $maxEm = 0): string
    {
        $html = Tex::html($text, $target, $maxEm);
        return (string) preg_replace_callback('/\{\{(\d+)\}\}/', function (array $m) use ($target): string {
            return $target === 'pdf'
                ? '<span class="blank">(' . $m[1] . ')&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;&#160;</span>'
                : '<span class="ex-blank">(' . $m[1] . ')</span>';
        }, $html);
    }

    /** ¿Las opciones caben en dos columnas? (cortas y sin fórmulas destacadas). */
    public static function shortOptions(array $options): bool
    {
        foreach ($options as $o) {
            $plain = (string) preg_replace('/\$[^$]*\$/', 'xxxxxx', $o);
            if (mb_strlen($plain) > 34 || str_contains($o, '$$') || str_contains($o, "\n")) {
                return false;
            }
        }
        return true;
    }

    /** Instrucción de cada sección. */
    public static function sectionHint(string $type, bool $sheet): string
    {
        $key = in_array($type, ['unica', 'multiple', 'vf'], true) && $sheet ? "examenes.pdf.hint_{$type}_sheet" : "examenes.pdf.hint_$type";
        return t($key);
    }

    /** Puntaje con coma decimal. */
    public static function points(float $p): string
    {
        return rtrim(rtrim(number_format($p, 2, ',', '.'), '0'), ',');
    }

    /** «1 pt» / «2,5 pts». */
    public static function pointsLabel(float $p): string
    {
        return t(abs($p - 1.0) < 0.001 ? 'examenes.pdf.point_one' : 'examenes.pdf.points_n', ['n' => self::points($p)]);
    }

    /** Fecha del encabezado (AAAA-MM-DD → «7 de octubre de 2026»). */
    public static function date(string $date): string
    {
        return $date !== '' ? fdate($date . ' 12:00:00', 'long') : '';
    }

    /** Filas de la hoja de respuestas: burbujas (única, múltiple, V/F) y casillas (corta, completar, relacionar, ordenar). */
    public static function sheet(array $version, int $options): array
    {
        $bubbles = [];
        $boxes = [];
        foreach ($version['questions'] as $q) {
            switch ($q['type']) {
                case 'unica':
                case 'multiple':
                    $bubbles[] = ['n' => $q['n'], 'choices' => array_map(fn ($i) => ExamContent::letter($i), array_keys($q['shown'])), 'multi' => $q['type'] === 'multiple'];
                    break;
                case 'vf':
                    $bubbles[] = ['n' => $q['n'], 'choices' => [t('examenes.pdf.v'), t('examenes.pdf.f')], 'multi' => false];
                    break;
                case 'corta':
                    $boxes[] = ['n' => $q['n'], 'labels' => ['']];
                    break;
                case 'completar':
                    $boxes[] = ['n' => $q['n'], 'labels' => array_map(fn ($i) => '(' . ($i + 1) . ')', array_keys($q['blanks']))];
                    break;
                case 'relacionar':
                    $boxes[] = ['n' => $q['n'], 'labels' => array_map(fn ($i) => (string) ($i + 1), array_keys($q['left'])), 'small' => true];
                    break;
                case 'ordenar':
                    $boxes[] = ['n' => $q['n'], 'labels' => array_map(fn ($i) => ExamContent::letter($i, true), array_keys($q['shown'])), 'small' => true];
                    break;
            }
        }
        return ['bubbles' => $bubbles, 'boxes' => $boxes];
    }

    /** Medidas del PDF según el papel y el tamaño de letra. */
    public static function layout(string $paper, string $letter): array
    {
        [$w, $h] = ExamCatalog::PAPERS[$paper] ?? ExamCatalog::PAPERS['carta'];
        $small = $paper === 'media_carta';
        $margin = $small ? 32 : 46;
        $font = ($small ? 9.2 : 10.6) + ($letter === 'grande' ? 2 : 0);
        $content = $w - 2 * $margin;
        return [
            'width' => $w,
            'height' => $h,
            'margin' => $margin,
            'margin_top' => $small ? 34 : 44,
            'margin_bottom' => $small ? 40 : 50,
            'font' => $font,
            'content' => $content,
            'max_em' => round($content / $font * 0.92, 1),
            'cell' => $small ? 13 : 17,
            'ws_cell' => $small ? 13 : 18,
        ];
    }
}
