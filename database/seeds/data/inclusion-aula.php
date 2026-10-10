<?php

declare(strict_types=1);

// Artículo de análisis: inclusión en el aula, el PIAR y la relación colegio-docente-familia (Colombia, Latinoamérica, EE. UU. y el mundo).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/inclusion/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

return [
    'slug' => 'inclusion-en-el-aula-piar-colombia-latinoamerica-mundo',
    'title' => 'Inclusión en el aula: qué debe tener un PIAR que funcione y cómo lograr que todo el grupo gane',
    'excerpt' => 'La inclusión no es un favor ni un formato: es un derecho que se planea. Explico qué debe contener un PIAR efectivo, cómo trabajar con la familia, qué hacen Latinoamérica, Estados Unidos y el resto del mundo, y cómo manejar la inclusión con todo el grupo.',
    'seo_title' => 'Inclusión en el aula y PIAR: guía para docentes y familias',
    'seo_description' => 'Qué debe tener un PIAR efectivo, buenas prácticas de inclusión en el aula y cómo trabajar con la familia y el grupo, con ejemplos de Colombia y el mundo.',
    'focus_keyword' => 'inclusión en el aula',
    'cover' => '/assets/img/articulos/inclusion/inclusion-portada',
    'cover_alt' => 'Aula ilustrada con un grupo diverso de estudiantes, uno de ellos en silla de ruedas, frente a un mismo tablero, junto al título Inclusión en el aula',
    'published_at' => '2026-10-07 14:00:00',
    'content_html' => <<<HTML
<p>En más de veinte años de docencia he tenido en mis clases de matemáticas y tecnología a estudiantes con autismo, con baja visión, con dislexia, con TDAH, con discapacidad intelectual y con talentos que el currículo no alcanzaba a retar. También he visto lo que pasa cuando el colegio los recibe sin preparación: un docente angustiado, una familia que siente que mendiga lo que es un derecho y un estudiante que aprende, antes que cualquier otra cosa, que en ese salón sobra.</p>
<p>Este artículo defiende la <strong>inclusión en el aula</strong> como la mejor forma de enseñar a todos: qué debe tener un PIAR para que no sea un papel más, cómo se reparten las tareas entre colegio, docente y familia, qué hacen otros países y cómo manejar la inclusión con el resto del grupo.</p>

<h2>Por qué la inclusión no es opcional (ni es caridad)</h2>
<p>Empiezo por lo jurídico porque despeja muchas discusiones de sala de profesores. Colombia aprobó la Convención de la ONU sobre los Derechos de las Personas con Discapacidad con la <strong>Ley 1346 de 2009</strong>, y su artículo 24 obliga a garantizar un sistema educativo inclusivo en todos los niveles. La <strong>Ley Estatutaria 1618 de 2013</strong> desarrolló esos derechos, la <strong>Ley 115 de 1994</strong> ya ordenaba atender a las personas con limitaciones o capacidades excepcionales y el <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=87040" target="_blank" rel="noopener">Decreto 1421 de 2017</a>, incorporado al Decreto Único Reglamentario del sector (Decreto 1075 de 2015), definió cómo se hace en la práctica.</p>
<p>Ese decreto dice algo que todo docente debería tener pegado en el escritorio: <strong>ningún establecimiento puede rechazar la matrícula de un estudiante por su discapacidad ni negarse a hacer los ajustes razonables que requiera</strong>, y la discapacidad tampoco puede ser razón para expulsarlo. La Corte Constitucional lo hace cumplir por tutela: en la <a href="https://www.corteconstitucional.gov.co/relatoria/2025/T-133-25.htm" target="_blank" rel="noopener">sentencia T-133 de 2025</a> ordenó a un colegio actualizar el PIAR de un estudiante con una valoración pedagógica y social que identificara con claridad los apoyos y ajustes necesarios.</p>
<p>Pero quedarse en la ley es quedarse corto. La escuela es el primer lugar donde una sociedad ensaya cómo convive con la diferencia. Un niño que comparte el salón con un compañero sordo aprende que las personas no se dividen entre "normales" y "especiales", sino entre las que tienen los apoyos que necesitan y las que no.</p>
<p>Y estamos lejos. Según un análisis del Laboratorio de Economía de la Educación de la Universidad Javeriana con datos del SIMAT, en 2023 había <a href="https://www.portafolio.co/economia/colombia-tiene-200-334-estudiantes-con-discapacidad-pero-solo-el-2-llega-al-sistema-educativo-formal-495503" target="_blank" rel="noopener">200.334 estudiantes con discapacidad matriculados</a>, cerca del 2 % de la matrícula, y la asistencia escolar de niños y jóvenes con discapacidad era bastante menor que la del resto.</p>

<h2>Lo que la inclusión es y lo que no es</h2>
<p>Desde la psicología del desarrollo hay una idea que cambia la manera de mirar: la discapacidad no está solo en la persona, sino en la interacción entre sus características y las <strong>barreras</strong> del entorno. El Decreto 1421 lo recoge al hablar de barreras actitudinales, institucionales o de infraestructura que impiden aprender y participar.</p>
<ul>
<li><strong>No es integración.</strong> Integrar es sentar al estudiante en el salón y esperar que se adapte. Incluir es transformar el salón para que pueda aprender y participar.</li>
<li><strong>No es un currículo paralelo.</strong> El PIAR adapta el currículo común; no inventa otro para que el estudiante haga planas al fondo del aula.</li>
<li><strong>No es bajar la exigencia.</strong> Es cambiar el camino, el tiempo o la forma de demostrar lo aprendido, con metas altas y realistas.</li>
<li><strong>No depende de un diagnóstico.</strong> El decreto es explícito: los ajustes razonables no dependen de un diagnóstico médico, sino de las barreras que impiden el pleno goce del derecho a la educación.</li>
</ul>
<p>Muchos colegios se paralizan esperando "el papel del neurólogo" mientras el estudiante pierde meses. Para notar que un niño se desregula con el ruido o entiende todo con objetos no hace falta un diagnóstico, y se puede ajustar ese mismo día.</p>

<h2>Qué debe contener un PIAR para que sea efectivo</h2>
<p>El <strong>Plan Individual de Ajustes Razonables (PIAR)</strong> es, según el Decreto 1421, la herramienta que garantiza los procesos de enseñanza y aprendizaje del estudiante a partir de una valoración pedagógica y social, con los apoyos y ajustes que necesita para aprender, participar, permanecer y ser promovido. Como explica <a href="https://colombia.unir.net/actualidad-unir/que-es-piar/" target="_blank" rel="noopener">UNIR en su guía sobre qué es el PIAR</a>, no es un currículo aparte, sino la forma de contrastar el currículo con las características de cada estudiante para definir metas y apoyos del año.</p>
<p>Se elabora durante el <strong>primer trimestre del año escolar</strong>, se actualiza cada año, facilita la entrega pedagógica entre grados y hace parte de la historia escolar. Si el estudiante llega tarde, hay un máximo de treinta días para elaborarlo y firmar el acta.</p>
{$img('inclusion-piar', 747, 'Infografía con los nueve contenidos mínimos del PIAR según el Decreto 1421: contexto, valoración pedagógica, informes de salud, objetivos y metas, ajustes razonables, recursos, proyectos específicos, otras situaciones y actividades en casa, más el acta de acuerdo', 'Contenidos mínimos del PIAR según el artículo 2.3.3.5.2.3.5 del Decreto 1075 de 2015, incorporado por el Decreto 1421 de 2017.')}
<p>Traducido al lenguaje del aula, un PIAR que funciona tiene estas piezas:</p>
<ol>
<li><strong>Información general y del entorno.</strong> Con quién vive el estudiante, cómo llega al colegio, qué pasa en el recreo, qué apoyos tiene fuera. Un PIAR que no conoce el hogar planea para un estudiante imaginario.</li>
<li><strong>Valoración pedagógica.</strong> Es el corazón del documento y lo que más se descuida. Describe las dimensiones <strong>cognitiva, comunicativa, socioafectiva, corporal y de participación</strong>, y sobre todo <strong>fortalezas, gustos, intereses, motivaciones</strong> y <strong>barreras</strong> concretas. "Le cuesta concentrarse" no sirve; "atiende unos diez minutos en tareas escritas y más de media hora cuando construye con material concreto" sí, porque de ahí sale el ajuste.</li>
<li><strong>Soportes médicos o terapéuticos, si existen.</strong> Ayudan a definir ajustes, pero su ausencia <strong>no justifica no hacer el PIAR</strong>. El decreto ordena matricular sin diagnóstico y reportar el caso para que la secretaría de educación, con el sector salud, lo gestione.</li>
<li><strong>Objetivos y metas.</strong> Pocos, claros y medibles, conectados con los aprendizajes del grado: qué hará el estudiante, en qué condiciones y cómo sabremos que lo logró.</li>
<li><strong>Ajustes razonables y apoyos concretos</strong>, área por área: curriculares (priorizar aprendizajes esenciales), metodológicos (material concreto, apoyos visuales, instrucciones fragmentadas), de tiempos (más tiempo, pausas) y de evaluación (prueba oral, formatos accesibles, valorar el proceso). "Brindar apoyo" no es un ajuste.</li>
<li><strong>Recursos</strong> humanos (docente de apoyo, intérprete, orientador), físicos, tecnológicos y didácticos.</li>
<li><strong>Proyectos y compromisos:</strong> proyectos que incluyan a todo el grupo, actividades en casa para los recesos y tareas claras para cada parte.</li>
<li><strong>Acta de acuerdo</strong>, firmada por el acudiente, el directivo, el docente de apoyo y los docentes a cargo, cada uno con su copia. Recomiendo que el estudiante participe y firme cuando su edad lo permita: nadie se compromete con un plan que no conoce. El acta es, además, el instrumento con el que la familia hace veeduría.</li>
</ol>
<p>Sé lo que cuesta redactar todo esto cuando hay varios PIAR por grupo y cuarenta estudiantes en el salón. Por eso preparé en el sitio una herramienta, <a href="/herramientas/piar/">Plan de ajustes razonables (PIAR) con IA</a>, que convierte el contexto y la valoración que escribe el docente en un borrador formal con esta estructura, descargable en PDF, para revisarlo con el equipo. Es un punto de partida para ahorrar horas de redacción, no un reemplazo del criterio profesional ni de la conversación con la familia.</p>

<h3>Lista de verificación de un PIAR efectivo</h3>
<ul>
<li>Describe fortalezas e intereses antes que dificultades.</li>
<li>Nombra barreras del entorno, no solo características del estudiante.</li>
<li>Tiene metas medibles y fechas de revisión.</li>
<li>Cada ajuste es concreto, observable y tiene un área y un responsable.</li>
<li>Dice cómo se evaluará, no solo cómo se enseñará.</li>
<li>Se construyó con la familia y, cuando es posible, con el estudiante.</li>
<li>Tiene acta firmada y seguimiento ligado al sistema institucional de evaluación.</li>
<li>Se usa en el aula, no se archiva en coordinación.</li>
</ul>

<h2>Colegio, docente y familia: un triángulo que no puede cojear</h2>
<p>He visto PIAR impecables que nunca salieron de una carpeta y PIAR sencillos que cambiaron la vida de un estudiante. La diferencia estuvo en la relación entre los adultos.</p>
{$img('inclusion-triangulo', 653, 'Diagrama de un triángulo con el estudiante en el centro y tres vértices: colegio, docente y familia, unidos por acompañamiento, comunicación frecuente y acta y seguimiento', 'Cuando uno de los tres vértices falla, el plan se cae, por bien escrito que esté.')}
<p><strong>Al colegio</strong> le corresponde entender la inclusión como un asunto institucional y no del docente al que "le tocó" el estudiante: tiempo protegido para planear y hacer seguimiento, acompañamiento del <strong>docente de apoyo pedagógico</strong>, formación continua, ajustes al sistema de evaluación y los requerimientos del PIAR dentro del Plan de Mejoramiento Institucional. Donde no hay docente de apoyo, la secretaría de educación debe asesorar al colegio. Quien se prepara para el <a href="/concurso-docente/">Concurso Docente</a> como directivo debería dominar este tema, porque es gestión pura.</p>
<p><strong>Al docente de aula</strong> le corresponde observar con método, planear desde el Diseño Universal para el Aprendizaje, aplicar los ajustes y registrar qué funciona. Y cuidar el lenguaje: el estudiante no "es" un TDAH ni "el de inclusión"; es Camila, que tiene TDAH y dibuja como nadie.</p>
<p><strong>A la familia</strong> le corresponde aportar lo que el colegio no ve —la historia, lo que funciona en casa, lo que asusta al niño—, participar en el PIAR, sostener en casa las estrategias acordadas y exigir su cumplimiento. El decreto habla de <strong>corresponsabilidad</strong>: ni el colegio puede delegar todo en la familia ni la familia todo en el colegio.</p>
<p>Para cuidar esa relación, cinco hábitos que me han funcionado:</p>
<ul>
<li><strong>Empezar por lo que el estudiante sí hace.</strong> Una familia que espera quejas se defiende; una que escucha logros colabora.</li>
<li><strong>Acordar un canal y una frecuencia.</strong> Un cuaderno viajero o un mensaje quincenal evitan que solo se hable cuando hay problemas.</li>
<li><strong>Traducir el lenguaje técnico.</strong> "Ajuste evaluativo" se entiende mejor como "le haremos la prueba oral y con más tiempo".</li>
<li><strong>Reconocer el cansancio</strong> de familias que llevan años de terapias, trámites y rechazos.</li>
<li><strong>Cuidar las transiciones.</strong> De preescolar a primaria, de primaria a bachillerato y de un colegio a otro es donde más se pierde. El PIAR debe viajar con el estudiante y actualizarse en el nuevo contexto.</li>
</ul>

<h2>Buenas prácticas que sí funcionan en el aula</h2>
<h3>Diseño Universal para el Aprendizaje (DUA)</h3>
<p>El Decreto 1421 lo pone como base: el PIAR complementa lo que el aula ya transformó con el DUA. La idea, desarrollada por la organización estadounidense CAST, cuyas <a href="https://udlguidelines.cast.org/" target="_blank" rel="noopener">Pautas DUA</a> llegaron a la versión 3.0 en 2024, es planear desde el inicio varias formas de presentar la información, de expresar lo aprendido y de motivar. Con un aula bien diseñada, muchos ajustes individuales dejan de ser necesarios.</p>
{$img('inclusion-dua', 507, 'Tres columnas con los principios del DUA: múltiples formas de representación, de acción y expresión, y de implicación, cada una con ejemplos para el aula', 'Los tres principios del DUA. Un aula diseñada así reduce los ajustes individuales que hacen falta.')}
<h3>Coenseñanza</h3>
<p>Cuando el docente de apoyo enseña dentro del aula junto al titular, en estaciones o en grupos paralelos, y no solo saca al estudiante a otro espacio, el apoyo llega a todos.</p>
<h3>Tutoría entre pares y aprendizaje cooperativo</h3>
<p>El <a href="https://educationendowmentfoundation.org.uk/education-evidence/teaching-learning-toolkit/peer-tutoring" target="_blank" rel="noopener">Teaching and Learning Toolkit de la Education Endowment Foundation</a> ubica la tutoría entre pares y el aprendizaje colaborativo entre las estrategias de mayor impacto y menor costo, aunque advierte que los resultados dependen de cómo se implementen. Funcionan cuando los roles rotan, cuando el estudiante con discapacidad también enseña algo y cuando la tarea de verdad necesita a todos.</p>
<h3>Evaluación flexible</h3>
<p>Evaluar lo que se quiere evaluar, no las barreras. Si la meta es resolver problemas de proporcionalidad, leerle el enunciado en voz alta a un estudiante con dislexia no invalida nada. Los estudiantes con discapacidad reciben los mismos informes que todos y, si tuvieron ajustes en la evaluación, un informe anual de competencias o de proceso pedagógico.</p>
<h3>Clima de aula y regulación emocional</h3>
<p>Desde la psicología infantil lo repito siempre: un niño desregulado no aprende. Rutinas visibles, anticipar los cambios, un rincón de calma, pausas activas y una relación cálida previenen más crisis que cualquier sanción. Muchas conductas difíciles son comunicación: algo lo sobrepasa.</p>
<h3>Evitar las etiquetas</h3>
<p>Un diagnóstico describe, no define. Cuando se vuelve apodo, el estudiante actúa según la etiqueta. Y la información de salud es un dato sensible (Ley 1581 de 2012) que no se comparte sin autorización.</p>
<h3>Cuidar a quien cuida</h3>
<p>Ningún docente agotado sostiene un aula inclusiva. Formación práctica, tiempo para planear y espacios para hablar de los casos difíciles sin ser juzgado son condiciones, no lujos.</p>

<h2>Cómo lo hacen en Latinoamérica</h2>
<p>El <a href="https://igualdad.cepal.org/es/digital-library/global-education-monitoring-report-2020-latin-america-and-caribbean-inclusion-and" target="_blank" rel="noopener">Informe de Seguimiento de la Educación en el Mundo 2020 de la UNESCO para América Latina y el Caribe</a> concluyó que la región tiene leyes y políticas fuertes que demuestran compromiso con la inclusión, pero que la realidad diaria de los estudiantes muestra una implementación rezagada. Es lo que vivimos en Colombia. Algunos modelos vecinos:</p>
<ul>
<li><strong>Chile</strong> lleva educadores diferenciales a los colegios regulares con el <em>Programa de Integración Escolar</em> (PIE) y, con el <strong>Decreto 83 de 2015</strong>, adoptó el DUA para todos y reservó el plan individual (PACI) para cuando eso no basta.</li>
<li><strong>México</strong> tiene las <em>Unidades de Servicios de Apoyo a la Educación Regular</em> (USAER) y una <a href="https://www.uv.mx/rmipe/files/2022/05/Estrategia-nacional-de-educacion-inclusiva.pdf" target="_blank" rel="noopener">Estrategia Nacional de Educación Inclusiva</a> que, dentro de la Nueva Escuela Mexicana, se centra en eliminar las barreras para el aprendizaje y la participación.</li>
<li><strong>Argentina</strong> definió con la <a href="https://argentina.gob.ar/sites/default/files/anexo-ii-res-311-cfe-58add83aa4885.pdf" target="_blank" rel="noopener">Resolución 311 de 2016 del Consejo Federal de Educación</a> el <em>Proyecto Pedagógico Individual para la Inclusión</em> (PPI) y reglas de promoción y certificación.</li>
<li><strong>Perú</strong> apoya a los colegios regulares con los equipos SAANEE y en 2021 reforzó el enfoque inclusivo en el reglamento de su Ley General de Educación; <strong>Uruguay</strong> tiene desde 2017 un protocolo nacional de inclusión en los centros educativos, actualizado en 2022.</li>
</ul>
<p>Colombia no está atrás en normas. Lo que nos falta, como a buena parte de la región, son docentes de apoyo suficientes, mejor formación inicial y recursos continuos.</p>

<h2>Estados Unidos: IEP, plan 504 y ambiente menos restrictivo</h2>
<p>Según el <a href="https://nces.ed.gov/programs/coe/indicator/cgg/students-with-disabilities" target="_blank" rel="noopener">Centro Nacional de Estadísticas Educativas (NCES)</a>, en 2022-23 recibieron servicios bajo la ley IDEA 7,5 millones de estudiantes de 3 a 21 años, el 15 % de la matrícula pública, y más de dos tercios pasaban al menos el 80 % de la jornada en aulas regulares.</p>
<ul>
<li><strong>IEP (programa educativo individualizado):</strong> lo construye un equipo con los padres y los docentes; recoge el desempeño actual, metas anuales medibles, servicios y cómo se medirá el progreso, y se revisa al menos una vez al año.</li>
<li><strong>Plan 504:</strong> nace de la Sección 504 de la Ley de Rehabilitación de 1973 y da adaptaciones, como más tiempo o una ubicación distinta, sin modificar el currículo.</li>
<li><strong>Ambiente menos restrictivo (LRE):</strong> el estudiante se educa con sus pares tanto como sea posible; retirarlo del aula regular debe justificarse.</li>
<li><strong>MTSS o RTI:</strong> apoyos por niveles, de la buena enseñanza para todos a la intervención intensiva para pocos.</li>
</ul>
<p>Lo que vale copiar: metas medibles y niveles de apoyo. Lo que no: volver el diagnóstico una puerta obligatoria, justo lo que el Decreto 1421 quiso evitar.</p>

<h2>El resto del mundo: de Salamanca a Nuevo Brunswick</h2>
<p>En 1994, representantes de 92 gobiernos y 25 organizaciones internacionales firmaron la <a href="https://www.european-agency.org/sites/default/files/salamanca-statement-and-framework.pdf" target="_blank" rel="noopener">Declaración de Salamanca</a>, que planteó que las escuelas regulares con orientación inclusiva son el medio más eficaz para combatir las actitudes discriminatorias. La Convención de la ONU de 2006 lo volvió derecho y el Objetivo de Desarrollo Sostenible 4 lo puso en la agenda global.</p>
<ul>
<li><strong>Finlandia</strong> organiza el apoyo en tres niveles (general, intensificado y especial) y apuesta por la detección temprana dentro del colegio regular.</li>
<li><strong>Italia</strong> cerró las clases especiales a finales de los años setenta y educa a casi todos sus estudiantes con discapacidad en aulas comunes, con docente de apoyo y plan individualizado.</li>
<li><strong>Portugal</strong>, con el Decreto-Lei 54 de 2018, dejó de clasificar estudiantes por categorías y organizó medidas universales, selectivas y adicionales decididas por un equipo multidisciplinario.</li>
<li><strong>Nuevo Brunswick (Canadá)</strong>, con su <a href="https://www.allfie.org.uk/resources/inclusion-now/inclusion-now-47/transforming-educational-systems-lessons-new-brunswick/" target="_blank" rel="noopener">Política 322 de 2013</a>, prohibió las aulas segregadas por discapacidad y creó equipos de apoyo en cada escuela.</li>
</ul>
{$img('inclusion-mapa', 693, 'Cuatro tarjetas que resumen la inclusión educativa en Colombia, Latinoamérica, Estados Unidos y el mundo, con sus normas e instrumentos principales', 'Cuatro escalas de un mismo derecho. Colombia tiene buena norma; el reto es la implementación.')}

<h2>Comparación de los principales planes individuales</h2>
<table>
<thead><tr><th>Instrumento</th><th>Base</th><th>¿Exige diagnóstico?</th><th>Quién lo construye</th><th>Revisión</th></tr></thead>
<tbody>
<tr><td>PIAR (Colombia)</td><td>Decreto 1421 de 2017</td><td>No: los ajustes dependen de las barreras</td><td>Docentes de aula, docente de apoyo, familia y estudiante</td><td>Primer trimestre y actualización anual</td></tr>
<tr><td>IEP (EE. UU.)</td><td>Ley IDEA</td><td>Sí, una evaluación de elegibilidad</td><td>Equipo escolar con los padres</td><td>Al menos una vez al año</td></tr>
<tr><td>Plan 504 (EE. UU.)</td><td>Sección 504, Ley de Rehabilitación</td><td>Sí, que la condición limite una actividad importante</td><td>Equipo escolar</td><td>Periódica, según el distrito</td></tr>
<tr><td>PIE y PACI (Chile)</td><td>Decretos 170 de 2009 y 83 de 2015</td><td>El PIE requiere evaluación diagnóstica</td><td>Docente, educador diferencial y profesionales</td><td>Anual</td></tr>
<tr><td>EHCP (Inglaterra)</td><td>Ley de Niños y Familias de 2014</td><td>Requiere una evaluación de necesidades</td><td>Autoridad local con la familia y la escuela</td><td>Anual, de 0 a 25 años</td></tr>
</tbody>
</table>
<p>La tabla muestra una fortaleza colombiana poco valorada: el PIAR no condiciona los ajustes a un diagnóstico y obliga a construirlos con la familia y el estudiante.</p>

<h2>Inclusión con todo el grupo: los que no necesitan ajustes también cuentan</h2>
<p>El estudiante con PIAR no aprende en una burbuja: comparte el aula con treinta compañeros que observan, comparan y a veces reclaman.</p>
<h3>Explicar las diferencias sin exponer a nadie</h3>
<p>El diagnóstico de un estudiante le pertenece a él y a su familia. Nunca se anuncia al grupo; solo se habla de él si la familia y el estudiante lo deciden y lo preparan. Sí se puede hablar de la diversidad en general: todos aprendemos distinto, unos usamos gafas, otros necesitamos silencio. Cuando la conversación es sobre todos, nadie queda señalado.</p>
<h3>"Justo no es igual"</h3>
<p>Los estudiantes tienen un sentido agudo de la justicia, y un "¿por qué a él le dan más tiempo?" merece una respuesta honesta. La mía suele ser otra pregunta: "Si te rompes un brazo, ¿sería justo pedirte que escribas igual que los demás?". Ser justo es que cada uno reciba lo que necesita para llegar a la meta.</p>
{$img('inclusion-justo', 587, 'Tres viñetas con estudiantes de distintas estaturas frente a un tablero: igual, todos con el mismo apoyo; justo, cada uno con el apoyo que necesita; diseño para todos, el tablero se baja y nadie necesita apoyo', 'Igualdad, equidad y diseño universal. El objetivo es la tercera viñeta; el PIAR resuelve lo que todavía queda pendiente.')}
<h3>Hacer que los ajustes sean de todos</h3>
<p>El recurso más poderoso es ofrecer a todo el grupo lo que el PIAR pide para uno: instrucciones escritas en el tablero, opción de responder oralmente, audífonos para quien quiera concentrarse, tiempo extra para quien lo necesite. El ajuste deja de ser un privilegio visible y se vuelve una opción del aula.</p>
<h3>Lo que gana el resto del grupo</h3>
<p>La evidencia es tranquilizadora. Una revisión de 280 estudios de 25 países, preparada por Thomas Hehir y colegas para el Instituto Alana, encontró <a href="https://alana.org.br/wp-content/uploads/2017/08/educacao-inclusiva_espanhol.pdf" target="_blank" rel="noopener">evidencia clara y consistente</a> de que los entornos inclusivos pueden beneficiar a estudiantes con y sin discapacidad, que además desarrollan menos prejuicios. Un metaanálisis de Szumski, Smogorzewska y Karwowski con 47 estudios, publicado en 2017, halló un efecto <a href="https://doi.org/10.1016/j.edurev.2017.02.004" target="_blank" rel="noopener">positivo, aunque pequeño</a>, sobre el rendimiento académico de los compañeros sin necesidades educativas especiales. Incluir no atrasa a los demás.</p>
<p>La condición son los apoyos. Sin docente de apoyo ni plan de manejo, las crisis frecuentes afectan el clima de todos. La respuesta no es excluir, sino exigir los apoyos que la ley ya ordena.</p>
<h3>Manejar las inquietudes de los demás padres</h3>
<ul>
<li><strong>Escuchar sin descalificar:</strong> la preocupación por el aprendizaje de un hijo es legítima, aunque esté mal enfocada.</li>
<li><strong>Hablar del aula, no del niño:</strong> nunca se comparten datos de otro estudiante.</li>
<li><strong>Mostrar la evidencia</strong> y contar qué se está haciendo, por ejemplo un protocolo para las crisis.</li>
<li><strong>Recordar el marco legal con calma:</strong> la matrícula y los ajustes no son negociables.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es el PIAR?</h3>
<p>Es el Plan Individual de Ajustes Razonables que establece el Decreto 1421 de 2017 para los estudiantes con discapacidad en Colombia. Recoge su contexto, su valoración pedagógica, sus metas y los ajustes, apoyos y recursos que necesita para aprender y participar con su grupo.</p>
<h3>¿Se necesita un diagnóstico médico para hacer el PIAR?</h3>
<p>No. Los informes de salud ayudan, pero los ajustes razonables no dependen de un diagnóstico médico, sino de las barreras que enfrenta el estudiante. La falta de diagnóstico tampoco permite negar la matrícula.</p>
<h3>¿Quién elabora el PIAR y cuándo?</h3>
<p>Lo lideran los docentes de aula con el docente de apoyo, la familia y el estudiante; según la organización del colegio participan directivos y orientador. Se elabora en el primer trimestre del año escolar y se actualiza cada año.</p>
<h3>¿La inclusión perjudica a los demás estudiantes?</h3>
<p>La evidencia indica que no: las revisiones internacionales encuentran efectos neutros o levemente positivos sobre el rendimiento de los compañeros y beneficios sociales como menos prejuicios, siempre que la inclusión cuente con los apoyos necesarios.</p>

<h2>Conclusión</h2>
<p>La inclusión en el aula no se logra con un formato bien llenado ni con buena voluntad aislada. Se logra cuando el colegio organiza tiempos y apoyos, el docente planea para la diversidad desde el inicio, la familia participa como aliada y el grupo entiende que justo no es igual. Colombia tiene una de las normas más completas de la región; falta convertirla en práctica diaria, con docentes formados, docentes de apoyo suficientes y PIAR que se usen en el salón y no solo en la carpeta. Si te interesa esa discusión más amplia, mis análisis sobre las <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">pruebas PISA en América Latina</a> y el <a href="/proyecto-de-vida-colegio-docentes-caso-platzi/">proyecto de vida en el colegio</a> muestran otras caras de la misma pregunta, y en <a href="/aulamagica-ia-herramientas-ia-docentes/">AulaMágica IA</a> encontrarás más ideas de inteligencia artificial para el aula.</p>

<p class="notice"><strong>Prueba el Plan de ajustes razonables (PIAR) con IA.</strong> Ingresas el contexto del estudiante, seleccionas sus condiciones y los parámetros que necesitas, y obtienes un borrador formal y estructurado del PIAR, descargable en PDF, para revisarlo con tu equipo y con la familia. Tienes un PIAR gratis para probar y, si te sirve, paquetes mensuales de 5, 10 o 20 PIAR por 30.000, 50.000 u 80.000 pesos. La IA te ahorra horas de redacción; el criterio profesional y la voz de la familia siguen siendo insustituibles.</p>
<p><a class="btn-link" href="/herramientas/piar/">Probar el PIAR con IA</a></p>

<h2>Una pregunta para terminar</h2>
{$img('inclusion-pregunta', 480, 'Pregunta final: si el aula se diseñó para un estudiante promedio que nunca existió, quién necesita de verdad los ajustes, el estudiante o la escuela', 'La pregunta que queda abierta.')}
<p>En los años cincuenta, la Fuerza Aérea de Estados Unidos midió a miles de pilotos para diseñar la cabina del "piloto promedio" y descubrió que ninguno coincidía con el promedio en todas las medidas, como cuenta Todd Rose en <em>The End of Average</em>. La solución fueron los asientos y pedales ajustables. <strong>Si el aula se diseñó para un "estudiante promedio" que nunca existió, ¿quién necesita de verdad los ajustes: el estudiante o la escuela?</strong></p>
HTML,
];
