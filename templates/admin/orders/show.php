<?php /** @var array $order @var array $events @var array $grants @var array $log */ ?>
<div class="grid-2">
  <section class="panel">
    <h2><?= e(t('admin.orders.summary')) ?></h2>
    <dl class="kv">
      <dt><?= e(t('admin.f.status')) ?></dt><dd><span class="tag tag--<?= e($order['status']) ?>"><?= e(t('status.' . $order['status'])) ?></span></dd>
      <dt><?= e(t('admin.col.customer')) ?></dt><dd><?= e($order['name']) ?> · <?= e($order['email']) ?></dd>
      <dt><?= e(t('checkout.document')) ?></dt><dd><?= e((string) $order['document']) ?></dd>
      <dt><?= e(t('checkout.phone')) ?></dt><dd><?= e((string) $order['phone']) ?></dd>
      <dt><?= e(t('account.col_total')) ?></dt><dd><?= e(money($order['total'], $order['currency'], 'es')) ?> (<?= e($order['currency']) ?>, <?= e(strtoupper($order['locale'])) ?>)</dd>
      <dt><?= e(t('admin.col.gateway')) ?></dt><dd><?= e(t('gateway.' . $order['gateway'])) ?> · <code><?= e((string) $order['gateway_id']) ?></code> <?= e((string) $order['gateway_status']) ?></dd>
      <dt><?= e(t('admin.col.date')) ?></dt><dd><?= e((string) $order['created_at']) ?> <?= e(t('admin.orders.utc')) ?></dd>
      <dt><?= e(t('admin.orders.paid_at')) ?></dt><dd><?= e((string) $order['paid_at']) ?></dd>
      <dt><?= e(t('admin.orders.public_link')) ?></dt><dd><a href="<?= e(route('order', ['token' => $order['token']], $order['locale'])) ?>" target="_blank" rel="noopener"><?= e(t('admin.view_public')) ?></a></dd>
    </dl>
    <ul>
      <?php foreach ($order['items'] as $item): ?><li><?= e($item['title']) ?> — <?= e(money($item['total'], $order['currency'], 'es')) ?></li><?php endforeach; ?>
    </ul>
    <div class="actions">
      <form method="post" action="<?= e(route('admin.orders.resend', ['id' => (int) $order['id']])) ?>"><?= csrf_field() ?><button class="btn btn--small" type="submit"><?= e(t('admin.orders.resend')) ?></button></form>
      <form method="post" action="<?= e(route('admin.orders.regenerate', ['id' => (int) $order['id']])) ?>"><?= csrf_field() ?><button class="btn btn--small btn--ghost" type="submit"><?= e(t('admin.orders.regenerate')) ?></button></form>
      <form method="post" action="<?= e(route('admin.orders.check', ['id' => (int) $order['id']])) ?>"><?= csrf_field() ?><button class="btn btn--small btn--ghost" type="submit"><?= e(t('admin.orders.check')) ?></button></form>
    </div>
  </section>
  <section class="panel">
    <h2><?= e(t('admin.orders.grants')) ?></h2>
    <?php if (!$grants): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <table><tbody>
      <?php foreach ($grants as $g): ?>
      <tr<?= $g['revoked_at'] ? ' class="muted"' : '' ?>><td><?= e($g['title']) ?></td><td><?= (int) $g['downloads'] ?>/<?= (int) $g['max_downloads'] ?></td><td><?= e(substr((string) $g['expires_at'], 0, 10)) ?></td><td><?= $g['revoked_at'] ? e(t('admin.orders.revoked')) : '' ?></td></tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>
    <h3><?= e(t('admin.orders.download_log')) ?></h3>
    <?php if (!$log): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <ul><?php foreach ($log as $l): ?><li><?= e((string) $l['created_at']) ?> · <?= e((string) $l['ip']) ?></li><?php endforeach; ?></ul>
    <?php endif; ?>
  </section>
</div>
<section class="panel">
  <h2><?= e(t('admin.orders.events')) ?></h2>
  <?php if (!$events): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
  <table class="data">
    <thead><tr><th><?= e(t('admin.col.date')) ?></th><th><?= e(t('admin.col.event')) ?></th><th><?= e(t('admin.col.result')) ?></th><th><?= e(t('admin.col.payload')) ?></th></tr></thead>
    <tbody>
    <?php foreach ($events as $ev): ?>
      <tr><td><?= e((string) $ev['created_at']) ?></td><td><?= e((string) $ev['event_type']) ?><br><small class="muted"><?= e($ev['event_id']) ?></small></td><td><?= e((string) $ev['result']) ?></td>
        <td><details><summary><?= e(t('admin.orders.view_payload')) ?></summary><pre><?= e(json_encode(json_decode((string) $ev['payload'], true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?></pre></details></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
</section>
