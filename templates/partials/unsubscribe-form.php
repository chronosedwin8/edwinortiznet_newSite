<?php /** @var string $token @var int $sendId */ ?>
<form class="sub-page__form" method="post" action="<?= e(route('subscribe.unsubscribe', ['token' => $token])) ?>">
  <?= csrf_field() ?>
  <?php if ($sendId > 0): ?><input type="hidden" name="n" value="<?= (int) $sendId ?>"><?php endif; ?>
  <div class="sub-page__fields">
    <label for="unsub-reason"><?= e(t('subscribe.unsub.reason')) ?> <span class="muted"><?= e(t('form.optional')) ?></span>
      <select id="unsub-reason" name="reason">
        <option value=""><?= e(t('subscribe.unsub.reason.choose')) ?></option>
        <?php foreach (['too_many', 'not_relevant', 'never_signed', 'other'] as $r): ?>
        <option value="<?= e($r) ?>"><?= e(t("subscribe.unsub.reason.$r")) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label for="unsub-text"><?= e(t('subscribe.unsub.reason_text')) ?> <span class="muted"><?= e(t('form.optional')) ?></span>
      <input id="unsub-text" type="text" name="reason_text" maxlength="180">
    </label>
  </div>
  <button class="btn btn--ghost" type="submit"><?= e(t('subscribe.unsub.button')) ?></button>
</form>
