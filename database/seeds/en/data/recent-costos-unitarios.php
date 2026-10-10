<?php

declare(strict_types=1);

// English version of «Costos unitarios del colegio en Excel: cuánto cuesta cada estudiante, cómo se re…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/costos-unitarios/' . $name . '-en';
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
<p>The board asks something simple: "how much does a student cost us per month?". The treasurer answers with the total budget divided by enrollment, and the principal, with the tuition charged. The two figures look alike, so it seems all is well. But the real question is another: <strong>how much does each level cost, what part of those costs is "theirs" and what part is everyone's, and how many students can be lost before costs are no longer covered?</strong></p>
<p>This article proposes calculating a school's <strong>unit costs</strong>: separating direct and shared costs, allocating the shared ones with an explicit criterion, calculating the cost per student per month and the break-even point. It includes an <a href="/descargas/costos-unitarios/costos-unitarios-colegio.xlsx">Excel workbook</a> (in Spanish) with a fictional two-level school, verified in Microsoft Excel 16 and against an independent calculation (with decimal arithmetic).</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional and in Colombian pesos; the example is a simplification (two levels, ten items, fixed enrollment). This is not accounting or tax advice, and tuition setting in private schools is regulated (see below). A cost per student is a management tool, not a judgment on the value of a level, a program or a student.</p>

<h2>Direct cost, shared cost and the allocation question</h2>
<ul>
<li><strong>Direct costs:</strong> those that can be assigned to a level or program without argument, such as primary teachers or secondary lab materials.</li>
<li><strong>Shared (indirect) costs:</strong> those that serve everyone: administration, utilities, maintenance, technology, security and cleaning, student welfare. To know what a level costs, you must decide <strong>how they are allocated</strong>.</li>
<li><strong>Fixed and variable costs:</strong> fixed ones do not fall if enrollment falls (payroll, premises); variable ones do (per-student materials). The distinction matters when simulating scenarios.</li>
</ul>
{{img:tipos}}
<p>Allocation is a <strong>management decision</strong>, not a datum: you can allocate by number of students, by square meters, by hours of use, by staff, or equally. Each criterion tells a different story, which is why the workbook calculates two at once.</p>

<h2>The Excel workbook</h2>
<ul>
<li><strong>Parametros:</strong> students and monthly tuition per level, months of tuition per year and an enrollment change for a scenario.</li>
<li><strong>Costos:</strong> ten items with their type and center (Primaria, Secundaria or Común, i.e. primary, secondary or shared).</li>
<li><strong>Calculo:</strong> total cost, cost per student per year and per month for each level, with two criteria for shared costs: <strong>A, by number of students</strong>, and <strong>B, equally</strong>, and each level's margin (tuition income minus cost).</li>
<li><strong>Resumen:</strong> average cost and tuition, levels in deficit, break-even point and the enrollment-change scenario.</li>
</ul>
<pre><code>' Allocation of shared costs by number of students (shared in D6, level's students in B4, total in D4)
=$D$6*B4/$D$4
' Cost per student per month (level's total cost in B8, months in Parametros!B7)
=B8/B4/Parametros!$B$7
' Break-even: students needed to cover total cost with the average tuition
=ROUNDUP(Calculo!D8/(Calculo!D15/Calculo!D4),0)           ' English
=REDONDEAR.MAS(Calculo!D8/(Calculo!D15/Calculo!D4);0)    ' Spanish</code></pre>

<h2>What the example showed (fictional data)</h2>
{{img:reparto}}
<p>A school with 420 students (180 in primary at a tuition of $480,000 and 240 in secondary at $560,000, ten months a year) and costs of $2,190 million a year:</p>
<ul>
<li><strong>Averages:</strong> cost per student is $521,429 a month; average tuition, $525,714. The total margin is $18 million a year (0.8% of income).</li>
<li><strong>Allocation changes the story.</strong> With criterion A (shared costs by students), primary costs $505,714 per student a month and secondary $533,214: <em>secondary looks costlier</em>. With criterion B (equal split), primary costs $536,667 and secondary $510,000: <em>now primary looks costlier</em>. Total cost is the same ($2,190 million); what changes is the reading.</li>
<li><strong>What does not change:</strong> primary is in deficit under both criteria (−$46.3 million with A, −$102 million with B) and secondary, in surplus ($64.3 and $120 million). A tuition of $480,000 does not cover primary's cost under either criterion.</li>
<li><strong>Break-even:</strong> with current costs, <strong>417 students</strong> of 420 are needed: a margin of just 3 students (0.7%).</li>
<li><strong>Scenario:</strong> if enrollment falls 10% (378 students) and costs stay fixed, cost per student rises to $579,365 a month and the margin goes from +$18 million to <strong>−$202.8 million</strong>. Ten percent fewer students does not lower costs by ten percent.</li>
</ul>
<p><strong>An honest reading:</strong> the example assumes all costs are fixed, which exaggerates the effect of an enrollment drop (in practice, some costs adjust, though with a lag), and that average tuition stays the same. And cost per student does not measure quality or educational value: a "loss-making" level may be the one sustaining the continuity of students who reach secondary. It serves to <strong>talk with clear numbers</strong>, not to close a level.</p>

<h2>Tuition, regulation and transparency in Colombia</h2>
<p>In Colombia's private sector, enrollment fees, tuition and periodic charges are governed by Decree 2253 of 1995 (now compiled in Decree 1075 of 2015) and by the Ministry of Education's annual resolutions setting the increase parameters. According to sources consulted on October 10, 2026, tuition is authorized by the certified territorial entity, schools are classified into regimes (regulated freedom, supervised freedom and controlled regime, depending on whether they meet quality requirements), and costs and institutional self-assessment must be submitted to the secretariat before enrollment. <strong>Check the current text and the resolution for your school year</strong>: regime names, deadlines and percentages change. In the public sector, the service is free and the logic is different: resources arrive as per-student transfers, and unit cost serves for planning and accountability, not for setting tuition.</p>
<p>For <strong>principals</strong>, knowing the real cost per level is the basis for setting tuition, planning enrollment and negotiating. For <strong>families</strong>, understanding what a tuition covers is part of transparency (charges must be clear and explicit). For <strong>teachers</strong>, payroll is the largest item, and the conversation about costs must be held with respect. And for <strong>students</strong>, that no cost analysis reduces them to a figure: see <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">budget executed, committed and available</a> and <a href="/comparar-dos-ofertas-de-credito-en-excel-tasa-real-costo-total-comparador/">comparing offers by their real total cost</a> for other uses of the same reasoning.</p>

<h2>How to start in a school</h2>
<ol>
<li><strong>Start from last year's executed budget</strong> (not the planned one) and classify each item as direct or shared.</li>
<li><strong>Decide and document the allocation criterion,</strong> and calculate at least two to see how much the reading changes.</li>
<li><strong>Calculate cost per student per month</strong> and compare it with tuition, without forgetting discounts, scholarships and unpaid fees (real income is lower than nominal).</li>
<li><strong>Calculate the break-even point</strong> and simulate enrollment scenarios with fixed and variable costs.</li>
<li><strong>Share the results</strong> with the board with their assumptions in plain view.</li>
</ol>

<h2>Tools and templates</h2>
<p>If you work with the site's Excel templates and want support, or prepare material with AI (always reviewing what it produces and without including confidential financial data in tools not designed to safeguard it), take a look at these products.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: the <a href="/descargas/costos-unitarios/costos-unitarios-colegio.xlsx">unit costs workbook</a>, <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">averages in Excel: seven mistakes</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Frequently asked questions</h2>
<h3>What is a unit cost?</h3>
<p>The cost of producing one unit of the service; in a school, typically the cost per student per month or year, total or by level.</p>
<h3>How do I allocate shared costs?</h3>
<p>With an explicit criterion: by number of students, by square meters, by hours of use or equally. It is best to calculate more than one and document the chosen one.</p>
<h3>What is the break-even point?</h3>
<p>The number of students at which tuition income equals total costs, with current costs and tuition.</p>
<h3>Why can a level look loss-making?</h3>
<p>Because that level's tuition does not cover its direct cost plus the share of shared costs assigned to it; the result depends on the allocation criterion and the tuition. It does not mean the level should be closed.</p>
<h3>Does it work for public schools?</h3>
<p>Yes, as a planning and accountability tool; income is not tuition but per-student transfers.</p>

<p class="notice"><strong>Calculate your school's cost.</strong> Download the <a href="/descargas/costos-unitarios/costos-unitarios-colegio.xlsx">unit costs workbook</a> (in Spanish), replace the fictional data with your school's, try the two allocation criteria and look at the break-even point.</p>

<h2>Food for thought</h2>
<p>A cost per student looks like an objective datum, but it depends on decisions: what is assigned, what is shared and with what criterion. <strong>Who decides today at your school how shared costs are allocated, and who gets to see it? And what decision would change if a level's cost were read with another allocation criterion?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tipos}}' => $img('costos-unitarios-tipos', 499, 'Table with four cost types and how they are treated: direct, shared, fixed and variable, with an example of each.', 'What is assigned and what is shared.'),
    '{{img:reparto}}' => $img('costos-unitarios-reparto', 524, 'Bar chart of cost per student per month by level under two allocation criteria and tuition: primary and secondary.', 'The allocation criterion changes which level looks costlier.'),
]);

return [
    'costos-unitarios-colegio-excel-costo-por-estudiante-reparto-punto-de-equilibrio' => [
        'slug' => 'school-unit-costs-excel-cost-per-student-allocation-break-even',
        'title' => 'School Unit Costs in Excel: What Each Student Costs, How Shared Costs Are Allocated and the Break-Even Point',
        'excerpt' => 'How to calculate cost per student and per level with direct and shared costs, why the allocation criterion changes the reading and how many students are needed to break even, with a verified Excel workbook.',
        'seo_title' => 'School Unit Costs in Excel: Cost per Student',
        'seo_description' => 'How to calculate a school\'s cost per student in Excel: direct and shared costs, allocation criteria, break-even point and scenarios, with a verified workbook.',
        'focus_keyword' => 'school unit costs in Excel',
        'cover' => '/assets/img/articulos/costos-unitarios/costos-unitarios-portada-en',
        'cover_alt' => 'Cover "School unit costs: what each student really costs" with a card: 417 of 420 students are enough to cover the example school\'s costs, a margin of only 3.',
        'content_html' => $html,
    ],
];
