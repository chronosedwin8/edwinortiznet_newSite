<?php /** @var array $post @var bool|null $eager */ $eager ??= false; ?>
<article class="post-card reveal">
  <?php if (!empty($post['cover_url'])): ?>
  <a class="post-card__media" href="<?= e(post_path($post)) ?>" tabindex="-1" aria-hidden="true">
    <img src="<?= e($post['cover_url']) ?>" alt="" width="<?= (int) ($post['cover_width'] ?: 800) ?>" height="<?= (int) ($post['cover_height'] ?: 450) ?>"
         <?php if (!empty($post['cover_srcset'])): ?>srcset="<?= e($post['cover_srcset']) ?>" sizes="<?= e(\App\Services\Seo\Assets::CARD_SIZES) ?>"<?php endif; ?>
         loading="<?= $eager ? 'eager' : 'lazy' ?>" decoding="async"<?= $eager ? ' fetchpriority="high"' : '' ?>>
  </a>
  <?php endif; ?>
  <div class="post-card__body">
    <h3 class="post-card__title"><a href="<?= e(post_path($post)) ?>"><?= e($post['title']) ?></a></h3>
    <p class="post-card__meta"><time datetime="<?= e(substr((string) $post['published_at'], 0, 10)) ?>"><?= e(fdate($post['published_at'])) ?></time> · <?= e(t('post.minutes', ['n' => (int) $post['reading_minutes']])) ?></p>
    <?php if (!empty($post['excerpt'])): ?>
    <p class="post-card__text"><?= e(excerpt_text($post['excerpt'], 150)) ?></p>
    <?php endif; ?>
  </div>
</article>
