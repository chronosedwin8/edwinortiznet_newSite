<?php

declare(strict_types=1);

// "Conflicto, indisciplina y violencia". Fuentes verificadas el 10-oct-2026: Decreto 1075 de 2015 (arts. 2.3.5.4.2.5 a 2.3.5.4.2.10, origen Decreto 1965 de 2013 arts. 39 a 44; Ley 1620 de 2013 art. 2) en texto compilado; OCDE PISA 2018 vol. III (23 % de promedio OCDE); cifra de Colombia de prensa sin contrastar con la tabla. Clasificador verificado en Excel 16 (I:1, II:3, III:2, mediar:1, falta:1). Casos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/convivencia-escolar/' . $name;
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
<p>"Es indisciplina." "No, es bullying." "Eso es un conflicto normal, que lo arreglen entre ellos." En la sala de profesores, las tres frases se dicen sobre la misma situación con total seguridad, y de cuál se escoja depende lo que se haga: una conversación, una sanción, un acta, un reporte a la familia, una llamada a la Policía. <strong>Confundir conflicto, indisciplina y violencia no es un problema de vocabulario: es el origen de respuestas equivocadas, tanto por defecto como por exceso.</strong></p>
<p>Este artículo distingue los tres conceptos con base en la Ley 1620 de 2013 y el Decreto 1965 de 2013 (hoy compilado en el Decreto Único Reglamentario 1075 de 2015), explica la clasificación de las situaciones en Tipo I, II y III y ofrece un <a href="/descargas/convivencia-escolar/clasificador-situaciones-convivencia.xlsx">clasificador en Excel</a> con ocho casos ficticios para practicar el razonamiento, con las rutas de atención resumidas. Textos verificados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Esta es una herramienta de <strong>formación</strong>, no de decisión: la clasificación de una situación real la analiza el Comité Escolar de Convivencia con el manual de convivencia y, cuando corresponde, las autoridades competentes. Los casos son ficticios; <strong>no escribas nombres ni datos reales de estudiantes</strong> en el libro ni en ninguna herramienta que no esté diseñada para custodiarlos. Esto no es asesoría jurídica ni psicológica. Si hay un riesgo inmediato para un niño, niña o adolescente, actúa según el protocolo de tu institución y acude a las autoridades; en Colombia, la línea 141 del ICBF atiende reportes de vulneración de derechos de menores (verifica su disponibilidad vigente).</p>

<h2>Tres conceptos, tres respuestas</h2>
<ul>
<li><strong>Conflicto.</strong> Según el Decreto 1075 de 2015 (art. 2.3.5.4.2.5), es una incompatibilidad real o percibida entre personas frente a sus intereses. Es normal, inevitable y puede ser una oportunidad de aprendizaje: dos estudiantes que no se ponen de acuerdo en un trabajo en grupo están en conflicto, no en agresión. Un conflicto se vuelve problema de convivencia cuando se maneja inadecuadamente y da lugar a altercados, enfrentamientos o riñas (sin afectación al cuerpo o la salud).</li>
<li><strong>Indisciplina.</strong> No es un término definido en la Ley 1620. En el lenguaje escolar se usa para referirse al incumplimiento de las normas del manual de convivencia (llegadas tarde, uso del celular en clase, no traer el material). Se atiende con el procedimiento del manual, que debe respetar el debido proceso y el derecho a la defensa y la proporcionalidad entre la falta y la medida (arts. 2.3.3.1.4.4 y 2.3.5.4.2.7). Una falta de este tipo no es, por sí misma, una agresión ni un conflicto.</li>
<li><strong>Agresión y violencia escolar.</strong> La agresión escolar es toda acción de integrantes de la comunidad educativa que busca afectar negativamente a otros, entre los que al menos uno es estudiante: puede ser física, verbal, gestual, relacional o electrónica. El <strong>acoso escolar (bullying)</strong> es una conducta negativa, intencional, metódica y sistemática de agresión, intimidación, humillación o aislamiento, repetida o sostenida en el tiempo, de pares con una relación de poder asimétrica; el <strong>ciberacoso</strong> lo hace con tecnologías de información. Un solo golpe puede ser agresión sin ser acoso; el acoso exige reiteración y desequilibrio de poder.</li>
</ul>
<p>La diferencia importa porque cada uno pide una respuesta distinta: al conflicto, mediación y desarrollo de competencias; a la indisciplina, el procedimiento del manual; a la agresión y al acoso, protección a la persona afectada, atención en salud si hay daño, trabajo con la familia y medidas con el comité, y, si hay delito, las autoridades.</p>

<h2>La clasificación en Tipo I, II y III</h2>
<p>El artículo 2.3.5.4.2.6 del Decreto 1075 (art. 40 del Decreto 1965 de 2013) clasifica en tres tipos las situaciones que afectan la convivencia escolar y el ejercicio de los derechos humanos, sexuales y reproductivos:</p>
{{img:tipos}}
<ul>
<li><strong>Tipo I:</strong> los conflictos manejados inadecuadamente y las situaciones esporádicas que inciden negativamente en el clima escolar, y que en ningún caso generan daños al cuerpo o a la salud.</li>
<li><strong>Tipo II:</strong> las situaciones de agresión escolar, acoso escolar (bullying) y ciberacoso que no revistan las características de un delito y que cumplan cualquiera de estas: se presentan de manera repetida o sistemática, o causan daños al cuerpo o a la salud sin generar incapacidad para ninguno de los involucrados.</li>
<li><strong>Tipo III:</strong> las situaciones de agresión escolar constitutivas de presuntos delitos contra la libertad, integridad y formación sexual (Título IV del Libro II de la Ley 599 de 2000) o de cualquier otro delito de la ley penal colombiana.</li>
</ul>
<p><strong>Los protocolos mínimos</strong> (arts. 2.3.5.4.2.8 a 2.3.5.4.2.10), en resumen: en el Tipo I, reunir de inmediato a las partes, mediar pedagógicamente, fijar una solución imparcial y justa, dejar constancia y hacer seguimiento. En el Tipo II, garantizar atención en salud si hay daño, remitir a las autoridades administrativas si se requiere restablecer derechos, proteger a los involucrados, informar de inmediato a los padres o acudientes, generar espacios para que expongan lo ocurrido, determinar acciones restaurativas y consecuencias, y que el comité deje acta y haga seguimiento. En el Tipo III, atención inmediata en salud si hay daño, informar a los padres o acudientes, que el presidente del comité ponga la situación en conocimiento de la Policía Nacional por el medio más expedito, y que el comité adopte de inmediato las medidas de protección propias del establecimiento. Siempre con confidencialidad, constancia por escrito y reporte en el sistema de información unificado de convivencia escolar. El protocolo completo, con sus pasos y plazos, debe estar en el manual de convivencia de cada colegio.</p>

<h2>El clasificador: ocho casos ficticios</h2>
<p>El libro pide, para cada caso, siete respuestas Sí o No (hay desacuerdo de intereses, hay agresión, es repetida, hay daño, hay incapacidad, puede ser delito, incumple una norma del manual) más si el conflicto escaló a altercado, y devuelve una clasificación orientativa y el primer paso del protocolo. Es una forma de entrenar el razonamiento:</p>
{{img:preguntas}}
<ol>
<li><strong>Empujón en la fila por el turno, una sola vez, sin lesión:</strong> Tipo I (conflicto manejado inadecuadamente; esporádico y sin daño).</li>
<li><strong>Apodos ofensivos a un compañero durante varias semanas:</strong> Tipo II (agresión verbal repetida: posible acoso escolar).</li>
<li><strong>Pelea a golpes con la nariz sangrando, una sola vez, sin incapacidad:</strong> Tipo II (agresión física con daño al cuerpo, sin incapacidad).</li>
<li><strong>Pelea con una fractura que genera incapacidad:</strong> Tipo III (el daño con incapacidad excede el Tipo II).</li>
<li><strong>Difusión de fotos íntimas de una compañera por internet:</strong> Tipo III (agresión electrónica con posible delito).</li>
<li><strong>Llegadas tarde reiteradas y uso del celular en clase:</strong> falta del manual de convivencia (indisciplina); se atiende por el procedimiento del manual.</li>
<li><strong>Desacuerdo por el reparto de tareas en un trabajo en grupo:</strong> conflicto sin escalada; se media antes de que escale.</li>
<li><strong>Amenazas repetidas por un chat de grupo:</strong> Tipo II (ciberacoso: agresión electrónica repetida).</li>
</ol>
<p>El resultado del libro: 1 caso Tipo I, 3 Tipo II, 2 Tipo III, 1 conflicto para mediar y 1 falta del manual (verificado en Excel). Dos advertencias de uso. Primero, <strong>la herramienta clasifica sobre la base de lo que se le dice</strong>: si el dato clave es incierto (¿hubo incapacidad?, ¿es un delito?), la respuesta no es adivinar sino consultar a quien corresponde, y en caso de duda sobre un posible delito contra un menor, no esperar. Segundo, la clasificación no agota la respuesta pedagógica: un caso Tipo II exige además trabajo con el curso, con las familias y con el contexto.</p>

<h2>Lo que suele salir mal</h2>
<ul>
<li><strong>Tratar el acoso como un conflicto entre iguales.</strong> En el acoso hay una relación de poder asimétrica por definición legal; poner frente a frente a la víctima y al agresor "para que se arreglen" puede revictimizar. Las formas de reparación deben diseñarse con cuidado y con acompañamiento profesional.</li>
<li><strong>Tratar la indisciplina como violencia</strong> (o al revés). Llevar una falta menor al comité o ignorar una agresión por considerarla "indisciplina" son errores simétricos.</li>
<li><strong>Sancionar sin debido proceso.</strong> El manual debe contemplar el derecho a la defensa, y las consecuencias deben ser proporcionales (art. 2.3.5.4.2.7, numeral 5).</li>
<li><strong>No dejar constancia ni hacer seguimiento.</strong> El decreto exige acta y seguimiento para verificar si la solución fue efectiva.</li>
<li><strong>Confundir confidencialidad con silencio.</strong> Se protege la intimidad de las partes, pero no se deja de informar a las familias y a las autoridades cuando corresponde.</li>
</ul>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La Ley 1620 de 2013 creó el Sistema Nacional de Convivencia Escolar y de Formación para el Ejercicio de los Derechos Humanos, la Educación para la Sexualidad y la Prevención y Mitigación de la Violencia Escolar, con una ruta de atención integral que comprende promoción, prevención, atención y seguimiento, y con comités de convivencia en cada colegio. En el mundo, el acoso escolar es un problema documentado: según los resultados de PISA 2018 de la OCDE, en promedio el 23 % de los estudiantes de los países de la OCDE reportó haber sido víctima de acoso al menos algunas veces al mes; para Colombia, la prensa reportó cifras superiores en ese ciclo (por ejemplo, 32 % según un medio, una cifra que no pude contrastar con la tabla de la OCDE bajo la misma definición, así que conviene consultar el informe, ver <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA en América Latina</a>). Para los <strong>docentes</strong>, el reto es observar y registrar con rigor, sin juzgar; para los <strong>directivos</strong>, hacer que el comité funcione, que el manual sea claro y que existan rutas conocidas; para las <strong>familias</strong>, acompañar y confiar en los procedimientos, sabiendo que se les informará; y para los <strong>estudiantes</strong>, saber que hay adultos a quienes acudir. En el caso de estudiantes con discapacidad o barreras de aprendizaje, que tienen mayor riesgo de ser víctimas, ver <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusión en el aula</a> y la herramienta <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Herramientas y lecturas</h2>
<p>Para planear actividades de competencias ciudadanas y de convivencia, y para organizar tus recursos con IA (siempre revisando lo que produce y sin incluir datos de estudiantes en herramientas que no estén diseñadas para custodiarlos), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,piar-con-ia-5-planes}}
<p>Sigue leyendo: <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">calificaciones: aprendizaje o cumplimiento</a>, <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">retroalimentación que cambia el aprendizaje</a> y <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA</a>. Para quienes se preparan para el Concurso Docente, la Ley 1620 y el Decreto 1965 se estudian en un artículo de la serie normativa de febrero.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuál es la diferencia entre conflicto y agresión?</h3>
<p>El conflicto es una incompatibilidad de intereses; la agresión es una acción que busca afectar negativamente a otro. Un conflicto puede derivar en agresión si se maneja mal, pero no son lo mismo.</p>
<h3>¿Cuándo es acoso escolar y no solo una pelea?</h3>
<p>Cuando la conducta es intencional, metódica y sistemática, se repite o se sostiene en el tiempo, y hay una relación de poder asimétrica entre quien agrede y quien es agredido.</p>
<h3>¿Qué tipo de situación es una pelea con lesiones?</h3>
<p>Depende: con daño al cuerpo o a la salud sin incapacidad, Tipo II; si genera incapacidad o constituye un delito, Tipo III. La clasificación la analiza el comité escolar de convivencia.</p>
<h3>¿La indisciplina está en la Ley 1620?</h3>
<p>No como término definido. Se atiende por el manual de convivencia, con debido proceso y proporcionalidad.</p>
<h3>¿Quién clasifica una situación?</h3>
<p>El Comité Escolar de Convivencia, con base en el manual y los protocolos del colegio, y activando a las autoridades cuando hay posible delito.</p>

<p class="notice"><strong>Practica con casos ficticios.</strong> Descarga el <a href="/descargas/convivencia-escolar/clasificador-situaciones-convivencia.xlsx">clasificador de situaciones</a>, resuelve primero los casos a mano y luego compara con la clasificación del libro. Y revisa si el protocolo de tu colegio cubre los tres tipos.</p>

<h2>Para pensar</h2>
<p>Nombrar bien una situación es el primer acto de cuidado, porque de ello depende qué hacemos y a quién protegemos. <strong>¿Cuántas veces hemos llamado "cosas de muchachos" a lo que era acoso, o "violencia" a lo que era un conflicto que nadie supo mediar? Y cuando una institución clasifica las situaciones sobre todo para protegerse a sí misma, ¿qué pasa con la persona que sufre?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tipos}}' => $img('convivencia-escolar-tipos', 444, 'Tabla con los tres tipos de situaciones de convivencia escolar, qué es cada una y el primer paso: Tipo I, Tipo II y Tipo III.', 'Los tres tipos de situación.'),
    '{{img:preguntas}}' => $img('convivencia-escolar-preguntas', 467, 'Cinco preguntas para clasificar una situación: hay desacuerdo, hay agresión, es repetida o con daño, es un posible delito y activar la ruta.', 'Cinco preguntas, en orden.'),
]);

return [
    'slug' => 'conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador',
    'title' => 'Conflicto, indisciplina y violencia escolar: tres cosas distintas, los tipos I, II y III y un clasificador con casos',
    'excerpt' => 'Cómo distinguir un conflicto, una falta de indisciplina y una agresión o acoso escolar según la Ley 1620 y el Decreto 1075, qué significan los tipos I, II y III y cuál es el primer paso de cada protocolo, con un clasificador de casos ficticios.',
    'seo_title' => 'Conflicto, indisciplina y violencia escolar: tipos I a III',
    'seo_description' => 'Diferencia entre conflicto, indisciplina y acoso escolar según la Ley 1620 y el Decreto 1075: tipos I, II y III, protocolos y clasificador de casos.',
    'focus_keyword' => 'conflicto indisciplina violencia escolar',
    'cover' => '/assets/img/articulos/convivencia-escolar/convivencia-escolar-portada',
    'cover_alt' => 'Portada "Conflicto, indisciplina y violencia: tres cosas distintas que no se atienden igual" con una tarjeta: las tres clases de situaciones tipo I, II y III del Decreto 1965 de 2013.',
    'published_at' => '2027-01-20 12:00:00',
    'content_html' => $html,
];
