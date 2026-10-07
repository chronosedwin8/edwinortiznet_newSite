<?php

declare(strict_types=1);

// Kit de IA para docentes: capítulos comunes a todas las materias (los usa `php bin/console kit:build`).
return [
    'como_usar_html' => <<<'HTML'
<p>Este kit no es una lista de «prompts mágicos». Es un <strong>sistema de trabajo</strong> para que la inteligencia artificial te ahorre tiempo en las tareas que más horas consumen —planear, evaluar, adaptar, retroalimentar e informar— sin que pierdas el control pedagógico ni el anclaje al currículo colombiano.</p>
<h3>Qué encuentras en cada receta</h3>
<ul>
<li><strong>Código, grados y tiempo ahorrado.</strong> El código (por ejemplo, MAT-07) te permite encontrar la misma receta en el archivo <em>prompts.txt</em>. El tiempo ahorrado es una estimación frente a hacer la tarea desde cero; depende de tu experiencia y de cuánto revises.</li>
<li><strong>Cuándo usarla.</strong> La situación concreta del aula para la que fue diseñada.</li>
<li><strong>Variables.</strong> Lo que va entre corchetes, como <code>[GRADO]</code> o <code>[TEMA]</code>. La tabla te dice qué escribir en cada una. Cuanto más concreto seas, mejor será el resultado.</li>
<li><strong>La instrucción (prompt).</strong> Lista para copiar. Ya trae el rol, el contexto colombiano, el formato de salida, las restricciones y un paso de verificación.</li>
<li><strong>Seguimientos.</strong> Las preguntas que conviene hacer después de la primera respuesta para mejorarla. La primera respuesta casi nunca es la mejor.</li>
<li><strong>Ejemplo revisado.</strong> Un fragmento real de una buena respuesta, ya corregido por un docente con experiencia, para que sepas cómo luce un resultado aprovechable.</li>
<li><strong>Revisa antes de usar.</strong> La lista de los errores que la IA suele cometer en esa tarea específica.</li>
</ul>
<h3>El método en seis pasos</h3>
<ol>
<li><strong>Elige la receta</strong> por categoría (planeación, evaluación, adaptación, recursos, retroalimentación o gestión) y por grado.</li>
<li><strong>Copia la instrucción</strong> desde <em>prompts.txt</em>: así evitas los saltos de línea y caracteres extraños que a veces aparecen al copiar desde un PDF.</li>
<li><strong>Reemplaza las variables</strong> con información de tu clase. Nunca escribas nombres, documentos ni diagnósticos de estudiantes identificables (ver el capítulo de privacidad).</li>
<li><strong>Pega tus propios insumos</strong> cuando la receta lo pida: el texto de lectura, el fragmento de la malla, las respuestas anonimizadas de tus estudiantes. La IA trabaja mucho mejor sobre material real que «de memoria».</li>
<li><strong>Itera con los seguimientos</strong> y pide cambios precisos: «acorta la actividad 2 a 15 minutos», «cambia el contexto por uno rural del Caribe».</li>
<li><strong>Verifica con la lista de chequeo</strong> y apropia el resultado: ajusta el lenguaje a tu grupo y a tu estilo. El documento final es tuyo y tú respondes por él.</li>
</ol>
<h3>Tres hábitos que multiplican el resultado</h3>
<ul>
<li><strong>Un bloque de contexto institucional.</strong> Escribe una sola vez un párrafo con el modelo pedagógico de tu PEI, la escala de tu SIEE, la intensidad horaria de tu área y las características generales del grupo (sin datos personales). Pégalo al inicio de cada conversación.</li>
<li><strong>Una conversación por tarea.</strong> Abre un chat nuevo para cada receta. Las conversaciones muy largas mezclan instrucciones y la calidad baja.</li>
<li><strong>Encadena en lugar de pedir todo junto.</strong> Primero la planeación, luego la evaluación alineada a esa planeación y después las adaptaciones. El capítulo «Flujos de trabajo» muestra esas cadenas paso a paso.</li>
</ul>
HTML,

    'anatomia_html' => <<<'HTML'
<p>Una buena instrucción para la IA se parece a una buena consigna para un estudiante: dice quién debe actuar, en qué situación, qué producir, cómo entregarlo y cómo saber si quedó bien. Todas las recetas de este kit siguen esta estructura de seis partes.</p>
<table>
<thead><tr><th>Parte</th><th>Para qué sirve</th><th>Ejemplo</th></tr></thead>
<tbody>
<tr><td><strong>1. Rol</strong></td><td>Activa el vocabulario y los criterios de un experto.</td><td>«Actúa como docente de Ciencias Naturales de básica secundaria en Colombia, con experiencia en evaluación por competencias».</td></tr>
<tr><td><strong>2. Contexto</strong></td><td>Evita respuestas genéricas: grado, número de estudiantes, recursos, región, tiempo disponible, referentes curriculares.</td><td>«Grupo de 7.° con 38 estudiantes en un colegio oficial rural de Boyacá; sin internet en el aula; bloques de 55 minutos».</td></tr>
<tr><td><strong>3. Tarea</strong></td><td>Un verbo claro y un producto concreto.</td><td>«Diseña una secuencia de 4 clases sobre…».</td></tr>
<tr><td><strong>4. Formato de salida</strong></td><td>Te entrega algo que puedes usar sin reescribir.</td><td>«Una tabla con columnas: momento, tiempo, actividad, evidencia de aprendizaje».</td></tr>
<tr><td><strong>5. Restricciones</strong></td><td>Lo que NO debe hacer o los límites que debe respetar.</td><td>«No inventes citas ni datos; usa español de Colombia; máximo una página».</td></tr>
<tr><td><strong>6. Verificación</strong></td><td>Obliga a la IA a revisar su propio trabajo antes de entregarlo.</td><td>«Antes de responder, comprueba que cada pregunta tenga una sola respuesta correcta y explica por qué los distractores son incorrectos».</td></tr>
</tbody>
</table>
<h3>Instrucción débil frente a instrucción profesional</h3>
<p><strong>Débil:</strong> «Hazme un taller de fracciones para sexto».</p>
<p><strong>Profesional:</strong> «Actúa como docente de matemáticas de 6.° en Colombia. Mi grupo confunde la fracción como parte de un todo con la fracción como razón. Diseña un taller de 50 minutos con tres momentos (exploración con material concreto, práctica guiada y reto), alineado con el pensamiento numérico de los Estándares de 6.° y 7.°. Usa contextos de una tienda de barrio con precios reales en pesos. Entrega una tabla por momento y las respuestas esperadas. Verifica todos los cálculos antes de responder».</p>
<h3>Técnicas que usan las recetas</h3>
<ul>
<li><strong>Preguntar antes de responder:</strong> «Antes de empezar, hazme hasta tres preguntas sobre mi grupo». Útil cuando no sabes qué contexto es relevante.</li>
<li><strong>Dar un ejemplo del resultado</strong> (instrucción con ejemplos): pegar una pregunta o una rúbrica que te guste para que la IA imite su nivel y su estilo.</li>
<li><strong>Trabajar sobre tus insumos:</strong> «Usa solo el texto que pego a continuación». Reduce las invenciones.</li>
<li><strong>Pedir alternativas:</strong> «Dame tres versiones con distinto nivel de dificultad». Elegir es más rápido que corregir.</li>
<li><strong>Autoverificación explícita:</strong> pedir que recalcule, que revise cada criterio o que marque lo que no puede comprobar.</li>
<li><strong>Dividir en pasos:</strong> primero el esquema, luego el desarrollo. Así corriges el rumbo a tiempo.</li>
</ul>
HTML,

    'plantilla_maestra' => <<<'TXT'
ROL
Actúa como [ROL: docente de (área) de (nivel) en Colombia, experto en (especialidad)].

CONTEXTO
- Grado y grupo: [GRADO], [N.º DE ESTUDIANTES] estudiantes, [CARACTERÍSTICAS DEL GRUPO sin datos personales].
- Institución: [OFICIAL/PRIVADA], [URBANA/RURAL], [MUNICIPIO o REGIÓN].
- Recursos disponibles: [RECURSOS: tablero, fotocopias, celulares, sala de sistemas, sin internet…].
- Tiempo: [DURACIÓN de la clase o de la unidad].
- Referentes: [ESTÁNDAR y DBA que trabajas; pega el texto oficial si lo tienes].
- Modelo pedagógico del PEI: [MODELO] · Escala del SIEE: Superior, Alto, Básico y Bajo (Decreto 1290 de 2009).

TAREA
[VERBO + PRODUCTO concreto: diseña, redacta, adapta, evalúa…].

FORMATO DE SALIDA
[Tabla con columnas…, lista numerada, documento con títulos…, extensión máxima].

RESTRICCIONES
- Usa español de Colombia y un lenguaje adecuado para [GRADO].
- No inventes citas, datos, normas ni códigos de DBA: si no estás seguro de algo, márcalo como [POR CONFIRMAR].
- Usa contextos colombianos realistas y precios en pesos actuales.
- [Otras restricciones propias].

VERIFICACIÓN
Antes de entregar, revisa que: (1) todo esté alineado con el referente indicado; (2) las respuestas y cálculos sean correctos; (3) el nivel sea adecuado para el grado; (4) se cumpla el formato. Al final, enumera lo que debo revisar yo.
TXT,

    'verificacion' => [
        'Alineación curricular: el estándar, el DBA o la competencia citados existen y dicen eso. Compáralos con el documento oficial del MEN o del ICFES; la IA suele inventar numeraciones.',
        'Exactitud: los datos, fechas, definiciones, cálculos y claves de respuesta son correctos. Resuelve tú mismo las preguntas antes de aplicarlas.',
        'Fuentes: ninguna cita, autor, libro, ley o enlace es inventado. Si no puedes comprobarlo en dos minutos, elimínalo.',
        'Nivel: el vocabulario, la longitud de los textos y la complejidad corresponden al grado y a tu grupo real.',
        'Contexto: los ejemplos son colombianos y verosímiles (precios, lugares, costumbres, clima, nombres) y no caen en estereotipos regionales, étnicos o de género.',
        'Lenguaje: español de Colombia (no «vosotros», «ordenador», «coger el autobús»), ortografía actualizada y trato respetuoso.',
        'Inclusión: la propuesta ofrece más de una forma de acceder, participar y demostrar lo aprendido (DUA) y no excluye a nadie por discapacidad, conectividad o recursos.',
        'Viabilidad: los tiempos, materiales y número de actividades caben en tu clase real.',
        'Evaluación: los criterios son observables, coherentes con lo enseñado y con la escala de tu SIEE.',
        'Privacidad: no quedó ningún dato personal de estudiantes, familias o colegas en la conversación ni en el documento.',
        'Autoría: revisaste, ajustaste y te apropiaste del resultado; puedes explicar y defender cada parte.',
    ],

    'privacidad_html' => <<<'HTML'
<p>Todo lo que escribes en un asistente de IA sale de tu computador y se procesa en servidores de una empresa, casi siempre fuera de Colombia. Por eso la regla de oro de este kit es simple: <strong>la IA trabaja con situaciones pedagógicas, nunca con personas identificables.</strong></p>
<h3>Lo que dice la norma</h3>
<ul>
<li><strong>Ley 1581 de 2012</strong> (protección de datos personales o <em>habeas data</em>): todo tratamiento de datos personales necesita una finalidad legítima y, en general, la autorización previa e informada del titular. Los datos sobre la salud, como un diagnóstico, son <strong>datos sensibles</strong> y tienen una protección reforzada.</li>
<li><strong>Datos de niñas, niños y adolescentes:</strong> el artículo 7 de la misma ley exige que su tratamiento respete el interés superior del menor y sus derechos fundamentales (así lo precisó la Corte Constitucional en la sentencia C-748 de 2011). En la práctica: necesitas la autorización de padres o acudientes y debes limitarte a lo estrictamente necesario.</li>
<li><strong>Decreto 1377 de 2013</strong>, hoy compilado en el Decreto 1074 de 2015, que reglamenta la autorización y las políticas de tratamiento. Tu institución debe tener su propia política: consúltala.</li>
<li><strong>CONPES 4144 de 2025</strong>, Política Nacional de Inteligencia Artificial, que incluye entre sus ejes la ética y la gobernanza de la IA, y los datos y la infraestructura.</li>
</ul>
<h3>Qué nunca debes escribir en un asistente de IA</h3>
<ul>
<li>Nombres y apellidos, números de documento, fotografías, direcciones, teléfonos o correos de estudiantes y familias.</li>
<li>Diagnósticos, historias clínicas, informes psicológicos o situaciones de protección (violencia, consumo, embarazo) asociados a una persona identificable.</li>
<li>Calificaciones con nombre propio, listados del SIMAT o capturas del sistema académico.</li>
<li>Información de colegas o de procesos disciplinarios.</li>
</ul>
<h3>Cómo anonimizar sin perder utilidad</h3>
<ul>
<li>Usa alias neutros: «Estudiante A», «E1», «un estudiante de 9.°».</li>
<li>Describe <strong>barreras y fortalezas</strong>, no diagnósticos: «se le dificulta sostener la atención más de 10 minutos y comprende mejor con apoyos visuales» en lugar del nombre de un trastorno junto a un nombre.</li>
<li>Generaliza los detalles que identifican: «vive en zona rural y camina una hora al colegio» basta; no hace falta la vereda.</li>
<li>Cuando pegues trabajos de estudiantes para retroalimentar, borra el nombre, el curso y cualquier dato personal del texto.</li>
</ul>
<h3>Configura tu asistente</h3>
<p>Casi todos los asistentes permiten desactivar el uso de tus conversaciones para entrenar sus modelos y borrar el historial. Busca en la configuración opciones como «Controles de datos», «Actividad» o «Privacidad». Si tu institución te da una cuenta educativa (Google Workspace for Education o Microsoft 365 Education), prefiérela: suele incluir protección de datos comercial y condiciones contractuales más estrictas que una cuenta personal gratuita.</p>
HTML,

    'politica_aula_html' => <<<'HTML'
<p>Tus estudiantes ya usan IA. Prohibirla del todo es difícil de hacer cumplir y les quita la oportunidad de aprender a usarla bien; permitirla sin reglas convierte las tareas en copia. La alternativa que proponen este kit y muchas instituciones es un <strong>acuerdo de aula explícito</strong>, construido con el grupo y conocido por las familias.</p>
<h3>El semáforo de uso de la IA</h3>
<table>
<thead><tr><th>Nivel</th><th>Qué significa</th><th>Ejemplos</th></tr></thead>
<tbody>
<tr><td><strong>Rojo: sin IA</strong></td><td>La actividad evalúa lo que el estudiante sabe hacer por sí mismo.</td><td>Evaluaciones en clase, dictados, cálculo mental, primera versión de un escrito personal.</td></tr>
<tr><td><strong>Amarillo: IA como apoyo declarado</strong></td><td>Se puede usar para generar ideas, pedir explicaciones o retroalimentación, pero el producto lo elabora el estudiante y declara cómo usó la IA.</td><td>Lluvia de ideas para un proyecto, explicación alternativa de un tema, revisión de ortografía de un borrador propio.</td></tr>
<tr><td><strong>Verde: IA integrada</strong></td><td>La actividad incluye la IA como herramienta y se evalúa el criterio con que se usa.</td><td>Comparar la respuesta de la IA con una fuente confiable, detectar errores en un texto generado, mejorar una instrucción.</td></tr>
</tbody>
</table>
<h3>Modelo de acuerdo de aula</h3>
<ol>
<li>En cada tarea, el docente indica el color del semáforo. Si no lo indica, es amarillo.</li>
<li>Quien use IA lo declara al final del trabajo: qué herramienta, para qué y qué cambió después. Declararlo no baja la nota; ocultarlo sí es una falta.</li>
<li>Nunca escribimos en la IA datos personales nuestros ni de compañeros.</li>
<li>Verificamos lo que dice la IA con al menos una fuente confiable: la IA se equivoca con seguridad.</li>
<li>Lo que entregamos debemos poder explicarlo con nuestras palabras. El docente puede pedir una explicación oral breve de cualquier trabajo.</li>
<li>Respetamos la edad mínima y las condiciones de cada servicio; varían entre 13 y 18 años y, para menores de edad, suelen exigir autorización de padres o acudientes.</li>
</ol>
<h3>Cómo evaluar en tiempos de IA</h3>
<ul>
<li><strong>Evalúa el proceso, no solo el producto:</strong> borradores, bitácoras, versiones con cambios, conversaciones en clase.</li>
<li><strong>Diseña tareas difíciles de delegar:</strong> que partan de la experiencia local, de datos tomados por el grupo o de una salida de campo.</li>
<li><strong>Incluye una defensa oral corta</strong> o una pregunta de transferencia en clase.</li>
<li><strong>No confíes en los «detectores de IA»:</strong> tienen tasas de error altas, producen falsos positivos (sobre todo con textos sencillos o de personas que escriben en una segunda lengua) y no son prueba suficiente para sancionar a un estudiante. Úsalos, si acaso, para abrir una conversación, nunca como evidencia.</li>
<li>Incorpora el acuerdo en el <strong>SIEE</strong> y en el manual de convivencia mediante el procedimiento de tu institución, para que tenga respaldo.</li>
</ul>
HTML,

    'herramientas_html' => <<<'HTML'
<p>Las instrucciones de este kit funcionan en cualquier asistente de IA conversacional actual. Las diferencias entre ellos cambian cada pocos meses, así que lo más útil es conocer sus fortalezas generales y usar el que tengas disponible, preferiblemente con una cuenta institucional.</p>
<table>
<thead><tr><th>Asistente</th><th>Empresa</th><th>Puntos fuertes para docentes</th></tr></thead>
<tbody>
<tr><td><strong>ChatGPT</strong></td><td>OpenAI</td><td>Muy versátil; versión gratuita con límites de uso; permite crear asistentes personalizados con tus instrucciones en las versiones de pago.</td></tr>
<tr><td><strong>Gemini</strong></td><td>Google</td><td>Integrado con Documentos, Presentaciones y Drive; disponible para cuentas de Google Workspace for Education según la configuración de la institución.</td></tr>
<tr><td><strong>Claude</strong></td><td>Anthropic</td><td>Destaca con documentos largos y redacción cuidada; útil para analizar mallas curriculares, PEI o textos extensos.</td></tr>
<tr><td><strong>Copilot</strong></td><td>Microsoft</td><td>Integrado con Word, PowerPoint y Edge; con cuentas educativas de Microsoft 365 ofrece protección de datos empresarial.</td></tr>
<tr><td><strong>NotebookLM</strong></td><td>Google</td><td>Responde solo a partir de los documentos que subes (por ejemplo, los Estándares o los DBA en PDF) y cita la fuente: ideal para consultar referentes sin invenciones.</td></tr>
</tbody>
</table>
<h3>Recomendaciones prácticas</h3>
<ul>
<li>Si una respuesta no te convence, prueba la misma instrucción en otro asistente: comparar dos respuestas es una forma rápida de detectar errores.</li>
<li>Para cálculos y claves de respuesta, pide que muestre el procedimiento y compruébalo tú o con una calculadora.</li>
<li>Para trabajar con documentos oficiales, sube el PDF o pega el fragmento: no confíes en lo que la IA «recuerda» de una norma o de un DBA.</li>
<li>Las versiones gratuitas suelen bastar para todas las recetas de este kit. Las de pago dan más capacidad de uso y modelos más potentes, pero no reemplazan una buena instrucción.</li>
</ul>
HTML,

    'dua_html' => <<<'HTML'
<p>El <strong>Diseño Universal para el Aprendizaje (DUA)</strong>, propuesto por CAST, parte de una idea sencilla: si planeas desde el inicio para la diversidad del grupo, necesitas menos adaptaciones individuales después. El <strong>Decreto 1421 de 2017</strong>, que reglamenta la atención educativa a la población con discapacidad en Colombia, adopta el DUA como base de la planeación y define el <strong>PIAR</strong> (Plan Individual de Ajustes Razonables) para los apoyos que cada estudiante con discapacidad necesita además de lo que el DUA ya ofrece.</p>
<h3>Los tres principios</h3>
<ul>
<li><strong>Múltiples formas de implicación</strong> (el porqué del aprendizaje): opciones para despertar el interés, sostener el esfuerzo y autorregularse.</li>
<li><strong>Múltiples formas de representación</strong> (el qué): la información se presenta de varias maneras: oral, escrita, visual, manipulativa, con apoyos de vocabulario.</li>
<li><strong>Múltiples formas de acción y expresión</strong> (el cómo): los estudiantes demuestran lo aprendido de distintas formas: oral, escrita, gráfica, con maquetas o con tecnología.</li>
</ul>
<h3>DUA y PIAR: cómo se complementan</h3>
<ul>
<li>El DUA beneficia a todo el grupo y se planea en la secuencia didáctica.</li>
<li>Los <strong>ajustes razonables</strong> del PIAR responden a barreras concretas de un estudiante: curriculares, metodológicos, de evaluación, de tiempos, de materiales o de comunicación. No rebajan las metas de aprendizaje sin justificación: buscan que el estudiante pueda alcanzarlas.</li>
<li>El PIAR lo elaboran el docente de aula y el docente de apoyo con la familia y el estudiante; se revisa periódicamente y hace parte de la historia escolar.</li>
<li>La IA puede ayudarte a redactar borradores de adaptaciones y ajustes, pero la valoración pedagógica la hace el equipo que conoce al estudiante. Describe barreras y fortalezas, nunca datos que lo identifiquen.</li>
</ul>
<p>Las instrucciones siguientes sirven para cualquier materia. Úsalas junto con las recetas de la categoría «Adaptación» de tu área.</p>
HTML,

    'dua_prompts' => [
        [
            'titulo' => 'Planear una clase con los tres principios del DUA',
            'prompt' => <<<'TXT'
Actúa como docente experto en Diseño Universal para el Aprendizaje (DUA) y en el Decreto 1421 de 2017.
Esta es mi planeación de clase para [GRADO] en [ÁREA] sobre [TEMA]:
[PEGA TU PLANEACIÓN]
Características del grupo (sin datos personales): [DESCRIPCIÓN: número de estudiantes, ritmos, barreras observadas, recursos].
Tarea: enriquece la planeación con opciones DUA sin cambiar el objetivo de aprendizaje.
Formato: una tabla con tres filas (implicación, representación, acción y expresión) y columnas «Qué agrego», «En qué momento de la clase», «Material necesario». Luego, la planeación completa ajustada.
Restricciones: propuestas realistas para un aula colombiana con [RECURSOS]; nada que requiera comprar equipos; máximo dos opciones nuevas por principio.
Verificación: confirma que el objetivo de aprendizaje y la evidencia de evaluación siguen siendo los mismos y que cada opción la puede usar cualquier estudiante, no solo uno.
TXT,
        ],
        [
            'titulo' => 'Convertir un texto a lectura fácil',
            'prompt' => <<<'TXT'
Actúa como especialista en lectura fácil y accesibilidad cognitiva.
Adapta el siguiente texto para estudiantes de [GRADO] que necesitan apoyos de comprensión lectora:
[PEGA EL TEXTO]
Pautas: oraciones cortas (una idea por oración), vocabulario frecuente, voz activa, sin metáforas ni dobles negaciones, palabras difíciles explicadas entre paréntesis la primera vez, títulos y listas para organizar la información.
Formato: primero el texto adaptado; después una tabla «palabra clave – explicación sencilla – sugerencia de imagen o pictograma».
Restricciones: conserva TODAS las ideas principales y los datos del original; no agregues información que no esté en el texto.
Verificación: al final, enumera las ideas principales del original y señala en qué párrafo del texto adaptado aparece cada una.
TXT,
        ],
        [
            'titulo' => 'Proponer ajustes razonables para una barrera concreta',
            'prompt' => <<<'TXT'
Actúa como docente de apoyo pedagógico con experiencia en la elaboración de PIAR según el Decreto 1421 de 2017.
Estudiante (alias): [ALIAS]. Grado: [GRADO]. Área: [ÁREA].
Barreras observadas en el aula (sin diagnósticos ni datos personales): [DESCRIPCIÓN DE LAS BARRERAS].
Fortalezas e intereses: [FORTALEZAS E INTERESES].
Meta de aprendizaje del periodo para el grupo: [META].
Tarea: propone ajustes razonables para que el estudiante alcance la meta.
Formato: tabla con columnas «Tipo de ajuste (curricular, metodológico, evaluativo, de tiempo, de materiales, de comunicación)», «Ajuste concreto», «Cómo se implementa en clase», «Cómo sabré si funciona».
Restricciones: ajustes viables para un docente con [N.º] estudiantes; no rebajes la meta salvo que lo justifiques; lenguaje respetuoso y centrado en la persona.
Verificación: revisa que cada ajuste responda a una barrera descrita y que ninguno dependa de un recurso que no tengo: [RECURSOS DISPONIBLES].
TXT,
        ],
        [
            'titulo' => 'Menú de opciones para demostrar lo aprendido',
            'prompt' => <<<'TXT'
Actúa como docente experto en evaluación auténtica y DUA.
Objetivo de aprendizaje: [OBJETIVO]. Grado: [GRADO]. Evidencia que debo valorar: [EVIDENCIA].
Diseña un menú de 5 productos distintos con los que un estudiante puede demostrar el mismo aprendizaje (por ejemplo: explicación oral grabada, infografía, maqueta, texto escrito, dramatización).
Formato: para cada producto, una consigna de máximo 4 líneas y los 3 criterios comunes de evaluación, idénticos para todos los productos.
Restricciones: todos los productos deben poder hacerse con materiales de bajo costo y en [TIEMPO]; ninguno debe requerir internet en casa.
Verificación: comprueba que los criterios evalúen el aprendizaje y no la habilidad artística o tecnológica.
TXT,
        ],
        [
            'titulo' => 'Adaptar una evaluación sin cambiar lo que mide',
            'prompt' => <<<'TXT'
Actúa como experto en evaluación accesible.
Esta es mi evaluación de [ÁREA] para [GRADO]:
[PEGA LA EVALUACIÓN]
Necesito una versión con apoyos para estudiantes que presentan [BARRERA: dificultad en lectura extensa, baja visión, procesamiento lento…].
Aplica solo los ajustes pertinentes: enunciados más cortos, una instrucción por pregunta, tipografía y espaciado amplios, apoyos visuales descritos, menos ítems con el mismo nivel de exigencia, tiempo adicional sugerido.
Formato: la evaluación adaptada completa y, al final, una tabla «pregunta original – cambio realizado – por qué no altera lo que se evalúa».
Verificación: confirma que cada pregunta adaptada mide la misma competencia que la original y que la clave de respuestas sigue siendo válida.
TXT,
        ],
        [
            'titulo' => 'Retos de profundización para estudiantes avanzados',
            'prompt' => <<<'TXT'
Actúa como docente experto en atención a estudiantes con capacidades o talentos excepcionales.
Tema que trabaja el grupo: [TEMA]. Grado: [GRADO]. El estudiante ya domina: [LO QUE YA DOMINA].
Diseña 3 retos de profundización que amplíen el tema en complejidad y no solo en cantidad de ejercicios: uno de investigación, uno de creación y uno de aplicación a un problema real de [MUNICIPIO o REGIÓN].
Formato: para cada reto, consigna, producto esperado, criterios de calidad y cómo lo comparte con el grupo.
Verificación: revisa que cada reto pueda hacerse de forma autónoma en clase mientras el resto del grupo trabaja la actividad principal.
TXT,
        ],
    ],

    'glosario' => [
        'Ajuste razonable' => 'Modificación o apoyo pertinente para un estudiante con discapacidad, basado en su valoración pedagógica, que le permite participar y aprender en igualdad de condiciones (Decreto 1421 de 2017).',
        'Alucinación' => 'Respuesta de la IA que suena convincente pero es falsa o inventada: una cita, un dato, una norma o una referencia que no existe.',
        'Anonimizar' => 'Quitar o cambiar los datos que permiten identificar a una persona antes de compartir información.',
        'Asistente de IA' => 'Programa conversacional basado en un modelo de lenguaje (ChatGPT, Gemini, Claude, Copilot) que responde a instrucciones escritas.',
        'Cadena de instrucciones' => 'Secuencia de instrucciones en la que el resultado de una es el insumo de la siguiente (por ejemplo: planeación, luego evaluación, luego adaptación).',
        'Competencia' => 'Saber hacer flexible que integra conocimientos, habilidades y actitudes para actuar en contextos nuevos. Es el eje de los Estándares Básicos de Competencias.',
        'Contexto (en IA)' => 'Información que le das al asistente para que ajuste su respuesta: grado, grupo, recursos, referentes. También, la cantidad de texto que el modelo puede tener en cuenta a la vez.',
        'DBA' => 'Derechos Básicos de Aprendizaje: aprendizajes estructurantes por grado y área publicados por el Ministerio de Educación Nacional, con evidencias y ejemplos.',
        'Desempeño' => 'Nivel en que un estudiante alcanza los aprendizajes. En Colombia, la escala nacional es Superior, Alto, Básico y Bajo (Decreto 1290 de 2009).',
        'Distractor' => 'Opción incorrecta de una pregunta de selección múltiple. Un buen distractor es plausible y refleja un error típico de razonamiento.',
        'DUA' => 'Diseño Universal para el Aprendizaje: marco para planear desde el inicio con múltiples formas de implicación, representación y acción y expresión.',
        'Estándares Básicos de Competencias' => 'Referentes del Ministerio de Educación Nacional (2006) que establecen lo que los estudiantes deben saber y saber hacer al terminar cada grupo de grados.',
        'Evidencia de aprendizaje' => 'Acción o producto observable que muestra que el estudiante alcanzó un aprendizaje.',
        'Ítem' => 'Pregunta de una prueba. En las pruebas Saber, los ítems de selección múltiple con única respuesta tienen un enunciado, varias opciones de respuesta (en la mayoría de las pruebas, cuatro: A, B, C y D) y una sola clave.',
        'Instrucción con ejemplos' => 'Técnica en la que se incluyen uno o varios ejemplos del resultado esperado para que la IA imite su forma y su nivel.',
        'Lectura fácil' => 'Método de redacción y adaptación de textos para hacerlos comprensibles a personas con dificultades de comprensión lectora.',
        'Malla de aprendizaje' => 'Documento del MEN que organiza por grado la progresión de los aprendizajes de los DBA, con orientaciones didácticas. Las publicadas en 2017 cubren de 1.° a 5.° en lenguaje, matemáticas, ciencias naturales y ciencias sociales.',
        'Matriz de referencia' => 'Documento del ICFES que muestra, para cada prueba Saber, las competencias, afirmaciones y evidencias que se evalúan.',
        'Modelo de lenguaje' => 'Sistema de IA entrenado con enormes cantidades de texto para predecir y generar lenguaje. Es la base de los asistentes conversacionales.',
        'PIAR' => 'Plan Individual de Ajustes Razonables: herramienta que garantiza los procesos de enseñanza y aprendizaje de los estudiantes con discapacidad, a partir de su valoración pedagógica y social (Decreto 1421 de 2017).',
        'Prompt (instrucción)' => 'Texto con el que le pides algo a un asistente de IA. Su calidad determina en gran parte la calidad de la respuesta.',
        'Retroalimentación formativa' => 'Información que recibe el estudiante sobre su desempeño, específica y oportuna, para que sepa qué hizo bien, qué mejorar y cómo hacerlo.',
        'Rúbrica analítica' => 'Tabla que describe, para cada criterio, cómo se ve el desempeño en cada nivel. Permite evaluar y retroalimentar con precisión.',
        'Sesgo' => 'Tendencia sistemática de la IA a favorecer ciertas visiones, grupos o contextos (por ejemplo, ejemplos de otros países o estereotipos de género), heredada de sus datos de entrenamiento.',
        'SIEE' => 'Sistema Institucional de Evaluación de los Estudiantes: reglas de evaluación y promoción que cada institución define en el marco del Decreto 1290 de 2009.',
        'Verificación' => 'Paso final de una instrucción en el que se le pide a la IA revisar su respuesta contra criterios concretos antes de entregarla. No reemplaza tu revisión.',
    ],
];
