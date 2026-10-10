<?php

declare(strict_types=1);

// "Conciliar dos listados en Excel". Libro verificado en Excel 16 (es-CO) con los mismos datos del conciliador en Python: 30 y 29 filas; 27 en ambos; 2 solo en A; 1 solo en B; 1 cero perdido; 3 solo formato; 6 conflictos reales. Trampas verificadas empíricamente: CONTAR.SI trata "0012" como 12 (COINCIDIR no); el signo = no distingue mayúsculas (IGUAL sí).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/conciliar-listados-excel/' . $name;
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
<p>Tienes dos listados del mismo grupo, uno del sistema de gestión escolar y otro del aula virtual, y necesitas saber cuántos estudiantes difieren. Abres Excel, escribes una fórmula que cuenta cuántos códigos de la lista A aparecen en la lista B y el resultado dice que casi todos aparecen. Hasta que descubres que <strong>Excel considera iguales el código "0012" y el código "12"</strong>, y que con ello acaba de esconder a un estudiante que está mal registrado. Conciliar listados en Excel es fácil; conciliarlos <em>bien</em> exige conocer dos trampas.</p>
<p>En un artículo anterior se comparó un par de listados con un <a href="/un-dato-varias-versiones-conciliar-sistema-gestion-aula-virtual-teams-conciliador/">conciliador en Python</a>. Este es el mismo ejercicio, con los <strong>mismos datos ficticios, pero hecho solo con fórmulas de Excel</strong>, para quien no usa Python: un <a href="/descargas/conciliar-listados-excel/conciliar-dos-listados-con-formulas.xlsx">libro de Excel</a> que normaliza el texto, busca cada llave de una lista en la otra, compara campo por campo y resume las diferencias. Los resultados coinciden exactamente con los del script. Verificado en Microsoft Excel 16 (configuración regional es-CO) el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios. Los listados reales contienen datos personales de menores: trabájalos solo en equipos y espacios seguros de tu institución, no los subas a servicios externos ni a herramientas de IA gratuitas y borra los archivos de trabajo al terminar. Los nombres de las funciones están en español; si tu Excel está en inglés, usa los equivalentes (se indican en las fórmulas).</p>

<h2>Las dos trampas</h2>
<h3>Trampa 1: CONTAR.SI trata "0012" como 12</h3>
<p>La función <code>CONTAR.SI</code> (<code>COUNTIF</code>) convierte en número un criterio que parece número. Si la lista A tiene el código de texto "0012" y la lista B tiene "12" (porque una importación perdió el cero inicial), <code>=CONTAR.SI(ListaB; "0012")</code> devuelve 1: Excel interpreta ambos como el número 12 y da por encontrado al estudiante. En el libro, el primer intento con <code>CONTAR.SI</code> daba "En ambos" para el código 0012, y al intentar traer sus datos con <code>COINCIDIR</code> el resultado era <code>#N/D</code> (porque <code>COINCIDIR</code> sí compara los textos tal cual). La solución es comparar texto exacto con <code>IGUAL</code> dentro de <code>SUMAPRODUCTO</code>:</p>
<pre><code>' Trampa: da 1 aunque B tenga "12" y A tenga "0012"
=CONTAR.SI(Lista_B!$A$4:$A$63; A4)                              ' español
=COUNTIF(Lista_B!$A$4:$A$63, A4)                                 ' inglés

' Correcto: comparación exacta de texto
=SUMAPRODUCTO(--IGUAL(Lista_B!$A$4:$A$63; A4))                   ' español
=SUMPRODUCT(--EXACT(Lista_B!$A$4:$A$63, A4))                     ' inglés</code></pre>
<h3>Trampa 2: el signo = no distingue mayúsculas</h3>
<p>En Excel, <code>="Ángel Ruiz"="ÁNGEL Ruiz"</code> da <code>VERDADERO</code>. Para detectar que dos textos se escribieron distinto, hay que usar <code>IGUAL</code> (<code>EXACT</code>), que sí distingue mayúsculas. En el libro, "Ángel Ruiz" frente a "ÁNGEL Ruiz" aparecía como "Igual" con el signo = y como "Solo formato" con <code>IGUAL</code>, lo correcto: la diferencia existe, pero no es un conflicto real.</p>
{{img:funciones}}

<h2>El libro, hoja por hoja</h2>
<ul>
<li><strong>Lista_A</strong> y <strong>Lista_B:</strong> los dos listados, con el código guardado como <strong>texto</strong> (formato <code>@</code>). Si pegas datos nuevos, hazlo como texto o los ceros iniciales se perderán.</li>
<li>En <strong>Lista_A</strong>, columnas calculadas: el nombre normalizado, el estado de la llave (en ambos, solo en A, posible cero inicial perdido), los datos que tiene B para esa llave y el resultado de comparar nombre, correo y curso (igual, solo formato o conflicto).</li>
<li>En <strong>Lista_B</strong>: el estado de cada llave (en ambos, solo en B o posible cero perdido).</li>
<li><strong>Resumen:</strong> los conteos.</li>
</ul>
<pre><code>' Nombre normalizado: minúsculas, sin espacios sobrantes y sin tildes
=SUSTITUIR(SUSTITUIR(SUSTITUIR(SUSTITUIR(SUSTITUIR(MINUSC(ESPACIOS(B4));"á";"a");"é";"e");"í";"i");"ó";"o");"ú";"u")   ' español
=SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(LOWER(TRIM(B4)),"á","a"),"é","e"),"í","i"),"ó","o"),"ú","u")   ' inglés

' Estado de la llave
=SI(SUMAPRODUCTO(--IGUAL(Lista_B!$A$4:$A$63;A4))>0;"En ambos";
   SI(SUMAPRODUCTO(--IGUAL(Lista_B!$A$4:$A$63;TEXTO(VALOR(A4);"0")))>0;"Posible cero perdido";"Solo en A"))

' Dato de B para la llave de A (solo si está en ambos)
=INDICE(Lista_B!$B$4:$B$63; COINCIDIR(A4; Lista_B!$A$4:$A$63; 0))

' Comparar nombres: igual, solo formato o conflicto
=SI(IGUAL(B4;G4);"Igual";SI(E4=normalizado_de_G4;"Solo formato";"Conflicto"))</code></pre>
<p>Cada parte es sencilla; el valor está en combinarlas con cuidado. En particular, el orden de las comprobaciones importa: primero igualdad exacta, luego igualdad tras normalizar, y solo entonces conflicto. Así el informe no se llena de falsas alarmas.</p>

<h2>Lo que muestra el libro (los mismos datos del conciliador en Python)</h2>
<p>La lista A tiene 30 filas y la B, 29. Resultados del <em>Resumen</em>:</p>
<ul>
<li><strong>27 llaves en ambas listas.</strong></li>
<li><strong>2 solo en A</strong> (los códigos 0027 y 0029: estudiantes que no están en el aula virtual) y <strong>1 solo en B</strong> (el 0099, un registro que no corresponde a ningún estudiante de la lista maestra).</li>
<li><strong>1 posible cero inicial perdido:</strong> 0012 en A y 12 en B.</li>
<li><strong>3 diferencias de nombre que son solo de formato</strong> (mayúsculas, tildes o espacios dobles).</li>
<li><strong>6 conflictos reales:</strong> 2 en el nombre (por ejemplo, "Camilo Torres" frente a "Camilo Torrez"), 2 en el correo (un dominio con una letra cambiada) y 2 en el curso (7B frente a 8A, 7A frente a 8B).</li>
</ul>
<p>Eso suma <strong>9 estudiantes de 30 con un problema real</strong> (2 ausentes, 1 cero perdido y 6 con conflictos), igual que el script de Python. Que dos herramientas independientes lleguen al mismo resultado es la mejor prueba de que ninguna de las dos se equivoca.</p>
{{img:pasos}}

<h2>Cómo usarlo con tus listados</h2>
<ol>
<li><strong>Exporta las dos listas el mismo día</strong> y pégalas en las hojas Lista_A y Lista_B, columnas A a D, con el código como texto. Si el sistema exporta el código como número, conviértelo a texto con ceros antes de comparar.</li>
<li><strong>Si tienes más de 60 filas,</strong> extiende las fórmulas hacia abajo y ajusta los rangos (en el libro llegan a la fila 63; para listas más largas, convierte los rangos en tablas o amplíalos).</li>
<li><strong>Mira primero las llaves</strong> (ausentes y ceros perdidos) y luego los conflictos. Filtra por "Conflicto" en cada columna.</li>
<li><strong>Corrige en el sistema maestro,</strong> no en la lista; si corriges la copia, el error volverá.</li>
<li><strong>Repite</strong> antes de cada corte de notas.</li>
</ol>
<p>Si trabajas con listas de miles de filas, Excel 365 ofrece <code>BUSCARX</code> (<code>XLOOKUP</code>) y Power Query, que son más cómodos y más rápidos; las trampas de texto y de mayúsculas se mantienen, así que el método de normalizar y comparar exacto sigue valiendo. Y si la conciliación se repite todos los meses, un script (como el de Python) es más fácil de automatizar. Para datos que viajan entre sistemas, ver <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">cómo importar CSV a Excel sin dañar cédulas y fechas</a>.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los colegios cruzan listados constantemente: el reporte de matrícula, las listas de asistencia, los usuarios de las plataformas y los cursos. Casi siempre se hace en hojas de cálculo, con las trampas que ya vimos. En la región y en el mundo, la calidad de los datos escolares es un tema recurrente de la gestión educativa; la Ley 1581 de 2012 de Colombia incluye, entre los principios del tratamiento de datos personales, el de veracidad o calidad (verifica el texto vigente). Para los <strong>coordinadores</strong>, la conciliación mensual es una forma concreta de cuidar los datos de los estudiantes; para los <strong>secretarios y el personal de sistemas</strong>, un libro como este les ahorra horas; para los <strong>docentes</strong>, evita que "su lista" difiera de la oficial; y para las <strong>familias</strong>, que las comunicaciones lleguen a quien corresponde. Ver también <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL! y #VALUE!</a> y <a href="/compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional/">compatibilidad de libros de Excel entre equipos</a>.</p>

<h2>Plantillas y herramientas</h2>
<p>Si prefieres partir de plantillas de Excel ya armadas, con soporte, mira estas opciones. Y para pedir a una IA ayuda con tus fórmulas (verificando siempre el resultado y sin pegar datos de estudiantes en herramientas gratuitas), hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas/">auditar el horario escolar en Excel</a>, <a href="/ausentismo-escolar-excel-asistencia-ausentismo-cronico-rachas-patrones/">ausentismo escolar en Excel</a> y <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">el presupuesto del colegio en Excel</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Por qué CONTAR.SI dice que "0012" y "12" son iguales?</h3>
<p>Porque convierte en número un criterio que parece número, así que ambos se leen como 12. Para comparar texto exacto, usa IGUAL dentro de SUMAPRODUCTO.</p>
<h3>¿El signo = distingue mayúsculas en Excel?</h3>
<p>No. Para distinguirlas, usa IGUAL (EXACT).</p>
<h3>¿Cómo comparo nombres con tildes distintas?</h3>
<p>Normalizando antes: minúsculas, espacios sobrantes quitados y tildes reemplazadas con SUSTITUIR, y comparando los resultados.</p>
<h3>¿Puedo usar BUSCARV?</h3>
<p>Sí, con coincidencia exacta (último argumento FALSO), con las mismas precauciones sobre el formato de la llave. COINCIDIR con INDICE es más flexible porque permite buscar hacia la izquierda.</p>
<h3>¿Se puede automatizar?</h3>
<p>Con Power Query o con un script (como el de Python del artículo anterior), sobre todo si la conciliación se repite cada mes.</p>

<p class="notice"><strong>Pruébalo con tus listados.</strong> Descarga el <a href="/descargas/conciliar-listados-excel/conciliar-dos-listados-con-formulas.xlsx">libro de conciliación con fórmulas</a>, revisa primero que reproduce los resultados del ejemplo y luego pega tus dos listados (con el código como texto).</p>

<h2>Para pensar</h2>
<p>Una fórmula que "casi siempre funciona" es más peligrosa que una que falla a la vista, porque da confianza justo donde hace falta desconfiar. <strong>¿Cuántas de las cifras que nuestro colegio reporta cada año dependen de una fórmula que nadie ha probado con un caso difícil? Y ¿qué costaría, en tiempo y en cuidado de los datos, probar una vez cada fórmula con el caso que más temes?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:funciones}}' => $img('conciliar-listados-excel-funciones', 553, 'Tabla con cinco funciones de Excel para conciliar listados, para qué sirve cada una y su trampa: CONTAR.SI, COINCIDIR, IGUAL, ESPACIOS y MINUSC, y SUSTITUIR.', 'Qué hace cada una y dónde falla.'),
    '{{img:pasos}}' => $img('conciliar-listados-excel-pasos', 467, 'Cinco pasos de la conciliación con fórmulas: pegar, normalizar, buscar, comparar y resumir.', 'Cinco pasos en una hoja de cálculo.'),
]);

return [
    'slug' => 'conciliar-dos-listados-en-excel-con-formulas-trampas-contar-si-igual-libro',
    'title' => 'Conciliar dos listados en Excel con fórmulas: las trampas de CONTAR.SI y del signo = (libro verificado)',
    'excerpt' => 'Cómo comparar dos listados de estudiantes solo con fórmulas de Excel: normalizar texto, buscar llaves, detectar ceros perdidos y conflictos, y evitar dos trampas (CONTAR.SI trata 0012 como 12 y el signo = ignora mayúsculas).',
    'seo_title' => 'Conciliar dos listados en Excel con fórmulas',
    'seo_description' => 'Concilia dos listados en Excel con fórmulas: normaliza, busca llaves y compara, y evita las trampas de CONTAR.SI y del signo =.',
    'focus_keyword' => 'conciliar dos listados en Excel',
    'cover' => '/assets/img/articulos/conciliar-listados-excel/conciliar-listados-excel-portada',
    'cover_alt' => 'Portada "Conciliar dos listados en Excel: las trampas de CONTAR.SI y el signo =" con una tarjeta: 0012 = 12 para CONTAR.SI, la trampa que esconde a un estudiante distinto.',
    'published_at' => '2027-02-11 12:00:00',
    'content_html' => $html,
];
