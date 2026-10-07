<?php
/**
 * Examen generado: pestañas por versión y solucionario, descarga del PDF y acciones.
 * @var array $customer @var array $exam @var array $input @var array $header @var array $versions @var ?array $version @var string $tab
 * @var array $keys @var array $types @var array $quota @var array $summary @var bool $texAvailable @var string|null $notice @var string|null $error
 */

use App\Core\View;
use App\Services\Examenes\ExamCatalog;
use App\Services\Examenes\Exams;

$uuid = $exam['uuid'];
$base = route('examenes.show', ['uuid' => $uuid]);
$content = Exams::content($exam);
$missing = (int) ($content['missing'] ?? 0);
$logoUrl = !empty($header['logo']) && !empty($profile['logo_key']) ? route('examenes.logo') : null;
?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap ex-page ex-exam">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <header class="ex-exam__head">
    <div>
      <p class="eyebrow"><?= e(ExamCatalog::subjects()[$exam['subject']] ?? '') ?> · <?= e(ExamCatalog::grades()[$exam['grade']] ?? '') ?></p>
      <h1 class="ex-title ex-title--sm"><?= e($exam['title'] ?: t('examenes.exam.title')) ?></h1>
      <p class="ex-exam__meta">
        <span><?= icon('layers') ?><?= e(t((int) $exam['versions'] === 1 ? 'examenes.dash.versions_one' : 'examenes.dash.versions', ['n' => (int) $exam['versions']])) ?> · <?= e(t('examenes.mode.' . $exam['mode'])) ?></span>
        <span><?= icon('list') ?><?= e(t('examenes.dash.questions', ['n' => count($version['questions'] ?? $versions[0]['questions'])])) ?></span>
        <span><?= icon('file') ?><?= e(t('examenes.paper.' . $header['papel'])) ?></span>
      </p>
    </div>
    <div class="ex-exam__actions">
      <a class="btn btn--buy" href="<?= e(route('examenes.pdf', ['uuid' => $uuid])) ?>" data-ex-pdf data-label-busy="<?= e(t('examenes.exam.pdf_busy')) ?>"><?= icon('download') ?><span><?= e(t('examenes.exam.pdf')) ?></span></a>
      <a class="btn btn--primary" href="<?= e(route('examenes.edit', ['uuid' => $uuid])) ?>"><?= icon('gear') ?><?= e(t('examenes.exam.edit')) ?></a>
      <a class="btn btn--ghost" href="<?= e(route('examenes.new') . '?desde=' . $uuid) ?>"><?= icon('copy') ?><?= e(t('examenes.exam.duplicate')) ?></a>
    </div>
  </header>
  <?php if ($missing > 0): ?><p class="notice"><?= e(t('examenes.exam.missing', ['n' => $missing])) ?></p><?php endif; ?>
  <?php if (!$texAvailable): ?><p class="notice"><?= e(t('examenes.exam.tex_off')) ?></p><?php endif; ?>

  <nav class="ex-tabs" aria-label="<?= e(t('examenes.exam.tabs')) ?>">
    <?php foreach ($versions as $v): ?>
    <a class="ex-tab" href="<?= e($base . '?v=' . $v['label']) ?>"<?= $tab === $v['label'] ? ' aria-current="page"' : '' ?>><?= e(count($versions) > 1 ? t('examenes.pdf.version_n', ['v' => $v['label']]) : t('examenes.exam.preview')) ?></a>
    <?php endforeach; ?>
    <a class="ex-tab ex-tab--key" href="<?= e($base . '?v=key') ?>"<?= $tab === 'key' ? ' aria-current="page"' : '' ?>><?= icon('check') ?><?= e(t('examenes.exam.key_tab')) ?></a>
  </nav>

  <div class="ex-preview">
    <?php if ($tab === 'key'): ?>
    <?= View::render('partials/examenes/key', ['versions' => $versions, 'keys' => $keys, 'types' => $types, 'mode' => $exam['mode']]) ?>
    <?php else: ?>
    <?= View::render('partials/examenes/paper', ['version' => $version, 'header' => $header, 'types' => $types, 'count' => count($versions), 'logoUrl' => $logoUrl]) ?>
    <?php endif; ?>
  </div>

  <aside class="ex-exam__foot">
    <p class="ex-muted"><?= e(t('examenes.exam.ai_left', ['n' => $quota['left'], 'r' => $quota['requests_left']])) ?></p>
    <form action="<?= e(route('examenes.delete', ['uuid' => $uuid])) ?>" method="post" data-confirm="<?= e(t('examenes.exam.delete_confirm')) ?>">
      <?= csrf_field() ?>
      <button class="link-button ex-danger" type="submit"><?= icon('trash') ?><?= e(t('examenes.exam.delete')) ?></button>
    </form>
  </aside>
</section>
