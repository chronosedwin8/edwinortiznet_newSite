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
use App\Core\Session;
use App\Services\Downloads\DownloadService;
use App\Services\Orders\OrderService;
use App\Services\Payments\Status;
use PHPUnit\Framework\TestCase;

/**
 * Fase 7: editar un artículo, crear un producto con archivo y reenviar un pedido. Seguridad del acceso.
 */
final class AdminTest extends TestCase
{
    private string $csrf;
    private string $run;
    private int $adminId;

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM admin_users');
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
        $this->run = bin2hex(random_bytes(3));
        $this->adminId = DB::insert('admin_users', [
            'email' => "admin-{$this->run}@test.local", 'name' => 'Admin prueba',
            'password_hash' => password_hash('clave-segura-123', PASSWORD_ARGON2ID),
        ]);
    }

    protected function tearDown(): void
    {
        if (!isset($this->adminId)) {
            return;
        }
        DB::run('DELETE FROM admin_users WHERE id = :id', ['id' => $this->adminId]);
        $ids = DB::column('SELECT product_id FROM product_translations WHERE slug LIKE :s', ['s' => "producto-prueba-{$this->run}%"]);
        foreach ($ids as $id) {
            DB::run('DELETE FROM products WHERE id = :id', ['id' => (int) $id]);
        }
        @array_map('unlink', glob(DownloadService::path("producto-prueba-{$this->run}") . '/*') ?: []);
        @rmdir(DownloadService::path("producto-prueba-{$this->run}"));
        DB::run('DELETE FROM redirects WHERE source LIKE :s', ['s' => "%prueba-{$this->run}%"]);
        DB::run('UPDATE products p JOIN order_items oi ON oi.product_id = p.id JOIN orders o ON o.id = oi.order_id SET p.sales_count = GREATEST(p.sales_count - 1, 0) WHERE o.email LIKE :e AND o.status = "approved"', ['e' => "%{$this->run}@test.local"]);
        DB::run('DELETE FROM orders WHERE email LIKE :e', ['e' => "%{$this->run}@test.local"]);
        DB::run('DELETE FROM customers WHERE email LIKE :e', ['e' => "%{$this->run}@test.local"]);
        RateLimiter::disable(false);
    }

    private function post(string $uri, array $data = [], array $files = []): Response
    {
        return App::handle(Request::create('POST', $uri, $data + ['_csrf' => $this->csrf], [], [Csrf::COOKIE => $this->csrf], null, $files));
    }

    private function get(string $uri): Response
    {
        return App::handle(Request::create('GET', $uri));
    }

    private function login(): void
    {
        $res = $this->post('/admin/acceso/', ['email' => "admin-{$this->run}@test.local", 'password' => 'clave-segura-123']);
        $this->assertSame(303, $res->status);
        $this->assertSame('/admin/', $res->headers['Location']);
    }

    public function testRequiresLoginAndLocksAfterFailures(): void
    {
        $this->assertSame('/admin/acceso/', $this->get('/admin/')->headers['Location'] ?? null);
        $this->assertSame('/admin/acceso/', $this->get('/admin/pedidos/')->headers['Location'] ?? null);
        for ($i = 0; $i < 5; $i++) {
            $this->assertSame(401, $this->post('/admin/acceso/', ['email' => "admin-{$this->run}@test.local", 'password' => 'mala'])->status);
        }
        // Bloqueada: ni con la clave correcta entra.
        $res = $this->post('/admin/acceso/', ['email' => "admin-{$this->run}@test.local", 'password' => 'clave-segura-123']);
        $this->assertSame(401, $res->status);
        $this->assertNull(Session::get('admin_id'));
        $hash = (string) DB::value('SELECT password_hash FROM admin_users WHERE id = :id', ['id' => $this->adminId]);
        $this->assertStringStartsWith('$argon2id$', $hash);
    }

    public function testCsrfIsRequired(): void
    {
        $this->login();
        $res = App::handle(Request::create('POST', '/admin/ajustes/', ['whatsapp_number' => '1'], [], [Csrf::COOKIE => $this->csrf]));
        $this->assertSame(419, $res->status);
    }

    public function testEditArticle(): void
    {
        $this->login();
        $this->assertSame(200, $this->get('/admin/')->status);
        $post = DB::one('SELECT * FROM posts WHERE locale = "es" AND slug = "como-hacer-listas-desplegables-en-excel"');
        $this->assertSame(200, $this->get("/admin/contenido/{$post['id']}/")->status);
        $original = $post;
        try {
            $res = $this->post("/admin/contenido/{$post['id']}/", [
                'title' => $post['title'], 'slug' => $post['slug'], 'type' => 'post', 'status' => 'published',
                'content_html' => $post['content_html'] . '<p>Párrafo de prueba ' . $this->run . '</p><script>alert(1)</script>',
                'excerpt' => $post['excerpt'], 'seo_title' => 'Listas desplegables en Excel paso a paso | Edwin',
                'seo_description' => $post['seo_description'], 'published_at' => $post['published_at'], 'hub_id' => (string) $post['hub_id'],
            ]);
            $this->assertSame(303, $res->status);
            $saved = DB::one('SELECT * FROM posts WHERE id = :id', ['id' => (int) $post['id']]);
            $this->assertStringContainsString('Párrafo de prueba ' . $this->run, $saved['content_html']);
            $this->assertStringNotContainsString('<script', $saved['content_html']);
            $this->assertSame(0, (int) $saved['seo_auto']);
            $public = $this->get('/como-hacer-listas-desplegables-en-excel/');
            $this->assertStringContainsString('Párrafo de prueba ' . $this->run, $public->body);
            $this->assertStringContainsString('<title>Listas desplegables en Excel paso a paso | Edwin', $public->body);
            // Vista previa
            $preview = $this->post('/admin/vista-previa/', ['title' => 'X', 'content_html' => '<h2>Hola</h2><p>{{productos:destacados}}</p>']);
            $this->assertSame(200, $preview->status);
            $this->assertStringContainsString('product-card', $preview->body);
        } finally {
            $restore = array_intersect_key($original, array_flip(['title', 'content_html', 'content_text', 'excerpt', 'seo_title', 'seo_description', 'seo_auto', 'updated_at', 'reading_minutes']));
            DB::update('posts', $restore, ['id' => (int) $post['id']]);
        }
    }

    public function testCreateProductWithFile(): void
    {
        $this->login();
        $slug = "producto-prueba-{$this->run}";
        $res = $this->post('/admin/productos/nuevo/', [
            'type' => 'download', 'status' => 'active', 'price_usd' => '12', 'price_cop' => '48000', 'audience' => 'oficina',
            'es' => ['title' => 'Producto prueba', 'slug' => $slug, 'short_html' => '<p>Corto</p>', 'description_html' => '<p>Largo</p>', 'faq' => "¿Sirve? | Sí"],
            'en' => ['title' => 'Test product', 'slug' => $slug . '-en', 'short_html' => '<p>Short</p>', 'needs_review' => '1'],
        ]);
        $this->assertSame(303, $res->status);
        $productId = (int) DB::value('SELECT product_id FROM product_translations WHERE slug = :s', ['s' => $slug]);
        $this->assertGreaterThan(0, $productId);
        // Sin archivo: "Disponible pronto"
        $this->assertStringContainsString('waitlist-form', $this->get("/producto/$slug/")->body);

        $tmp = tempnam(sys_get_temp_dir(), 'eo');
        file_put_contents($tmp, "PK\x03\x04 prueba");
        $up = $this->post("/admin/productos/$productId/archivo/", ['label' => 'Plantilla'], ['file' => [
            'name' => 'plantilla.zip', 'type' => 'application/zip', 'tmp_name' => $tmp, 'error' => UPLOAD_ERR_OK, 'size' => filesize($tmp),
        ]]);
        $this->assertSame(303, $up->status);
        $this->assertSame("$slug/plantilla.zip", DB::value('SELECT storage_path FROM product_files WHERE product_id = :p', ['p' => $productId]));
        $this->assertFileExists(DownloadService::path("$slug/plantilla.zip"));
        $page = $this->get("/producto/$slug/")->body;
        $this->assertStringContainsString('data-buy-now', $page);
        $this->assertSame(200, $this->get("/en/product/$slug-en/")->status);

        // Un PHP no se acepta.
        $tmp2 = tempnam(sys_get_temp_dir(), 'eo');
        file_put_contents($tmp2, '<?php echo 1;');
        $this->post("/admin/productos/$productId/archivo/", [], ['file' => ['name' => 'x.php', 'type' => 'text/plain', 'tmp_name' => $tmp2, 'error' => UPLOAD_ERR_OK, 'size' => 13]]);
        $this->assertFileDoesNotExist(DownloadService::path("$slug/x.php"));
        @unlink($tmp2);
    }

    public function testResendOrderAndRegenerate(): void
    {
        $this->login();
        $productId = (int) DB::value('SELECT id FROM products WHERE wp_id = 413');
        $order = OrderService::create('es', [$productId], ['name' => 'Cliente', 'email' => "cliente-{$this->run}@test.local"], 'wompi', '127.0.0.1');
        OrderService::apply('wompi', new Status(Status::APPROVED, 'tx', (float) $order['total'], 'COP', $order['reference'], 'APPROVED'));
        $this->assertSame(200, $this->get("/admin/pedidos/{$order['id']}/")->status);
        $this->assertSame(200, $this->get('/admin/pedidos/?status=approved')->status);
        Mailer::$sent = [];
        $res = $this->post("/admin/pedidos/{$order['id']}/reenviar/");
        $this->assertSame(303, $res->status);
        $this->assertCount(1, Mailer::$sent);
        $this->assertSame("cliente-{$this->run}@test.local", Mailer::$sent[0]['to']);
        $this->assertStringContainsString('/descarga/', Mailer::$sent[0]['html']);
        $before = DownloadService::forOrder((int) $order['id'])[0]['token'];
        $this->post("/admin/pedidos/{$order['id']}/regenerar/");
        $this->assertNotSame($before, DownloadService::forOrder((int) $order['id'])[0]['token']);
    }

    public function testOtherSectionsRender(): void
    {
        $this->login();
        foreach (['/admin/contenido/', '/admin/contenido/?review=1', '/admin/contenido/nuevo/', '/admin/productos/', '/admin/familias/', '/admin/suscriptores/', '/admin/redirecciones/', '/admin/preguntas/', '/admin/ajustes/'] as $path) {
            $this->assertSame(200, $this->get($path)->status, $path);
        }
        $csv = $this->get('/admin/suscriptores/exportar/');
        $this->assertStringContainsString('text/csv', $csv->headers['Content-Type']);
        $res = $this->post('/admin/redirecciones/', ['source' => "/vieja-prueba-{$this->run}/", 'target' => '/blog/', 'match_type' => 'exact', 'code' => '301']);
        $this->assertSame(303, $res->status);
        \App\Services\Seo\Redirects::clear();
        $this->assertSame(301, $this->get("/vieja-prueba-{$this->run}/")->status);
    }
}
