<?php
/** Presentación del Generador de exámenes (/herramientas/generador-de-examenes/). @var array $crumbs @var array $faqs @var array $offers @var array $types */

use App\Core\View;
use App\Services\Examenes\ExamView as V;

$features = [
    ['spark', 'examenes.what.f1_title', 'examenes.what.f1_text'],
    ['layers', 'examenes.what.f2_title', 'examenes.what.f2_text'],
    ['code', 'examenes.what.f3_title', 'examenes.what.f3_text'],
    ['check', 'examenes.what.f4_title', 'examenes.what.f4_text'],
    ['puzzle', 'examenes.what.f5_title', 'examenes.what.f5_text'],
    ['download', 'examenes.what.f6_title', 'examenes.what.f6_text'],
];
$sample = t('examenes.latex.sample');
?>
<section class="hero hero--page ex-hero">
  <div class="hero__aurora" aria-hidden="true"><span></span><span></span><span></span></div>
  <div class="wrap">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <div class="hero__grid">
      <div class="hero__copy">
        <p class="pill"><span class="pill__dot" aria-hidden="true"></span><?= e(t('examenes.hero.pill')) ?></p>
        <h1 class="hero__title hero__title--wide"><?= e(t('examenes.hero.h1_a')) ?> <span class="text-gradient"><?= e(t('examenes.hero.h1_b')) ?></span></h1>
        <p class="hero__lead"><?= e(t('examenes.hero.lead')) ?></p>
        <div class="hero__actions">
          <a class="btn btn--buy btn--lg" href="<?= e(route('examenes.demo')) ?>"><?= e(t('examenes.hero.cta')) ?> <?= icon('arrow') ?></a>
          <a class="btn btn--glass btn--lg" href="#precios"><?= e(t('examenes.hero.secondary')) ?></a>
        </div>
        <ul class="hero__trust">
          <li><?= icon('check') ?><?= e(t('examenes.hero.trust1')) ?></li>
          <li><?= icon('check') ?><?= e(t('examenes.hero.trust2')) ?></li>
          <li><?= icon('check') ?><?= e(t('examenes.hero.trust3')) ?></li>
        </ul>
      </div>
      <div class="hero__visual" aria-hidden="true">
        <div class="ex-mock">
          <div class="ex-mock__sheet ex-mock__sheet--back"><span class="ex-mock__ver">B</span></div>
          <div class="ex-mock__sheet">
            <p class="ex-mock__top"><span><?= e(t('examenes.mock.school')) ?></span><span class="ex-mock__ver">A</span></p>
            <p class="ex-mock__title"><?= e(t('examenes.mock.title')) ?></p>
            <div class="ex-mock__q"><span>1.</span><div><?= V::text(t('examenes.mock.q1')) ?><p class="ex-mock__opts"><i>A</i><i class="is-on">B</i><i>C</i><i>D</i></p></div></div>
            <div class="ex-mock__q"><span>2.</span><div><?= V::text(t('examenes.mock.q2')) ?></div></div>
            <div class="ex-mock__grid"><?php for ($i = 0; $i < 27; $i++): ?><b class="<?= in_array($i, [4, 10, 11, 12, 13, 14, 15, 16, 22], true) ? 'on' : '' ?>"></b><?php endfor; ?></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section wrap" aria-labelledby="ex-what">
  <p class="eyebrow"><?= e(t('examenes.what.eyebrow')) ?></p>
  <h2 id="ex-what" class="section__title"><?= e(t('examenes.what.title')) ?></h2>
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

<section class="section section--tint" aria-labelledby="ex-types">
  <div class="wrap">
    <p class="eyebrow"><?= e(t('examenes.types.eyebrow')) ?></p>
    <h2 id="ex-types" class="section__title"><?= e(t('examenes.types.title')) ?></h2>
    <p class="lead"><?= e(t('examenes.types.lead')) ?></p>
    <ul class="ex-typecloud">
      <?php foreach ($types as $k => $label): ?><li><?= e($label) ?></li><?php endforeach; ?>
    </ul>
  </div>
</section>

<section class="section wrap" aria-labelledby="ex-how">
  <p class="eyebrow"><?= e(t('examenes.how.eyebrow')) ?></p>
  <h2 id="ex-how" class="section__title"><?= e(t('examenes.how.title')) ?></h2>
  <ol class="ex-steps">
    <?php foreach ([1, 2, 3, 4] as $n): ?>
    <li class="ex-steps__item reveal" style="--i: <?= $n ?>">
      <span class="ex-steps__n"><?= $n ?></span>
      <h3 class="ex-steps__title"><?= e(t("examenes.how.s{$n}_title")) ?></h3>
      <p><?= e(t("examenes.how.s{$n}_text")) ?></p>
    </li>
    <?php endforeach; ?>
  </ol>
</section>

<section class="section section--tint" aria-labelledby="ex-latex">
  <div class="wrap ex-split">
    <div>
      <p class="eyebrow"><?= e(t('examenes.latex.eyebrow')) ?></p>
      <h2 id="ex-latex" class="section__title"><?= e(t('examenes.latex.title')) ?></h2>
      <p class="lead"><?= e(t('examenes.latex.lead')) ?></p>
      <ul class="ex-checklist">
        <li><?= icon('check') ?><span><?= e(t('examenes.latex.b1')) ?></span></li>
        <li><?= icon('check') ?><span><?= e(t('examenes.latex.b2')) ?></span></li>
        <li><?= icon('check') ?><span><?= e(t('examenes.latex.b3')) ?></span></li>
      </ul>
    </div>
    <div class="ex-latex-card">
      <p class="ex-latex-card__label"><?= e(t('examenes.latex.card')) ?></p>
      <div class="ex-latex-card__q"><?= V::text($sample) ?></div>
      <div class="ex-latex-card__q"><?= V::text(t('examenes.latex.sample2')) ?></div>
    </div>
  </div>
</section>

<section class="section wrap" aria-labelledby="ex-versions">
  <div class="ex-split">
    <div>
      <p class="eyebrow"><?= e(t('examenes.versions.eyebrow')) ?></p>
      <h2 id="ex-versions" class="section__title"><?= e(t('examenes.versions.title')) ?></h2>
      <p class="lead"><?= e(t('examenes.versions.lead')) ?></p>
    </div>
    <div class="ex-modes ex-modes--static">
      <div class="ex-mode"><span class="ex-mode__body"><span class="ex-mode__title"><?= icon('layers') ?><?= e(t('examenes.mode.distintas')) ?></span><span class="ex-mode__text"><?= e(t('examenes.f.distintas_help')) ?></span></span></div>
      <div class="ex-mode"><span class="ex-mode__body"><span class="ex-mode__title"><?= icon('shuffle') ?><?= e(t('examenes.mode.barajar')) ?></span><span class="ex-mode__text"><?= e(t('examenes.f.barajar_help')) ?></span></span></div>
    </div>
  </div>
</section>

<section class="section section--tint" id="precios" aria-labelledby="ex-pricing">
  <div class="wrap">
    <p class="eyebrow"><?= e(t('examenes.pricing.eyebrow')) ?></p>
    <h2 id="ex-pricing" class="section__title"><?= e(t('examenes.pricing.title')) ?></h2>
    <p class="lead"><?= e(t('examenes.pricing.lead')) ?></p>
    <?= View::render('partials/examenes/pricing', ['offers' => $offers, 'customer' => null]) ?>
  </div>
</section>

<?php if ($faqs): ?>
<section class="section wrap page-narrow" aria-labelledby="ex-faq">
  <h2 id="ex-faq" class="section__title"><?= e(t('examenes.faq_title')) ?></h2>
  <?= View::render('partials/faq', ['faqs' => $faqs]) ?>
</section>
<?php endif; ?>

<section class="section section--flush wrap">
  <div class="ex-final">
    <h2 class="ex-final__title"><?= e(t('examenes.final.title')) ?></h2>
    <p><?= e(t('examenes.final.text')) ?></p>
    <div class="ex-actions ex-actions--center">
      <a class="btn btn--buy btn--lg" href="<?= e(route('examenes.demo')) ?>"><?= e(t('examenes.hero.cta')) ?> <?= icon('arrow') ?></a>
      <a class="btn btn--glass btn--lg" href="<?= e(route('examenes.plans')) ?>"><?= e(t('examenes.final.plans')) ?></a>
    </div>
  </div>
</section>
