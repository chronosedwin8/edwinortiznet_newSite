<?php
/** @var array $issues */

use App\Core\View;
use App\Services\Newsletter\NewsletterSettings as NS;

$pct = static fn (int $part, int $whole): string => $whole > 0 ? round($part / $whole * 100) . '%' : '—';
?>
<?= View::render('admin/newsletter/tabs', ['current' => 'history']) ?>
<?php if (!$issues): ?>
<p class="muted"><?= e(t('admin.nl.no_history')) ?></p>
<?php else: ?>
<p class="muted"><?= e(t('admin.nl.history_note')) ?></p>
<div class="table-wrap">
<table class="data data--subs">
  <thead><tr>
    <th><?= e(t('admin.col.date')) ?></th>
    <th><?= e(t('admin.f.status')) ?></th>
    <th><?= e(t('admin.nl.subject')) ?></th>
    <th class="num"><?= e(t('admin.nl.col.sent')) ?></th>
    <th class="num"><?= e(t('admin.nl.col.opens')) ?></th>
    <th class="num"><?= e(t('admin.nl.col.clicks')) ?></th>
    <th class="num"><?= e(t('admin.nl.col.unsubs')) ?></th>
    <th class="num"><?= e(t('admin.nl.col.failed')) ?></th>
  </tr></thead>
  <tbody>
  <?php foreach ($issues as $i): $st = $i['stats']; $sent = (int) ($st['sent'] ?? 0); ?>
    <tr>
      <td><?= e(NS::local($i['started_at'] ?? $i['scheduled_for'], 'd/m/Y g:i a')) ?><span class="sub-meta"><code><?= e($i['issue_key']) ?></code></span></td>
      <td><span class="tag tag--<?= e($i['status']) ?>"><?= e(t('admin.nl.status.' . $i['status'])) ?></span><?php if ($i['note']): ?><span class="sub-meta"><?= e($i['note']) ?></span><?php endif; ?></td>
      <td><?= e((string) $i['subject']) ?>
        <?php if ($i['links']): ?>
        <details><summary class="sub-meta"><?= e(t('admin.nl.top_links')) ?></summary>
          <ol class="nl-links"><?php foreach ($i['links'] as $l): ?><li><a href="<?= e($l['url']) ?>" target="_blank" rel="noopener"><?= e(preg_replace('/[?&]utm_[^&]*/', '', (string) $l['url'])) ?></a> — <?= (int) $l['n'] ?></li><?php endforeach; ?></ol>
        </details>
        <?php endif; ?></td>
      <td class="num"><?= $sent ?><span class="sub-meta"><?= e(t('admin.nl.of', ['n' => (int) $i['recipients']])) ?></span></td>
      <td class="num"><?= (int) ($st['opened'] ?? 0) ?><span class="sub-meta"><?= e($pct((int) ($st['opened'] ?? 0), $sent)) ?></span></td>
      <td class="num"><?= (int) ($st['clicked'] ?? 0) ?><span class="sub-meta"><?= e($pct((int) ($st['clicked'] ?? 0), $sent)) ?></span></td>
      <td class="num"><?= (int) ($st['unsubscribed'] ?? 0) ?></td>
      <td class="num"><?= (int) ($st['failed'] ?? 0) ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php endif; ?>
