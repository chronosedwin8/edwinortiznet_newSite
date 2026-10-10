<?php

declare(strict_types=1);

// English version of "¿El docente está perdiendo autonomía pedagógica ante las plataformas que planean…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/autonomia-docente-plataformas/' . $name . '-en';
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
<p>A few years ago, planning, assessment and recommendations about what to teach depended mostly on the teacher and their team. Today there are platforms that suggest each student's path, grade automatically, generate AI lesson guides and recommend "the next content". Many truly save time. But every decision the platform makes by default is a decision the teacher no longer makes, and by not making it, they may forget how it is made.</p>
<p>In this article I contrast <strong>technological assistance</strong> with <strong>replacing professional judgment</strong>, review the evidence and the legal framework in Colombia, and give you a <strong>decision matrix</strong> to define which decisions must remain the teacher's responsibility. Data checked on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> Evidence on the value of educational technology is limited and often comes from those who sell it (UNESCO, 2023); Colombia's Constitution guarantees academic freedom and Law 115 recognizes schools' autonomy to adopt teaching methods. Technology helps when the teacher decides when to use it, understands it and can ignore it. The line: <strong>assisting, yes; deciding for the teacher, no</strong>.</p>

<h2>What the evidence says: little, and sometimes interested</h2>
<p>UNESCO's <a href="https://gem-report-2023.unesco.org/">2023 Global Education Monitoring Report</a>, "Technology in education: a tool on whose terms?", concludes that there is little robust, impartial evidence on the added value of digital technology in education; that much of the evidence comes from those seeking to sell it; that products change, on average, every 36 months, often before they can be evaluated; and that, in a survey of teachers and administrators in 17 US states, only 11% asked for peer-reviewed evidence before adopting a tool. Its director also warned that the voices of business tend to be louder than those of teachers and students in this debate. The report recommends that technology be introduced on the basis of evidence that it is appropriate, equitable, scalable and sustainable, and that it <strong>never replace in-person, teacher-led instruction</strong>.</p>
<p>On time savings, a Gallup and Walton Family Foundation survey in the US (June 2025, with more than 2,000 teachers) found that those who use AI at least weekly report saving about 5.9 hours a week; but only 32% use it weekly, and in schools with an AI policy the reported benefit was 26% larger. These are US, self-reported data, but they point to something useful: <strong>technology pays off more when there are clear rules of use</strong>, not when it is installed without judgment.</p>

<h2>What the Colombian framework says</h2>
<p>Article 27 of the Constitution guarantees "the freedoms of teaching, learning, research and academic freedom", and Article 68 requires that teaching be in the hands of people of recognized ethical and pedagogical suitability. Law 115 of 1994 (Article 77) recognizes, within the limits of the law and the Institutional Educational Project (PEI), the autonomy of institutions to, among other things, adopt teaching methods. In practical terms: <strong>the decision about how to teach is professional and institutional, not a vendor's</strong>. A platform can be a good tool, but it is not the PEI and does not replace the teacher's suitability. That autonomy cuts both ways: it demands judgment, and judgment is lost if it is not exercised.</p>
{{img:linea}}

<h2>How autonomy is lost: four signs</h2>
<ol>
<li><strong>The teacher no longer knows why.</strong> If you cannot explain why the platform recommends an activity, you are obeying, not deciding.</li>
<li><strong>Grades come out of a black box.</strong> An automatic grade without review can replicate biases or misread a valid answer; and if the teacher does not review it, nobody defends it before the student.</li>
<li><strong>The prefabricated resource defines the curriculum.</strong> When planning means "finishing the platform's units", the PEI and the group's context fall into the background.</li>
<li><strong>Administrative load grows.</strong> Each platform demands users, data and reports, and the time saved on one task is spent administering it (I will talk about that "technology debt" in an upcoming article).</li>
</ol>
<p>It is fair to say: <strong>not every use is a loss of autonomy</strong>. Delegating a draft of a guide, the sorting of common errors or a first version of an exam can free up time for what only the teacher does: observing the group, talking with a student, deciding what to reinforce tomorrow.</p>

<h2>Decision matrix: what is delegated and what is not</h2>
<p>This is the practical resource. Use it with your department or academic council:</p>
<table>
<thead><tr><th>Pedagogical decision</th><th>Acceptable assistance</th><th>Red line (the teacher decides)</th></tr></thead>
<tbody>
<tr><td><strong>What to teach (objectives and sequence)</strong></td><td>Suggest topics and resources aligned with standards.</td><td>Choose the order, the depth and what is left out according to the group and the PEI.</td></tr>
<tr><td><strong>How to teach</strong></td><td>Offer activities and examples.</td><td>Choose the method and adapt it; be able to change it on the fly.</td></tr>
<tr><td><strong>How to assess</strong></td><td>Generate versions of exercises or questions and mark what is objective.</td><td>Define criteria, review grades and decide the final grade.</td></tr>
<tr><td><strong>Feedback</strong></td><td>Propose comments the teacher edits.</td><td>The message the student receives, with its context.</td></tr>
<tr><td><strong>Attention to diversity and inclusion</strong></td><td>Propose reasonable accommodations as a draft.</td><td>Validate the accommodations with the student, the family and the team.</td></tr>
<tr><td><strong>Decisions about people (groups, promotion, sanctions)</strong></td><td>Show supporting data.</td><td>Decide; never automatically.</td></tr>
<tr><td><strong>Use of student data</strong></td><td>Use minimal, anonymized data.</td><td>Authorize which data leave the school (see <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">the article on student data</a>).</td></tr>
</tbody>
</table>
<p>And three control questions before adopting a platform: <strong>1) Can I see and change what it recommends or grades? 2) Is there independent evidence that it improves learning (not just the provider's)? 3) What happens to my planning and my data if I stop using it?</strong></p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, the discussion is known as the risk of "deprofessionalizing" teaching: turning the teacher into an operator of a system. In Colombia and Latin America, the risk mixes with scarcity of time and resources: a platform that offers ready-made guides is very attractive to a teacher with 30 class hours. According to the OECD (TALIS 2024), about 53% of Colombian teachers used AI in the past year, more than the OECD average (36%), and 54% feel society values their profession; that massive use without institutional rules is exactly what needs ordering. For <strong>teachers</strong>, the goal is to use technology without losing judgment; for <strong>school leaders</strong>, to define a policy and demand evidence from providers; for <strong>families</strong>, to ask whether the teacher still decides how their children are taught and assessed.</p>

<h2>Tools designed so the teacher decides</h2>
<p>The tools I build start from that line. In the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>, the teacher writes the context and the specific topic, reviews the exam and its solutions and decides whether to use it; in <a href="/herramientas/piar/">PIAR con IA</a>, the assistant drafts field by field and the document warns that it must be reviewed and validated by the team of experts; and the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a> brings recipes by subject so you adapt your planning, not replace it. There is a <a href="/examenes/demo/">free demo of the generator</a>.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">does AI expand thinking or replace it?</a>, <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades measure</a> and <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Does using a platform mean losing autonomy?</h3>
<p>Not necessarily. Autonomy is lost when the teacher cannot see, question or change what the platform decides. It is kept when it is used as support and the pedagogical decisions stay with the teacher.</p>
<h3>Can a school impose a platform on its teachers?</h3>
<p>The school has institutional autonomy to adopt methods within the PEI, and the teacher has academic freedom. The healthy way is to decide with the school community, with evidence and with clear rules, not by vendor imposition.</p>
<h3>What evidence should I ask an edtech provider for?</h3>
<p>Independent and, if possible, peer-reviewed evaluations, in contexts similar to yours, with learning outcomes (not just usage or satisfaction). UNESCO warns that much of the available evidence comes from those who sell.</p>
<h3>Can AI grade for me?</h3>
<p>It can help with what is objective, but assessment decisions (criteria, review and final grade) must remain in the teacher's hands, who answers to the student.</p>
<h3>How do I propose a usage policy at my school?</h3>
<p>Bring the decision matrix to your academic council and propose categories of permitted, conditional and unauthorized use, with owners and periodic review.</p>

<p class="notice"><strong>Review your decisions this week.</strong> Apply the matrix to the platforms you use and note which pedagogical decisions you have delegated without realizing. Take back those that should be yours, and for the rest use tools that let you review and change: try the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> or the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a>.</p>

<h2>Food for thought</h2>
<p>If a platform plans, teaches, assesses and recommends, what is left of the craft of teaching? <strong>Is pedagogical autonomy a privilege teachers must defend, or a burden many would be happy to shed, and who should decide how much autonomy a teacher really needs: the law, the school or the practice itself?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:linea}}' => $img('autonomia-docente-plataformas-linea', 633, 'Comparison between technological assistance, which proposes resources the teacher reviews, saves time and is transparent, and replacement, which imposes the path or grade, is opaque and leaves the teacher just executing.', 'Assisting is not replacing.'),
]);

return [
    'docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan' => [
        'slug' => 'are-teachers-losing-pedagogical-autonomy-to-platforms',
        'title' => 'Are Teachers Losing Pedagogical Autonomy to Platforms That Plan, Assess and Recommend for Them?',
        'excerpt' => 'Technological assistance versus replacing professional judgment: what UNESCO evidence and the Colombian framework say, and a matrix of decisions that must remain the teacher\'s.',
        'seo_title' => 'Teacher Autonomy vs. Educational Platforms and AI',
        'seo_description' => 'UNESCO evidence, the Colombian framework and a decision matrix so teachers keep their pedagogical autonomy against platforms and AI.',
        'focus_keyword' => 'teacher autonomy platforms',
        'cover' => '/assets/img/articulos/autonomia-docente-plataformas/autonomia-docente-plataformas-portada-en',
        'cover_alt' => 'Cover "Are teachers losing autonomy to platforms that decide for them?" with a list: the platform suggests and the teacher chooses and adapts, ticked; grading without review and an algorithm setting the curriculum, crossed out.',
        'content_html' => $html,
    ],
];
