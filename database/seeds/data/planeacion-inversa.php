<?php

declare(strict_types=1);

// "Planeación inversa". Fuentes consultadas el 10-oct-2026: Wiggins y McTighe (Understanding by Design, 1998); resumen de investigación de McTighe y metasíntesis de Uluçınar (2021), señalando que gran parte de la evidencia viene de autores del marco; MEN/Colombia Aprende sobre DBA (2015; v2 2016, U. de Antioquia) y análisis académico de Gómez y Velazco (2017) sobre documentos preliminares. Plantilla verificada en Excel 16: 3 de 5 alineados, 1 actividad huérfana.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/planeacion-inversa/' . $name;
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
<p>Es domingo por la noche y toca planear la semana. Muchos docentes abrimos el libro de texto, vemos el siguiente tema y pensamos en actividades que lo cubran: una lectura, un taller, un video, un quiz. Al final del periodo viene la prueba. Y ahí aparece el problema: <strong>algunas de las preguntas evalúan algo que nunca practicamos, y algunas de las cosas que más trabajamos no aparecen en ninguna evaluación</strong>.</p>
<p>La planeación inversa propone cambiar el orden: empezar por lo que se quiere que los estudiantes comprendan y puedan hacer, definir cómo se sabrá que lo lograron y solo entonces diseñar las actividades. Este artículo explica el marco y ofrece una <a href="/descargas/planeacion-inversa/planeacion-inversa-alineacion.xlsx">plantilla de Excel</a> con las tres etapas y una hoja que <strong>revisa automáticamente la alineación</strong> entre resultados, evidencias y actividades. Se verificó en Microsoft Excel 16 con un ejemplo ficticio. Datos y fuentes revisados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> El marco es una herramienta de planeación, no una receta única, y la evidencia de su efecto es todavía limitada (se explica abajo). La unidad del ejemplo es ficticia. La forma de calificar y los criterios de promoción los define el sistema institucional de evaluación (SIEE) de cada colegio, y los referentes curriculares (estándares, DBA, mallas) deben consultarse en las fuentes oficiales vigentes del Ministerio de Educación Nacional.</p>

<h2>El marco: tres etapas</h2>
<p>El enfoque de "diseño hacia atrás" (<em>backward design</em>) lo sistematizaron Grant Wiggins y Jay McTighe en <em>Understanding by Design</em> (1998; segunda edición, 2005), con antecedentes en la propuesta de Ralph Tyler (1949) de partir de objetivos. Sus tres etapas:</p>
{{img:etapas}}
<ol>
<li><strong>Resultados deseados:</strong> ¿qué deben comprender, saber y poder hacer los estudiantes al terminar? Conviene redactarlos como desempeños observables ("justifica sus procedimientos", no "ve proporcionalidad").</li>
<li><strong>Evidencias aceptables:</strong> ¿qué tendrían que producir o hacer para que yo crea que lo lograron? Puede ser una prueba, pero también un informe, una presentación, una solución justificada.</li>
<li><strong>Experiencias de aprendizaje:</strong> ¿qué actividades llevan a los estudiantes hasta allí? Solo en esta etapa se piensa en talleres, lecturas y proyectos.</li>
</ol>
<p>La plantilla agrega una cuarta revisión, que no es del marco original sino de elaboración propia: <strong>verificar que todo apunte a lo mismo</strong>. John Biggs llamó "alineación constructiva" (<em>constructive alignment</em>) a la idea relacionada de que los resultados, la enseñanza y la evaluación deben estar alineados.</p>

<h2>La plantilla en acción: una unidad de proporcionalidad (ejemplo ficticio)</h2>
<p>La unidad del ejemplo es de proporcionalidad en grado 7, con cinco resultados deseados: reconocer razones y proporciones; resolver problemas de proporcionalidad directa e inversa; interpretar gráficas y tablas de proporcionalidad; justificar procedimientos con argumentos; y usar porcentajes para decidir en contextos de consumo. Se listan cuatro evidencias (una prueba corta, un informe de compra comparativa, un cuaderno de problemas y una autoevaluación escrita) y ocho actividades. En cada hoja se marca con 1 qué resultado cubre cada evidencia y cada actividad, y la hoja <em>Alineacion</em> calcula, resultado por resultado, cuántas evidencias y cuántas actividades tiene:</p>
<ul>
<li><strong>O1, O2 y O5:</strong> alineados (tienen evidencia y actividades).</li>
<li><strong>O3 (interpretar gráficas):</strong> una actividad y <strong>ninguna evidencia</strong>: <em>"Enseñas lo que no evalúas"</em>.</li>
<li><strong>O4 (justificar procedimientos):</strong> dos evidencias y <strong>ninguna actividad</strong>: <em>"Evalúas lo que no enseñas"</em>.</li>
<li>Además, una actividad (el video de cierre) <strong>no desarrolla ningún resultado</strong>: una actividad "huérfana".</li>
</ul>
<p>Resultado: 3 de 5 resultados alineados, 1 actividad huérfana y 0 evidencias huérfanas (cálculos verificados en Excel). Los dos desajustes son típicos, y casi nunca se notan hasta que se ponen en una matriz: el estudiante aprendió a hacer gráficas pero nadie se lo pregunta, y se le pide justificar sin haber practicado a justificar. Una actividad huérfana no es necesariamente mala (puede motivar, cerrar o cuidar la convivencia), pero conviene que sea una decisión consciente y no un hábito.</p>
{{img:formas}}

<h2>Cómo redactar buenos resultados, evidencias y actividades</h2>
<ul>
<li><strong>Resultados:</strong> verbo observable + contenido + condición ("resuelve problemas de proporcionalidad directa e inversa en situaciones cotidianas"). Pocos y significativos: entre tres y seis por unidad.</li>
<li><strong>Evidencias:</strong> más de un tipo (no solo la prueba escrita) y con criterios claros (ver <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a>). Cada resultado importante necesita al menos una evidencia.</li>
<li><strong>Actividades:</strong> cada una debe poder responder "¿para qué resultado?". Si no puede, es candidata a cambiar o a eliminarse.</li>
<li><strong>Distribución del tiempo:</strong> los resultados más difíciles necesitan más actividades y más evidencias; la hoja muestra los conteos para que lo veas.</li>
</ul>

<h2>Lo que dice la evidencia (con honestidad)</h2>
<p>La planeación inversa es popular y lógica, pero su evidencia empírica es más modesta que su fama. Los resúmenes de investigación citados con más frecuencia vienen en parte de los propios autores del marco; hay una metasíntesis cualitativa (Uluçınar, 2021) que reporta mejoras en motivación, compromiso y pensamiento de orden superior, y estudios cuasiexperimentales pequeños en educación superior. Falta, hasta donde pude verificar, evidencia de ensayos controlados aleatorizados de gran escala, y buena parte de los resultados son percepciones de docentes o resultados a nivel de curso, no pruebas estandarizadas. Esas mismas revisiones señalan que el éxito depende de la formación docente y del apoyo continuo, y que se debilita cuando los objetivos son ambiguos. En otras palabras: <strong>es una buena práctica de planeación con respaldo conceptual sólido y evidencia empírica aún en construcción</strong>; pruébala con tus propios datos (ver <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">cómo probar una herramienta educativa en cuatro semanas</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los referentes de resultados vienen del Ministerio de Educación Nacional: los Estándares Básicos de Competencias, los Derechos Básicos de Aprendizaje (DBA, publicados desde 2015; la versión 2 de 2016 se elaboró con la Universidad de Antioquia) y las mallas de aprendizaje que los desarrollan. Un análisis académico de los documentos preliminares de 2016 y 2017 encontró complejidad y algunas incoherencias, un recordatorio de que estos referentes se leen con criterio y no como libreto. Cada colegio, además, tiene su SIEE, que define cómo se evalúa y promueve. La planeación inversa encaja con ese contexto porque obliga a conectar tres capas: el referente nacional (qué), la evidencia (cómo sé) y la actividad (cómo lo trabajo). En la región y en el mundo, el diseño hacia atrás se usa desde la educación básica hasta la universitaria, y sus defensores y críticos coinciden en un punto: sin tiempo para planear, se vuelve un formulario más. Para los <strong>docentes</strong>, el reto es el tiempo; para los <strong>directivos</strong>, dar espacios de planeación colectiva (un resultado compartido entre docentes del mismo grado evita duplicar y contradecir); para las <strong>familias</strong>, saber qué se espera que su hijo logre es más útil que un listado de temas; y para los <strong>estudiantes</strong>, conocer los resultados desde el inicio es una forma de dar sentido a lo que hacen. Ver también <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">calificaciones: aprendizaje o cumplimiento</a> y, para adaptar la planeación a estudiantes con barreras de aprendizaje, <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Herramientas y plantillas</h2>
<p>Para generar evidencias de aprendizaje (preguntas, exámenes con clave y niveles) alineadas con tus resultados, y para organizar tus recursos con IA (siempre revisando lo que produce), mira estas herramientas propias.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">el error matemático que se repite</a>, <a href="/steam-sin-equipos-costosos-proyectos-materiales-cotidianos-plantilla/">STEAM sin equipos costosos</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la planeación inversa?</h3>
<p>Un enfoque que parte de los resultados de aprendizaje deseados, define luego las evidencias de que se lograron y solo después diseña las actividades. Se asocia con Wiggins y McTighe (<em>Understanding by Design</em>, 1998).</p>
<h3>¿Es lo mismo que "planear por objetivos"?</h3>
<p>Se parece, pero pone énfasis en la comprensión y en definir la evidencia antes de las actividades. La idea de partir de objetivos tiene antecedentes en Tyler (1949).</p>
<h3>¿Cómo sé si mi unidad está alineada?</h3>
<p>Verificando que cada resultado importante tenga al menos una evidencia y una actividad, y que cada actividad y cada evidencia sirvan a algún resultado. La plantilla lo calcula.</p>
<h3>¿Hay evidencia de que mejora el aprendizaje?</h3>
<p>Hay reportes positivos, sobre todo cualitativos y de estudios pequeños; la evidencia a gran escala es limitada. Conviene probarlo con tus propios datos.</p>
<h3>¿Sirve para cualquier materia y grado?</h3>
<p>Sí, es un marco general. El ejemplo de la plantilla es de matemáticas, pero la lógica de alinear resultados, evidencias y actividades se aplica en cualquier área.</p>

<p class="notice"><strong>Revisa tu próxima unidad.</strong> Descarga la <a href="/descargas/planeacion-inversa/planeacion-inversa-alineacion.xlsx">plantilla de planeación inversa</a>, escribe los resultados de tu próxima unidad, marca qué evidencias y actividades los cubren y mira qué dice la hoja de alineación.</p>

<h2>Para pensar</h2>
<p>Planear desde la evidencia parece obvio, pero casi nadie lo hace de forma natural: es más cómodo empezar por las actividades que ya conocemos. <strong>¿Cuántas de las actividades que hacemos cada semana podríamos justificar con un resultado concreto? Y cuando descubrimos que enseñamos algo que no evaluamos o evaluamos algo que no enseñamos, ¿qué es más justo con los estudiantes: cambiar la evaluación o cambiar la enseñanza?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:etapas}}' => $img('planeacion-inversa-etapas', 467, 'Cuatro pasos de la planeación inversa: resultados, evidencias, actividades y revisión de alineación.', 'Se planea de atrás hacia adelante.'),
    '{{img:formas}}' => $img('planeacion-inversa-formas', 499, 'Tabla que contrasta planear desde el tema con planear desde el resultado en cuatro aspectos: punto de partida, evaluación, actividades y riesgo.', 'Dos formas de planear.'),
]);

return [
    'slug' => 'planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion',
    'title' => 'Planeación inversa: empezar por lo que quieres que comprendan, con una plantilla que revisa la alineación',
    'excerpt' => 'La planeación inversa en tres etapas (resultados, evidencias, actividades) y una plantilla de Excel que revisa si lo que enseñas y lo que evalúas apuntan a los mismos resultados, con un ejemplo de proporcionalidad.',
    'seo_title' => 'Planeación inversa: plantilla de alineación',
    'seo_description' => 'Cómo planear de atrás hacia adelante: resultados, evidencias y actividades, con una plantilla de Excel que detecta lo que enseñas pero no evalúas.',
    'focus_keyword' => 'planeación inversa',
    'cover' => '/assets/img/articulos/planeacion-inversa/planeacion-inversa-portada',
    'cover_alt' => 'Portada "Planeación inversa: empezar por lo que quieres que comprendan" con una tarjeta: 3 de 5 resultados alineados en la unidad de ejemplo, dos tienen un desajuste.',
    'published_at' => '2027-01-13 12:00:00',
    'content_html' => $html,
];
