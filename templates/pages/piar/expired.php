<?php
/** Prueba ya no visible (otra sesión o purgada). @var array $customer @var array $summary */

use App\Core\View;

?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap piar-page page-narrow">
  <div class="piar-panel piar-failed">
    <span class="piar-failed__icon" aria-hidden="true"><?= icon('clock') ?></span>
    <h1 class="piar-title piar-title--sm"><?= e(t('piar.expired.title')) ?></h1>
    <p><?= e(t('piar.expired.text')) ?></p>
    <div class="piar-actions">
      <a class="btn btn--buy btn--lg" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.trial.cta')) ?></a>
      <a class="btn btn--ghost btn--lg" href="<?= e(route('piar')) ?>"><?= e(t('piar.plan.back')) ?></a>
    </div>
  </div>
</section>
