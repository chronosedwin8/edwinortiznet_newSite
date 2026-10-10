<?php

declare(strict_types=1);

// "El SIEE y el Decreto 1290". Fuente: texto compilado del Decreto 1075 de 2015, arts. 2.3.3.3.3.1 a 2.3.3.3.3.18 (origen: Decreto 1290 de 2009; arts. 1 y 6 modificados por el Decreto 1421 de 2017), consultado el 10-oct-2026 (versión de la Administradora Colombiana de Pensiones). Conversor verificado en Excel 16 y con redondeo half-up independiente: 5 de 12 estudiantes cambian de desempeño; con nota redondeada 2 Superior, 4 Alto, 4 Básico, 2 Bajo. Casos de práctica no oficiales; cortes ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/siee-decreto-1290/' . $name;
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
<p>"En este colegio con 2,95 se pierde." "No, con 2,95 se redondea a 3,0 y se pasa." Dos docentes del mismo colegio, con el mismo reglamento en la mano, y dos respuestas distintas. Lo que está en juego es la nota de un estudiante, y la respuesta correcta no depende de la opinión de nadie sino de lo que diga <strong>el sistema institucional de evaluación de los estudiantes (SIEE)</strong> de ese colegio, dentro del marco que fija el Decreto 1290 de 2009, hoy compilado en el Decreto Único Reglamentario 1075 de 2015.</p>
<p>Este artículo estudia ese marco con la estructura <strong>norma (con su fuente) + interpretación + caso con respuesta justificada</strong>. Incluye una <a href="/descargas/concurso-docente/ficha-estudio-siee-decreto-1290.xlsx">ficha de estudio en Excel</a> con el mapa de los artículos, los 11 componentes del SIEE (con una lista para revisar si tu colegio los tiene), un <strong>conversor de notas a la escala nacional</strong> que muestra cómo el redondeo cambia el desempeño de un estudiante, y doce tarjetas. Textos del Decreto 1075 consultados el 10 de octubre de 2026; el conversor se verificó en Microsoft Excel 16 y contra un cálculo independiente.</p>
<p class="notice"><strong>Advertencias.</strong> Los resúmenes son míos, no literales: <strong>la fuente es el texto vigente</strong> del Decreto 1075 de 2015 (Presidencia, Ministerio de Educación, Función Pública). Algunos artículos de esta sección fueron modificados por el Decreto 1421 de 2017. Las preguntas de un concurso se basan en lo que indiquen la convocatoria y su anexo técnico en SIMO. Los casos y los cortes del conversor son <strong>ejercicios míos, no preguntas oficiales ni reglas de ningún colegio</strong>; el SIEE real de cada colegio define sus propias reglas. Esto no es asesoría jurídica ni garantiza resultados.</p>

<h2>Qué se evalúa y dónde: los tres ámbitos</h2>
<p>Según el artículo 2.3.3.3.3.1 (origen: Decreto 1290, art. 1; modificado por el Decreto 1421 de 2017), la evaluación de los aprendizajes se da en tres ámbitos: el <strong>internacional</strong> (pruebas frente a estándares internacionales), el <strong>nacional</strong> (pruebas censales del Ministerio de Educación y el ICFES, con fundamento en los estándares básicos, y los exámenes de Estado al finalizar el grado once) y el <strong>institucional</strong>: el proceso permanente y objetivo para valorar el nivel de desempeño de los estudiantes en los colegios. La sección se ocupa de este último y de la promoción (art. 2.3.3.3.3.2).</p>
<p><strong>Propósitos</strong> (art. 2.3.3.3.3.3): identificar características, intereses, ritmos de desarrollo y estilos de aprendizaje; proporcionar información para consolidar o reorientar los procesos educativos; apoyar a los estudiantes con debilidades y con desempeños superiores; determinar la promoción; y aportar al plan de mejoramiento institucional. Es decir, la evaluación no es solo para calificar: sirve para decidir cómo enseñar.</p>

<h2>El SIEE: qué debe contener</h2>
<p>El artículo 2.3.3.3.3.4 dice que el sistema de evaluación institucional, que hace parte del PEI, debe contener <strong>once componentes</strong>:</p>
<ol>
<li>Los criterios de evaluación y promoción.</li>
<li>La escala de valoración institucional y su equivalencia con la escala nacional.</li>
<li>Las estrategias de valoración integral de los desempeños.</li>
<li>Las acciones de seguimiento para el mejoramiento durante el año escolar.</li>
<li>Los procesos de autoevaluación de los estudiantes.</li>
<li>Las estrategias de apoyo para resolver situaciones pedagógicas pendientes.</li>
<li>Las acciones para garantizar que directivos y docentes cumplan los procesos evaluativos del SIEE.</li>
<li>La periodicidad de entrega de informes a los padres.</li>
<li>La estructura de los informes (claros, comprensibles e integrales).</li>
<li>Las instancias, procedimientos y mecanismos de atención y resolución de reclamaciones de padres y estudiantes.</li>
<li>Los mecanismos de participación de la comunidad educativa en la construcción del sistema.</li>
</ol>
<p>La hoja <em>SIEE_11</em> de la ficha trae esta lista para que marques cuáles encuentras en el SIEE de tu colegio y dónde; un buen ejercicio, que además sirve para la prueba, es verificar los once en un documento real.</p>

<h2>La escala nacional y la escala propia</h2>
<p>Cada colegio define y adopta su escala de valoración (numérica, de letras, conceptual), pero debe expresar su <strong>equivalencia con la escala nacional</strong> para facilitar la movilidad de los estudiantes: <strong>Desempeño Superior, Alto, Básico y Bajo</strong> (art. 2.3.3.3.3.5). El desempeño básico se entiende como la superación de los desempeños necesarios en las áreas obligatorias y fundamentales, con referentes en los estándares básicos, las orientaciones del Ministerio y el PEI; el desempeño bajo, como la no superación de los mismos. Ojo con lo que <strong>no</strong> dice la norma: no fija cortes numéricos (por ejemplo, que 3,0 sea el límite del Básico) ni una regla de redondeo. Eso lo define cada SIEE.</p>
{{img:niveles}}
<h3>El conversor: cuando el redondeo cambia el desempeño</h3>
<p>La hoja <em>Conversor</em> de la ficha usa cortes de ejemplo para una escala de 1,0 a 5,0 (Bajo desde 1,0; Básico desde 3,0; Alto desde 4,0; Superior desde 4,6; ficticios) y un número de decimales de redondeo editable. Con 12 estudiantes de ejemplo, el desempeño que se obtiene con la nota sin redondear no siempre coincide con el que se obtiene con la nota redondeada a un decimal:</p>
<ul>
<li>2,95 y 2,96: <strong>Bajo</strong> sin redondear, <strong>Básico</strong> al redondear a 3,0.</li>
<li>3,95 y 3,96: <strong>Básico</strong> sin redondear, <strong>Alto</strong> al redondear a 4,0.</li>
<li>4,55: <strong>Alto</strong> sin redondear, <strong>Superior</strong> al redondear a 4,6.</li>
</ul>
<p>Resultado: <strong>5 de los 12 estudiantes cambian de desempeño según el redondeo</strong>, y con la nota redondeada el grupo queda en 2 Superior, 4 Alto, 4 Básico y 2 Bajo. La enseñanza para el docente: la regla de redondeo (si se aplica, cuándo, a cuántos decimales y sobre qué nota) debe estar escrita en el SIEE y aplicarse igual para todos; una nota que se ve 3,0 en el informe pero que "vale" 2,95 es una fuente de reclamaciones. Para el detalle de este error en Excel, ver <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">promedios en Excel: siete errores</a>.</p>

<h2>Promoción, asistencia y cupo</h2>
<p>Según el artículo 2.3.3.3.3.6 (modificado por el Decreto 1421 de 2017), cada establecimiento determina los criterios de promoción de acuerdo con su SIEE y <strong>define el porcentaje de asistencia que incida en la promoción</strong>. Cuando determine que un estudiante no puede ser promovido al grado siguiente, <strong>debe garantizarle, en todos los casos, el cupo</strong> para que continúe su proceso formativo. La promoción de estudiantes con discapacidad se rige por las mismas disposiciones, con flexibilización curricular basada en la valoración pedagógica, la trayectoria, el proyecto de vida y las competencias desarrolladas (a esto vuelve la serie en el artículo sobre el Decreto 1421 de 2017). Sobre la asistencia como indicador, ver <a href="/ausentismo-escolar-excel-asistencia-ausentismo-cronico-rachas-patrones/">ausentismo escolar en Excel</a>.</p>
<p>La <strong>promoción anticipada</strong> (art. 2.3.3.3.3.7): durante el primer periodo, el consejo académico, con consentimiento de los padres, recomienda al consejo directivo la promoción anticipada de un estudiante con rendimiento superior en el desarrollo cognitivo, personal y social en el marco de las competencias básicas; la decisión se consigna en el acta del consejo directivo y, si es positiva, en el registro escolar. Los colegios también deben adoptar criterios para facilitar la promoción de quienes no la obtuvieron el año anterior.</p>

<h2>Crear o modificar el SIEE: un procedimiento</h2>
{{img:creacion}}
<p>El artículo 2.3.3.3.3.8 establece siete pasos mínimos: (1) definir el SIEE; (2) socializarlo con la comunidad educativa; (3) <strong>aprobarlo en sesión del consejo directivo y consignarlo en el acta</strong>; (4) incorporarlo al PEI, articulándolo con las necesidades de los estudiantes, el plan de estudios y el currículo; (5) divulgarlo; (6) divulgar los procedimientos de reclamación; y (7) informar sobre el sistema a los nuevos estudiantes, padres y docentes que ingresen en cada periodo. <strong>Para modificarlo se sigue el mismo procedimiento.</strong> A su vez, el artículo 2.3.3.3.3.11, sobre las responsabilidades del establecimiento, indica que este debe definir, adoptar y divulgar el SIEE "después de su aprobación por el consejo académico", incorporar sus criterios al PEI y servir, a través del consejo directivo, de instancia para decidir las reclamaciones sobre evaluación o promoción. Los dos artículos conviven: el consejo académico participa en la construcción y la aprobación pedagógica, y el consejo directivo lo aprueba y lo adopta (ver <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">gobierno escolar</a>). Es un buen ejemplo de por qué se estudian los dos artículos y no solo el que se recuerda primero.</p>

<h2>Derechos y deberes de estudiantes y familias</h2>
<ul>
<li><strong>Estudiantes</strong> (arts. 2.3.3.3.3.12 y 2.3.3.3.3.13): derecho a ser evaluados integralmente (académica, personal y socialmente), a conocer el SIEE desde el inicio del año, a conocer los resultados y recibir respuesta oportuna a sus inquietudes y a recibir asesoría y acompañamiento para superar sus debilidades; deber de cumplir los compromisos académicos y de convivencia y los de superación.</li>
<li><strong>Padres de familia</strong> (arts. 2.3.3.3.3.14 y 2.3.3.3.3.15): derecho a conocer el SIEE, acompañar el proceso, recibir informes periódicos y respuestas oportunas; deber de participar en la definición de los criterios, hacer seguimiento permanente y analizar los informes.</li>
<li><strong>Registro, constancias y graduación</strong> (arts. 2.3.3.3.3.16 a 2.3.3.3.3.18): registro escolar actualizado, constancias de desempeño a solicitud de los padres y título de Bachiller Académico o Técnico cuando se cumplen todos los requisitos de promoción adoptados en el PEI.</li>
</ul>

<h2>Dos casos de aplicación (práctica, no oficial)</h2>
<h3>Caso 1</h3>
<p><strong>Situación.</strong> Al finalizar el año, un estudiante queda en desempeño Bajo en dos áreas y, según el SIEE de su colegio, no es promovido. La coordinadora le dice a la familia: "no podemos garantizarle el cupo el próximo año; busquen otro colegio".</p>
<p><strong>Pregunta.</strong> ¿Qué es lo más sólido para cuestionar esa afirmación?</p>
<ol type="A">
<li>Nada: si el SIEE determina que no se promueve, el colegio puede negar el cupo.</li>
<li>Según el artículo 2.3.3.3.3.6, cuando un establecimiento determina que un estudiante no puede ser promovido, debe garantizarle, en todos los casos, el cupo para que continúe su proceso formativo; la no promoción no autoriza negar el cupo.</li>
<li>El colegio solo debe garantizar el cupo si el estudiante repite el año con la misma nota.</li>
<li>El cupo depende del consejo académico, que puede decidir libremente.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El texto es expreso: el cupo se garantiza "en todos los casos". El SIEE define los criterios de promoción, pero no puede desconocer esa garantía. A y D le atribuyen al colegio o al consejo una facultad que la norma no da; C inventa una condición. Un colegio puede, eso sí, definir estrategias de apoyo y planes de mejoramiento para el estudiante que repite.</p>
<h3>Caso 2</h3>
<p><strong>Situación.</strong> A mitad de año, el rector anuncia por circular que, desde el mes siguiente, los estudiantes que superen el 20 % de inasistencia perderán el año. Los docentes y la representante de los padres preguntan si eso es válido.</p>
<p><strong>Pregunta.</strong> ¿Qué falla en el procedimiento?</p>
<ol type="A">
<li>Nada: el rector puede modificar el SIEE por circular.</li>
<li>El porcentaje de asistencia que incide en la promoción debe estar definido en el SIEE, y modificarlo exige el procedimiento del artículo 2.3.3.3.3.8 (definir, socializar con la comunidad, aprobar en el consejo directivo con acta, incorporar al PEI y divulgar); una circular no lo sustituye.</li>
<li>La asistencia no puede ser un criterio de promoción en ningún caso.</li>
<li>Solo el Ministerio de Educación puede cambiar el SIEE de un colegio.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> La norma deja a cada colegio definir el porcentaje de asistencia que incide en la promoción, pero lo hace a través del SIEE, que se construye y se modifica con el procedimiento previsto. C contradice el texto (la asistencia puede incidir si el SIEE así lo define); D desconoce la autonomía institucional; A ignora el procedimiento participativo. Además, quien pierde el año por inasistencia conserva la garantía de cupo del caso anterior. Ambos casos son ejercicios míos, no preguntas oficiales.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>El Decreto 1290 de 2009 dio a los colegios colombianos autonomía para definir su sistema de evaluación y promoción dentro de un marco común (la escala nacional, los componentes mínimos y el procedimiento). Esa autonomía convive con las pruebas externas, que miden a todos con el mismo instrumento. En la región, los sistemas de evaluación y promoción van desde reglas nacionales detalladas hasta la autonomía de cada escuela; en el mundo, el debate sobre la repetición de grado, la evaluación formativa y la calificación es amplio, y la evidencia suele advertir sobre los costos de la repetición. Para los <strong>aspirantes</strong>, el reto es distinguir lo que fija la norma de lo que define cada SIEE; para los <strong>docentes</strong>, aplicar el SIEE de su colegio con rigor y con las mismas reglas para todos; para los <strong>directivos</strong>, garantizar que el SIEE exista, se conozca y se modifique por el procedimiento; y para las <strong>familias</strong>, que conocerlo desde el inicio del año es un derecho, y reclamar con base en él, una vía legítima. Ver también <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">calificaciones: aprendizaje o cumplimiento</a>, <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a> y <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">planeación inversa</a>.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a> y la serie normativa: <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">Ley 115 y Decreto 1860</a>, <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución</a> y <a href="/concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro/">el Decreto Ley 1278 de 2002</a>. Analiza tus errores con el <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">plan de mejora</a>, registra tu avance en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a> y refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a> y <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es el SIEE?</h3>
<p>El sistema institucional de evaluación de los estudiantes: parte del PEI, define los criterios de evaluación y promoción de cada colegio, su escala y sus procedimientos, dentro del marco del Decreto 1290 de 2009 (compilado en el Decreto 1075 de 2015).</p>
<h3>¿Cuál es la escala de valoración nacional?</h3>
<p>Desempeño Superior, Alto, Básico y Bajo. Cada colegio define su propia escala y su equivalencia con esa escala nacional.</p>
<h3>¿Quién define el porcentaje de asistencia para la promoción?</h3>
<p>Cada establecimiento educativo, en su SIEE. La norma no fija un porcentaje nacional.</p>
<h3>¿Un colegio puede negar el cupo a un estudiante que no fue promovido?</h3>
<p>No: según el artículo 2.3.3.3.3.6 debe garantizarle, en todos los casos, el cupo para que continúe su proceso formativo.</p>
<h3>¿Cómo se modifica el SIEE?</h3>
<p>Con el mismo procedimiento de creación: definir, socializar, aprobar en el consejo directivo con acta, incorporar al PEI y divulgar (art. 2.3.3.3.3.8).</p>

<p class="notice"><strong>Revisa un SIEE real.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-siee-decreto-1290.xlsx">ficha de estudio</a>, consigue el SIEE de un colegio (el tuyo o uno público en su sitio web) y marca cuáles de los 11 componentes encuentras. Luego prueba el conversor con tus propios cortes y mira cuántos estudiantes cambiarían de desempeño según el redondeo.</p>

<h2>Para pensar</h2>
<p>El SIEE existe para que la evaluación sea conocida, coherente y apelable. Pero muchos estudiantes y familias nunca lo han leído. <strong>¿Qué pasaría en tu colegio si cada familia recibiera, desde el primer día, un resumen de una página del SIEE y supiera exactamente cómo se calcula cada nota, cómo se redondea y a quién reclamar? Y si el redondeo cambia el desempeño de uno de cada tres estudiantes, ¿es un detalle técnico o una decisión de justicia?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:niveles}}' => $img('siee-decreto-1290-niveles', 553, 'Tabla con cinco elementos de la evaluación de estudiantes y quién los define, la norma o el colegio: escala nacional, escala propia, criterios de promoción, porcentaje de asistencia y cupo.', 'Dos niveles de decisión en la evaluación.'),
    '{{img:creacion}}' => $img('siee-decreto-1290-creacion', 467, 'Cinco pasos para crear o modificar el SIEE: definir, socializar, aprobar en el consejo directivo, incorporar al PEI e informar.', 'Un procedimiento, no una decisión del rector.'),
]);

return [
    'slug' => 'concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional',
    'title' => 'El SIEE y el Decreto 1290 en el Concurso Docente: evaluación y promoción de estudiantes, escala nacional y un conversor',
    'excerpt' => 'Los 11 componentes del sistema institucional de evaluación (SIEE), la escala nacional, la promoción, la asistencia y el cupo según el Decreto 1075 de 2015, con un conversor que muestra cómo el redondeo cambia el desempeño y dos casos resueltos.',
    'seo_title' => 'SIEE y Decreto 1290: evaluación de estudiantes',
    'seo_description' => 'Estudia el SIEE y el Decreto 1290 (compilado en el 1075): 11 componentes, escala nacional, promoción y cupo, con un conversor en Excel y dos casos resueltos.',
    'focus_keyword' => 'SIEE Decreto 1290 evaluación de estudiantes',
    'cover' => '/assets/img/articulos/siee-decreto-1290/siee-decreto-1290-portada',
    'cover_alt' => 'Portada "El SIEE y el Decreto 1290: cómo se evalúa y se promueve a los estudiantes" con una tarjeta: 5 de 12 estudiantes cambian de desempeño según cómo se redondee la nota.',
    'published_at' => '2027-02-05 12:00:00',
    'content_html' => $html,
];
