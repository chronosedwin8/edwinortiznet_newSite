<?php
/** @var array $posts @var string $returnUrl */
$deletable = array_values(array_filter($posts, fn (array $p) => !$p['protected']));
$withTranslation = count(array_filter($deletable, fn (array $p) => (int) $p['has_translation'] > 0));
?>
<form method="post" action="<?= e(route('admin.posts.delete')) ?>" class="admin-form confirm-box">
  <?= csrf_field() ?>
  <input type="hidden" name="confirmed" value="1">
  <input type="hidden" name="return" value="<?= e($returnUrl) ?>">
  <ul class="delete-list">
    <?php foreach ($posts as $p): ?>
    <li>
      <?php if ($p['protected']): ?>
      <s><?= e($p['title']) ?></s> <span class="tag tag--plain"><?= e(t('admin.posts.protected')) ?></span>
      <?php else: ?>
      <input type="hidden" name="ids[]" value="<?= (int) $p['id'] ?>">
      <strong><?= e($p['title']) ?></strong>
      <?php endif; ?>
      <small class="muted">(<?= e(t('admin.type.' . $p['type'])) ?> · <?= e(strtoupper($p['locale'])) ?> · <?= e(t('admin.status.' . $p['status'])) ?>)</small>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php if (count($deletable) < count($posts)): ?><p class="hint"><?= e(t('admin.posts.protected_hint')) ?></p><?php endif; ?>
  <?php if ($deletable): ?>
  <p class="hint"><?= e(t('admin.posts.delete_note')) ?></p>
  <?php if ($withTranslation > 0): ?>
  <label class="check"><input type="checkbox" name="with_translations" value="1"> <?= e(t('admin.posts.delete_translations', ['n' => $withTranslation])) ?></label>
  <p class="hint"><?= e(t('admin.posts.delete_translations_hint')) ?></p>
  <?php endif; ?>
  <label class="check"><input type="checkbox" name="redirect" value="1" checked> <?= e(t('admin.posts.delete_redirect')) ?></label>
  <p class="hint"><?= e(t('admin.posts.delete_redirect_hint')) ?></p>
  <div class="actions">
    <button class="btn btn--danger" type="submit"><?= icon('trash') ?><?= e(t('admin.posts.delete_confirm', ['n' => count($deletable)])) ?></button>
    <a class="btn btn--ghost" href="<?= e($returnUrl) ?>"><?= e(t('admin.cancel')) ?></a>
  </div>
  <?php else: ?>
  <p class="actions"><a class="btn btn--ghost" href="<?= e($returnUrl) ?>"><?= e(t('admin.back')) ?></a></p>
  <?php endif; ?>
</form>
