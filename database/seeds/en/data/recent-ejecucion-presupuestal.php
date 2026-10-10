<?php

declare(strict_types=1);

// English version of «Presupuesto del colegio en Excel: ejecutado, comprometido y disponible (CDP, RP,…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ejecucion-presupuestal/' . $name . '-en';
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
<p>The governing board asks: "how much money do we have for maintenance?". The treasurer looks at the bank balance. The principal looks at the approved budget. The coordinator remembers a quote was already requested. And the three answers are different, because a school's money has <strong>at least four states</strong>: authorized (appropriated), reserved (with an availability certificate), committed (with a contract or order recorded) and paid. Confusing them leads to two symmetric mistakes: <strong>spending more than there is</strong> or leaving money unspent while urgent repairs are put off.</p>
<p>This article explains the spending cycle with the words used by the Colombian public budget (appropriation, CDP, RP, obligation and payment) and offers an <a href="/descargas/ejecucion-presupuestal/ejecucion-presupuestal-colegio.xlsx">Excel workbook</a> (in Spanish) that tracks, by budget line, what is appropriated, reserved, committed, obligated and paid, with alerts when a document exceeds the previous one. The results were verified in Microsoft Excel 16 and against an independent Python calculation, with fictional data. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> This is not accounting or legal advice. Budget rules depend on whether the school is public or private and on its territorial entity's regulations; in public schools, the school services fund has its own regime (the principal is the authorizing officer and the governing board approves the budget), and exact definitions, deadlines and procedures must be verified in the current regulations and with the education secretariat. The example amounts are fictional and the workbook is an internal control tool, not a substitute for the official accounting system.</p>

<h2>The spending cycle in five words</h2>
{{img:ciclo}}
<ul>
<li><strong>Appropriation:</strong> the amount the budget authorizes to spend on a line during the fiscal year. In the workbook: initial appropriation, plus additions, minus reductions, equals the <em>final appropriation</em>.</li>
<li><strong>Budget availability certificate (CDP):</strong> the document guaranteeing there is sufficient appropriation free of encumbrance to take on a commitment. It is issued <em>before</em> contracting or committing and reserves the money preliminarily. Article 71 of the Budget Organic Statute (Decree 111 of 1996) requires that administrative acts affecting appropriations have prior availability certificates.</li>
<li><strong>Budget registration (RP):</strong> the record of the commitment when it is finalized (for example, on signing the contract or issuing the order). It encumbers the appropriation definitively and prevents those funds from being diverted to another purpose.</li>
<li><strong>Obligation:</strong> the payability, which arises when the good or service has been received satisfactorily. There can be commitments with no obligation yet (the contract signed and the works not delivered).</li>
<li><strong>Payment:</strong> the actual outflow of funds to meet the obligation.</li>
</ul>
<p>Each document rests on the previous one and should not exceed it: an RP cannot be greater than its CDP, an obligation cannot be greater than its RP and a payment cannot be greater than its obligation. And each link leaves a useful balance: <strong>available</strong> (appropriation − CDP), <strong>to commit</strong> (CDP − RP), <strong>to obligate</strong> (RP − obligated) and <strong>to pay</strong> (obligated − paid). For public schools, Decree 4791 of 2008 (compiled in Decree 1075 of 2015, arts. 2.3.1.6.3.4 and 2.3.1.6.3.5) establishes that the principal acts as the authorizing officer of the school services fund and that the governing board approves, by agreement and before each fiscal year, the income and expense budget (verify the current text).</p>

<h2>The workbook, sheet by sheet</h2>
<ul>
<li><strong>Rubros:</strong> one row per budget line, with the appropriation (initial, additions, reductions and final) and, calculated from the movements, the CDPs issued, committed, obligated and paid, plus the four balances, percentages and an alert.</li>
<li><strong>Movimientos:</strong> the record of each document (type, number, prior document, line, date and value). For each one it calculates the sum of the documents referencing it and flags whether they exceed it or the prior document is missing.</li>
<li><strong>Resumen:</strong> the totals and alerts.</li>
</ul>
<pre><code>' Committed (RP) of a line: sum of the RP-type movements of that line
=SUMIFS(Movimientos!$G$4:$G$300, Movimientos!$A$4:$A$300, "RP", Movimientos!$E$4:$E$300, A4)             ' English
=SUMAR.SI.CONJUNTO(Movimientos!$G$4:$G$300; Movimientos!$A$4:$A$300; "RP"; Movimientos!$E$4:$E$300; A4)   ' Spanish

' Available for new CDPs
=F4-G4

' A document exceeds the previous one if the documents referencing it add up to more than its value
=SUMIFS($G$4:$G$300, $C$4:$C$300, B4)         ' sum of those referencing it
=IF(AND(A4<>"PAGO", H4>G4), "Excede el documento", "OK")</code></pre>

<h2>What the workbook showed (fictional budget)</h2>
<p>The example has eight lines and a final appropriation of <strong>$88,000,000</strong> (two of them with additions or reductions). The movements add up to CDPs of $65,500,000, commitments (RP) of $58,600,000, obligations of $43,600,000 and payments of $37,600,000. That is, <strong>66.6% of the appropriation is committed</strong> and <strong>42.7% paid</strong>; the total available for new CDPs is $22,500,000. But the total hides several things that only show by line:</p>
<ul>
<li><strong>Training (R8): CDPs exceed the appropriation.</strong> A CDP of $3,500,000 was issued against an appropriation of $3,000,000: the line's available balance is −$500,000. A CDP should not be issued without sufficient appropriation.</li>
<li><strong>Communications and transport (R4): an RP exceeds its CDP.</strong> CDP-005 reserved $2,000,000 and RP-005 committed $2,300,000 (an excess of $300,000). The workbook flags it on the movements sheet and on the line.</li>
<li><strong>Printing and publications (R6): CDP not committed.</strong> $3,000,000 reserved that has not become an RP. It may be a commitment in process or a forgotten reservation blocking money another line or activity could use.</li>
<li><strong>Insurance (R7): zero available.</strong> The whole line is reserved, committed and obligated; $1,000,000 remains to be paid.</li>
<li><strong>Maintenance (R2) and technology equipment (R5):</strong> with $5,500,000 and $5,000,000 committed but not yet obligated, respectively: the service or good is contracted and awaiting receipt. In R5, there is also $5,000,000 obligated but unpaid.</li>
<li><strong>Total payable:</strong> $6,000,000 of unpaid obligations (R5: 5 million; R7: 1 million): a payable worth scheduling.</li>
</ul>
<p>The lesson: the <strong>total available of $22.5 million looks comfortable, but it is controlled by line</strong>, and in the training line it is negative. Leftover money in one line does not cover another's shortfall, unless there is an approved budget modification (transfer) under the institution's rules. Workbook summary: 1 line with CDPs over its appropriation, 1 document exceeding the previous one and 0 documents without a prior document.</p>
{{img:control}}

<h2>Four frequent mistakes</h2>
<ol>
<li><strong>Looking at the bank balance instead of budget availability.</strong> The bank knows nothing of commitments: there can be $10 million in the account and $9 million already committed in contracts to be paid.</li>
<li><strong>Committing without a CDP,</strong> or committing more than reserved. Article 71 of the Organic Statute is not a decorative formality: it is there to prevent incurring an expense without backing.</li>
<li><strong>Leaving live CDPs uncommitted.</strong> They block availability. It is worth reviewing CDPs without an RP monthly and releasing those that will no longer be used, following the institution's procedure.</li>
<li><strong>Confusing execution with payment.</strong> "66% was executed" can mean committed, obligated or paid; when reporting, say the exact word, or the board will take away a wrong idea.</li>
</ol>

<h2>Five steps for monthly control</h2>
<ol>
<li><strong>Record each document</strong> with its prior document and line, the same day.</li>
<li><strong>Check the excesses</strong> (documents exceeding the previous one) and CDPs over the appropriation.</li>
<li><strong>Look at availability by line</strong> before issuing a new CDP.</li>
<li><strong>Review what is payable</strong> and schedule the payments.</li>
<li><strong>Report</strong> with a clear summary (appropriated, committed, obligated, paid and available) to whoever decides.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, the appropriation, CDP, RP, obligation and payment cycle is the backbone of the public budget, and public schools apply it to the resources of their school services funds (gratuity transfers, own resources and others), while private ones keep their accounting under their own rules. In the region, schools' budget management ranges from centralized administration to managerial autonomy with accountability; worldwide, control by commitments (and not only by cash) is a standard practice of public financial management. For <strong>principals</strong>, understanding the words avoids decisions based on wrong information; for <strong>teachers</strong>, knowing that an order needs availability before buying; for the <strong>governing board</strong>, asking for reports by line and not only totals; and for <strong>families</strong>, that accountability be understandable. In the coming weeks of this series, Law 715 of 2001, which organizes the sector's resources, is studied. See also <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">the total cost of a platform</a> for technology purchase decisions.</p>

<h2>Templates and tools</h2>
<p>If you prefer to start from ready-made Excel templates, with support, look at these options. And to ask an AI for help with your formulas (always verifying the result and without pasting sensitive data), there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL! and #VALUE! errors</a>, <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">a dashboard that helps you act</a> and <a href="/comparar-dos-ofertas-de-credito-en-excel-tasa-real-costo-total-comparador/">comparing two loan offers in Excel</a>. For those preparing for the competition, see <a href="/herramientas/simulacro-concurso-docente/">the mock exam tool</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is a CDP?</h3>
<p>A budget availability certificate: the document guaranteeing there is available appropriation free of encumbrance to take on a commitment. It is issued before committing.</p>
<h3>What is the difference between CDP and RP?</h3>
<p>The CDP reserves availability preliminarily, before contracting; the RP records the commitment when finalized and encumbers the appropriation definitively.</p>
<h3>What is budget availability?</h3>
<p>The appropriation minus the CDPs issued (which already reserve money). It is not the bank balance.</p>
<h3>Can leftover money in one line be used in another?</h3>
<p>Only through a budget modification (transfer) approved under the institution's rules. Control is by line.</p>
<h3>What does it mean that a document exceeds the previous one?</h3>
<p>That the value of what depends on it (for example, a CDP's RPs) adds up to more than its own value: more was committed or paid than was reserved or obligated.</p>

<p class="notice"><strong>Measure your budget by line.</strong> Download the <a href="/descargas/ejecucion-presupuestal/ejecucion-presupuestal-colegio.xlsx">budget execution workbook</a> (in Spanish), replace the example lines and movements with yours and look first at lines with negative availability and documents that exceed the previous one.</p>

<h2>Food for thought</h2>
<p>A budget is a promise about how a community's money will be used. <strong>Who at your school can say today, without looking it up, how much is really available in each line and how much is committed but unpaid? And when money is not enough, who decides what is postponed, by what criterion and in whose sight?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ciclo}}' => $img('ejecucion-presupuestal-ciclo', 553, 'Table with the five words of the spending cycle, what each reserves or records and the balance to watch: appropriation, CDP, RP, obligation and payment.', 'Five words that do not mean the same.'),
    '{{img:control}}' => $img('ejecucion-presupuestal-control', 467, 'Five steps of monthly budget control: record, check excesses, look at availability, review payables and report.', 'Five steps to avoid overspending.'),
]);

return [
    'presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro' => [
        'slug' => 'school-budget-excel-executed-committed-available-cdp-rp-workbook',
        'title' => 'The School Budget in Excel: Executed, Committed and Available (CDP, RP, Obligation and Payment) with a Verified Workbook',
        'excerpt' => 'The spending cycle (appropriation, CDP, RP, obligation and payment) in an Excel workbook that tracks balances by line and alerts when a document exceeds the previous one, with a verified fictional example.',
        'seo_title' => 'School Budget in Excel: CDP, RP and Available',
        'seo_description' => 'Control the school budget in Excel: appropriation, CDP, RP, obligation and payment by line, with availability, alerts and a verified example.',
        'focus_keyword' => 'school budget Excel',
        'cover' => '/assets/img/articulos/ejecucion-presupuestal/ejecucion-presupuestal-portada-en',
        'cover_alt' => 'Cover "The school budget in Excel: executed, committed and available" with a card: 66.6% and 42.7%, committed and paid of the appropriation.',
        'content_html' => $html,
    ],
];
