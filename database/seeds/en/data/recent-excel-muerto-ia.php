<?php

declare(strict_types=1);

// English version of «¿Excel está muerto en la era de la IA?». Key is the Spanish slug.
// Nowdoc keeps code ($, <, &) literal; <pre><code> blocks are escaped automatically and figures are
// inserted from {{img:…}} markers. Facts checked on October 9, 2026, with linked sources. Formulas use
// English function names and comma separators; the Spanish originals were tested in Excel 16.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/excel-muerto-ia/' . $name . '-en';
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
<p>Every so often someone writes Excel's obituary. First databases were going to kill it, then Python, then Power BI, and now artificial intelligence: "why learn formulas if you can ask AI to do it?" Excel turned <a href="https://techcommunity.microsoft.com/blog/excelblog/excel-turns-40-join-the-celebration/4438765" target="_blank" rel="noopener">40 on September 30, 2025</a> and, according to Microsoft's own Excel team, it is used by <a href="https://techcommunity.microsoft.com/blog/excelblog/excel-in-2025-a-year-of-culture-craft-and-copilot/4474245" target="_blank" rel="noopener">hundreds of millions of people</a>. I have spent more than twenty years teaching math and building Excel and VBA solutions for companies and schools, and my answer is uncomfortable: <strong>Excel is not dead in the age of AI; what is dying is a way of using it</strong>. The way of the professional who copies, pastes, rebuilds the same report every Monday and never learned what lies beyond VLOOKUP.</p>
<p>In this article I show you the data (jobs, small businesses, costs), the modern Excel stack that almost nobody takes advantage of, where Excel is not the right tool and how the job changes when AI writes the formulas. And, as always, I leave you copy-paste examples: formulas, Power Query, DAX, a VBA macro, an Office Script, Python and Copilot prompts, all tested.</p>

<h2>Is Excel dead? What the data says</h2>
<p>Let's start with the job market. O*NET, the occupational information system of the US Department of Labor, publishes the technologies most requested in job postings using Lightcast data. Between January 1 and December 31, 2025, out of 46.9 million unique postings, <a href="https://www.onetonline.org/search/hot_tech/" target="_blank" rel="noopener">Microsoft Excel appeared in 3,211,598</a>: the second most requested technology, behind only the Office suite in general. Python appeared in 814,960 postings, SQL in 758,250 and Power BI in 357,898. Excel alone beats the three combined. This is not new: in 2015, Burning Glass's <a href="https://apo.org.au/node/209156" target="_blank" rel="noopener"><em>Crunched by the Numbers</em></a> found that spreadsheet and word processing skills were already a baseline requirement in 78% of middle-skill jobs.</p>
<p>Now the other side. The World Economic Forum's <a href="https://reports.weforum.org/docs/WEF_Future_of_Jobs_Report_2025.pdf" target="_blank" rel="noopener">Future of Jobs Report 2025</a> estimates that 39% of today's skills will be transformed or become outdated between 2025 and 2030; for Colombia the estimate is 44%, among the highest of the 55 economies studied. Analytical thinking remains the core skill (seven in ten companies consider it essential), and the fastest-growing skills are AI and big data, networks and cybersecurity, and technological literacy. Microsoft and LinkedIn's <a href="https://www.microsoft.com/en-us/worklab/work-trend-index/ai-at-work-is-here-now-comes-the-hard-part" target="_blank" rel="noopener">2024 Work Trend Index</a> adds that 75% of knowledge workers already use AI and 66% of leaders would not hire someone without AI skills.</p>
<p>What about Colombia? I looked for a reliable figure on the share of job openings that ask for Excel and found none; I would rather say so than make one up. What does exist is hard data about companies. According to <a href="https://www.dane.gov.co/files/operaciones/EMICRON/bol-EMICRON-2024.pdf" target="_blank" rel="noopener">DANE (EMICRON 2024)</a>, the country has 5.3 million micro-businesses: 68.2% keep no accounting records, 27.1% keep informal accounts "in a notebook, an Excel sheet or a cash register" and only 4.7% use a formal accounting method. Just 10.9% used a computer, tablet or laptop for their activity. <a href="https://confecamaras.org.co/wp-content/uploads/2026/03/graficas-investigaciones-economicas-2025-v-2026-1.webp" target="_blank" rel="noopener">Confecámaras</a> reports that, at the end of 2025, 99.5% of the country's 1,805,564 companies were micro, small or medium-sized, and the <a href="https://www.mincit.gov.co/prensa/noticias/industria/celebracion-del-dia-de-las-mipymes" target="_blank" rel="noopener">Ministry of Commerce</a> estimates they generate more than 78% of employment.</p>
<p>Across Latin America, <a href="https://www.cepal.org/es/temas/micro-pequenas-medianas-empresas-mipyme/acerca-microempresas-pymes" target="_blank" rel="noopener">ECLAC</a> notes that MSMEs make up about 99% of companies and employ around 67% of workers, but large firms can be up to 33 times more productive than micro-enterprises; in OECD countries that gap ranges from 1.3 to 2.4 times. Even in Europe the data analytics gap is huge: according to <a href="https://ec.europa.eu/eurostat/databrowser/view/isoc_eb_das/default/table?lang=en" target="_blank" rel="noopener">Eurostat</a>, in 2025 35.1% of small firms (10 to 49 employees) analysed data, compared with 82.0% of large ones.</p>
{{img:datos}}
<p>My reading: the market is not abandoning Excel; it is no longer paying for basic Excel. And the Latin American small business does not have an "old Excel" problem, it has a not-measuring problem: for a micro-business that writes its sales in a notebook, a well-built table with a PivotTable already is digital transformation.</p>

<h2>What did die: copy-and-paste Excel</h2>
<p>Here is a quick test. If you recognize yourself in three or more of these habits, your way of using Excel is at risk, even if Excel is not:</p>
<ul>
<li>Every month you open twelve files, copy their data and paste it one below the other.</li>
<li>You use VLOOKUP counting columns by hand and, if someone inserts a column, everything breaks.</li>
<li>Your reports contain hand-typed totals "because the formula didn't work".</li>
<li>You build the same report every week with the same clicks in the same order.</li>
<li>You don't know what an Excel table (Ctrl+T), Power Query or a measure is.</li>
<li>You paste the formula AI gave you and, if it returns a number, you assume it is right.</li>
</ul>
<p>The last point is the most dangerous one in 2026: AI automates mechanical work first, but not the judgment to know whether a number makes sense. I developed this idea in <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">AI won't replace you. Someone who masters it will</a>, and it applies here literally.</p>

<h2>The modern Excel stack: much more than a grid</h2>
<p>Today's Excel is a complete chain: it connects, cleans, models, presents and automates, with AI at every step. This is the map:</p>
{{img:pila}}

<h3>Dynamic array formulas: XLOOKUP, FILTER, UNIQUE, GROUPBY and LAMBDA</h3>
<p>In Microsoft 365 (and largely in Excel 2021), one formula can return an entire table that "spills" on its own. Imagine a <em>Sales</em> table with Date, Rep, Customer, City, Product, Category, Units and Total columns, plus a <em>Customers</em> table. I tested these formulas in Excel (in Spanish, the names in parentheses):</p>
<pre><code>1) XLOOKUP (BUSCARX): bring the customer name without counting columns
=XLOOKUP([@Customer], Customers[Code], Customers[Name], "Not found")

2) GROUPBY (AGRUPARPOR): total per rep, largest first, with a grand total
=GROUPBY(Sales[Rep], Sales[Total], SUM, , , -2)

3) PIVOTBY (PIVOTARPOR): categories in rows, months (202601, 202602...) in columns
=PIVOTBY(Sales[Category], YEAR(Sales[Date]) * 100 + MONTH(Sales[Date]), Sales[Total], SUM)

4) FILTER + SORTBY (FILTRAR, ORDENARPOR): Bogotá sales above 1 million
=SORTBY(FILTER(Sales, (Sales[City] = "Bogotá") * (Sales[Total] > 1000000), "No data"),
        FILTER(Sales[Total], (Sales[City] = "Bogotá") * (Sales[Total] > 1000000)), -1)

5) UNIQUE (UNICOS): how many different customers Ana served
=COUNTA(UNIQUE(FILTER(Sales[Customer], Sales[Rep] = "Ana")))

6) LET: a readable ranking with intermediate names
=LET(r, UNIQUE(Sales[Rep]),
     t, SUMIF(Sales[Rep], r, Sales[Total]),
     SORTBY(HSTACK(r, t), t, -1))

7) TEXTSPLIT (DIVIDIRTEXTO): split a product code "SHI-BLU-M"
=TEXTSPLIT(A2, "-")                        → SHI | BLU | M

8) Regular expressions (REGEXEXTRACCION, REGEXPRUEBA, REGEXREEMPLAZAR)
=REGEXEXTRACT(A2, "[\w.+-]+@[\w-]+(\.[\w-]+)+")      → pulls the email out of a text
=REGEXTEST(B2, "^3\d{9}$")                            → is it a valid Colombian mobile number?
=REGEXREPLACE(C2, "\D", "")                           → "(310) 456-78 90" becomes 3104567890</code></pre>
<p>Look at formula 3. If you ask an AI for "sales by month", it almost always suggests <code>TEXT(Sales[Date], "yyyy-mm")</code>. But the format codes inside TEXT depend on regional settings. I tested the Spanish version, <code>TEXTO(...; "aaaa-mm")</code>, on a Windows PC set to Colombia and got "jueves-03": there "aaaa" means the weekday name and the year is written "yyyy". That is why I prefer <code>YEAR()*100+MONTH()</code>, which works the same in any language. It is a perfect example of why a formula that "looks right" must be checked.</p>
<p>The gem is <strong>LAMBDA</strong>: it lets you create your own functions without a line of VBA. In <em>Formulas &gt; Name Manager &gt; New</em>, create the name <em>COMMISSION</em> with this definition:</p>
<pre><code>Name: COMMISSION
Refers to:
=LAMBDA(sale, target,
    LET(pct, sale / target,
        IF(pct >= 1, sale * 5%,
           IF(pct >= 0.8, sale * 3%, 0))))

Use it in any cell of the workbook:
=COMMISSION([@Total], [@Target])   → 12,000,000 with a 10,000,000 target = 600,000
                                     8,500,000 with a 10,000,000 target = 255,000</code></pre>
<p>If the commission policy changes tomorrow, you fix it in one place and the whole workbook updates. That is thinking like a programmer while remaining an Excel user. For more LAMBDA functions for analysts, see <a href="/excel-con-inteligencia-artificial-ejemplos-practicos-python/">Excel with artificial intelligence: practical examples</a>.</p>

<h3>Power Query: cleaning thousands of rows without a single formula</h3>
<p>Power Query is the tool that gives back the most hours and the least known one. It connects to files, folders, SQL databases, SharePoint or the web, records every cleaning step, and next month you just click <em>Refresh All</em>. The classic case: each branch sends its file with products in rows and months in columns. In the interface:</p>
<ol>
<li><em>Data &gt; Get Data &gt; From File &gt; From Folder</em>, choose the folder and click <em>Transform Data</em>.</li>
<li>Filter the .xlsx extension and combine the files using the first sheet.</li>
<li>Add the Branch column from the file name.</li>
<li>Remove empty rows, trim spaces and capitalize names.</li>
<li>Select Branch and Product and choose <em>Unpivot Other Columns</em>: months become rows.</li>
<li><em>Close &amp; Load</em> to a table or directly into the Data Model.</li>
</ol>
<p>And this is the complete M code. Paste it into <em>Get Data &gt; From Other Sources &gt; Blank Query &gt; Advanced Editor</em> and change the path:</p>
<pre><code>let
    // 1) All files in the folder (one per branch: "North.xlsx", "Downtown.xlsx"...)
    Source = Folder.Files("C:\Sales\Branches"),
    Workbooks = Table.SelectRows(Source, each [Extension] = ".xlsx"
                    and not Text.StartsWith([Name], "~$")),

    // 2) From each workbook, the first sheet with row 1 as headers,
    //    plus a Branch column taken from the file name
    WithData = Table.AddColumn(Workbooks, "Data", each
        let
            branch = Text.BeforeDelimiter([Name], "."),
            sheets = Table.SelectRows(Excel.Workbook([Content], true), each [Kind] = "Sheet"),
            sheet = sheets{0}[Data]
        in
            Table.AddColumn(sheet, "Branch", each branch, type text)),
    Combined = Table.Combine(WithData[Data]),

    // 3) Cleaning: no empty rows, no extra spaces, consistent names
    NoBlanks = Table.SelectRows(Combined, each [Product] <> null
                   and Text.Trim(Text.From([Product])) <> ""),
    Clean = Table.TransformColumns(NoBlanks,
                {{"Product", each Text.Proper(Text.Trim(Text.From(_))), type text}}),

    // 4) Unpivot: months move from columns to rows
    Rows = Table.UnpivotOtherColumns(Clean, {"Branch", "Product"}, "Month", "Sales"),
    Typed = Table.TransformColumnTypes(Rows, {{"Sales", type number}}, "en-US"),
    NoErrors = Table.RemoveRowsWithErrors(Typed, {"Sales"}),
    Final = Table.SelectRows(NoErrors, each [Sales] <> null and [Sales] <> 0)
in
    Final</code></pre>
<p>I tested it with three "dirty" files (extra spaces, capital letters, empty rows and an "n/a" where a number should be) and it returned a clean table with Product, Branch, Month and Sales. An auditing tip: the <em>NoErrors</em> step drops anything that is not a number; check how many rows it removes, because an "n/a" may be a figure someone forgot to report.</p>

<h3>Power Pivot and DAX: your own small BI at home</h3>
<p>The Data Model relates several tables like a database and computes indicators with DAX, the same language Power BI uses. With a <em>Calendar</em> table (one row per day) and a <em>Products</em> table related to <em>Sales</em>, these measures cover almost everything a manager asks for:</p>
<pre><code>Total Sales := SUM ( Sales[Total] )

Total Cost := SUMX ( Sales, Sales[Units] * RELATED ( Products[Cost] ) )

Margin % := DIVIDE ( [Total Sales] - [Total Cost], [Total Sales] )

Sales Last Year := CALCULATE ( [Total Sales], SAMEPERIODLASTYEAR ( Calendar[Date] ) )

YoY % := DIVIDE ( [Total Sales] - [Sales Last Year], [Sales Last Year] )

Year to Date := TOTALYTD ( [Total Sales], Calendar[Date] )

Running Total :=
CALCULATE (
    [Total Sales],
    FILTER ( ALL ( Calendar[Date] ), Calendar[Date] <= MAX ( Calendar[Date] ) )
)</code></pre>
<p>I verified them in a test model against hand calculations: a 43.75% margin, +7.5% for June and exact running totals. And the model taught me a lesson: for all of 2026 the year-over-year change was −46%, because 2026 only had data through June and was compared with the full 2025. The DAX was right; the question was wrong. If your regional settings use a decimal comma and Power Pivot rejects commas between arguments, use semicolons.</p>

<h3>Advanced PivotTables: what impresses a director</h3>
<p>On top of that model, a PivotTable becomes a dashboard: slicers by rep and city, a timeline to pick months with the mouse, <em>Show Values As &gt; % of Row Total</em> to see the product mix, and the <em>YoY %</em> measure with conditional formatting. If you connect several PivotTables to the same slicers (<em>Report Connections</em>), you have an interactive dashboard without paying for an extra license. I have a step-by-step guide in <a href="/tablas-dinamicas-en-excel-analiza-datos-como-un-profesional/">PivotTables in Excel: analyze data like a pro</a>.</p>

<h3>VBA and Office Scripts: automating what you do every week</h3>
<p>VBA is more than 30 years old and is still the most direct way to automate desktop Excel on Windows. This macro takes the <em>Sales</em> sheet, creates one PDF per rep in a dated folder and, if you turn it on, prepares an Outlook email with each PDF attached. I tested it with sample data: three reps, three PDFs, no leftover temporary sheets or forgotten filters.</p>
<pre><code>Option Explicit

' Splits the "Sales" sheet into one PDF per rep and, if you want, prepares
' an Outlook email with each PDF attached (it displays it, it does not send it).
' Requirements: data from A1 with headers; an "Emails" sheet with the rep
' in column A and the email in column B (only if SEND_MAIL = True).

Private Const DATA_SHEET As String = "Sales"
Private Const REP_COL As Long = 2               ' B = Rep
Private Const SEND_MAIL As Boolean = False      ' True = prepare emails

Public Sub CreatePdfPerRep()
    Dim ws As Worksheet, tmp As Worksheet
    Dim data As Range, cell As Range
    Dim reps As Object, v As Variant
    Dim folder As String, file As String, n As Long

    Set ws = ThisWorkbook.Worksheets(DATA_SHEET)
    If ws.AutoFilterMode Then ws.AutoFilterMode = False
    Set data = ws.Range("A1").CurrentRegion
    If data.Rows.Count < 2 Then
        MsgBox "The " & DATA_SHEET & " sheet has no data.", vbExclamation
        Exit Sub
    End If

    ' Output folder next to the workbook: PDF_2026-10-09
    folder = ThisWorkbook.Path & Application.PathSeparator & "PDF_" & Format(Date, "yyyy-mm-dd")
    If Dir(folder, vbDirectory) = "" Then MkDir folder

    ' Unique reps (case-insensitive)
    Set reps = CreateObject("Scripting.Dictionary")
    reps.CompareMode = vbTextCompare
    For Each cell In data.Columns(REP_COL).Offset(1).Resize(data.Rows.Count - 1).Cells
        If Len(Trim$(CStr(cell.Value))) > 0 Then reps(Trim$(CStr(cell.Value))) = True
    Next cell

    Application.ScreenUpdating = False
    On Error GoTo Failed
    For Each v In reps.Keys
        ' Filter the rep and copy only the visible rows to a temporary sheet
        data.AutoFilter Field:=REP_COL, Criteria1:="=" & v
        Set tmp = ThisWorkbook.Worksheets.Add(After:=ws)
        data.SpecialCells(xlCellTypeVisible).Copy tmp.Range("A1")
        tmp.Columns.AutoFit
        With tmp.PageSetup
            .Orientation = xlLandscape
            .Zoom = False
            .FitToPagesWide = 1
            .FitToPagesTall = False
            .CenterHeader = "Sales for " & v
            .RightFooter = "Page &P of &N"
        End With
        file = folder & Application.PathSeparator & SafeName(CStr(v)) & ".pdf"
        tmp.ExportAsFixedFormat Type:=xlTypePDF, Filename:=file, OpenAfterPublish:=False
        Application.DisplayAlerts = False
        tmp.Delete
        Application.DisplayAlerts = True
        Set tmp = Nothing
        If SEND_MAIL Then PrepareEmail CStr(v), file
        n = n + 1
    Next v

Failed:
    ' Whatever happens: remove the filter, delete the temporary sheet, restore the screen
    If Not tmp Is Nothing Then
        Application.DisplayAlerts = False
        tmp.Delete
        Application.DisplayAlerts = True
    End If
    If ws.AutoFilterMode Then ws.AutoFilterMode = False
    Application.ScreenUpdating = True
    If Err.Number <> 0 Then
        MsgBox "Error with " & v & ": " & Err.Description, vbCritical
    Else
        MsgBox n & " PDFs saved in:" & vbLf & folder, vbInformation
    End If
End Sub

' Creates an Outlook email with the PDF attached and displays it for review.
Private Sub PrepareEmail(ByVal rep As String, ByVal file As String)
    Dim address As Variant, ol As Object, msg As Object
    address = Application.VLookup(rep, ThisWorkbook.Worksheets("Emails").Range("A:B"), 2, False)
    If IsError(address) Then Exit Sub                 ' no email on file: skip
    Set ol = CreateObject("Outlook.Application")
    Set msg = ol.CreateItem(0)
    With msg
        .To = address
        .Subject = "Your sales report - " & Format(Date, "mmmm yyyy")
        .Body = "Hi " & rep & "," & vbLf & vbLf & _
                "Attached is your sales report. Let me know if anything looks off." & vbLf
        .Attachments.Add file
        .Display                                       ' switch to .Send once you trust the process
    End With
End Sub

' Removes characters Windows does not allow in a file name.
Private Function SafeName(ByVal s As String) As String
    Dim c As Variant
    For Each c In Array("\", "/", ":", "*", "?", """", "<", ">", "|")
        s = Replace(s, c, "_")
    Next c
    SafeName = Left$(Trim$(s), 100)
End Function</code></pre>
<p>To use it: <em>Alt+F11 &gt; Insert &gt; Module</em>, paste the code, save as <em>.xlsm</em> and run it with <em>Alt+F8</em>. Emails are displayed, not sent; errors never leave filters on; file names are sanitized. If you need the same with Word templates, hundreds of recipients, CC and BCC or different attachments per person, I already solved it in two templates: <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">Send mass emails with attachments, CC and BCC</a> and <a href="/producto/combinar-correspondencia-y-generar-pdf-individuales/">Mail merge to individual PDFs</a>.</p>
<p>The modern version is <strong>Office Scripts</strong> (TypeScript, <em>Automate</em> tab) for Excel on the web, Windows and Mac with business or education licenses. Their advantage is the connection with <strong>Power Automate</strong>: according to <a href="https://learn.microsoft.com/en-us/office/dev/scripts/testing/platform-limits" target="_blank" rel="noopener">Microsoft's documentation</a>, the <em>Run script</em> action allows up to 1,600 calls per user per day, with a 120-second limit per run. This script rebuilds a <em>Summary</em> sheet with totals per rep and returns text for an email:</p>
<pre><code>function main(workbook: ExcelScript.Workbook): string {
  const table = workbook.getTable("Sales");
  if (!table) {
    throw new Error("Sales table not found");
  }
  const headers = table.getHeaderRowRange().getValues()[0] as string[];
  const iRep = headers.indexOf("Rep");
  const iTotal = headers.indexOf("Total");

  // Add up each rep's total
  const totals = new Map<string, number>();
  for (const row of table.getRangeBetweenHeaderAndTotal().getValues()) {
    const rep = String(row[iRep]).trim();
    totals.set(rep, (totals.get(rep) || 0) + Number(row[iTotal]));
  }
  const rows = Array.from(totals.entries()).sort((a, b) => b[1] - a[1]);
  if (rows.length === 0) {
    return "The Sales table is empty";
  }

  // Rebuild the Summary sheet on every run
  workbook.getWorksheet("Summary")?.delete();
  const sheet = workbook.addWorksheet("Summary");
  sheet.getRange("A1:B1").setValues([["Rep", "Total"]]);
  sheet.getRange("A1:B1").getFormat().getFont().setBold(true);
  sheet.getRangeByIndexes(1, 0, rows.length, 2).setValues(rows);
  sheet.getRangeByIndexes(1, 1, rows.length, 1).setNumberFormat("$#,##0");
  sheet.getRange("A:B").getFormat().autofitColumns();

  // Text Power Automate can drop into the body of an email
  return rows.map(([r, t]) => `${r}: $${t.toLocaleString("en-US")}`).join("\n");
}</code></pre>
<p>In Power Automate the flow has three steps: <em>Recurrence</em> (Mondays, 7:00), <em>Run script</em> on the workbook in OneDrive or SharePoint, and <em>Send an email</em> with the result. The manager gets the summary before arriving at the office, and nobody opened Excel.</p>

<h3>Copilot and Python in Excel: AI inside the sheet</h3>
<p>The picture as of October 2026: Copilot's Agent Mode, which edits the workbook in several steps, is <a href="https://techcommunity.microsoft.com/blog/excelblog/agent-mode-in-excel-is-now-generally-available-on-desktop/4457408" target="_blank" rel="noopener">generally available</a> in Excel for the web, Windows and Mac; the <code>=COPILOT()</code> cell function <a href="https://support.microsoft.com/en-us/excel/functions/copilot-function" target="_blank" rel="noopener">was retired on September 14, 2026</a> without ever leaving preview; and <a href="https://support.microsoft.com/office/python-in-excel-availability-781383e6-86b9-4156-84fb-93e786f7cab0" target="_blank" rel="noopener">Python in Excel</a> is available for business plans on Windows, Mac and the web, and in preview for Personal and Family. Licensing and agent details are in my guide to <a href="/copilot-agentes-excel-lenguaje-natural-copilot-pages/">Copilot and agents in Excel</a>. Here I care about the difference between an amateur prompt and a professional one.</p>
<pre><code>WEAK PROMPT
Analyze the sales.

PROFESSIONAL PROMPT
Use the Sales table (Date, Rep, City, Product, Total).
Goal: prepare the October sales committee.
1) In a new sheet, create the total per rep and month with formulas
   (GROUPBY or PIVOTBY), never with pasted values.
2) Calculate the change from August to September per rep.
3) Point out the three products that fell the most and in which city.
4) Add a Control cell that compares the summary total with
   SUM(Sales[Total]); it must return 0.
Show me the plan before changing the workbook.</code></pre>
<p>The first produces a generic paragraph; the second produces auditable formulas and a cell that tells you if something got lost along the way. And for real statistics, a <code>=PY</code> cell classifies inventory with the ABC (Pareto) method in five lines; I tested the logic with pandas:</p>
<pre><code># =PY cell: ABC classification of products by sales
df = xl("Sales[#All]", headers=True)
abc = df.groupby("Product", as_index=False)["Total"].sum().sort_values("Total", ascending=False)
abc["Cumulative %"] = abc["Total"].cumsum() / abc["Total"].sum()
abc["Class"] = np.where(abc["Cumulative %"] <= 0.8, "A", np.where(abc["Cumulative %"] <= 0.95, "B", "C"))
abc</code></pre>
<p>How to verify what AI produces, in four steps that do not depend on it: demand formulas, not values; open three formulas at random and read them; add a control cell that compares totals and must return zero; and test a case whose result you know by heart. If you can't read the formula Copilot wrote, you are not using AI: you are gambling.</p>

<h2>How the job changes: AI amplifies whoever understands the data</h2>
<p>This is the core of my argument: AI does not level everyone up, <strong>it multiplies what you already know</strong>. For the analyst who understands tables, relationships and comparable periods, Copilot saves hours, and he or she spots the error in seconds. For someone who doesn't know what a data model is, the same AI confidently delivers a report comparing six months with twelve, like the −46% above. Both "use AI"; only one works better.</p>
<p>That is why the World Economic Forum does not contradict itself: AI and data skills are growing, and analytical thinking is still the most valued. For most people, Excel is where that thinking is learned: what a row is, a key, a total that reconciles. Those who master it make the most of AI; those who don't depend on it.</p>

<h2>Excel in small businesses: the low-cost BI you already have installed</h2>
<p>For a small Colombian business, the question is not "Excel or Power BI" but how much each step costs and what it returns. These are US list prices per user per month, paid annually, checked on Microsoft's pages:</p>
<table>
<thead><tr><th>Tool</th><th>List price</th><th>What it adds</th></tr></thead>
<tbody>
<tr><td>Microsoft 365 Business Standard</td><td>USD 14 (since July 1, 2026; previously 12.50)</td><td>Desktop Excel with Power Query, Power Pivot, PivotTables and VBA, plus email and Teams</td></tr>
<tr><td>Microsoft 365 Business Basic</td><td>USD 7</td><td>Excel for the web and mobile (no desktop Excel)</td></tr>
<tr><td>Power BI Desktop</td><td>Free</td><td>Models and dashboards on your computer, no online sharing</td></tr>
<tr><td>Power BI Pro</td><td>USD 14</td><td>Publish and share dashboards with the team</td></tr>
<tr><td>Microsoft 365 Copilot Business</td><td>USD 21 (USD 18 promotion through December 31, 2026)</td><td>Copilot in Excel, Word, Outlook and Teams for companies with fewer than 300 users</td></tr>
<tr><td>Microsoft 365 Copilot (enterprise)</td><td>USD 30</td><td>Full Copilot with agents</td></tr>
</tbody>
</table>
<p>Sources: <a href="https://www.microsoft.com/en-us/licensing/news/2026-m365-packaging-pricing-updates" target="_blank" rel="noopener">Microsoft 365 2026 pricing updates</a>, <a href="https://www.microsoft.com/en-us/power-platform/products/power-bi/pricing" target="_blank" rel="noopener">Power BI pricing</a>, <a href="https://www.microsoft.com/en-us/copilot/blog/2025/12/02/microsoft-365-copilot-business-the-future-of-work-for-small-businesses/" target="_blank" rel="noopener">Copilot Business announcement</a> and <a href="https://www.microsoft.com/en-us/copilot/pricing/enterprise" target="_blank" rel="noopener">Microsoft 365 Copilot pricing</a>. As an outside reference, <a href="https://www.tableau.com/pricing/cloud" target="_blank" rel="noopener">Tableau's pricing page</a> starts at USD 75 per user per month for a Creator, and an ERP also means implementation, training and months of adjustments.</p>
<p>The math for a five-person business: with Business Standard it pays USD 70 a month and has the whole stack; if one person publishes dashboards, add USD 14 for Power BI Pro. I am not saying small businesses never need an ERP; I am saying many buy software before knowing what they want to measure and end up exporting from the ERP… to Excel. I would do it the other way around: organize the data, measure with PivotTables, automate the repetitive work and, when the spreadsheet falls short, migrate with your indicators already defined.</p>

<h2>Use cases by role: formulas for tomorrow morning</h2>
<h3>Accounting: bank reconciliation with a date tolerance</h3>
<p>The bank records a payment on the 5th and the ledger on the 6th. XLOOKUP with multiple conditions finds the same amount within three days and returns the voucher:</p>
<pre><code>Voucher column in the Bank table:
=XLOOKUP(1, (Ledger[Amount] = [@Amount]) * (ABS(Ledger[Date] - [@Date]) <= 3),
         Ledger[Voucher], "Pending")

Total still to reconcile:
=SUMIF(Bank[Voucher], "Pending", Bank[Amount])</code></pre>
<p>In my test, a September 1 payment matched the August 30 voucher, and another one for the same amount on September 12 stayed pending because the ledger had it on the 20th: exactly what an accountant needs to review. For error-free invoicing, the <a href="/producto/factura-con-envio-por-correo-al-cliente/">invoice with email delivery</a> handles numbering and sending, and the <a href="/en/tools/number-to-words/">number-to-words converter</a> includes a free Excel module.</p>

<h3>Small business owner: cash flow and inventory</h3>
<pre><code>Week-by-week cash balance from an opening balance in B1 (SCAN):
=SCAN(B1, CashFlow[Inflows] - CashFlow[Outflows], LAMBDA(balance, mov, balance + mov))

Reorder alert based on the last 30 days of sales:
=LET(daily, SUMIFS(Sales[Units], Sales[Product], [@Product],
                   Sales[Date], ">=" & TODAY() - 30) / 30,
     point, daily * [@[Lead time days]] + [@[Safety stock]],
     IF([@[On hand]] <= point, "Order now", "OK"))</code></pre>
<p>With an opening balance of 1,000,000, inflows of 5,000,000 and outflows of 3,200,000, SCAN returns 2,800,000 in week one and keeps accumulating: if a week is going negative, you see it before it happens. To label assets and stock, the <a href="/producto/generador-de-etiquetas-para-inventario-de-activos-fijos-en-excel-con-qr-y-codigos-de-barras/">label generator with QR and barcodes</a> prints them from the same table.</p>

<h3>HR: overtime and attendance</h3>
<pre><code>Overtime for a shift, even if it crosses midnight:
=LET(h, MOD([@Out] - [@In], 1) * 24, MAX(0, h - 8))

Attendance rate for one row (P = present):
=COUNTIF(C2:X2, "P") / COUNTA(C2:X2)</code></pre>
<p>MOD solves the classic 10:00 p.m. to 6:00 a.m. shift that returns negative hours. Night and Sunday premiums depend on current law and your agreements, so put the rates in a parameter table, not inside the formula. If you track attendance, the <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">work or school attendance sheet</a> already has the calculations.</p>

<h3>Sales: commission dashboard</h3>
<p>Combine the above: <code>COMMISSION</code> as a calculated column, GROUPBY for totals per rep, a PivotTable with a month slicer and the PDF macro so every rep receives their statement. What took an afternoon now takes minutes.</p>

<h3>Teachers and school leaders: grades and attendance</h3>
<pre><code>Final grade with term weights (C2:E2 grades, Weights in H2:H4):
=ROUND(SUMPRODUCT(C2:E2, TRANSPOSE(Weights)), 1)

Performance level from the school's grading scale (Scale table sorted by From):
=XLOOKUP([@Final], Scale[From], Scale[Level], "No grade", -1)</code></pre>
<p>If you teach, AI helps most with preparing lessons and assessments: I built the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for Teachers</a> with tested prompts by subject and the <a href="/herramientas/generador-de-examenes/">AI exam generator</a>, which creates versions and answer keys. What comes next, consolidating grades, belongs in Excel.</p>

<h3>Logistics: on time, in full (OTIF)</h3>
<pre><code>Share of orders delivered on time and complete:
=AVERAGE((Shipments[Delivered] <= Shipments[Promised]) *
         (Shipments[Qty delivered] >= Shipments[Qty ordered]))</code></pre>
<p>With four test orders (one late, one incomplete), the formula returned 0.5: a 50% OTIF, the indicator a wholesale customer cares about most. And if your shipments carry codes, the <a href="/producto/generador-de-codigos-qr-masivos/">bulk QR code generator</a> creates them in batches; you can also download the free <code>=QR()</code> module from the <a href="/en/tools/qr-code-generator/">QR generator</a>.</p>

<h2>How much time you save: manual vs automated</h2>
<p>This table is <strong>illustrative</strong>: estimates based on processes I have automated with clients and colleagues, not a statistical measurement. Your case may vary, but the order of magnitude repeats:</p>
<table>
<thead><tr><th>Task</th><th>Manual</th><th>Automated</th><th>Tool</th></tr></thead>
<tbody>
<tr><td>Consolidate 12 branch files every month</td><td>3 to 4 hours</td><td>2 minutes (Refresh All)</td><td>Power Query</td></tr>
<tr><td>Create and send 40 PDFs per rep or customer</td><td>2 to 3 hours</td><td>5 minutes</td><td>VBA</td></tr>
<tr><td>Reconcile 600 bank transactions</td><td>A full day</td><td>1 hour (review pending items only)</td><td>XLOOKUP and Power Query</td></tr>
<tr><td>Monthly report with year-over-year comparison</td><td>4 hours</td><td>15 minutes</td><td>Power Pivot and PivotTables</td></tr>
<tr><td>Weekly summary email to the manager</td><td>45 minutes</td><td>0 (scheduled)</td><td>Office Scripts and Power Automate</td></tr>
<tr><td>Consolidate grades for six classes</td><td>A full day</td><td>1 hour</td><td>Dynamic array formulas</td></tr>
</tbody>
</table>
<p>To learn how to build them, <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">How to automate tasks in Excel and reduce errors</a> explains the logic, and <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ" target="_blank" rel="noopener">my Excel playlist on YouTube</a> (in Spanish) has step-by-step tutorials, from formulas to macros.</p>

<h2>Where Excel is not the right tool</h2>
<p>Defending Excel does not mean defending it for everything. These are its real limits, with documented cases:</p>
<ul>
<li><strong>Volume.</strong> A worksheet holds <a href="https://support.microsoft.com/en-us/office/excel-specifications-and-limits-1672b34d-7043-467e-8e27-269d656771c3" target="_blank" rel="noopener">1,048,576 rows by 16,384 columns</a>. The Data Model handles many more, but for tens of millions of records growing every day you need a database.</li>
<li><strong>Many users writing at once.</strong> Co-authoring is for editing a workbook, not for thirty people entering simultaneous orders with integrity rules: that is a database's job.</li>
<li><strong>Version control.</strong> "Final_report_v3_really_final.xlsx" is not version control. If a number affects public money, health or investments, you need peer review and a change log.</li>
<li><strong>Critical processes without review.</strong> In October 2020, Public Health England <a href="https://www.gov.uk/government/news/phe-statement-on-delayed-reporting-of-covid-19-cases" target="_blank" rel="noopener">failed to report 15,841 positive COVID-19 cases</a> between September 25 and October 2 because files exceeded their maximum size; the <a href="https://www.bbc.com/news/technology-54423988" target="_blank" rel="noopener">BBC explained</a> that the old .xls format, limited to 65,536 rows, was being used.</li>
<li><strong>Financial models copied by hand.</strong> <a href="https://elischolar.library.yale.edu/ypfs-documents/454" target="_blank" rel="noopener">JPMorgan's internal report</a> on the "London Whale" (losses of more than USD 6 billion in 2012) describes a risk model in Excel sheets filled in by copying and pasting, with a formula that divided by the sum instead of the average.</li>
<li><strong>Academic research.</strong> In 2013, <a href="https://zenodo.org/records/4017423" target="_blank" rel="noopener">Herndon, Ash and Pollin</a> found that Reinhart and Rogoff's influential study on debt and growth left out five countries because of a wrongly selected Excel range. That error explained only part of the difference (the rest came from data exclusions and questionable weighting), but it was enough to cast doubt on a thesis widely cited in the austerity debate.</li>
<li><strong>Automatic conversions.</strong> A <a href="https://genomebiology.biomedcentral.com/articles/10.1186/s13059-016-1044-7" target="_blank" rel="noopener">2016 study in Genome Biology</a> found that about one in five papers with gene lists in Excel had names converted into dates (SEPT1 became "1-Sep"). In 2020 the international nomenclature committee <a href="https://blog.genenames.org/newsletters/2020/08/28/Summer_newsletter/" target="_blank" rel="noopener">renamed those genes</a> (SEPT1 is now SEPTIN1).</li>
</ul>
<p>And a humbling figure: across studies that thoroughly inspected 85 spreadsheets, Ray Panko reported <a href="https://arxiv.org/abs/1602.02601" target="_blank" rel="noopener">errors in 94% of them</a>. The lesson is not to abandon Excel but to use it like a professional: structured tables, Power Query instead of copy and paste, control cells and a second person to review. Almost all of those disasters came from manual processes, exactly what the modern stack eliminates.</p>

<h2>Are you obsolete? A level 1 to 5 self-assessment and learning roadmap</h2>
{{img:niveles}}
<p>Place yourself honestly. Check what you already do without searching online:</p>
<ul>
<li><strong>Level 1, data entry:</strong> you type data and add it up with a calculator nearby. Learn next: tables with Ctrl+T, SUMIFS, filtering and sorting.</li>
<li><strong>Level 2, operator:</strong> you use VLOOKUP, filters and a basic PivotTable. Learn: XLOOKUP, FILTER, UNIQUE and data validation.</li>
<li><strong>Level 3, analyst:</strong> you use dynamic arrays, LET and PivotTables with slicers. Learn: Power Query to combine folders and unpivot.</li>
<li><strong>Level 4, modeler:</strong> you work with Power Query, the Data Model, DAX measures and dashboards. Learn: VBA or Office Scripts, LAMBDA and Power Automate.</li>
<li><strong>Level 5, augmented automator:</strong> you automate, use Copilot and Python, and audit what AI produces. Learn: data governance, Power BI and basic SQL.</li>
</ul>
<p>Move up one level per quarter by applying it to a real report from your job. A level 3 with judgment is worth more than a level 1 with a Copilot license.</p>

<p class="notice"><strong>Start today without starting from scratch.</strong> Download the free <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel with AI kit</a> (macros to profile data and classify it with your own free Gemini key) and the <a href="/en/tools/number-to-words/">number-to-words</a> and <a href="/en/tools/qr-code-generator/">QR code</a> modules. When you want to automate a whole process, the <a href="/excel/">Excel and automation</a> section has the templates I use with my clients: <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">mass emails with attachments</a>, <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">separate Word and PDF documents</a>, <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">invoice with automatic numbering</a> and, if you want me by your side during implementation, <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS support</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Will Excel disappear because of artificial intelligence?</h3>
<p>There are no signs of that. Microsoft is building AI into Excel (Copilot, Agent Mode, Python), and in 2025 Excel appeared in more than 3.2 million job postings in the United States alone. What is losing value is manual, repetitive use.</p>
<h3>What should I learn first so I don't fall behind?</h3>
<p>Tables (Ctrl+T), XLOOKUP and FILTER, PivotTables and then Power Query. With those four you can automate most of an office's repetitive work. After that, DAX or macros depending on your role.</p>
<h3>Is it better to learn Python or Power BI instead of Excel?</h3>
<p>They are not mutually exclusive: Power Query and DAX are the same in Excel and Power BI, and Python already runs inside Excel. For most administrative roles, modern Excel is the first step and the one with the best return.</p>
<h3>Do I need to pay for Copilot to use AI with Excel?</h3>
<p>Not necessarily. You can ask ChatGPT, Gemini or Claude for formulas by describing your table without pasting personal data, or use my free ExcelConIA module. Copilot works inside the workbook, but verification is still on you.</p>
<h3>Are VBA macros still useful in 2026?</h3>
<p>Yes. In desktop Excel for Windows they are the most direct way to automate files, PDFs and emails. For Excel on the web and cloud flows, the alternative is Office Scripts with Power Automate.</p>

<h2>Food for thought</h2>
<p>For decades, knowing Excel was an advantage; then it became a requirement; now AI promises you won't need to know it at all. But when anyone can ask a machine to "build the report", the value will no longer be in building it but in knowing whether it is right. <strong>If a generation learns to ask for formulas without learning to read them, are we training more productive professionals or people who sign off on numbers they don't understand? And who should answer for that gap: each worker, the companies that demand speed, or the schools and universities that still teach Excel as if it were 2005?</strong></p>
HTML;

$html = strtr($code($html), [
    '{{img:datos}}' => $img('excel-muerto-ia-datos', 720, 'Bar chart of the most requested software in US job postings in 2025 (Microsoft Office 3.42 million, Excel 3.21 million, Outlook 1.71, PowerPoint 1.62, Word 0.96, Python 0.81, SQL 0.76, Power BI 0.36 and Tableau 0.28) and a stacked bar showing how Colombian micro-businesses kept their books in 2024: 68.2% no records, 27.1% informal and 4.7% formal', 'Excel is the second most requested technology in job postings, while two in three Colombian micro-businesses keep no records. Sources: O*NET/Lightcast, DANE, Eurostat and Confecámaras.'),
    '{{img:pila}}' => $img('excel-muerto-ia-pila', 687, 'Diagram of the modern Excel stack: source data (ERP, bank CSV files, folders, SQL databases, web) flows through Power Query to clean, Power Pivot and DAX to model, PivotTables to present and VBA or Office Scripts to automate, on top of dynamic array formulas, with Copilot and Python as the AI layer', 'The modern stack: each layer replaces a manual task, and AI assists in all of them.'),
    '{{img:niveles}}' => $img('excel-muerto-ia-niveles', 653, 'Staircase of five Excel levels: data entry, operator, analyst, modeler and augmented automator, with what each one does, what to learn next and the illustrative time for a monthly report (from 2 days to 10 minutes)', 'Self-assessment: find your level and learn what the next column shows. Illustrative times.'),
]);

return [
    'excel-esta-muerto-era-de-la-ia' => [
        'slug' => 'is-excel-dead-in-the-age-of-ai',
        'title' => 'Is Excel Dead in the Age of AI? What Expired Is Not the Tool',
        'excerpt' => 'Excel is not dead in the age of AI: what is obsolete is using it to copy and paste. Job and small-business data, the modern stack (Power Query, DAX, PivotTables, VBA, Office Scripts, Copilot and Python), costs, real limits and tested examples for accountants, small businesses, HR, sales, teachers and logistics.',
        'seo_title' => 'Is Excel Dead in the Age of AI? Data and Examples',
        'seo_description' => 'Is Excel dead? Job and small-business data, Power Query, DAX, VBA, Copilot and Python with tested examples, real costs and a five-level self-assessment.',
        'focus_keyword' => 'Excel in the age of AI',
        'cover' => '/assets/img/articulos/excel-muerto-ia/excel-muerto-ia-portada-en',
        'cover_alt' => 'Cover for Is Excel dead in the age of AI?: a crossed-out VLOOKUP and copy-paste card next to a modern workbook with GROUPBY, sales and margin KPIs, bars per rep and chips for Power Query, DAX, LAMBDA, VBA, Copilot and Python',
        'content_html' => $html,
    ],
];
