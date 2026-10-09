<?php

declare(strict_types=1);

// English version of «El riesgo oculto de Excel…». Key is the Spanish slug. Cases and sources checked on October 9, 2026; the commission case is
// hypothetical and all formulas and figures were tested in Microsoft Excel 16. Status and date come from the Spanish post via en/02_recent_posts.php
// (scheduled for Thursday, October 22, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/riesgo-excel-auditoria/' . $name . '-en';
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
<p>In almost every company, school and office there is an Excel file something important depends on: payroll, commissions, inventory, grades, the budget. Someone built it years ago, three other people have modified it and nobody remembers which one is "the good version". <strong>Nobody audits it, nobody versions it and yet it moves money and decides things.</strong></p>
<p>In this article I show you, with a case tested in Excel, how a seemingly small mistake can alter a total by almost 20% without anyone noticing; how to catch it with controls you can copy and paste; and how to organize an <strong>audit of your critical spreadsheets</strong>. Data and tools checked on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> Spreadsheet errors are common and often invisible: in a tested case with nine salespeople, three small mistakes made the commission total differ by 1,954,000 pesos (19%) and the total still "looked reasonable". The controls that catch it are simple formulas. What is missing is not technology but the habit of reviewing.</p>

<h2>What the evidence says: spreadsheet errors are the rule</h2>
<p>The most famous case is that of the economists Reinhart and Rogoff. In 2013, Herndon, Ash and Pollin <a href="https://www.newstatesman.com/business/economics/2013/04/statistic-cited-defend-austerity-partially-based-excel-error">discovered</a> that their spreadsheet averaged rows 30 to 44 instead of 30 to 49, leaving out five countries; that range error alone explained about 0.3 percentage points of difference in the average growth of high-debt countries. Together with other exclusion and weighting decisions, the corrected growth was 2.2%, not the published −0.1%. That study was widely cited in economic policy debates.</p>
<p>Is it an isolated case? The literature on spreadsheet risk says no. In a <a href="https://arxiv.org/pdf/0802.3457">review of field audits</a>, Raymond Panko reports that the most recent and rigorous audits found errors in at least 86% of the spreadsheets audited, and that developers make uncorrected errors in 2% to 5% of formulas. Be careful with figures circulating without a source: the "94% of spreadsheets have errors" appears in second-hand summaries and I could not confirm it in the original work, so the figure I can back is the 86% or more in recent audits.</p>

<h2>A tested case: three small mistakes and a total that looks right</h2>
<p>I built a commission sheet with nine salespeople (sales, rate and commission = sales × rate) and planted three very common errors:</p>
<ol>
<li><strong>Row outside the total's range.</strong> Iván was added in row 10 after the total was built, and the formula stayed as <code>=SUM(D2:D9)</code>.</li>
<li><strong>Value pasted over a formula.</strong> In Diego's commission someone pasted 1,800,000 as a value; the formula gave 1,500,000.</li>
<li><strong>Wrong cell anchor.</strong> Felipe's commission ended up as <code>=B7*C$2</code> (it uses row 2's rate, 5%) instead of <code>=B7*C7</code> (6%).</li>
</ol>
<p>The reported total was <strong>8,292,500</strong>; the correct one, <strong>10,246,500</strong>. A difference of <strong>1,954,000 pesos (19%)</strong>. And notice how treacherous it is: the errors partly offset each other (the pasted value adds 300,000 too much; the anchor subtracts 274,000; the row outside the range subtracts 1,980,000), so the total does not look "absurd" and nobody suspects.</p>
{{img:errores}}
<p>A fourth error, on another sheet, is the duplicate payment. In a list of eight invoices, FAC-1004 appears twice (3,200,000 each time): the total paid is 14,130,000 and the total without duplicates is 10,930,000. <strong>3,200,000 was overpaid</strong>, and without a control nobody would have seen it.</p>

<h2>Controls you can copy and paste</h2>
<p>I tested these formulas in Excel with the sheet above (the data range is D2:D10; the commission is in D and the total in D11). Put them on a "Control" sheet; all should return zero:</p>
<pre><code>// 1. Rows left out of the total (should be 0; in the case it gave 1,980,000)
=SUM(D2:D10)-D11

// 2. Cells in the column that do NOT have a formula (should be 0; in the case it gave 1)
=SUMPRODUCT(--NOT(ISFORMULA(D2:D10)))

// 3. Rows where commission does not match sales x rate (should be 0; in the case it gave 2)
=SUMPRODUCT(--(D2:D10<>B2:B10*C2:C10))

// 4. See the formula of a suspicious cell (in the case it showed =B7*C$2)
=FORMULATEXT(D7)

// 5. Independently recomputed total (in the case it gave 10,246,500)
=SUMPRODUCT(B2:B10,C2:C10)

// 6. Duplicate invoices: flag each repeated one (on the payments sheet)
=IF(COUNTIF($A$2:$A$9,A2)>1,"DUPLICATE","")

// 7. Total without duplicates and how many invoices repeat (in the case: 10,930,000 and 1)
=SUMPRODUCT(B2:B9/COUNTIF(A2:A9,A2:A9))
=COUNTA(A2:A9)-SUMPRODUCT(1/COUNTIF(A2:A9,A2:A9))</code></pre>
<p>The Spanish-language names are SUMA, ESFORMULA, NO, FORMULATEXTO, SUMAPRODUCTO, SI, CONTAR.SI and CONTARA, and the argument separator is a semicolon. Control 3 works even when the error is a pasted value or a misplaced anchor: both make the commission stop being sales × rate. And control 5 is the core idea: <strong>recompute the total by another path and compare</strong>.</p>
<p>A note on Excel <strong>Tables</strong>: when you convert a range into a table, formulas can use column names, such as <code>=SUM(tComisiones[Comision])</code>, which read better and adjust when rows are added to the table. In my test, a fixed range that covered the table's entire column also expanded; the real risk appears when rows are pasted outside the table or below the total. That is why it pays both to structure the data and to control the totals.</p>

<h2>Auditing and version control with the tools you already have</h2>
<ul>
<li><strong>See all formulas.</strong> <em>Formulas &gt; Show Formulas</em> (or Ctrl + `) and <em>Trace Precedents</em> to follow where a number comes from.</li>
<li><strong>Inquire and Spreadsheet Compare.</strong> Microsoft offers the <a href="https://support.microsoft.com/en-us/excel/turn-on-the-inquire-add-in">Inquire</a> add-in (it analyzes a workbook and compares two versions cell by cell) and the Spreadsheet Compare tool, but only in Excel for Windows with enterprise editions (Office Professional Plus or Microsoft 365 Apps for enterprise). If you do not see the option in <em>File &gt; Options &gt; Add-ins &gt; COM Add-ins</em>, your edition does not include it.</li>
<li><strong>Version history.</strong> If the file is on OneDrive or SharePoint with a Microsoft 365 subscription, <em>File &gt; Info &gt; Version History</em> saves versions automatically and lets you restore. Local files do not have this feature.</li>
<li><strong>Protect.</strong> Lock formula cells and protect the sheet; leave only input cells editable, with <em>Data Validation</em> (for example, only numbers between 0 and 1 for a rate).</li>
<li><strong>One "official" file.</strong> No <em>final_FINAL2_reviewed.xlsx</em>: one shared location, one responsible owner and a "Change log" sheet with date, who, what changed and why.</li>
<li><strong>Separate duties.</strong> Whoever builds the sheet is not whoever reviews it.</li>
</ul>
{{img:pasos}}

<h2>Colombia, Latin America and the world: why it matters more for small businesses</h2>
<p>Worldwide, large companies have internal audit and model-management tools, and there are still cases like Reinhart and Rogoff's. In Latin America and Colombia, most small businesses, accounting offices and schools depend on Excel for payroll, invoicing, inventory and grades, as I describe in <a href="/excel-esta-muerto-era-de-la-ia/">Is Excel dead in the age of AI?</a>, but they rarely have a review process. For an <strong>accountant</strong> the risk is an error in a tax return or a reconciliation; for a <strong>manager</strong>, a poorly supported pricing or purchasing decision; for a <strong>teacher or school leader</strong>, miscalculated grades that affect a student's promotion (which connects with <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">the article on what grades measure</a>). The good news is that the controls are cheap: a "Control" sheet and a habit.</p>

<h2>Audit your critical sheets: step by step</h2>
<ol>
<li><strong>Inventory.</strong> List the Excel files that move money or decide things (payroll, commissions, inventory, grades, budget) and note each one's owner.</li>
<li><strong>Total test.</strong> For each one, recompute the total by another path (control 5) and compare.</li>
<li><strong>Cells with pasted values.</strong> Look for cells without a formula in calculated columns (control 2).</li>
<li><strong>Duplicates.</strong> Check for repeated identifiers (control 6).</li>
<li><strong>Protection and versions.</strong> Lock formulas, validate input and move the file to a location with version history.</li>
<li><strong>Second review and calendar.</strong> Have someone else repeat the control and schedule a quarterly review.</li>
</ol>

<h2>Tools to automate and control</h2>
<p>Numbering and duplicate errors disappear when the template controls the sequence: the <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">Simple invoice with automatic numbering</a> assigns the number consecutively and prevents repeating invoices. If you want someone to review your critical sheets or help you implement controls, the <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS advisory</a> accompanies you. And if you want to learn to automate without damaging your data, see <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">the article on how to import a CSV correctly</a>, with a practice file, and <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">how to automate tasks in Excel and reduce errors</a>.</p>
{{productos:plantilla-en-excel-de-factura-sencilla-numeracion-automatica,soporte-plus-para-las-plantillas-de-excel}}

<h2>Frequently asked questions</h2>
<h3>How do I know whether a cell has a formula or a pasted value?</h3>
<p>Use <code>=ISFORMULA(D2)</code>, which returns TRUE if the cell has a formula. For a whole column, <code>=SUMPRODUCT(--NOT(ISFORMULA(D2:D10)))</code> counts the cells without a formula.</p>
<h3>How do I prevent a row from being left out of the total?</h3>
<p>Compare the total with an independent sum of the whole column (control 1) and use Tables. And always check that, when rows are added, the total includes them.</p>
<h3>Does Excel keep the change history?</h3>
<p>Not in local files. If the file is on OneDrive or SharePoint with a Microsoft 365 subscription, it has version history. For cell-by-cell change auditing there is the Inquire add-in, only in enterprise editions on Windows.</p>
<h3>What do I do if I find an error in a file that was already used?</h3>
<p>Document what failed and since when, compute the effect, fix it and notify those who used the result. Note the lesson in the change log.</p>
<h3>Is it worth auditing small sheets?</h3>
<p>If they move money or decide something, yes. Size does not matter: the case in this article has nine rows and a 19% error.</p>

<p class="notice"><strong>Do your audit this week.</strong> Pick your three most critical sheets, add a "Control" sheet with controls 1, 2, 3 and 5, and see whether they return zero. If you want someone to do it with you, write to the <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS advisory</a>, and to invoice without repeating numbers use the <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">invoice with automatic numbering</a>.</p>

<h2>Food for thought</h2>
<p>We trust an Excel file because it "has always worked", but never having visibly failed does not prove it is correct. <strong>If your company or school made an important decision today with a file nobody has audited, who would answer for the error: whoever built it, whoever used it or whoever never asked to review it?</strong> And should we treat critical spreadsheets with the same discipline we apply to an accounting balance sheet?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:errores}}' => $img('riesgo-excel-auditoria-errores', 500, 'Table with three errors planted in a commission sheet and the control that catches each: row outside the range, value pasted over a formula, wrong cell anchor and an invoice paid twice.', 'Three planted errors and the control that catches them (case tested in Excel).'),
    '{{img:pasos}}' => $img('riesgo-excel-auditoria-pasos', 467, 'Five steps to audit a critical sheet: take inventory, control totals, protect, version and a second pair of eyes.', 'Auditing a critical sheet in five steps.'),
]);

return [
    'riesgo-oculto-excel-auditoria-control-versiones' => [
        'slug' => 'hidden-excel-risk-spreadsheets-without-audit-version-control',
        'title' => 'The Hidden Risk of Excel: Files That Control Money and Decisions Without Audit or Version Control',
        'excerpt' => 'A case tested in Excel where three small mistakes alter a total by 19%, controls you can copy and paste and a step-by-step audit of your critical spreadsheets.',
        'seo_title' => 'The Hidden Risk of Excel: Audit and Version Control',
        'seo_description' => 'How one small mistake alters an Excel total, formula controls to catch it and how to audit your critical spreadsheets and version your files.',
        'focus_keyword' => 'spreadsheet audit',
        'cover' => '/assets/img/articulos/riesgo-excel-auditoria/riesgo-excel-auditoria-portada-en',
        'cover_alt' => 'Cover reading "The hidden risk of Excel: files that move money without an audit" with a card showing a 1,954,000 peso difference in a total that looked correct, caused by a row outside the range, a pasted value and a misplaced anchor.',
        'content_html' => $html,
    ],
];
