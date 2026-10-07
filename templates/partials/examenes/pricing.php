<?php
/** Tarjetas de los planes. @var array $offers @var array|null $customer */

use App\Services\Examenes\ExamCredits;

$offers = $offers ?? [];
?>
<div class="ex-pricing">
  <?php foreach ($offers as $o): $isPopular = $o['sku'] === ExamCredits::POPULAR; $key = strtolower(str_replace('-', '_', $o['sku'])); ?>
  <article class="ex-price<?= $isPopular ? ' ex-price--popular' : '' ?>">
    <?php if ($isPopular): ?><p class="ex-price__badge"><?= e(t('examenes.price.popular')) ?></p><?php endif; ?>
    <h3 class="ex-price__name"><?= e(t('examenes.price.plan_' . $key)) ?></h3>
    <p class="ex-price__amount"><?= e(money($o['price_cop'], 'COP', 'es')) ?></p>
    <p class="ex-price__unit"><?= e(t('examenes.price.per_month')) ?> · <?= e(t('examenes.price.each', ['price' => money(round($o['price_cop'] / $o['exams']), 'COP', 'es')])) ?></p>
    <ul class="ex-price__list">
      <li><?= icon('check') ?><span><?= e(t('examenes.price.f_exams', ['n' => $o['exams']])) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('examenes.price.f_versions', ['n' => $o['versions']])) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('examenes.price.f_questions', ['n' => $o['questions']])) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('examenes.price.f_extra', ['n' => $o['extra']])) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('examenes.price.f_pdf')) ?></span></li>
      <li><?= icon('check') ?><span><?= e(t('examenes.price.f_latex')) ?></span></li>
    </ul>
    <?php if ($o['buyable']): ?>
    <a class="btn <?= $isPopular ? 'btn--buy' : 'btn--primary' ?> btn--block" href="<?= e(route('checkout', ['items' => (string) $o['product_id']], 'es')) ?>"><?= e(t('examenes.price.buy')) ?></a>
    <?php else: ?>
    <span class="btn btn--ghost btn--block" aria-disabled="true"><?= e(t('examenes.price.soon')) ?></span>
    <?php endif; ?>
  </article>
  <?php endforeach; ?>
</div>
<p class="ex-pricing__note"><?= icon('notice') ?><span><?= e(!empty($customer['email']) ? t('examenes.price.same_email_you', ['email' => $customer['email']]) : t('examenes.price.same_email')) ?></span></p>
