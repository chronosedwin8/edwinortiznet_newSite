<?php

declare(strict_types=1);

// "Flujo de aprobación digital". Fuentes consultadas el 10-oct-2026: documentación de Microsoft Learn sobre aprobaciones de Power Automate (tipos y límite con respuestas personalizadas) y fuentes sectoriales sobre licencias de conectores estándar (hedged). Ley 1581 de 2012; política cero papel (verificar texto vigente). Diseñador verificado en Excel 16 (umbrales 500.000/500.001/5.000.000/5.000.001); analizador verificado con cálculo independiente (Compra mediana 18, Rectoría 52, pendiente 95 h).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/flujo-aprobacion/' . $name;
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
<p>"Te mandé el correo la semana pasada." "No me llegó." "Pregúntale a la coordinadora, ella dijo que sí." En muchos colegios, las solicitudes (una compra, un permiso, el uso de un salón) viajan por correos, mensajes de WhatsApp y conversaciones de pasillo. Nadie sabe en qué estado está cada una, quién debía decidir ni cuánto lleva esperando. <strong>Lo que no se registra no se puede medir, y lo que no se mide no se puede mejorar.</strong></p>
<p>Este artículo describe cómo pasar de la cadena de correos a un <strong>flujo de aprobación digital</strong>: un formulario que captura la solicitud, una lista que guarda su estado, un flujo que la enruta, avisa y escala, y una medición de tiempos. Incluye un <a href="/descargas/flujo-aprobacion/disenador-flujo-aprobacion.xlsx">diseñador de reglas en Excel</a> (reglas por monto, plazos, escalamiento y delegados, con un simulador) y un <a href="/descargas/flujo-aprobacion/analizador_aprobaciones.py">analizador en Python</a> con un <a href="/descargas/flujo-aprobacion/solicitudes-ejemplo.csv">CSV de ejemplo</a>. El libro se verificó en Microsoft Excel 16 y el script con un cálculo independiente; los datos son ficticios. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Es una guía de diseño, no un tutorial paso a paso de un producto ni asesoría jurídica o contable. Los montos y los niveles de aprobación del ejemplo son ficticios: las reglas reales de compras y contratación las fijan el manual de contratación de tu institución y la normativa que le aplique. Los nombres de productos (Microsoft Forms, Lists, Power Automate) son ejemplos; en Google Workspace y otras plataformas hay equivalentes. Licencias, conectores y límites cambian: verifícalos en la documentación de tu plan.</p>

<h2>Por qué falla el correo como sistema de aprobación</h2>
<ul>
<li><strong>No hay estado visible:</strong> nadie sabe si la solicitud está pendiente, aprobada o perdida.</li>
<li><strong>No hay plazo ni escalamiento:</strong> si el aprobador no responde, nada ocurre.</li>
<li><strong>No hay registro confiable:</strong> el "sí" por pasillo no deja huella; una auditoría o una discusión posterior se vuelven un problema de memoria.</li>
<li><strong>Depende de personas:</strong> si el aprobador se ausenta, la solicitud se queda esperando.</li>
</ul>
<p>Un flujo bien diseñado no hace que las personas decidan mejor, pero sí que <strong>las decisiones queden registradas, tengan plazo y no dependan de la memoria de nadie</strong>.</p>

<h2>Las cuatro piezas</h2>
{{img:piezas}}
<ul>
<li><strong>Formulario:</strong> captura la solicitud con los campos mínimos para decidir y enrutar. Cada campo debe servir para algo; pedir "por si acaso" datos de terceros va contra la minimización de datos (ver la Ley 1581 de 2012 de protección de datos personales).</li>
<li><strong>Lista:</strong> una tabla compartida que guarda cada solicitud, su estado, quién decidió y cuándo. Es la fuente de verdad.</li>
<li><strong>Flujo:</strong> la automatización que, al llegar una solicitud, la enruta al aprobador correcto, le avisa, espera la respuesta, escala si vence el plazo y notifica el resultado.</li>
<li><strong>Medición:</strong> una revisión periódica de los tiempos por tipo y por aprobador.</li>
</ul>
<p>En el ecosistema de Microsoft 365, un camino habitual es Microsoft Forms o una lista de Microsoft Lists para capturar, Power Automate para el flujo y su acción de aprobaciones, y Excel para medir. En Google Workspace, el equivalente suele armarse con Formularios de Google, Hojas de cálculo y Apps Script, o con una herramienta como AppSheet. <strong>Elegir una de las dos depende de lo que tu institución ya use</strong> (ver <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">más plataformas no es mejor</a>), no de cuál sea más moderna.</p>

<h2>Las reglas: la parte que sí es de la institución</h2>
<p>La automatización es fácil; las reglas son lo difícil. El libro <em>disenador-flujo-aprobacion.xlsx</em> tiene una hoja <em>Reglas</em> donde defines, por tipo de solicitud y monto, quién aprueba, en cuánto tiempo, a quién se escala si vence y quién es el delegado si el aprobador está ausente. Una hoja <em>Simulador</em> toma un tipo y un monto y responde quién debe aprobar. En el ejemplo ficticio, una compra de $400.000 la aprueba Coordinación (plazo de 24 horas); de $1.200.000, Coordinación y Rectoría (48 horas); y de $6.000.000, el Consejo directivo (120 horas). Probé los límites exactos: $500.000 sigue en el primer nivel, $500.001 pasa al segundo, y $5.000.000 sigue en el segundo mientras $5.000.001 pasa al tercero. La fórmula que encuentra el umbral aplicable usa <code>MAX.SI.CONJUNTO</code> (<code>MAXIFS</code>) y luego <code>INDICE</code> y <code>COINCIDIR</code> (<code>INDEX</code> y <code>MATCH</code>):</p>
<pre><code>' Umbral aplicable: el mayor "desde monto" que no supera el monto de la solicitud
=MAX.SI.CONJUNTO(Reglas!C5:C24; Reglas!B5:B24; B3; Reglas!C5:C24; "<="&B4)   ' español
=MAXIFS(Reglas!C5:C24, Reglas!B5:B24, B3, Reglas!C5:C24, "<="&B4)             ' inglés

' Fila de la regla y aprobador
=COINCIDIR(B3&"|"&B6; Reglas!A5:A24; 0)       =INDICE(Reglas!D5:D24; B7)</code></pre>
<p>Las reglas deben salir del manual y no de la herramienta: si no existe un manual que diga quién aprueba qué, el primer entregable no es un flujo, sino ese acuerdo.</p>

<h2>El flujo, en lenguaje llano</h2>
<pre><code>1. Llega una solicitud nueva (formulario o lista).
2. Se lee el tipo y el monto; se busca en las reglas quién aprueba.
3. Se registra la solicitud como "Pendiente" y se envía la aprobación (correo y Teams).
4. En paralelo, se arranca un temporizador igual al plazo de la regla.
5. Si el aprobador responde: se registra la decisión, quién, cuándo y el comentario.
   Si el plazo vence: se notifica al aprobador y se escala a la persona definida.
6. Se avisa al solicitante del resultado y se actualiza el estado.</code></pre>
<p>En Power Automate, por ejemplo, la acción de aprobaciones permite varios tipos (aprobar o rechazar con el primero que responda, que todos deban aprobar, o respuestas personalizadas); los nombres exactos pueden cambiar con las versiones, y la documentación de Microsoft advierte que ciertas combinaciones con muchos destinatarios pueden fallar por límites de tamaño de datos, así que conviene probar antes. Una regla de diseño que ahorra problemas: <strong>el flujo debe pertenecer a la institución, no a la cuenta personal de una sola persona</strong>, con al menos dos propietarios; de lo contrario, el día que esa persona se vaya, el flujo deja de funcionar.</p>
<p>Sobre licencias: según la documentación y fuentes del sector, los conectores estándar (como Forms, SharePoint, Outlook, Teams y las aprobaciones) suelen estar incluidos en planes de Microsoft 365 que incluyen Power Automate, y un solo conector premium puede cambiar los requisitos de licencia del flujo. No lo des por hecho: confirma con el administrador de tu inquilino y con la documentación vigente, sobre todo en planes educativos.</p>

<h2>Medir: el analizador de aprobaciones</h2>
<p>El script <code>analizador_aprobaciones.py</code> lee el CSV exportado de la lista (columnas <code>id, tipo, solicitante, aprobador, creada, respondida, estado</code>) y calcula, con la biblioteca estándar de Python 3.8 o superior, la mediana y el percentil 90 de las horas de respuesta por tipo y por aprobador, y las solicitudes pendientes que ya superaron su plazo.</p>
<pre><code>python analizador_aprobaciones.py solicitudes-ejemplo.csv --sla Compra=48 Permiso=24 Espacio=48 --ahora "2027-01-12 07:00"

Solicitudes: 23 | pendientes: 2

Por tipo (horas de respuesta):
  Compra       n=10  mediana=18.0   p90=70.0
  Espacio      n=5   mediana=10.0   p90=20.0
  Permiso      n=6   mediana=3.0    p90=5.0

Por aprobador (posibles cuellos de botella):
  Rectoría       n=5   mediana=52.0   p90=90.0
  Secretaría     n=2   mediana=7.0    p90=8.0
  Coordinación   n=14  mediana=5.0    p90=12.0

Pendientes que ya superaron su plazo:
  S-023 (Compra, Rectoría): 95.0 h de espera; plazo 48 h</code></pre>
<p>Con los 23 registros ficticios, la mediana de las compras (18 horas) esconde dos realidades: cuando decide Coordinación se resuelven en 4 a 10 horas, y cuando decide Rectoría tardan entre 26 y 90 (mediana de 52 horas). <strong>El promedio por tipo de solicitud ocultaba el cuello de botella; el desglose por aprobador lo muestra.</strong> Esa conclusión no es una acusación contra una persona: lo normal es que quien aprueba lo más grande también tenga la agenda más cargada, y eso se arregla con delegación, con reglas por monto o con reuniones de aprobación periódicas, no con regaños. Los tiempos son de calendario, no de horas hábiles: ajusta la lectura si tu plazo se cuenta en horas laborales. Las medianas se probaron contra un cálculo independiente.</p>

<h2>Cinco pasos para implementarlo</h2>
{{img:pasos}}
<ol>
<li><strong>Mapea el proceso real:</strong> quién pide, quién decide, qué decide y cuánto tarda hoy.</li>
<li><strong>Define las reglas</strong> con el diseñador (montos, plazos, escalamiento y delegados) y apruébalas con quien corresponda.</li>
<li><strong>Construye lo mínimo:</strong> un formulario con pocos campos, una lista y un flujo simple. Empieza por un solo tipo de solicitud.</li>
<li><strong>Prueba</strong> un caso por cada nivel y con el aprobador ausente; revisa qué pasa si el flujo falla y deja un procedimiento manual.</li>
<li><strong>Mide cada mes</strong> con el analizador y ajusta reglas y plazos.</li>
</ol>
<p>La hoja <em>Checklist</em> del libro trae diez controles antes de publicar, entre ellos: dueño del proceso, delegado por nivel, plazo y escalamiento, confirmación al solicitante, registro, acceso limitado a adjuntos, flujo no atado a una cuenta personal y procedimiento manual de respaldo.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el sector público tiene lineamientos de reducción de papel y de gobierno digital (por ejemplo, la política de "cero papel" que viene desde 2012 y las políticas de gobierno digital; verifica el texto vigente aplicable a tu entidad), y los colegios, públicos y privados, tratan datos personales de estudiantes y familias, por lo que deben considerar la Ley 1581 de 2012. En la región, la digitalización de trámites avanza de forma desigual, con instituciones que aprueban todo por papel y otras que ya usan flujos digitales; en el mundo, la automatización de aprobaciones es una práctica común en la administración, y también es conocida su falla más frecuente: automatizar un proceso confuso lo hace confuso más rápido. Para los <strong>directivos</strong>, el flujo exige definir y publicar las reglas; para los <strong>docentes</strong>, saber en qué estado está su solicitud reduce la incertidumbre; para el <strong>personal administrativo</strong>, que suele cargar con los reenvíos, es una carga menos; y para las <strong>familias</strong>, si el flujo toca sus datos, les importa que se traten con cuidado. Cuando los procesos manejan datos sensibles, ver <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA</a> y <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">por qué las integraciones fallan en silencio</a>.</p>

<h2>Herramientas y plantillas</h2>
<p>Si necesitas formatos o plantillas de Excel ya armados, o apoyo para tus procesos administrativos, mira estas opciones. Para la parte pedagógica, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a> son herramientas propias para docentes.</p>
{{productos:factura-con-envio-por-correo-al-cliente,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">qué monitorear en una aplicación web</a>, <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">proteger el dominio del colegio</a> y <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">qué hacer en los primeros 60 minutos de un ransomware</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Necesito comprar una herramienta nueva para un flujo de aprobación?</h3>
<p>No necesariamente. Muchos colegios ya tienen formularios, listas y automatización en la suite que usan (Microsoft 365 o Google Workspace). Antes de comprar, revisa lo que ya tienes y sus límites de licencia.</p>
<h3>¿Qué tipo de aprobación conviene: la del primero que responda o la de todos?</h3>
<p>Depende de la regla. Si basta con una persona de un grupo (por ejemplo, cualquiera de dos coordinadores), el primero que responda. Si la política exige a todos (por ejemplo, Coordinación y Rectoría), todos deben aprobar. Define la regla antes de configurar la herramienta.</p>
<h3>¿Qué pasa si el aprobador está de vacaciones?</h3>
<p>Para eso existe el delegado: cada nivel debe tener uno definido, y el flujo debe poder enrutar a él. Sin delegado, las solicitudes se acumulan.</p>
<h3>¿Cómo sé si el flujo funciona bien?</h3>
<p>Midiendo tiempos por tipo y por aprobador, y revisando las solicitudes que superan su plazo. El analizador descargable lo calcula desde un CSV.</p>
<h3>¿Qué datos debo evitar pedir?</h3>
<p>Los que no sirvan para decidir o enrutar, en especial datos personales de terceros (como estudiantes) y datos sensibles. Pide lo mínimo y limita el acceso a los adjuntos.</p>

<p class="notice"><strong>Empieza con un solo tipo de solicitud.</strong> Descarga el <a href="/descargas/flujo-aprobacion/disenador-flujo-aprobacion.xlsx">diseñador de reglas</a>, escribe las reglas del tipo que más se atasca en tu colegio y pruébalas en el simulador antes de construir nada. Si ya tienes datos, ejecuta el <a href="/descargas/flujo-aprobacion/analizador_aprobaciones.py">analizador</a>.</p>

<h2>Para pensar</h2>
<p>Un flujo digital vuelve visible lo que antes era invisible: quién tarda, quién decide, dónde se atasca todo. <strong>¿Cómo evitar que esa visibilidad se use para vigilar a las personas en vez de mejorar el proceso? Y antes de automatizar una aprobación, ¿nos hemos preguntado si hace falta la aprobación misma, o si el control puede ser más ligero sin perder responsabilidad?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:piezas}}' => $img('flujo-aprobacion-piezas', 499, 'Tabla con las cuatro piezas de un flujo de aprobación, su función y un ejemplo: formulario, lista, flujo y medición.', 'Qué hace cada pieza de un flujo de aprobación.'),
    '{{img:pasos}}' => $img('flujo-aprobacion-pasos', 467, 'Cinco pasos antes de automatizar: mapear, definir reglas, construir, probar y medir.', 'Cinco pasos antes de automatizar.'),
]);

return [
    'slug' => 'flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion',
    'title' => 'Flujo de aprobación digital en el colegio: formulario, reglas, plazos y medición, con diseñador y analizador',
    'excerpt' => 'Cómo pasar de la cadena de correos a un flujo de aprobación digital: formulario, lista, reglas por monto, plazos y escalamiento, y medición de tiempos, con un diseñador en Excel y un analizador en Python.',
    'seo_title' => 'Flujo de aprobación digital para colegios: reglas',
    'seo_description' => 'Diseña un flujo de aprobación digital con formulario, lista y automatización: reglas por monto, plazos, escalamiento y medición, con diseñador y analizador.',
    'focus_keyword' => 'flujo de aprobación digital',
    'cover' => '/assets/img/articulos/flujo-aprobacion/flujo-aprobacion-portada',
    'cover_alt' => 'Portada "Flujo de aprobación digital: del correo perdido al proceso que se puede medir" con una tarjeta: 52 horas contra 5 horas de mediana de respuesta entre dos aprobadores, el cuello de botella se ve.',
    'published_at' => '2027-01-12 12:00:00',
    'content_html' => $html,
];
