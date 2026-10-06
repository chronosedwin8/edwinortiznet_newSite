<?php

declare(strict_types=1);

namespace Tests;

use App\Core\App;
use App\Core\Config;
use App\Core\DB;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Services\Seo\Redirects;
use PHPUnit\Framework\TestCase;

/**
 * Criterios de la fase 4: JSON-LD válido, sitemap, feed, redirecciones 301 y metadatos.
 */
final class SeoTest extends TestCase
{
    protected function setUp(): void
    {
        try {
            DB::value('SELECT COUNT(*) FROM redirects');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible');
        }
        RateLimiter::disable();
        Config::set('PAGE_CACHE', 'false');
        Redirects::clear();
    }

    private function get(string $path): \App\Core\Response
    {
        return App::handle(Request::create('GET', $path));
    }

    /** @return array<int, array> nodos JSON-LD (se aplanan los @graph) */
    private function jsonLd(string $html): array
    {
        preg_match_all('#<script type="application/ld\+json">(.*?)</script>#s', $html, $m);
        $nodes = [];
        foreach ($m[1] as $json) {
            $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
            $this->assertIsArray($data);
            $this->assertSame('https://schema.org', $data['@context'] ?? null, 'Cada bloque JSON-LD declara @context');
            foreach ($data['@graph'] ?? [$data] as $node) {
                $nodes[] = $node;
            }
        }
        return $nodes;
    }

    private function byType(array $nodes, string $type): ?array
    {
        foreach ($nodes as $node) {
            $types = (array) ($node['@type'] ?? []);
            if (in_array($type, $types, true)) {
                return $node;
            }
        }
        return null;
    }

    private function meta(string $html, string $pattern): ?string
    {
        return preg_match($pattern, $html, $m) ? html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5) : null;
    }

    public function testHomeJsonLdAndMeta(): void
    {
        $html = $this->get('/')->body;
        $nodes = $this->jsonLd($html);
        $this->assertNotNull($this->byType($nodes, 'Person'));
        $site = $this->byType($nodes, 'WebSite');
        $this->assertNotNull($site);
        $this->assertSame('SearchAction', $site['potentialAction']['@type']);
        $this->assertStringContainsString('{search_term_string}', $site['potentialAction']['target']['urlTemplate']);
        $title = $this->meta($html, '#<title>(.*?)</title>#');
        $this->assertSame('Edwin Ortiz Herazo | Excel, IA y tecnología educativa', $title);
        $this->assertGreaterThanOrEqual(50, mb_strlen($title));
        $this->assertLessThanOrEqual(60, mb_strlen($title));
        $desc = $this->meta($html, '#<meta name="description" content="([^"]*)">#');
        $this->assertGreaterThanOrEqual(150, mb_strlen($desc));
        $this->assertLessThanOrEqual(160, mb_strlen($desc));
        $this->assertStringContainsString('<html lang="es-CO"', $html);
        $this->assertStringContainsString('<meta property="og:locale" content="es_CO">', $html);
        $this->assertStringContainsString('<meta property="og:locale:alternate" content="en_US">', $html);
        $this->assertStringContainsString('<meta name="twitter:card" content="summary_large_image">', $html);
        $en = $this->get('/en/')->body;
        $this->assertSame('Edwin Ortiz Herazo | Excel automation & AI for teachers', $this->meta($en, '#<title>(.*?)</title>#'));
        $this->assertStringContainsString('<html lang="en"', $en);
    }

    public function testArticleJsonLd(): void
    {
        $html = $this->get('/generador-masivo-de-codigos-qr-desde-excel/')->body;
        $nodes = $this->jsonLd($html);
        $article = $this->byType($nodes, 'Article');
        $this->assertNotNull($article);
        foreach (['headline', 'datePublished', 'dateModified', 'author', 'inLanguage', 'mainEntityOfPage'] as $field) {
            $this->assertArrayHasKey($field, $article, "Article.$field");
        }
        $this->assertSame('es-CO', $article['inLanguage']);
        $this->assertNotFalse(\DateTimeImmutable::createFromFormat(DATE_ATOM, $article['datePublished']));
        $crumbs = $this->byType($nodes, 'BreadcrumbList');
        $this->assertNotNull($crumbs);
        $this->assertGreaterThanOrEqual(3, count($crumbs['itemListElement']));
        $this->assertStringContainsString('<link rel="canonical" href="' . Config::appUrl() . '/generador-masivo-de-codigos-qr-desde-excel/">', $html);
    }

    public function testProductJsonLdUsesLocaleCurrencyAndNoRatings(): void
    {
        $es = $this->get('/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/')->body;
        $product = $this->byType($this->jsonLd($es), 'Product');
        $this->assertNotNull($product);
        $this->assertSame('COP', $product['offers']['priceCurrency']);
        $this->assertMatchesRegularExpression('/^\d+$/', $product['offers']['price']);
        $this->assertArrayHasKey('availability', $product['offers']);
        $this->assertArrayNotHasKey('aggregateRating', $product);
        $this->assertStringNotContainsString('AggregateRating', $es);
        $this->assertNotNull($this->byType($this->jsonLd($es), 'FAQPage'));

        $enSlug = DB::value('SELECT t.slug FROM product_translations t JOIN products p ON p.id = t.product_id WHERE p.wp_id = 380 AND t.locale = "en"');
        $en = $this->get("/en/product/$enSlug/")->body;
        $enProduct = $this->byType($this->jsonLd($en), 'Product');
        $this->assertSame('USD', $enProduct['offers']['priceCurrency']);
        $this->assertSame('25.00', $enProduct['offers']['price']);
        $this->assertSame('en', $enProduct['inLanguage']);
    }

    public function testHubHasFaqPage(): void
    {
        $nodes = $this->jsonLd($this->get('/excel/')->body);
        $faq = $this->byType($nodes, 'FAQPage');
        $this->assertNotNull($faq);
        $this->assertNotEmpty($faq['mainEntity']);
        $this->assertNotNull($this->byType($nodes, 'BreadcrumbList'));
    }

    public function testCoursesHaveCourseSchema(): void
    {
        $this->assertNotNull($this->byType($this->jsonLd($this->get('/cursos/')->body), 'Course'));
    }

    public function testSeededRedirectsReturn301(): void
    {
        $cases = [
            '/page/3/' => '/blog/pagina/3/',
            '/author/edwinortiz/' => '/sobre-mi/',
            '/category/excel/' => '/excel/',
            '/category/oficina/' => '/excel/',
            '/category/correos-masivos/' => '/excel/',
            '/category/concurso-docente/' => '/concurso-docente/',
            '/category/educacion/' => '/blog/',
            '/archivos-gratis/' => '/herramientas/',
            '/blog' => '/blog/',
            '/microsoft-copilot-el-copiloto-de-trabajo-que-revoluciona-la-productividad-empresarial/' => '/microsoft-365-copilot-la-revolucion-de-la-productividad-en-el-mundo-empresarial/',
            '/?add-to-cart=380' => '/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/',
            '/?add-to-cart=409' => '/producto/generador-de-codigos-qr-masivos/',
        ];
        foreach ($cases as $from => $to) {
            $response = $this->get($from);
            $this->assertSame(301, $response->status, "301 en $from");
            $this->assertSame($to, $response->headers['Location'] ?? null, "Destino de $from");
        }
        // Sin barra final → 301 a la versión con barra.
        $response = $this->get('/excel');
        $this->assertSame(301, $response->status);
        $this->assertSame('/excel/', $response->headers['Location']);
    }

    public function testNotFoundIsLogged(): void
    {
        $path = '/no-existe-' . bin2hex(random_bytes(4)) . '/';
        $this->assertSame(404, $this->get($path)->status);
        $this->assertSame(1, (int) DB::value('SELECT hits FROM not_found_log WHERE path = :p', ['p' => $path]));
        DB::run('DELETE FROM not_found_log WHERE path = :p', ['p' => $path]);
    }

    public function testSitemapExcludesNoindexAndHasAlternates(): void
    {
        $response = $this->get('/sitemap.xml');
        $this->assertSame(200, $response->status);
        $xml = simplexml_load_string($response->body);
        $this->assertNotFalse($xml);
        $locs = [];
        foreach ($xml->url as $url) {
            $locs[] = (string) parse_url((string) $url->loc, PHP_URL_PATH);
            $this->assertNotEmpty((string) $url->loc);
        }
        foreach (DB::column('SELECT slug FROM posts WHERE status IN ("noindex","draft") AND locale = "es" AND slug NOT IN (SELECT slug FROM hub_translations)') as $slug) {
            $this->assertNotContains("/$slug/", $locs, "noindex/borrador en el sitemap: $slug");
        }
        $this->assertContains('/', $locs);
        $this->assertContains('/en/', $locs);
        $this->assertStringContainsString('hreflang="x-default"', $response->body);
        $this->assertStringContainsString('<lastmod>', $response->body);
    }

    public function testLegacyWordPressSitemapsRedirect(): void
    {
        foreach (['/sitemap_index.xml', '/post-sitemap.xml', '/wp-sitemap.xml'] as $path) {
            $response = $this->get($path);
            $this->assertSame(301, $response->status, $path);
            $this->assertStringEndsWith('/sitemap.xml', $response->headers['Location']);
        }
    }

    public function testFeeds(): void
    {
        foreach (['/feed/' => 'es-CO', '/en/feed/' => 'en'] as $path => $lang) {
            $response = $this->get($path);
            $this->assertSame(200, $response->status);
            $xml = simplexml_load_string($response->body);
            $this->assertNotFalse($xml);
            $this->assertSame($lang, (string) $xml->channel->language);
            $this->assertGreaterThan(0, count($xml->channel->item));
        }
    }

    public function testNoindexPostsAreMarked(): void
    {
        $post = DB::one('SELECT id, slug FROM posts WHERE locale = "es" AND type = "post" AND status = "published" ORDER BY id LIMIT 1');
        DB::run('UPDATE posts SET status = "noindex" WHERE id = :id', ['id' => $post['id']]);
        try {
            $html = $this->get("/{$post['slug']}/")->body;
            $this->assertStringContainsString('<meta name="robots" content="noindex, follow">', $html);
        } finally {
            DB::run('UPDATE posts SET status = "published" WHERE id = :id', ['id' => $post['id']]);
        }
    }

    public function testRetiredContentRedirectsToItsReplacement(): void
    {
        $response = $this->get('/restar-horas-en-excel/');
        $this->assertSame(301, $response->status);
        $this->assertSame('/como-restar-horas-en-excel-horas-laborales/', $response->headers['Location'] ?? null);
        $this->assertSame(301, $this->get('/los-mejores-portatiles-baratos-y-rapidos/')->status);
    }

    public function testSecurityHeaders(): void
    {
        $h = $this->get('/')->headers;
        $this->assertStringContainsString("default-src 'self'", $h['Content-Security-Policy']);
        $this->assertStringNotContainsString("'unsafe-inline' https://www.googletagmanager", $h['Content-Security-Policy']);
        $this->assertSame('nosniff', $h['X-Content-Type-Options']);
        $this->assertArrayHasKey('Referrer-Policy', $h);
        $this->assertArrayHasKey('Permissions-Policy', $h);
        $this->assertArrayHasKey('ETag', $h);
    }
}
