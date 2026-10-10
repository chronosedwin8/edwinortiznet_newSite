<?php

declare(strict_types=1);

// "Vacantes por territorio y por área en el Concurso Docente: qué se puede deducir y qué no". Fuentes verificadas el 9 de octubre de 2026: OPEC preliminar de la CNSC (19-ago-2026) según cobertura de Grupo Geard, Portafolio y otros medios; matriz de respuestas de la CNSC (sept. 2026). Cifras preliminares; escenarios y caso de práctica no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/vacantes-concurso-docente/' . $name;
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
<p>Cuando se publicó la oferta preliminar del Concurso Docente, la conversación entre aspirantes se llenó de números: "hay más de 28.000 vacantes", "Antioquia tiene mil y pico para primaria", "en Bogotá hay menos". Es natural querer saber dónde hay más plazas. Pero un número de vacantes, sin contexto, puede llevarte a decidir mal: <strong>más vacantes en un territorio no significa más probabilidad de ser nombrado</strong>.</p>
<p>Este artículo explica qué se sabe de la oferta preliminar, qué se puede deducir de las vacantes por territorio y por área, qué no, y cómo usarlas para tomar una decisión informada. Incluye una <a href="/descargas/concurso-docente/matriz-vacantes-concurso-docente.xlsx">matriz descargable en Excel</a> para comparar empleos con tus propios criterios. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> La oferta que se cita es la <strong>preliminar</strong>: un borrador que la CNSC publicó para observaciones y que puede variar antes de la apertura de inscripciones. Las cifras provienen de la cobertura de medios especializados sobre esa OPEC; verifica siempre en SIMO y en el portal de la CNSC, y distingue los documentos preliminares de los definitivos. Este artículo no garantiza puntajes, probabilidades ni nombramientos.</p>

<h2>Qué se sabe de la oferta preliminar</h2>
<p>La CNSC publicó el 19 de agosto de 2026 los proyectos de acuerdo, el anexo técnico y la OPEC preliminar del proceso de docentes y directivos docentes, con observaciones ciudadanas abiertas hasta el 25 de agosto. La OPEC preliminar supera las <strong>28.000 vacantes</strong>; en julio, con corte al 25 de junio, la proyección de las entidades territoriales hablaba de 26.365 (y el Ministerio de Educación de 26.741 en otra comunicación). Es normal que el número cambie: las entidades reportan y certifican su información, y la oferta definitiva se conoce con los acuerdos. Según la cobertura, por entidad aparecen, por ejemplo, Bogotá con 2.850 vacantes, Antioquia con 1.952, Norte de Santander con 1.482, Santander con 1.317 y Magdalena con 1.288 (todas las áreas y cargos, cifras preliminares). Para ver la oferta, busca en SIMO el proceso en la sección de proyectos de acuerdo (ver <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el nuevo cronograma</a> y <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">los errores en SIMO</a>).</p>

<h2>Un ejemplo: docente de primaria</h2>
<p>Según el reporte de Grupo Geard sobre la OPEC preliminar consolidada, hay <strong>8.059 vacantes proyectadas de docente de primaria</strong>, con los diez primeros territorios así: Antioquia (1.037), Magdalena (952), Norte de Santander (529), Atlántico (506), Bogotá (436), Santander (429), Tolima (387), Valle del Cauca (383), Cundinamarca (374) y Huila (312). Los diez suman 5.345, es decir, el <strong>66,3 %</strong> del total (cálculo propio). Amazonas no tiene vacantes proyectadas para este cargo en esa lista.</p>
{{img:territorios}}
<p>Hasta aquí, datos útiles: la oferta de primaria se concentra en pocos territorios, y dentro de ellos hay entidades grandes (por ejemplo, las secretarías departamentales y las de ciudades como Medellín o Barranquilla). Pero ¿qué puedes concluir de eso?</p>

<h2>Lo que se puede deducir y lo que no</h2>
{{img:deducir}}
<ul>
<li><strong>Sí:</strong> dónde está la oferta de tu área en este momento; qué empleos exigen requisitos que cumples (leyendo el documento oficial); si un empleo es rural o urbano; y que todo puede cambiar.</li>
<li><strong>No:</strong> que ahí tengas más probabilidad; cuántos aspirantes se inscribirán a cada empleo; que un empleo rural tenga menos competencia; ni que la cifra que viste en un medio sea la definitiva.</li>
</ul>

<h2>Por qué las vacantes solas no dicen nada</h2>
<p>La razón es aritmética: lo que importa no es cuántas vacantes hay, sino <strong>cuántos aspirantes competirán por cada una</strong>. La hoja "Escenarios" del libro lo muestra con cifras inventadas:</p>
<table>
<thead><tr><th>Escenario (ilustrativo)</th><th>Vacantes</th><th>Aspirantes que podrían competir</th><th>Aspirantes por vacante</th></tr></thead>
<tbody>
<tr><td>Muchas vacantes, mucha competencia</td><td>40</td><td>2.400</td><td>60</td></tr>
<tr><td>Pocas vacantes, poca competencia</td><td>3</td><td>45</td><td>15</td></tr>
<tr><td>Pocas vacantes, mucha competencia</td><td>3</td><td>600</td><td>200</td></tr>
<tr><td>Muchas vacantes, poca competencia</td><td>40</td><td>200</td><td>5</td></tr>
</tbody>
</table>
<p>Dos empleos con 3 vacantes pueden tener 15 o 200 aspirantes por vacante; uno con 40 puede tener 5 o 60. Y aun esa razón no es una probabilidad: depende de quién apruebe la prueba eliminatoria, de los puntajes de cada etapa y de las reglas definitivas. Por eso <strong>no existe una forma honesta de convertir vacantes en tu "probabilidad de ganar"</strong>, y cualquiera que te la ofrezca te está vendiendo humo.</p>

<h2>Cómo usar las vacantes para decidir bien</h2>
<p>Según el proyecto de anexo técnico y la matriz de respuestas de la CNSC (septiembre de 2026, documentos preliminares), cada aspirante se inscribe a <strong>un solo empleo por proceso</strong> y no se aceptan equivalencias por afinidad; confirma estas reglas en el acuerdo definitivo. Eso convierte la elección del empleo en la decisión más importante, y conviene tomarla con una lista de criterios:</p>
<ol>
<li><strong>Cumples los requisitos del empleo:</strong> título, área y experiencia exactos según el documento oficial. Si no los cumples, la verificación de requisitos te eliminará aunque tengas un gran puntaje (ver <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">cómo elegir el cargo</a>).</li>
<li><strong>Arraigo y disposición real a vivir allí:</strong> ganar una plaza que no estás dispuesto a ocupar no sirve; si el nombramiento se acepta, la permanencia importa.</li>
<li><strong>Logística y costo:</strong> traslado, vivienda, familia.</li>
<li><strong>Interés profesional:</strong> la zona, el nivel y el tipo de institución.</li>
<li><strong>Y solo después</strong>, como dato de contexto, las vacantes.</li>
</ol>
<p>La hoja "Mi_busqueda" del libro implementa este orden: calcula un puntaje de prioridad con arraigo, logística e interés, <strong>pone en cero los empleos cuyos requisitos no cumples</strong> y deja las vacantes fuera del puntaje a propósito.</p>

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación.</strong> Una aspirante a docente de primaria encuentra tres empleos: el A, con 3 vacantes en un municipio rural donde tiene familia; el B, con 12 vacantes en una ciudad grande donde no ha vivido; y el C, con 2 vacantes de matemáticas, para cuyo requisito no tiene el título exacto. Un amigo le dice que elija el B "porque tiene más vacantes".</p>
<p><strong>Pregunta.</strong> ¿Qué razonamiento es el más sólido?</p>
<ol type="A">
<li>Elegir el B: más vacantes significa más probabilidad.</li>
<li>Descartar el C porque no cumple el requisito y comparar A y B según arraigo, logística e interés, considerando las vacantes solo como contexto.</li>
<li>Elegir el C: pocas vacantes significan poca competencia.</li>
<li>Inscribirse en los tres para aumentar las posibilidades.</li>
</ol>
<p><strong>Respuesta:</strong> B. El C se descarta por requisitos (la verificación elimina a quien no los cumple); A y B se comparan con criterios propios; las vacantes no son probabilidad. A y C no se sostienen por la razón que dan; y D choca con la regla de inscripción a un solo empleo por proceso que contempla el proyecto, que debes confirmar en el acuerdo definitivo.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, la oferta se concentra donde el sistema educativo oficial es más grande y donde hay más rotación de provisionales, y los territorios apartados suelen tener plazas difíciles de ocupar; esa lógica se repite en la región, donde la distribución de docentes es un desafío de política pública. Para los <strong>aspirantes</strong>, la decisión es personal y estratégica; para las <strong>secretarías de educación</strong>, la calidad de lo que reportan a la OPEC define la oferta; para los <strong>colegios y las familias</strong> de zonas apartadas, la vacante cubierta con un docente que se queda es la diferencia entre un año estable y uno interrumpido. Por eso, el arraigo no es un detalle sentimental: es un criterio de calidad educativa.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Cuando tengas claro tu empleo, practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica, no material oficial de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio, y evalúa antes su calidad con la <a href="/concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica/">rúbrica de simulacros</a>. Para el razonamiento cuantitativo está el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si te interesa la educación inclusiva en el aula, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">cómo estudiar la normativa sin memorizar</a>, <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a> y <a href="/concurso-docente-reserva-7-por-ciento-discapacidad-que-verificar/">la reserva del 7 %</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuántas vacantes tiene el Concurso Docente?</h3>
<p>La OPEC preliminar publicada el 19 de agosto de 2026 supera las 28.000 vacantes para docentes y directivos docentes, pero es una cifra preliminar que puede cambiar antes de la apertura de inscripciones.</p>
<h3>¿Dónde veo las vacantes de mi área y territorio?</h3>
<p>En SIMO, en la sección de proyectos de acuerdo, buscando el proceso de docentes y directivos docentes 2026. Verifica siempre la versión vigente.</p>
<h3>¿Conviene elegir el territorio con más vacantes?</h3>
<p>No necesariamente. Importan los requisitos, el arraigo y cuántos aspirantes compitan por cada empleo, que no se conoce de antemano.</p>
<h3>¿Un empleo rural tiene menos competencia?</h3>
<p>No se puede asumir. Puede haber menos aspirantes por vacante o no; no hay datos que lo garanticen.</p>
<h3>¿Puedo inscribirme a varios empleos?</h3>
<p>Según el proyecto de anexo técnico y la matriz de la CNSC de septiembre de 2026, la inscripción es a un solo empleo por proceso; confirma la regla en el acuerdo definitivo.</p>

<p class="notice"><strong>Haz tu lista.</strong> Descarga la <a href="/descargas/concurso-docente/matriz-vacantes-concurso-docente.xlsx">matriz de vacantes</a>, pega lo que encuentres en SIMO para los empleos que cumplen tu perfil y puntúalos con tus criterios. Las vacantes quedan solo como contexto.</p>

<h2>Para pensar</h2>
<p>Las vacantes más difíciles de cubrir suelen estar donde más hacen falta docentes: zonas apartadas y rurales. <strong>¿Es justo pedirle a quien gana un concurso por mérito que ocupe una plaza donde nadie quiere ir? ¿O el Estado debería ofrecer incentivos reales (vivienda, bonificaciones, condiciones de seguridad) para que el mérito y la necesidad coincidan?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:territorios}}' => $img('vacantes-concurso-docente-territorios', 524, 'Barras con las vacantes preliminares de docente de primaria por territorio: Antioquia 1.037, Magdalena 952, Norte de Santander 529, Atlántico 506, Bogotá 436 y el resto del país 4.599, de un total de 8.059.', 'Vacantes preliminares de docente de primaria por territorio.'),
    '{{img:deducir}}' => $img('vacantes-concurso-docente-deducir', 633, 'Dos columnas: lo que se puede deducir de las vacantes (dónde hay más oferta, qué empleos piden requisitos que cumples, si es rural o urbano, que la cifra puede cambiar) y lo que no (más probabilidad, número de aspirantes, menos competencia rural, que sea definitiva).', 'Lo que dicen las vacantes y lo que no.'),
]);

return [
    'slug' => 'concurso-docente-vacantes-por-territorio-y-area-que-se-puede-deducir-y-que-no',
    'title' => 'Vacantes por territorio y por área en el Concurso Docente: qué se puede deducir y qué no',
    'excerpt' => 'Cómo leer la OPEC preliminar del Concurso Docente: qué se sabe, un ejemplo con docentes de primaria, por qué más vacantes no significa más probabilidad y una matriz descargable para comparar empleos con criterios propios.',
    'seo_title' => 'Vacantes del Concurso Docente: qué se puede deducir',
    'seo_description' => 'Cómo leer las vacantes por territorio y área de la OPEC preliminar del Concurso Docente, qué no puedes deducir de ellas y una matriz para comparar empleos.',
    'focus_keyword' => 'vacantes Concurso Docente por territorio',
    'cover' => '/assets/img/articulos/vacantes-concurso-docente/vacantes-concurso-docente-portada',
    'cover_alt' => 'Portada "Vacantes por territorio y por área: qué se puede deducir y qué no" con una tarjeta: 8.059 vacantes preliminares de docente de primaria, diez territorios concentran el 66 %, cifra preliminar y más vacantes no es más probabilidad.',
    'published_at' => '2026-11-27 12:00:00',
    'content_html' => $html,
];
