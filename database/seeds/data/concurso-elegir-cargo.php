<?php

declare(strict_types=1);

// "¿Docente de aula, orientador, coordinador o rector? Cómo elegir el cargo según tu perfil". Fundamentado en el Diario Oficial 51.984 (Resolución 3842
// de 2022, MEN) que cita el Decreto 1075 de 2015, y en las respuestas oficiales de la CNSC (septiembre de 2026) al proyecto de acuerdo del proceso docente
// 2026. Documentos PRELIMINARES. No se citan años de experiencia ni títulos por cargo porque no pude verificarlos en el Anexo Técnico 1 vigente: se
// remite a la fuente. Última verificación: 9 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/concurso-elegir-cargo/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Cuando llegue el momento de inscribirte al Concurso Docente tendrás que tomar una decisión que no podrás deshacer: <strong>escoger un solo empleo</strong>. Y la OPEC trae cargos muy distintos: docentes de aula, docentes orientadores, coordinadores, directores rurales y rectores. Elegir mal no es solo perder una oportunidad: puede significar presentarte a un cargo cuyos requisitos no cumples y quedar fuera en la verificación.</p>
<p>Este artículo te propone un método para <strong>elegir el cargo según tu perfil</strong>, comparar lo que cambia entre cargos y descartar lo que no cumples, usando los documentos oficiales. Una advertencia: los textos de la CNSC que cito son un <strong>proyecto de acuerdo preliminar</strong>; las reglas válidas son las del acuerdo definitivo, y <strong>hoy no hay inscripciones abiertas</strong>. Este artículo no garantiza nombramientos, puntajes ni probabilidades de aprobación. Fecha de la última verificación: 9 de octubre de 2026.</p>
<p class="notice"><strong>En resumen.</strong> El Decreto 1075 de 2015 distingue cargos docentes (docente de aula, docente orientador y docente de apoyo pedagógico) y directivos docentes (rector, director rural y coordinador). Los títulos habilitantes y la experiencia de cada cargo están en el Manual de Funciones, Requisitos y Competencias (Resolución 3842 de 2022, Anexo Técnico 1), y la CNSC dijo que no se crearán equivalencias "por afinidad" ni se exigirán requisitos adicionales. Elige solo el empleo cuyos requisitos cumples exactamente, y confirma cada uno en la OPEC.</p>

<h2>El mapa de cargos: qué es cada uno</h2>
<p>Según el Diario Oficial que publicó la <a href="https://sidn.ramajudicial.gov.co/SIDN/NORMATIVA/TEXTOS_COMPLETOS/8_RESOLUCIONES/RESOLUCIONES%202022/MEN%20Resoluci%C3%B3n%20003842%20de%202022%20(Requisitos%20y%20Competencias%20para%20los%20Cargos%20de%20Directivos%20Docentes).pdf">Resolución 3842 de 2022 del Ministerio de Educación</a>, el artículo 2.4.6.3.3 del Decreto 1075 de 2015 establece tres tipos de cargos docentes: <strong>docentes de aula</strong> (de preescolar, de primaria y de las áreas de conocimiento de básica y media), <strong>docentes orientadores</strong> y <strong>docentes de apoyo pedagógico</strong> (que acompañan a los docentes de aula que atienden estudiantes con discapacidad). Y los cargos directivos docentes son <strong>rector, director rural y coordinador</strong>. En el proyecto de la CNSC para 2026, la oferta preliminar incluye docentes de aula, docentes orientadores, rectores, coordinadores y directores rurales.</p>
<table>
<thead><tr><th>Cargo</th><th>Rol general (resumen)</th><th>Para quién suele ser</th></tr></thead>
<tbody>
<tr><td><strong>Docente de aula</strong></td><td>Orienta procesos de enseñanza y aprendizaje en una etapa o un área.</td><td>Licenciados y profesionales con título habilitante para el área o nivel.</td></tr>
<tr><td><strong>Docente orientador</strong></td><td>Acompaña a estudiantes y comunidad en procesos de orientación escolar y bienestar.</td><td>Perfiles de psicología u otras formaciones que el manual habilite expresamente.</td></tr>
<tr><td><strong>Coordinador</strong></td><td>Apoya la gestión académica o de convivencia bajo la dirección del rector.</td><td>Docentes con la formación y la experiencia que exige el manual.</td></tr>
<tr><td><strong>Director rural</strong></td><td>Dirige un establecimiento rural, a menudo con varias sedes.</td><td>Docentes con el perfil directivo y disposición para trabajar en zona rural.</td></tr>
<tr><td><strong>Rector</strong></td><td>Dirige el establecimiento educativo y lo representa ante las autoridades educativas.</td><td>Docentes con el perfil directivo, formación y experiencia que exige el manual.</td></tr>
</tbody>
</table>
<p>Esa descripción es un resumen general mío para orientarte; las funciones y los requisitos exactos están en el Manual de Funciones, Requisitos y Competencias y en la OPEC. <strong>No te cito aquí años de experiencia ni títulos por cargo</strong>, porque los requisitos exactos están en el Anexo Técnico 1 de esa resolución y no pude verificarlos en una fuente oficial al redactar; consúltalos directamente (más abajo te digo dónde).</p>

<h2>Lo que cambia entre ser docente y ser directivo: las pruebas</h2>
<p>Una diferencia sí está documentada en las respuestas de la CNSC al proyecto de acuerdo: el peso de las pruebas y el puntaje mínimo cambian entre docentes y directivos docentes.</p>
{{img:pruebas}}
<p>La prueba de aptitudes y competencias básicas es la <strong>única eliminatoria</strong> (55 % en ambos casos, con un mínimo de 60/100 para docentes y de 70/100 para directivos docentes, según el proyecto). Para los directivos pesa más la prueba psicotécnica (10 % frente a 5 %) y menos la valoración de antecedentes (25 % frente a 30 %). La entrevista pesa 10 % en ambos casos. Son valores del proyecto, que pueden cambiar en el acuerdo definitivo. Si quieres profundizar en cada rol, mira <a href="/concurso-docente-2026-docente-de-aula-la-estrategia-que-separa-a-los-preparados-de-los-eliminados/">la estrategia del docente de aula</a> y <a href="/concurso-docente-2026-el-filtro-que-muchos-rectores-no-pasaran/">el filtro que muchos rectores no pasarán</a>.</p>

<h2>Las reglas de elegibilidad que no cambian con el cargo</h2>
<ul>
<li><strong>Cada empleo tiene requisitos propios.</strong> La OPEC en SIMO indica la denominación, el área, el nivel y los requisitos de cada uno. La CNSC dijo que antes de las inscripciones cotejará el Manual con la OPEC y la parametrización de SIMO, y que <strong>no se exigirán requisitos adicionales ni se crearán equivalencias "por afinidad"</strong>.</li>
<li><strong>Título expedido por una institución habilitada.</strong> Según la Resolución 3842 (que cita el Decreto 1075), los títulos deben haber sido expedidos por una institución legalmente habilitada, y los obtenidos en el exterior deben estar convalidados ante el Ministerio de Educación Nacional para participar.</li>
<li><strong>Una sola inscripción por proceso.</strong> Hay que escoger un empleo, y aplica a todas las personas, incluso a educadores ya nombrados en propiedad.</li>
<li><strong>La verificación es individual</strong> y se hace con los documentos cargados en SIMO, hasta el último día de inscripciones. Te lo expliqué en <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">el artículo sobre errores en SIMO y documentos</a>.</li>
<li><strong>Si hay discapacidad certificada</strong>, existe una modalidad con reserva: mira <a href="/concurso-docente-reserva-7-por-ciento-discapacidad-que-verificar/">el artículo sobre la reserva del 7 %</a>.</li>
</ul>

<h2>Método en cinco pasos para elegir tu cargo</h2>
<ol>
<li><strong>Inventario de tu formación.</strong> Anota el nombre <em>exacto</em> de cada título (pregrado y posgrado), la institución y la fecha de grado. Distingue lo obtenido de lo que está en curso.</li>
<li><strong>Inventario de tu experiencia.</strong> Para cada certificación, anota el cargo, las funciones, las fechas de ingreso y retiro y el tipo de institución. Distingue experiencia docente de aula, de orientación y de dirección o coordinación.</li>
<li><strong>Lee la OPEC.</strong> Cuando esté disponible, busca en SIMO los empleos de tu interés y registra para cada uno la denominación, el área, el nivel, la entidad territorial y los requisitos exactos.</li>
<li><strong>Descarta lo que no cumples.</strong> Compara tu inventario con los requisitos de cada empleo. Si un requisito no se cumple, descarta ese empleo: no cuentes con equivalencias por afinidad. Esta es la regla que más ahorra errores.</li>
<li><strong>Prioriza entre los que sí cumples.</strong> Con los empleos viables, decide por vocación y contexto (nivel, área, territorio, condiciones de trabajo) y por el esfuerzo de preparación que exige cada prueba. Recuerda que solo puedes inscribirte a uno.</li>
</ol>

<h2>Un ejemplo hipotético</h2>
<p>Laura es licenciada en Matemáticas, tiene una maestría en Educación y 6 años como docente de aula en bachillerato; además trabaja como coordinadora académica "encargada" desde hace dos años. ¿Qué empleos podría considerar? Aplicando el método: <strong>docente de aula de Matemáticas</strong> en básica secundaria o media (su título y experiencia coinciden con el área); <strong>coordinador</strong>, si el manual y la OPEC del empleo específico reconocen su título y su experiencia en el cargo requerido (hay que verificar si el tiempo como encargada cuenta y cómo se certifica); y <strong>rector o director rural</strong>, que suelen exigir más formación y experiencia directiva, y que ella debe contrastar con los requisitos exactos antes de siquiera considerarlos. Lo importante: Laura no "elige el cargo que más le gusta", sino el que <strong>cumple, documenta y puede defender</strong>, y solo después compara cuál le conviene. Es un caso inventado con fines pedagógicos, no una evaluación de elegibilidad.</p>

<h2>Lista de verificación para elegir el cargo</h2>
<p>Este es el recurso aplicable. Úsalo para cada empleo que estés considerando; si un "No" aparece, descarta el empleo o revisa la norma:</p>
<table>
<thead><tr><th>Pregunta</th><th>Dónde verificarlo</th></tr></thead>
<tbody>
<tr><td>¿El nombre de mi título coincide con los títulos que admite este empleo?</td><td>OPEC en SIMO y Anexo Técnico 1 de la Resolución 3842 de 2022.</td></tr>
<tr><td>¿Mi título lo expidió una institución habilitada y, si es del exterior, está convalidado?</td><td>Resolución 3842 de 2022 y el acuerdo definitivo.</td></tr>
<tr><td>¿Cumplo la experiencia que pide este cargo y puedo certificarla con cargo, funciones y fechas?</td><td>Manual de Funciones y anexo técnico del proceso.</td></tr>
<tr><td>¿Cuento solo con lo obtenido hasta el último día de inscripciones?</td><td>Acuerdo definitivo y cronograma.</td></tr>
<tr><td>¿El área o nivel del empleo corresponde a mi formación (preescolar, primaria, área de básica o media)?</td><td>OPEC en SIMO.</td></tr>
<tr><td>¿Entiendo el peso de cada prueba para este cargo y mi plan de estudio lo refleja?</td><td>Acuerdo y anexo técnico (pruebas y ponderaciones).</td></tr>
<tr><td>¿Voy a elegir un solo empleo y ya lo comparé con mis alternativas?</td><td>Acuerdo definitivo (inscripción única por proceso).</td></tr>
<tr><td>¿Tengo organizados mis documentos (hoja de control)?</td><td><a href="/descargas/concurso-docente/control-documentos-aspirante.xlsx">Hoja de control de documentos</a> (gratis).</td></tr>
</tbody>
</table>
<p>Los textos exactos están en el <a href="https://www.suin-juriscol.gov.co/viewDocument.asp?ruta=Resolucion/30046385">SUIN-Juriscol (Resolución 3842 de 2022)</a>, en <a href="https://www.cnsc.gov.co/">cnsc.gov.co</a> y en <a href="https://simo.cnsc.gov.co/">SIMO</a>. Desconfía de quien te "asegure" un cargo o un puntaje.</p>

<h2>Tres miradas: docentes de aula, orientadores y aspirantes a dirección</h2>
<ul>
<li><strong>Docente de aula:</strong> es el cargo que más se parece a lo que ya haces si hoy enseñas; la preparación se concentra en la prueba de aptitudes y en demostrar competencias pedagógicas.</li>
<li><strong>Docente orientador:</strong> revisa con especial cuidado el nombre exacto de tu programa y su coincidencia con los títulos habilitantes del manual.</li>
<li><strong>Aspirante a dirección (coordinador, director rural, rector):</strong> el mínimo de la prueba eliminatoria es más alto (70/100 en el proyecto) y la psicotécnica y la entrevista pesan más; conviene sumar a la formación en gestión una preparación específica.</li>
</ul>

<h2>Cómo prepararte mientras llegan las reglas definitivas</h2>
<p>Practica el formato con el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito del Concurso Docente</a> (son preguntas de práctica, <strong>no oficiales</strong>) y, si tu punto débil es la parte cuantitativa de la prueba de aptitudes, el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">Curso de Aptitud Matemática</a> fue pensado para el concurso anterior: úsalo como práctica y compáralo con el anexo técnico definitivo. También te sirve <a href="/20-preguntas-frecuentes-sobre-el-concurso-docente/">el artículo de 20 preguntas frecuentes</a> y <a href="/entrevista-del-concurso-docente-2026-docentes-preescolar-basica-media-todas-las-areas/">la guía de la entrevista</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}

<h2>Preguntas frecuentes</h2>
<h3>¿Puedo inscribirme a un docente de aula y a un coordinador a la vez?</h3>
<p>Según el proyecto, no: hay una sola inscripción por proceso, así que debes escoger un empleo. Compara bien tus opciones antes de decidir.</p>
<h3>Si mi título es afín, ¿me sirve para el empleo?</h3>
<p>La CNSC dijo que no se crearán equivalencias por afinidad ni se exigirán requisitos adicionales: lo que cuenta es lo que el manual y la OPEC habilitan para ese empleo. Verifica el nombre exacto del título.</p>
<h3>¿Cuántos años de experiencia necesito para ser rector o coordinador?</h3>
<p>Depende del cargo y está en el Manual de Funciones, Requisitos y Competencias (Resolución 3842 de 2022, Anexo Técnico 1) y en la OPEC del empleo. No te doy cifras que no pude verificar: consúltalas en la fuente oficial.</p>
<h3>¿Es más difícil ser directivo que docente?</h3>
<p>Los requisitos son mayores y, según el proyecto, el puntaje mínimo de la prueba eliminatoria es más alto (70 frente a 60) y las ponderaciones difieren. No se puede hablar de probabilidades: depende de cada empleo y cada aspirante.</p>
<h3>¿Cuándo puedo ver la OPEC definitiva?</h3>
<p>La OPEC publicada hasta ahora es preliminar y puede cambiar hasta antes de abrir inscripciones. Consúltala en SIMO y revisa el acuerdo definitivo y el cronograma en cnsc.gov.co.</p>

<p class="notice"><strong>Empieza hoy tu inventario.</strong> Descarga la <a href="/descargas/concurso-docente/control-documentos-aspirante.xlsx">hoja de control de documentos</a>, anota tu formación y tu experiencia y prepárate con el <a href="/herramientas/simulacro-concurso-docente/">simulacro gratuito</a>. Cuando salga la OPEC definitiva, aplica el método en cinco pasos. Este artículo se actualizará con las reglas en firme.</p>

<h2>Para pensar</h2>
<p>Muchos docentes sienten que el siguiente paso natural de una carrera es dirigir, pero dirigir es otro oficio que enseñar. <strong>¿Deberíamos premiar a los mejores maestros sacándolos del aula para que dirijan, o hacer que el aula sea un lugar donde un buen docente pueda crecer sin dejar de enseñar?</strong> ¿Y qué dice de nuestro sistema que el camino de ascenso profesional pase casi siempre por abandonar lo que mejor sabemos hacer?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:pruebas}}' => $img('concurso-elegir-cargo-pruebas', 499, 'Tabla con el peso de cada prueba según el proyecto de acuerdo: aptitudes y competencias básicas 55 % para ambos con mínimo 60/100 para docentes y 70/100 para directivos, psicotécnica 5 % y 10 %, valoración de antecedentes 30 % y 25 % y entrevista 10 % en ambos casos.', 'Peso de cada prueba para docentes y directivos docentes (valores del proyecto de acuerdo; preliminares).'),
]);

return [
    'slug' => 'concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil',
    'title' => '¿Docente de aula, orientador, coordinador o rector? Cómo elegir el cargo del Concurso Docente según tu perfil',
    'excerpt' => 'Un método de cinco pasos para elegir un solo cargo en el Concurso Docente, qué cambia entre docentes y directivos según los documentos de la CNSC y una lista de verificación para descartar empleos que no cumples.',
    'seo_title' => 'Concurso Docente: cómo elegir el cargo según tu perfil',
    'seo_description' => 'Cómo elegir entre docente de aula, orientador, coordinador o rector en el Concurso Docente: método de cinco pasos, pesos de las pruebas y lista de verificación.',
    'focus_keyword' => 'elegir cargo Concurso Docente',
    'cover' => '/assets/img/articulos/concurso-elegir-cargo/concurso-elegir-cargo-portada',
    'cover_alt' => 'Portada con el título "¿Docente de aula, orientador, coordinador o rector? Cómo elegir según tu perfil" y una tarjeta con los cargos del proceso: docente de aula enseña, orientador acompaña, coordinador apoya la gestión y rector o director rural dirige.',
    'published_at' => '2026-10-30 12:00:00',
    'content_html' => $html,
];
