<?php
/** @var array $bestSellers @var array $tools @var array $hubs @var array $latest */

use App\Core\View;
use App\Services\I18n\I18n;

$locale = I18n::locale();
$profiles = $locale === 'es'
    ? [
        ['/excel/', 'office', t('home.profile.office.title'), t('home.profile.office.text')],
        ['/ia-para-docentes/', 'teacher', t('home.profile.teacher.title'), t('home.profile.teacher.text')],
        ['/concurso-docente/', 'contest', t('home.profile.contest.title'), t('home.profile.contest.text')],
    ]
    : [
        ['/en/excel-automation/', 'office', t('home.profile.office.title'), t('home.profile.office.text')],
        ['/en/ai-for-teachers/', 'teacher', t('home.profile.teacher.title'), t('home.profile.teacher.text')],
        [route('tools'), 'tools', t('home.profile.tools.title'), t('home.profile.tools.text')],
    ];
?>
<section class="hero">
  <div class="wrap hero__grid">
    <div class="hero__copy">
      <p class="eyebrow"><?= e(t('home.eyebrow')) ?></p>
      <h1 class="hero__title"><?= e(t('home.title')) ?></h1>
      <p class="hero__lead"><?= e(t('home.lead')) ?></p>
      <div class="hero__actions">
        <a class="btn btn--primary btn--lg" href="<?= e(route('tools')) ?>"><?= e(t('home.cta_tools')) ?></a>
        <a class="btn btn--ghost btn--lg" href="<?= e($profiles[1][0]) ?>"><?= e(t('home.cta_teacher')) ?></a>
      </div>
    </div>
    <aside class="hero__panel" aria-label="<?= e(t('home.panel_label')) ?>">
      <figure class="sheet" aria-hidden="true">
        <div class="sheet__bar"><span></span><span></span><span></span></div>
        <div class="sheet__grid">
          <span class="sheet__h">A</span><span class="sheet__h">B</span><span class="sheet__h">C</span>
          <span><?= e(t('home.sheet.name')) ?></span><span><?= e(t('home.sheet.email')) ?></span><span><?= e(t('home.sheet.file')) ?></span>
          <span>Ana R.</span><span>ana@…</span><span class="sheet__ok">PDF ✓</span>
          <span>Luis M.</span><span>luis@…</span><span class="sheet__ok">PDF ✓</span>
          <span>Sofía P.</span><span>sofia@…</span><span class="sheet__run">▸ …</span>
        </div>
      </figure>
      <ul class="hero__facts">
        <li><strong><?= e(t('home.fact1.value')) ?></strong> <?= e(t('home.fact1.label')) ?></li>
        <li><strong><?= e(t('home.fact2.value')) ?></strong> <?= e(t('home.fact2.label')) ?></li>
      </ul>
    </aside>
  </div>
</section>

<section class="section wrap" aria-labelledby="profiles-title">
  <h2 id="profiles-title" class="section__title"><?= e(t('home.profiles_title')) ?></h2>
  <ol class="profiles">
    <?php foreach ($profiles as $i => [$href, $key, $title, $text]): ?>
    <li class="profile reveal">
      <a href="<?= e($href) ?>" class="profile__link">
        <span class="profile__num" aria-hidden="true">0<?= $i + 1 ?></span>
        <span class="profile__title"><?= e($title) ?></span>
        <span class="profile__text"><?= e($text) ?></span>
        <span class="profile__go" aria-hidden="true">→</span>
      </a>
    </li>
    <?php endforeach; ?>
  </ol>
</section>

<?php if ($bestSellers): ?>
<section class="section section--tint" aria-labelledby="best-title">
  <div class="wrap">
    <div class="section__head">
      <h2 id="best-title" class="section__title"><?= e(t('home.best_title')) ?></h2>
      <a class="link-more" href="<?= e(route('shop')) ?>"><?= e(t('home.best_all')) ?></a>
    </div>
    <div class="product-rail">
      <?php foreach ($bestSellers as $i => $product): ?>
        <?= View::render('partials/product-card', ['product' => $product, 'rank' => $i + 1, 'eager' => false]) ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section wrap" aria-labelledby="tools-title">
  <div class="section__head">
    <h2 id="tools-title" class="section__title"><?= e(t('home.tools_title')) ?></h2>
    <a class="link-more" href="<?= e(route('tools')) ?>"><?= e(t('home.tools_all')) ?></a>
  </div>
  <ul class="tool-list">
    <?php foreach ($tools as $tool): ?>
    <li class="tool-item reveal">
      <a href="<?= e(route('tool', ['slug' => $tool['slug']])) ?>">
        <span class="tool-item__tag"><?= e(t('tools.free')) ?></span>
        <span class="tool-item__title"><?= e(t("tool.{$tool['key']}.name")) ?></span>
        <span class="tool-item__text"><?= e(t("tool.{$tool['key']}.summary")) ?></span>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</section>

<?php if ($hubs || $latest): ?>
<section class="section section--line wrap" aria-labelledby="latest-title">
  <h2 id="latest-title" class="section__title"><?= e(t('home.latest_title')) ?></h2>
  <div class="hub-columns">
    <?php foreach ($hubs as $hub): if (!$hub['posts']) { continue; } ?>
    <section class="hub-column" aria-labelledby="hubcol-<?= e($hub['key']) ?>">
      <h3 id="hubcol-<?= e($hub['key']) ?>" class="hub-column__title"><a href="<?= e(\App\Models\Hub::path($hub)) ?>"><?= e($hub['menu_title'] ?: $hub['title']) ?></a></h3>
      <ul class="post-list">
        <?php foreach ($hub['posts'] as $post): ?>
        <li><?= View::render('partials/post-line', ['post' => $post]) ?></li>
        <?php endforeach; ?>
      </ul>
    </section>
    <?php endforeach; ?>
    <?php if ($latest): ?>
    <section class="hub-column" aria-labelledby="hubcol-latest">
      <h3 id="hubcol-latest" class="hub-column__title"><a href="<?= e(route('blog')) ?>"><?= e(t('nav.blog')) ?></a></h3>
      <ul class="post-list">
        <?php foreach ($latest as $post): ?>
        <li><?= View::render('partials/post-line', ['post' => $post]) ?></li>
        <?php endforeach; ?>
      </ul>
    </section>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<section class="section wrap">
  <?= View::render('partials/author-box', ['large' => true]) ?>
</section>

<section class="section wrap">
  <?= View::render('partials/subscribe-box', ['source' => 'home', 'tag' => 'general']) ?>
</section>
