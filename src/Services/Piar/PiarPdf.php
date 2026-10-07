<?php

declare(strict_types=1);

namespace App\Services\Piar;

use App\Core\Config;
use App\Core\View;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * PDF formal del PIAR con dompdf (sin recursos remotos; el logo va incrustado como data URI).
 */
final class PiarPdf
{
    public static function html(array $plan, ?array $profile): string
    {
        $input = PiarPlans::input($plan);
        $logo = PiarProfile::logoData($profile);
        return View::render('piar/pdf', [
            'plan' => $plan,
            'input' => $input,
            'output' => PiarPlans::output($plan),
            'sections' => PiarPrompt::sections(),
            'rows' => PiarView::studentRows($plan, $input, $profile),
            'logo' => $logo !== null ? 'data:image/png;base64,' . base64_encode($logo) : null,
            'institution' => trim((string) (($profile['institution'] ?? '') ?: ($input['institucion'] ?? ''))),
            'city' => trim((string) ($profile['city'] ?? '')),
            'year' => (string) ($input['anio'] ?? substr((string) $plan['created_at'], 0, 4)),
        ]);
    }

    public static function render(array $plan, ?array $profile): string
    {
        $tmp = Config::storage('cache/dompdf');
        if (!is_dir($tmp)) {
            mkdir($tmp, 0770, true);
        }
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
        $dompdf->loadHtml(self::html($plan, $profile), 'UTF-8');
        $dompdf->setPaper('letter', 'portrait');
        $dompdf->addInfo('Title', t('piar.plan.doc_title') . ' — ' . ($plan['student_alias'] ?: t('piar.plan.student')));
        $dompdf->addInfo('Author', 'edwinortiz.net · PIAR con IA');
        $dompdf->render();

        // Número de página en el pie, a la derecha.
        $canvas = $dompdf->getCanvas();
        $font = $dompdf->getFontMetrics()->getFont('DejaVu Sans');
        $canvas->page_text($canvas->get_width() - 48 - 70, $canvas->get_height() - 44, t('piar.pdf.page'), $font, 7, [0.4, 0.46, 0.48]);
        return (string) $dompdf->output();
    }
}
