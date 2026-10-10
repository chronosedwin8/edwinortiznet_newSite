<?php

declare(strict_types=1);

// English version of «Aprender a aprender: saber lo que se sabe, estudiar con lo que funciona y repasa…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/aprender-a-aprender/' . $name . '-en';
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
<p>The night before the exam, a student spends three hours rereading her notes, highlighting in colors and copying a summary. She leaves calm: "I know it". The next day she scores 38 on the topic she studied most. It was not laziness or lack of time; it was something subtler: <strong>she studied with techniques that give a feeling of learning, and believed she knew what she did not</strong>. It is one of the most frequent situations in school, and rarely is anyone taught to avoid it.</p>
<p>This article analyzes what <strong>learning to learn</strong> means: knowing precisely what you know (calibration), choosing study techniques with the best evidence and spreading study over time. It includes an <a href="/descargas/aprender-a-aprender/aprender-a-aprender-calibracion-tecnicas-plan.xlsx">Excel workbook</a> (in Spanish) for one student, with three sheets (calibration, techniques and spaced review plan) and fictional data, verified in Microsoft Excel 16 and against an independent calculation. Sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional and the workbook is a reflection tool, not a diagnosis. Evidence on study techniques comes mostly from cognitive psychology research, with specific tasks and populations, and its conclusions depend on context, age and content. No technique guarantees a result, and difficulty studying may also have causes that are not about method (sleep, health, anxiety, conditions at home or learning barriers).</p>

<h2>Three ideas behind "learning to learn"</h2>
<ol>
<li><strong>Metacognition:</strong> thinking about one's own learning: what I know, what I do not, what strategy I am using and whether it is working. The Education Endowment Foundation (EEF, UK) Teaching and Learning Toolkit places metacognition and self-regulation among the highest-impact, low-cost approaches, with an estimated average effect of around +7 months of additional progress in its latest version (the figure changes as the Toolkit is updated and is an average, not a guarantee).</li>
<li><strong>Strategies with the best evidence:</strong> the review by Dunlosky, Rawson, Marsh, Nathan and Willingham (2013, <em>Psychological Science in the Public Interest</em>, 14(1), 4-58) evaluated ten techniques. They rated <strong>high utility</strong> for <em>practice testing</em> (self-quizzing with questions, flashcards or problems) and <em>distributed practice</em> (spreading study over time); <strong>moderate utility</strong> for elaborative interrogation, self-explanation and interleaved practice; and <strong>low utility</strong> for summarizing, highlighting and rereading, precisely some of the techniques students use most.</li>
<li><strong>Self-regulation:</strong> planning, monitoring and adjusting one's own study, including motivation and emotions. It is not just about techniques, but about the decision to use them when they take effort.</li>
</ol>
{{img:tecnicas}}
<p>An important nuance: "low utility" does not mean rereading is useless, but that, compared with other techniques, it yields less per time invested and produces an <strong>illusion of fluency</strong>: the text feels familiar and that is mistaken for knowing it. Practice testing is uncomfortable precisely because it shows what you do not know.</p>

<h2>The Excel workbook</h2>
<ul>
<li><strong>Calibracion:</strong> ten topics with what the student thought they knew (prediction, in %), what they scored and the <strong>gap</strong>. The reading is "Sobreestima" (overestimates) if the gap exceeds the margin (10 points in the example), "Subestima" (underestimates) if it is below the negative margin and "Calibrado" (calibrated) otherwise.</li>
<li><strong>Tecnicas:</strong> a week's study minutes per technique, with each one's utility according to the Dunlosky et al. review.</li>
<li><strong>Plan:</strong> six spaced review sessions, with editable days before the assessment, the resulting dates, the day of the week, the gap between sessions and whether they fall on a weekend.</li>
<li><strong>Resumen:</strong> the key indicators.</li>
</ul>
<pre><code>' Gap between what they thought they knew and what they scored, and its reading (margin in Parametros!B3)
=B4-C4
=IF(D4>Parametros!$B$3,"Sobreestima",IF(D4<-Parametros!$B$3,"Subestima","Calibrado"))   ' English
=SI(D4>Parametros!$B$3;"Sobreestima";SI(D4<-Parametros!$B$3;"Subestima";"Calibrado"))   ' Spanish

' Share of time on low-utility techniques (minutes in C, utility in B, total in B11)
=SUMIF(Tecnicas!B4:B9,"Baja",Tecnicas!C4:C9)/B11       ' English
=SUMAR.SI(Tecnicas!B4:B9;"Baja";Tecnicas!C4:C9)/B11    ' Spanish

' Date of a review session: the assessment minus the days of advance
=Parametros!$B$4-B4</code></pre>

<h2>What the example showed (fictional data)</h2>
{{img:minutos}}
<p>A student with an assessment on April 15, 2027:</p>
<ul>
<li><strong>Calibration:</strong> on 5 of 10 topics she overestimated her mastery by more than 10 points, on 5 she was calibrated and on none did she underestimate. The average gap was <strong>11.9 points</strong>, and the largest, <strong>37 points</strong> on topic 6 (she thought she knew 75%, scored 38%).</li>
<li><strong>The prediction barely guides:</strong> the correlation between what she predicted and what she scored was 0.38. In other words, her feeling of confidence did not distinguish well the topics she mastered from those she did not.</li>
<li><strong>Techniques:</strong> of 690 study minutes in the week, <strong>73.9% went to low-utility techniques</strong> (rereading 240, highlighting 150, summarizing 120), 13.0% to high-utility techniques (practice testing, 90 minutes) and 13.0% to moderate-utility ones.</li>
<li><strong>Spaced plan:</strong> six sessions at 35, 21, 14, 7, 5 and 1 days before, with gaps of 14, 7, 7, 2 and 4 days. One falls on a Saturday (April 10). The first session starts five weeks before, not the night before.</li>
</ul>
<p><strong>An honest reading:</strong> with ten topics, a correlation of 0.38 is only a hint, not a reliable measure. Overestimation is not a character flaw: it is common and is corrected with practice and immediate feedback (if I never test myself, I never find out what I do not know). A nice plan does not guarantee it will be followed either: the value is in reviewing it with the student and adjusting it.</p>

<h2>How to teach it in the classroom</h2>
<ol>
<li><strong>Ask for a prediction before each assessment</strong> ("what percentage do you think you will get on each topic?") and compare it with the result. Do it privately and without grading the prediction.</li>
<li><strong>Turn studying into questions:</strong> flashcards, exercises without looking at the material, questions the student writes and asks themself. Frequent low-stakes quizzes in class teach the technique and strengthen memory (see <a href="/analisis-de-items-excel-dificultad-discriminacion-distractores-kr20-libro/">item analysis</a> to review question quality).</li>
<li><strong>Spread content over time:</strong> revisit earlier topics in each unit rather than closing and forgetting them (see <a href="/transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla/">transfer of learning</a>).</li>
<li><strong>Teach the techniques explicitly,</strong> with examples from your own subject: how to do a good self-quiz in math, in science, in language.</li>
<li><strong>Use errors as information,</strong> not as punishment (see <a href="/error-revela-como-piensa-estudiante-ideas-previas-ciencias-preguntas-diagnostico/">the error as a window into thinking</a>) and give feedback that points to the next step (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a>).</li>
<li><strong>Look after those who cannot:</strong> if a student cannot get organized, ask whether there are barriers (attention, reading, anxiety, sleep, conditions at home) and lean on guidance counselors (see <a href="/herramientas/piar/">PIAR with AI</a> for students with reasonable adjustments).</li>
</ol>
<p><strong>And with AI:</strong> an AI assistant can help generate self-quiz questions or explain a topic, but it can also solve the task for the student and remove precisely the effort of retrieving information, which is what produces learning. It is best to teach using it to <em>practice</em> (asking it to quiz you) and not to <em>replace</em> studying, and to verify what it answers.</p>

<h2>Colombia, Latin America and the world</h2>
<p>"Learning to learn" appears in educational frameworks worldwide: the European Union, for example, included the "personal, social and learning to learn" competence among its key competences for lifelong learning in its 2018 recommendation (check the current text). In Colombia and Latin America, external assessments and access to higher education lead many students to prepare for exams with repetition and cramming techniques, and curricula mention autonomy but rarely teach study techniques explicitly. Research on these techniques comes mostly from high-income countries; applying it in our contexts requires adaptation and local evidence.</p>
<p>For <strong>teachers</strong>, the challenge is devoting class time to teaching how to study; for <strong>principals</strong>, including it in the classroom plan and teacher training; for <strong>families</strong>, understanding that "studying many hours" is not the same as studying well, and that helping is not solving; and for <strong>students</strong>, that getting something wrong in practice is the best news before an exam, not a defeat.</p>

<h2>Tools and templates</h2>
<p>To plan practice and self-assessment activities, rubrics and feedback, and to organize your resources with AI (always reviewing what it produces and without including student data in tools not designed to safeguard it), look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: the <a href="/descargas/aprender-a-aprender/aprender-a-aprender-calibracion-tecnicas-plan.xlsx">learning to learn workbook</a>, <a href="/argumentar-con-evidencia-ensenar-afirmacion-razonamiento-contraargumento-rubrica-excel/">arguing from evidence</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Frequently asked questions</h2>
<h3>What does learning to learn mean?</h3>
<p>Knowing how one learns and being able to regulate one's own learning: calibrating what you know, choosing and using good study strategies and adjusting them according to results.</p>
<h3>Which study techniques work best?</h3>
<p>According to the Dunlosky et al. review (2013), practice testing (self-quizzing) and distributed practice (spaced reviews) had high utility; rereading, highlighting and summarizing, low. It depends on context.</p>
<h3>Why do students overestimate what they know?</h3>
<p>Because the familiar is mistaken for the known (the illusion of fluency), and because without self-testing they get no evidence of what they do not know.</p>
<h3>How many review sessions should I plan?</h3>
<p>There is no single figure; what matters is spreading study across several sessions before the assessment instead of concentrating it the night before. The workbook uses six as an example.</p>
<h3>How do I use the workbook?</h3>
<p>Enter what you think you know per topic and what you score, the minutes per technique and the days before the assessment for each session; the workbook calculates the gaps, percentages and dates.</p>

<p class="notice"><strong>Try it before your next exam.</strong> Download the <a href="/descargas/aprender-a-aprender/aprender-a-aprender-calibracion-tecnicas-plan.xlsx">learning to learn workbook</a> (in Spanish), write down your prediction per topic before the exam and your result after, and plan review sessions weeks ahead.</p>

<h2>Food for thought</h2>
<p>Studying with more demanding techniques feels worse: it takes more effort, makes mistakes visible and leaves less peace of mind. <strong>What would we do differently in the classroom if students knew that feeling difficulty while studying is usually a good sign? And how would grading change if we valued the ability to know what you know as much as the right answer?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tecnicas}}' => $img('aprender-a-aprender-tecnicas', 499, 'Table with four groups of study techniques and their utility according to Dunlosky et al.: practice testing, spaced practice, self-explanation and interleaving, and rereading, highlighting and summarizing.', 'What the Dunlosky et al. review says.'),
    '{{img:minutos}}' => $img('aprender-a-aprender-minutos', 524, 'Bar chart of study minutes in one week per technique: rereading 240, highlighting 150, summarizing 120, practice testing 90, self-explanation 60 and interleaving 30.', 'Study minutes per technique in a week.'),
]);

return [
    'aprender-a-aprender-calibracion-tecnicas-de-estudio-repaso-espaciado-libro-excel' => [
        'slug' => 'learning-to-learn-calibration-study-techniques-spaced-review-excel-workbook',
        'title' => 'Learning to Learn: Knowing What You Know, Studying with What Works and Reviewing in Time, with an Excel Workbook',
        'excerpt' => 'What learning to learn is: calibration, study techniques with the best evidence (practice testing and spaced practice) and how to teach it, with a three-sheet Excel workbook for the student.',
        'seo_title' => 'Learning to Learn: Calibration and Study Techniques',
        'seo_description' => 'What learning to learn is: calibrating what you know, study techniques with evidence (practice testing, spaced review) and an Excel workbook for the student.',
        'focus_keyword' => 'learning to learn',
        'cover' => '/assets/img/articulos/aprender-a-aprender/aprender-a-aprender-portada-en',
        'cover_alt' => 'Cover "Learning to learn: know what you know and study with what works" with a card: 11.9 points of average overestimation between what the student thought they knew and what they scored.',
        'content_html' => $html,
    ],
];
