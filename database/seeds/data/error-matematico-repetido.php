<?php

declare(strict_types=1);

// "El error matemático que se repite". Fuentes verificadas el 10 de octubre de 2026: literatura sobre sesgo del número natural (Ni y Zhou, 2005), ítem 12/13 + 7/8 (Carpenter et al. y revisión de Siegler y colegas; las fuentes difieren en detalles), PISA 2022 Colombia 383. Matriz y diagnóstico de grupo verificados en Excel contra un cálculo independiente en Python (datos ficticios).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/error-matematico-repetido/' . $name;
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
<p>Es el tercer examen en que Valentina suma <code>1/2 + 1/3</code> y obtiene <code>2/5</code>. La docente lo explicó el mes pasado y lo volvió a explicar esta semana, de la misma manera, un poco más despacio. Valentina asiente. Y en el siguiente examen, <code>2/5</code> otra vez. Cuando un error se repite, casi siempre hay una causa más profunda que una distracción: <strong>el estudiante está aplicando una regla, solo que es la regla equivocada</strong>. Mientras no se descubra cuál es, explicar más fuerte no sirve.</p>
<p>Este artículo propone cómo pasar de "se equivocó" a "¿qué está pensando?", con una <strong>matriz de errores frecuentes</strong> (con su lógica y una intervención), doce preguntas diagnósticas en las que cada respuesta incorrecta delata un error posible y una hoja que revisa un grupo y detecta quién repite el mismo error. Está todo en un <a href="/descargas/errores-matematicos/matriz-errores-matematicos-diagnostico.xlsx">libro descargable en Excel</a>, probado contra un cálculo independiente. Datos verificados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Los errores matemáticos repetidos suelen ser <strong>concepciones erróneas con lógica propia</strong>, no descuidos: tratar una fracción como dos números sueltos, comparar decimales como enteros, creer que multiplicar siempre agranda. Se detectan con preguntas diseñadas para que cada distractor delate un error, se confirman preguntándole al estudiante cómo pensó y se corrigen con una intervención que ataque la regla equivocada, no solo la respuesta. Los errores de la matriz son <strong>hipótesis para explorar</strong>, no diagnósticos ni etiquetas sobre el estudiante.</p>

<h2>Lo que dice la investigación</h2>
<p>Hay décadas de investigación sobre los errores sistemáticos en matemáticas. Un ejemplo clásico es el <strong>sesgo del número natural</strong> (<em>whole number bias</em>, término popularizado por Ni y Zhou, 2005): los estudiantes aplican a las fracciones y los decimales las reglas que funcionan con los números enteros. Una de sus manifestaciones más conocidas es la <strong>suma por componentes</strong> (sumar numeradores con numeradores y denominadores con denominadores), que algunas revisiones describen como el error más frecuente en la suma de fracciones.</p>
<p>La evidencia es persistente. En una evaluación nacional de EE. UU. de principios de los años ochenta (Carpenter y colegas), se pidió a estudiantes de 13 años que estimaran, sin calcular, la suma <code>12/13 + 7/8</code>: la mayoría eligió 19 o 21 (la suma de los numeradores o de los denominadores) y solo el 24 % eligió la respuesta correcta, cerca de 2. Según una revisión de Siegler y colegas, un ítem equivalente aplicado más de treinta años después dio resultados parecidos (27 % de aciertos). Las fuentes difieren en detalles de muestra y año, así que lo tomo como un indicio: <strong>el error es antiguo, es común y no desaparece solo con el tiempo.</strong></p>
<p>En Colombia, el contexto invita a mirar con cuidado los vacíos de base: en PISA 2022, Colombia obtuvo 383 puntos en matemáticas (ver <a href="/mejores-sistemas-educativos-del-mundo-colombia/">los mejores sistemas educativos del mundo frente a Colombia</a>). Un puntaje es un promedio nacional, pero un error de base que se arrastra de grado en grado es una de las explicaciones que un docente puede ayudar a cerrar en el aula.</p>

<h2>Errores con lógica propia</h2>
{{img:logica}}
<p>La clave del enfoque es suponer que el estudiante <strong>es coherente</strong> con una regla, aunque sea la equivocada. Valentina no suma al azar: suma numeradores y denominadores porque, con los números enteros, sumar "lo de arriba con lo de arriba y lo de abajo con lo de abajo" sería natural. Corregir su error sin cambiar esa regla es como arreglar una hoja de cálculo mal armada borrando el resultado: reaparece.</p>

<h2>La matriz de errores</h2>
<p>La hoja "Matriz_de_errores" reúne nueve errores frecuentes. Cada uno tiene su código, un ejemplo, <strong>la hipótesis de lo que el estudiante podría estar pensando</strong>, una pregunta para explorarla y una intervención. Un resumen:</p>
<table>
<thead><tr><th>Código</th><th>Error</th><th>Hipótesis</th><th>Cómo explorarlo</th></tr></thead>
<tbody>
<tr><td>E1</td><td>1/2 + 1/3 = 2/5</td><td>Trata la fracción como dos números separados</td><td>Ubicar 1/2 y 1/3 en una recta y estimar la suma</td></tr>
<tr><td>E2</td><td>0,25 &gt; 0,3</td><td>Compara las cifras como enteros (25 &gt; 3)</td><td>Ubicarlos en una recta de 0 a 1; pasarlos a centésimas</td></tr>
<tr><td>E3</td><td>8 × 0,5 = 40</td><td>Multiplicar siempre agranda</td><td>¿El resultado debería ser mayor o menor que 8?</td></tr>
<tr><td>E4</td><td>8 + 4 = 12 + 5 → 17</td><td>El igual significa "escribe el resultado"</td><td>Completar 8 + 4 = □ + 5 y explicar el igual</td></tr>
<tr><td>E5</td><td>x + 3 = 7 → x = 10</td><td>Repite "pasa al otro lado" sin la operación inversa</td><td>Verificar reemplazando x</td></tr>
<tr><td>E6</td><td>-(x - 2) = -x - 2</td><td>Aplica el signo solo al primer término</td><td>Reemplazar x por un número y comparar</td></tr>
<tr><td>E7</td><td>(a + b)² = a² + b²</td><td>El exponente se distribuye sobre la suma</td><td>Probar con a = 2, b = 3</td></tr>
<tr><td>E8</td><td>(a + b)/a = b</td><td>Cancela una letra que no es factor común</td><td>Probar con (2 + 3)/2</td></tr>
<tr><td>E10</td><td>Sube 20 % y baja 20 %: queda igual</td><td>Ignora que cada porcentaje parte de una base distinta</td><td>Calcular con un precio de 100</td></tr>
</tbody>
</table>
<p>Un detalle valioso: casi todas las formas de explorar un error son <strong>verificaciones numéricas</strong> que el estudiante puede hacer solo. Si prueba <code>(2 + 3)²</code> y compara con <code>2² + 3²</code>, descubre por sí mismo que 25 no es 13; esa es una enseñanza más duradera que una corrección del docente.</p>

<h2>Doce preguntas que delatan el error</h2>
<p>La hoja "Ejercicios_y_claves" trae doce preguntas de opción única donde cada distractor está ligado a un error. Por ejemplo, en <em>"1/2 + 1/3 ="</em> las opciones son <code>5/6</code> (correcta), <code>2/5</code> (error E1) y <code>1/6</code> (otro error); en <em>"Es mayor: 0,25 o 0,3"</em>, elegir <code>0,25</code> señala E2; en <em>"8 + 4 = □ + 5"</em>, tanto 12 como 17 señalan E4. Una decisión de diseño importante: <strong>los errores E1, E5 y E6 aparecen en dos preguntas distintas</strong> (por ejemplo, <code>1/2 + 1/3</code> y <code>1/4 + 2/3</code>), porque un error cometido una sola vez puede ser un descuido y uno cometido en dos preguntas distintas es una pista fuerte de una regla equivocada.</p>
<p>Un cuidado: con opción única, un estudiante puede acertar por azar o por eliminación. Estas preguntas sirven para <em>señalar hipótesis</em> que luego se confirman con una conversación ("cuéntame cómo lo pensaste"), no para sentenciar. El Generador de exámenes con IA puede ayudarte a producir más preguntas de este tipo para otros temas (ver más abajo), siempre que las revises.</p>

<h2>El diagnóstico de un grupo (datos ficticios)</h2>
{{img:diagnostico}}
<p>La hoja "Diagnostico_de_grupo" recibe las letras que marcó cada estudiante, las convierte en códigos de error con la clave y calcula el resumen. Probé el libro con 12 estudiantes ficticios, cuyos resultados verifiqué contra un cálculo independiente en Python (coinciden):</p>
<ul>
<li><strong>El error más frecuente fue E1</strong> (suma de numeradores y denominadores): 5 de los 12 estudiantes (42 %) lo cometieron al menos una vez, 8 veces en total.</li>
<li><strong>5 de 12 estudiantes repiten el mismo error</strong> en más de una pregunta, y la hoja dice cuál: tres de ellos repiten E1, uno repite E5 y uno E6.</li>
<li>Los demás errores aparecen en uno a tres estudiantes cada uno.</li>
</ul>
<p>La decisión pedagógica se vuelve concreta: en lugar de repasar "fracciones" a todo el grupo, se trabaja <strong>la regla de la suma por componentes</strong> con los cinco estudiantes que la tienen, con la recta numérica y la estimación previa, y el resto sigue avanzando. Y la hoja marca a los cinco que <em>repiten</em> un error, que son los que más necesitan una conversación individual.</p>

<h2>Del diagnóstico a la intervención</h2>
<ol>
<li><strong>Confirma la hipótesis con el estudiante.</strong> Pídele que resuelva en voz alta o que explique un caso: "¿por qué sumas los de abajo?". Su explicación vale más que la respuesta escrita.</li>
<li><strong>Genera un conflicto cognitivo.</strong> Una pregunta que su regla no pueda resolver: "<code>1/2 + 1/2</code> da <code>2/4</code> con tu método; ¿cuánto es medio más medio?".</li>
<li><strong>Construye la regla correcta con apoyos concretos:</strong> modelos de áreas, rectas numéricas, billetes y monedas, balanzas.</li>
<li><strong>Estima antes de calcular</strong> y <strong>verifica después</strong> (reemplazando, con un caso numérico, con una calculadora): son hábitos que atacan varios errores a la vez.</li>
<li><strong>Vuelve a medir</strong> con preguntas distintas a las de la primera vez, unas semanas después. Si el error reaparece, la regla no cambió. (Para saber si una estrategia funciona, ver la <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">prueba de cuatro semanas</a>.)</li>
</ol>

<h2>Lo que no se debe hacer</h2>
<ul>
<li><strong>Etiquetar al estudiante</strong> ("es malo en fracciones"): la matriz habla de reglas, no de personas.</li>
<li><strong>Corregir solo la respuesta,</strong> sin tocar la regla.</li>
<li><strong>Dar el algoritmo correcto sin sentido:</strong> "busca el común denominador" sin entender por qué, se olvida o se mezcla.</li>
<li><strong>Diagnosticar con una sola pregunta:</strong> un error aislado puede ser un descuido.</li>
<li><strong>Exponer los resultados por nombre</strong> delante del grupo: los datos de desempeño son personales.</li>
</ul>
<p>Y una nota: si un estudiante tiene dificultades persistentes y amplias en matemáticas aunque se trabajen sus errores, vale la pena conversar con orientación escolar; podría necesitar ajustes razonables (ver <a href="/herramientas/piar/">PIAR con IA</a>). Esa decisión es del equipo, no de una matriz.</p>

<h2>La retroalimentación que acompaña</h2>
<p>El diagnóstico alimenta la retroalimentación: un comentario como "revisa la suma de fracciones" es vago; uno como "sumaste los numeradores y los denominadores por separado; ubica 1/2 y 1/3 en la recta y estima cuánto debería dar antes de calcular" nombra el proceso y propone un siguiente paso (ver <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">la retroalimentación que sí cambia el aprendizaje</a>). Y se conecta con la idea de evaluar el proceso de pensamiento y no solo el resultado, que también aplica en programación (ver <a href="/ensenar-programacion-era-ia-que-sigue-importando-rubrica-depuracion/">enseñar a depurar código en la era de la IA</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En el mundo, el análisis de errores es una práctica reconocida de la didáctica de las matemáticas. En Colombia y Latinoamérica, con grupos numerosos y poco tiempo, el desafío es hacerlo sin que se vuelva una carga: por eso las preguntas de opción única con distractores diseñados y una hoja que cuenta por el docente son una forma eficiente de empezar. Para los <strong>docentes</strong>, es una manera de dirigir mejor el tiempo de refuerzo; para los <strong>directivos</strong>, de analizar patrones por grado y articular el currículo (el error de fracciones de sexto suele venir de quinto); para las <strong>familias</strong>, de entender que un error repetido tiene una causa y una solución; y para los <strong>estudiantes</strong>, de ver el error como información y no como un fracaso. Ver también <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden las calificaciones</a>.</p>

<h2>Herramientas para el docente</h2>
<p>Para producir más preguntas diagnósticas con distractores pensados, versiones equivalentes y soluciones, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> genera el material que tú revisas antes de usarlo, y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia, incluidas actividades de refuerzo. Hay una <a href="/examenes/demo/">demostración gratuita del generador</a>.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">¿la IA amplía o reemplaza el pensamiento del estudiante?</a> y <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA para colegios</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Por qué un estudiante repite el mismo error matemático?</h3>
<p>Casi siempre porque aplica una regla equivocada de forma coherente (por ejemplo, tratar una fracción como dos números sueltos). Mientras la regla no cambie, el error reaparece aunque se le corrija la respuesta.</p>
<h3>¿Cómo sé si es un error de concepto o un descuido?</h3>
<p>Si el error aparece en dos o más preguntas distintas con la misma lógica, es una pista fuerte de concepto. Confírmalo pidiéndole que explique cómo lo pensó.</p>
<h3>¿Qué es el sesgo del número natural?</h3>
<p>Es la tendencia a aplicar a fracciones y decimales las reglas de los números enteros, por ejemplo, sumar numeradores con numeradores y denominadores con denominadores.</p>
<h3>¿Sirven las preguntas de opción única para diagnosticar?</h3>
<p>Sirven para señalar hipótesis, si cada distractor está diseñado para delatar un error. No bastan para sentenciar: se confirman con una conversación.</p>
<h3>¿Debo mostrar a cada estudiante su error?</h3>
<p>Sí, en privado y como información sobre la regla que usó, no sobre la persona, y con una oportunidad de volver a intentarlo.</p>

<p class="notice"><strong>Esta semana:</strong> descarga la <a href="/descargas/errores-matematicos/matriz-errores-matematicos-diagnostico.xlsx">matriz de errores y diagnóstico</a>, aplica las doce preguntas a un grupo (o adáptalas a tu tema) y pega las respuestas en la hoja. Elige el error más frecuente y trabájalo con los estudiantes que lo repiten.</p>

<h2>Para pensar</h2>
<p>Si la mayoría de los errores repetidos son reglas mal generalizadas, entonces buena parte de lo que llamamos "no entendió" es un malentendido sobre lo que la regla significa. <strong>¿Cuántos de los errores que corregimos con una nota roja son en realidad una buena idea aplicada donde no corresponde? Y si descubrir la lógica del error exige tiempo y conversación individual, ¿cómo se hace con cuarenta estudiantes por grupo y cinco grupos por docente?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:logica}}' => $img('error-matematico-repetido-logica', 573, 'Cuatro tarjetas con errores y su lógica: 1/2 + 1/3 = 2/5 por sumar numeradores y denominadores, 0,25 mayor que 0,3 por comparar como enteros, 8 por 0,5 igual a 40 por creer que multiplicar siempre agranda y el cuadrado de una suma mal distribuido.', 'Detrás de cada error suele haber una regla mal generalizada.'),
    '{{img:diagnostico}}' => $img('error-matematico-repetido-diagnostico', 656, 'Barras con cuántos de 12 estudiantes ficticios cometieron cada error al menos una vez: el error de las fracciones E1 lo cometieron 5, y los demás entre 1 y 3.', 'Cuántos estudiantes cometieron cada error al menos una vez.'),
]);

return [
    'slug' => 'error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo',
    'title' => 'El error matemático que se repite: cómo descubrir qué piensa el estudiante, con una matriz de errores y un diagnóstico de grupo',
    'excerpt' => 'Por qué un estudiante repite el mismo error en matemáticas, una matriz de nueve errores frecuentes con su lógica e intervención, doce preguntas diagnósticas y una hoja que detecta quién repite el mismo error en un grupo.',
    'seo_title' => 'Error matemático repetido: matriz y diagnóstico',
    'seo_description' => 'Cómo descubrir por qué un estudiante repite un error matemático: matriz de errores frecuentes, preguntas diagnósticas e intervenciones, con libro descargable.',
    'focus_keyword' => 'error matemático repetido',
    'cover' => '/assets/img/articulos/error-matematico-repetido/error-matematico-repetido-portada',
    'cover_alt' => 'Portada "El error matemático que se repite: cómo descubrir qué piensa el estudiante" con una tarjeta: 1/2 + 1/3 = 2/5, el error más frecuente del grupo de ejemplo; 5 de 12 estudiantes lo cometieron y 5 de 12 repiten el mismo error.',
    'published_at' => '2026-12-22 12:00:00',
    'content_html' => $html,
];
