<?php

declare(strict_types=1);

// English version of «Más plataformas no significa mejor educación: la deuda tecnológica silenciosa de…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/deuda-tecnologica-colegios/' . $name . '-en';
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
<p>A school starts with an academic platform. Then comes a virtual classroom, then an app to talk to families, the math platform brought by an enthusiastic teacher, an AI slide generator, a WhatsApp group for each class… Each decision, on its own, seemed reasonable. Together they form something almost nobody measures: a <strong>silent technology debt</strong>, made of accounts nobody remembers, data scattered across places nobody controls and tools that do the same thing under different names.</p>
<p>In this article I explain what that debt is, what the data say about the growth of tools in schools and propose <strong>three criteria</strong> (integration, pedagogical value and sustainability) to decide which tool stays, which is merged and which is retired. It includes a <a href="/descargas/deuda-tecnologica/inventario-herramientas-colegio.xlsx">downloadable Excel inventory</a> with an example school. Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> More tools does not mean better education: UNESCO warns that there is little robust, independent evidence on the value of education technology and that products change on average every 36 months. Each new tool adds cost, data to protect, training and support. The answer is not to ban, but to <strong>inventory, score and decide</strong> with explicit criteria and together with the people who use them.</p>

<h2>What technology debt is</h2>
<p>The term "technical debt" was proposed by programmer Ward Cunningham in 1992 to describe software shortcuts that save time today and charge interest tomorrow. Applied to a school, the idea extends: every tool adopted without criteria is a <strong>loan</strong> paid with maintenance, accounts to manage, data to protect and the attention of teachers who already have little time. The interest is silent because it does not appear in a single budget: it is spread across the principal's office, coordination, IT and every classroom.</p>
<p>Typical signs: two or three tools for the same function, teachers typing the same information in several places, accounts of people who no longer work at the school, paid platforms used by a single class, and nobody who can say for sure where the students' data are.</p>

<h2>What the data say</h2>
<p>UNESCO's <a href="https://gem-report-2023.unesco.org/">2023 Global Education Monitoring Report</a> concludes that there is little robust, impartial evidence on the added value of digital technology in education, that much of the evidence comes from those who sell it and that products change, on average, every 36 months, often before they can be evaluated. In a survey of teachers and administrators in 17 US states, only 11% asked for peer-reviewed evidence before adopting a tool.</p>
<p>On the size of the problem, LearnPlatform's EdTech Top 40 report (now part of Instructure), based on real usage in US districts, reported that districts used on average <strong>2,591 different tools</strong> in the 2022-23 school year, up from 2,547 the year before (according to <a href="https://www.k12dive.com/news/school-districts-ed-tech-use/685995/">K-12 Dive's coverage</a>, July 2023). Those are districts with thousands of students, not a single school; but they show the trend: <strong>tools accumulate faster than they are retired</strong>. I found no comparable figure published for Colombia, so the first step is to do your own inventory.</p>

<h2>Three criteria to decide</h2>
<p>I suggest scoring each tool from 0 to 2 on three criteria (framework by the author):</p>
{{img:criterios}}
<ol>
<li><strong>Integration.</strong> Does it share data with the core system (enrollment, grades, users) or force double entry? An isolated tool creates inconsistencies and extra work. 0 = island; 1 = manual import or export; 2 = integrates automatically.</li>
<li><strong>Pedagogical value.</strong> Is there <em>local</em> evidence that it improves something: attendance, homework submission, participation, results? The vendor's promise is not enough. 0 = unused; 1 = used by a small group; 2 = used and backed by evidence.</li>
<li><strong>Sustainability.</strong> Does it have an owner, a budget and a plan to extract the data if it stops being used? 0 = nobody answers for it; 1 = owner but no budget or no exit plan; 2 = owner, budget and exit.</li>
</ol>
<p>The sum (0 to 6) suggests a decision: <strong>retire or replace</strong> if value is 0 or the score is 2 or less; <strong>merge</strong> if a function is duplicated and a better-scoring tool exists; <strong>keep</strong> with 5 or more; and <strong>review</strong> in the other cases. It is a starting point for conversation, not a verdict.</p>

<h2>An example school: 12 tools</h2>
<p>The downloadable inventory includes a fictional school with 12 tools and an annual spend of 59.7 million pesos. Scoring them gives this:</p>
<table>
<thead><tr><th>Suggested decision</th><th>Tools</th><th>Annual spend</th></tr></thead>
<tbody>
<tr><td><strong>Keep</strong></td><td>Academic platform, office suite, assessment forms</td><td>27.0 million</td></tr>
<tr><td><strong>Review</strong></td><td>Institutional virtual classroom, family messaging app, math platform A, videoconferencing</td><td>21.9 million</td></tr>
<tr><td><strong>Retire or replace</strong></td><td>A teacher's own virtual classroom, WhatsApp groups, math platform B, AI slide generator, unused reading platform</td><td>10.8 million (18.1%)</td></tr>
</tbody>
</table>
{{img:gasto}}
<p>Notice what the exercise reveals. <strong>Three functions were duplicated</strong> (virtual classroom, family communication and math practice): half the tools competed with each other. A reading platform cost 5.4 million and scored zero on value. And seven of the twelve held personal data with low sustainability, that is, <strong>no owner or no plan to extract the data</strong>. That last point is the most serious: processing minors' data demands care (see <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">student data and AI personalization</a>), and Colombia's Law 1581 of 2012 makes the data controller, here the school, answerable for the data it hands to third parties.</p>
<p>One caution: <strong>retiring is not blindly deleting</strong>. Before closing a tool, consult its users, back up its data and define when and how students' data will be deleted.</p>

<h2>How to do it in three weeks</h2>
<ol>
<li><strong>Week 1: inventory.</strong> List every tool (including free ones and those a teacher adopted on their own): function, users, cost, data handled and owner. Ask the teachers; the "invisible" accounts show up there.</li>
<li><strong>Week 2: scoring.</strong> Score with the leadership team and at least two teachers who use them. Record evidence, not just opinion.</li>
<li><strong>Week 3: decision and calendar.</strong> Decide what is kept, merged or retired, with dates, backups and communication to the community. Name an owner and repeat the exercise every year.</li>
</ol>
<p>And a rule for the future: <strong>a new tool comes in only if another goes out or if it passes the three criteria before purchase</strong> (the three-year cost analysis in <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a> helps with the economic factor).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, the debate has moved from "do we have technology?" to "what does it do for learning?". In Colombia and Latin America the pressure comes from two sides: the persistent connectivity and equipment gap in many areas and, in schools that do have resources, the constant supply of platforms and AI. According to the OECD (TALIS 2024), about 53% of Colombian teachers used AI in the past year, more than the OECD average (36%): use is growing faster than institutional rules. For <strong>principals</strong>, the task is ordering the portfolio and accounting for the spend; for <strong>teachers</strong>, that tools save work instead of multiplying it (see <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">pedagogical autonomy and platforms</a>); for <strong>families</strong>, knowing which companies receive their children's data and why so many apps are used.</p>

<h2>Tools designed to add up, not pile up</h2>
<p>Part of reducing debt is choosing a few tools that do several things well and let the teacher decide. The <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> brings exam creation, solutions and grading together in one place; and the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> organizes recipes by subject without requiring yet another platform to maintain. For attention to diversity, <a href="/herramientas/piar/">PIAR con IA</a> keeps each student's reasonable adjustments in a single document, reviewed by the expert team, instead of scattering them across folders and chats.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a>, <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">the cloud is not a backup</a> and <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is technology debt in a school?</h3>
<p>It is the accumulated cost of tools adopted without criteria: maintenance, accounts, data to protect, training and duplicated work, paid for with the school's time.</p>
<h3>How many digital tools are too many?</h3>
<p>There is no universal number. The signs are duplication (several tools for the same function), low use and no owner. That is why it is better to score each one than to count them.</p>
<h3>Should I remove free tools?</h3>
<p>Free tools cost too: personal data, time and risk. Apply the same criteria and pay attention to what student data they handle and who answers for it.</p>
<h3>How do I convince a teacher to give up a favorite tool?</h3>
<p>With evidence and dialogue: show the duplication, ask what their tool does better and assess whether the school can adopt it instead of the other. Retiring without listening breeds resistance.</p>
<h3>What do I do with the data of a platform I am closing?</h3>
<p>Export and back up what must be kept, and ask the vendor to delete the students' data, leaving written confirmation.</p>

<p class="notice"><strong>Do the inventory this week.</strong> Download the <a href="/descargas/deuda-tecnologica/inventario-herramientas-colegio.xlsx">school tools inventory</a>, replace the example data with yours and score each tool. It needs Excel 2019 or Microsoft 365 (the decision column uses MAXIFS). The workbook is in Spanish.</p>

<h2>Food for thought</h2>
<p>Every tool we adopt promises to save time, but each also consumes attention, data and budget. <strong>Is the school choosing its tools for what its educational project needs, or for what the market offers? And who should have the last word on retiring a platform that students use: the principal, the teachers who use it, the families whose data it stores or the students themselves?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:criterios}}' => $img('deuda-tecnologica-colegios-criterios', 444, 'Table with three criteria for assessing a digital tool: integration with the core system, pedagogical value with local evidence and sustainability with owner, budget and exit plan, each with its warning sign.', 'The three criteria to decide which tool stays.'),
    '{{img:gasto}}' => $img('deuda-tecnologica-colegios-gasto', 392, 'Bars with the example school\'s annual spend by suggested decision: keep 27 million pesos, review 21.9 and retire or replace 10.8.', 'Annual spend by suggested decision in the example school.'),
]);

return [
    'mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios' => [
        'slug' => 'more-platforms-not-better-education-school-technology-debt',
        'title' => 'More Platforms Does Not Mean Better Education: The Silent Technology Debt of Schools',
        'excerpt' => 'What technology debt is in a school, what the data say about tool accumulation and three criteria (integration, pedagogical value and sustainability) to decide which to keep, merge or retire, with an Excel inventory.',
        'seo_title' => 'School Technology Debt: Which Tools to Keep',
        'seo_description' => 'How to spot redundant tools in a school with three criteria (integration, pedagogical value, sustainability) and a downloadable Excel inventory.',
        'focus_keyword' => 'school technology debt',
        'cover' => '/assets/img/articulos/deuda-tecnologica-colegios/deuda-tecnologica-colegios-portada-en',
        'cover_alt' => 'Cover "More platforms is not better education: the silent technology debt" with a card saying 5 of 12 tools in the example school would be retired, 18% of annual spending, with three duplicated functions and four tools to review.',
        'content_html' => $html,
    ],
];
