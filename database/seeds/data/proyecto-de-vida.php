<?php

declare(strict_types=1);

// Artículo de análisis: video de Platzi sobre la formación de docentes en proyecto de vida (YouTube FP6OR13xhfQ).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/proyecto-de-vida/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

return [
    'slug' => 'proyecto-de-vida-colegio-docentes-caso-platzi',
    'title' => 'Proyecto de vida en el colegio: por qué 4 de cada 10 profes cancelaban esa clase y qué nos enseña el caso Platzi',
    'excerpt' => 'Un video de Platzi revela que uno de cada tres docentes no se sentía preparado para guiar el proyecto de vida de sus estudiantes. Lo analizo desde el aula, la familia, los estudiantes y el sistema educativo colombiano, y lo comparo con Latinoamérica y el mundo.',
    'seo_title' => 'Proyecto de vida en el colegio: el caso Platzi y Colombia',
    'seo_description' => 'Uno de cada tres docentes no se siente preparado para guiar el proyecto de vida. Análisis del caso Platzi para profes, familias y el sistema educativo.',
    'focus_keyword' => 'proyecto de vida',
    'cover' => '/assets/img/articulos/proyecto-de-vida/proyecto-de-vida-portada',
    'cover_alt' => 'Ruta con cinco etapas del proyecto de vida: quién soy, qué me mueve, qué opciones tengo, mi plan y hacia dónde voy',
    'published_at' => '2026-10-06 16:00:00',
    'content_html' => <<<HTML
<p>Hay una pregunta que todo docente ha escuchado alguna vez en el pasillo: "Profe, ¿y yo qué estudio?". Detrás de esa pregunta no hay una tarea ni una evaluación: hay un adolescente intentando imaginarse a sí mismo dentro de cinco o diez años. La escuela tiene un nombre para ese trabajo, <strong>proyecto de vida</strong>, y en muchos colegios es justamente la clase que se aplaza cuando el tiempo no alcanza.</p>
<p>Un video reciente de Platzi puso cifras a esa realidad en colegios públicos de Cundinamarca. Lo analicé con calma porque, como docente, me interesa menos la noticia que lo que revela: qué les pasa a los profesores, qué necesitan los estudiantes, qué pueden hacer las familias y qué tan preparado está el sistema educativo colombiano frente a lo que se hace en Latinoamérica y en el resto del mundo.</p>

<h2>Lo que cuenta el video</h2>
<figure class="lite-yt" data-yt="FP6OR13xhfQ"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=FP6OR13xhfQ" data-yt="FP6OR13xhfQ"><img src="https://i.ytimg.com/vi/FP6OR13xhfQ/hqdefault.jpg" alt="Video: Platzi quiere llegar a 1,600 profes de escuelas públicas" width="480" height="360"><span class="lite-yt__play"></span></a></figure>
<p>En poco más de dos minutos, Platzi presenta un proyecto que hizo con la <strong>Fundación Santa Isabel</strong>. Antes de empezar, la fundación encontró dos datos incómodos en los colegios con los que trabajaba:</p>
<ul>
<li><strong>Uno de cada tres docentes</strong> no se sentía preparado para guiar los planes de vida de sus estudiantes.</li>
<li><strong>Más de cuatro de cada diez</strong> habían cancelado o pospuesto esa clase porque no contaban con las herramientas necesarias.</li>
</ul>
<p>Platzi tomó la metodología y las guías de la fundación y las convirtió en un curso en línea, "Aventura al éxito", dirigido a rectores, docentes y líderes escolares. Se lanzó en septiembre de 2025 y, según el video, <strong>729 docentes de 18 colegios públicos</strong> de Cundinamarca se certificaron con una valoración de 4,8 sobre 5. Una evaluación externa encontró que el <strong>96 %</strong> considera útil o muy útil lo aprendido y que el <strong>86 %</strong> ya lo aplica en clase. La meta es llegar a <strong>1.600 docentes en 2028</strong>.</p>
{$img('proyecto-de-vida-datos', 613, 'Infografía con los datos del caso: 1 de 3 docentes no se sentía preparado, 4 de 10 cancelaban la clase, 729 docentes certificados en 18 colegios, 96 % lo considera útil y 86 % lo aplica', 'Los datos del caso según el video de Platzi. La meta es formar 1.600 docentes en 2028.')}
<p>La segunda mitad del video es menos sobre educación y más sobre comunicación: Platzi reconoce que proyectos como este "no llegaron a redes, no llegaron a la comunidad y muchas veces ni siquiera llegaron a nosotros", y cierra con una idea que vale para cualquier colegio: <em>no hay que crear todo de cero, solo hay que contarlo</em>.</p>

<h2>Por qué el proyecto de vida no es una clase de relleno</h2>
<p>Cuando un colegio cancela la clase de proyecto de vida casi nunca lo hace por desinterés. Lo hace porque es la asignatura sin examen externo, sin libro de texto claro y, como muestra el video, a menudo sin un docente que se sienta seguro de cómo darla. El problema es que lo que no se trabaja en el colegio no desaparece: se decide igual, pero a ciegas.</p>
<p>Un estudiante que termina el grado once sin haber explorado sus intereses ni las opciones que tiene suele elegir por descarte, por lo que eligió un amigo o por lo que alguien le dijo en la casa. Y cuando la elección no tiene raíces, la deserción en los primeros semestres o el abandono de la formación aparecen como consecuencia lógica, no como sorpresa.</p>
<p>La investigación internacional apunta en la misma dirección. El informe <em>Dream Jobs?</em> de la OCDE, basado en las respuestas de los estudiantes de PISA, mostró que las aspiraciones profesionales de los adolescentes se concentran en un puñado de ocupaciones conocidas y que muchos jóvenes, sobre todo los de hogares con menos recursos, no tienen claro qué estudios necesitan para la carrera que dicen querer. No es falta de sueños: es falta de información y de experiencias para construirlos.</p>

<h2>Los profesores: de la buena voluntad al método</h2>
<p>El dato más revelador del video no es que los docentes cancelen la clase; es por qué lo hacen. La mayoría de quienes enseñamos en Colombia nos formamos para una disciplina: matemáticas, lenguaje, ciencias. Muy pocos programas de licenciatura preparan para acompañar decisiones de vida, y sin embargo esa tarea termina asignada al director de grupo o al docente que tiene horas libres.</p>
<p>Por eso tiene sentido el enfoque del caso: no reemplazar al profesor con una plataforma, sino darle una metodología, guías concretas y un orden de trabajo. El 86 % que reporta aplicar lo aprendido sugiere que el obstáculo no era la falta de compromiso, sino la falta de herramientas. Cuando un docente sabe qué hacer en cada sesión, deja de improvisar y deja de cancelar.</p>
<p>Ahora bien, la formación por sí sola no resuelve todo. Para que el proyecto de vida funcione en el aula, el docente también necesita:</p>
<ul>
<li><strong>Tiempo protegido en el horario</strong>, no las horas que sobran.</li>
<li><strong>Material actualizado</strong> sobre carreras, programas técnicos, becas y el mercado laboral de su región.</li>
<li><strong>Apoyo del orientador escolar</strong> para los casos que requieren atención individual.</li>
<li><strong>Seguimiento</strong>: saber qué pasó con sus estudiantes después del grado.</li>
</ul>

<h2>Los estudiantes: lo que necesitan para decidir</h2>
<p>Un proyecto de vida no es un formato que se llena una vez en décimo grado. Es un proceso que debería repetirse y ajustarse, porque los intereses cambian. Lo que más ayuda a un estudiante a construirlo, según la experiencia en el aula y las recomendaciones internacionales, se resume en tres verbos:</p>
<ol>
<li><strong>Conocerse</strong>: identificar intereses, habilidades y valores, y reconocer lo que le apasiona y lo que no.</li>
<li><strong>Explorar</strong>: conocer opciones reales (universitarias, técnicas, tecnológicas, de emprendimiento), hablar con personas que trabajan en ellas y, cuando sea posible, vivir experiencias en lugares de trabajo.</li>
<li><strong>Planear y revisar</strong>: convertir lo anterior en metas concretas, con pasos, plazos y planes alternativos, y volver a revisarlo cada año.</li>
</ol>
<p>Hay además una brecha que el sistema no puede ignorar. En los colegios rurales o de municipios pequeños, el abanico de opciones que un estudiante conoce suele ser más estrecho, y los estereotipos de género siguen pesando a la hora de imaginar ciertas profesiones. Un buen trabajo de proyecto de vida amplía ese abanico; uno ausente lo deja como está.</p>

<h2>Los padres de familia: acompañar sin imponer</h2>
<p>La familia es el primer lugar donde un adolescente habla de su futuro, y también donde más presión recibe. Muchos padres quieren para sus hijos la carrera que ellos no pudieron estudiar o la que creen que da más dinero, y eso, aunque nace del cariño, puede convertir el proyecto de vida en un proyecto ajeno.</p>
<p>Algunas ideas prácticas que comparto con las familias en las reuniones de padres:</p>
<ul>
<li><strong>Preguntar antes de opinar</strong>: "¿Qué te gusta hacer cuando nadie te obliga?" abre más conversación que "¿Qué vas a estudiar?".</li>
<li><strong>Conocer las opciones</strong>: la formación técnica y tecnológica también es un camino digno y con salida laboral.</li>
<li><strong>Hablar de dinero sin miedo</strong>: costos, becas, créditos y la posibilidad de estudiar y trabajar.</li>
<li><strong>Acercarse al colegio</strong>: preguntar cómo se trabaja el proyecto de vida y pedir que no se cancele.</li>
<li><strong>Aceptar los cambios</strong>: cambiar de idea a los dieciséis años no es un fracaso, es parte del proceso.</li>
</ul>
{$img('proyecto-de-vida-actores', 667, 'Mapa de actores alrededor del estudiante y su proyecto de vida: docentes, familia, colegio y orientación, y sistema educativo, con aliados externos', 'El proyecto de vida se sostiene entre cuatro actores. Cuando uno falla, los demás cargan con todo.')}

<h2>El sistema educativo colombiano: la norma existe, la práctica es desigual</h2>
<p>En el papel, Colombia no está mal. La Ley General de Educación (Ley 115 de 1994) plantea el pleno desarrollo de la personalidad como fin de la educación, y el Decreto 1860 de 1994 ordena que en todos los establecimientos educativos exista un <strong>servicio de orientación estudiantil</strong> que contribuya, entre otras cosas, a la toma de decisiones personales y a la identificación de aptitudes e intereses. El Ministerio de Educación también ha publicado orientaciones de <strong>orientación socio-ocupacional</strong> para que los colegios acompañen el tránsito a la educación superior y al trabajo.</p>
<p>El problema está en la ejecución. Cómo se trabaja el proyecto de vida depende del PEI de cada institución, del tiempo que le asigne y de si cuenta o no con <strong>docentes orientadores</strong>. Ese cargo existe en la carrera docente oficial, y quien se prepara para el <a href="/concurso-docente/">Concurso Docente</a> en ese perfil sabe lo exigente que es, pero muchos colegios tienen un solo orientador para cientos de estudiantes o simplemente no lo tienen.</p>
<p>En ese vacío aparecen las alianzas como la del video: una fundación que diseña la metodología y una plataforma que la lleva a escala. Es una fortaleza del ecosistema colombiano, pero también una señal de alerta. Si la formación de docentes en algo tan esencial depende de la iniciativa privada, su continuidad depende de presupuestos, prioridades y convocatorias que el colegio no controla.</p>

<h2>Colombia frente a Latinoamérica</h2>
<p>La región comparte desafíos muy parecidos: alta deserción en la educación superior, mucha informalidad laboral y grandes diferencias entre la educación urbana y la rural. Las respuestas, en cambio, varían:</p>
<ul>
<li><strong>Chile</strong> incluyó <em>Orientación</em> como asignatura del currículo nacional en la educación básica y en los primeros años de la media, con objetivos y horario propios. Eso le da un lugar fijo que no depende de la buena voluntad de cada colegio.</li>
<li><strong>México</strong> ha impulsado en la educación media superior programas de habilidades socioemocionales que trabajan la toma de decisiones y el proyecto de vida como parte de la formación integral.</li>
<li><strong>Colombia</strong> tiene la figura legal del servicio de orientación y del docente orientador, pero no una asignatura obligatoria ni un estándar común sobre qué debe vivir cada estudiante antes de graduarse.</li>
</ul>
<p>En pocas palabras: Colombia tiene la norma, pero le falta el estándar; algunos vecinos tienen el espacio en el horario, pero comparten la misma escasez de orientadores formados.</p>

<h2>Colombia frente al resto del mundo</h2>
<p>Los sistemas que mejor acompañan esta etapa tienen algo en común: tratan la orientación como un servicio profesional con estándares, no como una clase opcional.</p>
<ul>
<li><strong>Finlandia</strong> incluye la orientación educativa y profesional en su currículo nacional y cuenta con consejeros especializados que acompañan a los estudiantes en los momentos de transición.</li>
<li><strong>Inglaterra</strong> adoptó los ocho <em>Gatsby Benchmarks</em> como referencia de buena orientación: un programa estable en cada colegio, información sobre el mercado laboral, atención a las necesidades de cada estudiante, vínculo entre las asignaturas y las carreras, encuentros con empleadores, experiencias en lugares de trabajo, contacto con la educación superior y orientación personal.</li>
<li><strong>La OCDE</strong>, en sus informes sobre preparación para el mundo laboral, recomienda que los estudiantes exploren, experimenten y reflexionen sobre el trabajo desde temprano, y que los sistemas midan sus aspiraciones para detectar a tiempo a quienes se quedan sin horizonte.</li>
</ul>
{$img('proyecto-de-vida-modelos', 653, 'Comparación de cinco modelos de orientación: Colombia, Chile, Finlandia, Inglaterra y las recomendaciones de la OCDE', 'Cinco formas de acompañar el futuro de los estudiantes, de la norma colombiana a los estándares ingleses.')}
<p>Frente a esos referentes, el caso del video es valioso precisamente porque ataca el eslabón más débil del modelo colombiano: el docente que tiene la responsabilidad, pero no la preparación.</p>

<h2>Una lectura crítica del caso</h2>
<p>Celebrar el resultado no impide hacerle preguntas. Algunas que me parecen justas:</p>
<ul>
<li><strong>Aplicar no es lo mismo que impactar.</strong> Que el 86 % de los docentes aplique lo aprendido es un gran indicador de adopción, pero el verdadero resultado está en los estudiantes: ¿toman decisiones más informadas?, ¿persisten más en sus estudios?</li>
<li><strong>La escala importa.</strong> Llegar a 1.600 docentes en 2028 es valioso, pero Colombia tiene cientos de miles de docentes en el sector oficial. Lo que funciona en Cundinamarca necesita una ruta para llegar a todo el país.</li>
<li><strong>La sostenibilidad también.</strong> Si el proyecto depende de una alianza puntual, ¿qué pasa con los colegios cuando la alianza termina?</li>
</ul>
<p>Y hay una lección que el propio video deja sin proponérselo: muchas buenas prácticas educativas existen, pero nadie las cuenta. Cada colegio que logra trabajar bien el proyecto de vida debería documentarlo y compartirlo, porque, como dice Platzi, no hay que crear todo de cero.</p>

<h2>Qué puede hacer cada uno desde mañana</h2>
<ul>
<li><strong>Docentes</strong>: planear el proyecto de vida como cualquier otra área, con secuencia, materiales y evidencias, y pedir formación cuando no se sientan preparados.</li>
<li><strong>Rectores y coordinadores</strong>: proteger esa hora en el horario, incluirla en el PEI con metas medibles y articularla con el orientador.</li>
<li><strong>Familias</strong>: conversar en casa sin imponer y exigir al colegio que esa clase no se cancele.</li>
<li><strong>Estudiantes</strong>: tomarse en serio las actividades de exploración, hacer preguntas y entender que un plan se puede ajustar.</li>
<li><strong>Secretarías de educación y Ministerio</strong>: formar orientadores y docentes en esta área, definir un estándar mínimo de experiencias por estudiante y medir resultados.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es el proyecto de vida en el colegio?</h3>
<p>Es el proceso con el que el colegio ayuda a cada estudiante a conocerse, explorar sus opciones de estudio y trabajo y construir un plan para su futuro. En Colombia se enmarca en el servicio de orientación estudiantil y en el proyecto educativo institucional de cada colegio.</p>
<h3>¿Es obligatorio trabajar el proyecto de vida en Colombia?</h3>
<p>La norma exige que todos los establecimientos presten un servicio de orientación estudiantil que apoye la toma de decisiones y la identificación de aptitudes e intereses. La forma concreta de hacerlo, el tiempo y el responsable dependen del PEI de cada colegio.</p>
<h3>¿Qué es el curso "Aventura al éxito" de Platzi?</h3>
<p>Es un curso en línea creado por Platzi a partir de la metodología de la Fundación Santa Isabel para que rectores, docentes y líderes escolares guíen el proyecto de vida de sus estudiantes. Según el video, certificó a 729 docentes de 18 colegios públicos de Cundinamarca.</p>
<h3>¿Cómo pueden ayudar los padres a construir el proyecto de vida?</h3>
<p>Escuchando antes de opinar, conociendo las opciones de formación técnica, tecnológica y universitaria, hablando con franqueza de costos y becas, y aceptando que los intereses de un adolescente pueden cambiar.</p>
<h3>¿Qué hacen otros países para orientar a sus estudiantes?</h3>
<p>Chile tiene Orientación como asignatura; Finlandia cuenta con consejeros especializados dentro de su currículo; Inglaterra usa los ocho Gatsby Benchmarks como estándar, y la OCDE recomienda que los estudiantes exploren el mundo del trabajo desde temprano.</p>

<h2>Conclusión</h2>
<p>El caso de Platzi y la Fundación Santa Isabel demuestra algo sencillo y poderoso: cuando a un docente se le dan herramientas, deja de cancelar la clase de proyecto de vida y empieza a darla bien. Colombia ya tiene la norma que obliga a orientar a los estudiantes; lo que le falta es convertirla en una práctica estable, con docentes y orientadores formados, tiempo protegido y metas que se midan. Mientras eso llega, cada profe, cada familia y cada colegio pueden empezar por no dejar que esa hora se pierda.</p>

<h2>Una pregunta para terminar</h2>
{$img('proyecto-de-vida-pregunta', 480, 'Pregunta final: por qué el sistema educativo mide cuánto sabe un estudiante de matemáticas pero no si sabe quién quiere ser', 'La pregunta que queda abierta.')}
<p><strong>¿Por qué el sistema educativo mide con tanta precisión cuánto sabe un estudiante de matemáticas, pero no tiene un solo indicador de si sabe quién quiere ser?</strong> Si las pruebas de Estado definen lo que los colegios priorizan, tal vez el proyecto de vida seguirá siendo la clase que se cancela hasta el día en que alguien decida medirlo.</p>
HTML,
];
