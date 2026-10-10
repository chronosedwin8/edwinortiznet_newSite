<?php

declare(strict_types=1);

// English version of «Extensiones del navegador: la comodidad que puede ver todo lo que haces, con inv…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/extensiones-navegador/' . $name . '-en';
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
<p>A browser extension seems like an innocent detail: a dark mode, a translator, a coupon finder, a PDF converter. But when you install one, you give it permission to act <strong>inside your browser</strong>, right where you log in to your email, the school platform, the bank and your students' accounts. An extension with permission to "read and change your data on all websites" can, in principle, see what you type and what you see everywhere.</p>
<p>This article explains the risks of browser extensions, with verified data, a real case of a legitimate extension that was compromised, a <a href="/descargas/extensiones-navegador/auditar_extensiones.py">Python auditor</a> that reads installed extensions (I tested it with examples) and an <a href="/descargas/extensiones-navegador/inventario-politica-extensiones-navegador.xlsx">Excel workbook</a> (in Spanish) with an inventory, a permissions matrix and a model policy. Data verified on October 10, 2026.</p>
<p class="notice"><strong>Summary.</strong> Almost all users have extensions and many ask for very broad permissions. The risk does not come only from "bad" extensions: a legitimate one can be <strong>compromised</strong>, sold to another owner or abandoned. The defense is process: <strong>inventory, justify each extension, prefer those with the fewest permissions, update and review every quarter</strong>. And on machines with sensitive data, separate and clean browser profiles.</p>

<h2>What the data say</h2>
<p>LayerX's Enterprise Browser Extension Security Report 2025, which combines public extension-store data with telemetry from enterprise environments, reports (according to specialized press coverage) that <strong>99%</strong> of enterprise users have at least one extension installed, that <strong>53%</strong> have extensions with "high" or "critical" permissions (which can reach cookies, passwords and browsing data) and that 51% of extensions had gone over a year without an update; generative-AI extensions, moreover, have permissions of that level about twice as often as the average. These are data from enterprise environments and from a commercial security source, so read them as a sign of scale, not as an exact figure for a school.</p>
{{img:datos}}

<h2>A real case: the legitimate extension that turned malicious</h2>
<p>In December 2024, the security company Cyberhaven acknowledged that its own Chrome extension had been compromised. According to its analysis of the incident, an employee with admin access to the Chrome Web Store received a phishing email posing as developer support and was led to a fake OAuth consent page. With that access, the attackers published a malicious version (24.10.4) that was live for <strong>less than 24 hours</strong>, between December 25 and 26, and affected only those who received the automatic update in that window. The code was designed to steal cookies and authentication tokens for certain social media and AI platforms. Researchers concluded it was part of a broader campaign (using the same method against other extensions); figures for affected extensions and users vary by source (Cyberhaven's own extension had about 400,000 users), so I do not cite them as definitive.</p>
<p>The lesson is what matters: <strong>an extension updates itself, and whoever controls the developer's account controls what reaches all users</strong>. You do not need to install something "bad": it is enough for a good extension to be compromised or change owner.</p>

<h2>The three ways an extension becomes a risk</h2>
<ol>
<li><strong>Malicious from the start:</strong> it disguises itself as a utility (coupons, downloaders, "improvements") to collect data or inject ads.</li>
<li><strong>Compromised or sold:</strong> a legitimate extension changes owner or code (as in the Cyberhaven case, through stolen developer access). There are also precedents of popular extensions that, after a sale, began to include harmful code.</li>
<li><strong>Abandoned:</strong> it stops being updated, accumulates known flaws and stays installed on thousands of machines.</li>
</ol>

<h2>Permissions: what they ask for and what they mean</h2>
<table>
<thead><tr><th>Permission</th><th>What it allows</th><th>Risk</th></tr></thead>
<tbody>
<tr><td><strong>All sites</strong> (<code>&lt;all_urls&gt;</code>)</td><td>Read and modify any page you visit</td><td>See what you type and capture form data</td></tr>
<tr><td><strong>cookies</strong></td><td>Read session cookies</td><td>Impersonate you without your password</td></tr>
<tr><td><strong>history</strong></td><td>Read your history</td><td>Profile you or leak your habits</td></tr>
<tr><td><strong>webRequest</strong></td><td>See or block network traffic</td><td>Intercept and alter requests</td></tr>
<tr><td><strong>clipboardRead</strong></td><td>Read what you copy</td><td>Capture copied passwords and codes</td></tr>
<tr><td><strong>debugger, nativeMessaging, proxy</strong></td><td>Control the browser or network, talk to programs on the machine</td><td>Deep control</td></tr>
</tbody>
</table>
<p>The workbook's "Matriz_de_permisos" sheet has ten sensitive permissions with their risk and <strong>when they can be legitimate</strong>: a password manager needs access to all sites to fill in forms, and an ad blocker needs to see traffic. That is why the question is not "does it have permissions?" but <strong>"is this level of permissions justified for what it does, and do I trust whoever maintains it?"</strong>. Chrome and other browsers have been migrating extensions to so-called Manifest V3, which limits some capabilities (such as running remote code); that helps, but it does not remove the risk of broad permissions.</p>

<h2>The Python auditor: tested with examples</h2>
<p>A <code>manifest.json</code> file accompanies every installed extension and declares its permissions. I wrote an auditor of about 100 lines (standard library only) that reads those files in a Chrome or Edge profile, resolves localized names, flags sensitive permissions and computes a score. It does not connect to the internet or change anything. I tested it with five sample extensions (invented by me, with the typical permissions of each kind):</p>
<pre><code>5 extensiones en ...\User Data\Default\Extensions
  [ALTO ] 18 pts | Cupones y ofertas (ejemplo)        v1.9.4    MV2 | todos los sitios: SÍ | cookies, history, tabs, webRequest, webRequestBlocking
  [ALTO ] 11 pts | Convertidor de PDF (ejemplo)       v3.1      MV3 | todos los sitios: SÍ | clipboardRead, downloads, scripting
  [MEDIO]  7 pts | Gestor de contrasenas (ejemplo)    v5.2.1    MV3 | todos los sitios: SÍ | scripting
  [BAJO ]  0 pts | Modo oscuro (ejemplo)              v2.0      MV3 | todos los sitios: no | -
  [BAJO ]  0 pts | Temporizador de estudio (ejemplo)  v1.0      MV3 | todos los sitios: no | -
Resumen: 2 de riesgo alto, 3 con acceso a todos los sitios.</code></pre>
{{img:auditor}}
<p>Notice two things. First, the "Cupones y ofertas" (coupons) example (which asks for cookies, history and network traffic on all sites) rises to 18 points, and the "Convertidor de PDF" (which reads the clipboard and acts on all https sites) to 11: both "ALTO" (high). Second, the password manager ends up "MEDIO" (medium) because it needs broad access: <strong>the score measures how much an extension could do, not whether it is bad</strong>. I use it as a filter to decide which ones to look at first. I also ran the auditor on a real Chrome profile and it worked without errors.</p>

<h2>Inventory and decision on one sheet</h2>
<p>The "Inventario" sheet asks, for each extension: what it is used for, who answers for it, how many sensitive permissions it has, whether it acts on all sites, when it was last updated, whether the source is known and trusted and whether the use is justified. It computes a score (two points per sensitive permission, four for acting on all sites, three for not being updated in over a year, three for an untrusted source and two for lack of justification) and suggests a decision: <strong>"Permitir"</strong> (allow), <strong>"Justificar y revisar cada trimestre"</strong> (justify and review quarterly) or <strong>"Retirar o revisar con urgencia"</strong> (remove or review urgently). With the five examples, two are flagged for removal or urgent review, three have access to all sites and the institutional password manager ends up at "justify and review quarterly". The weights are my own proposal and you can adjust them.</p>

<h2>A policy of eight rules</h2>
<ol>
<li>Only extensions from a list approved by IT are installed on institutional machines.</li>
<li>Every request says who asks for it, what for and what permissions it requests.</li>
<li>The extension with the fewest permissions that does the job is preferred.</li>
<li>No extensions from outside the official store or loose files are installed.</li>
<li>Whoever publishes their own extensions uses two-step verification (the Cyberhaven case began with phishing a developer).</li>
<li>Every quarter the inventory is reviewed and what is unused or no longer updated is removed.</li>
<li>Machines with sensitive data (students, finances) use separate, clean browser profiles.</li>
<li>If an extension appears compromised: it is uninstalled, passwords are changed and open sessions are reviewed.</li>
</ol>
<p>In a school with Google Workspace for Education or Microsoft accounts, administrators can usually allow or block extensions from the admin console; check with whoever administers the account and with your IT provider how it is done in your case.</p>

<h2>A personal ten-minute review</h2>
<ol>
<li>Open your browser's extensions page (in Chrome, <code>chrome://extensions</code>).</li>
<li><strong>Uninstall</strong> those you do not use or do not recognize.</li>
<li>For those that remain, open "Details" and check the <strong>site access</strong>: when possible, change it to "on click" or to specific sites, instead of "on all sites".</li>
<li>Ask who maintains it, when it was last updated and how many users it has; distrust those nobody maintains.</li>
<li>Use a <strong>separate profile</strong> for work with student data or money, without unnecessary extensions.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, extensions have become a known attack vector, because they install with one click and update themselves. In Colombia and Latin America, many schools and small businesses use Chromebooks or shared machines where each person installs what they want, with no inventory or policy; and "free AI" and "downloader" extensions are especially popular. For <strong>principals</strong>, the question is who authorizes what gets installed; for <strong>teachers</strong>, taking care of the extensions on the machine they use to log in to platforms and grades; for <strong>families</strong>, that a student's browser has no extensions that read what they type; and for <strong>students</strong>, understanding that "free" and "convenient" are sometimes paid for with data. See also <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into a free AI tool</a> (many AI extensions read the page you are on) and <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: the first 60 minutes</a>.</p>

<h2>Tools designed to care for data</h2>
<p><a href="/herramientas/piar/">PIAR con IA</a> keeps sensitive documents in an account with controlled access, and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> is designed so you write the context and topic, not student data. Even so, the machine you log in from must be clean: an extension with access to all sites can see what is on the screen.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>, <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a> and <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">an institutional AI policy</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Are browser extensions dangerous?</h3>
<p>They can be: they act inside the browser and, depending on their permissions, can see what you type and what you see. Most extensions are not malicious, but a legitimate one can be compromised, sold or abandoned.</p>
<h3>How do I know what permissions an extension has?</h3>
<p>On the store page, under "Details" on the browser's extensions page and, more completely, in the manifest.json file, which the workbook's auditor reads.</p>
<h3>Is it better to have few extensions or many?</h3>
<p>Few, with the lowest possible permissions and a clear reason for each. Every extra extension adds attack surface.</p>
<h3>What do I do if I suspect an extension?</h3>
<p>Uninstall it, change the passwords of accounts you used in that browser (starting with email and the bank), close open sessions and check for unusual activity.</p>
<h3>Are AI extensions riskier?</h3>
<p>According to LayerX's report, generative-AI ones have high or critical permissions more often than the average. They are justified only when you need them to read or write on pages, and you should not give them sensitive data.</p>

<p class="notice"><strong>This week:</strong> do the ten-minute review in your browser, download the <a href="/descargas/extensiones-navegador/inventario-politica-extensiones-navegador.xlsx">inventory and policy</a> (in Spanish) and, if you administer machines, run the <a href="/descargas/extensiones-navegador/auditar_extensiones.py">auditor</a>.</p>

<h2>Food for thought</h2>
<p>Every extension is a small delegation of trust: we give it access to what we do in exchange for a convenience. <strong>Who should answer when an extension installed by a teacher on a school machine leaks students' data: the teacher who installed it, the school that did not control it or the store that published it? And if convenience is so cheap, what is it really worth, what we pay with our data?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('extensiones-navegador-datos', 573, 'Four cards with data from the LayerX 2025 report and the Cyberhaven case: 99% with at least one extension, 53% with high or critical permissions, 51% of extensions not updated in over a year and under 24 hours for the malicious version.', 'Almost everyone has extensions, and many see a lot.'),
    '{{img:auditor}}' => $img('extensiones-navegador-auditor', 499, 'Table with four sample extensions audited: coupons and deals high risk with 18 points, PDF converter high with 11, password manager medium with 7 and dark mode low with 0.', 'What each extension could do.'),
]);

return [
    'extensiones-del-navegador-riesgos-permisos-inventario-politica' => [
        'slug' => 'browser-extensions-risks-permissions-inventory-policy',
        'title' => 'Browser Extensions: The Convenience That Can See Everything You Do, with an Inventory and Policy for Schools and Small Businesses',
        'excerpt' => 'What permissions browser extensions ask for, how a legitimate extension gets compromised (the Cyberhaven case), a tested Python auditor, an inventory with a risk score and a model policy of eight rules.',
        'seo_title' => 'Browser Extensions: Risks, Permissions and Policy',
        'seo_description' => 'Browser extension risks: permissions, the Cyberhaven case, a Python auditor, an inventory with a risk score and a model policy for your institution.',
        'focus_keyword' => 'browser extensions security risks',
        'cover' => '/assets/img/articulos/extensiones-navegador/extensiones-navegador-portada-en',
        'cover_alt' => 'Cover "Browser extensions: convenience that can see everything you do" with a card: 53% of enterprise users had extensions with high or critical permissions and 99% at least one extension installed.',
        'content_html' => $html,
    ],
];
