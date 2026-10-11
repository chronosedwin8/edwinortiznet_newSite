<?php

declare(strict_types=1);

// "Por qué la escuela sigue pareciéndose a la que conocimos / qué cambiarías". Fuentes (10-oct-2026): Tyack y Tobin 1994 AERJ 31(3) 453-479 (Crossref); Carnegie Foundation y New America (unidad de 120 horas, 1906, criterio de tiempo; ~1910 casi todos); Gold 2002 y Education Next/PBS (calendario ~180 días, creación consciente); Mann visitó Prusia en 1843; crítica del mito del modelo de fábrica (blog, argumento); Cuban 2001; Decreto 1850 (40 semanas; 25/30 h), Ley 115 art. 23 y autonomía, Decreto 1290, Ley 2626 de 2026. Libro verificado en Excel 16 y Python: encuesta ficticia de 60 personas, 10 rasgos; 52 % cambiaría docente para 30+ e inicio temprano (consenso a 30 %), 3 brechas, mayor brecha tareas (55 pts), 2 rasgos >50 %. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/gramatica-escolar/' . $name;
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
<p>Imagina que alguien se durmió en 1996 y despierta hoy. No reconocería casi nada de la calle: ni los teléfonos, ni el dinero, ni la forma de pedir un taxi, ni de buscar un dato. Pero si entra a un colegio, sabría qué hacer: sentarse en un pupitre, esperar a que suene el timbre, pasar de una asignatura a otra cada cuarenta y cinco minutos, entregar tareas, presentar exámenes y recibir una nota. <strong>El mundo cambió por completo; la escuela, en su estructura, casi no.</strong> Y esa es una de las preguntas más incómodas de la educación: ¿por qué?</p>
<p>Este artículo propone una respuesta basada en la historia y la investigación, no en la nostalgia ni en la queja. Explica el concepto de <strong>"gramática de la escuela"</strong>, de dónde vienen sus piezas (los grados por edad, la hora de clase, el calendario, las asignaturas), por qué cuesta tanto cambiarlas, qué <em>sí</em> ha cambiado, qué marca la ley en Colombia y qué margen real hay. Y termina con la pregunta que importa: <strong>¿qué cambiarías tú?</strong> Incluye un <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">libro de Excel</a> para tabular una encuesta a docentes, familias y estudiantes (con datos ficticios de 60 personas), verificado en Microsoft Excel 16 y contra un cálculo independiente. Fuentes revisadas el <strong>10 de octubre de 2026</strong>.</p>
<p class="notice"><strong>Advertencia.</strong> La historia de la escuela se simplifica con facilidad y circulan relatos atractivos que no resisten el examen (ver más abajo). Distingo lo documentado de lo discutido. Los datos de la encuesta del libro son ficticios; no representan a ningún colegio.</p>

<h2>La gramática de la escuela</h2>
<p>En 1994, los historiadores de la educación David Tyack y William Tobin publicaron "The 'Grammar' of Schooling: Why Has It Been So Hard to Change?" (<em>American Educational Research Journal</em>, 31(3), 453-479). Su idea: así como la gramática de una lengua organiza las frases sin que lo pensemos, hay <strong>estructuras y reglas habituales que organizan el trabajo de enseñar</strong> (en sus palabras, prácticas organizativas estandarizadas para dividir el tiempo y el espacio, clasificar a los estudiantes y asignarlos a aulas, y fragmentar el conocimiento en "asignaturas"). Se vuelven tan familiares que a la gente le parecen "la escuela de verdad", y cualquier reforma que las altere se siente como "no es una escuela". Esa es, según los autores, una razón central de por qué tantas reformas se quedan en la superficie: los cambios que no tocan la gramática se absorben; los que la tocan chocan con lo que la comunidad entiende por escuela.</p>
{{img:gramatica}}
<h2>De dónde vienen las piezas</h2>
<ul>
<li><strong>Los grados por edad.</strong> En las escuelas coloniales de Estados Unidos era común enseñar juntos a estudiantes de edades distintas en una sola aula con un solo maestro. La organización por grados se extendió a mediados del siglo XIX, con reformadores como Horace Mann, que visitó Prusia en 1843 y admiró su organización escolar. Es una invención histórica con fecha, no una ley de la naturaleza.</li>
<li><strong>La hora como medida: la unidad Carnegie.</strong> En 1906, la Fundación Carnegie para el Avance de la Enseñanza definió una "unidad" de 120 horas de clase (una hora diaria, cinco días a la semana, durante 24 semanas) para decidir qué instituciones podían participar en su sistema de pensiones para profesores. Su informe de 1906 decía expresamente que el criterio fundamental era <strong>el tiempo dedicado a una materia, no los resultados</strong>. Hacia 1910, casi todas las universidades y colegios de secundaria de Estados Unidos usaban esa medida, y de ahí salió el "crédito" universitario. Hoy su propia fundación discute su retiro.</li>
<li><strong>El calendario.</strong> El historiador Kenneth Gold mostró que la explicación común (las vacaciones largas serían un residuo del mundo agrario) es incompleta: las escuelas rurales tenían dos temporadas cortas, y las urbanas, calendarios largos (en algunos casos más de 240 días); el calendario de unos 180 días con vacaciones de verano fue una <strong>creación consciente</strong> de reformadores de finales del siglo XIX y principios del XX, motivada en parte por la salud y el calor en las ciudades.</li>
<li><strong>Las asignaturas.</strong> El currículo dividido en materias viene de la tradición universitaria y del siglo XIX, y se consolidó con la organización por horarios.</li>
</ul>
<p><strong>Un aviso sobre un mito.</strong> Se repite que la escuela "es un modelo de fábrica prusiano" diseñado para producir obreros obedientes. Quienes revisan la historia advierten que ese relato es en gran parte una invención posterior: la etiqueta del "modelo de fábrica" se popularizó en las últimas décadas del siglo XX, hubo escuelas públicas y gratuitas antes de las reformas de Mann y el propio Mann conocía y respondió a las críticas de que el modelo prusiano fomentaba la obediencia ciega. La enseñanza de fondo es más sobria: <strong>las piezas de la escuela son decisiones históricas con razones de su tiempo</strong> (organizar a muchos niños, medir, financiar), no un destino. Y eso significa que pueden decidirse de otra manera.</p>

<h2>¿Por qué cuesta tanto cambiarlas?</h2>
<ul>
<li><strong>Todo está entrelazado.</strong> La hora de clase sostiene el horario del docente, que sostiene la contratación, la asignación académica y el transporte; los grados sostienen la promoción, el SIEE y la matrícula; las notas sostienen los informes a las familias. Mover una pieza obliga a mover las demás.</li>
<li><strong>Es lo que todos conocemos.</strong> Docentes, familias y estudiantes fuimos formados en esa gramática, y una escuela distinta puede sentirse como una pérdida de rigor.</li>
<li><strong>Las incorporaciones se adaptan a lo existente.</strong> El historiador Larry Cuban documentó en <em>Oversold and Underused</em> (2001) que los computadores llegaron a las aulas, pero en buena parte se usaron para hacer lo que ya se hacía: la tecnología cambió la superficie, no la gramática. Es una advertencia útil para la IA (ver <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a>).</li>
<li><strong>La ley y la rendición de cuentas también la reproducen.</strong> En Colombia, por ejemplo, la norma habla de semanas, horas, áreas y niveles de desempeño (ver abajo).</li>
</ul>

<h2>Qué sí ha cambiado (y qué no)</h2>
<p>Sería injusto decir que nada cambió: hay mejores libros, internet, evaluación formativa, inclusión de estudiantes con discapacidad (ver <a href="/concurso-docente-decreto-1421-de-2017-piar-ajustes-razonables-educacion-inclusiva/">el Decreto 1421 y el PIAR</a>, que obliga a ajustar la enseñanza al estudiante y no al revés), más cobertura, más conocimiento sobre cómo se aprende. Lo que cambió poco es la <strong>estructura</strong>: quién va con quién, durante cuánto tiempo, con quién, dividido en qué partes y medido cómo. La investigación sobre aprendizaje (ver <a href="/aprender-a-aprender-calibracion-tecnicas-de-estudio-repaso-espaciado-libro-excel/">aprender a aprender</a>) apunta a otras cosas: práctica espaciada, retroalimentación, tiempo para explicar, no siempre compatibles con franjas fijas de cuarenta y cinco minutos.</p>

<h2>Qué marca la ley en Colombia, y cuánto margen hay</h2>
<p>La estructura aparece en la norma, pero también hay espacio para cambiar:</p>
<ul>
<li><strong>Tiempo:</strong> el Decreto 1850 de 2002 (compilado en el Decreto 1075 de 2015) fija 40 semanas lectivas y una intensidad semanal mínima (25 horas en primaria, 30 en secundaria y media, según el texto consultado), y la asignación académica de docentes de secundaria y media de 22 horas efectivas semanales (ver <a href="/carga-academica-docente-excel-quien-excede-quien-sobra-que-falta/">la carga académica en Excel</a>).</li>
<li><strong>Áreas:</strong> la Ley 115 de 1994 (art. 23) define áreas obligatorias y fundamentales (nueve), aunque reconoce <strong>autonomía escolar</strong> para organizarlas, y el Proyecto Educativo Institucional puede definir la forma de enseñarlas (ver <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">la Ley 115 y el Decreto 1860</a>).</li>
<li><strong>Evaluación:</strong> cada colegio define su Sistema Institucional de Evaluación de los Estudiantes (SIEE) dentro de la escala nacional (ver <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE y el Decreto 1290</a>), con margen para criterios, estrategias y rúbricas.</li>
<li><strong>Experiencias propias:</strong> Colombia tiene una tradición de modelos flexibles, como la Escuela Nueva, un modelo de aula multigrado surgido en el medio rural en los años setenta, que muestra que se puede organizar distinto <em>dentro</em> de la ley.</li>
<li><strong>Nuevos contenidos:</strong> la Ley 2626 de 2026 incorpora IA, programación y ciencia de datos en tecnología e informática, y exige actualizar los lineamientos cada tres años. Es un ejemplo de cómo el cambio llega por <em>contenidos</em> (lo que se enseña) antes que por <em>estructura</em> (cómo se organiza).</li>
</ul>
<p>La conclusión práctica es que <strong>hay más margen del que se usa</strong>, pero cada cambio de estructura exige hacer cuentas con horarios, contratación y evaluación.</p>

<h2>¿Qué cambiarías? Una encuesta para empezar la conversación</h2>
<p>Antes de proponer cambios, conviene saber qué piensan las tres comunidades. El <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">libro de Excel</a> tabula una encuesta sencilla: para diez rasgos de la escuela (grupos por edad, franjas de clase, asignaturas separadas, un docente para 30 o más estudiantes, notas numéricas, exámenes escritos, calendario, pupitres en filas, inicio temprano y tareas) cada persona responde si lo <strong>mantendría, lo ajustaría o lo cambiaría</strong>. La hoja <em>Datos</em> guarda los conteos por rasgo y grupo, y la hoja <em>Rasgos</em> calcula el porcentaje que cambiaría cada uno, por grupo y en total, la brecha entre grupos y si hay <strong>consenso</strong> (los tres grupos por encima de un umbral editable).</p>
{{img:encuesta}}
<pre><code>' Porcentaje que cambiaría un rasgo (columna E = cambiar, F = total de respuestas)
=SUMAR.SI.CONJUNTO(Datos!$E$2:$E$31;Datos!$A$2:$A$31;A2)/SUMAR.SI.CONJUNTO(Datos!$F$2:$F$31;Datos!$A$2:$A$31;A2)     ' español
=SUMIFS(Datos!$E$2:$E$31,Datos!$A$2:$A$31,A2)/SUMIFS(Datos!$F$2:$F$31,Datos!$A$2:$A$31,A2)                           ' inglés

' Brecha entre grupos (en puntos porcentuales)
=MAX(D2:F2)-MIN(D2:F2)

' Consenso: los tres grupos cambiarían el rasgo por encima del umbral (Parametros!B3)
=SI(MIN(D2:F2)>=Parametros!$B$3;"Sí";"No")                                                                          ' español
=IF(MIN(D2:F2)>=Parametros!$B$3,"Sí","No")                                                                           ' inglés</code></pre>
<p>Resultados de la encuesta <strong>ficticia</strong> (20 docentes, 20 familias y 20 estudiantes): los rasgos que más personas cambiarían son <strong>"un docente para 30 o más estudiantes" y "inicio muy temprano" (52 % cada uno)</strong>, y son los dos únicos con consenso en los tres grupos (con un umbral del 30 %); los que menos, los grupos por edad y el calendario (12 %). Hay <strong>3 rasgos con brecha</strong> entre grupos: las notas numéricas, los pupitres en filas y, sobre todo, las <strong>tareas para la casa</strong>, que cambiaría el 65 % de los estudiantes y el 10 % de las familias (55 puntos de diferencia). Más de la mitad de las personas cambiaría solo 2 de los 10 rasgos: <strong>el cambio de estructura no suele tener mayorías abrumadoras</strong>, y por eso conviene empezar por donde hay consenso.</p>
<p><strong>Una lectura honesta:</strong> es una encuesta ficticia de 60 personas, sin muestra ni margen de error; en un colegio real, las diferencias pueden ser otras. Preguntar "¿qué cambiarías?" también tiene un sesgo: la gente señala lo que le duele hoy. Úsala como un instrumento de conversación, no de decisión.</p>

<h2>Cómo cambiar una cosa a la vez</h2>
<ol>
<li><strong>Elige un solo rasgo</strong> con deseo de cambio compartido (en el ejemplo, el tamaño del grupo o la hora de inicio) y no diez a la vez.</li>
<li><strong>Revisa el margen legal:</strong> ¿lo fija la norma nacional, la secretaría o el PEI y el manual de convivencia?</li>
<li><strong>Define una prueba pequeña y reversible:</strong> un grado, un periodo, un área.</li>
<li><strong>Decide de antemano cómo se medirá si funcionó</strong> (asistencia, aprendizaje, convivencia, percepción) y con qué línea base.</li>
<li><strong>Comunícalo a las familias</strong> y escucha a los estudiantes; los cambios que no se explican se rechazan.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La persistencia de la gramática escolar no es colombiana: la describieron historiadores de Estados Unidos y se observa, con variantes, en casi todos los sistemas. Algunos países se han movido más: Finlandia, por ejemplo, incorporó en su currículo de 2016 módulos de aprendizaje multidisciplinares (ver <a href="/finlandia-sistema-educativo-mito-o-realidad/">Finlandia: ¿mito o realidad?</a> y <a href="/mejores-sistemas-educativos-del-mundo-colombia/">los mejores sistemas educativos del mundo y lo que le falta a Colombia</a>), pero la mayoría conserva grados, horas y asignaturas. En América Latina, la presión por cobertura, jornadas y resultados externos tiende a reforzar la estructura; Colombia tiene, a la vez, experiencias flexibles propias y una normativa muy detallada.</p>
<p>Para los <strong>docentes</strong>, el reto es tener tiempo y apoyo para ensayar; para los <strong>directivos</strong>, hacer cuentas con horarios, contratación y SIEE; para las <strong>familias</strong>, entender que "más estricto" no siempre es "mejor"; y para los <strong>estudiantes</strong>, que su experiencia es una fuente de información válida sobre cómo funciona la escuela.</p>

<h2>Herramientas y plantillas</h2>
<p>Si quieres apoyar este tipo de ensayos con material de aula, planeación y evaluación (con la IA como asistente, revisando siempre lo que produce y sin incluir datos de estudiantes en herramientas que no estén diseñadas para custodiarlos), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">el libro de la encuesta</a>, <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (10 de octubre de 2026)</h2>
<ul>
<li><strong>Tyack y Tobin (1994),</strong> "The 'Grammar' of Schooling: Why Has It Been So Hard to Change?", <em>American Educational Research Journal</em> 31(3), 453-479; <strong>Tyack y Cuban (1995),</strong> <em>Tinkering Toward Utopia</em>; <strong>Cuban (2001),</strong> <em>Oversold and Underused: Computers in the Classroom</em>.</li>
<li><strong>Fundación Carnegie para el Avance de la Enseñanza,</strong> <a href="https://www.carnegiefoundation.org/what-is-the-carnegie-unit/">"What is the Carnegie Unit?"</a>; New America, <a href="https://www.newamerica.org/insights/the-curious-birth-of-the-credit-hour/">"The Curious Birth of the Credit Hour"</a> (el informe de 1906 y el criterio del tiempo).</li>
<li><strong>Gold (2002),</strong> <em>School's In: The History of Summer Education in American Public Schools</em> (Peter Lang), y la cobertura de <a href="https://www.educationnext.org/news-summer-vacation-took-hold-u-s/">Education Next</a> y <a href="https://www.pbs.org/newshour/updates/debunking-myth-summer-vacation">PBS NewsHour</a>; sobre el relato del "modelo de fábrica": <a href="http://hackeducation.com/2015/04/25/factory-model">The Invented History of "The Factory Model of Education"</a> (blog de Audrey Watters; argumento, no historia asentada).</li>
<li><strong>Normas colombianas:</strong> Decreto 1850 de 2002 (Gestor Normativo de la Función Pública), Ley 115 de 1994, Decreto 1290 de 2009 y Ley 2626 de 2026, en las versiones citadas en artículos anteriores de este sitio.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la "gramática de la escuela"?</h3>
<p>El conjunto de estructuras y reglas habituales (grados por edad, horas de clase, asignaturas, calendario) que organizan la enseñanza y que parecen "la escuela de verdad". Lo propusieron Tyack y Tobin en 1994.</p>
<h3>¿Es verdad que la escuela es un modelo de fábrica prusiano?</h3>
<p>Es un relato muy repetido y en gran parte discutido por los historiadores: la etiqueta es posterior y la historia es más compleja. Lo sólido es que las estructuras actuales son decisiones históricas, no naturales.</p>
<h3>¿Por qué existen las vacaciones largas?</h3>
<p>No son un simple residuo del trabajo agrícola; según Gold, el calendario de unos 180 días fue una creación deliberada de reformadores entre finales del siglo XIX y principios del XX.</p>
<h3>¿Se puede cambiar la estructura de la escuela dentro de la ley colombiana?</h3>
<p>En parte: hay normas de tiempo y áreas, pero también autonomía escolar, PEI, SIEE y modelos flexibles como la Escuela Nueva. Conviene revisar el margen con la secretaría de educación.</p>
<h3>¿Cómo uso el libro?</h3>
<p>Escribe los conteos de tu encuesta (mantener, ajustar y cambiar) por rasgo y grupo; el libro calcula porcentajes, brechas y consensos.</p>

<p class="notice"><strong>Haz la encuesta en tu colegio.</strong> Descarga el <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">libro de la encuesta</a>, aplícala a docentes, familias y estudiantes, reemplaza los datos ficticios y empieza por el rasgo con consenso.</p>

<h2>Para pensar</h2>
<p>Cada pieza de la escuela fue, en algún momento, la respuesta razonable a un problema de su época. <strong>¿Qué problema resuelve hoy cada pieza que te parece natural en tu colegio? Y, si pudieras cambiar una sola cosa de la escuela hoy, ¿cuál sería, qué ganarían los estudiantes con ese cambio y qué tendrías que cuidar para no perder lo que la escuela sí hace bien?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:gramatica}}' => $img('gramatica-escolar-gramatica', 499, 'Tabla con cuatro rasgos de la gramática de la escuela, su origen aproximado y qué se mide con cada uno: grados por edad, unidad Carnegie, asignaturas separadas y franjas y calendario.', 'Estructuras que parecen naturales y no lo son.'),
    '{{img:encuesta}}' => $img('gramatica-escolar-encuesta', 700, 'Gráfico de barras con el porcentaje de 60 personas de una encuesta ficticia que cambiaría cada rasgo de la escuela: docente para 30 o más 52, inicio muy temprano 52, pupitres 37, notas 35 y otros hasta 12.', 'Encuesta ficticia: qué cambiaría cada grupo.'),
]);

return [
    'slug' => 'por-que-la-escuela-se-parece-a-la-que-conocimos-gramatica-escolar-que-cambiarias',
    'title' => '¿Por qué la escuela sigue pareciéndose tanto a la que conocimos, si el mundo cambió por completo? Y qué cambiarías tú',
    'excerpt' => 'La "gramática de la escuela": de dónde vienen los grados por edad, la hora de clase y el calendario, por qué cuesta cambiarlos, qué margen da la ley en Colombia y una encuesta en Excel para decidir qué cambiar primero.',
    'seo_title' => '¿Por qué la escuela se parece a la de siempre?',
    'seo_description' => 'Por qué la escuela se parece tanto a la que conocimos: la gramática de la escuela, la unidad Carnegie, el margen de la ley colombiana y una encuesta en Excel.',
    'focus_keyword' => 'gramática de la escuela',
    'cover' => '/assets/img/articulos/gramatica-escolar/gramatica-escolar-portada',
    'cover_alt' => 'Portada "¿Por qué la escuela se parece tanto a la que conocimos? Y qué cambiarías tú" con una tarjeta: 120 horas es la unidad Carnegie de 1906, que contaba el tiempo en el aula, no lo aprendido.',
    'published_at' => '2027-03-09 12:00:00',
    'content_html' => $html,
];
