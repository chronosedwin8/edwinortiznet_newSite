<?php

declare(strict_types=1);

// English version of the analysis comparing the world's best education systems with Colombia and Latin America. Key is the Spanish slug.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/mejores-sistemas/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

return [
    'mejores-sistemas-educativos-del-mundo-colombia' => [
        'slug' => 'best-education-systems-in-the-world-colombia',
        'title' => 'The World’s Best Education Systems: What They Did and What Colombia Is Missing',
        'excerpt' => 'I compare Singapore, China, Japan, South Korea, Estonia and Finland with Colombia and Latin America using PISA 2025, Education at a Glance 2026 and TALIS 2024. I explain how they got to the top, what cannot be copied, and close with a checklist for Colombia: where we stand, what is missing and who has to do what.',
        'seo_title' => 'Best Education Systems in the World vs. Colombia',
        'seo_description' => 'Singapore, China, Japan, Korea, Estonia and Finland versus Colombia with PISA 2025: how they reached the top, what not to copy and a checklist.',
        'focus_keyword' => 'best education systems in the world',
        'cover' => '/assets/img/articulos/mejores-sistemas/mejores-sistemas-portada-en',
        'cover_alt' => 'Cover: The world’s best education systems and what Colombia is missing. A card shows PISA 2025 mathematics scores: China (B-S-J-Z) 612, Singapore 563, Estonia 508, OECD average 463 and Colombia 381',
        'content_html' => <<<HTML
<p>Every time PISA results come out, the same scene plays out: headlines about Singapore and China at the top, a paragraph about Finland, a sad line about Colombia and, a week later, the topic disappears. I have been teaching mathematics and technology in Colombian schools for more than twenty years, and the headline is no longer enough for me. I want to understand <strong>what the world’s best education systems did, how much of it depends on money, how much on culture and how much on decisions Colombia could also make</strong>.</p>
<p>On September 8, 2026, the OECD published the {$ext('https://www.oecd.org/en/publications/2026/09/pisa-2025-results-volume-i_5265bfb1.html', 'PISA 2025 results')}: 91 countries and economies, more than 760,000 fifteen-year-olds and the lowest OECD average in the history of the test in all three subjects. With that data, {$ext('https://data-explorer.oecd.org/', 'Education at a Glance 2026')} and the TALIS 2024 teacher survey, I built this comparison, which ends with a checklist for Colombia.</p>

<h2>PISA 2025: who is on top and where Colombia stands</h2>
<p>Asian systems dominate again. In mathematics, the Chinese sample of Beijing, Shanghai, Jiangsu and Zhejiang (B-S-J-Z) scored 612, Singapore 563, Macao 549, Chinese Taipei 546, Japan 525, and South Korea and Hong Kong 522. Estonia, Europe’s best, scored 508. Finland, the model for years, fell to 469, just six points above the OECD average (463).</p>
<p>Colombia scored <strong>381 in mathematics, 399 in reading and 414 in science</strong>, according to the {$ext('https://www.oecd.org/en/publications/pisa-2025-results-volume-i-country-notes_2d4ff9ea-en/colombia_d64a60a2-en.html', 'OECD country note')}. The changes since 2022 are not statistically significant (−2, −9 and +3), but the decline in mathematics and reading since 2018 is. In the region, Uruguay, Chile, Mexico, Costa Rica and Peru are ahead of us.</p>
<table>
<thead><tr><th>System</th><th>Mathematics</th><th>Reading</th><th>Science</th></tr></thead>
<tbody>
<tr><td>China (B-S-J-Z)</td><td>612</td><td>527</td><td>597</td></tr>
<tr><td>Singapore</td><td>563</td><td>535</td><td>560</td></tr>
<tr><td>Japan</td><td>525</td><td>503</td><td>538</td></tr>
<tr><td>South Korea</td><td>522</td><td>501</td><td>526</td></tr>
<tr><td>Estonia</td><td>508</td><td>499</td><td>527</td></tr>
<tr><td>Finland</td><td>469</td><td>474</td><td>504</td></tr>
<tr><td><strong>OECD average</strong></td><td>463</td><td>461</td><td>482</td></tr>
<tr><td>Chile</td><td>403</td><td>436</td><td>442</td></tr>
<tr><td>Mexico</td><td>388</td><td>408</td><td>414</td></tr>
<tr><td><strong>Colombia</strong></td><td><strong>381</strong></td><td><strong>399</strong></td><td><strong>414</strong></td></tr>
<tr><td>Brazil</td><td>377</td><td>408</td><td>409</td></tr>
</tbody>
</table>
{$img('mejores-sistemas-pisa-2025', 952, 'Dot chart of PISA 2025 scores in mathematics, reading and science. At the top, China (B-S-J-Z) with 612 in mathematics, Singapore 563, Macao 549, Chinese Taipei 546, Japan 525, Hong Kong and South Korea 522, Estonia 508 and Finland 469. OECD average: 463. Below, Uruguay 405, Chile 403, Mexico 388, Costa Rica 387, Peru 382, Colombia 381, Brazil 377, Argentina 367, El Salvador 346, Dominican Republic 339, Guatemala and Paraguay 334', 'PISA 2025: 231 points in mathematics separate the Chinese sample from Colombia. In PISA, about 20 points roughly equal one year of schooling.')}
<p>PISA 2022 showed the same order: Singapore 575, Japan 536, Korea 527, Estonia 510, Finland 484 and Colombia 383, according to {$ext('https://www.oecd.org/content/dam/oecd/en/publications/reports/2023/12/pisa-2022-results-volume-i_76772a36/53f23881-en.pdf', 'PISA 2022 Volume I')}; in 2018 the Chinese sample had scored 591. This is a trend, not a stroke of luck.</p>

<h2>Beyond the average: how many fall behind and how many excel</h2>
<p>The average hides what matters most. PISA defines Level 2 as the baseline for using mathematics in simple everyday situations. In Colombia, <strong>71% of fifteen-year-olds do not reach it</strong>. In Singapore it is 11.2%; in Japan, 16.1%; across the OECD, 34.9%. At the other end, only 0.2% of Colombian students reach Levels 5 and 6, versus 37.4% in Singapore and 54.2% in the Chinese sample.</p>
{$img('mejores-sistemas-desempeno', 1008, 'Diverging bar chart of PISA 2025 mathematics. On the left, the percentage of students below Level 2: China (B-S-J-Z) 3.6 percent, Singapore 11 percent, Japan 16 percent, OECD average 35 percent, Chile 59 percent, Colombia 71 percent and Guatemala 92 percent. On the right, the percentage at Levels 5 and 6: China 54 percent, Singapore 37 percent, OECD 7.8 percent and Colombia 0.2 percent', 'In mathematics, Colombia has almost seven times as many low performers as Singapore and almost no top performers.')}
<p>Worse still: 43.9% of Colombian students are below Level 2 in all three subjects at once (OECD: 19.7%). This is not a mathematics problem; it is a foundations problem.</p>

<h2>The trend: who improves, who stalls and who falls</h2>
<table>
<thead><tr><th>Mathematics</th><th>2012</th><th>2018</th><th>2022</th><th>2025</th></tr></thead>
<tbody>
<tr><td>Singapore</td><td>574</td><td>569</td><td>575</td><td>563</td></tr>
<tr><td>Japan</td><td>536</td><td>527</td><td>536</td><td>525</td></tr>
<tr><td>South Korea</td><td>554</td><td>526</td><td>527</td><td>522</td></tr>
<tr><td>Estonia</td><td>521</td><td>523</td><td>510</td><td>508</td></tr>
<tr><td>Finland</td><td>519</td><td>507</td><td>484</td><td>469</td></tr>
<tr><td>OECD average (35 countries)</td><td>491</td><td>490</td><td>475</td><td>466</td></tr>
<tr><td>Chile</td><td>423</td><td>417</td><td>412</td><td>403</td></tr>
<tr><td><strong>Colombia</strong></td><td>377</td><td>391</td><td>383</td><td>381</td></tr>
</tbody>
</table>
<p>Three takeaways. First: almost everyone is declining, including the best; the pandemic and changes in reading habits and screen use weigh everywhere, as I discussed when analyzing <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA in Latin America</a>. Second: Colombia remains just four points above its 2012 score and lost what it had gained up to 2018. Third: Finland lost 50 points in thirteen years, roughly two and a half years of schooling. No system is safe.</p>

<h2>How the world’s best education systems reached the top</h2>
<h3>Singapore: a state plan and a teacher pipeline</h3>
<p>Singapore became independent in 1965 with no natural resources and decided its resource would be its people. What stands out is the consistency: in 1997 Prime Minister Goh Chok Tong launched “Thinking Schools, Learning Nation”; in 2004 Lee Hsien Loong announced “Teach Less, Learn More,” which cut content to go deeper; in 2023 it {$ext('https://www.moe.gov.sg/news/parliamentary-replies/20231003-effect-of-removing-mid-year-examinations', 'removed mid-year examinations')}, and in 2024 it ended the “Express” and “Normal” streams in secondary school. Each reform corrects the previous one, but the direction does not change.</p>
<p>Teachers are the heart of the system. There is a single teacher-education institution, the National Institute of Education (NIE), and the Ministry recruits roughly from the top third of each cohort. Training is {$ext('https://www.moe.gov.sg/careers/become-teachers/pri-sec-jc-ci/postgraduate-diploma', 'fully funded by the Ministry')}, and future teachers commit to teach for at least three years. In 2026 it announced raises of 2% to 9% to stay competitive with the market. In TALIS 2024, 71% of Singapore’s teachers felt their profession is valued by society.</p>
<p>Two caveats: Singapore spends only {$ext('https://data.worldbank.org/indicator/SE.XPD.TOTL.GD.ZS?locations=SG', '2.19% of its GDP on education')} (2024), because its GDP per capita is very high: cumulative spending per student exceeds USD 166,000. And it is one of the systems where social background weighs most: 103 points separate the richest and poorest quarters in mathematics, more than the OECD average (83). The {$ext('https://www.moe.gov.sg/news/press-releases/20260908-pisa-2025-singapore-students-demonstrate-strong-real-world-problem-solving-skills-in-computational-thinking-domain', 'Ministry of Education')} itself acknowledges that the gap between its top and low performers widened.</p>

<h3>China, Hong Kong, Macao and Taipei: excellence with an asterisk</h3>
<p>China’s 612 points must be read carefully. The B-S-J-Z sample covers only four of the country’s richest regions; the OECD itself warned in 2018 that they are “far from representing China as a whole,” and they account for about 13% of its population. It is as if Colombia took part with only Bogotá, Medellín, Bucaramanga and Tunja.</p>
<p>China also shows the costs of the model. In 2021 it launched the {$ext('https://www.wilmerhale.com/en/insights/client-alerts/20210823-china-releases-double-reduction-policy-in-education-sector', '“double reduction” policy')}, which banned for-profit tutoring in school subjects during compulsory education, to ease the pressure on families. Taipei held steady (547 in 2022 and 546 in 2025), while Hong Kong fell 18 points in mathematics and 20 in reading. Macao, by contrast, is the most equitable case in the group: socio-economic status explains just 4.2% of the variation in mathematics there, versus 12% in the OECD and 17% in Colombia.</p>

<h3>Japan and South Korea: rigor, prestige and the price of pressure</h3>
<p>Japan and Korea share a culture that treats study as a family duty. In Korea, primary teacher training takes students from among the best on the national entrance exam, according to the {$ext('https://www.mona.uwi.edu/cop/sites/default/files/resource/files/how-the-worlds-best-performing-school-systems-come-out-on-top-sept-072.pdf', '2007 McKinsey report')}. Japan is famous for “lesson study” (<em>jugyō kenkyū</em>), in which teachers plan, observe and refine the same lesson together.</p>
<p>But there is a dark side. In 2025 Korean families spent {$ext('https://www.koreajoongangdaily.com/korea/private-education-spending-for-grade-school-students-hits-record-high-in-2025/12560246', '27.5 trillion won on private education')} (<em>hagwon</em> cram schools), with a 75.7% participation rate and a record 604,000 won a month per enrolled student; in 2024 the total had been 29.2 trillion. A study presented in September 2026 at a Bank of Korea conference estimates that, without that competition, fertility would be 28% higher, according to {$ext('https://www.koreatimes.co.kr/southkorea/20260903/koreas-birthrate-could-have-been-28-higher-without-private-education-competition', 'The Korea Times')}, in a country that had 0.72 children per woman in 2023. And according to official statistics reported by the Korean press in May 2026, suicide was the leading cause of death among people aged 9 to 24 in 2024, for the fourteenth year in a row.</p>
<p>In Japan, spending on <em>juku</em> (cram schools) averages about 230,000 yen a year per public junior-high student, according to the {$ext('https://www.mext.go.jp/content/20260116-mxt_chousa01-000039333_3.pdf', 'Ministry of Education survey')}. Its teachers work 53 hours a week, one of the highest figures in TALIS 2024, and only 49.3% would choose the profession again. Part of that success is paid for outside school, with families’ money and with mental health.</p>

<h3>Estonia: equity as a strategy</h3>
<p>Estonia proves you don’t need to be Asian or very rich to be at the top. It has a common nine-year basic school, with no tracking before age 16; it has bet on digital since 1996 with {$ext('https://www.educationestonia.org/tiger-leap/', '“Tiger Leap”')}, and it gives schools a lot of autonomy. According to the {$ext('https://hm.ee/sites/default/files/documents/2026-09/PISA_2025_Estonia_results_summary_EN_0.pdf', 'Estonian Ministry of Education')}, 82.8% of its students reach at least Level 2 in mathematics, the highest share in Europe.</p>
<p>Its warning signs are also instructive: reading has fallen 24 points since 2018 and the teaching workforce is aging. {$ext('https://www.oecd.org/en/publications/education-at-a-glance-2026_c0e523a9-en/estonia_1c115451-en.html', 'Education at a Glance 2026')} reports that 40% of secondary teachers are 55 or older, and only 20.3% of Estonian teachers feel society values their work.</p>

<h3>Finland: trust, equity and a decline that forces a rethink of the myth</h3>
<p>Finland built its reputation on teachers with master’s degrees, broad autonomy, little standardized testing and strong equity. Selection is still demanding: in 2025 the University of Helsinki admitted only {$ext('https://www.helsinki.fi/assets/drupal/2025-09/Yhteishaussa%20kandiohjelmiin%20hakeneet%2C%20hyv%C3%A4ksytyt%20ja%20opiskelupaikan%20vastaanottaneet%20hakukohteittain%20ja%20tiedekunnittain%208.9.2025.pdf', '8.2% of applicants')} to its primary-teacher program. But its reading score went from 546 in 2000 to 474 in 2025, and only 41% of its students say they try harder when a task gets difficult. I look at it in depth in <a href="/finlandia-sistema-educativo-mito-o-realidad/">Finland’s education system: myth or reality?</a></p>

<h2>Is it about money? Spending per student and results</h2>
<p>Yes and no. In PISA 2022 the OECD found that, up to about USD 75,000 in cumulative spending per student between ages 6 and 15, more spending is linked to better results; above that threshold, much less so. Colombia spent USD 37,315, half the threshold and just over a third of the OECD average (102,612). Within the OECD, only Chile, Colombia, Greece, Latvia, Lithuania, Mexico and Türkiye were below it.</p>
{$img('mejores-sistemas-gasto', 667, 'Scatter chart of cumulative spending per student aged 6 to 15 versus PISA 2022 mathematics scores. High performers sit at the top right: Singapore with USD 166k and 575 points, Macao with 196k and 552, Japan with 101k and 536. Colombia is at the bottom left with 37k and 383 points; Peru spends 25k and scores 391, Panama spends 63k and scores 357. A line marks the USD 75k threshold', 'Below the threshold, money matters; but Peru achieves more than Colombia with less, and Panama less with more.')}
<p>But money doesn’t explain everything: above the threshold, Japan achieves far more than the OECD average with similar spending, and Finland spends more than Japan with weaker results.</p>
<p>Education at a Glance 2026 records spending of USD 3,405 per student from primary to tertiary in Colombia (a partial, public-only figure), versus 15,897 in the OECD. The official {$ext('https://portalsineb.mineducacion.gov.co/1782/articles-412165_Recursos_04_V2024.pdf', 'Ministry of Education series')} puts public spending on education at 4.1% of GDP in 2024. And {$ext('https://normograma.supersalud.gov.co/compilacion/docs/acto_legislativo_03_2024.htm', 'Legislative Act 03 of 2024')} raises the General Participation System (SGP), the transfers to regions, to 39.5% of the nation’s current revenues over twelve years, but that clock starts only when Congress passes the so-called competencies law, which as of October 2026 is still pending, according to {$ext('https://www.larepublica.co/economia/asi-cambiaria-el-reparto-de-los-recursos-para-las-regiones-con-la-ley-de-competencias-4446815', 'La República')}. More money without clear rules can end up in payroll and bureaucracy, not learning.</p>

<h2>Teachers: selection, pay and prestige</h2>
<p>Every high-performing system takes care of its teachers. But there is a myth to debunk: Andreas Schleicher, the OECD’s Director for Education, showed in 2025 that {$ext('https://oecdedutoday.com/do-top-performing-countries-recruit-their-teachers-from-among-top-graduates/', 'in no country are teachers in the top third')} of tertiary-educated adults on skills tests. What these systems do well is train, support and retain those who join.</p>
<p>Colombia’s data are surprising. In {$ext('https://www.icfes.gov.co/wp-content/uploads/2025/11/20251118_informe-Talis_19_11_25.pdf', 'TALIS 2024')}, 54% of our lower-secondary teachers felt society values their profession, versus 21.7% in the OECD; we rank 12th out of 56 systems. 97% are satisfied with their job and 91.2% would become teachers again. 18.2% have an assigned mentor, twice the OECD average. But 24% say cost keeps them from professional development, versus 11% in the OECD, according to {$ext('https://www.javeriana.edu.co/recursosdb/d/lee/inf-132-2025-informe-docentes-segun-talis-2024', 'report 132 by Javeriana University’s LEE')}.</p>
<table>
<thead><tr><th>Teacher indicator</th><th>Colombia</th><th>OECD</th><th>High benchmark</th></tr></thead>
<tbody>
<tr><td>Feel their profession is valued by society (TALIS 2024)</td><td>54%</td><td>21.7%</td><td>Singapore 71%</td></tr>
<tr><td>Starting salary, lower secondary (USD PPP, 2025)</td><td>36,196</td><td>49,514</td><td>Finland 50,227</td></tr>
<tr><td>Typical top salary (USD PPP, 2025)</td><td>66,011</td><td>77,862</td><td>Korea 116,446</td></tr>
<tr><td>Used artificial intelligence in the past year</td><td>52.8%</td><td>36.3%</td><td>Singapore 74.9%</td></tr>
<tr><td>Weekly working hours / teaching hours</td><td>38.7 / 26.0</td><td>38.5 / 21.2</td><td>Singapore 46.8 / 17.6</td></tr>
</tbody>
</table>
<p>That last row says a lot: Singapore’s teachers work more hours than Colombia’s but teach far fewer classes. The rest of the time they plan, mark, observe colleagues and learn. In Colombia we teach 26 hours a week and many of us plan at night. On selection, the 2022 teacher hiring competition had 378,212 candidates sitting the tests for 37,480 posts, about ten per post, according to the {$ext('https://www.mineducacion.gov.co/portal/salaprensa/Comunicados/412272:Mas-de-378-mil-aspirantes-al-proceso-de-seleccion-Docentes-y-Directivos-Docentes-asistieron-a-la-jornada-de-pruebas-escritas-en-todo-el-pais', 'Ministry of Education')}; the {$ext('https://www.mineducacion.gov.co/1780/w3-article-429273.html', 'next competition')} will offer more than 26,300 posts. Merit exists; what is missing is initial training and support that match the filter.</p>
<p>If you are preparing, the <a href="/herramientas/simulacro-concurso-docente/">free practice test for Colombia’s teacher competition</a> (in Spanish) lets you measure yourself with exam-style questions at your own pace, and here is the <a href="/concurso-docente-2026-nuevo-cronograma-inscripciones-2027/">updated schedule with registration in 2027</a> (in Spanish).</p>

<h2>Latin America: the problem starts long before age 15</h2>
<p>PISA measures at 15, but the gap forms earlier. In UNESCO’s ERCE 2019 assessment, 49.2% of sixth graders in the region were at the lowest level in mathematics, and the {$ext('https://documents1.worldbank.org/curated/en/099443504042242867/pdf/IDU0e7871c270811504df009e620db34dfd8158b.pdf', 'World Bank')} estimates that 83% did not reach minimum proficiency. Before the pandemic, according to the {$ext('https://data.worldbank.org/indicator/SE.LPV.PRIM?locations=CO', 'World Bank indicator')}, 51.4% of Colombian ten-year-olds could not read and understand a simple text (“learning poverty”); for the region, the {$ext('https://www.worldbank.org/en/programs/educacion-america-latina-caribe/literacy', 'World Bank estimates')} that figure may have reached 79% after school closures. The {$ext('https://www.iadb.org/es/noticias/bid-y-banco-mundial-no-hay-tiempo-que-perder-para-abordar-la-crisis-de-aprendizaje-en', 'IDB and the World Bank')} summed it up in 2024: three in four fifteen-year-olds in the region lack basic mathematics skills.</p>
<p>In Colombia, {$ext('https://lee.javeriana.edu.co/w/lee-informe-140', 'LEE report 140')} shows that the average Saber 11 score (the national exit exam) rose to 255.8 in 2025, the second highest since 2014, but the gap between urban and rural schools reached 26.7 points, the largest on record, and the gap between private and public schools was 27.5. According to {$ext('https://www.dane.gov.co/files/operaciones/EDUC/bol-EDUC-2024.pdf', 'DANE')}, 67.4% of school sites are rural, but only 57.2% of them have internet, versus 95% of urban sites. And of every 100 children who started first grade in 2013, only 44 reached grade 11 on time, according to LEE data reported by {$ext('https://www.eltiempo.com/vida/educacion/solo-44-de-cada-100-ninos-llegan-a-tiempo-a-grado-once-en-colombia-asi-queda-el-sistema-educativo-colombiano-de-cara-al-nuevo-gobierno-3576663', 'El Tiempo')}.</p>

<h2>What cannot (and should not) be copied</h2>
<ul>
<li><strong>PISA doesn’t measure everything:</strong> not art, citizenship, coexistence or happiness.</li>
<li><strong>Samples matter.</strong> Colombia’s covers 75% of fifteen-year-olds; the rest are out of school or held back, and would probably score lower. Expanding coverage may lower the average for a while without that being a failure.</li>
<li><strong>Culture can’t be imported by decree.</strong> Korean family pressure produces results, but also anxiety, private spending and inequality.</li>
<li><strong>Contexts differ.</strong> Singapore is a city-state of six million people with no scattered rural population or armed conflict; Colombia has more than nine million students, many in villages without internet.</li>
<li><strong>Autonomy works with capacity.</strong> Without well-trained teachers and social trust, autonomy turns into abandonment.</li>
</ul>
<p>What is transferable are the deep decisions: early childhood, time for teachers to prepare and learn, policies sustained for decades and assessment to correct, not to punish.</p>

<h2>Colombia’s gaps in a single image</h2>
<p>I compared Colombia with the average of high-performing systems across seven dimensions. Each bar is Colombia’s figure as a percentage of the benchmark: 100 means the same level.</p>
{$img('mejores-sistemas-brechas', 816, 'Bar chart with seven dimensions of Colombia as a percentage of the high-performing systems’ average. Below: cumulative spending per student 28, students at baseline in mathematics 36, 3-year-olds enrolled 61, socio-economic equity 64 and starting teacher salary 85. Above: teachers who feel valued 132 and official primary instruction hours 146', 'Colombia’s biggest gaps are in spending, basic learning, early childhood and equity, not in official hours or in how valued teachers feel.')}
<p>The image debunks two beliefs. Colombia does not have fewer official class hours than the best: it has many more, although in practice the full school day (<em>jornada única</em>) covered only 19.9% of public enrollment in 2023, according to {$ext('https://www.javeriana.edu.co/recursosdb/d/lee/inf120-informe-jornada-unica-2025-vf-lee', 'LEE report 120')}. And our teachers feel more valued than those in Japan or Estonia. The big gaps are in money per student, early childhood, equity and basic learning.</p>

<h2>Checklist: how Colombia could get closer to the best</h2>
<p>Key: ✅ progressing, ⚠️ partial, ❌ pending. Time frames: short (1 to 2 years), medium (3 to 6) and long (more than 6).</p>
<table>
<thead><tr><th>Dimension</th><th>Status</th><th>Main responsibility</th><th>Time frame</th></tr></thead>
<tbody>
<tr><td>1. Long-term state vision</td><td>❌ Pending</td><td>State, Congress, Ministry of Education</td><td>Short to agree on it, long to sustain it</td></tr>
<tr><td>2. Early childhood</td><td>❌ Pending</td><td>Ministry, ICBF (family welfare agency), local education offices</td><td>Medium</td></tr>
<tr><td>3. Teacher training and selection</td><td>⚠️ Partial</td><td>Ministry, universities, CNSC (civil service commission)</td><td>Medium</td></tr>
<tr><td>4. Teacher time to plan and learn</td><td>⚠️ Partial</td><td>Ministry, local education offices, principals</td><td>Medium</td></tr>
<tr><td>5. Teacher pay and career</td><td>⚠️ Partial</td><td>State, Ministry, Fecode (teachers’ union)</td><td>Long</td></tr>
<tr><td>6. Social prestige of teaching</td><td>✅ Progressing</td><td>Teachers, media, families</td><td>Ongoing</td></tr>
<tr><td>7. Rural equity and connectivity</td><td>❌ Pending</td><td>State, ICT Ministry, local education offices</td><td>Medium</td></tr>
<tr><td>8. A quality full school day</td><td>⚠️ Partial</td><td>Ministry, local education offices</td><td>Medium</td></tr>
<tr><td>9. Focused curriculum and formative assessment</td><td>⚠️ Partial</td><td>Ministry, ICFES, schools, teachers</td><td>Short</td></tr>
<tr><td>10. Inclusion with real adjustments</td><td>⚠️ Partial</td><td>Schools, teachers, families</td><td>Short</td></tr>
<tr><td>11. Data for early warnings</td><td>⚠️ Partial</td><td>Local education offices, schools</td><td>Short</td></tr>
<tr><td>12. Stable, well-used funding</td><td>⚠️ Partial</td><td>Congress, Finance Ministry, Ministry of Education</td><td>Long</td></tr>
<tr><td>13. A culture of effort and partnership with families</td><td>⚠️ Partial</td><td>Families, schools, teachers</td><td>Ongoing</td></tr>
</tbody>
</table>

<h3>1. Long-term state vision ❌</h3>
<ul>
<li><strong>Evidence:</strong> Singapore has kept the same direction since 1997; in Colombia, the 2016–2026 Ten-Year National Education Plan ends this year without ever having been at the center of the debate.</li>
<li><strong>What is missing and how:</strong> a new plan with a few measurable goals (reading in third grade, mathematics in ninth grade, enrollment at age 3), a budget tied to them and an annual public report, built to survive changes of minister.</li>
</ul>

<h3>2. Early childhood ❌</h3>
<ul>
<li><strong>Evidence:</strong> only 55% of 3-year-olds are enrolled (OECD: 75%; Korea: 96%). Net enrollment in transition (the year before first grade) was 61.2% in 2024 and, according to {$ext('https://www.javeriana.edu.co/recursosdb/d/lee/inf139-primera-infancia-cobertura-lee-2026', 'LEE report 139')}, fewer than four in ten children attend pre-kindergarten or kindergarten.</li>
<li><strong>What is missing and how:</strong> public pre-K and kindergarten in small towns and rural areas, with targets per municipality and specialized preschool teachers.</li>
</ul>

<h3>3. Teacher training and selection ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> the hiring competition is demanding (about ten candidates per post in 2022), but initial training is uneven and 24% of teachers skip professional development because of cost.</li>
<li><strong>What is missing and how:</strong> long, supervised practicums, as in Finland and Singapore; scholarships for strong graduates who choose teaching; induction with a mentor for every new teacher and free continuing education.</li>
</ul>

<h3>4. Teacher time to plan and learn ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> 26 weekly teaching hours in Colombia, 21.2 in the OECD and 17.6 in Singapore.</li>
<li><strong>What is missing and how:</strong> one protected hour a week to work with colleagues, in the style of Japanese lesson study. Meanwhile, tools that free up time: the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> includes subject-specific recipes aligned with Colombian standards to plan worksheets and activities in minutes.</li>
</ul>

<h3>5. Teacher pay and career ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> starting salary of USD 36,196 PPP (OECD: 49,514); the typical top of the scale is reached after ten years. Two teacher statutes coexist, Decree 2277 of 1979 and Decree-Law 1278 of 2002.</li>
<li><strong>What is missing and how:</strong> a career that rewards good teaching and instructional leadership, agreed on for the long term between the government and Fecode.</li>
</ul>

<h3>6. Social prestige of teaching ✅</h3>
<ul>
<li><strong>Evidence:</strong> 54% of teachers feel valued (OECD: 21.7%) and 91.2% would choose the profession again.</li>
<li><strong>What is missing and how:</strong> turning that prestige into attracting talented young people to teaching degrees, by showcasing teachers who achieve learning in tough contexts.</li>
</ul>

<h3>7. Rural equity and connectivity ❌</h3>
<ul>
<li><strong>Evidence:</strong> a record 26.7-point urban–rural gap in Saber 11; internet at 57.2% of rural school sites versus 95% of urban ones.</li>
<li><strong>What is missing and how:</strong> resources allocated by need, real incentives for teachers to stay in rural areas and connectivity as a basic school service.</li>
</ul>

<h3>8. A quality full school day ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> 19.9% of public enrollment in 2023, against a 30% target for 2026.</li>
<li><strong>What is missing and how:</strong> infrastructure, school meals and a pedagogical use of the extra hours, evaluating their effect on learning. More hours of the same won’t help.</li>
</ul>

<h3>9. Focused curriculum and formative assessment ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> Singapore cut content and removed mid-year exams to gain learning time.</li>
<li><strong>What is missing and how:</strong> prioritizing essential learning and assessing often to give feedback. The <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> creates different versions of the same exam with an answer key; try the <a href="/examenes/demo/">free demo</a>.</li>
</ul>

<h3>10. Inclusion with real adjustments ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> the legal framework is advanced (Decree 1421 of 2017 and individual reasonable-adjustment plans, known as PIAR), but teachers apply it with little time and little support.</li>
<li><strong>What is missing and how:</strong> enough support teachers and plans that are used in class. <a href="/herramientas/piar/">PIAR with AI</a> helps build them with reasonable adjustments, and the first one is free. I go deeper in <a href="/inclusion-en-el-aula-piar-colombia-latinoamerica-mundo/">inclusion in the classroom</a>.</li>
</ul>

<h3>11. Data for early warnings ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> only 44 of every 100 children reach grade 11 on time; dropout was 3.2% in 2023, and 12.3% in Vichada.</li>
<li><strong>What is missing and how:</strong> daily attendance records and a monthly review by class. A well-kept <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">attendance list in Excel</a> already works as an early-warning system.</li>
</ul>

<h3>12. Stable, well-used funding ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> cumulative spending per student at half the OECD threshold; the SGP reform is approved but conditional on the competencies law.</li>
<li><strong>What is missing and how:</strong> passing that law and tying the new resources to early childhood, rural areas and teacher training, with transparency by municipality.</li>
</ul>

<h3>13. A culture of effort and partnership with families ⚠️</h3>
<ul>
<li><strong>Evidence:</strong> in Asia, families support study every day; in Finland, the decline coincides with less reading and less perseverance.</li>
<li><strong>What is missing and how:</strong> reading at home, limits on recreational screen use and simple family–school agreements, like the ones I propose in <a href="/celulares-en-el-colegio-prohibir-o-ensenar/">phones at school</a>.</li>
</ul>

<h2>Three perspectives: teachers, school leaders and families</h2>
<p><strong>Teachers</strong> don’t need to be compared with Finland at every forum; we need time, useful training and manageable groups. “Fewer forms and more time to teach,” many colleagues tell me, and TALIS proves them right.</p>
<p><strong>School leaders</strong> live between pressure for results and scarcity. A principal who assigns mentors, protects an hour of collaborative work and uses attendance data to act in time does more for learning than ten memos.</p>
<p><strong>Families</strong> want children who learn and are safe. The Asian lesson is not to pay for cram schools, but to be there: read together, ask what they learned today, respect study time.</p>
<p>Compared with Latin America, Colombia is in the middle of the pack, behind Chile and Uruguay. Compared with the world, the distance is enormous. Both things are true, and the second should keep us up at night.</p>

<h2>Frequently asked questions</h2>
<h3>What are the best education systems in the world according to PISA 2025?</h3>
<p>In mathematics, the leaders are the Chinese sample of Beijing, Shanghai, Jiangsu and Zhejiang (612), Singapore (563), Macao (549), Chinese Taipei (546), Japan (525), and Hong Kong and South Korea (522). In Europe, the best is Estonia (508). In reading, Singapore comes first.</p>
<h3>How did Colombia do in PISA 2025?</h3>
<p>It scored 381 in mathematics, 399 in reading and 414 in science, below the OECD (463, 461 and 482). 71% did not reach the baseline in mathematics. The changes since 2022 are not statistically significant.</p>
<h3>Why is Singapore so good at education?</h3>
<p>Because of state planning sustained since the 1990s, a single teacher-education institution, demanding recruitment with paid training, a focused curriculum and family support. The cost: heavy pressure and a socio-economic gap larger than the OECD average.</p>
<h3>Is Finland still an education model?</h3>
<p>It remains above the OECD average and keeps good practices in teacher education and equity, but it lost 50 points in mathematics between 2012 and 2025. Today it teaches as much as a warning as a recipe.</p>
<h3>What does Colombia need to improve in PISA?</h3>
<p>Expand early education, close the rural gap, give teachers time to plan and learn, sustain education policy beyond a single government, fund schools better with clear rules, and strengthen formative assessment and partnership with families.</p>

<p class="notice"><strong>Tools to make a difference from your classroom.</strong> The world’s best education systems protect teachers’ time to plan, assess well and include everyone. The <strong>AI Kit for Teachers</strong> includes subject-specific recipes aligned with the Colombian curriculum, at 60,000 pesos per subject. The <strong>AI Exam Generator</strong> creates different versions of the same exam, with plans from 29,900 pesos. <strong>PIAR with AI</strong> lets you build one PIAR for free and then choose packages of 5, 10 or 20 plans. And if you are taking the teacher competition, the <a href="/herramientas/simulacro-concurso-docente/">free practice test</a> helps you see where you stand.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">See the AI Kit for Teachers</a></p>

<h2>Food for thought</h2>
<p>South Korea is among the world’s best in PISA and, at the same time, has one of the lowest fertility rates on the planet, record spending on cram schools and suicide as the leading cause of death among its young people. Finland bet on wellbeing and trust, and now watches its results fall cycle after cycle. Colombia has teachers who feel valued and students who, for the most part, do not reach the minimum. <strong>If we could choose, which system would we want for our children: one that takes them to the top of PISA at the cost of their childhood, or a kinder one that leaves them without the tools to compete in the world? And why do we keep believing we have to choose between the two?</strong></p>
HTML,
    ],
];
