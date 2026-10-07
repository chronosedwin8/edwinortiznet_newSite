<?php

declare(strict_types=1);

namespace App\Services\Piar;

/**
 * Ayudas de presentación del PIAR (web y PDF): texto escapado con las marcas «a validar» resaltadas,
 * etiquetas del catálogo y filas de la ficha del estudiante.
 */
final class PiarView
{
    /** Texto escapado; la marca «(a validar por el equipo)» se resalta. */
    public static function text(?string $text): string
    {
        $html = e((string) $text);
        $mark = e(PiarPrompt::VALIDATE_MARK);
        return str_replace($mark, '<span class="piar-validate">' . $mark . '</span>', nl2br($html, false));
    }

    /** Párrafos separados por líneas en blanco. */
    public static function paragraphs(?string $text): string
    {
        $blocks = preg_split("/\n\s*\n/", trim((string) $text)) ?: [];
        return implode('', array_map(fn ($b) => '<p>' . self::text(trim($b)) . '</p>', array_filter($blocks, fn ($b) => trim($b) !== '')));
    }

    public static function list(array $items, string $class = ''): string
    {
        if ($items === []) {
            return '';
        }
        return '<ul' . ($class !== '' ? ' class="' . e($class) . '"' : '') . '>'
            . implode('', array_map(fn ($i) => '<li>' . self::text((string) $i) . '</li>', $items)) . '</ul>';
    }

    public static function category(string $key): string
    {
        $k = strtolower(trim($key));
        return \App\Services\I18n\I18n::has("piar.cat.$k") ? t("piar.cat.$k") : ($key !== '' ? mb_strtoupper(mb_substr($key, 0, 1)) . mb_substr($key, 1) : '');
    }

    public static function grade(?string $key): string
    {
        return PiarCatalog::grades()[(string) $key] ?? '';
    }

    /** ¿La sección tiene contenido? (para no pintar secciones vacías como si lo tuvieran). */
    public static function filled(mixed $value): bool
    {
        if (is_array($value)) {
            foreach ($value as $v) {
                if (self::filled($v)) {
                    return true;
                }
            }
            return false;
        }
        return trim((string) $value) !== '';
    }

    /**
     * Ficha del estudiante (etiqueta => valor), en el orden del PDF.
     * @return array<string, string>
     */
    public static function studentRows(array $plan, array $input, ?array $profile): array
    {
        $student = is_array($input['estudiante'] ?? null) ? $input['estudiante'] : [];
        $labels = PiarCatalog::conditionLabels();
        $conds = array_values(array_filter(array_map(fn ($k) => $labels[$k] ?? null, (array) ($input['condiciones'] ?? []))));
        if (trim((string) ($input['otra_condicion'] ?? '')) !== '') {
            $conds[] = trim((string) $input['otra_condicion']);
        }
        $level = PiarCatalog::supportLevels()[(string) ($input['nivel_apoyo'] ?? '')]['label'] ?? '';
        $join = static fn (array $parts): string => implode(' · ', array_filter(array_map('trim', $parts), fn ($p) => $p !== ''));
        $none = t('piar.data.none');
        $alias = (string) ($plan['student_alias'] ?? ($student['nombre'] ?? ''));
        $rows = [
            t('piar.data.estudiante') => $alias !== '' ? $alias : $none,
            t('piar.data.grado') => self::grade($plan['grade'] ?? ($student['grado'] ?? '')) ?: $none,
            t('piar.data.edad') => !empty($student['edad']) ? t('piar.data.edad_value', ['n' => (int) $student['edad']]) : $none,
            t('piar.data.sede') => $join([(string) ($student['sede'] ?? ''), (string) ($student['jornada'] ?? '')]) ?: $none,
            t('piar.data.anio') => $join([(string) ($input['anio'] ?? ''), PiarCatalog::periods()[(string) ($input['periodo'] ?? '')] ?? '']) ?: $none,
            t('piar.data.docente') => trim((string) ($input['docente'] ?? '')) ?: $none,
            t('piar.data.institucion') => trim((string) (($profile['institution'] ?? '') ?: ($input['institucion'] ?? ''))) ?: $none,
            t('piar.data.fecha') => fdate($plan['created_at'] ?? null, 'long'),
            t('piar.data.apoyo') => $level !== '' ? $level : $none,
            t('piar.data.soportes') => !empty($input['soporte_clinico']) ? t('piar.data.soportes_si') : t('piar.data.soportes_no'),
            t('piar.data.condiciones') => $conds !== [] ? implode('; ', $conds) : $none,
        ];
        return $rows;
    }
}
