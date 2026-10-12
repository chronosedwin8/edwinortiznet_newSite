<?php
/**
 * Encuesta corta dentro de un artículo ({{encuesta:clave}}). Funciona sin JavaScript (formulario que vuelve al artículo);
 * poll.js la mejora: envía por fetch, muestra los resultados al responder y recuerda "tus respuestas".
 *
 * @var string $key @var array{title:string, intro?:string, questions: array<int, array{q:string, options:string[]}>} $poll @var string $locale
 */

use App\Core\Csrf;

$n = count($poll['questions']);
?>
<section class="poll" id="encuesta" aria-labelledby="poll-title" data-poll data-poll-api="/api/encuestas/<?= e($key) ?>" data-csrf="<?= Csrf::PLACEHOLDER ?>" data-locale="<?= e($locale) ?>"
         data-label-sent="<?= e(t('poll.sent')) ?>" data-label-error="<?= e(t('poll.error')) ?>" data-label-people="<?= e(t('poll.people')) ?>" data-label-people-one="<?= e(t('poll.people_one')) ?>"
         data-label-mine="<?= e(t('poll.mine')) ?>" data-label-pick="<?= e(t('poll.pick')) ?>">
  <h3 id="poll-title" class="poll__title"><?= e($poll['title']) ?></h3>
  <?php if (!empty($poll['intro'])): ?><p class="poll__intro"><?= e($poll['intro']) ?></p><?php endif; ?>
  <form class="poll__form" method="post" action="/api/encuestas/<?= e($key) ?>" data-poll-form>
    <input type="hidden" name="_csrf" value="<?= Csrf::PLACEHOLDER ?>">
    <input type="hidden" name="locale" value="<?= e($locale) ?>">
    <?php foreach ($poll['questions'] as $i => $question): ?>
    <fieldset class="poll__q" data-poll-q="<?= $i ?>">
      <legend><span class="poll__num"><?= $i + 1 ?>/<?= $n ?></span> <?= e($question['q']) ?></legend>
      <div class="poll__opts">
        <?php foreach ($question['options'] as $j => $option): ?>
        <label class="poll__opt" data-poll-opt="<?= $j ?>">
          <input type="radio" name="a[<?= $i ?>]" value="<?= $j ?>">
          <span class="poll__label"><?= e($option) ?></span>
          <span class="poll__bar" aria-hidden="true"></span>
          <span class="poll__pct" data-poll-pct></span>
        </label>
        <?php endforeach; ?>
      </div>
    </fieldset>
    <?php endforeach; ?>
    <div class="poll__actions">
      <button type="submit" class="btn btn--primary" data-poll-submit><?= e(t('poll.submit')) ?></button>
      <button type="button" class="btn btn--ghost" data-poll-show hidden><?= e(t('poll.show')) ?></button>
      <p class="poll__status" role="status" aria-live="polite" data-poll-status></p>
    </div>
  </form>
  <p class="poll__note"><?= e(t('poll.note')) ?></p>
</section>
