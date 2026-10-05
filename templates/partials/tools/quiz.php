<?php /** @var array $questions @var bool $sent */ ?>
<script type="application/json" id="quiz-data"><?= json_encode($questions, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) ?></script>
<div class="quiz" data-quiz
     data-label-question="<?= e(t('quiz.question_n')) ?>" data-label-check="<?= e(t('quiz.check')) ?>"
     data-label-next="<?= e(t('quiz.next')) ?>" data-label-finish="<?= e(t('quiz.finish')) ?>"
     data-label-correct="<?= e(t('quiz.correct')) ?>" data-label-wrong="<?= e(t('quiz.wrong')) ?>"
     data-label-score="<?= e(t('quiz.score')) ?>" data-label-demo="<?= e(t('quiz.demo_badge')) ?>">
  <?php if ($sent): ?><p class="notice notice--ok" role="status"><?= e(t('quiz.sent')) ?></p><?php endif; ?>
  <div class="quiz__start" data-quiz-start>
    <p><?= e(t('quiz.intro', ['n' => min(10, count($questions))])) ?></p>
    <?php if (count($questions) < 10): ?><p class="notice"><?= e(t('quiz.bank_small', ['n' => count($questions)])) ?></p><?php endif; ?>
    <button type="button" class="btn btn--primary btn--lg" data-quiz-begin<?= $questions ? '' : ' disabled' ?>><?= e(t('quiz.start')) ?></button>
  </div>
  <div class="quiz__stage" data-quiz-stage hidden>
    <p class="quiz__progress" data-quiz-progress></p>
    <fieldset class="quiz__question">
      <legend data-quiz-text></legend>
      <div class="quiz__options" data-quiz-options></div>
    </fieldset>
    <div class="quiz__feedback" data-quiz-feedback role="status" aria-live="polite" hidden></div>
    <button type="button" class="btn btn--primary" data-quiz-action></button>
  </div>
  <div class="quiz__end" data-quiz-end hidden>
    <p class="quiz__score" data-quiz-score></p>
    <form class="quiz__mail" action="<?= e(route('quiz.result')) ?>" method="post" data-async-form data-quiz-mail>
      <?= csrf_field() ?>
      <?= antispam_fields() ?>
      <input type="hidden" name="score" value="0" data-quiz-score-input>
      <input type="hidden" name="total" value="10" data-quiz-total-input>
      <label for="quiz-email"><?= e(t('quiz.mail_label')) ?></label>
      <div class="subscribe-form__row">
        <input id="quiz-email" type="email" name="email" required autocomplete="email" placeholder="<?= e(t('subscribe.placeholder')) ?>">
        <button class="btn btn--primary" type="submit"><?= e(t('quiz.mail_button')) ?></button>
      </div>
      <p class="form-note"><?= e(t('quiz.mail_note')) ?></p>
      <p class="form-status" data-form-status role="status" aria-live="polite"></p>
    </form>
    <button type="button" class="btn btn--ghost" data-quiz-restart><?= e(t('quiz.restart')) ?></button>
  </div>
</div>
