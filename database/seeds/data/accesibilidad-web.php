<?php

declare(strict_types=1);

// «Accesibilidad web: formularios, contraste y teclado». Fuentes verificadas el 9 de octubre de 2026: WebAIM Million 2025; WCAG 2.2 (W3C); Resolución 1519 de 2020 del MinTIC (vía informes de entidades que la citan; no se accedió al texto oficial del anexo); Ley 1346 de 2009. Script y formularios de ejemplo ejecutados; contrastes calculados con la fórmula de WCAG.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/accesibilidad-web/' . $name;
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
<p>Un colegio abre las inscripciones a talleres con un formulario en línea. Una madre con baja visión no logra leer los campos, que están en gris claro sobre blanco; un padre que usa un lector de pantalla oye «campo de texto, campo de texto» sin saber qué se le pide; un estudiante con una lesión en la mano no puede usar el ratón y el botón «Enviar» no se alcanza con el teclado. Nadie quiso excluirlos: simplemente no se pensó en ellos.</p>
<p>La accesibilidad web no es un adorno para unos pocos: <strong>beneficia a todos</strong> (quien usa el celular al sol, quien tiene una conexión lenta, quien se lastimó el brazo) y, en muchos casos, es una obligación legal. Este artículo explica los tres frentes que más fallan (formularios, contraste y teclado), con datos verificados, código de un ejemplo malo y uno bueno, un <a href="/descargas/accesibilidad-web/revisar_accesibilidad_basica.py">script en Python que detecta problemas comunes</a> y una <a href="/descargas/accesibilidad-web/lista-accesibilidad-web.xlsx">lista de verificación en Excel</a>. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Los fallos de accesibilidad más frecuentes son simples de corregir: <strong>contraste bajo, imágenes sin texto alternativo, campos sin etiqueta y enlaces vacíos</strong> (WebAIM Million 2025). Un formulario accesible tiene etiquetas visibles, se maneja solo con el teclado, comunica los errores en texto y tiene contraste de al menos 4,5:1. Una revisión automática ayuda, pero no demuestra que una página sea accesible: hay que probarla con el teclado, con zoom y, si es posible, con un lector de pantalla.</p>

<h2>Qué dicen los datos y la ley</h2>
<p>El estudio WebAIM Million 2025 analizó con una herramienta automática (WAVE) un millón de páginas de inicio. Encontró que el <strong>79,1 %</strong> tenía texto con contraste insuficiente, el <strong>55,5 %</strong> imágenes sin texto alternativo, el <strong>48,2 %</strong> campos de formulario sin etiqueta y el <strong>45,4 %</strong> enlaces vacíos; esas categorías (más botones vacíos y falta de idioma) explican el 96 % de los errores detectados, y son prácticamente las mismas desde hace unos cinco años. Según la cobertura del informe, cerca del 95 % de las páginas tenía algún fallo de WCAG detectable. Y una advertencia del propio estudio: <strong>una página sin errores detectados no es necesariamente accesible</strong>, porque las herramientas automáticas solo encuentran una parte de los problemas.</p>
{{img:webaim}}
<p>El marco de referencia internacional son las <strong>Pautas de Accesibilidad para el Contenido Web (WCAG)</strong> del W3C, hoy en su versión 2.2, organizadas en niveles A, AA y AAA. En Colombia, según informes de entidades que lo citan (no pude acceder al texto oficial del anexo), la Resolución 1519 de 2020 del MinTIC exige a los sujetos obligados, que son principalmente entidades públicas, cumplir con el nivel AA de WCAG 2.1 en sus portales desde el 1 de enero de 2022, y las auditorías de control interno verifican 32 criterios de su Anexo 1. Colombia también aprobó la Convención sobre los Derechos de las Personas con Discapacidad mediante la Ley 1346 de 2009. Un colegio privado o una pyme puede no estar obligado por esa resolución, pero la lógica es la misma: <strong>si el servicio no es accesible, hay personas que no pueden usarlo</strong>. Confirma con tu asesor jurídico qué te aplica.</p>

<h2>Frente 1: formularios</h2>
<p>Los formularios son donde más se pierde a las personas, porque es donde se pide algo. Estas reglas resuelven la mayoría:</p>
<ul>
<li><strong>Una etiqueta visible y asociada a cada campo</strong> (<code>&lt;label for="..."&gt;</code>). Un <em>placeholder</em> no la reemplaza: desaparece al escribir y muchos lectores de pantalla no lo anuncian bien. Una prueba rápida: haz clic en la etiqueta; el campo debe enfocarse.</li>
<li><strong>Indicar los obligatorios</strong> en texto (no solo con un asterisco rojo) y usar <code>required</code>.</li>
<li><strong>Autocompletado</strong> (<code>autocomplete="name"</code>, <code>"email"</code>): ayuda a quien escribe con dificultad.</li>
<li><strong>Errores en texto claro</strong> que digan qué campo falló y cómo corregirlo, no solo un borde rojo (el color solo no basta).</li>
<li><strong>Un botón real</strong> (<code>&lt;button&gt;</code>), no un <code>&lt;div&gt;</code> con clic.</li>
</ul>
<p>Un ejemplo malo y uno bueno:</p>
<pre><code><input type="text" name="nombre" placeholder="Nombre">
<input type="email" name="correo" placeholder="Correo">
<a href="reglamento.pdf">Haz clic aquí</a>
<div onclick="enviar()" tabindex="3">Enviar</div></code></pre>
<pre><code><label for="nombre">Nombre completo</label>
<input type="text" id="nombre" name="nombre" autocomplete="name" required>
<label for="correo">Correo electrónico</label>
<input type="email" id="correo" name="correo" autocomplete="email" required>
<a href="reglamento.pdf">Leer el reglamento de talleres (PDF)</a>
<button type="submit">Enviar inscripción</button></code></pre>

<h2>Frente 2: contraste</h2>
<p>WCAG pide una relación de contraste de al menos <strong>4,5:1</strong> para el texto normal y de <strong>3:1</strong> para el texto grande. La relación se calcula a partir de la luminancia relativa de los dos colores. Calculé varios con el script, sobre fondo blanco:</p>
{{img:contraste}}
<p>El gris <code>#767676</code> es, de hecho, el más claro sobre blanco que cumple 4,5:1 (4,54:1); un solo paso más claro, <code>#777777</code>, ya no (4,48:1), y el gris «elegante» <code>#AAAAAA</code> queda en 2,32:1, que muchas personas no pueden leer, y casi nadie en pantalla al sol. Además, no uses solo el color para informar (por ejemplo, un campo con error solo en rojo) y revisa también los estados: enlaces, botones deshabilitados y texto sobre imágenes.</p>

<h2>Frente 3: teclado</h2>
<p>Muchas personas navegan sin ratón: usuarios de lectores de pantalla, de teclados adaptados o con temblores. La prueba es simple y no requiere herramientas: <strong>desconecta el ratón y recorre tu página con Tab</strong>. Debes poder llegar a todo lo interactivo, en un orden lógico, y <strong>ver siempre dónde está el foco</strong>. Los errores típicos: <code>&lt;div onclick&gt;</code> que no recibe el foco, <code>tabindex</code> positivos que alteran el orden, menús que solo abren con el ratón y ventanas emergentes que atrapan el foco. WCAG 2.2 sumó, entre otros, que el foco no quede oculto tras una barra fija y que los objetivos táctiles tengan al menos 24 por 24 píxeles.</p>

<h2>Un script que encuentra lo básico</h2>
<p>Escribí un script de unas 130 líneas en Python (solo biblioteca estándar) que revisa un HTML y detecta ocho problemas frecuentes: imágenes sin <code>alt</code>, campos sin etiqueta, falta de idioma o título, enlaces vacíos o genéricos («haz clic aquí»), botones sin texto, saltos de encabezados, <code>tabindex</code> positivos y <code>div</code> con clic, además de calcular contrastes. Lo probé con el formulario malo (con tres campos sin etiqueta y texto gris) y con el bueno:</p>
<pre><code>formulario-inaccesible.html: 14 problema(s) detectado(s)
 - Salto de encabezados: de h1 a h3
 - Imagen sin atributo alt: logo.png
 - Enlace con texto genérico: «Haz clic aquí»
 - tabindex positivo (3) en <div>: altera el orden natural del teclado
 - <div> con onclick: no es accesible por teclado; usa <button>
 - Falta el idioma de la página (<html lang="es">)
 - Campo <input> sin etiqueta asociada (name=nombre); un placeholder no reemplaza a la etiqueta
 - Contraste insuficiente: #aaaaaa sobre #ffffff = 2.32:1 (mínimo 4,5:1 para texto normal)
 (...)
formulario-accesible.html: 0 problema(s) detectado(s)</code></pre>
<p>Es una ayuda para empezar, no una auditoría: detecta lo que es mecánico, no lo que requiere criterio (si el texto alternativo es útil, si el orden es lógico). Por eso el libro trae una <strong>lista de verificación de 20 criterios</strong> de WCAG 2.1 y 2.2 con cómo probar cada uno a mano, un resumen que calcula el porcentaje de cumplimiento y las prioridades.</p>

<h2>Una prueba de diez minutos</h2>
<ol>
<li><strong>Teclado:</strong> recorre el formulario con Tab y envíalo con Enter. ¿Llegas a todo? ¿Ves el foco?</li>
<li><strong>Zoom:</strong> amplía al 200 % y al 400 %. ¿Se pierde contenido o aparece desplazamiento horizontal?</li>
<li><strong>Etiquetas:</strong> haz clic en cada etiqueta. ¿Se enfoca el campo?</li>
<li><strong>Errores:</strong> envía vacío. ¿Los mensajes dicen qué falló, en texto?</li>
<li><strong>Contraste:</strong> mide los colores de texto y botones.</li>
<li><strong>Lector de pantalla:</strong> si puedes, prueba con NVDA (gratuito, para Windows) o con VoiceOver en Mac y iPhone.</li>
</ol>
<p>Y, mejor aún, pide a una persona con discapacidad que use tu formulario: aprenderás más en cinco minutos que con cualquier herramienta.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la accesibilidad pasó de ser una buena práctica a una exigencia legal en muchos países (Europa, EE. UU., Canadá y otros), y los problemas más frecuentes son los mismos en todas partes, como muestra el estudio. En Colombia y Latinoamérica, las páginas de colegios, secretarías y pymes suelen hacerse con plantillas y complementos que se instalan sin revisar, y las inscripciones y trámites se mueven cada vez más a formularios en línea, a menudo desde el celular. Para los <strong>directivos</strong>, la accesibilidad es parte de la calidad del servicio y de la inclusión; para los <strong>docentes</strong>, también lo es en el material digital que comparten (documentos, presentaciones, videos con subtítulos); y para las <strong>familias</strong>, significa poder inscribir, pagar y consultar notas sin depender de otra persona. Es coherente con el enfoque de ajustes razonables y diseño universal que se aplica en el aula (ver <a href="/herramientas/piar/">PIAR con IA</a>).</p>

<h2>Herramientas que ayudan a trabajar con inclusión</h2>
<p>En el aula, el <a href="/herramientas/piar/">PIAR con IA</a> ayuda a documentar los ajustes razonables de cada estudiante, con borradores que valida el equipo de expertos. Y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> permite producir versiones de una evaluación para que el docente las adapte.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: los primeros 60 minutos</a>, <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">integraciones que fallan en silencio</a> y <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA para colegios</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es WCAG?</h3>
<p>Son las Pautas de Accesibilidad para el Contenido Web del W3C: criterios para que el contenido web sea perceptible, operable, comprensible y robusto. Tienen niveles A, AA y AAA; el nivel AA es el que suele exigirse.</p>
<h3>¿Un colegio privado está obligado a cumplir la accesibilidad web?</h3>
<p>La Resolución 1519 de 2020 obliga principalmente a entidades públicas; un colegio privado puede no estar obligado por ella, pero la accesibilidad es una buena práctica y puede serle exigible por otras normas de inclusión. Consulta con un asesor jurídico.</p>
<h3>¿Por qué no basta con un placeholder en los campos?</h3>
<p>Porque desaparece al escribir, suele tener poco contraste y muchos lectores de pantalla no lo anuncian como etiqueta. Hace falta una etiqueta visible y asociada al campo.</p>
<h3>¿Qué contraste debo usar?</h3>
<p>Al menos 4,5:1 para texto normal y 3:1 para texto grande, según WCAG nivel AA. Puedes medirlo con un verificador o con el script del libro.</p>
<h3>¿Me sirve una herramienta automática?</h3>
<p>Sirve para empezar, pero solo detecta una parte de los problemas. Completa con pruebas con el teclado, zoom y, si es posible, un lector de pantalla y personas usuarias reales.</p>

<p class="notice"><strong>Esta semana:</strong> prueba tu formulario más importante con el teclado y mide el contraste de sus textos. Descarga la <a href="/descargas/accesibilidad-web/lista-accesibilidad-web.xlsx">lista de verificación</a> y ejecuta el <a href="/descargas/accesibilidad-web/revisar_accesibilidad_basica.py">script</a> sobre tu HTML (también están los dos <a href="/descargas/accesibilidad-web/formulario-inaccesible.html">formularios</a> <a href="/descargas/accesibilidad-web/formulario-accesible.html">de ejemplo</a>).</p>

<h2>Para pensar</h2>
<p>La accesibilidad suele tratarse como un costo extra que se deja «para después». <strong>¿Es la inaccesibilidad de un servicio educativo una forma de discriminación aunque nadie la haya querido? Y si una institución recibe a todos pero su formulario de inscripción solo funciona para quien ve, usa ratón y tiene buena conexión, ¿a quién estamos eligiendo sin darnos cuenta?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:webaim}}' => $img('accesibilidad-web-webaim', 573, 'Cuatro tarjetas con los fallos más frecuentes según WebAIM Million 2025: 79,1 % de las páginas con contraste bajo, 55,5 % con imágenes sin texto alternativo, 48,2 % con campos sin etiqueta y 45,4 % con enlaces vacíos.', 'Los fallos que más se repiten en la web.'),
    '{{img:contraste}}' => $img('accesibilidad-web-contraste', 499, 'Tabla con contrastes calculados sobre fondo blanco: negro 21 a 1, gris 767676 4,54 a 1 que cumple por poco, gris 777777 4,48 a 1 que no cumple y gris AAAAAA 2,32 a 1 que no cumple.', 'Contraste de varios grises sobre fondo blanco.'),
]);

return [
    'slug' => 'accesibilidad-web-formularios-contraste-teclado-checklist-colegios-pymes',
    'title' => 'Accesibilidad web: formularios, contraste y teclado que todas las personas puedan usar (checklist para colegios y pymes)',
    'excerpt' => 'Los tres frentes que más fallan en la accesibilidad web (formularios, contraste y teclado), con datos de WebAIM Million 2025, el marco colombiano, código de un ejemplo malo y uno bueno, un script en Python y una lista de verificación en Excel.',
    'seo_title' => 'Accesibilidad web: formularios, contraste y teclado',
    'seo_description' => 'Cómo hacer accesibles tus formularios y páginas: etiquetas, contraste 4,5:1 y teclado, con datos de WebAIM, script en Python y lista de verificación.',
    'focus_keyword' => 'accesibilidad web formularios',
    'cover' => '/assets/img/articulos/accesibilidad-web/accesibilidad-web-portada',
    'cover_alt' => 'Portada «Accesibilidad web: formularios, contraste y teclado que todas las personas puedan usar» con una lista: cada campo con su etiqueta, uso solo con teclado y contraste de 4,5:1, marcados; un placeholder como etiqueta, descartado.',
    'published_at' => '2026-12-01 12:00:00',
    'content_html' => $html,
];
