<?php
/** Medidor de uso: prueba (x/1) o paquete (usados/total y vencimiento). @var array $summary */
$paid = $summary['has_active'];
$total = $paid ? max(1, (int) $summary['credits']) : \App\Services\Piar\PiarCredits::TRIAL_LIMIT;
$used = $paid ? (int) $summary['used'] : (int) $summary['trial_used'];
$pct = (int) round(min(100, $used / $total * 100));
$left = $paid ? (int) $summary['remaining'] : (int) $summary['trial_left'];
$empty = $left === 0;
$title = t($paid ? 'piar.meter.paid_title' : 'piar.meter.trial_title');
?>
<div class="piar-meter<?= $empty ? ' piar-meter--empty' : '' ?><?= $paid ? ' piar-meter--paid' : '' ?>">
  <div class="piar-meter__head">
    <p class="piar-meter__title"><?= e($title) ?></p>
    <?php if ($paid && $summary['expires_at']): ?><p class="piar-meter__date"><?= icon('calendar') ?><span><?= e(t('piar.meter.expires', ['date' => fdate($summary['expires_at'], 'long')])) ?></span></p><?php endif; ?>
  </div>
  <p class="piar-meter__nums"><strong><?= $left ?></strong><span><?= e($paid ? t('piar.meter.paid_text', ['used' => $used, 'total' => $total]) : t('piar.meter.trial_text', ['used' => $used, 'total' => $total])) ?></span></p>
  <div class="piar-meter__bar" role="progressbar" aria-valuemin="0" aria-valuemax="<?= $total ?>" aria-valuenow="<?= $used ?>" aria-label="<?= e($title) ?>"><span style="width: <?= $pct ?>%"></span></div>
  <?php if ($paid && count($summary['packages']) > 1): ?><p class="piar-meter__note"><?= e(t('piar.meter.packages', ['n' => count($summary['packages'])])) ?></p><?php endif; ?>
  <?php if ($empty): ?>
  <p class="piar-meter__note"><?= e(t($paid ? 'piar.meter.empty' : 'piar.meter.trial_done')) ?></p>
  <a class="btn btn--buy btn--sm" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.meter.buy')) ?></a>
  <?php elseif (!$paid): ?>
  <p class="piar-meter__note"><?= e($left === 1 ? t('piar.meter.trial_left_one') : t('piar.meter.trial_left', ['n' => $left])) ?></p>
  <a class="piar-meter__link" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.meter.buy')) ?> <?= icon('arrow') ?></a>
  <?php else: ?>
  <a class="piar-meter__link" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.meter.buy_more')) ?> <?= icon('arrow') ?></a>
  <?php endif; ?>
</div>
