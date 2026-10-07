<?php

declare(strict_types=1);

namespace App\Services\Examenes;

/**
 * Catálogos del generador de exámenes: materias, grados, niveles, estilos de redacción, alcance,
 * tipos de pregunta, modos de versión y tamaños de papel. Las etiquetas viven en lang/examenes.es.php.
 */
final class ExamCatalog
{
    /**
     * Materias. math: full (LaTeX en enunciados y soluciones), light (fórmulas ocasionales), none.
     * @var array<string, array{math:string}>
     */
    public const SUBJECTS = [
        'matematicas' => ['math' => 'full'],
        'geometria' => ['math' => 'full'],
        'estadistica' => ['math' => 'full'],
        'calculo' => ['math' => 'full'],
        'fisica' => ['math' => 'full'],
        'quimica' => ['math' => 'full'],
        'ciencias_naturales' => ['math' => 'light'],
        'biologia' => ['math' => 'light'],
        'tecnologia' => ['math' => 'light'],
        'lenguaje' => ['math' => 'none'],
        'ingles' => ['math' => 'none'],
        'sociales' => ['math' => 'none'],
        'historia' => ['math' => 'none'],
        'geografia' => ['math' => 'none'],
        'filosofia' => ['math' => 'none'],
        'etica' => ['math' => 'none'],
        'religion' => ['math' => 'none'],
        'artistica' => ['math' => 'none'],
        'educacion_fisica' => ['math' => 'none'],
        'economia' => ['math' => 'light'],
        'emprendimiento' => ['math' => 'light'],
        'otra' => ['math' => 'light'],
    ];

    public const GRADES = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', 'tecnico', 'universitario'];
    public const DIFFICULTIES = ['basico', 'medio', 'avanzado', 'progresivo'];
    public const STYLES = ['directo', 'saber', 'vida_real', 'ludico', 'narrativo', 'cientifico', 'mixto'];
    public const SCOPES = ['subtema', 'unidad', 'periodo', 'acumulativo'];
    public const PURPOSES = ['diagnostica', 'formativa', 'sumativa', 'recuperacion', 'simulacro'];
    public const MODES = ['distintas', 'barajar'];
    public const OPTION_COUNTS = [3, 4, 5];

    /**
     * Tipos de pregunta en el orden de las secciones del examen.
     * cap: tope de tokens de salida por pregunta y versión (acota el peor caso de costo).
     * max: cuántas de ese tipo caben en un examen. points: puntaje sugerido. sheet: va en la hoja de respuestas.
     * @var array<string, array{cap:int, max:int, points:float, sheet:string}>
     */
    public const TYPES = [
        'unica' => ['cap' => 520, 'max' => 60, 'points' => 1, 'sheet' => 'bubble'],
        'multiple' => ['cap' => 540, 'max' => 40, 'points' => 1, 'sheet' => 'bubble'],
        'vf' => ['cap' => 300, 'max' => 40, 'points' => 1, 'sheet' => 'bubble'],
        'corta' => ['cap' => 320, 'max' => 40, 'points' => 1, 'sheet' => 'box'],
        'completar' => ['cap' => 400, 'max' => 20, 'points' => 1, 'sheet' => 'box'],
        'relacionar' => ['cap' => 520, 'max' => 6, 'points' => 2, 'sheet' => 'match'],
        'ordenar' => ['cap' => 460, 'max' => 10, 'points' => 2, 'sheet' => 'order'],
        'problema' => ['cap' => 760, 'max' => 20, 'points' => 3, 'sheet' => 'none'],
        'abierta' => ['cap' => 520, 'max' => 20, 'points' => 2, 'sheet' => 'none'],
        'larga' => ['cap' => 760, 'max' => 6, 'points' => 4, 'sheet' => 'none'],
        'crucigrama' => ['cap' => 560, 'max' => 2, 'points' => 4, 'sheet' => 'none'],
        'sopa' => ['cap' => 460, 'max' => 2, 'points' => 3, 'sheet' => 'none'],
    ];

    /** Papel: [ancho, alto] en puntos PDF (1 in = 72 pt). Oficio colombiano: 8,5 × 13 in (216 × 330 mm). */
    public const PAPERS = [
        'carta' => [612.0, 792.0],
        'oficio' => [612.0, 936.0],
        'media_carta' => [396.0, 612.0],
    ];

    /** Letras de las versiones. */
    public const VERSION_LABELS = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];

    public static function subjects(): array
    {
        $out = [];
        foreach (array_keys(self::SUBJECTS) as $k) {
            $out[$k] = t("examenes.subject.$k");
        }
        return $out;
    }

    public static function mathLevel(string $subject): string
    {
        return self::SUBJECTS[$subject]['math'] ?? 'light';
    }

    public static function grades(): array
    {
        $out = [];
        foreach (self::GRADES as $g) {
            $out[$g] = t('examenes.grade.' . $g);
        }
        return $out;
    }

    /** @return array<string, string> */
    private static function labels(array $keys, string $prefix): array
    {
        $out = [];
        foreach ($keys as $k) {
            $out[$k] = t("$prefix.$k");
        }
        return $out;
    }

    public static function difficulties(): array
    {
        return self::labels(self::DIFFICULTIES, 'examenes.difficulty');
    }

    public static function styles(): array
    {
        return self::labels(self::STYLES, 'examenes.style');
    }

    public static function scopes(): array
    {
        return self::labels(self::SCOPES, 'examenes.scope');
    }

    public static function purposes(): array
    {
        return self::labels(self::PURPOSES, 'examenes.purpose');
    }

    public static function papers(): array
    {
        return self::labels(array_keys(self::PAPERS), 'examenes.paper');
    }

    public static function types(): array
    {
        return self::labels(array_keys(self::TYPES), 'examenes.type');
    }

    public static function typeHints(): array
    {
        return self::labels(array_keys(self::TYPES), 'examenes.type_hint');
    }

    public static function isType(string $type): bool
    {
        return isset(self::TYPES[$type]);
    }

    /** Descripciones para el modelo (no se muestran al docente). */
    public const AI_STYLE = [
        'directo' => 'Enunciados directos y breves, sin contexto adicional.',
        'saber' => 'Estilo de las Pruebas Saber del ICFES: cada pregunta parte de un contexto (situación, texto corto, tabla o gráfica descrita en palabras) y evalúa una competencia; opciones plausibles con distractores basados en errores frecuentes.',
        'vida_real' => 'Situaciones de la vida cotidiana colombiana (mercado, transporte, finanzas personales, salud, deporte, medio ambiente), con datos realistas.',
        'ludico' => 'Tono lúdico y motivador: retos, juegos, personajes y misiones, sin perder rigor.',
        'narrativo' => 'Una historia o personaje que hila varias preguntas, con contexto narrativo breve.',
        'cientifico' => 'Contexto científico: experimentos, datos, tablas y gráficas descritas en texto, análisis de resultados.',
        'mixto' => 'Combina enunciados directos con preguntas contextualizadas y situaciones reales.',
    ];

    public const AI_DIFFICULTY = [
        'basico' => 'básico: reconocimiento y aplicación directa de conceptos',
        'medio' => 'medio: aplicación en situaciones conocidas y relación de conceptos',
        'avanzado' => 'avanzado: análisis, argumentación y resolución de problemas no rutinarios',
        'progresivo' => 'progresivo: empieza básico y termina avanzado',
    ];

    public const AI_SCOPE = [
        'subtema' => 'un subtema puntual',
        'unidad' => 'una unidad temática completa',
        'periodo' => 'los temas de todo un periodo académico',
        'acumulativo' => 'una evaluación acumulativa del año',
    ];

    public const AI_PURPOSE = [
        'diagnostica' => 'evaluación diagnóstica (saberes previos)',
        'formativa' => 'evaluación formativa o quiz de clase',
        'sumativa' => 'evaluación sumativa de periodo',
        'recuperacion' => 'actividad de recuperación o nivelación',
        'simulacro' => 'simulacro tipo Pruebas Saber',
    ];

    /** Instrucción por tipo para el modelo: qué campos usar. */
    public const AI_TYPES = [
        'unica' => 'Selección múltiple con única respuesta: q = enunciado; o = exactamente :o opciones sin letras; a = [índice de la única correcta, desde 0]; s = explicación breve de por qué es correcta.',
        'multiple' => 'Selección múltiple con múltiples respuestas: q = enunciado que indique «Seleccione todas las correctas»; o = exactamente :o opciones sin letras; a = índices de las correctas (entre 2 y :o-1); s = explicación breve.',
        'vf' => 'Verdadero o falso: q = afirmación (no pregunta); tf = true o false; s = justificación breve (si es falsa, cómo sería verdadera). Equilibre verdaderas y falsas.',
        'corta' => 'Respuesta corta: q = pregunta cuya respuesta es una palabra, número o expresión breve; r = respuesta esperada exacta; s = explicación breve.',
        'completar' => 'Completar espacios: q = texto con 1 a 4 espacios marcados {{1}}, {{2}}…; b = respuestas de cada espacio en orden; s = explicación breve opcional.',
        'relacionar' => 'Relacionar columnas: q = instrucción breve; p = entre 4 y 7 parejas {l: elemento de la columna A, r: su pareja correcta en la columna B}. Las parejas deben ser inequívocas.',
        'ordenar' => 'Jerarquización u ordenamiento: q = instrucción que diga el criterio de orden; it = entre 4 y 7 elementos YA en el orden correcto; s = explicación breve del orden.',
        'problema' => 'Problema de aplicación: q = enunciado completo con todos los datos; r = respuesta final; s = solución paso a paso, concisa (máximo 8 pasos); ru = 2 o 3 criterios de calificación.',
        'abierta' => 'Pregunta abierta: q = pregunta; r = respuesta modelo breve; ru = 3 criterios de calificación observables.',
        'larga' => 'Respuesta larga o ensayo: q = consigna con extensión esperada; r = aspectos clave de una respuesta modelo; ru = 4 criterios de rúbrica (cada uno con lo que se espera).',
        'crucigrama' => 'Crucigrama: q = instrucción breve; w = entre 8 y 12 objetos {w: palabra en MAYÚSCULAS sin espacios, tildes ni signos (4 a 12 letras), c: pista clara}. Las palabras deben compartir letras para poder cruzarse.',
        'sopa' => 'Sopa de letras: q = instrucción breve que anticipe el tema; w = entre 8 y 14 objetos {w: palabra en MAYÚSCULAS sin espacios, tildes ni signos (3 a 12 letras), c: definición corta}.',
    ];
}
