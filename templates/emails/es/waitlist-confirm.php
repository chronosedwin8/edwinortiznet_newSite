<?php
/** @var array $product @var string $productUrl */
$subject = "Te aviso cuando salga: {$product['title']}";
?>
<p>Hola:</p>
<p>Quedaste en la lista de espera de <strong><?= e($product['title']) ?></strong>. Apenas esté disponible te escribo a este correo con el enlace para conseguirlo; no tienes que hacer nada más.</p>
<p><a href="<?= e($productUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Ver el producto</a></p>
<p>Si no fuiste tú, ignora este mensaje: solo recibirás un correo más, el día del lanzamiento.</p>
<p>Edwin Ortiz Herazo</p>
