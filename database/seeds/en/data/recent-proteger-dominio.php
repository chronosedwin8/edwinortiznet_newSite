<?php

declare(strict_types=1);

// English version of «Proteger el dominio del colegio: registrador, DNS y correo (SPF, DKIM, DMARC), c…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/proteger-dominio/' . $name . '-en';
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
<p>One Monday the school website will not open and institutional email stops arriving. Nobody deleted anything: <strong>the domain expired</strong>, because the renewal was tied to the card of someone who no longer works there and the reminders went to their personal email. Another, more serious case: someone logs in to the registrar account with a leaked password, changes the name servers and starts receiving the institution's email.</p>
<p>The domain (the "name.edu.co" or "name.com") is a school's digital identity: the website, email, platforms and families' trust all hang from it. This article proposes <strong>five layers of protection</strong>, with a <a href="/descargas/proteger-dominio/auditor_dominio.py">Python auditor</a> that checks your domain's public records and an <a href="/descargas/proteger-dominio/inventario-dominios.xlsx">Excel inventory</a> (in Spanish) with risk points and a traffic light. The script was tested with real domains and the workbook was verified in Microsoft Excel 16; reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> This is a good-practice guide, not a security audit or legal advice. The exact options (menu names, costs, registry lock, DNSSEC) vary by registrar and domain type (.co, .edu.co, .com or others): confirm them in your provider's documentation. The auditor only reads public DNS records; it changes nothing.</p>

<h2>The five layers</h2>
{{img:capas}}
<h3>1. The registrar account</h3>
<p>It is the master key: whoever gets in controls the domain. Three basic measures: <strong>two-step verification (2FA)</strong>, preferably with an app or security key rather than text messages; an <strong>institutional recovery email</strong> (an institution mailbox several people can access, not someone's personal email); and a <strong>unique password</strong> kept in a manager, never reused. The registrant must be the institution, not a teacher or a vendor who helped "set up the site".</p>
<h3>2. The domain: lock, renewal and expiry</h3>
<ul>
<li><strong>Transfer lock</strong> (technically the <code>clientTransferProhibited</code> status): prevents the domain from moving to another registrar without first turning the lock off. It does not stop everything, but it gives the institution time to react if someone gets into the account. Keep it on except during a legitimate transfer.</li>
<li><strong>Auto-renewal</strong> with a valid institutional payment method, and reminders to more than one person. ICANN's policy for generic domains requires registrars to notify of expiry at least twice (roughly a month and a week before) and sets a 30-day recovery period after deletion, but not every domain has it: country-code domains (such as .co) follow their own rules, and recovery fees are set by each registrar. Renewing on time is always cheaper and safer than recovering.</li>
<li><strong>Registry lock</strong> for critical domains, if your registrar offers it: it adds manual verification for changes, usually at extra cost.</li>
<li><strong>Multi-year expiry</strong> for the main domain, if the budget allows.</li>
</ul>
<h3>3. DNS</h3>
<p>DNS is the "address book" that says where the site is and where email goes. Whoever changes it redirects everything. It pays to: know <strong>who manages the DNS zone</strong> (the registrar, the host or a separate service); have at least <strong>two name servers</strong>; keep a <strong>copy of the zone</strong> (the list of records) every time it changes, because it is the first thing lost in an emergency; and consider <strong>CAA</strong> (restricts which authorities may issue certificates for your domain) and <strong>DNSSEC</strong> (signs answers so they cannot be forged), if your provider supports them.</p>
<h3>4. Email: SPF, DKIM and DMARC</h3>
{{img:registros}}
<p>These three records stop anyone from sending email "as" your school:</p>
<ul>
<li><strong>SPF</strong> lists the servers authorized to send email. There must be <strong>only one</strong> SPF record and it must not exceed <strong>10 DNS lookups</strong> (<code>include</code>, <code>a</code>, <code>mx</code>, etc.), per RFC 7208; if it does, the result is a permanent error and legitimate mail may bounce. An SPF ending in <code>+all</code> authorizes anyone: a serious mistake.</li>
<li><strong>DKIM</strong> cryptographically signs each message. Your email provider (Google Workspace, Microsoft 365, a sending service) turns it on; you publish the key they give you.</li>
<li><strong>DMARC</strong> tells the receiver what to do when SPF or DKIM fail: <code>p=none</code> (just observe), <code>p=quarantine</code> (to spam) or <code>p=reject</code> (reject). The sensible path is to start at <code>none</code> with reports (<code>rua=</code>), review who sends on behalf of the domain and move up gradually to <code>quarantine</code> and <code>reject</code>. Staying at <code>none</code> forever monitors, but does not protect.</li>
</ul>
<p>There is also a practical effect: since 2024, Google and Yahoo require bulk senders (more than 5,000 messages a day to their users) to authenticate with SPF, DKIM and DMARC; for smaller volumes, having them improves delivery. Since the details of those rules are set by each provider and may change, check their official sender guidelines before deciding. If your school sends bulk circulars or newsletters, this is not optional.</p>
<h3>5. People</h3>
<p>Almost all domain incidents are about process, not technology: the person who set everything up left; nobody knows which account holds the domain; the outside vendor is the registrant. Define <strong>two owners</strong> (primary and backup), keep credentials in a shared manager with audited access, and document <em>where everything is</em> in a sheet (the downloadable inventory serves for this). If your institution suffers a broader incident, see the <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">first-60-minutes protocol</a>.</p>

<h2>The Python auditor</h2>
<p>The <code>auditor_dominio.py</code> script queries, over DNS-over-HTTPS, the public records of one or more domains and lists findings with a risk level (high, medium, low): fewer than two NS, missing or duplicate SPF, SPF with more than 10 lookups or ending in <code>+all</code>, DMARC missing, at <code>none</code> or without reports, and absence of CAA and DNSSEC. It only uses the Python standard library, version 3.8 or later. (Its messages are in Spanish.)</p>
<pre><code>python auditor_dominio.py mynewschool.edu.co

== mynewschool.edu.co ==
NS : ns1.provider.example., ns2.provider.example.
SPF: v=spf1 include:_spf.google.com ~all
DMARC: v=DMARC1; p=none;
 - MEDIO: DMARC en p=none (solo monitorea; no protege contra suplantacion)
 - BAJO: DMARC sin rua= (no recibes reportes)
 - BAJO: sin registros CAA (cualquier autoridad podria emitir certificados)</code></pre>
<p>(The example above is illustrative, with an invented domain name.) I tested it with real domains on October 10, 2026 and the result was as expected: <code>google.com</code> has DMARC at <code>reject</code> with reports and SPF ending in <code>~all</code>, and <code>example.com</code> (a documentation domain that sends no email) has SPF <code>-all</code> and DMARC at <code>reject</code>; a nonexistent domain gives the high findings. What the auditor <strong>cannot</strong> see from outside are 2FA, the registrant, the registry lock or the expiry date: those go in the inventory.</p>

<h2>The Excel inventory</h2>
<p>The workbook lists each domain with its registrar, the recovery email (and whose it is), the expiry date, auto-renewal, transfer lock, 2FA, DMARC status and the last DNS zone copy. It calculates days to expiry and a risk score (expires in 30 days or less 3 points; between 31 and 60 days 1; no auto-renewal 1; no lock 2; no 2FA 2; DMARC none or <code>none</code> 1; no zone copy 1) and flags "Crítico" (5 or more), "Atención" (3 or 4) or "Bien". In the example's four fictional domains, with a review date of October 10, 2026: one is "Crítico" (8 points: expires in 23 days, no auto-renewal or 2FA, DMARC at <code>none</code> and no zone copy), one is "Atención" (3 points: no transfer lock and no DMARC) and two are "Bien". The criteria are indicative: adjust them.</p>

<h2>A routine for this week</h2>
<ol>
<li><strong>List your domains</strong> (the institution's, projects' and "forgotten" ones) with the inventory.</li>
<li><strong>Log in to each registrar account</strong> and verify registrant, recovery email, 2FA, transfer lock, expiry and renewal.</li>
<li><strong>Run the auditor</strong> and fix the high findings first.</li>
<li><strong>Save a copy of the DNS zone</strong> (exported or as a screenshot) and note where it is.</li>
<li><strong>Define two owners</strong> and a calendar with reminders 90, 30 and 7 days before expiry.</li>
<li><strong>Review DMARC</strong> every quarter: if you have been at <code>none</code> for months, plan the move to <code>quarantine</code>.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, schools often manage their domain through a hosting provider, a computer science teacher or the education secretariat, and it is common for the registrant not to be the institution. In the region the pattern repeats: many institutional domains depend on one person. Worldwide, email spoofing and domain hijacking are problems recognized by email providers and cybersecurity agencies, which is why they recommend email authentication and account controls. For <strong>principals</strong>, the domain is an asset to be inventoried like any other; for <strong>technical staff</strong>, the goal is reducing the risk of depending on a single person; for <strong>teachers</strong>, knowing that an email "from the school" can be fake; and for <strong>families</strong>, trusting official channels and distrusting urgent messages asking for payment or data. (See also <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a> and <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">the cloud is not a backup</a>.)</p>

<h2>Tools and templates</h2>
<p>If you need to issue receipts or send documents by email from your business or institution, look at these templates, and remember that the email you send must come from a properly authenticated domain. For the teaching side, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> are the author's own tools for teachers.</p>
{{productos:factura-con-envio-por-correo-al-cliente,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">what to monitor in a web application</a>, <a href="/extensiones-del-navegador-riesgos-permisos-inventario-politica/">browser extensions</a> and <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">more platforms is not better</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What happens if my school's domain expires?</h3>
<p>The website and email stop working. Many registrars allow renewal during a period after expiry, and generic domains have a recovery period, but cost and deadlines depend on the registrar and domain type. The best thing is not to get there.</p>
<h3>What is a transfer lock?</h3>
<p>A status that prevents the domain from moving to another registrar until you turn it off. It protects against unauthorized transfers, but does not prevent DNS changes: that is why the account also needs 2FA.</p>
<h3>What is DMARC and why does it matter?</h3>
<p>A policy published in DNS that tells receivers what to do with emails that claim to come from your domain but fail SPF and DKIM. It makes spoofing you harder.</p>
<h3>Should I set DMARC straight to reject?</h3>
<p>Not without observing first: you could block legitimate email sent by services you forgot to authorize. Start at <code>none</code> with reports, review who sends and move up gradually.</p>
<h3>Does the auditor change anything on my domain?</h3>
<p>No. It only makes read queries to public DNS.</p>

<p class="notice"><strong>Take the first step today.</strong> Download the <a href="/descargas/proteger-dominio/inventario-dominios.xlsx">domain inventory</a> (in Spanish), list your institution's domains and check, for each, who the registrant is and when it expires. Then run the <a href="/descargas/proteger-dominio/auditor_dominio.py">auditor</a>.</p>

<h2>Food for thought</h2>
<p>Paying for a domain seems a small expense, but the digital identity of a whole community depends on it. <strong>Who really owns your institution's domain: the institution, a person or a vendor? And if that person resigned tomorrow, would anyone know how to regain access before something fails?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:capas}}' => $img('proteger-dominio-capas', 467, 'Five layers to protect a domain: registrar account with 2FA, domain with lock and renewal, DNS, email with SPF, DKIM and DMARC, and responsible people.', 'A domain is protected in layers.'),
    '{{img:registros}}' => $img('proteger-dominio-registros', 553, 'Table with five DNS records, what each protects and its warning sign: SPF, DKIM, DMARC, CAA and DNSSEC.', 'Records you can check today.'),
]);

return [
    'proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor' => [
        'slug' => 'protect-school-domain-registrar-dns-email-spf-dkim-dmarc-auditor',
        'title' => 'Protect the School Domain: Registrar, DNS and Email (SPF, DKIM, DMARC), with a Python Auditor',
        'excerpt' => 'Five layers so you do not lose your domain or have your email spoofed: registrar account, lock and renewal, DNS, SPF/DKIM/DMARC and people, with a Python auditor and an Excel inventory.',
        'seo_title' => 'Protect the School Domain: DNS, SPF and DMARC',
        'seo_description' => 'How to protect a school domain: registrar 2FA, lock, renewal, DNS, SPF, DKIM and DMARC, with a Python auditor and an Excel inventory.',
        'focus_keyword' => 'protect school domain',
        'cover' => '/assets/img/articulos/proteger-dominio/proteger-dominio-portada-en',
        'cover_alt' => 'Cover "Protect the school domain: registrar, DNS and email before something fails" with a card: 5 layers (account, domain, DNS, email and people); if one fails, the domain is at risk.',
        'content_html' => $html,
    ],
];
