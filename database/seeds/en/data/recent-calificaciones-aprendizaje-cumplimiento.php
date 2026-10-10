<?php

declare(strict_types=1);

// English version of "¿Las calificaciones miden lo que aprende un estudiante o su capacidad para cumplir con las reglas del colegio?". Key is the
// Spanish slug. Checked on October 9, 2026. The Valentina and Mateo case is hypothetical. Status and date come from the Spanish post via
// en/02_recent_posts.php (scheduled for Wednesday, October 21, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/calificaciones-aprendizaje-cumplimiento/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>Picture the report cards of two ninth graders. Both have a 4.2 in math, a "High" performance. Yet if you ask them to solve a new problem without help, one does it and explains why, and the other does not know where to start. <strong>What exactly did that grade measure?</strong> It is an uncomfortable question, because most of us, teachers, students and families, have treated the grade as if it were an exact measure of learning.</p>
<p>In this article I analyze that hypothetical case, review what research and regulation say in Colombia, Latin America and the world, and give you a <strong>matrix to review assessment criteria</strong> in your classroom or school. Data and rules checked on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A review of a century of studies concludes that grades blend cognitive and non-cognitive factors: what the student learned and what the teacher values in their work (punctuality, neatness, attitude). It is not bad that both exist, but when they are fused into one number, the report card no longer says which is which. The way out is not to abolish grades but to separate achievement and compliance and review the criteria.</p>

<h2>A hypothetical case: two students, the same grade</h2>
<p>Suppose a school with this fairly common assessment system: homework and notebook 30%, attitude and punctuality 20%, classwork 20% and written exam or oral defense 30%. Two students end the term like this:</p>
{{img:caso}}
<table>
<thead><tr><th>Component (weight)</th><th>Valentina</th><th>Mateo</th></tr></thead>
<tbody>
<tr><td>Homework and notebook (30%)</td><td>5.0</td><td>3.5</td></tr>
<tr><td>Attitude and punctuality (20%)</td><td>5.0</td><td>4.0</td></tr>
<tr><td>Classwork (20%)</td><td>4.5</td><td>4.3</td></tr>
<tr><td>Exam (30%)</td><td>2.9</td><td>5.0</td></tr>
<tr><td><strong>Final grade</strong></td><td><strong>4.27</strong></td><td><strong>4.21</strong></td></tr>
</tbody>
</table>
<p>Valentina complies with everything: she hands in on time, keeps an impeccable notebook and participates. But on the exam, the only evidence of what she knows unaided, she gets 2.9, a low performance. Mateo hands in late, his notebook is a mess and he sometimes loses points for attitude, but on the exam he gets 5.0 and explains his reasoning. On the report card both are "High" and Valentina even has a tenth more. If we count only the evidence of learning (classwork and exam, reweighted to 100%), the "achievement grade" would be 3.54 for Valentina and 4.72 for Mateo.</p>
<p>The point is not to say Valentina "cheated" or that Mateo is a better person. It is to see that <strong>a single grade is telling two different stories</strong>, and that when they are mixed, whoever reads the report card (a parent, a principal, another school) cannot tell which is which. And there is a pedagogical decision underneath: how much of the grade should reward compliance with rules?</p>

<h2>What the research says</h2>
<p>The broadest review I know is <a href="https://doi.org/10.3102/0034654316672069">Brookhart and colleagues (2016), "A Century of Grading Research"</a>, in <em>Review of Educational Research</em>. After analyzing more than a hundred years of studies, they conclude that grades are a "multidimensional" measure: they partly measure what the student achieved on tests, but also reflect non-cognitive factors the teacher values (effort, behavior, participation). In other words, the Valentina and Mateo case is not an oddity: it is the rule.</p>
<p>That result has a nuance worth keeping in mind: "non-cognitive" factors are not junk. A <a href="https://consortium.uchicago.edu/news-item/high-school-GPAs-and-ACT-scores-as-predictors-of-college-completion">study by Allensworth and Clark (2020)</a> of 55,084 graduates of Chicago public schools found that high school grade point average predicts college graduation far better than the ACT exam, and that the ACT's value changed from school to school while grades' value stayed stable. A plausible explanation is that grades capture work habits and persistence that matter for finishing a degree. So the problem is not that grades include habits; it is that <strong>we do not know how much of each thing is in each grade</strong>, and therefore cannot use it well to decide.</p>
{{img:evidencia}}

<h2>What regulation says: Colombia, Chile and the world</h2>
<p><strong>In Colombia</strong>, <a href="https://normograma.icfes.gov.co/docs/pdf/decreto_1290_2009.pdf">Decree 1290 of 2009</a> (compiled in Decree 1075 of 2015) gives each school autonomy to design its <strong>Institutional Student Assessment System (SIEE)</strong> with the participation of the school community: assessment and promotion criteria, and its own scale that must express its equivalence with the four-level national scale (Superior, High, Basic and Low). That autonomy is an opportunity: <strong>the criteria we are discussing are the school's decision</strong>, and they can be reviewed with the community.</p>
<p><strong>In Latin America</strong>, Chile offers a useful contrast. Its Decree 67 of 2018 recognizes two uses of assessment (formative, to support learning, and summative, to certify it), requires each school to have an assessment regulation and proposes that repeating a grade be an exceptional decision supported by pedagogical and psychosocial criteria. Available studies on its application show uneven implementation: a 2023 study in five Antofagasta schools found a devaluation of formative assessment and few defined criteria. No change of decree replaces the conversation at each school.</p>
<p><strong>Worldwide</strong>, the discussion is known as <em>standards-based grading</em>: reporting separately the achievement level for each competency and work habits, instead of averaging them. It is the direction the authors of the cited review point to, although evidence on its effect on learning is still limited.</p>

<h2>Compliance, deep learning and competencies: three different things</h2>
<ul>
<li><strong>Compliance:</strong> handing in on time, keeping the notebook, following instructions. It is valuable and can be learned, but it does not prove understanding.</li>
<li><strong>Deep learning:</strong> understanding and being able to explain, applying to a new case, spotting errors. It shows when the student solves unaided or justifies an answer.</li>
<li><strong>Competencies:</strong> combining knowledge, skills and attitudes to solve real situations (for example, communicating a result or working in a team). They require evidence of performance, not just of submission.</li>
</ul>
<p>When the grade averages all three, it punishes Mateo for what he does not comply with and rewards Valentina for what she did not learn. <strong>Teachers</strong> know it: rewarding compliance keeps the classroom orderly and removing it is unrealistic. <strong>Families</strong> usually ask for transparency: they want to know whether their child "is doing badly" for not understanding or for not handing in. And <strong>students</strong> soon learn what is rewarded and adapt: if the notebook counts more than explaining, they take care of the notebook.</p>

<h2>A matrix to review your assessment criteria</h2>
<p>This is the practical resource. Use it with your department team or academic council to review your classroom or your SIEE:</p>
<table>
<thead><tr><th>Criterion</th><th>Question to review it</th><th>Warning sign</th><th>Possible adjustment</th></tr></thead>
<tbody>
<tr><td><strong>Separate achievement and habits</strong></td><td>Does the report card show separately what was learned and how the student works?</td><td>A single grade blends punctuality, neatness and knowledge.</td><td>Report two ratings: performance and work habits.</td></tr>
<tr><td><strong>Weight of compliance</strong></td><td>How much of the grade depends on handing in, not on knowing?</td><td>More than 40-50% of the grade is compliance.</td><td>Reduce the weight; keep compliance as feedback.</td></tr>
<tr><td><strong>Evidence without support</strong></td><td>Is there evidence of what the student does unaided?</td><td>All grades are homework.</td><td>Include an oral defense, a new problem or a transfer assessment.</td></tr>
<tr><td><strong>Late penalties</strong></td><td>Does handing in late lower the knowledge grade?</td><td>An excellent piece of work gets 2.0 for being a day late.</td><td>Deduct only in the habits rating, not in achievement.</td></tr>
<tr><td><strong>New opportunities</strong></td><td>Can the student later show they learned?</td><td>One bad day defines the whole grade.</td><td>Allow reassessment with an improvement plan.</td></tr>
<tr><td><strong>Clarity of criteria</strong></td><td>Does the student know beforehand what is valued and how?</td><td>Implicit or shifting criteria.</td><td>A shared rubric with examples.</td></tr>
<tr><td><strong>Consistency with the national scale</strong></td><td>What does "High" mean in our SIEE?</td><td>A "High" can be with or without understanding.</td><td>Describe each level by what the student knows and can do.</td></tr>
<tr><td><strong>Community participation</strong></td><td>Have teachers, students and families reviewed the SIEE in the last year?</td><td>Nobody remembers when it was updated.</td><td>Schedule a review using real report-card evidence.</td></tr>
</tbody>
</table>
<p>To compute both grades in an Excel sheet (for example, with weights in B1:E1 and each student's grades in B2:E2), <code>=SUMPRODUCT(B2:E2,$B$1:$E$1)</code> gives the final grade, and <code>=SUMPRODUCT(D2:E2,$D$1:$E$1)/SUM($D$1:$E$1)</code> gives the achievement grade (classwork and exam only). The difference between them is a signal: if it is large, the final grade is saying something different from learning.</p>

<h2>Tools to assess better</h2>
<p>If you want evidence of what the student knows unaided, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> creates different versions of the same problem in minutes, with solutions, ideal for transfer assessments (the <a href="/examenes/demo/">demo is free</a>). To record attendance and punctuality in a place separate from achievement grades, the <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">Work or academic attendance list in Excel</a> tracks compliance without mixing it with learning. And the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a> offers recipes by subject to design activities and performance rubrics.</p>
{{productos:generador-de-examenes-ia-esencial,listado-de-asistencia-laboral-o-academica-en-excel}}
<p>Keep reading: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">Is AI expanding a student's thinking or replacing it?</a> (with an autonomy and reasoning rubric) and <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">the AI mirage at university</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Should compliance be removed from the grade?</h3>
<p>Not necessarily. Work habits matter and can be taught. The recommended approach is to value them but report performance (what was learned) and habits separately, so the report card can be interpreted.</p>
<h3>What is the SIEE and who defines it?</h3>
<p>It is the Institutional Student Assessment System: each school's set of assessment and promotion criteria, scale and rules, which under Decree 1290 of 2009 (compiled in 1075 of 2015) is designed with the participation of the school community.</p>
<h3>Do grades predict success at university?</h3>
<p>According to a Chicago study, grade point average predicted college graduation better than the ACT exam. That does not mean they measure only knowledge: they also capture work habits and persistence.</p>
<h3>How do I know whether my child really understood?</h3>
<p>Ask them to explain the procedure in their own words and solve a similar exercise without help. If they can, they understood; if they only repeat, the grade does not tell the whole story.</p>
<h3>How can I propose changes to my school's SIEE?</h3>
<p>Through the academic council, the governing board or the parent and student representatives. Come with evidence: anonymized report cards showing equal final grades with different performances.</p>

<p class="notice"><strong>Review your criteria this week.</strong> Apply the matrix to your classroom, compute the final grade and the achievement grade of three students and see how far apart they are. If you need transfer evidence, try the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>; and if you keep your course records in Excel, the <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">attendance list</a> saves you hours.</p>

<h2>Food for thought</h2>
<p>If a student learns a great deal but has trouble handing in on time, and another complies with everything but learns little, <strong>which one do we want to reward with the highest grade: the one who knows, the one who complies or the one who combines both?</strong> And who should decide: the teacher, the school, families or the students themselves? Because each answer shapes a different kind of adult.</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:caso}}' => $img('calificaciones-aprendizaje-cumplimiento-caso', 625, 'Hypothetical comparison of two students: Valentina complies with everything but gets 2.9 on the exam and a 4.27 final grade; Mateo hands in late but gets 5.0 on the exam and a 4.21 final grade.', 'Hypothetical case: same grade, different learning.'),
    '{{img:evidencia}}' => $img('calificaciones-aprendizaje-cumplimiento-evidencia', 573, 'Four cards: grades are multidimensional (Brookhart et al., 2016), grade point average predicted college graduation better than the ACT among 55,084 Chicago graduates, Colombia\'s national scale has four levels and Chile\'s Decree 67 recognizes formative and summative assessment.', 'What research and regulation say. Sources: Brookhart et al. (2016), Allensworth and Clark (2020), Colombia Decree 1075 of 2015 and Chile Decree 67 of 2018.'),
]);

return [
    'calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio' => [
        'slug' => 'do-grades-measure-learning-or-rule-compliance',
        'title' => 'Do Grades Measure What a Student Learns or Their Ability to Follow School Rules?',
        'excerpt' => 'A hypothetical case of two students with the same grade and different learning, what research and rules say in Colombia, Chile and the world, and a matrix to review assessment criteria.',
        'seo_title' => 'Do Grades Measure Learning or Compliance?',
        'seo_description' => 'What grades really measure: compliance, learning or competencies. A hypothetical case, evidence, rules and a matrix to review your assessment criteria.',
        'focus_keyword' => 'grades and learning',
        'cover' => '/assets/img/articulos/calificaciones-aprendizaje-cumplimiento/calificaciones-aprendizaje-cumplimiento-portada-en',
        'cover_alt' => 'Cover reading "Do grades measure what you learn or how well you follow the rules?" with a card comparing two almost identical grades, 4.27 and 4.21, from two students with very different learning.',
        'content_html' => $html,
    ],
];
