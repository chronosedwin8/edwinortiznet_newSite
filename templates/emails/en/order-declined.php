<?php
/** @var array $order @var string $orderUrl @var string $total */
$subject = "Payment for order {$order['reference']} was not approved";
?>
<p>Hi <?= e($order['name']) ?>,</p>
<p>PayPal did not approve the payment for your order <strong><?= e($order['reference']) ?></strong> (<?= e($total) ?>). You have not been charged.</p>
<p>You can try again from your order page:</p>
<p><a href="<?= e($orderUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Try again</a></p>
<p>If the problem continues, just reply and we’ll sort it out.</p>
<p>Edwin Ortiz Herazo</p>
