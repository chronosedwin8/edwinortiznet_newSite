<?php

declare(strict_types=1);

namespace App\Services\Importer;

use DOMDocument;
use DOMElement;
use DOMNode;
use DOMText;
use DOMXPath;

/**
 * Limpieza del HTML de WordPress (Gutenberg y editor clásico) con lista blanca.
 * También la usa el panel para sanear el HTML que se guarda.
 */
final class HtmlCleaner
{
    private const ALLOWED = [
        'p', 'h2', 'h3', 'h4', 'ul', 'ol', 'li', 'a', 'img', 'figure', 'figcaption',
        'table', 'thead', 'tbody', 'tfoot', 'tr', 'th', 'td', 'caption',
        'blockquote', 'pre', 'code', 'strong', 'em', 'br', 'hr', 'video', 'span',
    ];
    private const RENAME = ['b' => 'strong', 'i' => 'em', 'h1' => 'h2', 'h5' => 'h4', 'h6' => 'h4', 'kbd' => 'code', 'tt' => 'code'];
    private const DROP = [
        'script', 'style', 'noscript', 'form', 'input', 'button', 'select', 'textarea', 'svg', 'object', 'embed',
        'link', 'meta', 'canvas', 'audio', 'template', 'head', 'title', 'iframe-placeholder',
    ];
    /** Clases propias que sobreviven al saneado. */
    private const CLASSES = ['lite-yt', 'lite-yt__link', 'lite-yt__play', 'gallery', 'table-wrap', 'embed-link', 'btn-link', 'notice', 'video'];
    private const ATTRS = [
        'a' => ['href', 'title', 'rel', 'target', 'class', 'data-yt', 'download'],
        'img' => ['src', 'alt', 'width', 'height', 'srcset', 'sizes', 'loading', 'decoding'],
        'td' => ['colspan', 'rowspan'],
        'th' => ['colspan', 'rowspan', 'scope'],
        'ol' => ['start', 'reversed'],
        'figure' => ['class', 'data-yt'],
        'video' => ['src', 'poster', 'controls', 'preload', 'playsinline', 'width', 'height'],
        'span' => ['class'],
        'p' => ['class'],
        'h2' => ['id'], 'h3' => ['id'], 'h4' => ['id'],
    ];

    /** @var array<int,string> wp_id de producto => slug */
    private array $productSlugs;

    public function __construct(
        private readonly ?AttachmentIndex $attachments = null,
        array $productSlugs = [],
        private readonly string $siteHost = 'edwinortiz.net',
    ) {
        $this->productSlugs = $productSlugs;
    }

    /**
     * @param array{slug?:string, title?:string, hub?:string|null} $context
     */
    public function clean(string $html, array $context = []): string
    {
        $html = $this->gutenberg($html, $context);
        $html = $this->shortcodes($html, $context);
        if (!str_contains($html, '<p') && !str_contains($html, '<h2')) {
            $html = self::autop($html);
        } elseif (!preg_match('/<!--\s*wp:/', $html) && preg_match('/\n\s*\n/', $html)) {
            $html = self::autop($html);
        }
        $html = preg_replace('/<!--.*?-->/s', '', $html) ?? $html;
        return $this->sanitize($html, $context);
    }

    // ------------------------------------------------------------------ Gutenberg

    private function gutenberg(string $html, array $context): string
    {
        // 1) Espaciadores y tiempo de lectura de Yoast: se eliminan.
        $html = preg_replace('#<!-- wp:spacer.*?<!-- /wp:spacer -->#s', '', $html) ?? $html;
        $html = preg_replace('#<!-- wp:yoast-seo/estimated-reading-time.*?<!-- /wp:yoast-seo/estimated-reading-time -->#s', '', $html) ?? $html;

        // 2) Productos de WooCommerce → marcador {{productos:slug1,slug2}}
        $html = preg_replace_callback('#<!-- wp:woocommerce/handpicked-products (\{.*?\}) /-->#s', function (array $m): string {
            $data = json_decode($m[1], true) ?: [];
            $slugs = [];
            foreach (($data['products'] ?? []) as $id) {
                if (isset($this->productSlugs[(int) $id])) {
                    $slugs[] = $this->productSlugs[(int) $id];
                }
            }
            return $slugs ? "\n<p>{{productos:" . implode(',', array_unique($slugs)) . "}}</p>\n" : '';
        }, $html) ?? $html;
        $html = preg_replace('#<!-- wp:woocommerce/product-tag .*? /-->#s', "\n<p>{{productos:destacados}}</p>\n", $html) ?? $html;

        // 3) Content Views → marcador {{articulos:hub}}
        $hub = $context['hub'] ?? null;
        $html = preg_replace('#<!-- wp:contentviews/[a-z0-9-]+ .*? /-->#s', "\n<p>{{articulos:" . ($hub ?: 'blog') . "}}</p>\n", $html) ?? $html;

        // 4) Bloques de tomsneddon → <video> o galería simple
        $html = preg_replace_callback('#<!-- wp:tomsneddon-video-player/[a-z0-9-]+ (\{.*?\}) /-->#s', function (array $m): string {
            $data = json_decode($m[1], true) ?: [];
            $src = (string) ($data['videoSource'] ?? '');
            if (!preg_match('#^https://#', $src)) {
                return '';
            }
            $poster = (string) ($data['posterImg'] ?? '');
            return "\n<figure class=\"video\"><video controls preload=\"none\" playsinline src=\"" . htmlspecialchars($src) . '"'
                . ($poster !== '' ? ' poster="' . htmlspecialchars($poster) . '"' : '') . "></video></figure>\n";
        }, $html) ?? $html;
        $html = preg_replace_callback('#<!-- wp:tomsneddon-image-slider/[a-z0-9-]+ (\{.*?\}) /-->#s', function (array $m) use ($context): string {
            $data = json_decode($m[1], true) ?: [];
            $images = array_filter((array) ($data['galleryImages'] ?? []), fn ($u) => is_string($u) && str_starts_with($u, 'https://'));
            if (!$images) {
                return '';
            }
            $out = "\n<figure class=\"gallery\">";
            foreach (array_values($images) as $i => $url) {
                $out .= '<img src="' . htmlspecialchars($url) . '" alt="' . htmlspecialchars(($context['title'] ?? '') . ' (' . ($i + 1) . ')') . '">';
            }
            return $out . "</figure>\n";
        }, $html) ?? $html;

        // 5) Embebidos: YouTube → componente lite; otros → enlace.
        $html = preg_replace_callback('#<!-- wp:embed (\{.*?\}) -->.*?<!-- /wp:embed -->#s', function (array $m) use ($context): string {
            $data = json_decode($m[1], true) ?: [];
            return $this->embed((string) ($data['url'] ?? ''), $context);
        }, $html) ?? $html;

        return $html;
    }

    private function shortcodes(string $html, array $context): string
    {
        $html = preg_replace_callback('#\[embed\](.*?)\[/embed\]#s', fn ($m) => $this->embed(trim(strip_tags($m[1])), $context), $html) ?? $html;
        $html = preg_replace('#\[pt_view[^\]]*\]#', "\n<p>{{articulos:" . (($context['hub'] ?? null) ?: 'blog') . "}}</p>\n", $html) ?? $html;
        $html = preg_replace_callback('#\[caption([^\]]*)\](.*?)\[/caption\]#s', function (array $m): string {
            $inner = $m[2];
            if (preg_match('#^\s*((?:<a[^>]*>)?\s*<img[^>]*>\s*(?:</a>)?)(.*)$#s', $inner, $parts)) {
                $caption = trim(strip_tags($parts[2]));
                return "\n<figure>" . $parts[1] . ($caption !== '' ? '<figcaption>' . htmlspecialchars($caption, ENT_NOQUOTES) . '</figcaption>' : '') . "</figure>\n";
            }
            return $inner;
        }, $html) ?? $html;
        $html = preg_replace('#\[/?(woocommerce_[a-z_]+|contact-form-7|gallery|audio|video|playlist)[^\]]*\]#', '', $html) ?? $html;
        return $html;
    }

    private function embed(string $url, array $context): string
    {
        $url = html_entity_decode(trim($url));
        if ($url === '') {
            return '';
        }
        $id = self::youtubeId($url);
        if ($id !== null) {
            return "\n" . self::liteYoutube($id, (string) ($context['title'] ?? '')) . "\n";
        }
        return "\n<p class=\"embed-link\"><a href=\"" . htmlspecialchars($url) . '">' . htmlspecialchars($url, ENT_NOQUOTES) . "</a></p>\n";
    }

    public static function youtubeId(string $url): ?string
    {
        if (preg_match('#(?:youtu\.be/|youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/))([A-Za-z0-9_-]{11})#', $url, $m)) {
            return $m[1] === 'videoseries' ? null : $m[1];
        }
        return null;
    }

    /** Miniatura + botón; el iframe de youtube-nocookie.com se crea al hacer clic (JS). */
    public static function liteYoutube(string $id, string $title): string
    {
        $alt = trim('Video: ' . $title);
        return '<figure class="lite-yt" data-yt="' . $id . '">'
            . '<a class="lite-yt__link" href="https://www.youtube.com/watch?v=' . $id . '" data-yt="' . $id . '">'
            . '<img src="https://i.ytimg.com/vi/' . $id . '/hqdefault.jpg" alt="' . htmlspecialchars($alt) . '" width="480" height="360">'
            . '<span class="lite-yt__play"></span></a></figure>';
    }

    /** Párrafos automáticos para contenido del editor clásico (versión reducida de wpautop). */
    public static function autop(string $html): string
    {
        $html = str_replace(["\r\n", "\r"], "\n", $html);
        $blocks = 'table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|form|map|area|blockquote|address|math|style|p|h[1-6]|hr|fieldset|legend|section|article|aside|hgroup|header|footer|nav|figure|figcaption|details|menu|summary|iframe|video';
        $html = preg_replace('#(<(?:' . $blocks . ')[\s/>])#i', "\n\n$1", $html) ?? $html;
        $html = preg_replace('#(</(?:' . $blocks . ')>)#i', "$1\n\n", $html) ?? $html;
        $chunks = preg_split('/\n\s*\n/', $html) ?: [];
        $out = '';
        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if ($chunk === '') {
                continue;
            }
            if (preg_match('#^</?(?:' . $blocks . ')[\s/>]#i', $chunk)) {
                $out .= $chunk . "\n";
            } else {
                $out .= '<p>' . preg_replace('/\n/', "<br>\n", $chunk) . "</p>\n";
            }
        }
        return $out;
    }

    // ------------------------------------------------------------------ Lista blanca (DOM)

    public function sanitize(string $html, array $context = []): string
    {
        if (trim($html) === '') {
            return '';
        }
        $doc = new DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8"?><div id="eo-root">' . $html . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET);
        libxml_clear_errors();
        libxml_use_internal_errors($previous);
        $root = $doc->getElementById('eo-root');
        if ($root === null) {
            return '';
        }
        $this->walk($root, $doc, $context);
        $this->postProcess($root, $doc, $context);

        $out = '';
        foreach ($root->childNodes as $child) {
            $out .= $doc->saveHTML($child);
        }
        $out = preg_replace('#<p>(?:\s|&nbsp;|\x{00A0}|<br>)*</p>#u', '', $out) ?? $out;
        $out = preg_replace("/\n{3,}/", "\n\n", $out) ?? $out;
        return trim($out);
    }

    private function walk(DOMNode $parent, DOMDocument $doc, array $context): void
    {
        $children = [];
        foreach ($parent->childNodes as $child) {
            $children[] = $child;
        }
        foreach ($children as $node) {
            if ($node instanceof DOMText) {
                continue;
            }
            if (!$node instanceof DOMElement) {
                $parent->removeChild($node); // comentarios, PI, etc.
                continue;
            }
            $tag = strtolower($node->tagName);
            if (in_array($tag, self::DROP, true)) {
                $parent->removeChild($node);
                continue;
            }
            if ($tag === 'iframe') {
                $this->replaceIframe($node, $doc, $context);
                continue;
            }
            if (isset(self::RENAME[$tag])) {
                $node = $this->rename($node, self::RENAME[$tag], $doc);
                $tag = self::RENAME[$tag];
            }
            $this->walk($node, $doc, $context);
            if ($tag === 'span' && !$this->hasOwnClass($node)) {
                $this->unwrap($node);
                continue;
            }
            if (!in_array($tag, self::ALLOWED, true)) {
                $this->unwrap($node);
                continue;
            }
            $this->filterAttributes($node, $tag);
            if ($tag === 'img') {
                $this->image($node, $context);
            } elseif ($tag === 'a') {
                $this->link($node, $context);
            }
        }
    }

    private function hasOwnClass(DOMElement $el): bool
    {
        foreach (preg_split('/\s+/', (string) $el->getAttribute('class')) ?: [] as $class) {
            if (in_array($class, self::CLASSES, true)) {
                return true;
            }
        }
        return false;
    }

    private function rename(DOMElement $node, string $tag, DOMDocument $doc): DOMElement
    {
        $new = $doc->createElement($tag);
        foreach (iterator_to_array($node->attributes ?? []) as $attr) {
            $new->setAttribute($attr->nodeName, $attr->nodeValue ?? '');
        }
        while ($node->firstChild) {
            $new->appendChild($node->firstChild);
        }
        $node->parentNode?->replaceChild($new, $node);
        return $new;
    }

    private function unwrap(DOMElement $node): void
    {
        $parent = $node->parentNode;
        if ($parent === null) {
            return;
        }
        // Un bloque desenvuelto dentro de otro bloque deja un salto para no pegar palabras.
        while ($node->firstChild) {
            $parent->insertBefore($node->firstChild, $node);
        }
        if (in_array(strtolower($node->tagName), ['div', 'section', 'center', 'article', 'header', 'footer'], true)) {
            $parent->insertBefore($node->ownerDocument->createTextNode("\n"), $node);
        }
        $parent->removeChild($node);
    }

    private function filterAttributes(DOMElement $node, string $tag): void
    {
        $allowed = self::ATTRS[$tag] ?? [];
        foreach (iterator_to_array($node->attributes ?? []) as $attr) {
            $name = strtolower($attr->nodeName);
            if (!in_array($name, $allowed, true)) {
                $node->removeAttribute($attr->nodeName);
                continue;
            }
            if ($name === 'class') {
                $classes = array_values(array_intersect(preg_split('/\s+/', (string) $attr->nodeValue) ?: [], self::CLASSES));
                $classes ? $node->setAttribute('class', implode(' ', $classes)) : $node->removeAttribute('class');
            }
            if (in_array($name, ['width', 'height'], true) && !ctype_digit((string) $attr->nodeValue)) {
                $node->removeAttribute($attr->nodeName);
            }
            if (in_array($name, ['src', 'href', 'poster'], true)) {
                $value = trim((string) $attr->nodeValue);
                if (preg_match('#^\s*(javascript|data|vbscript):#i', $value)) {
                    $node->removeAttribute($attr->nodeName);
                }
            }
        }
    }

    private function replaceIframe(DOMElement $node, DOMDocument $doc, array $context): void
    {
        $src = (string) $node->getAttribute('src');
        $id = self::youtubeId($src);
        $parent = $node->parentNode;
        if ($parent === null) {
            return;
        }
        if ($id !== null) {
            $tmp = new DOMDocument('1.0', 'UTF-8');
            $prev = libxml_use_internal_errors(true);
            $tmp->loadHTML('<?xml encoding="utf-8"?><div>' . self::liteYoutube($id, (string) ($context['title'] ?? '')) . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD | LIBXML_NONET);
            libxml_clear_errors();
            libxml_use_internal_errors($prev);
            $figure = $tmp->getElementsByTagName('figure')->item(0);
            if ($figure !== null) {
                $parent->replaceChild($doc->importNode($figure, true), $node);
            } else {
                $parent->removeChild($node);
            }
            return;
        }
        if (preg_match('#youtube(?:-nocookie)?\.com/embed/videoseries\?list=([A-Za-z0-9_-]+)#', $src, $m)) {
            $src = 'https://www.youtube.com/playlist?list=' . $m[1];
        }
        if (preg_match('#^https?://#', $src)) {
            $p = $doc->createElement('p');
            $p->setAttribute('class', 'embed-link');
            $a = $doc->createElement('a');
            $a->setAttribute('href', $src);
            $a->setAttribute('target', '_blank');
            $a->setAttribute('rel', 'noopener');
            $a->appendChild($doc->createTextNode(str_contains($src, 'genial.ly') ? 'Ver la presentación interactiva' : 'Abrir el contenido embebido'));
            $p->appendChild($a);
            $parent->replaceChild($p, $node);
            return;
        }
        $parent->removeChild($node);
    }

    private function image(DOMElement $img, array $context): void
    {
        $src = trim((string) $img->getAttribute('src'));
        if ($src === '' || !preg_match('#^(https?:)?//|^/#', $src)) {
            $img->parentNode?->removeChild($img);
            return;
        }
        $resolved = $this->attachments?->resolve($src);
        if ($resolved !== null) {
            $img->setAttribute('src', str_replace(' ', '%20', $resolved['url']));
            if ($resolved['width'] > 0 && $resolved['height'] > 0) {
                $img->setAttribute('width', (string) $resolved['width']);
                $img->setAttribute('height', (string) $resolved['height']);
            }
            $srcset = $this->attachments?->srcset($resolved['attachment'], max(720, $resolved['width']));
            if ($srcset !== null) {
                $img->setAttribute('srcset', $srcset);
                $img->setAttribute('sizes', '(min-width: 760px) 720px, 100vw');
            }
            if (trim((string) $img->getAttribute('alt')) === '') {
                $alt = $resolved['attachment']['alt'];
                if ($alt === '' && !preg_match('/^[\w\-\s]+$/u', $resolved['attachment']['title']) ) {
                    $alt = $resolved['attachment']['title'];
                }
                if ($alt !== '') {
                    $img->setAttribute('alt', $alt);
                }
            }
        }
        if (trim((string) $img->getAttribute('alt')) === '') {
            $img->setAttribute('alt', (string) ($context['title'] ?? ''));
        }
        // Si el ancho o el alto faltan, se retiran ambos para no deformar.
        if (!$img->hasAttribute('width') || !$img->hasAttribute('height')) {
            $img->removeAttribute('width');
            $img->removeAttribute('height');
        }
        $img->setAttribute('loading', 'lazy');
        $img->setAttribute('decoding', 'async');
    }

    private function link(DOMElement $a, array $context): void
    {
        $href = trim(html_entity_decode((string) $a->getAttribute('href')));
        if ($href === '') {
            $a->removeAttribute('href');
            if (!$a->hasAttribute('data-yt')) {
                $this->unwrap($a);
            }
            return;
        }
        if (!preg_match('#^(https?://|mailto:|tel:|/|\#)#i', $href)) {
            $this->unwrap($a);
            return;
        }
        // Enlaces internos absolutos → relativos (funcionan en cualquier dominio).
        if (preg_match('#^https?://(?:www\.)?' . preg_quote($this->siteHost, '#') . '(/[^\s]*)?$#i', $href, $m)) {
            $path = $m[1] ?? '/';
            if (!str_starts_with($path, '/wp-content/') && !str_starts_with($path, '/wp-admin/')) {
                $href = $path === '' ? '/' : $path;
            } else {
                $resolved = $this->attachments?->resolve($href);
                if ($resolved !== null) {
                    $href = $resolved['url'];
                }
            }
        }
        $rel = [];
        $host = strtolower((string) parse_url($href, PHP_URL_HOST));
        if (str_ends_with($host, 'fundales.com')) {
            $rel[] = 'noopener';
            $slug = (string) ($context['slug'] ?? '');
            $href = self::withUtm($href, $slug);
        }
        if (str_contains($host, 'lenovo-co.5nfc.net')) {
            $rel = array_merge($rel, ['sponsored', 'nofollow']);
        }
        if ($a->getAttribute('target') === '_blank') {
            $rel[] = 'noopener';
        } else {
            $a->removeAttribute('target');
        }
        $a->setAttribute('href', $href);
        $existing = array_filter(preg_split('/\s+/', strtolower((string) $a->getAttribute('rel'))) ?: [], fn ($r) => in_array($r, ['nofollow', 'sponsored', 'ugc', 'noopener', 'noreferrer'], true));
        $rel = array_values(array_unique(array_merge($existing, $rel)));
        $rel ? $a->setAttribute('rel', implode(' ', $rel)) : $a->removeAttribute('rel');
        if (preg_match('/wp-block-button__link/', (string) $a->getAttribute('class'))) {
            $a->setAttribute('class', 'btn-link');
        }
    }

    public static function withUtm(string $href, string $campaign): string
    {
        $parts = parse_url($href);
        parse_str((string) ($parts['query'] ?? ''), $query);
        $query = array_merge($query, [
            'utm_source' => 'edwinortiz.net',
            'utm_medium' => 'articulo',
            'utm_campaign' => $campaign !== '' ? $campaign : 'blog',
        ]);
        $url = ($parts['scheme'] ?? 'https') . '://' . ($parts['host'] ?? '') . ($parts['path'] ?? '/');
        return $url . '?' . http_build_query($query) . (isset($parts['fragment']) ? '#' . $parts['fragment'] : '');
    }

    private function postProcess(DOMElement $root, DOMDocument $doc, array $context): void
    {
        $xpath = new DOMXPath($doc);
        // Tablas con desplazamiento horizontal propio.
        foreach (iterator_to_array($xpath->query('.//table', $root) ?: []) as $table) {
            /** @var DOMElement $table */
            $parent = $table->parentNode;
            if ($parent instanceof DOMElement && strtolower($parent->tagName) === 'figure') {
                $parent->setAttribute('class', 'table-wrap');
                continue;
            }
            $figure = $doc->createElement('figure');
            $figure->setAttribute('class', 'table-wrap');
            $parent?->replaceChild($figure, $table);
            $figure->appendChild($table);
        }
        // Botones de Gutenberg sin clase reconocida.
        foreach (iterator_to_array($xpath->query('.//a[not(@class)]', $root) ?: []) as $a) {
            /** @var DOMElement $a */
            $text = trim($a->textContent);
            if ($a->parentNode instanceof DOMElement && strtolower($a->parentNode->tagName) === 'p'
                && trim($a->parentNode->textContent) === $text && preg_match('/^(comprar|descargar|ver |ir |más|adquirir)/iu', $text)) {
                $a->setAttribute('class', 'btn-link');
            }
        }
        // Jerarquía sin saltos (el H1 es el título): un H3/H4 que salta un nivel sube al siguiente válido.
        $previous = 1;
        foreach (iterator_to_array($xpath->query('.//h2|.//h3|.//h4', $root) ?: []) as $h) {
            /** @var DOMElement $h */
            $level = (int) substr($h->tagName, 1);
            if ($level > $previous + 1) {
                $level = $previous + 1;
                $h = $this->rename($h, 'h' . $level, $doc);
            }
            $previous = $level;
        }
        // Encabezados: id estable para la tabla de contenido.
        $used = [];
        foreach (iterator_to_array($xpath->query('.//h2|.//h3', $root) ?: []) as $h) {
            /** @var DOMElement $h */
            $id = self::slugify($h->textContent);
            if ($id === '') {
                continue;
            }
            $base = $id;
            $n = 2;
            while (isset($used[$id])) {
                $id = $base . '-' . $n++;
            }
            $used[$id] = true;
            $h->setAttribute('id', $id);
        }
        // Párrafos vacíos.
        foreach (iterator_to_array($xpath->query('.//p', $root) ?: []) as $p) {
            /** @var DOMElement $p */
            if (trim(str_replace("\u{00A0}", ' ', $p->textContent)) === '' && $xpath->query('.//img|.//video|.//br/following-sibling::*', $p)->length === 0) {
                $p->parentNode?->removeChild($p);
            }
        }
    }

    public static function slugify(string $text): string
    {
        $text = mb_strtolower(trim($text));
        $text = strtr($text, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'ü' => 'u', 'ñ' => 'n', 'à' => 'a', 'è' => 'e', 'ì' => 'i', 'ò' => 'o', 'ù' => 'u']);
        $text = preg_replace('/[^a-z0-9]+/', '-', $text) ?? '';
        return trim(substr($text, 0, 60), '-');
    }

    /** Texto plano para búsqueda. */
    public static function toText(string $html): string
    {
        $html = preg_replace('/\{\{[^}]+\}\}/', ' ', $html) ?? $html;
        $html = preg_replace('#<(br|/p|/h[2-4]|/li|/figcaption|/td|/th)\b[^>]*>#i', "$0 ", $html) ?? $html;
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        return trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    }

    public static function readingMinutes(string $text): int
    {
        $words = count(preg_split('/\s+/u', trim($text)) ?: []);
        return max(1, (int) ceil($words / 220));
    }

    /** Borrador de meta descripción (150–160 caracteres) a partir del primer párrafo con sustancia. */
    public static function draftDescription(string $html, string $fallback = ''): string
    {
        $text = '';
        if (preg_match_all('#<p[^>]*>(.*?)</p>#is', $html, $m)) {
            foreach ($m[1] as $p) {
                $candidate = self::toText($p);
                if (mb_strlen($candidate) >= 60 && !str_contains($candidate, '{{')) {
                    $text = $candidate;
                    break;
                }
            }
        }
        if ($text === '') {
            $text = self::toText($html) ?: $fallback;
        }
        if (mb_strlen($text) < 150) {
            $text = trim($text . ' ' . self::toText(mb_substr(self::toText($html), mb_strlen($text), 200)));
        }
        if (mb_strlen($text) <= 160) {
            return $text;
        }
        $cut = mb_substr($text, 0, 159);
        $space = mb_strrpos($cut, ' ');
        if ($space !== false && $space >= 140) {
            $cut = mb_substr($cut, 0, $space);
        }
        return rtrim($cut, " ,.;:") . '…';
    }
}
