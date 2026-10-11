<?php

declare(strict_types=1);

// English version of «Guía del uso de la inteligencia artificial en educación: qué funciona, qué no y …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-en-educacion/' . $name . '-en';
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
<p>A student hands in a flawless essay. The teacher suspects, confronts the student, the student denies it, the family complains, the AI detector says "87% generated" and nobody knows what to do with that number. In another classroom, a teacher uses an AI to prepare the lesson, generate three versions of an exercise and write comments on the work, and ends the week with time to attend the students who need it most. Both scenes happen today in Colombian schools, and the difference between them is not the tool: it is <strong>what decisions were made before using it</strong>.</p>
<p>This is a guide for those decisions. It is not a tool tutorial (they change every month), but a map: what the evidence says about when AI helps learning and when it only helps appearances, what regulatory and policy framework exists in Colombia and worldwide, how to decide <strong>how much AI each task allows</strong>, what to do with students' data and how to implement it in a school. It includes an <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">Excel workbook</a> (in Spanish) that turns the decision into a per-task matrix (with a fictional course of twelve tasks), verified in Microsoft Excel 16 and against an independent calculation. Sources reviewed on <strong>October 10, 2026</strong>.</p>
<p class="notice"><strong>Scope.</strong> This is a guide to professional judgment, not legal advice or an official policy. The cited studies are specific (one age group, one course, one country) and their results cannot be extrapolated without care. Rules change: check the current text and your education secretariat's guidance. The workbook's data are fictional.</p>

<h2>Principle 1: AI is a means; learning is the end</h2>
<p>UNESCO's guidance on generative AI in education and research (September 2023) starts from a <strong>human-centred</strong> approach: technology must serve human agency, inclusion and equity, not replace them. Among other things, it suggests that governments regulate use in schools, that tools be validated before reaching students, that teachers be trained and that a minimum age be considered (the proposal mentions 13) for autonomous classroom use; it is a recommendation for each country to evaluate, not a binding rule. In 2024, UNESCO also published AI competency frameworks for teachers (15 competencies in five dimensions: human-centred mindset, ethics of AI, AI foundations and applications, AI pedagogy and AI for professional development) and for students.</p>

<h2>What the evidence says: performing better is not learning better</h2>
{{img:evidencia}}
<ul>
<li><strong>An unrestricted chatbot can harm learning.</strong> In an experiment with about 1,000 high school students in Türkiye (Bastani and colleagues, <em>PNAS</em>, July 2025), those who practiced with a standard-interface GPT-4 did 48% better in practice, but <strong>17% worse</strong> on the AI-free exam than those who never used it. Those who used a tutor designed to give hints instead of answers did 127% better in practice and <strong>the same</strong> as the control group on the exam. It is short-term evidence.</li>
<li><strong>A well-designed tutor can speed up learning.</strong> In a randomized trial with 194 physics students at Harvard (Kestin and colleagues, <em>Scientific Reports</em>, 2025), those who learned a topic with an AI tutor designed on pedagogical principles learned, according to the authors, more than twice as much as with an active-learning class, and in less time (a median of 49 minutes versus 75). It is a study of university students in one course, two topics and short-term tests: it does not say AI replaces class.</li>
<li><strong>The OECD review</strong> (<em>Digital Education Outlook 2026</em>, January 2026) summarizes that direction: with general-purpose tools, students produce better results, but the advantage disappears, or reverses, when the tool is taken away; educational tools designed with pedagogical intent, by contrast, tend to show sustained improvements. It does not recommend banning, but selective, purposeful use.</li>
</ul>
<p>The practical reading is this: <strong>the question is not "AI yes or no?" but "does this task, with this kind of support, leave more or less learning?"</strong>. An AI that gives the answer removes the effort that produces learning (see also <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">the great lie about AI</a>, in Spanish); an AI that asks, hints and demands explanation can add it.</p>

<h2>Regulatory and policy framework</h2>
<ul>
<li><strong>Colombia, Law 2626 of 2026 (Digital Education Law, enacted on August 24).</strong> It updates the Technology and Informatics subject in basic and secondary education and adds competencies in computational thinking, programming, <strong>artificial intelligence</strong>, data science and digital citizenship (art. 1). It applies to public institutions, and private schools may adopt the model (art. 2). It orders the Ministry of Education to update guidelines at least every three years and design a mandatory curriculum map that includes AI (art. 3), create a mandatory teacher training program within six months (art. 4), guarantee equity in infrastructure and connectivity with priority for rural areas (art. 5) and regulate the law within six months (art. 14). It creates a National Digital Education Commission and an Observatory (arts. 7 to 9). It is a law about <em>what is taught</em> about AI; it does not regulate students' or teachers' use of AI, and a bill on responsible use is pending.</li>
<li><strong>Teacher training:</strong> MinTIC and Computadores para Educar opened in April 2026 the call "IAprende con sentido humano y territorial" for teachers and principals in public schools, with three levels and priority for rural areas and PDET municipalities. Check the current offer on the official pages.</li>
<li><strong>Personal data:</strong> Law 1581 of 2012 and its regulations protect personal data and set special rules for those of children and adolescents (the best-interest principle, art. 7, as interpreted by the Constitutional Court). The practical rule: <strong>do not paste into an AI tool data that identifies a student</strong> (name, ID number, diagnosis, grades, photos), unless the tool is contracted by the institution with the appropriate safeguards (see <a href="/herramientas/piar/">PIAR with AI</a>, designed with that restriction in mind).</li>
<li><strong>European Union:</strong> the AI Act classifies certain educational uses as <em>high-risk</em> (admission, evaluating learning outcomes, assigning level and monitoring exams), bans emotion inference in educational institutions and requires AI literacy from those who use these systems; check the application timeline. It is a reference for what is considered sensitive.</li>
</ul>

<h2>How much AI each task allows: a five-level scale</h2>
{{img:niveles}}
<p>Instead of banning or allowing "AI" in general, decide <strong>per task</strong>, according to what the task wants to assess. A useful scale is the <em>AI Assessment Scale</em> by Leon Furze, Mike Perkins, Jasper Roe and Jason MacVaugh, of which several versions exist. Its first version has five levels: <strong>1) no AI</strong> (supervised task, to assess knowledge and understanding); <strong>2) brainstorming</strong> (AI helps generate ideas at the start); <strong>3) outlines and notes</strong> (AI organizes and outlines; the writing is the student's own); <strong>4) feedback and editing</strong> (AI comments and suggests edits; the ideas are the student's own); and <strong>5) full AI</strong> (AI generates everything and what is assessed is what is done with it: verifying, critiquing, improving). It has limits (later versions change the levels) and its value is that it forces a decision.</p>
<p>The <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">Excel workbook</a> turns the scale into a matrix. For each task you record the <strong>objective it assesses</strong> (base knowledge, own writing and reasoning, ideas and understanding, or skill in using AI), the <strong>AI level allowed</strong>, whether <strong>use disclosure</strong> is requested and whether there is <strong>process evidence</strong>. The workbook compares the level with the maximum recommended for that objective and flags misaligned tasks, those that allow AI without asking for disclosure and those that leave no process evidence.</p>
<pre><code>' Maximum recommended level by objective (table in Parametros!A12:B15)
=VLOOKUP(C4,Parametros!$A$12:$B$15,2,FALSE)                                          ' English
=BUSCARV(C4;Parametros!$A$12:$B$15;2;FALSO)                                         ' Spanish

' Alignment between the level allowed (D) and the recommended maximum (G)
=IF(D4>G4,"Desalineada: permite más IA de la que admite el objetivo","Alineada")      ' English
=SI(D4>G4;"Desalineada: permite más IA de la que admite el objetivo";"Alineada")     ' Spanish

' Missing disclosure request? (level 2 or more and no disclosure)
=IF(AND(D4>=2,E4="No"),"Falta pedir que se declare el uso","")                        ' English
=SI(Y(D4>=2;E4="No");"Falta pedir que se declare el uso";"")                         ' Spanish</code></pre>
<p>With the <strong>twelve fictional tasks</strong> of a grade 9 science course: 3 tasks with no AI (level 1), 2 at level 2, 3 at level 3, 3 at level 4 and 1 full-AI; that is, <strong>9 of 12 (75%) allow some AI use</strong>. The workbook detects <strong>2 misaligned tasks</strong> (an argumentative essay that allows AI editing when the student's own writing is meant to be assessed, and a calculation exercise task, meant for base knowledge, that allows outlines and notes with AI), <strong>2 tasks with AI that do not ask for disclosure</strong> and <strong>5 tasks with AI and no process evidence</strong>. It is a design diagnosis, not a diagnosis of people: fixing the task is more effective than chasing the student.</p>

<h2>What to do about AI detectors</h2>
<p>AI-generated text detectors are not a reliable basis for sanctions. A study published in <em>Patterns</em> (Liang and colleagues, 2023) found that several detectors wrongly classified as AI-generated the texts of people who write English as a second language, and the companies themselves have acknowledged limitations. An "AI probability" percentage is not proof, least of all for minors; if a case requires it, it is better to have a conversation with the student, process evidence (drafts, logs, notes) and a brief oral assessment, always within due process under the coexistence manual and the assessment system.</p>

<h2>Uses that do help (and how to protect learning)</h2>
<ul>
<li><strong>For teachers:</strong> preparing lessons and exercise variants, drafting initial feedback that is then reviewed, adapting materials to different reading levels, generating practice questions (see the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>) and planning reasonable adjustments for students with disabilities (see <a href="/herramientas/piar/">PIAR with AI</a>), always with human review. It is the lowest-risk, highest time-saving use.</li>
<li><strong>For students:</strong> using AI as a <em>tutor that asks</em> (asking it to pose questions, explain why an answer is wrong or test an explanation) instead of as a solver. A simple rule: <em>I try first; then I consult; then I explain in my own words</em>.</li>
<li><strong>For principals:</strong> agreeing common rules by level and task type, avoiding each teacher having a different rule (see <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">the mirage of AI in higher education</a>, in Spanish, which shows the cost of improvisation), training teachers and making clear which tools are approved and with what data.</li>
<li><strong>For families:</strong> knowing that AI use at home also forms habits; accompanying without solving, asking the child to explain what was handed in and protecting personal data.</li>
</ul>

<h2>Risks to manage</h2>
<ul>
<li><strong>Errors and "hallucinations":</strong> generative AIs produce plausible text that may be false, with invented citations. Teach verifying against sources (see <a href="/inteligencia-artificial-cuantica-aplicaciones-limites/">critical reading of quantum AI claims</a>, which applies an evidence-level framework).</li>
<li><strong>Dependence and metacognitive laziness:</strong> delegating thinking reduces the practice of retrieving, explaining and correcting (see the evidence above).</li>
<li><strong>Bias and homogenization:</strong> models reproduce biases from their data and tend to produce answers similar to one another; also mind the equity gap: whoever has the better tool and better judgment benefits more.</li>
<li><strong>Privacy:</strong> it is the easiest risk to avoid and the hardest to repair. Minors' data stay out.</li>
<li><strong>Academic integrity:</strong> handled through task design, disclosure of use, process evidence and oral assessment, not detectors.</li>
</ul>

<h2>Implementation plan for a school (60 days)</h2>
{{img:pasos}}
<ol>
<li><strong>Weeks 1-2, diagnosis:</strong> who uses what, for what and with what data? (teachers, students and families; a short anonymous survey).</li>
<li><strong>Weeks 3-4, agreements:</strong> per-task level scale, use-disclosure rule, list of approved tools and data rule. It should go through the academic council and tie in with the assessment system and the coexistence manual.</li>
<li><strong>Weeks 5-6, pilot:</strong> each teacher in one area reviews three tasks with the matrix and adjusts the design.</li>
<li><strong>Weeks 7-8, communication and training:</strong> a session with families, guidelines for students and a teacher training space (Law 2626's mandatory training is an opportunity).</li>
<li><strong>Afterwards, review:</strong> each term, look at which tasks remain misaligned, what incidents occurred and what was learned.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Colombia combines a recent law about <em>what to teach</em> about AI with gaps about <em>how to use it</em> in the classroom: there is not yet a rule regulating use by students and teachers, so decisions fall to each school (hence the importance of institutional policies). Meanwhile, the access gap matters more than any integrity debate: Law 2626 itself prioritizes rural connectivity. Worldwide, things move in two directions: frameworks that set minimum ages and risks (UNESCO, the European Union) and systems that leave the decision to institutions. The evidence, for now, supports the OECD's selective caution more than prohibition or mass adoption.</p>
<p>For <strong>teachers</strong>, the challenge is time and judgment; for <strong>principals</strong>, agreeing rules and protecting data; for <strong>families</strong>, accompanying without solving; and for <strong>students</strong>, understanding that the task's goal is what they learn, not the file they hand in.</p>

<h2>Tools and templates</h2>
<p>These tools of our own apply the guide's principles: they help prepare material with human review and are designed not to expose student data.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">the AI-use-per-task matrix workbook</a>, <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel with artificial intelligence</a>, <a href="/las-matematicas-estan-a-punto-de-morir-openai-372-resultados-verificacion-lean/">is math dying? OpenAI's 372 results</a> and the <a href="/herramientas/piar/">PIAR with AI</a> tool.</p>

<h2>Sources consulted (October 10, 2026)</h2>
<ul>
<li><strong>UNESCO (2023),</strong> <em>Guidance for generative AI in education and research</em>, September 7, 2023, and <em>AI competency framework for teachers</em> (2024).</li>
<li><strong>Congress of Colombia,</strong> <a href="https://www.alcaldiabogota.gov.co/sisjur/normas/Norma1.jsp?i=194142&amp;dt=S">Law 2626 of 2026</a> (text from Bogotá's Legal Regime, read in full); <strong>MinTIC and Computadores para Educar,</strong> call "IAprende con sentido humano y territorial" (April 2026).</li>
<li><strong>Bastani et al. (2025),</strong> "Generative AI without guardrails can harm learning: Evidence from high school mathematics", <em>PNAS</em> 122(26); <strong>Kestin, Miller, Klales, Milbourne and Ponti (2025),</strong> study on an AI tutor in physics, <em>Scientific Reports</em> (timing figures come from summaries; check the paper); <strong>OECD (2026),</strong> <a href="https://www.oecd.org/en/publications/oecd-digital-education-outlook-2026_062a7394-en.html">Digital Education Outlook 2026</a> (I could not open the page; I summarize from its public summaries).</li>
<li><strong>Perkins, Furze, Roe and MacVaugh (2024),</strong> "The Artificial Intelligence Assessment Scale (AIAS)", <em>Journal of University Teaching and Learning Practice</em> 21(6); <a href="https://leonfurze.com/2023/12/18/the-ai-assessment-scale-version-1/">first version of the scale</a> (Leon Furze's blog); <strong>Liang et al. (2023),</strong> "GPT detectors are biased against non-native English writers", <em>Patterns</em>.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Should AI be banned in school?</h3>
<p>The available evidence supports neither a blanket ban nor uncritical adoption. It is recommended to decide per task, according to what is to be assessed, and to protect students' data.</p>
<h3>What minimum age is there for using AI?</h3>
<p>UNESCO proposed considering 13 as a minimum age for autonomous classroom use; it is a recommendation and each tool's terms of use may set others. In Colombia there is not yet a specific rule.</p>
<h3>Do AI detectors work?</h3>
<p>Not as proof. They have errors and biases; it is better to combine task design, process evidence and conversation.</p>
<h3>What data should I not put into an AI?</h3>
<p>Names, ID numbers, diagnoses, grades, photos or any data that identifies a student, unless the institution has a tool contracted with safeguards.</p>
<h3>How do I use the workbook?</h3>
<p>List your tasks, the objective each assesses, the AI level you allow, whether you ask for disclosure and whether there is process evidence; the workbook flags misalignments and gaps.</p>

<p class="notice"><strong>Review your own tasks.</strong> Download the <a href="/descargas/ia-en-educacion/matriz-uso-ia-por-tarea.xlsx">AI-use-per-task matrix workbook</a> (in Spanish), replace the fictional tasks with yours and see how many are misaligned with their objective.</p>

<h2>Food for thought</h2>
<p>Every task we design answers, even if we do not say it, a question: what do I want the student to be able to do without me and without the machine? <strong>How many of your current tasks could you explain with that question? And if students could use an AI for everything, what part of your class would remain impossible to delegate, and why is it worth protecting?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:evidencia}}' => $img('ia-en-educacion-evidencia', 444, 'Table with three studies on AI and learning: Bastani et al. 2025, Kestin et al. 2025 and the OECD 2026, with what they compared and the result.', 'Performing better is not learning better.'),
    '{{img:niveles}}' => $img('ia-en-educacion-niveles', 480, 'Bar chart of the number of tasks in a fictional course at each AI-use level: 3, 2, 3, 3 and 1 tasks at levels 1 to 5.', 'How much AI each task allows (fictional example).'),
    '{{img:pasos}}' => $img('ia-en-educacion-pasos', 467, 'Five steps to decide before adopting an AI tool: objective, level, data, evidence and review.', 'Five steps to decide with judgment.'),
]);

return [
    'guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel' => [
        'slug' => 'guide-artificial-intelligence-in-education-evidence-colombia-rules-excel-matrix',
        'title' => 'A Guide to Using Artificial Intelligence in Education: What Works, What Does Not and How to Decide Task by Task, with an Excel Workbook',
        'excerpt' => 'A guide to deciding on AI use in the classroom: what the evidence says (learning is not performing), the framework in Colombia (Law 2626 of 2026) and the world, a five-level per-task scale, risks and a 60-day plan, with an Excel workbook.',
        'seo_title' => 'Guide to Using AI in Education: Evidence and Rules',
        'seo_description' => 'Guide to using AI in education: what the evidence says, Colombia\'s Law 2626 of 2026, how much AI each task allows and an Excel workbook for your school.',
        'focus_keyword' => 'using AI in education',
        'cover' => '/assets/img/articulos/ia-en-educacion/ia-en-educacion-portada-en',
        'cover_alt' => 'Cover "A guide to using AI in education: what works, what does not and how to decide" with a card: −17% on the AI-free exam for those who practiced with a hint-free chatbot (PNAS, 2025).',
        'content_html' => $html,
    ],
];
