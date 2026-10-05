<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\DB;
use App\Core\Request;
use App\Core\RateLimiter;
use PHPUnit\Framework\TestCase;

/**
 * Criterios de la fase 3A: sin cadenas visibles fuera de t(), hreflang recíproco y URLs en español intactas.
 * Las pruebas que recorren páginas necesitan la base de datos importada (se omiten si no existe).
 */
final class I18nTest extends TestCase
{
    /** Texto permitido fuera de t(): números, unidades y signos. */
    private const ALLOWED = '/^(?:[A-Z]|[\s\d.,:;%×x+\-–—()\/|·•…→←↑↓▸✓×#*"\'«»=_&$€@?!px]*)$/u';

    public static function templateFiles(): array
    {
        $root = dirname(__DIR__) . '/templates';
        $files = [];
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($root, \FilesystemIterator::SKIP_DOTS));
        foreach ($it as $file) {
            $path = str_replace('\\', '/', (string) $file);
            // Los correos tienen una plantilla por idioma (templates/emails/{es,en}).
            if (str_ends_with($path, '.php') && !str_contains($path, '/emails/')) {
                $files[substr($path, strlen($root) + 1)] = [$path];
            }
        }
        return $files;
    }

    /** @dataProvider templateFiles */
    #[\PHPUnit\Framework\Attributes\DataProvider('templateFiles')]
    public function testNoVisibleStringsOutsideT(string $file): void
    {
        $src = (string) file_get_contents($file);
        $html = preg_replace('/<\?(php|=).*?(\?>|$)/s', ' ', $src) ?? '';
        $html = preg_replace('#<script\b[^>]*>.*?</script>#s', ' ', $html) ?? '';
        $html = preg_replace('#<style\b[^>]*>.*?</style>#s', ' ', $html) ?? '';
        $html = preg_replace('/<!--.*?-->/s', ' ', $html) ?? '';

        $problems = [];
        if (preg_match_all('/\s(alt|title|placeholder|aria-label|label)="([^"]*)"/', $html, $m, PREG_SET_ORDER)) {
            foreach ($m as $attr) {
                if (trim($attr[2]) !== '' && !preg_match(self::ALLOWED, $attr[2])) {
                    $problems[] = "atributo {$attr[1]}=\"{$attr[2]}\"";
                }
            }
        }
        $text = preg_replace('/<[^>]*>/s', "\n", $html) ?? '';
        foreach (preg_split('/\n/', $text) ?: [] as $line) {
            $line = trim(html_entity_decode($line, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if ($line !== '' && !preg_match(self::ALLOWED, $line)) {
                $problems[] = "texto «{$line}»";
            }
        }
        $this->assertSame([], $problems, "Cadenas visibles fuera de t() en $file");
    }

    public function testLangFilesHaveSameKeysForPublicUi(): void
    {
        $es = require dirname(__DIR__) . '/lang/es.php';
        $en = require dirname(__DIR__) . '/lang/en.php';
        // El panel solo existe en español; el simulacro del concurso no se traduce.
        $skip = static fn (string $k): bool => str_starts_with($k, 'admin.') || str_starts_with($k, 'tool.quiz.')
            || str_starts_with($k, 'home.profile.contest') || in_array($k, ['tool.words.faq3_q', 'tool.words.faq3_a', 'tool.words.how_p4', 'tool.qr.how_p5'], true);
        $missing = array_filter(array_diff(array_keys($es), array_keys($en)), fn ($k) => !$skip($k));
        $this->assertSame([], array_values($missing), 'Claves de es.php sin traducir en en.php');
    }

    private function db(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM posts');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        RateLimiter::disable();
        Config::set('PAGE_CACHE', 'false');
    }

    /** @return array<string,string> hreflang => href */
    private function alternates(string $path): array
    {
        $response = App::handle(Request::create('GET', $path));
        $this->assertSame(200, $response->status, "GET $path");
        preg_match_all('#<link rel="alternate" hreflang="([^"]+)" href="([^"]+)">#', $response->body, $m, PREG_SET_ORDER);
        $out = [];
        foreach ($m as $link) {
            $out[$link[1]] = (string) parse_url($link[2], PHP_URL_PATH);
        }
        return $out;
    }

    public function testEnglishPagesHaveReciprocalHreflang(): void
    {
        $this->db();
        $paths = ['/en/', '/en/blog/', '/en/shop/', '/en/tools/', '/en/tools/qr-code-generator/', '/en/tools/number-to-words/', '/en/about/', '/en/contact/', '/en/excel-automation/'];
        foreach (DB::all('SELECT slug, type FROM posts WHERE locale = "en" AND status = "published"') as $row) {
            $paths[] = $row['type'] === 'policy' ? '/en/policies/' . $row['slug'] . '/' : ($row['slug'] === 'about' ? '/en/about/' : '/en/' . $row['slug'] . '/');
        }
        foreach (DB::all('SELECT t.slug FROM product_translations t JOIN products p ON p.id = t.product_id WHERE t.locale = "en" AND p.status <> "hidden"') as $row) {
            $paths[] = '/en/product/' . $row['slug'] . '/';
        }
        foreach (array_unique($paths) as $enPath) {
            $alts = $this->alternates($enPath);
            $this->assertSame($enPath, $alts['en'] ?? null, "hreflang=en de $enPath");
            $this->assertArrayHasKey('es-CO', $alts, "hreflang=es-CO en $enPath");
            $this->assertSame($alts['es-CO'], $alts['x-default'] ?? null, "x-default de $enPath");
            $back = $this->alternates($alts['es-CO']);
            $this->assertSame($enPath, $back['en'] ?? null, "Recíproco: {$alts['es-CO']} debe apuntar a $enPath");
            $this->assertSame($alts['es-CO'], $back['es-CO'] ?? null, "Autorreferencia en {$alts['es-CO']}");
        }
    }

    public function testSpanishOnlyContentHasNoHreflang(): void
    {
        $this->db();
        $this->assertSame([], $this->alternates('/concurso-docente/'));
        $this->assertSame([], $this->alternates('/herramientas/simulacro-concurso-docente/'));
        $slug = DB::value('SELECT p.slug FROM posts p JOIN post_category pc ON pc.post_id = p.id JOIN categories c ON c.id = pc.category_id WHERE c.wp_slug = "concurso-docente" AND p.status = "published" LIMIT 1');
        $this->assertSame([], $this->alternates("/$slug/"));
    }

    public function testSpanishUrlsUnchanged(): void
    {
        $this->db();
        foreach (DB::all('SELECT slug FROM posts WHERE locale = "es" AND wp_id IS NOT NULL AND status <> "draft"') as $row) {
            $response = App::handle(Request::create('GET', '/' . $row['slug'] . '/'));
            $this->assertSame(200, $response->status, '/' . $row['slug'] . '/');
        }
        foreach (DB::all('SELECT t.slug FROM product_translations t JOIN products p ON p.id = t.product_id WHERE t.locale = "es" AND p.wp_id IS NOT NULL') as $row) {
            $response = App::handle(Request::create('GET', '/producto/' . $row['slug'] . '/'));
            $this->assertSame(200, $response->status, '/producto/' . $row['slug'] . '/');
        }
    }
}
