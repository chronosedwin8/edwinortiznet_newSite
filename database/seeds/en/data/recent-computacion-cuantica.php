<?php

declare(strict_types=1);

// English version of "La computación cuántica: para qué sirve y cómo podría cambiar el mundo". Key is the Spanish slug.
// Nowdoc keeps code literal; <pre><code> blocks are escaped automatically and figures are inserted from {{img:…}}
// markers. Facts checked on October 8, 2026, with linked sources; Python examples tested with NumPy and Qiskit 2.5.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/computacion-cuantica/' . $name . '-en';
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
<p>Every year I run the same experiment in class. I toss a coin and, while it spins, I ask: “Is it heads or tails?” Someone always answers, “Neither, yet.” That answer, which sounds like a joke, is the doorway to one of the most talked-about and worst-explained technologies of this decade: <strong>quantum computing</strong>.</p>
<p>Headlines say quantum computers “solve in minutes what would take millions of years,” that they will cure cancer and break every password. Some of that is true, much is exaggerated, and almost nobody explains why. I will tell it the way I would tell a 15-year-old student: with coins, dice and mazes, and with every fact linked to its source. At the end, for the curious, there is a first quantum program.</p>

<h2>What is quantum computing?</h2>
<p>It is a way of processing information that uses the rules of <strong>quantum physics</strong>, the part of science that describes how atoms, electrons and light behave. At that scale, nature does not work like everyday life: a particle can be in a mix of states, and two particles can stay connected even when they are far apart.</p>
<p>A quantum computer is not a faster ordinary computer. It is a different machine that <strong>uses those rules to solve certain problems</strong>, not all of them, better than a classical computer. To watch a video or do homework, your phone will still be better.</p>

<h2>How it works, explained with coins and dice</h2>
<h3>Bit and qubit: the coin lying still and the coin spinning</h3>
<p>Everything your phone does comes down to <strong>bits</strong>: switches that are 0 or 1, like a coin lying still showing heads or tails. A <strong>qubit</strong> (quantum bit) is more like a spinning coin: it is not just heads or just tails, but a combination of both, leaning a little toward each side. That lean, the <em>amplitude</em>, decides how likely each result is when the coin lands.</p>
{{img:qubit}}
<h3>Superposition: many possibilities at once, with fine print</h3>
<p>That “spinning coin” state is called <strong>superposition</strong>. With one qubit you have two possibilities mixed together; with two, four; with three, eight; with 300 qubits, more combinations than atoms in the observable universe. Hence the famous line “it tries every answer at the same time.” It is a half-truth: if you set all the answers spinning and looked, you would get <em>one</em> at random, almost always a wrong one. The trick comes next.</p>
<h3>Interference: the art of cancelling wrong paths</h3>
<p>Picture a maze traveled by waves, like the ripples from a stone in a pond. Where two crests meet, the wave grows; where a crest meets a trough, they cancel. A quantum algorithm is a choreography designed so that the paths toward wrong answers <strong>cancel out</strong> and the paths toward the right one <strong>reinforce each other</strong>. IBM puts it this way: <a href="https://www.ibm.com/think/topics/quantum-computing" target="_blank" rel="noopener">interference is the engine of quantum computing</a>. That is why many qubits are not enough: you need a problem with the right structure and a clever algorithm.</p>
<h3>Entanglement: two connected dice</h3>
<p>Now imagine two magic dice. You give one to a friend who travels to Leticia, in the Amazon, and keep the other in Barranquilla, on the Caribbean coast. Each one, on its own, lands at random. But when you compare, they always match. That, very simplified, is <strong>entanglement</strong>: two qubits form a single system and their results are correlated. Two caveats: it cannot send messages faster than light, because each of you sees a random result and only discovers the match by comparing; and the dice did not “already know” what they would show. The experiments that proved it won the <a href="https://www.nobelprize.org/prizes/physics/2022/summary/" target="_blank" rel="noopener">2022 Nobel Prize in Physics</a>.</p>
{{img:ideas}}
<h3>Measurement: the coin lands</h3>
<p>When we measure a qubit, the coin stops spinning and lands on 0 or 1. The superposition disappears and we are left with a single result. That is why quantum computers repeat a calculation thousands of times and look at which results come up most, like tossing a coin many times to find out whether it is loaded.</p>
<h3>Decoherence: the coin that falls on its own</h3>
<p>Enemy number one is <strong>decoherence</strong>: any vibration, heat or electrical noise “touches” the coin and makes it fall too early. That is why many quantum computers live inside giant refrigerators. According to IBM, its processors need temperatures <a href="https://www.ibm.com/think/topics/quantum-computing" target="_blank" rel="noopener">about a hundred times colder than one degree above absolute zero</a>, colder than outer space. The best qubits on Google’s Willow chip keep their information for <a href="https://blog.google/technology/research/google-willow-quantum-chip/" target="_blank" rel="noopener">close to 100 microseconds</a>: one ten-thousandth of a second.</p>
<p>A nice fact for class: the 2025 Nobel Prize in Physics went to John Clarke, Michel Devoret and John Martinis for showing, in 1984 and 1985, quantum effects in <a href="https://www.nobelprize.org/prizes/physics/2025/summary/" target="_blank" rel="noopener">an electrical circuit you can hold in your hand</a>. Google’s and IBM’s superconducting qubits grew out of that discovery.</p>

<h2>What is it for? Realistic uses and hype</h2>
<p>It pays to separate what science supports from what sells headlines. Here is my reading, with sources:</p>
<ul>
<li><strong>Chemistry and medicine (the most promising).</strong> Molecules obey quantum laws, so simulating them on a quantum machine is natural. A 2017 study showed that an error-corrected quantum computer could study the enzyme that fixes nitrogen from the air, key to <a href="https://doi.org/10.1073/pnas.1619152114" target="_blank" rel="noopener">making fertilizer with less energy</a>, something no supercomputer can do accurately. In 2025, Google used its <em>Quantum Echoes</em> algorithm to study <a href="https://blog.google/technology/research/quantum-echoes-willow-verifiable-quantum-advantage/" target="_blank" rel="noopener">two molecules with 15 and 28 atoms</a>, with results that matched nuclear magnetic resonance. It is a first step, not a medicine.</li>
<li><strong>Materials and batteries.</strong> For the same reason, it could help design batteries and catalysts. BMW is researching <a href="https://www.quantinuum.com/press-releases/quantinuum-announces-commercial-launch-of-new-helios-quantum-computer-that-offers-unprecedented-accuracy-to-enable-generative-quantum-ai-genqai" target="_blank" rel="noopener">fuel cell catalysts</a> on Quantinuum’s Helios machine. It is research, not a product.</li>
<li><strong>Logistics and optimization.</strong> Choosing the best route for 50 trucks looks ideal for “trying everything at once,” but there is no proof of a large advantage. John Preskill, the physicist who named this stage the <a href="https://quantum-journal.org/papers/q-2018-08-06-79/" target="_blank" rel="noopener">NISQ era (noisy intermediate-scale quantum)</a>, warns that it is unknown whether these machines will beat the best classical methods at optimization.</li>
<li><strong>Finance.</strong> JPMorganChase is exploring <a href="https://www.quantinuum.com/press-releases/quantinuum-announces-commercial-launch-of-new-helios-quantum-computer-that-offers-unprecedented-accuracy-to-enable-generative-quantum-ai-genqai" target="_blank" rel="noopener">advanced financial analytics</a> on Helios. One concrete result: in 2025, with Quantinuum, it generated <a href="https://www.nature.com/articles/s41586-025-08737-1" target="_blank" rel="noopener">certified random numbers</a>, useful for security and lotteries. “Predicting the stock market” is pure fantasy.</li>
<li><strong>Cryptography (the real threat).</strong> In 1994, Peter Shor showed that a large quantum computer could break the RSA encryption that protects banks and email. In 2025, Google’s Craig Gidney estimated that it would take a machine with <a href="https://arxiv.org/abs/2505.15917" target="_blank" rel="noopener">fewer than a million noisy qubits running for less than a week</a>. No machine is close today, but the figure is twenty times smaller than his 2019 estimate.</li>
<li><strong>Artificial intelligence.</strong> There is a lot of talk about “quantum AI,” but quantum machine learning algorithms often come with <a href="https://www.nature.com/articles/nphys3272" target="_blank" rel="noopener">fine print</a>, as computer scientist Scott Aaronson warned: loading millions of data points into qubits is slow and can wipe out the advantage. For now, AI helps quantum more than the other way around.</li>
<li><strong>Climate.</strong> Climate models handle huge amounts of data, exactly where classical supercomputers shine. The possible contribution is indirect: better catalysts, fertilizers or materials to capture carbon.</li>
</ul>
{{img:puede}}

<h2>Advantages</h2>
<ul>
<li><strong>Speed on specific problems.</strong> On tasks designed to show its power, the gap is enormous: Willow did in under five minutes a calculation that, according to Google, would take a supercomputer <a href="https://blog.google/technology/research/google-willow-quantum-chip/" target="_blank" rel="noopener">10 septillion years</a> (10<sup>25</sup>). Google itself notes that this task has no practical use.</li>
<li><strong>It simulates nature “in its own language.”</strong> Molecules and materials are quantum systems.</li>
<li><strong>Verifiable results.</strong> Quantum Echoes ran <a href="https://blog.google/technology/research/quantum-echoes-willow-verifiable-quantum-advantage/" target="_blank" rel="noopener">13,000 times faster</a> than the best classical algorithm on a supercomputer, and another quantum computer can repeat it to check.</li>
</ul>

<h2>Disadvantages</h2>
<ul>
<li><strong>They make many mistakes.</strong> On the best commercial machines, an operation between two qubits fails about once every 1,000 to 10,000 times: IonQ reported a record <a href="https://investors.ionq.com/news/news-details/2025/IonQ-Achieves-Landmark-Result-Setting-New-World-Record-in-Quantum-Computing-Performance/default.aspx" target="_blank" rel="noopener">99.99% fidelity</a> in October 2025.</li>
<li><strong>They are fragile.</strong> They need extreme cold, vacuum or precision lasers.</li>
<li><strong>They are not useful for much, yet.</strong> They do not run WhatsApp or Excel, only very particular problems.</li>
<li><strong>They are expensive and scarce.</strong> Almost all of us use them over the internet, with limited minutes.</li>
</ul>

<h2>Problems ahead</h2>
<ol>
<li><strong>Errors and noise.</strong> A useful calculation, such as the enzyme or the encryption one, requires billions of operations without failing. We are far from that.</li>
<li><strong>Extreme cold and energy.</strong> Scaling up means bigger refrigerators, more cables and more power.</li>
<li><strong>Scalability.</strong> Going from a hundred qubits to a million is not “making more”: every qubit brings more noise and more wiring.</li>
<li><strong>Cost.</strong> The quantum computer that Colombia’s Unidad Central del Valle del Cauca (UCEVA) put into operation in Tuluá cost about <a href="https://www.mineducacion.gov.co/1780/w3-article-427345.html" target="_blank" rel="noopener">450 million pesos</a>; cutting-edge research machines such as Google’s or IBM’s are projects of a very different scale.</li>
<li><strong>Security: “harvest now, decrypt later.”</strong> Someone can copy encrypted data today (medical records, state secrets) and store it until they have a machine able to open it. If a piece of data must stay secret for twenty years, the problem has already begun.</li>
<li><strong>Technological inequality.</strong> Only a few countries and companies can build these machines. Who will get the advantage first?</li>
</ol>

<h2>Solutions on the way</h2>
<ul>
<li><strong>Error correction and logical qubits.</strong> It works like a group of friends who vote: several physical qubits jointly store one <strong>logical qubit</strong>, and if one fails, the others correct it. In December 2024, Google showed with Willow that going from grids of 3×3 to 5×5 and 7×7 qubits <a href="https://www.nature.com/articles/s41586-024-08449-y" target="_blank" rel="noopener">halved the error at each step</a>. It was the first time more qubits meant fewer errors. IBM plans <a href="https://www.ibm.com/roadmaps/quantum/" target="_blank" rel="noopener">Starling, with 200 logical qubits and 100 million operations</a>, for 2029.</li>
<li><strong>Post-quantum cryptography.</strong> The defense is not another quantum computer, but new mathematics that runs on ordinary machines. On August 13, 2024, the US National Institute of Standards and Technology (NIST) published three standards: <a href="https://www.nist.gov/news-events/news/2024/08/nist-releases-first-3-finalized-post-quantum-encryption-standards" target="_blank" rel="noopener">FIPS 203 (ML-KEM), FIPS 204 (ML-DSA) and FIPS 205 (SLH-DSA)</a>, and urged organizations to start migrating “immediately.” In March 2025 it chose <a href="https://www.nist.gov/news-events/news/2025/03/nist-selects-hqc-fifth-algorithm-post-quantum-encryption" target="_blank" rel="noopener">HQC as a backup</a>, and it has proposed <a href="https://csrc.nist.gov/pubs/ir/8547/ipd" target="_blank" rel="noopener">deprecating RSA from 2030 and disallowing it in 2035</a>. The United Kingdom set the same goal: <a href="https://www.ncsc.gov.uk/guidance/pqc-migration-timelines" target="_blank" rel="noopener">full migration by 2035</a>.</li>
<li><strong>New qubit technologies.</strong> Several races run in parallel: superconducting circuits (Google, IBM, China), trapped ions (Quantinuum, IonQ), neutral atoms, photons and Microsoft’s topological qubits, which in theory would be more resistant to noise.</li>
</ul>

<h2>Where we stand: progress as of October 2026</h2>
<p>Every milestone on this timeline comes with its own debate:</p>
{{img:linea}}
<ul>
<li><strong>Google.</strong> In 2019, its 53-qubit Sycamore chip claimed “quantum supremacy” with a <a href="https://www.nature.com/articles/s41586-019-1666-5" target="_blank" rel="noopener">200-second calculation</a>; IBM replied that a supercomputer could do it in <a href="https://www.ibm.com/quantum/blog/on-quantum-supremacy" target="_blank" rel="noopener">a few days, not 10,000 years</a>. Then came Willow (2024) and Quantum Echoes (2025).</li>
<li><strong>IBM.</strong> In November 2025 it unveiled <a href="https://www.tomshardware.com/tech-industry/semiconductors/ibm-unveils-new-120-qubit-processor-and-software-stack" target="_blank" rel="noopener">Nighthawk, with 120 qubits, and Loon</a>, a test chip for error correction. In July 2026, together with the University of Chicago, Algorithmiq and Qedma, it announced <a href="https://spectrum.ieee.org/ibm-verifiable-quantum-advantage" target="_blank" rel="noopener">three demonstrations of verified quantum advantage</a>. Note: they were not yet peer reviewed and several experts urged caution, although Dominik Hangleiter argues in a <a href="https://arxiv.org/abs/2603.09901" target="_blank" rel="noopener">2026 essay</a> that the advantage already exists.</li>
<li><strong>Microsoft.</strong> In February 2025 it presented <a href="https://azure.microsoft.com/en-us/blog/quantum/2025/02/19/microsoft-unveils-majorana-1-the-worlds-first-quantum-processor-powered-by-topological-qubits/" target="_blank" rel="noopener">Majorana 1</a>, with eight “topological” qubits. Nature published the <a href="https://www.nature.com/articles/s41586-024-08445-2" target="_blank" rel="noopener">related paper</a> with an editorial note: the results were not evidence of Majorana modes. In June 2026, physicist Henry Legg published a <a href="https://doi.org/10.1038/s41586-026-10567-8" target="_blank" rel="noopener">formal critique</a> in Nature, Microsoft <a href="https://doi.org/10.1038/s41586-026-10568-7" target="_blank" rel="noopener">replied</a> and announced Majorana 2. The <a href="https://www.theregister.com/a/5260489" target="_blank" rel="noopener">debate remains open</a>.</li>
<li><strong>Quantinuum and IonQ.</strong> November 2025 brought <a href="https://www.quantinuum.com/press-releases/quantinuum-announces-commercial-launch-of-new-helios-quantum-computer-that-offers-unprecedented-accuracy-to-enable-generative-quantum-ai-genqai" target="_blank" rel="noopener">Helios, with 98 qubits</a> of trapped ions; IonQ, with the same technology, holds the fidelity record.</li>
<li><strong>China.</strong> Pan Jianwei’s team presented Zuchongzhi 3.0, with 105 superconducting qubits, in <a href="https://journals.aps.org/prl/abstract/10.1103/PhysRevLett.134.090601" target="_blank" rel="noopener">Physical Review Letters</a> in March 2025, and earlier the photonic machine <a href="https://doi.org/10.1126/science.abe8770" target="_blank" rel="noopener">Jiuzhang</a> in 2020.</li>
</ul>
<h3>The world: a year devoted to quantum</h3>
<p>The United Nations proclaimed 2025 the <a href="https://quantum2025.org/" target="_blank" rel="noopener">International Year of Quantum Science and Technology</a>, a hundred years after quantum mechanics, at Mexico’s initiative. Governments are investing: the United Kingdom committed <a href="https://uknqt.ukri.org/news/uk-government-publishes-the-national-quantum-strategy/" target="_blank" rel="noopener">£2.5 billion over ten years</a>, India approved a national mission of <a href="https://quantumcomputingreport.com/government-of-india-approves-a-national-quantum-mission-with-a-budget-of-rs-6003-65-crore-730m-usd" target="_blank" rel="noopener">about USD 730 million</a> and Spain launched its <a href="https://www.lamoncloa.gob.es/serviciosdeprensa/notasprensa/transformacion-digital-y-funcion-publica/Paginas/2025/240425-lopez-estrategia-cuantica.aspx" target="_blank" rel="noopener">first quantum strategy in 2025, with about €800 million</a>.</p>
<h3>Latin America and Colombia</h3>
<p>In the region, quantum is growing from universities and communities. <a href="https://quantum-latino.com/" target="_blank" rel="noopener">Quantum Latino</a> brings researchers, companies and students together every year. In Colombia:</p>
<ul>
<li>Universidad de los Andes received <a href="https://thequantuminsider.com/2024/12/04/colombias-first-quantum-computer-advancing-education-research-and-technological-innovation/" target="_blank" rel="noopener">the country’s first quantum computer</a> in late 2024, an educational nuclear magnetic resonance device that runs at room temperature, and joined the <a href="https://www.uniandes.edu.co/es/noticias/fisica/2025-el-ano-internacional-de-la-cuantica" target="_blank" rel="noopener">International Year</a>.</li>
<li>In February 2026, UCEVA in Tuluá put into operation, with Ministry of Education funding, what the ministry calls <a href="https://www.mineducacion.gov.co/1780/w3-article-427345.html" target="_blank" rel="noopener">the largest quantum computer in the country</a>.</li>
<li>Universidad Nacional leads <a href="https://quantumcolombia.net/" target="_blank" rel="noopener">Quantum Colombia</a> and a National Chair in Quantum Technologies, with outreach for children.</li>
<li>The science ministry, Minciencias, opened the ColombIA Inteligente call in 2025, with <a href="https://dplnews.com/?p=273137" target="_blank" rel="noopener">20 billion pesos</a> for artificial intelligence and quantum technology projects.</li>
</ul>
<p>These are valuable steps to build talent, not to compete with Willow or Helios.</p>

<h2>For the curious: your first quantum program (optional)</h2>
<p>If you have never programmed, you can skip this part. If you have, simulate a quantum coin in Python with NumPy:</p>
<pre><code>import numpy as np

# the qubit starts at 0 (coin lying still)
zero = np.array([1, 0])
# Hadamard gate: sets the coin spinning
H = np.array([[1, 1], [1, -1]]) / np.sqrt(2)

# superposition
spinning = H @ zero
# probability = amplitude squared
prob = np.abs(spinning) ** 2
print("Probabilities of 0 and 1:", prob.round(2))

rng = np.random.default_rng(seed=7)
# measure 1,000 times
shots = rng.choice([0, 1], size=1000, p=prob)
print("Times 0 and 1 came up:", np.bincount(shots))

# apply H again: interference
twice = H @ spinning
print("After two H gates:", (np.abs(twice) ** 2).round(2))</code></pre>
<p>The output is <code>[0.5 0.5]</code>, then about 500 of each value and, finally, <code>[1. 0.]</code>. That last result is interference: applying H twice cancels the path to 1, so 0 always comes up.</p>
<p>The next step is to entangle two qubits with <a href="https://www.qiskit.org" target="_blank" rel="noopener">Qiskit</a>, IBM’s free library (I tested it with version 2.5; install it with <code>pip install qiskit</code>):</p>
<pre><code>from qiskit import QuantumCircuit
from qiskit.primitives import StatevectorSampler

# a circuit with two qubits, both at 0
qc = QuantumCircuit(2)
# qubit 0 starts spinning (superposition)
qc.h(0)
# if qubit 0 is 1, flip qubit 1: now they are entangled
qc.cx(0, 1)
# measure both
qc.measure_all()

result = StatevectorSampler().run([qc], shots=1000).result()
print(result[0].data.meas.get_counts())</code></pre>
<p>You will see something like <code>{'00': 476, '11': 524}</code>: half the time two zeros and half the time two ones, but <strong>never</strong> <code>01</code> or <code>10</code>. Those are the connected dice: the <em>Bell state</em>, the “hello world” of quantum computing. This runs on a simulator; to use real hardware, IBM’s free plan gives <a href="https://quantum.cloud.ibm.com/docs/guides/plans-overview" target="_blank" rel="noopener">up to 10 minutes every 28 days</a>. And if you are just starting with Python, my article <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel with Artificial Intelligence: Practical Examples</a> and the free <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel with AI download</a> (in Spanish) are a good on-ramp.</p>

<h2>Myths and facts</h2>
<table>
<thead><tr><th>Myth</th><th>Fact</th></tr></thead>
<tbody>
<tr><td>“It tries every answer at once”</td><td>Measuring gives a single answer. The advantage comes from interference, and only on certain problems.</td></tr>
<tr><td>“It will replace my computer”</td><td>No. It will be a specialized accelerator, in the cloud, alongside supercomputers.</td></tr>
<tr><td>“It can already break every password”</td><td>Not today. It would take around a million good-quality qubits, and post-quantum cryptography is already standardized.</td></tr>
<tr><td>“More qubits is always better”</td><td>Quality matters more: a few qubits with few errors are worth more than many noisy ones.</td></tr>
<tr><td>“It multiplies any computer’s power thousands of times”</td><td>You can read this even in official statements, but the advantage exists only for specific tasks; for almost everything else, a laptop wins.</td></tr>
</tbody>
</table>

<h2>Quick glossary</h2>
<ul>
<li><strong>Bit:</strong> the smallest unit of classical information; it is 0 or 1.</li>
<li><strong>Qubit:</strong> quantum bit; it can be in a combination of 0 and 1.</li>
<li><strong>Superposition:</strong> a combination of possibilities, like the spinning coin.</li>
<li><strong>Entanglement:</strong> a connection that correlates the results of several qubits.</li>
<li><strong>Interference:</strong> possibilities that reinforce or cancel each other, like waves.</li>
<li><strong>Decoherence:</strong> loss of quantum information because of the environment.</li>
<li><strong>Quantum gate:</strong> an operation on qubits, such as H (sets it spinning) or CNOT (entangles).</li>
<li><strong>Logical qubit:</strong> a “reliable” qubit made of many physical qubits that correct each other.</li>
<li><strong>Quantum advantage:</strong> solving a task better than the best known classical methods.</li>
<li><strong>Post-quantum cryptography:</strong> encryption methods that resist quantum attacks and run on ordinary computers.</li>
</ul>

<h2>Ideas to explore in class</h2>
<p>You do not need a lab. These activities work from grade 9 up:</p>
<ul>
<li><strong>Coins in the classroom.</strong> Each group tosses a coin 50 times, records the results in a spreadsheet and compares them with the Python simulation: probability and relative frequency.</li>
<li><strong>Drag-and-drop circuits.</strong> <a href="https://algassert.com/quirk" target="_blank" rel="noopener">Quirk</a> is a free simulator in the browser, with no sign-up: students drag an H gate and a CNOT and watch entanglement appear. The <a href="https://quantum.cloud.ibm.com/composer" target="_blank" rel="noopener">IBM Quantum Composer</a> also lets you send the circuit to real hardware.</li>
<li><strong>Free courses.</strong> <a href="https://quantum.cloud.ibm.com/learning" target="_blank" rel="noopener">IBM Quantum Learning</a> offers open courses; <a href="https://learning.quantum.ibm.com/course/basics-of-quantum-information" target="_blank" rel="noopener">Basics of Quantum Information</a> is ideal for math teachers, because it uses vectors and matrices.</li>
<li><strong>Myth debate.</strong> Sort real headlines with the myths and facts table: critical thinking and physics at the same time.</li>
<li><strong>Assessment.</strong> With the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> you create a quantum computing quiz with several versions and an answer key; try the <a href="/examenes/demo/">free demo</a>.</li>
</ul>
<p>If you teach Technology and Computing or Mathematics, the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> (in Spanish) includes tested prompt recipes to plan a unit on a STEM topic like this one, assess it with rubrics on Colombia’s grading scale and adapt it with Universal Design for Learning. And on what these technologies mean for work, I wrote <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">AI Won’t Replace You. Someone Who Masters It Will</a>: something similar will happen with quantum.</p>

<p class="notice"><strong>Teach what is coming with what you already have.</strong> The <strong>AI Kit for Teachers</strong> (in Spanish; Technology and Computing or Mathematics, 60,000 Colombian pesos per subject) turns a new topic, such as quantum computing, into a concrete lesson. The <strong>AI Exam Generator</strong> builds the assessment with versions and an answer key, and has a free simulator. The free <strong>Excel with AI</strong> download includes a first Python script. None of them replaces your judgment: they give you time for what matters.</p>
<p><a class="btn-link" href="/producto/kit-de-ia-para-docentes/">See the AI Kit for Teachers</a></p>

<h2>Food for thought</h2>
<p>Quantum computing may be the first major technology whose advantage almost nobody can check for themselves: verifying what one of these machines says takes another machine like it, a supercomputer or a team of experts we have to trust. And its greatest risk, opening the secrets we keep encrypted today, will fall on everyone, even if only a few countries and companies control it. <strong>If a handful of labs reaches a machine able to read the world’s secrets first, should it be treated as a scientific discovery to be shared, a weapon to be regulated or a product to be sold? And what should we teach a 15-year-old in Colombia today so that, in that conversation, they are a protagonist and not just a spectator?</strong></p>
HTML;

$html = strtr($code($html), [
    '{{img:qubit}}' => $img('cuantica-bit-qubit', 540, 'Comparison of a bit and a qubit. On the left, a coin lying still: the bit is 0 or 1, like a switch that is off or on. On the right, a spinning coin: the qubit is in superposition, with a 50 percent chance of 0 and 50 percent of 1 in this example, until it is measured. Below: 1 qubit gives 2 possibilities, 2 give 4, 3 give 8 and 300 give more than the atoms in the observable universe', 'A bit is a coin lying still; a qubit, a coin that spins until we look at it.'),
    '{{img:ideas}}' => $img('cuantica-ideas', 600, 'Three key ideas of quantum computing with analogies: superposition, a spinning coin; entanglement, two connected dice that always match even in Barranquilla and Leticia; interference, waves that reinforce or cancel each other. Below, decoherence: noise, heat and vibrations make the coin fall too early', 'Superposition, entanglement and interference make a quantum computer different; decoherence is its enemy.'),
    '{{img:puede}}' => $img('cuantica-puede-no-puede', 600, 'Visual table of what quantum computing can and cannot do. Promising: simulating molecules for medicines and fertilizers, designing materials and batteries, breaking RSA encryption in the future with much larger machines and generating certified randomness. Uncertain: optimization and logistics, finance, quantum AI and climate. Useless or a myth: browsing, social media and office work, predicting the stock market, replacing your computer and trying everything at once', 'What science supports, what is still in doubt and what is pure myth.'),
    '{{img:linea}}' => $img('cuantica-linea-tiempo', 640, 'Quantum computing timeline from 2019 to 2026: 2019, Google Sycamore with 53 qubits; 2020, the photonic Jiuzhang in China; 2023, IBM utility with 127 qubits; August 2024, NIST publishes FIPS 203, 204 and 205; December 2024, Google Willow with 105 qubits below the error correction threshold; 2025, International Year of Quantum Science and Technology, Microsoft Majorana 1 in February, Zuchongzhi 3.0 in March, Quantum Echoes in October, IBM Nighthawk and Quantinuum Helios in November; 2026, UCEVA in Colombia in February, a critique of Majorana in Nature in June and IBM announces verified quantum advantage in July', 'Seven years of progress and debate, from the 2019 “supremacy” to the verifiable advantage of 2025 and 2026.'),
]);

return [
    'computacion-cuantica-para-que-sirve-como-cambiara-el-mundo' => [
        'slug' => 'quantum-computing-what-it-is-for-how-it-could-change-the-world',
        'title' => 'Quantum Computing: What It Is For and How It Could Change the World',
        'excerpt' => 'What a qubit is and what superposition, entanglement and interference mean, explained with coins, dice and mazes; what quantum computing is really for and what is hype; advantages, disadvantages, risks such as “harvest now, decrypt later,” post-quantum cryptography and the state of the art in October 2026, with optional Python code, a glossary and classroom ideas.',
        'seo_title' => 'Quantum Computing Explained: Uses, Myths and What Comes Next',
        'seo_description' => 'Quantum computing made simple: qubits, superposition and entanglement with everyday examples, real uses versus myths, risks, 2026 progress and Python code.',
        'focus_keyword' => 'quantum computing',
        'cover' => '/assets/img/articulos/computacion-cuantica/cuantica-portada-en',
        'cover_alt' => 'Cover: Quantum computing, what it is for and how it could change the world. A spinning coin represents a qubit in superposition next to a circuit with H and CNOT gates that entangles two qubits',
        'content_html' => $html,
    ],
];
