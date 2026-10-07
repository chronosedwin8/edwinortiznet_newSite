<?php /** @var string|null $notice @var string|null $error */ ?>
<?php if (!empty($error)): ?><p class="notice notice--error ex-flash" role="alert"><?= e($error) ?></p><?php endif; ?>
<?php if (!empty($notice)): ?><p class="notice notice--ok ex-flash" role="status"><?= e($notice) ?></p><?php endif; ?>
