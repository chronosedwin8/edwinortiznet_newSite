<?php
/** @var array $sales @var array $daily @var array $pending @var int $pendingCount @var int $subscribers @var int $subscribersPending
 *  @var array $waitlist @var array $notFound @var array $missingFiles @var int $toReview @var int $seoAuto */
$max = max(1, ...array_map(fn ($d) => (int) $d['orders'], $daily ?: [['orders' => 1]]));
?>
<section class="cards">
  <article class="card">
    <h2><?= e(t('admin.dash.sales30')) ?></h2>
    <?php if (!$sales): ?><p class="big">0</p><?php endif; ?>
    <?php foreach ($sales as $s): ?>
    <p class="big"><?= e(money($s['total'], $s['currency'], 'es')) ?></p>
    <p class="muted"><?= e(t('admin.dash.orders_n', ['n' => $s['orders'], 'currency' => $s['currency']])) ?></p>
    <?php endforeach; ?>
  </article>
  <article class="card">
    <h2><?= e(t('admin.dash.pending')) ?></h2>
    <p class="big"><?= (int) $pendingCount ?></p>
    <p><a href="/admin/pedidos/?status=pending"><?= e(t('admin.dash.see_orders')) ?></a></p>
  </article>
  <article class="card">
    <h2><?= e(t('admin.dash.subscribers')) ?></h2>
    <p class="big"><?= (int) $subscribers ?></p>
    <p class="muted"><?= e(t('admin.dash.subscribers_pending', ['n' => $subscribersPending])) ?></p>
  </article>
  <article class="card">
    <h2><?= e(t('admin.dash.review')) ?></h2>
    <p class="big"><?= (int) $toReview ?></p>
    <p><a href="/admin/contenido/?review=1"><?= e(t('admin.dash.see_review')) ?></a> · <a href="/admin/contenido/?seo=1"><?= e(t('admin.dash.seo_auto', ['n' => $seoAuto])) ?></a></p>
  </article>
</section>

<?php if ($daily): ?>
<section class="panel">
  <h2><?= e(t('admin.dash.daily')) ?></h2>
  <div class="bars" role="img" aria-label="<?= e(t('admin.dash.daily')) ?>">
    <?php foreach ($daily as $d): ?>
    <span class="bar" style="height: <?= (int) round(100 * (int) $d['orders'] / $max) ?>%" title="<?= e($d['day'] . ': ' . $d['orders']) ?>"></span>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>

<div class="grid-2">
  <section class="panel">
    <h2><?= e(t('admin.dash.pending_list')) ?></h2>
    <?php if (!$pending): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <table><tbody>
      <?php foreach ($pending as $o): ?>
      <tr><td><a href="/admin/pedidos/<?= (int) $o['id'] ?>/"><?= e($o['reference']) ?></a></td><td><?= e($o['email']) ?></td><td><?= e(money($o['total'], $o['currency'], 'es')) ?></td><td><?= e($o['gateway']) ?></td></tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>
  </section>
  <section class="panel">
    <h2><?= e(t('admin.dash.not_found')) ?></h2>
    <?php if (!$notFound): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <table><tbody>
      <?php foreach ($notFound as $nf): ?>
      <tr><td><code><?= e($nf['path']) ?></code></td><td><?= (int) $nf['hits'] ?></td><td><a href="/admin/redirecciones/?source=<?= rawurlencode($nf['path']) ?>"><?= e(t('admin.redirects.create')) ?></a></td></tr>
      <?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>
  </section>
  <section class="panel">
    <h2><?= e(t('admin.dash.missing_files')) ?></h2>
    <?php if (!$missingFiles): ?><p class="muted"><?= e(t('admin.dash.all_files')) ?></p><?php else: ?>
    <ul>
      <?php foreach ($missingFiles as $p): ?>
      <li><a href="/admin/productos/<?= (int) $p['id'] ?>/"><?= e($p['title']) ?></a> <span class="tag"><?= e($p['status']) ?></span></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
  <section class="panel">
    <h2><?= e(t('admin.dash.waitlist')) ?></h2>
    <?php if (!$waitlist): ?><p class="muted"><?= e(t('admin.none')) ?></p><?php else: ?>
    <table><tbody>
      <?php foreach ($waitlist as $w): ?><tr><td><?= e($w['title']) ?></td><td><?= (int) $w['n'] ?></td></tr><?php endforeach; ?>
    </tbody></table>
    <?php endif; ?>
  </section>
</div>
