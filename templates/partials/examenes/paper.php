<?php
/**
 * Una versión del examen como hoja en pantalla. @var array $version @var array $header @var array $types @var int $count versiones
 * @var bool|null $demo @var bool|null $logoUrl
 */

use App\Core\View;
use App\Services\Examenes\ExamView as V;

$date = V::date($header['fecha']);
$sheet = !empty($header['hoja']);
$pts = !empty($header['puntaje']);
?>
<article class="ex-paper ex-paper--<?= e($header['papel']) ?><?= $header['letra'] === 'grande' ? ' ex-paper--big' : '' ?><?= !empty($demo) ? ' ex-paper--demo' : '' ?>" aria-label="<?= e(t('examenes.exam.version_aria', ['v' => $version['label']])) ?>">
  <?php if (!empty($demo)): ?><span class="ex-paper__demo" aria-hidden="true"><?= e(t('examenes.demo.watermark')) ?></span><?php endif; ?>
  <header class="ex-head">
    <?php if (!empty($logoUrl)): ?><img class="ex-head__logo" src="<?= e($logoUrl) ?>" alt="<?= e(t('examenes.exam.logo_alt')) ?>" width="64" height="64"><?php endif; ?>
    <div class="ex-head__main">
      <?php if ($header['institucion'] !== ''): ?><p class="ex-head__inst"><?= e($header['institucion']) ?></p><?php endif; ?>
      <p class="ex-head__title"><?= e($header['titulo']) ?></p>
      <p class="ex-head__meta"><?= e(implode(' · ', array_filter([$header['asignatura'], $header['grado'], $header['docente'] !== '' ? t('examenes.pdf.teacher', ['name' => $header['docente']]) : '']))) ?></p>
    </div>
    <?php if ($count > 1): ?><p class="ex-head__ver"><span><?= e(t('examenes.pdf.version')) ?></span><strong><?= e($version['label']) ?></strong></p><?php endif; ?>
  </header>
  <dl class="ex-fields">
    <div class="ex-fields__wide"><dt><?= e(t('examenes.pdf.name')) ?></dt><dd></dd></div>
    <div><dt><?= e(t('examenes.pdf.course')) ?></dt><dd></dd></div>
    <div><dt><?= e(t('examenes.pdf.date')) ?></dt><dd><?= e($date) ?></dd></div>
    <?php if ($header['duracion'] !== ''): ?><div><dt><?= e(t('examenes.exam.time')) ?></dt><dd><?= e($header['duracion']) ?></dd></div><?php endif; ?>
    <div><dt><?= e(t('examenes.pdf.grade_mark')) ?></dt><dd><?php if ($pts): ?><span class="ex-fields__total">/ <?= e(V::points($version['points'])) ?></span><?php endif; ?></dd></div>
  </dl>
  <?php if ($header['instrucciones'] !== ''): ?>
  <p class="ex-instr"><strong><?= e(t('examenes.pdf.instructions')) ?></strong> <?= V::text($header['instrucciones']) ?><?php if ($sheet): ?> <?= e(t('examenes.pdf.instructions_sheet')) ?><?php endif; ?></p>
  <?php endif; ?>
  <?php foreach ($version['sections'] as $si => $section): ?>
  <section class="ex-sec">
    <h3 class="ex-sec__title"><?= e(V::roman($si)) ?>. <?= e($types[$section['type']] ?? '') ?><?php if ($pts): ?> <span class="ex-q__pts"><?= e(V::pointsLabel(array_sum(array_column($section['questions'], 'points')))) ?></span><?php endif; ?></h3>
    <p class="ex-sec__hint"><?= e(V::sectionHint($section['type'], $sheet)) ?></p>
    <?php foreach ($section['questions'] as $q): ?>
    <?= View::render('partials/examenes/question', ['q' => $q, 'points' => $pts]) ?>
    <?php endforeach; ?>
  </section>
  <?php endforeach; ?>
</article>
