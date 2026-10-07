<?php
/**
 * Menú móvil (panel lateral a pantalla completa). Se abre con el botón de la cabecera por debajo de 1000 px;
 * main.js se encarga de la animación, el foco atrapado, Esc, el bloqueo del scroll y de cerrarlo al navegar.
 *
 * @var array $meta @var array $hubs @var string $current @var string|null $switch
 */

use App\Models\Hub;
use App\Services\I18n\I18n;

$locale = I18n::locale();
$other = I18n::other();
$hubIcons = ['excel' => 'table', 'ia-para-docentes' => 'school', 'concurso-docente' => 'trophy'];
$hubDesc = ['excel' => 'nav.excel_desc', 'ia-para-docentes' => 'nav.teachers_desc', 'concurso-docente' => 'nav.contest_desc'];
$topics = array_map(fn (array $hub) => [
    Hub::path($hub), $hub['menu_title'] ?: $hub['title'], $hubIcons[$hub['key']] ?? 'layers',
    isset($hubDesc[$hub['key']]) ? t($hubDesc[$hub['key']]) : null,
], $hubs);
$resources = [[route('tools'), t('nav.tools'), 'bolt', t('nav.tools_desc')], [route('shop'), t('nav.shop'), 'tag', t('nav.shop_desc')]];
if ($locale === 'es') {
    $resources[] = [route('courses'), t('nav.courses'), 'video', t('nav.courses_desc')];
}
$resources[] = [route('blog'), t('nav.blog'), 'book', t('nav.blog_desc')];
$more = [[route('about'), t('footer.about'), 'user'], [route('contact'), t('footer.contact'), 'mail'], [route('account'), t('nav.account'), 'user-circle']];
$langUrls = [$locale => $current, $other => $switch ?? route('home', [], $other)];
$isCurrent = static fn (string $href): bool => $href !== '/' && $href !== '/en/' && str_starts_with($current, $href);
?>
<div class="mobile-menu" id="mobile-menu" data-menu hidden>
  <div class="mobile-menu__backdrop" data-menu-close></div>
  <div class="mobile-menu__panel" role="dialog" aria-modal="true" aria-labelledby="mobile-menu-title">
    <div class="mobile-menu__head">
      <a class="brand" href="<?= e(route('home')) ?>" aria-label="<?= e(t('nav.home_label')) ?>">
        <span class="brand__mark" aria-hidden="true"><?= e(t('nav.brand_mark')) ?></span>
        <span class="brand__name"><?= e(t('nav.brand_first')) ?> <span><?= e(t('nav.brand_last')) ?></span></span>
      </a>
      <h2 id="mobile-menu-title" class="visually-hidden"><?= e(t('nav.menu')) ?></h2>
      <button type="button" class="btn-icon mobile-menu__close" data-menu-close aria-label="<?= e(t('nav.menu_close')) ?>"><?= icon('close') ?></button>
    </div>

    <div class="mobile-menu__body">
      <a class="mobile-menu__search" href="<?= e(route('search')) ?>" data-search-open>
        <?= icon('search') ?><span><?= e(t('search.placeholder')) ?></span>
      </a>

      <nav aria-label="<?= e(t('nav.main')) ?>">
        <?php if ($topics): ?>
        <h3 class="mobile-menu__label"><?= e(t('nav.topics')) ?></h3>
        <ul class="mm-list">
          <?php foreach ($topics as $i => [$href, $label, $iconName, $desc]): ?>
          <li style="--i: <?= $i ?>">
            <a class="mm-link" href="<?= e($href) ?>"<?= $isCurrent($href) ? ' aria-current="page"' : '' ?>>
              <span class="mm-link__icon mm-link__icon--<?= e($iconName) ?>"><?= icon($iconName) ?></span>
              <span class="mm-link__text"><span class="mm-link__title"><?= e($label) ?></span><?php if ($desc): ?><span class="mm-link__desc"><?= e($desc) ?></span><?php endif; ?></span>
              <?= icon('chevron-right', 'icon mm-link__go') ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <h3 class="mobile-menu__label"><?= e(t('nav.resources')) ?></h3>
        <ul class="mm-list">
          <?php foreach ($resources as $i => [$href, $label, $iconName, $desc]): ?>
          <li style="--i: <?= $i + count($topics) ?>">
            <a class="mm-link" href="<?= e($href) ?>"<?= $isCurrent($href) ? ' aria-current="page"' : '' ?>>
              <span class="mm-link__icon mm-link__icon--<?= e($iconName) ?>"><?= icon($iconName) ?></span>
              <span class="mm-link__text"><span class="mm-link__title"><?= e($label) ?></span><span class="mm-link__desc"><?= e($desc) ?></span></span>
              <?= icon('chevron-right', 'icon mm-link__go') ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>

        <h3 class="mobile-menu__label"><?= e(t('nav.more')) ?></h3>
        <ul class="mm-grid">
          <?php foreach ($more as [$href, $label, $iconName]): ?>
          <li><a class="mm-chip" href="<?= e($href) ?>"<?= $isCurrent($href) ? ' aria-current="page"' : '' ?>><?= icon($iconName) ?><span><?= e($label) ?></span></a></li>
          <?php endforeach; ?>
          <li><a class="mm-chip" href="<?= e(route('cart')) ?>" data-cart-open><?= icon('cart') ?><span><?= e(t('cart.title')) ?></span><span class="mm-chip__count" data-cart-count hidden>0</span></a></li>
        </ul>
      </nav>
    </div>

    <div class="mobile-menu__foot">
      <div class="mm-pref">
        <span class="visually-hidden" id="mm-lang-label"><?= e(t('nav.language')) ?></span>
        <div class="segmented" role="group" aria-labelledby="mm-lang-label">
          <?php foreach (['es', 'en'] as $lang): ?>
          <a href="<?= e($langUrls[$lang]) ?>" hreflang="<?= e($lang) ?>" lang="<?= e(I18n::meta('html', $lang)) ?>"<?= $lang === $locale ? ' aria-current="true"' : '' ?>><?= e(t('lang.switch_to', [], $lang)) ?></a>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="mm-pref js-only">
        <span class="visually-hidden" id="mm-theme-label"><?= e(t('theme.label')) ?></span>
        <div class="segmented segmented--icons" role="group" aria-labelledby="mm-theme-label">
          <button type="button" data-theme-set="light" aria-pressed="false" title="<?= e(t('theme.light')) ?>"><?= icon('sun') ?><span class="visually-hidden"><?= e(t('theme.light')) ?></span></button>
          <button type="button" data-theme-set="dark" aria-pressed="false" title="<?= e(t('theme.dark')) ?>"><?= icon('moon') ?><span class="visually-hidden"><?= e(t('theme.dark')) ?></span></button>
        </div>
      </div>
    </div>
  </div>
</div>
