<?php

declare(strict_types=1);

// English version of "Qué monitorear en una aplicación web para enterarte antes que tus usuarios: seña…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/monitoreo-aplicacion-web/' . $name . '-en';
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
<p>A school's, small business's or startup's web application stops working on a Friday at six in the evening. The enrollment form does not load, payments are not recorded. Nobody finds out until Monday, when a mother calls angrily. <strong>The worst monitoring is the kind that consists of waiting for users to tell you.</strong></p>
<p>This article explains what to monitor in a web application (the essential signals, example thresholds, which alerts are useful and which only make noise), with a <a href="/descargas/monitoreo-web/monitor_basico.py">basic Python monitor</a> that I tested and a <a href="/descargas/monitoreo-web/plan-monitoreo-aplicacion-web.xlsx">downloadable Excel monitoring plan</a> (in Spanish) with an availability calculator. Data verified on October 10, 2026.</p>
<p class="notice"><strong>Summary.</strong> Monitor first what hurts the user: <strong>is it available?, does it respond fast?, does it fail?, is it filling up?</strong> (Google's "four golden signals": latency, traffic, errors and saturation), plus your business signals (are payments and enrollments being completed?). Every alert must have a named owner, a threshold and a first step. A 99.9% availability target allows about 43 minutes of downtime a month: choose the target by the harm a downtime causes, not for prestige.</p>

<h2>The four golden signals (and your business ones)</h2>
{{img:senales}}
<p>Google's "Site Reliability Engineering" book proposes, for monitoring any user-facing system, four signals: <strong>latency</strong> (how long it takes to respond, separating successful from failed responses, because a fast error misleads), <strong>traffic</strong> (how much demand it receives), <strong>errors</strong> (what share of requests fail, either explicitly or silently) and <strong>saturation</strong> (how full the most constrained resource is). That covers the technical side. But an application can be "up" and useless: a form that loads but does not save, a payment that is charged and not recorded. That is why you must add <strong>business signals</strong>: payments initiated versus confirmed, enrollments per hour, emails sent. Those truly tell whether the system does its job (see <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">integrations that fail silently</a>).</p>

<h2>The monitoring plan: ten signals to start</h2>
<table>
<thead><tr><th>Signal</th><th>What to measure (example)</th><th>Example threshold</th><th>Severity</th></tr></thead>
<tbody>
<tr><td><strong>Availability</strong></td><td>A check every minute of the home page and the payment flow</td><td>3 consecutive failures</td><td>Critical</td></tr>
<tr><td><strong>Latency</strong></td><td>95th percentile of response time</td><td>Over 2 s for 10 minutes</td><td>High</td></tr>
<tr><td><strong>Errors</strong></td><td>Percentage of 5xx responses</td><td>Over 2% for 5 minutes</td><td>High</td></tr>
<tr><td><strong>Saturation</strong></td><td>Disk, memory, CPU, database connections</td><td>Disk above 85%</td><td>High</td></tr>
<tr><td><strong>Traffic</strong></td><td>Requests per minute</td><td>A 50% drop from normal</td><td>Medium</td></tr>
<tr><td><strong>Scheduled jobs</strong></td><td>Last successful run (backups, emails)</td><td>Did not run in the expected time</td><td>High</td></tr>
<tr><td><strong>Payments and enrollments</strong></td><td>Initiated versus confirmed</td><td>Zero confirmed in 2 business hours</td><td>Critical</td></tr>
<tr><td><strong>Real experience</strong></td><td>Core Web Vitals on real devices</td><td>LCP &gt; 2.5 s; INP &gt; 200 ms; CLS &gt; 0.1</td><td>Medium</td></tr>
<tr><td><strong>Security</strong></td><td>Failed logins, new accounts with privileges</td><td>Over 20 failures a minute</td><td>High</td></tr>
<tr><td><strong>Certificates and domains</strong></td><td>Days until expiry</td><td>Fewer than 21 days</td><td>Medium</td></tr>
</tbody>
</table>
<p>The thresholds in the last column are examples to adjust to your case; the Core Web Vitals ones (LCP, INP and CLS) are the "good" thresholds Google publishes on web.dev. The workbook has this table with columns for who receives the alert, how it is measured and whether it is already implemented: with ten signals and none implemented, the summary says "0 de 10" (0 of 10) and warns that the two critical ones (availability and payments) are not yet covered.</p>

<h2>How much downtime is acceptable? The calculator</h2>
<p>An availability target translates into minutes. The "Calculadora_disponibilidad" sheet computes, with the formula <em>period minutes × (1 − target)</em>, the allowed downtime:</p>
{{img:disponibilidad}}
<p>99% allows about 7.2 hours of downtime a month; 99.9%, about 43 minutes; 99.99%, a little over 4 minutes. The lesson: <strong>each extra "nine" costs much more</strong> (redundancy, processes, on-call staff). For a school's informational page, 99% may be enough; for tuition collection in the last week of the deadline, perhaps not. The target is set by what a downtime costs users.</p>

<h2>A basic monitor in Python (tested)</h2>
<p>To understand how an availability monitor works, I wrote one of about 70 lines (standard library only): it makes N HTTP checks, measures response time and computes availability, median and 95th percentile, and raises an alert after three consecutive failures. I tested it against my own local site, against a port with no service and against a route that returns 404:</p>
<pre><code>$ python monitor_basico.py http://localhost:8090/ 20 0.1
http://localhost:8090/
  comprobaciones: 20 | disponibilidad: 100.0 % | alertas: 0
  latencia mediana: 11 ms | p95: 38 ms

$ python monitor_basico.py http://localhost:59999/ 6 0.1      # puerto donde no hay nada
  ALERTA: 3 fallos consecutivos (URLError) en http://localhost:59999/
  comprobaciones: 6 | disponibilidad: 0.0 % | alertas: 1

$ python monitor_basico.py http://localhost:8090/ruta-inexistente/ 4 0.1   # responde 404
  ALERTA: 3 fallos consecutivos (404) en http://localhost:8090/ruta-inexistente/
  comprobaciones: 4 | disponibilidad: 0.0 % | alertas: 1</code></pre>
<p>Notice two details. First, <strong>the 404 counts as a failure</strong>: a page that "responds" but with an error is not serving. Second, the alert fires on <strong>three consecutive failures</strong>, not the first: a single failure may be a network hiccup, and alerting on everything creates noise people learn to ignore. This is a demonstration, not a production system: a real monitor measures from several locations, keeps history, has reliable notifications and does not run on the same server it watches (if the server goes down, the monitor goes down with it).</p>

<h2>Alerts that help, alerts that get in the way</h2>
<ul>
<li><strong>One alert, one named owner.</strong> "Someone on the team" is nobody.</li>
<li><strong>Each alert says what to do first.</strong> An alert that forces you to investigate from scratch at three in the morning gets ignored.</li>
<li><strong>Alert on symptoms, not causes.</strong> "Payments are not arriving" matters more than "CPU is at 80%".</li>
<li><strong>Severity levels:</strong> critical (15 minutes, a call), high (1 hour, a message), medium (1 day, email) and informational (dashboard). The workbook's "Alertas" sheet includes them with suggested times and channels.</li>
<li><strong>If an alert is ignored three times, fix the cause or delete it.</strong></li>
<li><strong>Test critical alerts</strong> by switching something off on purpose: an alert that was never tested probably does not ring when needed.</li>
</ul>

<h2>What almost everyone forgets</h2>
<ol>
<li><strong>Scheduled jobs.</strong> A backup that stopped running two weeks ago does not warn by itself. The fix is the "heartbeat": the task pings on finishing, and an alert fires if the ping does not arrive on time.</li>
<li><strong>Certificates and domains.</strong> An expired certificate takes a site down overnight; avoid it with a calendar or an expiry monitor (see <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the risk of what nobody checks</a>).</li>
<li><strong>Real experience.</strong> That the server responds in 200 ms does not mean the page loads in under three seconds on the phone of a family with a slow connection; measurement on real devices (Core Web Vitals) shows it (see <a href="/accesibilidad-web-formularios-contraste-teclado-checklist-colegios-pymes/">web accessibility</a>).</li>
<li><strong>Backup and its restoration.</strong> If all that is monitored is the outage, the plan for when it happens is missing (see <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: the first 60 minutes</a>).</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, monitoring has gone from a luxury of large companies to a basic practice, and free or cheap services exist that cover the essentials. In Colombia and Latin America, the applications of schools, education secretariats and small businesses often depend on a single person or an outside provider, with no monitoring and no plan; the facts show up in high-demand seasons (enrollment, payments, results), when an unwatched system goes down just when it is needed most. For <strong>principals</strong>, the question is how much an hour of downtime costs and who would know; for <strong>technical staff</strong>, start with the two or three critical signals; for <strong>families</strong>, that a procedure is not lost to an outage nobody saw; and for <strong>teachers</strong> who use platforms, knowing what happens when they fail (see <a href="/clases-que-funcionen-sin-conexion-modelo-planificacion-offline-first/">classes without connectivity</a>).</p>

<h2>Tools to start in an orderly way</h2>
<p>If your need is to invoice or send documents without setting up your own application (and without having to monitor it), these Excel templates work on your own computer. And for sensitive documents such as a PIAR, <a href="/herramientas/piar/">PIAR con IA</a> is an already-operated tool with controlled access, although you must keep your own backups.</p>
{{productos:factura-con-envio-por-correo-al-cliente,piar-con-ia-5-planes}}
<p>Keep reading: <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a> (monitoring is part of the cost of your own application) and <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">schools' technology debt</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is the minimum I should monitor?</h3>
<p>Availability of the main page and the critical flow (for example, payment), errors, disk and database, that scheduled jobs ran and that business operations complete.</p>
<h3>What are the four golden signals?</h3>
<p>Latency, traffic, errors and saturation: the four metrics that, according to Google's Site Reliability Engineering book, are worth measuring in any user-facing system.</p>
<h3>What availability should I promise?</h3>
<p>The one that justifies the harm of an outage. 99% allows about 7.2 hours a month; 99.9%, about 43 minutes; 99.99%, about 4 minutes. Each extra "nine" costs more.</p>
<h3>Why not alert on the first failure?</h3>
<p>A single failure may be a network hiccup; alerting on everything creates noise and people stop paying attention. Alert after several consecutive failures.</p>
<h3>Can I monitor from the same server?</h3>
<p>Not for availability: if the server goes down, the monitor goes down with it. Use an external monitor.</p>

<p class="notice"><strong>This week:</strong> download the <a href="/descargas/monitoreo-web/plan-monitoreo-aplicacion-web.xlsx">monitoring plan</a> (in Spanish), mark which signals you already have and start with the critical ones. If you want to see how a monitor works, run the <a href="/descargas/monitoreo-web/monitor_basico.py">basic monitor</a> against your own site.</p>

<h2>Food for thought</h2>
<p>Monitoring costs time and money, and its value shows precisely when nothing happens. <strong>Who should pay the cost of watching the systems that thousands of families depend on: the institution that offers them, the provider that builds them or the State when they are public services? And when a system goes down and nobody knew, whose failure was it: whoever did not look or whoever never asked for someone to look?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:senales}}' => $img('monitoreo-aplicacion-web-senales', 573, 'Four cards with the golden signals: latency, traffic, errors and saturation, each with its meaning.', 'The four golden signals.'),
    '{{img:disponibilidad}}' => $img('monitoreo-aplicacion-web-disponibilidad', 444, 'Table with the downtime each availability target allows: 99% seven hours a month, 99.9% 43 minutes and 99.99% four minutes.', 'How much downtime each target allows.'),
]);

return [
    'que-monitorear-aplicacion-web-senales-umbrales-alertas-plan' => [
        'slug' => 'what-to-monitor-in-a-web-application-signals-thresholds-alerts-plan',
        'title' => 'What to Monitor in a Web Application to Find Out Before Your Users Do: Signals, Thresholds and Alerts',
        'excerpt' => 'The four golden signals and your business ones, example thresholds, which alerts are worth having, an availability calculator, a tested basic Python monitor and a downloadable Excel monitoring plan.',
        'seo_title' => 'What to Monitor in a Web App: Signals and Alerts',
        'seo_description' => 'What to monitor in a web application: essential signals, thresholds, useful alerts, an availability calculator and a Python monitor with a downloadable plan.',
        'focus_keyword' => 'what to monitor web application',
        'cover' => '/assets/img/articulos/monitoreo-aplicacion-web/monitoreo-aplicacion-web-portada-en',
        'cover_alt' => 'Cover "What to monitor in a web application to find out before your users do" with a card: 43 minutes a month is all the downtime a 99.9% availability target allows.',
        'content_html' => $html,
    ],
];
