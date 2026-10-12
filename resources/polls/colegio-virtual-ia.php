<?php

declare(strict_types=1);

// Encuesta del artículo "¿Se puede crear un colegio 100 % virtual con docentes 100 % de IA?". Cinco preguntas; la quinta
// (índice 4) segmenta las respuestas por rol en `polls:results`. El orden y el número de opciones deben coincidir en ES y EN.
return [
    'es' => [
        'title' => 'Encuesta rápida: ¿qué piensas de un colegio con docentes de IA?',
        'intro' => 'Cinco preguntas, menos de un minuto, anónima. Puedes contestar solo las que quieras.',
        'segment' => 4,
        'questions' => [
            ['q' => '¿Qué tan de acuerdo estás con crear un colegio 100 % virtual con docentes 100 % de IA?', 'options' => ['Nada de acuerdo', 'Poco de acuerdo', 'Depende de la evidencia', 'De acuerdo', 'Muy de acuerdo']],
            ['q' => '¿Qué papel debería tener la IA en la enseñanza?', 'options' => ['Ninguno', 'Apoyar al docente (planear, calificar)', 'Tutor del estudiante, con un docente presente', 'Tutor principal, con un adulto que acompaña', 'Reemplazar al docente']],
            ['q' => 'Si fueras madre, padre o acudiente, ¿matricularías hoy a tu hijo o hija en un colegio así?', 'options' => ['No', 'Solo con evidencia y permiso oficial', 'Solo como complemento, no como colegio', 'Sí, en una prueba piloto', 'Sí']],
            ['q' => '¿Cuál es tu mayor preocupación?', 'options' => ['Que se pierda el trato humano', 'La privacidad de los datos de los niños', 'Los errores y la calidad de lo que enseña', 'La desigualdad y la conectividad', 'La pérdida de empleos docentes', 'No me preocupa']],
            ['q' => '¿Desde qué lugar respondes?', 'options' => ['Docente', 'Directivo o coordinador', 'Madre, padre o acudiente', 'Estudiante', 'Otro']],
        ],
    ],
    'en' => [
        'title' => 'Quick poll: what do you think of a school with AI teachers?',
        'intro' => 'Five questions, under a minute, anonymous. Answer only the ones you want.',
        'segment' => 4,
        'questions' => [
            ['q' => 'How much do you agree with creating a 100% virtual school with 100% AI teachers?', 'options' => ['Not at all', 'A little', 'It depends on the evidence', 'I agree', 'I strongly agree']],
            ['q' => 'What role should AI have in teaching?', 'options' => ['None', 'Support the teacher (planning, marking)', 'Student tutor, with a teacher present', 'Main tutor, with an adult accompanying', 'Replace the teacher']],
            ['q' => 'If you were a parent or guardian, would you enroll your child in a school like that today?', 'options' => ['No', 'Only with evidence and official approval', 'Only as a complement, not as a school', 'Yes, in a pilot', 'Yes']],
            ['q' => 'What worries you most?', 'options' => ['Losing human contact', 'Children\'s data privacy', 'Errors and quality of what it teaches', 'Inequality and connectivity', 'Loss of teaching jobs', 'I am not worried']],
            ['q' => 'Where are you answering from?', 'options' => ['Teacher', 'Principal or coordinator', 'Parent or guardian', 'Student', 'Other']],
        ],
    ],
];
