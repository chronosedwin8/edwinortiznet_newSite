<?php

declare(strict_types=1);

// English version of "Un dashboard de Excel que ayude a actuar, no solo a mirar gráficos: un tablero d…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/dashboard-excel-actuar/' . $name . '-en';
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
<p>There is a kind of Excel dashboard that looks impressive and is useless: twenty colorful charts, maps, spinning gauges… and no question to answer. Whoever looks at it says "how pretty" and goes back to doing the same as before. A useful dashboard is something else: <strong>it starts from a question, compares with a target, sorts by priority and proposes the next step</strong>.</p>
<p>In this article I build a complete one, <strong>a school receivables dashboard</strong> that answers "whom do I call this week?", with fictional data and a downloadable template. I verified every calculation in the dashboard against an independent Python calculation (they match to the peso) and tested the formulas in Microsoft Excel 16 (es-CO). It is a <a href="/descargas/dashboard-excel/tablero-cartera-colegio.xlsx">downloadable Excel template</a> (in Spanish). Verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A good dashboard has four qualities: a concrete <strong>question</strong>, a <strong>target</strong> to compare with (traffic light), a <strong>prioritization</strong> that ranks what is urgent and a suggested <strong>action</strong> per row. It is built with a clean data sheet, a few formulas (SUMIFS, COUNTIFS, LARGE) and two or three charts, not twenty. In the example, the month's collection rate is 77% against a 90% target, 50% of receivables are more than 60 days overdue and the dashboard flags which families to contact and how.</p>

<h2>Why most dashboards do not work</h2>
{{img:dos-tableros}}
<p>A dashboard that only informs leaves all the work to the reader: interpreting, prioritizing and deciding. The four typical flaws: there is no clear question, figures are not compared with a target (77% says nothing without knowing whether the target is 70 or 90), there is no priority order and no action is proposed. Also, many dashboards fail because of chart design (see <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">Excel charts that lie</a>).</p>

<h2>The case: whom do I call this week?</h2>
<p>The treasury of a (fictional) private school has 80 families, each one's tuition and its outstanding balance. It wants to know: how is the month's collection against the target?, how are receivables by days overdue? and, above all, who must be spoken to this week and how? The dashboard is in the "Tablero" sheet and is fed from the "Datos" sheet.</p>
{{img:tablero}}
<p>With the example data, the dashboard shows:</p>
<ul>
<li><strong>Collection for the month:</strong> 77.3% against a 90% target: the traffic light reads "Por debajo de la meta" (below target) in red.</li>
<li><strong>Overdue receivables:</strong> 25.47 million pesos, split as follows: 8.16 million 1 to 30 days late (9 families), 4.56 at 31 to 60 (4 families), 8.10 at 61 to 90 (5 families) and 4.65 at over 90 (2 families).</li>
<li><strong>Concentration:</strong> 12.75 million (50% of receivables) sits with 7 families more than 60 days late.</li>
<li><strong>Priority this week:</strong> 5 families 61 to 90 days late with a balance equal to or above the threshold you define (1 million in the example), and 2 with over 90 days.</li>
<li><strong>The ten largest balances</strong>, each with its suggested action: for example, "Llamar esta semana" (call this week) or "Reunión para acuerdo de pago" (meeting for a payment agreement).</li>
</ul>

<h2>How it is built (and the formulas)</h2>
<p><strong>1. A clean data sheet.</strong> One row per family, with calculated columns (days late, range, suggested action):</p>
<pre><code>' Days late (Datos!F4)
=IF(D4=0, 0, Tablero!$C$3-E4)
=SI(D4=0; 0; Tablero!$C$3-E4)

' Suggested action (Datos!H4)
=IF(D4=0,"Sin acción", IF(F4<=30,"Recordatorio automático", IF(F4<=60,"Recordatorio escrito personalizado",
   IF(F4<=90,"Llamar esta semana","Reunión para acuerdo de pago"))))</code></pre>
<p><strong>2. Indicators with a single formula each:</strong></p>
<pre><code>' Receivables by days-late range (Tablero!C11)
=SUMIFS(Datos!$D$4:$D$83, Datos!$G$4:$G$83, B11)
=SUMAR.SI.CONJUNTO(Datos!$D$4:$D$83; Datos!$G$4:$G$83; B11)

' Priority: 61 to 90 days late and balance >= threshold
=COUNTIFS(Datos!F4:F83,">60", Datos!F4:F83,"<=90", Datos!D4:D83,">="&K3)
=CONTAR.SI.CONJUNTO(Datos!F4:F83;">60"; Datos!F4:F83;"<=90"; Datos!D4:D83;">="&K3)</code></pre>
<p><strong>3. The ten largest balances</strong> without new functions (works in any Excel version), with a helper sort-key column that breaks ties between equal balances by adding a tiny fraction of the row number:</p>
<pre><code>' Sort key (Datos!I4): avoids ties
=D4+ROW()/1000000

' Family with the nth largest balance (Tablero!H11)
=INDEX(Datos!$A$4:$A$83, MATCH(LARGE(Datos!$I$4:$I$83, G11), Datos!$I$4:$I$83, 0))
=INDICE(Datos!$A$4:$A$83; COINCIDIR(K.ESIMO.MAYOR(Datos!$I$4:$I$83; G11); Datos!$I$4:$I$83; 0))</code></pre>
<p><strong>4. A traffic light with conditional formatting:</strong> the status cell compares collection with the target (green if reached, amber if within five points, red otherwise). The target, the cut-off date and the threshold are editable yellow cells, not numbers hidden in formulas.</p>
<p><strong>5. Two charts, not twenty:</strong> balance by days-late range (columns, with the axis at zero) and collection by month against the target (line). If you want to learn not to mislead with axes, see the article on <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">charts that lie</a>.</p>

<h2>The test: does the dashboard tell the truth?</h2>
<p>A dashboard with misplaced formulas is worse than none, because it inspires confidence. That is why I computed the indicators by an independent route (a Python script with the same data) and compared them with what Excel gives: billed 61,920,000, collected 47,850,000 (77.28%), receivables 25,470,000, 7 families more than 60 days late, 12,750,000 in that band and the days-late ranges, all identical. That independent comparison is a practice I recommend for any dashboard that feeds decisions (see <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a> and <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">how to read errors</a>).</p>

<h2>Ten rules for your own dashboard</h2>
<ol>
<li><strong>Write the question</strong> in the title: "whom do I call this week?", "which groups need reinforcement?", "which products are running out?".</li>
<li><strong>Every indicator, with a target</strong> and a traffic light.</li>
<li><strong>Five to seven indicators</strong> at most.</li>
<li><strong>Sort by priority</strong> and show only the first ones.</li>
<li><strong>One suggested action</strong> per row.</li>
<li><strong>Visible, editable parameters</strong> (targets, thresholds, dates).</li>
<li><strong>Data separate from the dashboard</strong> and clean (see <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importing CSV correctly</a>).</li>
<li><strong>Honest charts:</strong> axes from zero in columns, comparable scales.</li>
<li><strong>Verify against an independent calculation.</strong></li>
<li><strong>Define who updates it and when</strong>; an outdated dashboard misleads.</li>
</ol>

<h2>A caution: the data are people</h2>
<p>A receivables dashboard is about families with financial difficulties. The workbook's actions are <strong>suggestions to start a respectful conversation</strong>, not sentences, and decisions about collection remain with people at the institution, with their rules and judgment. Also, a file with names and balances is personal information: protect it, limit who sees it and do not paste it into free AI tools (see <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into an AI</a>). When volume grows and several people edit at once, it is time to move to a database (see <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">the seven signs</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, dashboards became a symbol of data-driven management, and with them the risk of "decorative dashboards". In Colombia and Latin America, small and medium institutions and businesses rarely have a data analyst and almost everything is done in Excel; there a simple, verified dashboard is worth more than a sophisticated tool nobody knows how to maintain. For <strong>principals and treasurers</strong>, the lesson is to ask for dashboards that answer questions; for <strong>teachers</strong>, the same design works for tracking attendance or grades (for example, which groups need support); for <strong>families</strong>, transparency about how their data is used; and for <strong>those who teach Excel</strong>, it is a good capstone project.</p>

<h2>Templates to work in an orderly way</h2>
<p>If you prefer to start from ready-made templates, these options come with controls and formatting. And there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a> for asking for help with your formulas, always verifying the result.</p>
{{productos:plantilla-en-excel-de-factura-sencilla-numeracion-automatica,listado-de-asistencia-laboral-o-academica-en-excel}}
<p>Keep reading: <a href="/listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla/">dependent drop-down lists</a>, <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">forecasting in Excel</a> and <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">how to automate in Excel</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What makes an Excel dashboard good?</h3>
<p>It starts from a concrete question, compares indicators with a target, sorts by priority and proposes an action. Few indicators and honest charts.</p>
<h3>How many indicators should it have?</h3>
<p>Between five and seven is usually enough. More indicators dilute attention and hide what is urgent.</p>
<h3>How do I get the top ten values without new functions?</h3>
<p>With LARGE, INDEX and MATCH, and a helper column that breaks ties (the value plus a tiny fraction of the row number).</p>
<h3>How do I know my dashboard calculates correctly?</h3>
<p>Compute the same indicators by another route (by hand on a sample, with a pivot table or with a script) and compare.</p>
<h3>Do I need Power BI?</h3>
<p>Not to start. A well-designed Excel dashboard covers most needs of a small institution or business; Power BI helps when there is a lot of volume, several sources or many users.</p>

<p class="notice"><strong>Try it with your data.</strong> Download the <a href="/descargas/dashboard-excel/tablero-cartera-colegio.xlsx">receivables dashboard</a> (in Spanish), replace the "Datos" sheet with yours and adjust the cut-off date, the target and the threshold. If you adapt it to another topic (attendance, inventory), keep the structure: question, target, priority and action.</p>

<h2>Food for thought</h2>
<p>A dashboard that proposes what to do with each person can save time and also dehumanize. <strong>How far should the automation of "suggested actions" go when behind every row there is a family? And who should decide what is measured, what target is set and what action is recommended: whoever designs the dashboard, whoever uses it or the people who appear in it?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:dos-tableros}}' => $img('dashboard-excel-actuar-dos-tableros', 633, 'Two columns: a dashboard that only informs, with many charts, figures without targets and no actions, versus one that helps you act, starting from a question, comparing with a target, sorting by priority and proposing the next action.', 'Informing is not the same as helping you act.'),
    '{{img:tablero}}' => $img('dashboard-excel-actuar-tablero', 600, 'School receivables dashboard with fictional data: billed 61.9 million, collection 77.3% in red against the 90% target, overdue balance 25.5 million, seven families more than 60 days late, balance by days late, the largest balances with the suggested action and the week\'s priority.', 'The receivables dashboard: a question, a target, a priority and an action.'),
]);

return [
    'dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla' => [
        'slug' => 'excel-dashboard-that-helps-you-act-school-receivables-template',
        'title' => 'An Excel Dashboard That Helps You Act, Not Just Look at Charts: A Receivables Dashboard with Template',
        'excerpt' => 'How to build an Excel dashboard that starts from a question, compares with a target, sorts by priority and proposes an action: a school receivables dashboard with verified formulas and a downloadable template.',
        'seo_title' => 'Excel Dashboard That Helps You Act (Template)',
        'seo_description' => 'How to build a useful Excel dashboard: question, target, priority and action, with a school receivables example, verified formulas and a template.',
        'focus_keyword' => 'Excel dashboard',
        'cover' => '/assets/img/articulos/dashboard-excel-actuar/dashboard-excel-actuar-portada-en',
        'cover_alt' => 'Cover "An Excel dashboard that helps you act, not just look at charts" with a card: collection for the month 77% against a 90% target, receivables of 25.5 million and 50% more than 60 days overdue.',
        'content_html' => $html,
    ],
];
