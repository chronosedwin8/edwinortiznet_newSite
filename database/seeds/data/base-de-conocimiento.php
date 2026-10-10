<?php

declare(strict_types=1);

// "Base de conocimiento institucional". Marco propio inspirado en gestión del conocimiento en servicios de TI (ITIL, KCS; referencia general). Libro verificado en Excel 16 y Python: 12 artículos (6 vigentes, 2 por vencer, 3 vencidos, 1 sin responsable) a fecha 1-feb-2027; 10 preguntas, 382 tickets: 43 sin artículo, 138 con artículo vencido o sin responsable, 201 con respuesta vigente o por vencer; 47,4 % sin respuesta confiable. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/base-de-conocimiento/' . $name;
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
<p>Un docente nuevo pregunta por tercera vez en la semana cómo se suben las notas. La coordinadora le responde de memoria, otra vez. En el colegio existe un documento con los pasos, pero está en la carpeta de un correo viejo, tiene capturas de la versión anterior de la plataforma y nadie sabe quién debería actualizarlo. La respuesta <strong>existe</strong>, pero no está <strong>disponible, vigente ni a cargo de nadie</strong>. En la práctica, es como si no existiera, y el conocimiento sigue viviendo en la cabeza de tres personas.</p>
<p>Este artículo propone una <strong>base de conocimiento institucional</strong> sencilla: un conjunto de artículos cortos para las preguntas que más se repiten, cada uno con responsable y fecha de revisión, y un modo de medir si de verdad cubren lo que la gente pregunta. Incluye un <a href="/descargas/base-de-conocimiento/base-de-conocimiento-colegio.xlsx">libro de Excel</a> con doce artículos y diez preguntas frecuentes ficticias, verificado en Microsoft Excel 16 y contra un cálculo independiente.</p>
<p class="notice"><strong>Alcance.</strong> Es un marco básico, inspirado en prácticas de gestión del conocimiento en servicios de TI (como ITIL y la metodología KCS, citadas como referencia general, sin pretender reproducirlas). Los datos son ficticios; los plazos de revisión y los umbrales son ejemplos que debes ajustar. No incluyas en la base contraseñas, datos personales de estudiantes ni información confidencial.</p>

<h2>Por qué se pierde el conocimiento</h2>
<p>En un colegio, el conocimiento operativo (cómo se carga una nota, cómo se reserva una sala, a quién se llama cuando falla el internet) suele estar repartido en tres lugares: la memoria de las personas, documentos sueltos y mensajes de chat. Eso falla de tres maneras:</p>
<ul>
<li><strong>Depende de quién esté.</strong> Cuando la persona que sabe se enferma, se va o cambia de cargo, el conocimiento sale con ella (el llamado "factor bus").</li>
<li><strong>Se desactualiza en silencio.</strong> Cambia la plataforma, cambia el formulario, y el documento sigue diciendo lo de antes. Un paso falso cuesta más que no tener instrucciones, porque la persona confía en él.</li>
<li><strong>Genera tickets repetidos.</strong> Cada pregunta que ya tiene respuesta escrita pero nadie encuentra vuelve a la mesa de ayuda (ver <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">la mesa de ayuda sin software costoso</a>).</li>
</ul>

{{img:condiciones}}
<h2>Qué hace confiable a un artículo</h2>
<ol>
<li><strong>Un responsable.</strong> Una persona o un área a la que se le puede pedir que lo actualice. Sin responsable, un artículo es huérfano y se pudre.</li>
<li><strong>Fechas de revisión.</strong> La última revisión y la frecuencia con la que debe revisarse (los procesos que cambian con frecuencia, como una plataforma, requieren revisiones más cortas que un procedimiento estable).</li>
<li><strong>Pasos probados.</strong> Alguien distinto del autor los siguió y funcionaron, con capturas de la versión actual.</li>
<li><strong>Un enlace desde donde se pregunta.</strong> La mesa de ayuda responde con el enlace al artículo, y las preguntas que se repiten se convierten en artículos nuevos.</li>
</ol>
<p>Un artículo corto, con responsable y fecha, vale más que un manual de cien páginas que nadie lee. Para cada uno basta una estructura sencilla: <em>qué problema resuelve, para quién, pasos numerados, qué hacer si no funciona y a quién escribir</em>.</p>

<h2>El libro de Excel</h2>
<ul>
<li><strong>Parametros:</strong> la fecha de revisión (escribe la de hoy; se usa una celda y no <code>HOY()</code> para que el resultado sea reproducible) y los días de anticipación para marcar "Por vencer".</li>
<li><strong>Articulos:</strong> doce artículos con su categoría, responsable, última revisión y cada cuántos días debe revisarse. Calcula la próxima revisión, los días que faltan y el estado: <em>Vigente</em>, <em>Por vencer</em>, <em>Vencido</em> o <em>Sin responsable</em>.</li>
<li><strong>Preguntas:</strong> las diez preguntas más frecuentes de la mesa de ayuda en un trimestre, con el número de tickets y el artículo que las responde (si existe). La columna de estado dice si la respuesta es confiable.</li>
<li><strong>Resumen:</strong> los conteos clave.</li>
</ul>
<pre><code>' Estado de un artículo (responsable en D, días para vencer en H, anticipación en Parametros!B4)
=SI(D2="";"Sin responsable";SI(H2<0;"Vencido";SI(H2<=Parametros!$B$4;"Por vencer";"Vigente")))   ' español
=IF(D2="","Sin responsable",IF(H2<0,"Vencido",IF(H2<=Parametros!$B$4,"Por vencer","Vigente")))     ' inglés

' Estado de la respuesta a una pregunta frecuente (ID del artículo en D)
=SI(D2="";"Sin artículo";BUSCARV(D2;Articulos!$A$2:$I$13;9;FALSO))                                 ' español
=IF(D2="","Sin artículo",VLOOKUP(D2,Articulos!$A$2:$I$13,9,FALSE))                                  ' inglés

' Tickets sin una respuesta confiable (sin artículo, vencido o sin responsable)
=SUMAR.SI(Preguntas!E2:E11;"Sin artículo";Preguntas!C2:C11)                                         ' español</code></pre>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
{{img:estado}}
<p>Con una fecha de revisión del 1 de febrero de 2027:</p>
<ul>
<li><strong>De 12 artículos: 6 vigentes, 2 por vencer, 3 vencidos y 1 sin responsable.</strong> El de la contraseña (vigente) se revisó hace 83 días y debe revisarse cada 180; el del Wi-Fi está vencido desde hace 156 días (se revisó en marzo de 2026 y se debía revisar cada 180); el de crear un aula virtual no tiene responsable.</li>
<li><strong>De las diez preguntas más frecuentes (382 tickets en el trimestre):</strong> 201 tickets (52,6 %) tienen una respuesta vigente o por vencer; 138 (36,1 %) apuntan a un artículo vencido o sin responsable, y 43 (11,3 %) no tienen artículo. <strong>En total, 47,4 % de los tickets frecuentes no tiene una respuesta confiable.</strong></li>
<li>La lectura útil no es "hay tres artículos vencidos" sino <strong>cuáles</strong>: los dos más caros son el del Wi-Fi (64 tickets) y el del aula virtual sin responsable (41 tickets), y tienen mucho más impacto que el del proyector (vencido, pero pocas consultas). Se prioriza por consultas, no por antigüedad.</li>
<li>Las dos preguntas sin artículo (acceso al sistema de asistencia y creación de la cuenta de un docente nuevo, 43 tickets en total) son los dos artículos que más urge escribir.</li>
</ul>
<p><strong>Una lectura honesta:</strong> el libro mide si el artículo existe y está al día, no si es bueno. Un artículo vigente puede estar mal escrito, y uno vencido puede seguir siendo correcto. La fecha es una alarma para revisar, no un veredicto. Y los números dependen de que el registro de tickets sea fiable.</p>

<h2>Cómo empezar en un colegio</h2>
<ol>
<li><strong>Parte de los tickets.</strong> Toma las diez preguntas que más se repiten (de la mesa de ayuda, de los correos o de lo que el coordinador responde de memoria).</li>
<li><strong>Escribe un artículo por pregunta,</strong> corto y probado por otra persona, y asígnale un responsable y una frecuencia de revisión.</li>
<li><strong>Publícalo donde se pregunta:</strong> un lugar único y fácil de encontrar, y que la mesa de ayuda responda con el enlace.</li>
<li><strong>Revisa cada mes</strong> con el libro: qué venció, qué no tiene dueño, qué pregunta sigue sin artículo.</li>
<li><strong>Cuida lo sensible:</strong> accesos con permisos, sin contraseñas ni datos de estudiantes en los artículos (ver <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">el inventario tecnológico</a> y <a href="/plan-continuidad-operativa-colegio-analisis-impacto-rto-rpo-excel/">el plan de continuidad</a>, donde una base de conocimiento disponible sin conexión sirve en una caída).</li>
</ol>
<p>Si el colegio ya trabaja con herramientas de IA, un asistente puede ayudar a redactar o resumir artículos, pero <strong>solo con información que no sea confidencial</strong> y siempre con revisión humana (ver la <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">política institucional de IA</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La gestión del conocimiento en servicios de TI es una práctica consolidada en empresas y universidades, donde se mide qué parte de las consultas se resuelve con un artículo de autoservicio. En los colegios colombianos y latinoamericanos, el recurso más común sigue siendo la memoria de la persona de sistemas o de la secretaría, con una alta rotación de personal en algunos contextos que agrava el problema. En el mundo, la evidencia de los modelos de autoservicio muestra beneficios cuando el contenido se mantiene, y frustración cuando está desactualizado. Para los <strong>docentes</strong>, una base clara reduce la dependencia de las mismas tres personas; para los <strong>directivos</strong>, es una forma barata de continuidad y de inducción de personal nuevo; para las <strong>familias</strong>, respuestas consistentes sobre pagos, boletines y accesos; y para los <strong>estudiantes</strong>, menos tiempo perdido por no saber a quién preguntar.</p>

<h2>Herramientas y plantillas</h2>
<p>Si trabajas con las plantillas de Excel del sitio y quieres apoyo, o preparas material con IA (revisando siempre lo que produce y sin incluir datos personales ni confidenciales en herramientas que no estén diseñadas para custodiarlos), mira estos productos.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: el <a href="/descargas/base-de-conocimiento/base-de-conocimiento-colegio.xlsx">libro de la base de conocimiento</a>, <a href="/implementar-plataforma-colegio-30-dias-plan-piloto-decision-excel/">implementar una plataforma en 30 días</a> y las herramientas <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es una base de conocimiento institucional?</h3>
<p>Un conjunto de artículos cortos, con responsable y fecha de revisión, que responden las preguntas que más se repiten en la institución.</p>
<h3>¿Con cuántos artículos empiezo?</h3>
<p>Con diez: los que responden las preguntas más frecuentes. Es mejor pocos y vigentes que muchos y desactualizados.</p>
<h3>¿Cada cuánto debe revisarse un artículo?</h3>
<p>Depende de qué tan rápido cambia el proceso: los de plataformas o formularios, cada pocos meses; los estables, una vez al año. El libro permite fijar la frecuencia por artículo.</p>
<h3>¿Qué hago con un artículo vencido?</h3>
<p>Verifica los pasos con la versión actual: si siguen siendo correctos, actualiza la fecha de revisión; si no, corrígelo. Prioriza los que más preguntas generan.</p>
<h3>¿Puedo poner contraseñas o datos de estudiantes en un artículo?</h3>
<p>No. Una base de conocimiento no es un lugar para credenciales ni para datos personales o confidenciales.</p>

<p class="notice"><strong>Mide tu base de conocimiento.</strong> Descarga el <a href="/descargas/base-de-conocimiento/base-de-conocimiento-colegio.xlsx">libro de la base de conocimiento</a>, reemplaza los datos ficticios por tus artículos y tus diez preguntas más frecuentes, y mira primero qué artículos vencidos o huérfanos generan más tickets.</p>

<h2>Para pensar</h2>
<p>Cuando el conocimiento vive en la cabeza de unas pocas personas, el colegio depende de su memoria y de su disponibilidad, y ellas pagan el costo de ser siempre las que saben. <strong>¿Qué sabe hoy una sola persona de tu colegio que, si se fuera mañana, dejaría a los demás sin saber cómo hacerlo? Y ¿quién tendría que escribirlo, y quién tendría que comprobar que está bien?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:condiciones}}' => $img('base-de-conocimiento-condiciones', 499, 'Tabla con cuatro condiciones de un artículo confiable, qué evita cada una y cómo se ve: responsable, fecha de revisión, pasos probados y enlace desde la mesa de ayuda.', 'Cuatro condiciones de un buen artículo.'),
    '{{img:estado}}' => $img('base-de-conocimiento-estado', 480, 'Gráfico de barras con los tickets por estado de la respuesta: 172 vigente, 29 por vencer, 97 vencido, 41 sin responsable y 43 sin artículo.', 'Tickets por estado de la respuesta.'),
]);

return [
    'slug' => 'base-de-conocimiento-colegio-articulos-responsable-fecha-revision-excel',
    'title' => 'Base de conocimiento del colegio: que la respuesta exista, esté al día y tenga dueño, con un libro de Excel',
    'excerpt' => 'Cómo armar una base de conocimiento institucional con artículos cortos, responsable y fecha de revisión, y medir con Excel cuántas preguntas frecuentes quedan sin una respuesta confiable.',
    'seo_title' => 'Base de conocimiento del colegio: guía y libro de Excel',
    'seo_description' => 'Cómo armar una base de conocimiento para el colegio: artículos con responsable y fecha de revisión, tickets sin respuesta y un libro de Excel verificado.',
    'focus_keyword' => 'base de conocimiento del colegio',
    'cover' => '/assets/img/articulos/base-de-conocimiento/base-de-conocimiento-portada',
    'cover_alt' => 'Portada "Base de conocimiento del colegio: que la respuesta exista y esté al día" con una tarjeta: 47,4 % de los tickets frecuentes sin una respuesta confiable.',
    'published_at' => '2027-02-23 12:00:00',
    'content_html' => $html,
];
