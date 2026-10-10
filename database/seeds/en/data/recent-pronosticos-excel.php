<?php

declare(strict_types=1);

// English version of "Pronósticos en Excel: tendencia, estacionalidad y cuándo no confiar en el result…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/pronosticos-excel/' . $name . '-en';
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
<p>Forecasting sales, enrollments or consumption sounds like a task for specialists, but Excel comes with functions and tools that do it in a few clicks. The problem is that <strong>a forecast always produces a number</strong>, and a well-presented number inspires confidence even when the method is unsuitable. The important question is not "what does Excel say?" but "how do I know whether I can believe it?".</p>
<p>In this article I do something uncommon in this kind of text: a <strong>backtest</strong>. I train four methods on 24 months of fictional data, forecast the next 12 months and compare with what "actually happened". The results come from Microsoft Excel (version 16, es-CO regional settings) and the <a href="/descargas/pronosticos-excel/pronosticos-excel-ejercicios.xlsx">exercise workbook with solutions</a> (in Spanish) is downloadable. Verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> In the test, the ETS forecast with seasonality specified (12 months) had a mean error of 3.0%; the linear trend, 11.1%; the seasonal naive method, 13.0%; and the same ETS with seasonality <em>auto-detected</em>, 15.4%. The lesson: <strong>trend and seasonality matter, automatic mode does not always get it right, and no forecast is accepted without testing it on data it did not learn from</strong>. The data are fictional: the result illustrates the method, it is not a general rule.</p>

<h2>Trend and seasonality: what we are talking about</h2>
<ul>
<li><strong>Trend:</strong> where the series is heading in the long run (up, down, flat).</li>
<li><strong>Seasonality:</strong> a pattern that repeats every cycle; for example, a school's uniform sales that rise in January-February and in July, when terms start.</li>
<li><strong>Noise:</strong> random variation that no method explains.</li>
</ul>
<p>The test data are fictional monthly uniform sales over three years (2022 to 2024), generated with a rising trend, peaks in January, February and July, and some noise. I train on 2022-2023 and forecast 2024.</p>

<h2>The four methods</h2>
<ol>
<li><strong>Seasonal naive:</strong> forecasts each month with the value of the same month last year. It is the simplest method and the minimum bar: if a complex method does not beat it, it is not worth it.</li>
<li><strong>Linear trend</strong> (<code>FORECAST.LINEAR</code>; <code>PRONOSTICO.LINEAL</code> in Spanish): draws a straight line through the data. It ignores seasonality.</li>
<li><strong>ETS with seasonality specified</strong> (<code>FORECAST.ETS</code> with 12 as the seasonality): triple exponential smoothing, which models level, trend and seasonality.</li>
<li><strong>ETS with automatic seasonality:</strong> the same function without stating the cycle, so Excel detects it.</li>
</ol>
<pre><code>' In English
=FORECAST.LINEAR(A28, B$4:B$27, A$4:A$27)
=FORECAST.ETS(A28, B$4:B$27, A$4:A$27, 12)
=FORECAST.ETS(A28, B$4:B$27, A$4:A$27)
=FORECAST.ETS.SEASONALITY(B$4:B$27, A$4:A$27)

' In Spanish
=PRONOSTICO.LINEAL(A28; B$4:B$27; A$4:A$27)
=PRONOSTICO.ETS(A28; B$4:B$27; A$4:A$27; 12)
=PRONOSTICO.ETS(A28; B$4:B$27; A$4:A$27)
=PRONOSTICO.ETS.ESTACIONALIDAD(B$4:B$27; A$4:A$27)</code></pre>
<p>Each formula forecasts the date in A28 using only the data in rows 4 to 27 (the 24 training months), so the method does not "see" the future.</p>

<h2>The results</h2>
{{img:prueba}}
<p>The mean absolute percentage error (MAPE) of each method over the 12 test months:</p>
{{img:error}}
<table>
<thead><tr><th>Method</th><th>MAPE</th><th>What happened</th></tr></thead>
<tbody>
<tr><td><strong>ETS with 12 months specified</strong></td><td>3.0%</td><td>Captured the January-February and July peaks</td></tr>
<tr><td><strong>Linear trend</strong></td><td>11.1%</td><td>An almost flat line: ignored seasonality entirely</td></tr>
<tr><td><strong>Seasonal naive</strong></td><td>13.0%</td><td>Got the shape right but not the growth: underestimated the whole year</td></tr>
<tr><td><strong>Automatic ETS</strong></td><td>15.4%</td><td>Excel detected a 6-month seasonality, not 12: overestimated most of the year</td></tr>
</tbody>
</table>
<p>The surprise is the last row. When I asked Excel to detect the seasonality (<code>FORECAST.ETS.SEASONALITY</code>), it returned <strong>6</strong>, because the data have two peaks per year. The resulting forecast ended up worse than a plain straight line. When <strong>you</strong> know the cycle is annual, specify it: in this example it cut the error from 15.4% to 3.0%. And that does not mean automatic always fails; it means <strong>you have to check</strong>.</p>

<h2>The seven most common mistakes</h2>
<ol>
<li><strong>Extrapolating a straight line over seasonal data.</strong> The linear trend gives a "reasonable" number that ignores the peaks.</li>
<li><strong>Trusting automatic seasonality without checking it.</strong> Compare what it detects with what you know about the business.</li>
<li><strong>Not running a backtest.</strong> If you do not forecast a period you already know, you do not know whether the method works.</li>
<li><strong>Too little history.</strong> To estimate seasonality you need at least two full cycles; with 12 months there is no way to tell it from noise.</li>
<li><strong>Ignoring shocks.</strong> A pandemic, a closure or a policy change breaks the pattern; the model cannot foresee them.</li>
<li><strong>Delivering a single number.</strong> A forecast without a confidence interval hides uncertainty. In the workbook, the January 2025 forecast with all 36 months is about 199 units, with a 95% interval of roughly 189 to 208 (<code>FORECAST.ETS.CONFINT</code>).</li>
<li><strong>Irregular or missing dates.</strong> ETS functions need a timeline with constant steps (for example, monthly).</li>
</ol>
<p>And a warning about charts: a forecast plotted with a truncated axis or two different scales can mislead as much as those in <a href="/graficas-de-excel-mienten-cinco-errores-distorsionan-conclusiones/">charts that lie</a>.</p>

<h2>The exercise workbook</h2>
<p>The file includes the 36 months of data, the backtest already built (with the four formulas and the errors by month), five exercises and their solutions. Some exercises: compute each month's seasonal index (in the example, January is about 1.24 and May 0.79 relative to the average); forecast January 2025 with a confidence interval; replace the naive method with "same month last year plus average growth"; and simulate a shock (a 40% drop in April) to see how forecasts degrade. That last practice teaches the most important thing: <strong>models learn from the past and do not warn you when the past stops being useful</strong>.</p>
<p>You can also use Excel's wizard ("Data", "Forecast Sheet"), which applies ETS and draws the interval; the results depend on what it detects, and it is worth applying the same backtest.</p>

<h2>Colombia, Latin America and the world</h2>
<p>Forecasting well has huge practical value where there is little slack: a school estimating enrollment to hire teachers, a shop deciding how much inventory to buy before the school season, a small business planning its cash flow. In Colombia, the seasonality of the school calendar (A and B calendars), the June and December bonuses and holidays create very marked patterns that a good forecast must respect; and swings in the dollar or inflation can break the trend. For <strong>principals and administrators</strong>, the forecast is an aid to decide, not a promise; for math or technology <strong>teachers</strong>, it is an excellent case for teaching how to evaluate models with real data; for <strong>families</strong> and the community, understanding that an estimate has a margin of error helps read the figures they are shown.</p>

<h2>Tools to work with your data in Excel</h2>
<p>If you want to automate tasks with your data or have orderly templates, look at these options. And to review statistics and functions with AI support, there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:plantilla-en-excel-de-factura-sencilla-numeracion-automatica,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">when Excel stops being the solution</a>, <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a> and <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">how to automate in Excel</a>. For analysis of your own classroom data, see the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is the difference between FORECAST.LINEAR and FORECAST.ETS?</h3>
<p>FORECAST.LINEAR draws a straight line and ignores seasonality; FORECAST.ETS uses triple exponential smoothing and models level, trend and seasonality.</p>
<h3>How much data do I need for a seasonal forecast?</h3>
<p>At a minimum, two full cycles (for example, 24 months for an annual cycle); ideally, more.</p>
<h3>How do I evaluate whether a forecast is good?</h3>
<p>With a backtest: train on part of the data, forecast what you already know and compute an error such as MAPE. Always compare with a simple method, such as repeating last year.</p>
<h3>Can I trust Excel's automatic seasonality?</h3>
<p>Check it. In the example it detected 6 months instead of 12 and the error went up. If you know the cycle, specify it.</p>
<h3>Does a forecast predict the future?</h3>
<p>No: it projects patterns from the past. If the context changes (a closure, a crisis, a new policy), the forecast loses validity.</p>

<p class="notice"><strong>Try it with your data.</strong> Download the <a href="/descargas/pronosticos-excel/pronosticos-excel-ejercicios.xlsx">forecasting workbook</a> (in Spanish), solve the exercises and replace the fictional data with your sales, enrollments or consumption; then compare the four methods in the "Pronostico" sheet before believing in a number. It requires Excel 2016 or later (ETS functions).</p>

<h2>Food for thought</h2>
<p>A well-presented forecast looks like a fact, even if it is an informed bet. <strong>Who should answer when an important decision (hiring teachers, buying inventory, closing a branch) is made on a forecast that turned out wrong: whoever built the model, whoever presented it or whoever decided without asking about the margin of error? And if models learn from the past, how do we keep them from locking us into it just when the future needs to be different?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:prueba}}' => $img('pronosticos-excel-prueba', 520, 'Line chart with 36 months of fictional sales and, in the last 12, the actual value against three forecasts: the almost flat linear trend, ETS with 12 months specified following the peaks and ETS with automatic seasonality overestimating.', 'Actual vs forecasts: trained on 24 months and tested on 12.'),
    '{{img:error}}' => $img('pronosticos-excel-error', 436, 'Bars with each method\'s mean absolute percentage error: ETS with 12 months specified 3.0%, linear trend 11.1%, seasonal naive 13.0% and automatic ETS 15.4%.', 'Mean error of each method in the test.'),
]);

return [
    'pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar' => [
        'slug' => 'forecasting-in-excel-trend-seasonality-when-not-to-trust-it',
        'title' => 'Forecasting in Excel: Trend, Seasonality and When Not to Trust the Result',
        'excerpt' => 'A backtest of four forecasting methods in Excel (straight line, manual and automatic ETS, and seasonal naive), with measured errors, the seven most common mistakes and an exercise workbook with solutions.',
        'seo_title' => 'Excel Forecasting: Seasonality and Error Testing',
        'seo_description' => 'Excel forecasting with FORECAST.ETS and linear trend: a backtest with measured errors, common mistakes and a downloadable exercise workbook.',
        'focus_keyword' => 'forecasting in Excel',
        'cover' => '/assets/img/articulos/pronosticos-excel/pronosticos-excel-portada-en',
        'cover_alt' => 'Cover "Forecasting in Excel: trend, seasonality and when not to trust the result" with a card: 3.0% vs 15.4% average error of ETS with seasonality specified vs automatic, naive 13.0% and linear trend 11.1%.',
        'content_html' => $html,
    ],
];
