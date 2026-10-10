<?php

declare(strict_types=1);

// English version of «#N/A, #SPILL!, #CALC! y #VALUE!: qué significan los errores de Excel y cómo arre…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/errores-excel/' . $name . '-en';
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
<p>An Excel error is scary: a cell full of #N/A, another with #VALUE!, a spill that will not spill. The most common reaction is to cover it with <code>IFERROR</code> and move on. It is the worst idea: <strong>you hide the symptom and leave the cause</strong>, and next time the error will no longer be visible even if the numbers are wrong.</p>
<p>This article explains four errors that appear more and more with modern functions (#N/A, #SPILL!, #CALC! and #VALUE!), what they really mean and how to fix <strong>the cause</strong>. Each comes with a worked exercise in an <a href="/descargas/errores-excel/errores-excel-ejercicios.xlsx">exercise workbook with solutions</a> (in Spanish). Everything was tested in Microsoft Excel 16 with es-CO regional settings (in Spanish the errors are called #N/D, #¡DESBORDAMIENTO!, #CALC! and #¡VALOR!). Verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> An Excel error almost always has a small, concrete cause: an extra space, a cell in the way, a filter with no results, text where a number belonged. <strong>Read the error, find the cause, fix the cause</strong> and, only if it is an expected case (for example, "no results"), use the argument provided to handle it. Avoid wrapping everything in IFERROR.</p>

<h2>Why not cover errors with IFERROR</h2>
<p><code>=IFERROR(formula, "")</code> makes any error disappear, even those that mean something is broken. If you look up the price of a code and the code does not exist, do you want to see a blank or an alarm? A blank can end up summed as zero in a total (see <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a>). Rule of thumb: <strong>handle expected cases explicitly</strong> (with the argument the function offers for that) and leave unexpected ones visible.</p>

<h2>Exercise 1: #N/A</h2>
<p><strong>Situation.</strong> The office types the code <code>"A-107 "</code> (with a trailing space) and looks up its price in a list of 12 school-supply products:</p>
<pre><code>=XLOOKUP(B3, Datos!A2:A13, Datos!C2:C13)        ' English
=BUSCARX(B3; Datos!A2:A13; Datos!C2:C13)        ' Spanish
' Result: #N/A (#N/D in Spanish)</code></pre>
<p><strong>Cause.</strong> The code exists, but the one typed has a trailing space and is not identical to the one in the list. #N/A means "not available": the lookup value was not found.</p>
<p><strong>Solution.</strong> Clean the lookup value and explicitly handle the case where it does not exist:</p>
<pre><code>=XLOOKUP(TRIM(B3), Datos!A2:A13, Datos!C2:C13, "No existe")
=BUSCARX(ESPACIOS(B3); Datos!A2:A13; Datos!C2:C13; "No existe")
' Result: 95000</code></pre>
<p>Other frequent causes of #N/A: looking up a number against data stored as text (or the reverse), differences in accents or hyphens, and lookup ranges misaligned with the results range. See also <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importing CSV correctly</a>, where many of these problems begin.</p>

<h2>Exercise 2: #SPILL!</h2>
<p><strong>Situation.</strong> A single formula must list all products priced above 60,000, spilling the result across several rows and columns:</p>
<pre><code>=FILTER(Datos!A2:E13, Datos!C2:C13>60000)     ' English
=FILTRAR(Datos!A2:E13; Datos!C2:C13>60000)    ' Spanish</code></pre>
<p>The formula is well written, but the cell shows #SPILL!.</p>
<p><strong>Cause.</strong> The result occupies 5 rows and 5 columns (the filter returns five products), and in that range there is a cell with a forgotten note. A dynamic array formula needs the entire spill range to be free. When you select the cell, Excel marks the range with a dotted border, and the error menu offers to select the obstructing cells.</p>
<p><strong>Solution.</strong> Delete or move the note (or move the formula to a free area). The formula does not change. I tested removing the note and the result spilled from A-101 to A-110. Other causes of #SPILL!: merged cells in the way, an Excel table (spills are not allowed inside a table) and a result larger than the sheet.</p>

<h2>Exercise 3: #CALC!</h2>
<p><strong>Situation.</strong> You are asked to list the products priced above 10,000,000, and none qualifies:</p>
<pre><code>=FILTER(Datos!A2:E13, Datos!C2:C13>10000000)
=FILTRAR(Datos!A2:E13; Datos!C2:C13>10000000)
' Result: #CALC!</code></pre>
<p><strong>Cause.</strong> The filter found no rows and an empty array cannot be displayed; Excel flags it as #CALC!. It is not a failure of your formula; it is an expected case.</p>
<p><strong>Solution.</strong> Use FILTER's third argument (<code>if_empty</code>) to decide what to show:</p>
<pre><code>=FILTER(Datos!A2:E13, Datos!C2:C13>10000000, "Sin resultados")
=FILTRAR(Datos!A2:E13; Datos!C2:C13>10000000; "Sin resultados")</code></pre>
<p>This is the case where handling the error is appropriate: it is expected and there is an argument designed for it, with no need for IFERROR.</p>

<h2>Exercise 4: #VALUE!</h2>
<p><strong>Situation.</strong> You want to compute the inventory value of product A-109 (price times units):</p>
<pre><code>=Datos!C10*Datos!D10
' Result: #VALUE! (#¡VALOR! in Spanish)</code></pre>
<p><strong>Cause.</strong> Cell D10 contains the text <code>"12 unidades"</code> instead of the number 12, and Excel cannot multiply by text that is not a number. With a text that does look like a number (such as "1.200" stored as text) Excel sometimes converts it by itself; with "12 unidades" it does not.</p>
<p><strong>Solution.</strong> The right one is to <strong>fix the data</strong>: type 12 and put the unit in the header, and add <em>data validation</em> to the column so it only accepts whole numbers. If you cannot touch the source, extract the number:</p>
<pre><code>=Datos!C10*VALUE(LEFT(Datos!D10, FIND(" ", Datos!D10)-1))
=Datos!C10*VALOR(IZQUIERDA(Datos!D10; ENCONTRAR(" "; Datos!D10)-1))
' Result: 540000</code></pre>
<p>But this is a patch: the cause is that someone typed text where a number belonged, and it will happen again.</p>
{{img:diagnostico}}

<h2>The other frequent errors</h2>
<table>
<thead><tr><th>Error</th><th>Means</th><th>First check</th></tr></thead>
<tbody>
<tr><td><strong>#DIV/0!</strong></td><td>Division by zero or an empty cell</td><td>Check the divisor; control with IF</td></tr>
<tr><td><strong>#REF!</strong></td><td>A reference no longer exists</td><td>A row, column or sheet used was deleted</td></tr>
<tr><td><strong>#NAME?</strong></td><td>Excel does not recognize a name</td><td>Misspelled function or text without quotes</td></tr>
<tr><td><strong>#NUM!</strong></td><td>Invalid number for the operation</td><td>Square root of a negative or a result that is too large</td></tr>
</tbody>
</table>
<p>I checked in Excel that <code>=B1/0</code> gives #DIV/0!, <code>=SQRT(-1)</code> gives #NUM! and a nonexistent function gives #NAME?. The workbook has a "Guia_errores" sheet with all eight errors.</p>

<h2>A four-step method</h2>
<ol>
<li><strong>Read the error:</strong> each points to a family of causes.</li>
<li><strong>Evaluate the formula in parts:</strong> under <em>Formulas</em>, "Evaluate Formula" shows each step, and F9 on a selected part calculates only that part.</li>
<li><strong>Check the input data:</strong> spaces, text versus numbers, blank cells, types.</li>
<li><strong>Fix the cause</strong> and only then decide whether that case is handled explicitly.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, most spreadsheet errors come from dirty data, not badly written formulas. In Colombia and Latin America there is an added obstacle: separators. Our regional settings use a decimal comma and a thousands dot, and functions have different names in Spanish (BUSCARX, FILTRAR, SI.ERROR), so copying formulas from English tutorials often produces errors. For <strong>teachers</strong> keeping grades, <strong>administrative staff</strong> with inventories and invoices and <strong>small businesses</strong>, understanding the causes keeps a silent cell from becoming a wrong total. And for those who teach Excel, these four exercises serve as diagnostic practice.</p>

<h2>Templates and tools to work in an orderly way</h2>
<p>If you want your data in order from the source, these templates include validations and controls. And there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a> for asking an AI to help with your formulas, always verifying what it returns.</p>
{{productos:convertidor-de-numeros-a-letras-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">when Excel stops being the solution</a>, <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">forecasting in Excel</a> and <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">charts that lie</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What does #N/A mean in Excel?</h3>
<p>That the lookup value was not found. The most frequent cause is extra spaces or type differences (text versus number). Clean with TRIM and use the "if not found" argument.</p>
<h3>Why does #SPILL! appear and how do I fix it?</h3>
<p>Because the result of a dynamic formula does not fit: there are occupied cells, merged cells or a table in the spill range. Free the range.</p>
<h3>What is the difference between #CALC! and #VALUE!?</h3>
<p>#CALC! indicates a calculation problem, such as an empty array; #VALUE! indicates a value of the wrong type, such as text where a number was expected.</p>
<h3>Is IFERROR bad?</h3>
<p>Not always, but using it for everything hides real problems. Use it when the error is expected and no specific argument exists, not to cover up failures.</p>
<h3>Do these errors exist in older versions of Excel?</h3>
<p>#N/A and #VALUE! have existed for decades. #SPILL! and #CALC! appear with the dynamic arrays of modern Excel (Microsoft 365 and Excel 2021 or later).</p>

<p class="notice"><strong>Practice now.</strong> Download the <a href="/descargas/errores-excel/errores-excel-ejercicios.xlsx">exercise workbook</a> (in Spanish), solve the four sheets and compare with "Soluciones". It requires Excel 2021 or Microsoft 365 (XLOOKUP and FILTER).</p>

<h2>Food for thought</h2>
<p>A visible error is an opportunity: it tells you something is wrong. A covered error is a debt. <strong>Should organizations ban the indiscriminate use of IFERROR in workbooks that move money, grades or decisions, and require every error to be explained and resolved? Or is that an exaggeration that would choke the agility that made Excel popular?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:diagnostico}}' => $img('errores-excel-diagnostico', 499, 'Table with four Excel errors, the cause in the example and the fix: #N/A from a trailing space, #SPILL! from a note in the range, #CALC! from a filter with no rows and #VALUE! from text instead of a number.', 'From error to cause to fix.'),
]);

return [
    'errores-excel-na-spill-calc-value-que-significan-como-arreglarlos' => [
        'slug' => 'excel-errors-na-spill-calc-value-what-they-mean-how-to-fix-them',
        'title' => '#N/A, #SPILL!, #CALC! and #VALUE!: What Excel Errors Mean and How to Really Fix Them',
        'excerpt' => 'Four Excel errors with modern functions, explained with solved and tested exercises: the cause of each, how to fix it without covering it with IFERROR and an exercise workbook with solutions and a quick guide.',
        'seo_title' => 'Excel Errors #N/A, #SPILL!, #CALC! and #VALUE!',
        'seo_description' => 'What the #N/A, #SPILL!, #CALC! and #VALUE! errors mean in Excel, how to fix their cause and an exercise workbook with solutions to practice.',
        'focus_keyword' => 'Excel errors N/A SPILL CALC VALUE',
        'cover' => '/assets/img/articulos/errores-excel/errores-excel-portada-en',
        'cover_alt' => 'Cover "#N/A, #SPILL!, #CALC! and #VALUE!: what they mean and how to really fix them" with a card of four errors and their cause: an extra space, a cell in the way, an empty list and text instead of a number.',
        'content_html' => $html,
    ],
];
