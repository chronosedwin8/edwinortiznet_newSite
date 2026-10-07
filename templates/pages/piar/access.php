<?php
/** Acceso (sin sesión): nombre, correo y términos → enlace mágico. @var array $old @var string|null $notice @var string|null $error */

use App\Core\Session;
use App\Core\View;

$sent = $notice !== null && Session::get('piar_sent') !== null;
?>
<?= View::render('partials/piar/bar', ['customer' => null, 'active' => 'home']) ?>
<section class="wrap piar-page piar-access">
  <div class="piar-access__intro">
    <p class="eyebrow"><?= e(t('piar.brand')) ?></p>
    <h1 class="piar-title"><?= e(t('piar.access.title')) ?></h1>
    <p class="lead"><?= e(t('piar.access.lead')) ?></p>
    <ul class="piar-checklist">
      <li><?= icon('check') ?><span><?= e(t('piar.access.b1')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('piar.access.b2')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('piar.access.b3')) ?></span></li>
    </ul>
  </div>
  <div class="piar-panel piar-access__card">
    <?php if ($sent): ?>
    <div class="piar-sent" role="status">
      <span class="piar-sent__icon" aria-hidden="true"><?= icon('mail') ?></span>
      <h2 class="piar-panel__title"><?= e(t('piar.access.sent_title')) ?></h2>
      <p><?= e($notice) ?></p>
      <p class="piar-muted"><?= e(t('piar.access.sent_hint')) ?></p>
    </div>
    <?php else: ?>
    <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
    <?php endif; ?>
    <?php if (!empty($admin) && !$sent): ?>
    <form class="piar-admin-entry" action="<?= e(route('piar.access.admin')) ?>" method="post">
      <?= csrf_field() ?>
      <p class="piar-muted"><?= e(t('piar.access.admin_hint', ['email' => $admin['email']])) ?></p>
      <button class="btn btn--primary btn--lg btn--block" type="submit"><?= e(t('piar.access.admin_submit')) ?></button>
      <p class="piar-muted"><?= e(t('piar.access.admin_or')) ?></p>
    </form>
    <?php endif; ?>
    <form class="form piar-form" action="<?= e(route('piar.access')) ?>" method="post"<?= $sent ? ' hidden' : '' ?>>
      <?= csrf_field() ?>
      <div class="form__row">
        <label for="pa-name"><?= e(t('piar.access.name')) ?></label>
        <input id="pa-name" name="name" type="text" required minlength="2" maxlength="120" autocomplete="name" value="<?= e($old['name'] ?? '') ?>">
      </div>
      <div class="form__row">
        <label for="pa-email"><?= e(t('piar.access.email')) ?></label>
        <input id="pa-email" name="email" type="email" required maxlength="190" autocomplete="email" value="<?= e($old['email'] ?? '') ?>">
      </div>
      <div class="piar-check">
        <input id="pa-terms" type="checkbox" name="terms" value="1" required>
        <label for="pa-terms"><?= t('piar.access.terms', [
            'terms' => '<a href="' . e(route('policy', ['slug' => 'terminos'], 'es')) . '" target="_blank">' . e(t('piar.access.terms_link')) . '</a>',
            'privacy' => '<a href="' . e(route('policy', ['slug' => 'privacidad'], 'es')) . '" target="_blank">' . e(t('piar.access.privacy_link')) . '</a>',
        ]) ?></label>
      </div>
      <button class="btn btn--primary btn--lg btn--block" type="submit"><?= icon('mail') ?><?= e(t('piar.access.submit')) ?></button>
    </form>
  </div>
</section>
