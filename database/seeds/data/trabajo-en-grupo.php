<?php

declare(strict_types=1);

// "Trabajo en grupo justo". Fuentes: Latané, Williams y Harkins (1979), "Many hands make light the work"; Karau y Williams (1993), metaanálisis de la holgazanería social; Johnson y Johnson y Slavin (aprendizaje cooperativo); método WebPA (Universidad de Loughborough). Libro verificado en Excel 16 y Python: 3 grupos de 4; factores sin autoevaluación; B4 0,27 → nota 1,01 sin acotar y 3,04 acotada; 2 notas bajan más de 0,3; 1 grupo equilibrado. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/trabajo-en-grupo/' . $name;
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
<p>Cuatro estudiantes entregan un trabajo en grupo y reciben la misma nota: 4,2. Tres de ellos pasaron dos semanas coordinando, investigando y redactando. El cuarto aportó una diapositiva a las once de la noche anterior. La nota es la misma para los cuatro, y los tres que trabajaron aprendieron algo que no estaba en el plan de estudios: <strong>que en los trabajos en grupo conviene aportar poco</strong>. Es uno de los reclamos más frecuentes de estudiantes y familias, y una de las razones por las que muchos docentes dejan de asignar trabajos grupales.</p>
<p>Este artículo analiza cómo calificar un trabajo en grupo de forma más justa: qué dice la investigación sobre por qué algunos integrantes aportan menos, qué condiciones hacen que el trabajo cooperativo funcione y cómo usar la <strong>evaluación entre pares con un factor de contribución acotado</strong>. Incluye un <a href="/descargas/trabajo-en-grupo/trabajo-en-grupo-justo.xlsx">libro de Excel</a> con tres grupos ficticios de cuatro integrantes, verificado en Microsoft Excel 16 y contra un cálculo independiente. Fuentes revisadas el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los datos son ficticios. La evaluación entre pares es una herramienta imperfecta: puede estar sesgada por la amistad, la popularidad, la timidez o el miedo al conflicto, y los estudiantes son menores de edad. El factor de contribución es un <strong>insumo para una conversación, no un veredicto</strong>, y su uso debe estar acordado de antemano con los estudiantes y respaldado por el sistema institucional de evaluación (SIEE) de tu colegio. Esto no sustituye el criterio profesional del docente.</p>

<h2>Por qué ocurre: la holgazanería social</h2>
<p>El fenómeno tiene nombre en la psicología: <strong>holgazanería social</strong> (<em>social loafing</em>). En un estudio clásico, Latané, Williams y Harkins (1979, "Many hands make light the work") encontraron que las personas hacían menos esfuerzo cuando creían que su aporte se confundía con el de otros (por ejemplo, al gritar o aplaudir en grupo) que cuando sabían que se les medía individualmente. Un metaanálisis posterior (Karau y Williams, 1993) encontró que el efecto aparece en muchos contextos y tareas, con variaciones: disminuye cuando la tarea es atractiva, cuando el grupo es pequeño y cohesionado y cuando la aportación individual es identificable. Lo contrario también ocurre: quien trabaja más puede sentirse explotado y reducir su esfuerzo (a veces llamado "efecto del ingenuo"), o asumir toda la carga y resentirse.</p>
<p>Hay entonces dos fallas simétricas del trabajo en grupo calificado con una sola nota: <strong>premia al que no aporta y castiga al que carga con todo</strong>. Y una tercera, menos visible: no enseña a colaborar, sino a repartirse tareas y pegarlas al final.</p>

<h2>Qué condiciones hacen que el trabajo cooperativo funcione</h2>
{{img:condiciones}}
<p>La literatura sobre aprendizaje cooperativo (Johnson y Johnson; Slavin) coincide en un resultado práctico: trabajar en grupo mejora el aprendizaje cuando se cumplen ciertas condiciones, y no cuando simplemente se juntan estudiantes. Las dos más citadas son la <strong>interdependencia positiva</strong> (el grupo tiene una meta común y el éxito de uno depende del de los demás) y la <strong>responsabilidad individual</strong> (cada integrante responde por su parte y se puede ver qué aportó). En la práctica, esto se traduce en cuatro decisiones de diseño: una meta común, responsabilidad individual con evidencias, un proceso visible (bitácora, entregas parciales) y una evaluación entre pares. Los efectos reportados varían según el contexto, la edad y la tarea, y no son automáticos.</p>

<h2>La evaluación entre pares con un factor de contribución</h2>
<p>La idea, que usan varios sistemas de evaluación entre pares en la educación superior (por ejemplo, el método WebPA, de la Universidad de Loughborough), es simple: <strong>cada integrante reparte 100 puntos entre todos los integrantes de su grupo</strong> (incluido él mismo) según su contribución, con criterios acordados de antemano. Con esos repartos se calcula, para cada integrante, un factor: 1,0 significa que aportó igual que el promedio del grupo; menos de 1,0, menos; más de 1,0, más. La nota individual es la nota del producto del grupo multiplicada por el factor.</p>
<pre><code>' Puntos promedio que recibe un integrante, SIN contar su propia autoevaluación
=(SUMAR.SI.CONJUNTO(columna_del_integrante; grupo; g) - su_autoevaluación) / (integrantes - 1)   ' español
=(SUMIFS(member_column, group, g) - own_self_rating) / (members - 1)                              ' inglés

' Factor de contribución: 1,0 = igual al promedio del grupo (4 integrantes, 100 puntos)
=puntos_promedio * 4 / 100

' Factor acotado (por ejemplo, entre 0,8 y 1,2) y nota individual
=MIN(1,2; MAX(0,8; factor))
=MIN(5; MAX(1; nota_del_grupo * factor_acotado))</code></pre>
<p>Dos decisiones de diseño importan mucho:</p>
<ul>
<li><strong>Con o sin autoevaluación.</strong> Cada persona tiende a valorarse más de lo que la valoran los demás. En el libro, un integrante del grupo 2 se dio 40 puntos a sí mismo; los demás le dieron 25, 25 y 30. Con la autoevaluación, su factor es 1,20; sin ella, 1,07. Excluir la autoevaluación del cálculo (pero conservarla como dato de reflexión) evita ese sesgo.</li>
<li><strong>Acotar el ajuste.</strong> Un factor sin límites puede producir notas extremas por una sola ronda de evaluaciones entre pares. Acotarlo (por ejemplo, a un mínimo de 0,8 y un máximo de 1,2) limita el efecto y deja las diferencias grandes para la conversación con el docente.</li>
</ul>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
<p>Tres grupos de cuatro, con notas del producto de 4,2, 3,8 y 4,6:</p>
<ul>
<li><strong>Grupo 3 (4,6):</strong> todos se dieron 25 puntos entre sí. Factor 1,0 para todos y nota individual de 4,6 para los cuatro. Puede significar un aporte realmente equilibrado o un acuerdo de no confrontar: la evaluación entre pares no puede distinguirlo; el docente, con la bitácora, sí puede.</li>
<li><strong>Grupo 1 (4,2):</strong> un integrante recibe en promedio menos puntos (factor 0,87) y su nota individual baja a 3,64; otro recibe más (1,07) y sube a 4,48; los otros dos quedan en 4,20.</li>
<li><strong>Grupo 2 (3,8):</strong> un integrante recibe casi nada: 5, 5 y 10 puntos de sus compañeros. Su factor sin autoevaluación es de 0,27: <strong>sin acotar, su nota sería 1,01; con el ajuste acotado (mínimo 0,8), es 3,04</strong>. Los otros tres suben: 4,31, 4,56 y 4,05.</li>
</ul>
<p>Resumen del libro: 12 integrantes, 1 con factor por debajo de 0,8, ninguno por encima de 1,2, <strong>2 integrantes cuya nota baja más de 0,3</strong> frente a la del grupo, y 1 de 3 grupos con aporte plenamente equilibrado según los pares. La nota individual más baja es 3,04 y la más alta, 4,60.</p>
<p><strong>Una lectura honesta:</strong> el ajuste acotado es una decisión de política de calificación, no una verdad matemática. Un 3,04 para quien casi no aportó, frente a un 3,8 del grupo, es una diferencia de 0,76; con un factor sin límites sería de 2,8. Cuál es la proporción "justa" es una decisión pedagógica que debe estar en el SIEE o en el acuerdo del curso (ver <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE y el Decreto 1290</a>).</p>
{{img:pasos}}

<h2>Cinco pasos para un trabajo en grupo más justo</h2>
<ol>
<li><strong>Acuerda con el curso, desde el inicio,</strong> qué se califica y con qué peso: el producto del grupo, la parte individual, el proceso y la evaluación entre pares. Una rúbrica compartida (ver <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a>) lo facilita.</li>
<li><strong>Asigna roles y rótalos:</strong> coordinador, investigador, redactor, verificador. Los roles hacen visible quién aporta qué.</li>
<li><strong>Haz visible el proceso:</strong> una bitácora y entregas parciales con evidencias de quién hizo qué. La nota no debería depender solo del producto final.</li>
<li><strong>Evalúa entre pares</strong> con 100 puntos por persona y criterios claros, de forma confidencial, y pide a cada integrante una justificación breve para cualquier reparto muy desigual.</li>
<li><strong>Conversa antes de calificar.</strong> Si el factor de un integrante es muy bajo o muy alto, habla con el grupo y con la persona; puede haber razones (una enfermedad, un conflicto, un rol poco visible) que los números no muestran. Y revisa si el patrón se repite: un grupo con un integrante marginado puede necesitar una intervención de convivencia, no una nota.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el SIEE de cada colegio define las estrategias de valoración integral de los desempeños y los procesos de autoevaluación de los estudiantes (art. 2.3.3.3.3.4 del Decreto 1075 de 2015); la coevaluación entre pares puede formar parte de esas estrategias, y conviene verificar lo que dice el SIEE de tu colegio antes de usarla para calificar. En la región y en el mundo, el trabajo en grupo es una de las prácticas más extendidas y más criticadas por el problema de la nota única, y hay herramientas de evaluación entre pares (algunas gratuitas) usadas sobre todo en educación superior. Para los <strong>docentes</strong>, el desafío es diseñar el trabajo de modo que aportar sea visible; para los <strong>directivos</strong>, acordar criterios comunes entre docentes para que el estudiante no cambie de reglas cada año (ver <a href="/curriculo-oculto-entre-grados-reglas-que-cambian-cada-ano-mapa-expectativas/">el currículo oculto entre grados</a>); para las <strong>familias</strong>, entender que la nota grupal y la individual miden cosas distintas; y para los <strong>estudiantes</strong>, que evaluar a un compañero con honestidad es una habilidad que se aprende. Cuidado con la privacidad y el clima: las evaluaciones entre pares no se muestran públicamente, y si revelan un conflicto, se tratan con el protocolo de convivencia (ver <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflicto, indisciplina y violencia escolar</a>).</p>

<h2>Herramientas y plantillas</h2>
<p>Para planear actividades cooperativas, rúbricas y evidencias de aprendizaje, y para organizar tus recursos con IA (siempre revisando lo que produce y sin incluir datos de estudiantes en herramientas que no estén diseñadas para custodiarlos), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">promedios en Excel: siete errores</a>, <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">calificaciones: aprendizaje o cumplimiento</a> y el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>. Para adaptar el trabajo en grupo a estudiantes con barreras de aprendizaje, <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la holgazanería social?</h3>
<p>La tendencia de algunas personas a esforzarse menos cuando trabajan en grupo y su aporte individual no es identificable. Se estudia desde los trabajos de Latané, Williams y Harkins (1979).</p>
<h3>¿Cómo evito que un integrante no aporte?</h3>
<p>Con una meta común y responsabilidad individual visible: roles, bitácora, entregas parciales y evaluación entre pares, además de acordar los criterios desde el inicio.</p>
<h3>¿Es justo calificar entre pares?</h3>
<p>Puede ser una buena fuente de información, pero tiene sesgos. Conviene usarla como insumo, acotar su efecto y conversar antes de calificar.</p>
<h3>¿Qué significa un factor de contribución de 0,5?</h3>
<p>Que, según sus pares, el integrante aportó la mitad que el promedio del grupo. Es un dato para conversar, no una nota.</p>
<h3>¿Cómo uso el libro?</h3>
<p>Escribe los 100 puntos que repartió cada integrante, la nota del producto de cada grupo y los límites del ajuste; el libro calcula los factores y las notas individuales.</p>

<p class="notice"><strong>Pruébalo en tu próximo trabajo grupal.</strong> Descarga el <a href="/descargas/trabajo-en-grupo/trabajo-en-grupo-justo.xlsx">libro de trabajo en grupo justo</a>, acuerda los criterios con tu curso, recoge los repartos de 100 puntos y usa los factores como punto de partida para conversar.</p>

<h2>Para pensar</h2>
<p>Calificar a un grupo con una sola nota es cómodo para el docente, pero quizás incómodo para la justicia. <strong>¿Qué valoramos realmente en un trabajo en grupo: el producto, el aporte de cada uno o la capacidad de colaborar? Y si les pidiéramos a los estudiantes que diseñaran con nosotros las reglas para repartir la nota, ¿qué reglas propondrían y cuánto cuidarían que se cumplan?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:condiciones}}' => $img('trabajo-en-grupo-condiciones', 499, 'Tabla con cuatro condiciones de un trabajo en grupo justo, qué significa cada una y cómo se logra: meta común, responsabilidad individual, proceso visible y evaluación entre pares.', 'Qué hace justo a un trabajo en grupo.'),
    '{{img:pasos}}' => $img('trabajo-en-grupo-pasos', 467, 'Cinco pasos antes de calificar un trabajo en grupo: acordar, asignar roles, seguir el proceso, evaluar entre pares y conversar.', 'Cinco pasos para un trabajo en grupo más justo.'),
]);

return [
    'slug' => 'trabajo-en-grupo-justo-calificar-evaluacion-entre-pares-factor-de-contribucion-libro',
    'title' => 'Trabajo en grupo justo: cómo calificar sin premiar al que no aportó, con evaluación entre pares y un libro de Excel',
    'excerpt' => 'Por qué algunos integrantes aportan menos en un trabajo en grupo, qué condiciones lo hacen funcionar y cómo calificar con evaluación entre pares y un factor de contribución acotado, con un libro de Excel verificado.',
    'seo_title' => 'Trabajo en grupo justo: calificar con evaluación entre pares',
    'seo_description' => 'Cómo calificar un trabajo en grupo con justicia: holgazanería social, interdependencia y evaluación entre pares con factor de contribución, y libro de Excel.',
    'focus_keyword' => 'trabajo en grupo justo',
    'cover' => '/assets/img/articulos/trabajo-en-grupo/trabajo-en-grupo-portada',
    'cover_alt' => 'Portada "Trabajo en grupo justo: cómo calificar sin premiar al que no aportó" con una tarjeta: 1,01 y 3,04, nota sin acotar y con ajuste acotado de quien aportó mínimo, en un grupo de 3,8.',
    'published_at' => '2027-02-17 12:00:00',
    'content_html' => $html,
];
