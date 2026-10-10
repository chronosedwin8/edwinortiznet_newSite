<?php

declare(strict_types=1);

// "Auditar el horario escolar en Excel". Decreto 1850 de 2002 (intensidad horaria 25 h primaria / 30 h secundaria y media; asignación de docentes 22 h en secundaria y media), compilado en el Decreto 1075 de 2015; verificado el 10-oct-2026 en el Gestor Normativo de la Función Pública (fuente consultada vía búsqueda). Libro verificado en Excel 16 y en Python: 91 clases; 1 choque de docente, 1 de aula, 1 de grupo; Ruiz 26 h (exceso 4); 29 ventanas.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/auditoria-horarios/' . $name;
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
<p>Es la primera semana de clases y el horario ya tiene problemas: el profesor de matemáticas aparece en dos salones a la misma hora, el laboratorio está asignado a dos grupos, y un grupo tiene dos materias en la misma franja. Nadie lo vio al armarlo, porque el horario de un colegio es una tabla de cientos de filas que cambia cada vez que se mueve una clase. <strong>Revisar a ojo un horario escolar es la forma más segura de dejar pasar un choque.</strong></p>
<p>Este artículo muestra cómo <strong>auditar un horario escolar en Excel</strong>: detectar choques de docente, de aula y de grupo, medir la carga semanal de cada docente frente a un límite y contar las "ventanas" (huecos) en su día. Incluye un <a href="/descargas/auditoria-horarios/auditoria-horario-escolar.xlsx">libro descargable</a> con un horario ficticio de tres grupos y 91 clases, con resultados verificados en Microsoft Excel 16 y contra un cálculo independiente en Python. Normas y datos revisados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> El libro <strong>audita</strong> un horario ya armado; no lo genera ni lo optimiza. Los datos son ficticios. Un horario sin choques no es necesariamente un buen horario: faltan consideraciones pedagógicas, de espacios, de transporte y de normatividad laboral que decide cada institución. Las referencias normativas deben verificarse en su versión vigente.</p>

<h2>Por qué es mejor auditar que "revisar"</h2>
<p>Armar un horario sin ningún conflicto es un problema difícil: en ciencias de la computación, el problema general de elaborar horarios con restricciones es de una clase (NP-completa) para la que no se conocen métodos rápidos que garanticen la mejor solución, y por eso los programas especializados usan heurísticas. Pero <strong>verificar</strong> un horario ya armado es un problema mucho más fácil: basta contar, para cada día y franja, cuántas veces aparece cada docente, cada aula y cada grupo. Ese conteo es lo que Excel hace bien.</p>
{{img:controles}}

<h2>El libro, hoja por hoja</h2>
<p>La hoja <em>Horario</em> tiene una fila por clase: día, franja (1 a 6), grupo, materia, docente y aula. Las celdas amarillas son datos; el resto son fórmulas. Para cada fila, el libro arma tres claves uniendo el día, la franja y el recurso, y cuenta cuántas veces se repite cada clave:</p>
<pre><code>' Clave docente: día | franja | docente
=SI(A2="";"";A2&"|"&B2&"|"&E2)                  ' español
=IF(A2="","",A2&"|"&B2&"|"&E2)                  ' inglés

' ¿La clave se repite? Si aparece más de una vez, el docente está en dos lugares
=SI(CONTAR.SI($G$2:$G$300;G2)>1;"Sí";"")         ' español
=IF(COUNTIF($G$2:$G$300,G2)>1,"Sí","")           ' inglés

' Para contar cada choque una sola vez (no una vez por fila):
=SI(J2="Sí";1/CONTAR.SI($G$2:$G$300;G2);0)       ' y luego se suma la columna</code></pre>
<p>El truco del último bloque merece explicación: si dos filas chocan, cada una vale 1/2 y la suma da 1 choque; si tres filas chocan, cada una vale 1/3 y la suma sigue dando 1. Así el resumen cuenta <strong>choques</strong> y no filas. Lo mismo se hace con el aula y con el grupo.</p>
<p>La hoja <em>Docentes</em> cuenta las horas semanales de cada docente (<code>CONTAR.SI</code>), las compara con un límite editable y calcula el exceso. La hoja <em>Ventanas</em> calcula, por docente y por día, los huecos entre su primera y su última clase:</p>
<pre><code>' Ventanas de un docente en un día = (última franja − primera franja + 1) − número de clases
=MAX.SI.CONJUNTO(franjas; docentes; docente; días; día)
 - MIN.SI.CONJUNTO(franjas; docentes; docente; días; día) + 1
 - CONTAR.SI.CONJUNTO(docentes; docente; días; día)</code></pre>
<p><code>MAX.SI.CONJUNTO</code> y <code>MIN.SI.CONJUNTO</code> (<code>MAXIFS</code> y <code>MINIFS</code>) están en Excel 2019 y Microsoft 365; en versiones anteriores hay que usar fórmulas matriciales.</p>

<h2>Lo que encontró la auditoría (horario ficticio)</h2>
<p>El horario de ejemplo tiene tres grupos de secundaria (7A, 7B y 8A), seis franjas por día y 30 clases semanales por grupo. Se generó sin conflictos y luego se sembraron tres a propósito, más una sobrecarga. El libro encontró:</p>
<ul>
<li><strong>Choque de docente:</strong> el lunes en la franja 2, el profesor Ruiz aparece en 7A (matemáticas) y en 7B (sociales, que corresponde a otra docente). Un error de digitación que asigna al docente equivocado.</li>
<li><strong>Choque de aula:</strong> el miércoles en la franja 3, el laboratorio está asignado a 7B y a 8A al mismo tiempo.</li>
<li><strong>Choque de grupo:</strong> el martes en la franja 4, el grupo 7A tiene dos clases a la vez (sociales y tecnología).</li>
<li><strong>Carga:</strong> el profesor Ruiz acumula 26 horas semanales frente a un límite de 22, un exceso de 4 horas (sus 24 horas de matemáticas, tecnología y ética más las dos filas erróneas).</li>
<li><strong>Ventanas:</strong> 29 huecos en la semana entre todos los docentes, entre 0 (la docente de religión, con una sola hora) y 6 por docente.</li>
</ul>
<p>Resultado del resumen: 91 clases, 1 choque de docente, 1 de aula, 1 de grupo, 6 filas marcadas "Conflicto" (dos por cada choque), 1 docente por encima del límite y 29 ventanas. Todo coincide con el cálculo independiente en Python.</p>
{{img:pasos}}

<h2>Sobre el límite de horas: qué dice el Decreto 1850 de 2002</h2>
<p>La intensidad horaria mínima para los estudiantes es de 25 horas semanales en básica primaria y 30 en básica secundaria y media (horas de 60 minutos). En cuanto a los docentes, la asignación académica (tiempo de atención directa a los estudiantes) en preescolar y primaria equivale a la jornada escolar, y en secundaria y media es de <strong>22 horas efectivas de 60 minutos semanales</strong>. Esas reglas están en el Decreto 1850 de 2002, hoy compilado en el Decreto Único Reglamentario 1075 de 2015. Por eso el libro trae el límite de 22 horas como valor editable: ajústalo al caso de tu institución y a las normas que apliquen a cada docente (por ejemplo, la dirección de grupo no reduce la asignación de 22 horas en secundaria y media, según el mismo decreto). La figura de "permanencia" de 30 horas es distinta y depende de la normativa y la organización de cada institución.</p>

<h2>Cómo usar el libro con tu horario</h2>
<ol>
<li><strong>Exporta el horario</strong> a una tabla con una fila por clase. Si tu programa de horarios genera una matriz (grupos por franjas), conviértela en lista; el libro admite hasta 299 filas, y se amplía copiando las fórmulas hacia abajo.</li>
<li><strong>Pega los datos</strong> en las columnas A a F de <em>Horario</em> (y reemplaza la lista de docentes en <em>Docentes</em>).</li>
<li><strong>Lee el resumen:</strong> los choques primero, luego la carga y las ventanas.</li>
<li><strong>Filtra "Conflicto"</strong> en la columna de estado y corrige.</li>
<li><strong>Vuelve a auditar</strong> después de cada cambio: mover una clase suele crear otro choque.</li>
</ol>
<p>Si el colegio ya usa una base de datos o un programa de horarios que valida choques, esta auditoría sirve como segunda mirada independiente, especialmente después de cambios de última hora. Y si el horario crece mucho, vale la pena preguntarse si Excel sigue siendo la herramienta (ver <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">cuándo Excel deja de ser la solución</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el horario se arma dentro de las reglas de la intensidad horaria y la asignación académica, con la complicación de que muchas instituciones comparten sedes, jornadas y docentes (colegios con jornada mañana y tarde, sedes rurales con docentes que se desplazan). En la región, la organización del tiempo escolar varía mucho: jornadas únicas, dobles, semipresenciales; en el mundo, el horario es una de las decisiones de gestión que más afecta a docentes y estudiantes, y su elaboración se apoya en programas especializados que aun así requieren verificación. Para los <strong>directivos</strong>, auditar el horario antes de publicarlo evita el caos de la primera semana; para los <strong>docentes</strong>, saber que su carga y sus huecos se miden con un criterio claro reduce la sensación de arbitrariedad; para las <strong>familias</strong>, un horario sin choques es un colegio más predecible; y para los <strong>estudiantes</strong>, evita quedarse sin clase o con dos a la vez. Un horario es también una decisión sobre cómo se valora el tiempo de unos y otros: vale la pena mirar quién carga con más ventanas y quién con más horas seguidas.</p>

<h2>Plantillas y herramientas</h2>
<p>Si prefieres partir de plantillas de Excel con soporte, o necesitas organizar la asistencia del personal, mira estas opciones. Y para pedir a una IA ayuda con tus fórmulas (verificando siempre el resultado y sin pegar datos personales), hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL! y #VALUE!</a>, <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">un dashboard que ayude a actuar</a> y <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">promedios en Excel: siete errores</a>. Para quienes preparan el concurso, ver <a href="/herramientas/simulacro-concurso-docente/">la herramienta de simulacro</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿El libro arma el horario?</h3>
<p>No. Audita uno ya armado: detecta choques, carga y ventanas. Armar el horario es un problema distinto y más difícil.</p>
<h3>¿Cómo detecto que un docente está en dos lugares a la vez?</h3>
<p>Uniendo día, franja y docente en una clave y contando cuántas veces se repite: si aparece más de una vez, hay un choque. La fórmula es CONTAR.SI (COUNTIF).</p>
<h3>¿Cuántas horas puede tener un docente?</h3>
<p>Según el Decreto 1850 de 2002 (compilado en el 1075 de 2015), la asignación académica en secundaria y media es de 22 horas efectivas semanales; en preescolar y primaria equivale a la jornada escolar. Verifica la norma vigente y el caso de tu institución.</p>
<h3>¿Qué es una ventana en un horario?</h3>
<p>Una franja libre entre la primera y la última clase de un docente en un mismo día. Muchas ventanas pueden ser tiempo útil para planear, pero también tiempo perdido o una carga desigual.</p>
<h3>¿Funciona en versiones antiguas de Excel?</h3>
<p>Los choques y las horas, sí. Las ventanas usan MAX.SI.CONJUNTO y MIN.SI.CONJUNTO, que requieren Excel 2019 o Microsoft 365.</p>

<p class="notice"><strong>Audita tu horario.</strong> Descarga el <a href="/descargas/auditoria-horarios/auditoria-horario-escolar.xlsx">libro de auditoría</a>, pega tu horario en la hoja Horario y mira el resumen antes de publicarlo.</p>

<h2>Para pensar</h2>
<p>Un horario sin choques puede ser, aun así, injusto: algunos docentes con ventanas útiles y otros con el día partido en tres, algunos grupos con las materias exigentes a última hora. <strong>¿Quién decide qué es un horario "bueno" en tu colegio, y con qué criterios: los de la administración, los de los docentes o los del aprendizaje de los estudiantes? ¿Y quién se entera de cómo se repartieron las ventanas?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:controles}}' => $img('auditoria-horarios-controles', 553, 'Tabla con cinco controles de un horario escolar, la pregunta de cada uno y cómo se detecta: docente repetido, aula repetida, grupo repetido, carga del docente y ventanas.', 'Cinco controles, cinco fórmulas.'),
    '{{img:pasos}}' => $img('auditoria-horarios-pasos', 467, 'Cinco pasos para auditar un horario: ordenar, crear claves, detectar conflictos, medir carga y corregir.', 'De la tabla al diagnóstico en cinco pasos.'),
]);

return [
    'slug' => 'auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas',
    'title' => 'Auditar el horario escolar en Excel: choques de docente, aula y grupo, carga y ventanas (libro verificado)',
    'excerpt' => 'Un libro de Excel que audita un horario escolar ya armado: detecta docentes en dos lugares a la vez, aulas y grupos repetidos, mide la carga frente a un límite y cuenta las ventanas, con un ejemplo de 91 clases.',
    'seo_title' => 'Auditar el horario escolar en Excel: choques y carga',
    'seo_description' => 'Cómo auditar un horario escolar en Excel: choques de docente, aula y grupo, carga semanal frente al Decreto 1850 y ventanas, con libro de ejemplo.',
    'focus_keyword' => 'auditar horario escolar Excel',
    'cover' => '/assets/img/articulos/auditoria-horarios/auditoria-horarios-portada',
    'cover_alt' => 'Portada "Auditar el horario escolar en Excel: conflictos, carga y ventanas" con una tarjeta: 3 choques escondidos en un horario de 91 clases, de docente, de aula y de grupo.',
    'published_at' => '2027-01-14 12:00:00',
    'content_html' => $html,
];
