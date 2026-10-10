<?php

declare(strict_types=1);

// «#N/A, #SPILL!, #CALC! y #VALUE!: qué significan y cómo arreglarlos de verdad». Todo probado en Microsoft Excel 16 (es-CO): BUSCARX con espacio final da #N/D; FILTRAR con celda obstruyendo da #¡DESBORDAMIENTO!; FILTRAR sin filas da #CALC!; texto «12 unidades» da #¡VALOR!. Datos ficticios. Verificado el 9 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/errores-excel/' . $name;
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
<p>Un error en Excel asusta: una celda llena de #N/D, otra con #¡VALOR!, un derrame que no se derrama. La reacción más común es taparlo con <code>SI.ERROR</code> y seguir adelante. Es la peor idea: <strong>ocultas el síntoma y dejas la causa</strong>, y la próxima vez el error ya no se verá aunque los números estén mal.</p>
<p>Este artículo explica cuatro errores que aparecen cada vez más con las funciones modernas (#N/A, #SPILL!, #CALC! y #VALUE!), qué significan realmente y cómo corregir <strong>la causa</strong>. Cada uno viene con un ejercicio resuelto en un <a href="/descargas/errores-excel/errores-excel-ejercicios.xlsx">libro de ejercicios con soluciones</a>. Todo se probó en Microsoft Excel 16 con configuración regional es-CO (en español los errores se llaman #N/D, #¡DESBORDAMIENTO!, #CALC! y #¡VALOR!). Verificado el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Un error de Excel casi siempre tiene una causa pequeña y concreta: un espacio de más, una celda que estorba, un filtro sin resultados, un texto donde iba un número. <strong>Lee el error, busca la causa, corrige la causa</strong> y, solo si es un caso esperado (por ejemplo, «sin resultados»), usa el argumento previsto para manejarlo. Evita envolver todo en SI.ERROR.</p>

<h2>Por qué no tapar los errores con SI.ERROR</h2>
<p><code>=SI.ERROR(fórmula; "")</code> hace desaparecer cualquier error, incluso los que significan que algo está roto. Si buscas el precio de un código y el código no existe, ¿quieres ver un vacío o una alarma? Un vacío puede acabar sumándose como cero en un total (ver <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a>). Regla práctica: <strong>maneja de forma explícita los casos esperados</strong> (con el argumento que la función ofrece para eso) y deja visibles los inesperados.</p>

<h2>Ejercicio 1: #N/A (en español, #N/D)</h2>
<p><strong>Situación.</strong> La secretaría escribe el código <code>"A-107 "</code> (con un espacio al final) y busca su precio en una lista de 12 productos de una papelería escolar:</p>
<pre><code>=BUSCARX(B3; Datos!A2:A13; Datos!C2:C13)        ' español
=XLOOKUP(B3, Datos!A2:A13, Datos!C2:C13)        ' inglés
' Resultado: #N/D (#N/A)</code></pre>
<p><strong>Causa.</strong> El código existe, pero el que se escribió tiene un espacio al final y no es idéntico al de la lista. #N/A significa «no disponible»: el valor buscado no se encontró.</p>
<p><strong>Solución.</strong> Limpia el valor buscado y maneja explícitamente el caso de que no exista:</p>
<pre><code>=BUSCARX(ESPACIOS(B3); Datos!A2:A13; Datos!C2:C13; "No existe")
=XLOOKUP(TRIM(B3), Datos!A2:A13, Datos!C2:C13, "No existe")
' Resultado: 95000</code></pre>
<p>Otras causas frecuentes de #N/A: buscar un número contra datos que están guardados como texto (o al revés), diferencias de tildes o guiones, y rangos de búsqueda desalineados con el de resultados. Ver también <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importar CSV correctamente</a>, donde muchos de estos problemas nacen.</p>

<h2>Ejercicio 2: #SPILL! (en español, #¡DESBORDAMIENTO!)</h2>
<p><strong>Situación.</strong> Una sola fórmula debe listar todos los productos con precio mayor de 60.000, derramando el resultado en varias filas y columnas:</p>
<pre><code>=FILTRAR(Datos!A2:E13; Datos!C2:C13>60000)    ' español
=FILTER(Datos!A2:E13, Datos!C2:C13>60000)     ' inglés</code></pre>
<p>La fórmula está bien escrita, pero la celda muestra #¡DESBORDAMIENTO!.</p>
<p><strong>Causa.</strong> El resultado ocupa 5 filas y 5 columnas (el filtro devuelve cinco productos), y en ese rango hay una celda con una nota olvidada. Una fórmula de matriz dinámica necesita que todo el rango de derrame esté libre. Al seleccionar la celda, Excel marca el rango con un borde punteado, y el menú del error ofrece seleccionar las celdas que obstruyen.</p>
<p><strong>Solución.</strong> Borra o mueve la nota (o mueve la fórmula a un área libre). La fórmula no cambia. Probé quitar la nota y el resultado se derramó de A-101 a A-110. Otras causas de #SPILL!: celdas combinadas en el camino, una tabla de Excel (los derrames no se permiten dentro de una tabla) y un resultado más grande que la hoja.</p>

<h2>Ejercicio 3: #CALC!</h2>
<p><strong>Situación.</strong> Se pide listar los productos con precio mayor de 10.000.000, y ninguno cumple:</p>
<pre><code>=FILTRAR(Datos!A2:E13; Datos!C2:C13>10000000)
=FILTER(Datos!A2:E13, Datos!C2:C13>10000000)
' Resultado: #CALC!</code></pre>
<p><strong>Causa.</strong> El filtro no encontró ninguna fila y una matriz vacía no puede mostrarse; Excel lo marca como #CALC!. No es una falla de tu fórmula, es un caso esperado.</p>
<p><strong>Solución.</strong> Usa el tercer argumento de FILTRAR (<code>si_vacío</code>) para decidir qué mostrar:</p>
<pre><code>=FILTRAR(Datos!A2:E13; Datos!C2:C13>10000000; "Sin resultados")
=FILTER(Datos!A2:E13, Datos!C2:C13>10000000, "Sin resultados")</code></pre>
<p>Este es el caso donde sí corresponde manejar el error: es esperado y existe un argumento diseñado para eso, sin necesidad de SI.ERROR.</p>

<h2>Ejercicio 4: #VALUE! (en español, #¡VALOR!)</h2>
<p><strong>Situación.</strong> Quieres calcular el valor del inventario del producto A-109 (precio por unidades):</p>
<pre><code>=Datos!C10*Datos!D10
' Resultado: #¡VALOR!</code></pre>
<p><strong>Causa.</strong> La celda D10 contiene el texto <code>"12 unidades"</code> en lugar del número 12, y Excel no puede multiplicar por un texto que no es un número. Con un texto que sí parece número (como «1.200» guardado como texto) Excel a veces lo convierte solo; con «12 unidades» no.</p>
<p><strong>Solución.</strong> La buena es <strong>corregir el dato</strong>: escribir 12 y poner la unidad en el encabezado, y añadir <em>validación de datos</em> en la columna para que solo acepte números enteros. Si no puedes tocar el origen, extrae el número:</p>
<pre><code>=Datos!C10*VALOR(IZQUIERDA(Datos!D10; ENCONTRAR(" "; Datos!D10)-1))
=Datos!C10*VALUE(LEFT(Datos!D10, FIND(" ", Datos!D10)-1))
' Resultado: 540000</code></pre>
<p>Pero esto es un parche: la causa es que alguien escribió texto donde iba un número, y volverá a pasar.</p>
{{img:diagnostico}}

<h2>Los otros errores frecuentes</h2>
<table>
<thead><tr><th>Error</th><th>Significa</th><th>Primera revisión</th></tr></thead>
<tbody>
<tr><td><strong>#DIV/0! (#¡DIV/0!)</strong></td><td>División entre cero o celda vacía</td><td>Revisa el divisor; controla con SI</td></tr>
<tr><td><strong>#REF! (#¡REF!)</strong></td><td>Una referencia ya no existe</td><td>Se eliminó una fila, columna u hoja usada</td></tr>
<tr><td><strong>#NAME? (#¿NOMBRE?)</strong></td><td>Excel no reconoce un nombre</td><td>Función mal escrita o texto sin comillas</td></tr>
<tr><td><strong>#NUM! (#¡NUM!)</strong></td><td>Número inválido para la operación</td><td>Raíz de un negativo o resultado demasiado grande</td></tr>
</tbody>
</table>
<p>Comprobé en Excel que <code>=B1/0</code> da #¡DIV/0!, <code>=RAIZ(-1)</code> da #¡NUM! y una función inexistente da #¿NOMBRE?. El libro trae una hoja «Guia_errores» con los ocho errores.</p>

<h2>Un método de cuatro pasos</h2>
<ol>
<li><strong>Lee el error:</strong> cada uno apunta a una familia de causas.</li>
<li><strong>Evalúa la fórmula por partes:</strong> en <em>Fórmulas</em>, «Evaluar fórmula» muestra cada paso, y F9 sobre una parte seleccionada calcula solo esa parte.</li>
<li><strong>Revisa los datos de entrada:</strong> espacios, texto contra números, celdas vacías, tipos.</li>
<li><strong>Corrige la causa</strong> y solo entonces decide si ese caso se maneja explícitamente.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En todo el mundo, la mayoría de los errores en hojas de cálculo nace de datos sucios, no de fórmulas mal escritas. En Colombia y Latinoamérica se suma un obstáculo propio: los separadores. Nuestra configuración regional usa coma decimal y punto de miles, y las funciones se llaman distinto en español (BUSCARX, FILTRAR, SI.ERROR), por lo que copiar fórmulas de tutoriales en inglés suele producir errores. Para los <strong>docentes</strong> que llevan notas, los <strong>administrativos</strong> con inventarios y facturas y las <strong>pymes</strong>, entender las causas evita que una celda muda se convierta en un total equivocado. Y para quienes enseñan Excel, estos cuatro ejercicios sirven como práctica de diagnóstico.</p>

<h2>Plantillas y herramientas para trabajar con orden</h2>
<p>Si quieres que tus datos estén ordenados desde el origen, estas plantillas traen validaciones y controles. Y hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a> para pedir ayuda a una IA con tus fórmulas, siempre verificando lo que te devuelve.</p>
{{productos:convertidor-de-numeros-a-letras-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">cuándo Excel deja de ser la solución</a>, <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">pronósticos en Excel</a> y <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">las gráficas que mienten</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué significa #N/A en Excel?</h3>
<p>Que el valor buscado no se encontró. La causa más frecuente son espacios de más o diferencias de tipo (texto contra número). Limpia con ESPACIOS y usa el argumento «si no se encuentra».</p>
<h3>¿Por qué sale #SPILL! y cómo lo arreglo?</h3>
<p>Porque el resultado de una fórmula dinámica no cabe: hay celdas ocupadas, celdas combinadas o una tabla en el rango de derrame. Libera el rango.</p>
<h3>¿Cuál es la diferencia entre #CALC! y #VALUE!?</h3>
<p>#CALC! indica un problema de cálculo, como una matriz vacía; #VALUE! indica un valor de tipo equivocado, como texto donde se esperaba un número.</p>
<h3>¿Es malo usar SI.ERROR?</h3>
<p>No siempre, pero usarlo para todo oculta problemas reales. Úsalo cuando el error sea esperado y no exista un argumento específico, y no para tapar fallas.</p>
<h3>¿Estos errores existen en versiones antiguas de Excel?</h3>
<p>#N/A y #VALUE! existen desde hace décadas. #SPILL! y #CALC! aparecen con las matrices dinámicas de Excel moderno (Microsoft 365 y Excel 2021 o posterior).</p>

<p class="notice"><strong>Practica ahora.</strong> Descarga el <a href="/descargas/errores-excel/errores-excel-ejercicios.xlsx">libro de ejercicios</a>, resuelve las cuatro hojas y compara con «Soluciones». Requiere Excel 2021 o Microsoft 365 (BUSCARX y FILTRAR).</p>

<h2>Para pensar</h2>
<p>Un error visible es una oportunidad: te avisa que algo está mal. Un error tapado es una deuda. <strong>¿Deberían las organizaciones prohibir el uso indiscriminado de SI.ERROR en los libros que mueven dinero, notas o decisiones, y exigir que cada error se explique y se resuelva? ¿O es una exageración que ahogaría la agilidad que hizo popular a Excel?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:diagnostico}}' => $img('errores-excel-diagnostico', 499, 'Tabla con cuatro errores de Excel, la causa en el ejemplo y el arreglo: #N/A por un espacio al final, #SPILL! por una nota en el rango, #CALC! por un filtro sin filas y #VALUE! por texto en vez de número.', 'Del error a la causa y al arreglo.'),
]);

return [
    'slug' => 'errores-excel-na-spill-calc-value-que-significan-como-arreglarlos',
    'title' => '#N/A, #SPILL!, #CALC! y #VALUE!: qué significan los errores de Excel y cómo arreglarlos de verdad',
    'excerpt' => 'Cuatro errores de Excel con funciones modernas, explicados con ejercicios resueltos y probados: la causa de cada uno, cómo corregirla sin taparla con SI.ERROR y un libro de ejercicios con soluciones y guía rápida.',
    'seo_title' => 'Errores de Excel #N/A, #SPILL!, #CALC! y #VALUE!',
    'seo_description' => 'Qué significan los errores #N/A, #SPILL!, #CALC! y #VALUE! en Excel, cómo corregir su causa y un libro de ejercicios con soluciones para practicar.',
    'focus_keyword' => 'errores de Excel N/A SPILL CALC VALUE',
    'cover' => '/assets/img/articulos/errores-excel/errores-excel-portada',
    'cover_alt' => 'Portada «#N/A, #SPILL!, #CALC! y #VALUE!: qué significan y cómo arreglarlos de verdad» con una tarjeta de cuatro errores y su causa: un espacio de más, una celda que estorba, una lista vacía y texto en vez de número.',
    'published_at' => '2026-11-26 12:00:00',
    'content_html' => $html,
];
