<?php

declare(strict_types=1);

// English version of «Base de conocimiento del colegio: que la respuesta exista, esté al día y tenga d…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/base-de-conocimiento/' . $name . '-en';
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
<p>A new teacher asks for the third time this week how to upload grades. The coordinator answers from memory, again. The school has a document with the steps, but it is in an old email folder, has screenshots from the previous version of the platform and nobody knows who should update it. The answer <strong>exists</strong>, but it is not <strong>available, current or owned by anyone</strong>. In practice, it is as if it did not exist, and knowledge keeps living in the heads of three people.</p>
<p>This article proposes a simple <strong>institutional knowledge base</strong>: a set of short articles for the questions that repeat most, each with an owner and a review date, and a way to measure whether they truly cover what people ask. It includes an <a href="/descargas/base-de-conocimiento/base-de-conocimiento-colegio.xlsx">Excel workbook</a> (in Spanish) with twelve articles and ten fictional frequent questions, verified in Microsoft Excel 16 and against an independent calculation.</p>
<p class="notice"><strong>Scope.</strong> This is a basic framework, inspired by knowledge management practices in IT services (such as ITIL and the KCS methodology, cited as general reference, without claiming to reproduce them). The data are fictional; review periods and thresholds are examples you must adjust. Do not put passwords, student personal data or confidential information in the base.</p>

<h2>Why knowledge gets lost</h2>
<p>In a school, operational knowledge (how a grade is entered, how a room is booked, who to call when the internet fails) is usually spread across three places: people's memory, loose documents and chat messages. This fails in three ways:</p>
<ul>
<li><strong>It depends on who is there.</strong> When the person who knows gets sick, leaves or changes roles, the knowledge leaves with them (the so-called "bus factor").</li>
<li><strong>It becomes outdated silently.</strong> The platform changes, the form changes, and the document still says the old thing. A wrong step costs more than no instructions, because people trust it.</li>
<li><strong>It generates repeated tickets.</strong> Every question that has a written answer nobody finds goes back to the help desk (see <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">the help desk without costly software</a>).</li>
</ul>

{{img:condiciones}}
<h2>What makes an article reliable</h2>
<ol>
<li><strong>An owner.</strong> A person or team that can be asked to update it. Without an owner, an article is an orphan and rots.</li>
<li><strong>Review dates.</strong> The last review and how often it should be reviewed (processes that change often, like a platform, need shorter reviews than a stable procedure).</li>
<li><strong>Tested steps.</strong> Someone other than the author followed them and they worked, with screenshots of the current version.</li>
<li><strong>A link from where people ask.</strong> The help desk answers with the article's link, and repeated questions become new articles.</li>
</ol>
<p>A short article with an owner and a date is worth more than a hundred-page manual nobody reads. A simple structure is enough for each: <em>what problem it solves, for whom, numbered steps, what to do if it does not work and whom to write to</em>.</p>

<h2>The Excel workbook</h2>
<ul>
<li><strong>Parametros:</strong> the review date (enter today's; a cell is used instead of <code>TODAY()</code> so the result is reproducible) and the days of advance notice to mark "Due soon".</li>
<li><strong>Articulos:</strong> twelve articles with their category, owner, last review and how many days between reviews. It calculates the next review, days remaining and the status: <em>Current</em>, <em>Due soon</em>, <em>Outdated</em> or <em>No owner</em> (shown in the workbook in Spanish).</li>
<li><strong>Preguntas:</strong> the ten most frequent help desk questions of a quarter, with the number of tickets and the article that answers them (if any). The status column says whether the answer is reliable.</li>
<li><strong>Resumen:</strong> the key counts.</li>
</ul>
<pre><code>' Article status (owner in D, days to expiry in H, notice period in Parametros!B4)
=IF(D2="","Sin responsable",IF(H2<0,"Vencido",IF(H2<=Parametros!$B$4,"Por vencer","Vigente")))     ' English
=SI(D2="";"Sin responsable";SI(H2<0;"Vencido";SI(H2<=Parametros!$B$4;"Por vencer";"Vigente")))   ' Spanish

' Status of the answer to a frequent question (article ID in D)
=IF(D2="","Sin artículo",VLOOKUP(D2,Articulos!$A$2:$I$13,9,FALSE))                                  ' English
=SI(D2="";"Sin artículo";BUSCARV(D2;Articulos!$A$2:$I$13;9;FALSO))                                 ' Spanish

' Tickets without a reliable answer (no article, outdated or no owner)
=SUMIF(Preguntas!E2:E11,"Sin artículo",Preguntas!C2:C11)                                            ' English</code></pre>

<h2>What the example showed (fictional data)</h2>
{{img:estado}}
<p>With a review date of February 1, 2027:</p>
<ul>
<li><strong>Of 12 articles: 6 current, 2 due soon, 3 outdated and 1 with no owner.</strong> The password one (current) was reviewed 83 days ago and must be reviewed every 180; the Wi-Fi one has been outdated for 156 days (reviewed in March 2026 and due every 180); the one on creating a virtual classroom has no owner.</li>
<li><strong>Of the ten most frequent questions (382 tickets in the quarter):</strong> 201 tickets (52.6%) have a current or due-soon answer; 138 (36.1%) point to an outdated article or one with no owner, and 43 (11.3%) have no article. <strong>In total, 47.4% of frequent tickets have no reliable answer.</strong></li>
<li>The useful reading is not "three articles are outdated" but <strong>which ones</strong>: the two costliest are the Wi-Fi one (64 tickets) and the ownerless virtual classroom one (41 tickets), and they matter far more than the projector one (outdated, but few queries). Prioritize by queries, not by age.</li>
<li>The two questions with no article (access to the attendance system and creating a new teacher's account, 43 tickets in total) are the two articles most urgent to write.</li>
</ul>
<p><strong>An honest reading:</strong> the workbook measures whether the article exists and is up to date, not whether it is good. A current article can be badly written, and an outdated one can still be right. The date is an alarm to review, not a verdict. And the numbers depend on the ticket log being reliable.</p>

<h2>How to start in a school</h2>
<ol>
<li><strong>Start from tickets.</strong> Take the ten questions that repeat most (from the help desk, from emails or from what the coordinator answers from memory).</li>
<li><strong>Write one article per question,</strong> short and tested by someone else, and assign an owner and a review frequency.</li>
<li><strong>Publish it where people ask:</strong> a single, easy-to-find place, and have the help desk answer with the link.</li>
<li><strong>Review monthly</strong> with the workbook: what expired, what has no owner, which question still has no article.</li>
<li><strong>Protect what is sensitive:</strong> access with permissions, no passwords or student data in articles (see <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">the technology inventory</a> and <a href="/plan-continuidad-operativa-colegio-analisis-impacto-rto-rpo-excel/">the continuity plan</a>, where an offline-available knowledge base helps in an outage).</li>
</ol>
<p>If the school already works with AI tools, an assistant can help draft or summarize articles, but <strong>only with non-confidential information</strong> and always with human review (see the <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">institutional AI policy</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Knowledge management in IT services is an established practice in companies and universities, where the share of queries resolved with a self-service article is measured. In Colombian and Latin American schools, the most common resource is still the memory of the systems person or the secretary's office, with high staff turnover in some contexts making it worse. Worldwide, the evidence on self-service models shows benefits when content is maintained and frustration when it is out of date. For <strong>teachers</strong>, a clear base reduces dependence on the same three people; for <strong>principals</strong>, it is a cheap way to get continuity and onboard new staff; for <strong>families</strong>, consistent answers on payments, report cards and access; and for <strong>students</strong>, less time lost not knowing whom to ask.</p>

<h2>Tools and templates</h2>
<p>If you work with the site's Excel templates and want support, or prepare material with AI (always reviewing what it produces and without including personal or confidential data in tools not designed to safeguard it), take a look at these products.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: the <a href="/descargas/base-de-conocimiento/base-de-conocimiento-colegio.xlsx">knowledge base workbook</a>, <a href="/implementar-plataforma-colegio-30-dias-plan-piloto-decision-excel/">implementing a platform in 30 days</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Frequently asked questions</h2>
<h3>What is an institutional knowledge base?</h3>
<p>A set of short articles, each with an owner and a review date, that answer the questions that repeat most in the institution.</p>
<h3>How many articles do I start with?</h3>
<p>Ten: the ones that answer the most frequent questions. Better few and current than many and outdated.</p>
<h3>How often should an article be reviewed?</h3>
<p>It depends on how fast the process changes: platform or form articles, every few months; stable ones, once a year. The workbook lets you set the frequency per article.</p>
<h3>What do I do with an outdated article?</h3>
<p>Check the steps against the current version: if still right, update the review date; if not, fix it. Prioritize those that generate the most questions.</p>
<h3>Can I put passwords or student data in an article?</h3>
<p>No. A knowledge base is not a place for credentials or for personal or confidential data.</p>

<p class="notice"><strong>Measure your knowledge base.</strong> Download the <a href="/descargas/base-de-conocimiento/base-de-conocimiento-colegio.xlsx">knowledge base workbook</a> (in Spanish), replace the fictional data with your articles and your ten most frequent questions, and look first at which outdated or ownerless articles generate the most tickets.</p>

<h2>Food for thought</h2>
<p>When knowledge lives in the heads of a few people, the school depends on their memory and availability, and they pay the cost of always being the ones who know. <strong>What does a single person at your school know today that, if they left tomorrow, would leave everyone else without knowing how to do it? And who would have to write it down, and who would have to check it is right?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:condiciones}}' => $img('base-de-conocimiento-condiciones', 499, 'Table with four conditions of a reliable article, what each prevents and what it looks like: owner, review date, tested steps and link from the help desk.', 'Four conditions of a good article.'),
    '{{img:estado}}' => $img('base-de-conocimiento-estado', 480, 'Bar chart of tickets by answer status: 172 current, 29 due soon, 97 outdated, 41 no owner and 43 no article.', 'Tickets by answer status.'),
]);

return [
    'base-de-conocimiento-colegio-articulos-responsable-fecha-revision-excel' => [
        'slug' => 'school-knowledge-base-articles-owner-review-date-excel',
        'title' => 'A School Knowledge Base: The Answer Must Exist, Be Up to Date and Have an Owner, with an Excel Workbook',
        'excerpt' => 'How to build an institutional knowledge base with short articles, an owner and a review date, and measure with Excel how many frequent questions are left without a reliable answer.',
        'seo_title' => 'School Knowledge Base: Guide and Excel Workbook',
        'seo_description' => 'How to build a school knowledge base: articles with an owner and review date, tickets with no answer and a verified Excel workbook.',
        'focus_keyword' => 'school knowledge base',
        'cover' => '/assets/img/articulos/base-de-conocimiento/base-de-conocimiento-portada-en',
        'cover_alt' => 'Cover "A school knowledge base: the answer must exist and be up to date" with a card: 47.4% of frequent tickets without a reliable answer.',
        'content_html' => $html,
    ],
];
