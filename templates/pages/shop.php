<?php
/** @var array $products @var array $visibleIds @var int $total @var array $families @var array|null $family @var string|null $audience @var string|null $priceKey @var array $comparison @var array $crumbs */

use App\Controllers\ShopController;
use App\Core\View;
use App\Services\I18n\I18n;

$locale = I18n::locale();
$base = $family ? route('shop.family', ['slug' => $family['slug']]) : route('shop');
$link = static function (array $set) use ($base, $audience, $priceKey): string {
    $q = array_filter(['perfil' => $audience, 'precio' => $priceKey]);
    foreach ($set as $k => $v) {
        $q[$k] = $v;
    }
    $q = array_filter($q);
    return $base . ($q ? '?' . http_build_query($q) : '');
};
$audiences = $locale === 'es' ? ShopController::AUDIENCES : ['oficina', 'docente'];
?>
<section class="wrap listing shop" data-shop>
  <header class="listing__header">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="listing__title"><?= e($family ? $family['name'] : t('shop.title')) ?></h1>
    <?php if ($family && !empty($family['description_html'])): ?>
    <div class="lead prose"><?= $family['description_html'] ?></div>
    <?php else: ?>
    <p class="lead"><?= e(t('shop.lead')) ?></p>
    <?php endif; ?>
  </header>

  <form class="filters" action="<?= e($base) ?>" method="get" data-shop-filters aria-label="<?= e(t('shop.filters')) ?>">
    <fieldset class="filters__group">
      <legend><?= e(t('shop.filter_profile')) ?></legend>
      <a class="chip" href="<?= e($link(['perfil' => null])) ?>" data-filter="perfil" data-value=""<?= $audience === null ? ' aria-current="true"' : '' ?>><?= e(t('shop.all')) ?></a>
      <?php foreach ($audiences as $a): ?>
      <a class="chip" href="<?= e($link(['perfil' => $a])) ?>" data-filter="perfil" data-value="<?= e($a) ?>"<?= $audience === $a ? ' aria-current="true"' : '' ?>><?= e(t("audience.$a")) ?></a>
      <?php endforeach; ?>
    </fieldset>
    <?php if (!$family): ?>
    <fieldset class="filters__group">
      <legend><?= e(t('shop.filter_family')) ?></legend>
      <?php foreach ($families as $f): ?>
      <a class="chip" href="<?= e(route('shop.family', ['slug' => $f['slug']])) ?>" data-family-link="<?= e($f['slug']) ?>"><?= e($f['name']) ?></a>
      <?php endforeach; ?>
    </fieldset>
    <?php else: ?>
    <p class="filters__back"><a href="<?= e(route('shop')) ?>"><?= e(t('shop.all_families')) ?></a></p>
    <?php endif; ?>
    <fieldset class="filters__group">
      <legend><?= e(t('shop.filter_price')) ?></legend>
      <a class="chip" href="<?= e($link(['precio' => null])) ?>" data-filter="precio" data-value=""<?= $priceKey === null ? ' aria-current="true"' : '' ?>><?= e(t('shop.all')) ?></a>
      <?php foreach (array_keys(ShopController::PRICE_RANGES) as $key): ?>
      <a class="chip" href="<?= e($link(['precio' => $key])) ?>" data-filter="precio" data-value="<?= e($key) ?>"<?= $priceKey === $key ? ' aria-current="true"' : '' ?>><?= e(t("shop.price.$key")) ?></a>
      <?php endforeach; ?>
    </fieldset>
  </form>

  <p class="shop__count" data-shop-count role="status" aria-live="polite"
     data-label-one="<?= e(t('shop.count_one')) ?>" data-label-many="<?= e(t('shop.count_many')) ?>"><?= e(count($visibleIds) === 1 ? t('shop.count_one') : t('shop.count_many', ['n' => count($visibleIds)])) ?></p>

  <div class="product-grid" data-shop-grid>
    <?php foreach ($products as $i => $product): ?>
      <?= View::render('partials/product-card', ['product' => $product, 'rank' => $i + 1, 'eager' => $i < 2, 'hidden' => !in_array((int) $product['id'], $visibleIds, true)]) ?>
    <?php endforeach; ?>
  </div>
  <p class="shop__empty" data-shop-empty<?= $visibleIds ? ' hidden' : '' ?>><?= e(t('shop.empty')) ?></p>
</section>

<?php if ($comparison): ?>
<section class="section section--tint" aria-labelledby="compare-title">
  <div class="wrap">
    <h2 id="compare-title" class="section__title"><?= e(t('shop.compare_title')) ?></h2>
    <?php foreach ($comparison as $group): ?>
    <figure class="table-wrap compare">
      <table>
        <caption><?= e($group['family']['name']) ?></caption>
        <thead><tr><th scope="col"><?= e(t('shop.col_product')) ?></th><th scope="col"><?= e(t('shop.col_what')) ?></th><th scope="col"><?= e(t('shop.col_requires')) ?></th><th scope="col"><?= e(t('shop.col_price')) ?></th></tr></thead>
        <tbody>
          <?php foreach ($group['items'] as $p): ?>
          <tr>
            <th scope="row"><a href="<?= e(product_path($p)) ?>"><?= e($p['title']) ?></a></th>
            <td><?= e(excerpt_text($p['short_html'] ?: $p['description_html'], 90)) ?></td>
            <td><?= e(excerpt_text(strtok((string) $p['requirements'], "\n") ?: '', 70)) ?></td>
            <td class="compare__price"><?= e($locale === 'es' ? money($p['price_cop'], 'COP') : money($p['price_usd'], 'USD')) ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </figure>
    <?php endforeach; ?>
  </div>
</section>
<?php endif; ?>
