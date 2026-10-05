<?php

declare(strict_types=1);

namespace App\Services\Payments;

/**
 * Resultado de procesar un webhook: firma, identificador del evento (idempotencia) y estado verificado.
 */
final class WebhookResult
{
    public function __construct(
        public readonly bool $valid,
        public readonly ?string $eventId = null,
        public readonly ?string $eventType = null,
        public readonly ?Status $status = null,
        public readonly array $payload = [],
        public readonly bool $ignored = false,
    ) {
    }

    public static function invalid(array $payload = []): self
    {
        return new self(false, null, null, null, $payload);
    }

    /** Firma válida pero el evento no interesa (otro tipo de notificación). */
    public static function ignored(string $eventId, ?string $type, array $payload): self
    {
        return new self(true, $eventId, $type, null, $payload, true);
    }
}
