<?php
/** @var string $loginUrl @var string $name */
$subject = 'Tu enlace de acceso a PIAR con IA';
?>
<p>Hola<?= $name !== '' ? ', ' . e($name) : '' ?>:</p>
<p>Usa este enlace para entrar a <strong>PIAR con IA</strong> en edwinortiz.net. Vale por 15 minutos y solo funciona una vez.</p>
<p><a href="<?= e($loginUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Entrar a PIAR con IA</a></p>
<p>Con tu cuenta puedes crear 2 PIAR de prueba gratis. Recuerda: escribe solo las iniciales del estudiante y revisa siempre el borrador con el equipo docente y la familia.</p>
<p>Si no pediste este enlace, ignora este correo.</p>
