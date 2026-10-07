<?php
/**
 * Número de versiones y modo. @var array $in @var int $maxVersions @var int $maxQuestions (0: sin límite que mostrar)
 */
$versions = max(1, min($maxVersions, (int) ($in['versiones'] ?? 2)));
$mode = ($in['modo'] ?? 'barajar') === 'distintas' ? 'distintas' : 'barajar';
?>
<div class="form__row">
  <label for="ex-versiones"><?= e(t('examenes.f.versiones')) ?></label>
  <p class="form-note"><?= e(t('examenes.f.versiones_help', ['n' => $maxVersions])) ?></p>
  <select id="ex-versiones" name="versiones" data-ex-versions>
    <?php for ($i = 1; $i <= $maxVersions; $i++): ?><option value="<?= $i ?>"<?= $versions === $i ? ' selected' : '' ?>><?= e(t($i === 1 ? 'examenes.f.versions_one' : 'examenes.f.versions_n', ['n' => $i, 'letters' => implode(', ', array_slice(\App\Services\Examenes\ExamCatalog::VERSION_LABELS, 0, $i))])) ?></option><?php endfor; ?>
  </select>
</div>
<fieldset class="ex-modes">
  <legend class="ex-label"><?= e(t('examenes.f.modo')) ?></legend>
  <label class="ex-mode">
    <input type="radio" name="modo" value="barajar"<?= $mode === 'barajar' ? ' checked' : '' ?> data-ex-mode>
    <span class="ex-mode__body">
      <span class="ex-mode__title"><?= icon('shuffle') ?><?= e(t('examenes.mode.barajar')) ?></span>
      <span class="ex-mode__text"><?= e(t('examenes.f.barajar_help')) ?></span>
    </span>
  </label>
  <label class="ex-mode">
    <input type="radio" name="modo" value="distintas"<?= $mode === 'distintas' ? ' checked' : '' ?> data-ex-mode>
    <span class="ex-mode__body">
      <span class="ex-mode__title"><?= icon('layers') ?><?= e(t('examenes.mode.distintas')) ?></span>
      <span class="ex-mode__text"><?= e(t('examenes.f.distintas_help')) ?></span>
    </span>
  </label>
</fieldset>
<p class="ex-unique" data-ex-unique data-max="<?= (int) $maxQuestions ?>" data-label="<?= e(t('examenes.f.unique', ['n' => ':n', 'max' => ':max'])) ?>" data-label-nomax="<?= e(t('examenes.f.unique_nomax', ['n' => ':n'])) ?>" data-label-over="<?= e(t('examenes.f.unique_over')) ?>" aria-live="polite"></p>
