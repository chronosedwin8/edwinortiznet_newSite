<?php /** @var string|null $notice @var string|null $error */ ?>
<?php if (!empty($error)): ?><p class="notice notice--error piar-flash" role="alert"><?= e($error) ?></p><?php endif; ?>
<?php if (!empty($notice)): ?><p class="notice notice--ok piar-flash" role="status"><?= e($notice) ?></p><?php endif; ?>
