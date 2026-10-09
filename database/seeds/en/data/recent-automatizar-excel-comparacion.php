<?php

declare(strict_types=1);

// English version of «Power Query, VBA, Office Scripts o Python: ¿cuál es la mejor forma de automatizar Excel?». Key is the Spanish slug. Test of
// October 9, 2026: 12 workbooks of 10,000 rows consolidated with Power Query (6.7 s; 3.7 s refresh), VBA (7.5 s) and Python with pandas (7.0 s), all
// giving 120,000 rows and a Value sum of 11,111,254,600. Office Scripts were NOT executed. Status and date come from the Spanish post via
// en/02_recent_posts.php (scheduled for Thursday, October 29, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/automatizar-excel-comparacion/' . $name . '-en';
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
<p>"What is the best way to automate Excel?" is a question that almost always gets a wrong answer, because it is badly framed. There is no "best" tool: there is a suitable tool for your task, your machine, your license and the person who will maintain the solution two years from now. To make the comparison concrete, <strong>I solved the same task with four tools</strong>: consolidating 12 monthly sales workbooks (120,000 rows) into a single table.</p>
<p>In this article I show you each alternative's code, the times I measured, each one's real requirements (with their limits) and a <strong>decision matrix</strong> to choose. One clarification: the title mentions 2027, but I can only state what exists and what I verified as of October 9, 2026; tools change, the method of deciding does not.</p>
<p class="notice"><strong>Summary.</strong> In my test, Power Query (6.7 s; 3.7 s on refresh), VBA (7.5 s) and Python with pandas (7.0 s) consolidated 120,000 rows with exactly the same result. Speed does not decide: what decides is where it runs, who maintains it and what else you need (formatting, email, cloud flows). Practical rule: use the simplest tool that solves the problem.</p>

<h2>The task: consolidate 12 monthly workbooks</h2>
<p>Each workbook (<code>ventas-2026-01.xlsx</code> to <code>ventas-2026-12.xlsx</code>) has one sheet with five columns (Date, Salesperson, Product, Quantity, Value) and 10,000 rows. The goal is a consolidated table of 120,000 rows, with correct data types, that can be repeated when a new month arrives. I verified the result with a control sum: the Value total must be <strong>11,111,254,600</strong>. I tested it on Windows with Excel 16 and Python 3 with pandas 2.3.</p>
{{img:tiempos}}

<h2>Option 1: Power Query (no code in the sheet)</h2>
<p>Power Query is Excel's data connector: <em>Data &gt; Get Data &gt; From File &gt; From Folder</em>. You define it once and refresh with a click. This is the M code (Advanced Editor) I used:</p>
<pre><code>let
    Source = Folder.Files("C:\PATH\data"),
    OnlyXlsx = Table.SelectRows(Source, each [Extension] = ".xlsx" and not Text.StartsWith([Name], "~$")),
    Read = Table.AddColumn(OnlyXlsx, "Data", each Excel.Workbook([Content], true){0}[Data]),
    Combined = Table.Combine(Read[Data]),
    Typed = Table.TransformColumnTypes(Combined,
        {{"Fecha", type date}, {"Vendedor", type text}, {"Producto", type text},
         {"Cantidad", Int64.Type}, {"Valor", type number}})
in
    Typed</code></pre>
<p><strong>Result:</strong> 120,000 rows, sum 11,111,254,600, 6.7 seconds on first load and 3.7 on refresh. <strong>Advantages:</strong> no macros, auditable (every step is recorded), updates by adding the new month's file to the folder. <strong>Limits:</strong> it does not format or send email; it is designed to import, clean and combine data. I explain it in depth, with the case of dates and peso values, in the article on <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">how to import a CSV correctly</a>.</p>

<h2>Option 2: VBA (desktop macros)</h2>
<p>VBA is Excel's macro language. It works for consolidating, but its strength is what comes next: formatting, creating a PDF per salesperson, sending email. This macro, which reads each file into an array and writes it at once, is the efficient version:</p>
<pre><code>Sub Consolidar(ByVal carpeta As String)
    Dim destino As Worksheet, archivo As String, wb As Workbook
    Dim datos As Variant, fila As Long, n As Long
    Application.ScreenUpdating = False
    Application.Calculation = xlCalculationManual
    Set destino = ThisWorkbook.Worksheets("Consolidado")
    destino.Cells.Clear
    destino.Range("A1:E1").Value = Array("Fecha", "Vendedor", "Producto", "Cantidad", "Valor")
    fila = 2
    archivo = Dir(carpeta & "\ventas-2026-*.xlsx")
    Do While archivo <> ""
        Set wb = Workbooks.Open(carpeta & "\" & archivo, ReadOnly:=True, UpdateLinks:=0)
        With wb.Worksheets(1).UsedRange
            n = .Rows.Count - 1
            If n > 0 Then
                datos = .Offset(1, 0).Resize(n, 5).Value2   ' without the header
                destino.Cells(fila, 1).Resize(n, 5).Value2 = datos
                fila = fila + n
            End If
        End With
        wb.Close SaveChanges:=False
        archivo = Dir()
    Loop
    destino.Range("A:A").NumberFormat = "dd/mm/yyyy"
    Application.Calculation = xlCalculationAutomatic
    Application.ScreenUpdating = True
End Sub</code></pre>
<p><strong>Result:</strong> 120,000 rows, sum 11,111,254,600, 7.5 seconds. <strong>Advantages:</strong> total control of the process and the presentation; plenty of documentation. <strong>Limits:</strong> it only works in desktop Excel (not Excel for the web), the file must be saved as .xlsm and Microsoft blocks macros in files downloaded from the internet by default, so whoever receives them has to unblock them; it also requires maintenance discipline (comments, versions). To see ready-to-use macros, look at <a href="/excel-esta-muerto-era-de-la-ia/">Is Excel dead in the age of AI?</a> and the templates in the Excel section.</p>

<h2>Option 3: Office Scripts (cloud Excel) and Power Automate</h2>
<p>Office Scripts is the modern equivalent of macros, written in TypeScript, for Excel on the web (and recent desktop versions, according to Microsoft). One key point: <strong>a script works on the workbook it runs in</strong>; to loop over a folder of files it is orchestrated with Power Automate: a flow lists the files, runs the read script on each and then a write script on the consolidated workbook. This is the pattern (written from the documentation; <strong>I did not run it</strong>, because it needs Excel on the web, OneDrive or SharePoint and Power Automate):</p>
<pre><code>// Script 1 (runs on each monthly workbook): returns the data without the header
function main(workbook: ExcelScript.Workbook): (string | number | boolean)[][] {
  const sheet = workbook.getWorksheets()[0];
  return sheet.getUsedRange().getValues().slice(1);
}

// Script 2 (runs on the consolidated workbook): appends a batch of rows
function main(workbook: ExcelScript.Workbook, rows: (string | number | boolean)[][]) {
  const sheet = workbook.getWorksheet("Consolidado");
  const next = sheet.getUsedRange().getRowCount();
  sheet.getRangeByIndexes(next, 0, rows.length, rows[0].length).setValues(rows);
}</code></pre>
<p><strong>Advantages:</strong> it runs in the cloud without your computer being on, can be scheduled and integrates with Teams, email and SharePoint. <strong>Limits Microsoft documents:</strong> requests and responses in Excel for the web are limited to 5 MB, there are 1,600 calls per day per user to the "Run script" action and a 120-second limit on synchronous Power Automate operations; using Office Scripts with Power Automate requires a Microsoft 365 business license. For 120,000 rows you have to send batches. It is a solution for teams already working in SharePoint and Power Automate, not for a small business with one computer and local files.</p>

<h2>Option 4: Python (inside and outside Excel)</h2>
<p>There are two different things. <strong>Python in Excel</strong> (the <code>=PY()</code> function) runs in Microsoft's cloud, in an isolated environment with no access to your local files or network: data enter only through the <code>xl()</code> function and you cannot install your own packages, only those in the curated Anaconda distribution. That is why it <strong>cannot consolidate a folder</strong>: it is for analyzing and charting data already in the workbook (for example, the table Power Query left). And <strong>Python outside Excel</strong> (on your computer or a server) can read files and is the option for large volumes and scheduled jobs:</p>
<pre><code>import glob
import pandas as pd

files = sorted(glob.glob(r"C:\PATH\data\ventas-2026-*.xlsx"))
df = pd.concat((pd.read_excel(f) for f in files), ignore_index=True)

print(len(df), int(df["Valor"].sum()))                 # 120000 11111254600
print(df.groupby("Vendedor")["Valor"].sum().sort_values(ascending=False))
df.to_excel("consolidated.xlsx", index=False)</code></pre>
<p><strong>Result:</strong> 120,000 rows, sum 11,111,254,600, 7.0 seconds. <strong>Advantages:</strong> powerful for analysis, statistics and larger volumes; the code is short and reusable. <strong>Limits:</strong> you have to install Python and pandas and maintain the environment, and it is not what most offices have at hand.</p>
{{img:requisitos}}

<h2>Decision matrix: which do I choose?</h2>
<p>This is the practical resource. Answer these questions in order and keep the first tool that solves your case:</p>
<table>
<thead><tr><th>If your need is…</th><th>Choose</th><th>Why</th></tr></thead>
<tbody>
<tr><td>Bring in, clean and combine data from files, folders or databases, and repeat it every month</td><td><strong>Power Query</strong></td><td>No code in the sheet, auditable, refreshes with a click.</td></tr>
<tr><td>Format, generate PDFs, send email or run a step-by-step process on the desktop</td><td><strong>VBA</strong></td><td>Total control of the desktop environment and plenty of documentation.</td></tr>
<tr><td>Have the process run in the cloud, without your computer, integrated with SharePoint, Teams or email</td><td><strong>Office Scripts + Power Automate</strong></td><td>Cloud orchestration, with its limits and business license.</td></tr>
<tr><td>Analyze, model or chart data already loaded in the workbook</td><td><strong>Python in Excel</strong> (if your plan includes it)</td><td>Pandas and charts without leaving Excel, but no access to local files.</td></tr>
<tr><td>Very large volumes, scheduled jobs or processing outside Excel</td><td><strong>Python outside Excel</strong></td><td>Flexible and scalable, with its own maintenance.</td></tr>
<tr><td>Fixed, repeatable rules, but no programming skills</td><td><strong>A ready-made template</strong></td><td>The fastest and cheapest solution if one exists and fits.</td></tr>
</tbody>
</table>
<p>And four tie-breaker questions: <strong>1) Who will maintain it two years from now?</strong> (if only you know how it works, it is a risk). <strong>2) Where does it run?</strong> (desktop, web, server). <strong>3) Which license do you have?</strong> (some features require business plans). <strong>4) What happens if it fails?</strong> (is it auditable and reversible? I cover it in the article on <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a>).</p>

<h2>Colombia, Latin America and the world: where each option matters</h2>
<p>In the corporate world, the trend is to combine: Power Query for data, Python or BI for analysis and cloud flows for orchestration. In Colombia and much of Latin America, the reality of many small businesses, accounting offices and schools is different: desktop Excel on Windows, local files, sometimes without a business license. That is why, in my experience, <strong>Power Query and VBA solve most real cases</strong>: they are in the Excel you already have and there is plenty of documentation in Spanish. Office Scripts and Python in Excel shine where there are business licenses and cloud work. For an <strong>accountant</strong>, Power Query to reconcile and VBA to generate documents; for a <strong>teacher</strong>, Power Query to join course lists and macro templates for report cards; for a <strong>manager</strong>, the most important thing is that the process does not depend on a single person.</p>

<h2>Tools to automate without starting from scratch</h2>
<p>If the process you need already exists as a tested macro, save months of development. <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">Bulk emails with attachments and CC/BCC</a> and <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">Mail merge and individual PDF generation</a> are ready-to-use VBA applications that work from your Excel lists; and if you want to adapt the logic to your case, the <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS advisory</a> accompanies you. To start with AI and free macros, download the <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel con IA kit</a>, and learn more on my <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ">Excel playlist on YouTube</a> (in Spanish).</p>
{{productos:enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco,combinar-correspondencia-y-generar-pdf-individuales}}
<p>Keep reading: <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">how to automate tasks in Excel and reduce errors</a> and <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Is VBA obsolete?</h3>
<p>No. It still works and is very useful in desktop Excel. But it does not run in Excel for the web or in the cloud, and Microsoft blocks macros in files downloaded from the internet by default. For cloud tasks there are Office Scripts and Power Automate.</p>
<h3>Does Power Query replace macros?</h3>
<p>For importing, cleaning and combining data, almost always yes and with advantages. For formatting, sending email or generating documents, no: macros remain there.</p>
<h3>Can Python in Excel read files from my computer?</h3>
<p>No. It runs in Microsoft's cloud in an isolated environment without access to local files; data enter through xl(). To read files use Power Query or Python outside Excel.</p>
<h3>Do I need to know how to program to automate Excel?</h3>
<p>Not always. Power Query is managed through a graphical interface, and ready-made templates exist. Programming helps when the process is unique or complex.</p>
<h3>Which is faster?</h3>
<p>In my test with 120,000 rows, times were very similar (between 6.7 and 7.5 seconds; Power Query drops to 3.7 on refresh). Speed is rarely the criterion: where it runs and who maintains it matter more.</p>

<p class="notice"><strong>Choose with the matrix.</strong> Write down a repetitive task from your work, answer the four tie-breaker questions and pick the simplest tool that solves it. If it already exists as a template, start there: <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">bulk emails with attachments</a> or <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">individual PDFs</a>.</p>

<h2>Food for thought</h2>
<p>Every time we automate a task, we hide it: the process stops being visible and starts to depend on whoever built it. <strong>If the best automation is the one nobody notices, how do we keep it from becoming a black box nobody understands, and who should answer when it fails: whoever programmed it, whoever uses it or whoever decided not to document it?</strong> And is it worth learning the fashionable tool or the one that will keep working when fashion changes?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:tiempos}}' => $img('automatizar-excel-comparacion-tiempos', 436, 'Bar chart of the times to consolidate 12 workbooks of 120,000 rows: Power Query 6.7 seconds on first load and 3.7 on refresh, Python with pandas 7.0 and VBA 7.5.', 'Measured times consolidating 12 workbooks (120,000 rows). All three methods gave the same result.'),
    '{{img:requisitos}}' => $img('automatizar-excel-comparacion-requisitos', 553, 'Table showing where each tool runs and what it is best for: Power Query in desktop Excel, VBA on the desktop, Office Scripts in Excel for the web with Power Automate, Python in Excel in Microsoft\'s cloud and Python outside Excel on your machine or a server.', 'Where each tool runs and what it is best for.'),
]);

return [
    'automatizar-excel-power-query-vba-office-scripts-python-comparacion' => [
        'slug' => 'power-query-vba-office-scripts-python-best-way-automate-excel',
        'title' => 'Power Query, VBA, Office Scripts or Python: What Is the Best Way to Automate Excel in 2027?',
        'excerpt' => 'The same task (consolidating 12 workbooks of 120,000 rows) solved with Power Query, VBA, Python and Office Scripts, with measured times, real requirements and a decision matrix.',
        'seo_title' => 'Power Query, VBA, Office Scripts or Python: Which?',
        'seo_description' => 'We compare Power Query, VBA, Office Scripts and Python solving the same Excel task, with code, measured times and a matrix to decide which to use.',
        'focus_keyword' => 'automate Excel',
        'cover' => '/assets/img/articulos/automatizar-excel-comparacion/automatizar-excel-comparacion-portada-en',
        'cover_alt' => 'Cover "Power Query, VBA, Office Scripts or Python: which automates your Excel best?" with a card of what each tool does best: data, desktop, cloud and flows, and analysis.',
        'content_html' => $html,
    ],
];
