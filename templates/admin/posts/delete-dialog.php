<?php /** @var string $returnUrl */ ?>
<dialog class="modal modal--sm" data-delete-dialog aria-labelledby="del-title" aria-describedby="del-desc">
  <form method="post" action="<?= e(route('admin.posts.delete')) ?>">
    <?= csrf_field() ?>
    <input type="hidden" name="confirmed" value="1">
    <input type="hidden" name="return" value="<?= e($returnUrl) ?>" data-delete-return>
    <div data-delete-ids></div>
    <div class="modal__head"><h2 id="del-title" data-delete-heading data-one="<?= e(t('admin.posts.delete_heading_one')) ?>" data-many="<?= e(t('admin.posts.delete_heading')) ?>"><?= e(t('admin.posts.delete_title')) ?></h2></div>
    <div class="modal__body">
      <ul class="delete-list" data-delete-list data-more="<?= e(t('admin.posts.delete_more')) ?>"></ul>
      <p id="del-desc" class="hint"><?= e(t('admin.posts.delete_note')) ?></p>
      <div data-delete-tr hidden>
        <label class="check"><input type="checkbox" name="with_translations" value="1"> <span data-delete-tr-label data-text="<?= e(t('admin.posts.delete_translations')) ?>"></span></label>
        <p class="hint"><?= e(t('admin.posts.delete_translations_hint')) ?></p>
      </div>
      <label class="check"><input type="checkbox" name="redirect" value="1" checked> <?= e(t('admin.posts.delete_redirect')) ?></label>
      <p class="hint"><?= e(t('admin.posts.delete_redirect_hint')) ?></p>
    </div>
    <div class="modal__foot">
      <button type="button" class="btn btn--ghost" data-delete-cancel><?= e(t('admin.cancel')) ?></button>
      <button type="submit" class="btn btn--danger"><?= icon('trash') ?><?= e(t('admin.delete')) ?></button>
    </div>
  </form>
</dialog>
