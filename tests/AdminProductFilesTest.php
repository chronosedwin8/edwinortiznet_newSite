<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\Csrf;
use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;
use App\Services\Downloads\DownloadService;
use PHPUnit\Framework\TestCase;

/**
 * Panel → producto → archivos: el administrador ve y descarga cualquier archivo (todas las variantes)
 * sin consumir descargas de pedidos. Local en streaming; S3 con redirección a una URL firmada.
 */
final class AdminProductFilesTest extends TestCase
{
    private string $csrf;
    private string $run;
    private int $adminId;
    private int $productId;
    private int $fileId;
    private string $dir;
    /** @var array<string, mixed> */
    private array $s3Config = [];

    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM admin_users');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        Config::set('PAGE_CACHE', 'false');
        Config::set('DOWNLOAD_ACCEL', 'false');
        RateLimiter::disable();
        Session::fake();
        Csrf::reset();
        $this->csrf = Csrf::token(Request::create('GET', '/'));
        $this->run = bin2hex(random_bytes(3));
        $this->adminId = DB::insert('admin_users', [
            'email' => "admin-files-{$this->run}@test.local", 'name' => 'Admin archivos',
            'password_hash' => password_hash('clave-segura-123', PASSWORD_ARGON2ID),
        ]);
        $this->productId = DB::insert('products', ['type' => 'download', 'status' => 'hidden', 'price_usd' => 1, 'price_cop' => 4000]);
        DB::insert('product_translations', ['product_id' => $this->productId, 'locale' => 'es', 'slug' => "archivos-prueba-{$this->run}", 'title' => 'Archivos de prueba']);
        $this->dir = "archivos-prueba-{$this->run}";
        $path = DownloadService::path($this->dir . '/kit-matematicas.zip');
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }
        file_put_contents($path, str_repeat('PK-contenido-de-prueba ', 40));
        $this->fileId = DB::insert('product_files', [
            'product_id' => $this->productId, 'label' => 'Matemáticas', 'variant' => 'matematicas',
            'storage_path' => $this->dir . '/kit-matematicas.zip', 'storage_disk' => 'local', 'bytes' => filesize($path), 'version' => '2026.10.08',
        ]);
        foreach (['AWS_S3_BUCKET', 'AWS_S3_KEY', 'AWS_S3_SECRET', 'AWS_S3_REGION'] as $key) {
            $this->s3Config[$key] = Config::get($key);
        }
    }

    protected function tearDown(): void
    {
        if (!isset($this->adminId)) {
            return;
        }
        foreach ($this->s3Config as $key => $value) {
            Config::set($key, (string) ($value ?? ''));
        }
        DB::run('DELETE FROM admin_users WHERE id = :id', ['id' => $this->adminId]);
        DB::run('DELETE FROM products WHERE id = :id', ['id' => $this->productId]);
        @array_map('unlink', glob(DownloadService::path($this->dir) . '/*') ?: []);
        @rmdir(DownloadService::path($this->dir));
        RateLimiter::disable(false);
    }

    private function get(string $uri): Response
    {
        return App::handle(Request::create('GET', $uri));
    }

    private function login(): void
    {
        $res = App::handle(Request::create('POST', '/admin/acceso/', [
            'email' => "admin-files-{$this->run}@test.local", 'password' => 'clave-segura-123', '_csrf' => $this->csrf,
        ], [], [Csrf::COOKIE => $this->csrf]));
        $this->assertSame(303, $res->status);
    }

    private function url(int $file, ?int $product = null): string
    {
        return '/admin/productos/' . ($product ?? $this->productId) . "/archivos/$file/";
    }

    public function testRequiresAdminSession(): void
    {
        $res = $this->get($this->url($this->fileId));
        $this->assertSame(303, $res->status);
        $this->assertSame('/admin/acceso/', $res->headers['Location'] ?? null);
        $this->assertNull($res->streamer);
    }

    public function testUnknownFileOrOtherProductIs404(): void
    {
        $this->login();
        $this->assertSame(404, $this->get($this->url($this->fileId + 1000000))->status);
        // El archivo existe, pero no es de ese producto.
        $other = (int) DB::value('SELECT id FROM products WHERE id <> :p ORDER BY id LIMIT 1', ['p' => $this->productId]);
        $this->assertSame(404, $this->get($this->url($this->fileId, $other))->status);
    }

    public function testStreamsLocalFileWithoutTouchingGrants(): void
    {
        $this->login();
        $grants = (int) DB::value('SELECT COALESCE(SUM(downloads), 0) FROM download_grants');
        $res = $this->get($this->url($this->fileId));
        $this->assertSame(200, $res->status);
        $this->assertStringContainsString('attachment;', $res->headers['Content-Disposition']);
        $this->assertStringContainsString('kit-matematicas.zip', $res->headers['Content-Disposition']);
        $this->assertSame((string) filesize(DownloadService::path($this->dir . '/kit-matematicas.zip')), $res->headers['Content-Length']);
        $this->assertSame('private, no-store', $res->headers['Cache-Control']);
        $this->assertNotNull($res->streamer);
        $this->assertSame($grants, (int) DB::value('SELECT COALESCE(SUM(downloads), 0) FROM download_grants'));
    }

    public function testMissingLocalFileGoesBackWithError(): void
    {
        $this->login();
        unlink(DownloadService::path($this->dir . '/kit-matematicas.zip'));
        $res = $this->get($this->url($this->fileId));
        $this->assertSame(303, $res->status);
        $this->assertSame("/admin/productos/{$this->productId}/", $res->headers['Location']);
        $this->assertStringStartsWith('!', (string) Session::flash('admin'));
    }

    public function testS3FileRedirectsToPresignedUrl(): void
    {
        Config::set('AWS_S3_BUCKET', 'bucket-prueba');
        Config::set('AWS_S3_REGION', 'us-east-1');
        Config::set('AWS_S3_KEY', 'AKIDPRUEBA');
        Config::set('AWS_S3_SECRET', 'secreto-de-prueba');
        DB::update('product_files', ['storage_disk' => 's3'], ['id' => $this->fileId]);
        $this->login();
        $res = $this->get($this->url($this->fileId));
        $this->assertSame(302, $res->status);
        $location = (string) ($res->headers['Location'] ?? '');
        $this->assertStringContainsString('bucket-prueba', $location);
        $this->assertStringContainsString(DownloadService::S3_PREFIX . $this->dir . '/kit-matematicas.zip', rawurldecode($location));
        $this->assertStringContainsString('X-Amz-Signature=', $location);
    }

    public function testEditPageListsEveryVariantWithDownloadAndReplace(): void
    {
        $second = DB::insert('product_files', [
            'product_id' => $this->productId, 'label' => 'Inglés', 'variant' => 'ingles',
            'storage_path' => $this->dir . '/kit-ingles.zip', 'storage_disk' => 'local', 'bytes' => 10, 'version' => '2026.10.01',
        ]);
        $this->login();
        $res = $this->get("/admin/productos/{$this->productId}/?reemplazar=$second");
        $this->assertSame(200, $res->status);
        $this->assertStringContainsString('Matemáticas', $res->body);
        $this->assertStringContainsString('ingles', $res->body);
        // Solo el archivo que existe se puede descargar; el que falta se marca.
        $this->assertStringContainsString($this->url($this->fileId), $res->body);
        $this->assertStringNotContainsString($this->url($second), $res->body);
        $this->assertStringContainsString('No se encuentra', $res->body);
        // «Reemplazar» deja elegido ese archivo con su nombre y variante.
        $this->assertMatchesRegularExpression('/<option value="' . $second . '" selected>/', $res->body);
        $this->assertStringContainsString('name="variant" maxlength="40" list="up-variants" aria-describedby="up-variant-hint" value="ingles"', $res->body);
    }
}
