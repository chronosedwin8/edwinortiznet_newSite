<?php
/** @var array $order @var string $orderUrl @var array $downloads @var string $total */
$subject = "Payment approved: your downloads for order {$order['reference']}";
$hasService = (bool) array_filter($order['items'], fn ($i) => in_array($i['product_type'] ?? '', ['service', 'course'], true));
?>
<p>Hi <?= e($order['name']) ?>,</p>
<p>Your payment of <strong><?= e($total) ?></strong> was approved. Thank you for your purchase!</p>
<?php if ($downloads): ?>
<p><strong>Your downloads</strong> (each link is valid for <?= (int) \App\Services\Downloads\DownloadService::days() ?> days and <?= (int) \App\Services\Downloads\DownloadService::maxDownloads() ?> downloads):</p>
<ul>
<?php foreach ($downloads as $d): ?>
  <li><a href="<?= e(url(route('download', ['token' => $d['token']]))) ?>"><?= e($d['title']) ?><?= $d['label'] && $d['label'] !== $d['title'] ? ' — ' . e($d['label']) : '' ?></a></li>
<?php endforeach; ?>
</ul>
<p>Note: the template interface is in Spanish; the download includes an English quick-start guide.</p>
<?php endif; ?>
<?php if ($hasService): ?>
<p>For the courses or services in your order, I’ll email you to arrange access.</p>
<?php endif; ?>
<p><a href="<?= e($orderUrl) ?>" style="display:inline-block;background:#E8A013;color:#1d1400;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">View my order and downloads</a></p>
<p>If a link expires, sign in to “My account” with this email and generate a new one. If you have any trouble installing it, reply to this email or write to me from the contact page with reference <?= e($order['reference']) ?>.</p>
<p>Best,<br>Edwin Ortiz Herazo</p>
