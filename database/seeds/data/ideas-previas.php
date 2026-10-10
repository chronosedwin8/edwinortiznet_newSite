<?php

declare(strict_types=1);

// "El error revela cómo piensa el estudiante: ideas previas en ciencias". Fuentes consultadas el 10-oct-2026: A Private Universe (Schneps y Sadler, Harvard-Smithsonian CfA, 1987); reporte de prensa de 1988 (1 de 20); Force Concept Inventory (Hestenes, Wells y Swackhamer, The Physics Teacher, 1992). Libro verificado en Excel 16 y Python con datos ficticios exagerados: 29 % correctas, 55 % idea previa, 8 de 8 preguntas con idea previa mayor, perfiles 15/11/3/1.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ideas-previas/' . $name;
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
<p>Pregunta: "¿Por qué hay verano e invierno?". Respuesta de una estudiante de noveno: "Porque en verano la Tierra está más cerca del Sol". Es una respuesta incorrecta, pero no es una respuesta tonta: es una explicación razonable desde la experiencia cotidiana (lo cercano se calienta más), y la <strong>comparte una parte sorprendente de los adultos</strong>. Corregirla con "no, es por la inclinación del eje" suele no funcionar, porque la explicación nueva choca con una idea que la estudiante ya considera obvia.</p>
<p>Este artículo trata de lo que revelan esos errores: <strong>las ideas previas (o concepciones alternativas)</strong>, qué dice la investigación sobre su persistencia, cómo diseñar preguntas diagnóstico cuyos distractores son ideas previas conocidas y cómo trabajar con ellas. Incluye un <a href="/descargas/concepciones-alternativas/banco-diagnostico-ideas-previas.xlsx">libro de Excel</a> con ocho preguntas de ciencias, cada una con una idea previa frecuente como distractor etiquetado, y un análisis automático del grupo y de cada estudiante, verificado en Microsoft Excel 16 y contra un cálculo independiente en Python. Fuentes revisadas el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos del grupo son <strong>ficticios y exagerados a propósito</strong> para ilustrar el análisis (en un grupo real, los porcentajes variarán mucho). Las ideas previas del catálogo son concepciones frecuentes descritas en la literatura de enseñanza de las ciencias; su frecuencia depende del grupo, de la edad y del país, y conviene comprobarla con tus estudiantes. El enfoque no garantiza que las ideas cambien: las ideas previas son resistentes.</p>

<h2>Qué son las ideas previas y por qué importan</h2>
<p>Los estudiantes no llegan al aula con la mente en blanco: llegan con explicaciones construidas a partir de su experiencia (el pesado cae más rápido, la corriente se gasta en el bombillo, las plantas comen tierra). La literatura las llama <em>ideas previas</em>, <em>concepciones alternativas</em> o, con menos acierto, <em>errores conceptuales</em>. Prefiero los dos primeros nombres porque subrayan algo importante: <strong>son explicaciones razonables, no descuidos</strong>. Quien responde "la distancia al Sol" no está distraído; está aplicando una regla (más cerca, más calor) que en la vida diaria funciona.</p>
<p>La investigación muestra que estas ideas sobreviven a la enseñanza habitual. Dos referentes clásicos:</p>
<ul>
<li><strong><em>A Private Universe</em> (1987).</strong> Un documental del Harvard-Smithsonian Center for Astrophysics (de Schneps y Sadler) en el que graduados de Harvard, preguntados por la causa de las estaciones, explicaron con seguridad que la Tierra está más cerca del Sol en verano, y por las fases de la Luna que las produce la sombra de la Tierra, ideas que también tenían estudiantes de noveno de una escuela cercana. Un reporte de prensa de 1988 contó que solo uno de veinte entrevistados dio la explicación correcta. Es un estudio de casos con entrevistas, no una muestra representativa, pero ilustra la persistencia de las ideas.</li>
<li><strong>El Force Concept Inventory (1992).</strong> Un instrumento de opción múltiple (Hestenes, Wells y Swackhamer, <em>The Physics Teacher</em>) para evaluar la comprensión conceptual de la mecánica newtoniana. Su premisa es que los estudiantes llegan con un sistema de creencias de sentido común sobre el mundo físico, y sus autores encontraron que la enseñanza que no las toma en cuenta es casi totalmente ineficaz para la mayoría. Sus distractores no son errores al azar: reproducen las ideas previas frecuentes.</li>
</ul>

<h2>Preguntas diagnóstico: el distractor como pista</h2>
<p>La idea de las preguntas diagnóstico es simple: <strong>cada opción incorrecta representa una idea previa conocida</strong>, de modo que la respuesta del estudiante dice no solo si sabe, sino <em>qué piensa</em>. En el libro, la hoja <em>Preguntas</em> tiene ocho preguntas de ciencias, cada una con cuatro opciones y una etiqueta: la correcta (OK), una idea previa (C1 a C8) o ninguna.</p>
{{img:ideas}}
<ol>
<li><strong>Estaciones:</strong> ¿distancia al Sol (C1) o inclinación del eje y duración de los días?</li>
<li><strong>Fases de la Luna:</strong> ¿sombra de la Tierra (C2) o parte iluminada visible desde la Tierra?</li>
<li><strong>Caída de objetos</strong> (en un tubo sin aire): ¿el pesado llega antes (C3) o llegan a la vez?</li>
<li><strong>Circuito eléctrico:</strong> ¿la corriente se gasta en el bombillo (C4) o es la misma en todo el circuito?</li>
<li><strong>Origen de la masa de una planta:</strong> ¿del suelo (C5) o del dióxido de carbono del aire y del agua?</li>
<li><strong>Fuerza y movimiento:</strong> a velocidad constante sin fricción, ¿hay una fuerza en la dirección del movimiento (C6) o ninguna fuerza neta?</li>
<li><strong>Agua que hierve:</strong> ¿las burbujas contienen aire (C7) o vapor de agua?</li>
<li><strong>Calor y temperatura:</strong> ¿el metal se siente más frío porque tiene menor temperatura (C8) o porque conduce mejor el calor de la mano?</li>
</ol>
<p>Cómo se diseñan preguntas así: (1) se parte de ideas previas documentadas en la literatura y, mejor, de entrevistas con tus propios estudiantes; (2) se escribe un distractor que exprese cada idea de forma que un estudiante que la tiene la reconozca como "la respuesta obvia"; (3) los demás distractores se redactan plausibles; (4) se prueba con un grupo y se mira qué opciones eligen. Una variante útil son las preguntas de dos niveles: primero la respuesta y luego la razón.</p>

<h2>Lo que muestra el libro (grupo ficticio)</h2>
<p>El libro cuenta cuántos estudiantes eligen cada opción de cada pregunta. En el grupo ficticio de 30 estudiantes, <strong>29 % de las respuestas fueron correctas y 55 % siguieron la idea previa etiquetada</strong>, y en las ocho preguntas la idea previa superó a la respuesta correcta. Por pregunta:</p>
<ul>
<li><strong>Estaciones:</strong> 20 de 30 eligieron la distancia al Sol (67 %) y 6 la respuesta correcta (20 %). Es la idea previa más frecuente del grupo.</li>
<li><strong>Origen de la masa de una planta:</strong> 20 de 30 (67 %) eligieron el suelo; 6 la respuesta correcta.</li>
<li><strong>Agua que hierve:</strong> 18 de 30 (60 %) eligieron aire; 7 vapor de agua.</li>
<li><strong>Circuito:</strong> 17 de 30 (57 %) creen que la corriente se gasta; 11 (37 %) acertaron.</li>
<li><strong>Caída de objetos:</strong> 16 de 30 (53 %) eligieron la piedra primero; 13 (43 %) la opción correcta, la mejor de las ocho.</li>
<li><strong>Fuerza y movimiento:</strong> 11 (37 %) frente a 10 (33 %): casi empatan.</li>
</ul>
<p>La hoja <em>Estudiantes</em> clasifica a cada estudiante por cuántas veces eligió la idea previa: 15 con "ideas previas muy arraigadas" (5 o más), 11 con "varias ideas previas" (3 o 4), 3 "mixto" y 1 con "comprensión sólida". Es un perfil para decidir el trabajo posterior, <strong>no una nota ni una etiqueta</strong>. El resumen devuelve además la idea previa más frecuente (C1, la distancia al Sol).</p>
<p>La lectura de estos números cambia lo que haces el lunes: con 20 de 30 en la idea de la distancia al Sol, un "no, es por la inclinación" no alcanza. Hace falta una actividad que ponga la idea en crisis (ver más abajo). En cambio, la idea de que los pesados caen antes tiene menos peso y es la que más rápido se corrige con una demostración.</p>

<h2>Cinco pasos para trabajar una idea previa</h2>
{{img:pasos}}
<ol>
<li><strong>Pregunta "¿por qué lo piensas?"</strong> y escucha la explicación completa. Antes de corregir, entiende la lógica del estudiante.</li>
<li><strong>Clasifica la idea previa:</strong> ¿cuál de las del catálogo (o cuál nueva) explica la respuesta? La hoja de análisis ya lo hace por pregunta.</li>
<li><strong>Confronta con una predicción y una observación.</strong> El esquema <em>predecir, observar, explicar</em>: los estudiantes escriben qué creen que pasará (por ejemplo, qué cae primero, una hoja de papel o una hoja arrugada, con y sin libro debajo), observan y explican la diferencia. Sentir que su idea no explica lo observado es lo que abre la puerta a otra.</li>
<li><strong>Reconstruye el modelo científico</strong> con ellos: un modelo, un diagrama, una simulación. No basta con decirlo.</li>
<li><strong>Verifica otro día con una pregunta nueva,</strong> parecida pero no idéntica. Las ideas previas tienden a reaparecer, y es normal: se necesitan varias oportunidades (ver <a href="/transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla/">transferencia del aprendizaje</a>).</li>
</ol>
<p>El enfoque de cambio conceptual tiene resultados variados en la investigación: funciona mejor cuando el estudiante percibe que su idea no sirve y que la nueva explica más, y peor cuando se trata como una corrección rápida. Combínalo con prácticas de recuperación y espaciado (ver <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">del simulacro al plan de mejora</a>, que usa la lógica de clasificar errores por causa).</p>

<h2>Esto no es solo de ciencias</h2>
<p>En matemáticas, las ideas previas son las "reglas mal generalizadas" (ver <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">el error matemático que se repite</a>): sumar numeradores con numeradores, creer que multiplicar siempre agranda. En lenguaje, creer que "un texto es verdadero porque lo dice un libro". En ciencias sociales, creer que la historia es una lista de fechas. El método es el mismo: <strong>preguntar por qué, clasificar la lógica detrás del error y diseñar una situación que ponga esa lógica a prueba</strong>.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los Estándares Básicos de Competencias en Ciencias Naturales (MEN, 2004) y las pruebas Saber ponen el énfasis en explicar fenómenos y usar conceptos en situaciones, lo que exige pasar de la definición memorizada al modelo. La investigación sobre concepciones alternativas es internacional y abundante, desde la física y la astronomía hasta la biología y la química, y muestra patrones muy parecidos entre países, lo que sugiere que provienen de la experiencia compartida del mundo físico y no de un currículo particular. Para los <strong>docentes</strong>, el reto es ver el error como información; para los <strong>directivos</strong>, dar tiempo para el diagnóstico y la confrontación (una clase de 45 minutos rara vez basta); para las <strong>familias</strong>, saber que equivocarse con una idea razonable es parte de aprender, y que no hace falta "corregir" al hijo con un dato aprendido de memoria; y para los <strong>estudiantes</strong>, que preguntarse "¿por qué pensaba eso?" es una habilidad. Un riesgo: etiquetar a los estudiantes ("el de las ideas previas arraigadas"); el perfil sirve para planear, no para clasificar personas.</p>

<h2>Herramientas y plantillas</h2>
<p>Para generar preguntas diagnóstico con distractores basados en ideas previas y otras evidencias de aprendizaje, y para organizar tus recursos con IA (siempre revisando que la respuesta correcta sea correcta y que las ideas previas estén bien representadas), mira estas herramientas propias.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/analisis-de-items-excel-dificultad-discriminacion-distractores-kr20-libro/">análisis de ítems en Excel</a> (cómo leer los distractores de cualquier prueba), <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">planeación inversa</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>. Para adaptar el trabajo a estudiantes con barreras de aprendizaje, <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es una idea previa o concepción alternativa?</h3>
<p>Una explicación que el estudiante construyó a partir de su experiencia y que difiere de la explicación científica. Suele ser razonable y resistente a la enseñanza habitual.</p>
<h3>¿Por qué las corrijo y vuelven a aparecer?</h3>
<p>Porque corregir con un dato no cambia el modelo mental. Hace falta que el estudiante vea que su idea no explica lo observado y que construya una explicación mejor, y volver sobre el tema varias veces.</p>
<h3>¿Cómo diseño una pregunta diagnóstico?</h3>
<p>Escribe una opción correcta y distractores que expresen ideas previas conocidas, de modo que quien las tiene las reconozca como "la respuesta obvia"; pruébala con un grupo y revisa qué eligen.</p>
<h3>¿Las ideas previas son lo mismo que los errores?</h3>
<p>Los errores son la señal; las ideas previas son lo que suele estar detrás. Una misma idea puede producir errores distintos.</p>
<h3>¿Cambian las ideas previas con una buena explicación?</h3>
<p>Con una explicación sola, rara vez. Funcionan mejor las situaciones que generan conflicto con lo que el estudiante espera, el trabajo con modelos y la práctica repetida.</p>

<p class="notice"><strong>Prueba el diagnóstico en tu próxima unidad.</strong> Descarga el <a href="/descargas/concepciones-alternativas/banco-diagnostico-ideas-previas.xlsx">banco de preguntas diagnóstico</a>, reemplaza las preguntas por las de tu tema (con las ideas previas que veas en tus estudiantes) y mira qué idea domina en tu grupo antes de empezar.</p>

<h2>Para pensar</h2>
<p>Cuando un estudiante se equivoca, ¿qué pregunta hacemos primero: "¿cuál es la respuesta correcta?" o "¿cómo lo pensaste?". <strong>¿Cuántas de las ideas que hoy consideramos obvias fueron en su momento ideas previas de la humanidad? Y si un error fuera siempre una ventana a una explicación razonable, ¿cómo cambiaría lo que hacemos cuando corregimos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ideas}}' => $img('ideas-previas-ideas', 553, 'Tabla con cinco ideas previas frecuentes en ciencias y el modelo científico: estaciones, fases de la Luna, caída libre, circuito eléctrico y plantas.', 'Lo que muchos piensan y lo que dice la ciencia.'),
    '{{img:pasos}}' => $img('ideas-previas-pasos', 467, 'Cinco pasos para trabajar una idea previa: preguntar, clasificar, confrontar, reconstruir y verificar.', 'Cinco pasos para trabajar una idea previa.'),
]);

return [
    'slug' => 'error-revela-como-piensa-estudiante-ideas-previas-ciencias-preguntas-diagnostico',
    'title' => 'El error revela cómo piensa el estudiante: ideas previas en ciencias y preguntas diagnóstico (libro verificado)',
    'excerpt' => 'Qué son las ideas previas o concepciones alternativas, qué dice la investigación sobre su persistencia y cómo diseñar preguntas diagnóstico cuyos distractores las revelan, con un libro de Excel con ocho preguntas de ciencias.',
    'seo_title' => 'Ideas previas en ciencias: preguntas diagnóstico',
    'seo_description' => 'Qué son las ideas previas en ciencias, por qué persisten y cómo diseñar preguntas diagnóstico cuyos distractores las revelan, con libro de Excel.',
    'focus_keyword' => 'ideas previas en ciencias',
    'cover' => '/assets/img/articulos/ideas-previas/ideas-previas-portada',
    'cover_alt' => 'Portada "El error revela cómo piensa el estudiante: ideas previas en ciencias" con una tarjeta: 55 % y 29 %, respuestas con idea previa y correctas en un grupo ficticio.',
    'published_at' => '2027-02-03 12:00:00',
    'content_html' => $html,
];
