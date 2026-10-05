<?php

declare(strict_types=1);

namespace App\Services\I18n;

use App\Core\Config;

/**
 * Cadenas de interfaz (lang/es.php, lang/en.php) y formatos por idioma.
 */
final class I18n
{
    public const LOCALES = ['es', 'en'];
    public const DEFAULT = 'es';

    private const META = [
        'es' => ['html' => 'es-CO', 'intl' => 'es_CO', 'og' => 'es_CO', 'hreflang' => 'es-CO', 'currency' => 'COP'],
        'en' => ['html' => 'en', 'intl' => 'en_US', 'og' => 'en_US', 'hreflang' => 'en', 'currency' => 'USD'],
    ];

    private static string $locale = self::DEFAULT;
    /** @var array<string, array<string, string>> */
    private static array $strings = [];

    public static function setLocale(string $locale): void
    {
        self::$locale = in_array($locale, self::LOCALES, true) ? $locale : self::DEFAULT;
    }

    public static function locale(): string
    {
        return self::$locale;
    }

    public static function other(?string $locale = null): string
    {
        return ($locale ?? self::$locale) === 'es' ? 'en' : 'es';
    }

    public static function meta(string $key, ?string $locale = null): string
    {
        return self::META[$locale ?? self::$locale][$key];
    }

    public static function currency(?string $locale = null): string
    {
        return self::meta('currency', $locale);
    }

    private static function strings(string $locale): array
    {
        if (!isset(self::$strings[$locale])) {
            $file = Config::root("lang/$locale.php");
            self::$strings[$locale] = is_file($file) ? require $file : [];
        }
        return self::$strings[$locale];
    }

    public static function has(string $key, ?string $locale = null): bool
    {
        return isset(self::strings($locale ?? self::$locale)[$key]);
    }

    public static function t(string $key, array $params = [], ?string $locale = null): string
    {
        $locale ??= self::$locale;
        $text = self::strings($locale)[$key] ?? self::strings(self::DEFAULT)[$key] ?? $key;
        if ($params) {
            $replace = [];
            foreach ($params as $name => $value) {
                $replace[':' . $name] = (string) $value;
            }
            // Las claves largas primero para que ":count" no pise ":countries".
            uksort($replace, fn ($a, $b) => strlen($b) <=> strlen($a));
            $text = strtr($text, $replace);
        }
        return $text;
    }

    public static function date(string|\DateTimeInterface|null $value, string $style = 'long', ?string $locale = null): string
    {
        if ($value === null || $value === '') {
            return '';
        }
        $tz = new \DateTimeZone((string) Config::get('APP_TIMEZONE', 'America/Bogota'));
        $date = $value instanceof \DateTimeInterface
            ? $value
            : new \DateTimeImmutable($value, new \DateTimeZone('UTC'));
        $date = (new \DateTimeImmutable('@' . $date->getTimestamp()))->setTimezone($tz);
        $locale ??= self::$locale;
        if (class_exists(\IntlDateFormatter::class)) {
            $fmt = new \IntlDateFormatter(
                self::meta('intl', $locale),
                $style === 'short' ? \IntlDateFormatter::SHORT : \IntlDateFormatter::LONG,
                \IntlDateFormatter::NONE,
                $tz
            );
            $out = $fmt->format($date);
            if (is_string($out)) {
                return $out;
            }
        }
        return $date->format($locale === 'es' ? 'd/m/Y' : 'M j, Y');
    }

    public static function number(float|int $value, int $decimals = 0, ?string $locale = null): string
    {
        $locale ??= self::$locale;
        if (class_exists(\NumberFormatter::class)) {
            $fmt = new \NumberFormatter(self::meta('intl', $locale), \NumberFormatter::DECIMAL);
            $fmt->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals);
            $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $decimals);
            return (string) $fmt->format($value);
        }
        return $locale === 'es'
            ? number_format((float) $value, $decimals, ',', '.')
            : number_format((float) $value, $decimals, '.', ',');
    }

    /**
     * Formatea un monto. COP sin decimales; USD sin decimales si es entero.
     */
    public static function money(float|int|string $amount, string $currency, ?string $locale = null): string
    {
        $locale ??= self::$locale;
        $amount = (float) $amount;
        $decimals = ($currency === 'COP' || floor($amount) === $amount) ? 0 : 2;
        if (class_exists(\NumberFormatter::class)) {
            $fmt = new \NumberFormatter(self::meta('intl', $locale), \NumberFormatter::CURRENCY);
            $fmt->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals);
            $fmt->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, $decimals);
            if ($locale === 'es' && $currency === 'USD') {
                $fmt->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, 'US$');
            }
            $out = $fmt->formatCurrency($amount, $currency);
            if (is_string($out)) {
                // Espacio duro de ICU → espacio duro estándar.
                return str_replace(["\u{202F}", "\u{00A0}"], "\u{00A0}", $out);
            }
        }
        $symbol = $currency === 'USD' ? ($locale === 'es' ? 'US$' : '$') : '$';
        return $symbol . "\u{00A0}" . self::number($amount, $decimals, $locale) . ($currency === 'COP' ? '' : '');
    }
}
