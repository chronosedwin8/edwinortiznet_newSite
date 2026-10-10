<?php

declare(strict_types=1);

// English version of «Un dato, varias versiones: conciliar el sistema de gestión, el aula virtual y Te…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/conciliar-datos/' . $name . '-en';
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
<p>The report card says Camila is in 8A. In the virtual classroom she appears in 8B. She is not in the 8A math Teams group, and she is in the 8B one, with an email that has an extra letter. The coordinator asks which is the correct datum and the honest answer is that <strong>there are four versions of the same datum and nobody knows which one rules</strong>. This happens when a school uses a school management system, a virtual classroom and a collaboration platform, and it is one of the hidden costs of platform accumulation.</p>
<p>This article proposes two tools to bring order: a <a href="/descargas/conciliar-datos/matriz-fuente-de-verdad.xlsx">source-of-truth matrix in Excel</a> (in Spanish), which defines for each datum which system is the master, who edits it and how it is synchronized, and a <a href="/descargas/conciliar-datos/conciliador.py">Python reconciler</a> that compares two systems' lists and reports where they differ. It is tested with two fictional CSVs (<a href="/descargas/conciliar-datos/sistema-gestion.csv">sistema-gestion.csv</a> and <a href="/descargas/conciliar-datos/aula-virtual.csv">aula-virtual.csv</a>). The script's results were checked against an independent calculation and the matrix was verified in Microsoft Excel 16. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> Platform names (for example, school management systems such as Phidias, virtual classrooms such as Moodle or collaboration spaces such as Microsoft Teams) are <strong>examples</strong>; the method works with any pair of systems that export to CSV. The data are fictional. Real lists contain personal data of minors: handle them under your institution's data-protection rules, do not upload them to external services and delete working files when finished.</p>

<h2>Why several versions appear</h2>
<ul>
<li><strong>Manual entry in each system.</strong> Someone types the class in the management system and another person types it again in the virtual classroom; any error in one of the two copies creates a difference.</li>
<li><strong>Partial or outdated synchronizations.</strong> An integration that runs once a semester lets months of changes through (see <a href="/integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas/">why integrations fail silently</a>).</li>
<li><strong>Changes made on only one side.</strong> A name is corrected on the platform where the error was found, but not in the source system; on the next synchronization the error returns.</li>
<li><strong>Format differences.</strong> Accents, capitals, double spaces, leading zeros that get lost when opening a CSV in a spreadsheet (see <a href="/csv-excel-fechas-cedulas-pesos-importar-correctamente/">how to import CSV into Excel without damaging IDs and dates</a>).</li>
<li><strong>Nobody owns the datum.</strong> When it is "everybody's", it is never corrected.</li>
</ul>
<p>The costs are concrete: report cards with wrong information, students without access to the class they belong to or with access to one they should not, duplicate accounts, guardians who do not receive notices and official reports (for example, on enrollment) that do not match what the school has.</p>

<h2>The central idea: one source of truth per datum</h2>
<p>A <strong>source of truth</strong> (or master system) is the place where a datum is created and corrected; other systems receive it as a copy. It does not mean everything lives in a single program, but that <strong>for each datum there is only one master</strong>. For example: ID number, name and class are kept in the management system; the institutional email and user account, in the collaboration platform; assignments and activities, in the virtual classroom. Copies are updated from the master; a copy is never corrected without correcting the master.</p>
<p>Colombia's Law 1581 of 2012 on personal data protection includes, among its principles, truthfulness or quality: information subject to processing must be truthful, complete, accurate, up to date, verifiable and understandable (verify the current text). Keeping a source of truth is a practical way to comply.</p>

<h2>The source-of-truth matrix</h2>
<p>The <em>Campos</em> sheet lists the data (twelve in the example) and, for each, marks in each system whether it is <strong>Maestro</strong> (master), <strong>Copia</strong> (copy) or <strong>Local</strong>, who edits it, whether it is sensitive and how it is synchronized (automatic, manual or none). An automatic calculation counts the masters and copies and assigns a risk:</p>
<pre><code>' Risk of the datum (masters in H, copies in I, synchronization in G)
=IF(H5=0,"Sin fuente de verdad",IF(H5>1,"Varios maestros",IF(AND(I5>0,G5="Manual"),"Copia manual",IF(AND(I5>0,G5="Ninguna"),"Copia sin sincronizar","Controlado"))))   ' English

=SI(H5=0;"Sin fuente de verdad";SI(H5>1;"Varios maestros";SI(Y(I5>0;G5="Manual");"Copia manual";SI(Y(I5>0;G5="Ninguna");"Copia sin sincronizar";"Controlado"))))   ' Spanish</code></pre>
<p>In the fictional example, of 12 data only <strong>5 are controlled (42%)</strong>; 4 are copies updated by hand (name, class, photograph and user account), 1 is a copy without synchronization (attendance), 1 has two systems that think they are the master (final grades) and 1 has no source of truth (enrollment status, which exists in all three and nobody knows which rules). In addition, one sensitive datum (the photograph) has copies that depend on a manual update. The summary counts how many data require action: 7 of 12.</p>

<h2>The Python reconciler</h2>
<p>The <code>conciliador.py</code> script compares two CSVs by a key column (here, the student code) and reports: records that are in one system and not the other, keys that differ only by leading zeros, format differences that disappear on normalizing and <strong>real conflicts</strong> field by field. It uses only the Python 3.8+ standard library, reads files in UTF-8 and does not modify them. (Its messages are in Spanish.)</p>
<pre><code>python conciliador.py sistema-gestion.csv aula-virtual.csv --llave codigo --campos nombre,correo,curso --nombres Gestión Aula

Gestión: 30 filas | Aula: 29 filas | en ambos: 27
Solo en Gestión (2): ['0027', '0029']
Solo en Aula (1): ['0099']
Posible cero inicial perdido (1): 0012 / 12
Diferencias que desaparecen al normalizar tildes, mayúsculas y espacios: 3
Conflictos en "nombre": 2
   0004: Gestión="Andrea Gómez" | Aula="Andrea Gómez Ruiz"
   0005: Gestión="Camilo Torres" | Aula="Camilo Torrez"
Conflictos en "correo": 2
   0006: Gestión="lucia.mora@colegio.example" | Aula="lucia.mora@colegio.example.com"
   0007: Gestión="santiago.vega@colegio.example" | Aula="santiago.vega@colegio.exmaple"
Conflictos en "curso": 2
   0008: Gestión="7B" | Aula="8A"
   0010: Gestión="7A" | Aula="8B"
Total de conflictos reales: 6</code></pre>
<p>The numbers match an independent calculation done on the same files. Two points in this result deserve attention:</p>
<ul>
<li><strong>The three format differences are not errors.</strong> "María Pérez" versus "MARIA PEREZ", "José  Díaz" (with two spaces) versus "Jose Diaz" and "ÁNGEL Ruiz" versus "Ángel Ruiz" are resolved by normalizing. Reporting them as conflicts would fill the report with noise and hide the real problems. Still, it is worth deciding on a canonical way to write names.</li>
<li><strong>The lost zero is the most treacherous difference.</strong> The code "0012" appears as "12" in the virtual classroom; to a program comparing strings, they are two different students (one "missing" on each side). The script detects that they differ only by leading zeros and reports it as a separate case, so the origin of the problem (an import that treated the code as a number) is fixed instead of creating a new student.</li>
</ul>
<p>In summary, of the 30 students in the management system, <strong>9 have a real problem</strong> in the comparison: 2 are not in the virtual classroom, 1 has a code with a lost zero and 6 have conflicting data (2 names, 2 emails and 2 classes); in addition, there is one record in the virtual classroom that does not match any student on the master list.</p>
{{img:tipos}}

<h2>How to reconcile without making a mess</h2>
{{img:pasos}}
<ol>
<li><strong>Export both lists the same day,</strong> with the same key. A week's difference between exports produces differences that are not errors.</li>
<li><strong>Store the key as text.</strong> If you open the CSV in a spreadsheet, import it specifying the column as text; otherwise you will lose the leading zeros.</li>
<li><strong>Normalize before comparing</strong> (accents, capitals, spaces) and check how many differences were only formatting.</li>
<li><strong>Fix in the master system,</strong> not in the copy, and let it propagate. If you fix the copy, the error will come back on the next synchronization.</li>
<li><strong>Repeat the reconciliation</strong> before each grading cut-off and at the start of each term, and keep the report as evidence.</li>
<li><strong>Treat the files for what they are:</strong> personal data of minors. Limited access, no copies in personal emails or open shared folders, and deletion when finished.</li>
</ol>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, schools report their enrollment to the sector's systems (in basic and secondary education, to the enrollment system managed by the territorial entities and the Ministry), and what the school reports must match what it holds in its internal systems; many also use a school management platform, a virtual classroom and collaboration tools, each with its own list. In the region, integrating school data is a frequent challenge, with institutions running on spreadsheets and others on integrated platforms; worldwide, master data management is an established discipline, and its basic principle is the same as here: one datum, one owner, one master. For <strong>principals</strong>, defining which system rules is a data-governance decision, not a technical one; for <strong>IT staff</strong>, the matrix gives a map to prioritize integrations; for <strong>teachers</strong>, it prevents "their list" from differing from the official one; and for <strong>families</strong>, that communications reach the right person. See also <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">more platforms is not better</a> and <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into a free AI tool</a>.</p>

<h2>Templates and tools</h2>
<p>If you need ready-made Excel templates, with support, or help with your administrative processes, look at these options. For the teaching side, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> are the author's own tools for teachers.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">a help desk for the school</a>, <a href="/inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor/">technology inventory with traceability</a> and <a href="/flujo-de-aprobacion-digital-colegio-formulario-lista-reglas-plazos-medicion/">digital approval flow</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is a source of truth?</h3>
<p>The system where a datum is created and corrected; other systems receive it as a copy. There should be one for each datum.</p>
<h3>Why does the same student appear with different data on two platforms?</h3>
<p>Because of manual typing in each system, partial or outdated synchronizations, corrections made only on the copy and format differences.</p>
<h3>How do I compare two lists without formatting mistakes?</h3>
<p>With a common key stored as text and normalizing accents, capitals and spaces before comparing.</p>
<h3>Why are leading zeros lost?</h3>
<p>Because when a CSV is opened in a spreadsheet, a code like 0012 is read as a number and becomes 12. It is avoided by importing the column as text.</p>
<h3>Does the reconciler modify my files?</h3>
<p>No. It only reads the two CSVs and writes the report on screen.</p>

<p class="notice"><strong>Start with the matrix.</strong> Download the <a href="/descargas/conciliar-datos/matriz-fuente-de-verdad.xlsx">source-of-truth matrix</a> (in Spanish), list your data and systems and see how many are controlled. Then try the <a href="/descargas/conciliar-datos/conciliador.py">reconciler</a> with the sample CSVs before using it with your lists.</p>

<h2>Food for thought</h2>
<p>When a datum has several versions, someone pays the price: almost always the student or their family. <strong>Who is the owner of each datum at your school, and what happens when two people correct it at the same time? And if today you compared two lists from your systems, how many students would appear with a different version of themselves?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:pasos}}' => $img('conciliar-datos-pasos', 467, 'Five steps of the monthly reconciliation: export, normalize, compare, fix and repeat.', 'Reconciliation, step by step.'),
    '{{img:tipos}}' => $img('conciliar-datos-tipos', 553, 'Table with five types of difference between two lists, an example and what to do: missing, lost zero, format, conflict and extra.', 'Not all differences are the same.'),
]);

return [
    'un-dato-varias-versiones-conciliar-sistema-gestion-aula-virtual-teams-conciliador' => [
        'slug' => 'one-datum-several-versions-reconcile-school-system-virtual-classroom-teams-reconciler',
        'title' => 'One Datum, Several Versions: Reconciling the School System, the Virtual Classroom and Teams with a Matrix and a Python Reconciler',
        'excerpt' => 'Why the same student appears with different data on each platform and how to sort it out: a source-of-truth matrix in Excel and a Python reconciler that finds missing records, lost zeros and conflicts between two lists.',
        'seo_title' => 'Reconcile Data Across School Platforms',
        'seo_description' => 'How to reconcile lists from the school system, virtual classroom and Teams: a source-of-truth matrix in Excel and a Python reconciler to detect differences.',
        'focus_keyword' => 'reconcile data across platforms',
        'cover' => '/assets/img/articulos/conciliar-datos/conciliar-datos-portada-en',
        'cover_alt' => 'Cover "One datum, several versions: reconciling school management, the LMS and Teams" with a card: 9 of 30 students have a real problem between two systems.',
        'content_html' => $html,
    ],
];
