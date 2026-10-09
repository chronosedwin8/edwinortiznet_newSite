<?php

declare(strict_types=1);

// «Tener archivos en la nube no significa tener un respaldo: siete mitos». Datos verificados el 9 de octubre de 2026: papelera de OneDrive (93 días en
// cuentas de trabajo o escuela, 30 en personales; Restaurar OneDrive hasta 30 días con Microsoft 365), papelera de Google Drive (30 días), informe
// Ransomware Trends 2024 de Veeam (96 % de los ataques apuntó a los respaldos), cláusula de respaldo del Contrato de Servicios de Microsoft y regla 3-2-1.
// El script de verificación de restauración (PowerShell) se probó con una carpeta de origen y otra restaurada con un archivo faltante, uno alterado y uno sobrante.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/nube-no-es-respaldo/' . $name;
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
<p>«Tranquilo, todo está en la nube.» Es la frase que más escucho antes de una pérdida de datos. Una carpeta compartida se borra por error, un virus cifra los archivos del computador, alguien sobrescribe la hoja de cálculo del año con una versión vacía. Y la nube, que hacía su trabajo, replica el daño en todos los dispositivos. <strong>Sincronizar no es respaldar</strong>, y confundirlo es una de las causas más comunes de pérdida de datos en pymes, colegios y familias.</p>
<p>En este artículo desmonto siete mitos, explico en qué se diferencian la sincronización, la redundancia, el respaldo y la recuperación ante desastres, te dejo una estrategia simple y un <strong>script para comprobar que una restauración funciona</strong>. Datos verificados el 9 de octubre de 2026.</p>
<p class="notice"><strong>Resumen.</strong> La nube sincroniza; un respaldo es una copia independiente, con versiones, fuera del alcance del daño original y probada. La regla 3-2-1 (tres copias, dos tipos de medio, una fuera del sitio) es el punto de partida; y la única prueba de que un respaldo sirve es restaurarlo. Haz hoy una prueba de recuperación con un archivo y una carpeta.</p>

<h2>Cuatro conceptos que se confunden</h2>
<table>
<thead><tr><th>Concepto</th><th>Qué hace</th><th>Qué NO hace</th></tr></thead>
<tbody>
<tr><td><strong>Sincronización</strong> (OneDrive, Google Drive, Dropbox)</td><td>Mantiene los mismos archivos en varios dispositivos y en la nube.</td><td>No te protege de borrados, errores o cifrado: los replica.</td></tr>
<tr><td><strong>Redundancia</strong> (RAID, disco espejo)</td><td>Hace que el sistema siga funcionando si falla un disco.</td><td>No protege de borrados, virus ni errores: copia también el daño.</td></tr>
<tr><td><strong>Respaldo</strong> (copia de seguridad)</td><td>Una copia independiente y con versiones, que permite volver a un punto anterior.</td><td>No sirve si nunca se probó, o si está al alcance del atacante.</td></tr>
<tr><td><strong>Recuperación ante desastres</strong></td><td>El plan para volver a operar: qué se restaura, en qué orden, quién y en cuánto tiempo.</td><td>No existe si solo hay copias y nadie sabe cómo usarlas.</td></tr>
</tbody>
</table>
{{img:diferencia}}

<h2>Los siete mitos</h2>
<h3>Mito 1: «Está en la nube, así que está respaldado»</h3>
<p>Falso. La sincronización replica los cambios, incluidos los malos. Si borras una carpeta, desaparece en todos tus equipos; si un ransomware cifra tus archivos locales, las versiones cifradas se sincronizan. Algunos servicios ofrecen papelera y versiones, y eso ayuda, pero es una red de seguridad con plazos, no un respaldo.</p>
<h3>Mito 2: «Si lo borro por error, siempre lo recupero»</h3>
<p>Depende del plazo. Según Microsoft, la papelera de OneDrive guarda los elementos eliminados hasta 93 días en cuentas de trabajo o escuela (salvo que el administrador lo cambie) y hasta 30 días en cuentas personales; y la función <a href="https://support.microsoft.com/onedrive/restore-your-onedrive">Restaurar OneDrive</a> permite deshacer cambios de hasta 30 días, con una suscripción de Microsoft 365 en cuentas personales. Google, por su parte, borra automáticamente los archivos de la papelera de Drive <a href="https://workspaceupdates.googleblog.com/2020/09/drive-trash-auto-delete-30-days.html">a los 30 días</a>. Pasado el plazo, o si se vacía la papelera, <strong>no hay forma de recuperarlo</strong>.</p>
<h3>Mito 3: «El proveedor se encarga de mis datos»</h3>
<p>Microsoft lo dice en su Contrato de Servicios para consumidores: recomienda que hagas copias de seguridad regulares de tu contenido, y una versión próxima del contrato, publicada en julio de 2026 (no pude confirmar si ya está vigente), usa un lenguaje más fuerte («le aconsejamos encarecidamente»). Cada proveedor tiene sus propias condiciones, y las de las cuentas empresariales pueden diferir; lo prudente es asumir que <strong>el proveedor protege su infraestructura, y tú tu información</strong>. En Colombia, además, la Ley 1581 de 2012 incluye el principio de seguridad: quien trata datos personales debe adoptar medidas para evitar su pérdida, adulteración o acceso no autorizado.</p>
<h3>Mito 4: «Mi servidor tiene discos en espejo (RAID), así que tengo respaldo»</h3>
<p>La redundancia protege de la falla de un disco, no de un borrado, un error humano, un virus o un incendio: si el archivo se corrompe, se corrompe en ambos discos. Es disponibilidad, no respaldo.</p>
<h3>Mito 5: «Con un disco externo conectado basta»</h3>
<p>Un disco que siempre está conectado es también un blanco para el ransomware. Según el <em>Ransomware Trends Report 2024</em> de Veeam, según el resumen de SDxCentral, <a href="https://www.sdxcentral.com/news/ransomware-recovery-progress-is-being-made-but-theres-more-work-to-be-done/">el 96 % de los ataques apuntó a los repositorios de respaldo</a> de las víctimas (encuesta a más de mil profesionales de seguridad y respaldo). La defensa es tener <strong>al menos una copia desconectada, fuera del sitio o inmutable</strong>.</p>
<h3>Mito 6: «Mi respaldo dice “completado”, así que funciona»</h3>
<p>Un respaldo «completado» solo prueba que el programa terminó, no que los archivos se puedan restaurar ni que estén íntegros. Respaldos que nunca se probaron fallan justo cuando más se necesitan: por claves perdidas, archivos corruptos, carpetas que no se incluyeron o software que ya no abre el formato.</p>
<h3>Mito 7: «Si pasa algo, lo recupero rápido»</h3>
<p>Recuperar toma tiempo, y ese tiempo cuesta. Hay dos preguntas que definen tu plan: <strong>¿cuánta información puedo permitirme perder?</strong> (punto objetivo de recuperación, RPO) y <strong>¿cuánto tiempo puedo estar sin operar?</strong> (tiempo objetivo de recuperación, RTO). Si no las has respondido, no sabes si tu respaldo diario o semanal es suficiente.</p>
{{img:datos}}

<h2>Una estrategia simple: 3-2-1 y una prueba</h2>
<p>La regla <strong>3-2-1</strong> es el punto de partida: <strong>tres copias</strong> de tus datos (el original y dos respaldos), en <strong>dos tipos de medio</strong> distintos (por ejemplo, tu computador y un disco externo o la nube) y <strong>una copia fuera del sitio</strong> (otra ubicación, o la nube). Contra el ransomware se recomienda añadir una copia <strong>inmutable o desconectada</strong> y verificar que restaura sin errores (la variante «3-2-1-1-0»). Para una pyme o un colegio, un esquema realista es:</p>
<ul>
<li>El original en el computador o servidor de trabajo.</li>
<li>Un respaldo automático y con versiones en la nube, <strong>distinto</strong> de la carpeta sincronizada.</li>
<li>Un disco externo que se conecta solo para respaldar y luego se desconecta y se guarda en otro lugar.</li>
<li>Una prueba de restauración programada (cada trimestre) y una lista escrita de qué se restaura primero.</li>
</ul>

<h2>La prueba de recuperación: cómo comprobar que puedes restaurar</h2>
<p>Este es el recurso aplicable. Sigue estos pasos con un archivo y una carpeta, no con todo:</p>
<ol>
<li><strong>Elige</strong> un archivo importante y una carpeta con subcarpetas.</li>
<li><strong>Restáuralos</strong> desde el respaldo a una ubicación <em>diferente</em> (por ejemplo, otro equipo o una carpeta temporal), como si el original no existiera.</li>
<li><strong>Verifica la integridad:</strong> ¿están todos los archivos y son idénticos al original? El script de abajo lo hace comparando huellas SHA-256.</li>
<li><strong>Abre</strong> algunos archivos con su programa (una hoja de Excel, un documento) para comprobar que se leen.</li>
<li><strong>Mide el tiempo</strong> que tomó y anótalo: es tu RTO real, no el supuesto.</li>
<li><strong>Documenta</strong> el procedimiento y repítelo cada trimestre.</li>
</ol>
<p>Este script de PowerShell compara una carpeta original con la restaurada y reporta lo que falta, lo que cambió y lo que sobra. Lo probé con una restauración defectuosa (un archivo faltante, uno alterado y uno sobrante) y detectó los tres:</p>
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
<p>Se ejecuta así: <code>.\verificar-restauracion.ps1 -Origen "D:\Datos" -Restaurado "E:\PruebaRestauracion"</code>. Puedes <a href="/descargas/respaldo/verificar-restauracion.ps1">descargar el script</a> (es gratis; revísalo antes de ejecutarlo, como cualquier script que descargues). Si la restauración reporta «CON PROBLEMAS», <strong>ese respaldo no es confiable</strong> y mejor enterarte hoy que el día del desastre.</p>

<h2>Colombia, Latinoamérica y el mundo</h2>
<p>Los datos de Veeam o IBM son globales, pero la lección se aplica igual aquí: en Colombia, según la Estrategia Nacional de Seguridad Digital citada por la prensa, el país fue el segundo más atacado de América Latina en 2025 (lo conté en <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">el artículo sobre errores básicos de seguridad</a>), y muchas pymes, oficinas contables y colegios guardan lo esencial en un computador y en una carpeta sincronizada. Para un <strong>contador</strong>, el riesgo es perder la contabilidad del año; para un <strong>docente</strong>, perder notas, planeaciones y evidencias; para un <strong>directivo</strong>, no poder operar la matrícula; para una <strong>familia</strong>, perder las fotos de los hijos. La Ley 1581 recuerda que, si hay datos personales, la seguridad es una obligación y no solo una buena práctica.</p>

<h2>Herramientas para trabajar con tus datos con orden</h2>
<p>Lo que hoy vive en una hoja de Excel (asistencia, notas, facturas) es justo lo que más duele perder. El <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">Listado de asistencia laboral o académica en Excel</a> y la <a href="/producto/plantilla-en-excel-de-factura-sencilla-numeracion-automatica/">Factura sencilla con numeración automática</a> son archivos que conviene incluir en tu rutina de respaldo desde el primer día. Y los documentos que generes en cualquier herramienta, incluidas las mías (<a href="/herramientas/generador-de-examenes/">Generador de exámenes con IA</a>, <a href="/herramientas/piar/">PIAR con IA</a>), <strong>descárgalos y guárdalos tú</strong>: no dependas de que la plataforma los conserve.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,plantilla-en-excel-de-factura-sencilla-numeracion-automatica}}
<p>Sigue leyendo: <a href="/riesgo-oculto-excel-auditoria-control-versiones/">el riesgo oculto de Excel: auditoría y control de versiones</a>, <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">agentes de IA con acceso a tus sistemas</a> y <a href="/estafas-voz-clonada-ia-protocolo-verificacion/">estafas con voz clonada</a>.</p>

<h2>Preguntas frecuentes</h2>
<h3>¿OneDrive o Google Drive son un respaldo?</h3>
<p>No por sí solos. Son sincronización con papelera y versiones de plazo limitado. Sirven como una de las copias, pero no sustituyen un respaldo independiente.</p>
<h3>¿Cada cuánto debo hacer una copia de seguridad?</h3>
<p>Depende de cuánta información puedas permitirte perder: si perder un día de trabajo es inaceptable, el respaldo debe ser diario o continuo. Define tu RPO y tu RTO y ajusta la frecuencia a esas respuestas.</p>
<h3>¿Qué es la regla 3-2-1?</h3>
<p>Tres copias de tus datos, en dos tipos de medio distintos, con una copia fuera del sitio. Contra el ransomware se recomienda además una copia inmutable o desconectada y probar la restauración.</p>
<h3>¿Con qué frecuencia debo probar la restauración?</h3>
<p>Al menos cada trimestre y después de cualquier cambio importante en tu sistema de respaldo. Una prueba pequeña (un archivo y una carpeta) es mucho mejor que ninguna.</p>
<h3>¿Un ransomware puede cifrar también mis respaldos?</h3>
<p>Sí, si están conectados o accesibles desde el equipo infectado. Por eso se recomienda tener una copia desconectada o inmutable, y por eso los atacantes buscan primero los respaldos.</p>

<p class="notice"><strong>Haz tu prueba de recuperación esta semana.</strong> Elige un archivo y una carpeta, restáuralos en otra ubicación y verifica con el <a href="/descargas/respaldo/verificar-restauracion.ps1">script de verificación</a>. Anota cuánto tardaste y qué falló. Y si usas Excel para lo importante, incluye <a href="/producto/listado-de-asistencia-laboral-o-academica-en-excel/">tus plantillas</a> en tu rutina de respaldo.</p>

<h2>Para pensar</h2>
<p>Pagamos seguros para el carro, la casa y la salud, pero tratamos el respaldo de los datos como un lujo opcional que se hace «cuando haya tiempo». <strong>Si un archivo tiene más valor que el computador donde vive (la contabilidad de la empresa, las notas de un año, las fotos de los hijos), ¿por qué le dedicamos menos cuidado que a un electrodoméstico, y quién debería exigirnos ese cuidado: la ley, el cliente o nosotros mismos?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:diferencia}}' => $img('nube-no-es-respaldo-diferencia', 625, 'Comparación entre sincronización en la nube, que replica borrados, errores y archivos cifrados, y respaldo, que es una copia independiente con versiones, fuera del sitio y probada.', 'Sincronizar no es respaldar.'),
    '{{img:datos}}' => $img('nube-no-es-respaldo-datos', 573, 'Cuatro tarjetas: la papelera de OneDrive dura 93 días en cuentas de trabajo o escuela y 30 en personales, la de Google Drive 30 días, el 96 % de los ataques de ransomware apuntó a los respaldos y la regla 3-2-1.', 'Plazos de la papelera, ataques a los respaldos y la regla 3-2-1.'),
]);

return [
    'slug' => 'archivos-en-la-nube-no-es-respaldo-siete-mitos-datos',
    'title' => 'Tener archivos en la nube no significa tener un respaldo: siete mitos que ponen en riesgo tus datos',
    'excerpt' => 'Sincronización, redundancia, respaldo y recuperación son cosas distintas. Siete mitos sobre la nube y el respaldo, la regla 3-2-1 y un script para comprobar que una restauración funciona.',
    'seo_title' => 'La nube no es un respaldo: siete mitos sobre tus datos',
    'seo_description' => 'Por qué tener archivos en la nube no es tener un respaldo: siete mitos, la regla 3-2-1 y un script para probar que puedes restaurar tus datos.',
    'focus_keyword' => 'la nube no es un respaldo',
    'cover' => '/assets/img/articulos/nube-no-es-respaldo/nube-no-es-respaldo-portada',
    'cover_alt' => 'Portada con el título «Tener archivos en la nube no es tener un respaldo: siete mitos que ponen en riesgo tus datos» y una tarjeta con cuatro conceptos distintos: sincronización, redundancia, respaldo y recuperación.',
    'published_at' => '2026-11-03 12:00:00',
    'content_html' => $html,
];
