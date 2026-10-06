<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Config;
use App\Core\DB;
use App\Core\Logger;
use App\Core\Mailer;
use App\Models\Product;
use App\Services\Mail\MailTemplates;

/**
 * Lista de espera "Avísame cuando salga": confirma por correo al apuntarse, avisa al administrador
 * y escribe a toda la lista en cuanto el producto se puede comprar.
 */
final class Waitlist
{
    /** Guarda el correo (o lo reactiva si ya se le había avisado) y envía la confirmación. */
    public static function add(array $product, string $email, string $locale): void
    {
        $existing = DB::one('SELECT id, notified_at FROM waitlist WHERE product_id = :p AND email = :e', ['p' => (int) $product['id'], 'e' => $email]);
        if ($existing === null) {
            DB::insert('waitlist', ['product_id' => (int) $product['id'], 'email' => $email, 'locale' => $locale]);
        } else {
            DB::update('waitlist', ['locale' => $locale, 'notified_at' => null], ['id' => (int) $existing['id']]);
        }
        $data = ['product' => $product, 'productUrl' => url(product_path($product))];
        $mail = MailTemplates::render('waitlist-confirm', $locale, $data);
        Mailer::send($email, $mail['subject'], $mail['html'], $mail['text']);
        if ($existing === null) {
            $count = (int) DB::value('SELECT COUNT(*) FROM waitlist WHERE product_id = :p AND notified_at IS NULL', ['p' => (int) $product['id']]);
            $admin = MailTemplates::render('admin-waitlist', 'es', $data + compact('email', 'locale', 'count'));
            Mailer::send((string) Config::get('ADMIN_EMAIL', ''), $admin['subject'], $admin['html'], $admin['text'], $email);
        }
    }

    /**
     * Si el producto ya se puede comprar, escribe a cada correo pendiente en su idioma.
     * Devuelve cuántos avisos se enviaron.
     */
    public static function notifyIfAvailable(int $productId): int
    {
        $es = Product::find($productId, 'es');
        if ($es === null || !$es['purchasable']) {
            return 0;
        }
        $pending = DB::all('SELECT id, email, locale FROM waitlist WHERE product_id = :p AND notified_at IS NULL ORDER BY id', ['p' => $productId]);
        $products = ['es' => $es];
        $sent = 0;
        foreach ($pending as $row) {
            $locale = $row['locale'] === 'en' ? 'en' : 'es';
            $product = $products[$locale] ??= Product::find($productId, $locale) ?? $es;
            $mailLocale = $product['locale'] ?? $locale;
            $mail = MailTemplates::render('waitlist-available', $mailLocale, ['product' => $product, 'productUrl' => url(product_path($product))]);
            if (Mailer::send((string) $row['email'], $mail['subject'], $mail['html'], $mail['text'])) {
                DB::update('waitlist', ['notified_at' => gmdate('Y-m-d H:i:s')], ['id' => (int) $row['id']]);
                $sent++;
            } else {
                Logger::warning('No se pudo enviar el aviso de lista de espera', ['waitlist_id' => (int) $row['id']]);
            }
        }
        return $sent;
    }
}
