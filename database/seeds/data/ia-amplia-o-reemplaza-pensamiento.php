<?php

declare(strict_types=1);

// «¿La IA amplía el pensamiento del estudiante o lo reemplaza?»: dependencia cognitiva, evidencia (Bastani et al. PNAS 2025, Lee et al.
// CHI 2025, OCDE Digital Education Outlook 2026, TALIS 2024) y una rúbrica de autonomía, razonamiento y justificación. Datos verificados
// el 9 de octubre de 2026. Nowdoc: las figuras se insertan con marcadores {{img:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-amplia-o-reemplaza-pensamiento/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Una estudiante entrega una tarea impecable. Cuando le pides que explique el segundo paso, se queda en silencio. No es una mala estudiante: usó la inteligencia artificial como un atajo y el atajo funcionó, para la tarea. La pregunta que importa en el aula ya no es «¿usa IA?» sino <strong>«¿qué queda en su cabeza después de usarla?»</strong>.</p>
<p>En este artículo reviso la evidencia sobre dependencia cognitiva, propongo un criterio simple para distinguir el apoyo que amplía el pensamiento de la automatización que lo evita, y te dejo una <strong>rúbrica</strong> de autonomía, razonamiento y justificación para usar en tu clase o en casa. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> La IA casi siempre mejora el producto; lo que está en duda es si mejora el aprendizaje. En un experimento con cerca de mil estudiantes, quienes practicaron con un chat sin guías sacaron mejor nota en la práctica y 17 % menos en el examen sin IA; con un tutor que daba pistas en vez de respuestas, ese daño desapareció. La diferencia no la hace la herramienta, sino el diseño de la tarea.</p>

<h2>Qué dice la evidencia sobre IA y pensamiento</h2>
<p>El estudio más sólido hasta ahora es un experimento de campo con casi mil estudiantes de secundaria en matemáticas, publicado en <a href="https://www.pnas.org/doi/10.1073/pnas.2422633122"><em>PNAS</em> en 2025 (Bastani y colaboradores)</a>. Los estudiantes practicaron con tres condiciones: sin IA, con un chat tipo ChatGPT (GPT Base) y con un tutor diseñado para dar pistas (GPT Tutor). Durante la práctica, la IA subió el desempeño un 48 % con el chat y un 127 % con el tutor. Pero cuando se quitó el acceso y presentaron un examen sin IA, <strong>el grupo del chat sacó un 17 % menos que quienes nunca la usaron</strong>, mientras que el del tutor quedó sin diferencia negativa (aunque tampoco hubo un efecto positivo). Los autores lo describen como una «muleta»: los estudiantes dejaron de hacer el esfuerzo que construye el aprendizaje. Son resultados de corto plazo, en un solo país y una sola materia, pero marcan una dirección.</p>
{{img:evidencia}}
<p>Otras piezas apuntan en el mismo sentido, con más cautela:</p>
<ul>
<li><strong>Trabajadores del conocimiento.</strong> Una <a href="https://advait.org/files/lee_2025_ai_critical_thinking_survey.pdf">encuesta de Carnegie Mellon y Microsoft (CHI 2025)</a> a 319 personas encontró que a mayor confianza en la IA, menos pensamiento crítico declarado, y a mayor confianza en las propias capacidades, más. Es una correlación basada en autorreportes, no una prueba de causa.</li>
<li><strong>OCDE.</strong> El <a href="https://www.oecd.org/en/publications/oecd-digital-education-outlook-2026_062a7394-en.html">Digital Education Outlook 2026</a> concluye que la IA generativa puede apoyar el aprendizaje cuando se usa con principios pedagógicos claros, pero que delegar la tarea mejora el desempeño sin mejorar el aprendizaje, y que la ventaja tiende a desaparecer o revertirse cuando se quita la herramienta.</li>
<li><strong>Escritura.</strong> Un <a href="https://arxiv.org/abs/2506.08872">estudio preliminar del MIT Media Lab</a> con 54 participantes midió la actividad cerebral al escribir con ChatGPT, con buscador o sin ayudas, y reportó menor conectividad con la IA. Es un preprint pequeño y sin revisión por pares: úsalo como hipótesis, no como veredicto.</li>
</ul>
<p>La lectura honesta es esta: <strong>no hay evidencia de que la IA «apague el cerebro» por sí sola, pero sí de que, usada sin diseño, convierte el esfuerzo en producto y el producto en una ilusión de aprendizaje</strong>.</p>

<h2>Andamio o muleta: el criterio para distinguirlos</h2>
<p>Un andamio sostiene mientras construyes y se retira cuando el edificio se sostiene solo. Una muleta te lleva, pero si la quitas no caminas. La misma herramienta puede ser lo uno o lo otro según cómo se use. Estos son los indicadores prácticos:</p>
{{img:criterio}}
<p>Y esta es la <strong>prueba de tres preguntas</strong> que puede hacerse un estudiante, o un padre al revisar una tarea, sin necesidad de detectar si hubo IA:</p>
<ol>
<li><strong>¿Puedo explicarlo con mis palabras?</strong> Si solo puedo repetir lo que dice el texto, no lo entendí.</li>
<li><strong>¿Podría resolver uno parecido sin la IA?</strong> Es la prueba de transferencia, la que de verdad mide el aprendizaje.</li>
<li><strong>¿Sé dónde puede estar equivocada?</strong> Quien puede cuestionar la respuesta está pensando con la herramienta, no detrás de ella.</li>
</ol>

<h2>La rúbrica: autonomía, razonamiento y justificación</h2>
<p>Este es el recurso aplicable. Úsalo después de una tarea en la que se permitió IA, junto con una breve <strong>prueba de transferencia</strong>: 5 a 10 minutos con un problema similar, sin IA y sin apuntes, o una explicación oral. La nota no castiga haber usado IA; mide cuánto quedó en el estudiante.</p>
<table>
<thead><tr><th>Criterio</th><th>1 · Depende</th><th>2 · Acompañado</th><th>3 · Autónomo</th><th>4 · Amplía</th></tr></thead>
<tbody>
<tr><td><strong>Autonomía</strong>: resuelve sin la IA</td><td>No puede avanzar sin ella</td><td>Avanza con ayuda constante</td><td>Resuelve un problema similar sin IA</td><td>Resuelve y propone variantes más difíciles</td></tr>
<tr><td><strong>Razonamiento</strong>: reconstruye el procedimiento</td><td>Repite el resultado</td><td>Describe los pasos sin saber por qué</td><td>Explica por qué funciona cada paso</td><td>Compara métodos y elige con criterio</td></tr>
<tr><td><strong>Justificación</strong>: defiende su respuesta</td><td>«Eso dijo la IA»</td><td>Cita una fuente sin revisarla</td><td>Sustenta con evidencia y la contrasta</td><td>Anticipa objeciones y las responde</td></tr>
<tr><td><strong>Uso crítico de la IA</strong>: verifica y corrige</td><td>Acepta todo sin leer</td><td>Corrige errores evidentes</td><td>Detecta fallos y verifica en fuentes</td><td>Documenta qué pidió, qué corrigió y qué aprendió</td></tr>
</tbody>
</table>
<p><strong>Cómo usarla en 10 minutos.</strong> (1) Entrega la tarea con la regla de uso de IA explícita («puedes consultarla, debes declarar cómo»). (2) Pide una prueba de transferencia corta o una explicación oral de dos minutos. (3) Califica con la rúbrica y comparte el resultado como retroalimentación, no como castigo. (4) Si la brecha entre la tarea y la prueba de transferencia es grande, el problema es de diseño: cambia la tarea, no solo la nota.</p>

<h2>Colombia, Latinoamérica y el mundo: qué cambia según el contexto</h2>
<p>El debate tiene matices según dónde se mire. <strong>En el mundo</strong>, la OCDE y la UNESCO coinciden en que hay que enseñar a usar la IA con criterio y rediseñar la evaluación; los resultados de PISA 2025 sobre aprendizaje en el mundo digital llegarán en 2027. <strong>En Colombia</strong>, el uso ya es masivo: según la OCDE (TALIS 2024), alrededor del 53 % de los docentes colombianos usó IA en el último año, frente al 36 % del promedio OCDE; y una encuesta de GAD3 de 2024 encontró que el 84 % de los universitarios usa IA generativa con frecuencia, aunque solo el 35 % supera el nivel básico. El Ministerio de Educación presentó en agosto de 2026 un <a href="https://www.mineducacion.gov.co/1780/w3-article-429623.html">Decálogo de IA para la Educación Superior</a>, que insiste en conservar la interacción humana y adaptar los modelos pedagógicos; para el colegio, la Ley 2626 de 2026 sobre educación digital, según los textos publicados, incorpora IA y ciencia de datos en el área de Tecnología e Informática, aunque aún no conozco un lineamiento específico para el uso de IA por estudiantes de básica y media. <strong>En Latinoamérica</strong> se suma una brecha de acceso: no todos tienen conectividad ni un dispositivo, y la IA puede ampliar la desigualdad si solo unos pocos aprenden a usarla bien.</p>
<p>Y hay un matiz de equidad que no conviene olvidar: para estudiantes con discapacidad, la IA puede ser un apoyo legítimo y necesario (lectura en voz alta, simplificación de textos, estructura de apuntes). Aquí el criterio no es «cuánta IA» sino «qué barrera quita y qué aprendizaje conserva», y es lo que debe quedar escrito en el PIAR, no una prohibición general.</p>

<h2>Tres miradas: docentes, familias y estudiantes</h2>
<ul>
<li><strong>Docentes:</strong> piden tiempo y herramientas; el 72 % de los profesores de la OCDE teme que los estudiantes presenten como propio un trabajo hecho por IA. La salida no es perseguir copias, sino diseñar tareas con proceso visible y pruebas de transferencia.</li>
<li><strong>Familias:</strong> quieren saber si pueden dejar que sus hijos la usen. Una regla sencilla: sí para explicar, practicar y revisar; no para entregar la respuesta. Y pregúntales siempre: «explícame cómo lo resolviste».</li>
<li><strong>Estudiantes:</strong> la usan porque funciona y porque todos la usan. Necesitan reglas claras y razones, no sermones: la prueba de tres preguntas les sirve a ellos, no solo a sus profesores.</li>
</ul>

<h2>Herramientas para aplicarlo en tu aula</h2>
<p>Si quieres medir transferencia sin gastar tus noches, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> crea en minutos versiones distintas de un mismo problema, con LaTeX para matemáticas y sus soluciones, justo lo que necesitas para la prueba de transferencia (puedes probar la <a href="/examenes/demo/">demostración gratis</a>). Para diseñar actividades con el modo «andamio» (pistas, no respuestas), el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia. Y para estudiantes que necesitan apoyos razonables, <a href="/herramientas/piar/">PIAR con IA</a> te ayuda a redactar el plan sin perder el criterio pedagógico.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Si quieres seguir leyendo: <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">«La gran mentira de la IA»</a>, <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">«El espejismo de la IA en la universidad»</a> y <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">«La IA no te reemplazará, pero quien la domine sí»</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Usar IA para estudiar es hacer trampa?</h3>
<p>No necesariamente. Es trampa si la regla del curso lo prohíbe o si se entrega como propio algo que no se entiende. Usada para pedir explicaciones, ejemplos y práctica, y verificando lo que responde, es una forma de estudiar.</p>
<h3>¿Cómo sé si mi hijo entendió o solo copió?</h3>
<p>Pídele que te explique el procedimiento con sus palabras y que resuelva uno parecido sin pantalla. Si no puede, la tarea salió bien pero el aprendizaje no.</p>
<h3>¿Se puede detectar si un texto lo escribió una IA?</h3>
<p>Los detectores son poco fiables y pueden penalizar injustamente a quienes escriben en un segundo idioma. Es más útil rediseñar la tarea (proceso visible, defensa oral, prueba de transferencia) que intentar detectar.</p>
<h3>¿La IA hace que los estudiantes piensen menos?</h3>
<p>Depende del uso. La evidencia muestra que sin guías puede reemplazar el esfuerzo y dañar el examen sin IA, pero un tutor que da pistas neutralizó ese efecto. Casi todos los estudios son de corto plazo y falta evidencia de largo plazo.</p>
<h3>¿Debemos prohibir la IA en el colegio?</h3>
<p>La prohibición total es difícil de sostener y deja a los estudiantes sin aprender a usarla con criterio. Mejor: reglas claras por tipo de tarea, momentos «sin IA» para medir lo aprendido y alfabetización para usarla bien.</p>

<p class="notice"><strong>Llévalo al aula esta semana.</strong> Usa la rúbrica en tu próxima tarea, mide transferencia con el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y planifica actividades de tipo andamio con el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>. Y comparte este artículo con las familias de tus estudiantes: la conversación es más fácil cuando todos usan el mismo criterio.</p>

<h2>Para pensar</h2>
<p>Si un estudiante puede obtener en segundos una respuesta que antes tomaba una hora de esfuerzo, <strong>¿qué parte de ese esfuerzo era realmente aprendizaje y qué parte era solo costumbre escolar?</strong> Y si la escuela decide que lo importante es lo que el estudiante sabe hacer sin la herramienta, ¿estamos dispuestos a medir también lo que la herramienta le permite lograr con ella?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:evidencia}}' => $img('ia-amplia-o-reemplaza-pensamiento-evidencia', 627, 'Gráfico del experimento de Bastani y colaboradores: con IA la práctica sube 48 % con un chat sin guías y 127 % con un tutor con pistas, pero en el examen sin IA el chat baja 17 % y el tutor queda sin efecto positivo; junto a tres tarjetas con otros estudios.', 'Evidencia sobre IA, práctica y examen. Fuentes: Bastani et al. (PNAS, 2025), Lee et al. (CHI 2025), OCDE (2026) y MIT Media Lab (preprint).'),
    '{{img:criterio}}' => $img('ia-amplia-o-reemplaza-pensamiento-criterio', 573, 'Dos columnas comparan el uso de la IA como andamio (da pistas, explica tu error, propone posturas, ofrece práctica) y como muleta (entrega la solución, se copia sin leer, evita el esfuerzo, no sabrías repetirlo), con la prueba de tres preguntas.', 'Andamio o muleta, con la prueba de tres preguntas.'),
]);

return [
    'slug' => 'ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica',
    'title' => '¿La inteligencia artificial está ampliando el pensamiento del estudiante o lo está reemplazando?',
    'excerpt' => 'Qué dice la evidencia sobre dependencia cognitiva, cómo distinguir el apoyo que amplía el aprendizaje de la automatización que evita pensar y una rúbrica de autonomía, razonamiento y justificación.',
    'seo_title' => 'IA y pensamiento del estudiante: ¿amplía o reemplaza?',
    'seo_description' => 'Evidencia sobre IA y dependencia cognitiva, criterio andamio o muleta y una rúbrica de autonomía y razonamiento para docentes y familias en Colombia.',
    'focus_keyword' => 'IA y pensamiento del estudiante',
    'cover' => '/assets/img/articulos/ia-amplia-o-reemplaza-pensamiento/ia-amplia-o-reemplaza-pensamiento-portada',
    'cover_alt' => 'Portada con el título «¿La IA amplía el pensamiento del estudiante o lo reemplaza?» y dos tarjetas: andamio, que ayuda a llegar más lejos, y muleta, que piensa por ti.',
    'published_at' => '2026-10-14 12:00:00',
    'content_html' => $html,
];
