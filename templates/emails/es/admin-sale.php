<?php
/** @var array $order @var string $total */
$subject = "Venta aprobada {$order['reference']} — {$total}";
?>
<p>Nueva venta aprobada.</p>
<ul>
  <li>Referencia: <?= e($order['reference']) ?></li>
  <li>Total: <?= e($total) ?> (<?= e($order['currency']) ?>) por <?= e($order['gateway']) ?></li>
  <li>Cliente: <?= e($order['name']) ?> &lt;<?= e($order['email']) ?>&gt;</li>
  <li>Idioma: <?= e($order['locale']) ?></li>
</ul>
<ul>
<?php foreach ($order['items'] as $item): ?>
  <li><?= e($item['title']) ?></li>
<?php endforeach; ?>
</ul>
<p><a href="<?= e(url('/admin/pedidos/' . (int) $order['id'] . '/')) ?>">Ver en el panel</a></p>
