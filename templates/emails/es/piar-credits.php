<?php
/** @var array $order */
$packages = \App\Services\Piar\PiarCredits::forOrder((int) $order['id']);
$total = array_sum(array_map(fn ($p) => (int) $p['credits'], $packages));
$until = $packages ? max(array_column($packages, 'expires_at')) : null;
$subject = "Tu paquete de $total PIAR está activo";
?>
<p>Hola, <?= e($order['name']) ?>:</p>
<p>¡Gracias por tu compra! Tu paquete de <strong><?= (int) $total ?> PIAR con IA</strong> está activo<?php if ($until): ?> hasta el <strong><?= e(\App\Services\I18n\I18n::date($until, 'long')) ?></strong><?php endif; ?>.</p>
<ul>
  <li>Cada PIAR queda guardado en tu cuenta: puedes verlo, editarlo y descargarlo en PDF cuando quieras.</li>
  <li>En tu perfil puedes subir el logo de la institución para que aparezca en el documento.</li>
  <li>Si compras otro paquete mientras este sigue activo, se suma uno nuevo por 30 días.</li>
</ul>
<p><a href="<?= e(url(route('piar'))) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Crear mis PIAR</a></p>
<p>Entra con este mismo correo (<?= e($order['email']) ?>). Si tienes cualquier duda, responde a este correo.</p>
<p>Un abrazo,<br>Edwin Ortiz Herazo</p>
