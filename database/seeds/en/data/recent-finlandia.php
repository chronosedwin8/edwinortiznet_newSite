<?php

declare(strict_types=1);

// English version of the fact-check on Finland's education system, its PISA decline (2000–2025) and the comparison with Colombia and Latin America. Key is the Spanish slug.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/finlandia/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

$pisa25 = 'https://www.oecd.org/content/dam/oecd/en/publications/reports/2026/09/pisa-2025-results-volume-i_5265bfb1/73451bc5-en.pdf';

return [
    'finlandia-sistema-educativo-mito-o-realidad' => [
        'slug' => 'finland-education-system-myth-or-reality',
        'title' => 'Finland’s Education System: Myth or Reality?',
        'excerpt' => 'I fact-check eleven popular claims about Finland’s education system with PISA 2025, the OECD and official Finnish sources: what is true, what is exaggerated and what has already changed. Then I compare it with Colombia and Latin America to separate what can be adapted from what cannot.',
        'seo_title' => 'Finland’s Education System: Myth or Reality?',
        'seo_description' => 'I fact-check 11 claims about Finland’s education system with PISA 2025 and official sources, and compare it with Colombia and Latin America.',
        'focus_keyword' => 'Finland education system',
        'cover' => '/assets/img/articulos/finlandia/finlandia-portada-en',
        'cover_alt' => 'Cover: Finland’s education system, myth or reality? A card shows PISA mathematics scores: Finland 548 in 2006 and 469 in 2025, OECD average 463 and Colombia 381 in 2025',
        'content_html' => <<<HTML
<p>In more than twenty years of teaching, I have heard Finland mentioned at almost every professional development day. That there is no homework and no grades, that children play until age seven, that only the best become teachers and that this is why they sweep international tests. I confess I repeated it too. So when the OECD published the PISA 2025 results on 8 September 2026, I did what I ask of my students: go to the sources and check.</p>
<p>My conclusion is not that Finland is a myth, but that <strong>the Finnish education system circulating on social media no longer exists</strong>, and in some respects never did. There are solid truths, exaggerations, outdated data and a PISA decline that almost nobody mentions. Here I review each claim, compare it with Colombia and Latin America, and suggest what teachers, school leaders and families can adapt.</p>

<h2>The short answer: neither miracle nor fraud</h2>
<p>I checked eleven claims against documents from the Finnish National Agency for Education (OPH), the Ministry of Education and Culture, Finnish legislation, the University of Jyväskylä, which runs PISA in Finland, and the OECD. Result: four are true, three are half true, three are outdated and one is a myth.</p>
{$img('finlandia-mito-realidad', 839, 'Fact-check table of eleven claims about Finland. True: free lunch since 1948, about 8 percent admission to class-teacher education in Helsinki, fewer class hours and valued teachers. Half true: everything free, school starting at 7 and children loving school. Outdated: no grades or exams, collapsing applications and Finland at the top of PISA. Myth: subjects were scrapped', 'Eleven claims fact-checked. Details and sources for each are below.')}

<h2>The decline few people mention: Finland in PISA 2000–2025</h2>
<p>Finland topped reading in the first PISA, in 2000, and for a decade it was the obligatory reference. Since then it has fallen in every subject and in every recent cycle. According to the {$ext($pisa25, 'OECD PISA 2025 report')} (Volume I, Table I.1 and trend annexes), these are its scores:</p>
<table>
<thead><tr><th>Subject</th><th>Finland’s best year</th><th>2022</th><th>2025</th><th>OECD average 2025</th></tr></thead>
<tbody>
<tr><td>Reading</td><td>547 (2006)</td><td>490</td><td><strong>474</strong></td><td>461</td></tr>
<tr><td>Mathematics</td><td>548 (2006)</td><td>484</td><td><strong>469</strong></td><td>463</td></tr>
<tr><td>Science</td><td>563 (2006)</td><td>511</td><td><strong>504</strong></td><td>482</td></tr>
</tbody>
</table>
{$img('finlandia-pisa-tendencia', 640, 'Line chart of Finland in PISA from 2000 to 2025 versus the average of 23 OECD countries. Reading falls from 547 in 2006 to 474 in 2025; mathematics from 548 to 469; science from 563 to 504. In mathematics Finland now equals the comparable OECD average', 'In mathematics Finland has lost 79 points since 2006 and is now level with the comparable OECD average.')}
<p>Finland is still above the OECD average in all three subjects and ranks 12th of 91 systems in science, according to {$ext('https://yle.fi/a/74-20245073', 'Yle')}. It is not a system in crisis. But the trend is unmistakable, and the details are more worrying than the averages:</p>
<ul>
<li><strong>More students falling behind.</strong> Students below the baseline level in mathematics rose from 6.8% in 2003 to 24.9% in 2022 and 31.0% in 2025. In reading, from 21.4% to 25.8% between 2022 and 2025.</li>
<li><strong>Fewer top performers.</strong> In mathematics, students at Level 5 or 6 fell from 23.4% in 2003 to 6.7% in 2025.</li>
<li><strong>A huge gender gap in reading.</strong> Girls outscore boys by 46 points (498 versus 452), one of the widest gaps in the world; the OECD average is 30.</li>
<li><strong>An immigrant gap twice the OECD’s.</strong> In science, students without an immigrant background score 517 and those with one score 429: an 88-point difference, versus 43 in the OECD. They are about 7% of students tested, according to the {$ext('https://www.jyu.fi/en/news/pisa-2025-students-in-finland-still-perform-well-above-oecd-average-in-science', 'University of Jyväskylä national report')}.</li>
<li><strong>The decline is no longer only among the disadvantaged.</strong> Between 2022 and 2025, students from advantaged families fell 12 points in science while disadvantaged students held steady. Swedish-speaking schools went from 526 to 495 in science.</li>
<li><strong>Less perseverance.</strong> Only 41% of Finnish students say they put in extra effort when work becomes challenging, the lowest figure of all participants.</li>
</ul>
<p>It is not an isolated case: according to the PISA 2025 preface, the OECD average fell 22 points in mathematics and 28 in reading between 2015 and 2025, and the decline began before the pandemic. I analysed this for our region in <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA results in Latin America</a>. What sets Finland apart is the magnitude: few countries have lost so much since their best moment.</p>

<h2>Fact-checking, claim by claim</h2>

<h3>“Everything is free, from preschool to university”: half true</h3>
<p>Basic education, upper secondary and learning materials are free. Since {$ext('https://eurydice.eacea.ec.europa.eu/news/finland-compulsory-education-extended-until-age-18', 'compulsory education was extended to age 18')} on 1 August 2021, upper secondary materials are free too. The {$ext('https://toolbox.finland.fi/wp-content/uploads/sites/2/2021/10/school-meals-a-finnish-succes-story-two-pager.pdf', 'free hot school meal')} has existed since 1948 and covers pre-primary, basic and upper secondary education; school health care and transport, when the trip is over 5 kilometres, are also free.</p>
<p>But early childhood education, before pre-primary, <strong>is not free</strong>: fees depend on family income, with a cap that since 1 August 2026 is {$ext('https://www.pori.fi/app/uploads/sites/2/2026/05/varhaiskasvatusmaksut-1.8.2026.pdf', '335 euros a month')} for the first child. And since 2017 students from outside the European Union pay tuition in English-taught university programmes, which moved to full-cost fees in 2026; at the University of Turku, {$ext('https://www.utu.fi/en/news/press-release/university-of-turkus-international-degree-programmes-open-for-applications-on-7', '10,000 to 12,000 euros a year')}.</p>

<h3>“School starts at 7 and before that they just play”: half true</h3>
<p>Compulsory schooling starts in the year a child turns 7, but since August 2015 {$ext('https://eurydice.eacea.ec.europa.eu/eurypedia/finland/access', 'pre-primary education has been compulsory at 6')}, with at least 700 hours a year. And it is not just free play: it follows a national core curriculum. In addition, 91.3% of children aged 3 to 5 attend early childhood education.</p>
<p>A little-known fact: between 2021 and 2024 Finland trialled two-year pre-primary education in 148 municipalities with 37,357 children. The {$ext('https://www.jyu.fi/fi/uutinen/kaksivuotisen-esiopetuksen-kokeilun-tulokset-julki', 'final report')} (in Finnish), published on 14 January 2026, found that learning outcomes were the same as in the current model and that gaps did not narrow. So far there is no decision to make it permanent.</p>

<h3>“No numerical grades and no exams”: outdated</h3>
<p>In grades 1 to 3, each municipality decides whether assessment is verbal or numerical. Since the 2020 curriculum amendment, end-of-year reports in grades 4 to 8 and the final certificate must carry <strong>numerical grades</strong> on a 4–10 scale, according to the {$ext('https://www.oph.fi/fi/koulutus-ja-tutkinnot/luku-6-oppilaan-oppimisen-ja-osaamisen-arviointi-perusopetuksessa', 'OPH')}. National criteria for the final grade in grade 9 have existed since 2021, and for grade 6 since 2023.</p>
<p>It is true that there are no census tests in basic education: the evaluation centre Karvi assesses samples. But at the end of general upper secondary there is the Matriculation Examination (<em>ylioppilastutkinto</em>), fully digital since 2019, which has counted for university admission since 2020. And in June 2026 Parliament passed the {$ext('https://valtioneuvosto.fi/-/1410845/osaamistakuuta-koskeva-lainsaadanto-on-hyvaksytty-1', 'competence guarantee act')} (619/2026), which will set a national minimum level for moving up a grade from August 2027. Finland is heading toward more common assessment, not less.</p>
<p>The lesson for us is not “no exams” but “assess to learn”. That is why I built the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>: it creates short quizzes and several versions of the same exam with an answer key, so frequent assessment doesn’t cost you your weekend. You can try it for free in the <a href="/examenes/demo/">demo</a>.</p>

<h3>“Only the best students become teachers”: true, with nuances</h3>
<p>Since 1979, primary school teachers have needed a <strong>master’s degree</strong>, according to {$ext('https://tuni.fi/en/news/teachers-must-also-have-time-learn', 'Tampere University')}. Selectivity is real: in 2025, the University of Helsinki class-teacher programme received 1,532 applicants and admitted 125, or 8.2%, according to the {$ext('https://www.helsinki.fi/assets/drupal/2025-09/Yhteishaussa%20kandiohjelmiin%20hakeneet,%20hyv%C3%A4ksytyt%20ja%20opiskelupaikan%20vastaanottaneet%20hakukohteittain%20ja%20tiedekunnittain%208.9.2025.pdf', 'university’s figures')}. The entrance exam is national and since 2025 has been called Valintakoe E, replacing the former VAKAVA.</p>
<p>Have applications collapsed? That is outdated: the sharp drop came between 2016 and 2019, from about 6,500 to 5,300 applicants nationwide, and in 2020 numbers rose above 6,000 again, according to the {$ext('https://www.oph.fi/fi/uutiset/2020/opettajan-ammatti-kiinnostaa-yha-useampia-taydennys-ja-jatkokoulutusta-tarvitaan', 'OPH')}. In Helsinki, the decline between 2023 and 2025 was about 8%.</p>
<p>In Colombia, selection is competitive too: 378,212 candidates sat the written test of the 2022 teacher selection process for 37,480 vacancies, about ten per post, according to the {$ext('https://www.mineducacion.gov.co/portal/salaprensa/Comunicados/412272:Mas-de-378-mil-aspirantes-al-proceso-de-seleccion-Docentes-y-Directivos-Docentes-asistieron-a-la-jornada-de-pruebas-escritas-en-todo-el-pais', 'Ministry of Education')}. The difference is where the filter sits: Finland selects at the entrance to teacher education and then trusts; we filter at the end, with an exam, people who have already trained. If you are preparing for the next process, the <a href="/herramientas/simulacro-concurso-docente/">free teacher exam practice test</a> lets you measure yourself, and I track <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">the new process’s schedule</a> here.</p>

<h3>“Fewer class hours and little homework”: true</h3>
<p>According to the OECD’s {$ext('https://data-explorer.oecd.org/', 'Education at a Glance database')}, a Finnish student receives 6,413 compulsory instruction hours across primary and lower secondary. The OECD average is 7,604 and Colombia’s is 9,800: 53% more than Finland. In grades 1 and 2 the school day has at most five 45-minute lessons, according to the {$ext('https://www.oph.fi/fi/koulutus-ja-tutkinnot/tyoajat', 'OPH')}. In PISA 2012, Finnish students reported less than three hours of homework a week, versus almost five in the OECD, according to the {$ext('https://doi.org/10.1787/5jxrhqhtx2xt-en', 'OECD')}.</p>
<p>But note: since August 2025 Finland has {$ext('https://www.oph.fi/fi/koulutus-ja-tutkinnot/perusopetukseen-lisaa-aikaa-opiskella-aidinkielta-ja-kirjallisuutta-seka', 'added three weekly lessons')} of mother tongue and mathematics in the early grades. More hours do not guarantee more learning, and Colombia is the proof, but in early reading and arithmetic Finland was short of time.</p>

<h3>“They scrapped subjects for phenomenon-based learning”: myth</h3>
<p>In March 2015 several international media outlets reported that Finland would “scrap subjects”. It wasn’t true. The {$ext('https://www.oph.fi/sites/default/files/documents/perusopetuksen_opetussuunnitelman_perusteet_2014.pdf', '2014 national core curriculum')}, in force since 2016, requires at least one <strong>multidisciplinary learning module per school year</strong>, built around a real phenomenon or problem. Subjects still exist, and Pasi Sahlberg, the model’s best-known ambassador, {$ext('https://pasisahlberg.com/finlands-school-reforms-wont-scrap-subjects-altogether/', 'clarified it at the time')}.</p>
<p>The idea, however, is usable: one project a year that integrates subjects and ends in a real product fits in any Colombian school. That is what I built the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> for: it includes recipes by subject, aligned with Colombia’s standards and learning benchmarks, to plan project-based units and integrate subjects without starting from scratch.</p>

<h3>“Finnish children love school”: half true</h3>
<p>The School Health Promotion study by the THL institute shows a decline. In grades 8 and 9, liking school fell from 60% in 2019 to 51% in 2025, and in grades 4 and 5 from 78% to 70%. Weekly bullying in grades 8 and 9 rose from 5% to 8%; the {$ext('https://www.oph.fi/fi/uutiset/2025/kouluterveyskysely-2025-kouluissa-ja-oppilaitoksissa-rakennettava-yhteisollisyys-tukee', 'OPH')} acknowledges that nearly one in ten basic education pupils is bullied every week. On the plus side, in PISA 2025 students’ sense of belonging remained above the OECD average.</p>

<h3>“Teachers are highly valued”: true, but declining</h3>
<p>In TALIS 2024, the OECD’s international teacher survey, 48% of Finnish lower secondary teachers feel society values their profession, versus 22% on average in the OECD, according to the {$ext('https://jyx.jyu.fi/bitstreams/129367e8-54eb-47d6-9121-d888980ef468/download', 'Ministry of Education’s national report')}. But that is 10 points lower than in 2018, and job satisfaction fell from 91% in 2013 to 85%. In Colombia, according to the {$ext('https://www.icfes.gov.co/wp-content/uploads/2025/11/20251118_informe-Talis_19_11_25.pdf', 'Icfes report')} and {$ext('https://fundacionexe.org.co/wp-content/uploads/2025/11/133_Talis_2024.pdf', 'Fundación Empresarios por la Educación')}, 97% of teachers are satisfied with their job, more than half feel valued by society and over 90% would choose teaching again.</p>

<h2>Why did Finland decline? The debate at home</h2>
<p>There is no single explanation, and Finnish researchers avoid simple answers. These are the hypotheses with the most support:</p>
<ol>
<li><strong>Less reading for pleasure.</strong> In PISA 2018, 63% of Finnish boys said they read only when they had to, according to {$ext('https://yle.fi/a/3-11100956', 'Yle')}. After PISA 2025, researcher Arto Ahonen noted that reading on paper is increasingly uncommon.</li>
<li><strong>Screens and phones.</strong> Sahlberg has warned that young people spend many hours on devices, read less and sleep worse, and the OECD links the decline in reading to digitalisation and screen time.</li>
<li><strong>Municipal cuts.</strong> After the 2008 crisis, many municipalities closed or merged schools, enlarged classes and cut support staff, according to Sahlberg in a {$ext('https://gulfnews.com/lifestyle/why-finlands-schools-seem-to-be-slipping-1.1953014', 'column for The Washington Post')}.</li>
<li><strong>Inclusion without enough resources.</strong> OPH Director General Minna Kelha wrote in 2023 that “inclusion must not be used as an excuse for saving money” and that resources did not reach everywhere ({$ext('https://www.oph.fi/en/blog/pisa-results-reflect-broader-changes-finnish-society', 'OPH')}). Today special education teachers are scarce: in Pori, 11 of 18 posts were unfilled in March 2026, according to {$ext('https://yle.fi/a/74-20215258', 'Yle')}.</li>
<li><strong>Migration: a real but minor factor.</strong> Students with an immigrant background are about 7% of those tested, and the gap narrowed partly because native students fell more, so it does not explain the overall decline, according to the {$ext('https://www.jyu.fi/fi/uutinen/maahanmuuttajataustaisten-nuorten-osaaminen-pisa-2022-tutkimuksessa', 'University of Jyväskylä')}.</li>
<li><strong>Critics of the story.</strong> Tim Oates of Cambridge Assessment argues that Finland “peaked in 2000” and stopped doing what made it successful ({$ext('https://cambridgeassessment.org.uk/blogs/finland-old-stories-new-headlines', 'Cambridge Assessment')}). Gabriel Heller Sahlgren, in <em>Real Finnish Lessons</em> (2015), argues that success came from a traditional, disciplined school culture that predated the reforms, and that its erosion explains the decline ({$ext('https://www.ifn.se/en/news/2011-2015/2015-04-15-modern-school-policy-did-not-create-the-finnish-miracle', 'IFN')}).</li>
</ol>
<p>One hypothesis circulates widely that I could not support with data: that the 2016 curriculum caused the decline. The trend began years before it came into force, so at the very least it is not the main cause.</p>

<h2>How Finland is responding</h2>
<p>The most interesting thing about today’s Finland is not its legend but its reaction:</p>
<ul>
<li><strong>Phone restrictions.</strong> Act {$ext('https://www.finlex.fi/fi/lainsaadanto/saadoskokoelma/2025/245', '245/2025')}, in force since 1 August 2025, bans phone use during lessons unless the teacher allows it for learning or for health reasons. I analysed this in <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">phones at school: ban them or teach with them?</a></li>
<li><strong>Learning support reform.</strong> Since August 2025, Act 1090/2024 has replaced the three-tier support model with more group-based support and more resources, about 100 million euros in extra funding according to {$ext('https://yle.fi/a/74-20149497', 'Yle')}.</li>
<li><strong>More reading and more hours.</strong> Three more weekly lessons in the early grades and a national {$ext('https://www.oph.fi/fi/teemat-ja-kehittaminen/lukutaito-ohjelma', 'literacy programme')} run by the OPH.</li>
<li><strong>National minimums.</strong> The competence guarantee act, from 2027, with common criteria for moving up a grade.</li>
</ul>
<p>The world’s symbol of autonomy is adding rules, time and measurement. I don’t read it as a failure, but as the first thing we should imitate: looking at oneself honestly and correcting course.</p>

<h2>Finland, Colombia and Latin America in figures</h2>
<p>Comparing without context leads to wrong conclusions. I gathered six OECD indicators, with Chile and Mexico as Latin American references because they have comparable data for all of them.</p>
{$img('finlandia-colombia-indicadores', 1084, 'Comparative bars for Finland, Colombia, Chile and Mexico with the OECD average as a reference line. Spending per student: Finland 16,141 USD PPP, Colombia 3,405. Starting teacher salary: Finland 50,227, Colombia 36,196. Instruction hours: Finland 6,413, Colombia 9,800. Enrolment at age 3: Finland 87.4 percent, Colombia 55.3. Students per teacher in primary: Finland 12, Colombia 22.2. PISA 2025 mathematics: Finland 469, Colombia 381', 'Finland spends almost five times more per student than Colombia, with fewer hours, smaller classes and more early childhood education.')}
<table>
<thead><tr><th>Indicator</th><th>Finland</th><th>Colombia</th><th>OECD average</th></tr></thead>
<tbody>
<tr><td>Spending per student, primary to tertiary (USD PPP, 2023)</td><td>16,141</td><td>3,405*</td><td>15,897</td></tr>
<tr><td>Spending on educational institutions (% of GDP, 2023)</td><td>5.4%</td><td>3.5%*</td><td>4.7%</td></tr>
<tr><td>Compulsory hours, primary and lower secondary (2025)</td><td>6,413</td><td>9,800</td><td>7,604</td></tr>
<tr><td>Average class size in lower secondary (2024)</td><td>19.4</td><td>27.5</td><td>22.8</td></tr>
<tr><td>3-year-olds in early childhood education (2024)</td><td>87.4%</td><td>55.3%</td><td>81.5%</td></tr>
<tr><td>PISA 2025: mathematics, reading and science</td><td>469 / 474 / 504</td><td>381 / 399 / 414</td><td>463 / 461 / 482</td></tr>
</tbody>
</table>
<p><small>* The OECD flags that Colombia’s figure excludes independent private institutions; in practice it is public spending and should be read as a floor. Sources: Education at a Glance database (updated July 2026) and PISA 2025.</small></p>
<p>Two figures deserve comment. A Colombian lower secondary teacher’s starting salary is 72% of a Finnish teacher’s, and the OECD calculates that, after 15 years of experience, it equals 2.11 times what an average Colombian university graduate earns, versus 0.79 in Finland. That doesn’t mean teachers are well paid here, but that graduates in general earn little. And the simple average of the 13 Latin American countries in PISA 2025 was 370 in mathematics, 389 in reading and 399 in science. Colombia, at 381, 399 and 414, is slightly above the regional average but far from the OECD.</p>

<h2>What can be transferred to Colombia and what cannot</h2>

<h3>What cannot be imported by decree</h3>
<ul>
<li><strong>Social trust.</strong> In Finland parents don’t check every grade because they trust the teacher, and the teacher works without constant inspection because society trusts their training. That trust was built over decades and is as much an effect of good results as a cause.</li>
<li><strong>The welfare state.</strong> A Finnish child arrives at school with health, food and housing reasonably secured. In Colombia, the School Feeding Programme reached 85.5% coverage in 2026, according to {$ext('https://radionacional.co/actualidad/educacion/programa-de-alimentacion-escolar-llego-al-855-de-cobertura-en-2026', 'Radio Nacional')}, and the Comptroller warned that 1.3 trillion pesos were missing to avoid leaving out 1.6 million students ({$ext('https://www.elespectador.com/educacion/contraloria-advierte-que-faltan-13-billones-para-financiar-el-pae-de-2026/', 'El Espectador')}). Finland solved this in 1948.</li>
<li><strong>Spending.</strong> With just over a third of Chile’s spending per student and a fifth of Finland’s, expecting Nordic results from Colombian schools is unfair.</li>
</ul>

<h3>What we can adapt</h3>
<ul>
<li><strong>Quality early childhood education.</strong> Net enrolment in Colombia’s transition grade was 57.5% in 2025, according to the {$ext('https://www.mineducacion.gov.co/portal/anos/2026/350799:Informacion-Cobertura-en-cifras-2025', 'Ministry of Education’s coverage data')}, although that calculation depends on DANE population projections. Comprehensive early childhood care reached about 2.06 million children in 2025. It is the investment with the best return, and Finland reminds us that quality matters more than years: its two-year pre-primary trial did not improve learning.</li>
<li><strong>Early support inside the classroom.</strong> Finland’s historical strength was spotting difficulties early and providing specialised support without waiting for a diagnosis. Colombia has an advanced rule, Decree 1421 of 2017 and the PIAR (individual plan of reasonable accommodations), and about 217,000 students with disabilities enrolled in 2025, but few support teachers. I analysed this in <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusion in the classroom: the PIAR in Colombia, Latin America and the world</a>, and to ease the paperwork I built <a href="/herramientas/piar/">PIAR with AI</a>, which gives you the first plan for free.</li>
<li><strong>Autonomy with accountability.</strong> Finnish autonomy was never an absence of rules: there is a national curriculum, assessment criteria and now minimum competences. What can be adapted is giving teachers room to decide how to teach, in exchange for clear agreements on what students must learn.</li>
<li><strong>Equity in funding.</strong> Colombia cannot pay for Finnish class sizes everywhere, but it can prioritise the early grades and rural schools, where each extra student per class weighs more.</li>
</ul>

<h2>What this means for teachers, school leaders and families</h2>
<p><strong>If you are a teacher</strong>, Finland’s most useful lesson is not a technique but a priority: sustained reading from the early grades, frequent low-stakes assessment and early support for those falling behind. And perseverance can be taught too: asking students to keep trying when a problem gets hard is worth more than any platform.</p>
<p><strong>If you are a school leader</strong>, protect reading time, organise learning support as teamwork rather than paperwork, and be wary of imported reforms without resources: Finland learned that inclusion without support staff turns into overload.</p>
<p><strong>If you are a parent</strong>, don’t expect your child’s school to “be like Finland”: expect them to read every day, to be taught to persevere and for someone to notice early if they are falling behind. At home, reading for pleasure and limits on screens do more than any extra homework.</p>
<p>If you want to see how other countries often held up as examples, such as Estonia, Japan or Singapore, compare, I recommend my analysis of <a href="/mejores-sistemas-educativos-del-mundo-colombia/">the best education systems in the world and what Colombia can learn</a>.</p>

<p class="notice"><strong>The best of Finland, adapted to your classroom.</strong> The <strong>AI Kit for Teachers</strong> helps you plan projects and interdisciplinary units aligned with Colombian standards, for 60,000 Colombian pesos per subject. The <strong>AI Exam Generator</strong> creates formative assessments in several versions, with plans from 29,900 pesos. <strong>PIAR with AI</strong> lets you build the first PIAR for free and then choose packages of 5, 10 or 20 plans. And if you’re preparing for Colombia’s teacher selection exam, the <a href="/herramientas/simulacro-concurso-docente/">practice test</a> is free. None of them replaces your judgement: they’re built to give you time for what matters.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">See the AI Kit for Teachers</a></p>

<h2>Frequently asked questions</h2>
<h3>Is Finland’s education system still the best in the world?</h3>
<p>Not according to PISA. In 2025 Finland scored 504 in science, 474 in reading and 469 in mathematics, above the OECD average but far behind Singapore, Japan, Korea, Estonia or the Chinese jurisdictions at the top. It is an equitable, good-quality system, but no longer the leader.</p>
<h3>How much has Finland dropped in PISA?</h3>
<p>Since 2006, its best year, it has lost 79 points in mathematics (from 548 to 469), 73 in reading (from 547 to 474) and 59 in science (from 563 to 504). Between 2022 and 2025 it fell 15 points in mathematics and 16 in reading.</p>
<h3>At what age do children start school in Finland?</h3>
<p>Compulsory schooling starts in the year they turn 7, but since 2015 pre-primary education has been compulsory at 6, and more than 90% of children aged 3 to 5 attend early childhood education. Since 2021, education has been compulsory until 18.</p>
<h3>Is it true that Finland has no grades or exams?</h3>
<p>No. In grades 4 to 8, end-of-year reports carry numerical grades from 4 to 10, there are national criteria for grades 6 and 9, and at the end of upper secondary there is a national Matriculation Examination. What doesn’t exist are census tests in basic education, although a 2026 law will set national minimums from 2027.</p>
<h3>What can Colombia learn from Finland’s education system?</h3>
<p>The most transferable lessons are investing in quality early childhood education, spotting and supporting struggling students early, selecting and training teachers well, assessing to learn and granting autonomy with clear agreements. What cannot be copied by decree is the social trust and the welfare state that sustain them.</p>

<h2>Food for thought</h2>
<p>Finland built its prestige on one idea: trusting teachers instead of constantly measuring them. Today, after almost twenty years of decline, it has passed a law setting national minimums and added hours, rules and common assessment. Colombia, by contrast, measures a lot and trusts little. <strong>If the country that trusted its teachers most is starting to measure more, could it be that trust was a reward for good results rather than their cause? And if so, what would we Colombians be willing to give up, in control, in testing or in suspicion, to give our teachers that trust before the results justify it?</strong></p>
HTML,
    ],
];
