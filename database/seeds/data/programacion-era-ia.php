<?php

declare(strict_types=1);

// «¿Para qué enseñar a programar si la IA escribe el código? Lo que sigue importando». Fuentes verificadas el 9 de octubre de 2026: Bastani et al. (2024, preprint, «Generative AI Can Harm Learning»), Peng et al. (2023, Copilot), Prather et al. (ICER 2024, «The Widening Gap»). Ejercicio de depuración probado con unittest (3 de 6 pruebas fallan con el código de la IA; 6 de 6 con la solución). Rúbrica verificada en Excel.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/programacion-era-ia/' . $name;
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
<p>Un estudiante de décimo entrega un programa que funciona a la perfección. Le preguntas cómo lo hizo y responde: «le pedí a la IA». Le pides que cambie una línea y no sabe por dónde empezar. Lo que antes era una señal de aprendizaje (el programa funciona) ya no lo es. Y con la pregunta que muchos docentes se hacen en voz baja: <strong>¿para qué enseñar a programar si una máquina escribe el código?</strong></p>
<p>Este artículo propone una respuesta basada en evidencia: <strong>programar sigue siendo pensar</strong>, y lo que debe cambiar es cómo se enseña y cómo se evalúa. Incluye una <a href="/descargas/programacion-ia/rubrica-programacion-era-ia.xlsx">rúbrica descargable en Excel</a> para evaluar comprensión (no solo que el código corra), una bitácora de uso de IA y un <a href="/descargas/programacion-ia/ejercicio_mediana.py">ejercicio de depuración</a> con código que parece correcto, probado con pruebas automáticas. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> La evidencia disponible dice que la IA acelera tareas de programación, pero que usada sin límites puede crear una ilusión de progreso: en un estudio con unos 1.000 estudiantes de secundaria, quienes practicaron con un asistente sin límites mejoraron durante la práctica y rindieron peor en un examen sin IA. Por eso <strong>la enseñanza se desplaza hacia entender el problema, probar, depurar y explicar</strong>, y la evaluación hacia el proceso y la comprensión, con el uso de la IA declarado. Son estudios concretos, con limitaciones: dan señales, no leyes.</p>

<h2>Qué dice la evidencia (con sus límites)</h2>
<ul>
<li><strong>Una ayuda que puede dañar (Bastani et al., 2024).</strong> En un ensayo aleatorizado con unos 1.000 estudiantes de secundaria en Turquía (matemáticas de 9.º a 11.º), los que practicaron con un asistente tipo ChatGPT («GPT Base») rindieron un 48 % mejor durante la práctica, pero un <strong>17 % peor</strong> en el examen sin IA que el grupo de control. Los que usaron un tutor diseñado con salvaguardas (con las soluciones y las notas del docente, e instrucciones de no dar la respuesta) rindieron un 127 % mejor en la práctica y <strong>no tuvieron pérdida</strong> en el examen frente al control. Es un preprint de 2024 y de matemáticas, no de programación; pero muestra el mecanismo: usar la herramienta como muleta.</li>
<li><strong>Una ayuda que acelera (Peng et al., 2023).</strong> En un experimento con programadores contratados, quienes tuvieron GitHub Copilot terminaron una tarea acotada (un servidor HTTP en JavaScript) un <strong>55,8 % más rápido</strong> (intervalo de confianza muy amplio, del 21 % al 89 %). Mide velocidad en una tarea, no aprendizaje.</li>
<li><strong>Una ayuda que engaña (Prather et al., ICER 2024).</strong> En un estudio de laboratorio con 21 estudiantes de un primer curso de programación, 20 terminaron el problema con IA; pero entre los 10 que tuvieron dificultades, 9 llegaron a la solución con la IA y la mayoría <strong>creía entender más de lo que entendía</strong>: la herramienta les daba una ilusión de progreso. Es un estudio pequeño y exploratorio. Los estudiantes que ya sabían qué querían escribir usaron la IA para acelerar y descartaron las sugerencias malas.</li>
</ul>
{{img:evidencia}}
<p>La lectura conjunta: <strong>la IA beneficia a quien ya entiende y puede perjudicar a quien aún no</strong>, y un tutor con límites (que guía en vez de resolver) mitiga el daño. Lo cual nos dice qué hacer en el aula.</p>

<h2>Lo que cambia y lo que sigue importando</h2>
{{img:cambia}}
<p>Escribir la sintaxis pasa a un segundo plano; lo que sube de valor es:</p>
<ol>
<li><strong>Entender el problema:</strong> entradas, salidas, restricciones, casos borde. Una IA responde a lo que le pides, y pedir bien exige haber entendido.</li>
<li><strong>Descomponer y diseñar:</strong> dividir un problema grande en pasos, que es lo que ninguna sintaxis reemplaza.</li>
<li><strong>Probar:</strong> si no puedes decir cómo sabrías que el código funciona, no puedes verificar lo que te entrega una IA.</li>
<li><strong>Depurar y leer código ajeno:</strong> gran parte del trabajo real será revisar lo que otro, o una máquina, escribió.</li>
<li><strong>Explicar:</strong> si puedes explicar por qué funciona, lo entiendes.</li>
</ol>

<h2>Un ejercicio: el código que parece correcto</h2>
<p>Este es el tipo de actividad que desarrolla esas habilidades. Una IA generó esta función para calcular la mediana de las notas de un curso:</p>
<pre><code>def mediana(valores):
    ordenados = sorted(valores)
    n = len(ordenados)
    return ordenados[n // 2]</code></pre>
<p>Funciona con los primeros ejemplos que se prueban (con una cantidad impar de datos). Pero tiene errores de fondo. Escribí seis pruebas y las ejecuté:</p>
<pre><code>$ python -m unittest pruebas_mediana -v
test_cantidad_impar ... ok
test_un_solo_valor ... ok
test_no_modifica_la_lista_original ... ok
test_cantidad_par ... FAIL     AssertionError: 3 != 2.5
test_par_sin_ordenar ... FAIL  AssertionError: 3.0 != 2.5
test_lista_vacia ... ERROR     IndexError: list index out of range

Ran 6 tests: FAILED (failures=2, errors=1)</code></pre>
<p>La tarea del estudiante: <strong>ejecutar las pruebas, explicar por qué falla cada una y corregir la función sin cambiar las pruebas</strong>. Los errores son típicos de código generado sin criterio: con una cantidad par de datos, la mediana debe ser el promedio de los dos centrales (aquí devuelve el central superior); y con una lista vacía lanza un error poco claro en lugar de uno que explique el problema. Esta es la solución (también incluida, comentada, en el kit), con la que pasan las seis pruebas:</p>
<pre><code>def mediana(valores):
    if not valores:
        raise ValueError("La lista no puede estar vacía")
    ordenados = sorted(valores)
    n = len(ordenados)
    medio = n // 2
    if n % 2 == 1:
        return ordenados[medio]
    return (ordenados[medio - 1] + ordenados[medio]) / 2</code></pre>
<p>Fíjate en lo que el ejercicio exige al estudiante: leer pruebas, razonar sobre casos borde, localizar la causa y justificar el arreglo. <strong>Ninguna de esas tareas se resuelve pegando el enunciado en una IA sin entenderlo.</strong> Y si la usa, la bitácora le pide decir qué verificó.</p>

<h2>La rúbrica: evaluar comprensión, no solo resultados</h2>
<p>Si calificas solo que el programa funcione, calificas la herramienta. La rúbrica del libro (cuatro niveles por criterio, con pesos editables) cambia el foco:</p>
<table>
<thead><tr><th>Criterio</th><th>Peso sugerido</th><th>Qué evidencia mira</th></tr></thead>
<tbody>
<tr><td><strong>Comprensión del problema</strong></td><td>15 %</td><td>Entradas, salidas, restricciones y casos borde</td></tr>
<tr><td><strong>Diseño y descomposición</strong></td><td>15 %</td><td>Plan, funciones, justificación</td></tr>
<tr><td><strong>Corrección y pruebas</strong></td><td>20 %</td><td>Pruebas de casos típicos y borde</td></tr>
<tr><td><strong>Depuración</strong></td><td>15 %</td><td>Localizar y explicar errores</td></tr>
<tr><td><strong>Explicación y comprensión (defensa oral)</strong></td><td>20 %</td><td>Explicar y modificar una línea en vivo</td></tr>
<tr><td><strong>Uso responsable de la IA</strong></td><td>10 %</td><td>Bitácora: qué pidió, qué verificó, qué cambió</td></tr>
<tr><td><strong>Legibilidad y buenas prácticas</strong></td><td>5 %</td><td>Nombres, estructura, comentarios</td></tr>
</tbody>
</table>
<p>El libro calcula el puntaje (con todos los criterios en nivel 3, por ejemplo, da 75/100, equivalente a 4,0 en una escala lineal de 1 a 5, que debes adaptar a tu SIEE) y avisa si los pesos no suman 100. Tiene además la <strong>bitácora de uso de IA</strong> y una hoja de <strong>tareas a prueba de IA</strong>: trazar código a mano, depurar código dado, escribir pruebas primero, modificar en vivo, explicar una línea y programar sin asistentes en clase. Coherente con la idea de que la evaluación debe medir aprendizaje y no cumplimiento (ver <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden las calificaciones</a>) y con la <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA</a>.</p>

<h2>Cómo organizar las clases</h2>
<ol>
<li><strong>Empieza sin IA</strong> en lo básico (variables, condiciones, ciclos): necesitan la fluidez para poder juzgar lo que una IA propone.</li>
<li><strong>Introduce la IA con límites:</strong> como tutor que pregunta y explica, no como proveedor de soluciones; un tutor con salvaguardas fue lo que mitigó el daño en el estudio de Bastani.</li>
<li><strong>Enseña a pedir bien</strong> y a leer críticamente: ejercicios de depurar código generado.</li>
<li><strong>Evalúa en dos momentos:</strong> un trabajo con IA declarada y una prueba breve sin IA (o una defensa oral) que verifique la comprensión.</li>
<li><strong>Mide si funciona:</strong> compara con y sin la estrategia (ver la <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">prueba de cuatro semanas</a>).</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la discusión se da en las universidades y en los colegios con currículos de computación; varios informes de la comunidad de educación en computación plantean que la IA obliga a repensar qué y cómo se evalúa. En Colombia y Latinoamérica, la enseñanza de programación en colegios es muy desigual: hay instituciones con laboratorios y proyectos, y muchas sin equipos suficientes ni docentes de tecnología con formación específica. Para los <strong>docentes</strong> de tecnología e informática, el reto es evaluar comprensión con grupos grandes (las defensas orales breves y las pruebas sin IA ayudan); para los <strong>directivos</strong>, definir reglas claras (ver <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">autonomía pedagógica ante las plataformas</a>); para los <strong>estudiantes</strong>, entender que aprender a programar es aprender a razonar, y para las <strong>familias</strong>, que un programa que funciona no siempre es señal de aprendizaje.</p>

<h2>Herramientas para el docente</h2>
<p>Para planear las actividades y producir pruebas breves (en papel, sin IA) con sus soluciones, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> entrega el material para que lo revises, y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas para planear.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">¿la IA amplía o reemplaza el pensamiento del estudiante?</a> y <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">la deuda tecnológica de los colegios</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Hay que prohibir la IA en las clases de programación?</h3>
<p>No necesariamente. La evidencia sugiere que sin límites puede perjudicar el aprendizaje, y que con diseño (tutor que guía, bitácora, evaluación de comprensión) puede ayudar. Define usos permitidos, condicionados y no autorizados.</p>
<h3>¿Cómo sé si el estudiante entendió o solo copió?</h3>
<p>Pídele explicar y modificar su código en vivo, trazar a mano un ejemplo o depurar un código dado. Quien lo entiende puede hacerlo; quien solo copió, difícilmente.</p>
<h3>¿Sigue siendo necesario aprender sintaxis?</h3>
<p>Sí, lo suficiente para leer, juzgar y corregir el código que se obtiene, de la IA o de otra persona. La fluidez básica permite detectar los errores.</p>
<h3>¿Qué lenguaje conviene enseñar?</h3>
<p>El que permita enfocarse en el razonamiento: muchos colegios usan Python o bloques visuales al comienzo. Lo importante es la comprensión, no la herramienta.</p>
<h3>¿Cómo evalúo con grupos grandes?</h3>
<p>Combina pruebas breves sin IA, rúbricas con evidencias (pruebas, bitácora) y defensas orales por muestreo.</p>

<p class="notice"><strong>Pruébalo en tu clase.</strong> Descarga la <a href="/descargas/programacion-ia/rubrica-programacion-era-ia.xlsx">rúbrica</a> y el <a href="/descargas/programacion-ia/ejercicio_mediana.py">ejercicio de depuración</a> (con sus <a href="/descargas/programacion-ia/pruebas_mediana.py">pruebas</a> y la <a href="/descargas/programacion-ia/solucion_mediana.py">solución</a>) y aplícalos con un grupo.</p>

<h2>Para pensar</h2>
<p>Si una máquina puede escribir el programa, quizá lo que de verdad enseñamos al enseñar a programar siempre fue otra cosa: a formular problemas, a dudar de las respuestas y a explicarse. <strong>¿Está la escuela preparada para evaluar eso, o seguiremos premiando programas que funcionan sin preguntar quién los entendió? Y si la IA ayuda mucho a los que ya entienden y poco a los que no, ¿estamos ampliando la brecha entre estudiantes cuando ponemos la herramienta en todas las manos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:evidencia}}' => $img('programacion-era-ia-evidencia', 573, 'Cuatro tarjetas con la evidencia: un asistente sin límites mejoró la práctica un 48 % y empeoró el examen sin IA un 17 %; Copilot hizo una tarea un 55,8 % más rápida; 20 de 21 novatos terminaron con IA aunque algunos creyeron entender más de lo que entendían; y un tutor con límites no tuvo pérdida.', 'La IA acelera, pero también puede crear ilusión de progreso.'),
    '{{img:cambia}}' => $img('programacion-era-ia-cambia', 633, 'Dos columnas: lo que cambia en la enseñanza de la programación con IA, como pasar a un segundo plano la sintaxis y evaluar el proceso, y lo que sigue importando: entender el problema, descomponer y diseñar, probar y depurar y explicar por qué funciona.', 'Programar sigue siendo pensar.'),
]);

return [
    'slug' => 'ensenar-programacion-era-ia-que-sigue-importando-rubrica-depuracion',
    'title' => '¿Para qué enseñar a programar si la IA escribe el código? Lo que sigue importando, con rúbrica y un ejercicio de depuración',
    'excerpt' => 'Qué dice la evidencia sobre la IA y el aprendizaje de la programación, qué cambia y qué sigue importando, un ejercicio de depuración con código que parece correcto (probado con pruebas automáticas) y una rúbrica para evaluar comprensión.',
    'seo_title' => 'Enseñar programación con IA: rúbrica y depuración',
    'seo_description' => 'Cómo enseñar y evaluar programación cuando la IA escribe código: evidencia, rúbrica descargable, bitácora de uso y un ejercicio de depuración probado.',
    'focus_keyword' => 'enseñar programación con IA',
    'cover' => '/assets/img/articulos/programacion-era-ia/programacion-era-ia-portada',
    'cover_alt' => 'Portada «¿Para qué enseñar a programar si la IA escribe el código? Lo que sigue importando» con una tarjeta: +48 % en la práctica y −17 % en el examen sin IA con un asistente sin límites; un tutor con límites no tuvo pérdida.',
    'published_at' => '2026-12-02 12:00:00',
    'content_html' => $html,
];
