<?php
/** Examen en preparación o fallido. @var array $customer @var array $exam @var array $summary @var string|null $notice @var string|null $error */

use App\Core\View;

?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap ex-page">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <?php if ($exam['status'] === 'pending'): ?>
  <?= View::render('partials/examenes/progress', ['statusUrl' => route('examenes.status', ['uuid' => $exam['uuid']])]) ?>
  <?php else: ?>
  <div class="ex-panel ex-failed">
    <span class="ex-locked__icon" aria-hidden="true"><?= icon('notice') ?></span>
    <h1 class="ex-title ex-title--sm"><?= e(t('examenes.progress.failed_title')) ?></h1>
    <p><?= e(t('examenes.progress.failed')) ?></p>
    <p class="ex-muted"><?= e(t('examenes.progress.failed_quota')) ?></p>
    <div class="ex-actions">
      <a class="btn btn--primary" href="<?= e(route('examenes.new') . '?desde=' . $exam['uuid']) ?>"><?= icon('undo') ?><?= e(t('examenes.progress.retry')) ?></a>
      <a class="btn btn--ghost" href="<?= e(route('examenes')) ?>"><?= e(t('examenes.nav.home')) ?></a>
    </div>
  </div>
  <?php endif; ?>
</section>
