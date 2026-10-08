<?php
/** Medidor de uso del plan; a un administrador, su aviso y los límites de sus exámenes. @var array $summary */
if (!empty($summary['admin'])): ?>
<div class="ex-meter ex-meter--admin">
  <div class="ex-meter__head"><p class="ex-meter__title"><?= icon('gear') ?><span><?= e(t('examenes.meter.admin_title')) ?></span></p></div>
  <p class="ex-meter__note"><?= e(t('examenes.meter.admin_text')) ?></p>
  <ul class="ex-meter__limits">
    <li><?= icon('layers') ?><span><?= e(t('examenes.meter.versions', ['n' => $summary['max_versions']])) ?></span></li>
    <li><?= icon('list') ?><span><?= e(t('examenes.meter.questions', ['n' => $summary['max_questions']])) ?></span></li>
    <li><?= icon('spark') ?><span><?= e(t('examenes.meter.extra', ['n' => $summary['ai_extra']])) ?></span></li>
  </ul>
</div>
<?php return; endif;
$paid = $summary['has_active'];
$total = max(1, (int) $summary['exams']);
$used = (int) $summary['used'];
$left = (int) $summary['remaining'];
$pct = $paid ? (int) round(min(100, $used / $total * 100)) : 100;
$title = t($paid ? 'examenes.meter.title' : 'examenes.meter.none_title');
?>
<div class="ex-meter<?= $left === 0 ? ' ex-meter--empty' : '' ?>">
  <div class="ex-meter__head">
    <p class="ex-meter__title"><?= e($title) ?></p>
    <?php if ($paid && $summary['expires_at']): ?><p class="ex-meter__date"><?= icon('calendar') ?><span><?= e(t('examenes.meter.expires', ['date' => fdate($summary['expires_at'], 'long')])) ?></span></p><?php endif; ?>
  </div>
  <?php if ($paid): ?>
  <p class="ex-meter__nums"><strong><?= $left ?></strong><span><?= e(t('examenes.meter.text', ['used' => $used, 'total' => $total])) ?></span></p>
  <div class="ex-meter__bar" role="progressbar" aria-valuemin="0" aria-valuemax="<?= $total ?>" aria-valuenow="<?= $used ?>" aria-label="<?= e($title) ?>"><span style="width: <?= $pct ?>%"></span></div>
  <?php if ($left > 0): ?>
  <ul class="ex-meter__limits">
    <li><?= icon('layers') ?><span><?= e(t('examenes.meter.versions', ['n' => $summary['max_versions']])) ?></span></li>
    <li><?= icon('list') ?><span><?= e(t('examenes.meter.questions', ['n' => $summary['max_questions']])) ?></span></li>
    <li><?= icon('spark') ?><span><?= e(t('examenes.meter.extra', ['n' => $summary['ai_extra']])) ?></span></li>
  </ul>
  <?php endif; ?>
  <?php if (count($summary['subscriptions']) > 1): ?><p class="ex-meter__note"><?= e(t('examenes.meter.stacked', ['n' => count($summary['subscriptions'])])) ?></p><?php endif; ?>
  <?php if ($left === 0): ?>
  <p class="ex-meter__note"><?= e(t('examenes.meter.empty')) ?></p>
  <a class="btn btn--buy btn--sm" href="<?= e(route('examenes.plans')) ?>"><?= e(t('examenes.meter.buy')) ?></a>
  <?php else: ?>
  <a class="ex-meter__link" href="<?= e(route('examenes.plans')) ?>"><?= e(t('examenes.meter.buy_more')) ?> <?= icon('arrow') ?></a>
  <?php endif; ?>
  <?php else: ?>
  <p class="ex-meter__note"><?= e(t('examenes.meter.none_text')) ?></p>
  <div class="ex-meter__actions">
    <a class="btn btn--buy btn--sm" href="<?= e(route('examenes.plans')) ?>"><?= e(t('examenes.meter.buy')) ?></a>
    <a class="btn btn--ghost btn--sm" href="<?= e(route('examenes.demo')) ?>"><?= e(t('examenes.meter.demo')) ?></a>
  </div>
  <?php endif; ?>
</div>
