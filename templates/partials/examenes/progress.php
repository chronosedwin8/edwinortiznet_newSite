<?php
/**
 * Progreso de la generación. $overlay: capa al enviar el asistente; si no, bloque de la página del examen (consulta $statusUrl).
 * @var bool|null $overlay @var string|null $statusUrl
 */
$overlay = !empty($overlay);
$messages = array_map(fn ($i) => t("examenes.progress.m$i"), range(1, 8));
?>
<div class="ex-progress<?= $overlay ? ' ex-progress--overlay' : '' ?>"<?= $overlay ? ' data-ex-overlay hidden' : '' ?><?= !empty($statusUrl) ? ' data-status-url="' . e($statusUrl) . '"' : '' ?>
     data-messages="<?= e((string) json_encode($messages, JSON_UNESCAPED_UNICODE)) ?>" data-label-slow="<?= e(t('examenes.progress.slow')) ?>" role="status" aria-live="polite">
  <div class="ex-progress__card">
    <div class="ex-progress__sheet" aria-hidden="true"><i></i><i></i><i></i><i></i><i></i></div>
    <<?= $overlay ? 'p' : 'h1' ?> class="ex-progress__title"><?= e(t('examenes.progress.title')) ?></<?= $overlay ? 'p' : 'h1' ?>>
    <p class="ex-progress__lead"><?= e(t('examenes.progress.lead')) ?></p>
    <p class="ex-progress__msg" data-progress-msg><?= e($messages[0]) ?></p>
    <div class="ex-progress__bar" aria-hidden="true"><span data-progress-bar></span></div>
    <p class="ex-progress__time"><?= e(t('examenes.progress.elapsed')) ?> <span data-progress-time>0:00</span></p>
    <?php if (!$overlay): ?>
    <noscript><p class="ex-muted"><?= e(t('examenes.progress.nojs')) ?></p></noscript>
    <p class="ex-progress__refresh"><a class="btn btn--ghost btn--sm" href=""><?= e(t('examenes.progress.refresh')) ?></a></p>
    <?php endif; ?>
  </div>
</div>
