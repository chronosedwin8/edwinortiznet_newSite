<?php
/** Acceso (sin sesión): nombre, correo y términos → enlace mágico. @var array $old @var array|null $admin @var string|null $notice @var string|null $error */

use App\Core\Session;
use App\Core\View;

$sent = $notice !== null && Session::get('examenes_sent') !== null;
?>
<?= View::render('partials/examenes/bar', ['customer' => null, 'active' => 'home']) ?>
<section class="wrap ex-page ex-access">
  <div class="ex-access__intro">
    <p class="eyebrow"><?= e(t('examenes.brand')) ?></p>
    <h1 class="ex-title"><?= e(t('examenes.access.title')) ?></h1>
    <p class="lead"><?= e(t('examenes.access.lead')) ?></p>
    <ul class="ex-checklist">
      <li><?= icon('check') ?><span><?= e(t('examenes.access.b1')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('examenes.access.b2')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('examenes.access.b3')) ?></span></li>
    </ul>
    <p class="ex-access__demo"><a class="btn btn--ghost" href="<?= e(route('examenes.demo')) ?>"><?= icon('eye') ?><?= e(t('examenes.access.demo')) ?></a></p>
  </div>
  <div class="ex-panel ex-access__card">
    <?php if ($sent): ?>
    <div class="ex-sent" role="status">
      <span class="ex-sent__icon" aria-hidden="true"><?= icon('mail') ?></span>
      <h2 class="ex-panel__title"><?= e(t('examenes.access.sent_title')) ?></h2>
      <p><?= e($notice) ?></p>
      <p class="ex-muted"><?= e(t('examenes.access.sent_hint')) ?></p>
    </div>
    <?php else: ?>
    <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
    <?php endif; ?>
    <?php if (!empty($admin) && !$sent): ?>
    <form class="ex-admin-entry" action="<?= e(route('examenes.access.admin')) ?>" method="post">
      <?= csrf_field() ?>
      <p class="ex-muted"><?= e(t('examenes.access.admin_hint', ['email' => $admin['email']])) ?></p>
      <button class="btn btn--primary btn--lg btn--block" type="submit"><?= e(t('examenes.access.admin_submit')) ?></button>
      <p class="ex-muted"><?= e(t('examenes.access.admin_or')) ?></p>
    </form>
    <?php endif; ?>
    <form class="form ex-form" action="<?= e(route('examenes.access')) ?>" method="post"<?= $sent ? ' hidden' : '' ?>>
      <?= csrf_field() ?>
      <div class="form__row">
        <label for="ea-name"><?= e(t('examenes.access.name')) ?></label>
        <input id="ea-name" name="name" type="text" required minlength="2" maxlength="120" autocomplete="name" value="<?= e($old['name'] ?? '') ?>">
      </div>
      <div class="form__row">
        <label for="ea-email"><?= e(t('examenes.access.email')) ?></label>
        <input id="ea-email" name="email" type="email" required maxlength="190" autocomplete="email" value="<?= e($old['email'] ?? '') ?>">
      </div>
      <div class="ex-consent">
        <input id="ea-terms" type="checkbox" name="terms" value="1" required>
        <label for="ea-terms"><?= t('examenes.access.terms', [
            'terms' => '<a href="' . e(route('policy', ['slug' => 'terminos'], 'es')) . '" target="_blank">' . e(t('examenes.access.terms_link')) . '</a>',
            'privacy' => '<a href="' . e(route('policy', ['slug' => 'privacidad'], 'es')) . '" target="_blank">' . e(t('examenes.access.privacy_link')) . '</a>',
        ]) ?></label>
      </div>
      <button class="btn btn--primary btn--lg btn--block" type="submit"><?= icon('mail') ?><?= e(t('examenes.access.submit')) ?></button>
    </form>
  </div>
</section>
