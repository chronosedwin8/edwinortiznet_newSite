<?php /** @var array $families */ ?>
<form method="post" action="/admin/familias/" class="admin-form">
  <?= csrf_field() ?>
  <table class="data">
    <thead><tr><th><?= e(t('admin.field.key')) ?></th><th><?= e(t('admin.field.name_es')) ?></th><th><?= e(t('admin.field.slug_es')) ?></th><th><?= e(t('admin.field.name_en')) ?></th><th><?= e(t('admin.field.slug_en')) ?></th><th><?= e(t('admin.field.sort')) ?></th></tr></thead>
    <tbody>
    <?php foreach ($families as $f): $id = (int) $f['id']; ?>
      <tr>
        <td><code><?= e($f['key']) ?></code></td>
        <td><input aria-label="<?= e(t('admin.field.name_es')) ?>" name="families[<?= $id ?>][name_es]" value="<?= e((string) $f['name_es']) ?>"></td>
        <td><input aria-label="<?= e(t('admin.field.slug_es')) ?>" name="families[<?= $id ?>][slug_es]" value="<?= e((string) $f['slug_es']) ?>"></td>
        <td><input aria-label="<?= e(t('admin.field.name_en')) ?>" name="families[<?= $id ?>][name_en]" value="<?= e((string) $f['name_en']) ?>"></td>
        <td><input aria-label="<?= e(t('admin.field.slug_en')) ?>" name="families[<?= $id ?>][slug_en]" value="<?= e((string) $f['slug_en']) ?>"></td>
        <td><input aria-label="<?= e(t('admin.field.sort')) ?>" type="number" name="families[<?= $id ?>][sort]" value="<?= (int) $f['sort'] ?>" class="narrow"></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <button class="btn" type="submit"><?= e(t('admin.save')) ?></button>
</form>
