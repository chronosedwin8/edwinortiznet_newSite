<?php
/** @var string $loginUrl @var string $name */
$subject = 'Tu enlace de acceso al Generador de exámenes';
?>
<p>Hola<?= $name !== '' ? ', ' . e($name) : '' ?>:</p>
<p>Usa este enlace para entrar al <strong>Generador de exámenes con IA</strong> en edwinortiz.net. Vale por 15 minutos y solo funciona una vez.</p>
<p><a href="<?= e($loginUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Entrar al generador</a></p>
<p>Para generar exámenes con IA necesitas un plan. Mientras tanto, puedes probar el simulador gratis.</p>
<p>Si no pediste este enlace, ignora este correo.</p>
