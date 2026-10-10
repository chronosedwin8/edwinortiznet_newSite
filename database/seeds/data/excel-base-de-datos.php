<?php

declare(strict_types=1);

// «¿Cuándo Excel deja de ser la solución? Siete señales de que necesitas una base de datos». Fuentes verificadas el 9 de octubre de 2026: especificaciones y límites de Excel y de Access (Microsoft), Ley 1581 de 2012. Ejemplo SQL probado con SQLite; libro de autoevaluación con datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/excel-base-de-datos/' . $name;
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
<p>Excel es, probablemente, la herramienta de datos más usada del mundo, y con razón: es flexible, familiar y resuelve muchísimas necesidades sin programar. Pero hay un momento en que un libro de Excel deja de ser una hoja de cálculo y se convierte, sin que nadie lo decida, en el <strong>sistema de información</strong> de una oficina o de un colegio: ahí viven los clientes, las matrículas, los inventarios. Y ese sistema improvisado empieza a fallar de maneras previsibles.</p>
<p>Este artículo no dice que Excel sea malo: dice <strong>cuándo se queda corto</strong>, con siete señales concretas, un ejemplo con código SQL probado, una comparación y un <a href="/descargas/excel-base-de-datos/siete-senales-excel-base-de-datos.xlsx">libro de autoevaluación y migración descargable</a>. Datos técnicos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Los límites técnicos de Excel (más de un millón de filas por hoja) rara vez son el problema real; los problemas reales son <strong>la edición simultánea, los datos repetidos que no coinciden, la falta de permisos y de auditoría, la integridad y la integración con otras aplicaciones</strong>. Si reconoces cuatro o más señales, conviene planear una migración; con una o dos, a menudo basta reforzar controles.</p>

<h2>Lo que Excel hace muy bien</h2>
<p>Antes de migrar, reconozcamos sus fortalezas: análisis rápido, cálculos, gráficos, prototipos, informes y modelos de «qué pasaría si». Para una persona o un equipo pequeño con turnos claros y datos que no son sensibles, Excel es una solución excelente. El error no es usar Excel: es <strong>seguir usándolo como base de datos cuando el proceso ya exige otra cosa</strong>.</p>
<p>Los límites técnicos existen, pero suelen estar lejos. Según las especificaciones oficiales de Microsoft, una hoja admite <strong>1.048.576 filas y 16.384 columnas</strong>, y una celda puede contener hasta <strong>32.767 caracteres</strong>; una base de datos de Access está limitada a <strong>2 GB</strong> (incluidos todos sus objetos). Casi nadie choca con las filas antes de chocar con las siete señales siguientes.</p>
{{img:limites}}

<h2>Las siete señales</h2>
<ol>
<li><strong>Varias personas editan a la vez y se pisan.</strong> Aparecen archivos «final», «final_v2» y «final_definitivo». Excel permite coautoría en archivos guardados en la nube de Microsoft, pero no ofrece las reglas, los bloqueos por registro y la trazabilidad de una base de datos.</li>
<li><strong>El mismo dato está escrito de varias formas.</strong> «Ferretería El Tornillo», «Ferreteria El Tornillo» y «FERRETERÍA EL TORNILLO» son para Excel tres clientes distintos (más abajo, el ejemplo).</li>
<li><strong>Necesitas permisos por persona o auditoría.</strong> Que el docente de quinto vea solo sus estudiantes, o saber quién cambió una nota y cuándo, es difícil de lograr en un libro compartido.</li>
<li><strong>El archivo es lento, pesado o frágil.</strong> Tarda minutos en abrir, se cuelga o ya se acerca a cientos de miles de filas con fórmulas pesadas.</li>
<li><strong>Necesitas impedir datos incoherentes.</strong> Pedidos de clientes que no existen, códigos duplicados, fechas imposibles. Una base de datos puede rechazarlos por regla; Excel solo avisa si alguien configuró la validación y nadie la borra.</li>
<li><strong>Otras aplicaciones necesitan los datos.</strong> Si alguien copia y pega cada semana del libro a la facturación, a la página web o al correo masivo, ya tienes un proceso que pide una fuente central y automática.</li>
<li><strong>Manejas datos personales o sensibles.</strong> Un archivo que viaja por correo, con copias en cada computador, es difícil de proteger y auditar. La Ley 1581 de 2012 exige al responsable del tratamiento medidas de seguridad sobre los datos personales (ver <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">datos de estudiantes</a>). Por eso un documento como el PIAR de un estudiante no debería vivir en una hoja que circula: <a href="/herramientas/piar/">PIAR con IA</a> lo guarda en una cuenta con acceso controlado.</li>
</ol>

<h2>Un ejemplo con código: dos clientes que parecen cinco</h2>
<p>Un pequeño negocio registra seis pedidos en una hoja. Dos clientes reales, pero escritos con y sin tilde y en mayúsculas. Excel, al contar clientes distintos o resumir con una tabla dinámica, los trata como clientes diferentes. Lo mismo ocurre en SQL si se agrupa sobre texto libre. Lo comprobé con SQLite:</p>
<pre><code>-- Archivo plano: cliente como texto libre
SELECT cliente, COUNT(*) AS pedidos, SUM(valor) AS total
FROM pedidos_plano GROUP BY cliente;
-- Resultado: 5 «clientes» (Ferretería, Ferreteria, FERRETERÍA, Papelería, Papeleria)
-- Cada uno con 1 o 2 pedidos y totales parciales.</code></pre>
<p>La solución no es más disciplina al digitar (nadie escribe siempre igual) sino <strong>modelar los datos</strong>: una tabla de clientes con un código único y una tabla de pedidos que apunta a ese código.</p>
<pre><code>CREATE TABLE clientes(
  id INTEGER PRIMARY KEY,
  nombre TEXT UNIQUE,
  ciudad TEXT);

CREATE TABLE pedidos(
  pedido INTEGER PRIMARY KEY,
  fecha TEXT,
  cliente_id INT REFERENCES clientes(id),
  producto TEXT, cantidad INT, valor INT);

SELECT c.nombre, COUNT(*) AS pedidos, SUM(p.valor) AS total
FROM pedidos p JOIN clientes c ON c.id = p.cliente_id
GROUP BY c.nombre;
-- Ferretería El Tornillo | 3 | 570000
-- Papelería Central      | 3 | 350000</code></pre>
<p>Ahora los totales son correctos y, con las claves foráneas activadas, la base <strong>rechaza</strong> un pedido de un cliente que no existe («FOREIGN KEY constraint failed») y un cliente repetido («UNIQUE constraint failed»), cosa que probé también. El libro descargable trae este mismo caso con las dos formas: el archivo plano (donde una fórmula cuenta 4 «clientes» distintos, porque Excel ignora mayúsculas pero no tildes) y el modelo normalizado.</p>

<h2>Excel, base de datos o aplicación web</h2>
<p>No es una elección entre bueno y malo, sino entre necesidades:</p>
{{img:decision}}
<table>
<thead><tr><th>Opción</th><th>Fortaleza</th><th>Limitación</th><th>Cuándo elegirla</th></tr></thead>
<tbody>
<tr><td><strong>Excel</strong></td><td>Flexible, rápido de armar, ideal para análisis</td><td>Edición simultánea limitada, sin reglas de integridad ni permisos finos</td><td>Un equipo pequeño, datos no sensibles, informes y modelos</td></tr>
<tr><td><strong>Base de datos (Access, SQLite, PostgreSQL, SQL Server…)</strong></td><td>Integridad, consultas, permisos, respaldo, volumen</td><td>Requiere diseñar el modelo y alguien que la administre</td><td>Varios usuarios, datos relacionados, reglas de negocio</td></tr>
<tr><td><strong>Aplicación web sobre una base</strong></td><td>Formularios, acceso desde cualquier lugar, roles</td><td>Mayor costo de desarrollo y mantenimiento</td><td>Muchos usuarios externos o procesos críticos (ver <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribir o desarrollar</a>)</td></tr>
</tbody>
</table>
<p>Y no es o lo uno o lo otro: lo más sensato suele ser <strong>la base de datos guarda y Excel analiza</strong>. Con Power Query puedes conectar Excel a una base y analizarla con tablas dinámicas, sin copiar y pegar (ver <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">Power Query, VBA, Office Scripts y Python</a>).</p>

<h2>Cómo migrar sin perder información</h2>
<ol>
<li><strong>Respalda y congela</strong> el archivo actual con fecha (ver <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">la nube no es un respaldo</a>).</li>
<li><strong>Define el responsable</strong> de los datos y quién puede ver o cambiar qué.</li>
<li><strong>Identifica las entidades</strong> (clientes, productos, pedidos) y la llave única de cada una.</li>
<li><strong>Limpia</strong> duplicados y variantes antes de importar (ver <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importar CSV correctamente</a>).</li>
<li><strong>Importa en un entorno de prueba</strong> y compara los totales con el archivo original; deben coincidir.</li>
<li><strong>Decide cómo se capturarán los datos nuevos</strong> y capacita a los usuarios.</li>
<li><strong>Mantén el archivo antiguo en solo lectura</strong> un tiempo y mide los resultados.</li>
</ol>
<p>La hoja «Checklist_migracion» del libro descargable trae estos pasos con casillas.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En todo el mundo, las pymes y las instituciones educativas empiezan en Excel porque ya lo tienen y porque funciona. En Colombia y Latinoamérica pesa además el costo: pasar a un sistema con servidor, licencias o desarrollo puede parecer un lujo, y por eso es tan importante comparar antes (ver <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a>). Para los <strong>docentes y coordinadores</strong>, la señal más común es el mismo listado de estudiantes en cinco archivos; para los <strong>directivos</strong>, el riesgo de un dato sensible en un archivo sin control; para las <strong>familias</strong>, que los datos de sus hijos no circulen por correo en hojas sin protección.</p>

<h2>Herramientas para ordenar tus datos en Excel</h2>
<p>Si todavía no necesitas una base de datos, estas plantillas te ayudan a mantener los datos ordenados y con controles:</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>También hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a> para trabajar mejor tus datos.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuántas filas aguanta Excel?</h3>
<p>Según Microsoft, una hoja admite 1.048.576 filas y 16.384 columnas. En la práctica, el archivo se vuelve lento o inmanejable mucho antes, sobre todo con fórmulas pesadas.</p>
<h3>¿Cuándo debo pasar de Excel a una base de datos?</h3>
<p>Cuando varias personas editan a la vez, el mismo dato aparece repetido y distinto, necesitas permisos o auditoría, o otras aplicaciones requieren los datos. Con cuatro o más señales, conviene planear la migración.</p>
<h3>¿Access sirve o ya está obsoleto?</h3>
<p>Sirve para equipos pequeños en Windows, con el límite de 2 GB por base. Para más usuarios o acceso web, suelen elegirse otras bases (PostgreSQL, SQL Server o MySQL).</p>
<h3>¿Puedo seguir usando Excel después de migrar?</h3>
<p>Sí, y es lo recomendable: la base guarda los datos y Excel los consulta y analiza con Power Query y tablas dinámicas.</p>
<h3>¿Es necesario saber programar?</h3>
<p>Para el modelo básico, bastan unas pocas sentencias SQL como las del ejemplo, y hay herramientas visuales. Para una aplicación completa conviene apoyo técnico.</p>

<p class="notice"><strong>Haz la autoevaluación hoy.</strong> Descarga el <a href="/descargas/excel-base-de-datos/siete-senales-excel-base-de-datos.xlsx">libro de siete señales</a>, marca cuáles te ocurren y mira qué recomienda. Incluye el ejemplo de datos y la lista de migración.</p>

<h2>Para pensar</h2>
<p>Muchas organizaciones nunca decidieron que su información viviera en Excel: simplemente pasó. <strong>¿Es la comodidad de Excel un mérito de la herramienta o una trampa que nos impide ordenar nuestros procesos? Y si el dato más valioso de la institución (sus estudiantes, sus clientes) vive en un archivo que cualquiera puede copiar, ¿quién es responsable de que no se pierda, se altere o se filtre?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:limites}}' => $img('excel-base-de-datos-limites', 573, 'Cuatro tarjetas con los límites oficiales: 1.048.576 filas y 16.384 columnas por hoja de Excel, 32.767 caracteres por celda y 2 GB para una base de datos de Access.', 'Los límites técnicos que sí existen.'),
    '{{img:decision}}' => $img('excel-base-de-datos-decision', 499, 'Tabla que compara cuándo basta Excel y cuándo conviene una base de datos según usuarios, integridad, seguridad e integración.', '¿Excel o base de datos?'),
]);

return [
    'slug' => 'cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos',
    'title' => '¿Cuándo Excel deja de ser la solución? Siete señales de que necesitas una base de datos',
    'excerpt' => 'Siete señales concretas de que tu archivo de Excel se quedó corto, un ejemplo con código SQL probado, una comparación entre Excel, base de datos y aplicación web, y un libro descargable de autoevaluación y migración.',
    'seo_title' => 'Excel o base de datos: siete señales para migrar',
    'seo_description' => 'Siete señales de que Excel se quedó corto y necesitas una base de datos, con ejemplo en SQL, comparación y un libro descargable para decidir y migrar.',
    'focus_keyword' => 'cuándo usar una base de datos en lugar de Excel',
    'cover' => '/assets/img/articulos/excel-base-de-datos/excel-base-de-datos-portada',
    'cover_alt' => 'Portada «¿Cuándo Excel deja de ser la solución? Siete señales de que necesitas una base de datos» con una tarjeta de cuatro señales: edición simultánea, datos escritos de varias formas, permisos por persona y otras aplicaciones que necesitan los datos.',
    'published_at' => '2026-11-12 12:00:00',
    'content_html' => $html,
];
