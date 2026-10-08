<?php

declare(strict_types=1);

namespace App\Services\Social;

use App\Core\Config;
use RuntimeException;

/**
 * Cifrado de los tokens de las redes (libsodium secretbox). La clave se deriva de APP_KEY con BLAKE2b
 * y un contexto propio, así que cambiar APP_KEY obliga a reconectar las cuentas.
 * Formato guardado: "v1:" + base64(nonce || texto cifrado).
 */
final class TokenVault
{
    private const PREFIX = 'v1:';

    public static function encrypt(string $plain): string
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        return self::PREFIX . base64_encode($nonce . sodium_crypto_secretbox($plain, $nonce, self::key()));
    }

    public static function decrypt(?string $stored): ?string
    {
        if ($stored === null || !str_starts_with($stored, self::PREFIX)) {
            return null;
        }
        $raw = base64_decode(substr($stored, strlen(self::PREFIX)), true);
        if ($raw === false || strlen($raw) <= SODIUM_CRYPTO_SECRETBOX_NONCEBYTES) {
            return null;
        }
        $plain = sodium_crypto_secretbox_open(
            substr($raw, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES),
            substr($raw, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES),
            self::key()
        );
        return $plain === false ? null : $plain;
    }

    private static function key(): string
    {
        $appKey = (string) Config::get('APP_KEY', '');
        if (strlen($appKey) < 16) {
            throw new RuntimeException('APP_KEY no está configurada: no se pueden cifrar los tokens de las redes.');
        }
        return sodium_crypto_generichash('edwinortiz.net/social-tokens/v1', $appKey, SODIUM_CRYPTO_SECRETBOX_KEYBYTES);
    }
}
