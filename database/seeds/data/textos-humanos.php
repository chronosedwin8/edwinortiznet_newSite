<?php

declare(strict_types=1);

// "Cuando todos los textos sean iguales, lo humano se cotizará al alza": ¿qué tan cierta? Fuentes (10-oct-2026): Doshi y Hauser, Sci. Adv. 2024 (n=293, cuentos de 8 frases; más creativos y más parecidos); Shumailov et al., Nature 631 (2024); Jakesch, Hancock, Naaman, PNAS 2023 (acierto 50-52 %); Bellaiche et al. 2023; Schilke y Reimann 2025 (vía coberturas); Hui, Reshef, Zhou, Organization Science 2024 (DOI 10.1287/orsc.2023.18441: caen empleo e ingresos; sin cifras citadas); Cui, Dias, Ye arXiv 2509.25054 (-51 % correlación; señales hacia historial); Authors Guild Human Authored. Libro verificado en Excel 16 y Python: 5 partes, confianzas 60/80/65/25/40, pesos 1/1/1/2/1: promedio ponderado 49,2 %, conjunta 3,1 %, nivel de evidencia medio 2,4. Script verificado con una segunda implementación: A 0,015/0,976/1; B 0,636/0,292/29. Confianzas = juicio propio; textos de ejemplo ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/textos-humanos/' . $name;
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
<p>La frase circula en conferencias, hilos y charlas de pasillo y suena a consuelo para quien escribe: <em>"cuando todos los textos sean iguales, los escritos por humanos volverán a cotizarse al alza"</em>. Tiene la forma de una profecía tranquilizadora: la máquina inunda el mundo de texto correcto y gris, y lo auténtico, por escaso, vale más. Tiene algo de verdad, y también varios supuestos escondidos. <strong>¿Qué tan cierta es?</strong></p>
<p>En lugar de responder "sí" o "no", este artículo hace lo que conviene hacer con cualquier afirmación sonora: <strong>descomponerla en partes comprobables</strong>, buscar la mejor evidencia disponible para cada una, decir con qué nivel de confianza y dónde está lo que no sabemos. Incluye un <a href="/descargas/textos-iguales/evaluacion-afirmacion-textos-humanos.xlsx">libro de Excel</a> con la descomposición (cinco partes, con mis niveles de confianza editables) y un <a href="/descargas/textos-iguales/medidor_homogeneidad.py">script en Python</a> que mide qué tan parecidos son entre sí los textos de un grupo, con datos de ejemplo ficticios. El libro lo verifiqué en Microsoft Excel 16 y contra un cálculo independiente; el script, contra una segunda implementación escrita aparte. Fuentes revisadas el <strong>10 de octubre de 2026</strong>.</p>
<p class="notice"><strong>Advertencia.</strong> Las confianzas del libro son <strong>mi juicio</strong> sobre la evidencia citada, no datos publicados, y están ahí para que las cambies. Los estudios son concretos (tareas, poblaciones y plataformas específicas) y los resultados pueden no extrapolarse. Los textos de ejemplo del script son ficticios.</p>

<h2>La afirmación, descompuesta</h2>
{{img:partes}}
<p>Para que la frase sea verdadera tienen que cumplirse, <em>a la vez</em>, cinco cosas: <strong>P1)</strong> los textos de IA tenderán a parecerse entre sí; <strong>P2)</strong> los lectores no podrán distinguirlos de los humanos; <strong>P3)</strong> la gente valorará más lo que sabe que es humano; <strong>P4)</strong> ese valor se traducirá en precios más altos; y <strong>P5)</strong> pasará lo que el verbo "volverán" sugiere, que hay un precedente. Una cadena de supuestos es tan fuerte como su eslabón más débil. Veamos cada uno.</p>

<h2>P1. ¿Los textos de IA se parecen entre sí?</h2>
<p><strong>Parcialmente cierta (confianza 60 %).</strong> En un experimento publicado en <em>Science Advances</em> en 2024, Anil Doshi y Oliver Hauser pidieron a 293 escritores no profesionales que escribieran un cuento de ocho frases, con o sin ideas generadas por un modelo de lenguaje. Los cuentos con ideas de IA fueron evaluados como <strong>más creativos, mejor escritos y más agradables</strong>, sobre todo entre los escritores menos creativos, pero <strong>se parecían más entre sí</strong> que los escritos sin ayuda: ganancia individual, pérdida de diversidad colectiva. Los autores lo describen como un dilema social.</p>
<p>Otro resultado va en la misma dirección desde otra perspectiva: en un artículo de <em>Nature</em> (2024), Ilia Shumailov y colaboradores mostraron que los modelos entrenados de forma recursiva con datos generados por otros modelos <strong>pierden las "colas" de la distribución</strong> (lo raro, lo minoritario) y colapsan hacia resultados más uniformes. Eso no dice que todo texto de IA sea igual, sino que, <em>si la red se llena de texto sintético y los modelos se entrenan con él</em>, la diversidad se erosiona.</p>
<p>Los límites: el experimento usó textos cortos de escritores aficionados y ideas sin edición posterior; un texto con instrucciones específicas, estilo propio y revisión humana puede ser muy distinto. "Todos iguales" es una exageración; <strong>"los textos por defecto tienden a converger"</strong> es lo defendible. Puedes comprobarlo en tu aula con el script (ver abajo).</p>

<h2>P2. ¿Los lectores no distinguen un texto humano de uno de IA?</h2>
<p><strong>Probable (80 %), con matices.</strong> Maurice Jakesch, Jeffrey Hancock y Mor Naaman (<em>PNAS</em>, 2023) pusieron a leer autopresentaciones (como las de un perfil de citas o de una plataforma de empleo), humanas y generadas por IA: el acierto de los lectores fue de apenas <strong>50 a 52 %</strong>, es decir, casi azar. Y no era azar puro: muchos usaban las mismas pistas (pronombres en primera persona, contracciones, temas familiares), que resultaron erróneas, de modo que la IA podía producir textos que se percibían "más humanos que los humanos". En el mismo sentido, los detectores automáticos no son una solución confiable (ver <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a>).</p>
<p>Los límites: son textos cortos y de un género concreto; un lector experto, un texto largo o el conocimiento del autor cambian el panorama. Pero la conclusión útil es otra: <strong>si el texto ya no prueba su origen, el valor se desplaza a lo que sí lo prueba</strong> (identidad, trayectoria, proceso, reputación, evidencia).</p>

<h2>P3. ¿La gente valora más lo que sabe que es humano?</h2>
<p><strong>Parcialmente cierta (65 %).</strong> Hay evidencia de un sesgo a favor de lo humano <em>cuando se informa el origen</em>. Bellaiche y colaboradores (<em>Cognitive Research: Principles and Implications</em>, 2023) dieron a distintos participantes las mismas obras con etiqueta "creada por una persona" o "creada por IA": las etiquetadas como humanas recibieron valoraciones más positivas, y los autores identifican el relato y el esfuerzo percibido como parte del mecanismo. En el terreno de la comunicación, el estudio de Schilke y Reimann sobre "el dilema de la transparencia" (<em>Organizational Behavior and Human Decision Processes</em>, 2025) encontró que declarar el uso de IA reduce la confianza en quien lo declara (resumo según coberturas del trabajo; no leí el artículo completo).</p>
<p>Los límites: es un sesgo condicionado a la etiqueta, y varía por tipo de texto. Para un manual de instrucciones, un correo de rutina o un resumen de reunión, a casi nadie le importa quién lo escribió; para una memoria, una columna de opinión, un consejo médico o una carta de recomendación, mucho. Es un valor <strong>de nicho</strong>, no general.</p>

<h2>P4. ¿Ese valor se traduce en precios más altos?</h2>
<p><strong>Poco respaldada (25 %), y es la parte decisiva.</strong> Lo que sí se observa hasta ahora va en sentido contrario para el texto de uso corriente. Xiang Hui, Oren Reshef y Luofeng Zhou (<em>Organization Science</em>, 2024) estudiaron una gran plataforma de trabajo independiente después de la aparición de ChatGPT: los freelancers en ocupaciones muy expuestas (como la escritura) sufrieron <strong>reducciones en empleo e ingresos</strong>, y no encontraron que una mayor calidad previa los protegiera; incluso sugieren que los mejores se vieron proporcionalmente más afectados. Es un estudio de corto plazo en una plataforma, pero apunta en la dirección opuesta a "se cotiza al alza" para el texto como servicio.</p>
<p>Un segundo estudio, de Jingyi Cui, Gabriel Dias y Justin Ye (documento de trabajo de 2025, sin revisión por pares), muestra el mecanismo que sí parece funcionar: al introducirse una herramienta de IA para escribir cartas de presentación en una plataforma de empleo, la correlación entre la "calidad" de la carta y la probabilidad de ser contactado <strong>cayó 51 %</strong>, y los empleadores pasaron a fijarse más en señales difíciles de fabricar, como el <strong>historial de trabajos previos</strong>. Es decir: cuando el texto es barato, <strong>el valor se mueve a lo verificable</strong>.</p>
<p>Y hay una respuesta del mercado en forma de señal: el Gremio de Autores de Estados Unidos lanzó a comienzos de 2025 un sello de "Autoría humana" (<em>Human Authored</em>) para libros, con una base de datos pública de verificación, y lo extendió después a todos los autores publicados en ese país. Es un indicio de que el origen humano se está empezando a certificar, no de que se pague más por él: no encontré datos de precios.</p>

<h2>P5. ¿"Volverán"? La analogía histórica</h2>
<p><strong>Parcialmente cierta (40 %), pero es analogía, no evidencia.</strong> Es verdad que otros bienes industrializados (la cerámica, el pan, los muebles, la música grabada) dejaron un mercado de objetos "hechos a mano" o de presentaciones en vivo con precios altos. Pero ese precedente se parece más a un <strong>nicho de lujo</strong> que a una vuelta general al alza, y en ese mercado la mayoría del consumo se mudó a lo producido en serie. Aplicado al texto, sugiere un resultado en dos velocidades: el texto genérico, abaratado hasta casi cero; y un segmento reducido donde importan la autoría, la voz y la responsabilidad.</p>

<h2>El veredicto: una versión más estrecha, y más útil</h2>
<p>Con mis confianzas (editables en el libro), el <strong>promedio ponderado</strong> (la parte del precio pesa doble) es de <strong>49 %</strong>, es decir, <strong>parcialmente cierta</strong>; y si las cinco partes fueran independientes, la <strong>probabilidad conjunta</strong> de que todas se cumplan sería de apenas <strong>3 %</strong>. No hay que tomar ese 3 % al pie de la letra (las partes están relacionadas y las cifras son subjetivas), pero ilustra una regla: <strong>una afirmación que encadena cinco supuestos es mucho menos probable que cada uno por separado</strong>. De las cinco partes, una es "probable" (P2), tres "parcialmente ciertas" y una "poco respaldada" (P4). El nivel de evidencia medio es 2,4 de 5.</p>
{{img:confianza}}
<pre><code>' Confianza media ponderada (confianza en E, peso en F)
=SUMAPRODUCTO(Partes!E4:E8;Partes!F4:F8)/SUMA(Partes!F4:F8)         ' español
=SUMPRODUCT(Partes!E4:E8,Partes!F4:F8)/SUM(Partes!F4:F8)             ' inglés

' Probabilidad conjunta si las partes fueran independientes (en %)
=PRODUCTO(Partes!E4:E8)/100^CONTAR(Partes!E4:E8)*100                ' español
=PRODUCT(Partes!E4:E8)/100^COUNT(Partes!E4:E8)*100                  ' inglés

' Lectura según los cortes de la hoja Parametros
=SI(B4>=Parametros!B3;"Probable";SI(B4>=Parametros!B4;"Parcialmente cierta";"Poco respaldada"))   ' español
=IF(B4>=Parametros!B3,"Probable",IF(B4>=Parametros!B4,"Parcialmente cierta","Poco respaldada"))   ' inglés</code></pre>
<p>Y la versión que sí se sostiene es más modesta: <strong>cuando el texto genérico sea abundante, lo que se valorará no es "el texto humano" sino lo que sea verificablemente humano, responsable y con voz o experiencia propias.</strong> Eso incluye la firma que responde por lo que dice (periodismo, peritaje, consejo profesional), la experiencia de primera mano (memoria, testimonio, investigación original), el criterio que selecciona y la relación con un lector concreto. Quien escribe texto de relleno, de bajo riesgo y sin voz tiene motivos para preocuparse; quien aporta algo que una máquina no puede dar (haber estado allí, responder con su nombre, saber algo que no está en la red) tiene motivos para seguir. Un matiz más: la erosión de la diversidad que describe el colapso de modelos puede aumentar el valor de los datos humanos <em>para quienes entrenan modelos</em> (se han anunciado acuerdos de licencia entre empresas de IA y editoriales; no verifiqué sus términos), lo que no es lo mismo que el valor para el lector.</p>

<h2>Mide la homogeneidad de tus propios textos</h2>
<p>El <a href="/descargas/textos-iguales/medidor_homogeneidad.py">script <code>medidor_homogeneidad.py</code></a> (Python estándar, sin instalar nada) calcula, para un grupo de textos, tres indicadores: la <strong>similitud media</strong> (promedio, sobre todos los pares, del índice de Jaccard de las palabras que no son vacías), la <strong>diversidad de bigramas</strong> (bigramas distintos sobre bigramas totales) y los <strong>bigramas compartidos</strong> (los que aparecen en la mitad o más de los textos). Sin argumentos, corre con dos grupos de ejemplo <em>ficticios</em> de ocho textos: uno escrito con variedad y otro con la misma plantilla. Con carpetas de archivos .txt, mide los tuyos.</p>
<pre><code>python medidor_homogeneidad.py                       # ejemplo con datos ficticios
python medidor_homogeneidad.py respuestas_curso      # tus textos (un .txt por estudiante)

Grupo A (escritos con variedad, ficticio): 8 textos | similitud media 0.015 | diversidad de bigramas 0.976 | bigramas compartidos 1
Grupo B (misma plantilla, ficticio): 8 textos | similitud media 0.636 | diversidad de bigramas 0.292 | bigramas compartidos 29</code></pre>
{{img:script}}
<p>En el ejemplo, los ocho textos de plantilla comparten el 64 % de sus palabras (en promedio, por pares) y tienen 29 bigramas compartidos, frente al 1,5 % y a 1 de los textos con variedad. <strong>Una lectura honesta:</strong> es una medida simple, no un detector de IA; un grupo con instrucciones muy cerradas tendrá textos parecidos aunque cada persona los haya escrito, y un texto de IA con buen <em>prompt</em> puede ser distinto. Úsala para conversar con tus estudiantes sobre voz, variedad y originalidad, no para acusar a nadie. No pegues textos con datos personales de estudiantes en herramientas externas.</p>

<h2>Qué significa para quien enseña y aprende a escribir</h2>
<ul>
<li><strong>Para los docentes:</strong> si el texto genérico ya no prueba nada, evalúa el <strong>proceso</strong> (borradores, bitácora, conversación sobre lo escrito) y la <strong>voz</strong> (especificidad, experiencia propia, posición argumentada), no solo el producto (ver <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a> y <a href="/actividades-con-ia-taxonomia-de-bloom-banco-36-actividades-prompts-planificador-excel/">las actividades con IA por nivel de Bloom</a>).</li>
<li><strong>Para los estudiantes:</strong> lo que vale la pena entrenar es lo que una máquina no puede dar por ti: mirar de cerca, tener algo que decir, citar de verdad y responder con tu nombre. Escribir bien sigue siendo una forma de pensar bien.</li>
<li><strong>Para los directivos:</strong> acordar reglas de declaración de uso de IA y de evidencia del proceso, y no basar sanciones en detectores.</li>
<li><strong>Para las familias:</strong> el mensaje no es "escribir ya no sirve", sino "escribir con criterio es lo que no se delega".</li>
</ul>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La evidencia de este artículo viene sobre todo de estudios en inglés y de plataformas globales; el mercado del español tiene particularidades (una enorme cantidad de contenido de bajo costo, traducción y redacción para marketing, exposición alta de freelancers de la región) que merecen estudios propios, y aún no conozco cifras locales robustas sobre precios de texto humano frente a texto de IA. Un indicio para vigilar es el de las señales de origen: sellos como el de <em>Human Authored</em> se aplican por ahora a libros en Estados Unidos. En América Latina y en Colombia, las diferencias de acceso a la IA y al idioma pueden acentuar la brecha entre quien usa la herramienta con criterio y quien depende de ella. Es la misma discusión de fondo de <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">la gran mentira de la IA</a> y de <a href="/las-matematicas-estan-a-punto-de-morir-openai-372-resultados-verificacion-lean/">¿mueren las matemáticas?</a>: cuando producir es barato, lo escaso es entender y responder por lo producido.</p>

<h2>Herramientas y plantillas</h2>
<p>Para trabajar la escritura propia, la retroalimentación y la evaluación del proceso, con la IA como asistente (revisando siempre lo que produce y sin incluir datos de estudiantes en herramientas que no estén diseñadas para custodiarlos), mira estas herramientas propias.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Sigue leyendo: <a href="/descargas/textos-iguales/evaluacion-afirmacion-textos-humanos.xlsx">el libro de la afirmación descompuesta</a>, <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">la guía del uso de la IA en educación</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Fuentes consultadas (10 de octubre de 2026)</h2>
<ul>
<li><strong>Doshi y Hauser (2024),</strong> "Generative AI enhances individual creativity but reduces the collective diversity of novel content", <em>Science Advances</em> 10(28), eadn5290.</li>
<li><strong>Shumailov, Shumaylov, Zhao, Papernot et al. (2024),</strong> "AI models collapse when trained on recursively generated data", <em>Nature</em> 631, 755-759.</li>
<li><strong>Jakesch, Hancock y Naaman (2023),</strong> "Human heuristics for AI-generated language are flawed", <em>PNAS</em> 120(11); <strong>Liang et al. (2023),</strong> "GPT detectors are biased against non-native English writers", <em>Patterns</em>.</li>
<li><strong>Bellaiche, Shahi, Turpin, Ragnhildstveit et al. (2023),</strong> "Humans versus AI: whether and why we prefer human-created compared to AI-created artwork", <em>Cognitive Research: Principles and Implications</em> 8; <strong>Schilke y Reimann (2025),</strong> "The transparency dilemma: How AI disclosure erodes trust", <em>Organizational Behavior and Human Decision Processes</em> (según coberturas; no leí el texto completo).</li>
<li><strong>Hui, Reshef y Zhou (2024),</strong> "The short-term effects of generative artificial intelligence on employment: Evidence from an online labor market", <em>Organization Science</em> (DOI 10.1287/orsc.2023.18441); <strong>Cui, Dias y Ye (2025),</strong> estudio sobre IA y señales en cartas de presentación, <a href="https://arxiv.org/abs/2509.25054">arXiv:2509.25054</a> (documento de trabajo).</li>
<li><strong>Gremio de Autores,</strong> <a href="https://authorsguild.org/news/ag-launches-human-authored-certification/">lanzamiento de la certificación "Human Authored"</a>.</li>
</ul>

<h2>Preguntas frecuentes</h2>
<h3>¿Es cierto que los textos de IA serán todos iguales?</h3>
<p>Los textos "por defecto" tienden a converger, según un experimento con 293 escritores; con instrucciones específicas y edición humana pueden ser muy distintos. "Todos iguales" es una exageración.</p>
<h3>¿Podemos distinguir un texto humano de uno de IA?</h3>
<p>En textos cortos y en un estudio de 2023, los lectores acertaron entre 50 % y 52 %, casi como al azar; los detectores automáticos tampoco son confiables.</p>
<h3>¿Se pagará más por lo escrito por humanos?</h3>
<p>No hay datos que lo muestren; los estudios de mercado disponibles muestran caídas de empleo e ingresos en ocupaciones expuestas. Es más plausible un premio para lo verificablemente humano y con voz propia, en nichos.</p>
<h3>¿Qué hace valioso un texto en la era de la IA?</h3>
<p>La autoría responsable, la experiencia de primera mano, el criterio de selección y la confianza de un lector concreto, más que la corrección del texto.</p>
<h3>¿Cómo uso el script?</h3>
<p>Ejecuta <code>python medidor_homogeneidad.py</code> para ver el ejemplo, o pásale una carpeta con un .txt por texto para medir los tuyos.</p>

<p class="notice"><strong>Comprueba tus propias afirmaciones.</strong> Descarga el <a href="/descargas/textos-iguales/evaluacion-afirmacion-textos-humanos.xlsx">libro</a>, cambia tus confianzas en cada parte y mira cómo cambia la conclusión; y mide los textos de tu curso con el <a href="/descargas/textos-iguales/medidor_homogeneidad.py">script</a>.</p>

<h2>Para pensar</h2>
<p>Una máquina puede escribir un texto correcto sobre cualquier tema, pero no puede haber estado donde estuviste tú ni responder con su nombre por lo que dice. <strong>¿Qué sabes tú, de primera mano, que no está en ninguna red ni en ningún modelo? Y si todo lo demás se volviera abundante, ¿cómo harías para que quien te lee sepa que detrás de ese texto hay alguien que lo vivió, lo pensó y responde por él?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:partes}}' => $img('textos-humanos-partes', 553, 'Tabla con las cinco partes de la afirmación, la evidencia más sólida de cada una y su respaldo: los textos se parecen, no se distinguen, se valora lo humano, se paga más y vuelve a ocurrir.', 'Cada parte tiene su propia evidencia.'),
    '{{img:confianza}}' => $img('textos-humanos-confianza', 480, 'Gráfico de barras con la confianza en cada parte de la afirmación: los textos se parecen 60, no se distinguen 80, se valora lo humano 65, se paga más 25 y vuelve a ocurrir 40.', 'La parte del precio es la más débil.'),
    '{{img:script}}' => $img('textos-humanos-script', 348, 'Gráfico de barras con la diversidad de bigramas de dos grupos ficticios de ocho textos: 98 % para los escritos con variedad y 29 % para los escritos con la misma plantilla.', 'Ocho textos con plantilla se parecen mucho.'),
]);

return [
    'slug' => 'cuando-todos-los-textos-sean-iguales-lo-humano-se-cotizara-al-alza-que-tan-cierto-es',
    'title' => '"Cuando todos los textos sean iguales, los escritos por humanos volverán a cotizarse al alza": ¿qué tan cierta es esta afirmación?',
    'excerpt' => 'Una afirmación popular sobre IA y escritura, descompuesta en cinco partes con la mejor evidencia disponible: homogeneidad, indistinguibilidad, preferencia por lo humano, precios y precedentes; con un libro de Excel y un script para medir la homogeneidad de textos.',
    'seo_title' => '¿Valdrán más los textos humanos? Qué dice la evidencia',
    'seo_description' => '¿Se pagará más por lo escrito por humanos? Analizamos la afirmación en cinco partes, con evidencia, un libro de Excel y un script en Python.',
    'focus_keyword' => 'textos escritos por humanos y IA',
    'cover' => '/assets/img/articulos/textos-humanos/textos-humanos-portada',
    'cover_alt' => 'Portada "Cuando todos los textos sean iguales, lo humano se cotizará al alza: ¿es cierto?" con una tarjeta: 50 a 52 % de acierto de los lectores al distinguir autopresentaciones humanas y de IA (PNAS, 2023).',
    'published_at' => '2027-03-11 12:00:00',
    'content_html' => $html,
];
