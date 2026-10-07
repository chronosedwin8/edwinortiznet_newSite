<?php
/** Perfil de la institución (con paquete activo). @var array $customer @var array|null $profile @var array $summary @var string|null $notice @var string|null $error */

use App\Core\View;

$locked = !$summary['has_active'];
$hasLogo = !empty($profile['logo_key']);
?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => 'profile']) ?>
<section class="wrap piar-page">
  <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
  <div class="piar-dash">
    <div class="piar-dash__main">
      <p class="eyebrow"><?= e(t('piar.brand')) ?></p>
      <h1 class="piar-title"><?= e(t('piar.profile.title')) ?></h1>
      <p class="lead"><?= e(t('piar.profile.lead')) ?></p>
      <?php if ($locked): ?>
      <div class="piar-tip piar-tip--locked">
        <p><strong><?= e(t('piar.profile.locked_title')) ?>.</strong> <?= e(t('piar.profile.locked')) ?></p>
        <a class="btn btn--buy btn--sm" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.meter.buy')) ?></a>
      </div>
      <?php endif; ?>
      <form class="piar-panel piar-form piar-profile<?= $locked ? ' is-locked' : '' ?>" action="<?= e(route('piar.profile')) ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <fieldset class="piar-profile__fields"<?= $locked ? ' disabled' : '' ?>>
          <div class="form__row">
            <label for="pp-institution"><?= e(t('piar.profile.institution')) ?></label>
            <input id="pp-institution" name="institution" type="text" maxlength="190" value="<?= e($profile['institution'] ?? '') ?>">
          </div>
          <div class="form__row">
            <label for="pp-city"><?= e(t('piar.profile.city')) ?></label>
            <input id="pp-city" name="city" type="text" maxlength="120" value="<?= e($profile['city'] ?? '') ?>">
          </div>
          <div class="form__row">
            <p class="piar-label"><?= e(t('piar.profile.logo')) ?></p>
            <div class="piar-logo">
              <div class="piar-logo__preview" data-logo-preview>
                <?php if ($hasLogo): ?><img src="<?= e(route('piar.logo')) ?>?v=<?= e(substr(md5((string) $profile['logo_key']), 0, 8)) ?>" alt="<?= e(t('piar.profile.logo_current')) ?>"><?php else: ?><span><?= e(t('piar.profile.logo_none')) ?></span><?php endif; ?>
              </div>
              <div class="piar-logo__input">
                <label class="visually-hidden" for="pp-logo"><?= e(t('piar.profile.logo')) ?></label>
                <input id="pp-logo" name="logo" type="file" accept="image/png,image/jpeg,image/webp" data-logo-input data-max="<?= \App\Services\Piar\PiarProfile::LOGO_MAX_BYTES ?>" data-label-size="<?= e(t('piar.profile.logo_size')) ?>" aria-describedby="pp-logo-h">
                <p class="form-note" id="pp-logo-h"><?= e(t('piar.profile.logo_help')) ?></p>
                <?php if ($hasLogo): ?>
                <div class="piar-check"><input id="pp-remove" type="checkbox" name="remove_logo" value="1"><label for="pp-remove"><?= e(t('piar.profile.remove_logo')) ?></label></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <button class="btn btn--primary btn--lg" type="submit"><?= e(t('piar.profile.save')) ?></button>
        </fieldset>
      </form>
    </div>
    <aside class="piar-dash__side">
      <?= View::render('partials/piar/meter', ['summary' => $summary]) ?>
      <div class="piar-tip">
        <p class="piar-label"><?= e(t('piar.profile.account')) ?></p>
        <p><?= e($customer['name'] ?? '') ?><br><span class="piar-muted"><?= e($customer['email']) ?></span></p>
        <?php if (!empty($profile['terms_accepted_at'])): ?><p class="piar-muted piar-small"><?= e(t('piar.profile.terms', ['date' => fdate($profile['terms_accepted_at'], 'long')])) ?></p><?php endif; ?>
      </div>
    </aside>
  </div>
</section>
