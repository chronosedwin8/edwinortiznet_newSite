<?php

declare(strict_types=1);

// «Prueba de cuatro semanas para saber si una herramienta educativa mejora el aprendizaje». Fuentes verificadas el 9 de octubre de 2026: Informe GEM 2023 de la UNESCO; comunicado de LearnPlatform by Instructure (30 jun. 2025, vía cobertura); niveles de evidencia de ESSA. Simulación y ficha propias con datos ficticios, ejecutadas en Python y Microsoft Excel.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/prueba-herramienta-educativa/' . $name;
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
<p>Un proveedor promete que su plataforma «mejora el rendimiento hasta en un 30 %». Un docente la prueba un mes con su curso y las notas suben. ¿Funciona la herramienta? La respuesta honesta, casi siempre, es: <strong>no se sabe</strong>. Los estudiantes habrían mejorado de todos modos (más clases, más práctica, más madurez), la prueba final pudo ser más fácil, y el grupo estaba entusiasmado por la novedad.</p>
<p>Este artículo propone una <strong>prueba de cuatro semanas</strong>, al alcance de cualquier docente o colegio, para evaluar si una herramienta educativa mejora el aprendizaje. Incluye una <a href="/descargas/prueba-herramienta-educativa/ficha-prueba-4-semanas-herramienta-educativa.xlsx">ficha descargable en Excel</a> que calcula los resultados y una <a href="/descargas/prueba-herramienta-educativa/simulacion-prueba-herramienta.py">simulación en Python</a> que muestra por qué el «antes y después» engaña. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Para saber si una herramienta funciona hay que comparar: un grupo que la usa y otro parecido que no, medidos con la misma prueba al inicio y al final, con el criterio de éxito definido <strong>antes</strong>. En mi simulación, una herramienta que no hacía nada «mejoró» las notas en el 67 % de las pruebas sin grupo de comparación. Con pocos estudiantes, hasta con comparación el azar pesa; por eso el resultado se interpreta con cautela y se repite.</p>

<h2>Por qué casi nunca sabemos si funciona</h2>
<p>El <a href="https://gem-report-2023.unesco.org/">Informe de Seguimiento de la Educación en el Mundo 2023 de la UNESCO</a> concluye que hay poca evidencia robusta e imparcial sobre el valor de la tecnología en la educación, que buena parte viene de quienes la venden, que los productos cambian en promedio cada 36 meses y que solo el 11 % de docentes y administradores encuestados en 17 estados de EE. UU. pidió evidencia revisada por pares antes de adoptar una herramienta. Hay avances: según el comunicado de LearnPlatform by Instructure del 30 de junio de 2025, el 45 % de las herramientas de su lista EdTech Top 40 tenía investigación publicada bajo los niveles de evidencia de la ley estadounidense ESSA, frente al 32 % del año anterior. Esos niveles van de estudios con asignación al azar (evidencia fuerte), pasando por estudios cuasi-experimentales y correlacionales con controles, hasta un simple «fundamento razonable». Es decir, <strong>no toda evidencia pesa igual</strong>, y lo mejor que puedes hacer en tu aula es acercarte a la parte fuerte de esa escala.</p>

<h2>Por qué el «antes y después» engaña</h2>
<p>La trampa clásica: aplicar la herramienta, medir antes y después, y atribuirle la mejora. Pero los estudiantes aprenden en cuatro semanas incluso sin herramienta nueva. Lo simulé con supuestos ficticios y editables: nivel de los estudiantes ~ N(60, 12); error de medición de cada prueba de 6 puntos; crecimiento natural de 4 puntos en cuatro semanas; efecto real de la herramienta, cero.</p>
<ul>
<li><strong>Sin grupo de comparación</strong>, con 12 estudiantes: la herramienta «mejoró» las notas 3 puntos o más en el <strong>67 %</strong> de las pruebas, aunque no hacía nada.</li>
<li><strong>Con un grupo de comparación</strong> asignado al azar, y mirando la diferencia de ganancias, el azar produjo una «ventaja» de 3 puntos o más en el <strong>19 %</strong> de las pruebas con 12 estudiantes por grupo, el <strong>11 %</strong> con 25 por grupo y el <strong>3 %</strong> con 60 por grupo.</li>
<li>Y si la herramienta sí sumaba 5 puntos reales, la prueba lo detectó (diferencia observada de 3 o más) en el 72 % de los casos con 12 por grupo, el 80 % con 25 y el 90 % con 60.</li>
</ul>
{{img:azar}}
<p>Lo que muestra la simulación: con grupos pequeños, <strong>el azar y el crecimiento natural pueden parecer una mejora, y una mejora real puede pasar inadvertida</strong>. Un resultado no concluyente no es un fracaso: es información honesta sobre lo que tu prueba pudo detectar.</p>

<h2>La prueba de cuatro semanas, paso a paso</h2>
{{img:pasos}}
<ol>
<li><strong>Define antes de empezar.</strong> La herramienta, la hipótesis («los estudiantes que la usen mejorarán más que los que no, en…»), un <strong>resultado de aprendizaje concreto</strong> (no el uso ni la satisfacción) y el criterio de éxito. Anotarlo antes evita ajustar el criterio a los resultados.</li>
<li><strong>Forma dos grupos parecidos.</strong> Lo ideal es asignar al azar (por sorteo) entre estudiantes o grupos. Si no se puede, elige grupos comparables (mismo grado, nivel y docente) y dilo claramente: el resultado será menos firme.</li>
<li><strong>Mide al inicio.</strong> La misma prueba para ambos grupos, con criterios de corrección definidos de antemano. El <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> te ayuda a producir dos versiones equivalentes con sus soluciones.</li>
<li><strong>Aplica cuatro semanas.</strong> Un grupo usa la herramienta con una dosis definida (por ejemplo, tres sesiones de 20 minutos por semana) y el otro sigue con la práctica habitual. Anota lo que cambie para ambos.</li>
<li><strong>Mide al final</strong> con la misma prueba o una equivalente.</li>
<li><strong>Compara ganancias, no notas finales.</strong> Calcula la ganancia de cada estudiante (final − inicial), el promedio por grupo y la diferencia entre promedios. Mira también el tamaño del efecto y, si puedes, un valor p.</li>
<li><strong>Decide con cautela.</strong> Una diferencia pequeña con pocos estudiantes es «no concluyente»: amplía la muestra o repite antes de comprar.</li>
</ol>
<p>Una consideración ética: si la herramienta tiene posibilidades de ayudar, ofrécela al grupo de comparación al terminar las cuatro semanas (diseño de «lista de espera»). Así nadie queda sin la oportunidad. Y recuerda los datos: la herramienta debe cumplir las reglas de privacidad (ver la <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA</a> y los <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">datos de estudiantes</a>).</p>

<h2>La ficha en Excel: un ejemplo</h2>
<p>La ficha trae una hoja de diseño con diez preguntas por responder antes de empezar, una hoja de datos y una de resultados con las fórmulas listas. Con datos ficticios de 12 estudiantes por grupo (en los que simulé un efecto real de 4 puntos), el libro calcula una ganancia media de 7,4 puntos con la herramienta y de 4,7 sin ella: una diferencia de 2,8 puntos, un tamaño del efecto de 0,27 y un valor p de 0,51. La lectura sugerida es <strong>«diferencia positiva pero no concluyente»</strong>. Es decir: aunque el efecto era real, con 12 estudiantes por grupo la prueba no puede distinguirlo del azar. Esa es la enseñanza: <strong>con muestras pequeñas, hay que repetir y acumular evidencia</strong> (por ejemplo, entre varios cursos o varios colegios).</p>
<p>Un detalle sobre lectura de resultados: un valor p bajo no prueba que la herramienta cause la mejora si los grupos no eran comparables, y un valor p alto no prueba que la herramienta no sirva. Y el tamaño del efecto (alrededor de 0,2 pequeño, 0,5 mediano y 0,8 grande, según la convención de Cohen) dice cuánto, no solo si es distinto de cero.</p>

<h2>Qué más puede torcer la prueba</h2>
<ul>
<li><strong>Efecto novedad:</strong> todo lo nuevo entusiasma al principio; cuatro semanas pueden no mostrar el efecto sostenido.</li>
<li><strong>Efecto del docente:</strong> si un docente entusiasta aplica la herramienta y otro el método habitual, no sabes si funcionó la herramienta o el docente.</li>
<li><strong>Prueba que favorece la herramienta:</strong> medir con ejercicios idénticos a los de la plataforma mide la práctica, no el aprendizaje transferible.</li>
<li><strong>Estudiantes que abandonan:</strong> si se retiran los que van peor, el promedio sube sin mejora real.</li>
<li><strong>Medir lo fácil:</strong> el tiempo de uso o la satisfacción no son aprendizaje.</li>
</ul>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, la «evidencia primero» gana espacio, impulsada por marcos como ESSA en EE. UU. En Colombia y Latinoamérica, la mayoría de decisiones de compra tecnológica en colegios se toman con demostraciones del proveedor y poca evidencia independiente, y las pruebas locales casi no existen. Aquí, una prueba de cuatro semanas en un colegio es modesta, pero útil: produce evidencia propia, en tu contexto, con tus estudiantes. Para los <strong>directivos</strong>, es una forma de gastar con criterio (ver <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">la deuda tecnológica de los colegios</a> y <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">comprar, suscribir o desarrollar</a>); para los <strong>docentes</strong>, de ejercer su autonomía pedagógica con datos (ver <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">autonomía ante las plataformas</a>); para las <strong>familias</strong>, de saber que lo que se usa con sus hijos se probó, y para los <strong>estudiantes</strong>, de no ser cobayas sin saberlo (con transparencia y consentimiento).</p>

<h2>Herramientas para preparar la prueba</h2>
<p>Dos versiones equivalentes de una prueba, con claves y soluciones, son la base de la medición. El <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> las produce para que tú las revises, y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> ofrece recetas por materia para planear las sesiones. También hay una <a href="/examenes/demo/">demostración gratuita del generador</a>.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">¿la IA amplía o reemplaza el pensamiento del estudiante?</a> y <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden las calificaciones</a>. Si quieres analizar los resultados con más profundidad en Excel, mira <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">pronósticos en Excel</a> para aprender a probar un modelo antes de creerle.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuántos estudiantes necesito para una prueba válida?</h3>
<p>Cuantos más, mejor. Con 12 por grupo solo se detectan efectos grandes; en mi simulación, un efecto real de 5 puntos se detectó en el 72 % de las pruebas con 12 por grupo y en el 90 % con 60. Con pocos estudiantes, repite la prueba en varios cursos.</p>
<h3>¿Qué hago si no puedo asignar los grupos al azar?</h3>
<p>Elige grupos lo más parecidos posible (grado, nivel, docente), mide al inicio para comprobar que partían igual y reconoce que el resultado será menos firme.</p>
<h3>¿Cuánto debe durar la prueba?</h3>
<p>Cuatro semanas es un mínimo práctico para ver cambios; el efecto novedad puede inflar el resultado, así que una prueba más larga o una repetición dan más confianza.</p>
<h3>¿Es ético dejar un grupo sin la herramienta?</h3>
<p>Si hay dudas sobre el beneficio, es razonable. Para equidad, ofrece la herramienta al grupo de comparación al terminar (lista de espera) y obtén las autorizaciones necesarias.</p>
<h3>¿Me sirve la evidencia de otros países?</h3>
<p>Es un punto de partida, pero depende del contexto: currículo, idioma, recursos y docentes. Por eso conviene probar en tu aula.</p>

<p class="notice"><strong>Antes de comprar la próxima herramienta.</strong> Descarga la <a href="/descargas/prueba-herramienta-educativa/ficha-prueba-4-semanas-herramienta-educativa.xlsx">ficha de prueba de cuatro semanas</a>, responde las diez preguntas de diseño y pruébala con dos grupos. Y si quieres ver por qué el «antes y después» engaña, ejecuta la <a href="/descargas/prueba-herramienta-educativa/simulacion-prueba-herramienta.py">simulación</a>.</p>

<h2>Para pensar</h2>
<p>Exigir evidencia antes de adoptar una herramienta parece sensato, pero también puede frenar la innovación y sobrecargar a los docentes con trabajo de investigador. <strong>¿Quién debe producir la evidencia sobre el efecto de una herramienta educativa: los proveedores que la venden, las instituciones que la compran, los docentes en su aula o el Estado? Y mientras la evidencia llega, ¿es más responsable esperar o dejar que los estudiantes de hoy sean quienes la produzcan?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:azar}}' => $img('prueba-herramienta-educativa-azar', 392, 'Barras con el porcentaje de veces que el azar hace parecer que una herramienta inútil gana por 3 puntos o más: 19,1 % con 12 estudiantes por grupo, 11,1 % con 25 y 2,6 % con 60.', 'Con grupos pequeños, el azar produce diferencias que parecen mejoras.'),
    '{{img:pasos}}' => $img('prueba-herramienta-educativa-pasos', 467, 'Cinco pasos de la prueba de cuatro semanas: definir, medir al inicio, aplicar cuatro semanas, medir al final y comparar y decidir.', 'Los cinco pasos de la prueba.'),
]);

return [
    'slug' => 'prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje',
    'title' => 'Una prueba de cuatro semanas para saber si una herramienta educativa realmente mejora el aprendizaje',
    'excerpt' => 'Cómo evaluar en tu aula, con un grupo de comparación, si una herramienta educativa mejora el aprendizaje: por qué el «antes y después» engaña (simulación), cinco pasos, una ficha en Excel y cómo leer los resultados con cautela.',
    'seo_title' => '¿Funciona esta herramienta educativa? Prueba de 4 semanas',
    'seo_description' => 'Cómo probar en tu aula si una herramienta educativa mejora el aprendizaje: grupo de comparación, simulación, ficha en Excel y lectura cuidadosa de resultados.',
    'focus_keyword' => 'evaluar si una herramienta educativa funciona',
    'cover' => '/assets/img/articulos/prueba-herramienta-educativa/prueba-herramienta-educativa-portada',
    'cover_alt' => 'Portada «¿Funciona esta herramienta educativa? Una prueba de cuatro semanas para saberlo» con una tarjeta: el 67 % de las pruebas antes y después muestran mejora aunque la herramienta no haga nada, en una simulación de 12 estudiantes.',
    'published_at' => '2026-11-25 12:00:00',
    'content_html' => $html,
];
