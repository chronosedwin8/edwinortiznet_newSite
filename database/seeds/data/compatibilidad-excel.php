<?php

declare(strict_types=1);

// "Compatibilidad de libros de Excel entre equipos". Pruebas en Microsoft Excel 16 (es-CO): VALOR("1,5") da 1,5 con separadores de Colombia y #¡VALOR! con los de EE. UU. Revisor en Python probado sobre libros del sitio (detectó rutas absolutas en tres libros, ya limpiadas). Versiones mínimas de funciones aproximadas: confirmar en Microsoft. Verificado el 10 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/compatibilidad-excel/' . $name;
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
<p>"Te mando el archivo." Y al día siguiente: "No me abre.", "Me sale #¿NOMBRE? en todas partes.", "Los totales no coinciden con los tuyos.", "Me pide actualizar vínculos que no sé qué son". Un libro de Excel que funciona perfecto en tu computador puede fallar en el de un colega, una secretaría o un cliente. No porque Excel sea mal, sino porque <strong>un libro depende de cosas que no viajan con el archivo</strong>: la versión de Excel, la configuración regional, otros archivos, complementos y hasta el nombre de tu carpeta.</p>
<p>Este artículo explica las causas más frecuentes de incompatibilidad, con pruebas hechas en Microsoft Excel 16, un <a href="/descargas/compatibilidad-excel/revisar_compatibilidad_xlsx.py">revisor de libros en Python</a> que lee el archivo sin abrir Excel y una <a href="/descargas/compatibilidad-excel/lista-compatibilidad-excel.xlsx">lista de verificación en Excel</a>. Verificado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Antes de enviar un libro, revisa cuatro cosas: <strong>las funciones recientes</strong> que usa (dan #¿NOMBRE? en versiones antiguas), <strong>la configuración regional</strong> (un texto "1,5" da un número en Colombia y un error con la configuración de EE. UU., lo probé), <strong>los vínculos y macros</strong> y <strong>los metadatos</strong> (autor, ruta de tu carpeta, hojas ocultas). Y, sobre todo, <strong>pruébalo en otro equipo</strong> o en Excel para la Web.</p>

<h2>Causa 1: funciones recientes</h2>
<p>Excel suma funciones con cada versión. Las más usadas hoy (<code>XLOOKUP</code>/<code>BUSCARX</code>, <code>FILTER</code>/<code>FILTRAR</code>, <code>UNIQUE</code>/<code>UNICOS</code>, <code>SORT</code>/<code>ORDENAR</code>, <code>LET</code>) pertenecen a Excel 2021 y a Microsoft 365; en versiones anteriores el libro abre, pero esas celdas muestran #¿NOMBRE? y todo lo que dependa de ellas se rompe. Un grupo intermedio (<code>IFS</code>, <code>SWITCH</code>, <code>CONCAT</code>, <code>TEXTJOIN</code>, <code>MAXIFS</code>) llegó con Excel 2019; las de pronóstico (<code>FORECAST.ETS</code>) con Excel 2016. Las funciones antiguas (<code>BUSCARV</code>, <code>SUMAR.SI.CONJUNTO</code>, <code>SI.ERROR</code>) funcionan en casi todas partes. La hoja "Funciones_por_version" del libro trae una tabla con una alternativa universal para cada una; son versiones mínimas aproximadas, así que <strong>confirma siempre en la página de soporte de Microsoft de cada función</strong> y en la versión del destino.</p>
<p>¿Cómo saber cuáles usa tu libro? Un archivo .xlsx es un ZIP de XML, y las funciones recientes se guardan con el prefijo <code>_xlfn.</code> (por ejemplo, <code>_xlfn.XLOOKUP</code>). El revisor las cuenta leyendo el archivo.</p>

<h2>Causa 2: la configuración regional</h2>
<p>Esta es la más traicionera, porque el libro "funciona" y da resultados distintos. En Colombia usamos coma decimal y punto de miles (1.234,5); en EE. UU., lo contrario (1,234.5); los separadores de argumentos de las fórmulas (<code>;</code> o <code>,</code>) y hasta los nombres de las funciones cambian con el idioma. Los libros guardan las fórmulas en una forma universal, así que eso suele resolverse solo; el problema son los <strong>datos guardados como texto</strong>.</p>
<p>Lo probé en Excel cambiando a propósito los separadores. Una celda con el texto <code>1,5</code> y la fórmula <code>=VALOR(A3)</code>:</p>
<table>
<thead><tr><th>Configuración</th><th>VALOR("1,5")</th><th>VALOR("1.234,5")</th><th>VALOR("1,234.5")</th></tr></thead>
<tbody>
<tr><td><strong>Colombia (coma decimal)</strong></td><td>1,5</td><td>1234,5</td><td>1234,5</td></tr>
<tr><td><strong>EE. UU. (punto decimal, coma de miles)</strong></td><td>#¡VALOR!</td><td>#¡VALOR!</td><td>1234.5</td></tr>
</tbody>
</table>
<p>Es decir: el mismo texto da un número en un equipo y un error en otro. La hoja "Prueba_1_5" del libro lo reproduce. La defensa: <strong>guarda los números como números y las fechas como fechas reales</strong> (con formato), no como texto, y evita convertirlos con funciones que dependen de la región. Con las fechas ocurre igual: "03/04/2026" es el 3 de abril en Colombia y el 4 de marzo en EE. UU.; usa el formato <code>aaaa-mm-dd</code>, que no es ambiguo. Con los archivos CSV, el separador también cambia (ver <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importar CSV correctamente</a>).</p>

<h2>Causa 3: vínculos, conexiones y macros</h2>
<ul>
<li><strong>Vínculos a otros libros</strong> guardan una ruta; si el otro archivo no está en la misma ruta en el equipo del destinatario, Excel pide actualizar y muestra valores viejos o errores. Si necesitas los valores, pégalos como valores antes de enviar.</li>
<li><strong>Conexiones de datos</strong> (a bases, a otros libros o a la web) dependen de permisos y de drivers que el destino puede no tener.</li>
<li><strong>Macros (.xlsm)</strong>: muchos equipos las bloquean por seguridad, y Excel para la Web no las ejecuta; en Mac hay diferencias. Si el libro funciona sin macros, envíalo sin ellas.</li>
<li><strong>Complementos y fuentes</strong> que solo existen en tu equipo cambian el aspecto o rompen funciones.</li>
</ul>

<h2>Causa 4: metadatos y datos que viajan sin que lo notes</h2>
<p>Un libro lleva más de lo que ves: el autor y el último usuario que lo guardó, a veces la <strong>ruta de tu carpeta</strong>, hojas ocultas, comentarios y versiones. Mi propia experiencia: al pasar el revisor por los libros descargables de este sitio, detecté que <strong>tres de ellos (los que guardé desde Excel) llevaban la ruta de mi carpeta de trabajo</strong> en el archivo. No era grave, pero revelaba mi usuario y la estructura de mis carpetas. Los limpié. Es el tipo de cosa que solo se ve si la buscas. En Excel, <em>Archivo, Información, Comprobar si hay problemas, Inspeccionar documento</em> ayuda a quitar este tipo de datos (y las hojas o columnas ocultas con información que no quieres compartir).</p>

<h2>El revisor en Python, con resultados reales</h2>
<p>El revisor (unas 70 líneas, solo biblioteca estándar) lee el archivo y reporta: funciones recientes, vínculos, conexiones, macros, hojas ocultas, rutas y el autor. Lo ejecuté sobre libros de este sitio:</p>
{{img:revisor}}
<pre><code>listas-desplegables-dependientes.xlsx
  funciones recientes: ANCHORARRAY (3), FILTER (2), SORT (2), UNICHAR (6), UNIQUE (2)
  vínculos a otros libros: 0 | conexiones de datos: no | macros: no
  hojas ocultas: ninguna | referencias a rutas absolutas: 0
  autor y último en guardar: openpyxl, EDWIN ORTIZ
  ! Usa funciones recientes: en versiones antiguas darán #¿NOMBRE?; confirma la versión mínima de cada una

tablero-cartera-colegio.xlsx
  funciones recientes: ninguna
  vínculos a otros libros: 0 | conexiones de datos: no | macros: no
  Sin señales de incompatibilidad en esta revisión.</code></pre>
<p>Observa lo que encontró: los libros que usan <code>FILTER</code>, <code>SORT</code>, <code>UNIQUE</code> o <code>XLOOKUP</code> avisan que requieren Excel 2021 o Microsoft 365 (y yo lo digo en cada uno, en sus artículos); los de pronóstico, Excel 2016 o posterior; y el tablero de cartera, que usa funciones clásicas, no da señales de riesgo. Fíjate también en las funciones "<code>ANCHORARRAY</code>" y "<code>UNICHAR</code>": la primera es el operador <code>#</code> de los derrames (en la validación de datos de las listas dependientes) y la segunda es una función de texto reciente; el revisor las cuenta igual. Es una ayuda para mirar, no un veredicto: <strong>no sustituye al Comprobador de compatibilidad de Excel ni probar el archivo en el destino</strong>.</p>

<h2>La lista "antes de enviar"</h2>
{{img:causas}}
<p>La hoja "Antes_de_enviar" tiene trece preguntas, cada una con su respuesta segura: ¿sabes qué versión y sistema usará quien lo reciba?, ¿revisaste las funciones recientes?, ¿hay vínculos que se romperán?, ¿hay macros?, ¿hay datos como texto que dependen de la región?, ¿hay hojas ocultas?, ¿quitaste los metadatos?, ¿lo probaste en otro equipo o en Excel para la Web?, ¿enviaste un PDF para lo que solo debe leerse?, ¿hay una hoja "Léeme" con instrucciones? El libro cuenta los puntos por resolver: con todo en "No", marca 8 puntos y dice "Hay riesgos de compatibilidad o privacidad: revisa antes de enviar"; con todo resuelto, dice "Listo para enviar (aun así, pruébalo en el destino)".</p>

<h2>Reglas prácticas</h2>
<ol>
<li><strong>Pregunta primero</strong> qué versión de Excel y qué sistema (Windows, Mac, Web, celular) usará el destinatario.</li>
<li><strong>Para solo leer, envía un PDF.</strong> Para editar, un .xlsx limpio.</li>
<li><strong>Evita las funciones recientes</strong> si no estás seguro del destino, o ofrece una versión con alternativas universales (ver <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL!, #CALC! y #VALUE!</a>).</li>
<li><strong>Convierte vínculos en valores</strong> y evita rutas absolutas.</li>
<li><strong>Guarda números y fechas como lo que son</strong> y documenta los supuestos en una hoja "Léeme".</li>
<li><strong>Inspecciona el documento</strong> antes de enviarlo.</li>
<li><strong>Pruébalo en otro equipo</strong> o en Excel para la Web (gratuito con una cuenta de Microsoft).</li>
<li><strong>Si compartes con muchas personas y editan a la vez,</strong> considera un libro en la nube o, si crece, una base de datos (ver <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">las siete señales</a>).</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En todo el mundo, los libros de Excel circulan por correo y mensajería entre equipos con versiones y configuraciones distintas. En Colombia y Latinoamérica el problema se agrava por dos razones: la mezcla de versiones (muchas oficinas y colegios conservan Excel 2016 o 2019 junto a Microsoft 365) y el hecho de que el castellano de las fórmulas y los separadores nos diferencia de los tutoriales en inglés. Para los <strong>docentes y secretarías</strong> que comparten listados, para las <strong>pymes</strong> que envían cotizaciones y para <strong>quienes enseñan Excel</strong>, la regla es la misma: probar donde se va a usar. Y para las <strong>familias</strong>, que reciben libros o listados de un colegio, que un archivo abra bien en un teléfono es parte del acceso (ver <a href="/accesibilidad-web-formularios-contraste-teclado-checklist-colegios-pymes/">accesibilidad</a>).</p>

<h2>Plantillas ya probadas</h2>
<p>Si prefieres plantillas hechas con funciones clásicas, pensadas para funcionar en la mayoría de equipos, mira estas opciones. Y hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a> para pedir ayuda con tus fórmulas; recuerda verificar la versión mínima de lo que te proponga.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla/">listas desplegables dependientes</a>, <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">pronósticos en Excel</a> y <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">un dashboard que ayude a actuar</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Por qué mi libro muestra #¿NOMBRE? en otro equipo?</h3>
<p>Porque usa una función que esa versión de Excel no tiene (por ejemplo, XLOOKUP o FILTER en Excel 2019 o anterior). Usa una alternativa universal o confirma la versión del destino.</p>
<h3>¿Por qué los números dan distinto en otro país?</h3>
<p>Por la configuración regional: un texto como "1,5" se convierte en número o da error según el separador decimal. Guarda los números como números, no como texto.</p>
<h3>¿Cómo quito mis datos personales de un libro?</h3>
<p>Con Archivo, Información, Comprobar si hay problemas, Inspeccionar documento; y revisa las hojas ocultas. El revisor del libro muestra el autor y la ruta guardada.</p>
<h3>¿Funcionan las macros en Excel para la Web?</h3>
<p>No se ejecutan los macros de VBA en Excel para la Web; en Mac hay diferencias. Si el libro depende de macros, avisa al destinatario o busca una alternativa.</p>
<h3>¿Es mejor enviar un PDF?</h3>
<p>Si el destinatario solo necesita leer, sí: se ve igual en todos los equipos y no expone fórmulas ni hojas ocultas.</p>

<p class="notice"><strong>Antes de tu próximo envío.</strong> Pasa tu libro por la <a href="/descargas/compatibilidad-excel/lista-compatibilidad-excel.xlsx">lista de compatibilidad</a> y ejecuta el <a href="/descargas/compatibilidad-excel/revisar_compatibilidad_xlsx.py">revisor</a> (<code>python revisar_compatibilidad_xlsx.py tu_libro.xlsx</code>). Y pruébalo en otro equipo.</p>

<h2>Para pensar</h2>
<p>Enviar un libro de Excel es entregar una pequeña máquina que supone un entorno que no controlamos. <strong>¿Quién debe asegurarse de que un archivo funcione en el equipo del otro: quien lo envía, quien lo recibe o la institución que debería estandarizar versiones y formatos? Y cuando un libro mal hecho cambia un total sin que nadie lo note, ¿de quién es la responsabilidad?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:revisor}}' => $img('compatibilidad-excel-revisor', 499, 'Tabla con cinco libros de ejemplo revisados con el script: las listas dependientes y los errores de Excel requieren Excel 2021 o 365, los pronósticos Excel 2016 o posterior y el tablero de cartera no tiene señales de riesgo.', 'Cinco libros de ejemplo, revisados.'),
    '{{img:causas}}' => $img('compatibilidad-excel-causas', 573, 'Cuatro tarjetas con las causas frecuentes de que un libro falle en otro equipo: funciones recientes, configuración regional, vínculos y macros, y metadatos.', 'Por qué un libro se rompe en otro equipo.'),
]);

return [
    'slug' => 'compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional',
    'title' => 'El libro funciona en tu equipo, ¿y en el de otra persona? Compatibilidad de Excel entre versiones, equipos y configuraciones',
    'excerpt' => 'Las cuatro causas más frecuentes de que un libro de Excel falle en otro equipo (funciones recientes, configuración regional, vínculos y macros, metadatos), con pruebas en Excel, un revisor en Python y una lista de verificación descargable.',
    'seo_title' => 'Compatibilidad de Excel entre equipos: qué revisar',
    'seo_description' => 'Por qué un libro de Excel falla en otro equipo y qué revisar antes de enviarlo: funciones recientes, configuración regional, vínculos, macros y metadatos.',
    'focus_keyword' => 'compatibilidad de Excel entre equipos',
    'cover' => '/assets/img/articulos/compatibilidad-excel/compatibilidad-excel-portada',
    'cover_alt' => 'Portada "El libro funciona en tu equipo, pero ¿en el de otra persona? Compatibilidad en Excel" con una tarjeta: el texto 1,5 da un número con la configuración de Colombia y #¡VALOR! con la de EE. UU.',
    'published_at' => '2026-12-17 12:00:00',
    'content_html' => $html,
];
