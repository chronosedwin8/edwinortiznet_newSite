<?php
/**
 * Asistente de nuevo examen (6 pasos). Sin JavaScript es un formulario largo; con JavaScript se divide en pasos,
 * muestra el total de preguntas en vivo y guarda un borrador en este navegador.
 * @var array $customer @var array|null $profile @var array $summary @var bool $canCreate @var bool $aiReady @var array $input @var array $header
 * @var array $subjects @var array $grades @var array $difficulties @var array $styles @var array $scopes @var array $purposes
 * @var array $types @var array $typeHints @var array $papers @var array $examples @var bool $hasLogo @var string|null $notice @var string|null $error
 */

use App\Core\View;

$steps = ['examenes.new.s1', 'examenes.new.s2', 'examenes.new.s3', 'examenes.new.s4', 'examenes.new.s5', 'examenes.new.s6'];
$in = $input + ['tipos' => ['unica' => 10, 'vf' => 5, 'abierta' => 2]];
$forms = ['in' => $in, 'examples' => $examples] + compact('subjects', 'grades', 'difficulties', 'styles', 'scopes', 'purposes', 'types', 'typeHints', 'papers');
?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'new']) ?>
<section class="wrap ex-page ex-new">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <header class="ex-head-page">
    <p class="eyebrow"><?= e(t('examenes.brand')) ?></p>
    <h1 class="ex-title"><?= e(t('examenes.new.title')) ?></h1>
    <p class="lead"><?= e(t('examenes.new.lead')) ?></p>
  </header>

  <?php if (!$canCreate): ?>
  <div class="ex-panel ex-locked">
    <span class="ex-locked__icon" aria-hidden="true"><?= icon('list-ol') ?></span>
    <h2 class="ex-panel__title"><?= e(t('examenes.new.locked_title')) ?></h2>
    <p><?= e(t($summary['ever_paid'] ? 'examenes.new.locked_paid' : 'examenes.new.locked')) ?></p>
    <div class="ex-actions">
      <a class="btn btn--buy btn--lg" href="<?= e(route('examenes.plans')) ?>"><?= e(t('examenes.meter.buy')) ?></a>
      <a class="btn btn--ghost btn--lg" href="<?= e(route('examenes.demo')) ?>"><?= icon('eye') ?><?= e(t('examenes.meter.demo')) ?></a>
    </div>
  </div>
  <?php elseif (!$aiReady): ?>
  <p class="notice notice--error"><?= e(t('examenes.new.unavailable')) ?></p>
  <?php else: ?>
  <div class="ex-wizard" data-ex-wizard data-label-step="<?= e(t('examenes.new.step')) ?>" data-label-empty="<?= e(t('examenes.review.empty')) ?>"
       data-label-edit="<?= e(t('examenes.review.edit')) ?>" data-label-saved="<?= e(t('examenes.new.draft_saved')) ?>" data-label-submitting="<?= e(t('examenes.new.submitting')) ?>"
       data-label-types="<?= e(t('examenes.error.types')) ?>" data-draft-key="eo-examenes-draft-v1"<?= $input ? ' data-prefilled' : '' ?>>
    <ol class="ex-stepper js-only" data-stepper>
      <?php foreach ($steps as $i => $key): ?>
      <li><button type="button" class="ex-stepper__item" data-goto="<?= $i ?>"><span class="ex-stepper__n"><?= $i + 1 ?></span><span class="ex-stepper__label"><?= e(t($key)) ?></span></button></li>
      <?php endforeach; ?>
    </ol>
    <p class="notice ex-draft-banner" data-draft-banner hidden><span><?= e(t('examenes.new.draft_restored')) ?></span> <button type="button" class="link-button" data-draft-discard><?= e(t('examenes.new.draft_discard')) ?></button></p>

    <form class="ex-form ex-wizard__form" action="<?= e(route('examenes.new')) ?>" method="post" data-ex-form data-max-versions="<?= (int) $summary['max_versions'] ?>">
      <?= csrf_field() ?>
      <fieldset class="ex-step" data-step="0">
        <legend class="ex-step__title"><span class="ex-step__n">1</span><?= e(t('examenes.new.s1')) ?></legend>
        <p class="ex-step__lead"><?= e(t('examenes.new.s1_lead')) ?></p>
        <?= View::render('partials/examenes/form-subject', $forms) ?>
      </fieldset>

      <fieldset class="ex-step" data-step="1">
        <legend class="ex-step__title"><span class="ex-step__n">2</span><?= e(t('examenes.new.s2')) ?></legend>
        <p class="ex-step__lead"><?= e(t('examenes.new.s2_lead')) ?></p>
        <?= View::render('partials/examenes/form-topic', $forms) ?>
      </fieldset>

      <fieldset class="ex-step" data-step="2">
        <legend class="ex-step__title"><span class="ex-step__n">3</span><?= e(t('examenes.new.s3')) ?></legend>
        <p class="ex-step__lead"><?= e(t('examenes.new.s3_lead')) ?></p>
        <?= View::render('partials/examenes/form-types', $forms) ?>
      </fieldset>

      <fieldset class="ex-step" data-step="3">
        <legend class="ex-step__title"><span class="ex-step__n">4</span><?= e(t('examenes.new.s4')) ?></legend>
        <p class="ex-step__lead"><?= e(t('examenes.new.s4_lead')) ?></p>
        <?= View::render('partials/examenes/form-versions', ['in' => $in, 'maxVersions' => max(1, (int) $summary['max_versions']), 'maxQuestions' => (int) $summary['max_questions']]) ?>
      </fieldset>

      <fieldset class="ex-step" data-step="4">
        <legend class="ex-step__title"><span class="ex-step__n">5</span><?= e(t('examenes.new.s5')) ?></legend>
        <p class="ex-step__lead"><?= e(t('examenes.new.s5_lead')) ?></p>
        <?= View::render('partials/examenes/form-header', ['hd' => $header, 'papers' => $papers, 'hasLogo' => $hasLogo]) ?>
      </fieldset>

      <fieldset class="ex-step ex-step--review" data-step="5">
        <legend class="ex-step__title"><span class="ex-step__n">6</span><?= e(t('examenes.new.s6')) ?></legend>
        <p class="ex-step__lead"><?= e(t('examenes.new.s6_lead')) ?></p>
        <div class="ex-review js-only" data-review aria-live="polite"></div>
        <noscript><p class="ex-muted"><?= e(t('examenes.review.nojs')) ?></p></noscript>
        <p class="ex-usage-note"><?= icon('notice') ?><span><?= e(!empty($summary['admin']) ? t('examenes.new.admin_note') : t('examenes.new.credits_note', ['n' => (int) $summary['remaining']])) ?></span></p>
        <button class="btn btn--buy btn--lg ex-submit" type="submit" data-submit><?= icon('spark') ?><span><?= e(t('examenes.new.submit')) ?></span></button>
        <p class="form-note"><?= e(t('examenes.new.time_note')) ?></p>
      </fieldset>

      <div class="ex-wizard__nav js-only" data-nav>
        <button type="button" class="btn btn--ghost" data-prev><?= icon('chevron-left') ?><?= e(t('examenes.new.prev')) ?></button>
        <span class="ex-wizard__count" data-count-label></span>
        <button type="button" class="btn btn--primary" data-next><?= e(t('examenes.new.next')) ?><?= icon('chevron-right') ?></button>
      </div>
    </form>
  </div>
  <script type="application/json" data-ex-examples><?= json_encode($examples, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
  <?= View::render('partials/examenes/progress', ['overlay' => true]) ?>
  <?php endif; ?>
</section>
