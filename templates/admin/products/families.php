<?php /** @var array $families */ ?>
<div class="page-head">
  <p class="muted"><?= e(t('admin.families.intro')) ?></p>
  <a class="btn btn--small" href="<?= e(route('admin.families.create')) ?>"><?= icon('plus') ?><?= e(t('admin.families.new')) ?></a>
</div>
<form method="post" action="/admin/familias/" class="admin-form">
  <?= csrf_field() ?>
  <div class="table-wrap">
  <table class="data data--cards">
    <thead><tr><th><?= e(t('admin.field.key')) ?></th><th><?= e(t('admin.field.name_es')) ?></th><th><?= e(t('admin.field.slug_es')) ?></th><th><?= e(t('admin.field.name_en')) ?></th><th><?= e(t('admin.field.slug_en')) ?></th><th><?= e(t('admin.field.sort')) ?></th><th><?= e(t('admin.products')) ?></th><th><span class="visually-hidden"><?= e(t('admin.col.actions')) ?></span></th></tr></thead>
    <tbody>
    <?php foreach ($families as $f): $id = (int) $f['id']; ?>
      <tr>
        <td><a href="<?= e(route('admin.families.edit', ['id' => $id])) ?>"><code><?= e($f['key']) ?></code></a></td>
        <td data-label="<?= e(t('admin.field.name_es')) ?>"><input aria-label="<?= e(t('admin.field.name_es')) ?>" name="families[<?= $id ?>][name_es]" value="<?= e((string) $f['name_es']) ?>"></td>
        <td data-label="<?= e(t('admin.field.slug_es')) ?>"><input aria-label="<?= e(t('admin.field.slug_es')) ?>" name="families[<?= $id ?>][slug_es]" value="<?= e((string) $f['slug_es']) ?>"></td>
        <td data-label="<?= e(t('admin.field.name_en')) ?>"><input aria-label="<?= e(t('admin.field.name_en')) ?>" name="families[<?= $id ?>][name_en]" value="<?= e((string) $f['name_en']) ?>"></td>
        <td data-label="<?= e(t('admin.field.slug_en')) ?>"><input aria-label="<?= e(t('admin.field.slug_en')) ?>" name="families[<?= $id ?>][slug_en]" value="<?= e((string) $f['slug_en']) ?>"></td>
        <td data-label="<?= e(t('admin.field.sort')) ?>"><input aria-label="<?= e(t('admin.field.sort')) ?>" type="number" name="families[<?= $id ?>][sort]" value="<?= (int) $f['sort'] ?>" class="narrow"></td>
        <td data-label="<?= e(t('admin.products')) ?>"><?= (int) $f['products'] ?></td>
        <td class="col-actions">
          <a class="icon-btn icon-btn--sm" href="<?= e(route('admin.families.edit', ['id' => $id])) ?>" aria-label="<?= e(t('admin.edit') . ': ' . ($f['name_es'] ?? $f['key'])) ?>" title="<?= e(t('admin.edit')) ?>"><?= icon('file') ?></a>
          <?php if ((int) $f['products'] === 0): ?>
          <button class="icon-btn icon-btn--sm icon-btn--danger" type="submit" form="family-delete-<?= $id ?>" aria-label="<?= e(t('admin.families.delete_one', ['name' => $f['name_es'] ?? $f['key']])) ?>" title="<?= e(t('admin.delete')) ?>"><?= icon('trash') ?></button>
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
  <button class="btn" type="submit"><?= e(t('admin.save')) ?></button>
</form>
<?php foreach ($families as $f): if ((int) $f['products'] === 0): ?>
<form id="family-delete-<?= (int) $f['id'] ?>" method="post" action="<?= e(route('admin.families.delete', ['id' => (int) $f['id']])) ?>" data-confirm="<?= e(t('admin.families.delete_confirm', ['name' => $f['name_es'] ?? $f['key']])) ?>" data-confirm-ok="<?= e(t('admin.delete')) ?>" hidden><?= csrf_field() ?></form>
<?php endif; endforeach; ?>
