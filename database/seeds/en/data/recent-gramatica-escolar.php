<?php

declare(strict_types=1);

// English version of «¿Por qué la escuela sigue pareciéndose tanto a la que conocimos, si el mundo cam…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/gramatica-escolar/' . $name . '-en';
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
<p>Imagine someone fell asleep in 1996 and wakes up today. They would barely recognize the street: not the phones, not the money, not how to call a taxi or look up a fact. But if they walked into a school, they would know what to do: sit at a desk, wait for the bell, move from one subject to another every forty-five minutes, hand in homework, take exams and receive a grade. <strong>The world has changed completely; school, in its structure, hardly has.</strong> And that is one of education's most uncomfortable questions: why?</p>
<p>This article offers an answer based on history and research, not nostalgia or complaint. It explains the concept of the <strong>"grammar of schooling"</strong>, where its pieces come from (age grades, the class period, the calendar, subjects), why they are so hard to change, what <em>has</em> changed, what the law says in Colombia and how much real room there is. And it ends with the question that matters: <strong>what would you change?</strong> It includes an <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">Excel workbook</a> (in Spanish) to tabulate a survey of teachers, families and students (with fictional data for 60 people), verified in Microsoft Excel 16 and against an independent calculation. Sources reviewed on <strong>October 10, 2026</strong>.</p>
<p class="notice"><strong>Warning.</strong> The history of school is easily simplified and attractive stories circulate that do not survive scrutiny (see below). I distinguish what is documented from what is debated. The survey data in the workbook are fictional; they do not represent any school.</p>

<h2>The grammar of schooling</h2>
<p>In 1994, education historians David Tyack and William Tobin published "The 'Grammar' of Schooling: Why Has It Been So Hard to Change?" (<em>American Educational Research Journal</em>, 31(3), 453-479). Their idea: just as a language's grammar organizes sentences without our thinking about it, there are <strong>regular structures and rules that organize the work of teaching</strong> (in their words, standardized organizational practices for dividing time and space, classifying students and allocating them to classrooms, and splintering knowledge into "subjects"). They become so familiar that people take them for "real school", and any reform that alters them feels like "not a school". That is, according to the authors, a central reason why so many reforms stay on the surface: changes that do not touch the grammar are absorbed; those that do clash with what the community understands by school.</p>
{{img:gramatica}}
<h2>Where the pieces come from</h2>
<ul>
<li><strong>Age grades.</strong> In colonial American schools it was common to teach students of different ages together in one room with one teacher. Grade organization spread in the mid-19th century, with reformers like Horace Mann, who visited Prussia in 1843 and admired its school organization. It is a historical invention with a date, not a law of nature.</li>
<li><strong>The hour as a measure: the Carnegie unit.</strong> In 1906, the Carnegie Foundation for the Advancement of Teaching defined a "unit" of 120 class hours (one hour a day, five days a week, for 24 weeks) to decide which institutions could join its pension system for professors. Its 1906 report stated explicitly that the fundamental criterion was <strong>the time spent on a subject, not the results attained</strong>. By 1910, nearly all US colleges and high schools used that measure, and the university "credit" came from it. Today its own foundation debates retiring it.</li>
<li><strong>The calendar.</strong> Historian Kenneth Gold showed that the common explanation (long vacations would be a leftover from the agrarian world) is incomplete: rural schools had two short terms, and urban ones long calendars (in some cases over 240 days); the roughly 180-day calendar with summer vacation was a <strong>conscious creation</strong> by reformers in the late 19th and early 20th centuries, motivated in part by health and heat in cities.</li>
<li><strong>Subjects.</strong> The curriculum divided into subjects comes from the university tradition and the 19th century, and was consolidated with timetable organization.</li>
</ul>
<p><strong>A warning about a myth.</strong> It is often repeated that school is "a Prussian factory model" designed to produce obedient workers. Those who review the history warn that this story is largely a later invention: the "factory model" label became popular in the last decades of the 20th century, there were free public schools before Mann's reforms, and Mann himself knew of and answered the criticisms that the Prussian model bred blind obedience. The deeper lesson is more sober: <strong>school's pieces are historical decisions with reasons of their time</strong> (organizing many children, measuring, financing), not destiny. And that means they can be decided differently.</p>

<h2>Why are they so hard to change?</h2>
<ul>
<li><strong>Everything is intertwined.</strong> The class period holds up the teacher's timetable, which holds up hiring, teaching assignments and transport; grades hold up promotion, the assessment system and enrollment; marks hold up reports to families. Moving one piece forces the others to move.</li>
<li><strong>It is what everyone knows.</strong> Teachers, families and students were formed in that grammar, and a different school can feel like a loss of rigor.</li>
<li><strong>Additions adapt to what exists.</strong> Historian Larry Cuban documented in <em>Oversold and Underused</em> (2001) that computers reached classrooms but were largely used to do what was already done: technology changed the surface, not the grammar. It is a useful warning for AI (see <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">the guide to using AI in education</a>, in Spanish).</li>
<li><strong>Law and accountability also reproduce it.</strong> In Colombia, for example, the regulation speaks of weeks, hours, areas and performance levels (see below).</li>
</ul>

<h2>What has changed (and what has not)</h2>
<p>It would be unfair to say nothing changed: there are better books, the internet, formative assessment, inclusion of students with disabilities (see <a href="/concurso-docente-decreto-1421-de-2017-piar-ajustes-razonables-educacion-inclusiva/">Decree 1421 and the PIAR</a>, in Spanish, which requires adjusting teaching to the student and not the other way around), more coverage, more knowledge about how people learn. What has changed little is the <strong>structure</strong>: who goes with whom, for how long, with whom, divided into which parts and measured how. Research on learning (see <a href="/aprender-a-aprender-calibracion-tecnicas-de-estudio-repaso-espaciado-libro-excel/">learning to learn</a>) points to other things: spaced practice, feedback, time to explain, not always compatible with fixed forty-five-minute periods.</p>

<h2>What the law says in Colombia, and how much room there is</h2>
<p>The structure appears in the regulation, but there is also room to change:</p>
<ul>
<li><strong>Time:</strong> Decree 1850 of 2002 (compiled into Decree 1075 of 2015) sets 40 school weeks and a minimum weekly intensity (25 hours in primary, 30 in secondary and upper secondary, according to the text consulted), and teaching assignments of 22 effective weekly hours for secondary and upper secondary teachers (see <a href="/carga-academica-docente-excel-quien-excede-quien-sobra-que-falta/">teaching load in Excel</a>).</li>
<li><strong>Areas:</strong> Law 115 of 1994 (art. 23) defines mandatory, fundamental areas (nine), though it recognizes <strong>school autonomy</strong> to organize them, and the Institutional Educational Project can define how they are taught (see <a href="/concurso-docente-ley-115-decreto-1860-pei-curriculo-gobierno-escolar/">Law 115 and Decree 1860</a>).</li>
<li><strong>Assessment:</strong> each school defines its Student Assessment System within the national scale (see <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">the SIEE and Decree 1290</a>), with room for criteria, strategies and rubrics.</li>
<li><strong>Own experiences:</strong> Colombia has a tradition of flexible models, such as Escuela Nueva, a multigrade classroom model that emerged in rural areas in the 1970s, which shows that it is possible to organize differently <em>within</em> the law.</li>
<li><strong>New content:</strong> Law 2626 of 2026 adds AI, programming and data science to technology and informatics, and requires updating guidelines every three years. It is an example of how change arrives through <em>content</em> (what is taught) before <em>structure</em> (how it is organized).</li>
</ul>
<p>The practical conclusion is that <strong>there is more room than is used</strong>, but every structural change requires doing the math on timetables, hiring and assessment.</p>

<h2>What would you change? A survey to start the conversation</h2>
<p>Before proposing changes, it is worth knowing what the three communities think. The <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">Excel workbook</a> tabulates a simple survey: for ten school features (age groups, class periods, separate subjects, one teacher for 30 or more students, numerical grades, written exams, calendar, desks in rows, early start and homework) each person answers whether they would <strong>keep, adjust or change</strong> it. The <em>Datos</em> sheet stores the counts by feature and group, and the <em>Rasgos</em> sheet calculates the percentage who would change each one, by group and overall, the gap between groups and whether there is <strong>consensus</strong> (all three groups above an editable threshold).</p>
{{img:encuesta}}
<pre><code>' Percentage who would change a feature (column E = change, F = total responses)
=SUMIFS(Datos!$E$2:$E$31,Datos!$A$2:$A$31,A2)/SUMIFS(Datos!$F$2:$F$31,Datos!$A$2:$A$31,A2)                           ' English
=SUMAR.SI.CONJUNTO(Datos!$E$2:$E$31;Datos!$A$2:$A$31;A2)/SUMAR.SI.CONJUNTO(Datos!$F$2:$F$31;Datos!$A$2:$A$31;A2)     ' Spanish

' Gap between groups (in percentage points)
=MAX(D2:F2)-MIN(D2:F2)

' Consensus: all three groups would change the feature above the threshold (Parametros!B3)
=IF(MIN(D2:F2)>=Parametros!$B$3,"Sí","No")                                                                           ' English
=SI(MIN(D2:F2)>=Parametros!$B$3;"Sí";"No")                                                                          ' Spanish</code></pre>
<p>Results of the <strong>fictional</strong> survey (20 teachers, 20 families and 20 students): the features most people would change are <strong>"one teacher for 30 or more students" and "very early start" (52% each)</strong>, and they are the only two with consensus across all three groups (at a 30% threshold); the least, age groups and the calendar (12%). There are <strong>3 features with a gap</strong> between groups: numerical grades, desks in rows and, above all, <strong>homework</strong>, which 65% of students and 10% of families would change (a 55-point difference). More than half of the people would change only 2 of the 10 features: <strong>structural change rarely has overwhelming majorities</strong>, which is why it is best to start where there is consensus.</p>
<p><strong>An honest reading:</strong> it is a fictional survey of 60 people, without sampling or margin of error; in a real school, the differences may be others. Asking "what would you change?" also has a bias: people point at what hurts today. Use it as a conversation instrument, not a decision instrument.</p>

<h2>How to change one thing at a time</h2>
<ol>
<li><strong>Choose a single feature</strong> with shared desire for change (in the example, group size or start time) and not ten at once.</li>
<li><strong>Check the legal room:</strong> is it set by national regulation, the secretariat or the institutional project and coexistence manual?</li>
<li><strong>Define a small, reversible test:</strong> one grade, one term, one area.</li>
<li><strong>Decide beforehand how you will measure whether it worked</strong> (attendance, learning, coexistence, perception) and against what baseline.</li>
<li><strong>Communicate it to families</strong> and listen to students; changes that are not explained are rejected.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>The persistence of the grammar of schooling is not Colombian: it was described by US historians and is observed, with variants, in almost all systems. Some countries have moved more: Finland, for example, incorporated multidisciplinary learning modules into its 2016 curriculum (see <a href="/finlandia-sistema-educativo-mito-o-realidad/">Finland: myth or reality?</a> and <a href="/mejores-sistemas-educativos-del-mundo-colombia/">the world's best education systems and what Colombia lacks</a>, in Spanish), but most keep grades, hours and subjects. In Latin America, pressure for coverage, school days and external results tends to reinforce the structure; Colombia has, at once, its own flexible experiences and very detailed regulation.</p>
<p>For <strong>teachers</strong>, the challenge is having time and support to experiment; for <strong>principals</strong>, doing the math on timetables, hiring and the assessment system; for <strong>families</strong>, understanding that "stricter" is not always "better"; and for <strong>students</strong>, that their experience is a valid source of information about how school works.</p>

<h2>Tools and templates</h2>
<p>If you want to support this kind of experiment with classroom material, planning and assessment (with AI as an assistant, always reviewing what it produces and without including student data in tools not designed to safeguard it), take a look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">the survey workbook</a>, <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">the guide to using AI in education</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Sources consulted (October 10, 2026)</h2>
<ul>
<li><strong>Tyack and Tobin (1994),</strong> "The 'Grammar' of Schooling: Why Has It Been So Hard to Change?", <em>American Educational Research Journal</em> 31(3), 453-479; <strong>Tyack and Cuban (1995),</strong> <em>Tinkering Toward Utopia</em>; <strong>Cuban (2001),</strong> <em>Oversold and Underused: Computers in the Classroom</em>.</li>
<li><strong>Carnegie Foundation for the Advancement of Teaching,</strong> <a href="https://www.carnegiefoundation.org/what-is-the-carnegie-unit/">"What is the Carnegie Unit?"</a>; New America, <a href="https://www.newamerica.org/insights/the-curious-birth-of-the-credit-hour/">"The Curious Birth of the Credit Hour"</a> (the 1906 report and the time criterion).</li>
<li><strong>Gold (2002),</strong> <em>School's In: The History of Summer Education in American Public Schools</em> (Peter Lang), and coverage by <a href="https://www.educationnext.org/news-summer-vacation-took-hold-u-s/">Education Next</a> and <a href="https://www.pbs.org/newshour/updates/debunking-myth-summer-vacation">PBS NewsHour</a>; on the "factory model" story: <a href="http://hackeducation.com/2015/04/25/factory-model">The Invented History of "The Factory Model of Education"</a> (Audrey Watters's blog; argument, not settled history).</li>
<li><strong>Colombian regulations:</strong> Decree 1850 of 2002 (Public Function's Normative Manager), Law 115 of 1994, Decree 1290 of 2009 and Law 2626 of 2026, in the versions cited in earlier articles on this site.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What is the "grammar of schooling"?</h3>
<p>The set of regular structures and rules (age grades, class hours, subjects, calendar) that organize teaching and that seem like "real school". Tyack and Tobin proposed it in 1994.</p>
<h3>Is it true that school is a Prussian factory model?</h3>
<p>It is a much-repeated story and largely disputed by historians: the label is later and the history is more complex. What is solid is that today's structures are historical decisions, not natural ones.</p>
<h3>Why are there long vacations?</h3>
<p>They are not a mere leftover of farm work; according to Gold, the roughly 180-day calendar was a deliberate creation by reformers between the late 19th and early 20th centuries.</p>
<h3>Can school structure be changed within Colombian law?</h3>
<p>In part: there are rules on time and areas, but also school autonomy, the institutional project, the assessment system and flexible models like Escuela Nueva. It is best to check the room with the education secretariat.</p>
<h3>How do I use the workbook?</h3>
<p>Enter your survey's counts (keep, adjust and change) per feature and group; the workbook calculates percentages, gaps and consensus.</p>

<p class="notice"><strong>Run the survey at your school.</strong> Download the <a href="/descargas/gramatica-escolar/encuesta-gramatica-escolar-que-cambiarias.xlsx">survey workbook</a> (in Spanish), apply it to teachers, families and students, replace the fictional data and start with the feature where there is consensus.</p>

<h2>Food for thought</h2>
<p>Every piece of school was, at some moment, the reasonable answer to a problem of its time. <strong>What problem does each piece that seems natural at your school solve today? And, if you could change just one thing about school today, which would it be, what would students gain from that change and what would you have to take care of so as not to lose what school does well?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:gramatica}}' => $img('gramatica-escolar-gramatica', 499, 'Table with four features of the grammar of schooling, their approximate origin and what each measures: age grades, Carnegie unit, separate subjects and periods and calendar.', 'Structures that seem natural and are not.'),
    '{{img:encuesta}}' => $img('gramatica-escolar-encuesta', 700, 'Bar chart of the percentage of 60 people in a fictional survey who would change each school feature: one teacher for 30 or more 52, very early start 52, desks 37, grades 35 and others down to 12.', 'Fictional survey: what each group would change.'),
]);

return [
    'por-que-la-escuela-se-parece-a-la-que-conocimos-gramatica-escolar-que-cambiarias' => [
        'slug' => 'why-school-looks-like-the-one-we-knew-grammar-of-schooling-what-would-you-change',
        'title' => 'Why Does School Still Look So Much Like the One We Knew, If the World Has Changed Completely? And What Would You Change?',
        'excerpt' => 'The "grammar of schooling": where age grades, the class hour and the calendar come from, why they are hard to change, what room the law gives in Colombia and an Excel survey to decide what to change first.',
        'seo_title' => 'Why School Still Looks the Same: Grammar of Schooling',
        'seo_description' => 'Why school looks so much like the one we knew: the grammar of schooling, the Carnegie unit, Colombian law\'s room for change and an Excel survey.',
        'focus_keyword' => 'grammar of schooling',
        'cover' => '/assets/img/articulos/gramatica-escolar/gramatica-escolar-portada-en',
        'cover_alt' => 'Cover "Why does school look so much like the one we knew? And what would you change?" with a card: 120 hours is the 1906 Carnegie unit, which counted classroom time, not what was learned.',
        'content_html' => $html,
    ],
];
