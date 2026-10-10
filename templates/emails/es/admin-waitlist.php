<?php
/** @var array $product @var string $productUrl @var string $email @var string $locale @var int $count */
$subject = "Lista de espera: {$product['title']} ($count)";
?>
<p>Alguien se apuntó a la lista de espera.</p>
<ul>
  <li>Producto: <a href="<?= e($productUrl) ?>"><?= e($product['title']) ?></a></li>
  <li>Correo: <?= e($email) ?></li>
  <li>Idioma: <?= e($locale) ?></li>
  <li>Personas esperando este producto: <?= (int) $count ?></li>
</ul>
<p>Cuando el producto quede a la venta (estado "A la venta" y archivo subido), el sitio les escribe a todos automáticamente.</p>
