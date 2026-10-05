<?php /** @var bool|null $large */ $large ??= false; ?>
<aside class="author-box<?= $large ? ' author-box--large' : '' ?>" aria-labelledby="author-name">
  <div class="author-box__avatar" aria-hidden="true"><?= e(t('author.initials')) ?></div>
  <div class="author-box__body">
    <p class="eyebrow"><?= e(t('author.eyebrow')) ?></p>
    <p class="author-box__name" id="author-name"><?= e(t('author.name')) ?></p>
    <p><?= e(t('author.bio')) ?></p>
    <p><a class="link-more" href="<?= e(route('about')) ?>"><?= e(t('author.more')) ?></a></p>
  </div>
</aside>
