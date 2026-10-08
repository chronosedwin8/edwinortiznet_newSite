<?php

declare(strict_types=1);

namespace App\Services\Content;

use App\Core\Config;
use App\Core\View;
use App\Models\Hub;
use App\Models\Post;
use App\Models\Product;
use App\Models\Setting;

/**
 * Convierte el HTML guardado en HTML de página: resuelve marcadores, genera la tabla de contenido,
 * inserta la tarjeta de producto relacionada y reserva los espacios de anuncios.
 */
final class ContentRenderer
{
    /**
     * @return array{html:string, toc: array<int, array{id:string,text:string}>}
     */
    public static function render(array $post, ?array $relatedProduct = null, bool $ads = false, ?string $inlineHtml = null): array
    {
        $locale = $post['locale'];
        $html = (string) $post['content_html'];

        // Marcadores {{productos:slug1,slug2}} y {{articulos:hub}}
        $html = preg_replace_callback('#<p>\s*\{\{productos:([^}]*)\}\}\s*</p>|\{\{productos:([^}]*)\}\}#u', function (array $m) use ($locale): string {
            $arg = trim($m[1] !== '' ? $m[1] : ($m[2] ?? ''));
            $products = $arg === 'destacados' || $arg === ''
                ? Product::bestSellers($locale, 3)
                : Product::bySlugs(array_map('trim', explode(',', $arg)), $locale);
            if ($products === []) {
                return '';
            }
            return View::render('partials/product-grid', ['products' => $products, 'compact' => true]);
        }, $html) ?? $html;

        $html = preg_replace_callback('#<p>\s*\{\{articulos:([a-z0-9-]*)\}\}\s*</p>|\{\{articulos:([a-z0-9-]*)\}\}#u', function (array $m) use ($post, $locale): string {
            $key = $m[1] !== '' ? $m[1] : ($m[2] ?? 'blog');
            $hub = $key !== 'blog' ? Hub::byKey($key, $locale) : null;
            $posts = Post::latest($locale, 4, 0, $hub ? (int) $hub['id'] : null, [(int) $post['id']]);
            if ($posts === []) {
                return '';
            }
            return View::render('partials/inline-posts', ['posts' => $posts]);
        }, $html) ?? $html;

        $html = self::describeGenericLinks($html);
        $html = self::carousels($html);
        // Miniaturas de YouTube: 320 px en pantallas pequeñas, 480 px en el resto.
        $html = (string) preg_replace(
            '#src="https://i\.ytimg\.com/vi/([A-Za-z0-9_-]{11})/hqdefault\.jpg"#',
            'src="https://i.ytimg.com/vi/$1/hqdefault.jpg" srcset="https://i.ytimg.com/vi/$1/mqdefault.jpg 320w, https://i.ytimg.com/vi/$1/hqdefault.jpg 480w" sizes="(min-width: 760px) 720px, 300px"',
            $html
        );

        // Tabla de contenido desde los H2
        $toc = [];
        if (preg_match_all('#<h2 id="([^"]+)"[^>]*>(.*?)</h2>#is', $html, $m, PREG_SET_ORDER)) {
            foreach ($m as $h) {
                $text = trim(html_entity_decode(strip_tags($h[2]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
                if ($text !== '') {
                    $toc[] = ['id' => $h[1], 'text' => $text];
                }
            }
        }

        // Tarjeta de producto después del segundo H2 (tras su primer párrafo).
        if ($inlineHtml !== null) {
            $html = self::insertAfterHeading($html, 2, $inlineHtml);
        } elseif ($relatedProduct !== null) {
            $card = View::render('partials/product-inline', ['product' => $relatedProduct]);
            $html = self::insertAfterHeading($html, 2, $card);
        }

        if ($ads && empty($post['no_ads']) && Setting::get('ads_enabled', '1') === '1' && Config::get('ADSENSE_CLIENT')) {
            $html = self::insertAds($html);
        }
        return ['html' => $html, 'toc' => $toc];
    }

    /**
     * Preguntas frecuentes escritas dentro del artículo: un H2 «Preguntas frecuentes» seguido de
     * pares H3 (pregunta) + párrafos (respuesta). Alimenta el JSON-LD FAQPage.
     *
     * @return array<int, array{q:string, a:string}>
     */
    public static function faqs(string $html): array
    {
        if (!preg_match('#<h2[^>]*>\s*(?:preguntas frecuentes|frequently asked questions|faq)\b.*?</h2>(.*?)(?=<h2\b|$)#isu', $html, $section)) {
            return [];
        }
        preg_match_all('#<h3[^>]*>(.*?)</h3>(.*?)(?=<h3\b|$)#is', $section[1], $pairs, PREG_SET_ORDER);
        $faqs = [];
        foreach ($pairs as [, $q, $a]) {
            $q = trim(html_entity_decode(strip_tags($q), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            $a = trim((string) preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($a), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
            if ($q !== '' && $a !== '') {
                $faqs[] = ['q' => $q, 'a' => $a];
            }
        }
        return $faqs;
    }

    /**
     * Enlaces con texto genérico ("aquí", "here"…): se añade el destino en texto oculto visualmente,
     * para lectores de pantalla y buscadores, sin cambiar lo que se ve.
     */
    public static function describeGenericLinks(string $html): string
    {
        $generic = '/^(aqu[ií]|click aqu[ií]|clic aqu[ií]|haz clic aqu[ií]|da clic aqu[ií]|here|click here|este enlace|this link|ver m[aá]s|leer m[aá]s|m[aá]s informaci[oó]n|see more|read more|link|enlace)[.:!]?$/iu';
        return (string) preg_replace_callback('#<a\b([^>]*)\bhref="([^"]+)"([^>]*)>(.*?)</a>#is', function (array $m) use ($generic): string {
            $text = trim(html_entity_decode(strip_tags($m[4]), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
            if (!preg_match($generic, $text)) {
                return $m[0];
            }
            $href = html_entity_decode($m[2]);
            $label = null;
            if (preg_match('#^/(?:en/)?(?:producto/|product/)?([a-z0-9-]+)/$#', $href, $s)) {
                $label = \App\Core\DB::value('SELECT title FROM posts WHERE slug = :s LIMIT 1', ['s' => $s[1]])
                    ?? \App\Core\DB::value('SELECT title FROM product_translations WHERE slug = :s LIMIT 1', ['s' => $s[1]]);
            }
            if ($label === null) {
                $host = (string) parse_url($href, PHP_URL_HOST);
                $label = $host !== '' ? preg_replace('/^www\./', '', $host) : null;
            }
            if ($label === null) {
                return $m[0];
            }
            return '<a' . $m[1] . 'href="' . $m[2] . '"' . $m[3] . '>' . $m[4]
                . '<span class="visually-hidden"> (' . e($label) . ')</span></a>';
        }, $html);
    }

    /** Inserta $snippet tras el primer párrafo que sigue al H2 número $n (o al final). */
    public static function insertAfterHeading(string $html, int $n, string $snippet): string
    {
        $offset = 0;
        for ($i = 0; $i < $n; $i++) {
            $pos = stripos($html, '<h2', $offset);
            if ($pos === false) {
                return $html . $snippet;
            }
            $offset = $pos + 3;
        }
        $end = stripos($html, '</p>', $offset);
        $nextH2 = stripos($html, '<h2', $offset);
        if ($end === false || ($nextH2 !== false && $nextH2 < $end)) {
            $close = stripos($html, '</h2>', $offset);
            $at = $close === false ? strlen($html) : $close + 5;
        } else {
            $at = $end + 4;
        }
        $at = self::outsideCarousel($html, $at); // defensa: el carrusel no lleva <p> ni <h2> dentro
        return substr($html, 0, $at) . $snippet . substr($html, $at);
    }

    /**
     * Carruseles de imágenes guardados como <div class="carousel-gallery"><figure class="carousel-gallery__item">…
     * (forma que garantiza HtmlCleaner): se añade la semántica del patrón «carrusel» de WAI-ARIA, la proporción
     * común de las diapositivas (--cg-ratio, la imagen más alta, sin pasar de 1:1, para que nada se recorte ni salte)
     * y los textos que usa carousel.js. Sin JavaScript queda una tira desplazable con scroll-snap.
     */
    public static function carousels(string $html): string
    {
        if (!str_contains($html, '<div class="carousel-gallery"')) {
            return $html;
        }
        $index = 0;
        return (string) preg_replace_callback('#<div class="carousel-gallery"([^>]*)>(.*?)</div>#s', function (array $m) use (&$index): string {
            $index++;
            $total = preg_match_all('#<figure class="carousel-gallery__item"#', $m[2]);
            $ratio = null;
            if (preg_match_all('#<img\b[^>]*?\swidth="(\d+)"[^>]*?\sheight="(\d+)"#', $m[2], $dims, PREG_SET_ORDER)) {
                foreach ($dims as [, $w, $h]) {
                    if ((int) $w > 0 && (int) $h > 0 && ($ratio === null || (int) $h / (int) $w > $ratio[1] / $ratio[0])) {
                        $ratio = [(int) $w, (int) $h];
                    }
                }
            }
            if ($ratio !== null && $ratio[1] > $ratio[0]) {
                $ratio = [1, 1];
            }
            $i = 0;
            $slides = (string) preg_replace_callback('#<figure class="carousel-gallery__item">#', function () use (&$i, $total): string {
                $i++;
                return '<figure class="carousel-gallery__item" role="group" aria-roledescription="' . e(t('carousel.slide')) . '" aria-label="'
                    . e(t('carousel.slide_of', ['i' => $i, 'n' => $total])) . '">';
            }, $m[2]);
            $attrs = ' id="carrusel-' . $index . '" role="region" aria-roledescription="' . e(t('carousel.role')) . '"'
                . ' aria-label="' . e(t('carousel.label', ['n' => $total])) . '" tabindex="0"'
                . ($ratio !== null ? ' style="--cg-ratio: ' . $ratio[0] . ' / ' . $ratio[1] . '"' : '')
                . ' data-label-prev="' . e(t('carousel.prev')) . '" data-label-next="' . e(t('carousel.next')) . '"'
                . ' data-label-goto="' . e(t('carousel.goto')) . '" data-label-status="' . e(t('carousel.status')) . '"'
                . ' data-label-pause="' . e(t('carousel.pause')) . '" data-label-play="' . e(t('carousel.play')) . '"';
            return '<div class="carousel-gallery"' . $m[1] . $attrs . '>' . $slides . '</div>';
        }, $html);
    }

    /** Scripts que necesita el HTML ya renderizado (carousel.js solo si hay carruseles). */
    public static function scripts(string $html): array
    {
        return str_contains($html, '<div class="carousel-gallery"') ? ['js/carousel.js'] : [];
    }

    /** Si $pos cae dentro de un carrusel, devuelve la posición justo después de su cierre. */
    public static function outsideCarousel(string $html, int $pos): int
    {
        $offset = 0;
        while (($start = stripos($html, '<div class="carousel-gallery"', $offset)) !== false && $start < $pos) {
            $close = stripos($html, '</div>', $start);
            if ($close === false) {
                return $pos;
            }
            if ($pos < $close + 6) {
                return $close + 6;
            }
            $offset = $close + 6;
        }
        return $pos;
    }

    /** Máximo tres bloques, con espacio reservado (no mueven el contenido). */
    private static function insertAds(string $html): string
    {
        $max = max(0, min(3, (int) Setting::get('adsense_max_blocks', '3')));
        $slots = array_slice(array_values(array_filter([
            Config::get('ADSENSE_SLOT_TOP'),
            Config::get('ADSENSE_SLOT_MIDDLE'),
            Config::get('ADSENSE_SLOT_BOTTOM'),
        ])), 0, $max);
        if ($slots === []) {
            return $html;
        }
        $block = static fn (string $slot): string => '<aside class="ad-slot" aria-label="' . e(t('ads.label')) . '"><ins class="adsbygoogle" data-ad-slot="' . e($slot) . '" data-ad-format="auto" data-full-width-responsive="true"></ins></aside>';
        preg_match_all('#<h2#i', $html, $m, PREG_OFFSET_CAPTURE);
        $positions = array_column($m[0], 1);
        $inserts = [];
        if (isset($slots[0], $positions[0])) {
            $inserts[$positions[0]] = $block($slots[0]);
        }
        if (isset($slots[1]) && count($positions) >= 4) {
            $inserts[$positions[intdiv(count($positions), 2)]] = $block($slots[1]);
        }
        if (isset($slots[2]) && count($positions) >= 2) {
            $inserts[strlen($html)] = $block($slots[2]);
        }
        krsort($inserts);
        foreach ($inserts as $pos => $snippet) {
            $pos = self::outsideCarousel($html, $pos);
            $html = substr($html, 0, $pos) . $snippet . substr($html, $pos);
        }
        return $html;
    }
}
