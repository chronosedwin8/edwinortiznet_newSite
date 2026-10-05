<?php

declare(strict_types=1);

namespace App\Services\Seo;

use App\Core\Config;

/**
 * CSS crítico en línea (minificado y memorizado por fecha de modificación).
 */
final class Assets
{
    private static ?string $critical = null;

    public static function criticalCss(): string
    {
        if (self::$critical !== null) {
            return self::$critical;
        }
        $file = Config::root('public/assets/css/critical.css');
        if (!is_file($file)) {
            return self::$critical = '';
        }
        $cacheFile = Config::storage('cache/critical-' . filemtime($file) . '.css');
        if (is_file($cacheFile)) {
            return self::$critical = (string) file_get_contents($cacheFile);
        }
        $css = self::minify((string) file_get_contents($file));
        @file_put_contents($cacheFile, $css);
        return self::$critical = $css;
    }

    public static function minify(string $css): string
    {
        $css = preg_replace('#/\*.*?\*/#s', '', $css) ?? $css;
        $css = preg_replace('/\s+/', ' ', $css) ?? $css;
        $css = preg_replace('/\s*([{};,>])\s*/', '$1', $css) ?? $css;
        $css = preg_replace('/:\s+/', ':', $css) ?? $css;
        $css = str_replace(';}', '}', $css);
        // "a:hover" y similares se conservan; se evita romper "and (" en media queries.
        $css = str_replace(['and(', ')and'], ['and (', ') and'], $css);
        return trim(str_replace('</', '<\/', $css));
    }
}
