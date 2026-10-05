<?php
/** @var array $hub @var array $translations @var array $pillars */
use App\Admin\ProductsController;

?>
<form method="post" action="/admin/secciones/<?= (int) $hub['id'] ?>/" class="admin-form edit-grid" data-editor data-autosave="seccion-<?= (int) $hub['id'] ?>">
  <?= csrf_field() ?>
  <div class="edit-main">
    <div class="tabs" role="tablist" data-tabs>
      <button type="button" class="tab is-active" role="tab" aria-selected="true" data-tab="hub-es"><?= e(t('admin.lang.es')) ?></button>
      <button type="button" class="tab" role="tab" aria-selected="false" data-tab="hub-en"><?= e(t('admin.lang.en')) ?><?= !empty($translations['en']['needs_review']) ? ' •' : '' ?></button>
    </div>
    <?php foreach (['es', 'en'] as $loc): $tr = ($translations[$loc] ?? []) + ['title' => '', 'menu_title' => '', 'slug' => '', 'intro_html' => '', 'faq_json' => '', 'seo_title' => '', 'seo_description' => '', 'needs_review' => 0]; $prefix = $loc === 'en' ? '/en/' : '/'; ?>
    <section id="hub-<?= $loc ?>" class="tab-panel" role="tabpanel" lang="<?= $loc ?>"<?= $loc === 'en' ? ' hidden' : '' ?>>
      <label for="h-<?= $loc ?>-title" class="visually-hidden"><?= e(t('admin.col.title')) ?></label>
      <input id="h-<?= $loc ?>-title" name="<?= $loc ?>[title]" class="title-input" maxlength="190" value="<?= e($tr['title']) ?>"<?= $loc === 'es' ? ' required' : '' ?> placeholder="<?= e(t('admin.col.title')) ?>">
      <p class="slug-row"><span><?= e(t('admin.field.url')) ?> <?= e($prefix) ?></span><label for="h-<?= $loc ?>-slug" class="visually-hidden"><?= e(t('admin.field.slug')) ?></label><input id="h-<?= $loc ?>-slug" name="<?= $loc ?>[slug]" maxlength="190" value="<?= e($tr['slug']) ?>" pattern="[a-z0-9\-]+"><span>/</span>
        <?php if ($tr['slug'] !== ''): ?><a href="<?= e($prefix . $tr['slug']) ?>/" target="_blank" rel="noopener"><?= icon('eye') ?></a><?php endif; ?></p>
      <label for="h-<?= $loc ?>-menu"><?= e(t('admin.hubs.menu_title')) ?></label>
      <input id="h-<?= $loc ?>-menu" name="<?= $loc ?>[menu_title]" maxlength="80" value="<?= e((string) $tr['menu_title']) ?>">
      <label for="h-<?= $loc ?>-intro"><?= e(t('admin.hubs.intro_field')) ?></label>
      <textarea id="h-<?= $loc ?>-intro" name="<?= $loc ?>[intro_html]" rows="12" class="code" data-rte="full"><?= e((string) $tr['intro_html']) ?></textarea>
      <p class="hint"><?= e(t('admin.hubs.intro_hint')) ?></p>
      <label for="h-<?= $loc ?>-faq"><?= e(t('admin.field.faq')) ?></label>
      <textarea id="h-<?= $loc ?>-faq" name="<?= $loc ?>[faq]" rows="5" data-faq><?= e(ProductsController::faqText($tr['faq_json'])) ?></textarea>
      <p class="hint"><?= e(t('admin.hint.faq')) ?></p>
      <label for="h-<?= $loc ?>-seot"><?= e(t('admin.field.seo_title')) ?> <output data-count-for="h-<?= $loc ?>-seot" data-min="50" data-max="60"></output></label>
      <input id="h-<?= $loc ?>-seot" name="<?= $loc ?>[seo_title]" maxlength="190" value="<?= e((string) $tr['seo_title']) ?>">
      <label for="h-<?= $loc ?>-seod"><?= e(t('admin.field.seo_description')) ?> <output data-count-for="h-<?= $loc ?>-seod" data-min="120" data-max="160"></output></label>
      <textarea id="h-<?= $loc ?>-seod" name="<?= $loc ?>[seo_description]" rows="3" maxlength="320"><?= e((string) $tr['seo_description']) ?></textarea>
      <label class="check"><input type="checkbox" name="<?= $loc ?>[needs_review]" value="1"<?= $tr['needs_review'] ? ' checked' : '' ?>> <?= e(t('admin.f.review')) ?></label>
    </section>
    <?php endforeach; ?>
  </div>
  <aside class="edit-side">
    <fieldset>
      <legend><?= e(t('admin.field.publish')) ?></legend>
      <label for="h-pillar"><?= e(t('admin.hubs.pillar')) ?></label>
      <select id="h-pillar" name="pillar_post_id"><option value="0">—</option>
        <?php foreach ($pillars as $p): ?><option value="<?= (int) $p['id'] ?>"<?= (int) $hub['pillar_post_id'] === (int) $p['id'] ? ' selected' : '' ?>><?= e($p['title']) ?></option><?php endforeach; ?>
      </select>
      <label for="h-sort"><?= e(t('admin.field.sort')) ?></label>
      <input id="h-sort" name="sort" type="number" value="<?= (int) $hub['sort'] ?>">
      <button class="btn btn--block" type="submit" data-save><?= icon('check') ?><?= e(t('admin.save')) ?></button>
      <p class="hint"><kbd><?= e(t('admin.kbd.save')) ?></kbd> <?= e(t('admin.save_shortcut')) ?></p>
    </fieldset>
  </aside>
</form>
