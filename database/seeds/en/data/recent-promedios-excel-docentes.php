<?php

declare(strict_types=1);

// English version of «Promedios en Excel para docentes: siete errores que cambian una nota, con un lib…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/promedios-excel-docentes/' . $name . '-en';
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
<p>A student fails the course by a hundredth. Another passes with a grade that was really a 2.95. A third has an average that does not match the school platform's. When grades are calculated in Excel, <strong>a badly placed formula can change a person's outcome</strong> and almost never gives an error: it simply shows a believable number.</p>
<p>This article gathers seven frequent mistakes when calculating averages in Excel, with <strong>verified results</strong> in a <a href="/descargas/promedios-excel/siete-errores-promedios-excel.xlsx">downloadable sample workbook</a> (in Spanish): each sheet shows the mistake, the formula that produces it, the effect on the result and the fix. Everything was tested in Microsoft Excel 16 with es-CO regional settings and fictional data, on a 1.0 to 5.0 scale. Verified on October 10, 2026.</p>
<p class="notice"><strong>Summary.</strong> The seven mistakes: averaging the averages of groups of different size (3.50 instead of 3.25), counting a pending grade as zero (3.20 instead of 4.00), grades stored as text (4.25 instead of 4.00), a range that omits the last grade (3.40 instead of 3.67), rounding that only shows (2.95 displayed as 3.0), weights that do not add up to 100% (3.60 instead of 4.00) and an unanchored reference when copying the formula (1.60 instead of 5.60). Rounding rules and the treatment of pending grades are defined by each school's assessment system (SIEE).</p>

<h2>Why it matters: an average decides things</h2>
<p>In Colombia, each school's Student Assessment System (SIEE) defines the grading scale and its equivalence to the national scale (Superior, High, Basic and Low), and promotion depends on those values. A grade of 2.95 versus 3.0 can be the difference between "Low" and "Basic". That is why the calculation must be <strong>correct, verifiable and consistent with the SIEE's rules</strong>. (For the discussion of what grades measure, see <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">grades: learning or compliance?</a>.)</p>
{{img:efectos}}

<h2>Mistake 1: averaging the averages of groups of different size</h2>
<p><strong>Case.</strong> Group A of 10 students has an average of 4.0 and group B of 30 has an average of 3.0. What is the average of the 40?</p>
<pre><code>=AVERAGE(B4,B6)                          ' English: 3.50   (mistake)
=(B3*B4+B5*B6)/(B3+B5)                   ' English: 3.25   (correct)

=PROMEDIO(B4;B6)                         ' Spanish
=(B3*B4+B5*B6)/(B3+B5)</code></pre>
<p><strong>Why it fails.</strong> The average of the two averages treats the groups as if they weighed the same, when B has three times as many students. The correct result weights by size: 3.25. This shows up when the "institutional average" is computed from per-class averages.</p>

<h2>Mistake 2: counting a pending grade as zero</h2>
<p><strong>Case.</strong> Five assignments: 4.0; 3.5; pending; 4.5; 4.0. Someone typed 0 in the pending one "so as not to leave the cell empty".</p>
<pre><code>=AVERAGE(B3:B7)                          ' with the 0: 3.20
=AVERAGE(B3:B4,B6:B7)                    ' not counting the pending one: 4.00</code></pre>
<p><strong>Why it fails.</strong> A 0 is a grade; an empty cell is "not yet". <code>AVERAGE</code> ignores empty cells but counts zeros. The difference, in this case, is 0.80 points. How to treat unsubmitted work (zero, minimum grade, a chance to submit) is a decision the SIEE defines; what cannot happen is for Excel to make it with nobody having decided it.</p>

<h2>Mistake 3: grades stored as text</h2>
<p><strong>Case.</strong> Four grades: 4.0; "3,5" (text); 4.5; "4,0" (text), pasted from another system.</p>
<pre><code>=AVERAGE(B3:B6)                          ' ignores the text: 4.25  (averages only 4.0 and 4.5)
=SUMPRODUCT(VALUE(B3:B6))/COUNTA(B3:B6)  ' converts: 4.00</code></pre>
<p><strong>Why it fails.</strong> <code>AVERAGE</code> ignores text without warning: it averaged only two of the four grades. You recognize it because the value is left-aligned or a green triangle appears in the cell. Conversion with <code>VALUE</code> depends on regional settings (see <a href="/compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional/">Excel workbook compatibility between machines</a>), so the best thing is to fix the data at the source and use <em>data validation</em> so only numbers between 1.0 and 5.0 are accepted.</p>

<h2>Mistake 4: a range that omits the last grade</h2>
<p><strong>Case.</strong> <code>=AVERAGE(B3:B7)</code> was written when there were five grades (3.0; 4.0; 5.0; 2.0; 3.0). A sixth (5.0) was later added in row 8.</p>
<pre><code>=AVERAGE(B3:B7)                          ' 3.40  (mistake: B8 missing)
=AVERAGE(B3:B8)                          ' 3.67  (correct)</code></pre>
<p><strong>Why it fails.</strong> Formulas do not know a grade was added below. The defense is to turn the data into an <strong>Excel table</strong> (the range grows by itself), or to count the grades and compare: <code>=COUNT(B3:B8)</code> against the number of activities.</p>

<h2>Mistake 5: rounding that only shows</h2>
<p><strong>Case.</strong> Two components: 3.0 and 2.9, both weighted 50%. The final grade is 2.95, but with one decimal in the cell format it looks like <strong>3.0</strong>.</p>
<pre><code>=B3*0.5+B4*0.5                           ' is 2.95; displays 3.0
=IF(B5>=3,"Aprueba","No aprueba")        ' compares 2.95: "No aprueba" (does not pass)
=IF(ROUND(B5,1)>=3,"Aprueba","No aprueba")   ' if the SIEE rounds to one decimal: "Aprueba" (passes)</code></pre>
<p><strong>Why it fails.</strong> <em>Formatting</em> changes what you see, not what the value is. A cell that shows 3.0 can be worth 2.95, and comparisons use the real value. It is probably the most unfair mistake, because the student sees a 3.0 on the sheet and a decision that does not match. The fix is to decide (per the SIEE) how many decimals to round to and apply it <strong>with the function</strong>, not with formatting, before comparing.</p>

<h2>Mistake 6: weights that do not add up to 100%</h2>
<p><strong>Case.</strong> Midterm 4.0; assignment 3.0; project 5.0, each with a 30% weight (adding up to 90%, not 100%).</p>
<pre><code>=SUMPRODUCT(B3:B5,C3:C5)                 ' 3.60  (mistake: weights add to 90%)
=SUMPRODUCT(B3:B5,C3:C5)/SUM(C3:C5)      ' 4.00  (normalized)</code></pre>
<p><strong>Why it fails.</strong> If weights do not add up to 100%, the grade ends up below (or above) what it should be. Normalization (dividing by the sum of weights) hides the problem; it is better to <strong>validate that they add up to 100%</strong> and fix the weights. A control cell (<code>=SUM(C3:C5)</code> with conditional formatting that turns red if it is not 100%) prevents it.</p>

<h2>Mistake 7: the relative reference when copying the formula</h2>
<p><strong>Case.</strong> The assignment's weight (40%) is in one cell. The first row works; when copying the formula down, the reference to the weight shifts.</p>
<pre><code>' Row 3 (correct), row 4 (the reference shifts to E3, empty), etc.
=B3*E2        =B4*E3        =B5*E4        =B6*E5     ' sum: 1.60
=B3*$E$2      =B4*$E$2      =B5*$E$2      =B6*$E$2   ' sum: 5.60 (correct)</code></pre>
<p><strong>Why it fails.</strong> A relative reference shifts when copied; the <code>$</code> sign anchors it. With four students, the sum with the mistake gives 1.60 instead of 5.60, because only the first row used the weight. You recognize it because the rows below give 0. Rule of thumb: <strong>every parameter (weight, target, threshold) goes in one cell and is referenced with the $ sign</strong>, or better, with a defined name.</p>

<h2>A checklist for reviewing a gradebook</h2>
<ol>
<li><strong>Count the grades:</strong> compare <code>COUNT</code> with the expected number of activities per student.</li>
<li><strong>Look for text among the numbers:</strong> <code>=COUNTA(range)-COUNT(range)</code> must be 0.</li>
<li><strong>Review the zeros:</strong> are they real grades or pending items?</li>
<li><strong>Verify that weights add up to 100%</strong> with a control cell.</li>
<li><strong>Decide and document rounding</strong> (per the SIEE) and apply it with <code>ROUND</code>.</li>
<li><strong>Anchor parameters</strong> with $ or names.</li>
<li><strong>Calculate two students by hand</strong> and compare with the sheet.</li>
<li><strong>Protect the formulas</strong> and keep a copy before each reporting period (see <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a>).</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, spreadsheets are many teachers' default tool for keeping grades, and formula errors in spreadsheets are a documented problem in all kinds of organizations. In Colombia and Latin America the risk is worse because of the mix of platforms (the school has an official platform and each teacher keeps their own Excel) and the pressure of reporting deadlines. For <strong>teachers</strong>, the lesson is to audit their own workbook before handing in grades; for <strong>principals</strong>, to define in the SIEE how grades are calculated and rounded, and to cross-check the workbook against the platform; for <strong>families</strong>, to ask calmly how a grade was calculated; and for <strong>students</strong>, to understand that a grade has a formula that can be reviewed. And when the workbook grows, with several teachers editing, a specific tool is advisable (see <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">when Excel stops being the solution</a>).</p>

<h2>Ready-made templates</h2>
<p>If you prefer to start from templates with controls, look at these options. And to ask an AI for help with your formulas (always verifying the result and without pasting student data into free tools), there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL!, #CALC! and #VALUE! errors</a>, <a href="/listas-desplegables-dependientes-excel-metodo-clasico-y-moderno-plantilla/">dependent drop-down lists</a> and <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">a dashboard that helps you act</a>. For those who keep grades with AI, see also <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into a free AI tool</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Why does Excel show 3.0 if the grade is 2.95?</h3>
<p>Because the cell format shows one decimal, but the stored value is 2.95. For the value to change you must round with the ROUND function, per the SIEE's rule.</p>
<h3>Does AVERAGE count empty cells?</h3>
<p>No: it ignores empty cells and text, but it does count zeros.</p>
<h3>How do I calculate a weighted average in Excel?</h3>
<p>With SUMPRODUCT of the grades and weights, divided by the sum of the weights (which must be 100%): =SUMPRODUCT(grades,weights)/SUM(weights).</p>
<h3>How do I keep my formula from leaving out a new grade?</h3>
<p>Turn the data into an Excel table, so the range grows by itself, and compare the count of grades with what is expected.</p>
<h3>What is an anchored reference?</h3>
<p>A reference with a $ sign (for example, $E$2) that does not shift when the formula is copied to other cells.</p>

<p class="notice"><strong>Review your gradebook today.</strong> Download the <a href="/descargas/promedios-excel/siete-errores-promedios-excel.xlsx">seven-mistakes workbook</a> (in Spanish), look at each case and apply the checklist to your own workbook before the next reporting period.</p>

<h2>Food for thought</h2>
<p>A grade is a decision about a person expressed as a number, and that number comes from a formula almost nobody reviews. <strong>Should a school require teachers' gradebooks to be audited, or would that be distrusting the craft? And when a miscalculated grade harms a student, who answers: the teacher who built the sheet, the school that did not review it or the system that forces calculating by hand?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:efectos}}' => $img('promedios-excel-docentes-efectos', 663, 'Table with seven mistakes when calculating averages in Excel and their effect: averaging averages 3.50 versus 3.25, pending as zero 3.20 versus 4.00, grades as text 4.25 versus 4.00, incomplete range 3.40 versus 3.67, rounding 2.95 versus 3.00, 90% weights 3.60 versus 4.00 and unanchored reference 1.60 versus 5.60.', 'The same data, two results.'),
]);

return [
    'promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota' => [
        'slug' => 'averages-in-excel-for-teachers-seven-mistakes-that-change-a-grade',
        'title' => 'Averages in Excel for Teachers: Seven Mistakes That Change a Grade, with a Verified Sample Workbook',
        'excerpt' => 'Seven frequent mistakes when calculating averages in Excel (averages of averages, zeros, text, ranges, rounding, weights and references), each with its formula, verified effect and fix, in a downloadable workbook.',
        'seo_title' => 'Averages in Excel for Teachers: 7 Common Mistakes',
        'seo_description' => 'Seven mistakes when calculating averages and grades in Excel (zeros, text, rounding, weights, references) with verified results and a sample workbook.',
        'focus_keyword' => 'averages in Excel teachers',
        'cover' => '/assets/img/articulos/promedios-excel-docentes/promedios-excel-docentes-portada-en',
        'cover_alt' => 'Cover "Averages in Excel for teachers: seven mistakes that change a grade" with a card: average of two groups of different size, 3.50 if the averages are averaged versus 3.25 if weighted, and two more examples of mistakes.',
        'content_html' => $html,
    ],
];
