<?php
/**
 * Kit de IA para docentes — Ciencias Naturales y Educación Ambiental.
 * Contenido curado por Edwin Ortiz Herazo (edwinortiz.net).
 * Este archivo solo devuelve datos; otro módulo lo renderiza a PDF.
 */

return [
    'key' => 'naturales',
    'name' => 'Ciencias Naturales y Educación Ambiental',
    'tagline' => 'Prompts probados, alineados con Estándares, DBA y Saber, para planear, evaluar y adaptar ciencias con fenómenos colombianos reales y laboratorios seguros.',

    'intro_html' => '<p>Cualquier chat de IA puede «hacer una guía de la célula». Lo difícil es que esa guía esté alineada con el DBA que usted debe cumplir, que use un fenómeno que sus estudiantes reconozcan (el páramo que les da el agua, el manglar, el cultivo de la vereda), que no repita preconcepciones, que no proponga un experimento peligroso y que deje una evidencia evaluable con la escala del Decreto 1290. Este kit resuelve justamente eso.</p>
<p>Encontrará <strong>recetas</strong>: prompts completos con rol, contexto, tarea, formato y un paso de autoverificación que obliga a la IA a revisar su propio trabajo. Cada receta trae las variables que usted debe llenar, prompts de seguimiento para afinar el resultado, un ejemplo realista ya editado por un docente experto y una lista de lo que debe revisar antes de llevarlo al aula. Las recetas se agrupan en seis categorías: <strong>planeación, evaluación, adaptación (DUA y PIAR), recursos, retroalimentación y gestión</strong>, y cubren desde Transición hasta 11.°.</p>
<p>Además, el kit incluye <strong>cadenas de trabajo</strong> que encadenan varias recetas para producir una unidad completa, un banco de <strong>rúbricas</strong> con la escala Superior, Alto, Básico y Bajo, una lista de <strong>errores típicos de la IA en ciencias</strong> (datos desactualizados, preconcepciones, procedimientos inseguros, ejemplos ajenos a Colombia) y un <strong>banco de contextos colombianos</strong> listos para convertir en situaciones problema. Regla de oro: la IA propone, usted decide. Ningún resultado se usa sin la revisión que indica cada receta.</p>',

    'referentes_html' => '<p><strong>Lineamientos curriculares de Ciencias Naturales y Educación Ambiental (MEN, 1998).</strong> Plantean la enseñanza de las ciencias como construcción de conocimiento a partir de la pregunta, la exploración y la relación con el entorno, y la educación ambiental como eje transversal.</p>
<p><strong>Estándares Básicos de Competencias en Ciencias Naturales (MEN, 2004; compilados en la publicación de 2006).</strong> Se organizan por grupos de grados (1.° a 3.°, 4.° y 5.°, 6.° y 7.°, 8.° y 9.°, 10.° y 11.°) y en tres columnas: <em>me aproximo al conocimiento como científico(a) natural</em> (procesos de indagación), <em>manejo conocimientos propios de las ciencias naturales</em> (entorno vivo, entorno físico y ciencia, tecnología y sociedad; en 10.° y 11.° el entorno físico se separa en procesos químicos y procesos físicos) y <em>desarrollo compromisos personales y sociales</em>.</p>
<p><strong>Derechos Básicos de Aprendizaje de Ciencias Naturales (MEN, 2016).</strong> Van de 1.° a 11.°; cada DBA enuncia un aprendizaje estructurante y trae evidencias de aprendizaje observables. En este kit se citan por su contenido (por ejemplo, «el DBA de 6.° sobre la célula como unidad estructural de los seres vivos») y no por su número: copie siempre el texto oficial en el prompt para que la IA no lo invente. Para Transición, el referente son los DBA de Transición y las Bases Curriculares para la Educación Inicial y Preescolar, organizadas alrededor del juego, el arte, la literatura y la exploración del medio.</p>
<p><strong>Pruebas Saber (ICFES).</strong> En Saber 11 la prueba de Ciencias Naturales evalúa tres competencias: <em>uso comprensivo del conocimiento científico</em>, <em>explicación de fenómenos</em> e <em>indagación</em>, en los componentes biológico, químico, físico y ciencia, tecnología y sociedad (CTS). En Saber 5.° y 9.° (y en las aplicaciones que han incluido 7.°) la prueba de Ciencias Naturales y Educación Ambiental usa las mismas competencias, con componentes de entorno vivo, entorno físico y CTS. Consulte siempre la guía de orientación vigente del ICFES, porque las especificaciones y los grados aplicados cambian entre años.</p>
<p><strong>Normas que enmarcan el área.</strong> Ley 115 de 1994 (área obligatoria de Ciencias Naturales y Educación Ambiental), Decreto 1743 de 1994 (Proyectos Ambientales Escolares, PRAE), Ley 1549 de 2012 (Política Nacional de Educación Ambiental), Decreto 1290 de 2009 (evaluación y escala nacional: Superior, Alto, Básico y Bajo) y Decreto 1421 de 2017 (educación inclusiva, ajustes razonables y PIAR).</p>',

    'mapa' => [
        [
            'grados' => 'Transición a 3.°',
            'enfoque' => 'Exploración con los sentidos, asombro y pregunta. Los niños describen, comparan y clasifican seres vivos, objetos y materiales de su entorno, y registran con dibujos y palabras sencillas.',
            'claves' => [
                'En Transición se trabaja desde las actividades rectoras (juego, arte, literatura y exploración del medio), no con guías de transcripción.',
                'Seres vivos y no vivos, necesidades de plantas y animales, ciclos de vida observables (frijol, mariposa, gallina).',
                'Propiedades de los materiales (duro, blando, flota, se hunde) y cambios sencillos (hielo que se derrite).',
                'Cuidado del agua, del cuerpo y de los animales del entorno; nunca maltratar ni retener animales.',
                'Registro con dibujos, tablas de conteo y frases cortas; preguntas del tipo «¿qué pasaría si...?».',
            ],
        ],
        [
            'grados' => '4.° y 5.°',
            'enfoque' => 'De describir a explicar: relaciones entre seres vivos y su ambiente, funciones del cuerpo humano, propiedades de la materia y fenómenos de luz, sonido y electricidad. Primer contacto formal con el diseño de experimentos sencillos y con Saber 5.°.',
            'claves' => [
                'Ecosistemas colombianos cercanos: cadenas y redes tróficas, adaptaciones, especies endémicas y amenazadas.',
                'Sistemas del cuerpo humano (digestivo, circulatorio, respiratorio) y hábitos de cuidado.',
                'Mezclas y métodos de separación con materiales caseros; estados de la materia.',
                'Circuitos eléctricos sencillos, luz y sombra, sonido y vibración; el sistema solar y el movimiento de la Tierra.',
                'Variables en un experimento: qué cambio, qué mido, qué mantengo igual.',
            ],
        ],
        [
            'grados' => '6.° y 7.°',
            'enfoque' => 'Niveles de organización de la vida y modelo de partículas de la materia. Los estudiantes empiezan a usar modelos para explicar y a interpretar tablas y gráficas.',
            'claves' => [
                'La célula como unidad estructural y funcional; organización de los seres vivos y clasificación.',
                'Nutrición en plantas y animales; fotosíntesis y respiración celular como procesos complementarios.',
                'Sustancias puras y mezclas, cambios físicos y químicos, modelo de partículas.',
                'Fuerzas, movimiento y energía en situaciones cotidianas; máquinas simples.',
                'La Tierra: capas, placas tectónicas, volcanes y sismos en Colombia; flujo de energía en ecosistemas.',
            ],
        ],
        [
            'grados' => '8.° y 9.°',
            'enfoque' => 'Explicaciones con mecanismos: reproducción, herencia y evolución; estructura atómica, tabla periódica y reacciones; ondas, presión y calor. Preparación de Saber 9.° con énfasis en explicación de fenómenos e indagación.',
            'claves' => [
                'Reproducción y herencia (genética mendeliana), evolución y biodiversidad colombiana.',
                'Sistemas de regulación (nervioso, endocrino) y salud sexual y reproductiva con enfoque de derechos.',
                'Modelos atómicos, tabla periódica, enlace químico, ecuaciones y balanceo.',
                'Presión (incluida la atmosférica y su relación con la altitud), calor y temperatura, ondas y sonido.',
                'Diseño de experimentos con control de variables, análisis de datos y conclusiones con evidencia.',
            ],
        ],
        [
            'grados' => '10.° y 11.°',
            'enfoque' => 'Química y física como disciplinas con lenguaje matemático, articuladas con biología y CTS. Problemas socio-científicos colombianos y preparación de Saber 11 en las tres competencias y los cuatro componentes.',
            'claves' => [
                'Química: estequiometría, gases, soluciones y concentración, ácidos y bases, equilibrio, química orgánica.',
                'Física: cinemática, dinámica, energía y su conservación, ondas, termodinámica, electricidad y magnetismo.',
                'Biología integrada: homeostasis, genética molecular, evolución y ecología de poblaciones.',
                'CTS: minería, agua, energía, cambio climático, especies invasoras y salud pública con datos reales.',
                'Lectura de gráficas y diseños experimentales en formato Saber 11; argumentación con evidencia.',
            ],
        ],
    ],

    'recetas' => [
        [
            'id' => 'NAT-01',
            'categoria' => 'planeacion',
            'titulo' => 'Secuencia didáctica completa a partir de un DBA',
            'grados' => '1.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Al iniciar una unidad o un periodo, cuando tiene el DBA y el número de sesiones, pero no la ruta clase a clase.',
            'variables' => [
                '[GRADO]' => 'Grado y, si aplica, jornada (ej.: 6.° jornada tarde).',
                '[MUNICIPIO_REGION]' => 'Municipio y región (ej.: Fusagasugá, Cundinamarca).',
                '[DBA]' => 'Texto completo del DBA copiado del documento oficial del MEN.',
                '[EVIDENCIAS]' => 'Las evidencias de aprendizaje del DBA que va a priorizar.',
                '[ESTANDAR]' => 'Estándar o estándares asociados, copiados del documento oficial.',
                '[N_SESIONES]' => 'Número de sesiones y duración de cada una (ej.: 6 sesiones de 55 minutos).',
                '[RECURSOS]' => 'Lo que sí tiene: patio, huerta, celulares, video beam, lupas, etc.',
                '[LIMITACIONES]' => 'Lo que no tiene: laboratorio, internet, microscopios, etc.',
                '[CARACTERISTICAS]' => 'Rasgos del grupo: tamaño, ritmos, estudiantes con PIAR, intereses.',
            ],
            'prompt' => 'Actúa como un docente colombiano experto en didáctica de las ciencias naturales, con dominio de los Estándares Básicos de Competencias del MEN, los Derechos Básicos de Aprendizaje (DBA) y la evaluación formativa con la escala del Decreto 1290 (Superior, Alto, Básico, Bajo).

CONTEXTO
- Grado: [GRADO]. Institución en [MUNICIPIO_REGION].
- DBA (texto oficial, no lo modifiques): "[DBA]"
- Evidencias de aprendizaje que priorizo: [EVIDENCIAS]
- Estándar(es) asociado(s): [ESTANDAR]
- Tiempo: [N_SESIONES].
- Recursos disponibles: [RECURSOS]. No contamos con: [LIMITACIONES].
- Características del grupo: [CARACTERISTICAS].

TAREA
Diseña una secuencia didáctica organizada en cuatro momentos: (1) exploración de ideas previas, (2) construcción de nuevos conocimientos, (3) estructuración y síntesis, (4) aplicación y evaluación. Ancla toda la secuencia en UN fenómeno o situación problema real de [MUNICIPIO_REGION] o de su región natural, que los estudiantes puedan observar o reconocer, y formúlalo como una pregunta orientadora que no se responda con una sola palabra.

FORMATO DE SALIDA
1. Pregunta orientadora y fenómeno ancla (máximo 5 líneas, explicando por qué es pertinente para el grupo).
2. Tabla resumen con columnas: Sesión | Momento | Propósito | Actividad central | Evidencia de aprendizaje que alimenta | Producto o registro del estudiante.
3. Desarrollo de cada sesión: inicio (con la pregunta que hará el docente, textual), desarrollo (pasos numerados con tiempos), cierre (pregunta de salida o ticket de salida).
4. Evaluación formativa: tres puntos de control durante la secuencia y una tarea final con criterios descritos para Superior, Alto, Básico y Bajo.
5. Ajustes DUA: al menos una opción de representación, una de acción y expresión y una de implicación, concretas para este tema.
6. Lista de materiales con cantidades para el grupo y costo aproximado en pesos colombianos.

RESTRICCIONES
- No inventes DBA, números de DBA, estándares ni citas de documentos oficiales: trabaja solo con el texto que te entregué.
- Experimentos únicamente con materiales domésticos seguros; nada de fuego abierto, sustancias corrosivas, productos de limpieza mezclados ni animales vivos retenidos.
- Usa unidades del Sistema Internacional y ejemplos de Colombia (no de Estados Unidos ni Europa).
- Si un dato científico o una cifra depende de la fuente, márcalo con [POR CONFIRMAR].
- Anticipa las preconcepciones más comunes del tema y diseña al menos una actividad que las ponga en conflicto.

AUTOVERIFICACIÓN (hazla antes de entregar y muéstrala al final en máximo 6 viñetas)
a) Cada evidencia priorizada aparece en al menos una sesión. b) Los tiempos de cada sesión suman su duración. c) Ninguna actividad refuerza una preconcepción. d) Todo material se consigue en [MUNICIPIO_REGION]. e) Los criterios de evaluación miden la evidencia, no la presentación. f) Lista de datos marcados con [POR CONFIRMAR].',
            'seguimientos' => [
                'Convierte la sesión 3 en una guía de trabajo para el estudiante de máximo dos páginas, con espacios para registrar y una tabla de datos.',
                'Reescribe la tarea final para que tenga una versión para estudiantes que no tienen celular ni internet en casa.',
                'Propón 5 preguntas de salida (una por sesión) que me permitan saber en 2 minutos quién va bien y quién no.',
                'Identifica qué parte de la secuencia es la más débil frente al DBA y propón cómo fortalecerla sin agregar sesiones.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 6.° jornada mañana; [MUNICIPIO_REGION] Sogamoso, Boyacá; [DBA] texto oficial del DBA de 6.° sobre la célula como unidad estructural y funcional de los seres vivos; [N_SESIONES] 6 sesiones de 55 minutos; [RECURSOS] celulares de los estudiantes (no todos), video beam, huerta escolar; [LIMITACIONES] sin microscopios ni laboratorio; [CARACTERISTICAS] 38 estudiantes, dos con PIAR (discapacidad intelectual leve), muy interesados en el lago de Tota y los cultivos de cebolla.',
                'resultado_html' => '<p><strong>Pregunta orientadora:</strong> ¿En qué se parecen por dentro una hoja de cebolla larga de Aquitania y la piel de nuestra mano, si las dos están vivas?</p>
<table><tr><th>Sesión</th><th>Momento</th><th>Actividad central</th><th>Producto</th></tr>
<tr><td>1</td><td>Exploración</td><td>Dibujo «¿qué hay dentro de una hoja?» y muro de hipótesis; observación de la epidermis de cebolla con lupa y gota de agua.</td><td>Dibujo inicial con rótulos</td></tr>
<tr><td>2</td><td>Construcción</td><td>Microscopio casero: lente de un apuntador láser dañado pegada sobre la cámara del celular (un celular por equipo de 5).</td><td>Foto y dibujo de células de cebolla</td></tr>
<tr><td>3</td><td>Construcción</td><td>Modelo de célula en bolsa resellable con gel de almidón (citoplasma) y semillas o botones (organelos); comparación célula vegetal y animal.</td><td>Modelo y tabla de semejanzas</td></tr>
<tr><td>4</td><td>Estructuración</td><td>Mapa de niveles: célula, tejido, órgano, sistema, organismo, con ejemplos de la huerta.</td><td>Mapa conceptual</td></tr>
<tr><td>5</td><td>Aplicación</td><td>Problema: ¿por qué la cebolla que se riega con agua salada se marchita? Explicación con el modelo.</td><td>Explicación escrita</td></tr>
<tr><td>6</td><td>Evaluación</td><td>Galería de modelos y prueba corta con dos preguntas tipo Saber.</td><td>Autoevaluación y prueba</td></tr></table>
<p><strong>Preconcepción que se confronta (sesión 3):</strong> «las células son planas, como en el dibujo del libro». El modelo en bolsa obliga a pensar en volumen.</p>
<p><strong>Ajuste DUA:</strong> para los estudiantes con PIAR, la tarjeta de organelos trae imagen, nombre y función en una frase; su evidencia es ubicar membrana, núcleo y pared celular en el modelo y explicar oralmente una diferencia.</p>',
            ],
            'revisar' => [
                'Que el DBA que aparece en la respuesta sea textualmente el que usted pegó (la IA tiende a «mejorarlo»).',
                'Que el experimento propuesto sea seguro: sin fuego, sin vidrio roto manipulado por estudiantes, sin sustancias corrosivas.',
                'Que el tiempo sea realista para su grupo (la IA subestima el tiempo de organizar equipos y recoger materiales).',
                'Que el fenómeno ancla sea realmente local y no un ejemplo genérico con nombre colombiano pegado.',
                'Los datos marcados con [POR CONFIRMAR], contrastados con una fuente oficial antes de imprimir.',
            ],
        ],
        [
            'id' => 'NAT-02',
            'categoria' => 'planeacion',
            'titulo' => 'Proyecto de indagación STEM con un problema real de la comunidad',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 3 h',
            'cuando' => 'Para proyectos de periodo, ferias de la ciencia o articulación con el PRAE, cuando quiere que los estudiantes investiguen y diseñen una solución a un problema que existe de verdad.',
            'variables' => [
                '[GRADO]' => 'Grado o grados que participan.',
                '[PROBLEMA]' => 'Problema local observable (ej.: agua lluvia almacenada sin tratar, erosión en la ladera, ruido en el colegio).',
                '[LUGAR]' => 'Municipio, vereda o barrio y región.',
                '[SEMANAS]' => 'Duración del proyecto en semanas y horas por semana.',
                '[AREAS]' => 'Áreas que se integran (matemáticas, tecnología, sociales, etc.).',
                '[PRESUPUESTO]' => 'Presupuesto máximo por equipo en pesos.',
                '[PRODUCTO]' => 'Producto final esperado (prototipo, campaña, informe para la junta de acción comunal, etc.).',
            ],
            'prompt' => 'Actúa como asesor de proyectos escolares de ciencia, tecnología, ingeniería y matemáticas (STEM) en Colombia, con experiencia en el programa Ondas de Minciencias y en enseñanza por indagación.

CONTEXTO
- Grado(s): [GRADO]. Lugar: [LUGAR].
- Problema real que observamos: [PROBLEMA].
- Duración: [SEMANAS]. Áreas que se integran: [AREAS].
- Presupuesto máximo por equipo: [PRESUPUESTO]. Producto final: [PRODUCTO].

TAREA
Diseña un proyecto de indagación en cinco fases: (1) comprender el problema (preguntas, actores, datos existentes), (2) formular una pregunta investigable y una hipótesis, (3) diseñar y realizar una investigación con variables controladas y mediciones repetidas, (4) diseñar, construir y probar una solución con ciclos de mejora, (5) comunicar resultados a una audiencia real de la comunidad.

FORMATO DE SALIDA
1. Tres preguntas investigables posibles, ordenadas de la más sencilla a la más exigente, indicando variable independiente, dependiente y controladas de cada una.
2. Cronograma semanal en tabla: Semana | Fase | Lo que hacen los estudiantes | Lo que hace el docente | Entregable.
3. Protocolo de medición: qué medir, con qué instrumento casero o de bajo costo, cuántas repeticiones, cómo registrar (plantilla de tabla de datos).
4. Criterios de diseño y restricciones de la solución (costo, seguridad, materiales locales, mantenimiento).
5. Conexiones explícitas con cada área de [AREAS].
6. Plan de seguridad: riesgos y medidas para cada actividad práctica.
7. Rúbrica del proyecto con 4 criterios en escala Superior, Alto, Básico y Bajo.

RESTRICCIONES
- La investigación debe ser realizable por estudiantes con materiales de bajo costo; si una medición requiere laboratorio certificado, dilo y ofrece un indicador alternativo escolar.
- Los resultados escolares no reemplazan análisis oficiales: incluye una advertencia clara cuando el tema sea salud o agua de consumo.
- Nada de ingerir, oler directamente ni manipular sustancias peligrosas; nada de trabajo en ríos crecidos, alturas o vías.
- Usa datos y actores reales de Colombia (corporación autónoma regional, empresa de servicios públicos, junta de acción comunal); si no estás seguro de un nombre o un dato, márcalo con [POR CONFIRMAR].

AUTOVERIFICACIÓN
Al final, confirma en una lista breve: la pregunta investigable es medible con los recursos; hay control de variables y repeticiones; la solución responde al problema y no a otro; el plan de seguridad cubre cada actividad práctica; el producto llega a una audiencia real.',
            'seguimientos' => [
                'Redacta la carta formal dirigida a [ACTOR LOCAL] invitándolo a la socialización de resultados.',
                'Crea la bitácora del estudiante con una página por semana y preguntas de reflexión metacognitiva.',
                'Dame tres maneras de presentar los datos (tabla, gráfica de barras, gráfica de dispersión) y cuándo conviene cada una para este proyecto.',
                'Propón cómo evaluar el trabajo individual dentro del equipo sin que dependa de la autoevaluación.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [LUGAR] institución rural de Lloró, Chocó, región Pacífica; [PROBLEMA] la escuela recoge agua lluvia en tanques y algunos niños la beben sin tratar; [SEMANAS] 8 semanas, 4 horas semanales; [AREAS] matemáticas y tecnología; [PRESUPUESTO] 30.000 pesos por equipo; [PRODUCTO] protocolo ilustrado de manejo del agua lluvia para la escuela y las familias.',
                'resultado_html' => '<p><strong>Preguntas investigables:</strong></p>
<ol><li>¿Cómo cambia la turbidez del agua lluvia almacenada según los días que lleva en el tanque? (VI: días; VD: turbidez con disco de Secchi casero en tubo transparente; controladas: mismo tanque, misma hora, mismo recipiente).</li>
<li>¿Qué combinación de capas (arena fina, arena gruesa, gravilla, carbón vegetal) reduce más la turbidez? (VI: orden y espesor de capas; VD: turbidez; controladas: volumen de agua, tiempo de filtrado).</li>
<li>¿Cuántas horas de exposición solar en botella PET transparente necesita el agua filtrada para pasar la prueba de desinfección del método SODIS en días nublados, típicos de la región? (punto de partida: la guía del método SODIS indica 6 horas de sol cuando menos de la mitad del cielo está nublado y dos días consecutivos cuando está nublado más de la mitad; requiere apoyo de un laboratorio aliado para el análisis microbiológico; indicador escolar: registro de radiación con app y horas de sol).</li></ol>
<p><strong>Advertencia que debe ir en el protocolo:</strong> el filtro escolar mejora la apariencia del agua, pero no garantiza que sea potable. Ningún estudiante bebe el agua de los ensayos. El protocolo final se revisa con el personal de salud del municipio antes de compartirlo con las familias.</p>
<p><strong>Conexión con matemáticas:</strong> promedio y rango de tres mediciones por ensayo; gráfica de turbidez contra número de capas; cálculo del volumen del tanque y de los litros captados con la precipitación de un mes.</p>',
            ],
            'revisar' => [
                'Que ninguna actividad implique beber, oler o tocar agua o sustancias potencialmente contaminadas.',
                'Que la pregunta investigable tenga una sola variable independiente.',
                'Que las entidades mencionadas existan con ese nombre en su región (corporaciones autónomas, empresas de servicios).',
                'Que el producto final no prometa más de lo que una investigación escolar puede sostener.',
            ],
        ],
        [
            'id' => 'NAT-03',
            'categoria' => 'recursos',
            'titulo' => 'Práctica de laboratorio segura con materiales de bajo costo',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Cuando no hay laboratorio dotado o reactivos, y quiere una práctica experimental real, segura y con guía para el estudiante.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[CONCEPTO]' => 'Concepto o fenómeno que se quiere evidenciar.',
                '[ESPACIO]' => 'Dónde se hará: aula, patio, laboratorio sin dotación, etc.',
                '[N_EQUIPOS]' => 'Número de equipos y estudiantes por equipo.',
                '[DURACION]' => 'Duración de la sesión.',
                '[MATERIALES_DISPONIBLES]' => 'Materiales que ya tiene o que los estudiantes pueden traer.',
            ],
            'prompt' => 'Actúa como docente de ciencias naturales en Colombia, experto en prácticas experimentales con materiales de bajo costo y en seguridad escolar.

CONTEXTO
- Grado: [GRADO]. Concepto que quiero evidenciar: [CONCEPTO].
- Espacio: [ESPACIO]. Equipos: [N_EQUIPOS]. Duración: [DURACION].
- Materiales disponibles: [MATERIALES_DISPONIBLES].

TAREA
Diseña una práctica experimental que permita a los estudiantes observar, medir y explicar [CONCEPTO]. Incluye una versión para el docente y una guía para el estudiante.

FORMATO DE SALIDA
A. Para el docente
1. Objetivo en términos de lo que el estudiante podrá explicar.
2. Fundamento científico en máximo 8 líneas, correcto y al nivel del grado.
3. Materiales por equipo (con cantidades) y sustituciones posibles con cosas de la casa o la tienda del barrio.
4. Análisis de riesgos en tabla: Paso | Riesgo | Medida de prevención | Qué hacer si ocurre.
5. Resultados esperados y errores experimentales frecuentes.
6. Disposición de residuos (qué va a la caneca, qué se puede echar al desagüe con abundante agua, qué NO).
B. Para el estudiante (máximo dos páginas)
1. Pregunta de investigación y predicción («yo creo que... porque...»).
2. Procedimiento en pasos numerados, con verbos de acción.
3. Tabla de datos lista para llenar, con unidades.
4. Tres preguntas de análisis: una de describir, una de explicar con el concepto y una de transferir a una situación de Colombia.
5. Normas de seguridad en lenguaje directo.

RESTRICCIONES DE SEGURIDAD (obligatorias)
- Prohibido: mezclar productos de limpieza (en especial hipoclorito o cloro con vinagre, amoníaco u otros), soda cáustica, destapacañerías, ácido muriático, alcohol cerca de llamas, mercurio o termómetros de mercurio, fuego abierto manejado por estudiantes.
- Si se requiere calor, usa agua caliente servida por el docente o una plancha eléctrica manipulada solo por el docente.
- Gafas de protección o, como mínimo, distancia de seguridad cuando haya salpicaduras posibles.
- Nada se prueba con la boca ni se huele directamente.
Si el concepto no puede trabajarse con seguridad bajo estas condiciones, dilo y propone una simulación o una demostración del docente.

AUTOVERIFICACIÓN
Revisa paso a paso tu procedimiento y confirma: (a) ningún paso viola las restricciones; (b) las cantidades son consistentes entre la guía del docente y la del estudiante; (c) el fundamento no contiene errores conceptuales; (d) los resultados esperados realmente se observan con esos materiales. Informa cualquier ajuste que hiciste.',
            'seguimientos' => [
                'Convierte la práctica en una indagación abierta: que los estudiantes elijan qué variable cambiar.',
                'Redacta una versión de la guía con pictogramas para estudiantes de primaria o con dificultades de lectura.',
                'Agrega una pregunta tipo Saber con la tabla de datos de esta práctica.',
                'Propón una extensión para la casa que solo use lo que hay en una cocina colombiana.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [CONCEPTO] ácidos, bases y escala de pH con indicadores naturales; [ESPACIO] aula sin laboratorio, con lavamanos cercano; [N_EQUIPOS] 8 equipos de 4; [DURACION] 2 horas; [MATERIALES_DISPONIBLES] repollo morado, vasos desechables reutilizados, vinagre, limones, bicarbonato, jabón de barra, gaseosa, agua.',
                'resultado_html' => '<p><strong>Fundamento:</strong> el repollo morado contiene antocianinas, pigmentos que cambian de color según la acidez del medio. En soluciones ácidas tienden al rojo o rosado, cerca de la neutralidad al morado y en soluciones básicas al azul, verde y, si son muy básicas, al amarillo.</p>
<table><tr><th>Paso</th><th>Riesgo</th><th>Prevención</th><th>Si ocurre</th></tr>
<tr><td>Preparar el extracto</td><td>Quemadura con agua caliente</td><td>El docente sirve el agua caliente y entrega el extracto ya tibio</td><td>Agua fría corriente 10 minutos y aviso a enfermería</td></tr>
<tr><td>Probar sustancias</td><td>Salpicadura en ojos (limón, vinagre)</td><td>Gafas o distancia de un brazo; goteros o pitillos para agregar</td><td>Lavar con abundante agua 15 minutos</td></tr>
<tr><td>Sustancias traídas de casa</td><td>Mezclas peligrosas</td><td>Solo se usan las sustancias de la lista; los productos de limpieza no entran al aula</td><td>Retirar el producto y ventilar</td></tr></table>
<p><strong>Tabla del estudiante:</strong> Sustancia | Mi predicción (ácida, neutra, básica) | Color observado | Clasificación según el color.</p>
<p><strong>Pregunta de transferencia:</strong> en algunas zonas cafeteras se aplica cal agrícola a los suelos. Si un suelo ácido se tratara con cal, ¿qué color esperarías con el indicador en una muestra de agua de ese suelo antes y después? Explica.</p>
<p><strong>Residuos:</strong> todas las mezclas de esta práctica pueden ir al desagüe con abundante agua; los restos de repollo, a la caneca de orgánicos o al compostaje de la huerta.</p>',
            ],
            'revisar' => [
                'Leer todo el procedimiento buscando mezclas de productos de limpieza o uso de llama; la IA a veces las propone «para que sea más llamativo».',
                'Comprobar que las cantidades dan para todos los equipos y que el costo es realista.',
                'Hacer la práctica usted antes de la clase: los colores y los tiempos reales casi nunca coinciden con lo que describe la IA.',
                'Verificar que el fundamento no diga que el indicador «mide el pH exacto»: solo permite estimar rangos.',
            ],
        ],
        [
            'id' => 'NAT-04',
            'categoria' => 'evaluacion',
            'titulo' => 'Ítems tipo Saber 11 con contexto, clave y justificación de distractores',
            'grados' => '10.° y 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Para simulacros, evaluaciones de periodo o talleres de preparación de Saber 11 que midan competencias y no memoria.',
            'variables' => [
                '[COMPONENTE]' => 'Biológico, químico, físico o ciencia, tecnología y sociedad (CTS).',
                '[COMPETENCIA]' => 'Uso comprensivo del conocimiento científico, explicación de fenómenos o indagación.',
                '[TEMA]' => 'Tema o concepto específico (ej.: presión de vapor y punto de ebullición).',
                '[N_ITEMS]' => 'Cantidad de ítems.',
                '[CONTEXTO_LOCAL]' => 'Situación colombiana que debe servir de contexto.',
                '[PRECONCEPCIONES]' => 'Errores frecuentes de sus estudiantes en ese tema, si los conoce.',
            ],
            'prompt' => 'Actúa como constructor de ítems con experiencia en el diseño de pruebas estandarizadas tipo Saber 11 del ICFES para Ciencias Naturales. Conoces el modelo basado en evidencias: cada ítem se diseña a partir de una afirmación (lo que el estudiante sabe hacer) y una evidencia observable.

ESPECIFICACIONES
- Componente: [COMPONENTE]. Competencia: [COMPETENCIA].
- Tema: [TEMA]. Número de ítems: [N_ITEMS].
- Contexto: [CONTEXTO_LOCAL].
- Preconcepciones frecuentes en mi grupo: [PRECONCEPCIONES].

TAREA
Construye [N_ITEMS] ítems de selección múltiple con única respuesta (cuatro opciones: A, B, C, D). Cada ítem debe:
1. Tener un contexto breve (situación, tabla, gráfica descrita o experimento) que sea necesario leer para responder.
2. Tener un enunciado que no dé pistas gramaticales ni de longitud hacia la clave.
3. Tener tres distractores plausibles, cada uno basado en un error conceptual o de razonamiento real (no opciones absurdas).

FORMATO DE SALIDA (para cada ítem)
- Afirmación y evidencia que mide.
- Contexto.
- Enunciado.
- Opciones A a D.
- Clave.
- Justificación de la clave (por qué es correcta, en 3 a 5 líneas).
- Justificación de cada distractor: qué error de pensamiento lleva a elegirlo y qué le diría el docente al estudiante que lo eligió.
- Nivel de dificultad estimado (bajo, medio, alto) con una razón.

RESTRICCIONES
- Si la competencia es indagación, el ítem debe exigir analizar un diseño experimental, identificar variables, elegir el procedimiento adecuado o interpretar datos; no preguntar definiciones.
- Si es explicación de fenómenos, debe pedir elegir o evaluar una explicación con modelos científicos.
- Si es uso comprensivo, debe pedir aplicar un concepto a una situación nueva, no recordar su definición.
- La clave debe estar distribuida: no más de dos ítems seguidos con la misma letra.
- Evita «todas las anteriores», «ninguna de las anteriores» y dobles negaciones.
- Los datos numéricos deben ser físicamente coherentes; si son aproximados, indícalo.

AUTOVERIFICACIÓN
Resuelve tú mismo cada ítem como lo haría un estudiante, en dos líneas, y confirma que: solo hay una respuesta defendible; la clave no es la opción más larga; el contexto es indispensable; los datos son correctos. Si encuentras un problema, corrige el ítem antes de entregarlo y di qué cambiaste.',
            'seguimientos' => [
                'Convierte el ítem 2 en un ítem de indagación usando los mismos datos.',
                'Elabora una tabla de especificaciones de la prueba: ítem, componente, competencia, clave, dificultad.',
                'Reescribe los distractores del ítem 3: dos de ellos se pueden descartar sin saber el tema.',
                'Prepara la retroalimentación que leeré en voz alta después de la prueba, ítem por ítem, en máximo 4 líneas cada uno.',
            ],
            'ejemplo' => [
                'contexto' => '[COMPONENTE] químico; [COMPETENCIA] explicación de fenómenos; [TEMA] presión atmosférica y punto de ebullición; [N_ITEMS] 1 (se muestra uno); [CONTEXTO_LOCAL] estudiantes de Bogotá y Cartagena comparan la temperatura a la que hierve el agua; [PRECONCEPCIONES] creen que el agua siempre hierve a 100 °C.',
                'resultado_html' => '<p><strong>Afirmación:</strong> explica cómo la presión externa afecta los cambios de estado. <strong>Evidencia:</strong> relaciona la presión atmosférica con la temperatura de ebullición.</p>
<p><strong>Contexto:</strong> Laura, en Bogotá (aproximadamente 2.600 m sobre el nivel del mar), mide con un termómetro digital que el agua de una olla hierve a cerca de 92 °C. Su primo Andrés, en Cartagena (nivel del mar), repite la medición y obtiene cerca de 100 °C. Los dos usan agua de la llave y ollas similares.</p>
<p><strong>Enunciado:</strong> ¿Cuál de las siguientes explicaciones da cuenta de la diferencia?</p>
<ol type="A"><li>En Bogotá la presión atmosférica es menor, por lo que la presión de vapor del agua iguala la presión externa a una temperatura más baja.</li>
<li>En Bogotá el ambiente es más frío, por lo que el agua pierde calor continuamente y no logra llegar a 100 °C.</li>
<li>El agua de Bogotá tiene menos sales disueltas y por eso necesita menos energía para empezar a hervir.</li>
<li>A mayor altitud hay menos oxígeno en el aire, y el oxígeno es necesario para que el agua hierva.</li></ol>
<p><strong>Clave:</strong> A. La ebullición ocurre cuando la presión de vapor del líquido iguala la presión externa; a menor presión atmosférica, esa igualdad se alcanza a menor temperatura.</p>
<p><strong>Distractores:</strong> B confunde la temperatura ambiente con la temperatura de ebullición (en Bogotá se puede seguir calentando y el agua no supera los 92 °C mientras hierve). C usa una idea parcialmente real (los solutos elevan el punto de ebullición), pero el efecto es mínimo y no explica 8 °C de diferencia. D trata la ebullición como si fuera una combustión.</p>
<p><strong>Dificultad:</strong> media; exige superar la idea escolar de que «el agua hierve a 100 °C» sin condiciones.</p>',
            ],
            'revisar' => [
                'Resolver cada ítem usted mismo sin mirar la clave.',
                'Que la clave no sea siempre la opción más larga o más técnica.',
                'Que los datos sean coherentes (temperaturas, masas, unidades); la IA suele inventar valores imposibles.',
                'Que los ítems no reproduzcan textualmente preguntas liberadas del ICFES, que tienen derechos de autor.',
            ],
        ],
        [
            'id' => 'NAT-05',
            'categoria' => 'evaluacion',
            'titulo' => 'Ítems tipo Saber 5.° y 9.° para primaria y básica secundaria',
            'grados' => '4.° a 9.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Para evaluaciones de periodo o actividades de preparación de Saber 5.° y 9.°, con lenguaje adecuado a la edad y contextos cercanos.',
            'variables' => [
                '[GRADO]' => '4.°, 5.°, 6.°, 7.°, 8.° o 9.°.',
                '[COMPONENTE]' => 'Entorno vivo, entorno físico o ciencia, tecnología y sociedad.',
                '[COMPETENCIA]' => 'Uso comprensivo del conocimiento científico, explicación de fenómenos o indagación.',
                '[TEMA]' => 'Tema concreto.',
                '[ECOSISTEMA_O_SITUACION]' => 'Ecosistema o situación colombiana que el estudiante reconozca.',
                '[N_ITEMS]' => 'Cantidad de ítems.',
            ],
            'prompt' => 'Actúa como experto en evaluación de ciencias naturales para niños y adolescentes colombianos, con conocimiento de las pruebas Saber 5.° y 9.° de Ciencias Naturales y Educación Ambiental del ICFES.

ESPECIFICACIONES
- Grado: [GRADO]. Componente: [COMPONENTE]. Competencia: [COMPETENCIA].
- Tema: [TEMA]. Situación de contexto: [ECOSISTEMA_O_SITUACION].
- Número de ítems: [N_ITEMS], de selección múltiple con única respuesta y cuatro opciones.

TAREA Y REGLAS DE REDACCIÓN
1. Usa un contexto común para 2 o 3 ítems (como en las pruebas reales): un texto corto, una tabla sencilla o una ilustración descrita en palabras para que yo la dibuje.
2. Frases cortas, vocabulario del grado, máximo 60 palabras en cada contexto para 4.° y 5.° y 100 para 8.° y 9.°.
3. Nada de preguntas que se respondan con memoria de un nombre; cada ítem exige observar, relacionar o explicar.
4. Distractores basados en ideas reales de los niños (ej.: «las plantas comen tierra», «los animales grandes son los que más energía tienen»).
5. Organismos, lugares y nombres propios colombianos y diversos (regiones, etnias, campo y ciudad).

FORMATO DE SALIDA
Para cada ítem: contexto (o referencia al contexto común), enunciado, opciones A a D, clave, por qué es la clave, la idea errónea detrás de cada distractor y una pregunta de seguimiento oral para usar en clase con quien falló.
Al final, una tabla: Ítem | Componente | Competencia | Clave | Idea errónea más probable.

AUTOVERIFICACIÓN
Lee cada ítem como si fueras un niño de [GRADO]: señala cualquier palabra que podría no entender y reemplázala. Confirma que la información biológica o física del contexto es correcta para el ecosistema colombiano mencionado (especies que realmente viven allí). Si dudas de un dato, márcalo con [POR CONFIRMAR].',
            'seguimientos' => [
                'Haz una versión del mismo contexto para estudiantes con PIAR: mismo concepto, opciones con apoyo visual descrito y frases aún más cortas.',
                'Convierte los ítems en una actividad de clase: los estudiantes discuten en parejas por qué descartan cada opción.',
                'Crea dos ítems más con el mismo contexto, pero de la competencia indagación.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 5.°; [COMPONENTE] entorno vivo; [COMPETENCIA] explicación de fenómenos; [TEMA] cadenas alimentarias; [ECOSISTEMA_O_SITUACION] manglar de la bahía de Tumaco, Nariño; [N_ITEMS] 2 (se muestra uno).',
                'resultado_html' => '<p><strong>Contexto común:</strong> En el manglar de Tumaco, las hojas del mangle caen al agua y se descomponen. Los cangrejos se alimentan de esas hojas descompuestas. Las garzas se alimentan de cangrejos. Algunos pescadores de la zona cuentan que, donde se taló el manglar, ahora ven menos garzas.</p>
<p><strong>Enunciado:</strong> ¿Por qué hay menos garzas donde se taló el manglar?</p>
<ol type="A"><li>Porque sin mangle hay menos hojas, entonces hay menos alimento para los cangrejos y, por eso, menos cangrejos para las garzas.</li>
<li>Porque las garzas se alimentan directamente de las hojas del mangle.</li>
<li>Porque los cangrejos, al no tener mangle, se vuelven más grandes y se comen a las garzas.</li>
<li>Porque sin árboles hay más sol y las garzas solo viven en lugares oscuros.</li></ol>
<p><strong>Clave:</strong> A. Relaciona la pérdida del productor con la disminución de los niveles siguientes de la cadena.</p>
<p><strong>Ideas erróneas:</strong> B confunde a quién se come cada organismo; C invierte la relación depredador y presa; D da una explicación sin relación con la alimentación.</p>
<p><strong>Pregunta oral de seguimiento:</strong> «Si alguien siembra mangle de nuevo, ¿qué crees que pasará primero: llegan más garzas o llegan más cangrejos? ¿Por qué?»</p>',
            ],
            'revisar' => [
                'Que los organismos mencionados existan en ese ecosistema colombiano (la IA mezcla fauna de otros continentes).',
                'Que la longitud y el vocabulario sean adecuados para la edad.',
                'Que no haya dos opciones correctas desde otro punto de vista válido.',
                'Que el dibujo o la tabla descrita se pueda reproducir en una fotocopia en blanco y negro.',
            ],
        ],
        [
            'id' => 'NAT-06',
            'categoria' => 'adaptacion',
            'titulo' => 'Una lectura científica en tres niveles (DUA)',
            'grados' => '3.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Cuando tiene un buen texto científico pero su grupo tiene niveles de lectura muy distintos y no quiere que nadie se quede por fuera del concepto.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[TEXTO_BASE]' => 'El texto original (pegado completo) o el tema si no tiene texto.',
                '[CONCEPTOS_CLAVE]' => 'Conceptos que deben aparecer en los tres niveles.',
                '[PERFIL_DEL_GRUPO]' => 'Cómo leen sus estudiantes: cuántos con dificultades, cuántos avanzados, estudiantes con PIAR.',
            ],
            'prompt' => 'Actúa como especialista en Diseño Universal para el Aprendizaje (DUA) y en divulgación científica para estudiantes colombianos.

CONTEXTO
- Grado: [GRADO]. Perfil lector del grupo: [PERFIL_DEL_GRUPO].
- Texto base o tema: [TEXTO_BASE]
- Conceptos clave que no se pueden perder: [CONCEPTOS_CLAVE].

TAREA
Crea tres versiones del texto que enseñen los MISMOS conceptos clave con distinto nivel de apoyo:
- Nivel 1 (con apoyos): oraciones cortas, una idea por párrafo, glosario visual (describe la imagen o ícono que acompaña cada término), preguntas intercaladas para verificar comprensión.
- Nivel 2 (esperado para el grado): texto continuo con vocabulario científico definido en contexto.
- Nivel 3 (profundización): incluye un dato cuantitativo, una relación causal más compleja y una pregunta abierta para investigar.

FORMATO DE SALIDA
1. Los tres textos, cada uno con título atractivo distinto pero sin marcar «nivel bajo» o «nivel alto» (usa colores o símbolos neutros: círculo, triángulo, cuadrado).
2. Las mismas 4 preguntas de comprensión para los tres grupos (literal, inferencial, crítica y de transferencia a la vida del estudiante), para que la discusión final sea común.
3. Una actividad de cierre conjunta donde los tres grupos aporten algo distinto.
4. Tabla de control: Concepto clave | Cómo aparece en nivel 1 | nivel 2 | nivel 3.

RESTRICCIONES
- Simplificar no es distorsionar: ninguna versión puede contener una afirmación científica falsa, aunque sea para «hacerla fácil».
- Mantén ejemplos y datos colombianos; si el texto base trae ejemplos de otros países, propón un equivalente colombiano.
- Marca con [POR CONFIRMAR] toda cifra que no venga del texto base.

AUTOVERIFICACIÓN
Compara las tres versiones con la tabla de control y confirma que los conceptos clave están completos y correctos en las tres. Cuenta las palabras de cada versión y reporta el total.',
            'seguimientos' => [
                'Convierte el nivel 1 en un guion de audio de 2 minutos para estudiantes que aprenden mejor escuchando.',
                'Diseña un organizador gráfico que sirva para los tres niveles.',
                'Agrega a la versión 3 una fuente confiable (institución colombiana) que yo pueda verificar.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 6.°; [TEXTO_BASE] tema: el páramo como regulador del agua; [CONCEPTOS_CLAVE] ecosistema de alta montaña, frailejón, suelo que almacena agua, nacimiento de ríos, amenazas; [PERFIL_DEL_GRUPO] 35 estudiantes, 9 leen con dificultad, 6 avanzados, uno con PIAR por discapacidad intelectual.',
                'resultado_html' => '<p><strong>Versión círculo (con apoyos):</strong> «El páramo está en lo alto de las montañas. Allí hace frío y casi siempre hay neblina. [Ícono: montaña con nube.] En el páramo vive el frailejón. El frailejón tiene hojas peludas. Esas hojas atrapan el agua de la neblina. [Ícono: hoja con gotas.] El suelo del páramo es como una esponja: guarda el agua y la suelta poco a poco. Así nacen muchos ríos. Pregunta: ¿qué hace el suelo del páramo con el agua?»</p>
<p><strong>Versión triángulo (esperada):</strong> «Los páramos son ecosistemas de alta montaña, ubicados aproximadamente por encima de los 3.000 metros. Sus suelos, ricos en materia orgánica, retienen el agua como una esponja y la liberan lentamente, por eso allí nacen ríos que abastecen ciudades como Bogotá...»</p>
<p><strong>Versión cuadrado (profundización):</strong> incluye que el frailejón crece muy lentamente (en muchas especies, alrededor de un centímetro por año, aunque la tasa varía según la especie), y plantea: «Si una planta de dos metros se arranca, ¿cuántos años tardaría en recuperarse? ¿Qué implica eso para decidir si se permite el pastoreo o la papa en el páramo?»</p>
<p><strong>Pregunta crítica común:</strong> ¿Por qué una persona que vive en Bogotá o en Tunja debería preocuparse por un páramo que nunca ha visitado?</p>',
            ],
            'revisar' => [
                'Que la versión con apoyos no contenga simplificaciones falsas (ej.: «el frailejón fabrica el agua»).',
                'Que las tres versiones no se distingan con etiquetas que estigmaticen.',
                'Las cifras de profundización (altitudes, crecimiento, abastecimiento): verifique con Instituto Humboldt o la autoridad ambiental.',
            ],
        ],
        [
            'id' => 'NAT-07',
            'categoria' => 'adaptacion',
            'titulo' => 'Ajustes razonables para el PIAR en ciencias naturales',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Al diligenciar o actualizar el PIAR de un estudiante (Decreto 1421 de 2017) y necesitar ajustes concretos para el área, no frases genéricas.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[DESCRIPCION_ESTUDIANTE]' => 'Descripción pedagógica: fortalezas, intereses, barreras observadas en el aula (sin nombre ni diagnóstico médico detallado).',
                '[TIPO_DISCAPACIDAD]' => 'Categoría reportada en el SIMAT o en la valoración, si aplica.',
                '[UNIDAD]' => 'Unidad o tema que se trabajará y DBA asociado.',
                '[ACTIVIDADES_PREVISTAS]' => 'Actividades que hará el grupo (laboratorio, lectura, salida, prueba).',
                '[APOYOS_DISPONIBLES]' => 'Docente de apoyo, intérprete, familia, tecnología, etc.',
            ],
            'prompt' => 'Actúa como docente de apoyo pedagógico con experiencia en educación inclusiva en Colombia, conocedor del Decreto 1421 de 2017, el Plan Individual de Ajustes Razonables (PIAR) y el Diseño Universal para el Aprendizaje.

CONTEXTO
- Grado: [GRADO]. Unidad: [UNIDAD].
- Descripción pedagógica del estudiante: [DESCRIPCION_ESTUDIANTE].
- Categoría reportada: [TIPO_DISCAPACIDAD].
- Actividades previstas para el grupo: [ACTIVIDADES_PREVISTAS].
- Apoyos disponibles: [APOYOS_DISPONIBLES].

TAREA
Propón los ajustes razonables del área de Ciencias Naturales para esta unidad, partiendo de las barreras del contexto (no del déficit del estudiante).

FORMATO DE SALIDA
1. Barreras identificadas en las actividades previstas (de acceso, de participación y de aprendizaje).
2. Tabla de ajustes: Actividad | Barrera | Ajuste razonable | Quién lo implementa | Material o recurso.
3. Propósito de aprendizaje para el estudiante: indica si se mantiene el mismo DBA con ajustes de acceso o si se requiere flexibilizar el nivel de logro, y justifícalo.
4. Ajustes en la evaluación: formato, tiempo, apoyos, y descripción de cómo se vería un desempeño Básico, Alto y Superior para este estudiante.
5. Ajustes de seguridad en las prácticas experimentales.
6. Recomendaciones para la familia (máximo 4, concretas y realizables en casa).
7. Redacción breve para pegar en el formato del PIAR (máximo 12 líneas).

RESTRICCIONES
- No diagnostiques ni uses lenguaje clínico; describe desempeños y barreras observables.
- Los ajustes deben ser realizables por un docente con 35 o más estudiantes, sin recursos costosos.
- No reduzcas expectativas por defecto: primero ajustes de acceso, luego de nivel, y solo si es necesario.
- Lenguaje respetuoso: «estudiante con discapacidad», nunca «discapacitado» o «niño especial».

AUTOVERIFICACIÓN
Revisa que cada actividad prevista tenga al menos un ajuste, que la evaluación mida el mismo concepto que la del grupo (o explique por qué no) y que ningún ajuste aísle al estudiante de su grupo.',
            'seguimientos' => [
                'Redacta la guía de la práctica de laboratorio ya ajustada para este estudiante.',
                'Propón tres roles para el trabajo en equipo en los que este estudiante aporte desde sus fortalezas.',
                'Formula el seguimiento trimestral del PIAR: qué evidencias recoger y cómo valorarlas.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [DESCRIPCION_ESTUDIANTE] estudiante con baja visión, lee con macrotipo y lupa, excelente memoria auditiva, participa mucho en discusiones orales, se frustra cuando no alcanza a copiar del tablero; [TIPO_DISCAPACIDAD] discapacidad visual, baja visión; [UNIDAD] densidad y flotación; [ACTIVIDADES_PREVISTAS] práctica de medir masa y volumen, lectura de una gráfica, prueba escrita; [APOYOS_DISPONIBLES] docente de apoyo dos horas por semana, celular del estudiante.',
                'resultado_html' => '<table><tr><th>Actividad</th><th>Barrera</th><th>Ajuste razonable</th><th>Quién</th></tr>
<tr><td>Medir volumen por desplazamiento de agua</td><td>Lectura de la escala de la probeta</td><td>Probeta marcada con cinta de alto contraste cada 10 mL; uso de la cámara del celular con zoom para leer; compañero confirma la lectura en voz alta</td><td>Docente de área prepara; equipo apoya</td></tr>
<tr><td>Lectura de gráfica masa contra volumen</td><td>Tamaño y contraste de la gráfica</td><td>Gráfica en macrotipo (fuente 24, líneas gruesas) y versión en relieve con cordón pegado sobre cartulina</td><td>Docente de apoyo</td></tr>
<tr><td>Prueba escrita</td><td>Tiempo de lectura y copia</td><td>Prueba impresa en macrotipo, 50 % más de tiempo, opción de responder oralmente las preguntas abiertas</td><td>Docente de área</td></tr></table>
<p><strong>Propósito de aprendizaje:</strong> se mantiene el mismo DBA; los ajustes son de acceso, no de nivel. El estudiante debe explicar por qué unos objetos flotan y otros no usando la relación entre masa y volumen.</p>
<p><strong>Seguridad:</strong> superficie de trabajo despejada con bandeja para contener derrames; el estudiante trabaja siempre del mismo lado de la mesa para orientarse.</p>',
            ],
            'revisar' => [
                'Que no aparezcan diagnósticos ni datos sensibles del estudiante en lo que comparte con la IA: use descripciones pedagógicas, nunca el nombre.',
                'Que los ajustes sean coherentes con la valoración pedagógica real y con lo que dice la familia.',
                'Que lo que se redacte para el formato del PIAR coincida con el formato institucional y se firme según el procedimiento del colegio.',
            ],
        ],
        [
            'id' => 'NAT-08',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Retroalimentación formativa de informes de laboratorio',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h por curso',
            'cuando' => 'Cuando tiene muchos informes de laboratorio y quiere devolver comentarios específicos que mejoren el siguiente informe, no solo una nota.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PRACTICA]' => 'Nombre y propósito de la práctica.',
                '[CRITERIOS]' => 'Los criterios o la rúbrica con que evalúa los informes.',
                '[INFORME]' => 'Texto del informe del estudiante (sin nombre), o la parte que quiere revisar.',
                '[DATOS_ESPERADOS]' => 'Resultados que se esperaban con esos materiales.',
            ],
            'prompt' => 'Actúa como un docente de ciencias que da retroalimentación formativa siguiendo tres preguntas: ¿hacia dónde voy?, ¿cómo voy?, ¿qué sigue? Tu objetivo es que el estudiante mejore su próximo informe, no justificar una nota.

CONTEXTO
- Grado: [GRADO]. Práctica: [PRACTICA].
- Criterios de evaluación: [CRITERIOS].
- Resultados esperados con estos materiales: [DATOS_ESPERADOS].
- Informe del estudiante:
"""
[INFORME]
"""

TAREA
1. Identifica en el informe: la calidad de la hipótesis, el manejo de datos (tablas, unidades, repeticiones), el análisis (¿la conclusión se apoya en los datos?) y los errores conceptuales.
2. Escribe una retroalimentación dirigida al estudiante.

FORMATO DE SALIDA
A. Para el docente (no se entrega al estudiante): diagnóstico por criterio con la escala Superior, Alto, Básico o Bajo y la evidencia textual del informe que lo justifica (cita entre comillas).
B. Para el estudiante (máximo 150 palabras, en segunda persona, tono cálido y directo):
- Dos fortalezas específicas (no «buen trabajo»).
- Uno o dos aspectos por mejorar, formulados como pregunta que lo haga pensar.
- Una acción concreta para el próximo informe.
- Si hay un error conceptual, una pista para que lo descubra, no la respuesta.

RESTRICCIONES
- No reescribas el informe por el estudiante.
- No inventes datos del informe; si algo no está, dilo («no encontré la tabla de datos»).
- Distingue errores experimentales (normales y aprovechables) de errores conceptuales.

AUTOVERIFICACIÓN
Verifica que cada afirmación de la parte A esté respaldada por una cita del informe y que la parte B no supere 150 palabras.',
            'seguimientos' => [
                'Ahora dame la retroalimentación de los siguientes 5 informes en el mismo formato, y al final un resumen de los 3 errores más frecuentes del curso.',
                'Con esos errores frecuentes, diseña una minilección de 15 minutos para la próxima clase.',
                'Convierte la parte B en un audio corto: reescríbela para ser leída en voz alta en 40 segundos.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [PRACTICA] péndulo simple: ¿de qué depende el periodo?; [CRITERIOS] hipótesis, tabla de datos, gráfica, análisis y conclusión; [INFORME] «Hipótesis: el periodo depende de la masa porque lo pesado cae más rápido. Medimos con la bola de cristal y la de acero. El de acero fue más rápido (1,42 s y 1,45 s). Conclusión: el periodo depende de la masa.»; [DATOS_ESPERADOS] el periodo depende de la longitud y es prácticamente independiente de la masa para ángulos pequeños.',
                'resultado_html' => '<p><strong>Para el docente:</strong> Hipótesis: Básico (es contrastable, pero se apoya en la idea de que «lo pesado cae más rápido»). Datos: Bajo (una sola medición por masa, sin longitud ni ángulo reportados). Análisis: Bajo (concluye a partir de una diferencia de 0,03 s, menor que el error del cronómetro manual).</p>
<p><strong>Para el estudiante:</strong> «Tu hipótesis está bien formulada porque se puede poner a prueba, y elegiste dos masas muy distintas, lo que era una buena idea. Ahora, mira tus datos: 1,42 s y 1,45 s. ¿Cuánto tarda tu dedo en apretar el cronómetro? Si repites la medición cinco veces con la misma bola, ¿obtendrías siempre el mismo número? Para el próximo informe: mide 10 oscilaciones y divide entre 10, repite tres veces y compara los promedios. Luego pregúntate: si la masa no cambia el periodo, ¿qué otra variable de tu montaje sí podría cambiarlo?»</p>',
            ],
            'revisar' => [
                'Que la IA no haya inventado contenido que no estaba en el informe.',
                'Que el tono sea el suyo: ajuste expresiones que su estudiante no usaría o que suenen frías.',
                'Que no se compartan nombres ni datos personales de los estudiantes con la herramienta.',
            ],
        ],
        [
            'id' => 'NAT-09',
            'categoria' => 'evaluacion',
            'titulo' => 'Rúbrica analítica con la escala del Decreto 1290',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Cuando va a calificar un producto (modelo, informe, exposición, infografía, proyecto) y quiere criterios claros que los estudiantes conozcan desde el inicio.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PRODUCTO]' => 'Producto que se evalúa.',
                '[DBA_O_EVIDENCIA]' => 'Evidencia de aprendizaje o DBA que el producto demuestra.',
                '[ESCALA_INSTITUCIONAL]' => 'Rangos numéricos de su SIEE (ej.: Superior 4,6 a 5,0; Alto 4,0 a 4,5; Básico 3,0 a 3,9; Bajo 1,0 a 2,9).',
                '[N_CRITERIOS]' => 'Número de criterios (recomendado: 4 o 5).',
            ],
            'prompt' => 'Actúa como experto en evaluación de aprendizajes en Colombia, conocedor del Decreto 1290 de 2009 y de la construcción de rúbricas analíticas para ciencias naturales.

CONTEXTO
- Grado: [GRADO]. Producto: [PRODUCTO].
- Lo que el producto debe demostrar: [DBA_O_EVIDENCIA].
- Escala de mi Sistema Institucional de Evaluación (SIEE): [ESCALA_INSTITUCIONAL].

TAREA
Construye una rúbrica analítica de [N_CRITERIOS] criterios con los niveles Superior, Alto, Básico y Bajo.

REGLAS
1. Al menos el 60 % del peso debe estar en criterios de comprensión científica (explicar, usar evidencia, modelar), no en presentación.
2. Cada descriptor debe ser observable y diferenciarse del siguiente por la calidad del desempeño, no por adverbios vacíos («muy bien», «bien», «regular»).
3. El nivel Básico describe lo mínimo aceptable para aprobar la evidencia; el Bajo, lo que aún no la demuestra, redactado en positivo de lo que sí hace el estudiante y lo que le falta.
4. Incluye el peso porcentual de cada criterio.

FORMATO DE SALIDA
1. Tabla: Criterio (peso) | Superior | Alto | Básico | Bajo.
2. Versión para estudiantes en primera persona («Yo explico...»), para autoevaluación.
3. Instrucción de cómo convertir los niveles a la escala numérica de mi SIEE.

AUTOVERIFICACIÓN
Revisa que ningún descriptor de un nivel pueda confundirse con el del nivel vecino, que los pesos sumen 100 % y que la rúbrica evalúe la evidencia [DBA_O_EVIDENCIA] y no otra cosa.',
            'seguimientos' => [
                'Aplica la rúbrica a este trabajo de un estudiante y muestra qué evidencias justifican cada nivel: [TRABAJO].',
                'Reduce la rúbrica a una lista de cotejo de 6 ítems para usar durante la exposición.',
                'Hazla más sencilla, con caritas o íconos, para estudiantes de 2.° grado.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.°; [PRODUCTO] maqueta explicada de una red trófica del bosque seco tropical; [DBA_O_EVIDENCIA] explica el flujo de energía y materia en un ecosistema; [ESCALA_INSTITUCIONAL] Superior 4,6 a 5,0; Alto 4,0 a 4,5; Básico 3,0 a 3,9; Bajo 1,0 a 2,9; [N_CRITERIOS] 4.',
                'resultado_html' => '<table><tr><th>Criterio</th><th>Superior</th><th>Alto</th><th>Básico</th><th>Bajo</th></tr>
<tr><td>Flujo de energía (35 %)</td><td>Explica que la energía entra por los productores, se transfiere y disminuye en cada nivel, y lo relaciona con por qué hay pocos depredadores tope.</td><td>Explica la transferencia entre niveles y la pérdida de energía, sin relacionarla con el número de organismos.</td><td>Ubica correctamente productores, consumidores y descomponedores, y describe quién se alimenta de quién.</td><td>Ubica algunos organismos; confunde la dirección de las flechas o el papel de los descomponedores.</td></tr>
<tr><td>Organismos del ecosistema (20 %)</td><td>Incluye al menos 8 especies reales del bosque seco colombiano con su papel justificado.</td><td>Incluye al menos 6 especies reales con su papel.</td><td>Incluye especies reales, pero alguna de otro ecosistema.</td><td>Mezcla especies de otros ecosistemas o continentes.</td></tr></table>
<p><strong>Versión estudiante:</strong> «Yo explico por qué en mi red hay muchas plantas y pocos jaguares.»</p>',
            ],
            'revisar' => [
                'Que los rangos numéricos coincidan exactamente con su SIEE.',
                'Que los descriptores sean coherentes con lo que usted enseñó (la IA puede exigir conceptos que no se trabajaron).',
                'Socializar la rúbrica antes de que los estudiantes empiecen el producto.',
            ],
        ],
        [
            'id' => 'NAT-10',
            'categoria' => 'evaluacion',
            'titulo' => 'Diagnóstico de ideas previas con preguntas de dos niveles',
            'grados' => '3.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Antes de iniciar un tema donde sabe que los estudiantes traen ideas alternativas muy arraigadas (fotosíntesis, calor, fuerzas, estaciones, evolución).',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[TEMA]' => 'Tema que va a iniciar.',
                '[N_PREGUNTAS]' => 'Número de preguntas (recomendado: 5 a 8).',
                '[FORMA_DE_APLICACION]' => 'Papel, tarjetas de colores, formulario en línea, oral.',
            ],
            'prompt' => 'Actúa como investigador en didáctica de las ciencias experto en concepciones alternativas de los estudiantes y en instrumentos de diagnóstico de dos niveles (respuesta + razón).

CONTEXTO
- Grado: [GRADO]. Tema: [TEMA]. Aplicación: [FORMA_DE_APLICACION].

TAREA
1. Lista las concepciones alternativas más documentadas sobre [TEMA] en estudiantes de esta edad (máximo 6), con una frase típica que diría un estudiante.
2. Diseña [N_PREGUNTAS] preguntas de dos niveles: primer nivel, la respuesta (opción múltiple o verdadero o falso); segundo nivel, la razón (opciones que incluyen las concepciones alternativas y la explicación científica).
3. Usa situaciones de la vida cotidiana en Colombia.

FORMATO DE SALIDA
- Tabla de concepciones: Concepción | Frase típica | Por qué es razonable para el estudiante | Idea científica.
- Las preguntas, cada una con la clave de los dos niveles y qué concepción revela cada combinación de respuestas.
- Una matriz para tabular resultados del curso (filas: estudiantes; columnas: concepciones detectadas).
- Tres decisiones didácticas según los resultados: si predomina la concepción X, empiece por...

RESTRICCIONES
- No calificar: es un diagnóstico; la redacción para el estudiante debe decir que no tiene nota.
- Las concepciones deben ser las documentadas en la investigación, no inventadas. Si no estás seguro, dilo.
- Lenguaje adecuado a [GRADO].

AUTOVERIFICACIÓN
Comprueba que cada concepción de la tabla sea detectable con al menos una pregunta y que ninguna opción de razón sea correcta y a la vez esté marcada como concepción alternativa.',
            'seguimientos' => [
                'Con estos resultados de mi curso [PEGAR CONTEOS], ¿por cuál actividad empiezo y por qué?',
                'Diseña un experimento discrepante de 10 minutos que ponga en conflicto la concepción más frecuente.',
                'Prepara la misma prueba como salida al final de la unidad para comparar el cambio.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 5.°; [TEMA] nutrición de las plantas; [N_PREGUNTAS] 6 (se muestra una); [FORMA_DE_APLICACION] tarjetas de colores A, B, C, D levantadas por los estudiantes.',
                'resultado_html' => '<p><strong>Concepción frecuente:</strong> «Las plantas comen tierra» (la planta obtiene su alimento del suelo).</p>
<p><strong>Pregunta:</strong> Don Ernesto sembró un aguacate pequeño en una matera con 10 kg de tierra en Armenia. Cinco años después, el árbol pesa mucho más, pero la tierra de la matera pesa casi lo mismo. ¿De dónde salió la mayor parte del material del árbol?</p>
<p>Primer nivel: A. De la tierra. B. Del agua y del aire. C. Del abono. D. De la luz del sol.</p>
<p>Segundo nivel, la razón: 1. Porque las raíces absorben la tierra. 2. Porque la planta usa el dióxido de carbono del aire y el agua para fabricar su alimento con la energía de la luz. 3. Porque la luz se convierte en madera. 4. Porque el abono es la comida de las plantas.</p>
<p><strong>Clave:</strong> B y 2. La combinación A y 1 revela la concepción «las plantas comen tierra»; D y 3 confunde la energía de la luz con la materia; C y 4 confunde nutrientes minerales con alimento.</p>',
            ],
            'revisar' => [
                'Que las concepciones listadas correspondan a lo que usted observa en su aula.',
                'Que la situación sea físicamente coherente.',
                'No convertir el diagnóstico en nota; explicarlo así a los estudiantes.',
            ],
        ],
        [
            'id' => 'NAT-11',
            'categoria' => 'planeacion',
            'titulo' => 'Experiencia de exploración del medio para Transición a 3.°',
            'grados' => 'Transición a 3.°',
            'tiempo_ahorrado' => '≈ 1 h',
            'cuando' => 'Para preparar una experiencia de exploración con niños pequeños que parta del juego y la curiosidad, con registro adecuado para su edad.',
            'variables' => [
                '[GRADO]' => 'Transición, 1.°, 2.° o 3.°.',
                '[ESPACIO]' => 'Patio, huerta, parque cercano, aula, orilla de quebrada (sin acceso al agua).',
                '[PREGUNTA_INFANTIL]' => 'Una pregunta que hicieron los niños o que despierte su curiosidad.',
                '[DURACION]' => 'Duración (recomendado: 40 a 60 minutos).',
                '[N_NINOS]' => 'Número de niños y adultos acompañantes.',
            ],
            'prompt' => 'Actúa como maestra de educación inicial y primaria en Colombia, experta en la exploración del medio como actividad rectora y en ciencias para la primera infancia.

CONTEXTO
- Grado: [GRADO]. Espacio: [ESPACIO]. Duración: [DURACION]. Niños y adultos: [N_NINOS].
- Pregunta que guía la experiencia: [PREGUNTA_INFANTIL].

TAREA
Diseña una experiencia de exploración en tres momentos: (1) provocación y preguntas, (2) exploración libre y guiada con los sentidos, (3) conversación y registro.

FORMATO DE SALIDA
1. Provocación inicial (objeto, cuento corto, adivinanza o canción) con el texto exacto que dirá la docente.
2. Exploración: qué hacen los niños, qué preguntas abiertas hace la docente («¿qué notas?», «¿qué pasaría si...?») y qué observar de cada niño.
3. Registro: dibujo, conteo con palitos, tabla de caritas o fotos tomadas por la docente; incluye una plantilla descrita.
4. Normas de cuidado: de sí mismo, de los demás y de los seres vivos, en frases cortas que los niños puedan repetir.
5. Observación para la docente: 3 indicadores de lo que se espera que los niños hagan o digan (describir, comparar, preguntar, predecir).
6. Extensión a la familia: una actividad de 10 minutos para hacer en casa.

RESTRICCIONES
- Nada de fichas para colorear o transcribir; el protagonismo es la exploración.
- Seguridad: no tocar animales con la mano desnuda si pueden picar, no llevarse nada a la boca, lavado de manos al terminar, ningún animal se lleva al aula y todo ser vivo se devuelve a su lugar.
- Vocabulario científico introducido con naturalidad (observar, predecir, comparar), sin exigir definiciones.

AUTOVERIFICACIÓN
Confirma que la experiencia cabe en [DURACION], que hay al menos un adulto por cada grupo de niños en la exploración y que cada indicador es observable sin prueba escrita.',
            'seguimientos' => [
                'Escribe un cuento corto de 150 palabras que sirva como provocación para esta experiencia.',
                'Dame 10 preguntas abiertas para hacer durante la exploración, de las más sencillas a las más retadoras.',
                'Diseña una rejilla de observación para registrar lo que dice cada niño.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 1.°; [ESPACIO] patio con jardín de una escuela rural de Ventaquemada, Boyacá; [PREGUNTA_INFANTIL] ¿qué vive debajo de las piedras?; [DURACION] 50 minutos; [N_NINOS] 24 niños, la docente y dos madres voluntarias.',
                'resultado_html' => '<p><strong>Provocación:</strong> la docente llega con una piedra grande en una caja y dice: «Esta piedra me contó un secreto: debajo de ella vive alguien. ¿Quién creen que vive debajo de las piedras? ¿Por qué vivirá allí?». Se anotan las ideas en un cartel con dibujos.</p>
<p><strong>Exploración:</strong> en grupos de 8, cada uno con un adulto, levantan con cuidado piedras pequeñas del jardín. Observan con lupas sin tocar. Preguntas: «¿Está húmedo o seco debajo? ¿Cuántas patas tiene? ¿Qué hace cuando le llega la luz?». Es común encontrar cochinitas de humedad, lombrices y hormigas; la docente aclara sin corregir bruscamente que las cochinitas no son insectos, «tienen muchas más patas que una hormiga, ¡contémoslas!».</p>
<p><strong>Registro:</strong> tabla con dibujos de los animales encontrados y casillas para marcar con palitos cuántos vio cada grupo.</p>
<p><strong>Norma de cuidado:</strong> «Miro con los ojos, cuido con las manos, devuelvo la piedra a su lugar».</p>',
            ],
            'revisar' => [
                'Conocer el espacio antes: retirar vidrios, verificar que no haya hormigas de picadura dolorosa o nidos de avispas.',
                'Que el vocabulario y la duración sean realistas para la edad.',
                'Que la información sobre los animales sea correcta (la IA suele llamar «insectos» a arañas, cochinitas o ciempiés).',
            ],
        ],
        [
            'id' => 'NAT-12',
            'categoria' => 'recursos',
            'titulo' => 'Cuento científico con fauna y flora colombiana',
            'grados' => 'Transición a 5.°',
            'tiempo_ahorrado' => '≈ 45 min',
            'cuando' => 'Para introducir un concepto en primaria con una narración que enganche, sin sacrificar la exactitud científica.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[CONCEPTO]' => 'Concepto científico que el cuento debe enseñar.',
                '[ESPECIE]' => 'Especie colombiana protagonista.',
                '[LUGAR]' => 'Ecosistema o región donde ocurre.',
                '[EXTENSION]' => 'Número de palabras.',
            ],
            'prompt' => 'Actúa como autor de literatura infantil y divulgador científico colombiano. Escribes cuentos que los niños disfrutan y que los biólogos aprobarían.

CONTEXTO
- Grado: [GRADO]. Concepto que debe enseñar: [CONCEPTO].
- Protagonista: [ESPECIE], en [LUGAR]. Extensión: [EXTENSION] palabras.

TAREA
Escribe un cuento con inicio, conflicto y desenlace donde el concepto científico sea necesario para resolver el conflicto (no un dato pegado al final).

FORMATO DE SALIDA
1. Título.
2. Cuento, dividido en 5 a 7 escenas, cada una con una descripción breve de la ilustración que la acompañaría.
3. Ficha científica para la docente: datos reales de la especie (dónde vive, qué come, estado de conservación, amenazas), con [POR CONFIRMAR] en lo que dependa de la fuente.
4. Lista de licencias literarias que tomaste (por ejemplo, que el animal hable) y confirmación de que ninguna contradice la biología de la especie.
5. Cinco preguntas para conversar después de la lectura (dos literales, dos inferenciales, una sobre cuidado del ambiente).

RESTRICCIONES
- El animal puede hablar y sentir, pero su dieta, hábitat, comportamiento y ciclo de vida deben ser reales.
- Nada de mensajes que conviertan a un animal en «malo» (depredadores, serpientes, murciélagos): explica su papel en el ecosistema.
- No promuevas tener animales silvestres como mascotas.
- Lenguaje sencillo, con algunas palabras nuevas que se entiendan por el contexto.

AUTOVERIFICACIÓN
Lista cada afirmación biológica del cuento y marca si es correcta, licencia literaria declarada o requiere verificación.',
            'seguimientos' => [
                'Adapta el cuento para lectura en voz alta con efectos de sonido que hagan los niños.',
                'Crea una secuencia de 4 imágenes para que los niños ordenen el cuento.',
                'Escribe la versión del mismo cuento en la que el narrador es otra especie del ecosistema.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 2.°; [CONCEPTO] hábitat y por qué los animales silvestres no son mascotas; [ESPECIE] tití cabeciblanco; [LUGAR] bosque del norte de Colombia, en la región Caribe; [EXTENSION] 400 palabras.',
                'resultado_html' => '<p><strong>Título:</strong> «Copito quiere volver a casa».</p>
<p><strong>Escena 2:</strong> «Copito tenía un copete blanco que parecía una nube despeinada. Vivía con su familia en lo alto de los árboles, donde comían frutas, insectos y la savia dulce de algunos troncos. Una mañana, unas manos lo bajaron del árbol y lo metieron en una caja. Copito escuchó: “¡Qué lindo, para venderlo en el pueblo!”.» (Ilustración: el tití asustado en una caja de cartón, el bosque al fondo.)</p>
<p><strong>Ficha científica:</strong> el tití cabeciblanco vive solo en Colombia, en bosques del Caribe y el noroccidente del país; la UICN lo clasifica en peligro crítico (CR); sus principales amenazas son la pérdida de bosque y el tráfico ilegal como mascota.</p>
<p><strong>Licencias literarias:</strong> Copito habla y entiende a los humanos. No se alteró su dieta, su vida en grupos familiares ni su hábitat arbóreo.</p>',
            ],
            'revisar' => [
                'Verificar el estado de conservación y la distribución de la especie (Instituto Humboldt, listas rojas).',
                'Que el desenlace no muestre a niños rescatando o manipulando animales silvestres por su cuenta: lo correcto es avisar a la autoridad ambiental.',
                'Revisar que la dieta y el hábitat no se hayan «adornado».',
            ],
        ],
        [
            'id' => 'NAT-13',
            'categoria' => 'gestion',
            'titulo' => 'PRAE: diagnóstico ambiental participativo y plan de acción',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 4 h',
            'cuando' => 'Al formular o reformular el Proyecto Ambiental Escolar (Decreto 1743 de 1994) o al presentar avances al consejo directivo o a la secretaría de educación.',
            'variables' => [
                '[INSTITUCION]' => 'Tipo de institución, número de sedes y estudiantes (sin nombre si prefiere).',
                '[MUNICIPIO]' => 'Municipio, departamento y zona (urbana o rural).',
                '[PROBLEMATICAS]' => 'Problemáticas ambientales que ya identificaron.',
                '[AUTORIDAD_AMBIENTAL]' => 'Corporación autónoma regional o autoridad ambiental urbana.',
                '[ALIADOS]' => 'Aliados posibles: alcaldía, juntas de acción comunal, universidades, empresas de aseo, cabildos o consejos comunitarios.',
                '[TIEMPO]' => 'Horizonte del plan (un año, tres años).',
            ],
            'prompt' => 'Actúa como asesor en educación ambiental escolar en Colombia, conocedor del Decreto 1743 de 1994, la Ley 1549 de 2012 (Política Nacional de Educación Ambiental) y la articulación entre PRAE, comités interinstitucionales de educación ambiental (CIDEA) y proyectos ciudadanos (PROCEDA).

CONTEXTO
- Institución: [INSTITUCION] en [MUNICIPIO].
- Problemáticas identificadas: [PROBLEMATICAS].
- Autoridad ambiental: [AUTORIDAD_AMBIENTAL]. Aliados posibles: [ALIADOS].
- Horizonte: [TIEMPO].

TAREA
1. Diseña un diagnóstico ambiental participativo que puedan hacer los estudiantes: instrumentos (recorrido con lista de observación, encuesta a familias, cartografía del entorno, registro fotográfico, medición sencilla de residuos), quién los aplica y cómo se analizan.
2. Con base en [PROBLEMATICAS], propón cómo priorizar una problemática central (matriz de priorización con criterios: impacto, urgencia, posibilidad de acción escolar, relación con el currículo).
3. Formula el plan de acción del PRAE.

FORMATO DE SALIDA
- Instrumentos de diagnóstico listos para usar (preguntas y casillas).
- Matriz de priorización con ejemplo de puntaje.
- Plan de acción en tabla: Objetivo | Acción | Grados y áreas responsables | Aliado | Indicador verificable | Fecha.
- Integración curricular: qué tema de ciencias, sociales, matemáticas, lenguaje y ética se conecta con cada acción.
- Propuesta de comité ambiental escolar con roles de estudiantes, docentes y familias.
- Resumen de una página para presentar al consejo directivo.

RESTRICCIONES
- Indicadores medibles (kilos de residuos aprovechables, número de árboles nativos sembrados y vivos al año, litros de agua ahorrados), no «concientizar a la comunidad».
- Especies para siembra solo nativas de la región; si propones especies, indica que deben validarse con la autoridad ambiental.
- No prometas recursos o convenios que no existen; formúlalos como gestiones por hacer.
- Si dudas del nombre de una entidad, márcalo con [POR CONFIRMAR].

AUTOVERIFICACIÓN
Confirma que cada acción tiene responsable, indicador y fecha; que el diagnóstico realmente produce los datos para priorizar; y que el plan involucra a todos los niveles de la institución.',
            'seguimientos' => [
                'Redacta la carta a [AUTORIDAD_AMBIENTAL] solicitando acompañamiento técnico para el PRAE.',
                'Diseña la campaña de separación en la fuente con el código nacional de colores para canecas (Resolución 2184 de 2019: blanco para residuos aprovechables, negro para no aprovechables y verde para orgánicos aprovechables).',
                'Crea un formato de seguimiento trimestral del PRAE con evidencias fotográficas y datos.',
            ],
            'ejemplo' => [
                'contexto' => '[INSTITUCION] institución oficial urbana, 2 sedes, 1.400 estudiantes; [MUNICIPIO] Montería, Córdoba; [PROBLEMATICAS] quema de basuras en el barrio, residuos en el caño cercano, calor extremo en las aulas; [AUTORIDAD_AMBIENTAL] Corporación Autónoma Regional de los Valles del Sinú y del San Jorge (CVS); [ALIADOS] junta de acción comunal, empresa de aseo, universidad local; [TIEMPO] un año.',
                'resultado_html' => '<p><strong>Problemática priorizada:</strong> manejo inadecuado de residuos sólidos (quema y vertimiento al caño), por su impacto en salud, su relación con las inundaciones del barrio y la posibilidad real de acción escolar.</p>
<table><tr><th>Objetivo</th><th>Acción</th><th>Responsables</th><th>Indicador</th></tr>
<tr><td>Reducir los residuos que salen del colegio sin separar</td><td>Puntos ecológicos en cada piso y brigadas de 9.° que pesan semanalmente lo aprovechable</td><td>9.° (ciencias y matemáticas)</td><td>Kilos de aprovechables entregados al reciclador de oficio por mes</td></tr>
<tr><td>Disminuir el calor en el patio</td><td>Siembra de árboles nativos de sombra con mantenimiento por cursos</td><td>6.° y 7.° con la huerta escolar</td><td>Árboles vivos a los 12 meses</td></tr></table>
<p><strong>Integración curricular:</strong> en ciencias, descomposición y tiempos de degradación; en matemáticas, estadística de los pesajes; en sociales, derechos colectivos y deberes ambientales en la Constitución de 1991; en lenguaje, campaña radial escolar.</p>',
            ],
            'revisar' => [
                'Que las especies de siembra sean nativas y adecuadas para el lugar, validadas con la autoridad ambiental.',
                'Que los nombres de entidades y programas sean los correctos y vigentes en su municipio.',
                'Que el PRAE dialogue con el PEI y el plan de estudios, no que sea un proyecto aislado de un solo docente.',
            ],
        ],
        [
            'id' => 'NAT-14',
            'categoria' => 'recursos',
            'titulo' => 'Estudio de caso socio-científico con debate informado',
            'grados' => '8.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Para trabajar el componente ciencia, tecnología y sociedad con una controversia real colombiana donde la ciencia informa, pero no decide sola.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[CASO]' => 'Controversia real (ej.: hipopótamos del Magdalena Medio, minería en páramos, fumigación de cultivos, represas).',
                '[CONCEPTOS]' => 'Conceptos científicos que quiere que se usen.',
                '[SESIONES]' => 'Número de sesiones.',
                '[FUENTES]' => 'Fuentes que usted ya tiene (artículos, informes, noticias), si las tiene.',
            ],
            'prompt' => 'Actúa como docente de ciencias experto en cuestiones socio-científicas y en argumentación en el aula.

CONTEXTO
- Grado: [GRADO]. Caso: [CASO]. Sesiones: [SESIONES].
- Conceptos científicos que deben usarse: [CONCEPTOS].
- Fuentes disponibles: [FUENTES].

TAREA
Diseña un estudio de caso que lleve a los estudiantes de la información científica a una decisión argumentada.

FORMATO DE SALIDA
1. Presentación del caso para estudiantes (máximo 300 palabras), neutral, con los hechos verificables y sin tomar partido.
2. Ficha científica: los conceptos de [CONCEPTOS] explicados en relación directa con el caso.
3. Mapa de actores: tabla con Actor | Interés principal | Argumento más fuerte | Evidencia que usaría | Qué valora.
4. Dossier de evidencias: 6 a 8 «tarjetas de evidencia» breves (datos, observaciones, posturas de expertos) que incluyan evidencias que favorezcan distintas posiciones; marca con [POR CONFIRMAR] toda cifra.
5. Dinámica de debate: roles, tiempos, reglas de turno y una regla de oro (todo argumento debe citar al menos una tarjeta de evidencia).
6. Producto final: una recomendación escrita con la estructura afirmación, evidencia, razonamiento, contraargumento y respuesta.
7. Preguntas de cierre que distingan entre lo que la ciencia puede responder y lo que es una decisión ética, económica o política.

RESTRICCIONES
- No presentes como hecho científico lo que es una opinión o una decisión de política.
- No ridiculices a ningún actor (campesinos, empresas, comunidades, animalistas, científicos).
- Si el caso tiene decisiones judiciales o normas, menciónalas solo si estás seguro y márcalas para verificar.

AUTOVERIFICACIÓN
Revisa que el dossier tenga equilibrio de posiciones, que cada concepto científico de la lista aparezca en el caso y que las cifras estén marcadas para verificar.',
            'seguimientos' => [
                'Elabora la rúbrica de la recomendación escrita usando la escala Superior, Alto, Básico y Bajo.',
                'Redacta tres preguntas tipo Saber 11 del componente CTS a partir del caso.',
                'Prepara una versión del caso para 6.° y 7.° con menos actores y conceptos más básicos.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [CASO] hipopótamos en el Magdalena Medio, descendientes de los animales llevados a la Hacienda Nápoles en los años ochenta; [CONCEPTOS] especie invasora, nicho ecológico, crecimiento poblacional, capacidad de carga, eutrofización; [SESIONES] 4.',
                'resultado_html' => '<p><strong>Mapa de actores (extracto):</strong></p>
<table><tr><th>Actor</th><th>Interés</th><th>Argumento más fuerte</th></tr>
<tr><td>Pescadores de la ciénaga</td><td>Seguridad y pesca</td><td>Los animales pueden atacar a personas y alterar los lugares de pesca.</td></tr>
<tr><td>Investigadores en ecología</td><td>Conservar el ecosistema nativo</td><td>Sin depredadores naturales, la población sigue creciendo y desplaza especies nativas como el manatí antillano.</td></tr>
<tr><td>Organizaciones animalistas</td><td>Bienestar animal</td><td>Los animales no son culpables de su introducción; existen alternativas como la esterilización y el traslado.</td></tr>
<tr><td>Comerciantes de turismo de la zona</td><td>Ingresos</td><td>Los hipopótamos atraen visitantes a la región.</td></tr></table>
<p><strong>Tarjeta de evidencia 3:</strong> «Un estudio publicado en 2020 en la revista <em>Ecology</em> comparó lagos del Magdalena Medio antioqueño con y sin hipopótamos: en los lagos con hipopótamos había más cianobacterias y variaciones diarias más grandes del oxígeno disuelto, probablemente por los nutrientes que aportan sus heces.»</p>
<p><strong>Pregunta de cierre:</strong> la ciencia puede estimar cuántos hipopótamos habrá en 20 años; ¿puede la ciencia decidir qué hacer con ellos? ¿Quién debe decidirlo?</p>',
            ],
            'revisar' => [
                'Cifras de población y normas vigentes del caso: cambian rápido y la IA las desactualiza.',
                'Que el caso no se convierta en un juicio moral a las personas del territorio.',
                'Equilibrio real del dossier antes de imprimirlo.',
            ],
        ],
        [
            'id' => 'NAT-15',
            'categoria' => 'evaluacion',
            'titulo' => 'Taller de interpretación de tablas y gráficas con datos colombianos',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 15 min',
            'cuando' => 'Para fortalecer la competencia de indagación, que en Saber suele ser la más baja: leer datos, identificar tendencias y sacar conclusiones válidas.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[FENOMENO]' => 'Fenómeno con datos (temperatura y altitud, lluvias por mes, crecimiento de una planta, caudal de un río).',
                '[DATOS]' => 'Datos reales que usted tenga (pegue la tabla) o pida datos aproximados marcados como tales.',
                '[N_PREGUNTAS]' => 'Número de preguntas.',
            ],
            'prompt' => 'Actúa como docente de ciencias especialista en la competencia de indagación y en alfabetización de datos.

CONTEXTO
- Grado: [GRADO]. Fenómeno: [FENOMENO].
- Datos: [DATOS]
(Si no te entrego datos, usa valores aproximados realistas para Colombia y escribe «datos aproximados con fines didácticos».)

TAREA
Crea un taller de interpretación de datos con progresión de dificultad:
1. Lectura literal (¿cuál es el valor de...?).
2. Comparación y tendencia (¿qué pasa con Y cuando X aumenta?).
3. Interpolación o extrapolación (predicción razonable).
4. Validez de conclusiones (¿cuál de estas conclusiones se apoya en los datos y cuál no?).
5. Diseño: ¿qué dato o experimento adicional se necesitaría para responder una nueva pregunta?
6. Explicación del patrón con un concepto científico.

FORMATO DE SALIDA
- Tabla de datos con unidades y fuente o advertencia de aproximación.
- Instrucciones para que los estudiantes construyan la gráfica adecuada (tipo de gráfica, ejes, escala).
- [N_PREGUNTAS] preguntas en orden de dificultad, mezclando abiertas y de selección múltiple.
- Solucionario con los errores típicos en cada pregunta (por ejemplo, confundir correlación con causalidad, leer mal la escala, extrapolar sin límite).

RESTRICCIONES
- Los datos deben ser físicamente plausibles y coherentes entre sí.
- Al menos una pregunta debe tener una conclusión tentadora pero NO respaldada por los datos.

AUTOVERIFICACIÓN
Resuelve todas las preguntas con la tabla y confirma que las respuestas salen de los datos; revisa que la escala sugerida para la gráfica funcione con los valores.',
            'seguimientos' => [
                'Convierte las preguntas 4 y 5 en ítems tipo Saber con cuatro opciones y justificación de distractores.',
                'Dame una versión del taller para trabajar en hoja de cálculo con los estudiantes.',
                'Propón cómo los estudiantes pueden recoger sus propios datos del mismo fenómeno en el colegio.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.°; [FENOMENO] relación entre altitud y temperatura media en ciudades colombianas; [DATOS] no entregados, se usan datos aproximados; [N_PREGUNTAS] 6.',
                'resultado_html' => '<p><strong>Datos aproximados con fines didácticos:</strong></p>
<table><tr><th>Ciudad</th><th>Altitud aproximada (m)</th><th>Temperatura media aproximada (°C)</th></tr>
<tr><td>Cartagena</td><td>2</td><td>28</td></tr>
<tr><td>Cali</td><td>1.000</td><td>24</td></tr>
<tr><td>Medellín</td><td>1.500</td><td>22</td></tr>
<tr><td>Bogotá</td><td>2.600</td><td>14</td></tr>
<tr><td>Tunja</td><td>2.800</td><td>13</td></tr></table>
<p><strong>Pregunta 3 (predicción):</strong> Manizales está a unos 2.150 m. Usando la tendencia, ¿entre qué valores esperarías su temperatura media? Justifica con la gráfica.</p>
<p><strong>Pregunta 4 (validez):</strong> Un estudiante concluye: «En Bogotá hace frío porque está más lejos del Sol». ¿Se apoya en los datos? Explica qué muestran realmente los datos y qué concepto explica el patrón.</p>
<p><strong>Error típico:</strong> unir los puntos con una línea quebrada y concluir que «entre Medellín y Bogotá la temperatura baja más rápido», sin considerar que son pocos datos y que cada ciudad tiene otros factores.</p>',
            ],
            'revisar' => [
                'Comparar los datos con fuentes oficiales (IDEAM) si se presentan como reales.',
                'Que la gráfica sea construible en papel milimetrado o cuadriculado con la escala propuesta.',
                'Que el solucionario no contradiga la tabla.',
            ],
        ],
        [
            'id' => 'NAT-16',
            'categoria' => 'recursos',
            'titulo' => 'Problemas de física contextualizados y graduados',
            'grados' => '9.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Cuando quiere ejercicios de física que no sean «un auto en una carretera de Estados Unidos», con razonamiento conceptual además del cálculo.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[TEMA]' => 'Tema de física (energía, cinemática, dinámica, ondas, electricidad).',
                '[CONTEXTO_COLOMBIANO]' => 'Situación real (ciclismo en un alto, metrocable, hidroeléctrica, bus en una vía de montaña).',
                '[N_PROBLEMAS]' => 'Número de problemas.',
                '[NIVEL_MATEMATICO]' => 'Herramientas matemáticas que dominan (despejes, trigonometría, gráficas).',
            ],
            'prompt' => 'Actúa como profesor de física de educación media en Colombia, experto en resolución de problemas y en las competencias evaluadas en Saber 11.

CONTEXTO
- Grado: [GRADO]. Tema: [TEMA]. Contexto: [CONTEXTO_COLOMBIANO].
- Herramientas matemáticas del grupo: [NIVEL_MATEMATICO].

TAREA
Crea [N_PROBLEMAS] problemas graduados sobre [TEMA], todos en el mismo contexto:
- Los primeros, de aplicación directa.
- Los intermedios, de varios pasos.
- Al menos uno conceptual sin números (predecir y justificar).
- Al menos uno que pida evaluar una afirmación errónea.
- Uno de estimación (orden de magnitud) con datos que el estudiante debe suponer razonablemente.

FORMATO DE SALIDA
Para cada problema: enunciado, datos con unidades del SI, solución paso a paso (planteamiento, ecuación, cálculo, verificación de unidades, interpretación física del resultado) y el error más común de los estudiantes.

RESTRICCIONES
- Datos realistas (masas, velocidades, alturas) para el contexto colombiano; marca con [POR CONFIRMAR] cualquier dato geográfico.
- Usa g = 9,8 m/s² salvo que se indique otra cosa, y coma decimal.
- Declara siempre las simplificaciones (sin rozamiento, masa puntual, etc.).

AUTOVERIFICACIÓN
Recalcula cada resultado numérico de forma independiente y verifica unidades y orden de magnitud. Si un resultado no es físicamente razonable, corrige los datos. Reporta los recálculos al final.',
            'seguimientos' => [
                'Convierte el problema 3 en una práctica que se pueda hacer en el colegio con medición real.',
                'Escribe una versión de los problemas con apoyos (fórmulas dadas y pasos guiados) para estudiantes en nivel Bajo.',
                'Crea una pregunta tipo Saber 11 del componente físico con el mismo contexto.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [TEMA] energía mecánica y trabajo; [CONTEXTO_COLOMBIANO] un ciclista sube el Alto de Letras desde Mariquita, Tolima; [N_PROBLEMAS] 5 (se muestran dos); [NIVEL_MATEMATICO] despejes y notación científica.',
                'resultado_html' => '<p><strong>Problema 2 (varios pasos):</strong> Un ciclista de 65 kg con una bicicleta de 9 kg sube desde Mariquita (unos 495 m de altitud) hasta el Alto de Letras (unos 3.680 m). ¿Cuánto aumenta su energía potencial gravitacional?</p>
<p><strong>Solución:</strong> m = 74 kg; Δh ≈ 3.185 m. ΔEp = m·g·Δh = 74 × 9,8 × 3.185 ≈ 2,31 × 10⁶ J, es decir, unos 2,3 MJ. Interpretación: es la energía mínima; el ciclista gasta mucho más porque su cuerpo no convierte toda la energía de los alimentos en trabajo mecánico y hay rozamiento con el aire y la vía.</p>
<p><strong>Problema 4 (afirmación errónea):</strong> Un narrador de televisión dice: «Al llegar a la cima, el ciclista ya gastó toda su energía y por eso baja sin esfuerzo». ¿Qué está bien y qué está mal en esta afirmación desde la física?</p>
<p><strong>Error común:</strong> usar la altitud final (3.680 m) en lugar de la diferencia de altura.</p>',
            ],
            'revisar' => [
                'Recalcular usted al menos dos resultados: la IA comete errores aritméticos con frecuencia.',
                'Altitudes y distancias de lugares reales.',
                'Que las simplificaciones estén declaradas para que el estudiante no aprenda una física «sin rozamiento» como si fuera la realidad.',
            ],
        ],
        [
            'id' => 'NAT-17',
            'categoria' => 'recursos',
            'titulo' => 'Química en contexto: procesos productivos colombianos',
            'grados' => '9.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Para enseñar reacciones, estequiometría, soluciones o química orgánica a partir de procesos que los estudiantes conocen: panela, café, cacao, sal, cal, minería.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PROCESO]' => 'Proceso productivo o fenómeno cotidiano colombiano.',
                '[CONCEPTOS]' => 'Conceptos químicos a trabajar.',
                '[ACTIVIDAD]' => 'Tipo de actividad: guía de lectura, problemas, práctica demostrativa, salida a un trapiche o finca.',
            ],
            'prompt' => 'Actúa como profesor de química de educación media en Colombia, experto en enseñanza de la química en contexto y en procesos agroindustriales del país.

CONTEXTO
- Grado: [GRADO]. Proceso: [PROCESO].
- Conceptos químicos: [CONCEPTOS]. Tipo de actividad: [ACTIVIDAD].

TAREA
1. Describe el proceso en etapas, señalando en cada una qué cambio físico o químico ocurre y por qué.
2. Escribe las ecuaciones químicas pertinentes, balanceadas, con estados de agregación.
3. Diseña la actividad indicada con al menos tres problemas o preguntas que usen [CONCEPTOS] con datos plausibles del proceso.
4. Incluye una pregunta de impacto social o ambiental del proceso (CTS).

FORMATO DE SALIDA
- Diagrama de flujo del proceso descrito en texto (etapa → etapa).
- Ecuaciones con nombres de las sustancias.
- Problemas con solución detallada (masas molares usadas, factor de conversión, resultado con unidades y cifras razonables).
- Preguntas de análisis y la pregunta CTS.

RESTRICCIONES
- Ecuaciones correctamente balanceadas; verifica átomo por átomo.
- Si propones una práctica, solo con materiales seguros; nada de producir ni consumir bebidas alcohólicas en el colegio, nada de reactivos peligrosos.
- No confundas procesos tradicionales con creencias: describe con precisión lo que se sabe de la química del proceso y marca con [POR CONFIRMAR] lo que no sea seguro.

AUTOVERIFICACIÓN
Cuenta átomos de cada elemento a ambos lados de cada ecuación y muéstralo en una tabla corta; recalcula cada problema; revisa que las masas molares estén correctas.',
            'seguimientos' => [
                'Diseña una guía para una visita a un trapiche (o finca cafetera) con preguntas de observación química.',
                'Crea un problema de reactivo límite con el mismo proceso.',
                'Explica para 6.° el mismo proceso, solo como cambios físicos y químicos, sin ecuaciones.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.°; [PROCESO] de la caña a la panela y al guarapo fermentado; [CONCEPTOS] cambios físicos y químicos, hidrólisis, fermentación, estequiometría; [ACTIVIDAD] guía de problemas y demostración con levadura y globo.',
                'resultado_html' => '<p><strong>Flujo:</strong> molienda de la caña (cambio físico: extracción del jugo) → limpieza del jugo, tradicionalmente con mucílagos vegetales como los del balso, el cadillo o el guásimo (varían según la región), que ayudan a separar impurezas → evaporación del agua (cambio físico) → concentración y moldeo de la panela.</p>
<p><strong>Ecuaciones:</strong></p>
<ul><li>Hidrólisis de la sacarosa: C₁₂H₂₂O₁₁ (ac) + H₂O (l) → C₆H₁₂O₆ (ac) [glucosa] + C₆H₁₂O₆ (ac) [fructosa]</li>
<li>Fermentación alcohólica: C₆H₁₂O₆ (ac) → 2 C₂H₅OH (ac) + 2 CO₂ (g)</li></ul>
<p><strong>Problema:</strong> si la levadura fermenta completamente 180 g de glucosa, ¿qué masa de dióxido de carbono se produce? Masa molar de glucosa: 180 g/mol; de CO₂: 44 g/mol. 1 mol de glucosa produce 2 mol de CO₂ → 2 × 44 = 88 g de CO₂.</p>
<p><strong>Demostración segura:</strong> agua tibia, panela rallada y levadura en una botella con un globo en la boca; el globo se infla con CO₂. La mezcla se desecha al final; no se consume.</p>',
            ],
            'revisar' => [
                'Balanceo de cada ecuación y masas molares.',
                'Datos de producción o rendimientos: la IA los inventa con facilidad.',
                'Que la práctica no implique producir bebidas alcohólicas ni calentar con fuego.',
            ],
        ],
        [
            'id' => 'NAT-18',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Retroalimentación a explicaciones científicas escritas (afirmación, evidencia, razonamiento)',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min por curso',
            'cuando' => 'Cuando sus estudiantes responden preguntas abiertas de «explica por qué» y quiere ayudarles a pasar de respuestas vagas a explicaciones con evidencia y razonamiento.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PREGUNTA]' => 'La pregunta que respondieron.',
                '[RESPUESTA_ESPERADA]' => 'Los elementos de una buena respuesta.',
                '[RESPUESTAS]' => 'Respuestas anonimizadas de 5 a 10 estudiantes, numeradas.',
            ],
            'prompt' => 'Actúa como docente de ciencias experto en argumentación científica con el modelo afirmación, evidencia y razonamiento (AER).

CONTEXTO
- Grado: [GRADO].
- Pregunta: [PREGUNTA]
- Elementos de una buena respuesta: [RESPUESTA_ESPERADA]
- Respuestas de los estudiantes (anonimizadas):
[RESPUESTAS]

TAREA
1. Analiza cada respuesta en tres componentes: afirmación (¿responde la pregunta?), evidencia (¿usa datos u observaciones?), razonamiento (¿conecta la evidencia con un concepto científico?).
2. Identifica errores conceptuales.
3. Escribe retroalimentación individual breve.
4. Encuentra los patrones del grupo.

FORMATO DE SALIDA
- Tabla: Estudiante | Afirmación (sí/parcial/no) | Evidencia (sí/parcial/no) | Razonamiento (sí/parcial/no) | Error conceptual | Nivel (Superior, Alto, Básico, Bajo).
- Retroalimentación para cada estudiante: máximo 3 líneas, con una pregunta que le ayude a mejorar el componente más débil.
- Patrones del grupo: los 2 o 3 problemas más frecuentes.
- Una respuesta modelo comentada, para proyectar en clase, construida a partir de fragmentos de las respuestas de los estudiantes (no inventada desde cero).

RESTRICCIONES
- No corrijas la ortografía salvo que impida entender la idea; el foco es el razonamiento científico.
- No reveles la respuesta completa en la retroalimentación individual.

AUTOVERIFICACIÓN
Confirma que la clasificación de cada estudiante se apoya en lo que escribió y que la respuesta modelo usa fragmentos reales.',
            'seguimientos' => [
                'Diseña una actividad de 20 minutos de reescritura: los estudiantes mejoran su respuesta usando la retroalimentación.',
                'Crea un organizador gráfico AER para pegar en el cuaderno.',
                'Haz una versión de la retroalimentación para leer en voz alta al grupo sin señalar a nadie.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.°; [PREGUNTA] En la tienda, la señora Rosa echa sal sobre unas hojas de lechuga y a los 20 minutos están marchitas y hay agua en el plato. Explica por qué; [RESPUESTA_ESPERADA] el agua sale de las células por ósmosis hacia el medio con más concentración de sal; evidencia: agua en el plato y hojas marchitas; [RESPUESTAS] 8 respuestas.',
                'resultado_html' => '<table><tr><th>Est.</th><th>Afirmación</th><th>Evidencia</th><th>Razonamiento</th><th>Error</th><th>Nivel</th></tr>
<tr><td>3</td><td>Sí</td><td>Parcial</td><td>No</td><td>«La sal quema la lechuga»</td><td>Bajo</td></tr>
<tr><td>5</td><td>Sí</td><td>Sí</td><td>Parcial</td><td>Dice que la sal entra a la célula y «empuja» el agua</td><td>Básico</td></tr></table>
<p><strong>Retroalimentación al estudiante 3:</strong> «Notaste bien que la lechuga cambia con la sal. Pero mira el plato: ¿de dónde salió esa agua si nadie la echó? ¿Qué tendría que pasar dentro de las hojas para que aparezca agua afuera?»</p>
<p><strong>Patrón del grupo:</strong> 5 de 8 describen lo que pasa, pero no lo explican con lo que ocurre en las células; 3 creen que la sal «quema».</p>',
            ],
            'revisar' => [
                'Anonimizar las respuestas antes de pegarlas.',
                'Que la clasificación coincida con su criterio profesional; ajuste los casos dudosos.',
                'Que la respuesta modelo no contenga errores.',
            ],
        ],
        [
            'id' => 'NAT-19',
            'categoria' => 'adaptacion',
            'titulo' => 'Clase multigrado para escuela rural (estilo Escuela Nueva)',
            'grados' => 'Transición a 5.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Cuando enseña a varios grados en la misma aula y quiere un tema común con actividades escalonadas para cada grado.',
            'variables' => [
                '[GRADOS_PRESENTES]' => 'Grados y número de niños por grado.',
                '[TEMA_COMUN]' => 'Tema que puede trabajarse con todos (agua, suelo, plantas, animales de la finca, el clima).',
                '[VEREDA_REGION]' => 'Vereda, municipio y región.',
                '[DBA_POR_GRADO]' => 'Texto de los DBA de cada grado relacionados con el tema (copiados).',
                '[DURACION]' => 'Duración de la jornada o el bloque.',
            ],
            'prompt' => 'Actúa como docente rural colombiano experto en aulas multigrado y en el modelo Escuela Nueva (trabajo en grupos, guías de aprendizaje, monitores, rincones de trabajo, vínculo con la comunidad).

CONTEXTO
- Grados presentes: [GRADOS_PRESENTES]. Vereda: [VEREDA_REGION].
- Tema común: [TEMA_COMUN]. Duración: [DURACION].
- DBA de cada grado relacionados (textos oficiales): [DBA_POR_GRADO]

TAREA
Diseña una clase con un momento inicial común, trabajo diferenciado por grupos de grados y un cierre común.

FORMATO DE SALIDA
1. Inicio común (15 minutos): pregunta o experiencia que involucre a todos.
2. Trabajo por grupos: para cada grado o subgrupo, una actividad básica, una de práctica y una de aplicación en la finca o la casa, con el nivel de complejidad que corresponde a su DBA.
3. Rol de los monitores (estudiantes mayores que apoyan a los menores) con instrucciones precisas.
4. Plan de rotación de la docente: a qué grupo acompaña en cada momento y qué hacen los demás mientras tanto.
5. Cierre común: cada grupo aporta algo distinto a una producción colectiva (mural, maqueta, cartelera).
6. Evidencias por grado y cómo registrarlas en un formato simple.
7. Tarea para la familia que use saberes campesinos y la finca.

RESTRICCIONES
- Las actividades de los grupos deben ser autónomas (con instrucciones claras) porque la docente no puede estar en todos al tiempo.
- Materiales del entorno rural; nada que exija internet.
- Respeta y valora el saber campesino; cuando difiera del conocimiento científico, propone contrastarlo con observación, no descalificarlo.

AUTOVERIFICACIÓN
Revisa que cada grado tenga una tarea correspondiente a su DBA, que los tiempos de rotación cuadren y que ningún grupo quede sin actividad mientras la docente atiende a otro.',
            'seguimientos' => [
                'Convierte la actividad de 4.° y 5.° en una guía de aprendizaje de dos páginas para trabajo autónomo.',
                'Diseña la tarjeta de instrucciones para los monitores, con lenguaje para niños de 10 años.',
                'Propón cómo involucrar a un padre o abuelo agricultor como invitado.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADOS_PRESENTES] Transición (3), 1.° (4), 2.° (3), 3.° (5), 4.° (4), 5.° (3); [TEMA_COMUN] el suelo de la huerta; [VEREDA_REGION] vereda del municipio de Inzá, Cauca; [DURACION] 3 horas.',
                'resultado_html' => '<p><strong>Inicio común:</strong> cada niño trae un puñado de tierra de su casa en una bolsa. Todos comparan colores, olores y texturas en el suelo del salón sobre papel periódico. Pregunta: «¿Por qué no todas las tierras son iguales?».</p>
<table><tr><th>Grupo</th><th>Actividad</th><th>Evidencia</th></tr>
<tr><td>Transición y 1.°</td><td>Clasificar muestras por color y textura; buscar seres vivos con lupa y contarlos.</td><td>Dibujo de lo encontrado y conteo</td></tr>
<tr><td>2.° y 3.°</td><td>Frasco de sedimentación: agua y tierra, agitar y observar capas al día siguiente.</td><td>Dibujo rotulado de las capas</td></tr>
<tr><td>4.° y 5.°</td><td>Prueba de infiltración: misma cantidad de agua en tierra de huerta y tierra de camino; medir tiempo; relacionar con erosión en la ladera.</td><td>Tabla de datos y explicación</td></tr></table>
<p><strong>Monitores:</strong> dos niños de 5.° acompañan a Transición y 1.° en el conteo, con la regla «yo pregunto, tú descubres».</p>
<p><strong>Tarea familiar:</strong> preguntar a un mayor cómo sabe que una tierra es buena para sembrar maíz o fríjol, y traer la respuesta para compararla con nuestras pruebas.</p>',
            ],
            'revisar' => [
                'Que los DBA usados sean los reales de cada grado.',
                'Que los tiempos sean sostenibles con niños pequeños.',
                'Que las tareas familiares no supongan acceso a recursos que las familias no tienen.',
            ],
        ],
        [
            'id' => 'NAT-20',
            'categoria' => 'gestion',
            'titulo' => 'Informe descriptivo de desempeño para padres de familia',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 2 h por periodo',
            'cuando' => 'Al redactar los informes de periodo o preparar la reunión de entrega de boletines, cuando necesita textos claros, personalizados y sin jerga.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[DESEMPENO]' => 'Nivel del estudiante (Superior, Alto, Básico, Bajo) y nota si aplica.',
                '[FORTALEZAS]' => 'Lo que el estudiante hace bien (observaciones concretas).',
                '[DIFICULTADES]' => 'Lo que se le dificulta (observaciones concretas).',
                '[TEMAS_DEL_PERIODO]' => 'Temas o evidencias del periodo.',
                '[RECURSOS_FAMILIA]' => 'Lo que la familia puede hacer realistamente (tiempo, escolaridad, acceso a internet).',
            ],
            'prompt' => 'Actúa como docente colombiano con amplia experiencia comunicándose con familias de distintos contextos, incluidas familias con poca escolaridad.

CONTEXTO
- Grado: [GRADO]. Desempeño del periodo: [DESEMPENO].
- Temas del periodo: [TEMAS_DEL_PERIODO].
- Fortalezas observadas: [FORTALEZAS].
- Dificultades observadas: [DIFICULTADES].
- Posibilidades de la familia: [RECURSOS_FAMILIA].

TAREA
Redacta un informe descriptivo del área de Ciencias Naturales para la familia.

FORMATO DE SALIDA
1. Informe de máximo 120 palabras: empieza por una fortaleza concreta, describe el desempeño con ejemplos de lo que el estudiante hace (no con jerga pedagógica), explica la dificultad principal y cierra con un compromiso conjunto.
2. Tres actividades para la casa de 10 a 15 minutos, que no requieran comprar nada ni que la familia sepa ciencias (por ejemplo, preguntar, observar, cocinar juntos).
3. Una frase para iniciar la conversación en la reunión de padres.

RESTRICCIONES
- Prohibidas palabras como «competencias», «desempeño procedimental», «DBA» o «indagación» sin explicación sencilla.
- No compares con otros estudiantes.
- No uses etiquetas («perezoso», «distraído»); describe conductas.
- Tono respetuoso y esperanzador, sin minimizar las dificultades.

AUTOVERIFICACIÓN
Cuenta las palabras del informe, revisa que no haya jerga y que las actividades sean posibles con [RECURSOS_FAMILIA].',
            'seguimientos' => [
                'Ahora redacta los informes de estos 10 estudiantes con el mismo formato: [LISTA ANONIMIZADA].',
                'Reescribe el informe para una familia que se comunica mejor por nota de voz: hazlo como texto para leer en 45 segundos.',
                'Escribe una versión más breve para el espacio de observaciones del boletín (máximo 300 caracteres).',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 4.°; [DESEMPENO] Básico, 3,4; [TEMAS_DEL_PERIODO] sistema digestivo y alimentación saludable; [FORTALEZAS] hace preguntas interesantes, participa en las experiencias; [DIFICULTADES] no termina los registros escritos, confunde el orden de los órganos; [RECURSOS_FAMILIA] mamá trabaja todo el día, abuela en casa, sin internet.',
                'resultado_html' => '<p><strong>Informe:</strong> «Santiago es un niño curioso: en clase preguntó por qué el estómago no se digiere a sí mismo, una pregunta que nos sirvió a todos. En este periodo aprendimos cómo el cuerpo aprovecha los alimentos. Santiago comprende que la comida se transforma, pero todavía confunde el orden en que pasa por los órganos y no termina sus registros escritos. Su desempeño es Básico. Nos comprometemos a darle un esquema para completar en clase, y en casa pueden ayudarle con las actividades sugeridas.»</p>
<p><strong>Actividad para la casa:</strong> mientras la abuela cocina el almuerzo, Santiago le cuenta el «viaje» de un pedazo de yuca desde la boca hasta el intestino, señalando en su propio cuerpo dónde ocurre cada paso.</p>',
            ],
            'revisar' => [
                'Que el informe corresponda al estudiante real; no copiar y pegar el mismo texto con otro nombre.',
                'No incluir datos sensibles en la herramienta (diagnósticos, situaciones familiares).',
                'Que el nivel coincida con la valoración registrada en el sistema institucional.',
            ],
        ],
        [
            'id' => 'NAT-21',
            'categoria' => 'gestion',
            'titulo' => 'Plan de mejoramiento para estudiantes en desempeño Bajo',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Al finalizar un periodo o el año, cuando debe diseñar actividades de apoyo (planes de mejoramiento o de nivelación según su SIEE) que de verdad enseñen, no solo «un taller y una sustentación».',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[EVIDENCIAS_NO_ALCANZADAS]' => 'Evidencias de aprendizaje o DBA que el estudiante no ha demostrado.',
                '[DIAGNOSTICO]' => 'Qué errores concretos comete (de pruebas o trabajos).',
                '[TIEMPO]' => 'Tiempo disponible para el plan (semanas) y momentos de acompañamiento.',
                '[REGLAS_SIEE]' => 'Lo que dice su SIEE sobre actividades de apoyo y valoración máxima.',
            ],
            'prompt' => 'Actúa como docente de ciencias naturales experto en evaluación formativa y en el Decreto 1290 de 2009, que establece estrategias de apoyo para superar debilidades.

CONTEXTO
- Grado: [GRADO].
- Evidencias no alcanzadas: [EVIDENCIAS_NO_ALCANZADAS].
- Errores concretos observados: [DIAGNOSTICO].
- Tiempo: [TIEMPO]. Reglas del SIEE: [REGLAS_SIEE].

TAREA
Diseña un plan de mejoramiento en tres fases: (1) reenseñanza con un enfoque distinto al de la clase original, (2) práctica guiada con retroalimentación, (3) demostración de la evidencia.

FORMATO DE SALIDA
1. Explicación del plan para el estudiante y su familia (máximo 100 palabras).
2. Cronograma: Semana | Actividad | Qué hace el estudiante | Apoyo del docente o compañero | Producto.
3. Material de reenseñanza: explicación alternativa (analogía, experiencia, video o lectura sugerida), con ejemplos resueltos.
4. Práctica guiada: 6 a 8 ejercicios o preguntas en orden de dificultad, con pistas graduadas.
5. Evaluación final: dos formatos posibles para demostrar la evidencia (por ejemplo, escrito o explicación oral con un modelo), con criterios de Básico, Alto y Superior.
6. Registro de seguimiento para el docente.

RESTRICCIONES
- El plan debe atacar los errores del diagnóstico, no todo el periodo.
- Nada de copiar definiciones como actividad principal.
- La evaluación final mide la misma evidencia que se esperaba, con posibles ajustes de formato.

AUTOVERIFICACIÓN
Comprueba que cada error del diagnóstico tiene al menos una actividad que lo trabaja y que la evaluación final permite demostrar la evidencia no alcanzada.',
            'seguimientos' => [
                'Escribe las pistas graduadas como tarjetas que el estudiante pueda voltear una a una.',
                'Propón cómo organizar a un compañero tutor con una guía de 5 pasos.',
                'Genera una versión del plan para trabajo en casa sin conexión.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.°; [EVIDENCIAS_NO_ALCANZADAS] explica el tipo de enlace a partir de la posición en la tabla periódica; [DIAGNOSTICO] confunde grupo con periodo, cree que todos los compuestos con metal son covalentes, no usa la electronegatividad; [TIEMPO] 3 semanas, 2 encuentros de 30 minutos por semana; [REGLAS_SIEE] la valoración máxima de la actividad de apoyo es Básico.',
                'resultado_html' => '<p><strong>Semana 1, reenseñanza:</strong> la tabla periódica como «mapa de barrio»: los grupos son las calles (columnas) y los periodos los pisos (filas). El estudiante ubica 10 elementos con una tabla impresa y colorea metales, no metales y metaloides.</p>
<p><strong>Semana 2, práctica guiada:</strong> la «cuerda de la electronegatividad»: dos compañeros jalan una cuerda que representa el par de electrones; si uno jala mucho más fuerte (gran diferencia de electronegatividad), el electrón «se pasa» (iónico); si jalan parejo, se comparte (covalente). Ejercicios: NaCl, H₂O, CO₂, KBr, CH₄, MgO con pista 1: «ubica cada elemento», pista 2: «¿son metal y no metal?», pista 3: «compara electronegatividades».</p>
<p><strong>Evaluación final:</strong> explicación oral con la tabla en la mano de por qué la sal de cocina es iónica y el agua es covalente, o la versión escrita con los mismos dos compuestos.</p>',
            ],
            'revisar' => [
                'Que el plan respete lo que dice su SIEE (fechas, valoración máxima).',
                'Que la analogía tenga sus límites explicados (la cuerda simplifica el enlace).',
                'Que el tiempo exigido al estudiante sea razonable junto con los otros planes que pueda tener.',
            ],
        ],
        [
            'id' => 'NAT-22',
            'categoria' => 'recursos',
            'titulo' => 'Salida de campo y censo de biodiversidad del entorno escolar',
            'grados' => '3.° a 9.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Para salir del aula a observar seres vivos, levantar datos reales y conectar con la biodiversidad colombiana, incluso en colegios urbanos.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[LUGAR]' => 'Lugar de la salida (patio, parque, humedal, quebrada, finca vecina).',
                '[GRUPO_FOCAL]' => 'Grupo de organismos (aves, plantas, insectos, todos).',
                '[DURACION]' => 'Duración.',
                '[TECNOLOGIA]' => 'Celulares disponibles, conexión, apps permitidas.',
            ],
            'prompt' => 'Actúa como biólogo educador con experiencia en ciencia ciudadana en Colombia (conteos de aves, registros de biodiversidad) y en salidas pedagógicas seguras.

CONTEXTO
- Grado: [GRADO]. Lugar: [LUGAR]. Grupo focal: [GRUPO_FOCAL].
- Duración: [DURACION]. Tecnología: [TECNOLOGIA].

TAREA
Diseña una salida de campo con antes, durante y después.

FORMATO DE SALIDA
1. Antes: pregunta de investigación, hipótesis, preparación (cómo observar sin perturbar, cómo usar la guía de campo), lista de chequeo de seguridad y permisos.
2. Durante: protocolo de observación (transectos o puntos de conteo, tiempo por punto), hoja de campo para fotocopiar (fecha, hora, lugar, clima, organismo, número, comportamiento, foto o dibujo), roles en el equipo.
3. Después: cómo organizar los datos en tablas, calcular riqueza (número de especies distintas) y abundancia, comparar zonas y responder la pregunta.
4. Opción de ciencia ciudadana: cómo subir observaciones a una plataforma abierta cuidando la privacidad (sin fotos de estudiantes, sin ubicación de sus casas).
5. Conexión con la biodiversidad de Colombia y con la conservación.

RESTRICCIONES
- Nada de capturar, coleccionar ni retener animales; no arrancar plantas.
- Seguridad: no acercarse a cuerpos de agua profundos o crecidos, no tocar organismos desconocidos, relación adultos y estudiantes adecuada, autorizaciones firmadas.
- Las especies sugeridas como «probables» deben ser propias de la región; si dudas, dilo.

AUTOVERIFICACIÓN
Revisa que el protocolo produzca datos que respondan la pregunta de investigación y que todas las medidas de seguridad y permisos estén listadas.',
            'seguimientos' => [
                'Crea una guía visual de las 15 aves o plantas más probables en [LUGAR], con rasgos para identificarlas sin binoculares.',
                'Diseña la presentación de resultados para la comunidad educativa.',
                'Convierte los datos recolectados [PEGAR] en un taller de interpretación de gráficas.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 5.°; [LUGAR] parque del barrio y patio del colegio en Ibagué, Tolima; [GRUPO_FOCAL] aves; [DURACION] 2 horas; [TECNOLOGIA] 6 celulares del colegio, sin datos móviles.',
                'resultado_html' => '<p><strong>Pregunta:</strong> ¿Hay más tipos de aves en el parque con árboles o en el patio del colegio con cemento? ¿Por qué?</p>
<p><strong>Protocolo:</strong> 3 puntos de conteo en cada lugar; en cada punto, 10 minutos en silencio; un estudiante cuenta, otro anota, otro fotografía con el celular y otro vigila el tiempo.</p>
<p><strong>Aves frecuentes en Ibagué y otras ciudades andinas de clima templado</strong>: copetón, azulejo, mirla, tortolita, colibríes, garrapatero, bichofué.</p>
<p><strong>Después:</strong> tabla de especies por lugar, gráfica de barras de riqueza y conversación: Colombia es el país con más especies de aves registradas del mundo (la cifra actualizada está en el portal Cifras de Biodiversidad del SiB Colombia); ¿qué necesitan las aves que encontramos en el parque y no en el patio?</p>',
            ],
            'revisar' => [
                'Autorizaciones de los padres y del rector, según el reglamento de salidas pedagógicas.',
                'Las especies probables: valide con una guía regional o con un observador de aves local.',
                'Privacidad: las fotos subidas a plataformas no deben mostrar a estudiantes ni ubicaciones de sus casas.',
            ],
        ],
        [
            'id' => 'NAT-23',
            'categoria' => 'recursos',
            'titulo' => 'Auditor científico del material generado con IA',
            'grados' => 'Todos los grados',
            'tiempo_ahorrado' => '≈ 40 min',
            'cuando' => 'Siempre antes de imprimir o proyectar un material creado con IA (o tomado de internet): para detectar errores conceptuales, datos dudosos, riesgos de seguridad y ejemplos descontextualizados.',
            'variables' => [
                '[GRADO]' => 'Grado al que va dirigido.',
                '[MATERIAL]' => 'Texto completo del material.',
                '[TEMA]' => 'Tema central.',
            ],
            'prompt' => 'Actúa como revisor científico y editor pedagógico de materiales escolares de ciencias naturales en Colombia. Eres riguroso y escéptico: tu trabajo es encontrar problemas, no elogiar.

MATERIAL A REVISAR (grado [GRADO], tema [TEMA]):
"""
[MATERIAL]
"""

REVISA Y REPORTA EN ESTE ORDEN
1. Errores científicos: afirmaciones falsas, imprecisas o desactualizadas. Para cada una: cita textual, por qué es un problema, versión corregida.
2. Preconcepciones reforzadas: frases que, aunque «se entiendan», enseñan una idea errónea (por ejemplo, «las plantas respiran de noche y hacen fotosíntesis de día», «el frío entra por la ventana», «los átomos son bolitas»).
3. Datos y cifras: lista todas las cifras y fechas; indica cuáles son verificables, cuáles son dudosas y dónde se podrían verificar (IDEAM, Instituto Humboldt, Servicio Geológico Colombiano, INS, DANE, Parques Nacionales).
4. Seguridad: cualquier procedimiento o sugerencia riesgosa.
5. Contexto: ejemplos, especies, unidades o referencias ajenas a Colombia (estaciones del año, fauna de otros continentes, unidades inglesas) y su reemplazo colombiano.
6. Adecuación al grado: vocabulario o conceptos fuera de nivel.
7. Sesgos y estereotipos: de género, étnicos, regionales (por ejemplo, solo hombres como científicos).

FORMATO
Tabla por categoría: Cita | Problema | Gravedad (alta, media, baja) | Corrección. Al final, un veredicto: usar tal cual, usar con correcciones o no usar.

REGLA
Si no estás seguro de si algo es un error, no lo afirmes: márcalo como «dudoso, verificar en...». No inventes fuentes ni referencias.',
            'seguimientos' => [
                'Aplica todas las correcciones de gravedad alta y media y devuélveme el material corregido, marcando los cambios en negrita.',
                'Explícame en lenguaje sencillo el error científico más grave, para comentarlo con mis estudiantes como ejemplo de pensamiento crítico.',
                'Convierte los errores encontrados en una actividad de «detectives de errores» para que los estudiantes los encuentren.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [TEMA] presión atmosférica; [MATERIAL] guía generada por IA que dice «el agua siempre hierve a 100 °C», «Colombia es el país más biodiverso del mundo» y propone «calentar una lata con un mechero y sumergirla en agua helada» como experimento para estudiantes.',
                'resultado_html' => '<table><tr><th>Cita</th><th>Problema</th><th>Gravedad</th><th>Corrección</th></tr>
<tr><td>«El agua siempre hierve a 100 °C»</td><td>Solo a nivel del mar (presión cercana a 1 atm). Contradice el propio tema de la guía.</td><td>Alta</td><td>«A nivel del mar, el agua hierve a cerca de 100 °C; en ciudades altas como Bogotá, a cerca de 92 °C, porque la presión atmosférica es menor.»</td></tr>
<tr><td>«Colombia es el país más biodiverso del mundo»</td><td>Imprecisa. Según la métrica, Colombia aparece entre los primeros países en biodiversidad (con frecuencia se le presenta como el segundo) y ocupa el primer lugar en aves y orquídeas.</td><td>Media</td><td>«Colombia es uno de los países más biodiversos del planeta; ocupa el primer lugar en especies de aves.»</td></tr>
<tr><td>«Calentar una lata con mechero y sumergirla»</td><td>Riesgo de quemaduras y vapor; fuego manipulado por estudiantes.</td><td>Alta</td><td>Demostración realizada solo por el docente con pinzas y gafas, o alternativa sin fuego: botella plástica con agua caliente servida por el docente que se tapa y se enfría.</td></tr></table>
<p><strong>Veredicto:</strong> usar con correcciones.</p>',
            ],
            'revisar' => [
                'El auditor también es una IA: verifique usted las correcciones de gravedad alta en una fuente confiable.',
                'Use un chat nuevo para auditar, distinto al que generó el material, para reducir la tendencia a «defender» su propio texto.',
            ],
        ],
        [
            'id' => 'NAT-24',
            'categoria' => 'planeacion',
            'titulo' => 'Plan de periodo alineado con Estándares, DBA y Saber',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 3 h',
            'cuando' => 'Al iniciar el año o cada periodo, para distribuir DBA y evidencias en semanas y asegurar que las tres competencias de Saber se trabajen.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PERIODO]' => 'Periodo y número de semanas efectivas (descuente festivos, semanas institucionales).',
                '[INTENSIDAD]' => 'Horas semanales del área (y si se divide en biología, química y física).',
                '[DBA_DEL_PERIODO]' => 'DBA o evidencias asignados al periodo según el plan de área (textos oficiales).',
                '[EVENTOS]' => 'Eventos que afectan: feria de la ciencia, simulacros, semana cultural, salida.',
                '[RESULTADOS_PREVIOS]' => 'Resultados previos de Saber o diagnósticos (competencia más débil).',
            ],
            'prompt' => 'Actúa como coordinador académico experto en diseño curricular de Ciencias Naturales en Colombia, con dominio de Estándares, DBA y especificaciones de las pruebas Saber.

CONTEXTO
- Grado: [GRADO]. Periodo: [PERIODO]. Intensidad: [INTENSIDAD].
- DBA y evidencias del periodo (textos oficiales): [DBA_DEL_PERIODO]
- Eventos institucionales: [EVENTOS].
- Resultados previos: [RESULTADOS_PREVIOS].

TAREA
Construye el plan del periodo semana a semana.

FORMATO DE SALIDA
1. Tabla: Semana | DBA o evidencia | Pregunta o fenómeno de la semana | Competencia que se privilegia (uso comprensivo, explicación de fenómenos, indagación) | Actividad clave | Evaluación (formativa o sumativa).
2. Balance de competencias: porcentaje aproximado de tiempo para cada competencia y justificación según [RESULTADOS_PREVIOS].
3. Momentos de evaluación sumativa con ponderación sugerida, coherente con un SIEE típico (indica que debe ajustarse al propio).
4. Prácticas experimentales del periodo (mínimo dos) con su semana.
5. Conexiones con el PRAE y otras áreas.
6. Semanas de colchón para reenseñanza.

RESTRICCIONES
- No inventes DBA ni reasignes evidencias de otros grados.
- El plan debe caber en las semanas efectivas: no programes contenido en semanas de eventos.
- Incluye al menos una semana de colchón por cada 8 semanas.

AUTOVERIFICACIÓN
Verifica que todas las evidencias del periodo estén cubiertas, que las semanas suman [PERIODO] y que la competencia más débil recibe más tiempo.',
            'seguimientos' => [
                'Convierte la semana 4 en una secuencia didáctica completa (usa la receta de secuencia didáctica).',
                'Genera el formato de planeador semanal para imprimir, con espacio para observaciones.',
                'Ajusta el plan si pierdo dos semanas por paro o eventos no previstos: ¿qué priorizo?',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.°; [PERIODO] segundo periodo, 10 semanas efectivas; [INTENSIDAD] 4 horas semanales integradas; [DBA_DEL_PERIODO] reproducción en seres vivos y herencia (textos oficiales del DBA de 8.°); [EVENTOS] semana 6 feria de la ciencia; [RESULTADOS_PREVIOS] indagación es la competencia más débil en Saber 9.° institucional.',
                'resultado_html' => '<table><tr><th>Semana</th><th>Pregunta de la semana</th><th>Competencia</th><th>Actividad clave</th></tr>
<tr><td>1</td><td>¿Por qué los hijos se parecen a sus padres, pero no son iguales?</td><td>Explicación</td><td>Diagnóstico de ideas previas sobre herencia</td></tr>
<tr><td>3</td><td>¿Cómo se reproduce una papa sin semillas?</td><td>Indagación</td><td>Experimento de propagación vegetativa con papa, yuca y cebolla</td></tr>
<tr><td>6</td><td>Feria de la ciencia</td><td>Indagación</td><td>Presentación de los experimentos de propagación</td></tr>
<tr><td>8</td><td>¿Por qué los cruces de ganado buscan ciertas razas?</td><td>Uso comprensivo</td><td>Cuadros de Punnett con un rasgo de una raza criolla colombiana: la ausencia de cuernos del romosinuano (en bovinos, el carácter mocho es dominante sobre el carácter con cuernos)</td></tr>
<tr><td>9</td><td>Colchón</td><td>Según resultados</td><td>Reenseñanza</td></tr></table>
<p><strong>Balance:</strong> indagación 40 %, explicación 35 %, uso comprensivo 25 %, por los resultados previos.</p>',
            ],
            'revisar' => [
                'Que el plan coincida con el plan de área y la malla institucional aprobada.',
                'Que el calendario use las semanas reales de su institución.',
                'Que los porcentajes de evaluación correspondan a su SIEE.',
            ],
        ],
        [
            'id' => 'NAT-25',
            'categoria' => 'recursos',
            'titulo' => 'Analogías y modelos con sus límites explícitos',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 45 min',
            'cuando' => 'Cuando un concepto abstracto (átomo, célula, corriente eléctrica, enlace, ADN) necesita una analogía, pero no quiere que la analogía se vuelva una preconcepción.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[CONCEPTO]' => 'Concepto abstracto.',
                '[INTERESES]' => 'Intereses del grupo (fútbol, música, campo, videojuegos, cocina).',
            ],
            'prompt' => 'Actúa como didacta de las ciencias experto en el uso de analogías y modelos en el aula (enfoque que identifica semejanzas, diferencias y límites de cada analogía).

CONTEXTO
- Grado: [GRADO]. Concepto: [CONCEPTO]. Intereses del grupo: [INTERESES].

TAREA
Propón tres analogías distintas para [CONCEPTO], al menos una conectada con [INTERESES] y con la vida cotidiana colombiana.

FORMATO DE SALIDA (para cada analogía)
1. La analogía en 3 a 5 líneas, como la diría el docente.
2. Tabla de correspondencias: Elemento de la analogía | Elemento del concepto científico.
3. Dónde se rompe la analogía: al menos dos límites, explicados de modo que los estudiantes los entiendan.
4. Preconcepción que podría generar si no se aclaran los límites.
5. Pregunta para que los estudiantes encuentren por sí mismos un límite.
Al final: recomendación de cuál analogía usar primero y por qué, y una actividad de modelización física (con materiales) del concepto.

RESTRICCIONES
- Ninguna correspondencia de la tabla puede ser científicamente falsa.
- Evita analogías que requieran experiencias que el estudiante colombiano promedio no tiene (nieve, metro de Nueva York, béisbol de grandes ligas), salvo que el grupo las conozca.

AUTOVERIFICACIÓN
Revisa cada correspondencia y cada límite con criterio científico, y confirma que la actividad de modelización es segura.',
            'seguimientos' => [
                'Crea una ficha para que los estudiantes inventen su propia analogía y evalúen sus límites.',
                'Convierte la mejor analogía en una pregunta tipo Saber donde el estudiante deba detectar un límite.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.°; [CONCEPTO] corriente eléctrica en un circuito; [INTERESES] fútbol y fincas cafeteras.',
                'resultado_html' => '<p><strong>Analogía: el acueducto veredal.</strong> «El circuito es como el sistema de mangueras que lleva el agua del tanque a la finca. La bomba (pila) empuja el agua; el agua (cargas) circula; una manguera angosta (resistencia) deja pasar menos agua por segundo.»</p>
<table><tr><th>Analogía</th><th>Concepto</th></tr><tr><td>Bomba</td><td>Fuente de voltaje</td></tr><tr><td>Caudal de agua</td><td>Intensidad de corriente</td></tr><tr><td>Manguera angosta</td><td>Resistencia</td></tr><tr><td>Diferencia de presión</td><td>Diferencia de potencial</td></tr></table>
<p><strong>Dónde se rompe:</strong> (1) si se rompe una manguera, el agua se riega; si se corta un cable, la corriente no «se riega», simplemente deja de circular. (2) En la manguera el agua viaja rápido de un extremo a otro; en el cable, cada electrón avanza muy lentamente, aunque el efecto se transmite casi de inmediato.</p>
<p><strong>Preconcepción posible:</strong> «la pila guarda electricidad que se gasta como el agua de un tanque».</p>',
            ],
            'revisar' => [
                'Los límites: son la parte más valiosa y donde la IA suele ser más vaga.',
                'Que la analogía sea cercana a sus estudiantes reales.',
            ],
        ],
        [
            'id' => 'NAT-26',
            'categoria' => 'adaptacion',
            'titulo' => 'Diálogo de saberes: conocimiento tradicional y ciencia escolar',
            'grados' => '3.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'En instituciones etnoeducativas, rurales o con estudiantes de pueblos indígenas, comunidades negras, afrocolombianas, raizales, palenqueras o campesinas, cuando quiere articular el conocimiento propio con la ciencia escolar sin folclorizarlo ni descalificarlo.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[COMUNIDAD]' => 'Comunidad o pueblo y territorio.',
                '[PRACTICA_TRADICIONAL]' => 'Práctica o conocimiento propio (huerta tradicional, calendario de siembra, pesca, uso de plantas, construcción).',
                '[CONCEPTO_ESCOLAR]' => 'Concepto de ciencias con el que se quiere articular.',
                '[AUTORIDADES]' => 'Sabedores, mayores o autoridades con quienes se coordina.',
            ],
            'prompt' => 'Actúa como docente con experiencia en etnoeducación y educación intercultural en Colombia, respetuoso de la autonomía de los pueblos y de sus sistemas de conocimiento.

CONTEXTO
- Grado: [GRADO]. Comunidad: [COMUNIDAD].
- Práctica o conocimiento propio: [PRACTICA_TRADICIONAL].
- Concepto escolar: [CONCEPTO_ESCOLAR].
- Personas con quienes se coordina: [AUTORIDADES].

TAREA
Diseña una experiencia de aprendizaje de diálogo de saberes en la que los estudiantes: (1) conozcan la práctica desde la voz de los sabedores, (2) la observen o documenten con respeto, (3) la relacionen con conceptos de ciencias, (4) reflexionen sobre semejanzas, diferencias y aportes mutuos.

FORMATO DE SALIDA
1. Protocolo de acercamiento: cómo pedir permiso, a quién, qué no se debe grabar o publicar, cómo devolver el resultado a la comunidad.
2. Guía de conversación con el sabedor (preguntas abiertas, sin interrogatorio).
3. Actividad de observación o registro.
4. Tabla de diálogo: Lo que dice el saber propio | Lo que dice la ciencia escolar | Preguntas que surgen.
5. Reflexión final y producto para la comunidad.

RESTRICCIONES
- No presentes el saber tradicional como «mito» frente a la «verdad» científica, ni lo idealices como si nunca pudiera revisarse; ambos son sistemas de conocimiento con sus propios métodos.
- No describas prácticas espirituales o ceremoniales sin autorización; si la práctica tiene esa dimensión, indica que debe tratarse según lo defina la comunidad.
- Ninguna actividad implica consumir plantas, preparados o remedios.
- No generalices un pueblo a partir de otro; si no conoces la práctica específica de [COMUNIDAD], dilo y formula preguntas para averiguarla en lugar de inventarla.

AUTOVERIFICACIÓN
Revisa que no hayas atribuido a la comunidad prácticas o creencias que no te dieron en el contexto, y que el protocolo de permiso esté antes de cualquier actividad.',
            'seguimientos' => [
                'Redacta la carta de solicitud de acompañamiento a las autoridades tradicionales o al consejo comunitario.',
                'Diseña la rúbrica del producto final incluyendo el respeto y la fidelidad a la voz del sabedor.',
                'Propón cómo presentar el resultado en la lengua propia y en español, con apoyo de la comunidad.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.°; [COMUNIDAD] institución etnoeducativa en un resguardo nasa del norte del Cauca; [PRACTICA_TRADICIONAL] el tul, la huerta tradicional nasa con muchas especies sembradas juntas; [CONCEPTO_ESCOLAR] biodiversidad, relaciones entre especies y suelo; [AUTORIDADES] mayor sabedor y coordinación del proyecto educativo comunitario.',
                'resultado_html' => '<p><strong>Protocolo:</strong> la solicitud se presenta primero a la coordinación del proyecto educativo comunitario; el mayor decide qué se puede registrar; las fotos solo con permiso y sin publicar en redes; el producto final se entrega a la comunidad en una minga escolar.</p>
<table><tr><th>Lo que dice el saber propio</th><th>Lo que dice la ciencia escolar</th><th>Preguntas que surgen</th></tr>
<tr><td>En el tul se siembran juntas plantas que «se ayudan».</td><td>La asociación de cultivos puede mejorar el uso del suelo y reducir plagas; hay relaciones como el mutualismo y la fijación de nitrógeno por leguminosas.</td><td>¿Qué plantas se siembran juntas en el tul y por qué? ¿Podemos observar diferencias en el suelo?</td></tr></table>
<p><strong>Nota para el docente:</strong> las razones del saber propio se registran con las palabras del mayor; la tabla no busca «comprobar» el saber nasa con la ciencia, sino conversar entre ambos.</p>',
            ],
            'revisar' => [
                'Que la IA no haya inventado prácticas, palabras en lengua propia o creencias de la comunidad.',
                'El aval de las autoridades o sabedores antes de usar el material.',
                'La coherencia con el proyecto educativo comunitario (PEC) cuando exista.',
            ],
        ],
        [
            'id' => 'NAT-27',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Análisis de resultados de una prueba para decidir qué reenseñar',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 1 h 30 min',
            'cuando' => 'Después de un simulacro, una prueba de periodo o la llegada de resultados Saber, para convertir los datos en decisiones de aula y retroalimentación grupal.',
            'variables' => [
                '[GRADO]' => 'Grado y número de estudiantes evaluados.',
                '[RESULTADOS]' => 'Tabla con porcentaje de acierto por pregunta y, si la tiene, la opción más elegida en cada una.',
                '[ESPECIFICACIONES]' => 'Qué mide cada pregunta: competencia, componente, tema.',
                '[TIEMPO_DISPONIBLE]' => 'Clases disponibles para reenseñar.',
            ],
            'prompt' => 'Actúa como analista de evaluación educativa con experiencia en el uso pedagógico de resultados en ciencias naturales.

DATOS
- Grado: [GRADO].
- Resultados por pregunta: [RESULTADOS]
- Especificaciones: [ESPECIFICACIONES]
- Tiempo para reenseñar: [TIEMPO_DISPONIBLE].

TAREA
1. Calcula el porcentaje de acierto por competencia y por componente.
2. Identifica las preguntas críticas (acierto menor al 40 %) y, cuando tengas la opción más elegida, interpreta qué error de pensamiento revela.
3. Distingue problemas de conocimiento, de lectura del contexto y de razonamiento.
4. Prioriza qué reenseñar con el tiempo disponible.
5. Diseña la retroalimentación grupal.

FORMATO DE SALIDA
- Tabla resumen por competencia y componente.
- Lista de preguntas críticas con hipótesis del error.
- Plan de reenseñanza: Clase | Foco | Actividad | Cómo verifico que funcionó.
- Guion de retroalimentación grupal de 15 minutos: qué decir del resultado general (sin exponer a nadie), 3 preguntas para resolver juntos en voz alta y un compromiso del grupo.

RESTRICCIONES
- No hagas inferencias más allá de los datos; si el número de estudiantes es pequeño, advierte que las conclusiones son tentativas.
- No propongas «repetir la prueba» como estrategia principal.

AUTOVERIFICACIÓN
Recalcula los promedios por competencia y confirma que las prioridades corresponden a los datos más bajos y no a impresiones.',
            'seguimientos' => [
                'Con este análisis, redacta el informe para el consejo académico en una página.',
                'Diseña tres ítems nuevos que midan lo mismo que las preguntas críticas, para verificar después de reenseñar.',
                'Propón agrupamientos de estudiantes por tipo de error para la siguiente clase.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.°, 34 estudiantes; [RESULTADOS] 20 preguntas con porcentaje de acierto y opción más elegida; [ESPECIFICACIONES] 7 de indagación, 7 de explicación, 6 de uso comprensivo; [TIEMPO_DISPONIBLE] 4 clases.',
                'resultado_html' => '<table><tr><th>Competencia</th><th>Acierto promedio</th></tr><tr><td>Uso comprensivo</td><td>58 %</td></tr><tr><td>Explicación de fenómenos</td><td>49 %</td></tr><tr><td>Indagación</td><td>34 %</td></tr></table>
<p><strong>Pregunta crítica 12 (indagación, 21 % de acierto):</strong> la mayoría eligió la opción que cambia dos variables a la vez. Hipótesis: el grupo no reconoce la necesidad de controlar variables cuando el diseño «parece completo».</p>
<p><strong>Clase 1:</strong> foco en control de variables; actividad «¿Experimento justo o tramposo?» con cuatro diseños para comparar; verificación con un ticket de salida de dos preguntas.</p>
<p><strong>Guion grupal (inicio):</strong> «Como grupo, somos más fuertes aplicando conceptos que diseñando experimentos. Eso tiene solución y la vamos a trabajar en las próximas cuatro clases.»</p>',
            ],
            'revisar' => [
                'Recalcular los promedios: la IA a veces suma mal las tablas largas.',
                'Que las hipótesis de error tengan sentido con lo que usted conoce del grupo.',
                'No compartir resultados individuales con nombres.',
            ],
        ],
    ],

    'cadenas' => [
        [
            'titulo' => 'De la malla a la nota: una unidad completa',
            'objetivo' => 'Producir en una tarde la planeación, el diagnóstico, la secuencia, la práctica, la rúbrica y la retroalimentación de una unidad alineada con un DBA.',
            'pasos' => [
                ['paso' => 'Ubique la unidad dentro del periodo y la competencia que necesita más tiempo.', 'receta' => 'NAT-24', 'nota' => 'Copie el texto oficial de los DBA; no deje que la IA los resuma.'],
                ['paso' => 'Diagnostique las ideas previas del grupo antes de planear las sesiones.', 'receta' => 'NAT-10', 'nota' => 'Aplíquelo y pegue los resultados en el siguiente paso.'],
                ['paso' => 'Diseñe la secuencia didáctica considerando las concepciones encontradas.', 'receta' => 'NAT-01', 'nota' => 'En [CARACTERISTICAS] incluya lo que reveló el diagnóstico.'],
                ['paso' => 'Prepare la práctica experimental de la secuencia.', 'receta' => 'NAT-03', 'nota' => 'Haga la práctica usted mismo antes de la clase.'],
                ['paso' => 'Construya la rúbrica del producto final y socialícela desde el inicio.', 'receta' => 'NAT-09', 'nota' => 'Use los rangos exactos de su SIEE.'],
                ['paso' => 'Devuelva retroalimentación formativa sobre los informes.', 'receta' => 'NAT-08', 'nota' => 'Pida al final el resumen de errores frecuentes para la siguiente clase.'],
            ],
        ],
        [
            'titulo' => 'Preparación de Saber sin convertir la clase en simulacro',
            'objetivo' => 'Usar los resultados para enfocar la enseñanza en la competencia más débil y practicar con ítems de calidad.',
            'pasos' => [
                ['paso' => 'Analice los resultados del último simulacro o prueba.', 'receta' => 'NAT-27', 'nota' => 'Necesita el porcentaje de acierto por pregunta y, si es posible, la opción más elegida.'],
                ['paso' => 'Trabaje la competencia de indagación con datos colombianos.', 'receta' => 'NAT-15', 'nota' => 'Es la competencia que suele salir más baja.'],
                ['paso' => 'Construya ítems nuevos de la competencia débil.', 'receta' => 'NAT-04', 'nota' => 'Para 5.° y 9.° use NAT-05.'],
                ['paso' => 'Retroalimente las explicaciones escritas de los estudiantes.', 'receta' => 'NAT-18', 'nota' => 'Pida la justificación escrita de por qué descartaron cada opción.'],
                ['paso' => 'Diseñe planes de mejoramiento para quienes siguen en Bajo.', 'receta' => 'NAT-21', 'nota' => 'Enfóquelos en los errores detectados, no en todo el temario.'],
            ],
        ],
        [
            'titulo' => 'PRAE vivo: del diagnóstico ambiental al proyecto de aula',
            'objetivo' => 'Articular el Proyecto Ambiental Escolar con proyectos de indagación, salidas de campo y debate, y comunicar resultados a la comunidad.',
            'pasos' => [
                ['paso' => 'Haga el diagnóstico participativo y priorice una problemática.', 'receta' => 'NAT-13', 'nota' => 'Involucre a estudiantes de varios grados en el diagnóstico.'],
                ['paso' => 'Convierta la problemática en un proyecto de indagación por grado.', 'receta' => 'NAT-02', 'nota' => 'Una pregunta investigable distinta por grado.'],
                ['paso' => 'Levante datos de biodiversidad o del entorno.', 'receta' => 'NAT-22', 'nota' => 'Los datos alimentan el indicador del PRAE.'],
                ['paso' => 'Discuta las decisiones con un caso socio-científico.', 'receta' => 'NAT-14', 'nota' => 'Distinga lo que dice la ciencia de lo que se decide en comunidad.'],
                ['paso' => 'Informe avances a las familias.', 'receta' => 'NAT-20', 'nota' => 'Adapte el formato a un boletín para todas las familias.'],
            ],
        ],
        [
            'titulo' => 'Inclusión real en ciencias: nadie se queda fuera del laboratorio',
            'objetivo' => 'Planear una unidad con ajustes razonables y DUA desde el inicio, no como añadido al final.',
            'pasos' => [
                ['paso' => 'Defina los ajustes razonables del estudiante para la unidad.', 'receta' => 'NAT-07', 'nota' => 'Use descripción pedagógica, nunca nombres ni diagnósticos detallados.'],
                ['paso' => 'Prepare la lectura central en tres niveles.', 'receta' => 'NAT-06', 'nota' => 'Las preguntas de discusión son comunes para todo el grupo.'],
                ['paso' => 'Ajuste la práctica de laboratorio con roles y apoyos.', 'receta' => 'NAT-03', 'nota' => 'En [MATERIALES_DISPONIBLES] incluya los apoyos del PIAR.'],
                ['paso' => 'Construya una rúbrica que valore la misma evidencia con formatos flexibles.', 'receta' => 'NAT-09', 'nota' => 'Pida una versión con íconos si el estudiante la necesita.'],
            ],
        ],
        [
            'titulo' => 'Primaria rural multigrado: una semana de ciencias',
            'objetivo' => 'Organizar una semana de ciencias en un aula multigrado con exploración, cuento, evaluación y comunicación con familias.',
            'pasos' => [
                ['paso' => 'Planee la clase multigrado con tema común.', 'receta' => 'NAT-19', 'nota' => 'Pegue los DBA de cada grado presente.'],
                ['paso' => 'Diseñe la experiencia de exploración para los más pequeños.', 'receta' => 'NAT-11', 'nota' => 'Los monitores de 4.° y 5.° pueden acompañar.'],
                ['paso' => 'Escriba un cuento con una especie de la región como provocación.', 'receta' => 'NAT-12', 'nota' => 'Verifique los datos de la especie.'],
                ['paso' => 'Evalúe con ítems sencillos tipo Saber a los grados 4.° y 5.°.', 'receta' => 'NAT-05', 'nota' => 'Use el mismo ecosistema del cuento.'],
                ['paso' => 'Comunique a las familias lo aprendido y cómo apoyar en casa.', 'receta' => 'NAT-20', 'nota' => 'Actividades sin costo y con saberes de la finca.'],
            ],
        ],
    ],

    'rubricas' => [
        [
            'titulo' => 'Informe de práctica de laboratorio (6.° a 11.°)',
            'criterios' => [
                ['criterio' => 'Pregunta e hipótesis', 'niveles' => [
                    'Superior' => 'Formula una hipótesis contrastable que relaciona explícitamente variables y la justifica con un concepto científico.',
                    'Alto' => 'Formula una hipótesis contrastable que relaciona variables, con justificación parcial.',
                    'Básico' => 'Formula una predicción comprobable, sin justificación científica.',
                    'Bajo' => 'Escribe una afirmación que no puede ponerse a prueba o que no se relaciona con la pregunta.',
                ]],
                ['criterio' => 'Registro y manejo de datos', 'niveles' => [
                    'Superior' => 'Presenta tablas completas con unidades, repeticiones y promedios, y una gráfica adecuada con ejes rotulados.',
                    'Alto' => 'Presenta tablas con unidades y repeticiones; la gráfica tiene errores menores.',
                    'Básico' => 'Presenta datos organizados con algunas omisiones de unidades o sin repeticiones.',
                    'Bajo' => 'Los datos están incompletos, desorganizados o no corresponden a lo realizado.',
                ]],
                ['criterio' => 'Análisis y conclusión', 'niveles' => [
                    'Superior' => 'Concluye a partir de los datos, explica el resultado con el modelo científico y reconoce fuentes de error y su efecto.',
                    'Alto' => 'Concluye a partir de los datos y los explica con el concepto, sin analizar errores.',
                    'Básico' => 'Describe los resultados, pero la conclusión se apoya poco en los datos.',
                    'Bajo' => 'La conclusión contradice los datos o repite la teoría sin relacionarla con lo observado.',
                ]],
                ['criterio' => 'Seguridad y trabajo en equipo', 'niveles' => [
                    'Superior' => 'Cumple todas las normas, anticipa riesgos y apoya a su equipo en el cumplimiento de su rol.',
                    'Alto' => 'Cumple todas las normas y su rol en el equipo.',
                    'Básico' => 'Cumple las normas con recordatorios y realiza su rol parcialmente.',
                    'Bajo' => 'Incumple normas de seguridad o no asume su rol.',
                ]],
            ],
        ],
        [
            'titulo' => 'Explicación científica escrita (afirmación, evidencia, razonamiento)',
            'criterios' => [
                ['criterio' => 'Afirmación', 'niveles' => [
                    'Superior' => 'Responde la pregunta de forma precisa y completa, usando vocabulario científico pertinente.',
                    'Alto' => 'Responde la pregunta de forma correcta con vocabulario adecuado.',
                    'Básico' => 'Responde la pregunta de forma parcial o poco precisa.',
                    'Bajo' => 'No responde la pregunta o la respuesta es incorrecta.',
                ]],
                ['criterio' => 'Evidencia', 'niveles' => [
                    'Superior' => 'Usa evidencia suficiente y pertinente (datos, observaciones) y explica por qué es relevante.',
                    'Alto' => 'Usa evidencia pertinente y suficiente.',
                    'Básico' => 'Usa alguna evidencia, insuficiente o parcialmente pertinente.',
                    'Bajo' => 'No usa evidencia o usa información que no apoya la afirmación.',
                ]],
                ['criterio' => 'Razonamiento', 'niveles' => [
                    'Superior' => 'Conecta evidencia y afirmación mediante un principio o modelo científico correcto y considera una explicación alternativa.',
                    'Alto' => 'Conecta evidencia y afirmación mediante un principio científico correcto.',
                    'Básico' => 'Intenta conectar evidencia y afirmación, con imprecisiones conceptuales.',
                    'Bajo' => 'No hay conexión o se basa en una idea errónea.',
                ]],
            ],
        ],
        [
            'titulo' => 'Proyecto de indagación o STEM',
            'criterios' => [
                ['criterio' => 'Problema y pregunta investigable', 'niveles' => [
                    'Superior' => 'Plantea un problema real del entorno y una pregunta medible con variables bien definidas; justifica su relevancia para la comunidad.',
                    'Alto' => 'Plantea un problema real y una pregunta medible con variables definidas.',
                    'Básico' => 'Plantea un problema real, pero la pregunta es amplia o las variables poco claras.',
                    'Bajo' => 'La pregunta no es investigable con los recursos disponibles o no se relaciona con el problema.',
                ]],
                ['criterio' => 'Diseño y ejecución de la investigación', 'niveles' => [
                    'Superior' => 'Controla variables, repite mediciones, registra con rigor y ajusta el diseño cuando detecta problemas.',
                    'Alto' => 'Controla variables y repite mediciones con registro ordenado.',
                    'Básico' => 'Realiza mediciones con control parcial de variables o sin repeticiones.',
                    'Bajo' => 'Las mediciones no permiten responder la pregunta.',
                ]],
                ['criterio' => 'Solución o prototipo', 'niveles' => [
                    'Superior' => 'La solución responde al problema, cumple los criterios de diseño, se probó, se mejoró con evidencia y es viable en el contexto.',
                    'Alto' => 'La solución responde al problema y se probó al menos una vez.',
                    'Básico' => 'La solución responde parcialmente al problema y no se probó de forma sistemática.',
                    'Bajo' => 'La solución no se relaciona con el problema o no se construyó.',
                ]],
                ['criterio' => 'Comunicación a la comunidad', 'niveles' => [
                    'Superior' => 'Comunica resultados con datos, reconoce limitaciones y adapta el lenguaje a una audiencia real fuera del aula.',
                    'Alto' => 'Comunica resultados con datos y lenguaje claro.',
                    'Básico' => 'Comunica lo que hicieron, con pocos datos o sin conclusiones claras.',
                    'Bajo' => 'La comunicación es incompleta o no corresponde a lo investigado.',
                ]],
            ],
        ],
        [
            'titulo' => 'Participación en debate socio-científico (CTS)',
            'criterios' => [
                ['criterio' => 'Uso del conocimiento científico', 'niveles' => [
                    'Superior' => 'Usa conceptos científicos con precisión para sustentar y para cuestionar argumentos, incluidos los de su propia posición.',
                    'Alto' => 'Usa conceptos científicos correctos para sustentar su posición.',
                    'Básico' => 'Menciona conceptos científicos, con imprecisiones o sin relacionarlos con el argumento.',
                    'Bajo' => 'Argumenta solo con opiniones o con conceptos incorrectos.',
                ]],
                ['criterio' => 'Uso de evidencias', 'niveles' => [
                    'Superior' => 'Cita evidencias pertinentes, evalúa su confiabilidad y distingue datos de opiniones.',
                    'Alto' => 'Cita evidencias pertinentes del dossier.',
                    'Básico' => 'Cita evidencias de manera general o poco pertinente.',
                    'Bajo' => 'No cita evidencias.',
                ]],
                ['criterio' => 'Consideración de otras perspectivas', 'niveles' => [
                    'Superior' => 'Reconstruye con justicia el argumento contrario y responde a él; reconoce dimensiones éticas, económicas y sociales.',
                    'Alto' => 'Reconoce y responde a argumentos contrarios.',
                    'Básico' => 'Reconoce que existen otras posiciones, sin responderlas.',
                    'Bajo' => 'Descalifica o ignora a quienes piensan distinto.',
                ]],
            ],
        ],
    ],

    'errores' => [
        [
            'error' => 'Afirmar que el agua siempre hierve a 100 °C, sin considerar la presión atmosférica.',
            'como_detectarlo' => 'Busque cifras de ebullición o de cocción sin mención de la altitud. En ciudades como Bogotá, Tunja o Pasto el error es evidente para cualquier estudiante que mida.',
            'como_corregirlo' => 'Precise «a nivel del mar» y aproveche el error: en Bogotá el agua hierve a cerca de 92 °C. Pida a la IA que incluya la relación entre altitud, presión y punto de ebullición.',
        ],
        [
            'error' => 'Explicar el clima colombiano con cuatro estaciones (primavera, verano, otoño, invierno).',
            'como_detectarlo' => 'Aparecen «estaciones del año» o actividades como «el otoño en tu ciudad». También frases como «en invierno nieva» aplicadas a Colombia.',
            'como_corregirlo' => 'Colombia, por su ubicación en la zona intertropical, tiene temporadas secas y de lluvias, y pisos térmicos según la altitud. En el uso popular se dice «invierno» a la temporada de lluvias y «verano» a la seca; aclárelo como un uso regional, no como estaciones astronómicas.',
        ],
        [
            'error' => 'Exagerar o desactualizar datos de biodiversidad («Colombia es el país más biodiverso del mundo», cifras exactas de especies sin fuente).',
            'como_detectarlo' => 'Superlativos absolutos y cifras redondas sin fuente ni año.',
            'como_corregirlo' => 'Use formulaciones defendibles: Colombia es uno de los países megadiversos, suele ubicarse segundo en biodiversidad total y primero en aves y orquídeas. Verifique cifras en el Instituto Humboldt o el SiB Colombia y cite el año.',
        ],
        [
            'error' => 'Proponer prácticas inseguras: mezclar cloro con vinagre o amoníaco, usar mecheros manipulados por estudiantes, soda cáustica, termómetros de mercurio o experimentos «virales».',
            'como_detectarlo' => 'Lea cada paso del procedimiento buscando calor, llama, gases, productos de limpieza o vidrio.',
            'como_corregirlo' => 'Incluya siempre en el prompt las restricciones de seguridad de la receta NAT-03 y pida la tabla de análisis de riesgos. Cambie la práctica a demostración del docente o a simulación cuando no sea segura.',
        ],
        [
            'error' => 'Reforzar preconcepciones al simplificar: «las plantas se alimentan del suelo», «las plantas respiran solo de noche», «el frío entra», «los objetos pesados caen más rápido».',
            'como_detectarlo' => 'Revise frases simplificadas en los materiales de primaria y en las analogías; compare con la lista de concepciones alternativas del tema (receta NAT-10).',
            'como_corregirlo' => 'Pida a la IA que identifique y elimine preconcepciones, y reformule: las plantas fabrican su alimento con agua, dióxido de carbono y energía de la luz; respiran día y noche; el calor fluye del cuerpo más caliente al más frío.',
        ],
        [
            'error' => 'Ejemplos, fauna y contextos de otros países: ardillas grises, osos polares, mapaches, arces, nieve, millas, libras, grados Fahrenheit.',
            'como_detectarlo' => 'Especies o paisajes que sus estudiantes nunca han visto y unidades no métricas.',
            'como_corregirlo' => 'Indique la región colombiana y el ecosistema en el prompt, exija unidades del SI y use el banco de contextos de este kit. Verifique que las especies sean de ese ecosistema.',
        ],
        [
            'error' => 'Mezclar fauna y flora de ecosistemas colombianos distintos (frailejones en el manglar, jaguares en el páramo, delfines rosados en el Caribe).',
            'como_detectarlo' => 'Revise cada especie mencionada en redes tróficas, cuentos o ítems contra el ecosistema indicado.',
            'como_corregirlo' => 'Pida la lista de especies con su ecosistema y verifíquela en el SiB Colombia, guías regionales o el Instituto Humboldt.',
        ],
        [
            'error' => 'Clasificaciones y modelos desactualizados presentados como definitivos (cinco reinos sin mencionar los dominios, el átomo como sistema solar, Plutón como planeta).',
            'como_detectarlo' => 'Busque modelos presentados como «la verdad» sin indicar que son modelos históricos o simplificados.',
            'como_corregirlo' => 'Presente los modelos como representaciones que cambian con la evidencia; pida a la IA indicar el modelo vigente y el contexto histórico de los anteriores.',
        ],
        [
            'error' => 'Confusiones conceptuales clásicas: masa y peso, calor y temperatura, cambio climático y agujero de la capa de ozono, energía que «se gasta» o «se crea».',
            'como_detectarlo' => 'Términos usados como sinónimos en el mismo texto o explicaciones que mezclan dos fenómenos.',
            'como_corregirlo' => 'Pida a la IA una tabla que diferencie los conceptos y revise el texto con ella; use la receta NAT-23 para auditar.',
        ],
        [
            'error' => 'Ecuaciones químicas mal balanceadas, masas molares erradas y errores aritméticos en problemas de física.',
            'como_detectarlo' => 'Cuente átomos a cada lado y recalcule al menos dos resultados. Sospeche de resultados con demasiados decimales o magnitudes absurdas.',
            'como_corregirlo' => 'Exija en el prompt la tabla de conteo de átomos y el recálculo independiente (recetas NAT-16 y NAT-17).',
        ],
        [
            'error' => 'Inventar DBA, números de DBA, estándares o especificaciones del ICFES.',
            'como_detectarlo' => 'Textos de DBA que no coinciden con el documento oficial, números que no existen o «competencias» que no corresponden a la prueba.',
            'como_corregirlo' => 'Copie siempre el texto oficial en el prompt y prohíba explícitamente que la IA lo modifique o invente referencias.',
        ],
        [
            'error' => 'Datos ambientales y de salud desactualizados o sin fuente (población de especies invasoras, áreas deforestadas, casos de dengue, normas ambientales).',
            'como_detectarlo' => 'Cifras exactas sin año ni entidad, o normas citadas con número dudoso.',
            'como_corregirlo' => 'Marque con [POR CONFIRMAR] y consulte IDEAM, Instituto Humboldt, Instituto Nacional de Salud, Ministerio de Ambiente o la corporación autónoma regional. Prefiera datos con año de corte.',
        ],
    ],

    'banco_contextos' => [
        'El agua hierve a cerca de 92 °C en Bogotá y a cerca de 100 °C en Cartagena: presión atmosférica y altitud.',
        'Los páramos de Chingaza y Sumapaz como fuentes de agua de Bogotá; el frailejón y su lento crecimiento.',
        'El racionamiento de agua en Bogotá de 2024 y su relación con el fenómeno de El Niño y el nivel de los embalses.',
        'La temporada de lluvias y la temporada seca: zona de convergencia intertropical y fenómenos de El Niño y La Niña.',
        'Hipopótamos en el Magdalena Medio: especie invasora, crecimiento poblacional y decisiones de manejo.',
        'El pez león en el Caribe colombiano: especie invasora en arrecifes coralinos.',
        'Blanqueamiento de corales en las islas del Rosario y San Andrés: temperatura del mar y simbiosis.',
        'Manglares del Pacífico y del Caribe: cadenas tróficas, piangua, cangrejos y protección contra la erosión costera.',
        'Ballenas jorobadas en el Pacífico (Bahía Solano, Nuquí, Bahía Málaga): migración y reproducción.',
        'Caño Cristales en la Macarena: plantas acuáticas que dan color al río y factores que lo hacen posible.',
        'La tragedia de Armero (1985) y el volcán Nevado del Ruiz: lahares, monitoreo volcánico y gestión del riesgo.',
        'Sismos en Colombia: placas tectónicas de Nazca, Caribe y Suramericana; el terremoto del Eje Cafetero de 1999.',
        'Minería de oro y mercurio en ríos del Chocó y Antioquia: bioacumulación y salud; el río Atrato reconocido como sujeto de derechos.',
        'La broca y la roya del café: plagas, control biológico y variedades resistentes en la zona cafetera.',
        'De la caña a la panela en el trapiche: cambios físicos, evaporación y fermentación del guarapo.',
        'Sal de Zipaquirá y de Manaure: cloruro de sodio, cristalización y evaporación.',
        'El bosque seco tropical (Caribe, valles interandinos, Tatacoa): ecosistema muy reducido y adaptaciones a la sequía.',
        'Dengue y el mosquito Aedes aegypti: ciclo de vida, criaderos en el hogar y salud pública.',
        'Agua lluvia en el Chocó, una de las regiones más lluviosas del planeta, y escasez de agua en La Guajira.',
        'Energía en Colombia: predominio de la hidroelectricidad, parques eólicos y solares en La Guajira, crisis de Hidroituango.',
        'Incendios forestales en temporada seca en los cerros orientales de Bogotá y en la Orinoquía.',
        'La rana dorada venenosa del Pacífico caucano: coloración de advertencia y alcaloides.',
        'El oso de anteojos y el cóndor andino: especies sombrilla y conservación en la cordillera.',
        'Aves de Colombia: el país con más especies de aves registradas; conteos de ciencia ciudadana.',
        'El río Bogotá: contaminación, oxígeno disuelto y plantas de tratamiento de aguas residuales.',
        'Esmeraldas de Muzo y Chivor: minerales, cristales y la química del color verde.',
        'Cacao fino de aroma colombiano: fermentación, cadmio en suelos y exportación.',
        'Ciclistas colombianos en altura: adaptación fisiológica, glóbulos rojos y oxígeno en la sangre.',
    ],
];
