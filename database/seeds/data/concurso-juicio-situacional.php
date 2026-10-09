<?php

declare(strict_types=1);

// «Juicio situacional en el Concurso Docente»: método y cuatro casos de práctica (no oficiales) sobre convivencia (Ley 1620 de 2013), inclusión (Decreto 1421 de 2017), evaluación (Decreto 1290 de 2009) y gestión escolar (Ley 115 de 1994). Estructura de la prueba según las respuestas de la CNSC al proyecto de acuerdo (septiembre de 2026). Última verificación: 9 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/concurso-juicio-situacional/' . $name;
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
<p>Hay preguntas de concurso que no se resuelven recordando un artículo, sino <strong>analizando una situación</strong>: un estudiante, una familia, una norma y cuatro opciones que parecen razonables. Lo difícil es que casi siempre hay una opción «aparentemente correcta» (firme, amable, prudente) que falla por un detalle del marco aplicable. Este artículo te enseña un método para analizar un caso sin caer en esa trampa, con cuatro casos hipotéticos resueltos paso a paso.</p>
<p>Una advertencia: <strong>los casos de este artículo son ejercicios de práctica que escribí yo, no preguntas oficiales</strong> ni garantizan lo que aparecerá en la prueba. No garantizo puntajes ni nombramientos. Sobre la prueba: según las respuestas oficiales de la CNSC al proyecto de acuerdo (septiembre de 2026), la prueba de aptitudes y competencias básicas valora conocimientos disciplinares y pedagógicos, lectura crítica, razonamiento cuantitativo y competencias blandas orientadas al ejercicio del empleo. Los documentos que consulté no usan la etiqueta «juicio situacional»; si la convocatoria definitiva incluye preguntas basadas en situaciones, este método aplica. Verifica la estructura en el acuerdo definitivo. Fecha de la última verificación: 9 de octubre de 2026.</p>
<p class="notice"><strong>En resumen.</strong> Para resolver un caso: 1) interpreta el contexto, 2) identifica el problema real, 3) reconoce actores y derechos, 4) ubica el marco aplicable, 5) decide con una acción proporcional y justifícala. Desconfía de las opciones extremas (castigar sin proceso, ignorar, delegar todo) y de las que «suenan bien» pero omiten una obligación del marco.</p>

<h2>El método en cinco pasos</h2>
{{img:metodo}}
<ol>
<li><strong>Contexto:</strong> ¿quién, qué, dónde, desde cuándo y con qué frecuencia? Un hecho aislado y uno repetido se tratan distinto.</li>
<li><strong>Problema real:</strong> distingue el síntoma del problema. «Un estudiante no entrega tareas» puede ser un problema de aprendizaje, de salud, de acoso o de contexto familiar.</li>
<li><strong>Actores y derechos:</strong> estudiantes, familias, docentes, directivos. Pregúntate qué derecho está en juego (protección, educación, debido proceso, participación) y quién es el más vulnerable.</li>
<li><strong>Marco aplicable:</strong> manual de convivencia, ruta de atención, plan de ajustes, sistema de evaluación, gobierno escolar. La mejor respuesta es la que respeta el procedimiento previsto, no la que «parece justa» al margen de él.</li>
<li><strong>Decisión proporcional y justificada:</strong> una acción concreta, gradual y documentada, con responsables y seguimiento.</li>
</ol>
<p>Y una regla de lectura de las opciones: descarta primero la <strong>absolutista</strong> (siempre sancionar, nunca intervenir), la que <strong>delega sin responsabilidad</strong> («que lo resuelvan entre ellos»), la <strong>pasiva</strong> («esperar a ver qué pasa») y la que <strong>ignora un procedimiento obligatorio</strong>.</p>

<h2>Caso 1: convivencia (ciberacoso)</h2>
<p>En el grupo de WhatsApp del curso 8.°B, varios estudiantes humillan de forma repetida a una compañera con memes y mensajes. La madre de la afectada pide la expulsión de los agresores; algunos padres dicen que «eso pasó fuera del colegio». Eres el docente que se entera. ¿Qué haces primero?</p>
<ul>
<li><strong>A.</strong> Suspender de inmediato a los estudiantes señalados.</li>
<li><strong>B.</strong> Reunir al grupo para que lo resuelvan entre ellos.</li>
<li><strong>C.</strong> Proteger a la estudiante, registrar el caso y activar la ruta de atención integral: informar a las familias y remitirlo al comité de convivencia escolar para definir medidas pedagógicas y de restauración.</li>
<li><strong>D.</strong> No intervenir porque ocurrió fuera del horario escolar.</li>
</ul>
<p><strong>Respuesta fundamentada: C.</strong> La Ley 1620 de 2013 (Sistema Nacional de Convivencia Escolar), reglamentada por el Decreto 1965 de 2013 (hoy compilado en el Decreto 1075 de 2015), establece una <em>ruta de atención integral</em> con clasificación de situaciones (tipo I, II y III), protección de la víctima, información a las familias y participación del comité de convivencia; el ciberacoso repetido involucra a estudiantes del mismo establecimiento y se atiende por esa ruta. <strong>Por qué las otras fallan:</strong> A parece firme pero se salta el debido proceso del manual de convivencia y la ruta; B parece «restaurativa» pero deja sin protección a la víctima y delega en los estudiantes lo que es una responsabilidad institucional; D ignora que el daño afecta la convivencia escolar aunque ocurra en línea.</p>

<h2>Caso 2: inclusión (evaluación de un estudiante con discapacidad)</h2>
<p>En 6.° hay un estudiante con diagnóstico de discapacidad intelectual leve. Su familia pide «que lo pasen sin exigirle» y otro docente propone aplicarle el mismo examen que al resto «para ser equitativos». ¿Cuál es la mejor decisión?</p>
<ul>
<li><strong>A.</strong> Aplicar el mismo examen sin cambios.</li>
<li><strong>B.</strong> Promoverlo sin evaluar sus aprendizajes.</li>
<li><strong>C.</strong> Elaborar con la familia y el equipo un Plan Individual de Ajustes Razonables (PIAR), aplicar principios de diseño universal para el aprendizaje y evaluar con ajustes que mantengan las competencias esenciales, documentando el proceso.</li>
<li><strong>D.</strong> Remitirlo a una institución especial.</li>
</ul>
<p><strong>Respuesta fundamentada: C.</strong> El Decreto 1421 de 2017 reglamenta la educación inclusiva para población con discapacidad, e incorpora el diseño universal para el aprendizaje, los ajustes razonables y el PIAR como herramienta de planeación y evaluación. <strong>Por qué las otras fallan:</strong> A confunde igualdad con equidad (el mismo examen puede ser una barrera); B «protege» pero renuncia a la enseñanza y a la evaluación, lo que perjudica al estudiante; D contradice el principio de inclusión en la escuela regular. Si trabajas con ajustes razonables, te puede servir <a href="/herramientas/piar/">PIAR con IA</a> como apoyo para redactar borradores (siempre con validación del equipo).</p>

<h2>Caso 3: evaluación (una nota en discusión)</h2>
<p>Un estudiante termina el periodo con 2,8 en Matemáticas, pero mejoró mucho en el último mes. Su padre pide que le «suban la nota» porque se esforzó. El sistema institucional de evaluación del colegio establece criterios y un plan de apoyo para quienes no superan el desempeño básico. ¿Qué haces?</p>
<ul>
<li><strong>A.</strong> Subir la nota a 3,0 por el esfuerzo.</li>
<li><strong>B.</strong> Mantener la nota y no dar más explicaciones.</li>
<li><strong>C.</strong> Aplicar los criterios del SIEE tal como están, explicar al padre y al estudiante cómo se obtuvo la nota, ofrecer el plan de apoyo o actividades de recuperación que prevé el sistema y dejar constancia.</li>
<li><strong>D.</strong> Que el estudiante repita el curso automáticamente.</li>
</ul>
<p><strong>Respuesta fundamentada: C.</strong> Según el Decreto 1290 de 2009 (compilado en el Decreto 1075 de 2015), cada colegio define su sistema institucional de evaluación con criterios, escala y reglas de promoción, y esos criterios son los que orientan y limitan la decisión del docente; además, existen instancias de reclamación. <strong>Por qué las otras fallan:</strong> A parece empática pero rompe la coherencia y la igualdad entre estudiantes; B incumple el deber de explicar y de ofrecer apoyo; D ignora que la promoción se decide con los criterios del sistema y no de forma automática. (Profundizo en cómo revisar estos criterios en <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">el artículo sobre qué miden las calificaciones</a>).</p>

<h2>Caso 4: gestión escolar (cambio de reglas tras un incidente)</h2>
<p>Tras una pelea grave en el patio, el rector quiere endurecer de inmediato las sanciones del manual de convivencia y aplicarlas a los estudiantes involucrados. Algunos docentes dicen que no hace falta consultar a nadie «por urgencia». ¿Qué corresponde?</p>
<ul>
<li><strong>A.</strong> Modificar el manual por resolución rectoral y aplicarlo ya.</li>
<li><strong>B.</strong> No modificar nada y aplicar la sanción que cada docente considere.</li>
<li><strong>C.</strong> Atender el caso con el procedimiento vigente (ruta y debido proceso) y, si se requiere un ajuste al manual, tramitarlo con participación de la comunidad educativa y las instancias del gobierno escolar, para que rija hacia adelante.</li>
<li><strong>D.</strong> Esperar a fin de año para tratar el tema.</li>
</ul>
<p><strong>Respuesta fundamentada: C.</strong> La Ley 115 de 1994 exige que cada establecimiento tenga un manual de convivencia que defina derechos y obligaciones, y la Ley 1620 de 2013 pide que incorpore la ruta de atención y se construya con participación de la comunidad educativa; los cambios se tramitan por esas instancias (por ejemplo, el consejo directivo). <strong>Por qué las otras fallan:</strong> A decide de forma unilateral y aplica una regla nueva a un hecho pasado (afecta el debido proceso); B deja la sanción a la discrecionalidad de cada docente; D es pasiva y deja la situación sin respuesta. Verifica siempre el texto vigente de cada norma: este análisis es general.</p>

<h2>Ficha para analizar cualquier caso</h2>
<p>Este es el recurso aplicable. Úsala con cada ejercicio de práctica y compara tu razonamiento con la respuesta fundamentada:</p>
<table>
<thead><tr><th>Paso</th><th>Pregunta</th><th>Tu respuesta</th></tr></thead>
<tbody>
<tr><td><strong>1. Contexto</strong></td><td>¿Quién, qué, dónde y con qué frecuencia? ¿Hay riesgo inmediato?</td><td></td></tr>
<tr><td><strong>2. Problema</strong></td><td>¿Cuál es el problema de fondo (no solo el síntoma)?</td><td></td></tr>
<tr><td><strong>3. Actores y derechos</strong></td><td>¿Qué derechos están en juego y quién es el más vulnerable?</td><td></td></tr>
<tr><td><strong>4. Marco</strong></td><td>¿Qué norma o procedimiento aplica (manual, ruta, plan, sistema)?</td><td></td></tr>
<tr><td><strong>5. Decisión</strong></td><td>¿Cuál es la primera acción, proporcional y documentada? ¿Quién hace seguimiento?</td><td></td></tr>
<tr><td><strong>6. Descarte</strong></td><td>¿Por qué fallan las otras opciones (absolutista, delegar, pasiva, ignora el procedimiento)?</td><td></td></tr>
</tbody>
</table>

<h2>Cómo practicar con método</h2>
<p>Resuelve primero cada ejercicio sin mirar la respuesta, escribe tu razonamiento con los seis pasos y solo después compáralo. Lo que más enseña no es acertar, sino ver <strong>por qué fallan las opciones que te tentaron</strong>. Para entrenar el formato, usa el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito del Concurso Docente</a>: son preguntas de práctica, no oficiales, y te permiten identificar debilidades. Si tu punto débil es la parte cuantitativa, el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">Curso de Aptitud Matemática</a> fue pensado para el concurso anterior: úsalo como práctica y compáralo con el anexo técnico definitivo. También te sirven <a href="/20-preguntas-frecuentes-sobre-el-concurso-docente/">las 20 preguntas frecuentes</a> y la <a href="/entrevista-del-concurso-docente-2026-docentes-preescolar-basica-media-todas-las-areas/">guía de la entrevista</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}

<h2>Preguntas frecuentes</h2>
<h3>¿La prueba del Concurso Docente tiene preguntas de juicio situacional?</h3>
<p>Los documentos oficiales que consulté (septiembre de 2026) describen la prueba de aptitudes y competencias básicas con conocimientos disciplinares y pedagógicos, lectura crítica, razonamiento cuantitativo y competencias blandas; no usan la etiqueta «juicio situacional». Revisa la estructura en el acuerdo definitivo y el anexo técnico.</p>
<h3>¿Estos casos son preguntas oficiales?</h3>
<p>No. Son ejercicios de práctica elaborados para este artículo. Ninguna fuente oficial los respalda como preguntas del concurso.</p>
<h3>¿Cómo sé cuál es la respuesta correcta si todas parecen razonables?</h3>
<p>Descarta las extremas (castigar sin proceso, ignorar), las que delegan sin responsabilidad y las pasivas; luego elige la que respeta el procedimiento previsto, protege al más vulnerable y es proporcional y documentada.</p>
<h3>¿Debo memorizar las leyes?</h3>
<p>Conviene entender qué problema resuelve cada norma y cuándo aplica, más que memorizar artículos. Un mapa que relacione tema, norma y aplicación práctica te ayuda más.</p>
<h3>¿Estudiar casos garantiza un buen puntaje?</h3>
<p>No hay garantías. Practicar con método mejora tu razonamiento, pero el resultado depende de la prueba oficial y de muchos factores.</p>

<p class="notice"><strong>Resuelve un ejercicio hoy.</strong> Toma uno de los casos, anota tu razonamiento con la ficha de seis pasos y compáralo con la respuesta fundamentada. Luego entrena con el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito</a> y revisa en qué opciones caíste. Este artículo se actualizará con las reglas definitivas.</p>

<h2>Para pensar</h2>
<p>Las pruebas de casos premian a quien aplica el procedimiento previsto, pero muchos dilemas reales del aula no caben en un procedimiento. <strong>¿Queremos docentes que sepan seguir la ruta correcta o docentes que sepan cuándo la ruta no alcanza, y cómo podría un concurso medir lo segundo sin premiar solo a quien mejor adivina lo que el evaluador espera?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:metodo}}' => $img('concurso-juicio-situacional-metodo', 467, 'Cinco pasos para analizar un caso: contexto, problema real, actores y derechos, marco aplicable y decisión proporcional y justificada.', 'Método de cinco pasos para analizar un caso.'),
]);

return [
    'slug' => 'concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas',
    'title' => 'Juicio situacional en el Concurso Docente: cómo analizar un caso sin caer en respuestas aparentemente correctas',
    'excerpt' => 'Un método de cinco pasos y cuatro casos de práctica (convivencia, inclusión, evaluación y gestión escolar) resueltos con el marco aplicable, para analizar situaciones sin caer en respuestas aparentemente correctas.',
    'seo_title' => 'Concurso Docente: cómo analizar casos situacionales',
    'seo_description' => 'Método de cinco pasos y cuatro casos de práctica resueltos (convivencia, inclusión, evaluación y gestión) para analizar situaciones en el Concurso Docente.',
    'focus_keyword' => 'juicio situacional Concurso Docente',
    'cover' => '/assets/img/articulos/concurso-juicio-situacional/concurso-juicio-situacional-portada',
    'cover_alt' => 'Portada «Juicio situacional en el Concurso Docente: cómo analizar un caso sin caer en respuestas aparentemente correctas» con los cuatro ámbitos de los casos: convivencia, inclusión, evaluación y gestión escolar.',
    'published_at' => '2026-11-06 12:00:00',
    'content_html' => $html,
];
