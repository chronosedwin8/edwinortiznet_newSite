<?php

declare(strict_types=1);

// English version of "¿La IA amplía el pensamiento del estudiante o lo reemplaza?". Key is the Spanish slug. Evidence (Bastani et al. PNAS 2025,
// Lee et al. CHI 2025, OECD Digital Education Outlook 2026, TALIS 2024) checked on October 9, 2026. Status and date are carried over from the
// Spanish post by en/02_recent_posts.php (scheduled for Wednesday, October 14, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/ia-amplia-o-reemplaza-pensamiento/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>A student hands in a flawless assignment. When you ask her to explain the second step, she goes quiet. She is not a bad student: she used artificial intelligence as a shortcut and the shortcut worked, for the assignment. The question that matters in the classroom is no longer "does she use AI?" but <strong>"what is left in her head after using it?"</strong></p>
<p>In this article I review the evidence on cognitive dependence, propose a simple criterion to tell support that expands thinking from automation that avoids it, and give you a <strong>rubric</strong> for autonomy, reasoning and justification to use in class or at home. Data checked on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> AI almost always improves the product; what is in doubt is whether it improves learning. In an experiment with nearly a thousand students, those who practiced with an unguarded chatbot scored higher in practice and 17% lower on the AI-free exam; with a tutor that gave hints instead of answers, that harm disappeared. The difference is not made by the tool but by the design of the task.</p>

<h2>What the evidence says about AI and thinking</h2>
<p>The strongest study so far is a field experiment with nearly a thousand high school math students, published in <a href="https://www.pnas.org/doi/10.1073/pnas.2422633122"><em>PNAS</em> in 2025 (Bastani and colleagues)</a>. Students practiced under three conditions: no AI, a ChatGPT-style chatbot (GPT Base) and a tutor designed to give hints (GPT Tutor). During practice, AI raised performance by 48% with the chatbot and 127% with the tutor. But when access was removed and they took an exam without AI, <strong>the chatbot group scored 17% lower than those who never used it</strong>, while the tutor group showed no negative difference (though no positive effect either). The authors describe it as a "crutch": students stopped doing the effort that builds learning. These are short-term results, in one country and one subject, but they point in a direction.</p>
{{img:evidencia}}
<p>Other pieces point the same way, with more caution:</p>
<ul>
<li><strong>Knowledge workers.</strong> A <a href="https://advait.org/files/lee_2025_ai_critical_thinking_survey.pdf">Carnegie Mellon and Microsoft survey (CHI 2025)</a> of 319 people found that the more confidence in AI, the less self-reported critical thinking, and the more confidence in one's own abilities, the more. It is a correlation based on self-reports, not proof of cause.</li>
<li><strong>OECD.</strong> The <a href="https://www.oecd.org/en/publications/oecd-digital-education-outlook-2026_062a7394-en.html">Digital Education Outlook 2026</a> concludes that generative AI can support learning when used with clear pedagogical principles, but that delegating the task improves performance without improving learning, and that the advantage tends to vanish or reverse when the tool is removed.</li>
<li><strong>Writing.</strong> A <a href="https://arxiv.org/abs/2506.08872">preliminary MIT Media Lab study</a> with 54 participants measured brain activity while writing with ChatGPT, a search engine or no aids, and reported lower connectivity with AI. It is a small preprint without peer review: treat it as a hypothesis, not a verdict.</li>
</ul>
<p>The honest reading is this: <strong>there is no evidence that AI "switches off the brain" by itself, but there is evidence that, used without design, it turns effort into product and product into an illusion of learning</strong>.</p>

<h2>Scaffold or crutch: the criterion to tell them apart</h2>
<p>A scaffold holds you up while you build and comes down when the building can stand alone. A crutch carries you, but if you take it away you cannot walk. The same tool can be either one depending on how it is used. These are the practical indicators:</p>
{{img:criterio}}
<p>And this is the <strong>three-question test</strong> a student, or a parent reviewing homework, can use without needing to detect whether AI was involved:</p>
<ol>
<li><strong>Can I explain it in my own words?</strong> If I can only repeat what the text says, I did not understand it.</li>
<li><strong>Could I solve a similar one without AI?</strong> This is the transfer test, the one that really measures learning.</li>
<li><strong>Do I know where it might be wrong?</strong> Whoever can question the answer is thinking with the tool, not behind it.</li>
</ol>

<h2>The rubric: autonomy, reasoning and justification</h2>
<p>This is the practical resource. Use it after a task in which AI was allowed, together with a short <strong>transfer test</strong>: 5 to 10 minutes with a similar problem, without AI or notes, or a brief oral explanation. The grade does not punish having used AI; it measures how much stayed with the student.</p>
<table>
<thead><tr><th>Criterion</th><th>1 · Dependent</th><th>2 · Accompanied</th><th>3 · Autonomous</th><th>4 · Expands</th></tr></thead>
<tbody>
<tr><td><strong>Autonomy</strong>: solves without AI</td><td>Cannot move forward without it</td><td>Moves forward with constant help</td><td>Solves a similar problem without AI</td><td>Solves and proposes harder variants</td></tr>
<tr><td><strong>Reasoning</strong>: rebuilds the procedure</td><td>Repeats the result</td><td>Describes the steps without knowing why</td><td>Explains why each step works</td><td>Compares methods and chooses with judgment</td></tr>
<tr><td><strong>Justification</strong>: defends the answer</td><td>"That's what the AI said"</td><td>Cites a source without checking it</td><td>Supports with evidence and cross-checks</td><td>Anticipates objections and answers them</td></tr>
<tr><td><strong>Critical use of AI</strong>: verifies and corrects</td><td>Accepts everything unread</td><td>Fixes obvious errors</td><td>Detects flaws and verifies in sources</td><td>Documents what was asked, corrected and learned</td></tr>
</tbody>
</table>
<p><strong>How to use it in 10 minutes.</strong> (1) Hand out the task with an explicit AI rule ("you may consult it, you must declare how"). (2) Ask for a short transfer test or a two-minute oral explanation. (3) Grade with the rubric and share the result as feedback, not as punishment. (4) If the gap between the task and the transfer test is large, the problem is design: change the task, not just the grade.</p>

<h2>Colombia, Latin America and the world: what changes with context</h2>
<p>The debate has nuances depending on where you look. <strong>Worldwide</strong>, the OECD and UNESCO agree that we must teach people to use AI with judgment and redesign assessment; the PISA 2025 results on learning in the digital world will arrive in 2027. <strong>In Colombia</strong>, use is already widespread: according to the OECD (TALIS 2024), about 53% of Colombian teachers used AI in the past year, versus 36% for the OECD average; and a 2024 GAD3 survey found that 84% of university students use generative AI frequently, though only 35% go beyond the basics. In August 2026 the Ministry of Education presented a <a href="https://www.mineducacion.gov.co/1780/w3-article-429623.html">Decalogue on AI for Higher Education</a>, which insists on keeping human interaction and adapting pedagogical models; for schools, Law 2626 of 2026 on digital education, according to published texts, brings AI and data science into the Technology and Computing area, though I am not aware of a specific guideline on AI use by primary and secondary students. <strong>In Latin America</strong> there is also an access gap: not everyone has connectivity or a device, and AI can widen inequality if only a few learn to use it well.</p>
<p>And there is an equity nuance worth remembering: for students with disabilities, AI can be a legitimate and necessary support (reading aloud, simplifying texts, structuring notes). Here the criterion is not "how much AI" but "what barrier it removes and what learning it preserves", and that is what should be written in the support plan (the PIAR in Colombia), not a blanket ban.</p>

<h2>Three viewpoints: teachers, families and students</h2>
<ul>
<li><strong>Teachers:</strong> they ask for time and tools; 72% of OECD teachers fear students will present AI-made work as their own. The way out is not chasing copies but designing tasks with visible process and transfer tests.</li>
<li><strong>Families:</strong> they want to know whether they can let their children use it. A simple rule: yes to explain, practice and review; no to hand over the answer. And always ask: "explain to me how you solved it."</li>
<li><strong>Students:</strong> they use it because it works and because everybody does. They need clear rules and reasons, not sermons: the three-question test is for them, not only for their teachers.</li>
</ul>

<h2>Tools to apply this in your classroom</h2>
<p>If you want to measure transfer without spending your evenings, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> creates different versions of the same problem in minutes, with LaTeX for math and their solutions, exactly what you need for a transfer test (you can try the <a href="/examenes/demo/">free demo</a>). To design activities in "scaffold" mode (hints, not answers), the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a> offers recipes by subject. And for students who need reasonable accommodations, <a href="/herramientas/piar/">PIAR con IA</a> helps you draft the plan without losing pedagogical judgment.</p>
{{productos:generador-de-examenes-ia-esencial,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">"The Big Lie About AI"</a>, <a href="/inteligencia-artificial-educacion-superior-espejismo-evaluacion/">"The AI Mirage at University"</a> and <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">"AI won't replace you, but whoever masters it will"</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Is using AI to study cheating?</h3>
<p>Not necessarily. It is cheating if the course rule forbids it or if you hand in as your own something you do not understand. Used to ask for explanations, examples and practice, and verifying what it answers, it is a way of studying.</p>
<h3>How do I know whether my child understood or just copied?</h3>
<p>Ask them to explain the procedure in their own words and to solve a similar one without a screen. If they cannot, the assignment went well but the learning did not.</p>
<h3>Can you detect whether an AI wrote a text?</h3>
<p>Detectors are unreliable and can unfairly penalize people writing in a second language. It is more useful to redesign the task (visible process, oral defense, transfer test) than to try to detect.</p>
<h3>Does AI make students think less?</h3>
<p>It depends on the use. Evidence shows that without guardrails it can replace the effort and hurt the AI-free exam, but a tutor that gives hints neutralized that effect. Almost all studies are short-term and long-term evidence is missing.</p>
<h3>Should we ban AI at school?</h3>
<p>A total ban is hard to sustain and leaves students without learning to use it with judgment. Better: clear rules by type of task, "no AI" moments to measure what was learned, and literacy to use it well.</p>

<p class="notice"><strong>Take it to the classroom this week.</strong> Use the rubric on your next assignment, measure transfer with the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and plan scaffold-type activities with the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a>. And share this article with your students' families: the conversation is easier when everyone uses the same criterion.</p>

<h2>Food for thought</h2>
<p>If a student can get in seconds an answer that used to take an hour of effort, <strong>which part of that effort was really learning and which was just school habit?</strong> And if schools decide that what matters is what students can do without the tool, are we also willing to measure what the tool lets them achieve with it?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:evidencia}}' => $img('ia-amplia-o-reemplaza-pensamiento-evidencia', 627, 'Chart of the Bastani et al. experiment: with AI, practice rises 48% with an unguarded chatbot and 127% with a hint-giving tutor, but on the AI-free exam the chatbot drops 17% and the tutor shows no positive effect; next to three cards with other studies.', 'Evidence on AI, practice and exams. Sources: Bastani et al. (PNAS, 2025), Lee et al. (CHI 2025), OECD (2026) and MIT Media Lab (preprint).'),
    '{{img:criterio}}' => $img('ia-amplia-o-reemplaza-pensamiento-criterio', 573, 'Two columns compare AI used as a scaffold (gives hints, explains your mistake, proposes positions, offers practice) and as a crutch (hands over the solution, copied without reading, avoids effort, you could not repeat it), with the three-question test.', 'Scaffold or crutch, with the three-question test.'),
]);

return [
    'ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica' => [
        'slug' => 'ai-expanding-or-replacing-student-thinking-rubric',
        'title' => 'Is Artificial Intelligence Expanding a Student\'s Thinking or Replacing It?',
        'excerpt' => 'What the evidence says about cognitive dependence, how to tell support that expands learning from automation that avoids thinking, and a rubric for autonomy, reasoning and justification.',
        'seo_title' => 'AI and Student Thinking: Expanding or Replacing?',
        'seo_description' => 'Evidence on AI and cognitive dependence, a scaffold-or-crutch criterion and a rubric for autonomy and reasoning for teachers and families.',
        'focus_keyword' => 'AI and student thinking',
        'cover' => '/assets/img/articulos/ia-amplia-o-reemplaza-pensamiento/ia-amplia-o-reemplaza-pensamiento-portada-en',
        'cover_alt' => 'Cover with the title "Is AI expanding a student\'s thinking or replacing it?" and two cards: scaffold, which helps you reach further, and crutch, which thinks for you.',
        'content_html' => $html,
    ],
];
