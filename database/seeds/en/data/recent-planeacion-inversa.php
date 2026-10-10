<?php

declare(strict_types=1);

// English version of «Planeación inversa: empezar por lo que quieres que comprendan, con una plantilla…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/planeacion-inversa/' . $name . '-en';
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
<p>It is Sunday night and it is time to plan the week. Many of us teachers open the textbook, see the next topic and think of activities that cover it: a reading, a workshop, a video, a quiz. At the end of the term comes the test. And there is the problem: <strong>some of the questions assess something we never practiced, and some of the things we worked on most appear on no assessment</strong>.</p>
<p>Backward design proposes changing the order: start with what you want students to understand and be able to do, define how you will know they achieved it and only then design the activities. This article explains the framework and offers an <a href="/descargas/planeacion-inversa/planeacion-inversa-alineacion.xlsx">Excel template</a> (in Spanish) with the three stages and a sheet that <strong>automatically checks alignment</strong> among outcomes, evidence and activities. It was verified in Microsoft Excel 16 with a fictional example. Data and sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The framework is a planning tool, not a single recipe, and the evidence for its effect is still limited (explained below). The example unit is fictional. How grades are given and promotion criteria are defined by each school's student assessment system (SIEE), and curriculum references (standards, DBA, learning grids) should be consulted in the Ministry of Education's current official sources.</p>

<h2>The framework: three stages</h2>
<p>The "backward design" approach was systematized by Grant Wiggins and Jay McTighe in <em>Understanding by Design</em> (1998; second edition, 2005), with antecedents in Ralph Tyler's (1949) proposal to start from objectives. Its three stages:</p>
{{img:etapas}}
<ol>
<li><strong>Desired results:</strong> what should students understand, know and be able to do by the end? It helps to write them as observable performances ("justifies their procedures", not "sees proportionality").</li>
<li><strong>Acceptable evidence:</strong> what would they have to produce or do for me to believe they achieved it? It can be a test, but also a report, a presentation, a justified solution.</li>
<li><strong>Learning experiences:</strong> which activities lead students there? Only at this stage do you think about workshops, readings and projects.</li>
</ol>
<p>The template adds a fourth review, which is not from the original framework but the author's own: <strong>verify that everything points to the same thing</strong>. John Biggs called "constructive alignment" the related idea that outcomes, teaching and assessment must be aligned.</p>

<h2>The template in action: a proportionality unit (fictional example)</h2>
<p>The example unit is on proportionality in grade 7, with five desired outcomes: recognize ratios and proportions; solve direct and inverse proportionality problems; interpret proportionality graphs and tables; justify procedures with arguments; and use percentages to decide in consumer contexts. Four pieces of evidence are listed (a short test, a comparative shopping report, a problem notebook and a written self-assessment) and eight activities. On each sheet you mark with 1 which outcome each piece of evidence and each activity covers, and the <em>Alineacion</em> sheet calculates, outcome by outcome, how much evidence and how many activities it has:</p>
<ul>
<li><strong>O1, O2 and O5:</strong> aligned (they have evidence and activities).</li>
<li><strong>O3 (interpreting graphs):</strong> one activity and <strong>no evidence</strong>: <em>"Enseñas lo que no evalúas"</em> (you teach what you do not assess).</li>
<li><strong>O4 (justifying procedures):</strong> two pieces of evidence and <strong>no activity</strong>: <em>"Evalúas lo que no enseñas"</em> (you assess what you do not teach).</li>
<li>In addition, one activity (the closing video) <strong>develops no outcome</strong>: an "orphan" activity.</li>
</ul>
<p>Result: 3 of 5 outcomes aligned, 1 orphan activity and 0 orphan evidence (calculations verified in Excel). The two mismatches are typical, and almost never noticed until placed in a matrix: the student learned to make graphs but nobody asks about it, and is asked to justify without having practiced justifying. An orphan activity is not necessarily bad (it can motivate, close or care for the classroom climate), but it should be a conscious decision, not a habit.</p>
{{img:formas}}

<h2>How to write good outcomes, evidence and activities</h2>
<ul>
<li><strong>Outcomes:</strong> observable verb + content + condition ("solves direct and inverse proportionality problems in everyday situations"). Few and meaningful: three to six per unit.</li>
<li><strong>Evidence:</strong> more than one type (not just the written test) and with clear criteria (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a>). Each important outcome needs at least one piece of evidence.</li>
<li><strong>Activities:</strong> each must be able to answer "for which outcome?". If it cannot, it is a candidate for change or removal.</li>
<li><strong>Time distribution:</strong> the hardest outcomes need more activities and more evidence; the sheet shows the counts so you can see it.</li>
</ul>

<h2>What the evidence says (honestly)</h2>
<p>Backward design is popular and logical, but its empirical evidence is more modest than its fame. The research summaries most often cited come partly from the framework's own authors; there is a qualitative meta-synthesis (Uluçınar, 2021) reporting improvements in motivation, engagement and higher-order thinking, and small quasi-experimental studies in higher education. As far as I could verify, large-scale randomized controlled trials are missing, and much of the results are teacher perceptions or course-level outcomes, not standardized tests. Those same reviews note that success depends on teacher training and ongoing support, and weakens when goals are ambiguous. In other words: <strong>it is a good planning practice with solid conceptual backing and empirical evidence still being built</strong>; test it with your own data (see <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">how to test an educational tool in four weeks</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, outcome references come from the Ministry of Education: the Basic Competency Standards, the Basic Learning Rights (DBA, published since 2015; version 2 of 2016 was prepared with the Universidad de Antioquia) and the learning grids that develop them. An academic analysis of the preliminary 2016 and 2017 documents found complexity and some incoherence, a reminder that these references are read with judgment and not as a script. Each school also has its SIEE, which defines how students are assessed and promoted. Backward design fits this context because it forces you to connect three layers: the national reference (what), the evidence (how I know) and the activity (how I work on it). In the region and worldwide, backward design is used from basic to university education, and its defenders and critics agree on one point: without time to plan, it becomes one more form. For <strong>teachers</strong>, the challenge is time; for <strong>principals</strong>, to provide collective planning spaces (an outcome shared among teachers of the same grade avoids duplication and contradiction); for <strong>families</strong>, knowing what their child is expected to achieve is more useful than a list of topics; and for <strong>students</strong>, knowing the outcomes from the start is a way to make sense of what they do. See also <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">grades: learning or compliance</a> and, to adapt planning for students with learning barriers, <a href="/herramientas/piar/">PIAR with AI</a>.</p>

<h2>Tools and templates</h2>
<p>To generate learning evidence (questions, exams with answer keys and levels) aligned with your outcomes, and to organize your resources with AI (always reviewing what it produces), look at these tools of our own.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">the math error that keeps repeating</a>, <a href="/steam-sin-equipos-costosos-proyectos-materiales-cotidianos-plantilla/">STEAM without expensive equipment</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is backward design?</h3>
<p>An approach that starts from the desired learning outcomes, then defines the evidence that they were achieved and only afterward designs the activities. It is associated with Wiggins and McTighe (<em>Understanding by Design</em>, 1998).</p>
<h3>Is it the same as "planning by objectives"?</h3>
<p>It is similar, but it emphasizes understanding and defining the evidence before the activities. The idea of starting from objectives has antecedents in Tyler (1949).</p>
<h3>How do I know whether my unit is aligned?</h3>
<p>By checking that each important outcome has at least one piece of evidence and one activity, and that each activity and each piece of evidence serves some outcome. The template calculates it.</p>
<h3>Is there evidence that it improves learning?</h3>
<p>There are positive reports, mostly qualitative and from small studies; large-scale evidence is limited. It is worth testing with your own data.</p>
<h3>Does it work for any subject and grade?</h3>
<p>Yes, it is a general framework. The template's example is from mathematics, but the logic of aligning outcomes, evidence and activities applies in any area.</p>

<p class="notice"><strong>Review your next unit.</strong> Download the <a href="/descargas/planeacion-inversa/planeacion-inversa-alineacion.xlsx">backward design template</a> (in Spanish), write your next unit's outcomes, mark which evidence and activities cover them and see what the alignment sheet says.</p>

<h2>Food for thought</h2>
<p>Planning from the evidence seems obvious, but almost nobody does it naturally: it is easier to start from the activities we already know. <strong>How many of the activities we do each week could we justify with a concrete outcome? And when we find that we teach something we do not assess or assess something we do not teach, what is fairer to students: changing the assessment or changing the teaching?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:etapas}}' => $img('planeacion-inversa-etapas', 467, 'Four steps of backward design: outcomes, evidence, activities and alignment review.', 'Planning goes backward.'),
    '{{img:formas}}' => $img('planeacion-inversa-formas', 499, 'Table contrasting planning from the topic with planning from the outcome in four aspects: starting point, assessment, activities and risk.', 'Two ways of planning.'),
]);

return [
    'planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion' => [
        'slug' => 'backward-design-start-with-what-you-want-students-to-understand-alignment-template',
        'title' => 'Backward Design: Start with What You Want Students to Understand, with an Alignment-Checking Template',
        'excerpt' => 'Backward design in three stages (outcomes, evidence, activities) and an Excel template that checks whether what you teach and what you assess point to the same outcomes, with a proportionality example.',
        'seo_title' => 'Backward Design: Alignment Template',
        'seo_description' => 'How to plan backward: outcomes, evidence and activities, with an Excel template that detects what you teach but do not assess.',
        'focus_keyword' => 'backward design',
        'cover' => '/assets/img/articulos/planeacion-inversa/planeacion-inversa-portada-en',
        'cover_alt' => 'Cover "Backward design: start with what you want students to understand" with a card: 3 of 5 outcomes aligned in the example unit, two have a mismatch.',
        'content_html' => $html,
    ],
];
