<?php
/** @var array $settings @var string $due @var bool $adminEmailSet @var bool $gemini */

use App\Core\View;
use App\Services\Newsletter\NewsletterSettings as NS;
?>
<?= View::render('admin/newsletter/tabs', ['current' => 'settings']) ?>
<section class="panel">
  <h2><?= e(t('admin.nl.settings_title')) ?></h2>
  <p class="muted"><?= e(t('admin.nl.settings_help', ['date' => NS::local($due, 'd/m/Y g:i a')])) ?></p>
  <?php if (!$adminEmailSet): ?><p class="tag tag--warn tag--plain"><?= e(t('admin.nl.no_admin_email')) ?></p><?php endif; ?>
  <form method="post" action="<?= e(route('admin.newsletter.settings')) ?>" class="admin-form form-grid">
    <?= csrf_field() ?>
    <label class="check wide"><input type="checkbox" name="enabled" value="1"<?= $settings['enabled'] ? ' checked' : '' ?>> <?= e(t('admin.nl.s.enabled')) ?></label>
    <label><?= e(t('admin.nl.s.every')) ?><input type="number" name="every_days" min="1" max="90" value="<?= (int) $settings['every_days'] ?>"></label>
    <label><?= e(t('admin.nl.s.weekday')) ?>
      <select name="weekday">
        <?php foreach (range(0, 7) as $d): ?><option value="<?= $d ?>"<?= $settings['weekday'] === $d ? ' selected' : '' ?>><?= e(t("admin.nl.weekday.$d")) ?></option><?php endforeach; ?>
      </select></label>
    <label><?= e(t('admin.nl.s.time')) ?><input type="time" name="time" value="<?= e($settings['time']) ?>"></label>
    <label><?= e(t('admin.nl.s.mode')) ?>
      <select name="mode">
        <option value="auto"<?= $settings['mode'] === 'auto' ? ' selected' : '' ?>><?= e(t('admin.nl.mode.auto')) ?></option>
        <option value="approval"<?= $settings['mode'] === 'approval' ? ' selected' : '' ?>><?= e(t('admin.nl.mode.approval')) ?></option>
      </select></label>
    <label><?= e(t('admin.nl.s.articles')) ?><input type="number" name="articles" min="1" max="10" value="<?= (int) $settings['articles'] ?>"></label>
    <label><?= e(t('admin.nl.s.products')) ?><input type="number" name="products" min="0" max="4" value="<?= (int) $settings['products'] ?>"></label>
    <label><?= e(t('admin.nl.s.batch')) ?><input type="number" name="batch" min="5" max="300" value="<?= (int) $settings['batch'] ?>"></label>
    <label class="check"><input type="checkbox" name="ai" value="1"<?= $settings['ai'] ? ' checked' : '' ?>> <?= e(t($gemini ? 'admin.nl.s.ai' : 'admin.nl.s.ai_off')) ?></label>
    <label class="wide"><?= e(t('admin.nl.s.address')) ?><input type="text" name="address" maxlength="160" value="<?= e($settings['address']) ?>"></label>
    <p class="wide"><button class="btn btn--small" type="submit"><?= e(t('admin.save')) ?></button></p>
  </form>
</section>
<section class="panel">
  <h2><?= e(t('admin.nl.how')) ?></h2>
  <ul>
    <li><?= e(t('admin.nl.how1')) ?></li>
    <li><?= e(t('admin.nl.how2')) ?></li>
    <li><?= e(t('admin.nl.how3')) ?></li>
    <li><?= e(t('admin.nl.how4')) ?></li>
    <li><?= e(t('admin.nl.how5')) ?></li>
  </ul>
  <p class="muted"><?= e(t('admin.nl.cron')) ?> <code><?= e('*/10 * * * * php bin/console newsletter:run') ?></code></p>
</section>
