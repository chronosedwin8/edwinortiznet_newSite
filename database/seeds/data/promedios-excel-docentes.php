<?php

declare(strict_types=1);

// "Promedios en Excel para docentes: siete errores que cambian una nota". Siete casos con datos ficticios, resultados verificados en Microsoft Excel 16 (es-CO): 3,50 vs 3,25; 3,20 vs 4,00; 4,25 vs 4,00; 3,40 vs 3,67; 2,95 vs 3,00; 3,60 vs 4,00; 1,60 vs 5,60. Verificado el 10 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/promedios-excel-docentes/' . $name;
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
<p>Un estudiante pierde la materia por una centésima. Otro pasa con una nota que, en realidad, era un 2,95. Un tercero tiene un promedio que no coincide con el de la plataforma del colegio. Cuando las notas se calculan en Excel, <strong>una fórmula mal puesta puede cambiar el resultado de una persona</strong> y casi nunca da error: simplemente muestra un número creíble.</p>
<p>Este artículo reúne siete errores frecuentes al calcular promedios en Excel, con <strong>resultados verificados</strong> en un <a href="/descargas/promedios-excel/siete-errores-promedios-excel.xlsx">libro de ejemplo descargable</a>: cada hoja muestra el error, la fórmula que lo produce, el efecto sobre el resultado y la corrección. Todo se probó en Microsoft Excel 16 con configuración regional es-CO y datos ficticios, en la escala de 1,0 a 5,0. Verificado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Los siete errores: promediar promedios de grupos de distinto tamaño (3,50 en lugar de 3,25), contar como cero una nota pendiente (3,20 en lugar de 4,00), notas guardadas como texto (4,25 en lugar de 4,00), un rango que no incluye la última nota (3,40 en lugar de 3,67), un redondeo que solo se ve (2,95 que se muestra como 3,0), pesos que no suman 100 % (3,60 en lugar de 4,00) y una referencia sin anclar al copiar la fórmula (1,60 en lugar de 5,60). Las reglas de redondeo y de tratamiento de notas pendientes las define el SIEE de cada colegio.</p>

<h2>Por qué importa: un promedio decide cosas</h2>
<p>En Colombia, el Sistema Institucional de Evaluación de los Estudiantes (SIEE) de cada colegio define la escala de valoración y su equivalencia con la escala nacional (Superior, Alto, Básico y Bajo), y la promoción depende de esos valores. Una nota de 2,95 frente a 3,0 puede ser la diferencia entre "Bajo" y "Básico". Por eso el cálculo debe ser <strong>correcto, verificable y coherente con las reglas del SIEE</strong>. (Para la discusión sobre qué miden las notas, ver <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">las calificaciones: ¿aprendizaje o cumplimiento?</a>.)</p>
{{img:efectos}}

<h2>Error 1: promediar los promedios de grupos de distinto tamaño</h2>
<p><strong>Caso.</strong> Un grupo A de 10 estudiantes tiene promedio 4,0 y un grupo B de 30 tiene promedio 3,0. ¿Cuál es el promedio de los 40?</p>
<pre><code>=PROMEDIO(B4;B6)                         ' español: 3,50   (error)
=(B3*B4+B5*B6)/(B3+B5)                   ' español: 3,25   (correcto)

=AVERAGE(B4,B6)                          ' inglés
=(B3*B4+B5*B6)/(B3+B5)</code></pre>
<p><strong>Por qué falla.</strong> El promedio de los dos promedios trata a los grupos como si pesaran igual, cuando B tiene tres veces más estudiantes. El resultado correcto pondera por tamaño: 3,25. Esto aparece cuando se saca el "promedio institucional" a partir de promedios por curso.</p>

<h2>Error 2: contar como cero una nota pendiente</h2>
<p><strong>Caso.</strong> Cinco talleres: 4,0; 3,5; pendiente; 4,5; 4,0. Alguien escribió 0 en el pendiente "para no dejar la celda vacía".</p>
<pre><code>=PROMEDIO(B3:B7)                         ' con el 0: 3,20
=PROMEDIO(B3:B4;B6:B7)                   ' sin contar el pendiente: 4,00</code></pre>
<p><strong>Por qué falla.</strong> Un 0 es una nota; una celda vacía es "todavía no hay". <code>PROMEDIO</code> ignora las celdas vacías, pero cuenta los ceros. La diferencia, en este caso, es de 0,80 puntos. Cómo tratar un trabajo no presentado (cero, nota mínima, oportunidad de entrega) es una decisión que define el SIEE; lo que no puede ocurrir es que Excel la tome sin que nadie la haya decidido.</p>

<h2>Error 3: notas guardadas como texto</h2>
<p><strong>Caso.</strong> Cuatro notas: 4,0; "3,5" (texto); 4,5; "4,0" (texto), pegadas desde otro sistema.</p>
<pre><code>=PROMEDIO(B3:B6)                         ' ignora el texto: 4,25  (solo promedia 4,0 y 4,5)
=SUMAPRODUCTO(VALOR(B3:B6))/CONTARA(B3:B6)   ' convierte: 4,00</code></pre>
<p><strong>Por qué falla.</strong> <code>PROMEDIO</code> ignora el texto sin avisar: promedió solo dos de las cuatro notas. Se reconoce porque el valor queda alineado a la izquierda o aparece un triángulo verde en la celda. La conversión con <code>VALOR</code> depende de la configuración regional (ver <a href="/compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional/">compatibilidad de libros de Excel entre equipos</a>), así que lo mejor es corregir el dato en el origen y usar <em>validación de datos</em> para que solo acepte números entre 1,0 y 5,0.</p>

<h2>Error 4: un rango que no incluye la última nota</h2>
<p><strong>Caso.</strong> Se escribió <code>=PROMEDIO(B3:B7)</code> cuando había cinco notas (3,0; 4,0; 5,0; 2,0; 3,0). Después se agregó una sexta (5,0) en la fila 8.</p>
<pre><code>=PROMEDIO(B3:B7)                         ' 3,40  (error: falta B8)
=PROMEDIO(B3:B8)                         ' 3,67  (correcto)</code></pre>
<p><strong>Por qué falla.</strong> Las fórmulas no saben que se agregó una nota debajo. La defensa es convertir los datos en una <strong>tabla de Excel</strong> (el rango crece solo), o contar las notas y compararlas: <code>=CONTAR(B3:B8)</code> frente al número de actividades.</p>

<h2>Error 5: el redondeo que solo se ve</h2>
<p><strong>Caso.</strong> Dos componentes: 3,0 y 2,9, ambos de peso 50 %. La definitiva es 2,95, pero con un decimal en el formato de la celda se ve <strong>3,0</strong>.</p>
<pre><code>=B3*0,5+B4*0,5                           ' vale 2,95; se muestra 3,0
=SI(B5>=3;"Aprueba";"No aprueba")        ' compara 2,95: "No aprueba"
=SI(REDONDEAR(B5;1)>=3;"Aprueba";"No aprueba")   ' si el SIEE redondea a un decimal: "Aprueba"</code></pre>
<p><strong>Por qué falla.</strong> El <em>formato</em> cambia lo que se ve, no lo que vale. Una celda que muestra 3,0 puede valer 2,95, y las comparaciones usan el valor real. Es probablemente el error más injusto, porque el estudiante ve un 3,0 en la hoja y una decisión que no corresponde. La solución es decidir (según el SIEE) a cuántos decimales se redondea y aplicarlo <strong>con la función</strong>, no con el formato, antes de comparar.</p>

<h2>Error 6: pesos que no suman 100 %</h2>
<p><strong>Caso.</strong> Parcial 4,0; taller 3,0; proyecto 5,0, cada uno con peso 30 % (suman 90 %, no 100 %).</p>
<pre><code>=SUMAPRODUCTO(B3:B5;C3:C5)               ' 3,60  (error: pesos suman 90 %)
=SUMAPRODUCTO(B3:B5;C3:C5)/SUMA(C3:C5)   ' 4,00  (normalizado)</code></pre>
<p><strong>Por qué falla.</strong> Si los pesos no suman 100 %, la nota queda por debajo (o por encima) de lo que corresponde. La normalización (dividir entre la suma de pesos) disimula el problema; es mejor <strong>validar que sumen 100 %</strong> y arreglar los pesos. Una celda de control (<code>=SUMA(C3:C5)</code> con formato condicional que se pone roja si no es 100 %) lo evita.</p>

<h2>Error 7: la referencia relativa al copiar la fórmula</h2>
<p><strong>Caso.</strong> El peso del trabajo (40 %) está en una celda. La primera fila funciona; al copiar la fórmula hacia abajo, la referencia al peso se corre.</p>
<pre><code>' Fila 3 (correcta), fila 4 (la referencia se corre a E3, vacía), etc.
=B3*E2        =B4*E3        =B5*E4        =B6*E5     ' suma: 1,60
=B3*$E$2      =B4*$E$2      =B5*$E$2      =B6*$E$2   ' suma: 5,60 (correcto)</code></pre>
<p><strong>Por qué falla.</strong> Una referencia relativa se desplaza al copiar; el signo <code>$</code> la ancla. Con cuatro estudiantes, la suma con error da 1,60 en lugar de 5,60, porque solo la primera fila usó el peso. Se reconoce porque las filas de abajo dan 0. Regla práctica: <strong>todo parámetro (peso, meta, umbral) va en una celda y se referencia con signo $</strong>, o mejor, con un nombre definido.</p>

<h2>Una lista para revisar un libro de notas</h2>
<ol>
<li><strong>Cuenta las notas:</strong> compara <code>CONTAR</code> con el número esperado de actividades por estudiante.</li>
<li><strong>Busca texto entre los números:</strong> <code>=CONTARA(rango)-CONTAR(rango)</code> debe dar 0.</li>
<li><strong>Revisa los ceros:</strong> ¿son notas reales o pendientes?</li>
<li><strong>Verifica que los pesos sumen 100 %</strong> con una celda de control.</li>
<li><strong>Decide y documenta el redondeo</strong> (según el SIEE) y aplícalo con <code>REDONDEAR</code>.</li>
<li><strong>Ancla los parámetros</strong> con $ o nombres.</li>
<li><strong>Calcula dos estudiantes a mano</strong> y compara con la hoja.</li>
<li><strong>Protege las fórmulas</strong> y guarda una copia antes de cada corte (ver <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel</a>).</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En todo el mundo, las hojas de cálculo son la herramienta por defecto de muchos docentes para llevar notas, y los errores de fórmulas en hojas de cálculo son un problema documentado en toda clase de organizaciones. En Colombia y Latinoamérica el riesgo se agrava por la mezcla de plataformas (el colegio tiene una plataforma oficial y cada docente lleva su Excel) y por la presión de los cortes. Para los <strong>docentes</strong>, la lección es auditar su propio libro antes de entregar notas; para los <strong>directivos</strong>, definir en el SIEE cómo se calculan y se redondean las notas, y contrastar el libro con la plataforma; para las <strong>familias</strong>, preguntar con calma cómo se calculó una nota; y para los <strong>estudiantes</strong>, entender que una nota tiene una fórmula que se puede revisar. Y cuando el libro crece, con varios docentes editando, conviene una herramienta específica (ver <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">cuándo Excel deja de ser la solución</a>).</p>

<h2>Plantillas ya armadas</h2>
<p>Si prefieres partir de plantillas con controles, mira estas opciones. Y para pedir ayuda a una IA con tus fórmulas (siempre verificando el resultado y sin pegar datos de estudiantes en herramientas gratuitas), hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL!, #CALC! y #VALUE!</a>, <a href="/listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla/">listas desplegables dependientes</a> y <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">un dashboard que ayude a actuar</a>. Para quienes llevan notas con IA, mira también <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA gratuita</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Por qué Excel muestra 3,0 si la nota es 2,95?</h3>
<p>Porque el formato de la celda muestra un decimal, pero el valor almacenado es 2,95. Para que el valor cambie hay que redondear con la función REDONDEAR, según la regla del SIEE.</p>
<h3>¿PROMEDIO cuenta las celdas vacías?</h3>
<p>No: ignora las celdas vacías y el texto, pero sí cuenta los ceros.</p>
<h3>¿Cómo calculo un promedio ponderado en Excel?</h3>
<p>Con SUMAPRODUCTO de las notas y los pesos, dividido entre la suma de los pesos (que debe ser 100 %): =SUMAPRODUCTO(notas;pesos)/SUMA(pesos).</p>
<h3>¿Cómo evito que mi fórmula deje por fuera una nota nueva?</h3>
<p>Convierte los datos en una tabla de Excel, para que el rango crezca solo, y compara el conteo de notas con lo esperado.</p>
<h3>¿Qué es una referencia anclada?</h3>
<p>Una referencia con signo $ (por ejemplo, $E$2) que no se desplaza al copiar la fórmula a otras celdas.</p>

<p class="notice"><strong>Revisa tu libro de notas hoy.</strong> Descarga el <a href="/descargas/promedios-excel/siete-errores-promedios-excel.xlsx">libro de siete errores</a>, mira cada caso y aplica la lista de revisión a tu propio libro antes del próximo corte.</p>

<h2>Para pensar</h2>
<p>Una nota es una decisión sobre una persona expresada en un número, y ese número sale de una fórmula que casi nadie revisa. <strong>¿Debería un colegio exigir que los libros de notas de los docentes se auditen, o eso sería desconfiar del oficio? Y cuando una nota mal calculada perjudica a un estudiante, ¿quién responde: el docente que armó la hoja, el colegio que no la revisó o el sistema que obliga a calcular a mano?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:efectos}}' => $img('promedios-excel-docentes-efectos', 663, 'Tabla con siete errores al calcular promedios en Excel y su efecto: promediar promedios 3,50 frente a 3,25, pendiente como cero 3,20 frente a 4,00, notas como texto 4,25 frente a 4,00, rango incompleto 3,40 frente a 3,67, redondeo 2,95 frente a 3,00, pesos de 90 % 3,60 frente a 4,00 y referencia sin anclar 1,60 frente a 5,60.', 'El mismo dato, dos resultados.'),
]);

return [
    'slug' => 'promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota',
    'title' => 'Promedios en Excel para docentes: siete errores que cambian una nota, con un libro de ejemplo verificado',
    'excerpt' => 'Siete errores frecuentes al calcular promedios en Excel (promedios de promedios, ceros, texto, rangos, redondeo, pesos y referencias), cada uno con su fórmula, su efecto verificado y su corrección, en un libro descargable.',
    'seo_title' => 'Promedios en Excel para docentes: 7 errores comunes',
    'seo_description' => 'Siete errores al calcular promedios y notas en Excel (ceros, texto, redondeo, pesos, referencias) con resultados verificados y un libro de ejemplo.',
    'focus_keyword' => 'promedios en Excel para docentes',
    'cover' => '/assets/img/articulos/promedios-excel-docentes/promedios-excel-docentes-portada',
    'cover_alt' => 'Portada "Promedios en Excel para docentes: siete errores que cambian una nota" con una tarjeta: promedio de dos grupos de distinto tamaño, 3,50 si se promedian los promedios frente a 3,25 si se pondera, y otros dos ejemplos de errores.',
    'published_at' => '2026-12-23 12:00:00',
    'content_html' => $html,
];
