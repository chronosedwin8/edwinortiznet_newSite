<?php

declare(strict_types=1);

// English version of «¿Hasta dónde puede llegar un colegio al recopilar datos de sus estudiantes para personalizar el aprendizaje con IA?». Key is the
// Spanish slug. Sources checked on October 9, 2026 (Colombia Law 1581 of 2012, Decree 1074 of 2015, SIC External Circular 002 of 2024, EU Regulation
// 2024/1689, PowerSchool breach). Not legal advice. Status and date come from the Spanish post via en/02_recent_posts.php (scheduled for Wednesday,
// October 28, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/datos-estudiantes-ia-privacidad/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>The promise sounds irresistible: a platform that knows how each student learns, which mistakes they repeat, how long each exercise takes and what they should study tomorrow. To achieve it, it needs data: grades, attendance, timings, errors, sometimes behavior, sometimes voice or face. <strong>The question is no longer just whether AI personalizes, but how much of children's data we are willing to hand over in exchange.</strong></p>
<p>In this article I review which data are handled, what Colombian law and international regulation say, what happened in one of the largest school data incidents, and give you <strong>ten criteria</strong> to use educational data responsibly, useful for teachers, school leaders and families. Rules and cases checked on October 9, 2026. This is guidance, not legal advice.</p>
<p class="notice"><strong>Summary.</strong> In Colombia, Law 1581 of 2012 restricts the processing of minors' data to public data and requires their best interests to prevail; SIC External Circular 002 of 2024 asks AI systems to meet suitability, necessity, reasonableness and proportionality, with a prior impact assessment. The practical rule: collect less data, with a clear purpose, with human oversight and with a provider you can audit.</p>

<h2>Which data are collected and which are sensitive</h2>
<p>Not all of a student's data weigh the same. This practical classification helps decide how much care each type deserves:</p>
{{img:datos}}
<p>One category deserves a warning: <strong>inferences</strong>. When an AI calculates that a student "is at risk of dropping out", "is unmotivated" or "has a visual learning style", it creates new data about the child that can be wrong and that, once in a profile, tends to follow them. And health, disability or diagnosis data (for example, from a support plan) are sensitive: they should not reach an external tool with first and last names.</p>

<h2>A real case: the PowerSchool breach</h2>
<p>At the end of 2024, the US platform PowerSchool, which manages student information in thousands of schools, suffered unauthorized access. According to <a href="https://www.tomsguide.com/computing/online-security/powerschool-cyberattack-may-have-compromised-the-data-of-more-than-70-million-students-and-teachers-what-to-do-now">Tom's Guide's summary</a> based on BleepingComputer, the data of about 62.4 million students and 9.5 million teachers were affected, and the intrusion used a contractor's credentials, not a ransomware attack or a software flaw. What was exposed depended on each district: names, addresses, phone numbers, grade point averages, parent information and, in some cases, medical data. Figures vary by source and some details (for example, the exposure of Social Security numbers) conflict between reports. The lesson is simple: <strong>the more data a provider concentrates, the more attractive and damaging an incident is</strong>, and a school's security also depends on its contractors' credentials.</p>

<h2>What the law says: Colombia, Latin America and the world</h2>
<p><strong>In Colombia</strong> several rules combine. Article 7 of <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=49981">Law 1581 of 2012</a> establishes that in processing the data of children and adolescents their rights must prevail and that processing their data is prohibited, except for data of a public nature; it also assigns educational institutions the duty to inform and train legal representatives and guardians about the risks of misuse. The Constitutional Court (Ruling C-748 of 2011) clarified that it is not an absolute ban: there can be processing when it respects the minor's best interests. Decree 1074 of 2015 (which compiled Decree 1377 of 2013) also requires that respect for their fundamental rights be ensured and that the legal representative authorize, after hearing the minor's opinion according to their maturity. A school acts as the data controller.</p>
<p>For AI, <a href="https://sedeelectronica.sic.gov.co/sites/default/files/normativa/Circular%20Externa%20No.%20002%20del%2021%20de%20agosto%20de%202024.pdf">SIC External Circular 002 of 2024</a> applies Law 1581 to data processing in artificial intelligence systems: it demands suitability, necessity, reasonableness and proportionality, risk management, <strong>a privacy impact study before design and development</strong> and the ability to demonstrate compliance (demonstrated accountability). According to commentators, it also promotes privacy by design and by default.</p>
<p><strong>Worldwide</strong>, the European Union went further: its AI Act has banned inferring people's emotions in educational institutions since February 2025 (except for medical or safety reasons) and classifies as high-risk the AI systems that determine access to educational institutions, evaluate learning outcomes or monitor behavior during exams; the timeline for high-risk obligations has been adjusted, so verify the current date. <strong>In Latin America</strong>, data protection laws vary in maturity, but the trend is the same: processing minors' data demands more care, and the region's schools and platforms often operate with global providers without families or teachers knowing where the data live. That information asymmetry is part of the problem.</p>

<h2>Ten criteria for responsible use of educational data</h2>
<p>This is the practical resource. Use it to evaluate a platform or an institutional policy:</p>
<table>
<thead><tr><th>Criterion</th><th>Key question</th><th>Warning sign</th></tr></thead>
<tbody>
<tr><td><strong>1. Purpose</strong></td><td>Which specific pedagogical decision does this data improve?</td><td>"In case it is useful later".</td></tr>
<tr><td><strong>2. Necessity (minimization)</strong></td><td>Can the same be achieved with less data or anonymized data?</td><td>They ask for more data than needed.</td></tr>
<tr><td><strong>3. Proportionality</strong></td><td>Does the benefit justify the risk to a minor?</td><td>Biometric or emotional data for simple tasks.</td></tr>
<tr><td><strong>4. Authorization and information</strong></td><td>Do families understand which data, what for and who sees them? Was the student heard according to maturity?</td><td>A generic consent buried in enrollment.</td></tr>
<tr><td><strong>5. Human oversight</strong></td><td>Does a teacher review before a profile or alert affects the student?</td><td>Automatic decisions on grades, groups or sanctions.</td></tr>
<tr><td><strong>6. Provider and contract</strong></td><td>Where is the data stored, who accesses it and is it used to train models?</td><td>Clauses allowing reuse of the data.</td></tr>
<tr><td><strong>7. Security</strong></td><td>Are there access controls, encryption, access logs and MFA, including for contractors?</td><td>Shared accounts without a second factor.</td></tr>
<tr><td><strong>8. Retention and deletion</strong></td><td>How long is it kept and how is it erased?</td><td>No time limit or deletion procedure.</td></tr>
<tr><td><strong>9. Rights and channels</strong></td><td>Can families consult, correct and request deletion of the data?</td><td>No channel or visible person in charge.</td></tr>
<tr><td><strong>10. Impact assessment and incidents</strong></td><td>Was an impact study done before using it and is there a plan for a breach?</td><td>"Nothing has ever happened to us".</td></tr>
</tbody>
</table>
<p>And a three-question test that fits in any academic council meeting: <strong>1) Which pedagogical decision does it improve? 2) Could it be achieved with less data? 3) What happens if it leaks or gets it wrong?</strong> If there is no good answer to all three, the data probably should not be collected.</p>

<h2>Four viewpoints: teachers, families, students and providers</h2>
<ul>
<li><strong>Teachers:</strong> they want tools that save time, but they are the ones who upload the data and answer to families. They need clear rules on what they can and cannot upload to an AI platform.</li>
<li><strong>Families:</strong> they almost never know which platforms the school uses or what data they hand over. They have the right to ask and to get an understandable answer.</li>
<li><strong>Students:</strong> they have the right to be heard and not to carry labels an algorithm gave them at 12.</li>
<li><strong>Providers:</strong> a good provider can explain which data it collects, why, where it stores them and how they are erased. If it cannot, that is a signal.</li>
</ul>

<h2>How I apply it in my tools</h2>
<p>I apply what I recommend: in <a href="/herramientas/piar/">PIAR con IA</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>, what you type is sent to the Google Gemini API to generate the document, which is why I recommend using <strong>initials and not including data that identifies students</strong>; the site's <a href="/privacidad/">privacy policy</a> explains it. The support plan handles sensitive information (disability, supports), so that precaution is not a detail: it is the rule. If you want to work on a reasonable-accommodations plan without exposing a student, start with the <a href="/producto/piar-con-ia-5-planes/">PIAR con IA package</a> using minimal data, and to assess without collecting profiles, the <a href="/producto/generador-de-examenes-ia-esencial/">AI Exam Generator</a> creates exams and solutions without needing students' personal data (there is a <a href="/examenes/demo/">free demo</a>). The <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a> includes a digital citizenship sequence (footprint, privacy and personal data) to work on this topic with your students.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}
<p>To keep reading: <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>, <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a> and <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">whether AI expands student thinking or replaces it</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Can a school use student data on an AI platform?</h3>
<p>It can, if it complies with Law 1581 of 2012: a legitimate purpose, information and authorization from legal representatives, prevalence of the minor's best interests, security measures and, for AI, the guidelines of SIC Circular 002 of 2024. Some data are better not shared with an external provider.</p>
<h3>What is sensitive data and why does it matter?</h3>
<p>It is data that affects privacy or whose misuse can generate discrimination (health, biometric data, racial origin, among others). Its processing requires stricter conditions. In a school, disability data, diagnoses and supports are the clearest example.</p>
<h3>What happens if a school platform suffers a breach?</h3>
<p>The controller must report the incident under SIC rules (several firms indicate a 15-business-day deadline from detection; confirm the current text) and inform those affected. That is why a response plan is needed before it happens.</p>
<h3>Can learning be personalized without collecting so much data?</h3>
<p>Yes. Many useful personalizations (exercises at different levels, feedback, reinforcement paths) work with minimal or anonymized data. More data does not always mean better learning.</p>
<h3>What do I ask the school as a parent?</h3>
<p>Which platforms they use, which data of my child they collect, what for, who has access, where it is stored, for how long and how I can correct it or ask for it to be deleted.</p>

<p class="notice"><strong>Review your policy this week.</strong> Apply the ten criteria to a platform you use at your school and ask: do we have a written privacy and AI-use policy? If not, propose one at the academic council. And if you work with reasonable-accommodation plans, protect the data with <a href="/producto/piar-con-ia-5-planes/">PIAR con IA</a> using initials.</p>

<h2>Food for thought</h2>
<p>A child cannot decide whether they want the school to keep every mistake they make on a platform that will accompany them for years. <strong>If personalization requires closely watching students, does the learning we gain justify the privacy we take away, and who should have the last word: the school, families or the students themselves when they grow up and read their file?</strong></p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('datos-estudiantes-ia-privacidad-datos', 553, 'Table of educational data by sensitivity: name and grade medium, grades and attendance medium-high, behavior and profiles high, health and disability very high and emotions, voice and face very high, with the rule of thumb for each.', 'Educational data: sensitivity and rule of thumb.'),
    '{{img:normas}}' => $img('datos-estudiantes-ia-privacidad-normas', 573, 'Four cards: 62.4 million students affected in the PowerSchool breach, Article 7 of Law 1581 on minors\' data, SIC Circular 002 of 2024 and Article 5(1)(f) of the EU AI Act on inferring emotions in educational institutions.', 'A case and the rules.'),
]);

return [
    'colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad' => [
        'slug' => 'how-far-can-schools-go-collecting-student-data-ai-personalization',
        'title' => 'How Far Can a School Go in Collecting Student Data to Personalize Learning With AI?',
        'excerpt' => 'Which student data are collected, what Law 1581 and SIC Circular 002 of 2024 say, the PowerSchool case and ten criteria for responsible use of educational data.',
        'seo_title' => 'Student Data and AI: How Far Can a School Go?',
        'seo_description' => 'Student data privacy in educational AI: what the law says in Colombia, a real case and ten criteria for responsible use in schools.',
        'focus_keyword' => 'student data privacy AI',
        'cover' => '/assets/img/articulos/datos-estudiantes-ia-privacidad/datos-estudiantes-ia-privacidad-portada-en',
        'cover_alt' => 'Cover reading "How far can a school go collecting student data to personalize with AI?" with a list: academic data with a clear purpose and health with maximum protection ticked, and emotions and profiles without human review crossed out.',
        'content_html' => $html,
    ],
];
