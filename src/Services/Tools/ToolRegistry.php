<?php

declare(strict_types=1);

namespace App\Services\Tools;

/**
 * Herramientas gratuitas. Los textos viven en lang/*.php; aquí solo la estructura.
 * El simulacro del Concurso Docente es una página que lleva a Fundales (fundales.com).
 */
final class ToolRegistry
{
    /** clave => [slug por idioma, producto relacionado (wp_id), script, ícono, descarga para Excel] */
    private const TOOLS = [
        'qr' => [
            'slugs' => ['es' => 'generador-qr', 'en' => 'qr-code-generator'],
            'product_wp_id' => 409,
            'script' => 'js/tools/qr-tool.js',
            'icon' => 'qr',
            // Módulo VBA gratuito (tools/excel/build.ps1 genera los ZIP en public/descargas/)
            'excel' => ['module' => 'CodigoQR', 'zip' => ['es' => 'codigo-qr-excel.zip', 'en' => 'qr-code-excel.zip']],
        ],
        'words' => [
            'slugs' => ['es' => 'numero-a-letras', 'en' => 'number-to-words'],
            'product_wp_id' => 396,
            'script' => 'js/tools/words-tool.js',
            'icon' => 'abc',
            'excel' => ['module' => 'NumerosALetras', 'zip' => ['es' => 'numero-a-letras-excel.zip', 'en' => 'number-to-words-excel.zip']],
        ],
        'fundales' => [
            'slugs' => ['es' => 'simulacro-concurso-docente'],
            'product_wp_id' => null,
            'script' => null,
            'icon' => 'target',
        ],
    ];

    public static function forLocale(string $locale): array
    {
        $out = [];
        foreach (self::TOOLS as $key => $tool) {
            if (!isset($tool['slugs'][$locale])) {
                continue;
            }
            $out[] = $tool + ['key' => $key, 'slug' => $tool['slugs'][$locale]];
        }
        return $out;
    }

    public static function bySlug(string $locale, string $slug): ?array
    {
        foreach (self::forLocale($locale) as $tool) {
            if ($tool['slug'] === $slug) {
                return $tool;
            }
        }
        return null;
    }

    public static function alternates(string $key): array
    {
        $out = [];
        foreach (self::TOOLS[$key]['slugs'] ?? [] as $locale => $slug) {
            $out[$locale] = route('tool', ['slug' => $slug], $locale);
        }
        return $out;
    }
}
