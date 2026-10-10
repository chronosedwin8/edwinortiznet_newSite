<?php

declare(strict_types=1);

// "Una mesa de ayuda para el colegio". Modelo simplificado inspirado en gestión de incidentes (ITIL). Libro verificado en Excel 16 y en Python: 20 tickets, 17 cerrados, 14 en plazo (82,4 %), P1 1 de 3, P2 3 de 4, P3 4 de 4, P4 6 de 6; 2 abiertos vencidos; media 13,7 h; mediana 4,75 h. Datos ficticios.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/mesa-de-ayuda/' . $name;
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
<p>El proyector del salón 204 no enciende. La docente le escribe por WhatsApp al coordinador, que le responde que le avise al de sistemas, que está en otra sede. Dos horas después, la clase ya empezó, nadie sabe quién se encarga y el mismo problema se repite en otro salón. En muchos colegios el soporte tecnológico funciona así: <strong>se resuelve lo que le toca a quien está más cerca, sin registro, sin prioridades y sin saber qué se repite</strong>.</p>
<p>Una mesa de ayuda (<em>help desk</em>) no necesita software costoso para funcionar. Este artículo propone un modelo mínimo: un solo canal de entrada, tickets con categoría, impacto y urgencia, una prioridad calculada, plazos por prioridad y un tablero de indicadores. Incluye un <a href="/descargas/mesa-de-ayuda/mesa-de-ayuda-colegio.xlsx">libro de Excel</a> con 20 tickets ficticios, con resultados verificados en Microsoft Excel 16 y contra un cálculo independiente en Python. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Es un modelo de partida inspirado en prácticas de gestión de incidentes de servicios de TI (como ITIL), simplificado para un colegio; no es una implementación certificada ni asesoría de un proveedor. Los datos, las prioridades y los plazos del ejemplo son ficticios y editables: ajústalos a tu institución y a los recursos reales del equipo de soporte.</p>

<h2>Un solo canal, un solo registro</h2>
<p>La primera decisión es la más importante: <strong>todas las solicitudes entran por un solo canal</strong> (un formulario, un correo de soporte o un chat con formulario de respaldo) y se registran como un ticket. No porque la burocracia sea buena, sino porque sin registro no hay prioridad, ni plazo, ni historial, ni aprendizaje. Un mensaje por WhatsApp es una conversación; un ticket es un compromiso con un número, un responsable y un plazo. Si para ti el formulario es demasiado, el mínimo son seis campos: quién, dónde, qué pasa, desde cuándo, cuántas personas afecta y qué tan urgente es.</p>

<h2>Prioridad = impacto × urgencia</h2>
<p>No todo es urgente, aunque a quien lo pide se lo parezca. La práctica más usada para decidir es cruzar dos preguntas: <strong>impacto</strong> (¿a cuántas personas o servicios afecta?) y <strong>urgencia</strong> (¿qué tan rápido hay que resolverlo?). La hoja <em>Reglas</em> trae una matriz de 3 por 3 que produce cuatro prioridades:</p>
{{img:prioridades}}
<ul>
<li><strong>Impacto alto</strong> (toda la institución o un servicio crítico) con urgencia alta es <strong>P1</strong>; con urgencia media, P2; con urgencia baja, P3.</li>
<li><strong>Impacto medio</strong> (un grupo, un área o un aula): urgencia alta, P2; media, P3; baja, P4.</li>
<li><strong>Impacto bajo</strong> (una persona): urgencia alta, P3; media o baja, P4.</li>
</ul>
<p>Cada prioridad tiene un plazo de resolución de ejemplo: 4 horas (P1), 8 (P2), 24 (P3) y 72 (P4), en horas de calendario. En uso real, quizá prefieras horas hábiles; el modelo se adapta.</p>
<pre><code>' Prioridad: cruza impacto (fila) y urgencia (columna) en la matriz
=INDICE(Reglas!$B$5:$D$7; COINCIDIR(F4; Reglas!$A$5:$A$7; 0); COINCIDIR(G4; Reglas!$B$4:$D$4; 0))   ' español
=INDEX(Reglas!$B$5:$D$7, MATCH(F4, Reglas!$A$5:$A$7, 0), MATCH(G4, Reglas!$B$4:$D$4, 0))             ' inglés

' Límite = creación + plazo de la prioridad (en horas / 24)
=B4 + BUSCARV(H4; Reglas!$A$11:$B$14; 2; FALSO)/24

' Estado del plazo (cerrado o abierto)
=SI(K4=""; SI(Reglas!$B$16>J4; "Abierto vencido"; "Abierto en plazo"); SI(K4<=J4; "Cumplido"; "Incumplido"))</code></pre>

<h2>El ciclo de un ticket</h2>
{{img:ciclo}}
<ol>
<li><strong>Registrar</strong> (quién, qué, cuándo, por un solo canal).</li>
<li><strong>Clasificar:</strong> categoría (red, proyector, cuenta, plataforma, correo, impresión, software), impacto y urgencia. La clasificación la hace quien atiende, no quien pide: el solicitante dice qué le pasa, la mesa decide la prioridad.</li>
<li><strong>Resolver</strong> dentro del plazo. Si no se puede, comunicar y reprogramar, no desaparecer.</li>
<li><strong>Confirmar</strong> con la persona que quedó resuelto, antes de cerrar.</li>
<li><strong>Aprender:</strong> si el problema se repite, dejar la solución documentada (ver próximamente la base de conocimiento institucional) o resolver la causa.</li>
</ol>

<h2>Lo que mostró el ejemplo (datos ficticios)</h2>
<p>El libro tiene 20 tickets de una semana (11 al 18 de enero de 2027), 17 cerrados y 3 abiertos. Los indicadores calculados:</p>
<ul>
<li><strong>Cumplimiento general:</strong> 14 de los 17 cerrados llegaron dentro del plazo (82,4 %). Parece un buen resultado.</li>
<li><strong>Por prioridad:</strong> los tres P1 (los críticos) se cerraron en 4,4 horas en promedio, pero solo 1 de 3 cumplió su plazo de 4 horas (33 %). En P2 cumplieron 3 de 4; en P3, 4 de 4; y en P4, 6 de 6 (con 29,4 horas en promedio frente a un plazo de 72).</li>
<li><strong>Abiertos vencidos:</strong> 2 de los 3 abiertos ya pasaron su plazo al corte.</li>
<li><strong>Tiempo de resolución:</strong> promedio de 13,7 horas, pero mediana de unas 4,7 horas (4 horas y 45 minutos): unos pocos tickets lentos jalan el promedio.</li>
<li><strong>Categorías:</strong> proyector o aula (20 %) y cuenta o acceso (20 %) lideran; red, plataforma, correo, impresión y software suman el resto.</li>
</ul>
<p>La lección es la de siempre con los promedios: <strong>el 82 % global esconde que lo más crítico falla más</strong>. Un reporte que solo dijera "82 % de cumplimiento" daría la impresión de que todo va bien, cuando justo los incidentes que afectan a toda la sede se resolvieron tarde en dos de tres casos. Por eso el tablero desglosa por prioridad y reporta mediana además de promedio. (Ver también <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">qué monitorear en una aplicación web</a>, donde el mismo principio aplica a las alertas.)</p>

<h2>Respuestas modelo: tres mensajes que ahorran tiempo</h2>
<pre><code>1. Confirmación de recibido
"Recibimos tu solicitud (ticket #{n}). La clasificamos como {prioridad} y la atenderemos antes de {límite}.
Si cambia algo, responde a este mensaje con el número del ticket."

2. Falta información
"Para atender el ticket #{n} necesitamos saber: ¿en qué salón o sede ocurre?, ¿desde cuándo?
y ¿qué mensaje de error aparece? Con eso lo priorizamos."

3. Cierre y confirmación
"Resolvimos el ticket #{n}: {qué se hizo}. Por favor confirma si ya funciona.
Si no responde en 48 horas lo daremos por cerrado."</code></pre>

<h2>Del incidente al problema: cuando algo se repite</h2>
<p>Resolver tickets uno a uno apaga incendios; <strong>mirar las categorías que se repiten</strong> permite eliminar la causa. Si el proyector falla en tres salones, la causa quizá sea el cable o el cambio de modelo, no el salón. La hoja <em>Indicadores</em> cuenta los tickets por categoría para ver dónde está el patrón; cuando una categoría domina varias semanas, es hora de abrir un "problema" (una investigación de causa raíz) o una inversión de mantenimiento preventivo. Este es también un insumo para hablar de la deuda tecnológica con la dirección (ver <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">más plataformas no es mejor</a>) y para decidir qué comprar, con la mirada de costo total.</p>

<h2>Herramientas posibles (sin comprar nada)</h2>
<ul>
<li><strong>Excel o una hoja de cálculo compartida,</strong> como en el libro: suficiente para un equipo de una o dos personas y unas decenas de tickets semanales.</li>
<li><strong>Formulario + lista:</strong> un formulario que alimenta una lista compartida y un flujo que avisa (ver <a href="/flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion/">flujo de aprobación digital</a> para el mismo diseño de piezas).</li>
<li><strong>Software libre de mesa de ayuda,</strong> como GLPI u osTicket, que existen para instalar en un servidor propio; requieren alguien que los mantenga y que revise su licencia, su seguridad y las copias de respaldo.</li>
</ul>
<p>Empieza por lo más simple que puedas sostener: una mesa de ayuda abandonada es peor que ninguna, porque promete algo que no cumple.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En muchos colegios colombianos, públicos y privados, el soporte tecnológico es una sola persona, a veces un docente con horas de sistemas, a veces un contratista externo, y la demanda crece con las plataformas, los salones con proyector y las evaluaciones digitales. En la región el panorama se repite, con brechas grandes entre instituciones; en el mundo, las prácticas de gestión de servicios de TI (ITIL es la más conocida) son un lenguaje común que se puede adaptar a escalas pequeñas. Para los <strong>directivos</strong>, una mesa de ayuda convierte la queja ("nunca funciona nada") en datos que permiten decidir presupuesto; para los <strong>docentes</strong>, saber a quién pedir y cuándo recibirán respuesta reduce la frustración; para el <strong>personal de soporte</strong>, la prioridad explícita protege de ser el apagafuegos de quien más insiste; y para las <strong>familias</strong> y estudiantes, un servicio estable es parte de la continuidad escolar. Una nota de cuidado: los tickets pueden contener datos personales (nombres, cuentas); trátalos con las reglas de protección de datos de tu institución y limita quién los ve.</p>

<h2>Herramientas y plantillas</h2>
<p>Si prefieres partir de plantillas de Excel ya armadas, con soporte, o necesitas una guía para organizar tus formatos, mira estas opciones. Para la parte pedagógica, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a> son herramientas propias para docentes.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">proteger el dominio del colegio</a>, <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">qué hacer en los primeros 60 minutos de un ransomware</a> y <a href="/extensiones-del-navegador-riesgos-permisos-inventario-politica/">extensiones del navegador</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es una mesa de ayuda?</h3>
<p>Un punto único donde se reciben, clasifican, resuelven y registran las solicitudes de soporte. Puede ser un formulario y una hoja de cálculo, no necesariamente un software especializado.</p>
<h3>¿Cómo se define la prioridad de un ticket?</h3>
<p>Cruzando el impacto (a cuántas personas o servicios afecta) con la urgencia (qué tan rápido hay que resolverlo). La hoja Reglas trae una matriz de ejemplo.</p>
<h3>¿Qué indicadores debo medir?</h3>
<p>Cumplimiento del plazo por prioridad (no solo el global), tiempo de resolución (promedio y mediana), tickets abiertos vencidos y categorías que más se repiten.</p>
<h3>¿Necesito un software especial?</h3>
<p>No para empezar. Un formulario y una hoja de cálculo bastan para un equipo pequeño. Si el volumen crece, hay opciones de software libre y comerciales.</p>
<h3>¿Qué hago con las solicitudes que llegan por WhatsApp o en el pasillo?</h3>
<p>Pedir amablemente que se registren por el canal único, o registrarlas uno mismo, con un mensaje de confirmación. Sin registro, no hay prioridad ni historial.</p>

<p class="notice"><strong>Empieza esta semana.</strong> Descarga la <a href="/descargas/mesa-de-ayuda/mesa-de-ayuda-colegio.xlsx">mesa de ayuda en Excel</a>, ajusta la matriz de prioridades y los plazos, registra los tickets de tu semana y mira cuál es el cumplimiento de tus casos P1.</p>

<h2>Para pensar</h2>
<p>Cuando el soporte no se mide, depende de la buena voluntad de una persona y del volumen de las quejas. Cuando se mide, se vuelve visible quién sufre más, qué se rompe más y cuánto cuesta no invertir. <strong>¿Quién decide, en tu colegio, qué solicitud de soporte es más urgente: quien grita más fuerte o el impacto sobre la comunidad? Y si los datos muestran que lo crítico se resuelve tarde, ¿estamos dispuestos a invertir en tiempo y recursos, o solo a repartir la culpa?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:prioridades}}' => $img('mesa-de-ayuda-prioridades', 499, 'Tabla con cuatro prioridades de tickets y su plazo: P1 a 4 horas, P2 a 8, P3 a 24 y P4 a 72.', 'Cuatro prioridades, cuatro plazos.'),
    '{{img:ciclo}}' => $img('mesa-de-ayuda-ciclo', 467, 'Cinco pasos de la vida de un ticket: registrar, clasificar, resolver, confirmar y aprender.', 'De la solicitud al aprendizaje.'),
]);

return [
    'slug' => 'mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel',
    'title' => 'Una mesa de ayuda para el colegio sin software costoso: prioridades, plazos y tickets en Excel',
    'excerpt' => 'Cómo montar una mesa de ayuda mínima para el soporte tecnológico del colegio: un canal único, tickets, prioridad por impacto y urgencia, plazos y un tablero de cumplimiento, con un libro de Excel verificado.',
    'seo_title' => 'Mesa de ayuda para colegios: tickets y prioridades',
    'seo_description' => 'Monta una mesa de ayuda para el soporte tecnológico del colegio sin software costoso: tickets, prioridad por impacto y urgencia, plazos e indicadores.',
    'focus_keyword' => 'mesa de ayuda para el colegio',
    'cover' => '/assets/img/articulos/mesa-de-ayuda/mesa-de-ayuda-portada',
    'cover_alt' => 'Portada "Una mesa de ayuda para el colegio sin software costoso: prioridades y plazos" con una tarjeta: 82 % de tickets en plazo en general, pero solo 1 de 3 de los más críticos.',
    'published_at' => '2027-01-19 12:00:00',
    'content_html' => $html,
];
