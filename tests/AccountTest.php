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
use App\Core\Session;
use App\Services\Downloads\DownloadService;
use App\Services\Orders\OrderService;
use App\Services\Payments\Status;
use PHPUnit\Framework\TestCase;

final class AccountTest extends TestCase
{
    private string $csrf;
    private string $email;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM orders');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        Config::set('MAIL_DRIVER', 'array');
        Config::set('PAGE_CACHE', 'false');
        RateLimiter::disable();
        Session::fake();
        Mailer::$sent = [];
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->email = 'account-' . bin2hex(random_bytes(3)) . '@test.local';
    }

    protected function tearDown(): void
    {
        if (isset($this->email)) {
            DB::run('UPDATE products p JOIN order_items oi ON oi.product_id = p.id JOIN orders o ON o.id = oi.order_id SET p.sales_count = GREATEST(p.sales_count - 1, 0) WHERE o.email = :e AND o.status = "approved"', ['e' => $this->email]);
            DB::run('DELETE FROM orders WHERE email = :e', ['e' => $this->email]);
            DB::run('DELETE FROM customers WHERE email = :e', ['e' => $this->email]);
        }
        RateLimiter::disable(false);
    }

    private function post(string $uri, array $data): \App\Core\Response
    {
        return App::handle(Request::create('POST', $uri, $data + ['_csrf' => $this->csrf], [], [Csrf::COOKIE => $this->csrf]));
    }

    public function testMagicLinkLoginListsOrdersAndRegeneratesDownloads(): void
    {
        $productId = (int) DB::value('SELECT id FROM products WHERE wp_id = 409');
        $order = OrderService::create('es', [$productId], ['name' => 'Luis', 'email' => $this->email], 'wompi', '127.0.0.1');
        OrderService::apply('wompi', new Status(Status::APPROVED, 'tx-acc', (float) $order['total'], 'COP', $order['reference'], 'APPROVED'));
        $oldToken = DownloadService::forOrder((int) $order['id'])[0]['token'];

        $response = $this->post('/mi-cuenta/', ['email' => strtoupper($this->email)]);
        $this->assertSame(303, $response->status);
        $mail = end(Mailer::$sent);
        $this->assertSame($this->email, $mail['to']);
        $this->assertMatchesRegularExpression('#/mi-cuenta/acceso/([a-f0-9]{64})/#', $mail['html']);
        preg_match('#/mi-cuenta/acceso/([a-f0-9]{64})/#', $mail['html'], $m);

        $login = App::handle(Request::create('GET', "/mi-cuenta/acceso/{$m[1]}/"));
        $this->assertSame(303, $login->status);
        $page = App::handle(Request::create('GET', '/mi-cuenta/'));
        $this->assertStringContainsString($order['reference'], $page->body);

        // El enlace es de un solo uso.
        Session::forget('customer_id');
        App::handle(Request::create('GET', "/mi-cuenta/acceso/{$m[1]}/"));
        $this->assertNull(Session::get('customer_id'));

        // Regenerar descargas revoca las anteriores.
        Session::set('customer_id', (int) DB::value('SELECT id FROM customers WHERE email = :e', ['e' => $this->email]));
        $this->post('/mi-cuenta/regenerar/' . $order['id'] . '/', []);
        $grants = DownloadService::forOrder((int) $order['id']);
        $this->assertCount(1, $grants);
        $this->assertNotSame($oldToken, $grants[0]['token']);
    }

    public function testUnknownEmailGetsSameMessageAndNoMail(): void
    {
        $response = $this->post('/mi-cuenta/', ['email' => 'nadie-' . bin2hex(random_bytes(3)) . '@test.local']);
        $this->assertSame(303, $response->status);
        $this->assertSame([], Mailer::$sent);
    }

    public function testCartApiValidatesPricesServerSide(): void
    {
        $productId = (int) DB::value('SELECT id FROM products WHERE wp_id = 380');
        $soon = (int) DB::value('SELECT id FROM products WHERE status = "coming_soon" LIMIT 1');
        $body = (string) json_encode(['lang' => 'en', 'items' => [$productId, $soon, 999999]]);
        $res = App::handle(Request::create('POST', '/api/carrito', [], ['CONTENT_TYPE' => 'application/json'], [], $body));
        $data = json_decode($res->body, true);
        $this->assertSame('USD', $data['currency']);
        $this->assertCount(1, $data['items']);
        $this->assertTrue($data['removed']);
        $this->assertSame(25.0, (float) $data['total']);
    }
}
