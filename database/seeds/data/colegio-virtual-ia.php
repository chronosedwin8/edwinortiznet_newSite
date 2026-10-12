<?php

declare(strict_types=1);

// "Colegio 100 % virtual con docentes 100 % IA": análisis crítico y primer artículo de un proyecto. Fuentes (12-oct-2026): MEN respuesta 2025-EE-300537 de 14-oct-2025 (presencialidad 5-15 años, sin establecimientos virtuales autorizados; Decreto 1075 art. 2.3.3.5.3.4.5; SRPA 70 %; Decreto 1421), Ley 115 art. 104, Decreto Ley 1278 art. 3, Ley 1581 art. 7 y C-781/11, Ley 2626 de 2026, CONPES 4144, Decálogo MEN 2026 (educación superior); OCDE TALIS 2024 Colombia (7-oct-2025) e Icfes (dic-2025); OECD DEO 2026; Bastani et al. PNAS 122(26) 2025 (+48 % práctica, -17 % examen); Kestin et al. Sci Rep 2025 (194 estudiantes); Banco Mundial Nigeria (800 estudiantes, ~0,3 DE); Tutor CoPilot arXiv 2410.03017 (+4 pp, $20); CREDO 2015 (-72/-180 días), NEPC 2021 (54,6 %); Chalkbeat 29-ene-2025; Dan Meyer 12-ago-2026 (fuente secundaria: 10 % mate / 28 % lectura); UNESCO 2023; Common Sense abril 2025; EU AI Act art. 5 y anexo III; DANE ECV 2025 vía MinTIC (73,9 % / 56,9 % rural). Libro verificado en Excel 16 y Python: matriz de 8 dimensiones x 3 escenarios (20,0 / 32,6 / 72,6; bloqueos 2/1/0). Encuesta propia de 5 preguntas (resources/polls). Puntajes: juicio propio.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/colegio-virtual-ia/' . $name;
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
<p>La pregunta suena a ciencia ficción, pero ya se hace en serio: <strong>¿se puede crear un colegio 100 % virtual, con docentes 100 % de inteligencia artificial, para estudiantes reales?</strong> Hay fundadores que lo proponen, ministerios que lo rechazan, familias que dudan y docentes que sienten que se les pregunta, en voz baja, si siguen haciendo falta. Este artículo no quiere ganar una discusión: quiere <strong>descomponer la pregunta</strong> y mirar cada parte con la evidencia disponible, con ojo crítico.</p>
<p>La respuesta corta, antes de entrar en detalle: <strong>hoy, en Colombia, no es legal; técnicamente se puede armar algo que parezca un colegio, pero la evidencia no respalda que funcione sin docentes humanos; y lo que sí muestra resultados prometedores es otra cosa: la IA como tutor, con un docente al lado.</strong> Entre una cosa y otra hay ocho dimensiones que conviene mirar: la técnica, la legal, la ética, la pedagógica, la social, la de inclusión, la económica y la de aceptación. Para ordenarlas, incluyo un <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">libro de Excel con una matriz de viabilidad</a> de tres escenarios, que puedes editar con tus propios criterios (verificado en Microsoft Excel 16 y contra un cálculo independiente), y al final una <a href="#encuesta">encuesta de cinco preguntas</a> para conocer tu opinión. Fuentes revisadas el <strong>12 de octubre de 2026</strong>.</p>
<p class="notice"><strong>Advertencia.</strong> Los puntajes de la matriz son <strong>mi juicio</strong> sobre la evidencia citada, no datos publicados. Marco con claridad lo que es dato, lo que es concepto oficial y lo que es opinión. La encuesta es abierta y anónima: no representa a nadie en particular.</p>

<h2>Primero, definir los términos</h2>
<p>Casi toda la discusión se enreda porque cada quien entiende algo distinto. Para este análisis separo tres escenarios:</p>
<ol>
<li><strong>Escenario 1 (el que se pregunta):</strong> colegio 100 % virtual, con docentes que son sistemas de IA, para niñas, niños y adolescentes reales. Ningún adulto responde por la enseñanza.</li>
<li><strong>Escenario 2:</strong> colegio virtual donde la IA tutoriza y los adultos son "guías" que motivan y acompañan (es, a grandes rasgos, el modelo de los colegios que hoy se citan).</li>
<li><strong>Escenario 3:</strong> colegio presencial con docentes humanos y un tutor de IA como apoyo del estudiante (el "docente aumentado").</li>
</ol>
<p>Cuando alguien dice "los colegios con IA ya funcionan", casi siempre habla de los escenarios 2 o 3. El escenario 1 es otra cosa, y es el que se pregunta.</p>

<h2>Lo que ya existe, visto con ojo crítico</h2>
<p>El ejemplo más citado es <strong>Alpha School</strong>, un colegio privado con sedes en Estados Unidos que afirma enseñar las materias básicas en unas dos horas diarias con software adaptativo, y dedicar el resto del día a talleres. Lo importante para esta discusión: <strong>no es virtual ni carece de adultos</strong>; los adultos se llaman "guías" y se encargan de motivar y apoyar. Sus cifras de aprendizaje (afirma que sus estudiantes crecen 2,6 veces más rápido que sus pares en pruebas MAP) son <strong>del propio colegio</strong>, según el análisis que publicó Dan Meyer, y no he encontrado una evaluación independiente.</p>
<p>Su proyecto hermano, <strong>Unbound Academy</strong>, sí es virtual. Pensilvania rechazó su solicitud de escuela cibernética el 29 de enero de 2025; según la cobertura de Chalkbeat, el estado dijo que el modelo de IA era "no probado", que no mostraba cómo se alinearía con los estándares académicos, que sus planes para estudiantes con discapacidad eran insuficientes y que ni siquiera incluía una lista de cursos. Arizona sí la aprobó para el año 2025-2026. Un análisis de Dan Meyer (12 de agosto de 2026) de la presentación pública de la junta del colegio reporta, para ese primer año, <strong>10 % de estudiantes en nivel de dominio en matemáticas</strong> (la solicitud proyectaba 60 % y el promedio estatal era 34 %) y 28 % en lectura y escritura (frente a 65 % proyectado y 42 % estatal). Es una fuente secundaria, de un solo año y no es una evaluación independiente: <strong>no demuestra que el modelo falle, pero tampoco respalda las promesas</strong>.</p>
{{img:existente}}
<p>En América Latina, mi búsqueda (12 de octubre de 2026) no encontró ningún colegio virtual gestionado por IA sin docentes en México, Brasil, Chile ni Colombia; lo que hay son programas de IA con docentes humanos, formación universitaria y observatorios. Eso respalda la idea de que es un tema <strong>sin evidencia local</strong>, pero "no lo encontré" no equivale a "no existe".</p>

<h2>Dimensión técnica: lo que la IA hace bien, lo que no y lo que se rompe sin un adulto</h2>
<ul>
<li><strong>Lo que hace bien:</strong> explicar un tema de varias maneras, generar ejercicios, dar retroalimentación inmediata, adaptar la dificultad y estar disponible a cualquier hora. En Colombia, los docentes que ya la usan lo hacen sobre todo para generar planes o actividades (80 %) y aprender de forma eficiente sobre un tema (79 %), según TALIS 2024.</li>
<li><strong>Lo que hace mal:</strong> se equivoca con seguridad (alucinaciones), puede reforzar sesgos y no sabe cuándo un estudiante necesita algo distinto a lo que pregunta. La OCDE (<em>Digital Education Outlook 2026</em>) advierte del riesgo de "pereza metacognitiva": cuando el estudiante delega el pensamiento, el rendimiento sube mientras la herramienta está y puede desaparecer cuando se retira.</li>
<li><strong>Lo que se rompe sin un adulto:</strong> alguien tiene que notar que un niño lleva tres días sin conectarse, que está triste, que sufre acoso o que llegó un mensaje que preocupa. En Colombia eso tiene un nombre: la ruta de atención integral para la convivencia escolar (Ley 1620 de 2013). Un sistema de IA no puede ser el adulto que responde.</li>
<li><strong>Infraestructura:</strong> el 73,9 % de los hogares colombianos tiene internet (ECV 2025 del DANE, citada por MinTIC) y en los hogares rurales es el 56,9 %. Y entre los docentes colombianos que no usaron IA, el 76 % dice que su colegio no tiene la infraestructura necesaria, frente a 37 % en el promedio OCDE (TALIS 2024).</li>
</ul>
<p><strong>Lectura crítica:</strong> técnicamente se puede construir el escenario 1 con herramientas de hoy; lo que no se puede es garantizar que sea seguro y de calidad sin supervisión humana.</p>

<h2>Dimensión legal: aquí está el primer bloqueo</h2>
<p>El Ministerio de Educación Nacional lo dijo con una claridad poco habitual en una respuesta oficial a una consulta ciudadana del <strong>14 de octubre de 2025</strong> (radicado 2025-EE-300537): la educación no presencial está prevista únicamente para personas adultas (en la modalidad semipresencial, con presencialidad no inferior al 50 % de las horas anuales, según el artículo 2.3.3.5.3.4.5 del Decreto 1075 de 2015), para estudiantes del Sistema de Responsabilidad Penal para Adolescentes (con al menos 70 % de presencialidad) y para estudiantes con discapacidad que, por sus circunstancias, necesitan una oferta hospitalaria o domiciliaria (Decreto 1421 de 2017). <strong>Fuera de esos casos, la presencialidad es obligatoria entre los 5 y los 15 años</strong> en preescolar, básica y media. Y añade: "hasta tanto no se reglamente la modalidad virtual para los niveles de educación preescolar, básica y media, las Secretarías de Educación (...) únicamente podrán autorizar la prestación del servicio educativo de manera presencial", por lo que "en la actualidad no existen establecimientos educativos, oficiales o no oficiales, autorizados para ofrecer el servicio educativo bajo la modalidad virtual". También precisa que las medidas de trabajo en casa de 2020 fueron excepcionales y temporales, no una autorización general.</p>
<p>Otras piezas del marco que pesan:</p>
<ul>
<li><strong>Licencia de funcionamiento.</strong> Para un colegio privado la expide la secretaría de educación certificada y, según el Decreto 3433 de 2008 (compilado en el Decreto 1075 de 2015), exige entre otros proyecto educativo, concepto sanitario, uso del suelo y condiciones de planta física. Un colegio sin sede no encaja en ese diseño.</li>
<li><strong>Quién es el educador.</strong> La Ley 115 de 1994 (art. 104) dice que "el educador es el orientador en los establecimientos educativos, de un proceso de formación, enseñanza y aprendizaje". El Estatuto de Profesionalización Docente (Decreto Ley 1278 de 2002, art. 3) define a los profesionales de la educación como personas con título de licenciado u otro título habilitante. Un sistema de IA no es una persona, no tiene título y no responde ante nadie.</li>
<li><strong>Datos de menores.</strong> La Ley 1581 de 2012 (art. 7) manda respetar los derechos prevalentes de niñas, niños y adolescentes y, según la Corte Constitucional (C-781 de 2011), solo permite tratar sus datos si responde a su interés superior; el Decreto 1074 de 2015 (art. 2.2.2.25.2.9) exige la autorización de su representante legal, tras escuchar al menor. Un colegio que procesa cada conversación de un menor con una IA maneja datos sensibles de forma continua.</li>
<li><strong>Contenidos de IA, no docentes de IA.</strong> La Ley 2626 de 2026 (24 de agosto) actualiza Tecnología e Informática para incorporar IA, programación y ciencia de datos y obliga al Ministerio a diseñar un programa de formación docente en seis meses; respeta la autonomía escolar y el derecho preferente de los padres (Constitución, art. 68). Es una ley para <em>enseñar sobre</em> IA, no para <em>enseñar con IA en lugar de docentes</em>. La Política Nacional de IA (CONPES 4144 de 2025) y el Decálogo de IA para la educación superior del Ministerio (2026) insisten en la ética, la gobernanza y "la preservación de la interacción humana como eje central de la formación" (el decálogo es para educación superior).</li>
</ul>
<p>En Europa, el Reglamento (UE) 2024/1689 prohíbe inferir emociones con biometría en centros educativos y clasifica como de alto riesgo la IA que evalúa resultados de aprendizaje (la aplicación de las obligaciones de alto riesgo se está escalonando: verifica el calendario vigente). Es una señal de por dónde va la regulación donde ya se legisló.</p>
<p><strong>Lectura crítica:</strong> el escenario 1 (y el 2, por ser virtual) chocan hoy con la norma. Un concepto del Ministerio no es una ley, pero refleja cómo se está leyendo el Decreto 1075. Cambiarlo exigiría reglamentar la modalidad virtual para menores, y eso es una decisión de política pública, no de un emprendedor.</p>

<h2>Dimensión ética: quién responde cuando algo sale mal</h2>
<ul>
<li><strong>Responsabilidad.</strong> Si una IA da una orientación equivocada a un adolescente, ¿quién responde? En un colegio, la cadena es clara: docente, coordinación, rectoría, secretaría. En el escenario 1 no hay un adulto en esa cadena.</li>
<li><strong>Consentimiento informado.</strong> ¿Aceptarían las familias un experimento con sus hijos? Un diseño responsable debe decir qué se mide, qué riesgos hay y cómo se sale.</li>
<li><strong>Vínculo emocional.</strong> En abril de 2025, Common Sense Media calificó como "inaceptables" para menores de 18 años los compañeros sociales de IA (Character.AI, Replika, Nomi y similares), tras encontrar que afirman tener emociones y ofrecen respuestas dañinas. No es la misma categoría que un tutor escolar y no encontré una evaluación equivalente de tutores, pero <strong>un "profe" que te conoce, te elogia y siempre está disponible comparte rasgos con esos productos</strong>, y por eso exige evaluación específica.</li>
<li><strong>Vigilancia.</strong> Medir atención con cámara, o inferir emociones, es una práctica que la ley europea prohíbe en centros educativos. Algunos reportajes sobre colegios con IA han descrito monitoreo por cámara (el colegio citado disputa parte de esa cobertura); la discusión es real.</li>
<li><strong>Edad.</strong> La UNESCO (2023) propone fijar una edad mínima para las conversaciones independientes de estudiantes con plataformas de IA generativa (se suele citar 13 años) y un enfoque centrado en lo humano con validación ética y pedagógica previa.</li>
</ul>

<h2>Dimensión pedagógica: lo que dice la evidencia (a favor y en contra)</h2>
<p>Aquí hay que ser honesto con los dos lados. La IA como tutor tiene resultados reales:</p>
<ul>
<li><strong>Harvard (Kestin et al., <em>Scientific Reports</em>, 2025):</strong> 194 estudiantes de un curso de física aprendieron un tema con un tutor de IA diseñado con cuidado y otro con una clase activa: con el tutor, aprendieron más del doble en menos tiempo. El propio autor dijo que no lo ve como un argumento para reemplazar la interacción humana.</li>
<li><strong>Nigeria (Banco Mundial, 2024-2025):</strong> 800 estudiantes de secundaria, seis semanas de tutoría de inglés con Copilot, <strong>con docentes mediando</strong> la sesión: mejora de cerca de 0,3 desviaciones estándar. El Banco Mundial lo traduce a casi dos años de aprendizaje típico (una conversión que conviene leer con cautela) y reconoce que no se conocen los efectos a largo plazo ni los negativos.</li>
<li><strong>Tutor CoPilot (Wang et al., 2024):</strong> en un ensayo aleatorizado con 900 tutores y 1.800 estudiantes, una IA que <em>ayuda a tutores humanos</em> aumentó en 4 puntos porcentuales el dominio de los temas (9 con los tutores peor valorados), a unos 20 dólares por tutor al año.</li>
</ul>
<p>Y también hay evidencia de daño cuando la IA se usa sin criterio:</p>
<ul>
<li><strong>Bastani et al. (<em>PNAS</em>, 2025):</strong> en casi mil estudiantes de secundaria en Turquía, el acceso a GPT-4 sin guías subió el desempeño en la práctica (+48 %), pero cuando se retiró, los estudiantes sacaron <strong>17 % menos que quienes nunca la tuvieron</strong>. Con un tutor con salvaguardas (pistas en lugar de respuestas), el daño se mitigó en gran parte.</li>
<li><strong>Escuelas virtuales (sin IA).</strong> CREDO (2015) estimó que los estudiantes de colegios virtuales <em>charter</em> aprendían el equivalente a 72 días menos en lectura y 180 días menos en matemáticas que pares comparables (con un método discutido); el informe de NEPC (2021) contó 477 escuelas virtuales de tiempo completo con 332.379 estudiantes y una graduación de 54,6 %, frente a 85 % nacional. Es evidencia sobre la <em>modalidad</em> virtual, no sobre la IA, pero el escenario 1 la hereda.</li>
</ul>
<p><strong>Lectura crítica.</strong> Los estudios favorables son <strong>cortos</strong> (semanas), de <strong>una materia</strong>, con estudiantes motivados o con docentes alrededor, y casi siempre miden contenido estructurado. Ninguno prueba un colegio completo durante años sin docentes humanos. La conclusión más sólida es esta: <strong>la IA ayuda cuando está diseñada para hacerte pensar y hay un adulto que la integra; perjudica cuando te da la respuesta</strong>. Es la misma lección que la <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">guía del uso de la IA en educación</a> y que <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">el artículo sobre ampliar o reemplazar el pensamiento del estudiante</a>.</p>

<h2>¿Se pueden adquirir habilidades y competencias con IA?</h2>
<p>Es la pregunta central y todavía no tiene respuesta completa, ni en Colombia ni en la región. Una competencia es más que información: es saber, saber hacer y actuar con criterio <em>en una situación real</em>. Con la evidencia actual, mi lectura es esta:</p>
<table>
<thead><tr><th>Tipo de aprendizaje</th><th>Qué dice la evidencia</th><th>Confianza</th></tr></thead>
<tbody>
<tr><td>Conocimiento y procedimientos en áreas estructuradas (matemáticas, física, idiomas)</td><td>Resultados favorables con tutores bien diseñados, en estudios cortos</td><td>Media</td></tr>
<tr><td>Metacognición y aprender a aprender</td><td>Posible con andamiaje; sin él, aparece la "pereza metacognitiva"</td><td>Baja a media</td></tr>
<tr><td>Transferencia a situaciones nuevas, creatividad</td><td>Poca evidencia; los estudios miden sobre todo desempeño inmediato</td><td>Baja</td></tr>
<tr><td>Habilidades socioemocionales (empatía, convivencia, colaboración)</td><td>No hay evidencia de que la IA las enseñe; se desarrollan con otras personas</td><td>Muy baja</td></tr>
<tr><td>Juicio ético y ciudadanía</td><td>No hay evidencia; exige deliberar con otros y vivir la comunidad</td><td>Muy baja</td></tr>
</tbody>
</table>
<p>El contraste con lo humano es claro en los datos de Colombia: según TALIS 2024, el 97 % de los docentes dice que estudiantes y docentes se llevan bien en su colegio, el 83 % se siente valorado por los estudiantes y el 80 % cree poder apoyar el aprendizaje socioemocional "bastante" o "mucho". <strong>Esa red de relaciones es justo lo que el escenario 1 no puede ofrecer.</strong> Por eso la pregunta honesta no es "¿la IA enseña?" sino "¿qué enseña bien, qué enseña mal y quién cubre el resto?".</p>
{{img:dimensiones}}

<h2>Dimensión social, de inclusión y de interacción</h2>
<ul>
<li><strong>Socialización.</strong> La escuela no es solo instrucción: es donde se aprende a negociar, a esperar turno, a convivir con quien es distinto. Un colegio totalmente virtual con tutores de IA reduce al mínimo la interacción entre pares y con adultos de referencia.</li>
<li><strong>Estudiantes con discapacidad.</strong> El Ministerio afirma en la misma respuesta de 2025 que la educación virtual no está reglamentada "para ningún estudiante desde la diversidad". El Decreto 1421 de 2017 obliga a ajustes razonables y al PIAR (ver <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusión en el aula y el PIAR</a>), y Pensilvania señaló como una de sus razones de rechazo que los planes para estudiantes con discapacidad eran insuficientes. La IA puede ser un excelente apoyo (el 60 % de los docentes colombianos que la usan la emplean para apoyar a estudiantes con necesidades educativas especiales, según TALIS), pero <strong>como herramienta de un equipo humano, no como sustituto</strong>.</li>
<li><strong>Equidad.</strong> Con 56,9 % de hogares rurales con internet, un colegio virtual puede ampliar el acceso a quien hoy no tiene colegio cerca, pero también excluir a quien no tiene conectividad, dispositivo ni un adulto que supervise en casa. Las familias que sí pueden pagar un buen acompañamiento obtendrían resultados mejores: la brecha podría crecer.</li>
</ul>

<h2>Visión de futuro y pertinencia: dónde sí puede tener sentido</h2>
<p>Decir "no" al escenario 1 no es decir "no" a la IA. La UNESCO calcula que el mundo necesita <strong>44 millones de docentes más para 2030</strong>; hay lugares donde no hay docentes y donde una tutoría de IA, con apoyo humano a distancia, sería mejor que nada. Algunas rutas que la evidencia respalda más:</p>
<ul>
<li><strong>Tutor de IA con docente presente</strong> (escenario 3): refuerzo, práctica y retroalimentación inmediata, con el docente decidiendo cuándo y para qué.</li>
<li><strong>Educación de personas adultas</strong>, donde la norma ya permite modalidades semipresenciales o a distancia.</li>
<li><strong>Zonas con escasez de docentes</strong>, como complemento supervisado y no como reemplazo, y pidiendo a la secretaría de educación un permiso expreso para un piloto.</li>
<li><strong>IA que ayuda al docente</strong> (planear, adaptar materiales, dar retroalimentación): es el uso más extendido hoy entre los docentes colombianos.</li>
</ul>
<p>La pertinencia, en suma, está en <strong>redefinir el rol del docente</strong> (menos transmitir, más diagnosticar, acompañar, evaluar el proceso), no en eliminarlo. El propio Alpha, el modelo más citado, conserva adultos en el centro del diseño.</p>

<h2>El miedo a lo desconocido: docentes, familias y sistema educativo</h2>
<p>Este es probablemente el obstáculo menos técnico y más decisivo. Los miedos no son un defecto de quien los siente: <strong>son información</strong>. Algunos tienen base, otros son inercia, y conviene separarlos.</p>
<table>
<thead><tr><th>Quién</th><th>Qué teme</th><th>Qué hay de cierto</th><th>Qué lo reduce</th></tr></thead>
<tbody>
<tr><td>Docentes</td><td>Ser reemplazados; perder el vínculo; ser vigilados por la plataforma</td><td>Ninguna evidencia respalda que un tutor reemplace al docente; sí existe riesgo de vigilancia y de más carga si el sistema "gestiona" al docente</td><td>Participar en el diseño, formación con tiempo reconocido y reglas claras sobre datos de docentes</td></tr>
<tr><td>Familias</td><td>Que sus hijos no socialicen; que los datos se usen mal; que el título no valga</td><td>Los tres son riesgos reales: sin autorización oficial no hay título válido</td><td>Piloto autorizado, consentimiento informado, transparencia sobre datos y derecho de salida</td></tr>
<tr><td>Estudiantes</td><td>Aislarse; sentirse evaluados por una máquina</td><td>La interacción humana es parte de lo que valoran; los tutores de IA gustan por la inmediatez</td><td>Espacios humanos de trabajo y evaluación con criterios conocidos</td></tr>
<tr><td>Sistema educativo</td><td>Perder el control de calidad; que se abra la puerta a negocios sin evidencia</td><td>Fundado: no hay evidencia de largo plazo y las cifras de los colegios son propias</td><td>Evaluación independiente, sandbox regulatorio y publicación de resultados</td></tr>
</tbody>
</table>
<p>Un dato de Colombia ayuda a no dramatizar: según TALIS 2024, el 53 % de los docentes ya usó IA en el último año, más que el promedio de la OCDE (36 %) y a la par de Brasil (56 %), Chile (55 %) y Costa Rica (52 %). <strong>El problema no es una docencia que se niega a cambiar</strong>: es una docencia que quiere usar la IA y se encuentra con colegios sin infraestructura (76 % entre quienes no la usaron) y sin formación accesible (el 70 % dice que la formación es demasiado cara). Hablo más de esto en <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">la IA no te reemplazará, quien la domine, sí</a>.</p>

<h2>La matriz de viabilidad (con tus propios criterios)</h2>
<p>El <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">libro de Excel</a> reúne las ocho dimensiones, un peso para cada una (1 a 3), un puntaje de 0 a 5 para cada escenario y una regla de <strong>bloqueo</strong>: si una dimensión marcada como bloqueante (la legal y la ética de datos, en mi versión) queda en 1 o menos, el escenario no puede avanzar, sin importar su promedio. La hoja <em>Evidencia</em> lista las fuentes que sustentan cada puntaje.</p>
{{img:matriz}}
<pre><code>' Puntaje ponderado (0 a 100) del escenario 1 (columna D de la hoja Matriz)
=SUMAPRODUCTO(Matriz!$B$4:$B$11;Matriz!D$4:D$11)/(SUMA(Matriz!$B$4:$B$11)*Parametros!$B$3)*100     ' español
=SUMPRODUCT(Matriz!$B$4:$B$11,Matriz!D$4:D$11)/(SUM(Matriz!$B$4:$B$11)*Parametros!$B$3)*100        ' inglés

' Dimensiones bloqueantes en riesgo: bloqueantes con puntaje igual o menor al umbral
=SUMAPRODUCTO((Matriz!$C$4:$C$11="Sí")*(Matriz!D$4:D$11<=Parametros!$B$4))                          ' español
=SUMPRODUCT((Matriz!$C$4:$C$11="Sí")*(Matriz!D$4:D$11<=Parametros!$B$4))                             ' inglés</code></pre>
<p>Resultados con mis puntajes: <strong>escenario 1, 20 sobre 100 (bloqueado por la dimensión legal y la ética de datos); escenario 2, 33 (bloqueado por el marco legal); escenario 3, 73 (viable)</strong>. Si pones la dimensión legal del escenario 3 en 0, el libro lo marca como bloqueado: la regla funciona igual para todos. <strong>Una lectura honesta:</strong> los números condensan opiniones. Úsalos para discutir <em>por qué</em> pones cada puntaje, no para ganar una discusión. Si crees que la evidencia pedagógica del escenario 1 vale más que 1, cámbiala: verás que el bloqueo legal sigue ahí.</p>

<h2>Un piloto responsable: cómo empezar sin apostar con los niños</h2>
<p>Si el objetivo es iniciar un proyecto, el punto de partida no es abrir el colegio, sino <strong>hacer la pregunta correcta de la forma menos riesgosa</strong>. Mi propuesta, para discutir:</p>
{{img:piloto}}
<ol>
<li><strong>Una pregunta de investigación concreta,</strong> por ejemplo: ¿un tutor de IA con andamiaje, usado dos horas semanales en matemáticas de grados séptimo y octavo, mejora el aprendizaje sin reducir la convivencia?</li>
<li><strong>Escenario 3, no el 1.</strong> Docente humano presente, tutor de IA como apoyo, grupo pequeño, con grupo de comparación.</li>
<li><strong>Permiso y consentimiento.</strong> Secretaría de educación, PEI y SIEE al día, y consentimiento informado de las familias, con derecho de salida sin consecuencias.</li>
<li><strong>Datos mínimos.</strong> Sin nombres en las herramientas externas, contrato con el proveedor, retención limitada y tratamiento conforme a la Ley 1581.</li>
<li><strong>Medidas definidas de antemano:</strong> aprendizaje con la IA y <em>sin</em> la IA, a las pocas semanas y a los seis meses (retención), bienestar y convivencia, asistencia y equidad entre grupos.</li>
<li><strong>Criterios de parada:</strong> si el aprendizaje sin IA baja, si aumenta la dependencia o si aparece un daño, se detiene.</li>
<li><strong>Evaluación externa</strong> (una universidad o el Icfes, por ejemplo) y <strong>publicación de todos los resultados, también los negativos</strong>.</li>
<li><strong>Solicitar un sandbox regulatorio.</strong> Si algún día se quiere probar una modalidad virtual para menores, debe ser mediante un espacio de experimentación autorizado por el Ministerio, no por la vía de los hechos.</li>
</ol>
<p>Esa ruta responde a lo que Pensilvania echó de menos (evidencia, alineación con estándares, plan para estudiantes con discapacidad y apoyo sostenible) y a lo que pide la UNESCO (enfoque centrado en lo humano, validación ética y pedagógica).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p><strong>Colombia:</strong> el Ministerio no autoriza hoy colegios virtuales para menores; los docentes ya usan IA (53 %) y piden formación (el Icfes reporta que 78 % manifiesta necesidad de formación en IA; la OCDE, con un criterio más estricto, que 43 % tiene una "alta necesidad"); la Ley 2626 de 2026 abre la puerta a enseñar IA, no a que enseñe en lugar de docentes. <strong>Latinoamérica:</strong> Brasil, Chile, Costa Rica y Colombia superan el promedio de la OCDE en uso docente de IA, y no encontré colegios 100 % IA; el debate está empezando. <strong>El mundo:</strong> Estados Unidos es el laboratorio de los modelos comerciales (con rechazos y aprobaciones divididas entre estados), la Unión Europea regula con fuerza la IA en educación y la UNESCO pide un enfoque humano y edades mínimas.</p>
<p>Para los <strong>docentes</strong>, el reto es ser parte del diseño y no su objeto; para los <strong>directivos</strong>, decidir qué se prueba, con qué permiso y con qué datos; para las <strong>familias</strong>, exigir evidencia y consentimiento, no promesas; y para los <strong>estudiantes</strong>, que su voz cuente: son quienes viven la experiencia.</p>

<h2>Tu opinión cuenta: una encuesta de cinco preguntas</h2>
<p>Este artículo abre una conversación sobre una pregunta que en América Latina todavía no tiene respuesta. Para saber por dónde seguir, quiero conocer tu opinión. La encuesta es <strong>anónima</strong>, no guarda tu nombre, correo ni IP, y puedes ver los resultados al responder. Recuerda que refleja a quienes deciden contestar: es una conversación, no una estadística.</p>
{{encuesta:colegio-virtual-ia}}

<h2>Herramientas y recursos</h2>
<p>Si quieres explorar la IA como apoyo del docente (planeación, material y evaluación), con la revisión humana siempre presente y sin ingresar datos de estudiantes en herramientas que no estén hechas para custodiarlos, mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">el libro de la matriz de viabilidad</a>, <a href="/educacion-virtual-vs-presencial-colombia-datos/">educación virtual frente a presencial en Colombia</a>, <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">celulares en el colegio: prohibir no basta, hay que enseñar</a>, y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (12 de octubre de 2026)</h2>
<ul>
<li><strong>Ministerio de Educación Nacional,</strong> respuesta oficial 2025-EE-300537 (14 de octubre de 2025) y <a href="https://www.mineducacion.gov.co/1621/article-179304.html">orientaciones sobre licencias de funcionamiento</a>; Decreto 1075 de 2015 (arts. 2.3.3.5.3.4.5 y 2.3.3.5.8.5.4), Decreto 3433 de 2008, Decreto 1421 de 2017, Ley 115 de 1994 (art. 104), Decreto Ley 1278 de 2002, Ley 1581 de 2012 (art. 7) y Decreto 1074 de 2015, Ley 1620 de 2013, Ley 2626 de 2026, CONPES 4144 de 2025 y Decálogo de IA para la educación superior (MEN, 2026).</li>
<li><strong>OCDE,</strong> <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2025/10/results-from-talis-2024-country-notes_eafd703e/colombia_04c7b413/8f1df220-en.pdf">Results from TALIS 2024: Colombia</a> (7 de octubre de 2025); Icfes, <a href="https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf">Usos, percepciones y desafíos en la integración de la IA por los docentes en Colombia</a> (diciembre de 2025); OCDE, <a href="https://digital-skills-jobs.europa.eu/en/latest/news/oecd-digital-education-outlook-2026-how-generative-ai-can-support-learning-when-used">Digital Education Outlook 2026</a>.</li>
<li><strong>Bastani et al. (2025),</strong> <a href="https://www.pnas.org/doi/10.1073/pnas.2422633122">"Generative AI without guardrails can harm learning"</a>, <em>PNAS</em> 122(26); <strong>Kestin et al. (2025),</strong> "AI tutoring outperforms in-class active learning", <em>Scientific Reports</em>; <strong>Wang et al. (2024),</strong> <a href="https://arxiv.org/abs/2410.03017">Tutor CoPilot</a>; Banco Mundial, <a href="https://blogs.worldbank.org/en/education/From-chalkboards-to-chatbots-Transforming-learning-in-Nigeria">From chalkboards to chatbots</a> (Nigeria).</li>
<li><strong>CREDO (2015)</strong> y <a href="https://fordhaminstitute.org/national/commentary/virtual-charter-school-students-are-not-learning-nearly-enough">comentario del Fordham Institute</a>; <a href="https://www.nepc.colorado.edu/node/10899">NEPC, Virtual Schools in the U.S. 2021</a>.</li>
<li><strong>Chalkbeat,</strong> <a href="https://chalkbeat.org/philadelphia/2025/01/29/pennsylvania-rejects-ai-cyber-charter-school-unbound-academy-application">Pensilvania rechaza Unbound Academy</a> (29 de enero de 2025); Dan Meyer, <a href="https://danmeyer.substack.com/p/does-alpha-school-work-for-regular">Does the Alpha School model work for regular kids?</a> (12 de agosto de 2026; fuente secundaria, con datos de la junta del colegio).</li>
<li><strong>UNESCO,</strong> <a href="https://www.unesco.org/en/articles/guidance-generative-ai-education-and-research">Guidance for generative AI in education and research</a> (2023) y datos de la escasez docente (44 millones para 2030); <strong>Common Sense Media</strong> (abril de 2025), evaluación de compañeros sociales de IA; Reglamento (UE) 2024/1689, art. 5 y anexo III; <strong>MinTIC/DANE,</strong> <a href="https://www.mintic.gov.co/portal/715/w3-article-437305.html">conectividad de hogares (ECV 2025)</a>.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Es legal un colegio 100 % virtual en Colombia?</h3>
<p>Para preescolar, básica y media, no: según el Ministerio (14 de octubre de 2025), la presencialidad es obligatoria entre los 5 y los 15 años y no hay establecimientos autorizados para ofrecer el servicio en modalidad virtual. Las excepciones son adultos, el sistema de responsabilidad penal para adolescentes y estudiantes con discapacidad en oferta hospitalaria o domiciliaria.</p>
<h3>¿Existe algún colegio sin docentes humanos?</h3>
<p>Los modelos más citados (Alpha School y Unbound Academy) usan adultos como "guías" que motivan y acompañan. No encontré un colegio con evidencia que funcione sin ningún adulto responsable.</p>
<h3>¿La IA puede enseñar mejor que un docente?</h3>
<p>En estudios cortos y de una materia, un tutor de IA bien diseñado logró buenos resultados (por ejemplo, en Harvard y en Nigeria). Pero los autores no lo presentan como reemplazo del docente, y otros estudios muestran que, sin guías, la IA puede perjudicar el aprendizaje.</p>
<h3>¿Se pueden aprender competencias con IA?</h3>
<p>Hay evidencia para conocimientos y procedimientos en áreas estructuradas; es poca para transferencia y creatividad, y no hay evidencia de que la IA enseñe habilidades socioemocionales o juicio ético, que se desarrollan con otras personas.</p>
<h3>¿Cómo uso el libro de Excel?</h3>
<p>Edita los pesos (1 a 3) y los puntajes (0 a 5) de cada escenario; el libro calcula el puntaje ponderado, cuántas dimensiones bloqueantes están en riesgo, la dimensión más débil y una lectura final.</p>

<p class="notice"><strong>Participa.</strong> Descarga el <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">libro de la matriz</a>, discútelo con tu comunidad educativa y responde la <a href="#encuesta">encuesta</a>.</p>

<h2>Para pensar</h2>
<p>Una escuela es más que un lugar donde se transmiten contenidos: es un sitio donde alguien responde por ti. <strong>Si una IA pudiera explicar mejor que cualquiera de tus docentes, ¿qué seguirías necesitando de una persona para considerar que estás en una escuela? Y si fueras quien decide un piloto, ¿qué resultado te haría detenerlo, aunque los puntajes de las pruebas fueran buenos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:existente}}' => $img('colegio-virtual-ia-existente', 633, 'Comparación entre lo que existe (Alpha School presencial con guías humanos, Unbound Academy virtual con guías y rechazada en Pensilvania, cifras propias) y lo que se pregunta (100 % virtual, docentes 100 % IA, sin evidencia equivalente).', 'Los modelos de hoy no son el escenario que se pregunta.'),
    '{{img:dimensiones}}' => $img('colegio-virtual-ia-dimensiones', 717, 'Tabla de ocho dimensiones con su obstáculo principal y la lectura del escenario 1: legal bloqueada, técnica débil, ética y datos bloqueada, pedagógica débil, socioemocional débil, inclusión débil, costo favorable y aceptación débil.', 'Cada dimensión tiene su propio obstáculo.'),
    '{{img:matriz}}' => $img('colegio-virtual-ia-matriz', 392, 'Gráfico de barras con el puntaje ponderado de tres escenarios: 100 % virtual con docentes IA 20, virtual con guías humanos y tutor IA 33, y presencial con docentes humanos y tutor IA 73.', 'Matriz de viabilidad: puntajes de mi juicio.'),
    '{{img:piloto}}' => $img('colegio-virtual-ia-piloto', 467, 'Cinco pasos de un piloto responsable: pregunta, permiso, piloto pequeño con docente humano y tutor IA, medición de aprendizaje, bienestar y equidad, y decisión con publicación de todos los resultados.', 'Cómo empezar sin apostar con los niños.'),
]);

return [
    'slug' => 'colegio-100-virtual-docentes-100-ia-analisis-critico-legal-etico-pedagogico',
    'title' => '¿Se puede crear un colegio 100 % virtual con docentes 100 % de IA para estudiantes reales? Un análisis crítico',
    'excerpt' => 'Ocho dimensiones (técnica, legal, ética, pedagógica, social, de inclusión, económica y de aceptación), la evidencia a favor y en contra, lo que dice el Ministerio de Educación, el miedo de docentes y familias, una matriz en Excel y una encuesta.',
    'seo_title' => 'Colegio 100 % virtual con docentes IA: análisis crítico',
    'seo_description' => '¿Se puede crear un colegio virtual con docentes de IA? Análisis legal (Colombia), técnico, ético y pedagógico, con evidencia, matriz en Excel y encuesta.',
    'focus_keyword' => 'colegio virtual con docentes de IA',
    'cover' => '/assets/img/articulos/colegio-virtual-ia/colegio-virtual-ia-portada',
    'cover_alt' => 'Portada "¿Un colegio 100 % virtual con docentes 100 % IA? Un análisis crítico antes de empezar" con una tarjeta de lo que sabemos hoy: no es legal en Colombia, no hay evidencia a largo plazo, la IA sirve como tutor y se puede probar con docentes.',
    'published_at' => '2026-10-19 12:00:00',
    'content_html' => $html,
];
