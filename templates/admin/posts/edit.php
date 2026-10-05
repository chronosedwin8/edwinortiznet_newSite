<?php
/** @var array $post @var array|null $translation @var array $hubs @var array $products */
$isNew = $post['id'] === null;
$action = $isNew ? '/admin/contenido/nuevo/' : '/admin/contenido/' . (int) $post['id'] . '/';
$publicUrl = $post['type'] === 'policy' ? route('policy', ['slug' => $post['slug']], $post['locale']) : ($post['locale'] === 'en' ? '/en/' : '/') . $post['slug'] . '/';
?>
<nav class="tabs" aria-label="<?= e(t('admin.posts.languages')) ?>">
  <span class="tab is-active" aria-current="page"><?= e(strtoupper($post['locale'])) ?></span>
  <?php if ($translation): ?>
  <a class="tab" href="/admin/contenido/<?= (int) $translation['id'] ?>/"><?= e(strtoupper($translation['locale'])) ?><?= $translation['needs_review'] ? ' •' : '' ?></a>
  <?php elseif (!$isNew && $post['locale'] === 'es'): ?>
  <form method="post" action="<?= e(route('admin.posts.translate', ['id' => (int) $post['id']])) ?>" class="inline"><?= csrf_field() ?><button class="tab tab--add" type="submit"><?= e(t('admin.posts.create_en')) ?></button></form>
  <?php endif; ?>
  <?php if (!$isNew && $post['status'] !== 'draft'): ?><a class="tab tab--link" href="<?= e($publicUrl) ?>" target="_blank" rel="noopener"><?= e(t('admin.view_public')) ?></a><?php endif; ?>
</nav>

<form method="post" action="<?= e($action) ?>" class="admin-form edit-grid" data-editor>
  <?= csrf_field() ?>
  <input type="hidden" name="locale" value="<?= e($post['locale']) ?>">
  <div class="edit-main">
    <label for="p-title"><?= e(t('admin.col.title')) ?></label>
    <input id="p-title" name="title" required maxlength="255" value="<?= e($post['title']) ?>">
    <label for="p-slug"><?= e(t('admin.field.slug')) ?></label>
    <input id="p-slug" name="slug" maxlength="190" value="<?= e($post['slug']) ?>" pattern="[a-z0-9\-]+">
    <p class="hint"><?= e(t('admin.hint.slug')) ?></p>
    <label for="p-content"><?= e(t('admin.field.content')) ?></label>
    <textarea id="p-content" name="content_html" rows="28" class="code" spellcheck="false"><?= e($post['content_html']) ?></textarea>
    <p class="hint"><?= e(t('admin.hint.content')) ?></p>
    <button class="btn btn--ghost" type="submit" formaction="<?= e(route('admin.preview')) ?>" formtarget="_blank"><?= e(t('admin.preview')) ?></button>
    <label for="p-excerpt"><?= e(t('admin.field.excerpt')) ?></label>
    <textarea id="p-excerpt" name="excerpt" rows="3"><?= e($post['excerpt']) ?></textarea>
    <label for="p-notice"><?= e(t('admin.field.notice')) ?></label>
    <textarea id="p-notice" name="notice_html" rows="3" class="code"><?= e($post['notice_html']) ?></textarea>
  </div>
  <aside class="edit-side">
    <fieldset>
      <legend><?= e(t('admin.field.publish')) ?></legend>
      <label for="p-status"><?= e(t('admin.f.status')) ?></label>
      <select id="p-status" name="status">
        <?php foreach (['published', 'draft', 'noindex'] as $st): ?><option value="<?= $st ?>"<?= $post['status'] === $st ? ' selected' : '' ?>><?= e(t("admin.status.$st")) ?></option><?php endforeach; ?>
      </select>
      <label for="p-type"><?= e(t('admin.f.type')) ?></label>
      <select id="p-type" name="type">
        <?php foreach (['post', 'page', 'policy'] as $tp): ?><option value="<?= $tp ?>"<?= $post['type'] === $tp ? ' selected' : '' ?>><?= e(t("admin.type.$tp")) ?></option><?php endforeach; ?>
      </select>
      <label for="p-date"><?= e(t('admin.field.published_at')) ?></label>
      <input id="p-date" name="published_at" value="<?= e((string) $post['published_at']) ?>" pattern="\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}">
      <label class="check"><input type="checkbox" name="needs_review" value="1"<?= $post['needs_review'] ? ' checked' : '' ?>> <?= e(t('admin.f.review')) ?></label>
      <button class="btn" type="submit"><?= e(t('admin.save')) ?></button>
    </fieldset>
    <fieldset>
      <legend><?= e(t('admin.field.seo')) ?></legend>
      <label for="p-seo-title"><?= e(t('admin.field.seo_title')) ?> <output data-count-for="p-seo-title" data-min="50" data-max="60"></output></label>
      <input id="p-seo-title" name="seo_title" maxlength="190" value="<?= e($post['seo_title']) ?>">
      <label for="p-seo-desc"><?= e(t('admin.field.seo_description')) ?> <output data-count-for="p-seo-desc" data-min="150" data-max="160"></output></label>
      <textarea id="p-seo-desc" name="seo_description" rows="4" maxlength="320"><?= e($post['seo_description']) ?></textarea>
      <label class="check"><input type="checkbox" name="seo_auto" value="1"<?= $post['seo_auto'] ? ' checked' : '' ?>> <?= e(t('admin.field.seo_auto')) ?></label>
      <label for="p-kw"><?= e(t('admin.field.focus')) ?></label>
      <input id="p-kw" name="focus_keyword" maxlength="190" value="<?= e($post['focus_keyword']) ?>">
      <label for="p-canonical"><?= e(t('admin.field.canonical')) ?></label>
      <input id="p-canonical" name="canonical_url" maxlength="500" value="<?= e($post['canonical_url']) ?>">
    </fieldset>
    <fieldset>
      <legend><?= e(t('admin.field.relations')) ?></legend>
      <label for="p-hub"><?= e(t('admin.field.hub')) ?></label>
      <select id="p-hub" name="hub_id"><option value="0">—</option>
        <?php foreach ($hubs as $h): ?><option value="<?= (int) $h['id'] ?>"<?= (int) $post['hub_id'] === (int) $h['id'] ? ' selected' : '' ?>><?= e($h['title']) ?></option><?php endforeach; ?>
      </select>
      <label for="p-product"><?= e(t('admin.field.related_product')) ?></label>
      <select id="p-product" name="related_product_id"><option value="0">—</option>
        <?php foreach ($products as $pr): ?><option value="<?= (int) $pr['id'] ?>"<?= (int) $post['related_product_id'] === (int) $pr['id'] ? ' selected' : '' ?>><?= e($pr['title']) ?></option><?php endforeach; ?>
      </select>
      <label for="p-cover"><?= e(t('admin.field.cover')) ?></label>
      <input id="p-cover" name="cover_url" maxlength="500" value="<?= e($post['cover_url']) ?>">
      <label for="p-cover-alt"><?= e(t('admin.field.cover_alt')) ?></label>
      <input id="p-cover-alt" name="cover_alt" maxlength="255" value="<?= e($post['cover_alt']) ?>">
      <label class="check"><input type="checkbox" name="no_ads" value="1"<?= $post['no_ads'] ? ' checked' : '' ?>> <?= e(t('admin.field.no_ads')) ?></label>
    </fieldset>
  </aside>
</form>
