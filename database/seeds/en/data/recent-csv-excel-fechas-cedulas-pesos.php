<?php

declare(strict_types=1);

// English version of "El archivo CSV que destruye tus datos". Key is the Spanish slug. Tested in Microsoft Excel 16 with Colombian regional
// settings on October 9, 2026 (double click, Power Query, NUMBERVALUE, DATE, TEXT and CSV UTF-8 export). Status and date are carried over from
// the Spanish post by en/02_recent_posts.php (scheduled for Thursday, October 15, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/csv-excel-fechas-cedulas-pesos/' . $name . '-en';
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
<p>They send you the customer list from the company system, the bank or the grading platform. It is a .csv file, you double-click and it opens in Excel. Everything looks normal, until you notice that customer <code>000101</code> is now <code>101</code>, that the 16-digit account number ends in zeros, that the reference <code>3-4</code> reads "3-Apr" and that the sum of the values column does not add up. <strong>Excel did not make a mistake: it guessed</strong>, and guessed wrong.</p>
<p>In this tutorial I show you why it happens, how to import a CSV without Excel "interpreting" anything, how to repair a file you already opened and how to export without surprises. All with a <a href="/descargas/csv-excel/practica-csv-excel.zip">downloadable practice file</a> with deliberately problematic records, tested in Microsoft Excel with Colombian regional settings on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A CSV is just text: it stores no types, formats or language. On a double click, Excel decides each value's type using Windows regional settings. Import through <em>Data &gt; Get Data &gt; From Text/CSV</em>, choose UTF-8 and the delimiter, do not detect types and set each column's type yourself: identifiers always as text.</p>

<h2>Why Excel damages your data when it opens a CSV</h2>
<p>A CSV ("comma-separated values") file is not an Excel workbook: it is plain text where each line is a row and a separator marks the columns. It does not say whether <code>000101</code> is a number or a code, whether <code>04/03/2026</code> is April 3 or March 4, or whether <code>1.250.000,50</code> uses the period as a thousands separator. When you double-click it, Excel converts everything that "looks like" a number or a date using <strong>your computer's regional settings</strong>. On a Windows PC set to Colombia, the decimal is the comma, the thousands separator is the period and the list separator is the semicolon; on one set to the United States it is the other way around.</p>
<p>With the practice file (12 made-up customers), this is what Excel did when opened with a double click:</p>
{{img:danos}}
<p>There are five families of damage, and it pays to recognize them separately:</p>
<ol>
<li><strong>Wrong separator.</strong> A "US" CSV separates with commas; a Colombian Excel expects semicolons. Result: the whole file lands in column A. If you "fix" it with Text to Columns carelessly, values such as <code>"1,250,000.50"</code> are split in half.</li>
<li><strong>Decimals and thousands.</strong> <code>1,250,000.50</code> and <code>1.250.000,50</code> are the same number written under different rules. If the file and your Excel disagree, the value is read as text or with a different value, and the column sum stops adding up without warning.</li>
<li><strong>Ambiguous dates.</strong> <code>04/03/2026</code> is April 3 in a US file and March 4 in a Colombian one. If the day is greater than 12 (<code>04/15/2026</code>) the error shows; if it is 12 or less, the date ends up wrong <strong>and nobody notices</strong>.</li>
<li><strong>Leading zeros, codes and long numbers.</strong> <code>000101</code> becomes <code>101</code>. A reference such as <code>3-4</code> becomes "3-Apr", <code>12E3</code> becomes 12,000 in scientific notation and <code>1E5</code> becomes 100,000. And any number over 15 digits (accounts, cards, some identifiers) loses precision: Excel keeps <a href="https://support.microsoft.com/office/excel-specifications-and-limits-1672b34d-7043-467e-8e27-269d656771c3">15 significant digits</a> and replaces the rest with zeros. That last damage is irreversible: <code>1234567890123401</code> becomes <code>1234567890123400</code>.</li>
<li><strong>Broken accents.</strong> If the file is UTF-8 without a BOM mark, Excel reads it as ANSI and "Bogotá" becomes "BogotÃ¡".</li>
</ol>
<p>It is not a minor problem, nor one limited to accountants. In 2016 a team screened 35,175 supplementary files from 18 scientific journals and found <a href="https://genomebiology.biomedcentral.com/articles/10.1186/s13059-016-1044-7">Excel-caused gene name errors in 704 of 3,597 papers with gene lists (19.6%)</a>: symbols such as SEPT2 or MARCH1 were turned into dates. The scientific community ended up renaming genes to avoid the problem. In your small business the equivalent is invoices with damaged ID numbers, tax IDs or references, and student lists with altered identity documents.</p>

<h2>The right way: import with Power Query, don't double-click</h2>
<p>The fix is to stop "opening" the CSV and start <strong>importing</strong> it, telling Excel what each thing is. It is the procedure <a href="https://support.microsoft.com/en-us/office/import-or-export-text-txt-or-csv-files-5250ac4c-663c-47ce-937b-339e391393ba">documented by Microsoft</a> for text and CSV files. The steps (menu names may vary slightly by version):</p>
<ol>
<li><strong>Data &gt; Get Data &gt; From File &gt; From Text/CSV</strong> and select the file.</li>
<li>In the preview, choose <strong>File Origin: 65001 Unicode (UTF-8)</strong> and the right <strong>delimiter</strong> (semicolon, comma or tab).</li>
<li>Under <strong>Data Type Detection</strong>, choose <strong>Do not detect data types</strong> and click <strong>Transform Data</strong>. Everything arrives as text and nothing is altered.</li>
<li>In the Power Query Editor, use the first row as headers and set each column's type. Identifiers (ID number, tax ID, account, code, phone, reference) stay as <strong>Text</strong>. For the date and the value, right-click the column &gt; <strong>Change Type &gt; Using Locale…</strong> and choose the file's locale: <em>Spanish (Colombia)</em> if it comes with day/month/year and decimal commas, or <em>English (United States)</em> if it comes with month/day/year and decimal points.</li>
<li><strong>Close &amp; Load.</strong> The query is saved: if another file with the same format arrives tomorrow, just click <em>Refresh</em>.</li>
</ol>
{{img:pasos}}
<p>If you prefer to see the code (Advanced Editor), this query imports the Colombian-format file from the practice package; for the US file only the delimiter, the path and the locale change:</p>
<pre><code>// Colombian file: ";" separator, decimal comma, day/month/year date
let
    Source = Csv.Document(File.Contents("C:\PATH\clientes-formato-colombia.csv"),
        [Delimiter = ";", Columns = 8, Encoding = 65001, QuoteStyle = QuoteStyle.Csv]),
    Headers = Table.PromoteHeaders(Source, [PromoteAllScalars = true]),
    Typed = Table.TransformColumnTypes(Headers,
        {{"id_cliente", type text}, {"cedula", type text}, {"fecha", type date},
         {"valor_cop", type number}, {"cuenta", type text}, {"referencia", type text},
         {"telefono", type text}, {"ciudad", type text}}, "es-CO")
in
    Typed

// US file: change only these three things
//   File.Contents("C:\PATH\clientes-formato-estados-unidos.csv")
//   Delimiter = ","
//   ... }}, "en-US")</code></pre>
<p>With this query, <strong>both files give the same, verifiable result</strong>: 12 rows, the <code>valor_cop</code> sum is 9,067,524.45, customer 000101 keeps its zeros, the account keeps its 16 digits, the first row's date is April 3, 2026 (not March 4), <code>3-4</code> and <code>12E3</code> stay intact and accents display correctly.</p>

<h2>If you already opened the file: what can be repaired and what cannot</h2>
<p>Some damage can be fixed with formulas; some cannot be undone. I tested these formulas in Excel:</p>
<table>
<thead><tr><th>Problem</th><th>Repairable?</th><th>Formula (English Excel)</th></tr></thead>
<tbody>
<tr><td>Lost leading zeros (6-digit code)</td><td>Yes, if you know the length</td><td><code>=TEXT(A2,"000000")</code></td></tr>
<tr><td>Text value in US format ("1,250,000.50")</td><td>Yes</td><td><code>=NUMBERVALUE(A2,".",",")</code></td></tr>
<tr><td>Text value in Colombian format ("1.250.000,50")</td><td>Yes</td><td><code>=NUMBERVALUE(A2,",",".")</code></td></tr>
<tr><td>Text date in month/day/year ("04/03/2026")</td><td>Yes</td><td><code>=DATE(RIGHT(A2,4),LEFT(A2,2),MID(A2,4,2))</code></td></tr>
<tr><td>Values with a peso symbol ("$ 1.250.000")</td><td>Yes, after removing the symbol and spaces</td><td><code>=NUMBERVALUE(SUBSTITUTE(SUBSTITUTE(A2,"$","")," ",""),",",".")</code></td></tr>
<tr><td>16-digit number with lost precision</td><td><strong>No</strong>: you must re-import</td><td>—</td></tr>
<tr><td>Reference "3-4" turned into "3-Apr"</td><td><strong>Not reliably</strong>: the original was lost</td><td>—</td></tr>
<tr><td>Broken accents ("BogotÃ¡")</td><td>Avoided by re-importing with UTF-8</td><td>—</td></tr>
</tbody>
</table>
<p>The practical rule: <strong>if the data was lost on opening, repair by going back to the original file</strong>, not on the damaged workbook. And always keep an untouched copy of the CSV.</p>

<h2>Exporting without surprises: the "CSV UTF-8" case</h2>
<p>The same care applies in reverse. In an Excel set to Colombia, <em>Save As &gt; CSV UTF-8 (Comma delimited)</em> produces a file with a BOM mark (the one that lets accents read correctly), but separates columns with a <strong>semicolon</strong> and writes decimals with a <strong>comma</strong>: a row comes out as <code>1250000,5;Bogotá</code>. It is right for another Colombian Excel and a disaster for a system expecting commas and points. Before sending a CSV, agree with the recipient on field separator, decimal separator, date format and encoding. If the destination is a platform or an ERP, the safest option is to ask for ISO dates (<code>2026-04-03</code>), which are not confused in any country.</p>

<h2>Colombia, Latin America and the world: why it is everyone's problem</h2>
<p>The format clash is global. Colombia, Argentina, Chile, Brazil and Spain use the comma as the decimal separator; the United States, the United Kingdom and Mexico use the period. A Colombian small business exporting sales to a customer in Mexico, or receiving a supplier's catalog from the United States, lives this problem every week. What changes between contexts is the cost: a large company can have a data team; a small business, a school or an accounting office usually has one person with Excel. For them, learning to import a CSV correctly is among the lowest-cost, highest-return investments.</p>
<ul>
<li><strong>Accountants and small businesses:</strong> ID numbers, tax IDs and account numbers are identifiers, not numbers: they are never summed or given numeric formats.</li>
<li><strong>Teachers and schools:</strong> student lists carry documents with zeros, group codes such as <code>10-11</code> (which Excel turns into a date) and accents. A damaged list produces report cards with wrong data.</li>
<li><strong>IT teams:</strong> requiring UTF-8, an explicit separator and ISO dates in every export avoids most of these errors at the source.</li>
</ul>

<h2>Checklist: before and after importing a CSV</h2>
<p>This is the practical resource. Print it or paste it as a "Control" sheet in your workbooks:</p>
<table>
<thead><tr><th>When</th><th>Check</th></tr></thead>
<tbody>
<tr><td><strong>Before</strong></td><td>Open the CSV in Notepad: what is the separator? how are decimals and dates written? do accents look right?</td></tr>
<tr><td><strong>Before</strong></td><td>Ask whoever generated it for the format and encoding. Keep an untouched copy of the original.</td></tr>
<tr><td><strong>When importing</strong></td><td>Origin 65001 (UTF-8), correct delimiter, <em>Do not detect data types</em>.</td></tr>
<tr><td><strong>When importing</strong></td><td>Identifiers (ID, tax ID, account, phone, code, reference) as <strong>Text</strong>; date and values with the file's locale.</td></tr>
<tr><td><strong>After</strong></td><td>Count the rows and compare them with the source system's total.</td></tr>
<tr><td><strong>After</strong></td><td>Compare the sum of values with the source total (in the practice: 9,067,524.45).</td></tr>
<tr><td><strong>After</strong></td><td>Eyeball identifiers: length, leading zeros, no "E+".</td></tr>
<tr><td><strong>After</strong></td><td>Check 3 dates with a day of 12 or less against the original.</td></tr>
<tr><td><strong>When exporting</strong></td><td>Agree separator, decimal, date (ISO) and UTF-8 encoding with the recipient.</td></tr>
</tbody>
</table>

<h2>Tools to work with your data without damaging it</h2>
<p>If your job is moving data between files, emails and documents, these problems show up every day. The <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">Excel data merge app for separate DOCX and PDF documents</a> takes your table (with properly typed IDs, dates and values) and generates one document per row; and <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">Bulk emails with attachments and CC/BCC</a> sends each email with its attachment from a list. Both work with clean data: a damaged identifier in the table becomes a wrong letter or email. If you need values written out in words on invoices or checks, use the <a href="/herramientas/numero-a-letras/">free number-to-words converter</a>.</p>
{{productos:aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf,enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco}}
<p>And to diagnose a table before using it, the free <a href="/descargas/excel-con-ia/excel-con-ia.zip">Excel con IA</a> download includes the <code>PerfilarDatos</code> macro, which checks types, blanks and odd values in your sheet. To keep going with Excel, see <a href="/como-automatizar-tareas-en-excel-y-reducir-errores/">how to automate tasks in Excel and reduce errors</a>, <a href="/tablas-dinamicas-en-excel-analiza-datos-como-un-profesional/">PivotTables</a> and <a href="/excel-esta-muerto-era-de-la-ia/">Is Excel dead in the age of AI?</a>. And my Excel playlist is <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTL1WgcYIoZ8tYBCQblXsvJZ">on YouTube</a> (in Spanish).</p>

<h2>Frequently asked questions</h2>
<h3>Why does Excel remove leading zeros when opening a CSV?</h3>
<p>Because it reads <code>000101</code> as the number 101. Import the file with Power Query and leave that column as Text, or format the column as Text before pasting the data.</p>
<h3>How do I stop Excel from turning my codes into dates?</h3>
<p>Codes such as <code>3-4</code> or <code>10-11</code> become dates when you double-click. Import with <em>Do not detect data types</em> and leave the column as Text.</p>
<h3>How do I open a semicolon- or comma-delimited CSV in Excel?</h3>
<p>With <em>Data &gt; Get Data &gt; From Text/CSV</em>, choosing the right delimiter in the preview. That way you do not depend on Windows' list separator.</p>
<h3>How do I fix misspelled accents (BogotÃ¡)?</h3>
<p>Import the file again and choose origin 65001 Unicode (UTF-8). Saving the damaged workbook again does not fix the letters.</p>
<h3>Can a long number that ended up in scientific notation be recovered?</h3>
<p>No, if Excel already rounded it to 15 digits: that data is lost. You have to go back to the original CSV and import the column as Text.</p>

<p class="notice"><strong>Practice now.</strong> Download the <a href="/descargas/csv-excel/practica-csv-excel.zip">practice file (ZIP)</a>, open it with a double click and see what breaks; then import it with Power Query and compare against the checklist. When your daily job is moving this data into documents and emails, the <a href="/producto/aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf/">Excel data merge app</a> and <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/">bulk emails with attachments</a> save you the hours; and if you want me to help you implement it, there is the <a href="/producto/soporte-plus-para-las-plantillas-de-excel/">PLUS advisory</a>.</p>

<h2>Food for thought</h2>
<p>A decades-old format, designed to "pass data" between programs, still moves payrolls, invoices and grades, and nobody teaches it. <strong>If an import error changes a student's ID number or an invoice's value, who is responsible: whoever exported the file, whoever opened it without checking or software that prefers to guess rather than ask?</strong> And should we demand, as in any other quality control, that data always arrive with its format manual?</p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:danos}}' => $img('csv-excel-fechas-cedulas-pesos-danos', 600, 'Table of what Excel did when the CSV was opened with a double click: 000101 became 101, the 16-digit account number became scientific notation, 3-4 became 3-Apr, 12E3 became 1.20E+04, Bogotá became BogotÃ¡ and the whole US file landed in column A.', 'What Excel did to each value of the practice file when opened with a double click (Excel 16, Colombian regional settings).'),
    '{{img:pasos}}' => $img('csv-excel-fechas-cedulas-pesos-pasos', 427, 'Five steps to import a CSV with Power Query: Get Data, UTF-8 origin and delimiter, do not detect types, set text or locale and Close & Load.', 'Five steps to import a CSV without Excel guessing.'),
]);

return [
    'csv-excel-fechas-cedulas-pesos-importar-correctamente' => [
        'slug' => 'csv-file-destroys-your-data-import-excel-dates-ids-pesos',
        'title' => 'The CSV File That Destroys Your Data: How to Import Dates, Numbers, ID Numbers and Colombian Peso Values Correctly',
        'excerpt' => 'Why Excel changes zeros, dates and long numbers when opening a CSV, how to import it properly with Power Query, what formulas can repair and a downloadable practice file.',
        'seo_title' => 'Import a CSV in Excel Without Breaking Dates or IDs',
        'seo_description' => 'How to import a CSV in Excel without losing zeros, ID numbers or dates: Power Query, UTF-8, separators and peso values, with a practice file.',
        'focus_keyword' => 'import CSV in Excel',
        'cover' => '/assets/img/articulos/csv-excel-fechas-cedulas-pesos/csv-excel-fechas-cedulas-pesos-portada-en',
        'cover_alt' => 'Cover with the title "The CSV file that destroys your data" and a card showing how Excel changes 000101 to 101, a 16-digit number to scientific notation, 3-4 to 3-Apr and Bogotá to BogotÃ¡.',
        'content_html' => $html,
    ],
];
