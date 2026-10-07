<?php
/** @var array $family @var array $translations @var int $productCount */
$isNew = $family['id'] === null;
$action = $isNew ? route('admin.families.create') : route('admin.families.edit', ['id' => (int) $family['id']]);
?>
<form method="post" action="<?= e($action) ?>" class="admin-form edit-grid" data-editor>
  <?= csrf_field() ?>
  <div class="edit-main">
    <div class="tabs" role="tablist" data-tabs>
      <button type="button" class="tab is-active" role="tab" aria-selected="true" data-tab="fam-es"><?= e(t('admin.lang.es')) ?></button>
      <button type="button" class="tab" role="tab" aria-selected="false" data-tab="fam-en"><?= e(t('admin.lang.en')) ?><?= !empty($translations['en']['needs_review']) ? ' •' : '' ?></button>
    </div>
    <?php foreach (['es', 'en'] as $loc): $tr = ($translations[$loc] ?? []) + ['name' => '', 'slug' => '', 'description_html' => '', 'needs_review' => 0]; ?>
    <section id="fam-<?= $loc ?>" class="tab-panel" role="tabpanel" lang="<?= $loc ?>"<?= $loc === 'en' ? ' hidden' : '' ?>>
      <label for="f-<?= $loc ?>-name" class="visually-hidden"><?= e(t('admin.field.name_' . $loc)) ?></label>
      <input id="f-<?= $loc ?>-name" name="<?= $loc ?>[name]" class="title-input" maxlength="190" value="<?= e((string) $tr['name']) ?>"<?= $loc === 'es' ? ' required' : '' ?> placeholder="<?= e(t('admin.field.name_' . $loc)) ?>"<?= $tr['slug'] === '' ? ' data-slug-source="f-' . $loc . '-slug"' : '' ?>>
      <p class="slug-row"><span><?= e(t('admin.field.url')) ?> <?= e(substr(route('shop.family', ['slug' => '-'], $loc), 0, -2)) ?></span><label for="f-<?= $loc ?>-slug" class="visually-hidden"><?= e(t('admin.field.slug')) ?></label><input id="f-<?= $loc ?>-slug" name="<?= $loc ?>[slug]" maxlength="190" value="<?= e((string) $tr['slug']) ?>" pattern="[a-z0-9\-]+"><span>/</span>
        <?php if ($tr['slug'] !== ''): ?><a href="<?= e(route('shop.family', ['slug' => $tr['slug']], $loc)) ?>" target="_blank" rel="noopener" aria-label="<?= e(t('admin.view_public')) ?>"><?= icon('eye') ?></a><?php endif; ?></p>
      <label for="f-<?= $loc ?>-desc"><?= e(t('admin.field.description')) ?></label>
      <textarea id="f-<?= $loc ?>-desc" name="<?= $loc ?>[description_html]" rows="6" class="code" data-rte="basic"><?= e((string) $tr['description_html']) ?></textarea>
      <p class="hint"><?= e(t('admin.families.description_hint')) ?></p>
      <?php if ($loc === 'en'): ?><p class="hint"><?= e(t('admin.families.en_hint')) ?></p><?php endif; ?>
      <label class="check"><input type="checkbox" name="<?= $loc ?>[needs_review]" value="1"<?= $tr['needs_review'] ? ' checked' : '' ?>> <?= e(t('admin.f.review')) ?></label>
    </section>
    <?php endforeach; ?>
  </div>
  <aside class="edit-side">
    <fieldset>
      <legend><?= e(t('admin.field.catalog')) ?></legend>
      <?php if ($isNew): ?>
      <label for="f-key"><?= e(t('admin.field.key')) ?></label>
      <input id="f-key" name="key" maxlength="60" pattern="[a-z0-9\-]+" placeholder="<?= e(t('admin.hubs.key_placeholder')) ?>">
      <p class="hint"><?= e(t('admin.families.key_hint')) ?></p>
      <?php else: ?>
      <p class="hint"><?= e(t('admin.field.key')) ?>: <code><?= e($family['key']) ?></code> · <?= e(t('admin.families.products_n', ['n' => $productCount])) ?></p>
      <?php endif; ?>
      <label for="f-audience"><?= e(t('admin.field.audience')) ?></label>
      <select id="f-audience" name="audience">
        <?php foreach (\App\Controllers\ShopController::AUDIENCES as $a): ?><option value="<?= e($a) ?>"<?= $family['audience'] === $a ? ' selected' : '' ?>><?= e(t("audience.$a")) ?></option><?php endforeach; ?>
      </select>
      <label for="f-sort"><?= e(t('admin.field.sort')) ?></label>
      <input id="f-sort" name="sort" type="number" value="<?= (int) $family['sort'] ?>">
      <button class="btn btn--block" type="submit" data-save><?= icon('check') ?><?= e(t('admin.save')) ?></button>
    </fieldset>
    <?php if (!$isNew): ?>
    <details class="box box--danger">
      <summary><?= e(t('admin.danger_zone')) ?></summary>
      <div class="box__body">
        <?php if ($productCount > 0): ?>
        <p class="hint"><?= e(t('admin.families.not_empty', ['n' => $productCount])) ?></p>
        <?php else: ?>
        <p class="hint"><?= e(t('admin.families.delete_note')) ?></p>
        <button class="btn btn--danger btn--small btn--block" type="submit" form="family-delete"><?= icon('trash') ?><?= e(t('admin.families.delete')) ?></button>
        <?php endif; ?>
      </div>
    </details>
    <?php endif; ?>
  </aside>
</form>
<?php if (!$isNew && $productCount === 0): ?>
<form id="family-delete" method="post" action="<?= e(route('admin.families.delete', ['id' => (int) $family['id']])) ?>" data-confirm="<?= e(t('admin.families.delete_confirm', ['name' => $translations['es']['name'] ?? $family['key']])) ?>" data-confirm-ok="<?= e(t('admin.delete')) ?>" hidden><?= csrf_field() ?></form>
<?php endif; ?>
