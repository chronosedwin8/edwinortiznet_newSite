<?php
/** @var array $meta */

use App\Services\I18n\I18n;

$locale = I18n::locale();
$other = I18n::other();
$switch = $meta['switch_url'] ?? null;
$nav = $locale === 'es'
    ? [
        ['/excel/', t('nav.excel')],
        ['/ia-para-docentes/', t('nav.teachers')],
        ['/concurso-docente/', t('nav.contest')],
        [route('tools'), t('nav.tools')],
        [route('shop'), t('nav.shop')],
        [route('blog'), t('nav.blog')],
    ]
    : [
        ['/en/excel-automation/', t('nav.excel')],
        ['/en/ai-for-teachers/', t('nav.teachers')],
        [route('tools'), t('nav.tools')],
        [route('shop'), t('nav.shop')],
        [route('blog'), t('nav.blog')],
    ];
$current = \App\Services\Seo\Meta::path();
?>
<header class="site-header">
  <div class="wrap site-header__inner">
    <a class="brand" href="<?= e(route('home')) ?>" aria-label="<?= e(t('nav.home_label')) ?>">
      <span class="brand__mark" aria-hidden="true"><?= e(t('nav.brand_mark')) ?></span>
      <span class="brand__name"><?= e(t('nav.brand_first')) ?> <span><?= e(t('nav.brand_last')) ?></span></span>
    </a>
    <nav class="main-nav" aria-label="<?= e(t('nav.main')) ?>">
      <ul>
        <?php foreach ($nav as [$href, $label]): ?>
        <li><a href="<?= e($href) ?>"<?= str_starts_with($current, $href) ? ' aria-current="page"' : '' ?>><?= e($label) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <div class="header-actions">
      <a class="btn-icon" href="<?= e(route('search')) ?>" data-search-open aria-label="<?= e(t('search.open')) ?>" title="<?= e(t('search.shortcut')) ?>"><?= icon('search') ?></a>
      <a class="lang-switch" href="<?= e($switch ?? route('home', [], $other)) ?>" hreflang="<?= e($other) ?>" lang="<?= e(I18n::meta('html', $other)) ?>" aria-label="<?= e(t('lang.switch_label', [], $other)) ?>"><?= e(strtoupper($other)) ?></a>
      <button type="button" class="btn-icon js-only" data-theme-toggle aria-label="<?= e(t('theme.toggle')) ?>"><?= icon('contrast') ?></button>
      <a class="btn-icon cart-link" href="<?= e(route('cart')) ?>" data-cart-open aria-label="<?= e(t('cart.open')) ?>">
        <?= icon('cart') ?><span class="cart-count" data-cart-count hidden>0</span>
      </a>
    </div>
  </div>
</header>
