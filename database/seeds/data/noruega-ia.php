<?php

declare(strict_types=1);

// "Noruega prohíbe la IA a niños de 6 a 13 años": verificación del titular viral (Infobae 20-jun-2026). Fuentes (17-oct-2026): Udir (recomendación por trinn, 25-jun-2026, página actualizada 12-oct-2026: 1.º-7.º "i all hovedsak" sin acceso a IA generativa; 8.º-10.º gradual; videregående uso apropiado; excepciones; Udir iba a detallar antes del 1-oct); NRK 19-jun-2026 (Støre, Nordtun; propuesta de ley de acceso a materiales impresos); Barnevakten/Kiforskolen; Udir Spørsmål til Skole-Norge ene-2026 (80 % usa IA; 65 % primaria, 89 % ungdomsskole; 2/10 con edad local; 16 % 1-4; 75 % sin plan; 62 % celulares); Utdanningsforbundet (Røsvoll); OCDE PISA 2025 (Noruega 452/453/470 vs 463/461/482; ciencias 470 verificado en el PDF; asterisco) y 2022; TALIS 2024 Noruega 40 % vs 36 % (con asterisco); China Daily 16-may-2025; NY1 2-sep-2026; UNESCO 2023; Bastani PNAS 2025; Delgado 2018 (g -0,21); Colombia PISA 2025 381/399/414 (La República, Cambio); Ley 2626/2026. La página regjeringen.no devolvió 403: se citan Udir/NRK. Libro verificado en Excel 16 y Python: respaldo medio ponderado 54,5 (2 confirmadas, 3 parciales, 1 sin respaldo). Veredictos: juicio propio.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/noruega-ia/' . $name;
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
<p>Circula desde el 20 de junio de 2026 un titular que se compartió miles de veces: <strong>"Noruega se convierte en el primer país en prohibir el uso de inteligencia artificial a niños de entre 6 y 13 años y apuesta por el regreso a los libros de papel"</strong>. Suena contundente, tiene una frase atractiva ("primero aprender a leer, escribir, pensar y razonar; después, usar la tecnología") y llega justo cuando muchos docentes y familias se preguntan qué hacer con la IA. La pregunta honesta es: <strong>¿qué tan cierto es?</strong></p>
<p>Fui a las fuentes: la página oficial de la Dirección de Educación de Noruega (Udir), la cobertura de la televisión pública noruega (NRK), la reacción del sindicato docente y los datos de la OCDE sobre la calidad educativa del país. El veredicto, en una línea: <strong>lo esencial es cierto, pero el titular exagera en tres puntos: no es una prohibición legal sino una recomendación nacional, no pude confirmar que sea "el primer país" y "el regreso a los libros de papel" es, por ahora, una propuesta de ley</strong>. Además, el caso sirve para revisar un mito más grande: el de los países "modelo" en educación. Incluyo un <a href="/descargas/noruega-ia/verificador-titular-noruega-ia-escuela.xlsx">libro de Excel</a> que desglosa el titular afirmación por afirmación (verificado en Microsoft Excel 16 y contra un cálculo independiente). Fuentes revisadas el <strong>17 de octubre de 2026</strong>.</p>
<p class="notice"><strong>Advertencia.</strong> La página del gobierno noruego con el comunicado del 19 de junio no me abrió desde mi sistema de consulta; me apoyo en la página oficial de Udir, en NRK y en un sitio que resume las fuentes oficiales, y traduzco del noruego (las traducciones son mías). Los veredictos del libro son <strong>mi juicio</strong> sobre esas fuentes, no datos publicados.</p>

<h2>Qué dijo exactamente Noruega</h2>
<ul>
<li><strong>19 de junio de 2026:</strong> en su rueda de prensa semestral, el primer ministro Jonas Gahr Støre anunció que el gobierno recomendará que la inteligencia artificial "en lo esencial no se use" en la escuela primaria. Dijo que el uso acrítico de la IA "aumenta el riesgo de saltarse pasos importantes del aprendizaje" y que, "al mismo tiempo, los resultados escolares y las habilidades de los estudiantes están cayendo".</li>
<li><strong>25 de junio de 2026:</strong> la Dirección de Educación (Udir), por encargo del Ministerio de Educación, publicó los nuevos consejos por etapa. Según su página (actualizada el 12 de octubre de 2026), la recomendación se basa en el conocimiento disponible y en el <strong>principio de precaución</strong>.</li>
<li><strong>La ministra de Educación, Kari Nessa Nordtun:</strong> "Los estudiantes deben aprender a leer, escribir y calcular antes de usar IA. Deben tener buenas relaciones con su docente y sus compañeros. Los más pequeños no tienen el conocimiento, la reflexión crítica ni la autorregulación necesarios para usarla bien", y "no debemos cometer el mismo error de cuando los dispositivos digitales se introdujeron sin crítica entre los más pequeños".</li>
</ul>
{{img:etapas}}
<p>Tres precisiones que el titular omite:</p>
<ol>
<li><strong>Es una recomendación, no una ley.</strong> En Noruega la gestión de las escuelas es local (la administran los municipios) y el gobierno actúa a través de recomendaciones de Udir, que las escuelas "se espera" que sigan. El mismo mecanismo se usó para los celulares en 2024. Por eso la palabra "prohibir" es inexacta, aunque en la práctica pueda pesar casi como una norma.</li>
<li><strong>Hay excepciones previstas.</strong> La ministra dijo que los estudiantes que, por distintas razones, necesitan herramientas basadas en IA, las tendrán: menciona la enseñanza de idiomas y la educación individualizada. Udir indicó que detallará las excepciones; su página del 12 de octubre sigue hablando de recomendaciones "en preparación", y no pude confirmar que el texto ampliado se haya publicado.</li>
<li><strong>Los estudiantes siguen aprendiendo <em>sobre</em> la IA.</strong> La recomendación se refiere al <em>acceso</em> de los estudiantes a la IA generativa, no a enseñar cómo funciona y qué efectos tiene en la sociedad, algo que el currículo respalda.</li>
</ol>

<h2>Verificación del titular, afirmación por afirmación</h2>
{{img:afirmaciones}}
<table>
<thead><tr><th>Afirmación</th><th>Veredicto</th><th>Por qué</th></tr></thead>
<tbody>
<tr><td>"Prohíbe el uso de IA a niños"</td><td>Parcialmente cierta</td><td>Es una recomendación nacional (no una ley) de que en 1.º a 7.º los estudiantes "en lo esencial" no tengan acceso a IA generativa; con excepciones.</td></tr>
<tr><td>"Es el primer país en hacerlo"</td><td>No respaldada</td><td>Según China Daily, en mayo de 2025 China prohibió que estudiantes de primaria usen de forma autónoma herramientas de IA generativa de contenido abierto (otras fuentes lo describen como un uso supervisado). Y Nueva York decretó el 2 de septiembre de 2026 una moratoria de un año hasta 8.º grado. Noruega puede ser de los primeros en Europa, pero no pude confirmarlo.</td></tr>
<tr><td>"De entre 6 y 13 años"</td><td>Confirmada</td><td>Los grados 1.º a 7.º de la primaria noruega corresponden a esas edades.</td></tr>
<tr><td>"Apuesta por el regreso a los libros de papel"</td><td>Parcialmente cierta</td><td>El primer ministro anunció que el gobierno propondrá por ley que las escuelas básicas tengan acceso a materiales impresos. Es una propuesta; y el sindicato docente pide "una variedad de materiales", impresos y digitales.</td></tr>
<tr><td>"Primero leer, escribir, pensar y razonar"</td><td>Confirmada (con matiz)</td><td>La ministra habló de leer, escribir y calcular; "pensar y razonar" es una paráfrasis del titular.</td></tr>
<tr><td>"Sin reemplazar capacidades humanas fundamentales"</td><td>Parcialmente cierta</td><td>Es el argumento del gobierno, razonable pero con poca evidencia directa sobre niños de 6 a 13 años (ver más abajo).</td></tr>
</tbody>
</table>
<p>El libro de Excel reúne estas afirmaciones, con un puntaje de respaldo y un peso por afirmación, y calcula una lectura global. Con mis valores, el respaldo medio ponderado es de <strong>54,5 sobre 100: un titular "con exageraciones"</strong>, no un titular falso.</p>
<pre><code>' Respaldo medio ponderado (hoja Resumen)
=SUMAPRODUCTO(Afirmaciones!F4:F9;Afirmaciones!G4:G9)/SUMA(Afirmaciones!G4:G9)        ' español
=SUMPRODUCT(Afirmaciones!F4:F9,Afirmaciones!G4:G9)/SUM(Afirmaciones!G4:G9)           ' inglés

' Veredicto de cada afirmación (umbrales editables en la hoja Parametros)
=SI(F4>=Parametros!$B$3;"Confirmada";SI(F4>=Parametros!$B$4;"Parcialmente cierta";"No respaldada"))   ' español
=IF(F4>=Parametros!$B$3,"Confirmada",IF(F4>=Parametros!$B$4,"Parcialmente cierta","No respaldada"))   ' inglés</code></pre>

<h2>El contexto: por qué Noruega actuó</h2>
<p>La medida no salió de la nada. Según la encuesta "Preguntas a Skole-Norge" de Udir (enero de 2026), <strong>unas ocho de cada diez escuelas de educación básica ya usaban herramientas de IA</strong> (el 65 % de las de primaria y el 89 % de las de secundaria baja), <strong>no había ninguna edad mínima nacional</strong>, solo dos de cada diez escuelas habían fijado una por su cuenta y el 16 % de las de primaria daba acceso a la IA ya entre 1.º y 4.º grado. Además, el 75 % de las escuelas no tenía un plan para usarla. Es decir: la IA ya estaba en las aulas pequeñas, sin reglas. Entre los docentes, según TALIS 2024 (OCDE), el 40 % usó IA en su trabajo (promedio OCDE: 36 %), sobre todo para resumir y aprender sobre un tema (65 %) y generar planes de clase (57 %); solo el 19 % la usó para evaluar trabajos. Noruega figura con asterisco en esa encuesta: su participación quedó por debajo del estándar y las comparaciones deben leerse con cautela.</p>
{{img:udir}}
<p>Antes, en febrero de 2024, Udir había recomendado sacar los celulares de las aulas; en 2026, según la misma encuesta, el 62 % de las escuelas pide dejar el celular en una caja o con el docente al empezar el día. Y el gobierno noruego prepara una ley de edad mínima en redes sociales (consulta pública entre julio y octubre de 2025; el proyecto iría al Parlamento a más tardar a fines de 2026). Como en otros casos, hay un patrón: <strong>Noruega primero recomienda, luego mide y a veces legisla</strong>.</p>

<h2>La calidad de la educación en Noruega: lo que muestran los datos</h2>
<p>La escuela noruega es obligatoria durante diez años, de los 6 a los 16: siete años de primaria (1.º a 7.º) y tres de secundaria baja (8.º a 10.º), administrados por los municipios, con supervisión de los gobernadores de condado, y con un currículo renovado desde 2020. El país figura entre los que más invierten por estudiante en los rankings basados en <em>Education at a Glance</em> (las cifras varían según la fuente). Pero invertir mucho no es lo mismo que obtener resultados altos:</p>
{{img:pisa}}
<ul>
<li><strong>PISA 2022:</strong> según la OCDE, Noruega obtuvo resultados cercanos al promedio en matemáticas y lectura, y por debajo en ciencias; en matemáticas fue el valor más bajo de toda su historia en PISA.</li>
<li><strong>PISA 2025</strong> (publicada el 8 de septiembre de 2026): los resultados de Noruega fueron <strong>452 en matemáticas, 453 en lectura y 470 en ciencias</strong>, por debajo del promedio de la OCDE (463, 461 y 482) en las tres áreas. Frente a 2022, bajó unos 17 puntos en matemáticas y 24 en lectura (en ciencias, 8 puntos, sin significación estadística). Según el Consejo Nórdico, es la primera vez desde 2006 que está por debajo del promedio en las tres. La OCDE marca a Noruega con asterisco en sus tablas, lo que invita a leer los datos con cautela.</li>
</ul>
<p>El propio primer ministro lo dijo: "los resultados escolares y las habilidades de los estudiantes están cayendo". Es el contexto de la medida: <strong>una reacción de un sistema que ve caer sus resultados y busca una palanca</strong>. Conviene decirlo con claridad: <strong>no hay evidencia de que la IA haya causado esa caída</strong>. Los resultados de PISA bajaron en muchos países antes de que la IA generativa llegara a las aulas, y suelen explicarse por varios factores (pandemia, lectura, atención y uso de pantallas, entre otros). La IA es una explicación posible, no demostrada.</p>

<h2>¿Están sus leyes alineadas con la educación y la tecnología?</h2>
<ul>
<li><strong>Autonomía local, recomendaciones nacionales.</strong> No hay una ley que fije una edad mínima para que los estudiantes usen IA. La coherencia está en el método: recomendación de Udir, decisión del municipio y la escuela, y vigilancia de la protección de datos. Udir recuerda que los requisitos de la ley de datos personales se aplican siempre que se traten datos, y que la escuela debe usar soluciones seguras evaluadas y aprobadas por su propietario. En la encuesta de Udir, nueve de cada diez escuelas dicen haber revisado la privacidad de las herramientas de IA.</li>
<li><strong>La ley de IA todavía no rige en Noruega.</strong> El Reglamento de IA de la Unión Europea tiene que incorporarse al Acuerdo EEE y a la ley noruega; según análisis de consultoras y despachos, el plan era tener la ley a fines del verano de 2026 y se corrió: habría una nueva consulta en otoño de 2026 y un proyecto al Parlamento en la primavera de 2027. Es una información de segunda mano; conviene verificarla en la fuente oficial.</li>
<li><strong>Redes sociales.</strong> Existe un límite de 13 años desde 2018 (con permiso de los padres para menores) y un proyecto de ley para elevarlo a 15 años con verificación de edad, todavía no aprobado.</li>
<li><strong>Libros.</strong> La Ley del Libro entró en vigor el 1 de enero de 2024 y garantiza un precio fijo de 12 meses para cada libro nuevo; una política cultural que protege a las librerías pequeñas. La propuesta de 2026 va en la misma línea: que las escuelas tengan libros impresos como derecho.</li>
</ul>
<p><strong>Lectura crítica:</strong> las leyes noruegas no están "alineadas con la IA en la escuela" en el sentido de una norma específica: hay regulación general de datos, una cultura de recomendaciones y una intención política clara. La contradicción aparente (prohibir la IA a los 6 a 13 años y a la vez tener escuelas que ya la usaban) se explica por el vacío anterior, no por una incoherencia.</p>

<h2>La cultura: lectura, tiempo sin pantallas y confianza local</h2>
<p>Lo que revela el caso noruego es una cultura de política educativa con rasgos reconocibles:</p>
<ul>
<li><strong>Precaución antes que entusiasmo:</strong> Udir fundamenta su recomendación en el principio de precaución. La ministra reconoce un error pasado: introducir dispositivos "sin crítica" entre los más pequeños.</li>
<li><strong>Confianza en lo local:</strong> el Estado recomienda y se espera que las escuelas lo sigan, sin imponerlo por ley.</li>
<li><strong>Una política del libro:</strong> precios fijos, lectura y materiales impresos como asunto cultural, no solo pedagógico.</li>
<li><strong>Voz docente que matiza:</strong> el presidente del sindicato Utdanningsforbundet, Geir Røsvoll, apoya tener directrices nacionales, pero dice que quitar el acceso a la IA a todos los estudiantes de primaria "parece muy intrusivo" y que falta debatir cuándo introducirla. Pide una "variedad de materiales", no solo libros impresos, y sostiene que lo que los docentes necesitan es "tiempo para hacer su trabajo".</li>
</ul>

<h2>¿Y la evidencia? Lo que sabemos (y no) sobre la IA y los niños pequeños</h2>
<ul>
<li><strong>Cuando la IA se usa sin guías, puede perjudicar:</strong> en un ensayo con casi mil estudiantes de secundaria en Turquía (Bastani et al., <em>PNAS</em>, 2025), el acceso libre a GPT-4 mejoró el desempeño durante la práctica y empeoró 17 % el examen posterior sin IA; un tutor con salvaguardas mitigó el daño. La OCDE (<em>Digital Education Outlook 2026</em>) advierte que mejorar el rendimiento no es aprender.</li>
<li><strong>Cuando se diseña para enseñar y hay un docente, puede ayudar:</strong> en Harvard (194 estudiantes de física) y en Nigeria (800 estudiantes de secundaria, con docentes mediando) hubo ganancias; en ambos casos con jóvenes mayores de 13 años y en estudios cortos.</li>
<li><strong>Con niños de 6 a 13 años, la evidencia directa es escasa.</strong> No encontré estudios que midan el efecto de la IA generativa en ese grupo de edad. La UNESCO (2023) propone una edad mínima para las conversaciones independientes de estudiantes con IA generativa (se suele citar 13 años), y Common Sense Media calificó en 2025 como "inaceptables" para menores de 18 años los compañeros sociales de IA.</li>
<li><strong>Libros de papel frente a pantallas:</strong> el metaanálisis de Delgado y colegas (2018, <em>Educational Research Review</em>; 54 estudios y 171.055 participantes) encontró una ventaja pequeña de la lectura en papel para la comprensión (g = −0,21), mayor con tiempo limitado y con textos informativos, y no con textos narrativos. Es un efecto modesto, y no es lo mismo que probar que la IA "daña" la lectura.</li>
</ul>
<p><strong>Lectura crítica.</strong> La medida de Noruega es una <strong>apuesta de precaución</strong> razonable: el costo de esperar es bajo si el niño aprende primero a leer, escribir y calcular, y el costo de equivocarse podría ser mayor. Pero no es una conclusión científica cerrada, y tiene un costo: la IA bien usada puede apoyar a estudiantes con necesidades especiales o el aprendizaje de idiomas, y por eso el propio gobierno prevé excepciones. Sirve más como hipótesis que como modelo: <strong>lo valioso sería que Noruega la evalúe</strong>.</p>

<h2>El mito de los países "modelo" en educación</h2>
<p>El caso desmonta dos ideas cómodas. La primera: que los países nórdicos son, por definición, los mejores. En PISA 2025 Noruega está por debajo del promedio de la OCDE en las tres áreas; su sistema destaca por otras cosas (inversión, gestión local, bienestar), no por liderar las pruebas. La segunda: que "lo que hace Noruega" se copia. <strong>Lo que merece copiarse es el método</strong>: actuar con precaución, apoyarse en la evidencia disponible, decir qué se sabe y qué no, escuchar al sindicato y revisar la medida. No el titular. Ya revisé esas ideas en <a href="/finlandia-sistema-educativo-mito-o-realidad/">Finlandia: ¿mito o realidad?</a> y en <a href="/mejores-sistemas-educativos-del-mundo-colombia/">los mejores sistemas educativos del mundo y lo que le falta a Colombia</a>.</p>
<p>Un contrapunto: Suecia, otro país nórdico, anunció en 2023 un giro hacia los libros impresos y menos pantallas en los más pequeños, citando la caída de sus resultados en lectura; el debate es similar (¿es la causa o es una de varias?) y los reportes sobre el respaldo científico dependen de declaraciones de expertos más que de estudios causales.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p><strong>Colombia:</strong> en PISA 2025 obtuvo 381 puntos en matemáticas, 399 en lectura y 414 en ciencias (OCDE: 463, 461 y 482), sin cambios estadísticamente significativos frente a 2022; según la prensa, el 71 % de los estudiantes no alcanzó el nivel mínimo en matemáticas. Mientras Noruega discute si <em>limitar</em> la IA en primaria, los docentes colombianos la usan más que los noruegos (53 % frente a 40 %, TALIS 2024) y reportan falta de infraestructura (76 % entre quienes no la usan). La Ley 2626 de 2026 incorpora la IA como contenido de Tecnología e Informática, pero <strong>no encontré una norma o recomendación nacional sobre el uso de IA por los estudiantes de básica según su edad</strong>; el Decálogo del Ministerio (2026) es para educación superior.</p>
<p><strong>Latinoamérica:</strong> Brasil (56 %), Chile (55 %) y Costa Rica (52 %) usan IA en el aula casi como Colombia. <strong>El mundo:</strong> China (pautas de 2025), Nueva York (moratoria de 2026) y Noruega (recomendación de 2026) van hacia más cautela con los más pequeños; la UNESCO pide edades mínimas y un enfoque centrado en lo humano.</p>
<p>Para los <strong>docentes</strong>, la lección es que una restricción no los exime de formarse: los estudiantes seguirán aprendiendo <em>sobre</em> la IA. Para los <strong>directivos</strong>, que el 75 % de las escuelas noruegas no tenía un plan: el vacío es el riesgo. Para las <strong>familias</strong>, que "la IA" incluye desde un asistente de tareas hasta un compañero de conversación, con riesgos muy distintos. Y para los <strong>estudiantes</strong>, que se les explique el porqué, no solo la norma.</p>

<h2>Qué puede hacer tu colegio, sin esperar una ley</h2>
<p>No se trata de copiar a Noruega, sino de <strong>decidir con criterio</strong>. Una propuesta mía, para ajustar a tu contexto:</p>
<ol>
<li><strong>Define por escrito una escala de uso por edad y por tarea:</strong> en los primeros grados, sin cuentas de IA generativa para estudiantes (el docente la usa para preparar); en grados medios, demostraciones guiadas por el docente; en los últimos, uso gradual con reglas claras y evidencia del proceso (ver la <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">guía del uso de la IA en educación</a>).</li>
<li><strong>Prevé excepciones desde el inicio:</strong> estudiantes con ajustes razonables o con necesidades de apoyo (ver <a href="/herramientas/piar/">PIAR con IA</a>) pueden necesitar herramientas que otros no.</li>
<li><strong>Revisa la privacidad antes del primer uso:</strong> sin datos personales de estudiantes en herramientas que no estén diseñadas para custodiarlos.</li>
<li><strong>Forma primero a los docentes</strong>, como pide Udir para 8.º a 10.º: ninguna regla funciona si quien debe aplicarla no la entiende.</li>
<li><strong>Define cómo medirás si funcionó</strong> (lectura, escritura, cálculo, convivencia) y revisa la decisión en seis meses.</li>
<li><strong>Sigue enseñando <em>sobre</em> IA</strong>: qué es, cómo se equivoca y cómo afecta a las personas, también en los grados donde su uso está restringido.</li>
</ol>

<h2>Herramientas y recursos</h2>
<p>Si quieres explorar la IA como apoyo del docente (planeación, material y evaluación), con revisión humana siempre presente, mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/descargas/noruega-ia/verificador-titular-noruega-ia-escuela.xlsx">el libro verificador del titular</a>, <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">celulares en el colegio: prohibir no basta, hay que enseñar</a>, <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA y América Latina</a>, <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">la IA no te reemplazará, quien la domine, sí</a>, y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (17 de octubre de 2026)</h2>
<ul>
<li><strong>Dirección de Educación de Noruega (Udir),</strong> <a href="https://www.udir.no/kvalitet-og-kompetanse/digitalisering-skole/kunstig-intelligens-i-skolen/kommer-nye-rad-om-bruk-av-kunstig-intelligens-pa-ulike-trinn/">Nye anbefalinger om tilpasset bruk av KI etter trinn og alder</a> (actualizada el 12 de octubre de 2026) y <a href="https://www.udir.no/kvalitet-og-kompetanse/digitalisering-skole/kunstig-intelligens-i-skolen/">Kunstig intelligens i skolen</a>; encuesta "Spørsmål til Skole-Norge" (enero de 2026), según el resumen de <a href="https://www.barnevakten.no/survey-skolenorge-2026/">Barnevakten</a>.</li>
<li><strong>NRK,</strong> <a href="https://www.nrk.no/artikkel/store-vil-ha-ki-ut-av-barneskolen-1189">Støre vil ha KI ut av barneskolen</a> (19 de junio de 2026); Barnevakten, <a href="https://www.barnevakten.no/ki-skal-bort-fra-barneskolene/">KI skal bort fra barneskolene</a> (19 de junio de 2026); <a href="https://www.kiforskolen.no/hva-gjelder-na.html">Kiforskolen</a> (resumen de las fuentes oficiales); comunicado del gobierno (19 de junio de 2026, "Kunstig intelligens skal i all hovedsak ikke brukes i barneskolen"), citado por las anteriores.</li>
<li><strong>Utdanningsforbundet,</strong> <a href="https://www.utdanningsforbundet.no/nyheter/2026/-skraper-kun-overflaten-av-problemene">Røsvoll: "Skraper kun overflaten av problemene"</a> (2026).</li>
<li><strong>OCDE,</strong> PISA 2022, nota de país de Noruega; <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2026/09/pisa-2025-results-volume-i_5265bfb1/73451bc5-en.pdf">PISA 2025, Volumen I</a> (septiembre de 2026) y perfil Education GPS de Noruega; TALIS 2024, nota de país de Noruega; <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2025/10/results-from-talis-2024-country-notes_eafd703e/colombia_04c7b413/8f1df220-en.pdf">TALIS 2024: Colombia</a>; <a href="https://digital-skills-jobs.europa.eu/en/latest/news/oecd-digital-education-outlook-2026-how-generative-ai-can-support-learning-when-used">Digital Education Outlook 2026</a>.</li>
<li><strong>Eurydice,</strong> sistema educativo de Noruega; regjeringen.no (<a href="https://www.regjeringen.no/en/aktuelt/norway-moves-forward-with-age-limit-for-social-media/id3108682">límite de edad en redes sociales</a>, 2025); Ley del Libro de Noruega (en vigor desde el 1 de enero de 2024), según el resumen del NHH y The Local.</li>
<li><strong>China:</strong> <a href="https://mobile.chinadaily.com.cn/html5/2025-05/16/content_005_682652a6ed50ccabe1512244.htm">China Daily</a> (16 de mayo de 2025) sobre las pautas del Ministerio de Educación; <strong>Nueva York:</strong> <a href="https://ny1.com/nyc/all-boroughs/news/2026/09/02/new-york-city-bans-ai-use-in-schools-through-eighth-grade">NY1</a> (2 de septiembre de 2026); <strong>UNESCO,</strong> <a href="https://www.unesco.org/en/articles/guidance-generative-ai-education-and-research">Guidance for generative AI in education and research</a> (2023); <strong>Common Sense Media</strong> (abril de 2025).</li>
<li><strong>Bastani et al. (2025),</strong> <a href="https://www.pnas.org/doi/10.1073/pnas.2422633122">PNAS</a>; <strong>Delgado et al. (2018),</strong> "Don't throw away your printed books", <em>Educational Research Review</em> 25; resultados de Colombia en PISA 2025, según <a href="https://www.larepublica.co/globoeconomia/colombia-sigue-rezagada-en-matematicas-y-lectura-de-acuerdo-con-pruebas-pisa-2025-4476792">La República</a> y <a href="https://cambiocolombia.com/pais/articulo/2026/9/colombia-sigue-rezagada-en-las-pruebas-pisa-2025-mientras-la-caida-educativa-tambien-golpea-a-varios-paises">Cambio</a>; Ley 2626 de 2026; Infobae (20 de junio de 2026), origen del titular viral.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Noruega prohibió la IA a los niños de 6 a 13 años?</h3>
<p>No como ley. El gobierno y la Dirección de Educación recomiendan que, en 1.º a 7.º grado, los estudiantes en lo esencial no tengan acceso a IA generativa, con excepciones, y se espera que las escuelas lo cumplan.</p>
<h3>¿Es Noruega el primer país en hacerlo?</h3>
<p>No pude confirmarlo. China publicó en 2025 pautas que restringen el uso autónomo de IA generativa por estudiantes de primaria, según China Daily, y Nueva York decretó en 2026 una moratoria hasta 8.º grado.</p>
<h3>¿Noruega volvió a los libros de papel?</h3>
<p>Anunció una propuesta de ley para garantizar el acceso a materiales impresos en la escuela básica. Es una propuesta; el sindicato docente pide mantener una variedad de materiales, impresos y digitales.</p>
<h3>¿Tiene Noruega una educación de calidad?</h3>
<p>Invierte mucho y su sistema tiene fortalezas, pero en PISA 2025 está por debajo del promedio de la OCDE en matemáticas (452), lectura (453) y ciencias (470). Por eso se habla del "mito" de los países modelo.</p>
<h3>¿Cómo uso el libro de Excel?</h3>
<p>Cambia el respaldo (0 a 100), el nivel de fuente y el peso de cada afirmación y los umbrales de la hoja Parametros; el libro calcula el veredicto de cada una y una lectura global del titular. Úsalo con otros titulares virales.</p>

<p class="notice"><strong>Verifica antes de compartir.</strong> Descarga el <a href="/descargas/noruega-ia/verificador-titular-noruega-ia-escuela.xlsx">libro verificador</a>, cambia las afirmaciones por las de otro titular y comparte lo que sí es cierto.</p>

<h2>Para pensar</h2>
<p>Un titular rotundo suele ocultar una decisión más matizada, y una decisión matizada puede ser más útil que una prohibición. <strong>Si tu colegio tuviera que escribir hoy su propia regla sobre la IA para los estudiantes más pequeños, ¿qué incluiría, qué excepciones preverías y qué evidencia revisarías en seis meses para saber si fue una buena decisión?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:etapas}}' => $img('noruega-ia-etapas', 467, 'Cuatro etapas de la recomendación de Noruega: 1.º a 7.º sin acceso a IA generativa en lo esencial, 8.º a 10.º uso gradual y cuidadoso, secundaria superior aprender a usarla con propósito y en todas las etapas se aprende sobre IA con excepciones por necesidad.', 'La recomendación de Noruega por etapa.'),
    '{{img:afirmaciones}}' => $img('noruega-ia-afirmaciones', 608, 'Tabla con seis afirmaciones del titular y su veredicto: prohíbe la IA a niños (parcial, recomendación y no ley), primer país (sin respaldo), de 6 a 13 años (confirmada), vuelven los libros (parcial), leer y escribir primero (confirmada) y sin reemplazar lo humano (parcial).', 'Dos confirmadas, tres a medias y una sin respaldo.'),
    '{{img:udir}}' => $img('noruega-ia-udir', 573, 'Cuatro datos de Noruega antes de la medida: 8 de cada 10 escuelas ya usaban IA, sin edad mínima nacional, 75 % de las escuelas sin plan y 40 % de los docentes que usó IA frente a 36 % del promedio de la OCDE.', 'Ocho de cada diez escuelas ya usaban IA, sin regla nacional.'),
    '{{img:pisa}}' => $img('noruega-ia-pisa', 524, 'Gráfico de barras de PISA 2025: Noruega 452 en matemáticas frente a 463 de la OCDE, 453 en lectura frente a 461 y 470 en ciencias frente a 482.', 'PISA 2025: Noruega frente al promedio de la OCDE.'),
]);

return [
    'slug' => 'noruega-prohibe-ia-ninos-6-13-anos-libros-de-papel-verdad-o-mito',
    'title' => 'Noruega y la IA en la escuela: ¿prohibió de verdad la inteligencia artificial a niños de 6 a 13 años? Qué es cierto y qué no',
    'excerpt' => 'Verificamos el titular viral: qué dijo el gobierno noruego (una recomendación, no una ley), cómo está la calidad de su educación (PISA 2025), sus leyes, su cultura y qué puede aprender Colombia del mito de los países modelo.',
    'seo_title' => 'Noruega prohíbe la IA a niños de 6 a 13 años: ¿es cierto?',
    'seo_description' => 'Verificamos si Noruega prohibió la IA a niños de 6 a 13 años y volvió a los libros: qué es una recomendación, su calidad educativa y leyes.',
    'focus_keyword' => 'Noruega prohíbe la IA a niños',
    'cover' => '/assets/img/articulos/noruega-ia/noruega-ia-portada',
    'cover_alt' => 'Portada "Noruega y la IA en la escuela: ¿prohibió de verdad a los niños?" con una tarjeta de verificación: no es una ley, es una recomendación nacional, cubre de 6 a 13 años, no se confirma que sea el primer país y no hay estudios con esos niños.',
    'published_at' => '2026-10-17 15:25:00',
    'content_html' => $html,
];
