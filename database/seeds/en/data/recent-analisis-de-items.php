<?php

declare(strict_types=1);

// English version of «Análisis de ítems en Excel: dificultad, discriminación, distractores y KR-20 de …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/analisis-de-items/' . $name . '-en';
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
<p>You give your group a twenty-question multiple-choice test, grade it with the key and hand out marks. But how many of those twenty questions <strong>really measured what you wanted to measure</strong>? A question everyone gets right distinguishes nobody; one almost nobody gets right may be badly worded; one whose key is wrong punishes those who know most. <em>Item analysis</em> is the review of each question with the response data, and it can be done in Excel in minutes.</p>
<p>This article explains the classic indicators (difficulty, discrimination, item-total correlation, distractor analysis and KR-20 reliability), with a <a href="/descargas/analisis-de-items/analisis-de-items-prueba.xlsx">downloadable Excel workbook</a> (in Spanish) that calculates them automatically for 30 fictional students and 20 items. The formulas were verified in Microsoft Excel 16 and all results were checked against an independent Python calculation. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional. The indicators are <strong>signals to look at an item, not verdicts</strong>: with small groups (such as 30 students) they are very unstable, and reference values depend on the test's purpose. The decision on what to do with an item is the teacher's, with the question's content in view. How to grade and promotion decisions are defined by each school's SIEE.</p>

<h2>The indicators, one by one</h2>
{{img:indicadores}}
<ul>
<li><strong>Difficulty (p).</strong> The proportion of students who get the item right: <code>=AVERAGE(column of 0s and 1s)</code>. A p of 0.90 means 9 of 10 got it right (very easy); a p of 0.15, that only 3 of 20 did (very hard). As a guide, a p between 0.30 and 0.80 is usually considered desirable, although a mastery test may have easy questions on purpose.</li>
<li><strong>Discrimination (D).</strong> How well the item separates those who know more from those who know less. It is calculated by comparing the high and low groups by total score: traditionally the top 27% and bottom 27% (Kelley's rule, 1939); with 30 students, 8 in each group. <code>D = (correct in the high group − correct in the low group) / group size</code>. A classic reference (Ebel) reads it like this: 0.40 or more, excellent; 0.30 to 0.39, good; 0.20 to 0.29, marginal; under 0.20, poor; negative, something is wrong (the item works backward).</li>
<li><strong>Corrected item-total correlation.</strong> The correlation between getting the item right and the total score <em>without that item</em> (so it does not count against itself). It should be positive; near zero or negative indicates the item does not go with the rest of the test. In Excel: <code>=CORREL(item, total − item)</code>.</li>
<li><strong>Distractor analysis.</strong> How many students choose each option. A distractor almost nobody chooses does not do its job; one that attracts the high group more than the low group may be ambiguous; and if the most chosen option is not the key, suspect the key.</li>
<li><strong>KR-20 reliability.</strong> An internal consistency coefficient for right/wrong items (Kuder and Richardson, 1937): <code>KR-20 = (k/(k−1)) · (1 − Σ p·q / σ²)</code>, where k is the number of items, p·q each item's variance and σ² the variance of the total score. It runs from 0 to 1; high values indicate the items measure something in common, and it depends on the number of items (more items, higher KR-20).</li>
</ul>

<h2>The workbook, sheet by sheet</h2>
<ul>
<li><strong>Respuestas:</strong> one row per student and one column per item with the letter chosen (A to D), and the key in row 3.</li>
<li><strong>Puntajes:</strong> turns responses into 1 (correct) or 0 (wrong) by comparing with the key, calculates the total, the rank (tie-broken by list order, so there are exactly 8 students in each group) and the group (high, middle, low).</li>
<li><strong>Items:</strong> for each item, p, each group's correct answers, D, item-total correlation, each option's count, the most chosen option, rarely chosen distractors and a diagnosis.</li>
<li><strong>Resumen:</strong> mean, standard deviation, mean difficulty, KR-20 and the count of acceptable items and those to review.</li>
</ul>
<pre><code>' Correct (1/0): the student's response against the key in row 3
=IF(Respuestas!B4=Respuestas!B$3,1,0)                                    ' English
=SI(Respuestas!B4=Respuestas!B$3;1;0)                                    ' Spanish

' Difficulty p and discrimination D (high and low groups of 8 students)
=AVERAGE(Puntajes!B3:B32)
=(SUMIFS(item, group, "Alto") - SUMIFS(item, group, "Bajo")) / 8

' Corrected item-total correlation
=CORREL(Puntajes!B3:B32, Puntajes!$V$3:$V$32 - Puntajes!B3:B32)

' KR-20
=(k/(k-1)) * (1 - SUMPRODUCT(p, 1-p) / STDEV.P(totals)^2)</code></pre>

<h2>What the analysis found (fictional data)</h2>
<p>The group of 30 students had a mean of <strong>11.63 out of 20</strong> (standard deviation 3.02), a mean difficulty of 0.58 and a <strong>KR-20 of 0.60</strong>. Of the 20 items, 16 were acceptable and 4 asked for review:</p>
<ul>
<li><strong>Item 7: possible key error.</strong> With the published key (A), only 3 of 30 students got it right (p of 0.10). But <strong>17 of 30 chose option C</strong>, including 7 of the 8 students in the high group. When almost the whole high group chooses the same option other than the key, the key is most likely wrong (or the question has two defensible answers). With the key corrected to C, the group mean rises from 11.63 to <strong>12.10</strong>, KR-20 from 0.60 to <strong>0.66</strong>, and <strong>20 of the 30 students change score</strong>: 17 gain a point and 3 lose one. If the passing line were 12 of 20, 16 students would pass instead of 14.</li>
<li><strong>Item 3: discriminates backward.</strong> None of the 8 in the high group got it right, while 3 of the 8 in the low group did (D of −0.38); 5 of the 8 in the high group chose option D. A negative discrimination is an alarm: are there two correct answers? does the wording confuse those who think more? is the content from another topic? You have to read the question.</li>
<li><strong>Item 11: poorly discriminating and hard.</strong> p of 0.27, D of 0.13 and the four options chosen almost equally (8, 8, 7 and 7): the distribution of guessing. It usually indicates the content was not taught or the question is ambiguous.</li>
<li><strong>Item 14: very easy.</strong> p of 0.93 and two distractors nobody chose. It is not necessarily a problem (it may verify an expected minimum), but it distinguishes nobody.</li>
</ul>
<p>Among the good items, 6 and 16 (D of 0.88) separate the high group from the low very well, and item 8 (D of 0.75) too. Items 12 and 14 have distractors almost nobody chooses (item 12: nobody chose option C and one student chose D), an opportunity to improve the options.</p>
{{img:pasos}}

<h2>Five steps to review an item</h2>
<ol>
<li><strong>Look at difficulty:</strong> too easy or too hard for the purpose?</li>
<li><strong>Look at discrimination:</strong> does it separate those who know from those who do not? If negative, it is the first priority.</li>
<li><strong>Look at the options:</strong> which do the high-group students choose? Is there a distractor nobody chooses?</li>
<li><strong>Decide:</strong> keep, adjust (wording, distractors) or remove; and if there is a key error, fix it and regrade.</li>
<li><strong>Document:</strong> note what changed and why, for next year's question bank.</li>
</ol>

<h2>What the analysis cannot tell you</h2>
<ul>
<li><strong>With 30 students, the numbers are fragile.</strong> A difference of a couple of students in a group of 8 moves D a lot. Useful for spotting extreme cases (like item 7), unreliable for deciding between a "good" and a "fair" item.</li>
<li><strong>It does not say whether the item is valid.</strong> An item can have good discrimination and measure something else (for example, reading comprehension instead of mathematics).</li>
<li><strong>It does not say whether it is fair.</strong> Traditional analysis does not detect bias; there are specific methods for that.</li>
<li><strong>KR-20 depends on length and homogeneity.</strong> A short test or one mixing many topics will have a lower KR-20 without necessarily being bad.</li>
</ul>
<p>These indicators belong to classical test theory; large-scale standardized tests also use more sophisticated models (item response theory). For a teacher, classical theory is enough to clean up a question bank. And it connects with other assessment decisions: see <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">backward design</a> (does the item assess an outcome I taught?), <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">averages in Excel: seven mistakes</a> (the grade calculation) and <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">the math error that keeps repeating</a> (distractor analysis shows which errors attract students).</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, standardized tests such as Saber analyze their items with specialized statistical methods before using them, but tests given in class almost never go through any analysis: they are prepared, administered and graded. In the region and worldwide, the quality of teacher-made items is a recurring topic in assessment training. For <strong>teachers</strong>, the analysis is a concrete way to improve their question bank without depending on anyone; for <strong>principals</strong>, a reason for departments to share and clean their banks; for <strong>families</strong>, to know that a test can be reviewed and corrected when a key fails; and for <strong>students</strong>, that an error of the instrument is not their error. When a test is used to decide promotion, checking keys before handing out marks is an act of fairness.</p>

<h2>Templates and tools</h2>
<p>To generate multiple-choice questions with a key and plausible distractors, and then analyze them with this workbook, look at these tools of our own (always reviewing what the AI produces, especially the keys). And to ask for help with your formulas, there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:generador-de-examenes-ia-esencial,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL! and #VALUE! errors</a>, <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">a dashboard that helps you act</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>. For those preparing for the competition, see <a href="/herramientas/simulacro-concurso-docente/">the mock exam tool</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is item analysis?</h3>
<p>The review of each question on a test with the response data: how hard it was, how well it distinguishes those who know more from those who know less and which options students chose.</p>
<h3>What is a good discrimination index?</h3>
<p>As a classic reference, 0.30 or more is considered good and 0.40 or more excellent; under 0.20 is poor and negative is an alarm. With small groups, these values are very unstable.</p>
<h3>How do I know whether a question's key is wrong?</h3>
<p>If the most chosen option is not the key, and especially if almost all students in the high group choose it, it is a strong signal. Verify the question before deciding.</p>
<h3>What is KR-20?</h3>
<p>An internal consistency coefficient for right/wrong tests: it indicates how much the items measure something in common. It runs from 0 to 1 and depends on the number of items.</p>
<h3>Does it work with small groups?</h3>
<p>It serves to detect extreme cases (wrong keys, items that work backward), but discrimination and KR-20 values are unstable with few students.</p>

<p class="notice"><strong>Review your last test.</strong> Download the <a href="/descargas/analisis-de-items/analisis-de-items-prueba.xlsx">item analysis workbook</a> (in Spanish), paste your group's responses and the key, and see which items it asks you to review before handing out marks.</p>

<h2>Food for thought</h2>
<p>If a question on your test has the wrong key, how many students paid for it with their marks before anyone noticed? <strong>What would have to happen in a school for reviewing items before grading to be a normal practice and not an exception? And when an analysis shows a question failed, do we own the instrument's error or keep defending the mark?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:indicadores}}' => $img('analisis-de-items-indicadores', 499, 'Table with four item indicators, what each measures and its indicative reference: difficulty, discrimination, item-total correlation and distractors.', 'What each indicator measures and how to read it.'),
    '{{img:pasos}}' => $img('analisis-de-items-pasos', 467, 'Five steps to review an item: difficulty, discrimination, options, decide and document.', 'Five steps before deciding.'),
]);

return [
    'analisis-de-items-excel-dificultad-discriminacion-distractores-kr20-libro' => [
        'slug' => 'item-analysis-excel-difficulty-discrimination-distractors-kr20-workbook',
        'title' => 'Item Analysis in Excel: Difficulty, Discrimination, Distractors and KR-20 of Your Test (Verified Workbook)',
        'excerpt' => 'How to know which questions on your multiple-choice test work: difficulty, discrimination, item-total correlation, distractor analysis and KR-20 in Excel, with a verified workbook and a wrong-key case.',
        'seo_title' => 'Item Analysis in Excel for Teachers',
        'seo_description' => 'Analyze your multiple-choice tests in Excel: difficulty, discrimination, distractors and KR-20, with a verified workbook and how to spot a wrong key.',
        'focus_keyword' => 'item analysis Excel',
        'cover' => '/assets/img/articulos/analisis-de-items/analisis-de-items-portada-en',
        'cover_alt' => 'Cover "Item analysis in Excel: which questions of your test really work" with a card: 17 of 30 students chose the same option on item 7, and it was not the published key.',
        'content_html' => $html,
    ],
];
