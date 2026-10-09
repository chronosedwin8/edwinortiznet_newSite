<?php

declare(strict_types=1);

// «¿Comprar software, pagar una suscripción o desarrollar una aplicación propia?» Fuentes verificadas el 9 de octubre de 2026: Ley 1581 de 2012 art. 26 y Circular Única SIC, IVA de servicios digitales desde el exterior (Estatuto Tributario), Ley 603 de 2000. Cifras del caso: modelo propio con supuestos ilustrativos (matriz descargable).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/tco-comprar-suscribir-desarrollar/' . $name;
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
<p>Cuando una empresa, un colegio o una oficina necesita una herramienta nueva (facturar, gestionar matrículas, llevar inventarios), casi siempre compara tres cosas: el <strong>precio de la licencia</strong>, la <strong>cuota mensual</strong> o la <strong>cotización del desarrollo</strong>. Rara vez compara lo que de verdad importa: lo que costará esa decisión durante <strong>tres años</strong>. Ahí aparecen el soporte, los servidores, la capacitación, las integraciones, los aumentos de precio y el mantenimiento que nadie presupuestó.</p>
<p>En este artículo comparo las tres rutas con un caso numérico, <strong>con todos los supuestos a la vista</strong>, para que puedas cambiarlos por los tuyos. Incluyo una <a href="/descargas/matriz-costes/matriz-costes-3-anos.xlsx">matriz de costes descargable en Excel</a>. Datos normativos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Ninguna de las tres opciones es la mejor en abstracto. En el ejemplo (12 usuarios), la suscripción y la licencia quedan en un rango parecido y el desarrollo propio cuesta más del doble; pero con unos 40 usuarios el desarrollo propio pasa a ser el más barato. Lo importante es que <strong>el punto de equilibrio depende de tus cifras</strong>, y que el costo no es el único criterio: también cuentan la dependencia del proveedor, la seguridad y la capacidad de mantener lo que se construye.</p>

<h2>Las tres rutas y sus costos ocultos</h2>
<ul>
<li><strong>Comprar una licencia</strong> (pago único, uso perpetuo): pagas casi todo al inicio, pero luego vienen el soporte y las actualizaciones (suelen cobrarse como un porcentaje anual de la licencia), el servidor o equipo donde corre, los respaldos y quien lo administre.</li>
<li><strong>Pagar una suscripción</strong> (SaaS): el pago inicial es bajo y el proveedor se encarga de servidores y actualizaciones; a cambio, pagas siempre, el precio puede subir y si dejas de pagar pierdes el acceso. Cuando el proveedor está en el exterior, el pago suele hacerse en dólares y hay que mirar el IVA y la protección de datos (más abajo).</li>
<li><strong>Desarrollar una aplicación propia</strong>: haces exactamente lo que necesitas y los datos y el código son tuyos, pero asumes el desarrollo, el hosting, la seguridad, el soporte y un mantenimiento que no termina. El costo de construir es solo el comienzo.</li>
</ul>

<h2>El caso: 12 usuarios durante 3 años</h2>
<p>Supongamos una organización con 12 usuarios. Estos son los supuestos, todos <strong>ilustrativos</strong> (no son precios de ninguna marca real) y editables en la matriz:</p>
<table>
<thead><tr><th>Concepto</th><th>Comprar</th><th>Suscripción</th><th>Desarrollar</th></tr></thead>
<tbody>
<tr><td><strong>Precio base</strong></td><td>US$ 500 por usuario</td><td>US$ 25 por usuario y mes</td><td>US$ 18.000 de construcción</td></tr>
<tr><td><strong>Recurrente</strong></td><td>Soporte: 20 % de la licencia al año</td><td>Alza anual del 7 %</td><td>Mantenimiento: 20 % del desarrollo desde el año 2</td></tr>
<tr><td><strong>Otros costos</strong></td><td>Implementación, capacitación, servidor y seguridad</td><td>Implementación, capacitación, integraciones y administración</td><td>Hosting, seguridad, soporte y capacitación</td></tr>
</tbody>
</table>
<p>Con esos supuestos, el costo total a tres años queda así:</p>
<table>
<thead><tr><th>Opción</th><th>Año 1</th><th>Año 2</th><th>Año 3</th><th>Total 3 años</th></tr></thead>
<tbody>
<tr><td><strong>Comprar licencia</strong></td><td>US$ 11.100</td><td>US$ 2.100</td><td>US$ 2.100</td><td>US$ 15.300</td></tr>
<tr><td><strong>Suscripción</strong></td><td>US$ 5.700</td><td>US$ 4.152</td><td>US$ 4.422</td><td>US$ 14.274</td></tr>
<tr><td><strong>Desarrollo propio</strong></td><td>US$ 22.180</td><td>US$ 7.180</td><td>US$ 7.180</td><td>US$ 36.540</td></tr>
</tbody>
</table>
{{img:total}}
<p>Observa tres cosas. Primero, <strong>la licencia «barata a la larga» no lo es tanto</strong>: el 73 % de su costo cae en el primer año, y los años 2 y 3 siguen costando por soporte, servidor y administración. Segundo, <strong>la suscripción parece cara mes a mes</strong> (US$ 300 mensuales en el año 1), pero evita el golpe inicial. Tercero, <strong>el desarrollo propio es el más caro con pocos usuarios</strong>, porque su costo es casi fijo.</p>

<h2>Cuando cambian los usuarios, cambia la respuesta</h2>
<p>Sensibilidad con los mismos supuestos y solo el número de usuarios variando (calculada en la hoja «Sensibilidad» de la matriz):</p>
<table>
<thead><tr><th>Usuarios</th><th>Comprar</th><th>Suscripción</th><th>Desarrollar</th><th>Más barata</th></tr></thead>
<tbody>
<tr><td>5</td><td>US$ 9.700</td><td>US$ 7.522</td><td>US$ 36.540</td><td>Suscripción</td></tr>
<tr><td>15</td><td>US$ 17.700</td><td>US$ 17.167</td><td>US$ 36.540</td><td>Suscripción</td></tr>
<tr><td>25</td><td>US$ 25.700</td><td>US$ 26.812</td><td>US$ 36.540</td><td>Comprar</td></tr>
<tr><td>40</td><td>US$ 37.700</td><td>US$ 41.279</td><td>US$ 36.540</td><td>Desarrollar</td></tr>
<tr><td>60</td><td>US$ 53.700</td><td>US$ 60.568</td><td>US$ 36.540</td><td>Desarrollar</td></tr>
</tbody>
</table>
<p>Los puntos de equilibrio, con estos supuestos: la licencia supera a la suscripción a partir de unos <strong>19 usuarios</strong>, y el desarrollo propio supera a ambas a partir de unos <strong>36 a 39 usuarios</strong>. Pero ojo: eso solo es válido <em>si el desarrollo cuesta lo presupuestado, si resuelve la necesidad y si alguien lo mantiene</em>. Los proyectos de software suelen salirse de presupuesto; por eso la matriz te permite probar un desarrollo 50 % más caro y ver cómo se mueve el equilibrio.</p>
{{img:cuando}}

<h2>Lo que la hoja de cálculo no muestra</h2>
<p>El costo es un criterio; estos otros pueden pesar más que la diferencia de unos miles de dólares:</p>
<ul>
<li><strong>Dependencia (lock-in).</strong> ¿Puedes exportar tus datos en un formato abierto si cambias de proveedor? Con la suscripción, pregunta esto <em>antes</em> de firmar.</li>
<li><strong>Datos personales.</strong> Si la herramienta guarda datos de estudiantes, clientes o empleados en servidores fuera de Colombia, la Ley 1581 de 2012 (artículo 26) prohíbe, en principio, transferir datos a países sin nivel adecuado de protección según los estándares de la Superintendencia de Industria y Comercio, salvo excepciones como la autorización del titular. Revisa dónde se alojan los datos y qué cláusulas ofrece el proveedor.</li>
<li><strong>IVA y moneda.</strong> Los servicios digitales prestados desde el exterior a consumidores en Colombia causan IVA del 19 % (Estatuto Tributario), que generalmente asume el usuario, y el precio en dólares te expone a la tasa de cambio. Confírmalo con tu contador; no está incluido en la matriz.</li>
<li><strong>Software legal.</strong> Las sociedades deben informar en su informe de gestión el estado de cumplimiento de las normas de propiedad intelectual y derechos de autor (Ley 603 de 2000): conviene que tus licencias estén en regla.</li>
<li><strong>Capacidad de mantener.</strong> Una aplicación propia sin quien la mantenga se vuelve un riesgo. La pregunta no es «¿podemos construirla?», sino «¿quién la cuidará en el año tres?».</li>
</ul>

<h2>Una lista de verificación antes de decidir</h2>
<ol>
<li><strong>Define el proceso</strong> y cuántos usuarios lo usarán hoy y en tres años.</li>
<li><strong>Calcula el costo a 3 años</strong> de cada ruta con la matriz, incluyendo implementación, capacitación y soporte.</li>
<li><strong>Prueba el peor caso:</strong> alza del 15 %, desarrollo 50 % más caro, tasa de cambio más alta.</li>
<li><strong>Pregunta por la salida:</strong> cómo exportas tus datos y qué pasa si el proveedor desaparece o cambia el precio.</li>
<li><strong>Revisa el tratamiento de datos</strong> y el IVA con quien corresponda.</li>
<li><strong>Empieza pequeño:</strong> una prueba piloto con pocos usuarios antes de comprometer tres años.</li>
</ol>
<p>Y una pregunta que se omite casi siempre: <strong>¿existe ya una herramienta sencilla que resuelva el 80 % de la necesidad?</strong> A veces una plantilla bien hecha en Excel, con soporte, evita pagar por funciones que nadie usará (ver <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a> para saber cuándo no basta).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la suscripción se volvió la norma: casi todo el software de oficina y de gestión se vende como servicio. En Colombia y Latinoamérica, el modelo trae un matiz propio: se paga en dólares con ingresos en pesos, así que una devaluación sube el costo sin que el proveedor cambie el precio, y la contratación pública y los colegios deben además justificar el gasto ante consejos y rectoría. Para los <strong>directivos</strong>, la pregunta es la sostenibilidad del gasto; para los <strong>docentes y usuarios</strong>, que la herramienta realmente les ahorre trabajo (ver <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">cómo automatizar con Excel</a>); para las <strong>familias</strong>, qué pasa con los datos de sus hijos cuando el colegio contrata una plataforma (ver <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">datos de estudiantes</a>).</p>

<h2>Herramientas que ya existen y puedes probar</h2>
<p>Si tu necesidad es facturar, enviar documentos o automatizar tareas de oficina, quizás no necesites ninguna de las tres rutas grandes. Estas plantillas y aplicativos en Excel se compran una vez, con soporte opcional, y funcionan en tu equipo:</p>
{{productos:factura-con-envio-por-correo-al-cliente,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">la nube no es un respaldo</a>, <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad en una empresa</a> y <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Es más barato comprar una licencia que pagar una suscripción?</h3>
<p>Depende del número de usuarios y del plazo. En el ejemplo, la licencia solo gana a la suscripción a partir de unos 19 usuarios y a un horizonte de tres años; con pocos usuarios, la suscripción suele costar menos.</p>
<h3>¿Cuánto cuesta mantener una aplicación propia?</h3>
<p>Una regla práctica usada en el ejemplo es el 20 % anual del costo de desarrollo, más hosting, seguridad y soporte. Es un supuesto ilustrativo: ajústalo con una cotización real.</p>
<h3>¿Qué es el costo total de propiedad (TCO)?</h3>
<p>Es la suma de todo lo que cuesta una herramienta durante un periodo (compra, implementación, capacitación, soporte, infraestructura y administración), no solo el precio de compra.</p>
<h3>¿La suscripción paga IVA en Colombia?</h3>
<p>Los servicios digitales prestados desde el exterior a consumidores en Colombia causan IVA del 19 %. Confirma con tu contador cómo aplica a tu caso.</p>
<h3>¿Cómo evito quedar atrapado con un proveedor?</h3>
<p>Exige poder exportar tus datos en formatos abiertos, conserva copias propias y negocia condiciones de salida y de aumento de precio antes de firmar.</p>

<p class="notice"><strong>Haz tu propio cálculo.</strong> Descarga la <a href="/descargas/matriz-costes/matriz-costes-3-anos.xlsx">matriz de costes a 3 años</a>, cambia los supuestos amarillos por tus cifras y mira qué ruta gana, y con cuántos usuarios cambia la respuesta.</p>

<h2>Para pensar</h2>
<p>Pagar una suscripción es alquilar; comprar una licencia es ser dueño de una puerta que otro sigue cerrando; desarrollar es construir una casa que hay que habitar y reparar. <strong>¿Es la autonomía tecnológica un lujo que solo pueden permitirse las organizaciones grandes, o una inversión que las pequeñas deberían hacer por soberanía sobre sus propios datos, aunque cueste más al principio? ¿Y quién debería decidirlo: quien paga, quien usa o quien responde por los datos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:total}}' => $img('tco-comprar-suscribir-desarrollar-total', 392, 'Barras con el costo total a tres años en el caso de ejemplo: comprar licencia 15.300 dólares, suscripción 14.274 y desarrollo propio 36.540.', 'Costo total a tres años en el caso ilustrativo de 12 usuarios.'),
    '{{img:cuando}}' => $img('tco-comprar-suscribir-desarrollar-cuando', 444, 'Tabla que resume el riesgo principal de cada opción y cuándo gana: la licencia con muchos usuarios y uso estable, la suscripción con pocos usuarios y sin TI propia, y el desarrollo propio cuando el proceso es único.', 'Cuándo gana cada opción.'),
]);

return [
    'slug' => 'comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos',
    'title' => '¿Comprar software, pagar una suscripción o desarrollar una aplicación propia? La comparación que pocas empresas hacen',
    'excerpt' => 'El costo real a tres años de comprar una licencia, suscribirse o desarrollar una aplicación propia, con un caso numérico, supuestos explícitos, puntos de equilibrio y una matriz de costes en Excel.',
    'seo_title' => 'Comprar, suscribirse o desarrollar: costo a 3 años',
    'seo_description' => 'Compara el costo total a 3 años de comprar software, pagar una suscripción o desarrollar tu propia app, con un caso, puntos de equilibrio y matriz en Excel.',
    'focus_keyword' => 'comprar o desarrollar software',
    'cover' => '/assets/img/articulos/tco-comprar-suscribir-desarrollar/tco-comprar-suscribir-desarrollar-portada',
    'cover_alt' => 'Portada «¿Comprar, suscribirse o desarrollar tu propia aplicación? El costo real a 3 años» con una tarjeta que muestra 14.274 dólares para la suscripción, 15.300 para la licencia y 36.540 para el desarrollo propio en el caso de ejemplo.',
    'published_at' => '2026-11-10 12:00:00',
    'content_html' => $html,
];
