<?php /** @var array $product */
$href = product_path($product);
?>
<aside class="product-inline" aria-label="<?= e(t('post.product_label')) ?>">
  <?php if (!empty($product['cover_url'])): ?>
  <img class="product-inline__img" src="<?= e($product['cover_url']) ?>" alt="" width="<?= (int) ($product['cover_width'] ?: 600) ?>" height="<?= (int) ($product['cover_height'] ?: 400) ?>"<?php if (!empty($product['cover_srcset'])): ?> srcset="<?= e($product['cover_srcset']) ?>" sizes="(min-width: 640px) 200px, 88px"<?php endif; ?> loading="lazy" decoding="async">
  <?php endif; ?>
  <div class="product-inline__body">
    <p class="eyebrow"><?= e($product['status'] === 'coming_soon' ? t('post.product_soon') : t('post.product_eyebrow')) ?></p>
    <p class="product-inline__title"><a href="<?= e($href) ?>"><?= e($product['title']) ?></a></p>
    <p class="product-inline__text"><?= e(product_blurb($product, 140)) ?></p>
    <div class="product-inline__foot">
      <?= \App\Core\View::render('partials/price', ['product' => $product, 'size' => 'sm']) ?>
      <a class="btn btn--buy btn--sm" href="<?= e($href) ?>"><?= e($product['status'] === 'coming_soon' ? t('product.notify_short') : t('post.product_cta')) ?></a>
    </div>
  </div>
</aside>
