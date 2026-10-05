<?php

declare(strict_types=1);

namespace App\Services\Tools;

use InvalidArgumentException;

/**
 * Converts numbers to words in Colombian Spanish and international English.
 *
 * A JavaScript port with identical output lives in public/assets/js/tools/numwords.js;
 * both are checked against tests/fixtures/numwords_cases.json.
 *
 * Input parsing
 * -------------
 * - int: used as is.
 * - float: must be finite; converted with its shortest round-trip representation
 *   (same digits JavaScript's String(number) produces), exponents are expanded.
 * - string: surrounding whitespace is trimmed and an optional leading "+" or "-" is accepted.
 *   Spanish strings:
 *     1. if the string contains a ",", every "." is a thousands separator and the single ","
 *        is the decimal separator ("1.234.567,89", "12,5");
 *     2. otherwise, if it contains more than one ".", they are thousands separators ("1.234.567");
 *     3. otherwise a single "." is the decimal separator ("1234567.89", "1.234" = 1,234 thousandths).
 *   English strings: "," is a thousands separator and "." the decimal separator ("1,234,567.89").
 *   Thousands separators must form valid groups (1-3 leading digits, then groups of exactly 3).
 *
 * Decimals
 * --------
 * The fractional part is rounded half-up to $decimals digits (0-15), carrying into the integer
 * part when needed (2,999 -> 3). In currency mode cents are always rounded to 2 digits and
 * $decimals is only validated. The integer part must be at most 999.999.999.999.999 after rounding.
 * A value that rounds to zero never gets a "menos"/"minus" prefix.
 *
 * Every invalid input (malformed string, non-finite float, out of range, bad $decimals)
 * throws \InvalidArgumentException.
 */
final class NumberToWords
{
    public const MAX = 999_999_999_999_999;
    public const MAX_DECIMALS = 15;

    private const ES_UNITS = [
        '', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve',
        'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve',
        'veinte', 'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro', 'veinticinco', 'veintiséis',
        'veintisiete', 'veintiocho', 'veintinueve',
    ];

    private const ES_TENS = [
        3 => 'treinta', 4 => 'cuarenta', 5 => 'cincuenta', 6 => 'sesenta',
        7 => 'setenta', 8 => 'ochenta', 9 => 'noventa',
    ];

    private const ES_HUNDREDS = [
        '', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos',
        'seiscientos', 'setecientos', 'ochocientos', 'novecientos',
    ];

    private const EN_ONES = [
        'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
        'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen',
    ];

    private const EN_TENS = [
        2 => 'twenty', 3 => 'thirty', 4 => 'forty', 5 => 'fifty',
        6 => 'sixty', 7 => 'seventy', 8 => 'eighty', 9 => 'ninety',
    ];

    private const EN_SCALES = [
        1_000_000_000_000 => 'trillion',
        1_000_000_000 => 'billion',
        1_000_000 => 'million',
        1_000 => 'thousand',
    ];

    private const ES_UPPER = ['á' => 'Á', 'é' => 'É', 'í' => 'Í', 'ó' => 'Ó', 'ú' => 'Ú', 'ü' => 'Ü', 'ñ' => 'Ñ'];

    /**
     * Colombian Spanish words, e.g. 1001001 -> "un millón mil uno", "12,5" -> "doce con cincuenta".
     * Currency mode: 1500000 -> "UN MILLÓN QUINIENTOS MIL PESOS M/CTE".
     *
     * @throws InvalidArgumentException
     */
    public static function spanish(string|int|float $amount, bool $currency = false, int $decimals = 2): string
    {
        self::assertDecimals($decimals);
        $digits = $currency ? 2 : $decimals;
        [$negative, $int, $frac] = self::normalize($amount, 'es', $digits);

        if ($currency) {
            $words = self::esInteger($int, true);
            if ($int > 0 && $int % 1_000_000 === 0) {
                $words .= ' de pesos';
            } else {
                $words .= $int === 1 ? ' peso' : ' pesos';
            }
            if ($frac > 0) {
                $words .= ' con ' . self::esInteger($frac, true) . ($frac === 1 ? ' centavo' : ' centavos');
            }
            $words = ($negative ? 'menos ' : '') . $words . ' m/cte';

            return strtr(strtoupper($words), self::ES_UPPER);
        }

        $words = self::esInteger($int, false);
        if ($frac > 0) {
            $words .= ' con ' . self::esInteger($frac, false);
        }

        return ($negative ? 'menos ' : '') . $words;
    }

    /**
     * International English words, e.g. 1001001 -> "one million one thousand one", 12.5 -> "twelve and 50/100".
     * Currency mode: 1234.56 -> "One thousand two hundred thirty-four dollars and fifty-six cents".
     *
     * @throws InvalidArgumentException
     */
    public static function english(string|int|float $amount, bool $currency = false, int $decimals = 2): string
    {
        self::assertDecimals($decimals);
        $digits = $currency ? 2 : $decimals;
        [$negative, $int, $frac] = self::normalize($amount, 'en', $digits);

        $words = self::enInteger($int);
        if ($currency) {
            $words .= $int === 1 ? ' dollar' : ' dollars';
            if ($frac > 0) {
                $words .= ' and ' . self::enInteger($frac) . ($frac === 1 ? ' cent' : ' cents');
            }

            return ucfirst(($negative ? 'minus ' : '') . $words);
        }

        if ($frac > 0) {
            $words .= ' and ' . str_pad((string) $frac, $digits, '0', STR_PAD_LEFT) . '/1' . str_repeat('0', $digits);
        }

        return ($negative ? 'minus ' : '') . $words;
    }

    private static function assertDecimals(int $decimals): void
    {
        if ($decimals < 0 || $decimals > self::MAX_DECIMALS) {
            throw new InvalidArgumentException('Decimals must be between 0 and ' . self::MAX_DECIMALS . '.');
        }
    }

    /**
     * @return array{0: bool, 1: int, 2: int} [negative, integer part, rounded fraction as integer]
     */
    private static function normalize(string|int|float $amount, string $lang, int $digits): array
    {
        $plain = self::toPlain($amount, $lang);
        if (preg_match('/^([+-]?)(\d+)(?:\.(\d+))?$/D', $plain, $m) !== 1) {
            throw new InvalidArgumentException('Invalid number: ' . $plain);
        }

        $intDigits = ltrim($m[2], '0');
        if (strlen($intDigits) > 15) {
            throw new InvalidArgumentException('Number out of range (max ' . self::MAX . ').');
        }
        $int = (int) ($intDigits === '' ? '0' : $intDigits);

        $fracDigits = str_pad($m[3] ?? '', $digits + 1, '0');
        $frac = $digits > 0 ? (int) substr($fracDigits, 0, $digits) : 0;
        if ($fracDigits[$digits] >= '5') {
            $frac++;
            if ($frac >= 10 ** $digits) {
                $frac = 0;
                $int++;
            }
        }
        if ($int > self::MAX) {
            throw new InvalidArgumentException('Number out of range (max ' . self::MAX . ').');
        }

        return [$m[1] === '-' && ($int > 0 || $frac > 0), $int, $frac];
    }

    /**
     * Converts the input to a plain "[+-]digits[.digits]" string.
     */
    private static function toPlain(string|int|float $amount, string $lang): string
    {
        if (is_int($amount)) {
            return (string) $amount;
        }
        if (is_float($amount)) {
            if (!is_finite($amount)) {
                throw new InvalidArgumentException('Number must be finite.');
            }

            return self::expandExponent(var_export($amount, true));
        }

        $s = trim($amount);
        if (preg_match('/^([+-]?)(.+)$/sD', $s, $m) !== 1) {
            throw new InvalidArgumentException('Invalid number: empty string.');
        }
        [, $sign, $body] = $m;

        if ($lang === 'en') {
            if (preg_match('/^(\d{1,3}(?:,\d{3})+|\d+)(\.\d+)?$/D', $body) !== 1) {
                throw new InvalidArgumentException('Invalid number: ' . $amount);
            }

            return $sign . str_replace(',', '', $body);
        }

        if (str_contains($body, ',')) {
            if (preg_match('/^(\d{1,3}(?:\.\d{3})+|\d+),(\d+)$/D', $body, $p) !== 1) {
                throw new InvalidArgumentException('Invalid number: ' . $amount);
            }

            return $sign . str_replace('.', '', $p[1]) . '.' . $p[2];
        }
        if (substr_count($body, '.') > 1) {
            if (preg_match('/^\d{1,3}(?:\.\d{3})+$/D', $body) !== 1) {
                throw new InvalidArgumentException('Invalid number: ' . $amount);
            }

            return $sign . str_replace('.', '', $body);
        }
        if (preg_match('/^\d+(?:\.\d+)?$/D', $body) !== 1) {
            throw new InvalidArgumentException('Invalid number: ' . $amount);
        }

        return $sign . $body;
    }

    /**
     * "1.5E+15" -> "1500000000000000", "1.0E-5" -> "0.000010"; plain strings pass through.
     */
    private static function expandExponent(string $repr): string
    {
        if (preg_match('/^(-?)(\d+)(?:\.(\d*))?[eE]([+-]?\d+)$/D', $repr, $m) !== 1) {
            return $repr;
        }
        $digits = $m[2] . $m[3];
        $point = strlen($m[2]) + (int) $m[4];
        if ($point <= 0) {
            return $m[1] . '0.' . str_repeat('0', -$point) . $digits;
        }
        if ($point >= strlen($digits)) {
            return $m[1] . $digits . str_repeat('0', $point - strlen($digits));
        }

        return $m[1] . substr($digits, 0, $point) . '.' . substr($digits, $point);
    }

    /**
     * @param bool $apocope Shorten a trailing "uno" to "un" / "veintiuno" to "veintiún" (before a masculine noun).
     */
    private static function esInteger(int $n, bool $apocope): string
    {
        if ($n === 0) {
            return 'cero';
        }
        $billions = intdiv($n, 1_000_000_000_000);
        $millions = intdiv($n % 1_000_000_000_000, 1_000_000);
        $rest = $n % 1_000_000;

        $parts = [];
        if ($billions === 1) {
            $parts[] = 'un billón';
        } elseif ($billions > 1) {
            $parts[] = self::esBelowMillion($billions, true) . ' billones';
        }
        if ($millions === 1) {
            $parts[] = 'un millón';
        } elseif ($millions > 1) {
            $parts[] = self::esBelowMillion($millions, true) . ' millones';
        }
        if ($rest > 0) {
            $parts[] = self::esBelowMillion($rest, $apocope);
        }

        return implode(' ', $parts);
    }

    /** 1..999999 */
    private static function esBelowMillion(int $n, bool $apocope): string
    {
        $thousands = intdiv($n, 1000);
        $rest = $n % 1000;

        $parts = [];
        if ($thousands === 1) {
            $parts[] = 'mil';
        } elseif ($thousands > 1) {
            $parts[] = self::esBelowThousand($thousands, true) . ' mil';
        }
        if ($rest > 0) {
            $parts[] = self::esBelowThousand($rest, $apocope);
        }

        return implode(' ', $parts);
    }

    /** 1..999 */
    private static function esBelowThousand(int $n, bool $apocope): string
    {
        $hundreds = intdiv($n, 100);
        $rest = $n % 100;

        $parts = [];
        if ($hundreds > 0) {
            $parts[] = $n === 100 ? 'cien' : self::ES_HUNDREDS[$hundreds];
        }
        if ($rest > 0) {
            if ($rest < 30) {
                $word = self::ES_UNITS[$rest];
                if ($apocope && $rest === 1) {
                    $word = 'un';
                } elseif ($apocope && $rest === 21) {
                    $word = 'veintiún';
                }
            } else {
                $unit = $rest % 10;
                $word = self::ES_TENS[intdiv($rest, 10)];
                if ($unit > 0) {
                    $word .= ' y ' . ($apocope && $unit === 1 ? 'un' : self::ES_UNITS[$unit]);
                }
            }
            $parts[] = $word;
        }

        return implode(' ', $parts);
    }

    private static function enInteger(int $n): string
    {
        if ($n === 0) {
            return 'zero';
        }
        $parts = [];
        foreach (self::EN_SCALES as $scale => $name) {
            if ($n >= $scale) {
                $parts[] = self::enBelowThousand(intdiv($n, $scale)) . ' ' . $name;
                $n %= $scale;
            }
        }
        if ($n > 0) {
            $parts[] = self::enBelowThousand($n);
        }

        return implode(' ', $parts);
    }

    /** 1..999 */
    private static function enBelowThousand(int $n): string
    {
        $parts = [];
        if ($n >= 100) {
            $parts[] = self::EN_ONES[intdiv($n, 100)] . ' hundred';
            $n %= 100;
        }
        if ($n >= 20) {
            $parts[] = self::EN_TENS[intdiv($n, 10)] . ($n % 10 > 0 ? '-' . self::EN_ONES[$n % 10] : '');
        } elseif ($n > 0) {
            $parts[] = self::EN_ONES[$n];
        }

        return implode(' ', $parts);
    }
}
