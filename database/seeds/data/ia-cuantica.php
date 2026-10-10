<?php

declare(strict_types=1);

// "Inteligencia artificial cuántica". Escrito según la guía editorial de Edwin (guia_articulo_inteligencia_artificial_cuantica.md, 10-oct-2026). Fuentes comprobadas el 10-oct-2026: NIST (página actualizada 28-may-2026), Gokhale et al. 2026 (Discover Computing, 24-abr-2026; Crossref), Gundlach et al. ICML 2026 (PMLR 306), Tera et al. 2026 (ESWA, julio; solo datos bibliográficos), Rodriguez-Diaz et al. 2025 (ACM CSUR), Hong y Lopez 2025 (IEEE Access; la URL de la guía tenía un error: "of" en vez de "on"), IBM (página 12-sep-2024, actualizada 14-abr-2026), Bowles-Ahmed-Schuld arXiv 2403.07059 (12 modelos, 6 tareas, 160 conjuntos; ~40 % de 55 artículos), Huang 2021/2022, Cerezo 2025, McClean 2018, Aaronson 2015, Liu 2021, Tang 2018, Insilico/U. Toronto (Nat. Biotechnol. 2025; la nota dice que no se demuestra superioridad frente a métodos clásicos), HSBC/IBM 25-sep-2025 (disputado; crítica de Aaronson), AlphaQubit (Nature 2024). Libro verificado en Excel 16 y Python: 6 afirmaciones ficticias, puntajes 0/6/3/4/0/8, 4 sobrepromesas. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-cuantica/' . $name;
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
<p>¿Qué tendría que demostrar una tecnología cuántica para ser mejor que la inteligencia artificial que ya funciona, hoy, en computadores convencionales? La pregunta parece sencilla y es la más importante de todo el debate. Se habla mucho de la unión entre IA y computación cuántica porque ambas prometen resolver problemas que hoy cuestan demasiado tiempo o energía, y porque hay una motivación científica real: ciertos problemas de la física y la química son, por su propia naturaleza, cuánticos. Pero <strong>una cosa es el potencial científico y otra la superioridad demostrada</strong>: hasta hoy no existe una ventaja general de los métodos cuánticos para las tareas habituales de la IA.</p>
<p>Este artículo separa tres planos que suelen mezclarse: las <strong>expectativas</strong> (lo que se promete), los <strong>resultados</strong> (lo que se ha medido, y en qué condiciones) y las <strong>aplicaciones prácticas</strong> (lo que ya se usa). Incluye un <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">libro de Excel</a> para auditar afirmaciones con un marco de cinco niveles de evidencia (con seis afirmaciones ficticias, verificado en Microsoft Excel 16) y una lista de fuentes que consulté y comprobé el <strong>10 de octubre de 2026</strong>. Si necesitas lo básico de la computación cuántica, lo explico con dados y monedas en <a href="/computacion-cuantica-para-que-sirve-como-cambiara-el-mundo/">la computación cuántica: para qué sirve y cómo podría cambiar el mundo</a>.</p>
<p class="notice"><strong>Cómo leer este artículo.</strong> Cada resultado se etiqueta como <em>teórico</em>, <em>simulado</em>, <em>experimental en hardware</em>, <em>validado en un entorno aplicado</em> o <em>desplegado comercialmente</em>, porque no son lo mismo. Las afirmaciones de empresas se identifican como tales. Los datos del libro de Excel son ficticios. Esto no es asesoría de inversión.</p>

<h2>¿Qué es la inteligencia artificial cuántica?</h2>
<p>La expresión es ambigua: se usa para tres líneas de trabajo distintas.</p>
{{img:lineas}}
<ol>
<li><strong>Aprendizaje automático cuántico (<em>quantum machine learning</em>, QML):</strong> usar circuitos y procesadores cuánticos para realizar o mejorar tareas de aprendizaje automático, incluidos los modelos <em>híbridos</em>, en los que una parte del flujo corre en un sistema clásico y otra en un procesador cuántico.</li>
<li><strong>IA aplicada a la ciencia y a los sistemas cuánticos:</strong> usar IA convencional para diseñar experimentos, calibrar procesadores, analizar mediciones o <em>corregir errores</em>. Un ejemplo: <strong>AlphaQubit</strong>, de Google DeepMind y Google Quantum AI (Bausch y colaboradores, <em>Nature</em>, noviembre de 2024), una red neuronal que aprende a decodificar los errores de un procesador cuántico. La IA corre en hardware clásico; lo cuántico es su objeto de estudio.</li>
<li><strong>Algoritmos clásicos inspirados en lo cuántico:</strong> se ejecutan en computadores comunes; solo sus ideas vienen de métodos cuánticos. No son computación cuántica, y confundirlos es una fuente frecuente de titulares engañosos.</li>
</ol>
<p>Este artículo se centra en la primera línea y menciona las otras dos donde corresponde. QML <strong>no</strong> es "una IA más potente" ni un sinónimo de cualquier aplicación que mencione la física cuántica.</p>

<h2>Los conceptos cuánticos mínimos (sin convertirlo en un tratado)</h2>
<ul>
<li><strong>Qubit:</strong> la unidad de información cuántica. A diferencia del bit, que vale 0 o 1, un qubit puede estar en una combinación de ambos estados. El Instituto Nacional de Estándares y Tecnología de Estados Unidos (NIST) explica que cada qubit adicional duplica el número de combinaciones posibles.</li>
<li><strong>Superposición:</strong> un estado descrito como combinación de estados básicos, con "amplitudes". <strong>No equivale a leer todas las respuestas a la vez</strong>: es la imagen más repetida y más engañosa.</li>
<li><strong>Entrelazamiento:</strong> correlaciones entre qubits que no se pueden describir como si cada uno fuera independiente.</li>
<li><strong>Interferencia:</strong> las amplitudes se combinan y pueden reforzar o cancelar la probabilidad de ciertos resultados. Los algoritmos cuánticos útiles organizan la interferencia para que las respuestas correctas se refuercen.</li>
<li><strong>Medición:</strong> convierte el estado cuántico en un resultado clásico, de forma probabilística. De una medición no se recupera toda la información de la superposición.</li>
<li><strong>Ruido y decoherencia:</strong> el entorno degrada los estados y las operaciones. Según NIST (página consultada el 10 de octubre de 2026), los mejores equipos actuales cometen del orden de un error por cada mil operaciones, frente a uno por cada quintillón en un computador clásico, y, según la misma página, la mayoría de las aplicaciones están a años o décadas de distancia.</li>
</ul>
<p>Una analogía útil, con sus límites: un qubit se parece menos a un interruptor que a una onda cuya forma se puede combinar con otras; pero medirlo "colapsa" la onda en un 0 o un 1.</p>

<h2>Cómo funciona un modelo de aprendizaje automático cuántico</h2>
<p>El flujo típico de un modelo híbrido es este:</p>
<ol>
<li><strong>Se seleccionan y preparan los datos</strong> (clásicos, casi siempre).</li>
<li><strong>Se codifican</strong> en un estado o circuito cuántico. Es un paso costoso y delicado.</li>
<li>Un <strong>circuito cuántico parametrizado</strong> (un conjunto de operaciones con parámetros ajustables) transforma el estado.</li>
<li><strong>Se mide</strong> el sistema, muchas veces, para estimar probabilidades; el resultado es clásico.</li>
<li>Un <strong>optimizador clásico</strong> ajusta los parámetros y se repite el ciclo.</li>
<li><strong>Se evalúa</strong> el modelo con datos de prueba y frente a líneas base clásicas.</li>
</ol>
<p>Hay varias familias: los <em>algoritmos variacionales</em> (el ciclo anterior), los <em>métodos de kernel cuánticos</em> (usar el procesador cuántico para calcular una medida de similitud entre datos, que luego alimenta un clasificador clásico) y los modelos generativos. En todos, el coste total incluye la preparación de datos, las mediciones repetidas, el ruido y la comunicación entre procesadores, no solo el tiempo del circuito.</p>

<h2>Diferencias frente a la IA clásica</h2>
<table>
<thead><tr><th>Aspecto</th><th>IA clásica</th><th>Aprendizaje automático cuántico</th></tr></thead>
<tbody>
<tr><td>Infraestructura</td><td>CPU, GPU y otros aceleradores convencionales</td><td>Simuladores, procesadores cuánticos y sistemas híbridos</td></tr>
<tr><td>Madurez</td><td>Amplio ecosistema y muchas aplicaciones productivas</td><td>Campo emergente; utilidad práctica limitada a casos específicos</td></tr>
<tr><td>Datos</td><td>Procesamiento directo en representaciones clásicas</td><td>Puede requerir codificar datos clásicos en estados cuánticos</td></tr>
<tr><td>Evaluación</td><td>Métodos y líneas base maduras en muchos dominios</td><td>Exige controles rigurosos y comparaciones clásicas competitivas</td></tr>
<tr><td>Ventaja general</td><td>Rendimiento conocido según la tarea</td><td>No hay una ventaja general demostrada en todas las tareas de IA</td></tr>
</tbody></table>
<p>La tabla describe tendencias, no reglas sin excepciones, y comparar un algoritmo cuántico de laboratorio con un modelo clásico deliberadamente débil no vale como evidencia.</p>

<h2>Aplicaciones: potencial, demostraciones y utilidad</h2>
<p>Para cada caso hago las mismas cinco preguntas: qué problema resuelve, por qué sería difícil para los métodos clásicos, qué enfoque cuántico se propone, qué evidencia se ha publicado y si se demostró una ventaja total y práctica frente a una alternativa clásica competitiva.</p>
<h3>1. Aprender a partir de experimentos cuánticos (física)</h3>
<p><strong>Etiqueta: experimental en hardware, en un escenario construido.</strong> Huang y colaboradores (<em>Science</em>, junio de 2022) probaron, con el procesador Sycamore de Google (hasta 40 qubits y 1.300 compuertas), que una máquina que aprende con memoria cuántica puede necesitar exponencialmente menos experimentos que una máquina clásica sin ella para ciertas tareas sobre sistemas cuánticos. Es de los pocos resultados con una separación <em>demostrable</em>, pero Google mismo lo presenta como una prueba de principio, con un estado preparado a propósito, y la ventaja es en <em>cantidad de experimentos necesarios</em> para aprender sobre sistemas cuánticos, no en tareas de IA corrientes. Un trabajo previo del mismo grupo, "Power of data in quantum machine learning" (<em>Nature Communications</em>, 2021), mostró además que los datos importan: un modelo clásico con acceso a datos puede igualar a los cuánticos en muchos casos.</p>
<h3>2. Descubrimiento de fármacos (salud y bioinformática)</h3>
<p><strong>Etiqueta: demostración experimental con validación de laboratorio; ventaja cuántica no demostrada.</strong> Un equipo de la Universidad de Toronto e Insilico Medicine (<em>Nature Biotechnology</em>, enero de 2025) combinó un modelo generativo cuántico-clásico con la plataforma de IA Chemistry42 para proponer moléculas contra KRAS, una proteína del cáncer considerada difícil de atacar. Se entrenó con 1,1 millones de moléculas, de las que 15 candidatas pasaron a pruebas de laboratorio y dos mostraron actividad en células. Pero, según la propia nota de la Universidad de Toronto, los investigadores afirman que los resultados <strong>no demuestran que las moléculas sean más eficaces que las que se obtienen con métodos clásicos</strong>, y uno de los autores, Alán Aspuru-Guzik, señala que el estudio no ofrece ningún indicio de una ventaja cuántica significativa. Es una prueba de concepto sobre el uso de un componente cuántico en un flujo de trabajo, no una prueba de que sea mejor.</p>
<h3>3. Finanzas</h3>
<p><strong>Etiqueta: ensayo en hardware con datos reales; disputado.</strong> En septiembre de 2025, HSBC e IBM comunicaron una mejora "de hasta" 34 % al predecir si una operación de bonos corporativos europeos se ejecutaría al precio cotizado, con procesadores IBM Heron y datos de negociación reales, en un ensayo y no en operación en vivo. Es una <strong>afirmación empresarial</strong> y fue cuestionada: el científico de la computación Scott Aaronson la calificó de "qombie" (un zombi de ventaja cuántica) y los críticos señalaron que la mejora no se reprodujo en una simulación sin ruido, lo que sugiere que el efecto podría venir de las particularidades del ruido o de la comparación, y que un método clásico de regularización podría replicarla. Los autores y los directivos de IBM matizaron que no presentaban el resultado como una ventaja cuántica demostrada. Es un buen ejemplo de por qué la línea base importa.</p>
<h3>4. Recomendación y álgebra lineal (teoría, y una lección de "desquantización")</h3>
<p><strong>Etiqueta: teórico.</strong> En 2016 se propuso un algoritmo cuántico para sistemas de recomendación (del tipo de Amazon o Netflix) con una aceleración exponencial. En 2018, Ewin Tang, entonces estudiante de pregrado, publicó un algoritmo <em>clásico</em> "inspirado en lo cuántico" que resolvía el mismo problema con una diferencia solo polinomial, y trabajos posteriores extendieron el método a otros algoritmos (análisis de componentes principales, máquinas de vectores de soporte, regresión de bajo rango). Es el caso más citado de "desquantización": una supuesta ventaja exponencial desapareció cuando se pensó mejor el método clásico. Otro resultado, de Liu, Arunachalam y Temme (<em>Nature Physics</em>, 2021), demuestra una aceleración cuántica rigurosa en aprendizaje supervisado, pero para un problema matemático construido a propósito (basado en el logaritmo discreto), no para datos típicos de IA.</p>
<p><strong>La lección común:</strong> las ventajas más sólidas aparecen en problemas diseñados con estructura cuántica o matemática especial; las más débiles, en tareas generales de IA con datos corrientes.</p>

<h2>Límites técnicos y económicos</h2>
<ul>
<li><strong>Ruido y corrección de errores.</strong> Cálculos largos y fiables exigen corrección de errores, que a su vez requiere muchos qubits físicos por cada qubit lógico fiable; el número de qubits físicos no es el de qubits lógicos. IBM, en su descripción de la "supercomputación centrada en lo cuántico" (página publicada en 2024 y actualizada en abril de 2026), plantea una hoja de ruta de 200 qubits lógicos con cien millones de puertas para 2029: es una <strong>proyección empresarial</strong>, no un resultado, y la propia página reconoce que la ventaja cuántica plena todavía se busca.</li>
<li><strong>Carga de datos.</strong> Codificar datos clásicos en un estado cuántico puede costar tanto que elimine la ventaja teórica; Scott Aaronson lo llamó "la letra pequeña" de muchos algoritmos (<em>Nature Physics</em>, 2015). Algunos algoritmos dependen de una memoria cuántica de acceso aleatorio (QRAM) que todavía no existe en la práctica.</li>
<li><strong>Entrenamiento y <em>barren plateaus</em>.</strong> En 2018, McClean y colaboradores (<em>Nature Communications</em>) mostraron que, en circuitos aleatorios profundos, los gradientes se vuelven exponencialmente pequeños con el número de qubits, lo que dificulta el entrenamiento. Un trabajo de Cerezo y colaboradores (<em>Nature Communications</em>, 2025) argumenta que muchos de los modelos que evitan esos "mesetas estériles" también pueden simularse con eficiencia en computadores clásicos, lo que pone en duda su ventaja; los autores señalan salvedades y proponen usar los dispositivos cuánticos para obtener datos más que para entrenar.</li>
<li><strong>Benchmarks débiles.</strong> Bowles, Ahmed y Schuld (Xanadu, 2024) probaron 12 modelos populares de QML en 6 tareas de clasificación, con 160 conjuntos de datos: en promedio, los modelos clásicos listos para usar superaron a los clasificadores cuánticos, y quitar el entrelazamiento a menudo no empeoraba (o mejoraba) el resultado. Antes, al revisar 55 artículos que mencionaban "quantum machine learning" y "outperform", cerca del 40 % reportaba superar a un modelo clásico y solo tres no lo hacían. Es una señal de sesgo en la literatura, no una refutación del campo.</li>
<li><strong>Velocidad de operación.</strong> Gundlach, Kukina, Lynch y Thompson (ICML 2026, artículo de posición) argumentan que haría falta un "salto cuántico" para que los computadores cuánticos tengan un impacto significativo en el aprendizaje profundo en la próxima década o dos: las mejoras teóricas en multiplicación de matrices se pierden con tamaños prácticos porque cada operación cuántica es lenta, algunos algoritmos dependen de una QRAM poco desarrollada y otros solo se aplican a casos especiales.</li>
<li><strong>Coste de extremo a extremo.</strong> Medir solo el tiempo del circuito, sin preparación, repeticiones, transferencia, procesamiento y optimización, da una comparación incompleta.</li>
</ul>
<p>No todo son imposibilidades definitivas: unas son barreras actuales de ingeniería (ruido, escala) y otras dependen del algoritmo, los datos y el problema. Las revisiones recientes del campo coinciden en un mapa parecido: <em>Gokhale, Dhote y Delhibabu</em> (<em>Discover Computing</em>, abril de 2026) analizan dónde los modelos cuánticos han mostrado ventajas y dónde se quedan atrás, y señalan como retos abiertos la preparación de estados, la escalabilidad y los estándares de evaluación; <em>Rodríguez-Díaz y colaboradores</em> (<em>ACM Computing Surveys</em>, octubre de 2025) revisan más de 135 artículos y analizan las limitaciones de hardware, las tasas de error y la escalabilidad.</p>

<h2>Cómo evaluar una afirmación: cinco niveles de evidencia</h2>
{{img:niveles}}
<p>Una afirmación no merece el mismo crédito si es una idea teórica, una simulación, una demostración en hardware, una ventaja comparativa o una utilidad práctica. Los cinco niveles de la figura ordenan esa diferencia: (1) <em>fundamento teórico</em>, (2) <em>resultado simulado</em>, (3) <em>demostración experimental</em>, (4) <em>ventaja comparativa</em> (supera una línea base clásica competitiva, con costes contabilizados) y (5) <em>utilidad práctica</em> (reproducible y valiosa en un entorno real). Y antes de aceptar la expresión "ventaja cuántica demostrada", hay que preguntar <strong>qué ventaja</strong>, <strong>para qué tarea</strong>, <strong>contra qué método</strong> y <strong>en qué condiciones</strong>.</p>
<p>El <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">libro de Excel</a> convierte el marco en una auditoría: para cada afirmación se registran el nivel que <em>afirma</em> la fuente y el nivel que <em>sustenta</em> la evidencia, y ocho preguntas de sí o no (¿define la ventaja?, ¿dice contra qué método se compara?, ¿incluye los costes completos?, ¿la línea base es sólida?, ¿se ejecutó en hardware real?, ¿se reprodujo o hay código y datos?, ¿pasó revisión por pares?, ¿declara el interés comercial?). Calcula el puntaje, la calificación (Sólida, Parcial o Débil) y la <strong>brecha</strong> entre lo que se afirma y lo que se demuestra.</p>
<pre><code>' Puntaje: cuántas de las 8 preguntas se responden con un sí (E:L)
=CONTAR.SI(E4:L4;"Sí")                                                           ' español
=COUNTIF(E4:L4,"Sí")                                                             ' inglés

' Calificación según los cortes de la hoja Parametros
=SI(M4>=Parametros!$B$3;"Sólida";SI(M4>=Parametros!$B$4;"Parcial";"Débil"))      ' español
=IF(M4>=Parametros!$B$3,"Sólida",IF(M4>=Parametros!$B$4,"Parcial","Débil"))      ' inglés

' Brecha de nivel: lo que la fuente afirma menos lo que la evidencia sustenta
=C4-D4</code></pre>
{{img:auditoria}}
<p>Con seis afirmaciones <strong>ficticias</strong>, que representan patrones frecuentes (no estudios ni empresas reales): 1 sólida, 2 parciales y 3 débiles; puntaje promedio de 3,5 sobre 8; y <strong>4 con "sobrepromesa"</strong> (afirman un nivel dos o más escalones por encima del que sustenta la evidencia), con una brecha máxima de 3 niveles. Solo una cumple la mayoría de las preguntas, y es una que informa un <strong>resultado negativo</strong> (un circuito de 8 qubits que queda 2 puntos por debajo de una red clásica pequeña) con código, datos y costes completos. Es la ilustración de una idea sencilla: <strong>la calidad de una afirmación no se mide por lo espectacular, sino por lo comprobable</strong>. Solo 2 de las 6 usan una línea base clásica sólida, solo 1 incluye los costes completos y solo 1 está reproducida.</p>
<p><strong>Una lectura honesta:</strong> el libro no valida la ciencia de un artículo; ordena preguntas. Los puntajes dependen de quien los asigna, y un "sí" mal respondido invalida la auditoría. Úsalo como una lista de comprobación para leer con cuidado, no como un veredicto.</p>

<h2>Implicaciones para empresas y educación</h2>
<p><strong>En empresas,</strong> la actitud sensata es una <em>vigilancia informada</em> y, si corresponde, <strong>pruebas de concepto acotadas</strong>, no inversiones basadas en publicidad. Antes de adoptar una solución, conviene preguntar: ¿qué indicador de negocio debería mejorar?, ¿cuál es la línea base clásica más sólida (un buen solver, una heurística bien ajustada, un modelo de IA convencional)?, ¿se incluye el coste completo del servicio y de la preparación de datos?, ¿la mejora se reproduce fuera de una demostración controlada?, ¿el proveedor publica métodos, métricas y condiciones para auditar la afirmación? Y recuerda que quien comunica un resultado suele tener un interés comercial.</p>
<p><strong>En educación,</strong> el objetivo no es convertir una tendencia en una obligación curricular, sino enseñar a <em>evaluar tecnología emergente</em>: alfabetización cuántica básica, pensamiento computacional, fundamentos de probabilidad y álgebra lineal, y experimentación con simuladores (varias plataformas permiten ejecutar circuitos cuánticos en la nube o en simulador sin costo). No hace falta prometer que el alumnado usará computadores cuánticos en tareas ordinarias en el corto plazo. Para la misma actitud crítica frente a la IA en general, ver <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">la gran mentira de la IA</a> y <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">el espejismo de la IA en la educación superior</a>.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>El mapa del mundo cuántico está dominado por Estados Unidos, China y Europa, con inversiones estatales importantes y empresas que publican hojas de ruta; en América Latina y Colombia, la participación se da sobre todo a través de la investigación universitaria, algunas iniciativas nacionales y el acceso a procesadores y simuladores por la nube (más detalle en <a href="/computacion-cuantica-para-que-sirve-como-cambiara-el-mundo/">el artículo sobre computación cuántica</a>). Para un colegio, una universidad o una empresa de la región, la pregunta práctica no es "¿compramos un computador cuántico?" (no tiene sentido) sino "¿qué necesitamos saber para no dejarnos engañar, y qué capacidades humanas conviene formar (matemáticas, programación, pensamiento crítico) que sirven tanto si la tecnología llega como si no?".</p>
<p>Para los <strong>docentes</strong>, se trata de enseñar a distinguir ciencia, demostración y marketing; para los <strong>directivos</strong>, de no invertir por moda y de exigir comparaciones justas; para las <strong>familias</strong>, de desconfiar de titulares que prometen "revoluciones" con fecha; y para los <strong>estudiantes</strong>, de entender que el criterio con el que se juzga esta tecnología (qué problema resuelve, frente a qué alternativa y a qué coste) sirve para juzgar cualquier otra.</p>

<h2>Herramientas y plantillas</h2>
<p>Si quieres aplicar este tipo de lectura crítica a tus propios proyectos con IA, o preparas materiales de clase con ayuda de IA (revisando siempre lo que produce y sin incluir datos de estudiantes en herramientas que no estén diseñadas para custodiarlos), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel con inteligencia artificial</a>, <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">el libro de auditoría de afirmaciones</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (comprobadas el 10 de octubre de 2026)</h2>
<p>Las revisiones ofrecen un mapa del campo, pero no sustituyen la lectura del estudio original cuando se afirma una ventaja. Tipo de fuente entre paréntesis.</p>
<ul>
<li><strong>NIST,</strong> <a href="https://www.nist.gov/quantum-information-science/quantum-computing-explained">"Quantum Computing Explained"</a> (institucional, divulgación técnica; página creada en marzo de 2025 y actualizada en mayo de 2026).</li>
<li><strong>Gokhale, Dhote y Delhibabu (2026),</strong> <a href="https://link.springer.com/article/10.1007/s10791-026-10085-1">"A review of quantum machine learning algorithms, applications, and emerging advantages"</a>, <em>Discover Computing</em>, 24 de abril de 2026 (revisión; datos bibliográficos y resumen comprobados con el registro Crossref).</li>
<li><strong>Gundlach, Kukina, Lynch y Thompson (2026),</strong> <a href="https://proceedings.mlr.press/v306/gundlach26a.html">"Position: Quantum Deep Learning Still Needs a Quantum Leap"</a>, ICML 2026, PMLR 306 (artículo de posición, perspectiva crítica).</li>
<li><strong>Tera, Chinthaginjala, Zhao y Hamdi (2026),</strong> <a href="https://doi.org/10.1016/j.eswa.2026.132127">"Advancing quantum machine learning from conceptual design to practical use"</a>, <em>Expert Systems with Applications</em>, julio de 2026 (revisión; comprobé los datos bibliográficos, no el texto completo).</li>
<li><strong>Rodríguez-Díaz, Gutiérrez-Avilés, Troncoso y Martínez-Álvarez (2025),</strong> <a href="https://doi.org/10.1145/3764582">"A Survey of Quantum Machine Learning: Foundations, Algorithms, Frameworks, Data and Applications"</a>, <em>ACM Computing Surveys</em>, octubre de 2025 (revisión).</li>
<li><strong>Hong y Lopez (2025),</strong> <a href="https://ieeeaccess.ieee.org/featured-article/a-review-on-quantum-machine-learning-in-applied-systems-and-engineering/">"A Review on Quantum Machine Learning in Applied Systems and Engineering"</a>, <em>IEEE Access</em>, agosto de 2025 (revisión; los ejemplos de aplicación deben verificarse uno a uno).</li>
<li><strong>IBM,</strong> <a href="https://www.ibm.com/think/topics/quantum-centric-supercomputing">"What is quantum-centric supercomputing?"</a> (fuente empresarial: describe una arquitectura y proyecciones, no resultados independientes).</li>
<li><strong>Bowles, Ahmed y Schuld (2024),</strong> <a href="https://arxiv.org/abs/2403.07059">"Better than classical? The subtle art of benchmarking quantum machine learning models"</a>, arXiv:2403.07059 (estudio primario de evaluación).</li>
<li><strong>Huang et al. (2022),</strong> "Quantum advantage in learning from experiments", <em>Science</em> (<a href="https://research.google/blog/quantum-advantage-in-learning-from-experiments/">explicación de Google Research</a>), y <strong>Huang et al. (2021),</strong> "Power of data in quantum machine learning", <em>Nature Communications</em> 12.</li>
<li><strong>Cerezo et al. (2025),</strong> "Does provable absence of barren plateaus imply classical simulability?", <em>Nature Communications</em> 16, 7907; <strong>McClean et al. (2018),</strong> "Barren plateaus in quantum neural network training landscapes", <em>Nature Communications</em> 9; <strong>Aaronson (2015),</strong> "Read the fine print", <em>Nature Physics</em> 11, 291-293; <strong>Liu, Arunachalam y Temme (2021),</strong> <em>Nature Physics</em> 17, 1013-1017; <strong>Tang (2018),</strong> "A quantum-inspired classical algorithm for recommendation systems" (arXiv; STOC 2019).</li>
<li><strong>Ghazi Vakili et al. (2025),</strong> "Quantum-computing-enhanced algorithm unveils potential KRAS inhibitors", <em>Nature Biotechnology</em> 43, 1954-1959 (<a href="https://www.utoronto.ca/news/ai-quantum-computing-used-target-undruggable-cancer-protein">nota de la Universidad de Toronto</a>); <strong>HSBC,</strong> <a href="https://www.hsbc.com/news-and-views/news/media-releases/2025/hsbc-demonstrates-worlds-first-known-quantum-enabled-algorithmic-trading-with-ibm">comunicado del 25 de septiembre de 2025</a> (fuente empresarial) y la <a href="https://scottaaronson.blog/?p=9170">crítica de Scott Aaronson</a> (opinión de un especialista); <strong>Bausch et al. (2024),</strong> "Learning high-accuracy error decoding for quantum processors", <em>Nature</em> 635, 834-840 (AlphaQubit).</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la inteligencia artificial cuántica?</h3>
<p>Una expresión ambigua que designa, sobre todo, el aprendizaje automático cuántico (usar procesadores cuánticos en tareas de aprendizaje), pero también la IA aplicada a sistemas cuánticos y los algoritmos clásicos inspirados en lo cuántico.</p>
<h3>¿La IA cuántica es más rápida que la IA tradicional?</h3>
<p>No hay una ventaja general demostrada. Se investiga si ciertos algoritmos aportan ventajas en tareas específicas; el resultado depende del problema, de la comparación y de los costes incluidos.</p>
<h3>¿Un computador cuántico con más qubits es siempre mejor?</h3>
<p>No. Importan también la fidelidad, la conectividad, la corrección de errores, la profundidad del circuito y el coste, no solo el número de qubits.</p>
<h3>¿Reemplazará la IA cuántica a las GPU?</h3>
<p>Lo que se estudia es si los sistemas cuánticos pueden ser complementos de la computación clásica en flujos de trabajo específicos; no hay evidencia de un reemplazo general.</p>
<h3>¿Cómo sé si una noticia sobre ventaja cuántica es confiable?</h3>
<p>Pregunta qué ventaja, para qué tarea, contra qué método y en qué condiciones; busca el artículo original, los costes incluidos, la línea base clásica y si otro grupo la reprodujo.</p>

<p class="notice"><strong>Audita una afirmación que hayas leído.</strong> Descarga el <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">libro de auditoría</a>, reemplaza los ejemplos por una noticia o artículo real y responde las ocho preguntas antes de compartirlo.</p>

<h2>Para pensar</h2>
<p>La pregunta importante no es si la inteligencia artificial cuántica suena más avanzada, sino <strong>qué problema consigue resolver, frente a qué alternativa y a qué coste</strong>. La evidencia, y no la etiqueta tecnológica, determinará cuándo una posibilidad científica se convierte en una ventaja práctica. <strong>¿Qué tendría que demostrar para ti una tecnología nueva antes de que cambiaras lo que haces hoy? Y ¿cuántas de las promesas tecnológicas que has aceptado en los últimos años pasarían esa prueba?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:lineas}}' => $img('ia-cuantica-lineas', 444, 'Tabla con tres líneas de trabajo que se confunden bajo la expresión inteligencia artificial cuántica: aprendizaje automático cuántico, IA para lo cuántico y algoritmos inspirados en lo cuántico, con dónde corre cada una y un ejemplo.', 'No todo lo "cuántico" en IA es lo mismo.'),
    '{{img:niveles}}' => $img('ia-cuantica-niveles', 467, 'Cinco niveles de evidencia para evaluar una afirmación sobre IA cuántica: teoría, simulación, hardware, ventaja comparativa y utilidad práctica.', 'Cinco niveles de evidencia.'),
    '{{img:auditoria}}' => $img('ia-cuantica-auditoria', 524, 'Gráfico de barras con el puntaje, de 8, de seis afirmaciones ficticias auditadas: 0, 6, 3, 4, 0 y 8.', 'Auditoría de seis afirmaciones ficticias.'),
]);

return [
    'slug' => 'inteligencia-artificial-cuantica-aplicaciones-limites',
    'title' => 'Inteligencia artificial cuántica: entre la revolución tecnológica y las promesas que aún deben demostrarse',
    'excerpt' => 'La inteligencia artificial cuántica combina investigación en computación cuántica y aprendizaje automático. Qué es, qué se ha demostrado de verdad, sus límites y cómo evaluar una afirmación con cinco niveles de evidencia y un libro de Excel.',
    'seo_title' => 'IA cuántica: qué es, aplicaciones y límites',
    'seo_description' => 'Qué es la inteligencia artificial cuántica, cómo funciona el aprendizaje automático cuántico, sus aplicaciones y qué falta demostrar para una ventaja real.',
    'focus_keyword' => 'inteligencia artificial cuántica',
    'cover' => '/assets/img/articulos/ia-cuantica/ia-cuantica-portada',
    'cover_alt' => 'Portada "Inteligencia artificial cuántica: entre la revolución y las promesas que faltan por demostrar" con una tarjeta: 5 niveles de evidencia separan una idea teórica de una utilidad práctica demostrada.',
    'published_at' => '2026-10-10 18:40:00',
    'content_html' => $html,
];
