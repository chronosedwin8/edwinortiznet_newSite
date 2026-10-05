<?php
/** @var int $salesTotal @var int $productCount @var int $postCount @var array $bestSellers @var array $tools @var array $hubs @var array $latest */

use App\Core\View;
use App\Services\I18n\I18n;

$locale = I18n::locale();
$profiles = $locale === 'es'
    ? [
        ['/excel/', 'briefcase', t('home.profile.office.title'), t('home.profile.office.text')],
        ['/ia-para-docentes/', 'school', t('home.profile.teacher.title'), t('home.profile.teacher.text')],
        ['/concurso-docente/', 'trophy', t('home.profile.contest.title'), t('home.profile.contest.text')],
    ]
    : [
        ['/en/excel-automation/', 'briefcase', t('home.profile.office.title'), t('home.profile.office.text')],
        ['/en/ai-for-teachers/', 'school', t('home.profile.teacher.title'), t('home.profile.teacher.text')],
        [route('tools'), 'bolt', t('home.profile.tools.title'), t('home.profile.tools.text')],
    ];
$stats = [
    [20, '+', t('home.stat.years')],
    [$salesTotal, '', t('home.stat.sales')],
    [$productCount, '', t('home.stat.products')],
    [$postCount, '', t('home.stat.posts')],
];
?>
<section class="hero hero--home">
  <div class="hero__aurora" aria-hidden="true"><span></span><span></span><span></span></div>
  <div class="wrap hero__grid">
    <div class="hero__copy">
      <p class="pill"><span class="pill__dot" aria-hidden="true"></span><?= e(t('home.eyebrow')) ?></p>
      <h1 class="hero__title"><?= e(t('home.title_a')) ?> <span class="text-gradient"><?= e(t('home.title_b')) ?></span></h1>
      <p class="hero__lead"><?= e(t('home.lead')) ?></p>
      <div class="hero__actions">
        <a class="btn btn--primary btn--lg" href="<?= e(route('tools')) ?>"><?= e(t('home.cta_tools')) ?> <?= icon('arrow') ?></a>
        <a class="btn btn--glass btn--lg" href="<?= e($profiles[1][0]) ?>"><?= e(t('home.cta_teacher')) ?></a>
      </div>
      <ul class="hero__trust">
        <li><?= icon('check') ?><?= e(t('home.trust1')) ?></li>
        <li><?= icon('check') ?><?= e(t('home.trust2')) ?></li>
        <li><?= icon('check') ?><?= e(t($locale === 'es' ? 'home.trust3_es' : 'home.trust3_en')) ?></li>
      </ul>
    </div>
    <div class="hero__visual" aria-hidden="true">
      <figure class="sheet" data-sheet data-done="<?= e(t('home.sheet.done')) ?>">
        <div class="sheet__bar"><span></span><span></span><span></span></div>
        <div class="sheet__grid">
          <span class="sheet__h">A</span><span class="sheet__h">B</span><span class="sheet__h">C</span>
          <span><?= e(t('home.sheet.name')) ?></span><span><?= e(t('home.sheet.email')) ?></span><span><?= e(t('home.sheet.file')) ?></span>
          <?php foreach ([1, 2, 3, 4] as $row): ?>
          <span><?= e(t("home.sheet.row{$row}_name")) ?></span><span><?= e(t("home.sheet.row{$row}_mail")) ?></span>
          <span class="sheet__status sheet__run" data-sheet-status><?= e(t('home.sheet.running')) ?></span>
          <?php endforeach; ?>
        </div>
      </figure>
      <p class="float-chip float-chip--1"><?= icon('file') ?><?= e(t('home.chip1')) ?></p>
      <p class="float-chip float-chip--2"><?= icon('mail') ?><?= e(t('home.chip2')) ?></p>
    </div>
  </div>
</section>

<section class="stats" aria-label="<?= e(t('home.stats_label')) ?>">
  <div class="wrap stats__grid">
    <?php foreach ($stats as $i => [$n, $suffix, $label]): ?>
    <p class="stat reveal" style="--i: <?= $i ?>"><strong class="stat__n" data-count="<?= (int) $n ?>"><?= e(\App\Services\I18n\I18n::number($n)) ?></strong><span class="stat__suffix"><?= e($suffix) ?></span><span class="stat__label"><?= e($label) ?></span></p>
    <?php endforeach; ?>
  </div>
</section>

<section class="section wrap" aria-labelledby="profiles-title">
  <div class="section__head">
    <div>
      <p class="eyebrow"><?= e(t('home.profiles_eyebrow')) ?></p>
      <h2 id="profiles-title" class="section__title"><?= e(t('home.profiles_title')) ?></h2>
    </div>
  </div>
  <div class="bento">
    <?php foreach ($profiles as $i => [$href, $ic, $title, $text]): ?>
    <a href="<?= e($href) ?>" class="bento__card bento__card--<?= $i + 1 ?> reveal" style="--i: <?= $i ?>" data-spotlight>
      <span class="bento__icon"><?= icon($ic) ?></span>
      <span class="bento__title"><?= e($title) ?></span>
      <span class="bento__text"><?= e($text) ?></span>
      <span class="bento__go"><?= icon('arrow') ?></span>
    </a>
    <?php endforeach; ?>
  </div>
</section>

<?php if ($bestSellers): ?>
<section class="section section--tint" aria-labelledby="best-title">
  <div class="wrap">
    <div class="section__head">
      <div>
        <p class="eyebrow"><?= e(t('home.best_eyebrow')) ?></p>
        <h2 id="best-title" class="section__title"><?= e(t('home.best_title')) ?></h2>
      </div>
      <div class="carousel-nav js-only">
        <button type="button" class="btn-round" data-carousel-prev="best" aria-label="<?= e(t('a11y.prev')) ?>"><?= icon('chevron-left') ?></button>
        <button type="button" class="btn-round" data-carousel-next="best" aria-label="<?= e(t('a11y.next')) ?>"><?= icon('chevron-right') ?></button>
        <a class="link-more" href="<?= e(route('shop')) ?>"><?= e(t('home.best_all')) ?></a>
      </div>
    </div>
    <div class="carousel" id="carousel-best" data-carousel="best" tabindex="0" aria-label="<?= e(t('home.best_title')) ?>">
      <?php foreach ($bestSellers as $i => $product): ?>
      <div class="carousel__item">
        <?= View::render('partials/product-card', ['product' => $product, 'rank' => $i + 1, 'eager' => false]) ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="section wrap" aria-labelledby="tools-title">
  <div class="section__head">
    <div>
      <p class="eyebrow"><?= e(t('tools.free')) ?></p>
      <h2 id="tools-title" class="section__title"><?= e(t('home.tools_title')) ?></h2>
    </div>
    <a class="link-more" href="<?= e(route('tools')) ?>"><?= e(t('home.tools_all')) ?></a>
  </div>
  <?= View::render('partials/tool-cards', ['tools' => $tools]) ?>
</section>

<?php if ($locale === 'es'): ?>
<section class="wrap section--flush">
  <?= View::render('partials/fundales-cta', ['campaign' => 'portada', 'variant' => 'banner']) ?>
</section>
<?php endif; ?>

<?php if ($hubs || $latest): ?>
<section class="section wrap" aria-labelledby="latest-title">
  <div class="section__head">
    <div>
      <p class="eyebrow"><?= e(t('home.latest_eyebrow')) ?></p>
      <h2 id="latest-title" class="section__title"><?= e(t('home.latest_title')) ?></h2>
    </div>
    <a class="link-more" href="<?= e(route('blog')) ?>"><?= e(t('home.latest_all')) ?></a>
  </div>
  <div class="tabs-hubs" data-tabs-hubs>
    <div class="tabs-hubs__list js-only" role="tablist" aria-label="<?= e(t('home.latest_title')) ?>">
      <?php $n = 0; foreach ($hubs as $hub): if (!$hub['posts']) { continue; } ?>
      <button type="button" role="tab" id="tab-<?= e($hub['key']) ?>" aria-controls="panel-<?= e($hub['key']) ?>" aria-selected="<?= $n === 0 ? 'true' : 'false' ?>" tabindex="<?= $n === 0 ? '0' : '-1' ?>"><?= e($hub['menu_title'] ?: $hub['title']) ?></button>
      <?php $n++; endforeach; ?>
      <?php if ($latest): ?>
      <button type="button" role="tab" id="tab-latest" aria-controls="panel-latest" aria-selected="<?= $n === 0 ? 'true' : 'false' ?>" tabindex="<?= $n === 0 ? '0' : '-1' ?>"><?= e(t('nav.blog')) ?></button>
      <?php endif; ?>
    </div>
    <?php $n = 0; foreach ($hubs as $hub): if (!$hub['posts']) { continue; } ?>
    <div class="tabs-hubs__panel" role="tabpanel" id="panel-<?= e($hub['key']) ?>" aria-labelledby="tab-<?= e($hub['key']) ?>" data-panel<?= $n > 0 ? ' data-inactive' : '' ?>>
      <h3 class="tabs-hubs__nojs"><a href="<?= e(\App\Models\Hub::path($hub)) ?>"><?= e($hub['title']) ?></a></h3>
      <div class="post-grid post-grid--three">
        <?php foreach ($hub['posts'] as $post): ?>
          <?= View::render('partials/post-card', ['post' => $post]) ?>
        <?php endforeach; ?>
      </div>
      <p class="tabs-hubs__more"><a class="link-more" href="<?= e(\App\Models\Hub::path($hub)) ?>"><?= e(t('home.see_hub', ['name' => $hub['menu_title'] ?: $hub['title']])) ?></a></p>
    </div>
    <?php $n++; endforeach; ?>
    <?php if ($latest): ?>
    <div class="tabs-hubs__panel" role="tabpanel" id="panel-latest" aria-labelledby="tab-latest" data-panel<?= $n > 0 ? ' data-inactive' : '' ?>>
      <h3 class="tabs-hubs__nojs"><a href="<?= e(route('blog')) ?>"><?= e(t('nav.blog')) ?></a></h3>
      <div class="post-grid post-grid--three">
        <?php foreach ($latest as $post): ?>
          <?= View::render('partials/post-card', ['post' => $post]) ?>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>
<?php endif; ?>

<section class="section wrap">
  <?= View::render('partials/author-box', ['large' => true]) ?>
</section>

<section class="section wrap section--top0">
  <?= View::render('partials/subscribe-box', ['source' => 'home', 'tag' => 'general']) ?>
</section>
