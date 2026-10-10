<?php

declare(strict_types=1);

// "Ley 715 de 2001 y competencias". Fuente: texto de la Secretaría del Senado, consultado el 10-oct-2026: arts. 5 a 15, 20, 27 (Ley 1294 de 2009) y 28; num. 10.17 (publicar semestralmente horarios y carga docente). Ficha verificada en Excel 16: 9 de 12 competencias correctas, simulador de contratos (3 estatal, 4 consejo directivo, 1 exactamente 20 no definido). Algunos apartes inexequibles; verificar vigencia. Casos de práctica no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ley-715/' . $name;
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
<p>Una docente quiere trasladarse a otro colegio del mismo municipio y pregunta a quién tiene que pedírselo: ¿al rector?, ¿a la secretaría?, ¿al Ministerio? Un rector quiere pintar el patio con recursos del colegio y duda si necesita una licitación. Otra persona se pregunta por qué el Ministerio fija las normas pero el municipio nombra a los docentes. Las tres preguntas tienen la misma raíz: <strong>quién decide qué en la educación pública colombiana</strong>, y la respuesta está, en buena parte, en la <strong>Ley 715 de 2001</strong>, una de las normas que más se citan en el Concurso Docente y que define el reparto de competencias entre la Nación, los departamentos, los municipios, el rector y el consejo directivo.</p>
<p>Este artículo estudia esa ley con la estructura <strong>norma (con su fuente) + interpretación + caso con respuesta justificada</strong>. Incluye una <a href="/descargas/concurso-docente/ficha-estudio-ley-715-de-2001.xlsx">ficha de estudio en Excel</a> con el mapa de la ley, un ejercicio de doce funciones ("¿quién es competente?"), un <strong>simulador del régimen de contratación de los Fondos de Servicios Educativos</strong> y doce tarjetas. Texto consultado el 10 de octubre de 2026 en la Secretaría del Senado; el libro se verificó en Microsoft Excel 16.</p>
<p class="notice"><strong>Advertencias.</strong> Los resúmenes son míos, no literales: <strong>la fuente es el texto vigente</strong> de la ley. La Ley 715 ha sido modificada varias veces (por ejemplo, los artículos del Sistema General de Participaciones y el artículo 27, por la Ley 1294 de 2009) y algunos apartes fueron declarados inexequibles; consulta la nota de vigencia de cada numeral. Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>. Nadie puede garantizarte un resultado en el concurso. Esto no es asesoría jurídica ni contable.</p>

<h2>El mapa: Nación, departamentos y municipios</h2>
{{img:niveles}}
<ul>
<li><strong>La Nación (art. 5):</strong> formula las políticas y dicta las normas del sector; regula los servicios estatales y no estatales; establece las normas técnicas curriculares y pedagógicas sin perjuicio de la autonomía de las instituciones; <strong>reglamenta los concursos de la carrera docente</strong> (5.7); expide la regulación sobre costos y tarifas de matrículas y pensiones (5.12); distribuye los recursos del Sistema General de Participaciones; define anualmente la asignación por alumno, la canasta educativa y los criterios de planta, como los alumnos por docente.</li>
<li><strong>Los departamentos (art. 6):</strong> dan asistencia técnica, certifican a los municipios que cumplen los requisitos y, frente a los <strong>municipios no certificados</strong>, dirigen, planifican y prestan el servicio, administran los recursos y las instituciones, y administran el personal docente: hacen los concursos, los nombramientos, los ascensos y los traslados (6.2.3), además de evaluar a rectores y directivos (6.2.6).</li>
<li><strong>Los distritos y municipios certificados (art. 7):</strong> hacen lo mismo dentro de su jurisdicción: dirigir, planificar y prestar el servicio, distribuir los recursos entre sus establecimientos, <strong>administrar las instituciones y el personal docente</strong> (concursos, nombramientos, ascensos y traslados; 7.3), evaluar el desempeño de rectores y directivos docentes (7.7), ejercer inspección y vigilancia por delegación y vigilar la aplicación de las tarifas (7.13).</li>
<li><strong>Los municipios no certificados (art. 8):</strong> administran los recursos asignados para mantenimiento y calidad y trasladan plazas y docentes entre sus instituciones con acto motivado; el resto de la administración la hace el departamento.</li>
</ul>
<p><strong>¿Quién es "certificado"?</strong> Según el artículo 20, son entidades territoriales certificadas los departamentos y los distritos, y los municipios de más de 100.000 habitantes; los más pequeños pueden certificarse si cumplen requisitos de capacidad técnica, administrativa y financiera, y pueden perder la certificación si dejan de acreditarla. Es la clave para responder "¿quién administra a este docente?": depende de si su municipio es certificado o no. En ambos casos, la regla sobre quién <em>nombra</em> a un docente se conecta con el concurso (ver <a href="/concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro/">el Decreto Ley 1278</a>).</p>

<h2>La institución educativa y el rector</h2>
<p>El artículo 9 define la <strong>institución educativa</strong> como un conjunto de personas y bienes, promovido por autoridades públicas o por particulares, cuya finalidad es prestar un año de preescolar, nueve grados de básica como mínimo y la media; las que no ofrecen todos los grados son <em>centros educativos</em> y deben asociarse con otras instituciones para ofrecer el ciclo de básica completo. Las instituciones estatales son departamentales, distritales o municipales, y combinan sus recursos en el marco de su Programa Educativo Institucional.</p>
<p>El artículo 10 enumera las <strong>funciones del rector o director</strong> de las instituciones públicas, designados por concurso. Entre otras: dirigir la preparación del PEI con la participación de la comunidad; <strong>presidir el consejo directivo y el consejo académico</strong>; representar al establecimiento; formular planes anuales de acción y de mejoramiento; controlar el cumplimiento de las funciones del personal; distribuir las asignaciones académicas y demás funciones; <strong>realizar la evaluación anual del desempeño de docentes, directivos docentes y administrativos</strong> a su cargo; administrar el Fondo de Servicios Educativos; rendir un informe al consejo directivo al menos cada seis meses; y <strong>publicar una vez al semestre, en lugares públicos y por escrito a los padres de familia, los docentes a cargo de cada asignatura, los horarios y la carga docente de cada uno</strong> (10.17). Es una norma de transparencia que se conecta con la <a href="/carga-academica-docente-excel-quien-excede-quien-sobra-que-falta/">carga académica de los docentes</a>. Las funciones y la autonomía del rector se leen junto con <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">la Ley 115 y el Decreto 1860 (gobierno escolar)</a>.</p>

<h2>Los Fondos de Servicios Educativos</h2>
<p>Según los artículos 11 y 12, las instituciones educativas estatales pueden administrar Fondos de Servicios Educativos, cuentas en las que se manejan los recursos destinados a gastos distintos a los de personal que facilitan el funcionamiento de la institución; los reglamentos definen qué ingresos, gastos y bienes se manejan allí. El artículo 14 establece que el <strong>consejo directivo elabora el presupuesto de ingresos y gastos del Fondo, en absoluto equilibrio</strong>, y no puede aumentar el de ingresos sin autorización del distrito o municipio.</p>
<p>El artículo 13 fija las reglas de contratación: los actos y contratos se hacen respetando los principios de igualdad, moralidad, imparcialidad y publicidad, con el propósito fundamental de proteger los derechos de los niños y jóvenes. Los de <strong>cuantía superior a veinte salarios mínimos mensuales</strong> se rigen por las reglas de la contratación estatal; los de <strong>cuantía inferior a veinte</strong>, por los trámites, garantías y constancias que señale el consejo directivo, que puede exigir además su autorización específica para ciertos actos; el rector celebra los contratos dentro de los límites que fijan los reglamentos. Siempre debe haber información pública sobre las cuentas del Fondo, y omitirla es falta grave disciplinaria.</p>
{{img:pasos}}
<p>La hoja <em>Contratos</em> de la ficha clasifica ocho contratos de ejemplo según su cuantía en salarios mínimos: 4 (de 3, 8, 12 y 19 SMMLV) con los trámites del consejo directivo, 3 (de 21, 35 y 60) con las reglas de la contratación estatal y <strong>uno de exactamente 20 SMMLV que el texto no resuelve</strong>, porque dice "superior a" y "inferior a". Un buen recordatorio: la norma tiene huecos, y por eso el reglamento de los Fondos (hoy compilado en el Decreto 1075 de 2015; verifica) y las normas de contratación vigentes son indispensables. Ver también <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">el presupuesto ejecutado, comprometido y disponible</a>, <a href="/costos-unitarios-colegio-excel-costo-por-estudiante-reparto-punto-de-equilibrio/">los costos unitarios</a> y <a href="/presupuesto-limitado-solver-excel-elegir-proyectos-cuando-no-alcanza-modelo/">elegir proyectos con presupuesto limitado</a>.</p>

<h2>El Sistema General de Participaciones y la prestación del servicio</h2>
<p>El artículo 15 dispone que los recursos de la participación para educación del SGP se destinan a financiar el servicio educativo en actividades como el pago del personal docente y administrativo, la construcción de infraestructura, el mantenimiento, los servicios públicos, el funcionamiento, la canasta educativa y la calidad; y, una vez cubiertos esos costos, el transporte escolar donde las condiciones geográficas lo requieran. El artículo 27 (modificado por la Ley 1294 de 2009) establece que el servicio se presta a través del <strong>sistema educativo oficial</strong>, y que solo donde se demuestre insuficiencia se contrata con entidades sin ánimo de lucro o particulares de reconocida trayectoria, sin superar la asignación por estudiante. El artículo 28 ordena dar prioridad a la inversión que beneficie a los estratos más pobres, sin detrimento del derecho universal a la educación.</p>

<h2>Dos casos de aplicación (práctica, no oficial)</h2>
<h3>Caso 1</h3>
<p><strong>Situación.</strong> El rector de una institución educativa oficial de un distrito quiere saber ante quién responde por la evaluación de su desempeño. El coordinador le dice que "lo evalúa el consejo directivo, que es el que lo conoce".</p>
<p><strong>Pregunta.</strong> ¿Qué dice la ley?</p>
<ol type="A">
<li>Lo evalúa el consejo directivo de su institución.</li>
<li>Lo evalúa la entidad territorial certificada (el distrito), según los artículos 7.7 y 10, parágrafo 1.</li>
<li>Lo evalúa directamente el Ministerio de Educación Nacional.</li>
<li>No se evalúa, porque fue designado por concurso.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 7 (num. 7.7) asigna a los distritos y municipios certificados la competencia de evaluar el desempeño de rectores, directores y directivos docentes, y el parágrafo 1 del artículo 10 indica que el desempeño de los rectores es evaluado anualmente por el departamento, distrito o municipio, conforme al reglamento del Gobierno Nacional. El consejo directivo, en cambio, recibe del rector un informe al menos cada seis meses (10.15) y no lo evalúa. La Nación fija las reglas generales, no hace la evaluación individual; y el concurso es la forma de ingreso, no una exención. (Las consecuencias de la evaluación han sido objeto de pronunciamientos de la Corte Constitucional y de normas posteriores: verifica el texto vigente.)</p>
<h3>Caso 2</h3>
<p><strong>Situación.</strong> Una institución educativa oficial quiere contratar la pintura del patio, por 12 salarios mínimos mensuales, con recursos de su Fondo de Servicios Educativos. El rector piensa que "toca abrir una licitación pública" y que, si no, "no se puede contratar".</p>
<p><strong>Pregunta.</strong> ¿Cuál es la actuación más ajustada al texto de la ley?</p>
<ol type="A">
<li>Una licitación pública, como cualquier contrato del Estado.</li>
<li>El rector celebra el contrato respetando los principios de igualdad, moralidad, imparcialidad y publicidad, con los trámites, garantías y constancias que haya señalado el consejo directivo para contratos de cuantía inferior a 20 salarios mínimos, y con información pública sobre las cuentas del Fondo.</li>
<li>La secretaría de educación contrata directamente, porque el colegio no puede contratar.</li>
<li>Se contrata sin ningún trámite ni registro, porque es una suma pequeña.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 13 dice que el rector celebra los contratos que se paguen con recursos de los Fondos dentro de los límites de los reglamentos, que los de cuantía inferior a 20 salarios mínimos se rigen por los trámites que señale el consejo directivo (que puede exigir su autorización específica) y que a ellos no se les aplica ninguna otra norma de la Ley 80 de 1993, pero siempre con los principios del primer inciso y con información pública sobre las cuentas. A confunde el régimen de los contratos de más de 20 SMMLV; C desconoce que el rector tiene esa facultad; D ignora que los principios, los trámites del consejo y la publicidad siguen aplicando y que omitir la información es falta grave disciplinaria. Si el contrato fuera de 25 SMMLV, regirían las reglas de la contratación estatal según su valor y naturaleza. Ambos casos son ejercicios míos, no preguntas oficiales.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La Ley 715 organizó la <strong>descentralización</strong> del sector educativo: la Nación regula y distribuye los recursos; las entidades territoriales administran el servicio, las plantas y las instituciones. En América Latina, los sistemas educativos varían entre modelos centralizados, descentralizados a nivel provincial o municipal y mixtos, y cada uno enfrenta tensiones propias entre autonomía local, equidad entre territorios y capacidad técnica; la evidencia internacional sobre la descentralización es mixta y depende de las capacidades locales y de los mecanismos de compensación. En Colombia, los retos que más se discuten son la desigualdad entre entidades territoriales, la suficiencia de los recursos del SGP y la capacidad de gestión de municipios pequeños.</p>
<p>Para los <strong>aspirantes</strong>, el reto es saber quién es competente en cada caso (el ejercicio de la ficha entrena exactamente eso); para los <strong>docentes</strong>, entender a quién acudir y quién decide su traslado o su evaluación; para los <strong>directivos</strong>, manejar el Fondo con prudencia, información pública y respeto de la ley; y para las <strong>familias</strong>, saber que los horarios, la carga docente y las cuentas del Fondo deben ser públicos.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a> y la serie: <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">Ley 115 y Decreto 1860</a>, <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución</a>, <a href="/concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro/">el Decreto Ley 1278</a>, <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE</a>, <a href="/concurso-docente-ley-1620-decreto-1965-comite-convivencia-ruta-atencion/">la Ley 1620</a>, <a href="/concurso-docente-decreto-1421-de-2017-piar-ajustes-razonables-educacion-inclusiva/">el Decreto 1421</a> y <a href="/concurso-docente-ley-1098-de-2006-codigo-infancia-adolescencia-obligaciones-colegio/">la Ley 1098</a>. Entrena el análisis de casos con <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>, analiza tus errores con el <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">plan de mejora</a> y registra tu avance en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a>. Refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a> y la herramienta <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué regula la Ley 715 de 2001?</h3>
<p>El Sistema General de Participaciones y las competencias de la Nación, los departamentos, los distritos y municipios en educación y salud, entre otras cosas, y la organización de las instituciones educativas y los Fondos de Servicios Educativos.</p>
<h3>¿Quién administra a los docentes de un municipio?</h3>
<p>Depende: si es certificado, el propio municipio (art. 7.3); si no lo es, el departamento (art. 6.2.3).</p>
<h3>¿Qué es un Fondo de Servicios Educativos?</h3>
<p>La cuenta con la que las instituciones estatales manejan los recursos para gastos distintos a los de personal (arts. 11 y 12).</p>
<h3>¿Qué contratos del Fondo se rigen por la contratación estatal?</h3>
<p>Los de cuantía superior a 20 salarios mínimos mensuales; los de menos de 20 se rigen por los trámites que fije el consejo directivo (art. 13).</p>
<h3>¿Qué debe publicar el rector cada semestre?</h3>
<p>Los horarios y la carga docente de cada docente a cargo de cada asignatura, en lugares públicos y por escrito a los padres de familia (art. 10.17).</p>

<p class="notice"><strong>Entrena el mapa de competencias.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-ley-715-de-2001.xlsx">ficha de estudio</a>, resuelve el ejercicio de las doce funciones y prueba el simulador de contratos con tus propias cifras.</p>

<h2>Para pensar</h2>
<p>Tener claro quién decide qué ayuda a no perderse entre ventanillas, pero también a ejercer los derechos: quien sabe a quién preguntar puede pedir cuentas. <strong>¿Sabes, en tu colegio, quién decidió por última vez un traslado, una evaluación o un gasto grande, y con base en qué norma? Y ¿cómo se enteraría una familia de cómo se usó el Fondo de su colegio y de cuánta carga tiene cada docente?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:niveles}}' => $img('ley-715-niveles', 499, 'Tabla con cuatro niveles que intervienen en la planta docente y su papel principal: Nación, departamento, municipio certificado y rector, con el artículo de la Ley 715.', 'Cuatro niveles, cuatro papeles.'),
    '{{img:pasos}}' => $img('ley-715-pasos', 467, 'Cinco pasos de un contrato del Fondo de Servicios Educativos: presupuesto, necesidad, cuantía, contrato e información pública.', 'Cinco pasos de un contrato del Fondo.'),
]);

return [
    'slug' => 'concurso-docente-ley-715-de-2001-competencias-nacion-departamentos-municipios-fondos-servicios-educativos',
    'title' => 'Ley 715 de 2001 en el Concurso Docente: quién decide qué en la educación pública, el rector y los Fondos de Servicios Educativos',
    'excerpt' => 'Las competencias de la Nación, los departamentos y los municipios según la Ley 715 de 2001, las funciones del rector y las reglas de los Fondos de Servicios Educativos, con ejercicios, un simulador de contratación en Excel y dos casos resueltos.',
    'seo_title' => 'Ley 715 de 2001: competencias, rector y Fondos',
    'seo_description' => 'Estudia la Ley 715 de 2001: competencias de Nación, departamentos y municipios, funciones del rector y Fondos de Servicios Educativos, con ficha y casos.',
    'focus_keyword' => 'Ley 715 de 2001 competencias',
    'cover' => '/assets/img/articulos/ley-715/ley-715-portada',
    'cover_alt' => 'Portada "Ley 715 de 2001: quién decide qué en la educación pública" con una tarjeta: 20 SMMLV separan dos regímenes de contratación de los Fondos de Servicios Educativos.',
    'published_at' => '2027-03-05 12:00:00',
    'content_html' => $html,
];
