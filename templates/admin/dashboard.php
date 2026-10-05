<?php
/** @var array $sales @var array $daily @var array $counts @var array $recent @var array $pending @var int $pendingCount @var int $subscribers @var int $subscribersPending
 *  @var array $waitlist @var array $notFound @var array $missingFiles @var int $toReview @var int $seoAuto @var array|null $admin */
$max = max(1, ...array_map(fn ($d) => (int) $d['orders'], $daily));
$totalOrders = array_sum(array_map(fn ($d) => (int) $d['orders'], $daily));
$name = trim((string) ($admin['name'] ?? '')) ?: t('admin.dash.you');
?>
<section class="welcome">
  <div>
    <h2><?= e(t('admin.dash.hello', ['name' => $name])) ?></h2>
    <p><?= e(t('admin.dash.hello_text')) ?></p>
  </div>
  <div class="actions" style="margin:0">
    <a class="btn" href="/admin/contenido/nuevo/"><?= icon('plus') ?><?= e(t('admin.posts.new')) ?></a>
    <a class="btn btn--glass" href="/admin/medios/"><?= icon('image') ?><?= e(t('admin.media')) ?></a>
  </div>
</section>

<section class="kpis">
  <a class="kpi" href="/admin/pedidos/?status=approved">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('chart') ?></span><?= e(t('admin.dash.sales30')) ?></span>
    <?php if (!$sales): ?><span class="kpi__value">0</span><?php endif; ?>
    <?php foreach ($sales as $s): ?>
    <span class="kpi__value"><?= e(money($s['total'], $s['currency'], 'es')) ?></span>
    <span class="kpi__sub"><?= e(t('admin.dash.orders_n', ['n' => $s['orders'], 'currency' => $s['currency']])) ?></span>
    <?php endforeach; ?>
  </a>
  <a class="kpi kpi--warn" href="/admin/pedidos/?status=pending">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('clock') ?></span><?= e(t('admin.dash.pending')) ?></span>
    <span class="kpi__value"><?= (int) $pendingCount ?></span>
    <span class="kpi__sub"><?= e(t('admin.dash.see_orders')) ?></span>
  </a>
  <a class="kpi kpi--accent" href="/admin/suscriptores/">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('users') ?></span><?= e(t('admin.dash.subscribers')) ?></span>
    <span class="kpi__value"><?= (int) $subscribers ?></span>
    <span class="kpi__sub"><?= e(t('admin.dash.subscribers_pending', ['n' => $subscribersPending])) ?></span>
  </a>
  <a class="kpi" href="/admin/contenido/?status=published&amp;type=post">
    <span class="kpi__label"><span class="kpi__icon"><?= icon('file') ?></span><?= e(t('admin.dash.content')) ?></span>
    <span class="kpi__value"><?= (int) $counts['posts'] ?></span>
    <span class="kpi__sub"><?= e(t('admin.dash.content_sub', ['drafts' => $counts['drafts'], 'products' => $counts['products'], 'media' => $counts['media']])) ?></span>
  </a>
</section>

<div class="grid-2">
  <section class="panel">
    <div class="panel__head"><h2><?= e(t('admin.dash.daily')) ?></h2><span class="tag tag--plain"><?= e(t('admin.dash.orders_total', ['n' => $totalOrders])) ?></span></div>
    <div class="chart" role="img" aria-label="<?= e(t('admin.dash.daily')) ?>">
      <?php foreach ($daily as $d): ?>
      <span class="chart__bar" style="--h: <?= (int) round(100 * (int) $d['orders'] / $max) ?>%"<?= (int) $d['orders'] === 0 ? ' data-zero' : '' ?> title="<?= e(fdate($d['day'], 'short') . ': ' . $d['orders']) ?>"></span>
      <?php endforeach; ?>
    </div>
    <div class="chart__axis"><span><?= e(fdate($daily[0]['day'], 'short')) ?></span><span><?= e(fdate($daily[count($daily) - 1]['day'], 'short')) ?></span></div>
  </section>
  <section class="panel">
    <div class="panel__head"><h2><?= e(t('admin.dash.recent')) ?></h2><a href="/admin/contenido/"><?= e(t('admin.dash.see_all')) ?></a></div>
    <ul class="list-rows">
      <?php foreach ($recent as $r): ?>
      <li><a href="/admin/contenido/<?= (int) $r['id'] ?>/"><?= e($r['title']) ?></a><span class="tag tag--<?= e($r['status']) ?>"><?= e(t('admin.status.' . $r['status'])) ?></span><small><?= e(strtoupper($r['locale'])) ?> · <?= e(fdate($r['changed'], 'short')) ?></small></li>
      <?php endforeach; ?>
    </ul>
  </section>
  <section class="panel">
    <div class="panel__head"><h2><?= e(t('admin.dash.pending_list')) ?></h2></div>
    <?php if (!$pending): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <ul class="list-rows">
      <?php foreach ($pending as $o): ?>
      <li><a href="/admin/pedidos/<?= (int) $o['id'] ?>/"><?= e($o['reference']) ?></a><small><?= e($o['email']) ?></small><small><?= e(money($o['total'], $o['currency'], 'es')) ?></small></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
  <section class="panel">
    <div class="panel__head"><h2><?= e(t('admin.dash.review')) ?></h2></div>
    <ul class="list-rows">
      <li><a href="/admin/contenido/?review=1"><?= e(t('admin.dash.see_review')) ?></a><span class="tag tag--<?= $toReview ? 'warn' : 'published' ?>"><?= (int) $toReview ?></span></li>
      <li><a href="/admin/contenido/?seo=1"><?= e(t('admin.dash.seo_auto_link')) ?></a><span class="tag tag--<?= $seoAuto ? 'warn' : 'published' ?>"><?= (int) $seoAuto ?></span></li>
    </ul>
  </section>
  <section class="panel">
    <div class="panel__head"><h2><?= e(t('admin.dash.not_found')) ?></h2></div>
    <?php if (!$notFound): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <ul class="list-rows">
      <?php foreach ($notFound as $nf): ?>
      <li><code><?= e($nf['path']) ?></code><small><?= (int) $nf['hits'] ?></small><a class="btn btn--ghost btn--small" style="flex:none" href="/admin/redirecciones/?source=<?= rawurlencode($nf['path']) ?>"><?= e(t('admin.redirects.create')) ?></a></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
  <section class="panel">
    <div class="panel__head"><h2><?= e(t('admin.dash.missing_files')) ?></h2></div>
    <?php if (!$missingFiles): ?><p class="muted"><?= e(t('admin.dash.all_files')) ?></p><?php else: ?>
    <ul class="list-rows">
      <?php foreach ($missingFiles as $p): ?>
      <li><a href="/admin/productos/<?= (int) $p['id'] ?>/"><?= e($p['title']) ?></a><span class="tag tag--<?= e($p['status']) ?>"><?= e(t('admin.pstatus.' . $p['status'])) ?></span></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
  <?php if ($waitlist): ?>
  <section class="panel">
    <div class="panel__head"><h2><?= e(t('admin.dash.waitlist')) ?></h2></div>
    <ul class="list-rows">
      <?php foreach ($waitlist as $w): ?><li><span style="flex:1"><?= e($w['title']) ?></span><span class="tag tag--plain"><?= (int) $w['n'] ?></span></li><?php endforeach; ?>
    </ul>
  </section>
  <?php endif; ?>
</div>
