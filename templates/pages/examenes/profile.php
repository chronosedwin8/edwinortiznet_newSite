<?php
/** Perfil: institución, nombre para el encabezado y logo. @var array $customer @var array|null $profile @var array $summary @var string|null $notice @var string|null $error */

use App\Core\View;
use App\Services\Examenes\ExamProfile;

$hasLogo = !empty($profile['logo_key']);
?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'profile']) ?>
<section class="wrap ex-page page-narrow">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <p class="eyebrow"><?= e(t('examenes.brand')) ?></p>
  <h1 class="ex-title"><?= e(t('examenes.profile.title')) ?></h1>
  <p class="lead"><?= e(t('examenes.profile.lead')) ?></p>
  <form class="ex-panel form ex-form" action="<?= e(route('examenes.profile')) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form__row">
      <label for="ep-inst"><?= e(t('examenes.h.institucion')) ?></label>
      <input id="ep-inst" name="institution" type="text" maxlength="190" value="<?= e($profile['institution'] ?? '') ?>" autocomplete="organization">
    </div>
    <div class="form__row">
      <label for="ep-teacher"><?= e(t('examenes.h.docente')) ?></label>
      <input id="ep-teacher" name="teacher" type="text" maxlength="120" value="<?= e(($profile['teacher'] ?? '') ?: ($customer['name'] ?? '')) ?>" autocomplete="name">
    </div>
    <div class="form__row">
      <p class="ex-label"><?= e(t('examenes.profile.logo')) ?></p>
      <div class="ex-logo">
        <div class="ex-logo__preview" data-logo-preview><?php if ($hasLogo): ?><img src="<?= e(route('examenes.logo')) ?>?v=<?= e(substr(md5((string) $profile['logo_key']), 0, 8)) ?>" alt="<?= e(t('examenes.exam.logo_alt')) ?>"><?php else: ?><?= icon('image') ?><?php endif; ?></div>
        <div>
          <?php if ($summary['ever_paid']): ?>
          <input id="ep-logo" name="logo" type="file" accept="image/png,image/jpeg,image/webp" data-logo-input data-max="<?= ExamProfile::LOGO_MAX_BYTES ?>" data-label-size="<?= e(t('examenes.profile.logo_size')) ?>" aria-describedby="ep-logo-h">
          <p class="form-note" id="ep-logo-h"><?= e(t('examenes.profile.logo_help')) ?></p>
          <?php if ($hasLogo): ?><label class="ex-check"><input type="checkbox" name="remove_logo" value="1"><span><?= e(t('examenes.profile.remove_logo')) ?></span></label><?php endif; ?>
          <?php else: ?>
          <p class="ex-muted"><?= e(t('examenes.profile.locked')) ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <button class="btn btn--primary" type="submit"><?= e(t('examenes.profile.save')) ?></button>
  </form>
</section>
