// Número a letras (español con "pesos M/CTE" / inglés "dollars"), en el navegador.
import { spanish, english } from './numwords.js';

const root = document.querySelector('[data-words-tool]');
if (root) {
  const input = root.querySelector('[data-words-input]');
  const currency = root.querySelector('[data-words-currency]');
  const output = root.querySelector('[data-words-output]');
  const copy = root.querySelector('[data-words-copy]');
  const isEs = root.dataset.locale !== 'en';
  const copyLabel = copy.textContent;

  // En español, "1.500" se interpreta como mil quinientos (separador de miles), no como 1,5.
  const normalize = (raw) => {
    let v = raw.trim().replace(/\s+/g, '').replace(/^\$/, '');
    if (isEs && /^-?\d{1,3}(\.\d{3})+$/.test(v)) v = v.replace(/\./g, '');
    return v;
  };

  const render = () => {
    copy.textContent = copyLabel;
    const value = normalize(input.value);
    if (value === '') { output.textContent = ''; return; }
    try {
      output.textContent = (isEs ? spanish : english)(value, { currency: currency.checked });
      output.removeAttribute('data-state');
    } catch {
      output.textContent = root.dataset.error;
      output.dataset.state = 'error';
    }
  };

  copy.addEventListener('click', async () => {
    if (!output.textContent || output.dataset.state === 'error') return;
    try {
      await navigator.clipboard.writeText(output.textContent);
      copy.textContent = root.dataset.copied;
    } catch { /* sin permiso de portapapeles */ }
  });
  root.querySelector('[data-words-form]').addEventListener('submit', (e) => e.preventDefault());
  input.addEventListener('input', render);
  currency.addEventListener('change', render);
  render();
}
