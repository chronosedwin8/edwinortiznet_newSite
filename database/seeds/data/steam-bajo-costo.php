<?php

declare(strict_types=1);

// "STEAM sin equipos costosos". Fuentes consultadas el 10-oct-2026: Yakman (2006) y revisión de Perignat y Katz-Buonincontro (2019) vía Frontiers in Education 2024; Minciencias (programa Ondas, desde 2001); Stanford/NPR 2014 (Foldscope, ~US$0,50 a US$1). Plantilla verificada en Excel 16: 35.500 COP total, 1.183 por estudiante, 3/7 no comprados, rúbrica 3,20, promedio banco 4.750.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/steam-bajo-costo/' . $name;
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
<p>"Nos gustaría hacer STEAM, pero no tenemos laboratorio, ni impresora 3D, ni kits de robótica." Es una de las frases más repetidas cuando se habla de proyectos de ciencia, tecnología, ingeniería, artes y matemáticas en colegios con presupuesto limitado. Y esconde un malentendido: <strong>lo que hace valioso a un proyecto STEAM no es el equipo, sino la pregunta, la medición y la mejora</strong>.</p>
<p>Este artículo propone un diseño de proyecto que se puede hacer con materiales cotidianos y reciclados, con una <a href="/descargas/steam-bajo-costo/plantilla-steam-bajo-costo.xlsx">plantilla descargable en Excel</a> (ficha de proyecto, presupuesto, rúbrica de cinco criterios y un banco de ocho ideas), verificada en Microsoft Excel 16 con datos de ejemplo. Datos y fuentes revisados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los precios de la plantilla están en pesos colombianos y son de ejemplo: reemplázalos con los de tu zona. La rúbrica es una propuesta de elaboración propia; la escala y la forma de calificar las define el sistema institucional de evaluación (SIEE) de cada colegio. Los proyectos que implican electricidad, calor o herramientas cortantes requieren supervisión adulta y las medidas de seguridad correspondientes.</p>

<h2>Qué es (y qué no es) STEAM</h2>
<p>El marco más citado es el de Georgette Yakman, quien en 2006 propuso incorporar las artes a los campos de STEM (ciencia, tecnología, ingeniería y matemáticas). Pero no hay una única definición: según una revisión de la literatura entre 2007 y 2018 (Perignat y Katz-Buonincontro, 2019), los autores discrepan sobre qué significa integrar, cuál es el papel de las artes y cuál es el propósito de STEAM. Y la evidencia de que STEAM mejora resultados concretos, como el rendimiento en ciencias, es todavía mixta y se apoya sobre todo en estudios pequeños o cualitativos. Dicho de otro modo: <strong>STEAM es una buena idea pedagógica con evidencia en construcción, no una garantía</strong>, y conviene evaluarla en el aula con sus propios datos (ver <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">cómo probar una herramienta educativa en cuatro semanas</a>).</p>
<p>Lo que sí sugiere el sentido común pedagógico es que la integración funciona cuando cada área cumple una función, y no cuando se "decora" un proyecto de ciencias con un dibujo:</p>
{{img:versiones}}

<h2>Cuatro principios para hacer STEAM sin equipos costosos</h2>
<ol>
<li><strong>Empieza por la pregunta, no por el material.</strong> "¿Dónde sopla más fuerte el viento en el colegio?" es una pregunta medible; "hagamos un molino" es una actividad.</li>
<li><strong>Mide algo.</strong> Sin datos no hay ciencia ni matemáticas; basta un cronómetro del celular, una regla o un vaso medidor.</li>
<li><strong>Exige una segunda versión.</strong> Diseñar, probar y mejorar es el corazón de la ingeniería. El proyecto que se entrega al primer intento ahorra tiempo y pierde el aprendizaje.</li>
<li><strong>Dale un público real</strong> al producto: otro curso, las familias, la dirección del colegio. El arte, entonces, tiene una función (comunicar con claridad), no solo decorativa.</li>
</ol>
{{img:ciclo}}

<h2>Un caso completo: el anemómetro de vasos</h2>
<p>La ficha de ejemplo de la plantilla desarrolla este proyecto en cuatro sesiones de 55 minutos. <strong>Pregunta:</strong> ¿cómo podemos comparar la fuerza del viento en tres lugares del colegio con un instrumento que construimos? Un anemómetro de vasos tiene vasos (o conos) sujetos a brazos que giran con el viento; al contar las vueltas por minuto se obtiene una medida <em>relativa</em> de la fuerza del viento.</p>
<ol>
<li><strong>Sesión 1 (pregunta y diseño):</strong> cada grupo propone un diseño y predice dónde habrá más viento. Se discute qué variables controlar (la altura, el momento del día, el tiempo de conteo).</li>
<li><strong>Sesión 2 (versión 1 y prueba):</strong> se construye, se marca un vaso con color para contar vueltas y se mide en los tres lugares, tres veces cada uno, durante un minuto.</li>
<li><strong>Sesión 3 (mejora):</strong> se analizan los datos, se identifica qué falló (por ejemplo, fricción en el eje o vasos desiguales) y se construye la versión 2.</li>
<li><strong>Sesión 4 (comunicación):</strong> se calcula el promedio por lugar, se comparan las dos versiones y se elabora un afiche con una conclusión.</li>
</ol>
<p><strong>Una advertencia honesta:</strong> un instrumento casero no está calibrado; sirve para <em>comparar</em> lugares y versiones, no para decir "el viento es de 12 km/h". Reconocer los límites del instrumento es parte de lo que se aprende.</p>
<p>El presupuesto del ejemplo (con precios de ejemplo en pesos colombianos): 20 palos de balso a $500, una caja de alfileres a $3.000, tres cintas adhesivas a $2.500 y cinco marcadores a $3.000, y vasos, cartón y tapas reciclados: <strong>$35.500 en total, $1.183 por estudiante con 30 estudiantes</strong>, con 3 de 7 materiales no comprados (42,9 %). La hoja Presupuesto lo calcula sola.</p>

<h2>La rúbrica de cinco criterios</h2>
<p>La rúbrica evalúa pregunta e investigación, diseño y mejora (ingeniería), medición y cálculo (matemáticas), comunicación y diseño (arte) y colaboración, cada uno con cuatro niveles descritos, y suma los pesos para comprobar que dan 100 %. En el ejemplo, con niveles 3, 4, 2, 3 y 4 y un peso de 20 % cada uno, el resultado ponderado es 3,20 en una escala de 1 a 4 (lectura orientativa "Logrado"). Úsala como retroalimentación en cada prueba, no solo al final (ver <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a>), y traduce el resultado a la escala de tu SIEE.</p>

<h2>Ocho ideas con materiales cotidianos</h2>
<p>La hoja Banco_de_ideas incluye, con pregunta guía, áreas implicadas y materiales: anemómetro de vasos, reloj de agua, puente de papel, germinación, filtro de agua, instrumentos musicales con tubos, mapa a escala del colegio y circuito con pila y bombillo. Los costos aproximados por grupo (entre $2.000 y $9.000, con un promedio de $4.750) son referenciales y deben verificarse en tu zona. Cada idea mantiene la misma lógica: una pregunta medible, un instrumento o prototipo, un dato y una mejora.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia existe una tradición de investigación escolar con acompañamiento institucional: el programa Ondas de Minciencias, que nació en 2001 y se define como una estrategia para fomentar la cultura de la ciencia, la tecnología y la innovación en niños, niñas y jóvenes a través de la investigación como estrategia pedagógica. Funciona con maestros que acompañan a los estudiantes en sus proyectos. En el mundo, la "ciencia frugal" muestra que la escasez de equipos no impide hacer ciencia: el Foldscope, un microscopio de papel diseñado en Stanford, se presentó en 2014 con un costo estimado de unos 50 centavos de dólar por unidad (con cifras de hasta un dólar según la fuente), y se ha usado en proyectos educativos en varias ciudades. Para los <strong>docentes</strong>, el desafío es diseñar la pregunta y la mejora, no conseguir equipos; para los <strong>directivos</strong>, dar tiempo y respaldo (una sesión de 55 minutos rara vez basta para iterar); para las <strong>familias</strong>, aportar materiales reciclados y preguntas, no resolver el proyecto; y para los <strong>estudiantes</strong>, atreverse a equivocarse en la primera versión. Ojo con la equidad: pedir materiales "bonitos" a las familias reproduce desigualdades; el reciclaje y el material de la institución las reducen. Para adaptar un proyecto a estudiantes con discapacidad o con barreras de aprendizaje, ver <a href="/herramientas/piar/">PIAR con IA</a> y <a href="/clases-que-funcionen-sin-conexion-modelo-planificacion-offline-first/">clases que funcionen sin conexión</a>.</p>

<h2>Herramientas y plantillas</h2>
<p>Para planear la secuencia y las evaluaciones del proyecto con ayuda de IA (siempre revisando lo que produce), mira el kit y el generador de exámenes, y las demás herramientas propias de este sitio.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">el error matemático que se repite</a>, <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">calificaciones: aprendizaje o cumplimiento</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué significa STEAM?</h3>
<p>Ciencia, tecnología, ingeniería, artes y matemáticas, integradas en proyectos. Hay varias definiciones; la más citada es la de Georgette Yakman (2006).</p>
<h3>¿Se puede hacer STEAM sin laboratorio ni computadores?</h3>
<p>Sí. Lo esencial es una pregunta medible, un prototipo, datos y una versión mejorada. El celular como cronómetro, una regla y materiales reciclados bastan para muchos proyectos.</p>
<h3>¿Cómo evalúo un proyecto STEAM?</h3>
<p>Con una rúbrica que valore la pregunta, el diseño y la mejora, la medición, la comunicación y la colaboración, y con retroalimentación en cada prueba. La nota final debe traducirse a la escala del SIEE de tu colegio.</p>
<h3>¿Cuánto cuesta un proyecto?</h3>
<p>Depende del diseño. En el ejemplo, 35.500 pesos para 30 estudiantes (1.183 por estudiante), con precios de ejemplo. La plantilla calcula el costo por estudiante con tus precios.</p>
<h3>¿STEAM mejora las notas de ciencias?</h3>
<p>La evidencia es mixta y se apoya en estudios pequeños. Conviene medirlo en tu aula, por ejemplo con una prueba corta antes y después.</p>

<p class="notice"><strong>Pruébalo esta semana.</strong> Descarga la <a href="/descargas/steam-bajo-costo/plantilla-steam-bajo-costo.xlsx">plantilla STEAM de bajo costo</a>, escoge una idea del banco y diligencia la ficha. Si el proyecto cabe en una página con una pregunta, un instrumento, un dato y una mejora, está listo.</p>

<h2>Para pensar</h2>
<p>A veces la falta de equipos es una excusa y a veces es una realidad dura. <strong>¿Qué proyectos que hoy parecen imposibles por falta de recursos serían posibles con una buena pregunta y una segunda versión? Y, al revés: ¿cuándo la falta de recursos es un problema de equidad que el ingenio del docente no debería tener que resolver solo?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:versiones}}' => $img('steam-bajo-costo-versiones', 499, 'Tabla que compara un proyecto STEAM decorativo con uno con propósito en cuatro elementos: pregunta, arte, matemáticas e ingeniería.', 'El mismo proyecto, dos versiones.'),
    '{{img:ciclo}}' => $img('steam-bajo-costo-ciclo', 467, 'Cinco pasos de un proyecto STEAM: preguntar, diseñar, probar, mejorar y comunicar.', 'El ciclo de un proyecto STEAM.'),
]);

return [
    'slug' => 'steam-sin-equipos-costosos-proyectos-materiales-cotidianos-plantilla',
    'title' => 'STEAM sin equipos costosos: proyectos con materiales cotidianos, presupuesto y rúbrica (plantilla)',
    'excerpt' => 'Cómo hacer proyectos STEAM con materiales cotidianos y reciclados: cuatro principios, un caso completo (anemómetro de vasos), presupuesto, rúbrica de cinco criterios y ocho ideas, en una plantilla de Excel.',
    'seo_title' => 'STEAM sin equipos costosos: plantilla y rúbrica',
    'seo_description' => 'Proyectos STEAM con materiales cotidianos: principios, un caso completo, presupuesto, rúbrica y ocho ideas en una plantilla de Excel para docentes.',
    'focus_keyword' => 'STEAM sin equipos costosos',
    'cover' => '/assets/img/articulos/steam-bajo-costo/steam-bajo-costo-portada',
    'cover_alt' => 'Portada "STEAM sin equipos costosos: proyectos con materiales cotidianos" con una tarjeta: 1.183 pesos por estudiante en el proyecto de ejemplo, un anemómetro de vasos con 30 estudiantes.',
    'published_at' => '2027-01-06 12:00:00',
    'content_html' => $html,
];
