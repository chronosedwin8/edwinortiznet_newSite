<?php
/** @var array $meta */

use App\Core\Config;
use App\Services\I18n\I18n;

$locale = I18n::locale();
$wa = \App\Models\Setting::get('whatsapp_number') ?? (string) Config::get('WHATSAPP_NUMBER', '573162830615');
?>
<aside class="cart-drawer" id="cart-drawer" data-cart-drawer hidden aria-labelledby="cart-drawer-title"
       data-checkout="<?= e(route('checkout')) ?>" data-api="/api/carrito" data-locale="<?= e($locale) ?>">
  <div class="cart-drawer__backdrop" data-cart-close></div>
  <div class="cart-drawer__panel" role="dialog" aria-modal="true" aria-labelledby="cart-drawer-title">
    <div class="cart-drawer__head">
      <h2 id="cart-drawer-title"><?= e(t('cart.title')) ?></h2>
      <button type="button" class="btn-icon" data-cart-close aria-label="<?= e(t('a11y.close')) ?>">×</button>
    </div>
    <div class="cart-drawer__body" data-cart-items aria-live="polite"></div>
    <p class="cart-drawer__empty" data-cart-empty><?= e(t('cart.empty')) ?></p>
    <div class="cart-drawer__foot" data-cart-foot hidden>
      <p class="cart-drawer__total"><span><?= e(t('cart.total')) ?></span> <strong data-cart-total></strong></p>
      <a class="btn btn--buy btn--block" href="<?= e(route('checkout')) ?>"><?= e(t('cart.checkout')) ?></a>
    </div>
  </div>
</aside>

<dialog class="search-dialog" data-search-dialog aria-labelledby="search-dialog-title">
  <form class="search-dialog__form" role="search" action="<?= e(route('search')) ?>" method="get">
    <h2 id="search-dialog-title" class="visually-hidden"><?= e(t('search.title')) ?></h2>
    <label class="visually-hidden" for="search-dialog-input"><?= e(t('search.label')) ?></label>
    <input id="search-dialog-input" type="search" name="q" autocomplete="off" spellcheck="false"
           placeholder="<?= e(t('search.placeholder')) ?>" data-search-input
           role="combobox" aria-expanded="false" aria-controls="search-results" aria-autocomplete="list">
    <button type="button" class="btn-icon" data-search-close aria-label="<?= e(t('a11y.close')) ?>">×</button>
  </form>
  <div class="search-dialog__results" id="search-results" role="listbox" data-search-results
       data-label-posts="<?= e(t('search.group_posts')) ?>" data-label-products="<?= e(t('search.group_products')) ?>"
       data-label-empty="<?= e(t('search.no_results')) ?>" data-label-all="<?= e(t('search.see_all')) ?>"></div>
  <p class="search-dialog__hint"><?= e(t('search.hint')) ?></p>
</dialog>

<a class="whatsapp-float" href="https://wa.me/<?= e($wa) ?>?text=<?= rawurlencode(t('whatsapp.message')) ?>" target="_blank" rel="noopener" aria-label="<?= e(t('whatsapp.label')) ?>">
  <?= icon('whatsapp') ?>
</a>

<div class="consent" data-consent hidden role="region" aria-label="<?= e(t('consent.title')) ?>">
  <div class="consent__inner">
    <p><?= e(t('consent.text')) ?> <a href="<?= e(route('policy', ['slug' => 'cookies'])) ?>"><?= e(t('consent.more')) ?></a></p>
    <div class="consent__actions">
      <button type="button" class="btn btn--ghost" data-consent-reject><?= e(t('consent.reject')) ?></button>
      <button type="button" class="btn btn--primary" data-consent-accept><?= e(t('consent.accept')) ?></button>
    </div>
  </div>
</div>
<template id="tpl-cart-item">
  <div class="cart-item">
    <img class="cart-item__img" alt="" width="64" height="64" loading="lazy" decoding="async">
    <div class="cart-item__info">
      <a class="cart-item__title"></a>
      <span class="cart-item__price"></span>
    </div>
    <button type="button" class="btn-icon cart-item__remove" aria-label="<?= e(t('cart.remove')) ?>">×</button>
  </div>
</template>
