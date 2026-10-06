<?php
/** @var array $product @var string $productUrl */
$subject = "It’s here: {$product['title']}";
?>
<p>Hi,</p>
<p>You asked me to let you know: <strong><?= e($product['title']) ?></strong> is now available.</p>
<p><a href="<?= e($productUrl) ?>" style="display:inline-block;background:#E8A013;color:#1d1400;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">See it now</a></p>
<p>If you have any questions before buying, reply to this email or write to me from the contact page.</p>
<p>Best,<br>Edwin Ortiz Herazo</p>
