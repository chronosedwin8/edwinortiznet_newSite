<?php /** @var string $current */ ?>
<link rel="stylesheet" href="<?= e(asset('css/admin-social.css')) ?>">
<nav class="tabs" aria-label="<?= e(t('admin.social.sections')) ?>">
  <?php foreach (['queue' => ['/admin/redes/', 'admin.social.tab_queue'], 'history' => ['/admin/redes/historial/', 'admin.social.tab_history'], 'settings' => ['/admin/redes/ajustes/', 'admin.social.tab_settings']] as $key => [$href, $label]): ?>
  <a class="tab<?= $current === $key ? ' is-active' : '' ?>" href="<?= e($href) ?>"<?= $current === $key ? ' aria-current="page"' : '' ?>><?= e(t($label)) ?></a>
  <?php endforeach; ?>
</nav>
