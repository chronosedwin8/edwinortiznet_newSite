<?php
/** Cuenta existente que entra por primera vez: aceptar términos. @var array $customer @var string|null $notice @var string|null $error */

use App\Core\View;

?>
<?= View::render('partials/examenes/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap ex-page page-narrow">
  <div class="ex-panel">
    <?= View::render('partials/examenes/flash', ['notice' => $notice, 'error' => $error]) ?>
    <h1 class="ex-title ex-title--sm"><?= e(t('examenes.terms.title')) ?></h1>
    <p class="lead"><?= e(t('examenes.terms.lead')) ?></p>
    <form class="form ex-form" action="<?= e(route('examenes.terms')) ?>" method="post">
      <?= csrf_field() ?>
      <div class="ex-consent">
        <input id="et-terms" type="checkbox" name="terms" value="1" required>
        <label for="et-terms"><?= t('examenes.access.terms', [
            'terms' => '<a href="' . e(route('policy', ['slug' => 'terminos'], 'es')) . '" target="_blank">' . e(t('examenes.access.terms_link')) . '</a>',
            'privacy' => '<a href="' . e(route('policy', ['slug' => 'privacidad'], 'es')) . '" target="_blank">' . e(t('examenes.access.privacy_link')) . '</a>',
        ]) ?></label>
      </div>
      <button class="btn btn--primary btn--lg" type="submit"><?= e(t('examenes.terms.submit')) ?></button>
    </form>
  </div>
</section>
