<?php
/**
 * Secciones del PIAR. $mode: "web" (tarjetas adaptables) o "pdf" (tablas para dompdf).
 * @var array $output @var array $sections @var string $mode
 */

use App\Services\Piar\PiarCatalog;
use App\Services\Piar\PiarView as V;

$pdf = ($mode ?? 'web') === 'pdf';
$groups = static function (array $data, string $prefix) use ($pdf): string {
    $html = '';
    foreach ($data as $k => $items) {
        if (!$items) {
            continue;
        }
        $html .= '<div class="piar-group"><h4 class="piar-group__title">' . e(t("$prefix.$k")) . '</h4>' . V::list($items) . '</div>';
    }
    return $html !== '' ? '<div class="piar-groups">' . $html . '</div>' : '';
};
?>
<?php foreach ($sections as $n => $section):
    $key = $section['key'];
    $value = $output[$key] ?? null;
    $filled = V::filled($value);
?>
<section class="piar-section" id="sec-<?= e($key) ?>">
  <h2 class="piar-section__title"><?= e($section['title']) ?></h2>
  <?php if (!empty($section['intro'])): ?><p class="piar-section__intro"><?= e($section['intro']) ?></p><?php endif; ?>
  <?php if (!$filled): ?>
  <p class="piar-empty"><?= e(t('piar.plan.empty')) ?></p>
  <?php elseif ($key === 'contexto'): ?>
    <?php foreach (['familiar', 'social', 'escolar'] as $k): if (trim((string) ($value[$k] ?? '')) === '') { continue; } ?>
    <h3 class="piar-sub"><?= e(t("piar.ctx.$k")) ?></h3>
    <?= V::paragraphs($value[$k]) ?>
    <?php endforeach; ?>
  <?php elseif ($key === 'valoracion_pedagogica'): ?>
    <?php if ($pdf): ?>
    <table class="t-dims">
      <?php foreach (PiarCatalog::dimensions() as $k => $label): if (trim((string) ($value[$k] ?? '')) === '') { continue; } ?>
      <tr><th scope="row"><?= e($label) ?></th><td><?= V::paragraphs($value[$k]) ?></td></tr>
      <?php endforeach; ?>
    </table>
    <?php else: ?>
    <div class="piar-dims">
      <?php foreach (PiarCatalog::dimensions() as $k => $label): if (trim((string) ($value[$k] ?? '')) === '') { continue; } ?>
      <div class="piar-dim piar-dim--<?= e($k) ?>"><h3 class="piar-sub"><?= e($label) ?></h3><?= V::paragraphs($value[$k]) ?></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  <?php elseif ($key === 'barreras'): ?>
    <?php if ($pdf): ?>
    <table class="t-grid">
      <thead><tr><th class="w-25"><?= e(t('piar.col.tipo')) ?></th><th><?= e(t('piar.col.descripcion')) ?></th></tr></thead>
      <tbody><?php foreach ($value as $b): ?><tr><td><strong><?= e($b['tipo']) ?></strong></td><td><?= V::text($b['descripcion']) ?></td></tr><?php endforeach; ?></tbody>
    </table>
    <?php else: ?>
    <ul class="piar-cards">
      <?php foreach ($value as $b): ?>
      <li class="piar-card"><?php if ($b['tipo'] !== ''): ?><span class="piar-tag"><?= e($b['tipo']) ?></span><?php endif; ?><p><?= V::text($b['descripcion']) ?></p></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php elseif ($key === 'objetivos'): ?>
    <?php if ($pdf): ?>
    <table class="t-grid">
      <thead><tr><th class="w-18"><?= e(t('piar.col.area')) ?></th><th><?= e(t('piar.col.objetivo')) ?></th><th><?= e(t('piar.col.meta')) ?></th><th><?= e(t('piar.col.indicador')) ?></th></tr></thead>
      <tbody><?php foreach ($value as $o): ?><tr><td><strong><?= e($o['area']) ?></strong></td><td><?= V::text($o['objetivo']) ?></td><td><?= V::text($o['meta']) ?></td><td><?= V::text($o['indicador']) ?></td></tr><?php endforeach; ?></tbody>
    </table>
    <?php else: ?>
    <ul class="piar-cards">
      <?php foreach ($value as $o): ?>
      <li class="piar-card">
        <?php if ($o['area'] !== ''): ?><span class="piar-tag"><?= e($o['area']) ?></span><?php endif; ?>
        <p class="piar-card__lead"><?= V::text($o['objetivo']) ?></p>
        <dl class="piar-dl">
          <?php if ($o['meta'] !== ''): ?><dt><?= e(t('piar.col.meta')) ?></dt><dd><?= V::text($o['meta']) ?></dd><?php endif; ?>
          <?php if ($o['indicador'] !== ''): ?><dt><?= e(t('piar.col.indicador')) ?></dt><dd><?= V::text($o['indicador']) ?></dd><?php endif; ?>
        </dl>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php elseif ($key === 'ajustes'): ?>
    <?php if ($pdf): ?>
    <table class="t-grid">
      <thead><tr><th class="w-18"><?= e(t('piar.col.area')) ?></th><th><?= e(t('piar.col.ajuste')) ?></th><th class="w-22"><?= e(t('piar.col.responsable')) ?></th></tr></thead>
      <tbody><?php foreach ($value as $a): ?>
        <tr>
          <td><strong><?= e($a['area']) ?></strong><?php if ($a['categoria'] !== ''): ?><br><span class="cat"><?= e(V::category($a['categoria'])) ?></span><?php endif; ?></td>
          <td><?= V::text($a['ajuste']) ?><?php if ($a['estrategias']): ?><div class="strat"><span class="lbl"><?= e(t('piar.col.estrategias')) ?></span><?= V::list($a['estrategias']) ?></div><?php endif; ?></td>
          <td><?= V::text($a['responsable']) ?><?php if ($a['frecuencia'] !== ''): ?><br><span class="lbl"><?= e(t('piar.col.frecuencia')) ?>:</span> <?= V::text($a['frecuencia']) ?><?php endif; ?></td>
        </tr>
      <?php endforeach; ?></tbody>
    </table>
    <?php else: ?>
    <ul class="piar-cards">
      <?php foreach ($value as $a): ?>
      <li class="piar-card">
        <p class="piar-tags"><?php if ($a['area'] !== ''): ?><span class="piar-tag"><?= e($a['area']) ?></span><?php endif; ?><?php if ($a['categoria'] !== ''): ?><span class="piar-tag piar-tag--soft"><?= e(V::category($a['categoria'])) ?></span><?php endif; ?></p>
        <p class="piar-card__lead"><?= V::text($a['ajuste']) ?></p>
        <?php if ($a['estrategias']): ?><p class="piar-card__label"><?= e(t('piar.col.estrategias')) ?></p><?= V::list($a['estrategias'], 'piar-checks') ?><?php endif; ?>
        <dl class="piar-dl piar-dl--inline">
          <?php if ($a['responsable'] !== ''): ?><div><dt><?= e(t('piar.col.responsable')) ?></dt><dd><?= V::text($a['responsable']) ?></dd></div><?php endif; ?>
          <?php if ($a['frecuencia'] !== ''): ?><div><dt><?= e(t('piar.col.frecuencia')) ?></dt><dd><?= V::text($a['frecuencia']) ?></dd></div><?php endif; ?>
        </dl>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  <?php elseif ($key === 'evaluacion'): ?>
    <?php if ($pdf): ?>
    <table class="t-grid">
      <thead><tr><th class="w-25"><?= e(t('piar.col.aspecto')) ?></th><th><?= e(t('piar.col.ajuste')) ?></th></tr></thead>
      <tbody><?php foreach ($value as $ev): ?><tr><td><strong><?= e($ev['aspecto']) ?></strong></td><td><?= V::text($ev['ajuste']) ?></td></tr><?php endforeach; ?></tbody>
    </table>
    <?php else: ?>
    <dl class="piar-pairs">
      <?php foreach ($value as $ev): ?><div><dt><?= e($ev['aspecto']) ?></dt><dd><?= V::text($ev['ajuste']) ?></dd></div><?php endforeach; ?>
    </dl>
    <?php endif; ?>
  <?php elseif ($key === 'recursos'): ?>
    <?= $groups($value, 'piar.rec') ?>
  <?php elseif ($key === 'compromisos'): ?>
    <?= $groups($value, 'piar.comp') ?>
  <?php elseif ($key === 'seguimiento'): ?>
    <?php if (trim((string) ($value['periodicidad'] ?? '')) !== ''): ?><h3 class="piar-sub"><?= e(t('piar.seg.periodicidad')) ?></h3><?= V::paragraphs($value['periodicidad']) ?><?php endif; ?>
    <?php if (!empty($value['indicadores'])): ?><h3 class="piar-sub"><?= e(t('piar.seg.indicadores')) ?></h3><?= V::list($value['indicadores']) ?><?php endif; ?>
    <?php if (!empty($value['momentos'])): ?><h3 class="piar-sub"><?= e(t('piar.seg.momentos')) ?></h3><?= V::list($value['momentos']) ?><?php endif; ?>
  <?php elseif (is_array($value)): ?>
    <?= V::list(array_values(array_filter($value, 'is_string'))) ?>
  <?php else: ?>
    <?= V::paragraphs((string) $value) ?>
  <?php endif; ?>
</section>
<?php endforeach; ?>
