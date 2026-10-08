<?php
/** @var array $post @var array|null $translation @var array $hubs @var array $products */
$isNew = $post['id'] === null;
$action = $isNew ? '/admin/contenido/nuevo/' : '/admin/contenido/' . (int) $post['id'] . '/';
$prefix = $post['locale'] === 'en' ? '/en/' : '/';
$publicUrl = $post['type'] === 'policy' ? route('policy', ['slug' => $post['slug']], $post['locale']) : $prefix . $post['slug'] . '/';
?>
<div class="page-head">
  <nav class="tabs" aria-label="<?= e(t('admin.posts.languages')) ?>">
    <span class="tab is-active" aria-current="page"><?= icon('globe') ?><?= e(strtoupper($post['locale'])) ?></span>
    <?php if ($translation): ?>
    <a class="tab" href="/admin/contenido/<?= (int) $translation['id'] ?>/"><?= e(strtoupper($translation['locale'])) ?><?= $translation['needs_review'] ? ' •' : '' ?></a>
    <?php elseif (!$isNew && $post['locale'] === 'es'): ?>
    <form method="post" action="<?= e(route('admin.posts.translate', ['id' => (int) $post['id']])) ?>" class="inline"><?= csrf_field() ?><button class="tab tab--add" type="submit"><?= e(t('admin.posts.create_en')) ?></button></form>
    <?php endif; ?>
  </nav>
  <?php if (!$isNew && $post['status'] !== 'draft'): ?><a class="btn btn--ghost btn--small" href="<?= e($publicUrl) ?>" target="_blank" rel="noopener"><?= icon('eye') ?><?= e(t('admin.view_public')) ?></a><?php endif; ?>
</div>

<form method="post" action="<?= e($action) ?>" class="admin-form edit-grid" data-editor data-autosave="<?= e($isNew ? 'nuevo-' . $post['locale'] : 'post-' . (int) $post['id']) ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="locale" value="<?= e($post['locale']) ?>">
  <div class="edit-main" lang="<?= e($post['locale']) ?>">
    <label for="p-title" class="visually-hidden"><?= e(t('admin.col.title')) ?></label>
    <input id="p-title" name="title" class="title-input" required maxlength="255" value="<?= e($post['title']) ?>" placeholder="<?= e(t('admin.posts.title_placeholder')) ?>"<?= $isNew ? ' data-slug-source="p-slug"' : '' ?>>
    <p class="slug-row"><span><?= e(t('admin.field.url')) ?> <?= e($prefix) ?></span><label for="p-slug" class="visually-hidden"><?= e(t('admin.field.slug')) ?></label><input id="p-slug" name="slug" maxlength="190" value="<?= e($post['slug']) ?>" pattern="[a-z0-9\-]+" title="<?= e(t('admin.hint.slug')) ?>"><span>/</span></p>

    <label for="p-content"><?= e(t('admin.field.content_rich')) ?></label>
    <textarea id="p-content" name="content_html" rows="28" class="code" spellcheck="false" data-rte="full"><?= e($post['content_html']) ?></textarea>
    <p class="hint"><?= e(t('admin.hint.editor')) ?></p>

    <label for="p-excerpt"><?= e(t('admin.field.excerpt')) ?></label>
    <textarea id="p-excerpt" name="excerpt" rows="3"><?= e($post['excerpt']) ?></textarea>
    <p class="hint"><?= e(t('admin.hint.excerpt')) ?></p>

    <details class="box"<?= trim((string) $post['notice_html']) !== '' ? ' open' : '' ?> style="margin-top:16px">
      <summary><?= e(t('admin.field.notice_rich')) ?></summary>
      <div class="box__body">
        <label for="p-notice" class="visually-hidden"><?= e(t('admin.field.notice_rich')) ?></label>
        <textarea id="p-notice" name="notice_html" rows="3" class="code" data-rte="basic"><?= e($post['notice_html']) ?></textarea>
      </div>
    </details>

    <div class="save-bar">
      <button class="btn" type="submit" data-save><?= icon('check') ?><?= e(t('admin.save')) ?></button>
      <button class="btn btn--ghost" type="submit" formaction="<?= e(route('admin.preview')) ?>" formtarget="_blank"><?= icon('eye') ?><?= e(t('admin.preview')) ?></button>
      <span class="save-state" data-save-state data-dirty="<?= e(t('admin.unsaved')) ?>"><kbd><?= e(t('admin.kbd.save')) ?></kbd> <?= e(t('admin.save_shortcut')) ?></span>
    </div>
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
      <button class="btn btn--block" type="submit" data-save><?= e(t('admin.save')) ?></button>
    </fieldset>

    <details class="box" open data-seo-panel data-prefix="<?= e($prefix) ?>">
      <summary><?= e(t('admin.seo.assistant')) ?></summary>
      <div class="box__body">
        <div class="serp" aria-label="<?= e(t('admin.seo.preview')) ?>">
          <div class="serp__url" data-serp-url></div>
          <div class="serp__title" data-serp-title></div>
          <div class="serp__desc" data-serp-desc></div>
        </div>
        <div class="score"><div class="score__ring" data-score><span>0</span></div><p class="muted"><?= e(t('admin.seo.score')) ?></p></div>
        <ul class="checks" data-checks></ul>
        <label for="p-kw"><?= e(t('admin.field.focus')) ?></label>
        <input id="p-kw" name="focus_keyword" maxlength="190" value="<?= e($post['focus_keyword']) ?>">
        <label for="p-seo-title"><?= e(t('admin.field.seo_title')) ?> <output data-count-for="p-seo-title" data-min="50" data-max="60"></output></label>
        <input id="p-seo-title" name="seo_title" maxlength="190" value="<?= e($post['seo_title']) ?>">
        <label for="p-seo-desc"><?= e(t('admin.field.seo_description')) ?> <output data-count-for="p-seo-desc" data-min="120" data-max="160"></output></label>
        <textarea id="p-seo-desc" name="seo_description" rows="4" maxlength="320"><?= e($post['seo_description']) ?></textarea>
        <label class="check"><input type="checkbox" name="seo_auto" value="1"<?= $post['seo_auto'] ? ' checked' : '' ?>> <?= e(t('admin.field.seo_auto')) ?></label>
        <label for="p-canonical"><?= e(t('admin.field.canonical')) ?></label>
        <input id="p-canonical" name="canonical_url" maxlength="500" value="<?= e($post['canonical_url']) ?>">
      </div>
    </details>

    <details class="box" open>
      <summary><?= e(t('admin.field.cover_title')) ?></summary>
      <div class="box__body">
        <label for="p-cover"><?= e(t('admin.field.cover')) ?></label>
        <input id="p-cover" name="cover_url" maxlength="500" value="<?= e($post['cover_url']) ?>" data-media-input data-alt-target="p-cover-alt">
        <label for="p-cover-alt"><?= e(t('admin.field.cover_alt')) ?></label>
        <input id="p-cover-alt" name="cover_alt" maxlength="255" value="<?= e($post['cover_alt']) ?>">
      </div>
    </details>

    <details class="box">
      <summary><?= e(t('admin.field.relations')) ?></summary>
      <div class="box__body">
        <label for="p-hub"><?= e(t('admin.field.hub')) ?></label>
        <select id="p-hub" name="hub_id"><option value="0">—</option>
          <?php foreach ($hubs as $h): ?><option value="<?= (int) $h['id'] ?>"<?= (int) $post['hub_id'] === (int) $h['id'] ? ' selected' : '' ?>><?= e($h['title']) ?></option><?php endforeach; ?>
        </select>
        <label for="p-product"><?= e(t('admin.field.related_product')) ?></label>
        <select id="p-product" name="related_product_id"><option value="0">—</option>
          <?php foreach ($products as $pr): ?><option value="<?= (int) $pr['id'] ?>"<?= (int) $post['related_product_id'] === (int) $pr['id'] ? ' selected' : '' ?>><?= e($pr['title']) ?></option><?php endforeach; ?>
        </select>
        <label class="check"><input type="checkbox" name="no_ads" value="1"<?= $post['no_ads'] ? ' checked' : '' ?>> <?= e(t('admin.field.no_ads')) ?></label>
      </div>
    </details>

    <details class="box">
      <summary><?= e(t('admin.seo.outline')) ?></summary>
      <div class="box__body"><ol class="outline" data-outline></ol></div>
    </details>

    <?php if (!$isNew && $post['locale'] === 'es' && in_array($post['type'], ['post', 'page'], true)):
        try { $socialChannels = \App\Services\Social\Channels::all(true); } catch (\Throwable) { $socialChannels = []; } ?>
    <?php if ($socialChannels): ?>
    <details class="box">
      <summary><?= e(t('admin.social.schedule_box')) ?></summary>
      <div class="box__body">
        <?php if ($post['status'] !== 'published'): ?>
        <p class="hint"><?= e(t('admin.social.schedule_unpublished')) ?></p>
        <?php else: ?>
        <p class="hint"><?= e(t('admin.social.schedule_help')) ?></p>
        <label for="p-social-channel"><?= e(t('admin.social.channels')) ?></label>
        <select id="p-social-channel" name="channel_id" form="social-schedule">
          <?php foreach ($socialChannels as $sc): ?><option value="<?= (int) $sc['id'] ?>"><?= e($sc['name']) ?></option><?php endforeach; ?>
        </select>
        <label for="p-social-date"><?= e(t('admin.social.date_local')) ?></label>
        <input id="p-social-date" type="datetime-local" name="scheduled_local" form="social-schedule" required
               value="<?= e(\App\Services\Social\Schedule::toLocal(gmdate('Y-m-d H:i:s', time() + 86400), 'Y-m-d') . 'T' . $socialChannels[0]['schedule']['time']) ?>">
        <button class="btn btn--small btn--block" type="submit" form="social-schedule"><?= icon('share') ?><?= e(t('admin.social.schedule_btn')) ?></button>
        <?php endif; ?>
      </div>
    </details>
    <?php endif; endif; ?>

    <?php if (!$isNew): ?>
    <details class="box box--danger">
      <summary><?= e(t('admin.danger_zone')) ?></summary>
      <div class="box__body">
        <?php if (!empty($protected)): ?>
        <p class="hint"><?= e(t('admin.posts.protected_hint')) ?></p>
        <?php else: ?>
        <p class="hint"><?= e(t('admin.posts.delete_note')) ?></p>
        <button class="btn btn--danger btn--small btn--block" type="submit" form="delete-post"><?= icon('trash') ?><?= e(t('admin.posts.delete_this')) ?></button>
        <?php endif; ?>
      </div>
    </details>
    <?php endif; ?>
  </aside>
</form>
<?php if (!empty($socialChannels) && $post['status'] === 'published'): ?>
<form id="social-schedule" method="post" action="<?= e(route('admin.social.schedule')) ?>" hidden>
  <?= csrf_field() ?>
  <input type="hidden" name="post_id" value="<?= (int) $post['id'] ?>">
</form>
<?php endif; ?>
<?php if (!$isNew && empty($protected)): ?>
<form id="delete-post" method="post" action="<?= e(route('admin.posts.delete')) ?>" data-delete-form hidden>
  <?= csrf_field() ?>
  <input type="hidden" name="ids[]" value="<?= (int) $post['id'] ?>" data-title="<?= e($post['title']) ?>" data-translation="<?= $translation ? '1' : '0' ?>">
  <input type="hidden" name="return" value="/admin/contenido/">
</form>
<?= \App\Core\View::render('admin/posts/delete-dialog', ['returnUrl' => '/admin/contenido/']) ?>
<?php endif; ?>
<script type="application/json" id="rte-data"><?= json_encode([
    'products' => array_map(fn ($p) => ['slug' => $p['slug'], 'title' => $p['title']], $products),
    'hubs' => array_map(fn ($h) => ['key' => $h['key'], 'title' => $h['title']], $hubs),
], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
