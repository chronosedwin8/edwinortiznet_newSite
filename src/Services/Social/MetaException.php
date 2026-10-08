<?php

declare(strict_types=1);

namespace App\Services\Social;

use RuntimeException;

/**
 * Error de la Graph API (Facebook/Instagram). El mensaje nunca incluye tokens.
 */
final class MetaException extends RuntimeException
{
    public function __construct(
        string $message,
        public readonly int $http = 0,
        public readonly int $apiCode = 0,
        public readonly int $subcode = 0,
        public readonly bool $transient = false,
    ) {
        parent::__construct($message);
    }

    /** Token vencido, revocado o sin permisos: hay que reconectar la cuenta (código 190 y afines). */
    public function isTokenError(): bool
    {
        // 190 = token inválido o vencido; 102 = sesión; 10 y 200–299 = permiso retirado o faltante.
        return in_array($this->apiCode, [190, 102, 463, 467, 10], true) || ($this->apiCode >= 200 && $this->apiCode < 300);
    }
}
