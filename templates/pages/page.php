<?php /** @var array $post @var string $html @var array $crumbs */ ?>
<article class="page wrap">
  <header class="page__header">
    <?= \App\Core\View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="page__title"><?= e($post['title']) ?></h1>
  </header>
  <div class="prose page__body">
    <?php if (!empty($post['notice_html'])): ?><div class="notice" role="note"><?= $post['notice_html'] ?></div><?php endif; ?>
    <?= $html ?>
  </div>
</article>
