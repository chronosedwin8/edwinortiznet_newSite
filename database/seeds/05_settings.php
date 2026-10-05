<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * Ajustes por defecto y dos preguntas de demostración del simulacro.
 * [DECISIÓN DE EDWIN] cargar el banco real de preguntas desde el panel (no se inventan preguntas).
 */
return static function (): string {
    $defaults = [
        'whatsapp_number' => '573162830615',
        'social_youtube' => '',
        'social_linkedin' => '',
        'refund_days' => '7',
        'ads_enabled' => '1',
        'adsense_max_blocks' => '3',
    ];
    foreach ($defaults as $key => $value) {
        DB::run('INSERT IGNORE INTO settings (`key`, `value`) VALUES (:k, :v)', ['k' => $key, 'v' => $value]);
    }

    $demo = [
        [
            'area' => 'Demostración',
            'question' => '[Pregunta de demostración] ¿Qué entidad publica las fechas oficiales del Concurso Docente en Colombia?',
            'options' => ['El Ministerio de Educación Nacional', 'La Comisión Nacional del Servicio Civil (CNSC)', 'Cada secretaría de educación', 'El ICFES'],
            'correct' => 1,
            'explanation' => 'La CNSC es la entidad que adelanta los concursos de méritos y publica sus cronogramas en cnsc.gov.co. Esta pregunta es solo una demostración del funcionamiento del simulacro.',
        ],
        [
            'area' => 'Demostración',
            'question' => '[Pregunta de demostración] Si un estudiante obtiene 3,5; 4,0 y 4,5 en tres evaluaciones con el mismo peso, ¿cuál es su promedio?',
            'options' => ['3,8', '4,0', '4,2', '12,0'],
            'correct' => 1,
            'explanation' => '(3,5 + 4,0 + 4,5) ÷ 3 = 12 ÷ 3 = 4,0. Esta pregunta es solo una demostración del funcionamiento del simulacro.',
        ],
    ];
    foreach ($demo as $q) {
        $exists = DB::value('SELECT id FROM quiz_questions WHERE question = :q', ['q' => $q['question']]);
        if ($exists === null) {
            DB::insert('quiz_questions', [
                'area' => $q['area'],
                'question' => $q['question'],
                'options_json' => json_encode($q['options'], JSON_UNESCAPED_UNICODE),
                'correct_index' => $q['correct'],
                'explanation' => $q['explanation'],
                'is_demo' => 1,
                'active' => 1,
            ]);
        }
    }
    return count($defaults) . ' ajustes, 2 preguntas de demostración';
};
