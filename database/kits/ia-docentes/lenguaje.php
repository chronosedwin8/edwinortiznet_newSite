<?php
declare(strict_types=1);
// Kit de IA para docentes — Lengua Castellana (Colombia). Contenido curado: recetas de prompts,
// cadenas de trabajo, rúbricas, errores típicos de la IA y banco de contextos. Lo lee el build del PDF.
return [
  'key' => 'lenguaje',
  'name' => 'Lengua Castellana',
  'tagline' => 'Prompts probados, ejemplos editados y rúbricas para enseñar a leer, escribir, hablar y escuchar en el aula colombiana, de transición a 11.°, sin que la IA invente citas, estándares ni lecturas.',

  'intro_html' => <<<'TXT'
<p>Cualquier docente puede escribirle a un chat «hazme un taller de comprensión lectora para séptimo». Lo que recibe casi siempre es un texto genérico escrito en español de España, con preguntas que solo piden copiar información, distractores que nadie elegiría, un «estándar» que no existe y, con frecuencia, una cita de García Márquez que García Márquez nunca escribió. Este kit existe para cerrar esa distancia: convierte a la IA en un asistente útil para el área de Lengua Castellana <strong>sin entregarle el criterio pedagógico</strong>, que sigue siendo tuyo.</p>
<p>La diferencia está en tres cosas. Primero, cada receta está <strong>alineada con los referentes colombianos</strong>: los cinco factores de los Estándares Básicos de Competencias en Lenguaje (2006), los DBA de Lenguaje (versión 2, 2016), las afirmaciones de las pruebas Saber 3.°, 5.° y 9.° y de Lectura Crítica de Saber 11, la escala del Decreto 1290 de 2009 y el enfoque de DUA y PIAR del Decreto 1421 de 2017. Segundo, los prompts obligan a la IA a <strong>trabajar sobre los textos que tú le entregas</strong> (fragmentos de la obra, la noticia, el escrito del estudiante), a declarar el grado, a usar español de Colombia y a verificar su propio trabajo contra criterios concretos antes de responder. Tercero, cada receta trae un <strong>ejemplo real editado por un experto</strong> y una lista de lo que debes revisar, porque la IA comete en lenguaje errores muy específicos que conviene conocer de antemano.</p>
<p>El kit está organizado en seis bloques de recetas (planeación, evaluación, adaptación e inclusión, recursos, retroalimentación y gestión), cuatro <strong>cadenas de trabajo</strong> que encadenan recetas para resolver una unidad completa, un <strong>banco de rúbricas</strong> con descriptores observables en la escala Superior, Alto, Básico y Bajo, un catálogo de <strong>errores típicos de la IA</strong> en el área y un <strong>banco de contextos colombianos</strong> para que tus consignas de lectura, escritura y oralidad dejen de sonar a libro importado.</p>
<p>Cómo usarlo: copia el prompt, reemplaza las variables entre corchetes (por ejemplo <em>[GRADO]</em> o <em>[TEXTO]</em>) con tu información real, pega el texto fuente cuando la receta lo pida y lee el resultado con la lista «Revisar antes de usar». Los tiempos ahorrados son estimaciones de docentes que ya usaron las recetas frente a hacer el mismo material desde cero; incluyen el tiempo de revisión. Nunca pegues nombres completos, documentos de identidad ni diagnósticos de tus estudiantes: usa iniciales o «Estudiante A».</p>
TXT,

  'referentes_html' => <<<'TXT'
<h3>1. Estándares Básicos de Competencias en Lenguaje (MEN, 2006)</h3>
<p>Están organizados por <strong>grupos de grados</strong> (1.° a 3.°, 4.° y 5.°, 6.° y 7.°, 8.° y 9.°, 10.° y 11.°) y en cinco <strong>factores</strong>: <em>Producción textual</em>; <em>Comprensión e interpretación textual</em>; <em>Literatura</em>; <em>Medios de comunicación y otros sistemas simbólicos</em>; y <em>Ética de la comunicación</em>. Cada estándar tiene un <strong>enunciado identificador</strong> (por ejemplo, para 8.° y 9.°: «Comprendo e interpreto textos, teniendo en cuenta el funcionamiento de la lengua en situaciones de comunicación, el uso de estrategias de lectura y el papel del interlocutor y del contexto») y unos <strong>subprocesos</strong> que empiezan por «Para lo cual…». El propio documento aclara que el estándar cobija tanto el enunciado como sus subprocesos, así que en tu planeación puedes citar el enunciado y precisar el subproceso que trabajas.</p>
<p>Un detalle útil al planear literatura: en 8.° y 9.° el estándar se centra en las <strong>obras literarias latinoamericanas</strong> (incluida la tradición oral latinoamericana), mientras que en 10.° y 11.° habla de «manifestaciones literarias del <strong>contexto universal</strong>». La literatura colombiana cabe en ambos, pero cambia el tipo de relaciones que se le piden al estudiante. En 6.° y 7.° aparece de forma explícita la tradición oral («Reconozco la tradición oral como fuente de la conformación y desarrollo de la literatura»): mitos, leyendas, coplas, refranes y canciones.</p>
<table>
<tr><th>Grupo</th><th>Énfasis que conviene recordar al planear</th></tr>
<tr><td>1.° a 3.°</td><td>Textos orales y escritos con propósitos comunicativos cercanos; textos con diferentes formatos y finalidades; literatura para el desarrollo creativo y lúdico; medios masivos y sistemas no verbales; roles de la comunicación.</td></tr>
<tr><td>4.° y 5.°</td><td>Entonación y pertinencia articulatoria en la oralidad; escritura con procedimiento estratégico (planear, escribir, revisar); estrategias de búsqueda y organización de información; hipótesis de lectura en textos literarios.</td></tr>
<tr><td>6.° y 7.°</td><td>Tipologías textuales; estrategias argumentativas orales; escritura con procedimientos sistemáticos y nexos intertextuales; tradición oral; obras de diferentes géneros; respeto por la diversidad cultural.</td></tr>
<tr><td>8.° y 9.°</td><td>Funcionamiento de la lengua y estrategias de lectura; textos orales argumentativos para llegar a acuerdos; literatura latinoamericana; confrontación de medios con otras fuentes; reflexión crítica sobre los actos comunicativos.</td></tr>
<tr><td>10.° y 11.°</td><td>Textos argumentativos y ensayo; comprensión con actitud crítica y capacidad argumentativa; literatura universal y teoría literaria; lectura crítica de medios; respeto por la diversidad cultural y social.</td></tr>
</table>

<h3>2. Derechos Básicos de Aprendizaje (DBA) de Lenguaje</h3>
<p>Los DBA de Lenguaje vigentes son la <strong>versión 2 (MEN, 2016)</strong>, elaborada con la Universidad de Antioquia a partir de la primera versión de 2015. Cubren de 1.° a 11.° (transición tiene su propio documento de DBA) y en cada grado hay <strong>ocho DBA</strong>, cada uno con tres partes: <em>enunciado</em>, <em>evidencias de aprendizaje</em> y <em>ejemplo</em>. En casi todos los grados siguen un patrón: los primeros DBA se refieren a medios de comunicación y sistemas no verbales, luego vienen los de literatura, después los de escucha y comprensión, y los últimos a producción oral y escrita. Por ejemplo, en 6.° hay un DBA sobre interpretar obras de la tradición popular propias del entorno; en 9.°, uno sobre interpretar textos atendiendo al funcionamiento de la lengua a partir de estrategias de lectura; en 11.°, uno sobre producir textos académicos con procedimientos sistemáticos de corrección lingüística.</p>
<p>El MEN aclara que los DBA <strong>no son por sí solos una propuesta curricular</strong>: se articulan con el PEI, el plan de área y el plan de aula, y pueden moverse de un grado a otro según el proceso del grupo. Por eso en este kit nunca le pedimos a la IA que «recuerde» un DBA: <strong>tú pegas el enunciado y las evidencias</strong> del documento oficial y la IA trabaja sobre ese texto.</p>

<h3>3. Mallas de aprendizaje y referentes de primera infancia</h3>
<p>Las <strong>Mallas de aprendizaje de Lenguaje (MEN, 2017)</strong> desarrollan los DBA de 1.° a 5.° con secuencias, consideraciones didácticas y orientaciones de evaluación por grado. Para <strong>transición</strong>, los referentes son los DBA de transición (2016) y las Bases curriculares para la educación inicial y preescolar (2017), que trabajan el lenguaje desde el juego, la literatura, el arte y la exploración del medio, sin escolarizar la lectura y la escritura convencionales. También sigue vigente como marco conceptual el documento de <strong>Lineamientos Curriculares de Lengua Castellana (1998)</strong>, de donde viene la distinción entre lectura literal, inferencial y crítico-intertextual.</p>

<h3>4. Pruebas Saber 3.°, 5.° y 9.° (Lenguaje)</h3>
<p>Durante años la prueba de Lenguaje evaluó la <strong>competencia comunicativa lectora</strong> y la <strong>competencia comunicativa escritora</strong> a través de tres <strong>componentes</strong>: <em>semántico</em> (qué dice el texto), <em>sintáctico</em> (cómo se organiza) y <em>pragmático</em> (para qué, quién y en qué situación). Muchos informes institucionales y planes de mejoramiento todavía usan esa estructura. El marco de referencia más reciente del Icfes («Competencias comunicativas en lenguaje: lectura y escritura», 2020) organiza la <strong>lectura</strong> en tres afirmaciones:</p>
<ul>
<li><strong>Recupera información literal</strong> expresada en fragmentos del texto (vocabulario, tiempo, lugares, hechos, personajes, narrador).</li>
<li><strong>Comprende el sentido local y global</strong> del texto mediante inferencias de información implícita (intención comunicativa, funciones de las partes, voces, relación entre elementos lingüísticos y no lingüísticos, paráfrasis adecuadas).</li>
<li><strong>Asume una posición crítica</strong> sobre el texto mediante la evaluación de su forma y contenido (relación texto-contexto, evaluación de ideas, comparación entre textos, estrategias discursivas).</li>
</ul>
<p>El peso de lo literal baja a medida que sube el grado: en la guía de Saber 3.° de 2022 es la afirmación con más preguntas (cerca del 40 %), y en la de Saber 9.° de 2023 es la de menos (cerca del 20 %, frente a 40 % inferencial y 40 % crítico). En 3.° predominan los textos discontinuos; en 5.° y 9.°, los continuos, con más secuencias argumentativas y explicativas en 9.°. La <strong>escritura</strong> se evalúa con una pregunta abierta en la que el estudiante produce un texto; el marco de 2020 propone para 5.° y 9.° el texto argumentativo, y las guías de cada aplicación precisan la secuencia que se pide. Se valora en tres dominios: discursivo (responde a la pregunta y mantiene la secuencia), textual (coherencia, cohesión y concordancia) y legibilidad (ortografía y puntuación que permiten leer el texto). Consulta siempre en icfes.gov.co la guía de orientación del año en que se aplica la prueba.</p>

<h3>5. Saber 11: Lectura Crítica</h3>
<p>Evalúa tres competencias: <strong>(1) identificar y entender los contenidos locales que conforman un texto</strong>; <strong>(2) comprender cómo se articulan las partes de un texto para darle un sentido global</strong>; y <strong>(3) reflexionar a partir de un texto y evaluar su contenido</strong>. Usa textos <em>continuos</em> (cuento, novela, poema, ensayo, columna de opinión, texto filosófico) y <em>discontinuos</em> (infografías, tablas, gráficos, cómics, avisos), literarios e informativos. En las guías de orientación recientes la segunda competencia tiene el mayor peso, seguida de la tercera; la primera es la de menor peso.</p>

<h3>6. Evaluación, inclusión y lectura</h3>
<ul>
<li><strong>Decreto 1290 de 2009</strong>: escala nacional de desempeño <em>Superior, Alto, Básico y Bajo</em>. Cada institución define en su Sistema Institucional de Evaluación de los Estudiantes (SIEE) la equivalencia con su escala numérica y los criterios de promoción. El desempeño Básico es la superación de los desempeños necesarios con referencia en los estándares; el Bajo, su no superación.</li>
<li><strong>Decreto 1421 de 2017</strong> (compilado en el Decreto 1075 de 2015): educación inclusiva de estudiantes con discapacidad, <strong>Diseño Universal para el Aprendizaje (DUA)</strong>, <strong>ajustes razonables</strong> y <strong>Plan Individual de Ajustes Razonables (PIAR)</strong>, que elaboran docentes de aula y de apoyo con la familia. Para estudiantes sordos usuarios de Lengua de Señas Colombiana (LSC) contempla la oferta bilingüe bicultural: LSC como primera lengua y castellano escrito como segunda lengua.</li>
<li><strong>Plan Nacional de Lectura y Escritura «Leer es mi cuento»</strong> (liderado por el MEN desde 2011 y hoy Plan Nacional de Lectura, Escritura y Oralidad, que incorporó la oralidad a sus acciones): dotación de bibliotecas escolares (entre ellas la <strong>Colección Semilla</strong>) y formación de mediadores de lectura.</li>
</ul>

<h3>7. Cómo citarlos en una planeación</h3>
<p>Cita el documento, el grupo de grados o el grado, el factor y el texto literal; nunca un número que no hayas comprobado. Formato sugerido:</p>
<ul>
<li><strong>Estándar</strong>: MEN (2006). Estándares Básicos de Competencias en Lenguaje, 6.° a 7.°, factor Literatura: «Comprendo obras literarias de diferentes géneros, propiciando así el desarrollo de mi capacidad crítica y creativa».</li>
<li><strong>DBA</strong>: MEN (2016). DBA de Lenguaje V.2, grado 6.°, DBA 5: «Interpreta obras de la tradición popular propias de su entorno». Evidencia seleccionada: copia la evidencia exacta del documento.</li>
<li><strong>Referente de evaluación</strong>: Icfes, Saber 3.°, 5.° y 9.°, afirmación de lectura «Comprende el sentido local y global del texto mediante inferencias de información implícita».</li>
</ul>
TXT,

  'mapa' => [
    [
      'grados' => 'Transición a 3.°',
      'enfoque' => 'Entrar a la cultura escrita sin perder la oralidad: escuchar, conversar, jugar con la lengua, leer imágenes y escribir con propósito desde las primeras grafías. En transición no se escolariza la lectura convencional; de 1.° a 3.° se consolida el código alfabético dentro de situaciones reales de comunicación.',
      'claves' => [
        'Lectura en voz alta diaria de literatura infantil de calidad (Pombo, Jairo Aníbal Niño, tradición oral) con conversación antes, durante y después.',
        'Conciencia fonológica a través de rimas, retahílas, adivinanzas, trabalenguas y canciones de ronda de la región.',
        'Escritura con destinatario real: listas, avisos para el salón, cartas a la familia, rótulos de la biblioteca de aula.',
        'Textos discontinuos cotidianos (etiquetas, recibos, avisos de la tienda, horarios) porque predominan en Saber 3.°.',
        'Oralidad planificada: contar una anécdota, recitar, dar una instrucción; con escucha respetuosa de los turnos.',
        'Con IA: textos adaptados al nivel de decodificación del grupo y cuentos de apoyo a partir de contextos locales, siempre revisados en voz alta antes de llevarlos al aula.'
      ],
    ],
    [
      'grados' => '4.° y 5.°',
      'enfoque' => 'De leer para aprender el código a leer para aprender y opinar: inferencias, intención comunicativa, organización de la información y escritura con planeación, borrador y revisión. Cierre de la básica primaria con la prueba Saber 5.° (lectura y escritura argumentativa).',
      'claves' => [
        'Inferencias locales y globales: causas, intenciones de personajes, significado de palabras por contexto.',
        'Procedimiento estratégico de escritura: plan, primera versión, revisión con lista de chequeo y versión final publicada.',
        'Primeros textos de opinión con razones (carta a la junta de acción comunal, propuesta para el recreo).',
        'Organizadores gráficos, resúmenes y toma de notas a partir de textos expositivos de ciencias y sociales.',
        'Exposiciones orales con entonación y pertinencia articulatoria; textos poéticos y figuras literarias sencillas.',
        'Con IA: bancos de preguntas en tres niveles con distractores justificados y retroalimentación de borradores anonimizados.'
      ],
    ],
    [
      'grados' => '6.° y 7.°',
      'enfoque' => 'Tipologías textuales y tradición oral: el estudiante clasifica textos, reconoce sus estructuras y su relación con la cultura que los produce. La argumentación oral aparece como estrategia explícita y la escritura incorpora nexos intertextuales.',
      'claves' => [
        'Mitos, leyendas, coplas, refranes y relatos de la región como origen de los géneros literarios (lírico, narrativo, dramático).',
        'Clasificación de textos por tipología y propósito: narrativo, descriptivo, expositivo, argumentativo, instructivo.',
        'Escritura narrativa con plan textual y reescritura atendiendo a coherencia y cohesión (conectores, pronombres, tiempos verbales).',
        'Lectura crítica básica de medios: diferenciar noticia, opinión y publicidad; identificar la fuente.',
        'Respeto por la diversidad lingüística y cultural: variedades del español en Colombia y lenguas nativas y criollas.',
        'Con IA: textos de práctica originales con contexto colombiano y talleres de ortografía construidos con los errores reales del grupo.'
      ],
    ],
    [
      'grados' => '8.° y 9.°',
      'enfoque' => 'Funcionamiento de la lengua, argumentación y literatura latinoamericana. El estudiante explica cómo funciona un texto, confronta fuentes y produce textos argumentativos orales y escritos. Cierre de la básica secundaria con Saber 9.°.',
      'claves' => [
        'Literatura latinoamericana y colombiana: García Márquez, Carrasquilla, Mejía Vallejo, Quintana, entre otros, leída con relación al contexto estético, histórico y social.',
        'Textos argumentativos y explicativos: tesis, argumentos, contraargumentos, conectores y uso de fuentes.',
        'Debate, mesa redonda y foro con normas de participación y llegada a acuerdos.',
        'Confrontación de información de medios con otras fuentes; noticias falsas y cadenas de WhatsApp.',
        'Corrección lingüística sistemática: concordancia, puntuación, tildes, queísmo y dequeísmo.',
        'Con IA: guías de lectura de obra completa a partir de fragmentos que entrega el docente y rúbricas alineadas con el dominio discursivo, textual y de legibilidad.'
      ],
    ],
    [
      'grados' => '10.° y 11.°',
      'enfoque' => 'Lectura crítica y escritura académica: ensayo argumentativo, reseña crítica, comparación de textos de distintas épocas y culturas, y lectura crítica de medios. Preparación de Saber 11 (Lectura Crítica) sin convertir la clase en un simulacro permanente.',
      'claves' => [
        'Ensayo argumentativo con tesis propia, uso honesto de fuentes y citación; reseña crítica de obras y de producciones audiovisuales.',
        'Literatura universal en diálogo con la colombiana: movimientos, épocas, recursos de la teoría literaria.',
        'Textos continuos y discontinuos (infografías, tablas, columnas de opinión, textos filosóficos breves) con las tres competencias de Lectura Crítica.',
        'Ética de la comunicación: diversidad cultural, discursos de odio, sesgos y responsabilidad en redes.',
        'Producción oral académica: ponencia, relatoría, entrevista, debate formal.',
        'Con IA: ítems tipo Saber 11 con justificación de cada opción, y criterios claros de uso de IA en la escritura con proceso visible.'
      ],
    ],
  ],

  'recetas' => [

    // ───────────────────────── PLANEACIÓN ─────────────────────────
    [
      'id' => 'LEN-01',
      'categoria' => 'planeacion',
      'titulo' => 'Planeación de clase alineada con estándar, DBA y evidencia de aprendizaje',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 40 min',
      'cuando' => 'Cuando necesitas una clase de 1 o 2 horas con momentos claros (inicio, desarrollo, cierre), coherente con el estándar y el DBA que tú eliges, y con una evidencia que puedas evaluar ese mismo día.',
      'variables' => [
        '[GRADO]' => 'Grado y número de estudiantes. Ej.: 6.°, 38 estudiantes',
        '[ESTANDAR]' => 'Enunciado identificador y subproceso copiados del documento de Estándares 2006',
        '[DBA]' => 'Enunciado del DBA y la evidencia de aprendizaje que vas a trabajar, copiados del documento oficial',
        '[TEXTO_O_TEMA]' => 'Texto que leerán (pégalo) o tema concreto',
        '[DURACION]' => 'Minutos reales de clase. Ej.: 110 minutos (bloque doble)',
        '[CONDICIONES]' => 'Recursos y realidad del aula: sin internet, un televisor, fotocopias limitadas, estudiantes con PIAR, etc.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente experto en didáctica de la Lengua Castellana en Colombia, con dominio de los Estándares Básicos de Competencias en Lenguaje (MEN, 2006) y de los DBA de Lenguaje (MEN, 2016).

CONTEXTO
Grado: [GRADO]. Duración: [DURACION]. Condiciones del aula: [CONDICIONES].
Estándar (texto oficial que te entrego, no lo modifiques): [ESTANDAR]
DBA y evidencia (texto oficial que te entrego, no lo modifiques): [DBA]
Texto o tema de la clase: [TEXTO_O_TEMA]

TAREA
Diseña una clase con tres momentos (inicio, desarrollo, cierre) cuyo propósito se derive directamente del estándar y del DBA anteriores. La clase debe incluir lectura, conversación y una producción breve (oral o escrita) que sirva como evidencia evaluable al final de la sesión.

FORMATO DE SALIDA
1. Propósito de la clase en una oración, empezando por un verbo observable.
2. Tabla con columnas: Momento | Tiempo (min) | Qué hace el docente | Qué hacen los estudiantes | Material.
3. Preguntas para la conversación: 2 literales, 3 inferenciales, 2 críticas.
4. Evidencia de aprendizaje del día y cuatro criterios para valorarla (Superior, Alto, Básico, Bajo en una frase cada uno).
5. Un ajuste DUA para quien lee con dificultad y otro para quien termina antes.

RESTRICCIONES
- Usa español de Colombia (tú/ustedes; nada de «vosotros», «ordenador» ni «coger» en sentido de tomar).
- No cites estándares, DBA ni autores distintos a los que te di. Si te falta información, escríbelo como pregunta al final.
- Los tiempos deben sumar exactamente [DURACION].
- Las actividades deben ser viables con [CONDICIONES].

VERIFICACIÓN
Antes de responder, comprueba y escribe al final en tres líneas: (a) qué palabra del estándar y qué evidencia del DBA se ven en la evidencia del día; (b) que la suma de tiempos coincide; (c) que ninguna pregunta crítica se puede responder copiando una frase del texto.
TXT,
      'seguimientos' => [
        'Reescribe el momento de desarrollo para que funcione sin fotocopias: el texto se lee en voz alta y se copia solo un fragmento en el tablero.',
        'Convierte la evidencia del día en una lista de cotejo de cinco ítems que pueda marcar mientras paso por los puestos.',
        'Propón la clase siguiente que retome esta evidencia y avance hacia la segunda evidencia del mismo DBA.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 6.°, 38 estudiantes, colegio público de Ibagué. [ESTANDAR] Literatura, 6.° y 7.°: «Reconozco la tradición oral como fuente de la conformación y desarrollo de la literatura», subproceso «Caracterizo rasgos específicos que consolidan la tradición oral, como: origen, autoría colectiva, función social, uso del lenguaje, evolución, recurrencias temáticas, etc.». [DBA] 6.°, DBA 5: «Interpreta obras de la tradición popular propias de su entorno». [TEXTO_O_TEMA] Dos versiones de la leyenda del Mohán recogidas por los estudiantes con sus abuelos (transcritas por la docente). [DURACION] 110 minutos. [CONDICIONES] Sin internet, un televisor, 20 fotocopias, un estudiante con PIAR por baja visión.',
        'resultado_html' => <<<'TXT'
<p><strong>Propósito:</strong> Comparar dos versiones de la leyenda del Mohán para explicar por qué una misma historia cambia cuando pasa de boca en boca.</p>
<table>
<tr><th>Momento</th><th>Min</th><th>Docente</th><th>Estudiantes</th></tr>
<tr><td>Inicio</td><td>20</td><td>Pregunta: «¿Quién en su casa ha oído hablar del Mohán? ¿Dónde dicen que vive?». Anota respuestas en el tablero en dos columnas: <em>lugar</em> y <em>qué hace</em>.</td><td>Comparten lo que han oído en casa. Identifican que no todos cuentan lo mismo.</td></tr>
<tr><td>Desarrollo</td><td>65</td><td>Lee en voz alta la versión A (recogida en El Espinal) y luego la versión B (recogida en Honda). Entrega una fotocopia por pareja; la versión ampliada en letra 20 para el estudiante con baja visión.</td><td>En parejas completan un cuadro: personaje, lugar, qué hace, qué advierte la historia, palabras propias de la región. Subrayan dos diferencias.</td></tr>
<tr><td>Cierre</td><td>25</td><td>Pregunta orientadora: «Si las dos versiones son distintas, ¿cuál es la verdadera?».</td><td>Escriben un párrafo de 5 a 7 líneas: por qué la historia cambió y para qué la cuentan los mayores.</td></tr>
</table>
<p><strong>Preguntas críticas:</strong> ¿Para qué crees que los adultos del río cuentan esta historia a los niños? ¿Qué pasaría con la leyenda si nadie la volviera a contar?</p>
<p><strong>Evidencia y criterios:</strong> párrafo explicativo. <em>Superior:</em> explica el cambio por la autoría colectiva y la función social con ejemplos de ambas versiones. <em>Alto:</em> explica una de las dos razones con ejemplo. <em>Básico:</em> señala diferencias sin explicarlas. <em>Bajo:</em> vuelve a contar la leyenda sin compararla.</p>
<p><strong>Verificación:</strong> la evidencia retoma «autoría colectiva» y «función social» del subproceso y «interpreta obras de la tradición popular» del DBA; 20 + 65 + 25 = 110.</p>
TXT,
      ],
      'revisar' => [
        'El estándar y el DBA aparecen exactamente como los pegaste; la IA no agregó otros «de su cosecha».',
        'Los minutos suman la duración real y el desarrollo ocupa la mayor parte del tiempo.',
        'Las preguntas «críticas» exigen una opinión argumentada, no localizar información.',
        'La evidencia del día se puede valorar en el aula, sin llevarse 38 cuadernos a la casa.',
        'El ajuste para el estudiante con PIAR coincide con lo acordado en su plan, no con una suposición de la IA.',
      ],
    ],

    [
      'id' => 'LEN-02',
      'categoria' => 'planeacion',
      'titulo' => 'Secuencia didáctica por género textual (de la lectura de modelos a la publicación)',
      'grados' => '4.° a 11.°',
      'tiempo_ahorrado' => '≈ 2 h',
      'cuando' => 'Al iniciar una unidad centrada en un género (columna de opinión, crónica, reseña, carta formal, texto expositivo) que debe terminar en un texto publicado o presentado a un destinatario real.',
      'variables' => [
        '[GRADO]' => 'Grado y características del grupo',
        '[GENERO]' => 'Género textual. Ej.: carta de opinión al periódico regional',
        '[SITUACION_REAL]' => 'Problema o situación auténtica que motiva escribir y destinatario real',
        '[SESIONES]' => 'Número de sesiones y duración de cada una',
        '[MODELOS]' => 'Uno o dos textos modelo del género que tú pegas (de prensa, libros, años anteriores)',
      ],
      'prompt' => <<<'TXT'
Actúa como especialista en didáctica de la escritura con enfoque de secuencias didácticas (lectura de modelos, planeación, textualización, revisión y publicación), trabajando para un colegio colombiano.

CONTEXTO
Grado: [GRADO]. Género: [GENERO]. Situación auténtica y destinatario: [SITUACION_REAL]. Sesiones disponibles: [SESIONES].
Textos modelo (úsalos como única fuente de ejemplos del género): [MODELOS]

TAREA
Diseña una secuencia didáctica completa que lleve al grupo desde la lectura y análisis de los modelos hasta la publicación del texto para el destinatario real.

FORMATO DE SALIDA
1. Producto final, destinatario y medio de circulación.
2. Rasgos del género que se enseñarán (máximo 6), cada uno ilustrado con una frase tomada literalmente de los modelos que te di, entre comillas.
3. Tabla de sesiones: N.° | Propósito | Actividad central | Producto parcial | Cómo verifico el avance.
4. Instrumento de revisión entre pares (6 preguntas de sí/no con espacio para «sugiero…»).
5. Criterios de la versión final en escala Superior, Alto, Básico, Bajo.

RESTRICCIONES
- Español de Colombia. Lenguaje sencillo para el docente, sin jerga innecesaria.
- No inventes ejemplos atribuidos a autores reales. Si necesitas un ejemplo adicional, escribe uno propio y márcalo «(ejemplo elaborado para la clase)».
- La escritura debe tener al menos dos versiones con revisión entre ellas.
- Incluye una sesión de oralidad (lectura en voz alta, socialización o defensa).

VERIFICACIÓN
Antes de entregar, revisa que cada rasgo del género tenga una cita real de los modelos, que el número de sesiones sea exactamente [SESIONES] y que el producto final llegue al destinatario. Reporta esta revisión en una lista de tres puntos al final.
TXT,
      'seguimientos' => [
        'Escribe la consigna de escritura que entregaré a los estudiantes en la sesión 4, con situación, propósito, destinatario, extensión y criterios, en un lenguaje adecuado para su edad.',
        'Prepara una minilección de 15 minutos sobre los conectores de contraargumento usando solo frases de los modelos.',
        'Dame tres alternativas de publicación si el periódico no responde (cartelera, emisora escolar, grupo de WhatsApp de padres con autorización).',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 9.°, 35 estudiantes de una institución técnica de Montería. [GENERO] Carta de opinión dirigida a la sección de cartas de los lectores de un periódico regional. [SITUACION_REAL] El concejo discute restringir el parrillero en moto en el centro; muchos estudiantes llegan en mototaxi. [SESIONES] 8 sesiones de 55 minutos. [MODELOS] Dos cartas de lectores publicadas el mes anterior, pegadas por la docente.',
        'resultado_html' => <<<'TXT'
<p><strong>Producto final:</strong> carta de opinión de 250 a 350 palabras enviada al correo de la sección de lectores del periódico y leída en la emisora escolar.</p>
<p><strong>Rasgos del género (con frases de los modelos):</strong></p>
<ul>
<li>Saludo y referencia al tema que motiva la carta: «Me dirijo a ustedes a propósito de la medida anunciada el pasado lunes…» (modelo 1).</li>
<li>Postura explícita en el primer párrafo: «Considero que la medida castiga a quien menos tiene» (modelo 2).</li>
<li>Argumento con dato verificable y su fuente: el modelo 1 cita el número de mototaxistas reportado por la Alcaldía.</li>
<li>Reconocimiento de la postura contraria: «Es cierto que la seguridad preocupa a todos; sin embargo…» (modelo 2).</li>
<li>Propuesta concreta antes del cierre y firma con nombre, oficio y barrio.</li>
</ul>
<table>
<tr><th>N.°</th><th>Propósito</th><th>Producto parcial</th></tr>
<tr><td>1</td><td>Conversar sobre la medida y leer las dos cartas modelo</td><td>Lista de posturas del grupo</td></tr>
<tr><td>2</td><td>Analizar la estructura de los modelos</td><td>Esquema de la carta en el cuaderno</td></tr>
<tr><td>3</td><td>Buscar y verificar datos (concejo, alcaldía, emisora local)</td><td>Ficha con dos datos y su fuente</td></tr>
<tr><td>4</td><td>Planear: tesis, dos argumentos, contraargumento, propuesta</td><td>Plan textual revisado por la docente</td></tr>
<tr><td>5</td><td>Primera versión en clase, a mano</td><td>Borrador 1</td></tr>
<tr><td>6</td><td>Revisión entre pares con el instrumento</td><td>Borrador con sugerencias</td></tr>
<tr><td>7</td><td>Reescritura y corrección lingüística</td><td>Versión final</td></tr>
<tr><td>8</td><td>Lectura en voz alta y envío</td><td>Carta enviada y grabación para la emisora</td></tr>
</table>
<p><em>Nota de la editora: se eliminó una cita que la IA atribuyó a «un columnista de El Meridiano» y que no estaba en los modelos.</em></p>
TXT,
      ],
      'revisar' => [
        'Cada «rasgo del género» se ilustra con una frase que de verdad está en tus modelos; búscala con Ctrl+F.',
        'La secuencia incluye al menos dos versiones del texto y una revisión entre ellas.',
        'El destinatario es real y el medio de circulación es posible en tu contexto.',
        'Los datos que los estudiantes usarán deben venir de fuentes verificadas por ellos, no de la IA.',
      ],
    ],

    [
      'id' => 'LEN-03',
      'categoria' => 'planeacion',
      'titulo' => 'Proyecto de aula de lectura literaria en el marco del Plan Nacional de Lectura',
      'grados' => '1.° a 7.°',
      'tiempo_ahorrado' => '≈ 2 h 30 min',
      'cuando' => 'Cuando quieres organizar un proyecto de un periodo (lectura en voz alta, maleta viajera, club de lectura, lectura en familia) aprovechando los libros que de verdad tienes en la biblioteca escolar o en la Colección Semilla.',
      'variables' => [
        '[GRADO]' => 'Grado y edades',
        '[LIBROS_DISPONIBLES]' => 'Lista de títulos y autores que verificaste en tu biblioteca (con número de ejemplares)',
        '[SEMANAS]' => 'Duración del proyecto en semanas',
        '[COMUNIDAD]' => 'Rasgos del contexto: rural o urbano, acceso de las familias a libros, tradición oral local',
        '[PRODUCTO]' => 'Producto de cierre deseado: feria, tertulia, antología, programa de radio, etc.',
      ],
      'prompt' => <<<'TXT'
Actúa como mediador de lectura con experiencia en bibliotecas escolares colombianas y en la línea del Plan Nacional de Lectura y Escritura «Leer es mi cuento».

CONTEXTO
Grado: [GRADO]. Duración: [SEMANAS] semanas. Comunidad: [COMUNIDAD].
Libros disponibles (es la ÚNICA lista que puedes usar): [LIBROS_DISPONIBLES]
Producto de cierre: [PRODUCTO]

TAREA
Diseña un proyecto de aula de lectura literaria que combine lectura en voz alta del docente, lectura autónoma, conversación literaria, escritura creativa y participación de las familias.

FORMATO DE SALIDA
1. Nombre del proyecto y pregunta que lo moviliza (formulada para niños de la edad).
2. Cronograma semana a semana: libro o libros, estrategia de mediación, producción del estudiante.
3. Para cada libro: tres preguntas de conversación literaria abiertas (no de memoria) que pueda hacer cualquier lector del libro sin que yo te dé el texto.
4. Estrategia de circulación de libros con pocos ejemplares (turnos, maleta viajera, rincón).
5. Actividad con familias que no exija que los adultos sepan leer (contar, grabar un audio, dibujar).
6. Cómo registro el avance: un instrumento sencillo de seguimiento.

RESTRICCIONES
- No agregues títulos, autores ni argumentos que no estén en mi lista. Si no conoces el contenido de un libro, dilo y propón preguntas generales que sirvan para cualquier relato.
- No inventes citas de los libros.
- Lenguaje en español de Colombia; actividades viables sin internet.

VERIFICACIÓN
Al final, escribe una tabla de control: Título | ¿Está en mi lista? | ¿Usaste información de su argumento? (sí/no) | ¿De dónde la sacaste? Si alguna fila dice «de memoria», márcala como «[POR CONFIRMAR]» para que yo la revise con el libro.
TXT,
      'seguimientos' => [
        'Prepara la invitación a las familias para el cierre, en media página, con lenguaje cálido y sencillo.',
        'Propón cinco formas de registrar la lectura que no sean el resumen escrito (ruleta de preguntas, mapa del cuento, audio, títeres, diario de lectura con dibujos).',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 3.°, niños de 8 y 9 años, sede rural de Sotaquirá (Boyacá). [LIBROS_DISPONIBLES] Rafael Pombo, «Cuentos pintados y morales» (2 ejemplares); Jairo Aníbal Niño, «La alegría de querer» (1); antología de mitos y leyendas de Colombia (3); cinco libros álbum de la dotación escolar. [SEMANAS] 8. [COMUNIDAD] Familias campesinas, abuelos con tradición de coplas y cuentos de espantos. [PRODUCTO] Programa radial grabado en celular.',
        'resultado_html' => <<<'TXT'
<p><strong>Proyecto:</strong> «La vereda cuenta». Pregunta movilizadora: <em>¿Qué historias se cuentan en mi vereda y cuáles traen los libros?</em></p>
<table>
<tr><th>Semana</th><th>Libro / fuente</th><th>Mediación</th><th>Producción</th></tr>
<tr><td>1–2</td><td>Pombo, «Cuentos pintados y morales»</td><td>Lectura en voz alta diaria de un poema; recitación en coro</td><td>Cada niño memoriza una estrofa y la dice en la formación</td></tr>
<tr><td>3–4</td><td>Antología de mitos y leyendas</td><td>Lectura compartida y comparación con lo que cuentan los abuelos</td><td>Entrevista grabada a un mayor (con guía de 4 preguntas)</td></tr>
<tr><td>5–6</td><td>Jairo Aníbal Niño, «La alegría de querer»</td><td>Lectura del docente y conversación: ¿a quién le escribirías un poema?</td><td>Poema propio para alguien de la casa</td></tr>
<tr><td>7–8</td><td>Libros álbum + producciones del grupo</td><td>Guion del programa radial</td><td>Programa de 10 minutos grabado en celular</td></tr>
</table>
<p><strong>Preguntas abiertas que sirven para cualquier poema:</strong> ¿Qué palabra te sonó bonita y por qué? ¿Qué imagen se te formó en la cabeza? ¿Este poema se parece a algo que te haya pasado?</p>
<p><strong>Circulación:</strong> los tres ejemplares de la antología viajan en una maleta de casa en casa con un cuaderno de la familia, dos noches por niño.</p>
<p><strong>Control:</strong> los cinco libros álbum no se describieron porque no se entregaron sus títulos ni su contenido; las preguntas para ellos son generales.</p>
TXT,
      ],
      'revisar' => [
        'Ningún título, autor o argumento aparece fuera de tu lista de libros disponibles.',
        'Las actividades con familias funcionan aunque los adultos no sepan leer.',
        'El cronograma cabe en tus semanas reales, descontando izadas, simulacros y festivos.',
        'Si la IA describió el contenido de un libro, compruébalo hojeándolo antes de usarlo.',
      ],
    ],

    [
      'id' => 'LEN-04',
      'categoria' => 'planeacion',
      'titulo' => 'Malla de periodo: distribución de los cinco factores en semanas',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min',
      'cuando' => 'Al comienzo de cada periodo, para que los cinco factores de los Estándares no queden reducidos a gramática y literatura, y para que el plan de aula hable el mismo idioma que el plan de área.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[PERIODO]' => 'Número de periodo y semanas efectivas',
        '[INTENSIDAD]' => 'Horas semanales de Lengua Castellana',
        '[REFERENTES]' => 'Estándares y DBA del periodo, copiados del plan de área',
        '[PROYECTOS]' => 'Proyectos institucionales que cruzan el periodo (feria de la ciencia, día del idioma, PRAE, elecciones de personero)',
      ],
      'prompt' => <<<'TXT'
Actúa como jefe de área de Humanidades de un colegio colombiano que revisa mallas curriculares con base en los Estándares Básicos de Competencias en Lenguaje (2006) y los DBA de Lenguaje (2016).

CONTEXTO
Grado: [GRADO]. Periodo: [PERIODO]. Intensidad: [INTENSIDAD].
Referentes del periodo (texto oficial que te entrego): [REFERENTES]
Proyectos institucionales: [PROYECTOS]

TAREA
Distribuye los referentes en las semanas del periodo de modo que los cinco factores (producción textual; comprensión e interpretación textual; literatura; medios de comunicación y otros sistemas simbólicos; ética de la comunicación) tengan presencia real y se articulen con los proyectos institucionales.

FORMATO DE SALIDA
1. Tabla: Semana | Factor(es) | Referente (copia literal abreviada) | Texto o situación de trabajo | Evidencia.
2. Tres evaluaciones de proceso y una de cierre, con su tipo de instrumento.
3. Un párrafo de justificación para el plan de aula (máximo 120 palabras).

RESTRICCIONES
- Solo usa los referentes que te di. No agregues códigos ni numeraciones que no estén en el texto.
- Ningún factor puede quedar con menos de una semana de trabajo explícito.
- Los textos de trabajo deben ser variados: al menos uno literario, uno informativo, uno discontinuo y uno oral.
- Español de Colombia.

VERIFICACIÓN
Al final presenta un conteo: semanas por factor y tipos de texto usados. Si un factor quedó sin evidencia, corrige la tabla antes de entregarla.
TXT,
      'seguimientos' => [
        'Señala qué semanas pueden alinearse con Ciencias Sociales para un trabajo interdisciplinario, sin cambiar los referentes.',
        'Convierte la tabla en un cronograma de una página para pegar en la cartelera del salón, con lenguaje para estudiantes.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 4.°. [PERIODO] Segundo periodo, 10 semanas efectivas. [INTENSIDAD] 5 horas. [REFERENTES] Estándares de 4.° y 5.° (los cinco factores) y DBA de 4.° sobre construir textos poéticos con figuras literarias, analizar información de medios y producir textos atendiendo al público y al contexto de circulación. [PROYECTOS] Día del Idioma (23 de abril) y elección del personero.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Sem.</th><th>Factor</th><th>Situación de trabajo</th><th>Evidencia</th></tr>
<tr><td>1–2</td><td>Literatura</td><td>Lectura de coplas y poemas; figuras: comparación y personificación</td><td>Copla propia con una comparación</td></tr>
<tr><td>3</td><td>Producción textual / Ética</td><td>Día del Idioma: recital y antología del curso</td><td>Lectura en voz alta con entonación</td></tr>
<tr><td>4–5</td><td>Medios</td><td>Comparar la misma noticia local en radio comunitaria y en el periódico</td><td>Cuadro: quién informa, qué dice, qué omite</td></tr>
<tr><td>6–7</td><td>Comprensión</td><td>Propuestas de los candidatos a personero (textos escritos y carteles)</td><td>Organizador gráfico de propuestas</td></tr>
<tr><td>8–9</td><td>Producción textual</td><td>Carta al personero electo con una propuesta para el curso</td><td>Carta en dos versiones</td></tr>
<tr><td>10</td><td>Ética de la comunicación</td><td>Asamblea de curso: escuchar y responder propuestas</td><td>Acta sencilla de acuerdos</td></tr>
</table>
<p><strong>Conteo:</strong> literatura 3 semanas, medios 2, comprensión 2, producción 3 (compartida), ética 2 (compartida). Tipos de texto: literario (coplas), informativo (noticia), discontinuo (carteles de campaña), oral (recital y asamblea).</p>
TXT,
      ],
      'revisar' => [
        'Los referentes de la tabla son copias fieles (abreviadas) de los que pegaste, sin números añadidos.',
        'Hay variedad real de textos: literario, informativo, discontinuo y oral.',
        'Las fechas institucionales caen en las semanas correctas de tu calendario.',
        'La evaluación incluye proceso y cierre, coherente con tu SIEE.',
      ],
    ],

    [
      'id' => 'LEN-05',
      'categoria' => 'planeacion',
      'titulo' => 'Guía de lectura de una obra colombiana a partir de fragmentos que tú entregas',
      'grados' => '8.° a 11.°',
      'tiempo_ahorrado' => '≈ 2 h',
      'cuando' => 'Cuando el grupo leerá una novela, cuento o crónica colombiana completa y necesitas una guía por capítulos o partes, sin que la IA invente escenas, citas ni datos de la obra.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[OBRA]' => 'Autor, título, año y edición que tienen los estudiantes',
        '[FRAGMENTOS]' => 'Fragmentos que transcribes o pegas, numerados, con página',
        '[RESUMEN_DOCENTE]' => 'Tu resumen breve de cada parte (lo que la IA no debe adivinar)',
        '[ENFOQUE]' => 'Lo que quieres trabajar: narrador, espacio, contexto histórico, símbolo, voces, etc.',
      ],
      'prompt' => <<<'TXT'
Actúa como profesor de literatura latinoamericana con experiencia en educación media en Colombia. Vas a elaborar una guía de lectura, pero SOLO puedes usar la información que yo te entrego.

CONTEXTO
Grado: [GRADO]. Obra: [OBRA]. Enfoque de lectura: [ENFOQUE].
Resumen de cada parte elaborado por el docente: [RESUMEN_DOCENTE]
Fragmentos numerados (únicas citas permitidas): [FRAGMENTOS]

TAREA
Diseña una guía de lectura por partes para acompañar la lectura completa de la obra.

FORMATO DE SALIDA
Para cada parte:
- Antes de leer: una pregunta de anticipación.
- Durante la lectura: dos pistas de atención (qué observar) sin revelar el desenlace.
- Después de leer: 2 preguntas literales, 2 inferenciales y 1 crítica. Cada pregunta que se apoye en un fragmento debe indicar «(F1, p. X)».
Al final: una actividad de escritura que relacione la obra con el contexto de los estudiantes y tres criterios para valorarla.

RESTRICCIONES
- Prohibido citar frases que no estén en [FRAGMENTOS]. Si necesitas un pasaje que no tengo, escribe «[pedir fragmento sobre…]».
- No agregues hechos de la trama, nombres de personajes, fechas ni premios que no estén en el resumen o los fragmentos.
- Las preguntas críticas deben admitir más de una interpretación válida; no impongas una lectura única.
- Español de Colombia, registro adecuado al grado.

VERIFICACIÓN
Antes de entregar, haz una lista de todas las citas entre comillas que usaste y al lado el número de fragmento donde aparece. Si alguna no aparece, elimínala. Indica también cualquier dato de la obra que hayas usado y su origen (resumen o fragmento).
TXT,
      'seguimientos' => [
        'Para cada pregunta crítica, escribe dos respuestas posibles opuestas y bien argumentadas, para mostrar a los estudiantes que hay más de una lectura válida.',
        'Prepara un control de lectura de cinco preguntas que solo pueda responder quien leyó la parte (no un resumen de internet), basándote en los fragmentos.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 9.°, Cali. [OBRA] Pilar Quintana, «La perra» (2017), edición de bolsillo de la biblioteca. [FRAGMENTOS] F1 a F4 transcritos por el docente, con páginas. [RESUMEN_DOCENTE] Cinco partes resumidas en 4 a 6 líneas cada una. [ENFOQUE] Espacio (la costa del Pacífico como fuerza del relato) y relación entre la protagonista y la perra.',
        'resultado_html' => <<<'TXT'
<h4>Parte 1</h4>
<p><strong>Antes de leer:</strong> ¿Qué esperas de una novela que se llama «La perra»? ¿De quién crees que habla el título?</p>
<p><strong>Durante la lectura:</strong> fíjate en cómo se describe el lugar donde vive la protagonista (el mar, la lluvia, el monte) y en lo que la protagonista no dice en voz alta.</p>
<p><strong>Después de leer:</strong></p>
<ol>
<li>(Literal) ¿Cómo llega la perra a la vida de la protagonista? (F1, p. 11)</li>
<li>(Literal) ¿Quiénes viven cerca de ella y qué relación tienen? </li>
<li>(Inferencial) ¿Qué revela sobre la protagonista el nombre que le pone a la perra? Apóyate en F2.</li>
<li>(Inferencial) ¿Por qué el narrador insiste en la humedad y la lluvia? ¿Qué efecto tiene en ti como lector?</li>
<li>(Crítica) ¿Es la perra un animal de compañía o algo más para ella? Defiende tu respuesta con al menos un hecho de la parte leída.</li>
</ol>
<h4>Actividad de escritura</h4>
<p>Describe en un párrafo un lugar de tu barrio o vereda que «mande» sobre la vida de quienes viven allí (el río, la loma, la avenida), imitando la forma en que la novela convierte el espacio en una fuerza.</p>
<p><strong>Verificación de citas:</strong> la guía no usa citas textuales; las preguntas 1 y 3 remiten a F1 y F2. El nombre de la perra y la ubicación del pueblo se tomaron del resumen del docente.</p>
<p><em>Nota del editor: se eliminó una pregunta que mencionaba un premio internacional de la autora que no figuraba en el material entregado.</em></p>
TXT,
      ],
      'revisar' => [
        'Todas las citas entre comillas existen en tus fragmentos; búscalas una por una.',
        'Ningún personaje, escena o desenlace fue agregado por la IA «de memoria».',
        'Las pistas «durante la lectura» no revelan el final.',
        'Las preguntas críticas aceptan interpretaciones distintas y piden argumentos del texto.',
        'Revisa que la obra y el enfoque sean apropiados para la edad y el contexto del grupo (temas sensibles, violencia, sexualidad).',
      ],
    ],

    [
      'id' => 'LEN-06',
      'categoria' => 'planeacion',
      'titulo' => 'Debate o foro argumentativo con roles, normas y preparación por evidencias',
      'grados' => '6.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h 15 min',
      'cuando' => 'Cuando quieres trabajar la oralidad argumentativa (estándar de 8.° y 9.°: «Produzco textos orales de tipo argumentativo para exponer mis ideas y llegar a acuerdos…») con un tema auténtico que divida opiniones en tu comunidad.',
      'variables' => [
        '[GRADO]' => 'Grado y número de estudiantes',
        '[TEMA]' => 'Pregunta polémica formulada como sí/no o como dilema',
        '[FUENTES]' => 'Dos a cuatro textos (noticia, columna, testimonio, datos) que tú entregas',
        '[FORMATO]' => 'Debate por equipos, mesa redonda, foro, panel o juicio simulado',
        '[TIEMPO]' => 'Sesiones de preparación y duración del debate',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de Lengua Castellana experto en argumentación oral y en convivencia escolar en Colombia.

CONTEXTO
Grado: [GRADO]. Pregunta del debate: [TEMA]. Formato: [FORMATO]. Tiempo: [TIEMPO].
Fuentes que leerán los estudiantes (únicas fuentes válidas para los datos): [FUENTES]

TAREA
Organiza el debate de principio a fin: preparación, desarrollo y evaluación, de modo que todos los estudiantes tengan un rol y que el objetivo no sea «ganar» sino argumentar con evidencias y llegar a acuerdos.

FORMATO DE SALIDA
1. Roles (posiciones, moderador, relatores, jurado, público) con su tarea concreta.
2. Ficha de preparación por equipo: tesis, tres argumentos, evidencia para cada uno (con número de fuente), contraargumento esperado y respuesta.
3. Guion del moderador con tiempos por intervención.
4. Normas de participación redactadas en positivo (máximo 6).
5. Lista de cotejo para el jurado: 6 indicadores observables.
6. Pregunta de cierre para construir un acuerdo o propuesta común.

RESTRICCIONES
- Los datos solo pueden salir de [FUENTES]; no agregues cifras ni estudios.
- Presenta las dos posturas con la misma fuerza, sin favorecer ninguna.
- Si el tema toca a comunidades, culturas o creencias, incluye una norma explícita sobre el respeto y el lenguaje no discriminatorio.
- Español de Colombia.

VERIFICACIÓN
Revisa que cada argumento de la ficha tenga una fuente asignada y que los tiempos del guion sumen la duración del debate. Indica al final cualquier argumento que quedó sin evidencia para que el equipo lo investigue.
TXT,
      'seguimientos' => [
        'Escribe cinco preguntas que el público pueda hacer a cada equipo y que obliguen a usar evidencia, no opinión.',
        'Redacta la consigna del texto escrito posterior: una columna de opinión que recoja lo aprendido en el debate.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 10.°, 40 estudiantes, Sincelejo. [TEMA] ¿Deben mantenerse las corralejas en las fiestas del municipio? [FUENTES] F1: noticia regional sobre heridos en las fiestas del año anterior; F2: columna de un historiador local que defiende la tradición; F3: comunicado de un colectivo animalista; F4: testimonio grabado de un vendedor que vive de las fiestas. [FORMATO] Debate por equipos con jurado. [TIEMPO] 2 sesiones de preparación y una de 100 minutos.',
        'resultado_html' => <<<'TXT'
<p><strong>Roles:</strong> dos equipos de 8 (a favor y en contra), 2 moderadores, 4 relatores (toman nota de argumentos y acuerdos), 6 jurados con lista de cotejo, y el resto como público con tarjetas de preguntas.</p>
<p><strong>Ficha del equipo «Mantenerlas con cambios» (extracto):</strong></p>
<ul>
<li><em>Tesis:</em> las corralejas son patrimonio de la región y deben mantenerse, pero con condiciones de seguridad.</li>
<li><em>Argumento 1:</em> sostienen la economía de muchas familias durante las fiestas. Evidencia: testimonio del vendedor (F4).</li>
<li><em>Argumento 2:</em> son parte de la identidad sabanera y de su música. Evidencia: columna del historiador (F2).</li>
<li><em>Contraargumento esperado:</em> hay heridos todos los años (F1). <em>Respuesta:</em> proponer protocolos y controles en lugar de la prohibición.</li>
</ul>
<p><strong>Normas:</strong> pedimos la palabra levantando la tarjeta; hablamos de las ideas, no de las personas; citamos la fuente cuando damos un dato; escuchamos sin interrumpir; respetamos a quienes viven de las fiestas y a quienes las rechazan.</p>
<p><strong>Pregunta de cierre:</strong> ¿Qué tendría que cambiar para que ambos equipos aceptaran las fiestas del próximo año?</p>
<p><strong>Argumento sin evidencia:</strong> «el turismo aumenta con las corralejas» no aparece en ninguna fuente; el equipo debe consultarlo antes del debate.</p>
TXT,
      ],
      'revisar' => [
        'Ninguna cifra o estudio aparece sin estar en tus fuentes.',
        'Las dos posturas tienen argumentos de calidad similar.',
        'El tema y las normas cuidan a estudiantes cuyas familias están directamente involucradas.',
        'La lista de cotejo mide argumentación y escucha, no solo «hablar bonito».',
      ],
    ],

    [
      'id' => 'LEN-07',
      'categoria' => 'planeacion',
      'titulo' => 'Experiencias de lenguaje para transición y 1.°: juego, oralidad y escritura emergente',
      'grados' => 'Transición a 1.°',
      'tiempo_ahorrado' => '≈ 50 min',
      'cuando' => 'Cuando necesitas una semana de experiencias de lenguaje para los más pequeños, centradas en el juego, la tradición oral y la literatura, sin planas ni dictados mecánicos.',
      'variables' => [
        '[GRADO]' => 'Transición o 1.°, edades y número de niños',
        '[EJE]' => 'Eje o proyecto del momento. Ej.: los animales de la finca, el mercado, mi familia',
        '[TRADICION_ORAL]' => 'Rondas, retahílas, adivinanzas o coplas de la región que conoces (pégalas)',
        '[MATERIALES]' => 'Lo que tienes a mano: libros, títeres, tapas, semillas, revistas',
      ],
      'prompt' => <<<'TXT'
Actúa como maestra de educación inicial con formación en pedagogía de la primera infancia en Colombia, conocedora de las Bases curriculares para la educación inicial y preescolar y de los DBA de transición. Recuerda que en este nivel el juego, el arte, la literatura y la exploración del medio son las actividades rectoras.

CONTEXTO
Grado: [GRADO]. Eje: [EJE]. Materiales: [MATERIALES].
Tradición oral de la región que te entrego: [TRADICION_ORAL]

TAREA
Diseña cinco experiencias de lenguaje (una por día) que integren escuchar, hablar, leer imágenes y escribir de forma emergente, todas relacionadas con el eje.

FORMATO DE SALIDA
Para cada día: nombre de la experiencia, intención pedagógica, momento de inicio (canción, ronda o pregunta), desarrollo paso a paso, qué observo en los niños (2 indicadores) y cierre.

RESTRICCIONES
- Nada de planas, copias de letras sin sentido ni dictados.
- Usa la tradición oral que te di tal como está escrita; no inventes versos atribuidos a la tradición.
- Las experiencias de escritura aceptan garabatos, dibujos, letras inventadas y escritura con el apoyo del adulto como formas válidas.
- Tiempos de 30 a 45 minutos por experiencia.
- Español de Colombia, palabras cercanas a los niños.

VERIFICACIÓN
Al final, señala en una tabla qué experiencia trabaja oralidad, lectura y escritura, y confirma que ninguna incluye ejercicios mecánicos de trazo sin propósito comunicativo.
TXT,
      'seguimientos' => [
        'Escribe un mensaje para las familias con una actividad de juego verbal para hacer en casa durante la semana.',
        'Dame tres formas de registrar lo que observo en cada niño sin interrumpir la experiencia.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] Transición, 22 niños de 5 años, Pasto. [EJE] El mercado de la plaza. [TRADICION_ORAL] Dos adivinanzas sobre frutas y una ronda tradicional que canta la docente. [MATERIALES] Frutas reales, bolsas de papel, empaques de productos, crayolas, un libro álbum sobre el mercado.',
        'resultado_html' => <<<'TXT'
<h4>Día 1: «Adivina qué traje del mercado»</h4>
<p><strong>Intención:</strong> disfrutar del juego verbal y ampliar el vocabulario de frutas y verduras de la región.</p>
<p><strong>Inicio:</strong> la ronda que canta la maestra, en círculo. <strong>Desarrollo:</strong> la maestra esconde una fruta en una bolsa de papel y dice una de las adivinanzas entregadas; los niños tocan la bolsa sin mirar y proponen respuestas. Luego cada niño describe con dos palabras una fruta que escogió («es redonda y huele dulce»). <strong>Cierre:</strong> se prueba la fruta y se nombra su sabor.</p>
<p><strong>Observo:</strong> si usa palabras para describir textura, color u olor; si espera su turno para hablar.</p>
<h4>Día 3: «Nuestra lista del mercado»</h4>
<p><strong>Intención:</strong> descubrir para qué sirve escribir.</p>
<p><strong>Desarrollo:</strong> en grupos de cuatro, los niños «escriben» la lista de lo que comprarían para el almuerzo, como puedan: dibujos, letras, recortes de empaques. La maestra pregunta: «¿Qué dice aquí?» y escribe debajo, delante del niño, la palabra convencional sin corregir la del niño.</p>
<p><strong>Observo:</strong> si diferencia el dibujo de la escritura; si usa letras de su nombre para escribir otras palabras.</p>
<p><strong>Control:</strong> oralidad (días 1, 2, 4), lectura de imágenes (días 2, 5), escritura emergente (días 3, 5). Ninguna experiencia usa planas.</p>
TXT,
      ],
      'revisar' => [
        'No hay planas, copias ni dictados disfrazados de juego.',
        'Las rondas y adivinanzas son las que entregaste o las que conoces de la región; la IA no inventó «tradición oral».',
        'Se valida la escritura no convencional del niño.',
        'Las experiencias caben en la jornada y son seguras para niños de esa edad (alimentos, objetos pequeños).',
      ],
    ],

    // ───────────────────────── EVALUACIÓN ─────────────────────────
    [
      'id' => 'LEN-08',
      'categoria' => 'evaluacion',
      'titulo' => 'Preguntas de comprensión en tres niveles tipo Saber 3.°, 5.° y 9.° con distractores justificados',
      'grados' => '3.° a 9.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando necesitas un cuestionario de selección múltiple sobre un texto que tú elegiste, con preguntas realmente inferenciales y críticas, y distractores que revelen errores de lectura y no opciones absurdas.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[TEXTO]' => 'Texto completo que leerán (pégalo)',
        '[TIPO_TEXTO]' => 'Tipo de texto: cuento, fábula, noticia, aviso, infografía, carta, etc.',
        '[NUMERO]' => 'Número de preguntas y distribución. Ej.: 8 (3 literales, 3 inferenciales, 2 críticas)',
      ],
      'prompt' => <<<'TXT'
Actúa como constructor de ítems con experiencia en evaluación de lectura en Colombia, conocedor de las afirmaciones del Icfes para Saber 3.°, 5.° y 9.°: (1) recupera información literal; (2) comprende el sentido local y global mediante inferencias; (3) asume una posición crítica evaluando forma y contenido.

CONTEXTO
Grado: [GRADO]. Tipo de texto: [TIPO_TEXTO].
Texto (única fuente para las preguntas): [TEXTO]

TAREA
Elabora [NUMERO] preguntas de selección múltiple con única respuesta (A, B, C, D).

FORMATO DE SALIDA
Para cada pregunta:
- Nivel (literal, inferencial o crítico) y qué evalúa en una frase.
- Enunciado y cuatro opciones de extensión similar.
- Clave.
- Justificación de cada distractor: qué error de lectura revela (por ejemplo, «confunde lo que dice el narrador con lo que piensa el personaje», «generaliza a partir de un detalle», «responde con conocimiento previo y no con el texto»).
Al final, una tabla: N.° | Nivel | Línea o párrafo del texto que sustenta la clave.

RESTRICCIONES
- Las preguntas inferenciales no se pueden responder copiando una frase literal del texto.
- Nada de opciones «todas las anteriores», «ninguna de las anteriores» ni opciones absurdas o chistosas.
- La clave no puede ser siempre la más larga ni estar siempre en la misma letra.
- Vocabulario y longitud de enunciados acordes con [GRADO]. Español de Colombia.

VERIFICACIÓN
Para cada pregunta, comprueba: (a) que la clave se sustenta en una parte concreta del texto; (b) que ningún distractor es también defendible como correcto; (c) que el nivel asignado es el real. Corrige antes de entregar y reporta qué ajustaste.
TXT,
      'seguimientos' => [
        'Convierte las dos preguntas críticas en preguntas abiertas y dame una rúbrica de tres niveles para calificarlas.',
        'Revisa si alguna pregunta se puede responder sin leer el texto, solo con sentido común. Si es así, reescríbela.',
        'Ordena las claves para que queden distribuidas entre A, B, C y D de forma equilibrada.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 5.°. [TIPO_TEXTO] Fábula escrita por la docente: «La guacharaca y el gavilán», sobre un ave que presume de su canto y descuida su nido. [TEXTO] 280 palabras, pegado completo. [NUMERO] 8 preguntas (3 literales, 3 inferenciales, 2 críticas).',
        'resultado_html' => <<<'TXT'
<p><strong>Pregunta 4. Nivel inferencial</strong> (relaciona acciones y consecuencias para inferir la intención del texto).</p>
<p>En la fábula, la guacharaca canta cada vez más fuerte en la rama más alta. Esto permite pensar que ella</p>
<ol type="A">
<li>quería que el gavilán la escuchara para avisarle del peligro.</li>
<li>buscaba ser admirada sin pensar en lo que podía perder.</li>
<li>sabía que su nido estaba protegido por las otras aves.</li>
<li>tenía miedo de quedarse sola en el monte.</li>
</ol>
<p><strong>Clave:</strong> B. El texto dice que «cantaba para que todo el monte supiera que no había voz como la suya» (párrafo 2) y luego muestra que el gavilán encuentra el nido.</p>
<p><strong>Distractores:</strong> A: invierte la relación entre personajes; atribuye a la guacharaca una intención que el texto no sugiere. C: introduce información que no está en el texto (otras aves que protegen). D: responde desde una emoción plausible para un niño, pero sin apoyo en el texto.</p>
<p><strong>Pregunta 7. Nivel crítico</strong> (evalúa el propósito del texto).</p>
<p>¿Para qué fue escrita principalmente esta fábula?</p>
<ol type="A">
<li>Para informar sobre las costumbres de las guacharacas en el Tolima.</li>
<li>Para enseñar que presumir puede hacernos descuidar lo importante.</li>
<li>Para describir cómo cazan los gavilanes a otras aves.</li>
<li>Para contar lo que le pasó a una guacharaca real.</li>
</ol>
<p><strong>Clave:</strong> B. <strong>Distractores:</strong> A y C confunden el texto literario con uno informativo porque los personajes son animales reales de la región; D desconoce el carácter ficcional de la fábula.</p>
TXT,
      ],
      'revisar' => [
        'Cada clave tiene una línea del texto que la sustenta; ubícala tú mismo.',
        'Las preguntas «inferenciales» no se responden copiando una frase.',
        'Ningún distractor es correcto en otra lectura razonable del texto.',
        'Las claves están distribuidas entre las cuatro letras y no son siempre la opción más larga.',
        'Lee el cuestionario en voz alta: si suena a traducción o usa palabras ajenas al grado, ajústalo.',
      ],
    ],

    [
      'id' => 'LEN-09',
      'categoria' => 'evaluacion',
      'titulo' => 'Ítems tipo Saber 11 Lectura Crítica con texto discontinuo (tabla, gráfico o infografía)',
      'grados' => '10.° y 11.°',
      'tiempo_ahorrado' => '≈ 1 h 15 min',
      'cuando' => 'Para preparar Lectura Crítica con textos discontinuos, que suelen ser los que más fallan los estudiantes, usando datos que tú controlas (de tu colegio, del municipio o de una fuente oficial que verificaste).',
      'variables' => [
        '[TEXTO_DISCONTINUO]' => 'Tabla o descripción completa de la infografía/gráfico, con título, fuente, ejes y notas',
        '[TEXTO_CONTINUO]' => 'Opcional: texto breve (columna, noticia) para preguntas de relación entre textos',
        '[NUMERO]' => 'Número de ítems por competencia',
        '[GRUPO]' => 'Grado y nivel del grupo en simulacros recientes',
      ],
      'prompt' => <<<'TXT'
Actúa como diseñador de ítems con experiencia en la prueba de Lectura Crítica de Saber 11, que evalúa tres competencias: (1) identificar y entender los contenidos locales que conforman un texto; (2) comprender cómo se articulan las partes de un texto para darle un sentido global; (3) reflexionar a partir de un texto y evaluar su contenido.

CONTEXTO
Grupo: [GRUPO].
Texto discontinuo (única fuente de datos): [TEXTO_DISCONTINUO]
Texto continuo asociado (si lo hay): [TEXTO_CONTINUO]

TAREA
Elabora [NUMERO] ítems de selección múltiple con única respuesta por cada competencia.

FORMATO DE SALIDA
Para cada ítem: competencia, enunciado, opciones A a D, clave, justificación de la clave citando la celda, barra o elemento exacto del texto, y justificación de cada distractor (qué lectura equivocada representa).
Incluye al menos: un ítem sobre lo que la tabla NO permite concluir; un ítem sobre la relación entre el título o la nota al pie y los datos; un ítem que compare el texto discontinuo con el continuo.

RESTRICCIONES
- No uses ningún dato que no esté en el texto. No hagas cálculos que el estudiante no pueda hacer mentalmente.
- Evita confundir correlación con causalidad en las claves; úsalo como distractor cuando sea pertinente.
- Lenguaje formal propio de la prueba, sin regionalismos de otros países.

VERIFICACIÓN
Recalcula cada valor numérico mencionado en las opciones contra la tabla y escribe la verificación al final («Ítem 3: 42 % − 27 % = 15 puntos, correcto»). Si encuentras un error, corrige el ítem.
TXT,
      'seguimientos' => [
        'Escribe la retroalimentación que verá el estudiante después de responder cada ítem, en dos líneas, explicando por qué su opción no era la correcta.',
        'Transforma la tabla en una infografía descrita en texto (bloques, íconos, títulos) para que pueda dibujarla en el tablero.',
      ],
      'ejemplo' => [
        'contexto' => '[TEXTO_DISCONTINUO] Tabla «Hábitos de lectura de los estudiantes de 10.° y 11.° de la I. E. (encuesta institucional, marzo, 212 respuestas)»: porcentaje que lee por gusto al menos un libro al semestre (10.°: 31 %, 11.°: 24 %); porcentaje que lee noticias solo por redes sociales (10.°: 58 %, 11.°: 63 %); nota: «la encuesta fue voluntaria y anónima». [TEXTO_CONTINUO] Columna de 300 palabras escrita por el rector sobre «la crisis de la lectura». [NUMERO] 2 por competencia. [GRUPO] 11.°, desempeño medio en simulacros.',
        'resultado_html' => <<<'TXT'
<p><strong>Ítem 2. Competencia 1 (contenidos locales).</strong> Según la tabla, ¿qué afirmación es correcta?</p>
<ol type="A">
<li>La mayoría de estudiantes de 11.° lee al menos un libro por gusto al semestre.</li>
<li>En 11.° es mayor el porcentaje que lee noticias solo por redes sociales que en 10.°.</li>
<li>Los estudiantes de 10.° leen más noticias que los de 11.°.</li>
<li>Menos de la mitad de los estudiantes de 10.° lee noticias por redes sociales.</li>
</ol>
<p><strong>Clave:</strong> B (63 % frente a 58 %). <strong>Distractores:</strong> A lee 24 % como si fuera mayoría; C infiere cantidad de lectura a partir del canal de acceso; D invierte el dato del 58 %.</p>
<p><strong>Ítem 5. Competencia 3 (reflexionar y evaluar).</strong> El rector afirma en su columna que «nuestros jóvenes ya no leen». A partir de la tabla, esta afirmación</p>
<ol type="A">
<li>se confirma, porque menos de un tercio lee libros por gusto.</li>
<li>es exagerada, porque los datos muestran que la mayoría lee noticias, aunque por redes, y la encuesta no midió otras lecturas.</li>
<li>es falsa, porque todos los estudiantes encuestados leen algo.</li>
<li>no puede evaluarse, porque la encuesta fue anónima.</li>
</ol>
<p><strong>Clave:</strong> B. <strong>Distractores:</strong> A confunde «no leer libros por gusto» con «no leer»; C generaliza sin datos; D toma la nota sobre anonimato como si invalidara la encuesta.</p>
<p><strong>Verificación:</strong> 63 % &gt; 58 %; 24 % &lt; 50 %; ningún ítem usa datos externos a la tabla.</p>
TXT,
      ],
      'revisar' => [
        'Cada número de las opciones coincide con la tabla; recalcula tú.',
        'Ninguna clave afirma causas que los datos no permiten establecer.',
        'Si usaste datos externos (DANE, Icfes, alcaldía), confirmaste la fuente y la fecha antes de dárselos a la IA.',
        'Hay ítems de las tres competencias, con más peso en la segunda y la tercera, como en la prueba.',
      ],
    ],

    [
      'id' => 'LEN-10',
      'categoria' => 'evaluacion',
      'titulo' => 'Rúbrica analítica de texto argumentativo alineada con la evaluación de escritura del Icfes',
      'grados' => '5.° a 11.°',
      'tiempo_ahorrado' => '≈ 45 min',
      'cuando' => 'Antes de pedir un texto argumentativo (carta de opinión, columna, ensayo), para que los estudiantes conozcan los criterios desde el inicio y tú califiques con descriptores observables.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[CONSIGNA]' => 'Consigna exacta que recibirán los estudiantes',
        '[EXTENSION]' => 'Extensión esperada en palabras o párrafos',
        '[ESCALA_SIEE]' => 'Equivalencia numérica de tu SIEE. Ej.: Superior 4,6–5,0; Alto 4,0–4,5; Básico 3,0–3,9; Bajo 1,0–2,9',
      ],
      'prompt' => <<<'TXT'
Actúa como evaluador de escritura con experiencia en la matriz de producción escrita del Icfes (dominios discursivo, textual y de legibilidad) y en la escala del Decreto 1290 de 2009.

CONTEXTO
Grado: [GRADO]. Consigna: [CONSIGNA]. Extensión: [EXTENSION]. Escala institucional: [ESCALA_SIEE].

TAREA
Construye una rúbrica analítica para valorar el texto argumentativo que producirá el grupo.

FORMATO DE SALIDA
1. Tabla con 5 criterios en filas y 4 niveles en columnas (Superior, Alto, Básico, Bajo). Criterios mínimos: propósito y respuesta a la consigna; tesis y argumentos; contraargumento y conclusión; coherencia y cohesión; convenciones (ortografía, puntuación, concordancia).
2. Peso porcentual de cada criterio y cómo convertir el resultado a la escala [ESCALA_SIEE].
3. Versión para estudiantes: los mismos criterios en primera persona («Mi texto…»), con lenguaje adecuado al grado.

RESTRICCIONES
- Cada descriptor debe ser observable en el texto (qué se ve), no un juicio vago («buen manejo», «adecuado»).
- Los niveles se diferencian por calidad y no solo por cantidad («tres argumentos» frente a «dos»).
- Ajusta las exigencias a [GRADO]: no pidas a 5.° lo que se espera en 11.°.
- Español de Colombia.

VERIFICACIÓN
Lee en voz alta cada fila y comprueba que un colega podría asignar el mismo nivel a un texto sin consultarte. Señala con un asterisco cualquier descriptor que aún dependa de interpretación y reescríbelo.
TXT,
      'seguimientos' => [
        'Aplica la rúbrica a este texto anonimizado de un estudiante y explica qué nivel asignas en cada criterio, citando frases del texto: [TEXTO_ESTUDIANTE].',
        'Convierte la rúbrica en una lista de chequeo de autoevaluación de 8 preguntas para antes de entregar.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 10.°. [CONSIGNA] Escribe una columna de opinión para el periódico escolar sobre si el colegio debe permitir el uso del celular en los descansos. [EXTENSION] 350 a 450 palabras. [ESCALA_SIEE] Superior 4,6–5,0; Alto 4,0–4,5; Básico 3,0–3,9; Bajo 1,0–2,9.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Criterio (peso)</th><th>Superior</th><th>Alto</th><th>Básico</th><th>Bajo</th></tr>
<tr><td>Tesis y argumentos (30 %)</td><td>La tesis aparece en el primer párrafo y es una postura discutible; cada argumento se apoya en una razón y un ejemplo, dato o experiencia verificable.</td><td>Tesis clara; los argumentos son pertinentes pero uno carece de apoyo.</td><td>La postura se entiende pero aparece tarde o es ambigua; los argumentos son opiniones sin apoyo.</td><td>No se identifica una postura o el texto narra/describe en lugar de argumentar.</td></tr>
<tr><td>Contraargumento y conclusión (20 %)</td><td>Presenta la postura contraria con justicia y la refuta; la conclusión retoma la tesis y propone algo.</td><td>Menciona la postura contraria pero la refuta de manera débil; conclusión coherente.</td><td>Menciona la postura contraria sin responderla, o la conclusión repite la introducción.</td><td>No hay contraargumento ni cierre.</td></tr>
<tr><td>Convenciones (15 %)</td><td>Sin errores que dificulten la lectura; puntuación que organiza las ideas.</td><td>Errores aislados (tildes, comas) que no afectan la comprensión.</td><td>Errores frecuentes que obligan a releer algunas oraciones.</td><td>Los errores impiden comprender partes del texto.</td></tr>
</table>
<p><strong>Conversión:</strong> Superior = 5,0; Alto = 4,3; Básico = 3,5; Bajo = 2,5 por criterio; se multiplica por el peso y se suma.</p>
<p><strong>Versión estudiante:</strong> «En mi primer párrafo se ve claramente qué pienso y alguien podría no estar de acuerdo conmigo».</p>
TXT,
      ],
      'revisar' => [
        'Los descriptores dicen qué se ve en el texto, no «muy bien», «adecuado» o «regular».',
        'La conversión a nota coincide con la escala de tu SIEE.',
        'Las exigencias corresponden al grado (5.° no escribe ensayos con citación formal).',
        'Hay un criterio de propósito: un texto bien escrito que no responde la consigna no puede ser Superior.',
      ],
    ],

    [
      'id' => 'LEN-11',
      'categoria' => 'evaluacion',
      'titulo' => 'Lista de cotejo de oralidad: exposición, declamación o relato oral',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 30 min',
      'cuando' => 'Cuando vas a evaluar presentaciones orales y necesitas un instrumento rápido de marcar en vivo, con indicadores observables de voz, organización, lenguaje no verbal y escucha.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[TIPO_ORAL]' => 'Exposición, declamación, narración de leyenda, noticiero, entrevista, etc.',
        '[DURACION]' => 'Duración de cada intervención',
        '[ENFASIS]' => 'Lo que más te interesa observar en este momento del año',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de Lengua Castellana especialista en didáctica de la oralidad en Colombia, que valora la diversidad de acentos y variedades del español del país.

CONTEXTO
Grado: [GRADO]. Tipo de intervención: [TIPO_ORAL]. Duración: [DURACION]. Énfasis: [ENFASIS].

TAREA
Diseña una lista de cotejo para usar mientras el estudiante habla.

FORMATO DE SALIDA
1. Entre 8 y 10 indicadores agrupados en: preparación y contenido; organización; voz (volumen, ritmo, pausas, entonación); lenguaje corporal; interacción con el público. Columnas: Sí | En proceso | No.
2. Tres indicadores de escucha para el público (porque la oralidad también es escuchar).
3. Fórmula sencilla para convertir la lista a la escala Superior, Alto, Básico, Bajo.
4. Dos frases de retroalimentación tipo para cada grupo de indicadores.

RESTRICCIONES
- Ningún indicador puede penalizar el acento regional, el tartamudeo, la timidez manifiesta ni la discapacidad; si es pertinente, indica cómo ajustar el instrumento.
- Cada indicador debe poder marcarse en segundos, sin interpretación compleja.
- Lenguaje adecuado para leerlo también a los estudiantes antes de la presentación.

VERIFICACIÓN
Revisa cada indicador y responde: ¿lo puede observar un compañero sin formación docente? Si la respuesta es no, reescríbelo. Informa qué indicadores cambiaste.
TXT,
      'seguimientos' => [
        'Hazme una versión de coevaluación con caritas o íconos para que la usen los compañeros de 2.°.',
        'Propón ajustes de la lista para un estudiante con PIAR que se comunica mejor con apoyo visual o tablero de comunicación.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 4.°, Valledupar. [TIPO_ORAL] Exposición sobre un animal de la Sierra Nevada o de la región. [DURACION] 3 minutos. [ENFASIS] Organización de las ideas y entonación.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Indicador</th><th>Sí</th><th>En proceso</th><th>No</th></tr>
<tr><td>1. Dice el nombre del animal y dónde vive al comenzar.</td><td></td><td></td><td></td></tr>
<tr><td>2. Presenta al menos tres datos en orden (cómo es, qué come, qué peligros enfrenta).</td><td></td><td></td><td></td></tr>
<tr><td>3. Usa palabras para ordenar: «primero», «además», «por último».</td><td></td><td></td><td></td></tr>
<tr><td>4. Habla con un volumen que se escucha desde el fondo del salón.</td><td></td><td></td><td></td></tr>
<tr><td>5. Hace pausas entre una idea y otra.</td><td></td><td></td><td></td></tr>
<tr><td>6. Cambia la entonación al hacer una pregunta al público.</td><td></td><td></td><td></td></tr>
<tr><td>7. Mira al público y no solo a la cartelera.</td><td></td><td></td><td></td></tr>
<tr><td>8. Señala la imagen o el dibujo cuando habla de él.</td><td></td><td></td><td></td></tr>
<tr><td>9. Responde una pregunta de un compañero.</td><td></td><td></td><td></td></tr>
</table>
<p><strong>Escucha (público):</strong> mira a quien expone; no interrumpe; hace una pregunta relacionada con el tema.</p>
<p><strong>Conversión:</strong> Sí = 2, En proceso = 1, No = 0. Superior 16–18; Alto 13–15; Básico 9–12; Bajo 0–8.</p>
<p><strong>Ajuste:</strong> para un estudiante con tartamudez se suprime el indicador 5 y se valora la organización con el apoyo de tarjetas.</p>
TXT,
      ],
      'revisar' => [
        'Ningún indicador castiga el acento costeño, paisa, pastuso o cualquier otro.',
        'Se pueden marcar en vivo, en tres minutos por estudiante.',
        'Incluye la escucha del público, no solo al expositor.',
        'Los rangos de conversión suman bien y se ajustan a tu SIEE.',
      ],
    ],

    [
      'id' => 'LEN-12',
      'categoria' => 'evaluacion',
      'titulo' => 'Diagnóstico de lectura en primaria: fluidez, comprensión y escritura en una sola sesión',
      'grados' => '1.° a 5.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min',
      'cuando' => 'Al comienzo del año o del periodo, para saber en qué punto está cada niño y armar grupos de apoyo, sin aplicar pruebas largas ni etiquetar.',
      'variables' => [
        '[GRADO]' => 'Grado y número de niños',
        '[TEXTO_DIAGNOSTICO]' => 'Texto corto de lectura en voz alta (tú lo eliges o lo crea la IA con LEN-18 y lo revisas)',
        '[REFERENCIA_FLUIDEZ]' => 'La referencia de velocidad o precisión que usa tu institución o tu secretaría (si no tienes, escribe «ninguna»)',
        '[TIEMPO_DISPONIBLE]' => 'Tiempo total y si cuentas con apoyo (docente de apoyo, practicante)',
      ],
      'prompt' => <<<'TXT'
Actúa como especialista colombiano en enseñanza inicial de la lectura y la escritura, con experiencia en aulas de primaria pública y en el uso de las Mallas de aprendizaje de Lenguaje (MEN, 2017).

CONTEXTO
Grado: [GRADO]. Tiempo y apoyos: [TIEMPO_DISPONIBLE].
Texto para lectura en voz alta: [TEXTO_DIAGNOSTICO]
Referencia de fluidez de la institución: [REFERENCIA_FLUIDEZ]

TAREA
Diseña un diagnóstico breve con tres partes: lectura en voz alta individual, comprensión (oral) y una escritura corta con propósito.

FORMATO DE SALIDA
1. Protocolo paso a paso para la lectura individual (qué dice el docente, qué registra, cuánto dura).
2. Hoja de registro por estudiante: palabras leídas, errores (sustitución, omisión, inversión, adición), autocorrecciones, prosodia en escala de 1 a 4, y cinco preguntas de comprensión (2 literales, 2 inferenciales, 1 de opinión) con respuesta esperada.
3. Consigna de escritura corta (ej.: un mensaje para alguien) y cuatro indicadores para valorarla.
4. Cómo agrupar a los niños en tres grupos de apoyo según los resultados, con una actividad para cada grupo.

RESTRICCIONES
- Si la referencia de fluidez es «ninguna», NO inventes normas de palabras por minuto; usa solo descripciones cualitativas y recomienda acordar una referencia institucional.
- Lenguaje descriptivo, no diagnóstico clínico: no uses «dislexia», «TDAH» ni etiquetas; solo describe lo observado y sugiere remisión a orientación si aplica.
- Español de Colombia.

VERIFICACIÓN
Revisa que todas las preguntas de comprensión se respondan con el texto y que ninguna parte del protocolo emita juicios clínicos. Reporta esa revisión al final.
TXT,
      'seguimientos' => [
        'Con estos resultados anonimizados (Estudiante A, B, C…) arma los tres grupos y propone un plan de cuatro semanas para cada uno: [RESULTADOS].',
        'Redacta un mensaje respetuoso para la familia de un niño del grupo de mayor apoyo, sin etiquetas, con dos actividades para casa.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 2.°, 31 niños, Soacha. [TEXTO_DIAGNOSTICO] «La tienda de doña Rosa», 96 palabras, escrito por la docente. [REFERENCIA_FLUIDEZ] Ninguna. [TIEMPO_DISPONIBLE] Dos jornadas, con apoyo de una practicante de licenciatura.',
        'resultado_html' => <<<'TXT'
<p><strong>Protocolo (4 a 5 minutos por niño):</strong> la practicante acompaña al grupo con una actividad de dibujo mientras la docente llama a cada niño a una mesa aparte. Le dice: «Vas a leerme esta historia en voz alta. Si no sabes una palabra, intenta y sigue». Marca sobre su copia los errores con un código: S (sustituye), O (omite), I (invierte), A (agrega), AC (se autocorrige). Al terminar, retira el texto y hace las preguntas.</p>
<p><strong>Preguntas:</strong></p>
<ol>
<li>(Literal) ¿Qué vende doña Rosa en su tienda? <em>Esperada: pan, leche y bolis.</em></li>
<li>(Literal) ¿Quién llegó sin plata?</li>
<li>(Inferencial) ¿Por qué doña Rosa le dijo «me paga mañana»? <em>Esperada: porque lo conoce, confía en él o es vecino.</em></li>
<li>(Inferencial) ¿Cómo se sintió el niño al final? ¿Cómo lo sabes?</li>
<li>(Opinión) ¿Tú qué habrías hecho si fueras doña Rosa?</li>
</ol>
<p><strong>Prosodia:</strong> 1 = silabea; 2 = lee palabra por palabra; 3 = lee por frases con algunas pausas inadecuadas; 4 = lee con fluidez y respeta la puntuación.</p>
<p><strong>Fluidez:</strong> como la institución no tiene una referencia, se registran palabras leídas en un minuto solo para comparar al mismo niño en junio y en noviembre, no para clasificarlo.</p>
<p><strong>Grupos:</strong> (1) aún no decodifica de forma autónoma: trabajo con conciencia fonológica y lectura compartida; (2) decodifica con esfuerzo: lectura repetida de textos cortos con modelo del adulto; (3) lee con fluidez: preguntas inferenciales y escritura de mensajes.</p>
TXT,
      ],
      'revisar' => [
        'La IA no inventó una norma de «palabras por minuto» para Colombia.',
        'No aparecen etiquetas clínicas; solo descripciones de lo observado.',
        'Las respuestas esperadas salen del texto.',
        'Los grupos son flexibles y se revisan, no son «los que no saben».',
      ],
    ],

    // ───────────────────── ADAPTACIÓN E INCLUSIÓN ─────────────────────
    [
      'id' => 'LEN-13',
      'categoria' => 'adaptacion',
      'titulo' => 'Adaptación de un texto a lectura fácil (DUA) preservando las ideas',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 40 min',
      'cuando' => 'Cuando un texto del grado es necesario para todos pero algunos estudiantes no pueden acceder a él (dificultades de lectura, discapacidad intelectual, llegada reciente de otro país, nivel de español), y quieres una versión accesible que conserve el contenido.',
      'variables' => [
        '[TEXTO_ORIGINAL]' => 'Texto completo (pégalo)',
        '[GRADO]' => 'Grado del grupo',
        '[PERFIL_LECTOR]' => 'Descripción funcional, sin diagnóstico: qué puede leer hoy el estudiante',
        '[IDEAS_CLAVE]' => 'Las 3 a 5 ideas que no pueden perderse (tú decides)',
      ],
      'prompt' => <<<'TXT'
Actúa como especialista en accesibilidad cognitiva y lectura fácil, con experiencia en Diseño Universal para el Aprendizaje (DUA) en colegios colombianos, en el marco del Decreto 1421 de 2017.

CONTEXTO
Grado: [GRADO]. Perfil del lector: [PERFIL_LECTOR].
Ideas que deben conservarse: [IDEAS_CLAVE]
Texto original: [TEXTO_ORIGINAL]

TAREA
Escribe una versión en lectura fácil del texto original.

FORMATO DE SALIDA
1. Versión adaptada con estas pautas: una idea por oración; oraciones de máximo 15 palabras; voz activa; orden cronológico o lógico explícito; subtítulos cada 3 a 5 oraciones; palabras difíciles necesarias explicadas entre paréntesis la primera vez; sin metáforas que no se expliquen.
2. Glosario de máximo 6 palabras del original que el estudiante debe aprender (no se eliminan, se enseñan).
3. Tabla de fidelidad: Idea clave | Dónde está en el original | Dónde está en la adaptación.
4. Dos preguntas de comprensión que puedan responder tanto quien lee el original como quien lee la adaptación (para que todos participen en la misma conversación).

RESTRICCIONES
- No agregues información que no esté en el original. No cambies datos, nombres ni cifras.
- No infantilices: el texto debe ser respetuoso con la edad del estudiante.
- Mantén el vocabulario disciplinar esencial, explicado.
- Español de Colombia.

VERIFICACIÓN
Compara la adaptación con el original oración por oración y lista cualquier dato que hayas omitido o modificado. Si alguna idea clave no aparece, corrige la adaptación.
TXT,
      'seguimientos' => [
        'Prepara una versión intermedia (oraciones de hasta 25 palabras) para quienes no necesitan lectura fácil pero sí apoyo.',
        'Sugiere pictogramas o imágenes que acompañen cada subtítulo, descritos en palabras para buscarlos en ARASAAC o dibujarlos.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 7.°. [PERFIL_LECTOR] Estudiante que decodifica bien oraciones cortas pero pierde el hilo en párrafos largos con subordinadas. [IDEAS_CLAVE] (1) el páramo produce y regula el agua; (2) los frailejones crecen muy lento; (3) la ganadería y la minería lo amenazan; (4) cuidar el páramo es cuidar el agua de las ciudades. [TEXTO_ORIGINAL] Texto expositivo de 420 palabras sobre los páramos de Colombia.',
        'resultado_html' => <<<'TXT'
<h4>¿Qué es un páramo?</h4>
<p>Un páramo es un ecosistema de alta montaña. Un ecosistema es un lugar donde viven juntos plantas, animales y otros seres. En el páramo hace frío y llueve mucho.</p>
<h4>El páramo y el agua</h4>
<p>El suelo del páramo funciona como una esponja. Recoge el agua de la lluvia y de la niebla. Después, suelta el agua poco a poco. Así nacen muchos ríos. Por eso el páramo produce y regula el agua.</p>
<h4>Los frailejones</h4>
<p>El frailejón es una planta típica del páramo. Sus hojas atrapan el agua de la niebla. El frailejón crece muy lento: aproximadamente un centímetro cada año. Si se destruye, tarda muchísimos años en recuperarse.</p>
<h4>Peligros</h4>
<p>Algunas personas llevan ganado al páramo. Otras hacen minería. Estas actividades dañan el suelo y las plantas.</p>
<h4>¿Por qué cuidarlo?</h4>
<p>El agua de muchas ciudades de Colombia viene de los páramos. Cuidar el páramo es cuidar el agua que tomamos.</p>
<p><strong>Glosario:</strong> ecosistema, regular, niebla, minería.</p>
<p><strong>Fidelidad:</strong> las cuatro ideas clave están presentes. Se omitió la lista de especies de aves del original (no era idea clave); la docente decidió mantenerla en una imagen aparte.</p>
<p><em>Nota de la editora: la IA había escrito «crece un centímetro al año» como dato exacto; se cambió por «aproximadamente», como decía el original.</em></p>
TXT,
      ],
      'revisar' => [
        'Ninguna cifra, nombre o dato cambió respecto al original.',
        'Las ideas clave que tú definiste están todas, en el mismo orden lógico.',
        'El texto no suena infantil para la edad del estudiante.',
        'Las palabras del área se explican, no se eliminan.',
      ],
    ],

    [
      'id' => 'LEN-14',
      'categoria' => 'adaptacion',
      'titulo' => 'Apoyos para estudiantes con dificultades específicas de lectura y escritura (dislexia diagnosticada) y su relación con el PIAR',
      'grados' => '2.° a 11.°',
      'tiempo_ahorrado' => '≈ 45 min',
      'cuando' => 'Cuando un estudiante tiene un diagnóstico o una valoración que reporta dificultades específicas en lectura y escritura, y necesitas convertir su PIAR en ajustes concretos para tu clase de Lengua Castellana.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[AJUSTES_PIAR]' => 'Ajustes razonables acordados en el PIAR (cópialos sin datos personales)',
        '[ACTIVIDAD]' => 'Actividad o evaluación concreta de la próxima semana',
        '[FORTALEZAS]' => 'Fortalezas e intereses del estudiante',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de apoyo pedagógico con experiencia en educación inclusiva en Colombia (Decreto 1421 de 2017) y en dificultades específicas del aprendizaje de la lectura y la escritura.

CONTEXTO
Grado: [GRADO]. Estudiante: «Estudiante A» (no tengo autorización para compartir datos personales).
Ajustes razonables acordados en su PIAR: [AJUSTES_PIAR]
Fortalezas e intereses: [FORTALEZAS]
Actividad o evaluación de la próxima semana: [ACTIVIDAD]

TAREA
Traduce los ajustes del PIAR en modificaciones concretas de la actividad, sin bajar el objetivo de aprendizaje del grado.

FORMATO DE SALIDA
1. Objetivo de la actividad (igual para todo el grupo) y qué se ajusta: acceso al texto, forma de respuesta, tiempo, evaluación.
2. Tabla: Momento de la actividad | Barrera probable | Ajuste concreto | Ajuste del PIAR al que corresponde.
3. Versión de la consigna con formato accesible (fuente sin serifa, interlineado amplio, una instrucción por línea, palabras clave en negrita).
4. Qué evaluar y qué NO penalizar (por ejemplo, ortografía en una prueba de comprensión).
5. Registro sugerido para el seguimiento del PIAR (2 o 3 líneas).

RESTRICCIONES
- Solo propones ajustes coherentes con los del PIAR; si sugieres algo nuevo, márcalo «para acordar con docente de apoyo y familia».
- No hagas diagnósticos ni recomiendes terapias o medicamentos.
- Aprovecha las fortalezas del estudiante. Español de Colombia.

VERIFICACIÓN
Revisa que cada ajuste de la tabla remita a un ajuste del PIAR y que el objetivo de aprendizaje no se haya reducido. Lista cualquier ajuste que no tenga respaldo en el PIAR.
TXT,
      'seguimientos' => [
        'Prepara la misma evaluación en formato oral: guion de preguntas y criterios equivalentes a los de la versión escrita.',
        'Redacta una nota breve para el PIAR describiendo cómo respondió el estudiante a los ajustes, en lenguaje descriptivo y sin juicios.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 8.°. [AJUSTES_PIAR] Lectura en voz alta de textos por parte de un par o audio; tiempo adicional del 50 %; posibilidad de responder oralmente o con dictado por voz en el celular; no penalizar ortografía en evaluaciones de comprensión. [ACTIVIDAD] Control de lectura de «La siesta del martes» de García Márquez con 6 preguntas abiertas. [FORTALEZAS] Excelente comprensión oral, le gusta el fútbol y dibujar.',
        'resultado_html' => <<<'TXT'
<p><strong>Objetivo (igual para todos):</strong> interpretar las actitudes de la madre y el contexto del pueblo a partir de lo que el cuento muestra y no dice.</p>
<table>
<tr><th>Momento</th><th>Barrera probable</th><th>Ajuste</th><th>PIAR</th></tr>
<tr><td>Lectura del cuento</td><td>Lectura lenta que agota antes de terminar</td><td>Escucha el audio del cuento leído por la docente mientras sigue el texto impreso</td><td>Audio o lectura por par</td></tr>
<tr><td>Preguntas abiertas</td><td>Escribir respuestas largas le toma mucho tiempo</td><td>Responde 3 preguntas por escrito con dictado por voz y 3 oralmente a la docente</td><td>Respuesta oral o dictado</td></tr>
<tr><td>Tiempo</td><td>No alcanza en 55 minutos</td><td>Dispone de unos 82 minutos (55 + 50 %); empieza en el descanso anterior si lo desea</td><td>Tiempo adicional 50 %</td></tr>
<tr><td>Calificación</td><td>Errores ortográficos</td><td>Se valora solo la interpretación y el uso de evidencias</td><td>No penalizar ortografía</td></tr>
</table>
<p><strong>No se penaliza:</strong> ortografía, caligrafía, orden de la hoja. <strong>Sí se evalúa:</strong> que justifique sus interpretaciones con hechos del cuento.</p>
<p><strong>Para acordar con docente de apoyo y familia:</strong> permitir que represente en una viñeta dibujada la escena del final como respuesta a una de las preguntas.</p>
<p><strong>Registro PIAR:</strong> «Respondió 6/6 preguntas con apoyo de audio y dictado; sus respuestas orales mostraron inferencias completas sobre la dignidad de la madre».</p>
TXT,
      ],
      'revisar' => [
        'Cada ajuste está respaldado por el PIAR o marcado como propuesta para acordar.',
        'El objetivo de aprendizaje es el mismo que el del grupo.',
        'No aparecen datos personales ni diagnósticos detallados en lo que pegaste.',
        'Lo que no se penaliza queda escrito y se comunica al estudiante.',
      ],
    ],

    [
      'id' => 'LEN-15',
      'categoria' => 'adaptacion',
      'titulo' => 'Estudiantes sordos usuarios de Lengua de Señas Colombiana: castellano escrito como segunda lengua',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando en tu grupo hay estudiantes sordos con oferta bilingüe bicultural (LSC como primera lengua, castellano escrito como segunda) y necesitas planear la clase con el intérprete o el modelo lingüístico.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[ACTIVIDAD]' => 'Actividad de la clase y texto que se trabajará',
        '[APOYOS]' => 'Con quién cuentas: intérprete de LSC, modelo lingüístico, docente bilingüe, ninguno',
        '[NIVEL_CASTELLANO]' => 'Descripción funcional del nivel de castellano escrito del estudiante',
      ],
      'prompt' => <<<'TXT'
Actúa como docente con experiencia en educación bilingüe bicultural para personas sordas en Colombia. Ten presente que la Lengua de Señas Colombiana (LSC) es una lengua completa con su propia gramática, y que para estos estudiantes el castellano escrito es una segunda lengua, como lo contempla el Decreto 1421 de 2017.

CONTEXTO
Grado: [GRADO]. Apoyos disponibles: [APOYOS]. Nivel de castellano escrito: [NIVEL_CASTELLANO].
Actividad y texto: [ACTIVIDAD]

TAREA
Planea los ajustes de la actividad para que el estudiante sordo acceda al contenido en LSC y desarrolle su castellano escrito como segunda lengua.

FORMATO DE SALIDA
1. Antes de la clase: qué compartir con el intérprete o el modelo lingüístico (vocabulario clave, texto, propósito) y con cuánta anticipación.
2. Durante la clase: estrategias visuales (organizadores, imágenes, palabras clave escritas), ubicación en el salón, turnos de palabra.
3. Tarea de castellano escrito ajustada al nivel (con apoyo visual y modelos de oraciones).
4. Cómo evaluar comprensión (que puede expresarse en LSC) por separado de la producción en castellano escrito.
5. Tres errores frecuentes de los oyentes al trabajar con estudiantes sordos y cómo evitarlos.

RESTRICCIONES
- No propongas «enseñar a hablar» ni lectura labiofacial como estrategia principal.
- No describas señas específicas de la LSC: eso le corresponde al intérprete o al modelo lingüístico.
- No evalúes la comprensión del texto con la calidad del castellano escrito.
- Español de Colombia.

VERIFICACIÓN
Comprueba que en cada momento hay acceso visual a la información y que la evaluación separa comprensión (en LSC) y producción escrita. Reporta esa revisión.
TXT,
      'seguimientos' => [
        'Prepara un banco de 15 palabras clave del texto con su definición en castellano sencillo y una imagen sugerida, para enviarlo al intérprete con anticipación.',
        'Diseña una escala de progresión del castellano escrito como segunda lengua para registrar en el PIAR al final del periodo.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 6.°, Bogotá, colegio con oferta bilingüe. [ACTIVIDAD] Lectura de la leyenda de la Llorona y escritura de una versión propia. [APOYOS] Intérprete de LSC en el aula. [NIVEL_CASTELLANO] Escribe oraciones simples, omite artículos y preposiciones, comprende textos cortos con apoyo visual.',
        'resultado_html' => <<<'TXT'
<p><strong>Antes:</strong> enviar al intérprete, dos días antes, la leyenda, el propósito («comparar versiones y escribir la propia») y el vocabulario clave: <em>leyenda, lamento, río, castigo, aparecer, versión</em>.</p>
<p><strong>Durante:</strong> la estudiante se ubica en primera fila, con visión directa al intérprete y al tablero. La leyenda se presenta primero en LSC (intérprete), luego en una secuencia de seis imágenes con una oración escrita debajo de cada una. La docente escribe en el tablero las palabras clave a medida que aparecen. En la conversación, una sola persona habla a la vez y se señala quién tiene el turno.</p>
<p><strong>Escritura en castellano:</strong> la estudiante escribe su versión con la secuencia de imágenes como apoyo y un banco de oraciones modelo («Una noche, una mujer…», «Ella buscaba…», «Desde ese día…»). Se valora el orden de los hechos y el uso de conectores temporales; los artículos y preposiciones se trabajan como meta del periodo.</p>
<p><strong>Evaluación:</strong> comprensión: la estudiante explica en LSC (con el intérprete) qué cambia entre dos versiones de la leyenda. Producción: se valora su texto con la escala de castellano como segunda lengua del PIAR, no con la rúbrica del grupo.</p>
<p><strong>Errores frecuentes:</strong> hablar mientras la estudiante mira el tablero (pierde la información); pedirle que «lea en voz alta»; hablarle al intérprete en lugar de a ella.</p>
TXT,
      ],
      'revisar' => [
        'Ninguna estrategia depende de que la estudiante oiga o lea los labios.',
        'La comprensión se evalúa en LSC y la escritura con criterios de segunda lengua.',
        'La IA no inventó descripciones de señas.',
        'Los ajustes coinciden con el PIAR y con lo acordado con el intérprete o el modelo lingüístico.',
      ],
    ],

    [
      'id' => 'LEN-16',
      'categoria' => 'adaptacion',
      'titulo' => 'Material accesible para estudiantes con baja visión o ciegos',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 40 min',
      'cuando' => 'Cuando un estudiante con baja visión o ceguera necesita acceder a guías, textos discontinuos (infografías, carteles, tiras cómicas) y evaluaciones del área.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[MATERIAL]' => 'Guía, taller o evaluación (pégala o describe sus imágenes)',
        '[PERFIL_VISUAL]' => 'Qué le funciona: macrotipo y tamaño, alto contraste, lector de pantalla, braille, audio',
        '[RECURSOS]' => 'Recursos disponibles: impresora, celular con lector de pantalla, tiflólogo, docente de apoyo',
      ],
      'prompt' => <<<'TXT'
Actúa como especialista en accesibilidad para estudiantes con discapacidad visual en el sistema educativo colombiano, con criterios de DUA y ajustes razonables (Decreto 1421 de 2017).

CONTEXTO
Grado: [GRADO]. Perfil: [PERFIL_VISUAL]. Recursos: [RECURSOS].
Material original: [MATERIAL]

TAREA
Adapta el material para que el estudiante acceda al mismo contenido y responda las mismas preguntas que sus compañeros.

FORMATO DE SALIDA
1. Indicaciones de formato para la versión impresa o digital (tipo y tamaño de letra, contraste, márgenes, estructura con títulos para lector de pantalla).
2. Descripción textual (texto alternativo) de cada imagen, infografía o viñeta: primero una frase general y luego los detalles en orden de importancia.
3. Las preguntas reescritas cuando dependen de lo visual («observa la imagen» → «según la descripción de la imagen…»), sin cambiar lo que evalúan.
4. Ajustes de tiempo y forma de respuesta.

RESTRICCIONES
- La descripción de imágenes debe ser objetiva: no interpretes lo que la pregunta evalúa (si la pregunta es inferir la emoción de un personaje por su gesto, describe el gesto, no la emoción).
- No elimines preguntas por ser visuales; adáptalas.
- Español de Colombia.

VERIFICACIÓN
Para cada descripción, verifica que no regala la respuesta de ninguna pregunta. Señala qué preguntas revisaste con ese criterio.
TXT,
      'seguimientos' => [
        'Convierte la guía a un documento estructurado para lector de pantalla: títulos jerárquicos, listas reales y tablas simples con encabezados.',
        'Escribe el guion para grabar la guía en audio, con pausas indicadas y numeración clara de preguntas.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 5.°. [MATERIAL] Taller con una tira cómica de cuatro viñetas sobre dos niños que pelean por un balón, y 5 preguntas. [PERFIL_VISUAL] Baja visión: lee macrotipo en Arial 24, negrita, alto contraste; se cansa con textos largos. [RECURSOS] Impresora en blanco y negro, docente de apoyo dos veces por semana.',
        'resultado_html' => <<<'TXT'
<p><strong>Formato:</strong> Arial 24 en negrita, interlineado 1,5, texto negro sobre blanco, una pregunta por página, sin columnas. Cada viñeta se imprime ampliada en media hoja con bordes gruesos.</p>
<p><strong>Descripción de la viñeta 3:</strong> «Dos niños en una cancha de tierra. El niño de camiseta roja abraza el balón contra el pecho y tiene la boca abierta como si gritara. La niña de trenzas tiene los brazos cruzados y el ceño fruncido. Al fondo, un perro mira hacia ellos.»</p>
<p><strong>Pregunta original:</strong> «Observa la viñeta 3. ¿Cómo se siente la niña?» <strong>Pregunta adaptada:</strong> «Según la descripción de la viñeta 3, ¿cómo se siente la niña? ¿Qué detalle te lo indica?»</p>
<p><strong>Verificación:</strong> la descripción menciona «brazos cruzados» y «ceño fruncido» (gestos) pero no dice «está brava», que es lo que evalúa la pregunta 3. Revisadas las preguntas 2, 3 y 5.</p>
<p><strong>Tiempo:</strong> 30 minutos adicionales; puede responder oralmente a la docente de apoyo las preguntas 4 y 5.</p>
TXT,
      ],
      'revisar' => [
        'Las descripciones no regalan la respuesta (describen gestos, no emociones, si eso es lo evaluado).',
        'Se conservaron todas las preguntas y lo que cada una evalúa.',
        'El formato coincide con lo que le funciona al estudiante según su PIAR.',
        'Si usas lector de pantalla, la estructura del documento es real (títulos y listas), no solo letra grande.',
      ],
    ],

    [
      'id' => 'LEN-17',
      'categoria' => 'adaptacion',
      'titulo' => 'Aula multigrado (Escuela Nueva): una misma lectura con tareas para varios grados',
      'grados' => 'Transición a 5.° (multigrado)',
      'tiempo_ahorrado' => '≈ 1 h 15 min',
      'cuando' => 'En sedes rurales con un solo docente para varios grados, cuando quieres que todos trabajen sobre el mismo texto o tema con tareas diferenciadas por grado.',
      'variables' => [
        '[GRADOS]' => 'Grados presentes y número de niños por grado',
        '[TEXTO]' => 'Texto común (pégalo): cuento, leyenda, noticia de la vereda, receta',
        '[GUIAS]' => 'Guía de Escuela Nueva u otro material que estás usando, si aplica',
        '[TIEMPO]' => 'Duración de la jornada de lenguaje',
      ],
      'prompt' => <<<'TXT'
Actúa como docente rural colombiano con experiencia en el modelo Escuela Nueva y en aulas multigrado.

CONTEXTO
Grados y niños: [GRADOS]. Tiempo: [TIEMPO]. Material de referencia: [GUIAS].
Texto común para todos: [TEXTO]

TAREA
Diseña una jornada de lenguaje con un momento común para todos y momentos diferenciados por grado, aprovechando el trabajo en grupo y la monitoría de los mayores.

FORMATO DE SALIDA
1. Momento común (15 a 20 minutos): lectura en voz alta y conversación con preguntas para distintos niveles.
2. Tabla de trabajo diferenciado: Grado | Tarea | Producto | Quién apoya (docente, monitor, autónomo).
3. Plan de rotación del docente: a qué grupo acompaña en cada bloque de tiempo.
4. Momento de socialización final en el que cada grado aporta algo.

RESTRICCIONES
- Las tareas de cada grado deben ser coherentes con lo esperado para ese grado, no la misma tarea «más larga».
- Los niños de grados superiores pueden ser monitores, pero también deben tener su propio reto.
- Sin internet ni fotocopias abundantes; materiales del entorno.
- Español de Colombia, sin infantilizar a los mayores.

VERIFICACIÓN
Revisa que en cada bloque haya un solo grupo que requiera al docente y que los demás puedan trabajar de forma autónoma. Indica el bloque en el que esto no se cumple y ajústalo.
TXT,
      'seguimientos' => [
        'Diseña tarjetas de instrucciones autónomas para cada grado, en letra grande y con íconos, para que no dependan del docente.',
        'Propón cómo registrar el avance de cada grado en una sola planilla semanal.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADOS] Transición (2), 1.° (3), 2.° (2), 3.° (4), 4.° (3), 5.° (2). Vereda de Chaparral, Tolima. [TEXTO] Leyenda del Mohán contada por un abuelo y transcrita por la docente (250 palabras). [GUIAS] Guías de Escuela Nueva de Lenguaje. [TIEMPO] 2 horas.',
        'resultado_html' => <<<'TXT'
<p><strong>Momento común (20 min):</strong> la docente lee la leyenda. Pregunta para los pequeños: «¿Dónde vive el Mohán?». Para los medianos: «¿Por qué los pescadores le tienen miedo?». Para los grandes: «¿Para qué creen que los abuelos cuentan esta historia?».</p>
<table>
<tr><th>Grado</th><th>Tarea</th><th>Producto</th><th>Apoyo</th></tr>
<tr><td>Transición y 1.°</td><td>Dibujar al Mohán y el río; dictar a un monitor una frase sobre el dibujo</td><td>Dibujo con frase</td><td>Monitores de 5.°</td></tr>
<tr><td>2.° y 3.°</td><td>Ordenar 6 tarjetas con hechos de la leyenda y escribir el final con sus palabras</td><td>Secuencia y final escrito</td><td>Docente (bloque 1)</td></tr>
<tr><td>4.°</td><td>Entrevistar en casa a un adulto sobre otra versión y anotar 3 diferencias</td><td>Ficha de entrevista (para mañana); hoy: preguntas de la entrevista</td><td>Autónomo con tarjeta</td></tr>
<tr><td>5.°</td><td>Después de monitorear 20 min, escribir una carta a un niño de otra vereda contándole la leyenda</td><td>Carta</td><td>Docente (bloque 2)</td></tr>
</table>
<p><strong>Rotación:</strong> bloque 1 (40 min) docente con 2.° y 3.°; bloque 2 (40 min) docente con 5.°, mientras 2.° y 3.° pasan su final a limpio.</p>
<p><strong>Socialización:</strong> los pequeños muestran el dibujo, 3.° lee un final, 5.° lee la carta.</p>
TXT,
      ],
      'revisar' => [
        'Cada grado tiene una tarea con exigencia propia, no la misma más larga.',
        'En cada bloque el docente acompaña a un solo grupo y los demás tienen instrucciones autónomas.',
        'Los monitores también tienen su propio reto de aprendizaje.',
        'El texto de tradición oral se trabaja con respeto por la versión de la comunidad.',
      ],
    ],

    // ───────────────────────── RECURSOS ─────────────────────────
    [
      'id' => 'LEN-18',
      'categoria' => 'recursos',
      'titulo' => 'Texto original corto de práctica a partir de un contexto colombiano (no literario)',
      'grados' => '2.° a 9.°',
      'tiempo_ahorrado' => '≈ 35 min',
      'cuando' => 'Cuando necesitas un texto de práctica con una extensión, estructura y vocabulario exactos (para diagnóstico, comprensión o un modelo de género) y no encuentras uno que se ajuste. Es material didáctico, no literatura: se presenta como texto elaborado para la clase.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[TIPO_TEXTO]' => 'Narrativo, expositivo, instructivo, noticia, carta, aviso, receta, etc.',
        '[CONTEXTO_LOCAL]' => 'Situación, lugar y personajes de tu entorno (del banco de contextos o tuyos)',
        '[EXTENSION]' => 'Número de palabras',
        '[PROPOSITO_DIDACTICO]' => 'Para qué lo usarás: inferencias, conectores, secuencia, vocabulario, etc.',
      ],
      'prompt' => <<<'TXT'
Actúa como autor de materiales educativos de Lengua Castellana para Colombia.

CONTEXTO
Grado: [GRADO]. Tipo de texto: [TIPO_TEXTO]. Extensión: [EXTENSION] palabras (más o menos 10 %).
Contexto local: [CONTEXTO_LOCAL]
Propósito didáctico: [PROPOSITO_DIDACTICO]

TAREA
Escribe un texto original con esas características.

FORMATO DE SALIDA
1. Título.
2. Texto, con párrafos numerados.
3. Ficha técnica: número de palabras, número de oraciones, promedio de palabras por oración, palabras que pueden ser nuevas para el grado, y dónde está la información que sirve al propósito didáctico (por ejemplo, «la inferencia sobre el miedo del personaje se apoya en el párrafo 3»).
4. Rótulo para el pie del texto: «Texto elaborado para la clase con apoyo de IA y revisado por el docente».

RESTRICCIONES
- No imites el estilo de un autor real ni uses personajes de obras existentes.
- No incluyas datos factuales (cifras, fechas, nombres de instituciones reales) salvo los que te di; si el texto es expositivo y necesitas datos, deja «[POR CONFIRMAR]» en su lugar.
- Evita estereotipos regionales, étnicos o de género. Los personajes de comunidades afrocolombianas, indígenas o campesinas tienen agencia y no son decorado.
- Español de Colombia, natural para la región indicada, sin caricaturizar el habla.

VERIFICACIÓN
Cuenta las palabras y confirma que está dentro del rango. Revisa que el texto permite trabajar [PROPOSITO_DIDACTICO] y que no contiene datos factuales sin marcar.
TXT,
      'seguimientos' => [
        'Escribe una segunda versión del mismo texto con un nivel de dificultad mayor (oraciones compuestas y vocabulario menos frecuente) para el grupo avanzado.',
        'Marca en el texto los conectores y pronombres que sirven para un taller de cohesión.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 4.°. [TIPO_TEXTO] Narrativo. [CONTEXTO_LOCAL] Guapi (Cauca): una niña que acompaña a su abuela, cantadora, a preparar un arrullo para una fiesta de la vereda. [EXTENSION] 160 palabras. [PROPOSITO_DIDACTICO] Inferir emociones del personaje a partir de acciones.',
        'resultado_html' => <<<'TXT'
<p><strong>El cuaderno de la abuela Eloísa</strong></p>
<p>1. Esa mañana, Yuliana se levantó antes que el gallo. La abuela Eloísa ya estaba en el patio, sentada frente al río, con el cuaderno de tapas azules sobre las piernas.</p>
<p>2. —Hoy ensayamos el arrullo para la fiesta —dijo la abuela—. Y tú vas a cantar la primera parte.</p>
<p>3. Yuliana no respondió. Se frotó las manos, miró el agua y luego miró el camino, como si buscara por dónde salir corriendo.</p>
<p>4. La abuela abrió el cuaderno. Las letras estaban escritas a lápiz, algunas casi borradas por la humedad. Le pasó el dedo por encima a la primera línea y empezó a cantar bajito, marcando el ritmo con el pie.</p>
<p>5. Yuliana repitió la primera frase con la voz temblorosa. La abuela siguió cantando sin mirarla. Yuliana repitió la segunda frase un poco más fuerte.</p>
<p>6. Cuando llegaron al final, la niña ya no se frotaba las manos. Tomó el cuaderno y preguntó si podía copiar el arrullo en el suyo.</p>
<p><em>Texto elaborado para la clase con apoyo de IA y revisado por el docente.</em></p>
<p><strong>Ficha (verificada por la docente):</strong> 157 palabras; 14 oraciones; 11,2 palabras por oración; palabras posiblemente nuevas: <em>arrullo, cantadora, humedad</em>. El nervio de Yuliana se infiere en el párrafo 3 (se frota las manos, busca por dónde salir); el cambio, en los párrafos 5 y 6.</p>
TXT,
      ],
      'revisar' => [
        'Lleva el rótulo de texto elaborado para la clase; no lo presentes como obra literaria ni como texto de un autor.',
        'No contiene datos factuales sin respaldo: los que la IA no podía sustentar quedaron marcados como «[POR CONFIRMAR]» y ya los revisaste.',
        'El habla de los personajes es natural, sin caricatura regional.',
        'Cuenta las palabras: la IA suele equivocarse en la ficha técnica.',
      ],
    ],

    [
      'id' => 'LEN-19',
      'categoria' => 'recursos',
      'titulo' => 'Banco de consignas de escritura auténticas (situación, propósito, destinatario y género)',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 50 min',
      'cuando' => 'Cuando quieres dejar de pedir «una composición sobre…» y necesitas consignas en las que escribir tenga sentido: alguien real va a leer el texto y espera algo de él.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[GENEROS]' => 'Géneros que quieres trabajar en el año',
        '[ENTORNO]' => 'Rasgos del entorno: municipio, problemáticas, celebraciones, medios locales, oficios',
        '[CANTIDAD]' => 'Número de consignas',
      ],
      'prompt' => <<<'TXT'
Actúa como didacta de la escritura que trabaja con colegios públicos colombianos y diseña consignas auténticas.

CONTEXTO
Grado: [GRADO]. Géneros: [GENEROS]. Entorno de los estudiantes: [ENTORNO].

TAREA
Escribe [CANTIDAD] consignas de escritura auténticas.

FORMATO DE SALIDA
Cada consigna con estos elementos, en lenguaje dirigido al estudiante:
- Situación (qué está pasando y por qué hace falta este texto).
- Propósito (qué debe lograr el texto en su lector).
- Destinatario real o verosímil y medio de circulación.
- Género y extensión.
- Tres criterios de éxito en primera persona («Mi texto…»).
Al final, una tabla que muestre la variedad: Consigna | Género | Destinatario | Ámbito (personal, escolar, comunitario, público).

RESTRICCIONES
- Al menos la mitad de los destinatarios deben ser reales y alcanzables (junta de acción comunal, rector, emisora, familia, otro curso).
- No repitas el mismo género más de dos veces.
- Ninguna consigna puede pedir datos personales sensibles del estudiante o de su familia.
- Español de Colombia, adecuado a la edad.

VERIFICACIÓN
Revisa cada consigna y responde: ¿alguien leería este texto aunque no fuera una tarea? Si la respuesta es no, reescríbela.
TXT,
      'seguimientos' => [
        'Ordena las consignas en una progresión de dificultad para el año escolar.',
        'Para la consigna 3, escribe un texto modelo de calidad Alta (no Superior) para analizar con el grupo qué le falta.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 7.°. [GENEROS] Carta formal, instructivo, noticia, reseña, aviso. [ENTORNO] Barrio de Bello (Antioquia), quebrada contaminada, emisora comunitaria, torneo de microfútbol, muchos estudiantes cuidan a hermanos menores. [CANTIDAD] 6.',
        'resultado_html' => <<<'TXT'
<p><strong>Consigna 2. Instructivo.</strong> <em>Situación:</em> muchos de ustedes cuidan a hermanos menores por la tarde y a veces no saben qué hacer cuando se aburren. <em>Propósito:</em> que un hermano mayor pueda organizar un juego sin pantallas en 10 minutos. <em>Destinatario:</em> estudiantes de 5.° de la sede primaria; el instructivo se publicará en la cartelera de su salón. <em>Extensión:</em> media página con lista de materiales y pasos numerados.</p>
<p><strong>Criterios:</strong> mi instructivo dice qué se necesita antes de empezar; mis pasos están en orden y empiezan con un verbo; alguien que nunca ha jugado lo puede seguir sin preguntarme.</p>
<p><strong>Consigna 4. Noticia.</strong> <em>Situación:</em> el torneo de microfútbol del barrio terminó y la emisora comunitaria abrió un espacio para noticias juveniles. <em>Propósito:</em> informar qué pasó, quiénes ganaron y por qué fue importante para el barrio. <em>Destinatario:</em> oyentes de la emisora; la noticia se leerá al aire. <em>Extensión:</em> 150 a 200 palabras.</p>
<table>
<tr><th>Consigna</th><th>Género</th><th>Destinatario</th><th>Ámbito</th></tr>
<tr><td>1</td><td>Carta formal</td><td>Junta de acción comunal (quebrada)</td><td>Comunitario</td></tr>
<tr><td>2</td><td>Instructivo</td><td>Estudiantes de 5.°</td><td>Escolar</td></tr>
<tr><td>3</td><td>Reseña</td><td>Biblioteca escolar (recomendación)</td><td>Escolar</td></tr>
<tr><td>4</td><td>Noticia</td><td>Oyentes de la emisora</td><td>Público</td></tr>
</table>
TXT,
      ],
      'revisar' => [
        'Los destinatarios son alcanzables en tu contexto y el texto realmente llegará a ellos.',
        'No hay consignas que expongan situaciones familiares sensibles.',
        'Los criterios de éxito son comprensibles para el estudiante.',
        'Hay variedad de géneros y ámbitos.',
      ],
    ],

    [
      'id' => 'LEN-20',
      'categoria' => 'recursos',
      'titulo' => 'Taller de ortografía y puntuación contextualizada a partir de los errores reales del grupo',
      'grados' => '4.° a 11.°',
      'tiempo_ahorrado' => '≈ 45 min',
      'cuando' => 'Cuando revisaste un lote de textos y ves errores que se repiten. En lugar de listas de palabras sueltas, quieres un taller que trabaje esas reglas en textos con sentido y con la norma vigente.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[ERRORES]' => 'Errores reales copiados de los textos (sin nombres), con su forma correcta',
        '[CONTEXTO_TEXTO]' => 'Tema o situación para el texto del taller',
        '[TIEMPO]' => 'Duración del taller',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de Lengua Castellana experto en ortografía y puntuación del español según la Ortografía de la lengua española (RAE y ASALE, 2010) y sus actualizaciones.

CONTEXTO
Grado: [GRADO]. Tiempo: [TIEMPO]. Tema para el texto del taller: [CONTEXTO_TEXTO].
Errores reales del grupo (forma escrita → forma correcta): [ERRORES]

TAREA
Diseña un taller que parta de esos errores, explique la regla con lenguaje claro y la practique en un texto con sentido.

FORMATO DE SALIDA
1. Agrupación de los errores por regla (máximo 4 reglas).
2. Para cada regla: explicación en dos o tres oraciones, un ejemplo correcto y uno incorrecto, y un truco de memoria si existe.
3. Un texto de 150 a 200 palabras sobre [CONTEXTO_TEXTO] que contenga 10 errores de esas reglas para que los estudiantes los encuentren y corrijan.
4. Clave de corrección: línea, error, corrección, regla.
5. Actividad de transferencia: el estudiante revisa su propio texto con esas reglas.

RESTRICCIONES
- Aplica la norma vigente: «solo» y los demostrativos sin tilde; según la RAE (2023), la tilde es opcional únicamente cuando quien escribe percibe riesgo de ambigüedad; «guion», «truhan», «fie» sin tilde por ser monosílabos ortográficos; meses y días con minúscula; «o» entre cifras sin tilde.
- No inventes reglas ni excepciones. Si una regla tiene matices, dilo.
- Los 10 errores del texto deben ser exactamente del tipo de [ERRORES].
- Español de Colombia.

VERIFICACIÓN
Cuenta los errores insertados y confirma que son 10, que todos aparecen en la clave y que el resto del texto no tiene errores accidentales. Reporta el conteo.
TXT,
      'seguimientos' => [
        'Crea un dictado significativo de 80 palabras con las mismas reglas, relacionado con el tema que estamos leyendo.',
        'Diseña una tarjeta de autocorrección de bolsillo con las cuatro reglas para pegar en el cuaderno.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 7.°. [ERRORES] «haber si vienes» → «a ver si vienes»; «echo» (de hacer) → «hecho»; «el dijo» → «él dijo»; «Febrero» → «febrero»; «ay mucha gente» → «hay mucha gente»; «sólo» (adverbio) → «solo». [CONTEXTO_TEXTO] Mensaje de WhatsApp de un estudiante invitando al Festival del Retorno de su municipio. [TIEMPO] 55 minutos.',
        'resultado_html' => <<<'TXT'
<p><strong>Regla 1. Homófonos: «a ver», «haber»; «hay», «ay», «ahí».</strong> «A ver» se usa cuando puedes cambiarlo por «vamos a ver» o «para ver». «Haber» es un verbo: «puede haber lluvia». «Hay» es del verbo haber («hay festival»); «ay» es una exclamación; «ahí» indica lugar. <em>Truco:</em> si puedes decir «allí», es «ahí».</p>
<p><strong>Regla 2. Tilde diacrítica en «él».</strong> «Él» lleva tilde cuando es pronombre (él dijo); «el» sin tilde es artículo (el festival).</p>
<p><strong>Regla 3. «Hecho» y «echo».</strong> «Hecho» viene de hacer (lo he hecho); «echo» viene de echar (echo agua).</p>
<p><strong>Regla 4. Minúscula en meses y adverbio «solo» sin tilde.</strong></p>
<p><strong>Texto con errores (extracto):</strong> «Parce, el sábado 13 de Junio empieza el Festival del Retorno. Ay chirimía desde las 7, haber si llegas temprano. Mi tío dijo que el ya tiene echo el sancocho para todos…»</p>
<p><strong>Clave (extracto):</strong> línea 1: «Junio» → «junio» (minúscula en meses); línea 2: «Ay» → «Hay» (verbo haber); «haber si» → «a ver si»; línea 3: «el ya» → «él ya» (pronombre); «echo» → «hecho» (participio de hacer).</p>
<p><strong>Conteo:</strong> 10 errores insertados, 10 en la clave.</p>
TXT,
      ],
      'revisar' => [
        'Las reglas siguen la Ortografía de 2010: «solo» y «este» sin tilde por defecto, «guion» sin tilde, meses en minúscula.',
        'El texto tiene exactamente los errores anunciados y ninguno accidental.',
        'Los errores provienen de tus estudiantes, no de una lista genérica.',
        'Se cierra con revisión del propio texto, no solo con el ejercicio.',
      ],
    ],

    [
      'id' => 'LEN-21',
      'categoria' => 'recursos',
      'titulo' => 'Análisis de medios y desinformación: noticias falsas, cadenas de WhatsApp y titulares',
      'grados' => '5.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando circula en la comunidad una cadena, audio o publicación dudosa, o quieres trabajar el factor «Medios de comunicación y otros sistemas simbólicos» con un caso real y cercano.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[PIEZA]' => 'Texto de la cadena, publicación o titular (sin datos de quien la envió)',
        '[FUENTES_CONTRASTE]' => 'Fuentes que tú verificaste para contrastar (comunicado oficial, medio regional, verificador de datos)',
        '[TIEMPO]' => 'Duración',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de Lengua Castellana con formación en alfabetización mediática e informacional, trabajando en un colegio colombiano.

CONTEXTO
Grado: [GRADO]. Tiempo: [TIEMPO].
Pieza a analizar: [PIEZA]
Fuentes de contraste verificadas por el docente: [FUENTES_CONTRASTE]

TAREA
Diseña una actividad en la que los estudiantes analicen la pieza como texto (quién habla, a quién, con qué intención, con qué recursos) y la contrasten con las fuentes.

FORMATO DE SALIDA
1. Preguntas de análisis organizadas en: emisor y fuente; propósito e intención; recursos del lenguaje (mayúsculas, urgencia, apelación al miedo, autoridad falsa); contraste con otras fuentes; consecuencias de compartirla.
2. Lista de señales de alerta, redactadas para la edad, ilustradas SOLO con elementos que aparecen en la pieza.
3. Producto final: un mensaje corto y respetuoso para responder en el grupo de WhatsApp donde circuló, con la información verificada.
4. Criterios de valoración (4).

RESTRICCIONES
- No afirmes que la pieza es falsa o verdadera por tu cuenta: la conclusión debe salir del contraste con [FUENTES_CONTRASTE].
- No agregues fuentes, verificadores ni datos que no te di.
- No ridiculices a quienes comparten cadenas; muchas veces son familiares de los estudiantes.
- Español de Colombia.

VERIFICACIÓN
Revisa que cada señal de alerta esté ilustrada con una frase literal de la pieza y que ninguna afirmación sobre la veracidad dependa de información externa no entregada.
TXT,
      'seguimientos' => [
        'Diseña una variante para 5.° con una pieza más sencilla: publicidad engañosa de un producto en redes.',
        'Propón cómo convertir el análisis en una cápsula de 2 minutos para la emisora escolar.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 8.°, Barranquilla. [PIEZA] Cadena: «URGENTE!!! La Secretaría de Educación anunció que desde el lunes las clases serán virtuales por la ola de calor. Compártelo antes de que lo borren». [FUENTES_CONTRASTE] Comunicado del colegio del mismo día; publicación oficial de la Secretaría que no menciona clases virtuales. [TIEMPO] 55 minutos.',
        'resultado_html' => <<<'TXT'
<p><strong>Preguntas de análisis (extracto):</strong></p>
<ul>
<li><em>Emisor:</em> ¿Quién escribió el mensaje? ¿Dice el nombre de algún funcionario o enlace al anuncio?</li>
<li><em>Recursos:</em> ¿Qué efecto buscan las mayúsculas y los tres signos de exclamación en «URGENTE!!!»? ¿Por qué dirá «antes de que lo borren»?</li>
<li><em>Contraste:</em> ¿Qué dice la publicación oficial de la Secretaría sobre la jornada? ¿Qué dice el comunicado del colegio?</li>
<li><em>Consecuencias:</em> ¿Qué pasaría si las familias creen el mensaje y no envían a los niños el lunes?</li>
</ul>
<p><strong>Señales de alerta:</strong> urgencia exagerada («URGENTE!!!»); presión para compartir («Compártelo antes de que lo borren»); autoridad nombrada sin fuente («La Secretaría de Educación anunció»), sin enlace ni fecha.</p>
<p><strong>Mensaje de respuesta modelo:</strong> «Buenas tardes. Revisamos la página de la Secretaría y el comunicado del colegio, y ninguno dice que las clases pasen a ser virtuales. Mañana hay clase normal. Les dejo el enlace oficial para que lo vean».</p>
<p><strong>Conclusión:</strong> según las dos fuentes de contraste, el anuncio no tiene respaldo oficial.</p>
TXT,
      ],
      'revisar' => [
        'La conclusión sobre la veracidad se apoya solo en las fuentes que verificaste.',
        'Las señales de alerta citan frases que realmente están en la pieza.',
        'No hay datos de quién envió la cadena ni burlas a los familiares.',
        'El producto final sirve en la vida real del estudiante.',
      ],
    ],

    [
      'id' => 'LEN-22',
      'categoria' => 'recursos',
      'titulo' => 'Lírica popular como texto: décima, copla y canción (vallenato, cumbia, bullerengue)',
      'grados' => '5.° a 11.°',
      'tiempo_ahorrado' => '≈ 50 min',
      'cuando' => 'Cuando quieres trabajar el género lírico, la métrica, las figuras literarias o la tradición oral con textos que los estudiantes conocen y cantan, entregando tú el fragmento.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[FRAGMENTO]' => 'Fragmento de la canción, décima o copla (máximo una estrofa o dos de una canción protegida por derechos de autor)',
        '[DATOS_OBRA]' => 'Autor o compositor, intérprete, año aproximado y región, verificados por ti',
        '[FOCO]' => 'Qué trabajar: métrica y rima, figuras literarias, voz lírica, contexto, relación con la tradición oral',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de literatura con conocimiento de la tradición oral y musical colombiana (décima, copla, vallenato, cumbia, bullerengue, música de marimba del Pacífico, carranga, joropo).

CONTEXTO
Grado: [GRADO]. Foco: [FOCO].
Fragmento entregado por el docente (único texto que puedes citar): [FRAGMENTO]
Datos de la obra verificados por el docente: [DATOS_OBRA]

TAREA
Diseña una actividad de análisis del fragmento como texto lírico y una producción creativa de los estudiantes.

FORMATO DE SALIDA
1. Análisis guiado: preguntas sobre la voz lírica, el tema, las imágenes y figuras (indicando el verso donde aparecen) y la relación con el contexto de la región.
2. Si el foco es métrica: conteo silábico de dos versos, mostrando sinalefas y la regla del acento final (aguda +1, llana igual, esdrújula −1).
3. Producción: consigna para que los estudiantes escriban una copla o décima propia sobre un tema de su entorno, con la estructura explicada.
4. Criterios de valoración (4).

RESTRICCIONES
- No completes, continúes ni cites versos de la canción que no estén en [FRAGMENTO]. No reproduzcas letras completas.
- No agregues datos biográficos, fechas ni anécdotas que no estén en [DATOS_OBRA].
- La décima espinela tiene diez versos octosílabos con rima consonante abbaaccddc; la copla tradicional suele tener cuatro versos octosílabos con rima en los pares. Si el fragmento no cumple el esquema, señálalo sin forzarlo.
- Español de Colombia.

VERIFICACIÓN
Recuenta las sílabas métricas de los versos analizados y confirma las sinalefas. Lista los versos citados y comprueba que todos están en el fragmento.
TXT,
      'seguimientos' => [
        'Prepara una comparación entre este fragmento y un poema de autor que yo te entrego, sobre el mismo tema.',
        'Diseña la dinámica de un «duelo de coplas» respetuoso en clase, con normas y criterios.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 6.°, Riohacha. [FRAGMENTO] Dos coplas tradicionales que los estudiantes recogieron con sus familias. [DATOS_OBRA] Tradición oral, sin autor conocido, recogidas en Riohacha y Fonseca. [FOCO] Métrica, rima y relación con la tradición oral.',
        'resultado_html' => <<<'TXT'
<p><strong>Análisis guiado:</strong> ¿Quién habla en la copla 1 y a quién se dirige? ¿Qué palabra del verso 3 te muestra que la copla nació para cantarse en una reunión? ¿Por qué creen que nadie sabe quién la inventó?</p>
<p><strong>Conteo silábico (ejemplo con un verso de práctica, no del fragmento):</strong> «Caminando por la orilla» tiene 9 sílabas gramaticales (ca-mi-nan-do-por-la-o-ri-lla); con la sinalefa «la‿o» quedan 8 (ca-mi-nan-do-por-lao-ri-lla). La palabra final es llana (o-ri-lla), así que no se suma ni se resta: es un octosílabo.</p>
<p><strong>Producción:</strong> escribe una copla de cuatro versos de ocho sílabas sobre algo de tu barrio (el viento, la playa, el mercado). Haz que rimen el segundo y el cuarto verso. Léela en voz alta marcando el ritmo con las palmas.</p>
<p><strong>Criterios:</strong> mi copla tiene cuatro versos; cuento ocho sílabas en al menos tres versos; riman el segundo y el cuarto; habla de algo de mi entorno.</p>
<p><em>Nota del editor: la IA ofreció «completar la copla con la versión más conocida»; se eliminó, porque las versiones de la tradición oral varían y la de las familias es la válida para la clase.</em></p>
TXT,
      ],
      'revisar' => [
        'La IA no completó ni citó versos que no entregaste.',
        'Los datos del compositor o de la tradición son los que tú verificaste.',
        'El conteo silábico es correcto (revisa sinalefas y acento final).',
        'Respetas los derechos de autor: fragmentos breves con fines educativos y con crédito.',
      ],
    ],

    // ───────────────────────── RETROALIMENTACIÓN ─────────────────────────
    [
      'id' => 'LEN-23',
      'categoria' => 'retroalimentacion',
      'titulo' => 'Retroalimentación formativa a textos de estudiantes: «lo que ya logras» y «tu siguiente paso»',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min por lote de 35 textos',
      'cuando' => 'Cuando tienes un lote de borradores y quieres devolver a cada estudiante comentarios específicos que le sirvan para reescribir, no solo una nota. La IA hace el primer borrador de comentario; tú lo revisas y firmas.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[CONSIGNA]' => 'Consigna que recibieron los estudiantes',
        '[CRITERIOS]' => 'Rúbrica o criterios de evaluación (pega LEN-10 o la tuya)',
        '[TEXTOS]' => 'Textos anonimizados: «Estudiante A: …», «Estudiante B: …» (máximo 5 por consulta)',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de Lengua Castellana experto en evaluación formativa, que escribe retroalimentación específica, amable y accionable para estudiantes colombianos.

CONTEXTO
Grado: [GRADO]. Consigna: [CONSIGNA].
Criterios de evaluación: [CRITERIOS]
Textos anonimizados: [TEXTOS]

TAREA
Para cada texto, escribe una retroalimentación dirigida al estudiante.

FORMATO DE SALIDA
Para cada estudiante:
- «Lo que ya logras»: dos fortalezas concretas, cada una con una cita breve de su propio texto entre comillas.
- «Tu siguiente paso»: UNA sola prioridad de mejora (la más importante según los criterios), con una explicación de máximo dos oraciones, un ejemplo de cómo se vería mejorada una oración de su texto y una pregunta que lo haga pensar.
- Nivel provisional por criterio (Superior, Alto, Básico, Bajo), solo para el docente.

RESTRICCIONES
- Dirígete al estudiante con «tú», en tono respetuoso y cercano, sin sarcasmo ni exceso de elogios.
- Prohibidos los comentarios genéricos («buen trabajo», «mejora la redacción», «sigue así»).
- Las citas deben ser textuales del escrito del estudiante. No reescribas su texto completo.
- Si un texto parece no responder la consigna o sugiere una situación de riesgo para el estudiante, no lo comentes: escribe «Revisión personal del docente».
- Español de Colombia, adecuado a la edad.

VERIFICACIÓN
Comprueba que cada cita existe en el texto correspondiente, que cada estudiante tiene una sola prioridad y que ninguna retroalimentación podría copiarse a otro estudiante sin cambios.
TXT,
      'seguimientos' => [
        'Agrupa a los cinco estudiantes según su «siguiente paso» y propón una minilección de 10 minutos para cada grupo.',
        'Reescribe la retroalimentación del Estudiante C en un lenguaje más sencillo, porque tiene dificultades de comprensión lectora.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 9.°. [CONSIGNA] Carta de opinión al periódico regional sobre la restricción del parrillero en moto (ver LEN-02). [CRITERIOS] Rúbrica de texto argumentativo del banco. [TEXTOS] Cinco borradores; se muestra el del Estudiante B.',
        'resultado_html' => <<<'TXT'
<p><strong>Estudiante B</strong></p>
<p><strong>Lo que ya logras:</strong></p>
<ul>
<li>Tu postura es clara desde el inicio: «Yo no estoy de acuerdo con la medida porque afecta a los que trabajan en moto». Cualquier lector sabe qué piensas desde la primera línea.</li>
<li>Usas un ejemplo cercano y concreto: «mi papá hace carreras desde las cinco de la mañana para pagar el arriendo». Eso le da fuerza humana a tu argumento.</li>
</ul>
<p><strong>Tu siguiente paso:</strong> tu carta solo muestra un lado. Quienes apoyan la medida dicen que busca reducir los robos, y si no respondes a esa idea, el lector puede pensar que no la conoces. Por ejemplo, después de tu segundo párrafo podrías escribir: «Es cierto que los robos en moto preocupan a todos; sin embargo, prohibir el parrillero castiga a miles de trabajadores honestos por lo que hacen unos pocos». <em>Pregunta para pensar:</em> ¿qué otra medida podría reducir los robos sin quitarles el trabajo a los mototaxistas?</p>
<p><em>Solo para el docente:</em> Propósito: Alto. Tesis y argumentos: Alto. Contraargumento: Bajo. Coherencia: Básico. Convenciones: Básico.</p>
TXT,
      ],
      'revisar' => [
        'Las citas existen en el texto de cada estudiante.',
        'Cada estudiante tiene una sola prioridad, la más importante.',
        'No hay elogios vacíos ni comentarios que sirvan para cualquiera.',
        'Pegaste los textos sin nombres, documentos ni datos personales.',
        'Tú firmas la retroalimentación: ajústala con lo que sabes del estudiante y que la IA no conoce.',
      ],
    ],

    [
      'id' => 'LEN-24',
      'categoria' => 'retroalimentacion',
      'titulo' => 'Retroalimentación a toda la clase a partir de errores frecuentes',
      'grados' => '4.° a 11.°',
      'tiempo_ahorrado' => '≈ 45 min',
      'cuando' => 'Después de revisar una evaluación o un lote de textos, para devolver al grupo lo que salió bien y los tres problemas más frecuentes, con ejemplos anónimos y una práctica breve.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[TAREA]' => 'Qué hicieron (prueba, texto, exposición) y con qué criterios',
        '[HALLAZGOS]' => 'Tus notas de revisión: fortalezas, errores frecuentes y ejemplos reales anonimizados',
        '[TIEMPO]' => 'Tiempo de clase para la retroalimentación',
      ],
      'prompt' => <<<'TXT'
Actúa como docente experto en evaluación formativa en Lengua Castellana, en un colegio colombiano.

CONTEXTO
Grado: [GRADO]. Tarea evaluada: [TAREA]. Tiempo disponible: [TIEMPO].
Hallazgos del docente (con ejemplos reales anonimizados): [HALLAZGOS]

TAREA
Prepara una sesión de retroalimentación grupal.

FORMATO DE SALIDA
1. Apertura: dos fortalezas del grupo con un ejemplo real cada una (de los hallazgos).
2. Tres problemas frecuentes, ordenados por impacto en el aprendizaje. Para cada uno: nombre sencillo, ejemplo anónimo tomado de los hallazgos, por qué es un problema para el lector y una estrategia concreta para resolverlo.
3. Práctica de 10 minutos: un ejercicio breve por problema usando oraciones de los propios textos (anónimas).
4. Cierre: una pregunta de autoevaluación para que cada estudiante identifique cuál de los tres problemas es el suyo.
5. Texto para proyectar o escribir en el tablero (máximo 10 líneas).

RESTRICCIONES
- Usa solo los ejemplos de [HALLAZGOS]; no inventes errores ni ejemplos.
- Ningún ejemplo debe permitir identificar al autor.
- Tono constructivo; el error es material de aprendizaje.
- Ajusta todo al tiempo disponible. Español de Colombia.

VERIFICACIÓN
Comprueba que los tres problemas aparecen en los hallazgos, que los tiempos suman [TIEMPO] y que ningún ejemplo es identificable (sin nombres, apodos ni detalles personales).
TXT,
      'seguimientos' => [
        'Diseña una tarea de reescritura en la que cada estudiante corrija su texto solo en el problema que eligió en la autoevaluación.',
        'Escribe un mensaje para la plataforma del colegio que resuma la retroalimentación para quienes faltaron.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 10.°. [TAREA] Columna de opinión sobre el celular en los descansos, valorada con la rúbrica de texto argumentativo. [HALLAZGOS] Fortalezas: tesis claras; buenos ejemplos de la vida escolar. Problemas: argumentos que son solo opiniones («porque sí es malo»); conectores mal usados («sin embargo» para sumar ideas); conclusiones que repiten la introducción. [TIEMPO] 50 minutos.',
        'resultado_html' => <<<'TXT'
<p><strong>Lo que hicieron bien:</strong> casi todos dejaron clara su postura en el primer párrafo, como en «El celular en el descanso nos aísla aunque estemos juntos». Además, usaron ejemplos reales del colegio, como la fila de la tienda escolar en la que nadie habla.</p>
<p><strong>Problema 1: el argumento que no argumenta.</strong> Ejemplo: «El celular es malo porque sí es malo». El lector no recibe ninguna razón nueva; solo se repite la idea. <em>Estrategia:</em> después de cada opinión, pregúntate «¿por qué?» y «¿cómo lo sé?», y escribe la respuesta.</p>
<p><strong>Problema 2: el conector que dice lo contrario.</strong> Ejemplo: «Los estudiantes se distraen; sin embargo, también dejan de jugar». «Sin embargo» anuncia una idea opuesta, pero aquí se suma otra desventaja. <em>Estrategia:</em> antes de usar un conector, di qué relación quieres mostrar: suma (además), contraste (sin embargo), causa (porque), consecuencia (por eso).</p>
<p><strong>Problema 3: la conclusión eco.</strong> Muchas conclusiones copian la introducción con otras palabras. <em>Estrategia:</em> la conclusión responde «¿y ahora qué?»: una propuesta, una advertencia o una pregunta.</p>
<p><strong>Tiempos:</strong> fortalezas 5 min; problemas 20 min; práctica 15 min; autoevaluación 10 min. Total: 50.</p>
TXT,
      ],
      'revisar' => [
        'Los tres problemas y sus ejemplos salen de tus hallazgos, no de la imaginación de la IA.',
        'Ningún ejemplo identifica a un estudiante (ni por el tema personal que escribió).',
        'Hay práctica, no solo explicación.',
        'Cada estudiante sale sabiendo qué corregir en su propio texto.',
      ],
    ],

    // ───────────────────────── GESTIÓN ─────────────────────────
    [
      'id' => 'LEN-25',
      'categoria' => 'gestion',
      'titulo' => 'Comunicación a familias para acompañar la lectura en casa',
      'grados' => 'Transición a 9.°',
      'tiempo_ahorrado' => '≈ 25 min',
      'cuando' => 'Al iniciar un proyecto de lectura, al enviar la maleta viajera o cuando necesitas que las familias apoyen sin convertirse en «profesores de tareas», incluyendo a quienes tienen poca escolaridad.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[PROPOSITO]' => 'Qué necesitas de las familias',
        '[CANAL]' => 'WhatsApp, circular impresa, reunión, audio',
        '[CONTEXTO_FAMILIAS]' => 'Rasgos generales: horarios de trabajo, escolaridad, acceso a internet, lenguas',
      ],
      'prompt' => <<<'TXT'
Actúa como docente con experiencia en trabajo con familias en comunidades colombianas diversas (urbanas, rurales, afrocolombianas, indígenas, migrantes).

CONTEXTO
Grado: [GRADO]. Propósito: [PROPOSITO]. Canal: [CANAL]. Familias: [CONTEXTO_FAMILIAS].

TAREA
Redacta el mensaje para las familias y una versión alternativa para quienes leen con dificultad.

FORMATO DE SALIDA
1. Mensaje principal (máximo 150 palabras): saludo, qué estamos haciendo y por qué importa, qué les pedimos (máximo 3 acciones concretas que tomen menos de 15 minutos), cómo pueden comunicarse con el docente, despedida.
2. Versión para audio de WhatsApp (guion de máximo 60 segundos), pensada para familias que prefieren escuchar.
3. Tres ideas de acompañamiento que no exijan saber leer: contar historias de la familia, preguntar por el cuento, escuchar al niño leer.

RESTRICCIONES
- Tono cálido y respetuoso, sin culpar a las familias ni dar por sentado que tienen tiempo, libros o internet.
- Sin tecnicismos («competencias», «DBA», «procesos lectoescriturales»).
- No pidas compras ni gastos.
- Español de Colombia, con «ustedes».

VERIFICACIÓN
Lee el mensaje como si fueras una madre que trabaja todo el día y tiene tercero de primaria: ¿entiendes qué hacer, cuándo y para qué? Si algo no queda claro, corrígelo. Cuenta las palabras.
TXT,
      'seguimientos' => [
        'Adapta el mensaje para familias venezolanas recién llegadas, incluyendo cómo acceder a la biblioteca pública del municipio.',
        'Redacta un mensaje de agradecimiento al final del proyecto, con un ejemplo de lo que lograron los niños.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 2.°, Quibdó. [PROPOSITO] Que las familias escuchen al niño leer 10 minutos tres veces por semana el libro de la maleta viajera. [CANAL] WhatsApp. [CONTEXTO_FAMILIAS] Muchos padres trabajan en el comercio hasta la noche; varios abuelos cuidan a los niños; conexión limitada.',
        'resultado_html' => <<<'TXT'
<p><strong>Mensaje:</strong></p>
<p>Buenas tardes, queridas familias de segundo. Esta semana empezamos la «Maleta viajera»: cada niño llevará a casa un libro de la biblioteca del salón durante tres días.</p>
<p>Leer en voz alta a alguien que lo quiere es una de las mejores formas de aprender a leer. Por eso les pedimos tres cosas sencillas:</p>
<p>1. Escuchar al niño leer 10 minutos, tres días esta semana. Puede ser mientras cocinan o antes de dormir.<br>2. Preguntarle: «¿Qué fue lo que más te gustó?».<br>3. Devolver el libro en la maleta el jueves.</p>
<p>Si no saben leer o no tienen tiempo, un abuelo, un tío o un hermano mayor también puede acompañar. Lo importante es que alguien lo escuche.</p>
<p>Cualquier duda, me escriben por aquí. Gracias por acompañar a sus hijos.</p>
<p><strong>Audio (guion):</strong> «Hola, familias de segundo, les habla la profe. Esta semana su hijo lleva un libro a la casa. Solo les pido que lo escuchen leer diez minuticos, tres días, y que le pregunten qué le gustó. El jueves devuelven el libro en la maleta. ¡Gracias!».</p>
<p><em>Conteo: 128 palabras.</em></p>
TXT,
      ],
      'revisar' => [
        'No hay tecnicismos ni tono de regaño.',
        'Las acciones son pocas, concretas y posibles sin dinero ni internet.',
        'El mensaje no expone a ningún niño ni compara resultados.',
        'Revisa que el diminutivo o los regionalismos suenen naturales en tu región.',
      ],
    ],

    [
      'id' => 'LEN-26',
      'categoria' => 'gestion',
      'titulo' => 'Informe de periodo con desempeños (Decreto 1290) y observaciones de boletín',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 2 h por curso',
      'cuando' => 'Al cierre del periodo, cuando debes redactar los desempeños del área por nivel y las observaciones individuales del boletín sin repetir la misma frase para 40 estudiantes.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[APRENDIZAJES]' => 'Aprendizajes o desempeños evaluados en el periodo (de tu planeación)',
        '[FORMATO_SIEE]' => 'Cómo pide tu SIEE los desempeños: fortalezas, debilidades, recomendaciones, número de caracteres',
        '[DATOS_ESTUDIANTES]' => 'Para observaciones individuales: «Estudiante A: nivel por aprendizaje + una nota tuya» (sin nombres)',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de Lengua Castellana con experiencia en la redacción de informes académicos según el Decreto 1290 de 2009 (escala Superior, Alto, Básico, Bajo) y el Sistema Institucional de Evaluación de cada colegio.

CONTEXTO
Grado: [GRADO]. Formato exigido por el SIEE: [FORMATO_SIEE].
Aprendizajes evaluados en el periodo: [APRENDIZAJES]
Datos anonimizados para observaciones individuales: [DATOS_ESTUDIANTES]

TAREA
Parte 1. Redacta los descriptores de desempeño del área para cada nivel (Superior, Alto, Básico, Bajo) a partir de los aprendizajes del periodo.
Parte 2. Redacta una observación individual para cada estudiante.

FORMATO DE SALIDA
Parte 1: tabla Nivel | Descriptor (empieza con un verbo en tercera persona, describe lo que el estudiante hace, no lo que «es»).
Parte 2: «Estudiante A: [observación]». Cada observación incluye un logro concreto, un aspecto por fortalecer y una recomendación práctica para el estudiante y la familia.

RESTRICCIONES
- Respeta el límite de caracteres de [FORMATO_SIEE].
- Lenguaje claro para las familias, sin tecnicismos ni juicios sobre la personalidad («es perezoso», «no le interesa»).
- Las observaciones solo usan lo que te di de cada estudiante; no inventes logros ni dificultades.
- El nivel Bajo describe lo que aún no logra y qué necesita, sin tono de castigo.
- Español de Colombia.

VERIFICACIÓN
Cuenta los caracteres de cada observación, confirma que ninguna se repite literalmente y que cada una corresponde al nivel que te di. Reporta cualquier caso fuera del límite.
TXT,
      'seguimientos' => [
        'Genera una versión más breve (máximo 250 caracteres) de cada observación para la plataforma.',
        'Para los estudiantes en nivel Bajo, redacta el compromiso que firmarán con la familia en la entrega de boletines.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 11.°. [APRENDIZAJES] (1) Interpreta textos continuos y discontinuos con actitud crítica; (2) produce un ensayo argumentativo con uso de fuentes; (3) participa en debates con argumentos y respeto. [FORMATO_SIEE] Descriptores por nivel; observaciones de máximo 400 caracteres. [DATOS_ESTUDIANTES] Estudiante A: Superior en 1, Alto en 2, Básico en 3; «muy buena lectora, le cuesta intervenir en público».',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Nivel</th><th>Descriptor del periodo</th></tr>
<tr><td>Superior</td><td>Interpreta textos continuos y discontinuos, relaciona sus partes y evalúa sus ideas con argumentos propios; escribe ensayos con tesis clara, fuentes citadas y contraargumentos; en los debates sustenta su postura y retoma las ideas de otros.</td></tr>
<tr><td>Alto</td><td>Interpreta el sentido global de los textos y propone valoraciones con apoyo parcial en el texto; su ensayo presenta tesis y argumentos con fuentes, aunque el contraargumento es débil; participa en debates con argumentos pertinentes.</td></tr>
<tr><td>Básico</td><td>Identifica información explícita y algunas relaciones entre las partes del texto; escribe un ensayo con postura identificable, pero sus argumentos se apoyan sobre todo en opiniones; participa en debates cuando se le pide.</td></tr>
<tr><td>Bajo</td><td>Aún necesita apoyo para identificar la idea global de los textos y para sostener una postura por escrito con razones; requiere acompañamiento para preparar su participación oral.</td></tr>
</table>
<p><strong>Estudiante A:</strong> Se destaca en la lectura crítica: interpreta tablas y columnas de opinión y evalúa sus argumentos con precisión. Su ensayo tiene una tesis clara y buenas fuentes. Le recomendamos preparar por escrito dos ideas antes de cada debate y participar al menos una vez por sesión; en casa puede practicar exponiendo su opinión sobre una noticia. <em>(337 caracteres)</em></p>
TXT,
      ],
      'revisar' => [
        'Los descriptores corresponden a los aprendizajes que de verdad evaluaste.',
        'Ninguna observación juzga la personalidad ni incluye información que no diste.',
        'Respeta el límite de caracteres de la plataforma (verifícalo; la IA cuenta mal).',
        'Las observaciones no se repiten literalmente entre estudiantes.',
      ],
    ],

    [
      'id' => 'LEN-27',
      'categoria' => 'gestion',
      'titulo' => 'Plan de mejoramiento o nivelación con actividades y evidencias verificables',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando un estudiante o un grupo termina el periodo en desempeño Bajo y necesitas un plan de apoyo coherente con tu SIEE que mida aprendizaje real y no solo «entregar un trabajo».',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[APRENDIZAJES_PENDIENTES]' => 'Aprendizajes no alcanzados, en términos concretos',
        '[EVIDENCIAS_PREVIAS]' => 'Qué mostraron sus trabajos (sin datos personales)',
        '[TIEMPO_PLAN]' => 'Duración y momentos de encuentro según el SIEE',
      ],
      'prompt' => <<<'TXT'
Actúa como coordinador académico con experiencia en planes de apoyo y nivelación en Lengua Castellana, en el marco del Decreto 1290 de 2009 y del SIEE institucional.

CONTEXTO
Grado: [GRADO]. Tiempo del plan: [TIEMPO_PLAN].
Aprendizajes pendientes: [APRENDIZAJES_PENDIENTES]
Lo que mostraron sus evidencias: [EVIDENCIAS_PREVIAS]

TAREA
Diseña un plan de mejoramiento que permita al estudiante alcanzar los aprendizajes pendientes y demostrarlo.

FORMATO DE SALIDA
1. Aprendizajes pendientes reformulados como metas comprensibles para el estudiante («Al terminar este plan podré…»).
2. Tabla: Semana | Actividad de aprendizaje (con apoyo) | Producto | Cómo se valora.
3. Evidencia final que demuestre el aprendizaje en una situación nueva (no la repetición del mismo taller).
4. Rol del estudiante, del docente y de la familia.
5. Criterio para considerar superado el desempeño, coherente con el nivel Básico.

RESTRICCIONES
- Nada de «copiar el cuaderno», «hacer un resumen de internet» o «exposición de cualquier tema» como evidencia.
- Las actividades deben ser posibles sin internet en casa.
- Incluye al menos una evidencia oral o hecha en clase para asegurar autoría.
- Español de Colombia.

VERIFICACIÓN
Revisa que cada aprendizaje pendiente tenga actividad, producto y criterio. Si uno no lo tiene, complétalo antes de entregar.
TXT,
      'seguimientos' => [
        'Redacta el acta de compromiso del plan para firmar con el estudiante y la familia, en media página.',
        'Prepara la evaluación final en una versión escrita y una oral equivalentes.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 8.°. [APRENDIZAJES_PENDIENTES] (1) Hacer inferencias sobre la intención de los personajes en textos narrativos; (2) escribir un párrafo argumentativo con tesis y dos razones. [EVIDENCIAS_PREVIAS] Responde bien preguntas literales; en las inferenciales copia frases del texto; sus párrafos de opinión no tienen razones. [TIEMPO_PLAN] 3 semanas, dos encuentros de 30 minutos por semana.',
        'resultado_html' => <<<'TXT'
<p><strong>Metas:</strong> Al terminar este plan podré explicar por qué un personaje actúa como actúa, usando pistas del texto. Podré escribir un párrafo en el que digo qué pienso y doy dos razones.</p>
<table>
<tr><th>Sem.</th><th>Actividad</th><th>Producto</th><th>Valoración</th></tr>
<tr><td>1</td><td>Lectura guiada de un cuento breve con la docente: «pista + lo que sé = lo que infiero»</td><td>Tabla de tres inferencias con su pista</td><td>Cada inferencia tiene una pista del texto</td></tr>
<tr><td>2</td><td>Mismo método con otro cuento, de forma autónoma; luego, del párrafo «opino porque…» a «opino; primero…, además…»</td><td>Tabla de inferencias + párrafo con dos razones</td><td>Revisión con lista de chequeo de 4 ítems</td></tr>
<tr><td>3</td><td>Evidencia final en clase: cuento nuevo y párrafo de opinión sobre una decisión del personaje</td><td>Respuestas y párrafo escritos en clase</td><td>Criterio de superación</td></tr>
</table>
<p><strong>Criterio de superación:</strong> formula al menos dos de tres inferencias con una pista textual pertinente y escribe un párrafo con postura clara y dos razones relacionadas con ella.</p>
<p><strong>Familia:</strong> preguntar dos veces por semana «¿por qué crees que el personaje hizo eso?» sobre una novela, una serie o una noticia.</p>
TXT,
      ],
      'revisar' => [
        'La evidencia final es nueva y hecha en clase, no un taller repetido o un trabajo copiable.',
        'El criterio de superación corresponde al nivel Básico, no al Superior.',
        'Los tiempos coinciden con lo que tu SIEE establece para planes de apoyo.',
        'No hay datos personales del estudiante en lo que pegaste.',
      ],
    ],

    [
      'id' => 'LEN-28',
      'categoria' => 'gestion',
      'titulo' => 'Criterios de uso de IA en tareas de escritura: proceso visible y autoría',
      'grados' => '6.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Al inicio del año o de una unidad de escritura, para acordar con el grupo cuándo pueden usar IA, cómo declararlo y cómo se evidencia el proceso, en lugar de intentar «detectar» textos generados.',
      'variables' => [
        '[GRADO]' => 'Grado',
        '[TAREA]' => 'Tarea de escritura de la unidad',
        '[POLITICA_INSTITUCIONAL]' => 'Lo que dice el manual de convivencia o el SIEE sobre IA y plagio (si no hay, escribe «no existe»)',
        '[ACCESO]' => 'Acceso real de los estudiantes a la IA y a computadores',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de Lengua Castellana con experiencia en integridad académica y en el uso pedagógico de la inteligencia artificial en colegios colombianos.

CONTEXTO
Grado: [GRADO]. Tarea: [TAREA]. Acceso a tecnología: [ACCESO].
Política institucional: [POLITICA_INSTITUCIONAL]

TAREA
Propón criterios de uso de IA para esta tarea y un sistema de evidencias del proceso de escritura.

FORMATO DE SALIDA
1. Semáforo de usos: verde (permitido sin declarar), amarillo (permitido declarándolo), rojo (no permitido), con 3 ejemplos concretos en cada color para esta tarea.
2. Formato de declaración de uso de IA (qué herramienta, para qué, qué pedí, qué cambié) en máximo 5 líneas.
3. Evidencias del proceso: qué partes se hacen en clase y a mano, qué borradores se guardan y qué conversación oral confirma la autoría.
4. Qué hacer si se sospecha un uso no permitido: pasos pedagógicos, coherentes con el debido proceso del manual de convivencia.
5. Versión para estudiantes, en lenguaje directo, de máximo una página.

RESTRICCIONES
- No recomiendes detectores de texto generado por IA como prueba: sus resultados no son confiables y pueden acusar injustamente, sobre todo a quienes escriben en una segunda lengua o con estilo sencillo.
- Si [ACCESO] es limitado, ningún uso verde puede depender de tener IA en casa.
- No contradigas la política institucional; si no existe, sugiere llevar la propuesta al consejo académico.
- Español de Colombia.

VERIFICACIÓN
Revisa que cada uso en rojo tenga una razón pedagógica explicada y que el sistema de evidencias permita valorar el aprendizaje aunque el estudiante haya usado IA de forma permitida.
TXT,
      'seguimientos' => [
        'Diseña la conversación de cinco minutos («defensa del texto») con preguntas que solo puede responder quien escribió el texto.',
        'Crea una actividad en la que los estudiantes comparen un texto generado por IA con uno propio y evalúen ambos con la rúbrica.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 11.°. [TAREA] Ensayo argumentativo sobre la responsabilidad de las redes sociales en la salud mental juvenil. [POLITICA_INSTITUCIONAL] El manual sanciona el plagio pero no menciona la IA. [ACCESO] La mayoría tiene celular con datos limitados; sala de sistemas dos horas por semana.',
        'resultado_html' => <<<'TXT'
<p><strong>Verde (sin declarar):</strong> buscar el significado de una palabra; revisar la ortografía de tu versión final; pedir sinónimos para no repetir «además».</p>
<p><strong>Amarillo (declarándolo):</strong> pedir a la IA contraargumentos a tu tesis para responderlos; pedir que te haga preguntas sobre tu borrador; pedir ejemplos de cómo se cita una fuente.</p>
<p><strong>Rojo:</strong> pedir que escriba el ensayo o un párrafo completo (no se evalúa tu argumentación); pedir fuentes o datos sin verificarlos (la IA inventa referencias); parafrasear con IA un texto de otro autor para ocultar el origen (es plagio).</p>
<p><strong>Evidencias del proceso:</strong> la tesis y el plan se escriben a mano en clase; el primer borrador se escribe en la sala de sistemas o en el cuaderno; se entregan borrador, versión final y declaración; cada estudiante tiene una conversación de cinco minutos sobre su texto.</p>
<p><strong>Si hay sospecha:</strong> no se acusa a partir de un detector. Se conversa con el estudiante sobre su proceso, se revisan sus borradores y, si no puede explicar su texto, se le pide reescribir una sección en clase. Si se confirma una falta, se sigue el debido proceso del manual.</p>
<p><strong>Política:</strong> como el manual no menciona la IA, se sugiere llevar estos criterios al consejo académico para incluirlos en el SIEE.</p>
TXT,
      ],
      'revisar' => [
        'No se usa ningún «detector de IA» como prueba.',
        'Los usos permitidos no dependen de tener IA en casa si el acceso es limitado.',
        'Las evidencias del proceso son realistas para tu número de estudiantes.',
        'Los criterios son coherentes con el manual de convivencia y el debido proceso.',
      ],
    ],
  ],

  'cadenas' => [
    [
      'titulo' => 'Unidad completa de texto argumentativo (8.° a 11.°)',
      'objetivo' => 'Llevar al grupo desde la lectura de modelos hasta un texto argumentativo publicado, con proceso visible, retroalimentación útil y plan de apoyo para quien no alcance el nivel Básico. Duración aproximada: 4 a 5 semanas.',
      'pasos' => [
        ['paso' => 'Acordar con el grupo los criterios de uso de IA y las evidencias del proceso antes de empezar.', 'receta' => 'LEN-28', 'nota' => 'Hazlo en la primera sesión; la declaración de uso se entrega con la versión final.'],
        ['paso' => 'Diseñar la secuencia didáctica del género con modelos reales y destinatario auténtico.', 'receta' => 'LEN-02', 'nota' => 'Busca modelos en la prensa regional de las últimas semanas.'],
        ['paso' => 'Redactar la consigna de escritura con situación, propósito y destinatario.', 'receta' => 'LEN-19', 'nota' => 'Usa el seguimiento «escribe la consigna de la sesión 4».'],
        ['paso' => 'Construir la rúbrica y compartirla con los estudiantes desde el inicio.', 'receta' => 'LEN-10', 'nota' => 'Entrega también la versión en primera persona para autoevaluación.'],
        ['paso' => 'Preparar el debate que alimenta los argumentos antes de escribir.', 'receta' => 'LEN-06', 'nota' => 'Los relatores entregan la lista de argumentos al grupo.'],
        ['paso' => 'Retroalimentar los borradores en lotes de cinco, revisando y firmando cada comentario.', 'receta' => 'LEN-23', 'nota' => 'Una sola prioridad por estudiante.'],
        ['paso' => 'Devolver al grupo los tres problemas más frecuentes con práctica breve.', 'receta' => 'LEN-24', 'nota' => 'Usa oraciones anónimas de los propios borradores.'],
        ['paso' => 'Taller de puntuación y conectores con los errores reales del lote.', 'receta' => 'LEN-20', 'nota' => 'Antes de la versión final.'],
        ['paso' => 'Plan de apoyo para quienes queden en Bajo.', 'receta' => 'LEN-27', 'nota' => 'La evidencia final se hace en clase.'],
      ],
    ],
    [
      'titulo' => 'Preparación de Lectura Crítica de Saber 11 durante un periodo (10.° y 11.°)',
      'objetivo' => 'Fortalecer las tres competencias de Lectura Crítica con textos continuos y discontinuos del contexto de los estudiantes, sin convertir la clase en un simulacro permanente. Una sesión semanal durante 8 a 10 semanas.',
      'pasos' => [
        ['paso' => 'Seleccionar textos variados: columna de opinión, cuento colombiano breve, texto filosófico corto, infografía y tabla con datos verificados.', 'receta' => '', 'nota' => 'Arma una carpeta de 8 a 10 textos; anota fuente y fecha de cada uno.'],
        ['paso' => 'Elaborar ítems para los textos discontinuos con justificación de cada opción.', 'receta' => 'LEN-09', 'nota' => 'Recalcula tú todos los valores numéricos.'],
        ['paso' => 'Elaborar ítems para los textos continuos con distractores que revelen errores de lectura.', 'receta' => 'LEN-08', 'nota' => 'Pide a la IA que use la terminología de las tres competencias de Saber 11 en lugar de las afirmaciones de 3.°, 5.° y 9.°.'],
        ['paso' => 'Trabajar una pieza de desinformación para la competencia de reflexión y evaluación.', 'receta' => 'LEN-21', 'nota' => 'Conecta con el factor de medios de los Estándares de 10.° y 11.°.'],
        ['paso' => 'Retroalimentar al grupo con los errores más frecuentes de cada simulacro interno.', 'receta' => 'LEN-24', 'nota' => 'Analiza por competencia, no solo por puntaje.'],
        ['paso' => 'Redactar los descriptores de desempeño del periodo con base en las competencias trabajadas.', 'receta' => 'LEN-26', 'nota' => 'Evita reducir el informe a puntajes de simulacro.'],
      ],
    ],
    [
      'titulo' => 'Proyecto de lectura inclusivo en primaria (1.° a 5.°)',
      'objetivo' => 'Organizar un proyecto de lectura de un periodo que parta del diagnóstico del grupo, incluya a los estudiantes con PIAR y vincule a las familias. Duración: 8 semanas.',
      'pasos' => [
        ['paso' => 'Diagnosticar fluidez, comprensión y escritura de cada niño y armar grupos de apoyo.', 'receta' => 'LEN-12', 'nota' => 'Sin normas inventadas de palabras por minuto.'],
        ['paso' => 'Diseñar el proyecto con los libros que realmente hay en la biblioteca escolar.', 'receta' => 'LEN-03', 'nota' => 'Verifica cada título en el estante antes de planear.'],
        ['paso' => 'Preparar versiones de lectura fácil de los textos informativos del proyecto.', 'receta' => 'LEN-13', 'nota' => 'Todos participan en la misma conversación.'],
        ['paso' => 'Traducir los ajustes del PIAR a la actividad semanal.', 'receta' => 'LEN-14', 'nota' => 'Para baja visión usa LEN-16; para estudiantes sordos, LEN-15.'],
        ['paso' => 'Invitar a las familias a escuchar leer en casa.', 'receta' => 'LEN-25', 'nota' => 'Incluye la versión en audio de WhatsApp.'],
        ['paso' => 'Evaluar la presentación oral de cierre (recital, programa radial, tertulia).', 'receta' => 'LEN-11', 'nota' => 'Incluye indicadores de escucha del público.'],
      ],
    ],
    [
      'titulo' => 'Una obra colombiana en el aula: lectura, conversación y ensayo (9.° a 11.°)',
      'objetivo' => 'Leer una obra colombiana completa con guía, debatir sus problemas y escribir un ensayo literario evaluado con rúbrica, sin que la IA invente citas ni interpretaciones únicas. Duración: 5 a 6 semanas.',
      'pasos' => [
        ['paso' => 'Seleccionar la obra, transcribir los fragmentos clave y escribir tu resumen de cada parte.', 'receta' => '', 'nota' => 'Es el insumo que protege la guía de citas inventadas.'],
        ['paso' => 'Elaborar la guía de lectura por partes.', 'receta' => 'LEN-05', 'nota' => 'Revisa cada cita contra tus fragmentos.'],
        ['paso' => 'Adaptar los apoyos para estudiantes con PIAR (audio, tiempo, respuesta oral).', 'receta' => 'LEN-14', 'nota' => 'Mismo objetivo para todos.'],
        ['paso' => 'Organizar un foro sobre un problema que plantea la obra.', 'receta' => 'LEN-06', 'nota' => 'Las fuentes del foro son los fragmentos y, si quieres, una reseña de prensa que verificaste.'],
        ['paso' => 'Evaluar el ensayo con la rúbrica de ensayo literario del banco de rúbricas.', 'receta' => '', 'nota' => 'Usa la rúbrica «Ensayo literario (10.° y 11.°)» de este kit; ajústala para 9.°.'],
        ['paso' => 'Retroalimentar los borradores del ensayo.', 'receta' => 'LEN-23', 'nota' => 'Exige que la retroalimentación cite el texto del estudiante.'],
        ['paso' => 'Redactar las observaciones de boletín del periodo.', 'receta' => 'LEN-26', 'nota' => 'Respeta el límite de caracteres de tu plataforma.'],
      ],
    ],
  ],

  'rubricas' => [
    [
      'titulo' => 'Texto argumentativo escrito (8.° a 11.°)',
      'criterios' => [
        ['criterio' => 'Propósito y respuesta a la consigna', 'niveles' => [
          'Superior' => 'Responde exactamente la pregunta o situación planteada, mantiene la secuencia argumentativa en todo el texto y se dirige al destinatario indicado con el registro adecuado.',
          'Alto' => 'Responde la consigna y argumenta, aunque en algún tramo narra o describe sin relación con la tesis, o el registro no se ajusta del todo al destinatario.',
          'Básico' => 'Se relaciona con el tema de la consigna, pero alterna argumentación con narración u opinión suelta; el destinatario no se tiene en cuenta.',
          'Bajo' => 'No responde la consigna o produce otro tipo de texto (resumen, relato, lista de ideas).',
        ]],
        ['criterio' => 'Tesis y argumentos', 'niveles' => [
          'Superior' => 'Presenta una tesis discutible en el primer párrafo y al menos dos argumentos distintos, cada uno con razón y apoyo (dato con fuente, ejemplo, experiencia o autoridad pertinente).',
          'Alto' => 'Tesis clara y argumentos pertinentes; uno de ellos carece de apoyo o depende solo de la experiencia personal.',
          'Básico' => 'La postura se identifica, pero aparece tarde o es ambigua; los argumentos son afirmaciones sin apoyo o repiten la tesis.',
          'Bajo' => 'No se identifica una postura o los argumentos contradicen la tesis.',
        ]],
        ['criterio' => 'Contraargumentación y conclusión', 'niveles' => [
          'Superior' => 'Expone la postura contraria con justicia, la refuta con razones y cierra con una conclusión que retoma la tesis y propone, advierte o proyecta.',
          'Alto' => 'Reconoce la postura contraria y la responde de manera parcial; la conclusión retoma la tesis.',
          'Básico' => 'Menciona la postura contraria sin responderla, o la conclusión repite la introducción.',
          'Bajo' => 'No hay contraargumento ni conclusión identificable.',
        ]],
        ['criterio' => 'Coherencia y cohesión', 'niveles' => [
          'Superior' => 'Cada párrafo desarrolla una idea; usa conectores variados y precisos (contraste, causa, consecuencia, adición) y pronombres que evitan repeticiones sin crear ambigüedad.',
          'Alto' => 'Párrafos organizados con conectores adecuados; hay alguna repetición o un conector impreciso que no afecta la comprensión.',
          'Básico' => 'Ideas mezcladas dentro de los párrafos, conectores repetitivos («y», «entonces») o mal usados que obligan a releer.',
          'Bajo' => 'Las ideas no se relacionan entre sí; el lector no puede seguir el razonamiento.',
        ]],
        ['criterio' => 'Convenciones de la lengua escrita', 'niveles' => [
          'Superior' => 'Ortografía, puntuación y concordancia sin errores que afecten la lectura; la puntuación organiza las ideas.',
          'Alto' => 'Errores aislados de tildes o comas que no afectan la comprensión.',
          'Básico' => 'Errores frecuentes de puntuación o concordancia que dificultan la lectura de algunas oraciones.',
          'Bajo' => 'Los errores impiden comprender partes del texto.',
        ]],
      ],
    ],
    [
      'titulo' => 'Exposición oral (4.° a 9.°)',
      'criterios' => [
        ['criterio' => 'Dominio y organización del contenido', 'niveles' => [
          'Superior' => 'Presenta el tema con introducción, desarrollo en orden lógico y cierre; explica con sus palabras y responde preguntas con precisión.',
          'Alto' => 'Sigue un orden claro y explica con sus palabras; responde preguntas de forma general.',
          'Básico' => 'Presenta datos sueltos sin orden claro o depende de leer la cartelera; responde preguntas con dificultad.',
          'Bajo' => 'Lee textualmente o no logra presentar el tema; no responde preguntas.',
        ]],
        ['criterio' => 'Voz: volumen, ritmo, pausas y entonación', 'niveles' => [
          'Superior' => 'Se escucha en todo el salón; varía la entonación para destacar ideas y hace pausas entre las partes.',
          'Alto' => 'Se escucha bien y hace pausas; la entonación es poco variada.',
          'Básico' => 'Volumen bajo o ritmo muy rápido en varios momentos; pocas pausas.',
          'Bajo' => 'No se escucha o el ritmo impide seguir la exposición.',
        ]],
        ['criterio' => 'Lenguaje corporal y apoyos visuales', 'niveles' => [
          'Superior' => 'Mira al público, usa gestos que acompañan lo que dice y se apoya en el material visual señalándolo en el momento oportuno.',
          'Alto' => 'Mira al público la mayor parte del tiempo y usa el material visual.',
          'Básico' => 'Mira sobre todo al material o al piso; el apoyo visual está presente pero no lo usa.',
          'Bajo' => 'Da la espalda al público o no utiliza apoyos cuando son necesarios.',
        ]],
        ['criterio' => 'Adecuación al público y vocabulario', 'niveles' => [
          'Superior' => 'Usa el vocabulario del tema y lo explica cuando es nuevo para el público; adapta ejemplos al grupo.',
          'Alto' => 'Usa vocabulario adecuado y explica algunas palabras nuevas.',
          'Básico' => 'Usa palabras que el público no conoce sin explicarlas o muletillas frecuentes.',
          'Bajo' => 'El vocabulario impide la comprensión del público.',
        ]],
      ],
    ],
    [
      'titulo' => 'Comprensión lectora inferencial y crítica (respuestas abiertas, 5.° a 9.°)',
      'criterios' => [
        ['criterio' => 'Inferencia con apoyo textual', 'niveles' => [
          'Superior' => 'Formula inferencias pertinentes sobre intenciones, causas o significados implícitos y las sustenta con dos o más pistas del texto, explicando la relación.',
          'Alto' => 'Formula inferencias pertinentes con una pista del texto, aunque no siempre explica la relación.',
          'Básico' => 'Responde con información literal o con inferencias sin pista textual.',
          'Bajo' => 'Responde con información que no está en el texto ni se deduce de él.',
        ]],
        ['criterio' => 'Sentido global', 'niveles' => [
          'Superior' => 'Expresa el tema y la intención del texto en una oración propia que integra sus partes.',
          'Alto' => 'Expresa el tema global, aunque omite la intención o alguna parte relevante.',
          'Básico' => 'Confunde el tema con un detalle o con el primer párrafo.',
          'Bajo' => 'No identifica de qué trata el texto.',
        ]],
        ['criterio' => 'Posición crítica', 'niveles' => [
          'Superior' => 'Valora el contenido o la forma del texto con argumentos y lo relaciona con otros textos o con su contexto.',
          'Alto' => 'Expresa una valoración argumentada sobre el contenido del texto.',
          'Básico' => 'Expresa gusto o rechazo sin razones o con razones ajenas al texto.',
          'Bajo' => 'No expresa ninguna valoración o repite lo que dice el texto.',
        ]],
        ['criterio' => 'Vocabulario en contexto', 'niveles' => [
          'Superior' => 'Explica el significado de palabras desconocidas a partir del contexto y lo verifica con el sentido de la oración.',
          'Alto' => 'Deduce el significado de la mayoría de palabras por contexto.',
          'Básico' => 'Deduce algunos significados; en otros casos da definiciones que no encajan en la oración.',
          'Bajo' => 'No intenta deducir significados o los inventa sin relación con el texto.',
        ]],
      ],
    ],
    [
      'titulo' => 'Escritura narrativa en primaria (2.° a 5.°)',
      'criterios' => [
        ['criterio' => 'Estructura del relato', 'niveles' => [
          'Superior' => 'El relato tiene inicio que presenta personajes y lugar, un problema claro, acciones que lo desarrollan y un final que lo resuelve.',
          'Alto' => 'Tiene inicio, problema y final; alguna acción del desarrollo falta o se salta.',
          'Básico' => 'Presenta acciones en orden, pero sin problema claro o con un final abrupto («y ya»).',
          'Bajo' => 'Enumera hechos sin relación entre ellos o no se reconoce un relato.',
        ]],
        ['criterio' => 'Personajes y ambiente', 'niveles' => [
          'Superior' => 'Describe a los personajes con rasgos físicos y de carácter, y el lugar con detalles que se pueden imaginar.',
          'Alto' => 'Describe personajes o lugar con algunos detalles.',
          'Básico' => 'Nombra personajes y lugar sin describirlos.',
          'Bajo' => 'No es posible saber quiénes participan ni dónde ocurre.',
        ]],
        ['criterio' => 'Cohesión: conectores de tiempo y referencias', 'niveles' => [
          'Superior' => 'Usa conectores de tiempo variados («una mañana», «de repente», «al final») y evita repetir nombres usando pronombres sin confundir al lector.',
          'Alto' => 'Usa conectores de tiempo, aunque se repiten; alguna repetición de nombres.',
          'Básico' => 'Une las ideas casi siempre con «y» o «entonces».',
          'Bajo' => 'No hay conectores; las oraciones aparecen sueltas.',
        ]],
        ['criterio' => 'Convenciones según el grado', 'niveles' => [
          'Superior' => 'Usa mayúscula inicial y punto final en todas las oraciones; separa correctamente las palabras; ortografía adecuada para el grado.',
          'Alto' => 'Errores ocasionales de mayúsculas, puntos o unión de palabras que no impiden leer.',
          'Básico' => 'Errores frecuentes que obligan a releer, aunque el texto se entiende.',
          'Bajo' => 'Los errores impiden leer partes del texto (se valora según el momento del proceso de cada niño).',
        ]],
      ],
    ],
    [
      'titulo' => 'Ensayo literario (10.° y 11.°)',
      'criterios' => [
        ['criterio' => 'Tesis interpretativa', 'niveles' => [
          'Superior' => 'Plantea una interpretación propia y discutible de la obra (sobre un tema, un personaje, un símbolo o una técnica), no un resumen ni una opinión de gusto.',
          'Alto' => 'Plantea una interpretación clara, aunque cercana a lecturas habituales de la obra.',
          'Básico' => 'Plantea un tema general («la obra habla de la violencia») sin una afirmación interpretativa.',
          'Bajo' => 'Resume la obra o expresa solo gusto o rechazo.',
        ]],
        ['criterio' => 'Uso de evidencia textual', 'niveles' => [
          'Superior' => 'Sustenta cada idea con citas o referencias precisas a pasajes (con página) y analiza cómo esas palabras producen el sentido que propone.',
          'Alto' => 'Usa citas pertinentes con página, aunque a veces las deja sin análisis.',
          'Básico' => 'Alude a escenas sin citarlas o usa citas que no apoyan la idea.',
          'Bajo' => 'No usa evidencia de la obra o la evidencia es incorrecta.',
        ]],
        ['criterio' => 'Relación con el contexto y con otros textos', 'niveles' => [
          'Superior' => 'Relaciona la obra con su contexto histórico, social o estético y con otra obra, de forma que enriquece la interpretación.',
          'Alto' => 'Relaciona la obra con su contexto o con otra obra, aunque la relación es descriptiva.',
          'Básico' => 'Menciona datos de contexto o biográficos sin relacionarlos con la interpretación.',
          'Bajo' => 'No hay relación con el contexto o los datos son incorrectos.',
        ]],
        ['criterio' => 'Organización y estilo académico', 'niveles' => [
          'Superior' => 'La estructura responde a la lógica del argumento (no a una plantilla fija); párrafos con idea central, transiciones claras y registro académico propio.',
          'Alto' => 'Estructura clara y registro adecuado, con algunas transiciones débiles.',
          'Básico' => 'Sigue una plantilla rígida o mezcla registros; párrafos con varias ideas.',
          'Bajo' => 'Ideas sin organización; registro coloquial.',
        ]],
        ['criterio' => 'Honestidad académica y citación', 'niveles' => [
          'Superior' => 'Cita la obra y las fuentes secundarias con un formato consistente y distingue con claridad sus ideas de las ajenas; declara el uso de IA si lo hubo, según lo acordado.',
          'Alto' => 'Cita correctamente con pequeñas inconsistencias de formato.',
          'Básico' => 'Usa ideas ajenas sin citar en algún pasaje o el formato es inconsistente.',
          'Bajo' => 'Presenta como propias ideas o textos ajenos.',
        ]],
      ],
    ],
  ],

  'errores' => [
    [
      'error' => 'Inventa citas de obras literarias o las atribuye al autor equivocado.',
      'como_detectarlo' => 'La cita «suena» al autor pero no aparece en el libro; pide la página y la edición; busca la frase exacta entre comillas en el texto o en un buscador. Desconfía de frases muy citables atribuidas a García Márquez, Borges o Neruda en redes.',
      'como_corregirlo' => 'Entrega tú los fragmentos y prohíbe en el prompt citar cualquier frase que no esté en ellos (ver LEN-05). Pide al final una tabla «cita | fragmento de origen».',
    ],
    [
      'error' => 'Inventa obras, fechas, premios o detalles de la trama.',
      'como_detectarlo' => 'Títulos que no conoces, años redondos, premios «internacionales» sin nombre, personajes secundarios que nadie recuerda o desenlaces distintos al del libro.',
      'como_corregirlo' => 'Dale tu resumen de la obra y los datos verificados; exige «[POR CONFIRMAR]» cuando no tenga la información. Contrasta con la edición que tienen los estudiantes o con fuentes como la Biblioteca Nacional.',
    ],
    [
      'error' => 'Preguntas de «comprensión» que son solo literales o que se responden sin leer.',
      'como_detectarlo' => 'Casi todas empiezan por «¿Qué…?», «¿Quién…?», «¿Dónde…?» y la respuesta es una frase copiada del texto; o se responden con sentido común.',
      'como_corregirlo' => 'Pide distribución por niveles (literal, inferencial, crítico) y la verificación «ninguna inferencial se responde copiando». Usa las afirmaciones del Icfes como guía (ver LEN-08).',
    ],
    [
      'error' => 'Distractores absurdos, chistosos o con la clave siempre en la opción más larga.',
      'como_detectarlo' => 'Una opción se descarta sin leer el texto; las claves se concentran en una letra; la correcta es notoriamente más extensa o la única con matices.',
      'como_corregirlo' => 'Exige justificación de cada distractor según el error de lectura que representa y opciones de extensión similar. Revisa la distribución de claves.',
    ],
    [
      'error' => 'Aplica normas ortográficas desactualizadas o erróneas.',
      'como_detectarlo' => 'Pone tilde en «sólo» y en los demostrativos como obligatoria, escribe «guión», mayúscula en meses y días, tilde en la «o» entre cifras.',
      'como_corregirlo' => 'Incluye en el prompt la norma de la Ortografía de 2010 que necesitas y pide citar la regla en cada corrección. Consulta la duda en el Diccionario panhispánico de dudas o en la RAE.',
    ],
    [
      'error' => 'Usa español de España u otras variantes ajenas al aula colombiana.',
      'como_detectarlo' => '«Vosotros», «ordenador», «coger» por tomar, «zumo», «gafas», «aparcar», «vale», «curso» por grado, «nota media», «instituto» por colegio.',
      'como_corregirlo' => 'Indica «español de Colombia» en el prompt y da ejemplos de las palabras que prefieres. Lee el material en voz alta antes de imprimir.',
    ],
    [
      'error' => 'Texto con nivel léxico y sintáctico inadecuado para el grado.',
      'como_detectarlo' => 'Oraciones de más de 25 palabras para primaria, subordinadas encadenadas, vocabulario abstracto; o, al revés, textos infantilizados para bachillerato.',
      'como_corregirlo' => 'Define en el prompt longitud de oración, extensión y palabras nuevas permitidas; pide una ficha técnica y verifica tú el conteo (ver LEN-18).',
    ],
    [
      'error' => 'Inventa estándares, DBA, numeraciones o «competencias» que no existen.',
      'como_detectarlo' => 'Códigos como «DBA 3.2», «LEN-7-04», enunciados que no aparecen en los documentos del MEN, o una «competencia» de Saber con nombre inventado.',
      'como_corregirlo' => 'Copia y pega siempre el texto oficial del estándar y del DBA en el prompt y prohíbe agregar otros. Cita el documento, el grado y el texto literal (ver Referentes).',
    ],
    [
      'error' => 'Retroalimentación genérica que serviría para cualquier estudiante.',
      'como_detectarlo' => '«Buen trabajo, mejora la redacción», «sigue así», «revisa la ortografía» sin señalar dónde ni cómo.',
      'como_corregirlo' => 'Exige citas del texto del estudiante, una sola prioridad y un ejemplo de mejora sobre su propia oración (ver LEN-23).',
    ],
    [
      'error' => 'Impone la plantilla rígida del ensayo de cinco párrafos o una estructura única para todos los géneros.',
      'como_detectarlo' => 'Toda consigna termina en «introducción, tres párrafos de desarrollo y conclusión», sin importar el género, el propósito ni la extensión.',
      'como_corregirlo' => 'Pide que la estructura se derive de los textos modelo del género y del propósito; en la rúbrica valora la organización según la lógica del argumento.',
    ],
    [
      'error' => 'Presenta los «detectores de IA» o de plagio como prueba confiable.',
      'como_detectarlo' => 'Recomienda pasar los textos por un detector y sancionar según el porcentaje.',
      'como_corregirlo' => 'Los detectores producen falsos positivos, sobre todo con estudiantes que escriben de forma sencilla o en segunda lengua. Evalúa el proceso: borradores, escritura en clase y conversación sobre el texto (ver LEN-28).',
    ],
    [
      'error' => 'Ofrece una única interpretación «correcta» de una obra literaria.',
      'como_detectarlo' => 'Preguntas críticas con una sola respuesta válida, claves del tipo «el autor quiso decir…», o rúbricas que premian coincidir con una lectura.',
      'como_corregirlo' => 'Pide que las preguntas críticas admitan varias interpretaciones y que se valore la argumentación con evidencia, no la coincidencia con la del docente o la de la IA.',
    ],
  ],

  'banco_contextos' => [
    'La emisora comunitaria del municipio abre un espacio de 10 minutos para noticias escritas por jóvenes.',
    'La junta de acción comunal convoca a una reunión sobre la quebrada contaminada del barrio.',
    'El grupo de WhatsApp de padres del curso recibe una cadena alarmista sobre el calendario escolar.',
    'La tienda de la esquina tiene un aviso escrito a mano con errores y precios; se analiza como texto discontinuo.',
    'Un recibo de servicios públicos (agua o energía) para leer tablas, fechas límite y consumo.',
    'La cartelera del colegio necesita textos para el Día del Idioma (23 de abril).',
    'El Festival de la Leyenda Vallenata en Valledupar: crónica, entrevista a un acordeonero o reseña de un concierto.',
    'Las décimas del Pacífico y del Caribe recogidas con abuelos y cantadoras de la comunidad.',
    'Los alabaos y arrullos del Pacífico como tradición oral que se transmite de mayores a niños.',
    'La leyenda del Mohán en los pueblos ribereños del Magdalena y sus distintas versiones.',
    'La Madremonte, la Patasola o el Hombre Caimán: comparación de versiones regionales de mitos y leyendas.',
    'El Carnaval de Barranquilla o el Carnaval de Negros y Blancos de Pasto: letanías, comparsas y su lenguaje.',
    'La Feria de las Flores en Medellín y los silleteros: entrevista, crónica y texto expositivo.',
    'Las fiestas en corraleja de la sabana de Sucre y Córdoba como tema de debate.',
    'El mototaxismo en ciudades intermedias: carta de opinión al concejo o al periódico regional.',
    'El páramo que abastece de agua al municipio: texto expositivo, infografía y campaña.',
    'Una receta tradicional de la región (sancocho, ajiaco, mote de queso, arepa de huevo) como texto instructivo.',
    'El mercado campesino del fin de semana: listas, avisos, diálogos y regateo como práctica oral.',
    'Una columna de opinión del periódico regional sobre la seguridad en el barrio.',
    'Un video viral en redes sociales con información de salud dudosa para verificar.',
    'Estudiantes venezolanos recién llegados: diversidad de variantes del español en el mismo salón.',
    'Palabras de lenguas indígenas y del criollo palenquero o sanandresano presentes en el español regional.',
    'La elección del personero estudiantil: propuestas, carteles, debate y discurso.',
    'El manual de convivencia del colegio como texto normativo para leer, discutir y proponer cambios.',
    'La biblioteca pública municipal o la biblioteca escolar: reseñas de libros para recomendar a otros cursos.',
    'Una carta a un familiar que vive en otra ciudad o en otro país, contando la vida en el barrio o la vereda.',
    'Letras de vallenato, cumbia, salsa caleña o música de carranga como textos líricos para analizar (fragmentos breves).',
    'El torneo de microfútbol del barrio o el partido de la Selección: crónica deportiva y titulares.',
    'Las memorias de los abuelos sobre cómo era el pueblo hace cincuenta años: entrevista y relato testimonial.',
    'Un aviso de la alcaldía sobre vacunación, inscripción a subsidios o cortes de agua, para leer con atención crítica.',
  ],
];
