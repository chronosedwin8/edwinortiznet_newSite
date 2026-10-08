<?php

declare(strict_types=1);

// English version of «Copilot y agentes en Excel». Key is the Spanish slug.
// Nowdoc keeps formulas ($, <, &) literal; <pre><code> blocks are escaped automatically and figures
// are inserted from {{img:…}} markers. Facts checked on October 8, 2026, with linked sources.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/copilot-excel/' . $name . '-en';
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
<p>A year ago the promise sounded perfect: type <code>=COPILOT("Classify this comment", B2)</code> in a cell, fill it down and watch artificial intelligence complete a thousand rows. Many colleagues wrote to me, excited. Today that function no longer exists, not because the idea was bad, but because Microsoft decided to put natural language somewhere else: a Copilot pane that no longer just answers, but <strong>plans, edits the workbook, creates columns, formulas and PivotTables, and works with agents</strong>.</p>
<p>In this guide I explain, with sources checked on October 8, 2026, what Excel offers today, how to ask Copilot to classify and summarize, which agents exist and what Copilot Pages is for. Above all, I give you exact prompts, formulas and code for small businesses, accountants, HR, teachers, school leaders and analysts, because a tool that is never tested on a real case is just news.</p>

{{img:flujo}}

<h2>What Excel offers today (October 2026)</h2>
<p>Microsoft changes names and buttons almost every month, so let me start with the map. This is what is current, with its source:</p>
<table>
<thead><tr><th>Feature</th><th>What it does</th><th>Status</th></tr></thead>
<tbody>
<tr><td>Copilot Chat in Excel</td><td>Answers questions, explains formulas and summarizes data without changing the workbook</td><td>Available in the Copilot pane</td></tr>
<tr><td>Agent Mode</td><td>Edits the workbook in several steps: columns, formulas, PivotTables, charts</td><td>Generally available since January 2026; the default since April</td></tr>
<tr><td>Plan Mode</td><td>Shows the steps and data it will use before touching the sheet</td><td>Generally available since May 2026</td></tr>
<tr><td>Model choice</td><td>Auto, or OpenAI and Anthropic models you pick</td><td>Available; Grok through the Frontier program</td></tr>
<tr><td>Personalization and workbook rules</td><td>Your standing instructions, or a <em>.Rules</em> sheet that travels with the file</td><td>Available since June 2026</td></tr>
<tr><td>Change history with Copilot</td><td>Explains what changed, who changed it and undoes specific edits</td><td>Available since September 1, 2026</td></tr>
<tr><td>The <code>=COPILOT()</code> function</td><td>Called AI from a cell</td><td>Retired on September 14, 2026</td></tr>
</tbody>
</table>
<p>The details: Agent Mode reached Excel for the web in December 2025 and Windows on January 27, 2026, with a switcher between OpenAI and Anthropic models, according to the <a href="https://techcommunity.microsoft.com/blog/excelblog/agent-mode-in-excel-is-now-generally-available-on-desktop/4457408" target="_blank" rel="noopener">official Excel blog</a>. On April 22, 2026, Microsoft announced that these capabilities became <a href="https://www.microsoft.com/en-us/microsoft-365/blog/2026/04/22/copilots-agentic-capabilities-in-word-excel-and-powerpoint-are-generally-available/" target="_blank" rel="noopener">the default experience in Word, Excel and PowerPoint</a> for Microsoft 365 Copilot, Premium, Personal and Family. <a href="https://www.microsoft.com/en-us/microsoft-365/roadmap?searchterms=560338" target="_blank" rel="noopener">Plan Mode</a> launched in May, and July added <a href="https://techcommunity.microsoft.com/blog/excelblog/whats-new-in-excel-july-2026/4523403" target="_blank" rel="noopener">GPT-5.6 and Claude Opus 5</a>, plus support for workbooks with AutoSave turned off on Windows and Mac. Since February, Agent Mode also works with <a href="https://techcommunity.microsoft.com/blog/microsoft365insiderblog/agent-mode-in-excel-now-works-with-your-local-files/4497675" target="_blank" rel="noopener">files saved on your computer</a>.</p>

<h2>What happened to =COPILOT(), and how do you do the same today?</h2>
<p>Microsoft’s <a href="https://support.microsoft.com/office/copilot-function-5849821b-755d-4030-a38b-9e20be0cbf62" target="_blank" rel="noopener">support page</a> is clear: since September 14, 2026 the function is no longer available; results that were already calculated stay as cached values, but when the cell recalculates it shows <em>#NAME?</em>. It never left the Insider and Frontier preview. Microsoft recommends the Copilot pane, which summarizes text, classifies data, generates content and looks things up on the web.</p>
<p>If you have a workbook that uses it, do this before anyone presses F9: copy the column, paste it as values and leave a note with the date and the prompt that was used. Then redo the task like this:</p>
<pre><code>Before (retired beta):
=COPILOT("Classify as Delivery, Price, Payments, Service or Inventory", B2)

Now, in the Copilot pane with Agent Mode:
In the Comments table add a Topic column that classifies each comment
into ONE of these categories: Delivery, Price, Payments, Service,
Inventory or Other. Add a Sentiment column with Positive, Neutral or
Negative. Do not change the Comment column. Show me the plan first.
Finally, on a new sheet, create a PivotTable counting Topic by Sentiment.</code></pre>
<p>The underlying difference matters: the function recalculated and could change its answer; Agent Mode writes the result into the sheet as data you can audit, filter and compare. For long text, Microsoft also documents how to <a href="https://support.microsoft.com/topic/cecc7821-39c1-4e12-8bd6-4d4348370585" target="_blank" rel="noopener">get themes, sentiment and summaries</a> from a text column, with numbered citations pointing to the source rows.</p>

<h2>Classify and summarize in plain language: three prompts and what to expect</h2>
<p>Imagine a <em>Comments</em> table with 1,200 answers from a store’s customers. These are the prompts I use, in order:</p>
<pre><code>1) Explore (Copilot Chat, no edits):
What are the five most frequent topics in Comments[Comment]? For each
one, give me a verbatim example and the approximate number of rows.

2) Classify (Agent Mode):
Using those five topics plus "Other", add the Topic column. If a
comment touches two topics, pick the main one and write the second in
a Topic2 column. Mark the ones you don't understand as "Review".

3) Summarize to decide:
On the Summary sheet write three findings with their figure, citing
the range each number comes from, and two concrete actions for the month.</code></pre>
<p>The expected output is a <em>Topic</em> column with values such as <em>Delivery</em>, <em>Payments</em> or <em>Other</em>; a PivotTable with, say, 412 <em>Delivery</em> comments, 318 of them negative; and a paragraph like “34% of comments mention late deliveries, concentrated in weekend orders.” Now comes what separates a professional from an amateur: <strong>checking</strong>. These formulas don’t depend on AI:</p>
<pre><code>Unclassified rows:        =COUNTBLANK(Comments[Topic])
Invented categories:      =SUM(--ISNA(XMATCH(Comments[Topic], Categories[Topic])))
Reconcile with PivotTable: =ROWS(Comments) - Summary!B10   (B10: grand total)
Sample of 20 to read:     =TAKE(SORTBY(Comments, RANDARRAY(ROWS(Comments))), 20)</code></pre>
<p>If the second formula isn’t zero, Copilot created a category you didn’t ask for; if the third isn’t zero, the PivotTable doesn’t cover every row. And reading twenty random comments with their label tells you in five minutes whether the classification makes sense.</p>
<p>No Copilot? For categories with stable keywords, a classic formula is free, instant and always gives the same result. With a <em>Keywords</em> table (Keyword and Topic columns):</p>
<pre><code>=LET(t, LOWER([@Comment]),
     hit, ISNUMBER(SEARCH(Keywords[Keyword], t)),
     IFERROR(INDEX(FILTER(Keywords[Topic], hit), 1), "Review"))</code></pre>
<p>It works in Microsoft 365 and Excel 2021 (LET, FILTER). AI is then reserved for what truly requires understanding language: irony, mixed complaints, comments without keywords.</p>

<h2>Before you ask: rules Copilot always follows</h2>
<p>Since June 2026 you can write your preferences once. <a href="https://techcommunity.microsoft.com/blog/excelblog/new-ways-to-customize-how-copilot-edits-your-workbooks/4527307" target="_blank" rel="noopener">Personalization</a> stores your rules for every workbook, and <strong>workbook rules</strong> live in a sheet whose name ends in <em>.Rules</em>, one rule per row in column A. This is the one I put in my templates:</p>
<pre><code>Sheet: Template.Rules (column A)
Never merge cells; use "Center Across Selection".
Write formulas with structured table references, not fixed ranges.
Do not paste values where a formula belongs.
Currency format: $#,##0 with no decimals.
Every summary sheet has a "Control" cell that compares its total with
the total of the source table.
Never write student or employee names: use the ID code.</code></pre>
<p>Because the sheet travels with the file, everyone who uses Copilot in that workbook follows the same rules. For a school or a small business with several people editing, that is gold.</p>

<h2>Step-by-step practical scenarios</h2>
<h3>Small businesses: sales and inventory</h3>
<p>A store with a <em>Sales</em> table (Date, Product, Category, Units, Total) and an <em>Inventory</em> table (Product, Stock, Cost). This is an outcome-based prompt, as Microsoft recommends:</p>
<pre><code>Use the Sales and Inventory tables. Show me the plan first. Then:
1) Create a Summary sheet with total sales by category and month,
   using formulas (no pasted values).
2) In Inventory add "Days of stock" based on average daily sales over
   the last 90 days.
3) Highlight in red the products with fewer than 15 days.
4) Add a Control cell comparing the summary total with SUM(Sales[Total]);
   it must be 0.</code></pre>
<p>What you should see in the sheet, and what you must review formula by formula:</p>
<pre><code>Summary (A3):
=PIVOTBY(Sales[Category], TEXT(Sales[Date], "yyyy-mm"), Sales[Total], SUM)

Days of stock (column in Inventory):
=LET(avg, SUMIFS(Sales[Units], Sales[Product], [@Product],
                 Sales[Date], ">=" & TODAY() - 90) / 90,
     IF(avg = 0, "No sales", ROUND([@Stock] / avg, 0)))

Control:
=SUM(Sales[Total]) - TAKE(A3#, -1, -1)</code></pre>
<p>If the control isn’t zero, don’t present the report. And once the analysis tells you which products move, the next step is usually operational: labeling stock with the <a href="/producto/generador-de-etiquetas-para-inventario-de-activos-fijos-en-excel-con-qr-y-codigos-de-barras/">fixed asset label generator with QR and barcodes</a> or invoicing with the <a href="/producto/factura-con-envio-por-correo-al-cliente/">invoice template that emails the customer</a>. That needs no AI: it needs a template that never fails.</p>

<h3>Finance and accounting: bank reconciliation</h3>
<p>With <em>Bank</em> and <em>Ledger</em> tables, the prompt:</p>
<pre><code>Reconcile Bank against Ledger by Reference and Amount. Add a Status
column to Bank with Matched, Pending or Duplicate in ledger. Use
formulas, not values. Then explain the 10 largest pending items and
what pattern you see (dates, counterparties, fees). Do not delete or
change any original row.</code></pre>
<p>The formula you should find in the Status column, easy to audit:</p>
<pre><code>=LET(n, COUNTIFS(Ledger[Reference], [@Reference], Ledger[Amount], [@Amount]),
     IF(n = 1, "Matched", IF(n = 0, "Pending", "Duplicate in ledger")))

Pending amount: =SUMIF(Bank[Status], "Pending", Bank[Amount])</code></pre>
<p>If the reconciliation repeats every month, turn it into a button. This Office Script (TypeScript, Automate tab in Excel for the web and Windows, with a work or school account) highlights unmatched items and counts them:</p>
<pre><code>function main(workbook: ExcelScript.Workbook) {
  const bank = workbook.getTable("Bank");
  const ledger = workbook.getTable("Ledger");
  const key = (r: (string | number | boolean)[], iRef: number, iAmt: number) =>
    `${String(r[iRef]).trim()}|${Number(r[iAmt]).toFixed(2)}`;

  const lh = ledger.getHeaderRowRange().getValues()[0] as string[];
  const inLedger = new Set(ledger.getRangeBetweenHeaderAndTotal().getValues()
    .map(r => key(r, lh.indexOf("Reference"), lh.indexOf("Amount"))));

  const bh = bank.getHeaderRowRange().getValues()[0] as string[];
  const body = bank.getRangeBetweenHeaderAndTotal();
  body.getFormat().getFill().clear();
  let pending = 0;
  body.getValues().forEach((row, i) => {
    if (!inLedger.has(key(row, bh.indexOf("Reference"), bh.indexOf("Amount")))) {
      body.getRow(i).getFormat().getFill().setColor("#FFF2CC");
      pending++;
    }
  });
  console.log(`Bank items without a match: ${pending}`);
}</code></pre>
<p>And when several people touch the same workbook, the <a href="https://techcommunity.microsoft.com/blog/excelblog/copilot-in-excel-bringing-clarity-to-collaborative-workbooks/4552007" target="_blank" rel="noopener">change history skill</a> answers questions like “what changed on this sheet since Monday and who did it?” or “undo only last week’s Copilot edits and keep the manual ones.” In accounting, that traceability is worth as much as the reconciliation itself.</p>

<h3>HR: absenteeism and exit interviews</h3>
<p>The golden rule here is privacy: work with ID codes, not names or diagnoses. A useful prompt for the text column of exit interviews:</p>
<pre><code>In ExitInterviews[Reason] identify the reasons for leaving and group
them into at most six categories. Add a Category column and a table
counting Department by Category. Do not use or show the ID column in
the summary. Flag any department with fewer than five cases, so we
don't publish figures that identify people.</code></pre>
<p>For the absenteeism rate by department, a single formula:</p>
<pre><code>=LET(a, GROUPBY(Staff[Department],
            HSTACK(Staff[Hours absent], Staff[Scheduled hours]), SUM, 0, 0),
     HSTACK(INDEX(a,, 1), INDEX(a,, 2) / INDEX(a,, 3)))</code></pre>
<p>And if you then have to send each employee their certificate or pay stub, that is automation work, not AI: <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">mail merge to individual PDFs</a> and <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">bulk emails with attachments</a> do it in minutes.</p>

<h3>Teachers and school leaders: grades, attendance and reports</h3>
<p>With a <em>Grades</em> table (ID, Class, Subject, Grade) and your school’s <em>Scale</em> table, the performance level is a formula, not AI:</p>
<pre><code>Level:  =XLOOKUP([@Grade], Scale[From], Scale[Level], "No grade", -1)

Students at risk (Low in 2 or more subjects or absences above 15%):
=FILTER(Summary[ID], (Summary[Subjects at Low] >= 2) + (Summary[% absences] > 0.15), "Nobody at risk")</code></pre>
<p>Where Copilot does help is the report. This prompt saves me an afternoon before every grading committee:</p>
<pre><code>Using the Summary table (student ID codes, never names) write for each
class a paragraph of at most 80 words for the grading committee:
number of students at Low by subject, relation to absences and one
concrete teaching action. Cite the cell or range of every figure.
Make no judgments about families or diagnoses.</code></pre>
<p>A reminder that is not optional: children’s data has reinforced protection in most countries; in Colombia, for example, article 7 of <a href="https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=49981" target="_blank" rel="noopener">Law 1581 of 2012</a>. Use your school account, codes instead of names, and aggregate before sharing. If you track attendance in Excel, my <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">attendance list template</a> already has the calculations. For classroom work with AI, I built the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> with tested prompts by subject, the <a href="/herramientas/generador-de-examenes/">AI exam generator</a> (try the <a href="/examenes/demo/">demo</a>) and <a href="/herramientas/piar/">PIAR with AI</a> for individual accommodation plans (these tools are in Spanish).</p>

<h3>Data analysts: Python in Excel plus Copilot</h3>
<p><a href="https://support.microsoft.com/office/python-in-excel-availability-781383e6-86b9-4156-84fb-93e786f7cab0" target="_blank" rel="noopener">Python in Excel</a> is available for business accounts on Windows and the web, and in preview for Personal and Family. Two <code>=PY</code> cells I use as a starting point:</p>
<pre><code># =PY cell 1: outliers in Total using the interquartile range
df = xl("Sales[#All]", headers=True)
q1, q3 = df["Total"].quantile([0.25, 0.75])
limit = q3 + 1.5 * (q3 - q1)
df[df["Total"] > limit].sort_values("Total", ascending=False)

# =PY cell 2: monthly trend and three-month projection
import numpy as np
df["Month"] = pd.to_datetime(df["Date"]).dt.to_period("M").astype(str)
m = df.groupby("Month")["Total"].sum()
x = np.arange(len(m))
slope, intercept = np.polyfit(x, m.values, 1)
pd.DataFrame({"Month": [f"+{i}" for i in (1, 2, 3)],
              "Projection": [round(intercept + slope * (len(m) - 1 + i)) for i in (1, 2, 3)]})</code></pre>
<p>Since August, Insiders can ask Copilot to write those cells with the <a href="https://techcommunity.microsoft.com/blog/excelblog/whats-new-in-excel-august-2026/4527283" target="_blank" rel="noopener">Python skill</a>: “@python-in-excel detect outliers in Sales[Total] by category with the IQR method and explain the code line by line.” Note that, according to <a href="https://support.microsoft.com/en-us/excel/copilot/copilot-in-excel-built-in-skills" target="_blank" rel="noopener">Microsoft support</a>, @ skills currently work only when Office is in English. For analysis across several files, the Analyst agent, covered next, writes and runs Python and shows you the code; that transparency is what lets you audit it.</p>

<h2>The agents: who is who</h2>
{{img:agentes}}
<ul>
<li><strong>Analyst</strong> plans the analysis, writes and runs Python, cleans data and returns charts and commentary from files you attach (<a href="https://support.microsoft.com/topic/ff505b9c-a06c-4be9-b855-69d89b1d25d2" target="_blank" rel="noopener">Microsoft guide</a>). Sample prompt: “I’m attaching Sales_2025.xlsx and Inventory.csv. Compare turnover by category and quarter, identify the ten products with the most days of stock and show me the code you used.”</li>
<li><strong>Researcher</strong> does multi-step research with web and work sources. Both launched for business customers in June 2025, then with <a href="https://www.microsoft.com/en-us/microsoft-365/blog/?p=276953" target="_blank" rel="noopener">25 combined queries per month</a>; check the current limits for your plan.</li>
<li><strong>The Excel agent</strong> in the Microsoft 365 Copilot app creates a complete workbook from the chat; according to <a href="https://support.microsoft.com/topic/76691f5e-bb19-4029-a34d-33a00e0a0c4f" target="_blank" rel="noopener">support</a>, people without a Copilot license can use it too, with web information and files they reference.</li>
<li><strong>Agent Builder and Copilot Studio</strong> create your own agents. Microsoft Learn sums it up: <a href="https://learn.microsoft.com/en-us/microsoft-365-copilot/extensibility/copilot-studio-experience" target="_blank" rel="noopener">Agent Builder</a> for simple no-code agents for you or your team; Copilot Studio for multi-step flows, connectors and broad publishing. Without a Copilot license they run on Copilot Credits or pay-as-you-go, and Agent Builder is free if the agent only uses web knowledge.</li>
<li><strong>Copilot Cowork</strong>, generally available since June 2026, runs long tasks across apps with <a href="https://techcommunity.microsoft.com/blog/microsoft-copilot-blog/what%E2%80%99s-new-in-microsoft-365-copilot--june-2026/4529572" target="_blank" rel="noopener">usage-based billing</a>.</li>
</ul>
<p>These are the instructions of an agent I set up with Agent Builder for a grading committee; copy and adapt them:</p>
<pre><code>Name: Grading committee assistant
Knowledge: "Committee 2026" folder (assessment policy, minutes and grade books with ID codes)

Instructions:
- Answer only from the files in the folder. If a fact is not there,
  say so; never estimate it.
- Never show names, ID numbers or health data: always use the
  student code.
- Every figure must state the file, sheet and range it comes from.
- Suggest concrete teaching actions and mark which ones need a
  committee decision.
- Respectful tone, with no judgments about families.

Conversation starters:
- "Summarize the Low cases in grade 9 for term 3"
- "What does our assessment policy say about make-up activities?"</code></pre>

<h2>Copilot Pages: from analysis to a team document</h2>
<p><a href="https://support.microsoft.com/en-us/microsoft-365-copilot/get-started-with-microsoft-365-copilot-pages" target="_blank" rel="noopener">Copilot Pages</a> turns a Copilot answer into a persistent page you edit, share and refine with your team and with Copilot. You create one with <em>Edit in Pages</em> from a response’s menu, or from the chat’s + button, under <em>More</em>, with the option to draft a page. With a work account, anyone with OneDrive or SharePoint storage can use it, even without a Copilot license; with a personal account, Personal, Family, Premium or Pro subscribers. It supports interactive charts, and the team can co-edit without entering your chat. One caveat from <a href="https://support.microsoft.com/en-us/microsoft-365-copilot/how-microsoft-365-copilot-pages-works" target="_blank" rel="noopener">Microsoft itself</a>: when several people edit at once, Copilot’s answer may not reflect every change until you refresh the page.</p>
{{img:pages}}
<p>This is how I use it with an Excel analysis: Analyst or Copilot in Excel produce the summary; I move it to Pages; the coordinator adds the tutoring plan; a teacher checks the totals against the PivotTable and leaves a comment; and since June 2026 I can <a href="https://techcommunity.microsoft.com/blog/excelblog/whats-new-in-excel-june-2026/4523402" target="_blank" rel="noopener">attach Loop pages</a> as context in Copilot in Excel for the next question. The page becomes the living record of the decision, not one more email nobody can find.</p>
<pre><code>Prompt inside the page:
Turn these findings into a table with Class, Finding, Figure, Source
(file and range), Action and Owner columns. Leave Owner empty so the
committee can fill it in.</code></pre>

<h2>Licensing: what you need in each case</h2>
<table>
<thead><tr><th>Your situation</th><th>Copilot inside Excel</th><th>Agents and Pages</th></tr></thead>
<tbody>
<tr><td>Microsoft 365 Personal or Family</td><td>Yes, with monthly AI credits and only for the subscription owner</td><td>Pages, yes</td></tr>
<tr><td>Microsoft 365 Premium (US$19.99 a month in the US)</td><td>Yes, with the highest limits</td><td>Researcher, Analyst and Pages</td></tr>
<tr><td>Organization with a Microsoft 365 Copilot license</td><td>Full: Agent Mode, models, chat history, Work IQ</td><td>All of them, plus Agent Builder and Copilot Studio</td></tr>
<tr><td>Unlicensed, organization with more than 2,000 seats</td><td>No, since April 15, 2026</td><td>Copilot Chat on the web, Word, Excel and PowerPoint agents, Pages</td></tr>
<tr><td>Unlicensed, organization with up to 2,000 seats</td><td>Copilot Chat with standard access, subject to capacity</td><td>Same as the previous row</td></tr>
</tbody>
</table>
<p>Sources: <a href="https://support.microsoft.com/office/frequently-asked-questions-about-copilot-in-microsoft-365-subscriptions-bda0d6e8-346d-41ce-ab1e-f6af6229c462" target="_blank" rel="noopener">Copilot FAQ for home plans</a>, the <a href="https://www.microsoft.com/en-us/copilot/blog/2025/10/01/meet-microsoft-365-premium-your-ai-and-productivity-powerhouse/" target="_blank" rel="noopener">Microsoft 365 Premium announcement</a> and the change for unlicensed users announced in messages MC1253858 and MC1253863, summarized by <a href="https://kurtsh.com/2026/04/05/info-copilot-chat-behavior-changes-for-microsoft-365-users-coming-april-15-2026/" target="_blank" rel="noopener">Kurt Shintaku</a>. In Family, although the plan covers six people, AI features belong to the owner only. In organizations, Analyst and Researcher require the Microsoft 365 Copilot license. You will also see a name change: Microsoft Learn documentation already calls Microsoft 365 Copilot <em>Microsoft Copilot</em> and Copilot Chat <em>Microsoft Copilot Chat</em>; both names coexist during the transition.</p>

<h2>Privacy and governance: what every leader should know</h2>
<ul>
<li><strong>Enterprise data protection.</strong> With a work account, prompts and responses fall under Microsoft’s Data Protection Addendum and <a href="https://learn.microsoft.com/en-us/copilot/microsoft-365/enterprise-data-protection" target="_blank" rel="noopener">aren’t used to train foundation models</a>. Copilot respects permissions, sensitivity labels, retention and auditing.</li>
<li><strong>Sensitivity labels.</strong> If an encrypted file lets you view but not copy (the EXTRACT right), <a href="https://learn.microsoft.com/en-us/purview/ai-m365-copilot-considerations" target="_blank" rel="noopener">you won’t be able to use Copilot with it</a>. It is a simple way to protect payroll or medical records.</li>
<li><strong>Anthropic models.</strong> In business accounts, the admin must <a href="https://support.microsoft.com/topic/b2c3b3ec-154b-484b-84d0-914a80df395a" target="_blank" rel="noopener">enable them</a>; Anthropic acts as a subprocessor, and its models are currently excluded from the EU Data Boundary.</li>
<li><strong>Web searches.</strong> Queries Copilot sends to Bing leave without user or tenant identifiers, but they are governed by terms different from Microsoft 365’s.</li>
</ul>

<h2>Limitations and how to verify</h2>
<p>Copilot is very good at writing formulas and building tables, but it can confidently invent a figure in a summary. Microsoft says so in its <a href="https://support.microsoft.com/topic/cecc7821-39c1-4e12-8bd6-4d4348370585" target="_blank" rel="noopener">own documentation</a>: review, edit and verify anything Copilot creates. My minimum checklist before signing:</p>
<ol>
<li>Require formulas, not pasted values, and open at least three to read them.</li>
<li>Add a control cell comparing each summary with the sum of its source; it must be 0.</li>
<li>Hover over the numbered citations and check they point to the right rows.</li>
<li>Read a random sample of what Copilot classified.</li>
<li>Use Plan Mode for big tasks and don’t approve a plan you don’t understand.</li>
<li>After several edits, ask the change history what changed.</li>
<li>If the result goes to someone with Excel 2019 or 2021, check it doesn’t use functions their version lacks.</li>
</ol>

<h2>No Copilot? Free alternatives</h2>
<p>If your school or company has no license, ChatGPT, Gemini or Claude write and explain formulas for any Excel version; the key is to describe the structure and never paste personal data. I explained it in detail in <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel with artificial intelligence: practical examples</a>, where I also give away the <strong>ExcelConIA</strong> module: the PerfilarDatos macro profiles your table, GenerarPromptIA builds a prompt without personal data and the <code>=IA_CLASIFICAR(B2, $H$2:$H$6)</code> function classifies from a cell with your own free Google Gemini key. In practice, it brings back the convenience of the retired function in any Windows Excel. You can <a href="/descargas/excel-con-ia/excel-con-ia.zip">download the full package for free</a>, and for single tasks there are the free <a href="/herramientas/numero-a-letras/">number to words</a> and <a href="/herramientas/generador-qr/">QR code</a> tools.</p>

<p class="notice"><strong>Take it to your work.</strong> AI helps you analyze; the tasks you repeat every week deserve a template that always does the same thing. In the <a href="/excel/">Excel and automation</a> section you will find <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">bulk emails with attachments</a>, <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">mail merge to PDF</a>, the <a href="/producto/generador-de-codigos-qr-masivos/">bulk QR code generator</a> and the <a href="/producto/factura-con-envio-por-correo-al-cliente/">invoice that emails the customer</a>. If you teach, start with the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> and the <a href="/herramientas/generador-de-examenes/">exam generator</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Can I still type natural language “inside the cell”?</h3>
<p>Not with <code>=COPILOT()</code>, which was retired. Today you do it from the Copilot pane: Agent Mode writes columns, formulas and PivotTables into the sheet as auditable data. If you need a cell function, one alternative is the <code>=IA()</code> function in the free ExcelConIA module, with your own key.</p>
<h3>Does Copilot replace formulas?</h3>
<p>No. Copilot writes them for you, but the reliable result is still a formula someone can read. That’s why I always ask for formulas instead of values and a control cell.</p>
<h3>Which model should I pick?</h3>
<p>Start with Auto. If a complex task goes wrong, repeat it with another model and compare: that comparison is a cheap way to catch errors.</p>

<h2>Food for thought</h2>
<p>For decades, the most important moment in working with data was that awkward silence when someone looked at a figure and said “this can’t be right.” Today one click on “Approve plan” is enough for an agent to classify, summarize and suggest which students go to make-up classes or which supplier to stop buying from. <strong>If that click becomes routine, who answers when the agent is wrong: the person who approved without reading, the institution that asked for speed, or the company that designed the model? And are we willing to measure productivity by how many plans we approve, or by how many times we stopped to doubt?</strong></p>
HTML;

$html = strtr($code($html), [
    '{{img:flujo}}' => $img('copilot-excel-flujo', 580, 'Five-step diagram from question to result with Copilot in Excel: ask (Copilot Chat, skills with @, .Rules sheet), plan (Plan Mode, Auto model), act (Agent Mode, GROUPBY, =PY), verify (control SUM, change history) and share (Copilot Pages, Teams and Outlook), with who does each step', 'Copilot does the work in the middle; the question and the verification are still yours.'),
    '{{img:agentes}}' => $img('copilot-excel-agentes', 640, 'Agent map in four groups: inside Excel (Copilot Chat, Agent Mode and Plan Mode, skills with @), Microsoft agents in the Microsoft 365 Copilot app (Analyst, Researcher, Excel agent), your own agents (Agent Builder and Copilot Studio) and long-running work (Copilot Cowork and automations), with the license each group requires', 'Which agent to use for each kind of data work and which license each one needs.'),
    '{{img:pages}}' => $img('copilot-excel-pages', 600, 'Copilot Pages flow in four steps (analyze, edit in Pages, collaborate, decide and return) and a sample page titled Grading committee term 3, with findings by class, a chart of students at Low level by class, three co-authors and a comment from a teacher who checked the totals against the PivotTable', 'A Copilot page turns an Excel analysis into the living record of a team decision.'),
]);

return [
    'copilot-agentes-excel-lenguaje-natural-copilot-pages' => [
        'slug' => 'copilot-agents-excel-natural-language-copilot-pages',
        'title' => 'Copilot and Agents in Excel: Natural Language, Classification, Summaries and Copilot Pages',
        'excerpt' => 'What Copilot offers in Excel today (Agent Mode, Plan Mode, model choice), what happened to the =COPILOT() function, how to classify and summarize with real prompts, which agents exist, what Copilot Pages is for, which license you need and how to verify, with formulas and code for small businesses, finance, HR, teachers and analysts.',
        'seo_title' => 'Copilot and Agents in Excel: A Practical 2026 Guide',
        'seo_description' => 'Copilot in Excel today: Agent Mode, the end of =COPILOT(), Analyst and Researcher agents, Copilot Pages, licensing and prompts with formulas for real work.',
        'focus_keyword' => 'Copilot in Excel',
        'cover' => '/assets/img/articulos/copilot-excel/copilot-excel-portada-en',
        'cover_alt' => 'Copilot and agents in Excel cover: Comments.xlsx sheet with Topic and Sentiment columns, Copilot pane in Agent Mode with a three-step plan, and a card with Analyst, Researcher and Copilot Pages',
        'content_html' => $html,
    ],
];
