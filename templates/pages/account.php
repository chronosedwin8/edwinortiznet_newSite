<?php /** @var array|null $customer @var array $orders @var string|null $notice @var array $crumbs */ ?>
<section class="wrap listing<?= $customer ? '' : ' page-narrow' ?>">
  <?= \App\Core\View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
  <h1 class="listing__title"><?= e(t('account.title')) ?></h1>
  <?php if ($notice): ?><p class="notice" role="status"><?= e($notice) ?></p><?php endif; ?>

  <?php if (!$customer): ?>
  <p class="lead"><?= e(t('account.lead')) ?></p>
  <form class="form" action="<?= e(route('account')) ?>" method="post">
    <?= csrf_field() ?>
    <div class="form__row">
      <label for="acc-email"><?= e(t('account.email_label')) ?></label>
      <input id="acc-email" name="email" type="email" required autocomplete="email">
    </div>
    <button class="btn btn--primary" type="submit"><?= e(t('account.send_link')) ?></button>
  </form>
  <?php else: ?>
  <p class="lead"><?= e(t('account.hello', ['email' => $customer['email']])) ?></p>
  <h2 class="section__title"><?= e(t('account.orders')) ?></h2>
  <?php if (!$orders): ?>
  <p><?= e(t('account.no_orders')) ?></p>
  <?php else: ?>
  <figure class="table-wrap">
    <table class="orders-table">
      <thead><tr><th scope="col"><?= e(t('account.col_ref')) ?></th><th scope="col"><?= e(t('account.col_date')) ?></th><th scope="col"><?= e(t('account.col_status')) ?></th><th scope="col"><?= e(t('account.col_total')) ?></th><th scope="col"><span class="visually-hidden"><?= e(t('account.view')) ?></span></th></tr></thead>
      <tbody>
      <?php foreach ($orders as $o): ?>
        <tr>
          <th scope="row"><?= e($o['reference']) ?></th>
          <td><?= e(fdate($o['created_at'], 'short')) ?></td>
          <td><?= e(t('status.' . $o['status'])) ?></td>
          <td><?= e(money($o['total'], $o['currency'])) ?></td>
          <td>
            <a href="<?= e(route('order', ['token' => $o['token']])) ?>"><?= e(t('account.view')) ?></a>
            <?php if ($o['status'] === 'approved'): ?>
            <form action="<?= e(route('account.regenerate', ['id' => (int) $o['id']])) ?>" method="post" style="display:inline">
              <?= csrf_field() ?>
              <button class="link-button" type="submit"><?= e(t('account.regenerate')) ?></button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </figure>
  <?php endif; ?>
  <form action="<?= e(route('account.logout')) ?>" method="post">
    <?= csrf_field() ?>
    <button class="btn btn--ghost btn--sm" type="submit"><?= e(t('account.logout')) ?></button>
  </form>
  <?php endif; ?>
</section>
