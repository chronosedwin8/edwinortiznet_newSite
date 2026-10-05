<?php /** @var array $posts */ ?>
<aside class="inline-posts" aria-label="<?= e(t('post.related')) ?>">
  <p class="inline-posts__title"><?= e(t('post.related')) ?></p>
  <ul>
    <?php foreach ($posts as $p): ?>
    <li><a href="<?= e(post_path($p)) ?>"><?= e($p['title']) ?></a></li>
    <?php endforeach; ?>
  </ul>
</aside>
