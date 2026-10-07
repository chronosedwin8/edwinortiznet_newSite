<?php

declare(strict_types=1);

// English version of the article on AI and job replacement. Key is the Spanish slug.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-reemplazo/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$ext = static fn (string $url, string $text): string => '<a href="' . $url . '" target="_blank" rel="noopener">' . $text . '</a>';

return [
    'la-ia-no-te-reemplazara-quien-la-domine-si' => [
        'slug' => 'ai-wont-replace-you-someone-who-masters-it-will',
        'title' => 'AI Won’t Replace You. Someone Who Masters It Will',
        'excerpt' => 'AI rarely replaces professionals on its own: they are displaced by the people and organizations that learn to use it well. I review the data without alarmism, what AI does badly, what mastering it really means and a 30-day plan for teachers, school leaders and professionals in other fields.',
        'seo_title' => 'Will AI Replace Us? Those Who Master It Will',
        'seo_description' => 'AI doesn’t replace professionals: people who use it well do. Verified data, real limits and a 30-day plan for teachers, school leaders and professionals.',
        'focus_keyword' => 'will AI replace us',
        'cover' => '/assets/img/articulos/ia-reemplazo/ia-reemplazo-portada-en',
        'cover_alt' => 'Cover with the title AI won’t replace you. Someone who masters it will, next to a legacy spreadsheet full of #REF! errors and a card with a workflow: draft with AI, check the sources, apply your judgment and sign',
        'content_html' => <<<HTML
<p>In almost every staff room and office I visit, I hear the same sentence, sometimes as a joke and sometimes with real anxiety: “AI is going to replace us all.” And almost always, at the next desk, someone answers with suspicious calm: “Not me. What I do can’t be done by a machine.”</p>
<p>After more than twenty years teaching math and technology in Colombia, and a few years building AI tools for teachers, I think they are both wrong. The first confuses a technology with a destiny. The second confuses habit with safety. This cartoon sums it up better than any report:</p>
<figure><img src="/assets/img/articulos/ia-reemplazo/caricatura-excel-inmortal-800.webp" srcset="/assets/img/articulos/ia-reemplazo/caricatura-excel-inmortal-640.webp 640w, /assets/img/articulos/ia-reemplazo/caricatura-excel-inmortal-800.webp 800w" sizes="(min-width: 760px) 720px, 100vw" alt="Cartoon in Spanish titled AI is going to replace us all… Same worries. Different context. A frightened office worker says AI is going to replace us all; his colleague, in front of a spreadsheet called Presupuesto_FINAL_2017_v4 full of #REF! and #N/D errors and with a sticky note that reads Don’t touch. It works, 2017, replies: Relax, this Excel file is immortal. The footer reads: Technology changes. Human contradictions don’t." width="800" height="800" loading="lazy" decoding="async"><figcaption>“Same worries. Different context.” Cartoon in Spanish by Wanaki Cartoons.</figcaption></figure>
<p>Take a close look: a file called <em>Presupuesto_FINAL_2017_v4</em> (Budget_FINAL_2017_v4), <em>#REF!</em> and <em>#N/D</em> errors in plain sight and a sticky note that says “Don’t touch. It works :) 2017.” That spreadsheet isn’t immortal: it is a process nobody understands, nobody documents and nobody dares to improve. That is the trap. The real risk is not a robot taking the chair; it is that the organization next door, or the colleague at the next desk, rebuilds that process in an afternoon with AI and good judgment while we keep defending the file that “works.”</p>
<p>The footer says it all: <strong>technology changes, human contradictions don’t</strong>. We fear AI and, at the same time, we cling to what we know. In this article I want to get out of that contradiction with data, with critical thinking and with a plan.</p>

<h2>My thesis, plainly</h2>
<p>AI on its own rarely replaces a whole professional. What it does is change the price of many of their tasks. When drafting a report, summarizing a regulation or designing a test takes minutes instead of hours, value moves toward what the machine doesn’t do well: deciding what is worth doing, verifying, adding context, taking responsibility for the result and dealing with people.</p>
<p>That is why I argue that <strong>those who don’t master AI do face a real risk of being replaced, not by AI, but by people and organizations that use it well</strong>. That replacement rarely arrives as a dramatic layoff. It arrives as a job opening that never happens, a contract that goes to someone else, a nearby school that answers families faster or a firm that delivers in three days what used to take three weeks.</p>
<p>A thesis like this can turn into a sales pitch if it isn’t examined rigorously. So let’s look at the data, including the data that contradicts it.</p>

<h2>What the data says (and what it doesn’t)</h2>
<p>The first important distinction is between <strong>exposure</strong> and <strong>replacement</strong>. A job “exposed” to AI is one where part of the tasks can be done or sped up with it, not one that is about to disappear. With that caveat, these are the figures I consider most solid:</p>
<table>
<thead><tr><th>Source</th><th>What it measures</th><th>Figure</th></tr></thead>
<tbody>
<tr><td>{$ext('https://www.imf.org/en/Publications/Staff-Discussion-Notes/Issues/2024/01/14/Gen-AI-Artificial-Intelligence-and-the-Future-of-Work-542379', 'IMF, SDN/2024/001')} (January 2024)</td><td>Employment exposed to AI</td><td>Almost 40% worldwide; 60% in advanced economies, 40% in emerging markets and 26% in low-income countries</td></tr>
<tr><td>{$ext('https://www.ilo.org/publications/generative-ai-and-jobs-refined-global-index-occupational-exposure', 'ILO, Working Paper 140')} (May 2025)</td><td>Occupational exposure to generative AI</td><td>1 in 4 workers with some exposure; 3.3% in the highest category; 34% in high-income countries versus 11% in low-income ones</td></tr>
<tr><td>{$ext('https://www.ilo.org/node/664436', 'ILO and World Bank, Working Paper 121')} (July 2024)</td><td>Latin America and the Caribbean</td><td>26% to 38% of jobs exposed; only 2% to 5% at risk of full automation; 17 million jobs held back by the digital divide</td></tr>
<tr><td>{$ext('https://www.weforum.org/publications/the-future-of-jobs-report-2025/', 'World Economic Forum, Future of Jobs 2025')}</td><td>Jobs and skills to 2030</td><td>170 million jobs created and 92 million displaced; 39% of current skills will change</td></tr>
<tr><td>{$ext('https://www.microsoft.com/en-us/worklab/work-trend-index/ai-at-work-is-here-now-comes-the-hard-part', 'Microsoft and LinkedIn, Work Trend Index 2024')}</td><td>Use and hiring</td><td>75% of knowledge workers use AI; 66% of leaders wouldn’t hire someone without AI skills; only 39% of users got training from their company</td></tr>
<tr><td>{$ext('https://hai.stanford.edu/ai-index/2025-ai-index-report', 'Stanford, AI Index 2025')}</td><td>Adoption by organizations</td><td>78% of organizations used AI in 2024, up from 55% the year before</td></tr>
<tr><td>{$ext('https://www.icfes.gov.co/wp-content/uploads/2026/08/1.-Nota-Inteligenciaa-artificial-TALIS.pdf', 'Icfes note on TALIS 2024')} (December 2025, in Spanish)</td><td>Teachers in Colombia</td><td>53% used AI in their teaching in the past year, versus an OECD average of 36%</td></tr>
</tbody>
</table>
{$img('ia-reemplazo-exposicion', 573, 'Bar chart: the IMF estimates that 60 percent of employment is exposed to AI in advanced economies, almost 40 percent worldwide, 40 in emerging markets and 26 in low-income countries. On the right, for Latin America and the Caribbean: 26 to 38 out of every 100 jobs exposed, 8 to 14 with productivity-enhancing transformation and 2 to 5 at risk of full automation; 17 million jobs held back by the digital divide', 'Exposure is not replacement: in Latin America, full automation affects a small share of exposed jobs.')}
<p>Look at the right side of the chart: in our region, out of every 100 jobs, between 2 and 5 could be fully automated, but between 8 and 14 could be transformed to gain productivity. The ILO itself concludes that job transformation is the most likely effect. And the Microsoft and LinkedIn figure completes the picture: 71% of leaders said they would rather hire a less experienced candidate with AI skills than a more experienced one without them. Replacement, when it happens, happens between people.</p>

<h2>Hype versus evidence</h2>
<p>Being rigorous means admitting there is no “jobs apocalypse” today. An analysis by the {$ext('https://budgetlab.yale.edu/research/evaluating-impact-ai-labor-market-current-state-affairs', 'Yale Budget Lab')} (October 2025) found no discernible disruption of the US labor market since ChatGPT arrived: the occupational mix is changing somewhat faster than before, but that trend started before generative AI.</p>
<p>There is, however, a signal worth taking seriously. The study {$ext('https://digitaleconomy.stanford.edu/publication/canaries-in-the-coal-mine-six-facts-about-the-recent-employment-effects-of-artificial-intelligence/', '“Canaries in the Coal Mine?” by Brynjolfsson, Chandar and Chen')}, in its August 2026 revision, finds that employment of workers aged 22 to 25 in highly exposed occupations is 19% below where it would be had it kept pace with less-exposed peers, while employment of experienced workers holds steady. The authors present it as an early indicator, not definitive causal proof. But it supports my thesis: the first blow is not the veteran’s layoff, it is the door that doesn’t open for the beginner.</p>

<h3>The jagged frontier</h3>
<p>Experimental evidence is even more revealing, because it shows AI doesn’t always help.</p>
{$img('ia-reemplazo-frontera', 623, 'Diverging bar chart: consultants using AI on tasks inside the frontier improve quality by 40 percent and speed by 25 percent; novice support agents resolve 34 percent more issues per hour and the average agent 14 percent; on a task outside the frontier consultants with AI are 19 points less likely to be correct, and expert developers on their own code take 19 percent longer', 'The same technology improves or worsens work depending on the task and on who verifies.')}
<ul>
<li>In an experiment with 758 BCG consultants, {$ext('https://www.hbs.edu/faculty/Pages/item.aspx?num=64700', 'Dell’Acqua and co-authors')} found that, on tasks within AI’s capabilities, those using it completed 12.2% more tasks, 25.1% faster and with 40% higher quality. On a task designed to fall outside that frontier, however, they were 19 percentage points less likely to reach the correct solution.</li>
<li>In a support center with 5,179 agents, {$ext('https://www.nber.org/papers/w31161', 'Brynjolfsson, Li and Raymond')} measured a 14% increase in issues resolved per hour, rising to 34% for novice agents and minimal for the most experienced ones.</li>
<li>In a randomized trial by {$ext('https://metr.org/blog/2025-07-10-early-2025-ai-experienced-os-dev-study/', 'METR')} (July 2025), experienced developers working on their own projects took 19% longer with AI, even though they believed they had been about 20% faster.</li>
</ul>
<p>The conclusion is neither “AI works” nor “AI doesn’t work.” It is more uncomfortable: <strong>AI performs according to the task and to the judgment of the person using it</strong>, and our sense of how much it helps can be badly off. That is precisely the difference between using it and mastering it.</p>

<h2>What AI does badly (and why that strengthens the thesis)</h2>
<p>Every limitation of AI makes the person who knows how to use it more valuable. These are the ones that worry me most:</p>
<ul>
<li><strong>It makes things up with confidence.</strong> In {$ext('https://www.lawnext.com/2023/06/court-imposes-sanctions-on-lawyers-who-filed-bogus-cases-after-relying-on-chatgpt-for-legal-research.html', 'Mata v. Avianca')} (2023), a New York judge fined two lawyers USD 5,000 for citing nonexistent rulings generated by ChatGPT. Even specialized legal tools aren’t immune: a {$ext('https://hai.stanford.edu/news/ai-trial-legal-models-hallucinate-1-out-6-or-more-benchmarking-queries', 'Stanford study')} found incorrect answers in more than 17% of queries for some and more than 34% for another. In Colombia, the Constitutional Court, in {$ext('https://www.corteconstitucional.gov.co/relatoria/2024/T-323-24.htm', 'ruling T-323 of 2024')} (in Spanish), accepted that a judge used ChatGPT after having made his decision, but made it clear that AI cannot replace the reasoning of the person who decides.</li>
<li><strong>It reproduces bias.</strong> Amazon scrapped a recruiting tool that penalized résumés containing the word “women’s,” as in “women’s chess club captain,” according to {$ext('https://www.reuters.com/article/us-amazon-com-jobs-automation-insight-idUSKCN1MK08G', 'Reuters')}. If the past discriminated, a model trained on the past tends to repeat it.</li>
<li><strong>It exposes data.</strong> In 2023, {$ext('https://www.bloomberg.com/news/articles/2023-05-02/samsung-bans-chatgpt-and-other-generative-ai-use-by-staff-after-leak', 'Samsung restricted generative AI')} after an engineer uploaded confidential code to ChatGPT. In a school, the equivalent is pasting a student’s diagnosis with their name into a chat, which clashes with Colombia’s data protection law, {$ext('https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=49981', 'Law 1581 of 2012')} (in Spanish).</li>
<li><strong>It can deskill us.</strong> In a study published in <em>The Lancet Gastroenterology &amp; Hepatology</em>, the {$ext('https://wrap.warwick.ac.uk/id/eprint/191005', 'adenoma detection rate')} of endoscopists working without AI fell from 28.4% to 22.4% after they got used to it. And a Microsoft Research and Carnegie Mellon survey of 319 knowledge workers ({$ext('https://www.microsoft.com/en-us/research/?p=1135061', 'CHI 2025')}) found that higher confidence in AI is associated with less critical thinking.</li>
<li><strong>It doesn’t reach everyone equally.</strong> According to {$ext('https://www.dane.gov.co/files/operaciones/ECV/cp-ECV-2025.pdf', 'DANE')} (in Spanish), in 2025 73.9% of Colombian households had internet, but in villages and scattered rural areas the figure was 56.9%. And 76% of Colombian teachers say their school lacks the infrastructure to use AI, versus 37% in the OECD, according to Icfes.</li>
<li><strong>It consumes energy.</strong> The {$ext('https://www.iea.org/reports/energy-and-ai/executive-summary', 'International Energy Agency')} projects data-center electricity use rising from about 415 TWh in 2024 to around 945 TWh in 2030, driven mainly by AI.</li>
<li><strong>It can make work more precarious.</strong> The IMF warns that, in advanced economies, in half of the exposed jobs AI could take over key tasks and push down wages and hiring. In a region where informality affects almost half of workers (47% according to the {$ext('https://researchrepository.ilo.org/esploro/outputs/report/995682961202676', 'ILO’s Panorama Laboral 2025')}, in Spanish; 54.6% in Colombia between May and July 2026, according to {$ext('https://www.dane.gov.co/files/operaciones/GEIH/bol-GEIHEISS-may-jul2026.pdf', 'DANE')}), the risk is not only losing a job: it is being left out of the gains.</li>
</ul>

<h2>Where the replacement narrative goes too far</h2>
<p>A job is not a task: it is a bundle of tasks, relationships and responsibilities. AI can draft the school climate report, but it can’t sit down with a distressed mother. It can propose a bank reconciliation, but it doesn’t sign the financial statements or answer to the tax authority. It can suggest a differential diagnosis, but it doesn’t examine the patient or carry the decision.</p>
<p>Besides, many projections start from what AI <em>could</em> do in a demo, not from what it does in a company with messy data, unreliable connections and processes like the immortal spreadsheet. Exaggeration paralyzes some people and sells smoke to others.</p>
<p>But complacency has a cost too. The fact that AI won’t replace you doesn’t mean your current way of working will survive intact.</p>

<h2>What mastering AI really means</h2>
<p>Mastering AI isn’t knowing fifty apps or collecting prompts. In 2024 UNESCO published {$ext('https://www.unesco.org/en/articles/ai-competency-framework-teachers', 'an AI competency framework for teachers')} (15 competencies in five dimensions) and {$ext('https://www.unesco.org/en/articles/ai-competency-framework-students', 'another for students')} (12 competencies), and in both a human-centred mindset and ethics weigh as much as technique. In Europe, the {$ext('https://eur-lex.europa.eu/eli/reg/2024/1689/oj', 'AI Act')} made AI literacy an obligation for organizations that use AI from February 2025. Drawing on those frameworks and my own experience, I propose seven competencies:</p>
{$img('ia-reemplazo-competencias', 636, 'Seven cards with the competencies for mastering AI: domain judgment, verification, framing, data literacy, ethics and privacy, process redesign and continuous learning, each with a control question; an eighth card lists what mastering AI is not: knowing 50 tools by heart, copying prompts you don’t understand, outsourcing your judgment and using it for everything', 'Seven competencies for mastering AI, each with the question worth asking before using a result.')}
<ol>
<li><strong>Domain judgment.</strong> Only someone who knows their field better than the machine can spot the error. That is why AI amplifies expertise rather than replacing it.</li>
<li><strong>Verification.</strong> Checking figures, quotes, regulations and calculations against primary sources before using any result.</li>
<li><strong>Framing.</strong> Writing a good instruction means thinking through the problem: context, task, format, constraints and a checking step. A prompt is a way of thinking, not a trick.</li>
<li><strong>Data literacy.</strong> Understanding where numbers come from, what they represent, what is missing and what biases they carry.</li>
<li><strong>Ethics and privacy.</strong> Knowing what information never goes into a chat, when AI use must be disclosed and who answers for each decision.</li>
<li><strong>Process redesign.</strong> It isn’t about doing the same thing faster, but about asking which steps are no longer needed. It is the competency the owner of the immortal spreadsheet lacks.</li>
<li><strong>Continuous learning.</strong> Testing, measuring the real time saved, adjusting and, sometimes, deciding that AI isn’t worth it.</li>
</ol>

<h2>Teachers: what changes in the classroom</h2>
<p>Colombian teachers aren’t starting from zero. According to the Icfes note on TALIS 2024, among those who use AI, 80% use it to generate lesson plans or activities and 60% to support students with special educational needs. But 65% say they lack the knowledge to teach with it and 78% ask for training. That is the point: the difference isn’t between those who use it and those who don’t, but between those who use it with method and those who use it in a rush.</p>
<p><strong>Planning.</strong> Before: a whole afternoon adapting last year’s worksheet. With AI used badly: a generic worksheet with another country’s contexts and references to curriculum standards that don’t exist. With AI and judgment: a sequence built on your grade, your resources and your curriculum, which you review in twenty minutes. That is why I put together the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a>, with tested recipes by subject aligned with the Colombian curriculum; it doesn’t replace your review, it makes it faster.</p>
<p><strong>Assessment.</strong> A teacher who masters AI doesn’t ask for “a fractions test”: they define the evidence of learning they need, check every key and adjust the difficulty. That principle guides the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> (in Spanish), which builds versions, answer sheets and a teacher’s key; before paying you can try the <a href="/examenes/demo/">free simulator</a> (in Spanish).</p>
<p><strong>Inclusion.</strong> A PIAR (Colombia’s individual plan of reasonable adjustments) can’t be improvised with a generic chat, and a child’s sensitive data shouldn’t be pasted into one. AI can propose reasonable adjustments from a well-done pedagogical assessment, but the judgment and the signed record belong to the teaching team. With that logic I built <a href="/herramientas/piar/">PIAR with AI</a> (in Spanish), which lets you try one PIAR free before deciding.</p>
<p><strong>Feedback and paperwork.</strong> AI can turn your quick notes into clear comments for each student or a readable letter to families. What it doesn’t know is that Juan is coming off a hard week. You add that.</p>

<h2>School leaders: govern before you ban</h2>
<p>Principals and coordinators face a different question: not “should I use AI?” but “how do I govern it in my school?” Today, in many schools, teachers already use it with personal accounts and no rules, like the 78% of AI users at work who, according to Microsoft and LinkedIn, bring their own tools.</p>
<ul>
<li><strong>Institutional policy.</strong> Before: silence or a ban. With judgment: a short agreement, discussed with the academic council, on permitted uses, data that is never shared and how AI use is disclosed to students and families.</li>
<li><strong>School plan and code of conduct.</strong> Bring AI into the curriculum across subjects and update the code of conduct for new problems, such as fake images of classmates or assignments copied without understanding.</li>
<li><strong>Data.</strong> Use AI to read national test results or internal performance data and to formulate questions, not to label students. A leader with data literacy asks what is missing from that table before making decisions with it.</li>
<li><strong>Communication.</strong> Clearer letters, timely answers to families and better-written minutes, always reviewed by a person.</li>
<li><strong>Governance and privacy.</strong> Knowing which tools teachers use, where student data ends up and which contracts are signed. Minors’ data deserves the utmost care.</li>
</ul>

<h2>Professionals in other fields: before and after</h2>
<p>I think of an accountant at a small business in Barranquilla. Before, month-end closing was a week of matching statements, chasing receipts and sending collection emails one by one. Her colleague who masters AI automates the sending, uses AI to explain variances and draft the report for management, and spends the time saved on the analysis the client actually values. The client won’t compare the accountant with AI, but with her colleague.</p>
<table>
<thead><tr><th>Profession</th><th>What AI speeds up</th><th>What can’t be delegated</th></tr></thead>
<tbody>
<tr><td>Accounting</td><td>Reconciliations, draft reports, explaining variances</td><td>Signature, professional judgment and accountability to the tax authority</td></tr>
<tr><td>Law</td><td>First drafts, case-file summaries, initial research</td><td>Checking every citation and rule; strategy and argument</td></tr>
<tr><td>Health administration</td><td>Scheduling, answers to patients, claims analysis</td><td>Privacy of medical records and decisions about patients</td></tr>
<tr><td>Engineering</td><td>Documentation, code review, preliminary calculations</td><td>Technical validation, safety standards and sign-off</td></tr>
<tr><td>Marketing</td><td>Content variants, segmentation, comment analysis</td><td>Strategy, advertising ethics and brand voice</td></tr>
<tr><td>Public sector</td><td>Replies to citizen requests, regulatory summaries, reports</td><td>Due process, transparency and data protection</td></tr>
<tr><td>Small business</td><td>Quotes, inventory, chat support</td><td>Customer relationships and business decisions</td></tr>
</tbody>
</table>
<p>A critical note, because it hits close to home: not everything that looks like AI is AI. Many office tasks don’t need a language model, but a well-built, predictable and auditable automation. If every month you send dozens of personalized emails with attachments or produce certificates one by one, a template to <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">send bulk emails from Excel</a> or to <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">run a mail merge into individual PDFs</a> solves the problem without inventing anything. The <a href="/excel/">Excel and automation</a> section has more examples. Mastering AI also means knowing when you don’t need it.</p>

<h2>Latin America: disadvantage and opportunity</h2>
<p>Our region has reasons to worry and reasons to be excited. The worries: high informality, uneven connectivity, models trained mostly in English that don’t always understand our regulations or our varieties of Spanish, and institutions with little capacity to evaluate and buy technology. The ILO and World Bank study puts a number on it: half of the jobs that could gain productivity with AI are held back by the digital divide.</p>
<p>The opportunities are concrete too. In February 2025 Colombia approved {$ext('https://www.dnp.gov.co/publicaciones/Planeacion/Paginas/conpes-4144-hoja-de-ruta-colombia-inteligencia-artificial-retos-actuales-transformacion-futura.aspx?ID=291', 'CONPES 4144')} (in Spanish), its national AI policy, with about 479 billion pesos through 2030 and a pillar devoted to talent. In the {$ext('https://mintic.gov.co/portal/inicio/Sala-de-prensa/Noticias/416782:Colombia-asciende-al-cuarto-lugar-en-el-Indice-Latinoamericano-de-Inteligencia-Artificial-de-la-CEPAL', 'Latin American AI Index 2025')} (in Spanish) by ECLAC and CENIA, the country rose to fourth place out of 19, with 55.84 points. And our teachers use AI more than the OECD average. The opportunity is that a small business in Montería or a school in Sincelejo can access capabilities that only large companies had five years ago; the risk is that only those who were already connected take advantage of it.</p>

<h2>A 30-day plan</h2>
<p>Nobody masters AI by reading articles. This is a short route, with at least one hour a week.</p>
<h3>For teachers</h3>
<ol>
<li><strong>Week 1:</strong> pick a single task that eats your time, such as a worksheet or a rubric, and measure how long it takes you today.</li>
<li><strong>Week 2:</strong> do it with AI using context, format and constraints; check every fact and write down the errors you find.</li>
<li><strong>Week 3:</strong> write your own privacy rule: what you never paste into a chat (names, diagnoses, documents).</li>
<li><strong>Week 4:</strong> compare the real time saved, share what you learned with your department and decide what to keep and what to drop.</li>
</ol>
<h3>For school leaders</h3>
<ol>
<li><strong>Week 1:</strong> run an anonymous survey on which tools teachers already use and for what.</li>
<li><strong>Week 2:</strong> draft a one-page use agreement with the academic council: permitted uses, protected data and transparency.</li>
<li><strong>Week 3:</strong> choose one institutional process, such as letters or minutes, and test it with AI and human review.</li>
<li><strong>Week 4:</strong> present the results to the governing board and set a teacher training line for the semester.</li>
</ol>
<h3>For professionals in other fields</h3>
<ol>
<li><strong>Week 1:</strong> list your repetitive tasks and mark which need judgment and which only need rules.</li>
<li><strong>Week 2:</strong> automate one fixed-rule task and test AI on a writing or analysis task.</li>
<li><strong>Week 3:</strong> create a checklist for your field: figures, citations, regulations and sensitive data.</li>
<li><strong>Week 4:</strong> document your new workflow so someone else can follow it. Don’t let it become another immortal spreadsheet.</li>
</ol>

<h2>Conclusion</h2>
<p>Back to the cartoon. The one who is afraid and the one who is complacent share something: neither is learning. AI won’t replace the good teacher, the good accountant or the good engineer, but it will expose those who can’t verify, can’t frame a problem and defend a process only because “it works.” Technology changes; let’s not let our contradictions leave us behind.</p>

<p class="notice"><strong>Tools to start with judgment.</strong> If you teach, the <strong>AI Kit for Teachers</strong> brings tested recipes by subject, aligned with the Colombian curriculum, for 60,000 Colombian pesos (USD 15) per subject; <strong>PIAR with AI</strong> lets you try one PIAR free and then choose packages of 5, 10 or 20 plans for 30,000, 50,000 or 80,000 pesos (USD 7.50, 12.50 or 20); and the <strong>AI Exam Generator</strong> has a free simulator and plans from 29,900 pesos (USD 9.50). Those three tools work in Spanish. If you work in an office, the <a href="/excel/">Excel and automation</a> templates handle repetitive tasks without depending on AI. None of them replaces your judgment: they are built so you can spend it where it matters.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">See the AI Kit for Teachers</a></p>

<h2>A question to close</h2>
<p>For centuries, a professional’s expertise was built by doing the most basic tasks thousands of times: the accountant who balanced books by hand, the lawyer who read entire case files, the teacher who marked notebook after notebook. Today those are exactly the tasks AI does first and, as the data shows, beginners feel the first blow. <strong>If AI takes away the repetitive work through which judgment used to be formed, how will we form the judgment of those who come after us, which is precisely what AI can’t replace?</strong></p>
HTML,
    ],
];
