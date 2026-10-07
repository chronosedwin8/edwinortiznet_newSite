<?php

declare(strict_types=1);

namespace App\Services\Examenes;

/**
 * Simulador sin IA: arma un examen de muestra con el banco fijo (DemoBank) según lo que el docente elige.
 * Usa el mismo armado de versiones, la misma vista previa y el mismo PDF (con marca de agua «DEMO»).
 */
final class ExamDemo
{
    public const MAX_VERSIONS = 4;

    /** Banco principal y de respaldo para cada materia. */
    private const MAP = [
        'matematicas' => ['matematicas', 'fisica'], 'geometria' => ['matematicas', 'fisica'], 'estadistica' => ['matematicas', 'fisica'],
        'calculo' => ['matematicas', 'fisica'], 'fisica' => ['fisica', 'matematicas'], 'quimica' => ['quimica', 'fisica'],
        'ciencias_naturales' => ['quimica', 'fisica'], 'biologia' => ['quimica', 'fisica'], 'tecnologia' => ['fisica', 'matematicas'],
        'lenguaje' => ['lenguaje', 'sociales'], 'ingles' => ['lenguaje', 'sociales'], 'filosofia' => ['sociales', 'lenguaje'],
        'etica' => ['sociales', 'lenguaje'], 'religion' => ['sociales', 'lenguaje'], 'artistica' => ['lenguaje', 'sociales'],
        'educacion_fisica' => ['sociales', 'lenguaje'], 'sociales' => ['sociales', 'lenguaje'], 'historia' => ['sociales', 'lenguaje'],
        'geografia' => ['sociales', 'lenguaje'], 'economia' => ['sociales', 'matematicas'], 'emprendimiento' => ['sociales', 'matematicas'],
        'otra' => ['sociales', 'lenguaje'],
    ];

    /** Ejemplo con el que se llena el simulador (editable). */
    public static function defaults(): array
    {
        return [
            'materia' => 'matematicas',
            'materia_otra' => '',
            'grado' => '9',
            'tema' => 'Ecuaciones cuadráticas y función cuadrática',
            'contexto' => "Vimos la fórmula general, el discriminante, el vértice de la parábola y problemas de área y de lanzamiento de objetos. El grupo tiene 36 estudiantes; a muchos les gusta el fútbol.",
            'alcance' => 'unidad',
            'proposito' => 'sumativa',
            'dificultad' => 'medio',
            'estilo' => 'saber',
            'opciones' => 4,
            'tipos' => ['unica' => 2, 'multiple' => 1, 'vf' => 1, 'corta' => 1, 'completar' => 1, 'relacionar' => 1, 'ordenar' => 1, 'problema' => 2, 'abierta' => 1, 'larga' => 0, 'crucigrama' => 1, 'sopa' => 0],
            'versiones' => 2,
            'modo' => 'distintas',
        ];
    }

    public static function defaultHeader(): array
    {
        return [
            'institucion' => t('examenes.demo.institution'),
            'docente' => t('examenes.demo.teacher'),
            'duracion' => t('examenes.demo.duration'),
            'fecha' => '',
            'papel' => 'carta',
            'letra' => 'normal',
            'hoja' => true,
            'puntaje' => true,
            'logo' => false,
        ] + Exams::sanitizeHeader([]);
    }

    /** Preguntas disponibles por tipo para esa materia (banco principal + respaldo). */
    public static function available(string $subject): array
    {
        $out = array_fill_keys(array_keys(ExamCatalog::TYPES), 0);
        foreach (self::MAP[$subject] ?? self::MAP['otra'] as $bank) {
            foreach (DemoBank::slots()[$bank] ?? [] as $slot) {
                $out[$slot['type']]++;
            }
        }
        return $out;
    }

    /**
     * Examen de muestra. Las cantidades se recortan a lo que tiene el banco; nunca se llama a la IA.
     * @return array{exam:array, input:array, content:array, versions:array, clamped:bool}
     */
    public static function build(array $input): array
    {
        if ($input['materia'] === '') {
            $input['materia'] = 'matematicas';
        }
        $input['versiones'] = max(1, min(self::MAX_VERSIONS, (int) $input['versiones']));
        $banks = self::MAP[$input['materia']] ?? self::MAP['otra'];
        $pool = [];
        foreach ($banks as $bank) {
            foreach (DemoBank::slots()[$bank] ?? [] as $slot) {
                $pool[$slot['type']][] = $slot;
            }
        }
        $slots = [];
        $clamped = false;
        foreach ($input['tipos'] as $type => $n) {
            $have = count($pool[$type] ?? []);
            if ($n > $have) {
                $clamped = true;
            }
            foreach (array_slice($pool[$type] ?? [], 0, min($n, $have)) as $slot) {
                $slots[] = $slot;
            }
            $input['tipos'][$type] = min($n, $have);
        }
        if ($slots === []) {
            $input['tipos'] = self::defaults()['tipos'];
            return self::build($input);
        }
        $content = ['v' => 1, 'seed' => Rng::seed($input['materia'], $input['tema'], $input['versiones'], $input['modo']), 'slots' => $slots];
        $exam = [
            'id' => 0,
            'uuid' => 'demo',
            'mode' => $input['modo'],
            'versions' => $input['versiones'],
            'subject' => $input['materia'],
            'grade' => $input['grado'] !== '' ? $input['grado'] : '9',
            'title' => $input['tema'],
            'created_at' => gmdate('Y-m-d H:i:s'),
            'status' => 'done',
        ];
        $versions = ExamContent::build($content, ['mode' => $input['modo'], 'versions' => $input['versiones'], 'difficulty' => $input['dificultad']]);
        return ['exam' => $exam, 'input' => $input, 'content' => $content, 'versions' => $versions, 'clamped' => $clamped];
    }
}
