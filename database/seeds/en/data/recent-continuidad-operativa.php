<?php

declare(strict_types=1);

// English version of «Plan de continuidad operativa del colegio: qué hacer cuando la tecnología falla,…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/continuidad-operativa/' . $name . '-en';
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
<p>It is the last grading day of the term. At 10 in the morning the school platform stops responding. The vendor says it is "working on it". Teachers have their grades in notebooks and, at best, in a spreadsheet from two weeks ago. Families expect the report cards the next day. Nobody knows how long it will last, who decides what to do or what can be done meanwhile. <strong>Technology will fail at some point; what can be decided in advance is how much it costs when it does.</strong></p>
<p>This article proposes an <strong>operational continuity plan</strong> for a school: not a hundred-page document, but a simple analysis of which processes cannot stop, how much time and how much data can be lost, and what is done while the system is down. It includes an <a href="/descargas/continuidad-operativa/analisis-impacto-continuidad-operativa.xlsx">Excel workbook</a> (in Spanish) with an impact analysis of eight processes, a priority index and a scenarios sheet, verified in Microsoft Excel 16 and against an independent calculation. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> This is a basic framework inspired by business continuity management practices (for example, the ISO 22301 standard and guides such as NIST SP 800-34), simplified for a school; it is not a certified implementation or security advice. The example's processes, times and weights are fictional and editable. Colombia's Law 1581 of 2012 includes among the principles of personal data processing that of security (technical, human and administrative measures); check with your institution what its data protection policy requires.</p>

<h2>The vocabulary of continuity</h2>
{{img:terminos}}
<ul>
<li><strong>Business impact analysis (BIA):</strong> identifying critical processes and what happens if they are interrupted.</li>
<li><strong>RTO (recovery time objective):</strong> the maximum time a process can be down before the damage is unacceptable. It is what the institution <em>can tolerate</em>.</li>
<li><strong>RPO (recovery point objective):</strong> the maximum amount of data that can be lost, measured in time: if the last backup is 24 hours old, up to a day of work is lost.</li>
<li><strong>Manual alternative:</strong> how to keep operating without the system (printed lists, contingency sheets, phone communication).</li>
</ul>
<p>The difference between what is <em>tolerated</em> (target RTO and RPO) and what <em>really happens</em> (actual recovery time and the age of the last backup) is the <strong>gap</strong>, and closing it is the plan's work.</p>

<h2>The Excel workbook</h2>
<ul>
<li><strong>Procesos:</strong> eight school processes (grades platform, institutional email, payments and enrollment, virtual classroom, communication with families, network and Wi-Fi, attendance records and online assessments), each with three impacts from 1 to 5 (academic, on families, legal or financial), the target RTO and RPO in hours, the actual recovery time, the age of the last backup and whether there is a manual alternative.</li>
<li>It calculates <strong>criticality</strong> (weighted average of the three impacts: 40% academic, 30% families, 30% legal or financial; editable), time and data <strong>gaps</strong> and a <strong>priority index</strong> with its rank.</li>
<li><strong>Escenarios:</strong> five scenarios (internet outage, grades platform failure, ransomware, prolonged power loss and absence of the only technical person), with affected processes, first action, owner and the alternative meanwhile.</li>
<li><strong>Resumen:</strong> the key counts.</li>
</ul>
<pre><code>' Criticality of a process (weights in D2, E2 and F2)
=ROUND(D5*$D$2+E5*$E$2+F5*$F$2,2)                              ' English
=REDONDEAR(D5*$D$2+E5*$E$2+F5*$F$2;2)                         ' Spanish

' Time gap: how much longer it takes than tolerable (never negative)
=MAX(0,I5-G5)

' Data gap: backup older than tolerable
=IF(OR(H5="",J5=""),0,MAX(0,J5-H5))

' Priority index: criticality weighs more if there are gaps or no manual alternative
=ROUND(L5*(1+0.5*(M5>0)+0.5*(N5>0)+0.5*(K5="No")),2)

' Rank (1 = most urgent)
=RANK(O5,$O$5:$O$25,0)</code></pre>
<p>The priority index is the author's own criterion, not a standard: the idea is that a <em>critical</em> process with gaps and no alternative should go first, and one with low criticality and a reasonable alternative can wait. Adjust the weights to your reality.</p>

<h2>What the example shows (fictional data)</h2>
<ul>
<li><strong>6 of 8 processes with a time gap:</strong> they would take longer to recover than the institution tolerates. The largest, <strong>24 hours</strong>, is payments and enrollment (it would take 48 hours against a tolerance of 24), followed by institutional email (20 hours more than tolerable: 24 actual versus 4).</li>
<li><strong>4 of 8 with a data gap:</strong> the last backup is older than tolerable. The grades platform tolerates losing 4 hours of data and its last backup is 24 hours old, a 20-hour gap; online assessments have a 23-hour gap.</li>
<li><strong>3 of 8 with no manual alternative:</strong> the grades platform, payments and enrollment and online assessments. And those same three processes have <strong>all three weaknesses at once</strong> (time gap, data gap and no alternative).</li>
<li><strong>Priority:</strong> 1st the grades platform (criticality 4.7; index 11.75), 2nd payments and enrollment (4.2; 10.5) and 3rd online assessments (3.8; 9.5). Processes with a manual alternative, even with gaps, rank lower.</li>
</ul>
<p>The practical conclusion: with limited time and budget, <strong>start with three things</strong>: back up the grades platform more often (a 20-hour data gap is the most serious), prepare a contingency sheet for payments and assessments, and agree with the vendor on a realistic recovery time (in writing). The email and family communication gaps are important, but have alternatives (phone, messaging).</p>

<h2>What to do while the system is down</h2>
<p>The workbook's scenarios sheet forces you to think in advance about something that is badly improvised in a crisis: <strong>who does what</strong>. Examples from the workbook: with an internet outage at the campus, the IT person calls the provider and activates backup mobile data while teachers use printed material and offline activities; with a grades platform failure, coordination contacts the vendor, exports the latest copy and uses a contingency sheet with a protected copy; with a ransomware attack, equipment is isolated and the first-60-minutes protocol is followed (see <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">what to do in the first 60 minutes of ransomware</a>); with the absence of the only technical person, the substitute is activated with emergency credentials.</p>
{{img:pasos}}

<h2>Five steps to build the plan</h2>
<ol>
<li><strong>Identify the processes that cannot stop,</strong> with the people who know them (not only with IT). Ask: "if this fails on a Monday morning, what happens and how long can we hold?".</li>
<li><strong>Measure impact and tolerance</strong> of each (target RTO and RPO).</li>
<li><strong>Compare with reality:</strong> how long would it really take to recover? when is the last backup and has restoring it been tested? (see <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">the cloud is not a backup</a>).</li>
<li><strong>Close the gaps in order of priority:</strong> more frequent backups, tested restores, prepared manual alternatives, contracts with response times, a technical substitute.</li>
<li><strong>Test the plan with a short drill</strong> and adjust. A plan that has never been tested is a hypothesis.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, schools depend more and more on platforms for grades, enrollment, communication and classes, often hosted outside the institution and with contracts that do not specify recovery times. In the region the picture is similar, with very uneven technical capacity; worldwide, continuity management is a mature discipline with standards (such as ISO 22301) and public guides, and ransomware incidents against schools have shown the cost of not being prepared. For <strong>principals</strong>, the plan is a risk-management decision, not a technical topic; for <strong>IT staff</strong>, the analysis provides arguments and priorities to ask for resources; for <strong>teachers</strong>, knowing what to do when a tool fails avoids improvising in front of students; and for <strong>families</strong>, continuity is part of trust. See also <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">a help desk for the school</a>, <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">the technology inventory</a> and <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">protecting the school domain</a>.</p>

<h2>Templates and tools</h2>
<p>If you prefer to start from ready-made Excel templates, with support, look at these options. For the teaching side, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> are the author's own tools for teachers.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">what to monitor in a web application</a>, <a href="/implementar-plataforma-colegio-30-dias-plan-piloto-decision-excel/">implementing a platform in 30 days</a> and <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is an operational continuity plan?</h3>
<p>A set of decisions made in advance about which processes cannot stop, how much downtime is tolerated and what is done while the system is unavailable.</p>
<h3>What are RTO and RPO?</h3>
<p>RTO is the maximum time a process can be down; RPO, the maximum amount of data that can be lost, measured in time since the last backup.</p>
<h3>Is a cloud backup enough?</h3>
<p>Not necessarily: what matters is how often it is made, whether restoring it has been tested and how long recovery takes. See "the cloud is not a backup".</p>
<h3>Where do I start?</h3>
<p>With the most critical process with the most gaps and no manual alternative: in the example, the grades platform.</p>
<h3>How often should I test the plan?</h3>
<p>At least once a year with a short drill, and after major changes (a new platform, a change of vendor).</p>

<p class="notice"><strong>Do your analysis this week.</strong> Download the <a href="/descargas/continuidad-operativa/analisis-impacto-continuidad-operativa.xlsx">impact analysis</a> (in Spanish), replace the processes with yours, fill in the times with those who know them and see which rank first in priority.</p>

<h2>Food for thought</h2>
<p>A continuity plan is, at bottom, an honest conversation about what we do not want to fail and what would happen today if it did. <strong>How many of this workbook's answers does whoever leads your school know today, and how many are they assuming? And if tomorrow at 10 a.m. your main platform stopped working, what would teachers know how to do, without asking?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:terminos}}' => $img('continuidad-operativa-terminos', 499, 'Table with four continuity management terms, their meaning and the question each answers: BIA, RTO, RPO and manual alternative.', 'The vocabulary of continuity.'),
    '{{img:pasos}}' => $img('continuidad-operativa-pasos', 467, 'Five steps to build a continuity plan: identify, measure, compare, close gaps and test.', 'Five steps, from critical to tested.'),
]);

return [
    'plan-continuidad-operativa-colegio-analisis-impacto-rto-rpo-excel' => [
        'slug' => 'school-operational-continuity-plan-impact-analysis-rto-rpo-excel',
        'title' => 'A School Operational Continuity Plan: What to Do When Technology Fails, with an Impact Analysis (RTO and RPO) in Excel',
        'excerpt' => 'A continuity plan for the school: identify critical processes, measure how much downtime and data loss is tolerated (RTO and RPO), compare with reality and define what to do meanwhile, with an Excel workbook and five scenarios.',
        'seo_title' => 'School Continuity Plan (RTO and RPO)',
        'seo_description' => 'How to build a continuity plan for a school: critical processes, RTO and RPO, gaps, manual alternatives and scenarios, with a verified Excel workbook.',
        'focus_keyword' => 'school continuity plan',
        'cover' => '/assets/img/articulos/continuidad-operativa/continuidad-operativa-portada-en',
        'cover_alt' => 'Cover "A school operational continuity plan: what to do when technology fails" with a card: 3 of 8 processes with three weaknesses, slow recovery, old backup and no alternative.',
        'content_html' => $html,
    ],
];
