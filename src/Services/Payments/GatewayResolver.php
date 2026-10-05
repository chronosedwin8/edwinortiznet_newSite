<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Core\CurlHttpClient;
use App\Core\HttpClient;

/**
 * Pasarelas permitidas por idioma del pedido: es → Mercado Pago y Wompi (COP); en → PayPal (USD).
 */
final class GatewayResolver
{
    private const BY_LOCALE = [
        'es' => ['mercadopago', 'wompi'],
        'en' => ['paypal'],
    ];
    private const CURRENCY = ['es' => 'COP', 'en' => 'USD'];

    private static ?HttpClient $http = null;
    /** @var array<string, PaymentGateway> */
    private static array $overrides = [];

    /** Pruebas: sustituye el cliente HTTP o una pasarela concreta. */
    public static function useHttpClient(?HttpClient $http): void
    {
        self::$http = $http;
    }

    public static function override(string $name, ?PaymentGateway $gateway): void
    {
        if ($gateway === null) {
            unset(self::$overrides[$name]);
            return;
        }
        self::$overrides[$name] = $gateway;
    }

    /**
     * Pasarelas ofrecidas en el idioma. GATEWAYS_DISABLED (lista separada por comas) oculta las que aún
     * no tienen credenciales de producción, sin tocar el código.
     *
     * @return string[]
     */
    public static function allowed(string $locale): array
    {
        $disabled = array_filter(array_map('trim', explode(',', strtolower((string) \App\Core\Config::get('GATEWAYS_DISABLED', '')))));
        return array_values(array_diff(self::BY_LOCALE[$locale] ?? [], $disabled));
    }

    public static function currency(string $locale): string
    {
        return self::CURRENCY[$locale] ?? 'COP';
    }

    public static function isAllowed(string $locale, string $gateway): bool
    {
        return in_array($gateway, self::allowed($locale), true);
    }

    /** Lanza excepción si la combinación idioma/pasarela/moneda no es válida. */
    public static function assertAllowed(array $order, string $gateway): void
    {
        if (!self::isAllowed((string) $order['locale'], $gateway) || ($order['currency'] ?? '') !== self::currency((string) $order['locale'])) {
            throw new \DomainException("Pasarela $gateway no permitida para un pedido en {$order['locale']} ({$order['currency']})");
        }
    }

    public static function make(string $name): PaymentGateway
    {
        if (isset(self::$overrides[$name])) {
            return self::$overrides[$name];
        }
        $http = self::$http ?? new CurlHttpClient();
        return match ($name) {
            'mercadopago' => MercadoPago::fromConfig($http),
            'wompi' => Wompi::fromConfig($http),
            'paypal' => PayPal::fromConfig($http),
            default => throw new \InvalidArgumentException("Pasarela desconocida: $name"),
        };
    }
}
