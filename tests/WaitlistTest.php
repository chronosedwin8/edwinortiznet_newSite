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
use App\Services\Content\AntiSpam;
use App\Services\Waitlist;
use PHPUnit\Framework\TestCase;

final class WaitlistTest extends TestCase
{
    private string $csrf;
    private int $productId = 0;
    private string $slug;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT notified_at FROM waitlist LIMIT 1');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible o sin migrar');
        }
        Config::set('MAIL_DRIVER', 'array');
        Config::set('ADMIN_EMAIL', 'admin@test.local');
        RateLimiter::disable();
        Mailer::$sent = [];
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->slug = 'espera-' . bin2hex(random_bytes(3));
        $this->productId = (int) DB::insert('products', ['type' => 'course', 'status' => 'coming_soon', 'price_usd' => 10, 'price_cop' => 40000]);
        DB::insert('product_translations', ['product_id' => $this->productId, 'locale' => 'es', 'slug' => $this->slug, 'title' => 'Curso de prueba']);
        DB::insert('product_translations', ['product_id' => $this->productId, 'locale' => 'en', 'slug' => $this->slug . '-en', 'title' => 'Test course']);
    }

    protected function tearDown(): void
    {
        if ($this->productId > 0) {
            DB::run('DELETE FROM products WHERE id = :id', ['id' => $this->productId]);
        }
        RateLimiter::disable(false);
    }

    private function join(string $uri, string $email): \App\Core\Response
    {
        $data = ['email' => $email, 'product_id' => $this->productId, '_csrf' => $this->csrf, '_ts' => AntiSpam::stamp(time() - 5), 'website' => ''];
        return App::handle(Request::create('POST', $uri, $data, ['HTTP_ACCEPT' => 'application/json'], [Csrf::COOKIE => $this->csrf]));
    }

    public function testJoinSendsConfirmationAndAdminNotice(): void
    {
        $res = $this->join('/lista-de-espera/', 'Lector@Test.local');
        $this->assertSame(200, $res->status);
        $this->assertTrue(json_decode($res->body, true)['ok']);
        $this->assertSame('lector@test.local', DB::value('SELECT email FROM waitlist WHERE product_id = :p', ['p' => $this->productId]));
        $this->assertCount(2, Mailer::$sent);
        [$confirm, $admin] = Mailer::$sent;
        $this->assertSame('lector@test.local', $confirm['to']);
        $this->assertStringContainsString('Curso de prueba', $confirm['subject']);
        $this->assertStringContainsString("/producto/{$this->slug}/", $confirm['html']);
        $this->assertSame('admin@test.local', $admin['to']);
        $this->assertStringContainsString('lector@test.local', $admin['html']);

        // Repetir el registro vuelve a confirmar, pero no duplica la fila ni el aviso al administrador.
        Mailer::$sent = [];
        $this->join('/lista-de-espera/', 'lector@test.local');
        $this->assertSame(1, (int) DB::value('SELECT COUNT(*) FROM waitlist WHERE product_id = :p', ['p' => $this->productId]));
        $this->assertCount(1, Mailer::$sent);
    }

    public function testNotifiesEachLocaleOnceWhenAvailable(): void
    {
        $this->join('/lista-de-espera/', 'es@test.local');
        $this->join('/en/waitlist/', 'en@test.local');
        $this->assertStringContainsString('waiting list', Mailer::$sent[2]['html']);
        Mailer::$sent = [];

        // Todavía no se puede comprar: nadie recibe aviso.
        $this->assertSame(0, Waitlist::notifyIfAvailable($this->productId));

        DB::update('products', ['status' => 'active'], ['id' => $this->productId]);
        $this->assertSame(2, Waitlist::notifyIfAvailable($this->productId));
        $byTo = array_column(Mailer::$sent, null, 'to');
        $this->assertStringContainsString("/producto/{$this->slug}/", $byTo['es@test.local']['html']);
        $this->assertStringStartsWith('Ya está disponible', $byTo['es@test.local']['subject']);
        $this->assertStringContainsString("/en/product/{$this->slug}-en/", $byTo['en@test.local']['html']);
        $this->assertSame(0, (int) DB::value('SELECT COUNT(*) FROM waitlist WHERE product_id = :p AND notified_at IS NULL', ['p' => $this->productId]));

        // Una segunda vez no repite los avisos.
        $this->assertSame(0, Waitlist::notifyIfAvailable($this->productId));
    }
}
