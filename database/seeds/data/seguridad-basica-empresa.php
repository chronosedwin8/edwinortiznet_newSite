<?php

declare(strict_types=1);

// "Errores básicos de seguridad": lista de comprobación para auditar la seguridad básica de una empresa o colegio. Datos verificados el 9 de
// octubre de 2026 (Verizon DBIR 2025, IBM Cost of a Data Breach 2025, estudio de Microsoft Research sobre MFA, NIST SP 800-63B-4, SIC).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/seguridad-basica-empresa/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Cuando pensamos en un ataque informático imaginamos a un experto tecleando a toda velocidad en un cuarto oscuro. La realidad es más aburrida y más incómoda: la mayoría de los desastres empiezan con una contraseña repetida, una cuenta sin segunda verificación, un permiso que nadie revisó o un respaldo que nadie probó. <strong>No hacen falta hackers más sofisticados; basta con que tus errores básicos sigan ahí.</strong></p>
<p>En este artículo te muestro qué dicen los datos, cuáles son los cuatro errores básicos que más daño causan y te dejo una <strong>lista de comprobación de 20 puntos</strong> para auditar la seguridad básica de tu empresa, tu oficina contable o tu colegio. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Según el informe DBIR 2025 de Verizon, las credenciales robadas o abusadas son la principal vía de acceso inicial (22 % de las brechas) y cerca del 60 % de las brechas involucra un elemento humano. La autenticación multifactor reduce el riesgo de que una cuenta sea comprometida en más del 99 % según un estudio de Microsoft. Cuatro frentes: contraseñas, MFA, permisos y respaldos que realmente se puedan restaurar.</p>

<h2>Qué dicen los datos: lo básico sigue siendo la puerta principal</h2>
<p>El <a href="https://www.verizon.com/business/resources/reports/dbir/">Data Breach Investigations Report 2025 de Verizon</a> analiza miles de brechas reales. Entre sus hallazgos, la vía de entrada más común fue el <strong>abuso de credenciales (22 %)</strong>, seguida de la explotación de vulnerabilidades (20 %) y el phishing (16 %); y alrededor del 60 % de las brechas tuvo un componente humano, como caer en un engaño o usar credenciales robadas. Ojo con un matiz que suele confundirse: el 88 % que circula en resúmenes se refiere a ataques web básicos en los que se usaron credenciales robadas, no a todas las brechas.</p>
{{img:datos}}
<p>¿Cuánto cuesta equivocarse? El <a href="https://www.ibm.com/reports/data-breach">informe Cost of a Data Breach 2025 de IBM</a> estima un costo promedio global de 4,44 millones de dólares por brecha; en América Latina, la muestra del informe (que incluye empresas de Argentina, Brasil, Chile, Colombia y México) arrojó unos 2,51 millones. Son promedios de empresas grandes y medianas, y no hay una cifra solo para Colombia, pero la lectura es clara: una pyme no necesita perder millones para que el golpe sea fatal. Y el contexto local importa: la Estrategia Nacional de Seguridad Digital ubicó a Colombia como el segundo país más atacado de América Latina en 2025, con el 17 % de los intentos de la región, según recogió <a href="https://www.portafolio.co/tecnologia/estafas-con-voces-clonadas-por-ia-crecieron-30-en-diciembre-y-alertan-a-expertos-en-colombia-486082">Portafolio</a>.</p>

<h2>Error 1: contraseñas débiles, repetidas o mal gestionadas</h2>
<p>La guía <a href="https://csrc.nist.gov/pubs/sp/800/63/b/4/final">NIST SP 800-63B-4</a> (publicada en julio de 2025) cambió varios mitos: recomienda priorizar la <strong>longitud</strong> sobre la complejidad, <strong>no forzar cambios periódicos</strong> sin evidencia de compromiso y comparar las contraseñas contra listas de claves filtradas o comunes. En la práctica, para una empresa pequeña:</p>
<ul>
<li>Usa contraseñas largas (frases de varias palabras) y <strong>únicas</strong> para cada servicio.</li>
<li>Adopta un <strong>gestor de contraseñas</strong>: es la única forma realista de tener claves únicas sin escribirlas en un papel o en un Excel.</li>
<li>No obligues a cambiar la clave cada 90 días: eso produce "Clave2026!" y "Clave2027!". Cámbiala cuando haya sospecha de filtración.</li>
<li>Revisa si tus correos aparecen en filtraciones conocidas y cambia las claves afectadas.</li>
</ul>

<h2>Error 2: no usar autenticación multifactor (MFA)</h2>
<p>Una contraseña robada deja de servir si hace falta un segundo factor. Un <a href="https://arxiv.org/abs/2305.00945">estudio de Microsoft Research (2023)</a> sobre cuentas con actividad sospechosa encontró que la MFA redujo el riesgo de compromiso en 99,22 % en la población y en 98,56 % cuando las credenciales ya se habían filtrado. Es una reducción de riesgo observada en cuentas de Microsoft, no una garantía universal, y los autores hallaron que las aplicaciones de autenticación funcionan mejor que los mensajes SMS. Prioriza en este orden:</p>
<ol>
<li>El <strong>correo electrónico</strong> (con él se restablecen todas las demás cuentas).</li>
<li>La <strong>banca en línea</strong> y las cuentas de pago.</li>
<li>Las <strong>cuentas de administración</strong> (hosting, dominio, nube, redes sociales de la empresa).</li>
<li>Después, todos los demás servicios que lo permitan.</li>
</ol>

<h2>Error 3: permisos excesivos y cuentas que nadie cierra</h2>
<p>El "mínimo privilegio" significa que cada persona accede solo a lo que necesita para su trabajo. En la práctica se rompe de cuatro formas: todos son administradores "para que no molesten", se comparte una misma cuenta entre varias personas, no se cierra el acceso de quien dejó la empresa y las carpetas compartidas están abiertas "a cualquiera con el enlace". Un colegio lo vive con las cuentas de docentes que se van a mitad de año y con los accesos a las notas; una pyme, con el contador externo que mantiene acceso a todo. Soluciones: roles por cargo, una cuenta por persona, una lista de salida (<em>offboarding</em>) para cerrar accesos el último día y revisiones trimestrales de quién ve qué.</p>

<h2>Error 4: respaldos que nunca se verificaron</h2>
<p>Tener los archivos "en la nube" no es tener un respaldo: la sincronización replica también los borrados y los archivos cifrados por un ransomware. Un respaldo útil es una <strong>copia independiente, con versiones, y que has probado restaurar</strong>. La regla clásica 3-2-1 (tres copias, en dos medios, una fuera del sitio) sigue siendo un buen punto de partida. Y la única forma de saber si funciona es una <strong>prueba de restauración</strong>: elige un archivo y una carpeta, restáuralos en otro equipo y comprueba que abren. Si nunca lo hiciste, no tienes un respaldo: tienes una esperanza.</p>

<h2>Lista de comprobación: autoevaluación de seguridad básica</h2>
<p>Este es el recurso aplicable. Responde "sí" o "no" a cada punto y cuenta tus "sí". Es una herramienta de autodiagnóstico práctica, no una certificación ni una auditoría formal.</p>
{{img:pasos}}
<table>
<thead><tr><th>Área</th><th>Pregunta (responde sí o no)</th></tr></thead>
<tbody>
<tr><td><strong>Contraseñas</strong></td><td>1. Todas las cuentas importantes tienen contraseñas largas y distintas entre sí.</td></tr>
<tr><td><strong>Contraseñas</strong></td><td>2. Usamos un gestor de contraseñas (nadie guarda claves en papeles, chats o archivos sin cifrar).</td></tr>
<tr><td><strong>Contraseñas</strong></td><td>3. No obligamos a cambios periódicos sin motivo, pero sí cambiamos al sospechar una filtración.</td></tr>
<tr><td><strong>Contraseñas</strong></td><td>4. Las claves de administración no se comparten por WhatsApp ni correo.</td></tr>
<tr><td><strong>Contraseñas</strong></td><td>5. Revisamos si nuestros correos aparecen en filtraciones conocidas.</td></tr>
<tr><td><strong>MFA</strong></td><td>6. El correo de la empresa tiene verificación en dos pasos.</td></tr>
<tr><td><strong>MFA</strong></td><td>7. La banca en línea tiene MFA y las notificaciones de transacciones están activas.</td></tr>
<tr><td><strong>MFA</strong></td><td>8. Las cuentas de administración (dominio, hosting, nube) tienen MFA.</td></tr>
<tr><td><strong>MFA</strong></td><td>9. Usamos una app de autenticación o llave de seguridad, no solo SMS, donde es posible.</td></tr>
<tr><td><strong>MFA</strong></td><td>10. Guardamos de forma segura los códigos de recuperación.</td></tr>
<tr><td><strong>Permisos</strong></td><td>11. Cada persona tiene su propia cuenta; no se comparten.</td></tr>
<tr><td><strong>Permisos</strong></td><td>12. Solo quien lo necesita es administrador.</td></tr>
<tr><td><strong>Permisos</strong></td><td>13. Cerramos los accesos de quien se va el mismo día.</td></tr>
<tr><td><strong>Permisos</strong></td><td>14. Las carpetas compartidas no están abiertas a "cualquiera con el enlace".</td></tr>
<tr><td><strong>Permisos</strong></td><td>15. Revisamos quién tiene acceso a qué, al menos cada trimestre.</td></tr>
<tr><td><strong>Respaldos</strong></td><td>16. Tenemos al menos una copia independiente de los datos críticos (no solo sincronizada).</td></tr>
<tr><td><strong>Respaldos</strong></td><td>17. Una copia está fuera del sitio o desconectada, a salvo de un ransomware.</td></tr>
<tr><td><strong>Respaldos</strong></td><td>18. Probamos restaurar un archivo y una carpeta en los últimos 6 meses.</td></tr>
<tr><td><strong>Respaldos</strong></td><td>19. Sabemos cuánto tardaríamos en volver a operar (y cuánto dato perderíamos).</td></tr>
<tr><td><strong>Respaldos</strong></td><td>20. Alguien tiene por escrito el procedimiento de restauración.</td></tr>
</tbody>
</table>
<p><strong>Cómo leer tu puntaje (orientativo).</strong> 17 a 20 "sí": buena base; sigue revisando. 11 a 16: hay brechas que conviene cerrar este mes, empezando por MFA y respaldos. 10 o menos: prioridad alta; dedica una semana a cerrar los puntos de correo, banco y respaldo. Si un incidente expone datos personales, además tienes obligaciones legales: según varias firmas jurídicas, los incidentes de seguridad deben reportarse a la Superintendencia de Industria y Comercio en el Registro Nacional de Bases de Datos dentro de los 15 días hábiles siguientes a su detección; confirma el texto vigente en sic.gov.co o con un abogado.</p>

<h2>Colombia, Latinoamérica y el mundo: dónde está la brecha</h2>
<p>A nivel mundial, la MFA y los respaldos ya son requisitos mínimos de grandes empresas y de los seguros cibernéticos. En Latinoamérica, la IBM encuentra que la adopción de IA y automatización en seguridad reduce costos, y el 75 % de las empresas de la región ya las usa, en distintos niveles de madurez. En Colombia, la brecha suele ser de prioridades, no de dinero: muchas pymes y colegios tienen antivirus pero no MFA, y hojas de cálculo con contraseñas pegadas al monitor. Para <strong>docentes y directivos</strong>, el riesgo es doble: datos sensibles de menores y operación escolar paralizada. Para <strong>familias</strong>, la lección es la misma a menor escala: MFA en el correo y en las cuentas de los hijos, y fotos respaldadas.</p>

<h2>Herramientas para empezar hoy</h2>
<p>Si tu negocio factura o envía documentos por correo, estandariza el remitente y el formato: la <a href="/producto/factura-con-envio-por-correo-al-cliente/">Factura con envío por correo al cliente</a> mantiene siempre la misma plantilla y datos bancarios, así que cualquier cambio de cuenta que llegue "de parte tuya" salta a la vista como una anomalía (lo expliqué en el artículo sobre <a href="/estafas-voz-clonada-ia-protocolo-verificacion/">estafas con voz clonada</a>). Y si enseñas, el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> incluye una secuencia de ciudadanía digital (huella, privacidad, ciberacoso y datos personales) para llevar estos hábitos al aula; el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> convierte esta lista en un quiz para tus estudiantes (<a href="/examenes/demo/">demostración gratis</a>).</p>
{{productos:factura-con-envio-por-correo-al-cliente,kit-de-ia-para-docentes}}
<p>Si necesitas que alguien te acompañe a implementar plantillas y controles en Excel, está la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a>. Y para seguir: <a href="/excel-esta-muerto-era-de-la-ia/">¿Excel está muerto en la era de la IA?</a> y <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">cómo automatizar tareas en Excel y reducir errores</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es lo primero que debo hacer para proteger a mi empresa?</h3>
<p>Activar la verificación en dos pasos en el correo y en la banca en línea, y hacer una prueba de restauración de tus respaldos. Son los dos cambios de menor costo y mayor efecto.</p>
<h3>¿Un antivirus es suficiente?</h3>
<p>No. Protege contra algunos programas maliciosos, pero no contra una contraseña robada, un permiso excesivo o un respaldo inexistente, que son los frentes que más pesan en los datos.</p>
<h3>¿Cada cuánto debo cambiar las contraseñas?</h3>
<p>NIST ya no recomienda cambios periódicos obligatorios sin evidencia de compromiso. Mejor: claves largas y únicas, un gestor de contraseñas y cambio inmediato si hay sospecha de filtración.</p>
<h3>¿La nube es un respaldo?</h3>
<p>No necesariamente. La sincronización replica errores, borrados y cifrados. Un respaldo tiene versiones, es independiente y se prueba restaurando.</p>
<h3>¿Qué hago si ya me atacaron?</h3>
<p>Aísla el equipo, cambia las claves desde un dispositivo limpio, avisa al banco si hubo dinero en juego, conserva las pruebas y denuncia (en Colombia, el CAI Virtual de la Policía y la Fiscalía). Si hubo datos personales, evalúa el reporte ante la SIC.</p>

<p class="notice"><strong>Haz hoy tu autoevaluación.</strong> Responde los 20 puntos, cierra los tres más urgentes esta semana y agenda una prueba de restauración. Comparte la lista con quien administra tus sistemas y, si enseñas, llévala al aula con el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>.</p>

<h2>Para pensar</h2>
<p>Gastamos millones en cerraduras y alarmas físicas y casi nada en revisar quién tiene las llaves digitales. <strong>Si el error más común de seguridad es humano, ¿es justo castigar a quien cae en un engaño, o deberíamos diseñar sistemas en los que un descuido no tenga consecuencias catastróficas?</strong> ¿Y quién debe responder cuando una empresa pequeña pierde los datos de sus clientes por no haber hecho lo básico: el dueño, el proveedor de tecnología o la falta de cultura de seguridad en todo el país?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('seguridad-basica-empresa-datos', 588, 'Gráfico de barras de los vectores de acceso inicial en las brechas de seguridad según el informe DBIR 2025 de Verizon: credenciales robadas o abusadas 22 %, explotación de vulnerabilidades 20 % y phishing 16 %.', 'Vectores de acceso inicial. Fuente: Verizon, DBIR 2025.'),
    '{{img:pasos}}' => $img('seguridad-basica-empresa-pasos', 427, 'Cinco pasos de una auditoría básica de seguridad: inventariar, activar MFA, reducir permisos, probar la restauración y documentar y repetir.', 'Auditoría básica de seguridad en cinco pasos.'),
]);

return [
    'slug' => 'errores-basicos-seguridad-empresa-lista-comprobacion',
    'title' => 'La mayoría de las empresas no necesita hackers más sofisticados para sufrir un desastre: necesita corregir sus errores básicos de seguridad',
    'excerpt' => 'Contraseñas débiles, falta de autenticación multifactor, permisos excesivos y respaldos sin verificar: qué dicen los datos y una lista de comprobación de 20 puntos para autoevaluar tu seguridad básica.',
    'seo_title' => 'Seguridad básica para empresas: lista de comprobación',
    'seo_description' => 'Los errores básicos de seguridad que más daño causan (contraseñas, MFA, permisos y respaldos) y una lista de 20 puntos para auditar tu empresa o colegio.',
    'focus_keyword' => 'seguridad básica para empresas',
    'cover' => '/assets/img/articulos/seguridad-basica-empresa/seguridad-basica-empresa-portada',
    'cover_alt' => 'Portada con el título "Tu empresa no necesita hackers sofisticados para sufrir un desastre: corrige lo básico" y una tarjeta con cuatro errores marcados: contraseñas débiles, sin autenticación multifactor, permisos excesivos y respaldos sin restaurar.',
    'published_at' => '2026-10-20 12:00:00',
    'content_html' => $html,
];
