<?php
/** @var array $meta @var string $content */

use App\Core\Config;
use App\Services\Seo\Meta;
use App\Services\Seo\SecurityHeaders;
use App\Services\Seo\Assets;

$locale = $meta['locale'];
?>
<!doctype html>
<html lang="<?= e($meta['html_lang']) ?>" data-locale="<?= e($locale) ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($meta['full_title']) ?></title>
<meta name="description" content="<?= e($meta['description']) ?>">
<link rel="canonical" href="<?= e($meta['canonical']) ?>">
<meta name="robots" content="<?= e($meta['robots']) ?>">
<?php foreach ($meta['alternates'] as $lang => $href): ?>
<link rel="alternate" hreflang="<?= e(\App\Services\I18n\I18n::meta('hreflang', $lang)) ?>" href="<?= e($href) ?>">
<?php endforeach; ?>
<?php if (isset($meta['alternates']['es'])): ?>
<link rel="alternate" hreflang="x-default" href="<?= e($meta['alternates']['es']) ?>">
<?php endif; ?>
<meta name="theme-color" content="#0E5A6B" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#0f1416" media="(prefers-color-scheme: dark)">
<meta name="color-scheme" content="light dark">
<meta property="og:site_name" content="<?= e(t('site.name')) ?>">
<meta property="og:type" content="<?= e($meta['og_type']) ?>">
<meta property="og:title" content="<?= e($meta['og_title'] ?? $meta['full_title']) ?>">
<meta property="og:description" content="<?= e($meta['description']) ?>">
<meta property="og:url" content="<?= e($meta['canonical']) ?>">
<meta property="og:image" content="<?= e($meta['image']) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:locale" content="<?= e($meta['og_locale']) ?>">
<?php if ($meta['og_locale_alternate']): ?>
<meta property="og:locale:alternate" content="<?= e($meta['og_locale_alternate']) ?>">
<?php endif; ?>
<?php if (!empty($meta['published'])): ?>
<meta property="article:published_time" content="<?= e($meta['published']) ?>">
<?php endif; ?>
<?php if (!empty($meta['modified'])): ?>
<meta property="article:modified_time" content="<?= e($meta['modified']) ?>">
<?php endif; ?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= e($meta['og_title'] ?? $meta['full_title']) ?>">
<meta name="twitter:description" content="<?= e($meta['description']) ?>">
<meta name="twitter:image" content="<?= e($meta['image']) ?>">
<link rel="alternate" type="application/rss+xml" title="<?= e(t('site.name')) ?>" href="<?= e(url(route('feed'))) ?>">
<link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
<link rel="icon" href="/favicon.ico" sizes="32x32">
<link rel="apple-touch-icon" href="/assets/img/apple-touch-icon.png">
<link rel="preload" href="/assets/fonts/bricolage-grotesque-var.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="/assets/fonts/plus-jakarta-sans-var.woff2" as="font" type="font/woff2" crossorigin>
<link rel="preconnect" href="https://blogedwinortiznet.s3.amazonaws.com">
<?php if (!empty($meta['preload_image'])): ?>
<link rel="preload" as="image" href="<?= e($meta['preload_image']) ?>"<?php if (!empty($meta['preload_srcset'])): ?> imagesrcset="<?= e($meta['preload_srcset']) ?>" imagesizes="<?= e($meta['preload_sizes'] ?? '100vw') ?>"<?php endif; ?> fetchpriority="high">
<?php endif; ?>
<style><?= Assets::criticalCss() ?></style>
<script><?= SecurityHeaders::THEME_SCRIPT ?></script>
<script type="module" src="<?= e(asset('js/main.js')) ?>"></script>
<?php foreach (($meta['scripts'] ?? []) as $script): ?>
<script type="module" src="<?= e(asset($script)) ?>"></script>
<?php endforeach; ?>
<?php foreach ($meta['jsonld'] as $ld): if ($ld === null) { continue; } ?>
<script type="application/ld+json"><?= Meta::json($ld) ?></script>
<?php endforeach; ?>
</head>
<body class="<?= e($meta['body_class'] ?? '') ?>"
      data-ga="<?= e((string) Config::get('GA4_ID', '')) ?>"
      data-adsense="<?= !empty($meta['ads']) ? e((string) Config::get('ADSENSE_CLIENT', '')) : '' ?>"
      data-has-alt="<?= $meta['switch_url'] ? '1' : '0' ?>"
      data-label-currency="<?= e(t('price.currency_label')) ?>" data-label-charged="<?= e(t('price.charged_cop')) ?>"
      data-label-network="<?= e(t('form.network_error')) ?>">
<a class="skip-link" href="#main"><?= e(t('a11y.skip')) ?></a>
<?= \App\Core\View::render('partials/header', ['meta' => $meta]) ?>
<?php if ($meta['switch_url']): ?>
<div class="lang-banner" data-lang-banner hidden>
  <div class="wrap lang-banner__inner">
    <p lang="<?= e(\App\Services\I18n\I18n::meta('html', \App\Services\I18n\I18n::other())) ?>"><a href="<?= e($meta['switch_url']) ?>" hreflang="<?= e(\App\Services\I18n\I18n::other()) ?>"><?= e(t('lang.banner', [], \App\Services\I18n\I18n::other())) ?></a></p>
    <button type="button" class="btn-icon" data-lang-banner-close aria-label="<?= e(t('a11y.close')) ?>">×</button>
  </div>
</div>
<?php endif; ?>
<main id="main" tabindex="-1">
<?= $content ?>
</main>
<?= \App\Core\View::render('partials/footer', ['meta' => $meta]) ?>
<?= \App\Core\View::render('partials/overlays', ['meta' => $meta]) ?>
<link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
</body>
</html>
