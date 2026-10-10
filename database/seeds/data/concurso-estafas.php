<?php

declare(strict_types=1);

// "Estafas alrededor del Concurso Docente: cómo reconocerlas antes de pagar". Fuentes verificadas el 9 de octubre de 2026: canales oficiales (cnsc.gov.co y simo.cnsc.gov.co según guías consultadas), proyecto de anexo técnico y matriz de respuestas de la CNSC (documentos preliminares, sept. 2026), Constitución art. 125. No se encontró una alerta oficial específica y no se afirma. Script y lista probados; dominios falsos de ejemplo inventados.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/estafas-concurso-docente/' . $name;
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
<p>Un concurso con miles de aspirantes ansiosos, mucho dinero en juego y información dispersa en redes sociales es un terreno ideal para los estafadores. Aparecen mensajes que prometen "asegurar tu plaza", páginas idénticas a las oficiales que piden "el pago de tu inscripción", cuentas que venden "las preguntas reales" y falsos funcionarios que escriben por WhatsApp. Casi siempre explotan lo mismo: <strong>tu urgencia y tu miedo a quedar por fuera</strong>.</p>
<p>Este artículo no se basa en una alerta específica (no encontré una alerta oficial reciente de la CNSC sobre este concurso y no la invento), sino en lo que se puede verificar: los canales oficiales, el principio de mérito y las señales clásicas de estafa. Incluye una <a href="/descargas/estafas-concurso/lista-verificacion-estafas-concurso-docente.xlsx">lista de verificación de quince preguntas en Excel</a> y un <a href="/descargas/estafas-concurso/verificar_enlace.py">verificador de enlaces en Python</a>, ambos probados. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> La información del concurso se consulta únicamente en los canales oficiales de la CNSC (portal y SIMO), y las reglas definitivas están en los documentos definitivos de la convocatoria. Esta lista ayuda a detectar señales de estafa, pero <strong>no demuestra que algo sea legítimo</strong>. Si ya pagaste o diste datos, ve a la sección "Si caíste" y actúa de inmediato. Este artículo no sustituye asesoría jurídica ni la de las autoridades.</p>

<h2>Lo que sí es oficial (para comparar)</h2>
<ul>
<li><strong>El portal y la plataforma de la CNSC.</strong> El portal institucional está en cnsc.gov.co y la plataforma de inscripción, <strong>SIMO</strong>, en simo.cnsc.gov.co. Según las guías consultadas, el SIMO es la herramienta para registrar la hoja de vida, inscribirse a un empleo, pagar los derechos de participación y seguir las alertas del proceso, y puede usarse gratuitamente. Escribe estas direcciones a mano; no entres por mensajes.</li>
<li><strong>Los derechos de participación.</strong> Según el proyecto de anexo técnico y la matriz de respuestas de la CNSC (septiembre de 2026, documentos preliminares), el costo de la inscripción es de 1,5 salarios mínimos diarios, y para quienes se inscriben en las vacantes reservadas a personas con discapacidad la inscripción es gratuita; confirma montos y reglas en el acuerdo definitivo. Se paga <strong>dentro del proceso oficial</strong> (en procesos anteriores, a través de PSE en el SIMO o en entidades bancarias indicadas por la CNSC), no a cuentas personales.</li>
<li><strong>El mérito.</strong> La Constitución (artículo 125) establece que el ingreso a los cargos de carrera se hace por el cumplimiento de los requisitos y condiciones que fije la ley para determinar los méritos y calidades de los aspirantes. <strong>Nadie puede venderte ni "asegurarte" una plaza.</strong></li>
</ul>

<h2>Las ocho estafas más frecuentes</h2>
{{img:senales}}
<ol>
<li><strong>"Plaza o puntaje garantizado".</strong> Contradice el principio de mérito. Quien lo ofrece te está mintiendo o te está proponiendo algo ilegal, y en ese caso tú también quedarías expuesto.</li>
<li><strong>Páginas que imitan a la CNSC o al SIMO.</strong> Buscan tu dinero o tus datos (nombre, documento, contraseña). Se anuncian con enlaces en mensajes, anuncios patrocinados o resultados de búsqueda.</li>
<li><strong>"Preguntas reales" o "filtraciones".</strong> Las pruebas no se venden; es un cebo clásico y, además, puede ser delito.</li>
<li><strong>Cobros por "tramitar" tu inscripción.</strong> La inscripción la haces tú; si alguien te cobra por hacer lo que puedes hacer gratis en la plataforma oficial, desconfía.</li>
<li><strong>Mensajes de "tu inscripción está incompleta".</strong> Phishing: usa urgencia y enlaces. Entra por la dirección oficial y revisa tu cuenta.</li>
<li><strong>Falsos funcionarios.</strong> Escriben desde números y correos personales, y piden contraseñas, códigos de verificación o datos bancarios. Nadie legítimo necesita tu contraseña ni tus códigos.</li>
<li><strong>Simulacros y cursos "oficiales" o "garantizados".</strong> Los simulacros de terceros no son material oficial de la CNSC y ningún curso garantiza un resultado (ver la <a href="/concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica/">rúbrica para evaluar simulacros</a>).</li>
<li><strong>Venta de "certificados".</strong> Títulos o certificaciones de experiencia "arregladas" son falsedad documental: pueden sacarte del concurso y traerte consecuencias legales.</li>
</ol>
<p>No es un fenómeno solo colombiano: en Brasil, por ejemplo, el gobierno federal tuvo que actuar para derribar sitios falsos relacionados con el "Concurso Nacional Unificado" (el "Enem de los concursos"), que imitaban la página oficial para captar datos de los candidatos. El patrón se repite en todas partes: <strong>un evento masivo, una página oficial que copiar y un aspirante apurado</strong>.</p>

<h2>El enlace: cómo leerlo bien</h2>
<p>El engaño más común es el enlace que "parece" oficial. La regla: lo que cuenta es el <strong>nombre del servidor</strong>, que va entre "https://" y la primera barra, y en particular <strong>cómo termina</strong>. Un enlace es de la CNSC solo si el servidor es exactamente <code>cnsc.gov.co</code> o termina en <code>.cnsc.gov.co</code> (como <code>simo.cnsc.gov.co</code>). Todo lo que ponga "cnsc.gov.co" pero termine en otra cosa es una imitación. Escribí un script pequeño que aplica esta regla (la función central, de cuatro líneas):</p>
<pre><code>def es_dominio_oficial(url):
    if "://" not in url:
        url = "https://" + url
    host = (urlparse(url).hostname or "").lower().rstrip(".")
    return host == OFICIAL or host.endswith("." + OFICIAL), host</code></pre>
<p>Y lo probé con siete enlaces, dos reales y cinco imitaciones inventadas (con dominios de ejemplo, no de sitios reales):</p>
<pre><code>OFICIAL     www.cnsc.gov.co                               <- https://www.cnsc.gov.co/
OFICIAL     simo.cnsc.gov.co                              <- https://simo.cnsc.gov.co/
NO OFICIAL  cnsc.gov.co.inscripciones-docentes.example    <- https://cnsc.gov.co.inscripciones-docentes.example/pago
NO OFICIAL  simo-cnsc.gov.co.pago-seguro.example          <- https://simo-cnsc.gov.co.pago-seguro.example/
NO OFICIAL  www.cnsc-gov.example                          <- https://www.cnsc-gov.example/concurso
NO OFICIAL  sitio-falso.example                           <- https://cnsc.gov.co@sitio-falso.example/
NO OFICIAL  simo.cnsc.gov.co.evil.example                 <- https://simo.cnsc.gov.co.evil.example/</code></pre>
{{img:enlaces}}
<p>Observa los trucos: el nombre oficial al <em>principio</em> de una dirección más larga (<code>cnsc.gov.co.inscripciones-docentes.example</code>), un guion en lugar de un punto (<code>cnsc-gov</code>), el símbolo <code>@</code> que hace que lo anterior sea solo un "usuario" y lo que cuenta sea lo de después, y un subdominio oficial seguido de un dominio ajeno. Con el script se verifica la forma; pero <strong>un enlace oficial no basta para confiar</strong>: lo más seguro sigue siendo escribir tú la dirección.</p>

<h2>La lista de verificación de quince preguntas</h2>
<p>El libro trae una lista con quince preguntas, tres de ellas críticas (⚠): ¿promete asegurarte una plaza o un puntaje?, ¿te pide dinero para "reservar" tu cupo?, ¿ofrece las preguntas de la prueba? Otras: ¿el enlace pertenece al dominio oficial?, ¿escribiste la dirección tú?, ¿te pide contraseñas o códigos?, ¿presiona con urgencia?, ¿se presenta como funcionario desde un número personal?, ¿puedes identificar quién cobra y con qué soporte?, ¿hay condiciones por escrito? Cada pregunta indica la respuesta segura, y el libro calcula el veredicto: <strong>si una sola de las tres críticas es insegura, el resultado es "ALTO: detente y verifica por los canales oficiales"</strong>; con tres o más señales, "MEDIO"; con una o dos, "BAJO-MEDIO". Lo probé con varios escenarios: todas las respuestas seguras dan "Sin señales en esta lista: igual verifica en el portal oficial", y marcar solo "promete plaza" dispara "ALTO".</p>

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación.</strong> A una aspirante le llega por WhatsApp un mensaje de un "asesor de la CNSC": "Su inscripción está incompleta y perderá su cupo hoy. Pague 180.000 pesos a esta cuenta personal y le enviamos su confirmación. Responda con el código que le llegará por mensaje". Trae un enlace que dice "cnsc.gov.co.confirmar-cupo.example".</p>
<p><strong>Pregunta.</strong> ¿Qué debe hacer?</p>
<ol type="A">
<li>Pagar rápido para no perder el cupo.</li>
<li>No pagar ni dar el código; entrar a SIMO escribiendo la dirección oficial a mano, revisar el estado de su inscripción y, si quiere, reportar el mensaje por los canales oficiales y denunciar.</li>
<li>Responder pidiendo más información al mismo número.</li>
<li>Pagar la mitad como garantía.</li>
</ol>
<p><strong>Respuesta:</strong> B. El mensaje reúne cuatro señales: urgencia, pago a una cuenta personal, petición de un código y un enlace que termina en un dominio ajeno (el verificador lo marcaría como no oficial). La confirmación de una inscripción se consulta en la plataforma oficial, no por mensajes. A y D regalan dinero; C mantiene la conversación con quien intenta engañarte y revela que tu número es útil.</p>

<h2>Si caíste</h2>
<p>Pasa a cualquiera. Lo importante es actuar rápido, y el libro trae una hoja "Registro_de_incidente" con los pasos:</p>
<ol>
<li><strong>Guarda las pruebas:</strong> capturas del mensaje, el sitio, el número o el correo, con fecha y hora.</li>
<li><strong>Deja de responder</strong> y no envíes más datos ni dinero.</li>
<li><strong>Cambia tu contraseña</strong> (y las de otras cuentas si la repetías) y activa la verificación en dos pasos donde exista.</li>
<li><strong>Si pagaste,</strong> contacta de inmediato a tu banco o al medio de pago, con los soportes.</li>
<li><strong>Reporta</strong> el sitio o el número por los canales oficiales de la entidad y <strong>denuncia</strong> ante las autoridades (por ejemplo, el CAI Virtual de la Policía Nacional; verifica el canal vigente).</li>
<li><strong>Revisa tu cuenta de SIMO</strong> y tu correo por si fueron modificados, y avisa a otros aspirantes.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En todo el mundo, los eventos masivos (concursos, loterías, becas, mundiales) atraen estafas, y las autoridades repiten el mismo consejo: usar los canales oficiales y desconfiar de la urgencia. En Colombia, la dificultad es que la información del concurso circula sobre todo en redes sociales y grupos de mensajería, donde un rumor y una estafa se ven igual. Para los <strong>aspirantes</strong>, la mejor defensa es un hábito: escribir la dirección oficial y verificar antes de pagar; para los <strong>formadores y plataformas honestas</strong>, ser transparentes sobre qué son y qué no (no oficiales, sin promesas); para las <strong>secretarías de educación y las instituciones</strong>, difundir los canales oficiales entre sus docentes; y para las <strong>familias</strong>, apoyar sin presionar. Ver también <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">errores en SIMO y documentos</a> y <a href="/concurso-docente-titulo-opec-compatibilidad-sin-rumores-matriz-trazabilidad/">compatibilidad título-OPEC sin rumores</a>.</p>

<h2>Practica con transparencia</h2>
<p>Para practicar para la prueba sin riesgos, una opción es <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año). Te digo con claridad lo que es: <strong>práctica, no material oficial de la CNSC</strong>, y no garantiza puntaje ni nombramiento; evalúala, como a cualquier otra, con la <a href="/concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica/">rúbrica de simulacros</a>. También está la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio y el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Y para el estudio de la normativa, el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-vacantes-por-territorio-y-area-que-se-puede-deducir-y-que-no/">vacantes por territorio</a> y <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el cronograma</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Puedo pagar a alguien para que me asegure una plaza en el Concurso Docente?</h3>
<p>No. Las plazas se ganan por mérito (Constitución, art. 125); quien ofrece asegurarlas miente o propone algo ilegal.</p>
<h3>¿Cuál es el sitio oficial para inscribirme?</h3>
<p>El portal de la CNSC (cnsc.gov.co) y la plataforma SIMO (simo.cnsc.gov.co). Escribe la dirección a mano y confirma las vigentes en el portal.</p>
<h3>¿Cuánto cuesta inscribirse?</h3>
<p>Según el proyecto de anexo técnico (documento preliminar), 1,5 salarios mínimos diarios, con inscripción gratuita para las vacantes reservadas a personas con discapacidad. Confirma el monto en el acuerdo definitivo y paga solo dentro de la plataforma oficial.</p>
<h3>¿Cómo sé si un enlace es oficial?</h3>
<p>Mira cómo termina el nombre del servidor: debe ser cnsc.gov.co o terminar en .cnsc.gov.co. Y aun así, es más seguro escribir la dirección tú mismo.</p>
<h3>¿Qué hago si pagué en un sitio falso?</h3>
<p>Guarda las pruebas, contacta de inmediato a tu banco o medio de pago, cambia tus contraseñas y denuncia ante las autoridades y la entidad.</p>

<p class="notice"><strong>Antes de pagar algo.</strong> Descarga la <a href="/descargas/estafas-concurso/lista-verificacion-estafas-concurso-docente.xlsx">lista de verificación</a>, respóndela y corre el <a href="/descargas/estafas-concurso/verificar_enlace.py">verificador de enlaces</a>. Si hay una sola señal crítica, detente y verifica por los canales oficiales.</p>

<h2>Para pensar</h2>
<p>Las estafas funcionan porque el concurso despierta esperanza y miedo a la vez, y porque la información oficial es difícil de encontrar y de entender. <strong>¿De quién es la responsabilidad de proteger a los aspirantes: de cada persona que debe aprender a verificar, de la entidad que debería comunicar con más claridad, o de las plataformas y redes donde circulan los anuncios falsos? Y si miles de aspirantes caen cada año, ¿no será que el problema no es de ellos, sino de cómo está diseñada la información?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:senales}}' => $img('estafas-concurso-docente-senales', 499, 'Tabla con cuatro señales de estafa: plaza o puntaje garantizado, preguntas filtradas, cobro por inscribirte y petición de contraseña o códigos, con por qué es alerta y qué hacer.', 'Lo que debe encender la alarma.'),
    '{{img:enlaces}}' => $img('estafas-concurso-docente-enlaces', 499, 'Tabla con cuatro enlaces de ejemplo y el dominio del que dependen: el de SIMO es oficial, y tres imitaciones inventadas no lo son.', 'Lo que importa es el final del nombre del servidor.'),
]);

return [
    'slug' => 'concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist',
    'title' => 'Estafas alrededor del Concurso Docente: cómo reconocerlas antes de pagar, con una lista de verificación',
    'excerpt' => 'Las ocho estafas más frecuentes alrededor de un concurso de méritos, cómo leer un enlace para saber si es oficial, una lista de verificación de quince preguntas probada y qué hacer si caíste, con un verificador de enlaces en Python.',
    'seo_title' => 'Estafas del Concurso Docente: cómo reconocerlas',
    'seo_description' => 'Cómo reconocer estafas alrededor del Concurso Docente: plazas garantizadas, páginas y enlaces falsos, con lista de verificación y verificador.',
    'focus_keyword' => 'estafas Concurso Docente',
    'cover' => '/assets/img/articulos/estafas-concurso-docente/estafas-concurso-docente-portada',
    'cover_alt' => 'Portada "Estafas alrededor del Concurso Docente: cómo reconocerlas antes de pagar" con señales de alerta (plaza garantizada, preguntas reales de la prueba, petición de contraseña) descartadas y la dirección oficial escrita a mano, marcada.',
    'published_at' => '2026-12-11 12:00:00',
    'content_html' => $html,
];
