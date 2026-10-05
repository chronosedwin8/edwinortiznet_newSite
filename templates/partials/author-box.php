<?php /** @var bool|null $large */ $large ??= false; ?>
<aside class="author-box<?= $large ? ' author-box--large' : '' ?>" aria-labelledby="author-name">
  <div class="author-box__avatar" aria-hidden="true"><span><?= e(t('author.initials')) ?></span></div>
  <div class="author-box__body">
    <p class="eyebrow"><?= e(t('author.eyebrow')) ?></p>
    <p class="author-box__name" id="author-name"><?= e(t('author.name')) ?></p>
    <p class="author-box__role"><?= e(t('author.job')) ?></p>
    <p><?= e(t('author.bio')) ?></p>
    <p><a class="link-more" href="<?= e(route('about')) ?>"><?= e(t('author.more')) ?></a></p>
  </div>
  <?php if ($large): ?>
  <ul class="author-box__facts">
    <li><strong><?= e(t('author.fact1_value')) ?></strong><span><?= e(t('author.fact1_label')) ?></span></li>
    <li><strong><?= e(t('author.fact2_value')) ?></strong><span><?= e(t('author.fact2_label')) ?></span></li>
    <li><strong><?= e(t('author.fact3_value')) ?></strong><span><?= e(t('author.fact3_label')) ?></span></li>
  </ul>
  <?php endif; ?>
</aside>
