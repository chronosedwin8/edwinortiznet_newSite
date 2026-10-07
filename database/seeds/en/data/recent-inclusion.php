<?php

declare(strict_types=1);

// English version of the classroom inclusion and PIAR article. Key is the Spanish slug.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/inclusion/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

return [
    'inclusion-en-el-aula-piar-colombia-latinoamerica-mundo' => [
        'slug' => 'classroom-inclusion-piar-colombia-latin-america-world',
        'title' => 'Classroom Inclusion: What an Effective PIAR Needs and How to Make the Whole Class Win',
        'excerpt' => 'Inclusion is neither a favor nor a form: it is a right that has to be planned. I explain what an effective PIAR must contain, how to work with families, what Latin America, the United States and the rest of the world do, and how to manage inclusion with the whole class.',
        'seo_title' => 'Classroom Inclusion and the PIAR: A Guide for Teachers',
        'seo_description' => 'What an effective PIAR must contain, inclusive classroom practices and working with families and the whole class, with examples from Colombia and beyond.',
        'focus_keyword' => 'classroom inclusion',
        'cover' => '/assets/img/articulos/inclusion/inclusion-portada-en',
        'cover_alt' => 'Illustrated classroom with a diverse group of students, one of them in a wheelchair, facing the same board, next to the title Classroom inclusion',
        'content_html' => <<<HTML
<p>In more than twenty years of teaching, my math and technology classes have included students with autism, low vision, dyslexia, ADHD, intellectual disabilities and talents the curriculum could not challenge. I have also seen what happens when a school takes them in unprepared: an anxious teacher, a family that feels it is begging for what is already a right, and a student who learns, before anything else, that he doesn’t belong in that room.</p>
<p>This article makes the case for <strong>classroom inclusion</strong> as the best way to teach everyone: what a PIAR needs so it isn’t just another piece of paper, how responsibilities are shared among school, teacher and family, what other countries do, and how to manage inclusion with the rest of the class.</p>

<h2>Why inclusion is not optional (or charity)</h2>
<p>I start with the law because it settles many staff-room arguments. Colombia approved the UN Convention on the Rights of Persons with Disabilities through <strong>Law 1346 of 2009</strong>, and its Article 24 requires an inclusive education system at every level. <strong>Statutory Law 1618 of 2013</strong> developed those rights, <strong>Law 115 of 1994</strong> already required schools to serve people with disabilities or exceptional abilities, and <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=87040" target="_blank" rel="noopener">Decree 1421 of 2017</a> (in Spanish), incorporated into the education sector’s single regulatory decree (Decree 1075 of 2015), defined how it is done in practice. Its key instrument is the <strong>PIAR</strong>, the Spanish acronym for <em>Plan Individual de Ajustes Razonables</em>: the Individual Plan of Reasonable Accommodations.</p>
<p>That decree says something every teacher should keep taped to their desk: <strong>no school may refuse to enroll a student because of a disability or refuse to make the reasonable accommodations the student needs</strong>, and disability cannot be grounds for expulsion either. Colombia’s Constitutional Court enforces this through <em>tutela</em> actions: in <a href="https://www.corteconstitucional.gov.co/relatoria/2025/T-133-25.htm" target="_blank" rel="noopener">ruling T-133 of 2025</a> (in Spanish), it ordered a school to update a student’s PIAR with a pedagogical and social assessment that clearly identified the supports and accommodations required.</p>
<p>But stopping at the law falls short. School is the first place where a society rehearses how to live with difference. A child who shares a classroom with a deaf classmate learns that people are not divided into “normal” and “special,” but into those who have the supports they need and those who don’t.</p>
<p>And we have a long way to go. According to an analysis by the Education Economics Lab at Pontificia Universidad Javeriana using data from SIMAT, Colombia’s enrollment system, there were <a href="https://www.portafolio.co/economia/colombia-tiene-200-334-estudiantes-con-discapacidad-pero-solo-el-2-llega-al-sistema-educativo-formal-495503" target="_blank" rel="noopener">200,334 students with disabilities enrolled in 2023</a> (in Spanish), about 2% of total enrollment, and school attendance among children and young people with disabilities was considerably lower than among their peers.</p>

<h2>What inclusion is and what it isn’t</h2>
<p>Developmental psychology offers an idea that changes how we look at this: disability is not only in the person, but in the interaction between their characteristics and the <strong>barriers</strong> in their environment. Decree 1421 reflects this when it speaks of attitudinal, institutional or infrastructure barriers that prevent learning and participation.</p>
<ul>
<li><strong>It is not integration.</strong> Integrating means seating the student in the room and expecting them to adapt. Including means transforming the room so they can learn and participate.</li>
<li><strong>It is not a parallel curriculum.</strong> The PIAR adapts the common curriculum; it doesn’t invent a different one so the student can copy worksheets at the back of the room.</li>
<li><strong>It is not lowering expectations.</strong> It changes the path, the time or the way of showing learning, with high and realistic goals.</li>
<li><strong>It does not depend on a diagnosis.</strong> The decree is explicit: reasonable accommodations do not depend on a medical diagnosis, but on the barriers that prevent the full exercise of the right to education.</li>
</ul>
<p>Many schools freeze while waiting for “the neurologist’s report” and the student loses months. You don’t need a diagnosis to notice that a child gets dysregulated by noise or understands everything with hands-on objects, and you can start adjusting that same day.</p>

<h2>What an effective PIAR must contain</h2>
<p>Under Decree 1421, the <strong>PIAR</strong> is the tool that guarantees the student’s teaching and learning processes based on a pedagogical and social assessment, including the supports and accommodations needed to learn, participate, stay in school and be promoted. As <a href="https://colombia.unir.net/actualidad-unir/que-es-piar/" target="_blank" rel="noopener">UNIR explains in its guide to the PIAR</a> (in Spanish), it is not a separate curriculum, but a way of contrasting the curriculum with each student’s characteristics to set the year’s goals and supports.</p>
<p>It is drafted during the <strong>first term of the school year</strong>, updated every year, eases the handover between grades and becomes part of the student’s school record. If the student enrolls late, the school has up to thirty days to draft it and sign the agreement record.</p>
{$img('inclusion-piar', 747, 'Infographic with the nine minimum contents of a PIAR under Decree 1421: context, pedagogical assessment, health reports, goals, reasonable accommodations, resources, specific projects, other situations and home activities, plus the agreement record', 'Minimum contents of the PIAR under Article 2.3.3.5.2.3.5 of Decree 1075 of 2015, as incorporated by Decree 1421 of 2017.')}
<p>Translated into classroom language, a PIAR that works has these pieces:</p>
<ol>
<li><strong>General and environmental information.</strong> Who the student lives with, how they get to school, what happens at recess, what support they have outside school. A PIAR that doesn’t know the home plans for an imaginary student.</li>
<li><strong>Pedagogical assessment.</strong> The heart of the document and the part most often neglected. It describes the <strong>cognitive, communicative, social-emotional, physical and participation</strong> dimensions and, above all, <strong>strengths, likes, interests, motivations</strong> and concrete <strong>barriers</strong>. “Has trouble concentrating” is useless; “stays focused about ten minutes on written tasks and over half an hour when building with hands-on materials” is useful, because that is where the accommodation comes from.</li>
<li><strong>Medical or therapy reports, if any.</strong> They help define accommodations, but their absence <strong>is no excuse not to write the PIAR</strong>. The decree requires enrolling students without a diagnosis and reporting the case so the education authority, together with the health sector, can follow up.</li>
<li><strong>Goals and targets.</strong> Few, clear and measurable, connected to grade-level learning: what the student will do, under what conditions and how we will know it was achieved.</li>
<li><strong>Reasonable accommodations and concrete supports</strong>, subject by subject: curricular (prioritizing essential learning), methodological (hands-on materials, visual supports, step-by-step instructions), timing (extra time, breaks) and assessment (oral tests, accessible formats, valuing the process). “Provide support” is not an accommodation.</li>
<li><strong>Resources:</strong> human (support teacher, interpreter, counselor), physical, technological and instructional.</li>
<li><strong>Projects and commitments:</strong> projects that include the whole class, home activities for school breaks and clear tasks for each party.</li>
<li><strong>Agreement record</strong>, signed by the guardian, the school leader, the support teacher and the teachers in charge, each keeping a copy. I recommend that the student take part and sign when old enough: nobody commits to a plan they don’t know. The record is also the family’s oversight tool.</li>
</ol>
<p>I know how much effort it takes to write all this when there are several PIARs per class and forty students in the room. That is why I built a tool on this site, <a href="/herramientas/piar/">AI-powered Reasonable Accommodations Plan (PIAR)</a> (in Spanish), which turns the context and assessment the teacher writes into a formal draft with this structure, downloadable as a PDF, to review with the team. It works in Spanish and is designed for Colombian schools. It is a starting point to save hours of writing, not a replacement for professional judgment or for the conversation with the family.</p>

<h3>Checklist for an effective PIAR</h3>
<ul>
<li>It describes strengths and interests before difficulties.</li>
<li>It names barriers in the environment, not just the student’s characteristics.</li>
<li>It has measurable goals and review dates.</li>
<li>Each accommodation is concrete, observable and assigned to a subject and a person.</li>
<li>It says how learning will be assessed, not only how it will be taught.</li>
<li>It was built with the family and, when possible, with the student.</li>
<li>It has a signed agreement record and follow-up tied to the school’s assessment system.</li>
<li>It is used in the classroom, not filed away in the office.</li>
</ul>

<h2>School, teacher and family: a triangle that can’t wobble</h2>
<p>I have seen flawless PIARs that never left a folder and simple ones that changed a student’s life. The difference was the relationship among the adults.</p>
{$img('inclusion-triangulo', 653, 'Triangle diagram with the student at the center and three corners: school, teacher and family, linked by coaching, frequent communication and agreement and follow-up', 'When one of the three corners fails, the plan collapses, no matter how well it is written.')}
<p><strong>The school’s job</strong> is to treat inclusion as an institutional matter, not as the problem of the teacher who “got” the student: protected time to plan and follow up, coaching from the <strong>support teacher</strong>, ongoing training, adjustments to the assessment system and the PIAR’s requirements built into the school improvement plan. Where there is no support teacher, the local education authority must advise the school. Anyone preparing for Colombia’s <a href="/concurso-docente/">teacher hiring exam</a> (in Spanish) as a school leader should master this topic, because it is pure management.</p>
<p><strong>The classroom teacher’s job</strong> is to observe methodically, plan with Universal Design for Learning, apply the accommodations and record what works. And to watch the language: the student is not “an ADHD” or “the inclusion kid”; she is Camila, who has ADHD and draws like no one else.</p>
<p><strong>The family’s job</strong> is to share what the school can’t see — the history, what works at home, what frightens the child — take part in the PIAR, support the agreed strategies at home and demand that they be carried out. The decree speaks of <strong>shared responsibility</strong>: the school can’t hand everything to the family, and the family can’t hand everything to the school.</p>
<p>To take care of that relationship, five habits that have worked for me:</p>
<ul>
<li><strong>Start with what the student can do.</strong> A family expecting complaints gets defensive; one that hears about progress cooperates.</li>
<li><strong>Agree on a channel and a frequency.</strong> A home-school notebook or a message every two weeks keeps conversations from happening only when there are problems.</li>
<li><strong>Translate the jargon.</strong> “Assessment accommodation” is better understood as “we’ll give the test orally and with extra time.”</li>
<li><strong>Acknowledge the fatigue</strong> of families who have spent years on therapies, paperwork and rejections.</li>
<li><strong>Take care of transitions.</strong> From preschool to primary, from primary to secondary and from one school to another is where most is lost. The PIAR must travel with the student and be updated in the new setting.</li>
</ul>

<h2>Classroom practices that actually work</h2>
<h3>Universal Design for Learning (UDL)</h3>
<p>Decree 1421 makes it the foundation: the PIAR complements what the classroom has already transformed through UDL. The approach, developed by the US organization CAST, whose <a href="https://udlguidelines.cast.org/" target="_blank" rel="noopener">UDL Guidelines</a> reached version 3.0 in 2024, means planning from the start for multiple ways to present information, express learning and motivate. In a well-designed classroom, many individual accommodations are no longer needed.</p>
{$img('inclusion-dua', 507, 'Three columns with the UDL principles: multiple means of representation, of action and expression, and of engagement, each with classroom examples', 'The three UDL principles. A classroom designed this way reduces the individual accommodations needed.')}
<h3>Co-teaching</h3>
<p>When the support teacher teaches inside the classroom alongside the lead teacher, through stations or parallel groups, instead of only pulling the student out, the support reaches everyone.</p>
<h3>Peer tutoring and cooperative learning</h3>
<p>The <a href="https://educationendowmentfoundation.org.uk/education-evidence/teaching-learning-toolkit/peer-tutoring" target="_blank" rel="noopener">Education Endowment Foundation’s Teaching and Learning Toolkit</a> places peer tutoring and collaborative learning among the highest-impact, lowest-cost strategies, while warning that results depend on how they are implemented. They work when roles rotate, when the student with a disability also teaches something and when the task genuinely needs everyone.</p>
<h3>Flexible assessment</h3>
<p>Assess what you mean to assess, not the barriers. If the goal is solving proportional reasoning problems, reading the prompt aloud to a student with dyslexia invalidates nothing. Students with disabilities receive the same reports as everyone else and, if their assessment was adjusted, an annual competency or learning-process report.</p>
<h3>Classroom climate and emotional regulation</h3>
<p>From child psychology I always repeat it: a dysregulated child doesn’t learn. Visible routines, advance notice of changes, a calm corner, movement breaks and a warm relationship prevent more meltdowns than any punishment. Many difficult behaviors are communication: something is overwhelming the child.</p>
<h3>Avoid labels</h3>
<p>A diagnosis describes; it doesn’t define. When it becomes a nickname, the student starts acting out the label. And health information is sensitive data under Colombia’s data protection law (Law 1581 of 2012), not to be shared without authorization.</p>
<h3>Care for the caregivers</h3>
<p>No exhausted teacher can sustain an inclusive classroom. Practical training, planning time and spaces to discuss difficult cases without being judged are conditions, not luxuries.</p>

<h2>How Latin America does it</h2>
<p>UNESCO’s <a href="https://igualdad.cepal.org/es/digital-library/global-education-monitoring-report-2020-latin-america-and-caribbean-inclusion-and" target="_blank" rel="noopener">2020 Global Education Monitoring Report for Latin America and the Caribbean</a> concluded that the region has strong laws and policies showing commitment to inclusion, but that students’ daily reality shows implementation lagging behind. That is what we experience in Colombia. Some neighboring models:</p>
<ul>
<li><strong>Chile</strong> brings special education teachers into mainstream schools through its <em>School Integration Program</em> (PIE) and, with <strong>Decree 83 of 2015</strong>, adopted UDL for all students and reserved the individual plan (PACI) for when that isn’t enough.</li>
<li><strong>Mexico</strong> has its regular-education support units (USAER) and a <a href="https://www.uv.mx/rmipe/files/2022/05/Estrategia-nacional-de-educacion-inclusiva.pdf" target="_blank" rel="noopener">National Inclusive Education Strategy</a> (in Spanish) that, within the New Mexican School model, focuses on removing barriers to learning and participation.</li>
<li><strong>Argentina</strong>, through <a href="https://argentina.gob.ar/sites/default/files/anexo-ii-res-311-cfe-58add83aa4885.pdf" target="_blank" rel="noopener">Federal Education Council Resolution 311 of 2016</a> (in Spanish), defined the <em>Individual Pedagogical Project for Inclusion</em> (PPI) and rules for promotion and certification.</li>
<li><strong>Peru</strong> supports mainstream schools with SAANEE teams and strengthened the inclusive approach in its General Education Law regulations in 2021; <strong>Uruguay</strong> has had a national protocol for inclusion in schools since 2017, updated in 2022.</li>
</ul>
<p>Colombia is not behind on regulations. What we lack, like much of the region, are enough support teachers, better initial teacher training and steady funding.</p>

<h2>The United States: IEPs, 504 plans and the least restrictive environment</h2>
<p>According to the <a href="https://nces.ed.gov/programs/coe/indicator/cgg/students-with-disabilities" target="_blank" rel="noopener">National Center for Education Statistics (NCES)</a>, 7.5 million students ages 3 to 21 received services under IDEA in 2022–23, 15% of public school enrollment, and more than two-thirds spent at least 80% of the school day in general classes.</p>
<ul>
<li><strong>IEP (Individualized Education Program):</strong> built by a team with parents and teachers; it records current performance, measurable annual goals, services and how progress will be measured, and is reviewed at least once a year.</li>
<li><strong>504 plan:</strong> based on Section 504 of the Rehabilitation Act of 1973, it provides accommodations, such as extra time or different seating, without changing the curriculum.</li>
<li><strong>Least restrictive environment (LRE):</strong> students are educated with their peers as much as possible; removing them from the general classroom must be justified.</li>
<li><strong>MTSS or RTI:</strong> tiered supports, from good teaching for all to intensive intervention for a few.</li>
</ul>
<p>Worth copying: measurable goals and tiers of support. Not worth copying: turning a diagnosis into a mandatory gateway, precisely what Decree 1421 sought to avoid.</p>

<h2>The rest of the world: from Salamanca to New Brunswick</h2>
<p>In 1994, representatives of 92 governments and 25 international organizations adopted the <a href="https://www.european-agency.org/sites/default/files/salamanca-statement-and-framework.pdf" target="_blank" rel="noopener">Salamanca Statement</a>, which held that regular schools with an inclusive orientation are the most effective means of combating discriminatory attitudes. The 2006 UN Convention made it a right, and Sustainable Development Goal 4 put it on the global agenda.</p>
<ul>
<li><strong>Finland</strong> organizes support in three tiers (general, intensified and special) and bets on early identification within the mainstream school.</li>
<li><strong>Italy</strong> closed its special classes in the late 1970s and educates almost all students with disabilities in mainstream classrooms, with a support teacher and an individualized plan.</li>
<li><strong>Portugal</strong>, with Decree-Law 54 of 2018, stopped classifying students by category and organized universal, selective and additional measures decided by a multidisciplinary team.</li>
<li><strong>New Brunswick (Canada)</strong>, with its <a href="https://www.allfie.org.uk/resources/inclusion-now/inclusion-now-47/transforming-educational-systems-lessons-new-brunswick/" target="_blank" rel="noopener">Policy 322 of 2013</a>, banned classrooms segregated by disability and created support teams in every school.</li>
</ul>
{$img('inclusion-mapa', 693, 'Four cards summarizing inclusive education in Colombia, Latin America, the United States and the world, with their main laws and instruments', 'Four scales of the same right. Colombia has good regulations; the challenge is implementation.')}

<h2>Comparing the main individual plans</h2>
<table>
<thead><tr><th>Instrument</th><th>Basis</th><th>Diagnosis required?</th><th>Who builds it</th><th>Review</th></tr></thead>
<tbody>
<tr><td>PIAR (Colombia)</td><td>Decree 1421 of 2017</td><td>No: accommodations depend on barriers</td><td>Classroom teachers, support teacher, family and student</td><td>First term, updated yearly</td></tr>
<tr><td>IEP (US)</td><td>IDEA</td><td>Yes, an eligibility evaluation</td><td>School team with parents</td><td>At least once a year</td></tr>
<tr><td>504 plan (US)</td><td>Section 504, Rehabilitation Act</td><td>Yes, the condition must limit a major life activity</td><td>School team</td><td>Periodic, by district</td></tr>
<tr><td>PIE and PACI (Chile)</td><td>Decrees 170 of 2009 and 83 of 2015</td><td>PIE requires a diagnostic assessment</td><td>Teacher, special educator and professionals</td><td>Yearly</td></tr>
<tr><td>EHCP (England)</td><td>Children and Families Act 2014</td><td>Requires a needs assessment</td><td>Local authority with family and school</td><td>Yearly, ages 0 to 25</td></tr>
</tbody>
</table>
<p>The table shows an underrated Colombian strength: the PIAR does not make accommodations conditional on a diagnosis and requires building them with the family and the student.</p>

<h2>Inclusion with the whole class: students without accommodations count too</h2>
<p>The student with a PIAR doesn’t learn in a bubble: they share the room with thirty classmates who watch, compare and sometimes complain.</p>
<h3>Explaining differences without exposing anyone</h3>
<p>A student’s diagnosis belongs to them and their family. It is never announced to the class; it is discussed only if the family and the student decide to and prepare for it. What you can do is talk about diversity in general: we all learn differently, some of us wear glasses, others need quiet. When the conversation is about everyone, no one is singled out.</p>
<h3>“Fair is not the same as equal”</h3>
<p>Students have a sharp sense of justice, and a “why does he get more time?” deserves an honest answer. Mine is usually another question: “If you broke your arm, would it be fair to ask you to write like everyone else?” Being fair means each student gets what they need to reach the goal.</p>
{$img('inclusion-justo', 587, 'Three panels with students of different heights in front of a board: equal, everyone gets the same support; fair, each gets the support they need; design for all, the board is lowered and nobody needs support', 'Equality, equity and universal design. The goal is the third panel; the PIAR handles whatever is still pending.')}
<h3>Make accommodations available to all</h3>
<p>The most powerful move is to offer the whole class what the PIAR asks for one student: written instructions on the board, the option to answer orally, headphones for anyone who wants to concentrate, extra time for whoever needs it. The accommodation stops being a visible privilege and becomes a classroom option.</p>
<h3>What the rest of the class gains</h3>
<p>The evidence is reassuring. A review of 280 studies from 25 countries, prepared by Thomas Hehir and colleagues for Instituto Alana, found <a href="https://alana.org.br/wp-content/uploads/2016/12/A_Summary_of_the_evidence_on_inclusive_education.pdf" target="_blank" rel="noopener">clear and consistent evidence</a> that inclusive settings can benefit students with and without disabilities, who also develop fewer prejudices. A meta-analysis by Szumski, Smogorzewska and Karwowski covering 47 studies, published in 2017, found a <a href="https://doi.org/10.1016/j.edurev.2017.02.004" target="_blank" rel="noopener">positive, albeit small</a>, effect on the academic achievement of classmates without special educational needs. Inclusion doesn’t hold others back.</p>
<p>The condition is support. Without a support teacher or a behavior plan, frequent meltdowns affect everyone’s climate. The answer is not exclusion, but demanding the supports the law already requires.</p>
<h3>Handling other parents’ concerns</h3>
<ul>
<li><strong>Listen without dismissing:</strong> concern for a child’s learning is legitimate, even when misdirected.</li>
<li><strong>Talk about the classroom, not the child:</strong> never share information about another student.</li>
<li><strong>Show the evidence</strong> and explain what is being done, such as a protocol for meltdowns.</li>
<li><strong>Calmly recall the legal framework:</strong> enrollment and accommodations are not negotiable.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What is the PIAR?</h3>
<p>It is the Individual Plan of Reasonable Accommodations established by Decree 1421 of 2017 for students with disabilities in Colombia. It records the student’s context, pedagogical assessment, goals and the accommodations, supports and resources needed to learn and participate with their class.</p>
<h3>Is a medical diagnosis required to write a PIAR?</h3>
<p>No. Health reports help, but reasonable accommodations do not depend on a medical diagnosis; they depend on the barriers the student faces. The lack of a diagnosis is not grounds to refuse enrollment either.</p>
<h3>Who writes the PIAR, and when?</h3>
<p>Classroom teachers lead it with the support teacher, the family and the student; depending on the school, leaders and the counselor also take part. It is drafted in the first term of the school year and updated every year.</p>
<h3>Does inclusion harm other students?</h3>
<p>The evidence says no: international reviews find neutral or slightly positive effects on classmates’ achievement and social benefits such as fewer prejudices, as long as inclusion has the necessary supports.</p>

<h2>Conclusion</h2>
<p>Classroom inclusion is not achieved with a well-filled form or isolated goodwill. It happens when the school organizes time and support, the teacher plans for diversity from the start, the family takes part as an ally and the class understands that fair is not the same as equal. Colombia has some of the most complete regulations in the region; what is missing is turning them into daily practice, with trained teachers, enough support teachers and PIARs used in the classroom, not just kept in a folder. If you are interested in that broader discussion, my analyses of <a href="/pruebas-pisa-america-latina-colombia-docentes-familias/">PISA results in Latin America</a> and the <a href="/proyecto-de-vida-colegio-docentes-caso-platzi/">life project at school</a> show other sides of the same question, and <a href="/aulamagica-ia-herramientas-ia-docentes/">AulaMágica IA</a> has more ideas for using artificial intelligence in the classroom.</p>

<p class="notice"><strong>Try the AI-powered Reasonable Accommodations Plan (PIAR).</strong> You enter the student’s context, select their conditions and the parameters you need, and get a formal, structured PIAR draft, downloadable as a PDF, to review with your team and the family. The tool works in Spanish and follows Colombian regulations. You get one free PIAR to try it and, if it helps, monthly packages of 5, 10 or 20 PIARs for 30,000, 50,000 or 80,000 Colombian pesos. AI saves you hours of writing; professional judgment and the family’s voice remain irreplaceable.</p>
<p><a class="btn-link" href="/herramientas/piar/">Try the PIAR tool (in Spanish)</a></p>

<h2>A question to close</h2>
{$img('inclusion-pregunta', 480, 'Closing question: if the classroom was designed for an average student who never existed, who really needs the accommodations, the student or the school', 'The question that remains open.')}
<p>In the 1950s, the US Air Force measured thousands of pilots to design a cockpit for the “average pilot” and found that none of them matched the average on every measurement, as Todd Rose recounts in <em>The End of Average</em>. The fix was adjustable seats and pedals. <strong>If the classroom was designed for an “average student” who never existed, who really needs the accommodations: the student or the school?</strong></p>
HTML,
    ],
];
