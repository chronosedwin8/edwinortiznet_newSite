<?php

declare(strict_types=1);

// «Concurso Docente: errores en SIMO y documentos que debes revisar antes de inscribirte». Fundamentado en la matriz oficial de respuestas de la CNSC
// (septiembre de 2026) al proyecto de acuerdo y anexo técnico del proceso docente 2026 y en la noticia de la CNSC del 19 de agosto de 2026.
// Documentos PRELIMINARES. Última verificación: 9 de octubre de 2026. Recurso: public/descargas/concurso-docente/control-documentos-aspirante.xlsx
// (probado en Excel 16).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/concurso-simo-documentos/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Cada concurso docente deja la misma historia: personas con formación y experiencia suficientes que quedan por fuera por un error evitable. Un certificado laboral sin funciones, un título cargado con otro nombre, un documento ilegible, un empleo que no corresponde a su formación. <strong>El mérito se demuestra con documentos, y los documentos hay que prepararlos antes.</strong></p>
<p>Este artículo te propone una lista de verificación para revisar tu perfil y tus soportes <strong>con antelación</strong>. Una advertencia desde ya: <strong>hoy no hay inscripciones abiertas</strong>. Prepararte no es inscribirte, y todo lo que cito de la CNSC son documentos preliminares (proyecto de acuerdo y anexo técnico) que pueden cambiar en el acuerdo definitivo. Fecha de la última verificación: 9 de octubre de 2026.</p>
<p class="notice"><strong>En resumen.</strong> Según las respuestas oficiales de la CNSC al proyecto de acuerdo, mantener actualizada y veraz la información del perfil en SIMO es responsabilidad del aspirante; cuentan los títulos y certificaciones obtenidos hasta el último día de inscripciones; y la documentación registrada puede actualizarse, modificarse, reemplazarse o adicionarse hasta el cierre. Solo se puede escoger un empleo. Organiza tus documentos ahora, pero espera el acuerdo definitivo para saber qué exige tu empleo.</p>

<h2>Prepararte no es inscribirte</h2>
<p>La CNSC publicó el 19 de agosto de 2026 los proyectos de acuerdo, el anexo técnico y la OPEC preliminar del proceso docente 2026, y advirtió que la <a href="https://www.cnsc.gov.co/la-cnsc-publica-los-proyectos-de-acuerdo-el-anexo-tecnico-y-la-opec-preliminar-del-proceso-de">OPEC es preliminar y puede variar</a> hasta antes de abrir inscripciones. Después de recibir observaciones, publicó en septiembre una <a href="https://www.cnsc.gov.co/sites/default/files/2026-09/matriz-de-observaciones-respuestas-ciudadania.xlsx">matriz con las respuestas</a>, de donde salen las precisiones de este artículo. En el momento de redactarlo, las fechas exactas de inscripción dependen del acuerdo definitivo y del cronograma, que, según la información disponible, se ajustó hacia 2027 (te lo conté en <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">este artículo</a>). Y la inscripción para personas con discapacidad tiene su propia modalidad, explicada en <a href="/concurso-docente-reserva-7-por-ciento-discapacidad-que-verificar/">el artículo sobre la reserva del 7 %</a>.</p>
<p>Lo que <em>sí</em> puedes hacer hoy es ordenar tu información y tus soportes, de modo que cuando se abra la etapa de inscripciones solo tengas que ajustar detalles. Lo que <em>no</em> debes hacer es pagarle a alguien para que «te asegure el cupo» o «te inscriba ya»: el único canal es <a href="https://simo.cnsc.gov.co/">SIMO</a> y la información oficial está en <a href="https://www.cnsc.gov.co/">cnsc.gov.co</a>.</p>

<h2>Cómo funciona SIMO según el proyecto de acuerdo</h2>
<p>La CNSC responde que el proyecto de acuerdo define a SIMO y al sitio web de la CNSC como los medios oficiales de comunicación del proceso, y que el anexo técnico describe la secuencia: <strong>registro, actualización de la hoja de vida, consulta de la OPEC, selección del empleo, pago y formalización de la inscripción</strong>. Para la selección de personal, SIMO es el sistema donde cargas tu perfil, y en esa plataforma se hace la verificación de requisitos mínimos y la valoración de antecedentes con los documentos que cargaste.</p>
{{img:ruta}}
<p>Estas son las reglas que la CNSC ha precisado en sus respuestas, y que te conviene tener presentes:</p>
<ul>
<li><strong>La responsabilidad del perfil es tuya.</strong> «Mantener actualizada y veraz la información del perfil es responsabilidad del aspirante.»</li>
<li><strong>Fecha de corte.</strong> Los documentos que se acreditan son los registrados en SIMO que correspondan a los títulos académicos y las certificaciones de experiencia obtenidos hasta el último día del término de inscripciones. Una ventana posterior, si el cronograma la prevé, solo serviría para cargar o corregir el soporte de condiciones <em>ya obtenidas</em> a esa fecha, no para aportar méritos nuevos.</li>
<li><strong>Actualizar hasta el cierre.</strong> El anexo técnico establece la posibilidad de actualizar, modificar, reemplazar o adicionar la documentación registrada en SIMO hasta el cierre del término de inscripciones.</li>
<li><strong>Una sola inscripción por proceso.</strong> Hay que escoger un empleo y acreditar los requisitos de ese empleo en la OPEC; esto aplica a todos, incluso a educadores ya nombrados en propiedad.</li>
<li><strong>Cada empleo tiene sus requisitos.</strong> La identificación de cada empleo (denominación, área, nivel y requisitos) consta en la OPEC publicada en SIMO. La CNSC dijo que antes de inscripciones cotejará el Manual de Funciones con la OPEC y la parametrización de SIMO, que <strong>no se exigirán requisitos adicionales ni se crearán equivalencias «por afinidad»</strong>.</li>
<li><strong>Los datos de la OPEC los reporta la entidad territorial.</strong> La CNSC verifica la consistencia formal del cargue, pero la corrección de fondo de un dato corresponde a la entidad territorial certificada que lo reportó.</li>
<li><strong>Títulos obtenidos en el exterior.</strong> Según las respuestas, el aspirante debe contar con la convalidación dentro de la oportunidad de cargue de documentos.</li>
<li><strong>Derechos de participación.</strong> En el proyecto, quien se inscribe a empleos sin reserva paga 1,5 salarios mínimos diarios legales vigentes; la modalidad con reserva para personas con discapacidad no paga si aporta el certificado.</li>
<li><strong>Dificultades técnicas.</strong> Se atienden por los canales oficiales de soporte de la CNSC (mesa de ayuda y PQRSD); si algo falla en la plataforma, deja evidencia y radica el caso por esos canales, no por intermediarios.</li>
</ul>
<p>El formato, el peso de los archivos y los documentos exigibles por empleo se publican, según la CNSC, en el anexo técnico y en la <strong>guía del aspirante</strong> antes de que empiecen las inscripciones. Por eso en este artículo no te doy medidas de archivos inventadas: confírmalas en esa guía cuando salga.</p>

<h2>Los errores más frecuentes y cómo evitarlos</h2>
<p>Lo que sigue combina lo que dicen los documentos oficiales con la experiencia de quienes hemos acompañado aspirantes. Donde es una recomendación mía, lo digo.</p>
<ol>
<li><strong>Datos personales que no coinciden con el documento de identidad.</strong> Nombres, apellidos, número de documento y fecha de nacimiento deben ser idénticos a la cédula. Un correo que ya no usas es un riesgo: las notificaciones llegan por SIMO y por el correo registrado.</li>
<li><strong>Títulos que no «hablan» el mismo idioma que el empleo.</strong> Compara el nombre exacto de tu título con los requisitos de la OPEC. Si tu título está en una lista de títulos admitidos, anótalo; si no lo está, no esperes equivalencias por afinidad (la CNSC dijo que no las creará). Distingue entre título <em>obtenido</em> (con grado) y en curso: según la regla de la fecha de corte, cuenta lo obtenido hasta el último día de inscripciones.</li>
<li><strong>Certificaciones laborales incompletas.</strong> La experiencia se valora con las funciones certificadas y su relación con el empleo, y el proyecto prevé reglas de cómputo (por ejemplo, evitar contar dos veces un mismo periodo). Revisa que cada certificación indique el cargo, las funciones, las fechas de ingreso y retiro y quién la expide. Verifica el anexo técnico para saber cómo se computa y qué hacer con el ejercicio profesional independiente, que la CNSC dijo que revisará para acreditarlo con una declaración bajo juramento.</li>
<li><strong>Soportes ilegibles, incompletos o con el nombre equivocado.</strong> Escanea con buena resolución, sin recortes, con todas las páginas. Cuando salga la guía del aspirante, usa los nombres y formatos que pida; mientras tanto, es buena práctica nombrar los archivos de forma clara y sin tildes, espacios ni «ñ». Es una recomendación mía, no una regla verificada del proceso actual.</li>
<li><strong>Elegir un empleo que no corresponde a tu perfil.</strong> Como solo hay una inscripción por proceso, la decisión es definitiva. Lee la denominación, el área, el nivel y los requisitos de cada empleo y cruza con tu formación y experiencia (el próximo artículo de esta serie te ayuda a comparar cargos).</li>
<li><strong>Dejar todo para el último día.</strong> Pagar, cargar y formalizar la inscripción tiene un plazo. Si algo falla, necesitas margen para pedir apoyo por los canales oficiales.</li>
<li><strong>Confiar en terceros con tu clave.</strong> Tu usuario y contraseña son personales: no los compartas con nadie que te «inscriba». Activa y guarda tu correo de recuperación, y mantén el correo registrado bajo tu control.</li>
</ol>

<h2>Lista de verificación: perfil y documentos</h2>
<p>Este es el recurso aplicable. Úsalo para preparar tu perfil con antelación; la numeración de artículos corresponde al proyecto de acuerdo y puede cambiar en el definitivo. Puedes <a href="/descargas/concurso-docente/control-documentos-aspirante.xlsx">descargar la hoja de Excel «Control de documentos del aspirante»</a> (gratis) para llevar el estado de cada soporte, con listas desplegables, avance en porcentaje y una revisión de nombres de archivo; no es un documento oficial.</p>
<table>
<thead><tr><th>Bloque</th><th>Qué revisar</th><th>Dónde verificarlo</th></tr></thead>
<tbody>
<tr><td><strong>Registro y datos</strong></td><td>Nombre y número de documento iguales a la cédula; correo y celular vigentes; contraseña y recuperación a tu nombre.</td><td>SIMO (simo.cnsc.gov.co) y tu cédula.</td></tr>
<tr><td><strong>Formación</strong></td><td>Título o acta de grado con nombre exacto, institución y fecha de grado; convalidación si el título es del exterior; certificados complementarios, si aplican.</td><td>Requisitos del empleo en la OPEC y el acuerdo definitivo.</td></tr>
<tr><td><strong>Experiencia</strong></td><td>Cada certificación con cargo, funciones, fechas de ingreso y retiro y quién la expide; sin periodos superpuestos que cuenten dos veces.</td><td>Anexo técnico, capítulo de valoración de antecedentes.</td></tr>
<tr><td><strong>Fecha de corte</strong></td><td>Qué títulos y certificaciones tendrás obtenidos hasta el último día de inscripciones.</td><td>Acuerdo definitivo y cronograma oficial.</td></tr>
<tr><td><strong>Archivos</strong></td><td>Escaneos completos y legibles; formato y peso según la guía del aspirante; nombres claros.</td><td>Guía del aspirante y anexo técnico.</td></tr>
<tr><td><strong>Empleo y requisitos</strong></td><td>Denominación, área, nivel y requisitos del empleo que te interesa; coincidencia con tu título y experiencia; única inscripción.</td><td>OPEC en SIMO.</td></tr>
<tr><td><strong>Modalidad y pago</strong></td><td>Si aplica la reserva para personas con discapacidad, el certificado y la gratuidad; si no, el valor de los derechos y el plazo de pago.</td><td>Acuerdo definitivo y cronograma.</td></tr>
<tr><td><strong>Después de inscribirte</strong></td><td>Constancia de inscripción formalizada; revisar notificaciones por SIMO y correo; fechas de reclamación.</td><td>SIMO y cnsc.gov.co.</td></tr>
</tbody>
</table>

<h2>Un plan de cuatro semanas para ordenar tu perfil (sin inscribirte)</h2>
<ul>
<li><strong>Semana 1:</strong> reúne los originales o copias de tu cédula, títulos y certificaciones. Pide a tiempo las certificaciones laborales que te falten: a veces tardan.</li>
<li><strong>Semana 2:</strong> escanéalos con buena calidad y organízalos en una carpeta por categoría (identidad, formación, experiencia). Llena la hoja de control.</li>
<li><strong>Semana 3:</strong> si no te has registrado, crea tu cuenta en SIMO y revisa que tus datos personales coincidan con tu documento. Explora la OPEC preliminar para ver los empleos que se ajustan a tu perfil.</li>
<li><strong>Semana 4:</strong> practica para las pruebas y revisa el acuerdo definitivo cuando se publique. Todavía no hay una inscripción que formalizar, así que no pagues ni compartas tus claves.</li>
</ul>
<p>Para el estudio, el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito del Concurso Docente</a> te permite practicar el formato con preguntas de práctica (<strong>son de práctica, no preguntas oficiales</strong>). Y si tu punto débil es la parte numérica de la prueba de aptitudes, el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">Curso de Aptitud Matemática</a> fue pensado para el concurso anterior: úsalo como práctica y compáralo con el anexo técnico definitivo. Mira también <a href="/20-preguntas-frecuentes-sobre-el-concurso-docente/">20 preguntas frecuentes sobre el concurso</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}

<h2>Lo que piensan aspirantes, rectores y entidades territoriales</h2>
<p>Los <strong>aspirantes</strong> temen perder por un detalle burocrático; la CNSC responde que las situaciones individuales se resuelven en la etapa correspondiente (inscripción, verificación de requisitos mínimos, valoración de antecedentes o reclamación) y que el resultado individual se consulta en SIMO. Los <strong>rectores y directivos</strong> pueden ayudar de forma sencilla: expedir a tiempo las certificaciones laborales con cargo, funciones y fechas. Y las <strong>entidades territoriales</strong> tienen una responsabilidad central: la OPEC se construye con lo que ellas reportan y certifican, así que revisar que tus datos de vacantes sean coherentes también es un asunto de ellas.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Ya puedo inscribirme al Concurso Docente?</h3>
<p>No. Las inscripciones no han abierto y las fechas dependen del acuerdo definitivo y del cronograma que publique la CNSC. Lo que sí puedes hacer es registrarte en SIMO y organizar tus documentos.</p>
<h3>¿Qué documentos cuentan: los que tengo hoy o los que tendré al cerrar?</h3>
<p>Según el proyecto, los títulos y las certificaciones obtenidos hasta el último día del término de inscripciones. Verifica la fecha de corte en el acuerdo definitivo.</p>
<h3>¿Puedo cambiar un documento después de cargarlo?</h3>
<p>El anexo técnico contempla actualizar, modificar, reemplazar o adicionar la documentación registrada en SIMO hasta el cierre de inscripciones. Revisa la regla definitiva en el acuerdo.</p>
<h3>¿Puedo inscribirme a varios empleos?</h3>
<p>Según el proyecto, no: hay una sola inscripción por proceso, así que hay que escoger el empleo.</p>
<h3>¿Qué hago si SIMO me da un error?</h3>
<p>Guarda evidencia (capturas, fecha y hora) y radica el caso por los canales oficiales de la CNSC: mesa de ayuda y PQRSD. No entregues tus claves a terceros.</p>

<p class="notice"><strong>Empieza hoy, sin inscribirte.</strong> Descarga la <a href="/descargas/concurso-docente/control-documentos-aspirante.xlsx">hoja de control de documentos</a>, ordena tus soportes y practica con el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito</a>. Cuando salga el acuerdo definitivo, ajusta la lista a lo que exija tu empleo. Este artículo se actualizará con las reglas en firme.</p>

<h2>Para pensar</h2>
<p>Un concurso por mérito se supone que premia lo que sabes y has hecho, pero el primer filtro es administrativo: quien documenta mejor pasa y quien documenta peor se queda. <strong>¿Es justo que un buen docente con experiencia real quede fuera por un certificado mal redactado, y debería el sistema ayudarle a corregirlo o es parte del mérito saber hacerlo?</strong> ¿Y qué dice eso de las barreras que enfrentan los docentes de zonas rurales o con menos acceso a trámites?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ruta}}' => $img('concurso-simo-documentos-ruta', 467, 'Seis pasos del proceso en SIMO según el proyecto de acuerdo: registro, hoja de vida, consulta de la OPEC, selección de un empleo, pago y formalización y actualización de soportes hasta el cierre de inscripciones.', 'La ruta en SIMO que describe el anexo técnico (documento preliminar). Fuente: CNSC.'),
]);

return [
    'slug' => 'concurso-docente-errores-simo-documentos-revisar-antes-inscripcion',
    'title' => 'Concurso Docente: errores en SIMO y documentos que debes revisar antes de inscribirte',
    'excerpt' => 'Una lista de verificación para preparar tu perfil y tus soportes del Concurso Docente, según las respuestas oficiales de la CNSC, sin confundir preparación con inscripción abierta.',
    'seo_title' => 'Concurso Docente: errores en SIMO y documentos',
    'seo_description' => 'Errores frecuentes en SIMO y documentos que debes revisar antes de inscribirte al Concurso Docente, con lista de verificación y hoja de Excel gratis.',
    'focus_keyword' => 'errores en SIMO Concurso Docente',
    'cover' => '/assets/img/articulos/concurso-simo-documentos/concurso-simo-documentos-portada',
    'cover_alt' => 'Portada con el título «Errores en SIMO y documentos que debes revisar antes de inscribirte» y una lista de verificación: datos personales, títulos, soportes y empleo marcados, y la nota de que todavía no hay inscripción abierta.',
    'published_at' => '2026-10-23 12:00:00',
    'content_html' => $html,
];
