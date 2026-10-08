<?php
/** @var array $rows @var string $status @var array $channels */

use App\Core\View;
use App\Services\Social\Schedule;

$networks = ['fb' => 'admin.social.net.fb', 'ig' => 'admin.social.net.ig'];
$return = '/admin/redes/historial/' . ($status !== '' ? '?estado=' . $status : '');
?>
<?= View::render('admin/social/tabs', ['current' => 'history']) ?>

<nav class="tabs" aria-label="<?= e(t('admin.f.status')) ?>">
  <?php foreach (['' => 'admin.social.all', 'published' => 'admin.social.status.published', 'failed' => 'admin.social.status.failed', 'skipped' => 'admin.social.status.skipped'] as $value => $label): ?>
  <a class="tab<?= $status === $value ? ' is-active' : '' ?>" href="/admin/redes/historial/<?= $value !== '' ? '?estado=' . e($value) : '' ?>"><?= e(t($label)) ?></a>
  <?php endforeach; ?>
</nav>

<?php if (!$rows): ?>
<p class="muted"><?= e(t('admin.none')) ?></p>
<?php else: ?>
<div class="table-wrap">
<table class="data sq-history">
  <thead><tr><th><?= e(t('admin.col.date')) ?></th><th><?= e(t('admin.social.col_network')) ?></th><th><?= e(t('admin.social.col_content')) ?></th><th><?= e(t('admin.f.status')) ?></th><th><?= e(t('admin.social.col_detail')) ?></th></tr></thead>
  <tbody>
  <?php foreach ($rows as $r): ?>
    <tr>
      <td><?= e(Schedule::toLocal($r['published_at'] ?? $r['scheduled_at'])) ?></td>
      <td><?= e(t($networks[$r['network']] ?? $r['network'])) ?><br><small class="muted"><?= e($r['account_username'] ? '@' . $r['account_username'] : (string) $r['account_name']) ?></small></td>
      <td><?= e($r['title']) ?><br><small class="muted"><?= e(($channels[(int) $r['channel_id']]['name'] ?? '') . ' · ' . t('admin.social.type.' . $r['content_type'])) ?></small></td>
      <td><span class="tag tag--<?= e($r['status']) ?>"><?= e(t('admin.social.status.' . $r['status'])) ?></span></td>
      <td>
        <?php if ($r['permalink']): ?><a href="<?= e($r['permalink']) ?>" target="_blank" rel="noopener"><?= icon('external') ?><?= e(t('admin.social.view_post')) ?></a><?php endif; ?>
        <?php if ($r['error']): ?><p class="sq-net__error"><?= e($r['error']) ?></p><?php endif; ?>
        <?php if ((int) $r['attempts'] > 1): ?><small class="muted"><?= e(t('admin.social.attempts', ['n' => (int) $r['attempts']])) ?></small><?php endif; ?>
        <?php if (in_array($r['status'], ['failed', 'skipped'], true)): ?>
        <form method="post" action="<?= e(route('admin.social.group', ['token' => $r['group_key']])) ?>" class="sq-inline-form">
          <?= csrf_field() ?><input type="hidden" name="return" value="<?= e($return) ?>">
          <button class="btn btn--ghost btn--small" type="submit" name="action" value="approve"><?= e(t('admin.social.retry')) ?></button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php endif; ?>
