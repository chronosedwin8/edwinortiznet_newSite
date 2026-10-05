<?php
/** @var array $order @var string $orderUrl @var string $total */
$subject = "We received your order {$order['reference']}";
?>
<p>Hi <?= e($order['name']) ?>,</p>
<p>We received your order <strong><?= e($order['reference']) ?></strong> for <strong><?= e($total) ?></strong>. As soon as PayPal confirms the payment we’ll send you the download links.</p>
<ul>
<?php foreach ($order['items'] as $item): ?>
  <li><?= e($item['title']) ?></li>
<?php endforeach; ?>
</ul>
<p>You can check your order status at any time:</p>
<p><a href="<?= e($orderUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">View my order</a></p>
<p>If you didn’t complete the payment, you can try again from the same link.</p>
<p>Thank you,<br>Edwin Ortiz Herazo</p>
