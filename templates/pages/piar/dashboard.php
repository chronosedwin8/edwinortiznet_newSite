<?php
/**
 * Panel: medidor de uso, PIAR en preparación e historial (solo pagados).
 * @var array $customer @var array|null $profile @var array $summary @var array $history @var array|null $pending @var array $grades
 * @var string|null $notice @var string|null $error
 */

use App\Core\View;

$first = trim((string) strtok((string) ($customer['name'] ?? ''), ' '));
$canCreate = $summary['remaining'] > 0 || (!$summary['has_active'] && $summary['trial_left'] > 0);
?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap piar-page">
  <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
  <div class="piar-dash">
    <div class="piar-dash__main">
      <p class="eyebrow"><?= e(t('piar.brand')) ?></p>
      <h1 class="piar-title"><?= e($first !== '' ? t('piar.dash.hello', ['name' => $first]) : t('piar.dash.title')) ?></h1>
      <p class="lead"><?= e(t('piar.dash.lead')) ?></p>
      <div class="piar-actions">
        <a class="btn <?= $canCreate ? 'btn--primary' : 'btn--ghost' ?> btn--lg" href="<?= e(route('piar.new')) ?>"><?= icon('plus') ?><?= e(t('piar.dash.new')) ?></a>
        <?php if (!$canCreate): ?><a class="btn btn--buy btn--lg" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.meter.buy')) ?></a><?php endif; ?>
      </div>
      <?php if ($pending): ?>
      <p class="notice piar-pending-note"><span class="piar-spinner" aria-hidden="true"></span><span><?= e(t('piar.dash.pending')) ?> <a href="<?= e(route('piar.show', ['uuid' => $pending['uuid']])) ?>"><?= e(t('piar.dash.pending_link')) ?></a></span></p>
      <?php endif; ?>
    </div>
    <aside class="piar-dash__side">
      <?= View::render('partials/piar/meter', ['summary' => $summary]) ?>
      <?php if ($summary['has_active'] && empty($profile['logo_key'])): ?>
      <div class="piar-tip">
        <p><?= e(t('piar.dash.profile_hint')) ?></p>
        <a class="piar-meter__link" href="<?= e(route('piar.profile')) ?>"><?= e(t('piar.dash.profile_cta')) ?> <?= icon('arrow') ?></a>
      </div>
      <?php endif; ?>
    </aside>
  </div>

  <h2 class="piar-h2"><?= e(t('piar.dash.history')) ?></h2>
  <?php if (!$history): ?>
  <div class="piar-empty-state">
    <span class="piar-empty-state__icon" aria-hidden="true"><?= icon('file') ?></span>
    <p><?= e(t($summary['ever_paid'] ? 'piar.dash.empty_paid' : 'piar.dash.empty_trial')) ?></p>
  </div>
  <?php else: ?>
  <ul class="piar-history">
    <?php foreach ($history as $h): ?>
    <li class="piar-history__item">
      <a class="piar-history__link" href="<?= e(route('piar.show', ['uuid' => $h['uuid']])) ?>">
        <span class="piar-history__avatar" aria-hidden="true"><?= e(mb_strtoupper(mb_substr((string) preg_replace('/[^\p{L}\p{N}]+/u', '', (string) $h['student_alias']), 0, 2)) ?: '?') ?></span>
        <span class="piar-history__body">
          <span class="piar-history__name"><?= e($h['student_alias'] ?: t('piar.plan.student')) ?></span>
          <span class="piar-history__meta"><?= e($grades[$h['grade']] ?? '') ?> · <?= e(fdate($h['created_at'], 'short')) ?><?= $h['edited_at'] ? ' · ' . e(t('piar.dash.edited')) : '' ?></span>
        </span>
        <span class="piar-status piar-status--<?= e($h['status']) ?>"><?= e(t('piar.status.' . $h['status'])) ?></span>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</section>
