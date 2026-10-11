<?php

declare(strict_types=1);

// English version of «Actividades con IA para cada nivel de la taxonomía de Bloom: un banco de 36, sei…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/bloom-ia/' . $name . '-en';
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
<p>It is Sunday night and you are planning the week. On the staff room wall there is a poster of Bloom's taxonomy: a pyramid with colored verbs. You know you should design activities that reach "analyze", "evaluate" and "create", and not only "remember". You open ten tabs, search "Bloom activities for science", find generic lists and at eleven at night you are still with the same old exercise. <strong>Using Bloom should not mean spending hours searching for ideas.</strong> And artificial intelligence, well used, can save exactly that time, as long as the pedagogical decision stays yours.</p>
<p>This article does three things. First, it explains rigorously what the revised Bloom's taxonomy is (and is not). Second, it offers a <strong>bank of 36 AI activities</strong>, six per level, each with what the AI does, what the student does, the minutes, the AI's role, the AI use level on the per-task scale (see <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">the guide to using AI in education</a>, in Spanish), the risk and the evidence it leaves. Third, it delivers six <strong>prompt templates</strong> and an <a href="/descargas/bloom-ia/banco-bloom-actividades-con-ia.xlsx">Excel workbook</a> (in Spanish) with the bank and a unit planner that counts coverage by level and higher-order minutes, verified in Microsoft Excel 16 and against an independent calculation. Sources reviewed on <strong>October 10, 2026</strong>.</p>
<p class="notice"><strong>Warning.</strong> The activities are design proposals, not a curriculum: adjust them to your area, your group and your assessment system. AI can be wrong and produce material with errors: <strong>review everything it generates before using it with students</strong> and do not enter personal data of minors. The planner's data are an example.</p>

<h2>What Bloom's taxonomy is (and is not)</h2>
{{img:niveles}}
<p>In 1956, a group of university examiners led by Benjamin Bloom proposed a classification of educational objectives in the cognitive domain. In 2001, Lorin Anderson and David Krathwohl published a revision (summarized by Krathwohl in 2002, <em>Theory Into Practice</em>, 41(4), 212-218) that changed nouns to verbs and reordered the levels: <strong>remember, understand, apply, analyze, evaluate and create</strong> (in the original, "synthesis" came before "evaluation"). It is a design tool: it helps you ask, when planning, <em>what kind of thinking this activity requires</em>.</p>
<p>It is worth knowing its limits, which the literature itself points out:</p>
<ul>
<li><strong>It is not a strict hierarchy.</strong> Critical reviews (for example, a 2020 <em>Frontiers in Education</em> article and a 2022 <em>CBE-Life Sciences Education</em> one) recall that empirical evidence for its cumulative hierarchical structure is weak and that understanding can arise from analysis and application, not just precede them. Most complex tasks combine several levels.</li>
<li><strong>"Higher" does not mean "better".</strong> Remembering is not a minor level: retrieval practice (self-quizzing, flashcards) is among the study techniques with the highest utility according to the 2013 Dunlosky et al. review (see <a href="/aprender-a-aprender-calibracion-tecnicas-de-estudio-repaso-espaciado-libro-excel/">learning to learn</a>). A good unit uses all levels.</li>
<li><strong>The verbs are ambiguous.</strong> "Analyze" can be a deep task or a mechanical exercise depending on content and instructions; what counts is what the student does.</li>
<li><strong>It is not a Colombian regulation.</strong> The references for planning are the Basic Competency Standards, the Basic Learning Rights, the institutional project and the assessment system; Bloom helps design, it does not replace those frameworks.</li>
</ul>

<h2>What AI can do here (and what it cannot)</h2>
<p>AI is good at generating <em>draft material</em> in seconds: practice questions, examples and non-examples, exercise variants, contexts close to the student, texts with deliberate errors to detect. It is poor as a quality judge: it can produce badly posed exercises, questions with two correct answers, invented data or false "facts". So the rule is: <strong>AI proposes, you decide and verify</strong>. And a second rule, which comes from the evidence (see the guide): in activities where the student uses AI, let it be more a <em>tutor that asks</em> or an <em>object of analysis</em> than a <em>solver</em>. That is why the bank includes each activity's <em>AI role</em> and <em>AI use level</em>.</p>

<h2>How to prepare an activity in minutes</h2>
{{img:pasos}}
<p>The method fits in five steps: decide <strong>which Bloom level</strong> you aim at, pick an activity from the bank, set <strong>how much AI</strong> it allows (per the guide's scale), ask for the material with a prompt and <strong>review it</strong>, and define what <strong>evidence</strong> the process will leave. With the bank and templates, preparing an activity goes from an hour to a few minutes plus review.</p>
<h2>The bank: six activities per level</h2>
<p>The full workbook has all 36 with their details. Here, some from each level (minutes are an estimate for a typical group):</p>
<h3>Remember</h3>
<ul>
<li><strong>Retrieval practice with flashcards (15 min).</strong> AI generates 20 practice questions from the student's notes; they answer without looking and repeat what they missed.</li>
<li><strong>Quiz in equivalent versions (10 min).</strong> The teacher creates three versions of the same quiz with AI and gives it in class without AI.</li>
<li><strong>Spaced review calendar (15 min).</strong> AI builds the calendar before the assessment; the student adjusts it and follows it.</li>
</ul>
<h3>Understand</h3>
<ul>
<li><strong>Explain it to a 10-year-old (20 min).</strong> AI plays a child who asks questions; the student explains in their own words.</li>
<li><strong>My summary versus the AI's (25 min).</strong> The student writes theirs first and compares what was lost in each.</li>
<li><strong>Examples and non-examples (20 min).</strong> AI gives three and three; the student classifies and justifies.</li>
</ul>
<h3>Apply</h3>
<ul>
<li><strong>Problems with local context (25 min).</strong> AI generates problems with regional contexts; the teacher reviews them before use.</li>
<li><strong>Graded exercises with hints (20 min).</strong> Five exercises of increasing difficulty and staged hints the student uses only if needed.</li>
<li><strong>Predictions before the experiment (30 min).</strong> AI asks the student to predict the result before doing it and compares afterwards.</li>
</ul>
<h3>Analyze</h3>
<ul>
<li><strong>Find the error (25 min).</strong> AI writes an explanation with three subtle errors (the teacher reviews it first); students find them.</li>
<li><strong>Verify the sources (30 min).</strong> AI lists sources for a claim; the student checks which exist and what they really say (a way of teaching the risk of "hallucinations").</li>
<li><strong>The chart that distorts (25 min).</strong> Three charts of the same dataset; the student decides which distorts.</li>
</ul>
<h3>Evaluate</h3>
<ul>
<li><strong>Judges with a rubric (25 min).</strong> The student grades an AI-generated answer with a rubric and justifies.</li>
<li><strong>Feedback on my draft (25 min).</strong> AI comments; the student decides what to accept and why, and logs it in a notebook.</li>
<li><strong>Is the summary faithful? (25 min).</strong> Contrast an AI summary with the original text.</li>
</ul>
<h3>Create</h3>
<ul>
<li><strong>An exam for classmates (40 min).</strong> Students design questions and an answer key; AI reviews clarity.</li>
<li><strong>A tutor that does not give the answer (45 min).</strong> They design a prompt that teaches without solving and test it; high risk because it takes judgment not to hand over the solution.</li>
<li><strong>A project with a prompt log (45 min).</strong> AI assists in bounded tasks and the student documents each use.</li>
</ul>

<h2>Six prompt templates (to ask for the material in a minute)</h2>
<p>Copy, change what is in brackets and review the result. Avoid pasting student data and verify the content:</p>
<pre><code>1. Remember: "Create 15 retrieval practice questions about [topic] for [grade], short-answer, with the correct answer at the end. Avoid yes/no questions."

2. Understand: "Act as a curious 10-year-old. Ask me questions, one at a time, about [concept], and ask me to explain it another way if you do not understand."

3. Apply: "Create 5 problems on [topic] with a [region or situation] context, of increasing difficulty, and for each two staged hints. Do not give the full solution."

4. Analyze: "Write an explanation of [topic] for [grade] with exactly 3 subtle errors. Give me separately a list of the errors and their correction."

5. Evaluate: "Generate a [medium]-level answer to this question: [question]. Then propose a 4-criterion rubric to evaluate it."

6. Create: "Help me review the clarity of these 8 exam questions I wrote: [questions]. Point out ambiguities, but do not rewrite them."</code></pre>

<h2>The Excel workbook: bank and planner</h2>
<ul>
<li><strong>Niveles:</strong> the six levels with typical verbs, guiding question and whether they count as higher-order thinking (analyze, evaluate and create).</li>
<li><strong>Banco:</strong> the 36 activities, with filters by level, AI role, AI use level and risk.</li>
<li><strong>Plan:</strong> you type the IDs of the activities you chose for a unit (up to 15) and the workbook brings the level, minutes, AI use level and risk.</li>
<li><strong>Resumen:</strong> how many activities there are per level, which levels are missing, the minutes and share of higher order, the high-risk ones and those with AI use at level 4 or 5.</li>
</ul>
<pre><code>' Bring the minutes of an activity by its ID (ID in B4, bank in A:F)
=IF(B4="","",INDEX(Banco!$F$4:$F$39,MATCH(B4,Banco!$A$4:$A$39,0)))           ' English
=SI(B4="";"";INDICE(Banco!$F$4:$F$39;COINCIDIR(B4;Banco!$A$4:$A$39;0)))     ' Spanish

' Higher-order minutes and their share
=SUMIF(Plan!H4:H18,"Sí",Plan!E4:E18)           ' English
=SUMAR.SI(Plan!H4:H18;"Sí";Plan!E4:E18)       ' Spanish
=B13/B5</code></pre>
{{img:plan}}
<p>With the <strong>example plan of 8 activities</strong> (RE1, CO4, AP1, AP3, AN2, AN6, EV2 and CR6): 205 minutes in total; one remember activity, one understand, two apply, two analyze, one evaluate and one create, that is, <strong>all six levels covered</strong>; 125 minutes (<strong>61%</strong>) at higher-order levels; <strong>1 high-risk activity</strong> (the tutor that does not give the answer) and <strong>4 with AI use at level 4 or 5</strong>, which are worth reviewing with the AI-use-per-task matrix. <strong>An honest reading:</strong> the higher-order percentage is not a goal (more is not better), just a mirror: if your unit is 90% remember or 90% create, it is worth asking why.</p>

<h2>Seven frequent mistakes</h2>
<ol>
<li><strong>Turning Bloom into a list of verbs</strong> and changing the verb in the prompt without changing what the student does.</li>
<li><strong>Believing that higher is better</strong> and abandoning retrieval practice.</li>
<li><strong>Using the AI's material without reviewing it.</strong></li>
<li><strong>Letting the student use AI as a solver</strong> in activities that seek understanding.</li>
<li><strong>Not setting the AI use level</strong> of the activity or asking for it to be disclosed.</li>
<li><strong>Copying activities without adapting them</strong> to the area, group and context.</li>
<li><strong>Not leaving evidence of the process</strong> (logs, drafts, predictions), which is what makes assessment possible and protects against impersonation.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, classroom planning ties in with the Basic Competency Standards, the Basic Learning Rights, the institutional project's curriculum maps and the Student Assessment System (see <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">the SIEE and Decree 1290</a>, in Spanish); Bloom is widely used in teacher training and objective design, although it is not part of the regulation. Law 2626 of 2026 incorporates AI into the technology and informatics subject, and will require teacher training, an opportunity to integrate these activities. Worldwide, Bloom's taxonomy and its versions are taught in teacher training in many countries, and its relevance versus newer approaches is debated; the practical consensus is to use it as a flexible guide, not a dogma.</p>
<p>For <strong>teachers</strong>, the challenge is time: a bank and templates reduce it; for <strong>principals</strong>, agreeing on AI-use criteria and reviewing level coverage in lesson plans; for <strong>families</strong>, understanding that a student who "used AI" in an activity may be practicing analyzing or evaluating, not copying; and for <strong>students</strong>, that what counts is what they do with AI, not that AI does it for them.</p>

<h2>Tools and templates</h2>
<p>These tools of our own help turn a topic into classroom material with human review (without entering student data):</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/descargas/bloom-ia/banco-bloom-actividades-con-ia.xlsx">the bank and planner workbook</a>, <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">the guide to using AI in education</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Sources consulted (October 10, 2026)</h2>
<ul>
<li><strong>Anderson and Krathwohl (eds., 2001),</strong> <em>A Taxonomy for Learning, Teaching, and Assessing: A Revision of Bloom's Taxonomy of Educational Objectives</em>; <strong>Krathwohl (2002),</strong> "A Revision of Bloom's Taxonomy: An Overview", <em>Theory Into Practice</em> 41(4), 212-218.</li>
<li>Critiques and reviews: <a href="https://www.frontiersin.org/journals/education/articles/10.3389/feduc.2020.00107/pdf">Frontiers in Education (2020)</a> and <a href="https://www.lifescied.org/doi/10.1187/cbe.20-08-0170">CBE-Life Sciences Education (2022)</a> (I read their summaries in search; check the articles before citing).</li>
<li><strong>Dunlosky, Rawson, Marsh, Nathan and Willingham (2013),</strong> <em>Psychological Science in the Public Interest</em> 14(1), 4-58 (utility of retrieval practice); per-task AI use scale by <strong>Furze, Perkins, Roe and MacVaugh,</strong> in <a href="https://leonfurze.com/2023/12/18/the-ai-assessment-scale-version-1/">its first version</a>.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What is the revised Bloom's taxonomy?</h3>
<p>A classification of cognitive processes in six levels (remember, understand, apply, analyze, evaluate and create) for designing objectives and activities, revised by Anderson and Krathwohl in 2001.</p>
<h3>Do I have to use all levels in every class?</h3>
<p>Not necessarily; it is best for a unit to cover them coherently with its objectives.</p>
<h3>Can AI design my activities?</h3>
<p>It can propose drafts, but the pedagogical decision and verification are yours.</p>
<h3>How do I stop students from copying with AI?</h3>
<p>Set the activity's AI use level, ask them to disclose it, leave process evidence and prefer activities where AI is a tutor or object of analysis, not a solver.</p>
<h3>How do I use the workbook?</h3>
<p>Filter the bank by level, choose activities, type their IDs in the Plan sheet and look at coverage, minutes and risks.</p>

<p class="notice"><strong>Build your next unit.</strong> Download the <a href="/descargas/bloom-ia/banco-bloom-actividades-con-ia.xlsx">bank and planner workbook</a> (in Spanish), choose eight activities and see whether you cover all six levels.</p>

<h2>Food for thought</h2>
<p>Bloom's taxonomy reminds us that not all learning is repetition, but also that repetition has its place. <strong>At which Bloom level do your students spend most of their time today, and why? And if AI gave you back hours of preparation, in which activity of your class would you invest them so that what happens in the classroom is more human and not less?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:niveles}}' => $img('bloom-ia-niveles', 608, 'Table with the six levels of the revised Bloom\'s taxonomy, their typical verbs and guiding question: remember, understand, apply, analyze, evaluate and create.', 'Six levels, six guiding questions.'),
    '{{img:pasos}}' => $img('bloom-ia-pasos', 467, 'Five steps to prepare an AI activity: objective, activity, AI use, material and evidence.', 'Five steps to prepare the activity in minutes.'),
    '{{img:plan}}' => $img('bloom-ia-plan', 524, 'Bar chart of minutes per Bloom level in an example 205-minute plan: remember 15, understand 20, apply 45, analyze 55, evaluate 25 and create 45.', 'An example plan: 61% of the time at higher-order levels.'),
]);

return [
    'actividades-con-ia-taxonomia-de-bloom-banco-36-actividades-prompts-planificador-excel' => [
        'slug' => 'ai-activities-blooms-taxonomy-bank-of-36-activities-prompts-excel-planner',
        'title' => 'AI Activities for Every Level of Bloom\'s Taxonomy: A Bank of 36, Six Prompts and an Excel Planner So You Do Not Spend Hours Searching for Ideas',
        'excerpt' => 'What the revised Bloom\'s taxonomy is (and is not) and 36 AI activities, six per level, with the AI\'s role, minutes, risk and evidence; six prompt templates and an Excel planner that counts coverage by level.',
        'seo_title' => 'AI Activities for Every Bloom Level',
        'seo_description' => '36 AI activities for the six Bloom levels, with prompts, risks and evidence, and an Excel planner to cover every level of your unit.',
        'focus_keyword' => 'AI activities Bloom\'s taxonomy',
        'cover' => '/assets/img/articulos/bloom-ia/bloom-ia-portada-en',
        'cover_alt' => 'Cover "AI activities for every Bloom level, without hours spent searching for ideas" with a card: 36 activities, six for each level of the revised Bloom\'s taxonomy, with the AI\'s role and evidence.',
        'content_html' => $html,
    ],
];
