<?php

declare(strict_types=1);

// Artículo de opinión con datos: la IA no reemplaza profesionales; los reemplaza quien la domina (docentes, directivos y otras profesiones).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-reemplazo/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

return [
    'slug' => 'la-ia-no-te-reemplazara-quien-la-domine-si',
    'title' => 'La IA no te va a reemplazar. Quien la domine, sí',
    'excerpt' => 'La IA no reemplaza profesionales por sí sola: los desplaza la persona o la organización que aprende a usarla bien. Reviso los datos sin alarmismo, lo que la IA hace mal, qué significa de verdad dominarla y un plan de 30 días para docentes, directivos y profesionales de otras áreas.',
    'seo_title' => '¿La IA nos va a reemplazar? Quien la domine, sí',
    'seo_description' => 'La IA no reemplaza profesionales: los desplaza quien la usa bien. Datos verificados, límites reales y un plan de 30 días para docentes y profesionales.',
    'focus_keyword' => 'la IA nos va a reemplazar',
    'cover' => '/assets/img/articulos/ia-reemplazo/ia-reemplazo-portada',
    'cover_alt' => 'Portada con el título La IA no te va a reemplazar. Quien la domine, sí, junto a una hoja de cálculo heredada llena de errores #REF! y una tarjeta con un flujo de trabajo: borrador con IA, verificar fuentes, aplicar tu criterio y firmar',
    'published_at' => '2026-10-07 22:00:00',
    'content_html' => <<<HTML
<p>En casi todas las salas de profesores y oficinas que visito escucho la misma frase, a veces en broma y a veces con angustia: "la IA nos va a reemplazar a todos". Y casi siempre, en la mesa de al lado, hay alguien que responde con una tranquilidad sospechosa: "a mí no, lo mío no lo hace una máquina".</p>
<p>Después de más de veinte años enseñando matemáticas y tecnología, y de unos cuantos construyendo herramientas con inteligencia artificial para docentes, creo que los dos se equivocan. El primero porque confunde una tecnología con un destino. El segundo porque confunde la costumbre con la seguridad. Esta caricatura lo resume mejor que cualquier informe:</p>
<figure><img src="/assets/img/articulos/ia-reemplazo/caricatura-excel-inmortal-800.webp" srcset="/assets/img/articulos/ia-reemplazo/caricatura-excel-inmortal-640.webp 640w, /assets/img/articulos/ia-reemplazo/caricatura-excel-inmortal-800.webp 800w" sizes="(min-width: 760px) 720px, 100vw" alt="Caricatura titulada La IA nos va a reemplazar a todos… Mismas preocupaciones. Distinto contexto. Un oficinista asustado dice que la IA nos va a reemplazar a todos; su compañero, frente a una hoja de cálculo llamada Presupuesto_FINAL_2017_v4 llena de errores #REF! y #N/D y con una nota adhesiva que dice No tocar. Funciona, 2017, le responde: Tranquilo, este Excel es inmortal. Al pie: La tecnología cambia. Las contradicciones humanas no." width="800" height="800" loading="lazy" decoding="async"><figcaption>"Mismas preocupaciones. Distinto contexto." Ilustración: Wanaki Cartoons.</figcaption></figure>
<p>Mírala con calma: <em>Presupuesto_FINAL_2017_v4</em>, errores <em>#REF!</em> y <em>#N/D</em> a la vista y una nota que dice "No tocar. Funciona :) 2017". Ese Excel no es inmortal: es un proceso que nadie entiende, nadie documenta y nadie se atreve a mejorar. Ahí está la trampa. El riesgo real no es que llegue un robot a ocupar la silla; es que la organización de al lado, o el colega de al lado, rehaga ese proceso en una tarde con IA y con criterio, mientras nosotros seguimos defendiendo la hoja que "funciona".</p>
<p>La frase del pie lo dice todo: <strong>la tecnología cambia, las contradicciones humanas no</strong>. Le tememos a la IA y, al mismo tiempo, nos aferramos a lo que conocemos. En este artículo quiero salir de esa contradicción con datos, con crítica y con un plan.</p>

<h2>Mi tesis, sin rodeos</h2>
<p>La IA, por sí sola, rara vez reemplaza a un profesional completo. Lo que hace es cambiar el precio de muchas de sus tareas. Cuando redactar un informe, resumir una norma o diseñar una prueba cuesta minutos en lugar de horas, el valor se desplaza hacia lo que la máquina no hace bien: decidir qué vale la pena hacer, verificar, contextualizar, responder por el resultado y relacionarse con las personas.</p>
<p>Por eso sostengo que <strong>quien no domine la IA sí corre un riesgo real de ser reemplazado, pero no por la IA, sino por personas y organizaciones que la usan bien</strong>. Ese reemplazo casi nunca llega como un despido dramático. Llega como una vacante que no se abre, un contrato que se le da a otro, un colegio vecino que responde más rápido a las familias o una firma que entrega en tres días lo que antes tomaba tres semanas.</p>
<p>Una tesis así puede volverse discurso de vendedor si no se examina con rigor. Vamos a los datos, incluidos los que la contradicen.</p>

<h2>Lo que dicen los datos (y lo que no dicen)</h2>
<p>La primera distinción importante es entre <strong>exposición</strong> y <strong>reemplazo</strong>. Que un empleo esté "expuesto" a la IA significa que una parte de sus tareas se puede hacer o acelerar con ella, no que vaya a desaparecer. Con esa advertencia, estas son las cifras que considero más sólidas:</p>
<table>
<thead><tr><th>Fuente</th><th>Qué mide</th><th>Dato</th></tr></thead>
<tbody>
<tr><td>{$ext('https://www.imf.org/en/Publications/Staff-Discussion-Notes/Issues/2024/01/14/Gen-AI-Artificial-Intelligence-and-the-Future-of-Work-542379', 'FMI, nota SDN/2024/001')} (enero de 2024)</td><td>Empleo expuesto a la IA</td><td>Casi 40 % en el mundo; 60 % en economías avanzadas, 40 % en emergentes y 26 % en países de bajo ingreso</td></tr>
<tr><td>{$ext('https://www.ilo.org/publications/generative-ai-and-jobs-refined-global-index-occupational-exposure', 'OIT, Working Paper 140')} (mayo de 2025)</td><td>Exposición a la IA generativa por ocupación</td><td>1 de cada 4 trabajadores con alguna exposición; 3,3 % en la categoría más alta; 34 % en países de ingreso alto frente a 11 % en los de ingreso bajo</td></tr>
<tr><td>{$ext('https://www.ilo.org/node/664436', 'OIT y Banco Mundial, Working Paper 121')} (julio de 2024)</td><td>América Latina y el Caribe</td><td>Entre 26 % y 38 % de los empleos expuestos; solo 2 % a 5 % en riesgo de automatización total; 17 millones de empleos frenados por la brecha digital</td></tr>
<tr><td>{$ext('https://www.weforum.org/publications/the-future-of-jobs-report-2025/', 'Foro Económico Mundial, Future of Jobs 2025')}</td><td>Empleos y habilidades a 2030</td><td>170 millones de empleos creados y 92 millones desplazados; 39 % de las habilidades actuales cambiará</td></tr>
<tr><td>{$ext('https://www.microsoft.com/en-us/worklab/work-trend-index/ai-at-work-is-here-now-comes-the-hard-part', 'Microsoft y LinkedIn, Work Trend Index 2024')}</td><td>Uso y contratación</td><td>75 % de los trabajadores del conocimiento usa IA; 66 % de los líderes no contrataría a alguien sin habilidades en IA; solo 39 % de los usuarios recibió formación de su empresa</td></tr>
<tr><td>{$ext('https://hai.stanford.edu/ai-index/2025-ai-index-report', 'Stanford, AI Index 2025')}</td><td>Adopción en organizaciones</td><td>78 % de las organizaciones usó IA en 2024, frente a 55 % el año anterior</td></tr>
<tr><td>{$ext('https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf', 'Icfes, nota sobre TALIS 2024')} (diciembre de 2025)</td><td>Docentes de Colombia</td><td>53 % usó IA en su enseñanza en el último año, frente a 36 % en el promedio de la OCDE</td></tr>
</tbody>
</table>
{$img('ia-reemplazo-exposicion', 573, 'Gráfico de barras: el FMI estima que el 60 por ciento del empleo está expuesto a la IA en economías avanzadas, casi 40 por ciento en el mundo, 40 en mercados emergentes y 26 en países de bajo ingreso. A la derecha, para América Latina y el Caribe: 26 a 38 de cada 100 empleos expuestos, 8 a 14 con transformación que eleva la productividad y 2 a 5 en riesgo de automatización total; 17 millones de empleos frenados por la brecha digital', 'Exposición no es reemplazo: en América Latina, la automatización total afecta a una fracción pequeña de los empleos expuestos.')}
<p>Fíjate en la última columna del gráfico: en nuestra región, de cada 100 empleos, entre 2 y 5 podrían automatizarse por completo, pero entre 8 y 14 podrían transformarse para ganar productividad. La propia OIT concluye que la transformación de los empleos es el efecto más probable. Y el dato de Microsoft y LinkedIn completa el cuadro: el 71 % de los líderes dijo preferir a un candidato con menos experiencia y con habilidades en IA antes que a uno con más experiencia y sin ellas. El reemplazo, cuando ocurre, ocurre entre personas.</p>

<h2>Exageración contra evidencia</h2>
<p>Ser riguroso obliga a reconocer que hoy no hay un "apocalipsis del empleo". Un análisis del {$ext('https://budgetlab.yale.edu/research/evaluating-impact-ai-labor-market-current-state-affairs', 'Budget Lab de Yale')} (octubre de 2025) no encontró una alteración apreciable del mercado laboral de Estados Unidos desde la llegada de ChatGPT: la mezcla de ocupaciones cambia algo más rápido que antes, pero esa tendencia empezó antes de la IA generativa.</p>
<p>Sin embargo, hay una señal que no conviene ignorar. El estudio {$ext('https://digitaleconomy.stanford.edu/publication/canaries-in-the-coal-mine-six-facts-about-the-recent-employment-effects-of-artificial-intelligence/', '"Canaries in the Coal Mine?" de Brynjolfsson, Chandar y Chen')}, en su revisión de agosto de 2026, encuentra que el empleo de jóvenes de 22 a 25 años en ocupaciones muy expuestas está 19 % por debajo de donde estaría si hubiera crecido como el de sus pares menos expuestos, mientras el de los trabajadores experimentados se mantiene. Los autores lo presentan como un indicador temprano, no como una prueba causal definitiva. Pero confirma mi tesis: el primer golpe no es el despido del veterano, sino la puerta que no se abre para el principiante.</p>

<h3>La frontera irregular</h3>
<p>La evidencia experimental es todavía más reveladora, porque muestra que la IA no suma siempre.</p>
{$img('ia-reemplazo-frontera', 623, 'Gráfico de barras divergentes: consultores con IA en tareas dentro de la frontera mejoran 40 por ciento la calidad y 25 por ciento la velocidad; agentes de soporte novatos resuelven 34 por ciento más casos por hora y el promedio 14 por ciento; en una tarea fuera de la frontera los consultores con IA aciertan 19 puntos menos, y programadores expertos en su propio código tardan 19 por ciento más', 'La misma tecnología mejora o empeora el trabajo según la tarea y según quién verifica.')}
<ul>
<li>En un experimento con 758 consultores de BCG, {$ext('https://www.hbs.edu/faculty/Pages/item.aspx?num=64700', 'Dell’Acqua y sus coautores')} hallaron que, en tareas dentro de las capacidades de la IA, quienes la usaban completaron 12,2 % más tareas, 25,1 % más rápido y con resultados 40 % mejores. En una tarea diseñada para quedar fuera de esa frontera, en cambio, fueron 19 puntos porcentuales menos propensos a dar con la solución correcta.</li>
<li>En un centro de soporte con 5.179 agentes, {$ext('https://www.nber.org/papers/w31161', 'Brynjolfsson, Li y Raymond')} midieron un aumento de 14 % en casos resueltos por hora, que llegó a 34 % en los agentes novatos y fue mínimo en los más expertos.</li>
<li>En un ensayo controlado de {$ext('https://metr.org/blog/2025-07-10-early-2025-ai-experienced-os-dev-study/', 'METR')} (julio de 2025), programadores experimentados trabajando en sus propios proyectos tardaron 19 % más con IA, aunque creían haber ido alrededor de 20 % más rápido.</li>
</ul>
<p>La conclusión no es "la IA sirve" ni "la IA no sirve". Es más incómoda: <strong>la IA rinde según la tarea y según el criterio de quien la usa</strong>, y nuestra percepción de cuánto nos ayuda puede estar muy equivocada. Esa es, precisamente, la diferencia entre usarla y dominarla.</p>

<h2>Lo que la IA hace mal (y por qué eso refuerza la tesis)</h2>
<p>Cada limitación de la IA hace más valiosa a la persona que sabe usarla. Estas son las que más me preocupan:</p>
<ul>
<li><strong>Inventa con seguridad.</strong> En el caso {$ext('https://www.lawnext.com/2023/06/court-imposes-sanctions-on-lawyers-who-filed-bogus-cases-after-relying-on-chatgpt-for-legal-research.html', 'Mata contra Avianca')} (2023), un juez de Nueva York multó con 5.000 dólares a dos abogados que citaron sentencias inexistentes generadas por ChatGPT. Ni siquiera las herramientas jurídicas especializadas se salvan: un estudio de {$ext('https://hai.stanford.edu/news/ai-trial-legal-models-hallucinate-1-out-6-or-more-benchmarking-queries', 'Stanford')} encontró respuestas incorrectas en más del 17 % de las consultas en unas y en más del 34 % en otra. En Colombia, la Corte Constitucional, en la {$ext('https://www.corteconstitucional.gov.co/relatoria/2024/T-323-24.htm', 'sentencia T-323 de 2024')}, aceptó que un juez usara ChatGPT después de haber tomado su decisión, pero dejó claro que la IA no puede reemplazar el razonamiento de quien decide.</li>
<li><strong>Reproduce sesgos.</strong> Amazon abandonó una herramienta de selección de personal que penalizaba las hojas de vida que incluían la expresión "de mujeres", como en "capitana del club de ajedrez de mujeres", según {$ext('https://www.reuters.com/article/us-amazon-com-jobs-automation-insight-idUSKCN1MK08G', 'Reuters')}. Si el pasado discriminó, un modelo entrenado con el pasado tiende a repetirlo.</li>
<li><strong>Expone datos.</strong> En 2023, {$ext('https://www.bloomberg.com/news/articles/2023-05-02/samsung-bans-chatgpt-and-other-generative-ai-use-by-staff-after-leak', 'Samsung restringió el uso de IA generativa')} después de que un ingeniero subiera código confidencial a ChatGPT. En un colegio, el equivalente es pegar en un chat el diagnóstico de un estudiante con su nombre, algo que choca con la {$ext('https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=49981', 'Ley 1581 de 2012')} de protección de datos personales.</li>
<li><strong>Puede desentrenarnos.</strong> En un estudio publicado en <em>The Lancet Gastroenterology &amp; Hepatology</em>, la {$ext('https://wrap.warwick.ac.uk/id/eprint/191005', 'tasa de detección de adenomas')} de endoscopistas que trabajaban sin IA bajó de 28,4 % a 22,4 % después de acostumbrarse a usarla. Y una encuesta de Microsoft Research y Carnegie Mellon a 319 trabajadores del conocimiento ({$ext('https://www.microsoft.com/en-us/research/?p=1135061', 'CHI 2025')}) encontró que más confianza en la IA se asocia con menos pensamiento crítico.</li>
<li><strong>No llega igual a todos.</strong> Según el {$ext('https://www.dane.gov.co/files/operaciones/ECV/cp-ECV-2025.pdf', 'DANE')}, en 2025 el 73,9 % de los hogares colombianos tenía internet, pero en centros poblados y zonas rurales dispersas la cifra era de 56,9 %. El 76 % de los docentes colombianos dice que su colegio no tiene la infraestructura para usar IA, frente a 37 % en la OCDE, según el Icfes.</li>
<li><strong>Consume energía.</strong> La {$ext('https://www.iea.org/reports/energy-and-ai/executive-summary', 'Agencia Internacional de Energía')} proyecta que el consumo eléctrico de los centros de datos pase de unos 415 TWh en 2024 a cerca de 945 TWh en 2030, impulsado sobre todo por la IA.</li>
<li><strong>Puede precarizar.</strong> El FMI advierte que, en las economías avanzadas, en la mitad de los empleos expuestos la IA podría asumir tareas clave y presionar salarios y contrataciones. En una región donde la informalidad afecta a casi la mitad de los ocupados (47 % según el {$ext('https://researchrepository.ilo.org/esploro/outputs/report/995682961202676', 'Panorama Laboral 2025 de la OIT')}; 54,6 % en Colombia entre mayo y julio de 2026, según el {$ext('https://www.dane.gov.co/files/operaciones/GEIH/bol-GEIHEISS-may-jul2026.pdf', 'DANE')}), el riesgo no es solo perder el empleo: es quedar por fuera de las ganancias.</li>
</ul>

<h2>Dónde la narrativa del reemplazo exagera</h2>
<p>Un empleo no es una tarea: es un paquete de tareas, relaciones y responsabilidades. La IA puede redactar el informe de convivencia, pero no puede sentarse con una madre angustiada. Puede proponer una conciliación bancaria, pero no firma los estados financieros ni responde ante la DIAN. Puede sugerir un diagnóstico diferencial, pero no examina al paciente ni carga con la decisión.</p>
<p>Además, muchas proyecciones parten de lo que la IA <em>podría</em> hacer en una demostración, no de lo que hace en una empresa con datos desordenados, conexiones intermitentes y procesos como el del Excel inmortal. La exageración paraliza a unos y les vende humo a otros.</p>
<p>Pero la complacencia también tiene un costo. Que la IA no te reemplace a ti no significa que tu forma actual de trabajar sobreviva intacta.</p>

<h2>Qué significa realmente dominar la IA</h2>
<p>Dominar la IA no es conocer cincuenta aplicaciones ni coleccionar prompts. La UNESCO publicó en 2024 {$ext('https://www.unesco.org/en/articles/ai-competency-framework-teachers', 'un marco de competencias en IA para docentes')} (15 competencias en cinco dimensiones) y {$ext('https://www.unesco.org/en/articles/ai-competency-framework-students', 'otro para estudiantes')} (12 competencias), y en ambos la mentalidad centrada en el ser humano y la ética pesan tanto como la técnica. En Europa, el {$ext('https://eur-lex.europa.eu/eli/reg/2024/1689/oj', 'Reglamento de IA')} convirtió la alfabetización en IA en una obligación para las organizaciones que la usan desde febrero de 2025. A partir de esos marcos y de mi experiencia, propongo siete competencias:</p>
{$img('ia-reemplazo-competencias', 636, 'Siete tarjetas con las competencias para dominar la IA: criterio de dominio, verificación, formulación, alfabetización de datos, ética y privacidad, rediseño de procesos y aprendizaje continuo, cada una con una pregunta de control; una octava tarjeta enumera lo que no es dominar la IA: saberse 50 herramientas, copiar prompts sin entenderlos, delegar el criterio y usarla para todo', 'Siete competencias para dominar la IA, cada una con la pregunta que conviene hacerse antes de usar un resultado.')}
<ol>
<li><strong>Criterio de dominio.</strong> Solo detecta el error quien sabe más que la máquina sobre su campo. Por eso la IA amplifica la experiencia, no la sustituye.</li>
<li><strong>Verificación.</strong> Contrastar cifras, citas, normas y cálculos con fuentes primarias antes de usar cualquier resultado.</li>
<li><strong>Formulación.</strong> Escribir una buena instrucción es pensar el problema: contexto, tarea, formato, restricciones y un paso de comprobación. El prompt es una forma de pensamiento, no un truco.</li>
<li><strong>Alfabetización de datos.</strong> Entender de dónde salen los números, qué representan, qué falta y qué sesgos traen.</li>
<li><strong>Ética y privacidad.</strong> Saber qué información nunca se pega en un chat, cuándo hay que informar el uso de IA y quién responde por cada decisión.</li>
<li><strong>Rediseño de procesos.</strong> No se trata de hacer más rápido lo mismo, sino de preguntarse qué pasos sobran. Es la competencia que le falta al dueño del Excel inmortal.</li>
<li><strong>Aprendizaje continuo.</strong> Probar, medir el tiempo real ahorrado, ajustar y, a veces, decidir que la IA no conviene.</li>
</ol>

<h2>Docentes: lo que cambia en el aula</h2>
<p>Los docentes colombianos no parten de cero. Según la nota del Icfes sobre TALIS 2024, entre quienes usan IA el 80 % la emplea para generar planes de clase o actividades y el 60 % para apoyar a estudiantes con necesidades educativas especiales. Pero el 65 % dice no tener los conocimientos para enseñar con ella y el 78 % pide formación. Ese es el punto: la diferencia no está entre quien usa y quien no usa, sino entre quien usa con método y quien usa a la carrera.</p>
<p><strong>Planeación.</strong> Antes: una tarde entera adaptando la guía del año pasado. Con IA mal usada: una guía genérica con contextos de otro país y referencias a DBA que no existen. Con IA y criterio: una secuencia con tu grado, tus recursos y tus referentes curriculares, que tú revisas en veinte minutos. Para eso armé el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>, con recetas probadas por materia y alineadas con el currículo colombiano; no reemplaza tu revisión, la hace más rápida.</p>
<p><strong>Evaluación.</strong> El docente que domina la IA no le pide "un examen de fracciones": define qué evidencia de aprendizaje necesita, revisa cada clave y ajusta la dificultad. Ese principio guía el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>, que arma versiones, hoja de respuestas y solucionario; antes de pagar puedes probar el <a href="/examenes/demo/">simulador gratuito</a>.</p>
<p><strong>Inclusión.</strong> Un PIAR no se puede improvisar con un chat genérico, ni se deben pegar en él datos sensibles de un niño. La IA puede proponer ajustes razonables a partir de una valoración pedagógica bien hecha, pero el criterio y el acta son del equipo docente. Con esa lógica construí <a href="/herramientas/piar/">PIAR con IA</a>, que permite probar un PIAR gratis antes de decidir.</p>
<p><strong>Retroalimentación y carga administrativa.</strong> La IA puede convertir tus notas rápidas en comentarios claros para cada estudiante o en una circular comprensible para las familias. Lo que no sabe es que Juan viene de una semana difícil. Ese dato lo pones tú.</p>

<h2>Directivos docentes: gobernar antes que prohibir</h2>
<p>Rectores y coordinadores enfrentan una pregunta distinta: no "¿uso la IA?", sino "¿cómo la gobierno en mi institución?". Hoy, en muchos colegios, los docentes ya la usan con cuentas personales y sin reglas, como el 78 % de los usuarios de IA en el trabajo que, según Microsoft y LinkedIn, lleva sus propias herramientas.</p>
<ul>
<li><strong>Política institucional.</strong> Antes: silencio o prohibición. Con criterio: un acuerdo breve, discutido con el consejo académico, sobre usos permitidos, datos que nunca se comparten y cómo se informa el uso de IA a estudiantes y familias.</li>
<li><strong>PEI y manual de convivencia.</strong> Incorporar la IA en el plan de estudios de manera transversal y actualizar el manual frente a nuevos problemas, como las imágenes falsas de compañeros o los trabajos copiados sin comprensión.</li>
<li><strong>Datos.</strong> Usar la IA para leer resultados de pruebas Saber o de desempeño interno y formular preguntas, no para etiquetar estudiantes. Un directivo con alfabetización de datos pregunta qué falta en esa tabla antes de tomar decisiones con ella.</li>
<li><strong>Comunicación.</strong> Circulares más claras, respuestas oportunas a las familias y actas mejor redactadas, siempre revisadas por una persona.</li>
<li><strong>Gobierno y privacidad.</strong> Saber qué herramientas usan los docentes, dónde quedan los datos de los estudiantes y qué contratos se firman. Los datos de menores merecen el máximo cuidado.</li>
</ul>

<h2>Profesionales de otras áreas: antes y después</h2>
<p>Pienso en una contadora de una pyme en Barranquilla. Antes, el cierre de mes era una semana de cruzar extractos, perseguir soportes y enviar uno por uno los correos de cobro. Su colega que domina la IA automatiza los envíos, usa la IA para explicar variaciones y redactar el informe para la gerencia, y dedica el tiempo ganado al análisis que el cliente sí valora. El cliente no comparará a la contadora con la IA, sino con su colega.</p>
<table>
<thead><tr><th>Profesión</th><th>Lo que la IA acelera</th><th>Lo que no se delega</th></tr></thead>
<tbody>
<tr><td>Contaduría</td><td>Conciliaciones, borradores de informes, explicación de variaciones</td><td>Firma, juicio profesional y responsabilidad ante la DIAN</td></tr>
<tr><td>Derecho</td><td>Primeras versiones, resúmenes de expedientes, búsqueda inicial</td><td>Verificar cada cita y norma; estrategia y argumentación</td></tr>
<tr><td>Administración en salud</td><td>Agendas, respuestas a usuarios, análisis de glosas</td><td>Privacidad de historias clínicas y decisiones sobre pacientes</td></tr>
<tr><td>Ingeniería</td><td>Documentación, revisión de código, cálculos preliminares</td><td>Validación técnica, normas de seguridad y firma</td></tr>
<tr><td>Mercadeo</td><td>Variantes de piezas, segmentación, análisis de comentarios</td><td>Estrategia, ética publicitaria y voz de la marca</td></tr>
<tr><td>Sector público</td><td>Respuestas a peticiones, resúmenes normativos, informes</td><td>Debido proceso, transparencia y protección de datos</td></tr>
<tr><td>Pyme</td><td>Cotizaciones, inventarios, atención por chat</td><td>Relación con el cliente y decisiones de negocio</td></tr>
</tbody>
</table>
<p>Un apunte crítico, porque me toca de cerca: no todo lo que parece IA lo es. Muchas tareas de oficina no necesitan un modelo de lenguaje, sino una automatización bien hecha, predecible y auditable. Si cada mes envías decenas de correos personalizados con adjuntos o generas certificados uno por uno, una plantilla para <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">enviar correos masivos desde Excel</a> o para <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">combinar correspondencia y generar PDF individuales</a> resuelve el problema sin inventar nada. En la sección de <a href="/excel/">Excel y automatización</a> hay más ejemplos. Dominar la IA también es saber cuándo no hace falta.</p>

<h2>América Latina: desventaja y oportunidad</h2>
<p>Nuestra región tiene razones para preocuparse y razones para entusiasmarse. Las preocupaciones: informalidad alta, conectividad desigual, modelos entrenados sobre todo en inglés que no siempre entienden nuestras normas ni nuestras variantes del español, e instituciones con poca capacidad para evaluar y comprar tecnología. El estudio de la OIT y el Banco Mundial lo cuantifica: la mitad de los empleos que podrían ganar productividad con IA están frenados por la brecha digital.</p>
<p>Las oportunidades también son concretas. Colombia aprobó en febrero de 2025 el {$ext('https://www.dnp.gov.co/publicaciones/Planeacion/Paginas/conpes-4144-hoja-de-ruta-colombia-inteligencia-artificial-retos-actuales-transformacion-futura.aspx?ID=291', 'CONPES 4144')}, su política nacional de IA, con unos 479.000 millones de pesos hasta 2030 y un eje dedicado al talento. En el {$ext('https://mintic.gov.co/portal/inicio/Sala-de-prensa/Noticias/416782:Colombia-asciende-al-cuarto-lugar-en-el-Indice-Latinoamericano-de-Inteligencia-Artificial-de-la-CEPAL', 'Índice Latinoamericano de IA 2025')} de la CEPAL y el CENIA, el país subió al cuarto lugar entre 19, con 55,84 puntos. Y nuestros docentes usan IA más que el promedio de la OCDE. La oportunidad es que una pyme de Montería o un colegio de Sincelejo accedan a capacidades que hace cinco años solo tenían las grandes empresas; el riesgo, que la aprovechen solo los que ya estaban conectados.</p>

<h2>Plan de 30 días</h2>
<p>Nadie domina la IA leyendo artículos. Esta es una ruta corta, con una hora semanal como mínimo.</p>
<h3>Para docentes</h3>
<ol>
<li><strong>Semana 1:</strong> elige una sola tarea que te robe tiempo, por ejemplo una guía o una rúbrica, y mide cuánto tardas hoy.</li>
<li><strong>Semana 2:</strong> hazla con IA usando contexto, formato y restricciones; revisa cada dato y anota los errores que encuentres.</li>
<li><strong>Semana 3:</strong> escribe tu propia regla de privacidad: qué nunca pegas en un chat (nombres, diagnósticos, documentos).</li>
<li><strong>Semana 4:</strong> compara el tiempo real ahorrado, comparte lo aprendido con tu área y decide qué incorporas y qué descartas.</li>
</ol>
<h3>Para directivos docentes</h3>
<ol>
<li><strong>Semana 1:</strong> haz una encuesta anónima sobre qué herramientas usan ya los docentes y para qué.</li>
<li><strong>Semana 2:</strong> redacta con el consejo académico un acuerdo de uso de una página: usos permitidos, datos protegidos y transparencia.</li>
<li><strong>Semana 3:</strong> escoge un proceso institucional, como circulares o actas, y pruébalo con IA y revisión humana.</li>
<li><strong>Semana 4:</strong> presenta los resultados al consejo directivo y define una línea de formación docente para el semestre.</li>
</ol>
<h3>Para profesionales de otras áreas</h3>
<ol>
<li><strong>Semana 1:</strong> haz un inventario de tus tareas repetitivas y marca cuáles necesitan criterio y cuáles solo reglas.</li>
<li><strong>Semana 2:</strong> automatiza una tarea de reglas fijas y prueba la IA en una tarea de redacción o análisis.</li>
<li><strong>Semana 3:</strong> crea una lista de verificación para tu campo: cifras, citas, normas y datos sensibles.</li>
<li><strong>Semana 4:</strong> documenta tu nuevo flujo para que otra persona pueda seguirlo. Que no se convierta en otro Excel inmortal.</li>
</ol>

<h2>Conclusión</h2>
<p>Vuelvo a la caricatura. El que teme y el que se confía comparten algo: ninguno de los dos está aprendiendo. La IA no va a reemplazar al buen docente, a la buena contadora ni al buen ingeniero, pero sí va a dejar en evidencia a quien no sabe verificar, a quien no sabe formular un problema y a quien defiende un proceso solo porque "funciona". La tecnología cambia; que nuestras contradicciones no nos dejen atrás.</p>

<p class="notice"><strong>Herramientas para empezar con criterio.</strong> Si eres docente, el <strong>Kit de IA para docentes</strong> trae recetas probadas por materia, alineadas con el currículo colombiano, por 60.000 pesos cada materia; <strong>PIAR con IA</strong> te deja probar un PIAR gratis y luego elegir paquetes de 5, 10 o 20 planes por 30.000, 50.000 u 80.000 pesos; y el <strong>Generador de exámenes con IA</strong> tiene simulador gratuito y planes desde 29.900 pesos. Si trabajas en oficina, las plantillas de <a href="/excel/">Excel y automatización</a> resuelven tareas repetitivas sin depender de la IA. Ninguna reemplaza tu criterio: están hechas para que lo uses en lo que importa.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">Ver el Kit de IA para docentes</a></p>

<h2>Una pregunta para terminar</h2>
<p>Durante siglos, la experiencia de un profesional se construyó haciendo miles de veces las tareas más básicas: el contador que cuadraba a mano, el abogado que leía expedientes completos, el docente que corregía cuaderno por cuaderno. Hoy esas son justamente las tareas que la IA hace primero y, como muestran los datos, es en los principiantes donde se siente el primer golpe. <strong>Si la IA nos quita el trabajo repetitivo con el que se formaba el criterio, ¿cómo vamos a formar el criterio de quienes vienen detrás, que es precisamente lo que la IA no puede reemplazar?</strong></p>
HTML,
];
