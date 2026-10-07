<?php
/**
 * Tipos de pregunta y cantidad de cada uno, con total en vivo. @var array $in @var array $types @var array $typeHints
 * @var array|null $available máximo por tipo (simulador)
 */

use App\Services\Examenes\ExamCatalog;

$counts = (array) ($in['tipos'] ?? []);
?>
<div class="ex-types" data-ex-types>
  <?php foreach ($types as $type => $label):
      $max = ExamCatalog::TYPES[$type]['max'];
      if (isset($available)) {
          $max = min($max, (int) ($available[$type] ?? 0));
      }
      $n = min($max, (int) ($counts[$type] ?? 0)); ?>
  <div class="ex-type<?= $n > 0 ? ' is-on' : '' ?><?= $max === 0 ? ' is-off' : '' ?>">
    <div class="ex-type__text">
      <label class="ex-type__label" for="ex-t-<?= e($type) ?>"><?= e($label) ?></label>
      <p class="ex-type__hint" id="ex-t-<?= e($type) ?>-h"><?= e($typeHints[$type] ?? '') ?></p>
    </div>
    <div class="ex-num">
      <button type="button" class="ex-num__btn js-only" data-step="-1" aria-label="<?= e(t('examenes.f.less', ['type' => $label])) ?>" aria-controls="ex-t-<?= e($type) ?>"><?= icon('minus') ?></button>
      <input id="ex-t-<?= e($type) ?>" name="tipos[<?= e($type) ?>]" type="number" min="0" max="<?= $max ?>" value="<?= $n ?>" inputmode="numeric" aria-describedby="ex-t-<?= e($type) ?>-h" data-type-count="<?= e($type) ?>"<?= $max === 0 ? ' disabled' : '' ?>>
      <button type="button" class="ex-num__btn js-only" data-step="1" aria-label="<?= e(t('examenes.f.more', ['type' => $label])) ?>" aria-controls="ex-t-<?= e($type) ?>"><?= icon('plus') ?></button>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<div class="ex-total" aria-live="polite">
  <p><?= e(t('examenes.f.total_label')) ?> <strong data-ex-total><?= array_sum(array_map('intval', $counts)) ?></strong></p>
  <div class="form__row ex-total__opts">
    <label for="ex-opciones"><?= e(t('examenes.f.opciones')) ?></label>
    <select id="ex-opciones" name="opciones">
      <?php foreach (ExamCatalog::OPTION_COUNTS as $o): ?><option value="<?= $o ?>"<?= (int) ($in['opciones'] ?? 4) === $o ? ' selected' : '' ?>><?= e(t('examenes.f.opciones_n', ['n' => $o])) ?></option><?php endforeach; ?>
    </select>
  </div>
</div>
