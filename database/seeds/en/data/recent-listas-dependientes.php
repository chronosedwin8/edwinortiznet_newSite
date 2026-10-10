<?php

declare(strict_types=1);

// English version of "Listas desplegables dependientes en Excel: el método clásico, el moderno y la ve…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/listas-dependientes/' . $name . '-en';
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
<p>An Excel form that collects data on students, customers or inventory has a constant enemy: <strong>what each person types in their own way</strong>. "Medellín", "medellin", "Medellin." and "MED" are the same municipality to a person and four different values to Excel (see <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">when Excel stops being the solution</a>). The simplest defense is <strong>drop-down lists</strong>, and the most useful are the <strong>dependent</strong> ones: when you choose a department, the next list offers only its municipalities.</p>
<p>This article explains two methods to chain lists: the <strong>classic</strong> one (defined names and <code>INDIRECT</code>, which works in any version) and the <strong>modern</strong> one (<code>UNIQUE</code>, <code>FILTER</code> and spill references, for Excel 2021 and Microsoft 365). It includes a <a href="/descargas/listas-dependientes/listas-desplegables-dependientes.xlsx">downloadable template</a> (in Spanish) with both methods, tested in Microsoft Excel 16 (es-CO), and the check almost nobody adds. Verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A dependent list is built from a single source table and chained with a formula. The modern method updates itself when you add rows and does not break with spaces in names; the classic one works in any version. Both have a weakness: <strong>if you change the first list, the value in the second stays</strong>, and an impossible combination can remain. The fix is a check cell that confirms the combination exists. All of this was tested with fictional data on departments, municipalities and schools.</p>

<h2>The source: a single table</h2>
<p>Before any formula, an orderly table in the "Listas" sheet with one row per combination:</p>
<table>
<thead><tr><th>Department</th><th>Municipality</th><th>School (fictional)</th></tr></thead>
<tbody>
<tr><td>Antioquia</td><td>Medellín</td><td>I. E. Ejemplo 01</td></tr>
<tr><td>Antioquia</td><td>Envigado</td><td>I. E. Ejemplo 03</td></tr>
<tr><td>Atlántico</td><td>Barranquilla</td><td>I. E. Ejemplo 07</td></tr>
<tr><td>…</td><td>…</td><td>…</td></tr>
</tbody>
</table>
<p>The template has 24 rows: 4 departments, 3 municipalities each and 2 schools per municipality. The golden rule: <strong>everything comes from this sheet</strong>; if a municipality must be added, it is added here and nowhere else.</p>

<h2>Modern method: UNIQUE, FILTER and the spill</h2>
{{img:pasos}}
<p>In a helper area (columns H to J of the form sheet) the three lists are computed:</p>
<pre><code>' In English                                                   (cell)
=SORT(UNIQUE(Listas!A2:A25))                                   ' H3: departments
=SORT(UNIQUE(FILTER(Listas!B2:B25, Listas!A2:A25=B4, "")))     ' I3: municipalities of the chosen department
=FILTER(Listas!C2:C25, (Listas!A2:A25=B4)*(Listas!B2:B25=B5), "")  ' J3: schools of the municipality

' In Spanish
=ORDENAR(UNICOS(Listas!A2:A25))
=ORDENAR(UNICOS(FILTRAR(Listas!B2:B25; Listas!A2:A25=B4; "")))
=FILTRAR(Listas!C2:C25; (Listas!A2:A25=B4)*(Listas!B2:B25=B5); "")</code></pre>
<p>Then, under <em>Data, Data Validation</em>, choose <em>List</em> and use the spill reference as the source, with the <code>#</code> sign: <code>=$H$3#</code> for the department (B4), <code>=$I$3#</code> for the municipality (B5) and <code>=$J$3#</code> for the school (B6). The <code>#</code> means "the whole range that formula spills", so the list grows or shrinks by itself. I checked that when choosing Antioquia, the second list offers Envigado, Itagüí and Medellín; and when switching to Atlántico, Barranquilla, Malambo and Soledad.</p>
<p>Advantages: no defined names or ranges to adjust, the lists come out sorted and without duplicates, and adding data in "Listas" updates everything (if the formulas' range covers it; using an Excel table as the source makes it automatic).</p>

<h2>Classic method: defined names and INDIRECT</h2>
<p>It works in any version of Excel. The idea: each department has its own column of municipalities, and each column is given a <strong>defined name equal to the department's name</strong> (under <em>Formulas, Name Manager</em>). Then the municipality validation uses:</p>
<pre><code>' Validation of the department list (B3): the header range
=Clasico_listas!$A$3:$D$3

' Validation of the municipality list (B4): INDIRECT turns the text in B3 into the name
=INDIRECT($B$3)           ' English
=INDIRECTO($B$3)          ' Spanish</code></pre>
<p>If B3 says "Antioquia", <code>INDIRECT</code> returns the range with that name, and the list shows its municipalities. It is the long-standing method, but it has quirks I tested:</p>
<ul>
<li><strong>Defined names do not allow spaces</strong>: a "Norte de Santander" requires a name like "Norte_de_Santander" and a formula <code>INDIRECT(SUBSTITUTE(B3," ","_"))</code>.</li>
<li>Each time you add a department, you must create its name and extend the header list.</li>
<li>If the department is empty, <code>INDIRECT</code> errors and the municipality list will not open.</li>
</ul>

<h2>The check almost nobody adds</h2>
<p>With either method there is a problem: <strong>if you choose Antioquia and Envigado, and then change the department to Atlántico, Excel leaves "Envigado" in the municipality cell</strong>. Validation only controls what is typed, not what was already there. I tested exactly that case: the result is an impossible combination nobody notices. The fix is a check cell:</p>
<pre><code>=IF(COUNTIFS(Listas!A2:A25, B4, Listas!B2:B25, B5, Listas!C2:C25, B6)=1,
    "Combinación válida", "Revisar: la combinación no existe")

=SI(CONTAR.SI.CONJUNTO(Listas!A2:A25; B4; Listas!B2:B25; B5; Listas!C2:C25; B6)=1;
    "Combinación válida"; "Revisar: la combinación no existe")</code></pre>
<p>In the test, with Antioquia, Envigado and "I. E. Ejemplo 03" the check says "Combinación válida" (valid combination); when changing the department to Atlántico and leaving the rest, it says "Revisar: la combinación no existe" (and conditional formatting turns it red). For the classic method, the equivalent check uses <code>COUNTIF(INDIRECT(B3), B4)</code>. If the form feeds a database or a report, <strong>make submission conditional on the check being valid</strong>.</p>

<h2>Classic or modern: which to choose</h2>
{{img:comparacion}}
<table>
<thead><tr><th>Situation</th><th>Choose</th></tr></thead>
<tbody>
<tr><td>The workbook will be used by people with old versions of Excel</td><td>Classic</td></tr>
<tr><td>The lists change often (municipalities or schools are added)</td><td>Modern</td></tr>
<tr><td>There are names with spaces or accents</td><td>Modern (or classic with SUBSTITUTE)</td></tr>
<tr><td>The form is in Excel for the Web or Microsoft 365</td><td>Modern</td></tr>
</tbody>
</table>

<h2>Common mistakes and how to avoid them</h2>
<ol>
<li><strong>Leaving validation in "Warning" or "Information" mode:</strong> it lets anything be typed. In <em>Error Alert</em>, the style must be <em>Stop</em>.</li>
<li><strong>Copying and pasting over cells with validation:</strong> pasting replaces the rule. Protect the sheet or paste values only.</li>
<li><strong>Typing the lists by hand in each form:</strong> use a single source.</li>
<li><strong>Forgetting the check</strong> and trusting that validation covers everything.</li>
<li><strong>Using #N/A or errors in the helper list:</strong> if FILTER finds nothing, the third argument <code>""</code> avoids the error (see <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL!, #CALC! and #VALUE! errors</a>).</li>
</ol>

<h2>Use cases in a school or a small business</h2>
<ul>
<li><strong>Enrollment:</strong> grade and group; or department, municipality and school.</li>
<li><strong>Attendance:</strong> area, teacher and group, so nobody types a different name.</li>
<li><strong>Inventory:</strong> category and subcategory.</li>
<li><strong>Orders:</strong> customer and branch.</li>
</ul>
<p>When volume grows and several people edit at once, that is the sign to move to a database (see the seven signs) or to a specific tool.</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, data validation is among the cheapest and most effective data-quality practices. In Colombia and Latin America the challenge is twofold: list separators and functions in Spanish (<code>;</code> instead of <code>,</code>, <code>FILTRAR</code> instead of <code>FILTER</code>), which make formulas from English tutorials fail when copied, and name normalization (accents, "Bogotá D. C.", "Norte de Santander"), which the drop-down list solves at the root. For <strong>teachers and education secretariats</strong> building attendance lists, <strong>small businesses</strong> with orders by branch and <strong>those who teach Excel</strong>, this technique is among the most rewarding: a well-made list avoids hours of cleaning later (see <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importing CSV correctly</a>).</p>

<h2>Templates to work in an orderly way</h2>
<p>If you want an attendance list with controls already built, or invoicing templates with automatic numbering, these options are ready to use, with optional support. And there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a> for asking for help with your formulas, always verifying the result.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">forecasting in Excel</a>, <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a> and <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">how to automate in Excel</a>.</p>

<h2>Frequently asked questions</h2>
<h3>How do I create a dependent drop-down list in Excel?</h3>
<p>With a source table, a helper list that depends on the previous choice (with FILTER or with defined names and INDIRECT) and a List-type data validation pointing to that list.</p>
<h3>What does the # sign mean in data validation?</h3>
<p>It is the spill operator: it refers to the whole range occupied by the result of a dynamic array formula, so the list adjusts by itself.</p>
<h3>Does it work in old versions of Excel?</h3>
<p>The classic method does. UNIQUE, FILTER and SORT require Excel 2021 or Microsoft 365.</p>
<h3>Why does the second list keep the old value when I change the first?</h3>
<p>Because validation only controls what is typed, not values already present. Add a check cell that confirms the combination exists.</p>
<h3>What do I do with names with spaces in the classic method?</h3>
<p>Defined names do not allow spaces: use an underscore in the name and SUBSTITUTE in the INDIRECT formula.</p>

<p class="notice"><strong>Try it now.</strong> Download the <a href="/descargas/listas-dependientes/listas-desplegables-dependientes.xlsx">dependent lists template</a> (in Spanish), replace the data in the "Listas" sheet with yours and keep the check cell. It includes both methods and a problems-and-solutions sheet. The modern method requires Excel 2021 or Microsoft 365.</p>

<h2>Food for thought</h2>
<p>A drop-down list keeps each person from typing the data in their own way, but it also decides which options exist. <strong>Who should control the lists in a form (whoever designs it, whoever uses it or whoever answers for the data)? And when a list does not include someone's reality (a new municipality, a different name), should the list change or should the person adjust?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:pasos}}' => $img('listas-dependientes-pasos', 467, 'Five steps of the modern method: a single source, first list with SORT and UNIQUE, dependent list with FILTER, validation pointing to the spill and a check cell.', 'Five steps with UNIQUE, FILTER and the spill.'),
    '{{img:comparacion}}' => $img('listas-dependientes-comparacion', 499, 'Table comparing the classic INDIRECT method and the modern spill method: Excel version, setup, what happens when data is added and names with spaces.', 'Two ways to chain lists.'),
]);

return [
    'listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla' => [
        'slug' => 'dependent-drop-down-lists-excel-classic-and-modern-method-template',
        'title' => 'Dependent Drop-Down Lists in Excel: The Classic Method, the Modern One and the Check Almost Nobody Adds',
        'excerpt' => 'How to chain drop-down lists in Excel (department, municipality, school) with INDIRECT and with UNIQUE and FILTER, a check cell against impossible combinations and a downloadable template tested in Excel.',
        'seo_title' => 'Dependent Drop-Down Lists in Excel (Template)',
        'seo_description' => 'How to create dependent drop-down lists in Excel with INDIRECT and with FILTER and UNIQUE, with combination checks and a downloadable template.',
        'focus_keyword' => 'dependent drop-down lists Excel',
        'cover' => '/assets/img/articulos/listas-dependientes/listas-dependientes-portada-en',
        'cover_alt' => 'Cover "Dependent drop-down lists in Excel: the classic method and the modern one" with a card of three chained lists: department Antioquia, municipality Envigado, school I. E. Ejemplo 03 and the check "Valid combination".',
        'content_html' => $html,
    ],
];
