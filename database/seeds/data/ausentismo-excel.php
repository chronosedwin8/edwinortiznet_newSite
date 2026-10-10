<?php

declare(strict_types=1);

// "Ausentismo escolar en Excel". Fuentes consultadas el 10-oct-2026: definición de ausentismo crónico (10 % o más de los días matriculados, por cualquier motivo) de agencias educativas estatales de EE. UU.; Decreto 1290 de 2009 (compilado en el Decreto 1075 de 2015, art. 2.3.3.3.3.6: el SIEE define el porcentaje de asistencia que incide en la promoción; el MEN indica que ya no hay un porcentaje fijo nacional); Constitución art. 67. Libro verificado en Excel 16 y Python: asistencia 94,5 %, 22 ausencias, 5 crónicos, racha 5, viernes 7.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ausentismo-excel/' . $name;
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
<p>Cada mañana, el docente de dirección de grupo toma lista y anota "ausente". El día siguiente, otra vez. Al final del periodo, un estudiante ha faltado trece veces y nadie lo notó hasta que apareció en la comisión de evaluación. Lo que hace falta no es una lista más larga, sino <strong>una forma de leer la asistencia que muestre a tiempo quién necesita ayuda y qué patrón se esconde detrás</strong>.</p>
<p>Este artículo presenta cómo analizar el ausentismo escolar en Excel: asistencia del grupo, <strong>ausentismo crónico</strong>, rachas de ausencias seguidas y patrones por día de la semana. Incluye un <a href="/descargas/ausentismo-excel/ausentismo-escolar-excel.xlsx">libro descargable</a> con 20 estudiantes ficticios (identificados solo por código) durante 20 días hábiles, con resultados verificados en Microsoft Excel 16 y contra un cálculo independiente en Python. Fuentes y normas revisadas el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios; <strong>no uses nombres ni datos reales de estudiantes</strong> en herramientas que no estén diseñadas para custodiarlos, y respeta las reglas de protección de datos de tu institución. El ausentismo tiene causas diversas y casi nunca es un tema de "voluntad": el análisis sirve para ofrecer apoyo, no para etiquetar. Las consecuencias de la inasistencia en la promoción las define el sistema institucional de evaluación (SIEE) de cada colegio.</p>

<h2>Ausentismo, ausentismo crónico y deserción</h2>
<ul>
<li><strong>Ausentismo</strong> es la no asistencia a clase, justificada o no. Un estudiante enfermo está ausente, y su ausencia es legítima, pero igual afecta su aprendizaje.</li>
<li><strong>Ausentismo crónico.</strong> En la literatura y en varias autoridades educativas de Estados Unidos se define como faltar el <strong>10 % o más de los días</strong> en que el estudiante está matriculado, <strong>por cualquier motivo</strong> (justificado o no). Esa medida es distinta de la "inasistencia injustificada" y de la asistencia promedio diaria de la escuela: un colegio puede tener 95 % de asistencia promedio y, aun así, un grupo de estudiantes que faltan mucho, porque el promedio los esconde. El umbral del 10 % se usa también en los reportes federales de ese país, según resúmenes de agencias estatales; no es una norma colombiana.</li>
<li><strong>Deserción</strong> es el abandono del sistema educativo. El ausentismo sostenido suele ser una señal temprana: la deserción rara vez es un evento, casi siempre es un proceso. Por eso mirar las ausencias a tiempo es una herramienta de prevención.</li>
</ul>
<p><strong>Qué dice la norma colombiana sobre la inasistencia.</strong> La Constitución (art. 67) establece que la educación es obligatoria entre los cinco y los quince años, con un año de preescolar y nueve de educación básica como mínimo. En cuanto a las consecuencias de faltar, el Decreto 1290 de 2009 (hoy compilado en el Decreto 1075 de 2015, art. 2.3.3.3.3.6) dispone que cada establecimiento define en su SIEE los criterios de promoción, incluido el porcentaje de asistencia que incida en ella. Según información del Ministerio de Educación consultada para este artículo, ya no existe un porcentaje fijo de inasistencias que determine la repitencia a nivel nacional, y la regla del "25 %" que muchos recuerdan pertenece a normas anteriores; <strong>revisa el SIEE de tu colegio</strong> para saber qué se aplica allí. Además, cuando se determina que un estudiante no puede ser promovido, el establecimiento debe garantizarle el cupo para continuar sus estudios.</p>

<h2>El libro, hoja por hoja</h2>
<p>La hoja <em>Asistencia</em> es una matriz: un estudiante por fila y un día por columna, con códigos <strong>P</strong> (presente), <strong>A</strong> (ausente sin justificar), <strong>J</strong> (ausente justificado) y <strong>T</strong> (tardanza, que cuenta como presente). La hoja <em>Analisis</em> calcula, por estudiante, los días registrados, las ausencias sin justificar y justificadas, el porcentaje de asistencia, las tardanzas, la <strong>racha máxima</strong> de ausencias consecutivas y si supera el umbral de ausentismo crónico (editable, 10 % por defecto). La hoja <em>Resumen</em> agrega al grupo y cuenta las ausencias por día de la semana y por semana.</p>
{{img:lecturas}}
<pre><code>' Ausencias totales de un estudiante: sin justificar (A) más justificadas (J)
=CONTAR.SI(Asistencia!B4:U4;"A") + CONTAR.SI(Asistencia!B4:U4;"J")        ' español
=COUNTIF(Asistencia!B4:U4,"A") + COUNTIF(Asistencia!B4:U4,"J")            ' inglés

' ¿Ausentismo crónico? (ausencias / días registrados >= umbral)
=SI(E5/B5>=$E$2;"Sí";"No")                                                 ' español
=IF(E5/B5>=$E$2,"Sí","No")                                                 ' inglés

' Día de la semana en la cabecera (1 = lunes) y ausencias por día
=ELEGIR(DIASEM(B2;2);"L";"M";"X";"J";"V";"S";"D")
=SUMAPRODUCTO((Asistencia!$B$3:$U$3="V")*((Asistencia!$B$4:$U$23="A")+(Asistencia!$B$4:$U$23="J")))

' Racha: columnas auxiliares que suman 1 mientras la ausencia continúa y vuelven a 0 si hay presencia
=SI(O(celda="A";celda="J");racha_anterior+1;0)     ' y luego =MAX de la fila</code></pre>
<p>Una lección de configuración regional que aparece en este libro: en una fórmula con un criterio numérico escrito como texto, como <code>COUNTIFS(rango;"&lt;=0.95")</code>, el punto decimal funciona en una configuración regional y falla en otra (en es-CO, "0.95" se interpreta como texto y no coincide con el número). La forma segura es concatenar el número: <code>"&lt;="&amp;0,95</code>, que Excel convierte con el separador de la configuración regional del equipo (ver <a href="/compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional/">compatibilidad de libros de Excel entre equipos</a>).</p>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
<p>Con 20 estudiantes y 20 días hábiles (400 registros), el libro calculó:</p>
<ul>
<li><strong>Asistencia del grupo: 94,5 %</strong>, con 22 ausencias (12 sin justificar y 10 justificadas). Un número que, solo, parece tranquilizador.</li>
<li><strong>Ausentismo crónico: 5 de 20 estudiantes (25 %).</strong> Detrás hay historias muy distintas: un estudiante que falta <strong>todos los lunes</strong> (4 ausencias); otro con <strong>cinco días seguidos justificados</strong> (probablemente una enfermedad: racha máxima de 5); otro con <strong>tres viernes</strong>; otro con dos ausencias dispersas; y otro con dos días seguidos justificados.</li>
<li><strong>Patrón por día:</strong> viernes (7 ausencias, 31,8 %), lunes y jueves (5 cada uno, 22,7 %), miércoles (4) y martes (1). <strong>Lunes y viernes suman 12 de 22 ausencias (54,5 %)</strong>: un patrón que invita a preguntar por transporte, trabajo en fines de semana o desmotivación.</li>
<li><strong>Por semana:</strong> 6, 9, 4 y 3 ausencias; la segunda semana concentra la racha de cinco días.</li>
<li><strong>En atención (una sola ausencia):</strong> 6 estudiantes con entre 5 y 9 % de ausencias.</li>
</ul>
<p>Una advertencia importante sobre estos números: <strong>una ventana de cuatro semanas es muy corta</strong>. Con solo 20 días, una ausencia es 5 % y dos ausencias ya son 10 % (el umbral); por eso 5 de 20 cruzan la línea. En la práctica, el ausentismo crónico se mide durante todo el año o por periodos largos, y el análisis semanal sirve para <em>detectar tendencias y rachas</em>, no para etiquetar. El libro deja el umbral editable para que lo adaptes.</p>

<h2>Cinco pasos ante una ausencia que se repite</h2>
{{img:apoyo}}
<ol>
<li><strong>Detecta</strong> con el libro, cada semana: no esperes el fin de periodo.</li>
<li><strong>Entiende</strong> antes de juzgar: pregunta el motivo. Las causas habituales incluyen salud, transporte, trabajo o cuidado de familiares, conectividad en zonas rurales, desmotivación, dificultades de aprendizaje o situaciones de convivencia (ver <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflicto, indisciplina y violencia escolar</a>).</li>
<li><strong>Contacta a la familia</strong> con respeto, con un mensaje que ofrezca ayuda y no solo advierta consecuencias.</li>
<li><strong>Apoya:</strong> ajustes de horario o de transporte, apoyo social, coordinación con orientación escolar, plan de nivelación, y para estudiantes con barreras de aprendizaje, ver <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusión en el aula</a>.</li>
<li><strong>Haz seguimiento:</strong> vuelve al libro en dos semanas y mira si la asistencia mejora. Si hay indicios de vulneración de derechos, activa la ruta institucional.</li>
</ol>
<p>Hay una trampa conocida: <strong>no uses la asistencia como castigo ni como premio</strong>. Cuando los datos se usan solo para sancionar, las familias aprenden a justificar de cualquier manera y el dato pierde valor.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, la asistencia se registra en cada colegio y la matrícula se reporta a los sistemas del sector; la normativa deja a cada institución decidir cómo la considera en la promoción, lo que explica la variedad de reglas entre colegios. En la región, el ausentismo y la deserción se asocian con condiciones socioeconómicas, trabajo infantil, distancias en zonas rurales y violencia; en el mundo, la literatura sobre "ausentismo crónico" ha mostrado la utilidad de intervenir pronto con sistemas de alerta temprana y apoyo, más que con sanciones. Para los <strong>docentes</strong>, el desafío es registrar con rigor y sin estigmatizar; para los <strong>directivos</strong>, revisar el SIEE y las rutas de apoyo, y mirar los patrones colectivos (¿faltan más los lunes?, ¿en cierto grado?); para las <strong>familias</strong>, comunicar a tiempo los motivos; y para los <strong>estudiantes</strong>, sentirse esperados en el colegio. Si el libro crece (varios grupos, todo el año), conviene preguntarse si Excel sigue siendo la herramienta (ver <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">cuándo Excel deja de ser la solución</a>).</p>

<h2>Plantillas y herramientas</h2>
<p>Si prefieres partir de una plantilla de asistencia ya armada, con soporte, mira estas opciones. Y para pedir a una IA ayuda con tus fórmulas (verificando siempre el resultado y sin pegar datos de estudiantes en herramientas gratuitas), hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">un dashboard que ayude a actuar</a>, <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">promedios en Excel: siete errores</a> y <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL! y #VALUE!</a>. Para quienes preparan el concurso, ver <a href="/herramientas/simulacro-concurso-docente/">la herramienta de simulacro</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es el ausentismo crónico?</h3>
<p>Faltar el 10 % o más de los días de clase en que el estudiante está matriculado, por cualquier motivo (justificado o no). Es una definición usada en la literatura y por varias autoridades educativas de Estados Unidos, no una norma colombiana.</p>
<h3>¿Cuál es el porcentaje de inasistencia que hace perder el año en Colombia?</h3>
<p>No hay un porcentaje fijo nacional vigente: el Decreto 1290 de 2009 (compilado en el Decreto 1075 de 2015) dispone que cada colegio define en su SIEE los criterios de promoción, incluido el porcentaje de asistencia. Consulta el SIEE de tu institución.</p>
<h3>¿Cómo calculo el porcentaje de asistencia en Excel?</h3>
<p>Días registrados menos ausencias, dividido entre días registrados: =(B5-E5)/B5. El libro lo hace por estudiante y para el grupo.</p>
<h3>¿Cómo detecto ausencias consecutivas?</h3>
<p>Con una fila auxiliar que suma 1 mientras la ausencia continúa y vuelve a 0 con una presencia; el máximo de la fila es la racha. El libro lo incluye.</p>
<h3>¿Sirve una ventana de pocas semanas para medir ausentismo crónico?</h3>
<p>Con pocas semanas, una sola ausencia pesa mucho. Sirve para detectar patrones y rachas; el ausentismo crónico se evalúa en periodos largos o en todo el año.</p>

<p class="notice"><strong>Mira tu asistencia de esta semana.</strong> Descarga el <a href="/descargas/ausentismo-excel/ausentismo-escolar-excel.xlsx">libro de ausentismo</a>, reemplaza los códigos del ejemplo por los de tu grupo y mira primero las rachas y los días de la semana con más ausencias.</p>

<h2>Para pensar</h2>
<p>Un estudiante que falta tres viernes seguidos nos dice algo, aunque no sepamos qué. <strong>¿Qué haría tu colegio hoy si descubriera que la mitad de las ausencias caen en lunes y viernes: llamar a las familias a reclamar o preguntar qué les dificulta llegar? Y cuando un estudiante deja de venir, ¿cuánto tiempo pasa antes de que alguien lo note, y quién es ese alguien?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:lecturas}}' => $img('ausentismo-excel-lecturas', 499, 'Tabla con cuatro indicadores de asistencia, qué dice y qué esconde cada uno: asistencia del grupo, ausentismo crónico, rachas y patrón por día.', 'Qué mide cada indicador y qué esconde.'),
    '{{img:apoyo}}' => $img('ausentismo-excel-apoyo', 467, 'Cinco pasos ante una ausencia que se repite: detectar, entender, contactar a la familia, apoyar y hacer seguimiento.', 'Del dato al apoyo.'),
]);

return [
    'slug' => 'ausentismo-escolar-excel-asistencia-ausentismo-cronico-rachas-patrones',
    'title' => 'Ausentismo escolar en Excel: asistencia, ausentismo crónico, rachas y patrones por día (libro verificado)',
    'excerpt' => 'Cómo analizar la asistencia escolar en Excel para detectar a tiempo el ausentismo crónico, las rachas y los patrones por día de la semana, con un libro de ejemplo verificado y pasos para apoyar al estudiante y a su familia.',
    'seo_title' => 'Ausentismo escolar en Excel: asistencia y rachas',
    'seo_description' => 'Analiza el ausentismo escolar en Excel: asistencia, ausentismo crónico (10 %), rachas y patrones por día, con libro verificado y pasos de apoyo.',
    'focus_keyword' => 'ausentismo escolar en Excel',
    'cover' => '/assets/img/articulos/ausentismo-excel/ausentismo-excel-portada',
    'cover_alt' => 'Portada "Ausentismo escolar en Excel: detectar patrones antes de que sea deserción" con una tarjeta: 12 de 22 ausencias caen en lunes o viernes en el ejemplo.',
    'published_at' => '2027-01-21 12:00:00',
    'content_html' => $html,
];
