<?php

declare(strict_types=1);

// English version of «Conflicto, indisciplina y violencia escolar: tres cosas distintas, los tipos I, …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/convivencia-escolar/' . $name . '-en';
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
<p>"It is indiscipline." "No, it is bullying." "That is a normal conflict, let them sort it out." In the staff room, the three sentences are said about the same situation with total certainty, and which one is chosen determines what is done: a conversation, a sanction, a record, a report to the family, a call to the Police. <strong>Confusing conflict, indiscipline and violence is not a vocabulary problem: it is the source of wrong responses, both too little and too much.</strong></p>
<p>This article distinguishes the three concepts based on Colombia's Law 1620 of 2013 and Decree 1965 of 2013 (now compiled in Single Regulatory Decree 1075 of 2015), explains the classification of situations into Type I, II and III and offers an <a href="/descargas/convivencia-escolar/clasificador-situaciones-convivencia.xlsx">Excel classifier</a> (in Spanish) with eight fictional cases to practice the reasoning, with the response routes summarized. Texts verified on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> This is a <strong>training</strong> tool, not a decision tool: the classification of a real situation is analyzed by the School Coexistence Committee with the coexistence manual and, when appropriate, the competent authorities. The cases are fictional; <strong>do not write real names or data of students</strong> in the workbook or in any tool not designed to safeguard them. This is not legal or psychological advice. If there is an immediate risk to a child or adolescent, act under your institution's protocol and go to the authorities; in Colombia, ICBF's 141 line takes reports of violations of minors' rights (verify its current availability).</p>

<h2>Three concepts, three responses</h2>
<ul>
<li><strong>Conflict.</strong> Under Decree 1075 of 2015 (art. 2.3.5.4.2.5), it is a real or perceived incompatibility between people regarding their interests. It is normal, inevitable and can be a learning opportunity: two students who cannot agree on a group assignment are in conflict, not in aggression. A conflict becomes a coexistence problem when it is handled inadequately and gives rise to altercations, confrontations or fights (without harm to body or health).</li>
<li><strong>Indiscipline.</strong> It is not a term defined in Law 1620. In school language it refers to breaking the coexistence manual's rules (arriving late, using the phone in class, not bringing materials). It is handled with the manual's procedure, which must respect due process, the right to defense and proportionality between the fault and the measure (arts. 2.3.3.1.4.4 and 2.3.5.4.2.7). A fault of this kind is not, by itself, an aggression or a conflict.</li>
<li><strong>School aggression and violence.</strong> School aggression is any action by members of the educational community that seeks to negatively affect others, at least one of whom is a student: it can be physical, verbal, gestural, relational or electronic. <strong>School bullying</strong> is negative, intentional, methodical and systematic conduct of aggression, intimidation, humiliation or isolation, repeated or sustained over time, by peers with an asymmetric power relationship; <strong>cyberbullying</strong> does it with information technologies. A single punch can be aggression without being bullying; bullying requires repetition and an imbalance of power.</li>
</ul>
<p>The difference matters because each asks for a different response: for conflict, mediation and skill-building; for indiscipline, the manual's procedure; for aggression and bullying, protection of the affected person, health care if there is harm, work with the family and measures with the committee, and, if there is a crime, the authorities.</p>

<h2>The Type I, II and III classification</h2>
<p>Article 2.3.5.4.2.6 of Decree 1075 (art. 40 of Decree 1965 of 2013) classifies into three types the situations that affect school coexistence and the exercise of human, sexual and reproductive rights:</p>
{{img:tipos}}
<ul>
<li><strong>Type I:</strong> mishandled conflicts and sporadic situations that negatively affect the school climate and in no case cause harm to body or health.</li>
<li><strong>Type II:</strong> situations of school aggression, bullying and cyberbullying that do not have the characteristics of a crime and meet either of these: they occur repeatedly or systematically, or they cause harm to body or health without causing disability to any of those involved.</li>
<li><strong>Type III:</strong> situations of school aggression that constitute alleged crimes against sexual freedom, integrity and formation (Title IV of Book II of Law 599 of 2000) or any other crime under Colombian criminal law.</li>
</ul>
<p><strong>The minimum protocols</strong> (arts. 2.3.5.4.2.8 to 2.3.5.4.2.10), in summary: in Type I, immediately gather the parties, mediate pedagogically, set an impartial and fair solution, leave a record and follow up. In Type II, guarantee health care if there is harm, refer to administrative authorities if rights must be restored, protect those involved, immediately inform parents or guardians, create spaces for them to explain what happened, determine restorative actions and consequences, and have the committee keep minutes and follow up. In Type III, immediate health care if there is harm, inform parents or guardians, have the committee's president report the situation to the National Police by the quickest means, and have the committee immediately adopt the establishment's own protection measures. Always with confidentiality, written records and reporting in the unified school coexistence information system. The complete protocol, with its steps and deadlines, must be in each school's coexistence manual.</p>

<h2>The classifier: eight fictional cases</h2>
<p>For each case, the workbook asks for seven Yes or No answers (is there a disagreement of interests, is there aggression, is it repeated, is there harm, is there disability, could it be a crime, does it break a manual rule) plus whether the conflict escalated to an altercation, and returns an indicative classification and the protocol's first step. It is a way of training the reasoning:</p>
{{img:preguntas}}
<ol>
<li><strong>A shove in line over a turn, once, no injury:</strong> Type I (mishandled conflict; sporadic and without harm).</li>
<li><strong>Offensive nicknames for a classmate over several weeks:</strong> Type II (repeated verbal aggression: possible bullying).</li>
<li><strong>A fistfight with a bleeding nose, once, no disability:</strong> Type II (physical aggression with harm to the body, without disability).</li>
<li><strong>A fight with a fracture that causes disability:</strong> Type III (harm with disability exceeds Type II).</li>
<li><strong>Spreading a classmate's intimate photos online:</strong> Type III (electronic aggression with a possible crime).</li>
<li><strong>Repeated lateness and phone use in class:</strong> coexistence manual fault (indiscipline); handled by the manual's procedure.</li>
<li><strong>Disagreement over splitting tasks in a group assignment:</strong> conflict without escalation; mediate before it escalates.</li>
<li><strong>Repeated threats in a group chat:</strong> Type II (cyberbullying: repeated electronic aggression).</li>
</ol>
<p>The workbook's result: 1 Type I case, 3 Type II, 2 Type III, 1 conflict to mediate and 1 manual fault (verified in Excel). Two warnings for use. First, <strong>the tool classifies on the basis of what it is told</strong>: if the key fact is uncertain (was there disability? is it a crime?), the answer is not to guess but to consult whoever is responsible, and in case of doubt about a possible crime against a minor, not to wait. Second, the classification does not exhaust the pedagogical response: a Type II case also requires work with the class, with families and with the context.</p>

<h2>What usually goes wrong</h2>
<ul>
<li><strong>Treating bullying as a conflict between equals.</strong> In bullying there is an asymmetric power relationship by legal definition; putting the victim and the aggressor face to face "to sort it out" can revictimize. Forms of repair must be designed carefully and with professional support.</li>
<li><strong>Treating indiscipline as violence</strong> (or vice versa). Taking a minor fault to the committee or ignoring an aggression because it is "indiscipline" are symmetric mistakes.</li>
<li><strong>Sanctioning without due process.</strong> The manual must provide the right to defense, and consequences must be proportionate (art. 2.3.5.4.2.7, item 5).</li>
<li><strong>Not leaving a record or following up.</strong> The decree requires minutes and follow-up to verify whether the solution was effective.</li>
<li><strong>Confusing confidentiality with silence.</strong> The parties' privacy is protected, but families and authorities are still informed when appropriate.</li>
</ul>

<h2>Colombia, Latin America and the world</h2>
<p>Law 1620 of 2013 created the National System of School Coexistence and Training for the Exercise of Human Rights, Sexuality Education and the Prevention and Mitigation of School Violence, with a comprehensive care route comprising promotion, prevention, care and follow-up, and with coexistence committees in every school. Worldwide, school bullying is a documented problem: according to the OECD's PISA 2018 results, on average 23% of students in OECD countries reported being bullied at least a few times a month; for Colombia, the press reported higher figures in that cycle (for example, 32% according to one outlet, a figure I could not cross-check against the OECD table under the same definition, so consult the report; see <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA in Latin America</a>). For <strong>teachers</strong>, the challenge is to observe and record rigorously, without judging; for <strong>principals</strong>, to make the committee work, the manual clear and the routes known; for <strong>families</strong>, to accompany and trust the procedures, knowing they will be informed; and for <strong>students</strong>, to know there are adults to turn to. For students with disabilities or learning barriers, who are at higher risk of being victims, see <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusion in the classroom</a> and the <a href="/herramientas/piar/">PIAR with AI</a> tool.</p>

<h2>Tools and reading</h2>
<p>To plan citizenship and coexistence activities, and to organize your resources with AI (always reviewing what it produces and without including student data in tools not designed to safeguard it), look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,piar-con-ia-5-planes}}
<p>Keep reading: <a href="/calificaciones-miden-aprendizaje-o-cumplimiento-reglas-colegio/">grades: learning or compliance</a>, <a href="/retroalimentacion-que-cambia-el-aprendizaje-banco-ejemplos-rubrica/">feedback that changes learning</a> and <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into an AI tool</a>. For those preparing for the Teacher Competition, Law 1620 and Decree 1965 are studied in an article of the February normative series.</p>

<h2>Frequently asked questions</h2>
<h3>What is the difference between conflict and aggression?</h3>
<p>Conflict is an incompatibility of interests; aggression is an action that seeks to negatively affect another. A conflict can lead to aggression if handled badly, but they are not the same.</p>
<h3>When is it bullying and not just a fight?</h3>
<p>When the conduct is intentional, methodical and systematic, repeated or sustained over time, and there is an asymmetric power relationship between the one who aggresses and the one aggressed.</p>
<h3>What type of situation is a fight with injuries?</h3>
<p>It depends: with harm to body or health without disability, Type II; if it causes disability or constitutes a crime, Type III. The school coexistence committee analyzes the classification.</p>
<h3>Is indiscipline in Law 1620?</h3>
<p>Not as a defined term. It is handled by the coexistence manual, with due process and proportionality.</p>
<h3>Who classifies a situation?</h3>
<p>The School Coexistence Committee, based on the school's manual and protocols, activating the authorities when there is a possible crime.</p>

<p class="notice"><strong>Practice with fictional cases.</strong> Download the <a href="/descargas/convivencia-escolar/clasificador-situaciones-convivencia.xlsx">situation classifier</a> (in Spanish), solve the cases by hand first and then compare with the workbook's classification. And check whether your school's protocol covers all three types.</p>

<h2>Food for thought</h2>
<p>Naming a situation well is the first act of care, because what we do and whom we protect depend on it. <strong>How many times have we called "boys will be boys" what was bullying, or "violence" what was a conflict nobody knew how to mediate? And when an institution classifies situations mainly to protect itself, what happens to the person who is suffering?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tipos}}' => $img('convivencia-escolar-tipos', 444, 'Table with the three types of school coexistence situations, what each is and the first step: Type I, Type II and Type III.', 'The three types of situation.'),
    '{{img:preguntas}}' => $img('convivencia-escolar-preguntas', 467, 'Five questions to classify a situation: is there a disagreement, an aggression, is it repeated or harmful, a possible crime and activate the route.', 'Five questions, in order.'),
]);

return [
    'conflicto-indisciplina-violencia-escolar-diferencias-tipos-i-ii-iii-clasificador' => [
        'slug' => 'conflict-indiscipline-school-violence-differences-types-i-ii-iii-classifier',
        'title' => 'Conflict, Indiscipline and School Violence: Three Different Things, Types I, II and III and a Classifier with Cases',
        'excerpt' => 'How to distinguish a conflict, an indiscipline fault and school aggression or bullying under Law 1620 and Decree 1075, what Types I, II and III mean and the first step of each protocol, with a classifier of fictional cases.',
        'seo_title' => 'Conflict, Indiscipline and School Violence: Types I-III',
        'seo_description' => 'Difference between conflict, indiscipline and bullying under Law 1620 and Decree 1075: Type I, II and III situations, protocols and a case classifier.',
        'focus_keyword' => 'conflict indiscipline school violence',
        'cover' => '/assets/img/articulos/convivencia-escolar/convivencia-escolar-portada-en',
        'cover_alt' => 'Cover "Conflict, indiscipline and violence: three different things not handled the same way" with a card: the three classes of Type I, II and III situations of Decree 1965 of 2013.',
        'content_html' => $html,
    ],
];
