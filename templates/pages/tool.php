<?php
/** @var array $tool @var string $key @var array|null $product @var array $faqs @var array $crumbs */

use App\Core\View;
use App\Services\I18n\I18n;

?>
<section class="tool wrap">
  <header class="tool__header">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <p class="eyebrow"><?= e(t('tools.free_tool')) ?></p>
    <h1 class="tool__title"><?= e(t("tool.$key.h1")) ?></h1>
    <p class="lead"><?= e(t("tool.$key.intro")) ?></p>
  </header>

  <noscript><p class="notice"><?= e(t('tools.needs_js')) ?></p></noscript>
  <div class="tool__app">
    <?= View::render("partials/tools/$key") ?>
  </div>
  <p class="tool__privacy"><?= e(t('tools.privacy_note')) ?></p>
  <?php if (!empty($tool['excel'])): ?><p class="tool__excel-jump"><a class="link-more" href="#excel"><?= e(t('tools.excel.jump')) ?></a></p><?php endif; ?>
</section>

<?php if (!empty($tool['excel'])): ?>
<?= View::render('partials/excel-download', ['key' => $key, 'excel' => $tool['excel']]) ?>
<?php endif; ?>

<section class="section wrap tool__content">
  <div class="prose page-narrow">
    <h2><?= e(t("tool.$key.how_title")) ?></h2>
    <?php for ($i = 1; I18n::has("tool.$key.how_p$i"); $i++): ?>
    <p><?= e(t("tool.$key.how_p$i")) ?></p>
    <?php endfor; ?>
  </div>
  <?php if ($product): ?>
  <div class="page-narrow">
    <?= View::render('partials/product-inline', ['product' => $product]) ?>
  </div>
  <?php endif; ?>
</section>

<?php if ($faqs): ?>
<section class="section wrap page-narrow" aria-labelledby="tool-faq-title">
  <h2 id="tool-faq-title" class="section__title"><?= e(t('faq.title')) ?></h2>
  <?= View::render('partials/faq', ['faqs' => $faqs]) ?>
</section>
<?php endif; ?>
