<?php

declare(strict_types=1);

namespace Tests;

use App\Services\Tools\NumberToWords;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Cases come from tests/fixtures/numwords_cases.json, shared with tests/js/numwords.test.mjs
 * so the PHP and JS implementations are guaranteed to produce the same strings.
 * Fixture entry: {lang: "es"|"en", input: string|number, currency: bool, decimals?: int, expected: string|null};
 * expected = null means the input must be rejected.
 */
final class NumberToWordsTest extends TestCase
{
    /**
     * @return list<array{lang: string, input: string|int|float, currency: bool, decimals?: int, expected: ?string}>
     */
    private static function fixture(): array
    {
        $json = file_get_contents(__DIR__ . '/fixtures/numwords_cases.json');
        self::assertIsString($json);

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return iterable<string, array{string, string|int|float, bool, int, ?string}>
     */
    private static function cases(bool $valid): iterable
    {
        foreach (self::fixture() as $i => $case) {
            if (($case['expected'] !== null) !== $valid) {
                continue;
            }
            $label = sprintf(
                '#%d %s%s %s',
                $i,
                $case['lang'],
                $case['currency'] ? ' currency' : '',
                var_export($case['input'], true)
            );
            yield $label => [
                $case['lang'],
                $case['input'],
                $case['currency'],
                $case['decimals'] ?? 2,
                $case['expected'],
            ];
        }
    }

    public static function validCases(): iterable
    {
        return self::cases(true);
    }

    public static function invalidCases(): iterable
    {
        return self::cases(false);
    }

    private static function convert(string $lang, string|int|float $input, bool $currency, int $decimals): string
    {
        return $lang === 'es'
            ? NumberToWords::spanish($input, $currency, $decimals)
            : NumberToWords::english($input, $currency, $decimals);
    }

    #[DataProvider('validCases')]
    public function testConvertsFixtureCase(
        string $lang,
        string|int|float $input,
        bool $currency,
        int $decimals,
        ?string $expected
    ): void {
        self::assertSame($expected, self::convert($lang, $input, $currency, $decimals));
    }

    #[DataProvider('invalidCases')]
    public function testRejectsInvalidFixtureCase(
        string $lang,
        string|int|float $input,
        bool $currency,
        int $decimals,
        ?string $expected
    ): void {
        $this->expectException(InvalidArgumentException::class);
        self::convert($lang, $input, $currency, $decimals);
    }

    public function testFixtureCoversRequiredCases(): void
    {
        $inputs = [];
        foreach (self::fixture() as $case) {
            $inputs[$case['lang'] . ($case['currency'] ? '$' : '')][] = $case['input'];
        }
        foreach ([0, 1, 21, 100, 101, 1000, 1000000, 1001001] as $n) {
            self::assertContains($n, $inputs['es']);
            self::assertContains($n, $inputs['es$']);
            self::assertContains($n, $inputs['en']);
            self::assertContains($n, $inputs['en$']);
        }
    }

    /**
     * @return iterable<string, array{float}>
     */
    public static function nonFiniteFloats(): iterable
    {
        yield 'INF' => [INF];
        yield '-INF' => [-INF];
        yield 'NAN' => [NAN];
        yield '1e20' => [1e20];
    }

    #[DataProvider('nonFiniteFloats')]
    public function testRejectsNonFiniteOrHugeFloats(float $value): void
    {
        $this->expectException(InvalidArgumentException::class);
        NumberToWords::spanish($value);
    }

    public function testExpandsFloatExponents(): void
    {
        self::assertSame('cero', NumberToWords::spanish(1e-7));
        self::assertSame('un billón', NumberToWords::spanish(1e12));
        self::assertSame('one hundred trillion', NumberToWords::english(1e14));
        self::assertSame('one and 01/100', NumberToWords::english(1.005));
    }
}
