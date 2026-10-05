<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Core\Config;
use App\Services\I18n\I18n;

/**
 * Metadatos de cada página: título, descripción, canonical, hreflang, Open Graph, robots y JSON-LD.
 */
final class Meta
{
    private static string $path = '/';

    public static function setPath(string $path): void
    {
        self::$path = $path;
    }

    public static function path(): string
    {
        return self::$path;
    }

    public static function complete(array $meta): array
    {
        $locale = I18n::locale();
        $site = I18n::t('site.name');
        $title = trim((string) ($meta['title'] ?? ''));
        if (!empty($meta['title_full'])) {
            $fullTitle = $title;
        } elseif ($title === '') {
            $fullTitle = I18n::t('seo.home.title');
        } else {
            $fullTitle = $title . ' | ' . $site;
            // Títulos SEO de 50 a 60 caracteres: si la versión larga se pasa, se quita el sufijo.
            if (mb_strlen($fullTitle) > 65) {
                $fullTitle = $title;
            }
        }
        $meta['full_title'] = $fullTitle;
        $meta['description'] = excerpt_text((string) ($meta['description'] ?? I18n::t('seo.home.description')), 160);
        $meta['canonical'] = url($meta['canonical'] ?? self::$path);

        $alternates = [];
        foreach (($meta['alternates'] ?? []) as $lang => $path) {
            if ($path) {
                $alternates[$lang] = url($path);
            }
        }
        // hreflang solo si existen ambas versiones (recíprocas).
        $meta['alternates'] = (isset($alternates['es'], $alternates['en'])) ? $alternates : [];
        $meta['switch_url'] = $alternates[I18n::other()] ?? null;

        $noindex = !empty($meta['noindex']) || Config::bool('NOINDEX');
        $meta['robots'] = $noindex ? 'noindex, follow' : 'index, follow, max-image-preview:large';
        $meta['og_type'] ??= 'website';
        $meta['image'] = $meta['image'] ?? url($locale === 'en' ? '/assets/img/og-default-en.png' : '/assets/img/og-default.png');
        $meta['og_locale'] = I18n::meta('og');
        $meta['og_locale_alternate'] = $meta['alternates'] ? I18n::meta('og', I18n::other()) : null;
        $meta['html_lang'] = I18n::meta('html');

        $jsonld = $meta['jsonld'] ?? [];
        if (!empty($meta['breadcrumbs'])) {
            $jsonld[] = self::breadcrumbList($meta['breadcrumbs']);
        }
        $meta['jsonld'] = $jsonld;
        $meta['ads'] = $meta['ads'] ?? false;
        $meta['locale'] = $locale;
        return $meta;
    }

    /** @param array<int, array{0:string,1:string}> $crumbs nombre, ruta */
    public static function breadcrumbList(array $crumbs): array
    {
        $items = [];
        foreach (array_values($crumbs) as $i => [$name, $path]) {
            $item = ['@type' => 'ListItem', 'position' => $i + 1, 'name' => $name];
            if ($path !== null) {
                $item['item'] = url($path);
            }
            $items[] = $item;
        }
        return ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $items];
    }

    public static function person(): array
    {
        return [
            '@type' => 'Person',
            '@id' => url('/#edwin'),
            'name' => 'Edwin Ortiz Herazo',
            'url' => url(I18n::locale() === 'en' ? '/en/about/' : '/sobre-mi/'),
            'jobTitle' => I18n::t('author.job'),
            'description' => I18n::t('author.bio_short'),
            'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Barranquilla', 'addressCountry' => 'CO'],
            'sameAs' => array_values(array_filter([
                \App\Models\Setting::get('social_youtube'),
                \App\Models\Setting::get('social_linkedin'),
            ])),
        ];
    }

    public static function website(): array
    {
        $locale = I18n::locale();
        return [
            '@type' => 'WebSite',
            '@id' => url($locale === 'en' ? '/en/#website' : '/#website'),
            'url' => url($locale === 'en' ? '/en/' : '/'),
            'name' => I18n::t('site.name'),
            'inLanguage' => I18n::meta('html'),
            'publisher' => ['@id' => url('/#edwin')],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => ['@type' => 'EntryPoint', 'urlTemplate' => url(route('search')) . '?q={search_term_string}'],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /** @param array<int, array{q:string, a:string}> $faqs */
    public static function faqPage(array $faqs): ?array
    {
        if ($faqs === []) {
            return null;
        }
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'inLanguage' => I18n::meta('html'),
            'mainEntity' => array_map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f['q'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
            ], $faqs),
        ];
    }

    public static function json(array $data): string
    {
        return (string) json_encode(self::withoutNulls($data), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG);
    }

    private static function withoutNulls(array $data): array
    {
        foreach ($data as $key => $value) {
            if ($value === null || $value === []) {
                unset($data[$key]);
            } elseif (is_array($value)) {
                $data[$key] = self::withoutNulls($value);
            }
        }
        return $data;
    }
}
