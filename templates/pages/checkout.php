<?php
/** @var array $cart @var array $gateways @var array $errors @var array $old @var array $crumbs */

use App\Services\I18n\I18n;

$locale = I18n::locale();
$ids = implode(',', array_map(fn ($p) => (string) $p['line_key'], $cart['items']));
$old += ['name' => '', 'email' => '', 'document' => '', 'phone' => '', 'gateway' => $gateways[0] ?? ''];
$totalLabel = money($cart['total'], $cart['currency']);
$err = static fn (string $k): string => isset($errors[$k]) ? '<p class="field-error" id="err-' . e($k) . '">' . e($errors[$k]) . '</p>' : '';
?>
<section class="wrap" data-checkout-page data-has-items="<?= $cart['items'] ? '1' : '0' ?>">
  <header class="listing__header" style="margin-top:24px">
    <?= \App\Core\View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="listing__title"><?= e(t('checkout.title')) ?></h1>
    <p class="lead"><?= e(t('checkout.lead')) ?></p>
  </header>

  <?php if (!empty($errors['form'])): ?><p class="notice notice--error" role="alert"><?= e($errors['form']) ?></p><?php endif; ?>
  <?php if (!empty($cart['needs_variant'])): ?>
  <div class="notice notice--info" role="status"><p><?= e(t('checkout.needs_variant')) ?></p><ul>
    <?php foreach ($cart['needs_variant'] as $p): ?><li><a href="<?= e(product_path($p, $locale)) ?>#buy"><?= e($p['title']) ?></a></li><?php endforeach; ?>
  </ul></div>
  <?php elseif ($cart['removed']): ?><p class="notice notice--info" role="status"><?= e(t('checkout.removed')) ?></p><?php endif; ?>

  <?php if (!$cart['items']): ?>
  <p class="notice"><?= e(t('checkout.empty')) ?></p>
  <p><a class="btn btn--primary" href="<?= e(route('shop')) ?>"><?= e(t('cart.continue')) ?></a></p>
  <?php else: ?>
  <form class="checkout" action="<?= e(route('checkout')) ?>" method="post" novalidate>
    <?= csrf_field() ?>
    <input type="hidden" name="items" value="<?= e($ids) ?>">
    <div class="checkout__form">
      <fieldset class="form" style="border:0;padding:0;margin:0">
        <legend class="section__title"><?= e(t('checkout.your_data')) ?></legend>
        <div class="form__row">
          <label for="co-name"><?= e(t('checkout.name')) ?></label>
          <input id="co-name" name="name" type="text" required autocomplete="name" maxlength="190" value="<?= e($old['name']) ?>"<?= isset($errors['name']) ? ' aria-invalid="true" aria-describedby="err-name"' : '' ?>>
          <?= $err('name') ?>
        </div>
        <div class="form__row">
          <label for="co-email"><?= e(t('checkout.email')) ?></label>
          <input id="co-email" name="email" type="email" required autocomplete="email" maxlength="190" value="<?= e($old['email']) ?>" aria-describedby="co-email-help<?= isset($errors['email']) ? ' err-email' : '' ?>"<?= isset($errors['email']) ? ' aria-invalid="true"' : '' ?>>
          <p class="form-note" id="co-email-help"><?= e(t('checkout.email_help')) ?></p>
          <?= $err('email') ?>
        </div>
        <div class="form__grid">
          <div class="form__row">
            <label for="co-doc"><?= e(t('checkout.document')) ?> <span class="form-note"><?= e(t('form.optional')) ?></span></label>
            <input id="co-doc" name="document" type="text" autocomplete="off" maxlength="40" value="<?= e($old['document']) ?>">
          </div>
          <div class="form__row">
            <label for="co-phone"><?= e(t('checkout.phone')) ?> <span class="form-note"><?= e(t('form.optional')) ?></span></label>
            <input id="co-phone" name="phone" type="tel" autocomplete="tel" maxlength="40" value="<?= e($old['phone']) ?>">
          </div>
        </div>
        <fieldset class="gateway-options">
          <legend><?= e(t('checkout.gateway')) ?></legend>
          <?php foreach ($gateways as $g): ?>
          <label class="gateway-option">
            <input type="radio" name="gateway" value="<?= e($g) ?>" required<?= $old['gateway'] === $g ? ' checked' : '' ?>>
            <span><?= e(t("checkout.gateway_$g")) ?><?php if (t("checkout.gateway_{$g}_help") !== ''): ?><small><?= e(t("checkout.gateway_{$g}_help")) ?></small><?php endif; ?></span>
          </label>
          <?php endforeach; ?>
          <?= $err('gateway') ?>
        </fieldset>
        <div class="form__row form__row--inline">
          <input id="co-terms" type="checkbox" name="terms" value="1" required<?= ($old['terms'] ?? '') === '1' ? ' checked' : '' ?>>
          <label for="co-terms"><?= t('checkout.terms', [
              'terms' => '<a href="' . e(route('policy', ['slug' => $locale === 'es' ? 'terminos' : 'terms'])) . '" target="_blank">' . e(t('checkout.terms_link')) . '</a>',
              'privacy' => '<a href="' . e(route('policy', ['slug' => $locale === 'es' ? 'privacidad' : 'privacy'])) . '" target="_blank">' . e(t('checkout.privacy_link')) . '</a>',
          ]) ?></label>
        </div>
        <?= $err('terms') ?>
        <button class="btn btn--buy btn--lg btn--block" type="submit"><?= e(t('checkout.pay', ['amount' => $totalLabel])) ?></button>
        <p class="form-note"><?= e(t('checkout.secure')) ?></p>
      </fieldset>
    </div>
    <aside class="checkout__summary summary-card" aria-labelledby="summary-title">
      <h2 id="summary-title"><?= e(t('checkout.summary')) ?></h2>
      <ul class="summary-list">
        <?php foreach ($cart['items'] as $p): ?>
        <li><span><?= e($p['title']) ?></span> <strong><?= e(money(\App\Models\Product::chargePrice($p, $locale), $cart['currency'])) ?></strong></li>
        <?php endforeach; ?>
      </ul>
      <p class="summary-total"><span><?= e(t('cart.total')) ?></span> <span><?= e($totalLabel) ?></span></p>
      <p class="form-note"><?= e(t('checkout.currency_note')) ?></p>
    </aside>
  </form>
  <?php endif; ?>
</section>
