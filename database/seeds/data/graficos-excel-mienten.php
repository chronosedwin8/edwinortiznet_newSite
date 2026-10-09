<?php

declare(strict_types=1);

// «Las gráficas de Excel también pueden mentir: cinco errores que distorsionan tus conclusiones». Todos los gráficos se hicieron en Microsoft Excel 16
// (macro de VBA) con datos hipotéticos; la macro RevisarEjes se probó: de tres gráficos de columnas detectó solo el que tenía el eje truncado. En el
// ejemplo de correlación (datos inventados), COEF.DE.CORREL dio 0,998 y COEFICIENTE.R2 0,996. Fecha de verificación: 9 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/graficos-excel-mienten/' . $name;
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
<p>Un gráfico de Excel se hace en tres clics y parece objetivo: es «el dato», dibujado. Pero un gráfico no es un dato: es una <strong>decisión de presentación</strong>, y esa decisión puede inflar una diferencia, esconder una caída o inventar una relación que no existe. A veces es deliberado; casi siempre es descuido, porque Excel elige por ti el eje, la escala y el estilo.</p>
<p>En este artículo te muestro <strong>cinco errores</strong> con su versión engañosa y su versión corregida (todos hechos en Excel con datos hipotéticos), una macro de VBA que detecta uno de ellos en tus libros y una <strong>lista de comprobación</strong> para revisar un gráfico antes de presentarlo. Probado en Microsoft Excel el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Los cinco errores: eje truncado en barras, escalas distintas entre gráficos comparables, periodo o datos elegidos a conveniencia, correlación presentada como causa y ejes dobles ajustados para forzar una relación. La regla común: <strong>el gráfico debe dejar ver lo que dicen los datos, no lo que te conviene que digan</strong>.</p>

<h2>Error 1: el eje truncado</h2>
<p>En un gráfico de barras o columnas, <strong>la longitud de la barra representa el valor</strong>. Si el eje no empieza en cero, la longitud deja de ser proporcional y una diferencia pequeña se ve enorme. Aquí, las tasas de aprobación de tres colegios (92 %, 94 % y 93 %) con el eje cortado en 91 hacen que el B parezca tener el triple que el A:</p>
{{img:c1}}
<p><strong>Cómo corregirlo en Excel:</strong> clic derecho sobre el eje vertical &gt; <em>Dar formato al eje</em> &gt; <em>Límites</em> &gt; <em>Mínimo</em> = 0. En gráficos de líneas, un eje que no empieza en cero es aceptable si el objetivo es mostrar la variación, pero conviene decirlo y no exagerarla.</p>

<h2>Error 2: escalas inconsistentes entre gráficos comparables</h2>
<p>Excel ajusta la escala de cada gráfico a sus propios datos. Si pones dos gráficos lado a lado, cada uno con su escala, <strong>dos series muy distintas se ven iguales</strong>. En el ejemplo, la Sede Sur vende diez veces más que la Norte, pero al mirar los dos gráficos juntos con escalas automáticas parecen idénticos:</p>
{{img:c2}}
<p><strong>Cómo corregirlo:</strong> fija el mismo mínimo y máximo en los ejes de todos los gráficos que se van a comparar (aquí, 0 a 160), o pon ambas series en un mismo gráfico.</p>

<h2>Error 3: selección sesgada del periodo o de los datos</h2>
<p>Con los mismos datos puedes contar historias opuestas según la ventana que elijas. Mostrar solo de enero a julio dice «¡crecimiento!»; el año completo revela que desde agosto las ventas caen:</p>
{{img:c3}}
<p><strong>Cómo corregirlo:</strong> muestra el periodo completo, o justifica el recorte (por ejemplo, «desde que cambió el precio»). Si comparas con un año anterior, compara los mismos meses. Y pregúntate qué datos quedaron fuera: colegios que no respondieron, clientes perdidos, meses sin registro.</p>

<h2>Error 4: confundir correlación con causalidad</h2>
<p>Dos series pueden moverse juntas sin que una cause la otra. En el ejemplo (datos inventados), el helado vendido y las quemaduras de sol tienen una correlación altísima, y Excel lo confirma:</p>
<pre><code>=COEF.DE.CORREL(A2:A13;B2:B13)     → 0,998
=COEFICIENTE.R2(B2:B13;A2:A13)     → 0,996</code></pre>
<p>Pero el helado no produce quemaduras: ambos dependen del calor y de la temporada. Esa tercera variable oculta se llama <em>variable de confusión</em>.</p>
{{img:c4}}
<p><strong>Cómo evitarlo:</strong> antes de escribir «X causa Y», pregúntate si hay una tercera variable que afecte a ambas, si el orden en el tiempo tiene sentido y si hay un mecanismo plausible. Una correlación alta es una pista para investigar, no una prueba. Las <a href="https://www.tylervigen.com/spurious-correlations">correlaciones espurias</a> (como las que recopila Tyler Vigen) muestran que con suficientes series siempre aparece alguna que «coincide».</p>

<h2>Error 5: ejes dobles que fuerzan una relación</h2>
<p>El eje secundario de Excel permite graficar dos magnitudes distintas, pero también permite <strong>ajustar los dos ejes hasta que las líneas coincidan</strong>. En el ejemplo, la inversión en publicidad varía menos del 5 % y las visitas, menos del 7 %: casi no hay movimiento. Con dos ejes recortados, ambas líneas parecen bailar juntas:</p>
{{img:c5}}
<p><strong>Cómo corregirlo:</strong> evita los ejes dobles cuando no sean imprescindibles; mejor usa un <em>índice</em> (cada serie dividida por su valor inicial, por 100), que pone ambas en la misma escala, o dos gráficos separados con ejes que empiecen en cero.</p>

<h2>Una macro para detectar ejes truncados</h2>
<p>Si recibes libros con muchos gráficos, esta función de VBA recorre todas las hojas y lista los gráficos de columnas o barras cuyo eje de valores no empieza en cero. La probé con tres gráficos de columnas (uno con el eje en 90, uno en 0 y uno automático) y señaló solo el primero:</p>
<pre><code>Public Function RevisarEjes(Optional libro As Workbook) As String
    Dim ws As Worksheet, co As ChartObject, ax As Axis, msg As String, tipo As Long
    If libro Is Nothing Then Set libro = ActiveWorkbook
    For Each ws In libro.Worksheets
        For Each co In ws.ChartObjects
            tipo = co.Chart.ChartType
            If tipo = xlColumnClustered Or tipo = xlColumnStacked Or tipo = xlBarClustered Or tipo = xlBarStacked Then
                Set ax = co.Chart.Axes(xlValue)
                If Not ax.MinimumScaleIsAuto Then
                    If ax.MinimumScale <> 0 Then msg = msg & ws.Name & " / " & co.Name & ": el eje empieza en " & ax.MinimumScale & vbLf
                End If
            End If
        Next co
    Next ws
    If msg = "" Then msg = "Ningun grafico de barras o columnas tiene el eje truncado."
    RevisarEjes = msg
End Function

Sub MostrarRevision()
    MsgBox RevisarEjes(ActiveWorkbook)
End Sub</code></pre>
<p>Úsala como control en la hoja «Control» de tus informes (como el que propongo en <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el artículo sobre el riesgo oculto de Excel</a>). Para guardar macros, el libro debe ser .xlsm, y recuerda que Microsoft bloquea por defecto las macros de archivos descargados de internet.</p>

<h2>Colombia, Latinoamérica y el mundo: dónde importan estas distorsiones</h2>
<p>Los gráficos engañosos no son un problema solo de la prensa o de la política. Se cuelan en el informe de resultados que el colegio presenta a las familias, en el comparativo de ventas que llega al gerente, en la presentación de una licitación o en una tesis. En el mundo, los especialistas en visualización llevan décadas advirtiendo sobre el «factor de mentira» de los gráficos; en Colombia y Latinoamérica, donde buena parte de las decisiones de pymes, colegios y oficinas se apoyan en gráficos hechos en Excel por una sola persona, el riesgo es mayor porque rara vez alguien los revisa. Para un <strong>docente o directivo</strong>, la lección es doble: construir gráficos honestos y enseñar a los estudiantes a leer los de otros (una habilidad clave de alfabetización de datos). Para un <strong>gerente</strong>, pedir siempre el eje, el periodo y la fuente. Para las <strong>familias</strong>, mirar dónde empieza el eje antes de creerle a un gráfico.</p>

<h2>Lista de comprobación: revisa un gráfico antes de presentarlo</h2>
<p>Este es el recurso aplicable. Úsalo con un informe tuyo:</p>
<table>
<thead><tr><th>Pregunta</th><th>Si la respuesta es «no»…</th></tr></thead>
<tbody>
<tr><td>¿En barras y columnas, el eje de valores empieza en cero?</td><td>Corrige el límite mínimo o cambia a un gráfico de líneas y avisa del recorte.</td></tr>
<tr><td>¿Los gráficos que se comparan tienen la misma escala?</td><td>Fija mínimo y máximo iguales, o ponlos en un mismo gráfico.</td></tr>
<tr><td>¿Muestro todo el periodo relevante, o justifiqué el recorte?</td><td>Amplía la ventana o explica el criterio.</td></tr>
<tr><td>¿Incluí todos los datos que corresponden (sin omitir casos incómodos)?</td><td>Revisa qué quedó fuera y por qué.</td></tr>
<tr><td>¿Afirmo una causa solo con una correlación?</td><td>Cambia el lenguaje («se asocia con») o busca más evidencia.</td></tr>
<tr><td>¿Uso ejes dobles?</td><td>Prefiere un índice o dos gráficos separados.</td></tr>
<tr><td>¿El título dice lo que muestra el gráfico (no una conclusión exagerada)?</td><td>Describe el dato; deja la interpretación al texto.</td></tr>
<tr><td>¿Están claros las unidades, la fuente y el periodo?</td><td>Agrega nota al pie con fuente y fecha.</td></tr>
<tr><td>¿Alguien más lo revisó con ojos nuevos?</td><td>Pide una segunda lectura antes de enviarlo.</td></tr>
</tbody>
</table>

<h2>Herramientas para trabajar tus datos con criterio</h2>
<p>Un buen gráfico empieza con datos limpios. La descarga gratuita <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel con IA</a> incluye la macro <code>PerfilarDatos</code>, que revisa tipos, vacíos y valores raros de tu tabla antes de graficar, y en el artículo <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">cómo importar un CSV correctamente</a> verás cómo evitar que Excel dañe tus datos desde el origen. Si quieres que alguien revise un informe con gráficos o te ayude a montar plantillas con controles, la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a> te acompaña; y para presentar resultados sin repetir trabajo, el <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">Combinar correspondencia y generar PDF individuales</a> arma documentos por persona a partir de tu hoja de Excel. Aprende más en mi <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ">lista de Excel en YouTube</a>.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,combinar-correspondencia-y-generar-pdf-individuales}}
<p>Sigue leyendo: <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a>, <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">cómo automatizar Excel</a> y <a href="/excel-esta-muerto-era-de-la-ia/">¿Excel está muerto en la era de la IA?</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Un gráfico de barras siempre debe empezar en cero?</h3>
<p>Sí, porque la longitud de la barra representa el valor. En un gráfico de líneas puedes recortar el eje para mostrar la variación, pero conviene avisarlo y no exagerar.</p>
<h3>¿Cómo cambio el mínimo del eje en Excel?</h3>
<p>Clic derecho sobre el eje &gt; Dar formato al eje &gt; Límites &gt; Mínimo. Fija 0 (o el valor que decidas) y comprueba que el máximo sea razonable.</p>
<h3>¿Una correlación alta prueba una causa?</h3>
<p>No. Puede deberse a una tercera variable, al azar o a la coincidencia en el tiempo. Úsala como pista para investigar, no como conclusión.</p>
<h3>¿Qué es mejor que un eje doble?</h3>
<p>Un índice (cada serie dividida por su valor inicial) en un solo eje, o dos gráficos separados con ejes que empiecen en cero.</p>
<h3>¿Cómo detecto gráficos truncados en un libro con muchos gráficos?</h3>
<p>Con la macro RevisarEjes de este artículo, que lista los gráficos de barras o columnas con el mínimo del eje distinto de cero.</p>

<p class="notice"><strong>Revisa un informe tuyo esta semana.</strong> Elige un informe con gráficos, aplica la lista de comprobación y corrige al menos uno. Si quieres una segunda mirada experta sobre tus informes y plantillas, escribe a la <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">asesoría PLUS</a>.</p>

<h2>Para pensar</h2>
<p>Un gráfico honesto casi siempre es menos espectacular que uno que exagera, y en una reunión gana el espectacular. <strong>Si todos sabemos que un eje recortado engaña, ¿por qué seguimos premiando los gráficos que impresionan sobre los que informan, y de quién es la responsabilidad: de quien lo dibuja, de quien lo presenta o de quien no se atreve a preguntar dónde empieza el eje?</strong> ¿Y deberíamos enseñar en el colegio a leer un gráfico con la misma seriedad con que enseñamos a leer un texto?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:c1}}' => $img('graficos-excel-mienten-c1', 480, 'Dos gráficos de columnas de la tasa de aprobación de tres colegios: a la izquierda con el eje cortado en 91, donde el colegio B parece triplicar al A; a la derecha, con el eje desde cero, donde las diferencias son pequeñas.', 'Error 1: el eje truncado exagera una diferencia pequeña.'),
    '{{img:c2}}' => $img('graficos-excel-mienten-c2', 787, 'Cuatro gráficos de columnas de las ventas de la Sede Norte y la Sede Sur: con escalas automáticas parecen iguales; con la misma escala de 0 a 160 se ve que la Sur vende diez veces más.', 'Error 2: escalas distintas hacen que series muy diferentes parezcan iguales.'),
    '{{img:c3}}' => $img('graficos-excel-mienten-c3', 480, 'Dos gráficos de líneas de ventas mensuales: a la izquierda solo de enero a julio, con crecimiento; a la derecha, el año completo, con una caída desde agosto.', 'Error 3: elegir el periodo oculta la caída.'),
    '{{img:c4}}' => $img('graficos-excel-mienten-c4', 480, 'A la izquierda, un diagrama de dispersión del helado vendido contra quemaduras de sol con correlación 0,998; a la derecha, un gráfico de líneas con temperatura, helados y quemaduras subiendo juntos con la temporada.', 'Error 4: la correlación es altísima, pero la causa común es el calor.'),
    '{{img:c5}}' => $img('graficos-excel-mienten-c5', 480, 'A la izquierda, un gráfico con dos ejes recortados donde la inversión en publicidad y las visitas parecen moverse juntas; a la derecha, los mismos datos como índice base 100, donde ambas líneas son casi planas.', 'Error 5: dos ejes recortados inventan una relación.'),
]);

return [
    'slug' => 'graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones',
    'title' => 'Las gráficas de Excel también pueden mentir: cinco errores que distorsionan tus conclusiones',
    'excerpt' => 'Cinco errores en gráficos de Excel (eje truncado, escalas distintas, datos elegidos, correlación sin causa y ejes dobles) con su versión corregida, una macro de VBA que detecta ejes truncados y una lista de comprobación.',
    'seo_title' => 'Gráficas de Excel que mienten: 5 errores y cómo corregirlos',
    'seo_description' => 'Cinco errores en gráficos de Excel (eje truncado, escalas, correlación y ejes dobles) con ejemplos, macro de VBA y lista de comprobación para corregirlos.',
    'focus_keyword' => 'gráficas de Excel engañosas',
    'cover' => '/assets/img/articulos/graficos-excel-mienten/graficos-excel-mienten-portada',
    'cover_alt' => 'Portada con el título «Las gráficas de Excel también pueden mentir: cinco errores que distorsionan tus conclusiones» y una lista de comprobación: eje en cero, escalas comparables y periodo completo marcados, y confundir correlación con causa descartado.',
    'published_at' => '2026-11-05 12:00:00',
    'content_html' => $html,
];
