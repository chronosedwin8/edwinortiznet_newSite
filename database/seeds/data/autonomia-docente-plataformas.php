<?php

declare(strict_types=1);

// «¿El docente está perdiendo autonomía pedagógica ante las plataformas…?» Fuentes verificadas el 9 de octubre de 2026: Informe GEM 2023 de la UNESCO, encuesta Gallup-Walton 2025, Constitución arts. 27 y 68, Ley 115 de 1994 art. 77 y TALIS 2024.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/autonomia-docente-plataformas/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$code = static fn (string $html): string => (string) preg_replace_callback(
    '#<pre><code>(.*?)</code></pre>#s',
    static fn (array $m): string => '<pre><code>' . htmlspecialchars($m[1], ENT_NOQUOTES, 'UTF-8') . '</code></pre>',
    $html
);

$html = <<<'HTML'
<p>Hace unos años, la planeación, la evaluación y las recomendaciones de qué enseñar dependían, sobre todo, del docente y de su equipo. Hoy hay plataformas que sugieren la ruta de cada estudiante, califican automáticamente, generan guías de clase con IA y recomiendan «el siguiente contenido». Muchas ahorran tiempo de verdad. Pero cada decisión que la plataforma toma por defecto es una decisión que el docente deja de tomar, y de tanto no tomarla, puede olvidar cómo se toma.</p>
<p>En este artículo contrasto la <strong>asistencia tecnológica</strong> con la <strong>sustitución del criterio profesional</strong>, reviso la evidencia y el marco legal en Colombia, y te dejo una <strong>matriz de decisiones</strong> para definir cuáles deben seguir siendo responsabilidad del docente. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> La evidencia sobre el valor de la tecnología educativa es limitada y a menudo proviene de quienes la venden (UNESCO, 2023); la Constitución colombiana garantiza la libertad de cátedra y la Ley 115 reconoce autonomía a los colegios para adoptar métodos de enseñanza. La tecnología ayuda cuando el docente decide cuándo usarla, la entiende y puede ignorarla. La línea: <strong>asistir, sí; decidir por el docente, no</strong>.</p>

<h2>Lo que dice la evidencia: poca, y a veces interesada</h2>
<p>El <a href="https://gem-report-2023.unesco.org/">Informe de Seguimiento de la Educación en el Mundo 2023 de la UNESCO</a>, «La tecnología en la educación: ¿una herramienta en qué condiciones?», concluye que existe poca evidencia robusta e imparcial sobre el valor agregado de la tecnología digital en la educación; que buena parte de la evidencia proviene de quienes buscan venderla; que los productos cambian, en promedio, cada 36 meses, a menudo antes de poder evaluarse; y que, en una encuesta a docentes y administradores de 17 estados de EE. UU., solo el 11 % pidió evidencia revisada por pares antes de adoptar una herramienta. Además, su director advirtió que las voces del sector empresarial suelen sonar más fuerte que las de docentes y estudiantes en este debate. El informe recomienda que la tecnología se introduzca con base en evidencia de que es apropiada, equitativa, escalable y sostenible, y que <strong>nunca reemplace la enseñanza presencial dirigida por docentes</strong>.</p>
<p>Del lado del ahorro de tiempo, una encuesta de Gallup y la Fundación Walton en EE. UU. (junio de 2025, con más de 2.000 docentes) encontró que quienes usan IA al menos una vez por semana reportan ahorrar unas 5,9 horas semanales; pero solo el 32 % la usa semanalmente, y en las escuelas con una política de IA el beneficio declarado fue 26 % mayor. Son datos de EE. UU. y autorreportados, pero apuntan a algo útil: <strong>la tecnología rinde más cuando hay reglas claras de uso</strong>, no cuando se instala sin criterio.</p>

<h2>Qué dice el marco colombiano</h2>
<p>El artículo 27 de la Constitución garantiza «las libertades de enseñanza, aprendizaje, investigación y cátedra», y el artículo 68 exige que la enseñanza esté a cargo de personas de reconocida idoneidad ética y pedagógica. La Ley 115 de 1994 (artículo 77) reconoce, dentro de los límites de la ley y del Proyecto Educativo Institucional, la autonomía de las instituciones para, entre otras cosas, adoptar métodos de enseñanza. En términos prácticos: <strong>la decisión sobre cómo enseñar es profesional e institucional, no de un proveedor</strong>. Una plataforma puede ser una buena herramienta, pero no es el PEI ni sustituye la idoneidad del docente. Esa autonomía tiene doble filo: exige criterio, y el criterio se pierde si no se ejercita.</p>
{{img:linea}}

<h2>Cómo se pierde la autonomía: cuatro señales</h2>
<ol>
<li><strong>El docente ya no sabe por qué.</strong> Si no puedes explicar por qué la plataforma recomienda una actividad, estás obedeciendo, no decidiendo.</li>
<li><strong>Las notas salen de una caja negra.</strong> Una calificación automática sin revisión puede replicar sesgos o malentender una respuesta válida; y si el docente no la revisa, nadie la defiende ante el estudiante.</li>
<li><strong>El currículo lo define el recurso prediseñado.</strong> Cuando la planeación consiste en «terminar las unidades de la plataforma», el PEI y el contexto del grupo quedan en segundo plano.</li>
<li><strong>La carga administrativa crece.</strong> Cada plataforma exige usuarios, datos y reportes, y el tiempo ahorrado en una tarea se gasta en administrarla (hablaré de esa «deuda tecnológica» en un próximo artículo).</li>
</ol>
<p>Conviene ser justo: <strong>no todo uso es una pérdida de autonomía</strong>. Delegar el borrador de una guía, la clasificación de errores comunes o una primera versión de un examen puede liberar tiempo para lo que solo el docente hace: observar al grupo, conversar con un estudiante, decidir qué reforzar mañana.</p>

<h2>Matriz de decisiones: qué se delega y qué no</h2>
<p>Este es el recurso aplicable. Úsala con tu área o tu consejo académico:</p>
<table>
<thead><tr><th>Decisión pedagógica</th><th>Asistencia aceptable</th><th>Línea roja (decide el docente)</th></tr></thead>
<tbody>
<tr><td><strong>Qué enseñar (objetivos y secuencia)</strong></td><td>Sugerir temas y recursos alineados con estándares.</td><td>Elegir el orden, la profundidad y lo que se omite según el grupo y el PEI.</td></tr>
<tr><td><strong>Cómo enseñar</strong></td><td>Ofrecer actividades y ejemplos.</td><td>Escoger el método y adaptarlo; poder cambiarlo sobre la marcha.</td></tr>
<tr><td><strong>Cómo evaluar</strong></td><td>Generar versiones de ejercicios o preguntas y corregir lo objetivo.</td><td>Definir criterios, revisar las calificaciones y decidir la nota final.</td></tr>
<tr><td><strong>Retroalimentación</strong></td><td>Proponer comentarios que el docente edita.</td><td>El mensaje que recibe el estudiante, con su contexto.</td></tr>
<tr><td><strong>Atención a la diversidad e inclusión</strong></td><td>Proponer ajustes razonables como borrador.</td><td>Validar los ajustes con el estudiante, la familia y el equipo.</td></tr>
<tr><td><strong>Decisiones sobre personas (grupos, promoción, sanciones)</strong></td><td>Mostrar datos de apoyo.</td><td>Decidir; nunca de forma automática.</td></tr>
<tr><td><strong>Uso de datos de estudiantes</strong></td><td>Usar datos mínimos y anonimizados.</td><td>Autorizar qué datos salen del colegio (ver <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">el artículo sobre datos de estudiantes</a>).</td></tr>
</tbody>
</table>
<p>Y tres preguntas de control antes de adoptar una plataforma: <strong>1) ¿Puedo ver y cambiar lo que recomienda o califica? 2) ¿Hay evidencia independiente de que mejora el aprendizaje (no solo la del proveedor)? 3) ¿Qué pasa con mi planeación y mis datos si dejo de usarla?</strong></p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la discusión se conoce como el riesgo de «desprofesionalizar» la docencia: convertir al maestro en operador de un sistema. En Colombia y Latinoamérica, el riesgo se mezcla con la escasez de tiempo y de recursos: una plataforma que ofrece guías listas es muy atractiva para un docente con 30 horas de clase. Según la OCDE (TALIS 2024), alrededor del 53 % de los docentes colombianos usó IA en el último año, más que el promedio de la OCDE (36 %), y el 54 % siente que la sociedad valora su profesión; ese uso masivo sin reglas institucionales es justamente lo que conviene ordenar. Para <strong>docentes</strong>, la meta es usar la tecnología sin perder el criterio; para <strong>directivos</strong>, definir una política y exigir evidencia a los proveedores; para <strong>familias</strong>, preguntar si el docente sigue decidiendo cómo se enseña y evalúa a sus hijos.</p>

<h2>Herramientas diseñadas para que el docente decida</h2>
<p>Las herramientas que construyo parten de esa línea. En el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>, el docente escribe el contexto y el tema específico, revisa el examen y sus soluciones y decide si lo usa; en <a href="/herramientas/piar/">PIAR con IA</a>, el asistente redacta borradores campo por campo y el documento advierte que debe ser revisado y validado por el equipo de expertos; y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia para que adaptes la planeación, no para que la reemplaces. Hay una <a href="/examenes/demo/">demostración gratuita del generador</a>.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">¿la IA amplía el pensamiento o lo reemplaza?</a>, <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden las calificaciones</a> y <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Usar una plataforma significa perder autonomía?</h3>
<p>No necesariamente. Se pierde autonomía cuando el docente no puede ver, cuestionar ni cambiar lo que la plataforma decide. Se conserva cuando la usa como apoyo y mantiene las decisiones pedagógicas.</p>
<h3>¿Tiene un colegio derecho a imponer una plataforma a sus docentes?</h3>
<p>El colegio tiene autonomía institucional para adoptar métodos dentro del PEI, y el docente tiene libertad de cátedra. Lo sano es decidir con la comunidad educativa, con evidencia y con reglas claras, no por imposición del proveedor.</p>
<h3>¿Qué evidencia debo pedir a un proveedor de tecnología educativa?</h3>
<p>Evaluaciones independientes y, si es posible, revisadas por pares, en contextos parecidos al tuyo, con resultados de aprendizaje (no solo uso o satisfacción). La UNESCO advierte que mucha de la evidencia disponible viene de quienes venden.</p>
<h3>¿Puede la IA calificar por mí?</h3>
<p>Puede ayudar con lo objetivo, pero las decisiones de evaluación (criterios, revisión y nota final) deben seguir en manos del docente, que responde ante el estudiante.</p>
<h3>¿Cómo propongo una política de uso en mi colegio?</h3>
<p>Lleva la matriz de decisiones a tu consejo académico y propón categorías de uso permitido, condicionado y no autorizado, con responsables y revisión periódica.</p>

<p class="notice"><strong>Revisa tus decisiones esta semana.</strong> Aplica la matriz a las plataformas que usas y anota qué decisiones pedagógicas has delegado sin darte cuenta. Recupera las que deban ser tuyas, y para las demás usa herramientas que te dejen revisar y cambiar: prueba el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> o el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>.</p>

<h2>Para pensar</h2>
<p>Si una plataforma planea, enseña, evalúa y recomienda, ¿qué queda del oficio de enseñar? <strong>¿Es la autonomía pedagógica un privilegio que los docentes deben defender, o una carga de la que muchos estarían felices de librarse, y quién debería decidir cuánta autonomía necesita realmente un docente: la ley, el colegio o la propia práctica?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:linea}}' => $img('autonomia-docente-plataformas-linea', 633, 'Cuadro comparativo entre asistencia tecnológica, que propone recursos que el docente revisa, ahorra tiempo y es transparente, y sustitución, que impone la ruta o la nota, es opaca y deja al docente solo ejecutando.', 'Asistir no es sustituir.'),
]);

return [
    'slug' => 'docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan',
    'title' => '¿El docente está perdiendo autonomía pedagógica ante las plataformas que planean, evalúan y recomiendan por él?',
    'excerpt' => 'Asistencia tecnológica frente a sustitución del criterio profesional: qué dice la evidencia de la UNESCO, qué dice el marco colombiano y una matriz de decisiones que deben seguir siendo del docente.',
    'seo_title' => 'Autonomía pedagógica del docente frente a las plataformas',
    'seo_description' => 'Evidencia de la UNESCO, marco colombiano y una matriz de decisiones para que el docente conserve su autonomía pedagógica frente a plataformas e IA.',
    'focus_keyword' => 'autonomía pedagógica del docente',
    'cover' => '/assets/img/articulos/autonomia-docente-plataformas/autonomia-docente-plataformas-portada',
    'cover_alt' => 'Portada «¿Pierde el docente autonomía ante las plataformas que deciden por él?» con una lista: la plataforma sugiere y el docente elige y adapta, marcados; calificar sin revisión y un algoritmo que define el currículo, descartados.',
    'published_at' => '2026-11-04 12:00:00',
    'content_html' => $html,
];
