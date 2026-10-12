<?php

declare(strict_types=1);

// "La IA también obliga al docente a volver a aprender": qué aprender, si quieren cualificarse, reto o trabajo adicional, vale la pena seguir. Fuentes (12-oct-2026): OCDE TALIS 2024 Colombia (7-oct-2025: 53 % usó IA vs 36 %; usos 80/79/64/39/37; sin conocimientos 64 % y sin infraestructura 76 % entre no usuarios; alta necesidad IA 43 %; barreras de formación 70/59/55; formación impactante 69 %; horas 40,4 / 26,8 / 9,1 / 6,0 / 3,1; satisfacción 97 %, valorados 54 %, salario 63 %, estrés 8 %, 16 % menores de 30 se irían, contrato permanente 70 %); Icfes dic-2025 (78 % necesidad, 48 % IA en formación, 29 % abrumados, correlación 0,83); UNESCO marco de competencias de IA para docentes 2024 (5 dimensiones, 15 competencias) y escasez 44 M; Gallup/Walton jun-2025 (5,9 h; 32/28/40; 68 % sin formación; 19 % con política); OECD DEO 2026; Tutor CoPilot (+4 pp, $20); Ley 115 art. 104; Ley 2626 de 2026; Decreto 1850 (40 semanas). Libro verificado en Excel 16 y Python: base +47,2 h, equilibrio semana 15; revisión 60 % +3,0 h/36; período 10 sem +6,0/37; colegio 3 h +95,2/7; sin ahorro -56,0. Supuestos de ahorro propios. Encuesta propia de 5 preguntas.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/docente-aprender-ia/' . $name;
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
<p>Durante años, la tecnología llegaba al aula como una herramienta que el docente podía adoptar o ignorar. Con la IA generativa cambió algo: <strong>los estudiantes ya la usan, las familias preguntan, la ley la incorpora al currículo y se le empieza a pedir al docente que la entienda</strong>. De ahí salen cuatro preguntas incómodas que este artículo aborda de frente: <strong>¿qué hay que aprender? ¿Los docentes quieren de verdad cualificarse? ¿Es un reto o es un trabajo adicional? ¿Vale la pena seguir siendo docente en la era de la IA?</strong></p>
<p>Respondo con datos de Colombia (la encuesta TALIS 2024 de la OCDE, analizada también por el Icfes), con evidencia internacional y con un <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">libro de Excel</a> que calcula, con tus propios supuestos, si el tiempo que inviertes en aprender se te devuelve (verificado en Microsoft Excel 16 y contra un cálculo independiente). Al final hay una <a href="#encuesta">encuesta de cinco preguntas</a> para conocer qué piensas tú. Fuentes revisadas el <strong>12 de octubre de 2026</strong>.</p>
<p class="notice"><strong>Advertencia.</strong> Los resultados de TALIS son autorreportes de docentes de secundaria baja y no hablan por todo el sistema. Los supuestos de ahorro de tiempo del libro son <strong>míos</strong>, no datos publicados: cámbialos por los tuyos. La encuesta es abierta y anónima, y refleja solo a quienes responden.</p>

<h2>¿Qué hay que aprender? No son herramientas: es criterio</h2>
<p>La tentación es aprender "las diez mejores herramientas de IA". Es una mala estrategia: cambian cada mes. La UNESCO publicó en 2024 un <strong>marco de competencias de IA para docentes</strong> con 15 competencias, tres niveles de progresión (adquirir, profundizar, crear) y cinco dimensiones. Esas dimensiones sirven como mapa; las habilidades concretas de cada una son ejemplos míos:</p>
{{img:dimensiones}}
<ul>
<li><strong>Mentalidad centrada en lo humano:</strong> decidir cuándo <em>no</em> usar IA y conservar el juicio pedagógico sobre lo que propone. Es la base de todo lo demás.</li>
<li><strong>Ética de la IA:</strong> saber qué datos de estudiantes nunca se pegan en una herramienta externa, reconocer sesgos y errores, y explicar a familias y estudiantes qué hace y qué no hace la IA en tu clase.</li>
<li><strong>Fundamentos y aplicaciones:</strong> escribir instrucciones claras y comprobables, y entender los límites (inventa fuentes, se equivoca en cálculos, no conoce tu contexto).</li>
<li><strong>Pedagogía con IA:</strong> diseñar actividades donde la IA haga pensar y no pensar por el estudiante, y evaluar el <em>proceso</em>, no solo el producto (ver <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">ampliar o reemplazar el pensamiento del estudiante</a> y <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">qué miden de verdad las calificaciones</a>).</li>
<li><strong>IA para el aprendizaje profesional:</strong> usarla para planear y dar retroalimentación, siempre con revisión, y aprender en comunidad con colegas.</li>
</ul>
<p>La evidencia sobre qué se aprende primero en la práctica es clara: según TALIS 2024, los docentes colombianos que usan IA la emplean sobre todo para generar planes de clase o actividades (80 %) y para aprender de forma eficiente sobre un tema (79 %); mucho menos para evaluar trabajos (39 %) o revisar datos de desempeño (37 %). Es decir: empiezan por lo que ahorra tiempo y menos por lo que exige más criterio. <strong>El orden que recomiendo es el inverso:</strong> primero lo humano y lo ético, luego lo práctico (ver la <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">guía del uso de la IA en educación</a>).</p>

<h2>¿Los docentes quieren de verdad cualificarse?</h2>
<p>Los datos de Colombia contradicen la imagen de una docencia que se resiste:</p>
{{img:talis}}
<ul>
<li>El <strong>53 %</strong> de los docentes usó IA en su trabajo en los 12 meses previos (promedio OCDE: 36 %), a la par de Brasil (56 %), Chile (55 %) y Costa Rica (52 %).</li>
<li>El Icfes reporta que el <strong>78 %</strong> manifiesta necesidad de formación en IA (OCDE: 66 %), la mayor entre los temas consultados; la OCDE, con un criterio más estricto, indica que el <strong>43 %</strong> tiene una "alta necesidad" de formación en IA.</li>
<li>El 48 % incluyó IA en su formación reciente (promedio OCDE: 38 %), y el 69 % dice que la formación en la que participó tuvo un impacto positivo en su enseñanza (OCDE: 55 %).</li>
</ul>
<p>La voluntad existe. Lo que falla es la oferta. Entre los docentes que <em>no</em> usaron IA, el 64 % dice no tener los conocimientos y el 76 % que su colegio no tiene la infraestructura (en la OCDE, 75 % y 37 %). Y entre las barreras para formarse, en general, los docentes colombianos señalan que <strong>es demasiado cara (70 %)</strong>, que <strong>no hay incentivos (59 %)</strong> y que <strong>no hay apoyo del empleador (55 %)</strong>. Sentirse "abrumado" por las nuevas tecnologías afecta a casi el 30 % (OCDE: 33 %). En Estados Unidos, la encuesta de Gallup y la Fundación Walton (abril de 2025, 2.232 docentes) encontró que el 32 % usa IA cada semana, el 28 % de forma ocasional y el 40 % no la usa, y que el 68 % no recibió formación sobre IA en el año escolar.</p>
<p><strong>Lectura crítica.</strong> "¿Quieren?" es una pregunta mal planteada: casi todos <em>quieren</em>, pero no en cualquier condición. Querer cualificarse no es lo mismo que aceptar hacerlo gratis, de noche y sin reconocimiento. Hay dos cautelas: TALIS cubre a docentes de secundaria baja y mide intención y autorreporte, y puede haber sesgo de quien responde; y pasar de "usé IA" a "enseño bien con IA" es un salto que la encuesta no mide.</p>

<h2>¿Es un reto o es un trabajo adicional?</h2>
<p>Depende de quién pone el tiempo y de cuánto se recupera. Para tener un punto de partida, la jornada de un docente colombiano de tiempo completo, según TALIS 2024, es de <strong>40,4 horas semanales</strong>: 26,8 enseñando, 9,1 preparando clases, 6,0 calificando y corrigiendo, y 3,1 en trabajo administrativo. Preparar y calificar están por encima del promedio OCDE (7,4 y 4,6 horas). Es decir, hay más de 18 horas semanales donde la IA podría ayudar.</p>
{{img:horas}}
<p>En Estados Unidos, los docentes que usan IA cada semana dicen ahorrar <strong>5,9 horas semanales</strong> (Gallup y Fundación Walton, 2025): no hay una cifra equivalente para Colombia, y es un autorreporte. El <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">libro de Excel</a> te deja poner tus propios supuestos: horas en cada tarea, porcentaje que ahorras, porcentaje del ahorro que se pierde revisando lo que produce la IA, horas de formación (al inicio y después) y horas que tu colegio reconoce como tiempo de formación. Con mis supuestos base (4,1 horas de ahorro bruto semanal, 30 % perdido en revisión y 5 horas semanales de formación durante 4 semanas, luego 1 hora):</p>
{{img:balance}}
<table>
<thead><tr><th>Escenario</th><th>Balance del año</th><th>Semana de equilibrio</th><th>Lectura</th></tr></thead>
<tbody>
<tr><td>Base</td><td>+47,2 horas</td><td>15</td><td>Reto que se paga</td></tr>
<tr><td>El 60 % del ahorro se pierde revisando</td><td>+3,0 horas</td><td>36</td><td>Se paga muy tarde</td></tr>
<tr><td>Período inicial de 10 semanas (el plan completo del libro)</td><td>+6,0 horas</td><td>37</td><td>Se paga muy tarde</td></tr>
<tr><td>El colegio reconoce 3 horas semanales de formación</td><td>+95,2 horas</td><td>7</td><td>Reto claro</td></tr>
<tr><td>No hay ahorro (la IA no sirve para tus tareas)</td><td>-56,0 horas</td><td>No se recupera</td><td>Trabajo adicional</td></tr>
</tbody>
</table>
<pre><code>' Balance acumulado de la semana (columna E de la hoja Semanas)
=E4+D5                                                                      ' misma fórmula en español e inglés

' Semana de equilibrio: primera semana con balance acumulado >= 0
=SI.ERROR(INDICE(Semanas!A4:A63;COINCIDIR(VERDADERO;INDICE(Semanas!E4:E63>=0;0);0));"No se recupera en el año")   ' español
=IFERROR(INDEX(Semanas!A4:A63,MATCH(TRUE,INDEX(Semanas!E4:E63>=0,0),0)),"No se recupera en el año")                ' inglés</code></pre>
<p><strong>Lo que enseña el ejercicio:</strong> la respuesta no es "reto" ni "trabajo adicional", sino <strong>"depende de tres palancas"</strong>: cuánto ahorras de verdad, cuánto pierdes revisando y, sobre todo, <strong>quién reconoce el tiempo de aprender</strong>. Con tiempo institucional, el balance es claro; sin él, el costo recae por completo en el docente y el retorno tarda. Hay una trampa adicional que el libro no calcula: <strong>si el tiempo ahorrado se llena con más tareas, el "dividendo" de la IA se lo queda el sistema</strong>. Por eso conviene que los colegios decidan de antemano qué harán con las horas recuperadas.</p>
<p>La <strong>Ley 2626 de 2026</strong> obliga al Ministerio de Educación a diseñar un programa de formación docente en un plazo no mayor a seis meses desde su promulgación (24 de agosto de 2026). Será importante ver si ese programa reconoce el tiempo, no solo el contenido.</p>

<h2>¿Vale la pena seguir siendo docente en la era de la IA?</h2>
<p>Es la pregunta que más pesa, y conviene responderla sin consuelos fáciles ni catastrofismo.</p>
<p><strong>Lo que dicen los datos de Colombia.</strong> Según TALIS 2024, el 97 % de los docentes está satisfecho con su trabajo (OCDE: 89 %), el 54 % siente que la sociedad los valora (OCDE: 22 %), el 63 % está satisfecho con su salario (OCDE: 39 %), solo el 8 % reporta mucho estrés (OCDE: 19 %) y el 16 % de los menores de 30 años piensa dejar la docencia en cinco años (OCDE: 20 %). Son datos de percepción y no de realidad laboral completa: el 30 % no tiene contrato permanente.</p>
<p><strong>Lo que dice la evidencia sobre la IA.</strong> Los estudios más sólidos la muestran como <em>aumento</em> del docente: en el ensayo Tutor CoPilot, la IA que ayudó a tutores humanos mejoró el dominio de los temas de los estudiantes (4 puntos porcentuales, 9 con los tutores peor valorados) por unos 20 dólares por tutor al año; el autor del estudio de Harvard dijo que su resultado no es un argumento para reemplazar la interacción humana; y la OCDE (<em>Digital Education Outlook 2026</em>) concluye que la IA debe aumentar a los docentes y no reemplazarlos, y pide mantener una enseñanza centrada en lo humano. Y la UNESCO calcula que el mundo necesita <strong>44 millones de docentes más para 2030</strong>.</p>
<p><strong>Lo que la IA no hace (hoy).</strong> Responder por un niño, notar que algo anda mal en casa, sostener la convivencia (en Colombia, el 97 % de los docentes dice que estudiantes y docentes se llevan bien en su colegio y el 80 % cree poder apoyar el aprendizaje socioemocional), tomar decisiones de evaluación que la ley exige que sean de una persona, y orientar, que es lo que la Ley 115 de 1994 (art. 104) llama el papel del educador: "orientador (...) de un proceso de formación, enseñanza y aprendizaje". Lo comenté en <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">la IA no te reemplazará, quien la domine, sí</a>.</p>
<p><strong>Lo que no se sabe.</strong> Qué tareas del docente cambiarán en diez años, cuántas plazas habrá, qué pasará con quienes no se actualicen y cuánto se deteriorará o mejorará la profesión. Nadie lo sabe con certeza: quien afirme lo contrario vende algo.</p>
<p><strong>Mi lectura:</strong> vale la pena <em>si</em> la docencia que eliges es la de acompañar, diagnosticar, evaluar procesos y formar criterio, y <em>si</em> el sistema reconoce el tiempo de aprender y no convierte el ahorro de la IA en más carga. Si lo que más te define es transmitir información o corregir trabajos repetitivos, esa parte sí está cambiando. La señal a observar no es "la IA hace X", sino <strong>"¿qué parte de mi trabajo solo puede hacerla alguien que responde por estos estudiantes?"</strong>.</p>

<h2>Un plan mínimo de cuatro semanas</h2>
<p>El libro trae una hoja <em>Plan</em> con diez habilidades (dos por dimensión), tu nivel actual, el nivel meta y las horas estimadas. Con el ejemplo del libro (47,5 horas para cerrar todas las brechas), un plan realista no se hace en un mes. Para empezar sin abrumarte:</p>
<ol>
<li><strong>Semana 1, lo ético:</strong> define qué datos de estudiantes nunca entrarán en una herramienta externa y por qué.</li>
<li><strong>Semana 2, verificar:</strong> pide a una IA algo que conozcas bien y anota sus errores; es la mejor forma de ganar criterio.</li>
<li><strong>Semana 3, una sola actividad:</strong> diseña con IA una actividad de tu clase y decide qué parte la hará el estudiante sin IA.</li>
<li><strong>Semana 4, balance:</strong> mide cuánto tiempo tomó y cuánto ahorró, con los valores reales en el libro, y decide el siguiente paso.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p><strong>Colombia</strong> es uno de los países con mayor apertura docente a la IA y, al mismo tiempo, con una de las mayores brechas de infraestructura (76 % frente a 37 %). <strong>Latinoamérica</strong> (Brasil, Chile, Costa Rica y Colombia) supera el promedio OCDE de uso docente. <strong>En el mundo</strong>, la dispersión es enorme: de más de 65 % en Singapur, Emiratos Árabes Unidos, Nueva Zelanda, Australia y Vietnam, a 24 % o menos en Francia, Japón, Bulgaria, Hungría, Turquía e Islandia (TALIS 2024, según el Icfes). El Icfes encuentra además que donde más docentes usan IA, más reciben formación sobre ella (correlación de 0,83): <strong>la formación parece ir de la mano del uso</strong>, aunque la correlación no prueba causalidad.</p>
<p>Para los <strong>docentes</strong>, el reto es aprender con tiempo y criterio; para los <strong>directivos</strong>, reconocer horas de formación y definir políticas de uso (en Estados Unidos, solo el 19 % de los docentes dice que su escuela tiene una política de IA, según Gallup y Walton); para las <strong>familias</strong>, saber que usar IA no es sinónimo de enseñar peor ni mejor, sino de cómo se usa; y para los <strong>estudiantes</strong>, que sus docentes les enseñen a usarla con criterio y no solo a evitarla.</p>

<h2>Tu opinión cuenta: una encuesta de cinco preguntas</h2>
<p>Quiero saber cómo lo vives tú. La encuesta es <strong>anónima</strong>, no guarda tu nombre, correo ni IP, y puedes ver los resultados al responder. Refleja a quienes deciden contestar: es una conversación, no una estadística.</p>
{{encuesta:docente-aprender-ia}}

<h2>Herramientas y recursos</h2>
<p>Si quieres empezar a aprender con material probado (prompts revisados con el currículo colombiano, exámenes y planeación con revisión humana, y sin ingresar datos de estudiantes en herramientas que no estén hechas para custodiarlos), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">el libro del balance de tiempo</a>, <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a>, <a href="/colegio-100-virtual-docentes-100-ia-analisis-critico-legal-etico-pedagogico/">el análisis de un colegio 100 % virtual con docentes de IA</a>, y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (12 de octubre de 2026)</h2>
<ul>
<li><strong>OCDE,</strong> <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2025/10/results-from-talis-2024-country-notes_eafd703e/colombia_04c7b413/8f1df220-en.pdf">Results from TALIS 2024: Colombia</a> (7 de octubre de 2025): uso de IA, horas de trabajo, necesidades y barreras de formación, satisfacción, estrés, estatus y contratos; Icfes, <a href="https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf">Usos, percepciones y desafíos en la integración de la IA por los docentes en Colombia</a> (diciembre de 2025).</li>
<li><strong>UNESCO,</strong> AI competency framework for teachers (2024; Miao y Çukurova): cinco dimensiones, 15 competencias, tres niveles; datos de la escasez docente (44 millones para 2030).</li>
<li><strong>Gallup y Fundación Walton,</strong> <em>Teaching for Tomorrow</em> (junio de 2025; 2.232 docentes de escuelas públicas de EE. UU.; <a href="https://www.waltonfamilyfoundation.org/the-ai-dividend-new-survey-shows-ai-is-helping-teachers-reclaim-valuable-time">resumen de la Fundación Walton</a>); cifras de formación según la cobertura de <a href="https://the74million.org/article/survey-60-of-teachers-used-ai-this-year-and-saved-up-to-6-hours-of-work-a-week/">The 74</a>.</li>
<li><strong>OCDE,</strong> <a href="https://digital-skills-jobs.europa.eu/en/latest/news/oecd-digital-education-outlook-2026-how-generative-ai-can-support-learning-when-used">Digital Education Outlook 2026</a>; <strong>Wang et al. (2024),</strong> <a href="https://arxiv.org/abs/2410.03017">Tutor CoPilot</a>; <strong>Kestin et al. (2025),</strong> <em>Scientific Reports</em>, con la declaración del autor a The Hechinger Report.</li>
<li><strong>Normas:</strong> Ley 115 de 1994 (art. 104), Decreto 1850 de 2002 (40 semanas lectivas, compilado en el Decreto 1075 de 2015) y Ley 2626 de 2026.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué debe aprender un docente sobre IA?</h3>
<p>Más criterio que herramientas: cuándo no usarla, qué datos proteger, cómo verificar lo que produce, cómo diseñar actividades donde el estudiante piense y cómo evaluar el proceso. La UNESCO lo organiza en cinco dimensiones.</p>
<h3>¿Los docentes colombianos usan IA?</h3>
<p>Según TALIS 2024, el 53 % la usó en los 12 meses previos, más que el promedio de la OCDE (36 %). La barrera principal que reportan es la falta de infraestructura (76 % entre quienes no la usaron) y de conocimientos (64 %).</p>
<h3>¿Aprender IA es un trabajo adicional?</h3>
<p>Depende de cuánto ahorras, cuánto pierdes revisando lo que produce y si tu colegio reconoce el tiempo de formación. Con supuestos prudentes, el tiempo invertido puede recuperarse en unas 15 semanas; con tiempo institucional, en 7; y si no ahorras nada, es una carga neta. El libro de Excel te permite calcularlo con tus datos.</p>
<h3>¿Vale la pena ser docente con la IA?</h3>
<p>La evidencia disponible muestra la IA como un aumento del docente y no como su reemplazo, pero nadie puede predecir cómo cambiará la profesión en diez años. Vale la pena si lo central de tu trabajo es acompañar, diagnosticar y formar criterio, y si el sistema reconoce el tiempo de aprender.</p>
<h3>¿Cómo uso el libro de Excel?</h3>
<p>Cambia los parámetros amarillos (horas por tarea, porcentajes de ahorro y revisión, horas de formación) y tu nivel actual y meta en cada habilidad; el libro calcula el balance semana a semana, la semana de equilibrio y las horas que pide tu plan.</p>

<p class="notice"><strong>Calcula tu caso.</strong> Descarga el <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">libro del balance de tiempo</a>, reemplaza mis supuestos por los tuyos y responde la <a href="#encuesta">encuesta</a>.</p>

<h2>Para pensar</h2>
<p>Aprender cuesta tiempo, y el tiempo del docente rara vez es de él. <strong>¿Quién debería pagar el tiempo de aprender IA: el Estado, el colegio o cada docente? Y si la IA te devolviera cinco horas a la semana, ¿qué parte de tu trabajo querrías hacer con ese tiempo para que valga la pena seguir siendo docente?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:dimensiones}}' => $img('docente-aprender-ia-dimensiones', 553, 'Tabla con las cinco dimensiones del marco de competencias de IA para docentes de la UNESCO, qué aprender en cada una y para qué: lo humano primero, ética, fundamentos, pedagogía y aprendizaje profesional.', 'No es aprender herramientas: es aprender criterio.'),
    '{{img:talis}}' => $img('docente-aprender-ia-talis', 524, 'Gráfico de barras de docentes en Colombia según TALIS 2024: usó IA 53 %, tuvo IA en su formación 48 %, alta necesidad de formación 43 %, sin conocimientos 64 %, colegio sin infraestructura 76 % y formación demasiado cara 70 %.', 'Docentes en Colombia: uso, necesidades y barreras.'),
    '{{img:horas}}' => $img('docente-aprender-ia-horas', 436, 'Gráfico de barras de la semana de un docente colombiano de tiempo completo: enseñar 26,8 horas, preparar clases 9,1, calificar y corregir 6,0 y trabajo administrativo 3,1.', 'Una semana de un docente colombiano (TALIS 2024).'),
    '{{img:balance}}' => $img('docente-aprender-ia-balance', 573, 'Cuatro datos del balance de tiempo del libro: menos 20 horas al terminar el primer mes, equilibrio en la semana 15, más 47 horas al cierre del año y semana 36 si se pierde el 60 % del ahorro revisando.', 'El balance de tiempo depende de los supuestos.'),
]);

return [
    'slug' => 'ia-obliga-docente-volver-a-aprender-que-aprender-reto-o-trabajo-adicional',
    'title' => 'La IA también obliga al docente a volver a aprender: ¿qué aprender, es un reto o un trabajo adicional y vale la pena seguir?',
    'excerpt' => 'Qué debe aprender un docente sobre IA, si de verdad quiere cualificarse, si es un reto o un trabajo adicional (con un libro de Excel) y si vale la pena seguir siendo docente, con datos de Colombia (TALIS 2024) y una encuesta.',
    'seo_title' => 'La IA obliga al docente a volver a aprender: ¿vale la pena?',
    'seo_description' => 'Qué debe aprender el docente sobre IA, si quiere cualificarse, si es reto o trabajo adicional y si vale la pena seguir. Datos de Colombia y Excel.',
    'focus_keyword' => 'docente aprender inteligencia artificial',
    'cover' => '/assets/img/articulos/docente-aprender-ia/docente-aprender-ia-portada',
    'cover_alt' => 'Portada "La IA también obliga al docente a volver a aprender: ¿qué, para qué y a qué costo?" con una tarjeta: 53 % de los docentes colombianos usó IA en su enseñanza en el último año, frente a 36 % del promedio de la OCDE.',
    'published_at' => '2026-10-24 12:00:00',
    'content_html' => $html,
];
