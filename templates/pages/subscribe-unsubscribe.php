<?php /** @var string $token @var int $sendId */ ?>
<section class="wrap page-narrow message-page sub-page">
  <h1><?= e(t('subscribe.unsub.title')) ?></h1>
  <p class="lead"><?= e(t('subscribe.unsub.text')) ?></p>
  <?= \App\Core\View::render('partials/unsubscribe-form', ['token' => $token, 'sendId' => $sendId]) ?>
  <p class="form-note"><a href="<?= e(route('subscribe.preferences', ['token' => $token])) ?>"><?= e(t('subscribe.unsub.prefer_prefs')) ?></a></p>
</section>
