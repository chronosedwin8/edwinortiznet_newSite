<?php

declare(strict_types=1);

// "Análisis de ítems en Excel". Teoría clásica de los tests: dificultad, discriminación (27 % de Kelley, 1939; referencias de Ebel), correlación ítem-total corregida, distractores y KR-20 (Kuder y Richardson, 1937). Libro verificado en Excel 16 y Python: media 11,63, DE 3,02, p media 0,58, KR-20 0,60; ítems a revisar 3, 7, 11 y 14; clave corregida del ítem 7: media 12,10, KR-20 0,66, 20 estudiantes cambian de puntaje. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/analisis-de-items/' . $name;
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
<p>Aplicas una prueba de veinte preguntas de opción múltiple a tu grupo, calificas con la clave y entregas notas. Pero ¿cuántas de esas veinte preguntas <strong>midieron realmente lo que querías medir</strong>? Una pregunta que todos aciertan no distingue a nadie; una que casi nadie acierta puede estar mal redactada; una cuya clave está equivocada castiga a quienes más saben. El <em>análisis de ítems</em> es la revisión de cada pregunta con los datos de las respuestas, y se puede hacer en Excel en minutos.</p>
<p>Este artículo explica los indicadores clásicos (dificultad, discriminación, correlación ítem-total, análisis de distractores y confiabilidad KR-20), con un <a href="/descargas/analisis-de-items/analisis-de-items-prueba.xlsx">libro de Excel descargable</a> que los calcula automáticamente para 30 estudiantes ficticios y 20 ítems. Las fórmulas se verificaron en Microsoft Excel 16 y todos los resultados se contrastaron con un cálculo independiente en Python. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios. Los indicadores son <strong>señales para mirar un ítem, no sentencias</strong>: con grupos pequeños (como 30 estudiantes) son muy inestables, y los valores de referencia dependen del propósito de la prueba. La decisión sobre qué hacer con un ítem es del docente, con el contenido de la pregunta a la vista. La forma de calificar y las decisiones de promoción las define el SIEE de cada colegio.</p>

<h2>Los indicadores, uno por uno</h2>
{{img:indicadores}}
<ul>
<li><strong>Dificultad (p).</strong> La proporción de estudiantes que acierta el ítem: <code>=PROMEDIO(columna de 0 y 1)</code>. Un p de 0,90 significa que 9 de cada 10 acertaron (muy fácil); un p de 0,15, que solo 3 de cada 20 acertaron (muy difícil). Como orientación, se suele considerar deseable un p entre 0,30 y 0,80, aunque una prueba de dominio puede tener preguntas fáciles a propósito.</li>
<li><strong>Discriminación (D).</strong> Qué tanto el ítem separa a quienes saben más de quienes saben menos. Se calcula comparando el grupo alto y el bajo según el puntaje total: tradicionalmente el 27 % superior y el 27 % inferior (regla de Kelley, 1939); con 30 estudiantes, 8 en cada grupo. <code>D = (aciertos del grupo alto − aciertos del grupo bajo) / tamaño del grupo</code>. Una referencia clásica (Ebel) lo lee así: 0,40 o más, excelente; 0,30 a 0,39, buena; 0,20 a 0,29, marginal; menos de 0,20, pobre; negativa, algo anda mal (el ítem funciona al revés).</li>
<li><strong>Correlación ítem-total corregida.</strong> La correlación entre acertar el ítem y el puntaje total <em>sin ese ítem</em> (para no contarlo contra sí mismo). Debe ser positiva; cercana a cero o negativa indica que el ítem no va con el resto de la prueba. En Excel: <code>=COEF.DE.CORREL(ítem; total − ítem)</code> (<code>CORREL</code> en inglés).</li>
<li><strong>Análisis de distractores.</strong> Cuántos estudiantes eligen cada opción. Un distractor que casi nadie elige no cumple su función; uno que atrae más al grupo alto que al bajo puede ser ambiguo; y si la opción más elegida no es la clave, hay que sospechar de la clave.</li>
<li><strong>Confiabilidad KR-20.</strong> Un coeficiente de consistencia interna de la prueba para ítems de acierto/error (Kuder y Richardson, 1937): <code>KR-20 = (k/(k−1)) · (1 − Σ p·q / σ²)</code>, donde k es el número de ítems, p·q la varianza de cada ítem y σ² la varianza del puntaje total. Va de 0 a 1; valores altos indican que los ítems miden algo en común, y depende del número de ítems (más ítems, mayor KR-20).</li>
</ul>

<h2>El libro, hoja por hoja</h2>
<ul>
<li><strong>Respuestas:</strong> una fila por estudiante y una columna por ítem con la letra elegida (A a D), y la clave en la fila 3.</li>
<li><strong>Puntajes:</strong> convierte las respuestas en 1 (acierto) o 0 (error) comparándolas con la clave, calcula el total, el puesto (con desempate por el orden de la lista, para tener exactamente 8 estudiantes en cada grupo) y el grupo (alto, medio, bajo).</li>
<li><strong>Items:</strong> para cada ítem, p, aciertos de cada grupo, D, correlación ítem-total, el conteo de cada opción, la opción más elegida, los distractores poco elegidos y un diagnóstico.</li>
<li><strong>Resumen:</strong> media, desviación estándar, dificultad media, KR-20 y el conteo de ítems aceptables y a revisar.</li>
</ul>
<pre><code>' Acierto (1/0): respuesta del estudiante contra la clave de la fila 3
=SI(Respuestas!B4=Respuestas!B$3;1;0)                                    ' español
=IF(Respuestas!B4=Respuestas!B$3,1,0)                                    ' inglés

' Dificultad p y discriminación D (grupo alto y bajo de 8 estudiantes)
=PROMEDIO(Puntajes!B3:B32)
=(SUMAR.SI.CONJUNTO(item; grupo; "Alto") - SUMAR.SI.CONJUNTO(item; grupo; "Bajo")) / 8

' Correlación ítem-total corregida
=COEF.DE.CORREL(Puntajes!B3:B32; Puntajes!$V$3:$V$32 - Puntajes!B3:B32)

' KR-20
=(k/(k-1)) * (1 - SUMAPRODUCTO(p; 1-p) / DESVEST.P(totales)^2)</code></pre>

<h2>Lo que encontró el análisis (datos ficticios)</h2>
<p>El grupo de 30 estudiantes obtuvo una media de <strong>11,63 de 20</strong> (desviación estándar de 3,02), con una dificultad media de 0,58 y un <strong>KR-20 de 0,60</strong>. De los 20 ítems, 16 resultaron aceptables y 4 pidieron revisión:</p>
<ul>
<li><strong>Ítem 7: posible error de clave.</strong> Con la clave publicada (A), solo 3 de 30 estudiantes acertaron (p de 0,10). Pero <strong>17 de 30 eligieron la opción C</strong>, incluidos 7 de los 8 estudiantes del grupo alto. Cuando casi todo el grupo alto elige la misma opción distinta de la clave, lo más probable es que la clave esté equivocada (o que la pregunta tenga dos respuestas defendibles). Con la clave corregida a C, la media del grupo sube de 11,63 a <strong>12,10</strong>, el KR-20 de 0,60 a <strong>0,66</strong>, y <strong>20 de los 30 estudiantes cambian de puntaje</strong>: 17 ganan un punto y 3 lo pierden. Si la línea de aprobación fuera 12 de 20, pasarían 16 estudiantes en lugar de 14.</li>
<li><strong>Ítem 3: discrimina al revés.</strong> Ninguno de los 8 del grupo alto acertó, mientras 3 de los 8 del grupo bajo sí (D de −0,38); 5 de los 8 del grupo alto eligieron la opción D. Una discriminación negativa es una alarma: ¿hay dos respuestas correctas?, ¿la redacción confunde a quien piensa más?, ¿el contenido es de otro tema? Hay que leer la pregunta.</li>
<li><strong>Ítem 11: poco discriminativo y difícil.</strong> p de 0,27, D de 0,13 y las cuatro opciones elegidas casi por igual (8, 8, 7 y 7): la distribución de quien adivina. Suele indicar que el contenido no se enseñó o que la pregunta es ambigua.</li>
<li><strong>Ítem 14: muy fácil.</strong> p de 0,93 y dos distractores que nadie eligió. No es necesariamente un problema (puede verificar un mínimo esperado), pero no distingue a nadie.</li>
</ul>
<p>Entre los ítems buenos, el 6 y el 16 (D de 0,88) separan muy bien al grupo alto del bajo, y el ítem 8 (D de 0,75) también. Los ítems 12 y 14 tienen distractores que casi nadie elige (el ítem 12: la opción C no la eligió nadie y la D, un estudiante), una oportunidad para mejorar las opciones.</p>
{{img:pasos}}

<h2>Cinco pasos para revisar un ítem</h2>
<ol>
<li><strong>Mira la dificultad:</strong> ¿demasiado fácil o demasiado difícil para el propósito?</li>
<li><strong>Mira la discriminación:</strong> ¿separa a quienes saben de quienes no? Si es negativa, es la primera prioridad.</li>
<li><strong>Mira las opciones:</strong> ¿cuál eligen los estudiantes del grupo alto? ¿Hay un distractor que nadie elige?</li>
<li><strong>Decide:</strong> conservar, ajustar (redacción, distractores) o eliminar; y si hay un error de clave, corregirlo y recalificar.</li>
<li><strong>Documenta:</strong> anota qué cambió y por qué, para el banco de preguntas del año siguiente.</li>
</ol>

<h2>Lo que el análisis no puede decir</h2>
<ul>
<li><strong>Con 30 estudiantes, los números son frágiles.</strong> Una diferencia de un par de estudiantes en un grupo de 8 mueve la D mucho. Útil para detectar casos extremos (como el ítem 7), poco fiable para decidir entre un ítem "bueno" y otro "regular".</li>
<li><strong>No dice si el ítem es válido.</strong> Un ítem puede tener buena discriminación y medir otra cosa (por ejemplo, comprensión lectora en lugar de matemáticas).</li>
<li><strong>No dice si es justo.</strong> El análisis tradicional no detecta sesgos; para eso hay métodos específicos.</li>
<li><strong>El KR-20 depende de la longitud y la homogeneidad.</strong> Una prueba corta o que mezcla muchos temas tendrá un KR-20 menor sin que necesariamente sea mala.</li>
</ul>
<p>Estos indicadores forman parte de la teoría clásica de los tests; las pruebas estandarizadas de gran escala usan además modelos más sofisticados (teoría de respuesta al ítem). Para un docente, la teoría clásica es suficiente para limpiar su banco de preguntas. Y conecta con otras decisiones de evaluación: ver <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">planeación inversa</a> (¿el ítem evalúa un resultado que enseñé?), <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">promedios en Excel: siete errores</a> (el cálculo de la nota) y <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">el error matemático que se repite</a> (el análisis de distractores muestra qué errores atraen a los estudiantes).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, las pruebas estandarizadas como las Saber analizan sus ítems con métodos estadísticos especializados antes de usarlos, pero las pruebas que se aplican en el aula casi nunca pasan por ningún análisis: se preparan, se aplican y se califican. En la región y en el mundo, la calidad de los ítems preparados por docentes es un tema recurrente en la formación en evaluación. Para los <strong>docentes</strong>, el análisis es una forma concreta de mejorar su banco de preguntas sin depender de nadie; para los <strong>directivos</strong>, una razón para que las áreas compartan y depuren sus bancos; para las <strong>familias</strong>, saber que una prueba se puede revisar y corregir cuando una clave falla; y para los <strong>estudiantes</strong>, que un error del instrumento no sea un error suyo. Cuando una prueba se aplica para decidir promoción, la revisión de claves antes de entregar notas es un acto de justicia.</p>

<h2>Plantillas y herramientas</h2>
<p>Para generar preguntas de opción múltiple con clave y distractores plausibles, y luego analizarlas con este libro, mira estas herramientas propias (siempre revisando lo que produce la IA, sobre todo las claves). Y para pedir ayuda con tus fórmulas, hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:generador-de-examenes-ia-esencial,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL! y #VALUE!</a>, <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">un dashboard que ayude a actuar</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>. Para quienes se preparan para el concurso, ver <a href="/herramientas/simulacro-concurso-docente/">la herramienta de simulacro</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es el análisis de ítems?</h3>
<p>La revisión de cada pregunta de una prueba con los datos de las respuestas: qué tan difícil fue, qué tanto distingue a quienes saben más de quienes saben menos y qué opciones eligieron los estudiantes.</p>
<h3>¿Qué es un buen índice de discriminación?</h3>
<p>Como referencia clásica, 0,30 o más se considera bueno y 0,40 o más, excelente; por debajo de 0,20 es pobre y negativo es una alarma. Con grupos pequeños, son valores muy inestables.</p>
<h3>¿Cómo sé si la clave de una pregunta está mal?</h3>
<p>Si la opción más elegida no es la clave, y sobre todo si la eligen casi todos los estudiantes del grupo alto, es una señal fuerte. Verifica la pregunta antes de decidir.</p>
<h3>¿Qué es el KR-20?</h3>
<p>Un coeficiente de consistencia interna para pruebas de acierto y error: indica qué tanto los ítems miden algo en común. Va de 0 a 1 y depende del número de ítems.</p>
<h3>¿Sirve con grupos pequeños?</h3>
<p>Sirve para detectar casos extremos (claves erróneas, ítems que funcionan al revés), pero los valores de discriminación y KR-20 son inestables con pocos estudiantes.</p>

<p class="notice"><strong>Revisa tu última prueba.</strong> Descarga el <a href="/descargas/analisis-de-items/analisis-de-items-prueba.xlsx">libro de análisis de ítems</a>, pega las respuestas de tu grupo y la clave, y mira qué ítems pide revisar antes de entregar las notas.</p>

<h2>Para pensar</h2>
<p>Si una pregunta de tu prueba tiene la clave equivocada, ¿cuántos estudiantes lo pagaron con sus notas antes de que alguien lo notara? <strong>¿Qué tendría que pasar en un colegio para que revisar los ítems antes de calificar fuera una práctica normal, y no una excepción? Y cuando un análisis muestra que una pregunta falló, ¿asumimos el error del instrumento o seguimos defendiendo la nota?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:indicadores}}' => $img('analisis-de-items-indicadores', 499, 'Tabla con cuatro indicadores de un ítem, qué mide cada uno y su referencia orientativa: dificultad, discriminación, correlación ítem-total y distractores.', 'Qué mide cada indicador y cómo leerlo.'),
    '{{img:pasos}}' => $img('analisis-de-items-pasos', 467, 'Cinco pasos para revisar un ítem: dificultad, discriminación, opciones, decidir y documentar.', 'Cinco pasos antes de decidir.'),
]);

return [
    'slug' => 'analisis-de-items-excel-dificultad-discriminacion-distractores-kr20-libro',
    'title' => 'Análisis de ítems en Excel: dificultad, discriminación, distractores y KR-20 de tu prueba (libro verificado)',
    'excerpt' => 'Cómo saber qué preguntas de tu prueba de opción múltiple funcionan: dificultad, discriminación, correlación ítem-total, análisis de distractores y KR-20 en Excel, con un libro verificado y un caso de clave equivocada.',
    'seo_title' => 'Análisis de ítems en Excel para docentes',
    'seo_description' => 'Analiza tus pruebas de opción múltiple en Excel: dificultad, discriminación, distractores y KR-20, con libro verificado y cómo detectar una clave errónea.',
    'focus_keyword' => 'análisis de ítems en Excel',
    'cover' => '/assets/img/articulos/analisis-de-items/analisis-de-items-portada',
    'cover_alt' => 'Portada "Análisis de ítems en Excel: qué preguntas de tu prueba sí funcionan" con una tarjeta: 17 de 30 estudiantes eligieron la misma opción en el ítem 7, y no era la clave publicada.',
    'published_at' => '2027-01-28 12:00:00',
    'content_html' => $html,
];
