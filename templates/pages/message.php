<?php /** @var string $title @var string $text @var string|null $actionUrl @var string|null $actionLabel */ ?>
<section class="wrap page-narrow message-page">
  <h1><?= e($title) ?></h1>
  <p class="lead"><?= e($text) ?></p>
  <p><a class="btn btn--primary" href="<?= e($actionUrl ?? route('home')) ?>"><?= e($actionLabel ?? t('error.home')) ?></a></p>
</section>
