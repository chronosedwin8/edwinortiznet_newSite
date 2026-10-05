<?php /** @var string $subject @var string $body @var string $locale */ ?>
<!doctype html>
<html lang="<?= $locale === 'en' ? 'en' : 'es-CO' ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="light">
<title><?= e($subject) ?></title>
</head>
<body style="margin:0;padding:0;background:#f3f1ec;font-family:Arial,Helvetica,sans-serif;color:#16191b;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f1ec;padding:24px 12px;">
  <tr><td align="center">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:580px;background:#ffffff;border-radius:12px;overflow:hidden;border:1px solid #e2ded5;">
      <tr><td style="background:#0E5A6B;padding:18px 28px;color:#ffffff;font-size:18px;font-weight:bold;">Edwin Ortiz Herazo</td></tr>
      <tr><td style="padding:28px;font-size:16px;line-height:1.6;"><?= $body ?></td></tr>
      <tr><td style="padding:18px 28px;border-top:1px solid #e2ded5;font-size:12px;color:#565e62;">edwinortiz.net · Barranquilla, Colombia</td></tr>
    </table>
  </td></tr>
</table>
</body>
</html>
