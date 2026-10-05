<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\Csrf;
use App\Core\DB;
use App\Core\Mailer;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Services\Orders\OrderService;
use App\Services\Payments\GatewayResolver;
use PHPUnit\Framework\TestCase;
use Tests\Support\FakeHttpClient;

/**
 * Pagos: firmas (válida/ inválida), idempotencia, monto que no coincide, reglas idioma ↔ pasarela
 * y compra simulada completa en cada pasarela hasta la descarga.
 */
final class PaymentsTest extends TestCase
{
    private FakeHttpClient $http;
    private string $csrf;
    private int $productId;
    private int $salesBefore;
    private string $run;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM orders');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        $this->run = bin2hex(random_bytes(4));
        foreach ([
            'MAIL_DRIVER' => 'array', 'PAGE_CACHE' => 'false', 'APP_URL' => 'https://www.edwinortiz.net',
            'MP_ACCESS_TOKEN' => 'TEST-token', 'MP_WEBHOOK_SECRET' => 'mp_test_secret', 'MP_MODE' => 'sandbox',
            'WOMPI_PUBLIC_KEY' => 'pub_test_abc', 'WOMPI_PRIVATE_KEY' => 'prv_test_abc', 'WOMPI_INTEGRITY_SECRET' => 'test_integrity_abc',
            'WOMPI_EVENTS_SECRET' => 'test_events_abc', 'WOMPI_MODE' => 'sandbox',
            'PAYPAL_CLIENT_ID' => 'client', 'PAYPAL_CLIENT_SECRET' => 'secret', 'PAYPAL_WEBHOOK_ID' => 'WH-TEST', 'PAYPAL_MODE' => 'sandbox',
        ] as $k => $v) {
            Config::set($k, $v);
        }
        RateLimiter::disable();
        Mailer::$sent = [];
        $this->http = new FakeHttpClient();
        GatewayResolver::useHttpClient($this->http);
        \App\Core\Cache::forget('paypal-token-sandbox-' . substr(hash('sha256', 'client'), 0, 12));
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->productId = (int) DB::value('SELECT id FROM products WHERE wp_id = 380');
        $this->salesBefore = (int) DB::value('SELECT sales_count FROM products WHERE id = :id', ['id' => $this->productId]);
        $this->assertNotNull(DB::value('SELECT storage_path FROM product_files WHERE product_id = :p', ['p' => $this->productId]), 'El producto de prueba necesita archivo local (php bin/console downloads:fetch)');

        $this->http->on('POST', '#/checkout/preferences$#', 201, ['id' => 'pref-1', 'init_point' => 'https://www.mercadopago.com.co/checkout/v1/redirect?pref_id=pref-1', 'sandbox_init_point' => 'https://sandbox.mercadopago.com.co/checkout/v1/redirect?pref_id=pref-1']);
        $this->http->on('POST', '#/v1/oauth2/token$#', 200, ['access_token' => 'A21-token', 'expires_in' => 32400]);
        $this->http->on('POST', '#/v2/checkout/orders$#', 201, ['id' => 'PP-' . $this->run, 'status' => 'PAYER_ACTION_REQUIRED', 'links' => [['rel' => 'payer-action', 'href' => 'https://www.sandbox.paypal.com/checkoutnow?token=PP-' . $this->run]]]);
    }

    protected function tearDown(): void
    {
        if (!isset($this->productId)) {
            return;
        }
        GatewayResolver::useHttpClient(null);
        DB::run('DELETE FROM payment_events WHERE event_id LIKE :p', ['p' => '%' . $this->run . '%']);
        DB::run('DELETE FROM orders WHERE email LIKE :e', ['e' => '%@test.local']);
        DB::run('DELETE FROM customers WHERE email LIKE :e', ['e' => '%@test.local']);
        DB::run('UPDATE products SET sales_count = :s WHERE id = :id', ['s' => $this->salesBefore, 'id' => $this->productId]);
        RateLimiter::disable(false);
    }

    private function request(string $method, string $uri, array $post = [], array $server = [], ?string $body = null): Response
    {
        if ($method === 'POST' && $body === null) {
            $post['_csrf'] = $this->csrf;
        }
        return App::handle(Request::create($method, $uri, $post, $server, [Csrf::COOKIE => $this->csrf], $body));
    }

    /** Compra por el formulario de pago; devuelve [respuesta, pedido]. */
    private function checkout(string $locale, string $gateway): array
    {
        $email = "buyer-{$this->run}-" . bin2hex(random_bytes(2)) . '@test.local';
        $path = $locale === 'en' ? '/en/checkout/' : '/finalizar-compra/';
        $response = $this->request('POST', $path, [
            'items' => (string) $this->productId, 'name' => 'Ana Prueba', 'email' => $email,
            'document' => '123', 'phone' => '3001234567', 'gateway' => $gateway, 'terms' => '1',
        ]);
        $id = DB::value('SELECT id FROM orders WHERE email = :e', ['e' => $email]);
        return [$response, $id !== null ? OrderService::find((int) $id) : null];
    }

    private function mpWebhook(string $paymentId, string $eventId, ?string $secret = null): Response
    {
        $ts = '1760000000';
        $requestId = 'req-' . $eventId;
        $v1 = hash_hmac('sha256', "id:$paymentId;request-id:$requestId;ts:$ts;", $secret ?? 'mp_test_secret');
        $body = (string) json_encode(['id' => $eventId, 'type' => 'payment', 'action' => 'payment.updated', 'data' => ['id' => $paymentId]]);
        return $this->request('POST', "/webhooks/mercadopago?data.id=$paymentId&type=payment", [], [
            'HTTP_X_SIGNATURE' => "ts=$ts,v1=$v1", 'HTTP_X_REQUEST_ID' => $requestId, 'CONTENT_TYPE' => 'application/json',
        ], $body);
    }

    private function wompiWebhook(string $txId, string $status, int $cents, string $reference, ?string $secret = null): Response
    {
        $timestamp = 1760000000;
        $checksum = hash('sha256', $txId . $status . $cents . $timestamp . ($secret ?? 'test_events_abc'));
        $body = (string) json_encode([
            'event' => 'transaction.updated',
            'data' => ['transaction' => ['id' => $txId, 'status' => $status, 'amount_in_cents' => $cents, 'reference' => $reference, 'currency' => 'COP']],
            'environment' => 'test',
            'signature' => ['properties' => ['transaction.id', 'transaction.status', 'transaction.amount_in_cents'], 'checksum' => strtoupper($checksum)],
            'timestamp' => $timestamp,
            'sent_at' => '2026-10-05T12:00:00.000Z',
        ]);
        return $this->request('POST', '/webhooks/wompi', [], ['CONTENT_TYPE' => 'application/json'], $body);
    }

    private function paypalWebhook(string $eventId, string $type, string $value, string $reference): Response
    {
        $body = (string) json_encode([
            'id' => $eventId, 'event_type' => $type,
            'resource' => [
                'id' => 'CAP-' . $this->run, 'status' => 'COMPLETED', 'custom_id' => $reference,
                'amount' => ['currency_code' => 'USD', 'value' => $value],
                'supplementary_data' => ['related_ids' => ['order_id' => 'PP-' . $this->run]],
            ],
        ]);
        return $this->request('POST', '/webhooks/paypal', [], [
            'CONTENT_TYPE' => 'application/json',
            'HTTP_PAYPAL_AUTH_ALGO' => 'SHA256withRSA', 'HTTP_PAYPAL_CERT_URL' => 'https://api.sandbox.paypal.com/v1/notifications/certs/CERT',
            'HTTP_PAYPAL_TRANSMISSION_ID' => 'tx-' . $eventId, 'HTTP_PAYPAL_TRANSMISSION_SIG' => 'sig', 'HTTP_PAYPAL_TRANSMISSION_TIME' => '2026-10-05T12:00:00Z',
        ], $body);
    }

    private function approvedMail(array $order): ?array
    {
        foreach (array_reverse(Mailer::$sent) as $mail) {
            if ($mail['to'] === $order['email'] && str_contains($mail['html'], '/descarga/')) {
                return $mail;
            }
        }
        return null;
    }

    /** Del correo aprobado a la descarga real del archivo. */
    private function assertDownloadWorks(array $mail): void
    {
        $this->assertMatchesRegularExpression('#/descarga/([a-f0-9]{64})/#', $mail['html']);
        preg_match('#/descarga/([a-f0-9]{64})/#', $mail['html'], $m);
        $response = $this->request('GET', "/descarga/{$m[1]}/");
        $this->assertSame(200, $response->status);
        $this->assertStringContainsString('attachment;', $response->headers['Content-Disposition']);
        $this->assertNotNull($response->streamer);
        $this->assertSame(1, (int) DB::value('SELECT downloads FROM download_grants WHERE token = :t', ['t' => $m[1]]));
    }

    // ------------------------------------------------------------ Mercado Pago

    public function testDisabledGatewaysAreHiddenFromCheckout(): void
    {
        \App\Core\Config::set('GATEWAYS_DISABLED', 'Wompi, paypal');
        try {
            $this->assertSame(['mercadopago'], GatewayResolver::allowed('es'));
            $this->assertSame([], GatewayResolver::allowed('en'));
            $this->assertFalse(GatewayResolver::isAllowed('es', 'wompi'));
        } finally {
            \App\Core\Config::set('GATEWAYS_DISABLED', '');
        }
        $this->assertSame(['mercadopago', 'wompi'], GatewayResolver::allowed('es'));
    }

    public function testMercadoPagoFullFlowValidSignatureApprovesAndDelivers(): void
    {
        [$response, $order] = $this->checkout('es', 'mercadopago');
        $this->assertSame(303, $response->status);
        $this->assertStringStartsWith('https://sandbox.mercadopago.com.co/', $response->headers['Location']);
        $this->assertSame('pending', $order['status']);
        $this->assertSame('COP', $order['currency']);
        $this->assertSame(100000.0, (float) $order['total']);
        $pref = json_decode((string) $this->http->last('#/checkout/preferences#')['body'], true);
        $this->assertSame($order['reference'], $pref['external_reference']);
        $this->assertSame('COP', $pref['items'][0]['currency_id']);

        // El retorno con parámetros en la URL NO aprueba el pedido.
        $this->request('GET', "/pedido/{$order['token']}/?collection_status=approved&status=approved&external_reference={$order['reference']}");
        $this->assertSame('pending', OrderService::find((int) $order['id'])['status']);

        $payment = '9' . random_int(10000000, 99999999);
        $this->http->on('GET', "#/v1/payments/$payment$#", 200, ['id' => (int) $payment, 'status' => 'approved', 'transaction_amount' => 100000, 'currency_id' => 'COP', 'external_reference' => $order['reference']]);
        $res = $this->mpWebhook($payment, "evt-{$this->run}-1");
        $this->assertSame(200, $res->status);
        $this->assertSame('approved', json_decode($res->body, true)['result']);
        $this->assertSame('approved', OrderService::find((int) $order['id'])['status']);
        $mail = $this->approvedMail($order);
        $this->assertNotNull($mail);
        $this->assertStringStartsWith('Pago aprobado', $mail['subject']);
        $this->assertNotEmpty($mail['text']);
        $this->assertDownloadWorks($mail);
        $this->assertSame($this->salesBefore + 1, (int) DB::value('SELECT sales_count FROM products WHERE id = :id', ['id' => $this->productId]));
    }

    public function testMercadoPagoInvalidSignatureIs401(): void
    {
        [, $order] = $this->checkout('es', 'mercadopago');
        $this->http->on('GET', '#/v1/payments/#', 200, ['id' => 1, 'status' => 'approved', 'transaction_amount' => 100000, 'currency_id' => 'COP', 'external_reference' => $order['reference']]);
        $res = $this->mpWebhook('555', "evt-{$this->run}-bad", 'otro_secreto');
        $this->assertSame(401, $res->status);
        $this->assertSame('pending', OrderService::find((int) $order['id'])['status']);
        $this->assertNull($this->http->last('#/v1/payments/#'), 'Con firma inválida no se consulta la API');
    }

    public function testMercadoPagoDuplicateEventIsIdempotent(): void
    {
        [, $order] = $this->checkout('es', 'mercadopago');
        $this->http->on('GET', '#/v1/payments/777$#', 200, ['id' => 777, 'status' => 'approved', 'transaction_amount' => 100000, 'currency_id' => 'COP', 'external_reference' => $order['reference']]);
        $this->assertSame('approved', json_decode($this->mpWebhook('777', "evt-{$this->run}-dup")->body, true)['result']);
        $mails = count(Mailer::$sent);
        $grants = (int) DB::value('SELECT COUNT(*) FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id WHERE oi.order_id = :o', ['o' => (int) $order['id']]);
        $second = $this->mpWebhook('777', "evt-{$this->run}-dup");
        $this->assertSame(200, $second->status);
        $this->assertSame('duplicate', json_decode($second->body, true)['result']);
        $this->assertSame($mails, count(Mailer::$sent));
        $this->assertSame($grants, (int) DB::value('SELECT COUNT(*) FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id WHERE oi.order_id = :o', ['o' => (int) $order['id']]));
        $this->assertSame(1, (int) DB::value('SELECT COUNT(*) FROM payment_events WHERE gateway = "mercadopago" AND event_id = :e', ['e' => "evt-{$this->run}-dup"]));
    }

    public function testMercadoPagoAmountMismatchDoesNotApprove(): void
    {
        [, $order] = $this->checkout('es', 'mercadopago');
        $this->http->on('GET', '#/v1/payments/888$#', 200, ['id' => 888, 'status' => 'approved', 'transaction_amount' => 1000, 'currency_id' => 'COP', 'external_reference' => $order['reference']]);
        $res = $this->mpWebhook('888', "evt-{$this->run}-amt");
        $this->assertSame(200, $res->status);
        $this->assertSame('amount_mismatch', json_decode($res->body, true)['result']);
        $this->assertSame('error', OrderService::find((int) $order['id'])['status']);
        $this->assertNull($this->approvedMail($order));
    }

    // ------------------------------------------------------------ Wompi

    public function testWompiFullFlowValidSignatureApprovesAndDelivers(): void
    {
        [$response, $order] = $this->checkout('es', 'wompi');
        $this->assertSame(303, $response->status);
        $location = $response->headers['Location'];
        $this->assertStringStartsWith('https://checkout.wompi.co/p/?', $location);
        parse_str((string) parse_url($location, PHP_URL_QUERY), $q);
        $this->assertSame('10000000', (string) $q['amount-in-cents']);
        $this->assertSame('COP', $q['currency']);
        $this->assertSame(hash('sha256', $order['reference'] . '10000000COPtest_integrity_abc'), $q['signature:integrity']);

        $tx = "12-{$this->run}-1";
        $this->http->on('GET', "#sandbox\\.wompi\\.co/v1/transactions/$tx$#", 200, ['data' => ['id' => $tx, 'status' => 'APPROVED', 'amount_in_cents' => 10000000, 'currency' => 'COP', 'reference' => $order['reference']]]);
        $res = $this->wompiWebhook($tx, 'APPROVED', 10000000, $order['reference']);
        $this->assertSame(200, $res->status);
        $this->assertSame('approved', json_decode($res->body, true)['result']);
        $mail = $this->approvedMail($order);
        $this->assertNotNull($mail);
        $this->assertDownloadWorks($mail);
    }

    public function testWompiInvalidSignatureIs401(): void
    {
        [, $order] = $this->checkout('es', 'wompi');
        $res = $this->wompiWebhook("12-{$this->run}-x", 'APPROVED', 10000000, $order['reference'], 'secreto_falso');
        $this->assertSame(401, $res->status);
        $this->assertSame('pending', OrderService::find((int) $order['id'])['status']);
    }

    public function testWompiDuplicateEventIsIdempotent(): void
    {
        [, $order] = $this->checkout('es', 'wompi');
        $tx = "12-{$this->run}-dup";
        $this->http->on('GET', "#/v1/transactions/$tx$#", 200, ['data' => ['id' => $tx, 'status' => 'APPROVED', 'amount_in_cents' => 10000000, 'currency' => 'COP', 'reference' => $order['reference']]]);
        $this->assertSame('approved', json_decode($this->wompiWebhook($tx, 'APPROVED', 10000000, $order['reference'])->body, true)['result']);
        $mails = count(Mailer::$sent);
        $res = $this->wompiWebhook($tx, 'APPROVED', 10000000, $order['reference']);
        $this->assertSame('duplicate', json_decode($res->body, true)['result']);
        $this->assertSame($mails, count(Mailer::$sent));
    }

    public function testWompiAmountMismatchDoesNotApprove(): void
    {
        [, $order] = $this->checkout('es', 'wompi');
        $tx = "12-{$this->run}-amt";
        // El cuerpo dice 10.000.000 centavos, pero la API (fuente de verdad) dice otro monto.
        $this->http->on('GET', "#/v1/transactions/$tx$#", 200, ['data' => ['id' => $tx, 'status' => 'APPROVED', 'amount_in_cents' => 150000, 'currency' => 'COP', 'reference' => $order['reference']]]);
        $res = $this->wompiWebhook($tx, 'APPROVED', 10000000, $order['reference']);
        $this->assertSame('amount_mismatch', json_decode($res->body, true)['result']);
        $this->assertSame('error', OrderService::find((int) $order['id'])['status']);
    }

    public function testWompiDeclinedSendsDeclinedMail(): void
    {
        [, $order] = $this->checkout('es', 'wompi');
        $tx = "12-{$this->run}-dec";
        $this->http->on('GET', "#/v1/transactions/$tx$#", 200, ['data' => ['id' => $tx, 'status' => 'DECLINED', 'amount_in_cents' => 10000000, 'currency' => 'COP', 'reference' => $order['reference']]]);
        $this->assertSame('declined', json_decode($this->wompiWebhook($tx, 'DECLINED', 10000000, $order['reference'])->body, true)['result']);
        $last = end(Mailer::$sent);
        $this->assertStringStartsWith('No se aprobó', $last['subject']);
    }

    // ------------------------------------------------------------ PayPal

    public function testPayPalFullFlowCaptureOnReturnAndEnglishMail(): void
    {
        [$response, $order] = $this->checkout('en', 'paypal');
        $this->assertSame(303, $response->status);
        $this->assertStringStartsWith('https://www.sandbox.paypal.com/checkoutnow?token=PP-', $response->headers['Location']);
        $this->assertSame('USD', $order['currency']);
        $this->assertSame(25.0, (float) $order['total']);
        $created = $this->http->last('#/v2/checkout/orders$#');
        $this->assertSame($order['reference'], $created['headers']['PayPal-Request-Id']);
        $body = json_decode((string) $created['body'], true);
        $this->assertSame('USD', $body['purchase_units'][0]['amount']['currency_code']);
        $this->assertSame('25.00', $body['purchase_units'][0]['amount']['value']);
        $this->assertSame($order['reference'], $body['purchase_units'][0]['custom_id']);

        $ppId = 'PP-' . $this->run;
        $this->http->on('POST', "#/v2/checkout/orders/$ppId/capture$#", 201, ['id' => $ppId, 'status' => 'COMPLETED', 'purchase_units' => [[
            'payments' => ['captures' => [['id' => 'CAP-1', 'status' => 'COMPLETED', 'amount' => ['currency_code' => 'USD', 'value' => '25.00'], 'custom_id' => $order['reference']]]],
        ]]]);
        $page = $this->request('GET', "/en/order/{$order['token']}/?token=$ppId&PayerID=ABC");
        $this->assertSame(200, $page->status);
        $this->assertSame('approved', OrderService::find((int) $order['id'])['status']);
        $mail = $this->approvedMail($order);
        $this->assertNotNull($mail);
        $this->assertStringStartsWith('Payment approved', $mail['subject']);
        $this->assertDownloadWorks($mail);
    }

    public function testPayPalWebhookVerifiedByApi(): void
    {
        [, $order] = $this->checkout('en', 'paypal');
        $this->http->on('POST', '#/v1/notifications/verify-webhook-signature$#', 200, ['verification_status' => 'SUCCESS']);
        $res = $this->paypalWebhook("WH-{$this->run}-1", 'PAYMENT.CAPTURE.COMPLETED', '25.00', $order['reference']);
        $this->assertSame(200, $res->status);
        $this->assertSame('approved', json_decode($res->body, true)['result']);
        $verify = json_decode((string) $this->http->last('#verify-webhook-signature#')['body'], true);
        $this->assertSame('WH-TEST', $verify['webhook_id']);
        $this->assertSame("WH-{$this->run}-1", $verify['webhook_event']['id']);

        // Duplicado
        $dup = $this->paypalWebhook("WH-{$this->run}-1", 'PAYMENT.CAPTURE.COMPLETED', '25.00', $order['reference']);
        $this->assertSame('duplicate', json_decode($dup->body, true)['result']);

        // Reembolso: revoca las descargas
        $refund = $this->paypalWebhook("WH-{$this->run}-2", 'PAYMENT.CAPTURE.REFUNDED', '25.00', $order['reference']);
        $this->assertSame('refunded', json_decode($refund->body, true)['result']);
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id WHERE oi.order_id = :o AND g.revoked_at IS NULL', ['o' => (int) $order['id']]));
    }

    public function testPayPalInvalidSignatureIs401(): void
    {
        [, $order] = $this->checkout('en', 'paypal');
        $this->http->on('POST', '#/v1/notifications/verify-webhook-signature$#', 200, ['verification_status' => 'FAILURE']);
        $res = $this->paypalWebhook("WH-{$this->run}-bad", 'PAYMENT.CAPTURE.COMPLETED', '25.00', $order['reference']);
        $this->assertSame(401, $res->status);
        $this->assertSame('pending', OrderService::find((int) $order['id'])['status']);
    }

    public function testPayPalAmountMismatchDoesNotApprove(): void
    {
        [, $order] = $this->checkout('en', 'paypal');
        $this->http->on('POST', '#/v1/notifications/verify-webhook-signature$#', 200, ['verification_status' => 'SUCCESS']);
        $res = $this->paypalWebhook("WH-{$this->run}-amt", 'PAYMENT.CAPTURE.COMPLETED', '2.50', $order['reference']);
        $this->assertSame('amount_mismatch', json_decode($res->body, true)['result']);
        $this->assertSame('error', OrderService::find((int) $order['id'])['status']);
    }

    // ------------------------------------------------------------ Idioma ↔ pasarela

    public function testServerRejectsPayPalForSpanishOrders(): void
    {
        [$response, $order] = $this->checkout('es', 'paypal');
        $this->assertSame(422, $response->status);
        $this->assertNull($order);
    }

    public function testServerRejectsMercadoPagoAndWompiForEnglishOrders(): void
    {
        foreach (['mercadopago', 'wompi'] as $gateway) {
            [$response, $order] = $this->checkout('en', $gateway);
            $this->assertSame(422, $response->status, $gateway);
            $this->assertNull($order, $gateway);
        }
    }

    public function testResolverRejectsWrongCombinations(): void
    {
        $this->assertSame(['mercadopago', 'wompi'], GatewayResolver::allowed('es'));
        $this->assertSame(['paypal'], GatewayResolver::allowed('en'));
        foreach ([['es', 'COP', 'paypal'], ['en', 'USD', 'wompi'], ['en', 'USD', 'mercadopago'], ['es', 'USD', 'wompi']] as [$locale, $currency, $gateway]) {
            try {
                GatewayResolver::assertAllowed(['locale' => $locale, 'currency' => $currency], $gateway);
                $this->fail("Debía rechazar $gateway en $locale/$currency");
            } catch (\DomainException) {
                $this->addToAssertionCount(1);
            }
        }
        $this->expectException(\DomainException::class);
        OrderService::create('es', [$this->productId], ['name' => 'X', 'email' => "x-{$this->run}@test.local"], 'paypal', '127.0.0.1');
    }

    public function testClientCannotSendAmounts(): void
    {
        $email = "price-{$this->run}@test.local";
        $this->request('POST', '/finalizar-compra/', [
            'items' => (string) $this->productId, 'name' => 'Ana', 'email' => $email, 'gateway' => 'wompi', 'terms' => '1',
            'total' => '1', 'price' => '1', 'amount' => '1',
        ]);
        $this->assertSame(100000.0, (float) DB::value('SELECT total FROM orders WHERE email = :e', ['e' => $email]));
    }

    public function testDownloadLimitAndCsrf(): void
    {
        [, $order] = $this->checkout('es', 'wompi');
        $tx = "12-{$this->run}-lim";
        $this->http->on('GET', "#/v1/transactions/$tx$#", 200, ['data' => ['id' => $tx, 'status' => 'APPROVED', 'amount_in_cents' => 10000000, 'currency' => 'COP', 'reference' => $order['reference']]]);
        $this->wompiWebhook($tx, 'APPROVED', 10000000, $order['reference']);
        $token = (string) DB::value('SELECT g.token FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id WHERE oi.order_id = :o', ['o' => (int) $order['id']]);
        for ($i = 0; $i < 5; $i++) {
            $this->assertSame(200, $this->request('GET', "/descarga/$token/")->status);
        }
        $this->assertSame(410, $this->request('GET', "/descarga/$token/")->status);

        // Sin CSRF el pago se rechaza.
        $res = App::handle(Request::create('POST', '/finalizar-compra/', ['items' => (string) $this->productId, 'name' => 'A', 'email' => "csrf-{$this->run}@test.local", 'gateway' => 'wompi', 'terms' => '1']));
        $this->assertSame(419, $res->status);
    }
}
