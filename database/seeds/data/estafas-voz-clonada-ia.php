<?php

declare(strict_types=1);

// "Me llamó mi jefe y parecía su voz": estafas con voz clonada y protocolo de verificación. Cifras del FBI (IC3 2024), el caso Arup,
// el estudio de la UCL sobre detección de voces falsas, la FTC, la Ley 2502 de 2025 y el informe de la Universidad de San Buenaventura
// (vía Portafolio), verificados el 9 de octubre de 2026. El texto va en nowdoc; las figuras se insertan con marcadores {{img:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/estafas-voz-clonada-ia/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>El teléfono suena un martes a las 4:40 p. m. Es la voz de tu jefe, o la del rector, o la de tu hijo. Está agitada. Necesita una transferencia "ya", un código que te acaban de enviar o un favor que "no debes comentar con nadie". Todo en esa llamada te parece auténtico, y justamente ahí está el problema: <strong>hoy una voz que suena conocida ya no prueba nada</strong>.</p>
<p>En este artículo explico cómo funciona la clonación de voz, qué dicen los datos (FBI, Hong Kong, Colombia), cuáles son las señales de alerta y, sobre todo, te dejo un <strong>protocolo de verificación</strong> listo para usar en tu empresa, tu colegio o tu familia. Fecha de la última verificación de datos y normas: 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Con unos segundos de audio publicado en redes se puede imitar una voz. Los oyentes detectan las voces falsas solo el 73 % de las veces. Lo que protege no es tener buen oído sino verificar por un segundo canal, con un número que ya tienes, y exigir doble aprobación para pagos y cambios de cuenta.</p>

<h2>Cómo funciona la clonación de voz y por qué engaña</h2>
<p>Un modelo de voz sintética se entrena con grabaciones de una persona y aprende su timbre, su ritmo y sus muletillas. Después puede "leer" cualquier texto con esa voz, incluso en tiempo real durante una llamada. La <a href="https://consumer.ftc.gov/scams/family-emergency-scams">Comisión Federal de Comercio de EE. UU. (FTC)</a> advierte que al estafador le basta un clip corto de la voz de un familiar, que puede sacar de contenido publicado en línea, y un programa de clonación. Los audios de WhatsApp, los videos de Instagram, las clases grabadas y las conferencias son material más que suficiente.</p>
<p>¿Lo notaríamos? Un estudio de la University College London, publicado en <em>PLOS ONE</em> en 2023, puso a 529 personas a distinguir voces reales de falsas: <a href="https://www.ucl.ac.uk/news/headlines/2023/aug/humans-can-detect-deepfake-speech-only-73-time-study-finds">acertaron el 73 % de las veces</a>, y entrenarlas con ejemplos mejoró poco el resultado. Los propios autores aclaran que usaron algoritmos relativamente antiguos, así que con los modelos actuales el dato probablemente sea peor. La conclusión práctica es incómoda: <strong>no puedes confiar en tu oído, tienes que confiar en un procedimiento</strong>.</p>

<h2>Qué dicen los datos: del FBI a Colombia</h2>
<p>En 2024 el <a href="https://www.ic3.gov/AnnualReport/Reports/2024_IC3Report.pdf">Centro de Quejas de Delitos en Internet del FBI (IC3)</a> recibió 859.531 denuncias y registró pérdidas por 16.600 millones de dólares, un 33 % más que en 2023. Solo el fraude de "correo empresarial comprometido" (BEC, por sus siglas en inglés: alguien se hace pasar por un jefe o proveedor para desviar un pago) causó 2.770 millones de dólares en pérdidas, con 21.442 denuncias. Es la segunda causa de pérdidas, y la clonación de voz y de video es la nueva versión de ese mismo guion.</p>
<p>El caso más citado ocurrió en Hong Kong. Un empleado de finanzas de la ingeniería Arup asistió a una videollamada con quien creía que era el director financiero y otros colegas; <a href="https://abc17news.com/money/cnn-business-consumer/2024/05/16/british-engineering-giant-arup-revealed-as-25-million-deepfake-scam-victim/">todos eran recreaciones falsas</a>. Hizo 15 transferencias por unos 200 millones de dólares de Hong Kong (cerca de 25 millones de dólares) a cinco cuentas, y solo lo descubrió una semana después, al consultar con la sede central. Dudó al principio de un correo "secreto", pero la videollamada disipó sus dudas: la presencia de "colegas" que se veían y sonaban reales fue la prueba falsa de autenticidad.</p>
<p>¿Y aquí? En Colombia no existe todavía una estadística oficial consolidada sobre estafas con voz clonada. Lo que hay son señales. Un informe del programa de Ingeniería de Sonido de la Universidad de San Buenaventura, recogido por <a href="https://www.portafolio.co/tecnologia/estafas-con-voces-clonadas-por-ia-crecieron-30-en-diciembre-y-alertan-a-expertos-en-colombia-486082">Portafolio</a>, habla de un aumento del 30 % en diciembre de 2025 (el artículo no precisa con respecto a qué periodo). La Policía Nacional reportó, a diciembre de 2025, 64 denuncias de extorsión en Bolívar, de las cuales 24 usaban modalidades digitales como voces clonadas e imágenes generadas con IA, y el Gaula registró 36 capturas relacionadas. Y la Estrategia Nacional de Seguridad Digital ubica a Colombia como el segundo país más atacado de América Latina en 2025, con el 17 % de los intentos de la región.</p>
{{img:cifras}}

<h2>Cómo suena una llamada de estafa: el patrón que se repite</h2>
<p>Cambian la voz y la tecnología, pero el guion casi no varía. Fíjate en esta combinación de elementos:</p>
<ul>
<li><strong>Una voz de autoridad o de afecto:</strong> el gerente, el rector, el contador, tu hijo, tu mamá.</li>
<li><strong>Urgencia:</strong> "es para hoy", "si no, perdemos el contrato", "me están esperando".</li>
<li><strong>Secreto:</strong> "no se lo cuentes a nadie", "es confidencial", "me da pena".</li>
<li><strong>Una forma de pago que no se puede reversar:</strong> transferencia a una cuenta nueva, billeteras digitales, criptomonedas, tarjetas de regalo, o un código que llegó por mensaje.</li>
<li><strong>Un canal que te impide verificar:</strong> te llaman desde un número desconocido, te dicen que no cuelgues o que su teléfono "está dañado".</li>
</ul>
<p>Cuando aparecen dos o más de estas señales juntas, deja de importar qué tan real suena la voz. En el colegio la versión típica es la del "rector" que pide a tesorería un pago urgente a un proveedor nuevo; en casa, la del hijo "detenido" o accidentado que necesita dinero ya. La FTC y el informe de la Universidad de San Buenaventura coinciden en el mismo consejo: <strong>no confíes en la voz, verifica por otro canal</strong>.</p>

<h2>Protocolo de verificación para empresas, colegios y familias</h2>
<p>Este es el recurso que te prometí. Está pensado para aplicarse en menos de dos minutos y para que no dependa de que alguien "se dé cuenta". Imprímelo y pégalo junto al teléfono de tesorería, o compártelo en el grupo familiar.</p>
{{img:protocolo}}
<table>
<thead><tr><th>Situación</th><th>Regla de verificación</th></tr></thead>
<tbody>
<tr><td>Piden un pago nuevo o un cambio de cuenta bancaria</td><td>Se confirma llamando al número que <em>ya está registrado</em> (no al que te dan). Lo aprueban dos personas y queda por escrito.</td></tr>
<tr><td>Piden un código, una clave o datos personales</td><td>Nunca se entregan por teléfono, aunque la voz sea la de alguien conocido. Los códigos son personales e intransferibles.</td></tr>
<tr><td>Llamada "urgente" de un directivo</td><td>Pausa de 20 segundos, se cuelga y se devuelve la llamada por el canal oficial. Toda urgencia real resiste esa espera.</td></tr>
<tr><td>Videollamada con peticiones de dinero</td><td>Se pide que la persona haga algo imprevisto (un gesto, una pregunta que solo ella sabría) y se confirma por otro medio antes de actuar.</td></tr>
<tr><td>Un familiar "en problemas" pide dinero</td><td>Se usa la <strong>palabra clave familiar</strong> acordada de antemano, o se llama directamente a esa persona o a otro familiar.</td></tr>
<tr><td>Te piden guardar el secreto</td><td>El secreto es una señal de alerta, no una razón para obedecer. Se consulta con alguien de confianza.</td></tr>
</tbody>
</table>
<p>Algunas recomendaciones del informe de la Universidad de San Buenaventura son útiles para adaptar el protocolo: pausar al menos 20 segundos antes de actuar, hacer una pregunta que solo la persona real sabría responder, escuchar el audio con audífonos para notar cortes o finales antinaturales, guardar la grabación y denunciar. Como lo resume el docente Marcelo Herrera: "Lo que protege no es la tecnología, sino la calma para verificar".</p>

<h3>Cómo montar la palabra clave familiar</h3>
<ul>
<li>Elíjanla en persona, no por chat; que sea una palabra o frase que nadie adivine y que no esté en ninguna red social.</li>
<li>Úsenla solo en emergencias de dinero o de seguridad; así conserva su valor.</li>
<li>Explíquenla también a los abuelos y a los adolescentes: son los objetivos más frecuentes de este tipo de llamadas.</li>
</ul>

<h3>Cómo protegerte en el trabajo y en el colegio</h3>
<p>Para una empresa pequeña o una institución educativa, el cambio más barato y más eficaz es <strong>separar quien pide el pago de quien lo autoriza</strong> y estandarizar el documento con el que se pide. Una orden de pago con un formato fijo, con el valor también escrito en letras, la cuenta registrada y dos firmas, dificulta que una voz urgente la reemplace. Los cheques tenían esa lógica; las transferencias la perdieron. Si usas Excel para tus órdenes de pago, el <a href="/producto/convertidor-de-numeros-a-letras-en-excel/">Convertidor de números a letras en Excel</a> escribe el valor en palabras de forma automática (hay también una <a href="/herramientas/numero-a-letras/">versión gratuita en línea</a>), y la <a href="/producto/factura-con-envio-por-correo-al-cliente/">Factura con envío por correo al cliente</a> mantiene siempre el mismo remitente, formato y datos bancarios, de modo que cualquier cambio de cuenta salta a la vista como una anomalía.</p>
{{productos:convertidor-de-numeros-a-letras-en-excel,factura-con-envio-por-correo-al-cliente}}

<h2>Qué hacer si ya hiciste la transferencia</h2>
<ol>
<li><strong>Llama de inmediato a tu banco</strong> y pide que intenten bloquear o reversar la operación. En fraudes empresariales cada hora cuenta: según el resumen que hizo <a href="https://www.proofpoint.com/us/blog/email-and-cloud-threats/email-attacks-drive-record-cybercrime-losses-2024">Proofpoint</a> del informe del FBI, su equipo de recuperación de activos logró congelar el 66 % de las transferencias de fraude empresarial que atendió en 2024.</li>
<li><strong>Guarda las pruebas:</strong> el audio, el número desde el que llamaron, los mensajes, los comprobantes.</li>
<li><strong>Denuncia.</strong> En Colombia puedes hacerlo en el <a href="https://caivirtual.policia.gov.co">CAI Virtual de la Policía Nacional</a> y ante la Fiscalía General de la Nación.</li>
<li><strong>Cambia claves y activa la verificación en dos pasos</strong> en tu correo y banca virtual, por si el estafador también obtuvo credenciales.</li>
</ol>

<h2>Lo que dice la ley en Colombia</h2>
<p>La <a href="https://normograma.mintic.gov.co/mintic/compilacion/docs/ley_2502_2025.htm">Ley 2502 de 2025</a>, sancionada el 28 de julio de 2025 y publicada en el Diario Oficial 53.198, definió el <em>deepfake</em> como el registro audiovisual (fotos, videos o grabaciones de sonido) falso creado o modificado con IA, y agregó al delito de falsedad personal (artículo 296 del Código Penal) un agravante cuando la suplantación se hace con inteligencia artificial: según el texto, la multa aumenta hasta en una tercera parte, siempre que la conducta no constituya otro delito. La ley también ordena formular una política pública sobre el uso de IA para engañar o dañar. Ten en cuenta que la estafa y la extorsión tienen sus propios delitos y penas; consulta con un abogado o la Fiscalía cómo se tipificaría tu caso y revisa en la norma la fecha de vigencia del agravante, porque este artículo no es asesoría legal.</p>

<h2>Cómo hablar de esto con estudiantes y familias</h2>
<p>Los adolescentes comparten su voz y la de sus familias en redes todo el día, y sus abuelos son un blanco frecuente. Un ejercicio de 15 minutos sirve más que una charla: pide a los estudiantes que redacten, en parejas, un guion de "llamada falsa" y que otra pareja identifique las cinco señales del patrón (autoridad, urgencia, secreto, pago irreversible, canal sin verificación). Después, que cada familia acuerde su palabra clave. Si das clase de tecnología o informática, el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> te ayuda a preparar recursos de alfabetización digital por materia sin partir de cero, y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> permite convertir este protocolo en un quiz de comprensión en minutos (<a href="/examenes/demo/">hay una demostración gratis</a>).</p>
<p>Si quieres ampliar el panorama de lo que la IA puede y no puede hacer, te recomiendo <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">"La IA no te reemplazará, pero quien la domine sí"</a> y <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">"La gran mentira de la IA"</a>, donde reviso qué entiende de verdad una máquina y qué leyes existen en Colombia, Latinoamérica y el mundo.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuántos segundos de audio necesita un estafador para clonar mi voz?</h3>
<p>No hay una cifra única y confiable: depende de la herramienta y de la calidad del audio. Las advertencias oficiales hablan de "un clip corto". Lo prudente es asumir que cualquier audio público (historias, videos, mensajes de voz reenviados) basta para una imitación convincente.</p>
<h3>¿Se puede detectar una voz clonada?</h3>
<p>A veces. Los cortes, las pausas raras, la ausencia de respiración o un tono demasiado plano pueden delatarla, pero los estudios muestran que las personas aciertan alrededor del 73 % y los modelos mejoran cada año. Por eso el protocolo no depende de detectar la falsedad, sino de verificar la solicitud.</p>
<h3>¿Qué es una palabra clave familiar y cómo se usa?</h3>
<p>Es una palabra o frase acordada en persona que solo la familia conoce. Si alguien llama pidiendo dinero con urgencia, se le pide la palabra; si no la sabe, se cuelga y se llama a la persona directamente. No debe publicarse ni escribirse en chats.</p>
<h3>¿Mi empresa necesita software especial contra estas estafas?</h3>
<p>No para empezar. Los controles más efectivos son de proceso: doble aprobación, devolución de llamada a números registrados, plantillas de pago estandarizadas y capacitación. El software de detección complementa, pero no reemplaza esas reglas.</p>
<h3>¿Qué hago si mi voz o la de mi rector fue clonada y circula en redes?</h3>
<p>Guarda capturas y enlaces, reporta el contenido a la plataforma, avisa a tu comunidad por los canales oficiales y presenta la denuncia en el CAI Virtual o ante la Fiscalía.</p>

<p class="notice"><strong>Pasa de la información a la acción.</strong> Estandariza tus órdenes de pago con el <a href="/producto/convertidor-de-numeros-a-letras-en-excel/">Convertidor de números a letras en Excel</a>, envía facturas siempre con el mismo formato usando la <a href="/producto/factura-con-envio-por-correo-al-cliente/">Factura con envío por correo</a> y, si enseñas, lleva el tema al aula con el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>. Y comparte este artículo con quien maneja los pagos de tu casa o tu institución: es gratis y puede ahorrar mucho dinero.</p>

<h2>Para pensar</h2>
<p>Durante siglos, reconocer la voz de alguien fue la forma más íntima de confiar en él. Si esa prueba ya no sirve, <strong>¿deberíamos acostumbrarnos a desconfiar por defecto de quienes más queremos, o rediseñar nuestras instituciones para que la confianza no dependa de una voz?</strong> ¿Y quién debería asumir el costo cuando una empresa, un colegio o una familia es engañada: la víctima, el banco, las plataformas que alojan los audios o quienes desarrollan estas herramientas?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:cifras}}' => $img('estafas-voz-clonada-ia-cifras', 573, 'Cuatro tarjetas con cifras: 16.600 millones de dólares en pérdidas por ciberdelitos denunciadas al FBI en 2024, 2.770 millones por fraude de correo empresarial, 25 millones transferidos por un empleado de Arup tras una videollamada falsa y 73 % de acierto al detectar voces falsas.', 'Pérdidas y límites de la detección humana. Fuentes: FBI IC3 2024, CNN sobre Arup (2024) y Mai et al., PLOS ONE (2023).'),
    '{{img:protocolo}}' => $img('estafas-voz-clonada-ia-protocolo', 600, 'Protocolo de verificación en cuatro pasos: pausa, cuelga, verifica por otro canal y confirma entre dos personas.', 'Protocolo de verificación en cuatro pasos antes de pagar o compartir datos.'),
]);

return [
    'slug' => 'estafas-voz-clonada-ia-protocolo-verificacion',
    'title' => '"Me llamó mi jefe y parecía su voz": cómo funcionan las estafas con inteligencia artificial y cómo evitar caer en ellas',
    'excerpt' => 'Con unos segundos de audio se puede clonar una voz. Qué dicen el FBI, el caso Arup y las cifras en Colombia, las señales de alerta y un protocolo de verificación para empresas, colegios y familias.',
    'seo_title' => 'Estafas con voz clonada por IA: cómo evitarlas',
    'seo_description' => 'Cómo funcionan las estafas con voz clonada por IA, señales de alerta y un protocolo de verificación para pagos, empresas, colegios y familias en Colombia.',
    'focus_keyword' => 'estafas con voz clonada',
    'cover' => '/assets/img/articulos/estafas-voz-clonada-ia/estafas-voz-clonada-ia-portada',
    'cover_alt' => 'Pantalla de un teléfono con una llamada entrante de "Jefe / Rector", una onda de voz y el mensaje "Necesito una transferencia ya. No se lo digas a nadie", con alertas de voz familiar, urgencia y secreto y el consejo de colgar y volver a llamar.',
    'published_at' => '2026-10-13 12:00:00',
    'content_html' => $html,
];
