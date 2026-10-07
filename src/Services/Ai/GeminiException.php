<?php

declare(strict_types=1);

namespace App\Services\Ai;

use RuntimeException;

/**
 * Error de Gemini con lo que se sabe de la llamada: si se facturó (hubo respuesta 200), los tokens usados,
 * el motivo de cierre (p. ej., MAX_TOKENS) y el texto recibido (para rescatar una respuesta truncada).
 */
final class GeminiException extends RuntimeException
{
    public bool $billed = false;
    public int $promptTokens = 0;
    public int $outputTokens = 0;
    public string $finish = '';
    public string $text = '';
    public string $model = '';
}
