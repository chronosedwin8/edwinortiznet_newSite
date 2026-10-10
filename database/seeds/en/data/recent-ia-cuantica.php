<?php

declare(strict_types=1);

// English version of «Inteligencia artificial cuántica: entre la revolución tecnológica y las promesas…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-cuantica/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$code = static fn (string $html): string => (string) preg_replace_callback(
    '#<pre><code>(.*?)</code></pre>#s',
    static fn (array $m): string => '<pre><code>' . htmlspecialchars($m[1], ENT_NOQUOTES, 'UTF-8') . '</code></pre>',
    $html
);

$html = <<<'HTML'
<p>What would a quantum technology have to prove to be better than the artificial intelligence that already works, today, on conventional computers? The question seems simple and is the most important one in the whole debate. The union of AI and quantum computing is much discussed because both promise to solve problems that today take too much time or energy, and because there is real scientific motivation: certain problems in physics and chemistry are, by their very nature, quantum. But <strong>scientific potential is one thing and demonstrated superiority another</strong>: to date there is no general advantage of quantum methods for the usual AI tasks.</p>
<p>This article separates three levels that tend to get mixed: <strong>expectations</strong> (what is promised), <strong>results</strong> (what has been measured, and under what conditions) and <strong>practical applications</strong> (what is already in use). It includes an <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">Excel workbook</a> (in Spanish) to audit claims with a five-level evidence framework (with six fictional claims, verified in Microsoft Excel 16) and a list of sources I consulted and checked on <strong>October 10, 2026</strong>. If you need the basics of quantum computing, I explain them with dice and coins in <a href="/computacion-cuantica-para-que-sirve-como-cambiara-el-mundo/">quantum computing: what it is for and how it could change the world</a> (in Spanish).</p>
<p class="notice"><strong>How to read this article.</strong> Each result is labeled <em>theoretical</em>, <em>simulated</em>, <em>experimental on hardware</em>, <em>validated in an applied setting</em> or <em>commercially deployed</em>, because they are not the same. Company claims are identified as such. The workbook's data are fictional. This is not investment advice.</p>

<h2>What is quantum artificial intelligence?</h2>
<p>The expression is ambiguous: it is used for three different lines of work.</p>
{{img:lineas}}
<ol>
<li><strong>Quantum machine learning (QML):</strong> using quantum circuits and processors to perform or improve machine learning tasks, including <em>hybrid</em> models, in which part of the workflow runs on a classical system and part on a quantum processor.</li>
<li><strong>AI applied to science and quantum systems:</strong> using conventional AI to design experiments, calibrate processors, analyze measurements or <em>correct errors</em>. An example: <strong>AlphaQubit</strong>, from Google DeepMind and Google Quantum AI (Bausch and colleagues, <em>Nature</em>, November 2024), a neural network that learns to decode the errors of a quantum processor. The AI runs on classical hardware; the quantum part is its object of study.</li>
<li><strong>Classical quantum-inspired algorithms:</strong> they run on ordinary computers; only their ideas come from quantum methods. They are not quantum computing, and confusing them is a frequent source of misleading headlines.</li>
</ol>
<p>This article focuses on the first line and mentions the other two where relevant. QML is <strong>not</strong> "a more powerful AI" nor a synonym for any application that mentions quantum physics.</p>

<h2>The minimum quantum concepts (without turning it into a treatise)</h2>
<ul>
<li><strong>Qubit:</strong> the unit of quantum information. Unlike a bit, which is 0 or 1, a qubit can be in a combination of both states. The U.S. National Institute of Standards and Technology (NIST) explains that each additional qubit doubles the number of possible combinations.</li>
<li><strong>Superposition:</strong> a state described as a combination of basis states, with "amplitudes". <strong>It does not equal reading all answers at once</strong>: it is the most repeated and most misleading image.</li>
<li><strong>Entanglement:</strong> correlations between qubits that cannot be described as if each were independent.</li>
<li><strong>Interference:</strong> amplitudes combine and can reinforce or cancel the probability of certain outcomes. Useful quantum algorithms arrange interference so that correct answers are reinforced.</li>
<li><strong>Measurement:</strong> converts the quantum state into a classical result, probabilistically. One measurement does not recover all the information in the superposition.</li>
<li><strong>Noise and decoherence:</strong> the environment degrades states and operations. According to NIST (page consulted on October 10, 2026), the best current machines make on the order of one error per thousand operations, versus one per quintillion in a classical computer, and, per the same page, most applications are years or decades away.</li>
</ul>
<p>A useful analogy, with its limits: a qubit is less like a switch than like a wave whose shape can be combined with others; but measuring it "collapses" the wave into a 0 or a 1.</p>

<h2>How a quantum machine learning model works</h2>
<p>The typical flow of a hybrid model is this:</p>
<ol>
<li><strong>Data are selected and prepared</strong> (classical, almost always).</li>
<li><strong>They are encoded</strong> into a quantum state or circuit. It is a costly and delicate step.</li>
<li>A <strong>parametrized quantum circuit</strong> (a set of operations with adjustable parameters) transforms the state.</li>
<li><strong>The system is measured,</strong> many times, to estimate probabilities; the result is classical.</li>
<li>A <strong>classical optimizer</strong> adjusts the parameters and the cycle repeats.</li>
<li><strong>The model is evaluated</strong> on test data and against classical baselines.</li>
</ol>
<p>There are several families: <em>variational algorithms</em> (the cycle above), <em>quantum kernel methods</em> (using the quantum processor to compute a similarity measure between data, which then feeds a classical classifier) and generative models. In all of them, total cost includes data preparation, repeated measurements, noise and communication between processors, not just circuit time.</p>

<h2>Differences from classical AI</h2>
<table>
<thead><tr><th>Aspect</th><th>Classical AI</th><th>Quantum machine learning</th></tr></thead>
<tbody>
<tr><td>Infrastructure</td><td>CPUs, GPUs and other conventional accelerators</td><td>Simulators, quantum processors and hybrid systems</td></tr>
<tr><td>Maturity</td><td>Broad ecosystem and many productive applications</td><td>Emerging field; practical usefulness limited to specific cases</td></tr>
<tr><td>Data</td><td>Direct processing in classical representations</td><td>May require encoding classical data into quantum states</td></tr>
<tr><td>Evaluation</td><td>Mature methods and baselines in many domains</td><td>Requires rigorous controls and competitive classical comparisons</td></tr>
<tr><td>General advantage</td><td>Known performance depending on the task</td><td>No demonstrated general advantage across all AI tasks</td></tr>
</tbody></table>
<p>The table describes tendencies, not rules without exceptions, and comparing a laboratory quantum algorithm with a deliberately weak classical model is not evidence.</p>

<h2>Applications: potential, demonstrations and usefulness</h2>
<p>For each case I ask the same five questions: what problem it solves, why it would be hard for classical methods, what quantum approach is proposed, what evidence has been published and whether a full, practical advantage over a competitive classical alternative was shown.</p>
<h3>1. Learning from quantum experiments (physics)</h3>
<p><strong>Label: experimental on hardware, in a constructed setting.</strong> Huang and colleagues (<em>Science</em>, June 2022) showed, with Google's Sycamore processor (up to 40 qubits and 1,300 gates), that a machine that learns with quantum memory can need exponentially fewer experiments than a classical machine without it for certain tasks on quantum systems. It is among the few results with a <em>provable</em> separation, but Google itself presents it as a proof of principle, with a state prepared on purpose, and the advantage is in the <em>number of experiments needed</em> to learn about quantum systems, not in ordinary AI tasks. An earlier paper from the same group, "Power of data in quantum machine learning" (<em>Nature Communications</em>, 2021), also showed that data matter: a classical model with access to data can match quantum ones in many cases.</p>
<h3>2. Drug discovery (health and bioinformatics)</h3>
<p><strong>Label: experimental demonstration with laboratory validation; quantum advantage not demonstrated.</strong> A team from the University of Toronto and Insilico Medicine (<em>Nature Biotechnology</em>, January 2025) combined a quantum-classical generative model with the Chemistry42 AI platform to propose molecules against KRAS, a cancer protein considered hard to target. It was trained on 1.1 million molecules, of which 15 candidates went to laboratory tests and two showed activity in cells. But, according to the University of Toronto's own release, the researchers state that the results <strong>do not show that the molecules are more effective than those obtained with classical methods</strong>, and one of the authors, Alán Aspuru-Guzik, says the study "does not provide any sign of significant quantum advantage". It is a proof of concept of using a quantum component in a workflow, not proof that it is better.</p>
<h3>3. Finance</h3>
<p><strong>Label: hardware trial with real data; disputed.</strong> In September 2025, HSBC and IBM announced an improvement "of up to" 34% in predicting whether a European corporate bond trade would be filled at the quoted price, using IBM Heron processors and real trading data, in a trial and not in live operation. It is a <strong>company claim</strong> and it was questioned: computer scientist Scott Aaronson called it a "qombie" (a zombie quantum-advantage claim) and critics pointed out that the improvement was not reproduced in a noiseless simulation, which suggests the effect might come from the particulars of noise or the comparison, and that a classical regularization method might replicate it. The authors and IBM executives clarified that they were not presenting the result as a demonstrated quantum advantage. It is a good example of why the baseline matters.</p>
<h3>4. Recommendation and linear algebra (theory, and a lesson in "dequantization")</h3>
<p><strong>Label: theoretical.</strong> In 2016 a quantum algorithm was proposed for recommendation systems (of the Amazon or Netflix kind) with an exponential speedup. In 2018, Ewin Tang, then an undergraduate, published a <em>classical</em> "quantum-inspired" algorithm that solved the same problem with only a polynomial difference, and later work extended the method to other algorithms (principal component analysis, support vector machines, low-rank regression). It is the most cited case of "dequantization": a supposed exponential advantage vanished once the classical method was thought through better. Another result, by Liu, Arunachalam and Temme (<em>Nature Physics</em>, 2021), proves a rigorous quantum speedup in supervised learning, but for a mathematical problem constructed on purpose (based on the discrete logarithm), not for typical AI data.</p>
<p><strong>The common lesson:</strong> the strongest advantages appear in problems designed with special quantum or mathematical structure; the weakest, in general AI tasks with ordinary data.</p>

<h2>Technical and economic limits</h2>
<ul>
<li><strong>Noise and error correction.</strong> Long, reliable calculations require error correction, which in turn requires many physical qubits per reliable logical qubit; the number of physical qubits is not that of logical qubits. IBM, in its description of "quantum-centric supercomputing" (page published in 2024 and updated in April 2026), lays out a roadmap of 200 logical qubits running one hundred million gates by 2029: it is a <strong>company projection</strong>, not a result, and the page itself acknowledges that full quantum advantage is still being sought.</li>
<li><strong>Data loading.</strong> Encoding classical data into a quantum state can cost so much that it eliminates the theoretical advantage; Scott Aaronson called it "the fine print" of many algorithms (<em>Nature Physics</em>, 2015). Some algorithms depend on a quantum random access memory (QRAM) that does not yet exist in practice.</li>
<li><strong>Training and barren plateaus.</strong> In 2018, McClean and colleagues (<em>Nature Communications</em>) showed that, in deep random circuits, gradients become exponentially small with the number of qubits, making training hard. A paper by Cerezo and colleagues (<em>Nature Communications</em>, 2025) argues that many of the models that avoid these "barren plateaus" can also be efficiently simulated on classical computers, which casts doubt on their advantage; the authors point out caveats and propose using quantum devices to collect data rather than to train.</li>
<li><strong>Weak benchmarks.</strong> Bowles, Ahmed and Schuld (Xanadu, 2024) tested 12 popular QML models on 6 classification tasks, with 160 datasets: on average, out-of-the-box classical models outperformed the quantum classifiers, and removing entanglement often did not worsen (or improved) the result. Earlier, in reviewing 55 papers mentioning "quantum machine learning" and "outperform", about 40% reported outperforming a classical model and only three did not. It is a sign of bias in the literature, not a refutation of the field.</li>
<li><strong>Operating speed.</strong> Gundlach, Kukina, Lynch and Thompson (ICML 2026, position paper) argue that a "quantum leap" would be needed for quantum computers to have a meaningful impact on deep learning over the next decade or two: theoretical improvements in matrix multiplication are lost at practical sizes because each quantum operation is slow, some algorithms depend on an underdeveloped QRAM and others apply only to special cases.</li>
<li><strong>End-to-end cost.</strong> Measuring only circuit time, without preparation, repetitions, transfer, processing and optimization, gives an incomplete comparison.</li>
</ul>
<p>Not all of these are definitive impossibilities: some are current engineering barriers (noise, scale) and others depend on the algorithm, the data and the problem. Recent reviews of the field agree on a similar map: <em>Gokhale, Dhote and Delhibabu</em> (<em>Discover Computing</em>, April 2026) analyze where quantum models have shown advantages and where they lag, and point to state preparation, scalability and evaluation standards as open challenges; <em>Rodríguez-Díaz and colleagues</em> (<em>ACM Computing Surveys</em>, October 2025) review over 135 papers and analyze hardware limitations, error rates and scalability.</p>

<h2>How to assess a claim: five levels of evidence</h2>
{{img:niveles}}
<p>A claim does not deserve the same credit if it is a theoretical idea, a simulation, a hardware demonstration, a comparative advantage or a practical use. The five levels in the figure order that difference: (1) <em>theoretical foundation</em>, (2) <em>simulated result</em>, (3) <em>experimental demonstration</em>, (4) <em>comparative advantage</em> (beats a competitive classical baseline, with costs accounted for) and (5) <em>practical utility</em> (reproducible and valuable in a real setting). And before accepting the expression "demonstrated quantum advantage", you must ask <strong>which advantage</strong>, <strong>for what task</strong>, <strong>against what method</strong> and <strong>under what conditions</strong>.</p>
<p>The <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">Excel workbook</a> turns the framework into an audit: for each claim you record the level the source <em>claims</em> and the level the evidence <em>supports</em>, and eight yes-or-no questions (does it define the advantage?, does it say what method it is compared against?, does it include full costs?, is the baseline strong?, was it run on real hardware?, was it reproduced or are code and data available?, did it pass peer review?, does it disclose the commercial interest?). It calculates the score, the rating (Sólida, Parcial or Débil, i.e. Solid, Partial or Weak) and the <strong>gap</strong> between what is claimed and what is shown.</p>
<pre><code>' Score: how many of the 8 questions are answered yes (E:L)
=COUNTIF(E4:L4,"Sí")                                                             ' English
=CONTAR.SI(E4:L4;"Sí")                                                           ' Spanish

' Rating according to the cut-offs in the Parametros sheet
=IF(M4>=Parametros!$B$3,"Sólida",IF(M4>=Parametros!$B$4,"Parcial","Débil"))      ' English
=SI(M4>=Parametros!$B$3;"Sólida";SI(M4>=Parametros!$B$4;"Parcial";"Débil"))      ' Spanish

' Level gap: what the source claims minus what the evidence supports
=C4-D4</code></pre>
{{img:auditoria}}
<p>With six <strong>fictional</strong> claims, representing frequent patterns (not real studies or companies): 1 solid, 2 partial and 3 weak; an average score of 3.5 out of 8; and <strong>4 with "overpromise"</strong> (they claim a level two or more steps above what the evidence supports), with a maximum gap of 3 levels. Only one meets most of the questions, and it is one that reports a <strong>negative result</strong> (an 8-qubit circuit that falls 2 points below a small classical network) with code, data and full costs. It illustrates a simple idea: <strong>a claim's quality is measured not by how spectacular it is, but by how checkable it is</strong>. Only 2 of 6 use a strong classical baseline, only 1 includes full costs and only 1 is reproduced.</p>
<p><strong>An honest reading:</strong> the workbook does not validate a paper's science; it organizes questions. The scores depend on whoever assigns them, and a wrongly answered "yes" invalidates the audit. Use it as a checklist for careful reading, not as a verdict.</p>

<h2>Implications for business and education</h2>
<p><strong>In business,</strong> the sensible attitude is <em>informed monitoring</em> and, where appropriate, <strong>bounded proofs of concept</strong>, not investments based on advertising. Before adopting a solution, ask: which business indicator should improve?, what is the strongest classical baseline (a good solver, a well-tuned heuristic, a conventional AI model)?, is the full cost of the service and data preparation included?, does the improvement reproduce outside a controlled demonstration?, does the vendor publish methods, metrics and conditions so the claim can be audited? And remember that whoever communicates a result usually has a commercial interest.</p>
<p><strong>In education,</strong> the goal is not to turn a trend into a curricular obligation, but to teach how to <em>evaluate emerging technology</em>: basic quantum literacy, computational thinking, foundations of probability and linear algebra, and experimenting with simulators (several platforms let you run quantum circuits in the cloud or in simulation at no cost). There is no need to promise that students will use quantum computers for ordinary tasks in the short term. For the same critical attitude toward AI in general, see <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">the great lie about AI</a> and <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">the mirage of AI in higher education</a> (both in Spanish).</p>

<h2>Colombia, Latin America and the world</h2>
<p>The map of the quantum world is dominated by the United States, China and Europe, with major state investments and companies that publish roadmaps; in Latin America and Colombia, participation happens mainly through university research, some national initiatives and cloud access to processors and simulators (more detail in <a href="/computacion-cuantica-para-que-sirve-como-cambiara-el-mundo/">the article on quantum computing</a>). For a school, a university or a company in the region, the practical question is not "do we buy a quantum computer?" (it makes no sense) but "what do we need to know so as not to be fooled, and what human capabilities should we build (mathematics, programming, critical thinking) that serve whether or not the technology arrives?".</p>
<p>For <strong>teachers</strong>, it is about teaching to tell science, demonstration and marketing apart; for <strong>principals</strong>, about not investing out of fashion and demanding fair comparisons; for <strong>families</strong>, about distrusting headlines that promise "revolutions" with dates; and for <strong>students</strong>, about understanding that the criterion used to judge this technology (what problem it solves, against what alternative and at what cost) serves to judge any other.</p>

<h2>Tools and templates</h2>
<p>If you want to apply this kind of critical reading to your own AI projects, or prepare class materials with AI help (always reviewing what it produces and without including student data in tools not designed to safeguard it), take a look at these tools of our own.</p>
{{productos:kit-de-ia-para-docentes,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel with artificial intelligence</a>, <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">the claims audit workbook</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Sources consulted (checked on October 10, 2026)</h2>
<p>Reviews offer a map of the field, but they do not replace reading the original study when an advantage is claimed. Source type in parentheses.</p>
<ul>
<li><strong>NIST,</strong> <a href="https://www.nist.gov/quantum-information-science/quantum-computing-explained">"Quantum Computing Explained"</a> (institutional, technical outreach; page created in March 2025 and updated in May 2026).</li>
<li><strong>Gokhale, Dhote and Delhibabu (2026),</strong> <a href="https://link.springer.com/article/10.1007/s10791-026-10085-1">"A review of quantum machine learning algorithms, applications, and emerging advantages"</a>, <em>Discover Computing</em>, April 24, 2026 (review; bibliographic data and abstract checked against the Crossref record).</li>
<li><strong>Gundlach, Kukina, Lynch and Thompson (2026),</strong> <a href="https://proceedings.mlr.press/v306/gundlach26a.html">"Position: Quantum Deep Learning Still Needs a Quantum Leap"</a>, ICML 2026, PMLR 306 (position paper, critical perspective).</li>
<li><strong>Tera, Chinthaginjala, Zhao and Hamdi (2026),</strong> <a href="https://doi.org/10.1016/j.eswa.2026.132127">"Advancing quantum machine learning from conceptual design to practical use"</a>, <em>Expert Systems with Applications</em>, July 2026 (review; I checked the bibliographic data, not the full text).</li>
<li><strong>Rodríguez-Díaz, Gutiérrez-Avilés, Troncoso and Martínez-Álvarez (2025),</strong> <a href="https://doi.org/10.1145/3764582">"A Survey of Quantum Machine Learning: Foundations, Algorithms, Frameworks, Data and Applications"</a>, <em>ACM Computing Surveys</em>, October 2025 (review).</li>
<li><strong>Hong and Lopez (2025),</strong> <a href="https://ieeeaccess.ieee.org/featured-article/a-review-on-quantum-machine-learning-in-applied-systems-and-engineering/">"A Review on Quantum Machine Learning in Applied Systems and Engineering"</a>, <em>IEEE Access</em>, August 2025 (review; application examples must be verified one by one).</li>
<li><strong>IBM,</strong> <a href="https://www.ibm.com/think/topics/quantum-centric-supercomputing">"What is quantum-centric supercomputing?"</a> (company source: describes an architecture and projections, not independent results).</li>
<li><strong>Bowles, Ahmed and Schuld (2024),</strong> <a href="https://arxiv.org/abs/2403.07059">"Better than classical? The subtle art of benchmarking quantum machine learning models"</a>, arXiv:2403.07059 (primary evaluation study).</li>
<li><strong>Huang et al. (2022),</strong> "Quantum advantage in learning from experiments", <em>Science</em> (<a href="https://research.google/blog/quantum-advantage-in-learning-from-experiments/">Google Research explanation</a>), and <strong>Huang et al. (2021),</strong> "Power of data in quantum machine learning", <em>Nature Communications</em> 12.</li>
<li><strong>Cerezo et al. (2025),</strong> "Does provable absence of barren plateaus imply classical simulability?", <em>Nature Communications</em> 16, 7907; <strong>McClean et al. (2018),</strong> "Barren plateaus in quantum neural network training landscapes", <em>Nature Communications</em> 9; <strong>Aaronson (2015),</strong> "Read the fine print", <em>Nature Physics</em> 11, 291-293; <strong>Liu, Arunachalam and Temme (2021),</strong> <em>Nature Physics</em> 17, 1013-1017; <strong>Tang (2018),</strong> "A quantum-inspired classical algorithm for recommendation systems" (arXiv; STOC 2019).</li>
<li><strong>Ghazi Vakili et al. (2025),</strong> "Quantum-computing-enhanced algorithm unveils potential KRAS inhibitors", <em>Nature Biotechnology</em> 43, 1954-1959 (<a href="https://www.utoronto.ca/news/ai-quantum-computing-used-target-undruggable-cancer-protein">University of Toronto release</a>); <strong>HSBC,</strong> <a href="https://www.hsbc.com/news-and-views/news/media-releases/2025/hsbc-demonstrates-worlds-first-known-quantum-enabled-algorithmic-trading-with-ibm">release of September 25, 2025</a> (company source) and <a href="https://scottaaronson.blog/?p=9170">Scott Aaronson's critique</a> (a specialist's opinion); <strong>Bausch et al. (2024),</strong> "Learning high-accuracy error decoding for quantum processors", <em>Nature</em> 635, 834-840 (AlphaQubit).</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>What is quantum artificial intelligence?</h3>
<p>An ambiguous expression that mainly refers to quantum machine learning (using quantum processors in learning tasks), but also to AI applied to quantum systems and classical quantum-inspired algorithms.</p>
<h3>Is quantum AI faster than traditional AI?</h3>
<p>There is no demonstrated general advantage. Research looks at whether certain algorithms bring advantages in specific tasks; the outcome depends on the problem, the comparison and the costs included.</p>
<h3>Is a quantum computer with more qubits always better?</h3>
<p>No. Fidelity, connectivity, error correction, circuit depth and cost also matter, not just the number of qubits.</p>
<h3>Will quantum AI replace GPUs?</h3>
<p>What is being studied is whether quantum systems can complement classical computing in specific workflows; there is no evidence of a general replacement.</p>
<h3>How do I know if a news story about quantum advantage is reliable?</h3>
<p>Ask which advantage, for what task, against what method and under what conditions; look for the original paper, the costs included, the classical baseline and whether another group reproduced it.</p>

<p class="notice"><strong>Audit a claim you have read.</strong> Download the <a href="/descargas/ia-cuantica/auditoria-afirmaciones-ia-cuantica.xlsx">audit workbook</a> (in Spanish), replace the examples with a real news story or paper and answer the eight questions before sharing it.</p>

<h2>Food for thought</h2>
<p>The important question is not whether quantum artificial intelligence sounds more advanced, but <strong>what problem it manages to solve, against what alternative and at what cost</strong>. Evidence, and not the technology label, will determine when a scientific possibility becomes a practical advantage. <strong>What would a new technology have to prove to you before you changed what you do today? And how many of the technological promises you have accepted in recent years would pass that test?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:lineas}}' => $img('ia-cuantica-lineas', 444, 'Table with three lines of work mixed up under the expression quantum artificial intelligence: quantum machine learning, AI for quantum and quantum-inspired algorithms, with where each runs and an example.', 'Not everything "quantum" in AI is the same.'),
    '{{img:niveles}}' => $img('ia-cuantica-niveles', 467, 'Five levels of evidence to assess a claim about quantum AI: theory, simulation, hardware, comparative advantage and practical utility.', 'Five levels of evidence.'),
    '{{img:auditoria}}' => $img('ia-cuantica-auditoria', 524, 'Bar chart of the score, out of 8, of six audited fictional claims: 0, 6, 3, 4, 0 and 8.', 'Audit of six fictional claims.'),
]);

return [
    'inteligencia-artificial-cuantica-aplicaciones-limites' => [
        'slug' => 'quantum-artificial-intelligence-applications-limits',
        'title' => 'Quantum Artificial Intelligence: Between Technological Revolution and Promises Still to Be Proven',
        'excerpt' => 'Quantum artificial intelligence combines research in quantum computing and machine learning. What it is, what has really been shown, its limits and how to assess a claim with five levels of evidence and an Excel workbook.',
        'seo_title' => 'Quantum AI: What It Is, Applications and Limits',
        'seo_description' => 'What quantum artificial intelligence is, how quantum machine learning works, its applications and what remains to be proven for a practical advantage.',
        'focus_keyword' => 'quantum artificial intelligence',
        'cover' => '/assets/img/articulos/ia-cuantica/ia-cuantica-portada-en',
        'cover_alt' => 'Cover "Quantum artificial intelligence: between revolution and promises yet to be proven" with a card: 5 levels of evidence separate a theoretical idea from a demonstrated practical use.',
        'content_html' => $html,
    ],
];
