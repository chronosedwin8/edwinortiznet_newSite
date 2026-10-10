<?php

declare(strict_types=1);

// English version of "Siete preguntas antes de pegar datos en una IA gratuita (y una matriz para decid…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/datos-en-ia-gratuita/' . $name . '-en';
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
<p>It is Monday, twenty reports for families must be written and a free AI tool promises to do it in minutes. The temptation is to paste the notes as they are: the student's name, grades, the diagnosis the family reported. It is quick, it works and nobody finds out. <strong>But what you paste into a free tool is no longer under your control</strong>: it may be stored, reviewed by people or used to train models, depending on the tool and its settings.</p>
<p>This article proposes <strong>seven questions</strong> to ask yourself before pasting data into a free AI tool, a <a href="/descargas/datos-en-ia/matriz-siete-preguntas-datos-en-ia.xlsx">downloadable Excel matrix</a> (in Spanish) that combines the data type with the tool type, and a <a href="/descargas/datos-en-ia/anonimizar_texto.py">Python script</a> that helps remove identifiable data, with its limits. Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> Before pasting data into a free AI tool ask: what data it is, whether you can anonymize it, whether the tool uses your conversations or people review them, where and for how long they are kept, what type of account you use, whether you have authorization and what would happen if they leaked. If you cannot answer question 1 or lack authorization (question 6), <strong>do not paste the data</strong>. Minors' data and sensitive data must not go into free tools with a personal account. This is a general guide, not legal advice.</p>

<h2>What can happen to what you paste</h2>
<p>Each tool has its own rules, which change over time; that is why it pays to read them, and the principle is always the same: <strong>do not assume what you have not verified</strong>. Two examples of what has been documented:</p>
<ul>
<li><strong>Use to train the model.</strong> In ChatGPT, according to OpenAI's help center, there is a setting ("Improve the model for everyone") which, when off, keeps your new conversations from being used to train its models; history remains. The available controls depend on whether you are signed in, your plan and workspace settings, and I could not confirm from the sources consulted what the default is for free users: <strong>check it in your own account</strong>.</li>
<li><strong>Human review and retention.</strong> According to coverage of Gemini's privacy policy (I could not access Google's original page), conversations that people review, together with associated data such as language, device type and location, <strong>are not deleted when you delete your activity</strong> but are kept for up to three years; turning activity off keeps future chats from being reviewed, but Google still holds them for about 72 hours. Verify the current details on the official page.</li>
</ul>
<p>And a well-known case: in April 2023, Samsung engineers uploaded internal code to ChatGPT; according to the press, the company then banned the use of generative AI on its devices and networks for fear that data would end up on external servers, hard to retrieve and delete. If it happened to a multinational with its own rules, it can happen to a school or a small business.</p>

<h2>The seven questions</h2>
{{img:preguntas}}
<ol>
<li><strong>Do I know exactly what data I will paste?</strong> Make the list: names, IDs, emails, grades, diagnoses, photos, attached files (an Excel sheet can carry hidden columns).</li>
<li><strong>Is it anonymized or not needed?</strong> Almost always you can ask the same thing with invented data or placeholders like [STUDENT 1].</li>
<li><strong>Does it use my conversations to train or do people review them? Did I turn it off?</strong> Look at the data settings and the privacy policy.</li>
<li><strong>Where and for how long is it kept? Can I delete it?</strong> Deleting the history may not delete everything (see the Gemini case).</li>
<li><strong>Is it an institutional account with organization terms or a free personal account?</strong> Terms for organizations are usually different; review them, do not assume.</li>
<li><strong>Do I have authorization?</strong> From the institution and, if minors' data is involved, from families or their representatives.</li>
<li><strong>If this data leaked, what would happen?</strong> Think of the worst case for the people, not for you.</li>
</ol>
<p>The "Siete_preguntas" sheet lets you assess up to three tools, counts the "Yes" answers and gives a verdict: <em>"Not sure" counts as "No"</em> and, if question 1 or 6 is "No", the verdict is "No pegues estos datos" (do not paste this data) regardless of the score (I tested several scenarios: with all seven "Yes" it says "Puedes continuar"; with six and no authorization, "No pegues estos datos").</p>

<h2>The matrix: data type by tool type</h2>
{{img:matriz}}
<p>Not every data type goes into every tool. The workbook's matrix combines four data types (public, internal non-personal, personal, sensitive or minors') with three tool types (free with a personal account, institutional account with organization terms and local or private model) and gives one of three answers: <strong>Allowed</strong>, <strong>Conditional</strong> or <strong>No</strong>. A calculator resolves it and lowers the risk level if the data is truly anonymized. For example, personal data in a free tool with a personal account gives "No"; the same data in an institutional account gives "Conditional": only with a policy, authorization, a defined purpose and human review. "Conditional" does not mean free.</p>
<p>The legal framework matters: Colombia's Law 1581 of 2012 regulates the processing of personal data and restricts that of children and adolescents, and the Superintendence of Industry and Commerce has issued instructions on processing personal data in artificial intelligence systems (see <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">student data and AI personalization</a>). If your institution has an AI policy, apply it; if not, it is a good time to create one (see the <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">institutional AI policy for schools</a>).</p>

<h2>Really anonymizing: an example and its limits</h2>
<p>I wrote a script of about 40 lines in Python (standard library only) that replaces emails, phone numbers, ID numbers, dates and the names you indicate. I tested it with a fictional text:</p>
<pre><code>Estudiante: Valentina Rojas Pérez, documento 1.234.567.890, nació el 14/03/2012.
Acudiente: Marta Pérez (celular 311 456 7890, correo marta.perez@correo.com).
Observación del docente: Valentina presenta dificultades de atención y su familia
reporta un diagnóstico reciente.</code></pre>
<p>Result:</p>
<pre><code>Estudiante: [PERSONA], documento [DOCUMENTO], nació el [FECHA].
Acudiente: [PERSONA] (celular [TELEFONO], correo [CORREO]).
Observación del docente: [PERSONA] presenta dificultades de atención y su familia
reporta un diagnóstico reciente.</code></pre>
<p>It worked on the mechanical parts, but notice what it did <strong>not</strong> do: the last line still says that the person (now "[PERSONA]") has attention difficulties and a recent diagnosis. That is <strong>sensitive data</strong> about a girl whose grade, age or context could be enough to identify her; changing the name does not anonymize it. That is why the script is a help, not a guarantee: <strong>it does not detect addresses, nicknames or combinations of "innocent" data that together identify someone</strong>, and the result must always be checked by hand. And if the data is sensitive, the best anonymization is not pasting it: describe it in general ("a student with attention difficulties") or write that part yourself.</p>
<p>A safer technique: <strong>ask the AI for the template, not the case</strong>. "Write a report for the family with these sections: progress, difficulties, recommendations", and fill in the real data yourself outside the tool.</p>

<h2>What to do instead of pasting</h2>
<ul>
<li><strong>Use invented data</strong> that keeps the structure of the case.</li>
<li><strong>Ask for templates or rubrics</strong> and complete them outside the tool.</li>
<li><strong>Use tools designed for the data.</strong> If you work with sensitive documents such as a PIAR, a specific tool with controlled access is better than a generic free AI (see <a href="/herramientas/piar/">PIAR con IA</a>).</li>
<li><strong>Ask your institution</strong> whether there is an account with organization terms.</li>
<li><strong>Document</strong>: what was used, for what and with what data (see the AI-use log in the programming rubric in <a href="/ensenar-programacion-era-ia-que-sigue-importando-rubrica-depuracion/">teaching programming in the age of AI</a>).</li>
</ul>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, several companies and governments have restricted free AI tools over confidentiality risks, and data protection authorities have begun to speak out. In Colombia and Latin America, use is massive and institutional rules arrive late: according to the OECD (TALIS 2024), about 53% of Colombian teachers used AI in the past year. For <strong>teachers</strong>, the risk is practical: the temptation of the shortcut with real data; for <strong>principals</strong>, offering a safe alternative and a policy; for <strong>families</strong>, knowing that their children's data should not end up in free personal accounts; and for <strong>students</strong>, learning early to take care of their own information (see <a href="/riesgo-oculto-excel-auditoria-control-versiones/">data controls in Excel</a> for a similar example of care).</p>

<h2>Tools designed for data care</h2>
<p>The <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> is designed so you write the context and the topic, not student data; <a href="/herramientas/piar/">PIAR con IA</a> keeps sensitive documents in an account with controlled access and the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> offers recipes by subject that work without personal data.</p>
{{productos:kit-de-ia-para-docentes,piar-con-ia-5-planes}}
<p>Keep reading: <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a>, <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: the first 60 minutes</a> and <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Is it safe to paste student data into ChatGPT or another free AI?</h3>
<p>Not as a rule. Minors' data and sensitive data must not go into free tools with a personal account; anonymize, use invented data or a tool authorized by your institution.</p>
<h3>Does deleting the history delete my data?</h3>
<p>Not necessarily. According to coverage of Gemini's policy, conversations reviewed by people are kept for up to three years even if you delete your activity. Read each tool's policy.</p>
<h3>How do I turn off the use of my chats for training?</h3>
<p>It depends on the tool. In ChatGPT, under Settings, Data controls, there is a setting to stop using your new conversations for training; check yours.</p>
<h3>Is anonymizing by changing the name enough?</h3>
<p>No. Sensitive data or a combination of data can identify a person even if you change their name. Check by hand and, if it is sensitive, do not paste it.</p>
<h3>What law applies in Colombia?</h3>
<p>Law 1581 of 2012 on personal data protection, with special rules for children's and adolescents' data, and the instructions of the Superintendence of Industry and Commerce. Consult your legal adviser on what applies to your case.</p>

<p class="notice"><strong>Before the next report.</strong> Download the <a href="/descargas/datos-en-ia/matriz-siete-preguntas-datos-en-ia.xlsx">seven-questions matrix</a> (in Spanish), assess the tool you use most and review the "Que_quitar" sheet. If you work with text, try the <a href="/descargas/datos-en-ia/anonimizar_texto.py">anonymization script</a> with the <a href="/descargas/datos-en-ia/ejemplo_texto.txt">sample text</a>, remembering that it does not replace your judgment.</p>

<h2>Food for thought</h2>
<p>Free tools are not free: they are paid for with attention or with data. <strong>Is it acceptable for teaching work, already overloaded, to depend on tools that force a choice between saving time and protecting students' data? And who should bear the cost of offering safe alternatives: each teacher, each school or the State?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:preguntas}}' => $img('datos-en-ia-gratuita-preguntas', 467, 'Seven control questions before pasting data into an AI: data, anonymize, use of chats, retention, account type, authorization and impact.', 'A checklist before pasting data.'),
    '{{img:matriz}}' => $img('datos-en-ia-gratuita-matriz', 499, 'Table of data type against tool: public allowed in both, internal non-personal conditional in the free tool and allowed in the institutional one, personal and sensitive not in the free tool and conditional in the institutional one.', 'Not every data type goes into every tool.'),
]);

return [
    'siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz' => [
        'slug' => 'seven-questions-before-pasting-data-into-a-free-ai-tool-matrix',
        'title' => 'Seven Questions Before Pasting Data Into a Free AI Tool (and a Matrix to Decide What You Can Paste)',
        'excerpt' => 'What can happen to what you paste into a free AI tool, seven control questions, a data-type by tool-type matrix in Excel and a tested anonymization script, with its limits.',
        'seo_title' => 'Data in a Free AI Tool: Seven Questions Before Pasting',
        'seo_description' => 'Seven questions and a matrix to decide what data to paste into a free AI tool, with a tested anonymization script, its limits and Colombia\'s Law 1581.',
        'focus_keyword' => 'privacy free AI tools student data',
        'cover' => '/assets/img/articulos/datos-en-ia-gratuita/datos-en-ia-gratuita-portada-en',
        'cover_alt' => 'Cover "Seven questions before pasting data into a free AI tool" with a card of four of the questions: what data will I paste, can I remove it, do they use my chats for training and do I have authorization.',
        'content_html' => $html,
    ],
];
