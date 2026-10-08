<?php /** @var array $row @var string $token @var string[] $interests @var bool $saved @var bool $paused */
$unsubscribed = $row['status'] === 'unsubscribed';
?>
<section class="wrap page-narrow message-page sub-page">
  <h1><?= e(t('subscribe.prefs.title')) ?></h1>
  <p class="lead"><?= e(t('subscribe.prefs.lead', ['email' => $row['email']])) ?></p>
  <?php if ($saved): ?><p class="sub-page__notice" role="status"><?= e(t('subscribe.prefs.saved')) ?></p>
  <?php elseif ($unsubscribed): ?><p class="sub-page__notice sub-page__notice--muted"><?= e(t('subscribe.prefs.is_unsubscribed')) ?></p>
  <?php elseif ($paused): ?><p class="sub-page__notice sub-page__notice--muted"><?= e(t('subscribe.prefs.is_paused', ['date' => fdate($row['paused_until'])])) ?></p><?php endif; ?>

  <form class="sub-page__form" method="post" action="<?= e(route('subscribe.preferences', ['token' => $token])) ?>">
    <?= csrf_field() ?>
    <?= \App\Core\View::render('partials/interest-chips', ['idPrefix' => 'prefs', 'checked' => $interests, 'large' => true]) ?>
    <p class="form-note"><?= e(t('subscribe.interests.none_note')) ?></p>
    <div class="sub-page__fields">
      <label for="prefs-locale"><?= e(t('subscribe.prefs.locale')) ?>
        <select id="prefs-locale" name="locale">
          <option value="es"<?= $row['locale'] !== 'en' ? ' selected' : '' ?>><?= e(t('subscribe.prefs.locale_es')) ?></option>
          <option value="en"<?= $row['locale'] === 'en' ? ' selected' : '' ?>><?= e(t('subscribe.prefs.locale_en')) ?></option>
        </select>
      </label>
      <label for="prefs-pause"><?= e(t('subscribe.prefs.pause')) ?>
        <select id="prefs-pause" name="pause">
          <option value=""><?= e(t('subscribe.prefs.pause_none')) ?></option>
          <option value="1m"><?= e(t('subscribe.prefs.pause_1m')) ?></option>
          <option value="3m"><?= e(t('subscribe.prefs.pause_3m')) ?></option>
        </select>
      </label>
    </div>
    <button class="btn btn--primary" type="submit"><?= e(t($unsubscribed ? 'subscribe.prefs.resubscribe' : 'subscribe.prefs.save')) ?></button>
  </form>

  <?php if (!$unsubscribed): ?>
  <section class="sub-page__danger" aria-labelledby="prefs-unsub">
    <h2 id="prefs-unsub"><?= e(t('subscribe.unsub.title')) ?></h2>
    <?= \App\Core\View::render('partials/unsubscribe-form', ['token' => $token, 'sendId' => 0]) ?>
  </section>
  <?php endif; ?>
</section>
