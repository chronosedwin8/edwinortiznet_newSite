<?php /** @var array $post @var string $html @var array $crumbs */ ?>
<article class="page about wrap">
  <header class="page__header">
    <?= \App\Core\View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="page__title"><?= e($post['title']) ?></h1>
  </header>
  <div class="about__grid">
    <div class="about__card" aria-hidden="true">
      <span class="about__initials"><?= e(t('author.initials')) ?></span>
      <span class="about__role"><?= e(t('author.job')) ?></span>
    </div>
    <div class="prose page__body"><?= $html ?></div>
  </div>
  <p class="about__actions">
    <a class="btn btn--primary" href="<?= e(route('contact')) ?>"><?= e(t('about.contact_cta')) ?></a>
    <a class="btn btn--ghost" href="<?= e(route('shop')) ?>"><?= e(t('about.shop_cta')) ?></a>
  </p>
</article>
