<?php
/**
 * Formulario de suscripción. El origen (tipo, ruta y título de la página) y los temas por omisión salen del
 * contexto de la página ($meta['subscribe'], ver SubscribeContext) y van en campos ocultos: la página sigue
 * siendo cacheable. main.js agrega la referencia externa y las UTM de la URL.
 * @var string $source @var string $tag @var bool $compact @var string $idPrefix @var string|null $sourceType @var bool|null $chips
 */
use App\Core\View;

$compact ??= false;
$idPrefix ??= 'sub';
$chips ??= false;
$ctx = ($meta['subscribe'] ?? null) ?: ((View::shared('meta')['subscribe'] ?? null) ?: ['type' => 'other', 'path' => \App\Services\Seo\Meta::path(), 'title' => '', 'interests' => []]);
$type = $sourceType ?? $ctx['type'];
?>
<form class="subscribe-form<?= $compact ? ' subscribe-form--compact' : '' ?>" action="<?= e(route('subscribe')) ?>" method="post" data-async-form data-sub-ctx>
  <?= csrf_field() ?>
  <?= antispam_fields() ?>
  <input type="hidden" name="source" value="<?= e($source) ?>">
  <input type="hidden" name="tag" value="<?= e($tag) ?>">
  <input type="hidden" name="source_type" value="<?= e($type) ?>">
  <input type="hidden" name="source_path" value="<?= e($ctx['path']) ?>">
  <input type="hidden" name="source_title" value="<?= e($ctx['title']) ?>">
  <input type="hidden" name="ref" value="">
  <input type="hidden" name="utm_source" value="">
  <input type="hidden" name="utm_medium" value="">
  <input type="hidden" name="utm_campaign" value="">
  <?php if ($chips): ?>
  <?= View::render('partials/interest-chips', ['idPrefix' => $idPrefix, 'checked' => $ctx['interests']]) ?>
  <?php else: foreach ($ctx['interests'] as $interest): ?>
  <input type="hidden" name="interests[]" value="<?= e($interest) ?>">
  <?php endforeach; endif; ?>
  <label class="visually-hidden" for="<?= e($idPrefix) ?>-email"><?= e(t('subscribe.email_label')) ?></label>
  <div class="subscribe-form__row">
    <input id="<?= e($idPrefix) ?>-email" type="email" name="email" required autocomplete="email" placeholder="<?= e(t('subscribe.placeholder')) ?>">
    <button type="submit" class="btn btn--primary"><?= e(t('subscribe.button')) ?></button>
  </div>
  <?= View::render('partials/turnstile') ?>
  <p class="form-note"><?= e(t('subscribe.note')) ?></p>
  <p class="form-status" data-form-status role="status" aria-live="polite"></p>
</form>
