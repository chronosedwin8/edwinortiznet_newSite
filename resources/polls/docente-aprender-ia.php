<?php

declare(strict_types=1);

// Encuesta del artículo "La IA también obliga al docente a volver a aprender". Cinco preguntas; la primera (índice 0, frecuencia
// de uso de IA) segmenta las respuestas en `polls:results`. El orden y el número de opciones deben coincidir en ES y EN.
return [
    'es' => [
        'title' => 'Encuesta rápida: ¿y tú, qué piensas de volver a aprender por la IA?',
        'intro' => 'Cinco preguntas, menos de un minuto, anónima. Puedes contestar solo las que quieras.',
        'segment' => 0,
        'questions' => [
            ['q' => '¿Con qué frecuencia usas IA en tu trabajo docente?', 'options' => ['Nunca', 'Rara vez', 'Cada mes', 'Cada semana', 'A diario']],
            ['q' => '¿Qué es lo que más te frena para aprender sobre IA?', 'options' => ['La falta de tiempo', 'El costo de la formación', 'No sé por dónde empezar', 'La desconfianza o el miedo', 'Nada me frena']],
            ['q' => 'Aprender IA es para ti...', 'options' => ['Un reto que me motiva', 'Un reto, pero sin tiempo ni apoyo', 'Un trabajo adicional que no me corresponde', 'Una exigencia más del sistema', 'Algo que ya hago']],
            ['q' => '¿Seguirías siendo docente si la IA hiciera buena parte de lo que hoy haces?', 'options' => ['Sí, sin dudas', 'Sí, si mi rol cambia y me forman', 'Lo dudo', 'No', 'No lo sé']],
            ['q' => '¿Quién debería asumir el tiempo y el costo de esa formación?', 'options' => ['El Estado y las secretarías', 'El colegio o la institución', 'Cada docente', 'Entre todos', 'No es necesaria']],
        ],
    ],
    'en' => [
        'title' => 'Quick poll: what do you think about learning again because of AI?',
        'intro' => 'Five questions, under a minute, anonymous. Answer only the ones you want.',
        'segment' => 0,
        'questions' => [
            ['q' => 'How often do you use AI in your teaching work?', 'options' => ['Never', 'Rarely', 'Monthly', 'Weekly', 'Daily']],
            ['q' => 'What holds you back most from learning about AI?', 'options' => ['Lack of time', 'The cost of training', 'I do not know where to start', 'Distrust or fear', 'Nothing holds me back']],
            ['q' => 'For you, learning AI is...', 'options' => ['A challenge that motivates me', 'A challenge, but without time or support', 'Extra work that is not my job', 'One more demand from the system', 'Something I already do']],
            ['q' => 'Would you stay a teacher if AI did a good part of what you do today?', 'options' => ['Yes, without doubt', 'Yes, if my role changes and I am trained', 'I doubt it', 'No', 'I do not know']],
            ['q' => 'Who should take on the time and cost of that training?', 'options' => ['The State and education secretariats', 'The school or institution', 'Each teacher', 'Everyone together', 'It is not necessary']],
        ],
    ],
];
