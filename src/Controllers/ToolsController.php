<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\Core\Response;
use App\Models\Hub;
use App\Models\Product;
use App\Services\I18n\I18n;
use App\Services\Seo\Meta;
use App\Services\Tools\ToolRegistry;

/**
 * Herramientas gratuitas (en el navegador) y la página del simulacro, que lleva a Fundales.
 */
final class ToolsController extends Controller
{
    public function index(Request $request): Response
    {
        $locale = I18n::locale();
        $hub = Hub::byKey('herramientas', $locale);
        $faqs = $hub ? Hub::faqs($hub) : [];
        $crumbs = [[t('nav.home'), route('home')], [t('nav.tools'), route('tools')]];
        return $this->page('pages/tools', [
            'hub' => $hub,
            'tools' => ToolRegistry::forLocale($locale),
            'faqs' => $faqs,
            'crumbs' => $crumbs,
        ], [
            'title' => $hub['seo_title'] ?? t('tools.title'),
            'title_full' => !empty($hub['seo_title']),
            'description' => $hub['seo_description'] ?? t('tools.lead'),
            'alternates' => ['es' => route('tools', [], 'es'), 'en' => route('tools', [], 'en')],
            'breadcrumbs' => $crumbs,
            'jsonld' => [Meta::faqPage($faqs)],
            'body_class' => 'page-tools',
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $locale = I18n::locale();
        $tool = ToolRegistry::bySlug($locale, $slug);
        if ($tool === null) {
            $this->notFound();
        }
        $key = $tool['key'];
        if ($key === 'fundales') {
            return $this->fundales($slug);
        }
        if ($key === 'piar') {
            return (new PiarController())->landing($slug);
        }
        $product = !empty($tool['product_wp_id']) ? Product::byWpId((int) $tool['product_wp_id'], $locale) : null;
        $faqs = self::faqs("tool.$key");
        $path = route('tool', ['slug' => $slug]);
        $crumbs = [[t('nav.home'), route('home')], [t('nav.tools'), route('tools')], [t("tool.$key.name"), $path]];
        return $this->page('pages/tool', [
            'tool' => $tool,
            'key' => $key,
            'product' => $product,
            'faqs' => $faqs,
            'crumbs' => $crumbs,
        ], [
            'title' => t("tool.$key.seo_title"),
            'title_full' => true,
            'description' => t("tool.$key.seo_description"),
            'alternates' => ToolRegistry::alternates($key),
            'breadcrumbs' => $crumbs,
            'scripts' => [$tool['script']],
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@type' => 'WebApplication',
                'name' => t("tool.$key.name"),
                'url' => url($path),
                'applicationCategory' => 'UtilitiesApplication',
                'operatingSystem' => 'Any',
                'browserRequirements' => 'Requires JavaScript',
                'inLanguage' => I18n::meta('html'),
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => I18n::currency()],
            ] + (isset($tool['excel']['zip'][$locale]) ? ['downloadUrl' => url('/descargas/' . $tool['excel']['zip'][$locale])] : []), Meta::faqPage($faqs)],
            'body_class' => 'page-tool page-tool--' . $key,
        ]);
    }

    /** @return array<int, array{q:string,a:string}> */
    private static function faqs(string $prefix): array
    {
        $faqs = [];
        for ($i = 1; I18n::has("$prefix.faq{$i}_q"); $i++) {
            $faqs[] = ['q' => t("$prefix.faq{$i}_q"), 'a' => t("$prefix.faq{$i}_a")];
        }
        return $faqs;
    }

    /** Simulacro del Concurso Docente: presentación de Fundales (cuenta gratis por un año). */
    private function fundales(string $slug): Response
    {
        $path = route('tool', ['slug' => $slug]);
        $crumbs = [[t('nav.home'), route('home')], [t('nav.tools'), route('tools')], [t('fundales.crumb'), $path]];
        $faqs = self::faqs('fundales');
        return $this->page('pages/fundales', [
            'crumbs' => $crumbs,
            'faqs' => $faqs,
            'hub' => Hub::byKey('concurso-docente', 'es'),
        ], [
            'title' => t('fundales.seo_title'),
            'title_full' => true,
            'description' => t('fundales.seo_description'),
            'breadcrumbs' => $crumbs,
            'jsonld' => [[
                '@context' => 'https://schema.org',
                '@type' => 'WebApplication',
                'name' => 'Fundales — Entrenador Docente',
                'url' => 'https://fundales.com/',
                'applicationCategory' => 'EducationalApplication',
                'operatingSystem' => 'Any',
                'inLanguage' => 'es-CO',
                'creator' => ['@type' => 'Person', 'name' => 'Edwin Ortiz Herazo'],
                'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'COP', 'description' => t('fundales.offer')],
            ], Meta::faqPage($faqs)],
            'body_class' => 'page-fundales',
        ]);
    }
}
