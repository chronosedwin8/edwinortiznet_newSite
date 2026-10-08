<?php /** @var string $token */ ?>
<section class="wrap page-narrow message-page">
  <h1><?= e(t('subscribe.confirm.title')) ?></h1>
  <p class="lead"><?= e(t('subscribe.confirm.text')) ?></p>
  <form method="post" action="<?= e(route('subscribe.confirm', ['token' => $token])) ?>">
    <?= csrf_field() ?>
    <button class="btn btn--primary" type="submit"><?= e(t('subscribe.confirm.button')) ?></button>
  </form>
</section>
