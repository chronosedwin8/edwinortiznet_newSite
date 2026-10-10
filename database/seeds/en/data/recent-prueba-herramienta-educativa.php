<?php

declare(strict_types=1);

// English version of «Una prueba de cuatro semanas para saber si una herramienta educativa realmente m…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/prueba-herramienta-educativa/' . $name . '-en';
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
<p>A vendor promises its platform "improves performance by up to 30%". A teacher tries it for a month with a class and grades go up. Does the tool work? The honest answer, almost always, is: <strong>we do not know</strong>. The students would have improved anyway (more classes, more practice, more maturity), the final test may have been easier, and the group was excited by the novelty.</p>
<p>This article proposes a <strong>four-week test</strong>, within reach of any teacher or school, to assess whether an educational tool improves learning. It includes a <a href="/descargas/prueba-herramienta-educativa/ficha-prueba-4-semanas-herramienta-educativa.xlsx">downloadable Excel worksheet</a> (in Spanish) that computes the results and a <a href="/descargas/prueba-herramienta-educativa/simulacion-prueba-herramienta.py">Python simulation</a> showing why "before and after" misleads. Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> To know whether a tool works you have to compare: one group that uses it and a similar one that does not, measured with the same test at the start and the end, with the success criterion defined <strong>beforehand</strong>. In my simulation, a tool that did nothing "improved" grades in 67% of tests without a comparison group. With few students, even with a comparison chance matters; that is why the result is interpreted with caution and repeated.</p>

<h2>Why we almost never know whether it works</h2>
<p>UNESCO's <a href="https://gem-report-2023.unesco.org/">2023 Global Education Monitoring Report</a> concludes that there is little robust, impartial evidence on the value of technology in education, that much of it comes from those who sell it, that products change on average every 36 months and that only 11% of teachers and administrators surveyed in 17 US states asked for peer-reviewed evidence before adopting a tool. There is progress: according to a LearnPlatform by Instructure release of June 30, 2025, 45% of the tools in its EdTech Top 40 list had published research under the evidence tiers of the US ESSA law, up from 32% the year before. Those tiers run from randomized studies (strong evidence), through quasi-experimental and correlational studies with controls, down to a simple "reasonable rationale". In other words, <strong>not all evidence weighs the same</strong>, and the best you can do in your classroom is move toward the strong end of that scale.</p>

<h2>Why "before and after" misleads</h2>
<p>The classic trap: apply the tool, measure before and after, and credit it with the improvement. But students learn in four weeks even without a new tool. I simulated it with fictional, editable assumptions: students' level ~ N(60, 12); measurement error of 6 points per test; natural growth of 4 points in four weeks; true effect of the tool, zero.</p>
<ul>
<li><strong>Without a comparison group</strong>, with 12 students: the tool "improved" grades by 3 points or more in <strong>67%</strong> of tests, even though it did nothing.</li>
<li><strong>With a comparison group</strong> assigned at random, looking at the difference in gains, chance produced an "advantage" of 3 points or more in <strong>19%</strong> of tests with 12 students per group, <strong>11%</strong> with 25 per group and <strong>3%</strong> with 60 per group.</li>
<li>And if the tool did add 5 real points, the test detected it (observed difference of 3 or more) in 72% of cases with 12 per group, 80% with 25 and 90% with 60.</li>
</ul>
{{img:azar}}
<p>What the simulation shows: with small groups, <strong>chance and natural growth can look like an improvement, and a real improvement can go unnoticed</strong>. An inconclusive result is not a failure: it is honest information about what your test could detect.</p>

<h2>The four-week test, step by step</h2>
{{img:pasos}}
<ol>
<li><strong>Define before you start.</strong> The tool, the hypothesis ("students who use it will improve more than those who do not, in…"), a <strong>concrete learning outcome</strong> (not usage or satisfaction) and the success criterion. Writing it down first prevents adjusting the criterion to the results.</li>
<li><strong>Form two similar groups.</strong> Ideally assign at random (by lottery) among students or classes. If that is not possible, choose comparable groups (same grade, level and teacher) and say so clearly: the result will be less firm.</li>
<li><strong>Measure at the start.</strong> The same test for both groups, with grading criteria defined in advance. The <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> helps you produce two equivalent versions with their solutions.</li>
<li><strong>Apply for four weeks.</strong> One group uses the tool at a defined dose (for example, three 20-minute sessions per week) and the other continues usual practice. Note anything that changes for both.</li>
<li><strong>Measure at the end</strong> with the same or an equivalent test.</li>
<li><strong>Compare gains, not final grades.</strong> Compute each student's gain (final − initial), the average per group and the difference between averages. Also look at the effect size and, if you can, a p-value.</li>
<li><strong>Decide with caution.</strong> A small difference with few students is "inconclusive": enlarge the sample or repeat before buying.</li>
</ol>
<p>An ethical point: if the tool may help, offer it to the comparison group after the four weeks (a "waitlist" design). That way nobody misses the opportunity. And remember data: the tool must meet privacy rules (see the <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">institutional AI policy</a> and <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">student data</a>).</p>

<h2>The Excel worksheet: an example</h2>
<p>The worksheet has a design sheet with ten questions to answer before starting, a data sheet and a results sheet with the formulas ready. With fictional data for 12 students per group (in which I simulated a true effect of 4 points), the workbook computes an average gain of 7.4 points with the tool and 4.7 without it: a difference of 2.8 points, an effect size of 0.27 and a p-value of 0.51. The suggested reading is <strong>"positive difference but inconclusive"</strong>. That is: although the effect was real, with 12 students per group the test cannot tell it from chance. That is the lesson: <strong>with small samples, you have to repeat and accumulate evidence</strong> (for example, across several classes or schools).</p>
<p>A note on reading results: a low p-value does not prove the tool caused the improvement if the groups were not comparable, and a high p-value does not prove the tool is useless. And effect size (around 0.2 small, 0.5 medium and 0.8 large, by Cohen's convention) says how much, not just whether it differs from zero.</p>

<h2>What else can skew the test</h2>
<ul>
<li><strong>Novelty effect:</strong> anything new excites at first; four weeks may not show the sustained effect.</li>
<li><strong>Teacher effect:</strong> if an enthusiastic teacher applies the tool and another the usual method, you do not know whether the tool or the teacher worked.</li>
<li><strong>A test that favors the tool:</strong> measuring with exercises identical to the platform's measures practice, not transferable learning.</li>
<li><strong>Students who drop out:</strong> if the weakest leave, the average rises without real improvement.</li>
<li><strong>Measuring the easy thing:</strong> usage time or satisfaction is not learning.</li>
</ul>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, "evidence first" is gaining ground, driven by frameworks like ESSA in the US. In Colombia and Latin America, most technology purchase decisions in schools are made with vendor demos and little independent evidence, and local trials barely exist. Here, a four-week test in a school is modest but useful: it produces your own evidence, in your context, with your students. For <strong>principals</strong>, it is a way to spend with judgment (see <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">schools' technology debt</a> and <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a>); for <strong>teachers</strong>, to exercise their pedagogical autonomy with data (see <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">autonomy and platforms</a>); for <strong>families</strong>, to know that what is used with their children was tested, and for <strong>students</strong>, not to be guinea pigs without knowing it (with transparency and consent).</p>

<h2>Tools to prepare the test</h2>
<p>Two equivalent versions of a test, with keys and solutions, are the basis of measurement. The <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> produces them for you to review, and the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> offers recipes by subject for planning the sessions. There is also a <a href="/examenes/demo/">free demo of the generator</a>.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">does AI expand or replace student thinking?</a> and <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades measure</a>. If you want to analyze the results more deeply in Excel, see <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">forecasting in Excel</a> to learn to test a model before believing it.</p>

<h2>Frequently asked questions</h2>
<h3>How many students do I need for a valid test?</h3>
<p>The more, the better. With 12 per group only large effects are detected; in my simulation, a true effect of 5 points was detected in 72% of tests with 12 per group and in 90% with 60. With few students, repeat the test across several classes.</p>
<h3>What do I do if I cannot assign groups at random?</h3>
<p>Choose groups as similar as possible (grade, level, teacher), measure at the start to check they began alike and acknowledge that the result will be less firm.</p>
<h3>How long should the test last?</h3>
<p>Four weeks is a practical minimum to see changes; the novelty effect can inflate the result, so a longer test or a repetition gives more confidence.</p>
<h3>Is it ethical to leave one group without the tool?</h3>
<p>If there are doubts about the benefit, it is reasonable. For fairness, offer the tool to the comparison group at the end (waitlist) and obtain the necessary authorizations.</p>
<h3>Is evidence from other countries useful to me?</h3>
<p>It is a starting point, but it depends on context: curriculum, language, resources and teachers. That is why it pays to test in your own classroom.</p>

<p class="notice"><strong>Before buying the next tool.</strong> Download the <a href="/descargas/prueba-herramienta-educativa/ficha-prueba-4-semanas-herramienta-educativa.xlsx">four-week test worksheet</a> (in Spanish), answer the ten design questions and try it with two groups. And if you want to see why "before and after" misleads, run the <a href="/descargas/prueba-herramienta-educativa/simulacion-prueba-herramienta.py">simulation</a>.</p>

<h2>Food for thought</h2>
<p>Demanding evidence before adopting a tool sounds sensible, but it can also slow innovation and burden teachers with researcher's work. <strong>Who should produce the evidence on the effect of an educational tool: the vendors who sell it, the institutions that buy it, the teachers in their classrooms or the State? And while the evidence arrives, is it more responsible to wait or to let today's students be the ones who produce it?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:azar}}' => $img('prueba-herramienta-educativa-azar', 392, 'Bars with the percentage of times chance makes a useless tool look like it wins by 3 points or more: 19.1% with 12 students per group, 11.1% with 25 and 2.6% with 60.', 'With small groups, chance produces differences that look like gains.'),
    '{{img:pasos}}' => $img('prueba-herramienta-educativa-pasos', 467, 'Five steps of the four-week test: define, measure at the start, apply for four weeks, measure at the end, and compare and decide.', 'The five steps of the test.'),
]);

return [
    'prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje' => [
        'slug' => 'four-week-test-does-an-educational-tool-improve-learning',
        'title' => 'A Four-Week Test to Find Out Whether an Educational Tool Really Improves Learning',
        'excerpt' => 'How to assess in your classroom, with a comparison group, whether an educational tool improves learning: why "before and after" misleads (simulation), five steps, an Excel worksheet and how to read the results with caution.',
        'seo_title' => 'Does This Edtech Tool Work? A Four-Week Test',
        'seo_description' => 'How to test in your classroom whether an educational tool improves learning: comparison group, simulation, Excel worksheet and careful reading of results.',
        'focus_keyword' => 'does edtech work test',
        'cover' => '/assets/img/articulos/prueba-herramienta-educativa/prueba-herramienta-educativa-portada-en',
        'cover_alt' => 'Cover "Does this educational tool work? A four-week test to find out" with a card: 67% of before-and-after tests show improvement even if the tool does nothing, a simulation of 12 students with natural growth of 4 points.',
        'content_html' => $html,
    ],
];
