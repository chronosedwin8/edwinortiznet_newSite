<?php /** @var string $source @var string $tag @var string|null $title @var string|null $text */ ?>
<section class="subscribe-box" aria-labelledby="sub-<?= e($source) ?>-title">
  <div class="subscribe-box__copy">
    <h2 class="subscribe-box__title" id="sub-<?= e($source) ?>-title"><?= e($title ?? t('subscribe.title')) ?></h2>
    <p><?= e($text ?? t('subscribe.text')) ?></p>
  </div>
  <?= \App\Core\View::render('partials/subscribe-form', ['source' => $source, 'tag' => $tag, 'idPrefix' => 'sub-' . preg_replace('/[^a-z0-9\-]/i', '-', $source), 'chips' => true]) ?>
</section>
