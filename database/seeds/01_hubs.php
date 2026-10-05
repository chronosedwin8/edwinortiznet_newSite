<?php

declare(strict_types=1);

use App\Core\DB;

/*
 * Hubs en español: introducción (150–250 palabras), guía pilar y preguntas frecuentes.
 * El contenido de la antigua página /excel/ ("Ver cursos de Excel" + listado de artículos) se integra en el hub.
 */
return static function (): string {
    $hubs = [
        'excel' => [
            'sort' => 1,
            'pillar' => 'como-automatizar-tareas-en-excel-y-reducir-errores',
            'slug' => 'excel',
            'title' => 'Excel y automatización de oficina',
            'menu_title' => 'Excel',
            'seo_title' => 'Excel y automatización de oficina: guías y plantillas',
            'seo_description' => 'Aprende a automatizar Excel y Word: correos masivos con adjuntos, combinar correspondencia en PDF, códigos QR y facturas. Guías paso a paso y plantillas listas.',
            'intro' => <<<'HTML'
<p>Si en tu trabajo repites cada semana las mismas tareas en Excel y Word —enviar decenas de correos con adjuntos distintos, sacar un PDF por cada fila de una lista, numerar facturas o generar códigos QR para un inventario—, aquí encuentras cómo dejar de hacerlo a mano.</p>
<p>Este espacio reúne las guías que he escrito durante años enseñando ofimática a docentes, secretarias, auxiliares administrativos y emprendedores. Están organizadas para que avances por niveles: primero lo básico (formatos, fórmulas, listas desplegables, tablas dinámicas) y luego la automatización con macros y con Outlook.</p>
<p>Cada tutorial explica el procedimiento completo para que lo puedas hacer tú mismo. Si prefieres ahorrarte el trabajo, al final de cada guía encontrarás la plantilla lista para usar: la misma lógica del tutorial, probada y con soporte por correo.</p>
<p>¿Por dónde empezar? Si manejas correo masivo, ve directo a la guía de envío con adjuntos desde Excel y Outlook. Si generas certificados, constancias o cartas, mira cómo combinar correspondencia y guardar cada documento por separado. Y si trabajas con inventarios, revisa los generadores de códigos QR y de barras.</p>
<p><a href="/cursos/">Ver cursos de Excel</a></p>
HTML,
            'faq' => [
                ['q' => '¿Qué versión de Excel necesito para las plantillas?', 'a' => 'Las plantillas con macros funcionan en Excel para Windows (2016, 2019, 2021 y Microsoft 365) con las macros habilitadas. Cada ficha indica los requisitos exactos del producto.'],
                ['q' => '¿Funcionan en Excel para Mac o en Excel en la web?', 'a' => 'Las que usan macros VBA y Outlook de escritorio no funcionan en Excel en la web y tienen limitaciones en Mac. Revisa la sección de requisitos de cada producto antes de comprar.'],
                ['q' => '¿Puedo aprender a hacerlo yo mismo sin comprar nada?', 'a' => 'Sí. Cada guía explica el procedimiento paso a paso. La plantilla de pago es para quien prefiere tener la solución lista y ahorrar tiempo.'],
                ['q' => '¿Las macros son seguras?', 'a' => 'Las macros de las plantillas solo trabajan sobre tus archivos locales y no envían datos a terceros. Puedes abrir el editor de VBA y revisar el código antes de ejecutarlo.'],
            ],
        ],
        'ia-para-docentes' => [
            'sort' => 2,
            'pillar' => 'herramientas-tecnologicas-para-docentes-pros-y-contras',
            'slug' => 'ia-para-docentes',
            'title' => 'IA y tecnología para docentes',
            'menu_title' => 'Docentes',
            'seo_title' => 'IA y tecnología para docentes: guías prácticas de aula',
            'seo_description' => 'Ideas y herramientas para usar inteligencia artificial y tecnología en el aula: ciudadanía digital, pensamiento computacional y recursos listos para clase.',
            'intro' => <<<'HTML'
<p>Llevo más de veinte años en el aula enseñando matemáticas y tecnología, y sé que el tiempo del docente no alcanza: planear, calificar, llenar formatos, atender reuniones y, además, mantenerse al día con herramientas que cambian cada mes.</p>
<p>Esta sección reúne lo que me ha funcionado para usar la tecnología a favor del docente y no al revés: cómo apoyarte en la inteligencia artificial para preparar material sin perder tu criterio pedagógico, cómo enseñar ciudadanía digital y seguridad en internet, cómo trabajar el pensamiento computacional con recursos sencillos y cómo automatizar tareas administrativas con Excel y Word.</p>
<p>Encontrarás guías con ejemplos reales de clase, ventajas y desventajas de cada herramienta y recomendaciones para colegios con conectividad limitada. La idea no es reemplazar al maestro, sino quitarle carga repetitiva para que dedique más tiempo a lo que importa: sus estudiantes.</p>
<p>Si te estás preparando para el Concurso Docente, visita también la sección dedicada, con guías y entrevistas, y practica con simulacros reales en <a href="https://fundales.com/?utm_source=edwinortiz.net&amp;utm_medium=hub&amp;utm_campaign=hub-docentes" target="_blank" rel="noopener">Fundales</a>, gratis durante un año.</p>
HTML,
            'faq' => [
                ['q' => '¿Puedo usar inteligencia artificial para planear mis clases?', 'a' => 'Sí, como apoyo para generar ideas, ejemplos y borradores. Revisa siempre el resultado: la IA se equivoca y no conoce el contexto de tu grupo.'],
                ['q' => '¿Necesito conocimientos de programación?', 'a' => 'No. Las guías están pensadas para docentes de cualquier área y explican cada paso con capturas o video.'],
                ['q' => '¿Los recursos sirven para colegios sin buena conexión?', 'a' => 'Muchos sí. Siempre indico cuándo una actividad requiere internet y propongo alternativas sin conexión cuando existen.'],
            ],
        ],
        'concurso-docente' => [
            'sort' => 3,
            'pillar' => 'concurso-docente-2026-guia-definitiva-con-estrategias-normativa-y-simulacros-con-ia',
            'slug' => 'concurso-docente',
            'title' => 'Concurso Docente',
            'menu_title' => 'Concurso',
            'seo_title' => 'Concurso Docente en Colombia: guías, entrevista y simulacros',
            'seo_description' => 'Prepárate para el Concurso Docente de la CNSC: guía completa, preguntas frecuentes, entrevista para docentes y directivos, y simulacros reales en Fundales.',
            'intro' => <<<'HTML'
<p>Prepararse para el Concurso Docente exige método: conocer la normativa, entender cómo se evalúan las competencias y practicar con preguntas del estilo de la prueba. Aquí reúno las guías que he preparado para docentes de aula, orientadores y directivos docentes que aspiran a un nombramiento en propiedad.</p>
<p>Empieza por la guía completa, donde explico las etapas del concurso y una estrategia de estudio por semanas. Luego revisa las preguntas frecuentes y las guías de entrevista, que es la etapa que más dudas genera. Cuando tengas la teoría, entrena en <a href="https://fundales.com/?utm_source=edwinortiz.net&amp;utm_medium=hub&amp;utm_campaign=hub-concurso" target="_blank" rel="noopener">Fundales</a>, la plataforma de simulacros que creé para el concurso: preguntas tipo CNSC con juicio situacional, tiempo controlado y un análisis de tus resultados. La cuenta es gratuita durante un año.</p>
<p>Las fechas del proceso las define la Comisión Nacional del Servicio Civil (CNSC). Cada guía indica cuándo fue actualizada; las fechas definitivas siempre se publican en cnsc.gov.co, así que confírmalas allí antes de tomar decisiones.</p>
<p>Si te sirve, suscríbete: aviso por correo cuando publico material nuevo para el concurso.</p>
HTML,
            'faq' => [
                ['q' => '¿Dónde se consultan las fechas oficiales del concurso?', 'a' => 'En el sitio de la Comisión Nacional del Servicio Civil, cnsc.gov.co. Los cronogramas cambian, así que verifica allí antes de inscribirte.'],
                ['q' => '¿Dónde puedo hacer un simulacro del concurso?', 'a' => 'En Fundales (fundales.com), la plataforma de simulacros que creé para el Concurso Docente. Tiene preguntas tipo CNSC por cargo, control del tiempo y análisis de resultados, y la cuenta es gratuita durante un año.'],
                ['q' => '¿Sirve para directivos docentes y orientadores?', 'a' => 'Sí. Hay guías específicas para la entrevista de directivos docentes y material para docentes de aula de todas las áreas.'],
            ],
        ],
        'herramientas' => [
            'sort' => 4,
            'pillar' => null,
            'slug' => 'herramientas',
            'title' => 'Herramientas gratis',
            'menu_title' => 'Herramientas',
            'seo_title' => 'Herramientas gratis: generador QR, número a letras y más',
            'seo_description' => 'Herramientas gratuitas que funcionan en tu navegador sin enviar datos: generador de códigos QR en PNG y SVG, número a letras en pesos y simulacro del Concurso Docente.',
            'intro' => <<<'HTML'
<p>Estas herramientas resuelven tareas pequeñas que aparecen todos los días en la oficina y en el colegio. Funcionan directamente en tu navegador: lo que escribes no se envía a ningún servidor y puedes usarlas sin registrarte, incluso sin conexión una vez cargada la página.</p>
<p>El generador de códigos QR crea códigos para enlaces, textos o datos de contacto y los descarga en PNG o SVG, listos para imprimir. El conversor de número a letras escribe montos en palabras, con la opción «pesos M/CTE» que se usa en facturas, cheques y cuentas de cobro en Colombia. El simulacro del Concurso Docente te pone a prueba con preguntas al azar y te explica cada respuesta.</p>
<p>Si necesitas hacer lo mismo cientos de veces —por ejemplo, un código QR por cada producto de tu inventario o el valor en letras dentro de una factura de Excel—, cada herramienta enlaza a su versión automatizada para Excel.</p>
HTML,
            'faq' => [
                ['q' => '¿Mis datos se guardan en algún lugar?', 'a' => 'No. Las herramientas se ejecutan en tu navegador y no envían lo que escribes al servidor. Solo si decides recibir el resultado del simulacro por correo se guarda tu dirección.'],
                ['q' => '¿Puedo usar los códigos QR con fines comerciales?', 'a' => 'Sí. Los códigos generados son tuyos y no caducan: contienen directamente el texto o enlace que escribiste.'],
                ['q' => '¿Funcionan en el celular?', 'a' => 'Sí, las tres herramientas están diseñadas para pantallas pequeñas.'],
            ],
        ],
    ];

    foreach ($hubs as $key => $h) {
        $hubId = (int) DB::upsert('hubs', ['key' => $key, 'sort' => $h['sort']], ['key']);
        $pillar = $h['pillar'] ? DB::value('SELECT id FROM posts WHERE locale = "es" AND slug = :s', ['s' => $h['pillar']]) : null;
        DB::update('hubs', ['pillar_post_id' => $pillar !== null ? (int) $pillar : null], ['id' => $hubId]);
        DB::upsert('hub_translations', [
            'hub_id' => $hubId,
            'locale' => 'es',
            'slug' => $h['slug'],
            'title' => $h['title'],
            'menu_title' => $h['menu_title'],
            'intro_html' => $h['intro'],
            'faq_json' => json_encode($h['faq'], JSON_UNESCAPED_UNICODE),
            'seo_title' => $h['seo_title'],
            'seo_description' => $h['seo_description'],
        ], ['hub_id', 'locale']);
    }

    // La antigua página /excel/ queda integrada en el hub: se retira como página.
    DB::run('UPDATE posts SET status = "draft" WHERE locale = "es" AND type = "page" AND slug = "excel"');
    return count($hubs) . ' hubs';
};
