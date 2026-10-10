<?php

declare(strict_types=1);

// "Extensiones del navegador: comodidad que puede ver todo lo que haces". Fuentes verificadas el 10 de octubre de 2026: análisis del incidente de Cyberhaven (dic. 2024), LayerX Enterprise Browser Extension Security Report 2025 (vía prensa especializada). Auditor en Python probado con manifiestos de ejemplo y un perfil real; inventario verificado en Excel.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/extensiones-navegador/' . $name;
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
<p>Una extensión de navegador parece un detalle inocente: un modo oscuro, un traductor, un buscador de cupones, un convertidor de PDF. Pero cuando instalas una, le das permiso para actuar <strong>dentro de tu navegador</strong>, justo donde entras a tu correo, a la plataforma del colegio, al banco y a las cuentas de tus estudiantes. Una extensión con permiso para "leer y cambiar tus datos en todos los sitios web" puede, en principio, ver lo que escribes y lo que ves en todas partes.</p>
<p>Este artículo explica los riesgos de las extensiones del navegador, con datos verificados, un caso real de una extensión legítima que fue comprometida, un <a href="/descargas/extensiones-navegador/auditar_extensiones.py">auditor en Python</a> que lee las extensiones instaladas (lo probé con ejemplos) y un <a href="/descargas/extensiones-navegador/inventario-politica-extensiones-navegador.xlsx">libro en Excel</a> con inventario, matriz de permisos y política modelo. Datos verificados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Casi todos los usuarios tienen extensiones y muchas piden permisos muy amplios. El riesgo no viene solo de extensiones "malas": una extensión legítima puede <strong>comprometerse</strong>, venderse a otro dueño o quedar abandonada. La defensa es de proceso: <strong>inventariar, justificar cada extensión, preferir las de menos permisos, actualizar y revisar cada trimestre</strong>. Y en equipos con datos sensibles, perfiles de navegador separados y limpios.</p>

<h2>Qué dicen los datos</h2>
<p>El informe Enterprise Browser Extension Security Report 2025 de LayerX, que combina datos públicos de las tiendas de extensiones con telemetría de entornos empresariales, reporta (según la cobertura de prensa especializada) que el <strong>99 %</strong> de los usuarios empresariales tiene al menos una extensión instalada, que el <strong>53 %</strong> tiene extensiones con permisos "altos" o "críticos" (que pueden acceder a cookies, contraseñas y datos de navegación) y que el 51 % de las extensiones llevaba más de un año sin actualizarse; las extensiones de IA generativa, además, tienen permisos de ese nivel con el doble de frecuencia que el promedio. Son datos de entornos empresariales y de una fuente comercial de seguridad, así que se leen como un indicio de la magnitud, no como una cifra exacta para un colegio.</p>
{{img:datos}}

<h2>Un caso real: la extensión legítima que se volvió maliciosa</h2>
<p>En diciembre de 2024, la empresa de seguridad Cyberhaven reconoció que su propia extensión de Chrome había sido comprometida. Según su análisis del incidente, un empleado con acceso de administrador a la Chrome Web Store recibió un correo de phishing que simulaba ser del soporte para desarrolladores y lo llevó a una página falsa de consentimiento OAuth. Con ese acceso, los atacantes publicaron una versión maliciosa (la 24.10.4) que estuvo disponible <strong>menos de 24 horas</strong>, entre el 25 y el 26 de diciembre, y solo afectó a quienes recibieron la actualización automática en ese lapso. El código estaba diseñado para robar cookies y tokens de autenticación de ciertas plataformas de redes sociales y de IA. Los investigadores concluyeron que formaba parte de una campaña más amplia (con el mismo método contra otras extensiones); las cifras de extensiones y usuarios afectados varían según la fuente (la propia extensión de Cyberhaven tenía unos 400.000 usuarios), por lo que no las cito como definitivas.</p>
<p>Lo importante es la lección: <strong>una extensión se actualiza sola, y quien controla la cuenta del desarrollador controla lo que llega a todos los usuarios</strong>. No hace falta instalar algo "malo": basta con que una extensión buena sea comprometida o cambie de dueño.</p>

<h2>Las tres formas en que una extensión se vuelve un riesgo</h2>
<ol>
<li><strong>Maliciosa desde el principio:</strong> se disfraza de utilidad (cupones, descargadores, "mejoras") para recoger datos o inyectar publicidad.</li>
<li><strong>Comprometida o vendida:</strong> una extensión legítima cambia de dueño o de código (como en el caso de Cyberhaven, por el robo de acceso al desarrollador). Hay antecedentes también de extensiones populares que, tras una venta, empezaron a incluir código dañino.</li>
<li><strong>Abandonada:</strong> deja de actualizarse, acumula fallas conocidas y sigue instalada en miles de equipos.</li>
</ol>

<h2>Los permisos: qué piden y qué significan</h2>
<table>
<thead><tr><th>Permiso</th><th>Qué permite</th><th>Riesgo</th></tr></thead>
<tbody>
<tr><td><strong>Todos los sitios</strong> (<code>&lt;all_urls&gt;</code>)</td><td>Leer y modificar cualquier página que visites</td><td>Ver lo que escribes y capturar datos de formularios</td></tr>
<tr><td><strong>cookies</strong></td><td>Leer cookies de sesión</td><td>Suplantarte sin tu contraseña</td></tr>
<tr><td><strong>history</strong></td><td>Leer tu historial</td><td>Perfilarte o filtrar tus hábitos</td></tr>
<tr><td><strong>webRequest</strong></td><td>Ver o bloquear tráfico de red</td><td>Interceptar y alterar solicitudes</td></tr>
<tr><td><strong>clipboardRead</strong></td><td>Leer lo que copias</td><td>Capturar contraseñas y códigos copiados</td></tr>
<tr><td><strong>debugger, nativeMessaging, proxy</strong></td><td>Controlar el navegador o la red, hablar con programas del equipo</td><td>Control profundo</td></tr>
</tbody>
</table>
<p>La hoja "Matriz_de_permisos" del libro trae diez permisos delicados con su riesgo y <strong>cuándo pueden ser legítimos</strong>: un gestor de contraseñas necesita acceso a todos los sitios para rellenar formularios, y un bloqueador de anuncios necesita ver el tráfico. Por eso la pregunta no es "¿tiene permisos?" sino <strong>"¿se justifica este nivel de permisos para lo que hace, y confío en quien la mantiene?"</strong>. Chrome y otros navegadores han ido migrando las extensiones al llamado Manifest V3, que limita algunas capacidades (como ejecutar código remoto); eso ayuda, pero no elimina el riesgo de los permisos amplios.</p>

<h2>El auditor en Python: probado con ejemplos</h2>
<p>Un archivo <code>manifest.json</code> acompaña a cada extensión instalada y declara sus permisos. Escribí un auditor de unas 100 líneas (solo biblioteca estándar) que lee esos archivos en un perfil de Chrome o Edge, resuelve los nombres localizados, marca los permisos delicados y calcula una puntuación. No se conecta a internet ni cambia nada. Lo probé con cinco extensiones de ejemplo (inventadas por mí, con los permisos típicos de cada tipo):</p>
<pre><code>5 extensiones en ...\User Data\Default\Extensions
  [ALTO ] 18 pts | Cupones y ofertas (ejemplo)        v1.9.4    MV2 | todos los sitios: SÍ | cookies, history, tabs, webRequest, webRequestBlocking
  [ALTO ] 11 pts | Convertidor de PDF (ejemplo)       v3.1      MV3 | todos los sitios: SÍ | clipboardRead, downloads, scripting
  [MEDIO]  7 pts | Gestor de contrasenas (ejemplo)    v5.2.1    MV3 | todos los sitios: SÍ | scripting
  [BAJO ]  0 pts | Modo oscuro (ejemplo)              v2.0      MV3 | todos los sitios: no | -
  [BAJO ]  0 pts | Temporizador de estudio (ejemplo)  v1.0      MV3 | todos los sitios: no | -
Resumen: 2 de riesgo alto, 3 con acceso a todos los sitios.</code></pre>
{{img:auditor}}
<p>Observa dos cosas. Primero, el ejemplo "Cupones y ofertas" (que pide cookies, historial y tráfico de red en todos los sitios) sube a 18 puntos, y el "Convertidor de PDF" (que lee el portapapeles y actúa sobre todos los sitios https) a 11: ambos "ALTO". Segundo, el gestor de contraseñas queda en "MEDIO" porque necesita acceso amplio: <strong>la puntuación mide cuánto podría hacer una extensión, no si es mala</strong>. Lo uso como filtro para decidir a cuáles mirar primero. Corrí el auditor también en un perfil real de Chrome y funcionó sin errores.</p>

<h2>Inventario y decisión en una hoja</h2>
<p>La hoja "Inventario" pide, por cada extensión: para qué se usa, quién responde por ella, cuántos permisos delicados tiene, si actúa sobre todos los sitios, cuándo se actualizó por última vez, si la fuente es conocida y confiable y si el uso se justifica. Calcula un puntaje (dos puntos por cada permiso delicado, cuatro por actuar en todos los sitios, tres por no actualizarse hace más de un año, tres por fuente no confiable y dos por falta de justificación) y sugiere una decisión: <strong>"Permitir"</strong>, <strong>"Justificar y revisar cada trimestre"</strong> o <strong>"Retirar o revisar con urgencia"</strong>. Con los cinco ejemplos, dos quedan para retirar o revisar con urgencia, tres tienen acceso a todos los sitios y el gestor de contraseñas institucional queda en "Justificar y revisar cada trimestre". Los pesos son una propuesta de elaboración propia que puedes ajustar.</p>

<h2>Una política de ocho reglas</h2>
<ol>
<li>Solo se instalan extensiones de una lista aprobada por TI en equipos institucionales.</li>
<li>Toda solicitud indica quién la pide, para qué y qué permisos pide.</li>
<li>Se prefiere la extensión con menos permisos que cumpla el trabajo.</li>
<li>No se instalan extensiones fuera de la tienda oficial ni archivos sueltos.</li>
<li>Quien publica extensiones propias usa verificación en dos pasos (el caso de Cyberhaven empezó con un phishing a un desarrollador).</li>
<li>Cada trimestre se revisa el inventario y se retira lo que no se usa o dejó de actualizarse.</li>
<li>Los equipos con datos sensibles (estudiantes, finanzas) usan perfiles de navegador separados y limpios.</li>
<li>Si una extensión aparece comprometida: se desinstala, se cambian las contraseñas y se revisan las sesiones abiertas.</li>
</ol>
<p>En un colegio con cuentas de Google Workspace for Education o de Microsoft, los administradores suelen poder permitir o bloquear extensiones desde la consola de administración; consulta con quien administra la cuenta y con tu proveedor de TI cómo se hace en tu caso.</p>

<h2>Una revisión personal en diez minutos</h2>
<ol>
<li>Abre la página de extensiones de tu navegador (en Chrome, <code>chrome://extensions</code>).</li>
<li><strong>Desinstala</strong> las que no usas o no reconoces.</li>
<li>Para las que quedan, abre "Detalles" y revisa el <strong>acceso al sitio</strong>: cuando se pueda, cámbialo a "al hacer clic" o a sitios específicos, en lugar de "en todos los sitios".</li>
<li>Pregúntate quién la mantiene, cuándo se actualizó y cuántos usuarios tiene; desconfía de las que nadie mantiene.</li>
<li>Usa un <strong>perfil separado</strong> para el trabajo con datos de estudiantes o dinero, sin extensiones innecesarias.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, las extensiones se han convertido en un vector de ataque conocido, porque se instalan con un clic y se actualizan solas. En Colombia y Latinoamérica, muchos colegios y pequeñas empresas usan Chromebooks o equipos compartidos donde cada persona instala lo que quiere, sin inventario ni política; y las extensiones de "IA gratis" y "descargadores" son especialmente populares. Para los <strong>directivos</strong>, la pregunta es quién autoriza lo que se instala; para los <strong>docentes</strong>, cuidar las extensiones del equipo con el que ingresan a las plataformas y a las notas; para las <strong>familias</strong>, que el navegador de un estudiante no tenga extensiones que lean lo que escribe; y para los <strong>estudiantes</strong>, entender que "gratis" y "cómodo" a veces se pagan con datos. Ver también <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA gratuita</a> (muchas extensiones de IA leen la página en la que estás) y <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: los primeros 60 minutos</a>.</p>

<h2>Herramientas pensadas para cuidar los datos</h2>
<p><a href="/herramientas/piar/">PIAR con IA</a> guarda los documentos sensibles en una cuenta con acceso controlado, y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> está diseñado para que escribas el contexto y el tema, no datos de estudiantes. Aun así, el equipo desde el que entres debe estar limpio: una extensión con acceso a todos los sitios puede ver lo que haya en pantalla.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a>, <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a> y <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Son peligrosas las extensiones del navegador?</h3>
<p>Pueden serlo: actúan dentro del navegador y, según sus permisos, pueden ver lo que escribes y lo que ves. La mayoría de las extensiones no son maliciosas, pero una legítima puede ser comprometida, vendida o abandonada.</p>
<h3>¿Cómo sé qué permisos tiene una extensión?</h3>
<p>En la página de la tienda, en "Detalles" en la página de extensiones del navegador y, de forma más completa, en el archivo manifest.json, que el auditor del libro lee.</p>
<h3>¿Qué es mejor, pocas extensiones o muchas?</h3>
<p>Pocas, con los menores permisos posibles y con una razón clara para cada una. Cada extensión extra suma superficie de ataque.</p>
<h3>¿Qué hago si sospecho de una extensión?</h3>
<p>Desinstálala, cambia las contraseñas de las cuentas que usaste en ese navegador (empezando por el correo y el banco), cierra las sesiones abiertas y revisa si hubo actividad extraña.</p>
<h3>¿Las extensiones de IA son más riesgosas?</h3>
<p>Según el informe de LayerX, las de IA generativa tienen permisos altos o críticos con más frecuencia que el promedio. Se justifican solo cuando necesitas leer o escribir en las páginas, y no debes darles datos sensibles.</p>

<p class="notice"><strong>Esta semana:</strong> haz la revisión de diez minutos en tu navegador, descarga el <a href="/descargas/extensiones-navegador/inventario-politica-extensiones-navegador.xlsx">inventario y la política</a> y, si administras equipos, corre el <a href="/descargas/extensiones-navegador/auditar_extensiones.py">auditor</a>.</p>

<h2>Para pensar</h2>
<p>Cada extensión es una pequeña delegación de confianza: le damos acceso a lo que hacemos a cambio de una comodidad. <strong>¿Quién debe responder cuando una extensión instalada por un docente en un equipo del colegio filtra los datos de los estudiantes: el docente que la instaló, el colegio que no la controlaba o la tienda que la publicó? Y si la comodidad es tan barata, ¿cuánto vale realmente lo que pagamos con nuestros datos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('extensiones-navegador-datos', 573, 'Cuatro tarjetas con datos del informe LayerX 2025 y el caso Cyberhaven: 99 % con al menos una extensión, 53 % con permisos altos o críticos, 51 % de extensiones sin actualizar hace más de un año y menos de 24 horas de la versión maliciosa.', 'Casi todos tienen extensiones, y muchas ven mucho.'),
    '{{img:auditor}}' => $img('extensiones-navegador-auditor', 499, 'Tabla con cuatro extensiones de ejemplo auditadas: cupones y ofertas en riesgo alto con 18 puntos, convertidor de PDF alto con 11, gestor de contraseñas medio con 7 y modo oscuro bajo con 0.', 'Qué podría hacer cada extensión.'),
]);

return [
    'slug' => 'extensiones-del-navegador-riesgos-permisos-inventario-politica',
    'title' => 'Extensiones del navegador: la comodidad que puede ver todo lo que haces, con inventario y política para colegios y pymes',
    'excerpt' => 'Qué permisos piden las extensiones del navegador, cómo se compromete una extensión legítima (el caso Cyberhaven), un auditor en Python probado, un inventario con puntaje de riesgo y una política modelo de ocho reglas.',
    'seo_title' => 'Extensiones del navegador: riesgos, permisos y política',
    'seo_description' => 'Riesgos de las extensiones del navegador: permisos, caso Cyberhaven, un auditor en Python, inventario con puntaje y una política modelo para tu institución.',
    'focus_keyword' => 'riesgos de las extensiones del navegador',
    'cover' => '/assets/img/articulos/extensiones-navegador/extensiones-navegador-portada',
    'cover_alt' => 'Portada "Extensiones del navegador: comodidad que puede ver todo lo que haces" con una tarjeta: el 53 % de los usuarios empresariales tenía extensiones con permisos altos o críticos y el 99 % al menos una extensión instalada.',
    'published_at' => '2026-12-21 12:00:00',
    'content_html' => $html,
];
