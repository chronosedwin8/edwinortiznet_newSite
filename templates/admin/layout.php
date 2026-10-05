<?php /** @var string $content @var array|null $admin @var string|null $flash @var string $title */
$nav = [
    ['/admin/', 'admin.dashboard'],
    ['/admin/contenido/', 'admin.posts'],
    ['/admin/productos/', 'admin.products'],
    ['/admin/familias/', 'admin.families'],
    ['/admin/pedidos/', 'admin.orders'],
    ['/admin/suscriptores/', 'admin.subscribers'],
    ['/admin/redirecciones/', 'admin.redirects'],
    ['/admin/preguntas/', 'admin.questions'],
    ['/admin/ajustes/', 'admin.settings'],
];
$path = \App\Services\Seo\Meta::path();
?>
<!doctype html>
<html lang="es-CO">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e(($title ? $title . ' · ' : '') . t('admin.title')) ?></title>
<link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
<link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
<script type="module" src="<?= e(asset('js/admin.js')) ?>"></script>
</head>
<body class="admin">
<a class="skip-link" href="#admin-main"><?= e(t('a11y.skip')) ?></a>
<header class="admin-top">
  <a class="admin-brand" href="/admin/"><?= e(t('admin.title')) ?></a>
  <?php if ($admin): ?>
  <nav class="admin-nav" aria-label="<?= e(t('admin.nav')) ?>">
    <?php foreach ($nav as [$href, $key]): ?>
    <a href="<?= e($href) ?>"<?= ($href === '/admin/' ? $path === '/admin/' : str_starts_with($path, $href)) ? ' aria-current="page"' : '' ?>><?= e(t($key)) ?></a>
    <?php endforeach; ?>
  </nav>
  <div class="admin-user">
    <a href="/" target="_blank" rel="noopener"><?= e(t('admin.view_site')) ?></a>
    <form action="<?= e(route('admin.logout')) ?>" method="post"><?= csrf_field() ?><button class="link-button" type="submit"><?= e(t('admin.logout')) ?></button></form>
  </div>
  <?php endif; ?>
</header>
<main class="admin-main" id="admin-main">
  <?php if ($title): ?><h1><?= e($title) ?></h1><?php endif; ?>
  <?php if (!empty($flash)): ?><p class="flash" role="status"><?= e($flash) ?></p><?php endif; ?>
  <?= $content ?>
</main>
</body>
</html>
