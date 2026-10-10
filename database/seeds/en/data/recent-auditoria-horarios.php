<?php

declare(strict_types=1);

// English version of «Auditar el horario escolar en Excel: choques de docente, aula y grupo, carga y v…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/auditoria-horarios/' . $name . '-en';
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
<p>It is the first week of classes and the timetable already has problems: the math teacher appears in two classrooms at the same time, the lab is assigned to two groups, and one group has two subjects in the same slot. Nobody saw it when building it, because a school timetable is a table of hundreds of rows that changes every time a class is moved. <strong>Checking a school timetable by eye is the surest way to let a clash through.</strong></p>
<p>This article shows how to <strong>audit a school timetable in Excel</strong>: detect teacher, room and group clashes, measure each teacher's weekly workload against a limit and count the "gaps" in their day. It includes a <a href="/descargas/auditoria-horarios/auditoria-horario-escolar.xlsx">downloadable workbook</a> (in Spanish) with a fictional timetable of three groups and 91 classes, with results verified in Microsoft Excel 16 and against an independent Python calculation. Rules and data reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> The workbook <strong>audits</strong> a timetable already built; it does not generate or optimize it. The data are fictional. A timetable without clashes is not necessarily a good timetable: pedagogical, space, transport and labor-law considerations that each institution decides are missing. Regulatory references must be verified in their current version.</p>

<h2>Why auditing beats "reviewing"</h2>
<p>Building a timetable with no conflicts is a hard problem: in computer science, the general problem of constructing timetables under constraints belongs to a class (NP-complete) for which no fast methods guaranteeing the best solution are known, which is why specialized programs use heuristics. But <strong>verifying</strong> an already built timetable is a much easier problem: it is enough to count, for each day and slot, how many times each teacher, each room and each group appears. That counting is what Excel does well.</p>
{{img:controles}}

<h2>The workbook, sheet by sheet</h2>
<p>The <em>Horario</em> sheet has one row per class: day, slot (1 to 6), group, subject, teacher and room. Yellow cells are data; the rest are formulas. For each row, the workbook builds three keys by joining day, slot and resource, and counts how many times each key repeats:</p>
<pre><code>' Teacher key: day | slot | teacher
=IF(A2="","",A2&"|"&B2&"|"&E2)                  ' English
=SI(A2="";"";A2&"|"&B2&"|"&E2)                  ' Spanish

' Does the key repeat? If it appears more than once, the teacher is in two places
=IF(COUNTIF($G$2:$G$300,G2)>1,"Sí","")           ' English
=SI(CONTAR.SI($G$2:$G$300;G2)>1;"Sí";"")         ' Spanish

' To count each clash only once (not once per row):
=IF(J2="Sí",1/COUNTIF($G$2:$G$300,G2),0)         ' and then sum the column</code></pre>
<p>The trick in the last block deserves an explanation: if two rows clash, each is worth 1/2 and the sum gives 1 clash; if three rows clash, each is worth 1/3 and the sum still gives 1. That way the summary counts <strong>clashes</strong>, not rows. The same is done for the room and for the group.</p>
<p>The <em>Docentes</em> sheet counts each teacher's weekly hours (<code>COUNTIF</code>), compares them with an editable limit and calculates the excess. The <em>Ventanas</em> sheet calculates, per teacher and per day, the gaps between their first and last class:</p>
<pre><code>' Gaps of a teacher in a day = (last slot − first slot + 1) − number of classes
=MAXIFS(slots, teachers, teacher, days, day)
 - MINIFS(slots, teachers, teacher, days, day) + 1
 - COUNTIFS(teachers, teacher, days, day)</code></pre>
<p><code>MAXIFS</code> and <code>MINIFS</code> are in Excel 2019 and Microsoft 365; older versions require array formulas.</p>

<h2>What the audit found (fictional timetable)</h2>
<p>The example timetable has three secondary groups (7A, 7B and 8A), six slots per day and 30 weekly classes per group. It was generated without conflicts and then three were planted on purpose, plus an overload. The workbook found:</p>
<ul>
<li><strong>Teacher clash:</strong> on Monday in slot 2, teacher Ruiz appears in 7A (mathematics) and in 7B (social studies, which belongs to another teacher). A typing error assigning the wrong teacher.</li>
<li><strong>Room clash:</strong> on Wednesday in slot 3, the lab is assigned to 7B and 8A at the same time.</li>
<li><strong>Group clash:</strong> on Tuesday in slot 4, group 7A has two classes at once (social studies and technology).</li>
<li><strong>Workload:</strong> teacher Ruiz accumulates 26 weekly hours against a limit of 22, an excess of 4 hours (their 24 hours of mathematics, technology and ethics plus the two erroneous rows).</li>
<li><strong>Gaps:</strong> 29 gaps in the week across all teachers, between 0 (the religion teacher, with a single hour) and 6 per teacher.</li>
</ul>
<p>Summary result: 91 classes, 1 teacher clash, 1 room clash, 1 group clash, 6 rows marked "Conflicto" (two per clash), 1 teacher over the limit and 29 gaps. Everything matches the independent Python calculation.</p>
{{img:pasos}}

<h2>On the hours limit: what Decree 1850 of 2002 says</h2>
<p>The minimum weekly hours for students are 25 in primary and 30 in lower secondary and upper secondary (60-minute hours). For teachers, the academic assignment (time of direct attention to students) in preschool and primary equals the school day, and in secondary and upper secondary it is <strong>22 effective hours of 60 minutes per week</strong>. Those rules are in Decree 1850 of 2002, now compiled in Single Regulatory Decree 1075 of 2015. That is why the workbook carries the 22-hour limit as an editable value: adjust it to your institution's case and to the rules that apply to each teacher (for example, homeroom duties do not reduce the 22-hour assignment in secondary and upper secondary, per the same decree). The 30-hour "presence" figure is different and depends on each institution's regulation and organization.</p>

<h2>How to use the workbook with your timetable</h2>
<ol>
<li><strong>Export the timetable</strong> to a table with one row per class. If your timetabling program produces a matrix (groups by slots), turn it into a list; the workbook supports up to 299 rows, and can be extended by copying the formulas down.</li>
<li><strong>Paste the data</strong> in columns A to F of <em>Horario</em> (and replace the teacher list in <em>Docentes</em>).</li>
<li><strong>Read the summary:</strong> clashes first, then workload and gaps.</li>
<li><strong>Filter "Conflicto"</strong> in the status column and fix.</li>
<li><strong>Audit again</strong> after each change: moving a class often creates another clash.</li>
</ol>
<p>If the school already uses a database or a timetabling program that validates clashes, this audit serves as an independent second look, especially after last-minute changes. And if the timetable grows a lot, it is worth asking whether Excel is still the tool (see <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">when Excel stops being the solution</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, the timetable is built within the rules of weekly hours and academic assignment, with the complication that many institutions share campuses, shifts and teachers (schools with morning and afternoon shifts, rural campuses with traveling teachers). In the region, the organization of school time varies a lot: single shift, double shift, blended; worldwide, the timetable is one of the management decisions that most affects teachers and students, and its construction relies on specialized programs that still require verification. For <strong>principals</strong>, auditing the timetable before publishing avoids first-week chaos; for <strong>teachers</strong>, knowing that their workload and gaps are measured with a clear criterion reduces the sense of arbitrariness; for <strong>families</strong>, a timetable without clashes is a more predictable school; and for <strong>students</strong>, it avoids being left without a class or having two at once. A timetable is also a decision about how each person's time is valued: it is worth looking at who carries the most gaps and who the most consecutive hours.</p>

<h2>Templates and tools</h2>
<p>If you prefer to start from Excel templates with support, or need to organize staff attendance, look at these options. And to ask an AI for help with your formulas (always verifying the result and without pasting personal data), there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL! and #VALUE! errors</a>, <a href="/dashboard-excel-que-ayude-a-actuar-tablero-cartera-colegio-plantilla/">a dashboard that helps you act</a> and <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">averages in Excel: seven mistakes</a>. For those preparing for the competition, see <a href="/herramientas/simulacro-concurso-docente/">the mock exam tool</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Does the workbook build the timetable?</h3>
<p>No. It audits one already built: it detects clashes, workload and gaps. Building the timetable is a different and harder problem.</p>
<h3>How do I detect a teacher in two places at once?</h3>
<p>By joining day, slot and teacher into a key and counting how many times it repeats: if it appears more than once, there is a clash. The formula is COUNTIF.</p>
<h3>How many hours can a teacher have?</h3>
<p>Under Decree 1850 of 2002 (compiled in Decree 1075 of 2015), the academic assignment in secondary and upper secondary is 22 effective hours per week; in preschool and primary it equals the school day. Verify the current rule and your institution's case.</p>
<h3>What is a gap in a timetable?</h3>
<p>A free slot between a teacher's first and last class on the same day. Many gaps can be useful planning time, but also lost time or an uneven load.</p>
<h3>Does it work in older versions of Excel?</h3>
<p>Clashes and hours, yes. Gaps use MAXIFS and MINIFS, which require Excel 2019 or Microsoft 365.</p>

<p class="notice"><strong>Audit your timetable.</strong> Download the <a href="/descargas/auditoria-horarios/auditoria-horario-escolar.xlsx">audit workbook</a> (in Spanish), paste your timetable in the Horario sheet and look at the summary before publishing it.</p>

<h2>Food for thought</h2>
<p>A timetable without clashes can still be unfair: some teachers with useful gaps and others with their day split in three, some groups with the demanding subjects at the last hour. <strong>Who decides what a "good" timetable is at your school, and by what criteria: the administration's, the teachers' or the students' learning? And who finds out how the gaps were distributed?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:controles}}' => $img('auditoria-horarios-controles', 553, 'Table with five school timetable controls, the question for each and how it is detected: repeated teacher, repeated room, repeated group, teacher workload and gaps.', 'Five controls, five formulas.'),
    '{{img:pasos}}' => $img('auditoria-horarios-pasos', 467, 'Five steps to audit a timetable: organize, create keys, detect clashes, measure workload and fix.', 'From table to diagnosis in five steps.'),
]);

return [
    'auditar-horario-escolar-excel-conflictos-docentes-aulas-carga-ventanas' => [
        'slug' => 'audit-school-timetable-excel-teacher-room-clashes-workload-gaps',
        'title' => 'Auditing the School Timetable in Excel: Teacher, Room and Group Clashes, Workload and Gaps (Verified Workbook)',
        'excerpt' => 'An Excel workbook that audits an already built school timetable: it detects teachers in two places at once, repeated rooms and groups, measures workload against a limit and counts gaps, with a 91-class example.',
        'seo_title' => 'Audit the School Timetable in Excel: Clashes',
        'seo_description' => 'How to audit a school timetable in Excel: teacher, room and group clashes, weekly workload and gaps, with a verified example workbook.',
        'focus_keyword' => 'audit school timetable Excel',
        'cover' => '/assets/img/articulos/auditoria-horarios/auditoria-horarios-portada-en',
        'cover_alt' => 'Cover "Auditing the school timetable in Excel: clashes, workload and gaps" with a card: 3 clashes hidden in a timetable of 91 classes, teacher, room and group.',
        'content_html' => $html,
    ],
];
