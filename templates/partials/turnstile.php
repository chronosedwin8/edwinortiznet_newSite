<?php
/* Cloudflare Turnstile: solo si TURNSTILE_SITE_KEY y TURNSTILE_SECRET están en .env. El script se carga una vez por página. */
use App\Core\View;
use App\Services\Turnstile;

if (!Turnstile::enabled()) {
    return;
}
$first = !View::shared('turnstile_loaded');
View::share('turnstile_loaded', true);
?>
<div class="cf-turnstile" data-sitekey="<?= e(Turnstile::siteKey()) ?>" data-appearance="interaction-only" data-size="flexible" data-language="<?= e(locale()) ?>"></div>
<?php if ($first): ?><script src="<?= e(Turnstile::SCRIPT) ?>" async defer></script><?php endif; ?>
