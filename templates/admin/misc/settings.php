<?php /** @var array $values */ ?>
<form method="post" action="/admin/ajustes/" class="admin-form panel">
  <?= csrf_field() ?>
  <label for="s-wa"><?= e(t('admin.settings.whatsapp')) ?></label>
  <input id="s-wa" name="whatsapp_number" value="<?= e($values['whatsapp_number']) ?>" pattern="\d{8,15}">
  <label for="s-yt"><?= e(t('admin.settings.youtube')) ?></label>
  <input id="s-yt" name="social_youtube" type="url" value="<?= e($values['social_youtube']) ?>" placeholder="<?= e(t('admin.hint.url_placeholder')) ?>">
  <label for="s-li"><?= e(t('admin.settings.linkedin')) ?></label>
  <input id="s-li" name="social_linkedin" type="url" value="<?= e($values['social_linkedin']) ?>" placeholder="<?= e(t('admin.hint.url_placeholder')) ?>">
  <label for="s-ref"><?= e(t('admin.settings.refund_days')) ?></label>
  <input id="s-ref" name="refund_days" type="number" min="0" max="60" value="<?= e($values['refund_days']) ?>" class="narrow">
  <label class="check"><input type="checkbox" name="ads_enabled" value="1"<?= $values['ads_enabled'] === '1' ? ' checked' : '' ?>> <?= e(t('admin.settings.ads')) ?></label>
  <label for="s-ads"><?= e(t('admin.settings.ads_max')) ?></label>
  <input id="s-ads" name="adsense_max_blocks" type="number" min="0" max="3" value="<?= e($values['adsense_max_blocks']) ?>" class="narrow">
  <p class="hint"><?= e(t('admin.settings.env_note')) ?></p>
  <button class="btn" type="submit"><?= e(t('admin.save')) ?></button>
</form>
<form method="post" action="<?= e(route('admin.cache')) ?>" class="panel">
  <?= csrf_field() ?>
  <p><?= e(t('admin.settings.cache_text')) ?></p>
  <button class="btn btn--ghost" type="submit"><?= e(t('admin.settings.cache')) ?></button>
</form>
