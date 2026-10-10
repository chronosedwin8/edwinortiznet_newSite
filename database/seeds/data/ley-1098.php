<?php

declare(strict_types=1);

// "Ley 1098 de 2006, Código de la Infancia y la Adolescencia". Fuente: texto de la Secretaría del Senado (actualizado al 30-sep-2026), consultado el 10-oct-2026: arts. 3, 6-10, 12, 15, 18, 18A (Ley 2089 de 2021), 20, 26, 28, 33, 42-44 (par. 1 y 2 art. 42 de la Ley 1453 de 2011). Ficha verificada en Excel 16: 24 obligaciones (14 plenas, 6 parciales, 4 ninguna; 58 %), 6 de 8 casos correctos. Casos de práctica no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ley-1098/' . $name;
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
<p>Un docente de segundo período nota que un estudiante llega con marcas en los brazos y responde con evasivas. Otro, en el mismo colegio, corrige a un estudiante diciéndole "burro" frente al grupo y dejándolo de pie toda la clase, convencido de que "así se aprende disciplina". Dos escenas distintas con una misma pregunta de fondo: <strong>¿qué le exige la ley a un colegio y a un docente frente a los derechos de la niñez?</strong> La respuesta está, en buena parte, en la <strong>Ley 1098 de 2006, el Código de la Infancia y la Adolescencia</strong>, una de las normas que más se citan en el Concurso Docente y en la vida cotidiana de cualquier colegio.</p>
<p>Este artículo estudia ese código con la estructura <strong>norma (con su fuente) + interpretación + caso con respuesta justificada</strong>. Incluye una <a href="/descargas/concurso-docente/ficha-estudio-ley-1098-codigo-infancia-adolescencia.xlsx">ficha de estudio en Excel</a> con el mapa de la ley, un <strong>autodiagnóstico de las 24 obligaciones</strong> de los artículos 42, 43 y 44, un ejercicio de ocho situaciones ("¿qué artículo se activa?") y doce tarjetas. Texto consultado el 10 de octubre de 2026 en la Secretaría del Senado (actualizado a septiembre de 2026); el libro se verificó en Microsoft Excel 16.</p>
<p class="notice"><strong>Advertencias.</strong> Los resúmenes son míos, no literales: <strong>la fuente es el texto vigente</strong> de la ley, que ha sido modificada varias veces (por ejemplo, por la Ley 1453 de 2011 y la Ley 2089 de 2021). Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>. Nadie puede garantizarte un resultado en el concurso. Esto no es asesoría jurídica ni psicológica: ante una situación real, activa el protocolo de tu colegio y acude a las autoridades competentes.</p>

<h2>A quién protege y cómo se interpreta</h2>
<p>Según el artículo 3, son sujetos titulares de derechos <strong>todas las personas menores de 18 años</strong>: se entiende por <em>niño o niña</em> a las personas entre los 0 y los 12 años, y por <em>adolescente</em> a las personas entre los 12 y los 18. En caso de duda sobre la edad, se presume la edad inferior. El artículo 6 establece que la Constitución y los tratados de derechos humanos ratificados por Colombia, en especial la Convención sobre los Derechos del Niño, hacen parte integral del Código y sirven de guía para interpretarlo, y que <strong>siempre se aplica la norma más favorable al interés superior</strong> del niño, niña o adolescente. Ver también <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución, arts. 13, 44 y 67</a>.</p>

<h2>Cuatro principios que se confunden</h2>
{{img:principios}}
<ul>
<li><strong>Protección integral (art. 7):</strong> reconocerlos como sujetos de derechos, garantizar y cumplir sus derechos, prevenir su amenaza o vulneración y asegurar su restablecimiento inmediato.</li>
<li><strong>Interés superior (art. 8):</strong> el imperativo que obliga a todas las personas a garantizar la satisfacción integral y simultánea de todos sus derechos, que son universales, prevalentes e interdependientes.</li>
<li><strong>Prevalencia de los derechos (art. 9):</strong> en todo acto o decisión prevalecen los derechos de los niños, en especial si hay conflicto con los de cualquier otra persona; y entre normas en conflicto, se aplica la más favorable.</li>
<li><strong>Corresponsabilidad (art. 10):</strong> la familia, la sociedad y el Estado son corresponsables de su atención, cuidado y protección; pero las instituciones obligadas a prestar servicios sociales <strong>no pueden invocarla para negar la atención</strong> que demande la satisfacción de derechos fundamentales.</li>
</ul>
<p>Una distinción útil: el <em>interés superior</em> es el criterio de decisión; la <em>prevalencia</em> dice qué gana cuando hay conflicto; la <em>corresponsabilidad</em> dice quién responde (todos); y la <em>protección integral</em> es el conjunto de acciones para lograrlo. Los cuatro aparecen también en la ruta de convivencia (ver <a href="/concurso-docente-ley-1620-decreto-1965-comite-convivencia-ruta-atencion/">Ley 1620 y Decreto 1965</a>).</p>

<h2>Los derechos que más tocan al colegio</h2>
<ul>
<li><strong>Integridad personal (art. 18):</strong> protección contra acciones que causen daño o sufrimiento físico, sexual o psicológico, en especial contra el maltrato por parte de los miembros del grupo familiar, <strong>escolar</strong> y comunitario. La ley define el maltrato infantil como toda forma de perjuicio, castigo, humillación o abuso físico o psicológico, descuido, omisión o trato negligente, malos tratos o explotación sexual, y toda forma de violencia o agresión.</li>
<li><strong>Buen trato (art. 18A, adicionado por la Ley 2089 de 2021):</strong> derecho a recibir orientación, educación, cuidado y disciplina por métodos no violentos; <strong>en ningún caso se admiten los castigos físicos</strong> como forma de corrección ni disciplina.</li>
<li><strong>Debido proceso (art. 26):</strong> garantías del debido proceso en toda actuación administrativa y judicial en que estén involucrados, con derecho a ser escuchados y a que sus opiniones se tengan en cuenta.</li>
<li><strong>Educación (art. 28):</strong> derecho a una educación de calidad, obligatoria por parte del Estado en un año de preescolar y nueve de básica, y gratuita en las instituciones estatales.</li>
<li><strong>Intimidad (art. 33):</strong> protección contra toda injerencia arbitraria o ilegal en su vida privada, y contra conductas que afecten su dignidad (relevante para los datos y las imágenes de los estudiantes).</li>
</ul>

<h2>Lo que el Código le exige al colegio: los artículos 42, 43 y 44</h2>
<p><strong>Artículo 42, obligaciones especiales de las instituciones educativas.</strong> Entre otras: facilitar el acceso y garantizar la permanencia; brindar una educación pertinente y de calidad; respetar en toda circunstancia la dignidad de los miembros de la comunidad educativa; facilitar la participación de los estudiantes en la gestión académica; abrir espacios de comunicación con los padres de familia; organizar programas de nivelación y de orientación psicopedagógica y psicológica; respetar y fomentar las diversas culturas; fomentar el estudio de idiomas; y evitar cualquier conducta discriminatoria por sexo, etnia, credo, condición socioeconómica o cualquier otra. El parágrafo 1 (Ley 1453 de 2011) obliga a todas las instituciones, públicas y privadas, a estructurar un módulo articulado al PEI para mejorar las capacidades de los padres en orientaciones para la crianza.</p>
<p><strong>Artículo 43, obligación ética fundamental.</strong> Las instituciones de primaria y secundaria, públicas y privadas, tienen la obligación fundamental de garantizar el pleno respeto a la dignidad, vida, integridad física y moral dentro de la convivencia escolar. Para ello deben formar en el respeto a la dignidad humana y la tolerancia hacia las diferencias; <strong>proteger eficazmente contra toda forma de maltrato, agresión física o psicológica, humillación, discriminación o burla de parte de los compañeros y de los profesores</strong>; y establecer en sus reglamentos mecanismos disuasivos, correctivos y reeducativos contra la agresión y la burla, en especial hacia estudiantes con dificultades de aprendizaje o de lenguaje o con capacidades sobresalientes.</p>
<p><strong>Artículo 44, obligaciones complementarias.</strong> Directivos y docentes y la comunidad educativa en general ponen en marcha mecanismos para: comprobar la inscripción del registro civil; <strong>detectar oportunamente y brindar apoyo y orientación en casos de malnutrición, maltrato, abandono, abuso sexual, violencia intrafamiliar y explotación económica y laboral</strong>; comprobar la afiliación a un régimen de salud; prevenir el tráfico y consumo de sustancias psicoactivas; coordinar los apoyos para estudiantes con discapacidad (ver <a href="/concurso-docente-decreto-1421-de-2017-piar-ajustes-razonables-educacion-inclusiva/">Decreto 1421 y el PIAR</a>); y <strong>reportar a las autoridades competentes las situaciones de abuso, maltrato o peores formas de trabajo infantil detectadas</strong>.</p>
<p>La hoja <em>Obligaciones</em> de la ficha lista 24 de esas obligaciones para que marques si tu colegio tiene evidencia plena, parcial o ninguna. En el ejemplo, 14 tienen evidencia plena, 6 parcial y 4 ninguna (58 % con evidencia plena): una fotografía que sirve para un plan de mejoramiento, no para culpar a nadie.</p>

{{img:pasos}}
<h2>Ante una posible vulneración: cinco pasos</h2>
<ol>
<li><strong>Registrar los hechos observados</strong> (qué se vio o escuchó, cuándo, quién), sin suponer causas ni diagnosticar.</li>
<li><strong>Escuchar sin interrogar:</strong> acoger al estudiante con calma, no presionarlo para que "cuente todo" y no confrontarlo con la persona señalada; la indagación corresponde a las autoridades competentes.</li>
<li><strong>Informar de inmediato</strong> al rector o a quien corresponda y a orientación, y activar el protocolo del colegio (en convivencia escolar, la ruta de la Ley 1620).</li>
<li><strong>Reportar a las autoridades competentes</strong> (art. 44 num. 9): según el caso, Comisaría de Familia, ICBF, Policía de Infancia y Adolescencia, Fiscalía o salud; el protocolo del colegio debe tener el directorio actualizado.</li>
<li><strong>Proteger y hacer seguimiento</strong> con confidencialidad: el estudiante no debe ser expuesto ni revictimizado, y los datos se manejan con reserva.</li>
</ol>

<h2>Dos casos de aplicación (práctica, no oficial)</h2>
<h3>Caso 1</h3>
<p><strong>Situación.</strong> Una docente nota que un estudiante de cuarto llega con moretones en los brazos y dice que "se cayó" en el parque. La docente piensa: "mejor espero a estar segura antes de decir algo, para no meter a la familia en problemas".</p>
<p><strong>Pregunta.</strong> ¿Cuál es la actuación más sólida según el Código?</p>
<ol type="A">
<li>Esperar a tener pruebas concluyentes antes de informar a alguien.</li>
<li>Registrar lo observado, escuchar al estudiante sin interrogarlo, informar al rector y a orientación, activar el protocolo del colegio y reportar a las autoridades competentes, con reserva y protección del estudiante.</li>
<li>Llamar a la familia para que explique y cerrar el tema si la explicación parece razonable.</li>
<li>Preguntar al estudiante, delante del grupo, qué le pasó, para que sea sincero.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 44 pone en cabeza de directivos y docentes mecanismos de detección oportuna y de orientación en casos de maltrato y violencia intrafamiliar, y de reporte a las autoridades competentes de las situaciones de abuso o maltrato <em>detectadas</em>; la norma no exige certeza para activar la ruta, sino que las autoridades investiguen. El artículo 18 incluye el maltrato dentro de la familia, y el artículo 33 protege la intimidad. A retrasa la protección; C puede poner en riesgo al estudiante si el agresor está en casa y no cumple el reporte; D lo expone y puede revictimizarlo. Aun así, que un moretón no sea necesariamente maltrato es justamente la razón por la que quienes deciden son las autoridades competentes y no el docente.</p>
<h3>Caso 2</h3>
<p><strong>Situación.</strong> Un docente deja de pie durante toda la clase a un estudiante que no entregó una tarea y le dice "burro" delante del grupo. Cuando coordinación le llama la atención, responde que es "una corrección pedagógica" y que los padres lo autorizaron.</p>
<p><strong>Pregunta.</strong> ¿Qué dice el Código sobre esa práctica?</p>
<ol type="A">
<li>Es válida porque es breve y los padres la autorizaron.</li>
<li>Es contraria al Código: la humillación y la burla por parte de profesores están dentro de lo que los colegios deben evitar y prevenir (art. 43), el maltrato incluye la humillación psicológica (art. 18) y el buen trato exige disciplina por métodos no violentos (art. 18A); la autorización de los padres no la hace válida.</li>
<li>Es válida si está prevista en el manual de convivencia.</li>
<li>Solo sería un problema si el estudiante se queja por escrito.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 43 (num. 2) obliga a proteger eficazmente a los estudiantes contra la humillación y la burla de parte de los profesores y a fijar mecanismos correctivos y reeducativos; el artículo 18 define el maltrato infantil incluyendo el humillar; el artículo 18A reconoce el derecho a la disciplina por métodos no violentos. C no sirve porque los manuales deben ajustarse a la ley y a la Constitución, y A y D confunden el consentimiento o la queja con la legalidad. Lo que corresponde es intervenir con un enfoque formativo, respetando el debido proceso del docente según las normas disciplinarias aplicables (ver <a href="/concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro/">el Decreto Ley 1278</a>) y reparando la situación del estudiante. Ambos casos son ejercicios míos, no preguntas oficiales.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>El Código de 2006 reemplazó el antiguo Código del Menor (1989) y adoptó el enfoque de <strong>protección integral</strong> y de sujetos de derechos de la Convención sobre los Derechos del Niño, que Colombia ratificó. En América Latina, muchos países reformaron sus códigos en esa dirección desde los años noventa; en el mundo, la tendencia es prohibir expresamente el castigo físico en todos los ámbitos (en Colombia, lo hace de forma expresa el art. 18A desde 2021). La brecha frecuente no está en la norma sino en la práctica: detectar a tiempo, saber a quién reportar y proteger sin exponer.</p>
<p>Para los <strong>aspirantes</strong>, el reto es distinguir los principios y saber qué artículo se activa en cada situación; para los <strong>docentes</strong>, que la obligación de proteger es personal e institucional y que la disciplina no puede humillar; para los <strong>directivos</strong>, tener protocolos conocidos, un directorio actualizado y mecanismos reales; y para las <strong>familias</strong>, que la corresponsabilidad no es delegar: el colegio y la familia protegen juntos, y la escuela no debe ser la única que actúa ni la que oculta. Ver también <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflicto, indisciplina y violencia escolar</a>.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a> y la serie: <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">Ley 115 y Decreto 1860</a>, <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución</a>, <a href="/concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro/">el Decreto Ley 1278</a>, <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE</a>, <a href="/concurso-docente-ley-1620-decreto-1965-comite-convivencia-ruta-atencion/">la Ley 1620</a> y <a href="/concurso-docente-decreto-1421-de-2017-piar-ajustes-razonables-educacion-inclusiva/">el Decreto 1421</a>. Entrena el análisis de casos con <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>, analiza tus errores con el <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">plan de mejora</a> y registra tu avance en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a>. Refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a> y la herramienta <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿A quién protege la Ley 1098 de 2006?</h3>
<p>A todas las personas menores de 18 años: niños y niñas de 0 a 12 años y adolescentes de 12 a 18 (art. 3).</p>
<h3>¿Qué es el interés superior del niño?</h3>
<p>El imperativo que obliga a todas las personas a garantizar la satisfacción integral y simultánea de todos sus derechos (art. 8).</p>
<h3>¿Qué obligaciones tiene el colegio según el Código?</h3>
<p>Las de los artículos 42 (obligaciones especiales), 43 (obligación ética fundamental) y 44 (obligaciones complementarias), entre ellas proteger contra el maltrato y la humillación, detectar y reportar situaciones de abuso o maltrato y coordinar los apoyos para estudiantes con discapacidad.</p>
<h3>¿Se permiten los castigos físicos en el colegio?</h3>
<p>No: el art. 18A (Ley 2089 de 2021) dice que en ningún caso se admiten como forma de corrección ni disciplina.</p>
<h3>¿Qué debe hacer un docente que detecta una posible situación de maltrato?</h3>
<p>Registrar lo observado, escuchar sin interrogar, informar a los directivos y a orientación, activar el protocolo del colegio y reportar a las autoridades competentes (art. 44 num. 9), con reserva.</p>

<p class="notice"><strong>Haz el autodiagnóstico de tu colegio.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-ley-1098-codigo-infancia-adolescencia.xlsx">ficha de estudio</a>, marca cuáles de las 24 obligaciones tienen evidencia en tu colegio y resuelve el ejercicio de las ocho situaciones.</p>

<h2>Para pensar</h2>
<p>Proteger a un niño suele exigir actuar antes de tener certeza, y esa incertidumbre incomoda: nos preocupa equivocarnos, ofender a una familia o ser nosotros quienes lo hagan "más grande". <strong>¿Qué te frena hoy, en tu colegio, de reportar una situación que te preocupa: el miedo a equivocarte, no saber a quién acudir o la sensación de que nada pasará? Y ¿qué tendría que ser distinto para que cualquier docente supiera, sin dudar, cuál es su primer paso?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:principios}}' => $img('ley-1098-principios', 499, 'Tabla con cuatro principios del Código de la Infancia y la Adolescencia y su artículo: protección integral, interés superior, prevalencia y corresponsabilidad.', 'Cuatro principios que se confunden.'),
    '{{img:pasos}}' => $img('ley-1098-pasos', 467, 'Cinco pasos ante una posible vulneración de derechos: registrar, no interrogar, informar, reportar y proteger.', 'Cinco pasos ante una posible vulneración.'),
]);

return [
    'slug' => 'concurso-docente-ley-1098-de-2006-codigo-infancia-adolescencia-obligaciones-colegio',
    'title' => 'Ley 1098 de 2006 en el Concurso Docente: los derechos de la infancia y lo que el Código le exige al colegio y al docente',
    'excerpt' => 'El Código de la Infancia y la Adolescencia: interés superior, prevalencia y corresponsabilidad, el buen trato, y las obligaciones de los artículos 42, 43 y 44, con un autodiagnóstico en Excel y dos casos resueltos.',
    'seo_title' => 'Ley 1098 de 2006: Código de la Infancia y obligaciones',
    'seo_description' => 'Estudia la Ley 1098 de 2006: interés superior, prevalencia, buen trato y las obligaciones del colegio (arts. 42, 43 y 44), con ficha y casos resueltos.',
    'focus_keyword' => 'Ley 1098 de 2006',
    'cover' => '/assets/img/articulos/ley-1098/ley-1098-portada',
    'cover_alt' => 'Portada "Ley 1098 de 2006: los derechos de la infancia y lo que le exige al colegio" con una tarjeta: 3 artículos concentran lo que el Código le exige directamente al colegio, el 42, el 43 y el 44.',
    'published_at' => '2027-02-26 12:00:00',
    'content_html' => $html,
];
