<?php /** @var array $accounts @var array $stats @var string $q */ ?>
<section class="kpis">
  <div class="kpi">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('puzzle') ?></span><?= e(t('admin.piar.k_paid')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['paid'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.piar.k_last30', ['n' => (int) ($stats['last30'] ?? 0)])) ?></span>
  </div>
  <div class="kpi kpi--accent">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('spark') ?></span><?= e(t('admin.piar.k_trials')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['trials'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.piar.k_errors', ['n' => (int) ($stats['errors'] ?? 0)])) ?></span>
  </div>
  <div class="kpi">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('chart') ?></span><?= e(t('admin.piar.k_usage')) ?></span>
    <span class="kpi__value"><?= e(number_format((int) ($stats['tin'] ?? 0) + (int) ($stats['tout'] ?? 0), 0, ',', '.')) ?></span>
    <span class="kpi__sub"><?= e(t('admin.piar.k_usage_sub', ['in' => number_format((int) ($stats['tin'] ?? 0), 0, ',', '.'), 'out' => number_format((int) ($stats['tout'] ?? 0), 0, ',', '.')])) ?></span>
  </div>
</section>

<section class="panel">
  <h2><?= e(t('admin.piar.grant_title')) ?></h2>
  <p class="muted"><?= e(t('admin.piar.grant_help')) ?></p>
  <form method="post" action="/admin/piar/" class="admin-form inline-form">
    <?= csrf_field() ?>
    <label for="pg-email"><?= e(t('admin.login.email')) ?></label>
    <input id="pg-email" name="email" type="email" required maxlength="190" value="<?= e(str_contains($q, '@') ? $q : '') ?>">
    <label for="pg-name"><?= e(t('admin.piar.name')) ?></label>
    <input id="pg-name" name="name" maxlength="120">
    <label for="pg-credits"><?= e(t('admin.piar.credits')) ?></label>
    <input id="pg-credits" name="credits" type="number" min="1" max="500" value="5" required>
    <label for="pg-days"><?= e(t('admin.piar.days')) ?></label>
    <input id="pg-days" name="days" type="number" min="1" max="366" value="30" required>
    <label for="pg-note"><?= e(t('admin.field.note')) ?></label>
    <input id="pg-note" name="note" maxlength="190">
    <button class="btn" type="submit"><?= e(t('admin.piar.grant')) ?></button>
  </form>
</section>

<form class="filters-bar" method="get" action="/admin/piar/">
  <label><?= e(t('admin.f.search')) ?> <input type="search" name="q" value="<?= e($q) ?>"></label>
  <button class="btn btn--small" type="submit"><?= e(t('admin.filter')) ?></button>
</form>
<?php if (!$accounts): ?>
<p class="muted"><?= e(t('admin.none')) ?></p>
<?php else: ?>
<div class="table-wrap">
<table class="data">
  <thead><tr><th><?= e(t('admin.col.customer')) ?></th><th><?= e(t('admin.piar.col_trial')) ?></th><th><?= e(t('admin.piar.col_credits')) ?></th><th><?= e(t('admin.piar.col_expires')) ?></th><th><?= e(t('admin.piar.col_plans')) ?></th><th><?= e(t('admin.piar.col_last')) ?></th></tr></thead>
  <tbody>
  <?php foreach ($accounts as $a): $active = (int) $a['credits'] > 0; ?>
    <tr>
      <td><?= e($a['name'] ?: '—') ?><br><small class="muted"><?= e($a['email']) ?><?= $a['institution'] ? ' · ' . e($a['institution']) : '' ?></small><?php if (!$a['terms_accepted_at']): ?><br><span class="tag tag--pending"><?= e(t('admin.piar.no_terms')) ?></span><?php endif; ?></td>
      <td><?= (int) $a['trial_used'] ?>/<?= \App\Services\Piar\PiarCredits::TRIAL_LIMIT ?></td>
      <td><?php if ($active): ?><span class="tag tag--published"><?= (int) $a['used'] ?>/<?= (int) $a['credits'] ?></span><?php else: ?><span class="muted">—</span><?php endif; ?></td>
      <td><?= $a['expires_at'] ? e(substr((string) $a['expires_at'], 0, 10)) : '—' ?></td>
      <td><?= (int) $a['plans_done'] ?></td>
      <td><?= $a['last_plan_at'] ? e(substr((string) $a['last_plan_at'], 0, 16)) : '—' ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php endif; ?>
