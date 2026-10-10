<?php

declare(strict_types=1);

// English version of "Política institucional de IA para colegios: qué permitir, qué condicionar y qué …". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/politica-ia-colegio/' . $name . '-en';
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
<p>In many schools, artificial intelligence has already come in through the back door: students use it for homework, some teachers use it to plan and almost nobody knows, clearly, what is allowed. When there are no rules, each teacher improvises their own, the same piece of work is "fraud" in one classroom and "good use" in another, and students' data end up in tools nobody evaluated.</p>
<p>This article proposes how to build a short, applicable <strong>institutional AI policy</strong>, organized into three categories: <strong>allowed</strong>, <strong>conditional</strong> and <strong>not authorized</strong> uses. It includes a <a href="/descargas/politica-ia-colegio/matriz-politica-ia-colegio.xlsx">downloadable Excel matrix</a> (in Spanish) with 16 uses for teachers, students and principals, a tool evaluation and a use-declaration template. Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> An AI policy is not written to ban or to applaud technology, but to make clear <strong>who decides what</strong>: AI may assist; decisions about people (final grades, sanctions, promotion) and the care of minors' data stay in the hands of humans who answer for them. The policy is built with the educational community, tested and reviewed every year.</p>

<h2>Why it is needed</h2>
<p>Three data points help size the issue, with their limits:</p>
<ul>
<li>A Gallup and Walton Family Foundation survey in the US (June 2025, over 2,000 teachers) found that in schools with an AI policy the reported benefit was 26% greater. It is US, self-reported data, but it suggests that <strong>clear rules make technology pay off more</strong>.</li>
<li>According to the OECD (TALIS 2024), about 53% of Colombian teachers used AI in the past year, more than the OECD average (36%). Use is growing faster than rules.</li>
<li>A GAD3 study for Planeta Formación y Universidades, reported by El Tiempo in August 2026, indicates that 84% of higher-education students in Colombia use generative AI habitually and that only 35% have the skills to use it beyond a basic level. It covers higher education (not schools) and the outlet does not report the sample, so it is cited only as a signal.</li>
</ul>
<p>On rules: in September 2023, UNESCO published its first global guidance on generative AI in education and proposed <strong>13 as the minimum age</strong> for using these tools in the classroom, acknowledging that many consider that threshold too low; it also called for institutions to validate systems before making them available to students and for data protection standards to be adopted. It is a recommendation, not a Colombian rule. In Colombia, as far as I could verify on October 9, 2026, <strong>I found no specific national guidelines for AI use in schools</strong> (the Ministry of Education has published guidance for higher education, and the National AI Policy, CONPES 4144 of 2025, exists); it is advisable to confirm on the Ministry's website. Meanwhile, the institutional policy is where each school decides.</p>

<h2>The three categories</h2>
{{img:categorias}}
<ul>
<li><strong>Allowed:</strong> low-risk uses, with no personal data and not affecting assessment. Example: adapting a text to another reading level.</li>
<li><strong>Conditional:</strong> valuable uses accepted only if a concrete condition is met. Example: a draft of feedback that the teacher reviews and signs as their own.</li>
<li><strong>Not authorized:</strong> uses that affect decisions about people, compromise minors' data or are dishonest. Example: assigning the final grade with an automatic system.</li>
</ul>
<p>The key is that <strong>every "conditional" has a verifiable condition and an owner</strong>; otherwise it is an "allowed" in disguise.</p>

<h2>The matrix: 16 uses to start</h2>
<p>The downloadable workbook has an initial proposal; with it, 2 uses are allowed, 6 conditional and 8 not authorized. Here are some:</p>
<table>
<thead><tr><th>Who</th><th>Use</th><th>Category</th><th>Condition or reason</th></tr></thead>
<tbody>
<tr><td>Teacher</td><td>Generate drafts of lesson plans or rubrics</td><td>Conditional</td><td>The teacher reviews, corrects and adapts</td></tr>
<tr><td>Teacher</td><td>Grade or set the final grade automatically</td><td>Not authorized</td><td>Assessment is the teacher's decision</td></tr>
<tr><td>Teacher</td><td>Paste student data into a public AI</td><td>Not authorized</td><td>Minors' data: only in authorized tools</td></tr>
<tr><td>Teacher</td><td>AI detector as sole evidence to accuse</td><td>Not authorized</td><td>Not conclusive; dialogue and evidence of process are required</td></tr>
<tr><td>Student</td><td>Ask for explanations or examples</td><td>Conditional</td><td>School account or supervision and a use declaration</td></tr>
<tr><td>Student</td><td>Hand in AI text as their own</td><td>Not authorized</td><td>Academic dishonesty under the code of conduct</td></tr>
<tr><td>Student</td><td>Use AI while under 13</td><td>Not authorized</td><td>Only with a school account, supervision and family authorization</td></tr>
<tr><td>Principal</td><td>Decide admissions, sanctions or promotion with AI</td><td>Not authorized</td><td>Decisions about people: a human makes them</td></tr>
</tbody>
</table>
<p>Two points deserve explanation. First, <strong>AI detectors</strong>: there is no reliable way to prove that a text was written by a machine, and accusing a student based on a detector can be unfair; it is better to assess the process (drafts, oral defense, classwork) and apply the due process of the code of conduct (see <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">whether AI expands or replaces thinking</a>). Second, <strong>minors' data</strong>: Colombia's Law 1581 of 2012 restricts the processing of children's and adolescents' data and requires ensuring their best interests; that is why the rule is not to enter identifiable data into unauthorized tools (see <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">student data and AI personalization</a>).</p>

<h2>How to build it in four weeks</h2>
<ol>
<li><strong>Week 1: diagnosis.</strong> Ask teachers and students (anonymously) which tools they use and for what. You will probably be surprised.</li>
<li><strong>Week 2: draft with the community.</strong> Start from the matrix and discuss it with teachers, students, families and principals. What is decided with the community is respected more.</li>
<li><strong>Week 3: pilot.</strong> Test the policy in one or two groups and the use declaration on a real task; adjust what does not work.</li>
<li><strong>Week 4: approval and communication.</strong> Approve it in the governing board, add what is needed to the code of conduct and communicate it with concrete examples.</li>
<li><strong>Afterwards: review.</strong> At least once a year, or when the regulation or an important tool changes.</li>
</ol>

<h2>Evaluate a tool before authorizing it</h2>
<p>The "Evaluacion_herramienta" sheet has nine questions: is there a concrete need?, is it known what data it collects and why?, does it allow school accounts?, where is data stored and can it be deleted?, does the vendor use it to train its models?, can it be used with supervision and without the minor creating a personal account?, is there independent evidence?, is there an owner and an exit plan?, were families informed? If the data questions are answered "no", it is not authorized (see <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">schools' technology debt</a> and <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a>).</p>

<h2>The use declaration: honesty instead of a witch hunt</h2>
<p>Instead of chasing AI use, ask students to <strong>declare</strong> it: which tool they used, for what, what they asked, which part is theirs and how they verified the information. The workbook includes the template. Declaring changes the conversation: from "did you copy it?" to "what did you learn and how did you check it?". It is consistent with the idea that the real task is the student's thinking (see <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">pedagogical autonomy and platforms</a> and <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades measure</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, AI policies in education range from total bans to guided integration; what the best practices share is a combination of literacy, clear rules and data protection, as UNESCO proposes. In Colombia and Latin America the challenge is twofold: unequal access (not all students have the same tools at home) and the lack of specific guidelines, which leaves the decision to each institution. For <strong>principals</strong>, leading the process and being accountable; for <strong>teachers</strong>, having clarity and support to use AI with judgment; for <strong>students</strong>, learning to use it honestly; for <strong>families</strong>, knowing what data on their children is used and being able to have a say.</p>

<h2>Tools that already follow these rules</h2>
<p>The tools I build are designed so the teacher decides: the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> delivers the exam and its solutions for the teacher to review before using them; <a href="/herramientas/piar/">PIAR con IA</a> drafts documents that the expert team validates and does not replace their judgment; and the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> provides recipes by subject that are adapted, not copied. They are examples of well-resolved "conditional" uses.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a> and <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Is a school required to have an AI policy?</h3>
<p>As far as I could verify, there is no specific national obligation for schools; but having one is good practice, and the code of conduct and institutional autonomy allow it to be incorporated.</p>
<h3>Should schools ban ChatGPT and similar tools?</h3>
<p>A total ban is hard to enforce and does not teach students to use them with judgment. It is more realistic to define which uses are allowed, which are conditional and which are not, and to teach verification.</p>
<h3>Can children under 13 use AI?</h3>
<p>UNESCO recommends 13 as the minimum in the classroom and many providers set their own age. As a precaution, the matrix requires a school account, supervision and family authorization.</p>
<h3>Are AI detectors usable to sanction?</h3>
<p>Not as sole evidence: they are not conclusive. Assess the student's process and apply the code of conduct's due process.</p>
<h3>How often is the policy reviewed?</h3>
<p>At least once a year, and sooner if the regulation changes or an important tool is adopted.</p>

<p class="notice"><strong>Start with the matrix.</strong> Download the <a href="/descargas/politica-ia-colegio/matriz-politica-ia-colegio.xlsx">AI policy matrix</a> (in Spanish), adapt it with your educational community and try the use declaration on a task. It includes the tool evaluation.</p>

<h2>Food for thought</h2>
<p>An AI policy is written to protect students and the craft of teaching, but it can also become a form of control. <strong>Who should have a voice in a school's AI rules: only principals and teachers, or also the students who will live with these tools all their lives? And if a rule bans what students at better-resourced schools can use freely at home, are we protecting or widening the gap?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:categorias}}' => $img('politica-ia-colegio-categorias', 444, 'Table with the three categories of an AI policy: allowed, conditional and not authorized, each with an example and its rule.', 'The three categories of an AI policy.'),
]);

return [
    'politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar' => [
        'slug' => 'school-ai-policy-what-to-allow-condition-and-not-authorize',
        'title' => 'An Institutional AI Policy for Schools: What to Allow, What to Condition and What Not to Authorize',
        'excerpt' => 'How to build a short, applicable AI policy for a school, with three categories of use, a matrix of 16 uses for teachers, students and principals, a tool evaluation and a use declaration.',
        'seo_title' => 'School AI Policy: What to Allow and What Not To',
        'seo_description' => 'Build an AI policy for your school: allowed, conditional and not-authorized uses, with a downloadable matrix, tool evaluation and use declaration.',
        'focus_keyword' => 'school AI policy',
        'cover' => '/assets/img/articulos/politica-ia-colegio/politica-ia-colegio-portada-en',
        'cover_alt' => 'Cover "An institutional AI policy for schools: what to allow, condition and not authorize" with a list: adapt a reading text and a draft the teacher reviews, ticked; automatic final grade and minors\' data in public AI, crossed out.',
        'content_html' => $html,
    ],
];
