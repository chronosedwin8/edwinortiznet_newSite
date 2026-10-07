<?php /** Barra de la aplicación. @var array|null $customer @var string $active */ ?>
<div class="ex-bar">
  <div class="wrap ex-bar__inner">
    <a class="ex-bar__brand" href="<?= e(route('examenes')) ?>"><span class="ex-bar__mark" aria-hidden="true"><?= icon('list-ol') ?></span><?= e(t('examenes.brand')) ?></a>
    <?php if ($customer): ?>
    <nav class="ex-bar__nav" aria-label="<?= e(t('examenes.nav.label')) ?>">
      <a href="<?= e(route('examenes')) ?>"<?= $active === 'home' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.home')) ?></a>
      <a href="<?= e(route('examenes.new')) ?>"<?= $active === 'new' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.new')) ?></a>
      <a href="<?= e(route('examenes.demo')) ?>"<?= $active === 'demo' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.demo')) ?></a>
      <a href="<?= e(route('examenes.plans')) ?>"<?= $active === 'plans' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.plans')) ?></a>
      <a href="<?= e(route('examenes.profile')) ?>"<?= $active === 'profile' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.profile')) ?></a>
    </nav>
    <form class="ex-bar__out" action="<?= e(route('examenes.logout')) ?>" method="post">
      <?= csrf_field() ?>
      <span class="ex-bar__email" title="<?= e($customer['email']) ?>"><?= e($customer['email']) ?></span>
      <button class="ex-bar__logout" type="submit"><?= e(t('examenes.nav.logout')) ?></button>
    </form>
    <?php else: ?>
    <nav class="ex-bar__nav" aria-label="<?= e(t('examenes.nav.label')) ?>">
      <a href="<?= e(route('tool', ['slug' => 'generador-de-examenes'], 'es')) ?>"><?= e(t('examenes.nav.about')) ?></a>
      <a href="<?= e(route('examenes.demo')) ?>"<?= $active === 'demo' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.demo')) ?></a>
      <a href="<?= e(route('examenes.plans')) ?>"<?= $active === 'plans' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.plans')) ?></a>
      <a href="<?= e(route('examenes')) ?>"<?= $active === 'home' ? ' aria-current="page"' : '' ?>><?= e(t('examenes.nav.login')) ?></a>
    </nav>
    <?php endif; ?>
  </div>
</div>
