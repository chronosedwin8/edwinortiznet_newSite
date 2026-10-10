<?php

declare(strict_types=1);

// "Decreto 1421 de 2017 y el PIAR". Fuente: texto del Decreto 1421 de 2017 en el Gestor Normativo de Función Pública (norma.php?i=87040, vía copia PDF), consultado el 10-oct-2026: arts. 2.3.3.5.2.1.1 a 2.3.3.5.2.3.14, arts. 2 a 6 del decreto (evaluación, promoción, formación, cargos docentes). Simulador verificado en Excel 16 y Python: 6 casos, 4 a tiempo, 2 vencidos; primer trimestre = 3 meses (lectura propia, con aviso). Casos de práctica no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/decreto-1421/' . $name;
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
<p>Marzo. Llega a quinto grado un estudiante con discapacidad, sin certificado médico y con una carpeta de informes de otra institución. En la sala de profesores se escuchan tres frases: "primero necesitamos el diagnóstico", "el PIAR lo hace el docente de apoyo" y "hay tiempo, es en el primer trimestre". Las tres suenan razonables y <strong>las tres pueden estar mal</strong>. El <strong>Decreto 1421 de 2017</strong>, hoy incorporado al Decreto 1075 de 2015, dice otra cosa, y es una de las normas que más se aplican en las aulas y que más aparecen en las preguntas de contexto del Concurso Docente.</p>
<p>Este artículo estudia ese decreto con la estructura <strong>norma (con su fuente) + interpretación + caso con respuesta justificada</strong>. Incluye una <a href="/descargas/concurso-docente/ficha-estudio-decreto-1421-piar.xlsx">ficha de estudio en Excel</a> con el mapa de la norma, una lista para comprobar los nueve elementos mínimos del PIAR en tu formato, un <strong>simulador de plazos</strong>, un cuadro de responsables y doce tarjetas. Texto del decreto consultado el 10 de octubre de 2026 en el Gestor Normativo de Función Pública; el simulador se verificó en Microsoft Excel 16.</p>
<p class="notice"><strong>Advertencias.</strong> Los resúmenes son míos, no literales: <strong>la fuente es el texto vigente</strong> del decreto y las orientaciones del Ministerio de Educación Nacional. La numeración citada es la del Decreto 1075 de 2015 tal como la reproduce el decreto. Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>. Nadie puede garantizarte un resultado en el concurso. Esto no es asesoría jurídica ni clínica: las decisiones sobre un estudiante concreto las toma el equipo del colegio con la familia y, cuando corresponde, con los profesionales de salud y la secretaría de educación.</p>

<h2>Qué regula el decreto</h2>
<p>El Decreto 1421 de 2017 (29 de agosto de 2017) reglamenta, en el marco de la educación inclusiva, la atención educativa a la población con discapacidad en preescolar, básica y media, en establecimientos <strong>públicos y privados</strong> (arts. 2.3.3.5.2.1.1 y 2.3.3.5.2.1.2). Sustituye la sección del Decreto 1075 sobre ese tema y deja la sección anterior solo para la población con capacidades o talentos excepcionales. Se apoya en la Constitución (arts. 13, 44, 47, 67 y 68; ver <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución, arts. 13, 44 y 67</a>), en la Ley 115 de 1994 (art. 46), en la Ley 1346 de 2009 (Convención sobre los derechos de las personas con discapacidad) y en la Ley Estatutaria 1618 de 2013. Su idea central, tomada de la jurisprudencia citada en sus considerandos (Sentencia T-051 de 2011), es que <em>la enseñanza se adapte a los estudiantes y no estos a la enseñanza</em>.</p>

<h2>Cuatro definiciones que se confunden</h2>
<ul>
<li><strong>Educación inclusiva:</strong> proceso permanente que reconoce, valora y responde a la diversidad, con pares de la misma edad en un ambiente de aprendizaje común, sin discriminación, y que garantiza los apoyos y ajustes razonables.</li>
<li><strong>Diseño Universal del Aprendizaje (DUA):</strong> diseño de entornos, currículos y servicios accesibles y significativos para todos; el PIAR es un <em>complemento</em> a lo hecho con el DUA.</li>
<li><strong>Ajustes razonables:</strong> acciones, apoyos o modificaciones necesarias basadas en necesidades específicas del estudiante, que <strong>persisten aunque se incorpore el DUA</strong> y se ponen en marcha tras una evaluación rigurosa. Según el decreto, <strong>su realización no depende de un diagnóstico médico de deficiencia</strong>, sino de las barreras visibles e invisibles que impiden el goce del derecho a la educación.</li>
<li><strong>PIAR (Plan Individual de Apoyos y Ajustes Razonables):</strong> herramienta basada en la valoración pedagógica y social que incluye los apoyos y ajustes, y es insumo para la planeación de aula y el Plan de Mejoramiento Institucional (PMI).</li>
</ul>
<p>La distinción importa: el DUA es para <em>todos</em> y se diseña antes; el PIAR es <em>individual</em> y responde a lo que el DUA no resuelve.</p>

{{img:pasos}}
<h2>Del ingreso al informe anual</h2>
<ol>
<li><strong>Matrícula sin condicionar el cupo (arts. 2.3.3.5.2.3.3 y 2.3.3.5.2.3.10).</strong> La discapacidad no es causal de negación del cupo. Lo ideal es que el estudiante llegue con diagnóstico, certificación o concepto médico y con el PIAR o informe pedagógico anterior; <strong>si no los tiene, se matricula igual</strong>, se registran las variables en el SIMAT y se reporta a la secretaría, que articula con el sector salud el diagnóstico en un plazo no mayor a tres meses. Ningún establecimiento puede rechazar la matrícula por la discapacidad ni negarse a hacer los ajustes razonables, ni expulsar por esa razón.</li>
<li><strong>Acogida y valoración pedagógica.</strong> Hecha la matrícula, se inicia el proceso de acogida basado en el DUA y se hace la valoración pedagógica. Si el colegio no tiene docente de apoyo, la secretaría debe asesorarlo para hacer el PIAR conjuntamente.</li>
<li><strong>Diseño del PIAR (art. 2.3.3.5.2.3.5).</strong> Lo <strong>lideran el o los docentes de aula con el docente de apoyo, la familia y el estudiante</strong>; según la organización escolar participan los directivos y el orientador. Se elabora <strong>durante el primer trimestre del año escolar</strong> y se actualiza cada año. Si el estudiante ingresa de forma extemporánea, el plazo es <strong>no mayor a 30 días</strong> para elaborar el PIAR y firmar el acta de acuerdo.</li>
<li><strong>Acta de acuerdo (art. 2.3.3.5.2.3.6).</strong> Al terminar el diseño se firma un acta con los compromisos, por el <strong>acudiente, el directivo, el docente de apoyo y los docentes a cargo</strong>, que conservan una copia; es el instrumento con el que la familia hace seguimiento y veeduría.</li>
<li><strong>Seguimiento e informe anual (art. 2.3.3.5.2.3.7).</strong> El estudiante recibe los mismos informes que todos según el SIEE. Si su PIAR tiene ajustes en la evaluación, al final del año se <strong>anexa al boletín</strong> un informe anual de proceso pedagógico (preescolar) o de competencias (básica y media), elaborado por el docente de aula con el de apoyo; es indispensable para el PIAR del año siguiente y para decisiones sobre la titulación.</li>
</ol>

<h2>Los nueve elementos mínimos del PIAR</h2>
<p>El artículo 2.3.3.5.2.3.5 dice que el PIAR debe contener como mínimo: (i) la descripción del contexto general del estudiante dentro y fuera del colegio; (ii) la valoración pedagógica; (iii) los informes de profesionales de la salud que aportan a definir los ajustes; (iv) los objetivos y metas de aprendizaje que se pretenden reforzar; (v) los ajustes curriculares, didácticos, evaluativos y metodológicos para el año, si se requieren; (vi) los recursos físicos, tecnológicos y didácticos necesarios; (vii) los proyectos específicos que se requieran en la institución, distintos de los ya programados y que incluyan a todos los estudiantes; (viii) otra información relevante para su aprendizaje y participación; y (ix) las actividades en casa que den continuidad a los procesos en los recesos escolares. La hoja <em>PIAR</em> de la ficha los lista para que marques cuáles tiene tu formato.</p>
<p>Los requerimientos de los PIAR deben incluirse en el PMI, y el PIAR hace parte de la <strong>historia escolar</strong>, que es <strong>confidencial</strong> y solo se entrega a otro establecimiento en caso de traslado o a la familia en caso de retiro (art. 2.3.3.5.2.3.8).</p>

<h2>Quién hace qué</h2>
{{img:actores}}
<p>El colegio (público o privado) debe, entre otras cosas, reportar en el SIMAT a los estudiantes con discapacidad, crear y mantener la historia escolar, proveer las condiciones para elaborar los PIAR, articularlos con la planeación de aula y el PMI, garantizar su cumplimiento y los informes anuales, conversar de forma permanente con las familias, revisar el SIEE con enfoque de educación inclusiva y el manual de convivencia para prevenir la discriminación, y reportar al ICFES a los estudiantes con discapacidad que presentan las pruebas de Estado (art. 2.3.3.5.2.3.1, literal c). Las secretarías de educación definen la estrategia territorial, gestionan la valoración pedagógica y el personal de apoyo y asesoran a los colegios. Las familias, como corresponsables, matriculan cada año, aportan información, cumplen y firman los compromisos y hacen veeduría (art. 2.3.3.5.2.3.12). Los <strong>docentes de apoyo pedagógico</strong> acompañan a los docentes de aula en el diseño, el seguimiento y el informe anual (art. 5 del decreto, que modifica el 2.4.6.3.3).</p>

<h2>El simulador de plazos</h2>
<p>La hoja <em>Plazos</em> calcula la fecha límite del PIAR: tres meses desde el inicio del año escolar (mi lectura de "primer trimestre", que debes confirmar con el calendario de tu colegio y las orientaciones de tu secretaría) o 30 días desde el ingreso si es extemporáneo. Con seis casos de ejemplo: un estudiante desde el inicio (25 de enero de 2027) tiene hasta el 25 de abril; uno que ingresa el 15 de marzo tiene hasta el <strong>14 de abril</strong>, no hasta fin de abril. Resultado del libro: <strong>4 casos a tiempo y 2 vencidos</strong> (verificado en Excel contra un cálculo independiente).</p>

<h2>Dos casos de aplicación (práctica, no oficial)</h2>
<h3>Caso 1</h3>
<p><strong>Situación.</strong> Una estudiante con discapacidad llega a un colegio oficial en la matrícula de enero. Su familia no tiene certificado médico. La coordinadora le dice que "sin diagnóstico no se puede matricular y que vuelva cuando lo tenga".</p>
<p><strong>Pregunta.</strong> ¿Cuál es la actuación ajustada a la norma?</p>
<ol type="A">
<li>Esperar el certificado, porque el PIAR exige un diagnóstico médico.</li>
<li>Matricularla, registrar en el SIMAT las variables de discapacidad con la información de la familia, reportar a la secretaría de educación para que articule con salud el diagnóstico (plazo no mayor a tres meses) y comenzar la acogida, la valoración pedagógica y el PIAR.</li>
<li>Matricularla de manera provisional, sin ajustes, hasta que haya diagnóstico.</li>
<li>Remitirla a otro colegio que tenga docente de apoyo.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 2.3.3.5.2.3.3 establece que la discapacidad no es causal de negación del cupo y que, si el estudiante no tiene el diagnóstico, se procede con la matrícula y el registro en el SIMAT con base en la información de la familia, con reporte a la secretaría para establecer el diagnóstico en articulación con salud en no más de tres meses. El artículo 2.3.3.5.2.3.10 prohíbe rechazar la matrícula o negarse a hacer los ajustes razonables, y la definición de ajustes razonables aclara que no dependen de un diagnóstico médico sino de las barreras. A y C condicionan el derecho a un papel; D es una forma de rechazo (aunque la oferta general exige remitir al establecimiento más cercano a la residencia, no a uno "con apoyo").</p>
<h3>Caso 2</h3>
<p><strong>Situación.</strong> Un estudiante con PIAR ingresa a un colegio el 15 de marzo. La docente de aula comenta: "el PIAR se hace en el primer trimestre del año escolar, así que tenemos hasta finales de abril".</p>
<p><strong>Pregunta.</strong> ¿Qué dice la norma sobre el plazo?</p>
<ol type="A">
<li>Tienen hasta finales de abril, porque el plazo es el primer trimestre.</li>
<li>No hay plazo para ingresos tardíos.</li>
<li>Para el ingreso extemporáneo, el plazo no puede pasar de 30 días para elaborar el PIAR y firmar el acta de acuerdo con la familia, es decir, hasta el 14 de abril en este caso.</li>
<li>El plazo lo define libremente cada docente.</li>
</ol>
<p><strong>Respuesta justificada: C.</strong> El parágrafo 1 del artículo 2.3.3.5.2.3.5 prevé, para el estudiante que se vincula de manera extemporánea, un término no mayor a treinta días para la elaboración del PIAR y la firma del acta de acuerdo entre el colegio y la familia. A confunde la regla general (primer trimestre) con la regla para ingreso tardío; B y D no encuentran apoyo en el texto. Además, si el estudiante viene de otra institución, la receptora debe actualizar el PIAR al nuevo contexto con la historia escolar que entrega la de origen (parágrafo 2). Ambos casos son ejercicios míos, no preguntas oficiales.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>El decreto traduce a la práctica colombiana el modelo de la Convención sobre los derechos de las personas con discapacidad (Ley 1346 de 2009) y su principio de educación inclusiva con ajustes razonables: pasar de la "integración", que pide al estudiante adaptarse, a la inclusión, que pide al sistema adaptarse. En la región, varios países cuentan con leyes y planes de educación inclusiva, y las herramientas individuales de apoyo (planes de apoyo, adecuaciones curriculares) existen con nombres diferentes; en el mundo, la inclusión plena convive con modelos mixtos, y la evidencia indica que los resultados dependen de la formación docente, los apoyos disponibles y la cultura escolar, no solo de la norma. En Colombia, los retos que más se señalan son la disponibilidad de docentes de apoyo, la formación, los tiempos y el riesgo de que el PIAR se convierta en un trámite de formularios.</p>
<p>Para los <strong>aspirantes</strong>, el reto es distinguir DUA, ajustes razonables y PIAR, y recordar quién lidera, cuándo y con qué firmas; para los <strong>docentes</strong>, que el PIAR es una herramienta de aula, no un papel para archivar; para los <strong>directivos</strong>, dar las condiciones (tiempo, espacios, articulación con el PMI); y para las <strong>familias</strong>, que el acta de acuerdo es un compromiso mutuo y también una herramienta de veeduría. Sobre la confidencialidad: la historia escolar es reservada; al usar herramientas de IA para redactar ajustes, hazlo sin nombres ni datos que identifiquen al estudiante (ver <a href="/herramientas/piar/">PIAR con IA</a>, diseñada para ese propósito, y revisa siempre lo que produce).</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a> y la serie: <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">Ley 115 y Decreto 1860</a>, <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución</a>, <a href="/concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro/">el Decreto Ley 1278</a>, <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE</a> y <a href="/concurso-docente-ley-1620-decreto-1965-comite-convivencia-ruta-atencion/">la Ley 1620</a>. Entrena el análisis de casos con <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>, analiza tus errores con el <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">plan de mejora</a> y registra tu avance en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a>. Refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué significa PIAR?</h3>
<p>Plan Individual de Apoyos y Ajustes Razonables: la herramienta, basada en la valoración pedagógica y social, que incluye los apoyos y ajustes que necesita un estudiante con discapacidad.</p>
<h3>¿Se necesita un diagnóstico médico para hacer ajustes razonables?</h3>
<p>Según el decreto, la realización de los ajustes no depende de un diagnóstico médico de deficiencia, sino de las barreras que se presenten. Y la falta de diagnóstico no es razón para negar la matrícula.</p>
<h3>¿Quién elabora el PIAR y cuándo?</h3>
<p>Lo lideran los docentes de aula con el docente de apoyo, la familia y el estudiante, durante el primer trimestre del año escolar; en ingreso extemporáneo, en no más de 30 días.</p>
<h3>¿Quién firma el acta de acuerdo?</h3>
<p>El acudiente, el directivo, el docente de apoyo y los docentes a cargo (art. 2.3.3.5.2.3.6).</p>
<h3>¿Qué es el informe anual de competencias?</h3>
<p>El anexo al boletín final de los estudiantes cuyo PIAR tiene ajustes en la evaluación; alimenta el PIAR del año siguiente.</p>

<p class="notice"><strong>Revisa tu formato de PIAR.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-decreto-1421-piar.xlsx">ficha de estudio</a>, marca cuáles de los nueve elementos mínimos incluye el formato de tu colegio y prueba el simulador con tus fechas.</p>

<h2>Para pensar</h2>
<p>Un PIAR puede estar completo, firmado y archivado, y aun así no cambiar nada en la clase de mañana. <strong>¿Qué ajuste de un PIAR de tu colegio se nota realmente en lo que hace el docente en el aula, y cuál quedó solo en el papel? Y si le preguntáramos al estudiante qué le ayudaría a aprender y a participar, ¿cuánto de lo que respondiera aparecería hoy en su plan?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:actores}}' => $img('decreto-1421-actores', 499, 'Tabla con cuatro actores del PIAR, qué le corresponde a cada uno y si firma el acta de acuerdo: docentes de aula, docente de apoyo, familia y directivos.', 'Cuatro actores en el PIAR.'),
    '{{img:pasos}}' => $img('decreto-1421-pasos', 467, 'Cinco pasos del PIAR: matricular, valorar, diseñar el PIAR, firmar el acta y hacer seguimiento con el informe anual.', 'Cinco pasos, del ingreso al informe anual.'),
]);

return [
    'slug' => 'concurso-docente-decreto-1421-de-2017-piar-ajustes-razonables-educacion-inclusiva',
    'title' => 'Decreto 1421 de 2017 en el Concurso Docente: el PIAR, los ajustes razonables y quién hace qué',
    'excerpt' => 'La atención educativa a la población con discapacidad según el Decreto 1421 de 2017: ajustes razonables, DUA y PIAR, sus nueve elementos mínimos, quién lo diseña y cuándo, con un simulador de plazos en Excel y dos casos resueltos.',
    'seo_title' => 'Decreto 1421 de 2017: PIAR y ajustes razonables',
    'seo_description' => 'Estudia el Decreto 1421 de 2017: PIAR, ajustes razonables y DUA, contenido y plazos, quién lo hace y dos casos resueltos, con ficha y simulador en Excel.',
    'focus_keyword' => 'Decreto 1421 de 2017 PIAR',
    'cover' => '/assets/img/articulos/decreto-1421/decreto-1421-portada',
    'cover_alt' => 'Portada "Decreto 1421 de 2017: el PIAR, los ajustes razonables y quién hace qué" con una tarjeta: 9 elementos mínimos tiene el PIAR; se elabora en el primer trimestre, o en 30 días si el ingreso es tardío.',
    'published_at' => '2027-02-19 12:00:00',
    'content_html' => $html,
];
