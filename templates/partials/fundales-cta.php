<?php /** @var string $campaign @var string|null $variant */ $variant ??= 'card'; ?>
<aside class="fundales fundales--<?= e($variant) ?>" aria-labelledby="fundales-<?= e($campaign) ?>">
  <div class="fundales__glow" aria-hidden="true"></div>
  <div class="fundales__body">
    <p class="fundales__badge"><?= icon('target') ?> <?= e(t('fundales.badge')) ?></p>
    <p class="fundales__title" id="fundales-<?= e($campaign) ?>"><?= e(t('fundales.cta_title')) ?></p>
    <p class="fundales__text"><?= e(t('fundales.cta_text')) ?></p>
    <ul class="fundales__list">
      <li><?= icon('check') ?><?= e(t('fundales.point1')) ?></li>
      <li><?= icon('check') ?><?= e(t('fundales.point2')) ?></li>
      <li><?= icon('check') ?><?= e(t('fundales.point3')) ?></li>
    </ul>
  </div>
  <div class="fundales__actions">
    <a class="btn btn--light btn--lg" href="<?= e(fundales_url($campaign)) ?>" target="_blank" rel="noopener"><?= e(t('fundales.cta_button')) ?> <?= icon('external') ?></a>
    <p class="fundales__note"><?= e(t('fundales.cta_note')) ?></p>
  </div>
</aside>
