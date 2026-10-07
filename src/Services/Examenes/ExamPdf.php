<?php

declare(strict_types=1);

namespace App\Services\Examenes;

use App\Core\Config;
use App\Core\View;
use Dompdf\Dompdf;
use Dompdf\Frame;
use Dompdf\Options;

/**
 * PDF del examen con dompdf: por cada versión, el examen y su hoja de respuestas; al final, el solucionario.
 * Las fórmulas van como SVG (Tex). Cada página lleva la versión y su número dentro de la versión: durante el
 * render se anota en qué página empieza cada versión (marcas .vstart) y luego se escribe el pie en cada página.
 */
final class ExamPdf
{
    /**
     * @param array{exam:array, header:array, input:array, versions:array, logo:?string, demo?:bool} $doc
     */
    public static function html(array $doc): string
    {
        $header = $doc['header'];
        $layout = ExamView::layout($header['papel'], $header['letra']);
        Tex::prepare(array_merge(ExamContent::texts($doc['versions']), [$header['instrucciones']]));
        $keys = [];
        foreach ($doc['versions'] as $v) {
            $keys[$v['index']] = ExamContent::answerKey($v);
        }
        return View::render('examenes/pdf', $doc + [
            'L' => $layout,
            'keys' => $keys,
            'equiv' => $doc['exam']['mode'] === 'barajar' && count($doc['versions']) > 1 ? ExamContent::equivalences($doc['versions']) : [],
            'demo' => !empty($doc['demo']),
        ]);
    }

    /** @return array{pdf:string, pages:int, starts:array} */
    public static function render(array $doc): array
    {
        $tmp = Config::storage('cache/dompdf');
        if (!is_dir($tmp)) {
            mkdir($tmp, 0770, true);
        }
        @set_time_limit(300);
        $header = $doc['header'];
        $layout = ExamView::layout($header['papel'], $header['letra']);
        $options = new Options();
        $options->setDefaultFont('DejaVu Sans');
        $options->setIsRemoteEnabled(false);
        $options->setIsPhpEnabled(false);
        $options->setIsJavascriptEnabled(false);
        $options->setTempDir($tmp);
        $options->setFontCache($tmp);
        $options->setChroot([Config::root('public')]);
        $options->setDpi(96);

        $dompdf = new Dompdf($options);
        $starts = [];
        $dompdf->setCallbacks([[
            'event' => 'begin_frame',
            'f' => function (Frame $frame, $canvas) use (&$starts): void {
                $node = $frame->get_node();
                if ($node instanceof \DOMElement && str_starts_with($node->getAttribute('id'), 'vstart-')) {
                    $key = substr($node->getAttribute('id'), 7);
                    $starts[$key] ??= $canvas->get_page_number();
                }
            },
        ]]);
        $dompdf->loadHtml(self::html($doc), 'UTF-8');
        $dompdf->setPaper([0, 0, $layout['width'], $layout['height']]);
        $dompdf->addInfo('Title', $header['titulo']);
        $dompdf->addInfo('Author', 'edwinortiz.net · Generador de exámenes con IA');
        $dompdf->render();

        $canvas = $dompdf->getCanvas();
        $fm = $dompdf->getFontMetrics();
        $font = $fm->getFont('DejaVu Sans');
        $bold = $fm->getFont('DejaVu Sans', 'bold');
        $total = $canvas->get_page_count();
        // Rangos de páginas: cada versión hasta la siguiente marca; el solucionario hasta el final.
        asort($starts);
        $ranges = [];
        $keys = array_keys($starts);
        foreach ($keys as $i => $key) {
            $from = $starts[$key];
            $to = isset($keys[$i + 1]) ? $starts[$keys[$i + 1]] - 1 : $total;
            $ranges[(string) $key] = [$from, $to];
        }
        $labels = [];
        foreach ($doc['versions'] as $v) {
            $labels[(string) $v['index']] = $v['label'];
        }
        $title = mb_substr($header['titulo'], 0, 70);
        $demo = !empty($doc['demo']);
        $w = $layout['width'];
        $h = $layout['height'];
        $m = $layout['margin'];
        $size = $layout['width'] < 500 ? 6.5 : 7.5;
        $canvas->page_script(function (int $page) use ($canvas, $font, $bold, $ranges, $labels, $title, $demo, $w, $h, $m, $size, $fm): void {
            $range = null;
            $key = null;
            foreach ($ranges as $k => $r) {
                if ($page >= $r[0] && $page <= $r[1]) {
                    $range = $r;
                    $key = $k;
                }
            }
            $y = $h - $m * 0.62;
            $grey = [0.42, 0.47, 0.52];
            $canvas->line($m, $y - 5, $w - $m, $y - 5, [0.82, 0.85, 0.88], 0.5);
            if ($range !== null) {
                $num = $page - $range[0] + 1;
                $count = $range[1] - $range[0] + 1;
                $right = $key === 'key'
                    ? t('examenes.pdf.footer_key', ['n' => $num, 'total' => $count])
                    : t('examenes.pdf.footer_version', ['v' => $labels[$key] ?? '', 'n' => $num, 'total' => $count]);
                $rw = $fm->getTextWidth($right, $bold, $size);
                $canvas->text($w - $m - $rw, $y, $right, $bold, $size, [0.06, 0.35, 0.42]);
            }
            $canvas->text($m, $y, $title, $font, $size, $grey);
            if ($demo) {
                $canvas->set_opacity(0.13);
                $mark = t('examenes.demo.watermark');
                $ms = $w < 500 ? 70 : 110;
                $tw = $fm->getTextWidth($mark, $bold, $ms);
                $canvas->text(($w - $tw * 0.75) / 2, $h / 2 + $tw * 0.3, $mark, $bold, $ms, [0.75, 0.1, 0.1], 0, 0, -38);
                $canvas->set_opacity(1);
            }
        });
        return ['pdf' => (string) $dompdf->output(), 'pages' => $total, 'starts' => $starts];
    }
}
