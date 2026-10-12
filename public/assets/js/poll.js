// Encuestas cortas de los artículos: envía las respuestas, muestra los resultados y recuerda "tu respuesta".
// Sin JavaScript el formulario sigue funcionando (vuelve al artículo); la página puede venir de la caché,
// así que los resultados siempre se piden a la API.
const root = document.querySelector('[data-poll]');
if (root) initPoll(root);

function initPoll(root) {
  const api = root.dataset.pollApi;
  const csrf = root.dataset.csrf;
  const form = root.querySelector('[data-poll-form]');
  const submit = root.querySelector('[data-poll-submit]');
  const show = root.querySelector('[data-poll-show]');
  const status = root.querySelector('[data-poll-status]');
  const nf = new Intl.NumberFormat(document.documentElement.lang || 'es');
  if (!api || !form) return;

  const say = (text) => { if (status) status.textContent = text; };
  const people = (n) => (n === 1 ? root.dataset.labelPeopleOne : root.dataset.labelPeople.replace(':n', nf.format(n)));

  function paint(data, { markMine = true } = {}) {
    root.classList.add('poll--results');
    const mine = data.mine || {};
    root.querySelectorAll('[data-poll-q]').forEach((fs) => {
      const q = Number(fs.dataset.pollQ);
      const res = data.questions?.[q];
      if (!res) return;
      const max = Math.max(1, ...res.counts);
      fs.querySelectorAll('[data-poll-opt]').forEach((label) => {
        const j = Number(label.dataset.pollOpt);
        const count = res.counts[j] || 0;
        const pct = res.total ? Math.round((count / res.total) * 100) : 0;
        label.querySelector('.poll__bar').style.setProperty('--w', `${(count / max) * 100}%`);
        label.querySelector('[data-poll-pct]').textContent = `${pct} %`;
        label.classList.toggle('is-mine', markMine && mine[q] === j);
        const input = label.querySelector('input');
        input.checked = markMine && mine[q] === j;
      });
      let total = fs.querySelector('.poll__total');
      if (!total) {
        total = document.createElement('p');
        total.className = 'poll__total';
        fs.appendChild(total);
      }
      total.textContent = people(res.total);
    });
  }

  async function load() {
    try {
      const res = await fetch(api, { headers: { Accept: 'application/json' }, credentials: 'same-origin' });
      if (!res.ok) return null;
      return await res.json();
    } catch { return null; }
  }

  // Al cargar: si ya respondió, se muestran los resultados con sus respuestas; si no, hay un botón para verlos.
  load().then((data) => {
    if (!data) return;
    if (Object.keys(data.mine || {}).length) paint(data);
    else if (show) {
      show.hidden = false;
      show.addEventListener('click', () => { paint(data, { markMine: false }); show.hidden = true; });
    }
  });

  form.addEventListener('submit', async (ev) => {
    ev.preventDefault();
    const answers = {};
    root.querySelectorAll('[data-poll-q]').forEach((fs) => {
      const picked = fs.querySelector('input:checked');
      if (picked) answers[fs.dataset.pollQ] = Number(picked.value);
    });
    if (!Object.keys(answers).length) { say(root.dataset.labelPick); return; }
    submit.disabled = true;
    try {
      const res = await fetch(api, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', Accept: 'application/json', 'X-CSRF-Token': csrf },
        body: JSON.stringify({ answers, locale: root.dataset.locale }),
      });
      if (!res.ok) throw new Error(String(res.status));
      const data = await res.json();
      paint(data);
      say(root.dataset.labelSent);
      if (show) show.hidden = true;
      window.gtag?.('event', 'poll_submit', { content_type: 'article', answered: Object.keys(answers).length });
    } catch {
      say(root.dataset.labelError);
    } finally {
      submit.disabled = false;
    }
  });
}
