<?php
/**
 * Materia y grado. @var array $in @var array $subjects @var array $grades
 */
$materia = (string) ($in['materia'] ?? '');
?>
<div class="ex-grid">
  <div class="form__row">
    <label for="ex-materia"><?= e(t('examenes.f.materia')) ?> <span class="ex-req"><?= e(t('examenes.f.required')) ?></span></label>
    <select id="ex-materia" name="materia" required data-ex-subject>
      <option value=""><?= e(t('examenes.f.choose')) ?></option>
      <?php foreach ($subjects as $k => $label): ?><option value="<?= e($k) ?>"<?= $materia === $k ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
    </select>
  </div>
  <div class="form__row" data-ex-other<?= $materia === 'otra' ? '' : ' hidden' ?>>
    <label for="ex-materia-otra"><?= e(t('examenes.f.materia_otra')) ?></label>
    <input id="ex-materia-otra" name="materia_otra" type="text" maxlength="80" value="<?= e($in['materia_otra'] ?? '') ?>" placeholder="<?= e(t('examenes.f.materia_otra_ph')) ?>">
  </div>
  <div class="form__row">
    <label for="ex-grado"><?= e(t('examenes.f.grado')) ?> <span class="ex-req"><?= e(t('examenes.f.required')) ?></span></label>
    <select id="ex-grado" name="grado" required>
      <option value=""><?= e(t('examenes.f.choose')) ?></option>
      <?php foreach ($grades as $k => $label): ?><option value="<?= e($k) ?>"<?= (string) ($in['grado'] ?? '') === (string) $k ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
    </select>
  </div>
</div>
<p class="ex-tip"><?= icon('notice') ?><span><?= e(t('examenes.f.latex_tip')) ?></span></p>
