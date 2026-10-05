<?php
/** @var array $product @var int|null $rank @var bool|null $eager */

use App\Services\I18n\I18n;

$locale = I18n::locale();
$eager ??= false;
$href = product_path($product, $locale);
$isSoon = $product['status'] === 'coming_soon' || !$product['purchasable'];
?>
<article class="product-card reveal" data-audience="<?= e($product['audience']) ?>" data-family="<?= e($product['family_slug'] ?? '') ?>"
         data-price="<?= e((string) (float) $product['price_usd']) ?>"<?= !empty($hidden) ? ' hidden' : '' ?>>
  <a class="product-card__media" href="<?= e($href) ?>" tabindex="-1" aria-hidden="true">
    <?php if (!empty($product['cover_url'])): ?>
    <img src="<?= e($product['cover_url']) ?>" alt="" width="<?= (int) ($product['cover_width'] ?: 600) ?>" height="<?= (int) ($product['cover_height'] ?: 400) ?>"
         <?php if (!empty($product['cover_srcset'])): ?>srcset="<?= e($product['cover_srcset']) ?>" sizes="<?= e(\App\Services\Seo\Assets::CARD_SIZES) ?>"<?php endif; ?>
         loading="<?= $eager ? 'eager' : 'lazy' ?>" decoding="async">
    <?php else: ?>
    <span class="product-card__placeholder"><?= e(mb_substr($product['family_name'] ?? $product['title'], 0, 1)) ?></span>
    <?php endif; ?>
  </a>
  <div class="product-card__body">
    <p class="product-card__meta">
      <?php if (!empty($product['family_name'])): ?><span><?= e($product['family_name']) ?></span><?php endif; ?>
      <?php if ($product['status'] === 'coming_soon'): ?><span class="badge badge--soon"><?= e(t('product.coming_soon')) ?></span>
      <?php elseif (!empty($rank) && $rank <= 3 && $product['sales_total'] > 20): ?><span class="badge"><?= e(t('product.best_seller')) ?></span><?php endif; ?>
    </p>
    <h3 class="product-card__title"><a href="<?= e($href) ?>"><?= e($product['title']) ?></a></h3>
    <?php if (!empty($product['short_html'])): ?>
    <p class="product-card__text"><?= e(product_blurb($product, 110)) ?></p>
    <?php endif; ?>
    <div class="product-card__foot">
      <?= \App\Core\View::render('partials/price', ['product' => $product, 'size' => 'sm']) ?>
      <?php if (!$isSoon): ?>
      <button type="button" class="btn btn--buy btn--sm js-only" data-add-to-cart="<?= (int) $product['id'] ?>"
              data-title="<?= e($product['title']) ?>" data-url="<?= e($href) ?>" data-img="<?= e($product['cover_url'] ?? '') ?>"
              data-price-cop="<?= (int) $product['price_cop'] ?>" data-price-usd="<?= e((string) $product['price_usd']) ?>"><?= e(t('product.add')) ?></button>
      <?php else: ?>
      <a class="btn btn--ghost btn--sm" href="<?= e($href) ?>"><?= e(t('product.notify_short')) ?></a>
      <?php endif; ?>
    </div>
  </div>
</article>
