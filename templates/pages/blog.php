<?php /** @var array $posts @var int $page @var int $pages @var array $crumbs */

use App\Core\View;

?>
<section class="wrap listing">
  <header class="listing__header">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="listing__title"><?= e(t('blog.title')) ?></h1>
    <p class="lead"><?= e(t('blog.lead')) ?></p>
  </header>
  <?php if ($posts): ?>
  <div class="post-grid post-grid--feature">
    <?php foreach ($posts as $i => $post): ?>
      <?= View::render('partials/post-card', ['post' => $post, 'eager' => $i === 0]) ?>
    <?php endforeach; ?>
  </div>
  <?php else: ?>
  <p><?= e(t('blog.empty')) ?></p>
  <?php endif; ?>

  <?php if ($pages > 1): ?>
  <nav class="pagination" aria-label="<?= e(t('blog.pagination')) ?>">
    <?php if ($page > 1): ?>
    <a rel="prev" href="<?= e($page === 2 ? route('blog') : route('blog.page', ['n' => $page - 1])) ?>"><?= e(t('blog.prev')) ?></a>
    <?php endif; ?>
    <ol>
      <?php for ($i = 1; $i <= $pages; $i++): ?>
      <li><?php if ($i === $page): ?><span aria-current="page"><?= $i ?></span><?php else: ?><a href="<?= e($i === 1 ? route('blog') : route('blog.page', ['n' => $i])) ?>"><?= $i ?></a><?php endif; ?></li>
      <?php endfor; ?>
    </ol>
    <?php if ($page < $pages): ?>
    <a rel="next" href="<?= e(route('blog.page', ['n' => $page + 1])) ?>"><?= e(t('blog.next')) ?></a>
    <?php endif; ?>
  </nav>
  <?php endif; ?>
</section>
