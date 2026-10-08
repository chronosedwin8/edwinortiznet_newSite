<?php
/** @var array $accounts @var array $channels @var array $hubs @var array $tools @var string|null $userExpires @var string|null $connectedAt
 *  @var string|null $lastPlan @var bool $metaApp @var bool $cronToken */

use App\Core\View;
use App\Services\Social\Accounts;
use App\Services\Social\Schedule;

$networks = ['fb' => 'admin.social.net.fb', 'ig' => 'admin.social.net.ig'];
$byNetwork = ['fb' => [], 'ig' => []];
foreach ($accounts as $a) {
    $byNetwork[$a['network']][] = $a;
}
?>
<?= View::render('admin/social/tabs', ['current' => 'settings']) ?>

<section class="panel">
  <div class="panel__head">
    <h2><?= e(t('admin.social.accounts')) ?></h2>
    <form method="post" action="<?= e(route('admin.social.check')) ?>"><?= csrf_field() ?><button class="btn btn--ghost btn--small" type="submit"><?= icon('check') ?><?= e(t('admin.social.check')) ?></button></form>
  </div>
  <?php if (!$accounts): ?>
  <p class="muted"><?= e(t('admin.social.no_accounts_yet')) ?></p>
  <?php else: ?>
  <div class="table-wrap">
  <table class="data">
    <thead><tr><th><?= e(t('admin.social.col_network')) ?></th><th><?= e(t('admin.social.col_account')) ?></th><th><?= e(t('admin.f.status')) ?></th><th><?= e(t('admin.social.col_token')) ?></th><th><?= e(t('admin.social.col_quota')) ?></th><th><?= e(t('admin.social.col_checked')) ?></th></tr></thead>
    <tbody>
    <?php foreach ($accounts as $a): [$state, $date, $days] = Accounts::expiry($a['token_expires_at']); $info = Accounts::decodeInfo($a); ?>
      <tr>
        <td><?= e(t($networks[$a['network']])) ?></td>
        <td><?= e($a['name']) ?><?php if ($a['username']): ?><br><small class="muted"><?= e('@' . $a['username']) ?></small><?php endif; ?></td>
        <td><span class="tag tag--<?= $a['status'] === 'active' ? 'published' : 'declined' ?>"><?= e(t('admin.social.account.' . $a['status'])) ?></span>
          <?php if ($a['last_error']): ?><br><small class="sq-net__error"><?= e($a['last_error']) ?></small><?php endif; ?></td>
        <td><?php if ($state === 'never'): ?><span class="tag tag--published"><?= e(t('admin.social.token_never')) ?></span>
          <?php else: ?><span class="tag tag--<?= $state === 'ok' ? 'published' : ($state === 'soon' ? 'pending' : 'declined') ?>"><?= e(t('admin.social.token_' . $state, ['date' => (string) $date, 'n' => (int) $days])) ?></span>
          <?php endif; ?></td>
        <td><?= isset($info['quota_usage']) ? e(t('admin.social.quota', ['used' => (int) $info['quota_usage'], 'total' => (int) $info['quota_total']])) : '—' ?></td>
        <td><?= $a['last_check_at'] ? e(Schedule::toLocal($a['last_check_at'])) : '—' ?></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
  <?php endif; ?>
  <p class="muted"><?= e(t('admin.social.meta_user_info', [
      'connected' => $connectedAt ? Schedule::toLocal($connectedAt) : '—',
      'expires' => $userExpires === null ? '—' : ($userExpires === 'never' ? t('admin.social.token_never') : Schedule::toLocal($userExpires, 'Y-m-d')),
  ])) ?></p>
</section>

<section class="panel">
  <h2><?= e(t('admin.social.connect_meta')) ?></h2>
  <ol class="sq-steps">
    <li><?= e(t('admin.social.meta_step1')) ?> <a href="https://developers.facebook.com/tools/explorer/" target="_blank" rel="noopener"><?= e(t('admin.social.meta_explorer')) ?></a></li>
    <li><?= e(t('admin.social.meta_step2')) ?></li>
    <li><?= e(t('admin.social.meta_step3')) ?></li>
    <li><?= e(t('admin.social.meta_step4')) ?> <code><?= e(implode(', ', \App\Services\Social\Connector::META_SCOPES)) ?></code></li>
    <li><?= e(t('admin.social.meta_step5')) ?></li>
    <li><?= e(t('admin.social.meta_step6')) ?></li>
  </ol>
  <?php if (!$metaApp): ?><p class="sq-net__error"><?= e(t('admin.social.meta_no_secret')) ?></p><?php endif; ?>
  <form method="post" action="<?= e(route('admin.social.connect')) ?>" class="admin-form" autocomplete="off">
    <?= csrf_field() ?>
    <label for="meta-token"><?= e(t('admin.social.user_token')) ?></label>
    <textarea id="meta-token" name="token" rows="3" required spellcheck="false" class="code"></textarea>
    <button class="btn" type="submit"><?= icon('link') ?><?= e(t('admin.social.connect_renew')) ?></button>
  </form>
</section>

<h2 class="sq-section-title"><?= e(t('admin.social.channels')) ?></h2>
<?php foreach ($channels as $c): $rule = $c['content']; $cid = 'c' . (int) $c['id']; ?>
<section class="panel" id="canal-<?= (int) $c['id'] ?>">
  <form method="post" action="<?= e(route('admin.social.channel', ['id' => (int) $c['id']])) ?>" class="admin-form">
    <?= csrf_field() ?>
    <div class="panel__head">
      <h2><?= e($c['name']) ?> <small class="muted"><?= e($c['key']) ?></small></h2>
      <span class="tag tag--<?= $c['active'] ? 'published' : 'declined' ?>"><?= e(t($c['active'] ? 'admin.social.active' : 'admin.social.inactive')) ?></span>
    </div>
    <div class="sq-grid">
      <div>
        <label for="<?= $cid ?>-name"><?= e(t('admin.social.channel_name')) ?></label>
        <input id="<?= $cid ?>-name" name="name" maxlength="120" value="<?= e($c['name']) ?>">
        <label class="check"><input type="checkbox" name="active" value="1"<?= $c['active'] ? ' checked' : '' ?>> <?= e(t('admin.social.active_help')) ?></label>
        <label class="check"><input type="checkbox" name="auto_approve" value="1"<?= $c['auto_approve'] ? ' checked' : '' ?>> <?= e(t('admin.social.auto_approve')) ?></label>
        <p class="hint"><?= e(t('admin.social.auto_approve_help')) ?></p>
        <?php foreach (['fb', 'ig'] as $net): ?>
        <label for="<?= $cid ?>-<?= $net ?>"><?= e(t($networks[$net])) ?></label>
        <select id="<?= $cid ?>-<?= $net ?>" name="<?= $net ?>_account_id">
          <option value="0"><?= e(t('admin.social.none_account')) ?></option>
          <?php foreach ($byNetwork[$net] as $a): ?>
          <option value="<?= (int) $a['id'] ?>"<?= (int) $c[$net . '_account_id'] === (int) $a['id'] ? ' selected' : '' ?>><?= e($a['name'] . ($a['username'] ? ' (@' . $a['username'] . ')' : '')) ?></option>
          <?php endforeach; ?>
        </select>
        <?php endforeach; ?>
      </div>
      <div>
        <fieldset class="sq-fieldset">
          <legend><?= e(t('admin.social.schedule')) ?></legend>
          <div class="sq-checks">
            <?php for ($d = 1; $d <= 7; $d++): ?>
            <label class="check"><input type="checkbox" name="days[]" value="<?= $d ?>"<?= in_array($d, $c['schedule']['days'], true) ? ' checked' : '' ?>> <?= e(t('admin.social.day.' . $d)) ?></label>
            <?php endfor; ?>
          </div>
          <label for="<?= $cid ?>-time"><?= e(t('admin.social.time')) ?></label>
          <input id="<?= $cid ?>-time" type="time" name="time" value="<?= e($c['schedule']['time']) ?>" required>
        </fieldset>
        <fieldset class="sq-fieldset">
          <legend><?= e(t('admin.social.content')) ?></legend>
          <p class="sq-label"><?= e(t('admin.social.types')) ?></p>
          <div class="sq-checks">
            <?php foreach (['post', 'page', 'product', 'tool'] as $type): ?>
            <label class="check"><input type="checkbox" name="types[]" value="<?= $type ?>"<?= in_array($type, $rule['types'], true) ? ' checked' : '' ?>> <?= e(t('admin.social.type.' . $type)) ?></label>
            <?php endforeach; ?>
          </div>
          <p class="sq-label"><?= e(t('admin.social.hubs_include')) ?></p>
          <div class="sq-checks">
            <?php foreach ($hubs as $key => $title): ?>
            <label class="check"><input type="checkbox" name="hubs_include[]" value="<?= e($key) ?>"<?= in_array($key, $rule['hubs_include'], true) ? ' checked' : '' ?>> <?= e($title) ?></label>
            <?php endforeach; ?>
          </div>
          <p class="sq-label"><?= e(t('admin.social.hubs_exclude')) ?></p>
          <div class="sq-checks">
            <?php foreach ($hubs as $key => $title): ?>
            <label class="check"><input type="checkbox" name="hubs_exclude[]" value="<?= e($key) ?>"<?= in_array($key, $rule['hubs_exclude'], true) ? ' checked' : '' ?>> <?= e($title) ?></label>
            <?php endforeach; ?>
          </div>
          <p class="sq-label"><?= e(t('admin.social.audiences')) ?></p>
          <div class="sq-checks">
            <?php foreach (['oficina', 'docente', 'concurso'] as $aud): ?>
            <label class="check"><input type="checkbox" name="audiences[]" value="<?= $aud ?>"<?= in_array($aud, $rule['audiences'], true) ? ' checked' : '' ?>> <?= e(t('admin.social.audience.' . $aud)) ?></label>
            <?php endforeach; ?>
          </div>
          <label for="<?= $cid ?>-skus"><?= e(t('admin.social.skus')) ?></label>
          <input id="<?= $cid ?>-skus" name="skus" value="<?= e(implode(', ', $rule['skus'])) ?>">
          <label for="<?= $cid ?>-xskus"><?= e(t('admin.social.exclude_skus')) ?></label>
          <input id="<?= $cid ?>-xskus" name="exclude_skus" value="<?= e(implode(', ', $rule['exclude_skus'])) ?>">
          <p class="sq-label"><?= e(t('admin.social.tools')) ?></p>
          <div class="sq-checks">
            <?php foreach ($tools as $key => $name): ?>
            <label class="check"><input type="checkbox" name="tools[]" value="<?= e($key) ?>"<?= in_array($key, $rule['tools'], true) ? ' checked' : '' ?>> <?= e($name) ?></label>
            <?php endforeach; ?>
          </div>
        </fieldset>
      </div>
    </div>
    <button class="btn" type="submit"><?= icon('check') ?><?= e(t('admin.save')) ?></button>
  </form>
</section>
<?php endforeach; ?>

<section class="panel">
  <h2><?= e(t('admin.social.automation')) ?></h2>
  <p><?= e(t('admin.social.automation_help')) ?></p>
  <p class="muted"><?= e(t('admin.social.last_plan', ['date' => $lastPlan ? Schedule::toLocal($lastPlan) : '—'])) ?> · <?= e(t($cronToken ? 'admin.social.cron_external_on' : 'admin.social.cron_external_off')) ?></p>
  <p class="muted"><?= e(t('admin.social.bio_help')) ?> <a href="/enlaces/" target="_blank" rel="noopener"><?= e(url('/enlaces/')) ?></a></p>
</section>
