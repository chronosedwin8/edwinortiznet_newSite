<?php /** @var string $token @var string[] $interests */ ?>
<section class="wrap page-narrow message-page sub-page">
  <h1><?= e(t('subscribe.confirm.title')) ?></h1>
  <p class="lead"><?= e(t('subscribe.confirm.text')) ?></p>
  <form class="sub-page__form" method="post" action="<?= e(route('subscribe.confirm', ['token' => $token])) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="interests_sent" value="1">
    <?= \App\Core\View::render('partials/interest-chips', ['idPrefix' => 'confirm', 'checked' => $interests, 'large' => true]) ?>
    <p class="form-note"><?= e(t('subscribe.interests.none_note')) ?></p>
    <button class="btn btn--primary btn--lg" type="submit"><?= e(t('subscribe.confirm.button')) ?></button>
  </form>
</section>
