<?php
/** @var array $product @var string $productUrl */
$subject = "Ya está disponible: {$product['title']}";
?>
<p>Hola:</p>
<p>Me pediste que te avisara: <strong><?= e($product['title']) ?></strong> ya está disponible.</p>
<p><a href="<?= e($productUrl) ?>" style="display:inline-block;background:#E8A013;color:#1d1400;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Verlo ahora</a></p>
<p>Si tienes alguna pregunta antes de comprar, responde a este correo o escríbeme desde la página de contacto.</p>
<p>Un abrazo,<br>Edwin Ortiz Herazo</p>
