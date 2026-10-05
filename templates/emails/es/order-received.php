<?php
/** @var array $order @var string $orderUrl @var string $total */
$subject = "Recibimos tu pedido {$order['reference']}";
?>
<p>Hola, <?= e($order['name']) ?>:</p>
<p>Recibimos tu pedido <strong><?= e($order['reference']) ?></strong> por <strong><?= e($total) ?></strong>. En cuanto la pasarela confirme el pago te enviaremos los enlaces de descarga.</p>
<ul>
<?php foreach ($order['items'] as $item): ?>
  <li><?= e($item['title']) ?></li>
<?php endforeach; ?>
</ul>
<p>Puedes ver el estado del pedido en cualquier momento:</p>
<p><a href="<?= e($orderUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Ver mi pedido</a></p>
<p>Si no completaste el pago, puedes intentarlo de nuevo desde ese mismo enlace.</p>
<p>Gracias,<br>Edwin Ortiz Herazo</p>
