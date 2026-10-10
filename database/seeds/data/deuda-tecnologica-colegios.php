<?php

declare(strict_types=1);

// "Más plataformas no es mejor educación: la deuda tecnológica silenciosa de los colegios". Fuentes verificadas el 9 de octubre de 2026: Informe GEM 2023 de la UNESCO, LearnPlatform EdTech Top 40 vía K-12 Dive (jul. 2023), TALIS 2024, Ley 1581 de 2012. Inventario de ejemplo con datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/deuda-tecnologica-colegios/' . $name;
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
<p>Un colegio empieza con una plataforma académica. Luego llega un aula virtual, después una aplicación para hablar con las familias, la plataforma de matemáticas que trajo un docente entusiasta, un generador de presentaciones con IA, el grupo de WhatsApp de cada curso… Cada decisión, por separado, parecía razonable. Juntas forman algo que casi nadie mide: una <strong>deuda tecnológica silenciosa</strong>, hecha de cuentas que nadie recuerda, datos repartidos en sitios que nadie controla y herramientas que hacen lo mismo con distinto nombre.</p>
<p>En este artículo explico qué es esa deuda, qué dicen los datos sobre el crecimiento de herramientas en las escuelas y propongo <strong>tres criterios</strong> (integración, utilidad pedagógica y sostenibilidad) para decidir qué se queda, qué se fusiona y qué se retira. Incluyo un <a href="/descargas/deuda-tecnologica/inventario-herramientas-colegio.xlsx">inventario descargable en Excel</a> con un colegio de ejemplo. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Más herramientas no significa mejor educación: la UNESCO advierte que hay poca evidencia robusta e independiente sobre el valor de la tecnología educativa y que los productos cambian en promedio cada 36 meses. Cada herramienta nueva suma costo, datos que proteger, capacitación y soporte. La solución no es prohibir, sino <strong>inventariar, puntuar y decidir</strong> con criterios explícitos y con quienes las usan.</p>

<h2>Qué es la deuda tecnológica</h2>
<p>El término "deuda técnica" lo propuso el programador Ward Cunningham en 1992 para describir los atajos de software que ahorran tiempo hoy y cobran intereses mañana. Aplicado a un colegio, la idea se extiende: cada herramienta adoptada sin criterio es un <strong>préstamo</strong> que se paga con mantenimiento, cuentas que gestionar, datos que proteger y atención de docentes que ya tienen poco tiempo. Los intereses son silenciosos porque no aparecen en un solo presupuesto: están repartidos entre rectoría, coordinación, sistemas y cada aula.</p>
<p>Las señales típicas: dos o tres herramientas para la misma función, docentes que digitan la misma información en varios sitios, cuentas de personas que ya no trabajan en el colegio, plataformas pagadas que usa un solo curso, y nadie que pueda decir con certeza dónde están los datos de los estudiantes.</p>

<h2>Lo que dicen los datos</h2>
<p>El <a href="https://gem-report-2023.unesco.org/">Informe de Seguimiento de la Educación en el Mundo 2023 de la UNESCO</a> concluye que existe poca evidencia robusta e imparcial sobre el valor agregado de la tecnología digital en la educación, que buena parte de la evidencia proviene de quienes la venden y que los productos cambian, en promedio, cada 36 meses, muchas veces antes de que se puedan evaluar. En una encuesta a docentes y administradores de 17 estados de EE. UU., solo el 11 % pidió evidencia revisada por pares antes de adoptar una herramienta.</p>
<p>Sobre el tamaño del problema, el informe EdTech Top 40 de LearnPlatform (hoy parte de Instructure), basado en uso real en distritos de EE. UU., reportó que los distritos usaron en promedio <strong>2.591 herramientas distintas</strong> en el año escolar 2022-23, frente a 2.547 el año anterior (según la <a href="https://www.k12dive.com/news/school-districts-ed-tech-use/685995/">cobertura de K-12 Dive</a>, julio de 2023). Son distritos con miles de estudiantes, no un colegio; pero muestran la tendencia: <strong>las herramientas se acumulan más rápido de lo que se retiran</strong>. En Colombia no encontré una cifra comparable publicada; por eso el primer paso es hacer tu propio inventario.</p>

<h2>Tres criterios para decidir</h2>
<p>Te propongo puntuar cada herramienta de 0 a 2 en tres criterios (marco de elaboración propia):</p>
{{img:criterios}}
<ol>
<li><strong>Integración.</strong> ¿Comparte datos con el sistema central (matrículas, notas, usuarios) o obliga a digitar dos veces? Una herramienta aislada genera inconsistencias y trabajo extra. 0 = isla; 1 = importa o exporta a mano; 2 = se integra de forma automática.</li>
<li><strong>Utilidad pedagógica.</strong> ¿Hay evidencia <em>local</em> de que mejora algo: asistencia, entrega de tareas, participación, resultados? No basta con que el proveedor lo prometa. 0 = no se usa; 1 = la usa un grupo pequeño; 2 = hay uso y evidencia.</li>
<li><strong>Sostenibilidad.</strong> ¿Tiene responsable, presupuesto y un plan para sacar los datos si se deja de usar? 0 = nadie responde; 1 = responsable sin presupuesto o sin plan de salida; 2 = responsable, presupuesto y salida.</li>
</ol>
<p>Con la suma (0 a 6) se sugiere una decisión: <strong>retirar o reemplazar</strong> si la utilidad es 0 o el puntaje es 2 o menos; <strong>fusionar</strong> si hay una función duplicada y existe una herramienta mejor puntuada; <strong>mantener</strong> con 5 o más; y <strong>revisar</strong> en los demás casos. Es un punto de partida para conversar, no un veredicto.</p>

<h2>Un colegio de ejemplo: 12 herramientas</h2>
<p>El inventario descargable trae un colegio ficticio con 12 herramientas y un gasto anual de 59,7 millones de pesos. Al puntuarlas, ocurre esto:</p>
<table>
<thead><tr><th>Decisión sugerida</th><th>Herramientas</th><th>Gasto anual</th></tr></thead>
<tbody>
<tr><td><strong>Mantener</strong></td><td>Plataforma académica, suite ofimática, formularios de evaluación</td><td>27,0 millones</td></tr>
<tr><td><strong>Revisar</strong></td><td>Aula virtual institucional, app de mensajería a familias, plataforma de matemáticas A, videoconferencia</td><td>21,9 millones</td></tr>
<tr><td><strong>Retirar o reemplazar</strong></td><td>Aula virtual de un docente, grupos de WhatsApp, plataforma de matemáticas B, generador de presentaciones con IA, plataforma de lectura sin uso</td><td>10,8 millones (18,1 %)</td></tr>
</tbody>
</table>
{{img:gasto}}
<p>Observa lo que revela el ejercicio. <strong>Tres funciones estaban duplicadas</strong> (aula virtual, comunicación con familias y práctica de matemáticas): la mitad de las herramientas competían entre sí. Una plataforma de lectura costaba 5,4 millones y puntuaba cero en utilidad. Y siete de las doce guardaban datos personales con una sostenibilidad baja, es decir, <strong>sin responsable o sin plan para sacar los datos</strong>. Ese último punto es el más serio: el tratamiento de datos de menores exige cuidado (ver <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">datos de estudiantes y personalización con IA</a>), y la Ley 1581 de 2012 obliga al responsable del tratamiento, en este caso el colegio, a responder por los datos que entrega a terceros.</p>
<p>Un cuidado: <strong>retirar no es borrar a ciegas</strong>. Antes de cerrar una herramienta, consulta a quienes la usan, respalda sus datos y define cuándo y cómo se eliminan los de los estudiantes.</p>

<h2>Cómo hacerlo en tres semanas</h2>
<ol>
<li><strong>Semana 1: inventario.</strong> Lista todas las herramientas (incluidas las gratuitas y las que adoptó un docente por su cuenta): función, usuarios, costo, datos que maneja y responsable. Pregunta a los docentes; las cuentas "invisibles" aparecen ahí.</li>
<li><strong>Semana 2: puntuación.</strong> Puntúa con el equipo directivo y con al menos dos docentes que las usen. Anota la evidencia, no solo la opinión.</li>
<li><strong>Semana 3: decisión y calendario.</strong> Decide qué se mantiene, se fusiona o se retira, con fechas, respaldos y comunicación a la comunidad. Fija un responsable y repite el ejercicio cada año.</li>
</ol>
<p>Y una regla para el futuro: <strong>una herramienta nueva entra solo si sale otra o si pasa los tres criterios antes de comprarla</strong> (el análisis de costos a tres años del artículo <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribirse o desarrollar</a> te ayuda con el factor económico).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, el debate pasó de "¿tenemos tecnología?" a "¿qué hace por el aprendizaje?". En Colombia y Latinoamérica la presión viene de dos lados: la brecha de conectividad y equipos que persiste en muchas zonas, y, en los colegios que sí tienen recursos, la oferta constante de plataformas y de IA. Según la OCDE (TALIS 2024), alrededor del 53 % de los docentes colombianos usó IA en el último año, más que el promedio de la OCDE (36 %): el uso crece más rápido que las reglas institucionales. Para los <strong>directivos</strong>, la tarea es ordenar el portafolio y rendir cuentas del gasto; para los <strong>docentes</strong>, que las herramientas les ahorren trabajo en vez de multiplicarlo (ver <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">autonomía pedagógica ante las plataformas</a>); para las <strong>familias</strong>, saber qué empresas reciben los datos de sus hijos y por qué se usan tantas aplicaciones.</p>

<h2>Herramientas pensadas para sumar, no para acumular</h2>
<p>Parte de reducir la deuda es elegir pocas herramientas que hagan bien varias cosas y que dejen al docente decidir. El <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> reúne en un solo lugar la creación del examen, sus soluciones y la corrección; y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> organiza recetas por materia sin exigir otra plataforma que mantener. Para la atención a la diversidad, <a href="/herramientas/piar/">PIAR con IA</a> concentra los ajustes razonables de cada estudiante en un solo documento, con la revisión del equipo de expertos, en lugar de repartirlos en carpetas y chats.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribirse o desarrollar</a>, <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">la nube no es un respaldo</a> y <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la deuda tecnológica en un colegio?</h3>
<p>Es el costo acumulado de herramientas adoptadas sin criterio: mantenimiento, cuentas, datos por proteger, capacitación y trabajo duplicado que se paga con el tiempo del colegio.</p>
<h3>¿Cuántas herramientas digitales son demasiadas?</h3>
<p>No hay un número universal. La señal es la duplicación (varias herramientas para la misma función), el uso bajo y la falta de responsable. Por eso conviene puntuar cada una y no contarlas.</p>
<h3>¿Debo eliminar las herramientas gratuitas?</h3>
<p>Las gratuitas también cuestan: datos personales, tiempo y riesgo. Aplica los mismos criterios, y presta atención a qué datos de estudiantes manejan y quién responde por ellos.</p>
<h3>¿Cómo convenzo a un docente de dejar su herramienta favorita?</h3>
<p>Con evidencia y diálogo: muéstrale la duplicación, pregúntale qué hace mejor su herramienta y evalúa si la institución puede adoptarla en lugar de la otra. Retirar sin escuchar genera resistencia.</p>
<h3>¿Qué hago con los datos de una plataforma que voy a cerrar?</h3>
<p>Exporta y respalda lo que deba conservarse, y pide al proveedor la eliminación de los datos de los estudiantes, dejando constancia por escrito.</p>

<p class="notice"><strong>Haz el inventario esta semana.</strong> Descarga el <a href="/descargas/deuda-tecnologica/inventario-herramientas-colegio.xlsx">inventario de herramientas del colegio</a>, reemplaza los datos de ejemplo por los tuyos y puntúa cada herramienta. Usa Excel 2019 o Microsoft 365 (la columna de decisión usa MAXIFS).</p>

<h2>Para pensar</h2>
<p>Cada herramienta que adoptamos promete ahorrar tiempo, pero cada una también consume atención, datos y presupuesto. <strong>¿Está el colegio eligiendo sus herramientas por lo que necesita su proyecto educativo, o por lo que ofrece el mercado? ¿Y quién debería tener la última palabra sobre retirar una plataforma que usan los estudiantes: el rector, los docentes que la usan, las familias cuyos datos guarda o los propios estudiantes?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:criterios}}' => $img('deuda-tecnologica-colegios-criterios', 444, 'Tabla con tres criterios para evaluar una herramienta digital: integración con el sistema central, utilidad pedagógica con evidencia local y sostenibilidad con responsable, presupuesto y plan de salida, cada uno con su señal de alerta.', 'Los tres criterios para decidir qué herramienta se queda.'),
    '{{img:gasto}}' => $img('deuda-tecnologica-colegios-gasto', 392, 'Barras con el gasto anual del colegio de ejemplo por decisión sugerida: mantener 27 millones de pesos, revisar 21,9 y retirar o reemplazar 10,8.', 'Gasto anual por decisión sugerida en el colegio de ejemplo.'),
]);

return [
    'slug' => 'mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios',
    'title' => 'Más plataformas no significa mejor educación: la deuda tecnológica silenciosa de los colegios',
    'excerpt' => 'Qué es la deuda tecnológica en un colegio, qué dicen los datos sobre la acumulación de herramientas y tres criterios (integración, utilidad pedagógica y sostenibilidad) para decidir cuáles mantener, fusionar o retirar, con inventario en Excel.',
    'seo_title' => 'Deuda tecnológica en colegios: qué herramientas conservar',
    'seo_description' => 'Cómo detectar herramientas redundantes en un colegio con tres criterios (integración, utilidad pedagógica, sostenibilidad) y un inventario en Excel.',
    'focus_keyword' => 'deuda tecnológica en colegios',
    'cover' => '/assets/img/articulos/deuda-tecnologica-colegios/deuda-tecnologica-colegios-portada',
    'cover_alt' => 'Portada "Más plataformas no es mejor educación: la deuda tecnológica silenciosa" con una tarjeta que dice 5 de 12 herramientas del colegio de ejemplo se retirarían, el 18 % del gasto anual, con tres funciones duplicadas y cuatro herramientas por revisar.',
    'published_at' => '2026-11-11 12:00:00',
    'content_html' => $html,
];
