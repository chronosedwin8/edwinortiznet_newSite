<?php

declare(strict_types=1);

// Tutorial: "El archivo CSV que destruye tus datos". Las pruebas (doble clic, Power Query, VALOR.NUMERO, FECHA, TEXTO y guardado como
// CSV UTF-8) se hicieron en Microsoft Excel 16 con configuración regional de Colombia el 9 de octubre de 2026 con el paquete de práctica
// public/descargas/csv-excel/practica-csv-excel.zip. Nowdoc: las figuras van con marcadores {{img:…}} y el código se escapa al final.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/csv-excel-fechas-cedulas-pesos/' . $name;
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
<p>Te descargan el listado de clientes del sistema de la empresa, del banco o de la plataforma de notas. Es un archivo .csv, haces doble clic y se abre en Excel. Todo parece normal, hasta que notas que el cliente <code>000101</code> ahora es <code>101</code>, que la cuenta de 16 dígitos termina en ceros, que la referencia <code>3-4</code> dice "3-abr" y que la suma de la columna de valores no cuadra. <strong>Excel no se equivocó: adivinó</strong>, y adivinó mal.</p>
<p>En este tutorial te muestro por qué pasa, cómo importar un CSV sin que Excel "interprete" nada, cómo reparar un archivo que ya abriste y cómo exportar sin sorpresas. Todo con un <a href="/descargas/csv-excel/practica-csv-excel.zip">archivo de práctica descargable</a> con registros deliberadamente problemáticos, y probado en Microsoft Excel con configuración regional de Colombia el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Un CSV es solo texto: no guarda tipos, formatos ni idioma. Al hacer doble clic, Excel decide el tipo de cada dato con la configuración regional de Windows. Importa con <em>Datos &gt; Obtener datos &gt; Desde texto o CSV</em>, elige UTF-8 y el delimitador, no detectes tipos y define tú el tipo de cada columna: los identificadores, siempre como texto.</p>

<h2>Por qué Excel daña tus datos al abrir un CSV</h2>
<p>Un archivo CSV ("valores separados por comas") no es un libro de Excel: es un texto plano donde cada línea es una fila y un separador marca las columnas. No dice si <code>000101</code> es un número o un código, si <code>04/03/2026</code> es 4 de marzo o 3 de abril, ni si <code>1.250.000,50</code> usa el punto como separador de miles. Al abrirlo con doble clic, Excel convierte todo lo que "parece" número o fecha usando <strong>la configuración regional de tu computador</strong>. En un Windows configurado para Colombia, el decimal es la coma, el separador de miles es el punto y el separador de listas es el punto y coma; en uno configurado para Estados Unidos es al revés.</p>
<p>Con el archivo de práctica (12 clientes inventados) esto fue lo que hizo Excel al abrirlo con doble clic:</p>
{{img:danos}}
<p>Hay cinco familias de daños, y conviene reconocerlas por separado:</p>
<ol>
<li><strong>Separador equivocado.</strong> Un CSV "de Estados Unidos" separa con comas; un Excel colombiano espera punto y coma. Resultado: todo el archivo queda en la columna A. Si lo "arreglas" con Texto en columnas sin cuidado, los valores como <code>"1,250,000.50"</code> se parten por la mitad.</li>
<li><strong>Decimales y miles.</strong> <code>1,250,000.50</code> y <code>1.250.000,50</code> son el mismo número escrito con reglas distintas. Si el archivo y tu Excel no coinciden, el valor se lee como texto o con otro valor, y la suma de la columna deja de cuadrar sin avisar.</li>
<li><strong>Fechas ambiguas.</strong> <code>04/03/2026</code> es el 4 de marzo en un archivo de Estados Unidos y el 3 de abril en uno colombiano. Si el día es mayor que 12 (<code>04/15/2026</code>) el error se nota; si es 12 o menos, la fecha queda equivocada <strong>y nadie se entera</strong>.</li>
<li><strong>Ceros iniciales, códigos y números largos.</strong> <code>000101</code> pasa a <code>101</code>. Una referencia como <code>3-4</code> se vuelve "3-abr", <code>12E3</code> se vuelve 12.000 en notación científica y <code>1E5</code> se vuelve 100.000. Y cualquier número de más de 15 cifras (cuentas, tarjetas, algunos identificadores) pierde precisión: Excel guarda <a href="https://support.microsoft.com/office/excel-specifications-and-limits-1672b34d-7043-467e-8e27-269d656771c3">15 dígitos significativos</a> y reemplaza el resto por ceros. Este último daño es irreversible: <code>1234567890123401</code> queda como <code>1234567890123400</code>.</li>
<li><strong>Tildes dañadas.</strong> Si el archivo está en UTF-8 sin marca BOM, Excel lo lee como ANSI y "Bogotá" se convierte en "BogotÃ¡".</li>
</ol>
<p>No es un problema menor ni exclusivo de los contadores. En 2016, un equipo revisó 35.175 archivos suplementarios de 18 revistas científicas y encontró <a href="https://genomebiology.biomedcentral.com/articles/10.1186/s13059-016-1044-7">errores de nombres de genes causados por Excel en 704 de 3.597 artículos con listas de genes (19,6 %)</a>: símbolos como SEPT2 o MARCH1 se convertían en fechas. La comunidad científica terminó renombrando genes para evitar el problema. En tu pyme el equivalente son facturas con cédulas, NIT o referencias dañadas, y listados de estudiantes con documentos de identidad alterados.</p>

<h2>La forma correcta: importar con Power Query, no abrir con doble clic</h2>
<p>La solución es dejar de "abrir" el CSV y empezar a <strong>importarlo</strong>, diciéndole a Excel qué es cada cosa. Es el procedimiento que <a href="https://support.microsoft.com/en-us/office/import-or-export-text-txt-or-csv-files-5250ac4c-663c-47ce-937b-339e391393ba">documenta Microsoft</a> para archivos de texto y CSV. Los pasos (los nombres de los menús pueden variar un poco según tu versión):</p>
<ol>
<li><strong>Datos &gt; Obtener datos &gt; Desde un archivo &gt; Desde texto o CSV</strong> y selecciona el archivo.</li>
<li>En la vista previa, elige <strong>Origen del archivo: 65001 Unicode (UTF-8)</strong> y el <strong>delimitador</strong> correcto (punto y coma, coma o tabulación).</li>
<li>En <strong>Detección de tipos de datos</strong>, elige <strong>No detectar tipos de datos</strong> y pulsa <strong>Transformar datos</strong>. Así todo llega como texto y nada se altera.</li>
<li>En el Editor de Power Query, usa la primera fila como encabezados y define el tipo de cada columna. Los identificadores (cédula, NIT, cuenta, código, teléfono, referencia) se dejan como <strong>Texto</strong>. Para la fecha y el valor, clic derecho en la columna &gt; <strong>Cambiar tipo &gt; Usando configuración regional…</strong> y elige la del archivo: <em>Español (Colombia)</em> si viene con día/mes/año y decimales con coma, o <em>Inglés (Estados Unidos)</em> si viene con mes/día/año y decimales con punto.</li>
<li><strong>Cerrar y cargar.</strong> La consulta queda guardada: si mañana llega otro archivo con el mismo formato, basta con <em>Actualizar</em>.</li>
</ol>
{{img:pasos}}
<p>Si prefieres ver el código (Editor avanzado), esta consulta importa el archivo colombiano del paquete de práctica; para el de Estados Unidos solo cambian el delimitador, la ruta y la configuración regional:</p>
<pre><code>// Archivo colombiano: separador ";", decimal con coma, fecha día/mes/año
let
    Origen = Csv.Document(File.Contents("C:\RUTA\clientes-formato-colombia.csv"),
        [Delimiter = ";", Columns = 8, Encoding = 65001, QuoteStyle = QuoteStyle.Csv]),
    Encabezados = Table.PromoteHeaders(Origen, [PromoteAllScalars = true]),
    Tipos = Table.TransformColumnTypes(Encabezados,
        {{"id_cliente", type text}, {"cedula", type text}, {"fecha", type date},
         {"valor_cop", type number}, {"cuenta", type text}, {"referencia", type text},
         {"telefono", type text}, {"ciudad", type text}}, "es-CO")
in
    Tipos

// Archivo de Estados Unidos: cambia solo estas tres cosas
//   File.Contents("C:\RUTA\clientes-formato-estados-unidos.csv")
//   Delimiter = ","
//   ... }}, "en-US")</code></pre>
<p>Con esta consulta, <strong>los dos archivos dan el mismo resultado</strong> y verificable: 12 filas, la suma de <code>valor_cop</code> es 9.067.524,45, el cliente 000101 conserva sus ceros, la cuenta mantiene sus 16 dígitos, la fecha de la primera fila es el 3 de abril de 2026 (no el 4 de marzo), <code>3-4</code> y <code>12E3</code> siguen intactos y las tildes se ven bien.</p>

<h2>Si ya abriste el archivo: qué se puede reparar y qué no</h2>
<p>Algunos daños se arreglan con fórmulas; otros no tienen vuelta atrás. Estas fórmulas las probé en Excel en español:</p>
<table>
<thead><tr><th>Problema</th><th>¿Se repara?</th><th>Fórmula (Excel en español)</th></tr></thead>
<tbody>
<tr><td>Ceros iniciales perdidos (código de 6 dígitos)</td><td>Sí, si conoces la longitud</td><td><code>=TEXTO(A2;"000000")</code></td></tr>
<tr><td>Valor en texto con formato de EE. UU. ("1,250,000.50")</td><td>Sí</td><td><code>=VALOR.NUMERO(A2;".";",")</code></td></tr>
<tr><td>Valor en texto con formato colombiano ("1.250.000,50")</td><td>Sí</td><td><code>=VALOR.NUMERO(A2;",";".")</code></td></tr>
<tr><td>Fecha en texto mes/día/año ("04/03/2026")</td><td>Sí</td><td><code>=FECHA(DERECHA(A2;4);IZQUIERDA(A2;2);EXTRAE(A2;4;2))</code></td></tr>
<tr><td>Valores con símbolo de pesos ("$ 1.250.000")</td><td>Sí, quitando el símbolo y los espacios</td><td><code>=VALOR.NUMERO(SUSTITUIR(SUSTITUIR(A2;"$";"");" ";"");",";".")</code></td></tr>
<tr><td>Número de 16 dígitos con precisión perdida</td><td><strong>No</strong>: hay que volver a importar</td><td>—</td></tr>
<tr><td>Referencia "3-4" convertida en "3-abr"</td><td><strong>No</strong> de forma fiable: el original se perdió</td><td>—</td></tr>
<tr><td>Tildes dañadas ("BogotÃ¡")</td><td>Se evita reimportando con UTF-8</td><td>—</td></tr>
</tbody>
</table>
<p>La regla práctica: <strong>si el dato se perdió al abrir, repara volviendo al archivo original</strong>, no sobre el libro dañado. Y guarda siempre una copia intacta del CSV.</p>

<h2>Exportar sin sorpresas: el caso del "CSV UTF-8"</h2>
<p>El mismo cuidado aplica al revés. En un Excel con configuración de Colombia, <em>Guardar como &gt; CSV UTF-8 (delimitado por comas)</em> genera un archivo con marca BOM (la que permite leer bien las tildes), pero separa las columnas con <strong>punto y coma</strong> y escribe los decimales con <strong>coma</strong>: una fila queda como <code>1250000,5;Bogotá</code>. Es correcto para otro Excel colombiano, y un desastre para un sistema que espera comas y puntos. Antes de enviar un CSV, acuerda con quien lo recibe: separador de campos, separador decimal, formato de fecha y codificación. Si el destino es una plataforma o un ERP, lo más seguro es pedir fechas en formato ISO (<code>2026-04-03</code>), que no se confunde en ningún país.</p>

<h2>Colombia, Latinoamérica y el mundo: por qué es un problema de todos</h2>
<p>El choque de formatos es global. Colombia, Argentina, Chile, Brasil y España usan la coma como separador decimal; Estados Unidos, el Reino Unido y México usan el punto. Una pyme colombiana que exporta ventas a un cliente en México, o que recibe el catálogo de un proveedor de Estados Unidos, vive este problema cada semana. Lo que cambia entre contextos es el costo: una empresa grande puede tener un equipo de datos; una pyme, un colegio o una oficina de contabilidad suele tener a una persona con Excel. Para ellas, aprender a importar bien un CSV es de las inversiones de menor costo y mayor retorno.</p>
<ul>
<li><strong>Contadores y pymes:</strong> las cédulas, NIT y números de cuenta son identificadores, no números: nunca se suman ni se les aplican formatos numéricos.</li>
<li><strong>Docentes y colegios:</strong> los listados de estudiantes traen documentos con ceros, códigos de grupo como <code>10-11</code> (que Excel convierte en fecha) y tildes. Un listado dañado produce boletines con datos equivocados.</li>
<li><strong>Equipos de sistemas:</strong> exigir UTF-8, un separador explícito y fechas ISO en cada exportación evita la mayoría de estos errores desde el origen.</li>
</ul>

<h2>Checklist: antes y después de importar un CSV</h2>
<p>Este es el recurso aplicable. Imprímelo o pégalo como una hoja "Control" en tus libros:</p>
<table>
<thead><tr><th>Momento</th><th>Verificación</th></tr></thead>
<tbody>
<tr><td><strong>Antes</strong></td><td>Abre el CSV en el Bloc de notas: ¿cuál es el separador? ¿cómo se escriben los decimales y las fechas? ¿se ven bien las tildes?</td></tr>
<tr><td><strong>Antes</strong></td><td>Pregunta a quien lo generó el formato y la codificación. Guarda una copia del original sin tocar.</td></tr>
<tr><td><strong>Al importar</strong></td><td>Origen 65001 (UTF-8), delimitador correcto, <em>No detectar tipos de datos</em>.</td></tr>
<tr><td><strong>Al importar</strong></td><td>Identificadores (cédula, NIT, cuenta, teléfono, código, referencia) como <strong>Texto</strong>; fecha y valores con la configuración regional del archivo.</td></tr>
<tr><td><strong>Después</strong></td><td>Cuenta las filas y compáralas con el total del sistema de origen.</td></tr>
<tr><td><strong>Después</strong></td><td>Compara la suma de valores con el total del origen (en la práctica: 9.067.524,45).</td></tr>
<tr><td><strong>Después</strong></td><td>Revisa a ojo los identificadores: longitud, ceros iniciales, ningún "E+".</td></tr>
<tr><td><strong>Después</strong></td><td>Revisa 3 fechas con día menor o igual a 12 contra el original.</td></tr>
<tr><td><strong>Al exportar</strong></td><td>Acuerda separador, decimal, fecha (ISO) y codificación UTF-8 con quien recibe el archivo.</td></tr>
</tbody>
</table>

<h2>Herramientas para trabajar con tus datos sin dañarlos</h2>
<p>Si tu trabajo es mover datos entre archivos, correos y documentos, estos problemas aparecen todos los días. El <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">Aplicativo para combinar datos de Excel en documentos separados DOCX y PDF</a> toma tu tabla (con cédulas, fechas y valores bien tipados) y genera un documento por cada fila; y <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">Enviar correos masivos con adjuntos y copias CC y CCO</a> envía cada correo con su adjunto desde un listado. Ambos funcionan con datos limpios: un identificador dañado en la tabla se convierte en una carta o un correo equivocados. Si necesitas mostrar los valores en letras en facturas o cheques, usa el <a href="/herramientas/numero-a-letras/">convertidor de número a letras gratuito</a>.</p>
{{productos:aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf,enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco}}
<p>Y para diagnosticar una tabla antes de usarla, la descarga gratuita <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel con IA</a> incluye la macro <code>PerfilarDatos</code>, que revisa tipos, vacíos y valores raros de tu hoja. Si quieres seguir con Excel, mira <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">cómo automatizar tareas en Excel y reducir errores</a>, <a href="/tablas-dinamicas-en-excel-analiza-datos-como-un-profesional/">tablas dinámicas</a> y <a href="/excel-esta-muerto-era-de-la-ia/">¿Excel está muerto en la era de la IA?</a>. Y mi lista de reproducción de Excel está <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ">en YouTube</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Por qué Excel quita los ceros a la izquierda al abrir un CSV?</h3>
<p>Porque interpreta <code>000101</code> como el número 101. Importa el archivo con Power Query y deja esa columna como Texto, o formatea la columna como Texto antes de pegar los datos.</p>
<h3>¿Cómo evito que Excel convierta mis códigos en fechas?</h3>
<p>Los códigos como <code>3-4</code> o <code>10-11</code> se convierten en fecha al abrir con doble clic. Importa con <em>No detectar tipos de datos</em> y deja la columna como Texto.</p>
<h3>¿Cómo abro un CSV con punto y coma o con comas en Excel?</h3>
<p>Con <em>Datos &gt; Obtener datos &gt; Desde texto o CSV</em>, eligiendo el delimitador correcto en la vista previa. Así no dependes del separador de listas de Windows.</p>
<h3>¿Cómo arreglo las tildes mal escritas (BogotÃ¡)?</h3>
<p>Vuelve a importar el archivo y elige el origen 65001 Unicode (UTF-8). Guardar de nuevo el libro dañado no corrige las letras.</p>
<h3>¿Se puede recuperar un número largo que quedó en notación científica?</h3>
<p>No, si Excel ya redondeó a 15 dígitos: ese dato se perdió. Hay que volver al CSV original e importar la columna como Texto.</p>

<p class="notice"><strong>Practica ahora.</strong> Descarga el <a href="/descargas/csv-excel/practica-csv-excel.zip">archivo de práctica (ZIP)</a>, ábrelo con doble clic y mira qué se daña; luego impórtalo con Power Query y compara con la lista de verificación. Cuando tu trabajo diario sea mover estos datos a documentos y correos, el <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">Aplicativo para combinar datos de Excel</a> y los <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">correos masivos con adjuntos</a> te ahorran las horas; y si quieres que te acompañe a implementarlo, está la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a>.</p>

<h2>Para pensar</h2>
<p>Un formato con décadas de antigüedad, pensado para "pasar datos" entre programas, sigue moviendo nóminas, facturas y calificaciones, y nadie lo enseña. <strong>Si un error de importación cambia la cédula de un estudiante o el valor de una factura, ¿de quién es la responsabilidad: de quien exportó el archivo, de quien lo abrió sin verificar o de un software que prefiere adivinar antes que preguntar?</strong> ¿Y deberíamos exigir, como en cualquier otro control de calidad, que los datos lleguen siempre con su manual de formato?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:danos}}' => $img('csv-excel-fechas-cedulas-pesos-danos', 600, 'Tabla con lo que hizo Excel al abrir el CSV con doble clic: 000101 pasó a 101, la cuenta de 16 dígitos a notación científica, 3-4 a 3-abr, 12E3 a 1,20E+04, Bogotá a BogotÃ¡ y todo el archivo de Estados Unidos quedó en la columna A.', 'Qué hizo Excel con cada valor del archivo de práctica al abrirlo con doble clic (Excel 16, configuración regional de Colombia).'),
    '{{img:pasos}}' => $img('csv-excel-fechas-cedulas-pesos-pasos', 427, 'Cinco pasos para importar un CSV con Power Query: Obtener datos, origen UTF-8 y delimitador, no detectar tipos, definir texto o configuración regional y Cerrar y cargar.', 'Cinco pasos para importar un CSV sin que Excel adivine.'),
]);

return [
    'slug' => 'csv-excel-fechas-cedulas-pesos-importar-correctamente',
    'title' => 'El archivo CSV que destruye tus datos: cómo importar correctamente fechas, números, cédulas y valores en pesos colombianos',
    'excerpt' => 'Por qué Excel cambia ceros, fechas y números largos al abrir un CSV, cómo importarlo bien con Power Query, qué se puede reparar con fórmulas y un archivo de práctica descargable.',
    'seo_title' => 'Importar un CSV en Excel sin dañar fechas ni cédulas',
    'seo_description' => 'Cómo importar un CSV en Excel sin perder ceros, cédulas ni fechas: Power Query, UTF-8, separadores y valores en pesos, con archivo de práctica.',
    'focus_keyword' => 'importar CSV en Excel',
    'cover' => '/assets/img/articulos/csv-excel-fechas-cedulas-pesos/csv-excel-fechas-cedulas-pesos-portada',
    'cover_alt' => 'Portada con el título "El archivo CSV que destruye tus datos" y una tarjeta que muestra cómo Excel cambia 000101 por 101, un número de 16 dígitos por notación científica, 3-4 por 3-abr y Bogotá por BogotÃ¡.',
    'published_at' => '2026-10-15 12:00:00',
    'content_html' => $html,
];
