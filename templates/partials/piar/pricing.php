<?php
/** Tarjetas de precios: prueba gratis (opcional) + paquetes. @var array $offers @var bool|null $showTrial @var array|null $customer */
$offers = $offers ?? [];
$popular = 'PIAR-10';
?>
<div class="piar-pricing<?= !empty($showTrial) ? ' piar-pricing--four' : '' ?>">
  <?php if (!empty($showTrial)): ?>
  <article class="piar-price piar-price--trial">
    <h3 class="piar-price__name"><?= e(t('piar.price.trial_name')) ?></h3>
    <p class="piar-price__amount"><?= e(t('piar.price.trial_price')) ?></p>
    <p class="piar-price__unit"><?= e(t('piar.price.trial_unit')) ?></p>
    <ul class="piar-price__list">
      <li><?= icon('check') ?><span><?= e(t('piar.price.trial_f1')) ?></span></li>
      <li class="is-off"><?= icon('minus') ?><span><?= e(t('piar.price.trial_f2')) ?></span></li>
      <li class="is-off"><?= icon('minus') ?><span><?= e(t('piar.price.trial_f3')) ?></span></li>
    </ul>
    <a class="btn btn--ghost btn--block" href="<?= e(route('piar')) ?>"><?= e(t('piar.price.trial_cta')) ?></a>
  </article>
  <?php endif; ?>
  <?php foreach ($offers as $o): $isPopular = $o['sku'] === $popular; ?>
  <article class="piar-price<?= $isPopular ? ' piar-price--popular' : '' ?>">
    <?php if ($isPopular): ?><p class="piar-price__badge"><?= e(t('piar.price.popular')) ?></p><?php endif; ?>
    <h3 class="piar-price__name"><?= e(t('piar.price.up_to', ['n' => $o['credits']])) ?></h3>
    <p class="piar-price__amount"><?= e(money($o['price_cop'], 'COP', 'es')) ?></p>
    <p class="piar-price__unit"><?= e(t('piar.price.per_month')) ?> · <?= e(t('piar.price.each', ['price' => money(round($o['price_cop'] / $o['credits']), 'COP', 'es')])) ?></p>
    <ul class="piar-price__list">
      <li><?= icon('check') ?><span><?= e(t('piar.price.f_save')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('piar.price.f_edit')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('piar.price.f_pdf')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('piar.price.f_acta')) ?></span></li>
    </ul>
    <?php if ($o['buyable']): ?>
    <a class="btn <?= $isPopular ? 'btn--buy' : 'btn--primary' ?> btn--block" href="<?= e(route('checkout', ['items' => (string) $o['product_id']], 'es')) ?>"><?= e(t('piar.price.buy')) ?></a>
    <?php else: ?>
    <span class="btn btn--ghost btn--block" aria-disabled="true"><?= e(t('piar.price.soon')) ?></span>
    <?php endif; ?>
  </article>
  <?php endforeach; ?>
</div>
<p class="piar-pricing__note"><?= icon('notice') ?><span><?= e(!empty($customer['email']) ? t('piar.price.same_email_you', ['email' => $customer['email']]) : t('piar.price.same_email')) ?></span></p>
