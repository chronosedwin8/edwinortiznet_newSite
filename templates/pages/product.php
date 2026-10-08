<?php
/** @var array $product @var array $images @var string $description @var array|null $tutorial @var array $family @var array $packItems @var array $faqs @var array $crumbs @var bool $waitlisted @var array $variants */

use App\Core\View;
use App\Services\I18n\I18n;

$locale = I18n::locale();
$soon = !$product['purchasable'];
$gallery = $images;
if (!empty($product['cover_url'])) {
    // La portada va primero; si también está entre las imágenes (importadas de WordPress), no se repite.
    $gallery = array_values(array_filter($gallery, static fn (array $img): bool => $img['url'] !== $product['cover_url']));
    $coverSizes = \App\Models\Product::imageSizes((string) $product['cover_url']);
    array_unshift($gallery, ['url' => $product['cover_url'], 'alt' => $product['cover_alt'] ?: $product['title'], 'width' => $product['cover_width'], 'height' => $product['cover_height'],
        'srcset' => ($product['cover_srcset'] ?? '') ?: $coverSizes['srcset'], 'thumb' => $coverSizes['thumb'], 'full' => $coverSizes['full']]);
}
$total = count($gallery);
$ratio = $gallery && !empty($gallery[0]['width']) && !empty($gallery[0]['height']) ? (int) $gallery[0]['width'] . ' / ' . (int) $gallery[0]['height'] : '3 / 2';
$checkoutUrl = route('checkout', ['items' => (string) $product['id']]);
$variants ??= [];
$hasVariants = $variants !== [];
?>
<section class="product wrap">
  <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
  <div class="product__grid">
    <div class="product__media">
      <?php if ($gallery): ?>
      <?php /* Carrusel: sin JS es una franja con desplazamiento horizontal (deslizar) y miniaturas que enlazan a cada imagen; product.js añade flechas, contador, teclado y ampliación. */ ?>
      <div class="pgallery" data-pgallery role="region" aria-roledescription="<?= e(t('product.gallery.carousel')) ?>" aria-label="<?= e(t('product.gallery')) ?>"
           style="--pg-ratio: <?= e($ratio) ?>" data-label-close="<?= e(t('product.gallery.close')) ?>" data-label-prev="<?= e(t('product.gallery.prev')) ?>" data-label-next="<?= e(t('product.gallery.next')) ?>" data-label-status="<?= e(t('product.gallery.n_of')) ?>">
        <div class="pgallery__stage">
          <ul class="pgallery__track" id="pg-track" data-pgallery-track<?= $total > 1 ? ' tabindex="0"' : '' ?>>
            <?php foreach ($gallery as $i => $img): $n = $i + 1; ?>
            <li class="pgallery__slide" id="pg-<?= $n ?>" data-pgallery-slide<?php if ($total > 1): ?> role="group" aria-roledescription="<?= e(t('product.gallery.slide')) ?>" aria-label="<?= e(t('product.gallery.n_of', ['n' => $n, 'total' => $total])) ?>"<?php endif; ?>>
              <a class="pgallery__zoom" href="<?= e($img['full'] ?? $img['url']) ?>" data-pgallery-zoom>
                <img src="<?= e($img['url']) ?>" alt="<?= e($img['alt'] ?: $product['title']) ?>"
                     <?php if (!empty($img['width']) && !empty($img['height'])): ?>width="<?= (int) $img['width'] ?>" height="<?= (int) $img['height'] ?>"<?php endif; ?>
                     <?php if (!empty($img['srcset'])): ?>srcset="<?= e($img['srcset']) ?>" sizes="<?= e(\App\Services\Seo\Assets::PRODUCT_SIZES) ?>"<?php endif; ?>
                     <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?> decoding="async">
                <span class="visually-hidden"><?= e(t('product.gallery.zoom')) ?></span>
              </a>
            </li>
            <?php endforeach; ?>
          </ul>
          <?php if ($total > 1): ?>
          <button type="button" class="pgallery__nav pgallery__nav--prev js-only" data-pgallery-prev aria-controls="pg-track" aria-label="<?= e(t('product.gallery.prev')) ?>"><?= icon('chevron-left') ?></button>
          <button type="button" class="pgallery__nav pgallery__nav--next js-only" data-pgallery-next aria-controls="pg-track" aria-label="<?= e(t('product.gallery.next')) ?>"><?= icon('chevron-right') ?></button>
          <p class="pgallery__counter js-only" aria-hidden="true"><span data-pgallery-current>1</span> / <?= $total ?></p>
          <?php endif; ?>
          <span class="pgallery__hint js-only" aria-hidden="true"><?= icon('maximize') ?></span>
        </div>
        <?php if ($total > 1): ?>
        <p class="visually-hidden" data-pgallery-status aria-live="polite" aria-atomic="true"></p>
        <ol class="gallery-thumbs" aria-label="<?= e(t('product.gallery.thumbs')) ?>">
          <?php foreach ($gallery as $i => $img): ?>
          <li><a class="gallery-thumbs__btn" href="#pg-<?= $i + 1 ?>" data-pgallery-thumb="<?= $i ?>" aria-label="<?= e(t('product.image_n', ['n' => $i + 1])) ?>"<?= $i === 0 ? ' aria-current="true"' : '' ?>>
            <img src="<?= e($img['thumb'] ?? $img['url']) ?>" alt="" width="96" height="64" loading="lazy" decoding="async">
          </a></li>
          <?php endforeach; ?>
        </ol>
        <?php endif; ?>
      </div>
      <?php endif; ?>
      <?php if (!empty($product['video_url']) && ($vid = \App\Services\Importer\HtmlCleaner::youtubeId($product['video_url']))): ?>
        <?= \App\Services\Importer\HtmlCleaner::liteYoutube($vid, $product['title']) ?>
      <?php endif; ?>
    </div>

    <div class="product__summary">
      <?php if (!empty($product['family_name'])): ?><p class="eyebrow"><?= e($product['family_name']) ?></p><?php endif; ?>
      <h1 class="product__title"><?= e($product['title']) ?></h1>
      <?php if (!empty($product['short_html'])): ?><div class="product__short prose"><?= $product['short_html'] ?></div><?php endif; ?>

      <?php if ($locale === 'en' && empty($product['has_english_version']) && $product['type'] !== 'service'): ?>
      <p class="notice notice--info" role="note"><?= e(t('product.spanish_interface')) ?></p>
      <?php endif; ?>

      <div class="buy-box" id="buy">
        <?= View::render('partials/price', ['product' => $product, 'size' => 'lg']) ?>
        <?php if ($tutorial): /* Artículo guía o tutorial del producto (products.tutorial_post_id): qué trae y cómo funciona, antes de comprar. */ ?>
        <a class="buy-guide" href="<?= e(post_path($tutorial)) ?>">
          <span class="buy-guide__icon"><?= icon('eye') ?></span>
          <span class="buy-guide__text"><strong><?= e(t('product.guide.title')) ?></strong> <small><?= e($tutorial['title']) ?></small></span>
          <?= icon('arrow', 'icon buy-guide__arrow') ?>
        </a>
        <?php endif; ?>
        <?php if (!$soon && $hasVariants): ?>
        <form class="buy-box__form" id="buy-form" action="<?= e(route('checkout')) ?>" method="get" data-variant-form>
          <fieldset class="variant-picker" aria-describedby="variant-help">
            <legend class="variant-picker__legend"><?= e(t('product.variant.choose')) ?> <span class="variant-picker__req"><?= e(t('product.variant.required')) ?></span></legend>
            <p class="variant-picker__help" id="variant-help"><?= e(t('product.variant.help')) ?></p>
            <div class="variant-picker__grid">
              <?php foreach ($variants as $vKey => $vLabel): $hintKey = "variant.$vKey.hint"; ?>
              <label class="variant-option">
                <input type="radio" name="items" value="<?= (int) $product['id'] ?>:<?= e($vKey) ?>" required
                       data-variant="<?= e($vKey) ?>" data-variant-label="<?= e($vLabel) ?>">
                <span class="variant-option__box">
                  <span class="variant-option__name"><?= e($vLabel) ?></span>
                  <?php if (\App\Services\I18n\I18n::has($hintKey)): ?><span class="variant-option__hint"><?= e(t($hintKey)) ?></span><?php endif; ?>
                </span>
              </label>
              <?php endforeach; ?>
            </div>
            <p class="field-error" data-variant-error role="alert" hidden><?= e(t('product.variant.error')) ?></p>
          </fieldset>
          <div class="buy-box__actions">
            <button class="btn btn--buy btn--lg" type="submit" data-buy-now="<?= (int) $product['id'] ?>"><?= e(t('product.buy_now')) ?></button>
            <button type="button" class="btn btn--ghost btn--lg js-only" data-add-to-cart="<?= (int) $product['id'] ?>" data-requires-variant="1"
                    data-title="<?= e($product['title']) ?>" data-url="<?= e(product_path($product)) ?>" data-img="<?= e($product['cover_url'] ?? '') ?>"
                    data-price-cop="<?= (int) $product['price_cop'] ?>" data-price-usd="<?= e((string) $product['price_usd']) ?>"><?= e(t('product.add')) ?></button>
          </div>
          <p class="buy-box__note"><?= e(t('product.variant.note')) ?></p>
        </form>
        <p class="buy-box__note"><?= e(t($locale === 'es' ? 'product.pay_note_es' : 'product.pay_note_en')) ?></p>
        <?php elseif (!$soon): ?>
        <div class="buy-box__actions">
          <a class="btn btn--buy btn--lg" href="<?= e($checkoutUrl) ?>" data-buy-now="<?= (int) $product['id'] ?>"><?= e(t('product.buy_now')) ?></a>
          <button type="button" class="btn btn--ghost btn--lg js-only" data-add-to-cart="<?= (int) $product['id'] ?>"
                  data-title="<?= e($product['title']) ?>" data-url="<?= e(product_path($product)) ?>" data-img="<?= e($product['cover_url'] ?? '') ?>"
                  data-price-cop="<?= (int) $product['price_cop'] ?>" data-price-usd="<?= e((string) $product['price_usd']) ?>"><?= e(t('product.add')) ?></button>
        </div>
        <p class="buy-box__note"><?= e(t($locale === 'es' ? 'product.pay_note_es' : 'product.pay_note_en')) ?></p>
        <?php else: ?>
        <p class="badge badge--soon"><?= e(t('product.coming_soon')) ?></p>
        <form class="waitlist-form" id="waitlist" action="<?= e(route('waitlist')) ?>" method="post" data-async-form>
          <?= csrf_field() ?>
          <?= antispam_fields() ?>
          <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
          <label for="wl-email"><?= e(t('waitlist.label')) ?></label>
          <div class="subscribe-form__row">
            <input id="wl-email" type="email" name="email" required autocomplete="email" placeholder="<?= e(t('subscribe.placeholder')) ?>">
            <button class="btn btn--primary" type="submit"><?= e(t('waitlist.button')) ?></button>
          </div>
          <p class="form-status" data-form-status role="status" aria-live="polite"><?= $waitlisted ? e(t('waitlist.ok')) : '' ?></p>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php if (!$soon): ?>
<div class="sticky-buy" data-sticky-buy hidden>
  <div class="sticky-buy__inner">
    <span class="sticky-buy__title"><?= e($product['title']) ?></span>
    <?= View::render('partials/price', ['product' => $product, 'size' => 'sm']) ?>
    <?php if ($hasVariants): ?>
    <button class="btn btn--buy btn--sm" type="submit" form="buy-form" data-buy-now="<?= (int) $product['id'] ?>"><?= e(t('product.buy_now')) ?></button>
    <?php else: ?>
    <a class="btn btn--buy btn--sm" href="<?= e($checkoutUrl) ?>" data-buy-now="<?= (int) $product['id'] ?>"><?= e(t('product.buy_now')) ?></a>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>

<div class="product-details wrap">
  <div class="product-details__main">
    <?php if (!empty($product['includes_html'])): ?>
    <section class="detail-block" aria-labelledby="inc-title">
      <h2 id="inc-title"><?= e(t('product.includes')) ?></h2>
      <div class="prose"><?= $product['includes_html'] ?></div>
    </section>
    <?php endif; ?>

    <?php if ($packItems): ?>
    <section class="detail-block" aria-labelledby="pack-title">
      <h2 id="pack-title"><?= e(t('product.pack_items')) ?></h2>
      <ul class="pack-list">
        <?php foreach ($packItems as $item): ?>
        <li><a href="<?= e(product_path($item)) ?>"><?= e($item['title']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </section>
    <?php endif; ?>

    <?php if (trim(strip_tags($description)) !== '' || str_contains($description, '<img') || str_contains($description, 'lite-yt')): ?>
    <section class="detail-block" aria-labelledby="desc-title">
      <h2 id="desc-title"><?= e(t('product.description')) ?></h2>
      <div class="prose"><?= $description ?></div>
    </section>
    <?php endif; ?>
  </div>

  <aside class="product-details__side">
    <?php if (!empty($product['requirements'])): ?>
    <section class="detail-card" aria-labelledby="req-title">
      <h2 id="req-title"><?= e(t('product.requirements')) ?></h2>
      <ul><?php foreach (preg_split('/\R/', (string) $product['requirements']) ?: [] as $line): if (trim($line) === '') { continue; } ?><li><?= e($line) ?></li><?php endforeach; ?></ul>
    </section>
    <?php endif; ?>
    <?php if (!empty($product['license_text'])): ?>
    <section class="detail-card" aria-labelledby="lic-title">
      <h2 id="lic-title"><?= e(t('product.license')) ?></h2>
      <p><?= e($product['license_text']) ?></p>
    </section>
    <?php endif; ?>
    <section class="detail-card" aria-labelledby="ref-title">
      <h2 id="ref-title"><?= e(t('product.refund')) ?></h2>
      <p><?= e(t('product.refund_text')) ?> <a href="<?= e(route('policy', ['slug' => $locale === 'es' ? 'reembolsos' : 'refunds'])) ?>"><?= e(t('product.refund_link')) ?></a></p>
    </section>
  </aside>
</div>

<?php if ($faqs): ?>
<section class="section wrap page-narrow" aria-labelledby="pfaq-title">
  <h2 id="pfaq-title" class="section__title"><?= e(t('faq.title')) ?></h2>
  <?= View::render('partials/faq', ['faqs' => $faqs]) ?>
</section>
<?php endif; ?>

<?php if ($family): ?>
<section class="section section--tint" aria-labelledby="fam-title">
  <div class="wrap">
    <h2 id="fam-title" class="section__title"><?= e(t('product.same_family')) ?></h2>
    <?= View::render('partials/product-grid', ['products' => $family]) ?>
  </div>
</section>
<?php endif; ?>
