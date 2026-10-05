<?php

declare(strict_types=1);

namespace App\Services\Payments;

/**
 * Estado normalizado de un pago según la pasarela.
 */
final class Status
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const DECLINED = 'declined';
    public const VOIDED = 'voided';
    public const REFUNDED = 'refunded';
    public const ERROR = 'error';

    public function __construct(
        public readonly string $status,
        public readonly ?string $gatewayId = null,
        public readonly ?float $amount = null,
        public readonly ?string $currency = null,
        public readonly ?string $reference = null,
        public readonly ?string $rawStatus = null,
        public readonly array $raw = [],
    ) {
    }

    public static function unknown(): self
    {
        return new self(self::PENDING);
    }
}
