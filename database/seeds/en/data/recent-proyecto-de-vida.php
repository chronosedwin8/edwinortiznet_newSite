<?php

declare(strict_types=1);

// English version of the life-project analysis article (Platzi video FP6OR13xhfQ). Key is the Spanish slug.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/proyecto-de-vida/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

return [
    'proyecto-de-vida-colegio-docentes-caso-platzi' => [
        'slug' => 'life-project-school-teachers-platzi-case',
        'title' => 'Life projects at school: why 4 in 10 teachers canceled that class and what the Platzi case teaches us',
        'excerpt' => 'A Platzi video reveals that one in three teachers did not feel prepared to guide their students’ life projects. I analyze it from the classroom, the family, the students and the Colombian education system, and compare it with Latin America and the rest of the world.',
        'seo_title' => 'Life Projects at School: The Platzi Case and Colombia',
        'seo_description' => 'One in three teachers doesn’t feel prepared to guide students’ life projects. An analysis of the Platzi case for teachers, families and the school system.',
        'focus_keyword' => 'life project',
        'cover' => '/assets/img/articulos/proyecto-de-vida/proyecto-de-vida-portada-en',
        'cover_alt' => 'Path with five life-project stages: who I am, what drives me, what my options are, my plan and where I am headed',
        'content_html' => <<<HTML
<p>There is a question every teacher has heard at some point in a school hallway: “Teacher, so what should I study?” Behind that question there is no homework and no test: there is a teenager trying to picture themselves five or ten years from now. Schools in Colombia have a name for that work, the <strong>life project</strong> (<em>proyecto de vida</em>, a mix of personal life planning and career guidance), and in many schools it is precisely the class that gets postponed when time runs short.</p>
<p>A recent Platzi video put numbers to that reality in public schools in Cundinamarca, the department that surrounds Bogotá. I analyzed it carefully because, as a teacher, I care less about the news itself than about what it reveals: what is happening to teachers, what students need, what families can do and how prepared the Colombian education system is compared with what is being done in Latin America and the rest of the world.</p>

<h2>What the video says</h2>
<figure class="lite-yt" data-yt="FP6OR13xhfQ"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=FP6OR13xhfQ" data-yt="FP6OR13xhfQ"><img src="https://i.ytimg.com/vi/FP6OR13xhfQ/hqdefault.jpg" alt="Video: Platzi wants to reach 1,600 public school teachers" width="480" height="360"><span class="lite-yt__play"></span></a></figure>
<p>In just over two minutes (video in Spanish), Platzi, the Latin American online learning platform, presents a project it carried out with the <strong>Fundación Santa Isabel</strong> (Santa Isabel Foundation). Before starting, the foundation found two uncomfortable facts in the schools it worked with:</p>
<ul>
<li><strong>One in three teachers</strong> did not feel prepared to guide their students’ life plans.</li>
<li><strong>More than four in ten</strong> had canceled or postponed that class because they did not have the tools they needed.</li>
</ul>
<p>Platzi took the foundation’s methodology and guides and turned them into an online course, “Aventura al éxito” (Adventure to Success), aimed at principals, teachers and school leaders. It launched in September 2025 and, according to the video, <strong>729 teachers from 18 public schools</strong> in Cundinamarca earned the certificate, rating it 4.8 out of 5. An external evaluation found that <strong>96%</strong> consider what they learned useful or very useful and that <strong>86%</strong> are already applying it in class. The goal is to reach <strong>1,600 teachers by 2028</strong>.</p>
{$img('proyecto-de-vida-datos', 613, 'Infographic with the case data: 1 in 3 teachers did not feel prepared, 4 in 10 canceled the class, 729 teachers certified across 18 schools, 96% find it useful and 86% apply it', 'The case data according to the Platzi video. The goal is to train 1,600 teachers by 2028.')}
<p>The second half of the video is less about education and more about communication: Platzi admits that projects like this one “didn’t reach social media, didn’t reach the community and often didn’t even reach us,” and it closes with an idea that applies to any school: <em>you don’t have to create everything from scratch; you just have to tell people about it</em>.</p>

<h2>Why the life project is not a filler class</h2>
<p>When a school cancels the life project class, it is almost never out of lack of interest. It does so because it is the subject with no external exam, no clear textbook and, as the video shows, often no teacher who feels confident about how to teach it. The problem is that what isn’t worked on at school doesn’t disappear: the decisions still get made, only blindly.</p>
<p>A student who finishes eleventh grade (the last year of high school in Colombia) without having explored their interests or the options available to them tends to choose by elimination, by following what a friend chose or by what someone said at home. And when the choice has no roots, dropping out in the first semesters or abandoning their training shows up as a logical consequence, not as a surprise.</p>
<p>International research points in the same direction. The OECD report <em>Dream Jobs?</em>, based on the answers of PISA students, showed that teenagers’ career aspirations are concentrated in a handful of familiar occupations and that many young people, especially those from lower-income households, are unclear about what education they need for the career they say they want. It is not a lack of dreams: it is a lack of information and of experiences to build them.</p>

<h2>Teachers: from goodwill to method</h2>
<p>The most revealing fact in the video is not that teachers cancel the class; it is why they do it. Most of us who teach in Colombia were trained in a discipline: mathematics, language, science. Very few teacher-education degree programs prepare you to guide life decisions, and yet that task ends up assigned to the homeroom teacher (<em>director de grupo</em>) or to whichever teacher has free periods.</p>
<p>That is why the approach in this case makes sense: not replacing the teacher with a platform, but giving them a methodology, concrete guides and an order of work. The 86% who report applying what they learned suggests that the obstacle was not a lack of commitment, but a lack of tools. When a teacher knows what to do in each session, they stop improvising and stop canceling.</p>
<p>That said, training alone does not solve everything. For the life project to work in the classroom, teachers also need:</p>
<ul>
<li><strong>Protected time in the timetable</strong>, not whatever hours are left over.</li>
<li><strong>Up-to-date material</strong> on university degrees, technical programs, scholarships and the job market in their region.</li>
<li><strong>Support from the school counselor</strong> for cases that require individual attention.</li>
<li><strong>Follow-up</strong>: knowing what happened to their students after graduation.</li>
</ul>

<h2>Students: what they need to decide</h2>
<p>A life project is not a form you fill out once in tenth grade. It is a process that should be repeated and adjusted, because interests change. What helps a student most to build it, according to classroom experience and international recommendations, can be summed up in three verbs:</p>
<ol>
<li><strong>Get to know yourself</strong>: identify interests, skills and values, and recognize what you are passionate about and what you are not.</li>
<li><strong>Explore</strong>: learn about real options (university, technical, technological, entrepreneurship), talk to people who work in them and, whenever possible, have experiences in actual workplaces.</li>
<li><strong>Plan and review</strong>: turn all of the above into concrete goals, with steps, deadlines and backup plans, and review it again every year.</li>
</ol>
<p>There is also a gap the system cannot ignore. In rural schools or those in small towns, the range of options a student knows about tends to be narrower, and gender stereotypes still weigh heavily when it comes to imagining certain professions. Good life-project work widens that range; the absence of it leaves it as it is.</p>

<h2>Parents: support without imposing</h2>
<p>The family is the first place where a teenager talks about their future, and also where they get the most pressure. Many parents want their children to pursue the degree they themselves could not study, or the one they believe pays the most, and that, although it comes from love, can turn the life project into someone else’s project.</p>
<p>Some practical ideas I share with families at parent meetings:</p>
<ul>
<li><strong>Ask before giving your opinion</strong>: “What do you like to do when nobody makes you?” opens up more conversation than “What are you going to study?”</li>
<li><strong>Learn about the options</strong>: technical and technological training is also a worthy path with good job prospects.</li>
<li><strong>Talk about money without fear</strong>: costs, scholarships, student loans and the possibility of studying and working at the same time.</li>
<li><strong>Get involved with the school</strong>: ask how the life project is handled and request that the class not be canceled.</li>
<li><strong>Accept change</strong>: changing your mind at sixteen is not a failure; it is part of the process.</li>
</ul>
{$img('proyecto-de-vida-actores', 667, 'Map of the actors around the student and their life project: teachers, family, school and counseling, and the education system, with outside allies', 'The life project rests on four actors. When one fails, the others carry the whole load.')}

<h2>The Colombian education system: the rules exist, practice is uneven</h2>
<p>On paper, Colombia is not doing badly. The General Education Law (Law 115 of 1994) sets the full development of the personality as an aim of education, and Decree 1860 of 1994 requires every educational institution to have a <strong>student guidance service</strong> that contributes, among other things, to personal decision-making and to identifying aptitudes and interests. The Ministry of Education has also published <strong>socio-occupational guidance</strong> guidelines so that schools can support the transition to higher education and work.</p>
<p>The problem is in the execution. How the life project is handled depends on each school’s PEI (<em>Proyecto Educativo Institucional</em>, its institutional education plan), on the time it assigns to it and on whether or not it has <strong>guidance teachers</strong> (<em>docentes orientadores</em>). That position exists in Colombia’s public-school teaching career, and anyone preparing for the <a href="/concurso-docente/">Concurso Docente</a> (in Spanish), the national public teacher selection exam, for that role knows how demanding it is; but many schools have a single counselor for hundreds of students, or simply have none.</p>
<p>In that gap, partnerships like the one in the video step in: a foundation that designs the methodology and a platform that takes it to scale. It is a strength of the Colombian ecosystem, but also a warning sign. If teacher training in something this essential depends on private initiative, its continuity depends on budgets, priorities and calls for proposals that the school does not control.</p>

<h2>Colombia compared with Latin America</h2>
<p>The region shares very similar challenges: high dropout rates in higher education, widespread informal employment and large differences between urban and rural education. The responses, however, vary:</p>
<ul>
<li><strong>Chile</strong> made <em>Orientación</em> (Guidance) a subject in the national curriculum for primary school and the first years of secondary school, with its own objectives and class time. That gives it a fixed place that does not depend on the goodwill of each school.</li>
<li><strong>Mexico</strong> has promoted social-emotional skills programs in upper secondary education that work on decision-making and the life project as part of students’ holistic education.</li>
<li><strong>Colombia</strong> has the legal framework for the guidance service and the guidance teacher, but no mandatory subject and no common standard for what every student should experience before graduating.</li>
</ul>
<p>In short: Colombia has the rules but lacks the standard; some of its neighbors have the slot in the timetable, but share the same shortage of trained counselors.</p>

<h2>Colombia compared with the rest of the world</h2>
<p>The systems that best support this stage have something in common: they treat guidance as a professional service with standards, not as an optional class.</p>
<ul>
<li><strong>Finland</strong> includes educational and career guidance in its national curriculum and has specialized counselors who support students at moments of transition.</li>
<li><strong>England</strong> adopted the eight <em>Gatsby Benchmarks</em> as its reference for good guidance: a stable program in every school, labor market information, attention to each student’s needs, linking curriculum subjects to careers, encounters with employers, experiences of workplaces, encounters with higher education and personal guidance.</li>
<li><strong>The OECD</strong>, in its reports on preparing young people for the world of work, recommends that students explore, experience and reflect on work from an early age, and that systems measure their aspirations to spot in time those who are left without a horizon.</li>
</ul>
{$img('proyecto-de-vida-modelos', 653, 'Comparison of five guidance models: Colombia, Chile, Finland, England and the OECD recommendations', 'Five ways to support students’ futures, from Colombia’s legal framework to England’s standards.')}
<p>Against those benchmarks, the case in the video is valuable precisely because it tackles the weakest link in the Colombian model: the teacher who has the responsibility but not the preparation.</p>

<h2>A critical reading of the case</h2>
<p>Celebrating the result does not stop us from asking questions about it. A few that seem fair to me:</p>
<ul>
<li><strong>Applying is not the same as having an impact.</strong> That 86% of teachers apply what they learned is a great indicator of adoption, but the real result lies with the students: do they make better-informed decisions? Do they stay in school longer?</li>
<li><strong>Scale matters.</strong> Reaching 1,600 teachers by 2028 is valuable, but Colombia has hundreds of thousands of teachers in the public sector. What works in Cundinamarca needs a path to reach the whole country.</li>
<li><strong>So does sustainability.</strong> If the project depends on a one-off partnership, what happens to the schools when the partnership ends?</li>
</ul>
<p>And there is a lesson the video itself leaves without meaning to: many good educational practices exist, but nobody tells their story. Every school that manages to do life-project work well should document it and share it, because, as Platzi says, you don’t have to create everything from scratch.</p>

<h2>What each of us can do starting tomorrow</h2>
<ul>
<li><strong>Teachers</strong>: plan the life project like any other subject, with a sequence, materials and evidence, and ask for training when they don’t feel prepared.</li>
<li><strong>Principals and coordinators</strong>: protect that hour in the timetable, include it in the PEI with measurable goals and coordinate it with the counselor.</li>
<li><strong>Families</strong>: talk at home without imposing, and insist that the school not cancel that class.</li>
<li><strong>Students</strong>: take the exploration activities seriously, ask questions and understand that a plan can be adjusted.</li>
<li><strong>Local education departments (<em>secretarías de educación</em>) and the Ministry</strong>: train counselors and teachers in this area, define a minimum standard of experiences for every student and measure results.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What is the life project at school?</h3>
<p>It is the process through which the school helps each student get to know themselves, explore their study and work options and build a plan for their future. In Colombia it falls under the student guidance service and each school’s institutional education plan (PEI).</p>
<h3>Is working on the life project mandatory in Colombia?</h3>
<p>The rules require every institution to provide a student guidance service that supports decision-making and the identification of aptitudes and interests. The specific way of doing it, the time devoted to it and who is in charge depend on each school’s PEI.</p>
<h3>What is Platzi’s “Aventura al éxito” course?</h3>
<p>It is an online course created by Platzi based on the Fundación Santa Isabel methodology so that principals, teachers and school leaders can guide their students’ life projects. According to the video, it certified 729 teachers from 18 public schools in Cundinamarca.</p>
<h3>How can parents help build the life project?</h3>
<p>By listening before giving their opinion, learning about technical, technological and university options, talking frankly about costs and scholarships, and accepting that a teenager’s interests can change.</p>
<h3>What do other countries do to guide their students?</h3>
<p>Chile has Guidance as a school subject; Finland has specialized counselors within its curriculum; England uses the eight Gatsby Benchmarks as its standard, and the OECD recommends that students explore the world of work from an early age.</p>

<h2>Conclusion</h2>
<p>The case of Platzi and the Fundación Santa Isabel shows something simple and powerful: when teachers are given tools, they stop canceling the life project class and start teaching it well. Colombia already has the rules requiring schools to guide their students; what it lacks is turning them into a stable practice, with trained teachers and counselors, protected time and goals that get measured. Until that happens, every teacher, every family and every school can start by not letting that hour go to waste.</p>

<h2>One last question</h2>
{$img('proyecto-de-vida-pregunta', 480, 'Final question: why does the education system measure how much math a student knows but not whether they know who they want to be', 'The question that remains open.')}
<p><strong>Why does the education system measure so precisely how much math a student knows, yet lack a single indicator of whether they know who they want to be?</strong> If the national standardized exams (Colombia’s Saber tests, run by ICFES) define what schools prioritize, perhaps the life project will remain the class that gets canceled until the day someone decides to measure it.</p>
HTML,
    ],
];
