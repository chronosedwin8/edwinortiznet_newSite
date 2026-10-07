<?php
/** Cuenta existente (p. ej., de la tienda) que entra por primera vez: aceptar términos. @var array $customer @var string|null $notice @var string|null $error */

use App\Core\View;

?>
<?= View::render('partials/piar/bar', ['customer' => $customer, 'active' => 'home']) ?>
<section class="wrap piar-page page-narrow">
  <div class="piar-panel">
    <?= View::render('partials/piar/flash', ['notice' => $notice, 'error' => $error]) ?>
    <h1 class="piar-title piar-title--sm"><?= e(t('piar.terms.title')) ?></h1>
    <p class="lead"><?= e(t('piar.terms.lead')) ?></p>
    <form class="form piar-form" action="<?= e(route('piar.terms')) ?>" method="post">
      <?= csrf_field() ?>
      <div class="piar-check">
        <input id="pt-terms" type="checkbox" name="terms" value="1" required>
        <label for="pt-terms"><?= t('piar.access.terms', [
            'terms' => '<a href="' . e(route('policy', ['slug' => 'terminos'], 'es')) . '" target="_blank">' . e(t('piar.access.terms_link')) . '</a>',
            'privacy' => '<a href="' . e(route('policy', ['slug' => 'privacidad'], 'es')) . '" target="_blank">' . e(t('piar.access.privacy_link')) . '</a>',
        ]) ?></label>
      </div>
      <button class="btn btn--primary btn--lg" type="submit"><?= e(t('piar.terms.submit')) ?></button>
    </form>
  </div>
</section>
