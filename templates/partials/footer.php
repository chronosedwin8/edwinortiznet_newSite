<?php
/** @var array $meta */

use App\Services\I18n\I18n;

$locale = I18n::locale();
$other = I18n::other();
$policies = $locale === 'es'
    ? ['privacidad' => t('footer.privacy'), 'terminos' => t('footer.terms'), 'reembolsos' => t('footer.refunds'), 'cookies' => t('footer.cookies')]
    : ['privacy' => t('footer.privacy'), 'terms' => t('footer.terms'), 'refunds' => t('footer.refunds'), 'cookies' => t('footer.cookies')];
?>
<footer class="site-footer">
  <div class="wrap site-footer__grid">
    <section class="site-footer__about">
      <p class="site-footer__brand"><?= e(t('site.owner')) ?></p>
      <p><?= e(t('footer.tagline')) ?></p>
      <p><a href="<?= e(route('about')) ?>"><?= e(t('footer.about')) ?></a> · <a href="<?= e(route('contact')) ?>"><?= e(t('footer.contact')) ?></a></p>
    </section>
    <nav aria-label="<?= e(t('footer.nav_explore')) ?>">
      <h2 class="site-footer__title"><?= e(t('footer.explore')) ?></h2>
      <ul>
        <li><a href="<?= e(route('blog')) ?>"><?= e(t('nav.blog')) ?></a></li>
        <li><a href="<?= e(route('shop')) ?>"><?= e(t('nav.shop')) ?></a></li>
        <li><a href="<?= e(route('tools')) ?>"><?= e(t('nav.tools')) ?></a></li>
        <?php if ($locale === 'es'): ?>
        <li><a href="<?= e(route('courses')) ?>"><?= e(t('nav.courses')) ?></a></li>
        <?php endif; ?>
        <li><a href="<?= e(route('account')) ?>"><?= e(t('nav.account')) ?></a></li>
      </ul>
    </nav>
    <nav aria-label="<?= e(t('footer.nav_legal')) ?>">
      <h2 class="site-footer__title"><?= e(t('footer.legal')) ?></h2>
      <ul>
        <?php foreach ($policies as $slug => $label): ?>
        <li><a href="<?= e(route('policy', ['slug' => $slug])) ?>"><?= e($label) ?></a></li>
        <?php endforeach; ?>
        <li><button type="button" class="link-button js-only" data-consent-open><?= e(t('consent.manage')) ?></button></li>
      </ul>
    </nav>
    <section aria-labelledby="footer-sub">
      <h2 class="site-footer__title" id="footer-sub"><?= e(t('subscribe.footer_title')) ?></h2>
      <?= \App\Core\View::render('partials/subscribe-form', ['source' => 'footer', 'tag' => 'general', 'compact' => true, 'idPrefix' => 'footer']) ?>
    </section>
  </div>
  <div class="wrap site-footer__bottom">
    <p><?= e(t('footer.copyright', ['year' => date('Y')])) ?></p>
    <p class="site-footer__lang">
      <a href="<?= e($meta['switch_url'] ?? route('home', [], $other)) ?>" hreflang="<?= e($other) ?>" lang="<?= e(I18n::meta('html', $other)) ?>"><?= e(t('lang.switch_to', [], $other)) ?></a>
    </p>
  </div>
</footer>
