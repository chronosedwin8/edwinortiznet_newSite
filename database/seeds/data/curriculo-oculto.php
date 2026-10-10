<?php

declare(strict_types=1);

// "El currículo oculto entre grados". Fuentes: Philip Jackson, Life in Classrooms (1968); crítica de Apple y Giroux; investigación sobre transiciones escolares (Eccles y colaboradores, ajuste etapa-entorno), citada con matices; Ley 115 de 1994, art. 76. Libro verificado en Excel 16 y Python con datos ficticios: 3 prácticas coherentes, 3 con dos versiones, 4 con tres o más; 13 de 30 transiciones cambian; por transición 2, 6 y 5.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/curriculo-oculto/' . $name;
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
<p>Sofía llega a octavo grado con un hábito que le funcionó en séptimo: entregar el trabajo un día tarde, con una pequeña penalización. En octavo, la profesora de matemáticas no recibe nada después de la hora; el de lenguaje, en cambio, acepta lo que sea. En séptimo corregía el docente; ahora le piden corregir a ella. Nadie le explicó nada de esto, porque no está en ningún documento: es lo que la comunidad escolar llama <strong>currículo oculto</strong>, y esta vez cambia de grado en grado.</p>
<p>Este artículo trata del currículo oculto y, en particular, de su versión menos visible: <strong>las reglas y las expectativas que cambian entre grados</strong> sin que nadie lo decida colectivamente. Incluye un <a href="/descargas/curriculo-oculto/mapa-expectativas-entre-grados.xlsx">libro de Excel</a> para mapear diez prácticas de aula en cuatro grados, contar cuántas versiones distintas hay de cada una y dónde se concentran los cambios, verificado en Microsoft Excel 16 y contra un cálculo independiente con datos ficticios. Fuentes revisadas el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos del mapa son ficticios y no describen ningún colegio. Las prácticas y los mensajes que se mencionan son ejemplos: el efecto de una regla depende del contexto y de cómo se aplique, y no hay una forma única correcta de manejar la puntualidad, el celular o la participación. El objetivo no es uniformar a todos los docentes, sino <strong>hacer visibles y conversables las diferencias</strong>. La evaluación de los estudiantes debe seguir el sistema institucional de evaluación (SIEE) del colegio.</p>

<h2>Qué es el currículo oculto</h2>
<p>La expresión se asocia con Philip Jackson, quien en <em>Life in Classrooms</em> (1968) describió que, además de los contenidos que se enseñan, la escuela transmite normas, valores y hábitos a través de su vida cotidiana: esperar turnos, aceptar la evaluación, convivir con la multitud, obedecer la rutina. Desde entonces, la sociología y la pedagogía críticas (por ejemplo, los trabajos de Apple y de Giroux) han analizado cómo esos mensajes implícitos pueden reproducir desigualdades o, bien usados, formar hábitos valiosos. Por contraste, el <strong>currículo explícito</strong> es el que está escrito: el plan de estudios, los estándares, los objetivos y el SIEE. El artículo 76 de la Ley 115 de 1994 define el currículo como el conjunto de criterios, planes de estudio, programas, metodologías y procesos que contribuyen a la formación integral y a la identidad cultural; el currículo oculto es lo que, sin estar ahí, también forma.</p>
<p>Ejemplos de mensajes implícitos: quién habla y quién calla, qué se premia (la velocidad, la obediencia, la creatividad), qué pasa con el error (se esconde o se discute), cómo se trata el trabajo en grupo (¿se aprende a colaborar o a repartirse tareas?), cómo se habla de los estudiantes. No es "bueno" ni "malo" por sí mismo: <strong>es inevitable, y la pregunta es si se hace consciente y coherente</strong>.</p>
{{img:mensajes}}

<h2>Lo que cambia entre grados</h2>
<p>El currículo oculto no solo varía entre colegios o entre docentes: cambia entre grados. Un estudiante recorre, año tras año, a cinco, diez o quince adultos que le piden cosas distintas con las mismas palabras ("trabajo en grupo", "participación", "corrección"). Los cambios más visibles ocurren en las transiciones, como el paso de primaria a secundaria, donde la investigación sobre transiciones escolares (por ejemplo, la línea de trabajo sobre el ajuste entre las necesidades de los adolescentes y el entorno escolar, de Eccles y colaboradores) ha encontrado, en promedio, descensos de motivación y de percepción de apoyo, con mucha variación entre estudiantes y contextos. No todo se explica por las reglas del aula, pero la <strong>falta de coherencia entre grados</strong> es una de las fuentes de esa incertidumbre que sí puede trabajarse.</p>

<h2>El mapa de expectativas: diez prácticas, cuatro grados</h2>
<p>La hoja <em>Opciones</em> del libro define diez prácticas, cada una con tres formas posibles de hacerse (A, B o C): qué pasa con los trabajos entregados tarde, el uso del celular en clase, el formato de entrega, la corrección de errores, el trabajo en grupo, la participación, las recuperaciones, la escala de las rúbricas, las tareas en casa y la forma de pedir la palabra. En la hoja <em>Mapa</em>, cada grado (6.º a 9.º en el ejemplo) marca la opción que realmente se aplica. El libro calcula, para cada práctica, las <strong>versiones distintas</strong> y los <strong>cambios entre grados consecutivos</strong>:</p>
<pre><code>' Versiones distintas de una práctica en los cuatro grados
=SUMAPRODUCTO(1/CONTAR.SI(C4:F4;C4:F4))             ' español
=SUMPRODUCT(1/COUNTIF(C4:F4,C4:F4))                 ' inglés

' Cambios entre grados consecutivos (0 a 3)
=(C4<>D4)+(D4<>E4)+(E4<>F4)

' Prácticas que cambian en la transición de 7.º a 8.º
=SUMAPRODUCTO(--(Mapa!D4:D13<>Mapa!E4:E13))</code></pre>
<p>Con los datos ficticios del ejemplo:</p>
<ul>
<li><strong>3 prácticas coherentes</strong> en los cuatro grados (uso del celular, trabajo en grupo y forma de pedir la palabra), <strong>3 con dos versiones</strong> y <strong>4 con tres versiones o más</strong> (trabajos tardíos, corrección de errores, recuperaciones y escala de las rúbricas).</li>
<li><strong>13 de 30 transiciones posibles (43 %)</strong> cambian de regla (10 prácticas por 3 transiciones).</li>
<li><strong>Por transición:</strong> de 6.º a 7.º cambian 2 prácticas; de 7.º a 8.º, <strong>6</strong> (la mayor sacudida); de 8.º a 9.º, 5.</li>
<li>La corrección de errores y las recuperaciones cambian en <strong>cada</strong> transición (3 cambios cada una): un estudiante que aprende cómo se manejan los errores en un grado tiene que aprenderlo de nuevo al siguiente.</li>
</ul>
<p>El diagnóstico automático de cada fila lee "Coherente en los cuatro grados" (en verde), "Dos versiones: revisar si el cambio es intencional" o "Tres versiones o más: el estudiante aprende reglas nuevas cada año". <strong>Una diferencia no es automáticamente un problema:</strong> puede ser un cambio por edad que tiene sentido (más autonomía en grados mayores). Lo que el mapa permite es distinguir los cambios <em>deliberados</em> de los <em>accidentales</em>.</p>

<h2>Cómo trabajarlo en la institución</h2>
{{img:pasos}}
<ol>
<li><strong>Mapea lo que se hace, no lo que dice el reglamento.</strong> Pide a cada equipo de grado que marque la práctica real, de forma anónima si hace falta; las diferencias entre lo escrito y lo practicado ya son un hallazgo.</li>
<li><strong>Compara y busca la razón.</strong> ¿Por qué cambia la política de recuperaciones de un grado a otro? ¿Es por edad, por tradición o por azar?</li>
<li><strong>Acuerda mínimos comunes</strong> y excepciones justificadas por edad (la hoja <em>Acuerdos</em> sirve para anotarlos). Dos o tres acuerdos claros valen más que un manual extenso.</li>
<li><strong>Comunica</strong> a estudiantes y familias, al inicio del año y en cada transición (por ejemplo, una página de "qué cambia en octavo").</li>
<li><strong>Revisa cada periodo</strong> con evidencia: reclamaciones, conversaciones con estudiantes, resultados.</li>
</ol>
<p>Esto conecta con otras piezas de la evaluación: las reglas de las recuperaciones, los plazos y el redondeo deben estar en el SIEE (ver <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE y el Decreto 1290</a>), y las diferencias de criterios entre docentes afectan la percepción de justicia de las notas (ver <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">calificaciones: aprendizaje o cumplimiento</a>). También con la retroalimentación (ver <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a>): si cada grado corrige de una manera, el estudiante no puede acumular el hábito de usarla.</p>

<h2>Una conversación entre docentes: cuatro preguntas</h2>
<ul>
<li>¿Qué hace un estudiante en mi clase que en la del grado anterior le funcionaba, y ya no?</li>
<li>¿Qué reglas mías podría explicar con una razón pedagógica, y cuáles son costumbre?</li>
<li>¿Qué mensaje recibe un estudiante de mi regla sobre el error, la colaboración o el esfuerzo?</li>
<li>¿Qué tendría que acordar con mis colegas para que un estudiante no tenga que adivinar?</li>
</ul>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el currículo explícito se articula entre el MEN (estándares y derechos básicos), el PEI y el SIEE de cada colegio, y la autonomía institucional permite que cada docente tome decisiones de aula que no están escritas en ninguna parte. En la región y en el mundo, el estudio del currículo oculto es una tradición consolidada, y la preocupación por las transiciones entre ciclos (preescolar a primaria, primaria a secundaria, secundaria a media) aparece de forma recurrente en las políticas educativas. Para los <strong>docentes</strong>, el reto es conversar sobre lo que parece obvio; para los <strong>directivos</strong>, dar espacios de coordinación entre grados y no solo entre áreas; para las <strong>familias</strong>, saber qué esperar en cada grado; y para los <strong>estudiantes</strong>, que las reglas sean predecibles es parte de sentirse seguros para aprender. Ver también la <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">planeación inversa</a> (alinear lo que se enseña, lo que se evalúa y lo que se practica) y <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflicto, indisciplina y violencia escolar</a> (cuando las reglas de convivencia también cambian de grado).</p>

<h2>Herramientas y plantillas</h2>
<p>Para planear acuerdos de aula, rúbricas coherentes entre grados y otros materiales, y para organizar tus recursos con IA (siempre revisando lo que produce), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla/">transferencia del aprendizaje</a>, <a href="/error-revela-como-piensa-estudiante-ideas-previas-ciencias-preguntas-diagnostico/">el error revela cómo piensa el estudiante</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>. Para adaptar las reglas a estudiantes con barreras de aprendizaje, <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es el currículo oculto?</h3>
<p>Las normas, valores, hábitos y expectativas que la escuela transmite a través de su vida cotidiana, sin estar escritos en el plan de estudios. Se asocia con Philip Jackson (<em>Life in Classrooms</em>, 1968).</p>
<h3>¿Es lo mismo que el currículo explícito?</h3>
<p>No: el explícito es el que está escrito (plan de estudios, estándares, objetivos, SIEE); el oculto es lo que se enseña de forma implícita.</p>
<h3>¿Por qué importa que las reglas cambien entre grados?</h3>
<p>Porque cada cambio exige que el estudiante aprenda de nuevo cómo funciona el aula, y las diferencias no explicadas pueden percibirse como arbitrarias. No todo cambio es un problema: algunos responden a la edad.</p>
<h3>¿Hay que unificar todas las reglas?</h3>
<p>No: se trata de acordar mínimos comunes, justificar las diferencias por edad y comunicarlas.</p>
<h3>¿Cómo uso el libro?</h3>
<p>Cada equipo de grado marca la práctica real, el libro cuenta versiones y cambios, y con ello el grupo de docentes decide qué acordar.</p>

<p class="notice"><strong>Mapea tus propias reglas.</strong> Descarga el <a href="/descargas/curriculo-oculto/mapa-expectativas-entre-grados.xlsx">mapa de expectativas</a>, reemplaza las prácticas y los grados por los de tu colegio y mira qué transición concentra más cambios. Luego conversa con tus colegas qué cambios son intencionales.</p>

<h2>Para pensar</h2>
<p>Los estudiantes aprenden lo que decimos y, sobre todo, lo que hacemos. <strong>¿Qué mensaje le llega a un estudiante que, a lo largo de cuatro años, recibe cuatro reglas distintas sobre el error? Y si la coherencia entre grados fuera un derecho de los estudiantes, ¿qué tendría que cambiar en la forma en que los docentes nos coordinamos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:mensajes}}' => $img('curriculo-oculto-mensajes', 499, 'Tabla con cuatro prácticas de aula, el mensaje que pueden transmitir sin decirlo y una pregunta para revisarlas.', 'Una regla del aula también transmite un mensaje.'),
    '{{img:pasos}}' => $img('curriculo-oculto-pasos', 467, 'Cinco pasos para ordenar las reglas entre grados: mapear, comparar, acordar, comunicar y revisar.', 'Cinco pasos para ordenar las reglas entre grados.'),
]);

return [
    'slug' => 'curriculo-oculto-entre-grados-reglas-que-cambian-cada-ano-mapa-expectativas',
    'title' => 'El currículo oculto entre grados: las reglas que cambian cada año sin que nadie lo diga, con un mapa de expectativas',
    'excerpt' => 'Qué es el currículo oculto y cómo cambian las reglas y expectativas del aula entre grados: un mapa de diez prácticas en cuatro grados en Excel que cuenta versiones, cambios por transición y ayuda a acordar mínimos comunes.',
    'seo_title' => 'Currículo oculto entre grados: mapa de expectativas',
    'seo_description' => 'Qué es el currículo oculto y cómo cambian las reglas del aula entre grados, con un mapa de expectativas en Excel para acordar mínimos comunes entre docentes.',
    'focus_keyword' => 'currículo oculto entre grados',
    'cover' => '/assets/img/articulos/curriculo-oculto/curriculo-oculto-portada',
    'cover_alt' => 'Portada "El currículo oculto entre grados: reglas que cambian cada año sin que nadie lo diga" con una tarjeta: 13 de 30 transiciones entre grados cambian de regla en el mapa de ejemplo.',
    'published_at' => '2027-02-10 12:00:00',
    'content_html' => $html,
];
