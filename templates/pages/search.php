<?php /** @var string $q @var array $results @var array $crumbs */

use App\Core\View;

?>
<section class="wrap listing page-narrow">
  <header class="listing__header">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="listing__title"><?= e(t('search.title')) ?></h1>
    <form class="search-inline" role="search" action="<?= e(route('search')) ?>" method="get">
      <label class="visually-hidden" for="search-page-q"><?= e(t('search.label')) ?></label>
      <input id="search-page-q" type="search" name="q" value="<?= e($q) ?>" placeholder="<?= e(t('search.placeholder')) ?>">
      <button class="btn btn--primary" type="submit"><?= e(t('search.button')) ?></button>
    </form>
  </header>
  <?php if ($q !== ''): ?>
    <?php if (!$results['posts'] && !$results['products']): ?>
    <p><?= e(t('search.no_results_for', ['q' => $q])) ?></p>
    <?php endif; ?>
    <?php if ($results['products']): ?>
    <h2 class="section__title"><?= e(t('search.group_products')) ?></h2>
    <ul class="result-list">
      <?php foreach ($results['products'] as $p): ?>
      <li><a href="<?= e(route('product', ['slug' => $p['slug']])) ?>"><?= e($p['title']) ?></a></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <?php if ($results['posts']): ?>
    <h2 class="section__title"><?= e(t('search.group_posts')) ?></h2>
    <ul class="result-list">
      <?php foreach ($results['posts'] as $p): ?>
      <li><a href="<?= e(post_path($p)) ?>"><?= e($p['title']) ?></a><?php if (!empty($p['excerpt'])): ?><p><?= e(excerpt_text($p['excerpt'], 160)) ?></p><?php endif; ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php endif; ?>
</section>
