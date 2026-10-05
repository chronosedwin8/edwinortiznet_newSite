<?php /** @var array $crumbs */ ?>
<section class="wrap page-narrow listing" data-cart-page data-checkout="<?= e(route('checkout')) ?>">
  <?= \App\Core\View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
  <h1 class="listing__title"><?= e(t('cart.title')) ?></h1>
  <p class="lead"><?= e(t('cart.page_lead')) ?></p>
  <noscript><p class="notice"><?= e(t('cart.nojs')) ?></p></noscript>
  <div class="summary-card js-only">
    <ul class="summary-list" data-cart-page-items></ul>
    <p data-cart-page-empty hidden><?= e(t('cart.empty')) ?></p>
    <p class="summary-total" data-cart-page-foot hidden><span><?= e(t('cart.total')) ?></span> <span data-cart-page-total></span></p>
  </div>
  <p class="hero__actions js-only">
    <a class="btn btn--buy btn--lg" href="<?= e(route('checkout')) ?>" data-cart-page-checkout hidden><?= e(t('cart.checkout')) ?></a>
    <a class="btn btn--ghost btn--lg" href="<?= e(route('shop')) ?>"><?= e(t('cart.continue')) ?></a>
  </p>
</section>
