<?php /** @var array $posts @var array $filters */ ?>
<form class="filters-bar" method="get" action="/admin/contenido/">
  <label><?= e(t('admin.f.search')) ?> <input type="search" name="q" value="<?= e($filters['q']) ?>"></label>
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
  <a class="btn btn--small btn--ghost" href="/admin/contenido/nuevo/"><?= e(t('admin.posts.new')) ?></a>
</form>
<p class="muted"><?= e(t('admin.count', ['n' => count($posts)])) ?></p>
<table class="data">
  <thead><tr><th><?= e(t('admin.col.title')) ?></th><th><?= e(t('admin.f.type')) ?></th><th><?= e(t('admin.f.locale')) ?></th><th><?= e(t('admin.f.status')) ?></th><th><?= e(t('admin.col.date')) ?></th><th><?= e(t('admin.col.flags')) ?></th></tr></thead>
  <tbody>
  <?php foreach ($posts as $p): ?>
    <tr>
      <td><a href="/admin/contenido/<?= (int) $p['id'] ?>/"><?= e($p['title']) ?></a><br><small class="muted">/<?= e($p['slug']) ?>/</small></td>
      <td><?= e(t('admin.type.' . $p['type'])) ?></td>
      <td><?= e(strtoupper($p['locale'])) ?><?= $p['has_translation'] ? ' ↔' : '' ?></td>
      <td><span class="tag tag--<?= e($p['status']) ?>"><?= e(t('admin.status.' . $p['status'])) ?></span></td>
      <td><?= e(substr((string) $p['published_at'], 0, 10)) ?></td>
      <td><?php if ($p['needs_review']): ?><span class="tag tag--warn"><?= e(t('admin.f.review')) ?></span><?php endif; ?><?php if ($p['seo_auto']): ?> <span class="tag"><?= e(t('admin.f.seo_auto')) ?></span><?php endif; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
