<?php
/** @var array $order */
$subs = \App\Services\Examenes\ExamCredits::forOrder((int) $order['id']);
$exams = array_sum(array_map(fn ($s) => (int) $s['exams'], $subs));
$until = $subs ? max(array_column($subs, 'expires_at')) : null;
$first = $subs[0] ?? null;
$subject = "Tu plan del Generador de exámenes está activo ($exams exámenes)";
?>
<p>Hola, <?= e($order['name']) ?>:</p>
<p>¡Gracias por tu compra! Tu plan del <strong>Generador de exámenes con IA</strong> está activo<?php if ($until): ?> hasta el <strong><?= e(\App\Services\I18n\I18n::date($until, 'long')) ?></strong><?php endif; ?>.</p>
<ul>
  <li><strong><?= (int) $exams ?> exámenes</strong> con IA durante 30 días.</li>
  <?php if ($first): ?>
  <li>Hasta <?= (int) $first['max_versions'] ?> versiones por examen (A, B, C…), distintas o barajadas.</li>
  <li>Hasta <?= (int) $first['max_questions'] ?> preguntas únicas por examen y <?= (int) $first['ai_extra'] ?> preguntas extra o reemplazos con IA en el editor.</li>
  <?php endif; ?>
  <li>PDF listo para imprimir con hoja de respuestas, solucionario y fórmulas LaTeX.</li>
  <li>Tus exámenes quedan en tu historial aunque el plan venza. Si compras otro plan mientras este sigue vigente, se suma.</li>
</ul>
<p><a href="<?= e(url(route('examenes'))) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Crear mi primer examen</a></p>
<p>Entra con este mismo correo (<?= e($order['email']) ?>). En tu perfil puedes subir el logo de tu institución para el encabezado. Si tienes cualquier duda, responde a este correo.</p>
<p>Un abrazo,<br>Edwin Ortiz Herazo</p>
