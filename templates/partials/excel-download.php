<?php
/** @var string $key @var array $excel ['module' => string, 'zip' => [locale => file]] */

use App\Core\Config;
use App\Services\I18n\I18n;

$zip = $excel['zip'][I18n::locale()] ?? null;
$file = $zip !== null ? Config::root('public/descargas/' . $zip) : null;
if ($file === null || !is_file($file)) {
    return;
}
$module = $excel['module'];
$kb = I18n::number(filesize($file) / 1024, 0);
?>
<section class="excel-dl section wrap" id="excel" aria-labelledby="excel-dl-title">
  <div class="excel-dl__inner">
    <div class="excel-dl__body">
      <p class="eyebrow"><?= e(t('tools.excel.eyebrow')) ?></p>
      <h2 id="excel-dl-title" class="excel-dl__title"><?= e(t("tool.$key.excel_title")) ?></h2>
      <p class="excel-dl__text"><?= e(t("tool.$key.excel_text")) ?></p>
      <ul class="excel-dl__examples">
        <?php for ($i = 1; I18n::has("tool.$key.excel_ex$i"); $i++): ?>
        <li><code><?= e(t("tool.$key.excel_ex$i")) ?></code><span><?= e(t("tool.$key.excel_ex{$i}_out")) ?></span></li>
        <?php endfor; ?>
      </ul>
      <h3 class="excel-dl__subtitle"><?= e(t('tools.excel.steps_title')) ?></h3>
      <ol class="excel-dl__steps">
        <li><?= e(t('tools.excel.step1')) ?></li>
        <li><?= e(t('tools.excel.step2')) ?></li>
        <li><?= e(t('tools.excel.step3', ['file' => $module])) ?></li>
        <li><?= e(t('tools.excel.step4')) ?></li>
      </ol>
    </div>
    <aside class="excel-dl__card">
      <span class="excel-dl__icon" aria-hidden="true"><?= icon('table') ?></span>
      <p class="excel-dl__card-title"><?= e(t('tools.excel.includes')) ?></p>
      <ul class="excel-dl__files">
        <li><?= icon('check') ?><span><?= e(t('tools.excel.inc_bas', ['file' => $module])) ?></span></li>
        <li><?= icon('check') ?><span><?= e(t('tools.excel.inc_xlam', ['file' => $module])) ?></span></li>
        <li><?= icon('check') ?><span><?= e(t('tools.excel.inc_xlsm')) ?></span></li>
        <li><?= icon('check') ?><span><?= e(t('tools.excel.inc_readme')) ?></span></li>
      </ul>
      <a class="btn btn--primary btn--lg excel-dl__button" href="/descargas/<?= e($zip) ?>" download data-download="<?= e($key) ?>-excel"><?= icon('download') ?><?= e(t('tools.excel.download')) ?></a>
      <p class="excel-dl__meta"><?= e(t('tools.excel.size', ['size' => $kb])) ?></p>
      <p class="excel-dl__note"><?= e(t('tools.excel.unblock')) ?></p>
      <p class="excel-dl__note"><?= e(t('tools.excel.requires')) ?></p>
    </aside>
  </div>
</section>
