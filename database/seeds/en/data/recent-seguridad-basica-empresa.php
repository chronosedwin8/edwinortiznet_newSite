<?php

declare(strict_types=1);

// English version of «La mayoría de las empresas no necesita hackers más sofisticados…». Key is the Spanish slug. Data checked on October 9, 2026
// (Verizon DBIR 2025, IBM Cost of a Data Breach 2025, Microsoft Research MFA study, NIST SP 800-63B-4). Status and date come from the Spanish post
// via en/02_recent_posts.php (scheduled for Tuesday, October 20, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/seguridad-basica-empresa/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>When we think of a cyberattack we imagine an expert typing at lightning speed in a dark room. Reality is duller and more uncomfortable: most disasters start with a reused password, an account without a second verification, a permission nobody reviewed or a backup nobody tested. <strong>You do not need more sophisticated hackers; it is enough that your basic mistakes are still there.</strong></p>
<p>In this article I show you what the data say, which four basic mistakes cause the most damage and give you a <strong>20-point checklist</strong> to audit the basic security of your company, accounting office or school. Data checked on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> According to Verizon's 2025 DBIR, stolen or abused credentials are the top initial access route (22% of breaches) and about 60% of breaches involve a human element. Multi-factor authentication cuts the risk of an account being compromised by more than 99% in a Microsoft study. Four fronts: passwords, MFA, permissions and backups you can actually restore.</p>

<h2>What the data say: the basics are still the front door</h2>
<p>Verizon's <a href="https://www.verizon.com/business/resources/reports/dbir/">2025 Data Breach Investigations Report</a> analyzes thousands of real breaches. Among its findings, the most common way in was <strong>credential abuse (22%)</strong>, followed by vulnerability exploitation (20%) and phishing (16%); and about 60% of breaches had a human component, such as falling for a trick or using stolen credentials. One nuance that is often confused: the 88% figure circulating in summaries refers to basic web attacks where stolen credentials were used, not to all breaches.</p>
{{img:datos}}
<p>How much does a mistake cost? <a href="https://www.ibm.com/reports/data-breach">IBM's 2025 Cost of a Data Breach report</a> estimates a global average of US$4.44 million per breach; in Latin America, the report's sample (which includes companies from Argentina, Brazil, Chile, Colombia and Mexico) came to about US$2.51 million. These are averages from large and medium companies and there is no Colombia-only figure, but the reading is clear: a small business does not need to lose millions for the blow to be fatal. And local context matters: Colombia's National Digital Security Strategy placed it as the second most attacked country in Latin America in 2025, with 17% of the region's attempts, as <a href="https://www.portafolio.co/tecnologia/estafas-con-voces-clonadas-por-ia-crecieron-30-en-diciembre-y-alertan-a-expertos-en-colombia-486082">Portafolio</a> reported.</p>

<h2>Mistake 1: weak, reused or poorly managed passwords</h2>
<p>The <a href="https://csrc.nist.gov/pubs/sp/800/63/b/4/final">NIST SP 800-63B-4</a> guidance (published in July 2025) changed several myths: it recommends prioritizing <strong>length</strong> over complexity, <strong>not forcing periodic changes</strong> without evidence of compromise, and checking passwords against lists of leaked or common ones. In practice, for a small company:</p>
<ul>
<li>Use long passwords (multi-word phrases) that are <strong>unique</strong> for every service.</li>
<li>Adopt a <strong>password manager</strong>: it is the only realistic way to have unique keys without writing them on paper or in an Excel file.</li>
<li>Do not force a change every 90 days: that produces "Password2026!" and "Password2027!". Change it when a leak is suspected.</li>
<li>Check whether your emails appear in known breaches and change the affected passwords.</li>
</ul>

<h2>Mistake 2: not using multi-factor authentication (MFA)</h2>
<p>A stolen password stops working if a second factor is required. A <a href="https://arxiv.org/abs/2305.00945">Microsoft Research study (2023)</a> of accounts with suspicious activity found that MFA reduced the risk of compromise by 99.22% across the population and by 98.56% when credentials had already leaked. It is a risk reduction observed on Microsoft accounts, not a universal guarantee, and the authors found that authenticator apps work better than SMS messages. Prioritize in this order:</p>
<ol>
<li><strong>Email</strong> (it resets every other account).</li>
<li><strong>Online banking</strong> and payment accounts.</li>
<li><strong>Admin accounts</strong> (hosting, domain, cloud, company social media).</li>
<li>Then every other service that allows it.</li>
</ol>

<h2>Mistake 3: excessive permissions and accounts nobody closes</h2>
<p>"Least privilege" means each person accesses only what they need for their job. In practice it breaks in four ways: everybody is an administrator "so they don't complain", one account is shared among several people, access is not closed for someone who left and shared folders are open to "anyone with the link". A school lives it with teachers' accounts when they leave mid-year and with access to grades; a small business, with the outside accountant who keeps access to everything. Solutions: roles by position, one account per person, an <em>offboarding</em> list to close access on the last day and quarterly reviews of who sees what.</p>

<h2>Mistake 4: backups that were never verified</h2>
<p>Having files "in the cloud" is not having a backup: synchronization also replicates deletions and files encrypted by ransomware. A useful backup is an <strong>independent copy, with versions, that you have tested restoring</strong>. The classic 3-2-1 rule (three copies, on two media, one off-site) is still a good starting point. And the only way to know whether it works is a <strong>restore test</strong>: pick a file and a folder, restore them on another computer and check that they open. If you never did, you do not have a backup: you have a hope.</p>

<h2>Checklist: basic security self-assessment</h2>
<p>This is the practical resource. Answer "yes" or "no" to each point and count your "yes" answers. It is a practical self-diagnostic tool, not a certification or a formal audit.</p>
{{img:pasos}}
<table>
<thead><tr><th>Area</th><th>Question (answer yes or no)</th></tr></thead>
<tbody>
<tr><td><strong>Passwords</strong></td><td>1. All important accounts have long passwords that differ from each other.</td></tr>
<tr><td><strong>Passwords</strong></td><td>2. We use a password manager (nobody keeps passwords on paper, in chats or in unencrypted files).</td></tr>
<tr><td><strong>Passwords</strong></td><td>3. We do not force periodic changes for no reason, but we change them when a leak is suspected.</td></tr>
<tr><td><strong>Passwords</strong></td><td>4. Admin passwords are not shared over WhatsApp or email.</td></tr>
<tr><td><strong>Passwords</strong></td><td>5. We check whether our emails appear in known breaches.</td></tr>
<tr><td><strong>MFA</strong></td><td>6. The company email has two-step verification.</td></tr>
<tr><td><strong>MFA</strong></td><td>7. Online banking has MFA and transaction notifications are on.</td></tr>
<tr><td><strong>MFA</strong></td><td>8. Admin accounts (domain, hosting, cloud) have MFA.</td></tr>
<tr><td><strong>MFA</strong></td><td>9. We use an authenticator app or security key, not just SMS, where possible.</td></tr>
<tr><td><strong>MFA</strong></td><td>10. We store recovery codes safely.</td></tr>
<tr><td><strong>Permissions</strong></td><td>11. Each person has their own account; none are shared.</td></tr>
<tr><td><strong>Permissions</strong></td><td>12. Only those who need it are administrators.</td></tr>
<tr><td><strong>Permissions</strong></td><td>13. We close access for people who leave on the same day.</td></tr>
<tr><td><strong>Permissions</strong></td><td>14. Shared folders are not open to "anyone with the link".</td></tr>
<tr><td><strong>Permissions</strong></td><td>15. We review who has access to what at least every quarter.</td></tr>
<tr><td><strong>Backups</strong></td><td>16. We have at least one independent copy of critical data (not just synchronized).</td></tr>
<tr><td><strong>Backups</strong></td><td>17. One copy is off-site or disconnected, safe from ransomware.</td></tr>
<tr><td><strong>Backups</strong></td><td>18. We tested restoring a file and a folder in the last 6 months.</td></tr>
<tr><td><strong>Backups</strong></td><td>19. We know how long it would take to operate again (and how much data we would lose).</td></tr>
<tr><td><strong>Backups</strong></td><td>20. Someone has the restore procedure in writing.</td></tr>
</tbody>
</table>
<p><strong>How to read your score (indicative).</strong> 17 to 20 "yes": a good base; keep reviewing. 11 to 16: there are gaps worth closing this month, starting with MFA and backups. 10 or fewer: high priority; spend a week closing the email, banking and backup points. If an incident exposes personal data, you also have legal obligations: according to several law firms, in Colombia security incidents must be reported to the Superintendency of Industry and Commerce in the National Database Registry within 15 business days of detection; confirm the current text at sic.gov.co or with a lawyer.</p>

<h2>Colombia, Latin America and the world: where the gap is</h2>
<p>Worldwide, MFA and backups are already minimum requirements for large companies and for cyber insurance. In Latin America, IBM finds that adopting AI and automation in security lowers costs, and 75% of companies in the region already use them at different maturity levels. In Colombia the gap is usually one of priorities, not money: many small businesses and schools have antivirus but no MFA, and spreadsheets with passwords taped to the monitor. For <strong>teachers and school leaders</strong> the risk is double: sensitive data of minors and a paralyzed school operation. For <strong>families</strong> the lesson is the same on a smaller scale: MFA on email and on the children's accounts, and photos backed up.</p>

<h2>Tools to start today</h2>
<p>If your business invoices or sends documents by email, standardize the sender and the format: the <a href="/producto/factura-con-envio-por-correo-al-cliente/">Invoice with email delivery to the customer</a> always keeps the same template and bank details, so any account change that arrives "on your behalf" stands out as an anomaly (I explained it in the article on <a href="/estafas-voz-clonada-ia-protocolo-verificacion/">voice-cloning scams</a>). And if you teach, the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a> includes a digital citizenship sequence (footprint, privacy, cyberbullying and personal data) to bring these habits into the classroom; the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> turns this checklist into a quiz for your students (<a href="/examenes/demo/">free demo</a>).</p>
{{productos:factura-con-envio-por-correo-al-cliente,kit-de-ia-para-docentes}}
<p>If you need someone to help you implement templates and controls in Excel, there is the <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS advisory</a>. And to keep reading: <a href="/excel-esta-muerto-era-de-la-ia/">Is Excel dead in the age of AI?</a> and <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">how to automate tasks in Excel and reduce errors</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What should I do first to protect my company?</h3>
<p>Turn on two-step verification on email and online banking, and run a restore test of your backups. They are the two lowest-cost, highest-effect changes.</p>
<h3>Is antivirus enough?</h3>
<p>No. It protects against some malware, but not against a stolen password, an excessive permission or a nonexistent backup, which are the fronts that weigh most in the data.</p>
<h3>How often should I change passwords?</h3>
<p>NIST no longer recommends mandatory periodic changes without evidence of compromise. Better: long, unique passwords, a password manager and an immediate change if a leak is suspected.</p>
<h3>Is the cloud a backup?</h3>
<p>Not necessarily. Synchronization replicates errors, deletions and encryption. A backup has versions, is independent and is tested by restoring.</p>
<h3>What do I do if I was already attacked?</h3>
<p>Isolate the device, change passwords from a clean device, tell the bank if money was involved, keep the evidence and report it (in Colombia, the Police's CAI Virtual and the Attorney General's Office). If personal data was involved, assess the report to the SIC.</p>

<p class="notice"><strong>Do your self-assessment today.</strong> Answer the 20 points, close the three most urgent ones this week and schedule a restore test. Share the checklist with whoever manages your systems and, if you teach, bring it to class with the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a>.</p>

<h2>Food for thought</h2>
<p>We spend millions on physical locks and alarms and almost nothing on checking who holds the digital keys. <strong>If the most common security mistake is human, is it fair to punish whoever falls for a trick, or should we design systems where one slip does not have catastrophic consequences?</strong> And who should answer when a small company loses its customers' data for not doing the basics: the owner, the technology provider or the lack of a security culture across the whole country?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('seguridad-basica-empresa-datos', 588, 'Bar chart of initial access vectors in security breaches according to Verizon\'s 2025 DBIR: stolen or abused credentials 22%, vulnerability exploitation 20% and phishing 16%.', 'Initial access vectors. Source: Verizon, 2025 DBIR.'),
    '{{img:pasos}}' => $img('seguridad-basica-empresa-pasos', 427, 'Five steps of a basic security audit: take inventory, turn on MFA, cut permissions, test the restore, and document and repeat.', 'A basic security audit in five steps.'),
]);

return [
    'errores-basicos-seguridad-empresa-lista-comprobacion' => [
        'slug' => 'basic-security-mistakes-company-checklist',
        'title' => 'Most Companies Don\'t Need More Sophisticated Hackers to Suffer a Disaster: They Need to Fix Their Basic Security Mistakes',
        'excerpt' => 'Weak passwords, no multi-factor authentication, excessive permissions and unverified backups: what the data say and a 20-point checklist to self-assess your basic security.',
        'seo_title' => 'Basic Security for Companies: A Checklist',
        'seo_description' => 'The basic security mistakes that cause the most damage (passwords, MFA, permissions and backups) and a 20-point checklist to audit your company or school.',
        'focus_keyword' => 'basic security for companies',
        'cover' => '/assets/img/articulos/seguridad-basica-empresa/seguridad-basica-empresa-portada-en',
        'cover_alt' => 'Cover reading "Your company does not need sophisticated hackers to suffer a disaster: fix the basics" with a card listing four marked mistakes: weak passwords, no multi-factor authentication, excess permissions and unrestored backups.',
        'content_html' => $html,
    ],
];
