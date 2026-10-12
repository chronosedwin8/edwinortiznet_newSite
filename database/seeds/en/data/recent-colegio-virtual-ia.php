<?php

declare(strict_types=1);

// English version of «¿Se puede crear un colegio 100 % virtual con docentes 100 % de IA para estudiant…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/colegio-virtual-ia/' . $name . '-en';
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
<p>The question sounds like science fiction, but it is already being asked in earnest: <strong>can you create a 100% virtual school, with 100% artificial intelligence teachers, for real students?</strong> Some founders propose it, some ministries reject it, families hesitate and teachers feel they are being asked, quietly, whether they are still needed. This article does not aim to win an argument: it aims to <strong>break the question apart</strong> and look at each piece with the available evidence and a critical eye.</p>
<p>The short answer, before the detail: <strong>today, in Colombia, it is not legal; technically you can assemble something that looks like a school, but the evidence does not support that it works without human teachers; and what does show promising results is something else: AI as a tutor, with a teacher alongside.</strong> Between one and the other there are eight dimensions worth looking at: technical, legal, ethical, pedagogical, social, inclusion, economic and acceptance. To organize them, I include an <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">Excel workbook with a viability matrix</a> (in Spanish) of three scenarios, which you can edit with your own criteria (verified in Microsoft Excel 16 and against an independent calculation), and at the end a <a href="#encuesta">five-question poll</a> to learn your opinion. Sources reviewed on <strong>October 12, 2026</strong>.</p>
<p class="notice"><strong>Warning.</strong> The matrix scores are <strong>my judgment</strong> on the cited evidence, not published data. I mark clearly what is data, what is an official opinion and what is opinion. The poll is open and anonymous: it does not represent anyone in particular.</p>

<h2>First, define the terms</h2>
<p>Almost the whole discussion gets tangled because everyone understands something different. For this analysis I separate three scenarios:</p>
<ol>
<li><strong>Scenario 1 (the one being asked):</strong> a 100% virtual school with teachers that are AI systems, for real children and teenagers. No adult is accountable for the teaching.</li>
<li><strong>Scenario 2:</strong> a virtual school where AI tutors and the adults are "guides" who motivate and accompany (broadly, the model of the schools cited today).</li>
<li><strong>Scenario 3:</strong> an in-person school with human teachers and an AI tutor supporting the student (the "augmented teacher").</li>
</ol>
<p>When someone says "AI schools already work", they are almost always talking about scenarios 2 or 3. Scenario 1 is something else, and it is the one being asked.</p>

<h2>What already exists, with a critical eye</h2>
<p>The most cited example is <strong>Alpha School</strong>, a private school with campuses in the United States that says it teaches core subjects in about two hours a day with adaptive software and spends the rest of the day on workshops. What matters for this discussion: <strong>it is neither virtual nor adult-free</strong>; the adults are called "guides" and are in charge of motivating and supporting. Its learning figures (it claims its students grow 2.6 times faster than peers on MAP tests) are <strong>the school's own</strong>, according to the analysis published by Dan Meyer, and I have not found an independent evaluation.</p>
<p>Its sister project, <strong>Unbound Academy</strong>, is virtual. Pennsylvania rejected its cyber charter application on January 29, 2025; according to Chalkbeat's coverage, the state said the AI model was "untested", that it did not show how it would align with academic standards, that its plans for students with disabilities were insufficient and that it did not even include a list of courses. Arizona approved it for the 2025-2026 school year. An analysis by Dan Meyer (August 12, 2026) of the school board's public slideshow reports, for that first year, <strong>10% of students at proficiency in math</strong> (the application projected 60% and the state average was 34%) and 28% in reading and writing (versus 65% projected and 42% statewide). It is a secondary source, covers a single year and is not an independent evaluation: <strong>it does not prove that the model fails, but it does not back up the promises either</strong>.</p>
{{img:existente}}
<p>In Latin America, my search (October 12, 2026) found no virtual school run by AI without teachers in Mexico, Brazil, Chile or Colombia; what exists are AI programs with human teachers, university training and observatories. That supports the idea that this topic has <strong>no local evidence</strong>, but "I did not find it" is not the same as "it does not exist".</p>

<h2>Technical dimension: what AI does well, what it does not and what breaks without an adult</h2>
<ul>
<li><strong>What it does well:</strong> explaining a topic in several ways, generating exercises, giving immediate feedback, adapting difficulty and being available at any hour. In Colombia, the teachers who already use it do so mostly to generate lesson plans or activities (80%) and to learn efficiently about a topic (79%), according to TALIS 2024.</li>
<li><strong>What it does badly:</strong> it errs with confidence (hallucinations), can reinforce biases and does not know when a student needs something other than what they ask. The OECD (<em>Digital Education Outlook 2026</em>) warns about "metacognitive laziness": when students offload thinking, performance rises while the tool is there and can vanish when it is removed.</li>
<li><strong>What breaks without an adult:</strong> someone has to notice that a child has not logged in for three days, is sad, is being bullied or received a worrying message. In Colombia that has a name: the comprehensive care route for school coexistence (Law 1620 of 2013). An AI system cannot be the adult who responds.</li>
<li><strong>Infrastructure:</strong> 73.9% of Colombian households have internet (DANE's 2025 Quality of Life Survey, cited by MinTIC), and 56.9% of rural households do. And among Colombian teachers who did not use AI, 76% say their school lacks the necessary infrastructure, versus 37% on the OECD average (TALIS 2024).</li>
</ul>
<p><strong>Critical reading:</strong> technically, scenario 1 can be built with today's tools; what cannot be guaranteed is that it is safe and of good quality without human supervision.</p>

<h2>Legal dimension: here is the first block</h2>
<p>Colombia's Ministry of Education put it with unusual clarity in an official reply to a citizen's inquiry of <strong>October 14, 2025</strong> (file 2025-EE-300537): non-in-person education is provided only for adults (in the semi-in-person modality, with attendance of no less than 50% of annual hours, under article 2.3.3.5.3.4.5 of Decree 1075 of 2015), for students in the Adolescent Criminal Responsibility System (with at least 70% in-person) and for students with disabilities who, because of their circumstances, need a hospital or home-based offer (Decree 1421 of 2017). <strong>Outside those cases, in-person attendance is mandatory between ages 5 and 15</strong> in preschool, basic and secondary education. And it adds: "until the virtual modality is regulated for preschool, basic and secondary education levels, education secretariats (...) may only authorize the educational service in person", so "at present there are no educational establishments, public or private, authorized to offer the educational service in the virtual modality" (my translation). It also clarifies that the 2020 work-from-home measures were exceptional and temporary, not a general authorization.</p>
<p>Other pieces of the framework that weigh in:</p>
<ul>
<li><strong>Operating license.</strong> For a private school it is issued by the certified education secretariat and, under Decree 3433 of 2008 (compiled into Decree 1075 of 2015), requires among other things an educational project, a health certificate, land use and physical plant conditions. A school with no premises does not fit that design.</li>
<li><strong>Who is the educator.</strong> Law 115 of 1994 (art. 104) says "the educator is the guide, in educational establishments, of a process of formation, teaching and learning" (my translation). The Teaching Profession Statute (Decree-Law 1278 of 2002, art. 3) defines education professionals as people with a teaching degree or another qualifying degree. An AI system is not a person, has no degree and answers to no one.</li>
<li><strong>Minors' data.</strong> Law 1581 of 2012 (art. 7) requires respecting the prevailing rights of children and adolescents and, according to the Constitutional Court (C-781 of 2011), allows processing their data only if it serves their best interests; Decree 1074 of 2015 (art. 2.2.2.25.2.9) requires the authorization of their legal representative, after hearing the minor. A school that processes every conversation a minor has with an AI handles sensitive data continuously.</li>
<li><strong>AI content, not AI teachers.</strong> Law 2626 of 2026 (August 24) updates Technology and Informatics to include AI, programming and data science and requires the Ministry to design a teacher training program within six months; it respects school autonomy and parents' preferential right (Constitution, art. 68). It is a law to <em>teach about</em> AI, not to <em>teach with AI instead of teachers</em>. The National AI Policy (CONPES 4144 of 2025) and the Ministry's AI Decalogue for higher education (2026) stress ethics, governance and "the preservation of human interaction as the central axis of education" (my translation; the decalogue is for higher education).</li>
</ul>
<p>In Europe, Regulation (EU) 2024/1689 bans inferring emotions from biometrics in educational institutions and classifies as high-risk the AI that evaluates learning outcomes (the application of high-risk obligations is being phased in: check the current calendar). It signals where regulation is heading where legislation already exists.</p>
<p><strong>Critical reading:</strong> scenario 1 (and 2, being virtual) clash with the regulation today. A Ministry opinion is not a law, but it reflects how Decree 1075 is being read. Changing that would require regulating the virtual modality for minors, which is a public-policy decision, not an entrepreneur's.</p>

<h2>Ethical dimension: who answers when something goes wrong</h2>
<ul>
<li><strong>Responsibility.</strong> If an AI gives wrong guidance to a teenager, who answers? In a school the chain is clear: teacher, coordination, principal, secretariat. In scenario 1 there is no adult in that chain.</li>
<li><strong>Informed consent.</strong> Would families accept an experiment with their children? A responsible design should say what is measured, what the risks are and how to exit.</li>
<li><strong>Emotional bonding.</strong> In April 2025, Common Sense Media rated social AI companions (Character.AI, Replika, Nomi and similar) "unacceptable" for people under 18, after finding they claim to have emotions and offer harmful responses. This is not the same category as a school tutor and I did not find an equivalent assessment of tutors, but <strong>a "teacher" who knows you, praises you and is always available shares traits with those products</strong>, and so it requires specific evaluation.</li>
<li><strong>Surveillance.</strong> Measuring attention with a camera, or inferring emotions, is a practice European law prohibits in educational institutions. Some reports on AI schools have described camera monitoring (the school concerned disputes part of that coverage); the discussion is real.</li>
<li><strong>Age.</strong> UNESCO (2023) proposes setting a minimum age for students' independent conversations with generative AI platforms (13 is often cited) and a human-centred approach with prior ethical and pedagogical validation.</li>
</ul>

<h2>Pedagogical dimension: what the evidence says (for and against)</h2>
<p>Here we must be honest with both sides. AI as a tutor has real results:</p>
<ul>
<li><strong>Harvard (Kestin et al., <em>Scientific Reports</em>, 2025):</strong> 194 students in a physics course learned one topic with a carefully designed AI tutor and another with an active-learning class: with the tutor they learned more than twice as much in less time. The author himself said he does not see it as an argument for replacing human interaction.</li>
<li><strong>Nigeria (World Bank, 2024-2025):</strong> 800 secondary students, six weeks of English tutoring with Copilot, <strong>with teachers mediating</strong> the session: an improvement of about 0.3 standard deviations. The World Bank translates it into nearly two years of typical learning (a conversion to read with caution) and acknowledges that long-term and negative effects are unknown.</li>
<li><strong>Tutor CoPilot (Wang et al., 2024):</strong> in a randomized trial with 900 tutors and 1,800 students, an AI that <em>helps human tutors</em> raised topic mastery by 4 percentage points (9 for lower-rated tutors), at about 20 dollars per tutor per year.</li>
</ul>
<p>And there is also evidence of harm when AI is used without judgment:</p>
<ul>
<li><strong>Bastani et al. (<em>PNAS</em>, 2025):</strong> among nearly a thousand secondary students in Turkey, unguarded GPT-4 access raised practice performance (+48%), but when it was removed, students scored <strong>17% lower than those who never had it</strong>. With a tutor with safeguards (hints instead of answers), the harm was largely mitigated.</li>
<li><strong>Virtual schools (without AI).</strong> CREDO (2015) estimated that students in virtual charter schools learned the equivalent of 72 fewer days in reading and 180 fewer days in math than comparable peers (with a debated method); NEPC's report (2021) counted 477 full-time virtual schools with 332,379 students and a 54.6% graduation rate, versus 85% nationally. It is evidence about the virtual <em>modality</em>, not about AI, but scenario 1 inherits it.</li>
</ul>
<p><strong>Critical reading.</strong> The favorable studies are <strong>short</strong> (weeks), on <strong>one subject</strong>, with motivated students or teachers around, and almost always measure structured content. None proves a whole school over years without human teachers. The soundest conclusion is this: <strong>AI helps when it is designed to make you think and an adult integrates it; it harms when it hands you the answer</strong>. It is the same lesson as the <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">guide to using AI in education</a> and <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">the article on whether AI amplifies or replaces student thinking</a> (both in Spanish).</p>

<h2>Can skills and competencies be acquired with AI?</h2>
<p>It is the central question and it still has no complete answer, either in Colombia or in the region. A competency is more than information: it is knowing, knowing how to do and acting with judgment <em>in a real situation</em>. With current evidence, my reading is this:</p>
<table>
<thead><tr><th>Type of learning</th><th>What the evidence says</th><th>Confidence</th></tr></thead>
<tbody>
<tr><td>Knowledge and procedures in structured areas (math, physics, languages)</td><td>Favorable results with well-designed tutors, in short studies</td><td>Medium</td></tr>
<tr><td>Metacognition and learning to learn</td><td>Possible with scaffolding; without it, "metacognitive laziness" appears</td><td>Low to medium</td></tr>
<tr><td>Transfer to new situations, creativity</td><td>Little evidence; studies mostly measure immediate performance</td><td>Low</td></tr>
<tr><td>Socio-emotional skills (empathy, coexistence, collaboration)</td><td>No evidence that AI teaches them; they develop with other people</td><td>Very low</td></tr>
<tr><td>Ethical judgment and citizenship</td><td>No evidence; it requires deliberating with others and living in a community</td><td>Very low</td></tr>
</tbody>
</table>
<p>The contrast with the human side is clear in Colombian data: according to TALIS 2024, 97% of teachers say students and teachers get along well at their school, 83% feel valued by students and 80% believe they can support socio-emotional learning "quite a bit" or "a lot". <strong>That web of relationships is exactly what scenario 1 cannot offer.</strong> That is why the honest question is not "does AI teach?" but "what does it teach well, what does it teach badly and who covers the rest?".</p>
{{img:dimensiones}}

<h2>Social, inclusion and interaction dimension</h2>
<ul>
<li><strong>Socialization.</strong> School is not just instruction: it is where you learn to negotiate, wait your turn and live with people who are different. A fully virtual school with AI tutors reduces interaction among peers and with adult role models to a minimum.</li>
<li><strong>Students with disabilities.</strong> The Ministry states in the same 2025 reply that virtual education is not regulated "for any student from diversity". Decree 1421 of 2017 requires reasonable adjustments and the PIAR (see <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusion in the classroom and the PIAR</a>, in Spanish), and Pennsylvania cited insufficient plans for students with disabilities as one of its reasons for rejection. AI can be an excellent support (60% of Colombian teachers who use it do so to support students with special educational needs, according to TALIS), but <strong>as a tool of a human team, not as a substitute</strong>.</li>
<li><strong>Equity.</strong> With 56.9% of rural households online, a virtual school can widen access for those with no school nearby, but it can also exclude those without connectivity, a device or an adult supervising at home. Families who can pay for good support would get better results: the gap could widen.</li>
</ul>

<h2>Vision for the future and relevance: where it can make sense</h2>
<p>Saying "no" to scenario 1 is not saying "no" to AI. UNESCO estimates the world needs <strong>44 million more teachers by 2030</strong>; there are places with no teachers where AI tutoring, with remote human support, would be better than nothing. Some routes the evidence backs more:</p>
<ul>
<li><strong>AI tutor with a teacher present</strong> (scenario 3): reinforcement, practice and immediate feedback, with the teacher deciding when and for what.</li>
<li><strong>Adult education</strong>, where the rules already allow semi-in-person or distance modalities.</li>
<li><strong>Areas with teacher shortages</strong>, as a supervised complement and not a replacement, and asking the education secretariat for express permission for a pilot.</li>
<li><strong>AI that helps the teacher</strong> (planning, adapting materials, giving feedback): the most widespread use today among Colombian teachers.</li>
</ul>
<p>The relevance, in short, lies in <strong>redefining the teacher's role</strong> (less transmitting, more diagnosing, accompanying, assessing the process), not eliminating it. Alpha itself, the most cited model, keeps adults at the center of its design.</p>

<h2>Fear of the unknown: teachers, families and the education system</h2>
<p>This is probably the least technical and most decisive obstacle. Fears are not a defect of those who feel them: <strong>they are information</strong>. Some have a basis, others are inertia, and it helps to separate them.</p>
<table>
<thead><tr><th>Who</th><th>What they fear</th><th>What is true</th><th>What reduces it</th></tr></thead>
<tbody>
<tr><td>Teachers</td><td>Being replaced; losing the bond; being watched by the platform</td><td>No evidence supports a tutor replacing the teacher; there is a risk of surveillance and of more workload if the system "manages" the teacher</td><td>Taking part in the design, training with recognized time and clear rules on teacher data</td></tr>
<tr><td>Families</td><td>That their children will not socialize; that data will be misused; that the diploma will not count</td><td>All three are real risks: without official authorization there is no valid diploma</td><td>An authorized pilot, informed consent, data transparency and a right to exit</td></tr>
<tr><td>Students</td><td>Isolation; being assessed by a machine</td><td>Human interaction is part of what they value; AI tutors are liked for their immediacy</td><td>Human spaces for work and assessment, with known criteria</td></tr>
<tr><td>Education system</td><td>Losing quality control; opening the door to businesses without evidence</td><td>Well-founded: there is no long-term evidence and the schools' figures are their own</td><td>Independent evaluation, a regulatory sandbox and publication of results</td></tr>
</tbody>
</table>
<p>A Colombian data point helps avoid drama: according to TALIS 2024, 53% of teachers already used AI in the last year, more than the OECD average (36%) and on par with Brazil (56%), Chile (55%) and Costa Rica (52%). <strong>The problem is not a teaching profession that refuses to change</strong>: it is a profession that wants to use AI and meets schools without infrastructure (76% among those who did not use it) and without affordable training (70% say training is too expensive). I discuss this more in <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">AI will not replace you, whoever masters it will</a> (in Spanish).</p>

<h2>The viability matrix (with your own criteria)</h2>
<p>The <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">Excel workbook</a> (in Spanish) gathers the eight dimensions, a weight for each (1 to 3), a score from 0 to 5 for each scenario and a <strong>blocking</strong> rule: if a dimension marked as blocking (legal and data ethics, in my version) is at 1 or less, the scenario cannot advance, whatever its average. The <em>Evidencia</em> sheet lists the sources behind each score.</p>
{{img:matriz}}
<pre><code>' Weighted score (0 to 100) of scenario 1 (column D of the Matriz sheet)
=SUMPRODUCT(Matriz!$B$4:$B$11,Matriz!D$4:D$11)/(SUM(Matriz!$B$4:$B$11)*Parametros!$B$3)*100        ' English
=SUMAPRODUCTO(Matriz!$B$4:$B$11;Matriz!D$4:D$11)/(SUMA(Matriz!$B$4:$B$11)*Parametros!$B$3)*100     ' Spanish

' Blocking dimensions at risk: blocking ones with a score at or below the threshold
=SUMPRODUCT((Matriz!$C$4:$C$11="Sí")*(Matriz!D$4:D$11<=Parametros!$B$4))                             ' English
=SUMAPRODUCTO((Matriz!$C$4:$C$11="Sí")*(Matriz!D$4:D$11<=Parametros!$B$4))                          ' Spanish</code></pre>
<p>Results with my scores: <strong>scenario 1, 20 out of 100 (blocked by the legal dimension and data ethics); scenario 2, 33 (blocked by the legal framework); scenario 3, 73 (viable)</strong>. If you set scenario 3's legal dimension to 0, the workbook marks it blocked: the rule works the same for everyone. <strong>An honest reading:</strong> the numbers condense opinions. Use them to discuss <em>why</em> you give each score, not to win an argument. If you think scenario 1's pedagogical evidence is worth more than 1, change it: you will see the legal block is still there.</p>

<h2>A responsible pilot: how to start without gambling with children</h2>
<p>If the goal is to start a project, the starting point is not opening the school, but <strong>asking the right question in the least risky way</strong>. My proposal, for discussion:</p>
{{img:piloto}}
<ol>
<li><strong>A concrete research question,</strong> for example: does an AI tutor with scaffolding, used two hours a week in math in grades seven and eight, improve learning without reducing coexistence?</li>
<li><strong>Scenario 3, not 1.</strong> A human teacher present, the AI tutor as support, a small group, with a comparison group.</li>
<li><strong>Permission and consent.</strong> The education secretariat, the school project and assessment system up to date, and families' informed consent, with a right to exit without consequences.</li>
<li><strong>Minimal data.</strong> No names in external tools, a contract with the provider, limited retention and processing in line with Law 1581.</li>
<li><strong>Measures defined beforehand:</strong> learning with AI and <em>without</em> AI, after a few weeks and at six months (retention), wellbeing and coexistence, attendance and equity between groups.</li>
<li><strong>Stopping criteria:</strong> if learning without AI drops, if dependence grows or if harm appears, it stops.</li>
<li><strong>External evaluation</strong> (a university or Icfes, for example) and <strong>publication of all results, including negative ones</strong>.</li>
<li><strong>Request a regulatory sandbox.</strong> If someday a virtual modality for minors is to be tried, it should be through an experimentation space authorized by the Ministry, not through facts on the ground.</li>
</ol>
<p>That route answers what Pennsylvania found missing (evidence, alignment with standards, a plan for students with disabilities and sustainable support) and what UNESCO asks for (a human-centred approach, ethical and pedagogical validation).</p>

<h2>Colombia, Latin America and the world</h2>
<p><strong>Colombia:</strong> the Ministry does not authorize virtual schools for minors today; teachers already use AI (53%) and ask for training (Icfes reports that 78% express a need for AI training; the OECD, with a stricter criterion, that 43% have a "high need"); Law 2626 of 2026 opens the door to teaching AI, not to AI teaching in place of teachers. <strong>Latin America:</strong> Brazil, Chile, Costa Rica and Colombia exceed the OECD average in teachers' use of AI, and I found no 100% AI schools; the debate is just starting. <strong>The world:</strong> the United States is the laboratory for commercial models (with approvals and rejections divided between states), the European Union strongly regulates AI in education and UNESCO asks for a human approach and minimum ages.</p>
<p>For <strong>teachers</strong>, the challenge is to be part of the design and not its object; for <strong>principals</strong>, to decide what is tested, with what permission and what data; for <strong>families</strong>, to demand evidence and consent, not promises; and for <strong>students</strong>, that their voice counts: they are the ones living the experience.</p>

<h2>Your opinion counts: a five-question poll</h2>
<p>This article opens a conversation about a question that in Latin America still has no answer. To know where to go next, I want to hear your opinion. The poll is <strong>anonymous</strong>, stores no name, email or IP, and you can see the results when you answer. Remember that it reflects those who choose to answer: it is a conversation, not a statistic.</p>
{{encuesta:colegio-virtual-ia}}

<h2>Tools and resources</h2>
<p>If you want to explore AI as support for the teacher (planning, material and assessment), with human review always present and without entering student data into tools not built to safeguard it, take a look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">the viability matrix workbook</a> (in Spanish), <a href="/educacion-virtual-vs-presencial-colombia-datos/">virtual versus in-person education in Colombia</a> and <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">phones at school: banning is not enough, we have to teach</a> (both in Spanish), and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Sources consulted (October 12, 2026)</h2>
<ul>
<li><strong>Ministry of National Education,</strong> official reply 2025-EE-300537 (October 14, 2025) and <a href="https://www.mineducacion.gov.co/1621/article-179304.html">guidance on operating licenses</a>; Decree 1075 of 2015 (arts. 2.3.3.5.3.4.5 and 2.3.3.5.8.5.4), Decree 3433 of 2008, Decree 1421 of 2017, Law 115 of 1994 (art. 104), Decree-Law 1278 of 2002, Law 1581 of 2012 (art. 7) and Decree 1074 of 2015, Law 1620 of 2013, Law 2626 of 2026, CONPES 4144 of 2025 and the AI Decalogue for higher education (MEN, 2026).</li>
<li><strong>OECD,</strong> <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2025/10/results-from-talis-2024-country-notes_eafd703e/colombia_04c7b413/8f1df220-en.pdf">Results from TALIS 2024: Colombia</a> (October 7, 2025); Icfes, <a href="https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf">Uses, perceptions and challenges in teachers' integration of AI in Colombia</a> (December 2025, in Spanish); OECD, <a href="https://digital-skills-jobs.europa.eu/en/latest/news/oecd-digital-education-outlook-2026-how-generative-ai-can-support-learning-when-used">Digital Education Outlook 2026</a>.</li>
<li><strong>Bastani et al. (2025),</strong> <a href="https://www.pnas.org/doi/10.1073/pnas.2422633122">"Generative AI without guardrails can harm learning"</a>, <em>PNAS</em> 122(26); <strong>Kestin et al. (2025),</strong> "AI tutoring outperforms in-class active learning", <em>Scientific Reports</em>; <strong>Wang et al. (2024),</strong> <a href="https://arxiv.org/abs/2410.03017">Tutor CoPilot</a>; World Bank, <a href="https://blogs.worldbank.org/en/education/From-chalkboards-to-chatbots-Transforming-learning-in-Nigeria">From chalkboards to chatbots</a> (Nigeria).</li>
<li><strong>CREDO (2015)</strong> and the <a href="https://fordhaminstitute.org/national/commentary/virtual-charter-school-students-are-not-learning-nearly-enough">Fordham Institute commentary</a>; <a href="https://www.nepc.colorado.edu/node/10899">NEPC, Virtual Schools in the U.S. 2021</a>.</li>
<li><strong>Chalkbeat,</strong> <a href="https://chalkbeat.org/philadelphia/2025/01/29/pennsylvania-rejects-ai-cyber-charter-school-unbound-academy-application">Pennsylvania rejects Unbound Academy</a> (January 29, 2025); Dan Meyer, <a href="https://danmeyer.substack.com/p/does-alpha-school-work-for-regular">Does the Alpha School model work for regular kids?</a> (August 12, 2026; secondary source, using the school board's data).</li>
<li><strong>UNESCO,</strong> <a href="https://www.unesco.org/en/articles/guidance-generative-ai-education-and-research">Guidance for generative AI in education and research</a> (2023) and teacher shortage data (44 million by 2030); <strong>Common Sense Media</strong> (April 2025), assessment of social AI companions; Regulation (EU) 2024/1689, art. 5 and Annex III; <strong>MinTIC/DANE,</strong> <a href="https://www.mintic.gov.co/portal/715/w3-article-437305.html">household connectivity (2025 Quality of Life Survey)</a>.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Is a 100% virtual school legal in Colombia?</h3>
<p>For preschool, basic and secondary education, no: according to the Ministry (October 14, 2025), in-person attendance is mandatory between ages 5 and 15 and no establishments are authorized to offer the service in the virtual modality. The exceptions are adults, the adolescent criminal responsibility system and students with disabilities in a hospital or home-based offer.</p>
<h3>Does any school exist without human teachers?</h3>
<p>The most cited models (Alpha School and Unbound Academy) use adults as "guides" who motivate and accompany. I found no school with evidence that works without any responsible adult.</p>
<h3>Can AI teach better than a teacher?</h3>
<p>In short, single-subject studies, a well-designed AI tutor achieved good results (for example, at Harvard and in Nigeria). But the authors do not present it as a replacement for the teacher, and other studies show that, without guardrails, AI can harm learning.</p>
<h3>Can competencies be learned with AI?</h3>
<p>There is evidence for knowledge and procedures in structured areas; little for transfer and creativity, and no evidence that AI teaches socio-emotional skills or ethical judgment, which develop with other people.</p>
<h3>How do I use the Excel workbook?</h3>
<p>Edit the weights (1 to 3) and the scores (0 to 5) of each scenario; the workbook calculates the weighted score, how many blocking dimensions are at risk, the weakest dimension and a final reading.</p>

<p class="notice"><strong>Take part.</strong> Download the <a href="/descargas/colegio-virtual-ia/matriz-viabilidad-colegio-virtual-ia.xlsx">matrix workbook</a> (in Spanish), discuss it with your educational community and answer the <a href="#encuesta">poll</a>.</p>

<h2>Food for thought</h2>
<p>A school is more than a place where content is transmitted: it is a place where someone answers for you. <strong>If an AI could explain better than any of your teachers, what would you still need from a person to consider that you are in a school? And if you were the one deciding on a pilot, what result would make you stop it even if the test scores were good?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:existente}}' => $img('colegio-virtual-ia-existente', 633, 'Comparison between what exists (in-person Alpha School with human guides, virtual Unbound Academy with guides and rejected in Pennsylvania, the schools\' own figures) and what is being asked (100% virtual, 100% AI teachers, no equivalent evidence).', 'Today\'s models are not the scenario being asked about.'),
    '{{img:dimensiones}}' => $img('colegio-virtual-ia-dimensiones', 717, 'Table of eight dimensions with their main obstacle and the reading of scenario 1: legal blocked, technical weak, ethics and data blocked, pedagogical weak, socio-emotional weak, inclusion weak, cost favorable and acceptance weak.', 'Each dimension has its own obstacle.'),
    '{{img:matriz}}' => $img('colegio-virtual-ia-matriz', 392, 'Bar chart with the weighted score of three scenarios: 100% virtual with AI teachers 20, virtual with human guides and AI tutor 33, and in person with human teachers and AI tutor 73.', 'Viability matrix: scores from my judgment.'),
    '{{img:piloto}}' => $img('colegio-virtual-ia-piloto', 467, 'Five steps of a responsible pilot: question, permission, small pilot with a human teacher and AI tutor, measurement of learning, wellbeing and equity, and a decision with publication of all results.', 'How to start without gambling with children.'),
]);

return [
    'colegio-100-virtual-docentes-100-ia-analisis-critico-legal-etico-pedagogico' => [
        'slug' => '100-percent-virtual-school-100-percent-ai-teachers-critical-analysis',
        'title' => 'Can You Create a 100% Virtual School with 100% AI Teachers for Real Students? A Critical Analysis',
        'excerpt' => 'Eight dimensions (technical, legal, ethical, pedagogical, social, inclusion, economic and acceptance), the evidence for and against, what Colombia\'s Ministry of Education says, teachers\' and families\' fears, an Excel matrix and a poll.',
        'seo_title' => '100% Virtual School with AI Teachers: Critical Analysis',
        'seo_description' => 'Can you create a virtual school with AI teachers? Legal (Colombia), technical, ethical and pedagogical analysis, with evidence, an Excel matrix and a poll.',
        'focus_keyword' => 'virtual school with AI teachers',
        'cover' => '/assets/img/articulos/colegio-virtual-ia/colegio-virtual-ia-portada-en',
        'cover_alt' => 'Cover "A 100% virtual school with 100% AI teachers? A critical analysis before starting" with a card on what we know today: it is not legal in Colombia, there is no long-term evidence, AI works as a tutor and it can be piloted with teachers.',
        'content_html' => $html,
    ],
];
