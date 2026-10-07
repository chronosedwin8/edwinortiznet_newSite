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
use App\Models\Product;
use App\Services\Downloads\DownloadService;
use App\Services\Orders\OrderService;
use App\Services\Payments\Status;
use PHPUnit\Framework\TestCase;

/**
 * Variantes de producto (la materia del Kit de IA para docentes): la variante es obligatoria, se valida en el
 * servidor, se guarda en el ítem del pedido y solo se entregan los archivos de esa variante (más los comunes).
 */
final class ProductVariantsTest extends TestCase
{
    private string $run;
    private string $csrf;
    private int $productId;
    private string $slug;
    private string $dir;
    /** @var array<string, int> */
    private array $files = [];

    protected function setUp(): void
    {
        try {
            DB::value('SELECT variant FROM order_items LIMIT 1');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible o sin la migración 015');
        }
        Config::set('MAIL_DRIVER', 'array');
        Config::set('PAGE_CACHE', 'false');
        RateLimiter::disable();
        Mailer::$sent = [];
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->run = bin2hex(random_bytes(4));
        $this->slug = "kit-variantes-prueba-{$this->run}";
        $this->productId = (int) DB::insert('products', ['type' => 'download', 'status' => 'active', 'price_usd' => 15, 'price_cop' => 60000, 'audience' => 'docente']);
        DB::insert('product_translations', ['product_id' => $this->productId, 'locale' => 'es', 'slug' => $this->slug, 'title' => 'Kit de prueba']);
        DB::insert('product_translations', ['product_id' => $this->productId, 'locale' => 'en', 'slug' => $this->slug . '-en', 'title' => 'Test kit']);
        $this->dir = "variantes-prueba-{$this->run}";
        @mkdir(DownloadService::path($this->dir), 0775, true);
        foreach (['comun' => null, 'matematicas' => 'matematicas', 'lenguaje' => 'lenguaje'] as $name => $variant) {
            $relative = "{$this->dir}/$name.zip";
            file_put_contents(DownloadService::path($relative), "contenido $name");
            $this->files[$name] = (int) DB::insert('product_files', [
                'product_id' => $this->productId, 'label' => ucfirst($name), 'variant' => $variant,
                'storage_path' => $relative, 'storage_disk' => 'local', 'bytes' => 20,
            ]);
        }
    }

    protected function tearDown(): void
    {
        if (!isset($this->productId)) {
            return;
        }
        DB::run('DELETE FROM orders WHERE email LIKE :e', ['e' => "variantes-{$this->run}%"]);
        DB::run('DELETE FROM customers WHERE email LIKE :e', ['e' => "variantes-{$this->run}%"]);
        DB::run('DELETE FROM products WHERE id = :id', ['id' => $this->productId]);
        foreach (glob(DownloadService::path($this->dir) . '/*') ?: [] as $file) {
            @unlink($file);
        }
        @rmdir(DownloadService::path($this->dir));
        RateLimiter::disable(false);
    }

    private function request(string $method, string $uri, array $post = [], array $server = [], ?string $body = null): Response
    {
        if ($method === 'POST' && $body === null) {
            $post['_csrf'] = $this->csrf;
        }
        return App::handle(Request::create($method, $uri, $post, $server, [Csrf::COOKIE => $this->csrf], $body));
    }

    private function email(): string
    {
        return "variantes-{$this->run}-" . bin2hex(random_bytes(2)) . '@test.local';
    }

    public function testVariantsComeFromFilesWithTranslatedNames(): void
    {
        $this->assertSame(['lenguaje' => 'Lengua Castellana', 'matematicas' => 'Matemáticas'], Product::variants($this->productId, 'es'));
        $this->assertSame(['matematicas' => 'Mathematics', 'lenguaje' => 'Spanish Language Arts'], Product::variants($this->productId, 'en'));
        $this->assertSame(2, (int) Product::find($this->productId, 'es')['variant_count']);
        // Un producto sin archivos de variante no tiene variantes.
        $plain = (int) DB::value('SELECT id FROM products WHERE wp_id = 380');
        $this->assertSame([], Product::variants($plain, 'es'));
    }

    public function testCartRequiresAValidVariantAndKeepsOneLinePerVariant(): void
    {
        $id = $this->productId;
        $cart = OrderService::cart('es', ["$id", "$id:fisica", "$id:matematicas", "$id:lenguaje", "$id:MATEMATICAS", "$id:<script>"]);
        $this->assertCount(2, $cart['items'], 'Dos materias = dos líneas; sin variante o con una inexistente se descarta');
        $this->assertSame(["$id:matematicas", "$id:lenguaje"], array_column($cart['items'], 'line_key'));
        $this->assertSame('Kit de prueba — Matemáticas', $cart['items'][0]['title']);
        $this->assertSame('Kit de prueba', $cart['items'][0]['product_title']);
        $this->assertSame('lenguaje', $cart['items'][1]['variant']);
        $this->assertTrue($cart['removed']);
        $this->assertSame([$id], array_map(fn ($p) => (int) $p['id'], $cart['needs_variant']));
        $this->assertSame(120000.0, $cart['total']);

        // Productos sin variantes: igual que siempre (ids enteros, sin duplicados).
        $plain = (int) DB::value('SELECT id FROM products WHERE wp_id = 380');
        $cart = OrderService::cart('es', [$plain, (string) $plain]);
        $this->assertCount(1, $cart['items']);
        $this->assertNull($cart['items'][0]['variant']);
        $this->assertSame((string) $plain, $cart['items'][0]['line_key']);
        $this->assertSame([], $cart['needs_variant']);
    }

    public function testCartApiReturnsLineKeys(): void
    {
        $id = $this->productId;
        $body = (string) json_encode(['lang' => 'es', 'items' => ["$id:matematicas", "$id:lenguaje", (string) $id]]);
        $res = $this->request('POST', '/api/carrito', [], ['CONTENT_TYPE' => 'application/json'], $body);
        $data = json_decode($res->body, true);
        $this->assertSame(["$id:matematicas", "$id:lenguaje"], array_column($data['items'], 'key'));
        $this->assertSame('Kit de prueba — Lengua Castellana', $data['items'][1]['title']);
        $this->assertTrue($data['removed']);
        $this->assertCount(1, $data['needs_variant']);
    }

    public function testProductPageShowsRequiredSubjectSelector(): void
    {
        $res = $this->request('GET', "/producto/{$this->slug}/");
        $this->assertSame(200, $res->status);
        $this->assertStringContainsString('data-variant-form', $res->body);
        $this->assertMatchesRegularExpression('#<input type="radio" name="items" value="' . $this->productId . ':matematicas" required#', $res->body);
        $this->assertStringContainsString('data-requires-variant="1"', $res->body);
        $this->assertStringContainsString('form="buy-form"', $res->body);
        // Sin variantes, la ficha conserva el enlace directo de compra.
        $plainSlug = (string) DB::value('SELECT t.slug FROM product_translations t JOIN products p ON p.id = t.product_id WHERE p.wp_id = 380 AND t.locale = "es"');
        $plain = $this->request('GET', "/producto/$plainSlug/");
        $this->assertStringNotContainsString('data-variant-form', $plain->body);
        $this->assertMatchesRegularExpression('#href="/finalizar-compra/\?items=\d+" data-buy-now#', $plain->body);
    }

    public function testCheckoutWithoutVariantOrWithInvalidVariantCreatesNoOrder(): void
    {
        foreach ([(string) $this->productId, "{$this->productId}:fisica"] as $items) {
            $email = $this->email();
            $res = $this->request('POST', '/finalizar-compra/', [
                'items' => $items, 'name' => 'Ana Prueba', 'email' => $email, 'gateway' => 'wompi', 'terms' => '1',
            ]);
            $this->assertSame(422, $res->status);
            $this->assertNull(DB::value('SELECT id FROM orders WHERE email = :e', ['e' => $email]));
        }
        $page = $this->request('GET', '/finalizar-compra/?items=' . $this->productId);
        $this->assertStringContainsString(e(t('checkout.needs_variant', [], 'es')), $page->body);
        $this->assertStringContainsString("/producto/{$this->slug}/#buy", $page->body);

        $page = $this->request('GET', '/finalizar-compra/?items=' . rawurlencode("{$this->productId}:matematicas"));
        $this->assertStringContainsString('name="items" value="' . $this->productId . ':matematicas"', $page->body);
        $this->assertStringContainsString('Kit de prueba — Matemáticas', $page->body);
    }

    public function testAdminUploadStoresSanitizedVariantAndKeepsItOnReplace(): void
    {
        \App\Core\Session::fake();
        $disk = (string) Config::get('STORAGE_DISK', 'local');
        Config::set('STORAGE_DISK', 'local');
        $adminId = DB::insert('admin_users', [
            'email' => "variantes-{$this->run}@test.local", 'name' => 'Admin prueba',
            'password_hash' => password_hash('clave-segura-123', PASSWORD_ARGON2ID),
        ]);
        try {
            $this->assertSame(303, $this->request('POST', '/admin/acceso/', ['email' => "variantes-{$this->run}@test.local", 'password' => 'clave-segura-123'])->status);
            $upload = function (array $post): Response {
                $tmp = tempnam(sys_get_temp_dir(), 'kv');
                file_put_contents($tmp, 'zip de prueba');
                $file = ['name' => 'sociales.zip', 'type' => 'application/zip', 'tmp_name' => $tmp, 'error' => UPLOAD_ERR_OK, 'size' => 13];
                return App::handle(Request::create('POST', "/admin/productos/{$this->productId}/archivo/", $post + ['_csrf' => $this->csrf], [], [Csrf::COOKIE => $this->csrf], null, ['file' => $file]));
            };
            $upload(['label' => 'Ciencias Sociales', 'variant' => ' Sociales! ']);
            $fileId = (int) DB::value('SELECT id FROM product_files WHERE product_id = :p AND label = "Ciencias Sociales"', ['p' => $this->productId]);
            $this->assertSame('sociales', DB::value('SELECT variant FROM product_files WHERE id = :id', ['id' => $fileId]));
            // Reemplazar sin indicar variante conserva la que tenía.
            $upload(['label' => 'Ciencias Sociales', 'replace_id' => (string) $fileId]);
            $this->assertSame('sociales', DB::value('SELECT variant FROM product_files WHERE id = :id', ['id' => $fileId]));
            $this->assertArrayHasKey('sociales', Product::variants($this->productId, 'es'));
            $edit = $this->request('GET', "/admin/productos/{$this->productId}/");
            $this->assertStringContainsString('name="variant"', $edit->body);
            $this->assertStringContainsString('<option value="sociales">', $edit->body);
        } finally {
            Config::set('STORAGE_DISK', $disk);
            DB::run('DELETE FROM admin_users WHERE id = :id', ['id' => $adminId]);
            @unlink(DownloadService::path("{$this->slug}/sociales.zip"));
            @rmdir(DownloadService::path($this->slug));
        }
    }

    public function testOrderStoresVariantAndGrantsOnlyItsFiles(): void
    {
        $id = $this->productId;
        $order = OrderService::create('es', ["$id:matematicas", "$id:lenguaje"], ['name' => 'Ana', 'email' => $this->email()], 'wompi', '127.0.0.1');
        $this->assertCount(2, $order['items']);
        $this->assertSame(['matematicas', 'lenguaje'], array_column($order['items'], 'variant'));
        $this->assertSame(['Matemáticas', 'Lengua Castellana'], array_column($order['items'], 'variant_label'));
        $this->assertSame('Kit de prueba — Matemáticas', $order['items'][0]['title']);
        $this->assertSame(120000.0, (float) $order['total']);
        $this->assertSame(["$id:matematicas", "$id:lenguaje"], OrderService::itemLines($order));

        $single = OrderService::create('es', ["$id:matematicas"], ['name' => 'Ana', 'email' => $this->email()], 'wompi', '127.0.0.1');
        $result = OrderService::apply('wompi', new Status(Status::APPROVED, 'tx-' . $this->run, 60000.0, 'COP', $single['reference']));
        $this->assertSame('approved', $result['result']);
        $granted = DB::column(
            'SELECT g.product_file_id FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id WHERE oi.order_id = :o ORDER BY g.product_file_id',
            ['o' => (int) $single['id']]
        );
        $this->assertSame([$this->files['comun'], $this->files['matematicas']], array_map('intval', $granted));

        // El correo de aprobación nombra la materia y trae sus dos enlaces de descarga.
        $mail = null;
        foreach (Mailer::$sent as $sent) {
            if ($sent['to'] === $single['email'] && str_contains($sent['html'], '/descarga/')) {
                $mail = $sent;
            }
        }
        $this->assertNotNull($mail);
        $this->assertStringContainsString('Kit de prueba — Matemáticas', $mail['html']);
        $this->assertSame(2, preg_match_all('#/descarga/[a-f0-9]{64}/#', $mail['html']));

        // Regenerar descargas no entrega la otra materia.
        DownloadService::createGrants((int) $single['id'], true);
        $active = DB::column(
            'SELECT g.product_file_id FROM download_grants g JOIN order_items oi ON oi.id = g.order_item_id WHERE oi.order_id = :o AND g.revoked_at IS NULL',
            ['o' => (int) $single['id']]
        );
        $this->assertNotContains($this->files['lenguaje'], array_map('intval', $active));
    }
}
