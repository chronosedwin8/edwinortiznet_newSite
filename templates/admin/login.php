<?php /** @var string|null $error */ ?>
<p class="side__brand" style="color:inherit;padding:0 0 8px"><span class="side__mark" aria-hidden="true"><?= e(t('nav.brand_mark')) ?></span><span><?= e(t('admin.brand')) ?><small class="muted"><?= e(t('admin.brand_sub')) ?></small></span></p>
<h1><?= e(t('admin.login.title')) ?></h1>
<?php if ($error): ?><p class="flash flash--error" role="alert"><?= e($error) ?></p><?php endif; ?>
<form method="post" action="/admin/acceso/" class="admin-form">
  <?= csrf_field() ?>
  <label for="a-email"><?= e(t('admin.login.email')) ?></label>
  <input id="a-email" type="email" name="email" required autocomplete="username" autofocus>
  <label for="a-pass"><?= e(t('admin.login.password')) ?></label>
  <input id="a-pass" type="password" name="password" required autocomplete="current-password">
  <button class="btn" type="submit"><?= e(t('admin.login.submit')) ?></button>
</form>
