<?php

declare(strict_types=1);

// Artículo de análisis: video de Platzi "El fracaso de la educación y las pruebas PISA" (YouTube fNLBeGyTNf8).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/pruebas-pisa/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

return [
    'slug' => 'pruebas-pisa-america-latina-colombia-docentes-familias',
    'title' => 'Pruebas PISA: por qué América Latina va mal en matemáticas y qué pueden hacer docentes, familias y el sistema educativo colombiano',
    'excerpt' => 'Analizo el video de Platzi sobre los resultados de PISA: la caída en matemáticas y lectura, las excusas que no alcanzan, el papel de las pantallas y la idea del colegio como "gimnasio de la mente", desde Colombia frente a Latinoamérica y el mundo.',
    'seo_title' => 'Pruebas PISA en América Latina: qué significa para Colombia',
    'seo_description' => 'Análisis del video de Platzi sobre PISA: matemáticas, lectura, pantallas y perseverancia. Qué significa para docentes, familias y estudiantes en Colombia.',
    'focus_keyword' => 'pruebas PISA',
    'cover' => '/assets/img/articulos/pruebas-pisa/pruebas-pisa-portada',
    'cover_alt' => 'Gráfico de barras con caídas en matemáticas, lectura y ciencias junto al titular América Latina reprobó en PISA',
    'published_at' => '2026-10-06 18:00:00',
    'content_html' => <<<HTML
<p>Cada vez que se publican los resultados de las pruebas PISA, en Colombia se repite la misma conversación durante una semana: titulares alarmados, culpables de siempre y, al poco tiempo, silencio. Esta vez, Freddy Vega, cofundador de Platzi, publicó un análisis de más de veinte minutos con una tesis incómoda: el atraso educativo de la región no se explica solo con la pobreza, la corrupción o la inteligencia artificial.</p>
<p>Lo vi completo con ojos de docente de matemáticas. Aquí resumo lo que plantea, lo contrasto con lo que vivimos en las aulas colombianas y lo comparo con lo que hacen otros países. Al final dejo una pregunta que, creo, deberíamos hacernos todos los que trabajamos en educación.</p>

<h2>Lo que plantea el video</h2>
<figure class="lite-yt" data-yt="fNLBeGyTNf8"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=fNLBeGyTNf8" data-yt="fNLBeGyTNf8"><img src="https://i.ytimg.com/vi/fNLBeGyTNf8/hqdefault.jpg" alt="Video: El fracaso de la educación y las pruebas PISA" width="480" height="360"><span class="lite-yt__play"></span></a></figure>
<p>Según el análisis que presenta el video, los últimos resultados de PISA muestran una caída global en ciencias, lectura y matemáticas, y América Latina aparece entre las regiones más golpeadas. Estos son los datos que más destaca:</p>
<ul>
<li><strong>Ningún país latinoamericano</strong> está por encima del promedio de la OCDE; todos están por debajo o muy por debajo.</li>
<li>En México, el porcentaje de estudiantes por debajo del nivel 2 en matemáticas, es decir, que no logran resolver un problema matemático básico, pasó de <strong>56 % a 70 %</strong> en diez años.</li>
<li>En la OCDE, alrededor del <strong>12 %</strong> de los estudiantes alcanza los niveles más altos (5 y 6); en Uruguay, el mejor de la región, es el <strong>2,8 %</strong>, y en Perú, el <strong>0,5 %</strong>.</li>
<li>Los estudiantes más pobres de Singapur y Japón obtienen mejores puntajes que los más ricos de los mejores países de la región.</li>
<li>Hay avances: Costa Rica y Uruguay mejoraron en ciencias, y la región ha logrado llevar a más jóvenes al colegio. Argentina, en cambio, cayó en las tres áreas.</li>
</ul>
{$img('pruebas-pisa-datos', 640, 'Seis datos de PISA citados en el video: ningún país latinoamericano supera el promedio de la OCDE, México pasó de 56 % a 70 % bajo el nivel 2, 12 % de estudiantes excelentes en la OCDE frente a 2,8 % en Uruguay y 0,5 % en Perú', 'Los datos que presenta el video. Las cifras oficiales completas están en los informes de la OCDE.')}
<p>El video también incluye una invitación de Platzi: dar acceso gratuito a su curso de fundamentos de matemáticas a colegios que tengan computadores, internet y el compromiso de sus directivas. Vale la pena saberlo, aunque el análisis no depende de esa oferta.</p>

<h2>Lo que PISA mide y lo que no</h2>
<p>Antes de sacar conclusiones conviene entender la prueba. PISA evalúa a estudiantes de 15 años en tres áreas: <strong>lectura</strong>, que en palabras del video mide la paciencia para entender un texto complejo; <strong>matemáticas</strong>, que mide la capacidad de resolver un problema paso a paso, y <strong>ciencias</strong>, que combina memoria y la rapidez para juzgar si algo encaja con la realidad.</p>
<p>Hay un detalle que el propio video subraya y que casi nunca aparece en los titulares: <strong>PISA solo evalúa a quienes están en el colegio</strong>. Según los datos que muestra, en Chile la prueba representa a cerca del 95 % de los jóvenes de 15 años, mientras que en Guatemala apenas a la mitad. Por eso comparar países sin mirar la cobertura puede llevar a conclusiones equivocadas, y por eso que más jóvenes latinoamericanos estén escolarizados es una buena noticia aunque, en el corto plazo, presione los promedios hacia abajo.</p>

<h2>La tesis central: no es (solo) lo que solemos culpar</h2>
<p>La parte más provocadora del video es su crítica a las explicaciones de siempre:</p>
<ul>
<li><strong>La pobreza no lo explica todo.</strong> Según el análisis, a partir de cierto nivel de inversión por estudiante los resultados dejan de mejorar al mismo ritmo. El ejemplo que usa es Turquía, que invierte por estudiante algo parecido a Perú y al promedio latinoamericano y, aun así, logró mejorar en ciencias hasta superar el promedio de la OCDE.</li>
<li><strong>Tampoco la desigualdad, por sí sola.</strong> El video señala que el cuartil más favorecido de la región, los estudiantes de familias con más recursos, empeoró, mientras el más desfavorecido mejoró un poco. Es decir, el problema es del sistema, no solo de un grupo.</li>
<li><strong>La inteligencia artificial influye, pero no basta como explicación.</strong> Los países que menos la usan tienden a tener mejores puntajes, pero hay excepciones claras: Singapur la usa mucho y le va muy bien; Vietnam la usa mucho y no.</li>
</ul>
{$img('pruebas-pisa-causas', 600, 'Comparación entre lo que solemos culpar (pobreza, corrupción, inteligencia artificial, redes sociales) y lo que señala el análisis (falta de perseverancia, pantallas para ocio, poca computación real y motivación para pensar)', 'El argumento del video: cambiar las excusas por causas sobre las que sí se puede actuar.')}
<p>¿Qué explica entonces la caída? El video apunta a cuatro factores: la <strong>falta de perseverancia</strong> (los estudiantes empezaron a responder al azar en lectura y matemáticas, las dos pruebas que exigen quedarse pensando), el <strong>uso de pantallas para ocio</strong>, la <strong>falta de alfabetización digital real</strong> con computadores y, sobre todo, la <strong>falta de motivación para hacer el esfuerzo de pensar</strong>.</p>

<h2>Los estudiantes: curiosos, pero se rinden rápido</h2>
<p>Hay un dato esperanzador en medio de tanto mal resultado: según el video, los estudiantes latinoamericanos reportan <strong>más curiosidad intelectual</strong> que el promedio de la OCDE. No es falta de interés por aprender. El problema aparece cuando aprender exige esfuerzo sostenido: ante el primer obstáculo, cada vez más jóvenes se rinden.</p>
<p>Eso coincide con lo que vemos en el aula. Un estudiante que ha pasado años con respuestas inmediatas a un clic de distancia, en el buscador, en el video corto o en el asistente de IA, tolera mal la incomodidad de no saber. Y las matemáticas son, precisamente, el arte de soportar esa incomodidad el tiempo suficiente para descomponer un problema en pasos.</p>
<p>El video menciona también una brecha de género global: más niños entre los mejores puntajes de matemáticas y más niñas entre los mejores de lectura. No es una cuestión de capacidad, sino de expectativas, estereotipos y oportunidades que se acumulan desde la primaria, y Colombia no es la excepción.</p>

<h2>Los profesores: enseñar a pensar cuando la respuesta está a un clic</h2>
<p>Para quienes enseñamos, el mensaje del video es exigente pero útil. Si el problema central es la perseverancia, la clase no puede limitarse a explicar y poner ejercicios mecánicos. Algunas prácticas que, en mi experiencia, cambian la dinámica:</p>
<ul>
<li><strong>Problemas de varios pasos</strong>, con contexto real, en lugar de listas de ejercicios repetitivos.</li>
<li><strong>Tiempo explícito para el error</strong>: valorar el procedimiento y la corrección, no solo la respuesta final.</li>
<li><strong>Pensar antes de consultar</strong>: diez minutos de trabajo propio antes de usar la calculadora, el buscador o la IA.</li>
<li><strong>Computación de verdad</strong>: hojas de cálculo, carpetas, archivos y programación básica en computadores con teclado, no solo aplicaciones en una tableta.</li>
</ul>
<p>Nada de esto funciona si el docente trabaja solo. Colombia tiene experiencia en acompañamiento docente con programas como Todos a Aprender, enfocado en lenguaje y matemáticas en los primeros grados; la pregunta es cómo llevar ese tipo de acompañamiento a la secundaria, que es donde PISA mide los resultados.</p>

<h2>Los padres de familia: el autocontrol también se aprende en casa</h2>
<p>Uno de los hallazgos más claros que cita el video tiene que ver con las pantallas. Usadas para ocio (redes, video corto, chat), <strong>más de una hora al día se asocia con peores puntajes</strong>, y cada hora adicional resta. Curiosamente, usarlas menos de una hora diaria para ocio se asocia con mejores resultados, algo que el video interpreta como una señal de autocontrol. Incluso el uso de dispositivos para aprender deja de ayudar cuando pasa de cinco horas.</p>
{$img('pruebas-pisa-pantallas', 573, 'Ilustración de la relación entre horas de pantalla y puntajes: el uso para ocio mejora por debajo de una hora y luego empeora; el uso para aprender es neutro hasta cinco horas y luego resta', 'Ilustración del hallazgo descrito en el video. No es a escala: muestra la tendencia, no los valores.')}
<p>Para las familias, la conclusión no es prohibir la tecnología, sino ponerle límites claros y enseñar a usarla:</p>
<ul>
<li><strong>Menos de una hora diaria de pantallas para ocio</strong> en días de colegio, acordada con los hijos y no impuesta a gritos.</li>
<li><strong>El teléfono fuera de la mesa de estudio</strong> mientras se hacen las tareas.</li>
<li><strong>Preguntar "¿cómo lo resolviste?"</strong> en lugar de "¿ya terminaste?".</li>
<li><strong>No hacer las tareas por ellos</strong>, ni dejar que la IA las haga: acompañar el esfuerzo es más valioso que resolver el problema.</li>
<li><strong>Dar ejemplo</strong>: los hijos aprenden más de cómo usamos el teléfono que de lo que les decimos sobre él.</li>
</ul>

<h2>El sistema educativo colombiano: resultados extremos</h2>
<p>Colombia participa en PISA desde 2006 y cuenta además con su propio sistema de evaluación, las pruebas Saber, que aplica el ICFES. Datos no faltan. Lo que el video agrega es una observación inquietante: Colombia tiene un promedio parecido al de varios vecinos, pero una distribución mucho más extrema. Según el análisis, sus mejores estudiantes son mejores que los mejores de México, pero sus peores son mucho peores que los peores de México.</p>
<p>Eso significa que en el mismo país conviven colegios que compiten con estándares internacionales y colegios donde la mayoría de estudiantes no alcanza lo básico. La brecha entre lo urbano y lo rural, entre lo público y lo privado, y entre regiones explica buena parte de ese abismo.</p>
<p>El punto de la computación también toca de cerca al país. Programas como Computadores para Educar han llevado equipos a miles de sedes públicas, y el video plantea un debate necesario: para aprender a resolver problemas, un computador con teclado y conexión a internet vale más que una tableta. La pregunta no es solo cuántos equipos llegan, sino cuáles y cómo se usan en clase.</p>

<h2>Colombia frente a Latinoamérica</h2>
<p>El video agrupa a los países de la región en tres niveles según sus resultados en matemáticas. Uruguay y Chile encabezan la región, aunque muy por debajo de la OCDE. Colombia aparece en el grupo más grande, junto con Costa Rica, Perú, Brasil, Argentina, Ecuador y México. Y El Salvador, República Dominicana, Guatemala y Paraguay muestran el mayor rezago.</p>
{$img('pruebas-pisa-paises', 600, 'Agrupación de países según el video: los mejores del mundo, el promedio de la OCDE, los mejores de la región, el grupo grande donde está Colombia y el grupo de mayor rezago', 'Cómo agrupa el video a los países en matemáticas. Es una agrupación aproximada, no un ranking oficial.')}
<p>Dentro de ese panorama hay historias distintas: <strong>Costa Rica</strong> es, según el video, el único país de la región que mejoró en matemáticas y algo en lectura; <strong>Perú</strong>, que venía creciendo de forma notable, se estancó; <strong>Argentina</strong>, que fue referente regional, retrocedió en las tres áreas, y <strong>México</strong> empeoró de forma marcada en matemáticas. Colombia no está entre los casos de colapso, pero tampoco entre los de mejora: está estancada en el medio.</p>

<h2>Colombia frente al resto del mundo</h2>
<p>Los países que lideran PISA, como Singapur y Japón, tienen algo en común que el video resalta: sistemas muy exigentes, con alta perseverancia de sus estudiantes. Según el análisis, solo algunos países, casi todos asiáticos, aumentaron la disposición de sus estudiantes a esforzarse ante un desafío; la mayoría cayó y América Latina cayó con fuerza. Japón, además, es un caso llamativo: casi no usa inteligencia artificial en los colegios y obtiene los mejores puntajes.</p>
<p>Fuera del video, la tendencia internacional va en la misma dirección. Varios países europeos han restringido el uso de teléfonos en las aulas, y la UNESCO, en su informe de 2023 sobre tecnología en la educación, recomendó usar la tecnología en clase solo cuando mejore el aprendizaje. El ejemplo de Turquía, que menciona el video, muestra además que un país con recursos parecidos a los nuestros puede mejorar en pocos años.</p>

<h2>Una lectura crítica del video</h2>
<p>El análisis es valioso, pero no está exento de matices:</p>
<ul>
<li><strong>Correlación no es causalidad.</strong> Que los países que menos usan IA tengan mejores puntajes no prueba que la IA sea la causa; puede haber factores culturales y de política educativa detrás de ambas cosas.</li>
<li><strong>Algunas conclusiones son muy contundentes.</strong> Afirmar que la región "nunca" podrá desarrollar industrias complejas por su nivel en matemáticas sirve para despertar, pero el futuro depende de lo que se haga a partir de ahora.</li>
<li><strong>Las cifras merecen ir a la fuente.</strong> El video resume muchos gráficos; quien quiera tomar decisiones debe revisar los informes oficiales de la OCDE y los datos de su país.</li>
<li><strong>Hay un contexto comercial.</strong> El video recomienda cursos de Platzi. No invalida el análisis, pero conviene tenerlo presente.</li>
</ul>
<p>Aun con esos matices, su aporte central me parece acertado: dejar de buscar excusas y concentrarnos en lo que sí podemos cambiar en el aula y en la casa.</p>

<h2>El colegio como "gimnasio de la mente"</h2>
<p>La idea con la que cierra el video es poderosa. Antes, ir al colegio era acceder a un conocimiento escaso; hoy el conocimiento está en todas partes. Desde la revolución industrial, las máquinas nos liberaron del esfuerzo físico y por eso existen los gimnasios: necesitamos ejercitarnos para estar bien. Con las máquinas que piensan por nosotros pasará lo mismo, y <strong>los colegios tendrán que convertirse en gimnasios de la mente</strong>, lugares donde nos obligamos a pensar y a sentirnos incómodos. Su conclusión: <em>educar ahora es motivar a pensar</em>.</p>
{$img('pruebas-pisa-gimnasio', 573, 'Qué puede entrenar cada actor en el colegio como gimnasio de la mente: docentes, estudiantes, familias y sistema educativo', 'Si el colegio es un gimnasio de la mente, cada actor tiene su rutina.')}

<h2>Preguntas frecuentes</h2>
<h3>¿Qué son las pruebas PISA?</h3>
<p>Son evaluaciones internacionales de la OCDE que miden las competencias en lectura, matemáticas y ciencias de estudiantes de 15 años. Se aplican cada pocos años en decenas de países y permiten comparar sistemas educativos.</p>
<h3>¿Cómo le fue a Colombia en las últimas pruebas PISA?</h3>
<p>Según el análisis del video, Colombia está en el grupo intermedio de América Latina, por debajo del promedio de la OCDE, y con una distribución muy desigual: sus mejores estudiantes superan a los mejores de México, pero sus peores están muy por debajo.</p>
<h3>¿Por qué América Latina sale mal en matemáticas?</h3>
<p>El video plantea que no se explica solo por la pobreza o la corrupción, sino por la falta de perseverancia ante problemas difíciles, el uso excesivo de pantallas para ocio, la poca formación en computación real y la falta de motivación para el esfuerzo de pensar.</p>
<h3>¿Cuánto tiempo de pantalla es recomendable para un estudiante?</h3>
<p>Según los hallazgos que cita el video, menos de una hora diaria de pantallas para ocio se asocia con mejores puntajes, y cada hora adicional los reduce. Para aprender, el uso deja de ayudar cuando supera las cinco horas.</p>
<h3>¿La inteligencia artificial empeora los resultados escolares?</h3>
<p>No hay una relación simple. Los países que menos la usan tienden a tener mejores resultados, pero hay excepciones. Lo importante es usarla para aprender a pensar y no para evitar pensar.</p>

<h2>Conclusión</h2>
<p>Los resultados de PISA no son una sentencia, son un diagnóstico. Y el diagnóstico que propone el video es, en el fondo, esperanzador: si el problema no es solo la pobreza ni la corrupción, sino la perseverancia, el uso de la tecnología y la motivación para pensar, entonces hay mucho que los docentes, las familias, los estudiantes y el sistema educativo colombiano pueden hacer desde mañana. Hacer que pensar vuelva a ser un hábito diario es una tarea de todos.</p>

<h2>Una pregunta para terminar</h2>
{$img('pruebas-pisa-pregunta', 480, 'Pregunta final: si una máquina ya responde en segundos, por qué seguimos calificando a los estudiantes por sus respuestas y no por cuánto tiempo resisten pensando', 'La pregunta que queda abierta.')}
<p><strong>Si una máquina ya responde en segundos, ¿por qué seguimos calificando a los estudiantes por sus respuestas y no por cuánto tiempo son capaces de resistir pensando antes de rendirse?</strong> Tal vez la próxima gran reforma educativa no consista en enseñar más contenidos, sino en evaluar el esfuerzo de pensar que ninguna máquina puede hacer por nosotros.</p>
HTML,
];
