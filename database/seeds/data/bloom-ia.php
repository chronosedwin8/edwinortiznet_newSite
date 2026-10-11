<?php

declare(strict_types=1);

// "Actividades con IA por nivel de Bloom". Fuentes (10-oct-2026): Anderson y Krathwohl 2001; Krathwohl 2002 TIP 41(4) 212-218 (Crossref); críticas: Frontiers in Education 2020 (feduc.2020.00107) y CBE-LSE 2022 (cbe.20-08-0170), vía resúmenes; Dunlosky et al. 2013 (práctica de recuperación); AIAS v1 de Furze. Libro verificado en Excel 16 y Python: banco de 36 actividades, plan de 8 (RE1, CO4, AP1, AP3, AN2, AN6, EV2, CR6): 205 min, 6 niveles cubiertos, 125 min (61 %) de orden superior, 1 de riesgo alto, 4 con IA nivel 4-5.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/bloom-ia/' . $name;
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
<p>Es domingo por la noche y estás planeando la semana. En la pared de la sala de profesores hay un afiche con la taxonomía de Bloom: una pirámide con verbos de colores. Sabes que deberías diseñar actividades que lleguen a "analizar", "evaluar" y "crear", y no solo a "recordar". Abres diez pestañas, buscas "actividades de Bloom para ciencias", encuentras listas genéricas y a las once de la noche sigues con el mismo ejercicio de siempre. <strong>Usar Bloom no debería significar pasar horas buscando ideas.</strong> Y la inteligencia artificial, bien usada, puede ahorrar justo ese tiempo, siempre que la decisión pedagógica siga siendo tuya.</p>
<p>Este artículo hace tres cosas. Primero, explica con rigor qué es (y qué no es) la taxonomía de Bloom revisada. Segundo, ofrece un <strong>banco de 36 actividades con IA</strong>, seis por cada nivel, cada una con lo que hace la IA, lo que hace el estudiante, los minutos, el rol de la IA, el nivel de uso de IA según la escala por tarea (ver <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a>), el riesgo y la evidencia que deja. Tercero, entrega seis <strong>plantillas de prompts</strong> y un <a href="/descargas/bloom-ia/banco-bloom-actividades-con-ia.xlsx">libro de Excel</a> con el banco, un planificador de unidad que cuenta la cobertura por nivel y los minutos de orden superior, verificado en Microsoft Excel 16 y contra un cálculo independiente. Fuentes revisadas el <strong>10 de octubre de 2026</strong>.</p>
<p class="notice"><strong>Advertencia.</strong> Las actividades son propuestas de diseño, no un currículo: ajústalas a tu área, tu grupo y tu SIEE. La IA puede equivocarse y producir material con errores: <strong>revisa todo lo que genere antes de usarlo con estudiantes</strong> y no ingreses datos personales de menores. Los datos del planificador son un ejemplo.</p>

<h2>Qué es la taxonomía de Bloom (y qué no es)</h2>
{{img:niveles}}
<p>En 1956, un grupo de examinadores universitarios dirigido por Benjamin Bloom propuso una clasificación de objetivos educativos del dominio cognitivo. En 2001, Lorin Anderson y David Krathwohl publicaron una revisión (resumida por Krathwohl en 2002, <em>Theory Into Practice</em>, 41(4), 212-218) que cambió los sustantivos por verbos y reordenó los niveles: <strong>recordar, comprender, aplicar, analizar, evaluar y crear</strong> (en la versión original, "síntesis" quedaba antes de "evaluación"). Es una herramienta de diseño: sirve para preguntarse, al planear, <em>qué tipo de pensamiento pide esta actividad</em>.</p>
<p>Conviene conocer sus límites, que la propia literatura señala:</p>
<ul>
<li><strong>No es una jerarquía estricta.</strong> Revisiones críticas (por ejemplo, un artículo de <em>Frontiers in Education</em> de 2020 y otro de <em>CBE-Life Sciences Education</em> de 2022) recuerdan que la evidencia empírica sobre su estructura jerárquica acumulativa es débil y que la comprensión puede surgir del análisis y de la aplicación, no solo precederlos. La mayoría de las tareas complejas combina varios niveles.</li>
<li><strong>"Más alto" no significa "mejor".</strong> Recordar no es un nivel menor: la práctica de recuperación (autoexamen, tarjetas) es una de las técnicas de estudio con mayor utilidad según la revisión de Dunlosky y colegas de 2013 (ver <a href="/aprender-a-aprender-calibracion-tecnicas-de-estudio-repaso-espaciado-libro-excel/">aprender a aprender</a>). Una buena unidad usa todos los niveles.</li>
<li><strong>Los verbos son ambiguos.</strong> "Analizar" puede ser una tarea profunda o un ejercicio mecánico según el contenido y las instrucciones; lo que cuenta es lo que el estudiante hace.</li>
<li><strong>No es una norma colombiana.</strong> Los referentes de la planeación son los Estándares Básicos de Competencias, los Derechos Básicos de Aprendizaje, el PEI y el SIEE; Bloom ayuda a diseñar, no sustituye esos marcos.</li>
</ul>

<h2>Qué puede hacer la IA aquí (y qué no)</h2>
<p>La IA es buena generando <em>borradores de material</em> en segundos: preguntas de práctica, ejemplos y no ejemplos, variantes de un ejercicio, contextos cercanos al estudiante, textos con errores deliberados para detectarlos. Es mala como juez de calidad: puede producir ejercicios mal planteados, preguntas con dos respuestas correctas, datos inventados o "hechos" falsos. Por eso la regla es esta: <strong>la IA propone, tú decides y verificas</strong>. Y una segunda regla, que viene de la evidencia (ver la guía): en las actividades donde el estudiante usa la IA, que sea más <em>tutor que pregunta</em> o <em>objeto de análisis</em> que <em>solucionador</em>. Por eso el banco incluye el <em>rol de la IA</em> y el <em>nivel de uso de IA</em> de cada actividad.</p>

<h2>Cómo preparar una actividad en minutos</h2>
{{img:pasos}}
<p>El método cabe en cinco pasos: decide <strong>qué nivel de Bloom</strong> buscas, elige una actividad del banco, fija <strong>cuánta IA</strong> admite (según la escala de la guía), pide el material con un prompt y <strong>revísalo</strong> y define qué <strong>evidencia</strong> dejará el proceso. Con el banco y las plantillas, preparar una actividad pasa de una hora a unos minutos más la revisión.</p>
<h2>El banco: seis actividades por nivel</h2>
<p>El libro completo tiene las 36 con sus detalles. Aquí, algunas de cada nivel (los minutos son una estimación para un grupo típico):</p>
<h3>Recordar</h3>
<ul>
<li><strong>Práctica de recuperación con tarjetas (15 min).</strong> La IA genera 20 preguntas de práctica a partir de los apuntes del estudiante; él responde sin mirar y repite lo fallado.</li>
<li><strong>Quiz en variantes equivalentes (10 min).</strong> La docente crea con IA tres versiones del mismo quiz y lo aplica en clase sin IA.</li>
<li><strong>Calendario de repasos espaciados (15 min).</strong> La IA arma el calendario antes de la evaluación; el estudiante lo ajusta y lo cumple.</li>
</ul>
<h3>Comprender</h3>
<ul>
<li><strong>Explícaselo a un niño de 10 años (20 min).</strong> La IA hace de niño que pregunta; el estudiante explica con sus palabras.</li>
<li><strong>Mi resumen frente al de la IA (25 min).</strong> El estudiante escribe el suyo primero y compara qué se perdió en cada uno.</li>
<li><strong>Ejemplos y no ejemplos (20 min).</strong> La IA da tres y tres; el estudiante clasifica y justifica.</li>
</ul>
<h3>Aplicar</h3>
<ul>
<li><strong>Problemas con contexto local (25 min).</strong> La IA genera problemas con contextos de la región; la docente los revisa antes de usarlos.</li>
<li><strong>Ejercicios graduados con pistas (20 min).</strong> Cinco ejercicios de dificultad creciente y pistas escalonadas que el estudiante usa solo si las necesita.</li>
<li><strong>Predicciones antes del experimento (30 min).</strong> La IA pide que prediga el resultado antes de hacerlo y compara después.</li>
</ul>
<h3>Analizar</h3>
<ul>
<li><strong>Encuentra el error (25 min).</strong> La IA redacta una explicación con tres errores sutiles (la docente la revisa antes); los estudiantes los encuentran.</li>
<li><strong>Verifica las fuentes (30 min).</strong> La IA lista fuentes para una afirmación; el estudiante comprueba cuáles existen y qué dicen realmente (una forma de enseñar el riesgo de las "alucinaciones").</li>
<li><strong>La gráfica que distorsiona (25 min).</strong> Tres gráficas del mismo conjunto de datos; el estudiante decide cuál distorsiona.</li>
</ul>
<h3>Evaluar</h3>
<ul>
<li><strong>Jueces con rúbrica (25 min).</strong> El estudiante califica una respuesta generada por la IA con una rúbrica y justifica.</li>
<li><strong>Retroalimentación sobre mi borrador (25 min).</strong> La IA comenta; el estudiante decide qué acepta y por qué, y lo registra en una bitácora.</li>
<li><strong>¿Es fiel el resumen? (25 min).</strong> Contrasta un resumen de la IA con el texto original.</li>
</ul>
<h3>Crear</h3>
<ul>
<li><strong>Un examen para los compañeros (40 min).</strong> Los estudiantes diseñan preguntas y clave; la IA revisa la claridad.</li>
<li><strong>Un tutor que no da la respuesta (45 min).</strong> Diseñan un prompt que enseñe sin resolver y lo prueban; es de riesgo alto porque exige criterio para no entregar la solución.</li>
<li><strong>Proyecto con bitácora de prompts (45 min).</strong> La IA asiste en tareas acotadas y el estudiante documenta cada uso.</li>
</ul>

<h2>Seis plantillas de prompts (para pedir el material en un minuto)</h2>
<p>Copia, cambia lo que está entre corchetes y revisa el resultado. Evita pegar datos de estudiantes y verifica los contenidos:</p>
<pre><code>1. Recordar: "Crea 15 preguntas de práctica de recuperación sobre [tema] para [grado], de respuesta corta, con la respuesta correcta al final. Evita preguntas que se contesten con sí o no."

2. Comprender: "Actúa como un niño de 10 años curioso. Hazme preguntas, una por vez, sobre [concepto], y pídeme que lo explique de otra forma si no entiendes."

3. Aplicar: "Crea 5 problemas de [tema] con un contexto de [región o situación], de dificultad creciente, y para cada uno dos pistas escalonadas. No des la solución completa."

4. Analizar: "Escribe una explicación de [tema] para [grado] con exactamente 3 errores sutiles. Entrégame aparte una lista de los errores y de su corrección."

5. Evaluar: "Genera una respuesta de nivel [medio] a esta pregunta: [pregunta]. Después, propón una rúbrica de 4 criterios para evaluarla."

6. Crear: "Ayúdame a revisar la claridad de estas 8 preguntas de examen que redacté: [preguntas]. Señala ambigüedades, pero no las reescribas."</code></pre>

<h2>El libro de Excel: banco y planificador</h2>
<ul>
<li><strong>Niveles:</strong> los seis niveles con verbos típicos, pregunta guía y si cuentan como pensamiento de orden superior (analizar, evaluar y crear).</li>
<li><strong>Banco:</strong> las 36 actividades, con filtros por nivel, rol de la IA, nivel de uso de IA y riesgo.</li>
<li><strong>Plan:</strong> escribes los ID de las actividades que elegiste para una unidad (hasta 15) y el libro trae el nivel, los minutos, el nivel de uso de IA y el riesgo.</li>
<li><strong>Resumen:</strong> cuántas actividades hay por nivel, qué niveles faltan, los minutos y el porcentaje de orden superior, las de riesgo alto y las de uso de IA de nivel 4 o 5.</li>
</ul>
<pre><code>' Traer los minutos de una actividad por su ID (ID en B4, banco en A:F)
=SI(B4="";"";INDICE(Banco!$F$4:$F$39;COINCIDIR(B4;Banco!$A$4:$A$39;0)))     ' español
=IF(B4="","",INDEX(Banco!$F$4:$F$39,MATCH(B4,Banco!$A$4:$A$39,0)))           ' inglés

' Minutos de orden superior y su porcentaje
=SUMAR.SI(Plan!H4:H18;"Sí";Plan!E4:E18)       ' español
=SUMIF(Plan!H4:H18,"Sí",Plan!E4:E18)           ' inglés
=B13/B5</code></pre>
{{img:plan}}
<p>Con el <strong>plan de ejemplo de 8 actividades</strong> (RE1, CO4, AP1, AP3, AN2, AN6, EV2 y CR6): 205 minutos en total; una actividad de recordar, una de comprender, dos de aplicar, dos de analizar, una de evaluar y una de crear, es decir, <strong>los seis niveles cubiertos</strong>; 125 minutos (<strong>61 %</strong>) en orden superior; <strong>1 actividad de riesgo alto</strong> (la del tutor que no da la respuesta) y <strong>4 con uso de IA de nivel 4 o 5</strong>, que conviene revisar con la matriz de uso de IA por tarea. <strong>Una lectura honesta:</strong> el porcentaje de orden superior no es una meta (más no es mejor), solo un espejo: si tu unidad tiene 90 % de recordar o 90 % de crear, vale la pena preguntarse por qué.</p>

<h2>Siete errores frecuentes</h2>
<ol>
<li><strong>Convertir Bloom en una lista de verbos</strong> y cambiar el verbo del enunciado sin cambiar lo que el estudiante hace.</li>
<li><strong>Creer que arriba es mejor</strong> y abandonar la práctica de recuperación.</li>
<li><strong>Usar el material de la IA sin revisarlo.</strong></li>
<li><strong>Dejar que el estudiante use la IA como solucionador</strong> en actividades que buscan comprensión.</li>
<li><strong>No fijar el nivel de uso de IA</strong> de la actividad ni pedir que se declare.</li>
<li><strong>Copiar actividades sin adaptarlas</strong> al área, al grupo y al contexto.</li>
<li><strong>No dejar evidencia del proceso</strong> (bitácora, borradores, predicciones), que es lo que permite evaluar y protege contra la suplantación.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, la planeación de aula se articula con los Estándares Básicos de Competencias, los Derechos Básicos de Aprendizaje, las mallas del PEI y el Sistema Institucional de Evaluación (ver <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE y el Decreto 1290</a>); Bloom se usa mucho en la formación de docentes y en el diseño de objetivos, aunque no es parte de la norma. La Ley 2626 de 2026 incorpora la IA en la asignatura de tecnología e informática, y exigirá formación docente, una oportunidad para integrar estas actividades. En el mundo, la taxonomía de Bloom y sus versiones se enseñan en la formación docente de muchos países, y se debate su vigencia frente a enfoques más nuevos; el consenso práctico es usarla como una guía flexible, no como un dogma.</p>
<p>Para los <strong>docentes</strong>, el reto es tiempo: un banco y plantillas lo reducen; para los <strong>directivos</strong>, acordar criterios de uso de IA y revisar la cobertura por nivel en las planeaciones; para las <strong>familias</strong>, entender que un estudiante que "usó IA" en una actividad puede estar practicando analizar o evaluar, no copiando; y para los <strong>estudiantes</strong>, que lo que cuenta es lo que hacen con la IA, no que la IA lo haga por ellos.</p>

<h2>Herramientas y plantillas</h2>
<p>Estas herramientas propias ayudan a convertir un tema en material de aula con revisión humana (sin ingresar datos de estudiantes):</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/descargas/bloom-ia/banco-bloom-actividades-con-ia.xlsx">el libro del banco y planificador</a>, <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (10 de octubre de 2026)</h2>
<ul>
<li><strong>Anderson y Krathwohl (eds., 2001),</strong> <em>A Taxonomy for Learning, Teaching, and Assessing: A Revision of Bloom's Taxonomy of Educational Objectives</em>; <strong>Krathwohl (2002),</strong> "A Revision of Bloom's Taxonomy: An Overview", <em>Theory Into Practice</em> 41(4), 212-218.</li>
<li>Críticas y revisiones: <a href="https://www.frontiersin.org/journals/education/articles/10.3389/feduc.2020.00107/pdf">Frontiers in Education (2020)</a> y <a href="https://www.lifescied.org/doi/10.1187/cbe.20-08-0170">CBE-Life Sciences Education (2022)</a> (leí sus resúmenes en la búsqueda; revisa los artículos para citarlos).</li>
<li><strong>Dunlosky, Rawson, Marsh, Nathan y Willingham (2013),</strong> <em>Psychological Science in the Public Interest</em> 14(1), 4-58 (utilidad de la práctica de recuperación); escala de uso de IA por tarea de <strong>Furze, Perkins, Roe y MacVaugh,</strong> en <a href="https://leonfurze.com/2023/12/18/the-ai-assessment-scale-version-1/">su primera versión</a>.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la taxonomía de Bloom revisada?</h3>
<p>Una clasificación de procesos cognitivos en seis niveles (recordar, comprender, aplicar, analizar, evaluar y crear) para diseñar objetivos y actividades, revisada por Anderson y Krathwohl en 2001.</p>
<h3>¿Hay que usar todos los niveles en cada clase?</h3>
<p>No necesariamente; conviene que una unidad los cubra de forma coherente con sus objetivos.</p>
<h3>¿Puede la IA diseñar mis actividades?</h3>
<p>Puede proponer borradores, pero la decisión pedagógica y la verificación son tuyas.</p>
<h3>¿Qué hago para que los estudiantes no copien con IA?</h3>
<p>Fija el nivel de uso de IA de la actividad, pide que lo declaren, deja evidencia del proceso y prefiere actividades donde la IA sea tutor u objeto de análisis, no solucionador.</p>
<h3>¿Cómo uso el libro?</h3>
<p>Filtra el banco por nivel, elige actividades, escribe sus ID en la hoja Plan y mira la cobertura, los minutos y los riesgos.</p>

<p class="notice"><strong>Arma tu próxima unidad.</strong> Descarga el <a href="/descargas/bloom-ia/banco-bloom-actividades-con-ia.xlsx">libro del banco y planificador</a>, elige ocho actividades y mira si cubres los seis niveles.</p>

<h2>Para pensar</h2>
<p>La taxonomía de Bloom nos recuerda que no todo aprendizaje es repetir, pero también que repetir tiene su lugar. <strong>¿En qué nivel de Bloom pasan hoy la mayor parte del tiempo tus estudiantes, y por qué? Y si la IA te devolviera horas de preparación, ¿en qué actividad de tu clase las invertirías para que lo que ocurra en el aula sea más humano y no menos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:niveles}}' => $img('bloom-ia-niveles', 608, 'Tabla con los seis niveles de la taxonomía de Bloom revisada, sus verbos típicos y su pregunta guía: recordar, comprender, aplicar, analizar, evaluar y crear.', 'Seis niveles, seis preguntas guía.'),
    '{{img:pasos}}' => $img('bloom-ia-pasos', 467, 'Cinco pasos para preparar una actividad con IA: objetivo, actividad, uso de IA, material y evidencia.', 'Cinco pasos para preparar la actividad en minutos.'),
    '{{img:plan}}' => $img('bloom-ia-plan', 524, 'Gráfico de barras con los minutos por nivel de Bloom en un plan de ejemplo de 205 minutos: recordar 15, comprender 20, aplicar 45, analizar 55, evaluar 25 y crear 45.', 'Un plan de ejemplo: 61 % del tiempo en orden superior.'),
]);

return [
    'slug' => 'actividades-con-ia-taxonomia-de-bloom-banco-36-actividades-prompts-planificador-excel',
    'title' => 'Actividades con IA para cada nivel de la taxonomía de Bloom: un banco de 36, seis prompts y un planificador en Excel para no pasar horas buscando ideas',
    'excerpt' => 'Qué es (y qué no es) la taxonomía de Bloom revisada y 36 actividades con IA, seis por nivel, con el rol de la IA, los minutos, el riesgo y la evidencia; seis plantillas de prompts y un planificador en Excel que cuenta la cobertura por nivel.',
    'seo_title' => 'Actividades con IA para cada nivel de Bloom',
    'seo_description' => '36 actividades con IA para los seis niveles de Bloom, con prompts, riesgos y evidencia, y un planificador en Excel para cubrir todos los niveles de tu unidad.',
    'focus_keyword' => 'actividades con IA taxonomía de Bloom',
    'cover' => '/assets/img/articulos/bloom-ia/bloom-ia-portada',
    'cover_alt' => 'Portada "Actividades con IA para cada nivel de Bloom, sin pasar horas buscando ideas" con una tarjeta: 36 actividades, seis por cada nivel de la taxonomía de Bloom revisada, con rol de la IA y evidencia.',
    'published_at' => '2027-03-10 12:00:00',
    'content_html' => $html,
];
