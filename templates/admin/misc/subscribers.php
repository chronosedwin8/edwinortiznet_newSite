<?php /** @var array $subscribers @var array $byTag @var array $waitlist */ ?>
<p class="actions">
  <a class="btn btn--small" href="<?= e(route('admin.subscribers.export')) ?>"><?= e(t('admin.subscribers.export')) ?></a>
  <a class="btn btn--small btn--ghost" href="<?= e(route('admin.waitlist.export')) ?>"><?= e(t('admin.waitlist.export')) ?></a>
</p>
<div class="grid-2">
  <section class="panel">
    <h2><?= e(t('admin.subscribers.by_tag')) ?></h2>
    <?php if (!$byTag): ?><p class="muted"><?= e(t('admin.subscribers.empty')) ?></p><?php endif; ?>
    <table><tbody><?php foreach ($byTag as $tg): ?><tr><td><?= e($tg['tag']) ?></td><td><?= e(t('admin.subscribers.active_total', ['active' => (int) $tg['active'], 'total' => (int) $tg['total']])) ?></td></tr><?php endforeach; ?></tbody></table>
  </section>
  <section class="panel">
    <h2><?= e(t('admin.dash.waitlist')) ?></h2>
    <?php if (!$waitlist): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <table><tbody><?php foreach ($waitlist as $w): ?><tr><td><?= e($w['title']) ?></td><td><?= (int) $w['n'] ?></td></tr><?php endforeach; ?></tbody></table>
    <?php endif; ?>
  </section>
</div>
<?php if ($subscribers): ?>
<table class="data">
  <thead><tr><th><?= e(t('form.email')) ?></th><th><?= e(t('admin.f.locale')) ?></th><th><?= e(t('admin.col.tag')) ?></th><th><?= e(t('admin.col.source')) ?></th><th><?= e(t('admin.f.status')) ?></th><th><?= e(t('admin.col.date')) ?></th></tr></thead>
  <tbody>
  <?php foreach ($subscribers as $s): ?>
    <tr><td><?= e($s['email']) ?></td><td><?= e(strtoupper($s['locale'])) ?></td><td><?= e($s['tag']) ?></td><td><?= e((string) $s['source']) ?></td>
      <td><?= e(t($s['unsubscribed_at'] ? 'admin.subscribers.unsubscribed' : ($s['confirmed_at'] ? 'admin.subscribers.confirmed' : 'admin.subscribers.pending'))) ?></td>
      <td><?= e(substr((string) $s['created_at'], 0, 10)) ?></td></tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
