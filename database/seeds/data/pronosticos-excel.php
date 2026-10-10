<?php

declare(strict_types=1);

// "Pronósticos en Excel: tendencia, estacionalidad y cuándo no confiar en el resultado". Prueba retrospectiva ejecutada en Microsoft Excel 16 (es-CO) con datos ficticios: MAPE ETS 12 meses 3,0 %, tendencia lineal 11,1 %, ingenuo estacional 13,0 %, ETS automático 15,4 %. Verificado el 9 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/pronosticos-excel/' . $name;
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
<p>Pronosticar ventas, matrículas o consumo parece una tarea para especialistas, pero Excel trae funciones y herramientas que lo hacen con unos pocos clics. El problema es que <strong>un pronóstico siempre produce un número</strong>, y un número bien presentado inspira confianza aunque el método sea inadecuado. La pregunta importante no es "¿qué dice Excel?", sino "¿cómo sé si puedo creerle?".</p>
<p>En este artículo hago algo poco común en este tipo de textos: una <strong>prueba retrospectiva</strong>. Entreno cuatro métodos con 24 meses de datos ficticios, pronostico los 12 meses siguientes y comparo con lo que realmente "ocurrió". Los resultados salieron en Microsoft Excel (versión 16, configuración regional es-CO) y el <a href="/descargas/pronosticos-excel/pronosticos-excel-ejercicios.xlsx">libro de ejercicios con soluciones</a> es descargable. Verificado el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> En la prueba, el pronóstico ETS con la estacionalidad indicada (12 meses) tuvo un error medio de 3,0 %; la tendencia lineal, 11,1 %; el método ingenuo estacional, 13,0 %; y el mismo ETS con la estacionalidad <em>detectada automáticamente</em>, 15,4 %. La lección: <strong>tendencia y estacionalidad importan, el modo automático no siempre acierta, y ningún pronóstico se acepta sin probarlo con datos que no usó para aprender</strong>. Son datos ficticios: el resultado ilustra el método, no es una regla general.</p>

<h2>Tendencia y estacionalidad: de qué hablamos</h2>
<ul>
<li><strong>Tendencia:</strong> hacia dónde va la serie a largo plazo (sube, baja, se estanca).</li>
<li><strong>Estacionalidad:</strong> un patrón que se repite en cada ciclo; por ejemplo, las ventas de uniformes de un colegio que suben en enero-febrero y en julio, cuando empiezan los periodos.</li>
<li><strong>Ruido:</strong> la variación aleatoria que ningún método explica.</li>
</ul>
<p>Los datos de la prueba son ventas mensuales ficticias de uniformes durante tres años (2022 a 2024), generadas con una tendencia creciente, picos en enero, febrero y julio, y algo de ruido. Entreno con 2022-2023 y pronostico 2024.</p>

<h2>Los cuatro métodos</h2>
<ol>
<li><strong>Ingenuo estacional:</strong> pronostica cada mes con el valor del mismo mes del año anterior. Es el método más simple y la vara mínima: si un método complejo no lo supera, no vale la pena.</li>
<li><strong>Tendencia lineal</strong> (<code>PRONOSTICO.LINEAL</code> en español, <code>FORECAST.LINEAR</code> en inglés): traza una recta por los datos. Ignora la estacionalidad.</li>
<li><strong>ETS con la estacionalidad indicada</strong> (<code>PRONOSTICO.ETS</code> / <code>FORECAST.ETS</code> con 12 como estacionalidad): suavizado exponencial triple, que modela nivel, tendencia y estacionalidad.</li>
<li><strong>ETS con estacionalidad automática:</strong> la misma función sin indicar el ciclo, para que Excel lo detecte.</li>
</ol>
<pre><code>' En español (PRONOSTICO.ETS.ESTACIONALIDAD usa los mismos rangos)
=PRONOSTICO.LINEAL(A28; B$4:B$27; A$4:A$27)
=PRONOSTICO.ETS(A28; B$4:B$27; A$4:A$27; 12)
=PRONOSTICO.ETS(A28; B$4:B$27; A$4:A$27)
=PRONOSTICO.ETS.ESTACIONALIDAD(B$4:B$27; A$4:A$27)

' En inglés
=FORECAST.LINEAR(A28, B$4:B$27, A$4:A$27)
=FORECAST.ETS(A28, B$4:B$27, A$4:A$27, 12)
=FORECAST.ETS(A28, B$4:B$27, A$4:A$27)
=FORECAST.ETS.SEASONALITY(B$4:B$27, A$4:A$27)</code></pre>
<p>Cada fórmula pronostica la fecha de A28 usando solo los datos de las filas 4 a 27 (los 24 meses de entrenamiento), de modo que el método no "ve" el futuro.</p>

<h2>Los resultados</h2>
{{img:prueba}}
<p>El error porcentual absoluto medio (MAPE) de cada método en los 12 meses de prueba:</p>
{{img:error}}
<table>
<thead><tr><th>Método</th><th>MAPE</th><th>Qué pasó</th></tr></thead>
<tbody>
<tr><td><strong>ETS con 12 meses indicados</strong></td><td>3,0 %</td><td>Capturó los picos de enero-febrero y julio</td></tr>
<tr><td><strong>Tendencia lineal</strong></td><td>11,1 %</td><td>Una recta casi plana: ignoró por completo la estacionalidad</td></tr>
<tr><td><strong>Ingenuo estacional</strong></td><td>13,0 %</td><td>Acertó la forma, pero no el crecimiento: subestimó todo el año</td></tr>
<tr><td><strong>ETS automático</strong></td><td>15,4 %</td><td>Excel detectó una estacionalidad de 6 meses y no de 12: sobrestimó la mayor parte del año</td></tr>
</tbody>
</table>
<p>La sorpresa es la última fila. Al pedirle a Excel que detectara la estacionalidad (<code>PRONOSTICO.ETS.ESTACIONALIDAD</code>), devolvió <strong>6</strong>, porque en los datos hay dos picos por año. El pronóstico resultante quedó peor que una simple recta. Cuando <strong>tú</strong> sabes que el ciclo es anual, indícalo: en este ejemplo bajó el error de 15,4 % a 3,0 %. Y esto no significa que lo automático siempre falle; significa que <strong>hay que comprobar</strong>.</p>

<h2>Los siete errores más comunes</h2>
<ol>
<li><strong>Extrapolar una recta sobre datos estacionales.</strong> La tendencia lineal da un número "razonable" que ignora los picos.</li>
<li><strong>Confiar en la estacionalidad automática sin revisarla.</strong> Compara lo que detecta con lo que sabes del negocio.</li>
<li><strong>No hacer una prueba retrospectiva.</strong> Si no pronosticas un periodo que ya conoces, no sabes si el método sirve.</li>
<li><strong>Muy poca historia.</strong> Para estimar estacionalidad se necesitan al menos dos ciclos completos; con 12 meses no hay cómo distinguirla del ruido.</li>
<li><strong>Ignorar los choques.</strong> Una pandemia, un cierre o un cambio de política rompen el patrón; el modelo no los puede prever.</li>
<li><strong>Entregar un solo número.</strong> Un pronóstico sin intervalo de confianza oculta la incertidumbre. En el libro, el pronóstico de enero de 2025 con los 36 meses es de unas 199 unidades, con un intervalo del 95 % de aproximadamente 189 a 208 (<code>PRONOSTICO.ETS.CONFINT</code>).</li>
<li><strong>Fechas irregulares o faltantes.</strong> Las funciones ETS necesitan una línea de tiempo con pasos constantes (por ejemplo, mensual).</li>
</ol>
<p>Y una advertencia sobre los gráficos: un pronóstico graficado con un eje recortado o con dos escalas distintas puede engañar tanto como los de <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">las gráficas que mienten</a>.</p>

<h2>El libro de ejercicios</h2>
<p>El archivo trae los 36 meses de datos, la prueba retrospectiva ya construida (con las cuatro fórmulas y los errores por mes), cinco ejercicios y sus soluciones. Algunos ejercicios: calcular el índice estacional de cada mes (en el ejemplo, enero ronda 1,24 y mayo 0,79 respecto al promedio); pronosticar enero de 2025 con intervalo de confianza; sustituir el método ingenuo por "mes del año anterior más el crecimiento promedio"; y simular un choque (una caída del 40 % en abril) para ver cómo se degradan los pronósticos. Esa última práctica enseña lo más importante: <strong>los modelos aprenden del pasado y no avisan cuando el pasado deja de servir</strong>.</p>
<p>También puedes usar el asistente de Excel ("Datos", "Hoja de previsión") que aplica ETS y dibuja el intervalo; los resultados dependen de lo que detecte, y vale la pena aplicar la misma prueba retrospectiva.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>Pronosticar bien tiene un valor práctico enorme en entornos de poca holgura: un colegio que estima matrículas para contratar docentes, una tienda que decide cuánto inventario comprar antes de la temporada escolar, una pyme que planea su flujo de caja. En Colombia, la estacionalidad del calendario escolar (calendario A y B), las primas de junio y diciembre y los días festivos crean patrones muy marcados que un buen pronóstico debe respetar; y las variaciones del dólar o de la inflación pueden romper la tendencia. Para <strong>directivos y administradores</strong>, el pronóstico es una ayuda para decidir, no una promesa; para <strong>docentes</strong> de matemáticas o tecnología, es un excelente caso para enseñar a evaluar modelos con datos reales; para las <strong>familias</strong> y la comunidad, entender que una estimación tiene margen de error ayuda a leer mejor las cifras que se presentan.</p>

<h2>Herramientas para trabajar tus datos en Excel</h2>
<p>Si quieres automatizar tareas con tus datos o tener plantillas ordenadas, mira estas opciones. Y para repasar estadística y funciones con apoyo de la IA, hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:plantilla-en-excel-de-factura-sencilla-numeracion-automatica,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">cuándo Excel deja de ser la solución</a>, <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a> y <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">cómo automatizar en Excel</a>. Para el análisis de tus propios datos de aula, mira el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué diferencia hay entre PRONOSTICO.LINEAL y PRONOSTICO.ETS?</h3>
<p>PRONOSTICO.LINEAL traza una recta y no considera la estacionalidad; PRONOSTICO.ETS usa suavizado exponencial triple y modela nivel, tendencia y estacionalidad.</p>
<h3>¿Cuántos datos necesito para un pronóstico con estacionalidad?</h3>
<p>Como mínimo, dos ciclos completos (por ejemplo, 24 meses para un ciclo anual); idealmente, más.</p>
<h3>¿Cómo evalúo si un pronóstico es bueno?</h3>
<p>Con una prueba retrospectiva: entrena con parte de los datos, pronostica lo que ya conoces y calcula un error como el MAPE. Compara siempre con un método simple, como repetir el año anterior.</p>
<h3>¿Puedo confiar en la estacionalidad automática de Excel?</h3>
<p>Revísala. En el ejemplo detectó 6 meses en lugar de 12 y el error subió. Si conoces el ciclo, indícalo.</p>
<h3>¿Un pronóstico predice el futuro?</h3>
<p>No: proyecta patrones del pasado. Si el contexto cambia (un cierre, una crisis, una nueva política), el pronóstico pierde validez.</p>

<p class="notice"><strong>Pruébalo con tus datos.</strong> Descarga el <a href="/descargas/pronosticos-excel/pronosticos-excel-ejercicios.xlsx">libro de pronósticos</a>, resuelve los ejercicios y reemplaza los datos ficticios por tus ventas, matrículas o consumo; luego compara los cuatro métodos en la hoja "Pronostico" antes de creer en un número. Requiere Excel 2016 o posterior (funciones ETS).</p>

<h2>Para pensar</h2>
<p>Un pronóstico bien presentado se ve como un hecho, aunque sea una apuesta informada. <strong>¿Quién debe responder cuando una decisión importante (contratar docentes, comprar inventario, cerrar una sede) se toma con un pronóstico que resultó equivocado: quien hizo el modelo, quien lo presentó o quien decidió sin preguntar por el margen de error? Y si los modelos aprenden del pasado, ¿cómo evitamos que nos encierren en él justo cuando el futuro necesita ser distinto?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:prueba}}' => $img('pronosticos-excel-prueba', 520, 'Gráfico de líneas con 36 meses de ventas ficticias y, en los últimos 12, el valor real frente a tres pronósticos: la tendencia lineal casi plana, ETS con 12 meses indicados siguiendo los picos y ETS con estacionalidad automática sobrestimando.', 'Real frente a pronósticos: se entrena con 24 meses y se prueba con 12.'),
    '{{img:error}}' => $img('pronosticos-excel-error', 436, 'Barras con el error porcentual absoluto medio de cada método: ETS con 12 meses indicados 3,0 %, tendencia lineal 11,1 %, ingenuo estacional 13,0 % y ETS automático 15,4 %.', 'Error medio de cada método en la prueba.'),
]);

return [
    'slug' => 'pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar',
    'title' => 'Pronósticos en Excel: tendencia, estacionalidad y cuándo no confiar en el resultado',
    'excerpt' => 'Una prueba retrospectiva de cuatro métodos de pronóstico en Excel (recta, ETS manual y automático, e ingenuo estacional), con errores medidos, los siete errores más comunes y un libro de ejercicios con soluciones.',
    'seo_title' => 'Pronósticos en Excel: estacionalidad y prueba de error',
    'seo_description' => 'Pronósticos en Excel con FORECAST.ETS y tendencia lineal: prueba retrospectiva con errores medidos, errores comunes y libro de ejercicios descargable.',
    'focus_keyword' => 'pronósticos en Excel',
    'cover' => '/assets/img/articulos/pronosticos-excel/pronosticos-excel-portada',
    'cover_alt' => 'Portada "Pronósticos en Excel: tendencia, estacionalidad y cuándo no confiar en el resultado" con una tarjeta: 3,0 % frente a 15,4 % de error medio de ETS con la estacionalidad indicada frente a la automática, ingenuo 13,0 % y tendencia lineal 11,1 %.',
    'published_at' => '2026-11-19 12:00:00',
    'content_html' => $html,
];
