<?php

declare(strict_types=1);

// English version of «La IA también obliga al docente a volver a aprender: ¿qué aprender, es un reto o…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/docente-aprender-ia/' . $name . '-en';
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
<p>For years, technology reached the classroom as a tool teachers could adopt or ignore. With generative AI something changed: <strong>students already use it, families ask about it, the law brings it into the curriculum and teachers are being asked to understand it</strong>. Four uncomfortable questions follow, and this article takes them head on: <strong>what must be learned? Do teachers really want to upskill? Is it a challenge or extra work? Is it still worth being a teacher in the age of AI?</strong></p>
<p>I answer with data from Colombia (the OECD's TALIS 2024 survey, also analyzed by Icfes), international evidence and an <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">Excel workbook</a> (in Spanish) that calculates, with your own assumptions, whether the time you invest in learning pays back (verified in Microsoft Excel 16 and against an independent calculation). At the end there is a <a href="#encuesta">five-question poll</a> to learn what you think. Sources reviewed on <strong>October 12, 2026</strong>.</p>
<p class="notice"><strong>Warning.</strong> TALIS results are self-reports from lower secondary teachers and do not speak for the whole system. The workbook's time-saving assumptions are <strong>mine</strong>, not published data: replace them with yours. The poll is open and anonymous, and reflects only those who answer.</p>

<h2>What must be learned? Not tools: judgment</h2>
<p>The temptation is to learn "the ten best AI tools". It is a bad strategy: they change every month. In 2024 UNESCO published an <strong>AI competency framework for teachers</strong> with 15 competencies, three progression levels (acquire, deepen, create) and five dimensions. Those dimensions work as a map; the specific skills in each are my own examples:</p>
{{img:dimensiones}}
<ul>
<li><strong>Human-centred mindset:</strong> deciding when <em>not</em> to use AI and keeping pedagogical judgment over what it proposes. It is the basis of everything else.</li>
<li><strong>Ethics of AI:</strong> knowing which student data never go into an external tool, recognizing bias and errors, and explaining to families and students what AI does and does not do in your class.</li>
<li><strong>Foundations and applications:</strong> writing clear, checkable instructions, and understanding the limits (it invents sources, gets calculations wrong, does not know your context).</li>
<li><strong>AI pedagogy:</strong> designing activities where AI makes students think rather than thinking for them, and assessing the <em>process</em>, not just the product (see <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">whether AI amplifies or replaces student thinking</a> and <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades really measure</a>, both in Spanish).</li>
<li><strong>AI for professional learning:</strong> using it to plan and give feedback, always with review, and learning with colleagues.</li>
</ul>
<p>The evidence on what is learned first in practice is clear: according to TALIS 2024, Colombian teachers who use AI use it mostly to generate lesson plans or activities (80%) and to learn efficiently about a topic (79%); much less to assess work (39%) or review performance data (37%). That is, they start with what saves time and less with what demands more judgment. <strong>The order I recommend is the reverse:</strong> the human and ethical first, then the practical (see the <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">guide to using AI in education</a>, in Spanish).</p>

<h2>Do teachers really want to upskill?</h2>
<p>Colombian data contradict the image of a profession that resists:</p>
{{img:talis}}
<ul>
<li><strong>53%</strong> of teachers used AI in their work in the previous 12 months (OECD average: 36%), on par with Brazil (56%), Chile (55%) and Costa Rica (52%).</li>
<li>Icfes reports that <strong>78%</strong> express a need for AI training (OECD: 66%), the highest among the topics surveyed; the OECD, with a stricter criterion, says <strong>43%</strong> have a "high need" for AI training.</li>
<li>48% included AI in their recent training (OECD average: 38%), and 69% say the professional learning they took part in had a positive impact on their teaching (OECD: 55%).</li>
</ul>
<p>The will exists. What fails is the supply. Among teachers who did <em>not</em> use AI, 64% say they lack the knowledge and 76% that their school lacks the infrastructure (OECD: 75% and 37%). And among barriers to training in general, Colombian teachers point out that it is <strong>too expensive (70%)</strong>, that <strong>there are no incentives (59%)</strong> and that <strong>there is no employer support (55%)</strong>. Feeling "overwhelmed" by new technology affects almost 30% (OECD: 33%). In the United States, the Gallup and Walton Family Foundation survey (April 2025, 2,232 teachers) found that 32% use AI weekly, 28% occasionally and 40% not at all, and that 68% received no AI training in the school year.</p>
<p><strong>Critical reading.</strong> "Do they want to?" is a badly framed question: almost all <em>want to</em>, but not under any condition. Wanting to upskill is not the same as agreeing to do it for free, at night and without recognition. Two cautions: TALIS covers lower secondary teachers and measures intention and self-report, and respondents may be biased; and going from "I used AI" to "I teach well with AI" is a leap the survey does not measure.</p>

<h2>Is it a challenge or extra work?</h2>
<p>It depends on who puts in the time and how much is recovered. As a starting point, a full-time Colombian teacher's week, according to TALIS 2024, is <strong>40.4 hours</strong>: 26.8 teaching, 9.1 preparing lessons, 6.0 marking and correcting, and 3.1 on administrative work. Preparing and marking are above the OECD average (7.4 and 4.6 hours). That means there are over 18 hours a week where AI could help.</p>
{{img:horas}}
<p>In the United States, teachers who use AI every week say they save <strong>5.9 hours a week</strong> (Gallup and Walton Family Foundation, 2025): there is no equivalent figure for Colombia, and it is a self-report. The <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">Excel workbook</a> (in Spanish) lets you enter your own assumptions: hours on each task, percentage you save, percentage of the saving lost to reviewing what the AI produces, training hours (at the start and afterwards) and hours your school recognizes as training time. With my base assumptions (4.1 hours of gross weekly saving, 30% lost to review and 5 weekly hours of training for 4 weeks, then 1 hour):</p>
{{img:balance}}
<table>
<thead><tr><th>Scenario</th><th>Balance for the year</th><th>Break-even week</th><th>Reading</th></tr></thead>
<tbody>
<tr><td>Base</td><td>+47.2 hours</td><td>15</td><td>A challenge that pays off</td></tr>
<tr><td>60% of the saving is lost to reviewing</td><td>+3.0 hours</td><td>36</td><td>Pays off very late</td></tr>
<tr><td>10-week initial period (the workbook's full plan)</td><td>+6.0 hours</td><td>37</td><td>Pays off very late</td></tr>
<tr><td>The school recognizes 3 weekly hours of training</td><td>+95.2 hours</td><td>7</td><td>A clear challenge</td></tr>
<tr><td>No saving (AI is useless for your tasks)</td><td>-56.0 hours</td><td>Not recovered</td><td>Extra work</td></tr>
</tbody>
</table>
<pre><code>' Cumulative balance for the week (column E of the Semanas sheet)
=E4+D5                                                                      ' same formula in English and Spanish

' Break-even week: first week with cumulative balance >= 0
=IFERROR(INDEX(Semanas!A4:A63,MATCH(TRUE,INDEX(Semanas!E4:E63>=0,0),0)),"No se recupera en el año")                ' English
=SI.ERROR(INDICE(Semanas!A4:A63;COINCIDIR(VERDADERO;INDICE(Semanas!E4:E63>=0;0);0));"No se recupera en el año")   ' Spanish</code></pre>
<p><strong>What the exercise teaches:</strong> the answer is neither "challenge" nor "extra work", but <strong>"it depends on three levers"</strong>: how much you really save, how much you lose reviewing and, above all, <strong>who recognizes the time spent learning</strong>. With institutional time the balance is clear; without it the cost falls entirely on the teacher and the return takes long. There is an extra trap the workbook does not calculate: <strong>if the saved time is filled with more tasks, AI's "dividend" is captured by the system</strong>. That is why schools should decide beforehand what they will do with the hours recovered.</p>
<p><strong>Law 2626 of 2026</strong> requires the Ministry of Education to design a teacher training program within six months of its promulgation (August 24, 2026). It will be important to see whether that program recognizes the time, not just the content.</p>

<h2>Is it worth continuing to be a teacher in the age of AI?</h2>
<p>It is the question that weighs the most, and it should be answered without easy comfort or catastrophism.</p>
<p><strong>What Colombian data say.</strong> According to TALIS 2024, 97% of teachers are satisfied with their job (OECD: 89%), 54% feel valued by society (OECD: 22%), 63% are satisfied with their salary (OECD: 39%), only 8% report a lot of stress (OECD: 19%) and 16% of those under 30 plan to leave teaching within five years (OECD: 20%). These are perception data, not the full labor reality: 30% do not have a permanent contract.</p>
<p><strong>What the evidence on AI says.</strong> The soundest studies show it as <em>augmenting</em> the teacher: in the Tutor CoPilot trial, AI that helped human tutors improved students' topic mastery (4 percentage points, 9 with lower-rated tutors) for about 20 dollars per tutor per year; the author of the Harvard study said his result is not an argument for replacing human interaction; and the OECD (<em>Digital Education Outlook 2026</em>) concludes that AI should augment teachers, not replace them, and calls for keeping teaching human-centred. And UNESCO estimates the world needs <strong>44 million more teachers by 2030</strong>.</p>
<p><strong>What AI does not do (today).</strong> Answer for a child, notice that something is wrong at home, sustain coexistence (in Colombia, 97% of teachers say students and teachers get along at their school and 80% believe they can support social-emotional learning), make assessment decisions the law requires to be a person's, and guide, which is what Law 115 of 1994 (art. 104) calls the educator's role: "guide (...) of a process of formation, teaching and learning" (my translation). I discussed it in <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">AI will not replace you, whoever masters it will</a> (in Spanish).</p>
<p><strong>What is not known.</strong> Which teaching tasks will change in ten years, how many positions there will be, what will happen to those who do not update and how much the profession will deteriorate or improve. Nobody knows for certain: whoever claims otherwise is selling something.</p>
<p><strong>My reading:</strong> it is worth it <em>if</em> the teaching you choose is about accompanying, diagnosing, assessing processes and forming judgment, and <em>if</em> the system recognizes the time spent learning and does not turn AI's saving into more workload. If what defines you most is transmitting information or correcting repetitive work, that part is indeed changing. The signal to watch is not "AI does X", but <strong>"which part of my work can only be done by someone who answers for these students?"</strong>.</p>

<h2>A minimal four-week plan</h2>
<p>The workbook has a <em>Plan</em> sheet with ten skills (two per dimension), your current level, your target level and estimated hours. With the workbook's example (47.5 hours to close all the gaps), a realistic plan is not done in a month. To start without being overwhelmed:</p>
<ol>
<li><strong>Week 1, the ethical:</strong> define which student data will never enter an external tool and why.</li>
<li><strong>Week 2, verify:</strong> ask an AI about something you know well and note its errors; it is the best way to build judgment.</li>
<li><strong>Week 3, a single activity:</strong> design a class activity with AI and decide which part students will do without AI.</li>
<li><strong>Week 4, balance:</strong> measure how long it took and how much it saved, with the real values in the workbook, and decide the next step.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p><strong>Colombia</strong> is one of the countries with the greatest teacher openness to AI and, at the same time, one of the largest infrastructure gaps (76% versus 37%). <strong>Latin America</strong> (Brazil, Chile, Costa Rica and Colombia) exceeds the OECD average in teacher use. <strong>Worldwide</strong>, dispersion is huge: from over 65% in Singapore, the United Arab Emirates, New Zealand, Australia and Vietnam, to 24% or less in France, Japan, Bulgaria, Hungary, Türkiye and Iceland (TALIS 2024, according to Icfes). Icfes also finds that where more teachers use AI, more receive training on it (correlation of 0.83): <strong>training seems to go hand in hand with use</strong>, although correlation does not prove causation.</p>
<p>For <strong>teachers</strong>, the challenge is to learn with time and judgment; for <strong>principals</strong>, to recognize training hours and define usage policies (in the United States, only 19% of teachers say their school has an AI policy, according to Gallup and Walton); for <strong>families</strong>, to know that using AI is neither better nor worse teaching in itself, it depends on how it is used; and for <strong>students</strong>, that their teachers teach them to use it with judgment and not just avoid it.</p>

<h2>Your opinion counts: a five-question poll</h2>
<p>I want to know how you live this. The poll is <strong>anonymous</strong>, stores no name, email or IP, and you can see the results when you answer. It reflects those who choose to answer: it is a conversation, not a statistic.</p>
{{encuesta:docente-aprender-ia}}

<h2>Tools and resources</h2>
<p>If you want to start learning with tested material (prompts reviewed against the Colombian curriculum, exams and planning with human review, and without entering student data into tools not built to safeguard it), take a look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">the time-balance workbook</a> (in Spanish), <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">the guide to using AI in education</a> and <a href="/colegio-100-virtual-docentes-100-ia-analisis-critico-legal-etico-pedagogico/">the analysis of a 100% virtual school with AI teachers</a> (both in Spanish), and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Sources consulted (October 12, 2026)</h2>
<ul>
<li><strong>OECD,</strong> <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2025/10/results-from-talis-2024-country-notes_eafd703e/colombia_04c7b413/8f1df220-en.pdf">Results from TALIS 2024: Colombia</a> (October 7, 2025): AI use, working hours, training needs and barriers, satisfaction, stress, status and contracts; Icfes, <a href="https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf">Uses, perceptions and challenges in teachers' integration of AI in Colombia</a> (December 2025, in Spanish).</li>
<li><strong>UNESCO,</strong> AI competency framework for teachers (2024; Miao and Çukurova): five dimensions, 15 competencies, three levels; teacher shortage data (44 million by 2030).</li>
<li><strong>Gallup and the Walton Family Foundation,</strong> <em>Teaching for Tomorrow</em> (June 2025; 2,232 US public school teachers; <a href="https://www.waltonfamilyfoundation.org/the-ai-dividend-new-survey-shows-ai-is-helping-teachers-reclaim-valuable-time">Walton Family Foundation summary</a>); training figures per <a href="https://the74million.org/article/survey-60-of-teachers-used-ai-this-year-and-saved-up-to-6-hours-of-work-a-week/">The 74</a> coverage.</li>
<li><strong>OECD,</strong> <a href="https://digital-skills-jobs.europa.eu/en/latest/news/oecd-digital-education-outlook-2026-how-generative-ai-can-support-learning-when-used">Digital Education Outlook 2026</a>; <strong>Wang et al. (2024),</strong> <a href="https://arxiv.org/abs/2410.03017">Tutor CoPilot</a>; <strong>Kestin et al. (2025),</strong> <em>Scientific Reports</em>, with the author's statement to The Hechinger Report.</li>
<li><strong>Rules:</strong> Law 115 of 1994 (art. 104), Decree 1850 of 2002 (40 school weeks, compiled into Decree 1075 of 2015) and Law 2626 of 2026.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What should a teacher learn about AI?</h3>
<p>More judgment than tools: when not to use it, which data to protect, how to verify what it produces, how to design activities where students think and how to assess the process. UNESCO organizes it into five dimensions.</p>
<h3>Do Colombian teachers use AI?</h3>
<p>According to TALIS 2024, 53% used it in the previous 12 months, more than the OECD average (36%). The main barrier they report is the lack of infrastructure (76% among those who did not use it) and of knowledge (64%).</p>
<h3>Is learning AI extra work?</h3>
<p>It depends on how much you save, how much you lose reviewing what it produces and whether your school recognizes training time. With prudent assumptions, the time invested can be recovered in about 15 weeks; with institutional time, in 7; and if you save nothing, it is a net burden. The Excel workbook lets you calculate it with your own data.</p>
<h3>Is it worth being a teacher with AI?</h3>
<p>The available evidence shows AI as augmenting the teacher rather than replacing them, but nobody can predict how the profession will change in ten years. It is worth it if the core of your work is accompanying, diagnosing and forming judgment, and if the system recognizes the time spent learning.</p>
<h3>How do I use the Excel workbook?</h3>
<p>Change the yellow parameters (hours per task, saving and review percentages, training hours) and your current and target level in each skill; the workbook calculates the week-by-week balance, the break-even week and the hours your plan requires.</p>

<p class="notice"><strong>Calculate your case.</strong> Download the <a href="/descargas/docente-aprender-ia/balance-tiempo-aprender-ia-docente.xlsx">time-balance workbook</a> (in Spanish), replace my assumptions with yours and answer the <a href="#encuesta">poll</a>.</p>

<h2>Food for thought</h2>
<p>Learning costs time, and a teacher's time is rarely their own. <strong>Who should pay for the time spent learning AI: the State, the school or each teacher? And if AI gave you back five hours a week, what part of your work would you want to do with that time so that it is worth continuing to be a teacher?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:dimensiones}}' => $img('docente-aprender-ia-dimensiones', 553, 'Table with the five dimensions of UNESCO\'s AI competency framework for teachers, what to learn in each and what for: human first, ethics, foundations, pedagogy and professional learning.', 'It is not learning tools: it is learning judgment.'),
    '{{img:talis}}' => $img('docente-aprender-ia-talis', 524, 'Bar chart of teachers in Colombia per TALIS 2024: used AI 53%, had AI in training 48%, high training need 43%, lack skills 64%, school lacks infrastructure 76% and training too expensive 70%.', 'Teachers in Colombia: use, needs and barriers.'),
    '{{img:horas}}' => $img('docente-aprender-ia-horas', 436, 'Bar chart of a full-time Colombian teacher\'s week: teaching 26.8 hours, preparing lessons 9.1, marking and correcting 6.0 and administrative work 3.1.', 'A Colombian teacher\'s week (TALIS 2024).'),
    '{{img:balance}}' => $img('docente-aprender-ia-balance', 573, 'Four figures from the workbook\'s time balance: minus 20 hours after the first month, break-even in week 15, plus 47 hours at the end of the year and week 36 if 60% of the saving is lost to reviewing.', 'The time balance depends on the assumptions.'),
]);

return [
    'ia-obliga-docente-volver-a-aprender-que-aprender-reto-o-trabajo-adicional' => [
        'slug' => 'ai-forces-teachers-to-learn-again-what-to-learn-challenge-or-extra-work',
        'title' => 'AI Also Forces Teachers to Learn Again: What to Learn, Is It a Challenge or Extra Work, and Is It Still Worth It?',
        'excerpt' => 'What a teacher must learn about AI, whether they really want to upskill, whether it is a challenge or extra work (with an Excel workbook) and whether teaching is still worth it, with Colombian data (TALIS 2024) and a poll.',
        'seo_title' => 'AI Forces Teachers to Learn Again: Is It Worth It?',
        'seo_description' => 'What teachers must learn about AI, whether they want to upskill, whether it is a challenge or extra work and if it is worth it. Colombian data and Excel.',
        'focus_keyword' => 'teachers learning artificial intelligence',
        'cover' => '/assets/img/articulos/docente-aprender-ia/docente-aprender-ia-portada-en',
        'cover_alt' => 'Cover "AI also forces teachers to learn again: what, what for and at what cost?" with a card: 53% of Colombian teachers used AI in their teaching in the past year, versus 36% on the OECD average.',
        'content_html' => $html,
    ],
];
