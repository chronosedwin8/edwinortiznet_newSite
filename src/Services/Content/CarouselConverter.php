<?php

declare(strict_types=1);

namespace App\Services\Content;

use App\Services\Importer\HtmlCleaner;
use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;

/**
 * Convierte en un carrusel (.carousel-gallery) las imágenes seguidas de una sección del contenido.
 * La sección se ubica por el texto de su encabezado (H2–H4, sin distinguir mayúsculas ni tildes) y termina
 * en el siguiente encabezado. Se toma el primer tramo de bloques que solo tienen imágenes (figuras, galerías
 * de WordPress con figuras anidadas, párrafos o enlaces con imágenes); el primer bloque con texto lo corta.
 * Conserva el texto alternativo (sin espacios sobrantes) y los pies de foto. Idempotente: si la sección ya
 * tiene un carrusel no cambia nada. El resultado pasa por HtmlCleaner::sanitize().
 */
final class CarouselConverter
{
    /**
     * @param string|string[] $headings textos posibles del encabezado (basta con que el encabezado los contenga)
     * @return array{html:string, changed:bool, images:int, alts:string[], message:string}
     */
    public static function section(string $html, string|array $headings, ?HtmlCleaner $cleaner = null, array $context = []): array
    {
        $result = ['html' => $html, 'changed' => false, 'images' => 0, 'alts' => [], 'message' => ''];
        $doc = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8"?><div id="eo-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $root = $doc->getElementById('eo-root');
        if ($root === null) {
            return ['message' => 'No se pudo leer el HTML.'] + $result;
        }

        $heading = null;
        foreach ((array) $headings as $needle) {
            foreach ($root->childNodes as $node) {
                if ($node instanceof DOMElement && preg_match('/^h[2-4]$/i', $node->tagName) && str_contains(self::fold($node->textContent), self::fold($needle))) {
                    $heading = $node;
                    break 2;
                }
            }
        }
        if ($heading === null) {
            return ['message' => 'No se encontró el encabezado «' . implode('» / «', (array) $headings) . '».'] + $result;
        }
        $title = trim(preg_replace('/\s+/u', ' ', $heading->textContent) ?? '');

        // Bloques de la sección hasta el siguiente encabezado.
        $run = [];
        $started = false;
        for ($node = $heading->nextSibling; $node !== null; $node = $node->nextSibling) {
            if ($node instanceof DOMText) {
                if (trim(str_replace("\u{00A0}", ' ', $node->textContent)) === '') {
                    if ($started) {
                        $run[] = $node;
                    }
                    continue;
                }
                if ($started) {
                    break;
                }
                continue;
            }
            if (!$node instanceof DOMElement) {
                continue;
            }
            $tag = strtolower($node->tagName);
            if (preg_match('/^h[1-6]$/', $tag)) {
                break;
            }
            if ($tag === 'div' && str_contains(' ' . $node->getAttribute('class') . ' ', ' ' . HtmlCleaner::CAROUSEL . ' ')) {
                return ['message' => "La sección «{$title}» ya tiene un carrusel: sin cambios."] + $result;
            }
            if (self::imageOnly($node)) {
                $started = true;
                $run[] = $node;
                continue;
            }
            if ($started) {
                break;
            }
        }
        while ($run !== [] && end($run) instanceof DOMText) {
            array_pop($run);
        }
        $images = [];
        foreach ($run as $node) {
            if ($node instanceof DOMElement) {
                foreach ($node->tagName === 'img' ? [$node] : iterator_to_array($node->getElementsByTagName('img')) as $img) {
                    $images[] = $img;
                }
            }
        }
        if (count($images) < 2) {
            return ['message' => "La sección «{$title}» tiene " . count($images) . ' imagen(es) seguidas: no hace falta un carrusel.'] + $result;
        }

        $carousel = $doc->createElement('div');
        $carousel->setAttribute('class', HtmlCleaner::CAROUSEL);
        $run[0]->parentNode?->insertBefore($carousel, $run[0]);
        foreach ($run as $node) {
            $carousel->appendChild($node);
        }
        $alts = [];
        foreach ($images as $img) {
            $alt = trim(preg_replace('/\s+/u', ' ', $img->getAttribute('alt')) ?? '');
            $img->setAttribute('alt', $alt);
            $alts[] = $alt;
        }

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }
        $out = ($cleaner ?? new HtmlCleaner())->sanitize($out, $context);
        return [
            'html' => $out,
            'changed' => true,
            'images' => count($images),
            'alts' => $alts,
            'message' => 'Sección «' . $title . '»: ' . count($images) . ' imágenes convertidas en un carrusel.',
        ];
    }

    /** Un bloque que solo contiene imágenes (y pies de foto). */
    private static function imageOnly(DOMElement $node): bool
    {
        $tag = strtolower($node->tagName);
        if ($tag === 'img') {
            return true;
        }
        if (!in_array($tag, ['figure', 'p', 'a', 'div'], true) || $node->getElementsByTagName('img')->length === 0) {
            return false;
        }
        if (str_contains(' ' . $node->getAttribute('class') . ' ', ' lite-yt ') || $node->getElementsByTagName('video')->length > 0
            || $node->getElementsByTagName('table')->length > 0 || $node->getElementsByTagName('iframe')->length > 0) {
            return false;
        }
        // El texto fuera de los pies de foto descalifica el bloque.
        $text = $node->textContent;
        foreach (iterator_to_array($node->getElementsByTagName('figcaption')) as $cap) {
            $text = str_replace($cap->textContent, '', $text);
        }
        return trim(str_replace("\u{00A0}", ' ', $text)) === '';
    }

    private static function fold(string $text): string
    {
        $text = mb_strtolower(trim(preg_replace('/\s+/u', ' ', $text) ?? ''));
        return strtr($text, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n']);
    }
}
