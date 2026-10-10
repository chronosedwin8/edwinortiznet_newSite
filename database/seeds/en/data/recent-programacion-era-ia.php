<?php

declare(strict_types=1);

// English version of "¿Para qué enseñar a programar si la IA escribe el código? Lo que sigue importand…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/programacion-era-ia/' . $name . '-en';
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
<p>A tenth grader hands in a program that works perfectly. You ask how they did it and they answer: "I asked the AI." You ask them to change one line and they do not know where to start. What used to be a sign of learning (the program works) no longer is. And the question many teachers ask under their breath: <strong>why teach programming if a machine writes the code?</strong></p>
<p>This article proposes an evidence-based answer: <strong>programming is still thinking</strong>, and what must change is how it is taught and assessed. It includes a <a href="/descargas/programacion-ia/rubrica-programacion-era-ia.xlsx">downloadable Excel rubric</a> (in Spanish) to assess understanding (not just whether the code runs), an AI-use log and a <a href="/descargas/programacion-ia/ejercicio_mediana.py">debugging exercise</a> with code that looks right, tested with automated tests. Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> The available evidence says AI speeds up programming tasks, but used without limits it can create an illusion of progress: in a study with about 1,000 secondary students, those who practiced with an unrestricted assistant improved during practice and did worse on an exam without AI. That is why <strong>teaching shifts toward understanding the problem, testing, debugging and explaining</strong>, and assessment toward process and understanding, with AI use declared. These are specific studies with limitations: they give signals, not laws.</p>

<h2>What the evidence says (with its limits)</h2>
<ul>
<li><strong>Help that can harm (Bastani et al., 2024).</strong> In a randomized trial with about 1,000 secondary students in Turkey (grade 9 to 11 math), those who practiced with a ChatGPT-like assistant ("GPT Base") performed 48% better during practice but <strong>17% worse</strong> on the exam without AI than the control group. Those who used a tutor designed with safeguards (with the solutions and teacher notes, and instructions not to give the answer) performed 127% better in practice and had <strong>no loss</strong> on the exam compared with the control. It is a 2024 preprint and about math, not programming; but it shows the mechanism: using the tool as a crutch.</li>
<li><strong>Help that speeds up (Peng et al., 2023).</strong> In an experiment with contracted programmers, those who had GitHub Copilot finished a scoped task (an HTTP server in JavaScript) <strong>55.8% faster</strong> (a very wide confidence interval, from 21% to 89%). It measures speed on a task, not learning.</li>
<li><strong>Help that deceives (Prather et al., ICER 2024).</strong> In a lab study with 21 students from a first programming course, 20 finished the problem with AI; but among the 10 who struggled, 9 reached the solution with AI and most <strong>believed they understood more than they did</strong>: the tool gave them an illusion of progress. It is a small, exploratory study. Students who already knew what they wanted to write used AI to speed up and discarded bad suggestions.</li>
</ul>
{{img:evidencia}}
<p>The combined reading: <strong>AI benefits those who already understand and can harm those who do not yet</strong>, and a tutor with limits (one that guides instead of solving) mitigates the harm. Which tells us what to do in the classroom.</p>

<h2>What changes and what still matters</h2>
{{img:cambia}}
<p>Writing syntax moves to the background; what rises in value is:</p>
<ol>
<li><strong>Understanding the problem:</strong> inputs, outputs, constraints, edge cases. An AI responds to what you ask, and asking well requires understanding.</li>
<li><strong>Breaking down and designing:</strong> splitting a big problem into steps, which no syntax replaces.</li>
<li><strong>Testing:</strong> if you cannot say how you would know the code works, you cannot verify what an AI hands you.</li>
<li><strong>Debugging and reading other people's code:</strong> much of real work will be reviewing what someone else, or a machine, wrote.</li>
<li><strong>Explaining:</strong> if you can explain why it works, you understand it.</li>
</ol>

<h2>An exercise: the code that looks right</h2>
<p>This is the kind of activity that develops those skills. An AI generated this function to compute the median of a class's grades:</p>
<pre><code>def mediana(valores):
    ordenados = sorted(valores)
    n = len(ordenados)
    return ordenados[n // 2]</code></pre>
<p>It works with the first examples tried (with an odd number of data points). But it has deeper flaws. I wrote six tests and ran them:</p>
<pre><code>$ python -m unittest pruebas_mediana -v
test_cantidad_impar ... ok
test_un_solo_valor ... ok
test_no_modifica_la_lista_original ... ok
test_cantidad_par ... FAIL     AssertionError: 3 != 2.5
test_par_sin_ordenar ... FAIL  AssertionError: 3.0 != 2.5
test_lista_vacia ... ERROR     IndexError: list index out of range

Ran 6 tests: FAILED (failures=2, errors=1)</code></pre>
<p>The student's task: <strong>run the tests, explain why each fails and fix the function without changing the tests</strong>. The errors are typical of code generated without judgment: with an even number of data points, the median must be the average of the two middle values (here it returns the upper middle one); and with an empty list it raises an unclear error instead of one that explains the problem. This is the solution (also included, commented, in the kit), with which all six tests pass:</p>
<pre><code>def mediana(valores):
    if not valores:
        raise ValueError("La lista no puede estar vacía")
    ordenados = sorted(valores)
    n = len(ordenados)
    medio = n // 2
    if n % 2 == 1:
        return ordenados[medio]
    return (ordenados[medio - 1] + ordenados[medio]) / 2</code></pre>
<p>Notice what the exercise demands of the student: reading tests, reasoning about edge cases, locating the cause and justifying the fix. <strong>None of those tasks is solved by pasting the prompt into an AI without understanding it.</strong> And if they use it, the log asks them to say what they verified.</p>

<h2>The rubric: assess understanding, not just results</h2>
<p>If you grade only that the program works, you are grading the tool. The workbook's rubric (four levels per criterion, with editable weights) changes the focus:</p>
<table>
<thead><tr><th>Criterion</th><th>Suggested weight</th><th>What evidence it looks at</th></tr></thead>
<tbody>
<tr><td><strong>Understanding the problem</strong></td><td>15%</td><td>Inputs, outputs, constraints and edge cases</td></tr>
<tr><td><strong>Design and decomposition</strong></td><td>15%</td><td>Plan, functions, justification</td></tr>
<tr><td><strong>Correctness and tests</strong></td><td>20%</td><td>Tests of typical and edge cases</td></tr>
<tr><td><strong>Debugging</strong></td><td>15%</td><td>Locating and explaining errors</td></tr>
<tr><td><strong>Explanation and understanding (oral defense)</strong></td><td>20%</td><td>Explaining and modifying a line live</td></tr>
<tr><td><strong>Responsible use of AI</strong></td><td>10%</td><td>Log: what they asked, verified and changed</td></tr>
<tr><td><strong>Readability and good practices</strong></td><td>5%</td><td>Names, structure, comments</td></tr>
</tbody>
</table>
<p>The workbook computes the score (with every criterion at level 3, for example, it gives 75/100, equivalent to 4.0 on a linear 1-to-5 scale, which you must adapt to your school's assessment system) and warns if the weights do not add up to 100. It also has the <strong>AI-use log</strong> and a sheet of <strong>AI-proof tasks</strong>: tracing code by hand, debugging given code, writing tests first, modifying live, explaining a line and programming without assistants in class. Consistent with the idea that assessment should measure learning and not compliance (see <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades measure</a>) and with the <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">institutional AI policy</a>.</p>

<h2>How to organize the classes</h2>
<ol>
<li><strong>Start without AI</strong> on the basics (variables, conditions, loops): they need the fluency to judge what an AI proposes.</li>
<li><strong>Introduce AI with limits:</strong> as a tutor that asks and explains, not as a provider of solutions; a tutor with safeguards is what mitigated the harm in Bastani's study.</li>
<li><strong>Teach how to ask well</strong> and to read critically: exercises on debugging generated code.</li>
<li><strong>Assess at two moments:</strong> a piece of work with declared AI use and a short test without AI (or an oral defense) that verifies understanding.</li>
<li><strong>Measure whether it works:</strong> compare with and without the strategy (see the <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">four-week test</a>).</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, the discussion takes place in universities and in schools with computing curricula; several reports from the computing education community argue that AI forces a rethink of what is assessed and how. In Colombia and Latin America, programming instruction in schools is very uneven: some institutions have labs and projects, and many lack enough equipment or technology teachers with specific training. For <strong>technology and computer science teachers</strong>, the challenge is to assess understanding with large groups (short oral defenses and tests without AI help); for <strong>principals</strong>, defining clear rules (see <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">pedagogical autonomy and platforms</a>); for <strong>students</strong>, understanding that learning to program is learning to reason, and for <strong>families</strong>, that a program that works is not always a sign of learning.</p>

<h2>Tools for the teacher</h2>
<p>To plan the activities and produce short tests (on paper, without AI) with their solutions, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> delivers the material for you to review, and the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> has recipes for planning.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">does AI expand or replace student thinking?</a> and <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">schools' technology debt</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Should AI be banned in programming classes?</h3>
<p>Not necessarily. The evidence suggests that without limits it can harm learning, and that with design (a tutor that guides, a log, assessment of understanding) it can help. Define allowed, conditional and not-authorized uses.</p>
<h3>How do I know whether the student understood or just copied?</h3>
<p>Ask them to explain and modify their code live, trace an example by hand or debug given code. Those who understand can do it; those who just copied can hardly do so.</p>
<h3>Is learning syntax still necessary?</h3>
<p>Yes, enough to read, judge and fix the code you get, from AI or from another person. Basic fluency allows you to detect errors.</p>
<h3>Which language should be taught?</h3>
<p>One that lets you focus on reasoning: many schools use Python or visual blocks at the start. What matters is understanding, not the tool.</p>
<h3>How do I assess large groups?</h3>
<p>Combine short tests without AI, rubrics with evidence (tests, log) and oral defenses by sampling.</p>

<p class="notice"><strong>Try it in your class.</strong> Download the <a href="/descargas/programacion-ia/rubrica-programacion-era-ia.xlsx">rubric</a> (in Spanish) and the <a href="/descargas/programacion-ia/ejercicio_mediana.py">debugging exercise</a> (with its <a href="/descargas/programacion-ia/pruebas_mediana.py">tests</a> and the <a href="/descargas/programacion-ia/solucion_mediana.py">solution</a>) and apply them with a group.</p>

<h2>Food for thought</h2>
<p>If a machine can write the program, perhaps what we truly taught when teaching programming was always something else: how to formulate problems, how to doubt answers and how to explain oneself. <strong>Is school ready to assess that, or will we keep rewarding programs that work without asking who understood them? And if AI helps those who already understand a lot and those who do not very little, are we widening the gap between students when we put the tool in every hand?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:evidencia}}' => $img('programacion-era-ia-evidencia', 573, 'Four cards with the evidence: an unrestricted assistant improved practice by 48% and worsened the exam without AI by 17%; Copilot made a task 55.8% faster; 20 of 21 novices finished with AI though some believed they understood more than they did; and a tutor with safeguards had no loss.', 'AI speeds things up but can also create an illusion of progress.'),
    '{{img:cambia}}' => $img('programacion-era-ia-cambia', 633, 'Two columns: what changes in teaching programming with AI, such as syntax moving to the background and assessing the process, and what still matters: understanding the problem, breaking down and designing, testing and debugging and explaining why it works.', 'Programming is still thinking.'),
]);

return [
    'ensenar-programacion-era-ia-que-sigue-importando-rubrica-depuracion' => [
        'slug' => 'teaching-programming-in-the-age-of-ai-what-still-matters-rubric-debugging',
        'title' => 'Why Teach Programming If AI Writes the Code? What Still Matters, with a Rubric and a Debugging Exercise',
        'excerpt' => 'What the evidence says about AI and learning to program, what changes and what still matters, a debugging exercise with code that looks right (tested with automated tests) and a rubric to assess understanding.',
        'seo_title' => 'Teaching Programming with AI: Rubric and Debugging',
        'seo_description' => 'How to teach and assess programming when AI writes code: evidence, a downloadable rubric, an AI-use log and a tested debugging exercise.',
        'focus_keyword' => 'teaching programming with AI',
        'cover' => '/assets/img/articulos/programacion-era-ia/programacion-era-ia-portada-en',
        'cover_alt' => 'Cover "Why teach programming if AI writes the code? What still matters" with a card: +48% in practice and −17% on the exam without AI with an unrestricted assistant; a tutor with safeguards had no loss.',
        'content_html' => $html,
    ],
];
