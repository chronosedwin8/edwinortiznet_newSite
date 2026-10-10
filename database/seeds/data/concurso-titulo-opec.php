<?php

declare(strict_types=1);

// "¿Mi título cumple el requisito del empleo? Compatibilidad sin rumores". Fuentes verificadas el 9 de octubre de 2026: matriz de respuestas de la CNSC y proyectos de acuerdo (documentos preliminares, sept. 2026); SNIES (Ministerio de Educación). Caso de práctica no oficial; matriz con ejemplo ficticio.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/titulo-opec-trazabilidad/' . $name;
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
<p>"Mi título es parecido, seguro sirve." "Un colega con el mismo posgrado ya se inscribió." "En el grupo dijeron que ese programa cuenta." Cada año, aspirantes a concursos docentes toman decisiones de inscripción con base en frases como estas. Y el error más caro no es sacar un puntaje bajo: es <strong>competir meses por un empleo cuyo requisito no cumples</strong> y enterarte al final, cuando la verificación de requisitos te deja fuera aunque hayas sacado un gran resultado.</p>
<p>Este artículo propone cómo comprobar la compatibilidad entre tu título (y tu experiencia) y el requisito de un empleo <strong>sin rumores</strong>, usando una matriz de trazabilidad que conecta el requisito literal, tu evidencia y la fuente oficial. Incluye una <a href="/descargas/concurso-docente/matriz-trazabilidad-titulo-opec.xlsx">matriz descargable en Excel</a> con un ejemplo ficticio, una hoja de rumores frecuentes y una plantilla de consulta escrita. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Las reglas citadas provienen de los documentos <strong>preliminares</strong> del proceso (proyectos de acuerdo, anexo técnico y matriz de respuestas de la CNSC de septiembre de 2026); las definitivas se conocen con el acuerdo. Este artículo no define si tú cumples un requisito: eso lo decide la CNSC con los documentos que cargues en SIMO. No garantiza puntajes ni nombramientos. El caso de práctica es un ejercicio mío, <strong>no una pregunta oficial</strong>.</p>

<h2>Lo que se sabe de las reglas (versión preliminar)</h2>
<ul>
<li><strong>La verificación de requisitos mínimos</strong> se hace solo a quienes superan la prueba eliminatoria, con los documentos que cargaste en SIMO; si no cumples el requisito del empleo, quedas fuera aunque tengas un gran puntaje (ver <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el nuevo cronograma</a>).</li>
<li><strong>No se aceptan equivalencias por afinidad</strong>, según la matriz de respuestas de la CNSC a las observaciones: lo que cuenta es el requisito tal como está escrito en el empleo.</li>
<li><strong>La fecha de corte</strong> para los requisitos es el último día de inscripciones (confirma el dato en el acuerdo definitivo).</li>
<li>La inscripción es a <strong>un solo empleo por proceso</strong> (ver <a href="/concurso-docente-vacantes-por-territorio-y-area-que-se-puede-deducir-y-que-no/">cómo leer las vacantes</a> y <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">cómo elegir el cargo</a>).</li>
</ul>
<p>Con estas reglas, la compatibilidad no se resuelve con parecidos ni con opiniones: se resuelve con <strong>texto literal y evidencia</strong>.</p>

<h2>La herramienta oficial para el programa: el SNIES</h2>
<p>Según el Ministerio de Educación, el <strong>SNIES</strong> (Sistema Nacional de Información de la Educación Superior) es la plataforma oficial, pública y gratuita para comprobar si un programa o una institución de educación superior está legalmente habilitado, y muestra datos como el nivel de formación, el registro calificado y su resolución, el código del programa y su <strong>núcleo básico del conocimiento (NBC)</strong>. El Ministerio informaba más de 16.870 programas con registro calificado ofrecidos por 305 instituciones (cifras que pueden haber cambiado). Una precisión importante: <strong>el SNIES valida el programa y la institución, no el diploma de una persona</strong>; para confirmar un título concreto se acude a la institución que lo expidió o a los trámites de validación de títulos del Ministerio (confirma la ruta vigente en su sitio).</p>
<p>¿Para qué sirve esto en tu caso? Para dejar de describir tu título con tus propias palabras y empezar a describirlo con los datos oficiales del programa (denominación exacta, código SNIES, NBC), y poder compararlos con el texto del empleo.</p>

<h2>La matriz de trazabilidad</h2>
{{img:pasos}}
<p>La matriz tiene una fila por requisito del empleo y estas columnas:</p>
<ol>
<li><strong>Requisito (texto literal).</strong> Cópialo del documento oficial sin "adaptarlo". Si dice "título profesional en el núcleo básico de conocimiento X", no escribas "en la misma área".</li>
<li><strong>Tipo:</strong> estudio, experiencia u otro.</li>
<li><strong>Tu evidencia:</strong> el documento que lo demuestra (diploma, acta de grado, certificación laboral).</li>
<li><strong>Dónde está:</strong> archivo y página, para encontrarlo rápido al cargarlo en SIMO.</li>
<li><strong>Fuente oficial para verificar:</strong> el SNIES para programa y NBC, la institución para el diploma, las entidades para las certificaciones.</li>
<li><strong>Fecha del documento</strong> y una fórmula que dice si es <strong>anterior o igual a la fecha de corte</strong> que tú escribes.</li>
<li><strong>Estado:</strong> Cumple (con evidencia), Dudo, Sin evidencia o No cumple. La regla es dura a propósito: <em>si no hay evidencia, el requisito está sin cumplir hasta demostrar lo contrario</em>.</li>
</ol>
<p>El libro trae el resumen automático (cuántos requisitos cumplen, cuántos dudo, cuántos sin evidencia y cuántos documentos son posteriores al corte; probé que al poner una fecha posterior al corte la fila lo señala y el resumen lo cuenta). Con el ejemplo ficticio, dos requisitos "cumplen", uno es "dudo" (una certificación laboral sin funciones claras) y uno "sin evidencia", y la lectura dice "Hay requisitos por resolver antes de inscribirte". Esa frase es el objetivo: <strong>descubrir hoy lo que podría eliminarte mañana</strong>. Para el control de documentos en general, ver el <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">artículo sobre errores en SIMO</a> y su libro de control.</p>

<h2>Rumores frecuentes y cómo verificarlos</h2>
{{img:rumores}}
<p>La hoja "Rumores_y_fuentes" trae seis rumores comunes. Algunos de ellos:</p>
<ul>
<li><strong>"Mi título es parecido, sirve".</strong> Con la regla preliminar de no aceptar equivalencias por afinidad, lo que importa es el texto literal. Compáralo con el programa en SNIES (denominación, código, NBC).</li>
<li><strong>"Me dijeron en un grupo que sí cumplo".</strong> Nadie distinto de la CNSC define si cumples. Si tienes una duda real, consúltala por los canales oficiales y guarda la respuesta.</li>
<li><strong>"Las cifras que vi son definitivas".</strong> La oferta preliminar es un borrador; consulta la vigente en SIMO.</li>
<li><strong>"Con una especialización cubro cualquier maestría".</strong> Cada empleo define el nivel y el tipo de estudio que exige; compáralo tal cual.</li>
</ul>
<p>Y una nota sobre la <strong>consulta escrita</strong>: el libro trae una plantilla (asunto, empleo, requisito transcrito, título con código SNIES, una sola pregunta concreta y los documentos adjuntos). Hazla por los canales oficiales de la CNSC o de la entidad, guarda la respuesta como evidencia y recuerda que una consulta no es una garantía: la verificación formal ocurre con los documentos cargados en SIMO. El plazo de respuesta lo define la normativa aplicable y el canal que uses; verifícalo en el sitio oficial.</p>

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación.</strong> Una aspirante es licenciada en Ciencias Naturales y Educación Ambiental. Encuentra un empleo de docente de aula cuyo requisito de estudio dice, literalmente: "Licenciado en Matemáticas o Licenciado en Educación Matemática". Una amiga le dice que "es de la misma área de ciencias, seguro la dejan". Según el proyecto de anexo técnico, no se aceptan equivalencias por afinidad.</p>
<p><strong>Pregunta.</strong> ¿Qué decisión es más sólida?</p>
<ol type="A">
<li>Inscribirse en ese empleo, porque la afinidad cuenta.</li>
<li>Buscar el programa de ambos títulos en el SNIES, comparar con el texto literal y, si no coincide, buscar otro empleo cuyo requisito sí coincida con su título, resolviendo cualquier duda por un canal oficial.</li>
<li>Inscribirse y esperar a ver qué dice la verificación.</li>
<li>Preguntar en un grupo de aspirantes y decidir por mayoría.</li>
</ol>
<p><strong>Respuesta:</strong> B. La decisión debe basarse en el texto literal y en la evidencia oficial. A depende de una afinidad que el proyecto no contempla; C asume el riesgo de competir meses para ser eliminada al final (la verificación se hace después de la prueba eliminatoria); D sustituye la fuente oficial por opiniones. <strong>Ejercicio:</strong> toma un empleo real que te interese y llena la matriz con su requisito literal.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los concursos de mérito se basan en el cumplimiento literal de requisitos porque es la forma de hacer comparables a miles de personas y evitar arbitrariedades. En muchos países de la región, los procesos de ingreso a la carrera docente se apoyan también en requisitos formales de titulación. Para los <strong>aspirantes</strong>, la cultura del rumor (grupos, redes) es una fuente de información abundante y poco confiable; para los <strong>formadores y plataformas</strong>, la responsabilidad es remitir a la fuente oficial; para las <strong>secretarías de educación</strong>, la claridad con que describen los requisitos en la OPEC evita errores; y para las <strong>instituciones de educación superior</strong>, la denominación exacta de sus programas importa cuando un egresado compite por un empleo.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Una vez que sepas a qué empleo te puedes inscribir, prepárate con calma. En <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica, no material oficial de la CNSC), puedes practicar, y también en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Evalúa antes la calidad de cualquier simulacro con la <a href="/concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica/">rúbrica de simulacros</a>; estudia la normativa con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a>; y, para razonamiento cuantitativo, mira el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si trabajas con estudiantes con discapacidad, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a> y <a href="/concurso-docente-reserva-7-por-ciento-discapacidad-que-verificar/">la reserva del 7 %</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cómo sé si mi título cumple el requisito de un empleo?</h3>
<p>Compara el texto literal del requisito con los datos oficiales de tu programa (denominación, código y núcleo básico del conocimiento en el SNIES), y revisa que tus documentos estén a la fecha de corte. La decisión formal la toma la CNSC con los documentos que cargues.</p>
<h3>¿Se aceptan equivalencias por afinidad?</h3>
<p>Según la matriz de respuestas de la CNSC de septiembre de 2026 (documento preliminar), no. Confirma la regla en el acuerdo definitivo.</p>
<h3>¿El SNIES valida mi diploma?</h3>
<p>No: valida el programa y la institución. Para confirmar un título concreto se acude a la institución que lo expidió o a los trámites de validación de títulos del Ministerio de Educación.</p>
<h3>¿Qué hago si tengo una duda sobre un requisito?</h3>
<p>Consúltala por escrito por los canales oficiales de la CNSC, con el requisito transcrito y los datos de tu programa, y guarda la respuesta. No dependas de opiniones informales.</p>
<h3>¿Cuál es la fecha de corte de los requisitos?</h3>
<p>Según los documentos preliminares, el último día de inscripciones; verifícalo en el acuerdo definitivo.</p>

<p class="notice"><strong>Haz tu matriz hoy.</strong> Descarga la <a href="/descargas/concurso-docente/matriz-trazabilidad-titulo-opec.xlsx">matriz de trazabilidad</a>, copia el requisito literal de un empleo que te interese y llena tu evidencia. Si el resumen dice que hay requisitos por resolver, es mejor saberlo ahora.</p>

<h2>Para pensar</h2>
<p>Un concurso por mérito exige reglas literales para ser justo, pero la literalidad puede dejar fuera a personas con formaciones cercanas y plenamente capaces. <strong>¿Es más justo un concurso que exige el título exacto, o uno que reconoce equivalencias de formación afín? ¿Y quién debería definirlas: la entidad que convoca, las instituciones de educación superior o la comunidad educativa que necesita docentes?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:pasos}}' => $img('titulo-opec-trazabilidad-pasos', 467, 'Cinco pasos del método de trazabilidad: requisito literal, tu evidencia, fuente oficial, fecha de corte y dudas por canal oficial.', 'Cinco pasos para verificar con documentos.'),
    '{{img:rumores}}' => $img('titulo-opec-trazabilidad-rumores', 444, 'Tabla con tres rumores frecuentes (es parecido y sirve, me dijeron que sí cumplo, las cifras son definitivas), el riesgo de cada uno y cómo verificarlo.', 'Lo que se dice y cómo verificarlo.'),
]);

return [
    'slug' => 'concurso-docente-titulo-opec-compatibilidad-sin-rumores-matriz-trazabilidad',
    'title' => '¿Mi título cumple el requisito del empleo? Compatibilidad título-OPEC en el Concurso Docente, sin rumores y con una matriz de trazabilidad',
    'excerpt' => 'Cómo comprobar con documentos y fuentes oficiales (texto literal del empleo, SNIES, fecha de corte) si tu título y tu experiencia cumplen el requisito de un empleo del Concurso Docente, con una matriz de trazabilidad descargable.',
    'seo_title' => 'Título y OPEC del Concurso Docente: verifica sin rumores',
    'seo_description' => 'Cómo verificar si tu título cumple el requisito de un empleo del Concurso Docente con el texto literal, el SNIES y una matriz de trazabilidad descargable.',
    'focus_keyword' => 'título requisito empleo Concurso Docente',
    'cover' => '/assets/img/articulos/titulo-opec-trazabilidad/titulo-opec-trazabilidad-portada',
    'cover_alt' => 'Portada "¿Mi título cumple el requisito del empleo? Compatibilidad sin rumores" con una lista: copiar el requisito literal, verificar el programa en el SNIES y guardar la evidencia, marcados; confiar en un rumor, descartado.',
    'published_at' => '2026-12-04 12:00:00',
    'content_html' => $html,
];
