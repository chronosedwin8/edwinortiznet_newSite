<?php

declare(strict_types=1);

// «Un dashboard de Excel que ayude a actuar, no solo a mirar gráficos». Tablero de cartera de un colegio (datos ficticios): indicadores verificados contra un cálculo independiente en Python y probados en Microsoft Excel 16 (es-CO). Verificado el 9 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/dashboard-excel-actuar/' . $name;
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
<p>Hay un tipo de tablero de Excel que se ve impresionante y no sirve para nada: veinte gráficos de colores, mapas, indicadores que giran… y ninguna pregunta que responder. Quien lo mira dice «qué bonito» y vuelve a hacer lo mismo que hacía. Un dashboard útil es otra cosa: <strong>parte de una pregunta, compara con una meta, ordena por prioridad y propone el siguiente paso</strong>.</p>
<p>En este artículo construyo uno completo, <strong>un tablero de cartera de un colegio</strong> que responde «¿a quién llamo esta semana?», con datos ficticios y plantilla descargable. Todos los cálculos del tablero los verifiqué contra un cálculo independiente en Python (coinciden al peso) y probé las fórmulas en Microsoft Excel 16 (es-CO). Es una <a href="/descargas/dashboard-excel/tablero-cartera-colegio.xlsx">plantilla descargable en Excel</a>. Verificado el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Un buen dashboard tiene cuatro cualidades: una <strong>pregunta</strong> concreta, una <strong>meta</strong> con la cual comparar (semáforo), una <strong>priorización</strong> que ordena lo urgente y una <strong>acción</strong> sugerida por fila. Se construye con una hoja de datos limpia, unas pocas fórmulas (SUMAR.SI.CONJUNTO, CONTAR.SI.CONJUNTO, K.ESIMO.MAYOR) y dos o tres gráficos, no veinte. En el ejemplo, el recaudo del mes es 77 % frente a una meta del 90 %, el 50 % de la cartera lleva más de 60 días de mora y el tablero señala qué familias contactar y cómo.</p>

<h2>Por qué la mayoría de dashboards no sirven</h2>
{{img:dos-tableros}}
<p>Un tablero que solo informa deja todo el trabajo al lector: interpretar, priorizar y decidir. Los cuatro defectos típicos: no hay una pregunta clara, las cifras no se comparan con una meta (un 77 % no dice nada sin saber si la meta es 70 u 90), no hay orden de prioridad y no se propone ninguna acción. Además, muchos tableros fallan por el diseño de los gráficos (ver <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">las gráficas de Excel que mienten</a>).</p>

<h2>El caso: ¿a quién llamo esta semana?</h2>
<p>La tesorería de un colegio privado (ficticio) tiene 80 familias, la pensión de cada una y su saldo pendiente. Quiere saber: ¿cómo va el recaudo del mes frente a la meta?, ¿cómo está la cartera según los días de mora? y, sobre todo, ¿con quién hay que hablar esta semana y de qué manera? El tablero está en la hoja «Tablero» y se alimenta de la hoja «Datos».</p>
{{img:tablero}}
<p>Con los datos de ejemplo, el tablero muestra:</p>
<ul>
<li><strong>Recaudo del mes:</strong> 77,3 % frente a una meta del 90 %: el semáforo marca «Por debajo de la meta» en rojo.</li>
<li><strong>Cartera vencida:</strong> 25,47 millones de pesos, repartidos así: 8,16 millones en mora de 1 a 30 días (9 familias), 4,56 de 31 a 60 (4 familias), 8,10 de 61 a 90 (5 familias) y 4,65 de más de 90 (2 familias).</li>
<li><strong>Concentración:</strong> 12,75 millones (el 50 % de la cartera) está en 7 familias con más de 60 días de mora.</li>
<li><strong>Prioridad esta semana:</strong> 5 familias con mora de 61 a 90 días y un saldo igual o superior al umbral que tú defines (1 millón en el ejemplo), y 2 con más de 90 días.</li>
<li><strong>Los diez saldos más altos</strong>, cada uno con su acción sugerida: por ejemplo, «Llamar esta semana» o «Reunión para acuerdo de pago».</li>
</ul>

<h2>Cómo está construido (y las fórmulas)</h2>
<p><strong>1. Una hoja de datos limpia.</strong> Una fila por familia, con columnas calculadas (días de mora, rango, acción sugerida):</p>
<pre><code>' Días de mora (Datos!F4)
=SI(D4=0; 0; Tablero!$C$3-E4)
=IF(D4=0, 0, Tablero!$C$3-E4)

' Acción sugerida (Datos!H4)
=SI(D4=0;"Sin acción"; SI(F4<=30;"Recordatorio automático"; SI(F4<=60;"Recordatorio escrito personalizado";
   SI(F4<=90;"Llamar esta semana";"Reunión para acuerdo de pago"))))</code></pre>
<p><strong>2. Indicadores con una sola fórmula cada uno:</strong></p>
<pre><code>' Cartera por rango de mora (Tablero!C11)
=SUMAR.SI.CONJUNTO(Datos!$D$4:$D$83; Datos!$G$4:$G$83; B11)
=SUMIFS(Datos!$D$4:$D$83, Datos!$G$4:$G$83, B11)

' Prioridad: mora de 61 a 90 días y saldo >= umbral
=CONTAR.SI.CONJUNTO(Datos!F4:F83;">60"; Datos!F4:F83;"<=90"; Datos!D4:D83;">="&K3)
=COUNTIFS(Datos!F4:F83,">60", Datos!F4:F83,"<=90", Datos!D4:D83,">="&K3)</code></pre>
<p><strong>3. Los diez saldos más altos</strong> sin funciones nuevas (funciona en cualquier versión de Excel), con una columna auxiliar de orden que desempata saldos iguales sumando una fracción mínima de la fila:</p>
<pre><code>' Clave de orden (Datos!I4): evita empates
=D4+FILA()/1000000

' Familia con el n-ésimo saldo más alto (Tablero!H11)
=INDICE(Datos!$A$4:$A$83; COINCIDIR(K.ESIMO.MAYOR(Datos!$I$4:$I$83; G11); Datos!$I$4:$I$83; 0))
=INDEX(Datos!$A$4:$A$83, MATCH(LARGE(Datos!$I$4:$I$83, G11), Datos!$I$4:$I$83, 0))</code></pre>
<p><strong>4. Un semáforo con formato condicional:</strong> la celda de estado compara el recaudo con la meta (verde si la alcanza, ámbar si está dentro de cinco puntos, rojo si no). La meta, la fecha de corte y el umbral son celdas amarillas editables, no números escondidos en fórmulas.</p>
<p><strong>5. Dos gráficos, no veinte:</strong> el saldo por rango de mora (columnas, con el eje en cero) y el recaudo por mes frente a la meta (línea). Si quieres aprender a no engañar con los ejes, mira el artículo sobre <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">gráficas que mienten</a>.</p>

<h2>La prueba: ¿el tablero dice la verdad?</h2>
<p>Un tablero con fórmulas mal puestas es peor que ninguno, porque inspira confianza. Por eso calculé los indicadores por un camino independiente (un script de Python con los mismos datos) y los comparé con lo que da Excel: facturado de 61.920.000, recaudado de 47.850.000 (77,28 %), cartera de 25.470.000, 7 familias con mora de más de 60 días, 12.750.000 en esa franja y los rangos de mora, todos iguales. Esa comparación independiente es una práctica que recomiendo para cualquier tablero que alimente decisiones (ver <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a> y <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">cómo leer los errores</a>).</p>

<h2>Diez reglas para tu propio tablero</h2>
<ol>
<li><strong>Escribe la pregunta</strong> en el título: «¿a quién llamo esta semana?», «¿qué grupos necesitan refuerzo?», «¿qué productos se están agotando?».</li>
<li><strong>Cada indicador, con meta</strong> y semáforo.</li>
<li><strong>Cinco a siete indicadores</strong> como máximo.</li>
<li><strong>Ordena por prioridad</strong> y muestra solo los primeros.</li>
<li><strong>Una acción sugerida</strong> por fila.</li>
<li><strong>Parámetros visibles y editables</strong> (metas, umbrales, fechas).</li>
<li><strong>Datos separados del tablero</strong> y limpios (ver <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importar CSV correctamente</a>).</li>
<li><strong>Gráficos honestos:</strong> ejes desde cero en columnas, escalas comparables.</li>
<li><strong>Verifica contra un cálculo independiente.</strong></li>
<li><strong>Define quién lo actualiza y cuándo</strong>; un tablero desactualizado engaña.</li>
</ol>

<h2>Un cuidado: los datos son personas</h2>
<p>Un tablero de cartera habla de familias con dificultades económicas. Las acciones del libro son <strong>sugerencias para iniciar una conversación respetuosa</strong>, no sentencias, y las decisiones sobre cobro siguen siendo de personas de la institución, con sus reglas y su criterio. Además, un archivo con nombres y saldos es información personal: protégelo, limita quién lo ve y no lo pegues en herramientas de IA gratuitas (ver <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA</a>). Cuando el volumen crece y varias personas editan a la vez, conviene pasar a una base de datos (ver <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">las siete señales</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En todo el mundo, los tableros se volvieron un símbolo de gestión basada en datos, y con ellos el riesgo de «tableros de adorno». En Colombia y Latinoamérica, las pequeñas y medianas instituciones y empresas rara vez tienen un analista de datos y casi todo se hace en Excel; allí un tablero sencillo y verificado vale más que una herramienta sofisticada que nadie sabe mantener. Para <strong>directivos y tesoreros</strong>, la lección es pedir tableros que respondan preguntas; para <strong>docentes</strong>, el mismo diseño sirve para seguimiento de asistencia o de notas (por ejemplo, qué grupos necesitan apoyo); para <strong>familias</strong>, la transparencia en cómo se usan sus datos; y para <strong>quienes enseñan Excel</strong>, es un buen proyecto integrador.</p>

<h2>Plantillas para trabajar con orden</h2>
<p>Si prefieres partir de plantillas ya armadas, estas opciones traen controles y formato. Y hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a> para pedir ayuda con tus fórmulas, siempre verificando el resultado.</p>
{{productos:plantilla-en-excel-de-factura-sencilla-numeracion-automatica,listado-de-asistencia-laboral-o-academica-en-excel}}
<p>Sigue leyendo: <a href="/listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla/">listas desplegables dependientes</a>, <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">pronósticos en Excel</a> y <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">cómo automatizar en Excel</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué hace bueno a un dashboard de Excel?</h3>
<p>Parte de una pregunta concreta, compara los indicadores con una meta, ordena por prioridad y propone una acción. Pocos indicadores y gráficos honestos.</p>
<h3>¿Cuántos indicadores debe tener?</h3>
<p>Entre cinco y siete suele ser suficiente. Más indicadores diluyen la atención y esconden lo urgente.</p>
<h3>¿Cómo saco los diez valores más altos sin funciones nuevas?</h3>
<p>Con K.ESIMO.MAYOR, INDICE y COINCIDIR, y una columna auxiliar que desempata (el valor más una fracción mínima de la fila).</p>
<h3>¿Cómo sé que mi tablero calcula bien?</h3>
<p>Calcula los mismos indicadores por otro camino (a mano con una muestra, con una tabla dinámica o con un script) y compara.</p>
<h3>¿Necesito Power BI?</h3>
<p>No para empezar. Un tablero bien diseñado en Excel cubre la mayoría de necesidades de una pequeña institución o empresa; Power BI aporta cuando hay mucho volumen, varias fuentes o muchos usuarios.</p>

<p class="notice"><strong>Pruébalo con tus datos.</strong> Descarga el <a href="/descargas/dashboard-excel/tablero-cartera-colegio.xlsx">tablero de cartera</a>, reemplaza la hoja «Datos» por la tuya y ajusta la fecha de corte, la meta y el umbral. Si lo conviertes para otro tema (asistencia, inventario), conserva la estructura: pregunta, meta, prioridad y acción.</p>

<h2>Para pensar</h2>
<p>Un tablero que propone qué hacer con cada persona puede ahorrar tiempo y también deshumanizar. <strong>¿Hasta dónde debe llegar la automatización de las «acciones sugeridas» cuando detrás de cada fila hay una familia? ¿Y quién debe decidir qué se mide, qué meta se fija y qué acción se recomienda: quien diseña el tablero, quien lo usa o las personas que aparecen en él?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:dos-tableros}}' => $img('dashboard-excel-actuar-dos-tableros', 633, 'Dos columnas: un tablero que solo informa, con muchos gráficos, cifras sin meta y sin acciones, frente a uno que ayuda a actuar, que parte de una pregunta, compara con una meta, ordena por prioridad y propone la acción siguiente.', 'Informar no es lo mismo que ayudar a actuar.'),
    '{{img:tablero}}' => $img('dashboard-excel-actuar-tablero', 600, 'Tablero de cartera de un colegio con datos ficticios: facturado 61,9 millones, recaudo 77,3 % en rojo frente a la meta del 90 %, cartera vencida 25,5 millones, siete familias con mora de más de 60 días, saldo por rango de mora, los saldos más altos con la acción sugerida y la prioridad de la semana.', 'El tablero de cartera: una pregunta, una meta, una prioridad y una acción.'),
]);

return [
    'slug' => 'dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla',
    'title' => 'Un dashboard de Excel que ayude a actuar, no solo a mirar gráficos: un tablero de cartera con plantilla',
    'excerpt' => 'Cómo construir un dashboard de Excel que parta de una pregunta, compare con una meta, ordene por prioridad y proponga una acción: un tablero de cartera de un colegio con fórmulas verificadas y plantilla descargable.',
    'seo_title' => 'Dashboard de Excel que ayude a actuar (plantilla)',
    'seo_description' => 'Cómo hacer un dashboard de Excel útil: pregunta, meta, prioridad y acción, con un tablero de cartera de colegio, fórmulas verificadas y plantilla descargable.',
    'focus_keyword' => 'dashboard de Excel',
    'cover' => '/assets/img/articulos/dashboard-excel-actuar/dashboard-excel-actuar-portada',
    'cover_alt' => 'Portada «Un dashboard de Excel que ayude a actuar, no solo a mirar gráficos» con una tarjeta: recaudo del mes 77 % frente a una meta del 90 %, cartera de 25,5 millones y el 50 % con más de 60 días de mora.',
    'published_at' => '2026-12-10 12:00:00',
    'content_html' => $html,
];
