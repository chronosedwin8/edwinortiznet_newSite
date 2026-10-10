<?php

declare(strict_types=1);

// "Altas y bajas de cuentas". Referencias generales: NIST SP 800-53 (AC-2, gestión de cuentas), ISO/IEC 27001 (familia), principio de mínimo privilegio; Ley 1581 de 2012 (principio de seguridad), con aviso de verificar. Libro verificado en Excel 16 y Python: fecha de revisión 1-mar-2027; 24 cuentas, 12 personas, 11 cuentas de retirados; 5 activas tras el retiro (45 %; máximo 91 días; 1 crítica de administrador, 45 días); 4 bajas a tiempo y 2 tardías (15 y 77 días); 3 inactivas (147, 106, 181 días); 10 vigentes; 4 personas retiradas con cuenta activa. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/altas-bajas-cuentas/' . $name;
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
<p>Una docente se retiró del colegio en noviembre. En marzo, su correo institucional sigue activo: alguien inició sesión ayer desde otra ciudad. No fue ella: fue quien tuvo su contraseña, o quien la adivinó, y ahora tiene acceso a una cuenta que todavía figura con el nombre del colegio y a los listados que la docente recibía. Nadie lo notó porque <strong>nadie había dado de baja la cuenta</strong>. No hubo un ataque sofisticado: hubo una puerta que se quedó abierta después de que la persona se fue.</p>
<p>Este artículo propone controlar el <strong>ciclo de vida de las cuentas</strong> del colegio (altas, cambios y bajas) y revisar periódicamente quién tiene acceso a qué. Incluye un <a href="/descargas/altas-bajas-cuentas/control-altas-bajas-cuentas.xlsx">libro de Excel</a> con 12 personas y 24 cuentas ficticias, verificado en Microsoft Excel 16 y contra un cálculo independiente.</p>
<p class="notice"><strong>Alcance.</strong> Es un marco básico, inspirado en el control de gestión de cuentas del NIST SP 800-53 (AC-2) y en prácticas generales de gestión de identidades, citados como referencia, no como reproducción. Los datos son ficticios; los plazos (2 días para la baja, 90 días de inactividad) son ejemplos que debes ajustar. No incluyas en el libro nombres reales, contraseñas ni datos personales innecesarios: usa códigos. Esto no es asesoría jurídica ni de seguridad, y los datos personales de docentes, estudiantes y familias están protegidos por la Ley 1581 de 2012, cuyo principio de seguridad exige proteger la información contra acceso no autorizado (verifica el texto vigente).</p>

<h2>Por qué las cuentas "huérfanas" son un riesgo</h2>
<ul>
<li><strong>Quedan sin dueño real.</strong> La persona ya no responde por ellas, pero siguen recibiendo correos, accesos y datos. Quien tenga la clave (la persona, un excompañero con quien se compartió, un atacante) puede usarla.</li>
<li><strong>Nadie las vigila.</strong> Una actividad extraña en la cuenta de alguien que ya no trabaja aquí no alarma a nadie, porque no hay un usuario atento que note que algo no cuadra.</li>
<li><strong>Las cuentas con privilegios multiplican el daño.</strong> Un administrador del sistema financiero o de la plataforma académica que sigue activo tras el retiro puede ver o modificar mucho más que un usuario común.</li>
<li><strong>Las cuentas inactivas de personas activas</strong> también son un riesgo: no se usan, nadie las nota y suelen conservar contraseñas viejas.</li>
</ul>

{{img:ciclo}}
<h2>El ciclo de vida: alta, cambio, baja y revisión</h2>
<ol>
<li><strong>Alta:</strong> se crean solo las cuentas y permisos que el cargo necesita (el principio del <em>mínimo privilegio</em>), con una solicitud registrada y aprobada por quien corresponda.</li>
<li><strong>Cambio:</strong> cuando la persona cambia de cargo o de área, se ajustan los accesos: se quitan los que ya no necesita, no solo se agregan los nuevos. Es donde más se acumulan permisos.</li>
<li><strong>Baja:</strong> el día del retiro (o antes, si es un retiro conflictivo) se desactivan las cuentas, se recuperan los equipos y se transfieren los datos que el colegio necesita conservar. Idealmente, la baja se dispara desde talento humano, no desde la memoria de alguien de sistemas.</li>
<li><strong>Revisión periódica:</strong> cada trimestre se compara la lista de cuentas con la nómina y con los contratistas vigentes, y se revisan las cuentas privilegiadas y las inactivas.</li>
</ol>
<p>El hilo común es una sola fuente de verdad sobre quién trabaja en el colegio (la nómina o la lista de personal) y una persona o área responsable de cada baja (ver <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">la mesa de ayuda</a> para registrar las solicitudes y <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">el inventario tecnológico</a> para recuperar los equipos).</p>

<h2>El libro de Excel</h2>
<ul>
<li><strong>Parametros:</strong> la fecha de revisión (se escribe la de hoy; no se usa <code>HOY()</code> para que el resultado sea reproducible), el plazo máximo de baja tras el retiro y los días sin sesión para marcar una cuenta como inactiva.</li>
<li><strong>Personas:</strong> doce personas con su rol, estado (activo o retirado) y fecha de retiro, con códigos en vez de nombres.</li>
<li><strong>Cuentas:</strong> 24 cuentas con persona, sistema, nivel (usuario o administrador), última sesión y fecha de baja. Calcula el estado de la persona, los días y una <strong>alerta</strong>: <em>Crítica</em> (administrador activo tras el retiro), <em>Activa tras el retiro</em>, <em>Baja tardía</em>, <em>Baja a tiempo</em>, <em>Inactiva</em> o <em>Vigente</em>.</li>
<li><strong>Resumen:</strong> los conteos clave.</li>
</ul>
<pre><code>' Alerta de una cuenta (G = estado de la persona, F = fecha de baja, I = días, D = nivel)
=SI(G2="Retirado";SI(F2="";SI(D2="Administrador";"Crítica: administrador activo tras el retiro";"Activa tras el retiro");SI(I2>Parametros!$B$4;"Baja tardía";"Baja a tiempo"));SI(F2<>"";"Baja con la persona activa";SI(I2>Parametros!$B$5;"Inactiva";"Vigente")))   ' español
=IF(G2="Retirado",IF(F2="",IF(D2="Administrador","Crítica: administrador activo tras el retiro","Activa tras el retiro"),IF(I2>Parametros!$B$4,"Baja tardía","Baja a tiempo")),IF(F2<>"","Baja con la persona activa",IF(I2>Parametros!$B$5,"Inactiva","Vigente")))   ' inglés

' Días: desde el retiro (si no hay baja), entre el retiro y la baja, o desde la última sesión
=SI(G2="Retirado";SI(F2="";Parametros!$B$3-H2;F2-H2);Parametros!$B$3-E2)   ' español</code></pre>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
{{img:dias}}
<p>Con una fecha de revisión del 1 de marzo de 2027, 24 cuentas y 12 personas (5 retiradas):</p>
<ul>
<li><strong>De 11 cuentas de personas retiradas, 5 seguían activas (45 %)</strong>, en 4 de las 5 personas retiradas. La más antigua llevaba <strong>91 días abierta</strong> tras el retiro (un correo y un aula virtual de una docente que salió el 30 de noviembre) y otra, 81 días (una plataforma de un contratista).</li>
<li><strong>Una era crítica:</strong> el acceso de administrador al sistema financiero de una persona que se retiró el 15 de enero y llevaba <strong>45 días</strong> activo.</li>
<li><strong>Las bajas ocurren, pero tarde:</strong> de 6 cuentas dadas de baja, 4 se hicieron a tiempo (dentro de 2 días) y 2 tarde, con 15 y 77 días de retraso.</li>
<li><strong>3 cuentas inactivas de personas activas</strong> (147, 106 y 181 días sin sesión), entre ellas una de <strong>administrador de la plataforma</strong> de un contratista, sin uso hace casi seis meses.</li>
<li><strong>10 cuentas vigentes</strong> (42 %), con sesiones recientes de personas activas.</li>
</ul>
<p><strong>Una lectura honesta:</strong> el libro solo detecta lo que se registra: una cuenta que no está en la hoja no se revisa, y una persona que no está en la lista de personal tampoco. Tampoco prueba que la cuenta fue usada indebidamente; muestra una puerta abierta. Y la "última sesión" depende de que el sistema la registre bien. Por eso lo ideal es que cada sistema pueda exportar su lista de usuarios, para compararla con la nómina.</p>

<h2>Buenas prácticas para el colegio</h2>
<ol>
<li><strong>Una lista única de personal</strong> (docentes, administrativos, contratistas, practicantes) con fechas de ingreso y retiro, y un responsable de mantenerla.</li>
<li><strong>Cuentas personales, no compartidas.</strong> Si varios usan la misma cuenta, no se puede saber quién hizo qué ni quitarle el acceso a uno solo.</li>
<li><strong>Doble verificación</strong> (en los sistemas que la ofrezcan) en las cuentas de correo y de administración (ver <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">proteger el dominio del colegio</a> y <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">los errores básicos de seguridad</a>).</li>
<li><strong>Privilegios mínimos y revisados:</strong> pocos administradores, con nombre propio, revisados cada trimestre.</li>
<li><strong>Un procedimiento de baja escrito,</strong> con una lista de verificación (cuentas, equipos, llaves, datos que se transfieren) y un plazo (por ejemplo, el mismo día del retiro). Publícalo en la base de conocimiento (ver <a href="/base-de-conocimiento-colegio-articulos-responsable-fecha-revision-excel/">la base de conocimiento</a>).</li>
<li><strong>Cuidado con los agentes y las automatizaciones:</strong> las cuentas de servicio y las claves de herramientas de IA también tienen que darse de baja (ver <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a los sistemas</a>).</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La gestión del ciclo de vida de las identidades (en inglés, <em>joiner, mover, leaver</em>) es un control básico en los marcos de seguridad de la información, como la familia ISO/IEC 27001 y el NIST SP 800-53, y una de las fallas más comunes en las auditorías: casi siempre aparecen cuentas de personas que ya no están. En Colombia, la Ley 1581 de 2012 exige a los responsables del tratamiento de datos personales medidas de seguridad, y un acceso que queda abierto tras el retiro es difícil de justificar en caso de incidente. En América Latina y el mundo, los colegios con poco personal técnico dependen del procedimiento de talento humano más que de herramientas costosas, y funciona cuando talento humano y sistemas trabajan juntos.</p>
<p>Para los <strong>docentes</strong>, entregar los accesos al retirarse es parte de una salida ordenada; para los <strong>directivos</strong>, es una medida barata que reduce riesgos y evita sorpresas; para las <strong>familias</strong>, es proteger los datos de sus hijos; y para <strong>quien se va</strong>, que lo mejor para todos es que sus accesos se cierren a tiempo y que se transfiera lo necesario, con respeto y sin sospechas.</p>

<h2>Herramientas y plantillas</h2>
<p>Si trabajas con las plantillas de Excel del sitio y quieres apoyo, o preparas material con IA (revisando siempre lo que produce y sin incluir datos personales ni credenciales en herramientas que no estén diseñadas para custodiarlos), mira estos productos.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: el <a href="/descargas/altas-bajas-cuentas/control-altas-bajas-cuentas.xlsx">libro de altas y bajas de cuentas</a>, <a href="/plan-continuidad-operativa-colegio-analisis-impacto-rto-rpo-excel/">el plan de continuidad operativa</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es una baja de cuenta?</h3>
<p>Desactivar o eliminar las cuentas y permisos de una persona que se retira o que ya no necesita el acceso, y recuperar o transferir lo que el colegio necesite.</p>
<h3>¿Cuándo debo dar de baja las cuentas de un docente que se retira?</h3>
<p>El día del retiro o antes, según el caso. El libro usa 2 días como plazo de ejemplo; define el tuyo.</p>
<h3>¿Borrar o desactivar la cuenta?</h3>
<p>Primero desactívala (para conservar el correo y los datos que el colegio deba mantener), y elimínala cuando termine el plazo de conservación y se haya transferido lo necesario.</p>
<h3>¿Qué es el mínimo privilegio?</h3>
<p>Dar a cada persona solo los accesos que necesita para su trabajo, y revisarlos cuando cambia de cargo.</p>
<h3>¿Cómo uso el libro?</h3>
<p>Escribe la fecha de revisión, la lista de personas con su estado, y las cuentas de cada sistema (con la última sesión y la fecha de baja); el libro marca las alertas y calcula el resumen.</p>

<p class="notice"><strong>Revisa tus cuentas esta semana.</strong> Descarga el <a href="/descargas/altas-bajas-cuentas/control-altas-bajas-cuentas.xlsx">libro de altas y bajas de cuentas</a>, reemplaza los datos ficticios por una exportación de tus sistemas y mira primero las cuentas críticas y las activas tras el retiro.</p>

<h2>Para pensar</h2>
<p>Cerrar los accesos de quien se va puede sentirse como una desconfianza, cuando en realidad es una forma de cuidado: de los datos de otros y de la propia persona, que no debería responder por lo que alguien haga con una cuenta que ya no usa. <strong>¿Cómo sería en tu colegio una salida ordenada, donde la persona entrega sus accesos y el colegio los cierra con respeto? Y ¿quién tendría que avisar a quién, y en qué momento, para que ninguna puerta quede abierta?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ciclo}}' => $img('altas-bajas-cuentas-ciclo', 499, 'Tabla con cuatro momentos del ciclo de vida de una cuenta, qué se hace y quién responde: alta, cambio, baja y revisión.', 'El ciclo de vida de una cuenta.'),
    '{{img:dias}}' => $img('altas-bajas-cuentas-dias', 480, 'Gráfico de barras con los días que cinco cuentas siguieron activas tras el retiro: 91, 91, 81, 45 y 9.', 'Días que cinco cuentas siguieron activas tras el retiro.'),
]);

return [
    'slug' => 'altas-y-bajas-de-cuentas-colegio-retiro-docentes-accesos-excel-auditor',
    'title' => 'Altas y bajas de cuentas del colegio: cómo saber quién sigue entrando cuando ya no trabaja aquí, con un libro de Excel',
    'excerpt' => 'El ciclo de vida de las cuentas del colegio (alta, cambio, baja y revisión), por qué las cuentas huérfanas son un riesgo y cómo detectarlas con un libro de Excel que cruza personas, cuentas y fechas de retiro.',
    'seo_title' => 'Altas y bajas de cuentas del colegio: control en Excel',
    'seo_description' => 'Cómo controlar las altas y bajas de cuentas en el colegio: ciclo de vida, cuentas activas tras el retiro, privilegios y un libro de Excel verificado.',
    'focus_keyword' => 'altas y bajas de cuentas del colegio',
    'cover' => '/assets/img/articulos/altas-bajas-cuentas/altas-bajas-cuentas-portada',
    'cover_alt' => 'Portada "Altas y bajas de cuentas: quién sigue entrando cuando ya no trabaja aquí" con una tarjeta: 5 de 11 cuentas de personas retiradas seguían activas, una de ellas con rol de administrador.',
    'published_at' => '2027-03-02 12:00:00',
    'content_html' => $html,
];
