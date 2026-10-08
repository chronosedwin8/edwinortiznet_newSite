<?php
/**
 * Edición del PIAR: un cuadro por sección; en las listas, un elemento por línea; las tablas, por elemento.
 * @var array $customer @var array $plan @var array $output @var array $sections @var string|null $notice @var string|null $error
 */

use App\Core\View;
use App\Services\Piar\PiarAssist;
use App\Services\Piar\PiarCatalog;

$area = static function (string $name, string $value, string $label, int $rows = 4, bool $lines = false): string {
    $id = 'pe-' . trim((string) preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-');
    return '<div class="form__row"><label for="' . e($id) . '">' . e($label) . ($lines ? ' <span class="piar-opt-tag">' . e(t('piar.edit.lines')) . '</span>' : '') . '</label>'
        . '<textarea id="' . e($id) . '" name="' . e($name) . '" rows="' . $rows . '" data-autogrow data-ai-field>' . e($value) . '</textarea></div>';
};
$lines = static fn (array $items): string => implode("\n", $items);
// Configuración del asistente "Redactar con IA" (piar.js lo monta junto a cada cuadro de texto).
$ai = [
    'url' => route('piar.assist', ['uuid' => $plan['uuid']]),
    'total' => $assistQuota['total'],
    'options' => PiarAssist::options(),
    'text' => array_map('t', [
        'button' => 'piar.assist.button', 'title' => 'piar.assist.title', 'instruction' => 'piar.assist.instruction',
        'placeholder' => 'piar.assist.placeholder', 'accion' => 'piar.assist.accion', 'tono' => 'piar.assist.tono',
        'lenguaje' => 'piar.assist.lenguaje', 'extension' => 'piar.assist.extension', 'generate' => 'piar.assist.generate',
        'working' => 'piar.assist.working', 'result' => 'piar.assist.result', 'replace' => 'piar.assist.replace',
        'append' => 'piar.assist.append', 'retry' => 'piar.assist.retry', 'discard' => 'piar.assist.discard',
        'close' => 'piar.assist.close', 'applied' => 'piar.assist.applied', 'error' => 'piar.assist.error',
        'need' => 'piar.assist.need', 'unsaved' => 'piar.assist.unsaved', 'quota' => 'piar.assist.quota',
    ]),
];
$categories = ['curricular', 'metodologico', 'evaluacion', 'tiempos', 'materiales', 'comunicacion', 'entorno', 'convivencia'];
$itemFields = [
    'barreras' => ['tipo' => 'piar.col.tipo', 'descripcion' => 'piar.col.descripcion'],
    'objetivos' => ['area' => 'piar.col.area', 'objetivo' => 'piar.col.objetivo', 'meta' => 'piar.col.meta', 'indicador' => 'piar.col.indicador'],
    'ajustes' => ['area' => 'piar.col.area', 'categoria' => 'piar.col.categoria', 'ajuste' => 'piar.col.ajuste', 'estrategias' => 'piar.col.estrategias', 'responsable' => 'piar.col.responsable', 'frecuencia' => 'piar.col.frecuencia'],
    'evaluacion' => ['aspecto' => 'piar.col.aspecto', 'ajuste' => 'piar.col.ajuste'],
];
?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap piar-page piar-edit">
  <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
  <header class="piar-head">
    <div>
      <p class="eyebrow"><a href="<?= e(route('piar.show', ['uuid' => $plan['uuid']])) ?>"><?= e(t('piar.plan.title_for', ['alias' => $plan['student_alias'] ?: t('piar.plan.student')])) ?></a></p>
      <h1 class="piar-title"><?= e(t('piar.edit.title')) ?></h1>
      <p class="lead"><?= e(t('piar.edit.lead')) ?></p>
    </div>
  </header>
  <p class="piar-assist-intro"><?= icon('spark') ?><span><?= e(t('piar.assist.intro')) ?> <strong data-ai-quota><?= e($assistQuota['admin'] ? t('piar.assist.admin_quota', ['hour' => PiarAssist::PER_HOUR]) : t('piar.assist.quota', ['left' => $assistQuota['left'], 'total' => $assistQuota['total']])) ?></strong></span></p>
  <form class="piar-form piar-edit__form" action="<?= e(route('piar.edit', ['uuid' => $plan['uuid']])) ?>" method="post" data-piar-assist="<?= e((string) json_encode($ai, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>">
    <?= csrf_field() ?>
    <?php foreach ($sections as $section): $key = $section['key']; $value = $output[$key] ?? null; ?>
    <fieldset class="piar-panel piar-edit__section" id="sec-<?= e($key) ?>">
      <legend class="piar-edit__legend"><?= e($section['title']) ?></legend>
      <?php if (in_array($key, ['resumen', 'observaciones'], true)): ?>
        <?= $area($key, (string) $value, $section['title'], 6) ?>
      <?php elseif (in_array($key, ['fortalezas', 'intereses', 'proyectos', 'aula_inclusiva'], true)): ?>
        <?= $area($key, $lines((array) $value), $section['title'], 5, true) ?>
      <?php elseif ($key === 'contexto'): ?>
        <?php foreach (['familiar', 'social', 'escolar'] as $k): ?><?= $area("contexto[$k]", (string) ($value[$k] ?? ''), t("piar.ctx.$k"), 4) ?><?php endforeach; ?>
      <?php elseif ($key === 'valoracion_pedagogica'): ?>
        <?php foreach (PiarCatalog::dimensions() as $k => $label): ?><?= $area("valoracion_pedagogica[$k]", (string) ($value[$k] ?? ''), $label, 4) ?><?php endforeach; ?>
      <?php elseif ($key === 'recursos'): ?>
        <div class="piar-grid"><?php foreach (['humanos', 'fisicos', 'tecnologicos', 'materiales'] as $k): ?><?= $area("recursos[$k]", $lines((array) ($value[$k] ?? [])), t("piar.rec.$k"), 4, true) ?><?php endforeach; ?></div>
      <?php elseif ($key === 'compromisos'): ?>
        <div class="piar-grid"><?php foreach (['docentes', 'familia', 'directivos', 'estudiante'] as $k): ?><?= $area("compromisos[$k]", $lines((array) ($value[$k] ?? [])), t("piar.comp.$k"), 4, true) ?><?php endforeach; ?></div>
      <?php elseif ($key === 'seguimiento'): ?>
        <?= $area('seguimiento[periodicidad]', (string) ($value['periodicidad'] ?? ''), t('piar.seg.periodicidad'), 2) ?>
        <?= $area('seguimiento[indicadores]', $lines((array) ($value['indicadores'] ?? [])), t('piar.seg.indicadores'), 4, true) ?>
        <?= $area('seguimiento[momentos]', $lines((array) ($value['momentos'] ?? [])), t('piar.seg.momentos'), 3, true) ?>
      <?php elseif (isset($itemFields[$key])): ?>
        <?php $items = array_values((array) $value); $items[] = []; ?>
        <?php foreach ($items as $i => $item): $isNew = $item === []; ?>
        <div class="piar-edit__item<?= $isNew ? ' piar-edit__item--new' : '' ?>">
          <p class="piar-edit__item-title"><?= e($isNew ? t('piar.edit.new_item') : t('piar.edit.item', ['n' => $i + 1])) ?></p>
          <div class="piar-grid">
            <?php foreach ($itemFields[$key] as $field => $labelKey): $name = "{$key}[$i][$field]"; $id = "pe-$key-$i-$field"; ?>
              <?php if ($field === 'categoria'): $current = (string) ($item[$field] ?? ''); ?>
              <div class="form__row">
                <label for="<?= e($id) ?>"><?= e(t($labelKey)) ?></label>
                <select id="<?= e($id) ?>" name="<?= e($name) ?>">
                  <option value=""></option>
                  <?php foreach ($categories as $c): ?><option value="<?= e($c) ?>"<?= $current === $c ? ' selected' : '' ?>><?= e(t("piar.cat.$c")) ?></option><?php endforeach; ?>
                  <?php if ($current !== '' && !in_array($current, $categories, true)): ?><option value="<?= e($current) ?>" selected><?= e($current) ?></option><?php endif; ?>
                </select>
              </div>
              <?php elseif ($field === 'estrategias'): ?>
              <div class="piar-grid__wide"><?= $area($name, $lines((array) ($item[$field] ?? [])), t($labelKey), 4, true) ?></div>
              <?php elseif (in_array($field, ['tipo', 'area', 'aspecto', 'responsable', 'frecuencia'], true)): ?>
              <div class="form__row">
                <label for="<?= e($id) ?>"><?= e(t($labelKey)) ?></label>
                <input id="<?= e($id) ?>" name="<?= e($name) ?>" type="text" maxlength="200" value="<?= e((string) ($item[$field] ?? '')) ?>">
              </div>
              <?php else: ?>
              <div class="piar-grid__wide"><?= $area($name, (string) ($item[$field] ?? ''), t($labelKey), 3) ?></div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </fieldset>
    <?php endforeach; ?>
    <div class="piar-save-bar">
      <a class="btn btn--ghost" href="<?= e(route('piar.show', ['uuid' => $plan['uuid']])) ?>"><?= e(t('piar.edit.cancel')) ?></a>
      <button class="btn btn--primary btn--lg" type="submit"><?= icon('check') ?><?= e(t('piar.edit.save')) ?></button>
    </div>
  </form>
</section>
