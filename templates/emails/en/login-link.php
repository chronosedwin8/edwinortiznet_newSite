<?php
/** @var string $loginUrl */
$subject = 'Your sign-in link for My account';
?>
<p>Hi,</p>
<p>Use this link to sign in to “My account” on edwinortiz.net. It is valid for 15 minutes and works only once.</p>
<p><a href="<?= e($loginUrl) ?>" style="display:inline-block;background:#0E5A6B;color:#ffffff;padding:12px 20px;border-radius:999px;text-decoration:none;font-weight:bold;">Sign in to My account</a></p>
<p>If you didn’t request this link, you can ignore this email.</p>
