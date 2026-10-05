<?php /** @var array $orders @var string $status @var string $q */ ?>
<form class="filters-bar" method="get" action="/admin/pedidos/">
  <label><?= e(t('admin.f.search')) ?> <input type="search" name="q" value="<?= e($q) ?>"></label>
  <label><?= e(t('admin.f.status')) ?>
    <select name="status"><option value=""><?= e(t('admin.all')) ?></option>
      <?php foreach (['pending', 'approved', 'declined', 'voided', 'refunded', 'error'] as $st): ?><option value="<?= $st ?>"<?= $status === $st ? ' selected' : '' ?>><?= e(t("status.$st")) ?></option><?php endforeach; ?>
    </select>
  </label>
  <button class="btn btn--small" type="submit"><?= e(t('admin.filter')) ?></button>
</form>
<table class="data">
  <thead><tr><th><?= e(t('account.col_ref')) ?></th><th><?= e(t('admin.col.date')) ?></th><th><?= e(t('admin.col.customer')) ?></th><th><?= e(t('account.col_total')) ?></th><th><?= e(t('admin.col.gateway')) ?></th><th><?= e(t('admin.f.status')) ?></th></tr></thead>
  <tbody>
  <?php foreach ($orders as $o): ?>
    <tr>
      <td><a href="/admin/pedidos/<?= (int) $o['id'] ?>/"><?= e($o['reference']) ?></a></td>
      <td><?= e(substr((string) $o['created_at'], 0, 16)) ?></td>
      <td><?= e($o['name']) ?><br><small class="muted"><?= e($o['email']) ?></small></td>
      <td><?= e(money($o['total'], $o['currency'], 'es')) ?></td>
      <td><?= e(t('gateway.' . $o['gateway'])) ?> · <?= e(strtoupper($o['locale'])) ?></td>
      <td><span class="tag tag--<?= e($o['status']) ?>"><?= e(t('status.' . $o['status'])) ?></span></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
