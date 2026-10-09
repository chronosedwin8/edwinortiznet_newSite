<?php

declare(strict_types=1);

// English version of «Tener archivos en la nube no significa tener un respaldo: siete mitos…». Key is the Spanish slug. Data checked on October 9, 2026
// (OneDrive and Google Drive retention, Veeam Ransomware Trends 2024, Microsoft Services Agreement backup clause, 3-2-1 rule). The PowerShell restore-check
// script was tested with a restore missing one file, altering one and adding one. Status and date come from the Spanish post via en/02_recent_posts.php
// (scheduled for Tuesday, November 3, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/nube-no-es-respaldo/' . $name . '-en';
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
<p>"Relax, everything is in the cloud." It is the phrase I hear most before a data loss. A shared folder is deleted by mistake, a virus encrypts the files on the computer, someone overwrites the year's spreadsheet with an empty version. And the cloud, doing its job, replicates the damage on every device. <strong>Syncing is not backing up</strong>, and confusing the two is one of the most common causes of data loss in small businesses, schools and families.</p>
<p>In this article I debunk seven myths, explain how synchronization, redundancy, backup and disaster recovery differ, and give you a simple strategy and a <strong>script to check that a restore works</strong>. Data checked on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> The cloud synchronizes; a backup is an independent copy, with versions, out of reach of the original damage and tested. The 3-2-1 rule (three copies, two types of media, one off-site) is the starting point; and the only proof that a backup works is restoring it. Run a recovery test today with one file and one folder.</p>

<h2>Four concepts that get confused</h2>
<table>
<thead><tr><th>Concept</th><th>What it does</th><th>What it does NOT do</th></tr></thead>
<tbody>
<tr><td><strong>Synchronization</strong> (OneDrive, Google Drive, Dropbox)</td><td>Keeps the same files on several devices and in the cloud.</td><td>It does not protect you from deletions, errors or encryption: it replicates them.</td></tr>
<tr><td><strong>Redundancy</strong> (RAID, mirrored disk)</td><td>Keeps the system running if one disk fails.</td><td>It does not protect against deletions, viruses or errors: it copies the damage too.</td></tr>
<tr><td><strong>Backup</strong></td><td>An independent copy with versions that lets you go back to an earlier point.</td><td>It is useless if it was never tested or if it is within the attacker's reach.</td></tr>
<tr><td><strong>Disaster recovery</strong></td><td>The plan to operate again: what is restored, in what order, by whom and how fast.</td><td>It does not exist if there are only copies and nobody knows how to use them.</td></tr>
</tbody>
</table>
{{img:diferencia}}

<h2>The seven myths</h2>
<h3>Myth 1: "It's in the cloud, so it's backed up"</h3>
<p>False. Synchronization replicates changes, including bad ones. If you delete a folder, it disappears on all your machines; if ransomware encrypts your local files, the encrypted versions sync. Some services offer a recycle bin and versions, and that helps, but it is a safety net with deadlines, not a backup.</p>
<h3>Myth 2: "If I delete it by mistake, I can always recover it"</h3>
<p>It depends on the window. According to Microsoft, OneDrive's recycle bin keeps deleted items for up to 93 days on work or school accounts (unless the administrator changes it) and up to 30 days on personal accounts; and the <a href="https://support.microsoft.com/onedrive/restore-your-onedrive">Restore your OneDrive</a> feature lets you undo changes from up to 30 days ago, with a Microsoft 365 subscription on personal accounts. Google, for its part, automatically deletes files in the Drive trash <a href="https://workspaceupdates.googleblog.com/2020/09/drive-trash-auto-delete-30-days.html">after 30 days</a>. After the window, or if the bin is emptied, <strong>there is no way to recover it</strong>.</p>
<h3>Myth 3: "The provider takes care of my data"</h3>
<p>Microsoft says so in its consumer Services Agreement: it recommends that you regularly back up your content, and an upcoming version of the agreement, published in July 2026 (I could not confirm whether it is already in force), uses stronger language ("we strongly advise you"). Each provider has its own terms, and those of business accounts may differ; the prudent assumption is that <strong>the provider protects its infrastructure, and you protect your information</strong>. In Colombia, moreover, Law 1581 of 2012 includes a security principle: whoever processes personal data must adopt measures to prevent its loss, tampering or unauthorized access.</p>
<h3>Myth 4: "My server has mirrored disks (RAID), so I have a backup"</h3>
<p>Redundancy protects against a disk failure, not against a deletion, a human error, a virus or a fire: if a file is corrupted, it is corrupted on both disks. It is availability, not backup.</p>
<h3>Myth 5: "An external disk plugged in is enough"</h3>
<p>A disk that is always connected is also a target for ransomware. According to Veeam's <em>Ransomware Trends Report 2024</em>, per <a href="https://www.sdxcentral.com/news/ransomware-recovery-progress-is-being-made-but-theres-more-work-to-be-done/">SDxCentral's summary</a>, 96% of attacks targeted the victims' backup repositories (a survey of more than a thousand security and backup professionals). The defense is to have <strong>at least one copy that is disconnected, off-site or immutable</strong>.</p>
<h3>Myth 6: "My backup says 'completed', so it works"</h3>
<p>A "completed" backup only proves the program finished, not that the files can be restored or are intact. Backups that were never tested fail exactly when they are needed most: lost keys, corrupt files, folders that were not included or software that can no longer open the format.</p>
<h3>Myth 7: "If something happens, I'll recover quickly"</h3>
<p>Recovering takes time, and that time costs. Two questions define your plan: <strong>how much information can I afford to lose?</strong> (recovery point objective, RPO) and <strong>how long can I be without operating?</strong> (recovery time objective, RTO). If you have not answered them, you do not know whether your daily or weekly backup is enough.</p>
{{img:datos}}

<h2>A simple strategy: 3-2-1 and a test</h2>
<p>The <strong>3-2-1</strong> rule is the starting point: <strong>three copies</strong> of your data (the original and two backups), on <strong>two different types of media</strong> (for example, your computer and an external disk or the cloud) and <strong>one copy off-site</strong> (another location, or the cloud). Against ransomware it is recommended to add an <strong>immutable or disconnected</strong> copy and to verify that it restores without errors (the "3-2-1-1-0" variant). For a small business or a school, a realistic setup is:</p>
<ul>
<li>The original on the work computer or server.</li>
<li>An automatic backup with versions in the cloud, <strong>separate</strong> from the synchronized folder.</li>
<li>An external disk that is connected only to back up and then disconnected and stored somewhere else.</li>
<li>A scheduled restore test (every quarter) and a written list of what is restored first.</li>
</ul>

<h2>The recovery test: how to check that you can restore</h2>
<p>This is the practical resource. Follow these steps with one file and one folder, not with everything:</p>
<ol>
<li><strong>Choose</strong> an important file and a folder with subfolders.</li>
<li><strong>Restore them</strong> from the backup to a <em>different</em> location (for example, another machine or a temporary folder), as if the original did not exist.</li>
<li><strong>Verify integrity:</strong> are all the files there and identical to the original? The script below does it by comparing SHA-256 hashes.</li>
<li><strong>Open</strong> some files with their program (an Excel sheet, a document) to check that they read.</li>
<li><strong>Time it</strong> and write it down: it is your real RTO, not the assumed one.</li>
<li><strong>Document</strong> the procedure and repeat it every quarter.</li>
</ol>
<p>This PowerShell script compares an original folder with the restored one and reports what is missing, what changed and what is extra. I tested it with a faulty restore (one missing file, one altered and one extra) and it caught all three:</p>
<pre><code>param(
    [Parameter(Mandatory)][string]$Origen,
    [Parameter(Mandatory)][string]$Restaurado
)

function Get-Huellas($raiz) {
    $raiz = (Resolve-Path $raiz).Path.TrimEnd('\')
    $d = @{}
    Get-ChildItem $raiz -Recurse -File | ForEach-Object {
        $d[$_.FullName.Substring($raiz.Length + 1)] = (Get-FileHash $_.FullName -Algorithm SHA256).Hash
    }
    return $d
}

$a = Get-Huellas $Origen
$b = Get-Huellas $Restaurado
$faltan    = @($a.Keys | Where-Object { -not $b.ContainsKey($_) })
$distintos = @($a.Keys | Where-Object { $b.ContainsKey($_) -and $a[$_] -ne $b[$_] })
$sobran    = @($b.Keys | Where-Object { -not $a.ContainsKey($_) })

"Archivos en el origen: $($a.Count) | restaurados: $($b.Count)"
"Faltan: $($faltan.Count) | Distintos (corruptos o modificados): $($distintos.Count) | Sobran: $($sobran.Count)"
$faltan    | ForEach-Object { "  FALTA      $_" }
$distintos | ForEach-Object { "  DISTINTO   $_" }
$sobran    | ForEach-Object { "  SOBRA      $_" }
if ($faltan.Count + $distintos.Count -eq 0) { "RESTAURACION VERIFICADA" } else { "RESTAURACION CON PROBLEMAS: no confies en este respaldo hasta corregirlo" }</code></pre>
<p>You run it like this: <code>.\verificar-restauracion.ps1 -Origen "D:\Data" -Restaurado "E:\RestoreTest"</code> (the messages are in Spanish; "FALTA" means missing, "DISTINTO" means different and "SOBRA" means extra). You can <a href="/descargas/respaldo/verificar-restauracion.ps1">download the script</a> (it is free; review it before running it, like any script you download). If the restore reports "CON PROBLEMAS", <strong>that backup is not reliable</strong>, and it is better to find out today than on disaster day.</p>

<h2>Colombia, Latin America and the world</h2>
<p>The Veeam or IBM data are global, but the lesson applies equally here: in Colombia, according to the National Digital Security Strategy as cited by the press, the country was the second most attacked in Latin America in 2025 (I covered it in <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">the article on basic security mistakes</a>), and many small businesses, accounting offices and schools keep the essentials on one computer and in one synchronized folder. For an <strong>accountant</strong>, the risk is losing the year's books; for a <strong>teacher</strong>, losing grades, lesson plans and evidence; for a <strong>school leader</strong>, being unable to run enrollment; for a <strong>family</strong>, losing the children's photos. Law 1581 reminds us that, where there is personal data, security is an obligation, not just good practice.</p>

<h2>Tools to keep your data in order</h2>
<p>What today lives in an Excel sheet (attendance, grades, invoices) is exactly what hurts most to lose. The <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">Work or academic attendance list in Excel</a> and the <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">Simple invoice with automatic numbering</a> are files worth including in your backup routine from day one. And the documents you generate in any tool, including mine (<a href="/herramientas/generador-de-examenes/">AI Exam Generator</a>, <a href="/herramientas/piar/">PIAR con IA</a>), <strong>download and keep them yourself</strong>: do not depend on the platform keeping them.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,plantilla-en-excel-de-factura-sencilla-numeracion-automatica}}
<p>Keep reading: <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel: audit and version control</a>, <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a> and <a href="/estafas-voz-clonada-ia-protocolo-verificacion/">voice-cloning scams</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Are OneDrive or Google Drive a backup?</h3>
<p>Not on their own. They are synchronization with a recycle bin and versions with limited windows. They work as one of the copies, but do not replace an independent backup.</p>
<h3>How often should I back up?</h3>
<p>It depends on how much information you can afford to lose: if losing a day of work is unacceptable, the backup must be daily or continuous. Define your RPO and RTO and adjust the frequency to those answers.</p>
<h3>What is the 3-2-1 rule?</h3>
<p>Three copies of your data, on two different types of media, with one copy off-site. Against ransomware it is also recommended to have an immutable or disconnected copy and to test the restore.</p>
<h3>How often should I test the restore?</h3>
<p>At least every quarter and after any major change to your backup system. A small test (one file and one folder) is far better than none.</p>
<h3>Can ransomware also encrypt my backups?</h3>
<p>Yes, if they are connected or reachable from the infected machine. That is why a disconnected or immutable copy is recommended, and why attackers go after backups first.</p>

<p class="notice"><strong>Do your recovery test this week.</strong> Pick a file and a folder, restore them to another location and verify with the <a href="/descargas/respaldo/verificar-restauracion.ps1">verification script</a>. Note how long it took and what failed. And if you use Excel for the important things, include <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">your templates</a> in your backup routine.</p>

<h2>Food for thought</h2>
<p>We pay for insurance on the car, the house and our health, but we treat data backup as an optional luxury done "when there is time". <strong>If a file is worth more than the computer it lives on (the company's books, a year of grades, the children's photos), why do we give it less care than an appliance, and who should demand that care of us: the law, the customer or ourselves?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:diferencia}}' => $img('nube-no-es-respaldo-diferencia', 625, 'Comparison between cloud synchronization, which replicates deletions, errors and encrypted files, and backup, which is an independent copy with versions, off-site and tested.', 'Syncing is not backing up.'),
    '{{img:datos}}' => $img('nube-no-es-respaldo-datos', 573, 'Four cards: OneDrive\'s recycle bin lasts 93 days on work or school accounts and 30 on personal ones, Google Drive\'s 30 days, 96% of ransomware attacks targeted backups and the 3-2-1 rule.', 'Recycle bin windows, attacks on backups and the 3-2-1 rule.'),
]);

return [
    'archivos-en-la-nube-no-es-respaldo-siete-mitos-datos' => [
        'slug' => 'files-in-the-cloud-are-not-a-backup-seven-myths',
        'title' => 'Having Files in the Cloud Does Not Mean Having a Backup: Seven Myths That Put Your Data at Risk',
        'excerpt' => 'Synchronization, redundancy, backup and recovery are different things. Seven myths about the cloud and backups, the 3-2-1 rule and a script to check that a restore works.',
        'seo_title' => 'The Cloud Is Not a Backup: Seven Myths About Your Data',
        'seo_description' => 'Why having files in the cloud is not having a backup: seven myths, the 3-2-1 rule and a script to test that you can restore your data.',
        'focus_keyword' => 'the cloud is not a backup',
        'cover' => '/assets/img/articulos/nube-no-es-respaldo/nube-no-es-respaldo-portada-en',
        'cover_alt' => 'Cover reading "Having files in the cloud is not having a backup: seven myths that put your data at risk" with a card of four different concepts: synchronization, redundancy, backup and recovery.',
        'content_html' => $html,
    ],
];
