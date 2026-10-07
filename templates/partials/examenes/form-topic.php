<?php
/**
 * Tema específico y contexto (texto libre) más alcance, propósito, dificultad y estilo.
 * @var array $in @var array $examples @var array $scopes @var array $purposes @var array $difficulties @var array $styles
 */

use App\Services\Examenes\Exams;

$subject = (string) (($in['materia'] ?? '') ?: 'matematicas');
[$topicPh, $contextPh] = $examples[$subject] ?? $examples['matematicas'];
$sel = static fn (string $name, array $options, string $current, string $id): string => '<select id="' . e($id) . '" name="' . e($name) . '">'
    . implode('', array_map(fn ($k, $label) => '<option value="' . e($k) . '"' . ($current === (string) $k ? ' selected' : '') . '>' . e($label) . '</option>', array_keys($options), $options))
    . '</select>';
?>
<div class="form__row">
  <label for="ex-tema"><?= e(t('examenes.f.tema')) ?> <span class="ex-req"><?= e(t('examenes.f.required')) ?></span></label>
  <p class="form-note" id="ex-tema-h"><?= e(t('examenes.f.tema_help')) ?></p>
  <input id="ex-tema" name="tema" type="text" required minlength="3" maxlength="<?= Exams::MAX_TOPIC ?>" value="<?= e($in['tema'] ?? '') ?>"
         placeholder="<?= e($topicPh) ?>" aria-describedby="ex-tema-h ex-tema-c" data-ex-topic data-count>
  <p class="ex-counter" id="ex-tema-c" aria-live="polite"></p>
</div>
<div class="form__row">
  <label for="ex-contexto"><?= e(t('examenes.f.contexto')) ?> <span class="ex-opt-tag"><?= e(t('examenes.f.recommended')) ?></span></label>
  <p class="form-note" id="ex-contexto-h"><?= e(t('examenes.f.contexto_help')) ?></p>
  <textarea id="ex-contexto" name="contexto" rows="6" maxlength="<?= Exams::MAX_CONTEXT ?>" placeholder="<?= e($contextPh) ?>" aria-describedby="ex-contexto-h ex-contexto-c" data-ex-context data-count data-autogrow><?= e($in['contexto'] ?? '') ?></textarea>
  <p class="ex-counter" id="ex-contexto-c" aria-live="polite"></p>
  <ul class="ex-ideas" aria-label="<?= e(t('examenes.f.contexto_ideas')) ?>">
    <li><?= e(t('examenes.f.idea1')) ?></li>
    <li><?= e(t('examenes.f.idea2')) ?></li>
    <li><?= e(t('examenes.f.idea3')) ?></li>
    <li><?= e(t('examenes.f.idea4')) ?></li>
  </ul>
</div>
<div class="ex-grid">
  <div class="form__row"><label for="ex-alcance"><?= e(t('examenes.f.alcance')) ?></label><?= $sel('alcance', $scopes, (string) ($in['alcance'] ?? 'unidad'), 'ex-alcance') ?></div>
  <div class="form__row"><label for="ex-proposito"><?= e(t('examenes.f.proposito')) ?></label><?= $sel('proposito', $purposes, (string) ($in['proposito'] ?? 'sumativa'), 'ex-proposito') ?></div>
  <div class="form__row"><label for="ex-dificultad"><?= e(t('examenes.f.dificultad')) ?></label><?= $sel('dificultad', $difficulties, (string) ($in['dificultad'] ?? 'medio'), 'ex-dificultad') ?></div>
  <div class="form__row"><label for="ex-estilo"><?= e(t('examenes.f.estilo')) ?></label><?= $sel('estilo', $styles, (string) ($in['estilo'] ?? 'mixto'), 'ex-estilo') ?></div>
</div>
