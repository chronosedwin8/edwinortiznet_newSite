<?php
/**
 * PIAR en PDF (dompdf, DejaVu Sans). Encabezado con logo e institución, ficha del estudiante,
 * secciones, acta de acuerdo con firmas y pie con la nota de validación por el equipo (los números de página los pinta PiarPdf).
 * @var array $plan @var array $input @var array $output @var array $sections @var array $rows @var string|null $logo
 * @var string $institution @var string $city @var string $year
 */

use App\Core\View;

$signers = ['piar.acta.sign_docente', 'piar.acta.sign_familia', 'piar.acta.sign_directivo', 'piar.acta.sign_apoyo', 'piar.acta.sign_estudiante'];
?>
<!doctype html>
<html lang="es-CO">
<head>
<meta charset="utf-8">
<title><?= e(t('piar.plan.doc_title')) ?></title>
<style>
@page { margin: 20mm 17mm 22mm 17mm; }
* { box-sizing: border-box; }
body { font-family: "DejaVu Sans", sans-serif; font-size: 9.4pt; line-height: 1.42; color: #1d2a2e; margin: 0; }
p { margin: 0 0 6pt; }
ul { margin: 2pt 0 6pt; padding-left: 13pt; }
li { margin: 0 0 2.5pt; }
strong { font-weight: bold; }
.foot { position: fixed; left: 0; right: 0; bottom: -13mm; height: 10mm; font-size: 7pt; color: #66767b; border-top: 0.6pt solid #c9d6d9; padding-top: 4pt; }
.foot__note { width: 80%; }
.head { width: 100%; border-collapse: collapse; margin-bottom: 10pt; }
.head td { vertical-align: middle; padding: 0; }
.head__logo { width: 90pt; padding-right: 12pt !important; }
.head__logo img { max-width: 90pt; max-height: 60pt; }
.head__inst { font-size: 12.5pt; font-weight: bold; color: #0E5A6B; line-height: 1.25; }
.head__city { font-size: 8.5pt; color: #5a6a6f; margin-top: 2pt; }
.head__badge { text-align: right; font-size: 7.5pt; color: #0E5A6B; }
.head__badge span { border: 0.8pt solid #0E5A6B; border-radius: 3pt; padding: 3pt 6pt; }
.band { background: #0E5A6B; color: #fff; padding: 12pt 14pt 11pt; border-radius: 4pt; margin-bottom: 12pt; }
.band__title { font-size: 15pt; font-weight: bold; line-height: 1.2; margin: 0 0 3pt; }
.band__sub { font-size: 8.5pt; color: #cfe6ea; margin: 0; }
.facts { width: 100%; border-collapse: collapse; margin-bottom: 8pt; }
.facts td { border: 0.6pt solid #c9d6d9; padding: 4.5pt 6pt; vertical-align: top; width: 25%; }
.facts .k { background: #eef5f6; color: #0E5A6B; font-weight: bold; font-size: 7.8pt; text-transform: uppercase; letter-spacing: .3pt; }
.legend { font-size: 7.8pt; color: #5a6a6f; margin: 0 0 10pt; }
.piar-validate { color: #8a5a00; background: #fff3d6; font-style: italic; }
.piar-section { margin: 0 0 12pt; }
.piar-section__title { font-size: 11.5pt; color: #0E5A6B; margin: 12pt 0 3pt; padding-bottom: 3pt; border-bottom: 1.2pt solid #0E5A6B; page-break-after: avoid; }
.piar-section__intro { font-size: 8pt; color: #66767b; font-style: italic; margin: 0 0 6pt; page-break-after: avoid; }
.piar-sub { font-size: 9.6pt; color: #1d2a2e; margin: 7pt 0 2pt; page-break-after: avoid; }
.piar-empty { color: #8a979b; font-style: italic; }
table.t-grid, table.t-dims { width: 100%; border-collapse: collapse; margin: 3pt 0 6pt; }
thead { display: table-header-group; }
.t-grid tr, .t-dims tr { page-break-inside: avoid; }
.t-grid td, .t-dims td { line-height: 1.38; }
.t-grid th { background: #0E5A6B; color: #fff; font-size: 7.8pt; text-align: left; padding: 4pt 5pt; font-weight: bold; }
.t-grid td { border-bottom: 0.6pt solid #d5e0e2; padding: 4.5pt 5pt; vertical-align: top; font-size: 8.6pt; }
.t-grid tr:nth-child(even) td { background: #f6fafa; }
.t-grid td ul { margin: 2pt 0 0; padding-left: 11pt; }
.t-dims th { width: 26%; text-align: left; vertical-align: top; background: #eef5f6; color: #0E5A6B; font-size: 8.4pt; padding: 5pt 6pt; border-bottom: 0.6pt solid #fff; }
.t-dims td { vertical-align: top; padding: 5pt 6pt; border-bottom: 0.6pt solid #d5e0e2; }
.t-dims td p:last-child, .t-grid td p:last-child { margin-bottom: 0; }
.w-18 { width: 18%; } .w-22 { width: 22%; } .w-25 { width: 25%; }
.cat { font-size: 7.4pt; color: #0E5A6B; text-transform: uppercase; letter-spacing: .3pt; }
.lbl { font-size: 7.4pt; color: #66767b; text-transform: uppercase; letter-spacing: .3pt; }
.strat { margin-top: 3pt; }
.piar-groups { width: 100%; }
.piar-group { margin: 0 0 5pt; padding: 5pt 8pt 2pt; border-left: 2pt solid #0E5A6B; background: #f6fafa; }
.piar-group__title { font-size: 8.6pt; color: #0E5A6B; margin: 0 0 1pt; text-transform: uppercase; letter-spacing: .3pt; }
.disclaimer { margin-top: 10pt; padding: 7pt 9pt; border: 0.8pt solid #c9d6d9; border-radius: 3pt; font-size: 7.8pt; color: #4a5a5f; background: #f6fafa; }
.acta { page-break-before: always; }
.acta__title { font-size: 15pt; font-weight: bold; color: #0E5A6B; margin: 0 0 4pt; }
.acta__sub { font-size: 8.5pt; color: #5a6a6f; margin: 0 0 12pt; }
.acta__text { text-align: justify; margin-bottom: 16pt; }
.signs { width: 100%; border-collapse: collapse; }
.signs td { width: 48%; vertical-align: top; border: 0.6pt solid #c9d6d9; padding: 9pt 10pt 4pt; }
.signs td.gap { width: 4%; border: 0; padding: 0; }
.signs tr.space td { border: 0; height: 12pt; padding: 0; }
.signs__role { font-weight: bold; color: #0E5A6B; font-size: 8.8pt; margin-bottom: 26pt; }
.signs__line { border-top: 0.7pt solid #1d2a2e; padding-top: 2pt; font-size: 7.4pt; color: #5a6a6f; margin-bottom: 9pt; }
</style>
</head>
<body>
<div class="foot"><div class="foot__note"><?= e(t('piar.pdf.footer')) ?></div></div>

<table class="head">
  <tr>
    <?php if ($logo): ?><td class="head__logo"><img src="<?= $logo ?>" alt=""></td><?php endif; ?>
    <td>
      <div class="head__inst"><?= e($institution !== '' ? $institution : t('piar.data.institucion')) ?></div>
      <?php if ($city !== ''): ?><div class="head__city"><?= e($city) ?></div><?php endif; ?>
    </td>
    <td class="head__badge"><span><?= e(t('piar.pdf.generated', ['date' => fdate($plan['created_at'], 'short')])) ?></span></td>
  </tr>
</table>

<div class="band">
  <p class="band__title"><?= e(t('piar.plan.doc_title')) ?></p>
  <p class="band__sub"><?= e(t('piar.plan.doc_subtitle')) ?></p>
</div>

<table class="facts">
  <?php $cells = []; foreach ($rows as $label => $value) { $cells[] = [$label, $value]; } $wide = array_pop($cells); ?>
  <?php foreach (array_chunk($cells, 2) as $pair): ?>
  <tr>
    <?php foreach ($pair as [$label, $value]): ?><td class="k"><?= e($label) ?></td><td><?= e($value) ?></td><?php endforeach; ?>
    <?php if (count($pair) === 1): ?><td class="k"></td><td></td><?php endif; ?>
  </tr>
  <?php endforeach; ?>
  <tr><td class="k"><?= e($wide[0]) ?></td><td colspan="3"><?= e($wide[1]) ?></td></tr>
</table>
<p class="legend"><span class="piar-validate"><?= e(\App\Services\Piar\PiarPrompt::VALIDATE_MARK) ?></span> <?= e(t('piar.pdf.legend')) ?></p>

<?= View::render('partials/piar/document', ['output' => $output, 'sections' => $sections, 'mode' => 'pdf']) ?>

<div class="disclaimer"><?= e(t('piar.pdf.footer')) ?></div>

<div class="acta">
  <p class="acta__title"><?= e(t('piar.acta.title')) ?></p>
  <p class="acta__sub"><?= e(t('piar.plan.doc_title')) ?> · <?= e((string) ($rows[t('piar.data.estudiante')] ?? '')) ?> · <?= e((string) ($rows[t('piar.data.grado')] ?? '')) ?></p>
  <p class="acta__text"><?= e(t('piar.acta.text', ['city' => $city !== '' ? $city : t('piar.acta.city_blank'), 'year' => $year])) ?></p>
  <table class="signs">
    <?php foreach (array_chunk($signers, 2) as $r => $pair): ?>
    <?php if ($r > 0): ?><tr class="space"><td colspan="3"></td></tr><?php endif; ?>
    <tr>
      <?php foreach ($pair as $i => $role): ?>
      <?php if ($i === 1): ?><td class="gap"></td><?php endif; ?>
      <td>
        <div class="signs__role"><?= e(t($role)) ?></div>
        <div class="signs__line"><?= e(t('piar.acta.sign')) ?></div>
        <div class="signs__line"><?= e(t('piar.acta.name')) ?></div>
        <div class="signs__line"><?= e(t('piar.acta.doc')) ?></div>
      </td>
      <?php endforeach; ?>
      <?php if (count($pair) === 1): ?><td class="gap"></td><td style="border: 0"></td><?php endif; ?>
    </tr>
    <?php endforeach; ?>
  </table>
</div>
</body>
</html>
