<?php

declare(strict_types=1);

// "Observaciones, reclamaciones y correcciones en el Concurso Docente: el mapa de plazos". Fuentes verificadas el 10 de octubre de 2026: matriz de respuestas de la CNSC a las observaciones y proyectos de acuerdo y anexo técnico (documentos preliminares, sept. 2026). Calculadora de plazos verificada en Excel; ejemplo de fechas hipotético; caso de práctica no oficial.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/reclamaciones-concurso-docente/' . $name;
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
<p>Llegan los resultados y el puntaje no es el que esperabas. O dice "No cumple requisitos" y estás seguro de que sí cumples. O hay un error en la suma. En ese momento aparecen dos reacciones: la rabia (escribir un mensaje largo y enojado) y el pánico (no saber qué hacer ni cuánto tiempo hay). Ninguna sirve. Lo que sirve es conocer de antemano <strong>qué se puede pedir en cada etapa, por dónde, en qué plazo y con qué evidencia</strong>.</p>
<p>Este artículo es un mapa de los procedimientos de observación, reclamación y corrección en el Concurso Docente, según las reglas <strong>preliminares</strong> de la CNSC (proyectos de acuerdo y de anexo técnico, y matriz de respuestas a las observaciones, septiembre de 2026). Incluye un <a href="/descargas/concurso-docente/mapa-procedimientos-reclamaciones-concurso-docente.xlsx">libro descargable en Excel</a> con el mapa por etapas, una calculadora de plazos en días hábiles, una plantilla para ordenar una reclamación y un registro de evidencias. Datos verificados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Lo que rige es el <strong>acuerdo definitivo y su anexo técnico</strong> y el cronograma publicado en SIMO; los términos y reglas que cito son los del proyecto y pueden cambiar. Este artículo no es asesoría jurídica ni garantiza que una reclamación prospere. Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>. Distingue siempre los documentos preliminares de los definitivos.</p>

<h2>Observaciones, reclamaciones y correcciones: no son lo mismo</h2>
<ul>
<li><strong>Observaciones</strong> son los comentarios ciudadanos a los <em>proyectos</em> de acuerdo y de anexo técnico. Esa etapa se abrió el 19 de agosto de 2026 y duró hasta el 25 de agosto; la CNSC publicó después una matriz con sus respuestas (más de 11.000 comentarios). La propia CNSC aclaró que las observaciones no son un derecho de petición, una reclamación ni un recurso, porque el proyecto no es todavía un acto administrativo en firme. Si no participaste, no pasa nada: esa etapa ya terminó, pero sus respuestas sirven para entender las reglas.</li>
<li><strong>Reclamaciones</strong> son el mecanismo para cuestionar un <em>resultado publicado</em> de una etapa del proceso. Según el proyecto, proceden contra los resultados de las pruebas escritas (artículo 15), de la verificación de requisitos mínimos (artículo 18) y de la valoración de antecedentes y la entrevista (artículo 21). En cada caso hay publicación previa de resultados, un término para reclamar, acceso a las pruebas cuando procede, respuesta motivada y publicación del resultado definitivo.</li>
<li><strong>Correcciones</strong> de resultados consolidados: según las respuestas de la CNSC, en esa instancia solo se verifican errores aritméticos o de compilación; las reclamaciones de fondo sobre cada prueba ya tuvieron su oportunidad en su etapa.</li>
</ul>

<h2>El ciclo de una reclamación (reglas preliminares)</h2>
{{img:ciclo}}
<ol>
<li><strong>Publicación del resultado.</strong> La publicación oficial de citaciones, resultados y decisiones se hace por SIMO y por los medios definidos en la convocatoria.</li>
<li><strong>Reclamación.</strong> Según las respuestas de la CNSC, contra los resultados de cada prueba procede reclamación <strong>dentro de los cinco días hábiles siguientes a su publicación, únicamente por SIMO</strong>. También para la verificación de requisitos mínimos, que no es una prueba ni un instrumento de selección, pero contra cuyo resultado procede reclamación en el mismo plazo.</li>
<li><strong>Acceso a la prueba.</strong> Cuando se autorice, el aspirante puede acceder a la prueba que presentó; según las respuestas de la CNSC, en ese caso hay <strong>dos días hábiles adicionales para complementar</strong> la reclamación.</li>
<li><strong>Respuesta motivada</strong> de la CNSC.</li>
<li><strong>Resultado definitivo</strong> de la etapa.</li>
</ol>
<p>Las reclamaciones se tramitan, según lo preliminar, conforme al Decreto Ley 760 de 2005 y a los términos del cronograma.</p>

<h2>Qué procede y qué no</h2>
{{img:etapas}}
<p>La regla que más aspirantes ignoran: <strong>una reclamación no es una segunda oportunidad para presentar lo que no presentaste.</strong> Según el anexo técnico preliminar (capítulo 3), la reclamación no es una oportunidad general para crear una experiencia, completar libremente una certificación sustancialmente insuficiente o aportar condiciones obtenidas después del cierre. Es decir, se reclama <strong>con lo que ya cargaste a tiempo</strong>: si el documento está y se leyó mal, hay materia para reclamar; si el documento nunca estuvo, o estaba incompleto, el camino no es la reclamación.</p>
<p>Por eso la mejor reclamación se prepara antes: revisando los documentos <em>antes</em> de que cierre la inscripción (ver <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">errores en SIMO</a> y <a href="/concurso-docente-titulo-opec-compatibilidad-sin-rumores-matriz-trazabilidad/">la matriz de trazabilidad título-OPEC</a>).</p>

<h2>Los plazos: cinco días hábiles no son cinco días</h2>
<p>La hoja "Calculadora_de_plazos" calcula el último día para reclamar a partir de la fecha de publicación, contando días hábiles (sin sábados, domingos ni festivos de una lista editable). Probé un caso hipotético, con una fecha inventada para ilustrar: si un resultado se publicara el viernes 18 de diciembre de 2026, los cinco días hábiles siguientes serían el 21, 22, 23 y 24 de diciembre y el 28 (porque el 25 es festivo); el último día sería el lunes 28 de diciembre, es decir, <strong>diez días calendario después</strong>. Si se autorizara un acceso a la prueba el 29 de diciembre, los dos días adicionales vencerían el 31. Ojo: el cómputo oficial lo define la normativa y el cronograma; la calculadora es una ayuda para no olvidar plazos, no un sustituto de lo publicado, y la lista de festivos que trae es editable y debes confirmarla en una fuente oficial.</p>

<h2>Cómo escribir una reclamación que se pueda atender</h2>
<p>La hoja "Plantilla_de_reclamacion" ordena la reclamación en siete partes (se presenta únicamente por el canal oficial que indique la convocatoria):</p>
<ol>
<li><strong>Identificación:</strong> nombre, documento, proceso y código del empleo.</li>
<li><strong>Etapa y resultado que cuestionas:</strong> la etapa, la fecha de publicación y el resultado exacto.</li>
<li><strong>Un hecho concreto</strong> y verificable, sin adjetivos: "el requisito de estudio dice X y mi título es Y (código SNIES Z)".</li>
<li><strong>Fundamento:</strong> el texto del acuerdo, del anexo o del empleo en que te apoyas, con artículo o numeral.</li>
<li><strong>Evidencia:</strong> los documentos que <strong>ya cargaste a tiempo</strong>, con archivo y página.</li>
<li><strong>Solicitud concreta:</strong> qué pides que se revise o corrija.</li>
<li><strong>Lo que no incluyes:</strong> documentos nuevos, condiciones posteriores al cierre, descalificaciones o amenazas.</li>
</ol>
<p>Una reclamación corta, concreta y documentada vale más que una larga y enojada. Y la hoja "Registro_de_evidencias" te ayuda a guardar desde ahora cada publicación, captura y plazo que se abre; cuenta cuántos pendientes tienes.</p>

<h2>Los cinco errores más frecuentes</h2>
<ol>
<li><strong>Dejar pasar el plazo.</strong> El término corre desde la publicación, no desde que te enteras.</li>
<li><strong>Reclamar por un canal que no es el oficial.</strong> Según lo preliminar, por SIMO únicamente; los mensajes por redes o por correo personal no cuentan.</li>
<li><strong>Adjuntar documentos nuevos</strong> para completar lo que faltó.</li>
<li><strong>No decir qué piden.</strong> "Me parece injusto" no es una solicitud.</li>
<li><strong>No guardar la evidencia</strong> (la citación, el resultado, las capturas, la respuesta).</li>
</ol>

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación.</strong> Una aspirante aprobó la prueba eliminatoria, pero en la verificación de requisitos le publican "No cumple": la certificación de experiencia que cargó no describe las funciones. Ella tiene otro certificado, de la misma institución, que sí las describe, y piensa subirlo con su reclamación. Quedan tres días hábiles del plazo.</p>
<p><strong>Pregunta.</strong> ¿Qué es lo más sólido?</p>
<ol type="A">
<li>Subir el certificado nuevo junto con la reclamación, porque el nuevo sí cumple.</li>
<li>Presentar la reclamación por SIMO dentro del plazo, apoyándose en lo que ya cargó y citando el texto del requisito, sin pretender completar con documentos posteriores; y, si el certificado nunca fue cargado, entender que probablemente no procede.</li>
<li>Escribir al correo personal de un funcionario para explicar el caso.</li>
<li>Esperar al resultado definitivo y reclamar después.</li>
</ol>
<p><strong>Respuesta:</strong> B. Según el anexo técnico preliminar, la reclamación no es la oportunidad para completar una certificación sustancialmente insuficiente o aportar condiciones obtenidas después del cierre, y se presenta por SIMO dentro del término. A choca con esa regla; C usa un canal que no cuenta; D deja vencer el plazo. <strong>La enseñanza:</strong> el certificado debió estar completo antes del cierre; por eso conviene revisar los documentos cuando todavía se puede.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el debido proceso en los concursos de mérito se concreta en etapas con publicación, reclamación y respuesta motivada; en la región, los procesos de ingreso a la carrera docente también contemplan mecanismos para cuestionar resultados, con reglas propias. Para los <strong>aspirantes</strong>, el desafío es la disciplina de plazos y evidencia; para la <strong>CNSC y las entidades</strong>, comunicar con claridad términos y canales (varias observaciones del proceso pidieron justamente más claridad y más tiempo); para los <strong>formadores</strong>, enseñar a reclamar con fundamento y no con rumores; y para las <strong>familias</strong> y colegas, apoyar sin presionar. Ver también <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a>: nadie puede "asegurarte" que una reclamación prospere.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Mientras llegan las etapas, prepárate con método: practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica, no material oficial de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio, evaluando antes su calidad con la <a href="/concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica/">rúbrica de simulacros</a>. Estudia la normativa con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a>, elige tu empleo con criterio (<a href="/concurso-docente-vacantes-por-territorio-y-area-que-se-puede-deducir-y-que-no/">vacantes</a>) y refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el nuevo cronograma</a> y <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuánto tiempo tengo para reclamar un resultado?</h3>
<p>Según los documentos preliminares, cinco días hábiles siguientes a la publicación, únicamente por SIMO; confirma el término en el acuerdo definitivo y en el cronograma.</p>
<h3>¿Puedo aportar documentos nuevos en la reclamación?</h3>
<p>Según el anexo técnico preliminar, la reclamación no es la oportunidad para completar una certificación insuficiente ni para aportar condiciones obtenidas después del cierre. Se reclama con lo que cargaste a tiempo.</p>
<h3>¿Puedo ver mi prueba?</h3>
<p>Según lo preliminar, cuando se autoriza el acceso a la prueba presentada, hay dos días hábiles adicionales para complementar la reclamación. Las condiciones exactas las define la convocatoria.</p>
<h3>¿Qué se puede corregir en los resultados consolidados?</h3>
<p>Según las respuestas de la CNSC, errores aritméticos o de compilación; no se vuelve a discutir el fondo de cada prueba.</p>
<h3>¿Las observaciones al proyecto cuentan como reclamación?</h3>
<p>No: la CNSC aclaró que no son derecho de petición, reclamación ni recurso, porque el proyecto no es un acto en firme.</p>

<p class="notice"><strong>Prepárate hoy.</strong> Descarga el <a href="/descargas/concurso-docente/mapa-procedimientos-reclamaciones-concurso-docente.xlsx">mapa de procedimientos</a>, abre el registro de evidencias y guarda desde ya tu citación, tus resultados y las fechas. Y cuando se publique el cronograma definitivo, actualiza los plazos en la calculadora.</p>

<h2>Para pensar</h2>
<p>Los plazos cortos y los canales únicos hacen que los procesos masivos sean manejables, pero también pueden dejar fuera a quien no tuvo acceso a internet, tiempo o información a tiempo. <strong>¿Es justo que un derecho de contradicción dependa de cinco días hábiles y de un único canal digital? ¿O la rigidez de los plazos es lo que garantiza que el concurso termine y que todos compitan en igualdad de condiciones?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ciclo}}' => $img('reclamaciones-concurso-docente-ciclo', 467, 'Cinco momentos de una reclamación según las reglas preliminares: publicación, reclamación en cinco días hábiles solo por SIMO, acceso a la prueba con dos días adicionales, respuesta motivada y resultado definitivo.', 'El ciclo de una reclamación (reglas preliminares).'),
    '{{img:etapas}}' => $img('reclamaciones-concurso-docente-etapas', 499, 'Tabla con cuatro etapas, qué puedes pedir en cada una y qué no procede: pruebas escritas, requisitos mínimos, antecedentes y entrevista y resultados consolidados.', 'Qué procede en cada etapa (preliminar).'),
]);

return [
    'slug' => 'concurso-docente-observaciones-reclamaciones-correcciones-mapa-de-plazos',
    'title' => 'Observaciones, reclamaciones y correcciones en el Concurso Docente: qué se puede pedir, por dónde y en qué plazo',
    'excerpt' => 'Un mapa de los procedimientos de reclamación del Concurso Docente según las reglas preliminares de la CNSC: qué procede en cada etapa, qué no, cómo contar los días hábiles y cómo ordenar una reclamación, con libro descargable.',
    'seo_title' => 'Reclamaciones en el Concurso Docente: plazos y etapas',
    'seo_description' => 'Qué se puede reclamar en cada etapa del Concurso Docente, en qué plazo y por dónde, según las reglas preliminares, con calculadora de plazos y plantilla.',
    'focus_keyword' => 'reclamaciones Concurso Docente',
    'cover' => '/assets/img/articulos/reclamaciones-concurso-docente/reclamaciones-concurso-docente-portada',
    'cover_alt' => 'Portada "Observaciones, reclamaciones y correcciones: el mapa de plazos" con una tarjeta: 5 días hábiles pueden ser hasta 10 días calendario; se reclama solo por SIMO y no procede completar lo que no presentaste.',
    'published_at' => '2026-12-18 12:00:00',
    'content_html' => $html,
];
