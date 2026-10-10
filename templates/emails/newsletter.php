<?php
/**
 * Boletín (Renderer::render). Tablas y estilos en línea para Gmail y Outlook; <style> para móvil y modo oscuro.
 * Imágenes JPEG absolutas con alt. Textos en Renderer::STRINGS (los correos no pasan por lang/*.php).
 *
 * @var array $s @var string $locale @var string $subject @var string $preheader @var string $intro @var string $date
 * @var array $posts @var bool $anyNew @var array $offers @var array $buttons @var string $homeUrl
 * @var string|null $prefsUrl @var string|null $unsubUrl @var string $why @var string|null $topics
 * @var string $address @var string $contact @var string|null $pixel @var string|null $banner @var string|null $testNote
 */
$font = "font-family:'Segoe UI',Helvetica,Arial,sans-serif;";
$hero = $posts[0] ?? null;
$rest = array_slice($posts, 1);
$labels = $s['interest'];
$tag = static function (?array $p) use ($labels): string {
    if (!empty($p['hub_title'])) {
        return (string) $p['hub_title'];
    }
    return isset($p['interests'][0]) ? (string) $labels[$p['interests'][0]] : '';
};

// Gmail convierte "edwinortiz.net" en un enlace azul (ilegible sobre el encabezado): se enlaza explícitamente con el color del texto.
$siteLink = static fn (string $html, string $color): string => str_replace('edwinortiz.net', '<a href="https://www.edwinortiz.net/" style="color:' . $color . ';text-decoration:none;">edwinortiz.net</a>', $html);
?>
<!doctype html>
<html lang="<?= $locale === 'en' ? 'en' : 'es-CO' ?>" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting">
<meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
<meta name="color-scheme" content="light dark">
<meta name="supported-color-schemes" content="light dark">
<title><?= e($subject) ?></title>
<!--[if mso]><noscript><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml></noscript><![endif]-->
<style>
  body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
  table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
  img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
  a { text-decoration: none; }
  .link:hover { text-decoration: underline !important; }
  @media screen and (max-width: 620px) {
    .container { width: 100% !important; }
    .px { padding-left: 20px !important; padding-right: 20px !important; }
    .stack { display: block !important; width: 100% !important; box-sizing: border-box !important; }
    .thumb { padding: 0 0 12px 0 !important; }
    .thumb img { width: 100% !important; max-width: 100% !important; height: auto !important; }
    .thumb-o { padding: 14px 14px 0 14px !important; }
    .thumb-o img, .thumb-o a { width: 100% !important; max-width: 100% !important; height: auto !important; }
    .btn-cell { display: block !important; width: 100% !important; padding: 0 0 10px 0 !important; }
    .btn-cell a { display: block !important; }
    .h1 { font-size: 24px !important; line-height: 30px !important; }
  }
  @media (prefers-color-scheme: dark) {
    .bg-page { background: #0b1016 !important; }
    .card { background: #141b23 !important; border-color: #263140 !important; }
    .band { background: #1a2330 !important; }
    .t-main { color: #e8edf5 !important; }
    .t-muted { color: #a3b0c2 !important; }
    .t-link { color: #8fb0ff !important; }
    .line { border-color: #263140 !important; }
    .btn-ghost { background: #1f2a38 !important; color: #e8edf5 !important; border-color: #33415a !important; }
  }
  [data-ogsc] .card { background: #141b23 !important; }
  [data-ogsc] .t-main { color: #e8edf5 !important; }
  [data-ogsc] .t-muted { color: #a3b0c2 !important; }
  [data-ogsc] .t-link { color: #8fb0ff !important; }
</style>
</head>
<body class="bg-page" style="margin:0;padding:0;width:100%;background:#eef2fa;">
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:#eef2fa;opacity:0;"><?= e($preheader) ?><?= str_repeat('&#8199;&#65279;&#847; ', 40) ?></div>
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="bg-page" style="background:#eef2fa;">
  <tr><td align="center" style="padding:24px 10px;">
    <!--[if mso]><table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" align="center"><tr><td><![endif]-->
    <table role="presentation" class="container" width="600" cellspacing="0" cellpadding="0" border="0" style="width:600px;max-width:600px;">

      <?php if ($banner): ?>
      <tr><td style="padding:0 0 14px 0;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#fff4e5;border:1px solid #ffc98f;border-radius:10px;">
          <tr><td style="padding:14px 18px;<?= $font ?>font-size:14px;line-height:21px;color:#5a3300;"><?= $banner ?></td></tr>
        </table>
      </td></tr>
      <?php endif; ?>

      <!-- Encabezado -->
      <tr><td bgcolor="#1a3bc2" style="background:#1a3bc2;background-image:linear-gradient(120deg,#2350f0 0%,#1a3bc2 55%,#0a7f6b 100%);border-radius:14px 14px 0 0;padding:26px 32px 24px;" class="px">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr>
            <td valign="middle" width="48" style="width:48px;">
              <a href="<?= e($homeUrl) ?>" style="display:inline-block;width:44px;height:44px;line-height:44px;border-radius:12px;background:#ffffff;color:#1a3bc2;<?= $font ?>font-size:18px;font-weight:800;text-align:center;">EO</a>
            </td>
            <td valign="middle" style="padding-left:12px;<?= $font ?>">
              <a href="<?= e($homeUrl) ?>" style="color:#ffffff;font-size:19px;font-weight:700;line-height:24px;">Edwin Ortiz Herazo</a><br>
              <span style="color:#dfe7ff;font-size:13px;line-height:18px;"><?= $siteLink(e($s['kicker']), '#dfe7ff') ?> · <?= e($date) ?></span>
            </td>
          </tr>
        </table>
      </td></tr>

      <!-- Saludo e introducción -->
      <tr><td class="card px" bgcolor="#ffffff" style="background:#ffffff;padding:28px 32px 8px;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;">
        <p class="t-main" style="margin:0 0 10px;<?= $font ?>font-size:17px;line-height:26px;color:#0a1124;font-weight:700;"><?= e($s['hello']) ?></p>
        <p class="t-main" style="margin:0 0 6px;<?= $font ?>font-size:16px;line-height:26px;color:#28324a;"><?= nl2br(e($intro)) ?></p>
        <p class="t-muted" style="margin:0;<?= $font ?>font-size:15px;line-height:24px;color:#536079;">— <?= e($s['sign']) ?></p>
      </td></tr>

      <!-- Artículos -->
      <tr><td class="card px" bgcolor="#ffffff" style="background:#ffffff;padding:22px 32px 6px;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr><td style="border-left:4px solid #0fb89a;padding:2px 0 2px 10px;<?= $font ?>font-size:13px;line-height:18px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#0a7f6b;"><?= e($anyNew ? $s['blog_title'] : $s['blog_title_recent']) ?></td></tr>
        </table>
      </td></tr>

      <?php if ($hero): ?>
      <tr><td class="card px" bgcolor="#ffffff" style="background:#ffffff;padding:14px 32px 10px;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;">
        <?php if ($hero['image']): ?>
        <a href="<?= e($hero['href']) ?>"><img src="<?= e($hero['image']) ?>" width="536" alt="<?= e($hero['alt']) ?>" style="display:block;width:100%;max-width:536px;height:auto;border-radius:12px;background:#e3e9f6;"></a>
        <?php endif; ?>
        <?php if ($tag($hero) !== ''): ?>
        <p style="margin:16px 0 6px;<?= $font ?>font-size:12px;line-height:16px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:#2350f0;" class="t-link"><?= e($tag($hero)) ?><?php if ($hero['minutes'] > 0): ?><span class="t-muted" style="color:#7a879e;font-weight:600;"> · <?= e(strtr($s['minutes'], [':n' => (string) $hero['minutes']])) ?></span><?php endif; ?></p>
        <?php endif; ?>
        <h1 class="h1" style="margin:<?= $tag($hero) !== '' ? '0' : '16px' ?> 0 8px;<?= $font ?>font-size:26px;line-height:33px;font-weight:800;color:#0a1124;"><a class="t-main link" href="<?= e($hero['href']) ?>" style="color:#0a1124;"><?= e($hero['title']) ?></a></h1>
        <p class="t-muted" style="margin:0 0 18px;<?= $font ?>font-size:16px;line-height:25px;color:#40506b;"><?= e($hero['summary']) ?></p>
        <table role="presentation" cellspacing="0" cellpadding="0" border="0"><tr>
          <td bgcolor="#2350f0" style="border-radius:999px;background:#2350f0;">
            <a href="<?= e($hero['href']) ?>" style="display:inline-block;padding:12px 24px;<?= $font ?>font-size:15px;line-height:20px;font-weight:700;color:#ffffff;border-radius:999px;"><?= e($s['read']) ?> &rarr;</a>
          </td>
        </tr></table>
      </td></tr>
      <?php endif; ?>

      <?php foreach ($rest as $p): ?>
      <tr><td class="card px" bgcolor="#ffffff" style="background:#ffffff;padding:18px 32px 0;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="line" style="border-top:1px solid #e3e9f6;">
          <tr>
            <?php if ($p['image']): ?>
            <td class="stack thumb" width="176" valign="top" style="width:176px;padding:18px 18px 0 0;">
              <a href="<?= e($p['href']) ?>"><img src="<?= e($p['image']) ?>" width="176" alt="<?= e($p['alt']) ?>" style="display:block;width:176px;height:auto;border-radius:10px;background:#e3e9f6;"></a>
            </td>
            <?php endif; ?>
            <td class="stack" valign="top" style="padding:18px 0 0 0;<?= $font ?>">
              <?php if ($tag($p) !== ''): ?><p class="t-link" style="margin:0 0 4px;font-size:11px;line-height:15px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;color:#2350f0;"><?= e($tag($p)) ?></p><?php endif; ?>
              <p style="margin:0 0 6px;font-size:17px;line-height:23px;font-weight:700;"><a class="t-main link" href="<?= e($p['href']) ?>" style="color:#0a1124;"><?= e($p['title']) ?></a></p>
              <p class="t-muted" style="margin:0 0 8px;font-size:14px;line-height:21px;color:#536079;"><?= e(excerpt_text($p['summary'], 140)) ?></p>
              <a class="t-link" href="<?= e($p['href']) ?>" style="font-size:14px;line-height:20px;font-weight:700;color:#2350f0;"><?= e($s['read_short']) ?> &rarr;</a>
            </td>
          </tr>
        </table>
      </td></tr>
      <?php endforeach; ?>

      <tr><td class="card" bgcolor="#ffffff" style="background:#ffffff;height:26px;line-height:26px;font-size:0;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;">&nbsp;</td></tr>

      <?php if ($offers): ?>
      <!-- De la tienda -->
      <tr><td class="band px" bgcolor="#f5f7fc" style="background:#f5f7fc;padding:24px 32px 8px;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;border-top:1px solid #dde3ef;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
          <tr><td style="border-left:4px solid #ff6a2b;padding:2px 0 2px 10px;<?= $font ?>font-size:13px;line-height:18px;font-weight:800;letter-spacing:1px;text-transform:uppercase;color:#c2410c;"><?= e($s['shop_title']) ?></td></tr>
        </table>
        <p class="t-muted" style="margin:10px 0 0;<?= $font ?>font-size:14px;line-height:21px;color:#536079;"><?= e($s['shop_lead']) ?></p>
      </td></tr>
      <?php foreach ($offers as $o): $isTool = $o['kind'] === 'tool'; ?>
      <tr><td class="band px" bgcolor="#f5f7fc" style="background:#f5f7fc;padding:12px 32px;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="card" bgcolor="#ffffff" style="background:#ffffff;border:1px solid #dde3ef;border-radius:12px;">
          <tr>
            <td class="stack thumb-o" width="150" valign="top" style="width:150px;padding:14px 0 14px 14px;">
              <?php if ($o['image']): ?>
              <a href="<?= e($o['href']) ?>"><img src="<?= e($o['image']) ?>" width="150" alt="<?= e($o['alt']) ?>" style="display:block;width:150px;height:auto;border-radius:8px;background:#e3e9f6;"></a>
              <?php else: ?>
              <a href="<?= e($o['href']) ?>" style="display:block;width:150px;height:79px;line-height:79px;border-radius:8px;background:<?= $isTool ? '#dcf7f1' : '#e6ecff' ?>;color:<?= $isTool ? '#0a7f6b' : '#1a3bc2' ?>;<?= $font ?>font-size:15px;font-weight:800;text-align:center;"><?= e($isTool ? $s['free'] : 'edwinortiz.net') ?></a>
              <?php endif; ?>
            </td>
            <td class="stack" valign="top" style="padding:14px 16px 14px 16px;<?= $font ?>">
              <p style="margin:0 0 4px;font-size:16px;line-height:22px;font-weight:700;"><a class="t-main link" href="<?= e($o['href']) ?>" style="color:#0a1124;"><?= e($o['title']) ?></a></p>
              <p class="t-muted" style="margin:0 0 10px;font-size:14px;line-height:20px;color:#536079;"><?= e($o['summary']) ?></p>
              <table role="presentation" cellspacing="0" cellpadding="0" border="0"><tr>
                <td style="padding-right:12px;<?= $font ?>font-size:14px;line-height:20px;font-weight:800;color:<?= $isTool || $o['price'] === null ? '#0a7f6b' : '#0a1124' ?>;" class="<?= $isTool ? '' : 't-main' ?>"><?= e($o['price'] ?? $s['free']) ?></td>
                <td><a class="t-link" href="<?= e($o['href']) ?>" style="<?= $font ?>font-size:14px;line-height:20px;font-weight:700;color:#2350f0;"><?= e($isTool ? $s['try_free'] : $s['see_product']) ?> &rarr;</a></td>
              </tr></table>
            </td>
          </tr>
        </table>
      </td></tr>
      <?php endforeach; ?>
      <tr><td class="band" bgcolor="#f5f7fc" style="background:#f5f7fc;height:14px;line-height:14px;font-size:0;border-left:1px solid #dde3ef;border-right:1px solid #dde3ef;">&nbsp;</td></tr>
      <?php endif; ?>

      <!-- Cierre -->
      <tr><td class="card px" bgcolor="#ffffff" style="background:#ffffff;padding:26px 32px 28px;border:1px solid #dde3ef;border-top:1px solid #dde3ef;border-radius:0 0 14px 14px;">
        <p class="t-main" style="margin:0 0 18px;<?= $font ?>font-size:16px;line-height:25px;color:#28324a;"><?= e($s['closing']) ?></p>
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"><tr>
          <?php foreach ($buttons as $b): ?>
          <td class="btn-cell" align="center" style="padding:0 8px 0 0;">
            <?php if ($b['primary']): ?>
            <a href="<?= e($b['href']) ?>" style="display:block;padding:12px 10px;border-radius:999px;background:#ff6a2b;border:1px solid #ff6a2b;<?= $font ?>font-size:14px;line-height:20px;font-weight:800;color:#160800;text-align:center;"><?= e($b['label']) ?></a>
            <?php else: ?>
            <a class="btn-ghost" href="<?= e($b['href']) ?>" style="display:block;padding:12px 10px;border-radius:999px;background:#eef2fa;border:1px solid #dde3ef;<?= $font ?>font-size:14px;line-height:20px;font-weight:700;color:#1a3bc2;text-align:center;"><?= e($b['label']) ?></a>
            <?php endif; ?>
          </td>
          <?php endforeach; ?>
        </tr></table>
        <p class="t-main" style="margin:22px 0 0;<?= $font ?>font-size:16px;line-height:24px;color:#28324a;"><?= e($s['bye']) ?><br><strong><?= e($s['sign']) ?></strong></p>
      </td></tr>

      <!-- Pie -->
      <tr><td class="px" style="padding:20px 32px 8px;<?= $font ?>font-size:12px;line-height:19px;color:#6b778c;text-align:center;">
        <p class="t-muted" style="margin:0 0 6px;color:#6b778c;"><?= e($why) ?><?php if ($topics): ?> <?= e($topics) ?><?php endif; ?></p>
        <?php if ($prefsUrl): ?>
        <p style="margin:0 0 6px;"><a class="t-link" href="<?= e($prefsUrl) ?>" style="color:#2350f0;text-decoration:underline;"><?= e($s['prefs']) ?></a> &nbsp;·&nbsp; <a class="t-link" href="<?= e($unsubUrl) ?>" style="color:#2350f0;text-decoration:underline;"><?= e($s['unsubscribe']) ?></a></p>
        <?php elseif ($testNote): ?>
        <p class="t-muted" style="margin:0 0 6px;color:#6b778c;"><?= e($testNote) ?></p>
        <?php endif; ?>
        <p class="t-muted" style="margin:0;color:#6b778c;">Edwin Ortiz Herazo · <?= $siteLink('edwinortiz.net', '#6b778c') ?> · <?= e($address) ?> · <?= e($contact) ?></p>
      </td></tr>
    </table>
    <!--[if mso]></td></tr></table><![endif]-->
  </td></tr>
</table>
<?php if ($pixel): ?><img src="<?= e($pixel) ?>" width="1" height="1" alt="" style="display:block;width:1px;height:1px;border:0;"><?php endif; ?>
</body>
</html>
