<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Config;
use App\Core\Request;
use App\Core\Response;
use App\Models\Post;
use App\Services\I18n\I18n;
use App\Services\Seo\Sitemap;

final class SeoController extends Controller
{
    public function sitemap(Request $request): Response
    {
        return Response::text(Sitemap::cached(), 200, 'application/xml')->header('Cache-Control', 'public, max-age=3600');
    }

    /** Respaldo dinámico si public/robots.txt no existe (Nginx/Apache sirven primero el estático). */
    public function robots(Request $request): Response
    {
        $lines = ['User-agent: *'];
        if (Config::bool('NOINDEX')) {
            $lines[] = 'Disallow: /';
        } else {
            foreach (['/admin/', '/carrito/', '/finalizar-compra/', '/mi-cuenta/', '/pedido/', '/api/', '/descarga/', '/en/cart/', '/en/checkout/', '/en/account/', '/en/order/'] as $path) {
                $lines[] = 'Disallow: ' . $path;
            }
        }
        $lines[] = '';
        $lines[] = 'Sitemap: ' . url('/sitemap.xml');
        return Response::text(implode("\n", $lines) . "\n");
    }

    /** RSS 2.0: /feed/ (español) y /en/feed/ (inglés). */
    public function feed(Request $request): Response
    {
        $locale = I18n::locale();
        $posts = Post::latest($locale, 20);
        $xml = new \XMLWriter();
        $xml->openMemory();
        $xml->startDocument('1.0', 'UTF-8');
        $xml->startElement('rss');
        $xml->writeAttribute('version', '2.0');
        $xml->writeAttribute('xmlns:atom', 'http://www.w3.org/2005/Atom');
        $xml->writeAttribute('xmlns:dc', 'http://purl.org/dc/elements/1.1/');
        $xml->startElement('channel');
        $xml->writeElement('title', t('site.name'));
        $xml->writeElement('link', url(route('home')));
        $xml->writeElement('description', t('seo.home.description'));
        $xml->writeElement('language', I18n::meta('html'));
        $xml->startElement('atom:link');
        $xml->writeAttribute('href', url(route('feed')));
        $xml->writeAttribute('rel', 'self');
        $xml->writeAttribute('type', 'application/rss+xml');
        $xml->endElement();
        if ($posts) {
            $xml->writeElement('lastBuildDate', gmdate(DATE_RSS, (int) strtotime(($posts[0]['updated_at'] ?? $posts[0]['published_at']) . ' UTC')));
        }
        foreach ($posts as $post) {
            $link = url(post_path($post));
            $xml->startElement('item');
            $xml->writeElement('title', $post['title']);
            $xml->writeElement('link', $link);
            $xml->startElement('guid');
            $xml->writeAttribute('isPermaLink', 'true');
            $xml->text($link);
            $xml->endElement();
            $xml->writeElement('dc:creator', 'Edwin Ortiz Herazo');
            $xml->writeElement('pubDate', gmdate(DATE_RSS, (int) strtotime($post['published_at'] . ' UTC')));
            $xml->writeElement('description', excerpt_text($post['excerpt'], 300));
            $xml->endElement();
        }
        $xml->endElement();
        $xml->endElement();
        $xml->endDocument();
        return Response::text($xml->outputMemory(), 200, 'application/rss+xml')->header('Cache-Control', 'public, max-age=1800');
    }
}
