<?php
/**
 * "¿Te sirvió este artículo?": reacciones (estilo LinkedIn) y botones para compartir.
 * Los conteos impresos aquí pueden venir de la caché de página; article.js los actualiza desde
 * /api/reacciones/{id} junto con la reacción del visitante. Sin JS, cada reacción es un botón de formulario.
 *
 * @var array $post @var array $reactions @var array $meta
 */

use App\Core\Csrf;
use App\Services\Reactions;

$postId = (int) $post['id'];
$api = '/api/reacciones/' . $postId;
$url = (string) ($meta['canonical'] ?? url(post_path($post)));
$title = (string) $post['title'];
$total = (int) $reactions['total'];
$enc = rawurlencode($url);
$encTitle = rawurlencode($title);
// Sin parámetros UTM: el sitio solo los usa en enlaces salientes, y una URL con query no se sirve desde la caché de página.
$networks = [
    'whatsapp' => ['https://wa.me/?text=' . rawurlencode($title . ' ' . $url), 'whatsapp'],
    'linkedin' => ['https://www.linkedin.com/sharing/share-offsite/?url=' . $enc, 'linkedin'],
    'facebook' => ['https://www.facebook.com/sharer/sharer.php?u=' . $enc, 'facebook'],
    'x' => ['https://x.com/intent/tweet?text=' . $encTitle . '&url=' . $enc, 'x-logo'],
    'telegram' => ['https://t.me/share/url?url=' . $enc . '&text=' . $encTitle, 'telegram'],
    'email' => ['mailto:?subject=' . $encTitle . '&body=' . rawurlencode(t('share.email_body') . "\n\n" . $title . "\n" . $url), 'mail'],
];
$totalLabel = $total === 1 ? t('rx.total_one') : t('rx.total', ['n' => number_format($total, 0, '', $post['locale'] === 'en' ? ',' : '.')]);
?>
<section class="engage" id="reacciones" aria-labelledby="engage-title">
  <div class="engage__head">
    <h2 id="engage-title" class="engage__title"><?= e(t('engage.title')) ?></h2>
    <p class="engage__text"><?= e(t('engage.text')) ?></p>
  </div>

  <div class="rx" data-rx data-rx-api="<?= e($api) ?>" data-csrf="<?= Csrf::PLACEHOLDER ?>"
       data-label-total="<?= e(t('rx.total')) ?>" data-label-total-one="<?= e(t('rx.total_one')) ?>"
       data-label-saved="<?= e(t('rx.saved')) ?>" data-label-removed="<?= e(t('rx.removed')) ?>"
       data-label-error="<?= e(t('rx.error')) ?>" data-label-remove="<?= e(t('rx.remove')) ?>">
    <form class="rx__form" method="post" action="<?= e($api) ?>" data-rx-form>
      <?= Csrf::field() ?>
      <div class="rx__actions">
        <button type="submit" name="reaction" value="like" class="rx__trigger js-only" data-rx-trigger aria-pressed="false" aria-describedby="rx-hint">
          <span class="rx__emoji" aria-hidden="true" data-rx-trigger-emoji><?= Reactions::TYPES['like'] ?></span>
          <span data-rx-trigger-label><?= e(t('rx.like')) ?></span>
        </button>
        <button type="button" class="rx__more js-only" data-rx-more aria-expanded="false" aria-controls="rx-picker" aria-label="<?= e(t('rx.picker')) ?>" title="<?= e(t('rx.picker')) ?>">
          <?= icon('chevron-down') ?>
        </button>
        <div class="rx__picker" id="rx-picker" role="group" aria-label="<?= e(t('rx.picker')) ?>" data-rx-picker>
          <?php $i = 0; foreach (Reactions::TYPES as $type => $emoji): ?>
          <button type="submit" style="--i: <?= $i++ ?>" name="reaction" value="<?= e($type) ?>" class="rx__opt" data-rx-opt="<?= e($type) ?>" data-label="<?= e(t('rx.' . $type)) ?>" aria-pressed="false">
            <span class="rx__opt-emoji" aria-hidden="true"><?= $emoji ?></span>
            <span class="rx__opt-label"><?= e(t('rx.' . $type)) ?></span>
          </button>
          <?php endforeach; ?>
        </div>
      </div>
      <p id="rx-hint" class="visually-hidden"><?= e(t('rx.hint')) ?></p>
    </form>

    <div class="rx__summary">
      <button type="button" class="rx__count" data-rx-count aria-expanded="false" aria-controls="rx-breakdown" title="<?= e(t('rx.details')) ?>"<?= $total ? '' : ' hidden' ?>>
        <span class="rx__stack" aria-hidden="true" data-rx-stack><?php foreach ($reactions['top'] as $type): ?><span><?= Reactions::TYPES[$type] ?></span><?php endforeach; ?></span>
        <span data-rx-total><?= e($totalLabel) ?></span>
      </button>
      <span class="rx__none" data-rx-none<?= $total ? ' hidden' : '' ?>><?= e(t('rx.none')) ?></span>
      <ul class="rx__breakdown" id="rx-breakdown" data-rx-breakdown hidden>
        <?php foreach (Reactions::TYPES as $type => $emoji): ?>
        <li data-rx-row="<?= e($type) ?>"<?= $reactions['counts'][$type] ? '' : ' hidden' ?>>
          <span class="rx__breakdown-emoji" aria-hidden="true"><?= $emoji ?></span>
          <span><?= e(t('rx.' . $type)) ?></span>
          <strong data-rx-n><?= (int) $reactions['counts'][$type] ?></strong>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
    <p class="visually-hidden" role="status" aria-live="polite" data-rx-status></p>
  </div>

  <div class="share" id="compartir">
    <h3 class="share__title"><?= e(t('share.title')) ?></h3>
    <ul class="share__list" aria-label="<?= e(t('share.label')) ?>">
      <li data-share-native-item hidden>
        <button type="button" class="share__btn share__btn--native" data-share-native data-url="<?= e($url) ?>" data-title="<?= e($title) ?>">
          <?= icon('share') ?><span><?= e(t('share.native')) ?></span>
        </button>
      </li>
      <?php foreach ($networks as $name => [$href, $iconName]): ?>
      <li>
        <a class="share__btn share__btn--<?= e($name) ?>" href="<?= e($href) ?>"<?= $name === 'email' ? '' : ' target="_blank" rel="noopener noreferrer"' ?>
           aria-label="<?= e(t('share.' . $name)) ?>" title="<?= e(t('share.' . $name)) ?>" data-share-net="<?= e($name) ?>">
          <?= icon($iconName, $name === 'email' ? 'icon' : 'icon icon-fill') ?>
        </a>
      </li>
      <?php endforeach; ?>
      <li class="js-only">
        <button type="button" class="share__btn share__btn--copy" data-share-copy data-url="<?= e($url) ?>"
                data-label="<?= e(t('share.copy')) ?>" data-label-done="<?= e(t('share.copied')) ?>" data-label-error="<?= e(t('share.copy_error')) ?>">
          <?= icon('copy') ?><span data-share-copy-label><?= e(t('share.copy')) ?></span>
        </button>
      </li>
    </ul>
    <p class="share__status visually-hidden" role="status" aria-live="polite" data-share-status></p>
  </div>
</section>
