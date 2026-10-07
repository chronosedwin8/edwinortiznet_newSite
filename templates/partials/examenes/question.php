<?php
/**
 * Una pregunta en pantalla (vista previa y editor). @var array $q pregunta armada (ExamContent::build) @var bool|null $points
 * @var bool|null $showKey marca la respuesta correcta
 */

use App\Services\Examenes\ExamContent;
use App\Services\Examenes\ExamView as V;

$T = static fn (string $s): string => V::text($s, 'screen');
$type = $q['type'];
$showKey = !empty($showKey);
?>
<div class="ex-q" id="q-<?= e($q['slot']) ?>">
  <span class="ex-q__n"><?= (int) $q['n'] ?>.</span>
  <div class="ex-q__body">
    <div class="ex-q__stem"><?= $T($q['stem']) ?><?php if (!empty($points)): ?> <span class="ex-q__pts"><?= e(V::pointsLabel($q['points'])) ?></span><?php endif; ?></div>
    <?php if ($type === 'unica' || $type === 'multiple'): ?>
    <ol class="ex-opts<?= V::shortOptions($q['shown']) ? ' ex-opts--two' : '' ?>">
      <?php foreach ($q['shown'] as $i => $opt): $ok = $showKey && in_array($i, $q['key'], true); ?>
      <li class="ex-opt<?= $ok ? ' is-correct' : '' ?>"><span class="ex-opt__l"><?= e(ExamContent::letter($i)) ?>)</span><span><?= $T($opt) ?></span><?php if ($ok): ?><span class="ex-sr"><?= e(t('examenes.exam.correct_sr')) ?></span><?php endif; ?></li>
      <?php endforeach; ?>
    </ol>
    <?php elseif ($type === 'vf'): ?>
    <p class="ex-tf"><span class="ex-bubble<?= $showKey && $q['tf'] ? ' is-correct' : '' ?>"><?= e(t('examenes.pdf.v')) ?></span> <?= e(t('examenes.pdf.true')) ?> <span class="ex-bubble<?= $showKey && !$q['tf'] ? ' is-correct' : '' ?>"><?= e(t('examenes.pdf.f')) ?></span> <?= e(t('examenes.pdf.false')) ?></p>
    <?php elseif ($type === 'corta'): ?>
    <p class="ex-line"><?= e(t('examenes.pdf.answer')) ?> <?php if ($showKey): ?><strong class="ex-key-inline"><?= $T($q['answer']) ?></strong><?php else: ?><span class="ex-fill"></span><?php endif; ?></p>
    <?php elseif ($type === 'completar' && $showKey): ?>
    <p class="ex-key-inline"><?= $T(implode('; ', array_map(fn ($a, $i) => '(' . ($i + 1) . ') ' . $a, $q['blanks'], array_keys($q['blanks'])))) ?></p>
    <?php elseif ($type === 'relacionar'): ?>
    <div class="ex-match">
      <div><p class="ex-match__h"><?= e(t('examenes.pdf.col_a')) ?></p><ol class="ex-match__list"><?php foreach ($q['left'] as $i => $left): ?><li><span class="ex-box"><?= $showKey ? e($q['key'][$i]) : '' ?></span><?= $T($left) ?></li><?php endforeach; ?></ol></div>
      <div><p class="ex-match__h"><?= e(t('examenes.pdf.col_b')) ?></p><ul class="ex-match__list ex-match__list--b"><?php foreach ($q['right'] as $i => $right): ?><li><strong><?= e(ExamContent::letter($i)) ?>.</strong> <?= $T($right) ?></li><?php endforeach; ?></ul></div>
    </div>
    <?php elseif ($type === 'ordenar'): ?>
    <ul class="ex-order"><?php foreach ($q['shown'] as $i => $item): ?><li><span class="ex-box"></span><strong><?= e(ExamContent::letter($i, true)) ?>)</strong> <?= $T($item) ?></li><?php endforeach; ?></ul>
    <?php if ($showKey): ?><p class="ex-key-inline"><?= e(implode(' → ', $q['key'])) ?></p><?php endif; ?>
    <?php elseif ($type === 'problema'): ?>
    <div class="ex-work"><span><?= e(t('examenes.pdf.work')) ?></span></div>
    <?php elseif ($type === 'abierta' || $type === 'larga'): ?>
    <div class="ex-lines ex-lines--<?= e($type) ?>" aria-hidden="true"><i></i><i></i><i></i><?php if ($type === 'larga'): ?><i></i><i></i><i></i><?php endif; ?></div>
    <?php elseif ($type === 'crucigrama'): $p = $q['puzzle']; ?>
    <div class="ex-cw-wrap">
      <table class="ex-cw" style="--cols: <?= (int) $p['width'] ?>" aria-label="<?= e(t('examenes.type.crucigrama')) ?>">
        <?php foreach ($p['cells'] as $y => $row): ?>
        <tr><?php foreach ($row as $x => $ch): ?><td class="<?= $ch === null ? 'off' : 'on' ?>"><?php if ($ch !== null): ?><?php if (isset($p['numbers']["$x,$y"])): ?><span class="ex-cw__n"><?= (int) $p['numbers']["$x,$y"] ?></span><?php endif; ?><?php if ($showKey): ?><span class="ex-cw__l"><?= e($ch) ?></span><?php endif; ?><?php endif; ?></td><?php endforeach; ?></tr>
        <?php endforeach; ?>
      </table>
    </div>
    <div class="ex-clues">
      <div><p class="ex-match__h"><?= e(t('examenes.pdf.across')) ?></p><ul><?php foreach ($p['across'] as $en): ?><li><strong><?= (int) $en['n'] ?>.</strong> <?= $T($en['clue']) ?> <span class="ex-q__pts">(<?= (int) $en['len'] ?>)</span></li><?php endforeach; ?></ul></div>
      <div><p class="ex-match__h"><?= e(t('examenes.pdf.down')) ?></p><ul><?php foreach ($p['down'] as $en): ?><li><strong><?= (int) $en['n'] ?>.</strong> <?= $T($en['clue']) ?> <span class="ex-q__pts">(<?= (int) $en['len'] ?>)</span></li><?php endforeach; ?></ul></div>
    </div>
    <?php elseif ($type === 'sopa'): $p = $q['puzzle'];
        $hit = [];
        if ($showKey) {
            foreach ($p['placed'] as $pl) {
                $len = count(\App\Services\Examenes\Puzzles::letters($pl['word']));
                for ($i = 0; $i < $len; $i++) {
                    $hit[($pl['x'] + $pl['dx'] * $i) . ',' . ($pl['y'] + $pl['dy'] * $i)] = true;
                }
            }
        } ?>
    <div class="ex-cw-wrap">
      <table class="ex-ws" aria-label="<?= e(t('examenes.type.sopa')) ?>">
        <?php foreach ($p['grid'] as $y => $row): ?><tr><?php foreach ($row as $x => $ch): ?><td<?= isset($hit["$x,$y"]) ? ' class="hit"' : '' ?>><?= e($ch) ?></td><?php endforeach; ?></tr><?php endforeach; ?>
      </table>
    </div>
    <p class="ex-wordlist"><?= e(implode(' · ', $p['words'])) ?></p>
    <?php endif; ?>
  </div>
</div>
