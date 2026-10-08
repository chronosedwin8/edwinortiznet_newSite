<?php
/** Selector de temas (casillas con forma de chip). @var string $idPrefix @var string[] $checked @var bool|null $large */
use App\Services\Newsletter\Interests;

$large ??= false;
?>
<fieldset class="interest-chips<?= $large ? ' interest-chips--large' : '' ?>">
  <legend class="interest-chips__legend"><?= e(t('subscribe.interests.legend')) ?></legend>
  <div class="interest-chips__list">
    <?php foreach (Interests::ALL as $interest): $id = $idPrefix . '-int-' . $interest; ?>
    <label class="interest-chip" for="<?= e($id) ?>">
      <input type="checkbox" id="<?= e($id) ?>" name="interests[]" value="<?= e($interest) ?>"<?= in_array($interest, $checked, true) ? ' checked' : '' ?>>
      <span><?= e(t("subscribe.interests.$interest")) ?></span>
    </label>
    <?php endforeach; ?>
  </div>
</fieldset>
