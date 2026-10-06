<?php
/** @var array $product @var string $productUrl */
$subject = "I’ll let you know when it’s out: {$product['title']}";
?>
<p>Hi,</p>
<p>You’re on the waiting list for <strong><?= e($product['title']) ?></strong>. As soon as it’s available I’ll email you the link to get it; there’s nothing else you need to do.</p>
<p><a href="<?= e($productUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">See the product</a></p>
<p>If this wasn’t you, just ignore this message: you’ll only get one more email, on launch day.</p>
<p>Edwin Ortiz Herazo</p>
