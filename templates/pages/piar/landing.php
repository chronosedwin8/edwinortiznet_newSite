<?php
/** Presentación de PIAR con IA (/herramientas/piar/). @var array $crumbs @var array $faqs @var array $offers */

use App\Core\View;

$features = [
    ['chart', 'piar.what.f1_title', 'piar.what.f1_text'],
    ['scale', 'piar.what.f2_title', 'piar.what.f2_text'],
    ['target', 'piar.what.f3_title', 'piar.what.f3_text'],
    ['check', 'piar.what.f4_title', 'piar.what.f4_text'],
    ['users', 'piar.what.f5_title', 'piar.what.f5_text'],
    ['download', 'piar.what.f6_title', 'piar.what.f6_text'],
];
?>
<section class="hero hero--page piar-hero">
  <div class="hero__aurora" aria-hidden="true"><span></span><span></span><span></span></div>
  <div class="wrap">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <div class="hero__grid">
      <div class="hero__copy">
        <p class="pill"><span class="pill__dot" aria-hidden="true"></span><?= e(t('piar.hero.pill')) ?></p>
        <h1 class="hero__title hero__title--wide"><?= e(t('piar.hero.h1_a')) ?> <span class="text-gradient"><?= e(t('piar.hero.h1_b')) ?></span></h1>
        <p class="hero__lead"><?= e(t('piar.hero.lead')) ?></p>
        <div class="hero__actions">
          <a class="btn btn--buy btn--lg" href="<?= e(route('piar')) ?>"><?= e(t('piar.hero.cta')) ?> <?= icon('arrow') ?></a>
          <a class="btn btn--glass btn--lg" href="#precios"><?= e(t('piar.hero.secondary')) ?></a>
        </div>
        <ul class="hero__trust">
          <li><?= icon('check') ?><?= e(t('piar.hero.trust1')) ?></li>
          <li><?= icon('check') ?><?= e(t('piar.hero.trust2')) ?></li>
          <li><?= icon('check') ?><?= e(t('piar.hero.trust3')) ?></li>
        </ul>
      </div>
      <div class="hero__visual" aria-hidden="true">
        <div class="piar-mock">
          <p class="piar-mock__top"><span><?= icon('puzzle') ?><?= e(t('piar.mock.label')) ?></span><span class="piar-mock__ok"><?= icon('check') ?><?= e(t('piar.mock.status')) ?></span></p>
          <p class="piar-mock__student"><?= e(t('piar.mock.student')) ?></p>
          <?php foreach (['s1', 's2', 's3', 's4'] as $i => $s): ?>
          <div class="piar-mock__row" style="--i: <?= $i ?>"><span class="piar-mock__n"><?= $i + 1 ?></span><span class="piar-mock__label"><?= e(t("piar.mock.$s")) ?></span><span class="piar-mock__lines"><i></i><i></i></span></div>
          <?php endforeach; ?>
          <div class="piar-mock__bar"><span></span></div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section wrap" aria-labelledby="piar-what">
  <p class="eyebrow"><?= e(t('piar.what.eyebrow')) ?></p>
  <h2 id="piar-what" class="section__title"><?= e(t('piar.what.title')) ?></h2>
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

<section class="section section--tint" aria-labelledby="piar-how">
  <div class="wrap">
    <p class="eyebrow"><?= e(t('piar.how.eyebrow')) ?></p>
    <h2 id="piar-how" class="section__title"><?= e(t('piar.how.title')) ?></h2>
    <ol class="piar-steps">
      <?php foreach ([1, 2, 3] as $n): ?>
      <li class="piar-steps__item reveal" style="--i: <?= $n ?>">
        <span class="piar-steps__n"><?= $n ?></span>
        <h3 class="piar-steps__title"><?= e(t("piar.how.s{$n}_title")) ?></h3>
        <p><?= e(t("piar.how.s{$n}_text")) ?></p>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section class="section wrap" aria-labelledby="piar-must">
  <div class="piar-split">
    <div>
      <p class="eyebrow"><?= e(t('piar.must.eyebrow')) ?></p>
      <h2 id="piar-must" class="section__title"><?= e(t('piar.must.title')) ?></h2>
      <p class="lead"><?= e(t('piar.must.lead')) ?></p>
      <p class="piar-muted"><?= e(t('piar.must.note')) ?></p>
    </div>
    <ol class="piar-must">
      <?php for ($i = 1; $i <= 9; $i++): ?>
      <li><?= e(t("piar.must.i$i")) ?></li>
      <?php endfor; ?>
    </ol>
  </div>
</section>

<section class="section section--tint" id="precios" aria-labelledby="piar-pricing">
  <div class="wrap">
    <p class="eyebrow"><?= e(t('piar.pricing.eyebrow')) ?></p>
    <h2 id="piar-pricing" class="section__title"><?= e(t('piar.pricing.title')) ?></h2>
    <p class="lead"><?= e(t('piar.pricing.lead')) ?></p>
    <?= View::render('partials/piar/pricing', ['offers' => $offers, 'showTrial' => true, 'customer' => null]) ?>
  </div>
</section>

<section class="section wrap" aria-labelledby="piar-privacy">
  <div class="piar-privacy">
    <span class="piar-privacy__icon" aria-hidden="true"><?= icon('eye') ?></span>
    <div>
      <p class="eyebrow"><?= e(t('piar.privacy.eyebrow')) ?></p>
      <h2 id="piar-privacy" class="piar-privacy__title"><?= e(t('piar.privacy.title')) ?></h2>
      <p><?= e(t('piar.privacy.p1')) ?></p>
      <p><?= e(t('piar.privacy.p2')) ?></p>
      <p><?= e(t('piar.privacy.p3')) ?></p>
    </div>
  </div>
</section>

<?php if ($faqs): ?>
<section class="section wrap page-narrow" aria-labelledby="piar-faq">
  <h2 id="piar-faq" class="section__title"><?= e(t('piar.faq_title')) ?></h2>
  <?= View::render('partials/faq', ['faqs' => $faqs]) ?>
</section>
<?php endif; ?>

<section class="section section--flush wrap">
  <div class="piar-final">
    <h2 class="piar-final__title"><?= e(t('piar.final.title')) ?></h2>
    <p><?= e(t('piar.final.text')) ?></p>
    <a class="btn btn--buy btn--lg" href="<?= e(route('piar')) ?>"><?= e(t('piar.hero.cta')) ?> <?= icon('arrow') ?></a>
  </div>
</section>
