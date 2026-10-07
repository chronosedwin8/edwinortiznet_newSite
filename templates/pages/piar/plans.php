<?php
/** Paquetes y compra. @var array|null $customer @var array|null $summary @var array $offers @var string|null $notice @var string|null $error */

use App\Core\View;

?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => 'plans']) ?>
<section class="wrap piar-page">
  <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
  <div class="piar-dash">
    <div class="piar-dash__main">
      <p class="eyebrow"><?= e(t('piar.brand')) ?></p>
      <h1 class="piar-title"><?= e(t('piar.plans.title')) ?></h1>
      <p class="lead"><?= e(t('piar.plans.lead')) ?></p>
    </div>
    <?php if ($summary): ?>
    <aside class="piar-dash__side"><?= View::render('partials/piar/meter', ['summary' => $summary]) ?></aside>
    <?php endif; ?>
  </div>
  <?= View::render('partials/piar/pricing', ['offers' => $offers, 'showTrial' => false, 'customer' => $customer]) ?>
  <?php if (!$customer): ?>
  <div class="piar-tip piar-tip--wide">
    <p><?= e(t('piar.plans.login_hint')) ?></p>
    <a class="btn btn--ghost btn--sm" href="<?= e(route('piar')) ?>"><?= e(t('piar.plans.login_cta')) ?></a>
  </div>
  <?php endif; ?>
  <div class="piar-panel piar-howbuy">
    <h2 class="piar-panel__title"><?= e(t('piar.plans.how_title')) ?></h2>
    <ol class="piar-numbered">
      <li><?= e(t('piar.plans.how1')) ?></li>
      <li><?= e(t('piar.plans.how2')) ?></li>
      <li><?= e(t('piar.plans.how3')) ?></li>
    </ol>
  </div>
</section>
