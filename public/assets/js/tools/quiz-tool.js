// Simulacro del Concurso Docente: 10 preguntas al azar del banco, retroalimentación y puntaje.
const root = document.querySelector('[data-quiz]');
const dataEl = document.getElementById('quiz-data');
if (root && dataEl) {
  const bank = JSON.parse(dataEl.textContent || '[]');
  const L = root.dataset;
  const $ = (s) => root.querySelector(s);
  const stage = $('[data-quiz-stage]');
  const start = $('[data-quiz-start]');
  const end = $('[data-quiz-end]');
  const progress = $('[data-quiz-progress]');
  const text = $('[data-quiz-text]');
  const options = $('[data-quiz-options]');
  const feedback = $('[data-quiz-feedback]');
  const action = $('[data-quiz-action]');
  let questions = [];
  let index = 0;
  let score = 0;
  let checked = false;

  const shuffle = (arr) => {
    const a = arr.slice();
    for (let i = a.length - 1; i > 0; i--) {
      const j = crypto.getRandomValues(new Uint32Array(1))[0] % (i + 1);
      [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
  };

  const show = () => {
    const q = questions[index];
    checked = false;
    progress.textContent = L.labelQuestion.replace(':i', String(index + 1)).replace(':n', String(questions.length));
    text.textContent = (q.demo ? L.labelDemo + ' · ' : '') + q.q;
    options.replaceChildren();
    q.o.forEach((opt, i) => {
      const label = document.createElement('label');
      label.className = 'quiz__option';
      const input = Object.assign(document.createElement('input'), { type: 'radio', name: 'quiz-option', value: String(i) });
      label.append(input, document.createTextNode(opt));
      options.append(label);
    });
    feedback.hidden = true;
    action.textContent = L.labelCheck;
    action.disabled = true;
    options.querySelector('input')?.focus();
  };

  options.addEventListener('change', () => { if (!checked) action.disabled = false; });

  action.addEventListener('click', () => {
    const q = questions[index];
    if (!checked) {
      const picked = options.querySelector('input:checked');
      if (!picked) return;
      checked = true;
      const ok = Number(picked.value) === q.c;
      if (ok) score++;
      options.querySelectorAll('.quiz__option').forEach((label, i) => {
        label.querySelector('input').disabled = true;
        if (i === q.c) label.classList.add('is-correct');
        else if (label.contains(picked)) label.classList.add('is-wrong');
      });
      feedback.textContent = (ok ? L.labelCorrect : L.labelWrong) + (q.e ? ' ' + q.e : '');
      feedback.hidden = false;
      action.textContent = index < questions.length - 1 ? L.labelNext : L.labelFinish;
      return;
    }
    if (index < questions.length - 1) { index++; show(); return; }
    stage.hidden = true;
    end.hidden = false;
    $('[data-quiz-score]').textContent = L.labelScore.replace(':s', String(score)).replace(':n', String(questions.length));
    $('[data-quiz-score-input]').value = String(score);
    $('[data-quiz-total-input]').value = String(questions.length);
    end.querySelector('input[type="email"]')?.focus();
  });

  const begin = () => {
    questions = shuffle(bank).slice(0, 10).map((q) => {
      // Se barajan también las opciones, conservando cuál es la correcta.
      const order = shuffle(q.o.map((_, i) => i));
      return { ...q, o: order.map((i) => q.o[i]), c: order.indexOf(q.c) };
    });
    index = 0;
    score = 0;
    start.hidden = true;
    end.hidden = true;
    stage.hidden = false;
    show();
  };
  $('[data-quiz-begin]')?.addEventListener('click', begin);
  $('[data-quiz-restart]')?.addEventListener('click', begin);
}
