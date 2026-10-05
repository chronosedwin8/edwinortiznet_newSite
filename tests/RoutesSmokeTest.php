<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Session;
use PHPUnit\Framework\TestCase;

/**
 * Ninguna ruta pública responde 500 (ES y EN).
 */
final class RoutesSmokeTest extends TestCase
{
    public function testPublicRoutesNeverFail(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM posts');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        RateLimiter::disable();
        Session::fake();
        Config::set('PAGE_CACHE', 'false');
        $family = (string) DB::value('SELECT slug FROM product_family_translations WHERE locale = "es" LIMIT 1');
        $familyEn = (string) DB::value('SELECT slug FROM product_family_translations WHERE locale = "en" LIMIT 1');
        $paths = [
            '/', '/blog/', '/blog/pagina/2/', '/tienda/', '/tienda/?perfil=docente&precio=hasta-20', "/categoria-producto/$family/", '/cursos/',
            '/herramientas/', '/herramientas/generador-qr/', '/herramientas/numero-a-letras/', '/herramientas/simulacro-concurso-docente/',
            '/sobre-mi/', '/contacto/', '/contacto/?enviado=1', '/politicas/privacidad/', '/politicas/terminos/', '/politicas/reembolsos/', '/politicas/cookies/',
            '/carrito/', '/finalizar-compra/', '/mi-cuenta/', '/buscar/', '/buscar/?q=excel', '/feed/', '/sitemap.xml', '/robots.txt',
            '/excel/', '/concurso-docente/', '/ia-para-docentes/',
            '/en/', '/en/blog/', '/en/shop/', "/en/product-category/$familyEn/", '/en/tools/', '/en/tools/qr-code-generator/', '/en/tools/number-to-words/',
            '/en/about/', '/en/contact/', '/en/policies/privacy/', '/en/cart/', '/en/checkout/', '/en/account/', '/en/search/?q=qr', '/en/feed/',
            '/en/excel-automation/', '/en/ai-for-teachers/', '/api/buscar?q=excel', '/webhooks/wompi',
            '/suscripcion/confirmar/' . str_repeat('a', 64) . '/', '/pedido/' . str_repeat('b', 64) . '/', '/descarga/' . str_repeat('c', 64) . '/',
        ];
        foreach ($paths as $path) {
            $response = App::handle(Request::create('GET', $path));
            $this->assertLessThan(500, $response->status, "GET $path → {$response->status}");
            $this->assertNotContains($response->status, [405], "GET $path");
        }
    }
}
