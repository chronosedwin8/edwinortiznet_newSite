<?php
/** @var array $order @var string $orderUrl @var array $downloads @var string $total */
$subject = "Pago aprobado: tus descargas del pedido {$order['reference']}";
$hasService = (bool) array_filter($order['items'], fn ($i) => in_array($i['product_type'] ?? '', ['service', 'course'], true));
?>
<p>Hola, <?= e($order['name']) ?>:</p>
<p>¡Tu pago de <strong><?= e($total) ?></strong> fue aprobado! Gracias por tu compra.</p>
<?php if ($downloads): ?>
<p><strong>Tus descargas</strong> (cada enlace vale por <?= (int) \App\Services\Downloads\DownloadService::days() ?> días y <?= (int) \App\Services\Downloads\DownloadService::maxDownloads() ?> descargas):</p>
<ul>
<?php foreach ($downloads as $d): ?>
  <li><a href="<?= e(url(route('download', ['token' => $d['token']]))) ?>"><?= e($d['title']) ?><?= $d['label'] && $d['label'] !== $d['title'] ? ' — ' . e($d['label']) : '' ?></a></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php if ($hasService): ?>
<p>Para los cursos o servicios de tu pedido te escribiré a este correo para coordinar el acceso.</p>
<?php endif; ?>
<p><a href="<?= e($orderUrl) ?>" style="display:inline-block;background:#E8A013;color:#1d1400;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Ver mi pedido y descargas</a></p>
<p>Si un enlace vence, entra a «Mi cuenta» con este mismo correo y genera uno nuevo. Si tienes cualquier problema con la instalación, responde a este correo o escríbeme desde la página de contacto con la referencia <?= e($order['reference']) ?>.</p>
<p>Un abrazo,<br>Edwin Ortiz Herazo</p>
