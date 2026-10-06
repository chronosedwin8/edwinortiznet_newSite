<?php

declare(strict_types=1);

// English version of the PISA analysis article (Platzi video fNLBeGyTNf8). Key is the Spanish slug.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/pruebas-pisa/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

return [
    'pruebas-pisa-america-latina-colombia-docentes-familias' => [
        'slug' => 'pisa-results-latin-america-colombia-teachers-families',
        'title' => 'PISA Results: Why Latin America Struggles in Math and What Teachers, Families and Colombia’s Education System Can Do',
        'excerpt' => 'I analyze Platzi’s video on the PISA results: the decline in math and reading, the excuses that fall short, the role of screens and the idea of school as a “gym for the mind,” from Colombia’s perspective compared with Latin America and the world.',
        'seo_title' => 'PISA Results in Latin America: What They Mean for Colombia',
        'seo_description' => 'An analysis of Platzi’s video on PISA results: math, reading, screens and perseverance. What it means for teachers, families and students in Colombia.',
        'focus_keyword' => 'PISA results',
        'cover' => '/assets/img/articulos/pruebas-pisa/pruebas-pisa-portada-en',
        'cover_alt' => 'Bar chart showing declines in math, reading and science next to the headline Latin America failed PISA',
        'content_html' => <<<HTML
<p>Every time the PISA results are published, Colombia has the same conversation for a week: alarmed headlines, the usual culprits and, soon after, silence. This time, Freddy Vega, cofounder of the online learning platform Platzi, published an analysis more than twenty minutes long (video in Spanish) with an uncomfortable thesis: the region’s educational lag cannot be explained only by poverty, corruption or artificial intelligence.</p>
<p>I watched all of it through the eyes of a math teacher. Here I summarize what it argues, contrast it with what we experience in Colombian classrooms and compare it with what other countries are doing. At the end I leave a question that I believe all of us who work in education should be asking ourselves.</p>

<h2>What the video argues</h2>
<figure class="lite-yt" data-yt="fNLBeGyTNf8"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=fNLBeGyTNf8" data-yt="fNLBeGyTNf8"><img src="https://i.ytimg.com/vi/fNLBeGyTNf8/hqdefault.jpg" alt="Video (in Spanish): The failure of education and the PISA tests" width="480" height="360"><span class="lite-yt__play"></span></a></figure>
<p>According to the analysis presented in the video, the latest PISA results show a global decline in science, reading and math, and Latin America is among the hardest-hit regions. These are the facts it highlights most:</p>
<ul>
<li><strong>No Latin American country</strong> is above the OECD average; all of them are below or far below it.</li>
<li>In Mexico, the percentage of students below level 2 in math, that is, students who cannot solve a basic math problem, went from <strong>56% to 70%</strong> in ten years.</li>
<li>Across the OECD, about <strong>12%</strong> of students reach the highest levels (5 and 6); in Uruguay, the region’s best performer, the figure is <strong>2.8%</strong>, and in Peru, <strong>0.5%</strong>.</li>
<li>The poorest students in Singapore and Japan score better than the richest students in the region’s best-performing countries.</li>
<li>There is progress: Costa Rica and Uruguay improved in science, and the region has managed to get more young people into school. Argentina, on the other hand, fell in all three areas.</li>
</ul>
{$img('pruebas-pisa-datos', 640, 'Six PISA facts cited in the video: no Latin American country exceeds the OECD average, Mexico went from 56% to 70% below level 2, 12% top-performing students in the OECD versus 2.8% in Uruguay and 0.5% in Peru', 'The data presented in the video. The full official figures are in the OECD reports.')}
<p>The video also includes an offer from Platzi: free access to its math fundamentals course for schools that have computers, internet access and the commitment of their administrators. It is worth knowing about, although the analysis does not depend on that offer.</p>

<h2>What PISA measures and what it doesn’t</h2>
<p>Before drawing conclusions, it helps to understand the test. PISA assesses 15-year-old students in three areas: <strong>reading</strong>, which in the video’s words measures the patience to understand a complex text; <strong>math</strong>, which measures the ability to solve a problem step by step; and <strong>science</strong>, which combines memory with the speed to judge whether something fits with reality.</p>
<p>There is a detail the video itself stresses and that almost never makes the headlines: <strong>PISA only assesses those who are in school</strong>. According to the data it shows, in Chile the test represents about 95% of 15-year-olds, while in Guatemala it represents barely half. That is why comparing countries without looking at coverage can lead to the wrong conclusions, and why having more young Latin Americans in school is good news even though, in the short term, it pulls the averages down.</p>

<h2>The core thesis: it’s not (only) what we usually blame</h2>
<p>The most provocative part of the video is its critique of the usual explanations:</p>
<ul>
<li><strong>Poverty doesn’t explain everything.</strong> According to the analysis, beyond a certain level of spending per student, results stop improving at the same pace. The example it uses is Turkey, which spends about as much per student as Peru and the Latin American average and, even so, managed to improve in science to the point of surpassing the OECD average.</li>
<li><strong>Nor does inequality, on its own.</strong> The video points out that the region’s most advantaged quartile, students from the families with the most resources, got worse, while the most disadvantaged quartile improved slightly. In other words, the problem lies with the system, not just with one group.</li>
<li><strong>Artificial intelligence plays a role, but it isn’t enough of an explanation.</strong> The countries that use it least tend to have better scores, but there are clear exceptions: Singapore uses it a lot and does very well; Vietnam uses it a lot and does not.</li>
</ul>
{$img('pruebas-pisa-causas', 600, 'Comparison between what we usually blame (poverty, corruption, artificial intelligence, social media) and what the analysis points to (lack of perseverance, screens for leisure, little real computing and motivation to think)', 'The video’s argument: trading excuses for causes we can actually act on.')}
<p>So what does explain the decline? The video points to four factors: a <strong>lack of perseverance</strong> (students started answering at random in reading and math, the two tests that require you to stay with a problem and think), the <strong>use of screens for leisure</strong>, the <strong>lack of real digital literacy</strong> with computers and, above all, a <strong>lack of motivation to make the effort to think</strong>.</p>

<h2>Students: curious, but quick to give up</h2>
<p>There is a hopeful finding amid so many poor results: according to the video, Latin American students report <strong>more intellectual curiosity</strong> than the OECD average. It is not a lack of interest in learning. The problem shows up when learning requires sustained effort: at the first obstacle, more and more young people give up.</p>
<p>That matches what we see in the classroom. A student who has spent years with instant answers one click away, in the search engine, in short videos or in the AI assistant, has a hard time tolerating the discomfort of not knowing. And math is precisely the art of enduring that discomfort long enough to break a problem down into steps.</p>
<p>The video also mentions a global gender gap: more boys among the top math scorers and more girls among the top reading scorers. It is not a question of ability, but of expectations, stereotypes and opportunities that build up from primary school onward, and Colombia is no exception.</p>

<h2>Teachers: teaching to think when the answer is a click away</h2>
<p>For those of us who teach, the video’s message is demanding but useful. If the central problem is perseverance, a class cannot be limited to explaining and assigning mechanical exercises. Some practices that, in my experience, change the dynamic:</p>
<ul>
<li><strong>Multi-step problems</strong> with real context, instead of lists of repetitive exercises.</li>
<li><strong>Explicit time for mistakes</strong>: valuing the process and the correction, not just the final answer.</li>
<li><strong>Think before looking it up</strong>: ten minutes of independent work before using the calculator, the search engine or AI.</li>
<li><strong>Real computing</strong>: spreadsheets, folders, files and basic programming on computers with keyboards, not just apps on a tablet.</li>
</ul>
<p>None of this works if teachers are on their own. Colombia has experience with teacher coaching through programs such as Todos a Aprender (“Everyone Learns”), which focuses on language and math in the early grades; the question is how to bring that kind of support to secondary school, which is where PISA measures results.</p>

<h2>Parents: self-control is also learned at home</h2>
<p>One of the clearest findings the video cites has to do with screens. When they are used for leisure (social media, short videos, chat), <strong>more than one hour a day is associated with lower scores</strong>, and each additional hour takes more away. Interestingly, using them for leisure less than one hour a day is associated with better results, which the video interprets as a sign of self-control. Even using devices for learning stops helping once it goes beyond five hours.</p>
{$img('pruebas-pisa-pantallas', 573, 'Illustration of the relationship between screen hours and scores: leisure use helps below one hour and then hurts; use for learning is neutral up to five hours and then takes away', 'Illustration of the finding described in the video. Not to scale: it shows the trend, not the values.')}
<p>For families, the takeaway is not to ban technology, but to set clear limits and teach how to use it:</p>
<ul>
<li><strong>Less than one hour a day of screens for leisure</strong> on school days, agreed on with your children rather than imposed by shouting.</li>
<li><strong>Keep the phone off the study table</strong> while homework is being done.</li>
<li><strong>Ask “How did you solve it?”</strong> instead of “Are you done yet?”</li>
<li><strong>Don’t do their homework for them</strong>, and don’t let AI do it either: supporting the effort is more valuable than solving the problem.</li>
<li><strong>Lead by example</strong>: children learn more from how we use our phones than from what we tell them about phones.</li>
</ul>

<h2>Colombia’s education system: extreme results</h2>
<p>Colombia has taken part in PISA since 2006 and also has its own assessment system, the Saber tests, national standardized exams administered by ICFES (the Colombian Institute for Educational Evaluation). There is no shortage of data. What the video adds is a troubling observation: Colombia has an average similar to that of several of its neighbors, but a much more extreme distribution. According to the analysis, its best students are better than Mexico’s best, but its worst students are much worse than Mexico’s worst.</p>
<p>That means the same country is home to schools that compete at international standards and schools where most students do not reach the basics. The gaps between urban and rural areas, between public and private schools, and between regions explain much of that chasm.</p>
<p>The point about computing also hits close to home. Programs such as Computadores para Educar (“Computers to Educate”) have brought equipment to thousands of public school campuses, and the video raises a necessary debate: to learn to solve problems, a computer with a keyboard and an internet connection is worth more than a tablet. The question is not just how many devices arrive, but which ones, and how they are used in class.</p>

<h2>Colombia compared with Latin America</h2>
<p>The video groups the region’s countries into three tiers according to their math results. Uruguay and Chile lead the region, although far below the OECD. Colombia is in the largest group, along with Costa Rica, Peru, Brazil, Argentina, Ecuador and Mexico. And El Salvador, the Dominican Republic, Guatemala and Paraguay lag furthest behind.</p>
{$img('pruebas-pisa-paises', 600, 'Grouping of countries according to the video: the world’s best, the OECD average, the region’s best, the large group that includes Colombia and the group furthest behind', 'How the video groups countries in math. It is an approximate grouping, not an official ranking.')}
<p>Within that picture there are different stories: <strong>Costa Rica</strong> is, according to the video, the only country in the region that improved in math and somewhat in reading; <strong>Peru</strong>, which had been growing remarkably, stalled; <strong>Argentina</strong>, once a regional benchmark, fell back in all three areas; and <strong>Mexico</strong> got markedly worse in math. Colombia is not among the cases of collapse, but it is not among the improvers either: it is stuck in the middle.</p>

<h2>Colombia compared with the rest of the world</h2>
<p>The countries that lead PISA, such as Singapore and Japan, have something in common that the video highlights: very demanding systems, with highly persevering students. According to the analysis, only a few countries, almost all of them Asian, increased their students’ willingness to make an effort when facing a challenge; most declined, and Latin America declined sharply. Japan is also a striking case: it barely uses artificial intelligence in schools and achieves the top scores.</p>
<p>Beyond the video, the international trend points in the same direction. Several European countries have restricted phone use in classrooms, and UNESCO, in its 2023 report on technology in education, recommended using technology in class only when it improves learning. The example of Turkey, which the video mentions, also shows that a country with resources similar to ours can improve in just a few years.</p>

<h2>A critical reading of the video</h2>
<p>The analysis is valuable, but it is not without nuance:</p>
<ul>
<li><strong>Correlation is not causation.</strong> The fact that the countries using AI the least have better scores does not prove that AI is the cause; there may be cultural and education-policy factors behind both.</li>
<li><strong>Some conclusions are very sweeping.</strong> Claiming that the region will “never” be able to develop complex industries because of its level in math works as a wake-up call, but the future depends on what is done from now on.</li>
<li><strong>The figures deserve a trip to the source.</strong> The video summarizes many charts; anyone who wants to make decisions should review the official OECD reports and their own country’s data.</li>
<li><strong>There is a commercial context.</strong> The video recommends Platzi courses. That does not invalidate the analysis, but it is worth keeping in mind.</li>
</ul>
<p>Even with those caveats, I think its core contribution is right: stop looking for excuses and focus on what we can actually change in the classroom and at home.</p>

<h2>School as a “gym for the mind”</h2>
<p>The idea the video closes with is powerful. In the past, going to school (<em>colegio</em>, as primary and secondary school is called in Colombia) meant gaining access to scarce knowledge; today knowledge is everywhere. Since the Industrial Revolution, machines have freed us from physical effort, and that is why gyms exist: we need to exercise to stay well. The same will happen with the machines that think for us, and <strong>schools will have to become gyms for the mind</strong>, places where we force ourselves to think and to feel uncomfortable. Its conclusion: <em>to educate now is to motivate people to think</em>.</p>
{$img('pruebas-pisa-gimnasio', 573, 'What each player can train in school as a gym for the mind: teachers, students, families and the education system', 'If school is a gym for the mind, each player has their own routine.')}

<h2>Frequently asked questions</h2>
<h3>What are the PISA tests?</h3>
<p>They are the OECD’s international assessments (the Programme for International Student Assessment) that measure the reading, math and science skills of 15-year-old students. They are given every few years in dozens of countries and make it possible to compare education systems.</p>
<h3>How did Colombia do in the latest PISA tests?</h3>
<p>According to the video’s analysis, Colombia is in Latin America’s middle group, below the OECD average, with a very unequal distribution: its best students outperform Mexico’s best, but its worst are far below.</p>
<h3>Why does Latin America do poorly in math?</h3>
<p>The video argues that it is not explained only by poverty or corruption, but by a lack of perseverance when facing difficult problems, excessive use of screens for leisure, little training in real computing and a lack of motivation to make the effort to think.</p>
<h3>How much screen time is advisable for a student?</h3>
<p>According to the findings the video cites, less than one hour a day of screens for leisure is associated with better scores, and each additional hour lowers them. For learning, use stops helping once it exceeds five hours.</p>
<h3>Does artificial intelligence make school results worse?</h3>
<p>There is no simple relationship. The countries that use it least tend to have better results, but there are exceptions. What matters is using it to learn to think, not to avoid thinking.</p>

<h2>Conclusion</h2>
<p>PISA results are not a sentence; they are a diagnosis. And the diagnosis the video puts forward is, at heart, hopeful: if the problem is not only poverty or corruption, but perseverance, the use of technology and the motivation to think, then there is a lot that teachers, families, students and Colombia’s education system can do starting tomorrow. Making thinking a daily habit again is everyone’s job.</p>

<h2>One last question</h2>
{$img('pruebas-pisa-pregunta', 480, 'Final question: if a machine already answers in seconds, why do we still grade students on their answers and not on how long they can keep thinking', 'The question that remains open.')}
<p><strong>If a machine can already answer in seconds, why do we still grade students on their answers and not on how long they can keep thinking before giving up?</strong> Perhaps the next great education reform won’t be about teaching more content, but about assessing the effort of thinking that no machine can do for us.</p>
HTML,
    ],
];
