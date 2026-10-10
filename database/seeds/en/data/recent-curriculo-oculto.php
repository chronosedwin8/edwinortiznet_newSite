<?php

declare(strict_types=1);

// English version of «El currículo oculto entre grados: las reglas que cambian cada año sin que nadie …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/curriculo-oculto/' . $name . '-en';
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
<p>Sofía reaches eighth grade with a habit that worked in seventh: handing in work a day late, with a small penalty. In eighth, the math teacher accepts nothing after the deadline; the language teacher, by contrast, accepts anything. In seventh the teacher corrected; now she is asked to correct. Nobody explained any of this to her, because it is in no document: it is what the school community calls the <strong>hidden curriculum</strong>, and this time it changes from grade to grade.</p>
<p>This article is about the hidden curriculum and, in particular, its least visible version: <strong>rules and expectations that change between grades</strong> without anyone deciding it collectively. It includes an <a href="/descargas/curriculo-oculto/mapa-expectativas-entre-grados.xlsx">Excel workbook</a> (in Spanish) to map ten classroom practices across four grades, count how many different versions of each there are and where changes concentrate, verified in Microsoft Excel 16 and against an independent calculation with fictional data. Sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The map's data are fictional and describe no school. The practices and messages mentioned are examples: the effect of a rule depends on context and on how it is applied, and there is no single correct way to handle punctuality, phones or participation. The goal is not to make all teachers uniform, but to <strong>make differences visible and discussable</strong>. Student assessment must follow the school's student assessment system (SIEE).</p>

<h2>What the hidden curriculum is</h2>
<p>The expression is associated with Philip Jackson, who in <em>Life in Classrooms</em> (1968) described that, besides the contents taught, school transmits norms, values and habits through its daily life: waiting turns, accepting evaluation, living with the crowd, obeying the routine. Since then, critical sociology and pedagogy (for example, the work of Apple and Giroux) have analyzed how those implicit messages can reproduce inequalities or, well used, form valuable habits. By contrast, the <strong>explicit curriculum</strong> is the written one: the study plan, standards, objectives and the SIEE. Article 76 of Colombia's Law 115 of 1994 defines the curriculum as the set of criteria, study plans, programs, methodologies and processes that contribute to comprehensive education and cultural identity; the hidden curriculum is what, without being there, also forms.</p>
<p>Examples of implicit messages: who speaks and who stays quiet, what is rewarded (speed, obedience, creativity), what happens with error (hidden or discussed), how group work is treated (does one learn to collaborate or to split tasks?), how students are talked about. It is not "good" or "bad" in itself: <strong>it is unavoidable, and the question is whether it is made conscious and coherent</strong>.</p>
{{img:mensajes}}

<h2>What changes between grades</h2>
<p>The hidden curriculum does not only vary between schools or teachers: it changes between grades. A student goes through, year after year, five, ten or fifteen adults who ask for different things with the same words ("group work", "participation", "correction"). The most visible changes occur at transitions, such as the move from primary to secondary school, where research on school transitions (for example, the line of work on the fit between adolescents' needs and the school environment by Eccles and colleagues) has found, on average, drops in motivation and perceived support, with large variation across students and contexts. Not everything is explained by classroom rules, but <strong>the lack of coherence between grades</strong> is one source of that uncertainty that can be worked on.</p>

<h2>The expectations map: ten practices, four grades</h2>
<p>The workbook's <em>Opciones</em> sheet defines ten practices, each with three possible ways of doing it (A, B or C): what happens with late work, phone use in class, submission format, error correction, group work, participation, retakes, rubric scale, homework and how to ask for the floor. On the <em>Mapa</em> sheet, each grade (6th to 9th in the example) marks the option that is really applied. The workbook calculates, for each practice, the <strong>different versions</strong> and the <strong>changes between consecutive grades</strong>:</p>
<pre><code>' Different versions of a practice across the four grades
=SUMPRODUCT(1/COUNTIF(C4:F4,C4:F4))                 ' English
=SUMAPRODUCTO(1/CONTAR.SI(C4:F4;C4:F4))             ' Spanish

' Changes between consecutive grades (0 to 3)
=(C4<>D4)+(D4<>E4)+(E4<>F4)

' Practices that change in the 7th-to-8th transition
=SUMPRODUCT(--(Mapa!D4:D13<>Mapa!E4:E13))</code></pre>
<p>With the example's fictional data:</p>
<ul>
<li><strong>3 coherent practices</strong> across the four grades (phone use, group work and how to ask for the floor), <strong>3 with two versions</strong> and <strong>4 with three or more versions</strong> (late work, error correction, retakes and rubric scale).</li>
<li><strong>13 of 30 possible transitions (43%)</strong> change rules (10 practices times 3 transitions).</li>
<li><strong>By transition:</strong> from 6th to 7th, 2 practices change; from 7th to 8th, <strong>6</strong> (the biggest jolt); from 8th to 9th, 5.</li>
<li>Error correction and retakes change at <strong>every</strong> transition (3 changes each): a student who learns how errors are handled in one grade must learn it again in the next.</li>
</ul>
<p>Each row's automatic diagnosis reads "Coherente en los cuatro grados" (coherent across the four grades, in green), "Dos versiones: revisar si el cambio es intencional" (two versions: check whether the change is intentional) or "Tres versiones o más: el estudiante aprende reglas nuevas cada año" (three versions or more: the student learns new rules every year). <strong>A difference is not automatically a problem:</strong> it can be an age-based change that makes sense (more autonomy in older grades). What the map allows is to distinguish <em>deliberate</em> from <em>accidental</em> changes.</p>

<h2>How to work on it in the institution</h2>
{{img:pasos}}
<ol>
<li><strong>Map what is done, not what the regulation says.</strong> Ask each grade team to mark the real practice, anonymously if needed; differences between what is written and what is practiced are already a finding.</li>
<li><strong>Compare and look for the reason.</strong> Why does the retake policy change from one grade to another? Is it age, tradition or chance?</li>
<li><strong>Agree on common minimums</strong> and age-justified exceptions (the <em>Acuerdos</em> sheet serves to note them). Two or three clear agreements are worth more than a long manual.</li>
<li><strong>Communicate</strong> to students and families, at the start of the year and at each transition (for example, a page on "what changes in eighth").</li>
<li><strong>Review each term</strong> with evidence: complaints, conversations with students, results.</li>
</ol>
<p>This connects with other assessment pieces: retake rules, deadlines and rounding must be in the SIEE (see <a href="/concurso-docente-siee-decreto-1290-evaluacion-promocion-estudiantes-escala-nacional/">the SIEE and Decree 1290</a>, in Spanish), and differences in criteria between teachers affect the perception of grade fairness (see <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">grades: learning or compliance</a>). Also with feedback (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a>): if each grade corrects in a different way, the student cannot build the habit of using it.</p>

<h2>A conversation among teachers: four questions</h2>
<ul>
<li>What does a student do in my class that worked in the previous grade's, and no longer does?</li>
<li>Which of my rules could I explain with a pedagogical reason, and which are habit?</li>
<li>What message does a student receive from my rule about error, collaboration or effort?</li>
<li>What would I have to agree with my colleagues so a student does not have to guess?</li>
</ul>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, the explicit curriculum is articulated among the Ministry (standards and basic learning rights), the PEI and each school's SIEE, and institutional autonomy lets each teacher make classroom decisions that are written nowhere. In the region and worldwide, the study of the hidden curriculum is a consolidated tradition, and concern about transitions between cycles (preschool to primary, primary to secondary, secondary to upper secondary) recurs in education policy. For <strong>teachers</strong>, the challenge is to talk about what seems obvious; for <strong>principals</strong>, to provide coordination spaces between grades and not only between subjects; for <strong>families</strong>, to know what to expect in each grade; and for <strong>students</strong>, predictable rules are part of feeling safe to learn. See also <a href="/planeacion-inversa-empezar-por-lo-que-quieres-que-comprendan-plantilla-alineacion/">backward design</a> (aligning what is taught, assessed and practiced) and <a href="/conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador/">conflict, indiscipline and school violence</a> (when coexistence rules also change by grade).</p>

<h2>Tools and templates</h2>
<p>To plan classroom agreements, coherent rubrics across grades and other materials, and to organize your resources with AI (always reviewing what it produces), look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla/">transfer of learning</a>, <a href="/error-revela-como-piensa-estudiante-ideas-previas-ciencias-preguntas-diagnostico/">the mistake reveals how the student thinks</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>. To adapt rules for students with learning barriers, <a href="/herramientas/piar/">PIAR with AI</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is the hidden curriculum?</h3>
<p>The norms, values, habits and expectations that school transmits through its daily life, without being written in the study plan. It is associated with Philip Jackson (<em>Life in Classrooms</em>, 1968).</p>
<h3>Is it the same as the explicit curriculum?</h3>
<p>No: the explicit one is what is written (study plan, standards, objectives, SIEE); the hidden one is what is taught implicitly.</p>
<h3>Why does it matter that rules change between grades?</h3>
<p>Because each change requires the student to learn again how the classroom works, and unexplained differences can feel arbitrary. Not every change is a problem: some respond to age.</p>
<h3>Must all rules be unified?</h3>
<p>No: the idea is to agree on common minimums, justify age-based differences and communicate them.</p>
<h3>How do I use the workbook?</h3>
<p>Each grade team marks the real practice, the workbook counts versions and changes, and the teacher group decides what to agree on.</p>

<p class="notice"><strong>Map your own rules.</strong> Download the <a href="/descargas/curriculo-oculto/mapa-expectativas-entre-grados.xlsx">expectations map</a> (in Spanish), replace the practices and grades with your school's and see which transition concentrates the most changes. Then talk with your colleagues about which changes are intentional.</p>

<h2>Food for thought</h2>
<p>Students learn what we say and, above all, what we do. <strong>What message reaches a student who, over four years, receives four different rules about error? And if coherence between grades were a student right, what would have to change in how we teachers coordinate?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:mensajes}}' => $img('curriculo-oculto-mensajes', 499, 'Table with four classroom practices, the message they may convey without saying it and a question to review them.', 'A classroom rule also conveys a message.'),
    '{{img:pasos}}' => $img('curriculo-oculto-pasos', 467, 'Five steps to order rules across grades: map, compare, agree, communicate and review.', 'Five steps to order rules across grades.'),
]);

return [
    'curriculo-oculto-entre-grados-reglas-que-cambian-cada-ano-mapa-expectativas' => [
        'slug' => 'hidden-curriculum-between-grades-rules-that-change-every-year-expectations-map',
        'title' => 'The Hidden Curriculum Between Grades: Rules That Change Every Year Without Anyone Saying So, with an Expectations Map',
        'excerpt' => 'What the hidden curriculum is and how classroom rules and expectations change between grades: an Excel map of ten practices across four grades that counts versions, changes per transition and helps agree on common minimums.',
        'seo_title' => 'Hidden Curriculum Between Grades: Expectations Map',
        'seo_description' => 'What the hidden curriculum is and how classroom rules change between grades, with an Excel expectations map to agree on common minimums among teachers.',
        'focus_keyword' => 'hidden curriculum between grades',
        'cover' => '/assets/img/articulos/curriculo-oculto/curriculo-oculto-portada-en',
        'cover_alt' => 'Cover "The hidden curriculum across grades: rules that change every year without anyone saying" with a card: 13 of 30 grade-to-grade transitions change rules in the example map.',
        'content_html' => $html,
    ],
];
