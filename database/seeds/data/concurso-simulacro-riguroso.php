<?php

declare(strict_types=1);

// "Simulacro riguroso o banco de preguntas inventado con IA". Fuentes verificadas el 9 de octubre de 2026: respuestas de la CNSC al proyecto de acuerdo (septiembre de 2026, documento preliminar), El Espectador (21-feb-2026). Preguntas de ejemplo hipotéticas hechas por el autor, no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/simulacro-riguroso-concurso/' . $name;
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
<p>Alrededor de cada concurso docente crece un negocio: simulacros, bancos de preguntas, cursos y "paquetes definitivos". Algunos son serios; otros son colecciones de preguntas generadas en minutos con inteligencia artificial, sin revisión, con claves que a veces están mal. Como aspirante, tienes poco tiempo y mucha ansiedad, y es fácil confundir <strong>cantidad con calidad</strong>. Una pregunta con la clave equivocada no solo no te ayuda: te enseña mal.</p>
<p>Este artículo te da una <strong>rúbrica de diez criterios</strong> para evaluar cualquier simulacro (incluido el mío, y lo digo más abajo), tres ejemplos de preguntas defectuosas y una <a href="/descargas/concurso-docente/rubrica-simulacro-concurso-docente.xlsx">rúbrica descargable en Excel</a> que calcula el puntaje. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los ejemplos de preguntas de este artículo son hipotéticos y los escribí yo para ilustrar errores; <strong>no son preguntas oficiales</strong>. Ningún simulacro garantiza un puntaje ni un nombramiento. La información oficial del concurso se consulta únicamente en el portal de la CNSC y en SIMO, y las condiciones definitivas están en los documentos definitivos de la convocatoria, no en preliminares ni en lo que diga un vendedor.</p>

<h2>Por qué importa la calidad de la práctica</h2>
<p>Según las respuestas oficiales de la CNSC a las observaciones al proyecto de acuerdo (septiembre de 2026, documento preliminar cuyas reglas debes confirmar en el acuerdo definitivo), la prueba de aptitudes y competencias básicas vale el 55 % y exige un mínimo de 60/100 para docentes y de 70/100 para directivos docentes; sus componentes incluyen lectura crítica, razonamiento cuantitativo, competencias blandas y conocimientos disciplinares y pedagógicos. Es un peso grande, y por eso la forma en que practicas importa: <strong>practicar con preguntas mal hechas puede entrenarte para el examen equivocado</strong>.</p>
<p>La prensa colombiana ha recordado, además, que los simulacros ayudan a gestionar el tiempo y a familiarizarse con el tipo de preguntas, pero que "ningún simulacro garantiza un resultado" y que muchas ofertas son de apoyo privado y no material oficial de la CNSC (El Espectador, febrero de 2026). Ese es el punto de partida: <strong>un simulacro es práctica, no un adelanto de la prueba</strong>.</p>

<h2>El problema de los bancos "inventados"</h2>
<p>Generar mil preguntas con IA cuesta casi nada. Revisarlas cuesta mucho. Cuando falta la revisión, aparecen tres defectos típicos, que ilustro con ejemplos hipotéticos:</p>
{{img:defectos}}
<ol>
<li><strong>Clave equivocada.</strong> "En un curso de 40 estudiantes aprobó el 35 %. ¿Cuántos NO aprobaron? A) 14 B) 26 C) 25 D) 65." Si el banco marca A, está contestando cuántos aprobaron (40 × 0,35 = 14); quienes no aprobaron son 26. Un solo error así, repetido, te enseña a leer mal el enunciado.</li>
<li><strong>Más de una respuesta correcta.</strong> "¿Cuál de los siguientes números es primo? A) 21 B) 23 C) 29 D) 33." Tanto 23 como 29 son primos. En una prueba de selección única, esa pregunta no se podría usar.</li>
<li><strong>Normas citadas que no existen.</strong> "Según el artículo 87 del Decreto 1075 de 2015…" El Decreto 1075 de 2015 se numera con el formato 2.3.3.3…, y no tiene un artículo 87 citado así. Una cita que no puedes ubicar en la fuente oficial es una señal de alerta; la IA es especialmente propensa a inventar referencias convincentes.</li>
</ol>
<p>No todo banco generado con IA es malo: la IA puede ayudar a redactar borradores. Lo decisivo es lo que ocurre <strong>después</strong>: revisión por personas expertas, verificación de claves y de normas, y mejora con datos reales.</p>

<h2>La rúbrica de diez criterios</h2>
<p>Puntúa cada criterio de 0 (no), 1 (parcial) a 2 (sí), para un total de 0 a 20 (marco de elaboración propia, no un criterio oficial):</p>
<table>
<thead><tr><th>#</th><th>Criterio</th><th>Qué verificar</th></tr></thead>
<tbody>
<tr><td>1</td><td><strong>Alineación con la estructura oficial</strong></td><td>Indica componentes, tipo de preguntas y tiempo, y cita el documento de la CNSC.</td></tr>
<tr><td>2</td><td><strong>Declara que no es oficial</strong></td><td>No anuncia "preguntas reales" ni se presenta como la CNSC.</td></tr>
<tr><td>3</td><td><strong>Origen de las preguntas</strong></td><td>Autores o revisores identificables; explica si usa IA.</td></tr>
<tr><td>4</td><td><strong>Revisión por expertos</strong></td><td>Cada pregunta la revisó una persona experta en la disciplina y en pedagogía.</td></tr>
<tr><td>5</td><td><strong>Claves justificadas</strong></td><td>Explica por qué la correcta lo es y por qué las otras no.</td></tr>
<tr><td>6</td><td><strong>Una sola respuesta correcta</strong></td><td>En una muestra de 10 preguntas no encuentras errores de clave.</td></tr>
<tr><td>7</td><td><strong>Normas con fuente y vigencia</strong></td><td>Decreto, artículo y enlace verificables.</td></tr>
<tr><td>8</td><td><strong>Retroalimentación diagnóstica</strong></td><td>Resultados por componente y orientación de estudio, no solo un puntaje.</td></tr>
<tr><td>9</td><td><strong>Actualización</strong></td><td>Fecha de revisión y cambios cuando cambian la convocatoria o la norma.</td></tr>
<tr><td>10</td><td><strong>Promesas realistas y datos</strong></td><td>No garantiza puntaje ni nombramiento; precio claro y uso transparente de tus datos.</td></tr>
</tbody>
</table>
<p><strong>Lectura del puntaje:</strong> de 16 a 20, riguroso; de 11 a 15, usable con cautela (verifica claves y normas); de 6 a 10, débil (no lo uses como única fuente); de 0 a 5, evítalo. Y una regla de oro: <strong>si el criterio 2 o el 6 puntúan 0, no lo uses</strong>, sin importar el total.</p>

<h2>Cómo revisar una muestra en 30 minutos</h2>
<ol>
<li>Toma <strong>10 preguntas al azar</strong> del simulacro (no las primeras, que suelen ser las más cuidadas).</li>
<li><strong>Resuélvelas tú antes de ver la clave</strong>, y subraya lo que pide el enunciado.</li>
<li>Marca en la hoja "Revision_de_items" cuántas tienen más de una correcta, clave errónea, enunciado que no coincide con la clave, distractores absurdos o normas que no puedes verificar.</li>
<li>Si encuentras <strong>dos o más</strong> preguntas con error en la muestra, no confíes en sus claves y busca otra fuente.</li>
</ol>

<h2>Y esto también aplica a mi plataforma</h2>
<p>Por transparencia: <strong>Fundales (<a href="https://fundales.com/">fundales.com</a>) es una plataforma mía</strong> de simulacros para el Concurso Docente, y las cuentas son gratuitas durante un año. No es material oficial de la CNSC y no te garantiza puntaje ni nombramiento: es práctica. Te invito a aplicarle esta misma rúbrica, y a aplicársela a cualquier otra que uses; si la rúbrica te muestra un defecto en una pregunta, es útil que me lo digas. Desde este sitio también puedes ver la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> y leer los <a href="/simulacros-concurso-docente-con-respuestas/">simulacros con respuestas</a>.</p>
<p>Para el componente de razonamiento cuantitativo, si necesitas reforzar la base antes de practicar, está el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Y para los casos de juicio situacional, revisa <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">cómo analizar un caso</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia el concurso docente mueve a muchos aspirantes y, con ellos, a un mercado de preparación; en otros países de la región, como Perú o México, también hay pruebas de ingreso docente y mercados de academias, con el mismo riesgo: promesas de éxito sin evidencia. Para los <strong>aspirantes</strong>, la defensa es la verificación; para los <strong>formadores y plataformas</strong>, la transparencia sobre cómo se elaboran las preguntas; para los <strong>directivos y las secretarías</strong>, fomentar práctica de calidad gratuita y orientación oficial clara. Y para tus datos personales: antes de registrarte, lee qué hace la plataforma con ellos (Ley 1581 de 2012).</p>
<p>Sigue leyendo: <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">errores de SIMO y documentos que debes revisar</a>, <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">cómo elegir el cargo</a>, <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el cronograma</a> y <a href="/concurso-docente-reserva-7-por-ciento-discapacidad-que-verificar/">la reserva del 7 %</a>. Si trabajas en inclusión, mira <a href="/herramientas/piar/">PIAR con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Son malos los simulacros hechos con IA?</h3>
<p>No necesariamente. La IA sirve para redactar borradores, pero sin revisión experta pueden aparecer claves erróneas, preguntas con varias respuestas correctas y normas inventadas. Aplica la rúbrica y revisa una muestra.</p>
<h3>¿Existen simulacros oficiales de la CNSC?</h3>
<p>Consulta siempre el portal de la CNSC y SIMO para saber qué material oficial hay. Lo que ofrecen terceros, incluida la mayoría de simulacros, es práctica privada, no material oficial.</p>
<h3>¿Cuántas preguntas debo revisar para evaluar un banco?</h3>
<p>Una muestra aleatoria de 10 preguntas da una primera idea. Si hay dos o más con error, desconfía de las claves.</p>
<h3>¿Un simulacro gratuito es de menor calidad que uno pago?</h3>
<p>No hay relación automática. El precio no mide la calidad: la miden la revisión, la transparencia y las claves justificadas.</p>
<h3>¿Cuánto debo practicar con simulacros?</h3>
<p>Lo importante es la calidad y el análisis de tus errores, más que la cantidad. Un simulacro bien revisado y analizado enseña más que cien sin control.</p>

<p class="notice"><strong>Evalúa tu simulacro hoy.</strong> Descarga la <a href="/descargas/concurso-docente/rubrica-simulacro-concurso-docente.xlsx">rúbrica de simulacros</a>, puntúa el que estás usando y revisa una muestra de 10 preguntas. Después, practica con calma en <a href="https://fundales.com/">Fundales</a> o en la plataforma que elijas, sabiendo que es práctica y no la prueba oficial.</p>

<h2>Para pensar</h2>
<p>Cuando la inteligencia artificial permite fabricar mil preguntas en una tarde, la escasez ya no es de preguntas, sino de criterio. <strong>¿Quién debería responder por la calidad de un simulacro cuando miles de aspirantes estudian con él: quien lo vende, quien lo usa o la entidad que organiza el concurso? ¿Y no sería más justo que existiera práctica oficial, gratuita y revisada para todos, en lugar de que cada aspirante tenga que defenderse de un mercado?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:defectos}}' => $img('simulacro-riguroso-concurso-defectos', 444, 'Tabla con tres preguntas defectuosas hipotéticas: una clave que marca los que aprobaron en vez de los que no, una pregunta con dos respuestas correctas y una cita de un artículo inexistente, con cómo detectar cada defecto.', 'Errores que un banco de preguntas sin revisión deja pasar.'),
]);

return [
    'slug' => 'concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica',
    'title' => 'Simulacro riguroso o banco de preguntas inventado con IA: cómo distinguirlos antes de preparar el Concurso Docente',
    'excerpt' => 'Una rúbrica de diez criterios, tres ejemplos de preguntas defectuosas y un método de revisión de 30 minutos para saber si un simulacro del Concurso Docente merece tu tiempo, con rúbrica descargable.',
    'seo_title' => 'Simulacro del Concurso Docente: cómo evaluarlo',
    'seo_description' => 'Rúbrica de diez criterios y revisión de 10 preguntas para distinguir un simulacro riguroso del Concurso Docente de un banco de preguntas sin control.',
    'focus_keyword' => 'simulacro Concurso Docente',
    'cover' => '/assets/img/articulos/simulacro-riguroso-concurso/simulacro-riguroso-concurso-portada',
    'cover_alt' => 'Portada "Simulacro riguroso o banco de preguntas inventado con IA: cómo distinguirlos" con una lista: declara que no es oficial, explica cada clave y lo revisó un experto, marcados; promete tu nombramiento, descartado.',
    'published_at' => '2026-11-13 12:00:00',
    'content_html' => $html,
];
