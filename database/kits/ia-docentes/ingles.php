<?php

// Kit de IA para docentes: Inglés
// Contenido curado por Edwin Ortiz Herazo (edwinortiz.net). Generado como arreglo PHP para el render a PDF.

return [
    'key' => 'ingles',
    'name' => 'Inglés',
    'tagline' => 'Flujos de IA probados para planear, evaluar, adaptar y retroalimentar la clase de inglés con los Estándares (Guía 22), los DBA y el MCER, en contextos colombianos.',
    'intro_html' => '<p>Este kit no es una lista de «prompts para inglés». Es un conjunto de <strong>recetas de trabajo</strong> que un docente de inglés colombiano usa en su semana real: planear desde un DBA con una meta MCER explícita, producir lecturas graduadas, preparar ítems con el formato de la prueba de inglés de Saber 11, evaluar speaking y writing con la escala del Decreto 1290, ajustar para estudiantes con PIAR y escribir informes para familias que no hablan inglés.</p> <p>Cada receta trae: <strong>cuándo usarla</strong>, las <strong>variables</strong> que usted debe llenar, el <strong>prompt listo para copiar</strong> (con rol, contexto, tarea, formato, restricciones y un paso de autoverificación), <strong>seguimientos</strong> para afinar el resultado, un <strong>ejemplo real ya editado por un experto</strong> y una lista de <strong>qué revisar</strong> antes de llevarlo al aula. Al final encontrará cadenas de trabajo (varias recetas encadenadas), rúbricas con la escala nacional, los errores típicos de la IA en inglés y un banco de contextos colombianos.</p> <p><strong>Tres reglas de oro.</strong> (1) <strong>El nivel lo pone usted, no la IA</strong>: escriba siempre el nivel MCER objetivo (A1, A2, B1) y pida que la IA marque cualquier palabra o estructura que lo supere. (2) <strong>Pegue el texto oficial</strong> del DBA o del estándar en lugar de pedir que la IA lo «recuerde»: los modelos inventan numeraciones y redacciones. (3) <strong>Nunca ingrese datos personales</strong> de estudiantes (nombres completos, documentos, diagnósticos con nombre): use iniciales o «Estudiante A», en coherencia con la Ley 1581 de 2012.</p> <p>Las recetas funcionan con cualquier asistente de uso general (ChatGPT, Gemini, Claude, Copilot). Cuando una receta produce material para los estudiantes, el material está en inglés y las explicaciones para usted, en español de Colombia.</p>',
    'referentes_html' => '<p><strong>Estándares Básicos de Competencias en Lenguas Extranjeras: Inglés (Guía 22, MEN, 2006).</strong> Organiza el aprendizaje por grupos de grados y los relaciona con niveles del MCER: 1.° a 3.° Principiante (A1); 4.° y 5.° Básico 1 (A2.1); 6.° y 7.° Básico 2 (A2.2); 8.° y 9.° Pre-intermedio 1 (B1.1); 10.° y 11.° Pre-intermedio 2 (B1.2). Plantea cinco habilidades: escucha, lectura, escritura, monólogos y conversación, y la meta de B1 al terminar la media.</p> <p><strong>Derechos Básicos de Aprendizaje (DBA) de Inglés.</strong> El MEN publicó los DBA de inglés para 6.° a 11.° (2016) y, posteriormente, los DBA para transición a 5.° junto con el currículo sugerido de primaria. Cada grado tiene un conjunto de enunciados con evidencias de aprendizaje. En este kit <strong>no citamos números de DBA</strong>: le pedimos que pegue el texto literal del documento que usa su institución, porque la numeración varía entre versiones y es justo lo que la IA tiende a inventar.</p> <p><strong>Currículo Sugerido de Inglés.</strong> Para 6.° a 11.° propone módulos organizados en ejes transversales (democracia y paz, salud, sostenibilidad y globalización) con enfoque por tareas y proyectos; los textos del MEN para secundaria (<em>Way to Go!</em> y <em>English, please!</em>) siguen esa lógica. Para primaria existe un currículo sugerido de transición a 5.° con su propia organización temática.</p> <p><strong>Marco Común Europeo de Referencia (MCER/CEFR)</strong> y su <em>Companion Volume</em> (Consejo de Europa, 2020), que añade descriptores de mediación y escalas actualizadas; útil para redactar can-do statements.</p> <p><strong>Prueba de inglés de Saber 11 (ICFES).</strong> Evalúa lectura, vocabulario y uso de la lengua en siete partes con tareas diferentes (avisos, léxico, conversaciones cortas, textos incompletos y comprensión de lectura literal e inferencial). <strong>No evalúa escucha ni habla.</strong> Reporta niveles A-, A1, A2, B1 y B+. Verifique cada año la <em>Guía de orientación</em> vigente del ICFES antes de diseñar simulacros, porque el orden y el número de preguntas pueden ajustarse.</p> <p><strong>Política de bilingüismo:</strong> Ley 1651 de 2013 (Ley de Bilingüismo) y el Programa Nacional de Bilingüismo / Colombia Bilingüe. <strong>Evaluación:</strong> Decreto 1290 de 2009 (escala Superior, Alto, Básico, Bajo, definida en el SIEE de cada institución). <strong>Inclusión:</strong> Decreto 1421 de 2017 (PIAR, ajustes razonables) y Diseño Universal para el Aprendizaje (pautas de CAST). <strong>Datos personales:</strong> Ley 1581 de 2012 y Decreto 1377 de 2013.</p>',
    'mapa' => [
        [
            'grados' => 'Transición a 3.°',
            'enfoque' => 'Inglés como experiencia: escuchar, responder con el cuerpo, repetir rutinas, canciones y cuentos con mucha imagen. Meta A1 inicial (Guía 22: Principiante). Casi nada de escritura libre.',
            'claves' => [
                'Pida a la IA chants y cuentos con repetición y patrones (Is it…? No, it isn\'t!), nunca listas de vocabulario sueltas.',
                'Instrucciones de aula de 3 a 5 palabras con gesto (Stand up, please. Touch your nose.).',
                'Exija vocabulario concreto y visualizable del entorno: finca, plaza de mercado, animales de la región.',
                'Evaluación por observación y lista de cotejo, no con pruebas escritas.',
                'Revise que la IA no proponga lectura de textos largos ni reglas gramaticales explícitas.',
            ],
        ],
        [
            'grados' => '4.° y 5.°',
            'enfoque' => 'Del reconocimiento a la producción guiada: frases modelo, diálogos cortos, descripciones simples de personas, lugares y rutinas. Meta A1 consolidado hacia A2.1.',
            'claves' => [
                'Pida modelos de lengua completos (diálogo de 6 a 8 líneas) antes de pedir producción.',
                'Use juegos de roles con tarjetas A/B: la IA los produce muy bien si le da la situación local (la tienda, el bus intermunicipal).',
                'Exija apoyo visual y léxico bilingüe para instrucciones complejas.',
                'Escritura con andamiaje: completar, ordenar, escribir 3 a 5 oraciones con modelo.',
                'Verifique que las lecturas no superen 80 a 120 palabras con oraciones simples.',
            ],
        ],
        [
            'grados' => '6.° y 7.°',
            'enfoque' => 'Comunicación sobre el entorno inmediato con tareas reales: dar y pedir información, describir, narrar en pasado simple. Guía 22: Básico 2 (A2.2); en la práctica muchos grupos parten de A1.',
            'claves' => [
                'Haga diagnóstico antes de planear: la IA calibra mejor si usted le dice el nivel real, no solo el esperado.',
                'Planee por tareas con producto (un mapa del barrio, una encuesta, un aviso).',
                'Pida explicaciones gramaticales contrastivas con el español y errores típicos de hispanohablantes.',
                'Inicie el formato Saber con tareas de avisos y léxico, sin convertir la clase en entrenamiento de prueba.',
                'Controle que los diálogos no usen modismos estadounidenses fuera de nivel.',
            ],
        ],
        [
            'grados' => '8.° y 9.°',
            'enfoque' => 'Textos más largos, opiniones sencillas, experiencias y planes; proyectos con ejes del Currículo Sugerido. Guía 22: Pre-intermedio 1 (B1.1).',
            'claves' => [
                'Lecturas graduadas en tres niveles (A1, A2, B1) del mismo texto para grupos heterogéneos.',
                'Escritura de correos, blogs y reseñas con rúbrica analítica y códigos de error.',
                'Speaking con tarjetas de tarea y tiempo de planeación; evaluación con rúbrica de 4 criterios.',
                'Proyectos de 4 a 6 semanas con producto público (emisora escolar, cartelera bilingüe).',
                'Pida a la IA que distinga present perfect y pasado simple pensando en el español colombiano.',
            ],
        ],
        [
            'grados' => '10.° y 11.°',
            'enfoque' => 'Argumentar, comparar fuentes, inferir y prepararse para Saber 11 y la vida universitaria o laboral. Guía 22: Pre-intermedio 2 (B1.2); meta nacional B1.',
            'claves' => [
                'Simulacros por partes de Saber 11 con justificación de distractores, verificados uno a uno.',
                'Análisis de resultados por parte para decidir qué enseñar, no solo qué repetir.',
                'Lectura inferencial y crítica con textos sobre temas colombianos actuales.',
                'Speaking argumentativo (recomendar, persuadir, debatir) con rúbrica B1.',
                'Uso crítico de la IA por parte de los estudiantes: detectar errores y sesgos en textos generados.',
            ],
        ],
    ],
    'recetas' => [
        [
            'id' => 'ING-01',
            'categoria' => 'planeacion',
            'titulo' => 'Plan de clase desde un DBA con meta MCER explícita',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 45 min',
            'cuando' => 'Cuando tiene que planear una clase concreta y quiere que todo (objetivo, lengua meta, tarea y evaluación) quede amarrado a un DBA y a un nivel MCER real, no a un tema suelto del libro.',
            'variables' => [
                '[GRADO]' => 'Grado y curso (p. ej., 7.° B).',
                '[NIVEL_MCER]' => 'Nivel objetivo realista del grupo (A1, A2, B1). Si el diagnóstico dice A1 aunque el grado espera A2, escriba A1.',
                '[DBA]' => 'Texto literal del DBA y sus evidencias, copiado del documento oficial.',
                '[EJE_TEMATICO]' => 'Eje del Currículo Sugerido (democracia y paz, salud, sostenibilidad, globalización) o tema institucional.',
                '[TEMA]' => 'Tema concreto de la clase.',
                '[DURACION]' => 'Minutos reales de clase (descuente llamado a lista y desplazamientos).',
                '[N_ESTUDIANTES]' => 'Número de estudiantes.',
                '[RECURSOS]' => 'Lo que de verdad tiene: tablero, parlante, fotocopias, celular del docente, sin internet, etc.',
                '[CARACTERISTICAS_GRUPO]' => 'Intereses, ritmo, convivencia, estudiantes con PIAR (sin nombres).',
            ],
            'prompt' => 'Actúa como docente de inglés colombiano con experiencia en enseñanza comunicativa y aprendizaje basado en tareas (TBLT), experto en los Estándares Básicos de Competencias en Lenguas Extranjeras: Inglés (Guía 22), los Derechos Básicos de Aprendizaje (DBA) de Inglés y el MCER.

CONTEXTO
- Grado: [GRADO]. Nivel MCER objetivo del grupo: [NIVEL_MCER].
- DBA y evidencias que trabajaremos (texto literal, no lo modifiques ni lo renumeres): "[DBA]"
- Eje temático: [EJE_TEMATICO]. Tema de la clase: [TEMA].
- Duración: [DURACION] minutos. Estudiantes: [N_ESTUDIANTES].
- Recursos disponibles: [RECURSOS].
- Características del grupo: [CARACTERISTICAS_GRUPO].

TAREA
Diseña UNA clase con:
1. Objetivo en forma de can-do statement ("Students can…"), observable y coherente con una evidencia del DBA.
2. Lengua meta: funciones comunicativas, máximo 8 palabras o expresiones nuevas y UNA estructura gramatical, cada una con un ejemplo contextualizado.
3. Secuencia por etapas (warm-up, pre-task, task, report, language focus, cierre) con tiempo, frases exactas del docente en inglés sencillo, qué hacen los estudiantes e interacción (T-Ss, S-S, grupos).
4. Una tarea comunicativa con propósito y producto real (un aviso, una encuesta, un mapa, una recomendación), no un ejercicio de completar.
5. Evidencia de evaluación formativa: qué voy a observar y cuál es el criterio de logro.
6. Un ajuste para quienes terminan rápido y uno para quienes necesitan apoyo.
7. Tarea corta para casa que no requiera internet.

FORMATO DE SALIDA
- Primero una tabla: Etapa | Tiempo | Docente (frases en inglés) | Estudiantes | Interacción | Material.
- Después los puntos 1, 2, 5, 6 y 7 en viñetas.

RESTRICCIONES
- Todo lo que deben comprender o producir los estudiantes debe estar dentro de [NIVEL_MCER]. Si necesitas una palabra de nivel superior, márcala con (*) y dame una glosa.
- Contextos colombianos y cercanos al estudiante. No uses como eje fiestas o costumbres ajenas (Thanksgiving, prom, Halloween) salvo que lo pida.
- Explicaciones para mí en español de Colombia; material para estudiantes en inglés.
- Cada instrucción del docente en inglés: máximo 10 palabras, acompañada de un gesto o demostración sugerida.
- Si hay fotocopias, que el material quepa en media hoja por estudiante.

AUTOVERIFICACIÓN (hazla antes de entregar y repórtala en 4 líneas)
a) ¿La tarea permite observar la evidencia del DBA? Explica cómo.
b) ¿Los tiempos suman exactamente [DURACION] minutos?
c) ¿Hay palabras o estructuras por encima de [NIVEL_MCER]? Si las hay, reemplázalas.
d) ¿La clase funciona con los recursos declarados y sin internet?',
            'seguimientos' => [
                'Convierte la etapa «task» en una ficha para estudiantes de media página: instrucciones en inglés, un ejemplo resuelto y un recuadro de vocabulario con imagen sugerida.',
                'Dame 3 variantes del warm-up que no requieran materiales y funcionen con 40 estudiantes en un salón con pupitres fijos.',
                'Escribe 4 preguntas de verificación de instrucciones (ICQs) y 4 de verificación de concepto (CCQs) para la estructura de la clase, con la respuesta esperada.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.° A · [NIVEL_MCER] A1 alto (el grado espera A2) · [DBA] el enunciado de 7.° sobre dar y pedir información de lugares del entorno, pegado del documento oficial · [EJE_TEMATICO] Globalización · [TEMA] Places in my town: Sincelejo · [DURACION] 55 min · [N_ESTUDIANTES] 38 · [RECURSOS] tablero, marcadores, parlante del celular, fotocopias en blanco y negro, sin internet · [CARACTERISTICAS_GRUPO] grupo participativo pero ruidoso; dos estudiantes con PIAR (uno con discapacidad intelectual leve).',
                'resultado_html' => '<p><strong>Objetivo:</strong> Students can ask for and give simple directions to places in Sincelejo using <em>there is / there are</em>, prepositions of place and imperatives.</p> <p><strong>Lengua meta:</strong> <em>Excuse me, where is the…? · It\'s next to / opposite / between… · Go straight. Turn left / right. · It\'s on … Street.</em> Vocabulario: <em>park, church, bus station, hospital, market, bank, drugstore, square</em>.</p> <table> <tr><th>Etapa</th><th>Tiempo</th><th>Docente</th><th>Estudiantes</th><th>Interacción</th></tr> <tr><td>Warm-up</td><td>5 min</td><td>«Look at the map. What places can you see?» (mapa simple del centro dibujado en el tablero)</td><td>Nombran lugares que conocen; el docente escribe en inglés.</td><td>T-Ss</td></tr> <tr><td>Pre-task</td><td>12 min</td><td>«Listen. Where is the market?» Lee dos veces un diálogo de 6 líneas.</td><td>Siguen la ruta con el dedo en su mapa y marcan el destino.</td><td>T-Ss, individual</td></tr> <tr><td>Task</td><td>18 min</td><td>«Student A, ask. Student B, answer. Then change.»</td><td>Con tarjetas A/B (cada uno tiene 4 lugares que el otro no) completan su mapa preguntando.</td><td>S-S</td></tr> <tr><td>Report</td><td>8 min</td><td>«Tell the class one route.»</td><td>Tres parejas leen una ruta; el grupo la sigue en el tablero.</td><td>Ss-Ss</td></tr> <tr><td>Language focus</td><td>8 min</td><td>Recoge frases de la tarea y contrasta <em>in front of</em> / <em>opposite</em>.</td><td>Corrigen 4 frases con error real tomado de la tarea.</td><td>T-Ss</td></tr> <tr><td>Cierre</td><td>4 min</td><td>«Show me with your hands: left, right, straight.»</td><td>Exit ticket oral con gestos.</td><td>T-Ss</td></tr> </table> <p><strong>Evidencia y criterio de logro:</strong> en la tarea, cada pareja completa al menos 3 de 4 lugares del mapa preguntando en inglés; el docente registra en lista de cotejo «pregunta / da indicaciones / usa preposición correcta».</p> <p><strong>Apoyo (PIAR):</strong> tarjeta con 3 frases modelo y flechas dibujadas; el estudiante puede responder señalando y diciendo solo <em>left / right / straight</em>. <strong>Reto:</strong> describir una ruta a un lugar de su elección sin mapa.</p> <p><strong>Autoverificación:</strong> a) sí, la tarea A/B obliga a pedir y dar información de lugares; b) 5+12+18+8+8+4 = 55 min; c) se cambió <em>pharmacy</em> por <em>drugstore</em>, que es la palabra del material del grupo (ambas son correctas); d) solo requiere tablero y fotocopia en media hoja.</p>',
            ],
            'revisar' => [
                'Que el DBA pegado sea el de su grado y versión institucional; la IA no debe haberlo reescrito.',
                'Que los minutos sumen la duración real y que la tarea ocupe al menos un tercio de la clase.',
                'Que las preposiciones y la gramática del ejemplo sean correctas (opposite vs. in front of es un error frecuente de la IA).',
                'Que el mapa o los lugares correspondan a su municipio; corrija nombres de calles y barrios.',
                'Que el ajuste para estudiantes con PIAR coincida con lo acordado en el PIAR real.',
            ],
        ],
        [
            'id' => 'ING-02',
            'categoria' => 'planeacion',
            'titulo' => 'Unidad por proyecto con un eje del Currículo Sugerido',
            'grados' => '8.° a 11.°',
            'tiempo_ahorrado' => '≈ 3 h',
            'cuando' => 'Al inicio de un periodo, cuando quiere una unidad de 4 a 6 semanas que termine en un producto público (campaña, programa de radio, guía turística) y no en una prueba escrita.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel objetivo realista.',
                '[DBA]' => 'Uno o dos DBA literales que la unidad desarrollará.',
                '[EJE]' => 'Eje del Currículo Sugerido: democracia y paz, salud, sostenibilidad o globalización.',
                '[PROBLEMA_LOCAL]' => 'Situación real del colegio o municipio (basuras en la quebrada, uso del celular, turismo).',
                '[SEMANAS]' => 'Número de semanas y horas semanales de inglés.',
                '[PRODUCTO]' => 'Producto final deseado o «propónmelo tú».',
                '[RECURSOS]' => 'Recursos reales (emisora escolar, sala de sistemas un día por semana, etc.).',
            ],
            'prompt' => 'Actúa como diseñador curricular de inglés para colegios oficiales colombianos, experto en aprendizaje basado en proyectos (ABP), en el Currículo Sugerido de Inglés del MEN y en el MCER.

CONTEXTO
- Grado [GRADO], nivel MCER objetivo [NIVEL_MCER].
- DBA (texto literal): "[DBA]"
- Eje: [EJE]. Problema o situación local: [PROBLEMA_LOCAL].
- Duración: [SEMANAS]. Recursos: [RECURSOS].
- Producto final: [PRODUCTO].

TAREA
Diseña una unidad de ABP con:
1. Pregunta orientadora en inglés, auténtica y abierta, ligada al problema local.
2. Producto final público con audiencia real (quién lo verá o escuchará) y criterios de calidad.
3. Cronograma semana a semana con: hito del proyecto, función comunicativa, lengua meta (léxico y una estructura), una actividad de input (lectura o escucha), una de output y la evidencia que recojo.
4. Andamiajes de lengua: banco de frases (sentence starters) para cada etapa del proyecto.
5. Roles de equipo con responsabilidades en inglés sencillo.
6. Plan de evaluación: porcentajes (proceso, producto, autoevaluación y coevaluación) coherentes con el Decreto 1290, y los criterios que irán en la rúbrica.
7. Conexión con otra área del currículo (ciencias naturales, sociales o tecnología).

FORMATO
Encabezado con pregunta orientadora y producto; tabla semanal (Semana | Hito | Función comunicativa | Lengua meta | Input | Output | Evidencia); luego los puntos 4 a 7 en viñetas.

RESTRICCIONES
- Lengua meta dentro de [NIVEL_MCER]; marca con (*) cualquier palabra por encima del nivel.
- Todas las actividades deben poder hacerse sin internet en casa.
- El producto debe ser realizable en el colegio con materiales de bajo costo.
- No inventes datos sobre el municipio: donde necesites un dato local escribe [DATO LOCAL: …] para que yo lo complete.

AUTOVERIFICACIÓN
Antes de entregar, revisa: ¿cada semana deja una evidencia evaluable?, ¿la lengua meta progresa de una semana a otra?, ¿el producto realmente responde la pregunta orientadora?, ¿hay algún dato inventado? Reporta en una tabla de 4 filas (Criterio | Cumple | Ajuste hecho).',
            'seguimientos' => [
                'Escribe el texto modelo del producto final (lo que haría un estudiante con desempeño Superior) para mostrarlo como ejemplo, dentro del nivel [NIVEL_MCER].',
                'Convierte los criterios de evaluación en una rúbrica con niveles Superior, Alto, Básico y Bajo, con descriptores observables.',
                'Diseña la clase de lanzamiento del proyecto (55 minutos) con un gancho que involucre el problema local.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.° · [NIVEL_MCER] A2+ hacia B1 · [EJE] Sostenibilidad · [PROBLEMA_LOCAL] el caño detrás del colegio en Montería se llena de plásticos después del recreo · [SEMANAS] 5 semanas, 3 horas semanales · [PRODUCTO] campaña bilingüe para la emisora escolar y carteleras · [RECURSOS] emisora escolar, celulares para grabar, sala de sistemas los jueves.',
                'resultado_html' => '<p><strong>Driving question:</strong> <em>How can we reduce the plastic that ends up in the caño behind our school?</em></p> <p><strong>Producto:</strong> campaña «Plastic-Free Break» con un spot de radio de 60 segundos (en inglés con resumen en español) y tres carteles bilingües para la cafetería. Audiencia: toda la sede, en la franja de la emisora del recreo.</p> <table> <tr><th>Semana</th><th>Hito</th><th>Función</th><th>Lengua meta</th><th>Evidencia</th></tr> <tr><td>1</td><td>Diagnóstico: contamos residuos de un recreo</td><td>Describir cantidades</td><td><em>How many / How much; there are about…; plastic bottles, wrappers, straws</em></td><td>Tabla de conteo con 5 oraciones</td></tr> <tr><td>2</td><td>Investigamos el impacto en el caño</td><td>Explicar causas y consecuencias</td><td><em>because, so, if + present simple</em> (<em>If we throw plastic, the water gets dirty.</em>)</td><td>Infografía con 4 oraciones causa-efecto</td></tr> <tr><td>3</td><td>Proponemos soluciones</td><td>Sugerir y persuadir</td><td><em>We should…, Let\'s…, Why don\'t we…?</em></td><td>Lista priorizada con votación</td></tr> <tr><td>4</td><td>Escribimos y ensayamos el spot</td><td>Persuadir a una audiencia</td><td>Imperativos, <em>you can</em>, cifras</td><td>Guion revisado con códigos de error</td></tr> <tr><td>5</td><td>Emisión y carteles</td><td>Presentar en público</td><td>Pronunciación y entonación</td><td>Grabación final y autoevaluación</td></tr> </table> <p><strong>Sentence starters (semana 3):</strong> <em>We think the best solution is… because… · One problem with this idea is… · Why don\'t we…?</em></p> <p><strong>Evaluación:</strong> proceso semanal 40 %, producto 35 %, autoevaluación 10 %, coevaluación 15 % (ajuste a los porcentajes de su SIEE).</p> <p><strong>Conexión:</strong> Ciencias Naturales (ecosistemas acuáticos del Sinú) y Tecnología (grabación y edición de audio).</p> <p><em>Nota del editor:</em> la IA había propuesto «a survey on Instagram»; se cambió por conteo físico en el recreo porque el proyecto no puede depender de redes sociales ni de que los estudiantes tengan datos móviles.</p>',
            ],
            'revisar' => [
                'Que no haya datos locales inventados (nombres del caño, cifras de contaminación): complételos usted.',
                'Que la progresión de lengua sea real y no repita la misma estructura todas las semanas.',
                'Que el producto tenga una audiencia real y una fecha de presentación posible en el calendario escolar.',
                'Que los porcentajes de evaluación coincidan con su SIEE.',
                'Que las actividades no dependan de redes sociales, datos móviles ni plataformas que piden registro de menores.',
            ],
        ],
        [
            'id' => 'ING-03',
            'categoria' => 'planeacion',
            'titulo' => 'Secuencia de rutinas, TPR y chants para los más pequeños',
            'grados' => 'Transición a 3.°',
            'tiempo_ahorrado' => '≈ 40 min',
            'cuando' => 'Cuando debe enseñar inglés en primaria sin ser licenciado en idiomas, o necesita una semana de clases cortas (20 a 40 minutos) basadas en movimiento, canto y repetición.',
            'variables' => [
                '[GRADO]' => 'Transición, 1.°, 2.° o 3.°.',
                '[TEMA]' => 'Tema concreto (animales de la finca, frutas de la plaza, partes del cuerpo, colores).',
                '[N_SESIONES]' => 'Número de sesiones y minutos por sesión.',
                '[NIVEL_DOCENTE]' => 'Su nivel de inglés y comodidad para pronunciar (sea honesto: la receta se adapta).',
                '[RECURSOS]' => 'Recursos (flashcards dibujadas, parlante, juguetes, patio).',
            ],
            'prompt' => 'Actúa como especialista en enseñanza de inglés a niños pequeños (young learners) en Colombia, experto en Respuesta Física Total (TPR), rutinas de aula y aprendizaje a través del juego, y conocedor del nivel A1 inicial de la Guía 22.

CONTEXTO
- Grado: [GRADO]. Tema: [TEMA]. Sesiones: [N_SESIONES].
- Nivel de inglés del docente: [NIVEL_DOCENTE].
- Recursos: [RECURSOS].

TAREA
1. Selecciona máximo 6 palabras y 2 expresiones del tema, concretas y dibujables, y explica por qué esas.
2. Escribe una rutina fija de inicio y de cierre (saludo, clima, canción de despedida) que se repita en todas las sesiones.
3. Escribe un chant ORIGINAL de 8 a 12 versos con ritmo marcado, rima sencilla, repetición y una acción física por verso. No uses letras de canciones con derechos de autor.
4. Planea cada sesión con: rutina de inicio, presentación con TPR, juego, chant, cierre. Indica minutos y las frases exactas que dice el docente.
5. Incluye una guía de pronunciación para el docente: cada palabra con una aproximación en español entre corchetes y el error típico a evitar.
6. Propón una lista de cotejo de observación con 3 indicadores (comprende, responde con el cuerpo, produce la palabra).

RESTRICCIONES
- Nada de lectura ni escritura en inglés para Transición y 1.°; en 2.° y 3.° solo rotular y copiar palabras.
- Frases del docente de máximo 5 palabras, siempre con gesto.
- Vocabulario del entorno colombiano (finca, plaza de mercado, río), no de otros países.
- Sin pantallas obligatorias.

AUTOVERIFICACIÓN
Revisa que cada sesión dure exactamente lo indicado, que el chant sea original y no reproduzca canciones conocidas, que las aproximaciones de pronunciación no enseñen errores (por ejemplo, la «s» inicial con «e» de apoyo), y repórtalo en 3 líneas.',
            'seguimientos' => [
                'Convierte el chant en una versión con espacios para que los niños digan solo la palabra del animal mientras el docente canta el resto.',
                'Dame 5 juegos de 5 minutos para el patio con este vocabulario, sin materiales.',
                'Escribe una nota corta en español para las familias explicando el chant y cómo practicarlo en casa en 3 minutos.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 1.° · [TEMA] animales de la finca · [N_SESIONES] 4 sesiones de 30 minutos · [NIVEL_DOCENTE] docente de primaria con inglés básico, insegura con la pronunciación · [RECURSOS] flashcards dibujadas, parlante, patio.',
                'resultado_html' => '<p><strong>Palabras:</strong> <em>cow, horse, pig, hen, dog, duck</em> + <em>What is it? · It\'s a…</em> (animales de finca colombiana, fáciles de imitar con sonido y gesto).</p> <p><strong>Chant original «On the farm»</strong> (acción entre paréntesis):</p> <p><em>On the farm, on the farm, (brazos abiertos)<br> I can see a cow. Moo, moo! (cuernos con los dedos)<br> On the farm, on the farm,<br> I can see a horse. Neigh, neigh! (galopan en el puesto)<br> On the farm, on the farm,<br> I can see a hen. Cluck, cluck! (aletean)<br> Cows and horses, hens and me, (se señalan)<br> On the farm, happy, happy! (aplauden)</em></p> <p><strong>Sesión 1 (30 min):</strong> rutina «Hello, children! How are you today?» (3) · presentación TPR con flashcards y sonidos (8) · juego «Show me the cow!» (7) · chant con gestos, dos veces (7) · cierre «Goodbye song» (5).</p> <p><strong>Pronunciación para el docente:</strong> <em>cow</em> [cáu], no [có]; <em>horse</em> [jors], h suave aspirada; <em>hen</em> [jen]; <em>duck</em> [dak], vocal corta. Evite decir «e-snake» si después usa palabras con s inicial.</p> <p><strong>Lista de cotejo:</strong> señala el animal al oír la palabra · hace el gesto/sonido del chant · dice al menos 3 animales sin modelo.</p>',
            ],
            'revisar' => [
                'Que el chant sea original (pida a la IA que lo confirme y compárelo usted con canciones conocidas).',
                'Que las aproximaciones de pronunciación sean razonables; si duda, escuche la palabra en un diccionario en línea con audio.',
                'Que los tiempos sean realistas para niños de esa edad (actividades de 5 a 8 minutos).',
                'Que no aparezcan actividades de lectura o escritura para Transición y 1.°.',
            ],
        ],
        [
            'id' => 'ING-04',
            'categoria' => 'planeacion',
            'titulo' => 'Malla de periodo: DBA, evidencias y evaluación distribuidos por semanas',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Al iniciar el año o un periodo, cuando coordinación pide la planeación del periodo y quiere una distribución realista de DBA, temas, evidencias y momentos de evaluación.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[PERIODO]' => 'Número de periodo y semanas efectivas (descuente semanas institucionales, izadas, simulacros).',
                '[HORAS]' => 'Horas semanales de inglés.',
                '[DBA_LISTA]' => 'Los DBA del periodo, con su texto literal.',
                '[LIBRO]' => 'Texto guía si existe (Way to Go!, English, please!, otro) y unidades asignadas.',
                '[SIEE]' => 'Porcentajes de evaluación de su institución y número mínimo de notas.',
                '[NIVEL_REAL]' => 'Nivel diagnóstico del grupo.',
            ],
            'prompt' => 'Actúa como coordinador académico de inglés con experiencia en colegios oficiales colombianos, experto en Guía 22, DBA de Inglés, MCER y Decreto 1290.

CONTEXTO
- Grado [GRADO], periodo [PERIODO], [HORAS] horas semanales.
- Nivel diagnóstico real del grupo: [NIVEL_REAL].
- DBA del periodo (texto literal): [DBA_LISTA]
- Texto guía y unidades: [LIBRO]
- Sistema de evaluación institucional: [SIEE]

TAREA
1. Distribuye los DBA en las semanas efectivas, con temas, funciones comunicativas y lengua meta por semana.
2. Por cada semana, indica la habilidad principal (escucha, lectura, escritura, monólogo, conversación) de modo que las cinco aparezcan de forma equilibrada en el periodo.
3. Ubica las evidencias evaluativas (mínimo las exigidas por el SIEE) con su tipo (tarea de desempeño, prueba, proyecto, autoevaluación) y su porcentaje.
4. Marca una semana de refuerzo y recuperación antes del cierre del periodo.
5. Señala qué lecciones del texto guía se usan y cuáles se omiten o adaptan, con razón.

FORMATO
Tabla: Semana | DBA (abreviado, sin renumerar) | Tema | Función comunicativa | Lengua meta | Habilidad principal | Evidencia y % | Texto guía. Debajo, un resumen de 5 líneas con la lógica de la distribución.

RESTRICCIONES
- No inventes números ni redacciones de DBA: usa solo lo que pegué.
- La lengua meta debe partir del nivel real [NIVEL_REAL], aunque el grado espere más; explica cómo cierras la brecha.
- No más de una prueba escrita por cada tres semanas.

AUTOVERIFICACIÓN
Comprueba que los porcentajes suman 100 %, que el número de evidencias cumple el SIEE, que las cinco habilidades aparecen al menos dos veces, y que ninguna semana tiene más contenido del que cabe en [HORAS] horas. Reporta cada comprobación con «Sí/No + ajuste».',
            'seguimientos' => [
                'Ahora genera la ficha de planeación semanal de la semana 3 con las clases detalladas.',
                'Redacta en español los criterios de evaluación del periodo para socializarlos con estudiantes y familias, en lenguaje sencillo.',
                'Propón dos actividades de recuperación diferentes para quienes queden en Bajo en este periodo.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 9.° · [PERIODO] 2.° periodo, 9 semanas efectivas · [HORAS] 3 · [NIVEL_REAL] A2 con mucha dispersión · [LIBRO] English, please! unidades asignadas por el área · [SIEE] cognitivo 40 %, procedimental 40 %, actitudinal 20 %; mínimo 6 notas.',
                'resultado_html' => '<table> <tr><th>Semana</th><th>Tema</th><th>Función</th><th>Lengua meta</th><th>Habilidad</th><th>Evidencia y %</th></tr> <tr><td>1</td><td>Healthy habits in my family</td><td>Describir rutinas y frecuencia</td><td>Present simple + adverbs of frequency</td><td>Lectura</td><td>Diagnóstico formativo (sin nota)</td></tr> <tr><td>2</td><td>Food in Colombian regions</td><td>Comparar</td><td>Comparatives (<em>healthier than</em>)</td><td>Conversación</td><td>Encuesta en parejas · 10 % procedimental</td></tr> <tr><td>3</td><td>What happened last weekend?</td><td>Narrar experiencias pasadas</td><td>Past simple regular/irregular</td><td>Escucha</td><td>Quiz corto · 10 % cognitivo</td></tr> <tr><td>4</td><td>Have you ever…?</td><td>Hablar de experiencias de vida</td><td>Present perfect + <em>ever / never</em></td><td>Monólogo</td><td>Presentación 1 min · 15 % procedimental</td></tr> <tr><td>…</td><td>…</td><td>…</td><td>…</td><td>…</td><td>…</td></tr> <tr><td>8</td><td>Refuerzo y recuperación</td><td colspan="4">Estaciones por habilidad según resultados</td></tr> </table> <p><strong>Lógica:</strong> como el grupo está en A2, el pasado simple (semana 3) se consolida antes del present perfect (semana 4), aunque el libro los presente en otro orden; las cinco habilidades aparecen al menos dos veces; los porcentajes suman 100 % con 7 evidencias.</p>',
            ],
            'revisar' => [
                'Que los DBA aparezcan con la redacción oficial y sin números inventados.',
                'Que las semanas cuadren con el calendario real (festivos, semana de desarrollo institucional, simulacros).',
                'Que los porcentajes coincidan con el SIEE vigente de su colegio.',
                'Que la secuencia gramatical sea lógica (lo que se necesita antes, va antes).',
            ],
        ],
        [
            'id' => 'ING-05',
            'categoria' => 'recursos',
            'titulo' => 'Una lectura, tres niveles MCER (A1, A2, B1)',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 60 min',
            'cuando' => 'Cuando tiene un grupo heterogéneo y quiere que todos lean sobre el mismo tema colombiano, cada uno en su nivel, para luego conversar juntos sobre el contenido.',
            'variables' => [
                '[TEMA]' => 'Tema colombiano (un lugar, una fiesta, un personaje, un problema ambiental).',
                '[DATOS]' => 'Datos verificados que usted le entrega (de una fuente confiable) para que la IA no invente.',
                '[GRADO]' => 'Grado.',
                '[PROPOSITO]' => 'Para qué es la lectura (introducir un tema, practicar pasado, preparar un debate).',
            ],
            'prompt' => 'Actúa como autor de lecturas graduadas (graded readers) para adolescentes colombianos, experto en los descriptores de lectura del MCER y en control léxico y gramatical por nivel.

CONTEXTO
- Grado [GRADO]. Tema: [TEMA]. Propósito: [PROPOSITO].
- Datos que debes usar (son los ÚNICOS hechos permitidos; no agregues otros): [DATOS]

TAREA
Escribe el MISMO contenido en tres versiones:
- Versión A1: 80 a 110 palabras, oraciones simples de máximo 10 palabras, presente simple y there is/are, vocabulario de alta frecuencia.
- Versión A2: 140 a 180 palabras, conectores and/but/because/so, pasado simple permitido, algunas oraciones compuestas.
- Versión B1: 220 a 280 palabras, variedad de tiempos verbales, cláusulas relativas, opinión del autor y un párrafo de causa-efecto.
Para cada versión entrega:
1. Título y texto.
2. Glosario de 5 a 8 palabras clave con definición sencilla en inglés y traducción al español.
3. Cuatro preguntas: 2 literales, 1 inferencial, 1 de opinión personal.
4. Clave de respuestas.
Al final, una actividad común para que estudiantes de los tres niveles conversen juntos (por ejemplo, un vacío de información).

RESTRICCIONES
- Usa solo los datos entregados. Si necesitas un dato que no está, escribe [POR CONFIRMAR: …].
- Las tres versiones deben contener la misma información central para que la conversación final sea posible.
- Ortografía en una sola variante (indica cuál: americana o británica) y mantenla.
- Sin estereotipos sobre Colombia.

AUTOVERIFICACIÓN
Cuenta las palabras de cada versión y repórtalas. Lista cualquier palabra de la versión A1 que no esté en un vocabulario A1 típico y reemplázala. Confirma que cada pregunta tiene una única respuesta correcta según el texto.',
            'seguimientos' => [
                'Convierte la versión A1 en un texto con imágenes sugeridas para cada oración (describe qué dibujar).',
                'Escribe una versión audio-script de la versión A2 para leer en voz alta, con pausas marcadas (/) y palabras para enfatizar en negrilla.',
                'Diseña la actividad de cierre como una tarea de vacío de información con tarjetas A, B y C (una por nivel).',
            ],
            'ejemplo' => [
                'contexto' => '[TEMA] Caño Cristales · [GRADO] 8.° · [PROPOSITO] introducir el eje Sostenibilidad · [DATOS] está en la Serranía de La Macarena (Meta); lo llaman «el río de los cinco colores»; el color rojo proviene de una planta acuática, <em>Macarenia clavigera</em>; la temporada de visitas suele ir de mitad de año a finales del año, cuando el nivel del agua lo permite; los visitantes no pueden usar bloqueador ni repelente al bañarse, para proteger la planta.',
                'resultado_html' => '<p><strong>Versión A1 — «The River of Five Colors»</strong> (94 palabras)<br> Caño Cristales is a river in Colombia. It is in the Serranía de La Macarena, in Meta. People call it "the river of five colors". The water is red, yellow, green, blue and black. Why is it red? There is a special plant in the water. Its name is <em>Macarenia clavigera</em>. Many tourists visit the river in the second half of the year. The colors are beautiful then. Visitors cannot use sunscreen in the water. Why not? Sunscreen is bad for the plant. We must protect this river. It is a treasure for Colombia.</p> <p><strong>Versión B1 (fragmento)</strong>: <em>…The red color, which surprises most visitors, comes from an aquatic plant called Macarenia clavigera. Because the plant is so sensitive, visitors are not allowed to use sunscreen or insect repellent when they swim. In my opinion, this rule shows that tourism can be good for a region only if it is carefully controlled…</em></p> <p><strong>Preguntas A1:</strong> 1. Where is Caño Cristales? (literal) 2. Why is the water red? (literal) 3. Why do you think tourists visit in the second half of the year? (inferencial: <em>because the colors are beautiful then</em>) 4. Would you like to visit Caño Cristales? Why? (opinión).</p> <p><em>Nota del editor:</em> la primera respuesta de la IA decía que el río «has seven colors» y que la temporada era «from January to March»; ambos datos se eliminaron porque no estaban en los datos entregados. Por eso esta receta exige pegar los datos.</p>',
            ],
            'revisar' => [
                'Que todos los datos factuales estén en lo que usted pegó; busque [POR CONFIRMAR] y complételos con una fuente oficial.',
                'Que el conteo de palabras sea real (la IA suele equivocarse: cuéntelas con el procesador de texto).',
                'Que la versión A1 no tenga tiempos compuestos ni cláusulas relativas.',
                'Que la clave de respuestas coincida con el texto, pregunta por pregunta.',
            ],
        ],
        [
            'id' => 'ING-06',
            'categoria' => 'recursos',
            'titulo' => 'Vocabulario en contexto con colocaciones y pronunciación para hispanohablantes',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 35 min',
            'cuando' => 'Cuando va a introducir un campo léxico (la finca cafetera, la plaza de mercado, el transporte) y quiere más que una lista traducida: colocaciones, ejemplos reales, falsos amigos y pronunciación.',
            'variables' => [
                '[CAMPO_LEXICO]' => 'Tema del vocabulario.',
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[N_PALABRAS]' => 'Cuántas palabras (8 a 15 es lo recomendable por clase).',
                '[CONTEXTO_LOCAL]' => 'Lugar o situación concreta del entorno de sus estudiantes.',
            ],
            'prompt' => 'Actúa como lexicógrafo y docente de inglés para hispanohablantes colombianos. Conoces los errores de pronunciación típicos del español de Colombia y los falsos amigos más comunes.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER].
- Campo léxico: [CAMPO_LEXICO], situado en [CONTEXTO_LOCAL].

TAREA
1. Selecciona [N_PALABRAS] palabras o expresiones útiles para hablar de este tema en este nivel. Prioriza frecuencia y utilidad comunicativa sobre exotismo.
2. Para cada una: categoría gramatical, definición sencilla en inglés, traducción, 1 o 2 colocaciones frecuentes (verbo + sustantivo, adjetivo + sustantivo) y una oración ejemplo situada en [CONTEXTO_LOCAL].
3. Pronunciación: transcripción AFI (IPA) y una alerta concreta para hispanohablantes cuando aplique (vocal corta/larga, -ed final, s inicial, sílaba tónica, letras mudas).
4. Señala falsos amigos o calcos que los estudiantes probablemente cometerán con estas palabras.
5. Propón 3 actividades de práctica de distinto tipo: reconocimiento, uso controlado y uso libre.
6. Si una palabra colombiana no tiene equivalente directo (tinto, arepa, panela, chiva), NO la traduzcas forzadamente: propón cómo explicarla en inglés.

FORMATO
Tabla: Word/expression | Type | Meaning (simple English) | Spanish | Collocations | Example | IPA | Alerta. Luego falsos amigos y actividades.

RESTRICCIONES
- Nivel [NIVEL_MCER]: si una palabra está por encima, márcala con (*).
- Ejemplos naturales, como los diría un hablante competente, no traducciones palabra por palabra.
- Variante del inglés: americana, salvo que indique otra; señala si una palabra cambia en británico.

AUTOVERIFICACIÓN
Revisa cada transcripción IPA y cada colocación: si no estás seguro de alguna, márcala con [REVISAR] en lugar de inventarla. Confirma que ninguna traducción de un producto colombiano es engañosa (por ejemplo, «tinto» no es «red wine» en este contexto).',
            'seguimientos' => [
                'Crea un crucigrama o sopa de letras con definiciones en inglés (no traducciones) para estas palabras.',
                'Escribe un texto corto de 100 palabras que use al menos 10 de estas palabras, para leer en clase.',
                'Dame 10 pares mínimos (minimal pairs) relacionados con las alertas de pronunciación de esta lista.',
            ],
            'ejemplo' => [
                'contexto' => '[CAMPO_LEXICO] el proceso del café · [GRADO] 8.° · [NIVEL_MCER] A2/B1 · [N_PALABRAS] 10 · [CONTEXTO_LOCAL] una finca cafetera en Salento (Quindío).',
                'resultado_html' => '<table> <tr><th>Word</th><th>Meaning</th><th>Collocations</th><th>Example</th><th>IPA y alerta</th></tr> <tr><td><em>harvest</em> (n/v)</td><td>the time when you collect the crop; to collect it</td><td><em>coffee harvest, harvest season</em></td><td><em>The main harvest in Salento is very busy.</em></td><td>/ˈhɑːrvɪst/ · acento en la 1.ª sílaba</td></tr> <tr><td><em>pick</em> (v)</td><td>to take fruit from a plant with your hand</td><td><em>pick coffee cherries, pick by hand</em></td><td><em>Workers pick only the red cherries.</em></td><td>/pɪk/ · vocal corta, no [pik] larga</td></tr> <tr><td><em>ripe</em> (adj)</td><td>ready to eat or to pick</td><td><em>ripe cherries, fully ripe</em></td><td><em>Green cherries are not ripe.</em></td><td>/raɪp/ · no confundir con <em>rip</em></td></tr> <tr><td><em>roast</em> (v)</td><td>to cook beans with dry heat</td><td><em>roast the beans, dark roast</em></td><td><em>They roast the beans on the farm.</em></td><td>/roʊst/ · s + t final: no agregar «e»</td></tr> <tr><td><em>dried</em> (adj)</td><td>with no water</td><td><em>sun-dried beans</em></td><td><em>The beans are sun-dried on the roof.</em></td><td>/draɪd/ · -ed suena /d/, no «dra-ied»</td></tr> </table> <p><strong>Palabras sin equivalente:</strong> <em>tinto</em> → <em>a small cup of black coffee, very common in Colombia</em> (no «red wine»). <em>Beneficiadero</em> → <em>a place on the farm where coffee is washed and processed</em>.</p> <p><strong>Falsos amigos:</strong> <em>cultivate</em> existe, pero en este contexto es más natural <em>grow coffee</em>; «recolectar» no es <em>recollect</em> (que significa recordar).</p>',
            ],
            'revisar' => [
                'Las transcripciones IPA: verifique las dudosas en un diccionario de aprendices (Cambridge, Oxford Learner\'s, Longman).',
                'Que las colocaciones sean reales (la IA a veces inventa combinaciones poco naturales).',
                'Que la explicación de productos colombianos sea respetuosa y precisa.',
                'Que la cantidad de palabras sea manejable en una clase (no más de 12 a 15).',
            ],
        ],
        [
            'id' => 'ING-07',
            'categoria' => 'recursos',
            'titulo' => 'Guion de listening grabable con tareas antes, durante y después',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 50 min',
            'cuando' => 'Cuando el libro no trae audio, no tiene internet en el aula o quiere un listening con acentos y situaciones colombianas que pueda leer usted mismo o grabar con una voz sintética.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[SITUACION]' => 'Situación comunicativa (anuncio en la terminal, conversación en la tienda, entrevista en la emisora escolar).',
                '[LENGUA_META]' => 'Vocabulario y estructura que quiere reciclar.',
                '[DURACION_AUDIO]' => 'Duración aproximada (60 a 90 s para A1; hasta 3 min para B1).',
                '[HABLANTES]' => 'Número de voces y quién las hará (usted, estudiantes, voz sintética).',
            ],
            'prompt' => 'Actúa como diseñador de materiales de escucha para adolescentes colombianos, conocedor de los descriptores de comprensión auditiva del MCER.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER].
- Situación: [SITUACION]. Lengua meta: [LENGUA_META].
- Duración del audio: [DURACION_AUDIO]. Voces: [HABLANTES].

TAREA
1. Escribe un guion natural (con muletillas leves, autocorrecciones y turnos realistas) que se lea en [DURACION_AUDIO] a una velocidad apropiada para [NIVEL_MCER]. Indica el número de palabras.
2. Marca en el guion las pausas (/) y las palabras clave que deben enfatizarse.
3. Diseña tres momentos:
   - Pre-listening: activar conocimiento previo y predecir (2 actividades).
   - While-listening: primera escucha para la idea general (1 tarea) y segunda escucha para detalles (5 ítems).
   - Post-listening: una tarea de habla o escritura que use la información.
4. Clave de respuestas con la línea del guion donde está cada respuesta.
5. Instrucciones para grabarlo: velocidad, cómo distinguir las voces si las hace una sola persona y, si se usa voz sintética, qué ajustes hacer.

RESTRICCIONES
- Nombres, lugares y precios colombianos realistas (precios en pesos coherentes con el año actual; si no estás seguro, marca [CONFIRMAR PRECIO]).
- Los ítems de detalle no se pueden responder sin escuchar (no deben adivinarse por sentido común).
- Las preguntas siguen el orden del audio.

AUTOVERIFICACIÓN
Estima la duración (palabras ÷ 120 por minuto para A1-A2, ÷ 140 para B1) y ajústala. Comprueba que cada ítem tenga una única respuesta en el guion. Repórtalo.',
            'seguimientos' => [
                'Escribe una versión más difícil del mismo guion para quienes terminaron la tarea con todo correcto.',
                'Convierte el guion en un dictado parcial (gap-fill) de 10 espacios centrado en la lengua meta.',
                'Propón un plan B para estudiantes con hipoacusia: qué entregar y cómo evaluar la misma comprensión.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 6.° · [NIVEL_MCER] A1 · [SITUACION] anuncios y conversación en la Terminal de Transportes de Bogotá · [LENGUA_META] números, horas, destinos, <em>What time does the bus to… leave?</em> · [DURACION_AUDIO] 60 segundos · [HABLANTES] docente + un estudiante.',
                'resultado_html' => '<p><strong>Guion (68 palabras sin contar los nombres de los hablantes; a ritmo A1, con las pausas marcadas y los cambios de voz, dura entre 50 y 60 segundos):</strong></p> <p><em>ANNOUNCER: Good morning, passengers. / The bus to <strong>Tunja</strong> leaves at <strong>nine fifteen</strong>, / from gate <strong>number six</strong>.<br> GIRL: Excuse me. / What time does the bus to <strong>Villavicencio</strong> leave?<br> CLERK: Villavicencio… let me see. / At <strong>ten thirty</strong>.<br> GIRL: Ten thirty. OK. / And how much is the ticket?<br> CLERK: It\'s <strong>forty-five thousand</strong> pesos.<br> GIRL: And which gate, please?<br> CLERK: Gate <strong>twelve</strong>. / Twelve, not twenty.<br> GIRL: Thank you!<br> ANNOUNCER: Attention, please. / The bus to <strong>Girardot</strong> is now leaving / from gate <strong>three</strong>.</em></p> <p><strong>While-listening (detalles):</strong> 1. Bus to Tunja: time ____ (9:15, línea 1) 2. Bus to Villavicencio: time ____ (10:30, línea 3) 3. Ticket price ____ (45.000 pesos, línea 5; es un valor de ejemplo: ajústelo al precio real del trayecto) 4. Gate ____ (12, línea 7) 5. The bus to Girardot leaves from gate ____ (3, línea 9).</p> <p><strong>Grabación:</strong> lea las pausas con 1 segundo; para el anunciante use un vaso o las manos alrededor de la boca para simular parlante. <em>Nota del editor:</em> se agregó «Twelve, not twenty» porque <em>twelve/twenty</em> es una confusión real de A1 que vale la pena entrenar.</p>',
            ],
            'revisar' => [
                'Que el precio y los destinos sean verosímiles hoy (actualice el precio del pasaje).',
                'Que la duración leída en voz alta sea la indicada: léalo y cronométrelo.',
                'Que las respuestas no se adivinen sin escuchar.',
                'Que los nombres de lugares estén bien escritos y se pronuncien en español, como haría un colombiano.',
            ],
        ],
        [
            'id' => 'ING-08',
            'categoria' => 'recursos',
            'titulo' => 'Juegos de roles con tarjetas A/B para situaciones cotidianas colombianas',
            'grados' => '4.° a 9.°',
            'tiempo_ahorrado' => '≈ 30 min',
            'cuando' => 'Cuando quiere que todos hablen al mismo tiempo en parejas con una necesidad real de comunicar (vacío de información), en vez de leer diálogos en coro.',
            'variables' => [
                '[SITUACION]' => 'Situación (comprar en la tienda de barrio, pedir en un restaurante, preguntar por el bus, reportar un objeto perdido).',
                '[FUNCION]' => 'Función comunicativa (pedir, ofrecer, preguntar precios, quejarse cortésmente).',
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
            ],
            'prompt' => 'Actúa como docente experto en enseñanza comunicativa del inglés y en tareas de vacío de información (information gap) para grupos grandes colombianos.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER].
- Situación: [SITUACION]. Función comunicativa: [FUNCION].

TAREA
1. Escribe un diálogo modelo de 8 a 10 líneas que muestre la función.
2. Extrae un banco de frases útiles (para el estudiante A y para el estudiante B).
3. Crea 3 pares de tarjetas de rol A/B de dificultad creciente. Cada tarjeta tiene: quién eres, qué necesitas lograr, información que tienes y que el otro no, y una complicación en la tercera (algo se agotó, el precio cambió, hay un malentendido).
4. Escribe la tarea de cierre: cada pareja reporta qué logró (report back).
5. Lista de cotejo para que el docente observe mientras circula (4 indicadores).

FORMATO
Diálogo modelo, banco de frases en dos columnas, tarjetas listas para recortar (cada una en un recuadro con línea punteada), cierre y lista de cotejo.

RESTRICCIONES
- Nivel [NIVEL_MCER]; productos, precios y nombres colombianos realistas.
- Cada tarjeta se puede leer en menos de 30 segundos.
- La información de A y B debe ser realmente complementaria: ninguno puede completar su tarea sin preguntar.

AUTOVERIFICACIÓN
Para cada par de tarjetas, confirma qué pregunta debe hacer A y qué pregunta debe hacer B para completar la tarea; si alguna tarjeta se puede completar sin hablar, corrígela. Reporta en una tabla corta.',
            'seguimientos' => [
                'Haz una versión de las tarjetas con apoyos en español para estudiantes con PIAR, manteniendo la tarea en inglés.',
                'Escribe 5 errores típicos que cometerán los estudiantes en esta situación y cómo corregirlos sin interrumpir la conversación.',
            ],
            'ejemplo' => [
                'contexto' => '[SITUACION] comprar en la tienda de barrio · [FUNCION] preguntar precios y cantidades · [GRADO] 5.° · [NIVEL_MCER] A1.',
                'resultado_html' => '<p><strong>Diálogo modelo:</strong> <em>A: Good afternoon! Do you have eggs? / B: Yes, I do. / A: How much is one egg? / B: It\'s six hundred pesos. / A: OK. Six eggs, please. / B: Here you are. Anything else? / A: Yes, a bag of milk, please. / B: Sorry, no milk today. / A: No problem. How much is it? / B: Three thousand six hundred, please.</em></p> <p><strong>Tarjeta 3-A (cliente):</strong> You want: 5 bread rolls, 1 panela, 2 bananas. You have 5,000 pesos. Ask the prices. Can you buy everything?</p> <p><strong>Tarjeta 3-B (tendero):</strong> Prices: bread roll 300 · panela 2,500 · banana 400. Complication: you have only 3 bread rolls today.</p> <p><strong>Autoverificación:</strong> A debe preguntar «How much is…?» por tres productos; B debe informar que solo hay 3 panes. A no puede llevar los 5 panes: con 3 panes, la panela y 2 bananos paga 4.200 (3 × 300 + 2.500 + 2 × 400) y le sobran 800 pesos, lo que obliga a negociar y recalcular. Los precios son valores de ejemplo: si los ajusta a los de la tienda de su barrio, recalcule la clave. <em>Nota del editor:</em> se cambió «a bottle of milk» por «a bag of milk», porque en Colombia la leche se compra con frecuencia en bolsa.</p>',
            ],
            'revisar' => [
                'Que la información de A y B sea complementaria (pruébelo usted mismo con un colega o estudiante).',
                'Que los precios y productos correspondan a su región y al año actual.',
                'Que los cálculos de dinero sean correctos (la IA se equivoca en sumas).',
            ],
        ],
        [
            'id' => 'ING-09',
            'categoria' => 'recursos',
            'titulo' => 'Cuento original para storytelling con repetición y participación',
            'grados' => 'Transición a 5.°',
            'tiempo_ahorrado' => '≈ 40 min',
            'cuando' => 'Cuando quiere contar un cuento en inglés (con imágenes dibujadas o títeres) que use el vocabulario de la unidad, tenga patrones repetitivos y permita que los niños participen.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[VOCABULARIO]' => 'Palabras que deben aparecer (6 a 10).',
                '[ESTRUCTURA]' => 'Patrón repetitivo (Is it…? / I can… / There is…).',
                '[VALOR]' => 'Valor o mensaje (cuidado del ambiente, amistad, respeto a la diferencia).',
                '[ESCENARIO]' => 'Escenario colombiano (Amazonas, páramo, Caribe, finca).',
            ],
            'prompt' => 'Actúa como autor de cuentos infantiles en inglés para niños colombianos que aprenden inglés como lengua extranjera (nivel A1 inicial).

CONTEXTO
- Grado [GRADO]. Vocabulario: [VOCABULARIO]. Patrón repetitivo: [ESTRUCTURA].
- Mensaje: [VALOR]. Escenario: [ESCENARIO].

TAREA
1. Escribe un cuento ORIGINAL de 8 a 10 escenas, máximo 2 oraciones cortas por escena, con un patrón que se repita y un final sorpresa o feliz.
2. Para cada escena: el texto, la imagen que el docente debe dibujar o mostrar, y la participación de los niños (repetir, hacer un sonido, señalar, adivinar).
3. Guía de narración: entonación, pausas para predecir, preguntas para antes, durante y después.
4. Una actividad posterior sin lectura (dramatizar, ordenar imágenes, dibujar la escena favorita y nombrar).

RESTRICCIONES
- Personajes y animales de [ESCENARIO]; evita estereotipos.
- Solo presente simple, there is/are, can y el patrón [ESTRUCTURA].
- Sin violencia ni sustos; nada que copie cuentos con derechos de autor.

AUTOVERIFICACIÓN
Comprueba que todas las palabras de [VOCABULARIO] aparezcan al menos dos veces, que el patrón se repita en al menos 5 escenas y que no haya palabras por encima de A1 sin apoyo visual. Repórtalo.',
            'seguimientos' => [
                'Escribe un mini-libro plegable (8 páginas en una hoja) con el cuento, indicando qué va en cada página.',
                'Crea una versión del cuento para títeres con dos personajes y diálogos de una línea.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 2.° · [VOCABULARIO] tree, river, flower, monkey, frog, fish, macaw · [ESTRUCTURA] Is she in the…? No, she isn\'t. · [VALOR] la familia y el cuidado del bosque · [ESCENARIO] Amazonas, cerca de Leticia.',
                'resultado_html' => '<p><strong>«Where is Lola?»</strong></p> <p><strong>Escena 1.</strong> <em>This is Lola. Lola is a little macaw. She is red, yellow and blue.</em> (Imagen: guacamaya pequeña. Los niños repiten los colores señalando la imagen.)</p> <p><strong>Escena 2.</strong> <em>Mama Macaw is sad. "Where is Lola?"</em> (Todos preguntan con las manos abiertas: «Where is Lola?»)</p> <p><strong>Escena 3.</strong> <em>Is she in the tree? No, she isn\'t! It\'s a monkey!</em> (Los niños hacen el sonido del mono.)</p> <p><strong>Escena 4.</strong> <em>Is she in the river? No, she isn\'t! It\'s a fish!</em> (Mueven las manos como pez.)</p> <p>… <strong>Escena 9.</strong> <em>Is she in the big flower? Yes, she is! Hello, Lola!</em> <strong>Escena 10.</strong> <em>Lola, Mama and the forest are happy. Let\'s take care of the forest!</em></p> <p><strong>Antes:</strong> «Look! What animals live in the Amazon?» <strong>Durante:</strong> pausa antes de cada «No, she isn\'t!» para que los niños lo digan. <strong>Después:</strong> ordenar 4 imágenes del cuento en el tablero.</p>',
            ],
            'revisar' => [
                'Que el cuento sea original y no una versión de un libro conocido.',
                'Que la fauna corresponda al ecosistema (no pingüinos en el Amazonas).',
                'Que el patrón repetitivo sea gramaticalmente correcto en todas las escenas.',
            ],
        ],
        [
            'id' => 'ING-10',
            'categoria' => 'recursos',
            'titulo' => 'Explicación gramatical contrastiva con el español y errores típicos de colombianos',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 40 min',
            'cuando' => 'Cuando una estructura no «entra» y necesita una explicación clara, por descubrimiento guiado, que anticipe los errores que vienen del español.',
            'variables' => [
                '[ESTRUCTURA]' => 'Estructura (present perfect vs. past simple, third person -s, comparatives, there is/are, will vs. going to).',
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[ERRORES_OBSERVADOS]' => 'Errores reales que usted ha visto en sus estudiantes (copie 3 a 5 oraciones tal como las escribieron, sin nombres).',
            ],
            'prompt' => 'Actúa como lingüista aplicado y docente de inglés para hispanohablantes colombianos. Explicas gramática de forma inductiva (descubrimiento guiado) y precisa, sin simplificaciones falsas.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER]. Estructura: [ESTRUCTURA].
- Errores reales de mis estudiantes: [ERRORES_OBSERVADOS]

TAREA
1. Para mí (docente): explica la forma, el significado y el uso de [ESTRUCTURA] en 8 a 10 líneas, y compárala con el español de Colombia (incluye diferencias de uso, no solo de forma).
2. Diagnostica los errores que pegué: ¿cuál es la causa probable de cada uno (transferencia del español, sobregeneralización, confusión de forma)?
3. Diseña una secuencia de descubrimiento guiado para los estudiantes: 6 a 8 oraciones ejemplo en contexto colombiano, preguntas que los lleven a deducir la regla, y la regla final en lenguaje sencillo (en español para A1-A2, en inglés sencillo para B1).
4. Práctica en tres pasos: controlada (5 ítems), semicontrolada (5 ítems) y libre (1 tarea comunicativa).
5. Clave de respuestas.

RESTRICCIONES
- No inventes reglas absolutas que no existen (por ejemplo, «some solo en afirmativas» sin matizar, o «nunca uses will después de if»). Si una regla tiene excepciones frecuentes en el nivel, dilas.
- Ejemplos naturales y del entorno de los estudiantes.
- No uses metalenguaje innecesario con estudiantes de A1-A2.

AUTOVERIFICACIÓN
Revisa cada oración ejemplo y cada respuesta de la clave: ¿es gramatical?, ¿es natural?, ¿podría haber más de una respuesta correcta? Si un ítem admite dos respuestas, reescríbelo o acepta ambas en la clave. Reporta los cambios.',
            'seguimientos' => [
                'Dame 10 oraciones con errores típicos de colombianos con esta estructura para una actividad de «encuentra y corrige» con clave.',
                'Convierte la regla en un organizador gráfico (línea de tiempo o tabla) que quepa en un cuarto de hoja.',
            ],
            'ejemplo' => [
                'contexto' => '[ESTRUCTURA] present perfect (experiencias) vs. past simple · [GRADO] 9.° · [NIVEL_MCER] A2+/B1 · [ERRORES_OBSERVADOS] «I have been in Cartagena last year.» · «Did you ever eat ajiaco?» · «I have visit San Andrés.» · «Yesterday I have seen my cousin.»',
                'resultado_html' => '<p><strong>Para el docente:</strong> el <em>present perfect</em> conecta una experiencia pasada con el presente sin decir cuándo (<em>I have been to San Andrés.</em>); el <em>past simple</em> sitúa la acción en un tiempo terminado y específico (<em>I went there in 2023.</em>). En el español de Colombia, a diferencia del de España, casi siempre se usa el pretérito simple («¿Ya comiste?», «Nunca fui a San Andrés»), por lo que los estudiantes no tienen una intuición del contraste y lo mezclan, sobre todo con marcadores de tiempo (<em>yesterday, last year</em>). Matiz real: en inglés americano informal <em>Did you ever…?</em> es aceptable, aunque <em>Have you ever…?</em> es la forma que conviene enseñar para hablar de experiencias de vida.</p> <p><strong>Diagnóstico:</strong> «I have been in Cartagena last year» y «Yesterday I have seen…» → transferencia del «he estado/he visto» peninsular aprendido en materiales, más desconocimiento de que los marcadores de tiempo terminado exigen <em>past simple</em>. «I have visit» → forma incompleta: falta el participio (<em>visited</em>).</p> <p><strong>Descubrimiento guiado:</strong> <em>Camila: Have you ever been to San Andrés? / Andrés: Yes, I have. I went there in December. / Camila: Did you swim in the sea? / Andrés: Yes! And I tried crab soup.</em> Preguntas: ¿Qué pregunta no dice cuándo? ¿Qué oraciones dicen cuándo? ¿Qué tiempo verbal acompaña a <em>in December</em>?</p> <p><strong>Regla (en español):</strong> Para preguntar o contar una experiencia sin decir cuándo: <em>have/has + participio</em>. Cuando dices cuándo (ayer, en 2023, el mes pasado): pasado simple.</p>',
            ],
            'revisar' => [
                'Que la explicación no contenga reglas falsas o absolutas.',
                'Que todas las oraciones de la clave sean correctas y que no haya ítems con dos respuestas posibles sin aclararlo.',
                'Que el contraste con el español sea el del español colombiano (la IA suele tomar como referencia el de España).',
            ],
        ],
        [
            'id' => 'ING-11',
            'categoria' => 'evaluacion',
            'titulo' => 'Ítems con el formato de la prueba de inglés de Saber 11, con justificación de distractores',
            'grados' => '9.° a 11.°',
            'tiempo_ahorrado' => '≈ 90 min',
            'cuando' => 'Cuando prepara simulacros o quiere familiarizar a sus estudiantes con el tipo de tarea de cada parte de la prueba, con ítems propios (no copiados de cuadernillos) y verificados.',
            'variables' => [
                '[PARTE]' => 'Tipo de tarea según la Guía de orientación vigente del ICFES (avisos, léxico/definiciones, conversaciones cortas, texto incompleto gramatical, comprensión literal, comprensión inferencial, texto incompleto léxico-gramatical).',
                '[FORMATO_OFICIAL]' => 'Descripción de esa parte copiada de la guía vigente: instrucción, número de opciones, número de preguntas.',
                '[NIVEL_MCER]' => 'Nivel que desea evaluar con los ítems (A1, A2, B1).',
                '[N_ITEMS]' => 'Número de ítems.',
                '[TEMA]' => 'Tema o contexto (opcional).',
            ],
            'prompt' => 'Actúa como constructor de ítems de evaluación de inglés con experiencia en pruebas estandarizadas alineadas con el MCER y conocedor de la prueba de inglés de Saber 11 (ICFES).

CONTEXTO
- Tipo de tarea: [PARTE].
- Formato oficial de esa parte (respétalo exactamente): [FORMATO_OFICIAL]
- Nivel MCER que mide cada ítem: [NIVEL_MCER]. Número de ítems: [N_ITEMS]. Tema: [TEMA].

TAREA
1. Escribe [N_ITEMS] ítems ORIGINALES con el formato indicado (instrucción en inglés como en la prueba, enunciado y opciones).
2. Para cada ítem: respuesta correcta; justificación de por qué es correcta; justificación de por qué cada distractor es incorrecto y qué error de comprensión atrae; nivel MCER que mide; y qué conocimiento evalúa (léxico, gramática, inferencia, pragmática).
3. Al final, una tabla de especificaciones: ítem | clave | nivel | conocimiento.

REGLAS DE CALIDAD
- Una sola respuesta correcta indiscutible; los distractores son plausibles pero claramente incorrectos para quien domina el nivel.
- Opciones de longitud y estructura gramatical similares; la clave no debe ser la más larga.
- Distribuye las claves de forma balanceada (no todas A o B).
- Sin pistas gramaticales cruzadas (artículos a/an que delaten la respuesta, concordancias evidentes).
- Contextos colombianos o universales; nada que exija conocimiento cultural extranjero para responder.
- No copies ítems de cuadernillos publicados del ICFES.

AUTOVERIFICACIÓN
Resuelve tú mismo cada ítem como si fueras un estudiante, sin mirar la clave, y reporta si llegaste a la misma respuesta. Si algún ítem admite dos respuestas o puede responderse sin leer el texto, reescríbelo y dime qué cambiaste.',
            'seguimientos' => [
                'Reescribe los ítems 2 y 4 para que midan un nivel superior sin cambiar el formato.',
                'Arma una hoja de respuestas y una tabla para registrar el porcentaje de acierto por ítem y por tipo de conocimiento.',
                'Escribe una retroalimentación de 2 líneas por ítem para entregar a los estudiantes después del simulacro.',
            ],
            'ejemplo' => [
                'contexto' => '[PARTE] avisos: el estudiante decide dónde puede ver un aviso · [FORMATO_OFICIAL] copiado de la guía de orientación vigente (tres opciones A, B, C) · [NIVEL_MCER] A1-A2 · [N_ITEMS] 5 · [TEMA] lugares públicos colombianos.',
                'resultado_html' => '<p><strong>Ítem 1.</strong> <em>Where can you see this notice?</em><br> <strong>«PLEASE DO NOT FEED THE ANIMALS. THEY HAVE A SPECIAL DIET.»</strong><br> A. in a restaurant · B. in a zoo · C. in a supermarket</p> <p><strong>Clave: B.</strong> Solo en un zoológico hay animales que los visitantes podrían alimentar y que tienen una dieta controlada. A atrae a quien asocia <em>diet</em> y <em>feed</em> con comida; C atrae a quien asocia comida con supermercado. Nivel A1 · léxico de lugares y propósito comunicativo.</p> <p><strong>Ítem 2.</strong> <em>Where can you see this notice?</em><br> <strong>«LAST BUS TO THE AIRPORT LEAVES AT 10:30 P.M. BUY YOUR TICKET HERE.»</strong><br> A. at a bus station · B. at an airport · C. at a train station</p> <p><strong>Clave: A.</strong> Se compra el pasaje del bus que va al aeropuerto. B atrae por la palabra <em>airport</em> (pista léxica falsa), C por <em>ticket</em>. Nivel A2 · comprensión de propósito.</p> <p><em>Nota del editor:</em> en la primera versión de la IA el ítem 2 tenía como opciones «at a bus station / at a bus stop», y ambas eran defendibles; se reemplazó B por «at an airport». La autoverificación detectó el problema solo cuando se le pidió resolver los ítems sin la clave.</p>',
            ],
            'revisar' => [
                'Que el formato (número de opciones, instrucción) coincida con la Guía de orientación del año en curso.',
                'Resuelva cada ítem usted mismo sin mirar la clave; los ítems con dos respuestas defendibles son el error más común.',
                'Que la clave no siga un patrón (A, B, C, A, B, C…) y esté balanceada.',
                'Que los ítems no sean copia de cuadernillos publicados.',
            ],
        ],
        [
            'id' => 'ING-12',
            'categoria' => 'evaluacion',
            'titulo' => 'Taller de comprensión lectora: literal, inferencial y crítica',
            'grados' => '8.° a 11.°',
            'tiempo_ahorrado' => '≈ 50 min',
            'cuando' => 'Cuando quiere evaluar o practicar comprensión de lectura más allá de «buscar la palabra en el texto», con preguntas de inferencia y lectura crítica sobre un texto propio.',
            'variables' => [
                '[TEXTO]' => 'El texto completo (propio, adaptado o generado con la receta ING-05 y verificado).',
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel del texto.',
                '[N_PREGUNTAS]' => 'Número de preguntas por nivel de lectura.',
            ],
            'prompt' => 'Actúa como evaluador de comprensión lectora en inglés como lengua extranjera, experto en niveles de lectura (literal, inferencial, crítico) y en los descriptores de lectura del MCER.

CONTEXTO
- Grado [GRADO]. Nivel del texto: [NIVEL_MCER].
- Texto (no lo modifiques): [TEXTO]

TAREA
1. Escribe [N_PREGUNTAS] preguntas literales, [N_PREGUNTAS] inferenciales y 2 críticas.
   - Literales: la respuesta está explícita (de selección múltiple con 3 opciones).
   - Inferenciales: propósito del autor, significado de una palabra por contexto, relación causa-efecto, referencia de pronombres, idea implícita (selección múltiple con 4 opciones).
   - Críticas: abiertas, piden opinión justificada con evidencia del texto.
2. Clave con la línea o frase del texto que sustenta cada respuesta y la explicación de cada distractor.
3. Criterio de valoración para las preguntas críticas (qué es una respuesta Superior, Alta, Básica y Baja).

RESTRICCIONES
- Las preguntas en inglés de nivel igual o inferior al del texto.
- Ninguna pregunta debe poder responderse sin leer el texto.
- Las inferenciales deben exigir unir información, no copiar una frase.

AUTOVERIFICACIÓN
Para cada pregunta, cita la evidencia textual. Si una pregunta inferencial puede responderse copiando una frase literal, reclasifícala o reescríbela. Reporta.',
            'seguimientos' => [
                'Convierte las preguntas críticas en una discusión en grupos con roles (moderador, relator, abogado del diablo).',
                'Haz una versión de las preguntas con apoyo en español para estudiantes con PIAR, manteniendo el texto en inglés.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.° · [NIVEL_MCER] B1 · [N_PREGUNTAS] 3 · [TEXTO] texto propio de 250 palabras sobre el Festival Petronio Álvarez de Cali (música del Pacífico, marimba de chonta, se celebra cada año en agosto, lleva el nombre del compositor de «Mi Buenaventura»).',
                'resultado_html' => '<p><strong>Literal 1.</strong> <em>When does the festival take place?</em> A. in December · B. in August · C. in March. <strong>Clave: B</strong> (línea 2: «every year in August»).</p> <p><strong>Inferencial 1.</strong> <em>In paragraph 3, "it" in "it became a symbol of the region" refers to…</em> A. the city of Cali · B. the marimba de chonta · C. the festival · D. the song "Mi Buenaventura". <strong>Clave: B</strong>: el párrafo describe el instrumento y en 2010 la UNESCO inscribió las músicas de marimba y los cantos tradicionales del Pacífico Sur de Colombia en su Lista Representativa del Patrimonio Cultural Inmaterial; D atrae porque la canción se menciona en el párrafo anterior.</p> <p><strong>Crítica 1.</strong> <em>The author says the festival "is more than a party". Do you agree? Use one example from the text and one from your own experience.</em></p> <p><strong>Criterio (Superior):</strong> toma posición clara, cita el texto con precisión y conecta con una experiencia propia pertinente; lengua B1 con pocos errores que no afectan el sentido.</p>',
            ],
            'revisar' => [
                'Que cada respuesta tenga sustento en el texto que usted entregó (la IA a veces responde con conocimiento externo).',
                'Que las preguntas inferenciales no se respondan copiando una frase.',
                'Que los datos culturales mencionados sean correctos; verifique cualquier fecha o dato agregado.',
            ],
        ],
        [
            'id' => 'ING-13',
            'categoria' => 'evaluacion',
            'titulo' => 'Tarea de speaking (monólogo e interacción) con tarjeta, guion del evaluador y rúbrica',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 60 min',
            'cuando' => 'Cuando debe evaluar expresión oral de 35 a 40 estudiantes de forma justa, con tareas iguales para todos, tiempos claros y criterios conocidos de antemano.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[DBA]' => 'DBA de monólogo o conversación (texto literal).',
                '[TEMA]' => 'Tema de la unidad.',
                '[TIEMPO_POR_ESTUDIANTE]' => 'Minutos disponibles por estudiante o pareja.',
            ],
            'prompt' => 'Actúa como examinador oral de inglés con experiencia en exámenes alineados con el MCER y en la escala de valoración del Decreto 1290.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER]. Tema: [TEMA].
- DBA (literal): "[DBA]"
- Tiempo por estudiante/pareja: [TIEMPO_POR_ESTUDIANTE].

TAREA
1. Diseña dos tareas:
   a) Monólogo: tarjeta con situación, propósito, 3 puntos que debe cubrir y 1 minuto de preparación.
   b) Interacción en parejas: tarjeta con una decisión que deben tomar juntos (planear, elegir, resolver).
2. Escribe 3 versiones equivalentes de cada tarjeta para que los estudiantes no se copien entre turnos.
3. Guion del evaluador: qué decir exactamente al inicio, preguntas de apoyo si el estudiante se bloquea y cómo cerrar.
4. Rúbrica analítica con 4 criterios (cumplimiento de la tarea, fluidez y coherencia, precisión gramatical y léxica, pronunciación e interacción) y 4 niveles: Superior, Alto, Básico, Bajo, con descriptores observables propios del nivel [NIVEL_MCER].
5. Planilla de registro para 40 estudiantes y una propuesta de logística (qué hace el resto del grupo mientras evalúo).

RESTRICCIONES
- Las tarjetas deben estar en inglés de nivel inferior al que se evalúa.
- Los descriptores no deben castigar el acento colombiano: se evalúa la inteligibilidad, no parecerse a un nativo.
- Ningún criterio debe depender de conocimiento cultural ajeno al estudiante.

AUTOVERIFICACIÓN
Confirma que las tres versiones de cada tarjeta tienen la misma dificultad (mismos tiempos verbales y cantidad de puntos), que los descriptores distinguen claramente entre niveles adyacentes y que la logística cabe en el tiempo disponible. Reporta.',
            'seguimientos' => [
                'Escribe ejemplos de respuesta de un estudiante en nivel Alto y uno en nivel Básico para calibrar la rúbrica con mis colegas.',
                'Dame una versión de la rúbrica en lenguaje para estudiantes (I can…) para entregarla antes de la evaluación.',
                'Propón una actividad autónoma de 25 minutos para el resto del grupo mientras evalúo por parejas.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.° · [NIVEL_MCER] B1 · [TEMA] turismo responsable en mi región · [TIEMPO_POR_ESTUDIANTE] 4 minutos por pareja (monólogo de 1 minuto cada uno + 2 minutos de interacción).',
                'resultado_html' => '<p><strong>Tarjeta monólogo (versión 1):</strong> <em>A group of exchange students is visiting your town next month. Recommend ONE place they should visit. Say: what the place is and where it is; what visitors can do there; one rule visitors should follow to protect it. You have 1 minute to prepare and 1 minute to speak.</em></p> <p><strong>Tarjeta interacción:</strong> <em>You and your partner have one free Saturday with the visitors and 100,000 pesos for the group. Decide together where to go, how to travel and what to eat. Agree on a plan.</em></p> <p><strong>Guion del evaluador:</strong> «Good morning. In this test you are going to speak for one minute about a place. Here is your card. You have one minute to prepare. You can make notes.» Apoyo si se bloquea: «What can visitors do there?» (máximo 2 apoyos; se registran).</p> <p><strong>Criterio «Fluidez y coherencia», nivel Alto:</strong> habla de forma comprensible durante casi todo el minuto con pausas para buscar palabras; organiza las ideas con conectores básicos (<em>first, also, because</em>). <strong>Básico:</strong> produce frases cortas con pausas frecuentes; necesita un apoyo del evaluador para continuar.</p> <p><strong>Logística:</strong> mientras dos parejas preparan en el pasillo, el resto realiza la lectura de la receta ING-05 con preguntas; 9 parejas por bloque de 55 minutos.</p>',
            ],
            'revisar' => [
                'Que las tres versiones de cada tarjeta sean equivalentes en dificultad.',
                'Que los descriptores no premien la «pronunciación nativa» sino la inteligibilidad.',
                'Que la logística sea realista para su número de estudiantes y horario.',
                'Que la rúbrica use la escala y las equivalencias numéricas de su SIEE.',
            ],
        ],
        [
            'id' => 'ING-14',
            'categoria' => 'evaluacion',
            'titulo' => 'Prueba diagnóstica de nivel al inicio del año (lectura, uso de la lengua y entrevista breve)',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 75 min',
            'cuando' => 'En las primeras semanas del año, para saber el nivel real del grupo antes de planear, y no suponer que un grado 9.° está en B1 porque así lo dice el estándar.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[NIVEL_ESPERADO]' => 'Nivel que espera el estándar para el grado.',
                '[TIEMPO]' => 'Minutos disponibles para la prueba.',
                '[TEMAS_PREVIOS]' => 'Temas vistos el año anterior (si los conoce).',
            ],
            'prompt' => 'Actúa como especialista en evaluación diagnóstica de inglés con conocimiento del MCER y de los niveles de la Guía 22.

CONTEXTO
- Grado [GRADO]. Nivel esperado: [NIVEL_ESPERADO]. Tiempo: [TIEMPO] minutos.
- Temas del año anterior: [TEMAS_PREVIOS].

TAREA
1. Diseña una prueba escrita escalonada de 30 ítems: 10 de nivel A1, 10 de A2 y 10 de B1, en orden de dificultad creciente, que combine vocabulario, uso de la lengua y comprensión de lectura breve.
2. Una tarea corta de escritura (40 a 80 palabras) con instrucción clara.
3. Una entrevista oral de 2 minutos con 6 preguntas escalonadas (A1 → B1) para hacer a una muestra de estudiantes.
4. Clave de respuestas y criterio de ubicación: cuántos aciertos por bloque indican que el estudiante está en cada nivel.
5. Una tabla para consolidar resultados del grupo y una guía para interpretarlos (qué hacer si el 60 % está por debajo del nivel esperado).

RESTRICCIONES
- La prueba no se califica con nota: es diagnóstica. Indícalo en la instrucción a los estudiantes en español.
- Ítems con una sola respuesta correcta; contextos colombianos.
- Instrucciones en español para no confundir comprensión de la instrucción con nivel de inglés.

AUTOVERIFICACIÓN
Resuelve cada ítem sin la clave y confirma el nivel MCER que mide cada uno. Si dudas de la dificultad, explica por qué. Reporta los ítems que cambiaste.',
            'seguimientos' => [
                'Con estos resultados agregados (pego porcentajes por bloque) dime qué ajustes hago a la malla del periodo.',
                'Diseña tres grupos de trabajo diferenciados según los resultados y una actividad para cada uno sobre el mismo tema.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 8.° · [NIVEL_ESPERADO] B1.1 según Guía 22 · [TIEMPO] 50 minutos · [TEMAS_PREVIOS] rutinas, pasado simple, comparativos.',
                'resultado_html' => '<p><strong>Bloque A1 (ítem 3):</strong> <em>My brother ___ 14 years old.</em> A. has · B. is · C. have. <strong>Clave: B</strong> (error típico por transferencia: «tiene 14 años»).</p> <p><strong>Bloque A2 (ítem 15):</strong> <em>Last Sunday we ___ to the river and had sancocho.</em> A. go · B. went · C. going. <strong>Clave: B.</strong></p> <p><strong>Bloque B1 (ítem 24):</strong> <em>If it rains tomorrow, the football match ___ cancelled.</em> A. will be · B. would be · C. was. <strong>Clave: A</strong> (condicional tipo 1).</p> <p><strong>Criterio de ubicación:</strong> 8 o más aciertos en un bloque = nivel consolidado; 5 a 7 = en proceso; menos de 5 = no alcanzado. Se ubica al estudiante en el bloque más alto consolidado.</p> <p><strong>Interpretación:</strong> si el 60 % del grupo consolida solo A1, la malla de 8.° debe empezar por A2 (pasado simple, comparativos con práctica comunicativa) y el B1 se convierte en meta de 9.°; registre la brecha en el plan de mejoramiento del área.</p>',
            ],
            'revisar' => [
                'Que los ítems estén ordenados por dificultad real (pruebe con 3 estudiantes antes de aplicarla a todos).',
                'Que no haya ítems con dos respuestas posibles.',
                'Que la prueba no se convierta en nota; comuníquelo a estudiantes y familias.',
            ],
        ],
        [
            'id' => 'ING-15',
            'categoria' => 'evaluacion',
            'titulo' => 'Tarea de escritura auténtica con texto modelo y marco de planeación',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 45 min',
            'cuando' => 'Cuando quiere que los estudiantes escriban un texto con propósito y destinatario reales (correo, blog, reseña, aviso) y necesita la consigna, un texto modelo de nivel adecuado y un andamio para planear.',
            'variables' => [
                '[GENERO]' => 'Tipo de texto (correo informal, entrada de blog, reseña, carta de solicitud, aviso).',
                '[DESTINATARIO]' => 'Para quién escriben (estudiante de intercambio, turista, emisora, comunidad).',
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[EXTENSION]' => 'Número de palabras esperado.',
                '[TEMA]' => 'Tema.',
            ],
            'prompt' => 'Actúa como docente de escritura en inglés como lengua extranjera, experto en enfoque por géneros textuales y en los descriptores de producción escrita del MCER.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER]. Género: [GENERO]. Destinatario: [DESTINATARIO]. Tema: [TEMA]. Extensión: [EXTENSION] palabras.

TAREA
1. Consigna para los estudiantes en inglés claro: situación, propósito, destinatario, 3 o 4 puntos de contenido obligatorios y extensión.
2. Texto modelo de desempeño Superior, exactamente dentro del nivel [NIVEL_MCER] y de la extensión pedida, con sus partes señaladas (saludo, apertura, desarrollo, cierre).
3. Análisis del modelo: 5 rasgos del género que los estudiantes deben imitar (conectores, registro, fórmulas de apertura y cierre).
4. Marco de planeación (organizador gráfico) que el estudiante llena antes de escribir.
5. Lista de autochequeo de 6 puntos en inglés sencillo para revisar antes de entregar.

RESTRICCIONES
- El texto modelo no debe sonar a texto «perfecto» de nativo: debe ser alcanzable para un estudiante de [NIVEL_MCER].
- Contenido situado en Colombia; el destinatario puede ser extranjero.
- Registro adecuado al destinatario.

AUTOVERIFICACIÓN
Cuenta las palabras del modelo, verifica que cubre todos los puntos de la consigna y señala cualquier estructura por encima de [NIVEL_MCER] para cambiarla. Reporta.',
            'seguimientos' => [
                'Escribe un segundo modelo de nivel Básico (con errores típicos realistas) para que los estudiantes lo comparen con el Superior y descubran las diferencias.',
                'Convierte el autochequeo en una lista de coevaluación entre pares con una línea para comentario.',
            ],
            'ejemplo' => [
                'contexto' => '[GENERO] correo informal · [DESTINATARIO] Liam, estudiante de intercambio de Canadá que llegará a Barranquilla · [GRADO] 9.° · [NIVEL_MCER] A2+ · [EXTENSION] 100 a 120 · [TEMA] el Carnaval de Barranquilla.',
                'resultado_html' => '<p><strong>Consigna:</strong> <em>Liam, an exchange student from Canada, is coming to Barranquilla in February. Write an email to him (100–120 words). Tell him: what the Carnival is; one activity he must see; what clothes to bring; one piece of advice to enjoy it safely.</em></p> <p><strong>Modelo (107 palabras):</strong><br> <em>Hi Liam,<br> I\'m so happy you\'re coming to Barranquilla in February! You are going to arrive during the Carnival. It is the biggest party in Colombia, with music, dancing and colorful costumes.<br> You must see the Batalla de Flores. It is a big parade on Saturday, and there are many dancers and floats. I think you will love the cumbia music.<br> It is very hot here, so bring light clothes, a hat and comfortable shoes. Remember to drink a lot of water and use sunscreen.<br> My advice: stay with my family or friends in the crowd, and don\'t carry a lot of money.<br> See you soon!<br> Mariana</em></p> <p><strong>Rasgos para imitar:</strong> saludo informal (<em>Hi</em>), apertura con emoción, un párrafo por punto, imperativos para consejos (<em>bring, remember</em>), cierre informal (<em>See you soon!</em>).</p>',
            ],
            'revisar' => [
                'Cuente las palabras del modelo usted mismo.',
                'Verifique datos culturales (fechas, nombres de desfiles) del evento que use.',
                'Que el modelo sea alcanzable: si suena demasiado sofisticado, pida una versión más sencilla.',
            ],
        ],
        [
            'id' => 'ING-16',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Retroalimentación de escritura con códigos de error (sin reescribir el texto del estudiante)',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h por grupo',
            'cuando' => 'Cuando tiene 40 textos para corregir y quiere una retroalimentación que haga pensar al estudiante (códigos, prioridades y una tarea de mejora), no un texto corregido por la IA que el estudiante solo copia.',
            'variables' => [
                '[TEXTO_ESTUDIANTE]' => 'Texto transcrito tal cual, sin nombre (use «Estudiante 12»).',
                '[CONSIGNA]' => 'La consigna original.',
                '[NIVEL_MCER]' => 'Nivel esperado.',
                '[CODIGOS]' => 'Su tabla de códigos (o use la sugerida: T tiempo verbal, SV concordancia sujeto-verbo, WW palabra equivocada, WO orden, ^ falta una palabra, Sp ortografía, P puntuación, ? no se entiende).',
                '[FOCO]' => 'Lo que se enseñó y se debe priorizar (p. ej., pasado simple y conectores).',
            ],
            'prompt' => 'Actúa como docente de inglés experto en retroalimentación formativa de la escritura (feed-forward) y en análisis de errores de hispanohablantes.

CONTEXTO
- Consigna: [CONSIGNA]
- Nivel esperado: [NIVEL_MCER]. Foco de la unidad: [FOCO].
- Códigos de error: [CODIGOS]
- Texto del estudiante (no lo reescribas): [TEXTO_ESTUDIANTE]

TAREA
1. Copia el texto y marca cada error con el código entre corchetes justo después de la palabra o segmento, SIN dar la corrección.
2. Clasifica los errores en: globales (impiden entender) y locales (no impiden entender). Prioriza máximo 3 aspectos para mejorar, empezando por los globales y por los relacionados con [FOCO].
3. Escribe al estudiante, en español sencillo y tono cálido: 2 fortalezas concretas (citando su texto), los 3 aspectos priorizados con una pista para cada uno y una pregunta que lo haga pensar.
4. Diseña una mini-tarea de reescritura de 10 minutos centrada en el aspecto 1.
5. Sugiere una valoración según la escala del Decreto 1290 (Superior, Alto, Básico, Bajo) con una frase de justificación basada en el cumplimiento de la consigna, no solo en el número de errores.

RESTRICCIONES
- No reescribas el texto completo ni entregues la versión corregida.
- No marques como error usos correctos de otra variante del inglés (británico o americano).
- No señales más de 12 errores: si hay más, marca los que afectan el foco y los globales, y dilo.

AUTOVERIFICACIÓN
Revisa cada marca: ¿es realmente un error?, ¿el código es el correcto? Si un segmento es aceptable aunque poco natural, no lo marques como error: sugiérelo como «forma más natural» en la retroalimentación. Reporta cuántas marcas retiraste.',
            'seguimientos' => [
                'Ahora, con los errores de 10 textos que te pego (ya anonimizados), dime cuáles son los 3 errores más frecuentes del grupo y diseña una clase de 20 minutos para atacarlos.',
                'Escribe la clave de corrección (solo para mí) del texto, para verificar mis propias marcas.',
            ],
            'ejemplo' => [
                'contexto' => '[CONSIGNA] escribir sobre el último fin de semana (60 a 80 palabras) · [NIVEL_MCER] A2 · [FOCO] pasado simple · [TEXTO_ESTUDIANTE] «Last weekend I go to the river with my family. Was very hot and we eat sancocho. My brother have 12 years and he swim very good. In the afternoon we play football and my father win. I was very happy because is my favorite place.»',
                'resultado_html' => '<p><strong>Texto marcado:</strong> <em>Last weekend I go [T] to the river with my family. ^ Was [^] very hot and we eat [T] sancocho. My brother have 12 years [WW] and he swim [T] very good [WW]. In the afternoon we play [T] football and my father win [T]. I was very happy because ^ is [^][T] my favorite place.</em></p> <p><strong>Para ti:</strong> ¡Tu texto se entiende muy bien y cuenta un fin de semana real! <strong>Fortalezas:</strong> usas bien <em>Last weekend</em> e <em>In the afternoon</em> para ordenar la historia, y escribiste <em>I was very happy</em> correctamente en pasado. <strong>Para mejorar:</strong> 1) Los verbos marcados con [T] hablan del fin de semana pasado: ¿cómo se escriben en pasado? Pista: algunos son regulares (+ed) y otros irregulares; busca <em>go, eat, swim, win</em> en tu lista. 2) En inglés toda oración necesita sujeto: ¿quién o qué «was very hot»? 3) Para la edad, en inglés no se «tiene» años: ¿qué verbo usamos? <strong>Pregunta:</strong> si lees tu texto en voz alta, ¿suena a algo que pasó o que pasa siempre?</p> <p><strong>Mini-tarea (10 min):</strong> subraya todos los verbos de tu texto, escribe su pasado en el margen con ayuda de la lista y vuelve a escribir solo las tres primeras oraciones.</p> <p><strong>Valoración sugerida:</strong> Básico. Cumple la consigna y la extensión, el mensaje se comprende, pero el foco de la unidad (pasado simple) aparece solo en <em>was</em>.</p> <p><em>Nota del editor:</em> la IA marcó inicialmente <em>sancocho</em> como [Sp]; se retiró, porque es un nombre propio de la gastronomía colombiana y está bien escrito.</p>',
            ],
            'revisar' => [
                'Que cada código sea correcto y que no se marquen como error palabras colombianas o variantes válidas.',
                'Que la retroalimentación no entregue la corrección completa.',
                'Que la valoración sea coherente con su rúbrica y SIEE, no solo con la opinión de la IA.',
                'No pegue nombres ni datos del estudiante.',
            ],
        ],
        [
            'id' => 'ING-17',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Retroalimentación de speaking a partir de sus notas de observación',
            'grados' => '6.° a 11.°',
            'tiempo_ahorrado' => '≈ 25 min',
            'cuando' => 'Después de una evaluación oral, cuando tiene notas rápidas (errores oídos, frases buenas) y quiere convertirlas en retroalimentación útil y un plan de práctica de pronunciación con pares mínimos.',
            'variables' => [
                '[NOTAS]' => 'Sus notas de observación tal como las tomó (sin nombre).',
                '[TAREA_ORAL]' => 'Qué tarea oral hizo el estudiante.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[VALORACION]' => 'La valoración que usted ya asignó con la rúbrica.',
            ],
            'prompt' => 'Actúa como docente de inglés y entrenador de pronunciación para hispanohablantes colombianos, con enfoque en inteligibilidad (no en acento nativo).

CONTEXTO
- Tarea oral: [TAREA_ORAL]. Nivel: [NIVEL_MCER]. Valoración asignada: [VALORACION].
- Mis notas de observación: [NOTAS]

TAREA
1. Organiza mis notas en: lo que hizo bien (con ejemplos), errores que afectan la comprensión y errores que no la afectan.
2. Escribe una retroalimentación para el estudiante en español, de máximo 120 palabras, con 2 logros, 1 prioridad de lengua y 1 prioridad de pronunciación.
3. Para la prioridad de pronunciación: explica el problema en términos sencillos, da 6 pares mínimos o palabras de práctica y una frase-trabalenguas corta para practicar en casa.
4. Propón una meta para la próxima evaluación oral redactada como «Next time I will…».

RESTRICCIONES
- No inventes errores ni logros que no estén en mis notas.
- No penalices rasgos del acento que no afectan la comprensión.
- Tono motivador y concreto.

AUTOVERIFICACIÓN
Comprueba que los pares mínimos realmente contrastan el sonido en cuestión y que todo lo que dices sale de mis notas. Reporta en 2 líneas.',
            'seguimientos' => [
                'Agrupa las notas de 8 estudiantes (te las pego) y dime qué sonido o error debo trabajar con todo el grupo.',
                'Diseña un calentamiento de pronunciación de 5 minutos para las próximas 4 clases con ese sonido.',
            ],
            'ejemplo' => [
                'contexto' => '[TAREA_ORAL] monólogo de 1 minuto recomendando un lugar · [NIVEL_MCER] B1 · [VALORACION] Alto · [NOTAS] «buena organización: first, also, finally · dijo "I am agree" · "walked" pronunciado walk-ed · "it\'s very beautiful place" · ship/sheep: dijo "sheep" por "ship" al hablar del barco en Cartagena · buena fluidez, pocas pausas».',
                'resultado_html' => '<p><strong>Para ti:</strong> ¡Muy buen trabajo! Organizaste tu recomendación con <em>first, also, finally</em> y hablaste con muy pocas pausas. <strong>Lengua:</strong> en inglés «estar de acuerdo» es un verbo: se dice <em>I agree</em>, no <em>I am agree</em>. <strong>Pronunciación:</strong> la terminación -ed de <em>walked</em> no se pronuncia como sílaba aparte: suena /t/, «walkt». Solo se agrega sílaba cuando el verbo termina en sonido t o d (<em>visited, needed</em>).</p> <p><strong>Práctica:</strong> <em>walked /t/ · watched /t/ · played /d/ · cleaned /d/ · visited /ɪd/ · wanted /ɪd/</em>. Frase: <em>I walked, talked and watched the boats.</em></p> <p><strong>Meta:</strong> <em>Next time I will say "I agree" and pronounce -ed endings correctly.</em></p> <p><em>Nota del editor:</em> el contraste <em>ship/sheep</em> se dejó para la clase de todo el grupo (apareció en varios estudiantes); se omitió la observación «it\'s very beautiful place» como prioridad porque no afecta la comprensión, y se priorizaron solo dos aspectos.</p>',
            ],
            'revisar' => [
                'Que la retroalimentación provenga solo de sus notas.',
                'Que las explicaciones de pronunciación sean correctas (la regla de -ed es un punto donde la IA a veces simplifica mal).',
                'Que no se mencionen más de dos prioridades.',
            ],
        ],
        [
            'id' => 'ING-18',
            'categoria' => 'retroalimentacion',
            'titulo' => 'Autoevaluación y coevaluación con can-do statements',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 30 min',
            'cuando' => 'Al cierre de una unidad, cuando quiere que los estudiantes reconozcan qué pueden hacer en inglés y se den retroalimentación entre pares con criterios claros.',
            'variables' => [
                '[UNIDAD]' => 'Tema y objetivos de la unidad.',
                '[DBA]' => 'DBA trabajados (texto literal).',
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[PRODUCTO]' => 'Producto que se coevalúa (presentación, cartel, diálogo).',
            ],
            'prompt' => 'Actúa como docente experto en evaluación formativa y en autorregulación del aprendizaje de lenguas, conocedor del Portafolio Europeo de las Lenguas y los descriptores del MCER.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER]. Unidad: [UNIDAD].
- DBA (literal): "[DBA]". Producto a coevaluar: [PRODUCTO].

TAREA
1. Escribe 8 a 10 can-do statements para la unidad, uno por habilidad como mínimo, concretos y situados (no «I can speak English»), con escala de 3 caritas o niveles (I can do it well / I can do it with help / I can\'t do it yet).
2. Para A1-A2: traduce cada statement al español debajo, en letra más pequeña.
3. Diseña una coevaluación del producto con el formato «Two stars and a wish» y 3 criterios observables, con frases de apoyo en inglés para dar retroalimentación respetuosa.
4. Agrega una pregunta de reflexión final: qué estrategia me sirvió y qué haré diferente.
5. Instrucciones para que el docente use los resultados (qué hacer con quienes marcan «not yet»).

RESTRICCIONES
- Statements alineados con los DBA pegados; sin numeración inventada.
- Lenguaje de estudiante, no de documento oficial.
- Frases de coevaluación que eviten juicios sobre la persona.

AUTOVERIFICACIÓN
Comprueba que cada statement sea observable (¿podría demostrarlo el estudiante en 1 minuto?) y que el conjunto cubra las cinco habilidades de la Guía 22 o las que la unidad trabajó. Reporta.',
            'seguimientos' => [
                'Convierte la autoevaluación en una tabla de una página para pegar en el cuaderno.',
                'Dame una forma de convertir la autoevaluación en una nota de 10 % sin que los estudiantes se pongan todos «Superior».',
            ],
            'ejemplo' => [
                'contexto' => '[UNIDAD] My town and its places · [GRADO] 6.° · [NIVEL_MCER] A1 · [PRODUCTO] cartel «Visit my neighborhood» presentado oralmente.',
                'resultado_html' => '<table> <tr><th>Can-do statement</th><th>Well</th><th>With help</th><th>Not yet</th></tr> <tr><td><em>I can name 8 places in my town.</em><br><small>Puedo nombrar 8 lugares de mi municipio.</small></td><td>☐</td><td>☐</td><td>☐</td></tr> <tr><td><em>I can understand simple directions to a place.</em><br><small>Entiendo indicaciones sencillas para llegar a un lugar.</small></td><td>☐</td><td>☐</td><td>☐</td></tr> <tr><td><em>I can ask "Where is the…?" and understand the answer.</em><br><small>Puedo preguntar dónde queda un lugar y entender la respuesta.</small></td><td>☐</td><td>☐</td><td>☐</td></tr> <tr><td><em>I can write 4 sentences about my neighborhood with "there is / there are".</em></td><td>☐</td><td>☐</td><td>☐</td></tr> </table> <p><strong>Two stars and a wish:</strong> ★ <em>I like your poster because…</em> ★ <em>You said … very clearly.</em> Wish: <em>Next time you can…</em></p> <p><strong>Uso de resultados:</strong> si más de un tercio del grupo marca «Not yet» en el mismo statement, ese aprendizaje se retoma en la primera semana de la unidad siguiente; los casos individuales van a la receta ING-22.</p>',
            ],
            'revisar' => [
                'Que los statements sean observables y del nivel del grupo.',
                'Que las traducciones al español sean fieles.',
                'Que los resultados se usen para decidir, no solo para archivar.',
            ],
        ],
        [
            'id' => 'ING-19',
            'categoria' => 'adaptacion',
            'titulo' => 'Clase con Diseño Universal para el Aprendizaje (DUA)',
            'grados' => 'Transición a 11.°',
            'tiempo_ahorrado' => '≈ 40 min',
            'cuando' => 'Cuando ya tiene una clase planeada y quiere hacerla accesible para todo el grupo desde el diseño (no solo con adaptaciones de última hora), con opciones de representación, acción-expresión e implicación.',
            'variables' => [
                '[PLAN_CLASE]' => 'Su plan de clase (pegue la tabla de la receta ING-01).',
                '[DIVERSIDAD]' => 'Diversidad del grupo sin nombres (ritmos, estudiantes con discapacidad, estudiantes que llegaron de otros países o regiones, intereses).',
                '[RECURSOS]' => 'Recursos reales.',
            ],
            'prompt' => 'Actúa como experto en Diseño Universal para el Aprendizaje (pautas de CAST) y en educación inclusiva en Colombia (Decreto 1421 de 2017), con experiencia en clases de inglés.

CONTEXTO
- Plan de clase original: [PLAN_CLASE]
- Diversidad del grupo: [DIVERSIDAD]
- Recursos: [RECURSOS]

TAREA
1. Identifica las barreras de aprendizaje y participación que tiene la clase tal como está (no del estudiante: de la clase).
2. Rediseña la clase con opciones en los tres principios del DUA:
   - Implicación (motivación): elección, relevancia, trabajo colaborativo, autorregulación.
   - Representación: input en varios formatos (visual, auditivo, gestual, texto), glosarios, activación de conocimientos previos.
   - Acción y expresión: varias formas de demostrar el aprendizaje (oral, escrita, dibujada, dramatizada) manteniendo el mismo objetivo.
3. Mantén el mismo objetivo de aprendizaje para todos; cambia caminos y apoyos, no la meta (salvo que el PIAR indique otra cosa).
4. Entrega la clase rediseñada en la misma tabla, con una columna nueva «Opciones DUA».

RESTRICCIONES
- Solo recursos disponibles; nada que requiera internet en el aula si no lo hay.
- No uses etiquetas diagnósticas para describir a los estudiantes.

AUTOVERIFICACIÓN
Revisa que cada etapa tenga al menos una opción DUA, que el objetivo siga siendo el mismo y que las opciones no multipliquen la carga de preparación del docente (máximo 30 minutos extra de preparación). Reporta.',
            'seguimientos' => [
                'Diseña el «menú de evidencias» de esta clase: 3 formas distintas de demostrar el mismo objetivo, con el mismo criterio de logro.',
                'Escribe los apoyos visuales que debo dibujar en el tablero, descritos paso a paso.',
            ],
            'ejemplo' => [
                'contexto' => '[PLAN_CLASE] clase de 8.° sobre rutinas diarias (present simple + adverbios de frecuencia), 55 min · [DIVERSIDAD] 36 estudiantes; uno con baja visión, dos con dificultades de atención, tres que llegaron este año de otras regiones con poco inglés previo · [RECURSOS] tablero, parlante, fotocopias.',
                'resultado_html' => '<p><strong>Barreras de la clase original:</strong> el input es solo una lectura en fotocopia de letra pequeña; la práctica es individual y escrita; no hay elección.</p> <table> <tr><th>Etapa</th><th>Original</th><th>Opciones DUA</th></tr> <tr><td>Presentación</td><td>Lectura «Sofía\'s day»</td><td>Lectura en voz alta por el docente + secuencia de 6 dibujos en el tablero con hora; fotocopia en letra 16 para quien la necesite; glosario visual de 6 verbos.</td></tr> <tr><td>Práctica</td><td>Completar 10 oraciones</td><td>Elegir: completar oraciones, ordenar tarjetas de la rutina en pareja o representar con mímica la rutina para que el compañero diga la oración.</td></tr> <tr><td>Producción</td><td>Escribir su rutina</td><td>Escribir 5 oraciones, grabar un audio de 30 s en el celular del docente o hacer una historieta de 4 viñetas con frases. Mismo criterio: 5 rutinas con frecuencia.</td></tr> </table> <p><strong>Autorregulación:</strong> cronómetro visible en el tablero por etapa; lista de 3 pasos para quienes se dispersan.</p>',
            ],
            'revisar' => [
                'Que el objetivo de aprendizaje no haya bajado para nadie sin justificación del PIAR.',
                'Que las opciones sean viables con sus recursos y tiempo de preparación.',
                'Que no aparezcan diagnósticos ni etiquetas.',
            ],
        ],
        [
            'id' => 'ING-20',
            'categoria' => 'adaptacion',
            'titulo' => 'Ajustes razonables de inglés para el PIAR',
            'grados' => 'Transición a 11.°',
            'tiempo_ahorrado' => '≈ 60 min',
            'cuando' => 'Cuando debe diligenciar o actualizar la parte de inglés del PIAR de un estudiante con discapacidad, con ajustes razonables concretos para la clase y la evaluación.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[DESCRIPCION]' => 'Descripción funcional sin nombre: qué hace bien, qué barreras enfrenta, apoyos que ya usa (según valoración pedagógica y reportes de salud, sin datos identificables).',
                '[DBA_PERIODO]' => 'DBA o propósitos del periodo.',
                '[RECURSOS]' => 'Recursos y apoyos disponibles (docente de apoyo, intérprete, materiales).',
            ],
            'prompt' => 'Actúa como docente de inglés con formación en educación inclusiva y experiencia en la construcción del PIAR según el Decreto 1421 de 2017.

CONTEXTO
- Grado [GRADO].
- Descripción funcional del estudiante (sin datos identificables): [DESCRIPCION]
- Propósitos o DBA del periodo: [DBA_PERIODO]
- Recursos y apoyos: [RECURSOS]

TAREA
1. Identifica las barreras para el aprendizaje y la participación que el estudiante encuentra específicamente en la clase de inglés (escucha, lectura, escritura, monólogo, conversación).
2. Propón ajustes razonables organizados en: didácticos (cómo enseño), de materiales, de evaluación (cómo evalúo y qué evidencias acepto) y de ambiente (ubicación, tiempos).
3. Señala si los objetivos se mantienen o si se requiere flexibilizar alguno, justificando con la descripción funcional. Prioriza mantener los objetivos con apoyos.
4. Define 3 indicadores de seguimiento de los ajustes (cómo sabré si funcionan) y la periodicidad de revisión.
5. Redacta una nota breve, en español, para socializar los ajustes con la familia.

FORMATO
Tabla: Barrera | Ajuste razonable | Tipo de ajuste | Evidencia de aprendizaje aceptada | Seguimiento. Después la nota a la familia.

RESTRICCIONES
- No hagas diagnósticos ni recomiendes tratamientos.
- Lenguaje respetuoso centrado en barreras del entorno.
- Recuerda que el PIAR se construye con la familia, el docente de apoyo y el equipo; esto es un borrador para esa reunión.

AUTOVERIFICACIÓN
Revisa que cada barrera tenga al menos un ajuste, que ningún ajuste sea genérico («dar más tiempo» debe decir cuánto y en qué actividad) y que la evaluación siga midiendo el aprendizaje del DBA. Reporta.',
            'seguimientos' => [
                'Convierte los ajustes de evaluación en instrucciones concretas para la prueba del periodo.',
                'Escribe un formato de seguimiento mensual de una página para estos ajustes.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.° · [DESCRIPCION] estudiante con hipoacusia moderada bilateral, usa audífonos; lee labios en español; buen desempeño en lectura; se fatiga en actividades largas de escucha; no usa lengua de señas · [DBA_PERIODO] comprender información principal de textos orales y escritos sobre temas conocidos; expresar opiniones sencillas · [RECURSOS] docente de apoyo una vez por semana, parlante, fotocopias.',
                'resultado_html' => '<table> <tr><th>Barrera</th><th>Ajuste razonable</th><th>Tipo</th><th>Evidencia aceptada</th></tr> <tr><td>Audios del parlante con ruido de fondo del salón</td><td>Ubicación en primera fila frente al docente; el docente lee el guion de frente (lectura labial) en vez de usar el parlante; segunda escucha con guion parcial.</td><td>Ambiente / didáctico</td><td>Mismas preguntas de comprensión del grupo</td></tr> <tr><td>Instrucciones orales rápidas</td><td>Instrucciones escritas en el tablero antes de hablar; verificación con ICQ dirigida.</td><td>Didáctico</td><td>—</td></tr> <tr><td>Fatiga en tareas de escucha de más de 3 min</td><td>Audios segmentados en partes de 60 a 90 s con pausa y pregunta.</td><td>Material</td><td>Comprensión de cada segmento</td></tr> <tr><td>Evaluación de escucha</td><td>Prueba con guion leído por el docente de frente, máximo 2 repeticiones; 10 minutos adicionales.</td><td>Evaluación</td><td>Se mantiene el mismo DBA de comprensión oral</td></tr> </table> <p><strong>Objetivos:</strong> se mantienen; los ajustes eliminan barreras de acceso al input sin reducir la exigencia de comprensión.</p> <p><strong>Seguimiento:</strong> porcentaje de acierto en escucha con ajustes vs. lectura; autorreporte de fatiga (escala 1 a 3); revisión cada 5 semanas con docente de apoyo y familia.</p>',
            ],
            'revisar' => [
                'Que el borrador se discuta con la familia, el docente de apoyo y orientación antes de formalizarlo.',
                'Que no haya diagnósticos ni datos de salud identificables en lo que se pegó en la IA.',
                'Que los ajustes sean concretos y medibles.',
                'Que se mantenga el DBA salvo justificación explícita.',
            ],
        ],
        [
            'id' => 'ING-21',
            'categoria' => 'adaptacion',
            'titulo' => 'Grupos multinivel y aulas multigrado (escuela rural, Escuela Nueva)',
            'grados' => '1.° a 9.°',
            'tiempo_ahorrado' => '≈ 45 min',
            'cuando' => 'Cuando en el mismo salón conviven grados distintos (multigrado rural) o niveles muy dispares, y necesita un mismo tema con tareas escalonadas que permitan trabajo simultáneo.',
            'variables' => [
                '[GRADOS]' => 'Grados o niveles presentes y número de estudiantes de cada uno.',
                '[TEMA]' => 'Tema común.',
                '[DURACION]' => 'Duración.',
                '[MODELO]' => 'Modelo pedagógico (Escuela Nueva, Postprimaria rural, tradicional).',
                '[RECURSOS]' => 'Recursos (guías, rincones de trabajo, sin electricidad estable, etc.).',
            ],
            'prompt' => 'Actúa como docente rural colombiano experto en aulas multigrado, en el modelo Escuela Nueva y en enseñanza de inglés con recursos mínimos.

CONTEXTO
- Grados y número de estudiantes: [GRADOS]. Tema común: [TEMA].
- Duración: [DURACION]. Modelo: [MODELO]. Recursos: [RECURSOS].

TAREA
1. Diseña una sesión con un momento común inicial (todos juntos), un momento de trabajo diferenciado por niveles (simultáneo) y un cierre común.
2. Para el momento diferenciado, crea tres tarjetas de trabajo autónomo (nivel inicial, intermedio y avanzado) con instrucciones que los estudiantes puedan seguir sin el docente.
3. Asigna roles de monitores: estudiantes de niveles avanzados que apoyan a los menores con una tarea propia (no solo «ayudar»).
4. Indica en qué momento el docente atiende a cada grupo y por cuántos minutos.
5. Propón cómo dejar evidencia de cada nivel en el portafolio o cuaderno viajero.

RESTRICCIONES
- Recursos solo del entorno (hojas, semillas, objetos de la finca, tablero).
- Instrucciones de las tarjetas en español con lengua meta en inglés para niveles iniciales.
- Contexto rural colombiano.

AUTOVERIFICACIÓN
Comprueba que cada grupo tenga trabajo para todo el momento diferenciado, que el docente no esté en dos grupos al mismo tiempo en el cronograma y que el cierre común permita participar a todos los niveles. Reporta.',
            'seguimientos' => [
                'Convierte las tres tarjetas en guías de una página al estilo Escuela Nueva (actividad básica, práctica y de aplicación).',
                'Diseña una actividad de aplicación para hacer con la familia en la finca.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADOS] sede rural de Ventaquemada (Boyacá): 3 de 1.°, 4 de 3.° y 5 de 5.° · [TEMA] animals and food on the farm · [DURACION] 60 min · [MODELO] Escuela Nueva · [RECURSOS] tablero, hojas, colores, objetos de la finca.',
                'resultado_html' => '<p><strong>Momento común (10 min):</strong> chant de animales con gestos; el docente muestra objetos (huevo, papa, leche en botella) y todos dicen el nombre.</p> <p><strong>Tarjeta 1.° (nivel inicial):</strong> «Dibuja 4 animales de tu finca. El monitor te dice el nombre en inglés y tú lo repites: <em>cow, hen, horse, dog</em>.»</p> <p><strong>Tarjeta 3.° (intermedio):</strong> «Une animal y comida: <em>The cow eats grass. The hen eats corn.</em> Escribe 4 oraciones con ayuda del modelo.»</p> <p><strong>Tarjeta 5.° (avanzado):</strong> «Escribe una ficha de un animal de tu finca: <em>It is… It eats… It gives us… I like it because…</em> Luego eres monitor de 1.°: enséñales tus 4 palabras con dibujos.»</p> <p><strong>Cronograma del docente:</strong> min 10–20 con 1.°; 20–30 con 3.°; 30–40 con 5.°; 40–50 revisa monitores. <strong>Cierre (10 min):</strong> cada grupo muestra algo: 1.° dice los animales, 3.° lee 2 oraciones, 5.° presenta su ficha.</p>',
            ],
            'revisar' => [
                'Que cada tarjeta sea realmente autónoma (pruébela leyendo solo la tarjeta).',
                'Que el vocabulario corresponda a la producción de la zona (papa, leche, maíz en Boyacá).',
                'Que el cronograma del docente no tenga cruces.',
            ],
        ],
        [
            'id' => 'ING-22',
            'categoria' => 'adaptacion',
            'titulo' => 'Plan de apoyo para estudiantes con desempeño Bajo',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 40 min',
            'cuando' => 'Cuando un estudiante (o un grupo) termina el periodo en Bajo y debe diseñar actividades de apoyo y recuperación coherentes con el SIEE y el Decreto 1290, centradas en lo que realmente le falta.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[EVIDENCIAS]' => 'Resumen de evidencias del periodo: qué logró y qué no (por habilidad), sin nombre.',
                '[DBA_NO_ALCANZADOS]' => 'DBA o desempeños no alcanzados (texto literal).',
                '[SEMANAS]' => 'Tiempo disponible para el plan.',
                '[SIEE_RECUPERACION]' => 'Lo que dice su SIEE sobre actividades de apoyo y recuperación.',
            ],
            'prompt' => 'Actúa como docente de inglés experto en evaluación formativa y en planes de mejoramiento individual en el marco del Decreto 1290 de 2009.

CONTEXTO
- Grado [GRADO]. Evidencias del periodo: [EVIDENCIAS]
- Desempeños no alcanzados: [DBA_NO_ALCANZADOS]
- Tiempo disponible: [SEMANAS]. Reglas del SIEE: [SIEE_RECUPERACION]

TAREA
1. Diagnostica la causa probable del desempeño Bajo en cada habilidad (falta de vocabulario, de una estructura, de estrategias de lectura, ausencias, etc.) solo a partir de las evidencias.
2. Diseña un plan de apoyo semana a semana: objetivo, actividad (con material concreto que no requiera internet), tiempo en casa (máximo 20 minutos diarios), apoyo de la familia y evidencia a entregar.
3. Diseña la actividad de valoración final del plan: qué hará el estudiante para demostrar que alcanzó el desempeño, con criterio de logro.
4. Redacta el compromiso del estudiante en primera persona y en lenguaje sencillo.

RESTRICCIONES
- La recuperación no es «un taller de 50 puntos para copiar»: debe ser evidencia de aprendizaje del desempeño no alcanzado.
- Actividades posibles para una familia que no sabe inglés.
- Ajustado a las reglas de su SIEE.

AUTOVERIFICACIÓN
Comprueba que cada desempeño no alcanzado tenga al menos una actividad y una evidencia, y que la carga en casa sea realista. Reporta.',
            'seguimientos' => [
                'Convierte el plan en una ficha de una página para entregar al estudiante y la familia.',
                'Diseña la prueba corta de valoración final con su clave.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.° · [EVIDENCIAS] lectura: 2 de 5 aciertos en preguntas literales; escritura: no entregó 2 de 3 tareas; speaking: participó con frases memorizadas; asistencia irregular en semanas 3 a 5 · [DBA_NO_ALCANZADOS] comprensión de textos cortos sobre rutinas y lugares; descripción escrita de su rutina · [SEMANAS] 3.',
                'resultado_html' => '<p><strong>Diagnóstico:</strong> las inasistencias coinciden con la introducción de adverbios de frecuencia y de lectura de textos de rutina; las preguntas literales falladas dependen de vocabulario de verbos de rutina (<em>wake up, have breakfast, take the bus</em>), no de estrategias de lectura.</p> <p><strong>Semana 1:</strong> objetivo: reconocer 15 verbos de rutina. Actividad: tarjetas con dibujo y palabra (hechas por el estudiante); juego de memoria con un familiar (10 min diarios). Evidencia: tarjetas y prueba oral de 2 minutos con el docente.</p> <p><strong>Semana 2:</strong> leer 3 textos cortos de rutina (80 palabras) y responder 5 preguntas literales cada uno. Evidencia: guía resuelta.</p> <p><strong>Semana 3:</strong> escribir su rutina (6 oraciones con <em>always, usually, never</em>) a partir del modelo. Valoración final: lectura nueva de 80 palabras (4 de 5 aciertos) + texto de 6 oraciones con 4 rutinas correctas = desempeño Básico alcanzado.</p> <p><strong>Compromiso:</strong> «Voy a practicar 15 minutos diarios con mis tarjetas y entregaré cada viernes mi evidencia.»</p>',
            ],
            'revisar' => [
                'Que el diagnóstico se base en evidencias reales y no en suposiciones.',
                'Que el plan respete lo que su SIEE establece sobre recuperaciones.',
                'Que la carga en casa sea viable.',
            ],
        ],
        [
            'id' => 'ING-23',
            'categoria' => 'gestion',
            'titulo' => 'Informe descriptivo a padres de familia (en español)',
            'grados' => 'Transición a 11.°',
            'tiempo_ahorrado' => '≈ 5 min por estudiante',
            'cuando' => 'Al cierre de periodo, cuando debe escribir observaciones de boletín o informes descriptivos claros, respetuosos y útiles para familias que no hablan inglés.',
            'variables' => [
                '[NOTAS_DOCENTE]' => 'Sus notas sobre el estudiante (sin nombre completo ni documento): logros, dificultades, actitud.',
                '[VALORACION]' => 'Desempeño del periodo (Superior, Alto, Básico, Bajo).',
                '[DBA_PERIODO]' => 'Aprendizajes del periodo en lenguaje sencillo.',
                '[EXTENSION]' => 'Caracteres o líneas que permite el boletín.',
            ],
            'prompt' => 'Actúa como docente de inglés colombiano con excelente comunicación con familias. Escribes informes claros, cálidos y concretos, sin jerga pedagógica ni técnica.

CONTEXTO
- Aprendizajes del periodo: [DBA_PERIODO]
- Desempeño: [VALORACION] (escala del Decreto 1290).
- Mis notas sobre el estudiante: [NOTAS_DOCENTE]
- Extensión máxima: [EXTENSION].

TAREA
Redacta el informe en español con: 1) un logro concreto (qué puede hacer en inglés ahora, con ejemplo); 2) un aspecto por mejorar, explicado sin culpas; 3) dos acciones que la familia puede hacer en casa aunque no sepa inglés; 4) una frase de reconocimiento al esfuerzo.

RESTRICCIONES
- No uses palabras como «flojo», «perezoso», «no le gusta»; describe conductas observables.
- No menciones diagnósticos ni información sensible.
- No prometas resultados.
- Respeta la extensión máxima.

AUTOVERIFICACIÓN
Comprueba que todo lo afirmado salga de mis notas, que el tono sea respetuoso y que el informe quepa en [EXTENSION]. Reporta el conteo de caracteres.',
            'seguimientos' => [
                'Ahora genera la versión para 5 estudiantes con estas notas (te las pego numeradas), manteniendo el mismo formato pero sin frases repetidas entre informes.',
                'Haz una versión más corta, de máximo 250 caracteres, para la plataforma de notas.',
            ],
            'ejemplo' => [
                'contexto' => '[VALORACION] Básico · [DBA_PERIODO] presentarse, describir su rutina y entender textos cortos sobre rutinas · [NOTAS_DOCENTE] participa en juegos orales y pronuncia bien; no entrega tareas escritas; se distrae con el celular · [EXTENSION] 600 caracteres.',
                'resultado_html' => '<p>Durante este periodo, el estudiante logró presentarse en inglés y contar su rutina en voz alta con buena pronunciación; participa con entusiasmo en las actividades orales. Necesita fortalecer la escritura: entregó pocas de las tareas escritas, que son clave para consolidar lo aprendido. En casa pueden ayudarle así: 1) acordar un horario fijo de 20 minutos sin celular para las tareas de inglés y 2) pedirle que les cuente en inglés su rutina mientras ustedes la siguen con las palabras de su cuaderno. Reconocemos su buena actitud en clase. (542 caracteres)</p>',
            ],
            'revisar' => [
                'Que nada del informe contradiga sus notas.',
                'Que no se incluya información sensible.',
                'Que no haya frases idénticas entre informes de diferentes estudiantes.',
            ],
        ],
        [
            'id' => 'ING-24',
            'categoria' => 'gestion',
            'titulo' => 'Guía para familias: apoyar el inglés en casa sin saber inglés',
            'grados' => 'Transición a 9.°',
            'tiempo_ahorrado' => '≈ 30 min',
            'cuando' => 'Al iniciar el año o en una reunión de padres, cuando quiere entregar a las familias estrategias concretas y gratuitas para acompañar el aprendizaje del inglés.',
            'variables' => [
                '[GRADOS]' => 'Grados a los que va dirigida.',
                '[CONTEXTO_FAMILIAS]' => 'Realidad de las familias (horarios, acceso a internet, televisión, radio, nivel educativo).',
                '[TEMAS_ANIO]' => 'Temas principales del año.',
            ],
            'prompt' => 'Actúa como docente de inglés y orientador familiar, experto en comunicación con familias colombianas de diversos contextos socioeconómicos.

CONTEXTO
- Grados: [GRADOS]. Realidad de las familias: [CONTEXTO_FAMILIAS]. Temas del año: [TEMAS_ANIO].

TAREA
1. Escribe una guía de una página en español sencillo: por qué el inglés importa (sin exagerar), qué se aprenderá este año y 8 estrategias concretas para hacer en casa.
2. Cada estrategia: nombre, cómo se hace (3 pasos), cuánto tiempo toma y qué necesita (debe ser gratis o casi).
3. Incluye estrategias para familias sin internet (radio, rotular objetos, canciones, juegos con tarjetas).
4. Cierra con 3 frases que la familia NO debe decir (por ejemplo, «yo nunca aprendí inglés, eso no es para nosotros») y qué decir en su lugar.

RESTRICCIONES
- Nada de recomendaciones de aplicaciones de pago ni de plataformas que pidan datos de menores.
- Tono respetuoso, sin culpar a las familias.
- Lenguaje para un adulto con primaria completa.

AUTOVERIFICACIÓN
Revisa que todas las estrategias sean gratuitas, posibles sin saber inglés y realizables en máximo 15 minutos. Reporta.',
            'seguimientos' => [
                'Convierte la guía en un guion de 5 minutos para presentarla en la reunión de padres.',
                'Haz una versión de la guía en formato de mensaje de WhatsApp, en 4 mensajes cortos.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADOS] 4.° y 5.° · [CONTEXTO_FAMILIAS] familias trabajadoras de Soacha; la mayoría con celular prepago y televisión; poco tiempo en la semana · [TEMAS_ANIO] familia, rutinas, lugares del barrio, comida.',
                'resultado_html' => '<p><strong>Estrategia 1. La casa con nombre.</strong> 1) Con su hijo, escriban en papelitos el nombre en inglés de 10 objetos de la casa (lo trae del cuaderno). 2) Péguenlos en los objetos. 3) Cada noche, pídale que le «presente» 3 objetos. <em>5 minutos · papel y cinta.</em></p> <p><strong>Estrategia 2. El mercado en inglés.</strong> 1) Antes de ir a la tienda, su hijo escribe la lista en inglés. 2) En la tienda, le pide a usted los productos por su nombre en inglés. 3) Usted le pregunta «¿cómo se dice…?» por uno nuevo. <em>10 minutos · lista del mercado.</em></p> <p><strong>No diga:</strong> «Yo nunca aprendí inglés, eso no es para nosotros». <strong>Diga:</strong> «Yo no sé inglés, pero quiero que me enseñes lo que aprendiste hoy.»</p>',
            ],
            'revisar' => [
                'Que todas las estrategias sean gratuitas y viables en su comunidad.',
                'Que el lenguaje sea claro para todas las familias.',
                'Que no se recomienden apps que pidan registro de menores.',
            ],
        ],
        [
            'id' => 'ING-25',
            'categoria' => 'gestion',
            'titulo' => 'Análisis de resultados de simulacro o Saber 11 por partes y plan de mejoramiento',
            'grados' => '9.° a 11.°',
            'tiempo_ahorrado' => '≈ 2 h',
            'cuando' => 'Después de un simulacro o al recibir los resultados institucionales, cuando quiere convertir porcentajes por parte en decisiones de enseñanza para las próximas semanas.',
            'variables' => [
                '[RESULTADOS]' => 'Resultados agregados del grupo: porcentaje de acierto por parte o por ítem, distribución por niveles (A-, A1, A2, B1, B+). Sin nombres.',
                '[GRADO]' => 'Grado.',
                '[SEMANAS]' => 'Semanas disponibles antes de la prueba o del cierre.',
                '[HORAS]' => 'Horas semanales.',
                '[HISTORICO]' => 'Resultados de años anteriores si los tiene.',
            ],
            'prompt' => 'Actúa como analista de evaluación educativa experto en la prueba de inglés de Saber 11 y en planes de mejoramiento para colegios oficiales colombianos.

CONTEXTO
- Grado [GRADO]. Resultados agregados: [RESULTADOS]
- Histórico: [HISTORICO]
- Tiempo disponible: [SEMANAS] semanas, [HORAS] horas semanales.

TAREA
1. Describe los resultados: partes con mayor y menor acierto, distribución por niveles, y qué porcentaje del grupo está en A- y A1.
2. Interpreta: qué conocimiento o habilidad explica cada resultado bajo (léxico, gramática, lectura literal, inferencia, pragmática), formulando hipótesis prudentes, no certezas.
3. Prioriza 3 focos de trabajo con mayor impacto, justificando por qué esos y no otros.
4. Diseña un plan de [SEMANAS] semanas: foco, actividad de enseñanza (no solo más simulacros), práctica tipo prueba y evidencia de avance.
5. Propón metas realistas e indicadores para el próximo simulacro.

RESTRICCIONES
- No inventes datos: usa solo los resultados pegados.
- Máximo 30 % del tiempo en práctica tipo prueba; el resto en enseñanza de lengua.
- Sin comparaciones entre estudiantes con nombre.

AUTOVERIFICACIÓN
Comprueba que cada afirmación descriptiva tenga un número de los resultados detrás y que el plan cumpla la regla del 30 %. Reporta.',
            'seguimientos' => [
                'Redacta un resumen de media página para presentar al consejo académico.',
                'Diseña la clase de la semana 1 para el foco prioritario.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 11.° (dos cursos, 68 estudiantes) · [RESULTADOS] simulacro: avisos 72 %, léxico 61 %, conversaciones 48 %, texto incompleto gramatical 41 %, comprensión literal 55 %, comprensión inferencial 33 %, texto incompleto léxico-gramatical 36 %; niveles: A- 18 %, A1 44 %, A2 29 %, B1 9 % · [SEMANAS] 8 · [HORAS] 3.',
                'resultado_html' => '<p><strong>Descripción:</strong> el 62 % del grupo está en A- o A1. El mejor desempeño está en avisos (72 %) y léxico (61 %); los más bajos, en comprensión inferencial (33 %), texto incompleto léxico-gramatical (36 %) y gramatical (41 %).</p> <p><strong>Hipótesis:</strong> el grupo reconoce vocabulario aislado pero tiene dificultades cuando el significado depende de la estructura de la oración y de relaciones entre oraciones (conectores, referencias, tiempos verbales). Conversaciones (48 %) sugiere poca exposición a lenguaje funcional y respuestas pragmáticas (<em>Never mind, I\'d rather not, Sure, go ahead</em>).</p> <p><strong>Focos:</strong> 1) gramática en contexto: tiempos verbales y conectores (impacta dos partes); 2) lectura inferencial: referencias y propósito del autor; 3) lenguaje funcional de conversaciones cotidianas.</p> <table> <tr><th>Semana</th><th>Foco</th><th>Enseñanza</th><th>Práctica tipo prueba</th></tr> <tr><td>1–2</td><td>Tiempos verbales y conectores</td><td>Descubrimiento guiado con textos cortos (receta ING-10)</td><td>8 ítems de texto incompleto</td></tr> <tr><td>3–4</td><td>Inferencia</td><td>Modelado de lectura en voz alta: «¿cómo sé que…?»</td><td>1 texto con 5 preguntas</td></tr> </table> <p><strong>Meta:</strong> pasar de 18 % a menos de 10 % en A- y subir texto incompleto gramatical a 50 % en el próximo simulacro.</p>',
            ],
            'revisar' => [
                'Que todas las cifras del análisis coincidan con las que pegó.',
                'Que las hipótesis se presenten como hipótesis.',
                'Que el plan priorice enseñanza y no solo simulacros.',
                'Que los nombres de las partes coincidan con la guía vigente del ICFES.',
            ],
        ],
        [
            'id' => 'ING-26',
            'categoria' => 'gestion',
            'titulo' => 'Rutinas, classroom language y dinámicas para grupos grandes sin recursos',
            'grados' => '4.° a 11.°',
            'tiempo_ahorrado' => '≈ 30 min',
            'cuando' => 'Cuando tiene 40 o más estudiantes, pupitres fijos y poco tiempo, y necesita rutinas en inglés y dinámicas que mantengan a todos activos sin perder el control del grupo.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[N_ESTUDIANTES]' => 'Número de estudiantes.',
                '[ESPACIO]' => 'Características del salón (pupitres fijos, calor, ruido de la calle).',
                '[PROBLEMAS]' => 'Situaciones difíciles (inicio lento, ruido en trabajo en parejas, pocos participan).',
                '[NIVEL_MCER]' => 'Nivel.',
            ],
            'prompt' => 'Actúa como docente de inglés con amplia experiencia en grupos numerosos de colegios oficiales colombianos y en gestión de aula positiva.

CONTEXTO
- Grado [GRADO], [N_ESTUDIANTES] estudiantes, nivel [NIVEL_MCER].
- Espacio: [ESPACIO]. Situaciones difíciles: [PROBLEMAS].

TAREA
1. Rutinas de inicio, transición y cierre en inglés (frases exactas del docente y respuesta esperada de los estudiantes), que se puedan aprender en dos semanas.
2. Un banco de 20 frases de classroom language para los estudiantes (pedir permiso, pedir repetir, preguntar cómo se dice), organizado por situación, para pegar en la pared.
3. 6 dinámicas de 5 a 10 minutos que funcionen con [N_ESTUDIANTES] estudiantes en pupitres fijos, sin materiales, con participación simultánea (no turnos de uno en uno).
4. Señales no verbales para pedir silencio y para trabajo en parejas.
5. Estrategias para que hablen en inglés en el trabajo en parejas sin pasarse al español.

RESTRICCIONES
- Nada que requiera mover pupitres ni salir del salón.
- Dinámicas que no expongan a los estudiantes a burlas.
- Lengua dentro de [NIVEL_MCER].

AUTOVERIFICACIÓN
Comprueba que cada dinámica tenga participación simultánea de todo el grupo y una regla de control del ruido. Reporta.',
            'seguimientos' => [
                'Diseña un sistema de puntos por filas (no individual) para motivar el uso del inglés durante un periodo.',
                'Escribe el póster de classroom language en dos versiones: con dibujos para primaria y sin dibujos para secundaria.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 7.° · [N_ESTUDIANTES] 44 · [ESPACIO] pupitres en filas, mucho calor después del recreo · [PROBLEMAS] tardan 10 minutos en empezar; ruido excesivo en parejas · [NIVEL_MCER] A1-A2.',
                'resultado_html' => '<p><strong>Rutina de inicio (2 min):</strong> Docente: <em>"Good morning, class! Three things on your desk: notebook, pencil, English book."</em> Estudiantes: <em>"Ready, teacher!"</em> El docente cuenta en voz baja <em>five, four, three…</em> y las filas listas ganan un punto.</p> <p><strong>Dinámica «Stand up if…» (5 min):</strong> <em>Stand up if you have a dog. Stand up if you ate arepa today.</em> Todos responden con el cuerpo al tiempo; luego un estudiante por fila dice una oración nueva. Control de ruido: quien hable en español se sienta.</p> <p><strong>Dinámica «Row dictation» (10 min):</strong> el primer estudiante de cada fila lee una oración del tablero, la susurra al de atrás y así hasta el último, que la escribe; gana la fila con la oración correcta. Regla: solo se susurra.</p> <p><strong>Señal de silencio:</strong> mano arriba + <em>"Hands up, voices off"</em>; los estudiantes levantan la mano y callan.</p>',
            ],
            'revisar' => [
                'Que las dinámicas no requieran mover pupitres.',
                'Que no haya actividades que expongan individualmente a estudiantes tímidos.',
                'Que las frases de rutina sean naturales y correctas.',
            ],
        ],
        [
            'id' => 'ING-27',
            'categoria' => 'planeacion',
            'titulo' => 'Clase de uso crítico de la IA: los estudiantes detectan errores en un texto generado',
            'grados' => '9.° a 11.°',
            'tiempo_ahorrado' => '≈ 50 min',
            'cuando' => 'Cuando sus estudiantes ya usan IA para las tareas de inglés y quiere enseñarles a usarla críticamente: detectar errores, sesgos y datos falsos, y distinguir ayuda de suplantación.',
            'variables' => [
                '[GRADO]' => 'Grado.',
                '[NIVEL_MCER]' => 'Nivel.',
                '[TEMA]' => 'Tema del texto.',
                '[N_ERRORES]' => 'Número de errores a sembrar (5 a 8).',
                '[POLITICA_IA]' => 'Política institucional de uso de IA (si existe).',
            ],
            'prompt' => 'Actúa como docente de inglés experto en alfabetización mediática e informacional y en uso ético de la inteligencia artificial en la escuela.

CONTEXTO
- Grado [GRADO], nivel [NIVEL_MCER]. Tema: [TEMA].
- Política institucional sobre IA: [POLITICA_IA].

TAREA
1. Escribe un texto de 180 a 220 palabras en inglés, como si lo hubiera generado una IA, sobre [TEMA], con [N_ERRORES] errores sembrados de distinto tipo: 2 datos falsos sobre Colombia, 2 errores gramaticales, 1 palabra fuera de contexto y 1 sesgo o estereotipo.
2. Entrega aparte la clave de errores (solo para el docente) con la corrección y el tipo de error.
3. Diseña la clase: los estudiantes, en grupos, leen el texto, buscan los errores con una lista de verificación y verifican datos con fuentes (libro, docente, enciclopedia).
4. Elabora la lista de verificación para estudiantes (5 preguntas en inglés sencillo).
5. Cierra con una discusión sobre cuándo usar IA es ayuda y cuándo es hacer trampa, y con la construcción de 5 acuerdos del grupo sobre uso de IA en inglés.

RESTRICCIONES
- Los datos falsos deben ser verificables por los estudiantes con recursos del colegio.
- El estereotipo debe ser evidente y servir para discutir, no para ofender.
- Coherente con la política institucional.

AUTOVERIFICACIÓN
Comprueba que el texto contiene exactamente [N_ERRORES] errores y que, fuera de ellos, todo es correcto. Reporta.',
            'seguimientos' => [
                'Diseña una rúbrica corta para valorar el trabajo de los grupos en la detección de errores.',
                'Escribe una carta a las familias explicando los acuerdos de uso de IA construidos con el grupo.',
            ],
            'ejemplo' => [
                'contexto' => '[GRADO] 10.° · [NIVEL_MCER] B1 · [TEMA] Gabriel García Márquez · [N_ERRORES] 6 · [POLITICA_IA] se permite la IA para practicar, no para entregar textos como propios.',
                'resultado_html' => '<p><strong>Fragmento del texto con errores sembrados:</strong> <em>Gabriel García Márquez was born in Barranquilla <strong>[dato falso: nació en Aracataca, Magdalena]</strong> in 1927. He win <strong>[gramática: won]</strong> the Nobel Prize in Literature in 1982. His most famous novel, One Hundred Years of Solitude, is about the Buendía family in the fictional town of Macondo. Like all Colombians, he loved coffee and dancing <strong>[estereotipo]</strong>…</em></p> <p><strong>Lista de verificación (estudiantes):</strong> 1. Are the dates and places correct? Check them. 2. Are the verbs in the correct tense? 3. Is any word strange in this context? 4. Does the text say something about a whole group of people? 5. Would you use this text as your own? Why or why not?</p> <p><strong>Acuerdos de ejemplo:</strong> <em>We use AI to practice and to check ideas, not to write our homework. We always check facts with another source.</em></p>',
            ],
            'revisar' => [
                'Que la clave de errores esté completa y que el resto del texto no tenga errores accidentales.',
                'Que los datos verdaderos (fechas, lugares) estén verificados.',
                'Que los acuerdos coincidan con el manual de convivencia y la política institucional.',
            ],
        ],
    ],
    'cadenas' => [
        [
            'titulo' => 'Unidad completa en una tarde de planeación',
            'objetivo' => 'Pasar de los DBA del periodo a una unidad lista para enseñar y evaluar: malla, clase, materiales, evaluación oral y autoevaluación.',
            'pasos' => [
                [
                    'paso' => 'Ubique los DBA en las semanas del periodo según el nivel real del grupo.',
                    'receta' => 'ING-04',
                    'nota' => 'Haga antes la prueba diagnóstica (ING-14) si es inicio de año.',
                ],
                [
                    'paso' => 'Planee la primera clase de la unidad desde el DBA.',
                    'receta' => 'ING-01',
                    'nota' => 'Use la tabla de la malla como contexto en el mismo chat.',
                ],
                [
                    'paso' => 'Prepare el vocabulario en contexto con pronunciación.',
                    'receta' => 'ING-06',
                    'nota' => 'Pida que el vocabulario coincida con el de la clase planeada.',
                ],
                [
                    'paso' => 'Escriba la lectura de la unidad en tres niveles.',
                    'receta' => 'ING-05',
                    'nota' => 'Entregue datos verificados; no deje que la IA aporte los hechos.',
                ],
                [
                    'paso' => 'Diseñe la evaluación oral del cierre de unidad.',
                    'receta' => 'ING-13',
                    'nota' => 'Comparta la rúbrica con los estudiantes desde la primera semana.',
                ],
                [
                    'paso' => 'Cierre con autoevaluación y coevaluación.',
                    'receta' => 'ING-18',
                    'nota' => 'Use los resultados para decidir qué se retoma.',
                ],
            ],
        ],
        [
            'titulo' => 'Preparación de la prueba de inglés de Saber 11 en 8 semanas',
            'objetivo' => 'Mejorar el desempeño en las partes más débiles enseñando lengua, no solo repitiendo simulacros.',
            'pasos' => [
                [
                    'paso' => 'Analice los resultados del último simulacro por partes y niveles.',
                    'receta' => 'ING-25',
                    'nota' => 'Solo datos agregados, sin nombres.',
                ],
                [
                    'paso' => 'Enseñe las estructuras que explican los resultados bajos.',
                    'receta' => 'ING-10',
                    'nota' => 'Use errores reales de sus estudiantes.',
                ],
                [
                    'paso' => 'Practique lectura literal, inferencial y crítica.',
                    'receta' => 'ING-12',
                    'nota' => 'Textos sobre temas colombianos actuales.',
                ],
                [
                    'paso' => 'Construya ítems propios por tipo de tarea y verifíquelos.',
                    'receta' => 'ING-11',
                    'nota' => 'Resuelva cada ítem sin clave antes de aplicarlo.',
                ],
                [
                    'paso' => 'Informe avances a familias y estudiantes.',
                    'receta' => 'ING-23',
                    'nota' => 'Enfoque en lo que cada estudiante puede hacer ahora.',
                ],
            ],
        ],
        [
            'titulo' => 'Una clase inclusiva de principio a fin',
            'objetivo' => 'Diseñar una clase accesible para todos y con ajustes razonables para quienes tienen PIAR, sin bajar la meta de aprendizaje.',
            'pasos' => [
                [
                    'paso' => 'Planee la clase desde el DBA.',
                    'receta' => 'ING-01',
                    'nota' => 'Declare en las características del grupo la diversidad real, sin nombres.',
                ],
                [
                    'paso' => 'Rediseñe la clase con los tres principios del DUA.',
                    'receta' => 'ING-19',
                    'nota' => 'Mismo objetivo, diferentes caminos.',
                ],
                [
                    'paso' => 'Ajuste materiales y evaluación según el PIAR.',
                    'receta' => 'ING-20',
                    'nota' => 'Es un borrador para la reunión con la familia y el docente de apoyo.',
                ],
                [
                    'paso' => 'Prepare la lectura en el nivel adecuado para cada estudiante.',
                    'receta' => 'ING-05',
                    'nota' => 'La versión A1 con imágenes suele servir como apoyo PIAR.',
                ],
            ],
        ],
        [
            'titulo' => 'Ciclo de escritura: de la consigna al plan de apoyo',
            'objetivo' => 'Convertir una tarea de escritura en aprendizaje real: texto modelo, retroalimentación con códigos, reescritura y apoyo a quienes no alcanzan el desempeño.',
            'pasos' => [
                [
                    'paso' => 'Diseñe la consigna, el texto modelo y el marco de planeación.',
                    'receta' => 'ING-15',
                    'nota' => 'Muestre también un modelo de nivel Básico para comparar.',
                ],
                [
                    'paso' => 'Retroalimente con códigos de error, sin reescribir.',
                    'receta' => 'ING-16',
                    'nota' => 'Transcriba los textos sin nombres.',
                ],
                [
                    'paso' => 'Haga que los estudiantes se autoevalúen tras la reescritura.',
                    'receta' => 'ING-18',
                    'nota' => 'Compare primera y segunda versión.',
                ],
                [
                    'paso' => 'Diseñe el plan de apoyo para quienes siguen en Bajo.',
                    'receta' => 'ING-22',
                    'nota' => 'Base el plan en las evidencias recogidas.',
                ],
                [
                    'paso' => 'Informe a la familia.',
                    'receta' => 'ING-23',
                    'nota' => 'Incluya acciones concretas para casa.',
                ],
            ],
        ],
    ],
    'rubricas' => [
        [
            'titulo' => 'Expresión oral: monólogo e interacción (8.° a 11.°, A2-B1)',
            'criterios' => [
                [
                    'criterio' => 'Cumplimiento de la tarea',
                    'niveles' => [
                        'Superior' => 'Cubre todos los puntos de la tarea con detalles y ejemplos pertinentes; adapta el mensaje al interlocutor.',
                        'Alto' => 'Cubre todos los puntos con información suficiente, aunque con pocos detalles.',
                        'Básico' => 'Cubre la mayoría de los puntos de forma breve; necesita apoyo del evaluador para completar.',
                        'Bajo' => 'Cubre uno o ningún punto; la respuesta no corresponde a la tarea.',
                    ],
                ],
                [
                    'criterio' => 'Fluidez y coherencia',
                    'niveles' => [
                        'Superior' => 'Habla con ritmo continuo, con pausas naturales; organiza ideas con conectores variados (first, however, so, because).',
                        'Alto' => 'Habla de forma comprensible con algunas pausas para buscar palabras; usa conectores básicos.',
                        'Básico' => 'Produce frases cortas con pausas frecuentes; ideas sueltas con and/but.',
                        'Bajo' => 'Produce palabras aisladas o frases memorizadas; no logra sostener el discurso.',
                    ],
                ],
                [
                    'criterio' => 'Precisión gramatical y léxica',
                    'niveles' => [
                        'Superior' => 'Usa con control las estructuras del nivel; los errores no afectan la comprensión; vocabulario variado y preciso para el tema.',
                        'Alto' => 'Usa correctamente las estructuras básicas; comete errores en las más complejas sin afectar el mensaje.',
                        'Básico' => 'Errores frecuentes en estructuras básicas que a veces dificultan la comprensión; vocabulario limitado.',
                        'Bajo' => 'Errores constantes que impiden entender el mensaje; vocabulario insuficiente para la tarea.',
                    ],
                ],
                [
                    'criterio' => 'Pronunciación e inteligibilidad',
                    'niveles' => [
                        'Superior' => 'Siempre inteligible; acentuación y entonación apoyan el significado. El acento colombiano no se penaliza.',
                        'Alto' => 'Inteligible casi siempre; algunos errores de sonidos que no afectan la comprensión.',
                        'Básico' => 'Requiere esfuerzo del oyente en algunos momentos; errores en sonidos clave.',
                        'Bajo' => 'Difícil de entender la mayor parte del tiempo.',
                    ],
                ],
                [
                    'criterio' => 'Interacción',
                    'niveles' => [
                        'Superior' => 'Inicia, responde y mantiene la conversación; pide aclaración y negocia acuerdos.',
                        'Alto' => 'Responde y hace preguntas; contribuye al acuerdo con algunas dudas.',
                        'Básico' => 'Responde cuando se le pregunta; rara vez inicia.',
                        'Bajo' => 'No logra interactuar sin traducción o apoyo constante.',
                    ],
                ],
            ],
        ],
        [
            'titulo' => 'Producción escrita: textos funcionales (6.° a 11.°, A1-B1)',
            'criterios' => [
                [
                    'criterio' => 'Propósito y contenido',
                    'niveles' => [
                        'Superior' => 'Cumple el propósito y todos los puntos de la consigna con información relevante y desarrollada.',
                        'Alto' => 'Cumple el propósito y los puntos de la consigna con desarrollo suficiente.',
                        'Básico' => 'Cumple parcialmente: omite un punto o lo desarrolla muy poco.',
                        'Bajo' => 'No cumple el propósito o el texto no corresponde a la consigna.',
                    ],
                ],
                [
                    'criterio' => 'Organización y cohesión',
                    'niveles' => [
                        'Superior' => 'Párrafos claros, fórmulas de apertura y cierre propias del género y conectores variados.',
                        'Alto' => 'Texto organizado con conectores básicos y fórmulas del género.',
                        'Básico' => 'Organización simple, ideas listadas con poca conexión.',
                        'Bajo' => 'Ideas sueltas sin orden reconocible.',
                    ],
                ],
                [
                    'criterio' => 'Gramática',
                    'niveles' => [
                        'Superior' => 'Control de las estructuras del nivel; errores escasos que no afectan el sentido.',
                        'Alto' => 'Uso correcto de estructuras básicas; algunos errores en las de mayor complejidad.',
                        'Básico' => 'Errores frecuentes en estructuras trabajadas en la unidad; el mensaje se entiende con esfuerzo.',
                        'Bajo' => 'Errores que impiden comprender la mayor parte del texto.',
                    ],
                ],
                [
                    'criterio' => 'Vocabulario y ortografía',
                    'niveles' => [
                        'Superior' => 'Vocabulario variado y pertinente al tema; ortografía casi sin errores.',
                        'Alto' => 'Vocabulario adecuado con alguna repetición; pocos errores de ortografía.',
                        'Básico' => 'Vocabulario limitado y repetitivo; errores de ortografía frecuentes.',
                        'Bajo' => 'Vocabulario insuficiente; uso de español para suplir palabras.',
                    ],
                ],
            ],
        ],
        [
            'titulo' => 'Proyecto de aula en inglés (ABP, 8.° a 11.°)',
            'criterios' => [
                [
                    'criterio' => 'Proceso y cumplimiento de hitos',
                    'niveles' => [
                        'Superior' => 'Entrega todos los hitos a tiempo con evidencias completas y mejora a partir de la retroalimentación.',
                        'Alto' => 'Entrega casi todos los hitos a tiempo; incorpora la mayor parte de la retroalimentación.',
                        'Básico' => 'Entrega algunos hitos con retraso o incompletos.',
                        'Bajo' => 'No entrega la mayoría de los hitos.',
                    ],
                ],
                [
                    'criterio' => 'Uso del inglés en el producto',
                    'niveles' => [
                        'Superior' => 'El producto usa la lengua meta de la unidad con precisión y adecuación a la audiencia.',
                        'Alto' => 'Usa la lengua meta con errores que no afectan el mensaje.',
                        'Básico' => 'Usa parcialmente la lengua meta; el mensaje requiere apoyo en español.',
                        'Bajo' => 'El producto está mayoritariamente en español o no usa la lengua meta.',
                    ],
                ],
                [
                    'criterio' => 'Respuesta a la pregunta orientadora',
                    'niveles' => [
                        'Superior' => 'El producto responde la pregunta con una propuesta viable y argumentada para el problema local.',
                        'Alto' => 'El producto responde la pregunta con una propuesta clara.',
                        'Básico' => 'La relación con la pregunta es parcial.',
                        'Bajo' => 'El producto no se relaciona con la pregunta.',
                    ],
                ],
                [
                    'criterio' => 'Trabajo en equipo',
                    'niveles' => [
                        'Superior' => 'Cumple su rol y apoya a otros; la coevaluación lo confirma.',
                        'Alto' => 'Cumple su rol de forma responsable.',
                        'Básico' => 'Cumple su rol de forma intermitente.',
                        'Bajo' => 'No asume su rol.',
                    ],
                ],
            ],
        ],
        [
            'titulo' => 'Participación y comprensión en primaria (transición a 5.°)',
            'criterios' => [
                [
                    'criterio' => 'Comprensión oral',
                    'niveles' => [
                        'Superior' => 'Comprende instrucciones y preguntas sencillas sin gestos de apoyo y responde de inmediato.',
                        'Alto' => 'Comprende instrucciones y preguntas con apoyo de gestos o imágenes.',
                        'Básico' => 'Comprende algunas palabras y responde imitando a sus compañeros.',
                        'Bajo' => 'Aún no muestra comprensión de instrucciones ni del vocabulario trabajado.',
                    ],
                ],
                [
                    'criterio' => 'Producción oral',
                    'niveles' => [
                        'Superior' => 'Dice palabras y frases del tema sin modelo y las usa en juegos y rutinas.',
                        'Alto' => 'Dice palabras y frases con un modelo previo.',
                        'Básico' => 'Repite algunas palabras después del docente.',
                        'Bajo' => 'Aún no produce palabras del tema.',
                    ],
                ],
                [
                    'criterio' => 'Participación en rutinas, cantos y juegos',
                    'niveles' => [
                        'Superior' => 'Participa con entusiasmo y anima a otros.',
                        'Alto' => 'Participa activamente en la mayoría de actividades.',
                        'Básico' => 'Participa cuando se le invita directamente.',
                        'Bajo' => 'Participa muy poco aun con invitación y apoyo.',
                    ],
                ],
            ],
        ],
    ],
    'errores' => [
        [
            'error' => 'Desajuste de nivel: textos o tareas por encima (o por debajo) del nivel MCER pedido, por ejemplo present perfect continuous o vocabulario C1 en un texto «A2».',
            'como_detectarlo' => 'Lea el texto pensando en su estudiante promedio; subraye palabras que usted mismo tuvo que aprender después de A2. Revise oraciones de más de 15 palabras y tiempos compuestos en textos A1-A2.',
            'como_corregirlo' => 'Exija en el prompt que marque con (*) lo que supere el nivel y pida «reescribe sin ninguna palabra marcada». Use la autoverificación de las recetas.',
        ],
        [
            'error' => 'Referencias culturales ajenas: Thanksgiving, prom, school bus amarillo, baseball, precios en dólares, nombres como Jake y Ashley en contextos que deberían ser locales.',
            'como_detectarlo' => 'Busque nombres, fiestas, comidas y monedas; pregúntese si un estudiante de su municipio entendería la situación sin explicación cultural.',
            'como_corregirlo' => 'Indique en el prompt el municipio, nombres colombianos y la moneda en pesos; use el banco de contextos de este kit.',
        ],
        [
            'error' => 'Explicaciones gramaticales falsas o reglas inventadas: «some solo en afirmativas», «will nunca va después de if», «el presente continuo no se usa para el futuro».',
            'como_detectarlo' => 'Desconfíe de las reglas absolutas («siempre», «nunca»). Contraste con una gramática pedagógica confiable (Cambridge, Oxford, Longman).',
            'como_corregirlo' => 'Pida a la IA «da excepciones frecuentes en este nivel» y «cita un ejemplo auténtico que contradiga la regla, si existe». Corrija la regla antes de enseñarla.',
        ],
        [
            'error' => 'Claves de respuesta con errores o ítems con dos respuestas correctas en selección múltiple.',
            'como_detectarlo' => 'Resuelva cada ítem usted mismo sin mirar la clave. Revise especialmente los ítems de preposiciones, tiempos verbales y respuestas en conversaciones.',
            'como_corregirlo' => 'Pida la autoverificación «resuelve sin clave» y la justificación de cada distractor. Reescriba o anule los ítems ambiguos.',
        ],
        [
            'error' => 'Traducciones engañosas de realidades colombianas: «tinto» como red wine, «arepa» como «corn tortilla», «buseta» como «van», «bandeja paisa» como «Paisa tray».',
            'como_detectarlo' => 'Revise cada producto, comida o lugar colombiano en el texto en inglés.',
            'como_corregirlo' => 'Mantenga el nombre en español en cursiva y explíquelo en inglés sencillo (a small cup of black coffee).',
        ],
        [
            'error' => 'Formato de Saber 11 equivocado: ítems de escucha (la prueba no tiene listening), número de opciones distinto o partes mezcladas.',
            'como_detectarlo' => 'Compare con la Guía de orientación del ICFES del año en curso.',
            'como_corregirlo' => 'Pegue en el prompt la descripción oficial de la parte que va a trabajar y pida que la respete exactamente.',
        ],
        [
            'error' => 'DBA, estándares o números de documentos inventados («DBA 7 de grado 8: …») o citas que no existen.',
            'como_detectarlo' => 'Busque el texto citado en el documento oficial. Si no aparece literal, es inventado.',
            'como_corregirlo' => 'Pegue siempre el texto literal del DBA y prohíba renumerarlo o reescribirlo.',
        ],
        [
            'error' => 'Datos falsos en lecturas sobre Colombia (fechas, cifras, nombres de lugares, récords deportivos).',
            'como_detectarlo' => 'Subraye cada dato verificable (número, fecha, nombre propio) y verifíquelo en una fuente confiable.',
            'como_corregirlo' => 'Entregue usted los datos verificados y pida «usa solo estos datos; si necesitas otro, escribe [POR CONFIRMAR]».',
        ],
        [
            'error' => 'Conteos de palabras y duraciones de audio incorrectos.',
            'como_detectarlo' => 'Cuente con el procesador de texto; lea el guion en voz alta con cronómetro.',
            'como_corregirlo' => 'Ajuste el texto usted mismo o pida «recorta a exactamente N palabras» y vuelva a contar.',
        ],
        [
            'error' => 'Transcripciones fonéticas (IPA) o «trucos» de pronunciación incorrectos que enseñan errores (por ejemplo, decir que la -ed siempre se pronuncia /ed/).',
            'como_detectarlo' => 'Compare con un diccionario de aprendices con audio.',
            'como_corregirlo' => 'Pida que marque [REVISAR] cuando no esté seguro y verifique usted las transcripciones antes de usarlas.',
        ],
        [
            'error' => 'Mezcla inconsistente de inglés británico y americano (colour/color, flat/apartment, have got) en un mismo material.',
            'como_detectarlo' => 'Busque pares típicos de ortografía y vocabulario.',
            'como_corregirlo' => 'Indique la variante en el prompt (o la de su texto guía) y pida mantenerla en todo el material.',
        ],
        [
            'error' => 'Reproducción de letras de canciones, fragmentos de libros o ítems publicados protegidos por derechos de autor, o recomendaciones de videos y enlaces que no existen.',
            'como_detectarlo' => 'Busque el texto o el enlace antes de usarlo; desconfíe de títulos muy específicos de videos.',
            'como_corregirlo' => 'Pida material original y busque usted los recursos externos en fuentes conocidas.',
        ],
    ],
    'banco_contextos' => [
        'Carnaval de Barranquilla: Batalla de Flores, disfraces, cumbia y marimondas.',
        'Feria de las Flores de Medellín y el desfile de silleteros de Santa Elena.',
        'Festival de la Leyenda Vallenata en Valledupar: acordeón, caja y guacharaca.',
        'Festival Petronio Álvarez en Cali: marimba de chonta y música del Pacífico.',
        'Una finca cafetera en el Quindío: cosecha, beneficiadero, secado y el tinto de la tarde.',
        'Caño Cristales en La Macarena (Meta) y las reglas para un turismo responsable.',
        'San Andrés, Providencia y Santa Catalina: la comunidad raizal y su lengua creole de base inglesa.',
        'Leticia y el Amazonas: animales de la selva, el río y las comunidades indígenas.',
        'La plaza de mercado del municipio: frutas, precios, pesos y medidas.',
        'La tienda de barrio: comprar, fiar, contar el cambio.',
        'La Terminal de Transportes: destinos, horarios y pasajes intermunicipales.',
        'TransMilenio, el Metro y el Metrocable de Medellín: moverse en la ciudad.',
        'La chiva rumbera de Cartagena y el turismo en la ciudad amurallada.',
        'El páramo de Sumapaz y los frailejones: agua para Bogotá.',
        'El desierto de la Tatacoa (Huila) y la observación de estrellas.',
        'Deportistas colombianos: Caterine Ibargüen (oro olímpico en salto triple, Río 2016) y Egan Bernal (Tour de Francia 2019).',
        'La literatura de Gabriel García Márquez: Aracataca, Macondo y el Nobel de 1982.',
        'Gastronomía regional: ajiaco, sancocho, arepas, bandeja paisa, mote de queso, viudo de pescado.',
        'La huerta escolar y el compostaje con residuos del restaurante escolar.',
        'La emisora escolar: noticias del colegio, entrevistas y campañas.',
        'Rutinas de estudiantes rurales: madrugar, caminar a la escuela, ayudar en la finca.',
        'El Día de la Antioqueñidad, el Día del Idioma y otras celebraciones del calendario escolar colombiano.',
        'Biodiversidad: Colombia como uno de los países con más especies de aves del mundo; avistamiento de aves.',
        'Reciclaje y recicladores de oficio en las ciudades colombianas.',
        'Partidos de la Selección Colombia y la pasión por el fútbol en el barrio.',
        'Música colombiana contemporánea: vallenato, champeta, salsa caleña y reguetón de Medellín (sin reproducir letras).',
        'El trabajo de los padres: mototaxistas, agricultores, comerciantes, docentes, enfermeras.',
        'Vacaciones en el río o la quebrada: paseo de olla y cuidado del agua.',
    ],
];
