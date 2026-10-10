<?php

declare(strict_types=1);

// English version of «Conciliar dos listados en Excel con fórmulas: las trampas de CONTAR.SI y del sig…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/conciliar-listados-excel/' . $name . '-en';
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
<p>You have two lists of the same group, one from the school management system and one from the virtual classroom, and you need to know how many students differ. You open Excel, write a formula counting how many codes from list A appear in list B and the result says almost all do. Until you discover that <strong>Excel considers the code "0012" and the code "12" equal</strong>, and that it has just hidden a student who is wrongly registered. Reconciling lists in Excel is easy; reconciling them <em>well</em> requires knowing two traps.</p>
<p>An earlier article compared a pair of lists with a <a href="/un-dato-varias-versiones-conciliar-sistema-gestion-aula-virtual-teams-conciliador/">Python reconciler</a>. This is the same exercise, with the <strong>same fictional data, but done only with Excel formulas</strong>, for those who do not use Python: an <a href="/descargas/conciliar-listados-excel/conciliar-dos-listados-con-formulas.xlsx">Excel workbook</a> (in Spanish) that normalizes text, looks up each key of one list in the other, compares field by field and summarizes the differences. The results match the script's exactly. Verified in Microsoft Excel 16 (es-CO regional settings) on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional. Real lists contain personal data of minors: work with them only on your institution's secure machines and spaces, do not upload them to external services or free AI tools and delete working files when finished. Function names are in Spanish in the workbook; the English equivalents are shown in the formulas.</p>

<h2>The two traps</h2>
<h3>Trap 1: COUNTIF treats "0012" as 12</h3>
<p>The <code>COUNTIF</code> function converts a criterion that looks like a number into a number. If list A has the text code "0012" and list B has "12" (because an import lost the leading zero), <code>=COUNTIF(ListB, "0012")</code> returns 1: Excel reads both as the number 12 and considers the student found. In the workbook, the first attempt with <code>COUNTIF</code> gave "En ambos" (in both) for code 0012, and when trying to fetch its data with <code>MATCH</code> the result was <code>#N/A</code> (because <code>MATCH</code> does compare the texts as they are). The fix is to compare exact text with <code>EXACT</code> inside <code>SUMPRODUCT</code>:</p>
<pre><code>' Trap: gives 1 even if B has "12" and A has "0012"
=COUNTIF(Lista_B!$A$4:$A$63, A4)                                 ' English
=CONTAR.SI(Lista_B!$A$4:$A$63; A4)                              ' Spanish

' Correct: exact text comparison
=SUMPRODUCT(--EXACT(Lista_B!$A$4:$A$63, A4))                     ' English
=SUMAPRODUCTO(--IGUAL(Lista_B!$A$4:$A$63; A4))                   ' Spanish</code></pre>
<h3>Trap 2: the = sign does not distinguish capitals</h3>
<p>In Excel, <code>="Ángel Ruiz"="ÁNGEL Ruiz"</code> gives <code>TRUE</code>. To detect that two texts were written differently, you must use <code>EXACT</code>, which does distinguish capitals. In the workbook, "Ángel Ruiz" versus "ÁNGEL Ruiz" showed up as "Igual" (equal) with the = sign and as "Solo formato" (format only) with <code>EXACT</code>, which is right: the difference exists, but it is not a real conflict.</p>
{{img:funciones}}

<h2>The workbook, sheet by sheet</h2>
<ul>
<li><strong>Lista_A</strong> and <strong>Lista_B:</strong> the two lists, with the code stored as <strong>text</strong> (format <code>@</code>). If you paste new data, do it as text or the leading zeros will be lost.</li>
<li>In <strong>Lista_A</strong>, calculated columns: the normalized name, the key status (in both, only in A, possible lost leading zero), the data B holds for that key and the result of comparing name, email and class (equal, format only or conflict).</li>
<li>In <strong>Lista_B</strong>: each key's status (in both, only in B or possible lost zero).</li>
<li><strong>Resumen:</strong> the counts.</li>
</ul>
<pre><code>' Normalized name: lowercase, no extra spaces and no accents
=SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(SUBSTITUTE(LOWER(TRIM(B4)),"á","a"),"é","e"),"í","i"),"ó","o"),"ú","u")   ' English
=SUSTITUIR(SUSTITUIR(SUSTITUIR(SUSTITUIR(SUSTITUIR(MINUSC(ESPACIOS(B4));"á";"a");"é";"e");"í";"i");"ó";"o");"ú";"u")   ' Spanish

' Key status
=IF(SUMPRODUCT(--EXACT(Lista_B!$A$4:$A$63,A4))>0,"En ambos",
   IF(SUMPRODUCT(--EXACT(Lista_B!$A$4:$A$63,TEXT(VALUE(A4),"0")))>0,"Posible cero perdido","Solo en A"))

' B's datum for A's key (only if in both)
=INDEX(Lista_B!$B$4:$B$63, MATCH(A4, Lista_B!$A$4:$A$63, 0))

' Compare names: equal, format only or conflict
=IF(EXACT(B4,G4),"Igual",IF(E4=normalized_of_G4,"Solo formato","Conflicto"))</code></pre>
<p>Each part is simple; the value is in combining them carefully. In particular, the order of the checks matters: exact equality first, then equality after normalizing, and only then conflict. That way the report is not filled with false alarms.</p>

<h2>What the workbook shows (the same data as the Python reconciler)</h2>
<p>List A has 30 rows and B has 29. Results from the <em>Resumen</em>:</p>
<ul>
<li><strong>27 keys in both lists.</strong></li>
<li><strong>2 only in A</strong> (codes 0027 and 0029: students not in the virtual classroom) and <strong>1 only in B</strong> (0099, a record that matches no student on the master list).</li>
<li><strong>1 possible lost leading zero:</strong> 0012 in A and 12 in B.</li>
<li><strong>3 name differences that are format only</strong> (capitals, accents or double spaces).</li>
<li><strong>6 real conflicts:</strong> 2 in the name (for example, "Camilo Torres" versus "Camilo Torrez"), 2 in the email (a domain with a changed letter) and 2 in the class (7B versus 8A, 7A versus 8B).</li>
</ul>
<p>That adds up to <strong>9 of 30 students with a real problem</strong> (2 missing, 1 lost zero and 6 with conflicts), the same as the Python script. Two independent tools reaching the same result is the best proof that neither is wrong.</p>
{{img:pasos}}

<h2>How to use it with your lists</h2>
<ol>
<li><strong>Export both lists the same day</strong> and paste them in the Lista_A and Lista_B sheets, columns A to D, with the code as text. If the system exports the code as a number, convert it to text with zeros before comparing.</li>
<li><strong>If you have more than 60 rows,</strong> extend the formulas down and adjust the ranges (in the workbook they reach row 63; for longer lists, turn the ranges into tables or widen them).</li>
<li><strong>Look at the keys first</strong> (missing and lost zeros) and then the conflicts. Filter by "Conflicto" in each column.</li>
<li><strong>Fix in the master system,</strong> not in the list; if you fix the copy, the error will return.</li>
<li><strong>Repeat</strong> before each grading cut-off.</li>
</ol>
<p>If you work with lists of thousands of rows, Excel 365 offers <code>XLOOKUP</code> and Power Query, which are more convenient and faster; the text and capitalization traps remain, so the method of normalizing and comparing exactly still holds. And if the reconciliation repeats every month, a script (like the Python one) is easier to automate. For data traveling between systems, see <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">how to import CSV into Excel without damaging IDs and dates</a>.</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, schools constantly cross lists: enrollment reports, attendance lists, platform users and classes. It is almost always done in spreadsheets, with the traps we have seen. In the region and worldwide, school data quality is a recurring topic of education management; Colombia's Law 1581 of 2012 includes, among the principles of personal data processing, truthfulness or quality (verify the current text). For <strong>coordinators</strong>, monthly reconciliation is a concrete way of caring for students' data; for <strong>secretaries and IT staff</strong>, a workbook like this saves hours; for <strong>teachers</strong>, it prevents "their list" from differing from the official one; and for <strong>families</strong>, that communications reach whoever they should. See also <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL! and #VALUE! errors</a> and <a href="/compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional/">Excel workbook compatibility between machines</a>.</p>

<h2>Templates and tools</h2>
<p>If you prefer to start from ready-made Excel templates, with support, look at these options. And to ask an AI for help with your formulas (always verifying the result and without pasting student data into free tools), there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas/">auditing the school timetable in Excel</a>, <a href="/ausentismo-escolar-excel-asistencia-ausentismo-cronico-rachas-patrones/">school absenteeism in Excel</a> and <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">the school budget in Excel</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Why does COUNTIF say "0012" and "12" are equal?</h3>
<p>Because it converts a criterion that looks like a number into a number, so both are read as 12. To compare exact text, use EXACT inside SUMPRODUCT.</p>
<h3>Does the = sign distinguish capitals in Excel?</h3>
<p>No. To distinguish them, use EXACT.</p>
<h3>How do I compare names with different accents?</h3>
<p>By normalizing first: lowercase, extra spaces removed and accents replaced with SUBSTITUTE, and comparing the results.</p>
<h3>Can I use VLOOKUP?</h3>
<p>Yes, with exact match (last argument FALSE), with the same precautions about the key's format. MATCH with INDEX is more flexible because it allows looking to the left.</p>
<h3>Can it be automated?</h3>
<p>With Power Query or a script (like the Python one in the previous article), especially if the reconciliation repeats every month.</p>

<p class="notice"><strong>Try it with your lists.</strong> Download the <a href="/descargas/conciliar-listados-excel/conciliar-dos-listados-con-formulas.xlsx">formula-based reconciliation workbook</a> (in Spanish), first check that it reproduces the example's results and then paste your two lists (with the code as text).</p>

<h2>Food for thought</h2>
<p>A formula that "almost always works" is more dangerous than one that fails in plain sight, because it gives confidence precisely where distrust is needed. <strong>How many of the figures our school reports each year depend on a formula nobody has tested with a hard case? And what would it cost, in time and care for the data, to test each formula once with the case you fear most?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:funciones}}' => $img('conciliar-listados-excel-funciones', 553, 'Table with five Excel functions to reconcile lists, what each is for and its trap: COUNTIF, MATCH, EXACT, TRIM and LOWER, and SUBSTITUTE.', 'What each does and where it fails.'),
    '{{img:pasos}}' => $img('conciliar-listados-excel-pasos', 467, 'Five steps of reconciliation with formulas: paste, normalize, look up, compare and summarize.', 'Five steps in a spreadsheet.'),
]);

return [
    'conciliar-dos-listados-en-excel-con-formulas-trampas-contar-si-igual-libro' => [
        'slug' => 'reconcile-two-lists-in-excel-with-formulas-countif-exact-traps-workbook',
        'title' => 'Reconciling Two Lists in Excel with Formulas: The Traps of COUNTIF and the = Sign (Verified Workbook)',
        'excerpt' => 'How to compare two student lists with Excel formulas only: normalize text, look up keys, detect lost zeros and conflicts, and avoid two traps (COUNTIF treats 0012 as 12 and the = sign ignores capitals).',
        'seo_title' => 'Reconcile Two Lists in Excel with Formulas',
        'seo_description' => 'Reconcile two student lists in Excel with formulas: normalize, look up keys and compare, and avoid the COUNTIF and = sign traps with a verified workbook.',
        'focus_keyword' => 'reconcile two lists in Excel',
        'cover' => '/assets/img/articulos/conciliar-listados-excel/conciliar-listados-excel-portada-en',
        'cover_alt' => 'Cover "Reconciling two lists in Excel: the traps of COUNTIF and the = sign" with a card: 0012 = 12 for COUNTIF, the trap that hides a different student.',
        'content_html' => $html,
    ],
];
