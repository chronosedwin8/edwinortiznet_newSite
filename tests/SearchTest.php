<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use PHPUnit\Framework\TestCase;

final class SearchTest extends TestCase
{
    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM posts');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        RateLimiter::disable();
        Config::set('PAGE_CACHE', 'false');
    }

    public function testApiGroupsPostsAndProductsAndIsFast(): void
    {
        $start = microtime(true);
        $res = App::handle(Request::create('GET', '/api/buscar?q=correos%20masivos&lang=es'));
        $ms = (microtime(true) - $start) * 1000;
        $this->assertSame(200, $res->status);
        $data = json_decode($res->body, true);
        $this->assertNotEmpty($data['posts']);
        $this->assertNotEmpty($data['products']);
        $this->assertStringStartsWith('/', $data['posts'][0]['url']);
        $this->assertLessThan(150, $ms, 'El buscador debe responder en menos de 150 ms en local');
    }

    public function testEnglishAndShortQueries(): void
    {
        $data = json_decode(App::handle(Request::create('GET', '/api/buscar?q=bulk%20email&lang=en'))->body, true);
        $this->assertNotEmpty($data['posts']);
        $this->assertStringStartsWith('/en/', $data['posts'][0]['url']);
        $data = json_decode(App::handle(Request::create('GET', '/api/buscar?q=qr&lang=es'))->body, true);
        $this->assertNotEmpty($data['posts']);
        $this->assertSame([], json_decode(App::handle(Request::create('GET', '/api/buscar?q=a&lang=es'))->body, true)['posts']);
    }

    public function testSearchPage(): void
    {
        $res = App::handle(Request::create('GET', '/buscar/?q=factura'));
        $this->assertSame(200, $res->status);
        $this->assertStringContainsString('noindex', $res->body);
        $this->assertStringContainsString('factura', mb_strtolower($res->body));
        $this->assertSame(200, App::handle(Request::create('GET', '/en/search/?q=qr'))->status);
    }
}
