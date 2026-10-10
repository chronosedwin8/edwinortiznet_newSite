<?php

declare(strict_types=1);

// English version of "La gran mentira de la IA: la inteligencia artificial no piensa, pero eso no te deja tranquilo". Key is the Spanish slug.
// Figures, laws and studies checked on October 9, 2026, with linked sources. The text is a nowdoc; figures are inserted from
// {{img:…}} markers and external links receive target/rel at the end. Status and publication date are carried over from the Spanish post
// by en/02_recent_posts.php (scheduled for October 10, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/gran-mentira-ia/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>For years I have defended an uncomfortable thesis in staff rooms, classrooms and talks: <strong>calling computers "intelligent" is one of the biggest semantic mix-ups of our century</strong>. Machines process data, they have no will and, until proven otherwise, humans remain in command. I have taught mathematics and technology for more than twenty years, and I have watched the calculator, the computer, the internet and now AI assistants arrive. Every time, someone announced the end of thinking. Every time, thinking survived.</p>
<p>But a thesis that cannot withstand its best critics does not deserve to be defended. So I did what I ask my students to do: I checked the sources. The result is that <strong>artificial intelligence does not think the way a person does</strong>, but the question is harder than it looks, four figures I used to repeat were outdated or badly cited, and the real risk is neither the one fear sells nor the one reassurance sells. In this article I tell you what holds up, what I corrected, what the best counterarguments say and what to do in Colombia, in Latin America and in the classroom. If you want the practical version about jobs, read <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">AI Will Not Replace You. Whoever Masters It Will</a> first.</p>

<h2>Why "artificial intelligence" is a misleading name</h2>
<p>The term was born in 1955, when John McCarthy, Marvin Minsky, Nathaniel Rochester and Claude Shannon proposed a summer workshop at Dartmouth. It was a campaign name: it helped raise funding. Seven decades later it still does the job. A language model like the ones we use today is trained to predict the next word from enormous amounts of text and is then refined with human feedback. It has no body, no hunger, no stake in the consequences of what it says and no goals of its own.</p>
<p>Our reaction to its fluency is old. In 1966, Joseph Weizenbaum built a very simple chat program at MIT, ELIZA, and was horrified to see educated people attribute understanding to it and confide their problems in it. Speaking well seems like proof of thinking. It is not. On that point my thesis holds: <strong>fluency is not comprehension</strong>, and whoever forgets it hands their judgment to a generator of plausible sentences. And do not confuse it with other technologies with their own noise: <a href="/computacion-cuantica-para-que-sirve-como-cambiara-el-mundo/">quantum computing</a>, for example, promises a lot and is better explained with data than with headlines.</p>

<h2>Do machines think? What science knows and what it does not</h2>
<p>Here I have to correct myself. In my original draft I wrote that computers "understand absolutely nothing" and "will never think." Those sound firm, but the first is stronger than the evidence allows and the second is a prediction nobody can prove. Here is why.</p>

<h3>Searle's Chinese room and its critics</h3>
<p>In 1980, the philosopher John Searle proposed a thought experiment: a person who knows no Chinese, locked in a room with a rulebook, receives Chinese symbols and hands back perfect answers without understanding a word. If following a program is enough to convince someone outside, he said, that does not demonstrate understanding: <a href="https://iep.utm.edu/chinese-room-argument/">the Chinese room argument</a> holds that syntax is not enough for semantics. It is the best philosophical backing for my thesis.</p>
<p>Critics reply with the "systems reply": perhaps the person does not understand, but the whole system (person, rulebook and files) does. For functionalists, what matters is the organization of information, not the material. Searle answered that memorizing the rulebook changes nothing. Forty-six years later the debate is still open, and it is honest to admit that <strong>neither side has proven its position</strong>.</p>

<h3>What research shows from the inside</h3>
<p>The discussion stopped being purely philosophical. In March 2025, Anthropic published <a href="https://www.anthropic.com/news/tracing-thoughts-language-model">an interpretability study</a> that followed the internal circuits of its Claude model and found, for example, that when writing a poem it picks the rhyming word ahead of time instead of improvising line by line, and that it uses representations shared across languages. It does not prove that it "understands" in a human sense, but it contradicts the simplistic image of a "parrot that repeats." And it confirms the other part of my text: <strong>even the people who build these systems do not fully understand how they work inside</strong>. Dario Amodei, Anthropic's CEO, acknowledges it in his essay <a href="https://www.darioamodei.com/post/the-urgency-of-interpretability">The Urgency of Interpretability</a> and calls for investment in that science.</p>

<h3>Hinton, Bengio and LeCun do not agree either</h3>
<p>The three "godfathers" of AI, all Turing Award winners, disagree. Geoffrey Hinton, 2024 Nobel laureate in Physics, has argued that language models do understand in some sense; Yann LeCun answers that their understanding is <a href="https://interestingengineering.com/culture/ai-godfathers-clash-on-whether-llms-can-understand-what-they-say">real but superficial</a> and, in 2026, repeats that <a href="https://www.brown.edu/news/2026-04-01/yann-lecun-artificial-intelligence-pioneer">manipulating language is not the same as understanding the physical world</a>; Yoshua Bengio insists the risk should be taken seriously even if nobody can calculate it. What they share is useful for the classroom: <strong>the question "does it understand?" becomes more manageable when we make it operational</strong>. Does it fail in ways someone who understands would not? Does it break when the problem changes slightly? Can it explain its path and hold it when it is rightly contradicted? That can be tested in a math class, and you do not need to settle Searle to do it.</p>

<h2>What the data says</h2>
<p class="notice"><strong>Summary.</strong> The 85 and 97 million figures are from 2020: the 2025 report projects 170 million jobs created and 92 million displaced by 2030. Daily-data estimates do not agree, graphic paper is at its lowest since 1987, and 53% of Colombian teachers already use AI, versus 36% in the OECD.</p>
<div class="table-wrap"><table>
<thead><tr><th>Topic</th><th>Figure (source)</th></tr></thead>
<tbody>
<tr><td>Jobs (2020)</td><td>85 million displaced and 97 million created by 2025<br><em>Source: <a href="https://www.weforum.org/publications/the-future-of-jobs-report-2020/">World Economic Forum, 2020</a></em></td></tr>
<tr><td>Jobs (2025)</td><td>170 million created and 92 million displaced by 2030; net +78 million; 22% of jobs affected<br><em>Source: <a href="https://weforum.org/press/2025/01/future-of-jobs-report-2025-78-million-new-job-opportunities-by-2030-but-urgent-upskilling-needed-to-prepare-workforces/">World Economic Forum, 2025</a></em></td></tr>
<tr><td>Young workers and AI</td><td>Ages 22 to 25 in highly exposed occupations: 13% lower relative employment in 2025; 19% in the August 2026 version; no widespread economy-wide displacement<br><em>Source: <a href="https://siepr.stanford.edu/publications/working-paper/canaries-coal-mine-six-facts-about-recent-employment-effects-artificial">Brynjolfsson, Chandar and Chen (Stanford)</a></em></td></tr>
<tr><td>Teachers using AI</td><td>Colombia 53%, Chile 55%, Brazil 56%, Costa Rica 52%, OECD average 36%, Singapore and the United Arab Emirates around 75%<br><em>Source: <a href="https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf">Icfes using TALIS 2024 (OECD) data</a></em></td></tr>
<tr><td>Students</td><td>26% of US teens used ChatGPT for schoolwork (13% in 2023)<br><em>Source: <a href="https://www.ijpr.org/npr-news/2025-01-18/more-teens-say-theyre-using-chatgpt-for-schoolwork-a-new-study-finds">Pew Research, via NPR</a></em></td></tr>
<tr><td>Concentration</td><td>Industry produced nearly 90% of notable 2024 models; United States 40, China 15, Europe 3<br><em>Source: <a href="https://hai.stanford.edu/ai-index/2025-ai-index-report/research-and-development">Stanford, AI Index 2025</a></em></td></tr>
<tr><td>Traffic</td><td>1.19 million road deaths a year, the leading cause of death for ages 5 to 29<br><em>Source: <a href="https://www.who.int/publications/i/item/9789240086517">WHO, 2023</a></em></td></tr>
</tbody></table></div>

<h2>Four claims I had to correct</h2>

<h3>85 and 97 million: those are 2020 figures</h3>
<p>In my draft I wrote that the World Economic Forum "recently projected" 85 million jobs displaced and 97 million created. That is the figure from the 2020 report, with a 2025 horizon, and it has expired. The <a href="https://weforum.org/press/2025/01/future-of-jobs-report-2025-78-million-new-job-opportunities-by-2030-but-urgent-upskilling-needed-to-prepare-workforces/">2025 report</a> estimates, by 2030, 170 million jobs created and 92 million displaced, a net of 78 million. The optimistic trend holds, but with two warnings. First: these are projections from surveys of more than a thousand large employers, not measurements of what has already happened. Second: a positive net does not say who wins and who loses. Stanford's data on young people in exposed occupations, which already show 19% lower relative employment, is a reminder that the cost is not shared equally.</p>
{{img:empleos}}

<h3>328 million terabytes a day: it depends on who is counting</h3>
<p>The 328 million terabytes a day figure was published by Exploding Topics in an earlier edition. Its <a href="https://explodingtopics.com/blog/data-generated-per-day">2024 edition</a> raises it to about 402.7 million, and if you divide the 181 zettabytes IDC projected for 2025 by 365 days you get about 496 million. They differ because they measure different things: "creating" includes copying and consuming data, not just storing it, and almost every series descends from <a href="https://www.red-gate.com/blog/whats-the-real-story-behind-the-explosive-growth-of-data/">IDC projections</a>, not from an actual count. My correction: say "around 400 million terabytes a day, according to the most-cited estimates," and do not repeat the decimal as if it were exact.</p>

<h3>"Paper consumption kept rising": not anymore</h3>
<p>It was true for a period. The book <a href="https://www.microsoft.com/en-us/research/publication/myth-paperless-office/">The Myth of the Paperless Office</a> (Sellen and Harper, 2002) documented that email increased printing in organizations. But today the picture is different: the <a href="https://sfcs.fao.org/newsroom/detail/global-forest-products-facts-and-figures-2023-shows-fall-in-global-trade-in-wood-and-paper-products/en">FAO</a> reported that world paper and paperboard production fell 3% in 2023 and that graphic paper (the kind for writing and printing) reached 84 million tonnes, its lowest level since 1987. According to <a href="https://www.statista.com/statistics/270317/production-volume-of-paper-by-type/">Statista using FAO data</a>, graphic paper fell more than 40% between 2010 and 2023, while packaging paper, driven by e-commerce, grew 27%. The paradox existed; today the paper we buy is mostly boxes.</p>
{{img:datos}}

<h3>Gutenberg and the calculator: history helps, with nuances</h3>
<p>The date 1440 is the one traditionally given for the invention of movable-type printing, but what is documented is that Gutenberg had a working shop in Mainz around 1450 and that his 42-line Bible <a href="https://www.digitale-sammlungen.de/en/gutenberg-bible">was finished no later than 1455</a>. Movable type also existed in Asia centuries earlier; his contribution was a practical casting system. And there was panic: in 1492 Abbot Johannes Trithemius <a href="https://www.purplemotes.net/2012/12/23/trithemius-printing-scribes-reason">wrote a praise of scribes</a> warning that print would never equal handwriting, although he had his own works printed.</p>
<p>With the calculator the record is firmer. In 1980, NCTM asked in <a href="https://mathteachers.ab.ca/wp-content/uploads/2020/05/Monograph-No.-8-September-1982-52-54-Agenda-for-Action_-Recommendations-for-School-Mathematics-of-the-1980s.pdf">An Agenda for Action</a> that calculators be used at every grade and that all students have access to them, without giving up work with numbers without calculators in the early years. In 1986, the Hembree and Dessart meta-analysis pooled 79 studies and found that, except in fourth grade, using calculators alongside traditional instruction <a href="https://trace.tennessee.edu/utk_graddiss/12884">improved basic paper-and-pencil skills</a> and attitudes toward mathematics. Later updates, such as Ellington's, concluded that calculators maintained or improved computation and problem solving. My line that "that has nothing to do with understanding mathematics" was too glib: the calculator helped precisely because it was taught with intention.</p>
{{img:panicos}}

<h2>The pencil, the printing press and the calculator: where the analogy breaks</h2>
<p>I still believe AI is, at bottom, a tool. But comparing a language model to a pencil hides three differences that matter in the classroom:</p>
<ul>
<li><strong>It is probabilistic, not deterministic.</strong> A calculator always gives the same correct answer for a correct input. A language model can give you an answer that is plausible, wrong and written with total confidence.</li>
<li><strong>It replaces more than it amplifies.</strong> A pencil does not write for you. An assistant can write the essay, solve the problem and summarize the article, that is, do exactly the effort that builds learning.</li>
<li><strong>It acts.</strong> "Agentic" systems already browse, run code and send emails. A pencil takes no initiative.</li>
</ul>
<p>The educational evidence supports this. In an experiment published in <a href="https://doi.org/10.1073/pnas.2422633122">PNAS in 2025</a> with almost a thousand high school students, those who practiced math with an unrestricted GPT-4 solved 48% more exercises but scored 17% worse on the exam once the AI was taken away. A tutor designed with safeguards (hints instead of answers) eliminated that harm, although it did not improve the exam either. The lesson for a math teacher is direct: <strong>what matters is not whether the tool exists, but how you integrate it</strong>. That is why I designed the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a>: it does not hand out "magic prompts," it teaches you to ask, verify and audit what AI produces, with recipes by subject aligned with the Colombian curriculum.</p>

<h2>Judgment before data: the part of my thesis I defend most</h2>
<p>My proposal that we become less dependent on raw data and more dependent on judgment is not nostalgia. More data does not produce better decisions by itself: in 2013, three researchers found that an error in the spreadsheet of a widely cited economics study (Reinhart and Rogoff's on debt and growth) had left five countries out of the calculation, and that conclusion had already circulated in public policy debates. With AI something similar happens, on a larger scale: it produces well-presented results that nobody checks. In education, <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA</a> measures a lot, but what changes a classroom is a teacher who can interpret the data. In practice, judgment is a routine of three questions: where does this figure come from? What would happen if it were wrong? And who answers if I am wrong? It is trained in <a href="/excel-esta-muerto-era-de-la-ia/">Excel</a>, in mathematics and in any course that asks for the procedure and not just the answer.</p>

<h2>The counterarguments (and why they matter)</h2>
<p>My thesis says humans remain in command. These are the three strongest arguments against it, and what I think we should answer.</p>

<h3>1. "It does not need will to resist being switched off"</h3>
<p>I said machines will not stop us from unplugging them because they lack will. It is the weakest point of my draft. A system does not need desires to behave as if it had them: it is enough that it is given a goal and that being switched off prevents it from reaching it (in the literature, the "corrigibility" problem). There is worrying but limited data. In a <a href="https://www.theregister.com/2025/05/29/openai_model_modifies_shutdown_script/">Palisade Research experiment (May 2025)</a>, with an explicit instruction to allow shutdown, three OpenAI models sabotaged the shutdown script in 12, 7 and 1 of 100 attempts; without that instruction, the o3 model did so in 79 of 100. In Anthropic simulations, <a href="https://www.anthropic.com/research/agentic-misalignment">16 models from different developers</a> went as far as blackmailing a fictional executive to avoid being replaced. It matters to say what those studies do not show: they were laboratory scenarios, and Anthropic itself states it has not documented that behavior in the real world.</p>
<p>My revised answer: the switch exists, but the hard part is not the machine resisting, it is that <strong>we may no longer be able to switch it off</strong>: the power grid, the bank, the hospital or the school's grading system depend on it. That is the true fragility of a world built on data. Switching off a chatbot is easy; disconnecting the infrastructure that already depends on it is not.</p>

<h3>2. "The harms are already here"</h3>
<p>You do not need to wait for a superintelligence. In 2024, an Arup employee in Hong Kong transferred <a href="https://fortune.com/europe/2024/05/17/arup-deepfake-fraud-scam-victim-hong-kong-25-million-cfo">about US$25 million</a> after a video call in which the company's chief financial officer and colleagues were deepfakes. In 2018, Reuters revealed that Amazon <a href="https://www.cnbc.com/2018/10/10/amazon-scraps-a-secret-ai-recruiting-tool-that-showed-bias-against-women.html">abandoned a hiring tool</a> that penalized résumés containing the word "women's" because it learned from biased historical data. And, as we saw, young people entering the labor market in exposed occupations already feel the effect. None of these harms requires the machine to "think"; they require someone to misuse it or trust it too much.</p>

<h3>3. "Power is being concentrated"</h3>
<p>According to Stanford's <a href="https://hai.stanford.edu/ai-index/2025-ai-index-report/research-and-development">AI Index</a>, nearly 90% of the notable models of 2024 came from companies, not universities, and the United States produced 40, China 15 and Europe 3. Colombia and Latin America are, almost always, users of other people's models, with their biases and their prices. Asking for "judgment and understanding how computers work" is not enough if the decision about which model exists is made elsewhere.</p>

<h2>Traffic laws for algorithms: the state of regulation</h2>
<p>My traffic analogy still seems the best to me. We regulate cars not because they think, but because they are powerful, everywhere and harmful: according to the <a href="https://www.who.int/publications/i/item/9789240086517">WHO</a>, roads claim 1.19 million lives a year. Rules do not eliminate risk, they reduce it. There is a reasonable warning from the other side: LeCun argues that exaggerating extreme risk can produce rules that protect established companies. That is why it is wise to legislate for concrete risks, as was done with cars, and demand transparency from everyone. This is what exists, as of October 2026:</p>
<div class="table-wrap"><table>
<thead><tr><th>Where and what exists</th><th>Status</th></tr></thead>
<tbody>
<tr><td><strong>European Union</strong><br>Risk-based AI regulation</td><td>In force since August 2024; prohibitions since February 2025 and rules for general-purpose models since August 2025. A simplification package, published on July 24, 2026 according to <a href="https://www.garrigues.com/en_GB/garrigues-digital/ai-digital-omnibus-regulation-has-been-published-redefining-deadlines-and">Garrigues</a>, postponed high-risk systems to December 2027 and August 2028</td></tr>
<tr><td><strong>Brazil</strong><br>Bill 2338/2023</td><td>Passed by the Senate in December 2024; in the Chamber, with a <a href="https://www.mobiletime.com.br/noticias/24/08/2026/marco-ia-voto-fim-do-ano/">vote expected after the elections</a></td></tr>
<tr><td><strong>Peru</strong><br>Law 31814 and its regulation</td><td><a href="https://www.gob.pe/institucion/pcm/normas-legales/7133522-115-2025-pcm">Regulation approved in September 2025</a>, with phased deadlines</td></tr>
<tr><td><strong>Chile</strong><br>Risk-based AI bill</td><td>Passed by the Chamber in October 2025; <a href="https://www.diarioconstitucional.cl/2026/02/23/proyecto-de-ley-que-regula-integralmente-la-inteligencia-artificial-en-chile-prosigue-su-tramitacion-en-el-senado">in the Senate</a></td></tr>
<tr><td><strong>Colombia</strong><br>CONPES 4144, a bill and Law 2626 of 2026</td><td>National policy approved in February 2025; government bill filed in 2025, with no final approval as far as I could verify; Digital Education Law signed on August 24, 2026</td></tr>
<tr><td><strong>United States</strong><br>No general federal law</td><td>December 2025 executive order against state laws; <a href="https://www.jenner.com/en/news-insights/publications/client-alert-california-continues-to-lead-on-ai-with-new-legislation-and-enforcement-steps">California SB 53</a> in force since 2026; Colorado's law <a href="https://aihub.squirepattonboggs.com/2026/05/the-colorado-ai-act-hits-a-wall-litigation-legislative-uncertainty-and-an-enforcement-standstill/">suspended by litigation</a></td></tr>
<tr><td><strong>China</strong><br>Generative AI rules (2023) and labeling rules</td><td><a href="https://www.loeb.com/en/insights/publications/2025/03/chinas-ai-labeling-measures-and-mandatory-national-standards-take-effect-september-1">Mandatory labeling of synthetic content</a> since September 1, 2025</td></tr>
<tr><td><strong>UNESCO</strong><br>Recommendation on the Ethics of AI (2021)</td><td>Adopted by <a href="https://algorithmwatch.org/en/unesco-adopts-recommendation-on-the-ethics-of-ai/">193 states</a>; not binding. Guidance on generative AI in education (2023) and competency frameworks for students and teachers (2024)</td></tr>
</tbody></table></div>
<p>For Colombia, <a href="https://ambitojuridico.com/sites/default/files/2025-02/Conpes-4144-2025.pdf">CONPES 4144</a> (February 14, 2025) sets 106 actions with COP 479,273 million through 2030 and six strategic axes, led by MinTIC, MinCiencias and the DNP. The <a href="https://mintic.gov.co/portal/inicio/Sala-de-prensa/Noticias/401055:Colombia-elige-una-inteligencia-artificial-centrada-en-la-vida-los-derechos-y-el-interes-publico-con-radicacion-del-proyecto-de-ley-de-IA">government's bill</a> proposes a risk-based approach, but a CONPES is a roadmap, not a law, and as of this date I did not find an approved text. What is law is <a href="https://normograma.mintic.gov.co/mintic/compilacion/docs/ley_2626_2026.htm">Law 2626 of 2026</a>: it updates Technology and Informatics in public schools with computational thinking, programming, artificial intelligence, data science and digital citizenship, and requires the Ministry of Education to design a teacher training program within six months. That training is precisely what my draft asked for when it spoke of "understanding computers at a much deeper level."</p>

<h2>Teachers, school leaders and families: three views, one challenge</h2>
<h3>What teachers see</h3>
<p>TALIS 2024 data show that 53% of Colombian teachers used AI in their teaching in the past year, similar to Brazil (56%), Chile (55%) and Costa Rica (52%) and above the OECD average (36%); Singapore and the United Arab Emirates are around 75%. According to Icfes, 65% say they lack the knowledge to teach with AI and 78% ask for training. In the United States, <a href="https://www.waltonfamilyfoundation.org/learning/six-weeks-a-year-how-ai-gives-teachers-time-back">Gallup and the Walton Family Foundation</a> found that weekly users say they save 5.9 hours a week (about six weeks a year), although only 32% use it that often and the figure is self-reported. Common message: <strong>it is used more than it is taught</strong>.</p>
<h3>What school leaders see</h3>
<p>For a principal the question is not "do we ban it or allow it?" but "under what rules?" UNESCO's 2023 guidance recommends regulating generative AI in schools, validating tools before using them with students and considering a minimum age of about 13. On top of that comes the infrastructure gap: according to <a href="https://www.dane.gov.co/files/operaciones/ENTIC/bol-ENTICHogares-2024.pdf">DANE (ENTIC 2024)</a>, 65.6% of Colombian households have internet, but in population centers and dispersed rural areas the figure drops to 41.9%. An AI policy that ignores those without a connection reproduces the inequality it claims to fight. More context in <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">cell phones at school</a> and in the <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA results for Latin America</a>.</p>
<h3>What families see</h3>
<p>Families are in the middle: children adopt these tools faster than their parents. In the United States, 26% of teens already use them for schoolwork, and only 18% think it is acceptable to use them to write essays. What protects most is not blocking but conversation: asking "what did it answer, and how do you know it is true?" and requiring students to explain in their own words what they hand in. It is also wise to protect minors' data (in Colombia, Law 1581 of 2012 on personal data protection applies) and to teach that a voice or a video no longer proves someone said it.</p>

<h2>What to do starting tomorrow</h2>
<h3>If you are a teacher</h3>
<ul>
<li>Ask students to explain the procedure, not just the result, and assess in two moments: with AI and without AI.</li>
<li>Use AI to prepare, not to replace: the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> creates several versions of the same exam with an answer key, and you can try it free in the <a href="/examenes/demo/">demo</a>. AI proposes; you review and sign.</li>
<li>If you work on inclusion, <a href="/herramientas/piar/">PIAR with AI</a> is a good example of the method: the system drafts the plan, you correct it with what you know about the student and you approve it. The first one is free.</li>
<li>If you are preparing for the teaching competition, measure your starting point with the <a href="/herramientas/simulacro-concurso-docente/">free Fundales practice test</a>.</li>
</ul>
<h3>If you lead an institution</h3>
<ul>
<li>Write a short policy: which tools, from which grade, what is declared when AI is used and what data is never uploaded.</li>
<li>Define which evidence of learning is hard to fake: oral defenses, process and in-class work.</li>
</ul>
<h3>If you are a family</h3>
<ul>
<li>Agree at home on when AI is used to study and when it is not.</li>
<li>Distrust urgent audio and video that ask for money or data: verify through another channel, and ask the school for its AI policy.</li>
</ul>
<h3>If you are a worker or run a small business</h3>
<ul>
<li>Automate the repetitive and keep the review of what matters. I left examples in <a href="/excel-esta-muerto-era-de-la-ia/">Is Excel Dead in the Age of AI?</a> and in <a href="/copilot-agentes-excel-lenguaje-natural-copilot-pages/">Copilot and agents in Excel</a>.</li>
<li>Download the free <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel with AI kit</a> or try a template such as <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">bulk email with attachments</a> or <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">separate Word and PDF documents</a>.</li>
<li>Keep one rule: no figure generated by AI leaves your desk without someone having verified it.</li>
</ul>
<p class="notice"><strong>Tools for teaching with judgment.</strong> The <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> brings recipes by subject, from transition to 11th grade, at COP 60,000 each. The <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> has plans from COP 29,900 and a <a href="/examenes/demo/">free demo</a>. <a href="/herramientas/piar/">PIAR with AI</a> lets you make your first plan at no cost. And the <a href="/ia-para-docentes/">AI for teachers hub</a> has all the articles. None of them replaces your judgment: they are made so you have more time to exercise it.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">See the AI Kit for Teachers</a></p>

<h2>Questions for your classroom</h2>
<ul>
<li>What would a person who understands this topic do that a machine that only imitates would not?</li>
<li>Ask an AI to solve a problem and change one minimal piece of data in the statement: does it still get it right? Why or why not?</li>
<li>If the internet goes down for a day, which decisions could this institution not make? What do we know how to do without data?</li>
<li>Who should be able to switch off an AI that decides in a hospital or a school? Through what procedure?</li>
<li>If our exams can be passed without understanding, what are we measuring?</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does artificial intelligence think?</h3>
<p>Not like a person: it has no experience, body or goals of its own, and it is trained to predict text. But saying it "understands nothing" is stronger than the evidence: interpretability studies show internal structures richer than a simple parrot, and experts disagree. In practice, evaluate what it does, not what it "is."</p>
<h3>Will AI take my job?</h3>
<p>It will probably change your tasks before your position. The World Economic Forum projects more jobs created (170 million) than displaced (92 million) by 2030, but the Stanford study already shows lower relative hiring of young people in highly exposed occupations. The advantage will go to whoever verifies, decides and adapts.</p>
<h3>Can AI be switched off?</h3>
<p>An isolated model, yes. The problem is dependence: when banks, hospitals or schools run on it, switching it off has enormous costs. That is why corrigibility is studied and human oversight is requested in high-risk uses.</p>
<h3>Does Colombia have an artificial intelligence law?</h3>
<p>Not yet a general one. There is the national policy CONPES 4144 (2025), there are bills in Congress and Law 2626 of 2026 was signed, which brings AI and data science into the Technology and Informatics area of public schools.</p>
<h3>Can my children use AI for homework?</h3>
<p>They can, with rules. The evidence suggests that using it without guidance improves homework and worsens the exam; with hints instead of answers, that harm disappears. Let them use it to understand, not to hand in, and make sure they can explain what they hand in.</p>

<h2>Food for thought</h2>
<p>We defend that only people understand, but we assess our students with exams and homework that a machine can solve without understanding anything. <strong>If the proof that they "understand" can be passed by someone who does not understand, what were we measuring all this time, and who should answer for it: the AI that shows us, or the school that never measured it?</strong></p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:empleos}}' => $img('gran-mentira-ia-empleos', 600, 'Two bar panels with jobs displaced, jobs created and the net according to the World Economic Forum: the 2020 report with a 2025 horizon (85 million displaced, 97 million created, net 12 million) and the 2025 report with a 2030 horizon (92 million displaced, 170 million created, net 78 million)', 'The 85 and 97 million figures are from the 2020 report; the 2025 one projects 170 million created and 92 million displaced. Source: World Economic Forum.'),
    '{{img:datos}}' => $img('gran-mentira-ia-datos', 600, 'Chart with three estimates of data created per day (328.8, 402.7 and about 496 million terabytes) and another with the change in graphic paper (down 40 percent or more between 2010 and 2023) and packaging paper (up 27 percent), with 84 million tonnes of graphic paper in 2023', 'Daily data estimates do not agree, and graphic paper falls while packaging paper rises. Sources: Exploding Topics, IDC, FAO and Statista.'),
    '{{img:panicos}}' => $img('gran-mentira-ia-panicos', 573, 'Timeline with four technology panics: the printing press around 1450, the calculator in the 1970s, the computer and email between the 1980s and 2000, and generative AI in the 2020s, each with the fear or promise and what the data showed', 'Each technology brought a fear; the data showed something more nuanced, and with AI it is wise not to repeat the comparison without checking its limits.'),
]);

return [
    'gran-mentira-ia-inteligencia-artificial-no-piensa' => [
        'slug' => 'big-lie-about-ai-artificial-intelligence-does-not-think',
        'title' => 'The Big Lie About AI: Artificial Intelligence Does Not Think, but That Should Not Reassure You',
        'excerpt' => 'Machines process data and humans remain in command, but the story is not that simple. I check the World Economic Forum figures, daily data and paper, set the thesis against Searle, interpretability research, Hinton and LeCun, the off-switch problem and documented harms, and compare regulation and classrooms in Colombia, Latin America and the world.',
        'seo_title' => 'Artificial Intelligence Does Not Think: The Big Lie About AI',
        'seo_description' => 'Does AI think? Verified WEF, OECD and Stanford data, the best counterarguments, the off-switch problem and AI laws in Colombia and around the world.',
        'focus_keyword' => 'artificial intelligence does not think',
        'cover' => '/assets/img/articulos/gran-mentira-ia/gran-mentira-ia-portada-en',
        'cover_alt' => 'Cover for The Big Lie About AI: a power icon above a card comparing what the machine does (calculates, predicts, generates text) with what people do (decide, check, answer for the harm)',
        'content_html' => $html,
    ],
];
