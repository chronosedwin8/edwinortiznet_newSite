<?php /** @var array $tools @var bool|null $large */ ?>
<ul class="tool-cards<?= !empty($large) ? ' tool-cards--large' : '' ?>">
  <?php foreach ($tools as $i => $tool): ?>
  <li class="reveal" style="--i: <?= $i ?>">
    <a class="tool-card tool-card--<?= e($tool['key']) ?>" href="<?= e(route('tool', ['slug' => $tool['slug']])) ?>" data-spotlight>
      <span class="tool-card__icon"><?= icon($tool['icon']) ?></span>
      <span class="tool-card__tag"><?= e(t($tool['key'] === 'fundales' ? 'tools.external' : 'tools.free')) ?></span>
      <span class="tool-card__title"><?= e(t("tool.{$tool['key']}.name")) ?></span>
      <span class="tool-card__text"><?= e(t("tool.{$tool['key']}.summary")) ?></span>
      <span class="tool-card__go"><?= e(t('tools.open')) ?> <?= icon('arrow') ?></span>
    </a>
  </li>
  <?php endforeach; ?>
</ul>
