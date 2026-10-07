<?php /** @var array $hubs */ ?>
<div class="page-head">
  <p class="muted"><?= e(t('admin.hubs.intro')) ?></p>
  <a class="btn btn--small" href="<?= e(route('admin.hubs.create')) ?>"><?= icon('plus') ?><?= e(t('admin.hubs.new')) ?></a>
</div>
<div class="table-wrap">
<table class="data">
  <thead><tr><th><?= e(t('admin.col.title')) ?></th><th><?= e(t('admin.field.url')) ?></th><th><?= e(t('admin.col.en')) ?></th><th><?= e(t('admin.hubs.posts')) ?></th><th><?= e(t('admin.hubs.menu_col')) ?></th><th><?= e(t('admin.field.sort')) ?></th></tr></thead>
  <tbody>
  <?php foreach ($hubs as $h): ?>
    <tr>
      <td><a href="/admin/secciones/<?= (int) $h['id'] ?>/"><?= e($h['title_es'] ?? $h['key']) ?></a></td>
      <td><a href="/<?= e((string) $h['slug_es']) ?>/" target="_blank" rel="noopener"><code>/<?= e((string) $h['slug_es']) ?>/</code></a></td>
      <td><?php if ($h['title_en']): ?><span class="tag tag--<?= $h['en_review'] ? 'warn' : 'published' ?>"><?= e($h['en_review'] ? t('admin.f.review') : $h['title_en']) ?></span><?php else: ?><span class="tag"><?= e(t('admin.hubs.no_en')) ?></span><?php endif; ?></td>
      <td><?= (int) $h['posts'] ?></td>
      <td><?= $h['in_menu'] ? '<span class="tag tag--published">' . e(t('admin.yes')) . '</span>' : '<span class="tag">' . e(t('admin.no')) . '</span>' ?></td>
      <td><?= (int) $h['sort'] ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
