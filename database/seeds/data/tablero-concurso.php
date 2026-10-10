<?php

declare(strict_types=1);

// "Indicadores de progreso para el Concurso Docente: tablero de proceso". Libro verificado en Excel 16 con datos ficticios: temas dominados 38,9 %; cobertura ponderada 55,6 %; cumplimiento de horas 83,9 % (47/56); 6 de 8 semanas; simulacros 63,3 % último, promedio 3 últimos 57,8 %, +15,0 puntos; documentos 62,5 %. Indicadores de proceso, sin predicción. Revisado el 10 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/tablero-concurso/' . $name;
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
<p>Llevas semanas preparándote para el Concurso Docente y, sin embargo, no sabes si vas bien. ¿Estudiar tres horas el sábado compensa no haber estudiado entre semana? ¿Un simulacro de 63 % es bueno o malo? ¿Ya reuniste los soportes de la inscripción? La incertidumbre cansa más que el estudio. Un tablero de indicadores sencillo puede ayudar, siempre que sepamos <strong>qué puede y qué no puede decirnos</strong>.</p>
<p>Este artículo propone <strong>diez indicadores de proceso</strong> agrupados en cuatro familias (temas, constancia, simulacros y documentos), con semáforo y umbrales editables, en un <a href="/descargas/concurso-docente/tablero-progreso-concurso-docente.xlsx">libro descargable en Excel</a> con datos de ejemplo ficticios, verificado en Microsoft Excel 16. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Estos indicadores miden si estás haciendo lo que planeaste; <strong>no miden ni predicen</strong> tu resultado en el concurso, y nadie puede garantizarte un puntaje ni un nombramiento. Los simulacros, incluidos los míos, son práctica no oficial. La lista de temas y documentos del libro es un ejemplo: reemplázala con los componentes y requisitos del acuerdo definitivo y de la convocatoria publicada en SIMO. Los umbrales del semáforo son criterios propios.</p>

<h2>Indicadores de proceso e indicadores de resultado</h2>
<p>Un indicador de <strong>resultado</strong> dice qué obtuviste (el puntaje de la prueba oficial); uno de <strong>proceso</strong> dice qué estás haciendo para llegar allí (horas, temas, simulacros). Para un aspirante, el resultado llega al final y no se puede corregir; el proceso se puede ajustar cada semana. Por eso un tablero de preparación debe ser de proceso. Pero hay una trampa conocida: cuando una medida se convierte en el objetivo, deja de ser una buena medida (la formulación popular de la llamada ley de Goodhart). Si el objetivo pasa a ser "llenar horas" o "subir el porcentaje del simulacro", se puede cumplir el indicador sin aprender: estudiar con el celular al lado, o repetir el mismo simulacro hasta memorizarlo. Por eso cada indicador del tablero está acompañado de una pregunta de control.</p>
{{img:familias}}

<h2>Los diez indicadores</h2>
<h3>Temas</h3>
<ol>
<li><strong>Temas dominados</strong> (38,9 % en el ejemplo: 7 de 18). "Dominado" significa que puedes explicarlo sin apuntes y resolver preguntas nuevas, no que lo leíste. <em>Pregunta de control:</em> ¿lo explico en voz alta en dos minutos?</li>
<li><strong>Cobertura ponderada</strong> (55,6 %): cuenta cada tema dominado como 1 y cada tema en curso como 0,5. Muestra el avance incluyendo lo que está a medias.</li>
<li><strong>Temas sin iniciar</strong> (5): los frentes que aún no empiezas. Un número alto no es un fracaso: es una lista de qué sigue.</li>
</ol>
<h3>Constancia</h3>
<ol start="4">
<li><strong>Cumplimiento de horas</strong> (83,9 %: 47 de 56 horas planeadas en ocho semanas). <em>Pregunta de control:</em> ¿las horas fueron de estudio con foco o de "estar frente al libro"?</li>
<li><strong>Semanas cumplidas</strong> (6 de 8, tomando como cumplida una semana con 80 % o más de lo planeado). La constancia importa más que un fin de semana heroico.</li>
</ol>
<h3>Simulacros</h3>
<ol start="6">
<li><strong>Último simulacro</strong> (63,3 %: 38 de 60 aciertos).</li>
<li><strong>Promedio de los tres últimos</strong> (57,8 %): suaviza la variación de un solo simulacro.</li>
<li><strong>Cambio entre el primero y el último</strong> (+15,0 puntos porcentuales, de 48,3 % a 63,3 %). Es la dirección de la tendencia, <em>no un pronóstico</em>: la dificultad y la estructura de un simulacro pueden diferir de la prueba oficial.</li>
</ol>
<h3>Documentos</h3>
<ol start="9">
<li><strong>Documentos listos</strong> (62,5 %: 5 de 8 en el ejemplo, con dos en trámite).</li>
<li><strong>Documentos sin gestionar</strong> (1: la copia de respaldo). Revisa antes de que cierre la inscripción (ver <a href="/concurso-docente-errores-simo-documentos-revisar-antes-inscripcion/">errores en SIMO</a> y <a href="/concurso-docente-titulo-opec-compatibilidad-sin-rumores-matriz-trazabilidad/">la matriz de trazabilidad título-OPEC</a>).</li>
</ol>
<p>Todos esos resultados se verificaron en Excel con un cálculo independiente. El semáforo de la hoja usa umbrales propios (por ejemplo, cumplimiento de horas: verde desde 80 %, amarillo desde 60 %), y los puedes cambiar. En el ejemplo, los indicadores de constancia y de simulacros están en verde; los de temas, en amarillo; y los de documentos, en rojo: <strong>lo que el tablero señala es dónde mirar esta semana</strong> (los documentos), y esa es una conclusión distinta de la que daría el puntaje de un simulacro.</p>

<h2>La revisión semanal de diez minutos</h2>
{{img:revision}}
<ol>
<li><strong>Actualiza</strong> las horas hechas, los estados de los temas y el último simulacro.</li>
<li><strong>Mira los indicadores en rojo</strong> y en amarillo.</li>
<li><strong>Elige una sola prioridad</strong> para la semana.</li>
<li><strong>Planea</strong> una tarea concreta, con horas, que mueva ese indicador.</li>
<li><strong>Revisa</strong> el domingo siguiente. Para analizar los errores de cada simulacro, ver <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">del simulacro al plan de mejora</a>.</li>
</ol>
<p>El libro incluye dos gráficos (el porcentaje de acierto por simulacro y las horas planeadas y hechas por semana) para ver la tendencia de un vistazo.</p>

<h2>Un caso de aplicación (práctica, no oficial)</h2>
<p><strong>Situación.</strong> Una aspirante revisa su tablero un domingo: cumplimiento de horas 85 %, cobertura ponderada 45 %, los tres últimos simulacros en 52 %, 51 % y 52 %, y dos documentos sin gestionar. Piensa: "voy mal porque mi simulacro no sube; voy a dejar de hacer simulacros y a estudiar solo teoría".</p>
<p><strong>Pregunta.</strong> ¿Cuál es la lectura más sólida?</p>
<ol type="A">
<li>Dejar los simulacros: no suben, así que no sirven.</li>
<li>Reconocer que la constancia es buena, que el estancamiento de los simulacros sugiere analizar sus errores por causa (no solo estudiar más), y gestionar primero los documentos pendientes, que tienen una fecha límite que no depende de su nivel de estudio.</li>
<li>Duplicar las horas de estudio, porque la cobertura es baja.</li>
<li>Esperar al siguiente simulacro antes de decidir nada.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> Los indicadores no se leen de a uno: la constancia es buena pero el resultado de los simulacros está estancado, y eso apunta a cambiar <em>cómo</em> se estudia (clasificar los errores por causa, ver el artículo anterior), no solo cuánto. Además, los documentos pendientes tienen plazo y consecuencias propias. A abandona la práctica justo cuando da información; C responde a un indicador con más cantidad sin cambiar la calidad; D pierde una semana. Este caso es un ejercicio mío, no una pregunta oficial.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>El Concurso Docente en Colombia se desarrolla con las reglas de la CNSC y con plazos y etapas que se publican en SIMO (ver <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">el nuevo cronograma</a>), y los aspirantes llegan con trayectorias muy distintas: docentes en ejercicio con poco tiempo, profesionales no licenciados, quienes preparan el concurso desde zonas rurales con conexión limitada. En otros países de la región y del mundo la preparación de pruebas de alto impacto también combina estudio, práctica y gestión de requisitos. Para los <strong>aspirantes</strong>, un tablero de proceso reduce la incertidumbre sin prometer resultados; para los <strong>formadores</strong> y las <strong>plataformas de práctica</strong>, devolver al aspirante datos de proceso (no solo un puntaje) es parte de enseñar bien; para los <strong>directivos</strong> de las instituciones donde trabajan los aspirantes, facilitar tiempos de estudio es una forma de cuidar a su equipo; y para las <strong>familias</strong>, respetar el tiempo de estudio sin presionar con "tienes que ganar". Y ante cualquier promesa de "plaza asegurada", ver <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a>.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio, y registra los resultados en el tablero. Estudia la normativa con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a>, elige tu empleo con criterio (<a href="/concurso-docente-vacantes-por-territorio-y-area-que-se-puede-deducir-y-que-no/">vacantes</a>) y refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-observaciones-reclamaciones-correcciones-mapa-de-plazos/">observaciones y reclamaciones</a> y <a href="/concurso-docente-elegir-cargo-aula-orientador-coordinador-rector-perfil/">cómo elegir cargo</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Un tablero verde significa que voy a aprobar el concurso?</h3>
<p>No. Mide si estás haciendo lo que planeaste, no el resultado. Nadie puede garantizar un puntaje ni un nombramiento.</p>
<h3>¿Qué porcentaje de simulacro es suficiente?</h3>
<p>No hay un número que lo determine: los simulacros son práctica no oficial, con dificultad y estructura que pueden diferir de la prueba oficial. Úsalos para ver tu tendencia y analizar errores.</p>
<h3>¿Cuántas horas debo estudiar por semana?</h3>
<p>Depende de tu punto de partida, de tu trabajo y de tu familia. Más útil que una cifra universal es un plan que puedas cumplir (el tablero te muestra si lo cumples) y ajustar.</p>
<h3>¿Puedo cambiar los temas y los umbrales?</h3>
<p>Sí. Las listas son un ejemplo: cambia los temas por los de la convocatoria definitiva y los umbrales por los que te sirvan.</p>
<h3>¿Qué hago con un indicador en rojo?</h3>
<p>Tómalo como una señal de dónde mirar, no como un fracaso: elige una sola prioridad para la semana y planea una tarea concreta.</p>

<p class="notice"><strong>Arma tu tablero hoy.</strong> Descarga el <a href="/descargas/concurso-docente/tablero-progreso-concurso-docente.xlsx">tablero de progreso</a>, reemplaza los temas y documentos del ejemplo por los tuyos y haz tu primera revisión de diez minutos este domingo.</p>

<h2>Para pensar</h2>
<p>Medir ayuda a no engañarse, pero también puede convertirse en otra fuente de ansiedad. <strong>¿Cuándo un indicador te ayuda a cuidar tu preparación y cuándo empieza a reemplazar el aprendizaje que debía medir? Y si el mejor docente no es el que más horas registró, sino el que más aprendió a enseñar, ¿qué indicador de ese proceso valdría la pena llevar?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:familias}}' => $img('tablero-concurso-familias', 499, 'Tabla con cuatro familias de indicadores de progreso, qué mide cada una y cuándo prender la alerta: cobertura de temas, cumplimiento de horas, tendencia de simulacros y documentos listos.', 'Qué mide cada familia de indicadores.'),
    '{{img:revision}}' => $img('tablero-concurso-revision', 467, 'Cinco pasos de la revisión semanal: actualizar, mirar los rojos, elegir una prioridad, planear y revisar.', 'La revisión semanal de diez minutos.'),
]);

return [
    'slug' => 'concurso-docente-indicadores-de-progreso-tablero-de-preparacion',
    'title' => 'Indicadores de progreso para el Concurso Docente: un tablero de proceso, sin confundir avance con pronóstico',
    'excerpt' => 'Diez indicadores de proceso con semáforo (temas, constancia, simulacros y documentos) para saber si estás haciendo lo que planeaste en tu preparación del Concurso Docente, con un tablero descargable en Excel.',
    'seo_title' => 'Indicadores de progreso para el Concurso Docente',
    'seo_description' => 'Un tablero de diez indicadores de proceso para preparar el Concurso Docente: temas, horas, simulacros y documentos, con semáforo y libro de Excel descargable.',
    'focus_keyword' => 'indicadores de progreso Concurso Docente',
    'cover' => '/assets/img/articulos/tablero-concurso/tablero-concurso-portada',
    'cover_alt' => 'Portada "Indicadores de progreso para el Concurso Docente: un tablero de proceso" con una tarjeta: 83,9 % de cumplimiento de horas en el ejemplo, 47 de 56 horas planeadas.',
    'published_at' => '2027-01-08 12:00:00',
    'content_html' => $html,
];
