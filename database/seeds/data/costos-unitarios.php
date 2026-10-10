<?php

declare(strict_types=1);

// "Costos unitarios del colegio". Libro verificado en Excel 16 y Python (Decimal): 420 estudiantes (180 primaria a $480.000, 240 secundaria a $560.000, 10 meses), costos $2.190 millones; criterio A (por estudiantes) primaria $505.714/mes y secundaria $533.214; B (partes iguales) $536.667 y $510.000; márgenes A -46.285.714/+64.285.714; B -102/+120 millones; margen total 18 millones; equilibrio 417 (margen 3); escenario -10 %: 378 est., $579.365/mes, margen -202,8 millones. Norma de tarifas privadas: Decreto 2253 de 1995 (compilado en el 1075), con aviso de verificar el texto vigente y la resolución anual. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/costos-unitarios/' . $name;
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
<p>El consejo directivo pregunta una cosa sencilla: "¿cuánto nos cuesta un estudiante al mes?". La tesorera responde con el presupuesto total dividido entre la matrícula, y el rector, con la pensión que se cobra. Las dos cifras se parecen, y entonces parece que todo está bien. Pero la pregunta de verdad es otra: <strong>¿cuánto cuesta cada nivel, qué parte de esos costos es "de ellos" y qué parte es de todos, y cuántos estudiantes se pueden perder antes de no cubrir los costos?</strong></p>
<p>Este artículo propone calcular los <strong>costos unitarios</strong> de un colegio: separar costos directos y comunes, repartir los comunes con un criterio explícito, calcular el costo por estudiante al mes y el punto de equilibrio. Incluye un <a href="/descargas/costos-unitarios/costos-unitarios-colegio.xlsx">libro de Excel</a> con un colegio ficticio de dos niveles, verificado en Microsoft Excel 16 y contra un cálculo independiente (con aritmética decimal).</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios y están en pesos colombianos; el ejemplo es una simplificación (dos niveles, diez rubros, matrícula fija). No es asesoría contable ni tributaria, y la fijación de tarifas de los colegios privados está regulada (ver abajo). Un costo por estudiante es una herramienta de gestión, no un juicio sobre el valor de un nivel, un programa o un estudiante.</p>

<h2>Costo directo, costo común y la pregunta del reparto</h2>
<ul>
<li><strong>Costos directos:</strong> los que se pueden asignar a un nivel o programa sin discusión, como los docentes de primaria o el material de los laboratorios de secundaria.</li>
<li><strong>Costos comunes (o indirectos):</strong> los que sirven a todos: administración, servicios públicos, mantenimiento, tecnología, seguridad y aseo, bienestar. Para saber cuánto cuesta un nivel, hay que decidir <strong>cómo se reparten</strong>.</li>
<li><strong>Costos fijos y variables:</strong> los fijos no bajan si la matrícula baja (nómina, planta física); los variables sí (material por estudiante). La distinción importa al simular escenarios.</li>
</ul>
{{img:tipos}}
<p>El reparto es una <strong>decisión de gestión</strong>, no un dato: se puede repartir por número de estudiantes, por metros cuadrados, por horas de uso, por personal, o en partes iguales. Cada criterio cuenta una historia distinta, y por eso el libro calcula dos a la vez.</p>

<h2>El libro de Excel</h2>
<ul>
<li><strong>Parametros:</strong> estudiantes y pensión mensual por nivel, meses de pensión al año y una variación de matrícula para un escenario.</li>
<li><strong>Costos:</strong> diez rubros con su tipo y su centro (Primaria, Secundaria o Común).</li>
<li><strong>Calculo:</strong> costo total, por estudiante, por año y por mes de cada nivel, con dos criterios para los comunes: <strong>A, por número de estudiantes</strong>, y <strong>B, en partes iguales</strong>, y el margen de cada nivel (ingreso por pensiones menos costo).</li>
<li><strong>Resumen:</strong> costo y pensión promedio, niveles con déficit, punto de equilibrio y el escenario de variación de la matrícula.</li>
</ul>
<pre><code>' Reparto de los costos comunes por número de estudiantes (comunes en D6, estudiantes del nivel en B4, total en D4)
=$D$6*B4/$D$4
' Costo por estudiante al mes (costo total del nivel en B8, meses en Parametros!B7)
=B8/B4/Parametros!$B$7
' Punto de equilibrio: estudiantes necesarios para cubrir el costo total con la pensión promedio
=REDONDEAR.MAS(Calculo!D8/(Calculo!D15/Calculo!D4);0)    ' español
=ROUNDUP(Calculo!D8/(Calculo!D15/Calculo!D4),0)           ' inglés</code></pre>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
{{img:reparto}}
<p>Un colegio con 420 estudiantes (180 en primaria con pensión de $480.000 y 240 en secundaria con $560.000, diez meses al año) y costos de $2.190 millones al año:</p>
<ul>
<li><strong>Promedios:</strong> el costo por estudiante es de $521.429 al mes; la pensión promedio, $525.714. El margen total es de $18 millones al año (0,8 % del ingreso).</li>
<li><strong>El reparto cambia la historia.</strong> Con el criterio A (comunes por estudiantes), primaria cuesta $505.714 por estudiante al mes y secundaria $533.214: <em>secundaria parece más cara</em>. Con el criterio B (partes iguales), primaria cuesta $536.667 y secundaria $510.000: <em>ahora primaria parece más cara</em>. El costo total es el mismo ($2.190 millones); lo que cambia es la lectura.</li>
<li><strong>Lo que no cambia:</strong> primaria queda en déficit en ambos criterios (−$46,3 millones con A, −$102 millones con B) y secundaria, con superávit ($64,3 y $120 millones). Una pensión de $480.000 no cubre el costo de primaria con ninguno de los dos criterios.</li>
<li><strong>Punto de equilibrio:</strong> con los costos actuales se necesitan <strong>417 estudiantes</strong> de 420: un margen de solo 3 estudiantes (0,7 %).</li>
<li><strong>Escenario:</strong> si la matrícula baja 10 % (378 estudiantes) y los costos se mantienen fijos, el costo por estudiante sube a $579.365 al mes y el margen pasa de +$18 millones a <strong>−$202,8 millones</strong>. Un diez por ciento menos de estudiantes no baja diez por ciento los costos.</li>
</ul>
<p><strong>Una lectura honesta:</strong> el ejemplo supone que todos los costos son fijos, lo que exagera el efecto de una caída de matrícula (en la práctica, algunos costos se ajustan, aunque con rezago), y que la pensión promedio sigue igual. Y el costo por estudiante no mide la calidad ni el valor educativo: un nivel "deficitario" puede ser el que sostiene la continuidad de los estudiantes que llegan a secundaria. Sirve para <strong>conversar con números claros</strong>, no para cerrar un nivel.</p>

<h2>Tarifas, norma y transparencia en Colombia</h2>
<p>En el sector privado colombiano, las matrículas, pensiones y cobros periódicos se rigen por el Decreto 2253 de 1995 (hoy compilado en el Decreto 1075 de 2015) y por las resoluciones anuales del Ministerio de Educación que fijan los parámetros de incremento. Según las fuentes consultadas el 10 de octubre de 2026, las tarifas las autoriza la entidad territorial certificada, los colegios se clasifican en regímenes (libertad regulada, libertad vigilada y régimen controlado, según cumplan requisitos de calidad), y los costos y la autoevaluación institucional deben presentarse a la secretaría antes de la matrícula. <strong>Verifica el texto vigente y la resolución del año escolar que te corresponde</strong>: los nombres de los regímenes, los plazos y los porcentajes cambian. En el sector oficial, el servicio es gratuito y la lógica es distinta: los recursos llegan por transferencias por estudiante, y el costo unitario sirve para planear y rendir cuentas, no para fijar pensiones.</p>
<p>Para los <strong>directivos</strong>, conocer el costo real por nivel es la base para fijar tarifas, planear la matrícula y negociar. Para las <strong>familias</strong>, entender qué cubre una pensión es parte de la transparencia (los cobros deben ser claros y explícitos). Para los <strong>docentes</strong>, la nómina es el mayor rubro, y la conversación sobre costos debe hacerse con respeto. Y para los <strong>estudiantes</strong>, que ningún análisis de costos los reduzca a una cifra: ver <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">el presupuesto ejecutado, comprometido y disponible</a> y <a href="/comparar-dos-ofertas-de-credito-en-excel-tasa-real-costo-total-comparador/">comparar ofertas por su costo total real</a> para otros usos del mismo razonamiento.</p>

<h2>Cómo empezar en un colegio</h2>
<ol>
<li><strong>Parte del presupuesto ejecutado</strong> del último año (no del presupuestado) y clasifica cada rubro como directo o común.</li>
<li><strong>Decide y documenta el criterio de reparto,</strong> y calcula al menos dos para ver cuánto cambia la lectura.</li>
<li><strong>Calcula el costo por estudiante al mes</strong> y compáralo con la pensión, sin olvidar los descuentos, las becas y la cartera morosa (el ingreso real es menor que el nominal).</li>
<li><strong>Calcula el punto de equilibrio</strong> y simula escenarios de matrícula con costos fijos y variables.</li>
<li><strong>Comparte los resultados</strong> con el consejo directivo con sus supuestos a la vista.</li>
</ol>

<h2>Herramientas y plantillas</h2>
<p>Si trabajas con las plantillas de Excel del sitio y quieres apoyo, o preparas material con IA (revisando siempre lo que produce y sin incluir datos financieros confidenciales en herramientas que no estén diseñadas para custodiarlos), mira estos productos.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: el <a href="/descargas/costos-unitarios/costos-unitarios-colegio.xlsx">libro de costos unitarios</a>, <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">promedios en Excel: siete errores</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es un costo unitario?</h3>
<p>El costo de producir una unidad del servicio; en un colegio, típicamente el costo por estudiante al mes o al año, total o por nivel.</p>
<h3>¿Cómo reparto los costos comunes?</h3>
<p>Con un criterio explícito: por número de estudiantes, por metros cuadrados, por horas de uso o en partes iguales. Conviene calcular más de uno y documentar el elegido.</p>
<h3>¿Qué es el punto de equilibrio?</h3>
<p>El número de estudiantes con el que los ingresos por pensiones igualan los costos totales, con los costos y la pensión actuales.</p>
<h3>¿Por qué un nivel puede parecer deficitario?</h3>
<p>Porque la pensión de ese nivel no cubre su costo directo más la parte de comunes que se le asigna; el resultado depende del criterio de reparto y de las pensiones. No significa que el nivel deba cerrarse.</p>
<h3>¿Sirve para colegios oficiales?</h3>
<p>Sí, como herramienta de planeación y rendición de cuentas; el ingreso no es una pensión sino transferencias por estudiante.</p>

<p class="notice"><strong>Calcula el costo de tu colegio.</strong> Descarga el <a href="/descargas/costos-unitarios/costos-unitarios-colegio.xlsx">libro de costos unitarios</a>, reemplaza los datos ficticios por los de tu colegio, prueba los dos criterios de reparto y mira el punto de equilibrio.</p>

<h2>Para pensar</h2>
<p>Un costo por estudiante parece un dato objetivo, pero depende de decisiones: qué se asigna, qué se reparte y con qué criterio. <strong>¿Quién decide hoy en tu colegio cómo se reparten los costos comunes, y quién lo ve? Y ¿qué decisión cambiaría si el costo de un nivel se leyera con otro criterio de reparto?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tipos}}' => $img('costos-unitarios-tipos', 499, 'Tabla con cuatro tipos de costo y cómo se tratan: directo, común, fijo y variable, con un ejemplo de cada uno.', 'Qué se asigna y qué se reparte.'),
    '{{img:reparto}}' => $img('costos-unitarios-reparto', 524, 'Gráfico de barras del costo por estudiante al mes por nivel con dos criterios de reparto y de la pensión: primaria y secundaria.', 'El criterio de reparto cambia qué nivel parece más caro.'),
]);

return [
    'slug' => 'costos-unitarios-colegio-excel-costo-por-estudiante-reparto-punto-de-equilibrio',
    'title' => 'Costos unitarios del colegio en Excel: cuánto cuesta cada estudiante, cómo se reparten los costos comunes y cuál es el punto de equilibrio',
    'excerpt' => 'Cómo calcular el costo por estudiante y por nivel con costos directos y comunes, por qué el criterio de reparto cambia la lectura y cuántos estudiantes se necesitan para el equilibrio, con un libro de Excel verificado.',
    'seo_title' => 'Costos unitarios del colegio en Excel: costo por estudiante',
    'seo_description' => 'Cómo calcular el costo por estudiante del colegio en Excel: costos directos y comunes, criterios de reparto y punto de equilibrio, con libro verificado.',
    'focus_keyword' => 'costos unitarios del colegio en Excel',
    'cover' => '/assets/img/articulos/costos-unitarios/costos-unitarios-portada',
    'cover_alt' => 'Portada "Costos unitarios del colegio: cuánto cuesta de verdad cada estudiante" con una tarjeta: 417 de 420 estudiantes bastan para cubrir los costos del colegio de ejemplo, un margen de solo 3.',
    'published_at' => '2027-02-25 12:00:00',
    'content_html' => $html,
];
