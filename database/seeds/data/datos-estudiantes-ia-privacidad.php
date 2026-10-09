<?php

declare(strict_types=1);

// «¿Hasta dónde puede llegar un colegio al recopilar datos de sus estudiantes para personalizar el aprendizaje con IA?» Fuentes verificadas el 9 de
// octubre de 2026: Ley 1581 de 2012 (art. 7) y Decreto 1074 de 2015 (art. 2.2.2.25.2.9), Sentencia C-748 de 2011, Circular Externa 002 de 2024 de la
// SIC, Reglamento (UE) 2024/1689 (art. 5(1)(f) y Anexo III) y la brecha de PowerSchool. No es asesoría legal.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/datos-estudiantes-ia-privacidad/' . $name;
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>La promesa suena irresistible: una plataforma que conoce cómo aprende cada estudiante, qué errores repite, cuánto tarda en cada ejercicio y qué le conviene estudiar mañana. Para lograrlo, necesita datos: notas, asistencia, tiempos, errores, a veces comportamiento, a veces la voz o el rostro. <strong>La pregunta ya no es solo si la IA personaliza, sino cuántos datos de los niños estamos dispuestos a entregar a cambio.</strong></p>
<p>En este artículo reviso qué datos se manejan, qué dicen la ley colombiana y la regulación internacional, qué pasó con uno de los mayores incidentes de datos escolares, y te dejo <strong>diez criterios</strong> para usar los datos educativos de forma responsable, útiles para docentes, directivos y familias. Normas y casos verificados el 9 de octubre de 2026. Es información de orientación, no asesoría legal.</p>
<p class="notice"><strong>Resumen.</strong> En Colombia, la Ley 1581 de 2012 restringe el tratamiento de datos de menores a los públicos y exige que prevalezca su interés superior; la Circular Externa 002 de 2024 de la SIC pide que los sistemas de IA cumplan idoneidad, necesidad, razonabilidad y proporcionalidad, con una evaluación de impacto previa. La regla práctica: recoge menos datos, con finalidad clara, con supervisión humana y con un proveedor que puedas auditar.</p>

<h2>Qué datos se recopilan y cuáles son sensibles</h2>
<p>No todos los datos de un estudiante pesan igual. Esta clasificación práctica sirve para decidir cuánto cuidado merece cada tipo:</p>
{{img:datos}}
<p>Hay una categoría que merece una advertencia: las <strong>inferencias</strong>. Cuando una IA calcula que un estudiante «tiene riesgo de deserción», «es poco motivado» o «tiene un estilo de aprendizaje visual», crea datos nuevos sobre el niño, que pueden ser erróneos y que, una vez en un perfil, tienden a seguirlo. Y los datos de salud, discapacidad o diagnósticos (por ejemplo, los de un PIAR) son sensibles: no deberían llegar a una herramienta externa con nombre y apellido.</p>

<h2>Un caso real: la brecha de PowerSchool</h2>
<p>A finales de 2024, la plataforma estadounidense PowerSchool, que gestiona información de estudiantes en miles de colegios, sufrió un acceso no autorizado. Según <a href="https://www.tomsguide.com/computing/online-security/powerschool-cyberattack-may-have-compromised-the-data-of-more-than-70-million-students-and-teachers-what-to-do-now">el resumen de Tom's Guide</a> basado en BleepingComputer, se vieron afectados los datos de unos 62,4 millones de estudiantes y 9,5 millones de docentes, y la intrusión se hizo con las credenciales de un contratista, no con un ataque de ransomware ni por una falla del software. Lo expuesto dependió de cada distrito: nombres, direcciones, teléfonos, promedios de notas, información de padres y, en algunos casos, datos médicos. Las cifras varían según la fuente y algunos detalles (por ejemplo, la exposición de números de seguridad social) se contradicen entre los informes. La lección es sencilla: <strong>mientras más datos concentra un proveedor, más atractivo y más dañino es un incidente</strong>, y la seguridad de un colegio depende también de las credenciales de sus contratistas.</p>

<h2>Qué dice la ley: Colombia, Latinoamérica y el mundo</h2>
<p><strong>En Colombia</strong> se combinan varias normas. El artículo 7 de la <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=49981">Ley 1581 de 2012</a> establece que en el tratamiento de datos de niños, niñas y adolescentes deben prevalecer sus derechos y que está prohibido tratar sus datos, salvo los de naturaleza pública; además, asigna a las entidades educativas el deber de informar y capacitar a representantes legales y tutores sobre los riesgos de un uso indebido. La Corte Constitucional (Sentencia C-748 de 2011) aclaró que no es una prohibición absoluta: puede haber tratamiento cuando respeta el interés superior del menor. El Decreto 1074 de 2015 (que compiló el Decreto 1377 de 2013) exige además que se asegure el respeto de sus derechos fundamentales y que el representante legal autorice, después de escuchar la opinión del menor según su madurez. Un colegio actúa como responsable del tratamiento.</p>
<p>Para la IA, la <a href="https://sedeelectronica.sic.gov.co/sites/default/files/normativa/Circular%20Externa%20No.%20002%20del%2021%20de%20agosto%20de%202024.pdf">Circular Externa 002 de 2024 de la SIC</a> aplica la Ley 1581 al tratamiento de datos en sistemas de inteligencia artificial: exige idoneidad, necesidad, razonabilidad y proporcionalidad, gestión de riesgos, <strong>un estudio de impacto de privacidad antes del diseño y desarrollo</strong> y la capacidad de demostrar el cumplimiento (responsabilidad demostrada). Según sus comentaristas, también promueve la privacidad desde el diseño y por defecto.</p>
<p><strong>En el mundo</strong>, la Unión Europea fue más lejos: su Reglamento de IA prohíbe desde febrero de 2025 inferir emociones de las personas en centros educativos (salvo por razones médicas o de seguridad) y clasifica como de alto riesgo los sistemas de IA que determinan el acceso a instituciones educativas, evalúan resultados de aprendizaje o vigilan el comportamiento en exámenes; el calendario de las obligaciones de alto riesgo se ha ajustado, así que verifica la fecha vigente. <strong>En Latinoamérica</strong>, las leyes de protección de datos varían en madurez, pero la tendencia es la misma: el tratamiento de datos de menores exige más cuidado, y los colegios y plataformas de la región suelen operar con proveedores globales sin que familias ni docentes sepan dónde viven los datos. Esa asimetría de información es parte del problema.</p>

<h2>Diez criterios para un uso responsable de datos educativos</h2>
<p>Este es el recurso aplicable. Úsalo para evaluar una plataforma o una política institucional:</p>
<table>
<thead><tr><th>Criterio</th><th>Pregunta clave</th><th>Señal de alerta</th></tr></thead>
<tbody>
<tr><td><strong>1. Finalidad</strong></td><td>¿Qué decisión pedagógica concreta mejora este dato?</td><td>«Por si sirve más adelante».</td></tr>
<tr><td><strong>2. Necesidad (minimización)</strong></td><td>¿Se logra lo mismo con menos datos o con datos anonimizados?</td><td>Piden más datos de los necesarios.</td></tr>
<tr><td><strong>3. Proporcionalidad</strong></td><td>¿El beneficio justifica el riesgo para un menor?</td><td>Datos biométricos o emocionales para tareas simples.</td></tr>
<tr><td><strong>4. Autorización e información</strong></td><td>¿Las familias entienden qué datos, para qué y quién los ve? ¿Se escuchó al estudiante según su madurez?</td><td>Un consentimiento genérico dentro de la matrícula.</td></tr>
<tr><td><strong>5. Supervisión humana</strong></td><td>¿Un docente revisa antes de que un perfil o alerta afecte al estudiante?</td><td>Decisiones automáticas sobre notas, grupos o sanciones.</td></tr>
<tr><td><strong>6. Proveedor y contrato</strong></td><td>¿Dónde se guardan los datos, quién accede, y se usan para entrenar modelos?</td><td>Cláusulas que permiten reutilizar los datos.</td></tr>
<tr><td><strong>7. Seguridad</strong></td><td>¿Hay control de accesos, cifrado, registro de accesos y MFA, también para contratistas?</td><td>Cuentas compartidas y sin segundo factor.</td></tr>
<tr><td><strong>8. Conservación y supresión</strong></td><td>¿Cuánto tiempo se guardan y cómo se borran?</td><td>Sin plazo ni procedimiento de eliminación.</td></tr>
<tr><td><strong>9. Derechos y canales</strong></td><td>¿Las familias pueden consultar, corregir y pedir suprimir los datos?</td><td>No hay canal ni responsable visible.</td></tr>
<tr><td><strong>10. Evaluación de impacto e incidentes</strong></td><td>¿Se hizo un estudio de impacto antes de usarla y hay plan si hay una filtración?</td><td>«Nunca nos ha pasado nada».</td></tr>
</tbody>
</table>
<p>Y una prueba de tres preguntas que cabe en cualquier reunión de consejo académico: <strong>1) ¿Qué decisión pedagógica mejora? 2) ¿Podría lograrse con menos datos? 3) ¿Qué pasa si se filtra o se equivoca?</strong> Si no hay una buena respuesta a las tres, probablemente el dato no se debería recoger.</p>

<h2>Cuatro miradas: docentes, familias, estudiantes y proveedores</h2>
<ul>
<li><strong>Docentes:</strong> quieren herramientas que ahorren tiempo, pero son quienes cargan los datos y quienes responden ante las familias. Necesitan reglas claras sobre qué pueden subir a una plataforma de IA y qué no.</li>
<li><strong>Familias:</strong> casi nunca saben qué plataformas usa el colegio ni qué datos entregan. Tienen derecho a preguntar y a recibir una respuesta comprensible.</li>
<li><strong>Estudiantes:</strong> tienen derecho a ser escuchados y a no cargar con etiquetas que un algoritmo les puso a los 12 años.</li>
<li><strong>Proveedores:</strong> un buen proveedor puede explicar qué datos recoge, por qué, dónde los guarda y cómo se borran. Si no puede, es una señal.</li>
</ul>

<h2>Cómo lo aplico en mis herramientas</h2>
<p>Aplico lo mismo que recomiendo: en <a href="/herramientas/piar/">PIAR con IA</a> y en el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> lo que escribes se envía a la API de Google Gemini para generar el documento, y por eso recomiendo usar <strong>iniciales y no incluir datos que identifiquen a estudiantes</strong>; así lo explica la <a href="/privacidad/">política de privacidad</a> del sitio. El PIAR trata información sensible (discapacidad, apoyos), así que esa precaución no es un detalle: es la regla. Si quieres trabajar con un plan de ajustes razonables sin exponer a un estudiante, empieza por el <a href="/producto/piar-con-ia-5-planes/">paquete PIAR con IA</a> usando datos mínimos, y para evaluar sin recoger perfiles, el <a href="/producto/generador-de-examenes-ia-esencial/">Generador de exámenes con IA</a> crea exámenes y soluciones sin necesidad de datos personales de los estudiantes (hay una <a href="/examenes/demo/">demostración gratuita</a>). El <a href="/producto/kit-de-ia-para-docentes/">Kit de IA para docentes</a> incluye una secuencia de ciudadanía digital (huella, privacidad y datos personales) para trabajar este tema con tus estudiantes.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}
<p>Para seguir leyendo: <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">errores básicos de seguridad</a>, <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a> y <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">si la IA amplía el pensamiento del estudiante o lo reemplaza</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Puede un colegio usar datos de los estudiantes en una plataforma de IA?</h3>
<p>Puede, si cumple la Ley 1581 de 2012: finalidad legítima, información y autorización de los representantes legales, prevalencia del interés superior del menor, medidas de seguridad y, para IA, los lineamientos de la Circular 002 de 2024 de la SIC. Hay datos que conviene no compartir con un proveedor externo.</p>
<h3>¿Qué es un dato sensible y por qué importa?</h3>
<p>Es aquel que afecta la intimidad o cuyo uso indebido puede generar discriminación (salud, datos biométricos, origen racial, entre otros). Su tratamiento exige condiciones más estrictas. En un colegio, los datos de discapacidad, diagnósticos y apoyos son el ejemplo más claro.</p>
<h3>¿Qué pasa si una plataforma escolar sufre una filtración?</h3>
<p>El responsable debe reportar el incidente según las reglas de la SIC (varias firmas indican un plazo de 15 días hábiles desde su detección; confirma el texto vigente) e informar a los afectados. Por eso conviene un plan de respuesta antes de que ocurra.</p>
<h3>¿Se puede personalizar el aprendizaje sin recolectar tantos datos?</h3>
<p>Sí. Muchas personalizaciones útiles (ejercicios de distintos niveles, retroalimentación, rutas de refuerzo) funcionan con datos mínimos o anonimizados. Más datos no siempre significa mejor aprendizaje.</p>
<h3>¿Qué le pregunto al colegio como padre o madre?</h3>
<p>Qué plataformas usan, qué datos de mi hijo recogen, para qué, quién tiene acceso, dónde se almacenan, por cuánto tiempo y cómo puedo corregirlos o pedir que se borren.</p>

<p class="notice"><strong>Revisa tu política esta semana.</strong> Aplica los diez criterios a una plataforma que uses en tu colegio y pregunta: ¿tenemos una política escrita de privacidad y uso de IA? Si no, propón una en el consejo académico. Y si trabajas con planes de ajustes razonables, protege los datos con el <a href="/producto/piar-con-ia-5-planes/">PIAR con IA</a> usando iniciales.</p>

<h2>Para pensar</h2>
<p>Un niño no puede decidir si quiere que el colegio guarde cada error que comete en una plataforma que lo acompañará durante años. <strong>Si la personalización requiere vigilar de cerca a los estudiantes, ¿el aprendizaje que ganamos justifica la privacidad que les quitamos, y quién debería tener la última palabra: el colegio, las familias o los propios estudiantes cuando crezcan y lean su expediente?</strong></p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('datos-estudiantes-ia-privacidad-datos', 553, 'Tabla de datos educativos por sensibilidad: nombre y curso media, notas y asistencia media-alta, comportamiento y perfiles alta, salud y discapacidad muy alta y emociones, voz y rostro muy alta, con la regla práctica para cada uno.', 'Datos educativos: sensibilidad y regla práctica.'),
    '{{img:normas}}' => $img('datos-estudiantes-ia-privacidad-normas', 573, 'Cuatro tarjetas: 62,4 millones de estudiantes afectados en la brecha de PowerSchool, el artículo 7 de la Ley 1581 sobre datos de menores, la Circular 002 de 2024 de la SIC y el artículo 5(1)(f) del Reglamento de IA de la UE sobre inferir emociones en centros educativos.', 'Un caso y las normas.'),
]);

return [
    'slug' => 'colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad',
    'title' => '¿Hasta dónde puede llegar un colegio al recopilar datos de sus estudiantes para personalizar el aprendizaje con IA?',
    'excerpt' => 'Qué datos de estudiantes se recopilan, qué dicen la Ley 1581 y la Circular 002 de 2024 de la SIC, el caso PowerSchool y diez criterios para un uso responsable de los datos educativos.',
    'seo_title' => 'Datos de estudiantes e IA: ¿hasta dónde llega un colegio?',
    'seo_description' => 'Privacidad de datos de estudiantes en la IA educativa: qué dice la ley en Colombia, un caso real y diez criterios para un uso responsable en colegios.',
    'focus_keyword' => 'privacidad de datos de estudiantes IA',
    'cover' => '/assets/img/articulos/datos-estudiantes-ia-privacidad/datos-estudiantes-ia-privacidad-portada',
    'cover_alt' => 'Portada «¿Hasta dónde puede un colegio recopilar datos de sus estudiantes para personalizar con IA?» con una lista: datos académicos y de salud protegidos, y emociones y perfiles sin revisión humana descartados.',
    'published_at' => '2026-10-28 12:00:00',
    'content_html' => $html,
];
