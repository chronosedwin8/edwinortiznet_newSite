<?php /** @var array $products @var bool|null $compact */ ?>
<div class="product-grid<?= !empty($compact) ? ' product-grid--compact' : '' ?>">
  <?php foreach ($products as $product): ?>
    <?= \App\Core\View::render('partials/product-card', ['product' => $product]) ?>
  <?php endforeach; ?>
</div>
