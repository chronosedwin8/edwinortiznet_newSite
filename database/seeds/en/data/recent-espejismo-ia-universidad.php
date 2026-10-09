<?php

declare(strict_types=1);

// English version of «El espejismo de la IA en la universidad: mucho "artefacto" y poca innovación». Key is the Spanish slug.
// Based on K. K. Ruiz Mendoza and E. Oviedo González (2026, TE&ET no. 44, DOI 10.24215/18509959.44.e4), read in full on
// October 9, 2026, plus linked sources. Quotes from Spanish-language sources are my translation. A phrase attributed to
// «Revista Mundo Empresarial» could not be verified and is not cited. Nowdoc keeps the text literal; figures are inserted
// from {{img:…}} markers.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/espejismo-ia-universidad/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>I have spent more than twenty years in classrooms, and almost every week I hear the same promise: generative artificial intelligence is going to "revolutionize" the university. That is why I stopped at a recent paper by Karla Karina Ruiz Mendoza and Eilen Oviedo González (2026) that reaches an uncomfortable conclusion: much of what gets called innovation with AI is producing the same things, in more formats and faster. My own summary is blunter: generative AI (GenAI) is being used as a glorified typewriter. But before assigning blame I did what I ask my students to do: <strong>I verified</strong>. I got the full paper, which is open access, went through its tables and compared what it says with what is usually said about it. The result is more useful, and more cautious, than the headline.</p>
<p>In this article I tell you what the study says and what it does not, what the wider evidence shows about <strong>AI in higher education</strong> in Colombia, Latin America and the world, and I leave you a concrete proposal (labeled as a proposal, not as proven truth) for assessing the process and not only the product, with a rubric, a logbook template and an oral-defense protocol you can use tomorrow.</p>

<h2>What the study really says about AI in higher education</h2>
<p>It is titled "<a href="https://doi.org/10.24215/18509959.44.e4" target="_blank" rel="noopener">From artifact production to pedagogical innovation: teaching strategies with GenAI in higher education</a>" and appeared in issue 44 (special issue, September 2026, pp. 40 to 49) of the <em>Revista Iberoamericana de Tecnología en Educación y Educación en Tecnología</em>, from the Universidad Nacional de La Plata (Argentina). The authors work at the Universidad Autónoma de Baja California (UABC), in Mexico. It is a qualitative, exploratory and interpretive study, using content analysis and descriptive percentages, with no claim to generalize.</p>
<p>The corpus is <strong>600 teaching strategies with a valid description, designed by 186 UABC instructors</strong> and recorded during an institutional teacher-training course on GenAI. Instructors came from all areas: 22% engineering and technology, 22% economics and business, 16% arts and humanities, and the rest from social sciences, health, natural and exact sciences, law and education.</p>
{{img:estudio}}
<table>
<caption>Evidence: the study's main figures (N = 600 strategies)</caption>
<thead><tr><th>What was measured</th><th>Result</th></tr></thead>
<tbody>
<tr><td>Main tool</td><td>ChatGPT 29.2% and Landbot (no-code chatbots) 17.8%; then Picsart 11.8%, InVideo 11.7% and SlidesAI 6.7%; "others", 13.5%</td></tr>
<tr><td>More than one tool in the same strategy</td><td>22.2%</td></tr>
<tr><td>Instructional integration: artifact production</td><td><strong>76.7%</strong> (460 of 600): text, slides, image, video or chatbot</td></tr>
<tr><td>Critical thinking, verification or ethics</td><td><strong>11.3%</strong></td></tr>
<tr><td>Explicit innovation indicators</td><td>Collaboration 10.3%; verification and attribution 9.3%; prompting as a skill 4.8%; iteration and improvement 3.5%; ethics 2.8%; personalization 1.0%</td></tr>
<tr><td>Declared assessment</td><td>Product or project as evidence 49.0%; rubric or explicit criteria 33.5%; <strong>no instrument or workable criteria 22.5%</strong>; reflection 5.3%; exam or quiz 3.3%</td></tr>
</tbody>
</table>
<p>A strategy can fall in several categories, so the percentages do not add up to 100. Source: tables 1 to 4 of the paper.</p>

<h3>What the study does support</h3>
<p>Three things, with numbers: activities that produce artifacts dominate; practices such as verifying, iterating or discussing ethics appear rarely; and assessment revolves around the product. The authors sum it up themselves: innovation "is expressed more as diversification of formats than as systematic redesign of assessment, verification and personalization processes". My thesis, which I stand by, is that a flawless essay, report or piece of code no longer tells you, on its own, who did the thinking.</p>

<h3>Where it needs nuance</h3>
<p>I say this with respect for the text that started this reflection, and for my own: some formulations stretch further than the data.</p>
<ul>
<li><strong>"The universities"</strong> are, in fact, one Mexican public university. The authors warn that the study "is limited to one institution and a specific moment of adoption", so it should not be generalized without considering discipline and local policy.</li>
<li><strong>"What professors do"</strong> is, more exactly, <strong>what they wrote in a course form</strong>. It represents pedagogical intent, not classroom implementation or learning effects, and it does not include what students did.</li>
<li><strong>"Absolute dominance of ChatGPT and Landbot"</strong>: together they add up to 47%, not everything. The authors also acknowledge that several tools were presented in the course and instructors picked the most familiar ones, so part of the concentration is an effect of the course itself.</li>
<li><strong>"Critical thinking is absent"</strong>: the study says "less frequent", and it only counts explicit mentions. A professor may demand source checking in class and not write it on the form. The authors speak of "a gap in pedagogical explicitness rather than an absence of normative concern".</li>
<li><strong>"Conventional rubrics"</strong>: the paper does not call them that. In fact, it argues for rubrics that include attribution, verification and an explanation of AI use. The harder number is a different one: almost one in four strategies leaves no operational assessment criteria at all.</li>
<li><strong>"Assessing the final product is absurd"</strong> is my thesis, not a conclusion of the study. The authors say something more nuanced: the validity of traditional tasks is under strain and the process should be made visible through prompt records, logbooks, source checking and successive versions, which is exactly what I propose below.</li>
</ul>
<p>A note on sources: next to my original draft circulated a phrase attributed to "Revista Mundo Empresarial (2026)" that I could not find in any publication, so I do not cite it. I prefer one fewer quote and one more verification.</p>

<h2>Why assessing only the product stopped working</h2>
<p>The UABC study is a portrait of intentions. To understand the underlying problem we have to look at what students do and what we know about learning.</p>
<ul>
<li><strong>Use is almost universal.</strong> In the UK, the <a href="https://www.hepi.ac.uk/reports/student-generative-ai-survey-2026/" target="_blank" rel="noopener">2026 HEPI and Kortext survey</a> (1,054 undergraduates) found that 95% use AI in some way, 94% for assessed work, and 12% pasted AI-generated text as is into assessed work. In 2024 the figures were 66%, 53% and 3%. And 65% say assessment changed significantly because of AI, while some students express anxiety about being falsely accused.</li>
<li><strong>Practicing with unguarded AI can be costly.</strong> In an experiment with almost 1,000 high school students in Türkiye, published in <a href="https://doi.org/10.1073/pnas.2422633122" target="_blank" rel="noopener">PNAS (2025)</a>, those who practiced with an unrestricted chatbot improved their practice performance by 48% (127% with the tutor version) but scored 17% worse than the no-AI group when access was removed for the exam. The "tutor" version, which gave hints instead of answers, eliminated the harm, though it produced no improvement. These are high school math students, not university students: a signal, not a verdict.</li>
<li><strong>Performing is not learning.</strong> The OECD's <a href="https://www.oecd.org/en/publications/oecd-digital-education-outlook-2026_062a7394-en.html" target="_blank" rel="noopener">Digital Education Outlook 2026</a> concludes that, without pedagogical support, delegating tasks to AI improves immediate performance but not real learning.</li>
<li><strong>With caution:</strong> the MIT preprint "<a href="https://arxiv.org/abs/2506.08872" target="_blank" rel="noopener">Your Brain on ChatGPT</a>" (2025) had 54 participants, only 18 of whom completed the fourth session; it has not been peer reviewed and is limited to essay writing. It helps formulate questions, not write headlines.</li>
<li><strong>Detectors are not the way out.</strong> <a href="https://doi.org/10.1016/j.patter.2023.100779" target="_blank" rel="noopener">Liang and colleagues (2023)</a> showed that seven detectors flagged, on average, 61% of 91 TOEFL essays written by non-native English speakers as "AI-generated". And OpenAI withdrew its own classifier in July 2023 because of low accuracy: in its initial evaluation it caught only 26% of AI-written text and falsely flagged 9% of human text.</li>
</ul>
{{img:uso}}
<p>My conclusion is not "let's monitor more" but "let's design better". If neither bans nor detectors solve the problem, what is left is redesigning what we assess and how. It was the same with phones in the classroom: <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">banning is not enough, we have to teach</a>.</p>

<h2>Colombia, Latin America and the world: three snapshots of the same film</h2>
<h3>Colombia: heavy use, little training and guidance without binding force</h3>
<p>According to a GAD3 study for <a href="https://planetaformacion.com/en/latest-news/news/planeta-formacion-y-universidades-has-analysed-results-barometer-artificial-intelligence-and-employability-future-higher-education-students-bogota" target="_blank" rel="noopener">Planeta Formación y Universidades</a> (presented in Bogotá in November 2024), 84% of Colombian higher-education students use generative AI tools frequently, but only 35% have the skills to go beyond a basic level. At the official level, the Ministry of Education's <a href="https://www.mineducacion.gov.co/1780/articles-429623_Decalogo_inteligencia_artificial.pdf" target="_blank" rel="noopener">Decalogue of AI for higher education</a> (August 2026) respects university autonomy and asks, in its sixth point, for assessment processes "that make it possible to observe thinking processes and not only final products". It builds on <a href="https://colaboracion.dnp.gov.co/CDT/Conpes/Econ%C3%B3micos/4144.pdf" target="_blank" rel="noopener">CONPES 4144 of 2025</a>. It is guidance, not a binding rule; and as for a specific AI law, I only found bills in progress (Bill 043 of 2025 in the Senate), with no confirmation that they have been passed. At the institutional level, the Universidad de los Andes published <a href="https://www.uniandes.edu.co/es/noticias/inteligencia-artificial/un-documento-pionero-en-colombia-para-usar-la-ia-generativa" target="_blank" rel="noopener">guidelines</a> in October 2024 that ask students to declare how AI was used and let professors set a scale of use per activity. And there is a national "secure lane": the Saber Pro test was taken in April 2026 <a href="https://newsroom.rcnradio.com/actualidad/icfes-anuncio-cambios-y-fechas-de-las-pruebas-saber-pro-y-ty-t-esto-deben-saber-los-estudiantes" target="_blank" rel="noopener">in person, on paper</a>, although it measures generic skills and does not replace assessment in each course.</p>
<h3>Latin America: reactive research and guidelines that are only arriving</h3>
<p>A <a href="https://revistas.uft.cl/index.php/rre/article/view/600" target="_blank" rel="noopener">systematic review of 35 studies</a> (2023 to April 2025) on teaching with GenAI in Latin American higher education found that the dominant themes are teacher training and academic integrity (54% each), while technological inequality (17%) and the lack of institutional policy (20%) stay in the background. The UABC study fits that picture. UNAM, in Mexico, published in 2026 <a href="https://www.gaceta.unam.mx/la-ia-generativa-modifica-la-forma-de-aprender-ensenar-y-evaluar/" target="_blank" rel="noopener">guides on generative AI in assessment</a>, with a sentence from Melchor Sánchez Mendiola, head of its evaluation office, that I share: AI "does not destroy assessment, it forces us to improve it". And the region already has instruments such as <a href="https://revistaseug.ugr.es/index.php/RELIEVE/article/view/36950" target="_blank" rel="noopener">CriticalAI</a>, which we will see below. Since 2023, the <a href="https://www.iesalc.unesco.org/2023/04/14/chatgpt-e-inteligencia-artificial-en-la-educacion-superior-guia-de-inicio-rapido/" target="_blank" rel="noopener">IESALC-UNESCO guide on ChatGPT in higher education</a> has served as a regional starting point.</p>
<h3>The rest of the world: reform assessment, don't just police it</h3>
<p>In 2024 the Digital Education Council surveyed 3,839 students in 16 countries: <a href="https://www.digitaleducationcouncil.com/post/digital-education-council-global-ai-student-survey-2024" target="_blank" rel="noopener">86% use AI</a> in their studies and 58% feel they lack sufficient knowledge. In <a href="https://www.educause.edu/content/2025/2025-educause-ai-landscape-study/introduction-and-key-findings" target="_blank" rel="noopener">EDUCAUSE (2025)</a>, only 39% of respondents said their institution had AI acceptable-use policies (a year earlier it was 23%). Australia took a concrete step: the regulator <a href="https://www.teqsa.gov.au/guides-resources/resources/corporate-publications/assessment-reform-age-artificial-intelligence" target="_blank" rel="noopener">TEQSA</a> proposed in 2023 that assessment prepare students to take part ethically in a society with AI and that learning be judged through multiple approaches; the <a href="https://educational-innovation.sydney.edu.au/teaching@sydney/?p=21312" target="_blank" rel="noopener">University of Sydney</a> turned it into its "two-lane" model. <a href="https://www.unesco.org/en/articles/guidance-generative-ai-education-and-research" target="_blank" rel="noopener">UNESCO published its guidance</a> on generative AI in education in 2023 and, in 2024, the <a href="https://www.unesco.org/en/digital-education/ai-future-learning/competency-frameworks" target="_blank" rel="noopener">AI competency frameworks</a> for students and teachers. And oral defenses are returning to classrooms: an <a href="https://www.adn.com/nation-world/2026/04/22/perfect-homework-blank-stares-why-colleges-are-turning-to-oral-exams-to-combat-ai/" target="_blank" rel="noopener">AP report</a> describes their comeback in US universities, with cost as the main obstacle.</p>

<h2>Four viewpoints: professors, university leaders, students and families</h2>
<h3>Professors</h3>
<p>In the Digital Education Council's <a href="https://www.digitaleducationcouncil.com/post/what-faculty-want-key-results-from-the-global-ai-faculty-survey-2025" target="_blank" rel="noopener">2025 global survey</a> (1,681 faculty in 28 countries), 61% had used AI in teaching, but 83% worried that students cannot critically evaluate what AI produces and 80% said their institution is unclear about how to apply it. And 54% thought assessment methods require significant changes. I did not find a representative survey of Colombian professors, and I would rather say so than invent a percentage.</p>
<h3>University leaders</h3>
<p>Theirs is a dilemma of scale and risk. An oral defense or a layered task costs teaching time, and teaching time is money. But a degree nobody can say what it certifies costs more. The Ministry's Decalogue and the Uniandes guidelines suggest the path: clear rules per institution and autonomy per course.</p>
<h3>Students</h3>
<p>According to HEPI (2026), only 36% feel their institution encourages them to use AI and 48% think their teaching staff help them develop AI skills, although 68% consider those skills essential for their careers. Among the comments in the report there is a fear we should take seriously: being accused of using AI simply for writing well.</p>
<h3>Families</h3>
<p>I did not find a Colombian survey of what families think, so what follows is my reading and not data: someone who pays tuition wants a degree that means something to an employer, and does not ask the university to ban AI but to teach how to use it with judgment. For them, process assessment is a guarantee that their child learned, not just that they handed something in.</p>

<h2>A proposal for assessing the process: four pieces (not a proven recipe)</h2>
<p>What follows are <strong>design proposals</strong>. They rest on the literature and on teaching craft, but I know of no experiments proving this set. Try them in one course, measure what happens and adjust.</p>
{{img:marco}}
<h3>1. Layered tasks: compare, audit and conclude</h3>
<p>Instead of "write an essay on X", ask the student to use AI to generate <strong>three positions</strong> on X, and assess their analysis: how they compare them, which fallacies and biases they detect, which claims they verify and what they conclude using readings the model did not give them. That way AI stops writing for the student and becomes their counterpart.</p>
<blockquote>
<p><strong>Assignment sheet (example, Business Administration course).</strong> Topic: should a Colombian small business adopt permanent remote work?</p>
<p><strong>Part 1 (with AI, 20 minutes).</strong> Ask the model for three positions (for, against and in between) with arguments and sources. Save the whole conversation.</p>
<p><strong>Part 2 (without delegating, 800 words maximum).</strong> Compare the positions using criteria you define; name at least two fallacies or biases and quote the passage; verify five factual claims in primary or indexed sources and mark which turned out false, nonexistent or unverifiable; add two readings that did not come from AI; write your conclusion and the variables the model left out.</p>
<p><strong>Part 3.</strong> Hand in your prompt log and your AI-use declaration (level 4 of the scale below).</p>
<p><strong>Part 4.</strong> Defend your analysis in 8 minutes, without slides.</p>
</blockquote>
<table>
<caption>Proposed rubric (each criterion scored from 1 to 4)</caption>
<thead><tr><th>Criterion and weight</th><th>1 Beginning</th><th>2 Developing</th><th>3 Achieved</th><th>4 Outstanding</th></tr></thead>
<tbody>
<tr><td><strong>Comparing positions</strong> (25%)</td><td>Summarizes the three without comparing</td><td>Compares with a list of pros and cons</td><td>Compares with explicit criteria and locates the real clash</td><td>Reveals hidden assumptions and reframes the problem</td></tr>
<tr><td><strong>Fallacies and bias</strong> (20%)</td><td>Detects none</td><td>Detects one without quoting the passage</td><td>Detects two or more, names and quotes them</td><td>Also explains how they change the conclusion and how to fix them</td></tr>
<tr><td><strong>Source verification</strong> (20%)</td><td>Accepts data and references unchecked</td><td>Verifies some; confuses primary and secondary sources</td><td>Verifies five claims and flags the false or nonexistent ones</td><td>Also adds two own readings that qualify the argument</td></tr>
<tr><td><strong>Metacognitive log</strong> (15%)</td><td>Missing or generic</td><td>Copies prompts without analyzing them</td><td>Records prompts, AI errors and corrections with the reason why</td><td>Shows how their way of asking changed</td></tr>
<tr><td><strong>Oral defense</strong> (20%)</td><td>Cannot explain their own claims</td><td>Repeats the text and fails the variation</td><td>Explains, justifies and answers the variation with reasons</td><td>Argues under pressure, admits limits and cites what the AI left out</td></tr>
</tbody>
</table>
<p>One design decision I suggest: let the defense <strong>cap</strong> the product's grade. If the student scores 1 on the defense, the document cannot exceed 2.5 out of 5. That way the defense is not decoration. If you prepare these tasks with AI, the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> includes recipes by subject for asking for contrasting positions, building question banks and drafting rubrics, always with your judgment having the last word.</p>

<h3>2. Metacognition and self-correction: the prompt log</h3>
<p>One source needs clarifying here. The journal RELIEVE published in 2026 the instrument <a href="https://revistaseug.ugr.es/index.php/RELIEVE/article/view/36950" target="_blank" rel="noopener">CriticalAI</a>, by Katherine Sandoval Perdomo and Luis Gibran Juárez Hernández: 48 items, six dimensions of Facione's model (interpretation, analysis, evaluation, inference, explanation and self-regulation), with items such as checking information obtained from AI against reliable sources or identifying its biases. But it is a <strong>self-report questionnaire</strong> validated in a pilot of 81 health-science students at a private university in Santiago, Chile, without factor analysis yet. It works as inspiration, not as a ready-to-grade rubric. For that, use the log:</p>
<table>
<caption>Prompt log template (one row for each important exchange)</caption>
<thead><tr><th>No.</th><th>Prompt (verbatim)</th><th>What the AI answered</th><th>What I verified and with which source</th><th>What I fixed or discarded and why</th><th>What I would change in my next prompt</th></tr></thead>
<tbody>
<tr><td>1</td><td>"Give me three positions on permanent remote work in Colombian small businesses"</td><td>Three positions with two figures and one citation</td><td>I looked up the figures at the official source; one does not appear and the citation does not exist</td><td>Discarded the figure and the citation; used the data I did find</td><td>Ask for links and separate facts from opinions</td></tr>
<tr><td>2</td><td>(illustrative example to complete)</td><td></td><td></td><td></td><td></td></tr>
</tbody>
</table>

<h3>3. Oral defense: an 8 to 10 minute protocol</h3>
<ol>
<li><strong>Opening (1 min).</strong> The student summarizes their thesis, with no slides or notes.</li>
<li><strong>Depth (3 min).</strong> Three questions about their analysis and sources.</li>
<li><strong>Variation (3 min).</strong> You change a figure or an assumption and ask them to rethink their conclusion.</li>
<li><strong>Process (2 min).</strong> "Show me a moment when the AI got it wrong and how you noticed."</li>
<li><strong>Close (1 min).</strong> The student self-assesses in one sentence and you score with the rubric on the spot.</li>
</ol>
<p>A starter question bank: which part of this text could you not defend without the AI? Which claim was hardest to verify? If the opposing position were true, what evidence would show it? Which variable did the model leave out and why does it matter? If this figure changes, does your conclusion still hold? How would you explain it in 30 seconds to someone with no background? Which of the sources you cited did you read in full? What would you do differently in your first prompt?</p>
<p>With 40 students that is six or seven hours, so you can run <strong>sampled vivas</strong> (a randomly chosen part of the group, announcing beforehand that anyone can be called) or five-minute mini defenses. Plan reasonable accommodations for anyone with anxiety, a stutter or a hearing disability (more time, written questions, a support person). The PIAR under Decree 1421 of 2017 is for preschool, primary and secondary education, but its logic applies at any level; if you teach in a school, <a href="/herramientas/piar/">PIAR with AI</a> helps you build one, and the first is free. And to schedule slots and keep attendance, an <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">attendance sheet in Excel</a> works well.</p>

<h3>4. AI-use declaration and two lanes: what holds the system together</h3>
<p>None of the above works if the student does not know what is allowed. The Universidad de los Andes adopted in its guidelines a five-level scale proposed by Perkins, Furze, Roe and MacVaugh (2024), which the professor can set for each activity:</p>
<table>
<caption>AI-use scale per activity (adapted from the Uniandes guidelines, 2024)</caption>
<thead><tr><th>Level</th><th>What is allowed</th><th>What the student must declare</th></tr></thead>
<tbody>
<tr><td>1</td><td>No generative AI</td><td>Nothing</td></tr>
<tr><td>2</td><td>Explore ideas and structure; generated material does not go into the work</td><td>That they used it to explore</td></tr>
<tr><td>3</td><td>Improve the clarity of the student's own ideas</td><td>How they used it, in a footnote or appendix</td></tr>
<tr><td>4</td><td>Complete some elements with human evaluation</td><td>Generated material in quotation marks, its quality and relevance, and a prompt appendix</td></tr>
<tr><td>5</td><td>Full use throughout the process</td><td>No need to distinguish own from generated</td></tr>
</tbody>
</table>
<p>And a <strong>two-lane</strong> architecture, inspired by Sydney: lane 1 is secure (in person and supervised: in-class exam, oral defense, lab practice) and assures that learning outcomes were reached; lane 2 is open, with AI allowed and declared, and teaches thinking with the tool. For the secure lane you need exams that cannot be solved through a chat: the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> creates several versions of the same exam with an answer key, and you can try it for free in the <a href="/examenes/demo/">demo</a>. I explain it in <a href="/generador-de-examenes-con-ia-versiones-solucionario-latex/">this article</a>.</p>

<h2>What you can do this week: professors and students</h2>
<h3>If you are a professor</h3>
<ul>
<li>Run your most "essay-like" assignment through an AI and see whether your rubric would pass it; if so, you know what to redesign.</li>
<li>Write the allowed level of AI use (1 to 5) in the syllabus and in each assignment.</li>
<li>Add one layer to a single task: three positions and an audit of five claims.</li>
<li>Ask for the log using the template above and grade only what you can read in ten minutes.</li>
<li>Run a five-minute defense with a random sample of your group.</li>
<li>Reserve an in-person exam with different versions for the secure lane.</li>
<li>Never use a detector as the only proof, and never to accuse.</li>
</ul>
<h3>If you are a student</h3>
<ul>
<li>Always declare how you used AI, even when nobody asks.</li>
<li>Save your whole conversation: it is your evidence of work and your defense against an accusation.</li>
<li>Verify at least five facts from each answer against primary sources, and be wary of "perfect" citations.</li>
<li>Ask the AI "where could you be wrong?" and check the answer against a real source.</li>
<li>Ask it to quiz you instead of solving things for you: that is the difference between a tutor and a crutch.</li>
<li>Practice explaining your work out loud, without a screen, before handing it in.</li>
<li>Do not paste personal data, yours or anyone else's, into a chat.</li>
</ul>
<p>If you want the other side of this coin, what AI promises and does not deliver, I collect my analyses in the <a href="/ia-para-docentes/">AI for teachers</a> section, together with <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">"AI won't replace you. Whoever masters it will"</a>. And if you wonder why the format matters less than the quality of assessment, see <a href="/educacion-virtual-vs-presencial-colombia-datos/">online versus in-person education</a>. The same goes for formulas: <a href="/excel-esta-muerto-era-de-la-ia/">if a generation asks for formulas without learning to read them, it signs off numbers it does not understand</a>.</p>

<p class="notice"><strong>Tools to assess the process, not just the product.</strong> The <strong>AI Kit for Teachers</strong> includes tested recipes by subject, aligned with the Colombian curriculum, for 60,000 Colombian pesos per subject. The <strong>AI Exam Generator</strong> creates different versions of the same exam for your secure lane, with plans from 29,900 pesos. <strong>PIAR with AI</strong> lets you build one PIAR for free and then choose packages of 5, 10 or 20 plans. None replaces your judgment: they are made so you can spend it on what matters.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">See the AI Kit for Teachers</a></p>

<h2>Frequently asked questions</h2>
<h3>Does this study prove that universities are not innovating with AI?</h3>
<p>No. It analyzes 600 strategies from 186 instructors at a single Mexican university, recorded in a training course, and it reflects intentions, not classroom practice or learning results. It is a valuable signal and consistent with other reviews, but not proof about "the universities".</p>
<h3>Should AI be banned in university assignments?</h3>
<p>Not necessarily. Banning without being able to verify only punishes those who comply. A more realistic way out is to combine a secure lane (in person, no AI or controlled AI) with an open lane where AI is allowed, declared and the process is assessed.</p>
<h3>Do AI detectors work to tell whether someone cheated?</h3>
<p>Not as the only proof. In a 2023 study, seven detectors flagged on average 61% of some essays written by people whose first language is not English as AI-generated, and OpenAI withdrew its own classifier because of low accuracy. A conversation with the student, their log and an oral defense are fairer.</p>
<h3>Is an oral defense feasible with groups of 40 students?</h3>
<p>Yes, with adjustments: five-minute vivas, defenses for a random sample or defenses in pairs. It is not free in time, but it is the most direct way to check that the student understands what they handed in.</p>
<h3>Isn't assessing the process much more work?</h3>
<p>At first, yes: you have to design tasks, rubrics and templates. Afterwards they are reused, and AI can help with feedback drafts, as long as the decision about what counts as evidence of learning stays yours.</p>

<h2>Food for thought</h2>
<p>If an AI writes in 30 seconds an essay that passes your rubric, is the problem the student who used it, the professor who designed the task, or a university that for decades called "learning" what a machine now does? <strong>And if the oral defense is the answer, are we willing to pay its cost, with fewer students per professor and more time to listen to them, or will we keep grading documents nobody knows who wrote?</strong></p>
HTML;

$html = strtr($html, [
    '{{img:estudio}}' => $img('espejismo-ia-universidad-estudio', 747, 'Chart with the figures from the study of 600 strategies by 186 UABC instructors: artifact production 76.7%, guided practice 15.5%, critical thinking, verification and ethics 11.3%, feedback 10.7%, planning 7.8%, automation 5.8%; innovation indicators such as collaboration 10.3%, verification 9.3%, iteration 3.5%, ethics 2.8% and personalization 1.0%; and assessment: product or project 49.0%, rubric 33.5%, no criteria 22.5%, reflection 5.3% and exam 3.3%', 'What instructors declared: artifacts abound, while verification, iteration, ethics and personalization are scarce. Source: Ruiz Mendoza and Oviedo González (2026), tables 2 to 4.'),
    '{{img:uso}}' => $img('espejismo-ia-universidad-uso', 640, 'Bars from the HEPI survey of UK students in 2024, 2025 and 2026: use of AI in some way 66, 92 and 95 percent; use in assessed work 53, 89 and 94 percent; AI text pasted as is 3, 8 and 12 percent; and four cards: 86 percent of 3,839 students in 16 countries use AI, 84 percent of Colombian students use it frequently and only 35 percent go beyond basic skills, 83 percent of 1,681 faculty worry students cannot critically evaluate AI output, and minus 17 percent on the AI-free exam for students who practiced with an unguarded chatbot', 'Almost all students use AI. The cards come from different surveys and studies and are not comparable. In 2026 HEPI adjusted the 2025 figure to 89% (it was 88%).'),
    '{{img:marco}}' => $img('espejismo-ia-universidad-marco', 667, 'Diagram: assessing only the product (prompt, AI writes it, document handed in, grade whose work) versus assessing the process in four layers (compare, audit, document, defend) and, below, two lanes: lane 1 secure, in person and supervised, and lane 2 open, with AI allowed and declared', 'A four-layer, two-lane design proposal. It is a proposal, not proven evidence.'),
]);

return [
    'inteligencia-artificial-educacion-superior-espejismo-evaluacion' => [
        'slug' => 'ai-in-higher-education-mirage-assessment-process',
        'title' => 'The AI Mirage at University: Lots of "Artifacts" and Little Innovation',
        'excerpt' => 'A study of 600 strategies by 186 UABC instructors (Mexico) found that generative AI is used mostly to produce artifacts, and rarely to verify, iterate or discuss ethics. I check what it says (and what it does not), set it against Colombia, Latin America and the world, and propose how to assess the process: layered tasks, a prompt log, oral defense and two lanes.',
        'seo_title' => 'AI in Higher Education: More Artifacts Than Innovation',
        'seo_description' => 'What a study of 600 teaching strategies with generative AI says, its limits, and how to assess the process: layered tasks, a prompt log and oral defense.',
        'focus_keyword' => 'AI in higher education',
        'cover' => '/assets/img/articulos/espejismo-ia-universidad/espejismo-ia-universidad-portada-en',
        'cover_alt' => 'Cover for The AI mirage at university: lots of artifacts, little innovation, with the UABC study figures: artifact production 76.7%, critical thinking, verification and ethics 11.3%, iteration 3.5% and personalization 1.0%',
        'content_html' => $html,
    ],
];
