<?php

declare(strict_types=1);

// "Comparar dos ofertas de crédito en Excel". Fuentes consultadas el 10-oct-2026: Ley 1328 de 2009 y Ley 1748 de 2014 (VTU, pago anticipado); Código de Comercio art. 884 y certificación del IBC por la Superfinanciera (ejemplo con IBC de enero de 2026: 16,24 %, tope 24,36 %, cálculo propio). Libro verificado en Excel 16 y en Python: A 28.184.053 / 27,16 %; B 27.361.286 / 23,91 %; diferencia 822.768.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/comparar-creditos/' . $name;
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
<p>Dos bancos te ofrecen el mismo crédito: $20 millones a 36 meses. El primero anuncia una tasa de 20,0 % efectiva anual; el segundo, 22,5 %. La decisión parece obvia, pero no lo es: <strong>la tasa anunciada no incluye el seguro, la comisión ni otros cobros que también salen de tu bolsillo</strong>. En el ejemplo de este artículo, la oferta con la tasa más baja termina costando $822.768 más.</p>
<p>Aquí construimos un <a href="/descargas/comparar-creditos/comparador-ofertas-credito.xlsx">comparador de ofertas de crédito en Excel</a> que calcula la cuota, el costo total y la <strong>tasa efectiva anual real</strong> (la que incluye seguros y comisiones), con una tabla de amortización y una lista de preguntas antes de firmar. Todos los resultados se verificaron en Microsoft Excel 16 con un cálculo independiente en Python, con datos ficticios. Normas y datos revisados el 10 de octubre de 2026.</p>
<p class="notice"><strong>Advertencias.</strong> Esto no es asesoría financiera, tributaria ni jurídica. El comparador supone tasa fija, cuotas mensuales iguales y cobros fijos; si tu crédito tiene tasa variable, periodos de gracia o cobros porcentuales sobre el saldo, ajusta la hoja o pide a la entidad la proyección. Confirma siempre los términos en el contrato y con la entidad. Los datos del ejemplo son ficticios.</p>

<h2>El resultado del ejemplo</h2>
{{img:ofertas}}
<p>Los dos créditos son de $20.000.000 a 36 meses. La oferta A anuncia 20,0 % E. A., con seguro de $45.000 al mes y una comisión de $400.000 descontada del desembolso (recibes $19.600.000). La oferta B anuncia 22,5 % E. A., con seguro de $12.000 al mes y sin comisión. Resultados verificados:</p>
<ul>
<li><strong>Cuota del crédito</strong> (solo capital e intereses): A $726.779; B $748.036. Parece que A gana.</li>
<li><strong>Cuota mensual total</strong> (con el seguro): A $771.779; B $760.036. Ya cambió el orden.</li>
<li><strong>Total que pagarás:</strong> A $28.184.053; B $27.361.286. <strong>B cuesta $822.768 menos.</strong></li>
<li><strong>Tasa efectiva anual real</strong> (incluyendo seguro y comisión, sobre lo que realmente recibes): A 27,16 %; B 23,91 %.</li>
</ul>
<p>La tasa real de A es de 27,16 %, siete puntos más que la anunciada. Esa diferencia es lo que se esconde en los "costos adicionales".</p>

<h2>Cómo se calcula, fórmula por fórmula</h2>
<p>Las celdas amarillas son datos de cada oferta; el resto son fórmulas (aquí en español y en inglés).</p>
<pre><code>' 1. Tasa mensual equivalente a la efectiva anual (E. A.)
=(1+C7)^(1/12)-1

' 2. Cuota del crédito (capital e intereses): PAGO(tasa; plazo; -monto)
=PAGO(B12;B6;-B5)            ' español
=PMT(B12,B6,-B5)             ' inglés

' 3. Cuota total con seguro y otros cobros fijos
=B13+B8

' 4. Desembolso neto: lo que realmente recibes
=B5-B9

' 5. Total pagado y costo total del crédito
=B14*B6+B9
=B16-B5

' 6. Tasa mensual REAL: la tasa que iguala lo que recibes con las cuotas totales
=TASA(B6;-B14;B15)          ' español
=RATE(B6,-B14,B15)          ' inglés

' 7. Tasa efectiva anual real
=(1+B18)^12-1</code></pre>
<p><strong>Por qué sirve el paso 6.</strong> La función <code>TASA</code> (<code>RATE</code>) busca la tasa mensual a la que el valor presente de las cuotas totales es igual al dinero que recibes. Al meter el seguro y la comisión en el flujo, obtienes una tasa que sí es comparable entre ofertas aunque tengan estructuras distintas. Es, en esencia, una tasa interna de retorno del crédito vista desde quien lo recibe.</p>
<p><strong>Por qué se convierte la tasa efectiva anual a mensual con una potencia y no dividiendo entre 12.</strong> Una tasa del 22,5 % efectivo anual equivale a 1,7056 % mensual, y no a 1,875 % (22,5/12), porque los intereses se capitalizan. Dividir entre 12 solo es correcto para una tasa nominal anual, y por eso la hoja pide siempre la efectiva anual.</p>

<h2>La tabla de amortización</h2>
<p>La hoja <em>Amortizacion_A</em> muestra, mes a mes, el saldo inicial, el interés, el abono a capital y el saldo final, con hasta 60 cuotas (las filas sobrantes quedan vacías según el plazo). En el ejemplo, la oferta A paga $6.164.053 de intereses, el capital pagado suma $20.000.000 y el saldo final es cero, como debe ser. Ver la tabla ayuda a entender algo que casi nadie percibe: en los primeros meses, la mayor parte de la cuota son intereses, y por eso el pago anticipado de capital al comienzo ahorra más.</p>

<h2>Cinco pasos para comparar</h2>
{{img:pasos}}
<ol>
<li><strong>Pide lo mismo a ambas entidades:</strong> mismo monto y mismo plazo. Sin eso, no hay comparación.</li>
<li><strong>Anota todo:</strong> tasa efectiva anual (no la nominal), seguros (de vida, de deudor, de desempleo), comisiones, cuota de manejo y cualquier otro cobro, sea al inicio o mensual.</li>
<li><strong>Calcula</strong> la cuota, el costo total y la tasa real con el comparador.</li>
<li><strong>Pregunta</strong> lo que la hoja no sabe (hay una lista de nueve preguntas): pago anticipado, mora, tasa variable, reportes a centrales de riesgo, qué pasa si pierdes el empleo.</li>
<li><strong>Decide con tu presupuesto:</strong> la mejor oferta por costo puede no ser la que cabe en tu mes. La cuota total debe caber sin tocar lo esencial.</li>
</ol>

<h2>Qué dice la normativa colombiana (verificado)</h2>
<ul>
<li><strong>Transparencia y costo total.</strong> La Ley 1328 de 2009 obliga a las entidades vigiladas a dar información cierta, suficiente, clara y oportuna sobre costos. La Ley 1748 de 2014 adicionó que, además de la tasa de interés, se informe el <strong>Valor Total Unificado (VTU)</strong>, que reúne todos los conceptos efectivamente pagados o recibidos, y que antes de firmar se entregue una proyección del VTU cuando la naturaleza del producto lo permita. Pídelo: es justamente el dato que compara ofertas.</li>
<li><strong>Pago anticipado.</strong> Según la misma ley, las entidades deben informar antes de otorgar el préstamo sobre la posibilidad de pagar anticipadamente (con excepciones para créditos muy grandes, de más de 880 salarios mínimos). Pregunta si reduce la cuota o el plazo y si hay penalidad.</li>
<li><strong>Tope de usura.</strong> La Superintendencia Financiera certifica periódicamente el <strong>interés bancario corriente (IBC)</strong> para cada modalidad de crédito; según el artículo 884 del Código de Comercio, los intereses remuneratorios y moratorios no pueden exceder 1,5 veces el IBC. Por ejemplo, con un IBC de consumo y ordinario de 16,24 % E. A. (el certificado para enero de 2026), el tope sería cercano a 24,36 % E. A. (es un cálculo ilustrativo; el valor vigente del mes y de la modalidad se verifica en el sitio de la Superfinanciera). La hoja incluye una celda para que escribas el IBC vigente y compara la tasa anunciada con el tope. Ojo: el tope se aplica al interés pactado; los seguros y comisiones tienen su propia regulación, y la tasa "real" de la hoja es una herramienta de comparación, no un dictamen sobre usura.</li>
</ul>
<p>Si crees que te cobraron de más o no te informaron lo que debían, puedes presentar una queja ante la entidad y, si no se resuelve, acudir a la Superintendencia Financiera y a la defensoría del consumidor financiero, según el trámite vigente.</p>

<h2>Cuándo los números no bastan</h2>
<p>Un comparador no sabe si el crédito es necesario. Antes de comparar ofertas, conviene preguntarse para qué es, si hay alternativas (aplazar la compra, ahorrar una parte, un crédito de menor monto) y qué ocurre si los ingresos bajan. Y si el crédito es para educación, conviene mirar también las líneas específicas que existan en tu región y su costo real, calculado con esta misma hoja. Para las decisiones de compra de tecnología en una institución, ver <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">el costo total de una plataforma</a>.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>En Colombia, el sistema financiero está supervisado por la Superintendencia Financiera, que además certifica las tasas de referencia; en la región, muchos países exigen informar un "costo total" o una tasa equivalente que incluya cargos (con nombres distintos, como costo anual total en algunos países), y en el mundo la discusión sobre el costo real del crédito al consumo es amplia. En todos los casos la lección es la misma: comparar por el costo total y no por la tasa anunciada. Para los <strong>docentes</strong>, que a menudo acceden a créditos de libranza o de cooperativas, es útil comparar el costo total entre esas opciones y la banca; para los <strong>directivos</strong> y las <strong>cooperativas</strong>, informar el costo total con claridad; para las <strong>familias</strong>, pedir siempre el VTU; y para los <strong>jóvenes</strong>, aprender a leer una oferta antes de firmar. Esta alfabetización financiera se enseña con casos concretos como este.</p>

<h2>Plantillas y recursos</h2>
<p>Si quieres partir de plantillas de Excel ya armadas, con soporte, mira estas opciones. Para pedir a una IA ayuda con tus fórmulas (verificando siempre el resultado y sin pegar datos personales), hay una <a href="/descargas/excel-con-ia/excel-con-ia.zip">guía gratuita de Excel con IA</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Sigue leyendo: <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">promedios en Excel: siete errores</a>, <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">los errores #N/A, #SPILL! y #VALUE!</a> y <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">pronósticos en Excel</a>. Y para enseñar matemática financiera con casos reales, ver <a href="/herramientas/generador-de-examenes/">el Generador de exámenes con IA</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿Cuál es la diferencia entre tasa nominal y efectiva anual?</h3>
<p>La efectiva anual incluye el efecto de capitalizar los intereses durante el año; la nominal no. Para comparar créditos usa la efectiva anual.</p>
<h3>¿Cómo calculo la cuota de un crédito en Excel?</h3>
<p>Con la función PAGO (PMT): =PAGO(tasa mensual; número de cuotas; -monto). La tasa mensual se obtiene de la efectiva anual con =(1+E.A.)^(1/12)-1.</p>
<h3>¿Qué es el Valor Total Unificado?</h3>
<p>Un dato que, según la Ley 1748 de 2014, las entidades vigiladas deben informar y que reúne todos los conceptos efectivamente pagados o recibidos por el cliente, además de la tasa de interés. Pídelo antes de firmar.</p>
<h3>¿Por qué la tasa real es mayor que la anunciada?</h3>
<p>Porque incluye cobros que la tasa anunciada no refleja (seguros, comisiones y otros) y los calcula sobre lo que realmente recibes.</p>
<h3>¿Sirve el comparador para créditos con tasa variable?</h3>
<p>Solo como aproximación con la tasa de hoy. Pide a la entidad una proyección o prueba la hoja con escenarios de tasas más altas.</p>

<p class="notice"><strong>Compara con tus datos.</strong> Descarga el <a href="/descargas/comparar-creditos/comparador-ofertas-credito.xlsx">comparador de ofertas de crédito</a>, reemplaza las celdas amarillas con las dos ofertas y mira cuál cuesta menos de verdad. Antes de firmar, responde la lista de preguntas de la última hoja.</p>

<h2>Para pensar</h2>
<p>Las ofertas de crédito se anuncian con la tasa más pequeña posible, y los cobros "adicionales" aparecen después. <strong>¿Es suficiente que una norma obligue a informar el costo total, o también hace falta que las personas aprendan a exigirlo y a calcularlo? Y cuando quien necesita el crédito está urgido, ¿cómo se protege su decisión de la prisa?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ofertas}}' => $img('comparar-creditos-ofertas', 499, 'Tabla que compara dos ofertas de un crédito de 20 millones a 36 meses: tasa anunciada 20,0 % y 22,5 %, cuota total, costo total 8.184.053 y 7.361.286, y tasa real 27,16 % y 23,91 %.', 'Dos ofertas: la tasa anunciada engaña.'),
    '{{img:pasos}}' => $img('comparar-creditos-pasos', 467, 'Cinco pasos para comparar créditos: pedir lo mismo, anotar todo, calcular, preguntar y decidir con el presupuesto.', 'Cinco pasos antes de elegir.'),
]);

return [
    'slug' => 'comparar-dos-ofertas-de-credito-en-excel-tasa-real-costo-total-comparador',
    'title' => 'Comparar dos ofertas de crédito en Excel: tasa real, costo total y preguntas antes de firmar (comparador)',
    'excerpt' => 'La tasa más baja no siempre es la más barata. Un comparador en Excel calcula la cuota, el costo total y la tasa efectiva anual real que incluye seguros y comisiones, con tabla de amortización y lista de preguntas.',
    'seo_title' => 'Comparar dos ofertas de crédito en Excel: comparador',
    'seo_description' => 'Compara dos créditos en Excel: cuota, costo total y tasa real con seguros y comisiones, amortización y preguntas antes de firmar.',
    'focus_keyword' => 'comparar ofertas de crédito en Excel',
    'cover' => '/assets/img/articulos/comparar-creditos/comparar-creditos-portada',
    'cover_alt' => 'Portada "Comparar dos ofertas de crédito en Excel: la tasa más baja no siempre es la más barata" con una tarjeta: 822.768 pesos más cuesta la oferta con la tasa anunciada más baja, 20,0 % frente a 22,5 %.',
    'published_at' => '2027-01-07 12:00:00',
    'content_html' => $html,
];
