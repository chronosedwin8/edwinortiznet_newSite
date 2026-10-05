<?php
/** @var array $product @var string|null $size */

use App\Services\I18n\I18n;

$size ??= 'md';
$locale = I18n::locale();
?>
<?php if ($locale === 'es'): ?>
<p class="price price--<?= e($size) ?>" data-price data-cop="<?= (int) $product['price_cop'] ?>" data-usd="<?= e((string) $product['price_usd']) ?>">
  <span class="price__main" data-price-main><?= e(money($product['price_cop'], 'COP')) ?></span>
  <span class="price__ref" data-price-ref><?= e(t('price.usd_ref', ['amount' => money($product['price_usd'], 'USD')])) ?></span>
</p>
<?php else: ?>
<p class="price price--<?= e($size) ?>">
  <span class="price__main"><?= e(money($product['price_usd'], 'USD')) ?></span>
</p>
<?php endif; ?>
