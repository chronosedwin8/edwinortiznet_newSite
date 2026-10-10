<?php

declare(strict_types=1);

// English version of "Accesibilidad web: formularios, contraste y teclado que todas las personas pueda…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/accesibilidad-web/' . $name . '-en';
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
<p>A school opens enrollment for workshops with an online form. A mother with low vision cannot read the fields, which are light gray on white; a father who uses a screen reader hears "text field, text field" without knowing what is being asked; a student with a hand injury cannot use the mouse and the "Submit" button cannot be reached with the keyboard. Nobody meant to exclude them: they were simply not thought of.</p>
<p>Web accessibility is not an adornment for a few: <strong>it benefits everyone</strong> (someone using a phone in the sun, someone on a slow connection, someone who hurt an arm) and, in many cases, it is a legal obligation. This article explains the three fronts that fail most (forms, contrast and keyboard), with verified data, code from a bad and a good example, a <a href="/descargas/accesibilidad-web/revisar_accesibilidad_basica.py">Python script that detects common problems</a> and an <a href="/descargas/accesibilidad-web/lista-accesibilidad-web.xlsx">Excel checklist</a> (in Spanish). Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> The most frequent accessibility failures are simple to fix: <strong>low contrast, images without alternative text, fields without a label and empty links</strong> (WebAIM Million 2025). An accessible form has visible labels, works with the keyboard alone, communicates errors in text and has a contrast of at least 4.5:1. An automated check helps, but it does not prove a page is accessible: you have to test it with the keyboard, with zoom and, if possible, with a screen reader.</p>

<h2>What the data and the law say</h2>
<p>The WebAIM Million 2025 study analyzed one million home pages with an automated tool (WAVE). It found that <strong>79.1%</strong> had text with insufficient contrast, <strong>55.5%</strong> images without alternative text, <strong>48.2%</strong> form fields without a label and <strong>45.4%</strong> empty links; those categories (plus empty buttons and missing language) account for 96% of detected errors, and they have been practically the same for about five years. According to coverage of the report, close to 95% of pages had some detectable WCAG failure. And a warning from the study itself: <strong>a page with no detected errors is not necessarily accessible</strong>, because automated tools find only part of the problems.</p>
{{img:webaim}}
<p>The international reference framework is the W3C's <strong>Web Content Accessibility Guidelines (WCAG)</strong>, now in version 2.2, organized in levels A, AA and AAA. In Colombia, according to reports from entities that cite it (I could not access the annex's official text), the MinTIC's Resolution 1519 of 2020 requires obligated subjects, mainly public entities, to meet WCAG 2.1 level AA on their portals since January 1, 2022, and internal-control audits verify 32 criteria of its Annex 1. Colombia also approved the Convention on the Rights of Persons with Disabilities through Law 1346 of 2009. A private school or small business may not be bound by that resolution, but the logic is the same: <strong>if the service is not accessible, some people cannot use it</strong>. Confirm with your legal adviser what applies to you.</p>

<h2>Front 1: forms</h2>
<p>Forms are where people are lost the most, because that is where something is asked of them. These rules solve most cases:</p>
<ul>
<li><strong>A visible label associated with every field</strong> (<code>&lt;label for="..."&gt;</code>). A <em>placeholder</em> does not replace it: it disappears when typing and many screen readers do not announce it well. A quick test: click the label; the field should get focus.</li>
<li><strong>Mark required fields</strong> in text (not just with a red asterisk) and use <code>required</code>.</li>
<li><strong>Autocomplete</strong> (<code>autocomplete="name"</code>, <code>"email"</code>): it helps those who type with difficulty.</li>
<li><strong>Errors in clear text</strong> saying which field failed and how to fix it, not just a red border (color alone is not enough).</li>
<li><strong>A real button</strong> (<code>&lt;button&gt;</code>), not a <code>&lt;div&gt;</code> with a click handler.</li>
</ul>
<p>A bad example and a good one:</p>
<pre><code><input type="text" name="nombre" placeholder="Nombre">
<input type="email" name="correo" placeholder="Correo">
<a href="reglamento.pdf">Haz clic aquí</a>
<div onclick="enviar()" tabindex="3">Enviar</div></code></pre>
<pre><code><label for="nombre">Nombre completo</label>
<input type="text" id="nombre" name="nombre" autocomplete="name" required>
<label for="correo">Correo electrónico</label>
<input type="email" id="correo" name="correo" autocomplete="email" required>
<a href="reglamento.pdf">Leer el reglamento de talleres (PDF)</a>
<button type="submit">Enviar inscripción</button></code></pre>

<h2>Front 2: contrast</h2>
<p>WCAG asks for a contrast ratio of at least <strong>4.5:1</strong> for normal text and <strong>3:1</strong> for large text. The ratio is calculated from the relative luminance of the two colors. I calculated several with the script, on a white background:</p>
{{img:contraste}}
<p>Gray <code>#767676</code> is, in fact, the lightest gray on white that meets 4.5:1 (4.54:1); one step lighter, <code>#777777</code>, no longer does (4.48:1), and the "elegant" gray <code>#AAAAAA</code> comes in at 2.32:1, which many people cannot read, and almost nobody on a screen in the sun. Also, do not use color alone to inform (for example, a field with an error only in red) and check states as well: links, disabled buttons and text over images.</p>

<h2>Front 3: keyboard</h2>
<p>Many people browse without a mouse: screen reader users, adaptive keyboard users or people with tremors. The test is simple and needs no tools: <strong>unplug the mouse and go through your page with Tab</strong>. You must be able to reach everything interactive, in a logical order, and <strong>always see where the focus is</strong>. Typical mistakes: <code>&lt;div onclick&gt;</code> that does not receive focus, positive <code>tabindex</code> values that alter the order, menus that only open with the mouse and pop-ups that trap focus. WCAG 2.2 added, among others, that focus must not be hidden behind a sticky bar and that touch targets be at least 24 by 24 pixels.</p>

<h2>A script that finds the basics</h2>
<p>I wrote a script of about 130 lines in Python (standard library only) that checks an HTML file and detects eight frequent problems: images without <code>alt</code>, fields without a label, missing language or title, empty or generic links ("click here"), buttons without text, heading jumps, positive <code>tabindex</code> and <code>div</code> with a click handler, and it also calculates contrasts. I tested it with the bad form (with three unlabeled fields and gray text) and the good one:</p>
<pre><code>formulario-inaccesible.html: 14 problema(s) detectado(s)
 - Salto de encabezados: de h1 a h3
 - Imagen sin atributo alt: logo.png
 - Enlace con texto genérico: "Haz clic aquí"
 - tabindex positivo (3) en <div>: altera el orden natural del teclado
 - <div> con onclick: no es accesible por teclado; usa <button>
 - Falta el idioma de la página (<html lang="es">)
 - Campo <input> sin etiqueta asociada (name=nombre); un placeholder no reemplaza a la etiqueta
 - Contraste insuficiente: #aaaaaa sobre #ffffff = 2.32:1 (mínimo 4,5:1 para texto normal)
 (...)
formulario-accesible.html: 0 problema(s) detectado(s)</code></pre>
<p>It is a help to get started, not an audit: it detects what is mechanical, not what requires judgment (whether the alternative text is useful, whether the order is logical). That is why the workbook includes a <strong>20-criterion checklist</strong> from WCAG 2.1 and 2.2 with how to test each by hand, a summary that computes the percentage of compliance and priorities.</p>

<h2>A ten-minute test</h2>
<ol>
<li><strong>Keyboard:</strong> go through the form with Tab and submit it with Enter. Can you reach everything? Do you see the focus?</li>
<li><strong>Zoom:</strong> enlarge to 200% and 400%. Is content lost or does horizontal scrolling appear?</li>
<li><strong>Labels:</strong> click each label. Does the field get focus?</li>
<li><strong>Errors:</strong> submit empty. Do the messages say what failed, in text?</li>
<li><strong>Contrast:</strong> measure the colors of text and buttons.</li>
<li><strong>Screen reader:</strong> if you can, try NVDA (free, for Windows) or VoiceOver on Mac and iPhone.</li>
</ol>
<p>And better still, ask a person with a disability to use your form: you will learn more in five minutes than with any tool.</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, accessibility has moved from good practice to a legal requirement in many countries (Europe, the US, Canada and others), and the most frequent problems are the same everywhere, as the study shows. In Colombia and Latin America, the websites of schools, education secretariats and small businesses are often built with templates and plugins installed without review, and enrollment and paperwork are moving more and more to online forms, often from a phone. For <strong>principals</strong>, accessibility is part of service quality and inclusion; for <strong>teachers</strong>, it also applies to the digital material they share (documents, presentations, captioned videos); and for <strong>families</strong>, it means being able to enroll, pay and check grades without depending on someone else. It is consistent with the reasonable-adjustments and universal-design approach applied in the classroom (see <a href="/herramientas/piar/">PIAR con IA</a>).</p>

<h2>Tools that help work with inclusion</h2>
<p>In the classroom, <a href="/herramientas/piar/">PIAR con IA</a> helps document each student's reasonable adjustments, with drafts the expert team validates. And the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> makes it possible to produce versions of an assessment for the teacher to adapt.</p>
{{productos:piar-con-ia-5-planes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">ransomware: the first 60 minutes</a>, <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">integrations that fail silently</a> and <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">an institutional AI policy for schools</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is WCAG?</h3>
<p>The W3C's Web Content Accessibility Guidelines: criteria for web content to be perceivable, operable, understandable and robust. They have levels A, AA and AAA; level AA is the one usually required.</p>
<h3>Is a private school required to meet web accessibility?</h3>
<p>Resolution 1519 of 2020 mainly binds public entities; a private school may not be bound by it, but accessibility is good practice and may be required under other inclusion rules. Consult a legal adviser.</p>
<h3>Why is a placeholder in fields not enough?</h3>
<p>Because it disappears when typing, usually has low contrast and many screen readers do not announce it as a label. A visible label associated with the field is needed.</p>
<h3>What contrast should I use?</h3>
<p>At least 4.5:1 for normal text and 3:1 for large text, under WCAG level AA. You can measure it with a checker or with the workbook's script.</p>
<h3>Is an automated tool enough?</h3>
<p>It is useful to start, but it detects only part of the problems. Complete it with keyboard tests, zoom and, if possible, a screen reader and real users.</p>

<p class="notice"><strong>This week:</strong> test your most important form with the keyboard and measure the contrast of its texts. Download the <a href="/descargas/accesibilidad-web/lista-accesibilidad-web.xlsx">checklist</a> (in Spanish) and run the <a href="/descargas/accesibilidad-web/revisar_accesibilidad_basica.py">script</a> on your HTML (the two example forms, <a href="/descargas/accesibilidad-web/formulario-inaccesible.html">inaccessible</a> and <a href="/descargas/accesibilidad-web/formulario-accesible.html">accessible</a>, are also available).</p>

<h2>Food for thought</h2>
<p>Accessibility is often treated as an extra cost left "for later". <strong>Is the inaccessibility of an educational service a form of discrimination even if nobody intended it? And if an institution welcomes everyone but its enrollment form only works for those who see, use a mouse and have a good connection, whom are we choosing without realizing it?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:webaim}}' => $img('accesibilidad-web-webaim', 573, 'Four cards with the most frequent failures according to WebAIM Million 2025: 79.1% of pages with low contrast, 55.5% with images without alternative text, 48.2% with fields without a label and 45.4% with empty links.', 'The failures that repeat most on the web.'),
    '{{img:contraste}}' => $img('accesibilidad-web-contraste', 499, 'Table with contrasts calculated on a white background: black 21 to 1, gray 767676 4.54 to 1 which barely passes, gray 777777 4.48 to 1 which fails and gray AAAAAA 2.32 to 1 which fails.', 'Contrast of several grays on a white background.'),
]);

return [
    'accesibilidad-web-formularios-contraste-teclado-checklist-colegios-pymes' => [
        'slug' => 'web-accessibility-forms-contrast-keyboard-checklist-schools-small-businesses',
        'title' => 'Web Accessibility: Forms, Contrast and a Keyboard Everyone Can Use (Checklist for Schools and Small Businesses)',
        'excerpt' => 'The three fronts that fail most in web accessibility (forms, contrast and keyboard), with WebAIM Million 2025 data, the Colombian framework, code from a bad and a good example, a Python script and an Excel checklist.',
        'seo_title' => 'Web Accessibility: Forms, Contrast and Keyboard',
        'seo_description' => 'How to make your forms and pages accessible: labels, 4.5:1 contrast and keyboard, with WebAIM data, a Python script and a downloadable checklist.',
        'focus_keyword' => 'web accessibility forms',
        'cover' => '/assets/img/articulos/accesibilidad-web/accesibilidad-web-portada-en',
        'cover_alt' => 'Cover "Web accessibility: forms, contrast and a keyboard everyone can use" with a list: every field with its label, keyboard-only use and 4.5:1 contrast, ticked; a placeholder as the label, crossed out.',
        'content_html' => $html,
    ],
];
