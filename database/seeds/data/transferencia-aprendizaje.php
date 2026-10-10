<?php

declare(strict_types=1);

// "Transferencia del aprendizaje". Fuentes consultadas el 10-oct-2026: Gick y Holyoak (1980/1983) según reseñas (Kubricht, Lu y Holyoak 2017): ~10 % sin analogía, ~30 % con la historia sin pista, ~80 % con pista (otras fuentes secundarias citan otros valores); Barnett y Ceci (2002, Psychological Bulletin); Perkins y Salomon (hugging y bridging); Sala y Gobet (2017). Plantilla verificada en Excel 16: distancias 0,1,1,3,4,2,4,8,8,5; media 3,6; 2 lejanas; espaciamiento 2-feb, 8-feb, 3-mar.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/transferencia-aprendizaje/' . $name;
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
<p>Una estudiante resuelve con soltura diez problemas de regla de tres en el cuaderno. Dos semanas después, en la tienda escolar, no sabe qué paquete de galletas conviene comprar. El profesor se pregunta qué falló: ¿no aprendió? Sí aprendió, pero <strong>lo aprendido no viajó al contexto nuevo</strong>. Ese problema tiene nombre en la psicología del aprendizaje: la transferencia.</p>
<p>La transferencia del aprendizaje es la capacidad de usar lo aprendido en una situación distinta de aquella en que se aprendió. Es, en el fondo, el propósito de casi toda la escuela: nadie enseña fracciones para que se resuelvan fracciones de libro, sino para que se pueda hacer algo con ellas. Este artículo explica qué dice la investigación (con cifras de estudios clásicos y sus límites), por qué la transferencia casi nunca ocurre sola y qué prácticas de aula ayudan, e incluye una <a href="/descargas/transferencia-aprendizaje/diseno-para-la-transferencia.xlsx">plantilla de Excel</a> con una matriz de distancia de las tareas, un calendario de repaso espaciado y ocho preguntas puente, verificada en Microsoft Excel 16 con un ejemplo ficticio. Fuentes revisadas el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> La transferencia es un tema con resultados de investigación variados y, en parte, debatidos; presento lo que la literatura sostiene con sus matices y evito prometer efectos. Las cifras provienen de estudios de laboratorio clásicos y de reseñas, no de aulas colombianas. La matriz de la plantilla es un marco de elaboración propia, no una escala validada. El ejemplo de la unidad es ficticio.</p>

<h2>Qué es la transferencia (y de qué tipos hay)</h2>
<ul>
<li><strong>Transferencia positiva y negativa.</strong> Lo aprendido puede ayudar en la nueva situación (positiva) o interferir (negativa: aplicar una regla donde no corresponde, como sumar numeradores y denominadores al sumar fracciones).</li>
<li><strong>Transferencia cercana y lejana.</strong> La cercana ocurre entre situaciones muy parecidas (otro problema de regla de tres); la lejana, entre situaciones muy distintas (usar proporcionalidad para decidir una compra, o una idea de la clase de ciencias en un debate de ciudadanía). Barnett y Ceci (2002) propusieron una taxonomía para describir cuán lejos viaja lo aprendido según dimensiones de contexto, como el dominio del conocimiento, el contexto físico, el temporal, el social y la modalidad, y concluyeron que la transferencia lejana es rara, pero en las condiciones adecuadas puede ocurrir.</li>
<li><strong>Camino bajo y camino alto.</strong> Perkins y Salomon distinguieron la transferencia de "camino bajo" (automática, basada en habilidades muy practicadas y situaciones parecidas) de la de "camino alto" (deliberada, que exige abstraer un principio y reconocer que aplica en otro lugar). La enseñanza puede favorecer la primera "abrazando" (haciendo que la práctica se parezca a donde se usará) y la segunda "tendiendo puentes" (ayudando a los estudiantes a abstraer y conectar).</li>
</ul>

<h2>Por qué casi nunca ocurre sola</h2>
<p>El estudio clásico es el de Gick y Holyoak (1980, con replicaciones en 1983). Se plantea a personas el "problema de la radiación": cómo destruir un tumor con rayos sin dañar el tejido sano alrededor. Sin ninguna ayuda previa, según reseñas de esa línea de investigación, solo alrededor del <strong>10 %</strong> encontró la solución (dirigir varios rayos débiles desde distintos ángulos que convergen en el tumor). Si antes leían una historia análoga, la de un general que divide su ejército para atacar una fortaleza desde varios caminos, pero sin que se les dijera que la usaran, la proporción subía a solo alrededor del <strong>30 %</strong>. Cuando se les daba la pista explícita ("la historia puede servirte"), el total llegaba a alrededor del <strong>80 %</strong>. Esos porcentajes varían entre experimentos y reseñas (algunas fuentes secundarias citan otros valores), así que conviene leerlos como órdenes de magnitud y no como cifras exactas.</p>
<p>La lección es incómoda y útil a la vez: las personas tienen el conocimiento necesario, pero <strong>no lo recuperan cuando la situación se ve distinta</strong>; el reconocimiento de que "esto es lo mismo que aquello" falla, y se corrige con una pista, es decir, con enseñanza. Dicho de otro modo, la transferencia no es un efecto automático de aprender bien: es algo que hay que enseñar y verificar.</p>
<p>Un matiz importante: los programas que prometen mejorar el pensamiento general con una actividad específica (por ejemplo, entrenar la memoria de trabajo, el ajedrez o la música para mejorar el rendimiento académico) han tenido poca evidencia de transferencia lejana en revisiones sistemáticas, como el metaanálisis de Sala y Gobet (2017). Es una razón más para ser prudente con las promesas, y para diseñar la transferencia de forma explícita en lugar de esperarla.</p>

<h2>Cinco dimensiones en las que una tarea se aleja de lo practicado</h2>
{{img:dimensiones}}
<p>La hoja <em>Tareas</em> de la plantilla califica cada tarea de una unidad en cinco dimensiones, de 0 (igual a lo practicado) a 2 (muy distinto): dominio, lugar, tiempo, formato y componente social. La suma es la <strong>distancia</strong> de la tarea (0 a 10) y se clasifica en cercana (0 a 2), intermedia (3 a 5) o lejana (6 a 10). Es un marco de elaboración propia, inspirado en las dimensiones de contexto de la literatura.</p>
<p>En el ejemplo ficticio de una unidad de proporcionalidad en grado 7, con diez tareas:</p>
<ul>
<li>Las distancias son 0, 1, 1, 3, 4, 2, 4, 8, 8 y 5. Cuatro tareas son cercanas, cuatro intermedias y <strong>dos lejanas</strong> (20 %): el presupuesto de un evento para otro curso y el informe de compra en un supermercado con la familia.</li>
<li>La distancia media de la unidad es <strong>3,6</strong> y la máxima, 8.</li>
<li>Por dimensión, la suma más alta es <strong>dominio (11)</strong> y la más baja es <strong>lugar (4)</strong>: la unidad varía bastante las situaciones, pero casi nunca se sale del aula. Esa es la dimensión menos variada.</li>
</ul>
<p>El diagnóstico automático de la hoja <em>Resumen</em> dice "Hay tareas lejanas", y si no hubiera ninguna diría "Ninguna tarea lejana: se practica, pero no se verifica el transferir". Muchas unidades reales entrarían en ese segundo caso: diez ejercicios de la misma forma, una prueba de la misma forma, y la sorpresa cuando el estudiante falla en un contexto nuevo.</p>

<h2>Cinco movimientos de aula para enseñar la transferencia</h2>
{{img:movimientos}}
<ol>
<li><strong>Variar los ejemplos y los contextos.</strong> Practicar con situaciones diversas ayuda a separar lo esencial de lo accidental. Una unidad de proporcionalidad con solo problemas de recetas lleva a asociar la regla con las recetas.</li>
<li><strong>Comparar casos para extraer la estructura común.</strong> La investigación sobre razonamiento analógico (por ejemplo, el trabajo de Gentner y colaboradores) sugiere que comparar dos casos, y no solo estudiarlos por separado, ayuda a ver el principio compartido. Pregunta: ¿qué tienen en común estos dos problemas aunque parezcan distintos?</li>
<li><strong>Tender puentes explícitos.</strong> Las preguntas puente (la hoja trae ocho) piden abstraer ("explica la idea sin el ejemplo del libro"), conectar ("¿dónde más has visto algo parecido?"), anticipar ("¿dónde podrías usarlo esta semana?") y reconocer límites ("¿cuándo esta estrategia no funcionaría?").</li>
<li><strong>Espaciar y recuperar.</strong> Volver al tema días y semanas después, con tareas de formato distinto, fortalece la retención y obliga a reconocer el tema en un contexto nuevo. La hoja <em>Espaciamiento</em> calcula las fechas de repaso a 1, 7 y 30 días desde la enseñanza (por ejemplo, un tema enseñado el 1 de febrero de 2027 se repasa el 2 y el 8 de febrero y el 3 de marzo; los intervalos son editables). Ver <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">del simulacro al plan de mejora</a>, que usa la misma lógica de recuperación y espaciamiento.</li>
<li><strong>Verificar con tareas de distancia mayor.</strong> Si lo único que se evalúa es lo que se practicó de la misma forma, no se sabe si hubo transferencia. Incluye al menos una tarea lejana por unidad, con retroalimentación (ver <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a>).</li>
</ol>
<p>Esto se conecta con la planeación: la <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">planeación inversa</a> pide definir primero qué deben poder hacer los estudiantes, y la transferencia es justamente ese "poder hacer en otro contexto". También con los proyectos: un buen proyecto STEAM (ver <a href="/steam-sin-equipos-costosos-proyectos-materiales-cotidianos-plantilla/">STEAM sin equipos costosos</a>) puede ser una tarea de transferencia lejana si el producto tiene un público real, y los errores recurrentes (ver <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">el error matemático que se repite</a>) suelen ser, en parte, transferencia negativa.</p>

<h2>Lo que no resuelve la transferencia</h2>
<ul>
<li><strong>Más ejercicios del mismo tipo.</strong> Mejoran la transferencia cercana y la fluidez, pero no garantizan reconocer el principio en otro lugar.</li>
<li><strong>Esperar que "el pensamiento crítico" se desarrolle solo.</strong> Las habilidades generales rara vez se transfieren sin enseñanza explícita del conocimiento de cada dominio.</li>
<li><strong>Evaluar solo la transferencia lejana sin haber enseñado a transferir.</strong> Se mide el contexto, no el aprendizaje, y se castiga a quien no tuvo la oportunidad de practicarlo.</li>
</ul>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La discusión sobre aprender "para la vida" aparece en las pruebas que miden competencias: el ICFES evalúa en las pruebas Saber la capacidad de aplicar conocimientos a situaciones, y las pruebas internacionales como PISA se plantean explícitamente aplicar lo aprendido a problemas de la vida real (ver <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA en América Latina</a>). Para los <strong>docentes</strong>, el desafío es diseñar tareas que se alejen de lo practicado, con apoyo y retroalimentación, en lugar de evaluar de golpe una transferencia que nunca se enseñó; para los <strong>directivos</strong>, entender que la transferencia exige tiempo (volver sobre los temas) y colaboración entre áreas; para las <strong>familias</strong>, que usar lo aprendido en casa (comparar precios, medir una receta) es una práctica de transferencia valiosa; y para los <strong>estudiantes</strong>, que preguntarse "¿dónde más sirve esto?" es una habilidad que se entrena. Ojo con la equidad: las tareas "de la vida real" favorecen a quienes tienen más experiencias previas con ese contexto; conviene ofrecer contextos variados y no asumir que todos los conocen.</p>

<h2>Herramientas y plantillas</h2>
<p>Para generar variantes de problemas en contextos distintos, evidencias de aprendizaje y preguntas puente, y organizar tus recursos con IA (siempre revisando lo que produce), mira estas herramientas propias.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">calificaciones: aprendizaje o cumplimiento</a>, <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">cómo probar una herramienta educativa en cuatro semanas</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>. Para adaptar las tareas a estudiantes con barreras de aprendizaje, <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la transferencia del aprendizaje?</h3>
<p>La capacidad de aplicar lo aprendido en una situación distinta de aquella en la que se aprendió.</p>
<h3>¿Por qué los estudiantes no transfieren lo que saben?</h3>
<p>Porque no reconocen que la nueva situación se parece a la aprendida. En estudios clásicos, solo una minoría transfería sin una pista y la mayoría lo hacía con una; la transferencia hay que enseñarla.</p>
<h3>¿Cuál es la diferencia entre transferencia cercana y lejana?</h3>
<p>La cercana ocurre entre situaciones muy parecidas; la lejana, entre situaciones muy distintas (otra materia, otro lugar, otro momento, otro formato). La lejana es más rara y más difícil.</p>
<h3>¿Cómo puedo promover la transferencia en mis clases?</h3>
<p>Variando ejemplos y contextos, comparando casos, haciendo preguntas puente, espaciando los repasos y verificando con al menos una tarea lejana por unidad.</p>
<h3>¿Sirven las preguntas puente?</h3>
<p>Son una práctica razonable respaldada por el marco de "tender puentes" de Perkins y Salomon, aunque la evidencia de efectos en el aula es variada. Conviene probarlas con tus datos.</p>

<p class="notice"><strong>Mide la distancia de tu próxima unidad.</strong> Descarga la <a href="/descargas/transferencia-aprendizaje/diseno-para-la-transferencia.xlsx">plantilla de diseño para la transferencia</a>, califica las tareas de tu próxima unidad y mira si alguna es lejana. Si ninguna lo es, agrega una.</p>

<h2>Para pensar</h2>
<p>Enseñamos para que lo aprendido sirva más allá del aula, pero evaluamos casi siempre dentro de ella. <strong>¿Qué parte de lo que enseñas está pensada para ser usada fuera del colegio, y cómo sabrías si lo está siendo? Y ¿qué cambiaría si cada unidad terminara no con una prueba igual a los ejercicios, sino con un problema que el estudiante no ha visto en ninguna clase?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:dimensiones}}' => $img('transferencia-aprendizaje-dimensiones', 553, 'Tabla con cinco dimensiones en las que una tarea se aleja de lo practicado, con el extremo cercano y el lejano: dominio, lugar, tiempo, formato y social.', 'Cinco dimensiones de distancia.'),
    '{{img:movimientos}}' => $img('transferencia-aprendizaje-movimientos', 467, 'Cinco movimientos de aula para enseñar la transferencia: variar, comparar, conectar, espaciar y verificar.', 'Cinco movimientos en el aula.'),
]);

return [
    'slug' => 'transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla',
    'title' => 'Transferencia del aprendizaje: por qué casi nunca ocurre sola y cómo diseñar tareas que la verifiquen (plantilla)',
    'excerpt' => 'Qué dice la investigación sobre la transferencia del aprendizaje (Gick y Holyoak, Barnett y Ceci, Perkins y Salomon), por qué casi nunca ocurre sola y cómo variar, comparar, conectar, espaciar y verificar, con una plantilla de Excel.',
    'seo_title' => 'Transferencia del aprendizaje: cómo enseñarla',
    'seo_description' => 'Qué es la transferencia del aprendizaje, por qué los estudiantes no aplican lo que saben y cómo promoverla en el aula, con plantilla de Excel.',
    'focus_keyword' => 'transferencia del aprendizaje',
    'cover' => '/assets/img/articulos/transferencia-aprendizaje/transferencia-aprendizaje-portada',
    'cover_alt' => 'Portada "Transferencia del aprendizaje: que lo aprendido sirva fuera del aula" con una tarjeta: de aproximadamente 10 % a 80 % resolvieron un problema nuevo sin pista y con una pista.',
    'published_at' => '2027-01-27 12:00:00',
    'content_html' => $html,
];
