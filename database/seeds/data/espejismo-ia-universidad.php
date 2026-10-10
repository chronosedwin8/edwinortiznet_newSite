<?php

declare(strict_types=1);

// Artículo de análisis: "El espejismo de la IA en la universidad: mucho "artefacto" y poca innovación".
// Parte del estudio de K. K. Ruiz Mendoza y E. Oviedo González (2026, TE&ET n.º 44, DOI 10.24215/18509959.44.e4), leído completo
// el 9 de octubre de 2026 (cifras de las tablas 1 a 4 y limitaciones citadas por las autoras). Evidencia adicional con fuentes enlazadas
// (HEPI 2024 a 2026, Digital Education Council, GAD3, Decálogo del MEN, CONPES 4144, lineamientos de Uniandes, TEQSA y Universidad de Sídney,
// OECD, Bastani et al., Kosmyna et al., Liang et al., OpenAI). No se cita una frase atribuida a "Revista Mundo Empresarial" porque no se pudo verificar.
// El texto va en nowdoc (nada se interpola); las figuras se insertan con marcadores {{img:…}}.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/espejismo-ia-universidad/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Llevo más de veinte años en las aulas y casi cada semana escucho la misma promesa: la inteligencia artificial generativa va a "revolucionar" la universidad. Por eso me detuve en un artículo reciente de Karla Karina Ruiz Mendoza y Eilen Oviedo González (2026) que llega a una conclusión incómoda: buena parte de lo que se llama innovación con IA es producir lo mismo, en más formatos y más rápido. Mi resumen es más brusco: la IA generativa (IAGen) se está usando como una máquina de escribir glorificada. Pero antes de repartir culpas hice lo que pido a mis estudiantes: <strong>verifiqué</strong>. Conseguí el artículo completo, que es de acceso abierto, revisé sus tablas y comparé lo que dice con lo que suele contarse de él. El resultado es más útil, y más prudente, que el titular.</p>
<p>En este texto te cuento qué dice el estudio y qué no, qué muestra la evidencia más amplia sobre la <strong>inteligencia artificial en la educación superior</strong> en Colombia, América Latina y el mundo, y te dejo una propuesta concreta (marcada como propuesta, no como verdad probada) para evaluar el proceso y no solo el producto, con rúbrica, plantilla de bitácora y protocolo de defensa oral que puedes usar mañana.</p>

<h2>Qué dice realmente el estudio sobre la IA en la educación superior</h2>
<p>Se titula "<a href="https://doi.org/10.24215/18509959.44.e4" target="_blank" rel="noopener">De la producción de artefactos a la innovación pedagógica: estrategias docentes con IAGen en educación superior</a>" y salió en el número 44 (especial, septiembre de 2026, pp. 40 a 49) de la <em>Revista Iberoamericana de Tecnología en Educación y Educación en Tecnología</em>, de la Universidad Nacional de La Plata (Argentina). Las autoras pertenecen a la Universidad Autónoma de Baja California (UABC), en México. Es un estudio cualitativo, exploratorio e interpretativo, con análisis de contenido y porcentajes descriptivos, sin pretensión de generalizar.</p>
<p>El corpus son <strong>600 estrategias didácticas con descripción válida, diseñadas por 186 docentes de la UABC</strong> y registradas en un curso institucional de formación docente sobre IAGen. Había profesores de todas las áreas: 22 % de ingeniería y tecnología, 22 % de economía y negocios, 16 % de artes y humanidades, y el resto de ciencias sociales, salud, ciencias naturales y exactas, derecho y educación.</p>
{{img:estudio}}
<table>
<caption>Evidencia: las cifras principales del estudio (N = 600 estrategias)</caption>
<thead><tr><th>Qué se midió</th><th>Resultado</th></tr></thead>
<tbody>
<tr><td>Herramienta principal</td><td>ChatGPT 29,2 % y Landbot (chatbots sin código) 17,8 %; luego Picsart 11,8 %, InVideo 11,7 % y SlidesAI 6,7 %; "otros", 13,5 %</td></tr>
<tr><td>Más de una herramienta en la misma estrategia</td><td>22,2 %</td></tr>
<tr><td>Integración didáctica: producción de artefactos</td><td><strong>76,7 %</strong> (460 de 600): texto, presentación, imagen, video o chatbot</td></tr>
<tr><td>Pensamiento crítico, verificación o ética</td><td><strong>11,3 %</strong></td></tr>
<tr><td>Indicadores explícitos de innovación</td><td>Colaboración 10,3 %; verificación y atribución 9,3 %; prompt como competencia 4,8 %; iteración y mejora 3,5 %; ética 2,8 %; personalización 1,0 %</td></tr>
<tr><td>Evaluación declarada</td><td>Producto o proyecto como evidencia 49,0 %; rúbrica o criterios explícitos 33,5 %; <strong>sin instrumento ni criterios operativos 22,5 %</strong>; reflexión 5,3 %; examen o cuestionario 3,3 %</td></tr>
</tbody>
</table>
<p>Una estrategia puede caer en varias categorías, por eso los porcentajes no suman 100. Fuente: tablas 1 a 4 del artículo.</p>

<h3>Lo que el estudio sí respalda</h3>
<p>Tres cosas, con números: predominan las actividades de producir artefactos; las prácticas de verificar, iterar o discutir la ética aparecen poco; y la evaluación gira en torno al producto. Las propias autoras lo resumen así: la innovación "se expresa más como diversificación de formatos que como rediseño sistemático de procesos evaluativos, verificación y personalización". Mi tesis, que sostengo, es que un ensayo, un informe o un código impecables ya no dicen por sí solos quién pensó.</p>

<h3>Dónde conviene matizar</h3>
<p>Lo digo con respeto por el texto que originó esta reflexión, y también por el mío: algunas formulaciones se estiran más que los datos.</p>
<ul>
<li><strong>"Las universidades"</strong> son, en realidad, una universidad pública mexicana. Las autoras lo advierten: el estudio "se circunscribe a una institución y a un momento específico", así que no debe generalizarse sin considerar la disciplina y las políticas locales.</li>
<li><strong>"Lo que hacen los profesores"</strong> es, más exactamente, <strong>lo que escribieron en el formulario de un curso</strong>. Representa intención pedagógica, no implementación en el aula ni efectos en el aprendizaje, y no incluye lo que hicieron los estudiantes.</li>
<li><strong>"Dominio absoluto de ChatGPT y Landbot"</strong>: juntos suman 47 %, no la totalidad. Además, las autoras reconocen que en el curso se presentaron varias herramientas y los docentes escogieron las más reconocibles, de modo que parte de la concentración es efecto del propio curso.</li>
<li><strong>"El pensamiento crítico, ausente"</strong>: el estudio dice "menor frecuencia", y solo cuenta menciones explícitas. Un profesor puede exigir verificar fuentes en clase y no escribirlo en el formulario. Las autoras hablan de una "brecha de explicitación pedagógica más que una ausencia de preocupación normativa".</li>
<li><strong>"Rúbricas convencionales"</strong>: el artículo no las llama así. De hecho, propone rúbricas que incluyan atribución, verificación y explicación del uso de IA. El dato más duro es otro: casi una de cada cuatro estrategias no deja ningún criterio operativo de evaluación.</li>
<li><strong>"Evaluar el producto final es un despropósito"</strong> es mi tesis, no una conclusión del estudio. Las autoras plantean algo más matizado: la validez de las tareas tradicionales se tensiona y conviene hacer visible el proceso con registro de prompts, bitácoras, contraste de fuentes y versiones sucesivas, que es justo lo que propongo más abajo.</li>
</ul>
<p>Una nota sobre fuentes: junto a mi borrador original circulaba una frase atribuida a la "Revista Mundo Empresarial (2026)" que no logré ubicar en ninguna publicación, así que no la cito. Prefiero una cita menos y una verificación más.</p>

<h2>Por qué evaluar solo el producto dejó de funcionar</h2>
<p>El estudio de la UABC es un retrato de intenciones. Para entender el problema de fondo hay que mirar lo que hacen los estudiantes y lo que sabemos del aprendizaje.</p>
<ul>
<li><strong>El uso es casi universal.</strong> En el Reino Unido, la <a href="https://www.hepi.ac.uk/reports/student-generative-ai-survey-2026/" target="_blank" rel="noopener">encuesta de HEPI y Kortext de 2026</a> (1.054 estudiantes de pregrado) halló que el 95 % usa IA de alguna forma, el 94 % para trabajos evaluados y el 12 % incluyó texto de IA tal cual en uno de ellos. En 2024 eran 66 %, 53 % y 3 %. El 65 % dice que la evaluación cambió mucho por la IA y algunos estudiantes expresan angustia por ser acusados falsamente.</li>
<li><strong>Practicar con IA sin guías puede salir caro.</strong> En un experimento con casi 1.000 estudiantes de secundaria en Turquía, publicado en <a href="https://doi.org/10.1073/pnas.2422633122" target="_blank" rel="noopener">PNAS (2025)</a>, quienes practicaron con un chat sin restricciones mejoraron 48 % su desempeño en los ejercicios de práctica (127 % con la versión tutor), pero rindieron 17 % peor que el grupo sin IA cuando se les quitó el acceso en el examen. La versión "tutor", que daba pistas en lugar de respuestas, eliminó ese daño, aunque no produjo una mejora. Son estudiantes de matemáticas de colegio, no universitarios: es una señal, no una sentencia.</li>
<li><strong>Rendir no es aprender.</strong> El <a href="https://www.oecd.org/en/publications/oecd-digital-education-outlook-2026_062a7394-en.html" target="_blank" rel="noopener">Digital Education Outlook 2026 de la OCDE</a> concluye que, sin apoyo pedagógico, delegar tareas en la IA mejora el desempeño inmediato pero no el aprendizaje real.</li>
<li><strong>Con cautela:</strong> el preprint "<a href="https://arxiv.org/abs/2506.08872" target="_blank" rel="noopener">Your Brain on ChatGPT</a>" del MIT (2025) tuvo 54 participantes, de los cuales solo 18 completaron la cuarta sesión; no ha pasado revisión por pares y se limita a escribir ensayos. Sirve para formular preguntas, no para sacar titulares.</li>
<li><strong>Los detectores no son la salida.</strong> <a href="https://doi.org/10.1016/j.patter.2023.100779" target="_blank" rel="noopener">Liang y colaboradores (2023)</a> mostraron que siete detectores marcaron, en promedio, como "generados por IA" el 61 % de 91 ensayos TOEFL escritos por personas que no tienen el inglés como lengua materna. Y OpenAI retiró en julio de 2023 su propio clasificador por baja precisión: en su evaluación inicial detectaba solo el 26 % del texto escrito por IA y acusaba falsamente al 9 % del texto humano.</li>
</ul>
{{img:uso}}
<p>La conclusión que saco no es "vigilemos más", sino "diseñemos mejor". Si ni la prohibición ni los detectores resuelven el problema, queda rediseñar qué evaluamos y cómo. Lo mismo me pasó con los celulares en el aula: <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">prohibir no basta, hay que enseñar</a>.</p>

<h2>Colombia, América Latina y el mundo: tres fotografías de la misma película</h2>
<h3>Colombia: mucho uso, poca formación y orientaciones sin fuerza obligatoria</h3>
<p>Según un estudio de GAD3 para <a href="https://planetaformacion.com/en/latest-news/news/planeta-formacion-y-universidades-has-analysed-results-barometer-artificial-intelligence-and-employability-future-higher-education-students-bogota" target="_blank" rel="noopener">Planeta Formación y Universidades</a> (presentado en Bogotá en noviembre de 2024), el 84 % de los estudiantes colombianos de educación superior usa herramientas de IA generativa con frecuencia, pero solo el 35 % tiene competencias para ir más allá de un nivel básico. En el plano oficial, el <a href="https://www.mineducacion.gov.co/1780/articles-429623_Decalogo_inteligencia_artificial.pdf" target="_blank" rel="noopener">Decálogo de IA para la educación superior</a> del Ministerio de Educación (agosto de 2026) respeta la autonomía universitaria y pide, en su sexto punto, procesos de evaluación "que permitan observar procesos de pensamiento y no solo productos finales". Se apoya en el <a href="https://colaboracion.dnp.gov.co/CDT/Conpes/Econ%C3%B3micos/4144.pdf" target="_blank" rel="noopener">CONPES 4144 de 2025</a>. Es una orientación, no una norma obligatoria; y sobre una ley específica de IA, solo encontré proyectos en trámite (el PL 043 de 2025 Senado) sin confirmación de que estén aprobados. A nivel institucional, la Universidad de los Andes publicó en octubre de 2024 <a href="https://www.uniandes.edu.co/es/noticias/inteligencia-artificial/un-documento-pionero-en-colombia-para-usar-la-ia-generativa" target="_blank" rel="noopener">lineamientos</a> que piden declarar cómo se usó la IA y permiten al profesor fijar una escala de uso por actividad. Y existe un "carril seguro" nacional: la prueba Saber Pro se presentó en abril de 2026 de forma <a href="https://newsroom.rcnradio.com/actualidad/icfes-anuncio-cambios-y-fechas-de-las-pruebas-saber-pro-y-ty-t-esto-deben-saber-los-estudiantes" target="_blank" rel="noopener">presencial y en papel</a>, aunque mide competencias genéricas y no reemplaza la evaluación de cada curso.</p>
<h3>América Latina: investigación reactiva y guías que apenas llegan</h3>
<p>Una <a href="https://revistas.uft.cl/index.php/rre/article/view/600" target="_blank" rel="noopener">revisión sistemática de 35 estudios</a> (2023 a abril de 2025) sobre docencia con IAGen en la educación superior latinoamericana encontró que los temas dominantes son la formación docente y la integridad académica (54 % cada uno), mientras la desigualdad tecnológica (17 %) y la falta de políticas institucionales (20 %) quedan en segundo plano. El estudio de la UABC encaja en ese cuadro. La UNAM, en México, publicó en 2026 <a href="https://www.gaceta.unam.mx/la-ia-generativa-modifica-la-forma-de-aprender-ensenar-y-evaluar/" target="_blank" rel="noopener">guías de IA generativa en la evaluación</a> con una frase de Melchor Sánchez Mendiola, jefe de su coordinación de evaluación, que comparto: la IA "no destruye la evaluación sino que nos obliga a mejorarla". Y en la región ya hay instrumentos como <a href="https://revistaseug.ugr.es/index.php/RELIEVE/article/view/36950" target="_blank" rel="noopener">CriticalAI</a>, que veremos más abajo. Desde 2023, la guía del <a href="https://www.iesalc.unesco.org/2023/04/14/chatgpt-e-inteligencia-artificial-en-la-educacion-superior-guia-de-inicio-rapido/" target="_blank" rel="noopener">IESALC-UNESCO sobre ChatGPT en la educación superior</a> sirve de punto de partida regional.</p>
<h3>El resto del mundo: reformar la evaluación, no solo vigilarla</h3>
<p>La Digital Education Council encuestó en 2024 a 3.839 estudiantes de 16 países: el <a href="https://www.digitaleducationcouncil.com/post/digital-education-council-global-ai-student-survey-2024" target="_blank" rel="noopener">86 % usa IA</a> en sus estudios y el 58 % cree no tener conocimientos suficientes. En <a href="https://www.educause.edu/content/2025/2025-educause-ai-landscape-study/introduction-and-key-findings" target="_blank" rel="noopener">EDUCAUSE (2025)</a>, solo el 39 % de los encuestados decía que su institución tenía políticas de uso aceptable de IA (un año antes eran 23 %). Australia dio un paso concreto: la agencia <a href="https://www.teqsa.gov.au/guides-resources/resources/corporate-publications/assessment-reform-age-artificial-intelligence" target="_blank" rel="noopener">TEQSA</a> propuso en 2023 que la evaluación prepare a los estudiantes para participar con ética en una sociedad con IA y que se juzgue el aprendizaje con enfoques múltiples; la <a href="https://educational-innovation.sydney.edu.au/teaching@sydney/?p=21312" target="_blank" rel="noopener">Universidad de Sídney</a> lo convirtió en su modelo de "dos carriles". La <a href="https://www.unesco.org/en/articles/guidance-generative-ai-education-and-research" target="_blank" rel="noopener">UNESCO publicó en 2023</a> su guía sobre IA generativa en educación y en 2024 los <a href="https://www.unesco.org/en/digital-education/ai-future-learning/competency-frameworks" target="_blank" rel="noopener">marcos de competencias en IA</a> para estudiantes y docentes. Y las defensas orales vuelven a las aulas: un <a href="https://www.adn.com/nation-world/2026/04/22/perfect-homework-blank-stares-why-colleges-are-turning-to-oral-exams-to-combat-ai/" target="_blank" rel="noopener">reportaje de AP</a> describe su regreso en universidades de Estados Unidos, con el costo como principal obstáculo.</p>

<h2>Cuatro miradas: docentes, directivos, estudiantes y familias</h2>
<h3>Docentes</h3>
<p>En la <a href="https://www.digitaleducationcouncil.com/post/what-faculty-want-key-results-from-the-global-ai-faculty-survey-2025" target="_blank" rel="noopener">encuesta global de 2025 de la Digital Education Council</a> (1.681 profesores de 28 países), el 61 % había usado IA para enseñar, pero el 83 % se preocupaba porque sus estudiantes no evalúan críticamente lo que la IA produce y el 80 % decía que su institución no aclara cómo aplicarla. El 54 % opinaba que los métodos de evaluación requieren cambios significativos. No encontré una encuesta representativa de profesores colombianos, y prefiero decirlo antes que inventar un porcentaje.</p>
<h3>Directivos</h3>
<p>Su dilema es de escala y de riesgo. Una defensa oral o una tarea por capas cuesta tiempo docente, y el tiempo docente es dinero. Pero un título del que nadie puede decir qué certifica cuesta más. El Decálogo del Ministerio y los lineamientos de Uniandes sugieren el camino: reglas claras por institución y autonomía por curso.</p>
<h3>Estudiantes</h3>
<p>Según HEPI (2026), solo el 36 % siente que su institución lo anima a usar IA y el 48 % cree que sus profesores lo ayudan a desarrollar habilidades de IA, aunque el 68 % las considera esenciales para su carrera. Entre los comentarios del informe aparece un miedo que deberíamos tomarnos en serio: que los acusen de usar IA por escribir bien.</p>
<h3>Familias</h3>
<p>No encontré una encuesta colombiana sobre lo que piensan las familias, así que lo que sigue es mi lectura y no un dato: quien paga una matrícula quiere un título que signifique algo para el empleador y no le pide a la universidad que prohíba la IA, sino que enseñe a usarla con criterio. Para ellas, la evaluación del proceso es una garantía de que su hijo aprendió, no solo de que entregó.</p>

<h2>Una propuesta para evaluar el proceso: cuatro piezas (no es una receta probada)</h2>
<p>Lo que sigue son <strong>propuestas de diseño</strong>. Se apoyan en la literatura y en el oficio docente, pero no conozco experimentos que prueben este conjunto. Pruébalas en un curso, mide qué pasa y ajústalas.</p>
{{img:marco}}
<h3>1. Tareas de varias capas: contrastar, auditar y concluir</h3>
<p>En lugar de "escribe un ensayo sobre X", pide que el estudiante use la IA para generar <strong>tres posturas</strong> sobre X y evalúa su análisis: cómo las compara, qué falacias y sesgos detecta, qué afirmaciones verifica y qué concluye con lecturas que el modelo no le entregó. Así la IA pasa de escribir por el estudiante a ser su contraparte.</p>
<blockquote>
<p><strong>Hoja de tarea (ejemplo, curso de Administración).</strong> Tema: ¿conviene que una pyme colombiana adopte el teletrabajo permanente?</p>
<p><strong>Parte 1 (con IA, 20 minutos).</strong> Pide al modelo tres posturas (a favor, en contra e intermedia) con argumentos y fuentes. Guarda la conversación completa.</p>
<p><strong>Parte 2 (sin delegar, máximo 800 palabras).</strong> Compara las posturas con criterios que tú definas; nombra al menos dos falacias o sesgos citando el fragmento; verifica cinco afirmaciones factuales en fuentes primarias o indexadas y marca cuáles resultaron falsas, inexistentes o no verificables; añade dos lecturas que no vinieron de la IA; escribe tu conclusión y las variables que el modelo omitió.</p>
<p><strong>Parte 3.</strong> Entrega tu bitácora de prompts y la declaración de uso (nivel 4 de la escala más abajo).</p>
<p><strong>Parte 4.</strong> Defiende tu análisis en 8 minutos, sin diapositivas.</p>
</blockquote>
<table>
<caption>Rúbrica propuesta (se califica de 1 a 4 cada criterio)</caption>
<thead><tr><th>Criterio y peso</th><th>1 Inicial</th><th>2 En desarrollo</th><th>3 Logrado</th><th>4 Destacado</th></tr></thead>
<tbody>
<tr><td><strong>Contraste de posturas</strong> (25 %)</td><td>Resume las tres sin compararlas</td><td>Compara con lista de pros y contras</td><td>Compara con criterios explícitos y ubica el choque real</td><td>Revela supuestos ocultos y reformula el problema</td></tr>
<tr><td><strong>Falacias y sesgos</strong> (20 %)</td><td>No detecta ninguno</td><td>Detecta uno sin citar el fragmento</td><td>Detecta dos o más, los nombra y cita</td><td>Además explica cómo cambian la conclusión y cómo corregirlos</td></tr>
<tr><td><strong>Verificación de fuentes</strong> (20 %)</td><td>Acepta datos y referencias sin comprobarlos</td><td>Verifica algunos; confunde fuentes primarias y secundarias</td><td>Verifica cinco afirmaciones y marca las falsas o inexistentes</td><td>Además suma dos lecturas propias que matizan el argumento</td></tr>
<tr><td><strong>Bitácora metacognitiva</strong> (15 %)</td><td>Falta o es genérica</td><td>Copia los prompts sin analizarlos</td><td>Registra prompts, errores de la IA y correcciones con su porqué</td><td>Muestra cómo cambió su forma de preguntar</td></tr>
<tr><td><strong>Defensa oral</strong> (20 %)</td><td>No puede explicar sus afirmaciones</td><td>Repite el texto y falla ante la variación</td><td>Explica, justifica y responde la variación con razones</td><td>Argumenta bajo presión, reconoce límites y cita lo que la IA omitió</td></tr>
</tbody>
</table>
<p>Una decisión de diseño que te sugiero: que la defensa pueda <strong>topar</strong> la nota del producto. Si el estudiante saca 1 en la defensa, el documento no pasa de 2,5 sobre 5. Así la sustentación no es un adorno. Si preparas estas tareas con IA, el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia para pedir posturas contrastadas, armar bancos de preguntas y redactar rúbricas, siempre con tu criterio como última palabra.</p>

<h3>2. Metacognición y autocorrección: la bitácora de prompts</h3>
<p>Aquí conviene precisar una fuente. La revista RELIEVE publicó en 2026 el instrumento <a href="https://revistaseug.ugr.es/index.php/RELIEVE/article/view/36950" target="_blank" rel="noopener">CriticalAI</a>, de Katherine Sandoval Perdomo y Luis Gibran Juárez Hernández: 48 ítems, seis dimensiones del modelo de Facione (interpretación, análisis, evaluación, inferencia, explicación y autorregulación), con ítems como verificar con fuentes confiables la información obtenida de la IA o identificar sus sesgos. Pero es un <strong>cuestionario de autorreporte</strong> validado en un piloto con 81 estudiantes de salud de una universidad privada de Santiago de Chile, sin análisis factorial todavía. Sirve de inspiración, no de rúbrica lista para calificar. Para eso va la bitácora:</p>
<table>
<caption>Plantilla de bitácora de prompts (una fila por cada intercambio importante)</caption>
<thead><tr><th>N.º</th><th>Prompt (copia literal)</th><th>Qué respondió la IA</th><th>Qué verifiqué y con qué fuente</th><th>Qué corregí o descarté y por qué</th><th>Qué cambiaría en mi próximo prompt</th></tr></thead>
<tbody>
<tr><td>1</td><td>"Dame tres posturas sobre el teletrabajo permanente en pymes colombianas"</td><td>Tres posturas con dos cifras y una cita</td><td>Busqué las cifras en la fuente oficial; una no aparece y la cita no existe</td><td>Descarté la cifra y la cita; usé el dato que sí encontré</td><td>Pedir enlaces y separar hechos de opiniones</td></tr>
<tr><td>2</td><td>(ejemplo ilustrativo para completar)</td><td></td><td></td><td></td><td></td></tr>
</tbody>
</table>

<h3>3. Defensa oral: protocolo de 8 a 10 minutos</h3>
<ol>
<li><strong>Apertura (1 min).</strong> El estudiante resume su tesis, sin diapositivas ni notas.</li>
<li><strong>Profundidad (3 min).</strong> Tres preguntas sobre su análisis y sus fuentes.</li>
<li><strong>Variación (3 min).</strong> Cambias un dato o un supuesto y pides que replantee su conclusión.</li>
<li><strong>Proceso (2 min).</strong> "Muéstreme un momento en que la IA se equivocó y cómo lo notó."</li>
<li><strong>Cierre (1 min).</strong> El estudiante se autoevalúa en una frase y tú calificas con la rúbrica en el momento.</li>
</ol>
<p>Banco de preguntas para empezar: ¿qué parte de este texto no podrías defender sin la IA? ¿Qué afirmación fue la más difícil de verificar? Si la postura contraria fuera cierta, ¿qué evidencia lo mostraría? ¿Qué variable omitió el modelo y por qué importa? Si cambia este dato, ¿se sostiene tu conclusión? ¿Cómo se lo explicarías en 30 segundos a alguien sin formación en el tema? ¿Qué fuente de las que citaste leíste completa? ¿Qué harías distinto en tu primer prompt?</p>
<p>Con 40 estudiantes son unas seis o siete horas, así que puedes hacer <strong>vivas por muestreo</strong> (a una parte elegida al azar, avisando de antemano que cualquiera puede ser llamado) o mini defensas de cinco minutos. Prevé ajustes razonables para quien tenga ansiedad, tartamudez o una discapacidad auditiva (más tiempo, preguntas por escrito, una persona de apoyo). El PIAR del Decreto 1421 de 2017 es para preescolar, básica y media, pero su lógica aplica en cualquier nivel; si enseñas en colegio, <a href="/herramientas/piar/">PIAR con IA</a> te ayuda a construirlo, y el primero es gratis. Y para programar turnos y llevar asistencia sirve un <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">listado de asistencia en Excel</a>.</p>

<h3>4. Declaración de uso y dos carriles: lo que sostiene el sistema</h3>
<p>Nada de lo anterior funciona si el estudiante no sabe qué está permitido. La Universidad de los Andes adoptó, en sus lineamientos, una escala de cinco niveles propuesta por Perkins, Furze, Roe y MacVaugh (2024), que el profesor puede fijar para cada actividad:</p>
<table>
<caption>Escala de uso de IA por actividad (adaptada de los lineamientos de Uniandes, 2024)</caption>
<thead><tr><th>Nivel</th><th>Qué se permite</th><th>Qué debe declarar el estudiante</th></tr></thead>
<tbody>
<tr><td>1</td><td>No usar IA generativa</td><td>Nada</td></tr>
<tr><td>2</td><td>Explorar ideas y estructurar; el material generado no entra en el trabajo</td><td>Que la usó para explorar</td></tr>
<tr><td>3</td><td>Mejorar la claridad de las ideas propias</td><td>Cómo la usó, en nota al pie o anexo</td></tr>
<tr><td>4</td><td>Completar algunos elementos con evaluación humana</td><td>Lo generado entre comillas, su calidad y pertinencia, y un anexo con los prompts</td></tr>
<tr><td>5</td><td>Uso pleno en todo el proceso</td><td>Sin distinguir lo propio de lo generado</td></tr>
</tbody>
</table>
<p>Y una arquitectura de <strong>dos carriles</strong>, inspirada en Sídney: el carril 1 es seguro (presencial y supervisado: examen en aula, defensa oral, práctica en laboratorio) y asegura que se alcanzaron los resultados de aprendizaje; el carril 2 es abierto, con IA permitida y declarada, y enseña a pensar con la herramienta. Para el carril seguro necesitas exámenes que no se resuelvan por chat: el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> crea varias versiones del mismo examen con solucionario, y puedes probarlo gratis en la <a href="/examenes/demo/">demostración</a>. Lo explico en <a href="/generador-de-examenes-con-ia-versiones-solucionario-latex/">este artículo</a>.</p>

<h2>Qué puedes hacer esta semana: docentes y estudiantes</h2>
<h3>Si eres profesor</h3>
<ul>
<li>Pasa tu tarea más "ensayística" por una IA y mira si tu rúbrica la aprobaría; si sí, ya sabes qué rediseñar.</li>
<li>Escribe en el sílabo y en cada consigna el nivel de uso de IA permitido (de 1 a 5).</li>
<li>Agrega una capa a una sola tarea: tres posturas y una auditoría de cinco afirmaciones.</li>
<li>Pide la bitácora con la plantilla de arriba y califica solo lo que puedas leer en diez minutos.</li>
<li>Haz una defensa de cinco minutos a una muestra al azar de tu grupo.</li>
<li>Reserva un examen presencial con versiones distintas para el carril seguro.</li>
<li>No uses un detector como única prueba, jamás para acusar.</li>
</ul>
<h3>Si eres estudiante</h3>
<ul>
<li>Declara siempre cómo usaste la IA, incluso cuando nadie lo pida.</li>
<li>Guarda tu conversación completa: es tu evidencia de trabajo y tu defensa ante una acusación.</li>
<li>Verifica al menos cinco datos de cada respuesta con fuentes primarias, y desconfía de las citas "perfectas".</li>
<li>Pregúntale a la IA "¿en qué podrías estar equivocada?" y contrasta la respuesta con una fuente real.</li>
<li>Pídele que te examine en lugar de que te resuelva: es la diferencia entre un tutor y una muleta.</li>
<li>Practica explicar tu trabajo en voz alta, sin pantalla, antes de entregarlo.</li>
<li>No pegues datos personales ni de terceros en un chat.</li>
</ul>
<p>Si quieres seguir con el otro lado de esta moneda, lo que la IA promete y no cumple, reúno mis análisis en la sección de <a href="/ia-para-docentes/">IA para docentes</a>, junto con <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">"La IA no te va a reemplazar. Quien la domine, sí"</a>. Y si te interesa por qué la modalidad importa menos que la calidad de la evaluación, mira <a href="/educacion-virtual-vs-presencial-colombia-datos/">educación virtual frente a presencial</a>. Lo mismo pasa con las fórmulas: <a href="/excel-esta-muerto-era-de-la-ia/">si una generación pide fórmulas sin aprender a leerlas, firma números que no entiende</a>.</p>

<p class="notice"><strong>Herramientas para evaluar el proceso, no solo el producto.</strong> El <strong>Kit de IA para docentes</strong> trae recetas probadas por materia, alineadas con el currículo colombiano, por 60.000 pesos cada materia. El <strong>Generador de exámenes con IA</strong> crea versiones distintas del mismo examen para tu carril seguro y tiene planes desde 29.900 pesos. <strong>PIAR con IA</strong> te deja hacer un PIAR gratis y luego elegir paquetes de 5, 10 o 20 planes. Ninguna reemplaza tu criterio: están hechas para que lo uses en lo que importa.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">Ver el Kit de IA para docentes</a></p>

<h2>Preguntas frecuentes</h2>
<h3>¿Este estudio prueba que las universidades no innovan con la IA?</h3>
<p>No. Analiza 600 estrategias de 186 docentes de una sola universidad mexicana, registradas en un curso de formación, y refleja intenciones, no prácticas en aula ni resultados de aprendizaje. Es una señal valiosa y consistente con otras revisiones, pero no una prueba sobre "las universidades".</p>
<h3>¿Hay que prohibir la IA en los trabajos universitarios?</h3>
<p>No necesariamente. Prohibir sin poder verificar solo castiga a quien cumple. Una salida más realista es combinar un carril seguro (presencial, sin IA o con IA controlada) con un carril abierto donde la IA está permitida, se declara y se evalúa el proceso.</p>
<h3>¿Sirven los detectores de IA para saber si hubo trampa?</h3>
<p>No como prueba única. En un estudio de 2023, siete detectores marcaron en promedio como generado por IA el 61 % de unos ensayos escritos por personas con otra lengua materna, y OpenAI retiró su propio clasificador por baja precisión. Una conversación con el estudiante, con su bitácora y una defensa oral es más justa.</p>
<h3>¿La defensa oral es viable con grupos de 40 estudiantes?</h3>
<p>Sí, con ajustes: vivas de cinco minutos, defensas a una muestra aleatoria o defensas en parejas. No es gratis en tiempo, pero es la forma más directa de comprobar que el estudiante entiende lo que entregó.</p>
<h3>¿Evaluar el proceso no es mucho más trabajo?</h3>
<p>Al principio, sí: hay que diseñar tareas, rúbricas y plantillas. Después se reutilizan, y la IA puede ayudarte con borradores de retroalimentación, siempre que la decisión sobre qué cuenta como evidencia de aprendizaje siga siendo tuya.</p>

<h2>Para pensar</h2>
<p>Si una IA escribe en 30 segundos un ensayo que aprueba tu rúbrica, ¿el problema está en el estudiante que la usó, en el profesor que diseñó la tarea o en una universidad que durante décadas llamó "aprender" a lo que ahora hace una máquina? <strong>Y si la defensa oral es la respuesta, ¿estamos dispuestos a pagar su costo, con menos estudiantes por profesor y más tiempo para escucharlos, o preferiremos seguir calificando documentos de los que nadie sabe de quién son?</strong></p>
HTML;

$html = strtr($html, [
    '{{img:estudio}}' => $img('espejismo-ia-universidad-estudio', 747, 'Gráfico con las cifras del estudio de 600 estrategias de 186 docentes de la UABC: producción de artefacto 76,7 %, práctica guiada 15,5 %, pensamiento crítico, verificación y ética 11,3 %, retroalimentación 10,7 %, planeación 7,8 %, automatización 5,8 %; indicadores de innovación como colaboración 10,3 %, verificación 9,3 %, iteración 3,5 %, ética 2,8 % y personalización 1,0 %; y evaluación: producto o proyecto 49,0 %, rúbrica 33,5 %, sin criterios 22,5 %, reflexión 5,3 % y examen 3,3 %', 'Lo que declararon los docentes: abundan los artefactos y escasean la verificación, la iteración, la ética y la personalización. Fuente: Ruiz Mendoza y Oviedo González (2026), tablas 2 a 4.'),
    '{{img:uso}}' => $img('espejismo-ia-universidad-uso', 640, 'Barras con la encuesta HEPI de estudiantes del Reino Unido en 2024, 2025 y 2026: uso de IA de alguna forma 66, 92 y 95 por ciento; uso en trabajos evaluados 53, 89 y 94 por ciento; texto de IA incluido tal cual 3, 8 y 12 por ciento; y cuatro tarjetas: 86 por ciento de 3.839 estudiantes de 16 países usa IA, 84 por ciento de estudiantes colombianos la usa con frecuencia y solo 35 por ciento supera el nivel básico, 83 por ciento de 1.681 profesores teme que sus estudiantes no evalúen con criterio lo que produce la IA y menos 17 por ciento de nota en el examen sin IA para quienes practicaron con un chat sin guías', 'Casi todos los estudiantes usan IA. Las tarjetas vienen de encuestas y estudios distintos y no son comparables entre sí. En 2026 HEPI ajustó el dato de 2025 a 89 % (antes 88 %).'),
    '{{img:marco}}' => $img('espejismo-ia-universidad-marco', 667, 'Diagrama: evaluar solo el producto (consigna, la IA redacta, se entrega el documento, nota de quién) frente a evaluar el proceso en cuatro capas (contrastar, auditar, documentar, defender) y, debajo, dos carriles: carril 1 seguro, presencial y supervisado, y carril 2 abierto, con IA permitida y declarada', 'Propuesta de diseño en cuatro capas y dos carriles. Es una propuesta, no evidencia comprobada.'),
]);

return [
    'slug' => 'inteligencia-artificial-educacion-superior-espejismo-evaluacion',
    'title' => 'El espejismo de la IA en la universidad: mucho "artefacto" y poca innovación',
    'excerpt' => 'Un estudio de 600 estrategias de 186 docentes de la UABC (México) halló que la IA generativa se usa sobre todo para producir artefactos, y poco para verificar, iterar o discutir la ética. Verifico lo que dice (y lo que no), lo contrasto con Colombia, América Latina y el mundo, y propongo cómo evaluar el proceso: tareas por capas, bitácora de prompts, defensa oral y dos carriles.',
    'seo_title' => 'IA en la educación superior: más artefactos que innovación',
    'seo_description' => 'Qué dice un estudio de 600 estrategias docentes con IA generativa, sus límites y cómo evaluar el proceso: tareas por capas, bitácora y defensa oral.',
    'focus_keyword' => 'IA en la educación superior',
    'cover' => '/assets/img/articulos/espejismo-ia-universidad/espejismo-ia-universidad-portada',
    'cover_alt' => 'Portada El espejismo de la IA en la universidad: mucho artefacto, poca innovación, con las cifras del estudio de la UABC: producción de artefactos 76,7 %, pensamiento crítico, verificación y ética 11,3 %, iteración 3,5 % y personalización 1,0 %',
    'published_at' => '2026-10-10 13:00:00',
    'content_html' => $html,
];
