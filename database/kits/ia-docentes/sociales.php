<?php
/**
 * Kit de IA para docentes — Ciencias Sociales.
 * Contenido curado por Edwin Ortiz Herazo (edwinortiz.net).
 * Este archivo solo devuelve datos; otro módulo lo renderiza a PDF.
 */

return [
    'key' => 'sociales',
    'name' => 'Ciencias Sociales',
    'tagline' => 'Prompts probados para enseñar historia, geografía, Constitución y ciudadanía con fuentes, perspectivas y contextos colombianos reales, alineados con Estándares, DBA y Saber.',

    'intro_html' => '<p>Pídale a cualquier chat de IA «una clase sobre la independencia» y recibirá una narración de héroes, fechas y batallas, probablemente con algún dato equivocado y sin una sola fuente. Las ciencias sociales que exigen los Estándares, los DBA y las pruebas Saber son otra cosa: pensar históricamente con fuentes, leer el territorio, comprender perspectivas distintas, analizar problemas con sus dimensiones económicas, políticas, culturales y ambientales, y formarse como ciudadano en un país diverso, con un conflicto armado que dejó millones de víctimas y con una Constitución que reconoce la diversidad étnica y cultural.</p>
<p>Este kit trae <strong>recetas</strong>: prompts completos con rol, contexto, tarea, formato y autoverificación, que obligan a la IA a trabajar con fuentes, a distinguir hechos de interpretaciones, a evitar estereotipos y a marcar lo que debe verificarse. Cada receta incluye variables, prompts de seguimiento, un ejemplo editado por un docente experto y una lista de lo que hay que revisar antes de usarlo en clase. Las recetas cubren <strong>planeación, evaluación, adaptación (DUA, PIAR, enfoque étnico), recursos, retroalimentación y gestión</strong>, desde Transición hasta 11.°.</p>
<p>También encontrará <strong>cadenas de trabajo</strong> para unidades completas, <strong>rúbricas</strong> con la escala Superior, Alto, Básico y Bajo, una lista de <strong>errores típicos de la IA en sociales</strong> (narrativas simplistas, anacronismos, geografía equivocada, civismo «gringo», sesgos sobre el conflicto armado) y un <strong>banco de contextos colombianos</strong>. Cuando se trabajan el conflicto armado y la memoria histórica, el kit aplica el principio de acción sin daño: cuidar a los estudiantes y familias que pudieron ser víctimas, no revictimizar y no convertir el dolor en espectáculo.</p>',

    'referentes_html' => '<p><strong>Lineamientos curriculares de Ciencias Sociales (MEN, 2002).</strong> Proponen un área integrada y problematizadora, organizada en ejes generadores, preguntas problematizadoras y ámbitos conceptuales. El MEN adelanta su actualización «en clave de historia de Colombia», en cumplimiento de la Ley 1874 de 2017, que restableció la enseñanza obligatoria de la historia de Colombia integrada a las ciencias sociales; verifique el estado de ese proceso antes de citarlo.</p>
<p><strong>Estándares Básicos de Competencias en Ciencias Sociales (MEN, 2004; compilados en 2006).</strong> Organizados por grupos de grados (1.° a 3.°, 4.° y 5.°, 6.° y 7.°, 8.° y 9.°, 10.° y 11.°) y en tres columnas: <em>me aproximo al conocimiento como científico(a) social</em>, <em>manejo conocimientos propios de las ciencias sociales</em> (relaciones con la historia y las culturas, relaciones espaciales y ambientales, relaciones ético-políticas) y <em>desarrollo compromisos personales y sociales</em>. Se complementan con los <strong>Estándares Básicos de Competencias Ciudadanas</strong> (convivencia y paz; participación y responsabilidad democrática; pluralidad, identidad y valoración de las diferencias).</p>
<p><strong>Derechos Básicos de Aprendizaje de Ciencias Sociales (MEN, 2016).</strong> Van de 1.° a 11.°, con evidencias de aprendizaje por cada DBA. En este kit se describen por su contenido y no por número: copie siempre el texto oficial en el prompt.</p>
<p><strong>Pruebas Saber (ICFES).</strong> La prueba de Sociales y Ciudadanas de Saber 11 evalúa tres competencias: <em>pensamiento social</em> (uso de conceptos de las ciencias sociales y de la Constitución para comprender problemas), <em>interpretación y análisis de perspectivas</em> y <em>pensamiento reflexivo y sistémico</em>. En Saber 5.° y 9.° el área se aproxima mediante la prueba de Competencias Ciudadanas (pensamiento ciudadano), que evalúa conocimientos sobre la Constitución y el Estado, argumentación, multiperspectivismo y pensamiento sistémico. Consulte la guía de orientación vigente: los grados aplicados y las especificaciones cambian entre años.</p>
<p><strong>Normas que enmarcan el área.</strong> Ley 115 de 1994 (área obligatoria de Ciencias Sociales, Historia, Geografía, Constitución Política y Democracia; en la media, Ciencias Económicas y Políticas), Ley 107 de 1994 (estudios constitucionales para obtener el título de bachiller), Decreto 1122 de 1998 (Cátedra de Estudios Afrocolombianos), Ley 1620 de 2013 (convivencia escolar), Ley 1732 de 2014 y Decreto 1038 de 2015 (Cátedra de la Paz), Ley 1874 de 2017 (historia de Colombia), Decreto 1290 de 2009 (evaluación) y Decreto 1421 de 2017 (educación inclusiva y PIAR).</p>',

    'mapa' => [
        [
            'grados' => 'Transición a 3.°',
            'enfoque' => 'El niño y su mundo cercano: yo, mi familia, mi escuela, mi barrio o vereda. Normas, acuerdos, oficios, paisaje, ubicación espacial y el paso del tiempo en la propia historia.',
            'claves' => [
                'En Transición, el juego, el arte, la literatura y la exploración del medio son el camino; nada de transcribir definiciones.',
                'Nociones de tiempo (antes, ahora, después; línea de vida personal) y de espacio (cerca, lejos, recorridos, planos sencillos).',
                'Diversidad de familias y culturas sin estereotipos; reconocimiento de la propia historia.',
                'Normas y acuerdos para convivir; manejo de emociones y conflictos (Cátedra de la Paz desde el aula).',
                'Oficios, productos y recursos del entorno: de dónde viene lo que comemos.',
            ],
        ],
        [
            'grados' => '4.° y 5.°',
            'enfoque' => 'Colombia como territorio y como sociedad diversa: regiones naturales, relieve, hidrografía, pueblos originarios, la Colonia y la organización política básica. Primer contacto con la Constitución y con Saber 5.°.',
            'claves' => [
                'Regiones naturales (Andina, Caribe, Pacífica, Orinoquía, Amazonía, Insular) y su relación con las formas de vida.',
                'Pueblos indígenas antes de la llegada de los europeos, y su presencia actual; poblamiento africano y mestizaje.',
                'Organización territorial: departamentos, municipios, territorios étnicos; ramas del poder público.',
                'Derechos de los niños y mecanismos de participación escolar.',
                'Lectura de mapas: puntos cardinales, convenciones, escala sencilla.',
            ],
        ],
        [
            'grados' => '6.° y 7.°',
            'enfoque' => 'Las sociedades en el tiempo y en el espacio global: de las primeras comunidades a la Edad Media y el encuentro de dos mundos; la Tierra, sus coordenadas y sus paisajes. Comparación entre culturas.',
            'claves' => [
                'Coordenadas geográficas, husos horarios, relieve y clima mundial, con Colombia como referente.',
                'Civilizaciones antiguas de distintos continentes, incluidas las americanas, sin jerarquizar culturas.',
                'Edad Media, expansión europea y procesos de conquista y colonización en América.',
                'Gobierno escolar, personero y participación; normas y Constitución.',
                'Uso de fuentes sencillas: diferenciar fuente primaria y secundaria.',
            ],
        ],
        [
            'grados' => '8.° y 9.°',
            'enfoque' => 'Formación de los Estados nacionales: revoluciones, independencia, siglo XIX colombiano, siglo XX, procesos económicos y sociales. Análisis de fuentes y perspectivas; preparación de Saber 9.°.',
            'claves' => [
                'Revoluciones liberales e independencias americanas; el siglo XIX colombiano, sus constituciones y guerras civiles.',
                'Esclavización y abolición (1851), procesos de colonización interna y economía exportadora.',
                'Siglo XX: industrialización, violencia bipartidista, Frente Nacional, urbanización y movimientos sociales.',
                'Población, migraciones internas y externas, desplazamiento forzado.',
                'Argumentación con fuentes y análisis de multiperspectivismo.',
            ],
        ],
        [
            'grados' => '10.° y 11.°',
            'enfoque' => 'Problemas contemporáneos con enfoque sistémico: conflicto armado y construcción de paz, Constitución de 1991, democracia, economía y globalización, ambiente y territorio, derechos humanos. Preparación de Saber 11 en sus tres competencias.',
            'claves' => [
                'Conflicto armado colombiano, memoria histórica, Acuerdo de Paz de 2016 y justicia transicional, con acción sin daño.',
                'Constitución de 1991: Estado social de derecho, derechos fundamentales, mecanismos de protección y participación.',
                'Ciencias económicas y políticas: modelos económicos, mercado, Estado, globalización, desigualdad.',
                'Conflictos socioambientales: minería, agua, páramos, tierra y territorio.',
                'Análisis de perspectivas, evaluación de argumentos y pensamiento sistémico como en Saber 11.',
            ],
        ],
    ],

    'recetas' => [
        [
            'id' => 'SOC-01',
            'categoria' => 'planeacion',
            'titulo' => 'Secuencia didáctica con pregunta problematizadora a partir de un DBA',
            'grados' => '1.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Al iniciar una unidad de historia, geografía o ciudadanía, cuando quiere salir del recuento de fechas y organizarla alrededor de una pregunta que exija pensar.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[MUNICIPIO_REGION]' => 'Municipio y región.',
                '[DBA]' => 'Texto oficial del DBA de Ciencias Sociales.',
                '[EVIDENCIAS]' => 'Evidencias de aprendizaje priorizadas.',
                '[TEMA]' => 'Tema o proceso histórico, geográfico o político.',
                '[N_SESIONES]' => 'Número y duración de sesiones.',
                '[RECURSOS]' => 'Recursos disponibles (video beam, biblioteca, mapas, internet o no).',
                '[CARACTERISTICAS]' => 'Rasgos del grupo, estudiantes con PIAR, composición étnica, víctimas del conflicto si se sabe y es pertinente.',
            ],
            'prompt' => 'Actúa como docente colombiano de ciencias sociales con formación en didáctica de la historia y la geografía, conocedor de los Estándares Básicos de Competencias, los DBA de Ciencias Sociales y la Ley 1874 de 2017 sobre la enseñanza de la historia de Colombia.

CONTEXTO
- Grado: [GRADO]. Institución en [MUNICIPIO_REGION].
- DBA (texto oficial, no lo modifiques): "[DBA]"
- Evidencias priorizadas: [EVIDENCIAS]
- Tema: [TEMA]. Tiempo: [N_SESIONES]. Recursos: [RECURSOS].
- Características del grupo: [CARACTERISTICAS].

TAREA
Diseña una secuencia didáctica organizada alrededor de una pregunta problematizadora (una pregunta abierta, discutible, que no se responde con un dato y que admite respuestas argumentadas distintas).

FORMATO DE SALIDA
1. Tres opciones de pregunta problematizadora; elige una y justifica por qué es la mejor para este grupo y este DBA.
2. Tabla: Sesión | Propósito | Actividad central | Fuente o recurso | Habilidad de pensamiento social que se trabaja (ubicar en tiempo y espacio, causalidad, cambio y continuidad, perspectivas, uso de fuentes, argumentación) | Evidencia.
3. Desarrollo de cada sesión con inicio, desarrollo y cierre, incluyendo las preguntas textuales que hará el docente.
4. Al menos dos fuentes (primarias o secundarias) descritas con precisión: qué son, quién las produjo, cuándo y dónde podría encontrarlas el docente. Si no estás seguro de que una fuente exista, NO la inventes: describe el tipo de fuente que se necesita.
5. Conexión con el presente y con el territorio de [MUNICIPIO_REGION].
6. Producto final con criterios en escala Superior, Alto, Básico y Bajo.
7. Ajustes DUA concretos.

RESTRICCIONES
- Incluye las perspectivas de distintos actores (por ejemplo, pueblos indígenas, población afrodescendiente, mujeres, campesinos, élites, sectores populares) cuando sean pertinentes, sin forzar ni caricaturizar.
- Distingue hechos documentados de interpretaciones historiográficas.
- No inventes citas textuales de personajes históricos. Si citas, que sea solo algo que puedas garantizar; si no, parafrasea y marca con [POR CONFIRMAR].
- Fechas y datos verificables marcados con [POR CONFIRMAR] cuando tengas duda.
- Si el tema toca el conflicto armado, aplica acción sin daño: nada de imágenes explícitas, nada de pedir a los estudiantes que cuenten experiencias propias de violencia.

AUTOVERIFICACIÓN
Antes de entregar, revisa y reporta: (a) la pregunta problematizadora se trabaja en todas las sesiones; (b) cada evidencia aparece al menos una vez; (c) hay más de una perspectiva; (d) no hay citas inventadas; (e) lista de datos marcados para verificar.',
            'seguimientos' => [
                'Diseña la guía del estudiante para la sesión de análisis de fuentes, con espacio para responder.',
                'Propón el producto final en dos formatos: uno escrito y uno oral o artístico, con la misma rúbrica.',
                'Ajusta la secuencia para un grupo sin conexión a internet ni video beam.',
                'Dame un ticket de salida para cada sesión que muestre el avance hacia la pregunta problematizadora.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [MUNICIPIO_REGION] Tunja, Boyacá; [DBA] texto oficial del DBA de 8.° sobre los procesos de independencia en el actual territorio colombiano; [TEMA] independencia, 1810 a 1821; [N_SESIONES] 6 de 55 minutos; [RECURSOS] video beam, biblioteca escolar; [CARACTERISTICAS] 36 estudiantes, interesados en el Puente de Boyacá.',
                'resultado_html' => '<p><strong>Pregunta elegida:</strong> ¿La independencia cambió la vida de todos los que vivían en la Nueva Granada?</p>
<p><strong>Justificación:</strong> obliga a pasar de la narración de batallas a analizar quiénes ganaron, quiénes siguieron igual y quiénes esperaron mucho más tiempo: por ejemplo, las personas esclavizadas, cuya libertad definitiva llegó con la ley del 21 de mayo de 1851, que hizo efectiva la abolición a partir del 1 de enero de 1852.</p>
<table><tr><th>Sesión</th><th>Actividad central</th><th>Habilidad</th></tr>
<tr><td>1</td><td>Lluvia de ideas: ¿qué celebramos el 20 de julio y el 7 de agosto? Línea de tiempo inicial.</td><td>Ubicación temporal</td></tr>
<tr><td>2</td><td>Mapa del virreinato y del Puente de Boyacá: ¿por qué ahí?</td><td>Relación espacio y proceso</td></tr>
<tr><td>3</td><td>Cuatro perspectivas en tarjetas: un comerciante criollo, una mujer del común que apoyó a las guerrillas patriotas, un indígena de resguardo, una persona esclavizada.</td><td>Perspectivas</td></tr>
<tr><td>4</td><td>Fuente: fragmentos de la ley del 19 de julio de 1821 sobre libertad de partos, manumisión y abolición del tráfico de esclavos, aprobada por el Congreso de Cúcuta (tome el texto de una compilación oficial o académica): ¿quiénes quedaban libres y quiénes no?</td><td>Uso de fuentes</td></tr>
<tr><td>5</td><td>Debate en «cuatro esquinas»: sí cambió, cambió para algunos, cambió poco, no cambió.</td><td>Argumentación</td></tr>
<tr><td>6</td><td>Producto: carta de uno de los personajes en 1822, contando qué cambió en su vida.</td><td>Síntesis</td></tr></table>',
            ],
            'revisar' => [
                'Fechas, nombres y leyes: verifíquelos en fuentes académicas o en la Biblioteca Nacional.',
                'Que no aparezcan citas textuales inventadas de próceres.',
                'Que las perspectivas no reproduzcan estereotipos (el indígena pasivo, la mujer solo como enfermera).',
                'Que la pregunta problematizadora sea abierta de verdad y no tenga una respuesta «correcta» esperada.',
            ],
        ],
        [
            'id' => 'SOC-02',
            'categoria' => 'recursos',
            'titulo' => 'Taller de análisis de fuentes históricas',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Cuando quiere que los estudiantes lean fuentes como historiadores: quién la produjo, para qué, en qué contexto, qué dice y qué calla, y cómo se contrasta con otras.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[TEMA]' => 'Hecho o proceso histórico.',
                '[FUENTES]' => 'Las fuentes que usted tiene (pegue el texto o describa la imagen con su procedencia).',
                '[PREGUNTA_HISTORICA]' => 'Pregunta que las fuentes ayudan a responder.',
            ],
            'prompt' => 'Actúa como historiador y docente experto en pensamiento histórico, con experiencia en el análisis de fuentes en el aula (procedencia, contextualización, lectura atenta y corroboración).

CONTEXTO
- Grado: [GRADO]. Tema: [TEMA].
- Pregunta histórica: [PREGUNTA_HISTORICA]
- Fuentes disponibles:
"""
[FUENTES]
"""

TAREA
Diseña un taller de análisis de estas fuentes. Trabaja SOLO con las fuentes que te entregué; no agregues fuentes que no puedas garantizar que existen.

FORMATO DE SALIDA
1. Ficha de cada fuente para el docente: tipo (primaria o secundaria), autor, fecha, propósito probable, contexto histórico en 4 líneas, aspectos que la fuente muestra y aspectos que oculta o deja por fuera.
2. Guía para el estudiante con cuatro momentos:
   a. Procedencia: ¿quién la hizo, cuándo, para quién y para qué?
   b. Contextualización: ¿qué estaba pasando en ese momento y lugar?
   c. Lectura atenta: ¿qué afirma? ¿qué palabras usa y qué revelan?
   d. Corroboración: ¿en qué coinciden y en qué difieren las fuentes? ¿a cuál le creo más para responder la pregunta y por qué?
3. Preguntas graduadas (literal, inferencial, crítica) para cada fuente.
4. Actividad de cierre: respuesta argumentada a [PREGUNTA_HISTORICA] citando al menos dos fuentes.
5. Respuestas esperadas y errores típicos (creerle a la fuente por ser «antigua», confundir opinión del autor con hecho, juzgar el pasado con valores de hoy sin contextualizar).

RESTRICCIONES
- No atribuyas a una fuente contenidos que no están en el texto entregado.
- Si una fuente es una imagen que describí, trabaja con mi descripción y pide al estudiante observar detalles concretos.
- Lenguaje adecuado a [GRADO].

AUTOVERIFICACIÓN
Confirma que todas las preguntas pueden responderse con las fuentes entregadas y el contexto dado, y que no se agregaron datos no verificables.',
            'seguimientos' => [
                'Propón una fuente adicional que contraste con estas (describe qué tipo de fuente y dónde podría buscarla, sin inventar una específica).',
                'Convierte el taller en un ítem tipo Saber 11 de interpretación y análisis de perspectivas.',
                'Adapta la guía para estudiantes con dificultades de lectura, sin cambiar las fuentes.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.°; [TEMA] el 9 de abril de 1948 en Bogotá; [FUENTES] una fotografía de prensa de la carrera Séptima en ruinas el 10 de abril (descrita por el docente), un titular de un periódico liberal y otro conservador de esos días (copiados de la hemeroteca), un fragmento de testimonio de un habitante de Bogotá publicado en un libro de memorias; [PREGUNTA_HISTORICA] ¿Por qué el asesinato de Jorge Eliécer Gaitán desató una reacción tan grande?',
                'resultado_html' => '<p><strong>Ficha (titulares):</strong> son fuentes primarias producidas por periódicos con filiación partidista explícita. Su propósito no era solo informar: también buscaban explicar los hechos a favor de su partido. Lo que muestran: cómo cada sector quería que se entendiera el hecho. Lo que ocultan: las voces de los sectores populares que protagonizaron la revuelta.</p>
<p><strong>Corroboración (pregunta para el estudiante):</strong> «Los dos periódicos culpan a actores distintos. ¿En qué coinciden? ¿Qué te dice eso sobre la polarización política de la época?»</p>
<p><strong>Error típico:</strong> tomar el titular de un periódico como «lo que pasó», sin preguntar quién lo escribió y con qué intención.</p>
<p><strong>Cierre:</strong> «Responde la pregunta histórica en un párrafo de 8 a 10 líneas, citando al menos dos fuentes y una idea sobre el contexto de la violencia entre partidos antes de 1948.»</p>',
            ],
            'revisar' => [
                'Que la IA no haya agregado fuentes o citas que usted no entregó.',
                'Procedencia real de las fuentes (fecha, autor, publicación).',
                'Si las fuentes incluyen imágenes de violencia, seleccionar las que no sean explícitas.',
            ],
        ],
        [
            'id' => 'SOC-03',
            'categoria' => 'recursos',
            'titulo' => 'Línea de tiempo con causas, simultaneidades y ritmos',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Cuando quiere una línea de tiempo que no sea una lista de fechas para memorizar, sino una herramienta para pensar causalidad, cambio, continuidad y simultaneidad.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PERIODO]' => 'Periodo histórico y espacio (Colombia, América Latina, el mundo, el municipio).',
                '[N_HITOS]' => 'Número de hitos.',
                '[DIMENSIONES]' => 'Dimensiones a incluir (política, económica, social, cultural, ambiental).',
                '[CONEXION_LOCAL]' => 'Municipio o región para conectar con hechos locales.',
            ],
            'prompt' => 'Actúa como historiador y docente de ciencias sociales experto en la enseñanza del tiempo histórico (cronología, duración, simultaneidad, cambio y continuidad, causalidad múltiple).

CONTEXTO
- Grado: [GRADO]. Periodo: [PERIODO]. Dimensiones: [DIMENSIONES].
- Conexión local: [CONEXION_LOCAL]. Número de hitos: [N_HITOS].

TAREA
1. Elabora una línea de tiempo con [N_HITOS] hitos del periodo, distribuidos en las dimensiones indicadas.
2. Para cada hito: fecha, hecho en una línea, dimensión, y por qué importa (consecuencia o relación con otro hito).
3. Señala al menos tres relaciones causales entre hitos (con flechas descritas: «A contribuyó a B porque...»), advirtiendo que los procesos tienen causas múltiples.
4. Señala al menos dos simultaneidades significativas (lo que pasaba al mismo tiempo en otro lugar o dimensión).
5. Indica qué cambió y qué permaneció a lo largo del periodo.
6. Propón cómo los estudiantes construyen la línea (escala de tiempo proporcional, colores por dimensión) y las preguntas de análisis.

RESTRICCIONES
- Cada fecha debe ser verificable. Si no estás seguro de una fecha exacta, da el año o la década y márcala con [POR CONFIRMAR]; nunca inventes una fecha precisa.
- Incluye hitos que no sean solo de gobernantes y guerras: economía, movimientos sociales, mujeres, pueblos étnicos, cultura, ambiente.
- Evita la narrativa de progreso lineal.

AUTOVERIFICACIÓN
Revisa el orden cronológico, la coherencia de las relaciones causales y lista al final las fechas que deben verificarse.',
            'seguimientos' => [
                'Convierte esta línea de tiempo en un juego de tarjetas para ordenar en equipos, con tarjetas de causa y consecuencia.',
                'Crea cinco preguntas tipo Saber de pensamiento social a partir de la línea de tiempo.',
                'Dame una versión para 4.° y 5.° con 8 hitos y lenguaje sencillo.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [PERIODO] Colombia de la Constitución de 1886 a la de 1991; [N_HITOS] 14 (se muestra un extracto); [DIMENSIONES] política, social, económica; [CONEXION_LOCAL] Santa Marta y la zona bananera.',
                'resultado_html' => '<table><tr><th>Fecha</th><th>Hito</th><th>Dimensión</th><th>Por qué importa</th></tr>
<tr><td>1886</td><td>Constitución centralista de la Regeneración</td><td>Política</td><td>Rige más de un siglo, con reformas; su crisis está en el origen de la Constituyente de 1991.</td></tr>
<tr><td>1899 a 1902</td><td>Guerra de los Mil Días</td><td>Política</td><td>Debilita al país y antecede la separación de Panamá (1903).</td></tr>
<tr><td>1928</td><td>Masacre de las bananeras, en Ciénaga (Magdalena)</td><td>Social</td><td>Conexión local: huelga de trabajadores de la zona bananera reprimida por el Ejército; marca el debate sobre derechos laborales.</td></tr>
<tr><td>1957</td><td>Las mujeres votan por primera vez, en el plebiscito</td><td>Social</td><td>El derecho se había reconocido con el Acto Legislativo 3 de 1954; el plebiscito fue el 1 de diciembre de 1957.</td></tr>
<tr><td>1958 a 1974</td><td>Frente Nacional</td><td>Política</td><td>Pone fin a la violencia bipartidista abierta, pero excluye a otras fuerzas políticas.</td></tr>
<tr><td>1990</td><td>Movimiento estudiantil de la «séptima papeleta»</td><td>Política</td><td>Impulsa la convocatoria de la Asamblea Nacional Constituyente.</td></tr></table>
<p><strong>Relación causal:</strong> la exclusión política del Frente Nacional contribuyó, junto con otros factores como la desigualdad en el acceso a la tierra, al surgimiento y la persistencia de guerrillas.</p>
<p><strong>Continuidad:</strong> la concentración de la tierra atraviesa todo el periodo.</p>',
            ],
            'revisar' => [
                'Todas las fechas, una por una.',
                'Que las relaciones causales no sean monocausales ni deterministas.',
                'Que haya diversidad de actores y dimensiones.',
            ],
        ],
        [
            'id' => 'SOC-04',
            'categoria' => 'recursos',
            'titulo' => 'Audiencia pública simulada sobre un conflicto socioambiental',
            'grados' => '8.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Para trabajar interpretación y análisis de perspectivas y pensamiento sistémico con un conflicto real, donde los estudiantes asumen roles y deben deliberar con evidencias.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[CONFLICTO]' => 'Conflicto real (minería en páramo, represa, relleno sanitario, vía en zona de reserva, uso del agua).',
                '[SESIONES]' => 'Número de sesiones.',
                '[N_ESTUDIANTES]' => 'Número de estudiantes.',
            ],
            'prompt' => 'Actúa como docente de ciencias sociales experto en deliberación democrática, conflictos socioambientales en Colombia y la competencia de interpretación y análisis de perspectivas de Saber 11.

CONTEXTO
- Grado: [GRADO]. Conflicto: [CONFLICTO]. Sesiones: [SESIONES]. Estudiantes: [N_ESTUDIANTES].

TAREA
Diseña una audiencia pública simulada.

FORMATO DE SALIDA
1. Descripción neutral del conflicto para estudiantes (máximo 300 palabras): qué está en juego, dónde, desde cuándo, qué ha decidido el Estado. Marca con [POR CONFIRMAR] normas, sentencias y cifras.
2. Fichas de rol (5 a 7 actores): quién es, qué le interesa, qué teme, qué valora, qué dice la Constitución o la ley que respalda su posición, una pregunta incómoda que podrían hacerle.
3. Análisis sistémico: dimensiones del conflicto (económica, ambiental, social, cultural, política, jurídica) y cómo se relacionan; consecuencias de cada alternativa a corto y largo plazo.
4. Protocolo de la audiencia: moderador, tiempos, réplicas, reglas de respeto, rol de observadores que registran argumentos.
5. Producto final: cada estudiante escribe una recomendación como si fuera un funcionario público, considerando al menos tres perspectivas.
6. Preguntas de cierre sobre participación ciudadana (consulta previa, consultas populares, audiencias, acciones constitucionales), indicando que el alcance de estos mecanismos depende de la normativa y la jurisprudencia vigentes.

RESTRICCIONES
- Ningún actor es villano: presenta el argumento más fuerte de cada uno.
- No tomes partido.
- No inventes sentencias, números de normas ni cifras; si no estás seguro, dilo.
- Distingue intereses (lo que quieren) de valores (lo que consideran importante) y de evidencias (datos).

AUTOVERIFICACIÓN
Verifica que cada rol tenga un argumento sólido, que el análisis sistémico conecte al menos cuatro dimensiones y que todo dato jurídico esté marcado para verificar.',
            'seguimientos' => [
                'Diseña la rejilla de observación para los estudiantes observadores.',
                'Crea tres ítems tipo Saber 11 de pensamiento reflexivo y sistémico con este conflicto.',
                'Prepara la rúbrica de la recomendación escrita.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.°; [CONFLICTO] minería de oro en el páramo de Santurbán (Santander y Norte de Santander) y abastecimiento de agua de Bucaramanga y su área metropolitana; [SESIONES] 3; [N_ESTUDIANTES] 35.',
                'resultado_html' => '<p><strong>Roles:</strong> habitante de Bucaramanga preocupado por el agua; minero tradicional de California o Vetas; representante de una empresa minera; funcionario del Ministerio de Ambiente encargado de la delimitación; campesino del páramo que cultiva papa; investigadora en ecología de páramos; abogado que conoce la sentencia T-361 de 2017 de la Corte Constitucional, que ordenó delimitar de nuevo el páramo mediante un proceso participativo.</p>
<p><strong>Ficha del minero tradicional (extracto):</strong> «Mi familia ha vivido de la minería por generaciones; en el municipio hay pocas alternativas de empleo. Temo que la delimitación nos deje sin trabajo y que nadie ofrezca opciones reales. Valoro mi oficio y mi pueblo. Pregunta incómoda: ¿cómo garantiza que su actividad no afecte el agua de un millón de personas que viven abajo?»</p>
<p><strong>Análisis sistémico:</strong> la dimensión ambiental (regulación hídrica del páramo) se conecta con la económica (empleo local y regalías), la social (identidad minera de los municipios), la jurídica (protección especial de los páramos y derecho a la participación) y la política (relación entre Gobierno nacional, municipios y ciudadanía).</p>',
            ],
            'revisar' => [
                'Normas, sentencias, cifras y estado actual del conflicto: cambian con frecuencia.',
                'Que ninguna ficha caricaturice a un actor.',
                'Si hay estudiantes cuyas familias están involucradas en el conflicto, prever cómo cuidar la discusión.',
            ],
        ],
        [
            'id' => 'SOC-05',
            'categoria' => 'recursos',
            'titulo' => 'Cartografía social del territorio escolar',
            'grados' => '3.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Para que los estudiantes lean su barrio, vereda o municipio con mapas: recursos, riesgos, lugares de encuentro, conflictos y cambios en el tiempo.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[TERRITORIO]' => 'Barrio, vereda, comuna o municipio.',
                '[TEMA_DEL_MAPA]' => 'Foco: riesgos, ambiente, servicios, memoria, movilidad, economía.',
                '[SESIONES]' => 'Número de sesiones.',
                '[MATERIALES]' => 'Papel, marcadores, mapas impresos, celulares.',
            ],
            'prompt' => 'Actúa como geógrafo y docente experto en cartografía social y en enseñanza de la geografía escolar en Colombia.

CONTEXTO
- Grado: [GRADO]. Territorio: [TERRITORIO]. Foco: [TEMA_DEL_MAPA].
- Sesiones: [SESIONES]. Materiales: [MATERIALES].

TAREA
Diseña un ejercicio de cartografía social con tres mapas: el territorio de ayer (cómo era según los mayores), el de hoy y el que queremos.

FORMATO DE SALIDA
1. Preparación: cómo conseguir una base cartográfica (mapa municipal, imagen satelital impresa o dibujo a mano) y cómo enseñar antes los elementos del mapa (título, orientación, convenciones, escala aproximada).
2. Convenciones sugeridas para el foco [TEMA_DEL_MAPA] (íconos y colores).
3. Desarrollo por sesión: trabajo en grupos, preguntas guía, recorrido de observación si es posible y seguro.
4. Guía de entrevista corta a un mayor del territorio para el mapa de ayer.
5. Análisis: preguntas para comparar los tres mapas (qué cambió, por qué, quién ganó y quién perdió con esos cambios).
6. Socialización a la comunidad y uso posible del mapa (por ejemplo, en el plan escolar de gestión del riesgo o en el PRAE).
7. Criterios de evaluación con escala Superior, Alto, Básico y Bajo.

RESTRICCIONES
- Seguridad: no ubicar en el mapa casas de estudiantes ni datos personales; no señalar personas o grupos como peligrosos; en contextos de presencia de actores armados, no cartografiar esa presencia.
- Recorridos solo con autorización y acompañamiento.
- Respetar los nombres propios que la comunidad da a los lugares.

AUTOVERIFICACIÓN
Confirma que el ejercicio enseña conceptos cartográficos reales (orientación, escala, convenciones) y no solo dibujo, y que las medidas de seguridad están incluidas.',
            'seguimientos' => [
                'Diseña la retroalimentación para los mapas: qué comentar sobre convenciones, escala y análisis.',
                'Convierte el mapa del «territorio que queremos» en una propuesta para la junta de acción comunal.',
                'Propón cómo comparar el mapa de los estudiantes con un mapa oficial del IGAC o del POT municipal.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.°; [TERRITORIO] barrio en la ladera de una comuna de Manizales, Caldas; [TEMA_DEL_MAPA] riesgos y lugares seguros; [SESIONES] 4; [MATERIALES] pliegos de papel, marcadores, mapa impreso del barrio tomado de una imagen satelital.',
                'resultado_html' => '<p><strong>Convenciones:</strong> triángulo rojo, zona donde ha habido deslizamientos; gota azul, quebradas y canales de agua lluvia; casa verde, punto de encuentro seguro; cruz, centro de salud; línea punteada, ruta de evacuación propuesta.</p>
<p><strong>Entrevista para el mapa de ayer:</strong> «¿Cómo era esta loma cuando usted llegó? ¿Dónde había árboles? ¿Qué quebradas había y qué pasó con ellas? ¿Recuerda alguna temporada de lluvias que haya causado daños?»</p>
<p><strong>Análisis:</strong> «Comparen el mapa de ayer y el de hoy: ¿qué pasó con la vegetación en la ladera? ¿Qué relación tiene eso con los deslizamientos que marcaron? ¿Quién debería tomar decisiones para el mapa que queremos?»</p>
<p><strong>Uso:</strong> el mapa se comparte con el comité escolar de gestión del riesgo para revisar las rutas de evacuación del colegio.</p>',
            ],
            'revisar' => [
                'Que no se exponga información personal ni de seguridad de las familias.',
                'Que los conceptos cartográficos estén bien explicados (la IA confunde escala gráfica y numérica).',
                'Que las rutas de evacuación propuestas se validen con quienes tienen esa responsabilidad, no se adopten solo por el ejercicio escolar.',
            ],
        ],
        [
            'id' => 'SOC-06',
            'categoria' => 'evaluacion',
            'titulo' => 'Ítems tipo Saber 11 de Sociales y Ciudadanas con justificación de distractores',
            'grados' => '10.° y 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Para simulacros y evaluaciones que midan pensamiento social, interpretación y análisis de perspectivas, y pensamiento reflexivo y sistémico.',
            'variables' => [
                '[COMPETENCIA]' => 'Pensamiento social; interpretación y análisis de perspectivas; o pensamiento reflexivo y sistémico.',
                '[TEMA]' => 'Tema (Constitución, conflicto, economía, territorio, derechos, historia).',
                '[N_ITEMS]' => 'Número de ítems.',
                '[CONTEXTO]' => 'Situación colombiana para los ítems (puede ser ficticia pero verosímil).',
            ],
            'prompt' => 'Actúa como constructor de ítems con experiencia en pruebas estandarizadas tipo Saber 11 de Sociales y Ciudadanas del ICFES.

ESPECIFICACIONES
- Competencia: [COMPETENCIA]. Tema: [TEMA]. Número de ítems: [N_ITEMS].
- Contexto: [CONTEXTO].

CRITERIOS POR COMPETENCIA
- Pensamiento social: usar conceptos de las ciencias sociales y de la Constitución para comprender una situación (ej.: identificar qué derecho o mecanismo aplica, qué concepto explica un fenómeno).
- Interpretación y análisis de perspectivas: identificar la perspectiva, los intereses o los supuestos de un actor; comparar posiciones; reconocer qué argumento apoya o contradice una postura.
- Pensamiento reflexivo y sistémico: evaluar usos de fuentes o argumentos, reconocer dimensiones de un problema, anticipar consecuencias de una decisión.

TAREA
Construye [N_ITEMS] ítems de selección múltiple con única respuesta (A a D). Cada uno con un contexto que sea indispensable leer (situación, fragmento de opinión, noticia ficticia verosímil, tabla).

FORMATO (para cada ítem)
- Afirmación y evidencia que mide.
- Contexto, enunciado, opciones.
- Clave y su justificación.
- Justificación de cada distractor: qué razonamiento erróneo lo hace atractivo.
- Dificultad estimada.

RESTRICCIONES
- Los ítems no evalúan opiniones ni valores del estudiante; evalúan razonamiento sobre situaciones sociales.
- No uses nombres reales de políticos actuales ni partidos vigentes; usa actores genéricos (un concejal, una líder comunitaria, un gremio).
- Si citas un artículo de la Constitución de 1991, solo si estás seguro de su contenido; si no, describe el derecho sin número.
- Distractores plausibles; nada de «todas las anteriores».

AUTOVERIFICACIÓN
Resuelve cada ítem como estudiante y confirma que solo una opción es defendible, que el contexto es necesario y que no hay sesgo político en la clave.',
            'seguimientos' => [
                'Haz la tabla de especificaciones del simulacro: ítem, competencia, tema, clave.',
                'Convierte el ítem 1 en una pregunta abierta para discusión en clase.',
                'Escribe la retroalimentación para leer después de la prueba, ítem por ítem.',
            ],
            'ejemplo' => [
                'contexto' => '[COMPETENCIA] interpretación y análisis de perspectivas; [TEMA] ordenamiento territorial y ambiente; [N_ITEMS] 1 (se muestra uno); [CONTEXTO] un municipio de la Orinoquía discute dónde ubicar un nuevo relleno sanitario.',
                'resultado_html' => '<p><strong>Contexto:</strong> En un municipio de Casanare, el concejo debate la ubicación de un relleno sanitario. Una líder de la vereda propuesta afirma: «Nadie nos consultó. Ese terreno está cerca del caño de donde sacamos el agua para el ganado y para la casa». Un funcionario de la alcaldía responde: «El sitio cumple la distancia mínima exigida y es el único terreno disponible que el municipio puede pagar».</p>
<p><strong>Enunciado:</strong> ¿Cuál de los siguientes supuestos está en la base del argumento del funcionario?</p>
<ol type="A"><li>Cumplir los requisitos técnicos y presupuestales es suficiente para justificar la decisión.</li>
<li>La comunidad de la vereda no necesita agua para sus actividades.</li>
<li>Los rellenos sanitarios no generan ningún impacto ambiental.</li>
<li>La líder comunitaria no tiene derecho a opinar sobre el tema.</li></ol>
<p><strong>Clave:</strong> A. El funcionario justifica la decisión solo con criterios técnicos (distancia) y económicos (costo), sin responder al reclamo de participación.</p>
<p><strong>Distractores:</strong> B atribuye al funcionario una afirmación que no hace; C exagera su argumento (él no dice que no haya impacto, sino que cumple la norma); D confunde no responder un reclamo con negar un derecho.</p>',
            ],
            'revisar' => [
                'Resolver los ítems sin mirar la clave.',
                'Que no haya sesgo partidista ni nombres de políticos actuales.',
                'Artículos constitucionales citados: verifíquelos en el texto oficial de la Constitución.',
            ],
        ],
        [
            'id' => 'SOC-07',
            'categoria' => 'evaluacion',
            'titulo' => 'Ítems tipo Saber 5.° y 9.° de pensamiento ciudadano',
            'grados' => '4.° a 9.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Para evaluar y preparar competencias ciudadanas en primaria y básica secundaria con situaciones cercanas a los estudiantes.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[COMPETENCIA]' => 'Conocimientos, argumentación, multiperspectivismo o pensamiento sistémico.',
                '[SITUACION]' => 'Situación escolar o comunitaria (uso de la cancha, elección del personero, basuras en la quebrada, conflicto entre vecinos).',
                '[N_ITEMS]' => 'Número de ítems.',
            ],
            'prompt' => 'Actúa como experto en evaluación de competencias ciudadanas para niños y adolescentes colombianos, conocedor de los Estándares Básicos de Competencias Ciudadanas y de la prueba de pensamiento ciudadano del ICFES.

ESPECIFICACIONES
- Grado: [GRADO]. Competencia: [COMPETENCIA]. Situación: [SITUACION]. Número de ítems: [N_ITEMS].

CRITERIOS
- Conocimientos: derechos, deberes, Constitución, organización del Estado y mecanismos de participación, aplicados a una situación.
- Argumentación: evaluar si una razón apoya o no una afirmación; distinguir opiniones de razones.
- Multiperspectivismo: reconocer cómo ven el problema distintas personas y por qué.
- Pensamiento sistémico: identificar las distintas dimensiones de un problema y las consecuencias de una solución.

TAREA
Construye [N_ITEMS] ítems de selección múltiple con única respuesta (A a D), con un contexto breve y cercano a la vida de un estudiante de [GRADO].

FORMATO
Para cada ítem: competencia, contexto, enunciado, opciones, clave, justificación de la clave y de cada distractor, y una pregunta de conversación para el aula.

RESTRICCIONES
- No evaluar valores ni actitudes personales («¿qué harías tú?» con respuesta moral esperada); evaluar razonamiento.
- Contextos con diversidad (campo y ciudad, distintas regiones y etnias) y sin estereotipos.
- Vocabulario del grado; contextos de máximo 80 palabras para 5.° y 120 para 9.°.

AUTOVERIFICACIÓN
Lee cada ítem como un estudiante de [GRADO] y reemplaza palabras difíciles; confirma que no hay dos respuestas defendibles.',
            'seguimientos' => [
                'Convierte la situación en un dilema para discutir en clase con la técnica de los cuatro rincones.',
                'Haz dos ítems más con la misma situación para otra competencia.',
                'Adapta los ítems con apoyos visuales descritos para estudiantes con PIAR.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 5.°; [COMPETENCIA] multiperspectivismo; [SITUACION] la única cancha del barrio en Riohacha; [N_ITEMS] 1.',
                'resultado_html' => '<p><strong>Contexto:</strong> En un barrio de Riohacha solo hay una cancha. Los jóvenes la usan todas las tardes para jugar fútbol. Las señoras del barrio quieren usarla dos tardes a la semana para hacer ejercicios. Un grupo de niños pequeños dice que nunca les dejan jugar.</p>
<p><strong>Enunciado:</strong> ¿Por qué los niños pequeños piensan distinto de los jóvenes sobre el uso de la cancha?</p>
<ol type="A"><li>Porque los niños pequeños quieren tener un espacio para jugar y casi nunca pueden usarla.</li>
<li>Porque a los niños pequeños no les gusta el fútbol.</li>
<li>Porque los niños pequeños quieren hacer ejercicio con las señoras.</li>
<li>Porque los niños pequeños quieren que cierren la cancha.</li></ol>
<p><strong>Clave:</strong> A. Reconoce el interés del grupo a partir de la información dada.</p>
<p><strong>Distractores:</strong> B, C y D atribuyen a los niños intereses que el texto no menciona.</p>
<p><strong>Pregunta de conversación:</strong> «¿Qué solución tendría en cuenta a los tres grupos?»</p>',
            ],
            'revisar' => [
                'Que el contexto no reproduzca estereotipos sobre la región o sus habitantes.',
                'Que la clave no dependa de un juicio moral.',
                'Que la longitud sea adecuada para la edad.',
            ],
        ],
        [
            'id' => 'SOC-08',
            'categoria' => 'adaptacion',
            'titulo' => 'Un texto de sociales en tres niveles (DUA)',
            'grados' => '3.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Cuando su grupo tiene niveles de lectura muy distintos y quiere que todos trabajen el mismo proceso histórico o geográfico.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[TEXTO_BASE]' => 'Texto original o tema.',
                '[CONCEPTOS_CLAVE]' => 'Conceptos que deben quedar en las tres versiones.',
                '[PERFIL_DEL_GRUPO]' => 'Cómo leen sus estudiantes.',
            ],
            'prompt' => 'Actúa como especialista en Diseño Universal para el Aprendizaje y en divulgación histórica y geográfica para estudiantes colombianos.

CONTEXTO
- Grado: [GRADO]. Perfil lector: [PERFIL_DEL_GRUPO].
- Texto base o tema: [TEXTO_BASE]
- Conceptos clave: [CONCEPTOS_CLAVE].

TAREA
Escribe tres versiones que enseñen los mismos conceptos:
- Versión con apoyos: oraciones cortas, una idea por párrafo, línea de tiempo o mapa sencillo descrito, glosario con imágenes descritas, preguntas intercaladas.
- Versión esperada para el grado.
- Versión de profundización: incluye una fuente o perspectiva adicional y una pregunta de investigación.

FORMATO DE SALIDA
1. Las tres versiones identificadas con símbolos neutros (círculo, triángulo, cuadrado).
2. Cuatro preguntas comunes: literal, inferencial, de perspectiva («¿cómo lo vería...?») y de conexión con el presente.
3. Actividad de cierre conjunta.
4. Tabla de control de conceptos por versión.

RESTRICCIONES
- Simplificar no es distorsionar: ninguna versión puede contener una afirmación histórica falsa ni una narrativa simplista de buenos y malos.
- Mantén la voz y la agencia de los actores (por ejemplo, las comunidades no «fueron ayudadas», actuaron).
- Datos y fechas inciertos marcados con [POR CONFIRMAR].

AUTOVERIFICACIÓN
Compara las tres versiones con la tabla de control y cuenta las palabras de cada una.',
            'seguimientos' => [
                'Haz un guion de audio de 2 minutos de la versión con apoyos.',
                'Crea un organizador gráfico común para las tres versiones.',
                'Agrega a la versión de profundización una pregunta tipo Saber.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.°; [TEXTO_BASE] tema: San Basilio de Palenque; [CONCEPTOS_CLAVE] cimarronaje, palenque, resistencia, lengua palenquera, patrimonio cultural inmaterial; [PERFIL_DEL_GRUPO] 32 estudiantes, 8 con dificultades de lectura, 5 avanzados.',
                'resultado_html' => '<p><strong>Versión círculo:</strong> «Hace más de 400 años, muchas personas africanas fueron traídas a la fuerza a América y esclavizadas. Algunas escaparon. A ellas se les llamó cimarrones. [Imagen descrita: personas caminando hacia los montes.] Los cimarrones construyeron pueblos libres, escondidos en el monte. Esos pueblos se llamaban palenques. Uno de ellos es San Basilio de Palenque, en Bolívar. Allí todavía se habla una lengua propia: el palenquero. Pregunta: ¿por qué crees que los cimarrones construyeron sus pueblos lejos de las ciudades?»</p>
<p><strong>Versión cuadrado:</strong> incluye que la UNESCO declaró el espacio cultural de San Basilio de Palenque obra maestra del patrimonio oral e inmaterial de la humanidad en 2005 (desde 2008 figura en la Lista Representativa del Patrimonio Cultural Inmaterial de la Humanidad), y plantea: «¿Qué papel tuvo el liderazgo de Benkos Biohó según los relatos históricos y la tradición oral? ¿Por qué hay diferencias entre las fuentes?»</p>
<p><strong>Pregunta común de perspectiva:</strong> ¿Cómo contaría la historia del palenque una joven palenquera de hoy?</p>',
            ],
            'revisar' => [
                'Fechas y reconocimientos (UNESCO, leyes) verificados.',
                'Que la versión con apoyos no simplifique en una narrativa de víctimas pasivas.',
                'Lenguaje: «personas esclavizadas» en lugar de «esclavos» cuando se quiera resaltar la condición impuesta.',
            ],
        ],
        [
            'id' => 'SOC-09',
            'categoria' => 'adaptacion',
            'titulo' => 'Ajustes razonables para el PIAR en ciencias sociales',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Al diligenciar o actualizar el PIAR (Decreto 1421 de 2017) para actividades propias del área: lectura de fuentes, mapas, debates, líneas de tiempo, salidas.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[DESCRIPCION_ESTUDIANTE]' => 'Descripción pedagógica: fortalezas, intereses, barreras observadas (sin nombre).',
                '[TIPO_DISCAPACIDAD]' => 'Categoría reportada, si aplica.',
                '[UNIDAD]' => 'Unidad y DBA.',
                '[ACTIVIDADES_PREVISTAS]' => 'Actividades del grupo.',
                '[APOYOS_DISPONIBLES]' => 'Docente de apoyo, familia, tecnología, intérprete.',
            ],
            'prompt' => 'Actúa como docente de apoyo pedagógico con experiencia en educación inclusiva en Colombia, conocedor del Decreto 1421 de 2017, el PIAR y el Diseño Universal para el Aprendizaje, aplicado a ciencias sociales.

CONTEXTO
- Grado: [GRADO]. Unidad: [UNIDAD].
- Descripción pedagógica: [DESCRIPCION_ESTUDIANTE].
- Categoría reportada: [TIPO_DISCAPACIDAD].
- Actividades previstas: [ACTIVIDADES_PREVISTAS].
- Apoyos: [APOYOS_DISPONIBLES].

TAREA
Propón ajustes razonables para esta unidad partiendo de las barreras del contexto.

FORMATO DE SALIDA
1. Barreras en cada actividad prevista.
2. Tabla: Actividad | Barrera | Ajuste razonable | Responsable | Recurso.
3. Propósito de aprendizaje: mismo DBA con ajustes de acceso o flexibilización justificada.
4. Ajustes de evaluación y descripción de desempeños Básico, Alto y Superior para este estudiante.
5. Recomendaciones para la familia.
6. Texto breve para el formato del PIAR (máximo 12 líneas).

RESTRICCIONES
- Sin lenguaje clínico ni diagnósticos; barreras y desempeños observables.
- Ajustes viables en un aula de más de 35 estudiantes.
- Primero ajustes de acceso; flexibilizar el logro solo si es necesario y justificado.
- Ningún ajuste debe aislar al estudiante del grupo.

AUTOVERIFICACIÓN
Cada actividad tiene ajuste, la evaluación mide el mismo concepto que la del grupo o explica por qué no, y el texto para el PIAR no excede 12 líneas.',
            'seguimientos' => [
                'Redacta la guía de la actividad de debate ya ajustada.',
                'Diseña una agenda visual de la unidad para anticipar cada sesión.',
                'Formula los indicadores de seguimiento trimestral del PIAR para el área.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [DESCRIPCION_ESTUDIANTE] estudiante con excelente memoria para fechas y datos, gran interés en mapas, dificultad con cambios imprevistos de rutina, con el ruido de las discusiones grupales y con la interpretación de intenciones de otros; [TIPO_DISCAPACIDAD] trastorno del espectro autista; [UNIDAD] Frente Nacional y conflicto armado; [ACTIVIDADES_PREVISTAS] debate en cuatro esquinas, análisis de caricaturas políticas, ensayo; [APOYOS_DISPONIBLES] docente de apoyo una vez por semana, familia comprometida.',
                'resultado_html' => '<table><tr><th>Actividad</th><th>Barrera</th><th>Ajuste</th></tr>
<tr><td>Debate en cuatro esquinas</td><td>Ruido, cambios rápidos de turno y desplazamientos</td><td>Agenda del debate entregada un día antes; rol de «cronista de argumentos» con rejilla escrita; opción de usar protectores auditivos; ubicación cerca de la puerta.</td></tr>
<tr><td>Análisis de caricaturas</td><td>Interpretar ironía e intenciones implícitas</td><td>Guía con preguntas explícitas en secuencia (¿qué personajes hay?, ¿qué objetos?, ¿qué dice el texto?, ¿qué hecho de la época se relaciona?) antes de preguntar por la intención del autor.</td></tr>
<tr><td>Ensayo</td><td>Organizar un texto argumentativo abierto</td><td>Plantilla con párrafos guiados; puede apoyar su tesis con una línea de tiempo o un mapa elaborado por él.</td></tr></table>
<p><strong>Propósito:</strong> se mantiene el DBA; ajustes de acceso y de formato. Su fortaleza con fechas y mapas se aprovecha como rol valioso para el grupo.</p>',
            ],
            'revisar' => [
                'No compartir con la IA nombres ni información sensible del estudiante.',
                'Coherencia con la valoración pedagógica y con lo acordado con la familia.',
                'Formato y firmas según el procedimiento institucional del PIAR.',
            ],
        ],
        [
            'id' => 'SOC-10',
            'categoria' => 'planeacion',
            'titulo' => 'Cátedra de la Paz: memoria histórica con acción sin daño',
            'grados' => '9.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Para trabajar el conflicto armado, las víctimas y la construcción de paz (Ley 1732 de 2014, Decreto 1038 de 2015) cuidando a los estudiantes, especialmente en territorios afectados por la violencia.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[TERRITORIO]' => 'Municipio y región; si hubo afectación por el conflicto.',
                '[CASO_O_EXPERIENCIA]' => 'Experiencia de memoria, resistencia o reconciliación que quiere trabajar.',
                '[SESIONES]' => 'Número de sesiones.',
                '[CONSIDERACIONES]' => 'Lo que sabe del grupo: víctimas, desplazamiento, familias de excombatientes, tensiones (sin datos identificables).',
            ],
            'prompt' => 'Actúa como pedagogo de la memoria y la paz en Colombia, con experiencia en el enfoque de acción sin daño, en la Cátedra de la Paz y en el uso pedagógico de los informes del Centro Nacional de Memoria Histórica y de la Comisión para el Esclarecimiento de la Verdad.

CONTEXTO
- Grado: [GRADO]. Territorio: [TERRITORIO].
- Caso o experiencia: [CASO_O_EXPERIENCIA].
- Sesiones: [SESIONES].
- Consideraciones del grupo: [CONSIDERACIONES].

TAREA
Diseña una unidad breve que permita comprender el caso, reconocer a las víctimas como sujetos con agencia (no solo como sufrientes), identificar formas de resistencia y construcción de paz, y relacionarlo con el presente.

FORMATO DE SALIDA
1. Principios de acción sin daño aplicados a esta unidad (máximo 6), en forma de acuerdos de aula.
2. Preparación del docente: qué leer, qué evitar, cómo responder si un estudiante se conmueve o revela una experiencia personal, y a quién remitir (orientación escolar, ruta de atención).
3. Secuencia por sesión: propósito, actividad, recurso, preguntas.
4. Énfasis en lenguajes del arte y la memoria (tejidos, música, fotografía, escritura), no en la descripción de la violencia.
5. Producto final que honre la memoria y mire hacia el futuro.
6. Evaluación formativa centrada en la comprensión y la reflexión, no en la opinión política del estudiante.

RESTRICCIONES
- Nada de imágenes o relatos explícitos de violencia; nada de pedir a los estudiantes que narren experiencias propias de violencia.
- No equipares ni justifiques las acciones de ningún actor armado; nombra a los responsables cuando esté documentado por fuentes oficiales o judiciales, sin especular.
- Lenguaje no estigmatizante con víctimas, excombatientes, comunidades y regiones.
- No inventes cifras, testimonios ni citas de informes; si no conoces el contenido exacto de un informe, indica qué capítulo o tipo de documento debería consultar el docente.
- Marca con [POR CONFIRMAR] fechas y datos del caso.

AUTOVERIFICACIÓN
Revisa cada actividad con la pregunta: ¿podría esto causar daño a un estudiante que vivió el conflicto? Ajusta lo que sea necesario y reporta los cambios.',
            'seguimientos' => [
                'Escribe el protocolo de una página para el docente si un estudiante revela una situación de violencia.',
                'Diseña la carta de invitación a una organización de víctimas o a un colectivo de memoria del territorio.',
                'Propón cómo exhibir el producto final en la institución respetando la privacidad.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [TERRITORIO] María la Baja, Bolívar, en los Montes de María, región afectada por el conflicto; [CASO_O_EXPERIENCIA] las mujeres tejedoras de Mampuján, que después del desplazamiento narraron su historia en tapices; [SESIONES] 4; [CONSIDERACIONES] hay estudiantes de familias desplazadas y la región vive procesos de reparación.',
                'resultado_html' => '<p><strong>Acuerdos de aula:</strong> nadie está obligado a contar su historia; hablamos de los hechos con respeto y sin detalles de violencia; cuidamos la palabra del otro; lo que se comparte en clase se queda en clase; cualquier persona puede salir un momento si lo necesita.</p>
<p><strong>Sesión 2:</strong> observación de fotografías de los tapices de Mampuján. Preguntas: «¿Qué colores y escenas eligieron las tejedoras? ¿Por qué creen que decidieron contar su historia tejiendo y no solo hablando? ¿Qué partes de la historia de su pueblo aparecen además del desplazamiento?»</p>
<p><strong>Dato de contexto para el docente:</strong> las tejedoras de Mampuján recibieron el Premio Nacional de Paz en 2015; la sentencia del caso Mampuján (Tribunal Superior de Bogotá, Sala de Justicia y Paz, 2010) fue la primera dictada en aplicación de la Ley de Justicia y Paz (Ley 975 de 2005) e incluyó medidas de reparación colectiva.</p>
<p><strong>Producto final:</strong> un tapiz colectivo de papel o tela sobre «lo que queremos cuidar de nuestro territorio».</p>',
            ],
            'revisar' => [
                'Datos del caso con fuentes oficiales (Centro Nacional de Memoria Histórica, Comisión de la Verdad, sentencias).',
                'Coordinar con orientación escolar antes de iniciar.',
                'Conocer el contexto del grupo para anticipar reacciones, sin exponer a nadie.',
                'Que no haya juicios sobre actores políticos actuales.',
            ],
        ],
        [
            'id' => 'SOC-11',
            'categoria' => 'planeacion',
            'titulo' => 'Cátedra de la Paz en primaria: emociones, conflictos y acuerdos',
            'grados' => 'Transición a 5.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Cuando hay conflictos frecuentes en el aula o quiere desarrollar competencias ciudadanas de convivencia con actividades lúdicas.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[SITUACION]' => 'Conflicto frecuente del grupo (turnos en el juego, burlas, apodos, exclusión, peleas en el descanso).',
                '[SESIONES]' => 'Número de sesiones cortas.',
                '[DURACION]' => 'Duración de cada sesión.',
            ],
            'prompt' => 'Actúa como maestra de primaria experta en educación socioemocional, competencias ciudadanas y Cátedra de la Paz en Colombia, conocedora de la Ley 1620 de 2013 sobre convivencia escolar.

CONTEXTO
- Grado: [GRADO]. Situación frecuente: [SITUACION].
- Sesiones: [SESIONES] de [DURACION].

TAREA
Diseña una serie de sesiones para que los niños: reconozcan sus emociones y las de los demás, comprendan el conflicto como algo que se puede transformar, practiquen la escucha y construyan acuerdos.

FORMATO DE SALIDA
1. Para cada sesión: propósito, actividad lúdica (juego, cuento, dramatización, arte), preguntas para conversar y cierre.
2. Un cuento corto (máximo 250 palabras) con personajes y escenario colombianos que represente la situación sin señalar a nadie del grupo.
3. Herramienta de aula concreta (por ejemplo, rincón de la calma, ruta de pasos para resolver un conflicto, semáforo de emociones) con instrucciones.
4. Acuerdos de aula construidos con los niños: cómo facilitarlos.
5. Observación para la docente: indicadores de avance.
6. Mensaje para las familias.

RESTRICCIONES
- No exponer ni culpar a niños concretos.
- Evitar castigos como estrategia; enfoque restaurativo.
- Lenguaje sencillo, positivo y concreto.
- Si la situación pudiera constituir acoso escolar, indica que debe activarse la ruta de atención integral del colegio.

AUTOVERIFICACIÓN
Revisa que cada sesión sea realizable en [DURACION] y que la herramienta de aula sea comprensible para niños de [GRADO].',
            'seguimientos' => [
                'Diseña los carteles de la ruta para resolver conflictos con dibujos descritos.',
                'Crea una canción o retahíla corta con los pasos de la ruta.',
                'Propón cómo hacer seguimiento semanal de los acuerdos con los niños.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 2.°; [SITUACION] peleas por el turno en los columpios y apodos en el descanso; [SESIONES] 4; [DURACION] 40 minutos.',
                'resultado_html' => '<p><strong>Cuento:</strong> «Mateo y Yuliana en el columpio de La Ceja». Dos niños quieren el único columpio; Mateo empuja y Yuliana le pone un apodo. Ambos terminan llorando. Una abuela que pasa les pregunta: «¿Qué sintió cada uno? ¿Qué necesitaba cada uno?».</p>
<p><strong>Ruta «Paro, pienso, hablo, acordamos»:</strong> 1. Paro y respiro tres veces. 2. Pienso qué siento y qué necesito. 3. Hablo sin gritar: «Yo me siento... cuando... porque...». 4. Acordamos una solución en la que los dos ganen (turnos con conteo hasta 50, jugar juntos).</p>
<p><strong>Indicadores:</strong> nombra al menos tres emociones; usa la frase «yo me siento...» en un conflicto; propone una solución que tenga en cuenta al otro.</p>',
            ],
            'revisar' => [
                'Que los nombres de los personajes no coincidan con niños del grupo.',
                'Que la ruta sea coherente con el manual de convivencia y la ruta institucional.',
                'Identificar si alguna situación requiere activar la ruta de atención.',
            ],
        ],
        [
            'id' => 'SOC-12',
            'categoria' => 'planeacion',
            'titulo' => 'Exploración del entorno social: familia, barrio, oficios y normas',
            'grados' => 'Transición a 3.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Para que los niños pequeños exploren su comunidad y construyan nociones de tiempo, espacio, trabajo y convivencia desde la experiencia.',
            'variables' => [
                '[GRADO]' => 'Transición, 1.°, 2.° o 3.°.',
                '[ENTORNO]' => 'Barrio o vereda, municipio y región.',
                '[TEMA]' => 'Familia, oficios, lugares del barrio, normas, cambios en el tiempo, de dónde viene la comida.',
                '[DURACION]' => 'Duración y número de sesiones.',
            ],
            'prompt' => 'Actúa como maestra de educación inicial y primaria en Colombia, experta en la exploración del medio social y en el desarrollo de nociones de tiempo y espacio en la infancia.

CONTEXTO
- Grado: [GRADO]. Entorno: [ENTORNO]. Tema: [TEMA]. Duración: [DURACION].

TAREA
Diseña una experiencia de exploración del entorno social con provocación, exploración (salida corta, visita de un invitado o juego de roles) y registro.

FORMATO DE SALIDA
1. Provocación: objeto, foto, canción o cuento, con el texto que dirá la docente.
2. Exploración: actividad principal, preguntas abiertas, qué observar de cada niño.
3. Juego de roles o rincón que recree el tema (la tienda, la plaza de mercado, la finca).
4. Registro adecuado a la edad: dibujos, plano sencillo del recorrido, línea de tiempo con fotos, entrevista con dibujos.
5. Indicadores observables de aprendizaje.
6. Tarea con la familia (sin costo, 10 minutos).

RESTRICCIONES
- Representar la diversidad de familias (monoparentales, con abuelos, extendidas, de distintas regiones y etnias) sin juicios.
- No preguntar datos sensibles de las familias (ingresos, situación migratoria, conflicto).
- Nada de fichas de transcripción.
- Salidas solo con autorización y acompañamiento adecuado.

AUTOVERIFICACIÓN
Confirma que la experiencia es viable en el tiempo, que es inclusiva con todas las familias y que los indicadores son observables.',
            'seguimientos' => [
                'Escribe una canción o rima sobre los oficios del barrio con ritmo regional.',
                'Diseña un plano sencillo del recorrido para que los niños lo completen con dibujos.',
                'Propón cómo invitar a un padre o madre a contar su oficio en 10 minutos.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 1.°; [ENTORNO] barrio del suroccidente de Barranquilla, Atlántico; [TEMA] los oficios del barrio; [DURACION] 3 sesiones de 50 minutos.',
                'resultado_html' => '<p><strong>Provocación:</strong> la docente trae en una bolsa un bollo de yuca, un candado, una tijera y una libreta de fiado. «Estas cosas son de personas que trabajan en nuestro barrio. ¿De quién será cada una?»</p>
<p><strong>Exploración:</strong> recorrido de dos cuadras con dos acudientes; visita a la tienda, a la peluquería y al taller de motos (con permiso previo). Cada grupo hace una pregunta al trabajador: «¿Qué es lo que más le gusta de su trabajo? ¿Qué herramienta usa más?».</p>
<p><strong>Rincón:</strong> la tienda del barrio con empaques reutilizados, billetes de papel y libreta de fiado.</p>
<p><strong>Indicador:</strong> nombra al menos tres oficios del barrio y explica para qué sirven a la comunidad.</p>',
            ],
            'revisar' => [
                'Permisos de la salida y de las personas visitadas.',
                'Que no se jerarquicen los oficios (todos son valiosos).',
                'Que las tareas familiares no generen gastos.',
            ],
        ],
        [
            'id' => 'SOC-13',
            'categoria' => 'recursos',
            'titulo' => 'Relato sobre diversidad étnica y cultural sin estereotipos',
            'grados' => 'Transición a 7.°',
            'tiempo_ahorrado' => '≈ 45 min',
            'cuando' => 'Para trabajar la diversidad étnica y cultural de Colombia (Constitución de 1991, Cátedra de Estudios Afrocolombianos) con un relato que evite el folclorismo y los estereotipos.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[GRUPO_O_CULTURA]' => 'Pueblo, comunidad o región protagonista.',
                '[MENSAJE]' => 'Concepto o valor a trabajar (identidad, lengua, territorio, migración interna, discriminación).',
                '[EXTENSION]' => 'Número de palabras.',
            ],
            'prompt' => 'Actúa como escritor de literatura infantil y juvenil colombiano con formación en estudios culturales y en educación intercultural.

CONTEXTO
- Grado: [GRADO]. Protagonista de la comunidad o región: [GRUPO_O_CULTURA].
- Concepto a trabajar: [MENSAJE]. Extensión: [EXTENSION] palabras.

TAREA
Escribe un relato con un protagonista de [GRUPO_O_CULTURA] que viva en el presente, con una vida cotidiana actual (estudia, usa tecnología, tiene amigos, gustos, problemas comunes) y con rasgos culturales propios presentados con naturalidad.

FORMATO DE SALIDA
1. Título y relato, en escenas con descripción de ilustraciones.
2. Ficha cultural para el docente: datos verificables sobre la comunidad (ubicación, lengua, organización), con [POR CONFIRMAR] donde dependa de la fuente.
3. Lista de estereotipos que evitaste y cómo.
4. Cinco preguntas de conversación, incluida una sobre la experiencia de los estudiantes con la diversidad.

RESTRICCIONES
- Nada de presentar a la comunidad solo en el pasado, solo con trajes de fiesta, solo bailando o solo como pobre.
- No atribuir prácticas espirituales o rituales sin certeza; si no estás seguro, no lo incluyas.
- No usar palabras en lengua propia que no puedas garantizar como correctas.
- El conflicto del relato debe resolverse por la acción del protagonista, no por un «salvador» externo.

AUTOVERIFICACIÓN
Revisa el relato frente a la lista de estereotipos y confirma que cada dato cultural es verificable o está marcado.',
            'seguimientos' => [
                'Adapta el relato para lectura en voz alta con preguntas de predicción.',
                'Escribe la versión del mismo relato contada por el amigo del protagonista.',
                'Propón cómo validar el relato con una persona de la comunidad.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 3.°; [GRUPO_O_CULTURA] niño raizal de San Andrés que llega a estudiar a Bogotá; [MENSAJE] identidad y lengua; [EXTENSION] 450 palabras.',
                'resultado_html' => '<p><strong>Título:</strong> «Kendall y las dos lenguas».</p>
<p><strong>Escena 1:</strong> «Kendall nunca había sentido tanto frío. En San Andrés, el mar estaba a cinco minutos de su casa; en Bogotá, el colegio estaba a cuarenta minutos en bus. El primer día, un compañero le preguntó: “¿Tú eres de otro país?”. Kendall sonrió: “Soy colombiano, de San Andrés. En mi casa hablamos español, inglés y creole”.» (Ilustración: Kendall con chaqueta grande en el bus, mirando por la ventana.)</p>
<p><strong>Estereotipos evitados:</strong> el protagonista no es presentado como extranjero ni como exótico; no se reduce la cultura raizal al reggae o a la playa; su lengua es un motivo de orgullo y un saber, no un problema.</p>
<p><strong>Ficha:</strong> el pueblo raizal habita el archipiélago de San Andrés, Providencia y Santa Catalina; su lengua criolla, de base inglesa, es reconocida como lengua nativa en Colombia por la Ley 1381 de 2010 (Ley de Lenguas Nativas).</p>',
            ],
            'revisar' => [
                'Validar el relato con una persona de la comunidad cuando sea posible.',
                'Datos culturales y lingüísticos verificados.',
                'Que el relato no reproduzca el estereotipo opuesto (la comunidad perfecta e idealizada).',
            ],
        ],
        [
            'id' => 'SOC-14',
            'categoria' => 'gestion',
            'titulo' => 'Gobierno escolar: elección de personero y proyecto de democracia',
            'grados' => '1.° a 11.°',
            'tiempo_ahorrado' => '≈ 3 h',
            'cuando' => 'Al organizar el proceso de gobierno escolar al inicio del año: pedagogía electoral, candidatos, debates, votaciones y seguimiento de propuestas.',
            'variables' => [
                '[INSTITUCION]' => 'Tipo de institución, sedes, número de estudiantes y jornadas.',
                '[CRONOGRAMA]' => 'Fechas disponibles según el calendario escolar.',
                '[CARGOS]' => 'Cargos a elegir (personero, representante al consejo directivo, consejo estudiantil, contralor si aplica en su entidad territorial).',
                '[RECURSOS]' => 'Recursos (tarjetones impresos, computadores, urnas).',
            ],
            'prompt' => 'Actúa como docente coordinador del proyecto de democracia escolar en Colombia, conocedor de la Ley 115 de 1994 y del Decreto 1860 de 1994 sobre el gobierno escolar y el personero de los estudiantes.

CONTEXTO
- Institución: [INSTITUCION].
- Cargos a elegir: [CARGOS].
- Fechas disponibles: [CRONOGRAMA]. Recursos: [RECURSOS].

TAREA
Diseña el proceso completo de gobierno escolar como experiencia pedagógica, no solo como trámite.

FORMATO DE SALIDA
1. Cronograma: Fecha | Actividad | Responsables | Producto. Indica que los plazos legales deben verificarse con la norma vigente y el manual de convivencia.
2. Pedagogía electoral por niveles: una actividad para primaria, una para 6.° a 9.° y una para la media (qué es representar, qué es una propuesta viable, cómo se vota).
3. Requisitos y funciones de cada cargo, redactados para estudiantes, con la indicación de verificarlos en la norma y el manual.
4. Guía para candidatos: cómo formular propuestas viables (dentro de las funciones del cargo, con recursos y tiempos), con ejemplos de propuestas viables e inviables.
5. Formato de debate entre candidatos con preguntas de los estudiantes.
6. Protocolo de jornada electoral: jurados, testigos, conteo, actas.
7. Mecanismo de rendición de cuentas a mitad de año.

RESTRICCIONES
- No inventes requisitos legales; cuando cites la norma, indica que debe verificarse.
- Propuestas evaluadas por viabilidad, no por popularidad.
- Inclusión de estudiantes con discapacidad como votantes y candidatos (ajustes en tarjetones y en debates).

AUTOVERIFICACIÓN
Revisa que el cronograma sea coherente, que cada cargo tenga funciones claras y que haya rendición de cuentas.',
            'seguimientos' => [
                'Diseña el tarjetón accesible (con fotos, colores y opción para baja visión).',
                'Escribe el acta de escrutinio modelo.',
                'Crea la rúbrica para que los estudiantes evalúen la viabilidad de las propuestas.',
            ],
            'ejemplo' => [
                'contexto' => '[INSTITUCION] institución oficial de Neiva, Huila, 3 sedes, 2.100 estudiantes, dos jornadas; [CARGOS] personero, representante de estudiantes al consejo directivo, consejo estudiantil; [CRONOGRAMA] febrero y marzo; [RECURSOS] tarjetones impresos y urnas de cartón.',
                'resultado_html' => '<p><strong>Propuesta viable vs. inviable (guía para candidatos):</strong></p>
<table><tr><th>Inviable</th><th>Por qué</th><th>Viable</th></tr>
<tr><td>«Quitaré las tareas los viernes.»</td><td>No es función del personero decidir sobre la evaluación.</td><td>«Haré una encuesta sobre la carga de tareas y presentaré los resultados al consejo académico.»</td></tr>
<tr><td>«Pondré piscina en el colegio.»</td><td>Requiere recursos que no maneja el gobierno escolar.</td><td>«Gestionaré con la alcaldía el préstamo del polideportivo una tarde al mes.»</td></tr></table>
<p><strong>Pedagogía electoral en primaria:</strong> elección del «nombre de la mascota del curso» con tarjetón, urna y conteo público, para comprender el voto secreto y la regla de la mayoría.</p>
<p><strong>Rendición de cuentas:</strong> en junio, el personero presenta avances ante el consejo estudiantil con evidencias.</p>',
            ],
            'revisar' => [
                'Requisitos, funciones y plazos del gobierno escolar en la norma vigente y el manual de convivencia.',
                'Lineamientos de su secretaría de educación (algunas entidades exigen figuras adicionales como el contralor estudiantil).',
                'Accesibilidad del proceso.',
            ],
        ],
        [
            'id' => 'SOC-15',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Retroalimentación de ensayos y textos argumentativos de sociales',
            'grados' => '8.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h por curso',
            'cuando' => 'Cuando tiene muchos ensayos o párrafos argumentativos y quiere devolver comentarios que mejoren la tesis, el uso de evidencias y la consideración de otras perspectivas.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PREGUNTA]' => 'Pregunta o tema del ensayo.',
                '[CRITERIOS]' => 'Rúbrica o criterios.',
                '[TEXTO]' => 'Texto del estudiante (sin nombre).',
                '[CONTENIDOS_TRABAJADOS]' => 'Lo que se trabajó en clase (para no exigir lo que no se enseñó).',
            ],
            'prompt' => 'Actúa como docente de ciencias sociales experto en argumentación histórica y en retroalimentación formativa (¿hacia dónde voy?, ¿cómo voy?, ¿qué sigue?).

CONTEXTO
- Grado: [GRADO]. Pregunta del ensayo: [PREGUNTA].
- Criterios: [CRITERIOS].
- Contenidos trabajados en clase: [CONTENIDOS_TRABAJADOS].
- Texto del estudiante:
"""
[TEXTO]
"""

TAREA
1. Analiza: tesis (¿responde la pregunta y es discutible?), argumentos, evidencias históricas (¿precisas, pertinentes, contextualizadas?), consideración de otras perspectivas, conclusión.
2. Detecta errores históricos o conceptuales y anacronismos.
3. Escribe la retroalimentación.

FORMATO DE SALIDA
A. Para el docente: diagnóstico por criterio con nivel (Superior, Alto, Básico, Bajo) y cita textual del ensayo que lo justifica; lista de errores factuales con su corrección.
B. Para el estudiante (máximo 160 palabras, segunda persona, tono cálido y exigente): dos fortalezas concretas, una o dos preguntas que lo hagan mejorar su argumento, una acción concreta para la reescritura.

RESTRICCIONES
- No evalúes la postura política del estudiante; evalúa la calidad del argumento.
- No reescribas el ensayo.
- No exijas contenidos que no estén en [CONTENIDOS_TRABAJADOS].
- Si detectas un error factual, señálalo con una pista para que lo verifique.

AUTOVERIFICACIÓN
Confirma que cada valoración tiene cita del texto, que la parte B no supera 160 palabras y que no hay juicio sobre la ideología del estudiante.',
            'seguimientos' => [
                'Haz lo mismo con estos 6 ensayos y al final dame los 3 problemas más frecuentes del curso: [TEXTOS].',
                'Diseña una minilección de 15 minutos sobre el problema más frecuente.',
                'Crea un banco de conectores y frases para introducir contraargumentos.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.°; [PREGUNTA] ¿Fue el Frente Nacional una solución o un problema para la democracia colombiana?; [CRITERIOS] tesis, evidencias, perspectivas, conclusión; [TEXTO] «El Frente Nacional fue un problema porque los liberales y conservadores se repartieron el poder y no dejaron participar a nadie más, por eso nacieron las FARC, el ELN y el M-19 al mismo tiempo. Fue una dictadura.»; [CONTENIDOS_TRABAJADOS] violencia bipartidista, pacto de Benidorm y Sitges, alternación y paridad, surgimiento de guerrillas.',
                'resultado_html' => '<p><strong>Para el docente:</strong> Tesis: Básico (responde, pero sin matices). Evidencias: Básico (menciona la exclusión, pero no la alternación ni la paridad). Perspectivas: Bajo (no considera que el pacto redujo la violencia bipartidista). Errores: «al mismo tiempo» es impreciso (las guerrillas surgen en momentos y por causas distintas, en los años sesenta y setenta); «dictadura» es un uso inadecuado del concepto para un régimen con elecciones, aunque restringido.</p>
<p><strong>Para el estudiante:</strong> «Tomaste una posición clara y la conectaste con la exclusión política, que es un argumento central. Ahora, pregúntate: ¿por qué los dos partidos firmaron ese pacto en 1957? ¿Qué estaba pasando en el país? Revisa también la palabra “dictadura”: ¿hubo elecciones durante el Frente Nacional? ¿Qué diferencia hay entre un régimen restringido y una dictadura? Para la reescritura, agrega un párrafo que presente el mejor argumento a favor del Frente Nacional y responde a él.»</p>',
            ],
            'revisar' => [
                'Que la IA no haya introducido errores al «corregir» datos históricos.',
                'Que no haya juicios sobre la postura política del estudiante.',
                'Anonimizar los textos.',
            ],
        ],
        [
            'id' => 'SOC-16',
            'categoria' => 'evaluacion',
            'titulo' => 'Rúbrica analítica de sociales con la escala del Decreto 1290',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Para evaluar productos del área (ensayo, mapa, línea de tiempo, exposición, debate, proyecto de investigación) con criterios claros conocidos desde el inicio.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PRODUCTO]' => 'Producto.',
                '[EVIDENCIA]' => 'Evidencia o DBA que el producto demuestra.',
                '[ESCALA_INSTITUCIONAL]' => 'Rangos numéricos de su SIEE.',
                '[N_CRITERIOS]' => 'Número de criterios.',
            ],
            'prompt' => 'Actúa como experto en evaluación de aprendizajes en ciencias sociales en Colombia, conocedor del Decreto 1290 de 2009.

CONTEXTO
- Grado: [GRADO]. Producto: [PRODUCTO].
- Evidencia que debe demostrar: [EVIDENCIA].
- Escala del SIEE: [ESCALA_INSTITUCIONAL].

TAREA
Construye una rúbrica analítica de [N_CRITERIOS] criterios con niveles Superior, Alto, Básico y Bajo.

REGLAS
1. Al menos el 60 % del peso en habilidades de pensamiento social (uso de fuentes, ubicación espacio-temporal, causalidad, perspectivas, argumentación) y no en presentación.
2. Descriptores observables que se diferencien por calidad, sin adverbios vacíos.
3. Básico describe lo mínimo para dar por alcanzada la evidencia.
4. Pesos porcentuales que sumen 100 %.

FORMATO DE SALIDA
1. Tabla: Criterio (peso) | Superior | Alto | Básico | Bajo.
2. Versión para estudiantes en primera persona.
3. Conversión a la escala numérica del SIEE.

AUTOVERIFICACIÓN
Revisa que los niveles no se traslapen, que los pesos sumen 100 % y que la rúbrica mida [EVIDENCIA].',
            'seguimientos' => [
                'Aplica la rúbrica a este trabajo y justifica cada nivel con evidencias: [TRABAJO].',
                'Conviértela en lista de cotejo para coevaluación entre pares.',
                'Hazla con íconos para 3.°.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.°; [PRODUCTO] infografía sobre las migraciones internas en Colombia en el siglo XX; [EVIDENCIA] explica causas y consecuencias de las migraciones del campo a la ciudad; [ESCALA_INSTITUCIONAL] Superior 4,6 a 5,0; Alto 4,0 a 4,5; Básico 3,0 a 3,9; Bajo 1,0 a 2,9; [N_CRITERIOS] 4.',
                'resultado_html' => '<table><tr><th>Criterio</th><th>Superior</th><th>Alto</th><th>Básico</th><th>Bajo</th></tr>
<tr><td>Causas múltiples (30 %)</td><td>Explica causas económicas, políticas (violencia) y sociales, y cómo se relacionan entre sí.</td><td>Explica causas de al menos dos dimensiones.</td><td>Menciona causas de una sola dimensión.</td><td>Menciona causas sin explicarlas o con errores.</td></tr>
<tr><td>Uso de datos (25 %)</td><td>Usa datos con fuente y año, y los interpreta.</td><td>Usa datos con fuente.</td><td>Usa datos sin fuente o sin interpretarlos.</td><td>No usa datos o son incorrectos.</td></tr></table>
<p><strong>Versión estudiante:</strong> «Yo explico por qué la gente se fue del campo a la ciudad desde más de una causa.»</p>',
            ],
            'revisar' => [
                'Rangos exactos del SIEE.',
                'Coherencia con lo enseñado.',
                'Socializar la rúbrica antes del trabajo.',
            ],
        ],
        [
            'id' => 'SOC-17',
            'categoria' => 'recursos',
            'titulo' => 'Caso de economía local: precios, mercados y cadenas de valor',
            'grados' => '8.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Para enseñar conceptos económicos (oferta, demanda, intermediación, costos, inflación, comercio internacional) con productos que los estudiantes conocen.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PRODUCTO]' => 'Producto o actividad económica local (papa, café, cacao, arroz, pesca, plátano, turismo, moto-taxismo).',
                '[REGION]' => 'Región.',
                '[CONCEPTOS]' => 'Conceptos económicos a trabajar.',
                '[DATOS]' => 'Datos reales que tenga (precios, entrevistas) o pida datos ficticios marcados.',
            ],
            'prompt' => 'Actúa como economista y docente de ciencias económicas y políticas en educación media en Colombia, con experiencia en economía campesina y regional.

CONTEXTO
- Grado: [GRADO]. Producto: [PRODUCTO] en [REGION].
- Conceptos: [CONCEPTOS].
- Datos disponibles: [DATOS] (si no hay, usa datos ilustrativos y escribe «datos ficticios con fines didácticos»).

TAREA
Diseña un estudio de caso que recorra la cadena de valor del producto desde quien lo produce hasta quien lo consume.

FORMATO DE SALIDA
1. Mapa de la cadena: eslabones (productor, acopiador, transportador, mayorista, minorista, consumidor; exportador si aplica) con qué hace cada uno y qué riesgos asume.
2. Explicación de cada concepto de [CONCEPTOS] aplicado al caso.
3. Ejercicio con datos: cómo se forma el precio en cada eslabón y qué parte del precio final recibe el productor.
4. Factores externos: clima, costos de insumos, tasa de cambio, importaciones, vías, conflicto, políticas públicas.
5. Actividad de investigación: guía de entrevista a un productor o comerciante local y a un consumidor.
6. Pregunta de debate con perspectivas (productor, consumidor, intermediario, Estado).

RESTRICCIONES
- No demonices a ningún eslabón; explica qué función cumple y qué problemas genera.
- Precios reales solo si los entregué o si puedes indicar la fuente (DANE, SIPSA, gremios); si no, datos ficticios marcados.
- Distingue descripción económica de juicio político.

AUTOVERIFICACIÓN
Revisa que los cálculos sean correctos, que los porcentajes sumen y que los datos ficticios estén marcados.',
            'seguimientos' => [
                'Haz una versión con gráfica de oferta y demanda explicada paso a paso.',
                'Crea dos ítems tipo Saber 11 de pensamiento sistémico con el caso.',
                'Propón cómo los estudiantes pueden consultar precios mayoristas reales en un sistema público de información de precios.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.°; [PRODUCTO] papa; [REGION] altiplano cundiboyacense; [CONCEPTOS] oferta y demanda, intermediación, costos de producción, protesta social; [DATOS] no disponibles, se usan datos ficticios.',
                'resultado_html' => '<p><strong>Datos ficticios con fines didácticos:</strong></p>
<table><tr><th>Eslabón</th><th>Precio por kilo</th><th>Lo que agrega</th></tr>
<tr><td>Productor en Ventaquemada</td><td>800 pesos</td><td>Cultiva, asume riesgo de clima y plagas</td></tr>
<tr><td>Acopiador</td><td>1.100 pesos</td><td>Recoge en finca, transporta a la central</td></tr>
<tr><td>Central de abastos</td><td>1.500 pesos</td><td>Distribuye a tiendas y supermercados</td></tr>
<tr><td>Tienda en Bogotá</td><td>2.400 pesos</td><td>Venta al detal, arriendo, pérdida por daño</td></tr></table>
<p><strong>Pregunta:</strong> el productor recibe aproximadamente el 33 % del precio final. ¿Es necesariamente injusto? ¿Qué costos y riesgos tiene cada eslabón?</p>
<p><strong>Factor externo:</strong> cuando muchos productores cosechan al tiempo, la oferta crece y el precio cae, a veces por debajo del costo de producción. Este tipo de situaciones estuvo entre las razones del paro agrario de 2013, en el que los productores de papa de Boyacá tuvieron un papel visible.</p>',
            ],
            'revisar' => [
                'Que los datos ficticios no se presenten como reales.',
                'Cálculos de porcentajes.',
                'Hechos históricos recientes mencionados.',
            ],
        ],
        [
            'id' => 'SOC-18',
            'categoria' => 'recursos',
            'titulo' => 'Verificación de información y desinformación en temas sociales',
            'grados' => '7.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 15 min',
            'cuando' => 'Cuando circula una cadena, un video o una noticia sobre un tema social (migración, elecciones, conflicto, economía) y quiere que los estudiantes aprendan a verificar antes de compartir.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[AFIRMACION]' => 'Afirmación viral o tipo de contenido (sin reproducir discursos de odio).',
                '[TEMA]' => 'Tema social de fondo.',
                '[RECURSOS]' => 'Acceso a internet o no.',
            ],
            'prompt' => 'Actúa como docente de ciencias sociales y alfabetización mediática, experto en técnicas de verificación (lectura lateral, búsqueda de la fuente original, verificación de imágenes, distinción entre hecho, dato y opinión).

CONTEXTO
- Grado: [GRADO]. Tema: [TEMA].
- Afirmación o contenido que circula: [AFIRMACION]
- Recursos: [RECURSOS].

TAREA
Diseña una clase de verificación en la que los estudiantes analicen la afirmación y aprendan un método replicable.

FORMATO DE SALIDA
1. Método en 5 pasos con preguntas para el estudiante (¿quién lo dice?, ¿cuál es la fuente original?, ¿qué dicen otras fuentes confiables?, ¿los datos dicen eso realmente?, ¿qué emoción busca provocar?).
2. Fuentes institucionales colombianas pertinentes para verificar [TEMA] (indica la entidad, no cifras que no puedas garantizar) y medios dedicados a la verificación de datos.
3. Aplicación del método a la afirmación: qué se puede verificar, qué no, y qué tipo de dato se necesitaría.
4. Análisis del lenguaje: palabras cargadas, generalizaciones, estigmatización de grupos.
5. Actividad para que los estudiantes verifiquen otro contenido por equipos.
6. Versión sin internet: tarjetas con fuentes impresas preparadas por el docente.

RESTRICCIONES
- No afirmes si la afirmación es verdadera o falsa con cifras que no puedas respaldar; enseña el proceso y señala qué datos oficiales deben consultarse.
- No reproduzcas ni amplifiques discursos de odio; cuando la afirmación estigmatice a un grupo (migrantes, comunidades étnicas, regiones), analiza el mecanismo del estigma.
- Neutralidad política: el método debe aplicarse igual a contenidos de cualquier tendencia.

AUTOVERIFICACIÓN
Revisa que no hayas dado por ciertas cifras no verificadas y que el método sirva para otros casos.',
            'seguimientos' => [
                'Crea una lista de cotejo de bolsillo para verificar antes de compartir.',
                'Diseña tres ítems tipo Saber 11 de pensamiento reflexivo sobre el uso de fuentes.',
                'Propón una campaña escolar de verificación para las familias.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [AFIRMACION] cadena de mensajería que atribuye el aumento de robos en una ciudad a los migrantes venezolanos, con una tabla sin fuente; [TEMA] migración y seguridad; [RECURSOS] sala de sistemas con internet.',
                'resultado_html' => '<p><strong>Paso 2, la fuente original:</strong> la tabla no dice de dónde salen los datos ni de qué año son. Pregunta para el estudiante: «Si no sabemos quién contó esos casos ni cómo, ¿podemos sacar conclusiones?».</p>
<p><strong>Fuentes para verificar:</strong> datos de criminalidad publicados por la Policía Nacional y la Fiscalía; datos de población migrante de Migración Colombia; análisis de medios de verificación de datos colombianos.</p>
<p><strong>Análisis del lenguaje:</strong> la cadena habla de «los venezolanos» como si fueran un grupo homogéneo; atribuye a toda una población la conducta de algunas personas. Pregunta: «¿Qué pasaría si alguien hiciera lo mismo con los habitantes de tu región?».</p>
<p><strong>Conclusión esperada del proceso:</strong> con la información disponible no se puede afirmar una relación causal; para analizarla se necesitarían datos comparables por población y por periodo, de fuentes oficiales.</p>',
            ],
            'revisar' => [
                'Que el material no repita el contenido estigmatizante sin análisis crítico.',
                'Que las fuentes sugeridas existan y sean las competentes.',
                'Cuidar a estudiantes migrantes del grupo durante la discusión.',
            ],
        ],
        [
            'id' => 'SOC-19',
            'categoria' => 'evaluacion',
            'titulo' => 'Taller de interpretación de datos sociales y demográficos',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 15 min',
            'cuando' => 'Para fortalecer la lectura de tablas, gráficas, pirámides de población y mapas temáticos, que aparecen con frecuencia en Saber.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[FENOMENO]' => 'Fenómeno (urbanización, pirámide poblacional, migración, pobreza, cobertura educativa, uso del suelo).',
                '[DATOS]' => 'Datos reales (pegue la tabla) o pida datos aproximados marcados.',
                '[N_PREGUNTAS]' => 'Número de preguntas.',
            ],
            'prompt' => 'Actúa como docente de ciencias sociales especialista en geografía de la población y alfabetización estadística.

CONTEXTO
- Grado: [GRADO]. Fenómeno: [FENOMENO].
- Datos: [DATOS]
(Si no los entrego, usa valores aproximados y escribe «datos aproximados con fines didácticos; verificar en el DANE».)

TAREA
Diseña un taller con preguntas de dificultad creciente:
1. Lectura literal.
2. Comparación y tendencia.
3. Relación con procesos históricos o geográficos (¿qué pasaba en Colombia cuando cambió la tendencia?).
4. Evaluación de conclusiones (una conclusión tentadora pero no respaldada).
5. Pregunta sistémica (consecuencias del fenómeno en distintas dimensiones).
6. Pregunta de investigación local.

FORMATO DE SALIDA
- Tabla de datos con fuente o advertencia.
- Indicaciones para graficar.
- [N_PREGUNTAS] preguntas con solucionario y errores típicos (confundir correlación con causalidad, ignorar la escala, generalizar a todo el país lo que es regional).

RESTRICCIONES
- Datos plausibles y coherentes.
- No atribuir causas únicas a fenómenos sociales.

AUTOVERIFICACIÓN
Resuelve cada pregunta con los datos y verifica coherencia.',
            'seguimientos' => [
                'Convierte las preguntas 4 y 5 en ítems tipo Saber 11.',
                'Haz una versión para trabajar en hoja de cálculo.',
                'Propón cómo comparar estos datos nacionales con los de nuestro municipio.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.°; [FENOMENO] urbanización en Colombia en la segunda mitad del siglo XX; [DATOS] población en cabeceras municipales según los censos del DANE (tabla entregada por el docente); [N_PREGUNTAS] 6.',
                'resultado_html' => '<p><strong>Datos del DANE (población censada; porcentajes redondeados):</strong></p>
<table><tr><th>Censo</th><th>Población en cabeceras municipales (%)</th></tr>
<tr><td>1964</td><td>52</td></tr><tr><td>1973</td><td>61</td></tr><tr><td>1985</td><td>67</td></tr><tr><td>1993</td><td>71</td></tr><tr><td>2005</td><td>76</td></tr><tr><td>2018</td><td>77</td></tr></table>
<p><strong>Pregunta 3:</strong> ¿en qué periodo creció más rápido la población urbana? ¿Qué procesos de esa época en Colombia pueden ayudar a explicarlo? (Se espera: violencia bipartidista y desplazamiento rural, industrialización, oferta de servicios en ciudades.)</p>
<p><strong>Pregunta 4:</strong> «Un estudiante concluye: desde 2005 la gente dejó de migrar del campo a la ciudad». ¿Se apoya en los datos? (Se espera: el porcentaje casi no cambia, pero eso no significa que nadie migre; la población total y los cambios en la definición de cabecera también influyen.)</p>',
            ],
            'revisar' => [
                'Verificar los porcentajes en los censos del DANE si se presentan como reales.',
                'Que las explicaciones históricas sean multicausales.',
            ],
        ],
        [
            'id' => 'SOC-20',
            'categoria' => 'recursos',
            'titulo' => 'Viaje por el relieve: regiones naturales, pisos térmicos y formas de vida',
            'grados' => '3.° a 7.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Para enseñar relieve, clima, pisos térmicos y regiones naturales a partir de un recorrido real por Colombia, conectando paisaje y formas de vida.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[RUTA]' => 'Recorrido real entre dos o más lugares de Colombia.',
                '[ENFOQUE]' => 'Lo que se quiere resaltar: clima, cultivos, vestido, vivienda, ríos, economía.',
                '[RECURSOS]' => 'Mapas físicos, atlas, aplicaciones de mapas, imágenes.',
            ],
            'prompt' => 'Actúa como geógrafo y docente de primaria y básica secundaria en Colombia, experto en enseñar relieve y clima de forma vivencial.

CONTEXTO
- Grado: [GRADO]. Ruta: [RUTA]. Enfoque: [ENFOQUE]. Recursos: [RECURSOS].

TAREA
Diseña un «viaje imaginario» por la ruta, con paradas, que permita comprender cómo cambia el paisaje con la altitud y la región.

FORMATO DE SALIDA
1. Paradas del viaje (4 a 6), cada una con: lugar, altitud aproximada, piso térmico, temperatura aproximada, paisaje, cultivos o actividades económicas, una costumbre o producto típico, y una pregunta para los estudiantes.
2. Perfil topográfico de la ruta descrito para que los estudiantes lo dibujen (eje horizontal: distancia; eje vertical: altitud).
3. Explicación de los pisos térmicos con la advertencia de que los rangos son aproximados y varían según la fuente.
4. Actividad: «maleta del viajero» (qué ropa y qué comida llevar en cada parada y por qué).
5. Evaluación: tres preguntas de aplicación con otra ruta.

RESTRICCIONES
- Altitudes y temperaturas aproximadas y marcadas con [POR CONFIRMAR] si hay duda.
- Mencionar la diversidad de la población de cada lugar sin estereotipos.
- Colombia no tiene estaciones como las de las zonas templadas; tiene temporadas de lluvias y secas.

AUTOVERIFICACIÓN
Revisa que las paradas estén en orden geográfico real, que las altitudes sean plausibles y que el perfil topográfico coincida con las paradas.',
            'seguimientos' => [
                'Crea una versión del viaje como juego de mesa con casillas y preguntas.',
                'Diseña un mapa mudo para ubicar las paradas.',
                'Propón el mismo viaje por la Orinoquía o la Amazonía, donde el relieve cambia poco: ¿qué cambia entonces?',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 5.°; [RUTA] de Buenaventura a Bogotá por carretera; [ENFOQUE] clima, cultivos y vestido; [RECURSOS] atlas escolar y video beam.',
                'resultado_html' => '<table><tr><th>Parada</th><th>Altitud aproximada</th><th>Piso térmico</th><th>Lo que vemos</th></tr>
<tr><td>Buenaventura</td><td>Nivel del mar</td><td>Cálido</td><td>Puerto principal del Pacífico, lluvias muy frecuentes, selva húmeda, pesca</td></tr>
<tr><td>Cali</td><td>Cerca de 1.000 m</td><td>Cálido a templado</td><td>Valle del río Cauca, caña de azúcar</td></tr>
<tr><td>Alto de La Línea</td><td>Cerca de 3.270 m</td><td>Frío a páramo</td><td>Cordillera Central, neblina, túnel de La Línea</td></tr>
<tr><td>Ibagué</td><td>Cerca de 1.280 m</td><td>Templado</td><td>Ciudad musical, cultivos de café y arroz en la región</td></tr>
<tr><td>Bogotá</td><td>Cerca de 2.600 m</td><td>Frío</td><td>Sabana, cultivos de flores y papa en los alrededores</td></tr></table>
<p><strong>Maleta del viajero:</strong> «¿Por qué en Buenaventura llevarías ropa fresca y un impermeable, y en La Línea una chaqueta gruesa, si viajas el mismo día?»</p>',
            ],
            'revisar' => [
                'Altitudes y rutas reales (el orden de las paradas debe corresponder al recorrido).',
                'Que los rangos de pisos térmicos se presenten como aproximados.',
                'Evitar estereotipos sobre los habitantes de cada región.',
            ],
        ],
        [
            'id' => 'SOC-21',
            'categoria' => 'planeacion',
            'titulo' => 'Proyecto de historia oral y memoria local',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Para que los estudiantes reconstruyan la historia de su barrio, vereda o municipio entrevistando a mayores, con un protocolo ético.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[LUGAR]' => 'Barrio, vereda o municipio.',
                '[TEMA_DE_MEMORIA]' => 'Fundación del barrio, cambios del paisaje, oficios, fiestas, el río, la escuela, la llegada de la carretera.',
                '[SEMANAS]' => 'Duración.',
                '[PRODUCTO]' => 'Producto (libro, podcast, exposición, línea de tiempo comunitaria).',
            ],
            'prompt' => 'Actúa como historiador oral y docente con experiencia en proyectos escolares de memoria local en Colombia.

CONTEXTO
- Grado: [GRADO]. Lugar: [LUGAR]. Tema: [TEMA_DE_MEMORIA].
- Duración: [SEMANAS]. Producto: [PRODUCTO].

TAREA
Diseña el proyecto completo de historia oral.

FORMATO DE SALIDA
1. Pregunta de investigación del proyecto.
2. Protocolo ético: consentimiento informado (oral y escrito) del entrevistado, derecho a no responder, a revisar y a retirar su testimonio; cuidado con temas dolorosos; quién conserva las grabaciones.
3. Formación de los estudiantes como entrevistadores: escucha activa, preguntas abiertas, repreguntas, cómo agradecer.
4. Guía de entrevista con 10 a 12 preguntas abiertas centradas en la vida cotidiana y los cambios.
5. Cómo transcribir y analizar: identificar temas comunes, contradicciones entre testimonios y contrastarlos con otras fuentes (fotos, documentos, prensa).
6. Cronograma semanal.
7. Producto final y devolución a la comunidad.
8. Rúbrica en escala Superior, Alto, Básico y Bajo.

RESTRICCIONES
- Las preguntas no deben indagar directamente por hechos violentos; si el entrevistado los menciona, el estudiante escucha con respeto, no profundiza y lo informa al docente.
- No publicar testimonios ni imágenes sin consentimiento.
- La memoria oral es una fuente con valor propio y con límites; enseñar a contrastarla, no a desconfiar de ella.

AUTOVERIFICACIÓN
Revisa que el protocolo ético preceda a las entrevistas y que la guía no tenga preguntas que puedan revictimizar.',
            'seguimientos' => [
                'Redacta el formato de consentimiento informado en lenguaje sencillo.',
                'Diseña la estructura del podcast de 10 minutos con los testimonios.',
                'Propón cómo contrastar los testimonios con documentos del archivo municipal o la parroquia.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 6.°; [LUGAR] casco urbano de Chaparral, Tolima; [TEMA_DE_MEMORIA] cómo era el pueblo cuando los abuelos eran niños; [SEMANAS] 6; [PRODUCTO] exposición de fotos antiguas con fragmentos de testimonios.',
                'resultado_html' => '<p><strong>Pregunta de investigación:</strong> ¿Qué ha cambiado y qué sigue igual en Chaparral desde que nuestros abuelos eran niños?</p>
<p><strong>Guía de entrevista (extracto):</strong></p>
<ol><li>¿Dónde vivía usted cuando era niño o niña? ¿Cómo era la casa?</li>
<li>¿A qué jugaban? ¿Dónde?</li>
<li>¿Cómo llegaban las cosas al pueblo: la comida, las noticias, las cartas?</li>
<li>¿Qué fiestas se celebraban? ¿Cómo eran?</li>
<li>¿Qué es lo que más extraña de esa época? ¿Qué le gusta más de ahora?</li></ol>
<p><strong>Protocolo:</strong> antes de grabar, el estudiante lee el consentimiento en voz alta; el entrevistado puede decir «esto no lo grabe». Si menciona hechos de violencia, el estudiante agradece, no hace más preguntas sobre ese tema y lo comenta con el docente.</p>',
            ],
            'revisar' => [
                'Consentimientos firmados antes de publicar.',
                'Conocer el contexto del municipio para anticipar temas sensibles.',
                'Que la guía sea apropiada para la edad de los entrevistadores.',
            ],
        ],
        [
            'id' => 'SOC-22',
            'categoria' => 'gestion',
            'titulo' => 'Informe descriptivo de desempeño para familias',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 2 h por periodo',
            'cuando' => 'Al redactar informes de periodo o preparar la entrega de boletines del área de ciencias sociales.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[DESEMPENO]' => 'Nivel y nota.',
                '[FORTALEZAS]' => 'Lo que hace bien.',
                '[DIFICULTADES]' => 'Lo que se le dificulta.',
                '[TEMAS_DEL_PERIODO]' => 'Temas del periodo.',
                '[RECURSOS_FAMILIA]' => 'Posibilidades reales de la familia.',
            ],
            'prompt' => 'Actúa como docente de ciencias sociales con experiencia en comunicación con familias de distintos contextos.

CONTEXTO
- Grado: [GRADO]. Desempeño: [DESEMPENO]. Temas: [TEMAS_DEL_PERIODO].
- Fortalezas: [FORTALEZAS]. Dificultades: [DIFICULTADES].
- Posibilidades de la familia: [RECURSOS_FAMILIA].

TAREA
Redacta el informe para la familia.

FORMATO DE SALIDA
1. Informe de máximo 120 palabras: fortaleza concreta, desempeño descrito con ejemplos, dificultad principal y compromiso conjunto.
2. Tres actividades para la casa de 10 a 15 minutos, sin costo, que aprovechen la conversación familiar (por ejemplo, contar historias de la familia, mirar las noticias juntos y preguntar «¿quién lo dice?», ubicar en un mapa de dónde vienen los alimentos).
3. Frase para abrir la conversación en la reunión.

RESTRICCIONES
- Sin jerga pedagógica; sin comparaciones; sin etiquetas.
- Tono respetuoso y esperanzador.
- Las actividades no deben exigir que la familia sepa historia o geografía.

AUTOVERIFICACIÓN
Cuenta palabras, elimina jerga y revisa la viabilidad de las actividades.',
            'seguimientos' => [
                'Redacta los informes de estos estudiantes con el mismo formato: [LISTA ANONIMIZADA].',
                'Versión para nota de voz de 45 segundos.',
                'Versión de 300 caracteres para el boletín.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 6.°; [DESEMPENO] Bajo, 2,7; [TEMAS_DEL_PERIODO] coordenadas geográficas y culturas antiguas; [FORTALEZAS] es muy creativo en las maquetas, ayuda a sus compañeros; [DIFICULTADES] no entrega los talleres, confunde latitud y longitud; [RECURSOS_FAMILIA] el papá es conductor de bus intermunicipal, poco tiempo en casa, tiene celular con datos.',
                'resultado_html' => '<p><strong>Informe:</strong> «Juan Esteban es muy creativo: su maqueta de una ciudad maya fue una de las más cuidadosas del curso, y siempre está dispuesto a ayudar a sus compañeros. En este periodo trabajamos cómo ubicar lugares en el mapa y las culturas antiguas. Juan Esteban todavía confunde las líneas que sirven para ubicar lugares en el mapa y no entregó tres de los cinco talleres, por eso su desempeño es Bajo. Vamos a darle un plan de apoyo y en casa pueden ayudarle con las actividades sugeridas.»</p>
<p><strong>Actividad para la casa:</strong> con el mapa del celular, el papá le muestra la ruta del bus que maneja y Juan Esteban le explica qué ciudades quedan más al norte y cuáles más al sur.</p>',
            ],
            'revisar' => [
                'Personalizar cada informe.',
                'No incluir información sensible.',
                'Coherencia con la valoración registrada.',
            ],
        ],
        [
            'id' => 'SOC-23',
            'categoria' => 'gestion',
            'titulo' => 'Plan de mejoramiento para estudiantes en desempeño Bajo',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Al diseñar actividades de apoyo de fin de periodo o de año que enseñen de nuevo lo que no se alcanzó.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[EVIDENCIAS_NO_ALCANZADAS]' => 'Evidencias o DBA no alcanzados.',
                '[DIAGNOSTICO]' => 'Errores concretos observados.',
                '[TIEMPO]' => 'Tiempo y momentos de acompañamiento.',
                '[REGLAS_SIEE]' => 'Lo que dice el SIEE sobre actividades de apoyo.',
            ],
            'prompt' => 'Actúa como docente de ciencias sociales experto en evaluación formativa y en el Decreto 1290 de 2009.

CONTEXTO
- Grado: [GRADO].
- Evidencias no alcanzadas: [EVIDENCIAS_NO_ALCANZADAS].
- Errores observados: [DIAGNOSTICO].
- Tiempo: [TIEMPO]. Reglas del SIEE: [REGLAS_SIEE].

TAREA
Diseña un plan de mejoramiento en tres fases: reenseñanza con un enfoque distinto, práctica guiada y demostración de la evidencia.

FORMATO DE SALIDA
1. Explicación del plan para el estudiante y la familia (máximo 100 palabras).
2. Cronograma: Semana | Actividad | Qué hace el estudiante | Apoyo | Producto.
3. Material de reenseñanza con ejemplos resueltos, conectados con el entorno del estudiante.
4. Práctica guiada de 6 a 8 ejercicios con pistas graduadas.
5. Evaluación final con dos formatos posibles y criterios de Básico, Alto y Superior.
6. Registro de seguimiento.

RESTRICCIONES
- Atacar los errores del diagnóstico, no todo el periodo.
- Nada de «copiar el capítulo» o «hacer un resumen» como actividad principal.
- Evaluar la misma evidencia que se esperaba.

AUTOVERIFICACIÓN
Cada error del diagnóstico tiene al menos una actividad y la evaluación permite demostrar la evidencia.',
            'seguimientos' => [
                'Escribe las pistas como tarjetas para voltear.',
                'Organiza un compañero tutor con una guía de 5 pasos.',
                'Versión para trabajo en casa sin conexión.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 6.°; [EVIDENCIAS_NO_ALCANZADAS] ubica lugares usando coordenadas geográficas; [DIAGNOSTICO] confunde latitud y longitud, no distingue hemisferios, lee la longitud en la línea equivocada; [TIEMPO] 3 semanas, 2 encuentros de 30 minutos; [REGLAS_SIEE] valoración máxima Básico.',
                'resultado_html' => '<p><strong>Semana 1, reenseñanza:</strong> el salón como planeta. Se marca con cinta en el piso una línea «ecuador» (de pared a pared) y una línea «Greenwich» perpendicular. El estudiante se ubica en el piso y dice: «estoy dos baldosas al norte y tres al oeste». Regla para recordar: la latitud se mide hacia arriba o abajo desde el ecuador, como los «pisos» de un edificio; la longitud, hacia los lados desde Greenwich.</p>
<p><strong>Semana 2, práctica guiada:</strong> ubicar en el mapa ciudades colombianas cercanas al ecuador (Leticia, Mitú, Mocoa) y explicar por qué casi todo el territorio colombiano está en el hemisferio norte y al oeste de Greenwich. Pista 1: «¿la ciudad está arriba o abajo del ecuador?». Pista 2: «¿a la izquierda o a la derecha de Greenwich?».</p>
<p><strong>Evaluación:</strong> ubicar 5 lugares dados por coordenadas aproximadas en un mapa mudo, o explicar oralmente la ubicación de su municipio.</p>',
            ],
            'revisar' => [
                'Reglas y fechas del SIEE.',
                'Coordenadas de los lugares usados en los ejercicios.',
                'Carga total del estudiante si tiene varios planes.',
            ],
        ],
        [
            'id' => 'SOC-24',
            'categoria' => 'planeacion',
            'titulo' => 'Plan de periodo alineado con Estándares, DBA y Saber',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 3 h',
            'cuando' => 'Al iniciar el año o cada periodo, para distribuir DBA y evidencias en semanas y equilibrar las competencias que evalúa Saber.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PERIODO]' => 'Periodo y semanas efectivas.',
                '[INTENSIDAD]' => 'Horas semanales (y si incluye Cátedra de la Paz, Constitución, economía y política).',
                '[DBA_DEL_PERIODO]' => 'DBA y evidencias asignados (textos oficiales).',
                '[EVENTOS]' => 'Eventos institucionales (elección de gobierno escolar, semana de la afrocolombianidad, simulacros).',
                '[RESULTADOS_PREVIOS]' => 'Competencia más débil según Saber o diagnósticos.',
            ],
            'prompt' => 'Actúa como coordinador académico experto en diseño curricular de Ciencias Sociales en Colombia, con dominio de Estándares, DBA, Cátedra de la Paz, Cátedra de Estudios Afrocolombianos, estudios constitucionales y especificaciones de Saber.

CONTEXTO
- Grado: [GRADO]. Periodo: [PERIODO]. Intensidad: [INTENSIDAD].
- DBA y evidencias (textos oficiales): [DBA_DEL_PERIODO]
- Eventos: [EVENTOS]. Resultados previos: [RESULTADOS_PREVIOS].

TAREA
Construye el plan del periodo semana a semana.

FORMATO DE SALIDA
1. Tabla: Semana | DBA o evidencia | Pregunta problematizadora o de la semana | Competencia que se privilegia | Actividad clave | Evaluación.
2. Integración de las cátedras y proyectos obligatorios (Cátedra de la Paz, estudios afrocolombianos, Constitución y democracia) donde sea pertinente, sin forzarlos.
3. Balance de competencias con justificación.
4. Momentos de evaluación sumativa con ponderación sugerida (ajustable al SIEE).
5. Semanas de colchón.

RESTRICCIONES
- No inventar DBA ni reasignar evidencias de otros grados.
- No programar contenido nuevo en semanas de eventos.
- Al menos una semana de colchón cada 8 semanas.

AUTOVERIFICACIÓN
Evidencias cubiertas, semanas que suman el total y más tiempo para la competencia más débil.',
            'seguimientos' => [
                'Desarrolla la semana 3 como secuencia didáctica completa.',
                'Formato de planeador semanal para imprimir.',
                'Si pierdo dos semanas, ¿qué priorizo?',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.°; [PERIODO] tercer periodo, 10 semanas; [INTENSIDAD] 3 horas de sociales y 1 de ciencias económicas y políticas; [DBA_DEL_PERIODO] textos oficiales de los DBA de 11.° sobre conflicto armado, construcción de paz y derechos humanos; [EVENTOS] semana 5 simulacro Saber 11; [RESULTADOS_PREVIOS] interpretación y análisis de perspectivas es la competencia más baja.',
                'resultado_html' => '<table><tr><th>Semana</th><th>Pregunta</th><th>Competencia</th><th>Actividad clave</th></tr>
<tr><td>1</td><td>¿Por qué el conflicto armado colombiano duró tanto?</td><td>Pensamiento sistémico</td><td>Mapa de factores: tierra, narcotráfico, exclusión política, presencia diferenciada del Estado</td></tr>
<tr><td>2</td><td>¿Cómo narran el conflicto distintos actores?</td><td>Perspectivas</td><td>Análisis de fragmentos de informes oficiales y testimonios publicados</td></tr>
<tr><td>4</td><td>¿Qué cambió y qué no con el Acuerdo de Paz de 2016?</td><td>Perspectivas</td><td>Audiencia simulada con roles</td></tr>
<tr><td>5</td><td>Simulacro</td><td>Todas</td><td>Simulacro y retroalimentación</td></tr>
<tr><td>8</td><td>¿Qué es la justicia transicional?</td><td>Pensamiento social</td><td>Estudio del funcionamiento de la JEP con fuentes oficiales</td></tr></table>
<p><strong>Balance:</strong> perspectivas 40 %, sistémico 35 %, pensamiento social 25 %.</p>',
            ],
            'revisar' => [
                'Coherencia con el plan de área y la malla institucional.',
                'Calendario real y ponderaciones del SIEE.',
                'Acción sin daño en las semanas que trabajan el conflicto.',
            ],
        ],
        [
            'id' => 'SOC-25',
            'categoria' => 'recursos',
            'titulo' => 'Auditor de errores, sesgos y anacronismos en material generado con IA',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 40 min',
            'cuando' => 'Siempre antes de imprimir o proyectar material de sociales creado con IA o tomado de internet.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[MATERIAL]' => 'Texto completo.',
                '[TEMA]' => 'Tema.',
            ],
            'prompt' => 'Actúa como historiador, geógrafo y editor pedagógico de materiales escolares de ciencias sociales en Colombia. Eres riguroso y escéptico: tu trabajo es encontrar problemas.

MATERIAL A REVISAR (grado [GRADO], tema [TEMA]):
"""
[MATERIAL]
"""

REVISA Y REPORTA EN ESTE ORDEN
1. Errores factuales: fechas, nombres, lugares, cifras, capitales, ríos, leyes. Para cada uno: cita, problema, corrección o «verificar en...».
2. Anacronismos: términos, nombres o categorías usados fuera de su época (por ejemplo, llamar «Colombia» al territorio colonial sin aclarar, hablar de «departamentos» en la Colonia).
3. Narrativas simplistas: héroes y villanos, causas únicas, progreso lineal, omisión de actores (mujeres, pueblos indígenas, población afrodescendiente, campesinos, sectores populares).
4. Eurocentrismo y lenguaje colonial: «descubrimiento», «tribus primitivas», pueblos indígenas presentados solo en pasado.
5. Contexto extranjero: instituciones, fiestas o figuras de otros países presentadas como si aplicaran a Colombia (estados, condados, Corte Suprema como tribunal constitucional, enmiendas).
6. Sesgos y estereotipos regionales, étnicos, de género o de clase.
7. Tratamiento del conflicto armado: equiparaciones indebidas, justificaciones, lenguaje estigmatizante, cifras sin fuente.
8. Sesgo político: afirmaciones partidistas presentadas como hechos.
9. Citas atribuidas a personajes: señala toda cita textual como «verificar»; muchas citas que circulan son apócrifas.

FORMATO
Tabla por categoría: Cita | Problema | Gravedad | Corrección. Veredicto final: usar tal cual, usar con correcciones o no usar.

REGLA
Si no estás seguro de que algo sea un error, márcalo como dudoso con la fuente recomendada para verificar (Biblioteca Nacional, Banco de la República, DANE, IGAC, Centro Nacional de Memoria Histórica, Comisión de la Verdad, texto oficial de la Constitución, Registraduría). No inventes referencias.',
            'seguimientos' => [
                'Aplica las correcciones de gravedad alta y media y marca los cambios en negrita.',
                'Convierte los errores en una actividad de «detectives de la historia» para los estudiantes.',
                'Explica el sesgo más grave en lenguaje sencillo para discutirlo en clase.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [TEMA] independencia; [MATERIAL] guía generada por IA que dice «Colombia se independizó de España el 20 de julio de 1810 gracias a Simón Bolívar», «las mujeres votaron por primera vez en 1954» y «la Corte Suprema de Colombia decide si las leyes son constitucionales».',
                'resultado_html' => '<table><tr><th>Cita</th><th>Problema</th><th>Gravedad</th><th>Corrección</th></tr>
<tr><td>«Colombia se independizó el 20 de julio de 1810 gracias a Simón Bolívar»</td><td>Narrativa simplista y anacrónica: el 20 de julio de 1810 se conformó una junta en Santafé que inicialmente no declaró la independencia absoluta; Bolívar no participó en ese hecho; la independencia fue un proceso largo con muchos actores.</td><td>Alta</td><td>«El 20 de julio de 1810 se conformó en Santafé una junta de gobierno; fue el inicio de un proceso de independencia que se consolidó en los años siguientes, con hitos como la Batalla de Boyacá (1819).»</td></tr>
<tr><td>«Las mujeres votaron por primera vez en 1954»</td><td>Confusión de fechas: el derecho se reconoció en 1954 y el primer voto fue en el plebiscito de 1957.</td><td>Media</td><td>Precisar ambas fechas: el Acto Legislativo 3 de 1954 reconoció el derecho y el primer voto fue en el plebiscito del 1 de diciembre de 1957.</td></tr>
<tr><td>«La Corte Suprema decide si las leyes son constitucionales»</td><td>Modelo de otro país: en Colombia, desde 1991, esa función corresponde a la Corte Constitucional.</td><td>Alta</td><td>«La Corte Constitucional guarda la integridad de la Constitución.»</td></tr></table>
<p><strong>Veredicto:</strong> usar con correcciones.</p>',
            ],
            'revisar' => [
                'Verificar usted las correcciones de gravedad alta en fuentes confiables.',
                'Usar un chat nuevo para auditar, distinto del que generó el material.',
            ],
        ],
        [
            'id' => 'SOC-26',
            'categoria' => 'recursos',
            'titulo' => 'Simulación histórica: Asamblea Nacional Constituyente de 1991',
            'grados' => '9.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h 30 min',
            'cuando' => 'Para estudios constitucionales (Ley 107 de 1994) y la unidad de Constitución, cuando quiere que los estudiantes comprendan cómo y por qué se escribió la Constitución de 1991 deliberando como constituyentes.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[N_ESTUDIANTES]' => 'Número de estudiantes.',
                '[SESIONES]' => 'Número de sesiones.',
                '[TEMAS_A_DEBATIR]' => 'Temas para las comisiones (derechos fundamentales, tutela, diversidad étnica, participación, organización territorial, descentralización).',
            ],
            'prompt' => 'Actúa como historiador del derecho constitucional colombiano y docente experto en simulaciones pedagógicas.

CONTEXTO
- Grado: [GRADO]. Estudiantes: [N_ESTUDIANTES]. Sesiones: [SESIONES].
- Temas a debatir: [TEMAS_A_DEBATIR].

TAREA
Diseña una simulación de la Asamblea Nacional Constituyente de 1991.

FORMATO DE SALIDA
1. Contexto histórico para estudiantes (máximo 350 palabras): crisis de finales de los ochenta, movimiento estudiantil de la séptima papeleta, convocatoria y elección de la Asamblea, diversidad de su composición (partidos tradicionales, movimientos surgidos de procesos de paz, representantes indígenas, sectores religiosos y otros). Marca con [POR CONFIRMAR] fechas, número de constituyentes y nombres.
2. Roles por bancada o sector, descritos por sus intereses y propuestas generales; usa roles genéricos («constituyente de un movimiento surgido de un proceso de paz», «constituyente indígena») y, si mencionas personas reales, solo las que puedas garantizar.
3. Comisiones de trabajo según [TEMAS_A_DEBATIR], con una pregunta guía y dos o tres propuestas en tensión para cada una.
4. Reglamento de la simulación: debate en comisión, plenaria, votación, redacción de artículos.
5. Momento de contraste: los estudiantes comparan los artículos que redactaron con el texto real de la Constitución (el docente busca los artículos en el texto oficial).
6. Reflexión: ¿qué cambió en Colombia con la Constitución de 1991? ¿qué promesas siguen pendientes?
7. Rúbrica de participación y del artículo redactado.

RESTRICCIONES
- No inventes números de artículos ni su contenido; indica el tema y pide al docente verificar en el texto oficial.
- No inventes citas de constituyentes.
- Presenta los debates con equilibrio entre posiciones.

AUTOVERIFICACIÓN
Revisa que todas las fechas y cifras estén marcadas para verificar y que cada comisión tenga posiciones genuinamente en tensión.',
            'seguimientos' => [
                'Crea las tarjetas de rol imprimibles para cada bancada.',
                'Diseña tres ítems tipo Saber 11 de pensamiento social sobre la tutela y los derechos fundamentales.',
                'Propón una actividad posterior: un caso de tutela real explicado para estudiantes.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.°; [N_ESTUDIANTES] 36; [SESIONES] 4; [TEMAS_A_DEBATIR] mecanismos de protección de derechos, reconocimiento de la diversidad étnica y cultural, mecanismos de participación ciudadana.',
                'resultado_html' => '<p><strong>Contexto (extracto):</strong> «A finales de los años ochenta, Colombia vivía una crisis profunda: asesinatos de candidatos presidenciales, atentados del narcotráfico y una sensación de que las instituciones no respondían. En las elecciones de marzo de 1990, un movimiento estudiantil promovió depositar una “séptima papeleta” pidiendo una Asamblea Constituyente. El 9 de diciembre de 1990 se eligieron los 70 constituyentes, y la Asamblea fue presidida de manera compartida por Horacio Serpa (Partido Liberal), Álvaro Gómez Hurtado (Movimiento de Salvación Nacional) y Antonio Navarro Wolff (Alianza Democrática M-19). La nueva Constitución se proclamó el 4 de julio de 1991.»</p>
<p><strong>Comisión de protección de derechos. Pregunta guía:</strong> ¿cómo puede un ciudadano común defender sus derechos fundamentales sin abogado y de forma rápida?</p>
<p><strong>Propuestas en tensión:</strong> A. Un mecanismo rápido ante cualquier juez, sin abogado. B. Fortalecer los procesos judiciales ordinarios para no congestionar a los jueces. C. Un tribunal especial para proteger la Constitución.</p>
<p><strong>Contraste:</strong> los estudiantes comparan su propuesta con la acción de tutela tal como quedó en la Constitución (el docente localiza el artículo en el texto oficial).</p>',
            ],
            'revisar' => [
                'Fechas, composición y presidencia de la Asamblea en fuentes confiables.',
                'Artículos de la Constitución en el texto oficial vigente (con sus reformas).',
                'Que los roles no se asocien con partidos actuales de manera que genere conflictos en el aula.',
            ],
        ],
        [
            'id' => 'SOC-27',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Análisis de resultados y retroalimentación grupal tras una prueba',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Después de un simulacro, una prueba de periodo o la llegada de resultados Saber, para decidir qué reenseñar y cómo devolver los resultados al grupo.',
            'variables' => [
                '[GRADO]' => 'Grado y número de estudiantes.',
                '[RESULTADOS]' => 'Porcentaje de acierto por pregunta y opción más elegida.',
                '[ESPECIFICACIONES]' => 'Competencia y tema de cada pregunta.',
                '[TIEMPO_DISPONIBLE]' => 'Clases para reenseñar.',
            ],
            'prompt' => 'Actúa como analista de evaluación educativa con experiencia en el uso pedagógico de resultados de ciencias sociales y competencias ciudadanas.

DATOS
- Grado: [GRADO].
- Resultados: [RESULTADOS]
- Especificaciones: [ESPECIFICACIONES]
- Tiempo: [TIEMPO_DISPONIBLE].

TAREA
1. Calcula el acierto promedio por competencia y por tema.
2. Identifica preguntas críticas (menos del 40 %) e interpreta el error más probable a partir de la opción más elegida.
3. Distingue problemas de conocimiento (no conocen el concepto), de lectura (no comprenden el contexto) y de razonamiento (no identifican perspectivas, supuestos o relaciones).
4. Prioriza qué reenseñar.
5. Diseña la retroalimentación grupal.

FORMATO DE SALIDA
- Tabla por competencia y tema.
- Preguntas críticas con hipótesis del error.
- Plan de reenseñanza: Clase | Foco | Actividad | Verificación.
- Guion de retroalimentación grupal de 15 minutos: resultado general sin exponer a nadie, tres preguntas para resolver juntos en voz alta explicando por qué se descartan las opciones, compromiso del grupo.

RESTRICCIONES
- Conclusiones tentativas si el grupo es pequeño.
- No proponer repetir la prueba como estrategia principal.

AUTOVERIFICACIÓN
Recalcula promedios y verifica que las prioridades correspondan a los datos más bajos.',
            'seguimientos' => [
                'Informe de una página para el consejo académico.',
                'Tres ítems nuevos para verificar después de reenseñar.',
                'Agrupamientos de estudiantes por tipo de error.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.°, 38 estudiantes; [RESULTADOS] 25 preguntas; [ESPECIFICACIONES] 9 de pensamiento social, 8 de perspectivas, 8 de reflexivo y sistémico; [TIEMPO_DISPONIBLE] 3 clases.',
                'resultado_html' => '<table><tr><th>Competencia</th><th>Acierto promedio</th></tr><tr><td>Pensamiento social</td><td>61 %</td></tr><tr><td>Interpretación y análisis de perspectivas</td><td>42 %</td></tr><tr><td>Pensamiento reflexivo y sistémico</td><td>38 %</td></tr></table>
<p><strong>Pregunta crítica 17 (sistémico, 24 %):</strong> la mayoría eligió la opción que solo considera la dimensión económica de una decisión. Hipótesis: el grupo no busca dimensiones adicionales cuando una opción «suena lógica».</p>
<p><strong>Clase 1:</strong> «Las seis gafas»: cada equipo analiza el mismo problema (construcción de una vía en una zona de reserva) con una dimensión distinta (económica, ambiental, social, cultural, política, jurídica) y luego se arma el mapa completo.</p>
<p><strong>Guion grupal:</strong> «Somos buenos usando conceptos. Nos cuesta mirar un problema desde varias dimensiones al tiempo. Hoy vamos a entrenar eso.»</p>',
            ],
            'revisar' => [
                'Recalcular promedios.',
                'Que las hipótesis de error tengan sentido con lo que conoce del grupo.',
                'No compartir resultados individuales con nombres.',
            ],
        ],
        [
            'id' => 'SOC-28',
            'categoria' => 'adaptacion',
            'titulo' => 'Contextualización étnica y territorial de una unidad (etnoeducación y estudios afrocolombianos)',
            'grados' => '1.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'En instituciones etnoeducativas o con población indígena, negra, afrocolombiana, raizal, palenquera o rrom, y en cualquier institución que quiera integrar la Cátedra de Estudios Afrocolombianos y la diversidad étnica al currículo regular, no solo en fechas conmemorativas.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[UNIDAD]' => 'Unidad o tema regular del plan de estudios.',
                '[COMUNIDAD_TERRITORIO]' => 'Comunidad y territorio (o «institución urbana sin población étnica mayoritaria»).',
                '[REFERENTES_PROPIOS]' => 'Proyecto educativo comunitario, plan de vida, sabedores disponibles, si existen.',
            ],
            'prompt' => 'Actúa como docente con experiencia en etnoeducación, Cátedra de Estudios Afrocolombianos (Decreto 1122 de 1998) y educación intercultural en Colombia, respetuoso de la autonomía de los pueblos.

CONTEXTO
- Grado: [GRADO]. Unidad: [UNIDAD].
- Comunidad y territorio: [COMUNIDAD_TERRITORIO].
- Referentes propios disponibles: [REFERENTES_PROPIOS].

TAREA
Reformula la unidad para que integre de manera sustantiva (no decorativa) la historia, los saberes, los territorios y los aportes de los pueblos étnicos pertinentes, manteniendo los DBA del grado.

FORMATO DE SALIDA
1. Diagnóstico de la unidad original: qué voces y actores están ausentes.
2. Nueva pregunta problematizadora que incluya la perspectiva étnica y territorial.
3. Ajustes por sesión: Sesión original | Qué se agrega o cambia | Fuente o referente (tipo de fuente, sin inventar títulos).
4. Participación de la comunidad: cómo invitar a sabedores, consejos comunitarios o cabildos, con protocolo de respeto.
5. Conceptos clave con su definición precisa (por ejemplo, territorio colectivo, resguardo, consulta previa, cimarronaje, autonomía), indicando que las normas citadas deben verificarse.
6. Evaluación que valore el diálogo entre perspectivas.

RESTRICCIONES
- Evitar el folclorismo (solo bailes, comidas y trajes), la victimización como única narrativa y la idealización.
- No atribuir a un pueblo prácticas o creencias que no estén en el contexto entregado; si no conoces la especificidad de [COMUNIDAD_TERRITORIO], formula preguntas para averiguarla.
- No usar palabras en lenguas propias que no puedas garantizar.
- Lenguaje preciso: «pueblos indígenas», «comunidades negras, afrocolombianas, raizales y palenqueras», «personas esclavizadas».

AUTOVERIFICACIÓN
Revisa que los DBA del grado se mantengan, que la perspectiva étnica atraviese la unidad y no sea un anexo, y que no haya datos culturales inventados.',
            'seguimientos' => [
                'Redacta la carta de invitación al consejo comunitario o cabildo.',
                'Propón un producto final bilingüe con apoyo de la comunidad.',
                'Diseña una línea de tiempo de la historia del territorio con hitos propuestos por la comunidad.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [UNIDAD] siglo XIX: abolición de la esclavitud y construcción de la nación; [COMUNIDAD_TERRITORIO] institución en Guapi, Cauca, costa Pacífica, con población mayoritariamente afrocolombiana; [REFERENTES_PROPIOS] consejo comunitario del río, cantadoras de la región.',
                'resultado_html' => '<p><strong>Ausencias en la unidad original:</strong> la abolición aparecía como una decisión del Congreso de 1851, sin las luchas de las personas esclavizadas ni la historia del poblamiento libre del Pacífico.</p>
<p><strong>Nueva pregunta:</strong> ¿Cómo construyeron libertad y territorio en el Pacífico las personas esclavizadas y sus descendientes, antes y después de la abolición?</p>
<table><tr><th>Sesión original</th><th>Ajuste</th><th>Referente</th></tr>
<tr><td>Ley de abolición de 1851</td><td>Se agrega la automanumisión (compra de la propia libertad), el cimarronaje y la ocupación de los ríos como estrategias de libertad.</td><td>Fuentes historiográficas sobre el Pacífico colombiano; tradición oral del consejo comunitario.</td></tr>
<tr><td>Construcción de la nación</td><td>Se conecta con la Ley 70 de 1993 y los títulos colectivos de las comunidades negras: ¿cuándo se tituló colectivamente el territorio que la comunidad habitaba desde generaciones atrás? (el dato está en la resolución de titulación del consejo comunitario)</td><td>Consejo comunitario; texto de la ley.</td></tr>
<tr><td>Cierre</td><td>Las cantadoras comparten cantos tradicionales de la región y explican su papel en la memoria comunitaria, si así lo deciden.</td><td>Sabedoras invitadas con protocolo.</td></tr></table>',
            ],
            'revisar' => [
                'Aval de la comunidad o de sus organizaciones antes de usar sus saberes.',
                'Datos históricos y normas verificados.',
                'Que la integración sea permanente en el plan de estudios y no un evento aislado.',
            ],
        ],
    ],

    'cadenas' => [
        [
            'titulo' => 'Unidad de historia con fuentes: de la pregunta al ensayo',
            'objetivo' => 'Construir una unidad completa de historia de Colombia que pase de la narración de hechos al pensamiento histórico con fuentes y argumentación.',
            'pasos' => [
                ['paso' => 'Ubique la unidad en el periodo y defina la competencia a fortalecer.', 'receta' => 'SOC-24', 'nota' => 'Copie los DBA oficiales.'],
                ['paso' => 'Diseñe la secuencia alrededor de una pregunta problematizadora.', 'receta' => 'SOC-01', 'nota' => 'Elija una pregunta que admita respuestas argumentadas distintas.'],
                ['paso' => 'Construya la línea de tiempo con causas y simultaneidades.', 'receta' => 'SOC-03', 'nota' => 'Verifique todas las fechas.'],
                ['paso' => 'Prepare el taller de análisis de fuentes.', 'receta' => 'SOC-02', 'nota' => 'Use solo fuentes que usted tenga y pueda verificar.'],
                ['paso' => 'Evalúe con rúbrica el ensayo final.', 'receta' => 'SOC-16', 'nota' => 'Socialícela desde la primera sesión.'],
                ['paso' => 'Devuelva retroalimentación formativa del ensayo.', 'receta' => 'SOC-15', 'nota' => 'Pida el resumen de problemas frecuentes para una minilección.'],
            ],
        ],
        [
            'titulo' => 'Cátedra de la Paz y memoria con acción sin daño',
            'objetivo' => 'Trabajar el conflicto armado, la memoria y la construcción de paz cuidando a los estudiantes y vinculando al territorio.',
            'pasos' => [
                ['paso' => 'Diseñe la unidad de memoria con acuerdos de acción sin daño.', 'receta' => 'SOC-10', 'nota' => 'Coordine con orientación escolar antes de iniciar.'],
                ['paso' => 'Recoja la memoria local mediante historia oral con protocolo ético.', 'receta' => 'SOC-21', 'nota' => 'Las preguntas se centran en la vida cotidiana, no en la violencia.'],
                ['paso' => 'Analice un conflicto actual del territorio con perspectivas.', 'receta' => 'SOC-04', 'nota' => 'Ningún actor es villano.'],
                ['paso' => 'Evalúe con una rúbrica centrada en comprensión y reflexión.', 'receta' => 'SOC-16', 'nota' => 'No se evalúa la opinión política del estudiante.'],
            ],
        ],
        [
            'titulo' => 'Preparación de Saber 11 en Sociales y Ciudadanas',
            'objetivo' => 'Usar los resultados para enfocar la enseñanza en las competencias más débiles y practicar con ítems de calidad.',
            'pasos' => [
                ['paso' => 'Analice los resultados del simulacro.', 'receta' => 'SOC-27', 'nota' => 'Necesita la opción más elegida por pregunta.'],
                ['paso' => 'Entrene la lectura de datos sociales.', 'receta' => 'SOC-19', 'nota' => 'Use datos del DANE cuando sea posible.'],
                ['paso' => 'Practique el análisis de fuentes y desinformación.', 'receta' => 'SOC-18', 'nota' => 'Refuerza el pensamiento reflexivo sobre el uso de fuentes.'],
                ['paso' => 'Construya ítems nuevos de las competencias débiles.', 'receta' => 'SOC-06', 'nota' => 'Sin nombres de políticos actuales.'],
                ['paso' => 'Diseñe planes de mejoramiento para quienes siguen en Bajo.', 'receta' => 'SOC-23', 'nota' => 'Enfocados en los errores detectados.'],
            ],
        ],
        [
            'titulo' => 'Primaria: mi territorio y su diversidad',
            'objetivo' => 'Una unidad de primaria que parta del entorno cercano, lea el territorio con mapas, reconozca la diversidad cultural y evalúe competencias ciudadanas.',
            'pasos' => [
                ['paso' => 'Explore el entorno social cercano.', 'receta' => 'SOC-12', 'nota' => 'Salidas cortas con autorización.'],
                ['paso' => 'Construya el mapa social del barrio o la vereda.', 'receta' => 'SOC-05', 'nota' => 'Sin ubicar casas de estudiantes.'],
                ['paso' => 'Lea un relato sobre diversidad cultural sin estereotipos.', 'receta' => 'SOC-13', 'nota' => 'Valide los datos culturales.'],
                ['paso' => 'Viaje por las regiones y pisos térmicos de Colombia.', 'receta' => 'SOC-20', 'nota' => 'Altitudes aproximadas y verificadas.'],
                ['paso' => 'Evalúe con ítems de pensamiento ciudadano.', 'receta' => 'SOC-07', 'nota' => 'Use situaciones del mismo territorio.'],
                ['paso' => 'Informe a las familias.', 'receta' => 'SOC-22', 'nota' => 'Actividades de conversación familiar sin costo.'],
            ],
        ],
        [
            'titulo' => 'Inclusión y diversidad en una unidad de Constitución',
            'objetivo' => 'Planear la unidad de Constitución de 1991 con ajustes razonables, lectura en niveles y enfoque étnico desde el inicio.',
            'pasos' => [
                ['paso' => 'Defina los ajustes razonables del PIAR para la unidad.', 'receta' => 'SOC-09', 'nota' => 'Descripción pedagógica, nunca nombres.'],
                ['paso' => 'Integre la perspectiva étnica y territorial.', 'receta' => 'SOC-28', 'nota' => 'La Constitución reconoce la diversidad étnica y cultural: aprovéchelo.'],
                ['paso' => 'Prepare el texto de contexto en tres niveles.', 'receta' => 'SOC-08', 'nota' => 'Preguntas comunes para todo el grupo.'],
                ['paso' => 'Realice la simulación de la Asamblea Constituyente.', 'receta' => 'SOC-26', 'nota' => 'Roles adaptados según el PIAR.'],
            ],
        ],
    ],

    'rubricas' => [
        [
            'titulo' => 'Análisis de fuentes históricas',
            'criterios' => [
                ['criterio' => 'Procedencia y contexto', 'niveles' => [
                    'Superior' => 'Identifica autor, fecha, propósito y público de la fuente, y explica cómo el contexto histórico influye en lo que dice.',
                    'Alto' => 'Identifica autor, fecha y propósito, y menciona el contexto.',
                    'Básico' => 'Identifica autor y fecha, pero no el propósito ni el contexto.',
                    'Bajo' => 'No identifica la procedencia o la confunde.',
                ]],
                ['criterio' => 'Lectura atenta', 'niveles' => [
                    'Superior' => 'Distingue hechos, opiniones e intenciones del autor, y analiza el lenguaje utilizado.',
                    'Alto' => 'Distingue hechos y opiniones del autor.',
                    'Básico' => 'Resume el contenido sin distinguir hechos de opiniones.',
                    'Bajo' => 'Malinterpreta el contenido de la fuente.',
                ]],
                ['criterio' => 'Corroboración', 'niveles' => [
                    'Superior' => 'Compara varias fuentes, explica coincidencias y diferencias y justifica cuál es más confiable para la pregunta.',
                    'Alto' => 'Compara fuentes e identifica coincidencias y diferencias.',
                    'Básico' => 'Menciona otra fuente sin compararla realmente.',
                    'Bajo' => 'Trabaja con una sola fuente como si fuera la verdad.',
                ]],
                ['criterio' => 'Respuesta a la pregunta histórica', 'niveles' => [
                    'Superior' => 'Responde con una tesis argumentada, citando fuentes y reconociendo los límites de la evidencia.',
                    'Alto' => 'Responde con argumentos apoyados en fuentes.',
                    'Básico' => 'Responde con una opinión apoyada parcialmente en las fuentes.',
                    'Bajo' => 'No responde la pregunta o lo hace sin relación con las fuentes.',
                ]],
            ],
        ],
        [
            'titulo' => 'Ensayo argumentativo de ciencias sociales (9.° a 11.°)',
            'criterios' => [
                ['criterio' => 'Tesis', 'niveles' => [
                    'Superior' => 'Plantea una tesis clara, discutible y matizada que responde la pregunta.',
                    'Alto' => 'Plantea una tesis clara que responde la pregunta.',
                    'Básico' => 'Plantea una posición general o poco precisa.',
                    'Bajo' => 'No hay tesis o no responde la pregunta.',
                ]],
                ['criterio' => 'Evidencias históricas y conceptuales', 'niveles' => [
                    'Superior' => 'Usa evidencias precisas, pertinentes y contextualizadas, con conceptos de las ciencias sociales bien empleados.',
                    'Alto' => 'Usa evidencias pertinentes y conceptos correctos.',
                    'Básico' => 'Usa evidencias generales o con imprecisiones menores.',
                    'Bajo' => 'No usa evidencias o contienen errores graves o anacronismos.',
                ]],
                ['criterio' => 'Otras perspectivas', 'niveles' => [
                    'Superior' => 'Presenta con justicia el mejor contraargumento y lo responde con evidencia.',
                    'Alto' => 'Presenta un contraargumento y lo responde.',
                    'Básico' => 'Menciona que existen otras posiciones sin desarrollarlas.',
                    'Bajo' => 'Ignora o descalifica otras perspectivas.',
                ]],
                ['criterio' => 'Organización y conclusión', 'niveles' => [
                    'Superior' => 'El texto progresa con lógica, usa conectores precisos y concluye con una síntesis que aporta.',
                    'Alto' => 'El texto es organizado y concluye coherentemente.',
                    'Básico' => 'El texto tiene saltos o repeticiones; la conclusión repite la tesis.',
                    'Bajo' => 'El texto es desorganizado o no tiene conclusión.',
                ]],
            ],
        ],
        [
            'titulo' => 'Debate o audiencia pública',
            'criterios' => [
                ['criterio' => 'Comprensión de la perspectiva asignada', 'niveles' => [
                    'Superior' => 'Representa con profundidad intereses, valores y argumentos del actor, y reconoce sus puntos débiles.',
                    'Alto' => 'Representa con fidelidad intereses y argumentos del actor.',
                    'Básico' => 'Representa al actor de manera general.',
                    'Bajo' => 'Caricaturiza al actor o habla desde su opinión personal.',
                ]],
                ['criterio' => 'Uso de evidencias y conceptos', 'niveles' => [
                    'Superior' => 'Sustenta con datos, normas o hechos pertinentes y verificables, y evalúa las evidencias de los otros.',
                    'Alto' => 'Sustenta con evidencias pertinentes.',
                    'Básico' => 'Sustenta con evidencias generales o poco pertinentes.',
                    'Bajo' => 'No sustenta con evidencias.',
                ]],
                ['criterio' => 'Escucha y réplica', 'niveles' => [
                    'Superior' => 'Responde directamente a los argumentos de otros, reformulándolos con precisión antes de replicar.',
                    'Alto' => 'Responde a los argumentos de otros.',
                    'Básico' => 'Repite su posición sin responder a los demás.',
                    'Bajo' => 'Interrumpe o descalifica a las personas.',
                ]],
                ['criterio' => 'Pensamiento sistémico', 'niveles' => [
                    'Superior' => 'Relaciona varias dimensiones del problema y anticipa consecuencias de las alternativas.',
                    'Alto' => 'Relaciona al menos dos dimensiones del problema.',
                    'Básico' => 'Analiza el problema desde una sola dimensión.',
                    'Bajo' => 'No identifica las dimensiones del problema.',
                ]],
            ],
        ],
        [
            'titulo' => 'Cartografía y línea de tiempo',
            'criterios' => [
                ['criterio' => 'Elementos técnicos', 'niveles' => [
                    'Superior' => 'Incluye título, orientación, convenciones claras y escala (o escala temporal proporcional) bien aplicadas.',
                    'Alto' => 'Incluye todos los elementos con errores menores.',
                    'Básico' => 'Faltan uno o dos elementos técnicos.',
                    'Bajo' => 'Faltan la mayoría de elementos o el producto no es legible.',
                ]],
                ['criterio' => 'Precisión de la información', 'niveles' => [
                    'Superior' => 'Toda la información espacial o temporal es correcta y está verificada con fuentes.',
                    'Alto' => 'La información es correcta en su mayoría.',
                    'Básico' => 'Hay algunos errores de ubicación o de fechas.',
                    'Bajo' => 'Hay errores frecuentes que afectan la comprensión.',
                ]],
                ['criterio' => 'Análisis', 'niveles' => [
                    'Superior' => 'Explica relaciones (causas, consecuencias, cambios y continuidades, patrones espaciales) a partir del producto.',
                    'Alto' => 'Explica algunas relaciones a partir del producto.',
                    'Básico' => 'Describe el producto sin explicar relaciones.',
                    'Bajo' => 'No hay análisis.',
                ]],
            ],
        ],
    ],

    'errores' => [
        [
            'error' => 'Narrativas heroicas y monocausales: «Bolívar nos dio la independencia», «Colombia se independizó el 20 de julio de 1810».',
            'como_detectarlo' => 'Un solo protagonista, una sola causa, una sola fecha; ausencia de procesos, de actores colectivos y de perspectivas.',
            'como_corregirlo' => 'Pida a la IA presentar la independencia como un proceso (1810 a 1819 y años siguientes), con múltiples actores (criollos, sectores populares, indígenas, personas esclavizadas, mujeres) y causas internas y externas.',
        ],
        [
            'error' => 'Anacronismos: llamar «Colombia» al territorio colonial sin aclaración, hablar de «departamentos» en la Colonia, juzgar el pasado solo con valores de hoy.',
            'como_detectarlo' => 'Términos actuales aplicados a épocas anteriores; nombres de entidades que no existían.',
            'como_corregirlo' => 'Use los nombres de cada época (Nuevo Reino de Granada, Virreinato, República de Colombia de 1819 a 1831, que la historiografía llama «Gran Colombia», Nueva Granada, Estados Unidos de Colombia) y pida a la IA contextualizar.',
        ],
        [
            'error' => 'Datos geográficos equivocados: capitales, número de departamentos, regiones naturales, longitudes de ríos, altitudes de picos.',
            'como_detectarlo' => 'Revise capitales menos conocidas (Mitú, Inírida, Puerto Carreño, San José del Guaviare, Mocoa, Yopal) y cifras exactas sin fuente.',
            'como_corregirlo' => 'Colombia tiene 32 departamentos y Bogotá como Distrito Capital. Verifique cifras en el IGAC y presente medidas como aproximadas cuando las fuentes difieran.',
        ],
        [
            'error' => 'Civismo importado de Estados Unidos: «estados», «condados», «enmiendas», «jurados», «la Corte Suprema decide la constitucionalidad», fiestas como Acción de Gracias.',
            'como_detectarlo' => 'Instituciones o vocabulario que no existen en el ordenamiento colombiano.',
            'como_corregirlo' => 'Especifique «según la Constitución Política de Colombia de 1991» y verifique: en Colombia la guarda de la Constitución corresponde a la Corte Constitucional; el territorio se organiza en departamentos, distritos, municipios y territorios indígenas.',
        ],
        [
            'error' => 'Artículos de la Constitución, leyes, decretos o sentencias inventados o con contenido equivocado.',
            'como_detectarlo' => 'Números de artículo o de norma que no coinciden con su contenido; sentencias citadas sin año o con contenido genérico.',
            'como_corregirlo' => 'Prohíba en el prompt citar números que la IA no pueda garantizar; verifique siempre en el texto oficial de la Constitución y en la relatoría de la Corte Constitucional.',
        ],
        [
            'error' => 'Tratamiento inadecuado del conflicto armado: equiparar o justificar a actores armados, lenguaje estigmatizante contra regiones o víctimas, cifras de víctimas sin fuente, imágenes explícitas.',
            'como_detectarlo' => 'Explicaciones que culpan a las víctimas, que reducen el conflicto a una sola causa o a un solo actor, o que usan cifras redondas sin fuente.',
            'como_corregirlo' => 'Aplique la receta SOC-10 (acción sin daño). Use cifras del Registro Único de Víctimas, el Centro Nacional de Memoria Histórica o la Comisión de la Verdad, con fecha de corte.',
        ],
        [
            'error' => 'Eurocentrismo y lenguaje colonial: «descubrimiento de América», «tribus», «primitivos», pueblos indígenas presentados solo en pasado.',
            'como_detectarlo' => 'Palabras valorativas y verbos en pasado para pueblos que existen hoy.',
            'como_corregirlo' => 'Pida a la IA usar «llegada de los europeos», «encuentro» o «invasión» según la perspectiva que se analiza, y presentar a los pueblos indígenas como sujetos actuales con derechos, territorios y organizaciones.',
        ],
        [
            'error' => 'Estereotipos regionales, étnicos y de género: costeños «perezosos», antioqueños «negociantes», población afrocolombiana solo asociada a música y deporte, mujeres ausentes de la historia.',
            'como_detectarlo' => 'Generalizaciones sobre «los de» una región o un grupo; ausencia de mujeres en líneas de tiempo y casos.',
            'como_corregirlo' => 'Incluya en el prompt la restricción de evitar estereotipos y pida explícitamente actores diversos con agencia. Use la receta SOC-25 para auditar.',
        ],
        [
            'error' => 'Fechas clave equivocadas: voto femenino (reconocido en 1954, ejercido por primera vez en 1957), abolición de la esclavitud (1851), separación de Panamá (1903), Constitución de 1886 y de 1991.',
            'como_detectarlo' => 'Revise las fechas de cada línea de tiempo y relato; desconfíe de fechas exactas de días y meses.',
            'como_corregirlo' => 'Pida a la IA marcar con [POR CONFIRMAR] toda fecha y contrástelas con fuentes como la Biblioteca Nacional o la Red Cultural del Banco de la República.',
        ],
        [
            'error' => 'Citas apócrifas atribuidas a Bolívar, Santander, Gaitán, García Márquez u otros personajes.',
            'como_detectarlo' => 'Citas textuales sin fuente precisa (obra, carta, discurso, fecha).',
            'como_corregirlo' => 'Prohíba las citas textuales no verificables; trabaje con fuentes que usted tenga o parafrasee.',
        ],
        [
            'error' => 'Datos demográficos, económicos y políticos desactualizados (población, migración, pobreza, gobernantes, estado de la implementación del Acuerdo de Paz).',
            'como_detectarlo' => 'Cifras sin año, menciones a «el actual presidente» o a procesos «en curso» que pudieron cambiar.',
            'como_corregirlo' => 'Consulte DANE, Migración Colombia, Registraduría y fuentes oficiales con fecha de corte; pida a la IA que indique el año de cada dato.',
        ],
        [
            'error' => 'Sesgo político: presentar opiniones partidistas como hechos o, al contrario, crear una falsa equivalencia entre hechos documentados y opiniones.',
            'como_detectarlo' => 'Adjetivos valorativos sobre partidos o gobiernos; afirmaciones sin evidencia; «hay dos versiones» cuando una está documentada judicialmente.',
            'como_corregirlo' => 'Pida separar hechos documentados, interpretaciones y opiniones, y presentar los argumentos más fuertes de cada posición sin tomar partido.',
        ],
    ],

    'banco_contextos' => [
        'La «séptima papeleta» de 1990 y la Asamblea Nacional Constituyente que produjo la Constitución de 1991.',
        'La acción de tutela: cómo un ciudadano protege sus derechos fundamentales (salud, educación, debido proceso).',
        'San Basilio de Palenque (Bolívar): cimarronaje, lengua palenquera y patrimonio cultural inmaterial.',
        'La Ley 70 de 1993 y los títulos colectivos de las comunidades negras del Pacífico.',
        'El pueblo raizal de San Andrés y Providencia: lengua creole, territorio insular y el fallo de La Haya de 2012.',
        'Pueblos indígenas de Colombia: resguardos, cabildos, guardia indígena y consulta previa.',
        'El pueblo wayuu en La Guajira: sistema normativo propio, palabreros, escasez de agua y minería de carbón.',
        'La Batalla de Boyacá (1819) y la independencia como proceso, con la participación de llaneros, mujeres y sectores populares.',
        'La abolición de la esclavitud (1851) y las estrategias de libertad de las personas esclavizadas.',
        'La Guerra de los Mil Días (1899 a 1902) y la separación de Panamá (1903).',
        'La masacre de las bananeras (1928) en Ciénaga, Magdalena, y los derechos laborales.',
        'El 9 de abril de 1948: el asesinato de Jorge Eliécer Gaitán y la violencia bipartidista.',
        'El Frente Nacional (1958 a 1974): pacto, alternación, exclusión política.',
        'El voto femenino: reconocido en 1954 y ejercido por primera vez en el plebiscito de 1957.',
        'Las tejedoras de Mampuján (Montes de María): memoria, arte y reparación.',
        'El informe final de la Comisión de la Verdad (2022) y su uso pedagógico con acción sin daño.',
        'El Acuerdo de Paz de 2016, el plebiscito y la Jurisdicción Especial para la Paz.',
        'Desplazamiento forzado y llegada a las ciudades: barrios construidos por población desplazada.',
        'Migración venezolana hacia Colombia: rutas, integración, xenofobia y derechos.',
        'El paro agrario de 2013 y los precios de la papa en Boyacá: oferta, demanda e intermediación.',
        'El Paisaje Cultural Cafetero: economía del café, colonización antioqueña y patrimonio de la UNESCO.',
        'El páramo de Santurbán: minería, agua para Bucaramanga y participación ciudadana.',
        'El río Atrato como sujeto de derechos y la minería ilegal en el Chocó.',
        'La tragedia de Armero (1985): gestión del riesgo, memoria y responsabilidad del Estado.',
        'La Expedición Botánica y la Comisión Corográfica: ciencia, mapas y construcción de la nación en los siglos XVIII y XIX.',
        'El Carnaval de Barranquilla, patrimonio inmaterial: identidad, mestizaje y economía cultural.',
        'La urbanización de Colombia en el siglo XX según los censos del DANE.',
        'El gobierno escolar y la elección del personero como primera experiencia de democracia.',
    ],
];
