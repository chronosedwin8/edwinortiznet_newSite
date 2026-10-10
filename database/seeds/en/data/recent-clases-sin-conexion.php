<?php

declare(strict_types=1);

// English version of "Clases que funcionen cuando no hay internet: un modelo de planificación "offline…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/clases-sin-conexion/' . $name . '-en';
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
<p>A teacher prepares a class with a video, an interactive simulation and an exercise platform. She arrives at the classroom and there is no internet. Or there is, but it drops after five minutes with thirty students connected. Or there is no power. The class planned so carefully becomes a wait. For many teachers in Colombia and the region, it is not a rare case: <strong>it is Monday</strong>.</p>
<p>This article proposes an "<strong>offline-first</strong>" planning model: design the class so that it achieves its learning outcome <strong>without needing a connection</strong>, and use the connection, if it exists, as an extra. It includes a <a href="/descargas/clases-sin-conexion/planificador-clase-sin-conexion.xlsx">downloadable Excel planner</a> (in Spanish) with a 90-minute example, a materials package and a plan B. Data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A robust class separates two moments: <strong>preparing with a connection</strong> (downloading, printing, testing) and <strong>teaching without depending on it</strong>. Each activity is marked "No", "Optional" or "Yes" depending on whether it needs a network, and every activity has a plan B. The aim is not to give up technology, but for <strong>students without a connection not to be left without a class</strong>.</p>

<h2>Why it matters: the data</h2>
<p>According to the International Telecommunication Union's (ITU) Facts and Figures 2025 report, about 6 billion people used the internet in 2025, but <strong>2.2 billion remained offline</strong>; use is 85% in urban areas and 58% in rural ones. In Colombia, a study by Universidad Javeriana's Education Economics Lab using data from DANE's form C600, reported by El País (April 22, 2025), estimated that <strong>40% of the country's school sites had no internet</strong> (over 21,000) and that about 10% (some 4,700) had no electricity; among the departments with the most sites without internet were Vaupés (84.3%), Amazonas (81.3%) and Vichada (79.5%), versus 0.6% in Bogotá. These are figures from a secondary source citing a study, and they may have changed; but they show the scale of the problem. Even where there is internet, there are quality limits: a connection that works for an email does not work for thirty videos at once.</p>
{{img:brecha}}
<p>The pedagogical consequence: <strong>a class that depends on the network widens inequality</strong> instead of closing it, because those who are already better connected get more class. (See also <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">schools' technology debt</a>.)</p>

<h2>The model in five steps</h2>
{{img:pasos}}
<ol>
<li><strong>Define the learning outcome and the evidence</strong> without mentioning tools: "order fractions and explain the reasoning", not "use simulation X".</li>
<li><strong>Choose activities that need no network:</strong> physical material, pair work, the board, a notebook, card games, the schoolyard. Digital comes in as a complement.</li>
<li><strong>Prepare a materials package beforehand</strong> (with a connection): download what you need, print guides and cards and keep copies on a USB drive and on the computer. And <strong>test it offline</strong>: put the device in airplane mode and open each file; a video that "did load" may depend on the network.</li>
<li><strong>Mark each activity's dependency</strong> (No, Optional, Yes) and write a plan B. An activity that depends on the connection without a plan B is a risk.</li>
<li><strong>Sync afterwards:</strong> upload what applies, review assignments and download new material when there is a connection.</li>
</ol>

<h2>An example: fractions in 90 minutes</h2>
<p>The planner includes a sixth-grade math class with six activities and each one's dependency:</p>
<table>
<thead><tr><th>Activity</th><th>Min.</th><th>Connection</th><th>Plan B</th></tr></thead>
<tbody>
<tr><td>Warm-up: what part of the chocolate?</td><td>10</td><td>No</td><td>Draw in the notebook</td></tr>
<tr><td>Paper-strip model: compare 1/2, 2/3 and 3/4</td><td>20</td><td>No</td><td>Draw rectangles</td></tr>
<tr><td>Number line on the floor with tape</td><td>15</td><td>No</td><td>Draw with chalk in the yard</td></tr>
<tr><td>Interactive simulation (demonstration)</td><td>15</td><td>Optional</td><td>Do it on the board</td></tr>
<tr><td>Practice: order six fractions</td><td>20</td><td>No</td><td>Dictate the fractions</td></tr>
<tr><td>Closing: explain a case in writing</td><td>10</td><td>No</td><td>Do it aloud in pairs</td></tr>
</tbody>
</table>
<p>The workbook computes, with formulas, that of the 90 minutes <strong>none needs a connection</strong>, 15 use it as optional (the simulation, which is downloaded beforehand and opened offline) and the reading is "La clase funciona sin conexión" (the class works without a connection). I tested the reverse case: if you mark the simulation "Yes", the workbook says 17% of the time depends on the connection and asks you to review the plan B. The "Paquete_de_materiales" sheet adds up the size of what you download (in the example, 58 MB: it fits easily on a USB drive), warns about materials without a backup copy and those not tested offline, and the "Plan_B" sheet covers what to do if the internet, power, projector, devices or a file fail.</p>

<h2>Tools that help</h2>
<ul>
<li><strong>Printed material and manipulatives:</strong> the most reliable technology is the one that needs no power.</li>
<li><strong>Platforms designed to work offline.</strong> Kolibri, from the nonprofit Learning Equality, is an open-source "offline-first" platform: content is loaded from the internet, a USB drive or another device on a local network, and students use it from tablets or computers connected to a classroom server; it syncs data when there is a connection. According to the information consulted, its library gathers materials in over 173 languages. Review the license conditions and privacy of any platform before adopting it (see the <a href="/politica-institucional-ia-colegios-que-permitir-condicionar-no-autorizar/">institutional AI policy</a> and the <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into an AI</a>).</li>
<li><strong>Open formats:</strong> simple PDFs, images and HTML open on any device; avoid those that require an account or an online service to open.</li>
<li><strong>Printable exams and guides:</strong> preparing them in advance allows working without screens.</li>
</ul>

<h2>How to assess offline</h2>
<p>Formative assessment hardly needs a network: exit tickets on a card, answers on mini whiteboards, oral explanations in pairs, observation of work with concrete material. For the final assessment, a printed exam with a rubric is perfectly valid. What matters is gathering <strong>evidence of learning</strong> and not depending on a platform to record it (see <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">what grades measure</a>).</p>

<h2>What not to do</h2>
<ul>
<li><strong>Assuming "everyone has internet at home".</strong> See the data.</li>
<li><strong>Assigning tasks that require a connection with no alternative:</strong> it penalizes those who cannot.</li>
<li><strong>Using long videos as the central activity</strong> in a classroom where the network is unstable.</li>
<li><strong>Not testing the material offline</strong> before class.</li>
</ul>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, the digital divide is concentrated in low- and middle-income countries and in rural areas; ITU estimates that 96% of those still offline live in low- and middle-income countries. In Colombia, school connectivity has grown, but it remains very unequal among territories. That is why the offline class is not just for remote areas: the urban school needs it too when the network or power fails. For <strong>teachers</strong>, planning with a plan B is a way of looking after their class; for <strong>principals</strong>, deciding which technology to buy with real connectivity in mind (see <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a>); for <strong>families</strong>, not demanding what they cannot give; and for <strong>students</strong>, that learning does not depend on their postal code.</p>

<h2>Tools for the teacher</h2>
<p>To plan and produce printable material, the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> has recipes by subject that help you prepare the package in advance, and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> delivers exams and solutions you can print and apply offline. There is also a <a href="/examenes/demo/">free demo</a>.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">a four-week test to assess a tool</a> and <a href="/docente-autonomia-pedagogica-plataformas-que-planean-evaluan-recomiendan/">pedagogical autonomy and platforms</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What does "offline-first" mean?</h3>
<p>Designing so that everything works without a connection, and using the connection, if it exists, to sync or extend. It is the opposite of designing for the network and "patching" when it fails.</p>
<h3>How do I prepare a materials package?</h3>
<p>With a connection, download what you need, print guides and cards, keep copies on a USB drive and on the computer, and test each file in airplane mode before class.</p>
<h3>Can I use simulations and videos if there is no internet?</h3>
<p>Yes, if you download them beforehand and open them offline. Check that the file works without a connection and mark the activity as "Optional", with a plan B.</p>
<h3>How do I assign tasks if students have no internet at home?</h3>
<p>With printed guides or notebook activities, and avoid those requiring platforms. If there is a connection, offer it as a complement.</p>
<h3>Are there platforms for working offline?</h3>
<p>Yes. Kolibri is an example of an open-source platform designed for offline use. Assess its license, privacy and fit with your curriculum before adopting it.</p>

<p class="notice"><strong>This week:</strong> take a class you have already planned, run it through the <a href="/descargas/clases-sin-conexion/planificador-clase-sin-conexion.xlsx">planner</a> (in Spanish), mark each activity's dependency and write the plan B for those that depend on the network. Then test your package in airplane mode.</p>

<h2>Food for thought</h2>
<p>Every time we plan a class that assumes a connection, we decide, without saying so, who the class is for. <strong>Is disconnection an infrastructure problem for the State to solve, or also a pedagogical design problem each teacher can address today? And while connection reaches every site, what are we willing to stop doing in class so nobody is left out?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:brecha}}' => $img('clases-sin-conexion-brecha', 573, 'Four cards with connectivity data: 2.2 billion people offline worldwide in 2025, internet use of 85% urban vs 58% rural, 40% of Colombia\'s school sites without internet and 84.3% in Vaupés vs 0.6% in Bogotá.', 'A class that depends on the network leaves many out.'),
    '{{img:pasos}}' => $img('clases-sin-conexion-pasos', 467, 'Five steps to plan a class without depending on the network: define the outcome, choose offline activities, prepare the package first, mark dependencies with a plan B and sync afterwards.', 'Five steps of offline-first design.'),
]);

return [
    'clases-que-funcionen-sin-conexion-modelo-planificacion-offline-first' => [
        'slug' => 'classes-that-work-without-internet-offline-first-planning-model',
        'title' => 'Classes That Work When There Is No Internet: An Offline-First Planning Model with a Plan B',
        'excerpt' => 'How to design a class that achieves its learning outcome with or without a connection: connectivity gap data, five steps, a 90-minute example and an Excel planner with a materials package and a plan B.',
        'seo_title' => 'Classes Without Internet: Offline-First Planning',
        'seo_description' => 'How to plan classes that work without internet: connectivity data for Colombia, five steps, a 90-minute example and a downloadable planner.',
        'focus_keyword' => 'offline classes without internet',
        'cover' => '/assets/img/articulos/clases-sin-conexion/clases-sin-conexion-portada-en',
        'cover_alt' => 'Cover "Classes that work when there is no internet: a planning model" with a card: 40% of the country\'s school sites had no internet, over 21,000 without a connection and about 4,700 without electricity.',
        'content_html' => $html,
    ],
];
