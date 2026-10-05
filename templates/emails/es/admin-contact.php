<?php
/** @var string $name @var string $email @var string $subject @var string $message @var string $locale */
$topic = $subject;
$subject = 'Contacto web: ' . ($topic !== '' ? $topic : $name);
?>
<p>Nuevo mensaje desde el formulario de contacto (<?= e($locale) ?>).</p>
<ul>
  <li>Nombre: <?= e($name) ?></li>
  <li>Correo: <?= e($email) ?></li>
  <li>Asunto: <?= e($topic) ?></li>
</ul>
<p style="white-space:pre-line;"><?= e($message) ?></p>
