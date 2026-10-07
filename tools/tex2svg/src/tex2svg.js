/*
 * tex2svg: convierte un lote de fórmulas TeX a SVG autocontenido con MathJax 3 (sin red, sin DOM del navegador).
 * Entrada (stdin, JSON): {"items":[{"tex":"x^2","display":false}, ...]}
 * Salida (stdout, JSON): {"items":[{"svg":"<svg…>","w":1.23,"h":2.34,"va":-0.5,"error":null}, ...]}
 *   w, h y va (vertical-align) en ex. Si una fórmula tiene un error de TeX: svg = null y error = mensaje.
 * Se empaqueta con esbuild (target node12) en dist/tex2svg.cjs. Ver README.md.
 */
'use strict';

const { mathjax } = require('mathjax-full/js/mathjax.js');
const { TeX } = require('mathjax-full/js/input/tex.js');
const { SVG } = require('mathjax-full/js/output/svg.js');
const { liteAdaptor } = require('mathjax-full/js/adaptors/liteAdaptor.js');
const { RegisterHTMLHandler } = require('mathjax-full/js/handlers/html.js');

require('mathjax-full/js/input/tex/base/BaseConfiguration.js');
require('mathjax-full/js/input/tex/ams/AmsConfiguration.js');
require('mathjax-full/js/input/tex/newcommand/NewcommandConfiguration.js');
require('mathjax-full/js/input/tex/configmacros/ConfigMacrosConfiguration.js');
require('mathjax-full/js/input/tex/mhchem/MhchemConfiguration.js');
require('mathjax-full/js/input/tex/cancel/CancelConfiguration.js');
require('mathjax-full/js/input/tex/color/ColorConfiguration.js');
require('mathjax-full/js/input/tex/boldsymbol/BoldsymbolConfiguration.js');
require('mathjax-full/js/input/tex/textmacros/TextMacrosConfiguration.js');
require('mathjax-full/js/input/tex/gensymb/GensymbConfiguration.js');
require('mathjax-full/js/input/tex/upgreek/UpgreekConfiguration.js');
require('mathjax-full/js/input/tex/braket/BraketConfiguration.js');
require('mathjax-full/js/input/tex/cases/CasesConfiguration.js');
require('mathjax-full/js/input/tex/mathtools/MathtoolsConfiguration.js');
require('mathjax-full/js/input/tex/enclose/EncloseConfiguration.js');
require('mathjax-full/js/input/tex/extpfeil/ExtpfeilConfiguration.js');

const PACKAGES = ['base', 'ams', 'newcommand', 'configmacros', 'mhchem', 'cancel', 'color', 'boldsymbol', 'textmacros', 'gensymb', 'upgreek', 'braket', 'cases', 'mathtools', 'enclose', 'extpfeil'];
const MAX_ITEMS = 2000;
const MAX_TEX = 2000;

const adaptor = liteAdaptor();
RegisterHTMLHandler(adaptor);
const tex = new TeX({
  packages: PACKAGES,
  // Un error de TeX no se dibuja en rojo: se lanza para que PHP muestre el texto original.
  formatError: (jax, err) => { throw err; },
  macros: { R: '\\mathbb{R}', N: '\\mathbb{N}', Z: '\\mathbb{Z}', Q: '\\mathbb{Q}', C: '\\mathbb{C}', sen: '\\operatorname{sen}', tg: '\\operatorname{tg}', ctg: '\\operatorname{ctg}', arcsen: '\\operatorname{arcsen}', senh: '\\operatorname{senh}' },
});
const svg = new SVG({ fontCache: 'none', internalSpeechTitles: false });
const doc = mathjax.document('', { InputJax: tex, OutputJax: svg });

function num(value) {
  const n = parseFloat(String(value || '').replace('ex', ''));
  return Number.isFinite(n) ? Math.round(n * 1000) / 1000 : 0;
}

function convert(item) {
  const source = String((item && item.tex) || '').slice(0, MAX_TEX);
  if (source.trim() === '') return { svg: null, w: 0, h: 0, va: 0, error: 'empty' };
  try {
    const node = doc.convert(source, { display: !!item.display, em: 16, ex: 8, containerWidth: 80 * 16 });
    const el = adaptor.firstChild(node);
    const style = adaptor.getAttribute(el, 'style') || '';
    const m = /vertical-align:\s*(-?[\d.]+)ex/.exec(style);
    const out = {
      svg: adaptor.outerHTML(el),
      w: num(adaptor.getAttribute(el, 'width')),
      h: num(adaptor.getAttribute(el, 'height')),
      va: m ? num(m[1]) : 0,
      error: null,
    };
    return out;
  } catch (err) {
    return { svg: null, w: 0, h: 0, va: 0, error: String((err && err.message) || err).slice(0, 300) };
  }
}

function main(input) {
  let payload;
  try {
    payload = JSON.parse(input || '{}');
  } catch (e) {
    process.stdout.write(JSON.stringify({ error: 'invalid json: ' + e.message }));
    process.exitCode = 2;
    return;
  }
  const items = Array.isArray(payload.items) ? payload.items.slice(0, MAX_ITEMS) : [];
  const result = { version: mathjax.version, items: items.map(convert) };
  process.stdout.write(JSON.stringify(result));
}

if (process.argv.includes('--version')) {
  process.stdout.write(JSON.stringify({ version: mathjax.version, packages: PACKAGES }) + '\n');
} else {
  const chunks = [];
  process.stdin.setEncoding('utf8');
  process.stdin.on('data', (c) => chunks.push(c));
  process.stdin.on('end', () => main(chunks.join('')));
}
