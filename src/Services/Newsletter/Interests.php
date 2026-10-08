<?php

declare(strict_types=1);

namespace App\Services\Newsletter;

/**
 * Temas del boletín (selección múltiple) y de dónde se suscribió cada persona.
 *
 * - docentes: docencia, aula, PIAR, exámenes, Kit de IA.
 * - tecnologia: tecnología e inteligencia artificial.
 * - excel: Excel, plantillas y oficina.
 * - concurso: Concurso Docente (CNSC) y simulacros.
 *
 * Sin intereses = "de todo un poco" (recibe lo más reciente de todos los temas).
 */
final class Interests
{
    public const ALL = ['docentes', 'tecnologia', 'excel', 'concurso'];
    public const SOURCE_TYPES = ['footer', 'home', 'article', 'hub', 'product', 'tool', 'checkout', 'account', 'waitlist', 'other'];
    public const STATUSES = ['pending', 'active', 'unsubscribed', 'bounced', 'spam'];

    /** Intereses por omisión según el hub de la página (lo que la persona estaba leyendo). */
    private const HUB = [
        'excel' => ['excel'],
        'ia-para-docentes' => ['docentes', 'tecnologia'],
        'concurso-docente' => ['concurso'],
    ];

    private const TOOL = [
        'piar' => ['docentes'],
        'examenes' => ['docentes'],
        'fundales' => ['concurso'],
        'qr' => ['excel'],
        'words' => ['excel'],
    ];

    /** @return string[] intereses válidos, sin repetir y en el orden de ALL */
    public static function normalize(mixed $value): array
    {
        if (is_string($value)) {
            $value = explode(',', $value);
        }
        if (!is_array($value)) {
            return [];
        }
        $value = array_map(static fn ($v) => is_string($v) ? strtolower(trim($v)) : '', $value);
        return array_values(array_intersect(self::ALL, $value));
    }

    public static function toSet(array $interests): string
    {
        return implode(',', self::normalize($interests));
    }

    /** @return string[] */
    public static function fromSet(?string $set): array
    {
        return self::normalize((string) $set);
    }

    /** @return string[] */
    public static function forHub(?string $hubKey): array
    {
        return self::HUB[(string) $hubKey] ?? [];
    }

    /** @return string[] */
    public static function forTool(?string $key): array
    {
        return self::TOOL[(string) $key] ?? [];
    }

    /**
     * Productos: los de Excel/oficina → excel; los de docentes → docentes (PIAR, exámenes y Kit de IA también
     * tecnología); los del Concurso → concurso.
     * @return string[]
     */
    public static function forProduct(array $product): array
    {
        $sku = strtoupper((string) ($product['sku'] ?? ''));
        if (str_starts_with($sku, 'PIAR-') || str_starts_with($sku, 'EXAM-') || in_array($sku, ['EO-KIT-IA', 'EO-EXAMENES', 'EO-CURSO-IA'], true)) {
            return ['docentes', 'tecnologia'];
        }
        return match ($product['audience'] ?? null) {
            'docente' => ['docentes'],
            'concurso' => ['concurso'],
            default => ['excel'],
        };
    }

    /**
     * Temas de un artículo: los de su hub más "tecnología" si habla de IA o tecnología.
     * Los artículos del hub de IA para docentes siempre son "docentes"; tecnología solo si el tema lo es.
     * @return string[]
     */
    public static function forPost(?string $hubKey, string $text): array
    {
        $out = match ((string) $hubKey) {
            'excel' => ['excel'],
            'ia-para-docentes' => ['docentes'],
            'concurso-docente' => ['concurso'],
            default => [],
        };
        if ($hubKey !== 'concurso-docente' && self::isTech($text)) {
            $out[] = 'tecnologia';
        }
        return self::normalize($out);
    }

    public static function isTech(string $text): bool
    {
        return (bool) preg_match('/\b(IA|AI)\b/u', $text)
            || (bool) preg_match('/\b(inteligencia artificial|artificial intelligence|chatgpt|copilot|gemini|tecnolog\w*|technolog\w*|digital\w*|programaci\w*|programming|cu[aá]ntic\w*|quantum|software|algoritm\w*|algorithm\w*|rob[oó]tic\w*|realidad aumentada|internet|ciberseguridad|cybersecurity|apps?|plataforma\w*|platform\w*)\b/iu', $text);
    }

    /** ¿Coincide algún interés? Sin intereses del suscriptor = todo le sirve. */
    public static function matches(array $subscriber, array $item): bool
    {
        return $subscriber === [] || array_intersect($subscriber, $item) !== [];
    }

    public static function sourceType(mixed $value): string
    {
        return is_string($value) && in_array($value, self::SOURCE_TYPES, true) ? $value : 'other';
    }
}
