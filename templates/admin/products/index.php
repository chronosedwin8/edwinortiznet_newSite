<?php /** @var array $products */ ?>
<p class="actions"><a class="btn btn--small" href="/admin/productos/nuevo/"><?= e(t('admin.products.new')) ?></a> <a class="btn btn--small btn--ghost" href="/admin/familias/"><?= e(t('admin.families')) ?></a></p>
<table class="data">
  <thead><tr>
    <th><?= e(t('admin.col.product')) ?></th><th><?= e(t('admin.f.status')) ?></th><th><?= e(t('admin.f.type')) ?></th>
    <th><?= e(t('admin.col.price')) ?></th><th><?= e(t('admin.col.sales')) ?></th><th><?= e(t('admin.col.files')) ?></th><th><?= e(t('admin.col.en')) ?></th><th><?= e(t('admin.col.waitlist')) ?></th>
  </tr></thead>
  <tbody>
  <?php foreach ($products as $p): ?>
    <tr>
      <td><a href="/admin/productos/<?= (int) $p['id'] ?>/"><?= e($p['title']) ?></a><br><small class="muted"><?= e($p['family'] ?? '—') ?> · <?= e(t('audience.' . $p['audience'])) ?></small></td>
      <td><span class="tag tag--<?= e($p['status']) ?>"><?= e(t('admin.pstatus.' . $p['status'])) ?></span></td>
      <td><?= e(t('admin.ptype.' . $p['type'])) ?></td>
      <td><?= e(money($p['price_cop'], 'COP', 'es')) ?><br><small class="muted"><?= e(money($p['price_usd'], 'USD', 'en')) ?></small></td>
      <td><?= (int) $p['legacy_sales'] ?> + <?= (int) $p['sales_count'] ?></td>
      <td><?php if ($p['type'] === 'download'): ?><span class="tag<?= (int) $p['files'] > 0 && $p['files'] === $p['files_ready'] ? ' tag--published' : ' tag--warn' ?>"><?= (int) $p['files_ready'] ?>/<?= (int) $p['files'] ?></span><?php if (!empty($p['variants'])): ?><br><small class="muted" title="<?= e(t('admin.files.variants')) ?>"><?= e($p['variants']) ?></small><?php endif; ?><?php endif; ?></td>
      <td><?= $p['title_en'] ? e(t($p['en_review'] ? 'admin.f.review' : 'admin.yes')) : '—' ?></td>
      <td><?= (int) $p['waitlist'] ?: '' ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
