<?php

declare(strict_types=1);

// "Constitución arts. 13, 44 y 67". Textos consultados el 10-oct-2026 (resumen propio) en fuente que reproduce la Constitución Política de 1991 (constitucioncolombia.com) y a contrastar con Corte Constitucional/Senado. Ley 12 de 1991 y Ley 1346 de 2009 mencionadas con aviso de verificación. Ficha verificada en Excel 16 (13: 5, 44: 6, 67: 6; 2 con los tres). Casos de práctica no oficiales.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/constitucion-13-44-67/' . $name;
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
<p>Si un docente se pregunta en qué se apoya para decir que una niña con discapacidad tiene derecho a estar en su aula, que un estudiante migrante no puede ser rechazado por falta de papeles o que una situación de violencia exige actuar de inmediato, la respuesta casi siempre empieza en tres artículos de la Constitución Política de 1991: el <strong>13</strong> (igualdad), el <strong>44</strong> (derechos de los niños) y el <strong>67</strong> (educación). Las leyes y los decretos que se estudian para el Concurso Docente son, en buena parte, el desarrollo de esas tres ideas.</p>
<p>Este artículo presenta los tres artículos con la estructura <strong>norma (con su fuente oficial) + interpretación + caso con respuesta justificada</strong>, y una <a href="/descargas/concurso-docente/ficha-estudio-constitucion-13-44-67.xlsx">ficha de estudio en Excel</a> con el mapa de los artículos, una matriz que relaciona decisiones cotidianas del aula con cada artículo y doce tarjetas. Textos consultados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Los resúmenes son míos, no literales: <strong>la fuente es el texto vigente de la Constitución</strong> (Corte Constitucional, Senado de la República, Presidencia) y los artículos pueden reformarse por acto legislativo. Las preguntas de un concurso se basan en lo que indiquen la convocatoria y su anexo técnico, publicados en SIMO. Los casos son ejercicios míos, <strong>no preguntas oficiales</strong>, y nadie puede garantizarte un resultado. Esto no es asesoría jurídica.</p>

<h2>Artículo 13: igualdad</h2>
<p><strong>Qué dice.</strong> Todas las personas nacen libres e iguales ante la ley, reciben la misma protección y trato de las autoridades y gozan de los mismos derechos, libertades y oportunidades, sin discriminación por sexo, raza, origen nacional o familiar, lengua, religión, opinión política o filosófica. El Estado promoverá las condiciones para que la igualdad sea <strong>real y efectiva</strong>, adoptará medidas en favor de los grupos discriminados o marginados, protegerá especialmente a las personas que, por su condición económica, física o mental, se encuentren en circunstancia de <strong>debilidad manifiesta</strong>, y sancionará los abusos o maltratos que contra ellas se cometan.</p>
<p><strong>Interpretación.</strong> El artículo contiene dos ideas distintas, y la confusión entre ellas explica muchos errores: la <em>igualdad formal</em> (la ley trata a todos igual y no discrimina) y la <em>igualdad real o material</em> (a veces, para que dos personas tengan las mismas oportunidades, hay que tratarlas de forma diferente: ajustar, apoyar, compensar). Para un docente, tratar igual no es tratar idéntico: el estudiante que usa un lector de pantalla o necesita más tiempo para una evaluación no recibe un privilegio, recibe las condiciones para participar en igualdad. Esta idea se desarrolla en normas específicas sobre inclusión, que se estudian en artículos posteriores de esta serie.</p>
{{img:articulos}}

<h2>Artículo 44: los derechos de los niños</h2>
<p><strong>Qué dice.</strong> Son derechos fundamentales de los niños la vida, la integridad física, la salud y la seguridad social, la alimentación equilibrada, su nombre y nacionalidad, tener una familia y no ser separados de ella, el cuidado y el amor, la educación y la cultura, la recreación y la libre expresión de su opinión. Serán protegidos contra toda forma de abandono, violencia física o moral, secuestro, venta, abuso sexual, explotación laboral o económica y trabajos riesgosos. Gozan además de los derechos consagrados en la Constitución, las leyes y los tratados internacionales ratificados por Colombia. <strong>La familia, la sociedad y el Estado</strong> tienen la obligación de asistir y proteger al niño; <strong>cualquier persona</strong> puede exigir de la autoridad competente su cumplimiento y la sanción de los infractores; y los derechos de los niños <strong>prevalecen</strong> sobre los derechos de los demás.</p>
<p><strong>Interpretación.</strong> Tres consecuencias prácticas. Primera: la educación aparece en la lista de derechos fundamentales del niño, de modo que no es una concesión. Segunda: la protección es una responsabilidad compartida (familia, sociedad y Estado), y el docente es parte de la "sociedad": no puede ignorar una situación de violencia argumentando que "es un asunto de la familia". Tercera: "prevalecen" no significa que los derechos de los niños no admitan ponderación; significa que, cuando entran en conflicto con los de otros, la Constitución les da un peso especial. El desarrollo de este principio se encuentra en la Ley 1098 de 2006 (Código de la Infancia y la Adolescencia), que también se estudia más adelante en esta serie. La opinión del niño ("libre expresión de su opinión") tiene una consecuencia directa en el aula: <strong>escuchar al estudiante</strong> es una obligación, no un favor.</p>

<h2>Artículo 67: la educación</h2>
<p><strong>Qué dice.</strong> La educación es <strong>un derecho de la persona y un servicio público que tiene una función social</strong>; con ella se busca el acceso al conocimiento, a la ciencia, a la técnica y a los demás bienes y valores de la cultura. Formará al colombiano en el respeto a los derechos humanos, a la paz y a la democracia, y en la práctica del trabajo y la recreación, para el mejoramiento cultural, científico, tecnológico y para la protección del ambiente. El Estado, la sociedad y la familia son responsables de la educación, que será <strong>obligatoria entre los cinco y los quince años de edad</strong> y comprenderá como mínimo un año de preescolar y nueve de educación básica. La educación será gratuita en las instituciones del Estado, sin perjuicio del cobro de derechos académicos a quienes puedan sufragarlos. Corresponde al Estado regular y ejercer la suprema inspección y vigilancia de la educación para velar por su calidad, por el cumplimiento de sus fines y por la mejor formación moral, intelectual y física de los educandos, garantizar el adecuado cubrimiento del servicio y <strong>asegurar a los menores las condiciones necesarias para su acceso y permanencia</strong> en el sistema educativo. La Nación y las entidades territoriales participan en la dirección, financiación y administración de los servicios educativos estatales, en los términos de la Constitución y la ley.</p>
<p><strong>Interpretación.</strong> Hay tres confusiones frecuentes. (1) <em>Obligatoria no es lo mismo que "limitada a"</em>: la obligatoriedad entre los cinco y los quince años no significa que quien tiene dieciséis años pierda el derecho a la educación; el artículo habla del derecho en general y del deber del Estado de garantizar el acceso y la permanencia. (2) <em>Gratuidad:</em> el artículo la establece en las instituciones del Estado, con la salvedad de los derechos académicos para quienes puedan pagarlos; la reglamentación posterior (que se consulta en el Decreto 1075 de 2015) concreta cómo se aplica, y conviene verificar el texto vigente. (3) <em>Permanencia:</em> no basta con matricular; el Estado debe asegurar las condiciones para que el estudiante continúe. Por eso las barreras de transporte, de alimentación, de conectividad o de discriminación son cuestiones del artículo 67, no solo "problemas del colegio". Para el vínculo con el ausentismo, ver <a href="/ausentismo-escolar-excel-asistencia-ausentismo-cronico-rachas-patrones/">ausentismo escolar en Excel</a>.</p>

<h2>Cómo razonar un caso desde la Constitución</h2>
{{img:razonar}}
<ol>
<li><strong>Identifica el derecho en juego:</strong> igualdad, un derecho del niño, educación.</li>
<li><strong>Identifica quién está obligado:</strong> Estado, sociedad o familia (casi siempre más de uno).</li>
<li><strong>Busca la desventaja:</strong> ¿hay una circunstancia de debilidad manifiesta que exige una protección especial?</li>
<li><strong>Busca el desarrollo:</strong> la ley o el decreto que concreta el principio (el artículo constitucional es el fundamento; la norma de desarrollo, el procedimiento).</li>
<li><strong>Justifica</strong> por qué las otras opciones fallan.</li>
</ol>
<p>La hoja <em>Matriz_aula</em> de la ficha lo practica con diez decisiones cotidianas. Por ejemplo, admitir a un estudiante con discapacidad y atender a un estudiante migrante sin documentos involucran los tres artículos; adaptar una evaluación involucra el 13 y el 67; responder a una situación de violencia entre estudiantes, el 44. Entre las diez decisiones, el artículo 13 aparece en 5, el 44 en 6 y el 67 en 6, y dos decisiones activan los tres (verificado en Excel).</p>

<h2>Dos casos de aplicación (práctica, no oficial)</h2>
<h3>Caso 1</h3>
<p><strong>Situación.</strong> Una institución educativa oficial recibe la solicitud de matrícula de un niño con discapacidad motora. La secretaría responde: "Este año no tenemos personal para apoyarlo, intente en otra institución".</p>
<p><strong>Pregunta.</strong> ¿Qué fundamento constitucional es más sólido para cuestionar esa respuesta?</p>
<ol type="A">
<li>El artículo 67 solo obliga a prestar el servicio, y la institución puede decidir a quién acepta.</li>
<li>Los artículos 13, 44 y 67 en conjunto: el niño tiene derecho a la educación (art. 44), el Estado debe asegurar acceso y permanencia a los menores (art. 67) y debe promover condiciones de igualdad real y proteger especialmente a quienes están en debilidad manifiesta (art. 13); la falta de apoyos es una barrera que el Estado debe superar, no un motivo para excluir.</li>
<li>La Constitución no dice nada sobre estudiantes con discapacidad, así que decide cada colegio.</li>
<li>Solo la familia es responsable de buscar un colegio adecuado.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> La educación es un derecho (art. 67) y un derecho fundamental del niño (art. 44); el Estado debe asegurar acceso y permanencia, y el artículo 13 exige igualdad real y protección reforzada para quienes están en circunstancia de debilidad manifiesta, como puede ocurrir con una discapacidad. A trata el artículo 67 como si solo regulara la prestación; C ignora que los principios constitucionales aplican sin necesidad de mención expresa de cada grupo; D desconoce que la responsabilidad es compartida entre Estado, sociedad y familia. El procedimiento y los apoyos concretos se estudian en las normas de desarrollo (por ejemplo, el Decreto 1421 de 2017, en un artículo posterior de la serie).</p>
<h3>Caso 2</h3>
<p><strong>Situación.</strong> Un estudiante de 16 años que cursa décimo grado quiere continuar y la coordinadora le dice que "como la educación solo es obligatoria hasta los quince años, no estamos obligados a recibirlo".</p>
<p><strong>Pregunta.</strong> ¿Qué falla en ese razonamiento?</p>
<ol type="A">
<li>Nada: la obligación del Estado termina a los quince años.</li>
<li>Confunde la obligatoriedad (un rango de edades) con el alcance del derecho a la educación y del deber del Estado de garantizar el acceso y la permanencia, que no se agotan a los quince años.</li>
<li>La obligatoriedad aplica solo a los estudiantes de colegios privados.</li>
<li>Los mayores de quince años solo pueden estudiar en jornada nocturna.</li>
</ol>
<p><strong>Respuesta justificada: B.</strong> El artículo 67 dice que la educación es un derecho y un servicio público, obligatoria entre los cinco y los quince años; eso fija un mínimo obligatorio, no un tope del derecho. C y D son afirmaciones sin sustento en el artículo. Los criterios de admisión y de permanencia en la educación media se rigen por las normas de desarrollo y por el manual de convivencia y el SIEE de cada institución. Ambos casos son ejercicios míos, no preguntas oficiales.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>La Constitución de 1991 puso los derechos de los niños y la educación en el centro, y reconoció que los tratados internacionales ratificados por Colombia complementan los derechos que enumera (art. 44), entre ellos la Convención sobre los Derechos del Niño de 1989, aprobada en Colombia por la Ley 12 de 1991, y la Convención sobre los Derechos de las Personas con Discapacidad, aprobada por la Ley 1346 de 2009 (verifica las normas en fuentes oficiales). En la región, la mayoría de los países consagran el derecho a la educación en sus constituciones, con diferencias en la edad obligatoria y en la gratuidad; en el mundo, la educación es un derecho reconocido en la Declaración Universal de Derechos Humanos y en varios tratados. Para los <strong>aspirantes</strong>, el reto es pasar de recitar artículos a explicar qué obligan a hacer; para los <strong>docentes</strong>, saber que estos artículos fundamentan su deber de proteger, escuchar y ajustar; para los <strong>directivos</strong>, que las barreras de acceso y permanencia son cuestión de derechos y no de buena voluntad; y para las <strong>familias</strong>, que tienen derechos y responsabilidades compartidas con el Estado y la sociedad.</p>

<h2>Practica y organiza tu preparación</h2>
<p>Practica en <a href="https://fundales.com/">Fundales</a>, mi plataforma de simulacros del Concurso Docente (cuentas gratuitas durante un año; es práctica no oficial, no material de la CNSC), o en la <a href="/herramientas/simulacro-concurso-docente/">herramienta de simulacro</a> de este sitio. Estudia la normativa con el <a href="/concurso-docente-estudiar-normativa-sin-memorizar-mapa-normativo/">mapa normativo</a> y la serie que empezó con <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">la Ley 115 y el Decreto 1860</a>, entrena el análisis de casos con <a href="/concurso-docente-juicio-situacional-analizar-caso-respuestas-aparentemente-correctas/">juicio situacional</a> y registra tu avance en el <a href="/concurso-docente-indicadores-de-progreso-tablero-de-preparacion/">tablero de progreso</a>. Para el vínculo con la inclusión, conoce <a href="/herramientas/piar/">PIAR con IA</a>.</p>
{{productos:curso-aptitud-matematica-para-docentes-y-profesionales-concurso-docentes-y-directivos-docentes-2021}}
<p>Sigue leyendo: <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">del simulacro al plan de mejora</a> y <a href="/concurso-docente-estafas-como-reconocerlas-antes-de-pagar-checklist/">estafas alrededor del concurso</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué dice el artículo 13 de la Constitución?</h3>
<p>Que todas las personas nacen libres e iguales ante la ley y gozan de los mismos derechos y oportunidades sin discriminación, y que el Estado promoverá condiciones para que la igualdad sea real y efectiva y protegerá especialmente a quienes estén en debilidad manifiesta.</p>
<h3>¿Qué significa que los derechos de los niños prevalezcan?</h3>
<p>Que, según el artículo 44, cuando entran en conflicto con los derechos de los demás, los de los niños tienen un peso especial. No elimina la necesidad de ponderar cada caso.</p>
<h3>¿Hasta qué edad es obligatoria la educación?</h3>
<p>Entre los cinco y los quince años, con mínimo un año de preescolar y nueve de educación básica (art. 67). Es un mínimo obligatorio, no el límite del derecho a la educación.</p>
<h3>¿La educación pública es gratuita?</h3>
<p>El artículo 67 establece la gratuidad en las instituciones del Estado, sin perjuicio del cobro de derechos académicos a quienes puedan sufragarlos. Consulta la reglamentación vigente para saber cómo se aplica.</p>
<h3>¿Quién puede exigir el cumplimiento de los derechos de un niño?</h3>
<p>Según el artículo 44, cualquier persona, ante la autoridad competente.</p>

<p class="notice"><strong>Empieza hoy.</strong> Descarga la <a href="/descargas/concurso-docente/ficha-estudio-constitucion-13-44-67.xlsx">ficha de estudio</a>, lee los tres artículos en el texto oficial, resume cada uno con tus palabras y resuelve la matriz de decisiones del aula antes de mirar las respuestas.</p>

<h2>Para pensar</h2>
<p>La Constitución dice que los derechos de los niños prevalecen, pero en la práctica cada institución decide cuánto pesa esa prevalencia cuando cuesta tiempo, dinero o incomodidad. <strong>¿Qué decisión de tu colegio cambiaría si se evaluara de entrada con la pregunta "¿esto garantiza el acceso, la permanencia y la igualdad real de este niño?" Y si tú fueras la persona en debilidad manifiesta, ¿qué esperarías de quien tiene que decidir?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:articulos}}' => $img('constitucion-13-44-67-articulos', 444, 'Tabla con los artículos 13, 44 y 67 de la Constitución, su idea central y lo que obligan a hacer en el aula.', 'Qué dice cada uno y qué obliga a hacer.'),
    '{{img:razonar}}' => $img('constitucion-13-44-67-razonar', 467, 'Cinco pasos para razonar un caso desde la Constitución: el derecho, quién debe, la desventaja, el desarrollo y justificar.', 'Cinco pasos para razonar una respuesta.'),
]);

return [
    'slug' => 'concurso-docente-constitucion-articulos-13-44-67-igualdad-ninos-educacion',
    'title' => 'Constitución, artículos 13, 44 y 67 en el Concurso Docente: igualdad, derechos de los niños y educación, con casos resueltos',
    'excerpt' => 'Los artículos 13, 44 y 67 de la Constitución explicados para el Concurso Docente: qué dicen, cómo se interpretan, cómo se razona un caso desde ellos y una ficha de estudio en Excel, con dos casos resueltos.',
    'seo_title' => 'Constitución arts. 13, 44 y 67 en el Concurso Docente',
    'seo_description' => 'Estudia los artículos 13, 44 y 67 de la Constitución: igualdad, derechos de los niños y educación, con dos casos resueltos y una ficha en Excel.',
    'focus_keyword' => 'Constitución artículos 13 44 67 Concurso Docente',
    'cover' => '/assets/img/articulos/constitucion-13-44-67/constitucion-13-44-67-portada',
    'cover_alt' => 'Portada "Constitución arts. 13, 44 y 67: igualdad, derechos de los niños y educación" con una tarjeta: 3 artículos que fundamentan las decisiones sobre inclusión y acceso.',
    'published_at' => '2027-01-22 12:00:00',
    'content_html' => $html,
];
