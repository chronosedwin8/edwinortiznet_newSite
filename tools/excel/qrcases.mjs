// Casos de referencia: matrices del codificador QR del sitio para comparar con el módulo VBA (lo usa build.ps1).
import { encodeQR } from '../../public/assets/js/tools/qrcode.js';
import { writeFileSync } from 'node:fs';
const long = 'Edwin Ortiz Herazo - plantillas de Excel, IA para docentes y concurso docente. '.repeat(6);
const texts = [
  ['', 'M'], ['0', 'M'], ['12345678901234567890', 'M'], ['HELLO WORLD', 'Q'], ['HTTPS://EDWINORTIZ.NET/', 'L'],
  ['https://www.edwinortiz.net/herramientas/generador-qr/', 'M'],
  ['Factura N\u00b0 001 \u2014 Jos\u00e9 P\u00e9rez, \u00f1and\u00fa', 'H'], ['Hola \ud83d\udc4b Excel', 'M'],
  ['WIFI:T:WPA;S:MiRed;P:clave123;;', 'Q'], [long, 'M'], [long.repeat(3), 'L'], [long.repeat(2), 'H'],
  ['ACTIVO-000123 | Port\u00e1til Lenovo | Sala 2', 'M'], ['01234567', 'H'],
];
const out = texts.map(([t, e]) => {
  const q = encodeQR(t, { ecc: e });
  return { text: t, ecc: e, version: q.version, matrix: q.modules.map((r) => r.map((b) => (b ? '1' : '0')).join('')).join('/') };
});
writeFileSync(process.argv[2] || 'qrcases.json', JSON.stringify(out));
