<?php

declare(strict_types=1);

// "Proteger el dominio del colegio". Fuentes consultadas el 10-oct-2026: documentación de registradores sobre clientTransferProhibited; política ICANN de recuperación de registros vencidos (ERRP); guías de remitentes masivos de Google/Yahoo (reportadas por terceros: se invita a consultar las oficiales); RFC 7208 (límite de 10 consultas SPF). Auditor probado con google.com, example.com y un dominio inexistente. Inventario verificado en Excel 16.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/proteger-dominio/' . $name;
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
<p>Un lunes el sitio del colegio no abre y el correo institucional deja de llegar. Nadie borró nada: <strong>el dominio venció</strong>, porque la renovación estaba asociada a la tarjeta de una persona que ya no trabaja allí y los avisos llegaban a su correo personal. Otro caso, más grave: alguien entra a la cuenta del registrador con una contraseña filtrada, cambia los servidores de nombres y empieza a recibir el correo de la institución.</p>
<p>El dominio (el "nombre.edu.co" o "nombre.com") es la identidad digital de un colegio: de él cuelgan el sitio, el correo, las plataformas y la confianza de las familias. Este artículo propone <strong>cinco capas de protección</strong>, con un <a href="/descargas/proteger-dominio/auditor_dominio.py">auditor en Python</a> que revisa los registros públicos de tu dominio y un <a href="/descargas/proteger-dominio/inventario-dominios.xlsx">inventario en Excel</a> con puntos de riesgo y semáforo. El script se probó con dominios reales y el libro se verificó en Microsoft Excel 16; revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Es una guía de buenas prácticas, no una auditoría de seguridad ni asesoría jurídica. Las opciones exactas (nombres de menús, costos, bloqueo de registro, DNSSEC) cambian según el registrador y el tipo de dominio (.co, .edu.co, .com u otros): confírmalas en la documentación de tu proveedor. El auditor solo lee registros DNS públicos; no modifica nada.</p>

<h2>Las cinco capas</h2>
{{img:capas}}
<h3>1. La cuenta del registrador</h3>
<p>Es la llave maestra: quien entra a ella controla el dominio. Tres medidas básicas: <strong>verificación en dos pasos (2FA)</strong>, preferiblemente con aplicación o llave de seguridad y no por mensaje de texto; <strong>correo de recuperación institucional</strong> (un buzón de la institución con varias personas con acceso, no el correo personal de alguien); y <strong>contraseña única</strong> guardada en un gestor, nunca reutilizada. Quien aparece como titular debe ser la institución, no un docente o un proveedor que ayudó "a montar el sitio".</p>
<h3>2. El dominio: bloqueo, renovación y vencimiento</h3>
<ul>
<li><strong>Bloqueo de transferencia</strong> (en el lenguaje técnico, el estado <code>clientTransferProhibited</code>): impide que el dominio se mueva a otro registrador sin desactivar antes el bloqueo. No lo detiene todo, pero le da tiempo a la institución de reaccionar si alguien entra a la cuenta. Mantenlo activo salvo durante una transferencia legítima.</li>
<li><strong>Renovación automática</strong> con un medio de pago institucional vigente, y recordatorios a más de una persona. La política de ICANN para dominios genéricos exige que los registradores avisen del vencimiento al menos dos veces (aproximadamente un mes y una semana antes) y fija un periodo de recuperación de 30 días tras la eliminación, pero no todos los dominios lo tienen: los dominios de país (como .co) siguen sus propias reglas, y las tarifas de recuperación las fija cada registrador. Renovar a tiempo siempre es más barato y más seguro que recuperar.</li>
<li><strong>Bloqueo de registro</strong> (<em>registry lock</em>) para dominios críticos, si tu registrador lo ofrece: añade verificación manual para cambios, normalmente con costo adicional.</li>
<li><strong>Vencimiento a varios años</strong> para el dominio principal, si el presupuesto lo permite.</li>
</ul>
<h3>3. El DNS</h3>
<p>El DNS es la "libreta de direcciones" que dice dónde está el sitio y dónde llega el correo. Quien lo cambia redirige todo. Conviene: saber <strong>quién administra la zona DNS</strong> (el registrador, el hosting o un servicio aparte); tener al menos <strong>dos servidores de nombres</strong>; guardar una <strong>copia de la zona</strong> (la lista de registros) cada vez que cambie, porque es lo primero que se pierde en una emergencia; y evaluar <strong>CAA</strong> (restringe qué autoridades pueden emitir certificados para tu dominio) y <strong>DNSSEC</strong> (firma las respuestas para que no se puedan falsificar), si tu proveedor los soporta.</p>
<h3>4. El correo: SPF, DKIM y DMARC</h3>
{{img:registros}}
<p>Estos tres registros evitan que cualquiera envíe correos "como" tu colegio:</p>
<ul>
<li><strong>SPF</strong> lista los servidores autorizados a enviar correo. Debe haber <strong>un solo</strong> registro SPF y no superar <strong>10 consultas DNS</strong> (<code>include</code>, <code>a</code>, <code>mx</code>, etc.), según la RFC 7208; si se pasa, el resultado es un error permanente y el correo legítimo puede rebotar. Un SPF terminado en <code>+all</code> autoriza a cualquiera: es un error grave.</li>
<li><strong>DKIM</strong> firma criptográficamente cada mensaje. Lo activa el proveedor de correo (Google Workspace, Microsoft 365, un servicio de envío); tú publicas la clave que te dan.</li>
<li><strong>DMARC</strong> le dice al receptor qué hacer cuando SPF o DKIM fallan: <code>p=none</code> (solo observar), <code>p=quarantine</code> (a spam) o <code>p=reject</code> (rechazar). Lo razonable es empezar en <code>none</code> con reportes (<code>rua=</code>), revisar quién envía en nombre del dominio y subir gradualmente a <code>quarantine</code> y <code>reject</code>. Quedarse para siempre en <code>none</code> monitorea, pero no protege.</li>
</ul>
<p>Esto además tiene un efecto práctico: desde 2024, Google y Yahoo exigen a los remitentes masivos (más de 5.000 mensajes diarios a sus usuarios) autenticar con SPF, DKIM y DMARC; para volúmenes menores, tenerlos mejora la entrega. Como los detalles de esas reglas los fija cada proveedor y pueden cambiar, consulta sus guías oficiales para remitentes antes de decidir. Si tu colegio envía circulares o boletines masivos, esto no es opcional.</p>
<h3>5. Las personas</h3>
<p>Casi todos los incidentes de dominio son de procesos, no de tecnología: la persona que montó todo se fue; nadie sabe qué cuenta tiene el dominio; el proveedor externo es el titular. Define <strong>dos responsables</strong> (principal y suplente), guarda las credenciales en un gestor compartido con acceso auditado, y documenta en una hoja <em>dónde está cada cosa</em> (el inventario descargable sirve para esto). Si tu institución sufre un incidente más amplio, ver el <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">protocolo de los primeros 60 minutos</a>.</p>

<h2>El auditor en Python</h2>
<p>El script <code>auditor_dominio.py</code> consulta, con DNS sobre HTTPS, los registros públicos de uno o varios dominios y lista hallazgos con nivel de riesgo (alto, medio, bajo): menos de dos NS, ausencia o duplicado de SPF, SPF con más de 10 consultas o terminado en <code>+all</code>, DMARC ausente, en <code>none</code> o sin reportes, ausencia de CAA y de DNSSEC. Solo usa la biblioteca estándar de Python 3.8 o superior.</p>
<pre><code>python auditor_dominio.py minuevocolegio.edu.co

== minuevocolegio.edu.co ==
NS : ns1.proveedor.example., ns2.proveedor.example.
SPF: v=spf1 include:_spf.google.com ~all
DMARC: v=DMARC1; p=none;
 - MEDIO: DMARC en p=none (solo monitorea; no protege contra suplantacion)
 - BAJO: DMARC sin rua= (no recibes reportes)
 - BAJO: sin registros CAA (cualquier autoridad podria emitir certificados)</code></pre>
<p>(El ejemplo anterior es ilustrativo, con un nombre de dominio inventado.) Lo probé con dominios reales el 10 de octubre de 2026 y el resultado fue el esperado: <code>google.com</code> tiene DMARC en <code>reject</code> con reportes y SPF terminado en <code>~all</code>, y <code>example.com</code> (un dominio de documentación que no envía correo) tiene SPF <code>-all</code> y DMARC en <code>reject</code>; un dominio inexistente da los hallazgos altos. Lo que el auditor <strong>no</strong> puede ver desde afuera son el 2FA, el titular, el bloqueo de registro ni la fecha de vencimiento: eso va en el inventario.</p>

<h2>El inventario en Excel</h2>
<p>El libro lista cada dominio con su registrador, el correo de recuperación (y de quién es), la fecha de vencimiento, la renovación automática, el bloqueo de transferencia, el 2FA, el estado del DMARC y la última copia de la zona DNS. Calcula los días para vencer y un puntaje de riesgo (vence en 30 días o menos 3 puntos; entre 31 y 60 días 1; sin renovación automática 1; sin bloqueo 2; sin 2FA 2; DMARC ninguno o <code>none</code> 1; sin copia de la zona 1) y marca "Crítico" (5 o más), "Atención" (3 o 4) o "Bien". En los cuatro dominios ficticios del ejemplo, con fecha de revisión del 10 de octubre de 2026: uno queda "Crítico" (8 puntos: vence en 23 días, sin renovación automática ni 2FA, DMARC en <code>none</code> y sin copia de la zona), uno en "Atención" (3 puntos: sin bloqueo de transferencia ni DMARC) y dos "Bien". Los criterios son orientativos: ajústalos.</p>

<h2>Una rutina para esta semana</h2>
<ol>
<li><strong>Lista tus dominios</strong> (los de la institución, los de proyectos y los "olvidados") con el inventario.</li>
<li><strong>Entra a cada cuenta de registrador</strong> y verifica titular, correo de recuperación, 2FA, bloqueo de transferencia, vencimiento y renovación.</li>
<li><strong>Ejecuta el auditor</strong> y corrige primero los hallazgos altos.</li>
<li><strong>Guarda una copia de la zona DNS</strong> (exportada o en captura) y anota dónde está.</li>
<li><strong>Define dos responsables</strong> y un calendario con recordatorios 90, 30 y 7 días antes del vencimiento.</li>
<li><strong>Revisa DMARC</strong> cada trimestre: si llevas meses en <code>none</code>, planea el paso a <code>quarantine</code>.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los colegios suelen administrar su dominio a través de un proveedor de hosting, un docente de sistemas o la secretaría de educación, y es habitual que el titular no sea la institución. En la región el patrón se repite: muchos dominios institucionales dependen de una persona. En el mundo, los ataques de suplantación de correo y de secuestro de dominio son un problema reconocido por los proveedores de correo y por las agencias de ciberseguridad, que por eso recomiendan autenticación del correo y controles de cuenta. Para los <strong>directivos</strong>, el dominio es un activo que se inventaría como cualquier otro; para el <strong>personal técnico</strong>, la meta es reducir el riesgo de depender de una sola persona; para los <strong>docentes</strong>, saber que un correo "del colegio" puede ser falso; y para las <strong>familias</strong>, confiar en los canales oficiales y desconfiar de mensajes urgentes de pago o de datos. (Ver también <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a> y <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">la nube no es un respaldo</a>.)</p>

<h2>Herramientas y plantillas</h2>
<p>Si necesitas emitir comprobantes o enviar documentos por correo desde tu negocio o institución, revisa estas plantillas, y recuerda que el correo que envíes debe salir de un dominio bien autenticado. Para la parte pedagógica, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a> son herramientas propias para docentes.</p>
{{productos:factura-con-envio-por-correo-al-cliente,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">qué monitorear en una aplicación web</a>, <a href="/extensiones-del-navegador-riesgos-permisos-inventario-politica/">extensiones del navegador</a> y <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">más plataformas no es mejor</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué pasa si se vence el dominio de mi colegio?</h3>
<p>El sitio y el correo dejan de funcionar. Muchos registradores permiten renovar durante un periodo posterior al vencimiento, y para dominios genéricos existe un periodo de recuperación, pero el costo y los plazos dependen del registrador y del tipo de dominio. Lo mejor es no llegar ahí.</p>
<h3>¿Qué es el bloqueo de transferencia?</h3>
<p>Un estado que impide mover el dominio a otro registrador hasta que lo desactives. Es una protección contra transferencias no autorizadas, pero no impide cambios de DNS: por eso la cuenta también necesita 2FA.</p>
<h3>¿Qué es DMARC y por qué importa?</h3>
<p>Es una política publicada en el DNS que indica a los receptores qué hacer con los correos que dicen venir de tu dominio pero no pasan SPF ni DKIM. Dificulta que te suplanten.</p>
<h3>¿Debo poner DMARC directamente en reject?</h3>
<p>No conviene hacerlo sin observar antes: podrías bloquear correo legítimo enviado por servicios que olvidaste autorizar. Empieza en <code>none</code> con reportes, revisa quién envía y sube gradualmente.</p>
<h3>¿El auditor modifica algo de mi dominio?</h3>
<p>No. Solo hace consultas de lectura a DNS público.</p>

<p class="notice"><strong>Haz el primer paso hoy.</strong> Descarga el <a href="/descargas/proteger-dominio/inventario-dominios.xlsx">inventario de dominios</a>, anota los de tu institución y revisa, para cada uno, quién es el titular y cuándo vence. Luego ejecuta el <a href="/descargas/proteger-dominio/auditor_dominio.py">auditor</a>.</p>

<h2>Para pensar</h2>
<p>Pagar por un dominio parece un gasto pequeño, pero de él depende la identidad digital de toda una comunidad. <strong>¿Quién es, en realidad, el dueño del dominio de tu institución: la institución, una persona o un proveedor? Y si esa persona renunciara mañana, ¿sabría alguien cómo recuperar el acceso antes de que algo falle?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:capas}}' => $img('proteger-dominio-capas', 467, 'Cinco capas para proteger un dominio: cuenta del registrador con 2FA, dominio con bloqueo y renovación, DNS, correo con SPF, DKIM y DMARC, y personas responsables.', 'Un dominio se protege por capas.'),
    '{{img:registros}}' => $img('proteger-dominio-registros', 553, 'Tabla con cinco registros DNS, qué protege cada uno y su señal de alerta: SPF, DKIM, DMARC, CAA y DNSSEC.', 'Registros que puedes revisar hoy.'),
]);

return [
    'slug' => 'proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor',
    'title' => 'Proteger el dominio del colegio: registrador, DNS y correo (SPF, DKIM, DMARC), con un auditor en Python',
    'excerpt' => 'Cinco capas para no perder el dominio ni que suplanten tu correo: cuenta del registrador, bloqueo y renovación, DNS, SPF/DKIM/DMARC y personas, con un auditor en Python y un inventario en Excel.',
    'seo_title' => 'Proteger el dominio del colegio: DNS, SPF y DMARC',
    'seo_description' => 'Cómo proteger el dominio de un colegio: 2FA del registrador, bloqueo, renovación, DNS, SPF, DKIM y DMARC, con auditor en Python e inventario en Excel.',
    'focus_keyword' => 'proteger dominio colegio',
    'cover' => '/assets/img/articulos/proteger-dominio/proteger-dominio-portada',
    'cover_alt' => 'Portada "Proteger el dominio del colegio: registrador, DNS y correo antes de que algo falle" con una tarjeta: 5 capas (cuenta, dominio, DNS, correo y personas); si una falla, el dominio está en riesgo.',
    'published_at' => '2027-01-05 12:00:00',
    'content_html' => $html,
];
