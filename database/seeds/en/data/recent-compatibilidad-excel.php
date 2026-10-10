<?php

declare(strict_types=1);

// English version of "El libro funciona en tu equipo, ¿y en el de otra persona? Compatibilidad de Exce…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/compatibilidad-excel/' . $name . '-en';
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
<p>"I will send you the file." And the next day: "It will not open.", "I get #NAME? everywhere.", "The totals do not match yours.", "It asks me to update links I do not know what they are". An Excel workbook that works perfectly on your computer can fail on a colleague's, a secretariat's or a customer's. Not because Excel is bad, but because <strong>a workbook depends on things that do not travel with the file</strong>: the Excel version, the regional settings, other files, add-ins and even the name of your folder.</p>
<p>This article explains the most frequent causes of incompatibility, with tests done in Microsoft Excel 16, a <a href="/descargas/compatibilidad-excel/revisar_compatibilidad_xlsx.py">Python workbook checker</a> that reads the file without opening Excel and an <a href="/descargas/compatibilidad-excel/lista-compatibilidad-excel.xlsx">Excel checklist</a> (in Spanish). Verified on October 10, 2026.</p>
<p class="notice"><strong>Summary.</strong> Before sending a workbook, check four things: <strong>the recent functions</strong> it uses (they give #NAME? in old versions), <strong>the regional settings</strong> (a text "1,5" gives a number in Colombia and an error with US settings, I tested it), <strong>links and macros</strong> and <strong>metadata</strong> (author, your folder path, hidden sheets). And above all, <strong>test it on another machine</strong> or in Excel for the Web.</p>

<h2>Cause 1: recent functions</h2>
<p>Excel adds functions with each version. The most used today (<code>XLOOKUP</code>, <code>FILTER</code>, <code>UNIQUE</code>, <code>SORT</code>, <code>LET</code>) belong to Excel 2021 and Microsoft 365; in earlier versions the workbook opens, but those cells show #NAME? and everything that depends on them breaks. An intermediate group (<code>IFS</code>, <code>SWITCH</code>, <code>CONCAT</code>, <code>TEXTJOIN</code>, <code>MAXIFS</code>) arrived with Excel 2019; the forecasting ones (<code>FORECAST.ETS</code>) with Excel 2016. Old functions (<code>VLOOKUP</code>, <code>SUMIFS</code>, <code>IFERROR</code>) work almost everywhere. The "Funciones_por_version" sheet in the workbook has a table with a universal alternative for each; these are approximate minimum versions, so <strong>always confirm on Microsoft's support page for each function</strong> and on the destination's version.</p>
<p>How do you know which ones your workbook uses? An .xlsx file is a ZIP of XML, and recent functions are stored with the <code>_xlfn.</code> prefix (for example, <code>_xlfn.XLOOKUP</code>). The checker counts them by reading the file.</p>

<h2>Cause 2: regional settings</h2>
<p>This is the most treacherous, because the workbook "works" and gives different results. In Colombia we use a decimal comma and a thousands dot (1.234,5); in the US, the opposite (1,234.5); formula argument separators (<code>;</code> or <code>,</code>) and even function names change with the language. Workbooks store formulas in a universal form, so that usually resolves itself; the problem is <strong>data stored as text</strong>.</p>
<p>I tested it in Excel by deliberately changing the separators. A cell with the text <code>1,5</code> and the formula <code>=VALUE(A3)</code>:</p>
<table>
<thead><tr><th>Setting</th><th>VALUE("1,5")</th><th>VALUE("1.234,5")</th><th>VALUE("1,234.5")</th></tr></thead>
<tbody>
<tr><td><strong>Colombia (decimal comma)</strong></td><td>1,5</td><td>1234,5</td><td>1234,5</td></tr>
<tr><td><strong>US (decimal point, thousands comma)</strong></td><td>#VALUE!</td><td>#VALUE!</td><td>1234.5</td></tr>
</tbody>
</table>
<p>That is: the same text gives a number on one machine and an error on another. The workbook's "Prueba_1_5" sheet reproduces it. The defense: <strong>store numbers as numbers and dates as real dates</strong> (with formatting), not as text, and avoid converting them with functions that depend on the region. Dates work the same way: "03/04/2026" is April 3 in Colombia and March 4 in the US; use the <code>yyyy-mm-dd</code> format, which is unambiguous. With CSV files, the separator also changes (see <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importing CSV correctly</a>).</p>

<h2>Cause 3: links, connections and macros</h2>
<ul>
<li><strong>Links to other workbooks</strong> store a path; if the other file is not at the same path on the recipient's machine, Excel asks to update and shows old values or errors. If you need the values, paste them as values before sending.</li>
<li><strong>Data connections</strong> (to databases, other workbooks or the web) depend on permissions and drivers the destination may lack.</li>
<li><strong>Macros (.xlsm)</strong>: many machines block them for security, and Excel for the Web does not run them; on Mac there are differences. If the workbook works without macros, send it without them.</li>
<li><strong>Add-ins and fonts</strong> that exist only on your machine change the look or break functions.</li>
</ul>

<h2>Cause 4: metadata and data that travel without your noticing</h2>
<p>A workbook carries more than you see: the author and the last user who saved it, sometimes the <strong>path of your folder</strong>, hidden sheets, comments and versions. My own experience: when running the checker over this site's downloadable workbooks, I found that <strong>three of them (those I saved from Excel) carried the path of my working folder</strong> in the file. It was not serious, but it revealed my username and my folder structure. I cleaned them. It is the kind of thing you only see if you look for it. In Excel, <em>File, Info, Check for Issues, Inspect Document</em> helps remove this kind of data (and hidden sheets or columns with information you do not want to share).</p>

<h2>The Python checker, with real results</h2>
<p>The checker (about 70 lines, standard library only) reads the file and reports: recent functions, links, connections, macros, hidden sheets, paths and the author. I ran it on workbooks from this site:</p>
{{img:revisor}}
<pre><code>listas-desplegables-dependientes.xlsx
  funciones recientes: ANCHORARRAY (3), FILTER (2), SORT (2), UNICHAR (6), UNIQUE (2)
  vínculos a otros libros: 0 | conexiones de datos: no | macros: no
  hojas ocultas: ninguna | referencias a rutas absolutas: 0
  autor y último en guardar: openpyxl, EDWIN ORTIZ
  ! Usa funciones recientes: en versiones antiguas darán #¿NOMBRE?; confirma la versión mínima de cada una

tablero-cartera-colegio.xlsx
  funciones recientes: ninguna
  vínculos a otros libros: 0 | conexiones de datos: no | macros: no
  Sin señales de incompatibilidad en esta revisión.</code></pre>
<p>Notice what it found: the workbooks that use <code>FILTER</code>, <code>SORT</code>, <code>UNIQUE</code> or <code>XLOOKUP</code> warn that they require Excel 2021 or Microsoft 365 (and I say so in each one, in their articles); the forecasting ones, Excel 2016 or later; and the receivables dashboard, which uses classic functions, gives no risk signals. Notice also the functions "<code>ANCHORARRAY</code>" and "<code>UNICHAR</code>": the first is the spill <code>#</code> operator (in the dependent lists' data validation) and the second is a recent text function; the checker counts them all the same. It is an aid for looking, not a verdict: <strong>it does not replace Excel's Compatibility Checker or testing the file at the destination</strong>.</p>

<h2>The "before sending" checklist</h2>
{{img:causas}}
<p>The "Antes_de_enviar" sheet has thirteen questions, each with its safe answer: do you know which version and system the recipient will use?, did you check the recent functions?, are there links that will break?, are there macros?, is there data as text that depends on the region?, are there hidden sheets?, did you remove the metadata?, did you test it on another machine or in Excel for the Web?, did you send a PDF for what should only be read?, is there a "Léeme" (read-me) sheet with instructions? The workbook counts the points to resolve: with everything on "No", it flags 8 points and says "Hay riesgos de compatibilidad o privacidad: revisa antes de enviar" (there are compatibility or privacy risks: check before sending); with everything resolved, it says "Listo para enviar (aun así, pruébalo en el destino)" (ready to send; still, test it at the destination).</p>

<h2>Practical rules</h2>
<ol>
<li><strong>Ask first</strong> which version of Excel and which system (Windows, Mac, Web, phone) the recipient will use.</li>
<li><strong>To read only, send a PDF.</strong> To edit, a clean .xlsx.</li>
<li><strong>Avoid recent functions</strong> if you are not sure about the destination, or offer a version with universal alternatives (see <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL!, #CALC! and #VALUE! errors</a>).</li>
<li><strong>Convert links to values</strong> and avoid absolute paths.</li>
<li><strong>Store numbers and dates as what they are</strong> and document assumptions in a "Léeme" sheet.</li>
<li><strong>Inspect the document</strong> before sending it.</li>
<li><strong>Test it on another machine</strong> or in Excel for the Web (free with a Microsoft account).</li>
<li><strong>If you share with many people who edit at once,</strong> consider a cloud workbook or, if it grows, a database (see <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">the seven signs</a>).</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, Excel workbooks circulate by email and messaging between machines with different versions and settings. In Colombia and Latin America the problem is worse for two reasons: the mix of versions (many offices and schools keep Excel 2016 or 2019 alongside Microsoft 365) and the fact that the Spanish of formulas and separators sets us apart from English tutorials. For <strong>teachers and secretariats</strong> who share lists, <strong>small businesses</strong> that send quotes and <strong>those who teach Excel</strong>, the rule is the same: test where it will be used. And for <strong>families</strong> who receive workbooks or lists from a school, a file opening well on a phone is part of access (see <a href="/accesibilidad-web-formularios-contraste-teclado-checklist-colegios-pymes/">accessibility</a>).</p>

<h2>Tested templates</h2>
<p>If you prefer templates made with classic functions, designed to work on most machines, look at these options. And there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a> for asking for help with your formulas; remember to check the minimum version of whatever it proposes.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla/">dependent drop-down lists</a>, <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">forecasting in Excel</a> and <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">a dashboard that helps you act</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Why does my workbook show #NAME? on another machine?</h3>
<p>Because it uses a function that version of Excel does not have (for example, XLOOKUP or FILTER in Excel 2019 or earlier). Use a universal alternative or confirm the destination's version.</p>
<h3>Why do numbers come out different in another country?</h3>
<p>Because of regional settings: a text like "1,5" is converted to a number or gives an error depending on the decimal separator. Store numbers as numbers, not text.</p>
<h3>How do I remove my personal data from a workbook?</h3>
<p>With File, Info, Check for Issues, Inspect Document; and review hidden sheets. The workbook checker shows the author and the saved path.</p>
<h3>Do macros work in Excel for the Web?</h3>
<p>VBA macros do not run in Excel for the Web; on Mac there are differences. If the workbook depends on macros, tell the recipient or find an alternative.</p>
<h3>Is it better to send a PDF?</h3>
<p>If the recipient only needs to read, yes: it looks the same on every machine and does not expose formulas or hidden sheets.</p>

<p class="notice"><strong>Before your next send.</strong> Run your workbook through the <a href="/descargas/compatibilidad-excel/lista-compatibilidad-excel.xlsx">compatibility checklist</a> (in Spanish) and run the <a href="/descargas/compatibilidad-excel/revisar_compatibilidad_xlsx.py">checker</a> (<code>python revisar_compatibilidad_xlsx.py your_workbook.xlsx</code>). And test it on another machine.</p>

<h2>Food for thought</h2>
<p>Sending an Excel workbook is handing over a small machine that assumes an environment we do not control. <strong>Who should make sure a file works on the other person's machine: the sender, the recipient or the institution that should standardize versions and formats? And when a badly made workbook changes a total without anyone noticing, whose responsibility is it?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:revisor}}' => $img('compatibilidad-excel-revisor', 499, 'Table with five sample workbooks checked with the script: dependent lists and Excel errors need Excel 2021 or 365, forecasting needs Excel 2016 or later and the receivables dashboard has no risk signals.', 'Five sample workbooks, checked.'),
    '{{img:causas}}' => $img('compatibilidad-excel-causas', 573, 'Four cards with the frequent reasons a workbook fails on another machine: recent functions, regional settings, links and macros, and metadata.', 'Why a workbook breaks on another machine.'),
]);

return [
    'compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional' => [
        'slug' => 'excel-workbook-compatibility-between-machines-versions-regional-settings',
        'title' => 'The Workbook Works on Your Machine, but on Someone Else\'s? Excel Compatibility Across Versions, Machines and Settings',
        'excerpt' => 'The four most frequent reasons an Excel workbook fails on another machine (recent functions, regional settings, links and macros, metadata), with Excel tests, a Python checker and a downloadable checklist.',
        'seo_title' => 'Excel Compatibility Between Machines: What to Check',
        'seo_description' => 'Why an Excel workbook fails on another machine and what to check before sending it: recent functions, regional settings, links, macros and metadata.',
        'focus_keyword' => 'Excel compatibility between machines',
        'cover' => '/assets/img/articulos/compatibilidad-excel/compatibilidad-excel-portada-en',
        'cover_alt' => 'Cover "The workbook works on your machine, but on someone else\'s? Compatibility in Excel" with a card: the text 1,5 gives a number with Colombia\'s settings and #VALUE! with US settings, and new functions give #NAME? in old versions.',
        'content_html' => $html,
    ],
];
