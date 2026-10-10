<?php
/**
 * PDF del examen (dompdf). Por cada versión: examen + hoja de respuestas; al final, el solucionario.
 * @var array $exam @var array $header @var array $input @var array $versions @var ?string $logo @var array $L
 * @var array $keys @var array $equiv @var bool $demo
 */

use App\Services\Examenes\ExamCatalog;
use App\Services\Examenes\ExamContent;
use App\Services\Examenes\ExamView as V;
use App\Services\Examenes\Tex;

$T = static fn (string $s, float $em = 0): string => V::text($s, 'pdf', $em > 0 ? $em : $L['max_em']);
$types = ExamCatalog::types();
$sheetOn = !empty($header['hoja']);
$options = (int) ($input['opciones'] ?? 4);
$mode = (string) $exam['mode'];
$date = V::date($header['fecha']);
$f = $L['font'];
$c = $L['content'];
$crossCell = static function (array $p) use ($L, $c): float {
    return max(9, min($L['cell'], floor(($c - 4) / max(1, $p['width']))));
};
$wsCell = static function (array $p) use ($L, $c): float {
    return max(9, min($L['ws_cell'], floor(($c * 0.8) / max(1, $p['size']))));
};
$sectionPoints = static function (array $section): float {
    return array_sum(array_column($section['questions'], 'points'));
};
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<style>
@page { margin: <?= $L['margin_top'] ?>pt <?= $L['margin'] ?>pt <?= $L['margin_bottom'] ?>pt <?= $L['margin'] ?>pt; }
* { box-sizing: border-box; }
body { font-family: "DejaVu Sans", sans-serif; font-size: <?= $f ?>pt; color: #17232d; line-height: <?= Tex::PDF_LINE_HEIGHT ?>; }
p { margin: 0 0 4pt; }
.pb { page-break-before: always; }
.vstart { height: 0; margin: 0; padding: 0; }
img.m { vertical-align: middle; }
.md { text-align: center; margin: 4pt 0; }
.ex-tex-raw { font-family: "DejaVu Sans Mono", monospace; font-size: <?= $f - 1.5 ?>pt; color: #5a2a2a; }
.blank { border-bottom: 0.7pt solid #33424e; color: #5d6b76; font-size: <?= $f - 1.5 ?>pt; }

/* Encabezado */
.hd { width: 100%; border-collapse: collapse; border: 1.1pt solid #0e5a6b; margin-bottom: 6pt; }
.hd td { vertical-align: middle; padding: 6pt 8pt; }
.hd-logo { width: <?= $L['width'] < 500 ? 46 : 64 ?>pt; text-align: center; border-right: 0.6pt solid #b9cdd3; }
.hd-logo img { max-width: <?= $L['width'] < 500 ? 40 : 56 ?>pt; max-height: <?= $L['width'] < 500 ? 40 : 56 ?>pt; }
.inst { font-size: <?= $f - 1 ?>pt; font-weight: bold; text-transform: uppercase; letter-spacing: .4pt; color: #0e5a6b; }
.title { font-size: <?= $f + 3.5 ?>pt; font-weight: bold; line-height: 1.15; margin: 1pt 0 2pt; }
.meta { font-size: <?= $f - 1.4 ?>pt; color: #42525e; }
.hd-ver { width: <?= $L['width'] < 500 ? 50 : 66 ?>pt; text-align: center; background: #0e5a6b; color: #fff; }
.ver-label { font-size: <?= $f - 2.5 ?>pt; text-transform: uppercase; letter-spacing: .8pt; }
.ver { font-size: <?= $f + 13 ?>pt; font-weight: bold; line-height: 1; }
.fields { width: 100%; border-collapse: collapse; margin-bottom: 6pt; font-size: <?= $f - 0.8 ?>pt; }
.fields td { padding: 5pt 4pt 2pt 0; vertical-align: bottom; }
.fill { display: inline-block; border-bottom: 0.7pt solid #33424e; }
.instr { border: 0.6pt solid #c9d6db; background: #f3f8f9; padding: 5pt 7pt; font-size: <?= $f - 1 ?>pt; margin-bottom: 8pt; }
.instr strong { color: #0e5a6b; }

/* Secciones y preguntas */
.sec { font-size: <?= $f + 1 ?>pt; font-weight: bold; color: #0e5a6b; border-bottom: 1pt solid #0e5a6b; padding-bottom: 2pt; margin: 9pt 0 3pt; page-break-after: avoid; }
.sec-pts { font-weight: normal; font-size: <?= $f - 1.5 ?>pt; color: #42525e; }
.hint { font-size: <?= $f - 1.5 ?>pt; color: #42525e; font-style: italic; margin: 0 0 5pt; page-break-after: avoid; }
table.q { width: 100%; border-collapse: collapse; margin: 0 0 7pt; page-break-inside: avoid; }
table.q td { vertical-align: top; padding: 0; }
td.qn { width: <?= $f * 2.1 ?>pt; font-weight: bold; color: #0e5a6b; }
.qp { font-size: <?= $f - 2 ?>pt; color: #6a7782; }
.opts { width: 100%; border-collapse: collapse; margin-top: 3pt; }
.opts td { vertical-align: top; padding: 1.5pt 6pt 1.5pt 0; }
.ol { font-weight: bold; color: #0e5a6b; padding-right: 3pt; }
.tf { margin-top: 2pt; font-size: <?= $f - 1 ?>pt; }
.lines div { border-bottom: 0.6pt solid #a8b4bd; height: <?= $f * 1.9 ?>pt; }
.work { border: 0.6pt dashed #a8b4bd; margin-top: 4pt; }
.work-label { font-size: <?= $f - 2.5 ?>pt; color: #8a96a0; padding: 2pt 4pt; }
.ans-line { margin-top: 4pt; font-size: <?= $f - 1 ?>pt; }
.match { width: 100%; border-collapse: collapse; margin-top: 3pt; }
.match td { vertical-align: top; padding: 2pt 4pt 2pt 0; width: 50%; }
.box { display: inline-block; width: <?= $f + 6 ?>pt; height: <?= $f + 4 ?>pt; border: 0.8pt solid #4b5d69; vertical-align: middle; margin-right: 4pt; }

/* Crucigrama y sopa de letras */
.grid { border-collapse: collapse; margin: 5pt auto 4pt; }
.grid td { text-align: center; vertical-align: middle; padding: 0; }
.cw td.on { border: 0.7pt solid #33424e; background: #fff; }
.cw td.off { border: 0; }
.cwn { font-size: 5pt; line-height: 1; text-align: left; color: #33424e; height: 5pt; padding-left: 1pt; }
.cwl { font-weight: bold; }
.ws { border: 1pt solid #33424e; }
.ws td { font-family: "DejaVu Sans Mono", monospace; font-weight: bold; color: #222; }
.ws td.hit { background: #ffe08a; color: #000; }
.ws td.miss { color: #b5bec5; }
.clues { width: 100%; border-collapse: collapse; font-size: <?= $f - 1.2 ?>pt; }
.clues td { vertical-align: top; padding: 0 6pt 0 0; width: 50%; }
.clues td + td, .match td + td, .opts td + td { padding-left: 10pt; }
.clues h4 { font-size: <?= $f - 0.6 ?>pt; margin: 2pt 0; color: #0e5a6b; }
.wordlist { font-family: "DejaVu Sans Mono", monospace; font-size: <?= $f - 1.5 ?>pt; text-align: center; }

/* Hoja de respuestas */
.sheet-title { font-size: <?= $f + 4 ?>pt; font-weight: bold; color: #0e5a6b; margin: 0 0 4pt; }
.sheet-note { font-size: <?= $f - 1.6 ?>pt; color: #42525e; margin-bottom: 6pt; }
.bub-wrap { width: 100%; border-collapse: collapse; }
.bub-wrap > tbody > tr > td { vertical-align: top; padding-right: 10pt; }
.bub { border-collapse: collapse; }
.bub td { padding: 2.2pt 2pt; vertical-align: middle; }
.bub .n { width: 18pt; text-align: right; font-weight: bold; padding-right: 5pt; font-size: <?= $f - 1 ?>pt; }
.bc { display: inline-block; width: 14pt; height: 11pt; border: 0.9pt solid #33424e; border-radius: 7pt; text-align: center; font-size: 7pt; line-height: 7pt; padding-top: 3pt; color: #4b5d69; }
.boxes td { padding: 3pt 6pt 3pt 0; vertical-align: middle; font-size: <?= $f - 1 ?>pt; }
.bx { display: inline-block; height: 15pt; border: 0.8pt solid #33424e; vertical-align: middle; }

/* Solucionario */
.key-h { font-size: <?= $f + 5 ?>pt; font-weight: bold; color: #7a2e0e; margin: 0 0 2pt; }
.key-sub { font-size: <?= $f - 1 ?>pt; color: #42525e; margin-bottom: 8pt; }
.kh2 { font-size: <?= $f + 1.5 ?>pt; font-weight: bold; color: #7a2e0e; border-bottom: 1pt solid #7a2e0e; margin: 10pt 0 5pt; padding-bottom: 2pt; page-break-after: avoid; }
.kh3 { font-size: <?= $f + 0.4 ?>pt; font-weight: bold; color: #0e5a6b; margin: 7pt 0 3pt; page-break-after: avoid; }
.kt { width: 100%; border-collapse: collapse; font-size: <?= $f - 1.4 ?>pt; margin-bottom: 4pt; }
.kt th, .kt td { border: 0.5pt solid #c3ccd2; padding: 2pt 4pt; vertical-align: top; text-align: left; }
.kt th { background: #eef3f5; font-weight: bold; }
.kt td.c { text-align: center; }
.sol { page-break-inside: avoid; margin: 0 0 7pt; padding: 4pt 6pt; border-left: 2pt solid #0e5a6b; background: #f7fafb; font-size: <?= $f - 1.2 ?>pt; }
.sol .st { color: #5d6b76; font-size: <?= $f - 1.8 ?>pt; margin-bottom: 2pt; }
.lbl { font-weight: bold; color: #0e5a6b; }
.rub { margin: 1pt 0 0 12pt; padding: 0; }
</style>
</head>
<body>
<?php foreach ($versions as $vi => $version): $vlabel = $version['label']; ?>
<?php if ($vi > 0): ?><div class="pb"></div><?php endif; ?>
<div class="vstart" id="vstart-<?= (int) $version['index'] ?>"></div>
<table class="hd">
  <tr>
    <?php if ($logo): ?><td class="hd-logo"><img src="<?= e($logo) ?>" alt=""></td><?php endif; ?>
    <td>
      <?php if ($header['institucion'] !== ''): ?><div class="inst"><?= e($header['institucion']) ?></div><?php endif; ?>
      <div class="title"><?= e($header['titulo']) ?></div>
      <div class="meta"><?= e(implode(' · ', array_filter([$header['asignatura'], $header['grado'], $header['docente'] !== '' ? t('examenes.pdf.teacher', ['name' => $header['docente']]) : '']))) ?></div>
    </td>
    <?php if (count($versions) > 1): ?>
    <td class="hd-ver"><div class="ver-label"><?= e(t('examenes.pdf.version')) ?></div><div class="ver"><?= e($vlabel) ?></div></td>
    <?php endif; ?>
  </tr>
</table>
<table class="fields">
  <tr>
    <td colspan="2"><?= e(t('examenes.pdf.name')) ?> <span class="fill" style="width: <?= round($c - 60) ?>pt">&#160;</span></td>
  </tr>
  <tr>
    <td style="width: 50%"><?= e(t('examenes.pdf.course')) ?> <span class="fill" style="width: <?= round($c * 0.5 - 50) ?>pt">&#160;</span></td>
    <td><?= e(t('examenes.pdf.date')) ?> <?php if ($date !== ''): ?><?= e($date) ?><?php else: ?><span class="fill" style="width: <?= round($c * 0.5 - 50) ?>pt">&#160;</span><?php endif; ?></td>
  </tr>
  <tr>
    <td><?php if ($header['duracion'] !== ''): ?><?= e(t('examenes.pdf.duration', ['time' => $header['duracion']])) ?><?php endif; ?></td>
    <td><?= e(t('examenes.pdf.grade_mark')) ?> <span class="fill" style="width: <?= round($c * 0.18) ?>pt">&#160;</span><?php if (!empty($header['puntaje'])): ?> / <?= e(V::points($version['points'])) ?><?php endif; ?></td>
  </tr>
</table>
<?php if ($header['instrucciones'] !== ''): ?>
<div class="instr"><strong><?= e(t('examenes.pdf.instructions')) ?></strong> <?= $T($header['instrucciones']) ?><?php if ($sheetOn): ?> <?= e(t('examenes.pdf.instructions_sheet')) ?><?php endif; ?></div>
<?php endif; ?>

<?php foreach ($version['sections'] as $si => $section): $type = $section['type']; ?>
<div class="sec"><?= e(V::roman($si)) ?>. <?= e($types[$type] ?? $type) ?><?php if (!empty($header['puntaje'])): ?> <span class="sec-pts">(<?= e(V::pointsLabel($sectionPoints($section))) ?>)</span><?php endif; ?></div>
<p class="hint"><?= e(V::sectionHint($type, $sheetOn)) ?></p>
<?php foreach ($section['questions'] as $q): ?>
<table class="q"><tr>
  <td class="qn"><?= (int) $q['n'] ?>.</td>
  <td>
    <div><?= $T($q['stem']) ?><?php if (!empty($header['puntaje'])): ?> <span class="qp">(<?= e(V::pointsLabel($q['points'])) ?>)</span><?php endif; ?></div>
    <?php if ($type === 'unica' || $type === 'multiple'): $two = V::shortOptions($q['shown']); ?>
    <table class="opts">
      <?php if ($two): foreach (array_chunk($q['shown'], 2, true) as $pair): ?>
      <tr><?php foreach ($pair as $i => $opt): ?><td style="width: 50%"><span class="ol"><?= e(ExamContent::letter($i)) ?>)</span><?= $T($opt, $L['max_em'] / 2.2) ?></td><?php endforeach; ?></tr>
      <?php endforeach; else: foreach ($q['shown'] as $i => $opt): ?>
      <tr><td><span class="ol"><?= e(ExamContent::letter($i)) ?>)</span><?= $T($opt, $L['max_em'] - 3) ?></td></tr>
      <?php endforeach; endif; ?>
    </table>
    <?php elseif ($type === 'vf' && !$sheetOn): ?>
    <div class="tf"><span class="bc"><?= e(t('examenes.pdf.v')) ?></span> <?= e(t('examenes.pdf.true')) ?> &#160; <span class="bc"><?= e(t('examenes.pdf.f')) ?></span> <?= e(t('examenes.pdf.false')) ?></div>
    <?php elseif ($type === 'corta'): ?>
    <div class="ans-line"><?= e(t('examenes.pdf.answer')) ?> <span class="fill" style="width: <?= round($c * 0.6) ?>pt">&#160;</span></div>
    <?php elseif ($type === 'relacionar'): ?>
    <table class="match">
      <tr><td><strong><?= e(t('examenes.pdf.col_a')) ?></strong></td><td><strong><?= e(t('examenes.pdf.col_b')) ?></strong></td></tr>
      <?php foreach ($q['left'] as $i => $left): ?>
      <tr><td><span class="box"></span><?= (int) ($i + 1) ?>. <?= $T($left, $L['max_em'] / 2.3) ?></td><td><strong><?= e(ExamContent::letter($i)) ?>.</strong> <?= $T($q['right'][$i] ?? '', $L['max_em'] / 2.3) ?></td></tr>
      <?php endforeach; ?>
    </table>
    <?php elseif ($type === 'ordenar'): ?>
    <table class="match">
      <?php foreach ($q['shown'] as $i => $item): ?>
      <tr><td style="width: 100%"><span class="box"></span><strong><?= e(ExamContent::letter($i, true)) ?>)</strong> <?= $T($item) ?></td></tr>
      <?php endforeach; ?>
    </table>
    <?php elseif ($type === 'problema'): ?>
    <div class="work" style="height: <?= round($f * ($L['width'] < 500 ? 11 : 15)) ?>pt"><div class="work-label"><?= e(t('examenes.pdf.work')) ?></div></div>
    <div class="ans-line"><?= e(t('examenes.pdf.final_answer')) ?> <span class="fill" style="width: <?= round($c * 0.55) ?>pt">&#160;</span></div>
    <?php elseif ($type === 'abierta' || $type === 'larga'): ?>
    <div class="lines"><?php for ($i = 0; $i < ($type === 'larga' ? 12 : 5); $i++): ?><div></div><?php endfor; ?></div>
    <?php elseif ($type === 'crucigrama'): $p = $q['puzzle']; $cell = $crossCell($p); ?>
    <table class="grid cw">
      <?php foreach ($p['cells'] as $y => $row): ?>
      <tr><?php foreach ($row as $x => $ch): ?>
        <?php if ($ch === null): ?><td class="off" style="width: <?= $cell ?>pt; height: <?= $cell ?>pt"></td>
        <?php else: ?><td class="on" style="width: <?= $cell ?>pt; height: <?= $cell ?>pt; vertical-align: top"><div class="cwn"><?= isset($p['numbers']["$x,$y"]) ? (int) $p['numbers']["$x,$y"] : '' ?></div></td><?php endif; ?>
      <?php endforeach; ?></tr>
      <?php endforeach; ?>
    </table>
    <table class="clues"><tr>
      <td><h4><?= e(t('examenes.pdf.across')) ?></h4><?php foreach ($p['across'] as $en): ?><p><strong><?= (int) $en['n'] ?>.</strong> <?= $T($en['clue'], $L['max_em'] / 2.3) ?> <span class="qp">(<?= (int) $en['len'] ?>)</span></p><?php endforeach; ?></td>
      <td><h4><?= e(t('examenes.pdf.down')) ?></h4><?php foreach ($p['down'] as $en): ?><p><strong><?= (int) $en['n'] ?>.</strong> <?= $T($en['clue'], $L['max_em'] / 2.3) ?> <span class="qp">(<?= (int) $en['len'] ?>)</span></p><?php endforeach; ?></td>
    </tr></table>
    <?php elseif ($type === 'sopa'): $p = $q['puzzle']; $cell = $wsCell($p); ?>
    <table class="grid ws">
      <?php foreach ($p['grid'] as $row): ?><tr><?php foreach ($row as $ch): ?><td style="width: <?= $cell ?>pt; height: <?= $cell ?>pt; font-size: <?= round($cell * 0.58, 1) ?>pt"><?= e($ch) ?></td><?php endforeach; ?></tr><?php endforeach; ?>
    </table>
    <p class="wordlist"><?= e(implode(' · ', $p['words'])) ?></p>
    <?php endif; ?>
  </td>
</tr></table>
<?php endforeach; ?>
<?php endforeach; ?>

<?php if ($sheetOn): $sheet = V::sheet($version, $options); if ($sheet['bubbles'] || $sheet['boxes']): ?>
<div class="pb"></div>
<table class="hd">
  <tr>
    <td><div class="sheet-title"><?= e(t('examenes.pdf.sheet')) ?></div><div class="meta"><?= e(implode(' · ', array_filter([$header['institucion'], $header['titulo'], $header['asignatura'], $header['grado']]))) ?></div></td>
    <?php if (count($versions) > 1): ?><td class="hd-ver"><div class="ver-label"><?= e(t('examenes.pdf.version')) ?></div><div class="ver"><?= e($vlabel) ?></div></td><?php endif; ?>
  </tr>
</table>
<table class="fields">
  <tr>
    <td style="width: 62%"><?= e(t('examenes.pdf.name')) ?> <span class="fill" style="width: <?= round($c * 0.62 - 50) ?>pt">&#160;</span></td>
    <td><?= e(t('examenes.pdf.course')) ?> <span class="fill" style="width: <?= round($c * 0.38 - 50) ?>pt">&#160;</span></td>
  </tr>
</table>
<p class="sheet-note"><?= e(t('examenes.pdf.sheet_note')) ?></p>
<?php if ($sheet['bubbles']): $cols = $L['width'] < 500 ? 2 : ($options >= 5 ? 3 : 4); $per = (int) ceil(count($sheet['bubbles']) / $cols); ?>
<table class="bub-wrap"><tr>
  <?php foreach (array_chunk($sheet['bubbles'], max(1, $per)) as $col): ?>
  <td><table class="bub">
    <?php foreach ($col as $b): ?>
    <tr><td class="n"><?= (int) $b['n'] ?></td><?php foreach ($b['choices'] as $ch): ?><td><span class="bc"><?= e($ch) ?></span></td><?php endforeach; ?></tr>
    <?php endforeach; ?>
  </table></td>
  <?php endforeach; ?>
</tr></table>
<?php endif; ?>
<?php if ($sheet['boxes']): ?>
<table class="boxes">
  <?php foreach ($sheet['boxes'] as $b): ?>
  <tr><td style="width: 22pt; text-align: right"><strong><?= (int) $b['n'] ?>.</strong></td><td>
    <?php foreach ($b['labels'] as $label): ?><?= e($label) ?> <span class="bx" style="width: <?= !empty($b['small']) ? 20 : (count($b['labels']) > 1 ? min(90, floor(($c - 40) / count($b['labels']) - 26)) : round($c * 0.6)) ?>pt"></span> &#160; <?php endforeach; ?>
  </td></tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>
<?php endif; endif; ?>
<?php endforeach; ?>

<?php /* ------------------------------------------------------------ Solucionario */ ?>
<div class="pb"></div>
<div class="vstart" id="vstart-key"></div>
<div class="key-h"><?= e(t('examenes.pdf.key_title')) ?></div>
<div class="key-sub"><?= e(t('examenes.pdf.key_sub', ['title' => $header['titulo'], 'mode' => t('examenes.mode.' . $mode), 'n' => count($versions)])) ?></div>

<div class="kh2"><?= e(t('examenes.pdf.keys')) ?></div>
<?php foreach ($versions as $version): $rows = $keys[$version['index']]; $half = (int) ceil(count($rows) / 2); ?>
<?php if (count($versions) > 1): ?><div class="kh3"><?= e(t('examenes.pdf.version_n', ['v' => $version['label']])) ?></div><?php endif; ?>
<table class="kt">
  <tr><th style="width: 7%"><?= e(t('examenes.pdf.col_n')) ?></th><th style="width: 43%"><?= e(t('examenes.pdf.col_key')) ?></th><th style="width: 7%"><?= e(t('examenes.pdf.col_n')) ?></th><th><?= e(t('examenes.pdf.col_key')) ?></th></tr>
  <?php for ($i = 0; $i < $half; $i++): $a = $rows[$i]; $b = $rows[$i + $half] ?? null; ?>
  <tr>
    <td class="c"><strong><?= (int) $a['n'] ?></strong></td><td><?= $T($a['key'], $L['max_em'] / 2.4) ?></td>
    <td class="c"><?php if ($b): ?><strong><?= (int) $b['n'] ?></strong><?php endif; ?></td><td><?= $b ? $T($b['key'], $L['max_em'] / 2.4) : '' ?></td>
  </tr>
  <?php endfor; ?>
</table>
<?php endforeach; ?>

<?php if ($equiv): ?>
<div class="kh2"><?= e(t('examenes.pdf.equiv')) ?></div>
<p class="key-sub"><?= e(t('examenes.pdf.equiv_note')) ?></p>
<table class="kt">
  <tr><?php foreach ($versions as $version): ?><th class="c"><?= e(t('examenes.pdf.version_n', ['v' => $version['label']])) ?></th><?php endforeach; ?></tr>
  <?php foreach ($versions[0]['questions'] as $q0): ?>
  <tr><?php foreach ($versions as $version): ?><td class="c"><?= (int) ($equiv[$q0['slot']][$version['index']] ?? 0) ?></td><?php endforeach; ?></tr>
  <?php endforeach; ?>
</table>
<?php endif; ?>

<div class="kh2"><?= e(t('examenes.pdf.specs')) ?></div>
<table class="kt">
  <tr><th style="width: 7%"><?= e(t('examenes.pdf.col_n')) ?></th><th style="width: 26%"><?= e(t('examenes.pdf.col_type')) ?></th><th><?= e(t('examenes.pdf.col_skill')) ?></th><th style="width: 10%"><?= e(t('examenes.pdf.col_points')) ?></th></tr>
  <?php foreach ($versions[0]['questions'] as $q): ?>
  <tr><td class="c"><?= (int) $q['n'] ?></td><td><?= e($types[$q['type']] ?? '') ?></td><td><?= e($q['skill']) ?></td><td class="c"><?= e(V::points($q['points'])) ?></td></tr>
  <?php endforeach; ?>
</table>

<?php
// Soluciones: en "barajar" una sola vez (numeración de la versión A); en "distintas", por versión.
$solVersions = $mode === 'distintas' ? $versions : [$versions[0]];
?>
<div class="kh2"><?= e(t('examenes.pdf.solutions')) ?></div>
<?php foreach ($solVersions as $version): ?>
<?php if (count($solVersions) > 1): ?><div class="kh3"><?= e(t('examenes.pdf.version_n', ['v' => $version['label']])) ?></div><?php elseif ($mode === 'barajar' && count($versions) > 1): ?><p class="key-sub"><?= e(t('examenes.pdf.solutions_a')) ?></p><?php endif; ?>
<?php foreach ($version['questions'] as $q): $type = $q['type']; ?>
<div class="sol">
  <div><span class="lbl"><?= (int) $q['n'] ?>. <?= e($types[$type] ?? '') ?></span></div>
  <?php if (in_array($type, ['problema', 'abierta', 'larga', 'completar', 'corta'], true)): ?><div class="st"><?= $T($q['stem'], $L['max_em'] - 6) ?></div><?php endif; ?>
  <?php if ($type === 'unica' || $type === 'multiple'): ?>
    <div><span class="lbl"><?= e(t('examenes.pdf.correct')) ?></span> <?= e(implode(', ', array_map(fn ($i) => ExamContent::letter((int) $i), $q['key']))) ?> — <?= $T(implode(' / ', array_map(fn ($i) => $q['shown'][$i], $q['key'])), $L['max_em'] - 8) ?></div>
  <?php elseif ($type === 'vf'): ?>
    <div><span class="lbl"><?= e(t('examenes.pdf.correct')) ?></span> <?= e($q['tf'] ? t('examenes.pdf.true') : t('examenes.pdf.false')) ?></div>
  <?php elseif ($type === 'corta' || $type === 'problema' || $type === 'abierta' || $type === 'larga'): ?>
    <?php if (($q['answer'] ?? '') !== ''): ?><div><span class="lbl"><?= e(t($type === 'larga' || $type === 'abierta' ? 'examenes.pdf.model_answer' : 'examenes.pdf.answer_key')) ?></span> <?= $T($q['answer'], $L['max_em'] - 6) ?></div><?php endif; ?>
  <?php elseif ($type === 'completar'): ?>
    <div><span class="lbl"><?= e(t('examenes.pdf.answer_key')) ?></span> <?= $T(implode('; ', array_map(fn ($a, $i) => '(' . ($i + 1) . ') ' . $a, $q['blanks'], array_keys($q['blanks']))), $L['max_em'] - 6) ?></div>
  <?php elseif ($type === 'relacionar'): ?>
    <div><span class="lbl"><?= e(t('examenes.pdf.answer_key')) ?></span> <?= e(implode(', ', array_map(fn ($l, $i) => ($i + 1) . '-' . $l, $q['key'], array_keys($q['key'])))) ?></div>
  <?php elseif ($type === 'ordenar'): ?>
    <div><span class="lbl"><?= e(t('examenes.pdf.answer_key')) ?></span> <?= e(implode(' → ', $q['key'])) ?></div>
  <?php elseif ($type === 'crucigrama'): $p = $q['puzzle']; $cell = $crossCell($p); ?>
    <table class="grid cw">
      <?php foreach ($p['cells'] as $y => $row): ?>
      <tr><?php foreach ($row as $x => $ch): ?>
        <?php if ($ch === null): ?><td class="off" style="width: <?= $cell ?>pt; height: <?= $cell ?>pt"></td>
        <?php else: ?><td class="on cwl" style="width: <?= $cell ?>pt; height: <?= $cell ?>pt; font-size: <?= round($cell * 0.55, 1) ?>pt"><?= e($ch) ?></td><?php endif; ?>
      <?php endforeach; ?></tr>
      <?php endforeach; ?>
    </table>
    <?php if ($p['unplaced']): ?><div class="st"><?= e(t('examenes.pdf.unplaced', ['words' => implode(', ', $p['unplaced'])])) ?></div><?php endif; ?>
  <?php elseif ($type === 'sopa'): $p = $q['puzzle']; $cell = max(8, $wsCell($p) * 0.8);
    $hit = [];
    foreach ($p['placed'] as $pl) {
        $len = count(\App\Services\Examenes\Puzzles::letters($pl['word']));
        for ($i = 0; $i < $len; $i++) {
            $hit[($pl['x'] + $pl['dx'] * $i) . ',' . ($pl['y'] + $pl['dy'] * $i)] = true;
        }
    } ?>
    <table class="grid ws">
      <?php foreach ($p['grid'] as $y => $row): ?><tr><?php foreach ($row as $x => $ch): ?><td class="<?= isset($hit["$x,$y"]) ? 'hit' : 'miss' ?>" style="width: <?= $cell ?>pt; height: <?= $cell ?>pt; font-size: <?= round($cell * 0.58, 1) ?>pt"><?= e($ch) ?></td><?php endforeach; ?></tr><?php endforeach; ?>
    </table>
    <?php if ($p['unplaced']): ?><div class="st"><?= e(t('examenes.pdf.unplaced', ['words' => implode(', ', $p['unplaced'])])) ?></div><?php endif; ?>
  <?php endif; ?>
  <?php if (($q['solution'] ?? '') !== ''): ?><div><span class="lbl"><?= e(t($type === 'problema' ? 'examenes.pdf.solution' : 'examenes.pdf.explanation')) ?></span> <?= $T($q['solution'], $L['max_em'] - 6) ?></div><?php endif; ?>
  <?php if (!empty($q['rubric'])): ?>
    <div class="lbl"><?= e(t('examenes.pdf.rubric')) ?></div>
    <ul class="rub"><?php foreach ($q['rubric'] as $r): ?><li><?= $T($r, $L['max_em'] - 8) ?></li><?php endforeach; ?></ul>
  <?php endif; ?>
</div>
<?php endforeach; ?>
<?php endforeach; ?>
</body>
</html>
