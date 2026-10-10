<?php

declare(strict_types=1);

// "Qué monitorear en una aplicación web". Fuentes verificadas el 10 de octubre de 2026: Beyer et al., Site Reliability Engineering (Google), cuatro señales doradas; umbrales de Core Web Vitals (web.dev). Monitor en Python probado contra sitio local, puerto cerrado y ruta 404; calculadora de disponibilidad verificada en Excel.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/monitoreo-aplicacion-web/' . $name;
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
<p>Una aplicación web de un colegio, una pyme o un emprendimiento deja de funcionar un viernes a las seis de la tarde. El formulario de inscripción no carga, los pagos no se registran. Nadie se entera hasta el lunes, cuando una madre llama enojada. <strong>El peor monitoreo es el que consiste en esperar a que los usuarios avisen.</strong></p>
<p>Este artículo explica qué monitorear en una aplicación web (las señales esenciales, los umbrales de ejemplo, qué alertas sirven y cuáles solo hacen ruido), con un <a href="/descargas/monitoreo-web/monitor_basico.py">monitor básico en Python</a> que probé y un <a href="/descargas/monitoreo-web/plan-monitoreo-aplicacion-web.xlsx">plan de monitoreo descargable en Excel</a> con una calculadora de disponibilidad. Datos verificados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Monitorea primero lo que le duele al usuario: <strong>¿está disponible?, ¿responde rápido?, ¿falla?, ¿se está llenando?</strong> (las "cuatro señales doradas" de Google: latencia, tráfico, errores y saturación), más las señales de tu negocio (¿se están completando los pagos y las inscripciones?). Cada alerta debe tener un responsable con nombre, un umbral y un primer paso. Una meta de disponibilidad del 99,9 % permite unos 43 minutos caído al mes: decide la meta por el daño que causa una caída, no por prestigio.</p>

<h2>Las cuatro señales doradas (y las de tu negocio)</h2>
{{img:senales}}
<p>El libro "Site Reliability Engineering" de Google propone, para monitorear cualquier sistema orientado a usuarios, cuatro señales: <strong>latencia</strong> (cuánto tarda en responder, separando respuestas correctas de fallidas, porque un error rápido engaña), <strong>tráfico</strong> (cuánta demanda recibe), <strong>errores</strong> (qué porcentaje de solicitudes falla, ya sea de forma explícita o silenciosa) y <strong>saturación</strong> (qué tan lleno está el recurso más limitado). Con eso se cubre lo técnico. Pero una aplicación puede estar "arriba" y no servir: un formulario que carga pero no guarda, un pago que se cobra y no se registra. Por eso hay que agregar <strong>señales de negocio</strong>: pagos iniciados contra confirmados, inscripciones por hora, correos enviados. Esas son las que de verdad dicen si el sistema cumple su trabajo (ver <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">integraciones que fallan en silencio</a>).</p>

<h2>El plan de monitoreo: diez señales para empezar</h2>
<table>
<thead><tr><th>Señal</th><th>Qué medir (ejemplo)</th><th>Umbral de ejemplo</th><th>Severidad</th></tr></thead>
<tbody>
<tr><td><strong>Disponibilidad</strong></td><td>Comprobación cada minuto de la página de inicio y del flujo de pago</td><td>3 fallos seguidos</td><td>Crítica</td></tr>
<tr><td><strong>Latencia</strong></td><td>Percentil 95 del tiempo de respuesta</td><td>Más de 2 s durante 10 minutos</td><td>Alta</td></tr>
<tr><td><strong>Errores</strong></td><td>Porcentaje de respuestas 5xx</td><td>Más del 2 % durante 5 minutos</td><td>Alta</td></tr>
<tr><td><strong>Saturación</strong></td><td>Disco, memoria, CPU, conexiones a la base de datos</td><td>Disco mayor del 85 %</td><td>Alta</td></tr>
<tr><td><strong>Tráfico</strong></td><td>Solicitudes por minuto</td><td>Caída del 50 % frente a lo normal</td><td>Media</td></tr>
<tr><td><strong>Procesos programados</strong></td><td>Última ejecución exitosa (respaldos, correos)</td><td>No corrió en el tiempo esperado</td><td>Alta</td></tr>
<tr><td><strong>Pagos e inscripciones</strong></td><td>Iniciados contra confirmados</td><td>Cero confirmados en 2 horas hábiles</td><td>Crítica</td></tr>
<tr><td><strong>Experiencia real</strong></td><td>Core Web Vitals en dispositivos reales</td><td>LCP &gt; 2,5 s; INP &gt; 200 ms; CLS &gt; 0,1</td><td>Media</td></tr>
<tr><td><strong>Seguridad</strong></td><td>Inicios de sesión fallidos, cuentas nuevas con privilegios</td><td>Más de 20 fallos por minuto</td><td>Alta</td></tr>
<tr><td><strong>Certificados y dominios</strong></td><td>Días para el vencimiento</td><td>Menos de 21 días</td><td>Media</td></tr>
</tbody>
</table>
<p>Los umbrales de la última columna son ejemplos que debes ajustar a tu caso; los de Core Web Vitals (LCP, INP y CLS) son los umbrales de "bueno" que publica Google en web.dev. El libro trae esta tabla con columnas para quién recibe la alerta, cómo se mide y si ya está implementada: con diez señales y ninguna implementada, el resumen dice "0 de 10" y avisa que las dos críticas (disponibilidad y pagos) aún no están cubiertas.</p>

<h2>¿Cuánto tiempo caído es aceptable? La calculadora</h2>
<p>Una meta de disponibilidad se traduce en minutos. La hoja "Calculadora_disponibilidad" calcula, con la fórmula <em>minutos del periodo × (1 − meta)</em>, el tiempo caído permitido:</p>
{{img:disponibilidad}}
<p>Un 99 % permite unas 7,2 horas caído al mes (casi un día completo cada tres meses); un 99,9 %, unos 43 minutos; un 99,99 %, poco más de 4 minutos. La lección: <strong>cada "nueve" extra cuesta mucho más</strong> (redundancia, procesos, personal de guardia). Para una página informativa de un colegio, el 99 % puede bastar; para el recaudo de pensiones en la última semana de plazo, quizá no. La meta se fija según lo que cuesta una caída a los usuarios.</p>

<h2>Un monitor básico en Python (probado)</h2>
<p>Para entender cómo funciona un monitor de disponibilidad, escribí uno de unas 70 líneas (solo biblioteca estándar): hace N comprobaciones HTTP, mide el tiempo de respuesta y calcula disponibilidad, mediana y percentil 95, y lanza una alerta tras tres fallos consecutivos. Lo probé contra mi propio sitio local, contra un puerto sin servicio y contra una ruta que responde 404:</p>
<pre><code>$ python monitor_basico.py http://localhost:8090/ 20 0.1
http://localhost:8090/
  comprobaciones: 20 | disponibilidad: 100.0 % | alertas: 0
  latencia mediana: 11 ms | p95: 38 ms

$ python monitor_basico.py http://localhost:59999/ 6 0.1      # puerto donde no hay nada
  ALERTA: 3 fallos consecutivos (URLError) en http://localhost:59999/
  comprobaciones: 6 | disponibilidad: 0.0 % | alertas: 1

$ python monitor_basico.py http://localhost:8090/ruta-inexistente/ 4 0.1   # responde 404
  ALERTA: 3 fallos consecutivos (404) en http://localhost:8090/ruta-inexistente/
  comprobaciones: 4 | disponibilidad: 0.0 % | alertas: 1</code></pre>
<p>Fíjate en dos detalles. Primero, <strong>el 404 cuenta como fallo</strong>: una página que "responde" pero con error no está sirviendo. Segundo, la alerta salta con <strong>tres fallos seguidos</strong>, no con el primero: un solo fallo puede ser un tropiezo de red y alertar por todo genera ruido que la gente aprende a ignorar. Esto es una demostración, no un sistema de producción: un monitor real mide desde varios lugares, guarda historia, tiene notificaciones confiables y no corre en el mismo servidor que vigila (si el servidor cae, el monitor cae con él).</p>

<h2>Alertas que sirven, alertas que estorban</h2>
<ul>
<li><strong>Una alerta, un responsable con nombre.</strong> "Alguien del equipo" no es nadie.</li>
<li><strong>Cada alerta dice qué hacer primero.</strong> Una alerta que obliga a investigar desde cero a las tres de la mañana se ignora.</li>
<li><strong>Alerta por síntomas, no por causas.</strong> "Los pagos no llegan" importa más que "la CPU está al 80 %".</li>
<li><strong>Niveles de severidad:</strong> crítica (15 minutos, llamada), alta (1 hora, mensaje), media (1 día, correo) e informativa (tablero). La hoja "Alertas" del libro los trae con tiempos y canales sugeridos.</li>
<li><strong>Si una alerta se ignora tres veces, se arregla la causa o se elimina.</strong></li>
<li><strong>Prueba las alertas críticas</strong> apagando algo a propósito: una alerta que nunca se probó probablemente no suena cuando hace falta.</li>
</ul>

<h2>Lo que casi todos olvidan</h2>
<ol>
<li><strong>Los trabajos programados.</strong> Un respaldo que dejó de correr hace dos semanas no avisa por sí solo. La solución es el "latido": la tarea avisa al terminar, y se alerta si el aviso no llega a tiempo.</li>
<li><strong>Los certificados y dominios.</strong> Un certificado vencido derriba el sitio de un día para otro; se evita con un calendario o un monitor de vencimiento (ver <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo de lo que nadie revisa</a>).</li>
<li><strong>La experiencia real.</strong> Que el servidor responda en 200 ms no significa que en el celular de una familia con conexión lenta la página cargue en tres segundos; la medición con dispositivos reales (Core Web Vitals) lo muestra (ver <a href="/accesibilidad-web-formularios-contraste-teclado-checklist-colegios-pymes/">accesibilidad web</a>).</li>
<li><strong>El respaldo y su restauración.</strong> Si lo único que se monitorea es la caída, falta el plan para cuando ocurre (ver <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: los primeros 60 minutos</a>).</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, el monitoreo pasó de ser un lujo de grandes empresas a una práctica básica, y existen servicios gratuitos o baratos que cubren lo esencial. En Colombia y Latinoamérica, las aplicaciones de colegios, secretarías y pymes suelen depender de una sola persona o de un proveedor externo, sin monitoreo y sin plan; los hechos lo muestran en épocas de alta demanda (inscripciones, pagos, resultados), cuando un sistema sin vigilar se cae justo cuando más se necesita. Para los <strong>directivos</strong>, la pregunta es cuánto cuesta una hora caída y quién lo sabría; para el <strong>personal técnico</strong>, empezar por las dos o tres señales críticas; para las <strong>familias</strong>, que un trámite no se pierda por una caída que nadie vio; y para los <strong>docentes</strong> que usan plataformas, conocer qué pasa cuando fallan (ver <a href="/clases-que-funcionen-sin-conexion-modelo-planificacion-offline-first/">clases sin conexión</a>).</p>

<h2>Herramientas para empezar con orden</h2>
<p>Si tu necesidad es facturar o enviar documentos sin montar una aplicación propia (y sin tener que monitorearla), estas plantillas en Excel funcionan en tu equipo. Y para documentos sensibles como un PIAR, <a href="/herramientas/piar/">PIAR con IA</a> es una herramienta ya operada, con acceso controlado, aunque debes mantener tus propios respaldos.</p>
{{productos:factura-con-envio-por-correo-al-cliente,piar-con-ia-5-planes}}
<p>Sigue leyendo: <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribirse o desarrollar</a> (el monitoreo es parte del costo de una aplicación propia) y <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">la deuda tecnológica de los colegios</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es lo mínimo que debo monitorear?</h3>
<p>La disponibilidad de la página principal y del flujo crítico (por ejemplo, el pago), los errores, el disco y la base de datos, que los trabajos programados corrieron y que las operaciones de negocio se completan.</p>
<h3>¿Qué son las cuatro señales doradas?</h3>
<p>Latencia, tráfico, errores y saturación: las cuatro métricas que, según el libro de Site Reliability Engineering de Google, conviene medir en cualquier sistema orientado a usuarios.</p>
<h3>¿Qué disponibilidad debo prometer?</h3>
<p>La que justifique el daño de una caída. 99 % permite unas 7,2 horas al mes; 99,9 %, unos 43 minutos; 99,99 %, unos 4 minutos. Cada "nueve" extra cuesta más.</p>
<h3>¿Por qué no alertar con el primer fallo?</h3>
<p>Un solo fallo puede ser un tropiezo de red; alertar por todo genera ruido y la gente deja de hacer caso. Alerta tras varios fallos seguidos.</p>
<h3>¿Puedo monitorear desde el mismo servidor?</h3>
<p>No para disponibilidad: si el servidor cae, el monitor cae con él. Usa un monitor externo.</p>

<p class="notice"><strong>Esta semana:</strong> descarga el <a href="/descargas/monitoreo-web/plan-monitoreo-aplicacion-web.xlsx">plan de monitoreo</a>, marca qué señales ya tienes y empieza por las críticas. Si quieres ver cómo funciona un monitor, ejecuta el <a href="/descargas/monitoreo-web/monitor_basico.py">monitor básico</a> contra tu propio sitio.</p>

<h2>Para pensar</h2>
<p>Monitorear cuesta tiempo y dinero, y su valor se nota justo cuando no pasa nada. <strong>¿Quién debe pagar el costo de vigilar los sistemas de los que dependen miles de familias: la institución que los ofrece, el proveedor que los construye o el Estado cuando se trata de servicios públicos? Y cuando un sistema cae y nadie lo supo, ¿de quién fue la falla: de quien no miró o de quien nunca pidió que alguien mirara?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:senales}}' => $img('monitoreo-aplicacion-web-senales', 573, 'Cuatro tarjetas con las señales doradas: latencia, tráfico, errores y saturación, cada una con su significado.', 'Las cuatro señales doradas.'),
    '{{img:disponibilidad}}' => $img('monitoreo-aplicacion-web-disponibilidad', 444, 'Tabla con el tiempo caído que permite cada meta de disponibilidad: 99 % siete horas al mes, 99,9 % 43 minutos y 99,99 % cuatro minutos.', 'Cuánto tiempo caído permite cada meta.'),
]);

return [
    'slug' => 'que-monitorear-aplicacion-web-senales-umbrales-alertas-plan',
    'title' => 'Qué monitorear en una aplicación web para enterarte antes que tus usuarios: señales, umbrales y alertas',
    'excerpt' => 'Las cuatro señales doradas y las de tu negocio, umbrales de ejemplo, qué alertas sirven, una calculadora de disponibilidad, un monitor básico en Python probado y un plan de monitoreo descargable en Excel.',
    'seo_title' => 'Qué monitorear en una aplicación web: señales y alertas',
    'seo_description' => 'Qué monitorear en una aplicación web: señales esenciales, umbrales, alertas útiles, calculadora de disponibilidad y un monitor en Python con plan descargable.',
    'focus_keyword' => 'qué monitorear en una aplicación web',
    'cover' => '/assets/img/articulos/monitoreo-aplicacion-web/monitoreo-aplicacion-web-portada',
    'cover_alt' => 'Portada "Qué monitorear en una aplicación web para enterarte antes que tus usuarios" con una tarjeta: 43 minutos al mes es todo el tiempo caído que permite una meta de disponibilidad del 99,9 %.',
    'published_at' => '2026-12-15 12:00:00',
    'content_html' => $html,
];
