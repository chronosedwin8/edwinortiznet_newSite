<?php

declare(strict_types=1);

// "Presupuesto del colegio en Excel: ejecutado, comprometido y disponible". Ciclo apropiación, CDP, RP, obligación y pago (Estatuto Orgánico del Presupuesto, Decreto 111 de 1996, art. 71; fondos de servicios educativos: Decreto 4791 de 2008 compilado en el Decreto 1075 de 2015, arts. 2.3.1.6.3.4 y 2.3.1.6.3.5; consultas del 10-oct-2026, con aviso de verificar). Libro verificado en Excel 16 y Python: apropiación 88.000.000; CDP 65.500.000; RP 58.600.000; obligado 43.600.000; pagado 37.600.000; disponible 22.500.000; R8 negativo; CDP-005 excedido.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ejecucion-presupuestal/' . $name;
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
<p>El consejo directivo pregunta: "¿cuánta plata tenemos para mantenimiento?". El tesorero mira el saldo del banco. La rectora mira el presupuesto aprobado. El coordinador recuerda que ya se pidió una cotización. Y las tres respuestas son distintas, porque el dinero de un colegio tiene <strong>al menos cuatro estados</strong>: autorizado (apropiado), reservado (con un certificado de disponibilidad), comprometido (con un contrato u orden registrados) y pagado. Confundirlos lleva a dos errores simétricos: <strong>gastar más de lo que hay</strong> o dejar dinero sin ejecutar mientras se suspenden arreglos urgentes.</p>
<p>Este artículo explica el ciclo del gasto con las palabras que usa el presupuesto público colombiano (apropiación, CDP, RP, obligación y pago) y ofrece un <a href="/descargas/ejecucion-presupuestal/ejecucion-presupuestal-colegio.xlsx">libro de Excel</a> que controla, por rubro, lo apropiado, lo reservado, lo comprometido, lo obligado y lo pagado, con alertas cuando un documento excede al anterior. Los resultados se verificaron en Microsoft Excel 16 y contra un cálculo independiente en Python, con datos ficticios. Revisado el 10 de octubre de 2026.</p>
<p class="notice"><strong>Alcance.</strong> Esto no es asesoría contable ni jurídica. Las reglas presupuestales dependen de si el colegio es oficial o privado y de las normas de su entidad territorial; en los oficiales, el fondo de servicios educativos tiene su propio régimen (el rector es el ordenador del gasto y el consejo directivo aprueba el presupuesto), y las definiciones exactas, los plazos y los procedimientos deben verificarse en la normativa vigente y con la secretaría de educación. Los montos del ejemplo son ficticios y el libro es una herramienta de control interno, no sustituye el sistema contable oficial.</p>

<h2>El ciclo del gasto en cinco palabras</h2>
{{img:ciclo}}
<ul>
<li><strong>Apropiación:</strong> el monto que el presupuesto autoriza gastar en un rubro durante la vigencia. En el libro: apropiación inicial, más adiciones, menos reducciones, igual a la <em>apropiación definitiva</em>.</li>
<li><strong>Certificado de disponibilidad presupuestal (CDP):</strong> el documento que garantiza que hay apropiación suficiente y libre de afectación para asumir un compromiso. Se expide <em>antes</em> de contratar o comprometer y reserva el dinero de forma preliminar. El artículo 71 del Estatuto Orgánico del Presupuesto (Decreto 111 de 1996) exige que los actos administrativos que afecten las apropiaciones cuenten con certificados de disponibilidad previos.</li>
<li><strong>Registro presupuestal (RP):</strong> el registro del compromiso cuando se perfecciona (por ejemplo, al firmar el contrato o expedir la orden). Afecta la apropiación de forma definitiva y evita que esos recursos se desvíen a otro fin.</li>
<li><strong>Obligación:</strong> la exigibilidad del pago, que nace cuando el bien o el servicio se recibió a satisfacción. Puede haber compromisos sin obligación todavía (el contrato firmado y la obra sin entregar).</li>
<li><strong>Pago:</strong> la salida efectiva de recursos para cumplir la obligación.</li>
</ul>
<p>Cada documento descansa sobre el anterior y no debería superarlo: un RP no puede ser mayor que su CDP, una obligación no puede ser mayor que su RP y un pago no puede ser mayor que su obligación. Y cada eslabón deja un saldo útil: <strong>disponible</strong> (apropiación − CDP), <strong>por comprometer</strong> (CDP − RP), <strong>por obligar</strong> (RP − obligado) y <strong>por pagar</strong> (obligado − pagado). Para los colegios oficiales, el Decreto 4791 de 2008 (compilado en el Decreto 1075 de 2015, arts. 2.3.1.6.3.4 y 2.3.1.6.3.5) establece que el rector actúa como ordenador del gasto del fondo de servicios educativos y que el consejo directivo aprueba, mediante acuerdo y antes de cada vigencia fiscal, el presupuesto de ingresos y gastos (verifica el texto vigente).</p>

<h2>El libro, hoja por hoja</h2>
<ul>
<li><strong>Rubros:</strong> una fila por rubro, con la apropiación (inicial, adiciones, reducciones y definitiva) y, calculados desde los movimientos, los CDP expedidos, lo comprometido, lo obligado y lo pagado, más los cuatro saldos, los porcentajes y una alerta.</li>
<li><strong>Movimientos:</strong> el registro de cada documento (tipo, número, documento previo, rubro, fecha y valor). Para cada uno calcula la suma de los documentos que lo referencian y señala si lo exceden o si falta el documento previo.</li>
<li><strong>Resumen:</strong> los totales y las alertas.</li>
</ul>
<pre><code>' Comprometido (RP) de un rubro: suma de los movimientos tipo RP de ese rubro
=SUMAR.SI.CONJUNTO(Movimientos!$G$4:$G$300; Movimientos!$A$4:$A$300; "RP"; Movimientos!$E$4:$E$300; A4)   ' español
=SUMIFS(Movimientos!$G$4:$G$300, Movimientos!$A$4:$A$300, "RP", Movimientos!$E$4:$E$300, A4)             ' inglés

' Disponible para nuevos CDP
=F4-G4

' Un documento excede al anterior si los documentos que lo referencian suman más que su valor
=SUMAR.SI.CONJUNTO($G$4:$G$300; $C$4:$C$300; B4)         ' suma de los que lo referencian
=SI(Y(A4<>"PAGO"; H4>G4); "Excede el documento"; "OK")</code></pre>

<h2>Lo que mostró el libro (presupuesto ficticio)</h2>
<p>El ejemplo tiene ocho rubros y una apropiación definitiva de <strong>$88.000.000</strong> (dos de ellos con adiciones o reducciones). Los movimientos acumulan CDP por $65.500.000, compromisos (RP) por $58.600.000, obligaciones por $43.600.000 y pagos por $37.600.000. Es decir, está <strong>comprometido el 66,6 %</strong> de la apropiación y <strong>pagado el 42,7 %</strong>; el disponible total para nuevos CDP es de $22.500.000. Pero el total esconde varias cosas que solo se ven por rubro:</p>
<ul>
<li><strong>Capacitación (R8): los CDP superan la apropiación.</strong> Se expidió un CDP de $3.500.000 sobre una apropiación de $3.000.000: el disponible del rubro es de −$500.000. Un CDP no debería expedirse sin apropiación suficiente.</li>
<li><strong>Comunicaciones y transporte (R4): un RP excede su CDP.</strong> El CDP-005 reservó $2.000.000 y el RP-005 comprometió $2.300.000 (exceso de $300.000). El libro lo marca en la hoja de movimientos y en el rubro.</li>
<li><strong>Impresos y publicaciones (R6): CDP sin comprometer.</strong> $3.000.000 reservados que no se han convertido en RP. Puede ser un compromiso en trámite o una reserva olvidada que está bloqueando dinero que otro rubro o actividad podría usar.</li>
<li><strong>Seguros (R7): disponible cero.</strong> Todo el rubro está reservado, comprometido y obligado; falta pagar $1.000.000.</li>
<li><strong>Mantenimiento (R2) y dotación tecnológica (R5):</strong> con $5.500.000 y $5.000.000 comprometidos pero aún sin obligar, respectivamente: el servicio o el bien está contratado y falta que se reciba. En R5, además, hay $5.000.000 obligados sin pagar.</li>
<li><strong>Por pagar en total:</strong> $6.000.000 de obligaciones sin pagar (R5: 5 millones; R7: 1 millón): una cuenta por pagar que conviene programar.</li>
</ul>
<p>La lección: el <strong>disponible total de $22,5 millones parece cómodo, pero se controla por rubro</strong>, y en el rubro de capacitación el disponible es negativo. El dinero sobrante de un rubro no cubre el faltante de otro, salvo que exista una modificación presupuestal aprobada (traslado) conforme a las reglas de la institución. Resumen del libro: 1 rubro con CDP sobre su apropiación, 1 documento que excede al anterior y 0 documentos sin documento previo.</p>
{{img:control}}

<h2>Cuatro errores frecuentes</h2>
<ol>
<li><strong>Mirar el saldo del banco en lugar del disponible presupuestal.</strong> El banco no sabe de compromisos: puede haber $10 millones en la cuenta y $9 millones ya comprometidos en contratos por pagar.</li>
<li><strong>Comprometer sin CDP,</strong> o comprometer más de lo reservado. El artículo 71 del Estatuto Orgánico no es un trámite decorativo: está para evitar que se contraiga un gasto sin respaldo.</li>
<li><strong>Dejar CDP vivos sin comprometer.</strong> Bloquean disponibilidad. Conviene revisar mensualmente los CDP sin RP y liberar los que ya no se usarán, siguiendo el procedimiento de la institución.</li>
<li><strong>Confundir ejecución con pago.</strong> "Se ejecutó el 66 %" puede significar comprometido, obligado o pagado; al informar, dilo con la palabra exacta, o el consejo se llevará una idea equivocada.</li>
</ol>

<h2>Cinco pasos para un control mensual</h2>
<ol>
<li><strong>Registra cada documento</strong> con su documento previo y su rubro, el mismo día.</li>
<li><strong>Revisa los excesos</strong> (documentos que superan al anterior) y los CDP sobre la apropiación.</li>
<li><strong>Mira el disponible por rubro</strong> antes de expedir un nuevo CDP.</li>
<li><strong>Revisa lo que está por pagar</strong> y programa los pagos.</li>
<li><strong>Informa</strong> con un resumen claro (apropiado, comprometido, obligado, pagado y disponible) a quien decide.</li>
</ol>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el ciclo apropiación, CDP, RP, obligación y pago es la columna vertebral del presupuesto público, y los colegios oficiales lo aplican a los recursos de sus fondos de servicios educativos (transferencias de gratuidad, recursos propios y otros), mientras los privados llevan su contabilidad bajo sus propias normas. En la región, la gestión presupuestal de las escuelas va desde la administración centralizada hasta la autonomía de gestión con rendición de cuentas; en el mundo, el control por compromisos (y no solo por caja) es una práctica estándar de la gestión financiera pública. Para los <strong>directivos</strong>, entender las palabras evita decisiones con información equivocada; para los <strong>docentes</strong>, saber que un pedido necesita disponibilidad antes de comprar; para el <strong>consejo directivo</strong>, pedir informes por rubro y no solo totales; y para las <strong>familias</strong>, que la rendición de cuentas sea comprensible. En las próximas semanas de esta serie se estudia la Ley 715 de 2001, que organiza los recursos del sector. Ver también <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">el costo total de una plataforma</a> para decisiones de compra tecnológica.</p>

<h2>Plantillas y herramientas</h2>
<p>Si prefieres partir de plantillas de Excel ya armadas, con soporte, mira estas opciones. Y para pedir a una IA ayuda con tus fórmulas (verificando siempre el resultado y sin pegar datos sensibles), hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL! y #VALUE!</a>, <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">un dashboard que ayude a actuar</a> y <a href="/comparar-dos-ofertas-de-credito-en-excel-tasa-real-costo-total-comparador/">comparar dos ofertas de crédito en Excel</a>. Para quienes preparan el concurso, ver <a href="/herramientas/simulacro-concurso-docente/">la herramienta de simulacro</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Qué es un CDP?</h3>
<p>Un certificado de disponibilidad presupuestal: el documento que garantiza que hay apropiación disponible y libre de afectación para asumir un compromiso. Se expide antes de comprometer.</p>
<h3>¿Cuál es la diferencia entre CDP y RP?</h3>
<p>El CDP reserva la disponibilidad de forma preliminar, antes de contratar; el RP registra el compromiso cuando se perfecciona y afecta la apropiación de forma definitiva.</p>
<h3>¿Qué es el disponible presupuestal?</h3>
<p>La apropiación menos los CDP expedidos (que ya reservan dinero). No es el saldo del banco.</p>
<h3>¿Se puede usar lo que sobra de un rubro en otro?</h3>
<p>Solo mediante una modificación presupuestal (traslado) aprobada conforme a las reglas de la institución. El control es por rubro.</p>
<h3>¿Qué significa que un documento excede al anterior?</h3>
<p>Que el valor de lo que depende de él (por ejemplo, los RP de un CDP) suma más que su propio valor: se comprometió o se pagó más de lo reservado u obligado.</p>

<p class="notice"><strong>Mide tu presupuesto por rubro.</strong> Descarga el <a href="/descargas/ejecucion-presupuestal/ejecucion-presupuestal-colegio.xlsx">libro de ejecución presupuestal</a>, reemplaza los rubros y los movimientos del ejemplo por los tuyos y mira primero los rubros con disponible negativo y los documentos que exceden al anterior.</p>

<h2>Para pensar</h2>
<p>Un presupuesto es una promesa sobre cómo se usará el dinero de una comunidad. <strong>¿Quién en tu colegio puede decir hoy, sin buscar, cuánto hay realmente disponible en cada rubro y cuánto está comprometido pero sin pagar? Y cuando el dinero no alcanza, ¿quién decide qué se aplaza, con qué criterio y a la vista de quién?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ciclo}}' => $img('ejecucion-presupuestal-ciclo', 553, 'Tabla con las cinco palabras del ciclo del gasto, qué reserva o registra cada una y el saldo que se mira: apropiación, CDP, RP, obligación y pago.', 'Cinco palabras que no significan lo mismo.'),
    '{{img:control}}' => $img('ejecucion-presupuestal-control', 467, 'Cinco pasos del control mensual del presupuesto: registrar, revisar excesos, mirar el disponible, revisar lo por pagar e informar.', 'Cinco pasos para no pasarse del presupuesto.'),
]);

return [
    'slug' => 'presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro',
    'title' => 'Presupuesto del colegio en Excel: ejecutado, comprometido y disponible (CDP, RP, obligación y pago) con libro verificado',
    'excerpt' => 'El ciclo del gasto (apropiación, CDP, RP, obligación y pago) en un libro de Excel que controla los saldos por rubro y alerta cuando un documento excede al anterior, con un ejemplo ficticio verificado.',
    'seo_title' => 'Presupuesto del colegio en Excel: CDP, RP y disponible',
    'seo_description' => 'Controla el presupuesto del colegio en Excel: apropiación, CDP, RP, obligación y pago por rubro, con disponible, alertas y un ejemplo verificado.',
    'focus_keyword' => 'presupuesto del colegio en Excel',
    'cover' => '/assets/img/articulos/ejecucion-presupuestal/ejecucion-presupuestal-portada',
    'cover_alt' => 'Portada "Presupuesto del colegio en Excel: ejecutado, comprometido y disponible" con una tarjeta: 66,6 % y 42,7 %, comprometido y pagado de la apropiación.',
    'published_at' => '2027-02-04 12:00:00',
    'content_html' => $html,
];
