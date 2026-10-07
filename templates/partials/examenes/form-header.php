<?php
/**
 * Encabezado y formato. @var array $hd @var array $papers @var bool $hasLogo @var bool|null $demo
 */
$paper = $hd['papel'] ?? 'carta';
?>
<div class="ex-grid">
  <div class="form__row ex-grid__wide">
    <label for="ex-h-inst"><?= e(t('examenes.h.institucion')) ?></label>
    <input id="ex-h-inst" name="header[institucion]" type="text" maxlength="190" value="<?= e($hd['institucion'] ?? '') ?>" autocomplete="organization">
  </div>
  <div class="form__row ex-grid__wide">
    <label for="ex-h-titulo"><?= e(t('examenes.h.titulo')) ?></label>
    <input id="ex-h-titulo" name="header[titulo]" type="text" maxlength="160" value="<?= e($hd['titulo'] ?? '') ?>" placeholder="<?= e(t('examenes.h.titulo_ph')) ?>">
  </div>
  <div class="form__row">
    <label for="ex-h-asig"><?= e(t('examenes.h.asignatura')) ?></label>
    <input id="ex-h-asig" name="header[asignatura]" type="text" maxlength="80" value="<?= e($hd['asignatura'] ?? '') ?>" placeholder="<?= e(t('examenes.h.auto')) ?>">
  </div>
  <div class="form__row">
    <label for="ex-h-grado"><?= e(t('examenes.h.grado')) ?></label>
    <input id="ex-h-grado" name="header[grado]" type="text" maxlength="60" value="<?= e($hd['grado'] ?? '') ?>" placeholder="<?= e(t('examenes.h.auto')) ?>">
  </div>
  <div class="form__row">
    <label for="ex-h-docente"><?= e(t('examenes.h.docente')) ?></label>
    <input id="ex-h-docente" name="header[docente]" type="text" maxlength="120" value="<?= e($hd['docente'] ?? '') ?>" autocomplete="name">
  </div>
  <div class="form__row">
    <label for="ex-h-fecha"><?= e(t('examenes.h.fecha')) ?></label>
    <input id="ex-h-fecha" name="header[fecha]" type="date" value="<?= e($hd['fecha'] ?? '') ?>">
  </div>
  <div class="form__row">
    <label for="ex-h-dur"><?= e(t('examenes.h.duracion')) ?></label>
    <input id="ex-h-dur" name="header[duracion]" type="text" maxlength="40" value="<?= e($hd['duracion'] ?? '') ?>" placeholder="<?= e(t('examenes.h.duracion_ph')) ?>">
  </div>
  <div class="form__row ex-grid__wide">
    <label for="ex-h-instr"><?= e(t('examenes.h.instrucciones')) ?></label>
    <textarea id="ex-h-instr" name="header[instrucciones]" rows="3" maxlength="1200" placeholder="<?= e(t('examenes.pdf.default_instructions')) ?>" data-autogrow><?= e($hd['instrucciones'] ?? '') ?></textarea>
  </div>
</div>
<fieldset class="ex-papers">
  <legend class="ex-label"><?= e(t('examenes.h.papel')) ?></legend>
  <?php foreach ($papers as $k => $label): ?>
  <label class="ex-paperopt ex-paperopt--<?= e($k) ?>">
    <input type="radio" name="header[papel]" value="<?= e($k) ?>"<?= $paper === $k ? ' checked' : '' ?>>
    <span class="ex-paperopt__shape" aria-hidden="true"></span>
    <span class="ex-paperopt__label"><?= e($label) ?></span>
  </label>
  <?php endforeach; ?>
</fieldset>
<div class="ex-checks">
  <label class="ex-check"><input type="checkbox" name="header[hoja]" value="1"<?= !empty($hd['hoja']) ? ' checked' : '' ?>><span><?= e(t('examenes.h.hoja')) ?></span></label>
  <label class="ex-check"><input type="checkbox" name="header[puntaje]" value="1"<?= !empty($hd['puntaje']) ? ' checked' : '' ?>><span><?= e(t('examenes.h.puntaje')) ?></span></label>
  <label class="ex-check"><input type="checkbox" name="header[letra]" value="grande"<?= ($hd['letra'] ?? '') === 'grande' ? ' checked' : '' ?>><span><?= e(t('examenes.h.letra_grande')) ?></span></label>
  <?php if (empty($demo)): ?>
  <?php if ($hasLogo): ?>
  <label class="ex-check"><input type="checkbox" name="header[logo]" value="1"<?= !empty($hd['logo']) ? ' checked' : '' ?>><span><?= e(t('examenes.h.logo')) ?></span></label>
  <?php else: ?>
  <p class="ex-muted ex-small"><?= e(t('examenes.h.no_logo')) ?> <a href="<?= e(route('examenes.profile')) ?>"><?= e(t('examenes.h.no_logo_link')) ?></a></p>
  <?php endif; ?>
  <?php endif; ?>
</div>
