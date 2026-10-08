<?php
/**
 * Asistente de nuevo PIAR. Sin JavaScript es un formulario largo; con JavaScript se divide en pasos,
 * guarda un borrador en este navegador y permite cargar un ejemplo.
 * @var array $customer @var array|null $profile @var array $summary @var bool $canCreate @var bool $isTrial @var bool $aiReady
 * @var array $conditions @var array $groupNotes @var array $grades @var array $areas @var array $levels @var array $dimensions
 * @var array $dimensionHints @var array $priorities @var array $periods @var array $help @var array $example
 * @var string|null $notice @var string|null $error
 */

use App\Core\View;

$fid = static fn (string $name): string => 'pf-' . trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-');
$note = static function (string $key, ?string $text = null) use ($help, $fid): string {
    $text ??= $help[$key] ?? '';
    return $text !== '' ? '<p class="form-note" id="' . e($fid($key)) . '-h">' . e($text) . '</p>' : '';
};
$described = static fn (string $key) => isset($help[$key]) ? ' aria-describedby="' . e($fid($key)) . '-h"' : '';
$textarea = static function (string $name, string $helpKey, string $labelKey, int $rows = 4, int $max = 3000) use ($note, $described, $fid): string {
    $id = $fid($helpKey);
    return '<div class="form__row"><label for="' . e($id) . '">' . e(t($labelKey)) . ' <span class="piar-opt-tag">' . e(t('piar.f.optional')) . '</span></label>'
        . $note($helpKey)
        . '<textarea id="' . e($id) . '" name="' . e($name) . '" rows="' . $rows . '" maxlength="' . $max . '"' . $described($helpKey) . ' data-autogrow></textarea></div>';
};
$steps = ['piar.new.s1', 'piar.new.s2', 'piar.new.s3', 'piar.new.s4', 'piar.new.s5', 'piar.new.s6'];
$year = (int) gmdate('Y');
?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => 'new']) ?>
<section class="wrap piar-page piar-new">
  <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
  <header class="piar-head">
    <div>
      <p class="eyebrow"><?= e(t('piar.brand')) ?><?php if ($canCreate && $isTrial): ?> · <span class="piar-badge piar-badge--trial"><?= e(t('piar.trial.badge')) ?></span><?php endif; ?></p>
      <h1 class="piar-title"><?= e(t('piar.new.title')) ?></h1>
      <p class="lead"><?= e(t('piar.new.lead')) ?></p>
    </div>
  </header>

  <?php if (!$canCreate): ?>
  <div class="piar-panel piar-locked">
    <span class="piar-locked__icon" aria-hidden="true"><?= icon('puzzle') ?></span>
    <h2 class="piar-panel__title"><?= e(t('piar.new.locked_title')) ?></h2>
    <p><?= e(t($summary['ever_paid'] ? 'piar.new.locked_paid' : 'piar.new.locked_trial')) ?></p>
    <a class="btn btn--buy btn--lg" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.meter.buy')) ?></a>
  </div>
  <?php elseif (!$aiReady): ?>
  <p class="notice notice--error"><?= e(t('piar.new.unavailable')) ?></p>
  <?php else: ?>
  <div class="piar-wizard" data-piar-wizard data-label-step="<?= e(t('piar.new.step')) ?>" data-label-empty="<?= e(t('piar.review.empty')) ?>"
       data-label-edit="<?= e(t('piar.review.edit')) ?>" data-label-selected="<?= e(t('piar.f.selected')) ?>" data-label-saved="<?= e(t('piar.new.draft_saved')) ?>"
       data-label-example="<?= e(t('piar.new.example_confirm')) ?>" data-label-submitting="<?= e(t('piar.new.submitting')) ?>">
    <ol class="piar-stepper js-only" data-stepper>
      <?php foreach ($steps as $i => $key): ?>
      <li><button type="button" class="piar-stepper__btn" data-goto="<?= $i ?>"><span class="piar-stepper__n"><?= $i + 1 ?></span><span class="piar-stepper__label"><?= e(t($key)) ?></span></button></li>
      <?php endforeach; ?>
    </ol>

    <div class="piar-wizard__tools">
      <p class="piar-privacy-tip"><?= icon('eye') ?><span><?= e(t('piar.new.privacy')) ?></span></p>
      <div class="piar-wizard__tools-end js-only">
        <span class="piar-draft-status" data-draft-status aria-live="polite"></span>
        <button type="button" class="btn btn--ghost btn--sm" data-piar-example><?= icon('spark') ?><?= e(t('piar.new.example')) ?></button>
      </div>
    </div>
    <p class="notice piar-draft-banner" data-draft-banner hidden><span><?= e(t('piar.new.draft_restored')) ?></span> <button type="button" class="link-button" data-draft-discard><?= e(t('piar.new.draft_discard')) ?></button></p>

    <form class="piar-form piar-wizard__form" action="<?= e(route('piar.new')) ?>" method="post" data-piar-form>
      <?= csrf_field() ?>

      <fieldset class="piar-step" data-step="0">
        <legend class="piar-step__title"><span class="piar-step__n">1</span><?= e(t('piar.new.s1')) ?></legend>
        <p class="piar-step__lead"><?= e(t('piar.new.s1_lead')) ?></p>
        <div class="piar-grid">
          <div class="form__row piar-grid__wide">
            <label for="<?= e($fid('estudiante.nombre')) ?>"><?= e(t('piar.f.nombre')) ?></label>
            <?= $note('estudiante.nombre') ?>
            <input id="<?= e($fid('estudiante.nombre')) ?>" name="estudiante[nombre]" type="text" maxlength="60" autocomplete="off"<?= $described('estudiante.nombre') ?>>
          </div>
          <div class="form__row">
            <label for="<?= e($fid('estudiante.grado')) ?>"><?= e(t('piar.f.grado')) ?> <span class="piar-req"><?= e(t('piar.f.required')) ?></span></label>
            <select id="<?= e($fid('estudiante.grado')) ?>" name="estudiante[grado]" required<?= $described('estudiante.grado') ?>>
              <option value=""><?= e(t('piar.f.grado_choose')) ?></option>
              <?php foreach ($grades as $k => $label): ?><option value="<?= e($k) ?>"><?= e($label) ?></option><?php endforeach; ?>
            </select>
            <?= $note('estudiante.grado') ?>
          </div>
          <div class="form__row">
            <label for="<?= e($fid('estudiante.edad')) ?>"><?= e(t('piar.f.edad')) ?></label>
            <input id="<?= e($fid('estudiante.edad')) ?>" name="estudiante[edad]" type="number" min="2" max="30" inputmode="numeric"<?= $described('estudiante.edad') ?>>
            <?= $note('estudiante.edad') ?>
          </div>
          <div class="form__row">
            <label for="<?= e($fid('estudiante.sede')) ?>"><?= e(t('piar.f.sede')) ?></label>
            <input id="<?= e($fid('estudiante.sede')) ?>" name="estudiante[sede]" type="text" maxlength="120">
          </div>
          <div class="form__row">
            <label for="<?= e($fid('estudiante.jornada')) ?>"><?= e(t('piar.f.jornada')) ?></label>
            <input id="<?= e($fid('estudiante.jornada')) ?>" name="estudiante[jornada]" type="text" maxlength="40"<?= $described('estudiante.jornada') ?>>
            <?= $note('estudiante.jornada') ?>
          </div>
          <div class="form__row piar-grid__wide">
            <label for="<?= e($fid('institucion')) ?>"><?= e(t('piar.f.institucion')) ?></label>
            <input id="<?= e($fid('institucion')) ?>" name="institucion" type="text" maxlength="190" value="<?= e($profile['institution'] ?? '') ?>" data-keep<?= $described('institucion') ?>>
            <?= $note('institucion') ?>
          </div>
          <div class="form__row piar-grid__wide">
            <label for="<?= e($fid('docente')) ?>"><?= e(t('piar.f.docente')) ?></label>
            <input id="<?= e($fid('docente')) ?>" name="docente" type="text" maxlength="120" value="<?= e($customer['name'] ?? '') ?>" data-keep<?= $described('docente') ?>>
            <?= $note('docente') ?>
          </div>
          <div class="form__row">
            <label for="<?= e($fid('anio')) ?>"><?= e(t('piar.f.anio')) ?></label>
            <input id="<?= e($fid('anio')) ?>" name="anio" type="number" min="2017" max="2100" value="<?= $year ?>" inputmode="numeric"<?= $described('anio') ?>>
          </div>
          <div class="form__row">
            <label for="<?= e($fid('periodo')) ?>"><?= e(t('piar.f.periodo')) ?></label>
            <select id="<?= e($fid('periodo')) ?>" name="periodo"<?= $described('periodo') ?>>
              <?php foreach ($periods as $k => $label): ?><option value="<?= e($k) ?>"><?= e($label) ?></option><?php endforeach; ?>
            </select>
          </div>
        </div>
      </fieldset>

      <fieldset class="piar-step" data-step="1">
        <legend class="piar-step__title"><span class="piar-step__n">2</span><?= e(t('piar.new.s2')) ?></legend>
        <p class="piar-step__lead"><?= e(t('piar.new.s2_lead')) ?></p>
        <div class="piar-opts-block" data-review-group="<?= e(t('piar.f.condiciones')) ?>" data-required-group>
          <p class="piar-label"><?= e(t('piar.f.condiciones')) ?> <span class="piar-req"><?= e(t('piar.f.required')) ?></span></p>
          <?= $note('condiciones') ?>
          <?php foreach ($conditions as $gi => $group): ?>
          <details class="piar-cgroup"<?= $gi === 0 ? ' open' : '' ?>>
            <summary class="piar-cgroup__summary"><span><?= e($group['group']) ?></span><span class="piar-cgroup__count" data-count></span></summary>
            <?php if (!empty($groupNotes[$group['group']])): ?><p class="piar-cgroup__note"><?= e($groupNotes[$group['group']]) ?></p><?php endif; ?>
            <div class="piar-opts">
              <?php foreach ($group['items'] as $item): ?>
              <label class="piar-opt">
                <input type="checkbox" name="condiciones[]" value="<?= e($item['key']) ?>">
                <span class="piar-opt__body"><span class="piar-opt__label"><?= e($item['label']) ?></span><span class="piar-opt__hint"><?= e($item['hint']) ?></span></span>
              </label>
              <?php endforeach; ?>
            </div>
          </details>
          <?php endforeach; ?>
        </div>
        <div class="form__row">
          <label for="<?= e($fid('otra_condicion')) ?>"><?= e(t('piar.f.otra_condicion')) ?></label>
          <input id="<?= e($fid('otra_condicion')) ?>" name="otra_condicion" type="text" maxlength="300"<?= $described('otra_condicion') ?>>
          <?= $note('otra_condicion') ?>
        </div>
        <div class="piar-check">
          <input id="<?= e($fid('soporte_clinico')) ?>" type="checkbox" name="soporte_clinico" value="1" data-toggle-target="#pf-soporte-wrap"<?= $described('soporte_clinico') ?>>
          <label for="<?= e($fid('soporte_clinico')) ?>"><?= e(t('piar.f.soporte_clinico')) ?></label>
        </div>
        <?= $note('soporte_clinico') ?>
        <div id="pf-soporte-wrap"><?= $textarea('soporte_detalle', 'soporte_detalle', 'piar.f.soporte_detalle', 3) ?></div>
        <div class="piar-opts-block" data-review-group="<?= e(t('piar.f.nivel_apoyo')) ?>">
          <p class="piar-label"><?= e(t('piar.f.nivel_apoyo')) ?></p>
          <?= $note('nivel_apoyo') ?>
          <div class="piar-opts piar-opts--levels">
            <?php foreach ($levels as $k => $level): ?>
            <label class="piar-opt piar-opt--radio">
              <input type="radio" name="nivel_apoyo" value="<?= e($k) ?>">
              <span class="piar-opt__body"><span class="piar-opt__label"><?= e($level['label']) ?></span><span class="piar-opt__hint"><?= e($level['hint']) ?></span></span>
            </label>
            <?php endforeach; ?>
            <label class="piar-opt piar-opt--radio piar-opt--none">
              <input type="radio" name="nivel_apoyo" value="" checked>
              <span class="piar-opt__body"><span class="piar-opt__label"><?= e(t('piar.f.nivel_none')) ?></span></span>
            </label>
          </div>
        </div>
      </fieldset>

      <fieldset class="piar-step" data-step="2">
        <legend class="piar-step__title"><span class="piar-step__n">3</span><?= e(t('piar.new.s3')) ?></legend>
        <p class="piar-step__lead"><?= e(t('piar.new.s3_lead')) ?></p>
        <?= $textarea('contexto_familiar', 'contexto_familiar', 'piar.f.contexto_familiar') ?>
        <?= $textarea('contexto_social', 'contexto_social', 'piar.f.contexto_social') ?>
        <?= $textarea('contexto_escolar', 'contexto_escolar', 'piar.f.contexto_escolar') ?>
      </fieldset>

      <fieldset class="piar-step" data-step="3">
        <legend class="piar-step__title"><span class="piar-step__n">4</span><?= e(t('piar.new.s4')) ?></legend>
        <p class="piar-step__lead"><?= e(t('piar.new.s4_lead')) ?></p>
        <?= $textarea('fortalezas', 'fortalezas', 'piar.f.fortalezas', 3) ?>
        <?= $textarea('intereses', 'intereses', 'piar.f.intereses', 3) ?>
        <?= $textarea('barreras', 'barreras', 'piar.f.barreras', 4) ?>
        <h3 class="piar-step__sub"><?= e(t('piar.f.valoracion')) ?></h3>
        <div class="piar-dims-form">
          <?php foreach ($dimensions as $k => $label): $id = $fid("valoracion.$k"); ?>
          <div class="form__row">
            <label for="<?= e($id) ?>"><?= e($label) ?> <span class="piar-opt-tag"><?= e(t('piar.f.optional')) ?></span></label>
            <?= $note("valoracion.$k", $help["valoracion.$k"] ?? ($dimensionHints[$k] ?? '')) ?>
            <textarea id="<?= e($id) ?>" name="valoracion[<?= e($k) ?>]" rows="3" maxlength="3000" aria-describedby="<?= e($id) ?>-h" data-autogrow></textarea>
          </div>
          <?php endforeach; ?>
        </div>
      </fieldset>

      <fieldset class="piar-step" data-step="4">
        <legend class="piar-step__title"><span class="piar-step__n">5</span><?= e(t('piar.new.s5')) ?></legend>
        <p class="piar-step__lead"><?= e(t('piar.new.s5_lead')) ?></p>
        <div class="piar-opts-block" data-review-group="<?= e(t('piar.f.areas')) ?>">
          <p class="piar-label"><?= e(t('piar.f.areas')) ?></p>
          <?= $note('areas') ?>
          <div class="piar-pills">
            <?php foreach ($areas as $k => $label): ?>
            <label class="piar-pill"><input type="checkbox" name="areas[]" value="<?= e($k) ?>"><span><?= e($label) ?></span></label>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="piar-opts-block" data-review-group="<?= e(t('piar.f.prioridades')) ?>">
          <p class="piar-label"><?= e(t('piar.f.prioridades')) ?></p>
          <?= $note('prioridades') ?>
          <div class="piar-pills">
            <?php foreach ($priorities as $k => $label): ?>
            <label class="piar-pill"><input type="checkbox" name="prioridades[]" value="<?= e($k) ?>"><span><?= e($label) ?></span></label>
            <?php endforeach; ?>
          </div>
        </div>
        <?= $textarea('recursos_disponibles', 'recursos_disponibles', 'piar.f.recursos_disponibles', 3) ?>
        <?= $textarea('observaciones', 'observaciones', 'piar.f.observaciones', 3) ?>
      </fieldset>

      <fieldset class="piar-step piar-step--review" data-step="5">
        <legend class="piar-step__title"><span class="piar-step__n">6</span><?= e(t('piar.new.s6')) ?></legend>
        <p class="piar-step__lead"><?= e(t('piar.new.s6_lead')) ?></p>
        <div class="piar-review js-only" data-review aria-live="polite"></div>
        <noscript><p class="piar-muted"><?= e(t('piar.review.nojs')) ?></p></noscript>
        <p class="piar-usage-note"><?= icon('notice') ?><span><?= e(!empty($summary['admin']) ? t('piar.new.admin_note') : ($isTrial ? t('piar.new.trial_note') : t('piar.new.credits_note', ['n' => (int) $summary['remaining']]))) ?></span></p>
        <div class="piar-check piar-check--consent">
          <input id="pf-autorizacion" type="checkbox" name="autorizacion" value="1" required data-no-draft>
          <label for="pf-autorizacion"><?= e(t('piar.f.autorizacion')) ?></label>
        </div>
        <button class="btn btn--buy btn--lg piar-submit" type="submit" data-submit><?= icon('spark') ?><span><?= e(t($isTrial ? 'piar.new.submit_trial' : 'piar.new.submit')) ?></span></button>
        <p class="form-note"><?= e(t('piar.new.time_note')) ?></p>
      </fieldset>

      <div class="piar-wizard__nav js-only" data-nav>
        <button type="button" class="btn btn--ghost" data-prev><?= icon('chevron-left') ?><?= e(t('piar.new.prev')) ?></button>
        <span class="piar-wizard__count" data-count-label></span>
        <button type="button" class="btn btn--primary" data-next><?= e(t('piar.new.next')) ?><?= icon('chevron-right') ?></button>
      </div>
    </form>
  </div>
  <script type="application/json" data-piar-example-json><?= json_encode($example, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
  <?= View::render('partials/piar/progress', ['overlay' => true]) ?>
  <?php endif; ?>
</section>
