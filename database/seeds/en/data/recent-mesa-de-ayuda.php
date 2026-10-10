<?php

declare(strict_types=1);

// English version of «Una mesa de ayuda para el colegio sin software costoso: prioridades, plazos y ti…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/mesa-de-ayuda/' . $name . '-en';
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
<p>The projector in room 204 will not turn on. The teacher messages the coordinator on WhatsApp, who replies to tell the IT person, who is at another campus. Two hours later, class has started, nobody knows who is handling it and the same problem repeats in another room. In many schools technology support works like this: <strong>whoever is nearest fixes what they can, without a record, without priorities and without knowing what keeps repeating</strong>.</p>
<p>A help desk does not need expensive software to work. This article proposes a minimal model: a single entry channel, tickets with category, impact and urgency, a calculated priority, deadlines by priority and an indicators dashboard. It includes an <a href="/descargas/mesa-de-ayuda/mesa-de-ayuda-colegio.xlsx">Excel workbook</a> (in Spanish) with 20 fictional tickets, with results verified in Microsoft Excel 16 and against an independent Python calculation. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> This is a starting model inspired by IT service incident management practices (such as ITIL), simplified for a school; it is not a certified implementation or a vendor's advice. The example's data, priorities and deadlines are fictional and editable: adjust them to your institution and to the support team's real resources.</p>

<h2>One channel, one record</h2>
<p>The first decision is the most important: <strong>all requests enter through a single channel</strong> (a form, a support email or a chat with a backup form) and are recorded as a ticket. Not because bureaucracy is good, but because without a record there is no priority, deadline, history or learning. A WhatsApp message is a conversation; a ticket is a commitment with a number, an owner and a deadline. If a form feels like too much, the minimum is six fields: who, where, what is happening, since when, how many people it affects and how urgent it is.</p>

<h2>Priority = impact × urgency</h2>
<p>Not everything is urgent, even if it seems so to whoever asks. The most widely used practice to decide is to cross two questions: <strong>impact</strong> (how many people or services does it affect?) and <strong>urgency</strong> (how fast must it be solved?). The <em>Reglas</em> sheet has a 3-by-3 matrix that produces four priorities:</p>
{{img:prioridades}}
<ul>
<li><strong>High impact</strong> (the whole institution or a critical service) with high urgency is <strong>P1</strong>; with medium urgency, P2; with low urgency, P3.</li>
<li><strong>Medium impact</strong> (a group, an area or a room): high urgency, P2; medium, P3; low, P4.</li>
<li><strong>Low impact</strong> (one person): high urgency, P3; medium or low, P4.</li>
</ul>
<p>Each priority has an example resolution deadline: 4 hours (P1), 8 (P2), 24 (P3) and 72 (P4), in calendar hours. In real use, you may prefer business hours; the model adapts.</p>
<pre><code>' Priority: crosses impact (row) and urgency (column) in the matrix
=INDEX(Reglas!$B$5:$D$7, MATCH(F4, Reglas!$A$5:$A$7, 0), MATCH(G4, Reglas!$B$4:$D$4, 0))             ' English
=INDICE(Reglas!$B$5:$D$7; COINCIDIR(F4; Reglas!$A$5:$A$7; 0); COINCIDIR(G4; Reglas!$B$4:$D$4; 0))   ' Spanish

' Deadline = creation + priority's hours / 24
=B4 + VLOOKUP(H4, Reglas!$A$11:$B$14, 2, FALSE)/24

' Deadline status (closed or open)
=IF(K4="", IF(Reglas!$B$16>J4, "Abierto vencido", "Abierto en plazo"), IF(K4<=J4, "Cumplido", "Incumplido"))</code></pre>

<h2>The life of a ticket</h2>
{{img:ciclo}}
<ol>
<li><strong>Log</strong> (who, what, when, through a single channel).</li>
<li><strong>Classify:</strong> category (network, projector, account, platform, email, printing, software), impact and urgency. Classification is done by whoever handles it, not whoever asks: the requester says what is happening, the desk decides the priority.</li>
<li><strong>Resolve</strong> within the deadline. If not possible, communicate and reschedule, do not disappear.</li>
<li><strong>Confirm</strong> with the person that it is resolved, before closing.</li>
<li><strong>Learn:</strong> if the problem repeats, document the solution (see the upcoming institutional knowledge base article) or fix the cause.</li>
</ol>

<h2>What the example showed (fictional data)</h2>
<p>The workbook has 20 tickets from one week (January 11 to 18, 2027), 17 closed and 3 open. The calculated indicators:</p>
<ul>
<li><strong>Overall compliance:</strong> 14 of the 17 closed arrived within the deadline (82.4%). It looks like a good result.</li>
<li><strong>By priority:</strong> the three P1s (the critical ones) closed in 4.4 hours on average, but only 1 of 3 met its 4-hour deadline (33%). In P2, 3 of 4 met it; in P3, 4 of 4; and in P4, 6 of 6 (averaging 29.4 hours against a 72-hour deadline).</li>
<li><strong>Open and overdue:</strong> 2 of the 3 open tickets had already passed their deadline at the cutoff.</li>
<li><strong>Resolution time:</strong> a 13.7-hour average, but a median of about 4.7 hours (4 hours 45 minutes): a few slow tickets pull the average up.</li>
<li><strong>Categories:</strong> projector or room (20%) and account or access (20%) lead; network, platform, email, printing and software make up the rest.</li>
</ul>
<p>The lesson is the usual one with averages: <strong>the overall 82% hides that the most critical fails most</strong>. A report that only said "82% compliance" would give the impression that all is well, when precisely the incidents affecting the whole campus were solved late in two of three cases. That is why the dashboard breaks down by priority and reports the median as well as the average. (See also <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">what to monitor in a web application</a>, where the same principle applies to alerts.)</p>

<h2>Template replies: three messages that save time</h2>
<pre><code>1. Acknowledgement
"We received your request (ticket #{n}). We classified it as {priority} and will handle it before {deadline}.
If anything changes, reply to this message with the ticket number."

2. Missing information
"To handle ticket #{n} we need to know: in which room or campus does it happen? since when?
and what error message appears? With that we will prioritize it."

3. Closing and confirmation
"We resolved ticket #{n}: {what was done}. Please confirm whether it works now.
If you do not reply within 48 hours we will consider it closed."</code></pre>

<h2>From incident to problem: when something repeats</h2>
<p>Resolving tickets one by one puts out fires; <strong>looking at categories that repeat</strong> lets you eliminate the cause. If the projector fails in three rooms, the cause may be the cable or a model change, not the room. The <em>Indicadores</em> sheet counts tickets by category to see where the pattern is; when a category dominates for several weeks, it is time to open a "problem" (a root-cause investigation) or a preventive maintenance investment. This is also an input for discussing technology debt with leadership (see <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">more platforms is not better</a>) and for deciding what to buy, with a total-cost view.</p>

<h2>Possible tools (without buying anything)</h2>
<ul>
<li><strong>Excel or a shared spreadsheet,</strong> as in the workbook: enough for a team of one or two and a few dozen tickets a week.</li>
<li><strong>Form + list:</strong> a form feeding a shared list and a flow that notifies (see <a href="/flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion/">digital approval flow</a> for the same piece design).</li>
<li><strong>Open-source help desk software,</strong> such as GLPI or osTicket, which can be installed on your own server; they require someone to maintain them and to review their license, security and backups.</li>
</ul>
<p>Start with the simplest thing you can sustain: an abandoned help desk is worse than none, because it promises something it does not deliver.</p>

<h2>Colombia, Latin America and the world</h2>
<p>In many Colombian schools, public and private, technology support is a single person, sometimes a teacher with IT hours, sometimes an outside contractor, and demand grows with platforms, rooms with projectors and digital assessments. In the region the picture repeats, with large gaps between institutions; worldwide, IT service management practices (ITIL is the best known) are a common language that can be adapted to small scales. For <strong>principals</strong>, a help desk turns the complaint ("nothing ever works") into data that allows budget decisions; for <strong>teachers</strong>, knowing whom to ask and when they will get an answer reduces frustration; for <strong>support staff</strong>, explicit priority protects from being the firefighter of whoever insists most; and for <strong>families</strong> and students, a stable service is part of school continuity. A note of care: tickets may contain personal data (names, accounts); handle them under your institution's data-protection rules and limit who sees them.</p>

<h2>Tools and templates</h2>
<p>If you prefer to start from ready-made Excel templates, with support, or need a guide to organize your forms, look at these options. For the teaching side, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> are the author's own tools for teachers.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">protecting the school domain</a>, <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">what to do in the first 60 minutes of ransomware</a> and <a href="/extensiones-del-navegador-riesgos-permisos-inventario-politica/">browser extensions</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is a help desk?</h3>
<p>A single point where support requests are received, classified, resolved and recorded. It can be a form and a spreadsheet, not necessarily specialized software.</p>
<h3>How is a ticket's priority defined?</h3>
<p>By crossing impact (how many people or services it affects) with urgency (how fast it must be solved). The Reglas sheet has an example matrix.</p>
<h3>Which indicators should I measure?</h3>
<p>Deadline compliance by priority (not just overall), resolution time (average and median), open overdue tickets and the categories that repeat most.</p>
<h3>Do I need special software?</h3>
<p>Not to start. A form and a spreadsheet are enough for a small team. If volume grows, there are open-source and commercial options.</p>
<h3>What do I do with requests that arrive by WhatsApp or in the hallway?</h3>
<p>Kindly ask that they be logged through the single channel, or log them yourself with a confirmation message. Without a record, there is no priority or history.</p>

<p class="notice"><strong>Start this week.</strong> Download the <a href="/descargas/mesa-de-ayuda/mesa-de-ayuda-colegio.xlsx">Excel help desk</a> (in Spanish), adjust the priority matrix and deadlines, log your week's tickets and see the compliance of your P1 cases.</p>

<h2>Food for thought</h2>
<p>When support is not measured, it depends on one person's goodwill and the volume of complaints. When it is measured, it becomes visible who suffers most, what breaks most and how much it costs not to invest. <strong>Who decides, at your school, which support request is more urgent: whoever shouts loudest or the impact on the community? And if data show that the critical is solved late, are we willing to invest time and resources, or only to share the blame?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:prioridades}}' => $img('mesa-de-ayuda-prioridades', 499, 'Table with four ticket priorities and their deadline: P1 at 4 hours, P2 at 8, P3 at 24 and P4 at 72.', 'Four priorities, four deadlines.'),
    '{{img:ciclo}}' => $img('mesa-de-ayuda-ciclo', 467, 'Five steps in the life of a ticket: log, classify, resolve, confirm and learn.', 'From request to learning.'),
]);

return [
    'mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel' => [
        'slug' => 'school-help-desk-without-expensive-software-priorities-deadlines-tickets-excel',
        'title' => 'A School Help Desk Without Expensive Software: Priorities, Deadlines and Tickets in Excel',
        'excerpt' => 'How to set up a minimal help desk for the school\'s technology support: a single channel, tickets, priority by impact and urgency, deadlines and a compliance dashboard, with a verified Excel workbook.',
        'seo_title' => 'School Help Desk: Tickets and Priorities',
        'seo_description' => 'Set up a help desk for school tech support without expensive software: tickets, priority by impact and urgency, deadlines and indicators in Excel.',
        'focus_keyword' => 'school help desk',
        'cover' => '/assets/img/articulos/mesa-de-ayuda/mesa-de-ayuda-portada-en',
        'cover_alt' => 'Cover "A help desk for the school without expensive software: priorities and deadlines" with a card: 82% of tickets on time overall, but only 1 of 3 of the most critical.',
        'content_html' => $html,
    ],
];
