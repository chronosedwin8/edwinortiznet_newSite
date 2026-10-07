<?php
/**
 * Un PIAR: en preparación (progreso), fallido o terminado (documento).
 * @var array $customer @var array|null $profile @var array $plan @var bool $isTrial @var array $input @var array $output
 * @var array $sections @var array $summary @var string|null $notice @var string|null $error
 */

use App\Core\View;
use App\Services\Piar\PiarView;

$status = $plan['status'];
?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => $isTrial ? 'new' : 'home']) ?>
<?php if ($status === 'pending'): ?>
<section class="wrap piar-page">
  <?= View::render('partials/piar/progress', ['statusUrl' => route('piar.status', ['uuid' => $plan['uuid']])]) ?>
</section>
<?php elseif ($status === 'error'): ?>
<section class="wrap piar-page page-narrow">
  <div class="piar-panel piar-failed">
    <span class="piar-failed__icon" aria-hidden="true"><?= icon('notice') ?></span>
    <h1 class="piar-title piar-title--sm"><?= e(t('piar.error.title')) ?></h1>
    <p><?= e(t('piar.error.text')) ?></p>
    <a class="btn btn--primary btn--lg" href="<?= e(route('piar.new')) ?>"><?= e(t('piar.error.retry')) ?></a>
  </div>
</section>
<?php else: ?>
<div class="piar-doc-page<?= $isTrial ? ' is-trial' : '' ?>" data-piar-done>
  <?php if ($isTrial): ?>
  <div class="piar-trial-banner">
    <div class="wrap piar-trial-banner__inner">
      <span class="piar-badge piar-badge--trial"><?= e(t('piar.trial.badge')) ?></span>
      <p><?= e(t('piar.trial.banner', ['time' => (new DateTimeImmutable(($plan['purge_after'] ?? gmdate('Y-m-d H:i:s')) . ' UTC'))->setTimezone(new DateTimeZone((string) config('APP_TIMEZONE', 'America/Bogota')))->format('g:i a')])) ?></p>
      <a class="btn btn--buy btn--sm" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.trial.cta')) ?></a>
    </div>
  </div>
  <?php endif; ?>
  <section class="wrap piar-page">
    <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
    <header class="piar-doc-head">
      <div class="piar-doc-head__text">
        <p class="eyebrow"><?= e(t('piar.plan.doc_title')) ?></p>
        <h1 class="piar-title"><?= e(t('piar.plan.title_for', ['alias' => $plan['student_alias'] ?: t('piar.plan.student')])) ?></h1>
        <p class="piar-muted"><?= e(t('piar.plan.created_on', ['date' => fdate($plan['created_at'], 'long')])) ?><?= $plan['edited_at'] ? ' · ' . e(t('piar.plan.edited_on', ['date' => fdate($plan['edited_at'], 'long')])) : '' ?></p>
      </div>
      <div class="piar-doc-head__actions">
        <?php if ($isTrial): ?>
        <a class="btn btn--ghost" href="<?= e(route('piar.plans')) ?>" title="<?= e(t('piar.error.trial_locked')) ?>"><?= icon('download') ?><?= e(t('piar.plan.pdf')) ?></a>
        <?php else: ?>
        <a class="btn btn--primary" href="<?= e(route('piar.pdf', ['uuid' => $plan['uuid']])) ?>"><?= icon('download') ?><?= e(t('piar.plan.pdf')) ?></a>
        <a class="btn btn--ghost" href="<?= e(route('piar.edit', ['uuid' => $plan['uuid']])) ?>"><?= icon('file') ?><?= e(t('piar.plan.edit')) ?></a>
        <?php endif; ?>
      </div>
    </header>

    <div class="piar-doc-layout">
      <nav class="piar-toc" aria-label="<?= e(t('piar.plan.toc')) ?>">
        <p class="piar-toc__title"><?= e(t('piar.plan.toc')) ?></p>
        <ol>
          <?php foreach ($sections as $s): ?><li><a href="#sec-<?= e($s['key']) ?>"><?= e($s['title']) ?></a></li><?php endforeach; ?>
        </ol>
      </nav>
      <article class="piar-doc">
        <dl class="piar-facts">
          <?php $facts = PiarView::studentRows($plan, $input, $profile); $last = array_key_last($facts); ?>
          <?php foreach ($facts as $label => $value): ?>
          <div<?= $label === $last ? ' class="piar-facts__wide"' : '' ?>><dt><?= e($label) ?></dt><dd><?= e($value) ?></dd></div>
          <?php endforeach; ?>
        </dl>
        <p class="piar-legend"><span class="piar-validate"><?= e(\App\Services\Piar\PiarPrompt::VALIDATE_MARK) ?></span> <?= e(t('piar.plan.validate_legend')) ?></p>
        <?= View::render('partials/piar/document', ['output' => $output, 'sections' => $sections, 'mode' => 'web']) ?>
        <p class="piar-disclaimer"><?= icon('notice') ?><span><?= e(t('piar.plan.disclaimer')) ?></span></p>
      </article>
    </div>

    <?php if ($isTrial): ?>
    <div class="piar-upsell">
      <div>
        <h2 class="piar-upsell__title"><?= e(t('piar.trial.cta_title')) ?></h2>
        <p><?= e(t('piar.trial.cta_text')) ?></p>
      </div>
      <a class="btn btn--buy btn--lg" href="<?= e(route('piar.plans')) ?>"><?= e(t('piar.trial.cta')) ?></a>
    </div>
    <p class="piar-print-block"><?= e(t('piar.trial.print')) ?></p>
    <?php else: ?>
    <p class="piar-doc-foot"><a class="link-more" href="<?= e(route('piar')) ?>"><?= e(t('piar.plan.back')) ?></a> <a class="link-more" href="<?= e(route('piar.new')) ?>"><?= e(t('piar.plan.new_another')) ?></a></p>
    <?php endif; ?>
  </section>
</div>
<?php endif; ?>
