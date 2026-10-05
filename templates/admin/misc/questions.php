<?php /** @var array $questions @var array|null $edit */
$opts = $edit ? implode("\n", json_decode((string) $edit['options_json'], true) ?: []) : '';
?>
<section class="panel">
  <h2><?= e($edit ? t('admin.questions.edit') : t('admin.questions.new')) ?></h2>
  <p class="hint"><?= e(t('admin.questions.note')) ?></p>
  <form method="post" action="/admin/preguntas/" class="admin-form">
    <?= csrf_field() ?>
    <input type="hidden" name="id" value="<?= (int) ($edit['id'] ?? 0) ?>">
    <label for="q-area"><?= e(t('admin.field.area')) ?></label>
    <input id="q-area" name="area" maxlength="120" value="<?= e((string) ($edit['area'] ?? '')) ?>">
    <label for="q-question"><?= e(t('admin.field.question')) ?></label>
    <textarea id="q-question" name="question" rows="3" required><?= e((string) ($edit['question'] ?? '')) ?></textarea>
    <label for="q-options"><?= e(t('admin.field.options')) ?></label>
    <textarea id="q-options" name="options" rows="5" required><?= e($opts) ?></textarea>
    <label for="q-correct"><?= e(t('admin.field.correct')) ?></label>
    <input id="q-correct" name="correct" type="number" min="1" max="10" value="<?= (int) ($edit['correct_index'] ?? 0) + 1 ?>" class="narrow">
    <label for="q-expl"><?= e(t('admin.field.explanation')) ?></label>
    <textarea id="q-expl" name="explanation" rows="3"><?= e((string) ($edit['explanation'] ?? '')) ?></textarea>
    <label class="check"><input type="checkbox" name="active" value="1"<?= ($edit['active'] ?? 1) ? ' checked' : '' ?>> <?= e(t('admin.field.active')) ?></label>
    <label class="check"><input type="checkbox" name="is_demo" value="1"<?= !empty($edit['is_demo']) ? ' checked' : '' ?>> <?= e(t('admin.field.demo')) ?></label>
    <button class="btn" type="submit"><?= e(t('admin.save')) ?></button>
  </form>
</section>
<table class="data">
  <thead><tr><th><?= e(t('admin.field.question')) ?></th><th><?= e(t('admin.field.area')) ?></th><th><?= e(t('admin.f.status')) ?></th><th></th></tr></thead>
  <tbody>
  <?php foreach ($questions as $q): ?>
    <tr><td><?= e(excerpt_text($q['question'], 120)) ?></td><td><?= e($q['area']) ?></td>
      <td><?= e(t($q['active'] ? 'admin.field.active' : 'admin.inactive')) ?><?= $q['is_demo'] ? ' · ' . e(t('admin.field.demo')) : '' ?></td>
      <td><a href="/admin/preguntas/?editar=<?= (int) $q['id'] ?>"><?= e(t('admin.edit')) ?></a>
        <form method="post" action="<?= e(route('admin.questions.delete', ['id' => (int) $q['id']])) ?>" class="inline" data-confirm="<?= e(t('admin.confirm_delete')) ?>"><?= csrf_field() ?><button class="link-button" type="submit"><?= e(t('admin.delete')) ?></button></form></td></tr>
  <?php endforeach; ?>
  </tbody>
</table>
