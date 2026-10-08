<?php

declare(strict_types=1);

namespace Tests;

use App\Core\Config;
use App\Core\DB;
use App\Services\Content\CarouselConverter;
use App\Services\Content\ContentRenderer;
use App\Services\Importer\HtmlCleaner;
use PHPUnit\Framework\TestCase;

/**
 * Carrusel de imágenes del contenido (.carousel-gallery): lista blanca de HtmlCleaner, semántica que añade
 * ContentRenderer, inserciones (tarjeta de producto y anuncios) que nunca caen dentro, y la conversión
 * del seed 19_carrusel_fundales sobre un fixture con la galería de WordPress del artículo del Concurso Docente.
 */
final class ContentCarouselTest extends TestCase
{
    private const IMG = 'https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2026/01/';

    private static function slide(string $name, string $alt, int $w = 1024, int $h = 505, string $caption = ''): string
    {
        return '<figure class="carousel-gallery__item"><img src="' . self::IMG . $name . '.jpg" alt="' . $alt . '" width="' . $w . '" height="' . $h . '">'
            . ($caption !== '' ? '<figcaption>' . $caption . '</figcaption>' : '') . '</figure>';
    }

    private static function carousel(string $attrs = ''): string
    {
        return '<div class="carousel-gallery"' . $attrs . '>' . self::slide('a', 'Uno', 1024, 505, 'Pie <strong>uno</strong>') . self::slide('b', 'Dos', 1024, 507) . self::slide('c', 'Tres') . '</div>';
    }

    // ------------------------------------------------------------------ HtmlCleaner

    public function testSanitizerKeepsCarouselMarkup(): void
    {
        $out = (new HtmlCleaner())->sanitize('<p>Antes</p>' . self::carousel() . '<p>Después</p>');
        $this->assertStringContainsString('<div class="carousel-gallery">', $out);
        $this->assertSame(3, substr_count($out, '<figure class="carousel-gallery__item"><img src="' . self::IMG));
        $this->assertStringContainsString('<figcaption>Pie <strong>uno</strong></figcaption>', $out);
        $this->assertStringContainsString('alt="Dos" width="1024" height="507" loading="lazy" decoding="async"', $out);
        $this->assertMatchesRegularExpression('#^<p>Antes</p><div class="carousel-gallery">.*</div><p>Después</p>$#s', $out);
    }

    public function testSanitizerStripsDisallowedAttributesAndForeignClasses(): void
    {
        $html = '<div class="carousel-gallery evil" id="x" style="color:red" onclick="alert(1)" data-carousel="best" data-foo="1" aria-label="x">'
            . '<figure class="carousel-gallery__item wp-block-image" onmouseover="x()" data-yt="abc" style="a:b"><img src="' . self::IMG . 'a.jpg" alt="A" onerror="x()"></figure>'
            . '<figure class="carousel-gallery__item"><img src="javascript:alert(1)" alt="B"></figure>'
            . '<figure class="carousel-gallery__item"><img src="' . self::IMG . 'c.jpg" alt="C"></figure></div>';
        $out = (new HtmlCleaner())->sanitize($html);
        $this->assertStringStartsWith('<div class="carousel-gallery">', $out);
        foreach (['onclick', 'onmouseover', 'onerror', 'style=', 'id="x"', 'data-carousel', 'data-foo', 'aria-label', 'evil', 'javascript:', 'wp-block-image', 'data-yt'] as $bad) {
            $this->assertStringNotContainsString($bad, $out, $bad);
        }
        // La imagen con src peligroso se elimina: quedan dos diapositivas.
        $this->assertSame(2, substr_count($out, 'carousel-gallery__item'));

        // Un video de YouTube no es una diapositiva: sale del carrusel con su propia clase.
        $video = (new HtmlCleaner())->sanitize('<div class="carousel-gallery">' . self::slide('a', 'A') . self::slide('b', 'B')
            . '<figure class="carousel-gallery__item lite-yt" data-yt="dQw4w9WgXcQ"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" data-yt="dQw4w9WgXcQ"><img src="https://i.ytimg.com/vi/dQw4w9WgXcQ/hqdefault.jpg" alt="Video"></a></figure></div>');
        $this->assertStringContainsString('</div><figure class="lite-yt" data-yt="dQw4w9WgXcQ">', $video);
        $this->assertSame(2, substr_count($video, 'carousel-gallery__item'));
    }

    public function testCarouselClassesOnlyValidOnTheirOwnTags(): void
    {
        $out = (new HtmlCleaner())->sanitize(
            '<p class="carousel-gallery">Texto</p><span class="carousel-gallery__item">en línea</span>'
            . '<figure class="carousel-gallery__item"><img src="' . self::IMG . 'a.jpg" alt="Suelta"></figure>'
            . '<div class="carousel-gallery__item"><p>Div sin carrusel</p></div><div><p>Div normal</p></div>'
        );
        $this->assertStringNotContainsString('carousel-gallery', $out);
        $this->assertStringNotContainsString('<div', $out);
        $this->assertStringContainsString('<p>Texto</p>', $out);
        $this->assertStringContainsString('<figure><img src="' . self::IMG . 'a.jpg" alt="Suelta"', $out);
        $this->assertStringContainsString('<p>Div sin carrusel</p>', $out);
    }

    public function testAutoplayIsValidated(): void
    {
        $cleaner = new HtmlCleaner();
        $this->assertStringContainsString('<div class="carousel-gallery" data-autoplay="5">', $cleaner->sanitize(self::carousel(' data-autoplay="05"')));
        foreach (['2', '31', 'abc', '5s', '-5', ''] as $bad) {
            $this->assertStringContainsString('<div class="carousel-gallery">', $cleaner->sanitize(self::carousel(' data-autoplay="' . $bad . '"')), $bad);
        }
    }

    public function testCarouselNormalizesContentAndNeverHidesTextInside(): void
    {
        $html = '<div class="carousel-gallery">'
            . '<figure><figure><img src="' . self::IMG . 'a.jpg" alt="A"><figcaption><p>Pie A</p></figcaption></figure><figure><img src="' . self::IMG . 'b.jpg" alt="B"></figure></figure>'
            . '<p><img src="' . self::IMG . 'c.jpg" alt="C"></p>'
            . '<img src="' . self::IMG . 'd.jpg" alt="D">'
            . '<h2>Un título que no va dentro</h2><p>Un párrafo con texto</p>texto suelto'
            . '</div><p>Fin</p>';
        $out = (new HtmlCleaner())->sanitize($html);
        $this->assertSame(4, substr_count($out, '<figure class="carousel-gallery__item">'));
        $this->assertStringContainsString('<figcaption>Pie A</figcaption>', $out);
        preg_match('#<div class="carousel-gallery">(.*?)</div>#s', $out, $m);
        $this->assertStringNotContainsString('<p', $m[1]);
        $this->assertStringNotContainsString('<h2', $m[1]);
        $this->assertStringNotContainsString('<figure>', $m[1]);
        // El texto se conserva, después del carrusel y en orden.
        $this->assertMatchesRegularExpression('#</div><h2 id="un-titulo-que-no-va-dentro">Un título que no va dentro</h2><p>Un párrafo con texto</p><p>texto suelto</p><p>Fin</p>$#', $out);
    }

    public function testFewerThanTwoImagesOrNestedCarouselBecomePlainFigures(): void
    {
        $cleaner = new HtmlCleaner();
        $one = $cleaner->sanitize('<div class="carousel-gallery"><figure class="carousel-gallery__item"><img src="' . self::IMG . 'a.jpg" alt="A"><figcaption>Pie</figcaption></figure></div>');
        $this->assertSame('<figure><img src="' . self::IMG . 'a.jpg" alt="A" loading="lazy" decoding="async"><figcaption>Pie</figcaption></figure>', $one);
        $nested = $cleaner->sanitize('<blockquote>' . self::carousel() . '</blockquote>');
        $this->assertStringNotContainsString('carousel-gallery', $nested);
        $this->assertSame(3, substr_count($nested, '<figure><img'));
        $this->assertSame('', $cleaner->sanitize('<div class="carousel-gallery"></div>'));
    }

    public function testSanitizeIsStableForCarousels(): void
    {
        $cleaner = new HtmlCleaner();
        $once = $cleaner->sanitize('<h2>Galería</h2>' . self::carousel(' data-autoplay="8"') . '<p>Texto</p>');
        $this->assertSame($once, $cleaner->sanitize($once));
        $this->assertSame('Galería Pie uno Texto', HtmlCleaner::toText($once));
    }

    // ------------------------------------------------------------------ ContentRenderer

    private static function render(string $html, ?string $inline = null): string
    {
        $clean = (new HtmlCleaner())->sanitize($html);
        return ContentRenderer::render(['id' => 0, 'locale' => 'es', 'content_html' => $clean, 'no_ads' => 1], null, false, $inline)['html'];
    }

    public function testRendererAddsCarouselSemanticsRatioAndLabels(): void
    {
        $html = self::render('<h2>Galería</h2>' . self::carousel() . self::carousel(' data-autoplay="6"'));
        $this->assertSame(2, substr_count($html, 'role="region" aria-roledescription="carrusel" aria-label="Galería de imágenes (3)" tabindex="0"'));
        $this->assertStringContainsString('<div class="carousel-gallery" id="carrusel-1" role="region"', $html);
        $this->assertStringContainsString('<div class="carousel-gallery" data-autoplay="6" id="carrusel-2" role="region"', $html);
        // Proporción común = la imagen más alta (1024 × 507).
        $this->assertStringContainsString('style="--cg-ratio: 1024 / 507"', $html);
        $this->assertStringContainsString('<figure class="carousel-gallery__item" role="group" aria-roledescription="diapositiva" aria-label="2 de 3">', $html);
        $this->assertStringContainsString('data-label-prev="Imagen anterior" data-label-next="Imagen siguiente"', $html);
        $this->assertStringContainsString('data-label-status="Imagen :i de :n"', $html);
        $this->assertSame(['js/carousel.js'], ContentRenderer::scripts($html));
        $this->assertSame([], ContentRenderer::scripts('<p>Sin carrusel</p>'));
    }

    public function testPortraitImagesCapTheRatioAtSquareAndUnknownSizesUseTheDefault(): void
    {
        $portrait = self::render('<div class="carousel-gallery">' . self::slide('a', 'A', 800, 1200) . self::slide('b', 'B') . '</div>');
        $this->assertStringContainsString('style="--cg-ratio: 1 / 1"', $portrait);
        $unknown = self::render('<div class="carousel-gallery"><figure><img src="' . self::IMG . 'a.jpg" alt="A"></figure><figure><img src="' . self::IMG . 'b.jpg" alt="B"></figure></div>');
        $this->assertStringContainsString('aria-label="Galería de imágenes (2)"', $unknown);
        $this->assertStringNotContainsString('--cg-ratio', $unknown);
    }

    public function testTocIgnoresCarouselAndProductCardNeverLandsInside(): void
    {
        $html = '<h2>Uno</h2><p>Intro.</p><h2>Dos</h2>' . self::carousel() . '<p>Primer párrafo tras el carrusel.</p><h2>Tres</h2><p>Final.</p>';
        $clean = (new HtmlCleaner())->sanitize($html);
        $rendered = ContentRenderer::render(['id' => 0, 'locale' => 'es', 'content_html' => $clean, 'no_ads' => 1], null, false, '<aside class="tarjeta">X</aside>');
        $this->assertSame(['uno', 'dos', 'tres'], array_column($rendered['toc'], 'id'));
        $this->assertStringContainsString('</div><p>Primer párrafo tras el carrusel.</p><aside class="tarjeta">X</aside>', $rendered['html']);
        preg_match('#<div class="carousel-gallery".*?</div>#s', $rendered['html'], $m);
        $this->assertStringNotContainsString('tarjeta', $m[0]);
    }

    public function testInsertionOffsetsInsideACarouselMoveAfterIt(): void
    {
        $html = '<p>a</p>' . self::carousel() . '<p>b</p>';
        $start = strpos($html, '<div class="carousel-gallery"');
        $end = strpos($html, '</div>') + 6;
        $this->assertSame($start, ContentRenderer::outsideCarousel($html, $start));
        $this->assertSame($end, ContentRenderer::outsideCarousel($html, $start + 1));
        $this->assertSame($end, ContentRenderer::outsideCarousel($html, strpos($html, '<figcaption>')));
        $this->assertSame($end, ContentRenderer::outsideCarousel($html, $end));
        $this->assertSame(2, ContentRenderer::outsideCarousel($html, 2));
        // Contenido sin H2 tras el carrusel: la tarjeta va al final, fuera del carrusel.
        $out = ContentRenderer::insertAfterHeading('<h2>A</h2><h2>B</h2>' . self::carousel(), 2, '<aside>X</aside>');
        $this->assertStringEndsWith('</h2><aside>X</aside>' . self::carousel(), $out);
    }

    public function testAdsAreNeverInjectedInsideACarousel(): void
    {
        try {
            DB::value('SELECT 1');
        } catch (\Throwable) {
            $this->markTestSkipped('Base de datos no disponible (ajustes de anuncios)');
        }
        $before = [Config::get('ADSENSE_CLIENT'), Config::get('ADSENSE_SLOT_TOP'), Config::get('ADSENSE_SLOT_MIDDLE'), Config::get('ADSENSE_SLOT_BOTTOM')];
        Config::set('ADSENSE_CLIENT', 'ca-pub-0000');
        Config::set('ADSENSE_SLOT_TOP', '111');
        Config::set('ADSENSE_SLOT_MIDDLE', '222');
        Config::set('ADSENSE_SLOT_BOTTOM', '333');
        try {
            $clean = (new HtmlCleaner())->sanitize('<h2>Uno</h2>' . self::carousel() . '<h2>Dos</h2>' . self::carousel() . '<h2>Tres</h2>' . self::carousel() . '<h2>Cuatro</h2>' . self::carousel());
            $html = (new \ReflectionMethod(ContentRenderer::class, 'insertAds'))->invoke(null, ContentRenderer::carousels($clean));
            preg_match_all('#<div class="carousel-gallery".*?</div>#s', $html, $m);
            $this->assertCount(4, $m[0]);
            foreach ($m[0] as $block) {
                $this->assertStringNotContainsString('ad-slot', $block);
                $this->assertSame(3, substr_count($block, 'carousel-gallery__item'));
            }
            $this->assertGreaterThan(0, substr_count($html, 'class="ad-slot"'));
        } finally {
            foreach (['ADSENSE_CLIENT', 'ADSENSE_SLOT_TOP', 'ADSENSE_SLOT_MIDDLE', 'ADSENSE_SLOT_BOTTOM'] as $i => $key) {
                Config::set($key, $before[$i]);
            }
        }
    }

    // ------------------------------------------------------------------ Conversión (seed 19)

    public function testConverterTurnsTheFundalesSectionIntoOneCarousel(): void
    {
        $cleaner = new HtmlCleaner();
        $source = $cleaner->sanitize((string) file_get_contents(__DIR__ . '/fixtures/carousel_fundales.html'));
        $result = CarouselConverter::section($source, ['La Mejor Herramienta de Preparación'], $cleaner);

        $this->assertTrue($result['changed']);
        $this->assertSame(4, $result['images']);
        $this->assertSame('Concurso Docente 2026 Preguntas simulador', $result['alts'][2], 'alt sin el salto de línea final');
        $this->assertStringContainsString('«La Mejor Herramienta de Preparación: Fundales.com»: 4 imágenes convertidas', $result['message']);
        $html = $result['html'];
        $this->assertSame(1, substr_count($html, '<div class="carousel-gallery">'));
        preg_match('#<div class="carousel-gallery">(.*?)</div>#s', $html, $m);
        $this->assertSame(4, substr_count($m[1], '<figure class="carousel-gallery__item"><img'));
        $this->assertStringContainsString('<figcaption>Concurso Docente 2026 Preguntas CNSC</figcaption>', $m[1]);
        $this->assertStringContainsString('srcset="', $m[1]);
        $this->assertStringContainsString('alt="Concurso Docente 2026 Preguntas simulador" width="1024"', $m[1]);
        // El carrusel queda entre el párrafo de la sección y el H3; el video y la sección siguiente no cambian.
        $this->assertMatchesRegularExpression('#la plataforma líder\.</p>\s*<div class="carousel-gallery">.*?</div>\s*<h3 id="por-que-fundales-com-es-tu-mejor-aliado">#s', $html);
        $this->assertStringContainsString('<figure class="lite-yt" data-yt="1rTzLsJBT6E">', $html);
        $this->assertSame(2, substr_count($html, '<figure><img src="' . self::IMG . 'ruta-'));
        $this->assertSame(HtmlCleaner::toText($source), HtmlCleaner::toText($html));
        $this->assertSame($html, $cleaner->sanitize($html));

        // Idempotente.
        $again = CarouselConverter::section($html, ['La Mejor Herramienta de Preparación'], $cleaner);
        $this->assertFalse($again['changed']);
        $this->assertSame($html, $again['html']);
        $this->assertStringContainsString('ya tiene un carrusel', $again['message']);
    }

    public function testConverterFindsTheHeadingWithoutCaseOrAccentsAndLooseImages(): void
    {
        $html = '<h2>la mejor HERRAMIENTA de preparacion: Fundales</h2><p>Texto.</p>'
            . '<p><img src="' . self::IMG . 'a.jpg" alt=" A "></p><p><a href="' . self::IMG . 'b.jpg"><img src="' . self::IMG . 'b.jpg" alt="B"></a></p>'
            . '<figure><img src="' . self::IMG . 'c.jpg" alt="C"><figcaption>Pie C</figcaption></figure>'
            . '<p>Un párrafo corta el tramo.</p><figure><img src="' . self::IMG . 'd.jpg" alt="D"></figure><h2>Otra</h2>';
        $result = CarouselConverter::section((new HtmlCleaner())->sanitize($html), 'La Mejor Herramienta de Preparación');
        $this->assertTrue($result['changed']);
        $this->assertSame(['A', 'B', 'C'], $result['alts']);
        $this->assertMatchesRegularExpression('#<p>Texto\.</p><div class="carousel-gallery">.*<figcaption>Pie C</figcaption></figure>\s*</div><p>Un párrafo corta el tramo\.</p><figure><img src="[^"]+d\.jpg"#s', $result['html']);
    }

    public function testConverterLeavesContentAloneWhenThereIsNothingToDo(): void
    {
        $missing = CarouselConverter::section('<h2>Otro tema</h2><figure><img src="/a.jpg" alt="A"></figure><figure><img src="/b.jpg" alt="B"></figure>', 'La Mejor Herramienta');
        $this->assertFalse($missing['changed']);
        $this->assertStringContainsString('No se encontró el encabezado', $missing['message']);
        $single = CarouselConverter::section('<h2>La Mejor Herramienta</h2><figure><img src="/a.jpg" alt="A"></figure><p>Texto</p><figure><img src="/b.jpg" alt="B"></figure>', 'La Mejor Herramienta');
        $this->assertFalse($single['changed']);
        $this->assertStringContainsString('1 imagen(es)', $single['message']);
    }

    public function testSeedFileReturnsAClosure(): void
    {
        $seed = require dirname(__DIR__) . '/database/seeds/19_carrusel_fundales.php';
        $this->assertInstanceOf(\Closure::class, $seed);
    }
}
