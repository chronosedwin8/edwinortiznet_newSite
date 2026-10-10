<?php

declare(strict_types=1);

// "Presupuesto limitado con Solver". Libro verificado: Solver ejecutado en Excel 16 (SolverOk/SolverAdd/SolverSolve, Simplex LP, binarias; resultado 0) y enumeración de 1.024 combinaciones en Python: 10 proyectos ($214 M), presupuesto $120 M, mínimo 2 pedagógicos, Wi-Fi excluyentes; óptimo P1,P3,P4,P5,P6,P8: costo 120, beneficio 287 (único); voraz por relación y baratos primero: 279 (costo 113); sensibilidad: 100→254, 110→265, 120→287, 130→307, 140→331. Fondo de Servicios Educativos citado como referencia con aviso de verificar. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/presupuesto-solver/' . $name;
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
<p>El consejo directivo tiene una lista de diez proyectos: reparar el techo del patio, mejorar el Wi-Fi, renovar la biblioteca, equipar el laboratorio, capacitar docentes, instalar cámaras, pintar las aulas, comprar computadores, material deportivo. Costarían $214 millones. Hay $120 millones. Alguien propone "ir de lo más barato a lo más caro"; otro, "primero lo más urgente"; un tercero, "lo que más beneficio dé por cada peso". Cada regla suena razonable y <strong>cada una produce un plan distinto</strong>. ¿Cómo saber cuál es el mejor, o si hay uno mejor que los tres?</p>
<p>Este artículo muestra cómo plantear esa decisión como un <strong>modelo de optimización</strong> y resolverla con <strong>Solver</strong>, el complemento de Excel. Incluye un <a href="/descargas/presupuesto-limitado-solver/presupuesto-limitado-solver.xlsx">libro de Excel</a> con el modelo ya configurado: diez proyectos ficticios, tres restricciones y una comparación entre el plan óptimo y dos reglas sencillas. El óptimo lo verifiqué de dos maneras: ejecutando Solver en Microsoft Excel 16 y enumerando las 1.024 combinaciones posibles con un cálculo independiente; coinciden.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios (costos en millones de pesos y "beneficio" en puntos de un comité imaginario). Un modelo de optimización no decide por ti: <strong>optimiza lo que le pides con los números que le das</strong>, y si esos números son discutibles, el resultado también lo es. Las decisiones de presupuesto de un colegio tienen reglas y órganos propios (en los colegios oficiales, el presupuesto del Fondo de Servicios Educativos lo aprueba el consejo directivo; verifica el Decreto 1075 de 2015 y las reglas de tu secretaría). Úsalo para ordenar la discusión, no para cerrarla.</p>

<h2>Tres ingredientes de un modelo</h2>
{{img:ingredientes}}
<ol>
<li><strong>Variables de decisión:</strong> lo que puedes elegir. Aquí, una celda por proyecto con 1 (se hace) o 0 (no se hace).</li>
<li><strong>Función objetivo:</strong> lo que quieres maximizar o minimizar. Aquí, el beneficio total: la suma de los puntos de los proyectos elegidos.</li>
<li><strong>Restricciones:</strong> lo que no puedes violar. Aquí: (a) el costo total no puede superar $120 millones; (b) debe haber al menos 2 proyectos pedagógicos; (c) el Wi-Fi completo y el básico son excluyentes (como máximo uno).</li>
</ol>
<p>Cuando las variables son 0 o 1 y las relaciones son lineales (sumas de costos o de beneficios), se trata de un problema de <em>programación lineal entera</em>, de la familia de los llamados "problemas de la mochila". Solver los resuelve con el método <em>Simplex LP</em> y variables binarias.</p>
<pre><code>' Costo total y beneficio total del plan (selección en F4:F13, costos en D, beneficios en E)
=SUMAPRODUCTO(F4:F13;D4:D13)              ' español
=SUMAPRODUCTO(F4:F13;E4:E13)
=SUMPRODUCT(F4:F13,D4:D13)                ' inglés
=SUMPRODUCT(F4:F13,E4:E13)

' Proyectos pedagógicos elegidos
=SUMAPRODUCTO((C4:C13="Pedagógico")*F4:F13)       ' español
=SUMPRODUCT((C4:C13="Pedagógico")*F4:F13)         ' inglés

' Relación beneficio por millón (para la regla voraz)
=Modelo!E4/Modelo!D4</code></pre>

<h2>Cómo configurar Solver (paso a paso)</h2>
<ol>
<li><strong>Activa el complemento</strong> si no ves el botón: Archivo, Opciones, Complementos, Administrar "Complementos de Excel", Ir, y marca <em>Solver</em>. Aparecerá en la pestaña <em>Datos</em>.</li>
<li><strong>Establecer objetivo:</strong> la celda del beneficio total (G16), con la opción <em>Máx</em>.</li>
<li><strong>Cambiando las celdas de variables:</strong> el rango de selección (F4:F13).</li>
<li><strong>Sujeto a las restricciones</strong> (botón <em>Agregar</em>): F4:F13 = <em>bin</em>; costo total (G15) ≤ presupuesto (Parametros!B3); pedagógicos (G17) ≥ mínimo (Parametros!B4); Wi-Fi (G18) ≤ 1 (Parametros!B5).</li>
<li><strong>Método de resolución:</strong> <em>Simplex LP</em>, y asegúrate de que la opción de convertir variables sin restricciones en no negativas esté marcada. Pulsa <em>Resolver</em>.</li>
<li><strong>Revisa el resultado,</strong> no solo la respuesta: confirma que cada restricción se cumple (el libro lo marca en la columna I) y guarda la solución.</li>
</ol>
<p>Los nombres de los botones pueden variar levemente según la versión y el idioma de Excel. El libro ya trae el modelo configurado y la solución cargada; al abrir Solver verás los parámetros, y puedes cambiar el presupuesto o los puntajes y volver a resolver.</p>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
<p>Diez proyectos por $214 millones, un presupuesto de $120 millones:</p>
<ul>
<li><strong>Plan óptimo (Solver):</strong> reparar el techo del patio (P1), Wi-Fi básico (P3), renovar los libros (P4), equipar el laboratorio (P5), capacitación docente (P6) y pintar las aulas (P8). Cuesta <strong>$120 millones</strong>, usa todo el presupuesto, incluye 3 proyectos pedagógicos y suma <strong>287 puntos</strong> de beneficio. Es el único plan óptimo del ejemplo.</li>
<li><strong>Regla "mayor beneficio por millón primero":</strong> elige P6, P3, P4, P10, P5, P7 y P8, cuesta $113 millones y suma <strong>279 puntos</strong>, ocho menos que el óptimo. El problema: llega al proyecto de mayor beneficio individual, el techo (72 puntos), cuando ya no le caben los $35 millones, y le sobran $7 millones sin usar.</li>
<li><strong>Regla "los más baratos primero":</strong> en este ejemplo da el mismo plan de 279 puntos.</li>
<li><strong>Las reglas sencillas no están mal;</strong> están a 8 puntos (casi 3 %) del óptimo, lo que puede ser aceptable o no según lo que esté en juego. Lo que el modelo ofrece es una referencia contra la cual medirlas.</li>
</ul>
{{img:sensibilidad}}
<p>Y una segunda pregunta, quizá más útil que la primera: <strong>¿qué pasa si cambia el presupuesto?</strong> La hoja <em>Sensibilidad</em> (calculada por enumeración) muestra que con $100 millones el beneficio óptimo es 254; con $110, 265; con $120, 287; con $130, 307, y con $140, 331. Cada $10 millones adicionales compran entre 11 y 24 puntos, y el plan cambia de proyectos: con $100 millones deja de lado el techo y elige las cámaras. Eso ayuda a negociar: <em>"con 10 millones más podemos sumar el material deportivo y llegar a 307"</em>.</p>
<p><strong>Una lectura honesta:</strong> el óptimo es óptimo <em>para esos puntajes</em>. Si el comité hubiera calificado el techo con 60 en lugar de 72, el plan cambiaría. Además, el modelo ignora cosas que importan: la urgencia (un techo que se cae no es un proyecto más), la equidad entre sedes o niveles, los costos de mantenimiento, las dependencias entre proyectos y lo que dice la comunidad. Una buena práctica es tratar el resultado como una propuesta que se discute, probar cómo cambia con otros puntajes y fijar a mano (con una restricción) lo que es obligatorio.</p>

<h2>Cómo construir los puntajes</h2>
<ol>
<li><strong>Define criterios</strong> (impacto en el aprendizaje, seguridad, equidad, número de beneficiarios, urgencia) y sus pesos antes de calificar los proyectos.</li>
<li><strong>Califica por separado</strong> (varios integrantes del comité, sin ver los puntajes de los demás) y promedia.</li>
<li><strong>Convierte las condiciones obligatorias en restricciones</strong>, no en puntajes altos (por ejemplo, "el techo debe estar en el plan").</li>
<li><strong>Prueba la sensibilidad:</strong> cambia pesos y puntajes y observa si el plan se mantiene o cambia mucho. Si cambia, la discusión debe centrarse en esos proyectos.</li>
<li><strong>Documenta y comunica</strong> los supuestos junto con el resultado (ver <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">el presupuesto ejecutado, comprometido y disponible</a> y <a href="/costos-unitarios-colegio-excel-costo-por-estudiante-reparto-punto-de-equilibrio/">los costos unitarios</a>).</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La optimización con restricciones es una herramienta estándar en la gestión de proyectos, la logística y las finanzas, y en el sector público se usa para priorizar inversión, entre otros fines. En los colegios, la práctica habitual es priorizar por urgencia, por presión de la comunidad o por lo que se aprobó el año anterior, con poca documentación de los criterios. En Colombia, la inversión de los colegios oficiales se ejecuta con recursos de transferencias y fondos de servicios educativos sujetos a normas de contratación y presupuesto; en los privados, con las tarifas autorizadas. Ninguna técnica reemplaza esas normas ni la deliberación del consejo directivo.</p>
<p>Para los <strong>directivos</strong>, un modelo transparente permite explicar por qué se eligió un proyecto y no otro; para los <strong>docentes</strong>, que se vea cómo se valoran las necesidades de cada área; para las <strong>familias</strong>, entender que "no alcanza" es una restricción y que elegir implica renunciar; y para los <strong>estudiantes</strong>, que las decisiones de inversión tengan en cuenta su seguridad y su aprendizaje, y no solo lo más visible.</p>

<h2>Herramientas y plantillas</h2>
<p>Si trabajas con las plantillas de Excel del sitio y quieres apoyo, o preparas material con IA (revisando siempre lo que produce y sin incluir datos financieros confidenciales en herramientas que no estén diseñadas para custodiarlos), mira estos productos.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: el <a href="/descargas/presupuesto-limitado-solver/presupuesto-limitado-solver.xlsx">libro del presupuesto limitado con Solver</a>, <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel con inteligencia artificial</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es Solver?</h3>
<p>Un complemento de Excel que busca los valores de unas celdas (variables) que maximizan o minimizan el resultado de otra (objetivo), respetando restricciones.</p>
<h3>¿Cómo activo Solver en Excel?</h3>
<p>Archivo, Opciones, Complementos, Administrar "Complementos de Excel", Ir, y marca Solver. Aparece en la pestaña Datos.</p>
<h3>¿Por qué usar variables binarias?</h3>
<p>Porque cada proyecto se hace entero o no se hace; la restricción "bin" fuerza que cada celda sea 0 o 1.</p>
<h3>¿El resultado de Solver es siempre el mejor?</h3>
<p>Es el mejor para el modelo que le diste. Si los puntajes o las restricciones son discutibles, el resultado también. Y puede haber varios planes igual de buenos.</p>
<h3>¿Qué hago si el plan óptimo no me convence?</h3>
<p>Revisa los puntajes y las restricciones: quizá falta una restricción que refleje algo obligatorio, o los puntajes subestiman un proyecto. Cambia y vuelve a resolver.</p>

<p class="notice"><strong>Prueba el modelo con tus proyectos.</strong> Descarga el <a href="/descargas/presupuesto-limitado-solver/presupuesto-limitado-solver.xlsx">libro del presupuesto limitado con Solver</a>, reemplaza los proyectos, costos y puntajes por los de tu colegio, cambia el presupuesto y vuelve a ejecutar Solver para ver cómo cambia el plan.</p>

<h2>Para pensar</h2>
<p>Un número que le damos a un modelo parece neutral, pero detrás de cada puntaje hay un juicio sobre qué importa más. <strong>¿Quién califica hoy las necesidades de tu colegio y con qué criterios? Y si un proyecto que importa a pocos pero es esencial para ellos tiene un puntaje bajo, ¿cómo evitamos que el modelo lo deje siempre fuera?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ingredientes}}' => $img('presupuesto-solver-ingredientes', 499, 'Tabla con los cuatro ingredientes de un modelo de Solver y el ejemplo de cada uno: variables, objetivo, restricciones y método.', 'Qué le dices a Solver.'),
    '{{img:sensibilidad}}' => $img('presupuesto-solver-sensibilidad', 480, 'Gráfico de barras con el beneficio óptimo según el presupuesto: 254 con 100, 265 con 110, 287 con 120, 307 con 130 y 331 con 140 millones.', 'Beneficio óptimo según el presupuesto.'),
]);

return [
    'slug' => 'presupuesto-limitado-solver-excel-elegir-proyectos-cuando-no-alcanza-modelo',
    'title' => 'Presupuesto limitado con Solver: cómo elegir qué proyectos hacer cuando no alcanza, con un modelo de Excel verificado',
    'excerpt' => 'Cómo plantear la elección de proyectos con presupuesto limitado como un modelo (variables, objetivo y restricciones) y resolverla con Solver, comparando el óptimo con reglas sencillas y viendo qué pasa si cambia el presupuesto.',
    'seo_title' => 'Presupuesto limitado con Solver en Excel: elegir proyectos',
    'seo_description' => 'Cómo usar Solver para elegir proyectos con presupuesto limitado: variables, objetivo y restricciones, óptimo frente a reglas sencillas, en un libro de Excel.',
    'focus_keyword' => 'Solver presupuesto limitado Excel',
    'cover' => '/assets/img/articulos/presupuesto-solver/presupuesto-solver-portada',
    'cover_alt' => 'Portada "Presupuesto limitado con Solver: elegir qué proyectos hacer cuando no alcanza" con una tarjeta: 287 frente a 279 puntos de beneficio, el plan óptimo frente a elegir por mayor relación beneficio/costo.',
    'published_at' => '2027-03-04 12:00:00',
    'content_html' => $html,
];
