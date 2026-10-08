<?php /** @var array $cards @var array $sections */ ?>
<section class="links wrap">
  <header class="links__head">
    <span class="links__mark" aria-hidden="true"><?= e(t('nav.brand_mark')) ?></span>
    <h1 class="links__title"><?= e(t('links.heading')) ?></h1>
    <p class="links__lead"><?= e(t('links.lead')) ?></p>
  </header>

  <nav class="links__sections" aria-label="<?= e(t('links.sections')) ?>">
    <?php foreach ($sections as [$label, $href]): ?>
    <a class="links__btn" href="<?= e($href) ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
  </nav>

  <?php if ($cards): ?>
  <h2 class="links__subtitle"><?= e(t('links.latest')) ?></h2>
  <ul class="links__list">
    <?php foreach ($cards as $i => $card): ?>
    <li>
      <a class="links__card" href="<?= e($card['url']) ?>">
        <?php if ($card['image']): ?>
        <img class="links__img" src="<?= e($card['image']) ?>"<?php if ($card['srcset']): ?> srcset="<?= e($card['srcset']) ?>" sizes="132px"<?php endif; ?> alt="" width="1200" height="630" loading="<?= $i < 2 ? 'eager' : 'lazy' ?>" decoding="async">
        <?php endif; ?>
        <span class="links__body">
          <span class="links__kicker"><?= e($card['kicker']) ?></span>
          <span class="links__name"><?= e($card['title']) ?></span>
        </span>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</section>
