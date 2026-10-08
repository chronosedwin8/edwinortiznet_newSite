<?php
/** @var array $groups @var array $channels @var int $channelId @var array $options @var array $stats @var array $accounts @var string|null $lastPlan @var bool $needsConnect */

use App\Core\View;
use App\Services\Social\CaptionWriter;
use App\Services\Social\Queue;
use App\Services\Social\Schedule;

$return = '/admin/redes/' . ($channelId > 0 ? '?canal=' . $channelId : '');
$networks = ['fb' => 'admin.social.net.fb', 'ig' => 'admin.social.net.ig'];
?>
<?= View::render('admin/social/tabs', ['current' => 'queue']) ?>

<?php if ($needsConnect): ?>
<p class="sq-notice"><?= icon('notice') ?><span><?= e(t('admin.social.connect_first')) ?> <a href="/admin/redes/ajustes/"><?= e(t('admin.social.tab_settings')) ?></a></span></p>
<?php endif; ?>

<section class="kpis">
  <div class="kpi kpi--warn">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('clock') ?></span><?= e(t('admin.social.k_drafts')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['drafts'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.social.k_drafts_sub')) ?></span>
  </div>
  <div class="kpi">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('check') ?></span><?= e(t('admin.social.k_approved')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['approved'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.social.k_approved_sub')) ?></span>
  </div>
  <div class="kpi kpi--accent">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('share') ?></span><?= e(t('admin.social.k_published')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['published30'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.social.k_failed', ['n' => (int) ($stats['failed7'] ?? 0)])) ?></span>
  </div>
</section>

<div class="page-head sq-head">
  <nav class="tabs" aria-label="<?= e(t('admin.social.channels')) ?>">
    <a class="tab<?= $channelId === 0 ? ' is-active' : '' ?>" href="/admin/redes/"><?= e(t('admin.social.all_channels')) ?></a>
    <?php foreach ($channels as $id => $c): ?>
    <a class="tab<?= $channelId === $id ? ' is-active' : '' ?>" href="/admin/redes/?canal=<?= (int) $id ?>"><?= e($c['name']) ?></a>
    <?php endforeach; ?>
  </nav>
  <div class="sq-head__actions">
    <form method="post" action="<?= e(route('admin.social.approve_week')) ?>" data-confirm="<?= e(t('admin.social.approve_week_q')) ?>" data-confirm-ok="<?= e(t('admin.social.approve')) ?>">
      <?= csrf_field() ?><input type="hidden" name="channel" value="<?= (int) $channelId ?>">
      <button class="btn btn--small" type="submit"><?= icon('check') ?><?= e(t('admin.social.approve_week')) ?></button>
    </form>
    <form method="post" action="<?= e(route('admin.social.plan')) ?>">
      <?= csrf_field() ?>
      <button class="btn btn--ghost btn--small" type="submit"><?= icon('calendar') ?><?= e(t('admin.social.plan_now')) ?></button>
    </form>
  </div>
</div>
<p class="muted sq-meta"><?= e(t('admin.social.queue_help')) ?><?php if ($lastPlan): ?> <?= e(t('admin.social.last_plan', ['date' => Schedule::toLocal($lastPlan)])) ?><?php endif; ?></p>

<?php if (!$groups): ?>
<p class="muted"><?= e(t('admin.social.queue_empty')) ?></p>
<?php endif; ?>

<?php foreach ($groups as $g):
    $channel = $channels[$g['channel_id']] ?? null;
    $editable = array_filter($g['rows'], fn ($r) => in_array($r['status'], Queue::EDITABLE, true)) !== [];
    $allApproved = array_filter($g['rows'], fn ($r) => $r['status'] !== 'approved') === [];
    $first = reset($g['rows']);
    $action = e(route('admin.social.group', ['token' => $g['key']]));
?>
<article class="sq-card" id="g-<?= e($g['key']) ?>">
  <header class="sq-card__head">
    <p class="sq-card__when"><?= icon('calendar') ?><time datetime="<?= e(str_replace(' ', 'T', (string) $g['scheduled_at']) . 'Z') ?>"><?= e(Schedule::toLocal($g['scheduled_at'], 'Y-m-d H:i')) ?></time>
      <?php if ($channel): ?><span class="tag tag--plain"><?= e($channel['name']) ?></span><?php endif; ?>
      <span class="tag tag--plain"><?= e(t('admin.social.type.' . $g['content_type'])) ?></span>
      <?php if ($first['created_by'] === 'admin'): ?><span class="tag tag--plain"><?= e(t('admin.social.by_admin')) ?></span><?php endif; ?>
    </p>
    <h2 class="sq-card__title"><a href="<?= e(strtok((string) $first['link'], '?')) ?>" target="_blank" rel="noopener"><?= e($g['title']) ?></a></h2>
  </header>

  <form method="post" action="<?= $action ?>" class="admin-form sq-form">
    <?= csrf_field() ?>
    <input type="hidden" name="return" value="<?= e($return) ?>">
    <div class="sq-nets">
      <?php foreach ($g['rows'] as $net => $row):
          $account = $accounts[(int) $row['account_id']] ?? null;
          $canEdit = in_array($row['status'], Queue::EDITABLE, true);
          $fid = 'f' . (int) $row['id'];
      ?>
      <section class="sq-net sq-net--<?= e($net) ?>">
        <h3 class="sq-net__name"><span><?= e(t($networks[$net])) ?><?php if ($account): ?> <small><?= e($account['username'] ? '@' . $account['username'] : $account['name']) ?></small><?php endif; ?></span>
          <span class="tag tag--<?= e($row['status']) ?>"><?= e(t('admin.social.status.' . $row['status'])) ?></span></h3>
        <?php if ($row['image_path']): ?>
        <img class="sq-net__img" src="<?= e($row['image_path']) ?>" alt="" loading="lazy" decoding="async">
        <?php else: ?>
        <p class="sq-net__noimg"><?= e(t('admin.social.no_image')) ?></p>
        <?php endif; ?>
        <div class="sq-net__text"><?= e(CaptionWriter::message($net, (string) $row['caption'], $row['hashtags'], (string) $row['link'])) ?></div>
        <p class="sq-net__meta"><?= e(t('admin.social.source.' . $row['caption_source'])) ?></p>
        <?php if ($row['error']): ?><p class="sq-net__error"><?= icon('notice') ?><span><?= e($row['error']) ?></span></p><?php endif; ?>
        <?php if ($row['permalink']): ?><p><a href="<?= e($row['permalink']) ?>" target="_blank" rel="noopener"><?= icon('external') ?><?= e(t('admin.social.view_post')) ?></a></p><?php endif; ?>
        <?php if ($canEdit): ?>
        <details class="sq-edit">
          <summary><?= e(t('admin.social.edit_text')) ?></summary>
          <label for="<?= $fid ?>-c"><?= e(t('admin.social.caption')) ?></label>
          <textarea id="<?= $fid ?>-c" name="caption[<?= e($net) ?>]" rows="<?= $net === 'ig' ? 10 : 6 ?>"><?= e((string) $row['caption']) ?></textarea>
          <label for="<?= $fid ?>-h"><?= e(t('admin.social.hashtags')) ?></label>
          <input id="<?= $fid ?>-h" name="hashtags[<?= e($net) ?>]" value="<?= e((string) $row['hashtags']) ?>">
          <p class="hint"><?= e(t('admin.social.hint.' . $net)) ?></p>
        </details>
        <?php endif; ?>
      </section>
      <?php endforeach; ?>
    </div>

    <?php if ($editable): ?>
    <div class="sq-actions">
      <button class="btn btn--small" type="submit" name="action" value="save_approve"><?= icon('check') ?><?= e(t($allApproved ? 'admin.social.save' : 'admin.social.save_approve')) ?></button>
      <?php if ($allApproved): ?>
      <button class="btn btn--ghost btn--small" type="submit" name="action" value="unapprove"><?= e(t('admin.social.unapprove')) ?></button>
      <?php else: ?>
      <button class="btn btn--ghost btn--small" type="submit" name="action" value="save"><?= e(t('admin.social.save_draft')) ?></button>
      <?php endif; ?>
      <button class="btn btn--ghost btn--small" type="submit" name="action" value="regenerate"><?= icon('spark') ?><?= e(t('admin.social.regenerate')) ?></button>
      <button class="btn btn--ghost btn--small" type="submit" name="action" value="skip"><?= e(t('admin.social.skip')) ?></button>
    </div>
    <div class="sq-actions sq-actions--fields">
      <label class="sq-inline"><span><?= e(t('admin.social.change_content')) ?></span>
        <select name="content_key">
          <?php foreach ($options[$g['channel_id']] ?? [] as $opt): ?>
          <option value="<?= e($opt['key']) ?>"<?= $opt['key'] === $g['content_key'] ? ' selected' : '' ?>><?= e(t('admin.social.type.' . $opt['type']) . ' · ' . $opt['title']) ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <button class="btn btn--ghost btn--small" type="submit" name="action" value="change"><?= e(t('admin.social.change')) ?></button>
      <label class="sq-inline"><span><?= e(t('admin.social.date_local')) ?></span>
        <input type="datetime-local" name="scheduled_local" value="<?= e(Schedule::toLocal($g['scheduled_at'], 'Y-m-d\TH:i')) ?>">
      </label>
      <button class="btn btn--ghost btn--small" type="submit" name="action" value="reschedule"><?= e(t('admin.social.reschedule')) ?></button>
    </div>
    <?php elseif (array_filter($g['rows'], fn ($r) => $r['status'] === 'skipped') !== []): ?>
    <div class="sq-actions">
      <button class="btn btn--ghost btn--small" type="submit" name="action" value="approve"><?= e(t('admin.social.restore')) ?></button>
    </div>
    <?php endif; ?>
  </form>

  <?php if ($editable || array_filter($g['rows'], fn ($r) => $r['status'] === 'skipped') !== []): ?>
  <div class="sq-actions sq-actions--end">
    <form method="post" action="<?= $action ?>" data-confirm="<?= e(t('admin.social.publish_now_q')) ?>" data-confirm-ok="<?= e(t('admin.social.publish_now')) ?>">
      <?= csrf_field() ?><input type="hidden" name="return" value="<?= e($return) ?>">
      <button class="btn btn--small" type="submit" name="action" value="publish"><?= icon('share') ?><?= e(t('admin.social.publish_now')) ?></button>
    </form>
    <form method="post" action="<?= $action ?>" data-confirm="<?= e(t('admin.social.delete_q')) ?>" data-confirm-ok="<?= e(t('admin.delete')) ?>">
      <?= csrf_field() ?><input type="hidden" name="return" value="<?= e($return) ?>">
      <button class="btn btn--danger btn--small" type="submit" name="action" value="delete"><?= icon('trash') ?><?= e(t('admin.delete')) ?></button>
    </form>
  </div>
  <?php endif; ?>
</article>
<?php endforeach; ?>
