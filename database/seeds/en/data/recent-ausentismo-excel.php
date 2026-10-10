<?php

declare(strict_types=1);

// English version of «Ausentismo escolar en Excel: asistencia, ausentismo crónico, rachas y patrones p…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ausentismo-excel/' . $name . '-en';
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
<p>Every morning, the homeroom teacher takes attendance and writes "absent". The next day, again. By the end of the term, a student has missed thirteen days and nobody noticed until they showed up at the evaluation committee. What is needed is not a longer list, but <strong>a way of reading attendance that shows in time who needs help and what pattern hides behind it</strong>.</p>
<p>This article presents how to analyze school absenteeism in Excel: group attendance, <strong>chronic absence</strong>, streaks of consecutive absences and patterns by weekday. It includes a <a href="/descargas/ausentismo-excel/ausentismo-escolar-excel.xlsx">downloadable workbook</a> (in Spanish) with 20 fictional students (identified only by code) over 20 school days, with results verified in Microsoft Excel 16 and against an independent Python calculation. Sources and rules reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional; <strong>do not use real names or data of students</strong> in tools not designed to safeguard them, and respect your institution's data-protection rules. Absenteeism has diverse causes and is almost never a matter of "willpower": the analysis serves to offer support, not to label. The consequences of absence for promotion are defined by each school's student assessment system (SIEE).</p>

<h2>Absenteeism, chronic absence and dropout</h2>
<ul>
<li><strong>Absenteeism</strong> is not attending class, justified or not. A sick student is absent, and the absence is legitimate, but it still affects their learning.</li>
<li><strong>Chronic absence.</strong> In the literature and in several U.S. education authorities it is defined as missing <strong>10% or more of the days</strong> the student is enrolled, <strong>for any reason</strong> (excused or not). That measure differs from "unexcused absence" and from the school's average daily attendance: a school can have 95% average attendance and still have a group of students who miss a lot, because the average hides them. The 10% threshold is also used in that country's federal reporting, according to state agency summaries; it is not a Colombian rule.</li>
<li><strong>Dropout</strong> is leaving the education system. Sustained absenteeism is often an early signal: dropout is rarely an event, almost always a process. That is why looking at absences in time is a prevention tool.</li>
</ul>
<p><strong>What Colombian regulation says about absence.</strong> The Constitution (art. 67) establishes that education is compulsory between ages five and fifteen, with at least one year of preschool and nine of basic education. On the consequences of absence, Decree 1290 of 2009 (now compiled in Decree 1075 of 2015, art. 2.3.3.3.3.6) provides that each establishment defines in its SIEE the promotion criteria, including the attendance percentage that bears on it. According to information from the Ministry of Education consulted for this article, there is no longer a fixed national absence percentage that determines grade repetition, and the "25%" rule many remember belongs to earlier regulations; <strong>check your school's SIEE</strong> to know what applies there. In addition, when it is determined that a student cannot be promoted, the establishment must guarantee the place to continue their studies.</p>

<h2>The workbook, sheet by sheet</h2>
<p>The <em>Asistencia</em> sheet is a matrix: one student per row and one day per column, with codes <strong>P</strong> (present), <strong>A</strong> (absent, unexcused), <strong>J</strong> (absent, excused) and <strong>T</strong> (late, counted as present). The <em>Analisis</em> sheet calculates, per student, days recorded, unexcused and excused absences, attendance percentage, lates, the <strong>maximum streak</strong> of consecutive absences and whether it exceeds the chronic-absence threshold (editable, 10% by default). The <em>Resumen</em> sheet aggregates the group and counts absences by weekday and by week.</p>
{{img:lecturas}}
<pre><code>' A student's total absences: unexcused (A) plus excused (J)
=COUNTIF(Asistencia!B4:U4,"A") + COUNTIF(Asistencia!B4:U4,"J")            ' English
=CONTAR.SI(Asistencia!B4:U4;"A") + CONTAR.SI(Asistencia!B4:U4;"J")        ' Spanish

' Chronic absence? (absences / days recorded >= threshold)
=IF(E5/B5>=$E$2,"Sí","No")

' Weekday in the header (1 = Monday) and absences per weekday
=CHOOSE(WEEKDAY(B2,2),"L","M","X","J","V","S","D")
=SUMPRODUCT((Asistencia!$B$3:$U$3="V")*((Asistencia!$B$4:$U$23="A")+(Asistencia!$B$4:$U$23="J")))

' Streak: helper columns that add 1 while the absence continues and reset to 0 on presence
=IF(OR(cell="A",cell="J"),previous_streak+1,0)     ' and then =MAX of the row</code></pre>
<p>A regional-settings lesson that appears in this workbook: in a formula with a numeric criterion written as text, such as <code>COUNTIFS(range,"&lt;=0.95")</code>, the decimal point works in one regional setting and fails in another (in es-CO, "0.95" is read as text and does not match the number). The safe way is to concatenate the number: <code>"&lt;="&amp;0.95</code>, which Excel converts with the separator of the machine's regional setting (see <a href="/compatibilidad-libros-excel-entre-equipos-versiones-configuracion-regional/">Excel workbook compatibility between machines</a>).</p>

<h2>What the example showed (fictional data)</h2>
<p>With 20 students and 20 school days (400 records), the workbook calculated:</p>
<ul>
<li><strong>Group attendance: 94.5%</strong>, with 22 absences (12 unexcused and 10 excused). A figure that, alone, looks reassuring.</li>
<li><strong>Chronic absence: 5 of 20 students (25%).</strong> Behind it are very different stories: a student who misses <strong>every Monday</strong> (4 absences); another with <strong>five consecutive excused days</strong> (probably an illness: maximum streak of 5); another with <strong>three Fridays</strong>; another with two scattered absences; and another with two consecutive excused days.</li>
<li><strong>Weekday pattern:</strong> Friday (7 absences, 31.8%), Monday and Thursday (5 each, 22.7%), Wednesday (4) and Tuesday (1). <strong>Monday and Friday add up to 12 of 22 absences (54.5%)</strong>: a pattern that invites asking about transport, weekend work or disengagement.</li>
<li><strong>By week:</strong> 6, 9, 4 and 3 absences; the second week concentrates the five-day streak.</li>
<li><strong>On watch (a single absence):</strong> 6 students with between 5 and 9% absences.</li>
</ul>
<p>An important warning about these numbers: <strong>a four-week window is very short</strong>. With only 20 days, one absence is 5% and two absences are already 10% (the threshold); that is why 5 of 20 cross the line. In practice, chronic absence is measured over the whole year or long periods, and weekly analysis serves to <em>detect trends and streaks</em>, not to label. The workbook leaves the threshold editable so you can adapt it.</p>

<h2>Five steps when an absence repeats</h2>
{{img:apoyo}}
<ol>
<li><strong>Detect</strong> with the workbook, every week: do not wait for the end of the term.</li>
<li><strong>Understand</strong> before judging: ask for the reason. Usual causes include health, transport, work or caring for relatives, connectivity in rural areas, disengagement, learning difficulties or coexistence situations (see <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflict, indiscipline and school violence</a>).</li>
<li><strong>Contact the family</strong> respectfully, with a message that offers help and does not only warn of consequences.</li>
<li><strong>Support:</strong> schedule or transport adjustments, social support, coordination with school counseling, a catch-up plan, and for students with learning barriers, see <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusion in the classroom</a>.</li>
<li><strong>Follow up:</strong> return to the workbook in two weeks and see whether attendance improves. If there are signs of rights violations, activate the institutional route.</li>
</ol>
<p>There is a known trap: <strong>do not use attendance as punishment or reward</strong>. When data are used only to sanction, families learn to excuse absences however they can and the data lose value.</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, attendance is recorded at each school and enrollment is reported to the sector's systems; regulation leaves each institution to decide how to consider it for promotion, which explains the variety of rules across schools. In the region, absenteeism and dropout are associated with socioeconomic conditions, child labor, distances in rural areas and violence; worldwide, the literature on "chronic absence" has shown the usefulness of intervening early with early-warning systems and support rather than with sanctions. For <strong>teachers</strong>, the challenge is to record rigorously and without stigma; for <strong>principals</strong>, to review the SIEE and support routes, and to look at collective patterns (are there more absences on Mondays? in a certain grade?); for <strong>families</strong>, to communicate reasons in time; and for <strong>students</strong>, to feel expected at school. If the workbook grows (several groups, the whole year), ask whether Excel is still the tool (see <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">when Excel stops being the solution</a>).</p>

<h2>Templates and tools</h2>
<p>If you prefer to start from a ready-made attendance template, with support, look at these options. And to ask an AI for help with your formulas (always verifying the result and without pasting student data into free tools), there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">a dashboard that helps you act</a>, <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">averages in Excel: seven mistakes</a> and <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL! and #VALUE! errors</a>. For those preparing for the competition, see <a href="/herramientas/simulacro-concurso-docente/">the mock exam tool</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is chronic absence?</h3>
<p>Missing 10% or more of the school days a student is enrolled, for any reason (excused or not). It is a definition used in the literature and by several U.S. education authorities, not a Colombian rule.</p>
<h3>What absence percentage makes a student fail the year in Colombia?</h3>
<p>There is no fixed national percentage in force: Decree 1290 of 2009 (compiled in Decree 1075 of 2015) provides that each school defines in its SIEE the promotion criteria, including the attendance percentage. Check your institution's SIEE.</p>
<h3>How do I calculate attendance percentage in Excel?</h3>
<p>Days recorded minus absences, divided by days recorded: =(B5-E5)/B5. The workbook does it per student and for the group.</p>
<h3>How do I detect consecutive absences?</h3>
<p>With a helper row that adds 1 while the absence continues and resets to 0 on presence; the row's maximum is the streak. The workbook includes it.</p>
<h3>Does a window of a few weeks work for measuring chronic absence?</h3>
<p>With few weeks, a single absence weighs a lot. It serves to detect patterns and streaks; chronic absence is assessed over long periods or the whole year.</p>

<p class="notice"><strong>Look at this week's attendance.</strong> Download the <a href="/descargas/ausentismo-excel/ausentismo-escolar-excel.xlsx">absenteeism workbook</a> (in Spanish), replace the example codes with your group's and look first at the streaks and the weekdays with most absences.</p>

<h2>Food for thought</h2>
<p>A student who misses three Fridays in a row tells us something, even if we do not know what. <strong>What would your school do today if it discovered that half the absences fall on Mondays and Fridays: call families to complain or ask what makes it hard for them to arrive? And when a student stops coming, how long before anyone notices, and who is that someone?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:lecturas}}' => $img('ausentismo-excel-lecturas', 499, 'Table with four attendance indicators, what each says and what it hides: group attendance, chronic absence, streaks and weekday pattern.', 'What each indicator measures and what it hides.'),
    '{{img:apoyo}}' => $img('ausentismo-excel-apoyo', 467, 'Five steps when an absence repeats: detect, understand, contact the family, support and follow up.', 'From data to support.'),
]);

return [
    'ausentismo-escolar-excel-asistencia-ausentismo-cronico-rachas-patrones' => [
        'slug' => 'school-absenteeism-excel-attendance-chronic-absence-streaks-patterns',
        'title' => 'School Absenteeism in Excel: Attendance, Chronic Absence, Streaks and Weekday Patterns (Verified Workbook)',
        'excerpt' => 'How to analyze school attendance in Excel to detect chronic absence, streaks and weekday patterns in time, with a verified example workbook and steps to support the student and family.',
        'seo_title' => 'School Absenteeism in Excel: Attendance, Streaks',
        'seo_description' => 'Analyze school absenteeism in Excel: attendance, chronic absence (10%), streaks and weekday patterns, with a verified workbook and support steps.',
        'focus_keyword' => 'school absenteeism Excel',
        'cover' => '/assets/img/articulos/ausentismo-excel/ausentismo-excel-portada-en',
        'cover_alt' => 'Cover "School absenteeism in Excel: spotting patterns before it becomes dropout" with a card: 12 of 22 absences fall on a Monday or Friday in the example.',
        'content_html' => $html,
    ],
];
