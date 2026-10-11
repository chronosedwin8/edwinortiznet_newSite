<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Cache;
use App\Core\Config;
use App\Core\DB;
use App\Core\Request;
use App\Services\Storage\PublicDownloads;
use App\Services\Storage\S3;
use PHPUnit\Framework\TestCase;

/**
 * Archivos gratuitos (/descargas/…): viven en S3 bajo recursos/, el sitio redirige al objeto público y
 * downloads:publish sube solo lo que falta o cambió. La red se sustituye por un transporte falso.
 */
final class PublicDownloadsTest extends TestCase
{
    /** @var array<int, array{method:string, url:string, headers:array, file:?string}> */
    private array $calls = [];
    /** @var array<string, string> clave => sha256 de lo que "hay" en el bucket */
    private array $bucket = [];
    private string $dir;

    protected function setUp(): void
    {
        Config::set('STORAGE_DISK', 's3');
        Config::set('AWS_S3_BUCKET', 'bucket-prueba');
        Config::set('AWS_S3_REGION', 'us-east-1');
        Config::set('AWS_S3_KEY', 'AKIDPRUEBA');
        Config::set('AWS_S3_SECRET', 'secreto-de-prueba');
        Config::set('AWS_S3_PUBLIC_URL', 'https://bucket-prueba.s3.amazonaws.com');
        $this->calls = [];
        $this->bucket = [];
        S3::fake(function (string $method, string $url, array $headers, ?string $file): array {
            $this->calls[] = ['method' => $method, 'url' => $url, 'headers' => $headers, 'file' => $file];
            $key = rawurldecode(substr((string) parse_url($url, PHP_URL_PATH), 1));
            if ($method === 'PUT') {
                $this->bucket[$key] = $headers['x-amz-meta-sha256'] ?? '';
                $this->bucket[$key . '#size'] = (string) filesize((string) $file);
                return ['status' => 200, 'body' => ''];
            }
            if ($method === 'HEAD') {
                return isset($this->bucket[$key])
                    ? ['status' => 200, 'body' => '', 'headers' => ['x-amz-meta-sha256' => $this->bucket[$key], 'content-length' => $this->bucket[$key . '#size']]]
                    : ['status' => 404, 'body' => ''];
            }
            return ['status' => 200, 'body' => ''];
        });
        $this->dir = sys_get_temp_dir() . '/eo-descargas-' . bin2hex(random_bytes(3));
        mkdir($this->dir . '/bloom-ia', 0777, true);
        file_put_contents($this->dir . '/bloom-ia/banco.xlsx', 'libro de prueba');
        file_put_contents($this->dir . '/bloom-ia/script.py', "print('hola')\n");
        mkdir($this->dir . '/bloom-ia/__pycache__');
        file_put_contents($this->dir . '/bloom-ia/__pycache__/script.cpython-314.pyc', 'x');
        PublicDownloads::setManifest(PublicDownloads::scan($this->dir));
        Cache::flushPages();
    }

    protected function tearDown(): void
    {
        S3::fake(null);
        PublicDownloads::setManifest(null);
        Config::set('STORAGE_DISK', 'local');
        Config::set('AWS_S3_BUCKET', '');
        Config::set('AWS_S3_PUBLIC_URL', '');
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->dir, \FilesystemIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($it as $f) {
            $f->isDir() ? rmdir($f->getPathname()) : unlink($f->getPathname());
        }
        rmdir($this->dir);
        DB::run('DELETE FROM not_found_log WHERE path LIKE "/descargas/%"');
    }

    public function testScanSkipsPythonCachesAndUnknownExtensions(): void
    {
        $manifest = PublicDownloads::manifest();
        $this->assertSame(['bloom-ia/banco.xlsx', 'bloom-ia/script.py'], array_keys($manifest));
        $this->assertSame(hash('sha256', 'libro de prueba'), $manifest['bloom-ia/banco.xlsx']['sha256']);
        $this->assertSame(15, $manifest['bloom-ia/banco.xlsx']['size']);
    }

    public function testNormalizeRejectsTraversalAndHiddenFiles(): void
    {
        $this->assertSame('bloom-ia/banco.xlsx', PublicDownloads::normalize('bloom-ia/banco.xlsx'));
        $this->assertNull(PublicDownloads::normalize('../.env'));
        $this->assertNull(PublicDownloads::normalize('bloom-ia/../../.env'));
        $this->assertNull(PublicDownloads::normalize('bloom-ia/%2e%2e/x.xlsx'));
        $this->assertNull(PublicDownloads::normalize('.git/config'));
        $this->assertNull(PublicDownloads::normalize('x/script.php'));
    }

    public function testPublishedFileRedirectsToS3(): void
    {
        $res = App::handle(Request::create('GET', '/descargas/bloom-ia/banco.xlsx'));
        $this->assertSame(302, $res->status);
        $this->assertSame('https://bucket-prueba.s3.amazonaws.com/recursos/bloom-ia/banco.xlsx', $res->headers['Location']);
    }

    public function testUnknownFileIs404(): void
    {
        $this->assertSame(404, App::handle(Request::create('GET', '/descargas/bloom-ia/no-existe.xlsx'))->status);
        $this->assertSame(404, App::handle(Request::create('GET', '/descargas/..%2F.env'))->status);
    }

    public function testWithoutS3TheLocalCopyIsServed(): void
    {
        Config::set('AWS_S3_BUCKET', '');
        PublicDownloads::setManifest([]);
        $local = Config::root(PublicDownloads::LOCAL_DIR . '/prueba-local-' . bin2hex(random_bytes(3)) . '.csv');
        @mkdir(dirname($local), 0777, true);
        file_put_contents($local, "a,b\n1,2\n");
        try {
            $res = App::handle(Request::create('GET', '/descargas/' . basename($local)));
            $this->assertSame(200, $res->status);
            $this->assertSame("a,b\n1,2\n", $res->body);
            $this->assertStringContainsString('attachment', $res->headers['Content-Disposition']);
        } finally {
            unlink($local);
        }
    }

    public function testPublishUploadsOnlyMissingOrChangedFiles(): void
    {
        $log = [];
        $first = PublicDownloads::publish($this->dir, function (string $l) use (&$log): void {
            $log[] = $l;
        });
        $this->assertSame(['bloom-ia/banco.xlsx', 'bloom-ia/script.py'], $first['uploaded']);
        $puts = array_values(array_filter($this->calls, fn ($c) => $c['method'] === 'PUT'));
        $this->assertCount(2, $puts);
        $this->assertSame('public-read', $puts[0]['headers']['x-amz-acl']);
        $this->assertSame('attachment; filename="banco.xlsx"', $puts[0]['headers']['content-disposition']);
        $this->assertStringStartsWith('application/vnd.openxmlformats', $puts[0]['headers']['content-type']);
        $this->assertStringContainsString('/recursos/bloom-ia/banco.xlsx', $puts[0]['url']);

        // Segunda vez: nada cambió, nada se sube.
        $this->calls = [];
        $second = PublicDownloads::publish($this->dir, fn () => null);
        $this->assertSame([], $second['uploaded']);
        $this->assertCount(2, $second['ok']);
        $this->assertSame([], array_filter($this->calls, fn ($c) => $c['method'] === 'PUT'));

        // Un archivo cambia: solo ese se sube.
        file_put_contents($this->dir . '/bloom-ia/script.py', "print('adiós')\n");
        PublicDownloads::setManifest(PublicDownloads::scan($this->dir));
        $third = PublicDownloads::publish($this->dir, fn () => null);
        $this->assertSame(['bloom-ia/script.py'], $third['uploaded']);
    }

    public function testVerifyWithoutFolderReportsMissingObjects(): void
    {
        $result = PublicDownloads::publish(null, fn () => null);
        $this->assertSame(['bloom-ia/banco.xlsx', 'bloom-ia/script.py'], $result['missing']);
    }

    public function testBrokenLinksAreDetected(): void
    {
        $html = '<a href="/descargas/bloom-ia/banco.xlsx">Libro</a> <a href="https://www.edwinortiz.net/descargas/bloom-ia/perdido.xlsx">x</a>.';
        $this->assertSame(['bloom-ia/perdido.xlsx'], PublicDownloads::brokenLinks($html));
    }

    public function testSiteScanReportsLinksMissingFromManifest(): void
    {
        $group = bin2hex(random_bytes(4));
        DB::run("INSERT INTO posts (type, locale, translation_group, slug, title, content_html, status, published_at)
            VALUES ('post', 'es', :g, :s, 'Prueba descargas', :h, 'draft', UTC_TIMESTAMP())", [
            'g' => $group, 's' => "prueba-descargas-$group",
            'h' => '<a href="/descargas/bloom-ia/banco.xlsx">ok</a> <a href="/descargas/bloom-ia/perdido.xlsx">x</a>',
        ]);
        try {
            $broken = PublicDownloads::brokenLinksInSite();
            $this->assertSame(['bloom-ia/perdido.xlsx'], $broken["es/prueba-descargas-$group"]);
            $this->assertArrayHasKey('herramienta qr', $broken);
        } finally {
            DB::run('DELETE FROM posts WHERE translation_group = :g', ['g' => $group]);
        }
    }

    public function testToolPageShowsExcelSectionFromManifest(): void
    {
        PublicDownloads::setManifest(['codigo-qr-excel.zip' => ['size' => 40960, 'sha256' => str_repeat('a', 64)]]);
        $res = App::handle(Request::create('GET', '/herramientas/generador-qr/'));
        $this->assertSame(200, $res->status);
        $this->assertStringContainsString('href="/descargas/codigo-qr-excel.zip"', $res->body);
        $this->assertStringContainsString('40', $res->body);

        // Sin inventario ni copia local no hay tamaño: la sección no se muestra.
        $this->assertNull(PublicDownloads::size('no-existe-excel.zip'));
    }
}
