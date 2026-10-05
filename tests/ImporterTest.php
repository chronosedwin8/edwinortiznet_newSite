<?php

declare(strict_types=1);

namespace Tests;

use App\Services\Importer\AttachmentIndex;
use App\Services\Importer\HtmlCleaner;
use PHPUnit\Framework\TestCase;

final class ImporterTest extends TestCase
{
    private function cleaner(): HtmlCleaner
    {
        $index = new AttachmentIndex();
        $index->add(
            1336,
            'https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/09/24133302/se-inteligente-post.jpg',
            'Sé inteligente',
            'Sé Inteligente en Internet',
            '2020/09/se-inteligente-post.jpg',
            serialize(['width' => 1200, 'height' => 632, 'sizes' => [
                'medium' => ['file' => 'se-inteligente-post-300x158.jpg', 'width' => 300, 'height' => 158],
                'large' => ['file' => 'se-inteligente-post-1024x539.jpg', 'width' => 1024, 'height' => 539],
                'thumbnail' => ['file' => 'se-inteligente-post-150x150.jpg', 'width' => 150, 'height' => 150],
            ]])
        );
        return new HtmlCleaner($index, [380 => 'enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco', 409 => 'generador-de-codigos-qr-masivos']);
    }

    public function testRemovesGutenbergCommentsAndSpacers(): void
    {
        $html = "<!-- wp:paragraph -->\n<p>Hola</p>\n<!-- /wp:paragraph -->\n<!-- wp:spacer {\"height\":\"51px\"} -->\n<div style=\"height:51px\" aria-hidden=\"true\" class=\"wp-block-spacer\"></div>\n<!-- /wp:spacer -->";
        $out = $this->cleaner()->clean($html);
        $this->assertSame('<p>Hola</p>', $out);
    }

    public function testWhitelistStripsStylesClassesAndScripts(): void
    {
        $out = $this->cleaner()->clean('<!-- wp:html --><div class="x" style="color:red"><p class="has-text-align-center" style="a:b">Texto <span style="x">ok</span></p><script>alert(1)</script><style>p{}</style></div><!-- /wp:html -->');
        $this->assertStringNotContainsString('style', $out);
        $this->assertStringNotContainsString('script', $out);
        $this->assertStringNotContainsString('class=', $out);
        $this->assertStringContainsString('<p>Texto ok</p>', $out);
    }

    public function testH1BecomesH2(): void
    {
        $out = $this->cleaner()->clean('<!-- wp:heading --><h1>Título interno</h1><!-- /wp:heading -->');
        $this->assertStringContainsString('<h2 id="titulo-interno">Título interno</h2>', $out);
        $this->assertStringNotContainsString('<h1', $out);
    }

    public function testCaptionBecomesFigureAndLocalImageMapsToS3(): void
    {
        $html = '[caption id="attachment_1336" align="alignnone" width="300"]<img class="size-medium wp-image-1336" src="https://www.edwinortiz.net/wp-content/uploads/2020/09/se-inteligente-post-300x158.jpg" alt="" width="300" height="158" /> Sé Inteligente en Internet - Interland[/caption]';
        $out = $this->cleaner()->clean($html, ['title' => 'Post']);
        $this->assertStringContainsString('<figure>', $out);
        $this->assertStringContainsString('<figcaption>Sé Inteligente en Internet - Interland</figcaption>', $out);
        $this->assertStringContainsString('src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/09/24133302/se-inteligente-post-300x158.jpg"', $out);
        $this->assertStringContainsString('alt="Sé Inteligente en Internet"', $out);
        $this->assertStringContainsString('loading="lazy"', $out);
        $this->assertStringContainsString('decoding="async"', $out);
        $this->assertStringContainsString('width="300" height="158"', $out);
        $this->assertStringContainsString('srcset=', $out);
        $this->assertStringNotContainsString('150x150', $out);
    }

    public function testImageWithoutAttachmentGetsAltFromTitle(): void
    {
        $out = $this->cleaner()->clean('<p><img src="https://example.com/a.png"></p>', ['title' => 'Mi artículo']);
        $this->assertStringContainsString('alt="Mi artículo"', $out);
    }

    public function testYoutubeEmbedsBecomeLiteComponent(): void
    {
        $html = '<!-- wp:embed {"url":"https://youtu.be/7Bsr-EwO9WI","type":"video","providerNameSlug":"youtube"} --><figure class="wp-block-embed"><div class="wp-block-embed__wrapper">https://youtu.be/7Bsr-EwO9WI</div></figure><!-- /wp:embed -->'
            . '<!-- wp:html --><iframe src="https://www.youtube.com/embed/CcWCpBpSMJY" width="560" height="315"></iframe><!-- /wp:html -->'
            . '[embed]https://youtu.be/_m582hmlrk0?si=x[/embed]';
        $out = $this->cleaner()->clean($html, ['title' => 'Tutorial']);
        $this->assertSame(3, substr_count($out, 'class="lite-yt"'));
        $this->assertStringContainsString('data-yt="7Bsr-EwO9WI"', $out);
        $this->assertStringContainsString('data-yt="CcWCpBpSMJY"', $out);
        $this->assertStringContainsString('data-yt="_m582hmlrk0"', $out);
        $this->assertStringNotContainsString('<iframe', $out);
    }

    public function testNonYoutubeIframesBecomeLinks(): void
    {
        $out = $this->cleaner()->clean('<!-- wp:html --><iframe src="https://view.genial.ly/5f400a"></iframe><!-- /wp:html -->');
        $this->assertStringNotContainsString('<iframe', $out);
        $this->assertStringContainsString('href="https://view.genial.ly/5f400a"', $out);
    }

    public function testWoocommerceAndContentViewsMarkers(): void
    {
        $html = '<!-- wp:woocommerce/handpicked-products {"products":[380,342,409]} /--><!-- wp:contentviews/grid1 {"blockId":"x"} /-->[pt_view id="abc"]';
        $out = $this->cleaner()->clean($html, ['hub' => 'excel']);
        $this->assertStringContainsString('{{productos:enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco,generador-de-codigos-qr-masivos}}', $out);
        $this->assertSame(2, substr_count($out, '{{articulos:excel}}'));
    }

    public function testTomsneddonBlocks(): void
    {
        $html = '<!-- wp:tomsneddon-video-player/toms-video-player {"videoSource":"https://cdn.example.com/v.mp4"} /-->'
            . '<!-- wp:tomsneddon-image-slider/toms-image-slider {"galleryImages":["https://s3.example.com/a.png","https://s3.example.com/b.png"]} /-->'
            . '<!-- wp:tomsneddon-video-player/toms-video-player {"autoPlay":true} /-->';
        $out = $this->cleaner()->clean($html, ['title' => 'T']);
        $this->assertSame(1, substr_count($out, '<video'));
        $this->assertStringContainsString('class="gallery"', $out);
        $this->assertSame(2, substr_count($out, '<img'));
    }

    public function testLinksFundalesLenovoAndInternal(): void
    {
        $html = '<p><a href="https://fundales.com/curso/?a=1">Fundales</a> <a href="https://lenovo-co.5nfc.net/abc">Lenovo</a> <a href="https://www.edwinortiz.net/excel/">Excel</a> <a href="javascript:alert(1)">x</a></p>';
        $out = $this->cleaner()->clean($html, ['slug' => 'mi-entrada']);
        $this->assertStringContainsString('href="https://fundales.com/curso/?a=1&amp;utm_source=edwinortiz.net&amp;utm_medium=articulo&amp;utm_campaign=mi-entrada"', $out);
        $this->assertMatchesRegularExpression('/href="https:\/\/fundales\.com[^"]*" rel="noopener"/', $out);
        $this->assertStringContainsString('rel="sponsored nofollow"', $out);
        $this->assertStringContainsString('href="/excel/"', $out);
        $this->assertStringNotContainsString('javascript:', $out);
    }

    public function testClassicEditorContentGetsParagraphs(): void
    {
        $out = $this->cleaner()->clean("Primera línea\n\nSegundo párrafo\ncon salto");
        $this->assertStringContainsString('<p>Primera línea</p>', $out);
        $this->assertStringContainsString("<p>Segundo párrafo<br>", $out);
    }

    public function testTextReadingTimeAndDescriptionDraft(): void
    {
        $html = '<p>' . str_repeat('palabra ', 440) . '</p>';
        $text = HtmlCleaner::toText($html);
        $this->assertSame(2, HtmlCleaner::readingMinutes($text));
        $draft = HtmlCleaner::draftDescription('<p>Corto</p><p>' . str_repeat('Excel automatiza tareas repetitivas de oficina. ', 8) . '</p>');
        $this->assertGreaterThanOrEqual(140, mb_strlen($draft));
        $this->assertLessThanOrEqual(160, mb_strlen($draft));
    }
}
