// Generador de código QR: todo ocurre en el navegador (sin enviar datos al servidor).
import { encodeQR, toSVG, drawToCanvas } from './qrcode.js';

const root = document.querySelector('[data-qr-tool]');
if (root) {
  const $ = (s) => root.querySelector(s);
  const text = $('[data-qr-text]');
  const size = $('[data-qr-size]');
  const ecc = $('[data-qr-ecc]');
  const dark = $('[data-qr-dark]');
  const light = $('[data-qr-light]');
  const preview = $('[data-qr-preview]');
  const status = $('[data-qr-status]');
  const buttons = [$('[data-qr-png]'), $('[data-qr-svg]')];
  let current = null;

  const render = () => {
    const value = text.value;
    if (!value.trim()) {
      current = null;
      preview.replaceChildren();
      status.textContent = root.dataset.errorEmpty;
      buttons.forEach((b) => { b.disabled = true; });
      return;
    }
    try {
      current = encodeQR(value, { ecc: ecc.value });
      preview.innerHTML = toSVG(current, { dark: dark.value, light: light.value });
      status.textContent = root.dataset.versionLabel.replace(':v', String(current.version)).replaceAll(':n', String(current.size));
      buttons.forEach((b) => { b.disabled = false; });
    } catch {
      current = null;
      preview.replaceChildren();
      status.textContent = root.dataset.errorLong;
      buttons.forEach((b) => { b.disabled = true; });
    }
  };

  const download = (blob, name) => {
    const url = URL.createObjectURL(blob);
    const a = Object.assign(document.createElement('a'), { href: url, download: name });
    document.body.append(a);
    a.click();
    a.remove();
    setTimeout(() => URL.revokeObjectURL(url), 1000);
  };

  $('[data-qr-png]').addEventListener('click', () => {
    if (!current) return;
    const px = Number(size.value) || 512;
    const margin = 4;
    const scale = Math.max(1, Math.floor(px / (current.size + margin * 2)));
    const canvas = document.createElement('canvas');
    drawToCanvas(current, canvas, { scale, margin, dark: dark.value, light: light.value });
    canvas.toBlob((blob) => blob && download(blob, 'qr-code.png'), 'image/png');
  });
  $('[data-qr-svg]').addEventListener('click', () => {
    if (!current) return;
    const svg = toSVG(current, { dark: dark.value, light: light.value, size: Number(size.value) || 512 });
    download(new Blob([svg], { type: 'image/svg+xml' }), 'qr-code.svg');
  });

  let timer = 0;
  root.addEventListener('input', () => { clearTimeout(timer); timer = setTimeout(render, 120); });
  root.addEventListener('change', render);
  root.querySelector('[data-qr-form]').addEventListener('submit', (e) => e.preventDefault());
  render();
}
