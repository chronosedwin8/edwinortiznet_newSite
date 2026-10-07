<?php /** @var array $accounts @var array $stats @var array $tokens @var float $cost30 @var array $plans @var string $q */ ?>
<section class="kpis">
  <div class="kpi">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('list-ol') ?></span><?= e(t('admin.examenes.k_done')) ?></span>
    <span class="kpi__value"><?= (int) ($stats['done'] ?? 0) ?></span>
    <span class="kpi__sub"><?= e(t('admin.examenes.k_last30', ['n' => (int) ($stats['last30'] ?? 0), 'e' => (int) ($stats['errors'] ?? 0)])) ?></span>
  </div>
  <div class="kpi kpi--accent">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('spark') ?></span><?= e(t('admin.examenes.k_questions')) ?></span>
    <span class="kpi__value"><?= e(number_format((int) ($stats['questions'] ?? 0), 0, ',', '.')) ?></span>
    <span class="kpi__sub"><?= e(t('admin.examenes.k_calls', ['n' => number_format((int) ($tokens['calls'] ?? 0), 0, ',', '.')])) ?></span>
  </div>
  <div class="kpi">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('chart') ?></span><?= e(t('admin.examenes.k_cost')) ?></span>
    <span class="kpi__value"><?= e(money(round($cost30), 'COP', 'es')) ?></span>
    <span class="kpi__sub"><?= e(t('admin.examenes.k_cost_sub', ['in' => number_format((int) ($tokens['tin30'] ?? 0), 0, ',', '.'), 'out' => number_format((int) ($tokens['tout30'] ?? 0), 0, ',', '.')])) ?></span>
  </div>
</section>

<section class="panel">
  <h2><?= e(t('admin.examenes.grant_title')) ?></h2>
  <p class="muted"><?= e(t('admin.examenes.grant_help')) ?></p>
  <form method="post" action="/admin/examenes/" class="admin-form inline-form">
    <?= csrf_field() ?>
    <label for="eg-email"><?= e(t('admin.login.email')) ?></label>
    <input id="eg-email" name="email" type="email" required maxlength="190" value="<?= e(str_contains($q, '@') ? $q : '') ?>">
    <label for="eg-name"><?= e(t('admin.piar.name')) ?></label>
    <input id="eg-name" name="name" maxlength="120">
    <label for="eg-sku"><?= e(t('admin.examenes.plan')) ?></label>
    <select id="eg-sku" name="sku">
      <?php foreach ($plans as $sku => $p): ?><option value="<?= e($sku) ?>"><?= e(t('admin.examenes.plan_opt', ['sku' => $sku, 'exams' => $p['exams'], 'versions' => $p['versions'], 'questions' => $p['questions']])) ?></option><?php endforeach; ?>
    </select>
    <label for="eg-days"><?= e(t('admin.piar.days')) ?></label>
    <input id="eg-days" name="days" type="number" min="1" max="366" value="30" required>
    <label for="eg-note"><?= e(t('admin.field.note')) ?></label>
    <input id="eg-note" name="note" maxlength="190">
    <button class="btn" type="submit"><?= e(t('admin.examenes.grant')) ?></button>
  </form>
</section>

<form class="filters-bar" method="get" action="/admin/examenes/">
  <label><?= e(t('admin.f.search')) ?> <input type="search" name="q" value="<?= e($q) ?>"></label>
  <button class="btn btn--small" type="submit"><?= e(t('admin.filter')) ?></button>
</form>
<?php if (!$accounts): ?>
<p class="muted"><?= e(t('admin.none')) ?></p>
<?php else: ?>
<div class="table-wrap">
<table class="data">
  <thead><tr><th><?= e(t('admin.col.customer')) ?></th><th><?= e(t('admin.examenes.col_quota')) ?></th><th><?= e(t('admin.piar.col_expires')) ?></th><th><?= e(t('admin.examenes.col_done')) ?></th><th><?= e(t('admin.examenes.col_ai')) ?></th><th><?= e(t('admin.examenes.col_last')) ?></th></tr></thead>
  <tbody>
  <?php foreach ($accounts as $a): ?>
    <tr>
      <td><?= e($a['name'] ?: '—') ?><br><small class="muted"><?= e($a['email']) ?><?= $a['institution'] ? ' · ' . e($a['institution']) : '' ?></small><?php if (!$a['terms_accepted_at']): ?><br><span class="tag tag--pending"><?= e(t('admin.piar.no_terms')) ?></span><?php endif; ?></td>
      <td><?php if ((int) $a['quota'] > 0): ?><span class="tag tag--published"><?= (int) $a['used'] ?>/<?= (int) $a['quota'] ?></span><?php else: ?><span class="muted">—</span><?php endif; ?></td>
      <td><?= $a['expires_at'] ? e(substr((string) $a['expires_at'], 0, 10)) : '—' ?></td>
      <td><?= (int) $a['exams_done'] ?><?php if ((int) $a['exams_deleted'] > 0): ?> <small class="muted"><?= e(t('admin.examenes.deleted_n', ['n' => (int) $a['exams_deleted']])) ?></small><?php endif; ?></td>
      <td><?= (int) $a['ai_questions'] ?></td>
      <td><?= $a['last_exam_at'] ? e(substr((string) $a['last_exam_at'], 0, 16)) : '—' ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php endif; ?>
