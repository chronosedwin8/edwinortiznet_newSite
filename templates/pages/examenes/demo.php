<?php
/**
 * Simulador sin IA: mismos campos que el asistente (llenos con un ejemplo y editables) y un examen de muestra armado
 * con el banco fijo, con marca de agua DEMO y PDF de muestra.
 * @var array|null $customer @var array $formInput @var array $formHeader @var array $versions @var ?array $version @var string $tab @var array $keys
 * @var array $header @var array $exam @var array $available @var bool $clamped @var bool $posted @var array $examples @var array $types @var array $typeHints
 * @var array $subjects @var array $grades @var array $difficulties @var array $styles @var array $scopes @var array $purposes @var array $papers
 * @var string|null $notice @var string|null $error
 */

use App\Core\View;
use App\Services\Examenes\ExamDemo;

$forms = ['in' => $formInput, 'examples' => $examples, 'available' => $available] + compact('subjects', 'grades', 'difficulties', 'styles', 'scopes', 'purposes', 'types', 'typeHints', 'papers');
$tabs = array_merge(array_column($versions, 'label'), ['key']);
?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'demo']) ?>
<section class="wrap ex-page ex-demo">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <header class="ex-head-page">
    <p class="eyebrow"><span class="ex-badge"><?= e(t('examenes.demo.badge')) ?></span> <?= e(t('examenes.brand')) ?></p>
    <h1 class="ex-title"><?= e(t('examenes.demo.title')) ?></h1>
    <p class="lead"><?= e(t('examenes.demo.lead')) ?></p>
    <p class="ex-demo__jump"><a href="#vista"><?= icon('arrow-down') ?><?= e(t('examenes.demo.jump')) ?></a></p>
  </header>

  <div class="ex-demo__grid">
    <form class="ex-panel ex-form ex-demo__form" id="demo-form" action="<?= e(route('examenes.demo')) ?>#vista" method="post" data-ex-demo>
      <?= csrf_field() ?>
      <details class="ex-fold" open>
        <summary class="ex-fold__summary"><span class="ex-step__n">1</span><?= e(t('examenes.new.s1')) ?></summary>
        <?= View::render('partials/examenes/form-subject', $forms) ?>
      </details>
      <details class="ex-fold" open>
        <summary class="ex-fold__summary"><span class="ex-step__n">2</span><?= e(t('examenes.new.s2')) ?></summary>
        <?= View::render('partials/examenes/form-topic', $forms) ?>
      </details>
      <details class="ex-fold">
        <summary class="ex-fold__summary"><span class="ex-step__n">3</span><?= e(t('examenes.new.s3')) ?></summary>
        <p class="form-note"><?= e(t('examenes.demo.types_note')) ?></p>
        <?= View::render('partials/examenes/form-types', $forms) ?>
      </details>
      <details class="ex-fold">
        <summary class="ex-fold__summary"><span class="ex-step__n">4</span><?= e(t('examenes.new.s4')) ?></summary>
        <?= View::render('partials/examenes/form-versions', ['in' => $formInput, 'maxVersions' => ExamDemo::MAX_VERSIONS, 'maxQuestions' => 0]) ?>
      </details>
      <details class="ex-fold">
        <summary class="ex-fold__summary"><span class="ex-step__n">5</span><?= e(t('examenes.new.s5')) ?></summary>
        <?= View::render('partials/examenes/form-header', ['hd' => $formHeader, 'papers' => $papers, 'hasLogo' => false, 'demo' => true]) ?>
      </details>
      <p class="ex-demo__note"><?= icon('notice') ?><span><?= e(t('examenes.demo.note')) ?></span></p>
      <div class="ex-actions">
        <button class="btn btn--primary" type="submit" name="v" value="A"><?= icon('eye') ?><?= e(t('examenes.demo.update')) ?></button>
        <button class="btn btn--ghost" type="submit" formaction="<?= e(route('examenes.demo.pdf')) ?>" data-ex-pdf data-label-busy="<?= e(t('examenes.exam.pdf_busy')) ?>"><?= icon('download') ?><span><?= e(t('examenes.demo.pdf')) ?></span></button>
      </div>
    </form>

    <div class="ex-demo__preview" id="vista">
      <?php if ($clamped): ?><p class="notice ex-small"><?= e(t('examenes.demo.clamped')) ?></p><?php endif; ?>
      <p class="ex-demo__topic"><?= icon('target') ?><span><?= e(t('examenes.demo.topic_used', ['topic' => $formInput['tema'] !== '' ? $formInput['tema'] : t('examenes.demo.no_topic')])) ?></span></p>
      <nav class="ex-tabs" aria-label="<?= e(t('examenes.exam.tabs')) ?>">
        <?php foreach ($tabs as $label): $text = $label === 'key' ? t('examenes.exam.key_tab') : (count($versions) > 1 ? t('examenes.pdf.version_n', ['v' => $label]) : t('examenes.exam.preview')); ?>
        <?php if ($posted): ?>
        <button class="ex-tab<?= $label === 'key' ? ' ex-tab--key' : '' ?>" type="submit" form="demo-form" name="v" value="<?= e($label) ?>"<?= $tab === $label ? ' aria-current="page"' : '' ?>><?= e($text) ?></button>
        <?php else: ?>
        <a class="ex-tab<?= $label === 'key' ? ' ex-tab--key' : '' ?>" href="<?= e(route('examenes.demo') . '?v=' . $label) ?>#vista"<?= $tab === $label ? ' aria-current="page"' : '' ?>><?= e($text) ?></a>
        <?php endif; ?>
        <?php endforeach; ?>
      </nav>
      <div class="ex-preview">
        <?php if ($tab === 'key'): ?>
        <?= View::render('partials/examenes/key', ['versions' => $versions, 'keys' => $keys, 'types' => $types, 'mode' => $exam['mode']]) ?>
        <?php else: ?>
        <?= View::render('partials/examenes/paper', ['version' => $version, 'header' => $header, 'types' => $types, 'count' => count($versions), 'demo' => true]) ?>
        <?php endif; ?>
      </div>
      <div class="ex-demo__cta">
        <p><?= e(t('examenes.demo.cta_text')) ?></p>
        <a class="btn btn--buy" href="<?= e(route('examenes.plans')) ?>"><?= e(t('examenes.demo.cta')) ?></a>
      </div>
    </div>
  </div>
  <script type="application/json" data-ex-examples><?= json_encode($examples, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
</section>
