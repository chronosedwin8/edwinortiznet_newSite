<?php

declare(strict_types=1);

// English version of «El error matemático que se repite: cómo descubrir qué piensa el estudiante, con …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/error-matematico-repetido/' . $name . '-en';
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
<p>It is the third exam in which Valentina adds <code>1/2 + 1/3</code> and gets <code>2/5</code>. The teacher explained it last month and explained it again this week, in the same way, a little more slowly. Valentina nods. And on the next exam, <code>2/5</code> again. When an error repeats, there is almost always a deeper cause than a distraction: <strong>the student is applying a rule, only it is the wrong rule</strong>. Until it is discovered which one, explaining louder does not help.</p>
<p>This article proposes how to move from "they got it wrong" to "what are they thinking?", with a <strong>matrix of frequent errors</strong> (with their logic and an intervention), twelve diagnostic questions in which each wrong answer reveals a possible error and a sheet that reviews a group and detects who repeats the same error. It is all in a <a href="/descargas/errores-matematicos/matriz-errores-matematicos-diagnostico.xlsx">downloadable Excel workbook</a> (in Spanish), tested against an independent calculation. Data verified on October 10, 2026.</p>
<p class="notice"><strong>Summary.</strong> Repeated math errors are usually <strong>misconceptions with their own logic</strong>, not carelessness: treating a fraction as two loose numbers, comparing decimals as whole numbers, believing multiplication always makes things bigger. They are detected with questions designed so each distractor reveals an error, confirmed by asking the student how they thought and corrected with an intervention that attacks the wrong rule, not just the answer. The matrix's errors are <strong>hypotheses to explore</strong>, not diagnoses or labels on the student.</p>

<h2>What the research says</h2>
<p>There are decades of research on systematic errors in mathematics. A classic example is the <strong>natural number bias</strong> (<em>whole number bias</em>, a term popularized by Ni and Zhou, 2005): students apply to fractions and decimals the rules that work with whole numbers. One of its best-known manifestations is <strong>componential addition</strong> (adding numerators to numerators and denominators to denominators), which some reviews describe as the most frequent error in adding fractions.</p>
<p>The evidence is persistent. In a US national assessment of the early 1980s (Carpenter and colleagues), 13-year-olds were asked to estimate, without calculating, the sum <code>12/13 + 7/8</code>: most chose 19 or 21 (the sum of the numerators or of the denominators) and only 24% chose the correct answer, about 2. According to a review by Siegler and colleagues, an equivalent item given more than thirty years later gave similar results (27% correct). Sources differ on details of sample and year, so I take it as a sign: <strong>the error is old, common and does not disappear by itself over time.</strong></p>
<p>In Colombia, the context invites a careful look at foundational gaps: in PISA 2022, Colombia scored 383 points in mathematics (see <a href="/mejores-sistemas-educativos-del-mundo-colombia/">the world's best education systems compared with Colombia</a>). A score is a national average, but a foundational error that is dragged from grade to grade is one of the explanations a teacher can help close in the classroom.</p>

<h2>Errors with their own logic</h2>
{{img:logica}}
<p>The key of the approach is to assume the student <strong>is consistent</strong> with a rule, even a wrong one. Valentina does not add at random: she adds numerators and denominators because, with whole numbers, adding "the top with the top and the bottom with the bottom" would be natural. Correcting her error without changing that rule is like fixing a badly built spreadsheet by erasing the result: it reappears.</p>

<h2>The error matrix</h2>
<p>The "Matriz_de_errores" sheet gathers nine frequent errors. Each has its code, an example, <strong>the hypothesis of what the student might be thinking</strong>, a question to explore it and an intervention. A summary:</p>
<table>
<thead><tr><th>Code</th><th>Error</th><th>Hypothesis</th><th>How to explore it</th></tr></thead>
<tbody>
<tr><td>E1</td><td>1/2 + 1/3 = 2/5</td><td>Treats the fraction as two separate numbers</td><td>Place 1/2 and 1/3 on a number line and estimate the sum</td></tr>
<tr><td>E2</td><td>0.25 &gt; 0.3</td><td>Compares the digits as whole numbers (25 &gt; 3)</td><td>Place them on a 0-to-1 line; convert to hundredths</td></tr>
<tr><td>E3</td><td>8 × 0.5 = 40</td><td>Multiplication always enlarges</td><td>Should the result be greater or less than 8?</td></tr>
<tr><td>E4</td><td>8 + 4 = 12 + 5 → 17</td><td>The equals sign means "write the result"</td><td>Complete 8 + 4 = □ + 5 and explain the equals sign</td></tr>
<tr><td>E5</td><td>x + 3 = 7 → x = 10</td><td>Repeats "move it to the other side" without the inverse operation</td><td>Check by substituting x</td></tr>
<tr><td>E6</td><td>-(x - 2) = -x - 2</td><td>Applies the sign only to the first term</td><td>Replace x with a number and compare</td></tr>
<tr><td>E7</td><td>(a + b)² = a² + b²</td><td>The exponent distributes over the sum</td><td>Try a = 2, b = 3</td></tr>
<tr><td>E8</td><td>(a + b)/a = b</td><td>Cancels a letter that is not a common factor</td><td>Try (2 + 3)/2</td></tr>
<tr><td>E10</td><td>Up 20% and down 20%: back to the same</td><td>Ignores that each percentage starts from a different base</td><td>Calculate with a price of 100</td></tr>
</tbody>
</table>
<p>A valuable detail: almost all the ways to explore an error are <strong>numerical checks</strong> the student can do alone. If they try <code>(2 + 3)²</code> and compare with <code>2² + 3²</code>, they discover for themselves that 25 is not 13; that is a more lasting lesson than a teacher's correction.</p>

<h2>Twelve questions that reveal the error</h2>
<p>The "Ejercicios_y_claves" sheet has twelve single-answer questions where each distractor is tied to an error. For example, in <em>"1/2 + 1/3 ="</em> the options are <code>5/6</code> (correct), <code>2/5</code> (error E1) and <code>1/6</code> (another error); in <em>"Which is greater: 0.25 or 0.3"</em>, choosing <code>0.25</code> points to E2; in <em>"8 + 4 = □ + 5"</em>, both 12 and 17 point to E4. An important design decision: <strong>errors E1, E5 and E6 appear in two different questions</strong> (for example, <code>1/2 + 1/3</code> and <code>1/4 + 2/3</code>), because an error made once may be carelessness and one made in two different questions is a strong clue of a wrong rule.</p>
<p>A caution: with single-answer questions, a student can get it right by chance or by elimination. These questions serve to <em>point to hypotheses</em> that are then confirmed with a conversation ("tell me how you thought about it"), not to pass sentence. The AI Exam Generator can help you produce more questions of this type for other topics (see below), as long as you review them.</p>

<h2>A group diagnostic (fictional data)</h2>
{{img:diagnostico}}
<p>The "Diagnostico_de_grupo" sheet receives the letters each student marked, converts them into error codes with the key and computes the summary. I tested the workbook with 12 fictional students, whose results I checked against an independent Python calculation (they match):</p>
<ul>
<li><strong>The most frequent error was E1</strong> (adding numerators and denominators): 5 of the 12 students (42%) made it at least once, 8 times in total.</li>
<li><strong>5 of 12 students repeat the same error</strong> in more than one question, and the sheet says which: three of them repeat E1, one repeats E5 and one E6.</li>
<li>The other errors appear in one to three students each.</li>
</ul>
<p>The pedagogical decision becomes concrete: instead of reviewing "fractions" with the whole group, you work on <strong>the componential-addition rule</strong> with the five students who have it, with the number line and estimation first, and the rest keep moving. And the sheet flags the five who <em>repeat</em> an error, who most need an individual conversation.</p>

<h2>From diagnosis to intervention</h2>
<ol>
<li><strong>Confirm the hypothesis with the student.</strong> Ask them to solve aloud or explain a case: "why do you add the bottoms?". Their explanation is worth more than the written answer.</li>
<li><strong>Create cognitive conflict.</strong> A question their rule cannot solve: "<code>1/2 + 1/2</code> gives <code>2/4</code> with your method; how much is half plus half?".</li>
<li><strong>Build the correct rule with concrete supports:</strong> area models, number lines, bills and coins, balances.</li>
<li><strong>Estimate before calculating</strong> and <strong>check afterwards</strong> (by substituting, with a numeric case, with a calculator): they are habits that attack several errors at once.</li>
<li><strong>Measure again</strong> with different questions a few weeks later. If the error reappears, the rule did not change. (To know whether a strategy works, see the <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">four-week test</a>.)</li>
</ol>

<h2>What not to do</h2>
<ul>
<li><strong>Labeling the student</strong> ("they are bad at fractions"): the matrix talks about rules, not people.</li>
<li><strong>Correcting only the answer,</strong> without touching the rule.</li>
<li><strong>Giving the correct algorithm without meaning:</strong> "find the common denominator" without understanding why is forgotten or mixed up.</li>
<li><strong>Diagnosing with a single question:</strong> an isolated error may be carelessness.</li>
<li><strong>Showing results by name</strong> in front of the group: performance data are personal.</li>
</ul>
<p>And a note: if a student has persistent, broad difficulties in math even though their errors are worked on, it is worth talking with school counseling; they might need reasonable adjustments (see <a href="/herramientas/piar/">PIAR con IA</a>). That decision belongs to the team, not to a matrix.</p>

<h2>The feedback that goes with it</h2>
<p>Diagnosis feeds feedback: a comment like "check the sum of fractions" is vague; one like "you added the numerators and the denominators separately; place 1/2 and 1/3 on the line and estimate what the sum should be before calculating" names the process and proposes a next step (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that really changes learning</a>). And it connects with the idea of assessing the thinking process and not just the result, which also applies in programming (see <a href="/ensenar-programacion-era-ia-que-sigue-importando-rubrica-depuracion/">teaching debugging in the age of AI</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, error analysis is a recognized practice in mathematics education. In Colombia and Latin America, with large groups and little time, the challenge is to do it without it becoming a burden: that is why single-answer questions with designed distractors and a sheet that counts for the teacher are an efficient way to start. For <strong>teachers</strong>, it is a way to direct reinforcement time better; for <strong>principals</strong>, to analyze patterns by grade and articulate the curriculum (the fractions error in sixth grade often comes from fifth); for <strong>families</strong>, to understand that a repeated error has a cause and a solution; and for <strong>students</strong>, to see the error as information and not as failure. See also <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades measure</a>.</p>

<h2>Tools for the teacher</h2>
<p>To produce more diagnostic questions with designed distractors, equivalent versions and solutions, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> generates material you review before using it, and the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> has recipes by subject, including reinforcement activities. There is a <a href="/examenes/demo/">free demo of the generator</a>.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">does AI expand or replace student thinking?</a> and <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">an institutional AI policy for schools</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Why does a student repeat the same math error?</h3>
<p>Almost always because they apply a wrong rule consistently (for example, treating a fraction as two loose numbers). As long as the rule does not change, the error reappears even if their answer is corrected.</p>
<h3>How do I know whether it is a concept error or carelessness?</h3>
<p>If the error appears in two or more different questions with the same logic, it is a strong clue of a concept. Confirm it by asking them to explain how they thought.</p>
<h3>What is the natural number bias?</h3>
<p>It is the tendency to apply whole-number rules to fractions and decimals, for example, adding numerators to numerators and denominators to denominators.</p>
<h3>Are single-answer questions useful for diagnosis?</h3>
<p>They are useful to point to hypotheses, if each distractor is designed to reveal an error. They are not enough to pass sentence: they are confirmed with a conversation.</p>
<h3>Should I show each student their error?</h3>
<p>Yes, in private and as information about the rule they used, not about the person, with a chance to try again.</p>

<p class="notice"><strong>This week:</strong> download the <a href="/descargas/errores-matematicos/matriz-errores-matematicos-diagnostico.xlsx">error matrix and diagnostic</a> (in Spanish), apply the twelve questions to a group (or adapt them to your topic) and paste the answers into the sheet. Pick the most frequent error and work on it with the students who repeat it.</p>

<h2>Food for thought</h2>
<p>If most repeated errors are badly generalized rules, then much of what we call "did not understand" is a misunderstanding about what the rule means. <strong>How many of the errors we correct with a red mark are really a good idea applied where it does not belong? And if discovering the logic of the error takes time and individual conversation, how is it done with forty students per group and five groups per teacher?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:logica}}' => $img('error-matematico-repetido-logica', 573, 'Four cards with errors and their logic: 1/2 + 1/3 = 2/5 by adding numerators and denominators, 0.25 greater than 0.3 by comparing as whole numbers, 8 times 0.5 equal to 40 by believing multiplication always enlarges and the square of a sum badly distributed.', 'Behind each error there is usually a badly generalized rule.'),
    '{{img:diagnostico}}' => $img('error-matematico-repetido-diagnostico', 656, 'Bars with how many of 12 fictional students made each error at least once: the fractions error E1 was made by 5, and the others by between 1 and 3.', 'How many students made each error at least once.'),
]);

return [
    'error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo' => [
        'slug' => 'the-math-error-that-keeps-repeating-error-matrix-group-diagnostic',
        'title' => 'The Math Error That Keeps Repeating: How to Find Out What the Student Is Thinking, with an Error Matrix and a Group Diagnostic',
        'excerpt' => 'Why a student repeats the same math error, a matrix of nine frequent errors with their logic and intervention, twelve diagnostic questions and a sheet that detects who repeats the same error in a group.',
        'seo_title' => 'Repeated Math Error: Matrix and Diagnostic',
        'seo_description' => 'How to find out why a student repeats a math error: a matrix of frequent errors, diagnostic questions and interventions, with a downloadable workbook.',
        'focus_keyword' => 'repeated math errors students',
        'cover' => '/assets/img/articulos/error-matematico-repetido/error-matematico-repetido-portada-en',
        'cover_alt' => 'Cover "The math error that keeps repeating: how to find out what the student is thinking" with a card: 1/2 + 1/3 = 2/5, the most frequent error in the example group; 5 of 12 students made it and 5 of 12 repeat the same error.',
        'content_html' => $html,
    ],
];
