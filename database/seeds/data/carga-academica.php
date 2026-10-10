<?php

declare(strict_types=1);

// "Carga académica docente en Excel". Fuente: Decreto 1850 de 2002, arts. 5, 6, 7, 11 (Gestor Normativo Función Pública, norma.php?i=5556, consultado 10-oct-2026): secundaria y media 22 h efectivas de 60 min; primaria = jornada escolar; dirección de grupo no reduce; jornada 8 h, mínimo 6 en el establecimiento. TALIS (OCDE) como referencia general. Libro verificado en Excel 16 y Python: 6 docentes, 6 grupos, 150 h requeridas, 133 asignadas (25,24,22,22,22,18), 17 sin cubrir en 6 combinaciones, 2 exceden (5 h), 1 por debajo, docente 6 con 287 estudiantes. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/carga-academica/' . $name;
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
<p>En enero, el coordinador académico arma la asignación: matemáticas para este docente, lengua para aquella, y así hasta que "cuadra". En marzo descubre dos cosas. Un docente da 25 horas de clase y está agotado; otro da 18 y le sobra tiempo. Y hay un curso, el 8B, sin profesor de matemáticas desde la primera semana. Nadie se equivocó con mala intención: <strong>la carga académica se armó "a ojo"</strong>, sin una vista que cruce, a la vez, cuántas horas tiene cada docente, cuántas puede tener y qué parte del plan de estudios queda sin cubrir.</p>
<p>Este artículo propone un <a href="/descargas/carga-academica/carga-academica-docente.xlsx">libro de Excel</a> para revisar la asignación académica con cuatro indicadores, con seis docentes y seis grupos ficticios, verificado en Microsoft Excel 16 y contra un cálculo independiente. Normas revisadas el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios y el libro es una herramienta de revisión, no de decisión: distribuir la carga es una decisión del rector, con criterios pedagógicos, de formación y de contratación, y debe cumplir la norma y las instrucciones de tu secretaría de educación. Esta plantilla aplica al caso de <strong>secundaria y media en establecimientos estatales</strong>; en preescolar y primaria la regla es distinta (ver abajo). No es asesoría jurídica.</p>

<h2>Qué dice la norma colombiana</h2>
<p>El Decreto 1850 de 2002 (compilado luego en el Decreto 1075 de 2015) reglamenta la organización de la jornada escolar y la jornada laboral de directivos docentes y docentes de los establecimientos estatales de educación formal. Según el texto consultado el 10 de octubre de 2026 en el Gestor Normativo de la Función Pública:</p>
<ul>
<li><strong>Asignación académica (art. 5):</strong> es el tiempo de clase en que el docente atiende directamente a sus estudiantes. En preescolar y básica primaria es <strong>igual a la jornada escolar</strong> de la institución. En básica secundaria y media es de <strong>22 horas efectivas semanales de 60 minutos</strong>, distribuidas por el rector en períodos de clase.</li>
<li><strong>Dirección de grupo (art. 6):</strong> todos los docentes y directivos orientan a sus estudiantes; en secundaria y media, la dirección de grupo no reduce las 22 horas.</li>
<li><strong>Distribución (art. 7):</strong> el rector fija el horario diario de cada docente, separando la asignación académica de las actividades curriculares complementarias.</li>
<li><strong>Jornada laboral (art. 11):</strong> dedicación mínima de 8 horas diarias, de las cuales al menos 6 se cumplen en el establecimiento (asignación académica y actividades complementarias); el resto puede cumplirse dentro o fuera de la institución.</li>
</ul>
<p>Hay matices que conviene confirmar con tu secretaría: la forma de contar horas (de 60 minutos efectivos frente a periodos de 45 o 50), las excepciones por cargos o por modelos educativos y la situación de los colegios privados, que se rigen por su contrato y su reglamento. Por eso el libro deja el tope como un <strong>parámetro editable</strong>.</p>

{{img:indicadores}}
<h2>Cuatro indicadores para revisar la carga</h2>
<ol>
<li><strong>Horas asignadas:</strong> la suma de las horas semanales de todas las asignaciones del docente.</li>
<li><strong>Diferencia con el tope:</strong> horas asignadas menos el máximo. Positiva, el docente excede; muy negativa, hay espacio o se está subutilizando.</li>
<li><strong>Preparaciones:</strong> cuántas asignaturas distintas prepara. Dar 22 horas de una sola asignatura no es lo mismo que dar 22 horas repartidas en cuatro: cada preparación suma trabajo fuera del aula.</li>
<li><strong>Cobertura del plan:</strong> por cada grupo y asignatura, las horas que exige el plan de estudios menos las horas asignadas. Es el indicador que más se olvida.</li>
</ol>
<pre><code>' Horas asignadas por docente (hoja Asignaciones, columnas A = docente y D = horas)
=SUMAR.SI.CONJUNTO(Asignaciones!$D$2:$D$32;Asignaciones!$A$2:$A$32;A2)    ' español
=SUMIFS(Assignments!$D$2:$D$32,Assignments!$A$2:$A$32,A2)                  ' inglés

' Asignaturas distintas que prepara (cuenta cada una una sola vez)
=SUMAPRODUCTO((Asignaciones!$A$2:$A$32=A2)/CONTAR.SI.CONJUNTO(Asignaciones!$A$2:$A$32;Asignaciones!$A$2:$A$32;Asignaciones!$B$2:$B$32;Asignaciones!$B$2:$B$32))
=SUMPRODUCT((Assignments!$A$2:$A$32=A2)/COUNTIFS(Assignments!$A$2:$A$32,Assignments!$A$2:$A$32,Assignments!$B$2:$B$32,Assignments!$B$2:$B$32))

' Horas sin cubrir de un grupo y asignatura (nunca negativas)
=MAX(0;C2-D2)    ' español   ·   =MAX(0,C2-D2)    ' inglés</code></pre>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
{{img:carga}}
<p>Seis docentes, seis grupos de secundaria (6A a 8B) y un plan de 25 horas por grupo (150 horas en total):</p>
<ul>
<li><strong>Horas asignadas: 133.</strong> Cargas de 25, 24, 22, 22, 22 y 18 horas. Dos docentes exceden el máximo de 22 (por 3 y 2 horas, 5 horas en total) y uno queda por debajo del umbral de revisión de 20.</li>
<li><strong>Horas sin cubrir: 17</strong>, en seis combinaciones grupo-asignatura: matemáticas, ciencias naturales y artes del 8B, y tecnología de 7A, 7B y 8A.</li>
<li><strong>La paradoja:</strong> hay horas excedidas y horas sin docente a la vez. Con un tope de 22, cubrir 150 horas exige al menos 7 docentes (150 ÷ 22 = 6,8); con seis solo alcanzan 132. Redistribuir ayuda (el docente de 18 puede absorber 4 horas y bajarle carga a quien excede), pero <strong>no alcanza para cerrar la brecha de 17 horas: falta contratar</strong> o reducir el plan.</li>
<li>El docente 6 tiene la carga más baja en horas, pero <strong>da clase a 287 estudiantes</strong> (la suma de los estudiantes de cada asignación), el valor más alto de los seis, porque educación física y artes pasan por todos los grupos. Las horas no cuentan toda la carga: también importa a cuántos estudiantes hay que evaluar.</li>
</ul>
<p><strong>Una lectura honesta:</strong> el libro no sabe de formación, experiencia, horarios cruzados ni cargos con reducción. Un docente con 22 horas puede estar mejor repartido que otro con 20. Sirve para ver el panorama y hacer las preguntas correctas, no para decidir. Para revisar también los cruces de horario y las ventanas, mira la <a href="/auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas/">auditoría del horario escolar</a>.</p>

<h2>Cómo usar el libro</h2>
<ol>
<li><strong>Plan:</strong> escribe las horas semanales por asignatura y grupo, según el plan de estudios del colegio.</li>
<li><strong>Asignaciones:</strong> una fila por docente, asignatura y grupo, con las horas y el número de estudiantes.</li>
<li><strong>Parametros:</strong> el tope (22 en el ejemplo) y el umbral por debajo del cual se revisa.</li>
<li><strong>Resultados y Cobertura:</strong> revisa a quién se le excede, a quién le sobra espacio y qué combinaciones no tienen docente. El Resumen reúne los conteos.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La carga docente es un tema de política educativa en todo el mundo. Las encuestas internacionales de docentes de la OCDE (TALIS) reportan sistemáticamente que las horas de enseñanza y las demás tareas varían mucho entre países, y que el tiempo de preparación, evaluación y gestión se suma a las horas de clase. En América Latina, los tiempos de clase frente a los de preparación varían por país y sector (público o privado), y en muchos sistemas el tiempo no lectivo es un reclamo gremial. En Colombia, el tope de 22 horas de clase es un mínimo de referencia para el sector estatal en secundaria y media, mientras que en primaria el docente atiende todo el grupo durante la jornada.</p>
<p>Cada actor lo ve distinto. Para los <strong>docentes</strong>, la carga es horas, grupos, preparaciones y calificaciones. Para los <strong>directivos</strong>, es una restricción de contratación y presupuesto: ver el <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">presupuesto ejecutado, comprometido y disponible</a>. Para las <strong>familias</strong>, es el docente que falta o cambia a mitad de año. Y para los <strong>estudiantes</strong>, es la continuidad de la clase. Una asignación transparente y verificable evita que la carga se decida por costumbre o por cercanía.</p>

<h2>Herramientas y plantillas</h2>
<p>Si trabajas con las plantillas de Excel del sitio y quieres apoyo, o preparas material con IA (revisando siempre lo que produce y sin incluir datos personales de docentes o estudiantes en herramientas que no estén diseñadas para custodiarlos), mira estos productos.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: el <a href="/descargas/carga-academica/carga-academica-docente.xlsx">libro de carga académica</a>, la <a href="/auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas/">auditoría de horarios</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuántas horas de clase puede dar un docente en Colombia?</h3>
<p>En establecimientos estatales de básica secundaria y media, la asignación académica es de 22 horas efectivas semanales de 60 minutos (Decreto 1850 de 2002, art. 5). En preescolar y primaria es igual a la jornada escolar. Confirma las reglas con tu secretaría de educación.</p>
<h3>¿La dirección de grupo reduce las 22 horas?</h3>
<p>No en secundaria y media, según el art. 6 del mismo decreto.</p>
<h3>¿Y en los colegios privados?</h3>
<p>Se rigen por el contrato de trabajo y el reglamento, no por la asignación del sector estatal. El libro sirve igual con otro tope.</p>
<h3>¿Por qué contar las preparaciones?</h3>
<p>Porque cada asignatura distinta suma planeación, materiales y evaluaciones; 22 horas de una asignatura no son lo mismo que 22 repartidas en cuatro.</p>
<h3>¿Cómo cambio el tope en el libro?</h3>
<p>En la hoja Parametros, celda B3; el resto se recalcula.</p>

<p class="notice"><strong>Revisa tu asignación antes de que empiece el año.</strong> Descarga el <a href="/descargas/carga-academica/carga-academica-docente.xlsx">libro de carga académica</a>, reemplaza los datos ficticios por los de tu colegio y mira primero las horas sin cubrir.</p>

<h2>Para pensar</h2>
<p>Cuando la carga se reparte "como siempre", lo que no está en la planilla se paga con tiempo invisible: el del docente que prepara cuatro asignaturas y el del curso que espera a un profesor. <strong>¿Qué tiempo del docente no aparece hoy en la asignación (preparar, evaluar, atender familias, acompañar) y cómo cambiaría la distribución si lo contáramos? Y, si faltan horas, ¿qué decisión es más justa para los estudiantes: sobrecargar a quienes ya están, reducir el plan o contratar?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:indicadores}}' => $img('carga-academica-indicadores', 499, 'Tabla con cuatro indicadores de la carga docente, qué responde cada uno y cómo se calcula: horas asignadas, diferencia con el tope, preparaciones y cobertura del plan.', 'Cuatro indicadores de la carga docente.'),
    '{{img:carga}}' => $img('carga-academica-carga', 524, 'Gráfico de barras con las horas asignadas a seis docentes ficticios: 25, 24, 22, 22, 22 y 18; el tope es 22.', 'Horas asignadas por docente: dos sobre el tope y uno por debajo.'),
]);

return [
    'slug' => 'carga-academica-docente-excel-quien-excede-quien-sobra-que-falta',
    'title' => 'Carga académica docente en Excel: quién excede, a quién le sobra espacio y qué horas quedan sin cubrir',
    'excerpt' => 'Cómo revisar la asignación académica con cuatro indicadores (horas, diferencia con el tope, preparaciones y cobertura del plan), con la norma colombiana y un libro de Excel verificado con seis docentes ficticios.',
    'seo_title' => 'Carga académica docente en Excel: asignación y cobertura',
    'seo_description' => 'Cómo revisar la carga académica docente en Excel: 22 horas (Decreto 1850), diferencia con el tope, preparaciones y horas sin cubrir, con libro verificado.',
    'focus_keyword' => 'carga académica docente en Excel',
    'cover' => '/assets/img/articulos/carga-academica/carga-academica-portada',
    'cover_alt' => 'Portada "Carga académica docente en Excel: quién excede, quién sobra y qué falta" con una tarjeta: 17 horas del plan sin docente, aunque 2 de 6 docentes exceden el máximo de 22 horas.',
    'published_at' => '2027-02-18 12:00:00',
    'content_html' => $html,
];
