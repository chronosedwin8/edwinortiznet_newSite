<?php
/** @var array $product @var array $translations @var array $files @var array $packItems @var array $families @var array $tutorials @var array $allProducts */

use App\Admin\ProductsController;

$isNew = $product['id'] === null;
$action = $isNew ? '/admin/productos/nuevo/' : '/admin/productos/' . (int) $product['id'] . '/';
?>
<form method="post" action="<?= e($action) ?>" class="admin-form edit-grid" data-editor data-autosave="<?= e($isNew ? 'producto-nuevo' : 'producto-' . (int) $product['id']) ?>">
  <?= csrf_field() ?>
  <div class="edit-main">
    <div class="tabs" role="tablist" data-tabs>
      <button type="button" class="tab is-active" role="tab" aria-selected="true" data-tab="tab-es"><?= e(t('admin.lang.es')) ?></button>
      <button type="button" class="tab" role="tab" aria-selected="false" data-tab="tab-en"><?= e(t('admin.lang.en')) ?><?= !empty($translations['en']['needs_review']) ? ' •' : '' ?></button>
    </div>
    <?php foreach (['es', 'en'] as $loc): $tr = $translations[$loc] + ['title' => '', 'slug' => '', 'short_html' => '', 'description_html' => '', 'includes_html' => '', 'requirements' => '', 'license_text' => '', 'faq_json' => '', 'seo_title' => '', 'seo_description' => '', 'needs_review' => $loc === 'en' ? 1 : 0]; ?>
    <section id="tab-<?= $loc ?>" class="tab-panel" role="tabpanel" lang="<?= $loc ?>"<?= $loc === 'en' ? ' hidden' : '' ?>>
      <?php if (!$isNew && $tr['slug'] !== ''): ?><p><a href="<?= e(route('product', ['slug' => $tr['slug']], $loc)) ?>" target="_blank" rel="noopener"><?= e(t('admin.view_public')) ?></a></p><?php endif; ?>
      <label for="t-<?= $loc ?>-title"><?= e(t('admin.col.title')) ?></label>
      <input id="t-<?= $loc ?>-title" name="<?= $loc ?>[title]" maxlength="255" value="<?= e($tr['title']) ?>"<?= $loc === 'es' ? ' required' : '' ?>>
      <label for="t-<?= $loc ?>-slug"><?= e(t('admin.field.slug')) ?></label>
      <input id="t-<?= $loc ?>-slug" name="<?= $loc ?>[slug]" maxlength="190" value="<?= e($tr['slug']) ?>">
      <label for="t-<?= $loc ?>-short"><?= e(t('admin.field.short')) ?></label>
      <textarea id="t-<?= $loc ?>-short" name="<?= $loc ?>[short_html]" rows="4" class="code" data-rte="basic"><?= e($tr['short_html']) ?></textarea>
      <label for="t-<?= $loc ?>-desc"><?= e(t('admin.field.description')) ?></label>
      <textarea id="t-<?= $loc ?>-desc" name="<?= $loc ?>[description_html]" rows="14" class="code" data-rte="full"><?= e($tr['description_html']) ?></textarea>
      <label for="t-<?= $loc ?>-inc"><?= e(t('admin.field.includes')) ?></label>
      <textarea id="t-<?= $loc ?>-inc" name="<?= $loc ?>[includes_html]" rows="4" class="code" data-rte="basic"><?= e($tr['includes_html']) ?></textarea>
      <label for="t-<?= $loc ?>-req"><?= e(t('admin.field.requirements')) ?></label>
      <textarea id="t-<?= $loc ?>-req" name="<?= $loc ?>[requirements]" rows="3"><?= e($tr['requirements']) ?></textarea>
      <label for="t-<?= $loc ?>-lic"><?= e(t('admin.field.license')) ?></label>
      <textarea id="t-<?= $loc ?>-lic" name="<?= $loc ?>[license_text]" rows="3"><?= e($tr['license_text']) ?></textarea>
      <label for="t-<?= $loc ?>-faq"><?= e(t('admin.field.faq')) ?></label>
      <textarea id="t-<?= $loc ?>-faq" name="<?= $loc ?>[faq]" rows="5" data-faq><?= e(ProductsController::faqText($tr['faq_json'])) ?></textarea>
      <p class="hint"><?= e(t('admin.hint.faq')) ?></p>
      <label for="t-<?= $loc ?>-seot"><?= e(t('admin.field.seo_title')) ?> <output data-count-for="t-<?= $loc ?>-seot" data-min="50" data-max="60"></output></label>
      <input id="t-<?= $loc ?>-seot" name="<?= $loc ?>[seo_title]" maxlength="190" value="<?= e($tr['seo_title']) ?>">
      <label for="t-<?= $loc ?>-seod"><?= e(t('admin.field.seo_description')) ?> <output data-count-for="t-<?= $loc ?>-seod" data-min="150" data-max="160"></output></label>
      <textarea id="t-<?= $loc ?>-seod" name="<?= $loc ?>[seo_description]" rows="3" maxlength="320"><?= e($tr['seo_description']) ?></textarea>
      <label class="check"><input type="checkbox" name="<?= $loc ?>[needs_review]" value="1"<?= $tr['needs_review'] ? ' checked' : '' ?>> <?= e(t('admin.f.review')) ?></label>
    </section>
    <?php endforeach; ?>
  </div>
  <aside class="edit-side">
    <fieldset>
      <legend><?= e(t('admin.field.publish')) ?></legend>
      <label for="pr-status"><?= e(t('admin.f.status')) ?></label>
      <select id="pr-status" name="status">
        <?php foreach (['active', 'coming_soon', 'hidden'] as $st): ?><option value="<?= $st ?>"<?= $product['status'] === $st ? ' selected' : '' ?>><?= e(t("admin.pstatus.$st")) ?></option><?php endforeach; ?>
      </select>
      <label for="pr-type"><?= e(t('admin.f.type')) ?></label>
      <select id="pr-type" name="type">
        <?php foreach (['download', 'service', 'course', 'pack'] as $tp): ?><option value="<?= $tp ?>"<?= $product['type'] === $tp ? ' selected' : '' ?>><?= e(t("admin.ptype.$tp")) ?></option><?php endforeach; ?>
      </select>
      <label for="pr-usd"><?= e(t('admin.field.price_usd')) ?></label>
      <input id="pr-usd" name="price_usd" type="number" step="0.01" min="0" value="<?= e((string) $product['price_usd']) ?>">
      <label for="pr-cop"><?= e(t('admin.field.price_cop')) ?></label>
      <input id="pr-cop" name="price_cop" type="number" step="1000" min="0" value="<?= (int) $product['price_cop'] ?>">
      <label class="check"><input type="checkbox" name="featured" value="1"<?= $product['featured'] ? ' checked' : '' ?>> <?= e(t('admin.field.featured')) ?></label>
      <label class="check"><input type="checkbox" name="has_english_version" value="1"<?= $product['has_english_version'] ? ' checked' : '' ?>> <?= e(t('admin.field.has_en')) ?></label>
      <button class="btn btn--block" type="submit" data-save><?= icon('check') ?><?= e(t('admin.save')) ?></button>
    </fieldset>
    <fieldset>
      <legend><?= e(t('admin.field.catalog')) ?></legend>
      <label for="pr-family"><?= e(t('admin.families')) ?></label>
      <select id="pr-family" name="family_id"><option value="0">—</option>
        <?php foreach ($families as $f): ?><option value="<?= (int) $f['id'] ?>"<?= (int) $product['family_id'] === (int) $f['id'] ? ' selected' : '' ?>><?= e($f['name']) ?></option><?php endforeach; ?>
      </select>
      <label for="pr-aud"><?= e(t('admin.field.audience')) ?></label>
      <select id="pr-aud" name="audience">
        <?php foreach (['oficina', 'docente', 'concurso'] as $a): ?><option value="<?= $a ?>"<?= $product['audience'] === $a ? ' selected' : '' ?>><?= e(t("audience.$a")) ?></option><?php endforeach; ?>
      </select>
      <label for="pr-sku"><?= e(t('admin.field.sku')) ?></label>
      <input id="pr-sku" name="sku" maxlength="60" value="<?= e((string) $product['sku']) ?>">
      <label for="pr-sort"><?= e(t('admin.field.sort')) ?></label>
      <input id="pr-sort" name="sort" type="number" value="<?= (int) $product['sort'] ?>">
      <label for="pr-tut"><?= e(t('admin.field.tutorial')) ?></label>
      <select id="pr-tut" name="tutorial_post_id" aria-describedby="pr-tut-hint"><option value="0">—</option>
        <?php foreach ($tutorials as $tu): ?><option value="<?= (int) $tu['id'] ?>"<?= (int) $product['tutorial_post_id'] === (int) $tu['id'] ? ' selected' : '' ?>><?= e($tu['title']) ?></option><?php endforeach; ?>
      </select>
      <p class="hint" id="pr-tut-hint"><?= e(t('admin.hint.tutorial')) ?></p>
      <label for="pr-cover"><?= e(t('admin.field.cover')) ?></label>
      <input id="pr-cover" name="cover_url" maxlength="500" value="<?= e((string) $product['cover_url']) ?>" data-media-input data-alt-target="pr-cover-alt">
      <label for="pr-cover-alt"><?= e(t('admin.field.cover_alt')) ?></label>
      <input id="pr-cover-alt" name="cover_alt" maxlength="255" value="<?= e((string) $product['cover_alt']) ?>">
      <label for="pr-video"><?= e(t('admin.field.video')) ?></label>
      <input id="pr-video" name="video_url" maxlength="500" value="<?= e((string) $product['video_url']) ?>">
    </fieldset>
    <?php if ($product['type'] === 'pack'): ?>
    <fieldset>
      <legend><?= e(t('admin.field.pack_items')) ?></legend>
      <select name="pack_items[]" multiple size="10">
        <?php foreach ($allProducts as $ap): ?><option value="<?= (int) $ap['id'] ?>"<?= in_array((int) $ap['id'], $packItems, true) ? ' selected' : '' ?>><?= e($ap['title']) ?></option><?php endforeach; ?>
      </select>
    </fieldset>
    <?php endif; ?>
  </aside>
</form>

<?php if (!$isNew): ?>
<section class="panel" id="archivos">
  <h2><?= e(t('admin.files')) ?><?= $files ? ' (' . count($files) . ')' : '' ?></h2>
  <?php if ($files): $replaceId ??= 0;
      $size = static fn (?int $b): string => $b === null ? '—' : ($b >= 1048576
          ? \App\Services\I18n\I18n::number($b / 1048576, 1, 'es') . ' MB'
          : \App\Services\I18n\I18n::number(max(1, $b / 1024), 0, 'es') . ' KB'); ?>
  <p class="hint"><?= e(t('admin.files.help')) ?></p>
  <div class="table-wrap">
  <table class="data data--cards">
    <thead><tr>
      <th><?= e(t('admin.field.label')) ?></th><th><?= e(t('admin.field.variant')) ?></th><th><?= e(t('admin.field.size')) ?></th>
      <th><?= e(t('admin.field.storage')) ?></th><th><?= e(t('admin.field.version')) ?></th><th><?= e(t('admin.files.updated')) ?></th><th class="col-actions"><span class="visually-hidden"><?= e(t('admin.files.actions')) ?></span></th>
    </tr></thead>
    <tbody>
    <?php foreach ($files as $f): $disk = ($f['storage_disk'] ?? 'local') === 's3' ? 's3' : 'local'; ?>
      <tr<?= (int) $f['id'] === $replaceId ? ' class="is-selected"' : '' ?>>
        <td>
          <strong><?= e($f['label']) ?></strong>
          <?php if ($f['storage_path']): ?><br><code class="muted"><?= e(basename((string) $f['storage_path'])) ?></code><?php endif; ?>
          <?php if (!empty($f['source_url']) && empty($f['storage_path'])): ?><br><small class="muted"><?= e((string) $f['source_url']) ?></small><?php endif; ?>
        </td>
        <td data-label="<?= e(t('admin.field.variant')) ?>"><?php if (!empty($f['variant'])): ?><span class="tag tag--plain"><?= e($f['variant']) ?></span><?php else: ?><span class="muted"><?= e(t('admin.files.all_buyers')) ?></span><?php endif; ?></td>
        <td data-label="<?= e(t('admin.field.size')) ?>"><?= e($size($f['bytes'] !== null ? (int) $f['bytes'] : null)) ?></td>
        <td data-label="<?= e(t('admin.field.storage')) ?>">
          <?php if (!$f['storage_path']): ?><span class="tag tag--warn"><?= e(t('admin.files.missing')) ?></span>
          <?php else: ?><span class="tag tag--<?= $disk === 's3' ? 'published' : 'plain' ?>"><?= e(t($disk === 's3' ? 'admin.files.in_s3' : 'admin.files.in_server')) ?></span>
            <?php if (!$f['available']): ?><span class="tag tag--error"><?= e(t('admin.files.not_found')) ?></span><?php endif; ?>
          <?php endif; ?>
        </td>
        <td data-label="<?= e(t('admin.field.version')) ?>"><?= $f['version'] ? e($f['version']) : '—' ?></td>
        <td data-label="<?= e(t('admin.files.updated')) ?>"><time datetime="<?= e(str_replace(' ', 'T', (string) $f['updated_at'])) ?>"><?= e(substr((string) $f['updated_at'], 0, 16)) ?></time></td>
        <td class="col-actions">
          <div class="file-actions">
            <?php if ($f['available']): ?>
            <a class="btn btn--small" href="<?= e(route('admin.products.file', ['id' => (int) $product['id'], 'file' => (int) $f['id']])) ?>" download><?= icon('download') ?><?= e(t('admin.files.download')) ?></a>
            <?php endif; ?>
            <a class="btn btn--small btn--ghost" href="?reemplazar=<?= (int) $f['id'] ?>#subir"><?= icon('upload') ?><?= e(t('admin.files.replace_one')) ?></a>
          </div>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>
  <?php endif; ?>
  <?php $replacing = null; foreach ($files as $f) { if ((int) $f['id'] === ($replaceId ?? 0)) { $replacing = $f; } } ?>
  <h3 id="subir"><?= e($replacing ? t('admin.files.replace_title', ['file' => $replacing['label'] . (!empty($replacing['variant']) ? ' (' . $replacing['variant'] . ')' : '')]) : t('admin.files.upload')) ?></h3>
  <?php if ($replacing): ?><p class="hint"><?= e(t('admin.files.replace_help')) ?></p><?php endif; ?>
  <form method="post" action="<?= e(route('admin.products.upload', ['id' => (int) $product['id']])) ?>" enctype="multipart/form-data" class="admin-form inline-form">
    <?= csrf_field() ?>
    <label for="up-file"><?= e(t('admin.files.file')) ?></label>
    <input id="up-file" type="file" name="file" required>
    <label for="up-label"><?= e(t('admin.field.label')) ?></label>
    <input id="up-label" name="label" maxlength="190" value="<?= e((string) ($replacing['label'] ?? '')) ?>">
    <label for="up-version"><?= e(t('admin.field.version')) ?></label>
    <input id="up-version" name="version" maxlength="40" placeholder="<?= e(date('Y.m.d')) ?>">
    <label for="up-variant"><?= e(t('admin.field.variant')) ?></label>
    <input id="up-variant" name="variant" maxlength="40" list="up-variants" aria-describedby="up-variant-hint" value="<?= e((string) ($replacing['variant'] ?? '')) ?>">
    <datalist id="up-variants"><?php foreach (array_unique(array_filter(array_column($files, 'variant'))) as $v): ?><option value="<?= e($v) ?>"><?php endforeach; ?></datalist>
    <?php if ($files): ?>
    <label for="up-replace"><?= e(t('admin.files.replace')) ?></label>
    <select id="up-replace" name="replace_id"><option value="0"><?= e(t('admin.files.add_new')) ?></option>
      <?php foreach ($files as $f): ?><option value="<?= (int) $f['id'] ?>"<?= $replacing && (int) $f['id'] === (int) $replacing['id'] ? ' selected' : '' ?>><?= e($f['label'] . (!empty($f['variant']) ? ' · ' . $f['variant'] : '') . ($f['version'] ? ' · v' . $f['version'] : '')) ?></option><?php endforeach; ?>
    </select>
    <?php endif; ?>
    <button class="btn" type="submit"><?= icon('upload') ?><?= e(t($replacing ? 'admin.files.replace_button' : 'admin.files.upload_button')) ?></button>
    <p class="hint"><?= e(t('admin.hint.upload')) ?></p>
    <p class="hint" id="up-variant-hint"><?= e(t('admin.hint.variant')) ?></p>
  </form>
</section>
<?php endif; ?>
