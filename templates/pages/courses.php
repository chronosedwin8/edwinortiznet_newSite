<?php /** @var array $courses @var array $playlists @var array|null $guide @var array $crumbs */

use App\Core\View;

?>
<section class="wrap listing">
  <header class="listing__header">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="listing__title"><?= e(t('courses.title')) ?></h1>
    <p class="lead"><?= e(t('courses.lead')) ?></p>
  </header>
  <?php if ($courses): ?>
  <h2 class="section__title"><?= e(t('courses.paid')) ?></h2>
  <?= View::render('partials/product-grid', ['products' => $courses]) ?>
  <?php endif; ?>

  <?php if ($playlists): ?>
  <section class="section" aria-labelledby="pl-title">
    <h2 id="pl-title" class="section__title"><?= e(t('courses.free')) ?></h2>
    <ul class="link-list">
      <?php foreach ($playlists as $href => $label): ?>
      <li><a href="<?= e($href) ?>" target="_blank" rel="noopener"><?= e($label) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </section>
  <?php endif; ?>

  <?php if ($guide): ?>
  <p class="link-more-wrap"><a class="link-more" href="<?= e(post_path($guide)) ?>"><?= e($guide['title']) ?></a></p>
  <?php endif; ?>
</section>
