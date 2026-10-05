<?php /** @var array $post */ ?>
<a class="post-line" href="<?= e(post_path($post)) ?>">
  <span class="post-line__title"><?= e($post['title']) ?></span>
  <span class="post-line__meta"><time datetime="<?= e(substr((string) $post['published_at'], 0, 10)) ?>"><?= e(fdate($post['published_at'], 'short')) ?></time> · <?= e(t('post.minutes', ['n' => (int) $post['reading_minutes']])) ?></span>
</a>
