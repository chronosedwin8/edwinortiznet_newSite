<?php

declare(strict_types=1);

// English version of «Altas y bajas de cuentas del colegio: cómo saber quién sigue entrando cuando ya …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/altas-bajas-cuentas/' . $name . '-en';
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
<p>A teacher left the school in November. In March, her institutional email is still active: someone logged in yesterday from another city. It was not her: it was whoever had her password, or guessed it, and now has access to an account that still carries the school's name and to the lists she used to receive. Nobody noticed because <strong>nobody had deactivated the account</strong>. There was no sophisticated attack: there was a door left open after the person left.</p>
<p>This article proposes controlling the <strong>life cycle of the school's accounts</strong> (creation, changes and removal) and periodically reviewing who has access to what. It includes an <a href="/descargas/altas-bajas-cuentas/control-altas-bajas-cuentas.xlsx">Excel workbook</a> (in Spanish) with 12 people and 24 fictional accounts, verified in Microsoft Excel 16 and against an independent calculation.</p>
<p class="notice"><strong>Scope.</strong> This is a basic framework, inspired by the NIST SP 800-53 account management control (AC-2) and general identity management practices, cited as reference, not as reproduction. The data are fictional; the deadlines (2 days for removal, 90 days of inactivity) are examples to adjust. Do not put real names, passwords or unnecessary personal data in the workbook: use codes. This is not legal or security advice, and personal data of teachers, students and families are protected in Colombia by Law 1581 of 2012, whose security principle requires protecting information from unauthorized access (check the current text).</p>

<h2>Why "orphan" accounts are a risk</h2>
<ul>
<li><strong>They have no real owner.</strong> The person no longer answers for them, but they keep receiving emails, access and data. Whoever has the password (the person, a former colleague it was shared with, an attacker) can use it.</li>
<li><strong>Nobody watches them.</strong> Odd activity on the account of someone who no longer works here alarms no one, because there is no attentive user to notice something is off.</li>
<li><strong>Privileged accounts multiply the damage.</strong> An administrator of the financial system or academic platform who stays active after leaving can see or change far more than an ordinary user.</li>
<li><strong>Inactive accounts of active people</strong> are also a risk: they are not used, nobody notices them and they often keep old passwords.</li>
</ul>

{{img:ciclo}}
<h2>The life cycle: create, change, remove and review</h2>
<ol>
<li><strong>Create:</strong> only the accounts and permissions the role needs are created (the <em>least privilege</em> principle), with a recorded request approved by the right person.</li>
<li><strong>Change:</strong> when a person changes role or area, access is adjusted: what they no longer need is removed, not just new access added. This is where permissions accumulate most.</li>
<li><strong>Remove:</strong> on the leaving day (or earlier, if the departure is contentious) accounts are deactivated, equipment is recovered and data the school needs to keep is transferred. Ideally, removal is triggered from HR, not from someone in systems remembering.</li>
<li><strong>Periodic review:</strong> every quarter, the list of accounts is compared with payroll and current contractors, and privileged and inactive accounts are reviewed.</li>
</ol>
<p>The common thread is a single source of truth on who works at the school (payroll or the staff list) and a person or team responsible for each removal (see <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">the help desk</a> to record requests and <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">the technology inventory</a> to recover equipment).</p>

<h2>The Excel workbook</h2>
<ul>
<li><strong>Parametros:</strong> the review date (enter today's; <code>TODAY()</code> is not used so the result is reproducible), the maximum removal deadline after leaving and the days without a session to mark an account inactive.</li>
<li><strong>Personas:</strong> twelve people with their role, status (active or retired/left) and leaving date, with codes instead of names.</li>
<li><strong>Cuentas:</strong> 24 accounts with person, system, level (user or administrator), last session and removal date. It calculates the person's status, the days and an <strong>alert</strong>: <em>Crítica</em> (administrator active after leaving), <em>Activa tras el retiro</em> (active after leaving), <em>Baja tardía</em> (late removal), <em>Baja a tiempo</em> (on-time removal), <em>Inactiva</em> (inactive) or <em>Vigente</em> (current), shown in the workbook in Spanish.</li>
<li><strong>Resumen:</strong> the key counts.</li>
</ul>
<pre><code>' Alert for an account (G = person's status, F = removal date, I = days, D = level)
=IF(G2="Retirado",IF(F2="",IF(D2="Administrador","Crítica: administrador activo tras el retiro","Activa tras el retiro"),IF(I2>Parametros!$B$4,"Baja tardía","Baja a tiempo")),IF(F2<>"","Baja con la persona activa",IF(I2>Parametros!$B$5,"Inactiva","Vigente")))   ' English
=SI(G2="Retirado";SI(F2="";SI(D2="Administrador";"Crítica: administrador activo tras el retiro";"Activa tras el retiro");SI(I2>Parametros!$B$4;"Baja tardía";"Baja a tiempo"));SI(F2<>"";"Baja con la persona activa";SI(I2>Parametros!$B$5;"Inactiva";"Vigente")))   ' Spanish

' Days: since leaving (if not removed), between leaving and removal, or since the last session
=IF(G2="Retirado",IF(F2="",Parametros!$B$3-H2,F2-H2),Parametros!$B$3-E2)   ' English</code></pre>

<h2>What the example showed (fictional data)</h2>
{{img:dias}}
<p>With a review date of March 1, 2027, 24 accounts and 12 people (5 who had left):</p>
<ul>
<li><strong>Of 11 accounts of people who had left, 5 were still active (45%)</strong>, belonging to 4 of the 5 people who left. The oldest had been <strong>open for 91 days</strong> after leaving (an email and a virtual classroom of a teacher who left on November 30) and another for 81 days (a platform account of a contractor).</li>
<li><strong>One was critical:</strong> administrator access to the financial system of a person who left on January 15 and had been active for <strong>45 days</strong>.</li>
<li><strong>Removals happen, but late:</strong> of 6 accounts removed, 4 were done on time (within 2 days) and 2 late, by 15 and 77 days.</li>
<li><strong>3 inactive accounts of active people</strong> (147, 106 and 181 days without a session), including a <strong>platform administrator</strong> account of a contractor, unused for almost six months.</li>
<li><strong>10 current accounts</strong> (42%), with recent sessions by active people.</li>
</ul>
<p><strong>An honest reading:</strong> the workbook only detects what is recorded: an account not on the sheet is not reviewed, and neither is a person not on the staff list. Nor does it prove the account was misused; it shows an open door. And "last session" depends on the system recording it properly. That is why ideally each system can export its user list, to compare it with payroll.</p>

<h2>Good practices for the school</h2>
<ol>
<li><strong>A single staff list</strong> (teachers, administrative staff, contractors, interns) with start and leaving dates, and someone responsible for maintaining it.</li>
<li><strong>Personal accounts, not shared ones.</strong> If several people use the same account, you cannot know who did what or remove access for just one.</li>
<li><strong>Two-step verification</strong> (in systems that offer it) on email and administration accounts (see <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">protecting the school's domain</a> and <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>).</li>
<li><strong>Minimum, reviewed privileges:</strong> few administrators, with their own names, reviewed every quarter.</li>
<li><strong>A written removal procedure,</strong> with a checklist (accounts, equipment, keys, data to transfer) and a deadline (for example, the leaving day). Publish it in the knowledge base (see <a href="/base-de-conocimiento-colegio-articulos-responsable-fecha-revision-excel/">the knowledge base</a>).</li>
<li><strong>Mind agents and automations:</strong> service accounts and AI tool keys must also be removed (see <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to systems</a>).</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Identity life cycle management (<em>joiner, mover, leaver</em>) is a basic control in information security frameworks, such as the ISO/IEC 27001 family and NIST SP 800-53, and one of the most common audit failures: accounts of people who are no longer there almost always turn up. In Colombia, Law 1581 of 2012 requires those who process personal data to apply security measures, and access left open after someone leaves is hard to justify in an incident. In Latin America and elsewhere, schools with little technical staff depend on the HR procedure more than on costly tools, and it works when HR and systems work together.</p>
<p>For <strong>teachers</strong>, handing over access when leaving is part of an orderly exit; for <strong>principals</strong>, it is a cheap measure that reduces risk and avoids surprises; for <strong>families</strong>, it protects their children's data; and for <strong>those leaving</strong>, it is best for everyone that their access is closed on time and what is needed is transferred, with respect and without suspicion.</p>

<h2>Tools and templates</h2>
<p>If you work with the site's Excel templates and want support, or prepare material with AI (always reviewing what it produces and without including personal data or credentials in tools not designed to safeguard them), take a look at these products.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: the <a href="/descargas/altas-bajas-cuentas/control-altas-bajas-cuentas.xlsx">account onboarding and offboarding workbook</a>, <a href="/plan-continuidad-operativa-colegio-analisis-impacto-rto-rpo-excel/">the operational continuity plan</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Frequently asked questions</h2>
<h3>What is account offboarding?</h3>
<p>Deactivating or deleting the accounts and permissions of a person who leaves or no longer needs access, and recovering or transferring what the school needs.</p>
<h3>When should I deactivate a departing teacher's accounts?</h3>
<p>On the leaving day or earlier, depending on the case. The workbook uses 2 days as an example deadline; set your own.</p>
<h3>Delete or deactivate the account?</h3>
<p>Deactivate first (to keep the email and data the school must retain), and delete when the retention period ends and what is needed has been transferred.</p>
<h3>What is least privilege?</h3>
<p>Giving each person only the access they need for their job, and reviewing it when they change roles.</p>
<h3>How do I use the workbook?</h3>
<p>Enter the review date, the list of people with their status, and the accounts of each system (with last session and removal date); the workbook flags alerts and calculates the summary.</p>

<p class="notice"><strong>Review your accounts this week.</strong> Download the <a href="/descargas/altas-bajas-cuentas/control-altas-bajas-cuentas.xlsx">account onboarding and offboarding workbook</a> (in Spanish), replace the fictional data with an export from your systems and look first at critical and active-after-leaving accounts.</p>

<h2>Food for thought</h2>
<p>Closing the access of someone who leaves can feel like distrust, when it is really a form of care: for other people's data and for the person themself, who should not answer for what someone does with an account they no longer use. <strong>What would an orderly exit look like at your school, where the person hands over their access and the school closes it respectfully? And who would have to tell whom, and when, so that no door stays open?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ciclo}}' => $img('altas-bajas-cuentas-ciclo', 499, 'Table with four moments in an account life cycle, what is done and who answers: create, change, remove and review.', 'The life cycle of an account.'),
    '{{img:dias}}' => $img('altas-bajas-cuentas-dias', 480, 'Bar chart of the days five accounts stayed active after the person left: 91, 91, 81, 45 and 9.', 'Days five accounts stayed active after leaving.'),
]);

return [
    'altas-y-bajas-de-cuentas-colegio-retiro-docentes-accesos-excel-auditor' => [
        'slug' => 'account-onboarding-offboarding-school-staff-leaving-access-excel-audit',
        'title' => 'School Account Onboarding and Offboarding: How to Know Who Still Logs In After Leaving, with an Excel Workbook',
        'excerpt' => 'The life cycle of a school\'s accounts (create, change, remove and review), why orphan accounts are a risk and how to detect them with an Excel workbook that crosses people, accounts and leaving dates.',
        'seo_title' => 'School Account Offboarding: Control in Excel',
        'seo_description' => 'How to control account onboarding and offboarding at school: life cycle, accounts active after leaving, privileges and a verified Excel workbook.',
        'focus_keyword' => 'account offboarding at school',
        'cover' => '/assets/img/articulos/altas-bajas-cuentas/altas-bajas-cuentas-portada-en',
        'cover_alt' => 'Cover "Account onboarding and offboarding: who still logs in after leaving the school" with a card: 5 of 11 accounts of people who had left were still active, one of them with an administrator role.',
        'content_html' => $html,
    ],
];
