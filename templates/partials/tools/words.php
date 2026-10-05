<?php use App\Services\I18n\I18n; $locale = I18n::locale(); ?>
<div class="words-tool" data-words-tool data-locale="<?= e($locale) ?>"
     data-error="<?= e(t('tool.words.error')) ?>" data-copied="<?= e(t('tool.words.copied')) ?>">
  <form class="words-tool__form" data-words-form>
    <div class="form__row">
      <label for="w-amount"><?= e(t('tool.words.amount_label')) ?></label>
      <input id="w-amount" type="text" inputmode="decimal" autocomplete="off" data-words-input
             placeholder="<?= e(t('tool.words.amount_placeholder')) ?>" value="<?= $locale === 'es' ? '1.250.000' : '1,250' ?>">
      <p class="form-note"><?= e(t('tool.words.amount_help')) ?></p>
    </div>
    <div class="form__row form__row--inline">
      <input id="w-currency" type="checkbox" data-words-currency checked>
      <label for="w-currency"><?= e(t('tool.words.currency_label')) ?></label>
    </div>
  </form>
  <div class="words-tool__result">
    <p class="words-tool__label"><?= e(t('tool.words.result_label')) ?></p>
    <output class="words-tool__output" data-words-output for="w-amount" aria-live="polite"></output>
    <button type="button" class="btn btn--ghost btn--sm" data-words-copy><?= e(t('tool.words.copy')) ?></button>
  </div>
</div>
