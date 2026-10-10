<?php

declare(strict_types=1);

// "Inventario tecnológico con trazabilidad". Libro verificado en Excel 16 y auditor en Python con CSV de ejemplo coincidiendo: 20 activos, garantías 14 vencidas / 2 por vencer / 4 vigentes, 11 con vida útil cumplida (sin bajas), 4 discrepancias (ACT-007, 017, 018, 020). NIST SP 800-88 y Ley 1672 de 2013 mencionadas con aviso de verificar.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/inventario-tecnologico/' . $name;
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
<p>"¿Dónde está el portátil que compramos en 2022?" "Creo que lo tiene la profesora de química." "No, ella lo devolvió y se lo llevó el de matemáticas." Es una conversación normal en un colegio sin inventario confiable. El costo no es solo el equipo perdido: es la garantía que venció sin que nadie la reclamara, la renovación que no se presupuestó, el computador con datos de estudiantes que nadie sabe dónde terminó y la <strong>imposibilidad de responder la pregunta más simple: ¿qué tenemos y quién lo tiene?</strong></p>
<p>Este artículo propone un inventario tecnológico con <strong>trazabilidad</strong>: no una lista estática de equipos, sino un inventario más un registro de movimientos, donde cada cambio (entrada, asignación, traslado, préstamo, reparación, baja) deja una fila fechada. Incluye un <a href="/descargas/inventario-tecnologico/inventario-tecnologico-trazabilidad.xlsx">libro de Excel</a> con 20 activos y 28 movimientos ficticios y un <a href="/descargas/inventario-tecnologico/auditor_inventario.py">auditor en Python</a> con dos CSV de ejemplo, que detectan cuándo los datos no coinciden con la realidad. Los resultados se verificaron en Microsoft Excel 16 y el script se contrastó con el libro. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Es una guía de gestión de activos tecnológicos, no asesoría contable ni jurídica. En colegios oficiales, el registro, el control y la baja de bienes siguen los procedimientos de la entidad territorial y del fondo de servicios educativos, y la vida útil y la depreciación las definen las políticas contables aplicables; en privados, las de la institución. Los datos del ejemplo son ficticios y los parámetros (vida útil, días de aviso) son editables.</p>

<h2>Una lista no es un inventario</h2>
<p>Una hoja con los equipos y su ubicación es una fotografía del día en que se hizo. Al mes siguiente, alguien lleva un proyector a otro salón, otra persona presta una tableta y un portátil va a reparación; la hoja sigue diciendo lo mismo. Con el tiempo, <strong>el inventario deja de describir la realidad</strong> y nadie confía en él. La solución es separar dos cosas:</p>
<ul>
<li><strong>El inventario:</strong> qué es cada activo (ID, tipo, serie), su ciclo de vida (compra, garantía, vida útil) y su situación declarada (ubicación, responsable, estado).</li>
<li><strong>Los movimientos:</strong> una bitácora fechada de cada cambio. El <strong>último movimiento</strong> de cada ID es su situación real; si el inventario dice otra cosa, algo no se actualizó.</li>
</ul>
{{img:datos}}

<h2>El libro, hoja por hoja</h2>
<ul>
<li><strong>Parametros:</strong> la fecha de revisión (fija en el ejemplo; en uso real, <code>=HOY()</code>), los días de aviso antes de que venza una garantía y la vida útil por tipo de equipo (portátil 4 años, tableta 3, proyector 5, punto de acceso 6, impresora 5, PC de escritorio 5; valores de ejemplo editables).</li>
<li><strong>Inventario:</strong> un activo por fila, con fórmulas que calculan el vencimiento de la garantía, su estado (vigente, vence pronto, vencida), el fin de la vida útil, la última ubicación y el último responsable según los movimientos, si coinciden con lo declarado y si la serie está duplicada.</li>
<li><strong>Movimientos:</strong> fecha, ID, tipo de movimiento, destino y responsable. Se registra siempre en orden cronológico.</li>
<li><strong>Resumen:</strong> los conteos clave.</li>
</ul>
<pre><code>' Garantía vence = compra + meses de garantía
=FECHA.MES(D4;E4)                                                         ' español
=EDATE(D4,E4)                                                             ' inglés

' Estado de la garantía frente a la fecha de revisión
=SI(I4<Parametros!$B$3;"Vencida";SI(I4-Parametros!$B$3<=Parametros!$B$4;"Vence pronto";"Vigente"))

' Fin de la vida útil = compra + (vida útil del tipo × 12 meses)
=FECHA.MES(D4;BUSCARV(B4;Parametros!$A$7:$B$12;2;FALSO)*12)

' Última ubicación según movimientos: la última fila cuyo ID coincide
=BUSCAR(2;1/(Movimientos!$B$4:$B$300=A4);Movimientos!$D$4:$D$300)       ' español
=LOOKUP(2,1/(Movimientos!$B$4:$B$300=A4),Movimientos!$D$4:$D$300)       ' inglés

' ¿Coincide con el inventario?
=SI(Y(F4=M4;G4=N4);"Sí";"No")</code></pre>
<p>El truco de la última fórmula merece una explicación: <code>1/(rango=ID)</code> produce 1 donde el ID coincide y un error de división por cero donde no; <code>BUSCAR(2; ...)</code> (<code>LOOKUP</code>) ignora los errores y devuelve el valor de la <strong>última</strong> fila con coincidencia, lo que equivale a "el último movimiento de este ID". Funciona porque los movimientos están en orden cronológico; si los ordenas de otra forma, el resultado cambia.</p>

<h2>Lo que encontró el libro (datos ficticios)</h2>
<p>Con la fecha de revisión del 25 de enero de 2027:</p>
<ul>
<li><strong>20 activos:</strong> 18 operativos, 1 en reparación y 1 dado de baja.</li>
<li><strong>Garantías:</strong> 14 vencidas, 2 por vencer (una tableta el 11 de febrero y un portátil el 3 de marzo de 2027) y 4 vigentes. Esas dos fechas son las únicas oportunidades de reclamar sin costo.</li>
<li><strong>Vida útil cumplida:</strong> 11 de los 19 activos que no están dados de baja ya superaron la vida útil del ejemplo. Es un dato para presupuestar renovaciones (ver <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">el costo total de comprar, suscribir o desarrollar</a>), no una orden de reemplazo: un equipo puede seguir sirviendo más allá de su vida útil nominal, con más riesgo y menos soporte.</li>
<li><strong>Cuatro activos con datos que no coinciden:</strong> una tableta que el inventario ubica en el carro pero que, según el último movimiento, está en un taller externo desde noviembre; un PC que se dio de baja en diciembre pero sigue en la sala de sistemas en el inventario; un portátil que se trasladó al laboratorio en junio mientras el inventario lo sigue ubicando en el Aula 302; y un proyector que se pasó del Aula 204 al 205 en febrero.</li>
<li><strong>Series duplicadas y activos sin movimientos:</strong> ninguno.</li>
</ul>
<p>Lo importante de este resultado no son las cifras, sino <strong>qué tipo de desajuste aparece</strong>: ninguno es una pérdida, todos son <em>actualizaciones que nadie hizo</em>. La dinámica es la habitual: alguien movió algo y no lo registró.</p>

<h2>El auditor en Python</h2>
<p>El script <code>auditor_inventario.py</code> lee dos CSV (<code>inventario.csv</code> y <code>movimientos.csv</code>) y reporta hallazgos con nivel de riesgo. Usa solo la biblioteca estándar de Python 3.8 o superior y no modifica los archivos. Revisa: IDs y series duplicados, campos obligatorios vacíos, movimientos de IDs que no existen, activos sin movimientos, discrepancias entre el inventario y el último movimiento, y garantías por vencer.</p>
<pre><code>python auditor_inventario.py inventario-ejemplo.csv movimientos-ejemplo.csv --fecha 2027-01-25

Activos: 20 | movimientos: 28 | fecha de revisión: 2027-01-25
Resumen: {'garantia vencida': 14, 'vida util cumplida (sin bajas)': 11, 'garantia vence pronto': 2}
 - ALTO: ACT-007: el inventario dice Carro de tabletas / Biblioteca, el último movimiento (2026-11-03, Reparación) dice Taller externo / Sistemas
 - ALTO: ACT-017: el inventario dice Sala de sistemas / Sistemas, el último movimiento (2026-12-10, Baja) dice Bodega de bajas / Sistemas
 - ALTO: ACT-018: el inventario dice Aula 302 / Docente Torres, el último movimiento (2026-06-15, Traslado) dice Laboratorio / Docente Torres
 - ALTO: ACT-020: el inventario dice Aula 204 / Docente Vega, el último movimiento (2026-02-02, Traslado) dice Aula 205 / Docente Vega
 - BAJO: ACT-018: la garantía vence el 2027-03-03
 - BAJO: ACT-019: la garantía vence el 2027-02-11</code></pre>
<p>Los números coinciden con los del libro de Excel (14 garantías vencidas, 2 por vencer, 11 con vida útil cumplida y 4 discrepancias). Que dos herramientas distintas lleguen a lo mismo es la mejor señal de que el cálculo es correcto.</p>

<h2>Cinco prácticas para que el inventario no se pudra</h2>
{{img:ciclo}}
<ol>
<li><strong>Rotula cada equipo</strong> con un ID visible (etiqueta o grabado) que coincida con la hoja. Sin etiqueta, la auditoría física es imposible.</li>
<li><strong>Un responsable por activo.</strong> Cuando "es de todos", no es de nadie. Quien recibe un equipo firma o confirma la asignación.</li>
<li><strong>Registra cada movimiento el mismo día,</strong> aunque sea una línea. Un traslado sin registro es la causa de casi todos los desajustes.</li>
<li><strong>Audita cada mes</strong> con el libro o el script, y una vez al año contra la realidad física (conteo físico).</li>
<li><strong>Cierra bien la baja:</strong> borrado seguro de los datos (por ejemplo, siguiendo las guías de sanitización de medios como la NIST SP 800-88), registro del destino final y de la fecha. Los aparatos eléctricos y electrónicos tienen reglas de gestión de residuos (en Colombia, la Ley 1672 de 2013 sobre residuos de aparatos eléctricos y electrónicos; verifica la normativa vigente y los gestores autorizados).</li>
</ol>
<p>Y el inventario también es seguridad: un equipo que no está en el inventario no se parchea, no se respalda y no se recupera si hay un incidente (ver <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">qué hacer en los primeros 60 minutos de un ransomware</a> y <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">una mesa de ayuda para el colegio</a>).</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, los colegios oficiales manejan sus bienes dentro de las reglas del sector público y del fondo de servicios educativos, y muchos reciben equipos por donación o dotación de entidades nacionales y locales, lo que exige llevar la cuenta de lo recibido; los privados responden ante sus propietarios y su contabilidad. En la región, la renovación tecnológica suele depender de programas externos, con ciclos irregulares; en el mundo, la gestión de activos de TI (ITAM, por sus siglas en inglés) es una práctica común, y la tendencia es mantener una base única de activos con su historial. Para los <strong>directivos</strong>, el inventario es la base para presupuestar y para justificar inversiones; para el <strong>personal de soporte</strong>, es la diferencia entre atender incidentes a ciegas o con contexto; para los <strong>docentes</strong>, saber de qué equipos son responsables evita sorpresas; y para las <strong>familias</strong>, la custodia de equipos que contienen datos de estudiantes es parte de la confianza. Cuando los equipos manejan datos personales, ver <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">siete preguntas antes de pegar datos en una IA gratuita</a>.</p>

<h2>Plantillas y herramientas</h2>
<p>Si prefieres partir de plantillas de Excel ya armadas, con soporte, mira estas opciones. Para la parte pedagógica, el <a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a> y <a href="/herramientas/piar/">PIAR con IA</a> son herramientas propias para docentes.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Sigue leyendo: <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">proteger el dominio del colegio</a>, <a href="/extensiones-del-navegador-riesgos-permisos-inventario-politica/">extensiones del navegador</a> y <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">más plataformas no es mejor</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es la trazabilidad de un activo?</h3>
<p>La capacidad de reconstruir su historia: dónde ha estado, quién lo ha tenido y qué le ha pasado, gracias a un registro fechado de cada movimiento.</p>
<h3>¿Qué datos mínimos debo registrar de cada equipo?</h3>
<p>ID, tipo, número de serie, fecha de compra, garantía, ubicación, responsable y estado, además de cada movimiento con fecha.</p>
<h3>¿Cada cuánto debo auditar el inventario?</h3>
<p>Una revisión mensual con el libro o el script, y un conteo físico al menos una vez al año.</p>
<h3>¿Qué hago con un equipo dado de baja?</h3>
<p>Borrar de forma segura los datos, registrar el movimiento de baja con su destino final y entregarlo a un gestor autorizado cuando sea un residuo electrónico.</p>
<h3>¿La vida útil del libro es una norma?</h3>
<p>No: son valores de ejemplo editables. La vida útil contable y técnica la define cada institución según sus políticas.</p>

<p class="notice"><strong>Empieza con una auditoría física.</strong> Descarga el <a href="/descargas/inventario-tecnologico/inventario-tecnologico-trazabilidad.xlsx">libro de inventario</a>, anota tus equipos con su ID y registra el primer movimiento de cada uno. Luego ejecuta el <a href="/descargas/inventario-tecnologico/auditor_inventario.py">auditor</a> cada mes.</p>

<h2>Para pensar</h2>
<p>Cuando algo no se encuentra, la primera reacción suele ser buscar al culpable. <strong>¿Qué cambiaría en tu colegio si cada equipo tuviera un nombre, un responsable y una historia, y encontrar un faltante fuera un asunto de revisar un registro y no de acusar a alguien? Y ¿quién es hoy el dueño del inventario: una persona, un cargo o nadie?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('inventario-tecnologico-datos', 499, 'Tabla con cuatro grupos de datos de un activo, qué contiene y qué responde: identidad, ciclo de vida, situación e historia.', 'Cuatro grupos de datos, cuatro preguntas.'),
    '{{img:ciclo}}' => $img('inventario-tecnologico-ciclo', 467, 'Cinco etapas del ciclo de vida de un activo: entrada, asignación, soporte, traslado y baja.', 'Cada cambio deja una fila.'),
]);

return [
    'slug' => 'inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor',
    'title' => 'Inventario tecnológico del colegio con trazabilidad: movimientos, garantías y un auditor en Python',
    'excerpt' => 'Un inventario que sabe dónde está cada equipo: ficha de activos más un registro de movimientos, garantías y vida útil, con un libro de Excel y un auditor en Python que detectan cuándo los datos no coinciden con la realidad.',
    'seo_title' => 'Inventario tecnológico del colegio con trazabilidad',
    'seo_description' => 'Inventario de equipos del colegio con movimientos, garantías y vida útil, con libro de Excel y auditor en Python que detecta datos que no coinciden.',
    'focus_keyword' => 'inventario tecnológico del colegio',
    'cover' => '/assets/img/articulos/inventario-tecnologico/inventario-tecnologico-portada',
    'cover_alt' => 'Portada "Inventario tecnológico del colegio con trazabilidad: dónde está cada equipo" con una tarjeta: 4 de 20 equipos tienen una ubicación o un responsable distinto al de su último movimiento.',
    'published_at' => '2027-01-26 12:00:00',
    'content_html' => $html,
];
