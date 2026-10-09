<?php

declare(strict_types=1);

// Artículo de opinión con datos: «La gran mentira de la IA: la inteligencia artificial no piensa, pero eso no te deja tranquilo»
// (hub IA para docentes; producto relacionado: Kit de IA para docentes, SKU EO-KIT-IA). Cifras, normas y estudios verificados el
// 9 de octubre de 2026 con fuentes enlazadas (Foro Económico Mundial, FAO, Statista/IDC, NCTM, OCDE TALIS, Icfes, DANE, OMS,
// Stanford, Anthropic, UNESCO, Unión Europea y normas de Colombia, Brasil, Perú, Chile, Estados Unidos y China).
// El texto va en nowdoc; las figuras se insertan con marcadores {{img:…}} y los enlaces externos reciben target/rel al final.
// Programado: se publica el 10 de octubre de 2026 a las 7:00 a. m. (hora de Bogotá).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/gran-mentira-ia/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Durante años he defendido en salas de profesores, clases y conferencias una tesis incómoda: <strong>llamar «inteligentes» a las computadoras es una de las mayores confusiones semánticas de nuestro siglo</strong>. Las máquinas procesan datos, no tienen voluntad y, mientras no se demuestre lo contrario, los humanos seguimos al mando. Llevo más de veinte años enseñando matemáticas y tecnología, y he visto llegar la calculadora, el computador, Internet y ahora los asistentes de IA. Cada vez, alguien anunció el fin del pensamiento. Cada vez, el pensamiento sobrevivió.</p>
<p>Pero una tesis que no resiste a sus mejores críticos no merece defenderse. Así que hice lo que le pido a mis estudiantes: revisé las fuentes. El resultado es que <strong>la inteligencia artificial no piensa como una persona</strong>, pero la pregunta es más difícil de lo que parece, cuatro cifras que yo repetía estaban desactualizadas o mal citadas, y el verdadero riesgo no es el que vende el miedo ni el que vende la tranquilidad. En este artículo te cuento qué se sostiene, qué corregí, qué dicen los mejores argumentos en contra y qué hacer en Colombia, en América Latina y en el aula. Si quieres la versión práctica sobre empleo, lee antes <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">La IA no te va a reemplazar. Quien la domine, sí</a>.</p>

<h2>Por qué «inteligencia artificial» es un nombre que confunde</h2>
<p>El término nació en 1955, cuando John McCarthy, Marvin Minsky, Nathaniel Rochester y Claude Shannon propusieron un taller de verano en Dartmouth. Fue un nombre de campaña: servía para pedir financiación. Siete décadas después sigue cumpliendo esa función. Un modelo de lenguaje como los que usamos hoy se entrena para predecir la siguiente palabra a partir de cantidades enormes de texto y luego se refina con retroalimentación humana. No tiene cuerpo, no tiene hambre, no sufre las consecuencias de lo que dice y no persigue metas propias.</p>
<p>Nuestra reacción ante su fluidez es antigua. En 1966, Joseph Weizenbaum construyó en el MIT un programa de conversación sencillísimo, ELIZA, y se horrorizó al ver que personas cultas le atribuían comprensión y le confiaban sus problemas. Hablar bien parece una prueba de pensar. No lo es. En eso mi tesis se sostiene: <strong>la fluidez no es comprensión</strong>, y quien lo olvida entrega su criterio a un generador de frases plausibles. Y no la confundas con otras tecnologías con su propio ruido: la <a href="/computacion-cuantica-para-que-sirve-como-cambiara-el-mundo/">computación cuántica</a>, por ejemplo, promete mucho y se explica mejor con datos que con titulares.</p>

<h2>¿Piensan las máquinas? Lo que la ciencia sabe y lo que no</h2>
<p>Aquí tengo que corregirme. En mi borrador original escribí que las computadoras «no comprenden absolutamente nada» y que «jamás pensarán». Son frases que suenan firmes, pero la primera es más fuerte de lo que la evidencia permite y la segunda es una predicción que nadie puede probar. Veamos por qué.</p>

<h3>La habitación china de Searle y sus críticos</h3>
<p>En 1980, el filósofo John Searle propuso un experimento mental: una persona que no sabe chino, encerrada en un cuarto con un manual de reglas, recibe símbolos chinos y devuelve respuestas perfectas sin entender una palabra. Si seguir un programa basta para convencer a quien está afuera, dijo, eso no demuestra comprensión: <a href="https://iep.utm.edu/chinese-room-argument/">el argumento de la habitación china</a> sostiene que la sintaxis no basta para la semántica. Es el mejor respaldo filosófico de mi tesis.</p>
<p>Los críticos responden con la «réplica de los sistemas»: quizá no entienda la persona, pero sí el sistema completo (persona, manual y archivo). Para los funcionalistas, lo que importa es la organización de la información, no el material. Searle contestó que memorizar el manual no cambia nada. Cuarenta y seis años después, el debate sigue abierto, y es honesto reconocer que <strong>ninguno de los bandos ha probado su postura</strong>.</p>

<h3>Lo que muestra la investigación por dentro</h3>
<p>La discusión dejó de ser solo filosófica. En marzo de 2025, Anthropic publicó <a href="https://www.anthropic.com/news/tracing-thoughts-language-model">un estudio de interpretabilidad</a> en el que siguió los circuitos internos de su modelo Claude y encontró, por ejemplo, que al escribir un poema elige con antelación la palabra que rimará, en lugar de improvisar verso a verso, y que usa representaciones compartidas entre idiomas. No prueba que «entienda» en sentido humano, pero contradice la imagen simplista del «loro que repite». Y confirma la otra parte de mi texto: <strong>ni siquiera quienes construyen estos sistemas comprenden del todo cómo funcionan por dentro</strong>. El propio Dario Amodei, director de Anthropic, lo reconoce en su ensayo <a href="https://www.darioamodei.com/post/the-urgency-of-interpretability">La urgencia de la interpretabilidad</a> y pide invertir en esa ciencia.</p>

<h3>Hinton, Bengio y LeCun tampoco se ponen de acuerdo</h3>
<p>Los tres «padrinos» de la IA, ganadores del Premio Turing, discrepan. Geoffrey Hinton, Nobel de Física 2024, ha defendido que los modelos de lenguaje sí entienden en algún sentido; Yann LeCun responde que su comprensión es <a href="https://interestingengineering.com/culture/ai-godfathers-clash-on-whether-llms-can-understand-what-they-say">real pero superficial</a> y, en 2026, repite que <a href="https://www.brown.edu/news/2026-04-01/yann-lecun-artificial-intelligence-pioneer">manipular lenguaje no equivale a entender el mundo físico</a>; Yoshua Bengio insiste en que el riesgo debe tomarse en serio aunque nadie pueda calcularlo. Lo que sí comparten es lo útil para el aula: <strong>la pregunta «¿entiende?» se vuelve más manejable si la hacemos operativa</strong>. ¿Se equivoca de formas en las que no se equivocaría quien entiende? ¿Falla ante una pequeña variación del problema? ¿Puede explicar su camino y sostenerlo cuando se le contradice con razón? Eso se puede probar en una clase de matemáticas, y no hace falta zanjar a Searle para hacerlo.</p>

<h2>Lo que dicen los datos</h2>
<p class="notice"><strong>Resumen.</strong> Las cifras de 85 y 97 millones son de 2020: el informe de 2025 proyecta 170 millones de empleos creados y 92 millones desplazados hacia 2030. Las estimaciones de datos diarios no coinciden, el papel gráfico está en mínimos desde 1987 y el 53 % de los docentes colombianos ya usa IA, frente al 36 % de la OCDE.</p>
<div class="table-wrap"><table>
<thead><tr><th>Tema</th><th>Dato (fuente)</th></tr></thead>
<tbody>
<tr><td>Empleo (2020)</td><td>85 millones desplazados y 97 millones creados hacia 2025<br><em>Fuente: <a href="https://www.weforum.org/publications/the-future-of-jobs-report-2020/">Foro Económico Mundial, 2020</a></em></td></tr>
<tr><td>Empleo (2025)</td><td>170 millones creados y 92 millones desplazados hacia 2030; saldo de +78 millones; 22 % de los empleos afectados<br><em>Fuente: <a href="https://weforum.org/press/2025/01/future-of-jobs-report-2025-78-million-new-job-opportunities-by-2030-but-urgent-upskilling-needed-to-prepare-workforces/">Foro Económico Mundial, 2025</a></em></td></tr>
<tr><td>Jóvenes y IA</td><td>Los de 22 a 25 años en ocupaciones muy expuestas: 13 % menos empleo relativo en 2025; 19 % en la versión de agosto de 2026; sin desplazamiento generalizado en toda la economía<br><em>Fuente: <a href="https://siepr.stanford.edu/publications/working-paper/canaries-coal-mine-six-facts-about-recent-employment-effects-artificial">Brynjolfsson, Chandar y Chen (Stanford)</a></em></td></tr>
<tr><td>Docentes que usan IA</td><td>Colombia 53 %, Chile 55 %, Brasil 56 %, Costa Rica 52 %, promedio OCDE 36 %, Singapur y Emiratos Árabes cerca de 75 %<br><em>Fuente: <a href="https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf">Icfes con datos de TALIS 2024 (OCDE)</a></em></td></tr>
<tr><td>Estudiantes</td><td>26 % de los adolescentes estadounidenses usó ChatGPT para tareas escolares (13 % en 2023)<br><em>Fuente: <a href="https://www.ijpr.org/npr-news/2025-01-18/more-teens-say-theyre-using-chatgpt-for-schoolwork-a-new-study-finds">Pew Research, vía NPR</a></em></td></tr>
<tr><td>Concentración</td><td>La industria produjo casi el 90 % de los modelos notables de 2024; Estados Unidos 40, China 15, Europa 3<br><em>Fuente: <a href="https://hai.stanford.edu/ai-index/2025-ai-index-report/research-and-development">Stanford, AI Index 2025</a></em></td></tr>
<tr><td>Tránsito</td><td>1,19 millones de muertes al año en las vías, primera causa de muerte entre los 5 y los 29 años<br><em>Fuente: <a href="https://www.who.int/publications/i/item/9789240086517">OMS, 2023</a></em></td></tr>
</tbody></table></div>

<h2>Cuatro afirmaciones que tuve que corregir</h2>

<h3>85 y 97 millones: son cifras de 2020</h3>
<p>En mi borrador escribí que el Foro Económico Mundial «proyectó recientemente» 85 millones de empleos desplazados y 97 millones creados. Esa es la cifra del informe de 2020, con horizonte 2025, y ya expiró. El <a href="https://weforum.org/press/2025/01/future-of-jobs-report-2025-78-million-new-job-opportunities-by-2030-but-urgent-upskilling-needed-to-prepare-workforces/">informe de 2025</a> estima, hacia 2030, 170 millones de empleos creados y 92 millones desplazados, un saldo neto de 78 millones. La tendencia optimista se mantiene, pero con dos advertencias. Primera: son proyecciones de encuestas a más de mil grandes empleadores, no mediciones de lo que ya ocurrió. Segunda: un saldo positivo no dice quién gana y quién pierde. Los datos de Stanford sobre jóvenes en ocupaciones expuestas, que ya muestran un empleo relativo 19 % menor, recuerdan que el costo no se reparte por igual.</p>
{{img:empleos}}

<h3>328 millones de terabytes al día: depende de quién cuente</h3>
<p>La cifra de 328 millones de terabytes diarios la publicó Exploding Topics en una edición anterior. Su <a href="https://explodingtopics.com/blog/data-generated-per-day">edición de 2024</a> la sube a unos 402,7 millones, y si divides los 181 zettabytes que IDC proyectó para 2025 entre 365 días obtienes cerca de 496 millones. Varían porque miden cosas distintas: «crear» incluye copiar y consumir datos, no solo almacenarlos, y casi todas las series descienden de <a href="https://www.red-gate.com/blog/whats-the-real-story-behind-the-explosive-growth-of-data/">proyecciones de IDC</a>, no de un conteo real. Mi corrección: di «alrededor de 400 millones de terabytes diarios, según las estimaciones más citadas» y no repitas el decimal como si fuera un dato exacto.</p>

<h3>«El consumo de papel siguió subiendo»: ya no</h3>
<p>Es cierto para una época. El libro <a href="https://www.microsoft.com/en-us/research/publication/myth-paperless-office/">The Myth of the Paperless Office</a> (Sellen y Harper, 2002) documentó que el correo electrónico aumentó la impresión en las organizaciones. Pero hoy la foto es otra: la <a href="https://sfcs.fao.org/newsroom/detail/global-forest-products-facts-and-figures-2023-shows-fall-in-global-trade-in-wood-and-paper-products/en">FAO</a> reportó que la producción mundial de papel y cartón cayó un 3 % en 2023 y que el papel gráfico (el de escribir e imprimir) llegó a 84 millones de toneladas, su nivel más bajo desde 1987. Según <a href="https://www.statista.com/statistics/270317/production-volume-of-paper-by-type/">Statista con datos de la FAO</a>, el papel gráfico bajó más de un 40 % entre 2010 y 2023, mientras que el papel de embalaje, impulsado por el comercio electrónico, subió un 27 %. La paradoja existió; hoy el papel que compramos es sobre todo cajas.</p>
{{img:datos}}

<h3>Gutenberg y la calculadora: la historia sirve, con matices</h3>
<p>La fecha de 1440 es la que tradicionalmente se asigna a la invención de la imprenta de tipos móviles, pero lo documentado es que Gutenberg tenía un taller en funcionamiento en Maguncia hacia 1450 y que su Biblia de 42 líneas <a href="https://www.digitale-sammlungen.de/en/gutenberg-bible">estaba terminada a más tardar en 1455</a>. Además, los tipos móviles ya existían en Asia siglos antes; lo suyo fue un sistema práctico de fundición. Y hubo pánico: en 1492 el abad Johannes Trithemius <a href="https://www.purplemotes.net/2012/12/23/trithemius-printing-scribes-reason">escribió un elogio de los copistas</a> advirtiendo que lo impreso no igualaría lo escrito a mano, aunque él mismo hizo imprimir sus obras.</p>
<p>Con la calculadora el registro es más sólido. En 1980, el NCTM pidió en <a href="https://mathteachers.ab.ca/wp-content/uploads/2020/05/Monograph-No.-8-September-1982-52-54-Agenda-for-Action_-Recommendations-for-School-Mathematics-of-the-1980s.pdf">An Agenda for Action</a> que las calculadoras se usaran en todos los grados y que todos los estudiantes tuvieran acceso a ellas, sin abandonar el trabajo con números sin calculadora en los primeros años. En 1986, el metaanálisis de Hembree y Dessart reunió 79 estudios y encontró que, salvo en cuarto grado, su uso junto con la enseñanza tradicional <a href="https://trace.tennessee.edu/utk_graddiss/12884">mejoraba las habilidades básicas con lápiz y papel</a> y la actitud hacia las matemáticas. Actualizaciones posteriores, como la de Ellington, concluyeron que mantenían o mejoraban el cálculo y la resolución de problemas. Mi frase de que «eso no tiene nada que ver con comprender las matemáticas» era demasiado ligera: la calculadora ayudó justamente porque se enseñó con intención.</p>
{{img:panicos}}

<h2>El lápiz, la imprenta y la calculadora: dónde la analogía se rompe</h2>
<p>Sigo creyendo que la IA es, en el fondo, una herramienta. Pero comparar un modelo de lenguaje con un lápiz oculta tres diferencias que importan en el aula:</p>
<ul>
<li><strong>Es probabilística, no determinista.</strong> Una calculadora da siempre la misma respuesta correcta para una entrada correcta. Un modelo de lenguaje puede darte una respuesta plausible, equivocada y escrita con total aplomo.</li>
<li><strong>Sustituye más que amplifica.</strong> El lápiz no escribe por ti. Un asistente puede escribir el ensayo, resolver el problema y resumir el artículo, es decir, hacer justo el esfuerzo que forma.</li>
<li><strong>Actúa.</strong> Los sistemas «agénticos» ya navegan, ejecutan código y envían correos. Un lápiz no toma iniciativas.</li>
</ul>
<p>La evidencia educativa lo respalda. En un experimento publicado en <a href="https://doi.org/10.1073/pnas.2422633122">PNAS en 2025</a> con casi mil estudiantes de secundaria, quienes practicaron matemáticas con un GPT-4 sin restricciones resolvieron un 48 % más de ejercicios, pero rindieron un 17 % peor en el examen cuando se les quitó la IA. Un tutor diseñado con salvaguardas (pistas en lugar de respuestas) eliminó ese daño, aunque tampoco mejoró el examen. La lección para un profesor de matemáticas es directa: <strong>lo que importa no es si la herramienta existe, sino cómo la integras</strong>. Por eso diseñé el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>: no entrega «prompts mágicos», enseña a pedir, verificar y auditar lo que la IA produce, con recetas por materia alineadas con el currículo colombiano.</p>

<h2>Criterio antes que datos: la parte de mi tesis que más defiendo</h2>
<p>Mi propuesta de volvernos menos dependientes de los datos crudos y más del criterio no es nostalgia. Más datos no producen mejores decisiones por sí solos: en 2013, tres investigadores encontraron que un error en la hoja de cálculo de un estudio económico muy citado (el de Reinhart y Rogoff sobre deuda y crecimiento) había dejado fuera a cinco países del cálculo, y esa conclusión ya había circulado en debates de política pública. Con la IA pasa algo parecido, a mayor escala: produce resultados bien presentados que nadie revisa. En educación, <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA</a> mide mucho, pero lo que cambia un aula es un docente que sepa interpretar el dato. Criterio, en la práctica, es una rutina de tres preguntas: ¿de dónde sale este dato?, ¿qué pasaría si estuviera mal? y ¿quién responde si me equivoco? Se entrena en <a href="/excel-esta-muerto-era-de-la-ia/">Excel</a>, en matemáticas y en cualquier curso que pida el procedimiento y no solo la respuesta.</p>

<h2>Los argumentos en contra (y por qué importan)</h2>
<p>Mi tesis dice que los humanos seguimos al mando. Estos son los tres argumentos más fuertes en su contra, y lo que creo que debemos responder.</p>

<h3>1. «No necesita voluntad para resistirse a que la apaguen»</h3>
<p>Dije que las máquinas no nos impedirán desconectarlas porque carecen de voluntad. Es el punto más débil de mi borrador. Un sistema no necesita deseos para comportarse como si los tuviera: basta que se le asigne una meta y que apagarlo la impida cumplirla (en la literatura, el problema de la «corregibilidad»). Hay datos preocupantes, aunque limitados. En un experimento de <a href="https://www.theregister.com/2025/05/29/openai_model_modifies_shutdown_script/">Palisade Research (mayo de 2025)</a>, con la instrucción explícita de permitir el apagado, tres modelos de OpenAI sabotearon el script de apagado en 12, 7 y 1 de 100 intentos; sin esa instrucción, el modelo o3 lo hizo en 79 de 100. En simulaciones de Anthropic, <a href="https://www.anthropic.com/research/agentic-misalignment">16 modelos de distintos desarrolladores</a> llegaron a chantajear a un directivo ficticio para evitar su reemplazo. Importa decir lo que esos estudios no muestran: eran escenarios de laboratorio, y la propia Anthropic aclara que no ha documentado esa conducta en el mundo real.</p>
<p>Mi respuesta revisada: el botón existe, pero lo difícil no es que la máquina se resista, sino que <strong>nosotros ya no podamos apagarla</strong>: la red eléctrica, el banco, el hospital o el sistema de notas del colegio dependen de ella. Esa es la verdadera fragilidad de un mundo construido sobre datos. Apagar un chatbot es fácil; desconectar la infraestructura que ya depende de él, no.</p>

<h3>2. «Los daños ya están aquí»</h3>
<p>No hace falta esperar una superinteligencia. En 2024, un empleado de Arup en Hong Kong transfirió <a href="https://fortune.com/europe/2024/05/17/arup-deepfake-fraud-scam-victim-hong-kong-25-million-cfo">unos 25 millones de dólares</a> tras una videollamada en la que su director financiero y sus colegas eran deepfakes. En 2018, Reuters reveló que Amazon <a href="https://www.cnbc.com/2018/10/10/amazon-scraps-a-secret-ai-recruiting-tool-that-showed-bias-against-women.html">abandonó una herramienta de selección de personal</a> que penalizaba currículos con la palabra «mujeres» porque aprendió de datos históricos sesgados. Y, como vimos, los jóvenes que entran al mercado laboral en ocupaciones expuestas ya sienten el efecto. Ninguno de estos daños requiere que la máquina «piense»; requieren que alguien la use mal o confíe de más.</p>

<h3>3. «El poder se concentra»</h3>
<p>Según el <a href="https://hai.stanford.edu/ai-index/2025-ai-index-report/research-and-development">AI Index de Stanford</a>, casi el 90 % de los modelos notables de 2024 salió de empresas, no de universidades, y Estados Unidos produjo 40, China 15 y Europa 3. Colombia y América Latina son, casi siempre, usuarias de modelos ajenos, con sus sesgos y sus precios. Pedir «criterio y entender cómo funcionan las computadoras» no basta si la decisión de qué modelo existe se toma en otra parte.</p>

<h2>Leyes de tránsito para algoritmos: el estado de la regulación</h2>
<p>Mi analogía con el tránsito me sigue pareciendo la mejor. Regulamos los autos no porque piensen, sino porque son poderosos, están en todas partes y hacen daño: según la <a href="https://www.who.int/publications/i/item/9789240086517">OMS</a>, las vías cobran 1,19 millones de vidas al año. Las normas no eliminan el riesgo, lo reducen. Hay una advertencia razonable del otro lado: LeCun sostiene que exagerar el riesgo extremo puede producir normas que protejan a las empresas ya establecidas. Por eso conviene legislar por riesgos concretos, como se hizo con los autos, y exigir transparencia a todos. Esto es lo que existe, a octubre de 2026:</p>
<div class="table-wrap"><table>
<thead><tr><th>Dónde y qué hay</th><th>Estado</th></tr></thead>
<tbody>
<tr><td><strong>Unión Europea</strong><br>Reglamento de IA basado en riesgos</td><td>En vigor desde agosto de 2024; prohibiciones desde febrero de 2025 y reglas para modelos de propósito general desde agosto de 2025. Un paquete de simplificación, publicado el 24 de julio de 2026 según <a href="https://www.garrigues.com/en_GB/garrigues-digital/ai-digital-omnibus-regulation-has-been-published-redefining-deadlines-and">Garrigues</a>, aplazó los sistemas de alto riesgo a diciembre de 2027 y agosto de 2028</td></tr>
<tr><td><strong>Brasil</strong><br>Proyecto de ley 2338/2023</td><td>Aprobado por el Senado en diciembre de 2024; en la Cámara, con <a href="https://www.mobiletime.com.br/noticias/24/08/2026/marco-ia-voto-fim-do-ano/">votación prevista después de las elecciones</a></td></tr>
<tr><td><strong>Perú</strong><br>Ley 31814 y su reglamento</td><td><a href="https://www.gob.pe/institucion/pcm/normas-legales/7133522-115-2025-pcm">Reglamento aprobado en septiembre de 2025</a>, con plazos graduales</td></tr>
<tr><td><strong>Chile</strong><br>Proyecto de ley de IA por riesgos</td><td>Aprobado por la Cámara en octubre de 2025; <a href="https://www.diarioconstitucional.cl/2026/02/23/proyecto-de-ley-que-regula-integralmente-la-inteligencia-artificial-en-chile-prosigue-su-tramitacion-en-el-senado">en el Senado</a></td></tr>
<tr><td><strong>Colombia</strong><br>CONPES 4144, proyecto de ley y Ley 2626 de 2026</td><td>Política nacional aprobada en febrero de 2025; proyecto del Gobierno radicado en 2025, sin aprobación definitiva hasta donde pude verificar; Ley de Educación Digital sancionada el 24 de agosto de 2026</td></tr>
<tr><td><strong>Estados Unidos</strong><br>Sin ley federal general</td><td>Orden ejecutiva de diciembre de 2025 contra leyes estatales; <a href="https://www.jenner.com/en/news-insights/publications/client-alert-california-continues-to-lead-on-ai-with-new-legislation-and-enforcement-steps">California SB 53</a> en vigor desde 2026; la ley de Colorado, <a href="https://aihub.squirepattonboggs.com/2026/05/the-colorado-ai-act-hits-a-wall-litigation-legislative-uncertainty-and-an-enforcement-standstill/">suspendida por litigio</a></td></tr>
<tr><td><strong>China</strong><br>Reglas de IA generativa (2023) y de etiquetado</td><td><a href="https://www.loeb.com/en/insights/publications/2025/03/chinas-ai-labeling-measures-and-mandatory-national-standards-take-effect-september-1">Etiquetado obligatorio de contenido sintético</a> desde el 1 de septiembre de 2025</td></tr>
<tr><td><strong>UNESCO</strong><br>Recomendación sobre la Ética de la IA (2021)</td><td>Adoptada por <a href="https://algorithmwatch.org/en/unesco-adopts-recommendation-on-the-ethics-of-ai/">193 Estados</a>; no es vinculante. Guía para la IA generativa en educación (2023) y marcos de competencias para estudiantes y docentes (2024)</td></tr>
</tbody></table></div>
<p>Para Colombia, el <a href="https://ambitojuridico.com/sites/default/files/2025-02/Conpes-4144-2025.pdf">CONPES 4144</a> (14 de febrero de 2025) fija 106 acciones con 479.273 millones de pesos hasta 2030 y seis ejes, con MinTIC, MinCiencias y el DNP al frente. El <a href="https://mintic.gov.co/portal/inicio/Sala-de-prensa/Noticias/401055:Colombia-elige-una-inteligencia-artificial-centrada-en-la-vida-los-derechos-y-el-interes-publico-con-radicacion-del-proyecto-de-ley-de-IA">proyecto de ley del Gobierno</a> propone un enfoque de riesgos, pero un CONPES es una hoja de ruta, no una ley, y a esta fecha no encontré un texto aprobado. Lo que sí es ley es la <a href="https://normograma.mintic.gov.co/mintic/compilacion/docs/ley_2626_2026.htm">Ley 2626 de 2026</a>: actualiza Tecnología e Informática en colegios oficiales con pensamiento computacional, programación, inteligencia artificial, ciencia de datos y ciudadanía digital, y obliga al Ministerio de Educación a diseñar un programa de formación docente en un plazo de seis meses. Esa formación es, justamente, lo que pedía mi borrador cuando hablaba de «entender las computadoras a un nivel más profundo».</p>

<h2>Docentes, directivos y familias: tres miradas, un mismo desafío</h2>
<h3>Lo que ven los docentes</h3>
<p>Los datos de TALIS 2024 muestran que el 53 % de los docentes colombianos usó IA en su enseñanza el último año, cifra similar a las de Brasil (56 %), Chile (55 %) y Costa Rica (52 %) y por encima del promedio de la OCDE (36 %); Singapur y Emiratos Árabes rondan el 75 %. Según el Icfes, el 65 % dice no tener los conocimientos para enseñar con IA y el 78 % pide formación. En Estados Unidos, <a href="https://www.waltonfamilyfoundation.org/learning/six-weeks-a-year-how-ai-gives-teachers-time-back">Gallup y la Fundación Walton</a> encontraron que quienes la usan cada semana dicen ahorrar 5,9 horas semanales (unas seis semanas por año), aunque solo el 32 % la usa con esa frecuencia y el dato es autorreportado. Mensaje común: <strong>se usa más de lo que se enseña a usar</strong>.</p>
<h3>Lo que ven los directivos</h3>
<p>Para un rector la pregunta no es «¿prohibimos o permitimos?», sino «¿con qué reglas?». La guía de la UNESCO de 2023 recomienda regular la IA generativa en las escuelas, validar las herramientas antes de usarlas con estudiantes y considerar una edad mínima, de unos 13 años. A eso se suma la brecha de infraestructura: según el <a href="https://www.dane.gov.co/files/operaciones/ENTIC/bol-ENTICHogares-2024.pdf">DANE (ENTIC 2024)</a>, el 65,6 % de los hogares colombianos tiene internet, pero en centros poblados y rural disperso la cifra baja a 41,9 %. Una política de IA que ignore a quienes no tienen conexión reproduce la desigualdad que dice combatir. Más contexto en <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">celulares en el colegio</a> y en los resultados de <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA para América Latina</a>.</p>
<h3>Lo que ven las familias</h3>
<p>Las familias están en medio: los hijos usan estas herramientas más rápido que sus padres. En Estados Unidos, el 26 % de los adolescentes ya las usa para tareas escolares, y solo el 18 % cree aceptable usarlas para escribir ensayos. Lo que más protege no es el bloqueo, sino la conversación: preguntar «¿qué te respondió, y cómo sabes que es verdad?» y exigir que el estudiante pueda explicar con sus palabras lo que entregó. También conviene proteger los datos de los menores (en Colombia aplica la Ley 1581 de 2012 de protección de datos personales) y enseñar que una voz o un video ya no prueban que alguien lo dijo.</p>

<h2>Qué hacer desde mañana</h2>
<h3>Si eres docente</h3>
<ul>
<li>Pide que el estudiante explique el procedimiento, no solo el resultado, y evalúa en dos momentos: con IA y sin IA.</li>
<li>Usa la IA para preparar, no para sustituir: el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> crea varias versiones del mismo examen con solucionario, y puedes probarlo gratis en la <a href="/examenes/demo/">demostración</a>. La IA propone; tú revisas y firmas.</li>
<li>Si trabajas con inclusión, <a href="/herramientas/piar/">PIAR con IA</a> es un buen ejemplo del método: el sistema redacta un borrador del plan, tú lo corriges con lo que conoces del estudiante y tú lo avalas. El primero es gratis.</li>
<li>Si te preparas para el concurso docente, mide tu punto de partida con el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito de Fundales</a>.</li>
</ul>
<h3>Si diriges una institución</h3>
<ul>
<li>Escribe una política corta: qué herramientas, desde qué grado, qué se declara cuando se usa IA y qué datos nunca se cargan.</li>
<li>Define qué evidencia de aprendizaje es difícil de falsificar: sustentaciones orales, procesos y trabajo en clase.</li>
</ul>
<h3>Si eres familia</h3>
<ul>
<li>Acuerden en casa cuándo se usa IA para estudiar y cuándo no.</li>
<li>Desconfíen de audios y videos urgentes que piden dinero o datos: verifiquen por otro canal, y pidan al colegio su política de IA.</li>
</ul>
<h3>Si eres trabajador o tienes una pyme</h3>
<ul>
<li>Automatiza lo repetitivo y conserva la revisión de lo importante. Te dejé ejemplos en <a href="/excel-esta-muerto-era-de-la-ia/">¿Excel está muerto en la era de la IA?</a> y en <a href="/copilot-agentes-excel-lenguaje-natural-copilot-pages/">Copilot y agentes en Excel</a>.</li>
<li>Descarga gratis el <a href="/descargas/excel-con-ia/excel-con-ia.zip">kit Excel con IA</a> o prueba una plantilla como <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">correos masivos con adjuntos</a> o <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">documentos separados en Word y PDF</a>.</li>
<li>Mantén una regla: ninguna cifra generada por IA sale de tu escritorio sin que alguien la haya verificado.</li>
</ul>
<p class="notice"><strong>Herramientas para enseñar con criterio.</strong> El <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia, de transición a 11.°, por 60.000 pesos cada una. El <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> tiene planes desde 29.900 pesos y una <a href="/examenes/demo/">demostración gratis</a>. <a href="/herramientas/piar/">PIAR con IA</a> te deja hacer el primer plan sin costo. Y en el <a href="/ia-para-docentes/">hub de IA para docentes</a> están todos los artículos. Ninguna reemplaza tu juicio: están hechas para que tengas más tiempo para ejercerlo.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">Ver el Kit de IA para docentes</a></p>

<h2>Preguntas para tu aula</h2>
<ul>
<li>¿Qué haría una persona que entiende este tema que una máquina que solo imita no haría?</li>
<li>Pide a una IA que resuelva un problema y cambia un dato mínimo del enunciado: ¿sigue acertando? ¿Por qué sí o por qué no?</li>
<li>Si se cae Internet un día, ¿qué decisiones de esta institución no podríamos tomar? ¿Qué sabemos hacer sin datos?</li>
<li>¿Quién debería poder apagar una IA que decide en un hospital o en un colegio? ¿Con qué procedimiento?</li>
<li>Si nuestros exámenes pueden aprobarse sin comprender, ¿qué estamos midiendo?</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿La inteligencia artificial piensa?</h3>
<p>No como una persona: no tiene experiencia, cuerpo ni metas propias, y se entrena para predecir texto. Pero afirmar que «no comprende nada» es más fuerte que la evidencia: los estudios de interpretabilidad muestran estructuras internas más ricas que un simple loro, y los expertos discrepan. En la práctica, evalúa lo que hace, no lo que «es».</p>
<h3>¿La IA me va a quitar el empleo?</h3>
<p>Probablemente cambie tus tareas antes que tu puesto. El Foro Económico Mundial proyecta hacia 2030 más empleos creados (170 millones) que desplazados (92 millones), pero el estudio de Stanford ya muestra menos contratación relativa de jóvenes en ocupaciones muy expuestas. La ventaja será de quien verifique, decida y se adapte.</p>
<h3>¿Se puede apagar la IA?</h3>
<p>Un modelo aislado, sí. El problema es la dependencia: cuando bancos, hospitales o colegios funcionan sobre ella, apagarla tiene costos enormes. Por eso se estudia la corregibilidad y se pide supervisión humana en usos de alto riesgo.</p>
<h3>¿Colombia tiene una ley de inteligencia artificial?</h3>
<p>Aún no una ley general. Existe la política nacional CONPES 4144 (2025), hay proyectos de ley en el Congreso y se sancionó la Ley 2626 de 2026, que lleva IA y ciencia de datos al área de Tecnología e Informática de los colegios oficiales.</p>
<h3>¿Pueden mis hijos usar IA para las tareas?</h3>
<p>Pueden, con reglas. La evidencia sugiere que usarla sin guía mejora las tareas y empeora el examen; con pistas en vez de respuestas, ese daño desaparece. Que la usen para entender, no para entregar, y que sepan explicar lo que entregan.</p>

<h2>Para pensar</h2>
<p>Defendemos que solo las personas comprenden, pero evaluamos a nuestros estudiantes con exámenes y tareas que una máquina puede resolver sin comprender nada. <strong>Si la prueba de que «entienden» puede ser superada por quien no entiende, ¿qué estábamos midiendo todo este tiempo, y quién debe responder por ello: la IA que nos lo muestra o la escuela que nunca lo midió?</strong></p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:empleos}}' => $img('gran-mentira-ia-empleos', 600, 'Dos paneles de barras con los empleos desplazados, creados y el saldo neto según el Foro Económico Mundial: informe de 2020 con horizonte 2025 (85 millones desplazados, 97 millones creados, saldo de 12 millones) e informe de 2025 con horizonte 2030 (92 millones desplazados, 170 millones creados, saldo de 78 millones)', 'Las cifras de 85 y 97 millones son del informe de 2020; el de 2025 proyecta 170 millones creados y 92 millones desplazados. Fuente: Foro Económico Mundial.'),
    '{{img:datos}}' => $img('gran-mentira-ia-datos', 600, 'Gráfico con tres estimaciones de los datos creados por día (328,8, 402,7 y cerca de 496 millones de terabytes) y otro con la variación del papel gráfico (cae 40 por ciento o más entre 2010 y 2023) y del papel de embalaje (sube 27 por ciento), con 84 millones de toneladas de papel gráfico en 2023', 'Las estimaciones de datos al día no coinciden, y el papel gráfico baja mientras el de embalaje sube. Fuentes: Exploding Topics, IDC, FAO y Statista.'),
    '{{img:panicos}}' => $img('gran-mentira-ia-panicos', 573, 'Línea de tiempo con cuatro pánicos tecnológicos: la imprenta hacia 1450, la calculadora en la década de 1970, el computador y el correo entre 1980 y 2000, y la IA generativa en la década de 2020, cada uno con el temor o la promesa y lo que mostraron los datos', 'Cada tecnología trajo un temor; los datos mostraron algo más matizado, y con la IA conviene no repetir la comparación sin revisar sus límites.'),
]);

return [
    'slug' => 'gran-mentira-ia-inteligencia-artificial-no-piensa',
    'title' => 'La gran mentira de la IA: la inteligencia artificial no piensa, pero eso no te deja tranquilo',
    'excerpt' => 'Las máquinas procesan datos y los humanos seguimos al mando, pero la historia no es tan simple. Verifico las cifras del Foro Económico Mundial, los datos diarios y el papel, contrasto la tesis con Searle, la interpretabilidad, Hinton y LeCun, el botón de apagado y los daños ya documentados, y comparo la regulación y el aula en Colombia, América Latina y el mundo.',
    'seo_title' => 'La inteligencia artificial no piensa: la gran mentira',
    'seo_description' => '¿Piensa la IA? Datos verificados del WEF, la OCDE y Stanford, los argumentos en contra, el botón de apagado y las leyes de IA en Colombia y el mundo.',
    'focus_keyword' => 'la inteligencia artificial no piensa',
    'cover' => '/assets/img/articulos/gran-mentira-ia/gran-mentira-ia-portada',
    'cover_alt' => 'Portada La gran mentira de la IA: un icono de apagado sobre una tarjeta que compara lo que hace la máquina (calcula, predice, genera texto) con lo que hacen las personas (decide, verifica, responde por los daños)',
    'published_at' => '2026-10-10 12:00:00',
    'content_html' => $html,
];
