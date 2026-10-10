<?php

declare(strict_types=1);

// English version of «La retroalimentación que sí cambia el aprendizaje: cuatro niveles, un banco de e…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/retroalimentacion-aprendizaje/' . $name . '-en';
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
<p>A teacher spends the weekend grading thirty assignments and writes on each one "Very good", "Improve", "Needs more effort". On Monday they are handed back; the students look at the grade, put the work away and never open it again. It is education's most repeated scene and one of the biggest wastes of teacher time: <strong>hours of feedback that change nothing</strong>.</p>
<p>Feedback is, according to the evidence, one of the highest-impact, lowest-cost interventions, but with a warning almost nobody tells: <strong>it can help, do nothing or even harm</strong>. This article explains what makes feedback change learning, with a <a href="/descargas/retroalimentacion/rubrica-banco-retroalimentacion.xlsx">bank of 20 rewritten examples and a downloadable Excel rubric</a> (in Spanish) to assess and improve your own comments. Data verified on October 10, 2026.</p>
<p class="notice"><strong>Summary.</strong> Feedback works when it focuses on <strong>the task, the process and self-regulation</strong>, is specific, says <strong>how to improve</strong>, arrives <strong>on time</strong> and the student has <strong>a moment to use it</strong>. Comments about the person ("you are very smart", "you did not try") rarely help. In a bank of 20 common comments, only 35% help improve and 35% focus on the person. With the rubric and the bank you can audit yours in ten minutes.</p>

<h2>What the evidence says</h2>
<ul>
<li><strong>It works, on average.</strong> The UK's Education Endowment Foundation (EEF) places feedback among low-cost, high-impact interventions: its guidance speaks of several months of additional progress (Toolkit versions cite between six and eight months; confirm the current figure on its site).</li>
<li><strong>But the average hides wide variation.</strong> The classic meta-analysis by Kluger and DeNisi (1996, <em>Psychological Bulletin</em>; 607 effect sizes, over 23,000 observations) found a positive average effect (d = 0.41) but that <strong>more than a third of feedback interventions made performance worse</strong>. Its authors explain that effectiveness drops when attention shifts from the task toward the self. The EEF itself warns that in some cases feedback can have negative effects.</li>
<li><strong>The level matters.</strong> Hattie and Timperley (2007, <em>Review of Educational Research</em>) distinguish four levels of comment: about the <strong>task</strong> (what is right or wrong), the <strong>process</strong> (the strategies used), <strong>self-regulation</strong> (how the student checks and corrects their work) and the <strong>person</strong> (general praise or criticism). The first three contribute to improvement; the last, in general, does not, because it does not guide what to do next.</li>
</ul>
{{img:niveles}}
<p>The practical lesson: <strong>it is not about giving more feedback, but better</strong>. And well-made feedback answers the model's three questions: where am I going? (the goal), how am I going? (where I am) and what is the next step? (how to improve).</p>

<h2>Four comments, four levels</h2>
<p>The same math assignment, four possible comments:</p>
<table>
<thead><tr><th>Comment</th><th>Level</th><th>Does it help?</th></tr></thead>
<tbody>
<tr><td>"Very good, you are very smart."</td><td>Person</td><td>No: it does not say what was good or what to do</td></tr>
<tr><td>"Wrong."</td><td>Task (vague)</td><td>No: it does not say where or why</td></tr>
<tr><td>"Check the second line: the sign changes when moving to the other side of the equals sign."</td><td>Task (specific)</td><td>Yes: it says where and how to fix</td></tr>
<tr><td>"What strategy did you use and why did you choose it? Compare it with your classmate's."</td><td>Self-regulation</td><td>Yes: it invites thinking about their own process</td></tr>
</tbody>
</table>

<h2>The comment-quality rubric</h2>
<p>The workbook has a rubric with six criteria and four levels, designed to assess a comment before handing it back (or for peer review among colleagues):</p>
<table>
<thead><tr><th>Criterion</th><th>Weight</th><th>What it looks at</th></tr></thead>
<tbody>
<tr><td><strong>Focuses on task and process, not the person</strong></td><td>20%</td><td>Talks about the work and how it was done</td></tr>
<tr><td><strong>Is specific</strong></td><td>20%</td><td>Points to the concrete spot, with an example</td></tr>
<tr><td><strong>Says how to improve</strong></td><td>25%</td><td>A clear, possible next step</td></tr>
<tr><td><strong>Arrives on time and can be used</strong></td><td>15%</td><td>There is a moment to act on it</td></tr>
<tr><td><strong>Protects dignity and motivation</strong></td><td>10%</td><td>Respectful and clear; acknowledges what was achieved</td></tr>
<tr><td><strong>Invites reflection</strong></td><td>10%</td><td>Asks to compare, explain or plan</td></tr>
</tbody>
</table>
<p>The workbook computes the score (with every criterion at level 3, for example, 75/100) and gives a reading: "Retroalimentación potente" (powerful), "Útil" (useful), "Débil" (weak) or "Poco útil" (not very useful). The weights are editable and must add up to 100. There is an important warning in the sheet's last row: excellent feedback that arrives when it can no longer be used does little. <strong>The timing criterion matters as much as the content.</strong></p>

<h2>The bank: 20 real comments, rewritten</h2>
{{img:ejemplos}}
<p>The "Banco_de_ejemplos" sheet collects 20 typical comments from different areas (math, language, science, social studies, English, technology, physical education, art), each with its level, whether it helps improve and an improved version. Some rewriting examples:</p>
<ul>
<li>"Your text is confusing." → "Each paragraph mixes two ideas: try one idea per paragraph and write the main idea in the first sentence."</li>
<li>"This time you did not try." → "Your report has the introduction but not the method: complete it so someone else can repeat the experiment."</li>
<li>"Grade: 3.2." → "3.2: you met criteria 1 and 2; to go up, work on criterion 3 (conclusion) with an example and hand it in again."</li>
<li>"Nice." (art) → "The contrast between warm and cool colors guides the eye: try applying it to the background too."</li>
</ul>
<p>Of the bank's 20 comments, only 7 (35%) help improve as they are and 7 (35%) focus on the person; the rest are comments on the task that are vague or incomplete. You will notice a pattern in the rewrites: each one <strong>names something concrete about the work and proposes an action</strong>.</p>

<h2>Audit your own comments in ten minutes</h2>
<ol>
<li><strong>Take ten comments</strong> you wrote last week and paste them into the "Mis_comentarios" sheet.</li>
<li><strong>Classify each one</strong> as Task, Process, Self-regulation or Person, and answer whether it says how to improve and whether it arrived in time.</li>
<li><strong>Read the summary:</strong> the workbook computes the percentage by level and warns, for example, "Muchos comentarios sobre la persona: reescribe esos hacia la tarea y el proceso" (many comments about the person: rewrite them toward task and process) or "Faltan siguientes pasos" (next steps missing). I tested the case with nine classified comments, four about the person (44%) and three with a next step (33%), and the summary gave exactly that warning.</li>
<li><strong>Rewrite three comments</strong> using the bank as a guide and compare the rubric score before and after.</li>
</ol>

<h2>Making it get used: time and the cycle</h2>
<p>An excellent comment is useless if nobody acts on it. Some practices that help:</p>
<ul>
<li><strong>Give class time to use it.</strong> Ten minutes to correct with the comment are worth more than an hour of comments nobody reads.</li>
<li><strong>Comment before grading</strong> or separate the comment from the grade: with the grade in view, many students ignore the comment.</li>
<li><strong>Few comments, the most important:</strong> two or three points the student can address, not twenty marks.</li>
<li><strong>Offer a chance to redo</strong> and value the improvement (see <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades measure</a>).</li>
<li><strong>Teach students to ask for and give feedback</strong> to each other with the same rubric: it is a form of self-regulation.</li>
<li><strong>Use oral feedback</strong> when possible: it is faster and allows dialogue.</li>
</ul>

<h2>And AI?</h2>
<p>Today there are tools that generate comments in seconds. They can save time with drafts, but <strong>a comment generated without review tends to be generic</strong> ("good work, keep it up"), exactly what the rubric penalizes, and it can be wrong about the work. Use them as a draft you check against the rubric, without pasting student data into free tools (see <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into an AI</a>), and remember that the assessment decision is yours (see the <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">institutional AI policy</a> and <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">pedagogical autonomy</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, formative feedback is one of the practices most backed by evidence. In Colombia and Latin America, the reality of large groups and teachers with many class hours makes individual written feedback hard to sustain: hence the value of <strong>oral, group and peer feedback</strong>, and of concentrating on a few quality comments. Each school's student assessment system (SIEE) is the place to agree on how it is done and used (see <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">the article on grades</a>). For <strong>teachers</strong>, the challenge is to give less and better; for <strong>principals</strong>, to protect time so feedback gets used; for <strong>families</strong>, to ask "what should my child do to improve?" rather than "what grade did they get?"; and for <strong>students</strong>, to learn to ask for and use feedback.</p>

<h2>Tools for the teacher</h2>
<p>To produce assessments with clear criteria, where feedback rests on solutions and rubrics, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> delivers exams and solutions you review before using; the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> has recipes by subject, including ideas for giving feedback; and <a href="/herramientas/piar/">PIAR con IA</a> helps document reasonable adjustments that feedback must take into account.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">does AI expand or replace student thinking?</a> and <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">a four-week test</a> to check whether your feedback strategy works.</p>

<h2>Frequently asked questions</h2>
<h3>What makes feedback effective?</h3>
<p>That it focuses on the task, process or self-regulation, is specific, says how to improve, arrives on time and that the student has a moment to use it.</p>
<h3>Why does praise like "you are very smart" not help?</h3>
<p>Because it talks about the person and does not say what they did well or what to do next. According to Hattie and Timperley, comments about the person rarely contribute to learning.</p>
<h3>Can feedback make learning worse?</h3>
<p>Yes. In Kluger and DeNisi's (1996) meta-analysis, more than a third of interventions made performance worse, especially those that shifted attention toward the self and away from the task.</p>
<h3>How much feedback should I give?</h3>
<p>Less and better: two or three points the student can address, with a clear next step and time to apply them.</p>
<h3>Is AI-generated feedback useful?</h3>
<p>As a draft, yes, if you review it with a rubric and do not paste student data into unauthorized tools. Without review it tends to be generic.</p>

<p class="notice"><strong>This week:</strong> download the <a href="/descargas/retroalimentacion/rubrica-banco-retroalimentacion.xlsx">feedback rubric and bank</a> (in Spanish), audit ten of your comments and rewrite three. Then give ten minutes of class time for students to use them.</p>

<h2>Food for thought</h2>
<p>Grading is one of the tasks that takes the most teacher time and one of the least assessed. <strong>If most written feedback does not change learning, is the time we devote to it worth it, or should we spend that time on other ways of helping learning? And who should decide how much written feedback is expected of a teacher with forty students per group: the school, the education secretariat or the evidence?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:niveles}}' => $img('retroalimentacion-aprendizaje-niveles', 573, 'Four cards with the levels of a comment according to Hattie and Timperley: task, process, self-regulation and person, the least useful.', 'What does your comment talk about?'),
    '{{img:ejemplos}}' => $img('retroalimentacion-aprendizaje-ejemplos', 444, 'Table with three common comments, their level and an improved version: "very good, you are smart", "your text is confusing" and "good work".', 'From an empty comment to one that guides.'),
]);

return [
    'retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica' => [
        'slug' => 'feedback-that-changes-learning-example-bank-rubric',
        'title' => 'Feedback That Really Changes Learning: Four Levels, an Example Bank and a Rubric',
        'excerpt' => 'What the evidence says about feedback (including when it harms), the four levels of a comment, a bank of 20 rewritten examples and a downloadable rubric to audit your own comments in ten minutes.',
        'seo_title' => 'Feedback That Changes Learning: Rubric and Examples',
        'seo_description' => 'What makes feedback effective: evidence, four levels of comment, 20 rewritten examples and a downloadable rubric for your own comments.',
        'focus_keyword' => 'effective feedback classroom',
        'cover' => '/assets/img/articulos/retroalimentacion-aprendizaje/retroalimentacion-aprendizaje-portada-en',
        'cover_alt' => 'Cover "The feedback that does change learning, with examples and a rubric" with a card: 1 in 3 feedback interventions made performance worse in a classic meta-analysis; comments about the person do harm.',
        'content_html' => $html,
    ],
];
