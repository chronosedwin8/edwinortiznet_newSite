<?php /** @var array $posts @var array $filters @var string $returnUrl */ ?>
<form class="filters-bar" method="get" action="/admin/contenido/">
  <label class="grow"><?= e(t('admin.f.search')) ?> <input type="search" name="q" value="<?= e($filters['q']) ?>"></label>
  <label><?= e(t('admin.f.locale')) ?>
    <select name="locale"><option value=""><?= e(t('admin.all')) ?></option><option value="es"<?= $filters['locale'] === 'es' ? ' selected' : '' ?>>ES</option><option value="en"<?= $filters['locale'] === 'en' ? ' selected' : '' ?>>EN</option></select>
  </label>
  <label><?= e(t('admin.f.type')) ?>
    <select name="type"><option value=""><?= e(t('admin.all')) ?></option>
      <?php foreach (['post', 'page', 'policy'] as $tp): ?><option value="<?= $tp ?>"<?= $filters['type'] === $tp ? ' selected' : '' ?>><?= e(t("admin.type.$tp")) ?></option><?php endforeach; ?>
    </select>
  </label>
  <label><?= e(t('admin.f.status')) ?>
    <select name="status"><option value=""><?= e(t('admin.all')) ?></option>
      <?php foreach (['published', 'draft', 'noindex'] as $st): ?><option value="<?= $st ?>"<?= $filters['status'] === $st ? ' selected' : '' ?>><?= e(t("admin.status.$st")) ?></option><?php endforeach; ?>
    </select>
  </label>
  <label class="check"><input type="checkbox" name="review" value="1"<?= $filters['review'] ? ' checked' : '' ?>> <?= e(t('admin.f.review')) ?></label>
  <label class="check"><input type="checkbox" name="seo" value="1"<?= $filters['seo'] ? ' checked' : '' ?>> <?= e(t('admin.f.seo_auto')) ?></label>
  <button class="btn btn--small" type="submit"><?= e(t('admin.filter')) ?></button>
  <a class="btn btn--small btn--ghost" href="/admin/contenido/nuevo/"><?= icon('plus') ?><?= e(t('admin.posts.new')) ?></a>
</form>
<p class="muted"><?= e(t('admin.count', ['n' => count($posts)])) ?></p>
<div class="table-wrap">
<table class="data data--posts">
  <thead><tr>
    <th class="col-check"><input type="checkbox" data-select-all aria-label="<?= e(t('admin.bulk.select_all')) ?>" title="<?= e(t('admin.bulk.select_all')) ?>" hidden></th>
    <th class="col-thumb"><span class="visually-hidden"><?= e(t('admin.field.cover')) ?></span></th>
    <th><?= e(t('admin.col.title')) ?></th>
    <th class="col-meta"><?= e(t('admin.f.type')) ?></th>
    <th class="col-meta"><?= e(t('admin.f.locale')) ?></th>
    <th class="col-meta"><?= e(t('admin.f.status')) ?></th>
    <th class="col-meta"><?= e(t('admin.col.date')) ?></th>
    <th class="col-meta"><?= e(t('admin.col.flags')) ?></th>
    <th class="col-actions"><span class="visually-hidden"><?= e(t('admin.col.actions')) ?></span></th>
  </tr></thead>
  <tbody>
  <?php foreach ($posts as $p): $id = (int) $p['id']; $tr = $p['has_translation'] ? '1' : '0'; ?>
    <tr>
      <td class="col-check">
        <?php if ($p['protected']): ?>
        <span class="lock" title="<?= e(t('admin.posts.protected_hint')) ?>"><?= icon('notice') ?><span class="visually-hidden"><?= e(t('admin.posts.protected')) ?></span></span>
        <?php else: ?>
        <input type="checkbox" name="ids[]" value="<?= $id ?>" form="bulk-form" data-row-check data-title="<?= e($p['title']) ?>" data-translation="<?= $tr ?>" aria-label="<?= e(t('admin.bulk.select', ['title' => $p['title']])) ?>">
        <?php endif; ?>
      </td>
      <td class="col-thumb"><?php if (!empty($p['cover_url'])): ?><img class="thumb" src="<?= e($p['cover_url']) ?>" alt="" loading="lazy" width="64" height="40"><?php else: ?><span class="thumb thumb--empty"><?= icon('file') ?></span><?php endif; ?></td>
      <td class="col-title"><a href="/admin/contenido/<?= $id ?>/"><?= e($p['title']) ?></a><br><small class="muted">/<?= e($p['slug']) ?>/</small>
        <small class="row-meta"><span><?= e(t('admin.type.' . $p['type'])) ?> · <?= e(strtoupper($p['locale'])) ?><?= $p['has_translation'] ? ' ↔' : '' ?></span> · <span class="tag tag--<?= e($p['status']) ?>"><?= e(t('admin.status.' . $p['status'])) ?></span> · <span><?= e(substr((string) $p['published_at'], 0, 10)) ?></span></small></td>
      <td class="col-meta"><?= e(t('admin.type.' . $p['type'])) ?></td>
      <td class="col-meta"><?= e(strtoupper($p['locale'])) ?><?= $p['has_translation'] ? ' ↔' : '' ?></td>
      <td class="col-meta"><span class="tag tag--<?= e($p['status']) ?>"><?= e(t('admin.status.' . $p['status'])) ?></span></td>
      <td class="col-meta"><?= e(substr((string) $p['published_at'], 0, 10)) ?></td>
      <td class="col-meta"><?php if ($p['protected']): ?><span class="tag tag--plain" title="<?= e(t('admin.posts.protected_hint')) ?>"><?= e(t('admin.posts.protected')) ?></span> <?php endif; ?><?php if ($p['needs_review']): ?><span class="tag tag--warn"><?= e(t('admin.f.review')) ?></span><?php endif; ?><?php if ($p['seo_auto']): ?> <span class="tag"><?= e(t('admin.f.seo_auto')) ?></span><?php endif; ?></td>
      <td class="col-actions">
        <?php if (!$p['protected']): ?>
        <form method="post" action="<?= e(route('admin.posts.delete')) ?>" data-delete-form>
          <?= csrf_field() ?>
          <input type="hidden" name="ids[]" value="<?= $id ?>" data-title="<?= e($p['title']) ?>" data-translation="<?= $tr ?>">
          <input type="hidden" name="return" value="<?= e($returnUrl) ?>">
          <button class="icon-btn icon-btn--sm icon-btn--danger" type="submit" aria-label="<?= e(t('admin.posts.delete_one', ['title' => $p['title']])) ?>" title="<?= e(t('admin.delete')) ?>"><?= icon('trash') ?></button>
        </form>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>

<?php if ($posts): ?>
<form id="bulk-form" class="bulk-bar" method="post" action="<?= e(route('admin.posts.delete')) ?>" data-delete-form data-bulk-bar aria-label="<?= e(t('admin.bulk.label')) ?>">
  <?= csrf_field() ?>
  <input type="hidden" name="return" value="<?= e($returnUrl) ?>">
  <p class="bulk-bar__count" data-bulk-count aria-live="polite" data-one="<?= e(t('admin.bulk.count_one')) ?>" data-many="<?= e(t('admin.bulk.count')) ?>"><?= e(t('admin.bulk.nojs')) ?></p>
  <button type="button" class="btn btn--ghost btn--small" data-bulk-clear hidden><?= e(t('admin.bulk.clear')) ?></button>
  <button type="submit" class="btn btn--danger btn--small"><?= icon('trash') ?><?= e(t('admin.bulk.delete')) ?></button>
</form>
<?= \App\Core\View::render('admin/posts/delete-dialog', ['returnUrl' => $returnUrl]) ?>
<?php endif; ?>
