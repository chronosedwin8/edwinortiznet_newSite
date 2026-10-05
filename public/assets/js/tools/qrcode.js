// QR Code encoder (ISO/IEC 18004) — self-contained ES module, no dependencies.
// Supports numeric / alphanumeric / byte (UTF-8) modes, versions 1–40,
// ECC levels L/M/Q/H, automatic version and mask selection.

// ---- Tables (index 0 unused; [ecc][version]) ----------------------------
const ECC_ORDER = { L: 0, M: 1, Q: 2, H: 3 };
const FORMAT_ECC_BITS = [1, 0, 3, 2]; // L, M, Q, H as encoded in format info

const ECC_PER_BLOCK = [
  [-1, 7, 10, 15, 20, 26, 18, 20, 24, 30, 18, 20, 24, 26, 30, 22, 24, 28, 30, 28, 28, 28, 28, 30, 30, 26, 28, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30],
  [-1, 10, 16, 26, 18, 24, 16, 18, 22, 22, 26, 30, 22, 22, 24, 24, 28, 28, 26, 26, 26, 26, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28, 28],
  [-1, 13, 22, 18, 26, 18, 24, 18, 22, 20, 24, 28, 26, 24, 20, 30, 24, 28, 28, 26, 30, 28, 30, 30, 30, 30, 28, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30],
  [-1, 17, 28, 22, 16, 22, 28, 26, 26, 24, 28, 24, 28, 22, 24, 24, 30, 28, 28, 26, 28, 30, 24, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30, 30],
];
const NUM_BLOCKS = [
  [-1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 4, 4, 4, 4, 4, 6, 6, 6, 6, 7, 8, 8, 9, 9, 10, 12, 12, 12, 13, 14, 15, 16, 17, 18, 19, 19, 20, 21, 22, 24, 25],
  [-1, 1, 1, 1, 2, 2, 4, 4, 4, 5, 5, 5, 8, 9, 9, 10, 10, 11, 13, 14, 16, 17, 17, 18, 20, 21, 23, 25, 26, 28, 29, 31, 33, 35, 37, 38, 40, 43, 45, 47, 49],
  [-1, 1, 1, 2, 2, 4, 4, 6, 6, 8, 8, 8, 10, 12, 16, 12, 17, 16, 18, 21, 20, 23, 23, 25, 27, 29, 34, 34, 35, 38, 40, 43, 45, 48, 51, 53, 56, 59, 62, 65, 68],
  [-1, 1, 1, 2, 4, 4, 4, 5, 6, 8, 8, 11, 11, 16, 16, 18, 16, 19, 21, 25, 25, 25, 34, 30, 32, 35, 37, 40, 42, 45, 48, 51, 54, 57, 60, 63, 66, 70, 74, 77, 81],
];

const ALNUM_CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ $%*+-./:';

// Modes: indicator bits and character-count bit widths for versions 1–9 / 10–26 / 27–40.
const MODES = {
  numeric: { bits: 0x1, cc: [10, 12, 14] },
  alnum:   { bits: 0x2, cc: [9, 11, 13] },
  byte:    { bits: 0x4, cc: [8, 16, 16] },
};

// ---- GF(256) arithmetic and Reed–Solomon --------------------------------
const EXP = new Uint8Array(512);
const LOG = new Uint8Array(256);
for (let i = 0, x = 1; i < 255; i++) {
  EXP[i] = x;
  LOG[x] = i;
  x <<= 1;
  if (x & 0x100) x ^= 0x11d;
}
for (let i = 255; i < 512; i++) EXP[i] = EXP[i - 255];

const gfMul = (a, b) => (a && b ? EXP[LOG[a] + LOG[b]] : 0);

// Generator polynomial coefficients (highest degree first, leading 1 omitted).
function rsDivisor(degree) {
  const poly = new Uint8Array(degree);
  poly[degree - 1] = 1;
  let root = 1;
  for (let i = 0; i < degree; i++) {
    for (let j = 0; j < degree; j++) {
      poly[j] = gfMul(poly[j], root);
      if (j + 1 < degree) poly[j] ^= poly[j + 1];
    }
    root = gfMul(root, 2);
  }
  return poly;
}

function rsRemainder(data, divisor) {
  const n = divisor.length;
  const rem = new Uint8Array(n);
  for (const b of data) {
    const factor = b ^ rem[0];
    rem.copyWithin(0, 1);
    rem[n - 1] = 0;
    for (let i = 0; i < n; i++) rem[i] ^= gfMul(divisor[i], factor);
  }
  return rem;
}

// ---- Capacity helpers ---------------------------------------------------
// Number of modules available for data + ECC (after function patterns).
function rawDataModules(ver) {
  let n = (16 * ver + 128) * ver + 64;
  if (ver >= 2) {
    const align = Math.floor(ver / 7) + 2;
    n -= (25 * align - 10) * align - 55;
    if (ver >= 7) n -= 36;
  }
  return n;
}

const dataCodewords = (ver, e) =>
  Math.floor(rawDataModules(ver) / 8) - ECC_PER_BLOCK[e][ver] * NUM_BLOCKS[e][ver];

function alignmentPositions(ver) {
  if (ver === 1) return [];
  const count = Math.floor(ver / 7) + 2;
  const step = Math.floor((ver * 8 + count * 3 + 5) / (count * 4 - 4)) * 2;
  const out = [6];
  for (let pos = ver * 4 + 10; out.length < count; pos -= step) out.splice(1, 0, pos);
  return out;
}

// ---- Data segment -------------------------------------------------------
function makeSegment(text) {
  const bits = [];
  const push = (val, len) => {
    for (let i = len - 1; i >= 0; i--) bits.push((val >>> i) & 1);
  };
  if (/^[0-9]*$/.test(text)) {
    for (let i = 0; i < text.length; i += 3) {
      const chunk = text.substr(i, 3);
      push(parseInt(chunk, 10), chunk.length * 3 + 1);
    }
    return { mode: MODES.numeric, count: text.length, bits };
  }
  if ([...text].every((c) => ALNUM_CHARS.includes(c))) {
    for (let i = 0; i < text.length; i += 2) {
      const a = ALNUM_CHARS.indexOf(text[i]);
      if (i + 1 < text.length) push(a * 45 + ALNUM_CHARS.indexOf(text[i + 1]), 11);
      else push(a, 6);
    }
    return { mode: MODES.alnum, count: text.length, bits };
  }
  const bytes = new TextEncoder().encode(text);
  for (const b of bytes) push(b, 8);
  return { mode: MODES.byte, count: bytes.length, bits };
}

const ccBits = (mode, ver) => mode.cc[ver <= 9 ? 0 : ver <= 26 ? 1 : 2];

// ---- Codeword construction ----------------------------------------------
function buildCodewords(seg, ver, e) {
  const capacity = dataCodewords(ver, e) * 8;
  const bits = [];
  const push = (val, len) => {
    for (let i = len - 1; i >= 0; i--) bits.push((val >>> i) & 1);
  };
  push(seg.mode.bits, 4);
  push(seg.count, ccBits(seg.mode, ver));
  for (const b of seg.bits) bits.push(b);
  // Terminator (up to 4 zeros), byte alignment, then alternating pad bytes.
  push(0, Math.min(4, capacity - bits.length));
  push(0, (8 - (bits.length % 8)) % 8);
  for (let pad = 0xec; bits.length < capacity; pad ^= 0xec ^ 0x11) push(pad, 8);

  const data = new Uint8Array(capacity / 8);
  for (let i = 0; i < bits.length; i++) data[i >>> 3] |= bits[i] << (7 - (i & 7));

  // Split into blocks, append ECC, interleave.
  const numBlocks = NUM_BLOCKS[e][ver];
  const eccLen = ECC_PER_BLOCK[e][ver];
  const rawCodewords = Math.floor(rawDataModules(ver) / 8);
  const numShort = numBlocks - (rawCodewords % numBlocks);
  const shortDataLen = Math.floor(rawCodewords / numBlocks) - eccLen;
  const divisor = rsDivisor(eccLen);
  const dataBlocks = [];
  const eccBlocks = [];
  for (let i = 0, k = 0; i < numBlocks; i++) {
    const len = shortDataLen + (i < numShort ? 0 : 1);
    const block = data.subarray(k, k + len);
    k += len;
    dataBlocks.push(block);
    eccBlocks.push(rsRemainder(block, divisor));
  }
  const out = [];
  for (let i = 0; i <= shortDataLen; i++)
    for (const b of dataBlocks) if (i < b.length) out.push(b[i]);
  for (let i = 0; i < eccLen; i++) for (const b of eccBlocks) out.push(b[i]);
  return out;
}

// ---- Matrix construction ------------------------------------------------
const MASKS = [
  (x, y) => (x + y) % 2 === 0,
  (x, y) => y % 2 === 0,
  (x) => x % 3 === 0,
  (x, y) => (x + y) % 3 === 0,
  (x, y) => (Math.floor(x / 3) + Math.floor(y / 2)) % 2 === 0,
  (x, y) => ((x * y) % 2) + ((x * y) % 3) === 0,
  (x, y) => (((x * y) % 2) + ((x * y) % 3)) % 2 === 0,
  (x, y) => (((x + y) % 2) + ((x * y) % 3)) % 2 === 0,
];

class Matrix {
  constructor(ver) {
    this.size = ver * 4 + 17;
    this.mod = Array.from({ length: this.size }, () => new Array(this.size).fill(false));
    this.fn = Array.from({ length: this.size }, () => new Array(this.size).fill(false));
  }
  setFn(x, y, dark) {
    this.mod[y][x] = dark;
    this.fn[y][x] = true;
  }
}

function drawFunctionPatterns(m, ver) {
  const n = m.size;
  // Timing patterns
  for (let i = 0; i < n; i++) {
    m.setFn(6, i, i % 2 === 0);
    m.setFn(i, 6, i % 2 === 0);
  }
  // Finder patterns with separators
  for (const [cx, cy] of [[3, 3], [n - 4, 3], [3, n - 4]]) {
    for (let dy = -4; dy <= 4; dy++) {
      for (let dx = -4; dx <= 4; dx++) {
        const x = cx + dx, y = cy + dy;
        if (x < 0 || y < 0 || x >= n || y >= n) continue;
        const d = Math.max(Math.abs(dx), Math.abs(dy));
        m.setFn(x, y, d !== 2 && d !== 4);
      }
    }
  }
  // Alignment patterns (skip the three overlapping the finders)
  const pos = alignmentPositions(ver);
  const last = pos.length - 1;
  pos.forEach((ay, i) => {
    pos.forEach((ax, j) => {
      if ((i === 0 && j === 0) || (i === 0 && j === last) || (i === last && j === 0)) return;
      for (let dy = -2; dy <= 2; dy++)
        for (let dx = -2; dx <= 2; dx++)
          m.setFn(ax + dx, ay + dy, Math.max(Math.abs(dx), Math.abs(dy)) !== 1);
    });
  });
  drawFormat(m, 0, 0); // reserve area; real bits drawn later
  // Version information (versions >= 7)
  if (ver >= 7) {
    let rem = ver;
    for (let i = 0; i < 12; i++) rem = (rem << 1) ^ ((rem >>> 11) * 0x1f25);
    const bits = (ver << 12) | rem;
    for (let i = 0; i < 18; i++) {
      const dark = ((bits >>> i) & 1) === 1;
      const a = n - 11 + (i % 3), b = Math.floor(i / 3);
      m.setFn(a, b, dark);
      m.setFn(b, a, dark);
    }
  }
}

function drawFormat(m, e, mask) {
  const data = (FORMAT_ECC_BITS[e] << 3) | mask;
  let rem = data;
  for (let i = 0; i < 10; i++) rem = (rem << 1) ^ ((rem >>> 9) * 0x537);
  const bits = ((data << 10) | rem) ^ 0x5412;
  const bit = (i) => ((bits >>> i) & 1) === 1;
  const n = m.size;
  // First copy, around the top-left finder
  for (let i = 0; i <= 5; i++) m.setFn(8, i, bit(i));
  m.setFn(8, 7, bit(6));
  m.setFn(8, 8, bit(7));
  m.setFn(7, 8, bit(8));
  for (let i = 9; i < 15; i++) m.setFn(14 - i, 8, bit(i));
  // Second copy, split between top-right and bottom-left
  for (let i = 0; i < 8; i++) m.setFn(n - 1 - i, 8, bit(i));
  for (let i = 8; i < 15; i++) m.setFn(8, n - 15 + i, bit(i));
  m.setFn(8, n - 8, true); // always-dark module
}

// Zigzag placement of codeword bits into non-function modules.
function placeData(m, codewords) {
  const n = m.size;
  let i = 0;
  const total = codewords.length * 8;
  for (let right = n - 1; right >= 1; right -= 2) {
    if (right === 6) right = 5;
    const upward = ((right + 1) & 2) === 0;
    for (let v = 0; v < n; v++) {
      const y = upward ? n - 1 - v : v;
      for (let j = 0; j < 2; j++) {
        const x = right - j;
        if (m.fn[y][x]) continue;
        if (i < total) m.mod[y][x] = ((codewords[i >>> 3] >>> (7 - (i & 7))) & 1) === 1;
        i++; // remainder bits stay light
      }
    }
  }
}

function applyMask(m, mask) {
  const f = MASKS[mask];
  for (let y = 0; y < m.size; y++)
    for (let x = 0; x < m.size; x++)
      if (!m.fn[y][x] && f(x, y)) m.mod[y][x] = !m.mod[y][x];
}

// ---- Penalty score (rules N1–N4) ----------------------------------------
function penalty(mod) {
  const n = mod.length;
  let score = 0;
  let dark = 0;
  const get = (x, y, col) => (col ? mod[x][y] : mod[y][x]);
  const P1 = [true, false, true, true, true, false, true, false, false, false, false];
  const P2 = [false, false, false, false, true, false, true, true, true, false, true];
  for (let col = 0; col < 2; col++) {
    for (let y = 0; y < n; y++) {
      let run = 0;
      let prev = null;
      for (let x = 0; x < n; x++) {
        const c = get(x, y, col);
        if (!col && c) dark++;
        if (c === prev) run++;
        else {
          if (run >= 5) score += run - 2;
          run = 1;
          prev = c;
        }
        // N3: finder-like 1:1:3:1:1 with 4 light modules on one side
        if (x + 11 <= n) {
          let a = true, b = true;
          for (let k = 0; k < 11 && (a || b); k++) {
            const v = get(x + k, y, col);
            if (v !== P1[k]) a = false;
            if (v !== P2[k]) b = false;
          }
          if (a) score += 40;
          if (b) score += 40;
        }
      }
      if (run >= 5) score += run - 2;
    }
  }
  // N2: 2x2 blocks of same color
  for (let y = 0; y < n - 1; y++)
    for (let x = 0; x < n - 1; x++) {
      const c = mod[y][x];
      if (c === mod[y][x + 1] && c === mod[y + 1][x] && c === mod[y + 1][x + 1]) score += 3;
    }
  // N4: dark/light balance
  const total = n * n;
  score += Math.max(0, Math.ceil(Math.abs(dark * 20 - total * 10) / total) - 1) * 10;
  return score;
}

// ---- Public API ---------------------------------------------------------
export function encodeQR(text, { ecc = 'M', minVersion = 1, maxVersion = 40, mask = -1 } = {}) {
  const level = String(ecc).toUpperCase();
  const e = ECC_ORDER[level];
  if (e === undefined) throw new RangeError('QR_BAD_ECC');
  if (!(minVersion >= 1 && maxVersion <= 40 && minVersion <= maxVersion)) throw new RangeError('QR_BAD_VERSION');
  if (!(Number.isInteger(mask) && mask >= -1 && mask <= 7)) throw new RangeError('QR_BAD_MASK');

  const seg = makeSegment(String(text ?? ''));
  let ver = 0;
  for (let v = minVersion; v <= maxVersion; v++) {
    const cc = ccBits(seg.mode, v);
    if (seg.count < 1 << cc && 4 + cc + seg.bits.length <= dataCodewords(v, e) * 8) {
      ver = v;
      break;
    }
  }
  if (!ver) throw new RangeError('QR_TOO_LONG');

  const m = new Matrix(ver);
  drawFunctionPatterns(m, ver);
  placeData(m, buildCodewords(seg, ver, e));

  let chosen = mask;
  if (chosen < 0) {
    let best = Infinity;
    for (let k = 0; k < 8; k++) {
      applyMask(m, k);
      drawFormat(m, e, k);
      const p = penalty(m.mod);
      if (p < best) {
        best = p;
        chosen = k;
      }
      applyMask(m, k); // XOR again to undo
    }
  }
  applyMask(m, chosen);
  drawFormat(m, e, chosen);
  return { version: ver, size: m.size, ecc: level, mask: chosen, modules: m.mod };
}

const escAttr = (s) => String(s).replace(/[&<>"']/g, (c) => `&#${c.charCodeAt(0)};`);

export function toSVG(qr, { margin = 4, dark = '#000000', light = '#ffffff', size = null } = {}) {
  const mg = Math.max(0, Math.floor(margin));
  const dim = qr.size + mg * 2;
  let path = '';
  qr.modules.forEach((row, y) => {
    for (let x = 0; x < qr.size; x++) {
      if (!row[x]) continue;
      let len = 1;
      while (x + len < qr.size && row[x + len]) len++;
      path += `M${x + mg} ${y + mg}h${len}v1h-${len}z`;
      x += len - 1;
    }
  });
  const wh = size ? ` width="${escAttr(size)}" height="${escAttr(size)}"` : '';
  return (
    `<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 ${dim} ${dim}"${wh} shape-rendering="crispEdges">` +
    `<rect width="${dim}" height="${dim}" fill="${escAttr(light)}"/>` +
    `<path d="${path}" fill="${escAttr(dark)}"/></svg>`
  );
}

export function drawToCanvas(qr, canvas, { scale = 8, margin = 4, dark = '#000', light = '#fff' } = {}) {
  const s = Math.max(1, Math.floor(scale));
  const mg = Math.max(0, Math.floor(margin));
  const px = (qr.size + mg * 2) * s;
  canvas.width = px;
  canvas.height = px;
  const ctx = canvas.getContext('2d');
  ctx.fillStyle = light;
  ctx.fillRect(0, 0, px, px);
  ctx.fillStyle = dark;
  qr.modules.forEach((row, y) => {
    for (let x = 0; x < qr.size; x++) {
      if (!row[x]) continue;
      let len = 1;
      while (x + len < qr.size && row[x + len]) len++;
      ctx.fillRect((x + mg) * s, (y + mg) * s, len * s, s);
      x += len - 1;
    }
  });
}
