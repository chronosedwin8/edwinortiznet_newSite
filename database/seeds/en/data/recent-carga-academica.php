<?php

declare(strict_types=1);

// English version of «Carga académica docente en Excel: quién excede, a quién le sobra espacio y qué h…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/carga-academica/' . $name . '-en';
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
<p>In January, the academic coordinator builds the assignment: math for this teacher, language for that one, until it "adds up". In March they discover two things. One teacher teaches 25 hours and is exhausted; another teaches 18 and has time to spare. And there is a class, 8B, without a math teacher since the first week. Nobody erred out of bad faith: <strong>the teaching load was built "by eye"</strong>, with no view that crosses, at once, how many hours each teacher has, how many they can have and what part of the curriculum is left uncovered.</p>
<p>This article proposes an <a href="/descargas/carga-academica/carga-academica-docente.xlsx">Excel workbook</a> (in Spanish) to review the teaching assignment with four indicators, with six fictional teachers and six groups, verified in Microsoft Excel 16 and against an independent calculation. Regulations reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional and the workbook is a review tool, not a decision tool: distributing load is the principal's decision, with pedagogical, training and hiring criteria, and must comply with regulation and your education secretariat's instructions. This template applies to the case of <strong>secondary and upper secondary in public (state) schools</strong>; in preschool and primary the rule is different (see below). This is not legal advice.</p>

<h2>What Colombian regulation says</h2>
<p>Decree 1850 of 2002 (later compiled into Decree 1075 of 2015) regulates the organization of the school day and the working day of teaching staff and principals in state schools of formal education. According to the text consulted on October 10, 2026 on the Public Function's Normative Manager:</p>
<ul>
<li><strong>Academic assignment (art. 5):</strong> the class time in which the teacher directly serves their students. In preschool and primary it is <strong>equal to the school day</strong> of the institution. In lower secondary and upper secondary it is <strong>22 effective weekly hours of 60 minutes</strong>, distributed by the principal in class periods.</li>
<li><strong>Homeroom (art. 6):</strong> all teachers and principals guide their students; in secondary and upper secondary, homeroom duty does not reduce the 22 hours.</li>
<li><strong>Distribution (art. 7):</strong> the principal sets each teacher's daily schedule, separating the academic assignment from complementary curricular activities.</li>
<li><strong>Working day (art. 11):</strong> a minimum dedication of 8 hours a day, of which at least 6 are spent at the school (academic assignment and complementary activities); the rest may be spent inside or outside the institution.</li>
</ul>
<p>There are nuances worth confirming with your secretariat: how hours are counted (60 effective minutes versus 45- or 50-minute periods), exceptions by position or education model, and the situation of private schools, governed by their contract and regulations. That is why the workbook leaves the cap as an <strong>editable parameter</strong>.</p>

{{img:indicadores}}
<h2>Four indicators to review the load</h2>
<ol>
<li><strong>Assigned hours:</strong> the sum of weekly hours of all the teacher's assignments.</li>
<li><strong>Difference from the cap:</strong> assigned hours minus the maximum. Positive, the teacher exceeds; very negative, there is room or they are underused.</li>
<li><strong>Preparations:</strong> how many distinct subjects they prepare. Teaching 22 hours of a single subject is not the same as 22 hours spread across four: each preparation adds work outside the classroom.</li>
<li><strong>Curriculum coverage:</strong> for each group and subject, the hours the curriculum requires minus the assigned hours. It is the most forgotten indicator.</li>
</ol>
<pre><code>' Assigned hours per teacher (Assignments sheet, columns A = teacher and D = hours)
=SUMIFS(Assignments!$D$2:$D$32,Assignments!$A$2:$A$32,A2)                  ' English
=SUMAR.SI.CONJUNTO(Asignaciones!$D$2:$D$32;Asignaciones!$A$2:$A$32;A2)    ' Spanish

' Distinct subjects prepared (counts each one once)
=SUMPRODUCT((Assignments!$A$2:$A$32=A2)/COUNTIFS(Assignments!$A$2:$A$32,Assignments!$A$2:$A$32,Assignments!$B$2:$B$32,Assignments!$B$2:$B$32))
=SUMAPRODUCTO((Asignaciones!$A$2:$A$32=A2)/CONTAR.SI.CONJUNTO(Asignaciones!$A$2:$A$32;Asignaciones!$A$2:$A$32;Asignaciones!$B$2:$B$32;Asignaciones!$B$2:$B$32))

' Uncovered hours for a group and subject (never negative)
=MAX(0,C2-D2)    ' English   ·   =MAX(0;C2-D2)    ' Spanish</code></pre>

<h2>What the example showed (fictional data)</h2>
{{img:carga}}
<p>Six teachers, six secondary groups (6A to 8B) and a curriculum of 25 hours per group (150 hours in total):</p>
<ul>
<li><strong>Assigned hours: 133.</strong> Loads of 25, 24, 22, 22, 22 and 18 hours. Two teachers exceed the 22-hour maximum (by 3 and 2 hours, 5 hours in total) and one is below the review threshold of 20.</li>
<li><strong>Uncovered hours: 17</strong>, in six group-subject combinations: 8B's math, natural sciences and arts, and technology for 7A, 7B and 8A.</li>
<li><strong>The paradox:</strong> there are excess hours and hours without a teacher at the same time. With a cap of 22, covering 150 hours takes at least 7 teachers (150 ÷ 22 = 6.8); with six, only 132 fit. Redistributing helps (the 18-hour teacher can absorb 4 hours and relieve one who exceeds), but <strong>it does not close the 17-hour gap: it takes hiring</strong> or reducing the curriculum.</li>
<li>Teacher 6 has the lowest load in hours, but <strong>teaches 287 students</strong> (the sum of each assignment's students), the highest of the six, because physical education and arts go through every group. Hours do not count the whole load: how many students must be assessed also matters.</li>
</ul>
<p><strong>An honest reading:</strong> the workbook knows nothing about training, experience, clashing schedules or positions with reduced load. A teacher with 22 hours may be better arranged than one with 20. It is for seeing the overall picture and asking the right questions, not for deciding. To also review schedule clashes and gaps, see the <a href="/auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas/">school timetable audit</a>.</p>

<h2>How to use the workbook</h2>
<ol>
<li><strong>Plan:</strong> enter the weekly hours per subject and group, according to your school's curriculum.</li>
<li><strong>Asignaciones:</strong> one row per teacher, subject and group, with hours and number of students.</li>
<li><strong>Parametros:</strong> the cap (22 in the example) and the threshold below which you review.</li>
<li><strong>Resultados and Cobertura:</strong> see who exceeds, who has room and which combinations have no teacher. The Resumen sheet gathers the counts.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Teacher workload is an education policy topic worldwide. The OECD's international teacher surveys (TALIS) consistently report that teaching hours and other tasks vary widely between countries, and that preparation, assessment and administration time adds to class hours. In Latin America, class time versus preparation time varies by country and sector (public or private), and in many systems non-teaching time is a union demand. In Colombia, the 22-class-hour cap is a reference maximum for the state sector in secondary and upper secondary, while in primary the teacher attends the whole group throughout the school day.</p>
<p>Each actor sees it differently. For <strong>teachers</strong>, load is hours, groups, preparations and grading. For <strong>principals</strong>, it is a hiring and budget constraint: see <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">budget executed, committed and available</a>. For <strong>families</strong>, it is the teacher who is missing or changes mid-year. And for <strong>students</strong>, it is the continuity of the class. A transparent, verifiable assignment keeps load from being decided by habit or closeness.</p>

<h2>Tools and templates</h2>
<p>If you work with the site's Excel templates and want support, or prepare material with AI (always reviewing what it produces and without including personal data of teachers or students in tools not designed to safeguard it), take a look at these products.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: the <a href="/descargas/carga-academica/carga-academica-docente.xlsx">teaching load workbook</a>, the <a href="/auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas/">timetable audit</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Frequently asked questions</h2>
<h3>How many class hours can a teacher teach in Colombia?</h3>
<p>In state schools of lower and upper secondary, the academic assignment is 22 effective weekly hours of 60 minutes (Decree 1850 of 2002, art. 5). In preschool and primary it equals the school day. Confirm the rules with your education secretariat.</p>
<h3>Does homeroom reduce the 22 hours?</h3>
<p>Not in secondary and upper secondary, according to art. 6 of the same decree.</p>
<h3>And in private schools?</h3>
<p>They are governed by the employment contract and regulations, not by the state sector's assignment. The workbook works just as well with another cap.</p>
<h3>Why count preparations?</h3>
<p>Because each distinct subject adds planning, materials and assessments; 22 hours of one subject are not the same as 22 spread across four.</p>
<h3>How do I change the cap in the workbook?</h3>
<p>In the Parametros sheet, cell B3; everything else recalculates.</p>

<p class="notice"><strong>Review your assignment before the year starts.</strong> Download the <a href="/descargas/carga-academica/carga-academica-docente.xlsx">teaching load workbook</a> (in Spanish), replace the fictional data with your school's and look at the uncovered hours first.</p>

<h2>Food for thought</h2>
<p>When load is distributed "as always", what is not on the spreadsheet is paid for with invisible time: the teacher who prepares four subjects and the class waiting for a teacher. <strong>What teacher time does not show up today in the assignment (preparing, assessing, meeting families, mentoring) and how would the distribution change if we counted it? And if hours are missing, which decision is fairer to students: overloading those already here, reducing the curriculum or hiring?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:indicadores}}' => $img('carga-academica-indicadores', 499, 'Table with four teaching load indicators, what each answers and how it is calculated: assigned hours, difference from the cap, preparations and curriculum coverage.', 'Four teaching load indicators.'),
    '{{img:carga}}' => $img('carga-academica-carga', 524, 'Bar chart of assigned hours for six fictional teachers: 25, 24, 22, 22, 22 and 18; the cap is 22.', 'Assigned hours per teacher: two over the cap and one below.'),
]);

return [
    'carga-academica-docente-excel-quien-excede-quien-sobra-que-falta' => [
        'slug' => 'teaching-load-excel-who-exceeds-who-has-room-what-is-missing',
        'title' => 'Teaching Load in Excel: Who Exceeds, Who Has Room and Which Hours Are Left Uncovered',
        'excerpt' => 'How to review the teaching assignment with four indicators (hours, difference from the cap, preparations and curriculum coverage), with the Colombian regulation and an Excel workbook verified with six fictional teachers.',
        'seo_title' => 'Teaching Load in Excel: Assignment and Coverage',
        'seo_description' => 'How to review teaching load in Excel: the 22-hour cap (Decree 1850), difference from the cap, preparations and uncovered hours, with a verified workbook.',
        'focus_keyword' => 'teaching load in Excel',
        'cover' => '/assets/img/articulos/carga-academica/carga-academica-portada-en',
        'cover_alt' => 'Cover "Teaching load in Excel: who exceeds, who has room and what is missing" with a card: 17 hours of the curriculum without a teacher, although 2 of 6 teachers exceed the 22-hour maximum.',
        'content_html' => $html,
    ],
];
