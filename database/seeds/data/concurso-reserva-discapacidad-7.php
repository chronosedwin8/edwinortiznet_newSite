<?php

declare(strict_types=1);

// «Concurso Docente: la reserva mínima del 7 % de vacantes para personas con discapacidad». Fundamentado en la noticia de la CNSC del
// 19 de agosto de 2026, la matriz oficial de respuestas a las observaciones sobre el proyecto de acuerdo y el anexo técnico (septiembre de
// 2026), la Ley 2418 de 2024 y fuentes comparadas (Brasil, Chile, Perú, OMS). Fecha de última verificación: 9 de octubre de 2026.
// Documentos PRELIMINARES: se corrige cuando salga el acuerdo definitivo. Nowdoc; las figuras van con marcadores {{img:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/concurso-docente-reserva-discapacidad/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Si eres docente con una discapacidad y piensas presentarte al Concurso Docente, o si simplemente quieres entender cómo cambia el concurso para todos, hay una frase que se repite en los medios: «se reserva el 7 % de las vacantes». Pero ¿qué significa exactamente? ¿Es un puesto asegurado? ¿Cambia los requisitos? ¿Quién la puede usar y cómo se inscribe?</p>
<p>Este artículo se basa en los <strong>documentos oficiales de la CNSC</strong>, no en rumores. Una advertencia desde el principio: los textos que cito son un <strong>proyecto de acuerdo y un anexo técnico preliminares</strong>; las reglas que valen son las del acuerdo definitivo cuando quede en firme. Fecha de la última verificación: 9 de octubre de 2026.</p>
<p class="notice"><strong>En resumen.</strong> Según la CNSC, el proceso docente 2026 incorpora por primera vez la reserva de <em>mínimo</em> el 7 % de las vacantes para personas con discapacidad, con base en la Ley 2418 de 2024. La reserva da una modalidad de inscripción propia (gratuita para quien acredite el certificado de discapacidad) y una lista de elegibles aparte, pero <strong>no elimina los requisitos del empleo ni garantiza un nombramiento</strong>. Hoy nadie puede inscribirse todavía.</p>

<h2>Qué dice la CNSC sobre la reserva del 7 %</h2>
<p>El 19 de agosto de 2026, la CNSC <a href="https://www.cnsc.gov.co/la-cnsc-publica-los-proyectos-de-acuerdo-el-anexo-tecnico-y-la-opec-preliminar-del-proceso-de">publicó los proyectos de acuerdo, el anexo técnico y la OPEC preliminar</a> del proceso de selección docente y directivos docentes 2026, que ofrece más de 28.000 vacantes. En esa comunicación explica que el proceso «incorpora, por primera vez, la reserva de mínimo el 7 % de las vacantes para personas con discapacidad, en virtud de la Ley 2418 de 2024 y la Sentencia C-117 de 2026 de la Corte Constitucional». La CNSC aclara además que la OPEC es preliminar y puede variar hasta antes de que abran las inscripciones, y que los acuerdos eran todavía un proyecto, no un acto administrativo en firme.</p>
<p>Tras recibir observaciones de la ciudadanía entre el 19 y el 25 de agosto, la CNSC publicó en septiembre una <a href="https://www.cnsc.gov.co/sites/default/files/2026-09/matriz-de-observaciones-respuestas-ciudadania.xlsx">matriz con las respuestas a las observaciones</a> (más de 11.000 comentarios, de los cuales la CNSC reporta haber aceptado 236 y aceptado parcialmente 1.901). Es la fuente más útil para entender cómo piensa aplicar la reserva, y de ahí salen varias de las precisiones que siguen. En esas respuestas la CNSC también deja una nota importante sobre la base legal: la decisión de la Corte (Sentencia C-117 de 2026) había sido anunciada en su Comunicado 19 del 6 de mayo de 2026, pero su texto integral aún no estaba publicado cuando la CNSC respondió. La <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=249256">Ley 2418 de 2024</a>, por su parte, modificó el artículo 29 de la Ley 909 de 2004 para fijar la reserva del 7 % de las plazas en los concursos de la carrera administrativa.</p>

<h2>Cómo funcionaría la reserva, según el proyecto de acuerdo</h2>
<p>Con base en las respuestas oficiales de la CNSC, estas son las reglas centrales del proyecto:</p>
<ul>
<li><strong>Dos modalidades.</strong> Las vacantes reservadas se ofertan en la modalidad «Abierto con reserva»; el resto, en «Abierto sin reserva». La marcación de cuáles vacantes son reservadas la reporta y certifica la entidad territorial certificada en educación (ETC), y la CNSC verifica la base de cálculo, el redondeo (que es hacia arriba) y la distribución por empleo y territorio antes de expedir los actos.</li>
<li><strong>Certificado de discapacidad.</strong> Para participar en la modalidad con reserva se debe acreditar la discapacidad con el certificado expedido conforme a la reglamentación del sector salud. Quien no lo acredite en los términos del acuerdo no continúa en esa modalidad, y no pasa automáticamente a la modalidad sin reserva.</li>
<li><strong>Gratuidad.</strong> Quien se inscribe a un empleo reservado y aporta el certificado al inscribirse no paga derechos de participación (artículo 7 de la Ley 2418 de 2024). Los aspirantes a empleos sin reserva sí pagan: 1,5 salarios mínimos diarios, según el proyecto.</li>
<li><strong>Listas separadas.</strong> Se conforman listas de elegibles independientes para cada empleo y condición de oferta (reservada y no reservada). Dentro de la reserva, el orden lo define el mérito, es decir, el puntaje consolidado: la CNSC respondió que no hay base legal para crear una prelación adicional, por ejemplo, por experiencia en provisionalidad.</li>
<li><strong>Vacantes desiertas.</strong> Una vacante reservada no pasa automáticamente a la modalidad abierta. Solo si queda desierta (sin inscripciones válidas o con menos inscritos que vacantes) y tras verificar los certificados, la CNSC la traslada, con una matriz de correspondencia pública, antes de que empiece la inscripción de la modalidad sin reserva.</li>
<li><strong>Una persona con discapacidad no está obligada a quedarse en la reserva.</strong> Puede inscribirse en un empleo abierto si acredita sus requisitos, en igualdad de condiciones. Eso sí: la regla de <strong>una sola inscripción por proceso</strong> se aplica a todos, así que hay que escoger el empleo y, con él, la lista.</li>
<li><strong>Ajustes razonables en todas las etapas.</strong> No solo en las pruebas escritas: también en la divulgación, la inscripción, la citación, la publicación de resultados, la reclamación y la audiencia pública. Se determinan según la necesidad concreta que informe la persona, no según la categoría del certificado, y no modifican el carácter, el puntaje ni la ponderación de las pruebas. La CNSC anunció que habrá intérprete certificado de Lengua de Señas Colombiana para las personas sordas.</li>
</ul>
{{img:flujo}}

<h2>Reserva no es lo mismo que requisitos de elegibilidad</h2>
<p>Esta es la confusión más frecuente. Son dos cosas distintas que deben cumplirse a la vez:</p>
<ol>
<li><strong>Los requisitos del empleo</strong> (título, formación, el cargo al que aspiras, según el Manual de Funciones): los deben cumplir <em>todos</em>, también quienes se inscriben en la reserva. La CNSC lo dice así: en la modalidad de ingreso pueden participar las personas que acrediten los requisitos del empleo, estén o no vinculadas al servicio educativo estatal.</li>
<li><strong>La acreditación de la condición de discapacidad</strong>: solo se exige a quien quiere usar la modalidad con reserva. Es un requisito de acceso a esa modalidad, no un sustituto de los requisitos del empleo.</li>
</ol>
<p>Y tampoco hay trato diferencial en el fondo: la CNSC reitera que los ajustes razonables no cambian el puntaje ni la ponderación de las pruebas, y que el mérito ordena la lista. Es una acción afirmativa en el <em>acceso</em>, no una exención de la evaluación. Tampoco hay garantía de nombramiento: este artículo no puede ni debe prometer puntajes, nombramientos o probabilidades de aprobación.</p>

<h2>¿Cuántas vacantes serían?</h2>
<p>Si la oferta final se acercara a las 28.000 vacantes de la OPEC preliminar, el 7 % sería de unas 1.960 (es un cálculo aproximado mío, no una cifra de la CNSC): la cifra real depende de la OPEC definitiva, del redondeo hacia arriba y de cómo se distribuya entre empleos y territorios. Como ejemplo de una ETC, en una de las respuestas de la CNSC aparece el acuerdo del Valle del Cauca con 711 vacantes, de las cuales 50 reservadas. La CNSC reconoce que la distribución por empleo es un punto sensible y que añadirá criterios de trazabilidad en el acuerdo y el anexo, sin presumir por diagnóstico qué empleos puede desempeñar una persona con discapacidad.</p>

<h2>Qué pasa en otros países</h2>
<p>El 7 % no es una cifra aislada, pero los diseños varían mucho. En <strong>Brasil</strong>, el <a href="https://www2.camara.leg.br/legin/fed/decret/2018/decreto-9508-24-setembro-2018-787196-normaatualizada-pe.html">Decreto 9.508 de 2018</a> reserva como mínimo el 5 % de las vacantes de cargos efectivos en la administración federal y manda redondear hacia arriba; si no hay inscritos o aprobados con discapacidad, las vacantes reservadas pueden ser ocupadas por otros candidatos. En <strong>Chile</strong>, la <a href="https://www.garrigues.com/es_ES/noticia/chile-ley-ndeg-21015-que-incentiva-la-inclusion-de-personas-con-discapacidad-al-mundo">Ley 21.015</a> exige que los organismos del Estado con 100 o más funcionarios tengan al menos el 1 % de su dotación con personas con discapacidad, además de la selección preferente a igualdad de mérito. En <strong>Perú</strong>, la Ley 29973 fija una cuota del 5 % en el sector público, pero <a href="https://gestion.pe/economia/empresas/conadis-personas-con-discapacidad-en-el-2023-solo-9-entidades-publicas-cumplieron-con-la-cuota-laboral-empleo-trabajo-municipios-noticia/">según el Conadis, en 2023 solo nueve de 143 entidades fiscalizadas la cumplieron</a>. Colombia y Brasil aplican el porcentaje a <strong>las vacantes ofertadas en el concurso</strong>; Chile y Perú, en cambio, fijan cuotas sobre la planta de personal de cada entidad. Y el 7 % colombiano es el más alto de los cuatro, con modalidad de inscripción y lista propias. Y la necesidad es real: la <a href="https://www.who.int/es/news-room/fact-sheets/detail/disability-and-health">OMS estima</a> que unos 1.300 millones de personas, el 16 % de la población mundial, viven con una discapacidad importante.</p>
<p>¿Qué significa esto para la escuela? Que las aulas con docentes con discapacidad también educan en diversidad. Los mismos ajustes razonables que se piden en el concurso se piden en el aula para los estudiantes. Si trabajas en inclusión, mira <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">el artículo sobre PIAR e inclusión</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Lista de verificación: qué debe revisar cada aspirante</h2>
<p>Este es el recurso aplicable. Úsalo con el acuerdo definitivo y su anexo técnico en la mano. La numeración corresponde al proyecto preliminar y puede cambiar; busca el tema, no solo el número.</p>
<table>
<thead><tr><th>Pregunta</th><th>Dónde verificarla</th><th>Qué buscar</th></tr></thead>
<tbody>
<tr><td>¿El acuerdo ya está en firme o sigo leyendo un proyecto?</td><td>cnsc.gov.co &gt; Procesos de selección &gt; Nuevos procesos de selección</td><td>Que el documento sea el acuerdo definitivo, no el proyecto, y su fecha de publicación.</td></tr>
<tr><td>¿Cuál es el cronograma oficial de inscripciones?</td><td>Cronograma en cnsc.gov.co y SIMO</td><td>Fechas de la modalidad con reserva y de la modalidad sin reserva (pueden ser distintas).</td></tr>
<tr><td>¿Qué empleos y vacantes están reservados?</td><td>OPEC en SIMO (simo.cnsc.gov.co)</td><td>La marcación de reserva por empleo y entidad territorial.</td></tr>
<tr><td>¿Cumplo los requisitos del empleo?</td><td>Artículo de requisitos de participación y Manual de Funciones del empleo</td><td>Título, formación y requisitos específicos; causales de exclusión.</td></tr>
<tr><td>¿Qué certificado de discapacidad piden y en qué momento?</td><td>Artículo de inscripciones y anexo técnico</td><td>Tipo de documento, vigencia y que se aporte <em>al inscribirse</em> (la gratuidad depende de eso). El procedimiento de certificación lo define el sector salud.</td></tr>
<tr><td>¿Qué derechos pago, si los pago?</td><td>Artículo de inscripciones</td><td>Gratuidad en la modalidad con reserva; el valor de los derechos en la modalidad abierta.</td></tr>
<tr><td>¿Cómo pido ajustes razonables?</td><td>Artículo de requisitos y anexo técnico</td><td>Plazo, medio y qué debo describir de mi necesidad concreta.</td></tr>
<tr><td>¿Puedo inscribirme en más de un empleo?</td><td>Artículo de inscripciones y causales de exclusión</td><td>La regla de una sola inscripción por proceso.</td></tr>
<tr><td>¿Qué pasa si no hay inscritos suficientes en la reserva?</td><td>Artículo de empleos convocados y anexo técnico</td><td>La declaratoria de vacantes desiertas y la matriz de correspondencia.</td></tr>
<tr><td>¿Cómo se conforman las listas?</td><td>Artículos sobre listas de elegibles y anexo técnico</td><td>Listas independientes para empleos reservados y no reservados.</td></tr>
</tbody>
</table>
<p><strong>Preguntas para hacerle a la CNSC por los canales oficiales</strong> (si tu caso no queda claro): ¿qué documento específico acredita mi condición en este proceso?, ¿puedo cambiar de modalidad después de inscribirme?, ¿cómo se aplican los ajustes en la entrevista y en la audiencia de escogencia de vacante? Las respuestas se obtienen en la línea de atención y los canales de la CNSC, no en redes sociales.</p>
<p>Cuidado con los intermediarios: <strong>nadie puede «asegurarte un cupo»</strong>. El único canal de inscripción es <a href="https://simo.cnsc.gov.co/">SIMO</a> y la información oficial se publica en <a href="https://www.cnsc.gov.co/">cnsc.gov.co</a>.</p>

<h2>Cómo prepararte mientras llegan las reglas definitivas</h2>
<p>Las pruebas del proyecto no cambian por la reserva: todos presentan la misma prueba de aptitudes y competencias básicas, que es la única eliminatoria (mínimo 60/100 para docentes y 70/100 para directivos docentes, según el proyecto). Prepararte sí está en tus manos. El <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito del Concurso Docente</a> te permite practicar el formato con preguntas de práctica; recuerda que <strong>son ejercicios de práctica, no preguntas oficiales</strong>. Para la parte de aptitud matemática, el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">Curso de Aptitud Matemática para docentes y profesionales</a> fue elaborado para el concurso anterior: úsalo como práctica y compáralo con el anexo técnico definitivo. Los artículos sobre <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el nuevo cronograma</a>, <a href="/concurso-docente-2026-docente-de-aula-la-estrategia-que-separa-a-los-preparados-de-los-eliminados/">la estrategia para docentes de aula</a> y <a href="/20-preguntas-frecuentes-sobre-el-concurso-docente/">20 preguntas frecuentes</a> completan la ruta.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}

<h2>Preguntas frecuentes</h2>
<h3>¿La reserva del 7 % garantiza un puesto a las personas con discapacidad?</h3>
<p>No. Reserva una proporción mínima de vacantes para una modalidad de inscripción y una lista propias, pero hay que cumplir los requisitos del empleo, aprobar las pruebas y obtener un puntaje que alcance en el orden de mérito de la lista.</p>
<h3>¿Qué documento acredita la discapacidad?</h3>
<p>Según las respuestas de la CNSC, el certificado de discapacidad expedido conforme a la reglamentación del sector salud, que debe aportarse al momento de inscribirse. Verifica en el acuerdo definitivo cuál es el documento exacto aceptado y su vigencia.</p>
<h3>¿Pagan derechos de inscripción las personas con discapacidad?</h3>
<p>Según el proyecto, quien se inscribe a un empleo reservado y aporta el certificado no paga derechos de participación; quien se inscribe a un empleo sin reserva paga 1,5 salarios mínimos diarios.</p>
<h3>¿Una persona con discapacidad puede concursar por un empleo no reservado?</h3>
<p>Sí, si acredita los requisitos del empleo, en igualdad de condiciones. La CNSC aclara que las listas reservadas y abiertas son independientes y que solo se permite una inscripción por proceso.</p>
<h3>¿Cuándo me puedo inscribir?</h3>
<p>Todavía no hay inscripciones abiertas. Las fechas oficiales las publica la CNSC en su página y en SIMO; ajustes recientes del cronograma están explicados en <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">este artículo</a>.</p>

<p class="notice"><strong>Prepárate con fuentes oficiales y práctica real.</strong> Revisa el acuerdo definitivo en cnsc.gov.co, practica con el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito del Concurso Docente</a> y, si necesitas reforzar aptitud matemática, mira el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Este artículo se actualizará cuando salga el acuerdo en firme.</p>

<h2>Para pensar</h2>
<p>Las acciones afirmativas buscan que el mérito se mida en igualdad de condiciones y no que el mérito desaparezca. <strong>Si una escuela quiere formar estudiantes que valoren la diversidad, ¿cuántos de sus propios docentes, directivos y evaluadores tendrían que ser personas con discapacidad para que ese mensaje sea creíble?</strong> ¿Y deberían los concursos medir además cómo cada aspirante enseña a un aula realmente diversa?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:flujo}}' => $img('concurso-docente-reserva-discapacidad-flujo', 627, 'Esquema de las dos modalidades del proyecto de acuerdo: Abierto con reserva, con certificado de discapacidad, inscripción gratuita, lista propia y traslado de vacantes desiertas, y Abierto sin reserva, con requisitos del empleo, derechos de participación y lista propia; reglas comunes: una sola inscripción, ajustes razonables y requisitos del empleo vigentes.', 'Las dos modalidades del proyecto de acuerdo. Fuente: CNSC, matriz de respuestas a observaciones (septiembre de 2026). Documento preliminar.'),
]);

return [
    'slug' => 'concurso-docente-reserva-7-por-ciento-discapacidad-que-verificar',
    'title' => 'Concurso Docente: qué significa la reserva mínima del 7 % de vacantes para personas con discapacidad y qué debe verificar cada aspirante',
    'excerpt' => 'Qué dice la CNSC sobre la reserva del 7 % para personas con discapacidad en el Concurso Docente 2026, cómo se diferencia de los requisitos de elegibilidad y una lista de verificación de fuentes oficiales.',
    'seo_title' => 'Concurso Docente: reserva del 7 % para discapacidad',
    'seo_description' => 'Qué es la reserva del 7 % de vacantes para personas con discapacidad en el Concurso Docente, qué dice la CNSC y qué verificar antes de inscribirte.',
    'focus_keyword' => 'reserva 7 % discapacidad Concurso Docente',
    'cover' => '/assets/img/articulos/concurso-docente-reserva-discapacidad/concurso-docente-reserva-discapacidad-portada',
    'cover_alt' => 'Portada con el título «La reserva del 7 % para personas con discapacidad en el Concurso Docente» y una cuadrícula de 100 puntos de los cuales 7 están resaltados, con la leyenda de cada 100 vacantes, mínimo con redondeo hacia arriba.',
    'published_at' => '2026-10-16 12:00:00',
    'content_html' => $html,
];
