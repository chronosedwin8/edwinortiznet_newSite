<?php
/** @var array $rows @var array $filters @var int $total @var int $pages @var array $stats @var array $byInterest @var array $bySource
 *  @var array $topPages @var array $waitlist @var array $query @var string $returnUrl */

use App\Services\Newsletter\Interests;

$fmt = static fn (?string $d): string => $d ? \App\Services\Newsletter\NewsletterSettings::local($d, 'Y-m-d') : '—';
$maxInterest = max(1, ...array_values($byInterest));
$maxSource = max(1, ...array_map('intval', array_column($bySource, 'total') ?: [0]));
$chips = static function (?string $set): string {
    $list = Interests::fromSet($set);
    if ($list === []) {
        return '<span class="chip chip--none">' . e(t('admin.subs.interest.none')) . '</span>';
    }
    return implode('', array_map(fn ($i) => '<span class="chip chip--' . e($i) . '">' . e(t("admin.subs.interest.$i")) . '</span>', $list));
};
$page = static fn (int $n): string => '/admin/suscriptores/?' . http_build_query($query + ['pagina' => $n]);
?>
<link rel="stylesheet" href="<?= e(asset('css/admin-newsletter.css')) ?>">
<p class="actions">
  <a class="btn btn--small" href="<?= e(route('admin.subscribers.export') . ($query ? '?' . http_build_query($query) : '')) ?>"><?= icon('download') ?><?= e(t('admin.subscribers.export')) ?></a>
  <a class="btn btn--small btn--ghost" href="<?= e(route('admin.waitlist.export')) ?>"><?= e(t('admin.waitlist.export')) ?></a>
  <a class="btn btn--small btn--ghost" href="<?= e(route('admin.newsletter')) ?>"><?= icon('mail') ?><?= e(t('admin.newsletter')) ?></a>
</p>

<div class="kpis">
  <a class="kpi kpi--accent" href="/admin/suscriptores/?estado=active">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('users') ?></span><?= e(t('admin.subs.kpi.active')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['active'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.subs.kpi.active_sub', ['n' => (int) ($stats['confirmed30'] ?? 0), 'p' => (int) ($stats['paused'] ?? 0)])) ?></span>
  </a>
  <a class="kpi kpi--warn" href="/admin/suscriptores/?estado=pending">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('clock') ?></span><?= e(t('admin.subs.kpi.pending')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['pending'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.subs.kpi.pending_sub')) ?></span>
  </a>
  <div class="kpi">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('chart') ?></span><?= e(t('admin.subs.kpi.new30')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['new30'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.subs.kpi.new30_sub', ['n' => (int) ($stats['unsub30'] ?? 0)])) ?></span>
  </div>
  <a class="kpi" href="/admin/suscriptores/?estado=unsubscribed">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('logout') ?></span><?= e(t('admin.subs.kpi.out')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['unsubscribed'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.subs.kpi.out_sub', ['n' => (int) ($stats['blocked'] ?? 0)])) ?></span>
  </a>
</div>

<div class="grid-2">
  <section class="panel">
    <h2><?= e(t('admin.subs.by_interest')) ?></h2>
    <ul class="hbars">
      <?php foreach ($byInterest as $key => $n): ?>
      <li><a href="/admin/suscriptores/?estado=active&amp;tema=<?= e($key) ?>"><?= e(t("admin.subs.interest.$key")) ?></a>
        <span class="hbars__track" aria-hidden="true"><span class="hbars__fill" style="width:<?= round($n / $maxInterest * 100, 1) ?>%"></span></span>
        <span class="hbars__value"><?= (int) $n ?></span></li>
      <?php endforeach; ?>
    </ul>
    <p class="muted"><?= e(t('admin.subs.by_interest_note')) ?></p>
  </section>
  <section class="panel">
    <h2><?= e(t('admin.subs.by_source')) ?></h2>
    <?php if (!$bySource): ?><p class="muted"><?= e(t('admin.subscribers.empty')) ?></p><?php else: ?>
    <ul class="hbars">
      <?php foreach ($bySource as $src): ?>
      <li><a href="/admin/suscriptores/?origen=<?= e($src['source_type']) ?>"><?= e(t('admin.subs.source.' . $src['source_type'])) ?></a>
        <span class="hbars__track" aria-hidden="true"><span class="hbars__fill" style="width:<?= round((int) $src['total'] / $maxSource * 100, 1) ?>%"></span></span>
        <span class="hbars__value" title="<?= e(t('admin.subs.active_of', ['a' => (int) $src['active'], 't' => (int) $src['total']])) ?>"><?= (int) $src['total'] ?></span></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <?php if ($topPages): ?>
    <h3><?= e(t('admin.subs.top_pages')) ?></h3>
    <ul class="hbars">
      <?php foreach ($topPages as $tp): ?>
      <li><a href="<?= e($tp['source_path']) ?>" target="_blank" rel="noopener"><?= e(excerpt_text((string) ($tp['source_title'] ?: (in_array($tp['source_path'], ['/', '/en/'], true) ? t('admin.subs.source.home') : $tp['source_path'])), 48)) ?></a>
        <span class="muted"><?= e(t('admin.subs.source.' . $tp['source_type'])) ?></span>
        <span class="hbars__value" title="<?= e(t('admin.subs.active_of', ['a' => (int) $tp['active'], 't' => (int) $tp['total']])) ?>"><?= (int) $tp['active'] ?></span></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
</div>

<form class="filters-bar" method="get" action="/admin/suscriptores/">
  <label class="grow"><?= e(t('admin.f.search')) ?> <input type="search" name="q" value="<?= e($filters['q']) ?>" placeholder="<?= e(t('admin.subs.search_ph')) ?>"></label>
  <label><?= e(t('admin.f.status')) ?>
    <select name="estado"><option value=""><?= e(t('admin.all')) ?></option>
      <?php foreach ([...Interests::STATUSES, 'paused'] as $st): ?><option value="<?= e($st) ?>"<?= $filters['status'] === $st ? ' selected' : '' ?>><?= e(t("admin.subs.status.$st")) ?></option><?php endforeach; ?>
    </select>
  </label>
  <label><?= e(t('admin.subs.f.interest')) ?>
    <select name="tema"><option value=""><?= e(t('admin.all')) ?></option>
      <?php foreach ([...Interests::ALL, 'none'] as $i): ?><option value="<?= e($i) ?>"<?= $filters['interest'] === $i ? ' selected' : '' ?>><?= e(t("admin.subs.interest.$i")) ?></option><?php endforeach; ?>
    </select>
  </label>
  <label><?= e(t('admin.col.source')) ?>
    <select name="origen"><option value=""><?= e(t('admin.all')) ?></option>
      <?php foreach (Interests::SOURCE_TYPES as $src): ?><option value="<?= e($src) ?>"<?= $filters['source'] === $src ? ' selected' : '' ?>><?= e(t("admin.subs.source.$src")) ?></option><?php endforeach; ?>
    </select>
  </label>
  <button class="btn btn--small" type="submit"><?= e(t('admin.filter')) ?></button>
  <?php if ($query): ?><a class="btn btn--small btn--ghost" href="/admin/suscriptores/"><?= e(t('admin.subs.clear_filters')) ?></a><?php endif; ?>
</form>
<p class="muted"><?= e(t('admin.count', ['n' => $total])) ?></p>

<?php if (!$rows): ?>
<p class="muted"><?= e(t('admin.subscribers.empty')) ?></p>
<?php else: ?>
<div class="table-wrap">
<table class="data data--subs">
  <thead><tr>
    <th class="col-check"><input type="checkbox" data-select-all aria-label="<?= e(t('admin.bulk.select_all')) ?>" title="<?= e(t('admin.bulk.select_all')) ?>" hidden></th>
    <th><?= e(t('form.email')) ?></th>
    <th><?= e(t('admin.f.status')) ?></th>
    <th><?= e(t('admin.subs.col.interests')) ?></th>
    <th><?= e(t('admin.col.source')) ?></th>
    <th><?= e(t('admin.subs.col.subscribed')) ?></th>
    <th><?= e(t('admin.subs.col.confirmed')) ?></th>
    <th><?= e(t('admin.subs.col.last')) ?></th>
    <th class="num"><?= e(t('admin.subs.col.engagement')) ?></th>
  </tr></thead>
  <tbody>
  <?php foreach ($rows as $s):
      $paused = $s['status'] === 'active' && $s['paused_until'] !== null && strtotime($s['paused_until'] . ' UTC') > time();
      $state = $paused ? 'paused' : $s['status']; ?>
    <tr>
      <td class="col-check"><input type="checkbox" name="ids[]" value="<?= (int) $s['id'] ?>" form="subs-bulk" data-row-check aria-label="<?= e(t('admin.bulk.select', ['title' => $s['email']])) ?>"></td>
      <td><span class="sub-email"><?= e($s['email']) ?></span>
        <span class="sub-meta"><?= e(strtoupper((string) $s['locale'])) ?><?php if ((int) $s['same_ip'] >= 3): ?> · <span class="sub-flag" title="<?= e(t('admin.subs.same_ip_help')) ?>"><?= e(t('admin.subs.same_ip', ['n' => (int) $s['same_ip']])) ?></span><?php endif; ?></span></td>
      <td><span class="tag tag--<?= e($state) ?>"><?= e(t("admin.subs.status.$state")) ?></span>
        <?php if ($paused): ?><span class="sub-meta"><?= e(t('admin.subs.until', ['date' => $fmt($s['paused_until'])])) ?></span><?php endif; ?>
        <?php if ($s['unsubscribed_reason']): ?><span class="sub-meta"><?= e(excerpt_text((string) $s['unsubscribed_reason'], 60)) ?></span><?php endif; ?></td>
      <td><div class="chips"><?= $chips($s['interests']) ?></div></td>
      <td class="sub-source"><?= e(t('admin.subs.source.' . $s['source_type'])) ?>
        <?php if ($s['source_path']): ?><span class="sub-meta"><a href="<?= e($s['source_path']) ?>" target="_blank" rel="noopener"><?= e(excerpt_text((string) ($s['source_title'] ?: $s['source_path']), 50)) ?></a></span><?php endif; ?>
        <?php if ($s['utm_source'] || $s['referrer']): ?><span class="sub-meta"><?= e(trim(($s['utm_source'] ? 'utm: ' . $s['utm_source'] . ($s['utm_campaign'] ? '/' . $s['utm_campaign'] : '') : '') . ($s['referrer'] ? ' · ' . $s['referrer'] : ''), ' ·')) ?></span><?php endif; ?></td>
      <td><?= e($fmt($s['created_at'])) ?></td>
      <td><?= e($fmt($s['confirmed_at'])) ?></td>
      <td><?= e($fmt($s['last_sent_at'])) ?><?php if ((int) $s['sends_count'] > 0): ?><span class="sub-meta"><?= e(t('admin.subs.sends', ['n' => (int) $s['sends_count']])) ?></span><?php endif; ?></td>
      <td class="num"><?= e(t('admin.subs.engagement', ['o' => (int) $s['opens_count'], 'c' => (int) $s['clicks_count']])) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php if ($pages > 1): ?>
<nav class="pager" aria-label="<?= e(t('admin.subs.pages')) ?>">
  <?php for ($n = 1; $n <= $pages; $n++): ?>
    <?php if ($n === $filters['page']): ?><span aria-current="page"><?= $n ?></span><?php else: ?><a href="<?= e($page($n)) ?>"><?= $n ?></a><?php endif; ?>
  <?php endfor; ?>
</nav>
<?php endif; ?>

<form id="subs-bulk" class="bulk-bar" method="post" action="<?= e(route('admin.subscribers.bulk')) ?>" data-bulk-bar aria-label="<?= e(t('admin.bulk.label')) ?>"
      data-confirm="<?= e(t('admin.subs.confirm')) ?>" data-confirm-ok="<?= e(t('admin.subs.apply')) ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="return" value="<?= e($returnUrl) ?>">
  <p class="bulk-bar__count" data-bulk-count aria-live="polite" data-one="<?= e(t('admin.bulk.count_one')) ?>" data-many="<?= e(t('admin.bulk.count')) ?>"><?= e(t('admin.bulk.nojs')) ?></p>
  <label class="visually-hidden" for="subs-action"><?= e(t('admin.subs.action')) ?></label>
  <select class="field" id="subs-action" name="action" required>
    <option value=""><?= e(t('admin.subs.action')) ?></option>
    <option value="interests"><?= e(t('admin.subs.do.interests')) ?></option>
    <option value="resend"><?= e(t('admin.subs.do.resend')) ?></option>
    <option value="active"><?= e(t('admin.subs.do.active')) ?></option>
    <option value="unsubscribed"><?= e(t('admin.subs.do.unsubscribed')) ?></option>
    <option value="bounced"><?= e(t('admin.subs.do.bounced')) ?></option>
    <option value="spam"><?= e(t('admin.subs.do.spam')) ?></option>
    <option value="delete"><?= e(t('admin.subs.do.delete')) ?></option>
  </select>
  <button type="button" class="btn btn--ghost btn--small" data-bulk-clear hidden><?= e(t('admin.bulk.clear')) ?></button>
  <button type="submit" class="btn btn--small"><?= e(t('admin.subs.apply')) ?></button>
  <fieldset class="chip-pick" aria-label="<?= e(t('admin.subs.do.interests_help')) ?>">
    <?php foreach (Interests::ALL as $i): ?><label><input type="checkbox" name="interests[]" value="<?= e($i) ?>"><span><?= e(t("admin.subs.interest.$i")) ?></span></label><?php endforeach; ?>
    <small class="muted"><?= e(t('admin.subs.do.interests_help')) ?></small>
  </fieldset>
</form>
<?php endif; ?>

<?php if ($waitlist): ?>
<section class="panel">
  <h2><?= e(t('admin.dash.waitlist')) ?></h2>
  <table><tbody><?php foreach ($waitlist as $w): ?><tr><td><?= e($w['title']) ?></td><td><?= (int) $w['n'] ?></td></tr><?php endforeach; ?></tbody></table>
</section>
<?php endif; ?>
