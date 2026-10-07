<?php
declare(strict_types=1);
// Kit de IA para docentes: Matemáticas (Colombia). Contenido curado que lee el build del PDF y de prompts.txt.
return [
  'key' => 'matematicas',
  'name' => 'Matemáticas',
  'tagline' => 'Prompts probados, alineados con Estándares, DBA y pruebas Saber, para planear, evaluar e incluir en matemáticas sin que la IA te cuele un error de cálculo.',
  'intro_html' => <<<'TXT'
<p>Cualquier docente puede pedirle a una IA «hazme un taller de fracciones». El resultado suele parecer bueno hasta que lo revisas: una clave de respuestas equivocada, dos opciones correctas en la misma pregunta, un pasaje de bus a precio de 2015, 3,5 personas en un problema de reparto o un «DBA 7» que no existe. En matemáticas un solo error de cálculo frente al grupo cuesta credibilidad, y revisar con lupa todo lo que produce la IA puede tardar más que hacerlo a mano.</p>
<p>Este kit está hecho para evitar eso. Cada receta es un flujo de trabajo probado en aulas colombianas: un prompt estructurado (rol, contexto, tarea, formato, restricciones y verificación), las variables que debes llenar, dos o tres seguimientos para afinar el resultado, un ejemplo real de salida ya revisado por un experto y una lista de chequeo con los errores que la IA comete justamente en esa tarea. Los prompts obligan a la IA a mostrar cada operación, a recalcular la clave, a justificar cada distractor con el error de pensamiento que captura, a usar coma decimal y punto de miles, y a trabajar con precios y tarifas realistas de 2026 en pesos colombianos.</p>
<p>Todo está anclado a los referentes que usas en tu planeación y en tu SIEE: los cinco pensamientos y los cinco procesos de los Estándares Básicos de Competencias (2006), los Derechos Básicos de Aprendizaje v.2 (2016), las mallas de aprendizaje de 1.° a 5.°, las competencias y componentes de Saber 3.°, 5.°, 9.° y Saber 11, la escala del Decreto 1290 de 2009 y los ajustes razonables del Decreto 1421 de 2017. Los contextos no son genéricos: tienda del barrio, tarifas de TransMilenio, MIO o Metro de Medellín, recibos con estratos, cosecha de café, mercado campesino, ciclovía, molas y tejidos wayuu.</p>
<p>El kit se organiza así: referentes curriculares y cómo citarlos; un mapa por grupos de grados; 28 recetas agrupadas en planeación, evaluación, adaptación, recursos, retroalimentación y gestión; cuatro cadenas que combinan recetas en flujos completos (una unidad, un proyecto estadístico, la preparación de Saber y el aula inclusiva); cinco rúbricas con la escala Superior, Alto, Básico y Bajo; los doce errores típicos de la IA en matemáticas con la forma de detectarlos; y un banco de contextos colombianos para tus propios problemas. Cada receta indica cuánto tiempo ahorra en promedio, siempre contando el tiempo de revisión.</p>
TXT,
  'referentes_html' => <<<'TXT'
<h3>1. Estándares Básicos de Competencias en Matemáticas (MEN, 2006)</h3>
<p>Publicados por el Ministerio de Educación Nacional junto con los de Lenguaje, Ciencias y Ciudadanas, desarrollan los <em>Lineamientos Curriculares de Matemáticas</em> (1998). Se organizan en <strong>cinco grupos de grados</strong>: 1.° a 3.°, 4.° a 5.°, 6.° a 7.°, 8.° a 9.° y 10.° a 11.°. En cada grupo, los estándares se agrupan por <strong>cinco pensamientos</strong>:</p>
<table>
<tr><th>Pensamiento</th><th>Qué abarca</th></tr>
<tr><td>Numérico y sistemas numéricos</td><td>Sentido numérico, valor posicional, operaciones y sus propiedades, fracciones, decimales, enteros, racionales y reales.</td></tr>
<tr><td>Espacial y sistemas geométricos</td><td>Figuras y cuerpos, ubicación, transformaciones (traslaciones, rotaciones, reflexiones, homotecias), semejanza, congruencia, demostración.</td></tr>
<tr><td>Métrico y sistemas de medidas</td><td>Magnitudes, unidades, estimación, perímetro, área, volumen, precisión y error de medición.</td></tr>
<tr><td>Aleatorio y sistemas de datos</td><td>Recolección y representación de datos, medidas de tendencia central y dispersión, probabilidad, interpretación crítica de información.</td></tr>
<tr><td>Variacional y sistemas algebraicos y analíticos</td><td>Patrones, regularidades, proporcionalidad, ecuaciones, funciones, razones de cambio, nociones de cálculo.</td></tr>
</table>
<p>Los estándares también se apoyan en <strong>cinco procesos generales</strong> de la actividad matemática: <em>formular y resolver problemas</em>; <em>modelar procesos y fenómenos de la realidad</em>; <em>comunicar</em>; <em>razonar</em>; y <em>formular, comparar y ejercitar procedimientos</em>. El documento insiste en la <strong>coherencia vertical</strong> (cómo progresa un estándar de un grupo de grados al siguiente) y la <strong>coherencia horizontal</strong> (cómo se relaciona con los de otros pensamientos del mismo grupo). Úsalo así: un buen tema integra al menos dos pensamientos y explicita qué proceso se trabaja.</p>
<h3>2. Derechos Básicos de Aprendizaje (DBA) de Matemáticas, versión 2 (MEN, 2016)</h3>
<p>Los DBA v.2 están formulados <strong>grado por grado de 1.° a 11.°</strong>. Cada DBA tiene un enunciado, unas <strong>evidencias de aprendizaje</strong> y un <strong>ejemplo</strong>. No reemplazan los estándares: los concretan por grado. Para transición existen DBA propios (no por áreas), articulados con las <em>Bases curriculares para la educación inicial y preescolar</em>. A grandes rasgos, la progresión por contenidos es esta:</p>
<ul>
<li><strong>1.° a 3.°:</strong> conteo, agrupación y valor posicional; situaciones aditivas (juntar, quitar, comparar) y luego multiplicativas; medición con patrones no convencionales y convencionales; figuras y cuerpos; clasificación y tablas de datos sencillas.</li>
<li><strong>4.° y 5.°:</strong> fracciones en sus distintos significados, decimales en contextos de medida y dinero, multiplicación y división con naturales, área y perímetro, volumen, ángulos, gráficas de barras y circulares, nociones de probabilidad.</li>
<li><strong>6.° y 7.°:</strong> números enteros y racionales, proporcionalidad directa e inversa, porcentajes, expresiones algebraicas y ecuaciones sencillas, transformaciones en el plano, área y volumen, medidas de tendencia central.</li>
<li><strong>8.° y 9.°:</strong> números reales, expresiones algebraicas y productos notables, funciones lineales, cuadráticas y exponenciales, sistemas de ecuaciones, teorema de Pitágoras y semejanza, muestreo y probabilidad.</li>
<li><strong>10.° y 11.°:</strong> trigonometría y funciones trigonométricas, secciones cónicas, sucesiones, límites y razón de cambio, combinatoria y probabilidad condicional, análisis crítico de estudios estadísticos.</li>
</ul>
<p><strong>Importante:</strong> la IA suele inventar el número y la redacción de los DBA. En tu planeación copia el enunciado exacto desde tu ejemplar oficial y verifica el número antes de citarlo. Las recetas de este kit piden a la IA describir el DBA por su contenido y escribir «[POR CONFIRMAR]» en lugar del número.</p>
<h3>3. Mallas de aprendizaje (MEN, 2017)</h3>
<p>Lanzadas por el MEN en 2017 para <strong>1.° a 5.°</strong>, desarrollan los DBA con progresiones de aprendizaje, orientaciones didácticas, sugerencias de evaluación formativa y de uso de material. Son el mejor apoyo para primaria. Complementa con los materiales del <strong>Programa Todos a Aprender (PTA)</strong> que tenga tu sede (textos de matemáticas, guías de enseñanza y orientaciones del tutor PTA).</p>
<h3>4. Pruebas Saber (ICFES)</h3>
<table>
<tr><th>Prueba</th><th>Competencias</th><th>Componentes o contenidos</th></tr>
<tr><td>Saber 3.°, 5.° y 9.° Matemáticas</td><td>Comunicación, modelación y representación; razonamiento y argumentación; planteamiento y resolución de problemas.</td><td>Numérico-variacional; espacial-métrico; aleatorio.</td></tr>
<tr><td>Saber 11 Matemáticas</td><td>Interpretación y representación; formulación y ejecución; argumentación.</td><td>Contenidos <em>genéricos</em> (los que necesita cualquier ciudadano) y <em>no genéricos</em> (propios del trabajo matemático escolar), en tres categorías: estadística, geometría, y álgebra y cálculo.</td></tr>
</table>
<p>Los nombres de la tabla son los del marco de referencia de Matemáticas del ICFES (2020) y de las guías de orientación recientes; en reportes anteriores verás «comunicación, representación y modelación» y «geométrico-métrico» para lo mismo. Las preguntas son de selección múltiple con única respuesta y se plantean en contexto; en la guía de orientación de Saber 3.° (2022), por ejemplo, la pregunta de muestra trae cuatro opciones (A a D). Antes de elaborar ítems, revisa la guía de orientación del año para el grado: allí están el formato de las preguntas, ejemplos y la descripción de los niveles de desempeño.</p>
<h3>5. Evaluación e inclusión</h3>
<ul>
<li><strong>Decreto 1290 de 2009:</strong> cada institución define su Sistema Institucional de Evaluación de los Estudiantes (SIEE) y usa la escala nacional <strong>Desempeño Superior, Alto, Básico y Bajo</strong>. Básico significa la superación de los desempeños necesarios en relación con las áreas obligatorias y fundamentales, con referencia en los estándares y orientaciones del MEN y el PEI; Bajo, su no superación. La equivalencia numérica (por ejemplo, de 1,0 a 5,0) la fija tu SIEE, no el decreto.</li>
<li><strong>Decreto 1421 de 2017</strong> (compilado en el Decreto 1075 de 2015): reglamenta la atención educativa a la población con discapacidad, adopta el <strong>Diseño Universal para el Aprendizaje (DUA)</strong> y el <strong>Plan Individual de Ajustes Razonables (PIAR)</strong>, que se elabora con la familia y el estudiante y orienta ajustes en currículo, didáctica y evaluación sin bajar las metas a lo trivial.</li>
</ul>
<h3>6. Cómo citarlos en una planeación</h3>
<ul>
<li><strong>Estándar:</strong> «Pensamiento variacional y sistemas algebraicos y analíticos, 6.° a 7.°: <em>Analizo las propiedades de correlación positiva y negativa entre variables, de variación lineal o de proporcionalidad directa y de proporcionalidad inversa en contextos aritméticos y geométricos</em> (MEN, 2006)».</li>
<li><strong>DBA:</strong> «DBA de Matemáticas, grado 7.° (MEN, 2016, v.2), sobre relaciones de proporcionalidad directa e inversa. Enunciado copiado del documento oficial: [pegar]. Evidencia seleccionada: [pegar]».</li>
<li><strong>Saber:</strong> «Competencia: planteamiento y resolución de problemas. Componente: numérico-variacional (ICFES, guía de orientación Saber 9.° vigente)».</li>
<li><strong>Desempeños:</strong> redactados en tercera persona, observables y graduados con la escala del Decreto 1290 según tu SIEE.</li>
</ul>
TXT,
  'mapa' => [
    [
      'grados' => 'Transición a 3.°',
      'enfoque' => 'Construir sentido numérico y espacial desde lo concreto: contar, agrupar, comparar, medir y representar con objetos, dibujos y luego símbolos. La IA sirve para diseñar situaciones de juego y material, no para producir planas de ejercicios.',
      'claves' => [
        'Secuencia concreto, pictórico y abstracto en cada tema: primero tapas, regletas o ábaco; luego dibujos; al final el algoritmo.',
        'Valor posicional con agrupaciones de 10 (atados de palitos, bolsitas de 10 tapas) antes de la suma con reagrupación.',
        'Problemas aditivos de todos los tipos: cambio, combinación, comparación e igualación, no solo «juntar».',
        'Medición con patrones no convencionales (cuartas, pasos) antes del metro; comparar capacidades con envases reales.',
        'Datos del salón: conteos, tablas de conteo y pictogramas con preguntas que los niños sí quieren responder.',
      ],
    ],
    [
      'grados' => '4.° y 5.°',
      'enfoque' => 'Paso del pensamiento aditivo al multiplicativo y llegada de las fracciones y los decimales. Los contextos de dinero, mercado y medición le dan sentido a cada operación.',
      'claves' => [
        'Fracciones en sus significados: parte-todo, medida, cociente, razón y operador; usar tiras, tangram y recta numérica.',
        'Decimales ligados al dinero y la medida, cuidando la idea errónea de que «más cifras significa número mayor».',
        'Área y perímetro como magnitudes distintas: misma área con diferente perímetro en el geoplano.',
        'Gráficas de barras y circulares a partir de encuestas propias, con preguntas de lectura literal, inferencial y crítica.',
        'Preparación de Saber 5.° sin simulacros mecánicos: ítems con distractores que revelan errores típicos.',
      ],
    ],
    [
      'grados' => '6.° y 7.°',
      'enfoque' => 'Ampliación de los sistemas numéricos (enteros y racionales) y razonamiento proporcional, que es la bisagra entre la aritmética y el álgebra. Primeras transformaciones geométricas y medidas de tendencia central.',
      'claves' => [
        'Enteros con modelos de temperatura, deudas y altitud bajo el nivel del mar, cuidando la regla de signos sin sentido.',
        'Proporcionalidad directa e inversa con tablas de la tienda, recetas y escalas de mapas; detectar cuándo no hay proporcionalidad.',
        'Porcentajes en descuentos, IVA y subsidios de servicios públicos.',
        'Transformaciones rígidas y homotecias en molas, tejidos wayuu y pintas del sombrero vueltiao.',
        'Media, mediana y moda con datos reales del grupo y discusión de cuál representa mejor.',
      ],
    ],
    [
      'grados' => '8.° y 9.°',
      'enfoque' => 'Álgebra con sentido: expresiones, ecuaciones y funciones como herramientas para modelar situaciones de variación. Geometría deductiva (Pitágoras, semejanza) y estadística con muestras.',
      'claves' => [
        'Funciones lineales y afines en tarifas, recargas de transporte y temperatura según la altura.',
        'Productos notables y factorización verificados numéricamente para desmontar errores como (a + b)² = a² + b².',
        'Sistemas de ecuaciones en problemas de mezcla y de comparación de planes de celular o de datos.',
        'Pitágoras y semejanza en mediciones del colegio (sombras, rampas, escaleras).',
        'Proyecto estadístico completo con datos del colegio y preparación de Saber 9.°.',
      ],
    ],
    [
      'grados' => '10.° y 11.°',
      'enfoque' => 'Modelación con funciones (trigonométricas, exponenciales, cuadráticas), pensamiento estadístico crítico y educación financiera. Preparación de Saber 11 centrada en interpretar, formular y argumentar, no en memorizar fórmulas.',
      'claves' => [
        'Trigonometría en situaciones de medición indirecta (alturas, pendientes de vías, ángulo de elevación).',
        'Funciones cuadráticas y exponenciales con GeoGebra y deslizadores; interpretación de parámetros.',
        'Interés simple y compuesto, tasa efectiva anual, crédito formal frente al gota a gota.',
        'Lectura crítica de encuestas, gráficas engañosas y estudios publicados en medios.',
        'Ítems tipo Saber 11 con tabla o gráfica y opciones justificadas por errores frecuentes.',
      ],
    ],
  ],
  'recetas' => [
    [
      'id' => 'MAT-01',
      'categoria' => 'planeacion',
      'titulo' => 'Planeación de clase con estándar, DBA y evidencias de aprendizaje',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 45 min',
      'cuando' => 'Cuando tienes que entregar la planeación de una clase o de una semana y quieres que el estándar, el DBA y las evidencias realmente orienten las actividades, no que aparezcan copiados en el encabezado.',
      'variables' => [
        '[GRADO]' => 'Grado y número de estudiantes. Ej.: 7.°, 36 estudiantes.',
        '[TEMA]' => 'Tema o aprendizaje concreto. Ej.: proporcionalidad directa en tablas de precios.',
        '[ESTANDAR]' => 'Texto exacto del estándar copiado del documento de 2006, con su pensamiento y grupo de grados.',
        '[DBA]' => 'Enunciado y evidencia del DBA copiados de tu ejemplar (si no los tienes, escribe «describir por contenido»).',
        '[DURACION]' => 'Duración de la clase. Ej.: 2 horas de 55 minutos.',
        '[CONTEXTO]' => 'Rasgos del grupo y del entorno: urbano o rural, recursos, saberes previos, dificultades conocidas.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas con experiencia en el sistema educativo colombiano y como formador en didáctica de la matemática.

CONTEXTO
Grado: [GRADO]. Duración: [DURACION]. Contexto del grupo: [CONTEXTO].
Tema: [TEMA].
Estándar (MEN, 2006): [ESTANDAR]
DBA (MEN, 2016, v.2): [DBA]

TAREA
Diseña la planeación de esta clase con tres momentos (exploración, estructuración, transferencia y cierre). La actividad central debe ser una situación problema con un contexto colombiano realista para el grado.

FORMATO DE SALIDA
1. Encabezado: grado, tema, pensamiento(s) y proceso(s) generales que se trabajan (de los cinco de los Estándares).
2. Desempeños esperados redactados en tercera persona, observables, uno por nivel de la escala del Decreto 1290 (Superior, Alto, Básico, Bajo).
3. Tabla de momentos: minutos, qué hace el docente, qué hacen los estudiantes, preguntas clave, material.
4. La situación problema completa con todas sus preguntas y la solución desarrollada paso a paso.
5. Evaluación formativa: una pregunta de cierre y qué respuesta indica cada nivel.

RESTRICCIONES
- No inventes números ni redacciones de DBA. Si no te di el enunciado, descríbelo por contenido y escribe «[POR CONFIRMAR]» en lugar del número del DBA.
- Precios en pesos colombianos de 2026, realistas, con punto de miles y coma decimal (ej.: $3.550; 2,5 kg).
- Cantidades coherentes: personas y objetos indivisibles en números enteros.
- Los minutos de la tabla deben sumar exactamente [DURACION].

VERIFICACIÓN (hazla antes de responder y muéstrala al final)
- Recalcula cada operación de la solución y escribe «verificado» o corrige.
- Comprueba que la suma de minutos coincide con la duración.
- Confirma que cada actividad se relaciona con el estándar citado; si alguna no, cámbiala.
TXT,
      'seguimientos' => [
        'Ahora escribe la versión de la situación problema para un estudiante que todavía no domina la tabla de multiplicar, sin cambiar el objetivo de la clase, y explica qué apoyo le diste.',
        'Propón tres preguntas que pueda hacer mientras circulo por los grupos para detectar quién está sumando en lugar de multiplicar o razonando de forma aditiva.',
        'Revisa de nuevo los precios de la situación: ¿algún valor es irreal para una tienda de barrio colombiana en 2026? Corrige y recalcula todo lo que dependa de él.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 7.°, 36 estudiantes, colegio oficial urbano de Soacha. [TEMA] proporcionalidad directa en tablas de precios. [ESTANDAR] Pensamiento variacional 6.° a 7.°: «Analizo las propiedades de correlación positiva y negativa entre variables, de variación lineal o de proporcionalidad directa y de proporcionalidad inversa en contextos aritméticos y geométricos». [DBA] describir por contenido. [DURACION] 110 minutos. [CONTEXTO] varios estudiantes ayudan en tiendas familiares; aún suman en lugar de multiplicar.',
        'resultado_html' => <<<'TXT'
<h4>Situación problema: «¿Huevo por huevo o cubeta?»</h4>
<p>En la tienda de doña Rosa un huevo AA cuesta <strong>$650</strong>. Ella anota en un cartel cuánto valen 1, 6 y 12 huevos.</p>
<table>
<tr><th>Huevos</th><th>1</th><th>6</th><th>12</th><th>30</th></tr>
<tr><th>Precio</th><td>$650</td><td>$3.900</td><td>$7.800</td><td>?</td></tr>
</table>
<ol>
<li>Completa la tabla si doña Rosa mantiene el precio por unidad. <em>Solución: 30 × 650 = $19.500.</em></li>
<li>¿Qué pasa con el precio cuando el número de huevos se duplica? <em>También se duplica: 6 → $3.900 y 12 → $7.800.</em></li>
<li>Doña Rosa vende la cubeta de 30 huevos a <strong>$18.000</strong>. ¿Sigue habiendo proporcionalidad directa? <em>No: 18.000 ÷ 30 = $600 por huevo, distinto de $650. La razón precio/cantidad ya no es constante.</em></li>
<li>¿Cuánto ahorra quien compra la cubeta en lugar de 30 huevos sueltos? <em>19.500 − 18.000 = $1.500.</em></li>
</ol>
<p><strong>Desempeño Básico:</strong> completa la tabla multiplicando por el valor unitario. <strong>Alto:</strong> explica que el cociente precio/cantidad es constante. <strong>Superior:</strong> identifica que la cubeta rompe la proporcionalidad y argumenta con la constante.</p>
<p><strong>Verificación:</strong> 6 × 650 = 3.900; 12 × 650 = 7.800; 30 × 650 = 19.500; 18.000 ÷ 30 = 600. Minutos: 20 + 60 + 30 = 110. Verificado.</p>
TXT,
      ],
      'revisar' => [
        'El estándar citado aparece textual y corresponde al grupo de grados correcto (no uno de 8.° a 9.° en una clase de 7.°).',
        'No hay un número de DBA inventado: o está copiado de tu documento o dice «[POR CONFIRMAR]».',
        'La solución de la situación problema está completa y cada producto o cociente es correcto.',
        'Los desempeños por nivel son observables (completa, explica, argumenta) y no repiten «comprende» en los cuatro niveles.',
        'Los minutos suman la duración real de la clase.',
      ],
    ],
    [
      'id' => 'MAT-02',
      'categoria' => 'planeacion',
      'titulo' => 'Secuencia didáctica a partir de una situación problema',
      'grados' => '3.° a 9.°',
      'tiempo_ahorrado' => '≈ 2 h',
      'cuando' => 'Cuando vas a abordar un tema durante varias sesiones y quieres que todas giren alrededor de una misma situación auténtica que se va complejizando, en lugar de clases sueltas.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 5.°',
        '[TEMA]' => 'Aprendizaje central. Ej.: suma de fracciones con distinto denominador.',
        '[SITUACION]' => 'Contexto de la situación. Ej.: venta de queso por libras en el mercado campesino.',
        '[SESIONES]' => 'Número y duración de sesiones. Ej.: 5 sesiones de 55 min.',
        '[MATERIAL]' => 'Material disponible. Ej.: tiras de papel, regletas, balanza de cocina.',
      ],
      'prompt' => <<<'TXT'
Actúa como diseñador de secuencias didácticas de matemáticas para colegios colombianos, con dominio de los Estándares Básicos de Competencias (2006) y los DBA v.2 (2016).

CONTEXTO
Grado: [GRADO]. Tema: [TEMA]. Situación de partida: [SITUACION]. Sesiones: [SESIONES]. Material: [MATERIAL].

TAREA
Diseña una secuencia didáctica en la que la misma situación evolucione sesión a sesión: de una pregunta que se resuelve con material concreto a una que exige el procedimiento formal y, al final, una tarea de transferencia a otro contexto.

FORMATO DE SALIDA
1. Pregunta generadora de toda la secuencia.
2. Por cada sesión: propósito, versión de la situación (con datos), actividad con material, preguntas para la discusión, producción que entrega el estudiante.
3. Errores frecuentes que aparecerán en cada sesión y cómo intervenir sin dar la respuesta.
4. Tarea de transferencia final con su solución desarrollada.
5. Relación con el pensamiento y el proceso general de los Estándares (sin inventar códigos).

RESTRICCIONES
- Todos los datos deben ser coherentes entre sesiones (si en la sesión 1 la libra cuesta $14.000, se mantiene).
- Precios realistas de 2026 en pesos colombianos, con punto de miles. Medidas con coma decimal.
- Usa fracciones que se puedan representar con el material indicado.
- Lenguaje adecuado a [GRADO].

VERIFICACIÓN
- Resuelve cada pregunta de la secuencia y muestra la operación al final de cada sesión.
- Revisa que ninguna respuesta dé personas, panes u objetos indivisibles fraccionados.
- Confirma que la dificultad realmente aumenta de una sesión a la siguiente; explica en una línea cómo.
TXT,
      'seguimientos' => [
        'Agrega para cada sesión una pregunta de cierre de un minuto que me permita saber quién necesita volver al material concreto.',
        'Convierte la tarea de transferencia en dos versiones: una con apoyo gráfico y otra sin apoyo, con la misma respuesta numérica.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 5.° [TEMA] suma de fracciones con distinto denominador. [SITUACION] don Aurelio vende queso costeño por libras en el mercado campesino del sábado. [SESIONES] 5 de 55 min. [MATERIAL] tiras de papel, balanza de cocina.',
        'resultado_html' => <<<'TXT'
<p><strong>Pregunta generadora:</strong> ¿Cómo sabe don Aurelio cuánto queso vendió y cuánto cobrar si cada cliente pide una fracción diferente de libra?</p>
<h4>Sesión 1: partir la libra</h4>
<p>Cada pareja recibe una tira que representa una libra. La doblan en mitades y cuartos. Pregunta: una clienta pide 1/2 libra y otra 1/4. ¿Cuánto queso salió? Con las tiras: 1/2 son dos cuartos, más un cuarto, son <strong>3/4 de libra</strong>.</p>
<h4>Sesión 3: cuando los pedazos no coinciden</h4>
<p>Una clienta pide 3/4 de libra y otra 1/2 libra. Error esperado: sumar numeradores y denominadores (3/4 + 1/2 = 4/6). Intervención: «Pon las dos tiras juntas. ¿Te da menos de una libra, como dice 4/6?». Las tiras muestran que el total pasa de una libra.</p>
<p><em>Solución:</em> 1/2 = 2/4, entonces 3/4 + 2/4 = 5/4 = 1 1/4 libras.</p>
<h4>Sesión 4: ¿cuánto cobrar?</h4>
<p>La libra cuesta <strong>$14.000</strong>. ¿Cuánto cobra por las 5/4 de libra? 14.000 ÷ 4 = 3.500 (precio de un cuarto) y 3.500 × 5 = <strong>$17.500</strong>.</p>
<h4>Tarea de transferencia</h4>
<p>Para un sancocho, la mamá de Valentina compra 1/2 kg de yuca y 3/4 kg de papa. ¿Cuántos kilogramos llevan en la bolsa? <em>2/4 + 3/4 = 5/4 = 1 1/4 kg.</em></p>
<p><strong>Progresión:</strong> la sesión 1 usa denominadores que el material ya iguala; la 3 obliga a buscar fracciones equivalentes; la 4 combina fracción y precio.</p>
TXT,
      ],
      'revisar' => [
        'Los datos se mantienen entre sesiones (mismo precio de la libra, mismas fracciones).',
        'Las fracciones elegidas se pueden construir con el material disponible (tiras dobladas en mitades y cuartos, no en séptimos).',
        'La IA no sugiere la regla «sumar numeradores y denominadores» ni siquiera como paso intermedio.',
        'Los precios del queso, la yuca o la papa son creíbles en tu región en 2026.',
      ],
    ],
    [
      'id' => 'MAT-03',
      'categoria' => 'planeacion',
      'titulo' => 'Unidad con resolución de problemas (Pólya) y secuencia concreto, pictórico, abstracto',
      'grados' => 'Transición a 5.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min',
      'cuando' => 'Cuando enseñas un algoritmo (suma con reagrupación, multiplicación, división) y quieres que los niños lleguen a él desde el material y el dibujo, con las cuatro fases de Pólya como rutina.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 2.°',
        '[ALGORITMO]' => 'Procedimiento que se quiere construir. Ej.: suma con reagrupación de números de dos cifras.',
        '[MATERIAL]' => 'Material concreto disponible. Ej.: tapas y bolsitas, ábaco, bloques de base 10.',
        '[CONTEXTO_LOCAL]' => 'Situación cercana. Ej.: ventas de la tienda escolar.',
        '[SEMANAS]' => 'Duración de la unidad. Ej.: 2 semanas.',
      ],
      'prompt' => <<<'TXT'
Actúa como maestro de primaria colombiano experto en enseñanza de las matemáticas con el enfoque concreto, pictórico y abstracto (CPA) y en la resolución de problemas según Pólya. Conoces las mallas de aprendizaje del MEN (2017).

CONTEXTO
Grado: [GRADO]. Procedimiento a construir: [ALGORITMO]. Material: [MATERIAL]. Contexto: [CONTEXTO_LOCAL]. Duración: [SEMANAS].

TAREA
Diseña una unidad en tres etapas (concreta, pictórica, abstracta). En cada etapa, los niños resuelven problemas del contexto siguiendo las cuatro fases de Pólya: comprender el problema, concebir un plan, ejecutar el plan, examinar la solución.

FORMATO DE SALIDA
1. Tabla de la unidad: etapa, días, qué hacen los niños, material, señal de que pueden pasar a la etapa siguiente.
2. Un problema modelo resuelto en las tres representaciones: cómo se hace con el material, cómo se dibuja y cómo se escribe el algoritmo, con el lenguaje que usaría el docente.
3. Las preguntas del docente para cada fase de Pólya, en lenguaje de [GRADO].
4. Seis problemas del contexto para la unidad, dos de ellos de comparación o de cambio con incógnita en el inicio (no solo «juntar»), con su respuesta.
5. Errores típicos del algoritmo y cómo se ven en el material.

RESTRICCIONES
- Números adecuados al grado; ningún resultado fuera del rango numérico que se trabaja.
- Las cantidades de objetos son enteras y plausibles (no 47 empanadas en una tienda de 20 estudiantes si no tiene sentido).
- No uses «llevar» sin explicar qué significa en el material (cambiar 10 unidades por 1 decena).

VERIFICACIÓN
- Resuelve los seis problemas y comprueba cada resultado con la operación inversa.
- Verifica que al menos dos problemas exigen reagrupación (o el paso difícil del algoritmo) y señálalos.
TXT,
      'seguimientos' => [
        'Escribe un guion de 5 minutos para la etapa pictórica: qué dibujo hago en el tablero, qué digo y qué preguntas hago.',
        'Prepara una hoja de registro para observar, durante la etapa concreta, quién cambia correctamente 10 unidades por una decena.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 2.° [ALGORITMO] suma con reagrupación, dos cifras. [MATERIAL] tapas sueltas y bolsitas cerradas de 10 tapas, ábaco vertical. [CONTEXTO_LOCAL] ventas de empanadas en la tienda escolar. [SEMANAS] 2 semanas.',
        'resultado_html' => <<<'TXT'
<h4>Problema modelo</h4>
<p>El lunes la tienda escolar vendió 47 empanadas y el martes 38. ¿Cuántas vendió en los dos días?</p>
<ul>
<li><strong>Comprender:</strong> «¿Qué sabemos? ¿Qué nos preguntan? ¿Van a ser más o menos de 47?»</li>
<li><strong>Concebir un plan:</strong> «¿Juntamos o quitamos? ¿Con qué lo podemos mostrar?»</li>
<li><strong>Ejecutar (concreto):</strong> 47 son 4 bolsitas y 7 tapas sueltas; 38 son 3 bolsitas y 8 sueltas. Juntamos: 7 bolsitas y 15 sueltas. Con 10 sueltas armamos una bolsita nueva: 8 bolsitas y 5 sueltas.</li>
<li><strong>Ejecutar (pictórico):</strong> se dibujan barras para las decenas y puntos para las unidades; se encierran 10 puntos y se convierten en una barra.</li>
<li><strong>Ejecutar (abstracto):</strong> 7 + 8 = 15 unidades: escribo 5 y la decena que formé pasa a la columna de las decenas; 4 + 3 + 1 = 8 decenas. Resultado: <strong>85</strong>.</li>
<li><strong>Examinar:</strong> «¿Es lógico? 47 está cerca de 50 y 38 cerca de 40; 50 + 40 = 90, y 85 está cerca». Comprobación: 85 − 38 = 47.</li>
</ul>
<h4>Señal para pasar de etapa</h4>
<p>Pasa a lo pictórico quien, sin ayuda, cambia 10 tapas sueltas por una bolsita y explica por qué. Pasa a lo abstracto quien puede decir qué representa el 1 pequeño que se escribe sobre las decenas.</p>
<h4>Problema de cambio con inicio desconocido</h4>
<p>Por la mañana había algunas empanadas. En el descanso se vendieron 26 y quedaron 19. ¿Cuántas había? <em>26 + 19 = 45; comprobación: 45 − 26 = 19.</em></p>
TXT,
      ],
      'revisar' => [
        'Cada problema tiene respuesta correcta comprobada con la operación inversa.',
        'Hay variedad de estructuras (cambio, combinación, comparación, inicio desconocido), no solo «juntar».',
        'La transición entre etapas tiene un criterio observable, no solo un número de días.',
        'El lenguaje del docente explica la reagrupación como canje de 10 unidades por una decena.',
      ],
    ],
    [
      'id' => 'MAT-04',
      'categoria' => 'planeacion',
      'titulo' => 'Proyecto estadístico de aula con datos reales del colegio',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 2 h',
      'cuando' => 'Cuando quieres que el pensamiento aleatorio deje de ser una tabla inventada del libro y los estudiantes recorran el ciclo completo: pregunta, plan, datos, análisis y conclusiones.',
      'variables' => [
        '[GRADO]' => 'Grado y número de estudiantes. Ej.: 8.°, 32 estudiantes.',
        '[PREGUNTA]' => 'Pregunta de investigación o tema de interés. Ej.: ¿cuánto tardamos en llegar al colegio y en qué medio?',
        '[SEMANAS]' => 'Duración. Ej.: 3 semanas, 4 horas semanales.',
        '[HERRAMIENTAS]' => 'Herramientas disponibles. Ej.: hoja de cálculo en la sala de informática, papel cuadriculado.',
        '[DATOS]' => 'Si ya tienes datos anonimizados, pégalos aquí; si no, escribe «aún no».',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas colombiano especialista en educación estadística y en el ciclo investigativo PPDAC (Problema, Plan, Datos, Análisis, Conclusiones).

CONTEXTO
Grado: [GRADO]. Pregunta o tema: [PREGUNTA]. Duración: [SEMANAS]. Herramientas: [HERRAMIENTAS]. Datos disponibles: [DATOS].

TAREA
Diseña un proyecto estadístico de aula en el que los estudiantes recojan datos reales del colegio, sin datos personales identificables, y lleguen a conclusiones que respondan la pregunta.

FORMATO DE SALIDA
1. Pregunta de investigación refinada (estadística, no de respuesta sí o no) y variables con su tipo (cualitativa nominal u ordinal, cuantitativa discreta o continua).
2. Instrumento de recolección (máximo 6 preguntas) con aviso de anonimato.
3. Cronograma por fases PPDAC con productos de cada fase.
4. Si hay datos: tabla de frecuencias absolutas, relativas y porcentajes; medidas adecuadas al tipo de variable; gráfica recomendada y por qué.
5. Tres preguntas de lectura de datos: literal, inferencial y crítica.
6. Estándares del pensamiento aleatorio del grupo de grados que se trabajan, citados textualmente si los conoces; si no, descríbelos sin inventar.

RESTRICCIONES
- Nunca pidas nombres, documentos, direcciones ni datos sensibles de menores (Ley 1581 de 2012).
- Las frecuencias deben sumar el total de datos y los porcentajes deben sumar 100 % (si redondeas, explica la diferencia).
- No calcules la media de una variable cualitativa.

VERIFICACIÓN
- Muestra la suma de frecuencias y de porcentajes.
- Recalcula la media (si es agrupada, muestra marcas de clase y productos) y ubica la mediana con la frecuencia acumulada.
TXT,
      'seguimientos' => [
        'Propón cómo comparar nuestros resultados con los de otro curso del colegio y qué cuidado hay que tener al comparar grupos de distinto tamaño.',
        'Escribe la rúbrica del informe final con cuatro criterios (pregunta, datos, análisis, conclusiones) y los niveles Superior, Alto, Básico y Bajo.',
        'Redacta la presentación de 3 minutos que harán los estudiantes en la izada de bandera, con una gráfica y una sola conclusión central.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 8.°, 32 estudiantes. [PREGUNTA] ¿cuánto tardamos en llegar al colegio y en qué medio? [SEMANAS] 3 semanas. [HERRAMIENTAS] hoja de cálculo. [DATOS] tiempos agrupados y medios de transporte de los 32 estudiantes (encuesta anónima).',
        'resultado_html' => <<<'TXT'
<p><strong>Variables:</strong> medio de transporte (cualitativa nominal); tiempo de desplazamiento en minutos (cuantitativa continua).</p>
<h4>Medio de transporte</h4>
<table>
<tr><th>Medio</th><th>f</th><th>%</th></tr>
<tr><td>A pie</td><td>14</td><td>43,75</td></tr>
<tr><td>Bus o SITP</td><td>9</td><td>28,125</td></tr>
<tr><td>Moto</td><td>5</td><td>15,625</td></tr>
<tr><td>Bicicleta</td><td>2</td><td>6,25</td></tr>
<tr><td>Carro</td><td>2</td><td>6,25</td></tr>
<tr><th>Total</th><th>32</th><th>100</th></tr>
</table>
<p><em>Nota:</em> si redondean a una cifra decimal (43,8; 28,1; 15,6; 6,3; 6,3) la suma da 100,1 %. No es un error de los datos sino del redondeo; conviene decirlo al pie de la gráfica. Para esta variable la medida adecuada es la <strong>moda</strong> (a pie); no tiene sentido una «media del medio de transporte».</p>
<h4>Tiempo de desplazamiento</h4>
<table>
<tr><th>Minutos</th><th>f</th><th>Marca</th><th>f × marca</th><th>F acumulada</th></tr>
<tr><td>[0, 10)</td><td>7</td><td>5</td><td>35</td><td>7</td></tr>
<tr><td>[10, 20)</td><td>12</td><td>15</td><td>180</td><td>19</td></tr>
<tr><td>[20, 30)</td><td>8</td><td>25</td><td>200</td><td>27</td></tr>
<tr><td>[30, 40)</td><td>3</td><td>35</td><td>105</td><td>30</td></tr>
<tr><td>[40, 50)</td><td>2</td><td>45</td><td>90</td><td>32</td></tr>
</table>
<p>Media aproximada: 610 ÷ 32 ≈ <strong>19,1 minutos</strong>. Los datos 16.° y 17.° están en [10, 20), que es la clase mediana y también la modal.</p>
<p><strong>Pregunta crítica:</strong> «Cinco compañeros tardan 30 minutos o más. ¿Qué tienen en común y qué le propondrían al consejo directivo sobre la hora de entrada?»</p>
TXT,
      ],
      'revisar' => [
        'Las frecuencias suman el total de encuestados y los porcentajes suman 100 % (o la diferencia por redondeo está explicada).',
        'La medida de tendencia central corresponde al tipo de variable (moda para nominales).',
        'El instrumento no recoge nombres ni datos que permitan identificar a un estudiante.',
        'La media agrupada se calculó con marcas de clase y se presenta como aproximación.',
        'La pregunta de investigación admite variabilidad (no es de sí o no).',
      ],
    ],
    [
      'id' => 'MAT-05',
      'categoria' => 'planeacion',
      'titulo' => 'Clase de modelación: de una situación real a una función',
      'grados' => '8.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando quieres trabajar el proceso de modelar (no solo aplicar fórmulas): elegir variables, proponer un modelo, contrastarlo con datos reales y discutir sus límites.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 9.°',
        '[FENOMENO]' => 'Fenómeno a modelar. Ej.: la temperatura media según la altitud de las ciudades.',
        '[TIPO_FUNCION]' => 'Familia de funciones esperada. Ej.: afín (lineal).',
        '[DATOS]' => 'Datos que tú aportas, con su fuente. Ej.: altitud y temperatura media de 5 ciudades (IDEAM).',
        '[DURACION]' => 'Duración. Ej.: 2 sesiones de 55 min.',
      ],
      'prompt' => <<<'TXT'
Actúa como profesor de matemáticas de educación media en Colombia, experto en modelación matemática y en el pensamiento variacional de los Estándares Básicos de Competencias (2006).

CONTEXTO
Grado: [GRADO]. Fenómeno: [FENOMENO]. Familia de funciones esperada: [TIPO_FUNCION]. Datos (aportados por el docente): [DATOS]. Duración: [DURACION].

TAREA
Diseña una clase que recorra el ciclo de modelación: situación real, simplificación y variables, modelo matemático, resultados del modelo, contraste con los datos, ajuste o crítica del modelo.

FORMATO DE SALIDA
1. Pregunta inicial que despierte la necesidad del modelo.
2. Variables (independiente, dependiente, unidades) y supuestos explícitos.
3. Un primer modelo sencillo y una tabla que compare valores del modelo con los datos reales (incluye la diferencia).
4. Un modelo ajustado a partir de dos puntos de los datos, con el cálculo de la pendiente paso a paso.
5. Preguntas de discusión sobre límites del modelo (dónde falla y por qué).
6. Producto que entrega el estudiante.

RESTRICCIONES
- Usa solo los datos que te di. No inventes datos climáticos ni demográficos; si falta alguno, deja «[dato del docente]».
- Unidades siempre visibles (°C, m, msnm). Coma decimal.
- Redondea a una cifra decimal e indícalo.

VERIFICACIÓN
- Recalcula cada valor de la tabla del modelo y cada diferencia.
- Comprueba la pendiente con los dos puntos usados y verifica que el modelo ajustado pasa por ellos.
TXT,
      'seguimientos' => [
        'Diseña una extensión para hoja de cálculo en la que los estudiantes grafiquen los datos, agreguen la línea de tendencia y comparen su pendiente con la que calcularon a mano.',
        'Escribe tres preguntas tipo Saber 11 (argumentación) sobre este modelo, con cuatro opciones y la justificación de cada distractor.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 9.° [FENOMENO] temperatura media según la altitud. [TIPO_FUNCION] afín. [DATOS] altitudes y temperaturas medias anuales redondeadas que aporta el docente (para la clase, contrástalas con los datos del IDEAM): Cartagena 0 m y 28 °C; Cali 1.000 m y 25 °C; Medellín 1.495 m y 22 °C; Manizales 2.150 m y 17 °C; Bogotá 2.640 m y 14 °C. [DURACION] 2 sesiones.',
        'resultado_html' => <<<'TXT'
<p><strong>Pregunta inicial:</strong> si un bus sale de Honda y sube hacia Bogotá, ¿podemos predecir cuánto bajará la temperatura sin un termómetro?</p>
<p><strong>Variables y supuestos:</strong> h = altitud (m), T = temperatura media anual (°C). Suponemos que la temperatura baja de forma constante con la altura y que no influyen vientos, vegetación ni el valle donde está la ciudad.</p>
<h4>Modelo 1 (regla escolar: baja 0,6 °C por cada 100 m)</h4>
<p>T(h) = 28 − 0,006h</p>
<table>
<tr><th>Ciudad</th><th>h (m)</th><th>Modelo (°C)</th><th>Dato (°C)</th><th>Diferencia</th></tr>
<tr><td>Cali</td><td>1.000</td><td>22,0</td><td>25</td><td>+3,0</td></tr>
<tr><td>Medellín</td><td>1.495</td><td>19,0</td><td>22</td><td>+3,0</td></tr>
<tr><td>Manizales</td><td>2.150</td><td>15,1</td><td>17</td><td>+1,9</td></tr>
<tr><td>Bogotá</td><td>2.640</td><td>12,2</td><td>14</td><td>+1,8</td></tr>
</table>
<p>El modelo siempre da temperaturas más bajas que las reales: la pendiente parece demasiado grande.</p>
<h4>Modelo 2 (ajustado con Cartagena y Bogotá)</h4>
<p>m = (14 − 28) ÷ (2.640 − 0) = −14 ÷ 2.640 ≈ −0,0053 °C por metro, es decir, cerca de 0,53 °C por cada 100 m. T(h) = 28 − 0,0053h. Comprobación: T(0) = 28 y T(2.640) = 28 − 13,99 ≈ 14,0.</p>
<p>Con este modelo: Cali 22,7 °C (diferencia +2,3); Medellín 20,1 °C (+1,9); Manizales 16,6 °C (+0,4).</p>
<p><strong>Discusión:</strong> ¿por qué Cali y Medellín siguen siendo más cálidas que lo que predice el modelo? Pista: son ciudades de valle. ¿Serviría el modelo para el Nevado del Ruiz, a más de 5.000 m?</p>
TXT,
      ],
      'revisar' => [
        'La IA usó solo los datos que aportaste; si agregó ciudades o temperaturas, elimínalas o verifícalas con el IDEAM.',
        'Cada valor de la tabla del modelo coincide con la fórmula (prueba al menos dos con calculadora).',
        'La pendiente tiene unidades y signo correctos (°C por metro, negativa).',
        'Hay una discusión explícita de los límites del modelo, no solo su aplicación.',
      ],
    ],
    [
      'id' => 'MAT-06',
      'categoria' => 'evaluacion',
      'titulo' => 'Ítems tipo Saber 3.°, 5.° y 9.° con distractores basados en errores típicos',
      'grados' => '3.°, 5.° y 9.°',
      'tiempo_ahorrado' => '≈ 1 h 15 min',
      'cuando' => 'Cuando necesitas preguntas de selección múltiple que se parezcan a las del ICFES y que, además, te digan qué error comete cada estudiante según la opción que marca.',
      'variables' => [
        '[GRADO]' => '3.°, 5.° o 9.°',
        '[COMPONENTE]' => 'Numérico-variacional, espacial-métrico o aleatorio.',
        '[COMPETENCIA]' => 'Comunicación, modelación y representación; razonamiento y argumentación; o planteamiento y resolución de problemas.',
        '[TEMA]' => 'Contenido concreto. Ej.: comparación de números decimales.',
        '[CANTIDAD]' => 'Número de ítems. Ej.: 4.',
        '[NUM_OPCIONES]' => 'Número de opciones según la guía de orientación vigente del ICFES para el grado. Ej.: 4 (A, B, C, D).',
      ],
      'prompt' => <<<'TXT'
Actúa como constructor de ítems con experiencia en pruebas estandarizadas de matemáticas en Colombia y conocimiento del marco de referencia de Saber 3.°, 5.° y 9.° del ICFES.

CONTEXTO
Grado: [GRADO]. Componente: [COMPONENTE]. Competencia: [COMPETENCIA]. Tema: [TEMA]. Número de opciones: [NUM_OPCIONES].

TAREA
Elabora [CANTIDAD] ítems de selección múltiple con única respuesta. Cada ítem tiene un contexto breve y auténtico colombiano, un enunciado y opciones. Cada distractor debe corresponder a un error de pensamiento frecuente y documentado en estudiantes de [GRADO], no a un número cualquiera.

FORMATO DE SALIDA
Para cada ítem:
- Contexto y enunciado (máximo 60 palabras para 3.° y 5.°; 90 para 9.°).
- Opciones A a la que corresponda.
- Clave.
- Procedimiento completo de la respuesta correcta.
- Tabla: opción, cómo se obtiene ese valor, error o concepción errónea que revela.
- Componente, competencia y qué afirmación evalúa en lenguaje sencillo.

RESTRICCIONES
- Una y solo una opción correcta. Ningún distractor puede ser defendible como correcto.
- Opciones de longitud y forma parecidas; ordenadas de menor a mayor si son números.
- Nada de «todas las anteriores» ni «ninguna de las anteriores».
- Precios realistas de 2026 en pesos colombianos; coma decimal y punto de miles.
- No copies preguntas publicadas por el ICFES.

VERIFICACIÓN
- Resuelve de nuevo cada ítem desde cero, sin mirar la clave, y confirma que coincide.
- Para cada distractor, rehaz el cálculo erróneo y confirma que produce exactamente ese valor.
- Confirma que ningún distractor también es correcto bajo otra interpretación razonable del enunciado.
TXT,
      'seguimientos' => [
        'Ordena los ítems de menor a mayor dificultad estimada y explica qué hace más difícil a cada uno.',
        'Para cada distractor, escribe la pregunta que le haría al estudiante que lo eligió para confirmar el error antes de reenseñar.',
        'Reescribe el ítem 2 cambiando el contexto a uno rural, sin alterar la estructura matemática ni los errores que capturan los distractores.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 5.° [COMPONENTE] numérico-variacional. [COMPETENCIA] planteamiento y resolución de problemas. [TEMA] decimales y proporcionalidad simple con dinero. [CANTIDAD] 2. [NUM_OPCIONES] 4.',
        'resultado_html' => <<<'TXT'
<h4>Ítem 1</h4>
<p>En la ciclovía del domingo, cuatro amigos anotaron la distancia que recorrieron en patines: Ana 2,5 km; Beto 2,45 km; Carla 2,125 km; Darío 2,09 km. ¿Quién recorrió la mayor distancia?</p>
<p>A. Ana &nbsp; B. Beto &nbsp; C. Carla &nbsp; D. Darío. <strong>Clave: A.</strong></p>
<p><em>Procedimiento:</em> se comparan las décimas: 2,5 tiene 5 décimas; 2,45 tiene 4; 2,125 tiene 1; 2,09 tiene 0. El mayor es 2,5.</p>
<table>
<tr><th>Opción</th><th>Concepción errónea</th></tr>
<tr><td>B</td><td>Lee la parte decimal como número entero: 45 &gt; 5.</td></tr>
<tr><td>C</td><td>Cree que el número con más cifras decimales es el mayor.</td></tr>
<tr><td>D</td><td>Se fija en la cifra más grande que aparece (9), sin atender su posición.</td></tr>
</table>
<h4>Ítem 2</h4>
<p>En la tienda, una libra de panela cuesta $3.400. Mariana compra tres libras y media. ¿Cuánto paga?</p>
<p>A. $10.200 &nbsp; B. $11.700 &nbsp; C. $11.900 &nbsp; D. $13.600. <strong>Clave: C.</strong></p>
<p><em>Procedimiento:</em> 3 × 3.400 = 10.200; media libra = 3.400 ÷ 2 = 1.700; 10.200 + 1.700 = 11.900.</p>
<table>
<tr><th>Opción</th><th>Cómo se obtiene y qué revela</th></tr>
<tr><td>A</td><td>3 × 3.400: ignora la media libra.</td></tr>
<tr><td>B</td><td>10.200 + 1.500: error al calcular la mitad de 3.400.</td></tr>
<tr><td>D</td><td>4 × 3.400: redondea 3,5 a 4 sin necesidad.</td></tr>
</table>
<p><strong>Verificación:</strong> recalculado desde cero; solo C coincide.</p>
TXT,
      ],
      'revisar' => [
        'Resuelve tú cada ítem antes de mirar la clave. La IA marca claves erradas con más frecuencia de lo que parece.',
        'Cada distractor se obtiene exactamente con el error descrito (rehaz la cuenta errónea).',
        'Ningún distractor es correcto bajo otra lectura del enunciado (ej.: «tres libras y media» no puede leerse como otra cantidad).',
        'El número de opciones coincide con la guía de orientación vigente del ICFES para ese grado.',
        'Los contextos y precios son plausibles y no hay datos que sobren sin intención.',
      ],
    ],
    [
      'id' => 'MAT-07',
      'categoria' => 'evaluacion',
      'titulo' => 'Ítems tipo Saber 11 con tabla o gráfica',
      'grados' => '10.° y 11.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min',
      'cuando' => 'Cuando preparas a tus estudiantes para Saber 11 y quieres ítems donde tengan que leer una tabla o gráfica, formular un procedimiento y argumentar, no solo aplicar una fórmula.',
      'variables' => [
        '[COMPETENCIA]' => 'Interpretación y representación; formulación y ejecución; o argumentación.',
        '[CATEGORIA]' => 'Estadística; geometría; o álgebra y cálculo.',
        '[TIPO_CONTENIDO]' => 'Genérico o no genérico.',
        '[CONTEXTO]' => 'Situación. Ej.: factura de energía con subsidio por estrato.',
        '[CANTIDAD]' => 'Número de ítems. Ej.: 2.',
      ],
      'prompt' => <<<'TXT'
Actúa como experto en evaluación de matemáticas con conocimiento del marco de referencia de la prueba de Matemáticas de Saber 11 (ICFES): competencias interpretación y representación, formulación y ejecución, y argumentación; contenidos genéricos y no genéricos; categorías estadística, geometría, y álgebra y cálculo.

CONTEXTO
Competencia: [COMPETENCIA]. Categoría: [CATEGORIA]. Contenido: [TIPO_CONTENIDO]. Contexto: [CONTEXTO].

TAREA
Construye [CANTIDAD] ítems de selección múltiple con única respuesta y cuatro opciones (A a D) que dependan de una tabla o gráfica que también debes construir. Sin la tabla o gráfica, el ítem no debe poder resolverse.

FORMATO DE SALIDA
1. La tabla (en formato de tabla) o la descripción exacta de la gráfica (ejes, escala, valores de cada punto o barra).
2. Cada ítem: enunciado, opciones, clave.
3. Solución paso a paso.
4. Justificación de cada distractor: cálculo que lo produce y error que revela.
5. Clasificación: competencia, categoría, genérico o no genérico.

RESTRICCIONES
- Si los datos son simplificados o hipotéticos, dilo en una nota bajo la tabla («Datos simplificados con fines escolares»).
- Valores en pesos colombianos de 2026 realistas, con punto de miles.
- En argumentación, las opciones son afirmaciones con su razón («Sí, porque…», «No, porque…») y solo una razón es válida.
- No reproduzcas ítems liberados del ICFES.

VERIFICACIÓN
- Recalcula todo lo que dependa de la tabla y confirma la clave.
- Comprueba que los valores de la gráfica permiten leer sin ambigüedad lo que se pregunta (escala adecuada).
- Confirma que exactamente una opción es correcta.
TXT,
      'seguimientos' => [
        'Escribe un tercer ítem con la misma tabla, ahora de interpretación y representación, en el que haya que escoger la gráfica que representa correctamente los datos (describe las cuatro gráficas).',
        'Redacta la retroalimentación que verá el estudiante que eligió cada distractor: dos líneas, sin dar la respuesta.',
      ],
      'ejemplo' => [
        'contexto' => '[COMPETENCIA] formulación y ejecución; argumentación. [CATEGORIA] álgebra y cálculo. [TIPO_CONTENIDO] genérico (porcentajes y tarifas por tramos). [CONTEXTO] factura de energía de un hogar de estrato 2. [CANTIDAD] 2.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Concepto</th><th>Valor</th></tr>
<tr><td>Tarifa plena por kWh</td><td>$900</td></tr>
<tr><td>Consumo de subsistencia</td><td>130 kWh al mes</td></tr>
<tr><td>Subsidio estrato 2</td><td>40 % sobre el consumo de subsistencia</td></tr>
<tr><td>Consumo por encima de la subsistencia</td><td>Tarifa plena</td></tr>
</table>
<p><em>Datos simplificados con fines escolares. En la realidad el consumo de subsistencia depende de la altitud del municipio y el subsidio lo define la regulación vigente.</em></p>
<h4>Ítem 1 (formulación y ejecución)</h4>
<p>Un hogar de estrato 2 consumió 160 kWh en el mes. ¿Cuánto paga por el consumo de energía?</p>
<p>A. $57.600 &nbsp; B. $86.400 &nbsp; C. $97.200 &nbsp; D. $144.000. <strong>Clave: C.</strong></p>
<p><em>Solución:</em> 130 × 900 × 0,6 = 70.200; 30 × 900 = 27.000; total 97.200.</p>
<ul>
<li>A: 160 × 900 × 0,4 = 57.600. Confunde lo que paga con el valor del subsidio.</li>
<li>B: 160 × 900 × 0,6 = 86.400. Aplica el subsidio a todo el consumo.</li>
<li>D: 160 × 900 = 144.000. Ignora el subsidio.</li>
</ul>
<h4>Ítem 2 (argumentación)</h4>
<p>Un vecino afirma: «Si un hogar consume el doble, paga el doble». Para un hogar que pasa de 80 kWh a 160 kWh, la afirmación es:</p>
<p>A. Correcta, porque el precio por kWh es siempre $900.<br>B. Correcta, porque el subsidio es el mismo porcentaje.<br>C. Incorrecta, porque los kWh por encima de 130 se cobran a tarifa plena: 80 kWh cuestan $43.200 y 160 kWh cuestan $97.200, más del doble.<br>D. Incorrecta, porque con 160 kWh el hogar pierde todo el subsidio. <strong>Clave: C.</strong></p>
<p>Verificación: 80 × 900 × 0,6 = 43.200; 2 × 43.200 = 86.400 &lt; 97.200. D es falsa: los primeros 130 kWh siguen subsidiados.</p>
TXT,
      ],
      'revisar' => [
        'La tabla o gráfica es necesaria para responder; si el ítem se resuelve sin ella, no evalúa lectura de información.',
        'Las cuentas de la clave y de cada distractor están rehechas con calculadora.',
        'En los ítems de argumentación, la razón de la opción correcta es verdadera y la de los distractores es falsa o irrelevante.',
        'Los datos simplificados están rotulados como tales; no se presentan tarifas inventadas como oficiales.',
      ],
    ],
    [
      'id' => 'MAT-08',
      'categoria' => 'evaluacion',
      'titulo' => 'Banco de problemas contextualizados por niveles de complejidad',
      'grados' => '4.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando necesitas una colección de problemas sobre un mismo tema con tres niveles de complejidad para trabajo diferenciado, tareas o evaluación, todos con solución verificada.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 6.°',
        '[TEMA]' => 'Tema. Ej.: área y perímetro de rectángulos con decimales.',
        '[CONTEXTO]' => 'Contexto común. Ej.: enchapar el piso de una cocina con baldosas.',
        '[POR_NIVEL]' => 'Problemas por nivel. Ej.: 3.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente colombiano de matemáticas que diseña bancos de problemas para aulas heterogéneas.

CONTEXTO
Grado: [GRADO]. Tema: [TEMA]. Contexto común: [CONTEXTO].

TAREA
Escribe [POR_NIVEL] problemas por cada uno de tres niveles:
- Nivel 1 (reproducción): un paso, datos explícitos.
- Nivel 2 (conexión): dos o más pasos, hay que decidir qué operación usar o convertir unidades.
- Nivel 3 (reflexión): decidir con información incompleta o sobrante, redondear con criterio (ej.: comprar cajas completas), justificar o comparar alternativas.

FORMATO DE SALIDA
Tabla con: código (N1-1, N2-1…), enunciado, respuesta, procedimiento resumido, qué lo hace de ese nivel. Al final, una clave aparte para fotocopiar.

RESTRICCIONES
- Medidas físicamente posibles (una cocina no mide 40 m de largo; una baldosa no mide 3 cm).
- Precios realistas de 2026 en pesos colombianos, con punto de miles. Coma decimal.
- Cuando el resultado sean objetos que se compran por unidad o caja, la respuesta se redondea hacia arriba y se dice por qué.
- Usa las unidades que se usan en Colombia en ese contexto (metros, centímetros, metros cuadrados).

VERIFICACIÓN
- Resuelve cada problema dos veces por caminos distintos (ej.: área total ÷ área de baldosa y baldosas por lado × baldosas por lado) y confirma que coinciden.
- Revisa que ningún problema tenga datos contradictorios.
TXT,
      'seguimientos' => [
        'Agrega un problema de nivel 3 con un dato faltante a propósito, que obligue al estudiante a preguntar o suponer, y explica cómo evaluarlo.',
        'Convierte dos problemas del nivel 2 en una tarea para hacer en casa con medidas reales del baño o la cocina de la familia.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 6.° [TEMA] área y perímetro con decimales. [CONTEXTO] enchapar el piso de una cocina rectangular de 3,6 m × 2,4 m con baldosas cuadradas de 30 cm. [POR_NIVEL] 3 (se muestra uno por nivel).',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Código</th><th>Enunciado</th><th>Respuesta y procedimiento</th></tr>
<tr><td>N1-1</td><td>¿Cuál es el área del piso de la cocina?</td><td>3,6 × 2,4 = <strong>8,64 m²</strong>.</td></tr>
<tr><td>N2-1</td><td>¿Cuántas baldosas de 30 cm × 30 cm se necesitan sin contar desperdicio?</td><td>30 cm = 0,3 m. Por el largo: 3,6 ÷ 0,3 = 12; por el ancho: 2,4 ÷ 0,3 = 8; 12 × 8 = <strong>96 baldosas</strong>. Segundo camino: 8,64 ÷ 0,09 = 96. Coinciden.</td></tr>
<tr><td>N3-1</td><td>Cada caja trae 16 baldosas y cuesta $52.000. El maestro de obra recomienda comprar 10 % más por cortes y daños. ¿Cuántas cajas deben comprar y cuánto pagan?</td><td>96 × 1,1 = 105,6 → se necesitan 106 baldosas. 106 ÷ 16 = 6,625 → <strong>7 cajas</strong> (no se venden cajas incompletas). 7 × 52.000 = <strong>$364.000</strong>. Sobran 7 × 16 − 106 = 6 baldosas.</td></tr>
</table>
<p><strong>Por qué N3 es de reflexión:</strong> hay que interpretar el 10 %, redondear dos veces hacia arriba con criterio y comprobar cuántas sobran.</p>
<p><strong>Problema de perímetro (N2-2):</strong> el guardaescoba va por todo el borde menos la puerta, de 0,9 m. Perímetro: 2 × (3,6 + 2,4) = 12 m; 12 − 0,9 = <strong>11,1 m</strong>.</p>
TXT,
      ],
      'revisar' => [
        'Las medidas y precios son físicamente y comercialmente posibles.',
        'En los problemas de compra, la respuesta se redondea hacia arriba y la IA lo justifica.',
        'Las unidades se convierten antes de operar (cm a m) y el área se expresa en unidades cuadradas.',
        'El nivel 3 de verdad exige decidir o justificar; no es solo un problema con números más grandes.',
      ],
    ],
    [
      'id' => 'MAT-09',
      'categoria' => 'evaluacion',
      'titulo' => 'Quiz de salida (exit ticket) con criterios para agrupar al día siguiente',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 25 min por clase',
      'cuando' => 'Al final de una clase, para saber en cinco minutos quién logró el aprendizaje, quién está cerca y quién necesita volver a empezar, y organizar la clase siguiente con esa información.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 8.°',
        '[APRENDIZAJE]' => 'Lo que se trabajó hoy. Ej.: plantear y resolver ecuaciones lineales en contexto.',
        '[ERRORES_ESPERADOS]' => 'Errores que viste en clase. Ej.: pasan términos sin cambiar la operación.',
        '[TIEMPO]' => 'Minutos disponibles. Ej.: 5 minutos.',
      ],
      'prompt' => <<<'TXT'
Actúa como especialista en evaluación formativa en matemáticas para colegios colombianos.

CONTEXTO
Grado: [GRADO]. Aprendizaje de hoy: [APRENDIZAJE]. Errores observados: [ERRORES_ESPERADOS]. Tiempo: [TIEMPO].

TAREA
Diseña un quiz de salida de tres preguntas que se resuelva en [TIEMPO]:
1. Una pregunta de procedimiento directo.
2. Una pregunta en contexto colombiano que exija plantear antes de calcular.
3. Una pregunta de metacognición («¿Qué paso te costó más y por qué?»).

FORMATO DE SALIDA
- Las preguntas listas para copiar en un cuarto de hoja.
- Respuestas esperadas con procedimiento.
- Tabla de clasificación: qué respuesta o error ubica al estudiante en el grupo «Logrado», «En proceso» o «Necesita apoyo», y qué actividad de 15 minutos hace cada grupo en la clase siguiente.

RESTRICCIONES
- Los números deben permitir resolver sin calculadora en el tiempo dado.
- Si hay dinero o tarifas, usa valores de 2026 e indica «tarifa de referencia; verifica la vigente».
- Las respuestas deben ser enteras o con decimales finitos y cortos, salvo que el aprendizaje sea justamente otro.

VERIFICACIÓN
- Resuelve las dos primeras preguntas y comprueba sustituyendo en la ecuación o en la situación.
- Confirma que un error típico de [ERRORES_ESPERADOS] produce una respuesta distinta y reconocible.
TXT,
      'seguimientos' => [
        'Dame tres versiones equivalentes del quiz (A, B y C) con otros números y la misma dificultad, para que no se copien.',
        'Escribe la actividad de 15 minutos para el grupo «Necesita apoyo» usando material o representación gráfica.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 8.° [APRENDIZAJE] plantear y resolver ecuaciones lineales en contexto. [ERRORES_ESPERADOS] trasladan términos sin invertir la operación; no interpretan el residuo. [TIEMPO] 5 minutos.',
        'resultado_html' => <<<'TXT'
<ol>
<li>Resuelve: 3x + 7 = 25.</li>
<li>Laura tiene $30.000 en su tarjeta TuLlave y cada pasaje de TransMilenio cuesta $3.550 (tarifa de 2026). Escribe una expresión para el saldo después de x viajes. ¿Cuántos viajes completos puede hacer y cuánto le queda?</li>
<li>¿Qué paso te costó más hoy y por qué?</li>
</ol>
<h4>Respuestas esperadas</h4>
<ol>
<li>3x = 25 − 7 = 18; x = 6. Comprobación: 3 × 6 + 7 = 25.</li>
<li>S = 30.000 − 3.550x. Como 3.550 × 8 = 28.400 y 3.550 × 9 = 31.950, alcanza para <strong>8 viajes</strong> y le quedan 30.000 − 28.400 = <strong>$1.600</strong>.</li>
</ol>
<table>
<tr><th>Grupo</th><th>Evidencia</th><th>Mañana (15 min)</th></tr>
<tr><td>Logrado</td><td>Las dos correctas, con expresión del saldo.</td><td>Reto: ¿cuánto debe recargar para completar 20 viajes?</td></tr>
<tr><td>En proceso</td><td>Pregunta 1 bien; en la 2 responde 8,45 viajes o no calcula el saldo.</td><td>Discusión: ¿qué significa 8,45 viajes? Tabla de saldos viaje por viaje.</td></tr>
<tr><td>Necesita apoyo</td><td>En la 1 escribe x = 32/3 o x = 10,67 (sumó 7 en vez de restarlo).</td><td>Modelo de balanza con sobres y fichas.</td></tr>
</table>
TXT,
      ],
      'revisar' => [
        'Las respuestas se pueden obtener sin calculadora en el tiempo previsto.',
        'La clasificación por grupos se basa en evidencias concretas de la hoja, no en impresiones.',
        'Las tarifas usadas están marcadas como referencia y coinciden con las vigentes en tu ciudad.',
        'El error típico produce una respuesta reconocible (ej.: 32 ÷ 3 si suman 7 en lugar de restarlo).',
      ],
    ],
    [
      'id' => 'MAT-10',
      'categoria' => 'evaluacion',
      'titulo' => 'Diagnóstico de errores y concepciones erróneas a partir de respuestas de estudiantes',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Después de una prueba o taller, cuando tienes respuestas incorrectas y quieres saber qué piensan los estudiantes (no solo que se equivocaron) para decidir qué reenseñar.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 7.°',
        '[TEMA]' => 'Tema evaluado. Ej.: operaciones con números enteros.',
        '[RESPUESTAS]' => 'Respuestas transcritas y anonimizadas: «Estudiante A: …». Nunca nombres.',
        '[CONTEXTO]' => 'Cómo se enseñó el tema. Ej.: con recta numérica y reglas de signos.',
      ],
      'prompt' => <<<'TXT'
Actúa como investigador en didáctica de la matemática con experiencia en análisis de errores de estudiantes de colegios colombianos.

CONTEXTO
Grado: [GRADO]. Tema: [TEMA]. Así se enseñó: [CONTEXTO].
Respuestas anonimizadas:
[RESPUESTAS]

TAREA
Para cada respuesta, identifica el error, la concepción errónea más probable que lo explica y cómo confirmarla. Luego agrupa los errores por concepción y propón una intervención para cada grupo.

FORMATO DE SALIDA
1. Tabla por estudiante: respuesta del estudiante, respuesta correcta con cálculo, tipo de error (conceptual, procedimental, de lectura, de cálculo), concepción errónea probable, pregunta diagnóstica para confirmarla.
2. Agrupación: concepciones erróneas detectadas, qué estudiantes (por letra) y prioridad.
3. Para cada concepción: una actividad de reenseñanza de 20 minutos con un contexto colombiano y un modelo (recta numérica, termómetro, saldo de cuenta, altitud).

RESTRICCIONES
- No inventes respuestas que no estén en la lista.
- Distingue un descuido de una concepción errónea: si solo hay una evidencia, di «hipótesis por confirmar».
- No uses nombres; conserva las letras.

VERIFICACIÓN
- Recalcula cada respuesta correcta.
- Comprueba que la concepción que propones reproduce exactamente la respuesta errónea del estudiante; si no la reproduce, busca otra explicación.
TXT,
      'seguimientos' => [
        'Diseña cuatro ítems cortos que discriminen entre estas concepciones erróneas: cada respuesta incorrecta debe apuntar a una sola concepción.',
        'Redacta una nota breve para cada estudiante (por letra) con una pista, sin dar la respuesta.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 7.° [TEMA] operaciones con enteros. [RESPUESTAS] Estudiante A: −3 − 5 = 2. Estudiante B: (−4)(−3) = −12. Estudiante C: −7 + 10 = −17. Estudiante D: −2² = 4. [CONTEXTO] recta numérica y reglas de signos memorizadas.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Est.</th><th>Correcta</th><th>Concepción errónea probable</th><th>Pregunta diagnóstica</th></tr>
<tr><td>A</td><td>−3 − 5 = −8</td><td>Aplica «menos por menos es más» a una resta y opera con los valores absolutos (5 − 3 = 2).</td><td>«Si a las 5 a. m. en el páramo de Sumapaz hay −3 °C y la temperatura baja 5 grados, ¿sube o baja el termómetro?»</td></tr>
<tr><td>B</td><td>(−4)(−3) = 12</td><td>Cree que el resultado conserva el signo de los factores («si los dos son negativos, el producto es negativo»).</td><td>«Completa el patrón: (−4)(2) = −8; (−4)(1) = −4; (−4)(0) = 0; (−4)(−1) = ?»</td></tr>
<tr><td>C</td><td>−7 + 10 = 3</td><td>Suma valores absolutos y deja el signo del primer número. Hipótesis por confirmar: puede ser descuido.</td><td>«Debes $7.000 en la tienda y pagas $10.000. ¿Debes o te deben?»</td></tr>
<tr><td>D</td><td>−2² = −4</td><td>Interpreta −2² como (−2)². No reconoce que la potencia se aplica antes que el signo.</td><td>«Calcula −3² y (−3)². ¿Por qué podrían ser distintos?»</td></tr>
</table>
<h4>Agrupación y prioridad</h4>
<ul>
<li><strong>Prioridad 1:</strong> reglas de signos aplicadas sin sentido (A y B). Reenseñanza con termómetro y altitudes: en la Ciénaga Grande y en el páramo.</li>
<li><strong>Prioridad 2:</strong> jerarquía de operaciones con signo (D). Contraste −3² y (−3)² en la calculadora científica.</li>
<li><strong>Por confirmar:</strong> C, con la pregunta de la deuda en la tienda.</li>
</ul>
TXT,
      ],
      'revisar' => [
        'La concepción propuesta reproduce exactamente el error (comprueba haciendo el cálculo «como lo haría el estudiante»).',
        'La IA distingue entre concepción errónea y descuido cuando hay una sola evidencia.',
        'No aparecen nombres ni datos personales de los estudiantes.',
        'Las respuestas correctas están bien calculadas, incluida la convención −a² = −(a²).',
      ],
    ],
    [
      'id' => 'MAT-11',
      'categoria' => 'evaluacion',
      'titulo' => 'Rúbrica de resolución de problemas para una tarea específica',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 40 min',
      'cuando' => 'Cuando vas a evaluar un problema abierto o una tarea de desempeño y necesitas una rúbrica ajustada a esa tarea, con descriptores que dos docentes aplicarían igual.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 5.°',
        '[TAREA]' => 'Enunciado completo de la tarea.',
        '[SOLUCION]' => 'Solución esperada o rango de soluciones válidas.',
        '[ESCALA_SIEE]' => 'Equivalencia numérica de tu SIEE. Ej.: Superior 4,6–5,0; Alto 4,0–4,5; Básico 3,0–3,9; Bajo 1,0–2,9.',
      ],
      'prompt' => <<<'TXT'
Actúa como especialista en evaluación auténtica de matemáticas en Colombia, conocedor del Decreto 1290 de 2009 y de las cuatro fases de resolución de problemas de Pólya.

CONTEXTO
Grado: [GRADO]. Tarea: [TAREA]. Solución esperada: [SOLUCION]. Escala del SIEE: [ESCALA_SIEE].

TAREA
Construye una rúbrica analítica para esta tarea con cuatro criterios: comprensión del problema, estrategia y representación, ejecución y exactitud, comunicación y verificación del resultado. Usa los niveles Superior, Alto, Básico y Bajo.

FORMATO DE SALIDA
1. Tabla: criterio × nivel, con descriptores observables específicos de esta tarea (menciona los datos y pasos concretos).
2. Peso de cada criterio (suma 100 %).
3. Dos ejemplos de producción de estudiante inventados y anonimizados (uno Alto y uno Básico) con la calificación aplicada criterio por criterio y el cálculo de la nota final.

RESTRICCIONES
- Nada de descriptores vagos como «excelente», «bueno», «regular». Describe qué se ve en la hoja.
- Un error de cálculo aislado no debe llevar a Bajo si la estrategia es correcta.
- La equivalencia numérica es la del SIEE dado, no otra.

VERIFICACIÓN
- Confirma que los pesos suman 100 %.
- Recalcula la nota final de los dos ejemplos con los pesos.
- Revisa que cada nivel sea distinguible del siguiente por al menos un rasgo observable.
TXT,
      'seguimientos' => [
        'Convierte la rúbrica en una lista de chequeo de autoevaluación en primera persona para el estudiante.',
        'Escribe la retroalimentación escrita para el ejemplo Básico: un logro, un aspecto por mejorar y un siguiente paso concreto.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 5.° [TAREA] «Con $60.000 organicen las onces de 12 compañeros: cada uno debe recibir una bebida y un pan; muestren la compra y el sobrante». [SOLUCION] varias válidas; ej.: 12 avenas de $2.500 y 12 pandeyucas de $1.500 = $48.000; sobran $12.000. [ESCALA_SIEE] Superior 4,6–5,0; Alto 4,0–4,5; Básico 3,0–3,9; Bajo 1,0–2,9.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Criterio (peso)</th><th>Superior</th><th>Alto</th><th>Básico</th><th>Bajo</th></tr>
<tr><td>Comprensión (20 %)</td><td>Identifica las tres condiciones (12 personas, bebida y pan para cada uno, máximo $60.000) y las escribe con sus palabras.</td><td>Identifica las tres condiciones sin reformularlas.</td><td>Identifica dos condiciones; olvida una (ej.: el tope de dinero).</td><td>No distingue lo que se pide.</td></tr>
<tr><td>Estrategia (30 %)</td><td>Organiza la compra en tabla y compara al menos dos opciones de productos.</td><td>Organiza una opción completa en tabla o lista.</td><td>Calcula por partes sin organizar; la opción es incompleta.</td><td>Escribe precios sueltos sin relacionarlos.</td></tr>
<tr><td>Ejecución (30 %)</td><td>Multiplicaciones, suma total y sobrante correctos.</td><td>Un error de cálculo que no cambia la decisión.</td><td>Errores que llevan a un total que supera $60.000 sin notarlo.</td><td>No llega a un total.</td></tr>
<tr><td>Comunicación y verificación (20 %)</td><td>Explica por qué su compra cumple y comprueba el sobrante sumando.</td><td>Explica su compra sin comprobar.</td><td>Da el resultado sin explicación.</td><td>No hay respuesta escrita.</td></tr>
</table>
<p><strong>Pesos:</strong> 20 + 30 + 30 + 20 = 100 %.</p>
<p><strong>Ejemplo Alto (Estudiante A):</strong> copia las condiciones sin reformularlas; hace una lista: 12 × 2.500 = 30.000; 12 × 1.500 = 18.000; total 48.000; sobran 12.000. No compara opciones y entrega el resultado sin explicar ni comprobar. Valoración: comprensión Alto (4,3), estrategia Alto (4,2), ejecución Superior (5,0), comunicación Básico (3,5). Nota: 4,3 × 0,2 + 4,2 × 0,3 + 5,0 × 0,3 + 3,5 × 0,2 = 0,86 + 1,26 + 1,5 + 0,7 = <strong>4,32 ≈ 4,3 (Alto)</strong>.</p>
TXT,
      ],
      'revisar' => [
        'Los descriptores mencionan elementos concretos de la tarea (datos, pasos), no adjetivos.',
        'Los pesos suman 100 % y la nota de los ejemplos está bien calculada.',
        'La equivalencia numérica coincide con tu SIEE.',
        'Un error de cálculo aislado no hunde toda la valoración.',
      ],
    ],
    [
      'id' => 'MAT-12',
      'categoria' => 'evaluacion',
      'titulo' => 'Prueba de período con tabla de especificaciones',
      'grados' => '6.° a 11.°',
      'tiempo_ahorrado' => '≈ 2 h',
      'cuando' => 'Cuando preparas la evaluación de final de período y quieres que esté balanceada entre competencias y contenidos, igual que una prueba Saber, en lugar de veinte ejercicios del mismo tipo.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 10.°',
        '[TEMAS]' => 'Temas del período. Ej.: razones trigonométricas, ley de senos y cosenos, repaso de estadística y funciones.',
        '[NUM_ITEMS]' => 'Número de ítems. Ej.: 20.',
        '[DISTRIBUCION]' => 'Pesos deseados. Ej.: 30 % interpretación, 45 % formulación, 25 % argumentación.',
      ],
      'prompt' => <<<'TXT'
Actúa como jefe de área de matemáticas con experiencia en diseño de pruebas alineadas con Saber 11 (competencias: interpretación y representación; formulación y ejecución; argumentación) y con Saber 3.°, 5.° y 9.° cuando el grado lo requiera.

CONTEXTO
Grado: [GRADO]. Temas del período: [TEMAS]. Número de ítems: [NUM_ITEMS]. Distribución deseada: [DISTRIBUCION].

TAREA
1. Construye la tabla de especificaciones: filas = competencias, columnas = categorías o componentes, celdas = número de ítems.
2. Para cada celda, enuncia qué tipo de tarea evaluará (ej.: «calcular una altura con razón tangente a partir de un dibujo»).
3. Escribe los tres primeros ítems completos como muestra, con clave y justificación de distractores.

FORMATO DE SALIDA
- Tabla de especificaciones con totales por fila y por columna.
- Lista de tareas por celda.
- Ítems de muestra.

RESTRICCIONES
- Los totales deben coincidir con [NUM_ITEMS] y los porcentajes con [DISTRIBUCION].
- Al menos un tercio de los ítems con contexto colombiano y datos en tabla o gráfica.
- Ángulos y longitudes posibles (ningún triángulo con lados 2, 3 y 7).

VERIFICACIÓN
- Suma filas y columnas y muéstralo.
- En los ítems de muestra, resuelve de nuevo y comprueba la clave.
- Verifica la desigualdad triangular en cada triángulo y que la suma de ángulos sea 180°.
TXT,
      'seguimientos' => [
        'Completa los ítems restantes de la celda «Formulación y ejecución × Geometría», uno por uno, verificando cada triángulo.',
        'Prepara la versión con ajustes razonables para un estudiante con PIAR: mismas celdas, menos ítems por celda y apoyos de lectura.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 10.° [TEMAS] trigonometría (principal), repaso de estadística y de funciones. [NUM_ITEMS] 20. [DISTRIBUCION] 30 % interpretación y representación, 45 % formulación y ejecución, 25 % argumentación.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Competencia</th><th>Geometría</th><th>Estadística</th><th>Álgebra y cálculo</th><th>Total</th></tr>
<tr><td>Interpretación y representación</td><td>3</td><td>2</td><td>1</td><td>6 (30 %)</td></tr>
<tr><td>Formulación y ejecución</td><td>6</td><td>1</td><td>2</td><td>9 (45 %)</td></tr>
<tr><td>Argumentación</td><td>3</td><td>1</td><td>1</td><td>5 (25 %)</td></tr>
<tr><th>Total</th><th>12</th><th>4</th><th>4</th><th>20</th></tr>
</table>
<h4>Tareas por celda (extracto)</h4>
<ul>
<li><strong>Interpretación × Geometría:</strong> identificar en un dibujo de una rampa del colegio qué lado es el cateto opuesto al ángulo de inclinación.</li>
<li><strong>Formulación × Geometría:</strong> calcular la altura de la torre de la iglesia del pueblo con el ángulo de elevación medido con un transportador casero y la distancia al pie.</li>
<li><strong>Argumentación × Geometría:</strong> decidir si un compañero que usó el seno en lugar de la tangente obtuvo un resultado razonable y por qué.</li>
<li><strong>Interpretación × Estadística:</strong> leer una tabla de precipitación mensual del municipio aportada por el docente.</li>
</ul>
<p><strong>Comprobación:</strong> filas 6 + 9 + 5 = 20; columnas 12 + 4 + 4 = 20; porcentajes 30 + 45 + 25 = 100.</p>
TXT,
      ],
      'revisar' => [
        'Los totales de filas y columnas coinciden con el número de ítems.',
        'La tabla de especificaciones refleja lo que realmente se enseñó en el período.',
        'Cada triángulo de los ítems es posible (desigualdad triangular, suma de ángulos de 180°).',
        'Las categorías y competencias tienen los nombres del ICFES, no inventados.',
      ],
    ],
    [
      'id' => 'MAT-13',
      'categoria' => 'adaptacion',
      'titulo' => 'Adaptación DUA de una guía con múltiples representaciones',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando tienes una guía o taller que funciona para una parte del grupo pero deja por fuera a quienes leen con dificultad, necesitan material o se desconectan, y quieres rediseñarla para todos desde el inicio.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 3.°',
        '[GUIA]' => 'Texto de la guía original o descripción detallada de sus actividades.',
        '[OBJETIVO]' => 'Aprendizaje que no puede cambiar. Ej.: comprender la multiplicación como arreglo rectangular.',
        '[DIVERSIDAD]' => 'Rasgos del grupo sin datos personales. Ej.: 3 estudiantes con baja fluidez lectora, uno con baja visión, varios muy inquietos.',
        '[RECURSOS]' => 'Recursos disponibles. Ej.: tapas, cuadrícula ampliada, celular del docente.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de apoyo pedagógico experto en Diseño Universal para el Aprendizaje (DUA) y en educación inclusiva según el Decreto 1421 de 2017, con dominio de la didáctica de las matemáticas.

CONTEXTO
Grado: [GRADO]. Objetivo de aprendizaje (no se modifica): [OBJETIVO].
Guía original: [GUIA]
Diversidad del grupo: [DIVERSIDAD]. Recursos: [RECURSOS].

TAREA
Rediseña la guía aplicando los tres principios del DUA: múltiples formas de implicación (compromiso), de representación y de acción y expresión. Mantén el mismo objetivo y el mismo nivel de exigencia matemática.

FORMATO DE SALIDA
1. Barreras de la guía original (lectura, abstracción, motivación, forma de respuesta).
2. Guía rediseñada: cada actividad con al menos dos representaciones (concreta, gráfica, numérica, verbal) y opciones de respuesta (dibujar, construir, escribir, explicar oralmente).
3. Tabla: actividad, principio DUA, pauta aplicada, qué barrera elimina.
4. Criterios de logro iguales para todos, con distintas evidencias aceptables.

RESTRICCIONES
- No bajes el objetivo: la adaptación es de acceso, no de contenido.
- Instrucciones de una sola acción por frase, con verbos claros.
- No etiquetes estudiantes ni uses diagnósticos.

VERIFICACIÓN
- Resuelve todas las actividades de la guía rediseñada y verifica que las respuestas son iguales en todas las representaciones.
- Confirma que cada barrera identificada tiene al menos una respuesta en el rediseño.
TXT,
      'seguimientos' => [
        'Prepara la versión en letra grande y alto contraste de la primera página, con indicaciones para imprimirla en blanco y negro.',
        'Escribe el guion para grabar un audio de 2 minutos que explique la actividad 1, para estudiantes que prefieren escuchar.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 3.° [GUIA] taller de 20 multiplicaciones de las tablas del 4 y del 6 en columnas. [OBJETIVO] comprender la multiplicación como arreglo rectangular. [DIVERSIDAD] 3 estudiantes con baja fluidez lectora, una estudiante con baja visión, grupo muy activo. [RECURSOS] tapas, cuadrícula ampliada, bandejas de cartón de huevos.',
        'resultado_html' => <<<'TXT'
<p><strong>Barreras de la guía original:</strong> solo representación simbólica; exige lectura de 20 instrucciones; una sola forma de respuesta; no hay contexto que motive.</p>
<h4>Actividad 1 (rediseñada): la bandeja de pandebonos</h4>
<p>En la panadería, cada bandeja tiene 4 filas de 6 pandebonos. Con tapas, arma una bandeja.</p>
<ul>
<li><strong>Concreto:</strong> 4 filas de 6 tapas. Cuenta por filas: 6, 12, 18, 24.</li>
<li><strong>Gráfico:</strong> colorea en la cuadrícula ampliada un rectángulo de 4 por 6.</li>
<li><strong>Numérico:</strong> 4 × 6 = 24 y 6 + 6 + 6 + 6 = 24.</li>
<li><strong>Verbal:</strong> «Cuatro filas de seis son veinticuatro».</li>
</ul>
<p>Pregunta de extensión: ¿cuántos pandebonos hay en 3 bandejas? 3 × 24 = <strong>72</strong>. Respuesta posible: armar, dibujar, escribir o explicarlo al docente.</p>
<table>
<tr><th>Actividad</th><th>Principio DUA</th><th>Barrera que elimina</th></tr>
<tr><td>Bandeja con tapas</td><td>Representación</td><td>Abstracción sin referente</td></tr>
<tr><td>Escoger cómo mostrar la respuesta</td><td>Acción y expresión</td><td>Exigencia de escritura</td></tr>
<tr><td>Contexto de panadería y reto por parejas</td><td>Implicación</td><td>Desmotivación del grupo activo</td></tr>
<tr><td>Cuadrícula ampliada, trazo grueso</td><td>Representación</td><td>Baja visión</td></tr>
</table>
<p><strong>Criterio común:</strong> relaciona un arreglo de filas y columnas con una multiplicación y halla el total. Evidencias aceptables: construcción, dibujo, escritura o explicación oral.</p>
TXT,
      ],
      'revisar' => [
        'El objetivo de aprendizaje es el mismo que el de la guía original.',
        'Cada actividad tiene al menos dos representaciones con resultados idénticos.',
        'Las instrucciones son cortas y de una acción; no hay párrafos largos.',
        'No se nombra ni se etiqueta a ningún estudiante.',
      ],
    ],
    [
      'id' => 'MAT-14',
      'categoria' => 'adaptacion',
      'titulo' => 'Ajustes razonables para dificultades en matemáticas y apartado de matemáticas del PIAR',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min',
      'cuando' => 'Cuando un estudiante tiene PIAR o presenta dificultades persistentes en el cálculo, el sentido numérico o la memoria de hechos numéricos (con o sin diagnóstico de discalculia) y necesitas definir ajustes concretos para tus clases y evaluaciones.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 6.°',
        '[PERFIL]' => 'Descripción pedagógica anonimizada: fortalezas, barreras observadas, apoyos que funcionan. Sin nombre ni diagnóstico copiado de la historia clínica.',
        '[TEMAS]' => 'Temas del período. Ej.: fracciones, decimales y porcentajes.',
        '[DBA_O_ESTANDAR]' => 'Referente del grado que se mantiene.',
        '[EVALUACION]' => 'Cómo evalúas normalmente. Ej.: talleres, quiz semanal, prueba de período.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas con formación en educación inclusiva en Colombia, conocedor del Decreto 1421 de 2017 (PIAR, ajustes razonables, DUA) y de las dificultades específicas del aprendizaje de las matemáticas.

CONTEXTO
Grado: [GRADO]. Perfil pedagógico (anonimizado): [PERFIL].
Temas del período: [TEMAS]. Referente que se mantiene: [DBA_O_ESTANDAR]. Evaluación habitual: [EVALUACION].

TAREA
Propón el componente de matemáticas del PIAR para este período: metas, barreras, ajustes razonables (didácticos, de evaluación, de materiales y de tiempo) y seguimiento.

FORMATO DE SALIDA
1. Fortalezas para apalancar.
2. Barreras específicas en matemáticas (ej.: recuperación de hechos numéricos, alineación de columnas, lectura de enunciados largos, secuencias de pasos).
3. Tabla de ajustes: tema, barrera, ajuste concreto, quién lo implementa, cómo se verifica.
4. Metas del período observables y medibles, alineadas con el referente del grado.
5. Ajustes en la evaluación: qué se permite (tabla de multiplicar, calculadora, recta numérica, tiempo adicional, lectura en voz alta) y en qué tareas no, según lo que se quiera evaluar.
6. Seguimiento: evidencias y frecuencia.

RESTRICCIONES
- No diagnostiques ni uses lenguaje clínico. Habla de barreras y apoyos.
- No reduzcas el currículo a contenidos de grados inferiores sin justificar; prioriza el acceso.
- Recuerda que el PIAR se construye con la familia, el estudiante y el docente de apoyo; señala qué se debe acordar con ellos.

VERIFICACIÓN
- Revisa que cada barrera tenga al menos un ajuste y que cada ajuste tenga una forma de verificación.
- Confirma que las metas se pueden observar en una producción del estudiante.
TXT,
      'seguimientos' => [
        'Redacta una versión del quiz semanal con los ajustes aplicados, con los mismos aprendizajes que la versión del grupo.',
        'Escribe la explicación para la familia, en lenguaje sencillo, de por qué se permite la calculadora en algunas tareas y no en otras.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 6.° [PERFIL] Estudiante A: buen razonamiento verbal y espacial, explica bien estrategias oralmente; tarda mucho en recuperar resultados de multiplicaciones, invierte cifras al copiar y se pierde en procedimientos de más de tres pasos. [TEMAS] fracciones, decimales y porcentajes. [EVALUACION] talleres y prueba de período.',
        'resultado_html' => <<<'TXT'
<p><strong>Fortalezas:</strong> explica estrategias en voz alta, comprende situaciones de dinero y reparto, buen manejo de dibujos y esquemas.</p>
<table>
<tr><th>Tema</th><th>Barrera</th><th>Ajuste razonable</th><th>Verificación</th></tr>
<tr><td>Fracciones equivalentes</td><td>Recuperación lenta de hechos multiplicativos</td><td>Tabla de multiplicar plastificada en el pupitre; el objetivo es la equivalencia, no el cálculo.</td><td>Resuelve 4 de 5 ejercicios de equivalencia con la tabla.</td></tr>
<tr><td>Decimales</td><td>Invierte cifras y desalinea columnas</td><td>Hoja cuadriculada con columnas de valor posicional marcadas; tablero de valor posicional.</td><td>Ubica la coma correctamente en 4 de 5 sumas.</td></tr>
<tr><td>Porcentajes</td><td>Secuencias largas de pasos</td><td>Tarjeta de pasos (1. ¿Qué es el 100 %? 2. Busco el 10 %. 3. Combino) y problemas divididos en preguntas guía.</td><td>Calcula el 10 %, 20 % y 5 % de un precio en contexto.</td></tr>
</table>
<p><strong>Meta del período:</strong> resuelve problemas de descuentos sencillos en la tienda (ej.: 20 % de $15.000 = $3.000) explicando oralmente o por escrito su estrategia, con apoyo de la tarjeta de pasos.</p>
<p><strong>En la evaluación:</strong> se permite calculadora cuando se evalúa la estrategia de porcentajes; no se permite cuando se evalúa la estimación. Tiempo adicional del 50 %, lectura en voz alta de enunciados y posibilidad de responder oralmente un ítem por sección.</p>
<p><strong>Por acordar con la familia y el docente de apoyo:</strong> uso de la tabla en casa, rutina de 10 minutos de juegos de hechos numéricos y fecha de revisión del PIAR.</p>
TXT,
      ],
      'revisar' => [
        'No aparece un diagnóstico clínico ni lenguaje que etiquete al estudiante.',
        'Cada ajuste tiene una forma de verificación observable.',
        'Las metas siguen alineadas con el referente del grado; no se reemplazó el currículo por el de grados inferiores.',
        'Los cálculos de los ejemplos (porcentajes, descuentos) son correctos.',
        'Se señalan los acuerdos con la familia, el estudiante y el docente de apoyo.',
      ],
    ],
    [
      'id' => 'MAT-15',
      'categoria' => 'adaptacion',
      'titulo' => 'Reto de enriquecimiento para estudiantes avanzados',
      'grados' => '5.° a 11.°',
      'tiempo_ahorrado' => '≈ 40 min',
      'cuando' => 'Cuando algunos estudiantes terminan rápido y bien, y quieres darles profundidad (no más ejercicios iguales): un problema rico que sorprenda, conecte ideas y exija argumentar.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 9.°',
        '[TEMA_BASE]' => 'Tema que ya dominan. Ej.: velocidad, razones y ecuaciones.',
        '[CONTEXTO]' => 'Contexto atractivo. Ej.: la Vuelta a Colombia subiendo el Alto de La Línea.',
        '[TIEMPO]' => 'Tiempo disponible. Ej.: 2 sesiones.',
      ],
      'prompt' => <<<'TXT'
Actúa como entrenador de olimpiadas de matemáticas en Colombia y como docente de aula que trabaja con estudiantes de alto desempeño.

CONTEXTO
Grado: [GRADO]. Tema base que dominan: [TEMA_BASE]. Contexto: [CONTEXTO]. Tiempo: [TIEMPO].

TAREA
Diseña un reto de enriquecimiento con una intuición falsa que el estudiante tenga que superar, varias preguntas encadenadas de dificultad creciente y una extensión abierta que permita generalizar.

FORMATO DE SALIDA
1. Enunciado del reto con datos realistas.
2. La intuición falsa que probablemente tendrán y por qué falla.
3. Preguntas encadenadas (4 a 6) con solución completa.
4. Generalización algebraica y su demostración.
5. Extensión abierta sin respuesta única.
6. Criterios para valorar la argumentación.

RESTRICCIONES
- Datos plausibles para el contexto (velocidades, distancias y tiempos de ciclistas reales en orden de magnitud).
- No uses contenidos de grados superiores sin introducirlos.
- La solución debe estar completa y ser verificable con calculadora.

VERIFICACIÓN
- Resuelve todas las preguntas por dos caminos (numérico y algebraico) y confirma que coinciden.
- Revisa que la intuición falsa efectivamente lleve a una respuesta distinta de la correcta.
TXT,
      'seguimientos' => [
        'Escribe tres pistas graduadas para quien se quede bloqueado, de la más leve a la más directa.',
        'Propón cómo presentarían el reto al resto del curso en 5 minutos, para que todos se beneficien.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 9.° [TEMA_BASE] velocidad media, fracciones y ecuaciones. [CONTEXTO] etapa de montaña de la Vuelta a Colombia. [TIEMPO] 2 sesiones.',
        'resultado_html' => <<<'TXT'
<p><strong>Reto:</strong> en una etapa, un ciclista sube un puerto de 20 km a 15 km/h y baja los mismos 20 km a 45 km/h. ¿Cuál fue su velocidad media en los 40 km?</p>
<p><strong>Intuición falsa:</strong> (15 + 45) ÷ 2 = 30 km/h. Falla porque el ciclista pasa mucho más tiempo subiendo que bajando.</p>
<ol>
<li>Tiempo de subida: 20 ÷ 15 = 4/3 h = 80 min.</li>
<li>Tiempo de bajada: 20 ÷ 45 = 4/9 h ≈ 26,7 min.</li>
<li>Tiempo total: 4/3 + 4/9 = 16/9 h.</li>
<li>Velocidad media: 40 ÷ (16/9) = 40 × 9/16 = <strong>22,5 km/h</strong>.</li>
<li>¿A qué velocidad debería bajar para que la media fuera 30 km/h? Necesitaría hacer los 40 km en 40 ÷ 30 = 4/3 h = 80 min, pero ya gastó 80 min subiendo. <strong>Es imposible</strong>, por rápido que baje.</li>
</ol>
<p><strong>Generalización:</strong> para dos tramos de igual distancia d a velocidades v₁ y v₂, la media es 2d ÷ (d/v₁ + d/v₂) = 2v₁v₂ ÷ (v₁ + v₂), la media armónica. Comprobación: 2 × 15 × 45 ÷ 60 = 1.350 ÷ 60 = 22,5.</p>
<p><strong>Extensión abierta:</strong> ¿qué pasa si los tramos no tienen la misma distancia? ¿Cuándo la media aritmética sí es correcta? (Pista: cuando los tiempos, y no las distancias, son iguales.)</p>
TXT,
      ],
      'revisar' => [
        'Las velocidades y distancias son plausibles para ciclismo profesional.',
        'La solución completa está verificada y la generalización reproduce el resultado numérico.',
        'La intuición falsa lleva efectivamente a otra respuesta.',
        'El reto no se resuelve con una fórmula que se pueda buscar sin pensar.',
      ],
    ],
    [
      'id' => 'MAT-16',
      'categoria' => 'adaptacion',
      'titulo' => 'Planeación multigrado (Escuela Nueva) con un mismo contexto para varios grados',
      'grados' => 'Transición a 5.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min',
      'cuando' => 'Cuando eres docente de escuela rural multigrado y necesitas que todos los grados trabajen sobre el mismo contexto al mismo tiempo, cada uno con el aprendizaje de su grado.',
      'variables' => [
        '[GRADOS]' => 'Grados presentes y número de niños por grado. Ej.: 1.° (3), 2.° (4), 3.° (2), 4.° (5), 5.° (3).',
        '[CONTEXTO_RURAL]' => 'Actividad productiva o cotidiana de la vereda. Ej.: la cosecha de café.',
        '[TIEMPO]' => 'Duración. Ej.: una semana, 1 hora diaria.',
        '[MATERIAL]' => 'Material disponible. Ej.: granos de café, balanza de la finca, cuadernos.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente rural colombiano experto en el modelo Escuela Nueva, en aulas multigrado y en las mallas de aprendizaje de Matemáticas (MEN, 2017).

CONTEXTO
Grados y número de niños: [GRADOS]. Contexto de la vereda: [CONTEXTO_RURAL]. Tiempo: [TIEMPO]. Material: [MATERIAL].

TAREA
Diseña una semana de trabajo de matemáticas en la que todos los grados partan del mismo contexto. Cada grado trabaja un aprendizaje propio de su grado (descríbelo por contenido, sin inventar números de DBA).

FORMATO DE SALIDA
1. Momento común de apertura (todos juntos, 10 minutos).
2. Tabla: grado, aprendizaje, tarea con datos, material, producto, respuesta esperada.
3. Cómo rota el docente entre grupos y qué hacen los niños mayores como monitores sin resolverle la tarea al menor.
4. Momento común de cierre en el que cada grado aporta algo a una conclusión colectiva.

RESTRICCIONES
- Datos coherentes con la realidad de la vereda (kilos recolectados por día, precios pagados por kilo) y marcados como «referencia; pregunten en la vereda el valor de este año».
- Cantidades enteras donde corresponda (niños, bultos, días).
- Lenguaje sencillo, sin tecnicismos para los niños.

VERIFICACIÓN
- Resuelve la tarea de cada grado y muestra la operación.
- Confirma que la tarea de cada grado corresponde a su nivel y no al de otro grado.
TXT,
      'seguimientos' => [
        'Prepara las tarjetas de trabajo de cada grado para imprimir, con instrucciones de una línea y un dibujo sugerido.',
        'Propón una tarea para hacer en la casa con la familia que también use el contexto de la cosecha.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADOS] 1.° a 5.° en una sede rural de Caldas. [CONTEXTO_RURAL] cosecha de café. [TIEMPO] una semana. [MATERIAL] granos de café, balanza, cuadernos. Valor de referencia por kilo recolectado: $1.100.',
        'resultado_html' => <<<'TXT'
<p><strong>Apertura común:</strong> «¿Cuántos kilos recoge en un día un recolector de la finca de don Hernán y cuánto le pagan?» Los niños cuentan lo que saben de sus familias.</p>
<table>
<tr><th>Grado</th><th>Aprendizaje</th><th>Tarea y respuesta esperada</th></tr>
<tr><td>1.°</td><td>Conteo y agrupación de 10 en 10</td><td>Cuentan un puñado de granos haciendo grupos de 10. Ej.: 4 grupos y 7 sueltos son 47 granos.</td></tr>
<tr><td>2.°</td><td>Suma con reagrupación</td><td>Don Hernán recogió 38 kg el lunes y 45 kg el martes. 38 + 45 = <strong>83 kg</strong>.</td></tr>
<tr><td>3.°</td><td>Multiplicación como suma repetida</td><td>6 recolectores recogen cada uno 40 kg. 6 × 40 = <strong>240 kg</strong>.</td></tr>
<tr><td>4.°</td><td>Fracción como operador</td><td>De 80 kg, 1/4 se despulpó antes del almuerzo. 80 ÷ 4 = <strong>20 kg</strong>.</td></tr>
<tr><td>5.°</td><td>Multiplicación con decimales en contexto de dinero</td><td>Doña Luz recogió 75,5 kg y le pagan $1.100 por kilo. 75,5 × 1.100 = <strong>$83.050</strong>.</td></tr>
</table>
<p><strong>Monitores:</strong> los de 5.° revisan el conteo de 1.° preguntando «¿cuántos grupos de 10 tienes?», sin contar por ellos.</p>
<p><strong>Cierre común:</strong> cartelera «Las matemáticas de la cosecha»: cada grado pega su resultado y explica su operación en una frase.</p>
TXT,
      ],
      'revisar' => [
        'Las tareas de cada grado corresponden a su nivel según las mallas o los DBA de ese grado.',
        'Los valores de kilos y pagos son razonables para tu región y están marcados como referencia.',
        'Todas las respuestas están calculadas correctamente.',
        'El rol de los monitores no consiste en resolverle la tarea al menor.',
      ],
    ],
    [
      'id' => 'MAT-17',
      'categoria' => 'recursos',
      'titulo' => 'Guía de trabajo con material concreto (regletas, geoplano, tangram, ábaco)',
      'grados' => 'Transición a 7.°',
      'tiempo_ahorrado' => '≈ 50 min',
      'cuando' => 'Cuando tienes material concreto en el colegio (a veces guardado en cajas del PTA) y quieres una guía en la que el material sea la herramienta para pensar y no solo un juego al inicio de la clase.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 4.°',
        '[MATERIAL]' => 'Material y cantidad. Ej.: 10 tangram de cartón para trabajar en parejas.',
        '[APRENDIZAJE]' => 'Lo que se quiere construir. Ej.: fracciones como partes de un todo y fracciones equivalentes.',
        '[DURACION]' => 'Duración. Ej.: 2 sesiones de 55 min.',
      ],
      'prompt' => <<<'TXT'
Actúa como formador de docentes de primaria en Colombia, experto en el uso didáctico de material concreto (regletas de Cuisenaire, geoplano, tangram, ábaco, bloques de base 10) y en las mallas de aprendizaje del MEN.

CONTEXTO
Grado: [GRADO]. Material: [MATERIAL]. Aprendizaje: [APRENDIZAJE]. Duración: [DURACION].

TAREA
Escribe una guía para el estudiante y una nota para el docente. La guía va de la exploración libre a preguntas que solo se responden manipulando el material, y termina con el registro en el cuaderno (dibujo y símbolo).

FORMATO DE SALIDA
1. Nota para el docente: qué propiedad matemática del material se aprovecha, normas de uso, errores esperados.
2. Guía del estudiante: exploración (5 min), 5 a 7 retos graduados, registro.
3. Respuestas de cada reto con la justificación que se espera del estudiante.
4. Pregunta de cierre que conecte el material con la representación simbólica.

RESTRICCIONES
- Las relaciones de tamaño, área o valor que uses deben ser las reales del material estándar (ej.: en el tangram tradicional los dos triángulos grandes son cada uno 1/4 del cuadrado).
- Retos realizables con la cantidad de material disponible.
- Lenguaje de [GRADO].

VERIFICACIÓN
- Comprueba que las fracciones o valores de todas las piezas suman el total.
- Verifica cada respuesta por superposición o conteo y explica cómo se comprueba con el material.
TXT,
      'seguimientos' => [
        'Diseña la versión de esta guía con el geoplano para trabajar área: mismas ideas de composición y descomposición.',
        'Escribe cinco preguntas orales para hacer mientras los estudiantes manipulan, que los lleven a justificar y no solo a mostrar.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 4.° [MATERIAL] tangram tradicional de 7 piezas, en parejas. [APRENDIZAJE] fracciones como parte de un todo y fracciones equivalentes. [DURACION] 2 sesiones.',
        'resultado_html' => <<<'TXT'
<p><strong>Nota para el docente:</strong> el cuadrado completo es la unidad. Las piezas guardan relaciones exactas: el triángulo pequeño cabe dos veces en el cuadrado, en el triángulo mediano y en el paralelogramo, y estos tres caben dos veces en un triángulo grande.</p>
<table>
<tr><th>Pieza</th><th>Fracción del cuadrado</th><th>En dieciseisavos</th></tr>
<tr><td>Triángulo grande (2)</td><td>1/4 cada uno</td><td>4/16 cada uno</td></tr>
<tr><td>Triángulo mediano</td><td>1/8</td><td>2/16</td></tr>
<tr><td>Cuadrado</td><td>1/8</td><td>2/16</td></tr>
<tr><td>Paralelogramo</td><td>1/8</td><td>2/16</td></tr>
<tr><td>Triángulo pequeño (2)</td><td>1/16 cada uno</td><td>1/16 cada uno</td></tr>
</table>
<p>Suma: 4 + 4 + 2 + 2 + 2 + 1 + 1 = 16 dieciseisavos = el cuadrado completo.</p>
<h4>Retos (extracto)</h4>
<ol>
<li>¿Cuántos triángulos pequeños necesitas para cubrir el cuadrado de la pieza? <em>2. Se comprueba superponiendo.</em></li>
<li>Si el cuadrado grande es 1, ¿qué parte es un triángulo grande? <em>1/4: cuatro triángulos grandes cubrirían el cuadrado (hay dos, pero se puede trazar el contorno y moverlo).</em></li>
<li>Busca dos formas distintas de cubrir un triángulo grande con otras piezas. <em>Ej.: cuadrado + 2 triángulos pequeños; triángulo mediano + 2 triángulos pequeños. Por eso 1/4 = 1/8 + 1/16 + 1/16.</em></li>
<li>¿El paralelogramo y el cuadrado son la misma fracción aunque tengan distinta forma? <em>Sí, 1/8 cada uno: cada uno se cubre con dos triángulos pequeños.</em></li>
</ol>
<p><strong>Cierre:</strong> «Escribe una suma de fracciones que dé 1/2 usando piezas distintas.» Ej.: 1/4 + 1/8 + 1/16 + 1/16 = 1/2.</p>
TXT,
      ],
      'revisar' => [
        'Las fracciones asignadas a cada pieza son las del tangram tradicional y suman 1.',
        'Cada respuesta se puede comprobar con el material (superposición o conteo).',
        'Hay registro gráfico y simbólico al final, no solo manipulación.',
        'Los retos son realizables con la cantidad de material del salón.',
      ],
    ],
    [
      'id' => 'MAT-18',
      'categoria' => 'recursos',
      'titulo' => 'Actividad con GeoGebra: explorar parámetros con deslizadores',
      'grados' => '6.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando tienes sala de informática, tabletas o celulares y quieres que los estudiantes descubran el efecto de cada parámetro de una función o de una transformación, en lugar de memorizarlo.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 10.°',
        '[OBJETO]' => 'Función o construcción. Ej.: función cuadrática h(t) = at² + bt + c.',
        '[CONTEXTO]' => 'Situación. Ej.: trayectoria de un balón en un partido de la Liga BetPlay.',
        '[DISPOSITIVOS]' => 'Ej.: sala con 20 computadores, GeoGebra Clásico sin internet.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas colombiano experto en GeoGebra y en el pensamiento variacional.

CONTEXTO
Grado: [GRADO]. Objeto matemático: [OBJETO]. Contexto: [CONTEXTO]. Dispositivos: [DISPOSITIVOS].

TAREA
Escribe una guía paso a paso para construir en GeoGebra una actividad con deslizadores y una serie de preguntas de exploración y conjetura.

FORMATO DE SALIDA
1. Construcción: cada paso con el comando exacto que se escribe en la barra de entrada (comandos de GeoGebra en español) y qué debe aparecer en pantalla.
2. Preguntas de exploración: «mueve el deslizador… ¿qué pasa con…?».
3. Conjeturas que se espera que formulen y cómo verificarlas algebraicamente.
4. Una pregunta de aplicación al contexto con respuesta numérica.
5. Plan B si no hay computadores (GeoGebra en celular o tabla de valores en papel).

RESTRICCIONES
- Recuerda que en GeoGebra los decimales se escriben con punto aunque en el cuaderno se use coma; adviértelo en la guía.
- Valores físicamente razonables para el contexto (alturas y tiempos de un balón real).
- Si un comando puede variar entre versiones, ofrece la alternativa.

VERIFICACIÓN
- Calcula a mano el vértice, las raíces y el corte con el eje vertical para los valores iniciales de los deslizadores y compáralos con lo que mostraría GeoGebra.
- Revisa que la respuesta de aplicación tenga unidades.
TXT,
      'seguimientos' => [
        'Agrega una segunda parte en la que los estudiantes ajusten la parábola a una foto de un tiro libre insertada como imagen de fondo.',
        'Escribe un quiz de salida de dos preguntas sobre el efecto del parámetro a.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 10.° [OBJETO] h(t) = at² + bt + c. [CONTEXTO] un portero despeja el balón desde 1 m de altura. [DISPOSITIVOS] sala de informática con GeoGebra Clásico.',
        'resultado_html' => <<<'TXT'
<p><strong>Aviso:</strong> en GeoGebra escribe 1.5, no 1,5. En el cuaderno seguimos usando coma decimal.</p>
<h4>Construcción</h4>
<ol>
<li>Crea los deslizadores: <code>a = Deslizador(-10, 0, 0.1)</code>, <code>b = Deslizador(0, 30, 0.5)</code>, <code>c = Deslizador(0, 3, 0.1)</code>. Ajústalos a a = −5, b = 15, c = 1.</li>
<li>Escribe <code>h(x) = a x^2 + b x + c</code>. Aparece una parábola que abre hacia abajo.</li>
<li>Escribe <code>Extremo(h)</code> y <code>Raíz(h)</code> para ver el punto más alto y los cortes con el eje horizontal.</li>
</ol>
<h4>Verificación a mano con a = −5, b = 15, c = 1</h4>
<ul>
<li>Vértice: t = −b ÷ (2a) = −15 ÷ (−10) = 1,5 s. h(1,5) = −5(2,25) + 22,5 + 1 = <strong>12,25 m</strong>.</li>
<li>Corte con el eje vertical: h(0) = 1 m, la altura desde donde sale el balón.</li>
<li>Raíz positiva: t = (15 + √245) ÷ 10 ≈ <strong>3,07 s</strong>; la otra raíz (≈ −0,07 s) no tiene sentido en el contexto.</li>
</ul>
<h4>Exploración</h4>
<ul>
<li>Mueve b manteniendo a y c. ¿Qué pasa con la altura máxima y con el tiempo en el aire?</li>
<li>¿Por qué a debe ser negativo en este contexto? (Relación con la gravedad: a ≈ −4,9 m/s² si t está en segundos; usamos −5 para simplificar.)</li>
<li>¿Qué representa c? ¿Qué pasaría con un despeje desde el suelo?</li>
</ul>
<p><strong>Aplicación:</strong> si el travesaño de la portería está a 2,44 m, ¿en qué momentos el balón está por encima de esa altura?</p>
TXT,
      ],
      'revisar' => [
        'Los comandos están en español y funcionan en tu versión de GeoGebra (pruébalos antes de clase).',
        'La guía advierte el uso del punto decimal en GeoGebra.',
        'El vértice, las raíces y los cortes calculados a mano son correctos.',
        'Se descartan las soluciones sin sentido en el contexto (tiempos negativos).',
      ],
    ],
    [
      'id' => 'MAT-19',
      'categoria' => 'recursos',
      'titulo' => 'Hoja de cálculo para modelar un recibo de servicios públicos con estratos',
      'grados' => '6.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando quieres que los estudiantes construyan fórmulas en una hoja de cálculo para una situación que conocen en casa: cómo se calcula el recibo del agua o de la energía según el estrato y el consumo.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 8.°',
        '[SERVICIO]' => 'Servicio. Ej.: acueducto.',
        '[DATOS_RECIBO]' => 'Datos de un recibo real sin datos personales: cargo fijo, valor por m³ o kWh, consumo básico o de subsistencia, porcentaje de subsidio o contribución.',
        '[SOFTWARE]' => 'Programa. Ej.: Excel en español, LibreOffice Calc o Google Sheets.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas e informática en un colegio colombiano, experto en hojas de cálculo y en educación económica y financiera.

CONTEXTO
Grado: [GRADO]. Servicio: [SERVICIO]. Datos (tomados de un recibo real, sin datos personales): [DATOS_RECIBO]. Programa: [SOFTWARE].

TAREA
Diseña una actividad en la que los estudiantes construyan una hoja que calcule el valor del recibo para distintos hogares según su consumo y estrato.

FORMATO DE SALIDA
1. Estructura de la hoja: columnas, encabezados y qué va en cada celda.
2. Fórmulas exactas, escritas como se digitan en [SOFTWARE] con configuración regional de Colombia (separador de argumentos punto y coma, coma decimal), y su alternativa con coma si la configuración es otra.
3. Tres hogares de prueba con el resultado calculado a mano, paso a paso.
4. Preguntas de análisis: función por tramos, efecto del subsidio, cuánto ahorra un hogar que baja su consumo.
5. Extensión: gráfica de valor del recibo frente a consumo y discusión de la pendiente en cada tramo.

RESTRICCIONES
- Usa solo los datos que te di. Si falta alguno, escribe «[dato del recibo]» y no inventes tarifas oficiales.
- Aclara que el consumo básico y los porcentajes de subsidio dependen de la regulación vigente y del municipio.
- Valores con punto de miles y coma decimal en el texto.

VERIFICACIÓN
- Calcula a mano los tres hogares de prueba y comprueba que la fórmula da lo mismo.
- Revisa los casos frontera: consumo igual al básico y consumo cero.
TXT,
      'seguimientos' => [
        'Agrega una columna que calcule el consumo máximo para que el recibo no supere un presupuesto dado, y explica qué ecuación resuelve.',
        'Diseña la versión en papel para colegios sin sala de informática, con una tabla para llenar a mano.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 8.° [SERVICIO] acueducto en una ciudad a más de 2.000 msnm. [DATOS_RECIBO] datos simplificados: cargo fijo $12.000 (sin subsidio, para simplificar); $3.800 por m³; consumo básico 11 m³; subsidio estrato 2 del 40 % sobre el consumo básico. [SOFTWARE] Excel en español.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Columna</th><th>Contenido</th></tr>
<tr><td>A</td><td>Hogar (A, B, C…)</td></tr>
<tr><td>B</td><td>Consumo (m³)</td></tr>
<tr><td>C</td><td>Consumo básico (m³)</td></tr>
<tr><td>D</td><td>Valor por m³</td></tr>
<tr><td>E</td><td>Subsidio (como decimal: 0,4)</td></tr>
<tr><td>F</td><td>Cargo fijo</td></tr>
<tr><td>G</td><td>Valor del consumo</td></tr>
<tr><td>H</td><td>Total del recibo</td></tr>
</table>
<p><strong>Fórmula en G2:</strong> <code>=MIN(B2;C2)*D2*(1-E2)+MAX(B2-C2;0)*D2</code><br><strong>En H2:</strong> <code>=G2+F2</code><br>(Si tu Excel usa coma como separador: <code>=MIN(B2,C2)*D2*(1-E2)+MAX(B2-C2,0)*D2</code>.)</p>
<h4>Hogares de prueba</h4>
<ul>
<li><strong>Hogar A, estrato 2, 18 m³:</strong> 11 × 3.800 × 0,6 = 25.080; 7 × 3.800 = 26.600; consumo 51.680; total 51.680 + 12.000 = <strong>$63.680</strong>.</li>
<li><strong>Hogar B, estrato 2, 9 m³:</strong> 9 × 3.800 × 0,6 = 20.520; total <strong>$32.520</strong>.</li>
<li><strong>Hogar C, estrato 4 (sin subsidio), 18 m³:</strong> 18 × 3.800 = 68.400; total <strong>$80.400</strong>.</li>
</ul>
<p><strong>Casos frontera:</strong> con 11 m³ en estrato 2, el consumo vale 11 × 3.800 × 0,6 = 25.080. Con 0 m³, el recibo es solo el cargo fijo: $12.000.</p>
<p><strong>Análisis:</strong> en estrato 2 la pendiente es $2.280 por m³ hasta 11 m³ y $3.800 por m³ después. ¿Por qué el recibo del hogar A no es el doble del hogar B aunque consume el doble?</p>
<p><em>Datos simplificados. El consumo básico, los subsidios y las contribuciones dependen de la regulación vigente y de tu municipio: compáralos con un recibo real.</em></p>
TXT,
      ],
      'revisar' => [
        'Las fórmulas usan el separador correcto para la configuración regional del equipo (punto y coma en español de Colombia).',
        'Los resultados a mano coinciden con los de la hoja.',
        'Las tarifas están marcadas como simplificadas o tomadas de un recibo real; no se presentan como oficiales sin fuente.',
        'Se revisan los casos frontera (consumo igual al básico, consumo cero).',
      ],
    ],
    [
      'id' => 'MAT-20',
      'categoria' => 'recursos',
      'titulo' => 'Problemas de educación financiera: ahorro, interés y crédito frente al gota a gota',
      'grados' => '7.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h 15 min',
      'cuando' => 'Cuando trabajas porcentajes, funciones exponenciales o interés compuesto y quieres conectarlos con decisiones reales de las familias: ahorrar, endeudarse en el banco o caer en un préstamo gota a gota.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 11.°',
        '[TEMA]' => 'Ej.: interés simple, interés compuesto y tasa efectiva anual.',
        '[SITUACION]' => 'Situación de partida. Ej.: una familia necesita $500.000 para arreglar la moto con la que trabaja.',
        '[TASAS]' => 'Tasas que tú consultaste: tasa de usura vigente (Superintendencia Financiera), tasa de un CDT o cuenta de ahorro, condiciones típicas del gota a gota.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas y educador financiero en Colombia, conocedor del sistema financiero formal y de los riesgos del préstamo informal conocido como gota a gota.

CONTEXTO
Grado: [GRADO]. Tema: [TEMA]. Situación: [SITUACION]. Tasas consultadas por el docente: [TASAS].

TAREA
Diseña una secuencia de 4 a 6 problemas encadenados en la que los estudiantes comparen el costo real de distintas opciones y tomen una decisión argumentada.

FORMATO DE SALIDA
1. Problemas con datos, del más sencillo (interés simple) al más complejo (tasa efectiva anual equivalente).
2. Solución de cada uno con todas las operaciones y fórmulas (I = C·i·t; M = C(1 + i)ⁿ; tasa efectiva anual = (1 + i_mensual)¹² − 1).
3. Tabla comparativa final de las opciones: cuánto se paga en total y tasa efectiva anual.
4. Preguntas de discusión sobre riesgos, alternativas formales (bancos, cooperativas, microcrédito vigilado) y derechos del consumidor financiero.

RESTRICCIONES
- Usa solo las tasas que te di; si falta la tasa de usura, escribe «[tasa de usura vigente]» y no inventes un valor.
- No promociones entidades financieras por su nombre.
- Trata el gota a gota como riesgo (intimidación, violencia, cobros abusivos), sin dar indicaciones para acceder a él.
- Valores en pesos colombianos con punto de miles; porcentajes con coma decimal.

VERIFICACIÓN
- Recalcula cada monto con calculadora y muestra el resultado con dos decimales cuando sea porcentaje.
- Comprueba que la tasa efectiva anual del gota a gota se calculó con capitalización mensual y no multiplicando por 12.
TXT,
      'seguimientos' => [
        'Construye la tabla de amortización de un crédito formal de $500.000 a 6 meses con cuota fija, usando la tasa mensual que te di, y verifica que el saldo final es cero.',
        'Escribe un caso para debatir en clase: una vecina ofrece «plata fácil sin papeles». ¿Qué preguntas matemáticas y qué preguntas de seguridad debería hacerse la familia?',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 11.° [TEMA] interés simple, compuesto y tasa efectiva. [SITUACION] una familia necesita $500.000 para reparar la moto con la que trabaja. [TASAS] gota a gota: entregan $500.000 y cobran 30 cuotas diarias de $20.000; ahorro hipotético al 10 % efectivo anual; tasa de usura: la consulta el docente.',
        'resultado_html' => <<<'TXT'
<h4>Problema 1: el costo real del gota a gota</h4>
<p>Total pagado: 30 × 20.000 = $600.000. Intereses: 600.000 − 500.000 = $100.000 en 30 días.</p>
<p>Tasa mensual: 100.000 ÷ 500.000 = 0,20 = <strong>20 % mensual</strong>.</p>
<h4>Problema 2: ¿cuánto es eso al año?</h4>
<p>Error frecuente: 20 % × 12 = 240 % anual. Pero si la deuda se renueva mes a mes, los intereses se acumulan: tasa efectiva anual = (1,20)¹² − 1 ≈ 8,9161 − 1 = 7,9161, es decir, <strong>cerca de 791,61 % efectivo anual</strong>.</p>
<p>Compárenla con la [tasa de usura vigente] certificada por la Superintendencia Financiera. ¿Cuántas veces mayor es?</p>
<h4>Problema 3: ahorrar en lugar de endeudarse</h4>
<p>Si la familia ahorra $1.000.000 durante 3 años al 10 % efectivo anual:</p>
<ul>
<li>Interés simple: 1.000.000 × 0,10 × 3 = 300.000; monto $1.300.000.</li>
<li>Interés compuesto: 1.000.000 × 1,1³ = 1.000.000 × 1,331 = <strong>$1.331.000</strong>.</li>
</ul>
<p>La diferencia de $31.000 son intereses sobre intereses.</p>
<h4>Discusión</h4>
<ul>
<li>¿Por qué el gota a gota cobra cuotas diarias y no mensuales? ¿Qué efecto tiene en un hogar con ingresos variables?</li>
<li>¿Qué riesgos, además del dinero, implica este préstamo? ¿A quién se puede acudir si hay amenazas? (Línea 123 de la Policía.)</li>
</ul>
TXT,
      ],
      'revisar' => [
        'La tasa efectiva anual se calculó con potencia, no multiplicando la tasa mensual por 12.',
        'No hay una tasa de usura inventada: está la que tú consultaste o un espacio para llenarla.',
        'Los montos de interés simple y compuesto están bien calculados.',
        'El gota a gota se presenta como riesgo y no se mencionan entidades por nombre.',
      ],
    ],
    [
      'id' => 'MAT-21',
      'categoria' => 'recursos',
      'titulo' => 'Geometría y cultura: transformaciones en molas, tejidos wayuu y el sombrero vueltiao',
      'grados' => '4.° a 9.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando enseñas simetrías, traslaciones, rotaciones o frisos y quieres partir de diseños de pueblos indígenas colombianos con respeto por su significado cultural.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 7.°',
        '[TRANSFORMACIONES]' => 'Ej.: traslación, reflexión y rotación de 180°; frisos.',
        '[ARTESANIA]' => 'Ej.: mola guna, tejido wayuu, sombrero vueltiao (pueblo zenú).',
        '[RECURSOS]' => 'Ej.: fotos tomadas por el docente, papel cuadriculado, espejos pequeños.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas con enfoque de etnomatemáticas, que trabaja en Colombia con respeto por los saberes de los pueblos indígenas.

CONTEXTO
Grado: [GRADO]. Transformaciones: [TRANSFORMACIONES]. Artesanía de referencia: [ARTESANIA]. Recursos: [RECURSOS].

TAREA
Diseña una actividad en la que los estudiantes identifiquen el motivo mínimo de un diseño, las transformaciones que lo generan y luego creen su propio friso en papel cuadriculado.

FORMATO DE SALIDA
1. Contexto cultural breve y verificable (pueblo, región, quién elabora la artesanía), con la advertencia de no atribuir significados que no se conocen.
2. Descripción exacta, en cuadrícula, de un motivo y del friso que forma (coordenadas o número de cuadros), para que el docente lo dibuje.
3. Preguntas para identificar traslación (vector), reflexión (eje) y rotación (centro y ángulo).
4. Reto de creación con criterios.
5. Respuestas esperadas.

RESTRICCIONES
- No inventes significados simbólicos de los diseños; si no estás seguro, di «consultar con la comunidad o con un sabedor».
- No uses los diseños como mera decoración: la matemática debe salir del diseño.
- Advierte que los diseños tradicionales no se deben reproducir con fines comerciales.

VERIFICACIÓN
- Aplica tú las transformaciones descritas sobre las coordenadas del motivo y comprueba que generan el friso descrito.
- Revisa que la clasificación de cada transformación sea correcta (una reflexión invierte la orientación; una traslación no).
TXT,
      'seguimientos' => [
        'Agrega una actividad de homotecia: ampliar el motivo al doble en la cuadrícula y calcular cómo cambian perímetro y área.',
        'Escribe la invitación a una sabedora o artesana de la comunidad para que visite la clase, con preguntas preparadas por los estudiantes.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 7.° [TRANSFORMACIONES] traslación, reflexión con eje vertical y rotación de 180°. [ARTESANIA] franjas escalonadas inspiradas en tejidos wayuu y en las trenzas del sombrero vueltiao. [RECURSOS] papel cuadriculado y espejos.',
        'resultado_html' => <<<'TXT'
<p><strong>Contexto:</strong> el pueblo wayuu (La Guajira) teje mochilas y chinchorros con diseños geométricos llamados kanaas; el sombrero vueltiao se elabora con fibra de caña flecha, trenzada principalmente por familias del pueblo zenú en Córdoba y Sucre. Cada diseño tiene nombre y sentido para sus comunidades: no les asignaremos significados que no conocemos.</p>
<h4>Motivo (en cuadrícula)</h4>
<p>Escalera de 3 escalones: un camino que va de (0, 0) a (1, 0), (1, 1), (2, 1), (2, 2), (3, 2), (3, 3).</p>
<h4>Friso</h4>
<ol>
<li>Refleja el motivo sobre la recta vertical x = 3: obtienes la bajada de (3, 3) a (6, 0). Los puntos (2, 2) y (1, 1) pasan a (4, 2) y (5, 1).</li>
<li>Ese «pico» completo (subida y bajada) se traslada 6 cuadros a la derecha una y otra vez: vector (6, 0).</li>
</ol>
<h4>Preguntas y respuestas</h4>
<ul>
<li>¿Cuál es el motivo más pequeño que, solo con traslaciones, forma todo el friso? <em>El pico completo, de 6 cuadros de ancho.</em></li>
<li>¿Hay simetría de reflexión? ¿Dónde están los ejes? <em>Sí, rectas verticales en x = 3, 9, 15…, en las cimas, y también en x = 0, 6, 12…, en los valles.</em></li>
<li>Al reflejar la subida, ¿cambia la orientación? <em>Sí: la subida va hacia la derecha y arriba; su reflejo baja hacia la derecha.</em></li>
<li>¿Hay simetría de rotación de 180°? <em>No: si giras el friso, los picos quedarían hacia abajo.</em></li>
</ul>
TXT,
      ],
      'revisar' => [
        'La información cultural es verificable y no atribuye significados inventados.',
        'Las coordenadas del motivo y sus transformaciones son consistentes (dibújalas tú antes de la clase).',
        'La clasificación de transformaciones es correcta (reflexión y traslación no se confunden).',
        'Se advierte sobre no comercializar diseños tradicionales.',
      ],
    ],
    [
      'id' => 'MAT-22',
      'categoria' => 'retroalimentacion',
      'titulo' => 'Retroalimentación formativa a procedimientos escritos',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 40 min por grupo',
      'cuando' => 'Cuando revisas talleres o pruebas y quieres devolver comentarios que hagan pensar al estudiante sobre su procedimiento, en lugar de una equis y la respuesta correcta.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 8.°',
        '[TAREA]' => 'Enunciado del ejercicio o problema.',
        '[PROCEDIMIENTOS]' => 'Procedimientos transcritos y anonimizados: «Estudiante A: …».',
        '[CRITERIO]' => 'Qué se esperaba lograr. Ej.: desarrollar el cuadrado de un binomio.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas experto en evaluación formativa y retroalimentación efectiva, que trabaja en un colegio colombiano.

CONTEXTO
Grado: [GRADO]. Tarea: [TAREA]. Criterio de logro: [CRITERIO].
Procedimientos de estudiantes (anonimizados):
[PROCEDIMIENTOS]

TAREA
Para cada procedimiento, redacta una retroalimentación escrita de máximo 60 palabras con esta estructura:
1. Lo que está bien hecho (específico, no «buen trabajo»).
2. Dónde está el problema, señalado con una pregunta o un contraejemplo numérico, sin dar la respuesta.
3. Un siguiente paso concreto que el estudiante puede hacer hoy.

FORMATO DE SALIDA
- Tabla: estudiante, paso exacto donde aparece el error, tipo de error, retroalimentación.
- Al final, un comentario general para el grupo sobre el error más frecuente.

RESTRICCIONES
- Dirígete al estudiante con tuteo, en tono respetuoso y motivador, sin sarcasmo.
- No corrijas lo que está bien. No reescribas todo el procedimiento.
- Si un procedimiento es correcto pero poco eficiente, dilo como sugerencia, no como error.

VERIFICACIÓN
- Resuelve la tarea tú mismo y ubica el primer paso incorrecto de cada procedimiento (no el último).
- Comprueba que el contraejemplo numérico que propones realmente muestra el error.
TXT,
      'seguimientos' => [
        'Convierte la retroalimentación del Estudiante A en una conversación de 2 minutos para hacer en voz alta mientras paso por su puesto.',
        'Propón dos ejercicios de práctica para quienes tuvieron el error más frecuente, con la respuesta y una forma de autocomprobarla.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 8.° [TAREA] desarrolla (x + 3)². [CRITERIO] desarrollar el cuadrado de un binomio. [PROCEDIMIENTOS] Estudiante A: (x + 3)² = x² + 9. Estudiante B: (x + 3)² = (x + 3)(x + 3) = x² + 3x + 9. Estudiante C: (x + 3)² = x² + 6x + 9.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Est.</th><th>Paso del error</th><th>Retroalimentación</th></tr>
<tr><td>A</td><td>Primer paso: eleva cada término por separado.</td><td>Escribiste bien el cuadrado del primer y del último término. Prueba tu resultado con x = 2: (2 + 3)² = 25, pero 2² + 9 = 13. ¿Qué falta? Escribe (x + 3)² como (x + 3)(x + 3) y multiplica cada término por cada término.</td></tr>
<tr><td>B</td><td>Al multiplicar: le falta uno de los productos 3x.</td><td>Muy bien que escribiste el producto de los dos binomios. Cuenta cuántos productos debes hacer: x·x, x·3, 3·x y 3·3. ¿Cuántos escribiste? Revisa con x = 2: ¿te da 25?</td></tr>
<tr><td>C</td><td>Sin error.</td><td>Correcto: x² + 6x + 9. Reto: explica con un cuadrado de lado x + 3, dibujado y partido en cuatro regiones, de dónde sale el 6x.</td></tr>
</table>
<p><strong>Comprobación:</strong> con x = 2, x² + 6x + 9 = 4 + 12 + 9 = 25 = 5². Con el resultado de B: 4 + 6 + 9 = 19 ≠ 25.</p>
<p><strong>Para el grupo:</strong> el error más frecuente fue «repartir» el cuadrado como si fuera una multiplicación por un número. Recuerden: (a + b)² significa (a + b)(a + b). Cuando dudes, prueba tu resultado con un número.</p>
TXT,
      ],
      'revisar' => [
        'Cada retroalimentación empieza por algo específico que está bien.',
        'Se ubica el primer paso incorrecto, no solo el resultado final.',
        'Los contraejemplos numéricos están bien calculados y realmente muestran el error.',
        'No se da la respuesta completa a quien se equivocó.',
      ],
    ],
    [
      'id' => 'MAT-23',
      'categoria' => 'retroalimentacion',
      'titulo' => 'Plan de mejoramiento y nivelación con actividades graduadas',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h 30 min',
      'cuando' => 'Al cerrar un período, cuando debes entregar planes de mejoramiento para quienes quedaron en Bajo, según las estrategias de apoyo que define tu SIEE (Decreto 1290 de 2009), y quieres que sean actividades de aprendizaje y no solo «repetir el taller».',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 7.°',
        '[DESEMPENOS_NO_ALCANZADOS]' => 'Desempeños del período no alcanzados. Ej.: resolver operaciones con enteros; resolver problemas de proporcionalidad directa.',
        '[ERRORES]' => 'Errores observados (puedes pegar la salida de MAT-10).',
        '[PLAZO]' => 'Plazo y forma de entrega según tu SIEE. Ej.: 3 semanas, sustentación oral.',
        '[RECURSOS_CASA]' => 'Recursos con que cuentan las familias. Ej.: la mayoría sin computador, con celular.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas colombiano con experiencia en planes de mejoramiento coherentes con el Decreto 1290 de 2009 y el SIEE de cada institución.

CONTEXTO
Grado: [GRADO]. Desempeños no alcanzados: [DESEMPENOS_NO_ALCANZADOS]. Errores observados: [ERRORES]. Plazo y forma de entrega: [PLAZO]. Recursos en casa: [RECURSOS_CASA].

TAREA
Diseña un plan de mejoramiento con actividades graduadas en tres fases: recuperar la base (con representaciones y material casero), practicar con retroalimentación (autocorregible) y demostrar el aprendizaje (tarea de desempeño y sustentación).

FORMATO DE SALIDA
1. Presentación breve para el estudiante y la familia: qué se debe mejorar y por qué importa.
2. Tabla: fase, actividad, tiempo estimado, evidencia que entrega.
3. Las actividades completas con clave de autocorrección en las fases 1 y 2.
4. Tarea de desempeño final y criterios de valoración.
5. Preguntas para la sustentación oral.

RESTRICCIONES
- Actividades realizables con [RECURSOS_CASA]; nada que exija impresora o internet si no lo tienen.
- Contextos colombianos cercanos (tienda, transporte, cocina, temperatura).
- Mínimo de copia mecánica: cada actividad exige explicar al menos un paso.

VERIFICACIÓN
- Resuelve todas las actividades y comprueba la clave.
- Confirma que cada desempeño no alcanzado se trabaja en al menos una actividad de cada fase.
TXT,
      'seguimientos' => [
        'Escribe la versión del plan para un estudiante con PIAR en el mismo grado, manteniendo los desempeños y ajustando apoyos.',
        'Redacta el acta breve de entrega del plan, con espacio para firma del estudiante y del acudiente.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 7.° [DESEMPENOS_NO_ALCANZADOS] operaciones con enteros; proporcionalidad directa. [ERRORES] aplican «menos por menos es más» a la resta; suman en lugar de multiplicar en tablas de proporción. [PLAZO] 3 semanas y sustentación. [RECURSOS_CASA] cuaderno y celular sin datos permanentes.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Fase</th><th>Actividad</th><th>Evidencia</th></tr>
<tr><td>1. Recuperar la base</td><td>Termómetro dibujado de −10 °C a 10 °C: registrar cambios de temperatura en el páramo durante una noche.</td><td>Termómetro con 6 cambios anotados como operaciones.</td></tr>
<tr><td>2. Practicar</td><td>12 ejercicios autocorregibles de enteros y 2 tablas de precios de la tienda.</td><td>Ejercicios con corrección propia en otro color.</td></tr>
<tr><td>3. Demostrar</td><td>«La receta para 30 personas»: ampliar una receta de arepas y decidir qué cantidades se compran.</td><td>Tabla, cálculos y explicación; sustentación oral.</td></tr>
</table>
<h4>Fase 1 (extracto con clave)</h4>
<ul>
<li>A medianoche marcaba −2 °C y a las 4 a. m. bajó 5 grados. −2 − 5 = <strong>−7 °C</strong>.</li>
<li>A las 7 a. m. subió 9 grados desde −7 °C. −7 + 9 = <strong>2 °C</strong>.</li>
</ul>
<h4>Fase 2 (extracto con clave)</h4>
<p>Si 4 arepas cuestan $6.000, completa: 8 arepas → $12.000; 12 arepas → $18.000; 2 arepas → $3.000. <em>Autocomprobación:</em> el precio de una arepa (6.000 ÷ 4 = 1.500) multiplicado por la cantidad debe dar cada valor.</p>
<p><strong>Preguntas de sustentación:</strong> «¿Por qué −2 − 5 no da 3?» «Si 4 arepas cuestan $6.000, ¿por qué 8 arepas no cuestan $10.000?»</p>
TXT,
      ],
      'revisar' => [
        'Cada desempeño no alcanzado aparece en las tres fases.',
        'Las claves de autocorrección están verificadas.',
        'Las actividades son posibles con los recursos reales de las familias.',
        'El plan respeta lo que tu SIEE establece sobre plazos y forma de valoración.',
      ],
    ],
    [
      'id' => 'MAT-24',
      'categoria' => 'retroalimentacion',
      'titulo' => 'Rutina de autoevaluación: ¿mi respuesta tiene sentido?',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 30 min',
      'cuando' => 'Cuando tus estudiantes entregan respuestas absurdas sin notarlo (un pasaje de $350.000, una persona de 15 m) y quieres instalar el hábito de estimar y verificar antes de entregar.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 5.°',
        '[TEMA]' => 'Tema actual. Ej.: multiplicación y división con decimales.',
        '[ERRORES_DE_SENTIDO]' => 'Ejemplos reales (anonimizados) de respuestas sin sentido que has visto.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas experto en metacognición y en el desarrollo del sentido numérico y de la estimación.

CONTEXTO
Grado: [GRADO]. Tema: [TEMA]. Respuestas sin sentido que he visto: [ERRORES_DE_SENTIDO].

TAREA
Diseña una rutina de autoevaluación de 5 minutos que los estudiantes apliquen antes de entregar cualquier problema, y una clase corta (30 minutos) para enseñarla.

FORMATO DE SALIDA
1. Lista de chequeo en primera persona, de 4 a 6 preguntas, en lenguaje de [GRADO] (ej.: «¿Estimé antes de calcular?», «¿Las unidades de mi respuesta son las que pide la pregunta?»).
2. Cinco problemas con una respuesta errónea ya escrita, para que los estudiantes detecten el error usando la lista; incluye la respuesta correcta.
3. Tabla de referentes de tamaño y precio en Colombia (altura de una persona, peso de un bulto de cemento, precio de un pasaje, de una gaseosa) para estimar.
4. Cómo hacer seguimiento a la rutina durante el período.

RESTRICCIONES
- Los referentes de precios deben ser de 2026 y marcados como aproximados.
- Los errores de los problemas deben ser errores reales de estudiantes (de unidades, de orden de magnitud, de operación), no inventos absurdos.

VERIFICACIÓN
- Comprueba que cada respuesta errónea se detecta con al menos una pregunta de la lista.
- Recalcula las respuestas correctas.
TXT,
      'seguimientos' => [
        'Convierte la lista de chequeo en un marcador de libro para imprimir, con espacio para que el estudiante marque.',
        'Diseña un juego de estimación de 10 minutos con precios de la tienda del barrio.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 5.° [TEMA] multiplicación y división con decimales. [ERRORES_DE_SENTIDO] «cada uno paga $250 por el almuerzo»; «la mesa mide 75 m».',
        'resultado_html' => <<<'TXT'
<h4>Mi lista antes de entregar</h4>
<ol>
<li>¿Estimé el resultado antes de calcular?</li>
<li>¿Mi respuesta está cerca de lo que estimé?</li>
<li>¿Tiene las unidades que pide la pregunta (pesos, metros, kilos)?</li>
<li>¿Es posible en la vida real?</li>
<li>¿Comprobé con la operación contraria?</li>
</ol>
<h4>Detecta el error</h4>
<table>
<tr><th>Problema</th><th>Respuesta escrita</th><th>¿Qué pregunta lo detecta?</th><th>Correcta</th></tr>
<tr><td>Un almuerzo de $25.000 se divide entre 4 amigos.</td><td>$625 cada uno</td><td>1 y 4: $25.000 ÷ 4 está cerca de $6.000.</td><td>$6.250</td></tr>
<tr><td>La mesa mide 75 cm. ¿Cuántos metros son?</td><td>75 m</td><td>3 y 4: una mesa de 75 m no cabe en el salón.</td><td>0,75 m</td></tr>
<tr><td>Una cuerda de 2,4 m se corta en trozos de 0,3 m. ¿Cuántos trozos salen?</td><td>0,72 trozos</td><td>2 y 5: multiplicó en lugar de dividir; 8 × 0,3 = 2,4.</td><td>8 trozos</td></tr>
</table>
<h4>Referentes para estimar (aproximados, 2026)</h4>
<ul>
<li>Altura de un estudiante de 5.°: entre 1,30 m y 1,50 m.</li>
<li>Pasaje de TransMilenio o del MIO: alrededor de $3.500.</li>
<li>Bulto de cemento: 50 kg.</li>
</ul>
TXT,
      ],
      'revisar' => [
        'Cada error de los problemas es del tipo que cometen los estudiantes reales (unidades, magnitud, operación).',
        'Las respuestas correctas están bien calculadas.',
        'Los referentes de precios están actualizados para tu ciudad.',
        'La lista es corta y en lenguaje del grado.',
      ],
    ],
    [
      'id' => 'MAT-25',
      'categoria' => 'gestion',
      'titulo' => 'Informe de período y observaciones de boletín con la escala del Decreto 1290',
      'grados' => '1.° a 11.°',
      'tiempo_ahorrado' => '≈ 2 h por período',
      'cuando' => 'Al cierre del período, cuando debes escribir decenas de observaciones para el boletín y quieres que sean específicas, respetuosas, coherentes con el desempeño y útiles para la familia.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 9.°',
        '[DESEMPENOS]' => 'Desempeños evaluados en el período (los de tu planeación).',
        '[ESTUDIANTES]' => 'Lista anonimizada: «Estudiante 1: nivel Alto; fortalezas…; dificultades…». Sin nombres.',
        '[ESCALA_SIEE]' => 'Equivalencia numérica de tu SIEE.',
        '[EXTENSION]' => 'Extensión máxima permitida en el boletín. Ej.: 300 caracteres.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente colombiano con experiencia en redacción de informes de evaluación según el Decreto 1290 de 2009 (escala Superior, Alto, Básico, Bajo) y el SIEE institucional.

CONTEXTO
Grado: [GRADO]. Desempeños del período: [DESEMPENOS]. Escala del SIEE: [ESCALA_SIEE]. Extensión máxima: [EXTENSION].
Estudiantes (anonimizados): [ESTUDIANTES]

TAREA
Escribe una observación de boletín para cada estudiante con: un logro concreto en matemáticas, un aspecto por mejorar formulado como acción, y una recomendación para la casa.

FORMATO DE SALIDA
- Tabla: estudiante, nivel, observación.
- Al final, un párrafo de informe general del grupo para el consejo académico: logros, dificultades comunes, estrategias para el siguiente período.

RESTRICCIONES
- Coherencia: la observación debe corresponder al nivel (no «excelente desempeño» en Básico).
- Lenguaje respetuoso y comprensible para las familias, sin tecnicismos ni juicios sobre la persona («es perezoso»).
- No inventes datos que no te di. Si no hay información sobre un aspecto, omítelo.
- No superes [EXTENSION] por observación.
- Las observaciones no deben ser idénticas entre estudiantes del mismo nivel.

VERIFICACIÓN
- Cuenta los caracteres de cada observación.
- Revisa que el nivel y el tono coincidan en cada caso.
TXT,
      'seguimientos' => [
        'Reescribe las observaciones de los estudiantes en Bajo para que incluyan las fechas y actividades del plan de mejoramiento.',
        'Escribe el informe general del grupo en formato de diapositiva para la comisión de evaluación y promoción.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 9.° [DESEMPENOS] funciones lineales; sistemas de ecuaciones 2 × 2; teorema de Pitágoras. [ESTUDIANTES] Estudiante 1: Superior, modela con sistemas, explica a compañeros. Estudiante 2: Básico, resuelve sistemas por sustitución con errores de signos, no interpreta la solución. Estudiante 3: Bajo, no entregó dos talleres, reconoce catetos e hipotenusa. [EXTENSION] 300 caracteres.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Est.</th><th>Nivel</th><th>Observación</th></tr>
<tr><td>1</td><td>Superior</td><td>Plantea y resuelve sistemas de ecuaciones para modelar situaciones como la comparación de planes de datos, y explica sus procedimientos a sus compañeros. Se recomienda proponerle retos con tres incógnitas.</td></tr>
<tr><td>2</td><td>Básico</td><td>Resuelve sistemas por sustitución. Debe revisar los signos al despejar e interpretar qué significa la solución en el problema. En casa: comprobar cada solución reemplazándola en las dos ecuaciones.</td></tr>
<tr><td>3</td><td>Bajo</td><td>Reconoce catetos e hipotenusa en un triángulo rectángulo. Necesita entregar los talleres pendientes y practicar el planteamiento de ecuaciones. Se recomienda acompañar en casa una rutina diaria de 20 minutos y asistir a las asesorías del plan de mejoramiento.</td></tr>
</table>
<p><strong>Informe general:</strong> el grupo avanzó en la representación de funciones lineales en tabla y gráfica. La principal dificultad común es interpretar la solución de un sistema en el contexto del problema. Para el siguiente período se priorizarán situaciones de comparación de tarifas y la verificación sistemática de soluciones.</p>
<p><em>Longitudes: 205, 197 y 259 caracteres con espacios; todas por debajo de 300.</em></p>
TXT,
      ],
      'revisar' => [
        'El tono y el contenido de cada observación coinciden con su nivel.',
        'No hay juicios sobre la persona ni datos inventados.',
        'Ninguna observación supera la extensión permitida en tu plataforma (verifica con el contador del sistema, no con el de la IA).',
        'Las observaciones del mismo nivel no son copias entre sí.',
      ],
    ],
    [
      'id' => 'MAT-26',
      'categoria' => 'gestion',
      'titulo' => 'Comunicación a familias para apoyar las matemáticas en casa',
      'grados' => 'Transición a 9.°',
      'tiempo_ahorrado' => '≈ 45 min',
      'cuando' => 'Al inicio de un tema o período, cuando quieres que las familias apoyen desde casa con actividades cotidianas (mercado, cocina, recibos), aunque no recuerden las matemáticas del colegio.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 2.°',
        '[TEMA]' => 'Tema del período. Ej.: suma y resta con números hasta 999 y uso del dinero.',
        '[FAMILIAS]' => 'Rasgos de las familias. Ej.: muchas trabajan en horario extendido; algunos acudientes son abuelos con baja escolaridad.',
        '[CANAL]' => 'Canal. Ej.: mensaje de WhatsApp y circular impresa de una página.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas colombiano experto en trabajo con familias y en educación matemática en contextos cotidianos.

CONTEXTO
Grado: [GRADO]. Tema: [TEMA]. Familias: [FAMILIAS]. Canal: [CANAL].

TAREA
Redacta una comunicación para las familias que explique qué se aprenderá y proponga cinco actividades caseras de 10 minutos que no requieran materiales comprados.

FORMATO DE SALIDA
1. Mensaje corto para el canal digital (máximo 80 palabras).
2. Circular de una página: qué aprenderán, por qué importa, cinco actividades (qué hacer, qué preguntar, qué respuesta esperar), y qué NO hacer (hacerle la tarea, decir «yo era malo para las matemáticas»).
3. Versión para leer en voz alta en reunión de padres (2 minutos).

RESTRICCIONES
- Lenguaje sencillo, sin tecnicismos, con usted o ustedes, respetuoso.
- Actividades con objetos y situaciones de cualquier hogar colombiano (mercado, recibos, cocina, monedas).
- Precios realistas de 2026 en pesos colombianos.
- Nada que exija internet o impresora.

VERIFICACIÓN
- Revisa que cada actividad tenga una respuesta esperada correcta.
- Cuenta las palabras del mensaje corto.
TXT,
      'seguimientos' => [
        'Traduce la circular a un lenguaje todavía más sencillo para acudientes con baja escolaridad y propón dibujos que la acompañen.',
        'Diseña una tarjeta de registro para que la familia marque qué actividades hizo durante la semana.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 2.° [TEMA] suma y resta hasta 999 con dinero. [FAMILIAS] horarios extendidos; algunos acudientes son abuelos. [CANAL] WhatsApp y circular impresa.',
        'resultado_html' => <<<'TXT'
<p><strong>Mensaje de WhatsApp:</strong> Buenas tardes, familias de 2.°. Este mes aprenderemos a sumar y restar con dinero. Ustedes pueden ayudar mucho en solo 10 minutos al día, sin comprar nada: les enviamos una circular con cinco ideas para hacer en la cocina o en la tienda. No se trata de hacer tareas, sino de conversar con números. ¡Gracias por acompañar!</p>
<h4>Actividades (extracto)</h4>
<ol>
<li><strong>La tienda en casa:</strong> pongan precio a tres productos de la cocina (panela $3.500, arroz $3.000, huevo $650). Pregunten: «Si compro la panela y el arroz, ¿cuánto pago?». <em>Respuesta: $6.500.</em></li>
<li><strong>¿Cuánto me devuelven?:</strong> «Pago la panela con un billete de $5.000. ¿Cuánto me devuelven?». <em>Respuesta: $1.500.</em> Pídanle que cuente desde 3.500 hasta 5.000.</li>
<li><strong>Monedas a la vista:</strong> con las monedas de la casa, formar $1.000 de tres formas distintas. <em>Ej.: dos de $500; una de $500 y cinco de $100; cuatro de $200 y dos de $100.</em></li>
</ol>
<p><strong>Por favor, eviten:</strong> resolverle el ejercicio o decir «yo nunca fui bueno para las matemáticas». Mejor pregunten: «¿Cómo lo pensaste?».</p>
TXT,
      ],
      'revisar' => [
        'Las respuestas de cada actividad son correctas.',
        'Los precios son plausibles en tu municipio y las monedas mencionadas existen en circulación.',
        'El mensaje corto cumple el límite de palabras.',
        'El tono es respetuoso y no supone recursos que las familias no tienen.',
      ],
    ],
    [
      'id' => 'MAT-27',
      'categoria' => 'gestion',
      'titulo' => 'Política de uso de la IA en tareas de matemáticas para el curso',
      'grados' => '6.° a 11.°',
      'tiempo_ahorrado' => '≈ 1 h',
      'cuando' => 'Cuando tus estudiantes ya usan IA o aplicaciones que resuelven ejercicios con una foto y necesitas acordar reglas claras: cuándo se permite, cómo se declara y cómo se demuestra que se aprendió.',
      'variables' => [
        '[GRADO]' => 'Grado. Ej.: 10.°',
        '[USOS_ACTUALES]' => 'Lo que observas. Ej.: copian soluciones de aplicaciones de fotos; tareas idénticas sin errores.',
        '[POLITICA_INSTITUCIONAL]' => 'Lo que dice el manual de convivencia o el SIEE sobre IA (si no hay nada, dilo).',
        '[ACCESO]' => 'Acceso real a dispositivos. Ej.: la mitad tiene celular propio con datos.',
      ],
      'prompt' => <<<'TXT'
Actúa como docente de matemáticas y líder de innovación educativa en un colegio colombiano, con criterio sobre el uso responsable de la inteligencia artificial.

CONTEXTO
Grado: [GRADO]. Usos actuales observados: [USOS_ACTUALES]. Política institucional: [POLITICA_INSTITUCIONAL]. Acceso: [ACCESO].

TAREA
Redacta una política de aula sobre el uso de IA en matemáticas, construida para socializar y ajustar con los estudiantes.

FORMATO DE SALIDA
1. Principio general en una frase.
2. Semáforo de usos: verde (permitido: explicar un concepto, generar ejercicios de práctica, revisar un procedimiento propio), amarillo (con declaración: pedir pistas), rojo (no permitido: entregar como propia una solución generada).
3. Cómo se declara el uso (formato de una línea).
4. Regla de verificación: toda respuesta obtenida con IA se comprueba con calculadora, con otro método o reemplazando en la ecuación, y el estudiante explica el proceso.
5. Formas de evaluación que muestran aprendizaje real: explicación oral, error intencional para corregir, problema con datos locales.
6. Consideraciones de equidad (no todos tienen acceso) y de datos personales.

RESTRICCIONES
- Tono formativo, no punitivo. Coherente con el manual de convivencia y el SIEE; señala lo que deba aprobar el consejo académico.
- Incluye un ejemplo de error real que cometen las IA en matemáticas para mostrar por qué hay que verificar.

VERIFICACIÓN
- Revisa que el ejemplo de error de la IA esté correctamente explicado y corregido.
- Comprueba que ninguna regla exija un recurso que la mitad del curso no tiene.
TXT,
      'seguimientos' => [
        'Diseña una actividad de clase de 30 minutos en la que los estudiantes cacen errores en una solución generada por IA que yo te daré.',
        'Redacta el texto para explicarle esta política a las familias en la reunión de entrega de informes.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 10.° [USOS_ACTUALES] tareas idénticas copiadas de aplicaciones que resuelven con foto. [POLITICA_INSTITUCIONAL] el manual no menciona IA. [ACCESO] la mitad tiene celular con datos.',
        'resultado_html' => <<<'TXT'
<p><strong>Principio:</strong> la IA puede ayudarte a aprender matemáticas, pero no puede aprender por ti; lo que entregas debes poder explicarlo.</p>
<table>
<tr><th>Color</th><th>Usos</th></tr>
<tr><td>Verde</td><td>Pedir que te explique un concepto de otra forma; generar ejercicios de práctica; revisar un procedimiento que tú hiciste.</td></tr>
<tr><td>Amarillo (declarar)</td><td>Pedir una pista para un paso; comparar tu método con otro.</td></tr>
<tr><td>Rojo</td><td>Copiar una solución generada y entregarla como propia; usar IA en evaluaciones presenciales.</td></tr>
</table>
<p><strong>Declaración:</strong> «Usé [herramienta] para [qué] en el paso [n.°]. Lo verifiqué así: [cómo]».</p>
<p><strong>Por qué verificar (ejemplo real de error):</strong> una IA resolvió 2x² = 18 y respondió «x = 3». Falta la otra solución: x² = 9, entonces x = 3 o x = −3. Comprobación: 2(−3)² = 2 × 9 = 18.</p>
<p><strong>Evaluación:</strong> cada semana, dos estudiantes al azar explican oralmente un ejercicio de la tarea en 2 minutos. Las tareas incluyen datos del municipio que una aplicación no conoce.</p>
<p><strong>Equidad:</strong> ninguna tarea exige IA. En clase se usarán los equipos del colegio en parejas. No se suben fotos de compañeros ni datos personales a ninguna herramienta.</p>
<p><em>Pendiente de aprobación del consejo académico para incluirla en el SIEE.</em></p>
TXT,
      ],
      'revisar' => [
        'La política no exige recursos que no todos tienen.',
        'El ejemplo de error de la IA está bien corregido.',
        'Es coherente con el manual de convivencia y el SIEE, y señala lo que requiere aprobación.',
        'Tiene una regla clara de verificación y de explicación del proceso.',
      ],
    ],
    [
      'id' => 'MAT-28',
      'categoria' => 'gestion',
      'titulo' => 'Análisis de resultados de Saber o de simulacros por competencia y componente',
      'grados' => '3.° a 11.°',
      'tiempo_ahorrado' => '≈ 2 h',
      'cuando' => 'Cuando recibes resultados de Saber, de un simulacro o de tu propia prueba y necesitas convertir porcentajes en decisiones de aula para el área, sin perderte en las tablas.',
      'variables' => [
        '[GRADO]' => 'Grado evaluado. Ej.: 9.°',
        '[RESULTADOS]' => 'Tabla con porcentaje de respuestas incorrectas o de acierto por competencia y por componente (de tu institución, sin datos de estudiantes).',
        '[PRUEBA]' => 'Ej.: Saber 9.°, simulacro institucional.',
        '[TIEMPO_DISPONIBLE]' => 'Tiempo hasta la siguiente aplicación o hasta fin de año. Ej.: 12 semanas.',
      ],
      'prompt' => <<<'TXT'
Actúa como asesor pedagógico de matemáticas con experiencia en el análisis de resultados del ICFES (competencias y componentes de Saber 3.°, 5.° y 9.°; competencias y categorías de Saber 11) y en planes de mejoramiento institucional.

CONTEXTO
Grado: [GRADO]. Prueba: [PRUEBA]. Tiempo disponible: [TIEMPO_DISPONIBLE].
Resultados (agregados, sin estudiantes): [RESULTADOS]

TAREA
Analiza los resultados y propón un plan de acción de aula priorizado.

FORMATO DE SALIDA
1. Lectura de los datos: tabla ordenada de mayor a menor dificultad y cruces relevantes (ej.: competencia más débil dentro del componente más débil).
2. Tres prioridades, cada una con su justificación en los datos.
3. Para cada prioridad: qué tipo de tarea de aula la desarrolla, frecuencia semanal y en qué grados anteriores debe reforzarse (coherencia vertical de los Estándares).
4. Indicadores de seguimiento medibles para la siguiente medición.
5. Riesgos de interpretación (tamaño del grupo, comparar pruebas distintas, confundir porcentaje de acierto con nivel de desempeño).

RESTRICCIONES
- Usa solo los datos dados. No inventes promedios nacionales ni de la entidad territorial; si son útiles, deja «[dato del reporte oficial]».
- Usa los nombres de competencias y componentes exactamente como los da el ICFES.
- No propongas «hacer más simulacros» como estrategia principal.

VERIFICACIÓN
- Revisa que el orden de dificultad corresponde a los porcentajes dados.
- Confirma que cada prioridad se apoya en al menos un dato de la tabla.
TXT,
      'seguimientos' => [
        'Convierte el plan en una presentación de 6 diapositivas para la jornada pedagógica del área.',
        'Diseña cuatro ítems tipo Saber para la competencia más débil, usando la receta MAT-06.',
      ],
      'ejemplo' => [
        'contexto' => '[GRADO] 9.° [PRUEBA] simulacro institucional. [RESULTADOS] porcentaje de acierto por componente: numérico-variacional 48 %, espacial-métrico 39 %, aleatorio 55 %. Por competencia: comunicación, modelación y representación 52 %; razonamiento y argumentación 38 %; planteamiento y resolución de problemas 45 %. Cruce: razonamiento en espacial-métrico 31 %. [TIEMPO_DISPONIBLE] 12 semanas.',
        'resultado_html' => <<<'TXT'
<table>
<tr><th>Orden</th><th>Aspecto</th><th>% de acierto</th></tr>
<tr><td>1 (más difícil)</td><td>Razonamiento y argumentación × espacial-métrico</td><td>31</td></tr>
<tr><td>2</td><td>Razonamiento y argumentación</td><td>38</td></tr>
<tr><td>3</td><td>Espacial-métrico</td><td>39</td></tr>
<tr><td>4</td><td>Planteamiento y resolución de problemas</td><td>45</td></tr>
<tr><td>5</td><td>Numérico-variacional</td><td>48</td></tr>
<tr><td>6</td><td>Comunicación, modelación y representación</td><td>52</td></tr>
<tr><td>7</td><td>Aleatorio</td><td>55</td></tr>
</table>
<h4>Prioridades</h4>
<ol>
<li><strong>Argumentar en geometría y medición</strong> (31 %): dos veces por semana, tareas de «¿es verdad que…? Justifica»: ej., «Si duplico el lado de un cuadrado, ¿se duplica el área?». Reforzar desde 6.° y 7.° (composición y descomposición de áreas).</li>
<li><strong>Razonamiento en general</strong> (38 %): en cada clase, una pregunta de «¿por qué?» que exija una razón escrita.</li>
<li><strong>Resolución de problemas</strong> (45 %): un problema de varios pasos semanal con la rutina de Pólya.</li>
</ol>
<p><strong>Indicador:</strong> subir el acierto en razonamiento × espacial-métrico de 31 % a 40 % en la siguiente medición.</p>
<p><strong>Riesgos:</strong> con un solo curso de 35 estudiantes, una diferencia de 3 puntos puede ser azar; el simulacro no es comparable directamente con Saber; el porcentaje de acierto no equivale a niveles de desempeño del ICFES.</p>
TXT,
      ],
      'revisar' => [
        'El orden de dificultad coincide con los porcentajes de tu reporte.',
        'No aparecen promedios nacionales o territoriales inventados.',
        'Los nombres de competencias y componentes son los del ICFES.',
        'Las prioridades son tareas de aula concretas, no «más simulacros».',
      ],
    ],
  ],
  'cadenas' => [
    [
      'titulo' => 'Unidad completa de proporcionalidad (6.° y 7.°)',
      'objetivo' => 'Planear, enseñar, evaluar y nivelar una unidad de proporcionalidad directa e inversa en tres semanas, con un hilo conductor en la tienda del barrio.',
      'pasos' => [
        ['paso' => 'Planea la primera clase con el estándar de variación y el DBA de 7.° copiados de tus documentos.', 'receta' => 'MAT-01', 'nota' => 'Usa la situación de los huevos y la cubeta: plantea desde el inicio cuándo no hay proporcionalidad.'],
        ['paso' => 'Extiende la situación a una secuencia de cinco sesiones (precios, recetas, escalas de un mapa del municipio).', 'receta' => 'MAT-02', 'nota' => 'Mantén los mismos precios en todas las sesiones para no confundir.'],
        ['paso' => 'Cierra cada clase con un quiz de salida y agrupa para la clase siguiente.', 'receta' => 'MAT-09', 'nota' => 'Tres preguntas, cinco minutos. Guarda las hojas para el diagnóstico.'],
        ['paso' => 'Arma el banco de problemas por niveles para el trabajo diferenciado de la segunda semana.', 'receta' => 'MAT-08', 'nota' => 'El nivel 3 debe incluir un caso donde la razón no es constante.'],
        ['paso' => 'Analiza los errores de la prueba de unidad con respuestas anonimizadas.', 'receta' => 'MAT-10', 'nota' => 'Busca el razonamiento aditivo («si aumenta 4, aumenta 4»).'],
        ['paso' => 'Devuelve retroalimentación a los procedimientos y entrega el plan de mejoramiento a quienes lo necesiten.', 'receta' => 'MAT-23', 'nota' => 'Combínalo con MAT-22 para los comentarios individuales.'],
      ],
    ],
    [
      'titulo' => 'Proyecto estadístico de principio a fin (8.° a 11.°)',
      'objetivo' => 'Llevar a un curso por el ciclo PPDAC con datos reales del colegio, desde la pregunta hasta la presentación pública, evaluando con rúbrica y vinculando a las familias.',
      'pasos' => [
        ['paso' => 'Diseña el proyecto, el instrumento anónimo y el cronograma.', 'receta' => 'MAT-04', 'nota' => 'Revisa con el coordinador que la encuesta no recoja datos personales.'],
        ['paso' => 'Organiza los datos en hoja de cálculo con fórmulas de frecuencias y porcentajes.', 'receta' => 'MAT-19', 'nota' => 'Adapta la receta: en lugar del recibo, usa CONTAR.SI y la tabla de frecuencias.'],
        ['paso' => 'Evalúa el informe con la rúbrica de proyecto estadístico de este kit.', 'receta' => '', 'nota' => 'Usa la rúbrica «Proyecto estadístico» de la sección de rúbricas.'],
        ['paso' => 'Retroalimenta los análisis escritos antes de la versión final.', 'receta' => 'MAT-22', 'nota' => 'Enfócate en conclusiones que van más allá de los datos.'],
        ['paso' => 'Comparte los resultados con las familias y la comunidad educativa.', 'receta' => 'MAT-26', 'nota' => 'Una gráfica y una conclusión por curso en la circular o en la izada de bandera.'],
      ],
    ],
    [
      'titulo' => 'Preparación para Saber 9.° y Saber 11 sin talleres de simulacros',
      'objetivo' => 'Convertir los resultados de una medición en tareas de aula semanales que desarrollen las competencias evaluadas, con ítems de calidad y seguimiento.',
      'pasos' => [
        ['paso' => 'Analiza los resultados por competencia y componente y define tres prioridades.', 'receta' => 'MAT-28', 'nota' => 'Usa solo datos agregados del reporte; nada de listas de estudiantes.'],
        ['paso' => 'Construye ítems de 9.° para la competencia más débil, con distractores basados en errores.', 'receta' => 'MAT-06', 'nota' => 'Cuatro ítems por semana bastan si se discuten en clase.'],
        ['paso' => 'Para 10.° y 11.°, construye ítems con tabla o gráfica en la categoría más débil.', 'receta' => 'MAT-07', 'nota' => 'Alterna formulación y ejecución con argumentación.'],
        ['paso' => 'Diagnostica los errores de las respuestas en los ítems trabajados.', 'receta' => 'MAT-10', 'nota' => 'Las opciones marcadas te dicen el error: tabula cuántos eligieron cada distractor.'],
        ['paso' => 'Instala la rutina de autoevaluación antes de entregar.', 'receta' => 'MAT-24', 'nota' => 'En pruebas de selección múltiple, la estimación elimina opciones absurdas.'],
        ['paso' => 'Diseña la prueba de período con tabla de especificaciones alineada a las prioridades.', 'receta' => 'MAT-12', 'nota' => 'Compara los resultados con los de la medición inicial.'],
      ],
    ],
    [
      'titulo' => 'Aula inclusiva en matemáticas durante un período',
      'objetivo' => 'Diseñar desde el inicio para todos (DUA), concretar los ajustes de quienes tienen PIAR, ofrecer profundidad a quienes avanzan rápido y reportar el período con coherencia.',
      'pasos' => [
        ['paso' => 'Rediseña la guía principal del período con múltiples representaciones.', 'receta' => 'MAT-13', 'nota' => 'Primero el DUA para todos; luego los ajustes individuales.'],
        ['paso' => 'Define el componente de matemáticas del PIAR con el docente de apoyo y la familia.', 'receta' => 'MAT-14', 'nota' => 'Acuerda qué apoyos se permiten en evaluación y en qué tareas.'],
        ['paso' => 'Prepara la guía con material concreto para el tema central.', 'receta' => 'MAT-17', 'nota' => 'El material beneficia a todo el grupo, no solo a quien tiene PIAR.'],
        ['paso' => 'Ofrece un reto de enriquecimiento a quienes terminan antes.', 'receta' => 'MAT-15', 'nota' => 'Profundidad, no más ejercicios iguales.'],
        ['paso' => 'Redacta las observaciones del boletín coherentes con los ajustes realizados.', 'receta' => 'MAT-25', 'nota' => 'El desempeño se valora frente a las metas del PIAR cuando aplique, según tu SIEE.'],
      ],
    ],
  ],
  'rubricas' => [
    [
      'titulo' => 'Resolución de problemas',
      'criterios' => [
        ['criterio' => 'Comprensión del problema', 'niveles' => [
          'Superior' => 'Reformula el problema con sus palabras, identifica datos relevantes, descarta los que sobran y señala qué se pregunta y en qué unidades.',
          'Alto' => 'Identifica datos y pregunta correctamente, aunque no descarta de forma explícita los datos que sobran.',
          'Básico' => 'Identifica la pregunta pero omite un dato necesario o usa uno que no corresponde.',
          'Bajo' => 'No distingue qué se pregunta; copia los números del enunciado sin relacionarlos.',
        ]],
        ['criterio' => 'Estrategia y representación', 'niveles' => [
          'Superior' => 'Elige una representación útil (tabla, dibujo, ecuación) y la justifica; compara con otra estrategia posible.',
          'Alto' => 'Elige una representación adecuada que le permite avanzar hasta la solución.',
          'Básico' => 'Usa una representación parcial o ensayo y error sin organizar.',
          'Bajo' => 'No hay estrategia visible; operaciones al azar con los números del enunciado.',
        ]],
        ['criterio' => 'Ejecución y exactitud', 'niveles' => [
          'Superior' => 'Todos los cálculos son correctos, con unidades y redondeo coherente con el contexto.',
          'Alto' => 'Un error menor de cálculo que no cambia la lógica de la solución.',
          'Básico' => 'Varios errores de cálculo o de unidades que llevan a un resultado poco razonable.',
          'Bajo' => 'Errores que impiden llegar a un resultado.',
        ]],
        ['criterio' => 'Verificación', 'niveles' => [
          'Superior' => 'Comprueba el resultado con otro método o con la operación inversa y analiza si tiene sentido en el contexto.',
          'Alto' => 'Comprueba el resultado con la operación inversa.',
          'Básico' => 'Afirma que el resultado es correcto sin comprobarlo.',
          'Bajo' => 'No revisa; entrega resultados imposibles (personas fraccionadas, precios absurdos) sin notarlo.',
        ]],
        ['criterio' => 'Comunicación de la respuesta', 'niveles' => [
          'Superior' => 'Responde con una frase completa que contesta la pregunta, con unidades, y explica el proceso de forma que otro lo pueda seguir.',
          'Alto' => 'Responde con frase completa y unidades; la explicación del proceso es breve.',
          'Básico' => 'Da solo el número, sin unidades ni explicación.',
          'Bajo' => 'No hay respuesta o no corresponde a la pregunta.',
        ]],
      ],
    ],
    [
      'titulo' => 'Modelación matemática',
      'criterios' => [
        ['criterio' => 'Identificación de variables y supuestos', 'niveles' => [
          'Superior' => 'Define variables con unidades y explicita los supuestos que simplifican la situación, explicando su efecto.',
          'Alto' => 'Define variables con unidades y menciona al menos un supuesto.',
          'Básico' => 'Nombra las variables sin unidades o sin distinguir dependiente e independiente.',
          'Bajo' => 'No identifica las variables de la situación.',
        ]],
        ['criterio' => 'Construcción del modelo', 'niveles' => [
          'Superior' => 'Construye un modelo coherente con los datos (tabla, gráfica y expresión) y justifica la familia de funciones elegida.',
          'Alto' => 'Construye un modelo coherente en al menos dos representaciones.',
          'Básico' => 'Propone una expresión que solo se ajusta a algunos datos o sin relación con la gráfica.',
          'Bajo' => 'No propone un modelo o copia uno sin relación con la situación.',
        ]],
        ['criterio' => 'Uso del modelo', 'niveles' => [
          'Superior' => 'Usa el modelo para predecir y calcula correctamente, interpretando el resultado en el contexto.',
          'Alto' => 'Usa el modelo para predecir con cálculos correctos.',
          'Básico' => 'Reemplaza valores con errores o sin interpretar el resultado.',
          'Bajo' => 'No usa el modelo para responder.',
        ]],
        ['criterio' => 'Contraste y validación', 'niveles' => [
          'Superior' => 'Compara el modelo con los datos reales, cuantifica diferencias, propone un ajuste y señala dónde deja de ser válido.',
          'Alto' => 'Compara el modelo con los datos y reconoce dónde falla.',
          'Básico' => 'Menciona que el modelo «no es exacto» sin precisar dónde ni cuánto.',
          'Bajo' => 'Considera el modelo válido para cualquier valor.',
        ]],
      ],
    ],
    [
      'titulo' => 'Comunicación y argumentación matemática',
      'criterios' => [
        ['criterio' => 'Uso del lenguaje matemático', 'niveles' => [
          'Superior' => 'Usa términos y notación con precisión (coma decimal, signo igual solo entre expresiones equivalentes, unidades) y los relaciona con el lenguaje cotidiano.',
          'Alto' => 'Usa términos y notación correctos con imprecisiones menores.',
          'Básico' => 'Mezcla notaciones o usa el signo igual como «y luego» (5 + 3 = 8 × 2 = 16).',
          'Bajo' => 'No usa lenguaje matemático o lo usa de forma incorrecta.',
        ]],
        ['criterio' => 'Estructura del argumento', 'niveles' => [
          'Superior' => 'Presenta afirmación, razones y conclusión encadenadas; cada paso se apoya en una propiedad o dato explícito.',
          'Alto' => 'Presenta afirmación y razones válidas, con algún paso implícito.',
          'Básico' => 'Da una afirmación con una razón débil («porque sí», «porque así dio»).',
          'Bajo' => 'Afirma sin razones.',
        ]],
        ['criterio' => 'Uso de ejemplos y contraejemplos', 'niveles' => [
          'Superior' => 'Distingue entre comprobar con ejemplos y demostrar; usa un contraejemplo para refutar una afirmación general.',
          'Alto' => 'Usa ejemplos pertinentes y reconoce que un contraejemplo refuta.',
          'Básico' => 'Considera que un ejemplo que funciona prueba una afirmación general.',
          'Bajo' => 'No usa ejemplos o usa ejemplos que no corresponden.',
        ]],
        ['criterio' => 'Representaciones', 'niveles' => [
          'Superior' => 'Articula varias representaciones (gráfica, tabla, expresión, dibujo) y explica cómo se corresponden.',
          'Alto' => 'Usa dos representaciones correctas.',
          'Básico' => 'Usa una representación con errores menores.',
          'Bajo' => 'Las representaciones contradicen el argumento.',
        ]],
        ['criterio' => 'Interacción con otros', 'niveles' => [
          'Superior' => 'Escucha argumentos de compañeros, los reformula y los valida o refuta con razones.',
          'Alto' => 'Escucha y responde a argumentos de compañeros con razones.',
          'Básico' => 'Expone su idea sin considerar las de otros.',
          'Bajo' => 'No participa en la discusión matemática.',
        ]],
      ],
    ],
    [
      'titulo' => 'Proyecto estadístico',
      'criterios' => [
        ['criterio' => 'Pregunta de investigación', 'niveles' => [
          'Superior' => 'Formula una pregunta estadística clara, de interés para la comunidad, que anticipa variabilidad y define población y variables.',
          'Alto' => 'Formula una pregunta estadística clara con variables definidas.',
          'Básico' => 'La pregunta es de respuesta única o de sí o no, o las variables son ambiguas.',
          'Bajo' => 'No hay pregunta o no se relaciona con los datos.',
        ]],
        ['criterio' => 'Recolección y ética de los datos', 'niveles' => [
          'Superior' => 'Diseña un instrumento claro, anónimo, con opciones exhaustivas; documenta cómo y a quién se aplicó.',
          'Alto' => 'Instrumento claro y anónimo; documenta parcialmente la aplicación.',
          'Básico' => 'Instrumento con preguntas ambiguas u opciones que se superponen.',
          'Bajo' => 'Recoge datos personales innecesarios o no documenta la recolección.',
        ]],
        ['criterio' => 'Organización y representación', 'niveles' => [
          'Superior' => 'Tablas de frecuencia correctas (sumas y porcentajes verificados) y gráficas adecuadas al tipo de variable, con título, ejes y fuente.',
          'Alto' => 'Tablas y gráficas correctas con algún elemento faltante (fuente o unidades).',
          'Básico' => 'Errores en frecuencias o gráfica inadecuada para el tipo de variable.',
          'Bajo' => 'Datos sin organizar o con errores que impiden el análisis.',
        ]],
        ['criterio' => 'Análisis', 'niveles' => [
          'Superior' => 'Elige y calcula medidas adecuadas al tipo de variable, compara grupos y describe la variabilidad.',
          'Alto' => 'Calcula correctamente medidas adecuadas y las interpreta.',
          'Básico' => 'Calcula medidas sin interpretarlas o usa medidas inadecuadas (media de una variable cualitativa).',
          'Bajo' => 'No analiza los datos.',
        ]],
        ['criterio' => 'Conclusiones', 'niveles' => [
          'Superior' => 'Responde la pregunta con base en los datos, reconoce limitaciones de la muestra y propone acciones o nuevas preguntas.',
          'Alto' => 'Responde la pregunta con base en los datos.',
          'Básico' => 'Concluye con opiniones que no se desprenden de los datos.',
          'Bajo' => 'No hay conclusiones o contradicen los datos.',
        ]],
      ],
    ],
    [
      'titulo' => 'Uso de material concreto en primaria (transición a 5.°)',
      'criterios' => [
        ['criterio' => 'Manipulación con propósito', 'niveles' => [
          'Superior' => 'Usa el material para resolver la tarea por iniciativa propia y propone otras formas de hacerlo.',
          'Alto' => 'Usa el material de forma adecuada para resolver la tarea.',
          'Básico' => 'Usa el material con orientación constante del docente.',
          'Bajo' => 'Juega con el material sin relación con la tarea, aun con orientación.',
        ]],
        ['criterio' => 'Relación entre material y concepto', 'niveles' => [
          'Superior' => 'Explica qué representa cada pieza o acción (ej.: «cambié diez tapas por una bolsita porque son una decena»).',
          'Alto' => 'Relaciona el material con el concepto cuando se le pregunta.',
          'Básico' => 'Hace la acción correcta con el material pero no explica qué representa.',
          'Bajo' => 'No relaciona el material con la situación.',
        ]],
        ['criterio' => 'Paso a la representación pictórica', 'niveles' => [
          'Superior' => 'Dibuja de forma organizada lo hecho con el material y lo usa para resolver problemas nuevos.',
          'Alto' => 'Dibuja correctamente lo hecho con el material.',
          'Básico' => 'Su dibujo representa parcialmente lo hecho.',
          'Bajo' => 'No logra representar gráficamente.',
        ]],
        ['criterio' => 'Paso a la representación simbólica', 'niveles' => [
          'Superior' => 'Escribe la operación o expresión correspondiente y explica cada símbolo con referencia al material.',
          'Alto' => 'Escribe la operación correcta.',
          'Básico' => 'Escribe la operación con errores menores o solo con ayuda.',
          'Bajo' => 'No relaciona la situación con una expresión numérica.',
        ]],
        ['criterio' => 'Comunicación y trabajo con otros', 'niveles' => [
          'Superior' => 'Explica su procedimiento a un compañero usando el material y escucha otras estrategias.',
          'Alto' => 'Explica su procedimiento cuando se le pide.',
          'Básico' => 'Explica con frases incompletas o solo muestra.',
          'Bajo' => 'No comunica su procedimiento.',
        ]],
      ],
    ],
  ],
  'errores' => [
    [
      'error' => 'Errores aritméticos en la solución o en la clave de respuestas',
      'como_detectarlo' => 'Resuelve tú cada ejercicio antes de mirar la clave. Desconfía especialmente de multiplicaciones de varias cifras, divisiones con decimales y porcentajes encadenados. Pide a la IA que recalcule paso a paso: si cambia el resultado, había error.',
      'como_corregirlo' => 'Exige en el prompt «muestra cada operación» y una verificación final independiente. Comprueba con calculadora o con la operación inversa. Nunca publiques una clave que no hayas verificado.',
    ],
    [
      'error' => 'Más de una opción correcta (o ninguna) en ítems de selección múltiple',
      'como_detectarlo' => 'Revisa cada distractor como si fuera la respuesta: ¿hay una lectura razonable del enunciado que lo haga correcto? Pasa con frecuencia con redondeos, unidades distintas o preguntas del tipo «cuál podría ser».',
      'como_corregirlo' => 'Pide a la IA que justifique por qué cada distractor es incorrecto y qué error produce ese valor. Ajusta el enunciado para eliminar ambigüedades (precisa unidades, redondeo, «exactamente»).',
    ],
    [
      'error' => 'Distractores arbitrarios que no capturan ningún error de pensamiento',
      'como_detectarlo' => 'Si no puedes explicar qué estudiante elegiría una opción y por qué, el distractor no aporta información.',
      'como_corregirlo' => 'Pide que cada distractor salga de un error típico documentado (sumar numeradores y denominadores, ignorar una parte del dato, confundir área y perímetro) y que muestre el cálculo erróneo que lo produce.',
    ],
    [
      'error' => 'Medidas imposibles o unidades equivocadas',
      'como_detectarlo' => 'Busca resultados absurdos: una cocina de 40 m de largo, un bebé de 15 kg al nacer, un salón de 3 m², un área en metros lineales, velocidades de ciclista de 120 km/h en subida.',
      'como_corregirlo' => 'Pide en el prompt «medidas físicamente posibles y unidades en cada resultado». Ten a mano referentes de tamaño (altura de una puerta ≈ 2 m; baldosa común de 30 a 60 cm) y verifica la conversión de unidades antes de operar.',
    ],
    [
      'error' => 'Precios desactualizados o irreales en pesos colombianos',
      'como_detectarlo' => 'Precios de hace años (pasaje a $1.800, salario mínimo de 2022) o imposibles (una gaseosa a $50.000). La IA suele tener datos de años anteriores a su entrenamiento.',
      'como_corregirlo' => 'Indica tú los precios de referencia en el prompt (ej.: SMMLV 2026, $1.750.905; pasaje de TransMilenio y SITP en 2026, $3.550; usa las tarifas de tu ciudad) o pide que marque como «[POR CONFIRMAR]» todo precio del que no tenga certeza.',
    ],
    [
      'error' => 'Datos inconsistentes dentro de un mismo problema o secuencia',
      'como_detectarlo' => 'El total no coincide con la suma de las partes; el precio cambia de una pregunta a otra; en la sesión 1 hay 30 estudiantes y en la 3 hay 28 sin explicación.',
      'como_corregirlo' => 'Pide al final «lista todos los datos usados y verifica que sean los mismos en cada parte». Revisa tú las tablas: sumas por fila y por columna.',
    ],
    [
      'error' => 'Personas, objetos indivisibles o compras fraccionadas',
      'como_detectarlo' => 'Respuestas como 3,5 buses, 12,4 estudiantes o 6,6 cajas de baldosas, presentadas sin interpretación.',
      'como_corregirlo' => 'Indica en el prompt que las cantidades indivisibles se redondean con criterio (hacia arriba si se compra, hacia abajo si se reparte) y que la respuesta explique por qué.',
    ],
    [
      'error' => 'Porcentajes que no suman 100 % o tablas de frecuencia que no cuadran',
      'como_detectarlo' => 'Suma la columna de porcentajes y la de frecuencias. Revisa gráficos circulares con sectores que suman más de 360°.',
      'como_corregirlo' => 'Pide que muestre las sumas. Si hay redondeo, que lo explique en una nota (ej.: 100,1 % por redondeo). Recalcula tú cada porcentaje como frecuencia ÷ total.',
    ],
    [
      'error' => 'Notación que no se usa en Colombia',
      'como_detectarlo' => 'Punto decimal (3.5 en lugar de 3,5), coma de miles (1,500 en lugar de 1.500), «billón» con sentido de mil millones, «dólares» o «$» sin aclarar que son pesos, unidades del sistema inglés (millas, pies, libras de 454 g sin aclarar que en Colombia la libra comercial es de 500 g).',
      'como_corregirlo' => 'Pide coma decimal y punto de miles en el prompt y revisa cada número. Recuerda que en GeoGebra y en algunos programas sí se escribe el punto decimal: explícalo a los estudiantes.',
    ],
    [
      'error' => 'DBA o estándares inventados o mal citados',
      'como_detectarlo' => 'Números de DBA que no coinciden con tu documento, enunciados que no aparecen en los Estándares de 2006, estándares de otro grupo de grados o de otro país (por ejemplo, «aprendizajes esperados» de México o «objetivos de aprendizaje» de Chile).',
      'como_corregirlo' => 'Pega tú el texto exacto del estándar y del DBA en el prompt. Si no lo tienes, pide que lo describa por contenido con la marca «[POR CONFIRMAR]». Contrasta siempre con el documento oficial del MEN.',
    ],
    [
      'error' => 'Enunciados ambiguos o con datos que permiten varias interpretaciones',
      'como_detectarlo' => 'Pide a un colega (o a la misma IA en otra conversación) que resuelva el problema sin ver la solución. Si llega a otra respuesta razonable, el enunciado es ambiguo. Ojo con «cuánto más», «aumentó en» frente a «aumentó a», «entre» y los porcentajes «de» qué total.',
      'como_corregirlo' => 'Reescribe con una sola interpretación posible: precisa la base de los porcentajes, el momento inicial y final, y la unidad de la respuesta.',
    ],
    [
      'error' => 'Soluciones incompletas o que ignoran el contexto',
      'como_detectarlo' => 'Ecuaciones cuadráticas con una sola raíz (2x² = 18 → solo x = 3), tiempos negativos aceptados, triángulos que no cumplen la desigualdad triangular, ángulos que no suman 180°.',
      'como_corregirlo' => 'Pide en la verificación «revisa todas las soluciones posibles y descarta las que no tienen sentido en el contexto, explicando por qué». Comprueba las condiciones geométricas básicas.',
    ],
  ],
  'banco_contextos' => [
    'La tienda del barrio: precios por unidad, por libra y por paca; fiado anotado en el cuaderno; vueltas con billetes y monedas colombianas.',
    'Tarifas de transporte masivo de 2026 (TransMilenio y SITP, $3.550; Metro de Medellín, usuario frecuente, $3.820; MIO, $3.500): recargas, saldo y número de viajes.',
    'Recibos de servicios públicos: cargo fijo, consumo básico o de subsistencia, subsidios a estratos 1, 2 y 3 y contribuciones de estratos 5 y 6.',
    'Cosecha de café: kilos recolectados por día, pago por kilo, rendimiento por árbol, secado y venta de café pergamino.',
    'Finca y cultivos: siembra en surcos y eras, distancia entre plantas, área en metros cuadrados, hectáreas y fanegadas (aclarando la equivalencia local).',
    'Mercado campesino: venta por libras y arrobas, ganancias, precios por temporada de cosecha.',
    'Ciclovía de los domingos: distancias, tiempos, velocidad media y mapas de recorrido.',
    'Vuelta a Colombia y ciclismo de montaña: altitud de los puertos, pendientes en porcentaje, velocidad media en subida y bajada.',
    'Liga BetPlay: tabla de posiciones, puntos por partido, diferencia de goles, promedio de asistencia, probabilidad de clasificar.',
    'Pico y placa: patrones según el último dígito de la placa, días hábiles del mes, conteo y combinatoria.',
    'Salario mínimo 2026 ($1.750.905 más auxilio de transporte de $249.095): presupuesto familiar, porcentajes de gasto, comparación con años anteriores.',
    'Ahorro y crédito: interés simple y compuesto, cuotas fijas, tasa efectiva anual, tasa de usura y riesgos del gota a gota.',
    'Construcción con baldosas: área del piso, número de baldosas y cajas, desperdicio, costo total y guardaescoba (perímetro).',
    'Tejidos wayuu, molas guna y sombrero vueltiao zenú: simetrías, traslaciones, rotaciones, frisos y patrones numéricos (con respeto por su significado cultural).',
    'Temperatura y altitud: pisos térmicos, modelo lineal de descenso de temperatura con la altura, ciudades de la cordillera.',
    'Ríos de Colombia: longitudes, caudales en temporada seca y de lluvias, lectura de tablas del IDEAM aportadas por el docente.',
    'Mapas del municipio: escalas, distancias reales, área aproximada de la vereda o del barrio con cuadrícula.',
    'Censo y proyecciones del DANE aportados por el docente: pirámides de población del municipio, porcentajes por grupos de edad, crecimiento.',
    'Tienda escolar y restaurante escolar (PAE): raciones, compras al por mayor, presupuesto semanal.',
    'Recetas típicas (arepas, sancocho, natilla, buñuelos para la novena): ampliar o reducir cantidades con proporcionalidad.',
    'Planes de celular y de datos: comparación de tarifas con funciones lineales y sistemas de ecuaciones.',
    'Elecciones del personero y del consejo estudiantil: conteo de votos, porcentajes, gráficas y abstención.',
    'Precipitación y temporadas de lluvias: promedios mensuales, gráficas de barras y líneas, fenómenos de El Niño y La Niña con datos aportados.',
    'Huerta escolar: crecimiento de plantas medido cada semana, gráficas de variación, área de las eras.',
    'Rampas, escaleras y techos del colegio: pendientes, ángulos de inclinación, teorema de Pitágoras y trigonometría.',
    'Sombras en el patio a distintas horas: semejanza de triángulos para medir la altura del asta de la bandera o de un árbol.',
    'Juegos tradicionales (tejo, parqués, trompo, golosa): probabilidad con dados, distancias y puntajes.',
    'Reciclaje en el colegio: kilos de material por curso, precio de venta por kilo, gráficas comparativas.',
  ],
];
