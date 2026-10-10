<?php

declare(strict_types=1);

// "Listas desplegables dependientes en Excel: el método clásico y el moderno". Todo probado en Microsoft Excel 16 (es-CO): ORDENAR/UNICOS/FILTRAR con validación =$H$3#, nombres definidos con INDIRECTO y celda de verificación (combinación válida o inválida tras cambiar la primera lista). Datos ficticios. Verificado el 9 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/listas-dependientes/' . $name;
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
<p>Un formulario en Excel que recoge datos de estudiantes, clientes o inventarios tiene un enemigo constante: <strong>lo que cada persona escribe a su manera</strong>. "Medellín", "medellin", "Medellin." y "MED" son el mismo municipio para una persona y cuatro valores distintos para Excel (ver <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">cuándo Excel deja de ser la solución</a>). La defensa más simple son las <strong>listas desplegables</strong>, y la más útil son las <strong>dependientes</strong>: al elegir un departamento, la siguiente lista solo ofrece sus municipios.</p>
<p>Este artículo explica dos métodos para encadenar listas: el <strong>clásico</strong> (nombres definidos e <code>INDIRECTO</code>, que funciona en cualquier versión) y el <strong>moderno</strong> (<code>UNICOS</code>, <code>FILTRAR</code> y referencias al derrame, para Excel 2021 y Microsoft 365). Incluye una <a href="/descargas/listas-dependientes/listas-desplegables-dependientes.xlsx">plantilla descargable</a> con ambos métodos, probada en Microsoft Excel 16 (es-CO), y la verificación que casi nadie agrega. Verificado el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Una lista dependiente se construye con una sola tabla fuente y se encadena con una fórmula. El método moderno se actualiza solo cuando agregas filas y no se rompe con espacios en los nombres; el clásico funciona en cualquier versión. Ambos tienen una debilidad: <strong>si cambias la primera lista, el valor de la segunda se queda</strong> y puede quedar una combinación imposible. La solución es una celda de verificación que confirme que la combinación existe. Todo esto se probó con datos ficticios de departamentos, municipios e instituciones.</p>

<h2>La fuente: una sola tabla</h2>
<p>Antes de cualquier fórmula, una tabla ordenada en la hoja "Listas" con una fila por combinación:</p>
<table>
<thead><tr><th>Departamento</th><th>Municipio</th><th>Institución (ficticia)</th></tr></thead>
<tbody>
<tr><td>Antioquia</td><td>Medellín</td><td>I. E. Ejemplo 01</td></tr>
<tr><td>Antioquia</td><td>Envigado</td><td>I. E. Ejemplo 03</td></tr>
<tr><td>Atlántico</td><td>Barranquilla</td><td>I. E. Ejemplo 07</td></tr>
<tr><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<p>La plantilla trae 24 filas: 4 departamentos, 3 municipios cada uno y 2 instituciones por municipio. La regla de oro: <strong>todo sale de esta hoja</strong>; si hay que agregar un municipio, se agrega aquí y nada más.</p>

<h2>Método moderno: ÚNICOS, FILTRAR y el derrame</h2>
{{img:pasos}}
<p>En una zona auxiliar (columnas H a J de la hoja del formulario) se calculan las tres listas:</p>
<pre><code>' En español                                                  (celda)
=ORDENAR(UNICOS(Listas!A2:A25))                               ' H3: departamentos
=ORDENAR(UNICOS(FILTRAR(Listas!B2:B25; Listas!A2:A25=B4; ""))) ' I3: municipios del departamento elegido
=FILTRAR(Listas!C2:C25; (Listas!A2:A25=B4)*(Listas!B2:B25=B5); "")  ' J3: instituciones del municipio

' En inglés
=SORT(UNIQUE(Listas!A2:A25))
=SORT(UNIQUE(FILTER(Listas!B2:B25, Listas!A2:A25=B4, "")))
=FILTER(Listas!C2:C25, (Listas!A2:A25=B4)*(Listas!B2:B25=B5), "")</code></pre>
<p>Después, en <em>Datos, Validación de datos</em>, se elige <em>Lista</em> y como origen se usa la referencia al derrame, con el signo <code>#</code>: <code>=$H$3#</code> para el departamento (B4), <code>=$I$3#</code> para el municipio (B5) y <code>=$J$3#</code> para la institución (B6). El <code>#</code> significa "todo el rango que derrama esa fórmula", así la lista crece o se encoge sola. Comprobé que al elegir Antioquia, la segunda lista ofrece Envigado, Itagüí y Medellín; y al cambiar a Atlántico, Barranquilla, Malambo y Soledad.</p>
<p>Ventajas: no hay nombres definidos ni rangos que ajustar, las listas salen ordenadas y sin repetidos, y agregar datos en "Listas" actualiza todo (si el rango de las fórmulas lo cubre; usar una tabla de Excel como fuente lo hace automático).</p>

<h2>Método clásico: nombres definidos e INDIRECTO</h2>
<p>Funciona en cualquier versión de Excel. La idea: cada departamento tiene su propia columna de municipios, y a cada columna se le da un <strong>nombre definido igual al del departamento</strong> (en <em>Fórmulas, Administrador de nombres</em>). Así, la validación del municipio usa:</p>
<pre><code>' Validación de la lista de departamentos (B3): el rango de encabezados
=Clasico_listas!$A$3:$D$3

' Validación de la lista de municipios (B4): INDIRECTO convierte el texto de B3 en el nombre
=INDIRECTO($B$3)          ' español
=INDIRECT($B$3)           ' inglés</code></pre>
<p>Si B3 dice "Antioquia", <code>INDIRECTO</code> devuelve el rango con ese nombre, y la lista muestra sus municipios. Es el método de toda la vida, pero tiene mañas que probé:</p>
<ul>
<li>Los <strong>nombres definidos no admiten espacios</strong>: un "Norte de Santander" exige un nombre como "Norte_de_Santander" y una fórmula <code>INDIRECTO(SUSTITUIR(B3;" ";"_"))</code>.</li>
<li>Cada vez que agregas un departamento, hay que crear su nombre y ampliar la lista de encabezados.</li>
<li>Si el departamento está vacío, <code>INDIRECTO</code> da error y la lista del municipio no abre.</li>
</ul>

<h2>La verificación que casi nadie agrega</h2>
<p>Con cualquiera de los dos métodos hay un problema: <strong>si eliges Antioquia y Envigado, y después cambias el departamento a Atlántico, Excel deja "Envigado" en la celda del municipio</strong>. La validación solo controla lo que se escribe, no lo que ya estaba. Probé exactamente ese caso: el resultado es una combinación imposible que nadie nota. La solución es una celda de verificación:</p>
<pre><code>=SI(CONTAR.SI.CONJUNTO(Listas!A2:A25; B4; Listas!B2:B25; B5; Listas!C2:C25; B6)=1;
    "Combinación válida"; "Revisar: la combinación no existe")

=IF(COUNTIFS(Listas!A2:A25, B4, Listas!B2:B25, B5, Listas!C2:C25, B6)=1,
    "Combinación válida", "Revisar: la combinación no existe")</code></pre>
<p>En la prueba, con Antioquia, Envigado e "I. E. Ejemplo 03" la verificación dice "Combinación válida"; al cambiar el departamento a Atlántico y dejar lo demás, dice "Revisar: la combinación no existe" (y el formato condicional la pone en rojo). Para el método clásico, la verificación equivalente usa <code>CONTAR.SI(INDIRECTO(B3); B4)</code>. Si el formulario alimenta una base de datos o un informe, <strong>condiciona el envío a que la verificación sea válida</strong>.</p>

<h2>Clásico o moderno: cuál elegir</h2>
{{img:comparacion}}
<table>
<thead><tr><th>Situación</th><th>Elige</th></tr></thead>
<tbody>
<tr><td>El libro lo usarán personas con versiones antiguas de Excel</td><td>Clásico</td></tr>
<tr><td>Las listas cambian con frecuencia (se agregan municipios o instituciones)</td><td>Moderno</td></tr>
<tr><td>Hay nombres con espacios o tildes</td><td>Moderno (o clásico con SUSTITUIR)</td></tr>
<tr><td>El formulario está en Excel para la Web o en Microsoft 365</td><td>Moderno</td></tr>
</tbody>
</table>

<h2>Errores frecuentes y cómo evitarlos</h2>
<ol>
<li><strong>Dejar la validación en modo "Advertencia" o "Información":</strong> permite escribir cualquier cosa. En <em>Mensaje de error</em>, el estilo debe ser <em>Detener</em>.</li>
<li><strong>Copiar y pegar sobre las celdas con validación:</strong> el pegado reemplaza la regla. Protege la hoja o pega solo valores.</li>
<li><strong>Escribir las listas a mano en cada formulario:</strong> usa una sola fuente.</li>
<li><strong>Olvidar la verificación</strong> y confiar en que la validación lo cubre todo.</li>
<li><strong>Usar #N/A o errores en la lista auxiliar:</strong> si FILTRAR no encuentra nada, el tercer argumento <code>""</code> evita el error (ver <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL!, #CALC! y #VALUE!</a>).</li>
</ol>

<h2>Casos de uso en un colegio o una pyme</h2>
<ul>
<li><strong>Inscripciones:</strong> grado y grupo; o departamento, municipio e institución.</li>
<li><strong>Asistencia:</strong> área, docente y grupo, para que nadie escriba un nombre distinto.</li>
<li><strong>Inventario:</strong> categoría y subcategoría.</li>
<li><strong>Pedidos:</strong> cliente y sede.</li>
</ul>
<p>Cuando el volumen crece y varias personas editan a la vez, es la señal de pasar a una base de datos (ver las siete señales) o a una herramienta específica.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la validación de datos es de las prácticas más baratas y efectivas de calidad de datos. En Colombia y Latinoamérica el reto es doble: los separadores de lista y las funciones en español (<code>;</code> en lugar de <code>,</code>, <code>FILTRAR</code> en lugar de <code>FILTER</code>), que hacen que las fórmulas de tutoriales en inglés fallen al copiarlas, y la normalización de nombres (tildes, "Bogotá D. C.", "Norte de Santander"), que la lista desplegable resuelve de raíz. Para <strong>docentes y secretarías</strong> que arman listados de asistencia, para <strong>pymes</strong> con pedidos por sede y para <strong>quienes enseñan Excel</strong>, esta técnica es de las más rentables: una lista bien hecha evita horas de limpieza después (ver <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importar CSV correctamente</a>).</p>

<h2>Plantillas para trabajar con orden</h2>
<p>Si quieres un listado de asistencia con controles ya armados, o plantillas de facturación con numeración automática, estas opciones están listas para usar, con soporte opcional. Y hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a> para pedir ayuda con tus fórmulas, verificando siempre el resultado.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">pronósticos en Excel</a>, <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a> y <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">cómo automatizar en Excel</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cómo creo una lista desplegable dependiente en Excel?</h3>
<p>Con una tabla fuente, una lista auxiliar que dependa de la elección anterior (con FILTRAR o con nombres definidos e INDIRECTO) y una validación de datos de tipo Lista que apunte a esa lista.</p>
<h3>¿Qué significa el signo # en la validación de datos?</h3>
<p>Es el operador de derrame: se refiere a todo el rango que ocupa el resultado de una fórmula de matriz dinámica, así la lista se ajusta sola.</p>
<h3>¿Funciona en versiones antiguas de Excel?</h3>
<p>El método clásico, sí. UNICOS, FILTRAR y ORDENAR requieren Excel 2021 o Microsoft 365.</p>
<h3>¿Por qué la segunda lista conserva el valor viejo al cambiar la primera?</h3>
<p>Porque la validación solo controla lo que se escribe, no los valores ya presentes. Agrega una celda de verificación que confirme que la combinación existe.</p>
<h3>¿Qué hago con nombres con espacios en el método clásico?</h3>
<p>Los nombres definidos no admiten espacios: usa guion bajo en el nombre y SUSTITUIR en la fórmula INDIRECTO.</p>

<p class="notice"><strong>Pruébalo ahora.</strong> Descarga la <a href="/descargas/listas-dependientes/listas-desplegables-dependientes.xlsx">plantilla de listas dependientes</a>, cambia los datos de la hoja "Listas" por los tuyos y conserva la celda de verificación. Incluye ambos métodos y una hoja de problemas y soluciones. El método moderno requiere Excel 2021 o Microsoft 365.</p>

<h2>Para pensar</h2>
<p>Una lista desplegable evita que cada persona escriba el dato a su manera, pero también decide qué opciones existen. <strong>¿Quién debería controlar las listas de un formulario (quien lo diseña, quien lo usa o quien responde por los datos)? Y cuando una lista no incluye la realidad de alguien (un municipio nuevo, un nombre distinto), ¿es la lista la que debe cambiar o la persona la que debe ajustarse?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:pasos}}' => $img('listas-dependientes-pasos', 467, 'Cinco pasos del método moderno: una sola fuente, primera lista con ORDENAR y ÚNICOS, lista dependiente con FILTRAR, validación con referencia al derrame y una celda de verificación.', 'Cinco pasos con ÚNICOS, FILTRAR y el derrame.'),
    '{{img:comparacion}}' => $img('listas-dependientes-comparacion', 499, 'Tabla que compara el método clásico con INDIRECTO y el moderno con derrames: versión de Excel, preparación, qué pasa al agregar datos y nombres con espacios.', 'Dos formas de encadenar listas.'),
]);

return [
    'slug' => 'listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla',
    'title' => 'Listas desplegables dependientes en Excel: el método clásico, el moderno y la verificación que casi nadie agrega',
    'excerpt' => 'Cómo encadenar listas desplegables en Excel (departamento, municipio, institución) con INDIRECTO y con ÚNICOS y FILTRAR, una celda de verificación contra combinaciones imposibles y una plantilla descargable probada en Excel.',
    'seo_title' => 'Listas desplegables dependientes en Excel (plantilla)',
    'seo_description' => 'Cómo crear listas desplegables dependientes en Excel con INDIRECTO y con FILTRAR y UNICOS, con verificación de combinaciones y plantilla descargable.',
    'focus_keyword' => 'listas desplegables dependientes en Excel',
    'cover' => '/assets/img/articulos/listas-dependientes/listas-dependientes-portada',
    'cover_alt' => 'Portada "Listas desplegables dependientes en Excel: el método clásico y el moderno" con una tarjeta de tres listas encadenadas: departamento Antioquia, municipio Envigado, institución I. E. Ejemplo 03 y la verificación "Combinación válida".',
    'published_at' => '2026-12-03 12:00:00',
    'content_html' => $html,
];
