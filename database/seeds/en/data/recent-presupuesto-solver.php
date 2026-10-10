<?php

declare(strict_types=1);

// English version of «Presupuesto limitado con Solver: cómo elegir qué proyectos hacer cuando no alcan…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/presupuesto-solver/' . $name . '-en';
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
<p>The school board has a list of ten projects: fixing the courtyard roof, improving Wi-Fi, renewing the library, equipping the lab, training teachers, installing cameras, painting classrooms, buying computers, sports equipment. They would cost $214 million. There is $120 million. Someone proposes "going from cheapest to most expensive"; another, "the most urgent first"; a third, "whatever gives the most benefit per peso". Each rule sounds reasonable and <strong>each produces a different plan</strong>. How do you know which is best, or whether there is one better than all three?</p>
<p>This article shows how to frame that decision as an <strong>optimization model</strong> and solve it with <strong>Solver</strong>, the Excel add-in. It includes an <a href="/descargas/presupuesto-limitado-solver/presupuesto-limitado-solver.xlsx">Excel workbook</a> (in Spanish) with the model already set up: ten fictional projects, three constraints and a comparison between the optimal plan and two simple rules. I verified the optimum in two ways: running Solver in Microsoft Excel 16 and enumerating all 1,024 possible combinations with an independent calculation; they agree.</p>
<p class="notice"><strong>Warnings.</strong> The data are fictional (costs in millions of pesos and "benefit" in points from an imaginary committee). An optimization model does not decide for you: <strong>it optimizes what you ask with the numbers you give it</strong>, and if those numbers are debatable, so is the result. A school's budget decisions have their own rules and bodies (in public schools, the Educational Services Fund budget is approved by the school board; check Decree 1075 of 2015 and your secretariat's rules). Use it to structure the discussion, not to close it.</p>

<h2>Three ingredients of a model</h2>
{{img:ingredientes}}
<ol>
<li><strong>Decision variables:</strong> what you can choose. Here, one cell per project with 1 (do it) or 0 (do not).</li>
<li><strong>Objective function:</strong> what you want to maximize or minimize. Here, total benefit: the sum of the points of the chosen projects.</li>
<li><strong>Constraints:</strong> what you cannot violate. Here: (a) total cost cannot exceed $120 million; (b) there must be at least 2 pedagogical projects; (c) full Wi-Fi and basic Wi-Fi are mutually exclusive (at most one).</li>
</ol>
<p>When variables are 0 or 1 and relationships are linear (sums of costs or benefits), this is an <em>integer linear programming</em> problem, of the family known as "knapsack problems". Solver solves them with the <em>Simplex LP</em> method and binary variables.</p>
<pre><code>' Total cost and total benefit of the plan (selection in F4:F13, costs in D, benefits in E)
=SUMPRODUCT(F4:F13,D4:D13)                ' English
=SUMPRODUCT(F4:F13,E4:E13)
=SUMAPRODUCTO(F4:F13;D4:D13)              ' Spanish
=SUMAPRODUCTO(F4:F13;E4:E13)

' Pedagogical projects chosen
=SUMPRODUCT((C4:C13="Pedagógico")*F4:F13)         ' English
=SUMAPRODUCTO((C4:C13="Pedagógico")*F4:F13)       ' Spanish

' Benefit per million (for the greedy rule)
=Modelo!E4/Modelo!D4</code></pre>

<h2>How to set up Solver (step by step)</h2>
<ol>
<li><strong>Enable the add-in</strong> if you do not see the button: File, Options, Add-ins, Manage "Excel Add-ins", Go, and check <em>Solver</em>. It will appear on the <em>Data</em> tab.</li>
<li><strong>Set Objective:</strong> the total benefit cell (G16), with the <em>Max</em> option.</li>
<li><strong>By Changing Variable Cells:</strong> the selection range (F4:F13).</li>
<li><strong>Subject to the Constraints</strong> (<em>Add</em> button): F4:F13 = <em>bin</em>; total cost (G15) ≤ budget (Parametros!B3); pedagogical (G17) ≥ minimum (Parametros!B4); Wi-Fi (G18) ≤ 1 (Parametros!B5).</li>
<li><strong>Solving method:</strong> <em>Simplex LP</em>, and make sure the option to make unconstrained variables non-negative is checked. Click <em>Solve</em>.</li>
<li><strong>Check the result,</strong> not only the answer: confirm each constraint is met (the workbook flags it in column I) and save the solution.</li>
</ol>
<p>Button names may vary slightly by Excel version and language. The workbook already comes with the model configured and the solution loaded; when you open Solver you will see the parameters, and you can change the budget or scores and solve again.</p>

<h2>What the example showed (fictional data)</h2>
<p>Ten projects costing $214 million, a budget of $120 million:</p>
<ul>
<li><strong>Optimal plan (Solver):</strong> fix the courtyard roof (P1), basic Wi-Fi (P3), renew the books (P4), equip the lab (P5), teacher training (P6) and paint classrooms (P8). It costs <strong>$120 million</strong>, uses the whole budget, includes 3 pedagogical projects and totals <strong>287 points</strong> of benefit. It is the only optimal plan in the example.</li>
<li><strong>"Highest benefit per million first" rule:</strong> chooses P6, P3, P4, P10, P5, P7 and P8, costs $113 million and totals <strong>279 points</strong>, eight less than the optimum. The problem: it reaches the single highest-benefit project, the roof (72 points), when the $35 million no longer fit, and $7 million is left unused.</li>
<li><strong>"Cheapest first" rule:</strong> in this example it gives the same 279-point plan.</li>
<li><strong>The simple rules are not bad;</strong> they are 8 points (almost 3%) from the optimum, which may or may not be acceptable depending on what is at stake. What the model offers is a benchmark to measure them against.</li>
</ul>
{{img:sensibilidad}}
<p>And a second question, perhaps more useful than the first: <strong>what if the budget changes?</strong> The <em>Sensibilidad</em> sheet (calculated by enumeration) shows that with $100 million the optimal benefit is 254; with $110, 265; with $120, 287; with $130, 307; and with $140, 331. Each extra $10 million buys between 11 and 24 points, and the plan changes projects: with $100 million it leaves out the roof and chooses cameras. That helps negotiate: <em>"with 10 million more we can add the sports equipment and reach 307"</em>.</p>
<p><strong>An honest reading:</strong> the optimum is optimal <em>for those scores</em>. If the committee had rated the roof 60 instead of 72, the plan would change. Also, the model ignores things that matter: urgency (a roof that is falling is not just another project), equity between campuses or levels, maintenance costs, dependencies between projects and what the community says. A good practice is to treat the result as a proposal to discuss, test how it changes with other scores and fix by hand (with a constraint) what is mandatory.</p>

<h2>How to build the scores</h2>
<ol>
<li><strong>Define criteria</strong> (impact on learning, safety, equity, number of beneficiaries, urgency) and their weights before rating the projects.</li>
<li><strong>Rate separately</strong> (several committee members, without seeing others' scores) and average.</li>
<li><strong>Turn mandatory conditions into constraints,</strong> not high scores (for example, "the roof must be in the plan").</li>
<li><strong>Test sensitivity:</strong> change weights and scores and see whether the plan holds or changes a lot. If it changes, the discussion should focus on those projects.</li>
<li><strong>Document and communicate</strong> the assumptions alongside the result (see <a href="/presupuesto-colegio-excel-ejecutado-comprometido-disponible-cdp-rp-libro/">budget executed, committed and available</a> and <a href="/costos-unitarios-colegio-excel-costo-por-estudiante-reparto-punto-de-equilibrio/">unit costs</a>).</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>Constrained optimization is a standard tool in project management, logistics and finance, and in the public sector it is used to prioritize investment, among other purposes. In schools, the usual practice is to prioritize by urgency, community pressure or what was approved the year before, with little documentation of criteria. In Colombia, public schools' investment is executed with transfers and educational services funds subject to procurement and budget rules; in private schools, with authorized tuition. No technique replaces those rules or the school board's deliberation.</p>
<p>For <strong>principals</strong>, a transparent model makes it possible to explain why one project was chosen and not another; for <strong>teachers</strong>, to see how each area's needs are valued; for <strong>families</strong>, to understand that "there is not enough" is a constraint and that choosing means giving something up; and for <strong>students</strong>, that investment decisions take their safety and learning into account, and not only what is most visible.</p>

<h2>Tools and templates</h2>
<p>If you work with the site's Excel templates and want support, or prepare material with AI (always reviewing what it produces and without including confidential financial data in tools not designed to safeguard it), take a look at these products.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: the <a href="/descargas/presupuesto-limitado-solver/presupuesto-limitado-solver.xlsx">limited budget with Solver workbook</a>, <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel with artificial intelligence</a> and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> tools.</p>

<h2>Frequently asked questions</h2>
<h3>What is Solver?</h3>
<p>An Excel add-in that finds the values of some cells (variables) that maximize or minimize the result of another (objective), respecting constraints.</p>
<h3>How do I enable Solver in Excel?</h3>
<p>File, Options, Add-ins, Manage "Excel Add-ins", Go, and check Solver. It appears on the Data tab.</p>
<h3>Why use binary variables?</h3>
<p>Because each project is either done in full or not done; the "bin" constraint forces each cell to be 0 or 1.</p>
<h3>Is Solver's result always the best?</h3>
<p>It is the best for the model you gave it. If the scores or constraints are debatable, so is the result. And there may be several equally good plans.</p>
<h3>What if the optimal plan does not convince me?</h3>
<p>Review the scores and constraints: maybe a constraint reflecting something mandatory is missing, or the scores undervalue a project. Change and solve again.</p>

<p class="notice"><strong>Try the model with your projects.</strong> Download the <a href="/descargas/presupuesto-limitado-solver/presupuesto-limitado-solver.xlsx">limited budget with Solver workbook</a> (in Spanish), replace the projects, costs and scores with your school's, change the budget and run Solver again to see how the plan changes.</p>

<h2>Food for thought</h2>
<p>A number we give a model looks neutral, but behind every score there is a judgment about what matters most. <strong>Who rates your school's needs today and with what criteria? And if a project that matters to few but is essential to them gets a low score, how do we keep the model from always leaving it out?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ingredientes}}' => $img('presupuesto-solver-ingredientes', 499, 'Table with the four ingredients of a Solver model and the example of each: variables, objective, constraints and method.', 'What you tell Solver.'),
    '{{img:sensibilidad}}' => $img('presupuesto-solver-sensibilidad', 480, 'Bar chart of the optimal benefit by budget: 254 with 100, 265 with 110, 287 with 120, 307 with 130 and 331 with 140 million.', 'Optimal benefit by budget.'),
]);

return [
    'presupuesto-limitado-solver-excel-elegir-proyectos-cuando-no-alcanza-modelo' => [
        'slug' => 'limited-budget-solver-excel-choosing-projects-when-there-is-not-enough-model',
        'title' => 'Limited Budget with Solver: How to Choose Which Projects to Do When There Is Not Enough, with a Verified Excel Model',
        'excerpt' => 'How to frame choosing projects under a limited budget as a model (variables, objective and constraints) and solve it with Solver, comparing the optimum with simple rules and seeing what happens if the budget changes.',
        'seo_title' => 'Limited Budget with Solver in Excel: Choosing Projects',
        'seo_description' => 'How to use Solver to choose projects under a limited budget: variables, objective and constraints, optimum versus simple rules, in an Excel workbook.',
        'focus_keyword' => 'Solver limited budget Excel',
        'cover' => '/assets/img/articulos/presupuesto-solver/presupuesto-solver-portada-en',
        'cover_alt' => 'Cover "Limited budget with Solver: choosing which projects to do when there is not enough" with a card: 287 versus 279 benefit points, the optimal plan versus choosing by highest benefit/cost ratio.',
        'content_html' => $html,
    ],
];
