<?php /** @var array $items @var int $total @var int $page @var int $pages @var string $q */ ?>
<form class="dropzone" method="post" action="<?= e(route('admin.media.upload')) ?>" enctype="multipart/form-data" data-dropzone id="subir">
  <?= csrf_field() ?>
  <?= icon('upload') ?>
  <p><strong><?= e(t('admin.media.drop')) ?></strong> <label class="link-button" for="media-files"><?= e(t('admin.media.choose')) ?></label></p>
  <input id="media-files" type="file" name="files[]" accept="image/jpeg,image/png,image/webp,image/gif" multiple class="visually-hidden">
  <p class="hint"><?= e(t('admin.media.hint')) ?></p>
  <p data-dropzone-status aria-live="polite"></p>
  <button class="btn btn--small" type="submit" data-dropzone-submit><?= e(t('admin.files.upload_button')) ?></button>
</form>

<form class="filters-bar" method="get" action="/admin/medios/">
  <label class="grow"><?= e(t('admin.f.search')) ?> <input type="search" name="q" value="<?= e($q) ?>"></label>
  <button class="btn btn--small" type="submit"><?= e(t('admin.filter')) ?></button>
  <span class="muted"><?= e(t('admin.count', ['n' => $total])) ?></span>
</form>

<?php if (!$items): ?>
<p class="muted"><?= e(t('admin.media.empty')) ?></p>
<?php else: ?>
<div class="media-grid">
  <?php foreach ($items as $m): ?>
  <article class="media-card">
    <a href="<?= e($m['url']) ?>" target="_blank" rel="noopener"><img src="<?= e($m['thumb']) ?>" alt="<?= e($m['alt']) ?>" width="<?= (int) $m['width'] ?>" height="<?= (int) $m['height'] ?>" loading="lazy"></a>
    <div class="media-card__body">
      <span class="media-card__name" title="<?= e($m['name']) ?>"><?= e($m['name'] ?: basename($m['url'])) ?></span>
      <span class="media-card__meta"><?= e(t('admin.media.meta', ['w' => $m['width'], 'h' => $m['height'], 'kb' => \App\Services\I18n\I18n::number($m['bytes'] / 1024, 0, 'es')])) ?></span>
      <form method="post" action="<?= e(route('admin.media.update', ['id' => $m['id']])) ?>" data-async data-ok="<?= e(t('admin.saved_short')) ?>">
        <?= csrf_field() ?>
        <label for="alt-<?= (int) $m['id'] ?>" class="visually-hidden"><?= e(t('admin.field.cover_alt')) ?></label>
        <input id="alt-<?= (int) $m['id'] ?>" name="alt" class="field" value="<?= e($m['alt']) ?>" placeholder="<?= e(t('admin.media.alt_placeholder')) ?>" maxlength="255">
        <button class="icon-btn icon-btn--sm" type="submit" aria-label="<?= e(t('admin.save')) ?>"><?= icon('check') ?></button>
      </form>
      <div class="media-card__tools">
        <button class="icon-btn icon-btn--sm" type="button" data-copy="<?= e($m['url']) ?>" aria-label="<?= e(t('admin.media.copy')) ?>" title="<?= e(t('admin.media.copy')) ?>"><?= icon('link') ?></button>
        <form method="post" action="<?= e(route('admin.media.delete', ['id' => $m['id']])) ?>" data-confirm="<?= e(t('admin.confirm_delete')) ?>"><?= csrf_field() ?><button class="icon-btn icon-btn--sm" type="submit" aria-label="<?= e(t('admin.delete')) ?>" title="<?= e(t('admin.delete')) ?>"><?= icon('trash') ?></button></form>
      </div>
    </div>
  </article>
  <?php endforeach; ?>
</div>
<?php if ($pages > 1): ?>
<nav class="pager" aria-label="<?= e(t('admin.pages')) ?>">
  <?php for ($i = 1; $i <= $pages; $i++): ?>
  <?php if ($i === $page): ?><span aria-current="page"><?= $i ?></span><?php else: ?><a href="?page=<?= $i ?><?= $q !== '' ? '&amp;q=' . rawurlencode($q) : '' ?>"><?= $i ?></a><?php endif; ?>
  <?php endfor; ?>
</nav>
<?php endif; ?>
<?php endif; ?>
