<?php /** @var string $title @var string $html */ ?>
<!doctype html>
<html lang="es-CO">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title><?= e(t('admin.preview')) ?></title>
<style><?= \App\Services\Seo\Assets::criticalCss() ?></style>
<link rel="stylesheet" href="<?= e(asset('css/main.css')) ?>">
<?php foreach (\App\Services\Content\ContentRenderer::scripts($html) as $script): ?>
<script type="module" src="<?= e(asset($script)) ?>"></script>
<?php endforeach; ?>
</head>
<body>
<main class="wrap page">
  <p class="notice notice--info"><?= e(t('admin.preview_note')) ?></p>
  <h1 class="page__title"><?= e($title) ?></h1>
  <div class="prose"><?= $html ?></div>
</main>
</body>
</html>
