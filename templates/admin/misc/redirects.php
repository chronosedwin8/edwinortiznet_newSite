<?php /** @var array $redirects @var array $notFound @var string $prefill */ ?>
<section class="panel">
  <h2><?= e(t('admin.redirects.create')) ?></h2>
  <form method="post" action="/admin/redirecciones/" class="admin-form inline-form">
    <?= csrf_field() ?>
    <label for="r-source"><?= e(t('admin.field.source_path')) ?></label>
    <input id="r-source" name="source" required maxlength="255" value="<?= e($prefill) ?>" placeholder="<?= e(t('admin.hint.source_placeholder')) ?>">
    <label for="r-target"><?= e(t('admin.field.target')) ?></label>
    <input id="r-target" name="target" required maxlength="500" placeholder="<?= e(t('admin.hint.target_placeholder')) ?>">
    <label for="r-type"><?= e(t('admin.f.type')) ?></label>
    <select id="r-type" name="match_type">
      <?php foreach (['exact', 'prefix', 'regex'] as $mt): ?><option value="<?= $mt ?>"><?= e(t("admin.match.$mt")) ?></option><?php endforeach; ?>
    </select>
    <label for="r-code"><?= e(t('admin.field.code')) ?></label>
    <select id="r-code" name="code"><option value="301">301</option><option value="302">302</option></select>
    <label for="r-note"><?= e(t('admin.field.note')) ?></label>
    <input id="r-note" name="note" maxlength="255">
    <button class="btn" type="submit"><?= e(t('admin.save')) ?></button>
  </form>
</section>
<div class="grid-2">
  <section class="panel">
    <h2><?= e(t('admin.dash.not_found')) ?></h2>
    <?php if (!$notFound): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <table><tbody>
      <?php foreach ($notFound as $nf): ?>
      <tr><td><code><?= e($nf['path']) ?></code><br><small class="muted"><?= e((string) $nf['referer']) ?></small></td><td><?= (int) $nf['hits'] ?></td><td><a href="/admin/redirecciones/?source=<?= rawurlencode($nf['path']) ?>"><?= e(t('admin.redirects.create')) ?></a></td></tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>
  </section>
  <section class="panel">
    <h2><?= e(t('admin.redirects')) ?></h2>
    <table class="data">
      <tbody>
      <?php foreach ($redirects as $r): ?>
        <tr><td><code><?= e($r['source']) ?></code><br><small class="muted"><?= e(t('admin.match.' . $r['match_type'])) ?> · <?= (int) $r['code'] ?> · <?= (int) $r['hits'] ?></small></td><td>→ <code><?= e($r['target']) ?></code></td>
          <td><form method="post" action="<?= e(route('admin.redirects.delete', ['id' => (int) $r['id']])) ?>" data-confirm="<?= e(t('admin.confirm_delete')) ?>"><?= csrf_field() ?><button class="link-button" type="submit"><?= e(t('admin.delete')) ?></button></form></td></tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</div>
