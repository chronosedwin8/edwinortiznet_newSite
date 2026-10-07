<?php
/**
 * Panel: medidor de uso, examen en preparación e historial.
 * @var array $customer @var array|null $profile @var array $summary @var array $history @var array|null $pending
 * @var array $subjects @var array $grades @var string|null $notice @var string|null $error
 */

use App\Core\View;

$first = trim((string) strtok((string) ($customer['name'] ?? ''), ' '));
$canCreate = $summary['remaining'] > 0;
?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap ex-page">
  <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
  <div class="ex-dash">
    <div class="ex-dash__main">
      <p class="eyebrow"><?= e(t('examenes.brand')) ?></p>
      <h1 class="ex-title"><?= e($first !== '' ? t('examenes.dash.hello', ['name' => $first]) : t('examenes.dash.title')) ?></h1>
      <p class="lead"><?= e(t($canCreate ? 'examenes.dash.lead' : 'examenes.dash.lead_noplan')) ?></p>
      <div class="ex-actions">
        <?php if ($canCreate): ?>
        <a class="btn btn--primary btn--lg" href="<?= e(route('examenes.new')) ?>"><?= icon('plus') ?><?= e(t('examenes.dash.new')) ?></a>
        <?php else: ?>
        <a class="btn btn--buy btn--lg" href="<?= e(route('examenes.plans')) ?>"><?= e(t('examenes.meter.buy')) ?></a>
        <a class="btn btn--ghost btn--lg" href="<?= e(route('examenes.demo')) ?>"><?= icon('eye') ?><?= e(t('examenes.meter.demo')) ?></a>
        <?php endif; ?>
      </div>
      <?php if ($pending): ?>
      <p class="notice ex-pending-note"><span class="ex-spinner" aria-hidden="true"></span><span><?= e(t('examenes.dash.pending')) ?> <a href="<?= e(route('examenes.show', ['uuid' => $pending['uuid']])) ?>"><?= e(t('examenes.dash.pending_link')) ?></a></span></p>
      <?php endif; ?>
    </div>
    <aside class="ex-dash__side">
      <?= View::render('partials/examenes/meter', ['summary' => $summary]) ?>
      <?php if ($summary['ever_paid'] && empty($profile['logo_key'])): ?>
      <div class="ex-tipbox">
        <p><?= e(t('examenes.dash.profile_hint')) ?></p>
        <a class="ex-meter__link" href="<?= e(route('examenes.profile')) ?>"><?= e(t('examenes.dash.profile_cta')) ?> <?= icon('arrow') ?></a>
      </div>
      <?php endif; ?>
    </aside>
  </div>

  <h2 class="ex-h2"><?= e(t('examenes.dash.history')) ?></h2>
  <?php if (!$history): ?>
  <div class="ex-empty">
    <span class="ex-empty__icon" aria-hidden="true"><?= icon('file') ?></span>
    <p><?= e(t($summary['ever_paid'] ? 'examenes.dash.empty_paid' : 'examenes.dash.empty')) ?></p>
  </div>
  <?php else: ?>
  <ul class="ex-history">
    <?php foreach ($history as $h): ?>
    <li>
      <a class="ex-history__link" href="<?= e(route('examenes.show', ['uuid' => $h['uuid']])) ?>">
        <span class="ex-history__badge" aria-hidden="true"><?= e(mb_strtoupper(mb_substr((string) ($subjects[$h['subject']] ?? '?'), 0, 2))) ?></span>
        <span class="ex-history__body">
          <span class="ex-history__name"><?= e($h['title'] ?: t('examenes.exam.title')) ?></span>
          <span class="ex-history__meta"><?= e(implode(' · ', array_filter([
              $subjects[$h['subject']] ?? '',
              $grades[$h['grade']] ?? '',
              t((int) $h['versions'] === 1 ? 'examenes.dash.versions_one' : 'examenes.dash.versions', ['n' => (int) $h['versions']]),
              t('examenes.dash.questions', ['n' => (int) $h['questions']]),
              fdate($h['created_at'], 'short'),
          ]))) ?><?= $h['edited_at'] ? ' · ' . e(t('examenes.dash.edited')) : '' ?></span>
        </span>
        <span class="ex-status ex-status--<?= e($h['status']) ?>"><?= e(t('examenes.status.' . $h['status'])) ?></span>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</section>
