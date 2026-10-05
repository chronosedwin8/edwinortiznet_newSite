<div class="qr-tool" data-qr-tool
     data-error-long="<?= e(t('tool.qr.error_long')) ?>" data-error-empty="<?= e(t('tool.qr.error_empty')) ?>"
     data-version-label="<?= e(t('tool.qr.version_label')) ?>">
  <form class="qr-tool__form" data-qr-form>
    <div class="form__row">
      <label for="qr-text"><?= e(t('tool.qr.text_label')) ?></label>
      <textarea id="qr-text" rows="3" maxlength="2900" data-qr-text placeholder="<?= e(t('tool.qr.text_placeholder')) ?>"><?= e(url('/')) ?></textarea>
    </div>
    <div class="form__grid">
      <div class="form__row">
        <label for="qr-size"><?= e(t('tool.qr.size_label')) ?></label>
        <select id="qr-size" data-qr-size>
          <option value="256">256 px</option>
          <option value="512" selected>512 px</option>
          <option value="1024">1024 px</option>
          <option value="2048">2048 px</option>
        </select>
      </div>
      <div class="form__row">
        <label for="qr-ecc"><?= e(t('tool.qr.ecc_label')) ?></label>
        <select id="qr-ecc" data-qr-ecc>
          <option value="L"><?= e(t('tool.qr.ecc_l')) ?></option>
          <option value="M" selected><?= e(t('tool.qr.ecc_m')) ?></option>
          <option value="Q"><?= e(t('tool.qr.ecc_q')) ?></option>
          <option value="H"><?= e(t('tool.qr.ecc_h')) ?></option>
        </select>
      </div>
      <div class="form__row">
        <label for="qr-dark"><?= e(t('tool.qr.color_label')) ?></label>
        <input id="qr-dark" type="color" value="#000000" data-qr-dark>
      </div>
      <div class="form__row">
        <label for="qr-light"><?= e(t('tool.qr.bg_label')) ?></label>
        <input id="qr-light" type="color" value="#ffffff" data-qr-light>
      </div>
    </div>
  </form>
  <div class="qr-tool__preview">
    <div class="qr-tool__canvas" data-qr-preview role="img" aria-label="<?= e(t('tool.qr.preview_label')) ?>"></div>
    <p class="form-status" data-qr-status role="status" aria-live="polite"></p>
    <div class="qr-tool__actions">
      <button type="button" class="btn btn--primary" data-qr-png><?= e(t('tool.qr.download_png')) ?></button>
      <button type="button" class="btn btn--ghost" data-qr-svg><?= e(t('tool.qr.download_svg')) ?></button>
    </div>
  </div>
</div>
