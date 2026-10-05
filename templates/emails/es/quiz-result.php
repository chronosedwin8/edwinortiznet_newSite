<?php
/** @var int $score @var int $total @var int $percent @var string|null $confirmUrl @var string $unsubscribeUrl @var string $toolUrl */
$subject = "Tu resultado en el simulacro: $score de $total";
?>
<p>Hola:</p>
<p>Este es tu resultado en el simulacro del Concurso Docente: <strong><?= (int) $score ?> de <?= (int) $total ?></strong> respuestas correctas (<?= (int) $percent ?> %).</p>
<p>Repite el simulacro las veces que quieras: cada intento toma preguntas distintas del banco.</p>
<p><a href="<?= e($toolUrl) ?>">Hacer otro intento</a></p>
<?php if ($confirmUrl): ?>
<p>Para recibir los avisos del Concurso Docente (nuevas guías y preguntas de práctica), confirma tu suscripción:</p>
<p><a href="<?= e($confirmUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Confirmar suscripción</a></p>
<?php endif; ?>
<p>Recuerda que las fechas oficiales del concurso se publican en cnsc.gov.co.</p>
<p style="font-size:12px;color:#565e62;">¿No quieres más correos? <a href="<?= e($unsubscribeUrl) ?>">Darse de baja</a>.</p>
