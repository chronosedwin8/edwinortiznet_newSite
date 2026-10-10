<?php

declare(strict_types=1);

// "Ley 115 y Decreto 1860: PEI, currículo y gobierno escolar". Fuentes verificadas el 10 de octubre de 2026: Ley 115 de 1994 (arts. 73, 76 a 79, 91 a 94, 138, 142 a 145; texto en Alcaldía de Bogotá/Régimen Legal) y texto compilado del Decreto 1075 de 2015 (arts. 2.3.3.1.4.1 a 2.3.3.1.5.12, con referencia al Decreto 1860 de 1994 arts. 14 a 29). Resúmenes propios; ficha verificada en Excel 16. Caso de práctica no oficial.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ley-115-decreto-1860/' . $name;
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
<p>"El manual de convivencia lo adopta el rector." "No: el consejo académico." "Creo que el consejo directivo." Entre aspirantes al Concurso Docente, y entre docentes en general, la conversación sobre quién decide qué en un colegio suele terminar en una discusión de memoria. La Ley 115 de 1994 y el Decreto 1860 de 1994 (hoy compilado en el Decreto Único Reglamentario 1075 de 2015) responden esas preguntas, pero <strong>no hace falta memorizar números de artículos: hace falta entender la lógica de quién decide qué y por qué</strong>.</p>
<p>Este artículo presenta esa lógica para tres temas que casi siempre aparecen en los estudios del concurso: el proyecto educativo institucional (PEI), el currículo y el gobierno escolar. Cada tema sigue el esquema <strong>norma (con su fuente oficial) + interpretación + caso con respuesta justificada</strong>. Incluye una <a href="/descargas/concurso-docente/ficha-estudio-ley-115-decreto-1860.xlsx">ficha de estudio descargable en Excel</a> (mapa de normas, los 14 aspectos del PEI, gobierno escolar y doce tarjetas). Textos verificados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los resúmenes son míos, no literales: <strong>la fuente es el texto vigente de la norma</strong> (Presidencia de la República, Ministerio de Educación Nacional, Función Pública, Senado). Las normas se modifican y se compilan, y las preguntas de un concurso se basan en el texto que indiquen la convocatoria y su anexo técnico, que se publican en SIMO. Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>, y nadie puede garantizarte un resultado. Esto no es asesoría jurídica.</p>

<h2>Qué normas son y cómo se relacionan</h2>
<ul>
<li><strong>Ley 115 de 1994 (Ley General de Educación), expedida el 8 de febrero de 1994.</strong> Es la ley marco: define, entre muchas cosas, el PEI (art. 73), el currículo (art. 76), la autonomía escolar (art. 77), la regulación del currículo (art. 78), el plan de estudios (art. 79) y el gobierno escolar (arts. 142 a 145).</li>
<li><strong>Decreto 1860 de 1994.</strong> Reglamenta parcialmente la Ley 115 en sus aspectos pedagógicos y organizativos generales: precisa el contenido del PEI (art. 14), cómo se adopta (art. 15), el manual de convivencia (art. 17) y cómo se integran y qué hacen los órganos del gobierno escolar (arts. 18 a 29).</li>
<li><strong>Decreto 1075 de 2015.</strong> Es el Decreto Único Reglamentario del sector educación: compila los decretos reglamentarios, entre ellos el 1860, con otra numeración. Por ejemplo, el contenido del PEI quedó en el artículo 2.3.3.1.4.1 y las funciones del Consejo Directivo en el 2.3.3.1.5.6. El texto compilado conserva, al final de cada artículo, la referencia al decreto de origen. Parte del Decreto 1860 fue modificada por otras normas (por ejemplo, la participación de los padres de familia se reguló después, en el Decreto 1286 de 2005), así que conviene estudiar siempre la versión compilada y vigente.</li>
</ul>

<h2>Tema 1: el PEI</h2>
<p><strong>Norma.</strong> Según el artículo 2.3.3.1.4.1 del Decreto 1075 (art. 14 del Decreto 1860), todo establecimiento educativo debe elaborar y poner en práctica, con la participación de la comunidad educativa, un PEI que exprese cómo ha decidido alcanzar los fines de la educación definidos por la ley, teniendo en cuenta sus condiciones sociales, económicas y culturales. Para la formación integral, debe contener por lo menos catorce aspectos, entre ellos: principios y fundamentos; análisis de la situación institucional; objetivos generales; estrategia pedagógica; organización de los planes de estudio y criterios de evaluación; acciones pedagógicas de democracia, educación sexual, tiempo libre, ambiente y valores; el reglamento o manual de convivencia y el reglamento para docentes; los órganos del gobierno escolar; el sistema de matrículas y pensiones; relaciones con otras organizaciones; evaluación de recursos; articulación con lo cultural local; criterios de organización administrativa y de evaluación de la gestión; y programas educativos para el trabajo y el desarrollo humano.</p>
<p><strong>Interpretación.</strong> Tres ideas ayudan más que la lista: (1) el PEI es de la <em>comunidad educativa</em>, no del rector; (2) tiene contenidos mínimos, pero cada institución goza de autonomía para formularlo, "sin más limitaciones que las definidas por la ley"; (3) los registros y los informes de avance se presentan a la secretaría de educación certificada (art. 2.3.3.1.4.3). En la hoja <em>PEI_14_aspectos</em> puedes anotar dónde está cada aspecto en tu colegio, lo que sirve tanto para la prueba como para ejercer la docencia.</p>
{{img:pei}}
<p><strong>Cómo se adopta y se modifica.</strong> El artículo 2.3.3.1.4.2 describe un proceso participativo: se forman grupos con representantes de todos los estamentos, que deliberan sobre las propuestas; el Consejo Directivo, en consulta con el Consejo Académico, integra y adopta el PEI y lo divulga; cualquier estamento puede pedir modificaciones al rector, que las somete a discusión, y el Consejo Directivo decide previa consulta con el Consejo Académico. Hay una regla particular: si la modificación toca los aspectos 1, 3, 5, 7 y 8 (principios, objetivos generales, planes de estudio y evaluación, manual de convivencia y reglamento, y gobierno escolar) y el Consejo Directivo no la acepta, debe someterse a una segunda votación. Finalmente, el rector presenta el plan operativo dentro de los tres meses siguientes a la adopción.</p>

<h2>Tema 2: el currículo y el plan de estudios</h2>
<p><strong>Norma.</strong> La Ley 115 define el currículo (art. 76) como el conjunto de criterios, planes de estudio, programas, metodologías y procesos que contribuyen a la formación integral y a la construcción de la identidad cultural. El artículo 77 reconoce la autonomía escolar: dentro de la ley y del PEI, las instituciones de educación formal organizan las áreas fundamentales, introducen asignaturas optativas y adoptan métodos de enseñanza, siguiendo los lineamientos del MEN. El artículo 78 asigna al Ministerio los lineamientos generales y deja a cada establecimiento definir su plan de estudios, informando cambios significativos a la secretaría de educación. El artículo 79 define el plan de estudios como el esquema estructurado de las áreas, con sus asignaturas, objetivos, metodología, distribución del tiempo y criterios de evaluación.</p>
<p><strong>Interpretación.</strong> Hay una doble lógica: el Estado fija lo común (lineamientos, estándares, derechos básicos) y la institución concreta lo propio (plan de estudios, métodos, optativas). Por eso, en preguntas sobre "quién decide" un cambio de plan de estudios, la respuesta casi nunca es "el docente solo" ni "la secretaría sola": el Consejo Académico estudia el currículo y organiza el plan de estudios (art. 2.3.3.1.5.7), y el Consejo Directivo participa en la planeación y evaluación del PEI, el currículo y el plan de estudios (art. 2.3.3.1.5.6, literal g). Para el vínculo con la planeación en el aula, ver <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">planeación inversa</a>.</p>

<h2>Tema 3: el gobierno escolar</h2>
<p><strong>Norma.</strong> En los establecimientos estatales, el gobierno escolar lo constituyen el Consejo Directivo, el Consejo Académico y el Rector (Ley 115, art. 142; Decreto 1075, art. 2.3.3.1.5.3). El Consejo Directivo es la instancia directiva, de participación y de orientación académica y administrativa; lo preside el rector e incluye representantes de los docentes, de los padres de familia, de los estudiantes (del último grado), de los exalumnos y de los sectores productivos (Ley 115, art. 143). Entre sus funciones están tomar las decisiones sobre el funcionamiento, resolver conflictos entre docentes o administrativos y alumnos después de agotar el manual de convivencia, <strong>adoptar el manual de convivencia y el reglamento</strong>, fijar criterios de asignación de cupos, asumir la defensa de los derechos de la comunidad y participar en la planeación y evaluación del PEI. El Consejo Académico lo integran el rector, los directivos docentes y un docente por área; estudia el currículo, organiza el plan de estudios, participa en la evaluación institucional anual y, entre otras funciones, decide los reclamos de los alumnos sobre la evaluación. El rector representa al establecimiento ante las autoridades educativas y ejecuta las decisiones del gobierno escolar.</p>
<p><strong>Interpretación.</strong> Una regla práctica: <em>lo directivo y de participación lo decide el Consejo Directivo; lo pedagógico y curricular lo estudia y orienta el Consejo Académico; el rector convoca, preside y ejecuta</em>. Hay también órganos de participación estudiantil: el personero (un estudiante del último grado que promueve los derechos y deberes de los estudiantes) y el Consejo de Estudiantes (un vocero por grado). Ojo con un detalle que suele generar errores: la Ley 115, en el artículo 93, habla de un representante de los estudiantes "de los tres últimos grados" y, en el 143, de un estudiante que cursa el último grado; el decreto reglamentario precisa el último grado. Es un buen ejemplo de por qué <strong>se estudia el texto vigente y no la memoria</strong>.</p>
{{img:organos}}

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación.</strong> En una institución educativa oficial, el rector considera que el manual de convivencia debe endurecer las sanciones por el uso del celular. Para ahorrar tiempo, redacta una circular que modifica el capítulo de sanciones y la publica, y dice que "ya rige desde el lunes". Un grupo de docentes y la representante de los padres cuestionan el procedimiento.</p>
<p><strong>Pregunta.</strong> ¿Qué fundamento es más sólido para cuestionar la circular?</p>
<ol type="A">
<li>El manual de convivencia es parte del PEI y la norma contempla un proceso participativo para modificarlo, en el que el Consejo Directivo (que adopta el manual) decide previa consulta con el Consejo Académico y tras la deliberación de los estamentos; una circular unilateral no sigue ese procedimiento.</li>
<li>El rector no puede proponer cambios al manual de convivencia en ningún caso.</li>
<li>Solo la secretaría de educación puede modificar el manual de convivencia.</li>
<li>Como las sanciones afectan a los estudiantes, solo el personero puede decidir su modificación.</li>
</ol>
<p><strong>Respuesta justificada: A.</strong> El manual de convivencia hace parte del PEI (art. 2.3.3.1.4.4) y lo adopta el Consejo Directivo (art. 2.3.3.1.5.6, literal c); para modificar el PEI, cualquier estamento puede pedir cambios al rector, que los somete a discusión, y el Consejo Directivo decide previa consulta con el Consejo Académico; si se trata del manual de convivencia (aspecto 7 del PEI) y el Consejo Directivo no acepta la propuesta, procede una segunda votación. El rector puede proponer (B es falsa: la norma le da un papel de convocar y presentar), la secretaría registra y recibe informes del PEI pero no lo adopta (C), y el personero promueve derechos y deberes, no decide el manual (D). Además, el manual debe contemplar el derecho a la defensa en las sanciones. Este caso es un ejercicio mío, no una pregunta oficial.</p>

<h2>Cómo estudiarlo sin memorizar</h2>
<ol>
<li><strong>Aprende el "quién decide qué"</strong> con la hoja <em>Gobierno_escolar</em> y reconstruye la tabla sin mirarla.</li>
<li><strong>Relaciona cada concepto con su ubicación</strong> (Ley 115, Decreto 1075) con la hoja <em>Mapa</em>, pero usa los números como etiquetas, no como objetivo.</li>
<li><strong>Convierte cada norma en un caso</strong> y justifica por qué las otras opciones fallan (ver <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>).</li>
<li><strong>Usa las tarjetas</strong> con espaciamiento (un repaso a los dos días, otro a la semana).</li>
<li><strong>Registra tu avance</strong> en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a> y analiza tus errores con el <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">plan de mejora</a>.</li>
</ol>
<p>Este es el primero de varios artículos normativos: en las próximas semanas, la Constitución (arts. 13, 44 y 67), el Estatuto de Profesionalización Docente (Decreto Ley 1278 de 2002), la evaluación de estudiantes y los sistemas institucionales de evaluación, la Ley 1620 y el Decreto 1965, el Decreto 1421 de 2017, la Ley 1098 de 2006 y la Ley 715 de 2001.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La Ley 115 de 1994 puso el énfasis en la autonomía escolar y en la participación de la comunidad educativa en el gobierno de las instituciones. En la región, los países han equilibrado de forma distinta la autonomía de las escuelas y los lineamientos nacionales (algunos con currículos nacionales muy detallados, otros con más autonomía local), y en el mundo la participación de familias y estudiantes en los órganos escolares también varía. Para los <strong>aspirantes</strong>, el desafío es pasar de recitar normas a explicar procedimientos; para los <strong>docentes</strong> en ejercicio, saber que el PEI y el manual no son documentos del rector sino de la comunidad, y que pueden pedir su revisión por los canales previstos; para los <strong>directivos</strong>, convocar los órganos en los plazos y con los procedimientos que las normas prevén (por ejemplo, integrar el Consejo Directivo dentro de los primeros sesenta días calendario del periodo lectivo); y para las <strong>familias</strong>, saber que tienen voz y representación. Y recuerda desconfiar de quien te prometa "el listado de artículos que sí van a preguntar": ver <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a>.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia la normativa con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a>, elige tu empleo con criterio (<a href="/concurso-docente-vacantes-por-territorio-y-area-que-se-puede-deducir-y-que-no/">vacantes</a>) y refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-observaciones-reclamaciones-correcciones-mapa-de-plazos/">observaciones y reclamaciones</a> y <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">cómo elegir cargo</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Quién adopta el manual de convivencia?</h3>
<p>El Consejo Directivo, como parte del PEI y mediante el proceso participativo que prevé la norma (Decreto 1075 de 2015, art. 2.3.3.1.5.6, literal c, y art. 2.3.3.1.4.4).</p>
<h3>¿Cuántos aspectos mínimos tiene el PEI?</h3>
<p>Catorce, según el artículo 2.3.3.1.4.1 del Decreto 1075 de 2015 (art. 14 del Decreto 1860 de 1994).</p>
<h3>¿Qué órganos conforman el gobierno escolar?</h3>
<p>En los establecimientos estatales: el Consejo Directivo, el Consejo Académico y el Rector.</p>
<h3>¿El Decreto 1860 de 1994 sigue vigente?</h3>
<p>Sus disposiciones fueron compiladas en el Decreto Único Reglamentario 1075 de 2015, con otra numeración y con modificaciones de normas posteriores. Estudia el texto compilado y vigente.</p>
<h3>¿Debo memorizar los números de los artículos?</h3>
<p>No como objetivo principal. Entender quién decide qué y por qué sirve más; los números son etiquetas útiles para ubicarte, y es mejor confirmarlos en el texto vigente.</p>

<p class="notice"><strong>Empieza hoy.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-ley-115-decreto-1860.xlsx">ficha de estudio</a>, reconstruye sin mirar la tabla del gobierno escolar y marca en el PEI de tu colegio dónde está cada uno de los 14 aspectos.</p>

<h2>Para pensar</h2>
<p>Las normas dicen que el PEI y el manual de convivencia son de la comunidad educativa, pero en muchos colegios son documentos que casi nadie ha leído. <strong>¿Qué tan real es la participación cuando los estamentos no conocen los documentos que deberían construir? Y si un aspirante al concurso aprende a explicar el proceso de adopción del PEI, ¿qué cambiaría en su colegio el día que lo ponga en práctica?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:pei}}' => $img('ley-115-decreto-1860-pei', 467, 'Cinco pasos para adoptar y modificar el PEI: formulación, adopción, modificación, agenda y plan operativo.', 'Un proceso participativo, no una circular.'),
    '{{img:organos}}' => $img('ley-115-decreto-1860-organos', 444, 'Tabla con los tres órganos del gobierno escolar en colegios estatales, quién los integra y su función clave: Consejo Directivo, Consejo Académico y Rector.', 'Tres órganos, tres funciones distintas.'),
]);

return [
    'slug' => 'concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar',
    'title' => 'Ley 115 y Decreto 1860 en el Concurso Docente: PEI, currículo y gobierno escolar sin memorizar, con ficha de estudio',
    'excerpt' => 'Quién decide qué en un colegio según la Ley 115 de 1994 y el Decreto 1860 (hoy en el Decreto 1075 de 2015): los 14 aspectos del PEI, el currículo y el gobierno escolar, con un caso resuelto y una ficha de estudio en Excel.',
    'seo_title' => 'Ley 115 y Decreto 1860: PEI y gobierno escolar',
    'seo_description' => 'Estudia la Ley 115 de 1994 y el Decreto 1860 sin memorizar: PEI, currículo y gobierno escolar con fuentes oficiales, un caso resuelto y una ficha en Excel.',
    'focus_keyword' => 'Ley 115 Decreto 1860 Concurso Docente',
    'cover' => '/assets/img/articulos/ley-115-decreto-1860/ley-115-decreto-1860-portada',
    'cover_alt' => 'Portada "Ley 115 y Decreto 1860: PEI, currículo y gobierno escolar sin memorizar" con una tarjeta: 14 aspectos mínimos del PEI en el Decreto 1860 de 1994, hoy en el Decreto 1075 de 2015.',
    'published_at' => '2027-01-15 12:00:00',
    'content_html' => $html,
];
