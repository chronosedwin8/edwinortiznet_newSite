<?php

declare(strict_types=1);

// English version of «Trabajo en grupo justo: cómo calificar sin premiar al que no aportó, con evaluac…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/trabajo-en-grupo/' . $name . '-en';
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
<p>Four students hand in a group assignment and receive the same grade: 4.2. Three of them spent two weeks coordinating, researching and writing. The fourth contributed one slide at eleven the night before. The grade is the same for all four, and the three who worked learned something that was not in the study plan: <strong>that in group work it is better to contribute little</strong>. It is one of the most frequent complaints from students and families, and one of the reasons many teachers stop assigning group work.</p>
<p>This article analyzes how to grade group work more fairly: what research says about why some members contribute less, what conditions make cooperative work function and how to use <strong>peer assessment with a bounded contribution factor</strong>. It includes an <a href="/descargas/trabajo-en-grupo/trabajo-en-grupo-justo.xlsx">Excel workbook</a> (in Spanish) with three fictional groups of four members, verified in Microsoft Excel 16 and against an independent calculation. Sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional. Peer assessment is an imperfect tool: it can be biased by friendship, popularity, shyness or fear of conflict, and the students are minors. The contribution factor is <strong>input for a conversation, not a verdict</strong>, and its use must be agreed with students beforehand and backed by your school's student assessment system (SIEE). This does not replace the teacher's professional judgment.</p>

<h2>Why it happens: social loafing</h2>
<p>The phenomenon has a name in psychology: <strong>social loafing</strong>. In a classic study, Latané, Williams and Harkins (1979, "Many hands make light the work") found that people made less effort when they believed their contribution was blended with others' (for example, when shouting or clapping in a group) than when they knew they were measured individually. A later meta-analysis (Karau and Williams, 1993) found the effect appears across many contexts and tasks, with variations: it diminishes when the task is attractive, when the group is small and cohesive and when individual contribution is identifiable. The opposite also happens: whoever works more may feel exploited and reduce their effort (sometimes called the "sucker effect"), or take on the whole load and resent it.</p>
<p>So there are two symmetric failures of group work graded with a single mark: <strong>it rewards the one who does not contribute and punishes the one who carries everything</strong>. And a third, less visible: it does not teach collaboration, but dividing tasks and pasting them together at the end.</p>

<h2>What conditions make cooperative work function</h2>
{{img:condiciones}}
<p>The literature on cooperative learning (Johnson and Johnson; Slavin) agrees on a practical result: working in groups improves learning when certain conditions are met, not when students are simply put together. The two most cited are <strong>positive interdependence</strong> (the group has a common goal and one member's success depends on the others') and <strong>individual accountability</strong> (each member answers for their part and what they contributed can be seen). In practice, this translates into four design decisions: a common goal, individual accountability with evidence, a visible process (logbook, partial deliveries) and a peer assessment. The reported effects vary with context, age and task, and are not automatic.</p>

<h2>Peer assessment with a contribution factor</h2>
<p>The idea, used by several peer assessment systems in higher education (for example, the WebPA method from Loughborough University), is simple: <strong>each member splits 100 points among all members of their group</strong> (including themself) according to contribution, with criteria agreed beforehand. From those splits a factor is calculated for each member: 1.0 means they contributed the same as the group average; below 1.0, less; above 1.0, more. The individual grade is the group product's grade multiplied by the factor.</p>
<pre><code>' Average points a member receives, NOT counting their own self-rating
=(SUMIFS(member_column, group, g) - own_self_rating) / (members - 1)                              ' English
=(SUMAR.SI.CONJUNTO(columna_del_integrante; grupo; g) - su_autoevaluación) / (integrantes - 1)   ' Spanish

' Contribution factor: 1.0 = equal to the group average (4 members, 100 points)
=average_points * 4 / 100

' Bounded factor (for example, between 0.8 and 1.2) and individual grade
=MIN(1.2, MAX(0.8, factor))
=MIN(5, MAX(1, group_grade * bounded_factor))</code></pre>
<p>Two design decisions matter a lot:</p>
<ul>
<li><strong>With or without self-assessment.</strong> People tend to rate themselves higher than others rate them. In the workbook, a member of group 2 gave themself 40 points; the others gave 25, 25 and 30. With self-assessment, their factor is 1.20; without it, 1.07. Excluding the self-rating from the calculation (but keeping it as reflection data) avoids that bias.</li>
<li><strong>Bounding the adjustment.</strong> An unbounded factor can produce extreme grades from a single round of peer ratings. Bounding it (for example, to a minimum of 0.8 and a maximum of 1.2) limits the effect and leaves large differences for the conversation with the teacher.</li>
</ul>

<h2>What the example showed (fictional data)</h2>
<p>Three groups of four, with product grades of 4.2, 3.8 and 4.6:</p>
<ul>
<li><strong>Group 3 (4.6):</strong> everyone gave each other 25 points. Factor 1.0 for all and an individual grade of 4.6 for all four. It may mean a genuinely balanced contribution or an agreement not to confront: peer assessment cannot tell; the teacher, with the logbook, can.</li>
<li><strong>Group 1 (4.2):</strong> one member receives fewer points on average (factor 0.87) and their individual grade drops to 3.64; another receives more (1.07) and rises to 4.48; the other two stay at 4.20.</li>
<li><strong>Group 2 (3.8):</strong> one member receives almost nothing: 5, 5 and 10 points from their peers. Their factor without self-assessment is 0.27: <strong>unbounded, their grade would be 1.01; with the bounded adjustment (minimum 0.8), it is 3.04</strong>. The other three rise: 4.31, 4.56 and 4.05.</li>
</ul>
<p>Workbook summary: 12 members, 1 with a factor below 0.8, none above 1.2, <strong>2 members whose grade drops by more than 0.3</strong> against the group's, and 1 of 3 groups with fully balanced contribution per peers. The lowest individual grade is 3.04 and the highest, 4.60.</p>
<p><strong>An honest reading:</strong> the bounded adjustment is a grading-policy decision, not a mathematical truth. A 3.04 for someone who barely contributed, against a group's 3.8, is a difference of 0.76; with an unbounded factor it would be 2.8. What the "fair" proportion is is a pedagogical decision that must be in the SIEE or the class agreement (see <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">the SIEE and Decree 1290</a>, in Spanish).</p>
{{img:pasos}}

<h2>Five steps to fairer group work</h2>
<ol>
<li><strong>Agree with the class, from the start,</strong> on what is graded and with what weight: the group product, the individual part, the process and peer assessment. A shared rubric (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a>) helps.</li>
<li><strong>Assign roles and rotate them:</strong> coordinator, researcher, writer, checker. Roles make visible who contributes what.</li>
<li><strong>Make the process visible:</strong> a logbook and partial deliveries with evidence of who did what. The grade should not depend only on the final product.</li>
<li><strong>Assess peers</strong> with 100 points per person and clear criteria, confidentially, and ask each member for a brief justification of any very unequal split.</li>
<li><strong>Talk before grading.</strong> If a member's factor is very low or very high, talk with the group and the person; there may be reasons (an illness, a conflict, a low-visibility role) that numbers do not show. And check whether the pattern repeats: a group with a marginalized member may need a coexistence intervention, not a grade.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, each school's SIEE defines the strategies for comprehensive assessment of performance and students' self-assessment processes (art. 2.3.3.3.3.4 of Decree 1075 of 2015); peer assessment may be part of those strategies, and it is worth checking what your school's SIEE says before using it to grade. In the region and worldwide, group work is among the most widespread and most criticized practices because of the single-grade problem, and there are peer assessment tools (some free) used mainly in higher education. For <strong>teachers</strong>, the challenge is to design the work so contributing is visible; for <strong>principals</strong>, to agree on common criteria among teachers so the student does not change rules every year (see <a href="/curriculo-oculto-entre-grados-reglas-que-cambian-cada-ano-mapa-expectativas/">the hidden curriculum between grades</a>); for <strong>families</strong>, to understand that the group grade and the individual one measure different things; and for <strong>students</strong>, that assessing a classmate honestly is a skill that can be learned. Mind privacy and climate: peer ratings are not shown publicly, and if they reveal a conflict, they are handled with the coexistence protocol (see <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflict, indiscipline and school violence</a>).</p>

<h2>Tools and templates</h2>
<p>To plan cooperative activities, rubrics and learning evidence, and to organize your resources with AI (always reviewing what it produces and without including student data in tools not designed to safeguard it), look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">averages in Excel: seven mistakes</a>, <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">grades: learning or compliance</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>. To adapt group work for students with learning barriers, <a href="/herramientas/piar/">PIAR with AI</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is social loafing?</h3>
<p>The tendency of some people to make less effort when working in a group and their individual contribution is not identifiable. It has been studied since the work of Latané, Williams and Harkins (1979).</p>
<h3>How do I prevent a member from not contributing?</h3>
<p>With a common goal and visible individual accountability: roles, logbook, partial deliveries and peer assessment, plus agreeing on criteria from the start.</p>
<h3>Is it fair to grade by peers?</h3>
<p>It can be a good source of information, but it has biases. It is best to use it as input, bound its effect and talk before grading.</p>
<h3>What does a contribution factor of 0.5 mean?</h3>
<p>That, according to their peers, the member contributed half of the group average. It is a datum to discuss, not a grade.</p>
<h3>How do I use the workbook?</h3>
<p>Enter the 100 points each member distributed, each group's product grade and the adjustment limits; the workbook calculates the factors and individual grades.</p>

<p class="notice"><strong>Try it in your next group assignment.</strong> Download the <a href="/descargas/trabajo-en-grupo/trabajo-en-grupo-justo.xlsx">fair group work workbook</a> (in Spanish), agree on criteria with your class, collect the 100-point splits and use the factors as a starting point for conversation.</p>

<h2>Food for thought</h2>
<p>Grading a group with a single mark is convenient for the teacher, but perhaps inconvenient for justice. <strong>What do we really value in group work: the product, each person's contribution or the ability to collaborate? And if we asked students to design with us the rules for splitting the grade, what rules would they propose and how carefully would they enforce them?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:condiciones}}' => $img('trabajo-en-grupo-condiciones', 499, 'Table with four conditions of fair group work, what each means and how it is achieved: common goal, individual accountability, visible process and peer assessment.', 'What makes group work fair.'),
    '{{img:pasos}}' => $img('trabajo-en-grupo-pasos', 467, 'Five steps before grading group work: agree, assign roles, follow the process, assess peers and talk.', 'Five steps to fairer group work.'),
]);

return [
    'trabajo-en-grupo-justo-calificar-evaluacion-entre-pares-factor-de-contribucion-libro' => [
        'slug' => 'fair-group-work-grading-peer-assessment-contribution-factor-workbook',
        'title' => 'Fair Group Work: How to Grade Without Rewarding Those Who Did Not Contribute, with Peer Assessment and an Excel Workbook',
        'excerpt' => 'Why some members contribute less in group work, what conditions make it work and how to grade with peer assessment and a bounded contribution factor, with a verified Excel workbook.',
        'seo_title' => 'Fair Group Work: Grading with Peer Assessment',
        'seo_description' => 'How to grade group work fairly: social loafing, interdependence and peer assessment with a contribution factor, with an Excel workbook.',
        'focus_keyword' => 'fair group work grading',
        'cover' => '/assets/img/articulos/trabajo-en-grupo/trabajo-en-grupo-portada-en',
        'cover_alt' => 'Cover "Fair group work: how to grade without rewarding the one who did not contribute" with a card: 1.01 and 3.04, unbounded and bounded-adjustment grade of the minimal contributor, in a 3.8 group.',
        'content_html' => $html,
    ],
];
