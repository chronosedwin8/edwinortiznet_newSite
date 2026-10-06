<?php

declare(strict_types=1);

// English versions of the Grupo Logic articles (part 3). Keys are the Spanish slugs.
return [
    'vcodepro-editor-codigo-ia-ensenar-programacion-colegio' => [
        'slug' => 'vcodepro-ai-code-editor-teaching-programming-school',
        'title' => 'VCodePro: an AI code editor for teaching programming at school',
        'excerpt' => 'What VCodePro is, the problem it solves, and 9 concrete ideas for teaching programming and building AI agents with secondary school students from age 12.',
        'seo_title' => 'VCodePro: Teach Coding and AI at School, With 9 Ideas',
        'seo_description' => 'Discover VCodePro, the AI code editor for teaching programming from age 12: key features, 9 classroom ideas, a step-by-step start and good practices.',
        'focus_keyword' => 'VCodePro',
        'cover_alt' => 'VCodePro home page, an AI-powered code editor for teaching programming at school',
        'content_html' => <<<'HTML'
<p>If you teach technology or computer science in secondary school, you already know your students live with artificial intelligence every day. The question isn’t whether they’ll use it, but whether they’ll learn to build it with good judgment. <strong>VCodePro</strong> is an AI code editor designed for exactly that: teaching programming from age 12 and bringing the creation of AI agents into the classroom, with criterion-based assessment built into the same tool.</p>
<p>Here I’ll tell you what it is, what problem it solves and, above all, how to use it in class, with concrete ideas, suggested grade levels and links to other subjects.</p>

<h2>What is VCodePro?</h2>
<p>VCodePro is a professional code editor for schools, developed by Grupo Logic. It brings together three things that usually live apart: an editor with industry-standard tools, an artificial intelligence assistant in <em>teaching mode</em>, and a studio where students design, test and publish their own AI agents.</p>
<p>It is aligned with the International Baccalaureate (IB) technology subjects: Computer Science SL and HL, Design and MYP Design, ITGS, the Personal Project, the Computer Science Extended Essay and CAS with a digital focus. But it isn’t only for IB schools: it comes with a classroom plan for grades 6 to 12, with 32 sessions per year, that works for any school. The editor is a free download for Windows, macOS and Linux; the school license unlocks classroom mode, rubrics, the progress dashboard and support.</p>

<h2>What problem does it solve?</h2>
<p>Any technology teacher will recognize two tensions. The first: students use AI as passive users and, if nobody sets rules, the AI ends up doing the work for them. The second: technology subjects, especially in the IB, demand evidence of the process, criterion-based assessment and documentation of the design cycle, a workload that almost always falls on the teacher.</p>
<p>VCodePro tackles both. Its assistant answers with questions, hints and analogous examples instead of solutions, and you decide how much help each class gets. On top of that, rubrics and the design journal are built into the daily work: you teach and assess in the same place.</p>

<h2>Key features</h2>
<ul>
<li><strong>Assistant in teaching mode.</strong> It explains code in plain language and answers with hints, not with the answer. The teacher sets the level of help for each class.</li>
<li><strong>AI agent studio.</strong> Students define an agent’s purpose, assign it tools (running tests, reading project files, querying a dataset or calling an API approved by the school), test it, measure its performance and publish it for the class once the teacher approves it. A guided form in Spanish lets them build their first agent without writing any code.</li>
<li><strong>Full-featured editor.</strong> Syntax highlighting, autocomplete, a debugger, an integrated terminal and version control for Python, JavaScript, HTML, CSS, Java and C++.</li>
<li><strong>Classroom mode.</strong> You see each student’s progress in real time, share templates and open pair programming sessions.</li>
<li><strong>Built-in IB rubrics.</strong> Criteria A, B, C and D: students see what’s missing before they hand in, and you export the grades.</li>
<li><strong>Automatic design journal.</strong> Inquiring, developing ideas, creating and evaluating, the stages of the MYP design cycle, are recorded while the student works.</li>
<li><strong>Academic integrity.</strong> Logs of conversations and versions, content filters, usage caps per class and an exam mode that turns the AI off.</li>
</ul>
<p>The license also includes a bank of more than 120 projects and challenges sorted by criterion, difficulty and duration, a coordination dashboard and training for the teaching team. A key detail for our computer labs: it’s lightweight and runs on computers that are several years old, without a permanent internet connection.</p>
<figure><img src="/assets/img/articulos/grupologic/vcodepro-panel-1100.webp" srcset="/assets/img/articulos/grupologic/vcodepro-panel-560.webp 560w, /assets/img/articulos/grupologic/vcodepro-panel-1100.webp 1100w" sizes="(min-width: 760px) 720px, 100vw" width="1100" height="493" alt="VCodePro editor with a Python temperature station project and the classroom panel reviewing the work against the IB rubric"><figcaption>A grade 9 project in VCodePro: the Python code and, below, the classroom panel with the passed tests and a suggestion for the design journal.</figcaption></figure>

<h3>What it offers for each IB subject</h3>
<table>
<thead>
<tr><th>Subject</th><th>What you’ll find</th></tr>
</thead>
<tbody>
<tr><td>Computer Science SL and HL</td><td>Templates for data structures, algorithms, databases and the internal assessment, with complexity checks and test cases.</td></tr>
<tr><td>Design and MYP Design</td><td>A design cycle journal, product specifications and photo evidence linked to the code.</td></tr>
<tr><td>ITGS</td><td>Case studies with real data, social impact analysis and worksheets on privacy, security and digital ethics.</td></tr>
</tbody>
</table>

<h2>Ideas for using VCodePro in the classroom</h2>
<p>The grade levels are suggestions: adjust them to your group’s actual level.</p>

<h3>1. An algorithm tutor built by the class itself</h3>
<p><strong>Grades 9 and 10 · Computer science and math.</strong> In the agent studio, students design a tutor for search, sorting or loop exercises. The rule goes in the instructions: “never give the full solution; ask a question that leads to the next step.” They test it with real mistakes, such as an infinite loop in a binary search, and once you approve it, it’s published for the class. They learn algorithms twice: by solving problems and by teaching the machine how to guide.</p>

<h3>2. Data analysis from a science experiment</h3>
<p><strong>Grades 8 and 9 · Science and statistics.</strong> For a week, they record the temperature of the classroom, the schoolyard and the computer lab in a CSV file. Then they write Python functions to calculate the average, maximum and minimum, and check that there are no empty readings. Science provides the research question; math, the interpretation; the design journal, the evidence of how they validated the data.</p>

<h3>3. Agents that solve real school problems</h3>
<p><strong>Grades 10 and 11 · Technology and civic education.</strong> Each team picks an everyday problem: questions about the school’s code of conduct, guidance for new students, or questions about the community service requirement. They design an agent that queries an approved dataset and they measure it: does it answer correctly? Does it make things up? Does it recognize when it doesn’t know? Since each tool is enabled only with explicit permission, the design includes deciding what the agent can and cannot do.</p>

<h3>4. An AI ethics workshop</h3>
<p><strong>Grades 10 and 11 · ITGS, ethics and social studies.</strong> Before building anything, discuss: what data should a school agent read? Who reviews its answers? What happens if it gets something wrong? The ITGS worksheets on privacy, security and digital ethics are a good starting point. Then each team writes down and justifies the limits of its agent, and they wrap up with a debate supported by the conversation logs.</p>

<h3>5. Project-based assessment with criteria A, B, C and D</h3>
<p><strong>Grades 7 to 10 · MYP Design and technology.</strong> Set an authentic project, such as a simple app to estimate water use at home. Share the rubric from day one: students see what’s missing before they hand in, the design journal records each stage of the design cycle, and you export the grades at the end.</p>

<h3>6. First steps in Python, in pairs</h3>
<p><strong>Grades 6 and 7 · Technology and math.</strong> Take short challenges from the project bank and organize pair programming sessions: one writes, the other reviews, and they switch every ten minutes. With classroom mode you see progress in real time and get to the stuck pair first. At this level it’s best to give little AI help, so they build solid foundations.</p>

<h3>7. A website for the class project</h3>
<p><strong>Grades 8 and 9 · Language arts, social studies and art.</strong> They build a site about the history of their neighborhood: HTML for structure, CSS for design and JavaScript for a final quiz. Language arts reviews the writing and social studies, the content. Version control shows them how their work evolved.</p>

<h3>8. With AI and without AI: a lesson on academic integrity</h3>
<p><strong>From grade 7 · Technology and life-skills education.</strong> Work for a week with the assistant on, then give a short quiz in exam mode. Afterwards, talk it over: what did I learn, and what did the assistant do? You talk about academic honesty with evidence, not sermons.</p>

<h3>9. Personal Project or Computer Science Extended Essay</h3>
<p><strong>Grades 11 and 12 · Computer Science HL.</strong> Advanced students rely on the templates with complexity checks and test cases. Every version of the code and of the agent is recorded, which makes it easier for the supervisor to follow the process and for the student to defend their decisions.</p>
<p>If your school starts the programming pathway earlier, take a look at <a href="/codexia-plataforma-programacion-ninos-ideas-aula/">Codexia</a> and <a href="/codenest-school-programacion-ninos-4-a-12-anos-aula/">CodeNest School</a>, which develop computational thinking from ages 4 to 12.</p>
<figure><img src="/assets/img/articulos/grupologic/vcodepro-agentes-1100.webp" srcset="/assets/img/articulos/grupologic/vcodepro-agentes-560.webp 560w, /assets/img/articulos/grupologic/vcodepro-agentes-1100.webp 1100w" sizes="(min-width: 760px) 720px, 100vw" width="1100" height="1184" alt="VCodePro agent studio with an algorithm tutor that guides a student through questions instead of giving the solution"><figcaption>An agent built in class guides the student with questions, without handing over the solution.</figcaption></figure>

<h2>How to get started, step by step</h2>
<ol>
<li><strong>Download the editor.</strong> It’s free for Windows, macOS and Linux; in computer labs you can install it on every machine at once with the silent installation package.</li>
<li><strong>Activate the school license.</strong> The coordinator receives the key, and it’s activated only once per school.</li>
<li><strong>Create your classes.</strong> Import the student list, assign the licenses and share the first project with a class code.</li>
<li><strong>Choose the first challenge.</strong> Review the classroom plan for your level and pick a short project from the bank.</li>
<li><strong>Set up the AI help.</strong> Decide how much help each class gets and agree on the rules of use before opening the assistant.</li>
<li><strong>Teach and assess</strong> with the IB criteria from the same dashboard.</li>
</ol>

<h2>Good practices and precautions</h2>
<ul>
<li><strong>Protect personal data.</strong> No agent needs the names, grades or health data of real students. Use fictitious or anonymized data and only APIs approved by the school, and review the school’s data protection policy with your coordinator.</li>
<li><strong>Agree on academic honesty rules.</strong> Put in writing when students may ask the AI for help. Use the conversation logs to give feedback and exam mode when you need evidence of individual work.</li>
<li><strong>Review before publishing.</strong> Test each agent’s answers yourself before approving it for the class.</li>
<li><strong>Think first, code later.</strong> Ask for a diagram or pseudocode on paper before opening the editor.</li>
<li><strong>Cater to diversity.</strong> Combine pair work, challenges of different difficulty and plain-language explanations so nobody gets left behind.</li>
</ul>
<p>To go further, check out the guide to <a href="/ia-para-docentes/">AI for teachers</a> and the analysis of the <a href="/herramientas-tecnologicas-para-docentes-pros-y-contras/">pros and cons of technology tools for teachers</a> (in Spanish).</p>

<h2>Frequently asked questions</h2>
<h3>From what age can VCodePro be used?</h3>
<p>From age 12. It includes a classroom plan for grades 6 to 12, with 32 sessions per year and assessable projects.</p>
<h3>Does VCodePro’s AI do students’ homework for them?</h3>
<p>No. In teaching mode it answers with questions, hints and analogous examples; the teacher controls how much help each class gets and can turn on exam mode, which disables the AI.</p>
<h3>Is it only for International Baccalaureate schools?</h3>
<p>No. Its classroom plan works for any school; it is also aligned with the IB technology subjects and the MYP design cycle.</p>
<h3>Which programming languages does it include?</h3>
<p>Python, JavaScript, HTML, CSS, Java and C++, with a debugger, an integrated terminal and version control.</p>
<h3>Do we need new computers or a permanent internet connection?</h3>
<p>No. It starts in seconds, it’s lightweight and it runs on computers that are several years old, without a permanent connection.</p>
<h3>Can I try it before the school buys the license?</h3>
<p>Yes. The editor is a free download; the license unlocks the classroom and assessment features.</p>

<h2>Conclusion</h2>
<p>VCodePro proposes that students stop being consumers of artificial intelligence and learn to build it with good judgment, while the teacher keeps control over the help they get and over assessment. Start with a small, well-defined project.</p>
<p><a href="https://www.grupologiclatam.com/productos/vcodepro/?utm_source=edwinortiz.net&amp;utm_medium=articulo&amp;utm_campaign=vcodepro-editor-codigo-ia-ensenar-programacion-colegio" rel="noopener">Learn more about VCodePro on Grupo Logic’s official page</a> and explore other options in the <a href="/herramientas/">tools directory</a>.</p>
HTML,
    ],
    'bookstudio-libros-interactivos-aula' => [
        'slug' => 'bookstudio-interactive-books-classroom',
        'title' => 'BookStudio: interactive books in the classroom, a guide and ideas for teachers',
        'excerpt' => 'What BookStudio is, how it works, and 10 ideas for your students to create interactive books with voice, video, maps, charts and self-grading questions.',
        'seo_title' => 'BookStudio: Interactive Books in the Classroom, 10 Ideas',
        'seo_description' => 'Meet BookStudio and create interactive books with voice, video, maps, charts and self-grading questions: key features, 10 classroom ideas and a how-to.',
        'focus_keyword' => 'BookStudio',
        'cover_alt' => 'BookStudio home page, a platform for interactive books that students create, listen to and share',
        'content_html' => <<<'HTML'
<p>Your students learn more when they produce: when they explain things in their own voice, organize ideas and share what they’ve created. The problem is that much of schoolwork is still trapped in notebooks and static documents. <strong>BookStudio</strong> is a web platform for creating interactive books with voice, video, maps, charts and questions that grade themselves, and it also lets you hand out material, give a grade with comments and keep track of each student’s work.</p>
<p>In this article I explain what BookStudio is, what problem it solves and what its features are. The heart of the article is the ideas for using it across different subjects and grade levels, followed by a step-by-step guide and a few precautions.</p>

<h2>What is BookStudio?</h2>
<p>BookStudio is an interactive book platform from Grupo Logic that runs in the browser, with nothing to install. It offers a free-form canvas, not a word processor with decorations: each element goes wherever it makes sense. A single page can hold text, images, audio recorded by the student, video, maps, charts, formulas and self-grading questions.</p>
<p>It’s used both by teachers, to create material, and by students, to build their own books. Younger children log in with a QR code, no email or password needed; everyone else uses their school email.</p>

<h2>What problem does it solve?</h2>
<p>There are two very familiar pain points. First: students’ work usually ends up in formats you can’t listen to, explore or interact with. Second: reviewing, grading and tracking that work across several different tools takes time we just don’t have.</p>
<p>BookStudio brings both together. Students create, listen and share on a single canvas; you hand out the material, give a grade with a comment and know how much each student has worked, all in one place.</p>

<h2>Key features</h2>
<ul>
<li><strong>Free-form canvas.</strong> Text, images, shapes, icons and drawings wherever they make sense: 26 shapes, 2,048 icons, emojis and 17 fonts chosen for readability, including OpenDyslexic.</li>
<li><strong>Voice, photo and video.</strong> Recorded right from the browser with the computer’s camera and microphone. Audio clips are inserted as listening points in the color you choose.</li>
<li><strong>Self-grading questions.</strong> Single answer, multiple answers or ordering, with text and images and a celebration animation for correct answers. The answer is checked on the server, so nobody can peek.</li>
<li><strong>Charts, formulas and maps.</strong> Six chart types with editable data, LaTeX formulas and OpenStreetMap maps inside the document, no screenshots required.</li>
<li><strong>Free media and embeds.</strong> A search tool for Creative Commons–licensed images and sounds with automatic attribution, plus embedded content from YouTube, Google, Canva or Genially.</li>
<li><strong>Templates and graphic organizers.</strong> 24 templates, including Venn diagrams, KWL charts, story maps, fishbone diagrams and Cornell notes.</li>
<li><strong>Grading and tracking.</strong> A grade and comment per book as many times as needed, a class grid with each student’s average, and a log of how many times and for how long each student worked.</li>
<li><strong>Distribution and group work.</strong> You send a page or a whole book to the class, and each student gets their own editable copy. You can also mark a book as collaborative so the whole group contributes to the same document.</li>
<li><strong>Sharing and exporting.</strong> Read-only links, public or restricted to the group and revocable with one click. Every book can be exported to PDF or to a standalone, single-file web page.</li>
</ul>
<figure><img src="/assets/img/articulos/grupologic/bookstudio-editor-1440.webp" srcset="/assets/img/articulos/grupologic/bookstudio-editor-640.webp 640w, /assets/img/articulos/grupologic/bookstudio-editor-960.webp 960w, /assets/img/articulos/grupologic/bookstudio-editor-1440.webp 1440w" sizes="(min-width: 760px) 720px, 100vw" width="1440" height="810" alt="BookStudio editor with tools to insert text, an image, a map, a question and a chart, and a page using the story map template"><figcaption>The BookStudio editor: insertion tools on the left and the story map template (“Mapa del cuento”) on the canvas.</figcaption></figure>

<h2>Ideas for using BookStudio in the classroom</h2>
<p>The grade levels are just a guide: what matters is that students produce, not just consume.</p>

<h3>1. Illustrated stories narrated in their own voice</h3>
<p><strong>Grades 2 to 5 (primary) · Language arts.</strong> Each student writes a short story, illustrates it with drawings, icons or freely licensed images, and records their voice reading each page. Before writing, they use the story map template to define the characters, setting, beginning, middle and end. Reading aloud and then listening to themselves builds reading fluency in a way a notebook can’t.</p>

<h3>2. A reading journal with audio and self-assessment</h3>
<p><strong>Grades 6 to 9 · Language arts and the school reading program.</strong> While reading a novel, students summarize each chapter, record an audio clip with their opinion and create two or three self-grading questions for their classmates. You grade the journal several times during the term, with a grade and comment, and they see your feedback inside their own book.</p>

<h3>3. An interactive social studies atlas with maps</h3>
<p><strong>Grades 6 to 8 · Social studies.</strong> Using OpenStreetMap, they build an atlas of their town, of Colombia’s natural regions or of the route of a historical process. Each page combines a map, an explanatory text, a listening point with their voice and a check-for-understanding question. That way they connect geography with their everyday lives.</p>

<h3>4. A lab report with real data charts</h3>
<p><strong>Grades 8 to 10 · Science and statistics.</strong> After an experiment, such as seed germination or heating water, they enter their data into one of the six editable charts, explain their conclusions and add a photo or a short video of the setup. Since the data stays editable, they can correct and compare results across groups.</p>

<h3>5. A math and physics guide with LaTeX</h3>
<p><strong>Grades 9 to 11 · Math and physics.</strong> Create a review guide on linear functions or uniformly accelerated motion: a brief explanation, LaTeX formulas, a chart with data and self-grading questions at the end of each section. You can also flip the challenge and have each team build the guide for one topic for the rest of the class.</p>

<h3>6. An illustrated English dictionary with pronunciation</h3>
<p><strong>Primary and grades 6 to 8 · English as a foreign language.</strong> Each student creates themed vocabulary pages (food, jobs, places in the city) with an image, the word, an example sentence and their own voice pronouncing it. With ordering questions, they put together exercises for their classmates to rebuild sentences. Hearing their own recordings helps them improve their pronunciation and lose their fear of speaking.</p>

<h3>7. A collaborative project across several classes</h3>
<p><strong>Any level · Cross-curricular projects.</strong> You can build groups with students from several classes, for example five from 10A, six from 10B and nine from 10C, and create a collaborative book they all contribute to. Use it for the school’s environmental project, a science fair or a record of a field trip, and share it with families through a read-only link.</p>

<h3>8. Graphic organizers for thinking before writing</h3>
<p><strong>Grades 4 to 11 · All subjects.</strong> At the start of a unit, hand out to the class a page with the KWL template (what I know, what I want to know, what I learned), and each student works on their own copy. In ethics or citizenship classes, the fishbone diagram helps analyze the causes of a problem at school; the Venn diagram is useful for comparing two eras, two cells or two texts.</p>

<h3>9. Accessible material for inclusion</h3>
<p><strong>All grades · With support from the school counseling team.</strong> Accessibility comes built in: dyslexia-friendly fonts such as OpenDyslexic, a minimum readable size and audio. Prepare guides with explanations recorded in your own voice for students with reading difficulties, and let some of them answer with audio or images instead of only text. It’s a practical way to apply Universal Design for Learning.</p>

<h3>10. An evidence portfolio for the term</h3>
<p><strong>Grades 6 to 11 · Any subject.</strong> Instead of handing in separate assignments, each student builds a portfolio book with their best work and an audio reflection. The log shows you how much time they actually spent, because sessions close automatically after a few minutes of inactivity, and the grading grid gives you an overview of the class.</p>
<p>If your students already make infographics, this is a good next step: start from what we covered in <a href="/infografia-en-power-point/">how to make an infographic in PowerPoint</a> (in Spanish) and take it to a format with voice and questions.</p>

<h2>How to get started, step by step</h2>
<ol>
<li><strong>Try it without signing up.</strong> You can open the editor with no account and no card, limited to one two-page book.</li>
<li><strong>Create a sample book.</strong> Start from scratch or with one of the 24 templates, and practice inserting an audio clip, a chart and a question.</li>
<li><strong>Choose a plan with your school.</strong> There are options for a single teacher, for a school or for an entire institution.</li>
<li><strong>Invite your group</strong> with a link, a QR code or by selecting students class by class.</li>
<li><strong>Hand out the first activity</strong> to the whole class so each student works on their own copy.</li>
<li><strong>Grade and publish.</strong> Give a grade with your comment, share the link or export to PDF.</li>
</ol>

<h2>Good practices and precautions</h2>
<ul>
<li><strong>Privacy first.</strong> Before recording the voices and videos of minors, inform families according to your school’s policy. Use links restricted to the group when faces or voices appear, and revoke them when they’re no longer needed.</li>
<li><strong>Academic honesty and copyright.</strong> Teach students to use the Creative Commons media search and to respect attribution. If your school uses AI tools to generate text or images, agree on when they’re allowed and how their use is disclosed.</li>
<li><strong>Accessibility by design.</strong> Choose readable fonts, add audio to long texts and avoid overloaded pages.</li>
<li><strong>Connectivity.</strong> Since it runs in the browser, check the lab’s connection before a recording session and have a plan B.</li>
<li><strong>Your books are yours.</strong> Export the best work to PDF or to a web page: they open with a double click, without the platform.</li>
</ul>
<p>To choose wisely, review the <a href="/herramientas-tecnologicas-para-docentes-pros-y-contras/">pros and cons of technology tools for teachers</a> (in Spanish) and the <a href="/ia-para-docentes/">AI for teachers</a> section. If you’re interested in planning with AI, also read about <a href="/edunova-ia-planear-ensenar-evaluar-colegio/">EduNova</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Can you try BookStudio before buying?</h3>
<p>Yes. You can open the full editor without signing up, limited to one two-page book.</p>
<h3>What do students need to log in?</h3>
<p>Just a browser. Younger children log in with a QR code, no email or password needed; everyone else uses their school email.</p>
<h3>Where is student data stored?</h3>
<p>On the service’s servers, encrypted in transit and backed up daily, with no ad tracking and no sharing of data with third parties.</p>
<h3>Can we take our books with us if we stop using the service?</h3>
<p>Yes. Each book can be exported to PDF or to a single-file web page, with its images and navigation, that opens with a double click without the platform.</p>
<h3>Can several people edit the same book?</h3>
<p>Yes. A book marked as collaborative accepts contributions from the whole group. Other people’s changes appear when you reload the page.</p>

<h2>Conclusion</h2>
<p>BookStudio turns schoolwork into something you can read, listen to, explore and share, and it saves you the hassle of reviewing across several tools. Start with a single activity, like a reading journal or a lab report, and let your students discover everything that fits on a page.</p>
<p><a href="https://www.grupologiclatam.com/productos/bookstudio/?utm_source=edwinortiz.net&amp;utm_medium=articulo&amp;utm_campaign=bookstudio-libros-interactivos-aula" rel="noopener">Learn more about BookStudio on Grupo Logic’s official page</a> and start creating your first interactive book.</p>
HTML,
    ],
];
