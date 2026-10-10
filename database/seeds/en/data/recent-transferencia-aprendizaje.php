<?php

declare(strict_types=1);

// English version of «Transferencia del aprendizaje: por qué casi nunca ocurre sola y cómo diseñar tar…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/transferencia-aprendizaje/' . $name . '-en';
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
<p>A student comfortably solves ten rule-of-three problems in her notebook. Two weeks later, at the school shop, she does not know which pack of cookies is the better buy. The teacher wonders what went wrong: did she not learn? She did learn, but <strong>what was learned did not travel to the new context</strong>. That problem has a name in learning psychology: transfer.</p>
<p>Transfer of learning is the ability to use what was learned in a situation different from the one in which it was learned. It is, deep down, the purpose of almost all schooling: nobody teaches fractions so that textbook fractions get solved, but so that something can be done with them. This article explains what research says (with figures from classic studies and their limits), why transfer almost never happens by itself and which classroom practices help, and includes an <a href="/descargas/transferencia-aprendizaje/diseno-para-la-transferencia.xlsx">Excel template</a> (in Spanish) with a task-distance matrix, a spaced-review calendar and eight bridge questions, verified in Microsoft Excel 16 with a fictional example. Sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> Transfer is a topic with varied and partly debated research results; I present what the literature holds, with its nuances, and avoid promising effects. The figures come from classic lab studies and reviews, not from Colombian classrooms. The template's matrix is the author's own framework, not a validated scale. The unit example is fictional.</p>

<h2>What transfer is (and its types)</h2>
<ul>
<li><strong>Positive and negative transfer.</strong> What was learned can help in the new situation (positive) or interfere (negative: applying a rule where it does not apply, such as adding numerators and denominators when adding fractions).</li>
<li><strong>Near and far transfer.</strong> Near transfer happens between very similar situations (another rule-of-three problem); far transfer, between very different ones (using proportionality to decide a purchase, or an idea from science class in a citizenship debate). Barnett and Ceci (2002) proposed a taxonomy to describe how far what is learned travels along context dimensions, such as knowledge domain, physical, temporal and social context and modality, and concluded that far transfer is rare, but under the right conditions it can occur.</li>
<li><strong>Low road and high road.</strong> Perkins and Salomon distinguished "low road" transfer (automatic, based on well-practiced skills and similar situations) from "high road" transfer (deliberate, requiring abstracting a principle and recognizing that it applies elsewhere). Teaching can favor the first by "hugging" (making practice resemble where it will be used) and the second by "bridging" (helping students abstract and connect).</li>
</ul>

<h2>Why it almost never happens by itself</h2>
<p>The classic study is Gick and Holyoak's (1980, with replications in 1983). People are given the "radiation problem": how to destroy a tumor with rays without damaging the healthy tissue around it. Without any prior help, according to reviews of that line of research, only about <strong>10%</strong> found the solution (directing several weak rays from different angles that converge on the tumor). If they had first read an analogous story, that of a general who splits his army to attack a fortress from several roads, but without being told to use it, the proportion rose to only about <strong>30%</strong>. When given the explicit hint ("the story may help you"), the total reached about <strong>80%</strong>. Those percentages vary across experiments and reviews (some secondary sources cite other values), so they are best read as orders of magnitude and not exact figures.</p>
<p>The lesson is uncomfortable and useful at once: people have the necessary knowledge, but <strong>do not retrieve it when the situation looks different</strong>; recognizing that "this is the same as that" fails, and is fixed with a hint, that is, with teaching. Put differently, transfer is not an automatic effect of learning well: it is something to be taught and checked.</p>
<p>An important nuance: programs promising to improve general thinking with a specific activity (for example, training working memory, chess or music to improve academic performance) have had little evidence of far transfer in systematic reviews, such as Sala and Gobet's (2017) meta-analysis. It is one more reason to be cautious about promises, and to design transfer explicitly rather than wait for it.</p>

<h2>Five dimensions in which a task moves away from what was practiced</h2>
{{img:dimensiones}}
<p>The template's <em>Tareas</em> sheet rates each task in a unit on five dimensions, from 0 (same as practiced) to 2 (very different): domain, place, time, format and social component. The sum is the task's <strong>distance</strong> (0 to 10) and is classified as near (0 to 2), intermediate (3 to 5) or far (6 to 10). It is the author's own framework, inspired by the context dimensions in the literature.</p>
<p>In the fictional example of a proportionality unit in grade 7, with ten tasks:</p>
<ul>
<li>The distances are 0, 1, 1, 3, 4, 2, 4, 8, 8 and 5. Four tasks are near, four intermediate and <strong>two far</strong> (20%): the budget for an event for another class and the shopping report at a supermarket with family.</li>
<li>The unit's mean distance is <strong>3.6</strong> and the maximum, 8.</li>
<li>By dimension, the highest sum is <strong>domain (11)</strong> and the lowest is <strong>place (4)</strong>: the unit varies situations quite a bit, but almost never leaves the classroom. That is the least varied dimension.</li>
</ul>
<p>The automatic diagnosis on the <em>Resumen</em> sheet says "Hay tareas lejanas" (there are far tasks), and if there were none it would say "Ninguna tarea lejana: se practica, pero no se verifica el transferir" (no far tasks: it is practiced, but transfer is not checked). Many real units would fall in that second case: ten exercises of the same form, a test of the same form, and the surprise when the student fails in a new context.</p>

<h2>Five classroom moves to teach transfer</h2>
{{img:movimientos}}
<ol>
<li><strong>Vary examples and contexts.</strong> Practicing with diverse situations helps separate the essential from the accidental. A proportionality unit with only recipe problems leads to associating the rule with recipes.</li>
<li><strong>Compare cases to extract the common structure.</strong> Research on analogical reasoning (for example, the work of Gentner and colleagues) suggests that comparing two cases, and not just studying them separately, helps see the shared principle. Ask: what do these two problems have in common even though they look different?</li>
<li><strong>Build explicit bridges.</strong> Bridge questions (the sheet has eight) ask students to abstract ("explain the idea without the textbook example"), connect ("where else have you seen something similar?"), anticipate ("where could you use it this week?") and recognize limits ("when would this strategy not work?").</li>
<li><strong>Space and retrieve.</strong> Returning to the topic days and weeks later, with tasks in a different format, strengthens retention and forces recognizing the topic in a new context. The <em>Espaciamiento</em> sheet calculates review dates at 1, 7 and 30 days from teaching (for example, a topic taught on February 1, 2027 is reviewed on February 2 and 8 and March 3; the intervals are editable). See <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">from the mock exam to the improvement plan</a>, which uses the same retrieval and spacing logic (in Spanish).</li>
<li><strong>Check with tasks of greater distance.</strong> If the only thing assessed is what was practiced in the same form, it is not known whether transfer happened. Include at least one far task per unit, with feedback (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a>).</li>
</ol>
<p>This connects with planning: <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">backward design</a> asks you to define first what students should be able to do, and transfer is precisely that "being able to do in another context". Also with projects: a good STEAM project (see <a href="/steam-sin-equipos-costosos-proyectos-materiales-cotidianos-plantilla/">STEAM without expensive equipment</a>) can be a far-transfer task if the product has a real audience, and recurring errors (see <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">the math error that keeps repeating</a>) are often, in part, negative transfer.</p>

<h2>What does not solve transfer</h2>
<ul>
<li><strong>More exercises of the same type.</strong> They improve near transfer and fluency, but do not guarantee recognizing the principle elsewhere.</li>
<li><strong>Expecting "critical thinking" to develop by itself.</strong> General skills rarely transfer without explicit teaching of each domain's knowledge.</li>
<li><strong>Assessing only far transfer without having taught how to transfer.</strong> It measures context, not learning, and punishes those who had no chance to practice it.</li>
</ul>

<h2>Colombia, Latin America and the world</h2>
<p>The discussion about learning "for life" appears in tests that measure competencies: ICFES's Saber tests assess the ability to apply knowledge to situations, and international tests such as PISA explicitly aim at applying what was learned to real-life problems (see <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA in Latin America</a>). For <strong>teachers</strong>, the challenge is to design tasks that move away from what was practiced, with support and feedback, rather than suddenly assessing a transfer never taught; for <strong>principals</strong>, to understand that transfer takes time (revisiting topics) and collaboration across areas; for <strong>families</strong>, that using what is learned at home (comparing prices, measuring a recipe) is valuable transfer practice; and for <strong>students</strong>, that asking "where else is this useful?" is a skill that can be trained. Mind equity: "real-life" tasks favor those with more prior experience with that context; offer varied contexts and do not assume everyone knows them.</p>

<h2>Tools and templates</h2>
<p>To generate problem variants in different contexts, learning evidence and bridge questions, and to organize your resources with AI (always reviewing what it produces), look at these tools of our own.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">grades: learning or compliance</a>, <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">how to test an educational tool in four weeks</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>. To adapt tasks for students with learning barriers, <a href="/herramientas/piar/">PIAR with AI</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is transfer of learning?</h3>
<p>The ability to apply what was learned in a situation different from the one in which it was learned.</p>
<h3>Why do students not transfer what they know?</h3>
<p>Because they do not recognize that the new situation resembles the learned one. In classic studies, only a minority transferred without a hint and most did with one; transfer has to be taught.</p>
<h3>What is the difference between near and far transfer?</h3>
<p>Near transfer happens between very similar situations; far transfer, between very different ones (another subject, place, time or format). Far transfer is rarer and harder.</p>
<h3>How can I promote transfer in my classes?</h3>
<p>By varying examples and contexts, comparing cases, asking bridge questions, spacing reviews and checking with at least one far task per unit.</p>
<h3>Do bridge questions work?</h3>
<p>They are a reasonable practice backed by Perkins and Salomon's "bridging" framework, although evidence of classroom effects is varied. It is worth testing them with your own data.</p>

<p class="notice"><strong>Measure your next unit's distance.</strong> Download the <a href="/descargas/transferencia-aprendizaje/diseno-para-la-transferencia.xlsx">transfer design template</a> (in Spanish), rate your next unit's tasks and see whether any is far. If none is, add one.</p>

<h2>Food for thought</h2>
<p>We teach so that what is learned serves beyond the classroom, but we almost always assess inside it. <strong>Which part of what you teach is meant to be used outside school, and how would you know if it is? And what would change if each unit ended not with a test identical to the exercises, but with a problem the student has not seen in any class?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:dimensiones}}' => $img('transferencia-aprendizaje-dimensiones', 553, 'Table with five dimensions in which a task moves away from what was practiced, with the near and far ends: domain, place, time, format and social.', 'Five dimensions of distance.'),
    '{{img:movimientos}}' => $img('transferencia-aprendizaje-movimientos', 467, 'Five classroom moves to teach transfer: vary, compare, connect, space and check.', 'Five moves in the classroom.'),
]);

return [
    'transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla' => [
        'slug' => 'transfer-of-learning-making-what-is-learned-useful-outside-the-classroom-template',
        'title' => 'Transfer of Learning: Why It Almost Never Happens by Itself and How to Design Tasks That Check It (Template)',
        'excerpt' => 'What research says about transfer of learning (Gick and Holyoak, Barnett and Ceci, Perkins and Salomon), why it almost never happens by itself and how to vary, compare, connect, space and check, with an Excel template.',
        'seo_title' => 'Transfer of Learning: How to Teach It',
        'seo_description' => 'What transfer of learning is, why students do not apply what they know and how to promote it in the classroom, with an Excel template for your units.',
        'focus_keyword' => 'transfer of learning',
        'cover' => '/assets/img/articulos/transferencia-aprendizaje/transferencia-aprendizaje-portada-en',
        'cover_alt' => 'Cover "Transfer of learning: making what is learned useful outside the classroom" with a card: from about 10% to 80% solved a new problem without a hint and with a hint.',
        'content_html' => $html,
    ],
];
