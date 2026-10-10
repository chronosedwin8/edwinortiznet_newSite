<?php

declare(strict_types=1);

// "Ley 1620 de 2013 y Decreto 1965". Fuentes: texto compilado del Decreto 1075 de 2015, arts. 2.3.5.2.3.1 a 2.3.5.2.3.6 y 2.3.5.4.2.1 a 2.3.5.4.2.14 (origen Decreto 1965 de 2013), consultado el 10-oct-2026; composición del comité (Ley 1620, art. 12) verificada en fuentes secundarias, con aviso de cotejar. Simulador verificado en Excel 16: 3 sesionan, 1 sin presidente, 2 sin quórum. Casos de práctica no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ley-1620/' . $name;
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
<p>Un estudiante denuncia que un grupo lo humilla por un chat. La coordinadora toma nota. La rectora está de viaje. El comité de convivencia "se reúne en dos meses". Mientras tanto, nadie sabe si debe llamar a la familia, a quién avisar ni quién decide qué. En muchos colegios, la convivencia escolar se atiende con buena voluntad y sin ruta, y la <strong>Ley 1620 de 2013 y el Decreto 1965 de 2013</strong> (hoy compilado en el Decreto Único Reglamentario 1075 de 2015) existen justamente para que no sea así: crean un sistema, un comité en cada colegio y una ruta con pasos, responsables y plazos.</p>
<p>Este artículo estudia ese marco con la estructura <strong>norma (con su fuente) + interpretación + caso con respuesta justificada</strong>. Incluye una <a href="/descargas/concurso-docente/ficha-estudio-ley-1620-decreto-1965.xlsx">ficha de estudio en Excel</a> con el mapa de normas, los siete integrantes del comité (con una lista para comprobar si tu colegio los tiene), un <strong>simulador de si el comité puede sesionar</strong>, los cuatro componentes de la ruta y doce tarjetas. Textos del Decreto 1075 consultados el 10 de octubre de 2026; el simulador se verificó en Microsoft Excel 16. Los tipos de situación (I, II y III) se explican con más detalle en <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflicto, indisciplina y violencia escolar</a>.</p>
<p class="notice"><strong>Advertencias.</strong> Los resúmenes son míos, no literales: <strong>la fuente es el texto vigente</strong> de la Ley 1620 y del Decreto 1075 (Presidencia, Ministerio de Educación, Función Pública). La composición del comité (art. 12 de la Ley 1620) la verifiqué en varias fuentes secundarias; cotéjala con el texto oficial. Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>, y el simulador usa un quórum de ejemplo (el real lo fija el reglamento de cada comité). Nadie puede garantizarte un resultado en el concurso. Esto no es asesoría jurídica ni psicológica.</p>

<h2>El Sistema Nacional de Convivencia Escolar</h2>
<p>La Ley 1620 de 2013 creó el <strong>Sistema Nacional de Convivencia Escolar y Formación para el Ejercicio de los Derechos Humanos, la Educación para la Sexualidad y la Prevención y Mitigación de la Violencia Escolar</strong>, con instancias en el nivel nacional, territorial (municipal, distrital y departamental) y en cada establecimiento educativo. El Decreto 1965 de 2013 la reglamentó, y ambos están hoy en el Título 5 de la Parte 3 del Libro 2 del Decreto 1075 de 2015. La idea central: la convivencia escolar no es un asunto de cada docente ni solo del rector, sino un sistema con responsabilidades compartidas entre el Estado, las familias, los colegios y la sociedad (la <em>corresponsabilidad</em>).</p>

<h2>El Comité Escolar de Convivencia</h2>
<p><strong>Quiénes deben tenerlo.</strong> Según el artículo 2.3.5.2.3.1 del Decreto 1075 (art. 22 del Decreto 1965), todas las instituciones educativas y centros educativos del país, oficiales y no oficiales, deben conformar el Comité Escolar de Convivencia, encargado de apoyar la promoción y el seguimiento de la convivencia escolar, la educación para el ejercicio de los derechos humanos, sexuales y reproductivos, el desarrollo y la aplicación del manual de convivencia y la prevención y mitigación de la violencia escolar. Su reglamento debe hacer parte integral del manual de convivencia.</p>
<p><strong>Quiénes lo integran.</strong> Según el artículo 12 de la Ley 1620: el <strong>rector</strong> (que lo preside), el <strong>personero estudiantil</strong>, el <strong>docente con función de orientación</strong>, el <strong>coordinador</strong> (cuando exista el cargo), el <strong>presidente del consejo de padres de familia</strong>, el <strong>presidente del consejo de estudiantes</strong> y <strong>un docente que lidere procesos o estrategias de convivencia escolar</strong>. Son siete, y la hoja <em>Comite</em> de la ficha los lista para que marques cuáles existen en tu colegio.</p>
<p><strong>Centros educativos.</strong> En los centros educativos (típicamente rurales) preside el director y, en su ausencia, el docente que lidera procesos de convivencia; donde no hay integrantes suficientes, el comité se integra como mínimo con el representante de los docentes, el presidente del consejo de padres y el representante de los estudiantes, y lo preside el docente (parágrafos 1 y 2 del mismo artículo).</p>
<p><strong>Cómo funciona.</strong> Sesiona <strong>como mínimo una vez cada dos meses</strong>; las sesiones extraordinarias las convoca el presidente cuando las circunstancias lo exijan o a solicitud de cualquier integrante (art. 2.3.5.2.3.2). El <strong>quórum decisorio</strong> es el que establezca su reglamento y, en cualquier caso, <strong>no puede sesionar sin la presencia del presidente</strong> (art. 2.3.5.2.3.3). De todas las sesiones se levanta un acta y el comité debe garantizar la intimidad y la confidencialidad de los datos personales (art. 2.3.5.2.3.4).</p>
<p>La hoja <em>Sesion</em> del libro simula esas reglas con seis casos: con todos presentes puede sesionar; si el rector no asiste y "preside el coordinador", <strong>no</strong> puede sesionar (en una institución educativa la regla es la presencia del presidente); con el presidente y tres integrantes, sesiona si el quórum del reglamento es de cuatro y no si es de cinco; con el presidente y solo dos integrantes, no hay quórum de cuatro. Resultado del libro: 3 casos pueden sesionar, 1 no puede por falta del presidente y 2 por falta de quórum (verificado en Excel). Es un ejercicio de estudio: <strong>el quórum real lo fija el reglamento de cada comité</strong>.</p>
{{img:ruta}}

<h2>La Ruta de Atención Integral: cuatro componentes</h2>
<ul>
<li><strong>Promoción</strong> (art. 2.3.5.4.2.2): políticas institucionales que fomentan la convivencia y mejoran el clima escolar para el ejercicio real y efectivo de los derechos humanos, sexuales y reproductivos.</li>
<li><strong>Prevención</strong> (art. 2.3.5.4.2.3): acciones que buscan intervenir oportunamente en comportamientos que podrían afectar esos derechos, para evitar que se vuelvan patrones de interacción; incluye identificar los riesgos de ocurrencia de las situaciones más comunes a partir del clima escolar y del análisis de las características del contexto.</li>
<li><strong>Atención</strong> (art. 2.3.5.4.2.4): asistir a los miembros de la comunidad educativa ante las situaciones que afectan la convivencia, mediante los protocolos internos y, cuando sea necesario, activando los protocolos de otras entidades.</li>
<li><strong>Seguimiento</strong> (art. 2.3.5.4.2.14): verificar si las soluciones fueron efectivas y reportar los casos al sistema de información unificado.</li>
</ul>
<p><strong>Principios.</strong> En todas las acciones de los cuatro componentes debe garantizarse la aplicación de los principios de protección integral, incluido el <strong>derecho a no ser revictimizado</strong>, el interés superior de los niños, las niñas y los adolescentes, la prevalencia de los derechos, la corresponsabilidad, la exigibilidad de los derechos, la perspectiva de género y los derechos de los grupos étnicos (arts. 7 a 13 de la Ley 1098 de 2006), además de la proporcionalidad de las medidas y la protección de datos (Constitución y Ley 1581 de 2012) (art. 2.3.5.4.2.1). Ver también <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución, arts. 13, 44 y 67</a>.</p>

<h2>Qué hacer al conocer una situación</h2>
{{img:pasos}}
<ol>
<li><strong>Registrar</strong> la queja o información, con reserva, por escrito y por el canal definido en el protocolo del colegio (el protocolo debe definir cómo se inicia, recibe y radica una queja y proteger a quien informa; art. 2.3.5.4.2.7).</li>
<li><strong>Clasificar</strong> la situación como Tipo I, II o III (art. 2.3.5.4.2.6; ver el artículo sobre <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">tipos de situaciones</a>).</li>
<li><strong>Atender y proteger:</strong> atención en salud si hay daño, medidas para proteger a los involucrados de posibles acciones en su contra, acciones pedagógicas y restaurativas según el tipo.</li>
<li><strong>Informar</strong> a los padres, madres o acudientes de los estudiantes involucrados (de inmediato en los Tipos II y III) y, en el Tipo III, <strong>el presidente del comité pone de inmediato la situación en conocimiento de la Policía Nacional</strong> por el medio más expedito, sin esperar a la siguiente sesión.</li>
<li><strong>Hacer seguimiento</strong> y dejar acta, y reportar el caso al sistema de información unificado.</li>
</ol>
<p>El protocolo del colegio debe incluir, entre otros contenidos mínimos, los mecanismos para garantizar la intimidad y la confidencialidad, las estrategias de solución con enfoque pedagógico, las consecuencias proporcionales, las formas de seguimiento y un directorio actualizado de entidades (Policía, Fiscalía, Defensoría, Comisaría de Familia, ICBF, entidades de salud, entre otras) (art. 2.3.5.4.2.7).</p>

<h2>Dos casos de aplicación (práctica, no oficial)</h2>
<h3>Caso 1</h3>
<p><strong>Situación.</strong> En una institución educativa oficial se debe decidir sobre un caso Tipo II. El día de la sesión, la rectora no puede asistir. Seis de los siete integrantes están presentes, y el coordinador propone presidir la sesión y decidir "para no dejar el caso sin atender".</p>
<p><strong>Pregunta.</strong> ¿Qué dice la norma sobre esa sesión?</p>
<ol type="A">
<li>Puede sesionar, porque hay seis de siete integrantes.</li>
<li>No puede sesionar sin la presencia del presidente; hay que reprogramarla (o convocar de forma extraordinaria cuando el presidente pueda asistir) sin dejar de atender urgencias de protección.</li>
<li>Puede sesionar si el coordinador firma el acta.</li>
<li>La norma no dice nada sobre la ausencia del presidente.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 2.3.5.2.3.3 dice que el quórum decisorio es el del reglamento y que, "en cualquier caso", el comité no puede sesionar sin el presidente. Que haya seis de siete integrantes no sustituye esa regla. Lo que sí puede y debe hacer el colegio mientras tanto es atender las medidas urgentes (atención en salud, protección de los involucrados e información a las familias), que no dependen de la sesión del comité. En los <em>centros educativos</em>, en cambio, la norma prevé que presida el docente líder en ausencia del director.</p>
<h3>Caso 2</h3>
<p><strong>Situación.</strong> Una coordinadora se entera de que unos estudiantes difundieron fotos íntimas de una compañera por internet. El comité sesiona ordinariamente cada dos meses y la próxima reunión es en seis semanas. Ella piensa esperar a esa reunión "para que el comité decida cómo manejarlo".</p>
<p><strong>Pregunta.</strong> ¿Cuál es la actuación más sólida?</p>
<ol type="A">
<li>Esperar a la sesión ordinaria para que el comité decida.</li>
<li>Activar de inmediato el protocolo de situaciones Tipo III: garantizar atención en salud y protección, informar a las familias, y el presidente del comité debe poner el caso en conocimiento de la Policía Nacional por el medio más expedito y citar al comité según el manual; sin esperar la sesión ordinaria.</li>
<li>Resolverlo con una mediación entre la estudiante afectada y los que difundieron las fotos.</li>
<li>Pedir a las familias que lo resuelvan entre ellas, para proteger la reputación del colegio.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> La difusión de fotos íntimas de una menor puede constituir un presunto delito, lo que corresponde a una situación Tipo III. El protocolo del artículo 2.3.5.4.2.10 exige la atención inmediata en salud si hay daño, informar de inmediato a los padres, que el presidente del comité informe a la Policía Nacional por el medio más expedito, citar al comité según el manual y adoptar de inmediato medidas de protección, incluso si el caso ya fue puesto en conocimiento de las autoridades. A espera un plazo que la norma no autoriza; C ignora la gravedad y puede revictimizar (principio del artículo 2.3.5.4.2.1); D deja la protección de una menor en manos de las familias. Ambos casos son ejercicios míos, no preguntas oficiales.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La Ley 1620 fue una respuesta a la preocupación por el acoso y la violencia escolar, con una arquitectura que combina promoción, prevención, atención y seguimiento, y que obliga a todos los colegios, oficiales y privados, a tener un comité y un protocolo. En la región, varios países cuentan con leyes o políticas de convivencia escolar y de prevención del acoso, con enfoques distintos (algunos más pedagógicos, otros más sancionatorios); en el mundo, los programas que funcionan combinan políticas claras, formación de docentes, trabajo con familias y atención a las víctimas, y la evidencia sobre los programas varía según el contexto. Para los <strong>aspirantes</strong>, el reto es entender la lógica del sistema (quién decide qué y cuándo se actúa de inmediato) más que memorizar artículos; para los <strong>docentes</strong>, conocer el protocolo del colegio y su papel en él; para los <strong>directivos</strong>, hacer que el comité funcione en la práctica; y para las <strong>familias</strong>, saber que el colegio debe informarles y que la confidencialidad no es silencio. Ver también <a href="/ausentismo-escolar-excel-asistencia-ausentismo-cronico-rachas-patrones/">ausentismo escolar</a> (una señal que el comité puede usar en prevención).</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a> y la serie: <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">Ley 115 y Decreto 1860</a>, <a href="/concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion/">la Constitución</a>, <a href="/concurso-docente-decreto-ley-1278-de-2002-estatuto-ingreso-escalafon-evaluacion-retiro/">el Decreto Ley 1278</a> y <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">el SIEE</a>. Entrena el análisis de casos con <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a>, analiza tus errores con el <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">plan de mejora</a> y registra tu avance en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a>. Refuerza el razonamiento cuantitativo con el <a href="/producto/curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021/">curso de aptitud matemática</a>. Si trabajas en inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué crea la Ley 1620 de 2013?</h3>
<p>El Sistema Nacional de Convivencia Escolar y Formación para el Ejercicio de los Derechos Humanos, la Educación para la Sexualidad y la Prevención y Mitigación de la Violencia Escolar, con comités en los niveles nacional, territorial y de cada colegio.</p>
<h3>¿Quién integra el Comité Escolar de Convivencia?</h3>
<p>El rector (que lo preside), el personero estudiantil, el docente con función de orientación, el coordinador (si existe), el presidente del consejo de padres, el presidente del consejo de estudiantes y un docente que lidere procesos de convivencia (Ley 1620, art. 12; verifica el texto vigente).</p>
<h3>¿Cada cuánto debe reunirse el comité?</h3>
<p>Como mínimo una vez cada dos meses, con sesiones extraordinarias cuando se requieran (Decreto 1075 de 2015, art. 2.3.5.2.3.2).</p>
<h3>¿Puede sesionar el comité sin el presidente?</h3>
<p>No: en cualquier caso, el comité no puede sesionar sin la presencia del presidente (art. 2.3.5.2.3.3).</p>
<h3>¿Cuáles son los componentes de la ruta de atención?</h3>
<p>Promoción, prevención, atención y seguimiento.</p>

<p class="notice"><strong>Revisa el comité de tu colegio.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-ley-1620-decreto-1965.xlsx">ficha de estudio</a>, marca cuáles de los siete integrantes existen en tu colegio, lee su reglamento (el quórum y las sesiones) y prueba el simulador con tus propios números.</p>

<h2>Para pensar</h2>
<p>Una ruta de atención puede estar perfectamente escrita y fallar en el momento de la verdad: la persona que sabe, no está; el que está, no sabe. <strong>¿Qué pasaría en tu colegio si hoy un estudiante pidiera ayuda por una situación grave: quién lo escucharía, qué haría en la primera hora y cómo sabría el estudiante que su caso está en manos del sistema? Y ¿cuántos de los adultos de la institución podrían contestar esas preguntas sin buscar el manual?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ruta}}' => $img('ley-1620-ruta', 499, 'Tabla con los cuatro componentes de la Ruta de Atención Integral, qué busca cada uno y un ejemplo: promoción, prevención, atención y seguimiento.', 'Cuatro componentes, cuatro preguntas.'),
    '{{img:pasos}}' => $img('ley-1620-pasos', 467, 'Cinco pasos al conocer una situación de convivencia: registrar, clasificar, atender y proteger, informar y hacer seguimiento.', 'Cinco pasos, con confidencialidad.'),
]);

return [
    'slug' => 'concurso-docente-ley-1620-decreto-1965-comite-convivencia-ruta-atencion',
    'title' => 'Ley 1620 y Decreto 1965 en el Concurso Docente: el Comité de Convivencia, la ruta de atención y cómo se actúa',
    'excerpt' => 'El Sistema Nacional de Convivencia Escolar según la Ley 1620 y el Decreto 1965 (compilado en el 1075): el Comité Escolar de Convivencia, sus siete integrantes, sus reglas de sesión, la ruta de atención y dos casos resueltos, con un simulador en Excel.',
    'seo_title' => 'Ley 1620 y Decreto 1965: Comité de Convivencia',
    'seo_description' => 'Estudia la Ley 1620 y el Decreto 1965: el Comité Escolar de Convivencia, su quórum, la ruta de atención y dos casos resueltos, con ficha y simulador en Excel.',
    'focus_keyword' => 'Ley 1620 Decreto 1965 comité de convivencia',
    'cover' => '/assets/img/articulos/ley-1620/ley-1620-portada',
    'cover_alt' => 'Portada "Ley 1620 y Decreto 1965: el comité, la ruta de atención y cómo se actúa" con una tarjeta: 7 integrantes tiene el Comité Escolar de Convivencia; no puede sesionar sin su presidente.',
    'published_at' => '2027-02-12 12:00:00',
    'content_html' => $html,
];
