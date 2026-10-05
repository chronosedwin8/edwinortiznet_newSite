<?php /** @var array $crumbs */ ?>
<nav class="breadcrumbs" aria-label="<?= e(t('a11y.breadcrumbs')) ?>">
  <ol>
    <?php foreach ($crumbs as $i => [$name, $href]): $last = $i === count($crumbs) - 1; ?>
    <li><?php if ($last): ?><span aria-current="page"><?= e($name) ?></span><?php else: ?><a href="<?= e($href) ?>"><?= e($name) ?></a><?php endif; ?></li>
    <?php endforeach; ?>
  </ol>
</nav>
