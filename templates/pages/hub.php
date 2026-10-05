<?php
/** @var array $hub @var array|null $pillar @var array $posts @var array $products @var array $faqs */

use App\Core\View;

$crumbs = [[t('nav.home'), route('home')], [$hub['title'], \App\Models\Hub::path($hub)]];
?>
<section class="hub-hero">
  <div class="wrap">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="hub-hero__title"><?= e($hub['title']) ?></h1>
    <div class="hub-hero__intro prose"><?= $hub['intro_html'] ?></div>
  </div>
</section>

<?php if ($pillar): ?>
<section class="section wrap" aria-labelledby="pillar-title">
  <a class="pillar" href="<?= e(post_path($pillar)) ?>">
    <?php if (!empty($pillar['cover_url'])): ?>
    <img class="pillar__img" src="<?= e($pillar['cover_url']) ?>" alt="" width="<?= (int) ($pillar['cover_width'] ?: 800) ?>" height="<?= (int) ($pillar['cover_height'] ?: 450) ?>" loading="lazy" decoding="async">
    <?php endif; ?>
    <span class="pillar__body">
      <span class="eyebrow" id="pillar-title"><?= e(t('hub.pillar')) ?></span>
      <span class="pillar__title"><?= e($pillar['title']) ?></span>
      <span class="pillar__text"><?= e(excerpt_text($pillar['excerpt'], 180)) ?></span>
      <span class="link-more"><?= e(t('hub.read_guide')) ?></span>
    </span>
  </a>
</section>
<?php endif; ?>

<?php if ($posts): ?>
<section class="section wrap" aria-labelledby="hub-posts-title">
  <h2 id="hub-posts-title" class="section__title"><?= e(t('hub.articles')) ?></h2>
  <div class="post-grid">
    <?php foreach ($posts as $post): ?>
      <?= View::render('partials/post-card', ['post' => $post]) ?>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<?php if ($products): ?>
<section class="section section--tint" aria-labelledby="hub-products-title">
  <div class="wrap">
    <div class="section__head">
      <h2 id="hub-products-title" class="section__title"><?= e(t('hub.products')) ?></h2>
      <a class="link-more" href="<?= e(route('shop')) ?>"><?= e(t('home.best_all')) ?></a>
    </div>
    <?= View::render('partials/product-grid', ['products' => $products]) ?>
  </div>
</section>
<?php endif; ?>

<?php if ($faqs): ?>
<section class="section wrap page-narrow" aria-labelledby="hub-faq-title">
  <h2 id="hub-faq-title" class="section__title"><?= e(t('faq.title')) ?></h2>
  <?= View::render('partials/faq', ['faqs' => $faqs]) ?>
</section>
<?php endif; ?>

<section class="section wrap">
  <?= View::render('partials/subscribe-box', ['source' => 'hub:' . $hub['key'], 'tag' => $hub['key']]) ?>
</section>
