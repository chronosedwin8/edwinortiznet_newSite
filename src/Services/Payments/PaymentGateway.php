<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Core\Request;

/**
 * Contrato común de las pasarelas. El pedido (array de la tabla orders + items) nunca se aprueba
 * desde la URL de retorno: solo desde un webhook verificado o una consulta servidor a servidor.
 */
interface PaymentGateway
{
    public function name(): string;

    /** Crea la sesión de pago y devuelve la URL a la que se redirige al comprador. */
    public function createCheckout(array $order): string;

    /** Id del lado de la pasarela creado en createCheckout (preferencia de MP, orden de PayPal), si aplica. */
    public function checkoutId(): ?string;

    /** Valida y normaliza un webhook. Nunca lanza excepción por firmas inválidas: devuelve valid = false. */
    public function handleWebhook(Request $request): WebhookResult;

    /** Consulta el estado en la API de la pasarela. $hint: id de transacción/pago/orden si se conoce. */
    public function fetchStatus(array $order, ?string $hint = null): Status;
}
