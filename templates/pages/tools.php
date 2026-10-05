<?php /** @var array|null $hub @var array $tools @var array $faqs @var array $crumbs */

use App\Core\View;

?>
<section class="hub-hero">
  <div class="wrap">
    <?= View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="hub-hero__title"><?= e($hub['title'] ?? t('tools.title')) ?></h1>
    <?php if ($hub && $hub['intro_html']): ?>
    <div class="hub-hero__intro prose"><?= $hub['intro_html'] ?></div>
    <?php else: ?>
    <p class="lead"><?= e(t('tools.lead')) ?></p>
    <?php endif; ?>
  </div>
</section>

<section class="section wrap" aria-labelledby="tools-list-title">
  <h2 id="tools-list-title" class="visually-hidden"><?= e(t('tools.title')) ?></h2>
  <ul class="tool-list tool-list--large">
    <?php foreach ($tools as $tool): ?>
    <li class="tool-item reveal">
      <a href="<?= e(route('tool', ['slug' => $tool['slug']])) ?>">
        <span class="tool-item__tag"><?= e(t('tools.free')) ?></span>
        <span class="tool-item__title"><?= e(t("tool.{$tool['key']}.name")) ?></span>
        <span class="tool-item__text"><?= e(t("tool.{$tool['key']}.summary")) ?></span>
        <span class="link-more"><?= e(t('tools.open')) ?></span>
      </a>
    </li>
    <?php endforeach; ?>
  </ul>
</section>

<?php if ($faqs): ?>
<section class="section wrap page-narrow" aria-labelledby="tools-faq-title">
  <h2 id="tools-faq-title" class="section__title"><?= e(t('faq.title')) ?></h2>
  <?= View::render('partials/faq', ['faqs' => $faqs]) ?>
</section>
<?php endif; ?>
