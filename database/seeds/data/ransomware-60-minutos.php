<?php

declare(strict_types=1);

// "Ransomware: qué hacer en los primeros 60 minutos". Fuentes verificadas el 9 de octubre de 2026: guía #StopRansomware de CISA/FBI/NSA/MS-ISAC (cisa.gov/stopransomware/ransomware-guide), Verizon DBIR 2025 (vía cobertura especializada), Ley 1273 de 2009, Ley 1581 de 2012 y guías sobre el reporte a la SIC (15 días hábiles; confirmar vigente).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ransomware-60-minutos/' . $name;
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
<p>Un lunes por la mañana, un computador de la secretaría muestra una pantalla roja: "Tus archivos han sido cifrados. Paga para recuperarlos". En minutos, otros equipos empiezan a fallar. Lo que ocurra en la primera hora decide si el incidente se queda en una molestia grave o se convierte en semanas sin notas, sin cobros y con los datos de estudiantes en manos de extorsionistas.</p>
<p>La mayoría de colegios y pequeñas empresas no tienen un protocolo: improvisan. Este artículo propone uno para los <strong>primeros 60 minutos</strong>, minuto a minuto, basado en la lista de respuesta de la guía #StopRansomware de CISA, el FBI, la NSA y MS-ISAC, adaptado a un colegio o una pyme colombiana. Incluye un <a href="/descargas/ransomware/protocolo-60-minutos-ransomware.xlsx">libro descargable</a> con la lista de acciones, los contactos, el registro del incidente y el orden de restauración. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> En los primeros minutos: <strong>aísla sin apagar</strong>, <strong>avisa por teléfono</strong> (no por canales que pueden estar comprometidos), <strong>protege los respaldos</strong> y <strong>registra todo</strong>. No pagues sin asesoría, no restaures sin verificar la copia y no improvises la comunicación. Esto es una guía general: adáptala con tu proveedor de TI y un asesor jurídico; no sustituye ayuda profesional.</p>

<h2>Qué es y qué tan frecuente es</h2>
<p>El ransomware es un programa malicioso que cifra los archivos de una organización y exige un pago a cambio de la clave. Hoy es habitual que, además, los atacantes <strong>roben</strong> los datos antes de cifrarlos y amenacen con publicarlos (la "doble extorsión"); por eso restaurar un respaldo no siempre cierra el problema.</p>
<p>Según el informe Verizon DBIR 2025 (que analiza incidentes de 2024, a nivel mundial), el ransomware estuvo presente en el <strong>44 %</strong> de las brechas analizadas, frente al 32 % del año anterior; el 64 % de las víctimas no pagó el rescate, y la mediana de los pagos fue de unos <strong>115.000 dólares</strong>. En las brechas de pequeñas y medianas empresas, el ransomware apareció en el <strong>88 %</strong>. (Cifras tomadas de la cobertura especializada del informe; consulta el informe original.) No hay razones para creer que un colegio o una pyme colombiana esté fuera de la mira: los atacantes suelen buscar a quien tiene menos defensas y datos valiosos.</p>
{{img:datos}}

<h2>Los primeros 60 minutos</h2>
{{img:ventanas}}
<h3>De 0 a 5 minutos: aislar</h3>
<ul>
<li><strong>Desconecta el equipo de la red</strong> (cable y Wi-Fi). La guía de CISA indica determinar qué sistemas se ven afectados y aislarlos de inmediato.</li>
<li><strong>No lo apagues</strong>, salvo que no puedas desconectarlo: apagar puede borrar evidencia que está en la memoria.</li>
<li>Toma una <strong>foto de la pantalla</strong> con el mensaje de rescate. No respondas a los atacantes ni abras nada más.</li>
</ul>
<h3>De 5 a 15 minutos: avisar y proteger</h3>
<ul>
<li><strong>Llama por teléfono</strong> al responsable del incidente y al proveedor de TI. No uses el correo ni el chat de la institución si podrían estar comprometidos; la guía de CISA recomienda coordinar el aislamiento por teléfono para que los atacantes no se enteren de que fueron detectados.</li>
<li>Si varios equipos están afectados, <strong>desconecta ese segmento de red</strong> (o el conmutador).</li>
<li><strong>Protege los respaldos</strong>: desconecta discos o unidades de copia y cierra las sesiones de almacenamiento en la nube. Un respaldo conectado también puede cifrarse (ver <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">la nube no es un respaldo</a>).</li>
</ul>
<h3>De 15 a 30 minutos: registrar y preservar</h3>
<ul>
<li>Abre el <strong>registro del incidente</strong>: hora, quién lo detectó, qué se ve y qué se hizo.</li>
<li><strong>Preserva evidencia</strong>: fotos, nombres de archivos cifrados, registros. La guía sugiere capturar imágenes del sistema y de la memoria de una muestra de equipos; pídele esto a tu proveedor de TI o a un especialista.</li>
<li>Desde un equipo limpio, <strong>cambia las contraseñas administrativas</strong> y activa la verificación en dos pasos.</li>
</ul>
<h3>De 30 a 45 minutos: evaluar</h3>
<ul>
<li>Clasifica los sistemas por criticidad con la hoja "Inventario_critico": ¿qué sostiene las operaciones del día? Eso se restaura primero.</li>
<li>Pregunta: <strong>¿hay datos personales afectados?</strong> Si los hay, se activan obligaciones de reporte.</li>
</ul>
<h3>De 45 a 60 minutos: notificar y decidir</h3>
<ul>
<li>Informa a la <strong>dirección o rectoría</strong> y a la persona encargada de datos personales.</li>
<li>Contacta a un <strong>asesor jurídico</strong> y a las autoridades (en Colombia, por ejemplo, el CAI Virtual de la Policía Nacional; verifica el canal vigente).</li>
<li>Comunica a los usuarios internos qué hacer y qué no hacer, con un mensaje corto, por un canal seguro.</li>
<li><strong>Verifica la copia de respaldo en un entorno limpio antes de restaurar</strong>: restaurar sobre un sistema aún infectado repite el problema.</li>
</ul>

<h2>Lo que no se debe hacer</h2>
<ul>
<li><strong>Pagar a toda prisa.</strong> La guía de CISA no recomienda pagar y advierte que el pago no garantiza que recuperes tus datos ni que no los filtren; además, financia a los delincuentes. Antes de cualquier decisión, consulta a las autoridades y a un asesor jurídico, que también te dirán si existe un descifrador público para esa variante.</li>
<li><strong>Apagar y reiniciar todo</strong> sin criterio, perdiendo evidencia.</li>
<li><strong>Restaurar sin verificar</strong> que la copia está limpia y que se cerró la puerta de entrada.</li>
<li><strong>Borrar archivos</strong> "para limpiar": destruye evidencia y puede complicar la recuperación.</li>
<li><strong>Comunicar a medias</strong> o negar el incidente a quienes tienen derecho a saberlo.</li>
</ul>

<h2>El marco colombiano en pocas líneas</h2>
<ul>
<li><strong>Ley 1273 de 2009:</strong> tipifica delitos informáticos; por ejemplo, el daño informático (art. 269D) y el uso de software malicioso (art. 269E) pueden aplicar a un ataque de ransomware. Una denuncia ayuda a la investigación y a tu protección jurídica.</li>
<li><strong>Ley 1581 de 2012:</strong> si el incidente compromete datos personales (por ejemplo, de estudiantes), el responsable del tratamiento debe reportarlo a la Superintendencia de Industria y Comercio. Según las guías consultadas, el reporte de incidentes de seguridad al Registro Nacional de Bases de Datos debe hacerse dentro de los 15 días hábiles siguientes a que se detecte; confirma el procedimiento y el plazo vigentes en el sitio de la SIC con tu asesor.</li>
<li><strong>Datos de menores:</strong> su tratamiento exige especial cuidado (ver <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">datos de estudiantes</a>).</li>
</ul>

<h2>Antes de que ocurra: lo que cambia el resultado</h2>
<ol>
<li><strong>Respaldo 3-2-1</strong>: tres copias, en dos medios distintos, una fuera de línea o fuera de la red. Y <strong>pruébalo</strong>: hay un <a href="/descargas/respaldo/verificar-restauracion.ps1">script para verificar la restauración</a>.</li>
<li><strong>Verificación en dos pasos</strong> en correo, plataformas y cuentas administrativas.</li>
<li><strong>Actualizaciones</strong> de sistemas, VPN y aplicaciones; muchos ataques entran por fallas conocidas.</li>
<li><strong>Cuentas con el mínimo privilegio</strong>: que nadie use una cuenta administrativa para el trabajo diario.</li>
<li><strong>Capacitación</strong> contra el phishing, porque el correo sigue siendo una puerta frecuente (ver <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a> y <a href="/estafas-voz-clonada-ia-protocolo-verificacion/">estafas con voz clonada</a>).</li>
<li><strong>Un simulacro</strong> de este protocolo una vez al año: la primera vez que lo lees no debería ser el día del ataque.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la educación y las pymes son blancos frecuentes porque combinan datos valiosos con presupuestos de seguridad limitados. En Colombia y Latinoamérica, muchos colegios dependen de una sola persona de sistemas, o de un proveedor externo, y no tienen un plan escrito. Para los <strong>directivos</strong>, la pregunta es quién decide y quién responde en la primera hora; para <strong>docentes y administrativos</strong>, qué hacer al ver una pantalla de rescate (desconectar y avisar, no probar suerte); y para las <strong>familias</strong>, qué datos de sus hijos están en juego y cómo se les informaría. Ver también <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a> y <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">integraciones que fallan en silencio</a>.</p>

<h2>Proteger los datos sensibles desde el diseño</h2>
<p>Los documentos más sensibles de un colegio (como los PIAR de estudiantes) no deberían vivir en carpetas compartidas sin control. <a href="/herramientas/piar/">PIAR con IA</a> los guarda en una cuenta con acceso controlado, aunque tú debes mantener tus propios respaldos y reglas. Y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> ayuda a mantener los exámenes y sus soluciones en un solo lugar, en vez de repartidos en correos y memorias USB.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}

<h2>Preguntas frecuentes</h2>
<h3>¿Debo apagar el computador si veo una nota de rescate?</h3>
<p>Primero desconéctalo de la red. Apágalo solo si no puedes desconectarlo, porque apagarlo puede borrar evidencia que está en la memoria.</p>
<h3>¿Debo pagar el rescate?</h3>
<p>Las autoridades de EE. UU. no lo recomiendan: no garantiza recuperar los datos ni que no los filtren, y financia a los delincuentes. Consulta a un asesor jurídico y a las autoridades antes de decidir.</p>
<h3>¿Basta con tener un respaldo?</h3>
<p>Ayuda mucho, pero solo si está aislado, se ha probado restaurar y no fue cifrado también. Además, la doble extorsión amenaza con publicar datos robados.</p>
<h3>¿Hay que reportar el incidente?</h3>
<p>Si hay datos personales comprometidos, sí, ante la SIC (según las guías consultadas, dentro de 15 días hábiles desde su detección; confirma el plazo vigente). También conviene denunciar ante las autoridades.</p>
<h3>¿Cada cuánto debo practicar el protocolo?</h3>
<p>Al menos una vez al año y cada vez que cambien los sistemas o el personal responsable.</p>

<p class="notice"><strong>Prepárate esta semana.</strong> Descarga el <a href="/descargas/ransomware/protocolo-60-minutos-ransomware.xlsx">protocolo de 60 minutos</a>, llena la hoja de contactos con números de celular (no solo correos), imprímelo y deja una copia fuera de la red. Después prueba tu respaldo con el <a href="/descargas/respaldo/verificar-restauracion.ps1">script de verificación</a>.</p>

<h2>Para pensar</h2>
<p>Cuando un colegio sufre un ataque, las primeras víctimas son los estudiantes y las familias cuyos datos estaban a su cuidado. <strong>¿Quién debe responder cuando los datos de los menores se filtran por un ataque que pudo evitarse con respaldos y un protocolo: el proveedor de TI, la rectoría, el consejo directivo o el Estado que no exige estándares mínimos de ciberseguridad a las instituciones educativas? Y si pagar el rescate puede ser la salida más rápida, ¿es legítimo hacerlo cuando financia al delito?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('ransomware-60-minutos-datos', 573, 'Cuatro tarjetas con datos del informe Verizon DBIR 2025: el ransomware estuvo en el 44 % de las brechas, el 64 % de las víctimas no pagó, la mediana del pago fue de 115.000 dólares y apareció en el 88 % de las brechas de pymes.', 'El ransomware ya es parte de casi la mitad de las brechas analizadas.'),
    '{{img:ventanas}}' => $img('ransomware-60-minutos-ventanas', 467, 'Cinco ventanas de tiempo para los primeros 60 minutos: aislar, avisar, registrar, evaluar y notificar, con la prioridad de cada una.', 'Cinco ventanas, una prioridad en cada una.'),
]);

return [
    'slug' => 'ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme',
    'title' => 'Ransomware: qué hacer en los primeros 60 minutos, y qué no hacer, en un colegio o una pyme',
    'excerpt' => 'Un protocolo minuto a minuto para los primeros 60 minutos de un ataque de ransomware, basado en la guía de CISA y el FBI, con datos del DBIR 2025, el marco colombiano y un libro descargable con contactos y registro del incidente.',
    'seo_title' => 'Ransomware: qué hacer en los primeros 60 minutos',
    'seo_description' => 'Protocolo de los primeros 60 minutos ante un ransomware en un colegio o pyme: aislar, avisar, registrar y notificar, con libro descargable y marco colombiano.',
    'focus_keyword' => 'ransomware qué hacer primeros minutos',
    'cover' => '/assets/img/articulos/ransomware-60-minutos/ransomware-60-minutos-portada',
    'cover_alt' => 'Portada "Ransomware: qué hacer en los primeros 60 minutos y qué no hacer" con una lista: aislar el equipo de la red, llamar por teléfono al responsable y proteger los respaldos, marcados; pagar sin consultar, descartado.',
    'published_at' => '2026-11-24 12:00:00',
    'content_html' => $html,
];
