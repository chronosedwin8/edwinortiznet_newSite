<?php
/** @var array $order @var string $orderUrl @var string $total */
$subject = "No se aprobó el pago del pedido {$order['reference']}";
?>
<p>Hola, <?= e($order['name']) ?>:</p>
<p>La pasarela de pago no aprobó el pago de tu pedido <strong><?= e($order['reference']) ?></strong> por <?= e($total) ?>. No se hizo ningún cobro.</p>
<p>Suele deberse a fondos insuficientes, a un límite de la tarjeta o a una validación del banco. Puedes intentarlo de nuevo con otro medio de pago:</p>
<p><a href="<?= e($orderUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Intentar de nuevo</a></p>
<p>Si el problema continúa, escríbeme y lo resolvemos.</p>
<p>Edwin Ortiz Herazo</p>
