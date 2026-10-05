<?php
/** @var array $post @var array|null $hub @var string $html @var array $toc @var array|null $product @var array $siblings @var array $crumbs */

use App\Core\View;

$published = substr((string) $post['published_at'], 0, 10);
$updated = substr((string) $post['updated_at'], 0, 10);
?>
<div class="reading-progress" aria-hidden="true"><span data-progress></span></div>
<article class="article" itemscope>
  <header class="article__header wrap">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <?php if ($hub): ?><p class="eyebrow"><a href="<?= e(\App\Models\Hub::path($hub)) ?>"><?= e($hub['menu_title'] ?: $hub['title']) ?></a></p><?php endif; ?>
    <h1 class="article__title"><?= e($post['title']) ?></h1>
    <p class="article__meta">
      <span><?= e(t('post.by')) ?> <a href="<?= e(route('about')) ?>" rel="author"><?= e(t('author.name')) ?></a></span>
      <span><?= e(t('post.published')) ?> <time datetime="<?= e($published) ?>"><?= e(fdate($post['published_at'])) ?></time></span>
      <?php if ($updated !== '' && $updated !== $published): ?>
      <span><?= e(t('post.updated')) ?> <time datetime="<?= e($updated) ?>"><?= e(fdate($post['updated_at'])) ?></time></span>
      <?php endif; ?>
      <span><?= e(t('post.minutes', ['n' => (int) $post['reading_minutes']])) ?></span>
    </p>
  </header>

  <?php if (!empty($post['cover_url'])): ?>
  <figure class="article__cover wrap">
    <img src="<?= e($post['cover_url']) ?>" alt="<?= e($post['cover_alt'] ?: $post['title']) ?>"
         <?php if ($post['cover_width'] && $post['cover_height']): ?>width="<?= (int) $post['cover_width'] ?>" height="<?= (int) $post['cover_height'] ?>"<?php endif; ?>
         fetchpriority="high" decoding="async">
  </figure>
  <?php endif; ?>

  <div class="article__layout wrap">
    <?php if (count($toc) >= 2): ?>
    <aside class="toc" aria-labelledby="toc-title">
      <details class="toc__details" open>
        <summary id="toc-title"><?= e(t('post.toc')) ?></summary>
        <ol>
          <?php foreach ($toc as $item): ?>
          <li><a href="#<?= e($item['id']) ?>"><?= e($item['text']) ?></a></li>
          <?php endforeach; ?>
        </ol>
      </details>
    </aside>
    <?php endif; ?>

    <div class="article__body prose" data-article-body>
      <?php if (!empty($post['notice_html'])): ?>
      <div class="notice" role="note"><?= $post['notice_html'] ?></div>
      <?php endif; ?>
      <?= $html ?>

      <?php if ($product): ?>
      <section class="article__product" aria-labelledby="article-product-title">
        <h2 id="article-product-title" class="article__product-title"><?= e($product['status'] === 'coming_soon' ? t('post.product_end_soon') : t('post.product_end')) ?></h2>
        <?= View::render('partials/product-inline', ['product' => $product]) ?>
      </section>
      <?php endif; ?>

      <?php if ($hub): ?>
      <p class="article__hub-link"><?= e(t('post.more_in')) ?> <a href="<?= e(\App\Models\Hub::path($hub)) ?>"><?= e($hub['title']) ?></a></p>
      <?php endif; ?>
    </div>
  </div>

  <footer class="article__footer wrap">
    <?= View::render('partials/author-box', []) ?>
    <?php if ($siblings): ?>
    <section class="siblings" aria-labelledby="siblings-title">
      <h2 id="siblings-title" class="section__title"><?= e(t('post.siblings')) ?></h2>
      <div class="post-grid">
        <?php foreach ($siblings as $s): ?>
          <?= View::render('partials/post-card', ['post' => $s]) ?>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>
    <?= View::render('partials/subscribe-box', ['source' => 'article:' . $post['slug'], 'tag' => $hub['key'] ?? 'general']) ?>
  </footer>
</article>
