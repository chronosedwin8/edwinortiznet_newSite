<?php

declare(strict_types=1);

// «La retroalimentación que sí cambia el aprendizaje». Fuentes verificadas el 10 de octubre de 2026: Hattie y Timperley (2007), Kluger y DeNisi (1996), Education Endowment Foundation. Banco de 20 comentarios y rúbrica verificados en Excel.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/retroalimentacion-aprendizaje/' . $name;
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
<p>Un docente dedica el fin de semana a corregir treinta trabajos y escribe en cada uno «Muy bien», «Mejorar», «Falta esfuerzo». El lunes los devuelve; los estudiantes miran la nota, guardan el trabajo y no vuelven a abrirlo. Es la escena más repetida de la educación y una de las mayores pérdidas de tiempo docente: <strong>horas de retroalimentación que no cambian nada</strong>.</p>
<p>La retroalimentación es, según la evidencia, una de las intervenciones de más impacto y menor costo, pero con una advertencia que casi nadie cuenta: <strong>puede ayudar, no hacer nada o incluso perjudicar</strong>. Este artículo explica qué hace que una retroalimentación cambie el aprendizaje, con un <a href="/descargas/retroalimentacion/rubrica-banco-retroalimentacion.xlsx">banco de 20 ejemplos reescritos y una rúbrica descargable en Excel</a> para evaluar y mejorar tus propios comentarios. Datos verificados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> La retroalimentación funciona cuando se centra en <strong>la tarea, el proceso y la autorregulación</strong>, es específica, dice <strong>cómo mejorar</strong>, llega <strong>a tiempo</strong> y el estudiante tiene <strong>un momento para usarla</strong>. Los comentarios sobre la persona («eres muy inteligente», «no te esforzaste») rara vez ayudan. En un banco de 20 comentarios comunes, solo el 35 % ayuda a mejorar y el 35 % se centra en la persona. Con la rúbrica y el banco puedes auditar los tuyos en diez minutos.</p>

<h2>Lo que dice la evidencia</h2>
<ul>
<li><strong>Funciona, en promedio.</strong> La Education Endowment Foundation (EEF) del Reino Unido ubica la retroalimentación entre las intervenciones de bajo costo y alto impacto: su guía habla de varios meses de progreso adicional (las versiones del Toolkit citan entre seis y ocho meses; confirma la cifra vigente en su sitio).</li>
<li><strong>Pero el promedio esconde una gran variación.</strong> El metaanálisis clásico de Kluger y DeNisi (1996, <em>Psychological Bulletin</em>; 607 tamaños de efecto, más de 23.000 observaciones) encontró un efecto medio positivo (d = 0,41), pero que <strong>más de un tercio de las intervenciones de retroalimentación empeoró el desempeño</strong>. Sus autores explican que la eficacia baja cuando la atención se desplaza de la tarea hacia el yo. La propia EEF advierte que en algunos casos la retroalimentación puede tener efectos negativos.</li>
<li><strong>El nivel importa.</strong> Hattie y Timperley (2007, <em>Review of Educational Research</em>) distinguen cuatro niveles de comentario: sobre la <strong>tarea</strong> (qué está bien o mal), el <strong>proceso</strong> (las estrategias usadas), la <strong>autorregulación</strong> (cómo el estudiante revisa y corrige su trabajo) y la <strong>persona</strong> (elogios o críticas generales). Los tres primeros contribuyen a mejorar; el último, en general, no, porque no guía qué hacer después.</li>
</ul>
{{img:niveles}}
<p>La lección práctica: <strong>no se trata de dar más retroalimentación, sino mejor</strong>. Y una retroalimentación bien hecha responde las tres preguntas del modelo: ¿hacia dónde voy? (la meta), ¿cómo voy? (dónde estoy) y ¿cuál es el siguiente paso? (cómo mejorar).</p>

<h2>Cuatro comentarios, cuatro niveles</h2>
<p>Un mismo trabajo de matemáticas, cuatro comentarios posibles:</p>
<table>
<thead><tr><th>Comentario</th><th>Nivel</th><th>¿Ayuda?</th></tr></thead>
<tbody>
<tr><td>«Muy bien, eres muy inteligente.»</td><td>Persona</td><td>No: no dice qué estuvo bien ni qué hacer</td></tr>
<tr><td>«Mal.»</td><td>Tarea (vaga)</td><td>No: no dice dónde ni por qué</td></tr>
<tr><td>«Revisa la segunda línea: el signo cambia al pasar al otro lado de la igualdad.»</td><td>Tarea (específica)</td><td>Sí: dice dónde y cómo corregir</td></tr>
<tr><td>«¿Qué estrategia usaste y por qué la elegiste? Compárala con la de tu compañero.»</td><td>Autorregulación</td><td>Sí: invita a pensar sobre su propio proceso</td></tr>
</tbody>
</table>

<h2>La rúbrica de calidad de un comentario</h2>
<p>El libro trae una rúbrica de seis criterios con cuatro niveles, pensada para evaluar un comentario antes de entregarlo (o para revisar entre colegas):</p>
<table>
<thead><tr><th>Criterio</th><th>Peso</th><th>Qué mira</th></tr></thead>
<tbody>
<tr><td><strong>Se centra en la tarea y el proceso, no en la persona</strong></td><td>20 %</td><td>Habla del trabajo y de cómo se hizo</td></tr>
<tr><td><strong>Es específico</strong></td><td>20 %</td><td>Señala el punto concreto, con un ejemplo</td></tr>
<tr><td><strong>Dice cómo mejorar</strong></td><td>25 %</td><td>Un siguiente paso claro y posible</td></tr>
<tr><td><strong>Llega a tiempo y se puede usar</strong></td><td>15 %</td><td>Hay un momento para actuar sobre ella</td></tr>
<tr><td><strong>Cuida la dignidad y la motivación</strong></td><td>10 %</td><td>Respetuoso y claro; reconoce lo logrado</td></tr>
<tr><td><strong>Invita a reflexionar</strong></td><td>10 %</td><td>Pide comparar, explicar o planear</td></tr>
</tbody>
</table>
<p>El libro calcula el puntaje (con todos los criterios en nivel 3, por ejemplo, 75/100) y da una lectura: «Retroalimentación potente», «Útil», «Débil» o «Poco útil». Los pesos son editables y deben sumar 100. Hay una advertencia importante en la última fila de la hoja: una retroalimentación excelente que llega cuando ya no se puede usar rinde poco. <strong>El criterio del tiempo importa tanto como el contenido.</strong></p>

<h2>El banco: 20 comentarios reales, reescritos</h2>
{{img:ejemplos}}
<p>La hoja «Banco_de_ejemplos» recoge 20 comentarios típicos de distintas áreas (matemáticas, lenguaje, ciencias, sociales, inglés, tecnología, educación física, arte), cada uno con su nivel, si ayuda a mejorar y una versión mejorada. Algunos ejemplos de reescritura:</p>
<ul>
<li>«Tu texto es confuso.» → «Cada párrafo mezcla dos ideas: intenta una idea por párrafo y escribe la idea principal en la primera frase.»</li>
<li>«Esta vez no te esforzaste.» → «Tu informe tiene la introducción pero no el método: complétalo para que otra persona pueda repetir el experimento.»</li>
<li>«Nota: 3,2.» → «3,2: cumpliste los criterios 1 y 2; para subir, trabaja el criterio 3 (conclusión) con un ejemplo y entrégalo de nuevo.»</li>
<li>«Bonito.» (arte) → «El contraste entre colores cálidos y fríos guía la mirada: prueba aplicarlo también al fondo.»</li>
</ul>
<p>De los 20 comentarios del banco, solo 7 (35 %) ayudan a mejorar tal como están y 7 (35 %) se centran en la persona; el resto son comentarios sobre la tarea que son vagos o incompletos. Notarás un patrón en las reescrituras: cada una <strong>nombra algo concreto del trabajo y propone una acción</strong>.</p>

<h2>Audita tus propios comentarios en diez minutos</h2>
<ol>
<li><strong>Toma diez comentarios</strong> que escribiste la semana pasada y pégalos en la hoja «Mis_comentarios».</li>
<li><strong>Clasifica cada uno</strong> en Tarea, Proceso, Autorregulación o Persona, y responde si dice cómo mejorar y si llegó con tiempo.</li>
<li><strong>Lee el resumen:</strong> el libro calcula el porcentaje por nivel y avisa, por ejemplo, «Muchos comentarios sobre la persona: reescribe esos hacia la tarea y el proceso» o «Faltan siguientes pasos». Probé el caso con nueve comentarios clasificados, cuatro sobre la persona (44 %) y tres con siguiente paso (33 %), y el resumen dio exactamente esa alerta.</li>
<li><strong>Reescribe tres comentarios</strong> con el banco como guía y compara el puntaje de la rúbrica antes y después.</li>
</ol>

<h2>Cómo hacer que se use: el tiempo y el ciclo</h2>
<p>Un comentario excelente no sirve si nadie actúa sobre él. Algunas prácticas que ayudan:</p>
<ul>
<li><strong>Da tiempo de clase para usarla.</strong> Diez minutos para corregir con el comentario valen más que una hora de comentarios que nadie lee.</li>
<li><strong>Comenta antes de calificar</strong> o separa el comentario de la nota: con la nota a la vista, muchos estudiantes ignoran el comentario.</li>
<li><strong>Pocos comentarios, los más importantes:</strong> dos o tres puntos que el estudiante pueda atender, no veinte marcas.</li>
<li><strong>Ofrece oportunidad de rehacer</strong> y valora la mejora (ver <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden las calificaciones</a>).</li>
<li><strong>Enseña a pedir y a dar retroalimentación</strong> entre estudiantes con la misma rúbrica: es una forma de autorregulación.</li>
<li><strong>Usa retroalimentación oral</strong> cuando sea posible: es más rápida y permite diálogo.</li>
</ul>

<h2>¿Y la IA?</h2>
<p>Hoy hay herramientas que generan comentarios en segundos. Pueden ahorrar tiempo con borradores, pero <strong>un comentario generado sin revisión suele ser genérico</strong> («buen trabajo, sigue así»), justo lo que la rúbrica penaliza, y puede equivocarse sobre el trabajo. Úsalas como borrador que revisas contra la rúbrica, sin pegar datos de estudiantes en herramientas gratuitas (ver <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA</a>), y recuerda que la decisión de evaluación es tuya (ver <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA</a> y <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">autonomía pedagógica</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la retroalimentación formativa es una de las prácticas más respaldadas por la evidencia. En Colombia y Latinoamérica, la realidad de grupos numerosos y docentes con muchas horas de clase hace que la retroalimentación escrita individual sea difícil de sostener: de ahí el valor de la <strong>retroalimentación oral, la grupal y la entre pares</strong>, y de concentrarse en pocos comentarios de calidad. El Sistema Institucional de Evaluación de los Estudiantes (SIEE) de cada colegio es el lugar para acordar cómo se hace y se usa (ver <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">el artículo sobre calificaciones</a>). Para los <strong>docentes</strong>, el reto es dar menos y mejor; para los <strong>directivos</strong>, proteger tiempo para que la retroalimentación se use; para las <strong>familias</strong>, preguntar «¿qué debe hacer mi hijo para mejorar?», más que «¿qué nota sacó?»; y para los <strong>estudiantes</strong>, aprender a pedir y a usar la retroalimentación.</p>

<h2>Herramientas para el docente</h2>
<p>Para producir evaluaciones con criterios claros, donde la retroalimentación se apoya en soluciones y rúbricas, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> entrega exámenes y soluciones que revisas antes de usar; el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia, incluidas ideas para dar retroalimentación; y <a href="/herramientas/piar/">PIAR con IA</a> ayuda a documentar ajustes razonables que la retroalimentación debe tener en cuenta.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">¿la IA amplía o reemplaza el pensamiento del estudiante?</a> y <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">una prueba de cuatro semanas</a> para comprobar si tu estrategia de retroalimentación funciona.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué hace efectiva a la retroalimentación?</h3>
<p>Que se centre en la tarea, el proceso o la autorregulación, sea específica, diga cómo mejorar, llegue a tiempo y que el estudiante tenga un momento para usarla.</p>
<h3>¿Por qué un elogio como «eres muy inteligente» no ayuda?</h3>
<p>Porque habla de la persona y no dice qué hizo bien ni qué hacer después. Según Hattie y Timperley, el comentario sobre la persona rara vez contribuye al aprendizaje.</p>
<h3>¿Puede la retroalimentación empeorar el aprendizaje?</h3>
<p>Sí. En el metaanálisis de Kluger y DeNisi (1996), más de un tercio de las intervenciones empeoró el desempeño, sobre todo las que desplazaron la atención hacia el yo y lejos de la tarea.</p>
<h3>¿Cuánta retroalimentación debo dar?</h3>
<p>Menos y mejor: dos o tres puntos que el estudiante pueda atender, con un siguiente paso claro y tiempo para aplicarlos.</p>
<h3>¿Sirve la retroalimentación generada por IA?</h3>
<p>Como borrador, sí, si la revisas con una rúbrica y no pegas datos de estudiantes en herramientas no autorizadas. Sin revisión suele ser genérica.</p>

<p class="notice"><strong>Esta semana:</strong> descarga la <a href="/descargas/retroalimentacion/rubrica-banco-retroalimentacion.xlsx">rúbrica y el banco de retroalimentación</a>, audita diez de tus comentarios y reescribe tres. Después, da diez minutos de clase para que los estudiantes los usen.</p>

<h2>Para pensar</h2>
<p>Corregir es una de las tareas que más tiempo consume al docente y una de las que menos se evalúa. <strong>Si la mayor parte de la retroalimentación escrita no cambia el aprendizaje, ¿vale la pena el tiempo que le dedicamos, o deberíamos dedicar ese tiempo a otras formas de ayudar a aprender? ¿Y quién debería decidir cuánta retroalimentación escrita se espera de un docente con cuarenta estudiantes por grupo: el colegio, la secretaría o la evidencia?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:niveles}}' => $img('retroalimentacion-aprendizaje-niveles', 573, 'Cuatro tarjetas con los niveles de un comentario según Hattie y Timperley: tarea, proceso, autorregulación y persona, el menos útil.', '¿Sobre qué habla tu comentario?'),
    '{{img:ejemplos}}' => $img('retroalimentacion-aprendizaje-ejemplos', 444, 'Tabla con tres comentarios comunes, su nivel y una versión mejorada: «muy bien, eres inteligente», «tu texto es confuso» y «buen trabajo».', 'De un comentario vacío a uno que guía.'),
]);

return [
    'slug' => 'retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica',
    'title' => 'La retroalimentación que sí cambia el aprendizaje: cuatro niveles, un banco de ejemplos y una rúbrica',
    'excerpt' => 'Qué dice la evidencia sobre la retroalimentación (también cuando perjudica), los cuatro niveles de un comentario, un banco de 20 ejemplos reescritos y una rúbrica descargable para auditar tus propios comentarios en diez minutos.',
    'seo_title' => 'Retroalimentación que cambia el aprendizaje: rúbrica',
    'seo_description' => 'Qué hace efectiva a la retroalimentación: evidencia, cuatro niveles de comentario, 20 ejemplos reescritos y una rúbrica descargable para tus comentarios.',
    'focus_keyword' => 'retroalimentación efectiva en el aula',
    'cover' => '/assets/img/articulos/retroalimentacion-aprendizaje/retroalimentacion-aprendizaje-portada',
    'cover_alt' => 'Portada «La retroalimentación que sí cambia el aprendizaje, con ejemplos y rúbrica» con una tarjeta: 1 de cada 3 intervenciones de retroalimentación empeoró el desempeño en un metaanálisis clásico; los comentarios sobre la persona dañan.',
    'published_at' => '2026-12-16 12:00:00',
    'content_html' => $html,
];
