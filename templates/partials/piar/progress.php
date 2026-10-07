<?php
/**
 * Progreso de la generación. $overlay: capa a pantalla completa al enviar el asistente;
 * si no, bloque de la página del PIAR en preparación (consulta $statusUrl).
 * @var bool|null $overlay @var string|null $statusUrl
 */
$overlay = !empty($overlay);
$messages = array_map(fn ($i) => t("piar.progress.m$i"), range(1, 8));
?>
<div class="piar-progress<?= $overlay ? ' piar-progress--overlay' : '' ?>"<?= $overlay ? ' data-piar-overlay hidden' : '' ?><?= !empty($statusUrl) ? ' data-status-url="' . e($statusUrl) . '"' : '' ?>
     data-messages="<?= e((string) json_encode($messages, JSON_UNESCAPED_UNICODE)) ?>" data-label-slow="<?= e(t('piar.progress.slow')) ?>" role="status" aria-live="polite">
  <div class="piar-progress__card">
    <div class="piar-progress__orb" aria-hidden="true"><span></span><span></span><span></span><?= icon('puzzle') ?></div>
    <<?= $overlay ? 'p' : 'h1' ?> class="piar-progress__title"><?= e(t('piar.progress.title')) ?></<?= $overlay ? 'p' : 'h1' ?>>
    <p class="piar-progress__lead"><?= e(t('piar.progress.lead')) ?></p>
    <p class="piar-progress__msg" data-progress-msg><?= e($messages[0]) ?></p>
    <div class="piar-progress__bar" aria-hidden="true"><span data-progress-bar></span></div>
    <p class="piar-progress__time"><?= e(t('piar.progress.elapsed')) ?> <span data-progress-time>0:00</span></p>
    <?php if (!$overlay): ?>
    <noscript><p class="piar-muted"><?= e(t('piar.progress.nojs')) ?></p></noscript>
    <p class="piar-progress__refresh"><a class="btn btn--ghost btn--sm" href=""><?= e(t('piar.progress.refresh')) ?></a></p>
    <?php endif; ?>
  </div>
</div>
