<?php

declare(strict_types=1);

// English version of the article on phones in school (Javeriana LEE report 143, evidence on bans, teaching with purpose). Key is the Spanish slug.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/celulares-aula/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

return [
    'celulares-en-el-colegio-prohibir-o-ensenar' => [
        'slug' => 'phones-in-school-banning-is-not-enough-we-have-to-teach',
        'title' => 'Phones in School: Banning Isn’t Enough, We Have to Teach',
        'excerpt' => 'I checked the Javeriana University study on children, phones and online safety in Colombia, and reviewed what happened in the countries that banned phones in school. My conclusion: restricting recreational use helps, but without teaching and without training teachers, a ban falls short. Includes a classroom protocol, a family agreement and a four-week teacher training plan.',
        'seo_title' => 'Phones in School: Banning Isn’t Enough, We Have to Teach',
        'seo_description' => 'What the Javeriana study really says, what happened where phones were banned and how to teach with them: classroom protocol, family agreement and teacher plan.',
        'focus_keyword' => 'phones in school',
        'cover' => '/assets/img/articulos/celulares-aula/celulares-aula-portada-en',
        'cover_alt' => 'Cover: Phones in class, banning isn’t enough, we have to teach. A phone shows today’s lesson: check a source (13%), protect my data (11%) and secure my account (9%)',
        'content_html' => <<<HTML
<p>For months, one sentence has been making the rounds on TV news, WhatsApp groups and parent meetings in Colombia: “more than five million minors use their phones every day, and about 90% don’t know how to protect themselves on the platforms.” It almost always comes with the conclusion many people already had: get phones out of schools.</p>
<p>I have been teaching math and technology in Colombia for more than twenty years, and I have seen the phone as both a problem and a tool, sometimes in the same lesson. Before giving my opinion, I went to the source. What I found confirms the concern, but not the conclusion. My thesis: <strong>restricting recreational phone use during the school day makes sense; turning that restriction into a crusade against the device is a mistake</strong>. It isn’t about banning, it’s about teaching. And teaching with phones requires training teachers, which is exactly what almost nobody is funding.</p>

<h2>First, let’s check the figure</h2>
<p>The source is {$ext('https://lee.javeriana.edu.co/w/lee-informe-143', 'Report 143 of the Education Economics Lab (LEE) at Pontificia Universidad Javeriana')} (in Spanish), “Use of digital devices and the challenges of effective regulation in school settings,” dated July 13, 2026. It analyzes microdata from the 2025 Quality of Life Survey by DANE, Colombia’s statistics agency (ages 5 to 17), the 2024 C600 school census form and the Saber 11 national exam questionnaires from 2019 to 2025. {$ext('https://www.eltiempo.com/vida/educacion/9-de-cada-10-ninos-y-adolescentes-en-colombia-no-saben-protegerse-en-internet-aunque-casi-todos-ya-tienen-celular-3572056', 'El Tiempo')} and {$ext('https://www.portafolio.co/economia/las-cifras-respaldan-la-restriccion-del-celular-en-los-colegios-menos-acoso-y-mejor-rendimiento-academico-498352', 'Portafolio')} reported on it in mid-July.</p>
<p>The exact figures: out of about 10.9 million children and teens aged 5 to 17, <strong>8.6 million use the internet</strong>, <strong>7.5 million (88%) go online mainly from a phone</strong> and <strong>4.9 million (44%) do so every day</strong>. Only 13% say they know how to check whether information is true, 11% how to limit the spread of their data and 9% how to protect their devices and accounts; between 89% and 91% say they don’t. In addition, more than 60% of 11th graders spend over an hour a day online outside schoolwork.</p>
{$img('celulares-aula-cifras', 547, 'Chart with two panels. On the left, in millions: 10.9 children and teens aged 5 to 17, 8.6 use the internet, 7.5 go online mainly from a phone and 4.9 go online every day. On the right, the share who say they know how: 13 percent check whether information is true, 11 percent limit the spread of their personal data and 9 percent protect devices and accounts. Note: 92 percent go online at home and 53 percent at school', 'The phone is the gateway to the internet for almost 9 in 10 connected children and teens, but very few say they know how to protect themselves.')}
<p>Two clarifications. The figure that circulates as “more than five million use their phones every day” is actually <strong>4.9 million who go online every day</strong>, from any device. And the safety skills are self-reported: they measure what children believe they know. Even so, the message survives the rounding: almost all of them are connected through a phone and almost none has learned to stay safe.</p>
<p>A detail few headlines mentioned: the report itself calls for <strong>distinguishing personal use from supervised teaching use</strong>, describes restriction as “necessary but not sufficient” and recommends grading it by school level, guaranteeing connectivity before restricting and pairing it with teacher training. The study used to demand bans also warns about their limits.</p>

<h2>The myth: “phones are bad”</h2>
<p>The concern is grounded. In {$ext('https://www.oecd.org/en/publications/pisa-2022-results-volume-ii_a97db61c-en.html', 'PISA 2022')}, 65% of students across the OECD said they were distracted by devices in at least some math lessons, and those distracted by classmates’ devices scored 15 points lower. 45% feel anxious if their phone isn’t nearby. UNESCO’s {$ext('https://www.unesco.org/gem-report/en/technology', '2023 GEM Report')}, “Technology in education: a tool on whose terms?”, found evidence of distraction in 14 countries and recommended allowing in school only technology that clearly supports learning.</p>
<p>The debate went mainstream with Jonathan Haidt’s {$ext('https://www.anxiousgeneration.com/', '“The Anxious Generation”')} (2024), which links rising teen anxiety to the shift from a play-based to a phone-based childhood and proposes phone-free schools, no smartphones before high school and no social media before 16. Psychologist Candice Odgers replied in a {$ext('https://www.nature.com/articles/d41586-024-00902-2', 'review in Nature')} that the evidence is mostly correlational and does not show that social media caused that epidemic. Both are partly right: there are signs of harm, and there is also the temptation to turn a correlation into a panic.</p>
<p>The most useful point in the Javeriana report is a distinction taken from a longitudinal study in South Korea (Han, 2022): <strong>using the phone to learn improves self-directed learning and does not increase addiction; using it for entertainment does the opposite</strong>. The problem isn’t the device. It’s use without purpose, without guidance and without limits.</p>

<h2>The wave of bans</h2>
<p>According to {$ext('https://www.unesco.org/gem-report/en/articles/phone-bans-schools-are-spreading-worldwide-policy-debate-rages', 'UNESCO’s tracking')}, the share of countries with a national ban on phones in school rose from 24% in June 2023 to 40% in early 2025 and 58% in March 2026: 114 education systems.</p>
{$img('celulares-aula-prohibiciones', 573, 'Chart: the share of countries with a national ban on phones in school rose from 24 percent in June 2023 to 40 percent in early 2025 and 58 percent in March 2026, equal to 114 education systems. On the right, a timeline: Brazil, Law 15,100 in January 2025, with an exception for teaching use; Bolivia and Costa Rica join in 2025 and 2026; Colombia, Decree 0769 in July 2026; Bogotá, phones stored and teaching use from grade 8 in September 2026; Mexico, restriction in primary and lower secondary in November 2026', 'In under three years, restrictions went from exception to majority. Colombia still has no national law.')}
<p><strong>Around the world.</strong> France has banned phones in primary school and <em>collège</em> since 2018 and in 2025 required them to be stored on arrival; the Netherlands restricted them from 2024; Italy extended its ban to upper secondary with {$ext('https://www.agendadigitale.eu/scuola-digitale/divieto-di-cellulari-e-ia-a-scuola-ecco-cosa-cambia/', 'circular 3392 of 2025')}, with exceptions for disability and for technical ICT programs; {$ext('https://eurydice.eacea.ec.europa.eu/news/portugal-prohibition-use-mobile-electronic-communication-devices-internet-access-primary', 'Portugal')} banned them in the first two cycles, and in Spain the {$ext('https://catalannews.com/society-science/item/spain-proposes-mobile-phone-ban-in-primary-schools-and-regulating-use-in-secondary-schools', 'State School Council')} agreed to bar them in early years and primary. South Korea has had a law since March 2026, England updated its {$ext('https://www.gov.uk/government/publications/mobile-phones-in-schools', 'official guidance')} and about two thirds of US states have some restriction.</p>
<p><strong>In Latin America.</strong> Brazil enacted {$ext('https://www.planalto.gov.br/ccivil_03/_ato2023-2026/2025/lei/L15100.htm', 'Law 15,100')} in January 2025: it bans phones in class and at recess across basic education but allows guided teaching use. Bolivia and Costa Rica followed. In September 2026 Mexico published a {$ext('https://www.poresto.com/mexico/2026/9/22/publican-acuerdo-de-la-sep-que-restringe-el-uso-de-celulares-en-escuelas.amp.html', 'SEP agreement')} (in Spanish) restricting them in primary and lower secondary from November 3, with teaching exceptions. Buenos Aires offered families a {$ext('https://buenosaires.gob.ar/gcaba_historico/noticias/postergar-el-primer-celular-una-propuesta-para-cuidar-el-bienestar-digital', 'voluntary pledge')} (in Spanish) to delay the first smartphone until secondary school.</p>
<p><strong>In Colombia.</strong> There is no national law. Bills {$ext('https://www.camara.gov.co/celulares-en-colegios-651/', '253 and 354 of 2024')}, merged in the Sixth Committee of the House, and {$ext('https://www.alianzaverde.org.co/comunicados/representante-a-la-camara-impulsa-proyecto-para-regular-el-uso-de-celulares-en-colegios', 'bill 542 of 2026')}, by Representative Olga Lucía Velásquez, have not completed their passage. A {$ext('https://www.camara.gov.co/restriccion-celular-3684/', '2018 bill')} passed several debates and was shelved. Regulation is arriving by other routes (all sources in Spanish):</p>
<ul>
<li>{$ext('https://www1.funcionpublica.gov.co/eva/gestornormativo/norma_pdf.php?i=260756', 'Law 2489 of 2025')} on healthy and safe digital environments, and its {$ext('https://www.eluniversal.com.co/colombia/2026/07/22/nuevo-decreto-para-proteger-a-menores-en-internet-estas-son-las-obligaciones/', 'Decree 0769 of 2026')}: schools must update their institutional project and code of conduct to address cyberbullying and offer digital workshops for families; platforms must verify age and build in privacy by design.</li>
<li>{$ext('https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=52287', 'Law 1620 of 2013')}, which created the school coexistence system and already includes cyberbullying in its response protocol.</li>
<li>On September 7, 2026, Bogotá presented the {$ext('https://bogota.gov.co/mi-ciudad/educacion/conoce-acb-normativa-de-uso-de-celulares-en-colegios-de-bogota-2026', '“(Re)connecting to learn” resolution')}, built with input from more than 98,000 people: phones stored and out of sight all day, including breaks; teaching use from grade 8 with a guided activity; and six months for schools to update their rules. Ibagué approved a restriction for under-14s in public schools.</li>
</ul>

<h2>What happened after the bans?</h2>
<p>This is the heart of the debate, and the results don’t all point the same way.</p>
{$img('celulares-aula-evidencia', 684, 'Evidence table with seven studies and three dimensions: achievement, climate and discipline, and wellbeing and attention. Norway: math gains for girls, less bullying and fewer mental health visits. Florida: plus 1.1 percentiles in year two, suspensions up 25 percent at first and then normal, and fewer absences. Rio de Janeiro: plus 0.06 standard deviations in test scores. Netherlands: 28 percent of schools see better results, 59 percent a better social climate and 75 percent better concentration. England: no differences. United States, 41,000 schools: test effect close to zero and mixed effects on discipline and wellbeing. Meta-analysis: non-significant achievement effect and improvements in bullying and social wellbeing', 'The most consistent gain is in school climate; for achievement, effects are small or null and depend on implementation.')}
<ul>
<li><strong>Norway.</strong> According to the Javeriana review, Sara Abrahamsson (2024) found that girls exposed to a ban throughout lower secondary gained 0.22 standard deviations in math and cut their mental health visits by almost 60%; bullying fell by 43% to 46%. Boys showed no academic effect.</li>
<li><strong>Florida.</strong> {$ext('https://www.nber.org/papers/w34388', 'Figlio and Özek')} found suspensions rose 25% at first and, by the second year, scores improved 1.1 percentiles, partly because absences fell.</li>
<li><strong>Rio de Janeiro.</strong> {$ext('https://www.nber.org/papers/w35233', 'Lichand, Gentzkow and coauthors')} measured a 0.06 standard deviation gain after the city’s 2023 ban: the best Latin American evidence available.</li>
<li><strong>Netherlands.</strong> In a {$ext('https://www.malaymail.com/news/life/2025/07/06/study-finds-smartphone-bans-in-dutch-schools-improved-focus/182897', 'government-commissioned evaluation')}, 75% of secondary schools reported better concentration, 59% a better social climate and 28% better results; this is perception, not measurement.</li>
<li><strong>England.</strong> The {$ext('https://www.birmingham.ac.uk/research/projects/smart-schools', 'SMART Schools')} study (Goodyear et al., 2025), with 1,227 students from 30 schools, found no differences in wellbeing, sleep or attainment between restrictive and permissive schools.</li>
<li><strong>United States.</strong> Baron and coauthors, with data from more than 41,000 schools, found a test score effect “consistently close to zero,” even though in-class use fell from 61% to 13% according to teachers, {$ext('https://www.adn.com/nation-world/2026/05/04/school-cellphone-bans-have-little-effect-on-test-scores-or-attendance-study-finds/', 'AP reports')}.</li>
<li><strong>Meta-analysis.</strong> Böttger and Zierer (2024) estimated an academic effect of d = 0.05, not significant, and 0.22 for social wellbeing.</li>
</ul>
<p>My reading: <strong>restricting recreational use improves school climate and reduces bullying; for learning, the effect is small, uneven and depends on implementation</strong>. Storing the device works better than “silent mode,” and even so, 29% of students in schools with bans admit to still using their phones (OECD, cited by the Javeriana report). Böttger and Zierer put it best: the goal of a restriction should be to build the media literacy that makes it unnecessary.</p>

<h2>Why banning isn’t enough</h2>
<p>I support restricting recreational use, especially in primary school. What I reject is the radicalization: believing the ideal school is a screen-free bunker and that the problem ends at the school gate. Four reasons:</p>
<p><strong>1. The risk lives at home.</strong> 92% go online at home, where most of the use happens. A school that only stores phones protects six hours and leaves children without tools for the other eighteen. If school doesn’t teach them to verify, protect their data and ask for help, who will?</p>
<p><strong>2. For many, the phone is the only computer.</strong> According to the C600 census, 43% of rural public schools and 36% of public schools overall have no internet connection. And among children and teens, daily use of computers and tablets does not exceed 7% in any category. Former vice minister Óscar Sánchez warned that the private schools that banned phones have labs and tablets; much of the country doesn’t.</p>
<p><strong>3. These are skills for working life.</strong> The European {$ext('https://joint-research-centre.ec.europa.eu/digcomp_en', 'DigComp 3.0')} framework (November 2025) defines 21 competences in five areas (information, communication, content creation, safety and wellbeing, and problem solving), with AI built into all of them. In 2024 UNESCO published an {$ext('https://www.unesco.org/en/articles/ai-competency-framework-students', 'AI competency framework for students')}. According to the {$ext('https://www.itu.int/itu-d/reports/statistics/2024/11/10/ff24-youth-internet-use/', 'ITU')}, at least 95% of 15- to 24-year-olds in the Americas use the internet. Those skills aren’t learned with the device locked away for all of secondary school, but by using it well with someone who teaches.</p>
<p><strong>4. UNESCO itself says so.</strong> In 2026 it warned that restricting phones doesn’t remove the need to teach students to navigate digital environments, because school is one of the few places where young people can develop digital literacy and critical thinking.</p>
<p>I make the same case for the workplace in <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">AI Won’t Replace You. Someone Who Masters It Will</a>: the risk isn’t the technology, it’s ending up among those who never learned to use it with judgment.</p>

<h2>Purposeful uses, grade by grade</h2>
<p>“Using phones in class” doesn’t mean “everyone on their own phone,” but an activity with a goal and a time limit; the rest of the time, stored. This is how I would organize it, in line with Bogotá’s rule:</p>
<table>
<thead><tr><th>Grades</th><th>Purposeful use</th><th>What students learn</th></tr></thead>
<tbody>
<tr><td>Kindergarten to grade 5</td><td>No student phones. The teacher uses one device to project, read QR codes in a scavenger hunt or record the class reading aloud</td><td>That technology serves a concrete purpose and has its moment</td></tr>
<tr><td>Grades 6 and 7</td><td>In teams and with school devices when available: photograph plants for an identification key, measure distances on a map, first lessons on passwords and privacy</td><td>Observation, recording evidence and protecting data</td></tr>
<tr><td>Grades 8 and 9</td><td>Collect data with forms for a school survey, create a science podcast, block-based coding, neighborhood maps of risks and resources</td><td>Statistics with real data, communication and computational thinking</td></tr>
<tr><td>Grades 10 and 11</td><td>Lateral reading to verify news, analyze data in a spreadsheet, use AI with judgment and cite it, manage their digital identity with working life in mind</td><td>Verification, analysis, ethics and autonomy</td></tr>
</tbody>
</table>
<p>For primary school, the site’s <a href="/en/tools/qr-code-generator/">free QR code generator</a> helps you set up reading stations or scavenger hunts in minutes. For older students, the free <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel with AI</a> download includes sample data for practicing analysis with judgment. If you teach technology, the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers in Technology and Computing</a> (in Spanish) includes tested recipes for a digital citizenship sequence (footprint, privacy, cyberbullying and personal data), for teaching with few devices or no internet, and for a coding path from unplugged activities to Python. The review of <a href="/codexia-plataforma-programacion-ninos-ideas-aula/">Codexia</a> has ideas for introducing coding to children.</p>

<h2>Digital safety: the three missing lessons</h2>
<p>The Javeriana figures are, at heart, a curriculum:</p>
<ol>
<li><strong>Check before you share.</strong> Find out who is behind it outside the page, compare two sources and check the date, using real news.</li>
<li><strong>Protect personal data.</strong> Set privacy options, remove location from photos and never post your address, school or routines.</li>
<li><strong>Secure accounts and devices.</strong> Long, different passwords, two-step verification, updates and screen lock.</li>
</ol>
<p>I add a fourth: <strong>knowing how to ask for help</strong>. Every student should know the school’s cyberbullying protocol and reporting channels such as {$ext('https://www.teprotejo.org/', 'Te Protejo')}. The Colombian ICT ministry’s {$ext('https://www.mintic.gov.co/portal/715/w3-article-182949.html', 'En TIC Confío+')} program, which reached more than 13 million people in its first ten years, offers free workshops.</p>

<h2>The elephant in the classroom: teacher training</h2>
<p>There is a lot of talk about phones and little about the people who have to manage them. According to the {$ext('https://www.icfes.gov.co/wp-content/uploads/2025/12/INFORME_NACIONAL_RESULTADOS_TALIS_2024.pdf', 'Icfes national TALIS 2024 report')} (in Spanish), 63% of Colombian teachers say their initial training prepared them to use digital tools (the OECD average is 42%), and 79% received training on digital resources in the past year. But 72% still want training in the teaching skills to use them, 78% want it on AI, 70% say training is too expensive and 55% feel unsupported by their employer. The {$ext('https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf', 'Icfes note on AI')} adds that 76% believe their school lacks the necessary infrastructure.</p>
<p>What almost no course teaches is <strong>how to manage 35 phones in one classroom</strong> without turning the lesson into a chase. The debate has focused on the rule and hardly at all on training: Bogotá promises support, but its hours and resources are not yet known. We ask teachers to enforce a rule, teach with the device and handle cyberbullying, without giving them time or tools. These strategies work, and almost none of them cost money:</p>
<ul>
<li><strong>Phone parking.</strong> Numbered pockets at the classroom door. According to the “brain drain” effect (Ward et al., 2017), a phone out of sight is less distracting than one in a pocket.</li>
<li><strong>Three-state signals.</strong> Stored, face down on the desk or in use. A colored card on the board avoids arguments.</li>
<li><strong>One per team.</strong> One phone for every three students, with roles (recorder, checker, presenter). Less distraction, and no one without a device is left out.</li>
<li><strong>BYOD and MDM.</strong> If students may bring their own device, there must be an alternative for those who don’t have one and never an obligation to spend personal data; on school tablets, a mobile device management (MDM) tool limits apps.</li>
<li><strong>Offline plan B.</strong> Every phone activity has a paper version.</li>
<li><strong>Assessment integrity.</strong> Phones parked and different versions of the test. The <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> creates several versions with answer sheet and solutions, and you can try the <a href="/examenes/demo/">free simulator</a> before deciding.</li>
</ul>

<h2>What teachers, school leaders and families say</h2>
<p><strong>Teachers.</strong> In a study by the Union of International Schools (Uncoli) with support from Stanford, cited by {$ext('https://www.infobae.com/colombia/2026/04/21/debate-por-celulares-en-colegios-toma-fuerza-en-colombia-entre-la-prohibicion-y-el-uso-pedagogico-el-gobierno-busca-un-punto-medio/', 'Infobae')} (in Spanish), 61% of teachers reported better concentration and 52% more participation after restricting phones. Many colleagues tell me the same: they don’t want to be screen police, they want to teach.</p>
<p><strong>School leaders.</strong> Camilo Camargo, principal of Colegio Los Nogales and president of Uncoli, says that reducing phone use cut distractions, and Bogotá’s education secretary, Julia Rubiano, talks about recovering “real spaces for play, conversation and coexistence.” But a rural principal doesn’t have the labs of an Uncoli school: a single rule doesn’t work the same everywhere.</p>
<p><strong>Families.</strong> In Mexico’s consultation, 88.8% of 565,396 participants supported the restriction; in Buenos Aires, 5 in 10 students say they want to stop using their phone and can’t. Families are right to ask for limits, but Decree 0769 also gives them duties, and banning phones at school without agreements at home leaves half the job undone.</p>
<p>And let’s not forget the disability exceptions in Bogotá, Brazil and Italy: for a student with low vision or communication difficulties, the device may be essential support. That use should be documented in the student’s PIAR (Colombia’s individual reasonable accommodation plan), and <a href="/herramientas/piar/">PIAR with AI</a> helps write it with concrete accommodations. I go deeper in <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">Inclusion in the classroom: the PIAR in Colombia, Latin America and the world</a>.</p>

<h2>Toolkit</h2>
<h3>1. Classroom phone protocol (template)</h3>
<ol>
<li><strong>General rule:</strong> during the school day, phones stay off or silent, stored in the classroom parking or a locker.</li>
<li><strong>Teaching use:</strong> only when the teacher announces it, with a defined goal, time and app, preferably one per team.</li>
<li><strong>Visible signal:</strong> a three-state card on the board (stored, face down, in use).</li>
<li><strong>Privacy:</strong> no photographing or recording people without consent; no activity requires personal mobile data.</li>
<li><strong>Assessments:</strong> all devices parked; different versions of the test.</li>
<li><strong>Exceptions:</strong> documented health needs, disability and reasonable accommodations, and family emergencies.</li>
<li><strong>If broken:</strong> a conversation; then the device is kept until the end of the day and the family is informed; for cyberbullying, the Law 1620 protocol.</li>
<li><strong>Review:</strong> every semester, with students, teachers and families.</li>
</ol>
<h3>2. Family agreement (template)</h3>
<ol>
<li>The phone sleeps outside the bedroom and charges in a shared space.</li>
<li>No screens at meals or in the hour before bed.</li>
<li>New accounts and apps are installed together and their privacy settings reviewed.</li>
<li>We turn on two-step verification and nobody shares passwords outside the family.</li>
<li>Before sharing anything, we ask who is behind it and whether we checked it.</li>
<li>If something feels wrong or scary, we talk about it without fear of losing the phone.</li>
<li>Once a month we review screen time together and adjust the agreement.</li>
<li>Adults follow the rules too.</li>
</ol>
<h3>3. Four-week teacher training plan</h3>
<ol>
<li><strong>Week 1 · Diagnosis.</strong> Anonymous student survey on use and risks, review of the code of conduct against Decree 0769 and team agreement on the general rule.</li>
<li><strong>Week 2 · Classroom management.</strong> Set up phone parking, practice the three-state signals and design a “one per team” activity with its offline version.</li>
<li><strong>Week 3 · Digital citizenship.</strong> Prepare and teach the three safety lessons (verify, protect data, secure accounts) and share the cyberbullying protocol.</li>
<li><strong>Week 4 · Assessment and families.</strong> Give a test with multiple versions, share results with the department and run a family workshop to sign the home agreement.</li>
</ol>

<h2>Conclusion</h2>
<p>The sentence going around has a hard fact behind it: almost all Colombian children are connected through a phone and almost none has learned to protect themselves. But the answer can’t just be locking the problem in a locker. The evidence supports restricting recreational use, which improves school climate more than learning. What’s missing is the hardest part: teaching with purpose, training teachers and supporting families. A ban is easy to announce; teaching takes time, method and budget.</p>

<p class="notice"><strong>Resources for teaching with purpose.</strong> The <strong>AI Kit for Teachers</strong> (in Spanish) has a <strong>Technology and Computing</strong> edition, from kindergarten to grade 11, at 60,000 Colombian pesos per subject. The <strong>AI Exam Generator</strong> creates different versions for phone-free tests and has a free simulator. <strong>PIAR with AI</strong> lets you try one PIAR for free to document reasonable accommodations. And the <strong>QR code generator</strong> is free. None of them replaces your judgment; they are built to give you more time to teach.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">See the AI Kit for Teachers</a></p>

<h2>Food for thought</h2>
<p>If at school we store children’s phones so they learn to concentrate, and at home we hand them back without having taught them how to use them, are we protecting their childhood or just moving the problem somewhere else? <strong>Who should teach a teenager to live with a technology that will be with them for the rest of their life: the school that takes it away for six hours, the family that handed it over, or the platforms that profit from every minute of their attention?</strong></p>
HTML,
    ],
];
