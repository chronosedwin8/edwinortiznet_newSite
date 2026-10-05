<?php
/** @var array $order @var array $downloads @var array $gateways @var bool $gatewayError @var array $crumbs */

$status = $order['status'];
$hasService = (bool) array_filter($order['items'], fn ($i) => in_array($i['product_type'] ?? '', ['service', 'course'], true));
?>
<section class="wrap page-narrow listing" data-order data-status-url="<?= e(route('order.status', ['token' => $order['token']])) ?>" data-status="<?= e($status) ?>">
  <?= \App\Core\View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
  <h1 class="listing__title"><?= e(t('order.title', ['ref' => $order['reference']])) ?></h1>

  <?php if ($gatewayError): ?><p class="notice notice--error" role="alert"><?= e(t('checkout.error.gateway_failed')) ?></p><?php endif; ?>

  <div class="order-status order-status--<?= e($status) ?>" role="status" aria-live="polite">
    <?php if ($status === 'pending'): ?><span class="spinner" aria-hidden="true"></span><?php endif; ?>
    <span><?= e(t("order.status.$status")) ?></span>
  </div>
  <?php if ($status === 'pending'): ?><p class="form-note"><?= e(t('order.status.pending_help')) ?></p><?php endif; ?>

  <?php if ($status === 'approved'): ?>
    <?php if ($downloads): ?>
    <h2 class="section__title"><?= e(t('order.downloads')) ?></h2>
    <ul class="download-list">
      <?php foreach ($downloads as $d): $left = max(0, (int) $d['max_downloads'] - (int) $d['downloads']); ?>
      <li>
        <span><strong><?= e($d['title']) ?></strong><br><small><?= e(t('order.download_meta', ['n' => $left, 'date' => fdate($d['expires_at'])])) ?></small></span>
        <?php if (!empty($d['storage_path'])): ?>
        <a class="btn btn--buy btn--sm" href="<?= e(route('download', ['token' => $d['token']])) ?>"><?= e(t('order.download')) ?></a>
        <?php else: ?>
        <small><?= e(t('order.download_soon')) ?></small>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <?php if ($hasService): ?><p><?= e(t('order.service_note')) ?></p><?php endif; ?>
    <p class="form-note"><?= e(t('order.email_note', ['email' => $order['email']])) ?></p>
  <?php endif; ?>

  <?php if (in_array($status, ['pending', 'declined', 'error', 'voided'], true)): ?>
  <form class="form" action="<?= e(route('order.pay', ['token' => $order['token']])) ?>" method="post">
    <?= csrf_field() ?>
    <?php if (count($gateways) > 1): ?>
    <fieldset class="gateway-options">
      <legend><?= e(t('checkout.gateway')) ?></legend>
      <?php foreach ($gateways as $g): ?>
      <label class="gateway-option"><input type="radio" name="gateway" value="<?= e($g) ?>"<?= $order['gateway'] === $g ? ' checked' : '' ?>> <span><?= e(t("checkout.gateway_$g")) ?></span></label>
      <?php endforeach; ?>
    </fieldset>
    <?php else: ?>
    <input type="hidden" name="gateway" value="<?= e($gateways[0] ?? $order['gateway']) ?>">
    <?php endif; ?>
    <button class="btn btn--primary" type="submit"><?= e(t('order.retry')) ?></button>
  </form>
  <?php endif; ?>

  <div class="summary-card" style="margin-top:24px">
    <h2><?= e(t('order.items')) ?></h2>
    <ul class="summary-list">
      <?php foreach ($order['items'] as $item): ?>
      <li><span><?= e($item['title']) ?></span> <strong><?= e(money($item['total'], $order['currency'])) ?></strong></li>
      <?php endforeach; ?>
    </ul>
    <p class="summary-total"><span><?= e(t('order.total')) ?></span> <span><?= e(money($order['total'], $order['currency'])) ?></span></p>
    <p class="form-note"><?= e(t('order.gateway', ['gateway' => t('gateway.' . $order['gateway'])])) ?></p>
  </div>
  <p class="form-note"><?= e(t('order.help')) ?></p>
</section>
