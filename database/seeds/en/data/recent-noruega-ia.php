<?php

declare(strict_types=1);

// English version of «Noruega y la IA en la escuela: ¿prohibió de verdad la inteligencia artificial a …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/noruega-ia/' . $name . '-en';
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
<p>Since June 20, 2026, a headline has been shared thousands of times: <strong>"Norway becomes the first country to ban the use of artificial intelligence for children aged 6 to 13 and bets on the return of paper books"</strong>. It sounds forceful, it has an attractive line ("first learn to read, write, think and reason; then use technology") and it arrives just when many teachers and families wonder what to do about AI. The honest question is: <strong>how true is it?</strong></p>
<p>I went to the sources: the Norwegian Directorate for Education and Training (Udir) official page, the coverage of Norway's public broadcaster (NRK), the teachers' union reaction and the OECD data on the country's educational quality. The verdict in one line: <strong>the essentials are true, but the headline exaggerates on three points: it is not a legal ban but a national recommendation, I could not confirm it is "the first country" and "the return to paper books" is, for now, a bill proposal</strong>. The case also serves to review a bigger myth: that of "model" countries in education. I include an <a href="/descargas/noruega-ia/verificador-titular-noruega-ia-escuela.xlsx">Excel workbook</a> (in Spanish) that breaks the headline down claim by claim (verified in Microsoft Excel 16 and against an independent calculation). Sources reviewed on <strong>October 17, 2026</strong>.</p>
<p class="notice"><strong>Warning.</strong> The Norwegian government page with the June 19 press release would not open from my research system; I rely on Udir's official page, on NRK and on a site that summarizes the official sources, and I translate from Norwegian (translations are mine). The workbook's verdicts are <strong>my judgment</strong> on those sources, not published data.</p>

<h2>What exactly Norway said</h2>
<ul>
<li><strong>June 19, 2026:</strong> at his semiannual press conference, Prime Minister Jonas Gahr Støre announced that the government will recommend that artificial intelligence "essentially not be used" in primary school. He said uncritical use of AI "increases the risk of skipping important steps in learning" and that, "at the same time, school results and students' skills are falling".</li>
<li><strong>June 25, 2026:</strong> the Directorate for Education and Training (Udir), commissioned by the Ministry of Education, published the new advice by stage. According to its page (updated October 12, 2026), the recommendation rests on available knowledge and on the <strong>precautionary principle</strong>.</li>
<li><strong>Education Minister Kari Nessa Nordtun:</strong> "Students must learn to read, write and calculate before using AI. They must have good relationships with their teacher and classmates. The youngest do not have the knowledge, critical reflection or self-regulation needed to use it well", and "we must not make the same mistake as when digital devices were introduced uncritically among the youngest".</li>
</ul>
{{img:etapas}}
<p>Three clarifications the headline omits:</p>
<ol>
<li><strong>It is a recommendation, not a law.</strong> In Norway school management is local (municipalities run them) and the government acts through Udir recommendations, which schools are "expected" to follow. The same mechanism was used for phones in 2024. So the word "ban" is inaccurate, although in practice it may weigh almost like a rule.</li>
<li><strong>Exceptions are foreseen.</strong> The minister said students who, for various reasons, need AI-based tools will get them: she mentions language teaching and individualized education. Udir said it will detail exceptions; its October 12 page still speaks of recommendations "in preparation", and I could not confirm that the expanded text has been published.</li>
<li><strong>Students keep learning <em>about</em> AI.</strong> The recommendation concerns students' <em>access</em> to generative AI, not teaching how it works and what effects it has on society, which the curriculum supports.</li>
</ol>

<h2>Checking the headline, claim by claim</h2>
{{img:afirmaciones}}
<table>
<thead><tr><th>Claim</th><th>Verdict</th><th>Why</th></tr></thead>
<tbody>
<tr><td>"Bans AI use for children"</td><td>Partly true</td><td>It is a national recommendation (not a law) that in grades 1 to 7 students "essentially" have no access to generative AI; with exceptions.</td></tr>
<tr><td>"It is the first country to do so"</td><td>Unsupported</td><td>According to China Daily, in May 2025 China barred primary students from independently using open-ended generative AI tools (other sources describe it as supervised use). And New York decreed on September 2, 2026 a one-year moratorium through 8th grade. Norway may be among the first in Europe, but I could not confirm it.</td></tr>
<tr><td>"Aged 6 to 13"</td><td>Confirmed</td><td>Grades 1 to 7 of Norwegian primary school correspond to those ages.</td></tr>
<tr><td>"Bets on the return of paper books"</td><td>Partly true</td><td>The prime minister announced the government will propose by law that basic schools have access to printed materials. It is a proposal; and the teachers' union asks for "a variety of materials", printed and digital.</td></tr>
<tr><td>"First read, write, think and reason"</td><td>Confirmed (with a nuance)</td><td>The minister spoke of reading, writing and calculating; "think and reason" is the headline's paraphrase.</td></tr>
<tr><td>"Without replacing fundamental human capacities"</td><td>Partly true</td><td>It is the government's argument, reasonable but with little direct evidence on children aged 6 to 13 (see below).</td></tr>
</tbody>
</table>
<p>The Excel workbook gathers these claims, with a support score and a weight for each, and calculates an overall reading. With my values, the weighted average support is <strong>54.5 out of 100: a headline "with exaggerations"</strong>, not a false one.</p>
<pre><code>' Weighted average support (Resumen sheet)
=SUMPRODUCT(Afirmaciones!F4:F9,Afirmaciones!G4:G9)/SUM(Afirmaciones!G4:G9)           ' English
=SUMAPRODUCTO(Afirmaciones!F4:F9;Afirmaciones!G4:G9)/SUMA(Afirmaciones!G4:G9)        ' Spanish

' Verdict of each claim (thresholds editable in the Parametros sheet)
=IF(F4>=Parametros!$B$3,"Confirmada",IF(F4>=Parametros!$B$4,"Parcialmente cierta","No respaldada"))   ' English
=SI(F4>=Parametros!$B$3;"Confirmada";SI(F4>=Parametros!$B$4;"Parcialmente cierta";"No respaldada"))   ' Spanish</code></pre>

<h2>The context: why Norway acted</h2>
<p>The measure did not come out of nowhere. According to Udir's "Questions to Skole-Norge" survey (January 2026), <strong>about eight in ten basic education schools already used AI tools</strong> (65% of primary and 89% of lower secondary schools), <strong>there was no national minimum age</strong>, only two in ten schools had set one on their own and 16% of primary schools gave access to AI as early as grades 1 to 4. Also, 75% of schools had no plan for using it. In other words: AI was already in the youngest classrooms, with no rules. Among teachers, per TALIS 2024 (OECD), 40% used AI in their work (OECD average: 36%), mostly to summarize and learn about a topic (65%) and generate lesson plans (57%); only 19% used it to assess work. Norway appears with an asterisk in that survey: its participation fell below the standard and comparisons should be read with caution.</p>
{{img:udir}}
<p>Earlier, in February 2024, Udir had recommended removing phones from classrooms; in 2026, according to the same survey, 62% of schools ask students to hand in their phones at the start of the day. And the Norwegian government is preparing a social media minimum-age law (public consultation between July and October 2025; the bill would go to Parliament by the end of 2026 at the latest). As in other cases, there is a pattern: <strong>Norway first recommends, then measures and sometimes legislates</strong>.</p>

<h2>The quality of education in Norway: what the data show</h2>
<p>Norwegian school is compulsory for ten years, from age 6 to 16: seven years of primary (grades 1 to 7) and three of lower secondary (grades 8 to 10), run by municipalities, overseen by county governors, with a curriculum renewed since 2020. The country is among those that spend the most per student in rankings based on <em>Education at a Glance</em> (figures vary by source). But spending a lot is not the same as getting high results:</p>
{{img:pisa}}
<ul>
<li><strong>PISA 2022:</strong> according to the OECD, Norway scored close to the average in math and reading, and below it in science; in math it was the lowest value in its entire PISA history.</li>
<li><strong>PISA 2025</strong> (released September 8, 2026): Norway scored <strong>452 in math, 453 in reading and 470 in science</strong>, below the OECD average (463, 461 and 482) in all three areas. Compared with 2022, it fell about 17 points in math and 24 in reading (in science, 8 points, not statistically significant). According to the Nordic Council, it is the first time since 2006 it is below the average in all three. The OECD marks Norway with an asterisk in its tables, which invites reading the data with caution.</li>
</ul>
<p>The prime minister himself said it: "school results and students' skills are falling". That is the context of the measure: <strong>the reaction of a system watching its results fall and looking for a lever</strong>. It should be said clearly: <strong>there is no evidence that AI caused that decline</strong>. PISA results fell in many countries before generative AI reached classrooms, and are usually explained by several factors (the pandemic, reading, attention and screen use, among others). AI is a possible explanation, not a proven one.</p>

<h2>Are its laws aligned with education and technology?</h2>
<ul>
<li><strong>Local autonomy, national recommendations.</strong> No law sets a minimum age for students to use AI. The coherence is in the method: a Udir recommendation, the decision of the municipality and school, and data protection oversight. Udir reminds that personal data law requirements always apply when data are processed, and that the school must use secure solutions assessed and approved by its owner. In Udir's survey, nine in ten schools say they have checked the privacy of AI tools.</li>
<li><strong>The AI law does not yet apply in Norway.</strong> The EU AI Regulation has to be incorporated into the EEA Agreement and Norwegian law; according to consultancies' and law firms' analyses, the plan was to have the law in late summer 2026 and it slipped: there would be a new consultation in autumn 2026 and a bill to Parliament in spring 2027. This is second-hand information; it should be checked against the official source.</li>
<li><strong>Social media.</strong> There has been a 13-year limit since 2018 (with parental permission for minors) and a bill to raise it to 15 with age verification, not yet approved.</li>
<li><strong>Books.</strong> The Book Act took effect on January 1, 2024 and guarantees a fixed price for 12 months for each new book; a cultural policy that protects small bookshops. The 2026 proposal runs along the same lines: schools having printed books as a right.</li>
</ul>
<p><strong>Critical reading:</strong> Norwegian laws are not "aligned with AI in school" in the sense of a specific rule: there is general data regulation, a culture of recommendations and a clear political intention. The apparent contradiction (barring AI for ages 6 to 13 while having schools that already used it) is explained by the earlier vacuum, not by incoherence.</p>

<h2>The culture: reading, screen-free time and local trust</h2>
<p>What the Norwegian case reveals is an educational policy culture with recognizable traits:</p>
<ul>
<li><strong>Caution before enthusiasm:</strong> Udir bases its recommendation on the precautionary principle. The minister acknowledges a past mistake: introducing devices "uncritically" among the youngest.</li>
<li><strong>Trust in the local level:</strong> the State recommends and schools are expected to follow, without imposing it by law.</li>
<li><strong>A book policy:</strong> fixed prices, reading and printed materials as a cultural matter, not only a pedagogical one.</li>
<li><strong>A teacher voice that adds nuance:</strong> the president of the Utdanningsforbundet union, Geir Røsvoll, supports having national guidelines, but says removing AI access for all primary students "seems very intrusive" and that there is still a debate to have about when to introduce it. He asks for a "variety of materials", not only printed books, and argues that what teachers need is "time to do their job".</li>
</ul>

<h2>And the evidence? What we know (and do not) about AI and young children</h2>
<ul>
<li><strong>Used without guardrails, AI can harm:</strong> in a trial with nearly a thousand secondary students in Turkey (Bastani et al., <em>PNAS</em>, 2025), free access to GPT-4 improved practice performance and worsened the later exam without AI by 17%; a tutor with safeguards mitigated the harm. The OECD (<em>Digital Education Outlook 2026</em>) warns that better performance is not learning.</li>
<li><strong>Designed to teach and with a teacher, it can help:</strong> at Harvard (194 physics students) and in Nigeria (800 secondary students, with teachers mediating) there were gains; in both cases with students older than 13 and in short studies.</li>
<li><strong>With children aged 6 to 13, direct evidence is scarce.</strong> I found no studies measuring the effect of generative AI in that age group. UNESCO (2023) proposes a minimum age for students' independent conversations with generative AI (13 is often cited), and Common Sense Media rated social AI companions "unacceptable" for under-18s in 2025.</li>
<li><strong>Paper books versus screens:</strong> Delgado and colleagues' meta-analysis (2018, <em>Educational Research Review</em>; 54 studies and 171,055 participants) found a small advantage of paper reading for comprehension (g = −0.21), larger under time pressure and with informational texts, and not with narrative texts. It is a modest effect, and not the same as proving that AI "harms" reading.</li>
</ul>
<p><strong>Critical reading.</strong> Norway's measure is a reasonable <strong>precautionary bet</strong>: the cost of waiting is low if children first learn to read, write and calculate, and the cost of being wrong could be higher. But it is not a closed scientific conclusion, and it has a cost: well-used AI can support students with special needs or language learning, which is why the government itself foresees exceptions. It works better as a hypothesis than as a model: <strong>what would be valuable is for Norway to evaluate it</strong>.</p>

<h2>The myth of "model" countries in education</h2>
<p>The case dismantles two comfortable ideas. The first: that the Nordic countries are, by definition, the best. In PISA 2025 Norway is below the OECD average in all three areas; its system stands out for other things (investment, local management, wellbeing), not for leading the tests. The second: that "what Norway does" can be copied. <strong>What deserves copying is the method</strong>: acting with caution, relying on the available evidence, saying what is and is not known, listening to the union and reviewing the measure. Not the headline. I already reviewed these ideas in <a href="/finlandia-sistema-educativo-mito-o-realidad/">Finland: myth or reality?</a> and in <a href="/mejores-sistemas-educativos-del-mundo-colombia/">the world's best education systems and what Colombia lacks</a> (both in Spanish).</p>
<p>A counterpoint: Sweden, another Nordic country, announced in 2023 a shift toward printed books and fewer screens for the youngest, citing its falling reading results; the debate is similar (is it the cause or one of several?) and reports on the scientific backing rely on experts' statements more than on causal studies.</p>

<h2>Colombia, Latin America and the world</h2>
<p><strong>Colombia:</strong> in PISA 2025 it scored 381 in math, 399 in reading and 414 in science (OECD: 463, 461 and 482), with no statistically significant changes from 2022; according to the press, 71% of students did not reach the minimum level in math. While Norway debates <em>limiting</em> AI in primary school, Colombian teachers use it more than Norwegian ones (53% versus 40%, TALIS 2024) and report a lack of infrastructure (76% among non-users). Law 2626 of 2026 brings AI in as content in Technology and Informatics, but <strong>I found no national rule or recommendation on AI use by basic-education students by age</strong>; the Ministry's Decalogue (2026) is for higher education.</p>
<p><strong>Latin America:</strong> Brazil (56%), Chile (55%) and Costa Rica (52%) use AI in the classroom almost as much as Colombia. <strong>The world:</strong> China (2025 guidelines), New York (2026 moratorium) and Norway (2026 recommendation) are moving toward more caution with the youngest; UNESCO asks for minimum ages and a human-centred approach.</p>
<p>For <strong>teachers</strong>, the lesson is that a restriction does not exempt them from training: students will keep learning <em>about</em> AI. For <strong>principals</strong>, that 75% of Norwegian schools had no plan: the vacuum is the risk. For <strong>families</strong>, that "AI" ranges from a homework helper to a conversational companion, with very different risks. And for <strong>students</strong>, that they be given the reason, not just the rule.</p>

<h2>What your school can do, without waiting for a law</h2>
<p>The point is not to copy Norway, but to <strong>decide with judgment</strong>. A proposal of mine, to adjust to your context:</p>
<ol>
<li><strong>Define in writing a scale of use by age and task:</strong> in the first grades, no generative AI accounts for students (the teacher uses it to prepare); in middle grades, teacher-guided demonstrations; in the last, gradual use with clear rules and evidence of the process (see the <a href="/guia-uso-inteligencia-artificial-educacion-evidencia-normas-colombia-matriz-excel/">guide to using AI in education</a>, in Spanish).</li>
<li><strong>Foresee exceptions from the start:</strong> students with reasonable adjustments or support needs (see <a href="/herramientas/piar/">PIAR with AI</a>) may need tools others do not.</li>
<li><strong>Check privacy before the first use:</strong> no students' personal data in tools not designed to safeguard them.</li>
<li><strong>Train teachers first</strong>, as Udir asks for grades 8 to 10: no rule works if those who must apply it do not understand it.</li>
<li><strong>Define how you will measure whether it worked</strong> (reading, writing, calculation, coexistence) and review the decision in six months.</li>
<li><strong>Keep teaching <em>about</em> AI</strong>: what it is, how it errs and how it affects people, also in grades where its use is restricted.</li>
</ol>

<h2>Tools and resources</h2>
<p>If you want to explore AI as support for the teacher (planning, material and assessment), with human review always present, take a look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,generador-de-examenes-ia-esencial}}
<p>Keep reading: <a href="/descargas/noruega-ia/verificador-titular-noruega-ia-escuela.xlsx">the headline-checker workbook</a> (in Spanish), <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">phones at school: banning is not enough, we have to teach</a>, <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA and Latin America</a>, <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">AI will not replace you, whoever masters it will</a> (all in Spanish), and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Sources consulted (October 17, 2026)</h2>
<ul>
<li><strong>Norwegian Directorate for Education and Training (Udir),</strong> <a href="https://www.udir.no/kvalitet-og-kompetanse/digitalisering-skole/kunstig-intelligens-i-skolen/kommer-nye-rad-om-bruk-av-kunstig-intelligens-pa-ulike-trinn/">Nye anbefalinger om tilpasset bruk av KI etter trinn og alder</a> (updated October 12, 2026) and <a href="https://www.udir.no/kvalitet-og-kompetanse/digitalisering-skole/kunstig-intelligens-i-skolen/">Kunstig intelligens i skolen</a>; the "Spørsmål til Skole-Norge" survey (January 2026), per the <a href="https://www.barnevakten.no/survey-skolenorge-2026/">Barnevakten</a> summary.</li>
<li><strong>NRK,</strong> <a href="https://www.nrk.no/artikkel/store-vil-ha-ki-ut-av-barneskolen-1189">Støre vil ha KI ut av barneskolen</a> (June 19, 2026); Barnevakten, <a href="https://www.barnevakten.no/ki-skal-bort-fra-barneskolene/">KI skal bort fra barneskolene</a> (June 19, 2026); <a href="https://www.kiforskolen.no/hva-gjelder-na.html">Kiforskolen</a> (summary of the official sources); the government press release (June 19, 2026, "Kunstig intelligens skal i all hovedsak ikke brukes i barneskolen"), as quoted by the above.</li>
<li><strong>Utdanningsforbundet,</strong> <a href="https://www.utdanningsforbundet.no/nyheter/2026/-skraper-kun-overflaten-av-problemene">Røsvoll: "Skraper kun overflaten av problemene"</a> (2026).</li>
<li><strong>OECD,</strong> PISA 2022, Norway country note; <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2026/09/pisa-2025-results-volume-i_5265bfb1/73451bc5-en.pdf">PISA 2025, Volume I</a> (September 2026) and the Norway Education GPS profile; TALIS 2024, Norway country note; <a href="https://www.oecd.org/content/dam/oecd/en/publications/reports/2025/10/results-from-talis-2024-country-notes_eafd703e/colombia_04c7b413/8f1df220-en.pdf">TALIS 2024: Colombia</a>; <a href="https://digital-skills-jobs.europa.eu/en/latest/news/oecd-digital-education-outlook-2026-how-generative-ai-can-support-learning-when-used">Digital Education Outlook 2026</a>.</li>
<li><strong>Eurydice,</strong> Norway's education system; regjeringen.no (<a href="https://www.regjeringen.no/en/aktuelt/norway-moves-forward-with-age-limit-for-social-media/id3108682">social media age limit</a>, 2025); Norway's Book Act (in force since January 1, 2024), per the NHH and The Local summaries.</li>
<li><strong>China:</strong> <a href="https://mobile.chinadaily.com.cn/html5/2025-05/16/content_005_682652a6ed50ccabe1512244.htm">China Daily</a> (May 16, 2025) on the Ministry of Education guidelines; <strong>New York:</strong> <a href="https://ny1.com/nyc/all-boroughs/news/2026/09/02/new-york-city-bans-ai-use-in-schools-through-eighth-grade">NY1</a> (September 2, 2026); <strong>UNESCO,</strong> <a href="https://www.unesco.org/en/articles/guidance-generative-ai-education-and-research">Guidance for generative AI in education and research</a> (2023); <strong>Common Sense Media</strong> (April 2025).</li>
<li><strong>Bastani et al. (2025),</strong> <a href="https://www.pnas.org/doi/10.1073/pnas.2422633122">PNAS</a>; <strong>Delgado et al. (2018),</strong> "Don't throw away your printed books", <em>Educational Research Review</em> 25; Colombia's PISA 2025 results, per <a href="https://www.larepublica.co/globoeconomia/colombia-sigue-rezagada-en-matematicas-y-lectura-de-acuerdo-con-pruebas-pisa-2025-4476792">La República</a> and <a href="https://cambiocolombia.com/pais/articulo/2026/9/colombia-sigue-rezagada-en-las-pruebas-pisa-2025-mientras-la-caida-educativa-tambien-golpea-a-varios-paises">Cambio</a> (in Spanish); Law 2626 of 2026; Infobae (June 20, 2026), origin of the viral headline.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Did Norway ban AI for children aged 6 to 13?</h3>
<p>Not as a law. The government and the Directorate for Education recommend that in grades 1 to 7 students essentially have no access to generative AI, with exceptions, and schools are expected to comply.</p>
<h3>Is Norway the first country to do so?</h3>
<p>I could not confirm it. China published guidelines in 2025 restricting primary students' independent use of generative AI, according to China Daily, and New York decreed a moratorium through 8th grade in 2026.</p>
<h3>Did Norway return to paper books?</h3>
<p>It announced a bill proposal to guarantee access to printed materials in basic school. It is a proposal; the teachers' union asks to keep a variety of materials, printed and digital.</p>
<h3>Does Norway have a quality education?</h3>
<p>It spends a lot and its system has strengths, but in PISA 2025 it is below the OECD average in math (452), reading (453) and science (470). That is why people speak of the "myth" of model countries.</p>
<h3>How do I use the Excel workbook?</h3>
<p>Change the support (0 to 100), the source level and the weight of each claim, and the thresholds on the Parametros sheet; the workbook calculates each verdict and an overall reading of the headline. Use it with other viral headlines.</p>

<p class="notice"><strong>Check before sharing.</strong> Download the <a href="/descargas/noruega-ia/verificador-titular-noruega-ia-escuela.xlsx">checker workbook</a> (in Spanish), replace the claims with those of another headline and share what is actually true.</p>

<h2>Food for thought</h2>
<p>A forceful headline often hides a more nuanced decision, and a nuanced decision can be more useful than a ban. <strong>If your school had to write today its own rule on AI for its youngest students, what would it include, what exceptions would you foresee and what evidence would you review in six months to know whether it was a good decision?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:etapas}}' => $img('noruega-ia-etapas', 467, 'Four stages of Norway\'s recommendation: grades 1 to 7 essentially no access to generative AI, grades 8 to 10 gradual and careful use, upper secondary learning to use it purposefully and at every stage learning about AI with exceptions for need.', 'Norway\'s recommendation by stage.'),
    '{{img:afirmaciones}}' => $img('noruega-ia-afirmaciones', 608, 'Table with six claims from the headline and their verdict: bans AI for children (partial, a recommendation and not a law), first country (unsupported), ages 6 to 13 (confirmed), books return (partial), read and write first (confirmed) and without replacing humans (partial).', 'Two confirmed, three half true and one unsupported.'),
    '{{img:udir}}' => $img('noruega-ia-udir', 573, 'Four facts about Norway before the measure: 8 in 10 schools already used AI, no national minimum age, 75% of schools without a plan and 40% of teachers who used AI versus 36% on the OECD average.', 'Eight in ten schools already used AI, with no national rule.'),
    '{{img:pisa}}' => $img('noruega-ia-pisa', 524, 'Bar chart of PISA 2025: Norway 452 in math versus 463 for the OECD, 453 in reading versus 461 and 470 in science versus 482.', 'PISA 2025: Norway versus the OECD average.'),
]);

return [
    'noruega-prohibe-ia-ninos-6-13-anos-libros-de-papel-verdad-o-mito' => [
        'slug' => 'norway-ban-ai-children-6-13-printed-books-true-or-myth',
        'title' => 'Norway and AI in School: Did It Really Ban Artificial Intelligence for Children Aged 6 to 13? What Is True and What Is Not',
        'excerpt' => 'We fact-check the viral headline: what the Norwegian government said (a recommendation, not a law), how its education quality stands (PISA 2025), its laws, its culture and what Colombia can learn from the myth of model countries.',
        'seo_title' => 'Norway Bans AI for Children 6 to 13: Is It True?',
        'seo_description' => 'We check whether Norway banned AI for children aged 6 to 13 and returned to books: a recommendation, not a law; its PISA results and its education laws.',
        'focus_keyword' => 'Norway AI ban children',
        'cover' => '/assets/img/articulos/noruega-ia/noruega-ia-portada-en',
        'cover_alt' => 'Cover "Norway and AI in school: did it really ban it for children?" with a fact-check card: it is not a law, it is a national recommendation, it covers ages 6 to 13, it is not confirmed as the first country and there are no studies on these children.',
        'content_html' => $html,
    ],
];
