<?php
/**
 * Kit de IA para docentes en PDF (dompdf, DejaVu Sans, tamaño carta). Solo en español: los textos fijos están en $L.
 * Portada, índice con páginas (segunda pasada de KitIaDocentes::pdf), capítulos y una ficha por receta.
 * @var array $kit @var array $common @var array $groups @var array $categories @var array $dua
 * @var string $color @var string $soft @var string $edition @var array $pages
 */

$L = [
    'brand' => 'edwinortiz.net · Kit de IA para docentes',
    'title' => 'Kit de IA para docentes',
    'aligned' => 'Alineado con los Estándares Básicos de Competencias, los DBA, las pruebas Saber, el Decreto 1290 de 2009 y el DUA (Decreto 1421 de 2017).',
    'author' => 'Edwin Ortiz Herazo',
    'license' => 'Licencia de uso personal. Prohibida su redistribución o reventa.',
    'recipes' => 'recetas listas para copiar',
    'flows' => 'flujos de trabajo',
    'rubrics' => 'rúbricas con la escala del Decreto 1290',
    'errors' => 'errores típicos de la IA',
    'contents' => 'Contenido',
    'recipe_index' => 'Índice de recetas',
    'chapter' => 'Capítulo',
    'page' => 'Pág.',
    'code' => 'Código',
    'recipe' => 'Receta',
    'grades' => 'Grados',
    'saved' => 'Tiempo ahorrado',
    'when' => 'Cuándo usarla.',
    'variables' => 'Variables: qué escribir',
    'variable' => 'Variable',
    'what' => 'Qué poner',
    'prompt' => 'Instrucción para copiar',
    'prompt_note' => 'También está en prompts.txt con el mismo código.',
    'followups' => 'Seguimientos',
    'example' => 'Ejemplo de resultado revisado',
    'context' => 'Contexto del ejemplo:',
    'check' => 'Revisa antes de usar',
    'step' => 'Paso',
    'goal' => 'Objetivo:',
    'see' => 'Receta',
    'criterion' => 'Criterio',
    'detect' => 'Cómo detectarlo',
    'fix' => 'Cómo corregirlo',
    'focus' => 'Enfoque',
    'keys' => 'Claves',
    'master' => 'Plantilla maestra para crear tus propias instrucciones',
    'verify' => 'Lista de verificación general',
    'dua_prompts' => 'Instrucciones de DUA y ajustes razonables',
    'contexts_intro' => 'Situaciones auténticas para contextualizar problemas, lecturas, proyectos y evaluaciones. Reemplaza con ellas las variables de contexto de las recetas o úsalas como punto de partida para tus propias tareas.',
    'errors_intro' => 'Estos son los errores que más se repiten cuando se usa la IA para preparar material de esta materia. Tenerlos presentes te ahorra correcciones y evita que lleguen al aula.',
    'flows_intro' => 'Los flujos encadenan varias recetas: el resultado de un paso es el insumo del siguiente. Así se obtiene material coherente de principio a fin en una sola sesión de trabajo.',
    'rubrics_intro' => 'Rúbricas analíticas con la escala nacional de desempeño (Superior, Alto, Básico y Bajo). Ajusta los descriptores a tu SIEE y compártelas con los estudiantes antes de la actividad.',
    'recipes_intro' => 'Cada receta empieza en una página nueva para que puedas imprimir solo la que necesitas.',
    'end' => 'Gracias por usar este kit. Si encuentras un error o tienes una idea para una nueva receta, escríbeme en edwinortiz.net/contacto/. Las actualizaciones del kit llegan al mismo correo de tu compra.',
];
$chapters = [
    ['s-intro', 'Presentación'],
    ['s-uso', 'Cómo usar el kit'],
    ['s-anatomia', 'Anatomía de una instrucción'],
    ['s-referentes', 'Referentes curriculares'],
    ['s-mapa', 'Mapa por grados'],
    ['s-recetas', 'Recetas'],
    ['s-cadenas', 'Flujos de trabajo'],
    ['s-rubricas', 'Rúbricas'],
    ['s-errores', 'Errores típicos de la IA en ' . $kit['name']],
    ['s-contextos', 'Banco de contextos colombianos'],
    ['s-dua', 'DUA, PIAR y ajustes razonables'],
    ['s-privacidad', 'Privacidad y datos personales'],
    ['s-politica', 'Política de uso de la IA en el aula'],
    ['s-herramientas', 'Asistentes de IA que funcionan'],
    ['s-glosario', 'Glosario'],
];
$num = array_flip(array_column($chapters, 0));
$box = "\u{2610}"; // casilla de verificación (DejaVu Sans la incluye)
$pg = static fn (string $id): string => isset($pages[$id]) ? (string) $pages[$id] : '00';
$mix = static function (string $hex, string $with, float $f): string {
    $a = sscanf(ltrim($hex, '#'), '%2x%2x%2x');
    $b = sscanf(ltrim($with, '#'), '%2x%2x%2x');
    return sprintf('#%02x%02x%02x', ...array_map(fn ($i) => (int) round($a[$i] + ($b[$i] - $a[$i]) * $f), [0, 1, 2]));
};
$dark = $mix($color, '#000000', .35);
$light = $mix($color, '#ffffff', .22);
$lighter = $mix($color, '#ffffff', .4);
$line = $mix($color, '#ffffff', .78);
$head = static function (string $id) use ($chapters, $num, $L): string {
    $title = $chapters[$num[$id]][1];
    return '<div class="chap" id="' . e($id) . '"><p class="chap__n">' . e($L['chapter'] . ' ' . ($num[$id] + 1)) . '</p><h1 class="chap__t">' . e($title) . '</h1></div>';
};
$prompt = static fn (string $text): string => nl2br(e(trim($text)), false);
$byId = [];
foreach ($kit['recetas'] as $r) {
    $byId[$r['id']] = $r;
}
?>
<!doctype html>
<html lang="es-CO">
<head>
<meta charset="utf-8">
<title><?= e($L['title'] . ' — ' . $kit['name']) ?></title>
<style>
@page { margin: 17mm 17mm 21mm 17mm; }
@page :first { margin: 0; }
* { box-sizing: border-box; }
body { font-family: "DejaVu Sans", sans-serif; font-size: 9.3pt; line-height: 1.5; color: #1f2633; margin: 0; }
p { margin: 0 0 6pt; }
ul, ol { margin: 2pt 0 7pt; padding-left: 14pt; }
li { margin: 0 0 3pt; }
strong, b { font-weight: bold; }
h3 { font-size: 11pt; color: <?= $dark ?>; margin: 12pt 0 5pt; page-break-after: avoid; }
h4 { font-size: 9.6pt; color: <?= $dark ?>; margin: 9pt 0 4pt; page-break-after: avoid; }
code { font-family: "DejaVu Sans Mono", monospace; font-size: 8.4pt; background: <?= $soft ?>; padding: 0 2pt; }
table { width: 100%; border-collapse: collapse; margin: 4pt 0 9pt; }
thead { display: table-header-group; }
tr { page-break-inside: avoid; }
th { background: <?= $color ?>; color: #fff; font-size: 8pt; text-align: left; padding: 5pt 6pt; font-weight: bold; }
td { border-bottom: 0.6pt solid <?= $line ?>; padding: 5pt 6pt; vertical-align: top; font-size: 8.7pt; }
td p:last-child, td ul:last-child { margin-bottom: 0; }
.page-break { page-break-before: always; }

/* Portada */
.cover { position: relative; width: 215.9mm; height: 279mm; background: <?= $color ?>; color: #fff; overflow: hidden; }
.cover__c1 { position: absolute; width: 150mm; height: 150mm; border-radius: 75mm; background: <?= $light ?>; right: -55mm; top: -45mm; }
.cover__c2 { position: absolute; width: 90mm; height: 90mm; border-radius: 45mm; background: <?= $dark ?>; left: -30mm; bottom: -28mm; }
.cover__c3 { position: absolute; width: 22mm; height: 22mm; border-radius: 11mm; background: <?= $lighter ?>; right: 16mm; top: 196mm; }
.cover__in { position: absolute; left: 22mm; right: 22mm; top: 24mm; }
.cover__brand { font-size: 8.5pt; letter-spacing: 1.5pt; text-transform: uppercase; color: #fff; margin: 0 0 40mm; }
.cover__kicker { font-size: 17pt; font-weight: bold; margin: 0 0 3mm; color: #fff; }
.cover__subject { font-size: 40pt; line-height: 1.08; font-weight: bold; margin: 0 0 7mm; color: #fff; }
.cover__tag { font-size: 12.5pt; line-height: 1.45; margin: 0 0 12mm; color: #fff; width: 135mm; }
.stats { width: 150mm; border-collapse: separate; border-spacing: 0 0; margin: 0 0 12mm; }
.stats td { border: 0; width: 25%; padding: 0 6pt 0 0; vertical-align: top; color: #fff; font-size: 8pt; line-height: 1.3; }
.stats b { display: block; font-size: 22pt; line-height: 1.1; margin-bottom: 2pt; }
.cover__aligned { font-size: 8.8pt; line-height: 1.5; width: 140mm; padding-top: 5mm; border-top: 0.8pt solid <?= $lighter ?>; color: #fff; }
.cover__foot { position: absolute; left: 22mm; right: 22mm; bottom: 18mm; font-size: 8.5pt; color: #fff; }
.cover__author { font-size: 11pt; font-weight: bold; margin: 0 0 1mm; }

/* Índice */
.toc-title { font-size: 20pt; color: <?= $dark ?>; margin: 0 0 8pt; }
.toc td { border-bottom: 0.6pt dotted <?= $line ?>; padding: 4.2pt 4pt; font-size: 10pt; }
.toc td.n { width: 22pt; color: <?= $color ?>; font-weight: bold; }
.toc td.p { width: 40pt; text-align: right; color: #4b5563; }
.toc a { color: #1f2633; text-decoration: none; }
.toc-sub td { font-size: 8.6pt; padding: 3pt 4pt; }
.toc-sub td.code { width: 52pt; font-weight: bold; color: <?= $color ?>; }
.toc-sub td.g { width: 78pt; color: #5b6472; }
.toc-sub td.p { width: 32pt; text-align: right; color: #4b5563; }
.toc-sub tr.cat td { background: <?= $soft ?>; color: <?= $dark ?>; font-weight: bold; font-size: 8.4pt; text-transform: uppercase; letter-spacing: .4pt; border-bottom: 0; }

/* Capítulos */
.chap { page-break-before: always; margin: 0 0 12pt; padding: 0 0 8pt; border-bottom: 2pt solid <?= $color ?>; }
.chap__n { font-size: 8pt; letter-spacing: 1.2pt; text-transform: uppercase; color: <?= $color ?>; margin: 0 0 2pt; font-weight: bold; }
.chap__t { font-size: 19pt; line-height: 1.2; color: <?= $dark ?>; margin: 0; }
.lead { font-size: 10pt; color: #374151; }
.note { background: <?= $soft ?>; border-left: 3pt solid <?= $color ?>; padding: 7pt 9pt; margin: 6pt 0 10pt; font-size: 8.8pt; }

/* Mapa */
.band td.g { width: 17%; font-weight: bold; color: <?= $dark ?>; background: <?= $soft ?>; }

/* Divisor de categoría */
.cat-div { page-break-before: always; padding: 70pt 0 0; }
.cat-div__k { font-size: 9pt; letter-spacing: 1.5pt; text-transform: uppercase; color: <?= $color ?>; font-weight: bold; margin: 0 0 4pt; }
.cat-div__t { font-size: 26pt; color: <?= $dark ?>; margin: 0 0 12pt; line-height: 1.15; }
.cat-div table td { font-size: 9pt; }
.cat-div td.code { width: 56pt; font-weight: bold; color: <?= $color ?>; }
.cat-div td.p { width: 40pt; text-align: right; }

/* Ficha de receta */
.recipe { page-break-before: always; }
.rhead { margin: 0 0 6pt; }
.rhead td { border: 0; padding: 0; vertical-align: middle; }
.rid { width: 68pt; }
.rid span { display: block; background: <?= $color ?>; color: #fff; font-weight: bold; font-size: 11pt; text-align: center; padding: 7pt 0; border-radius: 4pt; }
.rtitle { padding-left: 10pt !important; }
.rtitle__cat { font-size: 7.6pt; letter-spacing: 1pt; text-transform: uppercase; color: <?= $color ?>; font-weight: bold; }
.rtitle__t { font-size: 14.5pt; line-height: 1.25; font-weight: bold; color: #111827; }
.rmeta { margin: 0 0 8pt; }
.rmeta td { border: 0; background: <?= $soft ?>; font-size: 8.4pt; padding: 5pt 8pt; width: 50%; }
.rmeta td + td { border-left: 2pt solid #fff; }
.rmeta b { color: <?= $dark ?>; }
.vars td.v { width: 30%; font-family: "DejaVu Sans Mono", monospace; font-size: 8pt; font-weight: bold; color: <?= $dark ?>; }
.prompt { font-family: "DejaVu Sans Mono", monospace; font-size: 7.9pt; line-height: 1.47; background: #f6f7f9; border: 0.7pt solid #d9dee6; border-left: 3pt solid <?= $color ?>; padding: 8pt 10pt; margin: 0 0 3pt; color: #111827; }
.prompt-note { font-size: 7.2pt; color: #6b7280; margin: 0 0 8pt; }
.follow li { font-size: 8.6pt; }
.follow li span { font-family: "DejaVu Sans Mono", monospace; font-size: 7.9pt; }
.example { border: 0.8pt solid <?= $line ?>; border-radius: 4pt; padding: 0; margin: 8pt 0; }
.example__h { background: <?= $soft ?>; padding: 5pt 9pt; font-weight: bold; color: <?= $dark ?>; font-size: 9pt; border-radius: 4pt 4pt 0 0; }
.example__ctx { padding: 6pt 9pt 0; font-size: 8.3pt; color: #4b5563; font-style: italic; }
.example__body { padding: 4pt 9pt 6pt; font-size: 8.7pt; }
.example__body h4 { margin-top: 6pt; }
.example__body table td, .example__body table th { font-size: 8pt; padding: 3.5pt 5pt; }
.checklist { list-style: none; padding-left: 0; }
.checklist li { padding-left: 15pt; position: relative; font-size: 8.7pt; }
.checklist li span.box { position: absolute; left: 0; top: 0; color: <?= $color ?>; }

/* Flujos */
.flow { margin: 0 0 14pt; page-break-inside: avoid; }
.flow__t { font-size: 12pt; color: <?= $dark ?>; margin: 0 0 3pt; }
.flow__goal { font-size: 8.8pt; color: #4b5563; margin: 0 0 6pt; }
.flow td.n { width: 22pt; }
.flow td.n span { display: block; width: 16pt; height: 16pt; padding-top: 3.2pt; line-height: 1; border-radius: 8pt; background: <?= $color ?>; color: #fff; text-align: center; font-weight: bold; font-size: 8pt; }
.flow td.r { width: 82pt; text-align: right; }
.chip { font-size: 7.6pt; background: <?= $soft ?>; color: <?= $dark ?>; padding: 2pt 5pt; border-radius: 3pt; font-weight: bold; }
.flow .stepnote { font-size: 8pt; color: #5b6472; display: block; margin-top: 2pt; }

/* Rúbricas */
.rubric { margin: 0 0 14pt; }
.rubric h3 { margin-top: 4pt; }
.rubric th { font-size: 7.6pt; }
.rubric td { font-size: 7.6pt; line-height: 1.38; padding: 4.5pt 5pt; }
.rubric td.c { width: 19%; font-weight: bold; background: <?= $soft ?>; color: <?= $dark ?>; }

/* Errores */
.err { margin: 0 0 10pt; page-break-inside: avoid; border: 0.7pt solid <?= $line ?>; border-radius: 4pt; }
.err__t { background: <?= $soft ?>; padding: 6pt 9pt; font-weight: bold; color: #111827; border-radius: 4pt 4pt 0 0; }
.err__t span { color: <?= $color ?>; margin-right: 4pt; }
.err table { margin: 0; }
.err td { width: 50%; border: 0; font-size: 8.5pt; padding: 6pt 9pt; }
.err td + td { border-left: 0.7pt solid <?= $line ?>; }
.err .lbl { display: block; font-size: 7.2pt; text-transform: uppercase; letter-spacing: .6pt; font-weight: bold; color: <?= $color ?>; margin-bottom: 2pt; }

/* Contextos y glosario */
.ctx td.n { width: 22pt; color: <?= $color ?>; font-weight: bold; }
.gl dt { font-weight: bold; color: <?= $dark ?>; margin: 7pt 0 1pt; page-break-after: avoid; }
.gl dd { margin: 0 0 0 0; font-size: 8.8pt; }
.dua-p { margin: 0 0 10pt; page-break-inside: avoid; }
.end { margin-top: 18pt; padding: 10pt 12pt; background: <?= $soft ?>; border-radius: 4pt; font-size: 9pt; }
</style>
</head>
<body>

<div class="cover">
  <div class="cover__c1"></div><div class="cover__c2"></div><div class="cover__c3"></div>
  <div class="cover__in">
    <p class="cover__brand"><?= e($L['brand']) ?></p>
    <p class="cover__kicker"><?= e($L['title']) ?></p>
    <p class="cover__subject"><?= e($kit['name']) ?></p>
    <p class="cover__tag"><?= e($kit['tagline']) ?></p>
    <table class="stats"><tr>
      <td><b><?= count($kit['recetas']) ?></b><?= e($L['recipes']) ?></td>
      <td><b><?= count($kit['cadenas']) ?></b><?= e($L['flows']) ?></td>
      <td><b><?= count($kit['rubricas']) ?></b><?= e($L['rubrics']) ?></td>
      <td><b><?= count($kit['errores']) ?></b><?= e($L['errors']) ?></td>
    </tr></table>
    <p class="cover__aligned"><?= e($L['aligned']) ?></p>
  </div>
  <div class="cover__foot">
    <p class="cover__author"><?= e($L['author']) ?></p>
    <p><?= e($edition) ?> · <?= e($L['license']) ?></p>
  </div>
</div>

<h1 class="toc-title" id="s-toc"><?= e($L['contents']) ?></h1>
<table class="toc">
<?php foreach ($chapters as $i => [$id, $title]): ?>
  <tr><td class="n"><?= $i + 1 ?></td><td><a href="#<?= e($id) ?>"><?= e($title) ?></a></td><td class="p"><?= e($pg($id)) ?></td></tr>
<?php endforeach; ?>
</table>

<h2 class="toc-title" style="font-size:14pt;margin-top:14pt"><?= e($L['recipe_index']) ?></h2>
<table class="toc-sub">
<?php foreach ($groups as $cat => $recipes): ?>
  <tr class="cat"><td colspan="4"><?= e($categories[$cat]) ?></td></tr>
  <?php foreach ($recipes as $r): ?>
  <tr><td class="code"><a href="#r-<?= e($r['id']) ?>" style="color:inherit;text-decoration:none"><?= e($r['id']) ?></a></td><td><?= e($r['titulo']) ?></td><td class="g"><?= e($r['grados']) ?></td><td class="p"><?= e($pg('r-' . $r['id'])) ?></td></tr>
  <?php endforeach; ?>
<?php endforeach; ?>
</table>

<?= $head('s-intro') ?>
<div class="lead"><?= $kit['intro_html'] ?></div>

<?= $head('s-uso') ?>
<?= $common['como_usar_html'] ?>

<?= $head('s-anatomia') ?>
<?= $common['anatomia_html'] ?>
<h3><?= e($L['master']) ?></h3>
<div class="prompt"><?= $prompt((string) $common['plantilla_maestra']) ?></div>
<p class="prompt-note"><?= e($L['prompt_note']) ?></p>
<h3><?= e($L['verify']) ?></h3>
<ul class="checklist">
<?php foreach ($common['verificacion'] as $item): ?>
  <li><span class="box"><?= $box ?></span><?= e($item) ?></li>
<?php endforeach; ?>
</ul>

<?= $head('s-referentes') ?>
<?= $kit['referentes_html'] ?>

<?= $head('s-mapa') ?>
<table class="band">
  <thead><tr><th><?= e($L['grades']) ?></th><th><?= e($L['focus']) ?></th><th><?= e($L['keys']) ?></th></tr></thead>
  <tbody>
  <?php foreach ($kit['mapa'] as $band): ?>
  <tr><td class="g"><?= e($band['grados']) ?></td><td style="width:33%"><?= e($band['enfoque']) ?></td><td><ul><?php foreach ($band['claves'] ?? [] as $k): ?><li><?= e($k) ?></li><?php endforeach; ?></ul></td></tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?= $head('s-recetas') ?>
<p class="lead"><?= e($L['recipes_intro']) ?></p>
<table class="toc-sub">
<?php foreach ($groups as $cat => $recipes): ?>
  <tr class="cat"><td colspan="3"><?= e($categories[$cat]) ?></td><td class="p" style="background:<?= $soft ?>"><?= e($pg('s-cat-' . $cat)) ?></td></tr>
<?php endforeach; ?>
</table>

<?php foreach ($groups as $cat => $recipes): ?>
<div class="cat-div" id="s-cat-<?= e($cat) ?>">
  <p class="cat-div__k"><?= e($L['recipe'] . 's · ' . $kit['name']) ?></p>
  <h2 class="cat-div__t"><?= e($categories[$cat]) ?></h2>
  <table>
    <thead><tr><th><?= e($L['code']) ?></th><th><?= e($L['recipe']) ?></th><th><?= e($L['grades']) ?></th><th><?= e($L['saved']) ?></th><th style="text-align:right"><?= e($L['page']) ?></th></tr></thead>
    <tbody>
    <?php foreach ($recipes as $r): ?>
    <tr><td class="code"><?= e($r['id']) ?></td><td><?= e($r['titulo']) ?></td><td><?= e($r['grados']) ?></td><td><?= e($r['tiempo_ahorrado']) ?></td><td class="p"><?= e($pg('r-' . $r['id'])) ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
  <?php foreach ($recipes as $r): ?>
<div class="recipe" id="r-<?= e($r['id']) ?>">
  <table class="rhead"><tr>
    <td class="rid"><span><?= e($r['id']) ?></span></td>
    <td class="rtitle"><div class="rtitle__cat"><?= e($categories[$cat]) ?></div><div class="rtitle__t"><?= e($r['titulo']) ?></div></td>
  </tr></table>
  <table class="rmeta"><tr>
    <td><b><?= e($L['grades']) ?>:</b> <?= e($r['grados']) ?></td>
    <td><b><?= e($L['saved']) ?>:</b> <?= e($r['tiempo_ahorrado']) ?></td>
  </tr></table>
  <p><strong><?= e($L['when']) ?></strong> <?= e($r['cuando']) ?></p>

  <?php if (!empty($r['variables'])): ?>
  <h4><?= e($L['variables']) ?></h4>
  <table class="vars">
    <tbody>
    <?php foreach ($r['variables'] as $var => $help): ?>
    <tr><td class="v"><?= e((string) $var) ?></td><td><?= e((string) $help) ?></td></tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>

  <h4><?= e($L['prompt']) ?></h4>
  <div class="prompt"><?= $prompt((string) $r['prompt']) ?></div>
  <p class="prompt-note"><?= e($L['prompt_note']) ?></p>

  <?php if (!empty($r['seguimientos'])): ?>
  <h4><?= e($L['followups']) ?></h4>
  <ol class="follow">
    <?php foreach ($r['seguimientos'] as $s): ?><li><span><?= e(trim((string) $s)) ?></span></li><?php endforeach; ?>
  </ol>
  <?php endif; ?>

  <?php if (!empty($r['ejemplo']['resultado_html'])): ?>
  <div class="example">
    <div class="example__h"><?= e($L['example']) ?></div>
    <?php if (!empty($r['ejemplo']['contexto'])): ?><p class="example__ctx"><?= e($L['context']) ?> <?= e($r['ejemplo']['contexto']) ?></p><?php endif; ?>
    <div class="example__body"><?= $r['ejemplo']['resultado_html'] ?></div>
  </div>
  <?php endif; ?>

  <?php if (!empty($r['revisar'])): ?>
  <h4><?= e($L['check']) ?></h4>
  <ul class="checklist">
    <?php foreach ($r['revisar'] as $item): ?><li><span class="box"><?= $box ?></span><?= e($item) ?></li><?php endforeach; ?>
  </ul>
  <?php endif; ?>
</div>
  <?php endforeach; ?>
<?php endforeach; ?>

<?= $head('s-cadenas') ?>
<p class="lead"><?= e($L['flows_intro']) ?></p>
<?php foreach ($kit['cadenas'] as $c): ?>
<div class="flow">
  <h3 class="flow__t"><?= e($c['titulo']) ?></h3>
  <p class="flow__goal"><strong><?= e($L['goal']) ?></strong> <?= e($c['objetivo']) ?></p>
  <table>
    <tbody>
    <?php foreach ($c['pasos'] as $i => $paso): $ref = (string) ($paso['receta'] ?? ''); ?>
    <tr>
      <td class="n"><span><?= $i + 1 ?></span></td>
      <td><?= e($paso['paso']) ?><?php if (!empty($paso['nota'])): ?><span class="stepnote"><?= e($paso['nota']) ?></span><?php endif; ?></td>
      <td class="r"><?php if ($ref !== '' && isset($byId[$ref])): ?><span class="chip"><?= e($ref) ?> · <?= e($L['page']) ?> <?= e($pg('r-' . $ref)) ?></span><?php endif; ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endforeach; ?>

<?= $head('s-rubricas') ?>
<p class="lead"><?= e($L['rubrics_intro']) ?></p>
<?php foreach ($kit['rubricas'] as $rub): ?>
<div class="rubric">
  <h3><?= e($rub['titulo']) ?></h3>
  <table>
    <thead><tr><th><?= e($L['criterion']) ?></th><?php foreach (['Superior', 'Alto', 'Básico', 'Bajo'] as $lvl): ?><th><?= e($lvl) ?></th><?php endforeach; ?></tr></thead>
    <tbody>
    <?php foreach ($rub['criterios'] as $cr): ?>
    <tr>
      <td class="c"><?= e($cr['criterio']) ?></td>
      <?php foreach (['Superior', 'Alto', 'Básico', 'Bajo'] as $lvl): ?><td><?= e((string) ($cr['niveles'][$lvl] ?? '')) ?></td><?php endforeach; ?>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
<?php endforeach; ?>

<?= $head('s-errores') ?>
<p class="lead"><?= e($L['errors_intro']) ?></p>
<?php foreach ($kit['errores'] as $i => $er): ?>
<div class="err">
  <div class="err__t"><span><?= $i + 1 ?>.</span><?= e($er['error']) ?></div>
  <table><tr>
    <td><span class="lbl"><?= e($L['detect']) ?></span><?= e($er['como_detectarlo']) ?></td>
    <td><span class="lbl"><?= e($L['fix']) ?></span><?= e($er['como_corregirlo']) ?></td>
  </tr></table>
</div>
<?php endforeach; ?>

<?= $head('s-contextos') ?>
<p class="lead"><?= e($L['contexts_intro']) ?></p>
<table class="ctx">
  <tbody>
  <?php foreach ($kit['banco_contextos'] as $i => $ctx): ?>
  <tr><td class="n"><?= $i + 1 ?></td><td><?= e($ctx) ?></td></tr>
  <?php endforeach; ?>
  </tbody>
</table>

<?= $head('s-dua') ?>
<?= $common['dua_html'] ?>
<h3><?= e($L['dua_prompts']) ?></h3>
<?php foreach ($dua as $i => $p): ?>
<div class="dua-p">
  <h4><?= e('DUA-' . str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) . ' · ' . $p['titulo']) ?></h4>
  <div class="prompt"><?= $prompt($p['prompt']) ?></div>
</div>
<?php endforeach; ?>

<?= $head('s-privacidad') ?>
<?= $common['privacidad_html'] ?>

<?= $head('s-politica') ?>
<?= $common['politica_aula_html'] ?>

<?= $head('s-herramientas') ?>
<?= $common['herramientas_html'] ?>

<?= $head('s-glosario') ?>
<dl class="gl">
<?php foreach ($common['glosario'] as $term => $def): ?>
  <dt><?= e((string) $term) ?></dt><dd><?= e((string) $def) ?></dd>
<?php endforeach; ?>
</dl>
<div class="end"><?= e($L['end']) ?></div>

</body>
</html>
