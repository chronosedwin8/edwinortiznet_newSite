<?php

declare(strict_types=1);

// English version of «STEAM sin equipos costosos: proyectos con materiales cotidianos, presupuesto y r…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/steam-bajo-costo/' . $name . '-en';
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
<p>"We would like to do STEAM, but we have no lab, no 3D printer and no robotics kits." It is one of the most repeated phrases when talking about science, technology, engineering, arts and mathematics projects in schools with limited budgets. And it hides a misunderstanding: <strong>what makes a STEAM project valuable is not the equipment, but the question, the measurement and the improvement</strong>.</p>
<p>This article proposes a project design that can be done with everyday and recycled materials, with a <a href="/descargas/steam-bajo-costo/plantilla-steam-bajo-costo.xlsx">downloadable Excel template</a> (in Spanish: project sheet, budget, five-criterion rubric and a bank of eight ideas), verified in Microsoft Excel 16 with sample data. Data and sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The template's prices are in Colombian pesos and are examples: replace them with your area's. The rubric is the author's own proposal; the scale and way of grading are defined by each school's student assessment system (SIEE). Projects involving electricity, heat or sharp tools require adult supervision and the corresponding safety measures.</p>

<h2>What STEAM is (and is not)</h2>
<p>The most cited framework is Georgette Yakman's, who in 2006 proposed adding the arts to the STEM fields (science, technology, engineering and mathematics). But there is no single definition: according to a literature review covering 2007 to 2018 (Perignat and Katz-Buonincontro, 2019), authors disagree on what integrating means, what the role of the arts is and what the purpose of STEAM is. And evidence that STEAM improves concrete outcomes, such as science achievement, is still mixed and rests mostly on small or qualitative studies. In other words: <strong>STEAM is a good pedagogical idea with evidence still being built, not a guarantee</strong>, and it is worth evaluating in your classroom with your own data (see <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">how to test an educational tool in four weeks</a>).</p>
<p>What pedagogical common sense does suggest is that integration works when each area serves a function, not when a science project is "decorated" with a drawing:</p>
{{img:versiones}}

<h2>Four principles for STEAM without expensive equipment</h2>
<ol>
<li><strong>Start with the question, not the material.</strong> "Where does the wind blow hardest at school?" is a measurable question; "let's make a windmill" is an activity.</li>
<li><strong>Measure something.</strong> Without data there is no science or mathematics; a phone stopwatch, a ruler or a measuring cup is enough.</li>
<li><strong>Require a second version.</strong> Designing, testing and improving is the heart of engineering. A project handed in on the first try saves time and loses the learning.</li>
<li><strong>Give the product a real audience:</strong> another class, families, the school's leadership. Art then has a function (communicating clearly), not just a decorative one.</li>
</ol>
{{img:ciclo}}

<h2>A complete case: the cup anemometer</h2>
<p>The template's example sheet develops this project in four 55-minute sessions. <strong>Question:</strong> how can we compare wind strength in three places at school with an instrument we build? A cup anemometer has cups (or cones) attached to arms that spin in the wind; counting revolutions per minute gives a <em>relative</em> measure of wind strength.</p>
<ol>
<li><strong>Session 1 (question and design):</strong> each group proposes a design and predicts where there will be more wind. Which variables to control (height, time of day, counting time) is discussed.</li>
<li><strong>Session 2 (version 1 and test):</strong> it is built, one cup is marked with color to count revolutions and measurements are taken in the three places, three times each, for one minute.</li>
<li><strong>Session 3 (improvement):</strong> data are analyzed, what failed is identified (for example, friction on the axle or uneven cups) and version 2 is built.</li>
<li><strong>Session 4 (communication):</strong> the average per place is calculated, the two versions are compared and a poster with a conclusion is made.</li>
</ol>
<p><strong>An honest warning:</strong> a homemade instrument is not calibrated; it serves to <em>compare</em> places and versions, not to say "the wind is 12 km/h". Recognizing the instrument's limits is part of what is learned.</p>
<p>The example budget (with example prices in Colombian pesos): 20 balsa sticks at $500, a box of pins at $3,000, three rolls of tape at $2,500 and five markers at $3,000, plus recycled cups, cardboard and caps: <strong>$35,500 in total, $1,183 per student with 30 students</strong>, with 3 of 7 materials not purchased (42.9%). The Presupuesto sheet calculates it automatically.</p>

<h2>The five-criterion rubric</h2>
<p>The rubric evaluates question and investigation, design and improvement (engineering), measurement and calculation (mathematics), communication and design (art) and collaboration, each with four described levels, and adds up the weights to check they total 100%. In the example, with levels 3, 4, 2, 3 and 4 and a 20% weight each, the weighted result is 3.20 on a 1 to 4 scale (indicative reading "Logrado", achieved). Use it as feedback at each test, not only at the end (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a>), and translate the result to your SIEE's scale.</p>

<h2>Eight ideas with everyday materials</h2>
<p>The Banco_de_ideas sheet includes, with guiding question, areas involved and materials: cup anemometer, water clock, paper bridge, germination, water filter, musical instruments with tubes, scale map of the school and a circuit with battery and bulb. The approximate costs per group (between $2,000 and $9,000, averaging $4,750) are indicative and must be checked in your area. Each idea keeps the same logic: a measurable question, an instrument or prototype, a datum and an improvement.</p>

<h2>Colombia, Latin America and the world</h2>
<p>Colombia has a tradition of school research with institutional support: Minciencias' Ondas program, which began in 2001 and is defined as a strategy to foster a culture of science, technology and innovation in children and young people through research as a pedagogical strategy. It works with teachers who accompany students in their projects. Worldwide, "frugal science" shows that scarce equipment does not prevent doing science: the Foldscope, a paper microscope designed at Stanford, was presented in 2014 with an estimated cost of about 50 cents per unit (up to a dollar depending on the source), and has been used in educational projects in several cities. For <strong>teachers</strong>, the challenge is designing the question and the improvement, not obtaining equipment; for <strong>principals</strong>, giving time and backing (a 55-minute session rarely suffices to iterate); for <strong>families</strong>, contributing recycled materials and questions, not solving the project; and for <strong>students</strong>, daring to get the first version wrong. Mind equity: asking families for "nice" materials reproduces inequalities; recycling and school-provided material reduce them. To adapt a project for students with disabilities or learning barriers, see <a href="/herramientas/piar/">PIAR with AI</a> and <a href="/clases-que-funcionen-sin-conexion-modelo-planificacion-offline-first/">classes that work offline</a>.</p>

<h2>Tools and templates</h2>
<p>To plan the project's sequence and assessments with AI help (always reviewing what it produces), look at the kit and the exam generator, and this site's other own tools.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">the math error that keeps repeating</a>, <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">grades: learning or compliance</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What does STEAM mean?</h3>
<p>Science, technology, engineering, arts and mathematics, integrated in projects. There are several definitions; the most cited is Georgette Yakman's (2006).</p>
<h3>Can you do STEAM without a lab or computers?</h3>
<p>Yes. The essentials are a measurable question, a prototype, data and an improved version. A phone as stopwatch, a ruler and recycled materials are enough for many projects.</p>
<h3>How do I assess a STEAM project?</h3>
<p>With a rubric that values the question, design and improvement, measurement, communication and collaboration, and with feedback at each test. The final grade must be translated to your school's SIEE scale.</p>
<h3>How much does a project cost?</h3>
<p>It depends on the design. In the example, 35,500 pesos for 30 students (1,183 per student), with example prices. The template calculates the cost per student with your prices.</p>
<h3>Does STEAM improve science grades?</h3>
<p>The evidence is mixed and relies on small studies. It is worth measuring in your classroom, for example with a short test before and after.</p>

<p class="notice"><strong>Try it this week.</strong> Download the <a href="/descargas/steam-bajo-costo/plantilla-steam-bajo-costo.xlsx">low-cost STEAM template</a> (in Spanish), choose an idea from the bank and fill in the sheet. If the project fits on one page with a question, an instrument, a datum and an improvement, it is ready.</p>

<h2>Food for thought</h2>
<p>Sometimes the lack of equipment is an excuse and sometimes it is a hard reality. <strong>Which projects that seem impossible today for lack of resources would be possible with a good question and a second version? And conversely: when is the lack of resources an equity problem that the teacher's ingenuity should not have to solve alone?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:versiones}}' => $img('steam-bajo-costo-versiones', 499, 'Table comparing a decorative STEAM project with one with purpose in four elements: question, art, mathematics and engineering.', 'The same project, two versions.'),
    '{{img:ciclo}}' => $img('steam-bajo-costo-ciclo', 467, 'Five steps of a STEAM project: ask, design, test, improve and communicate.', 'The cycle of a STEAM project.'),
]);

return [
    'steam-sin-equipos-costosos-proyectos-materiales-cotidianos-plantilla' => [
        'slug' => 'steam-without-expensive-equipment-projects-everyday-materials-template',
        'title' => 'STEAM Without Expensive Equipment: Projects with Everyday Materials, Budget and Rubric (Template)',
        'excerpt' => 'How to do STEAM projects with everyday and recycled materials: four principles, a complete case (cup anemometer), budget, five-criterion rubric and eight ideas, in an Excel template.',
        'seo_title' => 'STEAM Without Expensive Equipment: Template',
        'seo_description' => 'STEAM projects with everyday materials: principles, a complete case, budget, rubric and eight ideas in an Excel template for teachers.',
        'focus_keyword' => 'STEAM without expensive equipment',
        'cover' => '/assets/img/articulos/steam-bajo-costo/steam-bajo-costo-portada-en',
        'cover_alt' => 'Cover "STEAM without expensive equipment: projects with everyday materials" with a card: 1,183 Colombian pesos per student in the example project, a cup anemometer with 30 students.',
        'content_html' => $html,
    ],
];
