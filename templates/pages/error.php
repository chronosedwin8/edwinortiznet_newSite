<?php /** @var int $status @var string $key */ ?>
<section class="wrap page-narrow error-page">
  <p class="eyebrow"><?= e(t('error.code', ['code' => $status])) ?></p>
  <h1><?= e(t("error.$key.title")) ?></h1>
  <p class="lead"><?= e(t("error.$key.text")) ?></p>
  <?php if ($status === 404): ?>
  <form class="search-inline" role="search" action="<?= e(route('search')) ?>" method="get">
    <label class="visually-hidden" for="err-q"><?= e(t('search.label')) ?></label>
    <input id="err-q" type="search" name="q" placeholder="<?= e(t('search.placeholder')) ?>">
    <button class="btn btn--primary" type="submit"><?= e(t('search.button')) ?></button>
  </form>
  <?php endif; ?>
  <p><a class="btn btn--ghost" href="<?= e(route('home')) ?>"><?= e(t('error.home')) ?></a></p>
</section>
