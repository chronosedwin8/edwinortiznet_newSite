<?php

declare(strict_types=1);

// Noticia verificada y guía práctica: la CNSC movió las inscripciones del Concurso Docente 2026 a 2027
// (Decreto Legislativo 1384 de 2026, tras el sismo del 10 de agosto). Fuentes revisadas el 8 de octubre de 2026.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/concurso-cronograma/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

return [
    'slug' => 'concurso-docente-2026-nuevo-cronograma-inscripciones-2027',
    'title' => 'Concurso Docente 2026: nuevo cronograma, inscripciones en 2027 y cómo aprovechar el tiempo extra',
    'excerpt' => 'La CNSC movió las inscripciones del Concurso Docente 2026 para el arranque de 2027 tras el Decreto Legislativo 1384. Te explico qué cambió y qué no, cómo quedan las fechas y las etapas, y un plan mes a mes para llegar mejor preparado a la prueba escrita.',
    'seo_title' => 'Concurso Docente 2026: nuevo cronograma y fechas 2027',
    'seo_description' => 'La CNSC movió las inscripciones del Concurso Docente 2026 a 2027. Nuevas fechas, etapas, reserva del 7 % y un plan de estudio mes a mes hasta la prueba.',
    'focus_keyword' => 'cronograma concurso docente 2026',
    'cover' => '/assets/img/articulos/concurso-cronograma/concurso-cronograma-portada',
    'cover_alt' => 'Portada: Concurso Docente, el cronograma se movió a 2027. Calendario con inscripción de personas con discapacidad (dic. 2026 a ene. 2027), inscripciones generales (ene. a feb. 2027) y pruebas escritas (2.º semestre de 2027)',
    'published_at' => '2026-10-08 16:00:00',
    'content_html' => <<<HTML
<p>Desde hace meses me llegan mensajes con la misma pregunta: "profe, ¿por fin cuándo abren las inscripciones?". Muchos colegas ya tenían todo listo para finales de 2026: los documentos escaneados, el empleo escogido y hasta el dinero de los derechos de participación guardado. Ahora la respuesta cambió: <strong>las inscripciones del Concurso Docente 2026 se movieron para el arranque de 2027</strong> y las pruebas escritas quedaron para el segundo semestre de ese año.</p>
<p>Antes de escribir esto revisé lo que publicaron la CNSC y los medios nacionales, porque en estos días circulan muchas cifras y fechas que no tienen respaldo. Te cuento qué está confirmado, qué todavía no y, sobre todo, cómo convertir esta espera en una ventaja.</p>

<p class="notice"><strong>En resumen.</strong> El concurso no se canceló ni se suspendió: se ajustó. Las personas con discapacidad se inscriben primero, de forma gratuita, entre diciembre de 2026 y enero de 2027; las inscripciones generales van de enero a febrero de 2027, y las pruebas escritas se aplicarán en el segundo semestre de 2027. Las fechas exactas saldrán en los acuerdos definitivos de la CNSC.</p>

<h2>Qué cambió y por qué</h2>
<p>El 10 de agosto de 2026 un sismo de magnitud 7,4, con epicentro en el Chocó, sacudió el occidente del país. Según el {$ext('https://www.paho.org/es/documentos/informe-situacion-1-colombia-terremoto-agosto-2026-10-agosto-2026', 'informe de situación de la OPS')}, fue el más fuerte de la última década, se sintió en 16 departamentos y golpeó con más fuerza a Chocó, Caldas, Risaralda, Quindío, Cauca y Valle del Cauca; ciudades como Pereira, Cali y Manizales reportaron edificaciones dañadas. El Gobierno declaró el estado de emergencia económica, social y ecológica y, dentro de ese marco, expidió el <strong>Decreto Legislativo 1384 del 9 de septiembre de 2026</strong>.</p>
<p>Ese decreto ordenó aplazar hasta el 31 de diciembre de 2026 los procesos de selección para proveer empleos públicos, con el fin de proteger la igualdad de oportunidades de los aspirantes damnificados, como informó {$ext('https://www.infobae.com/colombia/2026/09/11/gobierno-de-abelardo-de-la-espriella-anuncio-que-se-aplazan-los-concursos-de-merito-para-vacantes-de-la-cnsc-esta-es-la-razon/', 'Infobae')}. En el caso docente, la CNSC aclaró que el concurso <strong>no se suspende ni se aplaza, sino que se ajusta</strong> para que los aspirantes de las zonas más golpeadas puedan participar en condiciones reales, según recogieron {$ext('https://www.portafolio.co/economia/empleo/concurso-docente-cnsc-2026-requisitos-y-nuevas-fechas-de-inscripcion-para-mas-de-28-000-vacantes-503153', 'Portafolio')} y {$ext('https://www.elespectador.com/educacion/concurso-docente-2026-tiene-nuevas-fechas-de-inscripcion-asi-quedo-el-cronograma/', 'El Espectador')}.</p>
<p>Me parece una decisión sensata. Un maestro de Quibdó o de Pereira que perdió su casa o que está sosteniendo a su comunidad escolar en medio de la reconstrucción no puede competir en igualdad con quien estudia tranquilo. El mérito exige igualdad de condiciones, no solo la misma prueba.</p>

<h2>El nuevo cronograma</h2>
<table>
<thead><tr><th>Etapa</th><th>Cuándo</th><th>Qué debes saber</th></tr></thead>
<tbody>
<tr><td>Inscripción de personas con discapacidad</td><td>Diciembre de 2026 a enero de 2027</td><td>Gratuita. Aplica a las vacantes reservadas.</td></tr>
<tr><td>Inscripciones generales</td><td>Enero a febrero de 2027</td><td>Por SIMO, con pago de derechos de participación.</td></tr>
<tr><td>Pruebas escritas</td><td>Segundo semestre de 2027</td><td>Fecha exacta por definir; la CNSC citará con anticipación.</td></tr>
<tr><td>Verificación de requisitos, antecedentes y entrevista</td><td>Después de las pruebas escritas</td><td>Sin fechas publicadas todavía.</td></tr>
</tbody>
</table>
<p>Fuentes: CNSC, según {$ext('https://www.rtvcnoticias.com/actualidad/educacion/el-cronograma-del-concurso-docente-2026-se-movio-2027-aqui-le-contamos-las', 'RTVC Noticias')}, Portafolio y El Espectador (septiembre de 2026). Ojo con esto: la convocatoria sigue en etapa de planeación y <strong>hoy nadie puede inscribirse</strong>. Si alguien te ofrece "inscribirte ya" o "asegurarte un cupo", desconfía: el único canal es {$ext('https://simo.cnsc.gov.co/', 'SIMO')}, y la información oficial se publica en {$ext('https://www.cnsc.gov.co/', 'cnsc.gov.co')}.</p>
{$img('concurso-cronograma-linea-tiempo', 707, 'Línea de tiempo de agosto de 2026 a diciembre de 2027: sismo de 7,4 el 10 de agosto, OPEC preliminar el 19 de agosto, Decreto Legislativo 1384 el 9 de septiembre; inscripción gratuita de personas con discapacidad de diciembre a enero, inscripciones generales de enero a febrero de 2027 y pruebas escritas en el segundo semestre de 2027. Debajo, las cinco etapas en orden: aptitudes y competencias básicas eliminatoria con 60 puntos para docentes y 70 para directivos, psicotécnica clasificatoria, verificación de requisitos mínimos, valoración de antecedentes y entrevista', 'La ruta del concurso tras el ajuste: las fechas exactas llegarán con los acuerdos definitivos.')}

<h2>Cuántas vacantes hay y para qué cargos</h2>
<p>La OPEC preliminar que la CNSC publicó en agosto para observaciones habla de <strong>más de 28.000 vacantes</strong> en instituciones educativas oficiales, y algunos medios señalan que la cifra podría acercarse a 30.000. En julio, al cerrar la planeación, el {$ext('https://www.mineducacion.gov.co/portal/salaprensa/Comunicados/429606:Avanza-el-nuevo-proceso-de-seleccion-docente-con-26-741-vacantes-para-fortalecer-la-educacion-publica-del-pais', 'Ministerio de Educación')} hablaba de 26.741. Es normal que el número cambie: la oferta definitiva solo se conoce cuando salen los acuerdos, así que no te cases con una cifra exacta.</p>
<p>Los cargos incluyen docentes de aula, docentes orientadores, rectores, coordinadores y directores rurales. Además, la CNSC recibió unos 11.500 comentarios ciudadanos a los proyectos de acuerdo (según su matriz oficial de respuestas de septiembre de 2026), lo que puede traer ajustes en las reglas finales. Puedes consultar la oferta preliminar en SIMO, en la sección de proyectos de acuerdo, buscando el proceso de docentes y directivos docentes 2026 (población mayoritaria).</p>

<h2>A quién afecta y cómo</h2>
<ul>
<li><strong>Aspirantes a docente de aula u orientador.</strong> Tienen varios meses más para prepararse. La prueba eliminatoria exige, según el proyecto de anexo técnico, al menos 60 puntos sobre 100.</li>
<li><strong>Aspirantes a directivo docente.</strong> El listón es más alto: 70 puntos en la misma prueba. Si aspiras a rector, coordinador o director rural, revisa el artículo sobre <a href="/concurso-docente-2026-el-filtro-que-muchos-rectores-no-pasaran/">el filtro que muchos rectores no pasarán</a>.</li>
<li><strong>Personas con discapacidad.</strong> El proyecto de anexo técnico reserva como mínimo el 7 % de las vacantes definitivas para personas con discapacidad, con inscripción gratuita, en línea con la {$ext('https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=249256', 'Ley 2418 de 2024')}, que también garantiza ajustes razonables en las pruebas. Su inscripción va primero: entre diciembre de 2026 y enero de 2027.</li>
<li><strong>Docentes provisionales.</strong> Siguen en sus cargos mientras avanza el concurso. El aplazamiento les da tiempo, pero no cambia el fondo: la plaza se gana por mérito.</li>
</ul>

<h2>Cómo funcionan las etapas, en orden</h2>
<p>Las reglas definitivas estarán en el acuerdo y su anexo técnico. Mientras tanto, esto es lo que contempla el proyecto publicado para observaciones:</p>
<ol>
<li><strong>Prueba de aptitudes y competencias básicas (eliminatoria).</strong> Incluye lectura crítica, razonamiento cuantitativo, competencias como liderazgo, ética y trabajo en equipo, y conocimientos disciplinares y pedagógicos. Quien no alcance 60 puntos (docentes) o 70 (directivos docentes) sale del concurso.</li>
<li><strong>Prueba psicotécnica (clasificatoria).</strong> Se califica de 0 a 100 y suma, pero no elimina. Evalúa cómo actúas ante situaciones de la vida escolar.</li>
<li><strong>Verificación de requisitos mínimos.</strong> Se hace solo a quienes aprueban la prueba eliminatoria. Aquí se revisan los documentos que cargaste en SIMO, y si no cumples el requisito del empleo, quedas fuera aunque hayas sacado un gran puntaje.</li>
<li><strong>Valoración de antecedentes (clasificatoria).</strong> Suma tu formación (por ejemplo, maestría o doctorado) y tu experiencia, con más peso para la experiencia docente en la entidad territorial a la que te presentas.</li>
<li><strong>Entrevista (clasificatoria).</strong> El proyecto la incluye para docentes y directivos docentes, a cargo del ICFES o de la institución de educación superior que contrate la CNSC. Te dejo dos guías: <a href="/entrevista-del-concurso-docente-2026-docentes-preescolar-basica-media-todas-las-areas/">la entrevista para docentes</a> y <a href="/entrevista-de-directivos-docentes-2026-de-docente-a-lider/">la entrevista de directivos docentes</a>.</li>
</ol>
<p>Con los puntajes de todas las etapas se arman las listas de elegibles, y desde ahí se escogen las plazas y se hacen los nombramientos en período de prueba, como establece el Decreto 1278 de 2002. La conclusión práctica es clara: <strong>todo depende de pasar la primera prueba</strong>. Por eso el tiempo extra hay que invertirlo, sobre todo, ahí.</p>
<p class="notice"><strong>Mide hoy tu punto de partida.</strong> En <a href="/herramientas/simulacro-concurso-docente/">Fundales</a>, la plataforma de simulacros que creé para el concurso, haces simulacros tipo CNSC con juicio situacional, tiempo controlado y un informe de resultados. La cuenta es gratis durante un año, justo lo que falta para la prueba.</p>

<h2>Plan de estudio mes a mes: de octubre de 2026 a la prueba</h2>
<p>Doce meses es mucho tiempo si se usa con método y muy poco si se deja todo para el final. He visto colegas brillantes eliminados por estudiar a última hora y colegas con menos experiencia que pasaron porque practicaron con constancia. Este es el plan que yo seguiría:</p>
{$img('concurso-cronograma-plan-estudio', 660, 'Ocho tarjetas con el plan de estudio: octubre de 2026, diagnóstico con un simulacro completo; noviembre, documentos; diciembre, normativa base; enero y febrero de 2027, inscripción; marzo y abril, competencias básicas; mayo y junio, componente disciplinar y pedagógico; julio hasta la prueba, simulacros cronometrados; y después, verificación de requisitos, antecedentes y entrevista', 'Un plan orientativo: ajústalo cuando la CNSC publique las fechas exactas.')}
<ul>
<li><strong>Octubre de 2026: diagnóstico.</strong> Haz un simulacro completo sin estudiar antes y anota tu puntaje por componente. Revisa la OPEC preliminar en SIMO y define el cargo y la entidad territorial que te interesan.</li>
<li><strong>Noviembre: documentos.</strong> Reúne y escanea todo (más abajo te dejo la lista). Pide ya las certificaciones laborales: algunas entidades tardan semanas en expedirlas.</li>
<li><strong>Diciembre: normativa base.</strong> Ley 115 de 1994, Decreto 1278 de 2002, Ley 1620 de 2013, Decreto 1421 de 2017 y lo esencial del Decreto 1075 de 2015. No memorices artículos: entiende para qué sirve cada norma en un caso real. Si aspiras a la reserva para personas con discapacidad, este es tu mes de inscripción.</li>
<li><strong>Enero y febrero de 2027: inscripción.</strong> Lee el acuerdo completo antes de pagar. Elige el empleo con calma, paga los derechos de participación y carga los documentos con tiempo, no el último día.</li>
<li><strong>Marzo y abril: competencias básicas.</strong> Lectura crítica y razonamiento cuantitativo, de 30 a 40 preguntas por semana. Si las matemáticas te pesan, mi <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de Aptitud Matemática para docentes</a> trabaja exactamente ese tipo de razonamiento.</li>
<li><strong>Mayo y junio: lo disciplinar y lo pedagógico.</strong> Tu área, evaluación, currículo, inclusión y casos de juicio situacional. Una buena técnica es crear tus propios cuestionarios por tema: con el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> armas autoevaluaciones de tu área en minutos (tiene una <a href="/examenes/demo/">demostración gratuita</a>) y repasas justo lo que más fallas.</li>
<li><strong>Julio hasta la prueba: simulacros cronometrados.</strong> Uno completo cada quince días, en el mismo horario de la prueba. Lo importante no es hacer muchos, sino analizar cada error: por qué fallaste y qué vas a hacer distinto.</li>
<li><strong>Después de la prueba: VRM, antecedentes y entrevista.</strong> Revisa tus resultados, presenta reclamaciones dentro de los plazos y empieza a preparar la entrevista sin esperar a la citación.</li>
</ul>
<p>Si quieres la versión ampliada con estrategias por componente, la tienes en la <a href="/concurso-docente-2026-guia-definitiva-con-estrategias-normativa-y-simulacros-con-ia/">guía definitiva del Concurso Docente 2026</a>, y para docentes de aula en especial, en <a href="/concurso-docente-2026-docente-de-aula-la-estrategia-que-separa-a-los-preparados-de-los-eliminados/">la estrategia que separa a los preparados de los eliminados</a>.</p>

<h2>Documentos para tener listos en SIMO</h2>
<p>La verificación de requisitos mínimos y la valoración de antecedentes se hacen con lo que cargues en SIMO. Un documento ilegible o incompleto puede costarte el concurso. Esta es mi lista de chequeo:</p>
<ul>
<li>Cédula de ciudadanía ampliada, por ambas caras y legible.</li>
<li>Títulos de pregrado y posgrado, o actas de grado. Si estudiaste en el exterior, la convalidación del Ministerio de Educación.</li>
<li>Tarjeta o matrícula profesional, si tu profesión la exige.</li>
<li>Certificaciones laborales con fechas exactas de inicio y fin (día, mes y año), cargo, funciones y, si es docente, el nivel o el área. La de la secretaría de educación debe ser expedida por la autoridad competente.</li>
<li>Certificados de educación para el trabajo o cursos, si el acuerdo los valora.</li>
<li>Para la reserva de discapacidad, el soporte que pida el acuerdo. Hoy, en Colombia, el documento oficial es el certificado de discapacidad que se tramita según la Resolución 1239 de 2022 del Ministerio de Salud; si no lo tienes, empieza el trámite ya.</li>
<li>Tu hoja de vida en SIMO actualizada y un correo que revises a diario, porque por ahí llegan las citaciones.</li>
</ul>
<p>Guarda todo en PDF con nombres claros, como "titulo-licenciatura.pdf" o "certificacion-sed-2019-2024.pdf", en una carpeta en la nube.</p>

<h2>Errores comunes que veo cada concurso</h2>
<ul>
<li><strong>Bajar el ritmo porque "todavía falta mucho".</strong> El tiempo extra solo sirve si se usa. Fija desde ya un horario fijo de estudio, aunque sean 45 minutos diarios.</li>
<li><strong>Elegir el empleo a la carrera.</strong> Inscribirse en un cargo para el que no cumples el requisito exacto de título es la forma más triste de quedar fuera: pasas la prueba y te eliminan en la verificación.</li>
<li><strong>Certificaciones incompletas.</strong> Sin fechas exactas o sin funciones, la experiencia no se cuenta como esperas.</li>
<li><strong>Estudiar solo normas.</strong> La prueba evalúa competencias. Más que recitar artículos, tienes que saber aplicarlos a un caso.</li>
<li><strong>Creer en fechas y cifras que circulan por redes.</strong> Hasta que salgan los acuerdos definitivos, todo es preliminar. Confía solo en la CNSC.</li>
<li><strong>No practicar con tiempo.</strong> Mucha gente sabe las respuestas, pero no termina la prueba. El control del tiempo se entrena.</li>
</ul>

<h2>Consejos prácticos para aprovechar los meses extra</h2>
<ul>
<li><strong>Estudia en pequeño y con constancia.</strong> Cinco sesiones cortas rinden más que una maratón el domingo.</li>
<li><strong>Lleva un cuaderno de errores.</strong> Cada pregunta que falles va allí, con la explicación en tus propias palabras. Repásalo cada semana.</li>
<li><strong>Usa tu práctica diaria como laboratorio.</strong> Lo que trabajas en clase sobre evaluación, inclusión o convivencia es materia de la prueba. Si quieres ver cómo se aplica el Decreto 1421 en un caso real, prueba gratis <a href="/herramientas/piar/">PIAR con IA</a>: construir un PIAR completo es un repaso práctico de ajustes razonables.</li>
<li><strong>Libera tiempo de planeación.</strong> Si entre clases, planillas y reuniones no te queda tiempo para estudiar, el <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> trae recetas por materia, alineadas con el currículo colombiano, para preparar guías y evaluaciones en menos tiempo, siempre con tu revisión.</li>
<li><strong>Estudia en grupo, pero practica solo.</strong> Discutir casos con colegas aclara dudas; la prueba, en cambio, la presentas solo y contra el reloj.</li>
<li><strong>Cuida la logística.</strong> Si vives en una zona afectada por el sismo, revisa desde ya cómo llegarías a la ciudad de presentación de la prueba y no dudes en pedir información a la CNSC.</li>
</ul>
<p>Para las dudas puntuales, como el costo de la inscripción, cuántos empleos puedes elegir o si te sirve tu título, revisa <a href="/20-preguntas-frecuentes-sobre-el-concurso-docente/">las 20 preguntas frecuentes sobre el Concurso Docente</a>, y si quieres practicar con preguntas explicadas, los <a href="/simulacros-concurso-docente-con-respuestas/">simulacros con respuestas</a>.</p>

<p class="notice"><strong>Empieza hoy, no en julio.</strong> Crea tu cuenta gratuita en <strong>Fundales</strong> y úsala durante un año: simulacros tipo CNSC, juicio situacional, tiempo controlado e informes de resultados para saber exactamente qué reforzar. Si te cuesta el razonamiento cuantitativo, complementa con el curso de Aptitud Matemática; y para practicar por temas, crea tus cuestionarios con el Generador de exámenes con IA.</p>
<p><a class="btn-link" href="/herramientas/simulacro-concurso-docente/">Hacer mi simulacro gratis en Fundales</a></p>

<h2>Para pensar</h2>
<p>El concurso promete medir a todos con la misma vara: la misma prueba, el mismo puntaje mínimo, la misma lista de elegibles. Pero no todos llegan desde el mismo lugar. Una docente que estudia con buen internet en Bogotá y un maestro que sigue dando clase en una escuela del Chocó que el sismo dejó sin techo presentarán la misma prueba, y el ajuste del cronograma les dio a ambos los mismos meses extra. <strong>¿Es eso igualdad de oportunidades o solo igualdad de reglas? ¿Debería el mérito medirse teniendo en cuenta desde dónde parte cada aspirante, o cualquier compensación terminaría debilitando la idea misma de mérito?</strong></p>
HTML,
];
