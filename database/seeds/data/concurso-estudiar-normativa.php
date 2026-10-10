<?php

declare(strict_types=1);

// "Cómo estudiar la normativa del Concurso Docente sin memorizar artículos". Fuentes verificadas el 9 de octubre de 2026: Dunlosky et al. (2013), Constitución art. 67, Ley 115 de 1994 arts. 73, 76, 77, 142, 144 y 145 (Función Pública, Normograma). Caso de práctica no oficial.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/estudiar-normativa-concurso/' . $name;
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
<p>"Hay que estudiarse la normativa" es el consejo más repetido a quien se prepara para el Concurso Docente, y también el que más angustia produce: leyes, decretos, artículos, parágrafos. La reacción habitual es intentar memorizarlo todo, subrayar de colores y releer hasta que "suene familiar". El problema es que <strong>reconocer una norma no es lo mismo que saber usarla</strong>, y las preguntas de aplicación piden lo segundo.</p>
<p>Este artículo propone un método distinto: en lugar de memorizar artículos, <strong>construyes un mapa normativo</strong>, aprendes a leer cada norma con cuatro preguntas y repasas con intervalos crecientes. Incluye un <a href="/descargas/concurso-docente/mapa-normativo-concurso-docente.xlsx">mapa normativo descargable en Excel</a> con ejemplos verificados contra el texto oficial y un calendario de repaso automático. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Este artículo no define qué normas se evalúan: eso lo establecen los documentos oficiales de la convocatoria (consulta el portal de la CNSC y la guía de orientación vigente, y distingue siempre los documentos preliminares de los definitivos). Los casos de práctica son ejercicios míos, <strong>no preguntas oficiales</strong>. Ningún método garantiza un puntaje ni un nombramiento.</p>

<h2>Qué dice la ciencia del estudio</h2>
<p>La revisión más citada sobre técnicas de estudio, de Dunlosky, Rawson, Marsh, Nathan y Willingham (2013, <em>Psychological Science in the Public Interest</em>), evaluó diez técnicas. Dos recibieron la valoración más alta de utilidad: la <strong>práctica de recuperación</strong> (contestar preguntas sobre lo estudiado, con tarjetas o cuestionarios) y la <strong>práctica distribuida</strong> (repartir el estudio en el tiempo). Cinco recibieron una valoración baja, entre ellas dos de las más comunes: <strong>subrayar y releer</strong>. En palabras del propio Dunlosky, sustituir el releer por la recuperación tardía beneficiaría a los estudiantes.</p>
{{img:tecnicas}}
<p>La consecuencia práctica es incómoda: estudiar la norma con el texto al lado se siente productivo, pero enseña menos que cerrar el texto y tratar de responder. Un método basado en esa evidencia tiene tres piezas: <strong>un mapa</strong> que ordena las normas, <strong>preguntas</strong> para activarlas y un <strong>calendario de repaso</strong> espaciado.</p>

<h2>Paso 1: el mapa normativo</h2>
<p>En lugar de una lista de leyes, construye una tabla con una fila por norma (o artículo clave) y columnas que te obliguen a pensar:</p>
<ul>
<li><strong>Qué regula</strong>, en una sola frase tuya.</li>
<li><strong>Tres conceptos clave</strong> (no más).</li>
<li><strong>Con qué otra norma se conecta</strong>, porque las preguntas de aplicación suelen cruzar normas.</li>
<li><strong>Un caso típico</strong>, que escribes tú.</li>
<li><strong>Una pregunta de autoevaluación</strong>, que contestarás sin mirar la norma.</li>
<li><strong>La fuente oficial consultada</strong>, para no estudiar de resúmenes de terceros.</li>
</ul>
<p>El libro trae seis filas ya llenadas y verificadas contra el texto oficial, como ejemplo. Por ejemplo, el artículo 67 de la Constitución señala al Estado, la sociedad y la familia como responsables de la educación, obligatoria entre los cinco y los quince años, con un mínimo de un año de preescolar y nueve de educación básica; el artículo 73 de la Ley 115 de 1994 ordena que cada establecimiento educativo elabore y ponga en práctica un Proyecto Educativo Institucional; el artículo 142 integra el gobierno escolar de los establecimientos del Estado con el rector, el consejo directivo y el consejo académico; el artículo 144 asigna al consejo directivo participar en la planeación y evaluación del PEI, el currículo y el plan de estudios; y el artículo 145 al consejo académico el estudio, la modificación y el ajuste del currículo. Verifica siempre el texto vigente en la fuente oficial (Función Pública, Normograma o el sitio del Congreso).</p>

<h2>Paso 2: las cuatro preguntas para leer cualquier norma</h2>
<ol>
<li><strong>¿Quién?</strong> Quién decide, quién debe cumplir y quién responde.</li>
<li><strong>¿Qué debe, puede o no puede hacer?</strong> Distingue obligación, facultad y prohibición.</li>
<li><strong>¿Cuándo y cómo?</strong> El procedimiento y el orden de los pasos.</li>
<li><strong>¿Qué pasa si no se cumple y con qué otra norma se conecta?</strong></li>
</ol>
<p>La hoja "Cuatro_preguntas" las trae listas para aplicar a cada artículo. Fíjate que estas preguntas son las mismas que necesitas para resolver una situación: por eso conectan con el <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">método de juicio situacional</a>.</p>

<h2>Paso 3: el repaso espaciado</h2>
<p>El libro calcula la fecha de tu próximo repaso: si contestaste mal o dudaste (confianza 0), repasas al día siguiente; si contestaste bien, los intervalos crecen a 1, 3, 7, 14 y 30 días según los repasos hechos. La columna "Estado" te avisa cuándo toca "Repasar hoy". Son intervalos de elaboración propia, basados en el principio de práctica distribuida; ajústalos a tu tiempo. Lo esencial: <strong>anota "último repaso" solo cuando contestes sin mirar la norma</strong>.</p>
<p>La hoja "Preguntas_de_repaso" trae ocho tarjetas con respuestas verificadas, para empezar. Después, crea las tuyas.</p>

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación:</strong> En un colegio oficial, el equipo de matemáticas propone cambiar la secuencia de contenidos del currículo para que el pensamiento variacional aparezca antes. El rector quiere saber qué instancia debe estudiar y ajustar el currículo y cuál debe participar en la planeación y evaluación del PEI, del currículo y del plan de estudios.</p>
<p><strong>Pregunta:</strong> ¿Qué órgano del gobierno escolar estudia, modifica y ajusta el currículo?</p>
<ol type="A">
<li>El consejo directivo, porque es la máxima instancia del colegio.</li>
<li>El consejo académico, de conformidad con la Ley 115 de 1994.</li>
<li>El rector, por ser el representante legal.</li>
<li>La asamblea de padres de familia, por participar en el PEI.</li>
</ol>
<p><strong>Respuesta:</strong> B. El artículo 145 de la Ley 115 de 1994 asigna al consejo académico "el estudio, modificación y ajustes al currículo, de conformidad con lo establecido en la presente Ley". <strong>Por qué los distractores tientan:</strong> A mezcla dos funciones, porque el consejo directivo <em>participa</em> en la planeación y evaluación del PEI, el currículo y el plan de estudios (art. 144), pero no es el que lo estudia y ajusta; C confunde la representación legal con la competencia pedagógica; D apela a la participación de la comunidad, que existe, pero no es el órgano con esa función. <strong>Ejercicio:</strong> responde ahora ¿qué decisión corresponde a cada órgano si el cambio afecta además al PEI? Conecta con el art. 73 y con la autonomía del art. 77, que se ejerce "dentro de los límites" de la ley y del PEI.</p>

<h2>Cómo organizarlo en cuatro semanas</h2>
<ol>
<li><strong>Semana 1:</strong> consulta en la CNSC qué normas te corresponden, y llena el mapa con las diez más importantes.</li>
<li><strong>Semana 2:</strong> responde las cuatro preguntas por cada norma y escribe un caso típico para cada una.</li>
<li><strong>Semana 3:</strong> haz práctica de recuperación a diario (15 minutos) con tus tarjetas y resuelve casos de aplicación.</li>
<li><strong>Semana 4:</strong> practica en simulacros (evaluando antes su calidad con la <a href="/concurso-docente-simulacro-riguroso-o-banco-de-preguntas-inventado-con-ia-rubrica/">rúbrica de simulacros</a>) y ajusta las confianzas del mapa.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el concurso docente es la vía de ingreso a la carrera en el sector oficial, y la normativa educativa es extensa y se compila en decretos únicos como el 1075 de 2015, lo que facilita ubicarla pero no estudiarla. En otros países de la región también hay evaluaciones de ingreso a la carrera docente, con la misma tentación de memorizar. La evidencia sobre aprendizaje es internacional: lo que funciona para estudiar normas es lo mismo que funciona para cualquier contenido. Para los <strong>aspirantes</strong>, el desafío es estudiar para aplicar, no para recitar; para los <strong>formadores</strong>, enseñar a preguntar a la norma; para los <strong>directivos</strong>, recordar que dominar estas normas importa también en el día a día del colegio.</p>

<h2>Para practicar y organizarte</h2>
<p>Practica con calma en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros para el Concurso Docente (cuentas gratuitas durante un año; es práctica, no material oficial de la CNSC), o desde la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Para reforzar el razonamiento cuantitativo está el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Y si trabajas con estudiantes con discapacidad, mira <a href="/herramientas/piar/">PIAR con IA</a> para ver cómo se estructura un PIAR.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">errores en SIMO</a>, <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">elegir el cargo</a>, <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el cronograma</a> y <a href="/concurso-docente-reserva-7-por-ciento-discapacidad-que-verificar/">la reserva del 7 %</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Debo memorizar los números de los artículos?</h3>
<p>Conviene conocer los de las normas centrales y saber ubicar los demás, pero lo decisivo es entender quién decide, qué se debe hacer y cómo se conecta con otras normas. Las preguntas de aplicación piden usar la norma.</p>
<h3>¿Cuántas normas debo estudiar?</h3>
<p>Las que establezcan los documentos oficiales de la convocatoria para tu cargo. Consulta el portal de la CNSC y la guía de orientación, y confirma que sean los documentos definitivos.</p>
<h3>¿Sirve subrayar el texto?</h3>
<p>Sirve para ubicar, pero según la evidencia es una técnica de baja utilidad para aprender. Combínala con preguntas de recuperación.</p>
<h3>¿Cada cuánto debo repasar?</h3>
<p>Con intervalos crecientes (por ejemplo 1, 3, 7, 14 y 30 días), ajustados a cómo te va al contestar sin mirar la norma.</p>
<h3>¿Dónde consulto el texto oficial de las normas?</h3>
<p>En fuentes oficiales como el Normograma de la Función Pública, el sitio del Congreso, el del Ministerio de Educación o el de la CNSC. Evita estudiar solo de resúmenes de terceros.</p>

<p class="notice"><strong>Empieza hoy.</strong> Descarga el <a href="/descargas/concurso-docente/mapa-normativo-concurso-docente.xlsx">mapa normativo</a>, completa tres filas con las normas de tu cargo, contesta la pregunta de autoevaluación sin mirar y anota la fecha: así arranca tu calendario de repaso.</p>

<h2>Para pensar</h2>
<p>Un concurso que evalúa la normativa busca, en teoría, que quien enseñe conozca el marco en el que trabaja. <strong>¿Mide una prueba escrita el conocimiento de las normas o la capacidad de memorizarlas y reconocerlas rápido? Y si la normativa cambia cada pocos años, ¿es más justo evaluar lo que cada aspirante sabe de memoria o su capacidad de encontrar y aplicar la norma vigente cuando la necesita en un colegio real?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tecnicas}}' => $img('estudiar-normativa-concurso-tecnicas', 444, 'Tabla con tres técnicas de estudio según Dunlosky y colaboradores (2013): practicar recuperando y el repaso espaciado de utilidad alta, y subrayar y releer de utilidad baja, con cómo aplicar cada una a la normativa.', 'Qué técnicas de estudio funcionan mejor que releer y subrayar.'),
]);

return [
    'slug' => 'concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo',
    'title' => 'Cómo estudiar la normativa del Concurso Docente sin memorizar artículos: mapa normativo, preguntas y repaso espaciado',
    'excerpt' => 'Un método para estudiar la normativa del Concurso Docente con evidencia de aprendizaje: mapa normativo, cuatro preguntas para leer cualquier norma, repaso espaciado y un caso de aplicación, con plantilla descargable.',
    'seo_title' => 'Estudiar la normativa del Concurso Docente sin memorizar',
    'seo_description' => 'Cómo estudiar la normativa del Concurso Docente sin memorizar: mapa normativo, cuatro preguntas, repaso espaciado y un caso de aplicación con plantilla.',
    'focus_keyword' => 'estudiar la normativa del Concurso Docente',
    'cover' => '/assets/img/articulos/estudiar-normativa-concurso/estudiar-normativa-concurso-portada',
    'cover_alt' => 'Portada "Cómo estudiar la normativa del concurso sin memorizar artículos" con una lista: preguntarse sin mirar la norma, conectar cada norma con otras y resolver casos, marcados; subrayar todo y releer, descartado.',
    'published_at' => '2026-11-20 12:00:00',
    'content_html' => $html,
];
