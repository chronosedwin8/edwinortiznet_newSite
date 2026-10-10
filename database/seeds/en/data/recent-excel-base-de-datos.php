<?php

declare(strict_types=1);

// English version of "¿Cuándo Excel deja de ser la solución? Siete señales de que necesitas una base d…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/excel-base-de-datos/' . $name . '-en';
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
<p>Excel is probably the most widely used data tool in the world, and for good reason: it is flexible, familiar and solves a huge range of needs without programming. But there comes a moment when an Excel workbook stops being a spreadsheet and, without anyone deciding it, becomes the <strong>information system</strong> of an office or a school: customers, enrollments and inventories live there. And that improvised system begins to fail in predictable ways.</p>
<p>This article does not say Excel is bad: it says <strong>when it falls short</strong>, with seven concrete signs, an example with tested SQL code, a comparison and a <a href="/descargas/excel-base-de-datos/siete-senales-excel-base-de-datos.xlsx">downloadable self-assessment and migration workbook</a> (in Spanish). Technical data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> Excel's technical limits (over a million rows per sheet) are rarely the real problem; the real problems are <strong>simultaneous editing, repeated data that does not match, the lack of permissions and audit, integrity and integration with other applications</strong>. If you recognize four or more signs, plan a migration; with one or two, strengthening controls is often enough.</p>

<h2>What Excel does very well</h2>
<p>Before migrating, let us acknowledge its strengths: fast analysis, calculations, charts, prototypes, reports and what-if models. For one person or a small team with clear turns and non-sensitive data, Excel is an excellent solution. The mistake is not using Excel: it is <strong>continuing to use it as a database when the process already demands something else</strong>.</p>
<p>The technical limits exist, but they are usually far away. According to Microsoft's official specifications, a worksheet supports <strong>1,048,576 rows and 16,384 columns</strong>, and a cell can hold up to <strong>32,767 characters</strong>; an Access database is limited to <strong>2 GB</strong> (including all its objects). Almost nobody hits the row limit before hitting the seven signs below.</p>
{{img:limites}}

<h2>The seven signs</h2>
<ol>
<li><strong>Several people edit at once and overwrite each other.</strong> "final", "final_v2" and "final_definitive" files appear. Excel allows co-authoring on files stored in Microsoft's cloud, but it lacks the rules, record-level locking and traceability of a database.</li>
<li><strong>The same data is written in several ways.</strong> "Ferretería El Tornillo", "Ferreteria El Tornillo" and "FERRETERÍA EL TORNILLO" are three different customers to Excel (see the example below).</li>
<li><strong>You need per-person permissions or an audit trail.</strong> Having a fifth-grade teacher see only their students, or knowing who changed a grade and when, is hard to achieve in a shared workbook.</li>
<li><strong>The file is slow, heavy or fragile.</strong> It takes minutes to open, freezes or is nearing hundreds of thousands of rows with heavy formulas.</li>
<li><strong>You need to prevent inconsistent data.</strong> Orders for customers that do not exist, duplicate codes, impossible dates. A database can reject them by rule; Excel only warns if someone set up validation and nobody deletes it.</li>
<li><strong>Other applications need the data.</strong> If someone copies and pastes every week from the workbook to billing, the website or bulk email, you already have a process that calls for a central, automatic source.</li>
<li><strong>You handle personal or sensitive data.</strong> A file traveling by email, with copies on every computer, is hard to protect and audit. Colombia's Law 1581 of 2012 requires data controllers to apply security measures to personal data (see <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">student data</a>). That is why a document like a student's PIAR should not live in a sheet that gets passed around: <a href="/herramientas/piar/">PIAR con IA</a> keeps it in an account with controlled access.</li>
</ol>

<h2>An example with code: two customers that look like five</h2>
<p>A small business records six orders in a sheet. Two real customers, but written with and without accents and in capitals. Excel, when counting distinct customers or summarizing with a pivot table, treats them as different customers. The same happens in SQL when grouping on free text. I checked it with SQLite:</p>
<pre><code>-- Flat file: customer as free text
SELECT cliente, COUNT(*) AS pedidos, SUM(valor) AS total
FROM pedidos_plano GROUP BY cliente;
-- Result: 5 "customers" (Ferretería, Ferreteria, FERRETERÍA, Papelería, Papeleria)
-- Each with 1 or 2 orders and partial totals.</code></pre>
<p>The fix is not more discipline when typing (nobody always writes the same way) but <strong>modeling the data</strong>: a customers table with a unique code and an orders table that points to that code.</p>
<pre><code>CREATE TABLE clientes(
  id INTEGER PRIMARY KEY,
  nombre TEXT UNIQUE,
  ciudad TEXT);

CREATE TABLE pedidos(
  pedido INTEGER PRIMARY KEY,
  fecha TEXT,
  cliente_id INT REFERENCES clientes(id),
  producto TEXT, cantidad INT, valor INT);

SELECT c.nombre, COUNT(*) AS pedidos, SUM(p.valor) AS total
FROM pedidos p JOIN clientes c ON c.id = p.cliente_id
GROUP BY c.nombre;
-- Ferretería El Tornillo | 3 | 570000
-- Papelería Central      | 3 | 350000</code></pre>
<p>Now the totals are right and, with foreign keys enabled, the database <strong>rejects</strong> an order for a customer that does not exist ("FOREIGN KEY constraint failed") and a repeated customer ("UNIQUE constraint failed"), which I also tested. The downloadable workbook includes this same case in both forms: the flat file (where a formula counts 4 distinct "customers", because Excel ignores capitalization but not accents) and the normalized model.</p>

<h2>Excel, database or web application</h2>
<p>It is not a choice between good and bad, but between needs:</p>
{{img:decision}}
<table>
<thead><tr><th>Option</th><th>Strength</th><th>Limitation</th><th>When to choose it</th></tr></thead>
<tbody>
<tr><td><strong>Excel</strong></td><td>Flexible, quick to build, ideal for analysis</td><td>Limited simultaneous editing, no integrity rules or fine-grained permissions</td><td>A small team, non-sensitive data, reports and models</td></tr>
<tr><td><strong>Database (Access, SQLite, PostgreSQL, SQL Server…)</strong></td><td>Integrity, queries, permissions, backup, volume</td><td>Requires designing the model and someone to administer it</td><td>Several users, related data, business rules</td></tr>
<tr><td><strong>Web application on a database</strong></td><td>Forms, access from anywhere, roles</td><td>Higher development and maintenance cost</td><td>Many external users or critical processes (see <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a>)</td></tr>
</tbody>
</table>
<p>And it is not one or the other: the most sensible approach is usually <strong>the database stores and Excel analyzes</strong>. With Power Query you can connect Excel to a database and analyze it with pivot tables, with no copy and paste (see <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">Power Query, VBA, Office Scripts and Python</a>).</p>

<h2>How to migrate without losing information</h2>
<ol>
<li><strong>Back up and freeze</strong> the current file with a date (see <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">the cloud is not a backup</a>).</li>
<li><strong>Name the owner</strong> of the data and who can see or change what.</li>
<li><strong>Identify the entities</strong> (customers, products, orders) and each one's unique key.</li>
<li><strong>Clean</strong> duplicates and variants before importing (see <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">importing CSV correctly</a>).</li>
<li><strong>Import into a test environment</strong> and compare totals with the original file; they must match.</li>
<li><strong>Decide how new data will be captured</strong> and train users.</li>
<li><strong>Keep the old file read-only</strong> for a while and measure the results.</li>
</ol>
<p>The "Checklist_migracion" sheet in the downloadable workbook has these steps with checkboxes.</p>

<h2>Colombia, Latin America and the world</h2>
<p>Everywhere, small businesses and schools start in Excel because they already have it and it works. In Colombia and Latin America, cost weighs too: moving to a system with a server, licenses or development can look like a luxury, which is why comparing first matters (see <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a>). For <strong>teachers and coordinators</strong>, the most common sign is the same student list in five files; for <strong>principals</strong>, the risk of sensitive data in an uncontrolled file; for <strong>families</strong>, that their children's data does not travel by email in unprotected sheets.</p>

<h2>Tools to keep your Excel data in order</h2>
<p>If you do not need a database yet, these templates help you keep data organized and controlled:</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>There is also a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a> to work your data better.</p>

<h2>Frequently asked questions</h2>
<h3>How many rows can Excel handle?</h3>
<p>According to Microsoft, a worksheet supports 1,048,576 rows and 16,384 columns. In practice, the file becomes slow or unmanageable much earlier, especially with heavy formulas.</p>
<h3>When should I move from Excel to a database?</h3>
<p>When several people edit at once, the same data appears repeated and different, you need permissions or an audit trail, or other applications require the data. With four or more signs, plan the migration.</p>
<h3>Is Access still useful or is it obsolete?</h3>
<p>It works for small teams on Windows, with the 2 GB limit per database. For more users or web access, other databases (PostgreSQL, SQL Server or MySQL) are usually chosen.</p>
<h3>Can I keep using Excel after migrating?</h3>
<p>Yes, and it is recommended: the database stores the data and Excel queries and analyzes it with Power Query and pivot tables.</p>
<h3>Do I need to know how to program?</h3>
<p>For the basic model, a few SQL statements like those in the example are enough, and visual tools exist. For a full application, technical support is advisable.</p>

<p class="notice"><strong>Do the self-assessment today.</strong> Download the <a href="/descargas/excel-base-de-datos/siete-senales-excel-base-de-datos.xlsx">seven-signs workbook</a> (in Spanish), mark which ones apply to you and see what it recommends. It includes the sample data and the migration checklist.</p>

<h2>Food for thought</h2>
<p>Many organizations never decided that their information would live in Excel: it simply happened. <strong>Is Excel's convenience a merit of the tool or a trap that keeps us from ordering our processes? And if the institution's most valuable data (its students, its customers) lives in a file anyone can copy, who is responsible for making sure it is not lost, altered or leaked?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:limites}}' => $img('excel-base-de-datos-limites', 573, 'Four cards with the official limits: 1,048,576 rows and 16,384 columns per Excel worksheet, 32,767 characters per cell and 2 GB for an Access database.', 'The technical limits that do exist.'),
    '{{img:decision}}' => $img('excel-base-de-datos-decision', 499, 'Table comparing when Excel is enough and when a database is better by users, integrity, security and integration.', 'Excel or a database?'),
]);

return [
    'cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos' => [
        'slug' => 'when-excel-stops-being-the-solution-seven-signs-you-need-a-database',
        'title' => 'When Does Excel Stop Being the Solution? Seven Signs You Need a Database',
        'excerpt' => 'Seven concrete signs your Excel file has fallen short, an example with tested SQL code, a comparison of Excel, database and web application, and a downloadable self-assessment and migration workbook.',
        'seo_title' => 'Excel or Database: Seven Signs It Is Time to Migrate',
        'seo_description' => 'Seven signs Excel has fallen short and you need a database, with a SQL example, a comparison and a downloadable workbook to decide and migrate.',
        'focus_keyword' => 'Excel vs database',
        'cover' => '/assets/img/articulos/excel-base-de-datos/excel-base-de-datos-portada-en',
        'cover_alt' => 'Cover "When does Excel stop being the solution? Seven signs you need a database" with a card of four signs: simultaneous editing, data typed several ways, per-person permissions and other applications that need the data.',
        'content_html' => $html,
    ],
];
