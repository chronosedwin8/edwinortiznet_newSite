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
use App\Services\Media\MediaLibrary;
use App\Services\Orders\OrderService;
use App\Services\Payments\Status;
use App\Services\Storage\S3;
use PHPUnit\Framework\TestCase;

/**
 * Archivos en S3: firma de URLs, imágenes públicas, archivos de producto privados y entrega con URL firmada.
 * La red se sustituye por un transporte falso que registra cada petición.
 */
final class StorageTest extends TestCase
{
    /** @var array<int, array{method:string, url:string, headers:array, file:?string}> */
    private array $calls = [];
    private string $run;

    protected function setUp(): void
    {
        Config::set('STORAGE_DISK', 's3');
        Config::set('AWS_S3_BUCKET', 'bucket-prueba');
        Config::set('AWS_S3_REGION', 'us-east-1');
        Config::set('AWS_S3_KEY', 'AKIDPRUEBA');
        Config::set('AWS_S3_SECRET', 'secreto-de-prueba');
        Config::set('AWS_S3_PUBLIC_URL', '');
        Config::set('MAIL_DRIVER', 'array');
        $this->calls = [];
        $this->run = bin2hex(random_bytes(3));
        S3::fake(function (string $method, string $url, array $headers, ?string $file): array {
            $this->calls[] = ['method' => $method, 'url' => $url, 'headers' => $headers, 'file' => $file];
            return ['status' => $method === 'DELETE' ? 204 : 200, 'body' => ''];
        });
    }

    protected function tearDown(): void
    {
        S3::fake(null);
        Config::set('STORAGE_DISK', 'local');
        Config::set('AWS_S3_BUCKET', '');
        if (isset($this->run)) {
            DB::run('DELETE FROM media WHERE original_name LIKE :n', ['n' => "%prueba-s3-{$this->run}%"]);
            DB::run('DELETE FROM product_files WHERE storage_path LIKE :p', ['p' => "%prueba-s3-{$this->run}%"]);
            DB::run('DELETE FROM orders WHERE email LIKE :e', ['e' => "%s3-{$this->run}@test.local"]);
            DB::run('DELETE FROM customers WHERE email LIKE :e', ['e' => "%s3-{$this->run}@test.local"]);
        }
    }

    /** Vector oficial de AWS para URL prefirmadas (documentación de Signature Version 4, GET de test.txt). */
    public function testPresignedUrlMatchesAwsReferenceVector(): void
    {
        Config::set('AWS_S3_BUCKET', 'examplebucket');
        Config::set('AWS_S3_KEY', 'AKIAIOSFODNN7EXAMPLE');
        Config::set('AWS_S3_SECRET', 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY');
        $url = S3::presignedGet('test.txt', 86400, null, gmmktime(0, 0, 0, 5, 24, 2013));
        $this->assertStringStartsWith('https://examplebucket.s3.amazonaws.com/test.txt?X-Amz-Algorithm=AWS4-HMAC-SHA256', $url);
        $this->assertStringEndsWith('&X-Amz-Signature=aeeed9bbccd4d02ee5c0109b86d86835f995330da4c265957d157751f604d404', $url);
    }

    public function testImagesAreUploadedToS3AsPublicObjects(): void
    {
        $tmp = tempnam(sys_get_temp_dir(), 'eo') . '.png';
        $img = imagecreatetruecolor(1000, 500);
        imagepng($img, $tmp);
        $item = MediaLibrary::store(['name' => "prueba-s3-{$this->run}.png", 'tmp_name' => $tmp, 'error' => UPLOAD_ERR_OK, 'size' => filesize($tmp)]);
        @unlink($tmp);

        $this->assertStringStartsWith('https://bucket-prueba.s3.amazonaws.com/uploads/', $item['url']);
        $this->assertStringContainsString('-800.webp 800w', $item['srcset']);
        $puts = array_values(array_filter($this->calls, fn ($c) => $c['method'] === 'PUT'));
        $this->assertCount(2, $puts);
        foreach ($puts as $put) {
            $this->assertSame('public-read', $put['headers']['x-amz-acl'] ?? null);
            $this->assertSame('image/webp', $put['headers']['content-type']);
            $this->assertStringContainsString('immutable', $put['headers']['cache-control']);
            $this->assertStringStartsWith('AWS4-HMAC-SHA256 Credential=AKIDPRUEBA/', $put['headers']['authorization']);
        }
        $this->assertFileDoesNotExist(MediaLibrary::root() . '/uploads/' . gmdate('Y/m') . "/prueba-s3-{$this->run}.webp");
        $this->assertSame($item['id'], MediaLibrary::byPath($item['url'])['id'] ?? null);

        $this->calls = [];
        MediaLibrary::delete($item['id']);
        $this->assertCount(2, array_filter($this->calls, fn ($c) => $c['method'] === 'DELETE'));
    }

    public function testProductFilesArePrivateAndServedWithSignedUrl(): void
    {
        // Subida desde el panel: el archivo va a S3 sin ACL pública y no queda en el servidor.
        RateLimiter::disable();
        Session::fake();
        Csrf::reset();
        $csrf = Csrf::token(Request::create('GET', '/'));
        $adminId = DB::insert('admin_users', ['email' => "admin-s3-{$this->run}@test.local", 'name' => 'Admin', 'password_hash' => password_hash('clave-segura-123', PASSWORD_ARGON2ID)]);
        try {
            $post = fn (string $uri, array $data = [], array $files = []) => App::handle(Request::create('POST', $uri, $data + ['_csrf' => $csrf], [], [Csrf::COOKIE => $csrf], null, $files));
            $post('/admin/acceso/', ['email' => "admin-s3-{$this->run}@test.local", 'password' => 'clave-segura-123']);
            $productId = (int) DB::value('SELECT p.id FROM products p JOIN product_translations t ON t.product_id = p.id AND t.locale = "es" WHERE t.slug = "plantilla-en-excel-de-factura-sencilla-numeracion-automatica"');
            $slug = 'plantilla-en-excel-de-factura-sencilla-numeracion-automatica';
            $tmp = tempnam(sys_get_temp_dir(), 'eo');
            file_put_contents($tmp, "PK\x03\x04 prueba");
            $res = $post("/admin/productos/$productId/archivo/", ['label' => 'Prueba S3'], ['file' => [
                'name' => "prueba-s3-{$this->run}.zip", 'type' => 'application/zip', 'tmp_name' => $tmp, 'error' => UPLOAD_ERR_OK, 'size' => filesize($tmp),
            ]]);
            $this->assertSame(303, $res->status);
            $put = array_values(array_filter($this->calls, fn ($c) => $c['method'] === 'PUT'))[0] ?? null;
            $this->assertNotNull($put);
            $this->assertStringEndsWith("/descargas/$slug/prueba-s3-{$this->run}.zip", $put['url']);
            $this->assertArrayNotHasKey('x-amz-acl', $put['headers']);
            $this->assertFileDoesNotExist(DownloadService::path("$slug/prueba-s3-{$this->run}.zip"));
            $file = DB::one('SELECT * FROM product_files WHERE storage_path = :p', ['p' => "$slug/prueba-s3-{$this->run}.zip"]);
            $this->assertSame('s3', $file['storage_disk']);
        } finally {
            DB::run('DELETE FROM admin_users WHERE id = :id', ['id' => $adminId]);
        }

        // Compra aprobada: el enlace de descarga redirige a una URL firmada de S3 y cuenta la descarga.
        $order = OrderService::create('es', [$productId], ['name' => 'Cliente', 'email' => "cliente-s3-{$this->run}@test.local"], 'wompi', '127.0.0.1');
        OrderService::apply('wompi', new Status(Status::APPROVED, 'tx', (float) $order['total'], 'COP', $order['reference'], 'APPROVED'));
        $grant = DB::one('SELECT g.token, g.downloads FROM download_grants g WHERE g.product_file_id = :f', ['f' => (int) $file['id']]);
        $this->assertNotNull($grant);
        $res = App::handle(Request::create('GET', "/descarga/{$grant['token']}/"));
        $this->assertSame(302, $res->status);
        $location = $res->headers['Location'];
        $this->assertStringStartsWith("https://bucket-prueba.s3.amazonaws.com/descargas/$slug/prueba-s3-{$this->run}.zip?", $location);
        $this->assertStringContainsString('X-Amz-Expires=300', $location);
        $this->assertStringContainsString('response-content-disposition=attachment', $location);
        $this->assertSame(1, (int) DB::value('SELECT downloads FROM download_grants WHERE token = :t', ['t' => $grant['token']]));
        DB::run('UPDATE products p JOIN order_items oi ON oi.product_id = p.id SET p.sales_count = GREATEST(p.sales_count - 1, 0) WHERE oi.order_id = :o', ['o' => (int) $order['id']]);
        Mailer::$sent = [];
    }
}
