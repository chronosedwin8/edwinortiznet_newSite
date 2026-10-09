<?php

declare(strict_types=1);

// «¿Las calificaciones miden lo que aprende un estudiante o su capacidad para cumplir con las reglas?» Evidencia: Brookhart et al. (2016),
// Allensworth y Clark (2020); normas: Decreto 1075 de 2015 (compila el 1290 de 2009) y Decreto 67 de 2018 de Chile. Verificado el 9 de octubre
// de 2026. El caso de Valentina y Mateo es hipotético; los promedios se calcularon: 0,3·5,0+0,2·5,0+0,2·4,5+0,3·2,9 = 4,27 y
// 0,3·3,5+0,2·4,0+0,2·4,3+0,3·5,0 = 4,21.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/calificaciones-aprendizaje-cumplimiento/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Imagina el boletín de dos estudiantes de noveno. Ambos tienen 4,2 en matemáticas, un desempeño «Alto». Sin embargo, si les pides que resuelvan un problema nuevo sin ayuda, uno lo hace y explica por qué, y la otra no sabe por dónde empezar. <strong>¿Qué midió exactamente esa nota?</strong> Es una pregunta incómoda, porque la mayoría de nosotros, docentes, estudiantes y familias, hemos tratado la nota como si fuera una medida exacta del aprendizaje.</p>
<p>En este artículo analizo ese caso hipotético, reviso qué dice la investigación y la normativa en Colombia, Latinoamérica y el mundo, y te dejo una <strong>matriz para revisar los criterios de evaluación</strong> de tu aula o tu colegio. Datos y normas verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> Una revisión de un siglo de estudios concluye que las notas mezclan factores cognitivos y no cognitivos: lo que el estudiante aprendió y lo que el docente valora en su trabajo (puntualidad, orden, actitud). No es malo que existan ambos, pero si se funden en un solo número, el boletín ya no dice cuál es cuál. La salida no es eliminar las notas, sino separar logro y cumplimiento y revisar los criterios.</p>

<h2>Un caso hipotético: dos estudiantes, la misma nota</h2>
<p>Supón un colegio con este sistema de evaluación, bastante común: tareas y cuaderno 30 %, actitud y puntualidad 20 %, trabajos en clase 20 % y evaluación escrita o sustentación 30 %. Dos estudiantes terminan el periodo así:</p>
{{img:caso}}
<table>
<thead><tr><th>Componente (peso)</th><th>Valentina</th><th>Mateo</th></tr></thead>
<tbody>
<tr><td>Tareas y cuaderno (30 %)</td><td>5,0</td><td>3,5</td></tr>
<tr><td>Actitud y puntualidad (20 %)</td><td>5,0</td><td>4,0</td></tr>
<tr><td>Trabajos en clase (20 %)</td><td>4,5</td><td>4,3</td></tr>
<tr><td>Evaluación (30 %)</td><td>2,9</td><td>5,0</td></tr>
<tr><td><strong>Nota final</strong></td><td><strong>4,27</strong></td><td><strong>4,21</strong></td></tr>
</tbody>
</table>
<p>Valentina cumple con todo: entrega a tiempo, mantiene el cuaderno impecable y participa. Pero en la evaluación, que es la única evidencia de lo que sabe sin apoyo, saca 2,9, un desempeño bajo. Mateo entrega tarde, su cuaderno es un desorden y a veces pierde puntos por actitud, pero en la evaluación saca 5,0 y explica su razonamiento. En el boletín, los dos son «Alto» y Valentina tiene incluso una décima más. Si solo contamos la evidencia de aprendizaje (trabajos y evaluación, reponderados a 100 %), la «nota de logro» sería 3,54 para Valentina y 4,72 para Mateo.</p>
<p>No se trata de decir que Valentina «hizo trampa» ni que Mateo es mejor persona. Se trata de ver que <strong>una sola nota está contando dos historias distintas</strong>, y que cuando se mezclan, quien lee el boletín (un padre, un rector, otra institución) no puede saber cuál es cuál. Y hay una decisión pedagógica de fondo: ¿cuánto de la nota debería premiar el cumplimiento de reglas?</p>

<h2>Qué dice la investigación</h2>
<p>La revisión más amplia que conozco es la de <a href="https://doi.org/10.3102/0034654316672069">Brookhart y colaboradores (2016), «A Century of Grading Research»</a>, en <em>Review of Educational Research</em>. Tras analizar más de cien años de estudios, concluyen que las notas son una medida «multidimensional»: miden, en parte, lo que el estudiante logró en pruebas, pero también reflejan factores no cognitivos que el docente valora (esfuerzo, conducta, participación). Es decir, el fenómeno del caso de Valentina y Mateo no es una rareza: es la regla.</p>
<p>Ahora, ese resultado tiene un matiz que no conviene olvidar: los factores «no cognitivos» no son basura. Un <a href="https://consortium.uchicago.edu/news-item/high-school-GPAs-and-ACT-scores-as-predictors-of-college-completion">estudio de Allensworth y Clark (2020)</a> con 55.084 egresados de colegios públicos de Chicago encontró que el promedio de notas de bachillerato predice la graduación universitaria mucho mejor que el examen ACT, y que el valor del ACT cambiaba de un colegio a otro mientras el de las notas se mantenía estable. Una explicación plausible es que las notas capturan hábitos de trabajo y persistencia que importan para terminar una carrera. Entonces, el problema no es que las notas incluyan hábitos; es que <strong>no sabemos cuánto de cada cosa hay en cada nota</strong>, y por eso no podemos usarla bien para decidir.</p>
{{img:evidencia}}

<h2>Qué dice la normativa: Colombia, Chile y el mundo</h2>
<p><strong>En Colombia</strong>, el <a href="https://normograma.icfes.gov.co/docs/pdf/decreto_1290_2009.pdf">Decreto 1290 de 2009</a> (compilado en el Decreto 1075 de 2015) da autonomía a cada colegio para diseñar su <strong>Sistema Institucional de Evaluación de Estudiantes (SIEE)</strong> con participación de la comunidad educativa: criterios de evaluación y de promoción, y una escala propia que debe expresar su equivalencia con la escala nacional de cuatro niveles (Superior, Alto, Básico y Bajo). Esa autonomía es una oportunidad: <strong>los criterios que estamos discutiendo son decisión del colegio</strong>, y se pueden revisar con la comunidad.</p>
<p><strong>En Latinoamérica</strong>, Chile ofrece un contraste útil. Su Decreto 67 de 2018 reconoce dos usos de la evaluación (formativo, para apoyar el aprendizaje, y sumativo, para certificarlo), exige que cada colegio tenga un reglamento de evaluación y plantea que repetir curso sea una decisión excepcional apoyada en criterios pedagógicos y psicosociales. Los estudios disponibles sobre su aplicación muestran que la implementación es desigual: un estudio de 2023 en cinco escuelas de Antofagasta encontró una devaluación de la evaluación formativa y pocos criterios definidos. No hay un cambio de decreto que reemplace la conversación en cada escuela.</p>
<p><strong>En el mundo</strong>, la discusión se conoce como <em>calificación por estándares</em> (<em>standards-based grading</em>): informar por separado el nivel de logro de cada competencia y los hábitos de trabajo, en lugar de promediarlos. Es la dirección en la que apuntan los autores de la revisión citada, aunque la evidencia sobre su efecto en el aprendizaje todavía es limitada.</p>

<h2>Cumplimiento, aprendizaje profundo y competencias: tres cosas distintas</h2>
<ul>
<li><strong>Cumplimiento:</strong> entregar a tiempo, mantener el cuaderno, seguir instrucciones. Es valioso y se aprende, pero no prueba comprensión.</li>
<li><strong>Aprendizaje profundo:</strong> entender y poder explicar, aplicar a un caso nuevo, detectar errores. Se ve cuando el estudiante resuelve sin apoyo o justifica su respuesta.</li>
<li><strong>Competencias:</strong> combinar conocimiento, habilidades y actitudes para resolver situaciones reales (por ejemplo, comunicar un resultado o trabajar en equipo). Requieren evidencia de desempeño, no solo de entrega.</li>
</ul>
<p>Cuando la nota promedia las tres, castiga a Mateo por lo que no cumple y premia a Valentina por lo que no aprendió. Los <strong>docentes</strong> lo saben: premiar el cumplimiento mantiene el orden del aula, y eliminarlo no es realista. Las <strong>familias</strong> suelen pedir transparencia: quieren saber si su hijo «va mal» por no entender o por no entregar. Y los <strong>estudiantes</strong> aprenden pronto qué se premia y se adaptan: si el cuaderno vale más que explicar, cuidan el cuaderno.</p>

<h2>Matriz para revisar tus criterios de evaluación</h2>
<p>Este es el recurso aplicable. Úsala con tu equipo de área o con el consejo académico para revisar tu aula o tu SIEE:</p>
<table>
<thead><tr><th>Criterio</th><th>Pregunta para revisarlo</th><th>Señal de alerta</th><th>Ajuste posible</th></tr></thead>
<tbody>
<tr><td><strong>Separar logro y hábitos</strong></td><td>¿El boletín muestra por separado lo que se aprendió y cómo trabaja el estudiante?</td><td>Una sola nota mezcla puntualidad, orden y conocimiento.</td><td>Informar dos valoraciones: desempeño y hábitos de trabajo.</td></tr>
<tr><td><strong>Peso del cumplimiento</strong></td><td>¿Cuánto de la nota depende de entregar, no de saber?</td><td>Más del 40-50 % de la nota es cumplimiento.</td><td>Reducir el peso; mantener el cumplimiento como retroalimentación.</td></tr>
<tr><td><strong>Evidencia sin apoyo</strong></td><td>¿Hay evidencia de lo que el estudiante hace sin ayuda?</td><td>Todas las notas son tareas en casa.</td><td>Incluir sustentación oral, problema nuevo o evaluación de transferencia.</td></tr>
<tr><td><strong>Penalización por tardanza</strong></td><td>¿Entregar tarde baja la nota del conocimiento?</td><td>Un trabajo excelente recibe 2,0 por llegar un día tarde.</td><td>Descontar solo en la valoración de hábitos, no en la de logro.</td></tr>
<tr><td><strong>Nuevas oportunidades</strong></td><td>¿Puede el estudiante demostrar después que aprendió?</td><td>Un mal día define toda la nota.</td><td>Permitir reevaluar con plan de mejora.</td></tr>
<tr><td><strong>Claridad de criterios</strong></td><td>¿El estudiante sabe de antemano qué se valora y cómo?</td><td>Criterios implícitos o cambiantes.</td><td>Rúbrica compartida con ejemplos.</td></tr>
<tr><td><strong>Coherencia con la escala nacional</strong></td><td>¿Qué significa «Alto» en nuestro SIEE?</td><td>Un «Alto» puede ser con o sin comprensión.</td><td>Describir cada nivel por lo que el estudiante sabe y puede hacer.</td></tr>
<tr><td><strong>Participación de la comunidad</strong></td><td>¿Docentes, estudiantes y familias revisaron el SIEE en el último año?</td><td>Nadie recuerda cuándo se actualizó.</td><td>Agendar una revisión con evidencias de boletines reales.</td></tr>
</tbody>
</table>
<p>Para calcular las dos notas en una hoja de Excel (por ejemplo, con los pesos en B1:E1 y las notas de cada estudiante en B2:E2), basta con <code>=SUMAPRODUCTO(B2:E2;$B$1:$E$1)</code> para la nota final, y <code>=SUMAPRODUCTO(D2:E2;$D$1:$E$1)/SUMA($D$1:$E$1)</code> para la nota de logro (solo trabajos en clase y evaluación). La diferencia entre ambas es una señal: si es grande, la nota final está diciendo algo distinto del aprendizaje.</p>

<h2>Herramientas para evaluar mejor</h2>
<p>Si quieres tener evidencia de lo que el estudiante sabe sin apoyo, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> crea en minutos versiones distintas de un mismo problema, con las soluciones, ideales para evaluaciones de transferencia (la <a href="/examenes/demo/">demostración es gratuita</a>). Para registrar asistencia y puntualidad en un lugar separado de las notas de logro, el <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">Listado de asistencia laboral o académica en Excel</a> lleva el cumplimiento sin mezclarlo con el aprendizaje. Y el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia para diseñar actividades y rúbricas por desempeño.</p>
{{productos:generador-de-examenes-ia-esencial,listado-de-asistencia-laboral-o-academica-en-excel}}
<p>Sigue leyendo: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">¿La IA amplía el pensamiento del estudiante o lo reemplaza?</a> (con una rúbrica de autonomía y razonamiento) y <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">el espejismo de la IA en la universidad</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Debe eliminarse el cumplimiento de la nota?</h3>
<p>No necesariamente. Los hábitos de trabajo importan y se enseñan. Lo recomendable es valorarlos, pero informar por separado el desempeño (lo que se aprendió) y los hábitos, para que el boletín sea interpretable.</p>
<h3>¿Qué es el SIEE y quién lo define?</h3>
<p>Es el Sistema Institucional de Evaluación de Estudiantes: el conjunto de criterios, escala y reglas de evaluación y promoción de cada colegio, que según el Decreto 1290 de 2009 (compilado en el 1075 de 2015) se diseña con participación de la comunidad educativa.</p>
<h3>¿Las notas predicen el éxito en la universidad?</h3>
<p>Según un estudio de Chicago, el promedio de notas predijo la graduación universitaria mejor que el examen ACT. Eso no significa que midan solo conocimiento: capturan también hábitos de trabajo y persistencia.</p>
<h3>¿Cómo sé si mi hijo realmente entendió?</h3>
<p>Pídele que explique el procedimiento con sus palabras y que resuelva un ejercicio parecido sin ayuda. Si puede, entendió; si solo repite, la nota no cuenta toda la historia.</p>
<h3>¿Cómo puedo proponer cambios en el SIEE de mi colegio?</h3>
<p>A través del consejo académico, el consejo directivo o los representantes de padres y estudiantes. Llega con evidencia: boletines anonimizados que muestren notas finales iguales con desempeños distintos.</p>

<p class="notice"><strong>Revisa tus criterios esta semana.</strong> Aplica la matriz a tu aula, calcula la nota final y la nota de logro de tres estudiantes y mira cuánto se distancian. Si necesitas evidencia de transferencia, prueba el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>; y si llevas el registro del curso en Excel, el <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">Listado de asistencia</a> te ahorra horas.</p>

<h2>Para pensar</h2>
<p>Si un estudiante aprende muchísimo pero le cuesta entregar a tiempo, y otro cumple todo pero aprende poco, <strong>¿a cuál queremos premiar con la nota más alta: al que sabe, al que cumple o a quien combina ambas cosas?</strong> ¿Y quién debería decidirlo: el docente, el colegio, las familias o los propios estudiantes? Porque cada respuesta forma un tipo de adulto distinto.</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:caso}}' => $img('calificaciones-aprendizaje-cumplimiento-caso', 625, 'Comparación hipotética de dos estudiantes: Valentina cumple todo pero obtiene 2,9 en la evaluación y 4,27 de nota final; Mateo entrega tarde pero obtiene 5,0 en la evaluación y 4,21 de nota final.', 'Caso hipotético: misma nota, aprendizajes distintos.'),
    '{{img:evidencia}}' => $img('calificaciones-aprendizaje-cumplimiento-evidencia', 573, 'Cuatro tarjetas: las notas son multidimensionales (Brookhart et al., 2016), el promedio de notas predijo mejor la graduación universitaria que el ACT en 55.084 egresados de Chicago, la escala nacional colombiana tiene cuatro niveles y el Decreto 67 de Chile reconoce la evaluación formativa y sumativa.', 'Lo que dicen la investigación y la normativa. Fuentes: Brookhart et al. (2016), Allensworth y Clark (2020), Decreto 1075 de 2015 y Decreto 67 de 2018 de Chile.'),
]);

return [
    'slug' => 'calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio',
    'title' => '¿Las calificaciones miden lo que aprende un estudiante o su capacidad para cumplir con las reglas del colegio?',
    'excerpt' => 'Un caso hipotético de dos estudiantes con la misma nota y aprendizajes distintos, lo que dicen la investigación y las normas en Colombia, Chile y el mundo, y una matriz para revisar los criterios de evaluación.',
    'seo_title' => '¿Las notas miden aprendizaje o cumplimiento?',
    'seo_description' => 'Qué miden realmente las calificaciones: cumplimiento, aprendizaje o competencias. Caso hipotético, evidencia, normas y una matriz para revisar el SIEE.',
    'focus_keyword' => 'calificaciones y aprendizaje',
    'cover' => '/assets/img/articulos/calificaciones-aprendizaje-cumplimiento/calificaciones-aprendizaje-cumplimiento-portada',
    'cover_alt' => 'Portada con el título «¿Las notas miden lo que aprendes o qué tanto cumples las reglas?» y una tarjeta que compara dos notas casi iguales, 4,27 y 4,21, de dos estudiantes con aprendizajes muy distintos.',
    'published_at' => '2026-10-21 12:00:00',
    'content_html' => $html,
];
