<?php

declare(strict_types=1);

// "Del simulacro al plan de mejora: hoja de seguimiento". Libro con registro, análisis de errores, resumen y plan semanal (datos ficticios; verificado en Excel 16: 55,0/63,3/68,3/76,7 %; 14 errores: 5 con seguridad alta). Citas: Roediger y Karpicke 2006; Cepeda et al. 2006; Butterfield y Metcalfe 2001. Práctica no oficial. Verificado el 10 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/simulacro-plan-mejora/' . $name;
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
<p>Terminas un simulacro, miras el puntaje, sientes alivio o desánimo y pasas al siguiente. Es la forma más común de usar un simulacro y la que menos sirve: <strong>el puntaje dice cuánto, no dice por qué</strong>. El valor de un simulacro está en lo que haces con los errores después.</p>
<p>Este artículo propone un método sencillo para convertir un simulacro en un plan de mejora: registrar, clasificar cada error por su causa, priorizar, practicar una cosa por semana y medir. Incluye una <a href="/descargas/concurso-docente/hoja-seguimiento-simulacros-plan-mejora.xlsx">hoja de seguimiento descargable en Excel</a> (registro de simulacros, análisis de errores, resumen automático y plan de cuatro semanas), con datos ficticios de ejemplo y fórmulas verificadas en Microsoft Excel 16. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los simulacros, incluidos los míos, son <strong>práctica no oficial</strong>: no son preguntas de la CNSC ni predicen el puntaje de la prueba real, y nadie puede garantizarte un resultado ni un nombramiento. Las categorías y los datos de la hoja son un marco de elaboración propia y ejemplos ficticios: ajústalos a los componentes de tu convocatoria cuando se publique el acuerdo definitivo y su anexo técnico.</p>

<h2>Por qué el puntaje no basta</h2>
<p>Dos aspirantes pueden sacar 46 de 60 por razones opuestas: una no conocía cuatro normas; otro sabía todo, pero leyó mal cuatro enunciados y se quedó sin tiempo en otras. Si ambos "estudian más de todo", pierden semanas. La causa del error define la tarea:</p>
{{img:causas}}
<p>Esta distinción conecta con una idea que aparece en la psicología del aprendizaje: <strong>los errores cometidos con alta seguridad</strong> son los más valiosos. En estudios sobre el llamado efecto de hipercorrección (por ejemplo, el trabajo de Butterfield y Metcalfe de 2001), las personas corrigen con más facilidad los errores de los que estaban muy seguras, siempre que reciban la respuesta correcta y la expliquen, que los que respondieron con dudas. Para un aspirante, eso significa revisar primero lo que "sabía" y estaba mal: es un concepto errado, no un vacío.</p>

<h2>El ciclo de mejora, paso a paso</h2>
{{img:ciclo}}
<ol>
<li><strong>Registrar.</strong> Anota fecha, número de preguntas, aciertos y minutos usados (hoja <em>Registro</em>). La hoja calcula el porcentaje, los minutos por pregunta y el cambio frente al simulacro anterior.</li>
<li><strong>Clasificar cada error</strong> (hoja <em>Errores</em>): componente (normativa, pedagógico, razonamiento cuantitativo, lectura crítica, juicio situacional), causa (desconocimiento, confusión, lectura apresurada, tiempo, descuido de cálculo, azar) y seguridad con la que respondiste (alta, media, baja). Hazlo mientras el simulacro está fresco; antes de mirar la respuesta correcta, marca cuánta seguridad tenías.</li>
<li><strong>Priorizar.</strong> La hoja asigna prioridad: <em>1</em> a los errores con seguridad alta (conceptos errados), <em>2</em> a las dudas no resueltas y <em>3</em> a los vacíos o al azar. En el ejemplo, 5 de las 14 preguntas falladas fueron con seguridad alta.</li>
<li><strong>Practicar una prioridad por semana</strong> (hoja <em>Plan_semanal</em>): una tarea concreta, horas planeadas y una evidencia de lo que produjiste (una tabla, una ficha, un registro de tiempos). No "estudiar normativa", sino "tabla comparativa de las dos normas que confundí y 10 preguntas propias".</li>
<li><strong>Medir.</strong> Un nuevo simulacro y volver al registro. Un solo simulacro puede variar por simple azar, así que mira la tendencia de varios, sin sacar conclusiones fuertes de uno.</li>
</ol>

<h2>Lo que muestra el ejemplo (datos ficticios)</h2>
<p>En el libro de ejemplo, un aspirante hipotético hace cuatro simulacros de 60 preguntas: 33, 38, 41 y 46 aciertos (55,0 %, 63,3 %, 68,3 % y 76,7 %), y baja de 110 a 98 minutos usados (de 1,83 a 1,63 minutos por pregunta). Entre el primero y el último gana 21,7 puntos porcentuales. El análisis de las 14 preguntas falladas del último simulacro mostró:</p>
<ul>
<li><strong>Por componente:</strong> normativa 4 (28,6 %), razonamiento cuantitativo 4 (28,6 %), pedagógico 2, lectura crítica 2 y juicio situacional 2 (14,3 % cada uno).</li>
<li><strong>Por causa:</strong> confusión 4 (28,6 %), desconocimiento 3 (21,4 %), y lectura apresurada, tiempo y descuido de cálculo con 2 cada una (14,3 %), y azar 1 (7,1 %).</li>
<li><strong>Por seguridad:</strong> 5 con seguridad alta, 4 media y 5 baja. Dos de los cinco errores "seguros" fueron de normativa, uno pedagógico y dos de juicio situacional: por ahí empezó el plan.</li>
</ul>
<p>Una lectura apresurada de ese resumen diría "estudia más normativa". Una lectura con método dice algo más fino: en normativa hay <em>confusión entre normas</em> (tabla comparativa), no solo desconocimiento; en razonamiento cuantitativo el problema es <em>tiempo y descuido</em>, no falta de método (práctica con cronómetro y verificación); y en juicio situacional hay <em>seguridad errada</em> (analizar el caso y justificar por qué las otras opciones fallan). Tres semanas, tres tareas distintas, y una cuarta para medir.</p>
<p>Todo esto es un ejemplo inventado: tus datos serán otros, y por eso el valor está en el método, no en las cifras.</p>

<h2>Cinco reglas para que el plan funcione</h2>
<ol>
<li><strong>Una prioridad por semana.</strong> Un plan con diez frentes no se cumple. La hoja calcula el cumplimiento de horas y de tareas para que veas si el plan es realista; si cumples menos de la mitad, el plan estaba demasiado grande.</li>
<li><strong>Practicar recuperando, no releyendo.</strong> La investigación sobre el efecto de la evaluación (Roediger y Karpicke, 2006) encontró que intentar recordar información produce mejor retención a largo plazo que releerla. Cierra el material y explica o responde antes de revisar.</li>
<li><strong>Espaciar.</strong> Distribuir las sesiones en el tiempo suele rendir más que concentrarlas (Cepeda y colaboradores, 2006). Tres sesiones de una hora en semanas distintas suelen ser mejores que una de tres horas.</li>
<li><strong>Convertir cada error en una pregunta propia.</strong> Escribe, con tus palabras, la pregunta que habría evitado el error y respóndela una semana después.</li>
<li><strong>No tomar el simulacro como oráculo.</strong> Mira si el simulacro es riguroso (ver la <a href="/concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica/">rúbrica de simulacros</a>) y desconfía de cualquier promesa de "puntaje asegurado" (ver <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a>).</li>
</ol>

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación.</strong> Una aspirante analiza su simulacro: de 15 errores, 8 fueron en preguntas de juicio situacional que respondió "con seguridad alta" y 4 fueron de tiempo. Le quedan cuatro semanas antes del siguiente simulacro y dispone de cinco horas semanales. Piensa estudiar "todo el temario otra vez".</p>
<p><strong>Pregunta.</strong> ¿Qué plan es más sólido?</p>
<ol type="A">
<li>Releer todo el temario una vez más, empezando por lo que más le gusta.</li>
<li>Dedicar dos semanas al análisis de casos de juicio situacional (con la justificación de por qué las otras opciones fallan), una semana a práctica con cronómetro y una a un nuevo simulacro con comparación.</li>
<li>Hacer el siguiente simulacro cuanto antes para "ver si subió".</li>
<li>Ignorar los errores con seguridad alta, porque "ya los sabía".</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> Los errores se concentran en dos causas (seguridad errada en juicio situacional y tiempo), y el plan asigna una prioridad por semana, con tareas concretas y una medición al final. A repite lo que no atacó el problema; C mide sin haber cambiado nada; D descarta justo los errores más corregibles, según lo que muestra la investigación sobre la hipercorrección. Este caso es un ejercicio mío, no una pregunta oficial.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el ingreso a la carrera docente se hace por concurso de méritos, con pruebas escritas y otras etapas (ver <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el nuevo cronograma</a>); en otros países de la región hay procesos de selección con pruebas similares, y en el mundo la preparación de pruebas de alto impacto se apoya en la misma evidencia: práctica de recuperación, retroalimentación y espaciamiento. Para los <strong>aspirantes</strong>, el reto es dejar de acumular simulacros y empezar a aprender de ellos; para los <strong>formadores y plataformas</strong>, devolver no solo un puntaje sino un análisis del error; para los <strong>directivos</strong>, entender que apoyar a un docente aspirante con tiempo y espacios de estudio mejora la preparación; y para las <strong>familias y colegas</strong>, acompañar sin presionar.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio, y lleva el registro con esta hoja. Estudia la normativa con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a>, entrena el análisis de casos con <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a> y refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-observaciones-reclamaciones-correcciones-mapa-de-plazos/">observaciones, reclamaciones y correcciones</a> y <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">cómo elegir cargo</a>. Y para el análisis de errores de tus propios estudiantes, mira <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">el error matemático que se repite</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuántos simulacros debo hacer?</h3>
<p>No hay un número mágico. Más útil que la cantidad es el análisis de cada uno: un simulacro bien analizado enseña más que tres hechos de corrido. Una referencia práctica es uno cada una o dos semanas, con las tareas de mejora en medio.</p>
<h3>¿Un simulacro predice mi puntaje en la prueba real?</h3>
<p>No. Es práctica no oficial: orienta el estudio, pero no predice el puntaje, y su dificultad y estructura pueden diferir de la prueba oficial.</p>
<h3>¿Qué hago si no sé por qué fallé una pregunta?</h3>
<p>Explícala en voz alta como si se la enseñaras a alguien. Si no puedes, es desconocimiento o confusión; si puedes, probablemente fue lectura apresurada, tiempo o descuido.</p>
<h3>¿Por qué registrar la seguridad con que respondí?</h3>
<p>Porque distingue un concepto errado (seguridad alta) de un vacío (seguridad baja), y cada uno se trabaja distinto. Los errores con seguridad alta suelen corregirse bien cuando se revisan con la explicación correcta.</p>
<h3>¿Puedo usar la hoja para otro concurso o examen?</h3>
<p>Sí: cambia las listas de componente y de causa en la hoja Errores y ajusta el número de preguntas.</p>

<p class="notice"><strong>Empieza con tu último simulacro.</strong> Descarga la <a href="/descargas/concurso-docente/hoja-seguimiento-simulacros-plan-mejora.xlsx">hoja de seguimiento</a>, clasifica los errores de tu último simulacro (no necesitas hacer otro) y define una sola prioridad para esta semana.</p>

<h2>Para pensar</h2>
<p>Un simulacro puede ser un termómetro o un espejo: el termómetro solo mide la temperatura, el espejo te obliga a mirarte. <strong>¿Preparamos un concurso para pasar una prueba o para llegar a ser mejores docentes en el aula? Y si un aspirante aprende a analizar sus propios errores con honestidad, ¿ese hábito sirve igual para enseñar a sus estudiantes a aprender de los suyos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:causas}}' => $img('simulacro-plan-mejora-causas', 608, 'Tabla con seis causas de error en un simulacro y qué trabajar en cada una: desconocimiento, confusión, lectura apresurada, tiempo, descuido de cálculo y azar.', 'La causa del error define la tarea.'),
    '{{img:ciclo}}' => $img('simulacro-plan-mejora-ciclo', 467, 'Cinco pasos después de cada simulacro: registrar, clasificar, priorizar, practicar y medir.', 'El ciclo de mejora.'),
]);

return [
    'slug' => 'concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento',
    'title' => 'Del simulacro al plan de mejora en el Concurso Docente: cómo aprender de tus errores, con hoja de seguimiento',
    'excerpt' => 'Un método para convertir cada simulacro del Concurso Docente en un plan de mejora: clasificar los errores por causa y seguridad, priorizar, practicar una cosa por semana y medir, con una hoja de seguimiento descargable en Excel.',
    'seo_title' => 'Del simulacro al plan de mejora: Concurso Docente',
    'seo_description' => 'Cómo aprender de los errores de un simulacro del Concurso Docente: clasificarlos, priorizar, practicar y medir, con una hoja de seguimiento en Excel.',
    'focus_keyword' => 'simulacro Concurso Docente plan de mejora',
    'cover' => '/assets/img/articulos/simulacro-plan-mejora/simulacro-plan-mejora-portada',
    'cover_alt' => 'Portada "Del simulacro al plan de mejora: qué hacer con tus errores" con una tarjeta: 5 de 14 errores se fallaron con seguridad alta, son conceptos errados que se desmontan primero.',
    'published_at' => '2026-12-24 12:00:00',
    'content_html' => $html,
];
