<?php /** @var string|null $error */ ?>
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
