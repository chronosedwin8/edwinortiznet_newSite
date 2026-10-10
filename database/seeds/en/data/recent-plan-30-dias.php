<?php

declare(strict_types=1);

// English version of «Implementar una plataforma en el colegio en 30 días: plan, piloto y decisión de …». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/plan-30-dias/' . $name . '-en';
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
<p>The school buys a platform in December "so teachers use it from January". In March, three teachers use it. In June, nobody remembers the password. It was not a technology problem: it was an implementation problem. <strong>Most failures of an educational platform are decided before it is used for the first time</strong>, when it was not defined what problem it should solve, risks were not reviewed and the decision to scale was made without testing.</p>
<p>This article proposes a <strong>30-day implementation plan</strong>: four weeks to define, prepare, test with a pilot and decide with evidence whether to continue, adjust or close. It includes an <a href="/descargas/plan-30-dias/plan-implementacion-30-dias.xlsx">Excel workbook</a> (in Spanish) with a 14-task plan with predecessors, an automatic Gantt chart, a sequence check and a decision sheet with six weighted criteria, verified in Microsoft Excel 16 and against an independent calculation. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> This is a simplified project-management framework, not a certified methodology, and the example's plan, tasks, owners and criteria are fictional and editable. A 30-day pilot lets you decide whether it is worth continuing, but does not by itself show that the platform improves learning: that requires a longer evaluation (see <a href="/prueba-cuatro-semanas-herramienta-educativa-mejora-aprendizaje/">how to test an educational tool in four weeks</a>). Legal requirements on personal data, contracts and purchasing depend on your institution: check them.</p>

<h2>Why 30 days and why a pilot</h2>
<p>Thirty days is enough to learn the essentials (does it work with our data? do teachers understand it? how much support does it need?) and short enough that the cost of being wrong is low. The pilot is the central piece: <strong>test with a few groups and test data before committing the whole institution</strong>. It lets you discover problems while they are still cheap to fix, and gives you your own evidence base, not just the vendor's. This connects with a lesson from <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">technology debt</a>: every platform adopted without evaluation becomes a cost of maintenance, integration and training.</p>
{{img:semanas}}

<h2>The plan, week by week</h2>
<p><strong>Week 1 (days 1 to 7): define and review.</strong> Tasks: define the problem and success criteria (which indicator would change if it works?); name owners and the pilot team; review privacy, contract and costs. Deliverable: a one-page document with the problem, criteria and risks. Review questions: what student data does the platform receive and where is it stored? who is the data controller and what does the contract say about data deletion? what is the total cost over three years (see <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">the total cost of buying, subscribing or building</a>)? is there an exit plan if you decide to switch? If the platform uses AI, see <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into an AI tool</a>.</p>
<p><strong>Week 2 (days 8 to 14): configure and prepare.</strong> Configure accounts, roles and permissions; load <strong>test data, not real data</strong>; prepare materials and a quick guide; train the pilot team. Deliverable: a configured environment and a trained team. Golden rule: <strong>do not load real student data until you have reviewed the contract and permissions.</strong> In Colombia, Law 1581 of 2012 on personal data protection limits the processing of children's and adolescents' data (its article 7 requires that it respond to and respect the best interests of minors and their fundamental rights); check with your institution which authorizations are required.</p>
<p><strong>Week 3 (days 15 to 21): pilot.</strong> Pilot with two groups (or as many as your support capacity allows), collect feedback from teachers and students and adjust the configuration. Deliverable: usage data and a list of problems with their severity. Log incidents: this is the moment to apply the logic of the <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">help desk</a> (priority, deadline and vendor response time).</p>
<p><strong>Week 4 (days 22 to 30): expand, measure and decide.</strong> Expanded pilot, measurement of the indicators defined on day one, a decision session and a rollout or orderly closure plan. Deliverable: a documented decision.</p>

<h2>The Excel workbook</h2>
<ul>
<li><strong>Plan:</strong> one row per task with owner, start, duration, predecessor and, calculated, the end, the predecessor's end, a sequence <em>check</em>, the start week and a 30-column <strong>Gantt chart</strong> that paints itself with conditional formatting.</li>
<li><strong>Decision:</strong> six criteria with weight and a 1 to 5 score; it calculates the weighted score and a reading.</li>
<li><strong>Resumen:</strong> tasks, task-days, last day, tasks with a problem, tasks per week and tasks per team.</li>
</ul>
<pre><code>' End of a task (the start day counts as the first day)
=IF(D4="","",D4+E4-1)                                   ' English
=SI(D4="";"";D4+E4-1)                                   ' Spanish

' End of the predecessor (looking it up by its ID)
=IFERROR(INDEX($F$4:$F$40,MATCH(G4,$A$4:$A$40,0)),"No existe")

' Sequence check: a task must not start before its predecessor ends
=IF(D4<=H4,"Empieza antes de que termine su predecesora",IF(F4>30,"Pasa del día 30","OK"))

' Gantt cell for day 15 (painted when the value is 1)
=IF(AND(15>=$D4,15<=$F4),1,"")</code></pre>
<p>With the 14-task example, the sum of durations is <strong>41 task-days</strong> and the last one ends on <strong>day 30</strong>. The check detects <strong>one task with a sequence problem</strong>: collecting feedback (T9) starts on day 18, the same day the pilot (T8) ends, so it has no time to collect what the pilot produces; it must move to day 19. It is a classic mistake: planning as if tasks fit together without slack. By start week, there are 4 tasks in week 1, 4 in week 2, 2 in week 3 and 4 in weeks 4 and 5; and <strong>4 of the 14 tasks (29%) depend on the IT team</strong>, a likely bottleneck if it is one person (see <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">a help desk for the school</a>).</p>

<h2>The decision: six weighted criteria</h2>
<p>On day 29 you decide with criteria set at the start, not with the last day's impression. The <em>Decision</em> sheet proposes six criteria with weights (adding to 100%): solves the problem defined (25%), ease of use (20%), privacy and security (20%), integration with what is already used (15%), reasonable total cost over three years (10%) and support and vendor dependence (10%). With the example scores (4, 3, 5, 3, 4 and 2), the weighted score is <strong>3.65</strong> out of 5; with a threshold of 3.5, the reading is "continue, with adjustments in the lowest criteria": support (2), ease of use (3) and integration (3). The sheet also warns if a critical criterion is at 1 (in which case the recommendation is to close or fix before continuing) and if the weights do not add to 100%. The thresholds and weights are the example's: define yours before the pilot.</p>

<h2>Five mistakes the plan tries to avoid</h2>
{{img:pasos}}
<ol>
<li><strong>Starting with the tool and not the problem.</strong> "We want to use AI/a platform" is not a problem. "Teachers take three hours to submit grades" is, and it can be measured.</li>
<li><strong>Skipping the data and contract review</strong> because "everybody uses it".</li>
<li><strong>Scaling without a pilot</strong> or with a pilot without criteria: the pilot does not decide if nobody defined what it means for it to work.</li>
<li><strong>Underestimating training and support.</strong> A platform without accompaniment becomes one more file.</li>
<li><strong>Not planning the exit.</strong> If you do not know how to recover your data and close, you are tied to the vendor (see <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">why integrations fail silently</a> and <a href="/un-dato-varias-versiones-conciliar-sistema-gestion-aula-virtual-teams-conciliador/">one datum, several versions</a>).</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, schools adopt platforms on their own initiative, through territorial entity programs or under pressure from families, and the decision is often made on price or fashion. The same happens in the region, with the aggravating factor that institutions' technical capacity is very uneven; worldwide, the literature on educational technology adoption insists that success depends more on accompaniment and pedagogical use than on the tool. For <strong>principals</strong>, the plan turns a purchase into a decision with evidence; for <strong>teachers</strong>, the pilot is a chance to give their opinion before the tool is imposed; for <strong>IT staff</strong>, it orders the work and makes their load visible; and for <strong>families</strong>, the data review is a guarantee of care. See also <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">protecting the school domain</a> and <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">the technology inventory</a>.</p>

<h2>Templates and tools</h2>
<p>If you need ready-made Excel templates, with support, or help with your administrative processes, look at these options. For the teaching side, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> are the author's own tools for teachers.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion/">digital approval flow</a>, <a href="/que-monitorear-aplicacion-web-senales-umbrales-alertas-plan/">what to monitor in a web application</a> and <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">what to do in the first 60 minutes of ransomware</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Why a pilot before implementing?</h3>
<p>Because it lets you discover configuration, data, use and support problems while they are still cheap to fix, and decide with your own evidence.</p>
<h3>How many groups should the pilot have?</h3>
<p>As many as your support capacity can handle well: usually two or three groups at first, expanding later if all goes well.</p>
<h3>Can I use real student data in the pilot?</h3>
<p>First with test data. Real data only after reviewing the contract, the permissions and the authorizations required by data-protection regulation and your institution.</p>
<h3>What do I do if the pilot goes badly?</h3>
<p>Closing it in time is a good result: it avoided a larger cost. Document what was learned and recover or delete the data according to the contract.</p>
<h3>Does this plan work for a platform with AI?</h3>
<p>Yes, adding the specific review of what data enter the models, how they are stored and whether they are used for training; see the AI policy and the questions before pasting data.</p>

<p class="notice"><strong>Plan your pilot.</strong> Download the <a href="/descargas/plan-30-dias/plan-implementacion-30-dias.xlsx">30-day plan</a> (in Spanish), adjust the tasks and owners to your case, set the decision criteria before starting and check that no task starts before its predecessor ends.</p>

<h2>Food for thought</h2>
<p>A platform nobody uses is not neutral: it consumes money, training time and trust. <strong>Who at your school has the authority today to say "this platform did not work, we are closing it"? And if the answer is nobody, what are we willing to pay for not admitting a mistake?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:semanas}}' => $img('plan-30-dias-semanas', 499, 'Table with the four weeks of a 30-day implementation plan, the goal and deliverable of each.', 'Each week ends with a deliverable.'),
    '{{img:pasos}}' => $img('plan-30-dias-pasos', 467, 'Five steps before scaling a platform: problem, risks, pilot, measure and decide.', 'Five steps that avoid a costly failure.'),
]);

return [
    'implementar-plataforma-colegio-30-dias-plan-piloto-decision-excel' => [
        'slug' => 'implement-platform-school-30-days-plan-pilot-decision-excel',
        'title' => 'Implementing a Platform at School in 30 Days: Plan, Pilot and a Decision to Continue, Adjust or Close (Excel Workbook)',
        'excerpt' => 'A four-week plan to implement a platform at school: define, prepare, run a pilot and decide with six weighted criteria, with an Excel workbook with a Gantt chart and a sequence check.',
        'seo_title' => 'Implement a School Platform in 30 Days',
        'seo_description' => 'A 30-day plan to implement a school platform: define, prepare, pilot and decide with criteria, with an Excel workbook and Gantt chart.',
        'focus_keyword' => 'implement a school platform',
        'cover' => '/assets/img/articulos/plan-30-dias/plan-30-dias-portada-en',
        'cover_alt' => 'Cover "Implementing a platform at school in 30 days: a plan with a decision" with a card: 30 days to test a platform with a pilot and decide with evidence.',
        'content_html' => $html,
    ],
];
