<?php /** @var string $current */ ?>
<link rel="stylesheet" href="<?= e(asset('css/admin-newsletter.css')) ?>">
<nav class="tabs" aria-label="<?= e(t('admin.newsletter')) ?>">
  <?php foreach (['index' => ['/admin/boletin/', 'admin.nl.tab_next'], 'history' => ['/admin/boletin/historial/', 'admin.nl.tab_history'], 'settings' => ['/admin/boletin/ajustes/', 'admin.nl.tab_settings']] as $key => [$href, $label]): ?>
  <a class="tab<?= $current === $key ? ' is-active' : '' ?>" href="<?= e($href) ?>"<?= $current === $key ? ' aria-current="page"' : '' ?>><?= e(t($label)) ?></a>
  <?php endforeach; ?>
</nav>
