<?php
/**
 * Solucionario en pantalla: claves de todas las versiones y soluciones (en «barajar», una vez con la numeración A).
 * @var array $versions @var array $keys @var array $types @var string $mode
 */

use App\Core\View;
use App\Services\Examenes\ExamContent;
use App\Services\Examenes\ExamView as V;

$T = static fn (string $s): string => V::text($s, 'screen');
$solVersions = $mode === 'distintas' ? $versions : [$versions[0]];
$equiv = $mode === 'barajar' && count($versions) > 1 ? ExamContent::equivalences($versions) : [];
?>
<section class="ex-key" aria-labelledby="ex-key-title">
  <h2 id="ex-key-title" class="ex-key__title"><?= e(t('examenes.pdf.keys')) ?></h2>
  <div class="ex-key__grid">
    <?php foreach ($versions as $version): ?>
    <div class="ex-key__card">
      <?php if (count($versions) > 1): ?><p class="ex-key__ver"><?= e(t('examenes.pdf.version_n', ['v' => $version['label']])) ?></p><?php endif; ?>
      <ol class="ex-key__list">
        <?php foreach ($keys[$version['label']] as $row): ?>
        <li><span class="ex-key__n"><?= (int) $row['n'] ?></span><span class="ex-key__a"><?= $T($row['key']) ?></span></li>
        <?php endforeach; ?>
      </ol>
    </div>
    <?php endforeach; ?>
  </div>
  <?php if ($equiv): ?>
  <h3 class="ex-key__sub"><?= e(t('examenes.pdf.equiv')) ?></h3>
  <p class="ex-muted"><?= e(t('examenes.pdf.equiv_note')) ?></p>
  <div class="ex-table-wrap">
    <table class="ex-table">
      <thead><tr><?php foreach ($versions as $version): ?><th scope="col"><?= e(t('examenes.pdf.version_n', ['v' => $version['label']])) ?></th><?php endforeach; ?></tr></thead>
      <tbody><?php foreach ($versions[0]['questions'] as $q0): ?><tr><?php foreach ($versions as $version): ?><td><?= (int) ($equiv[$q0['slot']][$version['index']] ?? 0) ?></td><?php endforeach; ?></tr><?php endforeach; ?></tbody>
    </table>
  </div>
  <?php endif; ?>
  <h3 class="ex-key__sub"><?= e(t('examenes.pdf.solutions')) ?></h3>
  <?php foreach ($solVersions as $version): ?>
  <?php if (count($solVersions) > 1): ?><p class="ex-key__ver"><?= e(t('examenes.pdf.version_n', ['v' => $version['label']])) ?></p><?php elseif ($mode === 'barajar' && count($versions) > 1): ?><p class="ex-muted"><?= e(t('examenes.pdf.solutions_a')) ?></p><?php endif; ?>
  <div class="ex-sols">
    <?php foreach ($version['questions'] as $q): ?>
    <details class="ex-sol">
      <summary><span class="ex-sol__n"><?= (int) $q['n'] ?>.</span> <span class="ex-sol__type"><?= e($types[$q['type']] ?? '') ?></span><?php if ($q['skill'] !== ''): ?> <span class="ex-sol__skill"><?= e($q['skill']) ?></span><?php endif; ?></summary>
      <?= View::render('partials/examenes/question', ['q' => $q, 'points' => false, 'showKey' => true]) ?>
      <?php if (($q['answer'] ?? '') !== '' && !in_array($q['type'], ['corta'], true)): ?><p><strong><?= e(t(in_array($q['type'], ['abierta', 'larga'], true) ? 'examenes.pdf.model_answer' : 'examenes.pdf.answer_key')) ?></strong> <?= $T($q['answer']) ?></p><?php endif; ?>
      <?php if (($q['solution'] ?? '') !== ''): ?><div class="ex-sol__text"><strong><?= e(t($q['type'] === 'problema' ? 'examenes.pdf.solution' : 'examenes.pdf.explanation')) ?></strong> <?= $T($q['solution']) ?></div><?php endif; ?>
      <?php if (!empty($q['rubric'])): ?><p><strong><?= e(t('examenes.pdf.rubric')) ?></strong></p><ul class="ex-rubric"><?php foreach ($q['rubric'] as $r): ?><li><?= $T($r) ?></li><?php endforeach; ?></ul><?php endif; ?>
    </details>
    <?php endforeach; ?>
  </div>
  <?php endforeach; ?>
</section>
