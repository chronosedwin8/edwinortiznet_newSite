<?php

declare(strict_types=1);

// "Guía sobre el uso de la IA en el ámbito educativo". Fuentes (10-oct-2026): UNESCO 2023 (7-sep) y marco de competencias docentes 2024 (15 competencias, 5 dimensiones); Ley 2626 de 2026 (texto completo leído, Régimen Legal de Bogotá; arts. 1-5, 7-9, 14); convocatoria IAprende (MinTIC/CPE, abril 2026, vía resúmenes); Bastani et al. PNAS 2025 (~1.000 estudiantes; +48 %/-17 %; +127 %/igual); Kestin et al. Sci. Reports 2025 (n=194; >2x; 49 vs 75 min, vía resúmenes); OCDE Digital Education Outlook 2026 (vía resúmenes; página 403); AIAS v1 de Furze (5 niveles, blog); Liang et al. Patterns 2023; Ley 1581 y Ley de IA de la UE como referencias generales con aviso de verificar. Libro verificado en Excel 16 y Python: 12 tareas ficticias, niveles 3/2/3/3/1, 9 con IA (75 %), 2 desalineadas, 2 sin declaración, 5 sin evidencia.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-en-educacion/' . $name;
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
<p>Un estudiante entrega un ensayo impecable. La docente sospecha, lo confronta, el estudiante lo niega, la familia reclama, el detector de IA dice "87 % generado" y nadie sabe qué hacer con ese número. En otra aula, una docente usa una IA para preparar la clase, generar tres versiones de un ejercicio y escribir comentarios a los trabajos, y termina la semana con tiempo para atender a los estudiantes que más lo necesitan. Las dos escenas ocurren hoy en colegios colombianos, y la diferencia entre ellas no está en la herramienta: está en <strong>qué decisiones se tomaron antes de usarla</strong>.</p>
<p>Esta es una guía para esas decisiones. No es un tutorial de herramientas (cambian cada mes), sino un mapa: qué dice la evidencia sobre cuándo la IA ayuda a aprender y cuándo solo ayuda a aparentar, qué marco normativo y de políticas existe en Colombia y en el mundo, cómo decidir <strong>cuánta IA admite cada tarea</strong>, qué hacer con los datos de los estudiantes y cómo implementarlo en un colegio. Incluye un <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">libro de Excel</a> que convierte la decisión en una matriz por tarea (con un curso ficticio de doce tareas), verificado en Microsoft Excel 16 y contra un cálculo independiente. Fuentes revisadas el <strong>10 de octubre de 2026</strong>.</p>
<p class="notice"><strong>Alcance.</strong> Es una guía de criterio profesional, no asesoría jurídica ni una política oficial. Los estudios citados son concretos (una edad, un curso, un país) y sus resultados no se pueden extrapolar sin cuidado. Las normas cambian: verifica el texto vigente y las orientaciones de tu secretaría de educación. Los datos del libro son ficticios.</p>

<h2>Principio 1: la IA es un medio; el aprendizaje, el fin</h2>
<p>La guía de la UNESCO sobre IA generativa en la educación y la investigación (septiembre de 2023) parte de un enfoque <strong>centrado en las personas</strong>: la tecnología debe servir a la agencia humana, la inclusión y la equidad, no sustituirlas. Sugiere, entre otras cosas, que los gobiernos regulen el uso en los colegios, que se valide la herramienta antes de ponerla en manos de los estudiantes, que se capacite a los docentes y que se considere una edad mínima (la propuesta menciona 13 años) para el uso autónomo en el aula; es una recomendación para que cada país la evalúe, no una regla vinculante. En 2024, la UNESCO publicó además marcos de competencias en IA para docentes (15 competencias en cinco dimensiones: mentalidad centrada en el ser humano, ética de la IA, fundamentos y aplicaciones de la IA, pedagogía de la IA y la IA para el desarrollo profesional) y para estudiantes.</p>

<h2>Lo que dice la evidencia: rendir mejor no es aprender mejor</h2>
{{img:evidencia}}
<ul>
<li><strong>Un chatbot sin límites puede dañar el aprendizaje.</strong> En un experimento con cerca de 1.000 estudiantes de secundaria en Turquía (Bastani y colaboradores, <em>PNAS</em>, julio de 2025), quienes practicaron con una versión de GPT-4 con la interfaz habitual rindieron 48 % mejor en las prácticas, pero <strong>17 % peor</strong> en el examen sin IA que quienes nunca la usaron. Quienes usaron un tutor diseñado para dar pistas en lugar de respuestas rindieron 127 % mejor en las prácticas y <strong>igual</strong> que el grupo de control en el examen. Es evidencia a corto plazo.</li>
<li><strong>Un tutor bien diseñado puede acelerar el aprendizaje.</strong> En un ensayo aleatorizado con 194 estudiantes de física en Harvard (Kestin y colaboradores, <em>Scientific Reports</em>, 2025), quienes aprendieron un tema con un tutor de IA diseñado con principios pedagógicos aprendieron, según los autores, más del doble que con una clase de aprendizaje activo, y en menos tiempo (una mediana de 49 minutos frente a 75). Es un estudio con estudiantes universitarios de un curso, dos temas y pruebas de corto plazo: no dice que la IA reemplace a la clase.</li>
<li><strong>La revisión de la OCDE</strong> (<em>Digital Education Outlook 2026</em>, enero de 2026) resume esa dirección: con herramientas de uso general, los estudiantes producen mejores resultados, pero esa ventaja desaparece, o se revierte, cuando se retira la herramienta; en cambio, las herramientas educativas diseñadas con intención pedagógica tienden a mostrar mejoras sostenidas. No recomienda prohibir, sino un uso selectivo y con propósito.</li>
</ul>
<p>La lectura práctica es esta: <strong>la pregunta no es "¿IA sí o no?" sino "¿esta tarea, con este tipo de apoyo, deja más o menos aprendizaje?"</strong>. Una IA que da la respuesta quita el esfuerzo que produce el aprendizaje (ver también <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">la gran mentira de la IA</a>); una IA que pregunta, da pistas y exige explicar puede añadirlo.</p>

<h2>Marco normativo y de políticas</h2>
<ul>
<li><strong>Colombia, Ley 2626 de 2026 (Ley de Educación Digital, sancionada el 24 de agosto).</strong> Actualiza la asignatura de Tecnología e Informática en básica y media e incorpora competencias en pensamiento computacional, programación, <strong>inteligencia artificial</strong>, ciencia de datos y ciudadanía digital (art. 1). Aplica a las instituciones oficiales, y los colegios privados pueden adoptar el modelo (art. 2). Ordena al Ministerio de Educación actualizar los lineamientos al menos cada tres años y diseñar una malla curricular obligatoria que incluya la IA (art. 3), crear un programa obligatorio de formación docente en un plazo de seis meses (art. 4), garantizar equidad en infraestructura y conectividad con prioridad en zonas rurales (art. 5) y reglamentar la ley en seis meses (art. 14). Crea una Comisión Nacional de Educación Digital y un Observatorio (arts. 7 a 9). Es una ley sobre <em>qué se enseña</em> de IA; no regula el uso de IA por parte de estudiantes ni docentes, y hay un proyecto en trámite sobre uso responsable.</li>
<li><strong>Formación docente:</strong> MinTIC y Computadores para Educar abrieron en abril de 2026 la convocatoria "IAprende con sentido humano y territorial" para docentes y directivos de colegios oficiales, con tres niveles y prioridad para zonas rurales y municipios PDET. Verifica la oferta vigente en las páginas oficiales.</li>
<li><strong>Datos personales:</strong> la Ley 1581 de 2012 y sus reglamentos protegen los datos personales y establecen reglas especiales para los de niños, niñas y adolescentes (el interés superior, art. 7, interpretado por la Corte Constitucional). La regla práctica: <strong>no pegues en una herramienta de IA datos que identifiquen a un estudiante</strong> (nombre, documento, diagnóstico, notas, fotos), salvo que la herramienta esté contratada por la institución con las garantías del caso (ver el <a href="/herramientas/piar/">PIAR con IA</a>, diseñado con esa restricción en mente).</li>
<li><strong>Unión Europea:</strong> la Ley de IA clasifica como de <em>alto riesgo</em> ciertos usos educativos (admisión, evaluación de resultados, asignación de nivel y vigilancia de exámenes), prohíbe la inferencia de emociones en instituciones educativas y exige alfabetización en IA a quienes usan estos sistemas; verifica el calendario de aplicación. Es un referente de lo que se considera sensible.</li>
</ul>

<h2>Cuánta IA admite cada tarea: una escala de cinco niveles</h2>
{{img:niveles}}
<p>En lugar de prohibir o permitir "la IA" en general, decide <strong>por tarea</strong>, según lo que la tarea quiere evaluar. Una escala útil es la <em>AI Assessment Scale</em> de Leon Furze, Mike Perkins, Jasper Roe y Jason MacVaugh, de la que existen varias versiones. En su primera versión tiene cinco niveles: <strong>1) sin IA</strong> (tarea supervisada, para evaluar conocimiento y comprensión); <strong>2) lluvia de ideas</strong> (la IA ayuda a generar ideas al inicio); <strong>3) esquemas y notas</strong> (la IA ordena y esquematiza; la redacción es propia); <strong>4) retroalimentación y edición</strong> (la IA comenta y sugiere ediciones; las ideas son propias); y <strong>5) IA total</strong> (la IA genera todo y se evalúa lo que se hace con ello: verificar, criticar, mejorar). Tiene límites (las versiones posteriores cambian los niveles) y su valor es obligar a decidir.</p>
<p>El <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">libro de Excel</a> convierte la escala en una matriz. Para cada tarea registras el <strong>objetivo que evalúa</strong> (conocimiento base, escritura y razonamiento propios, ideas y comprensión, o habilidad de usar IA), el <strong>nivel de IA permitido</strong>, si se pide <strong>declarar el uso</strong> y si hay <strong>evidencia del proceso</strong>. El libro compara el nivel con el máximo recomendado para ese objetivo y marca las tareas desalineadas, las que permiten IA sin pedir declaración y las que no dejan evidencia del proceso.</p>
<pre><code>' Nivel máximo recomendado según el objetivo (tabla en Parametros!A12:B15)
=BUSCARV(C4;Parametros!$A$12:$B$15;2;FALSO)                                         ' español
=VLOOKUP(C4,Parametros!$A$12:$B$15,2,FALSE)                                          ' inglés

' Alineación entre el nivel permitido (D) y el máximo recomendado (G)
=SI(D4>G4;"Desalineada: permite más IA de la que admite el objetivo";"Alineada")     ' español
=IF(D4>G4,"Desalineada: permite más IA de la que admite el objetivo","Alineada")      ' inglés

' ¿Falta pedir que se declare el uso? (nivel 2 o más y sin declaración)
=SI(Y(D4>=2;E4="No");"Falta pedir que se declare el uso";"")                         ' español
=IF(AND(D4>=2,E4="No"),"Falta pedir que se declare el uso","")                        ' inglés</code></pre>
<p>Con las <strong>doce tareas ficticias</strong> de un curso de ciencias de grado 9.°: 3 tareas sin IA (nivel 1), 2 de nivel 2, 3 de nivel 3, 3 de nivel 4 y 1 de IA total; es decir, <strong>9 de 12 (75 %) permiten algún uso de IA</strong>. El libro detecta <strong>2 tareas desalineadas</strong> (un ensayo argumentativo que permite edición con IA cuando se quiere evaluar la escritura propia, y una tarea de ejercicios de cálculo, pensada para conocimiento base, que permite esquemas y notas con IA), <strong>2 tareas con IA sin pedir declaración</strong> y <strong>5 tareas con IA sin evidencia del proceso</strong>. Es un diagnóstico de diseño, no de personas: arreglar la tarea es más eficaz que perseguir al estudiante.</p>

<h2>Qué hacer con los detectores de IA</h2>
<p>Los detectores de texto generado por IA no son una base confiable para sancionar. Un estudio publicado en <em>Patterns</em> (Liang y colaboradores, 2023) encontró que varios detectores clasificaban erróneamente como generados por IA los textos de personas que escriben en inglés como segunda lengua, y las propias empresas han reconocido limitaciones. Un porcentaje de "probabilidad de IA" no es una prueba, y menos en menores de edad; si un caso lo requiere, es preferible una conversación con el estudiante, la evidencia del proceso (borradores, bitácoras, notas) y una evaluación oral breve, siempre dentro del debido proceso del manual de convivencia y del SIEE.</p>

<h2>Usos que sí ayudan (y cómo proteger el aprendizaje)</h2>
<ul>
<li><strong>Para docentes:</strong> preparar clases y variantes de ejercicios, redactar retroalimentación inicial que luego se revisa, adaptar materiales a distintos niveles de lectura, generar preguntas de práctica (ver el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>) y planear ajustes razonables para estudiantes con discapacidad (ver el <a href="/herramientas/piar/">PIAR con IA</a>), siempre con revisión humana. Es el uso con menos riesgo y más ahorro de tiempo.</li>
<li><strong>Para estudiantes:</strong> usar la IA como <em>tutor que pregunta</em> (pedirle que haga preguntas, que explique por qué una respuesta es incorrecta o que ponga a prueba una explicación) en lugar de como solucionador. Una regla simple: <em>primero intento yo; después consulto; luego explico con mis palabras</em>.</li>
<li><strong>Para directivos:</strong> acordar reglas comunes por nivel y tipo de tarea, evitar que cada docente tenga una norma distinta (ver <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">el espejismo de la IA en la educación superior</a>, que muestra el costo de la improvisación), formar a los docentes y dejar claro qué herramientas están aprobadas y con qué datos.</li>
<li><strong>Para las familias:</strong> saber que el uso de IA en casa también forma hábitos; acompañar sin resolver, pedir que el hijo explique lo que entregó y cuidar los datos personales.</li>
</ul>

<h2>Riesgos que hay que gestionar</h2>
<ul>
<li><strong>Errores y "alucinaciones":</strong> las IA generativas producen texto verosímil que puede ser falso, con citas inventadas. Enseña a verificar con fuentes (ver <a href="/inteligencia-artificial-cuantica-aplicaciones-limites/">la lectura crítica de afirmaciones sobre IA cuántica</a>, que aplica un marco de niveles de evidencia).</li>
<li><strong>Dependencia y pereza metacognitiva:</strong> delegar el pensamiento reduce la práctica de recuperar, explicar y corregir (ver lo que dice la evidencia arriba).</li>
<li><strong>Sesgos y homogeneización:</strong> los modelos reproducen sesgos de sus datos y tienden a producir respuestas parecidas entre sí; ver también la brecha de equidad: quien tiene mejor herramienta y mejor criterio se beneficia más.</li>
<li><strong>Privacidad:</strong> es el riesgo más fácil de evitar y el más difícil de reparar. Datos de menores, fuera.</li>
<li><strong>Integridad académica:</strong> se maneja con diseño de tareas, declaración de uso, evidencia de proceso y evaluación oral, no con detectores.</li>
</ul>

<h2>Plan de implementación en un colegio (60 días)</h2>
{{img:pasos}}
<ol>
<li><strong>Semanas 1-2, diagnóstico:</strong> ¿quién usa qué, para qué y con qué datos? (docentes, estudiantes y familias; una encuesta corta y anónima).</li>
<li><strong>Semanas 3-4, acuerdos:</strong> escala de niveles por tarea, regla de declaración de uso, lista de herramientas aprobadas y regla de datos. Que pase por el consejo académico y se articule con el SIEE y el manual de convivencia.</li>
<li><strong>Semanas 5-6, piloto:</strong> cada docente de un área revisa tres tareas con la matriz y ajusta el diseño.</li>
<li><strong>Semanas 7-8, comunicación y formación:</strong> sesión con familias, pautas para estudiantes y un espacio de formación docente (la formación obligatoria de la Ley 2626 es una oportunidad).</li>
<li><strong>Después, revisión:</strong> cada periodo, mirar qué tareas siguen desalineadas, qué incidentes hubo y qué se aprendió.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>Colombia combina una ley reciente sobre <em>qué enseñar</em> de IA con vacíos sobre <em>cómo usarla</em> en el aula: no hay todavía una norma que regule el uso por parte de estudiantes y docentes, así que las decisiones recaen en cada colegio (de ahí la importancia de las políticas institucionales). Mientras tanto, la brecha de acceso importa más que cualquier debate de integridad: la propia Ley 2626 prioriza la conectividad rural. En el mundo se mueven en dos direcciones: marcos que fijan edades mínimas y riesgos (la UNESCO, la Unión Europea) y sistemas que dejan la decisión a las instituciones. La evidencia, por ahora, respalda la prudencia selectiva de la OCDE más que la prohibición o la adopción masiva.</p>
<p>Para los <strong>docentes</strong>, el reto es tiempo y criterio; para los <strong>directivos</strong>, acordar reglas y proteger datos; para las <strong>familias</strong>, acompañar sin resolver; y para los <strong>estudiantes</strong>, entender que el objetivo de la tarea es lo que ellos aprenden, no el archivo que entregan.</p>

<h2>Herramientas y plantillas</h2>
<p>Estas herramientas propias aplican los principios de la guía: ayudan a preparar material con revisión humana y están pensadas para no exponer datos de estudiantes.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">el libro de la matriz de uso de IA por tarea</a>, <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel con inteligencia artificial</a>, <a href="/las-matematicas-estan-a-punto-de-morir-openai-372-resultados-verificacion-lean/">¿mueren las matemáticas? Los 372 resultados de OpenAI</a> y la herramienta <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (10 de octubre de 2026)</h2>
<ul>
<li><strong>UNESCO (2023),</strong> <em>Guidance for generative AI in education and research</em>, 7 de septiembre de 2023, y <em>AI competency framework for teachers</em> (2024).</li>
<li><strong>Congreso de la República,</strong> <a href="https://www.alcaldiabogota.gov.co/sisjur/normas/Norma1.jsp?i=194142&amp;dt=S">Ley 2626 de 2026</a> (texto del Régimen Legal de Bogotá, leído completo); <strong>MinTIC y Computadores para Educar,</strong> convocatoria "IAprende con sentido humano y territorial" (abril de 2026).</li>
<li><strong>Bastani et al. (2025),</strong> "Generative AI without guardrails can harm learning: Evidence from high school mathematics", <em>PNAS</em> 122(26); <strong>Kestin, Miller, Klales, Milbourne y Ponti (2025),</strong> estudio sobre un tutor de IA en física, <em>Scientific Reports</em> (las cifras de tiempo provienen de resúmenes; revisa el artículo); <strong>OCDE (2026),</strong> <a href="https://www.oecd.org/en/publications/oecd-digital-education-outlook-2026_062a7394-en.html">Digital Education Outlook 2026</a> (no pude abrir la página; resumo según sus resúmenes públicos).</li>
<li><strong>Perkins, Furze, Roe y MacVaugh (2024),</strong> "The Artificial Intelligence Assessment Scale (AIAS)", <em>Journal of University Teaching and Learning Practice</em> 21(6); <a href="https://leonfurze.com/2023/12/18/the-ai-assessment-scale-version-1/">primera versión de la escala</a> (blog de Leon Furze); <strong>Liang et al. (2023),</strong> "GPT detectors are biased against non-native English writers", <em>Patterns</em>.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Se debe prohibir la IA en el colegio?</h3>
<p>La evidencia disponible no respalda una prohibición general ni una adopción sin criterio. Se recomienda decidir por tarea, según lo que se quiere evaluar, y proteger los datos de los estudiantes.</p>
<h3>¿Qué edad mínima hay para usar IA?</h3>
<p>La UNESCO propuso considerar 13 años como edad mínima para el uso autónomo en el aula; es una recomendación y los términos de uso de cada herramienta pueden fijar otras. En Colombia no hay todavía una norma específica.</p>
<h3>¿Sirven los detectores de IA?</h3>
<p>No como prueba. Tienen errores y sesgos; es mejor combinar diseño de tareas, evidencia del proceso y conversación.</p>
<h3>¿Qué datos no debo poner en una IA?</h3>
<p>Nombres, documentos, diagnósticos, notas, fotos o cualquier dato que identifique a un estudiante, salvo que la institución tenga una herramienta contratada con garantías.</p>
<h3>¿Cómo uso el libro?</h3>
<p>Lista tus tareas, el objetivo que evalúa cada una, el nivel de IA que permites, si pides declaración y si hay evidencia del proceso; el libro marca desalineaciones y carencias.</p>

<p class="notice"><strong>Revisa tus propias tareas.</strong> Descarga el <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">libro de la matriz de uso de IA por tarea</a>, reemplaza las tareas ficticias por las tuyas y mira cuántas están desalineadas con su objetivo.</p>

<h2>Para pensar</h2>
<p>Cada tarea que diseñamos responde, aunque no lo digamos, a una pregunta: ¿qué quiero que el estudiante sea capaz de hacer sin mí y sin la máquina? <strong>¿Cuántas de tus tareas de hoy podrías explicar con esa pregunta? Y si el estudiante pudiera usar una IA para todo, ¿qué parte de tu clase seguiría siendo imposible de delegar, y por qué vale la pena protegerla?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:evidencia}}' => $img('ia-en-educacion-evidencia', 444, 'Tabla con tres estudios sobre IA y aprendizaje: Bastani et al. 2025, Kestin et al. 2025 y la OCDE 2026, con lo que compararon y el resultado.', 'Rendir mejor no es aprender mejor.'),
    '{{img:niveles}}' => $img('ia-en-educacion-niveles', 480, 'Gráfico de barras con el número de tareas de un curso ficticio en cada nivel de uso de IA: 3, 2, 3, 3 y 1 tareas en los niveles 1 a 5.', 'Cuánta IA permite cada tarea (ejemplo ficticio).'),
    '{{img:pasos}}' => $img('ia-en-educacion-pasos', 467, 'Cinco pasos para decidir antes de adoptar una herramienta de IA: objetivo, nivel, datos, evidencia y revisión.', 'Cinco pasos para decidir con criterio.'),
]);

return [
    'slug' => 'guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel',
    'title' => 'Guía del uso de la inteligencia artificial en educación: qué funciona, qué no y cómo decidirlo tarea por tarea, con un libro de Excel',
    'excerpt' => 'Guía para decidir el uso de IA en el aula: lo que dice la evidencia (aprender no es lo mismo que rendir), el marco en Colombia (Ley 2626 de 2026) y el mundo, una escala de cinco niveles por tarea, riesgos y un plan de 60 días, con un libro de Excel.',
    'seo_title' => 'Guía del uso de la IA en educación: evidencia y normas',
    'seo_description' => 'Guía del uso de la IA en educación: qué dice la evidencia, la Ley 2626 de 2026 en Colombia, cuánta IA admite cada tarea y un libro de Excel para tu colegio.',
    'focus_keyword' => 'uso de la inteligencia artificial en educación',
    'cover' => '/assets/img/articulos/ia-en-educacion/ia-en-educacion-portada',
    'cover_alt' => 'Portada "Guía del uso de la IA en educación: qué funciona, qué no y cómo decidirlo" con una tarjeta: −17 % en el examen sin IA para quienes practicaron con un chatbot sin pistas (PNAS, 2025).',
    'published_at' => '2026-10-12 12:00:00',
    'content_html' => $html,
];
