<?php

declare(strict_types=1);

// "Decreto Ley 1278 de 2002". Fuente: texto original del 19-jun-2002 (copia de la Universidad Nacional de Colombia del decreto del MEN), consultado el 10-oct-2026; arts. 1 a 9, 12 a 16, 18 a 21, 26 a 28, 31, 32, 35, 36, 37, 41, 63 y 68. Umbrales del texto original (60 %, 80 %, cuatro meses, tres meses, dos años consecutivos). Aviso de modificaciones y vigencia. Simulador verificado en Excel 16 (9 casos). Casos de práctica no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/decreto-1278/' . $name;
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
<p>Quien se presenta al Concurso Docente, y quien ya es docente estatal, se mueve dentro de un marco legal que casi nunca ha leído completo: el <strong>Decreto Ley 1278 de 2002, el Estatuto de Profesionalización Docente</strong>. Define quién es docente y quién directivo docente, cómo se ingresa (el concurso), qué pasa en el período de prueba, cómo se organiza el Escalafón Docente, qué se evalúa y con qué consecuencias, qué derechos y deberes se tienen y cuándo se termina la relación con el Estado.</p>
<p>Este artículo recorre ese estatuto con la estructura <strong>norma (con su fuente) + interpretación + caso con respuesta justificada</strong>. Incluye una <a href="/descargas/concurso-docente/ficha-estudio-decreto-ley-1278-de-2002.xlsx">ficha de estudio en Excel</a> con un mapa de los artículos, la ruta del docente, los requisitos de cada grado del escalafón, un <strong>simulador de las consecuencias de la evaluación</strong> (verificado en Microsoft Excel 16 con nueve casos) y doce tarjetas. Texto consultado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias importantes.</strong> Los resúmenes y los umbrales de este artículo corresponden al <strong>texto original del decreto, del 19 de junio de 2002</strong>. El estatuto ha sido reglamentado y modificado por normas posteriores (por ejemplo, el Decreto 1075 de 2015), y la Corte Constitucional ha revisado varios de sus artículos: <strong>verifica el texto vigente</strong> en Función Pública, el Ministerio de Educación o la Imprenta Nacional, y atiende a lo que digan la convocatoria y su anexo técnico en SIMO. Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>, y nadie puede garantizarte un resultado ni un nombramiento. Esto no es asesoría jurídica.</p>

<h2>A quién se aplica y cuál es su lógica</h2>
<p>El decreto se expidió con facultades extraordinarias otorgadas por el artículo 111 de la Ley 715 de 2001. Su <strong>artículo 1</strong> establece que regula las relaciones del Estado con los educadores a su servicio para garantizar que la docencia sea ejercida por educadores idóneos. El <strong>artículo 2</strong> lo aplica a quienes se vinculen desde su vigencia como docentes y directivos docentes al servicio del Estado en preescolar, básica y media: los educadores estatales <strong>ingresan primero al servicio y, si superan el período de prueba, se inscriben en el Escalafón Docente</strong>. Los docentes vinculados antes de 2002 se rigen por el estatuto anterior (el Decreto Ley 2277 de 1979), y los de colegios privados por el Código Sustantivo del Trabajo y sus reglamentos internos (art. 68).</p>
<p>La lógica del estatuto se puede resumir así: <strong>mérito para entrar, evaluación para permanecer y formación para ascender</strong>. La carrera docente (art. 16) se basa en el carácter profesional de los educadores, depende de la idoneidad en el desempeño y de las competencias demostradas, garantiza igualdad de acceso y considera el mérito como fundamento del ingreso, la permanencia, la promoción y el ascenso.</p>

<h2>Quién es quién: profesionales, docentes y directivos</h2>
<ul>
<li><strong>Profesionales de la educación</strong> (art. 3): licenciados en educación, profesionales con otro título habilitados para la función docente según el decreto, y normalistas superiores.</li>
<li><strong>Función docente</strong> (art. 4): la de carácter profesional que implica los procesos sistemáticos de enseñanza-aprendizaje, incluidos el diagnóstico, la planificación, la ejecución y la evaluación, y otras actividades educativas en el marco del PEI.</li>
<li><strong>Docentes</strong> (art. 5): quienes desarrollan labores académicas directa y personalmente con los alumnos; también son responsables de las actividades curriculares no lectivas complementarias (planeación, evaluación, dirección de grupo, atención a familias, etc.).</li>
<li><strong>Directivos docentes</strong> (art. 6): quienes desempeñan actividades de dirección, planeación, coordinación, administración, orientación y programación; los cargos estatales son director rural, rector y coordinador (el coordinador auxilia al rector).</li>
</ul>

<h2>Del concurso al Escalafón</h2>
{{img:ruta}}
<p><strong>Ingreso (arts. 7 a 9).</strong> Se requiere título de licenciado o profesional expedido por una institución de educación superior reconocida, o de normalista superior, y superar el concurso de méritos, ejerciendo en el nivel y el área de la formación. El concurso evalúa aptitudes, experiencia, competencias básicas, relaciones interpersonales y condiciones de personalidad, y produce un <strong>listado de elegibles</strong> por nivel y área en orden descendente de puntaje. Sus etapas generales son: convocatoria; inscripciones y presentación de documentos; verificación de requisitos y publicación de admitidos; prueba de aptitudes y competencias básicas; resultados; prueba psicotécnica, entrevista y valoración de antecedentes; clasificación; y resultados y listado. El Gobierno reglamenta los contenidos y procedimientos; los detalles de cada convocatoria están en su acuerdo y anexo técnico (ver <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el nuevo cronograma</a> y <a href="/concurso-docente-observaciones-reclamaciones-correcciones-mapa-de-plazos/">observaciones, reclamaciones y correcciones</a>).</p>
<p><strong>Listado de elegibles y provisionalidad (arts. 13 a 15).</strong> Las vacantes pueden proveerse transitoriamente por nombramiento provisional o encargo, pero <strong>no se puede proveer por provisionalidad o encargo una vacante definitiva cuando existe un listado de elegibles vigente</strong> para el nivel o el área (quien lo haga responde disciplinaria y patrimonialmente). Es la razón por la cual el listado importa.</p>
<p><strong>Período de prueba (arts. 12 y 31).</strong> La persona seleccionada por concurso es nombrada en período de prueba hasta terminar el año escolar de su nombramiento, siempre que haya ejercido el cargo <strong>al menos cuatro meses</strong>; al terminar el año se le hace una evaluación de desempeño y de competencias. Con una calificación de <strong>60 % o más</strong> (satisfactoria), adquiere los derechos de carrera y se inscribe en el Escalafón en el grado que corresponda a sus títulos; con una calificación inferior, los docentes son retirados del servicio, y quien no superó el período puede presentarse a nuevo concurso. Si no alcanzó los cuatro meses en el año, la evaluación se aplaza al año académico siguiente.</p>
<p><strong>El Escalafón (arts. 19 a 21).</strong> Es el sistema de clasificación de docentes y directivos estatales según formación académica, experiencia, responsabilidad, desempeño y competencias. Tiene <strong>tres grados</strong> (según la formación) y cada grado <strong>cuatro niveles salariales</strong> (A, B, C y D). Al superar el período de prueba se ubica a la persona en el nivel A de su grado; después de tres años de servicio, con la evaluación de competencias en el puntaje indicado, puede reubicarse en el nivel siguiente o ascender de grado. Los requisitos del texto original: Grado Uno, normalista superior; Grado Dos, licenciado o profesional con otro título más pedagogía o una especialización en educación; Grado Tres, licenciado o profesional con maestría o doctorado en un área afín o fundamental para la enseñanza-aprendizaje; en los tres, haber sido nombrado por concurso y superar el período de prueba o la evaluación de competencias.</p>

<h2>Evaluar: tres tipos, tres consecuencias</h2>
{{img:evaluaciones}}
<ul>
<li><strong>Período de prueba</strong> (art. 31): 60 % o más es satisfactoria (inscripción en el escalafón); menos, retiro (para docentes). Se aplica a quienes sirvieron al menos cuatro meses en el año.</li>
<li><strong>Desempeño anual</strong> (art. 32): pondera el cumplimiento de funciones y el logro de resultados; lo hace el rector o director (el superior jerárquico, en el caso de los rectores) a quienes hayan servido en el establecimiento <strong>más de tres meses</strong> en el año. Con menos de 60 % durante <strong>dos años consecutivos</strong>, el docente es excluido del escalafón y retirado del servicio (art. 36); los directivos docentes que vengan de la docencia estatal regresan a la docencia. Estas evaluaciones admiten los recursos de reposición y apelación, que deben resolverse en quince días hábiles.</li>
<li><strong>Competencias</strong> (art. 35): voluntaria para quienes quieran ascender o reubicarse; la entidad territorial la aplica cuando lo considere conveniente, sin que pasen más de seis años entre una y otra. Quienes obtengan <strong>más de 80 %</strong> son candidatos a reubicación o ascenso si cumplen los requisitos, en estricto orden de puntaje y según la disponibilidad presupuestal anual (art. 36).</li>
</ul>
<p>El simulador de la ficha (hoja <em>Simulador</em>) aplica esos umbrales a nueve casos: por ejemplo, un aspirante con 8 meses y 72 % queda inscrito en el escalafón; con 55 %, es retirado; con 80 % pero solo tres meses, "se espera" al año siguiente; un docente con 55 % tras un 70 % el año anterior no es excluido todavía; con 50 % tras un 58 %, sí lo es; con 90 % pero solo dos meses en el colegio, no se evalúa; con 85 % en competencias es candidato a reubicación o ascenso, y con 78 % no alcanza el umbral. Resultado del libro: 2 satisfactorias, 1 retiro, 1 "se espera", 1 sin exclusión, 1 exclusión, 1 "no se evalúa", 1 candidato y 1 que no alcanza (verificado en Excel).</p>

<h2>Derechos, deberes y retiro</h2>
<p>Entre los <strong>derechos</strong> (art. 37) están una remuneración acorde con la formación y el desempeño, asociarse libremente, permanecer en el cargo mientras el trabajo y la conducta sean satisfactorios y participar en la formación. Entre los <strong>deberes</strong> (art. 41): buscar de manera permanente la calidad del proceso de enseñanza-aprendizaje mediante la investigación, la innovación y el mejoramiento continuo, de acuerdo con el plan de desarrollo educativo de la entidad territorial y el PEI; cumplir el calendario, la jornada escolar y la jornada laboral; educar en los principios democráticos y en el respeto a la ley; observar una conducta acorde con la función educativa; y mantener relaciones cordiales con padres, acudientes, alumnos y compañeros. El <strong>retiro</strong> (art. 63) procede por causales como renuncia, pensión, muerte, exclusión del escalafón por evaluación no satisfactoria, incapacidad continua superior a seis meses, edad de retiro forzoso, destitución, abandono del cargo y no superar el período de prueba, entre otras.</p>

<h2>Dos casos de aplicación (práctica, no oficial)</h2>
<h3>Caso 1</h3>
<p><strong>Situación.</strong> Un aspirante seleccionado por concurso es nombrado en período de prueba a mediados de octubre y trabaja en el establecimiento hasta el fin del año escolar, es decir, algo más de dos meses. Obtiene en las evaluaciones una calificación de 80 %.</p>
<p><strong>Pregunta.</strong> ¿Qué sucede, según el texto original del estatuto?</p>
<ol type="A">
<li>Queda inscrito de inmediato en el Escalafón, porque su calificación supera el 60 %.</li>
<li>No se le aplica aún la evaluación del período de prueba, porque no cumplió al menos cuatro meses de servicio en el año; debe esperar al año académico siguiente.</li>
<li>Es retirado del servicio por no completar el año escolar.</li>
<li>Pierde el derecho al nombramiento y debe volver a concursar.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> Según el artículo 31 del texto original, la evaluación del período de prueba se aplica a quienes hayan servido el cargo no menos de cuatro meses durante el año; de lo contrario, deben esperar al año académico siguiente. A ignora ese requisito de tiempo; C y D no están previstos para esa situación. Lo que decide es el tiempo de servicio, no la calificación.</p>
<h3>Caso 2</h3>
<p><strong>Situación.</strong> Una docente inscrita en el escalafón obtiene 55 % en la evaluación de desempeño de este año. El año anterior había obtenido 70 %. El rector afirma que "ya quedó excluida del escalafón".</p>
<p><strong>Pregunta.</strong> ¿Qué falla en la afirmación del rector, según el texto original?</p>
<ol type="A">
<li>Nada: una calificación inferior al 60 % excluye de inmediato.</li>
<li>La exclusión exige una calificación inferior al 60 % durante dos años consecutivos; con un 70 % el año anterior, esta sería la primera calificación no satisfactoria y todavía no hay exclusión.</li>
<li>La evaluación de desempeño no tiene consecuencias.</li>
<li>Solo la evaluación de competencias puede excluir a un docente.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 36 dispone que el docente con calificación inferior al 60 % durante <strong>dos años consecutivos</strong> en la evaluación de desempeño es excluido del escalafón y retirado del servicio. Una sola calificación baja no basta; eso sí, es una señal para acompañar y apoyar a la docente antes de la siguiente evaluación, y ella dispone de los recursos de reposición y apelación contra la evaluación. A y D contradicen el texto; C lo niega. Ambos casos son ejercicios míos, no preguntas oficiales, y se rigen por el texto vigente que indique la convocatoria.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>El Estatuto de Profesionalización Docente representó un cambio de enfoque respecto del régimen anterior: ingreso por concurso de méritos, período de prueba, evaluación periódica y ascenso por formación y competencias. En la región, otros países han construido carreras docentes con lógicas semejantes y diferencias propias: por ejemplo, la Ley de Reforma Magisterial del Perú (Ley 29944 de 2012), el sistema de desarrollo profesional docente de Chile (Ley 20.903 de 2016) y el sistema de carrera de maestras y maestros de México con su unidad de administración del sistema (verifica las normas vigentes en fuentes oficiales). En el mundo, el debate sobre evaluación docente combina dos preguntas: cómo garantizar la calidad y cómo hacerlo sin deteriorar la motivación ni la autonomía profesional. Para los <strong>aspirantes</strong>, el reto es entender la lógica del estatuto y no solo memorizar umbrales; para los <strong>docentes</strong> en carrera, conocer sus derechos y los recursos que la norma prevé; para los <strong>directivos</strong>, hacer evaluaciones rigurosas y con acompañamiento; y para las <strong>familias</strong>, saber que la evaluación docente es parte de la garantía de calidad. Más adelante en esta serie se estudian la evaluación de estudiantes y la Ley 715 de 2001, que dio las facultades para este decreto.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a> y la serie normativa que empezó con <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">la Ley 115 y el Decreto 1860</a> y continuó con <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución, arts. 13, 44 y 67</a>; analiza tus errores con el <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">plan de mejora</a> y registra tu avance en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a>. Elige tu empleo con criterio (<a href="/concurso-docente-vacantes-por-territorio-y-area-que-se-puede-deducir-y-que-no/">vacantes</a>, <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">elegir cargo</a>) y refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a> y <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es el Decreto Ley 1278 de 2002?</h3>
<p>El Estatuto de Profesionalización Docente: regula el ingreso, la permanencia, el ascenso y el retiro de los docentes y directivos docentes estatales vinculados desde su vigencia.</p>
<h3>¿Cuánto dura el período de prueba?</h3>
<p>Según el texto original, hasta terminar el año escolar del nombramiento, siempre que se haya ejercido el cargo al menos cuatro meses; al final se evalúan el desempeño y las competencias.</p>
<h3>¿Qué calificación se necesita para superar el período de prueba?</h3>
<p>60 % o más (satisfactoria) según el texto original; con ella se adquieren los derechos de carrera y se inscribe en el Escalafón.</p>
<h3>¿Cuántos grados tiene el Escalafón Docente?</h3>
<p>Tres grados, cada uno con cuatro niveles salariales (A, B, C y D), según el texto original.</p>
<h3>¿El estatuto se aplica a los docentes de colegios privados?</h3>
<p>No: su régimen laboral es el Código Sustantivo del Trabajo y sus reglamentos internos (art. 68).</p>

<p class="notice"><strong>Estudia el estatuto con método.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-decreto-ley-1278-de-2002.xlsx">ficha de estudio</a>, lee los artículos en el texto vigente, prueba los casos del simulador y reconstruye la ruta del docente sin mirar. Y verifica siempre qué cambió respecto del texto original.</p>

<h2>Para pensar</h2>
<p>Un estatuto que premia el mérito y evalúa para decidir la permanencia busca la calidad, pero también pone una presión grande sobre quien enseña. <strong>¿Cómo se equilibra la exigencia de resultados con el acompañamiento y la autonomía de los docentes? Y cuando una evaluación de desempeño decide el futuro de una persona, ¿qué garantías deberían rodearla para que sea justa y sirva para mejorar y no solo para sancionar?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ruta}}' => $img('decreto-1278-ruta', 467, 'Cinco pasos de la ruta de un docente estatal: concurso, período de prueba, escalafón, evaluaciones y ascenso o retiro.', 'Del concurso al retiro, paso a paso.'),
    '{{img:evaluaciones}}' => $img('decreto-1278-evaluaciones', 444, 'Tabla con tres evaluaciones del Estatuto Docente, su umbral y su consecuencia: período de prueba, desempeño anual y competencias.', 'Qué se evalúa, el umbral y lo que ocurre.'),
]);

return [
    'slug' => 'concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro',
    'title' => 'Decreto Ley 1278 de 2002 en el Concurso Docente: del concurso al escalafón, la evaluación y el retiro, con simulador y casos',
    'excerpt' => 'La ruta de un docente estatal según el Decreto Ley 1278 de 2002: concurso, período de prueba, escalafón, evaluación de desempeño y de competencias, derechos, deberes y retiro, con un simulador de consecuencias y dos casos resueltos.',
    'seo_title' => 'Decreto Ley 1278 de 2002: estatuto docente explicado',
    'seo_description' => 'Decreto Ley 1278 de 2002: concurso, período de prueba, escalafón, evaluación y retiro del docente estatal, con simulador y dos casos resueltos.',
    'focus_keyword' => 'Decreto Ley 1278 de 2002',
    'cover' => '/assets/img/articulos/decreto-1278/decreto-1278-portada',
    'cover_alt' => 'Portada "Decreto Ley 1278 de 2002: del concurso al escalafón, la evaluación y el retiro" con una tarjeta: 3 por 4, grados por niveles salariales del Escalafón Docente según el texto original.',
    'published_at' => '2027-01-29 12:00:00',
    'content_html' => $html,
];
