<?php /** @var string $content @var array|null $admin @var string|null $flash @var bool $flashError @var string $title */
$groups = [
    'admin.group.content' => [
        ['/admin/', 'grid', 'admin.dashboard'],
        ['/admin/contenido/', 'file', 'admin.posts'],
        ['/admin/secciones/', 'layers', 'admin.hubs'],
        ['/admin/medios/', 'image', 'admin.media'],
        ['/admin/redes/', 'share', 'admin.social'],
    ],
    'admin.group.shop' => [
        ['/admin/productos/', 'box', 'admin.products'],
        ['/admin/familias/', 'tag', 'admin.families'],
        ['/admin/pedidos/', 'receipt', 'admin.orders'],
        ['/admin/piar/', 'puzzle', 'admin.piar'],
        ['/admin/examenes/', 'list-ol', 'admin.examenes'],
    ],
    'admin.group.site' => [
        ['/admin/suscriptores/', 'users', 'admin.subscribers'],
        ['/admin/redirecciones/', 'shuffle', 'admin.redirects'],
        ['/admin/ajustes/', 'gear', 'admin.settings'],
    ],
];
$path = \App\Services\Seo\Meta::path();
$isError = !empty($flashError);
?>
<!doctype html>
<html lang="es-CO">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?= e(($title ? $title . ' · ' : '') . t('admin.title')) ?></title>
<link rel="icon" href="/assets/img/favicon.svg" type="image/svg+xml">
<link rel="preload" href="/assets/fonts/plus-jakarta-sans-var.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= e(asset('css/admin.css')) ?>">
<script><?= \App\Services\Seo\SecurityHeaders::THEME_SCRIPT ?></script>
<script type="module" src="<?= e(asset('js/admin.js')) ?>"></script>
</head>
<body class="admin" data-csrf="<?= e(\App\Core\Csrf::PLACEHOLDER) ?>" data-icons="<?= e(asset('img/icons.svg')) ?>">
<a class="skip-link" href="#admin-main"><?= e(t('a11y.skip')) ?></a>
<?php if ($admin): ?>
<aside class="side" id="admin-side" aria-label="<?= e(t('admin.nav')) ?>">
  <a class="side__brand" href="/admin/"><span class="side__mark" aria-hidden="true"><?= e(t('nav.brand_mark')) ?></span><span><?= e(t('admin.brand')) ?><small><?= e(t('admin.brand_sub')) ?></small></span></a>
  <a class="side__new" href="/admin/contenido/nuevo/"><?= icon('plus') ?><?= e(t('admin.posts.new')) ?></a>
  <nav class="side__nav">
    <?php foreach ($groups as $label => $items): ?>
    <p class="side__group"><?= e(t($label)) ?></p>
    <ul>
      <?php foreach ($items as [$href, $ic, $key]): $current = $href === '/admin/' ? $path === '/admin/' : str_starts_with($path, $href); ?>
      <li><a href="<?= e($href) ?>"<?= $current ? ' aria-current="page"' : '' ?>><?= icon($ic) ?><span><?= e(t($key)) ?></span></a></li>
      <?php endforeach; ?>
    </ul>
    <?php endforeach; ?>
  </nav>
  <div class="side__foot">
    <a href="/" target="_blank" rel="noopener"><?= icon('eye') ?><span><?= e(t('admin.view_site')) ?></span></a>
    <form action="<?= e(route('admin.logout')) ?>" method="post"><?= csrf_field() ?><button type="submit"><?= icon('logout') ?><span><?= e(t('admin.logout')) ?></span></button></form>
  </div>
</aside>
<?php endif; ?>
<div class="shell">
  <?php if ($admin): ?>
  <header class="topbar">
    <button class="icon-btn topbar__menu" type="button" data-side-toggle aria-controls="admin-side" aria-expanded="false" aria-label="<?= e(t('admin.menu')) ?>"><?= icon('menu') ?></button>
    <button class="cmd-trigger" type="button" data-cmd-open><?= icon('search') ?><span><?= e(t('admin.cmd.placeholder')) ?></span><kbd><?= e(t('admin.kbd.cmd')) ?></kbd></button>
    <div class="topbar__end">
      <button class="icon-btn" type="button" data-theme-toggle aria-label="<?= e(t('theme.toggle')) ?>"><?= icon('contrast') ?></button>
      <span class="avatar" title="<?= e($admin['email']) ?>"><?= e(mb_strtoupper(mb_substr((string) ($admin['name'] ?: $admin['email']), 0, 1))) ?></span>
    </div>
  </header>
  <?php endif; ?>
  <main class="admin-main" id="admin-main">
    <?php if ($title): ?><h1 class="page-title"><?= e($title) ?></h1><?php endif; ?>
    <?= $content ?>
  </main>
</div>

<div class="toasts" aria-live="polite" data-toasts>
  <?php if (!empty($flash)): ?><p class="toast<?= $isError ? ' toast--error' : '' ?>" data-toast><?= icon($isError ? 'notice' : 'check') ?><span><?= e($flash) ?></span></p><?php endif; ?>
</div>

<?php if ($admin): ?>
<dialog class="cmd" data-cmd aria-label="<?= e(t('admin.cmd.title')) ?>">
  <div class="cmd__bar"><?= icon('search') ?><input type="search" data-cmd-input placeholder="<?= e(t('admin.cmd.placeholder')) ?>" aria-label="<?= e(t('admin.cmd.placeholder')) ?>" autocomplete="off" role="combobox" aria-expanded="true" aria-controls="cmd-list"><kbd><?= e(t('admin.kbd.esc')) ?></kbd></div>
  <div class="cmd__list" id="cmd-list" role="listbox" data-cmd-list
       data-label-actions="<?= e(t('admin.cmd.actions')) ?>" data-label-go="<?= e(t('admin.cmd.go')) ?>" data-label-empty="<?= e(t('admin.cmd.empty')) ?>" data-label-public="<?= e(t('admin.view_public')) ?>"></div>
  <script type="application/json" data-cmd-static><?= json_encode([
      ['title' => t('admin.posts.new'), 'url' => '/admin/contenido/nuevo/', 'icon' => 'plus', 'group' => 'actions'],
      ['title' => t('admin.products.new'), 'url' => '/admin/productos/nuevo/', 'icon' => 'plus', 'group' => 'actions'],
      ['title' => t('admin.media.upload'), 'url' => '/admin/medios/#subir', 'icon' => 'upload', 'group' => 'actions'],
      ['title' => t('admin.view_site'), 'url' => '/', 'icon' => 'eye', 'group' => 'actions', 'blank' => true],
      ...array_merge(...array_map(fn ($items) => array_map(fn ($i) => ['title' => t($i[2]), 'url' => $i[0], 'icon' => $i[1], 'group' => 'go'], $items), array_values($groups))),
  ], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
</dialog>
<?php endif; ?>
</body>
</html>
