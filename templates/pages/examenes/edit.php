<?php
/**
 * Editor: cada pregunta se edita por separado (texto, opciones, claves, soluciones y puntaje en todas sus versiones),
 * se puede quitar o reemplazar con IA, y se pueden pedir preguntas adicionales con IA. También encabezado y formato.
 * @var array $customer @var array $exam @var array $input @var array $header @var array $slots @var array $quota @var bool $hasLogo @var bool $aiReady
 * @var array $types @var array $difficulties @var array $styles @var array $papers @var string|null $notice @var string|null $error
 */

use App\Core\View;
use App\Services\Examenes\ExamCatalog;
use App\Services\Examenes\ExamContent;
use App\Services\Examenes\ExamCredits;
use App\Services\Examenes\Exams;
use App\Services\Examenes\ExamView as V;

$uuid = $exam['uuid'];
$action = route('examenes.edit', ['uuid' => $uuid]);
$labels = array_slice(ExamCatalog::VERSION_LABELS, 0, (int) $exam['versions']);
$distinct = $exam['mode'] === 'distintas';
$lines = static fn (array $items): string => implode("\n", $items);
$aiOk = $quota['ok'] && $aiReady;
$reason = $quota['reason'] ? t('examenes.ai.reason_' . $quota['reason']) : '';
?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap ex-page ex-edit" data-ex-editor data-render-url="<?= e(route('examenes.render')) ?>" data-label-preview-error="<?= e(t('examenes.edit.preview_error')) ?>">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <header class="ex-exam__head">
    <div>
      <p class="eyebrow"><a href="<?= e(route('examenes.show', ['uuid' => $uuid])) ?>"><?= icon('chevron-left') ?><?= e(t('examenes.edit.back')) ?></a></p>
      <h1 class="ex-title ex-title--sm"><?= e(t('examenes.edit.title')) ?></h1>
      <p class="ex-exam__meta"><span><?= e($exam['title']) ?></span><span><?= e(t('examenes.mode.' . $exam['mode'])) ?> · <?= e(implode(', ', $labels)) ?></span></p>
    </div>
    <div class="ex-exam__actions">
      <a class="btn btn--buy" href="<?= e(route('examenes.pdf', ['uuid' => $uuid])) ?>" data-ex-pdf data-label-busy="<?= e(t('examenes.exam.pdf_busy')) ?>"><?= icon('download') ?><span><?= e(t('examenes.exam.pdf')) ?></span></a>
      <a class="btn btn--ghost" href="<?= e(route('examenes.show', ['uuid' => $uuid])) ?>"><?= icon('eye') ?><?= e(t('examenes.edit.see')) ?></a>
    </div>
  </header>

  <div class="ex-aibox">
    <div class="ex-aibox__text">
      <p class="ex-aibox__title"><?= icon('spark') ?><?= e(t('examenes.ai.title')) ?></p>
      <p class="ex-muted" data-ai-quota><?= e(t('examenes.ai.quota', ['n' => $quota['left'], 'r' => $quota['requests_left'], 'u' => $quota['unique'], 'max' => $quota['unique_max']])) ?></p>
      <?php if (!$aiOk && $reason !== ''): ?><p class="ex-small ex-warn"><?= e($reason) ?></p><?php endif; ?>
    </div>
    <button type="button" class="btn btn--primary js-only" data-ai-open data-mode="add"<?= $aiOk ? '' : ' disabled' ?>><?= icon('plus') ?><?= e(t('examenes.ai.add')) ?></button>
    <noscript><p class="ex-small"><?= e(t('examenes.ai.nojs')) ?></p></noscript>
  </div>

  <details class="ex-panel ex-hdform" id="encabezado">
    <summary class="ex-hdform__summary"><?= icon('file') ?><?= e(t('examenes.edit.header')) ?></summary>
    <form class="ex-form" action="<?= e($action) ?>" method="post">
      <?= csrf_field() ?>
      <input type="hidden" name="anchor" value="encabezado">
      <?= View::render('partials/examenes/form-header', ['hd' => json_decode((string) $exam['header_json'], true) ?: $header, 'papers' => $papers, 'hasLogo' => $hasLogo]) ?>
      <button class="btn btn--primary" type="submit"><?= e(t('examenes.edit.save_header')) ?></button>
    </form>
  </details>

  <ol class="ex-eslots">
    <?php foreach ($slots as $n => $slot): $type = $slot['type']; $sid = $slot['id']; ?>
    <li class="ex-eslot" id="s-<?= e($sid) ?>">
      <div class="ex-eslot__head">
        <span class="ex-eslot__n"><?= $n + 1 ?></span>
        <div class="ex-eslot__info">
          <p class="ex-eslot__type"><?= e($types[$type] ?? $type) ?> · <?= e(V::pointsLabel((float) $slot['points'])) ?></p>
          <?php if (!empty($slot['skill'])): ?><p class="ex-eslot__skill"><?= e($slot['skill']) ?></p><?php endif; ?>
        </div>
        <div class="ex-eslot__tools">
          <button type="button" class="btn btn--ghost btn--sm js-only" data-ai-open data-mode="replace" data-slot="<?= e($sid) ?>" data-type="<?= e($type) ?>"<?= $aiOk ? '' : ' disabled' ?>><?= icon('shuffle') ?><?= e(t('examenes.ai.replace')) ?></button>
          <form action="<?= e($action) ?>" method="post" data-confirm="<?= e(t('examenes.edit.remove_confirm')) ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="remove[]" value="<?= e($sid) ?>">
            <button class="btn btn--ghost btn--sm ex-danger" type="submit" aria-label="<?= e(t('examenes.edit.remove_n', ['n' => $n + 1])) ?>"><?= icon('trash') ?></button>
          </form>
        </div>
      </div>
      <div class="ex-eslot__preview"><?= V::text((string) ($slot['variants'][0]['stem'] ?? '')) ?></div>
      <details class="ex-eslot__edit">
        <summary><?= icon('gear') ?><?= e(t('examenes.edit.edit_q')) ?></summary>
        <form class="ex-form" action="<?= e($action) ?>" method="post">
          <?= csrf_field() ?>
          <input type="hidden" name="anchor" value="s-<?= e($sid) ?>">
          <div class="form__row ex-points">
            <label for="p-<?= e($sid) ?>"><?= e(t('examenes.edit.points')) ?></label>
            <input id="p-<?= e($sid) ?>" name="points[<?= e($sid) ?>]" type="number" min="0" max="100" step="0.5" value="<?= e((string) $slot['points']) ?>" inputmode="decimal">
          </div>
          <?php foreach ($slot['variants'] as $v => $q): $f = 'q[' . $sid . '][' . $v . ']'; $id = $sid . '-' . $v; ?>
          <fieldset class="ex-variant">
            <?php if ($distinct && count($slot['variants']) > 1): ?><legend class="ex-variant__title"><?= e(t('examenes.pdf.version_n', ['v' => $labels[$v] ?? ($v + 1)])) ?></legend><?php endif; ?>
            <div class="form__row">
              <label for="st-<?= e($id) ?>"><?= e(t('examenes.edit.stem')) ?></label>
              <textarea id="st-<?= e($id) ?>" name="<?= e($f) ?>[stem]" rows="3" maxlength="4000" data-autogrow data-ex-preview><?= e($q['stem']) ?></textarea>
            </div>
            <?php if ($type === 'unica' || $type === 'multiple'): $opts = array_pad($q['options'], min(6, count($q['options']) + 1), ''); ?>
            <p class="ex-label"><?= e(t($type === 'unica' ? 'examenes.edit.options_one' : 'examenes.edit.options_many')) ?></p>
            <ul class="ex-eopts">
              <?php foreach ($opts as $i => $opt): ?>
              <li>
                <input type="<?= $type === 'unica' ? 'radio' : 'checkbox' ?>" name="<?= e($f) ?>[correct][]" value="<?= $i ?>"<?= in_array($i, $q['correct'], true) ? ' checked' : '' ?> aria-label="<?= e(t('examenes.edit.correct_n', ['l' => ExamContent::letter($i)])) ?>">
                <input type="text" name="<?= e($f) ?>[options][<?= $i ?>]" maxlength="600" value="<?= e($opt) ?>" aria-label="<?= e(t('examenes.edit.option_n', ['l' => ExamContent::letter($i)])) ?>" placeholder="<?= e($opt === '' ? t('examenes.edit.option_new') : '') ?>">
              </li>
              <?php endforeach; ?>
            </ul>
            <?php elseif ($type === 'vf'): ?>
            <div class="form__row"><label for="tf-<?= e($id) ?>"><?= e(t('examenes.edit.tf')) ?></label>
              <select id="tf-<?= e($id) ?>" name="<?= e($f) ?>[tf]"><option value="1"<?= $q['tf'] ? ' selected' : '' ?>><?= e(t('examenes.pdf.true')) ?></option><option value="0"<?= !$q['tf'] ? ' selected' : '' ?>><?= e(t('examenes.pdf.false')) ?></option></select></div>
            <?php elseif ($type === 'completar'): ?>
            <p class="form-note"><?= e(t('examenes.edit.cloze_help')) ?></p>
            <div class="form__row"><label for="bl-<?= e($id) ?>"><?= e(t('examenes.edit.blanks')) ?></label><textarea id="bl-<?= e($id) ?>" name="<?= e($f) ?>[blanks]" rows="3" data-autogrow><?= e($lines($q['blanks'])) ?></textarea></div>
            <?php elseif ($type === 'relacionar'): ?>
            <div class="form__row"><label for="pa-<?= e($id) ?>"><?= e(t('examenes.edit.pairs')) ?></label><p class="form-note"><?= e(t('examenes.edit.pairs_help')) ?></p><textarea id="pa-<?= e($id) ?>" name="<?= e($f) ?>[pairs]" rows="5" data-autogrow><?= e($lines(array_map(fn ($p) => $p['l'] . ' | ' . $p['r'], $q['pairs']))) ?></textarea></div>
            <?php elseif ($type === 'ordenar'): ?>
            <div class="form__row"><label for="it-<?= e($id) ?>"><?= e(t('examenes.edit.items')) ?></label><p class="form-note"><?= e(t('examenes.edit.items_help')) ?></p><textarea id="it-<?= e($id) ?>" name="<?= e($f) ?>[items]" rows="5" data-autogrow><?= e($lines($q['items'])) ?></textarea></div>
            <?php elseif ($type === 'crucigrama' || $type === 'sopa'): ?>
            <div class="form__row"><label for="wd-<?= e($id) ?>"><?= e(t('examenes.edit.words')) ?></label><p class="form-note"><?= e(t('examenes.edit.words_help')) ?></p><textarea id="wd-<?= e($id) ?>" name="<?= e($f) ?>[words]" rows="6" data-autogrow><?= e($lines(array_map(fn ($w) => $w['w'] . ' | ' . $w['c'], $q['words']))) ?></textarea></div>
            <?php endif; ?>
            <?php if (in_array($type, ['corta', 'problema', 'abierta', 'larga'], true)): ?>
            <div class="form__row"><label for="an-<?= e($id) ?>"><?= e(t(in_array($type, ['abierta', 'larga'], true) ? 'examenes.pdf.model_answer' : 'examenes.pdf.answer_key')) ?></label><textarea id="an-<?= e($id) ?>" name="<?= e($f) ?>[answer]" rows="2" maxlength="1500" data-autogrow data-ex-preview><?= e($q['answer'] ?? '') ?></textarea></div>
            <?php endif; ?>
            <?php if (!in_array($type, ['abierta', 'larga', 'crucigrama', 'sopa'], true)): ?>
            <div class="form__row"><label for="so-<?= e($id) ?>"><?= e(t($type === 'problema' ? 'examenes.pdf.solution' : 'examenes.pdf.explanation')) ?></label><textarea id="so-<?= e($id) ?>" name="<?= e($f) ?>[solution]" rows="3" maxlength="5000" data-autogrow data-ex-preview><?= e($q['solution'] ?? '') ?></textarea></div>
            <?php endif; ?>
            <?php if (in_array($type, ['problema', 'abierta', 'larga'], true)): ?>
            <div class="form__row"><label for="ru-<?= e($id) ?>"><?= e(t('examenes.pdf.rubric')) ?></label><p class="form-note"><?= e(t('examenes.edit.lines_help')) ?></p><textarea id="ru-<?= e($id) ?>" name="<?= e($f) ?>[rubric]" rows="3" data-autogrow><?= e($lines($q['rubric'] ?? [])) ?></textarea></div>
            <?php endif; ?>
          </fieldset>
          <?php endforeach; ?>
          <p class="form-note"><?= e(t('examenes.edit.latex_help')) ?></p>
          <button class="btn btn--primary" type="submit"><?= e(t('examenes.edit.save_q')) ?></button>
        </form>
      </details>
    </li>
    <?php endforeach; ?>
  </ol>

  <dialog class="ex-dialog" data-ai-dialog aria-labelledby="ex-ai-title"
          data-url="<?= e(route('examenes.ai', ['uuid' => $uuid])) ?>" data-label-add="<?= e(t('examenes.ai.add_title')) ?>" data-label-replace="<?= e(t('examenes.ai.replace_title')) ?>"
          data-label-working="<?= e(t('examenes.ai.working')) ?>" data-label-error="<?= e(t('examenes.ai.error_ai')) ?>">
    <form class="ex-form" method="dialog" data-ai-form>
      <h2 class="ex-panel__title" id="ex-ai-title" data-ai-title><?= e(t('examenes.ai.add_title')) ?></h2>
      <p class="ex-muted ex-small" data-ai-note><?= e(t('examenes.ai.note', ['v' => $quota['variants']])) ?></p>
      <input type="hidden" name="slot" value="" data-ai-slot>
      <div class="ex-grid">
        <div class="form__row"><label for="ai-type"><?= e(t('examenes.ai.type')) ?></label>
          <select id="ai-type" name="type"><?php foreach ($types as $k => $label): ?><option value="<?= e($k) ?>"><?= e($label) ?></option><?php endforeach; ?></select></div>
        <div class="form__row" data-ai-count><label for="ai-count"><?= e(t('examenes.ai.count')) ?></label>
          <select id="ai-count" name="count"><?php for ($i = 1; $i <= ExamCredits::EDIT_MAX; $i++): ?><option value="<?= $i ?>"><?= $i ?></option><?php endfor; ?></select></div>
        <div class="form__row"><label for="ai-diff"><?= e(t('examenes.f.dificultad')) ?></label>
          <select id="ai-diff" name="difficulty"><?php foreach ($difficulties as $k => $label): ?><option value="<?= e($k) ?>"<?= ($input['dificultad'] ?? '') === $k ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
        <div class="form__row"><label for="ai-style"><?= e(t('examenes.f.estilo')) ?></label>
          <select id="ai-style" name="style"><?php foreach ($styles as $k => $label): ?><option value="<?= e($k) ?>"<?= ($input['estilo'] ?? '') === $k ? ' selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
      </div>
      <div class="form__row">
        <label for="ai-topic"><?= e(t('examenes.ai.topic')) ?></label>
        <input id="ai-topic" name="topic" type="text" maxlength="<?= Exams::MAX_TOPIC ?>" placeholder="<?= e($input['tema'] ?? '') ?>" aria-describedby="ai-topic-c" data-count>
        <p class="ex-counter" id="ai-topic-c" aria-live="polite"></p>
      </div>
      <div class="form__row">
        <label for="ai-context"><?= e(t('examenes.ai.context')) ?></label>
        <p class="form-note" id="ai-context-h"><?= e(t('examenes.ai.context_help')) ?></p>
        <textarea id="ai-context" name="context" rows="4" maxlength="<?= Exams::MAX_REQUEST_CONTEXT ?>" aria-describedby="ai-context-h ai-context-c" data-count data-autogrow></textarea>
        <p class="ex-counter" id="ai-context-c" aria-live="polite"></p>
      </div>
      <p class="ex-ai-status" data-ai-status role="status" aria-live="polite"></p>
      <div class="ex-actions">
        <button type="button" class="btn btn--primary" data-ai-submit><?= icon('spark') ?><span><?= e(t('examenes.ai.generate')) ?></span></button>
        <button type="button" class="btn btn--ghost" data-ai-close><?= e(t('examenes.ai.cancel')) ?></button>
      </div>
    </form>
  </dialog>
</section>
