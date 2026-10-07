<?php /** @var array|null $customer @var string $active */ ?>
<div class="piar-bar">
  <div class="wrap piar-bar__inner">
    <a class="piar-bar__brand" href="<?= e(route('piar')) ?>"><span class="piar-bar__mark" aria-hidden="true"><?= icon('puzzle') ?></span><?= e(t('piar.brand')) ?></a>
    <?php if ($customer): ?>
    <nav class="piar-bar__nav" aria-label="<?= e(t('piar.nav.label')) ?>">
      <a href="<?= e(route('piar')) ?>"<?= $active === 'home' ? ' aria-current="page"' : '' ?>><?= e(t('piar.nav.home')) ?></a>
      <a href="<?= e(route('piar.new')) ?>"<?= $active === 'new' ? ' aria-current="page"' : '' ?>><?= e(t('piar.nav.new')) ?></a>
      <a href="<?= e(route('piar.plans')) ?>"<?= $active === 'plans' ? ' aria-current="page"' : '' ?>><?= e(t('piar.nav.plans')) ?></a>
      <a href="<?= e(route('piar.profile')) ?>"<?= $active === 'profile' ? ' aria-current="page"' : '' ?>><?= e(t('piar.nav.profile')) ?></a>
    </nav>
    <form class="piar-bar__out" action="<?= e(route('piar.logout')) ?>" method="post">
      <?= csrf_field() ?>
      <span class="piar-bar__email" title="<?= e($customer['email']) ?>"><?= e($customer['email']) ?></span>
      <button class="piar-bar__logout" type="submit"><?= e(t('piar.nav.logout')) ?></button>
    </form>
    <?php else: ?>
    <nav class="piar-bar__nav" aria-label="<?= e(t('piar.nav.label')) ?>">
      <a href="<?= e(route('tool', ['slug' => 'piar'], 'es')) ?>"><?= e(t('piar.nav.about')) ?></a>
      <a href="<?= e(route('piar.plans')) ?>"<?= $active === 'plans' ? ' aria-current="page"' : '' ?>><?= e(t('piar.nav.plans')) ?></a>
    </nav>
    <?php endif; ?>
  </div>
</div>
