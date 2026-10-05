<?php /** @var array $crumbs @var array $faqs @var array|null $hub */

use App\Core\View;

$features = [
    ['bolt', 'fundales.f1_title', 'fundales.f1_text'],
    ['scale', 'fundales.f2_title', 'fundales.f2_text'],
    ['chart', 'fundales.f3_title', 'fundales.f3_text'],
    ['clock', 'fundales.f4_title', 'fundales.f4_text'],
    ['spark', 'fundales.f5_title', 'fundales.f5_text'],
    ['devices', 'fundales.f6_title', 'fundales.f6_text'],
];
$roles = [
    ['fundales.r1_title', 'fundales.r1_text'],
    ['fundales.r2_title', 'fundales.r2_text'],
    ['fundales.r3_title', 'fundales.r3_text'],
    ['fundales.r4_title', 'fundales.r4_text'],
];
?>
<section class="hero hero--page">
  <div class="hero__aurora" aria-hidden="true"><span></span><span></span><span></span></div>
  <div class="wrap">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <div class="hero__grid">
      <div class="hero__copy">
        <p class="pill"><span class="pill__dot" aria-hidden="true"></span><?= e(t('fundales.eyebrow')) ?></p>
        <h1 class="hero__title hero__title--wide"><?= e(t('fundales.h1_a')) ?> <span class="text-gradient"><?= e(t('fundales.h1_b')) ?></span></h1>
        <p class="hero__lead"><?= e(t('fundales.lead')) ?></p>
        <div class="hero__actions">
          <a class="btn btn--primary btn--lg" href="<?= e(fundales_url('simulacro-hero')) ?>" target="_blank" rel="noopener"><?= e(t('fundales.cta_button')) ?> <?= icon('external') ?></a>
          <?php if ($hub): ?><a class="btn btn--glass btn--lg" href="<?= e(\App\Models\Hub::path($hub)) ?>"><?= e(t('fundales.guides')) ?></a><?php endif; ?>
        </div>
        <ul class="hero__trust">
          <li><?= icon('check') ?><?= e(t('fundales.trust1')) ?></li>
          <li><?= icon('check') ?><?= e(t('fundales.trust2')) ?></li>
          <li><?= icon('check') ?><?= e(t('fundales.trust3')) ?></li>
        </ul>
      </div>
      <div class="hero__visual" aria-hidden="true">
        <div class="mock-quiz">
          <p class="mock-quiz__top"><span><?= e(t('fundales.mock_label')) ?></span><span class="mock-quiz__timer"><?= icon('clock') ?> 01:24</span></p>
          <p class="mock-quiz__q"><?= e(t('fundales.mock_question')) ?></p>
          <p class="mock-quiz__opt"><?= e(t('fundales.mock_a')) ?></p>
          <p class="mock-quiz__opt mock-quiz__opt--ok"><?= icon('check') ?> <?= e(t('fundales.mock_b')) ?></p>
          <p class="mock-quiz__opt"><?= e(t('fundales.mock_c')) ?></p>
          <div class="mock-quiz__bar"><span></span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section wrap" aria-labelledby="fund-features">
  <p class="eyebrow"><?= e(t('fundales.features_eyebrow')) ?></p>
  <h2 id="fund-features" class="section__title"><?= e(t('fundales.features_title')) ?></h2>
  <div class="feature-grid">
    <?php foreach ($features as $i => [$ic, $title, $text]): ?>
    <article class="feature reveal" style="--i: <?= $i ?>" data-spotlight>
      <span class="feature__icon"><?= icon($ic) ?></span>
      <h3 class="feature__title"><?= e(t($title)) ?></h3>
      <p class="feature__text"><?= e(t($text)) ?></p>
    </article>
    <?php endforeach; ?>
  </div>
</section>

<section class="section section--tint" aria-labelledby="fund-roles">
  <div class="wrap">
    <p class="eyebrow"><?= e(t('fundales.roles_eyebrow')) ?></p>
    <h2 id="fund-roles" class="section__title"><?= e(t('fundales.roles_title')) ?></h2>
    <ol class="role-list">
      <?php foreach ($roles as $i => [$title, $text]): ?>
      <li class="role reveal" style="--i: <?= $i ?>"><span class="role__n"><?= $i + 1 ?></span><span><strong><?= e(t($title)) ?></strong> <?= e(t($text)) ?></span></li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="section wrap">
  <div class="prose page-narrow">
    <h2><?= e(t('fundales.how_title')) ?></h2>
    <ol>
      <li><?= e(t('fundales.how1')) ?></li>
      <li><?= e(t('fundales.how2')) ?></li>
      <li><?= e(t('fundales.how3')) ?></li>
      <li><?= e(t('fundales.how4')) ?></li>
    </ol>
    <p><?= e(t('fundales.disclaimer')) ?></p>
  </div>
</section>

<section class="wrap section--flush">
  <?= View::render('partials/fundales-cta', ['campaign' => 'simulacro-final', 'variant' => 'banner']) ?>
</section>

<?php if ($faqs): ?>
<section class="section wrap page-narrow" aria-labelledby="fund-faq">
  <h2 id="fund-faq" class="section__title"><?= e(t('faq.title')) ?></h2>
  <?= View::render('partials/faq', ['faqs' => $faqs]) ?>
</section>
<?php endif; ?>
