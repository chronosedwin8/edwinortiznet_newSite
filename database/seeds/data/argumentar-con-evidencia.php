<?php

declare(strict_types=1);

// "Argumentar con evidencia". Fuentes: Toulmin (1958), The Uses of Argument; McNeill, Lizotte, Krajcik y Marx (2006), J. of the Learning Sciences 15(2), 153-191 (331 estudiantes de 7.º, unidad de química de 8 semanas, andamios que se retiran); Osborne (2010), Science 328(5977), 463-466. Libro verificado en Excel 16 y Python: 10 argumentos; niveles 2/5/3; promedios 2,4/2,2/1,5/0,8/1,7; 4 sin contraargumento; acuerdo 44 de 50 (88 %), 4 difieren en 1, 2 en 2 o más (96 % adyacente). Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/argumentar-con-evidencia/' . $name;
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
<p>Se les pide a treinta estudiantes que escriban si el colegio debería empezar más tarde. Casi todos responden con una opinión firme: "sí, porque dormimos poco" o "no, porque se nos hace tarde para salir". Pocos citan un dato, menos todavía explican por qué ese dato apoya su opinión, y casi ninguno se pregunta qué diría alguien que piensa lo contrario. Tienen <strong>posturas</strong>, pero no <strong>argumentos</strong>. Y la diferencia entre ambos es una de las habilidades que más se menciona cuando se habla de pensamiento crítico y de ciudadanía.</p>
<p>Este artículo analiza cómo enseñar a <strong>argumentar con evidencia</strong>: qué es un argumento, qué dice la investigación sobre aprender argumentando y cómo evaluar los argumentos escritos con una rúbrica de cinco criterios. Incluye un <a href="/descargas/argumentar-con-evidencia/rubrica-argumentacion-evidencia.xlsx">libro de Excel</a> con diez argumentos ficticios calificados por dos lectores, verificado en Microsoft Excel 16 y contra un cálculo independiente. Fuentes revisadas el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios y la rúbrica es un ejemplo propio, no una escala oficial: ajústala con tus colegas y con el SIEE de tu colegio. Calificar argumentos tiene un componente de juicio, y por eso el libro incluye una segunda lectura. Los puntajes sirven para dar retroalimentación, no para etiquetar a un estudiante.</p>

<h2>Qué es argumentar (y qué no)</h2>
<p>Una opinión se afirma; un argumento se <strong>sostiene</strong>. El filósofo Stephen Toulmin (<em>The Uses of Argument</em>, 1958) propuso un modelo que sigue usándose en la enseñanza: un argumento tiene una <strong>afirmación</strong> (lo que se sostiene), unos <strong>datos</strong> que la apoyan, una <strong>garantía</strong> que explica por qué esos datos apoyan la afirmación, y puede incluir un respaldo, un matiz sobre qué tan seguro es y una <strong>refutación</strong> (las condiciones en que no valdría). En la enseñanza de las ciencias, un marco más simple, <strong>afirmación, evidencia y razonamiento</strong> (McNeill, Lizotte, Krajcik y Marx, 2006), se ha usado para guiar a los estudiantes en la escritura de explicaciones; ese estudio, con 331 estudiantes de séptimo grado en una unidad de química de ocho semanas, encontró que retirar gradualmente las ayudas escritas favoreció el razonamiento cuando ya no estaban. Los efectos dependen de la edad, el contexto y la tarea.</p>
{{img:elementos}}
<p>La investigación sobre <em>aprender argumentando</em> va más allá de escribir: Jonathan Osborne (2010, <em>Science</em>) sostiene que el discurso colaborativo y crítico, es decir, discutir razones con otros, mejora la comprensión conceptual y las habilidades de razonamiento, y que es poco frecuente en las clases de ciencias. No es un consejo para convertir cada clase en un debate, sino para que el estudiante tenga ocasión regular de defender una idea con razones y de escuchar una objeción.</p>

<h2>Una rúbrica de cinco criterios</h2>
<p>La hoja <em>Escala</em> del libro propone cinco criterios, cada uno de 0 a 3: <strong>afirmación</strong> (¿es clara y responde la pregunta?), <strong>evidencia</strong> (¿es pertinente, suficiente y verificable?), <strong>razonamiento</strong> (¿explica por qué la evidencia apoya la afirmación?), <strong>contraargumento</strong> (¿considera otras posturas y las responde?) y <strong>fuentes</strong> (¿se identifican, se fechan y se evalúan?). Cada nivel tiene un descriptor, para que el estudiante sepa qué se espera (ver <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a>). El total (0 a 15) se agrupa en tres niveles de ejemplo (12 o más "Sólido", de 8 a 11 "En desarrollo", menos de 8 "Inicial"), cuyos cortes son editables.</p>
<pre><code>' Total y nivel de un argumento (puntajes en B:F; cortes en Parametros!B3 y B4)
=SUMA(B4:F4)                                                                          ' español
=SI(G4>=Parametros!$B$3;"Sólido";SI(G4>=Parametros!$B$4;"En desarrollo";"Inicial"))   ' español
=SUM(B4:F4)                                                                           ' inglés
=IF(G4>=Parametros!$B$3,"Sólido",IF(G4>=Parametros!$B$4,"En desarrollo","Inicial"))   ' inglés

' Criterio más débil de un estudiante (ante un empate, el primero)
=INDICE($B$3:$F$3;COINCIDIR(MIN(B4:F4);B4:F4;0))                                       ' español
=INDEX($B$3:$F$3,MATCH(MIN(B4:F4),B4:F4,0))                                            ' inglés

' Calificaciones idénticas entre dos lectores (50 calificaciones)
=SUMAPRODUCTO(--(Lectura_A!B4:F13=Lectura_B!B4:F13))                                   ' español
=SUMPRODUCT(--(Lectura_A!B4:F13=Lectura_B!B4:F13))                                     ' inglés</code></pre>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
{{img:perfil}}
<p>Diez argumentos escritos, calificados con la rúbrica por la docente A:</p>
<ul>
<li><strong>Niveles:</strong> 2 sólidos, 5 en desarrollo y 3 iniciales; los totales van de 3 a 14 sobre 15.</li>
<li><strong>Perfil del curso:</strong> afirmación 2,4, evidencia 2,2, fuentes 1,7, razonamiento 1,5 y <strong>contraargumento 0,8</strong>. El curso afirma bien y cita datos, pero le cuesta explicar por qué esos datos apoyan su idea y casi no considera objeciones: <strong>4 de 10 argumentos no tienen ningún contraargumento</strong>. Para 7 de los 10 estudiantes, el criterio más débil es el contraargumento.</li>
<li><strong>Segunda lectura:</strong> la docente B calificó los mismos 10 argumentos sin ver la lectura A. De 50 calificaciones, 44 coinciden (88 %), 4 difieren en un punto y <strong>2 difieren en dos puntos</strong>, de modo que el acuerdo exacto o adyacente es del 96 %. Esas dos discrepancias son las que vale la pena conversar para afinar los descriptores.</li>
</ul>
<p><strong>Una lectura honesta:</strong> un acuerdo del 88 % con diez argumentos no demuestra que la rúbrica sea confiable: es un ejemplo de cómo revisarlo con tu propio equipo. Con pocos datos, un par de cambios altera los porcentajes, y el acuerdo entre dos lectores no prueba que ambos midan lo que importa. Además, una rúbrica reduce la riqueza de un argumento a cinco números: úsala para orientar la retroalimentación, y lee el texto.</p>

<h2>Cómo enseñarlo en el aula</h2>
<ol>
<li><strong>Parte de una pregunta con respuestas posibles</strong> y datos reales a mano (una tabla, una gráfica, dos textos que se contradicen). Sin datos, no hay evidencia que evaluar.</li>
<li><strong>Separa los elementos con andamios:</strong> pistas como "yo afirmo...", "los datos muestran...", "esto significa que...", "alguien podría objetar...". Retíralos de a poco, para que el estudiante pueda argumentar sin ellas.</li>
<li><strong>Entrena el razonamiento aparte.</strong> Muestra dos argumentos con la misma evidencia y distinto razonamiento, y pide que expliquen cuál conecta mejor.</li>
<li><strong>Haz del contraargumento una rutina:</strong> cada estudiante escribe la mejor objeción a su propia tesis y cómo respondería. Es el criterio más débil del ejemplo y el que más cuesta, y es respetuoso con la postura contraria.</li>
<li><strong>Califica un criterio a la vez al principio,</strong> y comparte los ejemplos de cada nivel (ver <a href="/error-revela-como-piensa-estudiante-ideas-previas-ciencias-preguntas-diagnostico/">el error como ventana al pensamiento del estudiante</a>).</li>
<li><strong>Calibra con colegas:</strong> califiquen los mismos cinco argumentos por separado y comparen, como hace la segunda lectura del libro.</li>
</ol>
<p><strong>La inteligencia artificial cambia la tarea.</strong> Un asistente de IA puede producir en segundos un texto con apariencia de argumento, con "datos" que a veces son inventados. Eso hace más valioso enseñar a verificar la evidencia y las fuentes (el criterio 5), y a defender el argumento de forma oral o con preguntas de seguimiento, no solo a entregar un texto (ver <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los referentes nacionales (los Estándares Básicos de Competencias y las pruebas Saber) mencionan el razonamiento y la argumentación entre las competencias que se espera desarrollar (por ejemplo, en las pruebas de matemáticas), y la prueba de lectura crítica de Saber 11 apunta, entre otras cosas, a valorar el contenido y los argumentos de los textos; verifica los marcos vigentes del Ministerio y del ICFES. En América Latina, la argumentación aparece en los currículos de lenguaje, ciencias y ciudadanía, aunque la práctica de aula suele ser más expositiva; en el mundo, los programas de "argumentación" y de "discurso dialógico" han mostrado beneficios en ciertos contextos y también las dificultades de llevarlos a escala sin formación docente.</p>
<p>Para los <strong>docentes</strong>, el reto es tiempo y tolerancia a la discusión; para los <strong>directivos</strong>, que los criterios sean comunes entre áreas para no cambiar las reglas cada año (ver <a href="/curriculo-oculto-entre-grados-reglas-que-cambian-cada-ano-mapa-expectativas/">el currículo oculto entre grados</a>); para las <strong>familias</strong>, aceptar que un hijo que "discute" con razones está aprendiendo; y para los <strong>estudiantes</strong>, que cambiar de opinión ante una buena razón es parte del argumentar, no una derrota. Las discusiones deben cuidar el respeto y el clima del aula, y los temas sensibles requieren acuerdos previos.</p>

<h2>Herramientas y plantillas</h2>
<p>Para planear actividades de argumentación, rúbricas y preguntas de seguimiento, y para organizar tus recursos con IA (revisando siempre lo que produce y sin incluir datos de estudiantes en herramientas que no estén diseñadas para custodiarlos), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: el <a href="/descargas/argumentar-con-evidencia/rubrica-argumentacion-evidencia.xlsx">libro de la rúbrica de argumentación</a>, <a href="/transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla/">transferencia del aprendizaje</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuál es la diferencia entre una opinión y un argumento?</h3>
<p>La opinión se afirma; el argumento se sostiene con evidencia y un razonamiento que explica por qué esa evidencia apoya la afirmación, y considera objeciones.</p>
<h3>¿Qué es el modelo de Toulmin?</h3>
<p>Un modelo de Stephen Toulmin (1958) que describe el argumento con afirmación, datos, garantía, respaldo, matiz y refutación. En el aula suele simplificarse a afirmación, evidencia y razonamiento.</p>
<h3>¿Desde qué edad se puede enseñar a argumentar?</h3>
<p>Desde primaria, con andamios sencillos ("yo pienso... porque..."), aumentando la exigencia con la edad. Los efectos varían según el contexto y la tarea.</p>
<h3>¿Cómo evito que un estudiante use IA para escribir el argumento?</h3>
<p>Pide que verifique y cite las fuentes, que defienda el argumento oralmente o responda preguntas de seguimiento, y evalúa también el proceso, no solo el texto.</p>
<h3>¿Cómo uso el libro?</h3>
<p>Escribe los puntajes (0 a 3) de cada criterio para cada estudiante, y, si lo deseas, de una segunda lectura; el libro calcula totales, niveles, el perfil del curso y el acuerdo entre lectores.</p>

<p class="notice"><strong>Pruébalo con un texto de tu curso.</strong> Descarga el <a href="/descargas/argumentar-con-evidencia/rubrica-argumentacion-evidencia.xlsx">libro de la rúbrica</a>, califica diez argumentos de tus estudiantes (y pídele a un colega que califique los mismos), y mira cuál es el criterio más débil del grupo.</p>

<h2>Para pensar</h2>
<p>Enseñar a argumentar implica aceptar que los estudiantes cuestionen, incluso nuestras propias afirmaciones. <strong>¿Cuándo fue la última vez que un estudiante te presentó una objeción a lo que enseñaste, y cómo la recibiste? Y si evaluáramos también cómo escuchan y responden las razones de los demás, ¿qué cambiaría en nuestras clases?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:elementos}}' => $img('argumentar-con-evidencia-elementos', 499, 'Tabla con cuatro elementos de un argumento, la pregunta que responde cada uno y una pista de ejemplo: afirmación, evidencia, razonamiento y contraargumento.', 'De la opinión al argumento.'),
    '{{img:perfil}}' => $img('argumentar-con-evidencia-perfil', 480, 'Gráfico de barras con el promedio por criterio de la rúbrica: afirmación 2,4, evidencia 2,2, razonamiento 1,5, contraargumento 0,8 y fuentes 1,7.', 'Perfil del curso: el contraargumento es el criterio más débil.'),
]);

return [
    'slug' => 'argumentar-con-evidencia-ensenar-afirmacion-razonamiento-contraargumento-rubrica-excel',
    'title' => 'Argumentar con evidencia: cómo enseñar a sostener lo que se afirma, con una rúbrica y un libro de Excel',
    'excerpt' => 'Qué es un argumento, qué dice la investigación sobre aprender argumentando y cómo evaluar afirmación, evidencia, razonamiento, contraargumento y fuentes con una rúbrica y un libro de Excel con dos lecturas.',
    'seo_title' => 'Argumentar con evidencia: rúbrica y libro de Excel',
    'seo_description' => 'Cómo enseñar a argumentar con evidencia: afirmación, razonamiento y contraargumento, con una rúbrica de cinco criterios y un libro de Excel con dos lecturas.',
    'focus_keyword' => 'argumentar con evidencia',
    'cover' => '/assets/img/articulos/argumentar-con-evidencia/argumentar-con-evidencia-portada',
    'cover_alt' => 'Portada "Argumentar con evidencia: enseñar a sostener lo que se afirma" con una tarjeta: 0,8 de 3 es el promedio del contraargumento, el criterio más débil del curso de ejemplo.',
    'published_at' => '2027-02-24 12:00:00',
    'content_html' => $html,
];
