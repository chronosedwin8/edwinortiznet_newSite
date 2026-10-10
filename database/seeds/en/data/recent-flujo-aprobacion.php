<?php

declare(strict_types=1);

// English version of «Flujo de aprobación digital en el colegio: formulario, reglas, plazos y medición…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/flujo-aprobacion/' . $name . '-en';
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
<p>"I sent you the email last week." "It never reached me." "Ask the coordinator, she said yes." In many schools, requests (a purchase, a permission, the use of a room) travel through emails, WhatsApp messages and hallway conversations. Nobody knows what state each one is in, who was supposed to decide or how long it has been waiting. <strong>What is not recorded cannot be measured, and what is not measured cannot be improved.</strong></p>
<p>This article describes how to move from the email chain to a <strong>digital approval flow</strong>: a form that captures the request, a list that stores its status, a flow that routes, notifies and escalates, and a timing measurement. It includes a <a href="/descargas/flujo-aprobacion/disenador-flujo-aprobacion.xlsx">rules designer in Excel</a> (in Spanish: rules by amount, deadlines, escalation and delegates, with a simulator) and a <a href="/descargas/flujo-aprobacion/analizador_aprobaciones.py">Python analyzer</a> with a <a href="/descargas/flujo-aprobacion/solicitudes-ejemplo.csv">sample CSV</a>. The workbook was verified in Microsoft Excel 16 and the script against an independent calculation; the data are fictional. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> This is a design guide, not a step-by-step tutorial for a product or legal or accounting advice. The amounts and approval levels in the example are fictional: the real purchasing and contracting rules are set by your institution's contracting manual and the regulations that apply to it. Product names (Microsoft Forms, Lists, Power Automate) are examples; Google Workspace and other platforms have equivalents. Licenses, connectors and limits change: verify them in your plan's documentation.</p>

<h2>Why email fails as an approval system</h2>
<ul>
<li><strong>No visible status:</strong> nobody knows whether the request is pending, approved or lost.</li>
<li><strong>No deadline or escalation:</strong> if the approver does not respond, nothing happens.</li>
<li><strong>No reliable record:</strong> a hallway "yes" leaves no trace; an audit or a later dispute becomes a memory problem.</li>
<li><strong>Dependence on people:</strong> if the approver is away, the request just waits.</li>
</ul>
<p>A well-designed flow does not make people decide better, but it does make <strong>decisions recorded, time-bound and independent of anyone's memory</strong>.</p>

<h2>The four pieces</h2>
{{img:piezas}}
<ul>
<li><strong>Form:</strong> captures the request with the minimum fields to decide and route. Every field must serve a purpose; asking "just in case" for third-party data goes against data minimization (see Colombia's Law 1581 of 2012 on personal data protection).</li>
<li><strong>List:</strong> a shared table that stores each request, its status, who decided and when. It is the source of truth.</li>
<li><strong>Flow:</strong> the automation that, when a request arrives, routes it to the right approver, notifies them, waits for the answer, escalates if the deadline passes and notifies the result.</li>
<li><strong>Measurement:</strong> a periodic review of times by type and by approver.</li>
</ul>
<p>In the Microsoft 365 ecosystem, a common path is Microsoft Forms or a Microsoft Lists list to capture, Power Automate for the flow and its approvals action, and Excel to measure. In Google Workspace, the equivalent is usually built with Google Forms, Sheets and Apps Script, or with a tool such as AppSheet. <strong>Choosing one over the other depends on what your institution already uses</strong> (see <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">more platforms is not better</a>), not on which is more modern.</p>

<h2>The rules: the part that belongs to the institution</h2>
<p>Automation is easy; rules are hard. The <em>disenador-flujo-aprobacion.xlsx</em> workbook has a <em>Reglas</em> (rules) sheet where you define, by request type and amount, who approves, in how long, who it escalates to if overdue and who the delegate is if the approver is absent. A <em>Simulador</em> sheet takes a type and an amount and answers who must approve. In the fictional example, a $400,000 purchase is approved by Coordination (24-hour deadline); $1,200,000, by Coordination and the Principal (48 hours); and $6,000,000, by the Governing Board (120 hours). I tested the exact boundaries: $500,000 stays at the first level, $500,001 moves to the second, and $5,000,000 stays at the second while $5,000,001 moves to the third. The formula that finds the applicable threshold uses <code>MAXIFS</code> and then <code>INDEX</code> and <code>MATCH</code>:</p>
<pre><code>' Applicable threshold: the largest "from amount" not exceeding the request amount
=MAXIFS(Reglas!C5:C24, Reglas!B5:B24, B3, Reglas!C5:C24, "<="&B4)             ' English
=MAX.SI.CONJUNTO(Reglas!C5:C24; Reglas!B5:B24; B3; Reglas!C5:C24; "<="&B4)   ' Spanish

' Rule row and approver
=MATCH(B3&"|"&B6, Reglas!A5:A24, 0)       =INDEX(Reglas!D5:D24, B7)</code></pre>
<p>Rules must come from the manual, not from the tool: if no manual says who approves what, the first deliverable is not a flow but that agreement.</p>

<h2>The flow, in plain language</h2>
<pre><code>1. A new request arrives (form or list).
2. The type and amount are read; the rules say who approves.
3. The request is recorded as "Pending" and the approval is sent (email and Teams).
4. In parallel, a timer equal to the rule's deadline starts.
5. If the approver responds: the decision, who, when and the comment are recorded.
   If the deadline passes: the approver is notified and it escalates to the defined person.
6. The requester is told the result and the status is updated.</code></pre>
<p>In Power Automate, for example, the approvals action supports several types (approve or reject with the first to respond, everyone must approve, or custom responses); exact names may change across versions, and Microsoft's documentation warns that some combinations with many recipients can fail because of data size limits, so test first. A design rule that saves trouble: <strong>the flow must belong to the institution, not to one person's personal account</strong>, with at least two owners; otherwise, the day that person leaves, the flow stops working.</p>
<p>On licensing: according to documentation and industry sources, standard connectors (such as Forms, SharePoint, Outlook, Teams and approvals) are usually included in Microsoft 365 plans that include Power Automate, and a single premium connector can change the flow's license requirements. Do not take it for granted: confirm with your tenant administrator and the current documentation, especially on education plans.</p>

<h2>Measuring: the approvals analyzer</h2>
<p>The <code>analizador_aprobaciones.py</code> script reads the CSV exported from the list (columns <code>id, tipo, solicitante, aprobador, creada, respondida, estado</code>) and calculates, with the Python 3.8+ standard library, the median and 90th percentile of response hours by type and by approver, and the pending requests that have already exceeded their deadline. (Its messages are in Spanish.)</p>
<pre><code>python analizador_aprobaciones.py solicitudes-ejemplo.csv --sla Compra=48 Permiso=24 Espacio=48 --ahora "2027-01-12 07:00"

Solicitudes: 23 | pendientes: 2

Por tipo (horas de respuesta):
  Compra       n=10  mediana=18.0   p90=70.0
  Espacio      n=5   mediana=10.0   p90=20.0
  Permiso      n=6   mediana=3.0    p90=5.0

Por aprobador (posibles cuellos de botella):
  Rectoría       n=5   mediana=52.0   p90=90.0
  Secretaría     n=2   mediana=7.0    p90=8.0
  Coordinación   n=14  mediana=5.0    p90=12.0

Pendientes que ya superaron su plazo:
  S-023 (Compra, Rectoría): 95.0 h de espera; plazo 48 h</code></pre>
<p>With the 23 fictional records, the median for purchases (18 hours) hides two realities: when Coordination decides they are resolved in 4 to 10 hours, and when the Principal decides they take 26 to 90 (median 52 hours). <strong>The average by request type hid the bottleneck; the breakdown by approver shows it.</strong> That conclusion is not an accusation against a person: usually whoever approves the biggest items also has the busiest calendar, and that is fixed with delegation, rules by amount or periodic approval meetings, not with scolding. Times are calendar hours, not business hours: adjust the reading if your deadline is counted in working hours. The medians were checked against an independent calculation.</p>

<h2>Five steps to implement it</h2>
{{img:pasos}}
<ol>
<li><strong>Map the real process:</strong> who asks, who decides, what they decide and how long it takes today.</li>
<li><strong>Define the rules</strong> with the designer (amounts, deadlines, escalation and delegates) and have them approved by whoever should.</li>
<li><strong>Build the minimum:</strong> a form with few fields, a list and a simple flow. Start with a single request type.</li>
<li><strong>Test</strong> one case per level and with the approver absent; check what happens if the flow fails and leave a manual procedure.</li>
<li><strong>Measure monthly</strong> with the analyzer and adjust rules and deadlines.</li>
</ol>
<p>The workbook's <em>Checklist</em> sheet has ten controls before publishing, among them: process owner, delegate per level, deadline and escalation, confirmation to the requester, a record, limited access to attachments, a flow not tied to a personal account and a manual fallback procedure.</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, the public sector has guidelines on paper reduction and digital government (for example, the "zero paper" policy dating from 2012 and digital government policies; verify the current text applicable to your entity), and schools, public and private, process students' and families' personal data, so they must consider Law 1581 of 2012. In the region, digitization of procedures advances unevenly, with institutions approving everything on paper and others already using digital flows; worldwide, automating approvals is common practice in administration, and its most frequent failure is also well known: automating a confusing process makes it confusing faster. For <strong>principals</strong>, the flow requires defining and publishing the rules; for <strong>teachers</strong>, knowing where their request stands reduces uncertainty; for <strong>administrative staff</strong>, who usually bear the forwarding, it is one burden less; and for <strong>families</strong>, if the flow touches their data, it matters that it is handled with care. When processes handle sensitive data, see <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into an AI tool</a> and <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">why integrations fail silently</a>.</p>

<h2>Tools and templates</h2>
<p>If you need ready-made Excel forms or templates, or support for your administrative processes, look at these options. For the teaching side, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> are the author's own tools for teachers.</p>
{{productos:factura-con-envio-por-correo-al-cliente,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">what to monitor in a web application</a>, <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">protecting the school domain</a> and <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">what to do in the first 60 minutes of ransomware</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Do I need to buy a new tool for an approval flow?</h3>
<p>Not necessarily. Many schools already have forms, lists and automation in the suite they use (Microsoft 365 or Google Workspace). Before buying, check what you have and its license limits.</p>
<h3>Which approval type is better: first to respond or everyone?</h3>
<p>It depends on the rule. If one person from a group suffices (for example, either of two coordinators), the first to respond. If policy requires everyone (for example, Coordination and the Principal), all must approve. Define the rule before configuring the tool.</p>
<h3>What if the approver is on vacation?</h3>
<p>That is what the delegate is for: each level must have one defined, and the flow must be able to route to them. Without a delegate, requests pile up.</p>
<h3>How do I know the flow works well?</h3>
<p>By measuring times by type and by approver, and reviewing requests that exceed their deadline. The downloadable analyzer calculates it from a CSV.</p>
<h3>What data should I avoid asking for?</h3>
<p>Whatever does not serve to decide or route, especially third parties' personal data (such as students') and sensitive data. Ask for the minimum and limit access to attachments.</p>

<p class="notice"><strong>Start with a single request type.</strong> Download the <a href="/descargas/flujo-aprobacion/disenador-flujo-aprobacion.xlsx">rules designer</a> (in Spanish), write the rules for the type that gets stuck most at your school and test them in the simulator before building anything. If you already have data, run the <a href="/descargas/flujo-aprobacion/analizador_aprobaciones.py">analyzer</a>.</p>

<h2>Food for thought</h2>
<p>A digital flow makes visible what was invisible: who is slow, who decides, where everything gets stuck. <strong>How do we keep that visibility from being used to watch people instead of improving the process? And before automating an approval, have we asked whether the approval itself is needed, or whether the control could be lighter without losing accountability?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:piezas}}' => $img('flujo-aprobacion-piezas', 499, 'Table with the four pieces of an approval flow, their function and an example: form, list, flow and measurement.', 'What each piece of an approval flow does.'),
    '{{img:pasos}}' => $img('flujo-aprobacion-pasos', 467, 'Five steps before automating: map, define rules, build, test and measure.', 'Five steps before automating.'),
]);

return [
    'flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion' => [
        'slug' => 'digital-approval-flow-school-form-list-rules-deadlines-measurement',
        'title' => 'Digital Approval Flow for a School: Form, Rules, Deadlines and Measurement, with a Designer and an Analyzer',
        'excerpt' => 'How to move from the email chain to a digital approval flow: form, list, rules by amount, deadlines and escalation, and time measurement, with an Excel designer and a Python analyzer.',
        'seo_title' => 'Digital Approval Flow for Schools: Rules',
        'seo_description' => 'Design a digital approval flow with form, list and automation: rules by amount, deadlines, escalation and measurement, with a designer and analyzer.',
        'focus_keyword' => 'digital approval flow',
        'cover' => '/assets/img/articulos/flujo-aprobacion/flujo-aprobacion-portada-en',
        'cover_alt' => 'Cover "Digital approval flow: from the lost email to a process that can be measured" with a card: 52 hours versus 5 hours median response between two approvers, the bottleneck shows.',
        'content_html' => $html,
    ],
];
