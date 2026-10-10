<?php

declare(strict_types=1);

// English version of «Inventario tecnológico del colegio con trazabilidad: movimientos, garantías y un…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/inventario-tecnologico/' . $name . '-en';
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
<p>"Where is the laptop we bought in 2022?" "I think the chemistry teacher has it." "No, she returned it and the math teacher took it." It is a normal conversation in a school without a reliable inventory. The cost is not just the lost device: it is the warranty that expired with nobody claiming it, the renewal that was not budgeted, the computer with student data that nobody knows where it ended up and the <strong>inability to answer the simplest question: what do we have and who has it?</strong></p>
<p>This article proposes a technology inventory with <strong>traceability</strong>: not a static list of devices, but an inventory plus a movement log, where each change (entry, assignment, transfer, loan, repair, write-off) leaves a dated row. It includes an <a href="/descargas/inventario-tecnologico/inventario-tecnologico-trazabilidad.xlsx">Excel workbook</a> (in Spanish) with 20 fictional assets and 28 movements and a <a href="/descargas/inventario-tecnologico/auditor_inventario.py">Python auditor</a> with two sample CSVs, which detect when the data no longer match reality. The results were verified in Microsoft Excel 16 and the script was cross-checked against the workbook. Reviewed on October 10, 2026.</p>
<p class="notice"><strong>Scope.</strong> This is a technology asset management guide, not accounting or legal advice. In public schools, the registration, control and write-off of assets follow the procedures of the territorial entity and the school services fund, and service life and depreciation are defined by the applicable accounting policies; in private ones, the institution's. The example data are fictional and the parameters (service life, notice days) are editable.</p>

<h2>A list is not an inventory</h2>
<p>A sheet with devices and their location is a snapshot of the day it was made. The following month, someone carries a projector to another room, someone else lends a tablet and a laptop goes for repair; the sheet still says the same. Over time, <strong>the inventory stops describing reality</strong> and nobody trusts it. The solution is to separate two things:</p>
<ul>
<li><strong>The inventory:</strong> what each asset is (ID, type, serial), its life cycle (purchase, warranty, service life) and its declared status (location, owner, condition).</li>
<li><strong>The movements:</strong> a dated log of each change. The <strong>last movement</strong> of each ID is its real status; if the inventory says something else, something was not updated.</li>
</ul>
{{img:datos}}

<h2>The workbook, sheet by sheet</h2>
<ul>
<li><strong>Parametros:</strong> the review date (fixed in the example; in real use, <code>=TODAY()</code>), the notice days before a warranty expires and the service life by device type (laptop 4 years, tablet 3, projector 5, access point 6, printer 5, desktop PC 5; editable example values).</li>
<li><strong>Inventario:</strong> one asset per row, with formulas that calculate warranty expiry, its status (valid, expiring soon, expired), the end of service life, the last location and last owner according to the movements, whether they match what is declared and whether the serial is duplicated.</li>
<li><strong>Movimientos:</strong> date, ID, movement type, destination and owner. Always recorded in chronological order.</li>
<li><strong>Resumen:</strong> the key counts.</li>
</ul>
<pre><code>' Warranty expires = purchase + warranty months
=EDATE(D4,E4)                                                             ' English
=FECHA.MES(D4;E4)                                                         ' Spanish

' Warranty status against the review date
=IF(I4<Parametros!$B$3,"Vencida",IF(I4-Parametros!$B$3<=Parametros!$B$4,"Vence pronto","Vigente"))

' End of service life = purchase + (type's service life × 12 months)
=EDATE(D4,VLOOKUP(B4,Parametros!$A$7:$B$12,2,FALSE)*12)

' Last location according to movements: the last row whose ID matches
=LOOKUP(2,1/(Movimientos!$B$4:$B$300=A4),Movimientos!$D$4:$D$300)       ' English
=BUSCAR(2;1/(Movimientos!$B$4:$B$300=A4);Movimientos!$D$4:$D$300)       ' Spanish

' Does it match the inventory?
=IF(AND(F4=M4,G4=N4),"Sí","No")</code></pre>
<p>The trick in the last formula deserves an explanation: <code>1/(range=ID)</code> yields 1 where the ID matches and a divide-by-zero error where it does not; <code>LOOKUP(2, ...)</code> ignores the errors and returns the value of the <strong>last</strong> matching row, which equals "the last movement of this ID". It works because movements are in chronological order; if you sort them otherwise, the result changes.</p>

<h2>What the workbook found (fictional data)</h2>
<p>With a review date of January 25, 2027:</p>
<ul>
<li><strong>20 assets:</strong> 18 operational, 1 under repair and 1 written off.</li>
<li><strong>Warranties:</strong> 14 expired, 2 about to expire (a tablet on February 11 and a laptop on March 3, 2027) and 4 valid. Those two dates are the only chances to claim at no cost.</li>
<li><strong>Service life reached:</strong> 11 of the 19 assets not written off have passed the example's service life. It is data for budgeting renewals (see <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">the total cost of buying, subscribing or building</a>), not a replacement order: a device can keep serving beyond its nominal service life, with more risk and less support.</li>
<li><strong>Four assets with mismatched data:</strong> a tablet that the inventory places in the cart but that, per the last movement, has been at an external workshop since November; a PC written off in December but still in the computer lab in the inventory; a laptop moved to the lab in June while the inventory still places it in Room 302; and a projector moved from Room 204 to 205 in February.</li>
<li><strong>Duplicate serials and assets without movements:</strong> none.</li>
</ul>
<p>What matters in this result is not the figures but <strong>what kind of mismatch appears</strong>: none is a loss, all are <em>updates nobody made</em>. The dynamic is the usual one: someone moved something and did not record it.</p>

<h2>The Python auditor</h2>
<p>The <code>auditor_inventario.py</code> script reads two CSVs (<code>inventario.csv</code> and <code>movimientos.csv</code>) and reports findings with a risk level. It uses only the Python 3.8+ standard library and does not modify the files. It checks: duplicate IDs and serials, empty required fields, movements for IDs that do not exist, assets without movements, mismatches between the inventory and the last movement, and warranties about to expire. (Its messages are in Spanish.)</p>
<pre><code>python auditor_inventario.py inventario-ejemplo.csv movimientos-ejemplo.csv --fecha 2027-01-25

Activos: 20 | movimientos: 28 | fecha de revisión: 2027-01-25
Resumen: {'garantia vencida': 14, 'vida util cumplida (sin bajas)': 11, 'garantia vence pronto': 2}
 - ALTO: ACT-007: el inventario dice Carro de tabletas / Biblioteca, el último movimiento (2026-11-03, Reparación) dice Taller externo / Sistemas
 - ALTO: ACT-017: el inventario dice Sala de sistemas / Sistemas, el último movimiento (2026-12-10, Baja) dice Bodega de bajas / Sistemas
 - ALTO: ACT-018: el inventario dice Aula 302 / Docente Torres, el último movimiento (2026-06-15, Traslado) dice Laboratorio / Docente Torres
 - ALTO: ACT-020: el inventario dice Aula 204 / Docente Vega, el último movimiento (2026-02-02, Traslado) dice Aula 205 / Docente Vega
 - BAJO: ACT-018: la garantía vence el 2027-03-03
 - BAJO: ACT-019: la garantía vence el 2027-02-11</code></pre>
<p>The numbers match the Excel workbook's (14 expired warranties, 2 expiring, 11 past service life and 4 mismatches). Two different tools reaching the same result is the best sign that the calculation is right.</p>

<h2>Five practices so the inventory does not rot</h2>
{{img:ciclo}}
<ol>
<li><strong>Label each device</strong> with a visible ID (sticker or engraving) that matches the sheet. Without a label, a physical audit is impossible.</li>
<li><strong>One owner per asset.</strong> When it is "everybody's", it is nobody's. Whoever receives a device signs or confirms the assignment.</li>
<li><strong>Record each movement the same day,</strong> even as a single line. An unrecorded transfer is the cause of almost all mismatches.</li>
<li><strong>Audit monthly</strong> with the workbook or the script, and once a year against physical reality (a physical count).</li>
<li><strong>Close write-offs properly:</strong> secure data erasure (for example, following media sanitization guides such as NIST SP 800-88), a record of the final destination and date. Electrical and electronic devices have waste-management rules (in Colombia, Law 1672 of 2013 on waste electrical and electronic equipment; verify the current regulation and authorized managers).</li>
</ol>
<p>And the inventory is also security: a device not in the inventory is not patched, not backed up and not recovered after an incident (see <a href="/ransomware-que-hacer-primeros-60-minutos-protocolo-colegio-pyme/">what to do in the first 60 minutes of ransomware</a> and <a href="/mesa-de-ayuda-colegio-sin-software-costoso-prioridades-plazos-tickets-excel/">a help desk for the school</a>).</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, public schools manage their assets within the rules of the public sector and the school services fund, and many receive equipment through donations or provisioning from national and local entities, which requires keeping track of what was received; private ones answer to their owners and their accounting. In the region, technology renewal often depends on external programs, with irregular cycles; worldwide, IT asset management (ITAM) is a common practice, and the trend is to keep a single asset base with its history. For <strong>principals</strong>, the inventory is the basis for budgeting and for justifying investments; for <strong>support staff</strong>, it is the difference between handling incidents blind or with context; for <strong>teachers</strong>, knowing which devices they are responsible for avoids surprises; and for <strong>families</strong>, custody of devices containing student data is part of trust. When devices handle personal data, see <a href="/siete-preguntas-antes-de-pegar-datos-en-una-ia-gratuita-matriz/">seven questions before pasting data into a free AI tool</a>.</p>

<h2>Templates and tools</h2>
<p>If you prefer to start from ready-made Excel templates, with support, look at these options. For the teaching side, the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> and <a href="/herramientas/piar/">PIAR with AI</a> are the author's own tools for teachers.</p>
{{productos:soporte-plus-para-las-plantillas-de-excel,kit-de-ia-para-docentes}}
<p>Keep reading: <a href="/proteger-dominio-colegio-registrador-dns-correo-spf-dkim-dmarc-auditor/">protecting the school domain</a>, <a href="/extensiones-del-navegador-riesgos-permisos-inventario-politica/">browser extensions</a> and <a href="/mas-plataformas-no-es-mejor-educacion-deuda-tecnologica-colegios/">more platforms is not better</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is asset traceability?</h3>
<p>The ability to reconstruct its history: where it has been, who has had it and what has happened to it, thanks to a dated record of each movement.</p>
<h3>What minimum data should I record for each device?</h3>
<p>ID, type, serial number, purchase date, warranty, location, owner and condition, plus each movement with a date.</p>
<h3>How often should I audit the inventory?</h3>
<p>A monthly review with the workbook or the script, and a physical count at least once a year.</p>
<h3>What do I do with a written-off device?</h3>
<p>Securely erase the data, record the write-off movement with its final destination and hand it to an authorized manager when it is electronic waste.</p>
<h3>Is the workbook's service life a rule?</h3>
<p>No: they are editable example values. Accounting and technical service life is defined by each institution under its policies.</p>

<p class="notice"><strong>Start with a physical audit.</strong> Download the <a href="/descargas/inventario-tecnologico/inventario-tecnologico-trazabilidad.xlsx">inventory workbook</a> (in Spanish), list your devices with their IDs and record each one's first movement. Then run the <a href="/descargas/inventario-tecnologico/auditor_inventario.py">auditor</a> every month.</p>

<h2>Food for thought</h2>
<p>When something cannot be found, the first reaction is often to look for someone to blame. <strong>What would change at your school if each device had a name, an owner and a history, and finding a missing one were a matter of checking a record and not accusing someone? And who owns the inventory today: a person, a role or nobody?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:datos}}' => $img('inventario-tecnologico-datos', 499, 'Table with four groups of asset data, what each contains and answers: identity, life cycle, status and history.', 'Four groups of data, four questions.'),
    '{{img:ciclo}}' => $img('inventario-tecnologico-ciclo', 467, 'Five stages of an asset life cycle: entry, assignment, support, transfer and write-off.', 'Every change leaves a row.'),
]);

return [
    'inventario-tecnologico-colegio-trazabilidad-movimientos-garantias-auditor' => [
        'slug' => 'school-technology-inventory-traceability-movements-warranties-auditor',
        'title' => 'School Technology Inventory with Traceability: Movements, Warranties and a Python Auditor',
        'excerpt' => 'An inventory that knows where each device is: asset sheet plus a movement log, warranties and service life, with an Excel workbook and a Python auditor that detect when the data do not match reality.',
        'seo_title' => 'School Technology Inventory with Traceability',
        'seo_description' => 'A school equipment inventory with movements, warranties and service life, with an Excel workbook and a Python auditor that detects mismatched data.',
        'focus_keyword' => 'school technology inventory',
        'cover' => '/assets/img/articulos/inventario-tecnologico/inventario-tecnologico-portada-en',
        'cover_alt' => 'Cover "The school tech inventory with traceability: where is each device" with a card: 4 of 20 devices have a location or owner different from their last movement.',
        'content_html' => $html,
    ],
];
