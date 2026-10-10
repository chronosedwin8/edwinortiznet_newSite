<?php

declare(strict_types=1);

// English version of «Argumentar con evidencia: cómo enseñar a sostener lo que se afirma, con una rúbr…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/argumentar-con-evidencia/' . $name . '-en';
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
<p>Thirty students are asked to write whether school should start later. Almost all answer with a firm opinion: "yes, because we sleep too little" or "no, because we would get out late". Few cite a datum, even fewer explain why that datum supports their opinion, and almost none ask what someone who thinks the opposite would say. They have <strong>positions</strong>, but not <strong>arguments</strong>. And the difference between the two is one of the skills most mentioned when talking about critical thinking and citizenship.</p>
<p>This article analyzes how to teach <strong>arguing from evidence</strong>: what an argument is, what research says about learning by arguing and how to assess written arguments with a five-criterion rubric. It includes an <a href="/descargas/argumentar-con-evidencia/rubrica-argumentacion-evidencia.xlsx">Excel workbook</a> (in Spanish) with ten fictional arguments scored by two readers, verified in Microsoft Excel 16 and against an independent calculation. Sources reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional and the rubric is the author's own example, not an official scale: adjust it with your colleagues and your school's SIEE. Scoring arguments involves judgment, which is why the workbook includes a second reading. Scores are for giving feedback, not for labeling a student.</p>

<h2>What arguing is (and is not)</h2>
<p>An opinion is stated; an argument is <strong>sustained</strong>. The philosopher Stephen Toulmin (<em>The Uses of Argument</em>, 1958) proposed a model still used in teaching: an argument has a <strong>claim</strong> (what is maintained), <strong>data</strong> that support it, a <strong>warrant</strong> that explains why the data support the claim, and may include backing, a qualifier on how certain it is and a <strong>rebuttal</strong> (the conditions under which it would not hold). In science teaching, a simpler framework, <strong>claim, evidence and reasoning</strong> (McNeill, Lizotte, Krajcik and Marx, 2006), has been used to guide students in writing explanations; that study, with 331 seventh-grade students in an eight-week chemistry unit, found that gradually fading written supports favored reasoning once they were gone. Effects depend on age, context and task.</p>
{{img:elementos}}
<p>Research on <em>learning by arguing</em> goes beyond writing: Jonathan Osborne (2010, <em>Science</em>) argues that collaborative, critical discourse, that is, discussing reasons with others, improves conceptual understanding and reasoning skills, and that it is rare in science classes. It is not advice to turn every class into a debate, but to give students regular chances to defend an idea with reasons and to hear an objection.</p>

<h2>A five-criterion rubric</h2>
<p>The workbook's <em>Escala</em> sheet proposes five criteria, each scored 0 to 3: <strong>claim</strong> (is it clear and does it answer the question?), <strong>evidence</strong> (is it relevant, sufficient and verifiable?), <strong>reasoning</strong> (does it explain why the evidence supports the claim?), <strong>counterargument</strong> (does it consider other positions and answer them?) and <strong>sources</strong> (are they identified, dated and evaluated?). Each level has a descriptor, so the student knows what is expected (see <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a>). The total (0 to 15) is grouped into three example levels (12 or more "Sólido" [solid], 8 to 11 "En desarrollo" [developing], below 8 "Inicial" [initial]), with editable cut-offs.</p>
<pre><code>' Total and level of an argument (scores in B:F; cut-offs in Parametros!B3 and B4)
=SUM(B4:F4)                                                                           ' English
=IF(G4>=Parametros!$B$3,"Sólido",IF(G4>=Parametros!$B$4,"En desarrollo","Inicial"))   ' English
=SUMA(B4:F4)                                                                          ' Spanish
=SI(G4>=Parametros!$B$3;"Sólido";SI(G4>=Parametros!$B$4;"En desarrollo";"Inicial"))   ' Spanish

' A student's weakest criterion (in a tie, the first)
=INDEX($B$3:$F$3,MATCH(MIN(B4:F4),B4:F4,0))                                            ' English
=INDICE($B$3:$F$3;COINCIDIR(MIN(B4:F4);B4:F4;0))                                       ' Spanish

' Identical scores between two readers (50 scores)
=SUMPRODUCT(--(Lectura_A!B4:F13=Lectura_B!B4:F13))                                     ' English
=SUMAPRODUCTO(--(Lectura_A!B4:F13=Lectura_B!B4:F13))                                   ' Spanish</code></pre>

<h2>What the example showed (fictional data)</h2>
{{img:perfil}}
<p>Ten written arguments, scored with the rubric by teacher A:</p>
<ul>
<li><strong>Levels:</strong> 2 solid, 5 developing and 3 initial; totals range from 3 to 14 out of 15.</li>
<li><strong>Class profile:</strong> claim 2.4, evidence 2.2, sources 1.7, reasoning 1.5 and <strong>counterargument 0.8</strong>. The class claims well and cites data, but struggles to explain why the data support its idea and barely considers objections: <strong>4 of 10 arguments have no counterargument at all</strong>. For 7 of the 10 students, the weakest criterion is the counterargument.</li>
<li><strong>Second reading:</strong> teacher B scored the same 10 arguments without seeing reading A. Of 50 scores, 44 match (88%), 4 differ by one point and <strong>2 differ by two points</strong>, so exact-or-adjacent agreement is 96%. Those two discrepancies are the ones worth discussing to refine the descriptors.</li>
</ul>
<p><strong>An honest reading:</strong> 88% agreement with ten arguments does not prove the rubric is reliable: it is an example of how to check it with your own team. With little data, a couple of changes shift the percentages, and agreement between two readers does not prove both measure what matters. Also, a rubric reduces an argument's richness to five numbers: use it to guide feedback, and read the text.</p>

<h2>How to teach it in the classroom</h2>
<ol>
<li><strong>Start from a question with possible answers</strong> and real data at hand (a table, a chart, two texts that contradict each other). Without data, there is no evidence to assess.</li>
<li><strong>Separate the elements with scaffolds:</strong> prompts like "I claim...", "the data show...", "this means that...", "someone might object...". Fade them gradually, so the student can argue without them.</li>
<li><strong>Train reasoning separately.</strong> Show two arguments with the same evidence and different reasoning, and ask which connects better.</li>
<li><strong>Make the counterargument a routine:</strong> each student writes the best objection to their own thesis and how they would answer. It is the weakest criterion in the example and the hardest, and it is respectful of the opposing position.</li>
<li><strong>Score one criterion at a time at first,</strong> and share examples of each level (see <a href="/error-revela-como-piensa-estudiante-ideas-previas-ciencias-preguntas-diagnostico/">the error as a window into student thinking</a>).</li>
<li><strong>Calibrate with colleagues:</strong> score the same five arguments separately and compare, as the workbook's second reading does.</li>
</ol>
<p><strong>Artificial intelligence changes the task.</strong> An AI assistant can produce in seconds a text that looks like an argument, with "data" that are sometimes invented. That makes it more valuable to teach checking evidence and sources (criterion 5), and defending the argument orally or with follow-up questions, not just handing in a text (see <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into a free AI</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, national references (the Basic Competency Standards and the Saber tests) mention reasoning and argumentation among the competencies expected to develop (for example, in math tests), and the Saber 11 critical reading test aims, among other things, at assessing the content and arguments of texts; check the current frameworks from the Ministry and ICFES. In Latin America, argumentation appears in language, science and citizenship curricula, although classroom practice tends to be more expository; worldwide, "argumentation" and "dialogic discourse" programs have shown benefits in certain contexts and also the difficulties of scaling them without teacher training.</p>
<p>For <strong>teachers</strong>, the challenge is time and tolerance for discussion; for <strong>principals</strong>, common criteria across subjects so rules do not change every year (see <a href="/curriculo-oculto-entre-grados-reglas-que-cambian-cada-ano-mapa-expectativas/">the hidden curriculum between grades</a>); for <strong>families</strong>, accepting that a child who "argues" with reasons is learning; and for <strong>students</strong>, that changing one's mind in the face of a good reason is part of arguing, not a defeat. Discussions must protect respect and classroom climate, and sensitive topics require prior agreements.</p>

<h2>Tools and templates</h2>
<p>To plan argumentation activities, rubrics and follow-up questions, and to organize your resources with AI (always reviewing what it produces and without including student data in tools not designed to safeguard it), look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: the <a href="/descargas/argumentar-con-evidencia/rubrica-argumentacion-evidencia.xlsx">argumentation rubric workbook</a>, <a href="/transferencia-del-aprendizaje-que-lo-aprendido-sirva-fuera-del-aula-plantilla/">transfer of learning</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Frequently asked questions</h2>
<h3>What is the difference between an opinion and an argument?</h3>
<p>An opinion is stated; an argument is sustained with evidence and reasoning that explains why the evidence supports the claim, and it considers objections.</p>
<h3>What is Toulmin's model?</h3>
<p>A model by Stephen Toulmin (1958) that describes an argument with claim, data, warrant, backing, qualifier and rebuttal. In the classroom it is often simplified to claim, evidence and reasoning.</p>
<h3>From what age can arguing be taught?</h3>
<p>From primary school, with simple scaffolds ("I think... because..."), raising the demand with age. Effects vary with context and task.</p>
<h3>How do I stop a student from using AI to write the argument?</h3>
<p>Ask them to verify and cite sources, to defend the argument orally or answer follow-up questions, and assess the process, not just the text.</p>
<h3>How do I use the workbook?</h3>
<p>Enter the scores (0 to 3) for each criterion and each student, and, if you wish, those of a second reading; the workbook calculates totals, levels, the class profile and agreement between readers.</p>

<p class="notice"><strong>Try it with a text from your class.</strong> Download the <a href="/descargas/argumentar-con-evidencia/rubrica-argumentacion-evidencia.xlsx">rubric workbook</a> (in Spanish), score ten of your students' arguments (and ask a colleague to score the same ones), and see the group's weakest criterion.</p>

<h2>Food for thought</h2>
<p>Teaching to argue means accepting that students question, even our own claims. <strong>When was the last time a student presented you with an objection to what you taught, and how did you receive it? And if we also assessed how students listen and respond to others' reasons, what would change in our classes?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:elementos}}' => $img('argumentar-con-evidencia-elementos', 499, 'Table with four elements of an argument, the question each answers and an example prompt: claim, evidence, reasoning and counterargument.', 'From opinion to argument.'),
    '{{img:perfil}}' => $img('argumentar-con-evidencia-perfil', 480, 'Bar chart of the average per rubric criterion: claim 2.4, evidence 2.2, reasoning 1.5, counterargument 0.8 and sources 1.7.', 'Class profile: counterargument is the weakest criterion.'),
]);

return [
    'argumentar-con-evidencia-ensenar-afirmacion-razonamiento-contraargumento-rubrica-excel' => [
        'slug' => 'arguing-from-evidence-teaching-claim-reasoning-counterargument-rubric-excel',
        'title' => 'Arguing from Evidence: How to Teach Students to Back Up What They Claim, with a Rubric and an Excel Workbook',
        'excerpt' => 'What an argument is, what research says about learning by arguing and how to assess claim, evidence, reasoning, counterargument and sources with a rubric and an Excel workbook with two readings.',
        'seo_title' => 'Arguing from Evidence: Rubric and Excel Workbook',
        'seo_description' => 'How to teach arguing from evidence: claim, reasoning and counterargument, with a five-criterion rubric and an Excel workbook with two readings.',
        'focus_keyword' => 'arguing from evidence',
        'cover' => '/assets/img/articulos/argumentar-con-evidencia/argumentar-con-evidencia-portada-en',
        'cover_alt' => 'Cover "Arguing from evidence: teaching students to back up what they claim" with a card: 0.8 of 3 is the counterargument average, the weakest criterion in the example class.',
        'content_html' => $html,
    ],
];
