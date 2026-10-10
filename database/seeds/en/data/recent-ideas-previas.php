<?php

declare(strict_types=1);

// English version of «El error revela cómo piensa el estudiante: ideas previas en ciencias y preguntas…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ideas-previas/' . $name . '-en';
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
<p>Question: "Why are there summer and winter?". Answer by a ninth grader: "Because in summer the Earth is closer to the Sun". It is a wrong answer, but not a silly one: it is a reasonable explanation from everyday experience (what is closer gets warmer), and a <strong>surprising share of adults</strong> hold it. Correcting it with "no, it is because of the axis tilt" often does not work, because the new explanation clashes with an idea the student already finds obvious.</p>
<p>This article is about what those mistakes reveal: <strong>preconceptions (or alternative conceptions)</strong>, what research says about their persistence, how to design diagnostic questions whose distractors are known preconceptions and how to work with them. It includes an <a href="/descargas/concepciones-alternativas/banco-diagnostico-ideas-previas.xlsx">Excel workbook</a> (in Spanish) with eight science questions, each with a frequent preconception as a tagged distractor, and an automatic analysis of the group and of each student, verified in Microsoft Excel 16 and against an independent Python calculation. Sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The group data are <strong>fictional and deliberately exaggerated</strong> to illustrate the analysis (in a real group, percentages will vary a lot). The catalog's preconceptions are frequent conceptions described in the science education literature; their frequency depends on the group, age and country, and is worth checking with your students. The approach does not guarantee that ideas will change: preconceptions are resistant.</p>

<h2>What preconceptions are and why they matter</h2>
<p>Students do not arrive in class with a blank mind: they arrive with explanations built from their experience (the heavy one falls faster, current gets used up in the bulb, plants eat soil). The literature calls them <em>preconceptions</em>, <em>alternative conceptions</em> or, less aptly, <em>misconceptions</em>. I prefer the first two names because they stress something important: <strong>they are reasonable explanations, not carelessness</strong>. Someone who answers "the distance to the Sun" is not distracted; they are applying a rule (closer, warmer) that works in daily life.</p>
<p>Research shows these ideas survive ordinary teaching. Two classic references:</p>
<ul>
<li><strong><em>A Private Universe</em> (1987).</strong> A documentary from the Harvard-Smithsonian Center for Astrophysics (by Schneps and Sadler) in which Harvard graduates, asked about the cause of the seasons, confidently explained that the Earth is closer to the Sun in summer, and for the Moon phases that the Earth's shadow produces them, ideas that ninth graders at a nearby school also held. A 1988 press report said only one in twenty interviewees gave the correct explanation. It is an interview case study, not a representative sample, but it illustrates the persistence of ideas.</li>
<li><strong>The Force Concept Inventory (1992).</strong> A multiple-choice instrument (Hestenes, Wells and Swackhamer, <em>The Physics Teacher</em>) to assess conceptual understanding of Newtonian mechanics. Its premise is that students arrive with a system of common-sense beliefs about the physical world, and its authors found that instruction that does not take them into account is almost totally ineffective for most students. Its distractors are not random errors: they reproduce frequent preconceptions.</li>
</ul>

<h2>Diagnostic questions: the distractor as a clue</h2>
<p>The idea of diagnostic questions is simple: <strong>each wrong option represents a known preconception</strong>, so the student's answer says not only whether they know, but <em>what they think</em>. In the workbook, the <em>Preguntas</em> sheet has eight science questions, each with four options and a tag: the correct one (OK), a preconception (C1 to C8) or none.</p>
{{img:ideas}}
<ol>
<li><strong>Seasons:</strong> distance to the Sun (C1) or axis tilt and day length?</li>
<li><strong>Moon phases:</strong> the Earth's shadow (C2) or the lit part visible from Earth?</li>
<li><strong>Falling objects</strong> (in an air-evacuated tube): does the heavy one arrive first (C3) or do they arrive together?</li>
<li><strong>Electric circuit:</strong> does current get used up in the bulb (C4) or is it the same throughout the circuit?</li>
<li><strong>Origin of a plant's mass:</strong> from the soil (C5) or from carbon dioxide in the air and water?</li>
<li><strong>Force and motion:</strong> at constant velocity without friction, is there a force in the direction of motion (C6) or no net force?</li>
<li><strong>Boiling water:</strong> do the bubbles contain air (C7) or water vapor?</li>
<li><strong>Heat and temperature:</strong> does metal feel colder because it has a lower temperature (C8) or because it conducts heat from the hand better?</li>
</ol>
<p>How such questions are designed: (1) start from preconceptions documented in the literature and, better, from interviews with your own students; (2) write a distractor expressing each idea so that a student who holds it recognizes it as "the obvious answer"; (3) write the other distractors plausibly; (4) test with a group and see which options they choose. A useful variant is two-tier questions: first the answer, then the reason.</p>

<h2>What the workbook shows (fictional group)</h2>
<p>The workbook counts how many students choose each option of each question. In the fictional group of 30 students, <strong>29% of answers were correct and 55% followed the tagged preconception</strong>, and on all eight questions the preconception outweighed the correct answer. By question:</p>
<ul>
<li><strong>Seasons:</strong> 20 of 30 chose distance to the Sun (67%) and 6 the correct answer (20%). It is the group's most frequent preconception.</li>
<li><strong>Origin of a plant's mass:</strong> 20 of 30 (67%) chose the soil; 6 the correct answer.</li>
<li><strong>Boiling water:</strong> 18 of 30 (60%) chose air; 7 water vapor.</li>
<li><strong>Circuit:</strong> 17 of 30 (57%) believe current gets used up; 11 (37%) got it right.</li>
<li><strong>Falling objects:</strong> 16 of 30 (53%) chose the stone first; 13 (43%) the correct option, the best of the eight.</li>
<li><strong>Force and motion:</strong> 11 (37%) against 10 (33%): almost tied.</li>
</ul>
<p>The <em>Estudiantes</em> sheet classifies each student by how many times they chose the preconception: 15 with "ideas previas muy arraigadas" (deeply rooted preconceptions, 5 or more), 11 with "varias ideas previas" (several, 3 or 4), 3 "mixto" and 1 with "comprensión sólida" (solid understanding). It is a profile to decide later work, <strong>not a grade or a label</strong>. The summary also returns the most frequent preconception (C1, distance to the Sun).</p>
<p>Reading these numbers changes what you do on Monday: with 20 of 30 on the distance-to-the-Sun idea, a "no, it is because of the tilt" is not enough. An activity that puts the idea in crisis is needed (see below). By contrast, the idea that heavy objects fall first carries less weight and is the one most quickly corrected with a demonstration.</p>

<h2>Five steps to work on a preconception</h2>
{{img:pasos}}
<ol>
<li><strong>Ask "why do you think so?"</strong> and listen to the whole explanation. Before correcting, understand the student's logic.</li>
<li><strong>Classify the preconception:</strong> which of the catalog's (or which new one) explains the answer? The analysis sheet already does it by question.</li>
<li><strong>Confront with a prediction and an observation.</strong> The <em>predict, observe, explain</em> scheme: students write what they think will happen (for example, what falls first, a sheet of paper or a crumpled one, with and without a book underneath), observe and explain the difference. Feeling that their idea does not explain what was observed is what opens the door to another.</li>
<li><strong>Rebuild the scientific model</strong> with them: a model, a diagram, a simulation. Telling it is not enough.</li>
<li><strong>Check another day with a new question,</strong> similar but not identical. Preconceptions tend to reappear, and that is normal: several opportunities are needed (see <a href="/transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla/">transfer of learning</a>).</li>
</ol>
<p>The conceptual change approach has varied results in research: it works better when the student perceives that their idea does not serve and that the new one explains more, and worse when treated as a quick correction. Combine it with retrieval and spacing practices (see <a href="/concurso-docente-del-simulacro-al-plan-de-mejora-hoja-de-seguimiento/">from the mock exam to the improvement plan</a>, which uses the logic of classifying errors by cause).</p>

<h2>This is not only about science</h2>
<p>In mathematics, preconceptions are "badly generalized rules" (see <a href="/error-matematico-que-se-repite-matriz-de-errores-diagnostico-grupo/">the math error that keeps repeating</a>): adding numerators to numerators, believing multiplying always makes bigger. In language, believing that "a text is true because a book says so". In social studies, believing that history is a list of dates. The method is the same: <strong>ask why, classify the logic behind the mistake and design a situation that puts that logic to the test</strong>.</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, the Basic Competency Standards in Natural Sciences (MEN, 2004) and the Saber tests emphasize explaining phenomena and using concepts in situations, which requires moving from the memorized definition to the model. Research on alternative conceptions is international and abundant, from physics and astronomy to biology and chemistry, and shows very similar patterns across countries, suggesting they come from the shared experience of the physical world and not from a particular curriculum. For <strong>teachers</strong>, the challenge is to see the mistake as information; for <strong>principals</strong>, to give time for diagnosis and confrontation (a 45-minute class rarely suffices); for <strong>families</strong>, to know that getting a reasonable idea wrong is part of learning, and that there is no need to "correct" the child with a memorized fact; and for <strong>students</strong>, that asking "why did I think that?" is a skill. A risk: labeling students ("the one with deeply rooted preconceptions"); the profile serves to plan, not to classify people.</p>

<h2>Tools and templates</h2>
<p>To generate diagnostic questions with distractors based on preconceptions and other learning evidence, and to organize your resources with AI (always checking that the correct answer is correct and that the preconceptions are well represented), look at these tools of our own.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/analisis-de-items-excel-dificultad-discriminacion-distractores-kr20-libro/">item analysis in Excel</a> (how to read any test's distractors), <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">backward design</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>. To adapt the work for students with learning barriers, <a href="/herramientas/piar/">PIAR with AI</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is a preconception or alternative conception?</h3>
<p>An explanation the student built from experience that differs from the scientific explanation. It is usually reasonable and resistant to ordinary teaching.</p>
<h3>Why do I correct them and they come back?</h3>
<p>Because correcting with a fact does not change the mental model. The student needs to see that their idea does not explain what was observed and to build a better explanation, and to return to the topic several times.</p>
<h3>How do I design a diagnostic question?</h3>
<p>Write a correct option and distractors expressing known preconceptions, so that whoever holds them recognizes them as "the obvious answer"; test it with a group and look at what they choose.</p>
<h3>Are preconceptions the same as mistakes?</h3>
<p>Mistakes are the signal; preconceptions are what usually lies behind. One idea can produce different mistakes.</p>
<h3>Do preconceptions change with a good explanation?</h3>
<p>Rarely with an explanation alone. Situations that create conflict with what the student expects, work with models and repeated practice work better.</p>

<p class="notice"><strong>Try the diagnostic in your next unit.</strong> Download the <a href="/descargas/concepciones-alternativas/banco-diagnostico-ideas-previas.xlsx">diagnostic question bank</a> (in Spanish), replace the questions with your topic's (with the preconceptions you see in your students) and see which idea dominates in your group before starting.</p>

<h2>Food for thought</h2>
<p>When a student gets it wrong, which question do we ask first: "what is the right answer?" or "how did you think about it?". <strong>How many of the ideas we now consider obvious were once humanity's preconceptions? And if a mistake were always a window onto a reasonable explanation, how would what we do when we correct change?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ideas}}' => $img('ideas-previas-ideas', 553, 'Table with five frequent science preconceptions and the scientific model: seasons, moon phases, free fall, electric circuit and plants.', 'What many think and what science says.'),
    '{{img:pasos}}' => $img('ideas-previas-pasos', 467, 'Five steps to work on a preconception: ask, classify, confront, rebuild and check.', 'Five steps to work on a preconception.'),
]);

return [
    'error-revela-como-piensa-estudiante-ideas-previas-ciencias-preguntas-diagnostico' => [
        'slug' => 'mistake-reveals-how-student-thinks-preconceptions-science-diagnostic-questions',
        'title' => 'The Mistake Reveals How the Student Thinks: Science Preconceptions and Diagnostic Questions (Verified Workbook)',
        'excerpt' => 'What preconceptions or alternative conceptions are, what research says about their persistence and how to design diagnostic questions whose distractors reveal them, with an Excel workbook of eight science questions.',
        'seo_title' => 'Science Preconceptions: Diagnostic Questions',
        'seo_description' => 'What science preconceptions are, why they persist and how to design diagnostic questions whose distractors reveal them, with a verified Excel workbook.',
        'focus_keyword' => 'science preconceptions',
        'cover' => '/assets/img/articulos/ideas-previas/ideas-previas-portada-en',
        'cover_alt' => 'Cover "The mistake reveals how the student thinks: preconceptions in science" with a card: 55% and 29%, preconception and correct answers in a fictional group.',
        'content_html' => $html,
    ],
];
