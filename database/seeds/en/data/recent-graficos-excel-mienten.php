<?php

declare(strict_types=1);

// English version of "Las gráficas de Excel también pueden mentir…". Key is the Spanish slug. All charts were made in Microsoft Excel 16 (VBA macro)
// with hypothetical data; the RevisarEjes macro was tested on three column charts and flagged only the truncated one. In the correlation example
// (invented data) CORREL gave 0.998 and RSQ 0.996. Status and date come from the Spanish post via en/02_recent_posts.php (scheduled for Thursday,
// November 5, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/graficos-excel-mienten/' . $name . '-en';
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
<p>An Excel chart takes three clicks and looks objective: it is "the data", drawn. But a chart is not data: it is a <strong>presentation decision</strong>, and that decision can inflate a difference, hide a drop or invent a relationship that does not exist. Sometimes it is deliberate; almost always it is carelessness, because Excel picks the axis, the scale and the style for you.</p>
<p>In this article I show you <strong>five mistakes</strong> with their misleading and corrected versions (all made in Excel with hypothetical data), a VBA macro that detects one of them in your workbooks and a <strong>checklist</strong> to review a chart before presenting it. Tested in Microsoft Excel on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> The five mistakes: a truncated axis on bars, different scales across comparable charts, a period or data chosen for convenience, correlation presented as cause and dual axes tuned to force a relationship. The common rule: <strong>the chart must show what the data say, not what you would like them to say</strong>.</p>

<h2>Mistake 1: the truncated axis</h2>
<p>In a bar or column chart, <strong>the length of the bar represents the value</strong>. If the axis does not start at zero, length stops being proportional and a small difference looks huge. Here, the pass rates of three schools (92%, 94% and 93%) with the axis cut at 91 make B look like triple A:</p>
{{img:c1}}
<p><strong>How to fix it in Excel:</strong> right-click the vertical axis &gt; <em>Format Axis</em> &gt; <em>Bounds</em> &gt; <em>Minimum</em> = 0. In line charts, an axis that does not start at zero is acceptable if the goal is to show variation, but say so and do not exaggerate it.</p>

<h2>Mistake 2: inconsistent scales across comparable charts</h2>
<p>Excel adjusts each chart's scale to its own data. If you put two charts side by side, each with its own scale, <strong>two very different series look alike</strong>. In the example, the South branch sells ten times more than the North branch, but looking at the two charts together with automatic scales they seem identical:</p>
{{img:c2}}
<p><strong>How to fix it:</strong> set the same minimum and maximum on the axes of all charts to be compared (here, 0 to 160), or put both series in one chart.</p>

<h2>Mistake 3: biased selection of the period or the data</h2>
<p>With the same data you can tell opposite stories depending on the window you choose. Showing only January to July says "growth!"; the full year reveals that sales fall from August on:</p>
{{img:c3}}
<p><strong>How to fix it:</strong> show the full period, or justify the cut (for example, "since the price changed"). If you compare with a previous year, compare the same months. And ask yourself what data were left out: schools that did not respond, lost customers, months with no records.</p>

<h2>Mistake 4: confusing correlation with causation</h2>
<p>Two series can move together without one causing the other. In the example (invented data), ice cream sold and sunburns have a very high correlation, and Excel confirms it:</p>
<pre><code>=CORREL(A2:A13,B2:B13)     → 0.998
=RSQ(B2:B13,A2:A13)        → 0.996</code></pre>
<p>But ice cream does not cause sunburns: both depend on heat and season. That hidden third variable is called a <em>confounder</em>.</p>
{{img:c4}}
<p><strong>How to avoid it:</strong> before writing "X causes Y", ask whether a third variable affects both, whether the order in time makes sense and whether there is a plausible mechanism. A high correlation is a clue to investigate, not proof. <a href="https://www.tylervigen.com/spurious-correlations">Spurious correlations</a> (such as those collected by Tyler Vigen) show that with enough series, some always "match".</p>

<h2>Mistake 5: dual axes that force a relationship</h2>
<p>Excel's secondary axis lets you chart two different quantities, but it also lets you <strong>tune the two axes until the lines coincide</strong>. In the example, advertising spend varies by less than 5% and visits by less than 7%: there is hardly any movement. With two cropped axes, both lines seem to dance together:</p>
{{img:c5}}
<p><strong>How to fix it:</strong> avoid dual axes unless essential; better use an <em>index</em> (each series divided by its starting value, times 100), which puts both on the same scale, or two separate charts with axes that start at zero.</p>

<h2>A macro to detect truncated axes</h2>
<p>If you receive workbooks with many charts, this VBA function goes through all the sheets and lists the column or bar charts whose value axis does not start at zero. I tested it with three column charts (one with the axis at 90, one at 0 and one automatic) and it flagged only the first:</p>
<pre><code>Public Function RevisarEjes(Optional libro As Workbook) As String
    Dim ws As Worksheet, co As ChartObject, ax As Axis, msg As String, tipo As Long
    If libro Is Nothing Then Set libro = ActiveWorkbook
    For Each ws In libro.Worksheets
        For Each co In ws.ChartObjects
            tipo = co.Chart.ChartType
            If tipo = xlColumnClustered Or tipo = xlColumnStacked Or tipo = xlBarClustered Or tipo = xlBarStacked Then
                Set ax = co.Chart.Axes(xlValue)
                If Not ax.MinimumScaleIsAuto Then
                    If ax.MinimumScale <> 0 Then msg = msg & ws.Name & " / " & co.Name & ": the axis starts at " & ax.MinimumScale & vbLf
                End If
            End If
        Next co
    Next ws
    If msg = "" Then msg = "No bar or column chart has a truncated axis."
    RevisarEjes = msg
End Function

Sub MostrarRevision()
    MsgBox RevisarEjes(ActiveWorkbook)
End Sub</code></pre>
<p>Use it as a control on the "Control" sheet of your reports (like the one I propose in <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the article on the hidden risk of Excel</a>). To save macros, the workbook must be .xlsm, and remember that Microsoft blocks macros in files downloaded from the internet by default.</p>

<h2>Colombia, Latin America and the world: where these distortions matter</h2>
<p>Misleading charts are not just a problem for the press or politics. They slip into the results report a school presents to families, into the sales comparison that reaches the manager, into a bid presentation or a thesis. Worldwide, visualization specialists have warned for decades about the "lie factor" of charts; in Colombia and Latin America, where many decisions in small businesses, schools and offices rest on charts made in Excel by one person, the risk is higher because they are rarely reviewed. For a <strong>teacher or school leader</strong>, the lesson is twofold: build honest charts and teach students to read other people's (a key data-literacy skill). For a <strong>manager</strong>, always ask for the axis, the period and the source. For <strong>families</strong>, look at where the axis starts before believing a chart.</p>

<h2>Checklist: review a chart before presenting it</h2>
<p>This is the practical resource. Use it with one of your own reports:</p>
<table>
<thead><tr><th>Question</th><th>If the answer is "no"…</th></tr></thead>
<tbody>
<tr><td>In bars and columns, does the value axis start at zero?</td><td>Fix the minimum bound or switch to a line chart and flag the cut.</td></tr>
<tr><td>Do the charts being compared share the same scale?</td><td>Set equal minimum and maximum, or put them in one chart.</td></tr>
<tr><td>Do I show the whole relevant period, or did I justify the cut?</td><td>Widen the window or explain the criterion.</td></tr>
<tr><td>Did I include all the data that belong (without leaving out uncomfortable cases)?</td><td>Check what was left out and why.</td></tr>
<tr><td>Am I claiming a cause from a correlation alone?</td><td>Change the wording ("is associated with") or find more evidence.</td></tr>
<tr><td>Am I using dual axes?</td><td>Prefer an index or two separate charts.</td></tr>
<tr><td>Does the title say what the chart shows (not an exaggerated conclusion)?</td><td>Describe the data; leave interpretation to the text.</td></tr>
<tr><td>Are units, source and period clear?</td><td>Add a footnote with source and date.</td></tr>
<tr><td>Did someone else review it with fresh eyes?</td><td>Ask for a second read before sending it.</td></tr>
</tbody>
</table>

<h2>Tools to work with your data with judgment</h2>
<p>A good chart starts with clean data. The free <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel con IA</a> download includes the <code>PerfilarDatos</code> macro, which checks the types, blanks and odd values of your table before charting, and in the article <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">how to import a CSV correctly</a> you will see how to keep Excel from damaging your data at the source. If you want someone to review a report with charts or help you build templates with controls, the <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS advisory</a> accompanies you; and to present results without repeating work, <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">Mail merge and individual PDF generation</a> builds per-person documents from your Excel sheet. Learn more on my <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ">Excel playlist on YouTube</a> (in Spanish).</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,combinar-correspondencia-y-generar-pdf-individuales}}
<p>Keep reading: <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a>, <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">how to automate Excel</a> and <a href="/excel-esta-muerto-era-de-la-ia/">Is Excel dead in the age of AI?</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Must a bar chart always start at zero?</h3>
<p>Yes, because the bar's length represents the value. In a line chart you can crop the axis to show variation, but it is wise to flag it and not exaggerate.</p>
<h3>How do I change the axis minimum in Excel?</h3>
<p>Right-click the axis &gt; Format Axis &gt; Bounds &gt; Minimum. Set 0 (or the value you decide) and check that the maximum is reasonable.</p>
<h3>Does a high correlation prove a cause?</h3>
<p>No. It can be due to a third variable, chance or coincidence in time. Use it as a clue to investigate, not as a conclusion.</p>
<h3>What is better than a dual axis?</h3>
<p>An index (each series divided by its starting value) on a single axis, or two separate charts with axes that start at zero.</p>
<h3>How do I detect truncated charts in a workbook with many charts?</h3>
<p>With this article's RevisarEjes macro, which lists the bar or column charts whose axis minimum is not zero.</p>

<p class="notice"><strong>Review one of your reports this week.</strong> Pick a report with charts, apply the checklist and fix at least one. If you want an expert second look at your reports and templates, write to the <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS advisory</a>.</p>

<h2>Food for thought</h2>
<p>An honest chart is almost always less spectacular than one that exaggerates, and in a meeting the spectacular one wins. <strong>If we all know that a cropped axis misleads, why do we keep rewarding charts that impress over charts that inform, and whose responsibility is it: whoever draws it, whoever presents it or whoever does not dare ask where the axis starts?</strong> And should we teach reading a chart at school with the same seriousness with which we teach reading a text?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:c1}}' => $img('graficos-excel-mienten-c1', 480, 'Two column charts of three schools\' pass rates: on the left with the axis cut at 91, where school B looks triple school A; on the right with the axis from zero, where the differences are small.', 'Mistake 1: a truncated axis exaggerates a small difference.'),
    '{{img:c2}}' => $img('graficos-excel-mienten-c2', 787, 'Four column charts of North and South branch sales: with automatic scales they look identical; with the same 0 to 160 scale you can see that the South sells ten times more.', 'Mistake 2: different scales make very different series look alike.'),
    '{{img:c3}}' => $img('graficos-excel-mienten-c3', 480, 'Two line charts of monthly sales: on the left only January to July, showing growth; on the right the full year, with a drop from August.', 'Mistake 3: choosing the period hides the drop.'),
    '{{img:c4}}' => $img('graficos-excel-mienten-c4', 480, 'On the left a scatter plot of ice cream sold against sunburns with correlation 0.998; on the right a line chart with temperature, ice cream and sunburns rising together with the season.', 'Mistake 4: the correlation is very high, but the common cause is heat.'),
    '{{img:c5}}' => $img('graficos-excel-mienten-c5', 480, 'On the left a chart with two cropped axes where advertising spend and visits seem to move together; on the right the same data as an index with base 100, where both lines are almost flat.', 'Mistake 5: two cropped axes invent a relationship.'),
]);

return [
    'graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones' => [
        'slug' => 'excel-charts-can-lie-five-mistakes-that-distort-your-conclusions',
        'title' => 'Excel Charts Can Also Lie: Five Mistakes That Distort Your Conclusions',
        'excerpt' => 'Five Excel chart mistakes (truncated axis, different scales, cherry-picked data, correlation without cause and dual axes) with corrected versions, a VBA macro that detects truncated axes and a checklist.',
        'seo_title' => 'Misleading Excel Charts: 5 Mistakes and How to Fix Them',
        'seo_description' => 'Five Excel chart mistakes that distort conclusions (truncated axis, scales, correlation and dual axes), with examples, a VBA macro and a checklist.',
        'focus_keyword' => 'misleading Excel charts',
        'cover' => '/assets/img/articulos/graficos-excel-mienten/graficos-excel-mienten-portada-en',
        'cover_alt' => 'Cover reading "Excel charts can also lie: five mistakes that distort your conclusions" with a checklist: axis at zero, comparable scales and full period ticked, and confusing correlation with cause crossed out.',
        'content_html' => $html,
    ],
];
