<?php /** @var array $crumbs @var bool $sent @var string|null $error @var string $whatsapp */ ?>
<section class="page wrap page-narrow">
  <header class="page__header">
    <?= \App\Core\View::render('partials/breadcrumbs', ['crumbs' => $crumbs]) ?>
    <h1 class="page__title"><?= e(t('contact.title')) ?></h1>
    <p class="lead"><?= e(t('contact.lead')) ?></p>
  </header>

  <?php if ($sent): ?>
  <p class="notice notice--ok" role="status"><?= e(t('contact.sent')) ?></p>
  <?php elseif ($error): ?>
  <p class="notice notice--error" role="alert"><?= e(t($error === 'rate' ? 'form.rate_limited' : 'contact.invalid')) ?></p>
  <?php endif; ?>

  <form class="form" action="<?= e(route('contact')) ?>" method="post">
    <?= csrf_field() ?>
    <?= antispam_fields() ?>
    <div class="form__row">
      <label for="c-name"><?= e(t('form.name')) ?></label>
      <input id="c-name" name="name" type="text" required autocomplete="name" maxlength="190">
    </div>
    <div class="form__row">
      <label for="c-email"><?= e(t('form.email')) ?></label>
      <input id="c-email" name="email" type="email" required autocomplete="email" maxlength="190">
    </div>
    <div class="form__row">
      <label for="c-subject"><?= e(t('contact.subject')) ?></label>
      <input id="c-subject" name="subject" type="text" maxlength="190">
    </div>
    <div class="form__row">
      <label for="c-message"><?= e(t('contact.message')) ?></label>
      <textarea id="c-message" name="message" rows="6" required minlength="10" maxlength="5000"></textarea>
    </div>
    <p class="form-note"><?= e(t('contact.privacy')) ?> <a href="<?= e(route('policy', ['slug' => \App\Services\I18n\I18n::locale() === 'es' ? 'privacidad' : 'privacy'])) ?>"><?= e(t('footer.privacy')) ?></a></p>
    <button class="btn btn--primary" type="submit"><?= e(t('contact.send')) ?></button>
  </form>

  <aside class="contact-alt">
    <h2><?= e(t('contact.whatsapp_title')) ?></h2>
    <p><?= e(t('contact.whatsapp_text')) ?></p>
    <p><a class="btn btn--ghost" href="https://wa.me/<?= e($whatsapp) ?>" target="_blank" rel="noopener"><?= e(t('contact.whatsapp_cta')) ?></a></p>
  </aside>
</section>
