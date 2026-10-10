<?php

declare(strict_types=1);

// "El riesgo oculto de Excel": auditoría y control de versiones. Casos y fuentes verificados el 9 de octubre de 2026 (Herndon, Ash y Pollin sobre
// Reinhart y Rogoff; Panko vía arXiv; documentación de Microsoft sobre Inquire/Spreadsheet Compare y el historial de versiones). El caso de
// comisiones es hipotético y TODAS las fórmulas y cifras se probaron en Microsoft Excel 16 (Windows, configuración regional de Colombia).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/riesgo-excel-auditoria/' . $name;
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
<p>En casi todas las empresas, colegios y oficinas hay un archivo de Excel del que depende algo importante: la nómina, las comisiones, el inventario, las notas, el presupuesto. Alguien lo construyó hace años, otras tres personas lo han modificado y nadie recuerda cuál es "la versión buena". <strong>Nadie lo audita, nadie lo versiona y, sin embargo, mueve dinero y decide cosas.</strong></p>
<p>En este artículo te muestro, con un caso probado en Excel, cómo un error aparentemente pequeño puede alterar un total en casi un 20 % sin que nadie lo note; cómo detectarlo con controles que puedes copiar y pegar; y cómo organizar una <strong>auditoría de tus hojas críticas</strong>. Datos y herramientas verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Los errores en hojas de cálculo son comunes y a menudo invisibles: en un caso probado con nueve vendedores, tres errores pequeños hicieron que el total de comisiones difiriera en 1.954.000 pesos (19 %) y el total aun así "parecía razonable". Los controles que lo detectan son fórmulas sencillas. Lo que falta no es tecnología, sino el hábito de revisar.</p>

<h2>Qué dice la evidencia: los errores en hojas de cálculo son la regla</h2>
<p>El caso más famoso es el de los economistas Reinhart y Rogoff. En 2013, Herndon, Ash y Pollin <a href="https://www.newstatesman.com/business/economics/2013/04/statistic-cited-defend-austerity-partially-based-excel-error">descubrieron</a> que su hoja de cálculo promediaba las filas 30 a 44 en lugar de la 30 a la 49, dejando fuera a cinco países; ese error de rango por sí solo explicaba unos 0,3 puntos porcentuales de diferencia en el crecimiento promedio de los países con deuda alta. Sumado a otras decisiones de exclusión y ponderación, el crecimiento corregido fue 2,2 % y no el −0,1 % publicado. Aquel estudio fue muy citado en debates de política económica.</p>
<p>¿Y es un caso aislado? La literatura sobre riesgo en hojas de cálculo dice que no. En una <a href="https://arxiv.org/pdf/0802.3457">revisión de auditorías de campo</a>, Raymond Panko reporta que las auditorías más recientes y rigurosas encontraron errores en al menos el 86 % de las hojas auditadas, y que los desarrolladores cometen errores no corregidos en entre el 2 % y el 5 % de las fórmulas. Ten cuidado con las cifras que circulan sin fuente: el "94 % de las hojas tiene errores" aparece en resúmenes de segunda mano y no pude confirmarlo en el trabajo original, así que la cifra que sí puedo respaldar es la del 86 % o más en las auditorías recientes.</p>

<h2>Un caso probado: tres errores pequeños y un total que parece correcto</h2>
<p>Armé una hoja de comisiones con nueve vendedores (ventas, tasa y comisión = ventas × tasa) y sembré tres errores muy comunes:</p>
<ol>
<li><strong>Fila fuera del rango del total.</strong> Se agregó a Iván en la fila 10 después de armar el total, y la fórmula quedó en <code>=SUMA(D2:D9)</code>.</li>
<li><strong>Valor pegado sobre una fórmula.</strong> En la comisión de Diego alguien pegó 1.800.000 como valor; la fórmula daba 1.500.000.</li>
<li><strong>Ancla de celda equivocada.</strong> La comisión de Felipe quedó como <code>=B7*C$2</code> (usa la tasa de la fila 2, 5 %) en vez de <code>=B7*C7</code> (6 %).</li>
</ol>
<p>El total reportado fue <strong>8.292.500</strong>; el correcto, <strong>10.246.500</strong>. Una diferencia de <strong>1.954.000 pesos (19 %)</strong>. Y fíjate en lo traicionero: los errores se compensan en parte (el valor pegado suma 300.000 de más; el ancla resta 274.000; la fila fuera del rango resta 1.980.000), así que el total no se ve "absurdo" y nadie sospecha.</p>
{{img:errores}}
<p>Un cuarto error, en otra hoja, es el pago duplicado. En una lista de ocho facturas, la FAC-1004 aparece dos veces (3.200.000 cada vez): el total pagado es 14.130.000 y el total sin duplicar, 10.930.000. <strong>Se pagó 3.200.000 de más</strong>, y sin un control nadie lo habría visto.</p>

<h2>Controles que puedes copiar y pegar</h2>
<p>Estas fórmulas las probé en Excel en español con la hoja anterior (el rango de datos es D2:D10; la comisión está en D y el total en D11). Ponlas en una hoja "Control"; todas deben dar cero:</p>
<pre><code>// 1. Filas que quedaron fuera del total (debe dar 0; en el caso dio 1.980.000)
=SUMA(D2:D10)-D11

// 2. Celdas de la columna que NO tienen fórmula (debe dar 0; en el caso dio 1)
=SUMAPRODUCTO(--NO(ESFORMULA(D2:D10)))

// 3. Filas donde la comisión no coincide con ventas x tasa (debe dar 0; en el caso dio 2)
=SUMAPRODUCTO(--(D2:D10<>B2:B10*C2:C10))

// 4. Ver la fórmula de una celda sospechosa (en el caso mostró =B7*C$2)
=FORMULATEXTO(D7)

// 5. Total recalculado de forma independiente (en el caso dio 10.246.500)
=SUMAPRODUCTO(B2:B10;C2:C10)

// 6. Facturas duplicadas: marca cada repetida (en la hoja de pagos)
=SI(CONTAR.SI($A$2:$A$9;A2)>1;"DUPLICADA";"")

// 7. Total sin duplicar y cuántas facturas se repiten (en el caso: 10.930.000 y 1)
=SUMAPRODUCTO(B2:B9/CONTAR.SI(A2:A9;A2:A9))
=CONTARA(A2:A9)-SUMAPRODUCTO(1/CONTAR.SI(A2:A9;A2:A9))</code></pre>
<p>En Excel en inglés, las funciones se llaman SUM, ISFORMULA, NOT, FORMULATEXT, SUMPRODUCT, IF, COUNTIF y COUNTA. El control 3 sirve incluso cuando el error es un valor pegado o un ancla mal puesta: ambos hacen que la comisión deje de ser ventas × tasa. Y el control 5 es la idea central: <strong>recalcula el total por otro camino y compara</strong>.</p>
<p>Un detalle sobre las <strong>Tablas</strong> de Excel: al convertir un rango en tabla, las fórmulas pueden usar nombres de columna, como <code>=SUMA(tComisiones[Comision])</code>, que se leen mejor y se ajustan cuando se agregan filas a la tabla. En mi prueba, además, un rango fijo que cubría exactamente toda la columna de la tabla también se amplió; el riesgo real aparece cuando las filas se pegan fuera de la tabla o debajo del total. Por eso conviene tanto estructurar los datos como controlar los totales.</p>

<h2>Auditoría y control de versiones con las herramientas que ya tienes</h2>
<ul>
<li><strong>Ver todas las fórmulas.</strong> <em>Fórmulas &gt; Mostrar fórmulas</em> (o Ctrl + `) y <em>Rastrear precedentes</em> para seguir de dónde viene un número.</li>
<li><strong>Inquire y Spreadsheet Compare.</strong> Microsoft ofrece el complemento <a href="https://support.microsoft.com/en-us/excel/turn-on-the-inquire-add-in">Inquire</a> (analiza un libro y compara dos versiones celda por celda) y la herramienta Spreadsheet Compare, pero solo en Excel para Windows con ediciones empresariales (Office Professional Plus o Microsoft 365 Apps for enterprise). Si no ves la opción en <em>Archivo &gt; Opciones &gt; Complementos &gt; Complementos COM</em>, tu edición no la incluye.</li>
<li><strong>Historial de versiones.</strong> Si el archivo está en OneDrive o SharePoint con una suscripción de Microsoft 365, <em>Archivo &gt; Información &gt; Historial de versiones</em> guarda versiones automáticamente y permite restaurar. Los archivos locales no tienen esta función.</li>
<li><strong>Proteger.</strong> Bloquea las celdas con fórmulas y protege la hoja; deja editables solo las celdas de entrada, con <em>Validación de datos</em> (por ejemplo, solo números entre 0 y 1 para una tasa).</li>
<li><strong>Un solo archivo "oficial".</strong> Nada de <em>final_FINAL2_revisado.xlsx</em>: una ubicación compartida, un dueño responsable y una hoja "Control de cambios" con fecha, quién, qué cambió y por qué.</li>
<li><strong>Separar funciones.</strong> Quien construye la hoja no es quien la revisa.</li>
</ul>
{{img:pasos}}

<h2>Colombia, Latinoamérica y el mundo: por qué importa más en la pyme</h2>
<p>En el mundo, las grandes empresas tienen auditoría interna y herramientas de gestión de modelos, y aun así hay casos como el de Reinhart y Rogoff. En Latinoamérica y Colombia, la mayoría de pymes, oficinas contables y colegios dependen de Excel para nómina, facturación, inventario y notas, como describo en el artículo <a href="/excel-esta-muerto-era-de-la-ia/">¿Excel está muerto en la era de la IA?</a>, pero rara vez tienen un proceso de revisión. Para un <strong>contador</strong>, el riesgo es un error en una declaración o una conciliación; para un <strong>gerente</strong>, una decisión de precios o de compra mal sustentada; para un <strong>docente o directivo</strong>, notas mal calculadas que afectan la promoción de un estudiante (lo que conecta con <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">el artículo sobre qué miden las calificaciones</a>). La buena noticia es que los controles son baratos: una hoja "Control" y un hábito.</p>

<h2>Auditoría de tus hojas críticas: paso a paso</h2>
<ol>
<li><strong>Inventario.</strong> Haz una lista de los archivos de Excel que mueven dinero o deciden cosas (nómina, comisiones, inventario, notas, presupuesto) y anota el dueño de cada uno.</li>
<li><strong>Prueba de total.</strong> Para cada uno, recalcula el total por otro camino (control 5) y compara.</li>
<li><strong>Celdas con valores pegados.</strong> Busca celdas sin fórmula en columnas calculadas (control 2).</li>
<li><strong>Duplicados.</strong> Revisa identificadores repetidos (control 6).</li>
<li><strong>Protección y versiones.</strong> Bloquea fórmulas, valida la entrada y mueve el archivo a una ubicación con historial de versiones.</li>
<li><strong>Segunda revisión y calendario.</strong> Que otra persona repita el control y agenda una revisión trimestral.</li>
</ol>

<h2>Herramientas para automatizar y controlar</h2>
<p>Los errores de numeración y duplicados desaparecen cuando la plantilla controla el consecutivo: la <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">Factura sencilla con numeración automática</a> asigna el número de forma consecutiva y evita repetir facturas. Si quieres que alguien revise tus hojas críticas o te ayude a implementar controles, la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a> te acompaña. Y si quieres aprender a automatizar sin dañar tus datos, mira <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">el artículo sobre cómo importar un CSV correctamente</a>, con archivo de práctica, y <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">cómo automatizar tareas en Excel y reducir errores</a>.</p>
{{productos:plantilla-en-excel-de-factura-sencilla-numeracion-automatica,soporte-plus-para-las-plantillas-de-excel}}

<h2>Preguntas frecuentes</h2>
<h3>¿Cómo sé si una celda tiene una fórmula o un valor pegado?</h3>
<p>Usa <code>=ESFORMULA(D2)</code>, que devuelve VERDADERO si la celda tiene fórmula. Para toda una columna, <code>=SUMAPRODUCTO(--NO(ESFORMULA(D2:D10)))</code> cuenta las celdas sin fórmula.</p>
<h3>¿Cómo evito que una fila quede fuera del total?</h3>
<p>Compara el total con una suma independiente de toda la columna (control 1) y usa Tablas. Y revisa siempre que, al agregar filas, el total las incluya.</p>
<h3>¿Excel guarda el historial de cambios?</h3>
<p>No en archivos locales. Si el archivo está en OneDrive o SharePoint con una suscripción de Microsoft 365, tiene historial de versiones. Para auditoría de cambios celda por celda existe el complemento Inquire, solo en ediciones empresariales de Windows.</p>
<h3>¿Qué hago si encuentro un error en un archivo que ya se usó?</h3>
<p>Documenta qué falló y desde cuándo, calcula el efecto, corrige y avisa a quienes usaron el resultado. Anota la lección en el registro de cambios.</p>
<h3>¿Vale la pena auditar hojas pequeñas?</h3>
<p>Si mueven dinero o deciden algo, sí. El tamaño no importa: el caso de este artículo tiene nueve filas y un 19 % de error.</p>

<p class="notice"><strong>Haz tu auditoría esta semana.</strong> Elige tus tres hojas más críticas, agrega una hoja "Control" con los controles 1, 2, 3 y 5, y mira si dan cero. Si quieres que alguien lo haga contigo, escribe a la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a>, y para facturar sin repetir números usa la <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">factura con numeración automática</a>.</p>

<h2>Para pensar</h2>
<p>Confiamos en un archivo de Excel porque "siempre ha funcionado", pero que nunca haya fallado a la vista no prueba que sea correcto. <strong>Si tu empresa o tu colegio tomara hoy una decisión importante con un archivo que nadie ha auditado, ¿quién respondería por el error: quien lo construyó, quien lo usó o quien nunca pidió revisarlo?</strong> ¿Y deberíamos tratar las hojas de cálculo críticas con la misma disciplina que tratamos un balance contable?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:errores}}' => $img('riesgo-excel-auditoria-errores', 500, 'Tabla con tres errores sembrados en una hoja de comisiones y el control que detecta cada uno: fila fuera del rango, valor pegado sobre una fórmula, ancla de celda equivocada y factura pagada dos veces.', 'Tres errores sembrados y el control que los detecta (caso probado en Excel).'),
    '{{img:pasos}}' => $img('riesgo-excel-auditoria-pasos', 467, 'Cinco pasos para auditar una hoja crítica: inventariar, controles de total, proteger, versionar y una segunda mirada.', 'Auditar una hoja crítica en cinco pasos.'),
]);

return [
    'slug' => 'riesgo-oculto-excel-auditoria-control-versiones',
    'title' => 'El riesgo oculto de Excel: archivos que controlan dinero y decisiones sin auditoría ni control de versiones',
    'excerpt' => 'Un caso probado en Excel con tres errores pequeños que alteran un total en 19 %, controles que puedes copiar y pegar y una auditoría paso a paso de tus hojas críticas.',
    'seo_title' => 'El riesgo oculto de Excel: auditoría y control de versiones',
    'seo_description' => 'Cómo un error pequeño altera un total en Excel, controles de fórmulas para detectarlo y cómo auditar tus hojas críticas y versionar tus archivos.',
    'focus_keyword' => 'auditoría de hojas de cálculo',
    'cover' => '/assets/img/articulos/riesgo-excel-auditoria/riesgo-excel-auditoria-portada',
    'cover_alt' => 'Portada con el título "El riesgo oculto de Excel: archivos que mueven dinero sin auditoría" y una tarjeta con 1.954.000 pesos de diferencia en un total que parecía correcto, causados por una fila fuera del rango, un valor pegado y un ancla mal puesta.',
    'published_at' => '2026-10-22 12:00:00',
    'content_html' => $html,
];
