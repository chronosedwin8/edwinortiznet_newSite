<?php

declare(strict_types=1);

// "Integraciones que fallan en silencio: API, webhooks, reintentos y alertas". Fuentes verificadas el 9 de octubre de 2026: documentación de webhooks de Stripe (docs.stripe.com/webhooks). Demostración en Python ejecutada y descargable; inventario de ejemplo con datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/integraciones-fallan-silencio/' . $name;
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
<p>La peor falla de una integración no es la que hace ruido: es la que <strong>no avisa</strong>. Un pago confirmado que nunca llega a contabilidad, una inscripción que no pasa de un formulario a la hoja de cálculo, un boletín que no sale por correo. Nadie ve un error en pantalla; el problema aparece semanas después, cuando una familia reclama o cuando no cuadra el cierre del mes.</p>
<p>Hoy casi todo está conectado con todo: la pasarela de pagos con la facturación, el formulario con la plataforma académica, la tienda con el correo. Cada conexión (una API, un webhook, un archivo programado) es un punto donde la información puede perderse, duplicarse o llegar tarde. Este artículo explica cómo diseñar integraciones que <strong>fallen a la vista</strong>, con un ejemplo en código que ejecuté, un <a href="/descargas/integraciones/inventario-integraciones.xlsx">inventario de integraciones en Excel</a> y la <a href="/descargas/integraciones/integracion_resiliente.py">demostración en Python</a>. Fuentes verificadas el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Una integración confiable hace cinco cosas: <strong>verifica</strong> de dónde viene el mensaje, <strong>confirma rápido</strong>, <strong>no duplica</strong> aunque el mensaje llegue dos veces, <strong>reintenta</strong> los fallos temporales y <strong>avisa a una persona</strong> cuando algo no se pudo procesar. Lo demás es inventariar y asignar responsables.</p>

<h2>Cómo fallan en silencio</h2>
<p>Seis formas típicas, ninguna con mensaje de error visible:</p>
<ul>
<li><strong>El destino estuvo caído un rato</strong> y el mensaje se perdió, porque nadie reintentó.</li>
<li><strong>El mensaje llegó dos veces</strong> y se registró dos pagos o dos matrículas.</li>
<li><strong>Los mensajes llegaron en otro orden</strong> y un estado "pagado" fue pisado por uno más viejo.</li>
<li><strong>Cambió un campo en la API</strong> del proveedor y la integración sigue "funcionando", pero con datos vacíos.</li>
<li><strong>Venció una credencial o un certificado</strong> y desde ese día todo falla sin avisar.</li>
<li><strong>Quien la hizo se fue</strong> y nadie sabe que existe.</li>
</ul>

<h2>Lo que ya advierte un proveedor serio</h2>
<p>La documentación de webhooks de Stripe, que cito como ejemplo de buenas prácticas (otros proveedores tienen reglas propias), dice varias cosas que aplican a casi cualquier integración: en modo real reintenta la entrega <strong>hasta por tres días con espera exponencial</strong>; <strong>el mismo evento puede llegar más de una vez</strong> y se recomienda registrar los identificadores de los eventos ya procesados; <strong>no garantiza el orden</strong> de entrega; el endpoint debe <strong>responder 2xx rápido, antes de la lógica pesada</strong>, y procesar en una cola; y hay que <strong>verificar la firma</strong> de cada mensaje para evitar eventos falsos.</p>
{{img:stripe}}
<p>Traduzco: si tu sistema depende de un mensaje que llega una sola vez, en orden y sin fallas, está mal diseñado, sin importar quién sea el proveedor.</p>

<h2>El flujo en cinco pasos</h2>
{{img:flujo}}
<ol>
<li><strong>Verifica.</strong> Comprueba la firma, el secreto compartido o el origen antes de actuar. Sin esto, cualquiera podría enviar un "pago confirmado" falso.</li>
<li><strong>Guarda y confirma.</strong> Registra el evento y responde 2xx de inmediato; si haces el trabajo pesado antes de responder, el proveedor puede dar el envío por fallido y reenviarlo.</li>
<li><strong>Procesa sin duplicar (idempotencia).</strong> Usa el identificador del evento: si ya lo viste, no lo apliques otra vez.</li>
<li><strong>Reintenta lo temporal.</strong> Con espera creciente y un poco de azar, para no golpear al destino todos a la vez. No reintentes errores permanentes (un pedido que no existe no va a existir mañana).</li>
<li><strong>Alerta y guarda lo fallido.</strong> Lo que no se pudo procesar va a una cola y avisa a una persona con nombre.</li>
</ol>

<h2>Un ejemplo ejecutado</h2>
<p>Escribí una demostración de unas 90 líneas en Python (solo biblioteca estándar) que simula un proveedor enviando seis eventos: dos repetidos, uno con un fallo temporal del sistema contable y uno con un error permanente. Estas son las partes clave:</p>
<pre><code>def recibir(evento):
    """Punto de entrada del webhook: idempotente."""
    try:
        db.execute("INSERT INTO procesados VALUES (?,?)", (evento["id"], time.time()))
    except sqlite3.IntegrityError:
        print(f"{evento['id']}: duplicado, se ignora (ya procesado)")
        return
    con_reintentos(evento)

def con_reintentos(evento, maximo=4, base=0.01):
    for n in range(1, maximo + 1):
        try:
            aplicar_pago(evento)
            return True
        except ConnectionError as e:          # temporal: reintentar
            espera = base * (2 ** (n - 1)) + random.uniform(0, base)
            time.sleep(espera)
        except ValueError as e:               # permanente: a la cola y alertar
            db.execute("INSERT INTO fallidos VALUES (?,?,?)", (evento["id"], str(e), n))
            alertar(f"evento {evento['id']} a cola de fallidos: {e}")
            return False
    alertar(f"evento {evento['id']} agotó {maximo} intentos")
    return False</code></pre>
<p>Y esta es la salida real al ejecutarla:</p>
<pre><code>evt_1: nuevo, se procesa
evt_2: nuevo, se procesa
evt_1: duplicado, se ignora (ya procesado)
evt_3: nuevo, se procesa
  intento 1 falló (el sistema contable no respondió); espero 0.013 s
  intento 2 falló (el sistema contable no respondió); espero 0.022 s
evt_2: duplicado, se ignora (ya procesado)
evt_5: nuevo, se procesa
  ALERTA: evento evt_5 a cola de fallidos: pedido inexistente en el sistema (error permanente)

Pagos aplicados: (3, 250000)
Eventos fallidos: [('evt_5', 'pedido inexistente en el sistema (error permanente)')]
Alertas enviadas: 1</code></pre>
<p>Los dos eventos repetidos se ignoraron; el que falló dos veces de forma temporal se aplicó al tercer intento (los 3 pagos suman 250.000, no 450.000); y el error permanente quedó en la cola de fallidos con una alerta. Una advertencia honesta: <strong>esta demostración marca el evento como procesado al recibirlo</strong>, para que se vea con claridad la idempotencia. En producción es mejor guardar un estado por evento (recibido, procesado, fallido) y marcarlo "procesado" solo cuando el trabajo termina, para no perder un evento que falló a mitad de camino.</p>

<h2>Inventaria tus integraciones</h2>
<p>Antes de mejorar el código, haz una lista. El libro descargable trae un inventario con columnas para el responsable, si hay alerta, si reintenta, si evita duplicados, si verifica el origen y la fecha de la última revisión; calcula un riesgo por integración. Con los datos de ejemplo, <strong>3 de las 6 integraciones quedan en riesgo alto</strong>: una sin alerta ni reintentos, otra sin ningún control y otra sin responsable. La hoja "Plan_de_falla" trae nueve preguntas para cada integración crítica, como "¿cuánto tardaríamos en enterarnos?" y "¿cómo reprocesamos lo perdido?".</p>
<p>Un detalle: la columna de días desde la revisión usa la fecha de hoy, así que el riesgo cambia con el tiempo; es intencional, para que una integración que nadie revisa suba de riesgo sola.</p>

<h2>Qué monitorear</h2>
<table>
<thead><tr><th>Señal</th><th>Qué indica</th><th>Acción</th></tr></thead>
<tbody>
<tr><td><strong>Eventos recibidos por día</strong></td><td>Si cae a cero o se dispara, algo cambió</td><td>Alerta por desviación frente al promedio</td></tr>
<tr><td><strong>Eventos en cola de fallidos</strong></td><td>Trabajo que nadie ha atendido</td><td>Revisión diaria y responsable</td></tr>
<tr><td><strong>Tiempo desde el último evento</strong></td><td>Una integración "muda"</td><td>Alerta si pasa más de lo esperable</td></tr>
<tr><td><strong>Vencimiento de credenciales</strong></td><td>Una caída anunciada</td><td>Calendario de renovación</td></tr>
<tr><td><strong>Conciliación diaria</strong></td><td>Diferencias entre origen y destino</td><td>Compara totales de ambos lados</td></tr>
</tbody>
</table>
<p>La conciliación es la red de seguridad final: aunque todo lo anterior falle, comparar cada día el total de pagos de la pasarela con el de la contabilidad te dice si algo se perdió (ver el artículo sobre <a href="/riesgo-oculto-excel-auditoria-control-versiones/">controles en Excel</a> para hacerlo con una fórmula).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, las integraciones entre servicios en la nube se volvieron la columna vertebral de casi cualquier operación. En Colombia y Latinoamérica el riesgo se agrava por dos razones frecuentes: muchas integraciones las armó un proveedor externo o una persona que ya no está, y no hay presupuesto para monitoreo, así que se descubren las fallas cuando un cliente reclama. En un colegio, la integración que falla es un boletín que no llega, una matrícula que no se refleja o un cobro que no se aplica. Para los <strong>directivos</strong>, la pregunta es quién responde por cada integración; para el <strong>personal administrativo y docente</strong>, tener un procedimiento manual de respaldo; y para las <strong>familias</strong>, que un error técnico no se convierta en un cobro indebido o un dato perdido (ver <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a> y <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a>, que también conectan sistemas entre sí).</p>

<h2>Herramientas para empezar con orden</h2>
<p>Si tu necesidad es facturar y enviar documentos a clientes por correo sin armar una integración compleja, esta plantilla en Excel resuelve el proceso completo en tu equipo. Y si en tu colegio manejas documentos sensibles de estudiantes, <a href="/herramientas/piar/">PIAR con IA</a> los guarda en una cuenta con acceso controlado, en vez de moverlos entre correos y hojas.</p>
{{productos:factura-con-envio-por-correo-al-cliente,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribirse o desarrollar</a>, <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">cuándo Excel deja de ser la solución</a> y <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">la nube no es un respaldo</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es un webhook?</h3>
<p>Es un aviso que un servicio envía automáticamente a una dirección tuya cuando ocurre algo (por ejemplo, un pago confirmado), en lugar de que tu sistema pregunte una y otra vez.</p>
<h3>¿Qué significa que una operación sea idempotente?</h3>
<p>Que repetirla no cambia el resultado: aplicar dos veces el mismo evento deja el sistema igual que aplicarlo una vez. Se logra, por ejemplo, registrando el identificador de cada evento procesado.</p>
<h3>¿Cuántas veces debo reintentar?</h3>
<p>Depende del caso; en la demostración son 4 intentos con espera creciente. Lo importante es que los errores temporales se reintenten, los permanentes no, y que el agotamiento de intentos genere una alerta.</p>
<h3>¿Cómo sé si una integración dejó de funcionar?</h3>
<p>Con alertas por inactividad (tiempo sin eventos), una cola de fallidos revisada a diario y una conciliación periódica de los totales entre el origen y el destino.</p>
<h3>¿Necesito programar para esto?</h3>
<p>Para el código, sí o con apoyo técnico; pero el inventario, los responsables y el plan de falla no requieren programación, y son lo que más evita sorpresas.</p>

<p class="notice"><strong>Esta semana:</strong> descarga el <a href="/descargas/integraciones/inventario-integraciones.xlsx">inventario de integraciones</a>, lista las tuyas, asigna un responsable a cada una y responde la hoja "Plan_de_falla" para las críticas. Si quieres ver las defensas en código, ejecuta la <a href="/descargas/integraciones/integracion_resiliente.py">demostración en Python</a>.</p>

<h2>Para pensar</h2>
<p>Una integración que funciona el 99 % del tiempo y falla en silencio el otro 1 % puede ser peor que una que falla a gritos, porque nadie sabe que debe corregir. <strong>¿Es aceptable que un colegio o una empresa dependa de conexiones que nadie vigila, cuando de ellas dependen los pagos, las notas o los datos de las personas? Y cuando una falla silenciosa perjudica a alguien (un cobro duplicado, una matrícula perdida), ¿quién responde: quien programó la integración, quien la contrató o quien debía vigilarla?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:stripe}}' => $img('integraciones-fallan-silencio-stripe', 573, 'Cuatro tarjetas con lo que dice la documentación de webhooks de Stripe: reintentos por tres días con espera exponencial, eventos duplicados posibles, sin orden garantizado y respuesta 2xx rápida.', 'Lo que advierte la documentación de un proveedor serio.'),
    '{{img:flujo}}' => $img('integraciones-fallan-silencio-flujo', 467, 'Cinco pasos para que una integración no falle en silencio: verificar, guardar y confirmar, procesar sin duplicar, reintentar y alertar.', 'El flujo en cinco pasos.'),
]);

return [
    'slug' => 'integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas',
    'title' => 'Las integraciones que fallan en silencio: API, webhooks, reintentos y alertas para que un pago o una inscripción no se pierdan',
    'excerpt' => 'Seis formas en que una integración falla sin avisar, cinco pasos para evitarlo, una demostración en Python ejecutada (idempotencia, reintentos y alertas) y un inventario de integraciones en Excel.',
    'seo_title' => 'Integraciones que fallan en silencio: webhooks y alertas',
    'seo_description' => 'Cómo evitar que una integración falle en silencio: verificación, idempotencia, reintentos, alertas y un inventario descargable con demostración en Python.',
    'focus_keyword' => 'integraciones que fallan en silencio',
    'cover' => '/assets/img/articulos/integraciones-fallan-silencio/integraciones-fallan-silencio-portada',
    'cover_alt' => 'Portada "Las integraciones que fallan en silencio: API, webhooks, reintentos y alertas" con una tarjeta: 3 de 6 integraciones del ejemplo tienen riesgo alto, un evento repetido no debe duplicar un pago y un error permanente avisa a una persona.',
    'published_at' => '2026-11-17 12:00:00',
    'content_html' => $html,
];
