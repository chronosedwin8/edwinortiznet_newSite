<?php

declare(strict_types=1);

// Artículo: por qué un kit curado de recetas de IA rinde más que «preguntarle a ChatGPT» (presenta el Kit de IA para docentes).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/kit-ia/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

return [
    'slug' => 'kit-de-ia-para-docentes-prompts-probados-curriculo-colombiano',
    'title' => 'Kit de IA para docentes: por qué una receta probada rinde más que «preguntarle a ChatGPT»',
    'excerpt' => 'La IA puede devolverte horas de planeación, evaluación y retroalimentación, pero solo si le hablas con método. Explico qué hace que una instrucción funcione, dónde se equivoca la IA en cada materia y cómo lo resolví con un kit de recetas alineadas con el currículo colombiano.',
    'seo_title' => 'Kit de IA para docentes: prompts alineados con DBA y Saber',
    'seo_description' => 'Cómo ahorrar horas con IA sin perder calidad: recetas de prompts alineadas con Estándares, DBA y Saber, rúbricas, DUA, privacidad y errores típicos.',
    'focus_keyword' => 'IA para docentes',
    'cover' => '/assets/img/articulos/kit-ia/kit-portada',
    'cover_alt' => 'Portada con el título Kit de IA para docentes: recetas probadas, no suerte, junto a una tarjeta de instrucción con rol, contexto, tarea, formato, restricciones y verificación',
    'published_at' => '2026-10-07 20:00:00',
    'content_html' => <<<HTML
<p>Seguramente te ha pasado. Le pides a un asistente de IA diez preguntas tipo Saber sobre proporcionalidad para tus estudiantes de séptimo y en treinta segundos tienes la prueba. En la hora y media siguiente descubres que dos claves están mal, que una pregunta tiene dos respuestas correctas, que los precios aparecen en dólares y que el «DBA 7» que cita no dice nada de lo que la IA asegura. Terminas rehaciendo casi todo. La IA sí ahorra tiempo, pero no a quien le pregunta a la carrera.</p>
<p>Después de más de veinte años enseñando matemáticas y tecnología, y de muchas horas probando instrucciones para planear, evaluar y adaptar, llegué a una conclusión que hoy comparto en cada taller: <strong>la diferencia entre perder y ganar tiempo con la IA está en el método, no en la herramienta</strong>. En este artículo explico ese método, muestro dónde se equivoca la IA en cada materia y cuento cómo lo convertí en un kit de recetas pensado para el aula colombiana.</p>

<h2>Preguntarle a ChatGPT no es lo mismo que trabajar con IA</h2>
<p>Un asistente de IA es un generador de texto muy convincente. Cuando le pides «hazme un taller de fracciones para sexto», completa los vacíos con lo más probable según lo que leyó en internet, y lo más probable casi nunca es tu colegio: un grupo de 38 estudiantes, sin internet en el aula, con la escala de valoración del Decreto 1290 y una malla organizada por Estándares Básicos de Competencias y Derechos Básicos de Aprendizaje (DBA).</p>
<p>El resultado tiene tres problemas que cualquier docente reconoce:</p>
<ul>
<li><strong>Es genérico.</strong> Sirve para cualquier país y por eso no sirve del todo para el tuyo: ardillas grises en la clase de ciencias, Thanksgiving en la de inglés, «estados» y «enmiendas» en la de sociales.</li>
<li><strong>Es seguro de sí mismo aunque esté equivocado.</strong> La IA no duda: inventa numeraciones de DBA, cita artículos de la Constitución que no dicen eso y entrega claves de respuesta sin haberlas resuelto.</li>
<li><strong>No llega en un formato útil.</strong> Te devuelve párrafos que tienes que convertir en tabla, guía o rúbrica, y ahí se va buena parte del tiempo que creías ahorrar.</li>
</ul>
<p>Nada de esto significa que la IA no sirva. Significa que hay que darle lo que no tiene: tu contexto, tus referentes y una forma de revisarse.</p>

<h2>La anatomía de una instrucción que sí funciona</h2>
<p>Una buena instrucción para la IA se parece a una buena consigna para un estudiante: dice quién debe actuar, en qué situación, qué producir, cómo entregarlo y cómo saber si quedó bien. Yo trabajo con seis partes:</p>
{$img('kit-receta', 700, 'Diagrama de las seis partes de una receta del kit: rol, contexto, tarea, formato de salida, restricciones y verificación, cada una con un ejemplo, y un panel con lo que acompaña la instrucción: cuándo usarla, variables, seguimientos, ejemplo revisado, lista de revisión y tiempo ahorrado', 'Las seis partes de una instrucción profesional y lo que trae cada receta alrededor de ella.')}
<ol>
<li><strong>Rol:</strong> activa el vocabulario y los criterios de un experto. «Actúa como docente de Ciencias Naturales de básica secundaria en Colombia, con experiencia en evaluación por competencias».</li>
<li><strong>Contexto:</strong> grado, número de estudiantes, recursos, región, tiempo disponible y referentes curriculares. Es la parte que más se omite y la que más cambia el resultado.</li>
<li><strong>Tarea:</strong> un verbo claro y un producto concreto. «Diseña una secuencia de cuatro clases», no «ayúdame con la célula».</li>
<li><strong>Formato de salida:</strong> lo que necesitas para usarlo sin reescribir. «Una tabla con momento, tiempo, actividad y evidencia de aprendizaje».</li>
<li><strong>Restricciones:</strong> lo que no debe hacer. «No inventes citas, datos ni códigos de DBA; si no estás seguro, márcalo como [POR CONFIRMAR]».</li>
<li><strong>Verificación:</strong> obliga a la IA a revisar su trabajo antes de entregarlo. «Resuelve de nuevo cada pregunta desde cero, sin mirar la clave, y confirma que coincide».</li>
</ol>
<p>Compara. Instrucción débil: «Hazme un taller de fracciones para sexto». Instrucción profesional: «Actúa como docente de matemáticas de 6.° en Colombia. Mi grupo confunde la fracción como parte de un todo con la fracción como razón. Diseña un taller de 50 minutos con tres momentos —exploración con material concreto, práctica guiada y reto—, en una tabla, con contextos colombianos y precios en pesos, y al final verifica cada respuesta». La segunda tarda un minuto más en escribirse y ahorra una hora de correcciones.</p>
<p>El problema es que escribir instrucciones así para cada tarea, cada grado y cada período también cuesta tiempo. Y ahí es donde un sistema hace la diferencia.</p>

<h2>Del prompt suelto a la receta: lo que construí</h2>
<p>Con esa idea armé el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a>: no una lista de «prompts mágicos», sino un sistema de trabajo por materia en el que cada instrucción ya viene escrita, probada y acompañada de lo necesario para usarla bien. Lo llamo receta porque, como en la cocina, trae ingredientes, pasos y la forma de saber si quedó bien. Cada una tiene:</p>
<ul>
<li><strong>Código, grados y tiempo ahorrado estimado</strong>, para ubicarla rápido en el PDF y en el archivo de texto.</li>
<li><strong>Cuándo usarla:</strong> la situación concreta de aula para la que fue diseñada.</li>
<li><strong>Tabla de variables:</strong> lo que va entre corchetes, como [GRADO], [COMPONENTE] o [TEMA], con un ejemplo de qué escribir.</li>
<li><strong>La instrucción completa</strong> con las seis partes, lista para copiar.</li>
<li><strong>Preguntas de seguimiento</strong>, porque la primera respuesta casi nunca es la mejor.</li>
<li><strong>Un ejemplo de resultado revisado</strong> por un docente con experiencia, para que sepas cómo luce algo aprovechable.</li>
<li><strong>Una lista de «Revisa antes de usar»</strong> con los errores que la IA suele cometer en esa tarea.</li>
</ul>
<p>Un ejemplo real: la receta MAT-06, «Ítems tipo Saber 3.°, 5.° y 9.° con distractores basados en errores típicos». Su ejemplo revisado incluye este ítem de 5.°: «En la tienda, una libra de panela cuesta \$3.400. Mariana compra tres libras y media. ¿Cuánto paga?». La clave es \$11.900, y cada distractor está explicado: \$10.200 revela que el estudiante ignoró la media libra; \$11.700, que calculó mal la mitad de 3.400; \$13.600, que redondeó 3,5 a 4 sin necesidad. Eso ya no es una pregunta: es un instrumento de diagnóstico.</p>
{$img('kit-pdf', 640, 'Tres páginas reales del kit de Matemáticas: la portada con 28 recetas, 4 flujos, 5 rúbricas y 12 errores típicos; la receta MAT-06 con su tabla de variables e instrucción; y el ejemplo revisado con la tabla de distractores', 'Páginas reales del kit de Matemáticas: portada, receta MAT-06 y su ejemplo revisado.')}

<h2>Dónde se gana el tiempo</h2>
<p>Las recetas están organizadas en seis categorías que corresponden a lo que de verdad consume las horas de un docente: <strong>planeación, evaluación, adaptación, recursos, retroalimentación y gestión</strong>. Cada una trae una estimación de tiempo ahorrado frente a hacer la tarea desde cero.</p>
{$img('kit-tiempo', 700, 'Gráfico de barras horizontales con el tiempo ahorrado estimado por tarea según el kit: prueba de período e informe de período, 2 horas; ajustes del PIAR y retroalimentación de 35 textos, 1 hora 30; ítems tipo Saber, 1 hora 15; adaptación DUA, 1 hora; planeación de clase, 45 minutos; rúbrica, 40 minutos; quiz de salida, 25 minutos por clase', 'Tiempo ahorrado estimado por algunas recetas de Matemáticas y Lengua Castellana. Son estimaciones del propio kit, no mediciones.')}
<p>Quiero ser honesto con esas cifras: son estimaciones y dependen de tu experiencia y de cuánto revises. Lo que sí tengo claro es dónde está el ahorro grande. No está en «escribir más rápido», sino en <strong>no tener que corregir lo que la IA hizo mal</strong>. Una prueba de período con tabla de especificaciones (MAT-12) o el informe de período con observaciones de boletín en la escala del Decreto 1290 (MAT-25) son tareas de dos horas que, con una instrucción mal dada, se convierten en tres.</p>
<p>Y una advertencia que repito en cada taller: el tiempo que te devuelve la IA no debería irse en hacer más guías. Úsalo en lo que ninguna máquina hace: conversar con el estudiante que se está quedando atrás, revisar con calma, planear con tu equipo.</p>

<h2>Dónde se gana la calidad: lo pedagógico</h2>
<h3>Alineación curricular de verdad</h3>
<p>La IA conoce los Estándares y los DBA «de oídas». Por eso las recetas te piden pegar el texto oficial del estándar y del DBA que trabajas, y le prohíben inventar códigos: lo que no pueda confirmar queda marcado como [POR CONFIRMAR]. Cada kit trae además un capítulo de referentes del área explicados en lenguaje claro: los Estándares Básicos de Competencias, los DBA, las competencias y componentes de las pruebas Saber y, según la materia, la Guía 30 de tecnología o la Guía 22 y el Marco Común Europeo de Referencia en inglés.</p>
<h3>Evaluación que informa</h3>
<p>Una pregunta de selección múltiple con distractores al azar solo dice quién acertó. Una con distractores construidos a partir de errores de pensamiento dice <em>por qué</em> se equivocó cada uno. Las recetas de evaluación exigen eso, más una tabla de especificaciones cuando se trata de una prueba completa. Cada kit trae también un banco de entre cuatro y cinco rúbricas con la escala nacional (Superior, Alto, Básico y Bajo). En la de resolución de problemas de matemáticas, por ejemplo, el criterio «Verificación» distingue entre quien comprueba con otro método (Superior) y quien «entrega resultados imposibles, como personas fraccionadas o precios absurdos, sin notarlo» (Bajo). Son descriptores que se pueden observar.</p>
<h3>Inclusión desde la planeación</h3>
<p>Cada kit incluye un capítulo sobre Diseño Universal para el Aprendizaje y ajustes razonables del PIAR según el Decreto 1421 de 2017, seis instrucciones comunes para cualquier materia —como convertir un texto a lectura fácil o adaptar una evaluación sin cambiar lo que mide— y recetas propias del área: una lectura científica en tres niveles, material accesible para estudiantes con baja visión, castellano escrito como segunda lengua para estudiantes sordos usuarios de Lengua de Señas Colombiana, o planeación multigrado al estilo Escuela Nueva. Si lo que necesitas es redactar el documento completo de un estudiante, la herramienta <a href="/herramientas/piar/">PIAR con IA</a> del sitio está hecha para eso; y si quieres el contexto completo, escribí sobre <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">qué debe tener un PIAR que funcione</a>.</p>
<h3>Retroalimentación que sirve</h3>
<p>La retroalimentación genérica («buen trabajo, mejora la ortografía») es uno de los errores típicos que el kit de Lengua enseña a detectar. Las recetas de retroalimentación piden comentarios del tipo «lo que ya logras» y «tu siguiente paso»; en inglés, códigos de error que no reescriben el texto del estudiante, y, en tecnología, pistas escalonadas para depurar código sin regalar la solución.</p>

<h2>Dónde se gana la confianza: lo técnico</h2>
<h3>Flujos de trabajo encadenados</h3>
<p>Pedirle todo junto a la IA («hazme la unidad, la prueba y las adaptaciones») baja la calidad. Funciona mejor encadenar: primero la planeación, luego la evaluación alineada a esa planeación y después las adaptaciones. Cada kit trae entre cuatro y cinco flujos así. Uno de los de matemáticas, «Unidad completa de proporcionalidad», recorre seis pasos en tres semanas con la tienda del barrio como hilo conductor: planear la primera clase, extenderla a una secuencia, cerrar cada sesión con un quiz de salida, armar un banco de problemas por niveles, analizar los errores de la prueba y entregar retroalimentación y plan de mejoramiento.</p>
<h3>Verificación contra los errores de la IA</h3>
<p>Aquí está, para mí, el mayor valor del kit. La IA no se equivoca igual en todas las áreas, así que cada materia trae sus doce errores típicos, con cómo detectarlos y cómo corregirlos. Algunos ejemplos tomados de los kits:</p>
<ul>
<li><strong>Matemáticas:</strong> resolver 2x² = 18 y quedarse solo con x = 3; usar punto decimal y coma de miles; dar ítems con dos opciones correctas.</li>
<li><strong>Lengua Castellana:</strong> inventar citas de obras literarias o atribuirlas al autor equivocado.</li>
<li><strong>Ciencias Naturales:</strong> explicar el clima colombiano con cuatro estaciones o afirmar que el agua siempre hierve a 100 °C, sin considerar la presión.</li>
<li><strong>Ciencias Sociales:</strong> llamar «Colombia» al territorio colonial o importar el civismo de Estados Unidos.</li>
<li><strong>Inglés:</strong> traducir «tinto» como <em>red wine</em> o incluir ítems de escucha en la prueba de Saber 11, que no tiene esa parte.</li>
<li><strong>Tecnología e Informática:</strong> escribir fórmulas en inglés para un Excel en español o proponer circuitos con LED sin resistencia.</li>
</ul>
<p>A eso se suma una lista general de once verificaciones, de la alineación curricular a la autoría, y hábitos prácticos: pedir el procedimiento de cada cálculo, comparar la respuesta en dos asistentes distintos y trabajar los documentos oficiales con herramientas que responden solo a partir del PDF que subes.</p>
<h3>Privacidad de los estudiantes</h3>
<p>Todo lo que escribes en un asistente sale de tu computador y se procesa en servidores casi siempre fuera de Colombia. La regla del kit es simple: <strong>la IA trabaja con situaciones pedagógicas, nunca con personas identificables</strong>. El capítulo de privacidad explica lo que exige la <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=49981" target="_blank" rel="noopener">Ley 1581 de 2012</a> —los datos de salud son sensibles y los de niñas, niños y adolescentes tienen protección reforzada—, cómo anonimizar con alias como «E1» y describiendo barreras en lugar de diagnósticos, y cómo desactivar el uso de tus conversaciones para entrenar modelos.</p>
<h3>Un acuerdo de uso con tus estudiantes</h3>
<p>Tus estudiantes ya usan IA. El kit propone un acuerdo de aula con un semáforo: rojo, sin IA; amarillo, IA como apoyo declarado; verde, IA integrada y evaluada por el criterio con que se usa. Incluye un modelo de acuerdo y una advertencia que comparto: los «detectores de IA» tienen tasas de error altas y no son prueba suficiente para sancionar a nadie.</p>

<h2>Pedido suelto frente a receta curada</h2>
{$img('kit-comparacion', 680, 'Tabla comparativa entre un pedido suelto a la IA y una receta del kit en seis aspectos: contexto, currículo, formato, calidad, evaluación y privacidad', 'Seis diferencias entre preguntar sin método y trabajar con una receta curada.')}
<table>
<thead><tr><th>Aspecto</th><th>Pedido suelto</th><th>Receta del kit</th></tr></thead>
<tbody>
<tr><td>Contexto</td><td>Genérico, de cualquier país</td><td>Grado, región, recursos y precios en pesos</td></tr>
<tr><td>Currículo</td><td>Numeraciones de DBA inventadas</td><td>Texto oficial pegado o marcado [POR CONFIRMAR]</td></tr>
<tr><td>Evaluación</td><td>Escalas importadas</td><td>Superior, Alto, Básico y Bajo, con rúbricas listas</td></tr>
<tr><td>Calidad</td><td>Claves sin comprobar</td><td>Autoverificación y doce errores típicos por materia</td></tr>
<tr><td>Ejemplo</td><td>Ninguno</td><td>Resultado revisado por un docente con experiencia</td></tr>
<tr><td>Contextos</td><td>Estereotipos o realidades ajenas</td><td>Banco de unos 28 contextos colombianos auténticos</td></tr>
</tbody>
</table>
<p>Ese último punto merece una línea más. El banco de contextos de matemáticas, por ejemplo, incluye la tienda del barrio con el fiado anotado en el cuaderno, los recibos de servicios públicos con subsidios por estrato, la cosecha de café pagada por kilo y la ciclovía de los domingos. Problemas así no se sienten importados, y los estudiantes lo notan.</p>

<h2>Seis materias, un kit por área</h2>
<p>El kit se vende por materia porque los errores de la IA no son los mismos en matemáticas que en inglés o en sociales. Hay seis: Matemáticas, Lengua Castellana, Ciencias Naturales y Educación Ambiental, Ciencias Sociales, Inglés y Tecnología e Informática. Cada uno cubre de transición a 11.° y trae entre 27 y 28 recetas, flujos de trabajo, rúbricas, doce errores típicos, el banco de contextos y los capítulos comunes de DUA y PIAR, privacidad, acuerdo de aula y glosario.</p>
{$img('kit-materias', 680, 'Seis tarjetas, una por materia, con su número de recetas, flujos y rúbricas y un error típico de la IA en esa área', 'Seis kits, uno por área, cada uno con los errores de IA propios de su materia.')}
<p>Recibes un ZIP con un PDF de más de cien páginas listo para imprimir y un archivo de texto con todas las instrucciones para copiar y pegar sin los saltos de línea raros que a veces aparecen al copiar desde un PDF. Las recetas funcionan en ChatGPT, Gemini, Claude o Copilot, también en sus versiones gratuitas.</p>

<h2>Lo que el kit no hace</h2>
<p>Prefiero decirlo claro. El kit no reemplaza tu criterio ni te exime de revisar: está diseñado para que la IA sea un asistente rápido y confiable, y para que siempre sepas qué mirar antes de llevar algo al aula. Algunos datos, como precios o tarifas, cambian con el tiempo y conviene actualizarlos en la variable correspondiente. Y el documento final es tuyo: tú lo firmas y tú respondes por él.</p>

<h2>Conclusión</h2>
<p>La IA no va a hacer mejores clases por nosotros, pero sí puede quitarnos de encima la parte mecánica que nos roba las tardes y los domingos. La condición es trabajar con método: contexto colombiano, referentes reales, formato útil y una verificación que atrape los errores antes de que lleguen al estudiante. Eso es lo que intenté empaquetar en cada receta. Si quieres seguir explorando, en <a href="/aulamagica-ia-herramientas-ia-docentes/">AulaMágica IA</a> encontrarás más ideas de inteligencia artificial para el aula y en mi análisis de las <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">pruebas PISA en América Latina</a> explico por qué la calidad de lo que evaluamos importa tanto.</p>

<p class="notice"><strong>Kit de IA para docentes, por materia.</strong> Eliges tu área al comprar y recibes su kit completo: entre 27 y 28 recetas con ejemplo revisado y lista de verificación, flujos de trabajo, rúbricas con la escala del Decreto 1290, los errores típicos de la IA en tu materia y un banco de contextos colombianos, en un PDF imprimible y un archivo de prompts listo para copiar. Cada materia cuesta 60.000 pesos (USD 15) y puedes llevar varias en el mismo pedido.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">Ver el Kit de IA para docentes</a></p>

<h2>Una pregunta para terminar</h2>
<p>Cuando un estudiante nos entrega un trabajo, no le preguntamos solo qué respondió, sino cómo llegó ahí y cómo sabe que está bien. Le exigimos método y verificación. <strong>Si eso es lo que le pedimos a un niño de quinto, ¿por qué seguimos aceptando de la IA respuestas que no le aceptaríamos a él?</strong></p>
HTML,
];
