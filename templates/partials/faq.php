<?php /** @var array $faqs */ ?>
<div class="faq">
  <?php foreach ($faqs as $faq): ?>
  <details class="faq__item">
    <summary class="faq__q"><?= e($faq['q']) ?></summary>
    <div class="faq__a"><p><?= e($faq['a']) ?></p></div>
  </details>
  <?php endforeach; ?>
</div>
