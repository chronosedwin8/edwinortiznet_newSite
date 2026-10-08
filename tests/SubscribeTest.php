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
use PHPUnit\Framework\TestCase;

final class SubscribeTest extends TestCase
{
    private string $csrf;
    private string $email;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM subscribers');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        Config::set('MAIL_DRIVER', 'array');
        RateLimiter::disable();
        Mailer::$sent = [];
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->email = 'sub-' . bin2hex(random_bytes(3)) . '@test.local';
    }

    protected function tearDown(): void
    {
        if (isset($this->email)) {
            DB::run('DELETE FROM subscribers WHERE email = :e', ['e' => $this->email]);
        }
        RateLimiter::disable(false);
    }

    private function post(string $uri, array $data, bool $json = true, ?int $ts = null): \App\Core\Response
    {
        $data += ['_csrf' => $this->csrf, '_ts' => AntiSpam::stamp($ts ?? time() - 5), 'website' => ''];
        $server = $json ? ['HTTP_ACCEPT' => 'application/json'] : [];
        return App::handle(Request::create('POST', $uri, $data, $server, [Csrf::COOKIE => $this->csrf]));
    }

    public function testDoubleOptIn(): void
    {
        $res = $this->post('/suscripcion/', ['email' => $this->email, 'source' => 'home', 'tag' => 'excel']);
        $this->assertSame(200, $res->status);
        $this->assertTrue(json_decode($res->body, true)['ok']);
        $this->assertNull(DB::value('SELECT confirmed_at FROM subscribers WHERE email = :e', ['e' => $this->email]));
        preg_match('#/suscripcion/confirmar/([a-f0-9]{64})/#', end(Mailer::$sent)['html'], $m);
        $this->assertNotEmpty($m);
        // Abrir el enlace (como hacen los filtros de correo) no confirma: hace falta pulsar el botón.
        $page = App::handle(Request::create('GET', "/suscripcion/confirmar/{$m[1]}/"));
        $this->assertSame(200, $page->status);
        $this->assertStringContainsString('method="post"', $page->body);
        $this->assertNull(DB::value('SELECT confirmed_at FROM subscribers WHERE email = :e', ['e' => $this->email]));
        $this->assertSame(200, $this->post("/suscripcion/confirmar/{$m[1]}/", [], false)->status);
        $this->assertNotNull(DB::value('SELECT confirmed_at FROM subscribers WHERE email = :e', ['e' => $this->email]));
        $this->assertSame(200, App::handle(Request::create('GET', "/suscripcion/baja/{$m[1]}/"))->status);
        $this->assertNotNull(DB::value('SELECT unsubscribed_at FROM subscribers WHERE email = :e', ['e' => $this->email]));
    }

    public function testHoneypotAndTooFastSubmissionsAreRejected(): void
    {
        $this->assertSame(422, $this->post('/suscripcion/', ['email' => $this->email, 'website' => 'http://spam'])->status);
        $this->assertSame(422, $this->post('/suscripcion/', ['email' => $this->email], true, time())->status);
        $this->assertNull(DB::value('SELECT id FROM subscribers WHERE email = :e', ['e' => $this->email]));
    }
}
