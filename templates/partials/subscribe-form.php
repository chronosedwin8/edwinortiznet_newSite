<?php
/** @var string $source @var string $tag @var bool $compact @var string $idPrefix */
$compact ??= false;
$idPrefix ??= 'sub';
?>
<form class="subscribe-form<?= $compact ? ' subscribe-form--compact' : '' ?>" action="<?= e(route('subscribe')) ?>" method="post" data-async-form>
  <?= csrf_field() ?>
  <?= antispam_fields() ?>
  <input type="hidden" name="source" value="<?= e($source) ?>">
  <input type="hidden" name="tag" value="<?= e($tag) ?>">
  <label class="visually-hidden" for="<?= e($idPrefix) ?>-email"><?= e(t('subscribe.email_label')) ?></label>
  <div class="subscribe-form__row">
    <input id="<?= e($idPrefix) ?>-email" type="email" name="email" required autocomplete="email" placeholder="<?= e(t('subscribe.placeholder')) ?>">
    <button type="submit" class="btn btn--primary"><?= e(t('subscribe.button')) ?></button>
  </div>
  <p class="form-note"><?= e(t('subscribe.note')) ?></p>
  <p class="form-status" data-form-status role="status" aria-live="polite"></p>
</form>
