<?php
/** Planes y compra. @var array|null $customer @var array|null $summary @var array $offers @var string|null $notice @var string|null $error */

use App\Core\View;

?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'plans']) ?>
<section class="wrap ex-page">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <div class="ex-dash">
    <div class="ex-dash__main">
      <p class="eyebrow"><?= e(t('examenes.brand')) ?></p>
      <h1 class="ex-title"><?= e(t('examenes.plans.title')) ?></h1>
      <p class="lead"><?= e(t('examenes.plans.lead')) ?></p>
    </div>
    <?php if ($summary): ?><aside class="ex-dash__side"><?= View::render('partials/examenes/meter', ['summary' => $summary]) ?></aside><?php endif; ?>
  </div>
  <?= View::render('partials/examenes/pricing', ['offers' => $offers, 'customer' => $customer]) ?>
  <div class="ex-panel ex-howbuy">
    <h2 class="ex-panel__title"><?= e(t('examenes.plans.how_title')) ?></h2>
    <ol class="ex-numbered">
      <li><?= e(t('examenes.plans.how1')) ?></li>
      <li><?= e(t('examenes.plans.how2')) ?></li>
      <li><?= e(t('examenes.plans.how3')) ?></li>
      <li><?= e(t('examenes.plans.how4')) ?></li>
    </ol>
    <p class="ex-muted"><?= e(t('examenes.plans.unique_note')) ?></p>
  </div>
  <?php if (!$customer): ?>
  <div class="ex-tipbox ex-tipbox--wide">
    <p><?= e(t('examenes.plans.login_hint')) ?></p>
    <a class="btn btn--ghost btn--sm" href="<?= e(route('examenes')) ?>"><?= e(t('examenes.plans.login_cta')) ?></a>
  </div>
  <?php endif; ?>
</section>
