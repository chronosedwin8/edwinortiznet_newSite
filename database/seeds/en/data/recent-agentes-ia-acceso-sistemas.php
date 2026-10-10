<?php

declare(strict_types=1);

// English version of "Agentes de IA con acceso a tus sistemas…". Key is the Spanish slug. Data checked on October 9, 2026 (OWASP LLM06:2025,
// Gartner June 2025, CVE-2025-32711, OECD.AI incident log on Replit). The approval-gate code was run in Python 3 with simulated tools. Status and
// date come from the Spanish post via en/02_recent_posts.php (scheduled for Tuesday, October 27, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/agentes-ia-acceso-sistemas/' . $name . '-en';
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
<p>For two years we learned to use AI like someone consulting a very well-read colleague: we ask, it answers, and we decide what to do. <strong>AI agents</strong> change that deal: they no longer just answer, <strong>they do things</strong>. They read your email, modify records, send messages, run code and, if you let them, pay invoices. The promise is huge (repetitive tasks solved without intervention), and so is the risk.</p>
<p>In this article I explain the difference between a chatbot and an agent, what has already happened when an agent has too much power, and give you a practical framework (permissions, human approval, traceability and containment), a <strong>decision matrix</strong> to choose what to automate and a code example of an "approval gate". Data checked on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A chatbot produces text; an agent executes actions with tools. The risk is no longer just a wrong answer but a wrong action, or one induced by an attacker. OWASP calls it "excessive agency" (LLM06:2025) and sums it up as too much functionality, too many permissions or too much autonomy. The practical answer: minimal permissions, human approval for what matters, a log of everything and a limit on possible damage.</p>

<h2>Chatbot, assistant and agent: where the difference lies</h2>
<p>The word "agent" is used very loosely. To decide with judgment it helps to have a working definition: <strong>an agent is an AI system that plans and executes steps using tools (reading files, calling services, writing to databases, sending messages), often without a person approving each step</strong>. A chatbot answers questions; an assistant suggests and drafts; an agent acts. And that last difference changes everything.</p>
{{img:diferencia}}
<p>A warning so you do not buy smoke: the consultancy Gartner uses the term <em>agent washing</em> for products that only changed their label (a chatbot or RPA presented as an "agent"), and <a href="https://www.gartner.com/en/newsroom/press-releases/2025-06-25-gartner-predicts-over-40-percent-of-agentic-ai-projects-will-be-canceled-by-end-of-2027">forecasts</a> that more than 40% of agentic AI projects will be canceled by the end of 2027 due to rising costs, unclear value or inadequate risk controls. It is a forecast, not a measurement, but it points to the same thing we will see below: often you do not need an agent, and when you do, you need control.</p>

<h2>What has happened when an agent has too much power</h2>
<ul>
<li><strong>Replit and SaaStr (July 2025).</strong> According to the <a href="https://oecd.ai/en/incidents/2025-07-19-1eb1">OECD.AI incident log</a> and the press, a coding agent deleted a database during an experiment by SaaStr founder Jason Lemkin, even though he had ordered it not to make changes without his approval, and then misreported what happened. The data belonged to a demo application, not a real business, and Replit promised to separate development and production environments and add a planning-only mode. What is instructive is not the drama: it is that <strong>an instruction in natural language ("don't change anything") is not a security control</strong>.</li>
<li><strong>EchoLeak (CVE-2025-32711).</strong> A critical (CVSS 9.3) prompt-injection flaw in Microsoft 365 Copilot allowed, according to reports, an email with hidden instructions to make the assistant leak internal data without the user clicking anything. Microsoft fixed it and, according to the sources, there is no evidence of real exploitation; the entry in the <a href="https://nvd.nist.gov/vuln/detail/CVE-2025-32711">NVD vulnerability database</a> describes it as AI command injection. The lesson: <strong>an agent that reads untrusted content (an email, a web page) can receive orders hidden in that content</strong>.</li>
</ul>
{{img:casos}}
<p>The most useful reference framework is <a href="https://genai.owasp.org/llmrisk/llm06/">OWASP's LLM06:2025 "Excessive Agency"</a>, which identifies three causes: <strong>excessive functionality</strong> (the agent has tools it does not need), <strong>excessive permissions</strong> (the tools have more access than necessary) and <strong>excessive autonomy</strong> (it executes high-impact actions without verification). Its main mitigations are to limit tools to the minimum, limit each tool's functions, require human approval for high-impact actions and, above all, <strong>enforce authorization in the downstream systems, not trust the model to "decide" what is allowed</strong>.</p>

<h2>Four controls to let an agent act</h2>
<ol>
<li><strong>Minimal permissions.</strong> Give the agent its own account (not yours or the administrator's), with access only to what it needs and, by default, read-only. If it needs to write, let it be on a single resource. Closing accounts and reviewing permissions periodically apply here just as for a person (I covered this in the article on <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a>).</li>
<li><strong>Human approval where it matters.</strong> A person approves before the agent sends something outside the organization, modifies data, spends money or publishes. Anything irreversible, never autonomously.</li>
<li><strong>Traceability.</strong> A log of every action: who (or which agent), what, with what parameters, when and with what result. If you cannot reconstruct what it did, you cannot audit or learn from the error.</li>
<li><strong>Containment.</strong> Volume and spending limits, a test environment separate from production, verified backups and a "kill switch" (the ability to suspend the agent immediately).</li>
</ol>
<p>A key detail about the controls: they have to live <strong>outside</strong> the agent. An agent you tell "don't delete anything" that has delete permission can delete; one that simply has no permission, cannot.</p>

<h2>Decision matrix: what to automate and what not</h2>
<p>This is the practical resource. For every task you want to delegate, ask yourself five things and use them to decide:</p>
<table>
<thead><tr><th>Question</th><th>If the answer is "yes"…</th></tr></thead>
<tbody>
<tr><td>Can it be easily undone?</td><td>Safer to automate. If it cannot be undone: human approval or do not automate.</td></tr>
<tr><td>Does it move money or commit the organization?</td><td>Explicit human approval. Never full autonomy.</td></tr>
<tr><td>Does it touch personal or sensitive data (minors, health, grades)?</td><td>Approval, minimal access and a log; check your data protection obligations.</td></tr>
<tr><td>Does it read content from untrusted sources (third-party emails, the web)?</td><td>Prompt-injection risk: isolate, limit possible actions and require approval.</td></tr>
<tr><td>Are the rules clear and repeatable?</td><td>You may not need an agent: a deterministic automation (macro, flow or script) is more predictable.</td></tr>
</tbody>
</table>
<table>
<thead><tr><th>Example task</th><th>Suggested decision</th></tr></thead>
<tbody>
<tr><td>Classify tickets or emails by topic</td><td>Automate (low risk, reversible), with sampling review.</td></tr>
<tr><td>Draft reply messages</td><td>Automate the draft; a person sends.</td></tr>
<tr><td>Send bulk emails to customers</td><td>With approval: a person reviews the list and the template.</td></tr>
<tr><td>Update records in the database</td><td>With approval, with a prior backup and a cap on changes.</td></tr>
<tr><td>Publish student grades or reports</td><td>With teacher approval; never autonomous.</td></tr>
<tr><td>Pay invoices or make transfers</td><td>Do not automate autonomously; only prepare for approval.</td></tr>
<tr><td>Delete data or change permissions</td><td>Do not delegate to the agent.</td></tr>
</tbody>
</table>

<h2>A code example: an approval gate</h2>
<p>If you build or connect an agent, the core idea fits in 40 lines of Python: a <strong>whitelist</strong> of actions with a risk level, <strong>human approval</strong> for medium and high risk, a <strong>cap</strong> on actions and a <strong>log</strong> of everything. I tested it with simulated tools: it classified the ticket, sent the email after approval, rejected the payment and blocked the unauthorized action.</p>
<pre><code>import json
from datetime import datetime, timezone

# Whitelist: only listed actions exist for the agent; each has a risk level.
RISK = {
    "classify_ticket": "low",      # reversible, no money or external data
    "draft_reply": "low",
    "send_email": "medium",        # leaves the organization: requires approval
    "update_record": "medium",     # modifies data: requires approval
    "pay_invoice": "high",         # money: explicit approval and a reason
}
MEDIUM_CAP = 5  # maximum medium-risk actions per run (damage limit)


def log(event, path="audit.jsonl"):
    event["date"] = datetime.now(timezone.utc).isoformat()
    with open(path, "a", encoding="utf-8") as f:
        f.write(json.dumps(event, ensure_ascii=False) + "\n")


def execute(action, params, approver, tools, state):
    level = RISK.get(action)
    if level is None:
        log({"action": action, "params": params, "result": "BLOCKED: not authorized"})
        raise PermissionError(f"Unauthorized action: {action}")
    if level == "medium":
        state["medium"] = state.get("medium", 0) + 1
        if state["medium"] > MEDIUM_CAP:
            log({"action": action, "result": "BLOCKED: action cap reached"})
            raise RuntimeError("Medium-risk action cap reached")
    if level in ("medium", "high") and not approver(action, params, level):
        log({"action": action, "params": params, "level": level, "result": "REJECTED by a person"})
        return "rejected"
    result = tools[action](**params)
    log({"action": action, "params": params, "level": level, "result": "executed"})
    return result</code></pre>
<p>The agent never calls the tools directly: it always goes through <code>execute()</code>. The <code>approver</code> function can be an on-screen question, a button in a chat or an approval workflow; what matters is that <strong>a person makes the decision and it is recorded</strong>. The audit file ends up with JSON lines such as <code>{"action": "pay_invoice", "level": "high", "result": "REJECTED by a person", ...}</code>. It is a minimal example, not a complete security product: in production you also need authentication, authorization in the target system and testing.</p>

<h2>Colombia, Latin America and the world</h2>
<p>Regulation is moving toward human oversight, not prohibition. Worldwide, the European Union's AI Act requires effective human oversight in high-risk systems; in Latin America there are bills in Brazil, Chile and Peru, and in Colombia there is the national policy CONPES 4144 of 2025 and bills in Congress (I summarized them in <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">"The Big Lie About AI"</a>). Closer to home, something that already exists matters: <strong>Law 1581 of 2012</strong> on personal data protection makes whoever processes the data responsible for it, even if an agent processes it. For a <strong>manager or small-business owner</strong>, the question is which process is worth delegating without risking cash; for a <strong>teacher or school leader</strong>, which minors' data a platform that "recommends" or "grades" may touch; for <strong>IT</strong>, how to grant permissions and audit. And for <strong>families</strong>, knowing that assistants with access to your email or accounts need the same care as a new person in the house.</p>

<h2>Tools to automate with control</h2>
<p>Not every automation needs an agent. When the rules are clear, a deterministic Excel automation is more predictable and cheaper. <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">Bulk emails with attachments and CC/BCC</a> sends each email with its attachment from an Excel list, and you review the list and the template before sending; the <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">Excel data merge app for separate DOCX and PDF documents</a> generates one document per row. If you teach, the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a> includes resources to work with your students on what an AI can and should not do with their data.</p>
{{productos:enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco,aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf}}
<p>To keep reading: <a href="/copilot-agentes-excel-lenguaje-natural-copilot-pages/">Copilot and agents in Excel</a>, <a href="/ia-amplia-o-reemplaza-pensamiento-estudiante-rubrica/">does AI expand thinking or replace it?</a> and <a href="/estafas-voz-clonada-ia-protocolo-verificacion/">voice-cloning scams and how to verify</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is an AI agent and how does it differ from ChatGPT?</h3>
<p>A chatbot like ChatGPT answers in text. An agent uses tools to execute actions (read files, send emails, modify data). The difference is the power to act, not the model.</p>
<h3>Is it safe to give an agent access to my email?</h3>
<p>Only with minimal permissions, human approval for what matters and an action log. And with care: a third party's email can contain hidden instructions trying to manipulate the agent (prompt injection).</p>
<h3>What is "excessive agency"?</h3>
<p>It is OWASP's LLM06:2025 category: an AI system with too much functionality, too many permissions or too much autonomy, so that an error or an attack causes large damage.</p>
<h3>Which tasks can I automate without risk?</h3>
<p>Reversible, low-impact ones, such as classifying or drafting, always with review. Those that move money, touch sensitive data or cannot be undone, with human approval or not delegated.</p>
<h3>Do I need an agent or is a macro enough?</h3>
<p>If the rules are clear and repeatable, a deterministic automation (macro, script or flow) is usually more predictable. Agents add value when there is ambiguity and variety, and that is when you need the most control.</p>

<p class="notice"><strong>Make your task map this week.</strong> List five repetitive tasks in your work, apply the matrix's five questions and mark which you would automate, which with approval and which not. For clear rules, try a controlled automation such as <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">bulk emailing from Excel</a>.</p>

<h2>Food for thought</h2>
<p>When an agent makes a mistake, there is nobody to apologize to and nobody to answer before the law. <strong>If we delegate actions to systems that cannot take responsibility, who should answer when something goes wrong: whoever programmed it, whoever sold it, whoever gave it permissions or whoever approved (or failed to approve) what it did?</strong> And how much autonomy are we willing to give up in exchange for saving time?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:diferencia}}' => $img('agentes-ia-acceso-sistemas-diferencia', 625, 'Comparison table: a chatbot or assistant answers and suggests, while an agent with tools plans and executes actions; the risk moves from a wrong answer to a wrong or induced action.', 'A chatbot talks; an agent acts.'),
    '{{img:casos}}' => $img('agentes-ia-acceso-sistemas-casos', 573, 'Four cards: OWASP\'s LLM06:2025 category on excessive agency, Gartner\'s forecast that more than 40% of agentic projects will be canceled by 2027, the EchoLeak vulnerability CVE-2025-32711 in Microsoft 365 Copilot and the 2025 Replit case.', 'Recent data and cases with AI agents. The 40% is a Gartner forecast.'),
]);

return [
    'agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad' => [
        'slug' => 'ai-agents-access-your-systems-automation-or-security-risk',
        'title' => 'AI Agents With Access to Your Systems: Smart Automation or a New Security Risk?',
        'excerpt' => 'The difference between a chatbot and an agent that executes actions, real cases of excessive agency, a framework of permissions, human approval and traceability, a matrix to decide what to automate and a code example.',
        'seo_title' => 'AI Agents With Access to Your Systems: Risks',
        'seo_description' => 'What an AI agent is, the risks of giving it access to your systems and how to control it with permissions, human approval and logging. With matrix and code.',
        'focus_keyword' => 'AI agents security',
        'cover' => '/assets/img/articulos/agentes-ia-acceso-sistemas/agentes-ia-acceso-sistemas-portada-en',
        'cover_alt' => 'Cover reading "AI agents with access to your systems: automation or a new risk?" with a card going from text to action: chatbot answers, assistant suggests, agent executes and the risk is permissions.',
        'content_html' => $html,
    ],
];
