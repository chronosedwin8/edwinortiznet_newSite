<?php

declare(strict_types=1);

// English version of «Ransomware: qué hacer en los primeros 60 minutos, y qué no hacer, en un colegio …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ransomware-60-minutos/' . $name . '-en';
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
<p>On a Monday morning, a computer in the school office shows a red screen: "Your files have been encrypted. Pay to recover them." Within minutes, other machines start to fail. What happens in the first hour decides whether the incident stays a serious nuisance or becomes weeks without grades, without billing and with students' data in the hands of extortionists.</p>
<p>Most schools and small businesses have no protocol: they improvise. This article proposes one for the <strong>first 60 minutes</strong>, minute by minute, based on the response checklist in the #StopRansomware guide from CISA, the FBI, the NSA and MS-ISAC, adapted to a Colombian school or small business. It includes a <a href="/descargas/ransomware/protocolo-60-minutos-ransomware.xlsx">downloadable workbook</a> (in Spanish) with the action list, the contacts, the incident log and the restoration order. Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> In the first minutes: <strong>isolate without powering off</strong>, <strong>notify by phone</strong> (not through channels that may be compromised), <strong>protect the backups</strong> and <strong>record everything</strong>. Do not pay without advice, do not restore without verifying the backup and do not improvise communication. This is a general guide: adapt it with your IT provider and a legal adviser; it does not replace professional help.</p>

<h2>What it is and how common it is</h2>
<p>Ransomware is malicious software that encrypts an organization's files and demands payment in exchange for the key. Today it is common for attackers to also <strong>steal</strong> the data before encrypting it and threaten to publish it ("double extortion"); that is why restoring a backup does not always close the problem.</p>
<p>According to the Verizon 2025 DBIR (which analyzes 2024 incidents worldwide), ransomware was present in <strong>44%</strong> of the breaches analyzed, up from 32% the year before; 64% of victims did not pay the ransom, and the median payment was about <strong>US$ 115,000</strong>. In small and medium business breaches, ransomware appeared in <strong>88%</strong>. (Figures taken from specialized coverage of the report; check the original report.) There is no reason to believe a Colombian school or small business is out of the crosshairs: attackers tend to look for those with fewer defenses and valuable data.</p>
{{img:datos}}

<h2>The first 60 minutes</h2>
{{img:ventanas}}
<h3>0 to 5 minutes: isolate</h3>
<ul>
<li><strong>Disconnect the machine from the network</strong> (cable and Wi-Fi). CISA's guide says to determine which systems are affected and isolate them immediately.</li>
<li><strong>Do not power it off</strong>, unless you cannot disconnect it: powering off can erase evidence held in memory.</li>
<li>Take a <strong>photo of the screen</strong> with the ransom message. Do not answer the attackers or open anything else.</li>
</ul>
<h3>5 to 15 minutes: notify and protect</h3>
<ul>
<li><strong>Phone</strong> the person in charge of the incident and the IT provider. Do not use the institution's email or chat if they may be compromised; CISA's guide recommends coordinating isolation by phone so attackers do not learn they have been detected.</li>
<li>If several machines are affected, <strong>disconnect that network segment</strong> (or the switch).</li>
<li><strong>Protect the backups</strong>: disconnect backup drives and close cloud storage sessions. A connected backup can be encrypted too (see <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">the cloud is not a backup</a>).</li>
</ul>
<h3>15 to 30 minutes: record and preserve</h3>
<ul>
<li>Open the <strong>incident log</strong>: time, who detected it, what is seen and what was done.</li>
<li><strong>Preserve evidence</strong>: photos, names of encrypted files, logs. The guide suggests capturing system and memory images from a sample of machines; ask your IT provider or a specialist to do this.</li>
<li>From a clean machine, <strong>change administrative passwords</strong> and enable two-step verification.</li>
</ul>
<h3>30 to 45 minutes: assess</h3>
<ul>
<li>Rank systems by criticality with the "Inventario_critico" sheet: what sustains the day's operations? That is restored first.</li>
<li>Ask: <strong>is personal data affected?</strong> If so, reporting obligations are triggered.</li>
</ul>
<h3>45 to 60 minutes: report and decide</h3>
<ul>
<li>Inform <strong>management or the principal's office</strong> and the person in charge of personal data.</li>
<li>Contact a <strong>legal adviser</strong> and the authorities (in Colombia, for example, the National Police's CAI Virtual; verify the current channel).</li>
<li>Tell internal users what to do and what not to do, with a short message through a safe channel.</li>
<li><strong>Verify the backup in a clean environment before restoring</strong>: restoring onto a still-infected system repeats the problem.</li>
</ul>

<h2>What not to do</h2>
<ul>
<li><strong>Paying in a rush.</strong> CISA's guide does not recommend paying and warns that payment does not guarantee you recover your data or that it will not be leaked; it also funds criminals. Before any decision, consult the authorities and a legal adviser, who can also tell you whether a public decryptor exists for that variant.</li>
<li><strong>Powering off and restarting everything</strong> without judgment, losing evidence.</li>
<li><strong>Restoring without verifying</strong> that the backup is clean and that the entry point was closed.</li>
<li><strong>Deleting files</strong> "to clean up": it destroys evidence and can complicate recovery.</li>
<li><strong>Communicating halfway</strong> or denying the incident to those entitled to know.</li>
</ul>

<h2>The Colombian framework in a few lines</h2>
<ul>
<li><strong>Law 1273 of 2009:</strong> defines computer crimes; for example, computer damage (art. 269D) and use of malicious software (art. 269E) can apply to a ransomware attack. A report helps the investigation and your legal protection.</li>
<li><strong>Law 1581 of 2012:</strong> if the incident compromises personal data (for example, students' data), the data controller must report it to the Superintendence of Industry and Commerce. According to the guides consulted, the report of security incidents to the National Database Registry must be made within 15 business days of detection; confirm the current procedure and deadline on the SIC website with your adviser.</li>
<li><strong>Minors' data:</strong> its processing requires special care (see <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">student data</a>).</li>
</ul>

<h2>Before it happens: what changes the outcome</h2>
<ol>
<li><strong>3-2-1 backup</strong>: three copies, on two different media, one offline or off the network. And <strong>test it</strong>: there is a <a href="/descargas/respaldo/verificar-restauracion.ps1">script to verify restoration</a>.</li>
<li><strong>Two-step verification</strong> on email, platforms and administrative accounts.</li>
<li><strong>Updates</strong> of systems, VPNs and applications; many attacks enter through known flaws.</li>
<li><strong>Least-privilege accounts</strong>: nobody should use an administrative account for daily work.</li>
<li><strong>Training</strong> against phishing, because email is still a frequent door (see <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a> and <a href="/estafas-voz-clonada-ia-protocolo-verificacion/">cloned-voice scams</a>).</li>
<li><strong>A drill</strong> of this protocol once a year: the first time you read it should not be the day of the attack.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, education and small businesses are frequent targets because they combine valuable data with limited security budgets. In Colombia and Latin America, many schools depend on a single systems person, or an outside provider, and have no written plan. For <strong>principals</strong>, the question is who decides and who answers in the first hour; for <strong>teachers and administrative staff</strong>, what to do on seeing a ransom screen (disconnect and report, do not test your luck); and for <strong>families</strong>, which of their children's data are at stake and how they would be informed. See also <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a> and <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">integrations that fail silently</a>.</p>

<h2>Protect sensitive data by design</h2>
<p>A school's most sensitive documents (such as students' PIARs) should not live in shared folders without control. <a href="/herramientas/piar/">PIAR con IA</a> keeps them in an account with controlled access, although you must keep your own backups and rules. And the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> helps keep exams and their solutions in one place, instead of scattered across emails and USB drives.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}

<h2>Frequently asked questions</h2>
<h3>Should I power off the computer if I see a ransom note?</h3>
<p>First disconnect it from the network. Power it off only if you cannot disconnect it, because powering off can erase evidence held in memory.</p>
<h3>Should I pay the ransom?</h3>
<p>US authorities do not recommend it: it does not guarantee data recovery or that data will not be leaked, and it funds criminals. Consult a legal adviser and the authorities before deciding.</p>
<h3>Is having a backup enough?</h3>
<p>It helps a lot, but only if it is isolated, restoring has been tested and it was not encrypted too. Also, double extortion threatens to publish stolen data.</p>
<h3>Do I have to report the incident?</h3>
<p>If personal data is compromised, yes, to the SIC (according to the guides consulted, within 15 business days of detection; confirm the current deadline). It is also advisable to file a report with the authorities.</p>
<h3>How often should I practice the protocol?</h3>
<p>At least once a year and whenever systems or the responsible staff change.</p>

<p class="notice"><strong>Get ready this week.</strong> Download the <a href="/descargas/ransomware/protocolo-60-minutos-ransomware.xlsx">60-minute protocol</a> (in Spanish), fill in the contacts sheet with mobile numbers (not just emails), print it and keep a copy off the network. Then test your backup with the <a href="/descargas/respaldo/verificar-restauracion.ps1">verification script</a>.</p>

<h2>Food for thought</h2>
<p>When a school suffers an attack, the first victims are the students and families whose data were in its care. <strong>Who should answer when minors' data leak through an attack that could have been prevented with backups and a protocol: the IT provider, the principal's office, the governing board or the State that does not demand minimum cybersecurity standards from educational institutions? And if paying the ransom can be the quickest way out, is it legitimate to do so when it funds crime?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('ransomware-60-minutos-datos', 573, 'Four cards with data from the Verizon 2025 DBIR report: ransomware was in 44% of breaches, 64% of victims did not pay, the median payment was US$ 115,000 and it appeared in 88% of small-business breaches.', 'Ransomware is now part of almost half of the breaches analyzed.'),
    '{{img:ventanas}}' => $img('ransomware-60-minutos-ventanas', 467, 'Five time windows for the first 60 minutes: isolate, notify, record, assess and report, with the priority for each.', 'Five windows, one priority in each.'),
]);

return [
    'ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme' => [
        'slug' => 'ransomware-what-to-do-in-the-first-60-minutes-school-small-business-protocol',
        'title' => 'Ransomware: What to Do in the First 60 Minutes, and What Not to Do, in a School or Small Business',
        'excerpt' => 'A minute-by-minute protocol for the first 60 minutes of a ransomware attack, based on the CISA and FBI guide, with 2025 DBIR data, the Colombian framework and a downloadable workbook with contacts and an incident log.',
        'seo_title' => 'Ransomware: What to Do in the First 60 Minutes',
        'seo_description' => 'A protocol for the first 60 minutes of a ransomware attack at a school or small business: isolate, notify, record and report, with a downloadable workbook.',
        'focus_keyword' => 'ransomware first 60 minutes',
        'cover' => '/assets/img/articulos/ransomware-60-minutos/ransomware-60-minutos-portada-en',
        'cover_alt' => 'Cover "Ransomware: what to do in the first 60 minutes and what not to do" with a list: isolate the machine from the network, phone the person in charge and protect the backups, ticked; pay without consulting, crossed out.',
        'content_html' => $html,
    ],
];
