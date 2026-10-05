/**
 * Number to words (Colombian Spanish / international English).
 *
 * JavaScript port of App\Services\Tools\NumberToWords (PHP) with identical output;
 * both are checked against tests/fixtures/numwords_cases.json.
 *
 * Input: string, number or bigint.
 * - number: must be finite; String(number) digits are used (exponents expanded), so 12.5 -> "12.5".
 * - string: surrounding whitespace trimmed, optional leading "+"/"-".
 *   Spanish: if it contains "," then "." are thousands separators and "," is the decimal separator;
 *            else if it contains more than one "." they are thousands separators;
 *            else a single "." is the decimal separator.
 *   English: "," thousands separators, "." decimal separator.
 *   Thousands groups must be valid (1-3 leading digits, then groups of exactly 3).
 * The fraction is rounded half-up to `decimals` digits (0-15) with carry; currency mode always
 * uses 2 (cents). Integer part max 999 999 999 999 999. All digit handling is string/BigInt based.
 *
 * Errors: TypeError for a wrong input type or a malformed string;
 *         RangeError for NaN/Infinity, out-of-range values or invalid `decimals`.
 */

const MAX = 999_999_999_999_999n;
const MAX_DECIMALS = 15;

const ES_UNITS = [
  '', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve',
  'diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve',
  'veinte', 'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro', 'veinticinco', 'veintiséis',
  'veintisiete', 'veintiocho', 'veintinueve',
];
const ES_TENS = ['', '', '', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
const ES_HUNDREDS = [
  '', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos',
  'seiscientos', 'setecientos', 'ochocientos', 'novecientos',
];
const EN_ONES = [
  'zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine',
  'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen',
];
const EN_TENS = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
const EN_SCALES = [
  [1_000_000_000_000n, 'trillion'],
  [1_000_000_000n, 'billion'],
  [1_000_000n, 'million'],
  [1_000n, 'thousand'],
];

/**
 * @param {string|number|bigint} input
 * @param {{currency?: boolean, decimals?: number}} [options]
 * @returns {string}
 */
export function spanish(input, { currency = false, decimals = 2 } = {}) {
  const digits = checkOptions(currency, decimals);
  const { negative, int, frac } = normalize(input, 'es', digits);

  if (currency) {
    let words = esInteger(int, true);
    if (int > 0n && int % 1_000_000n === 0n) {
      words += ' de pesos';
    } else {
      words += int === 1n ? ' peso' : ' pesos';
    }
    if (frac > 0n) {
      words += ' con ' + esInteger(frac, true) + (frac === 1n ? ' centavo' : ' centavos');
    }
    return ((negative ? 'menos ' : '') + words + ' m/cte').toUpperCase();
  }

  let words = esInteger(int, false);
  if (frac > 0n) {
    words += ' con ' + esInteger(frac, false);
  }
  return (negative ? 'menos ' : '') + words;
}

/**
 * @param {string|number|bigint} input
 * @param {{currency?: boolean, decimals?: number}} [options]
 * @returns {string}
 */
export function english(input, { currency = false, decimals = 2 } = {}) {
  const digits = checkOptions(currency, decimals);
  const { negative, int, frac } = normalize(input, 'en', digits);

  let words = enInteger(int);
  if (currency) {
    words += int === 1n ? ' dollar' : ' dollars';
    if (frac > 0n) {
      words += ' and ' + enInteger(frac) + (frac === 1n ? ' cent' : ' cents');
    }
    const out = (negative ? 'minus ' : '') + words;
    return out.charAt(0).toUpperCase() + out.slice(1);
  }

  if (frac > 0n) {
    words += ' and ' + frac.toString().padStart(digits, '0') + '/1' + '0'.repeat(digits);
  }
  return (negative ? 'minus ' : '') + words;
}

function checkOptions(currency, decimals) {
  if (typeof currency !== 'boolean') {
    throw new TypeError('currency must be a boolean');
  }
  if (!Number.isInteger(decimals) || decimals < 0 || decimals > MAX_DECIMALS) {
    throw new RangeError(`decimals must be an integer between 0 and ${MAX_DECIMALS}`);
  }
  return currency ? 2 : decimals;
}

function normalize(input, lang, digits) {
  const plain = toPlain(input, lang);
  const m = /^([+-]?)(\d+)(?:\.(\d+))?$/.exec(plain);
  if (!m) {
    throw new TypeError(`Invalid number: ${plain}`);
  }

  const intDigits = m[2].replace(/^0+/, '');
  if (intDigits.length > 15) {
    throw new RangeError(`Number out of range (max ${MAX})`);
  }
  let int = BigInt(intDigits === '' ? '0' : intDigits);

  const fracDigits = (m[3] ?? '').padEnd(digits + 1, '0');
  let frac = digits > 0 ? BigInt(fracDigits.slice(0, digits)) : 0n;
  if (fracDigits[digits] >= '5') {
    frac += 1n;
    if (frac >= 10n ** BigInt(digits)) {
      frac = 0n;
      int += 1n;
    }
  }
  if (int > MAX) {
    throw new RangeError(`Number out of range (max ${MAX})`);
  }

  return { negative: m[1] === '-' && (int > 0n || frac > 0n), int, frac };
}

/** Converts the input to a plain "[+-]digits[.digits]" string. */
function toPlain(input, lang) {
  if (typeof input === 'bigint') {
    return input.toString();
  }
  if (typeof input === 'number') {
    if (!Number.isFinite(input)) {
      throw new RangeError('Number must be finite');
    }
    return expandExponent(String(input));
  }
  if (typeof input !== 'string') {
    throw new TypeError('Input must be a string, number or bigint');
  }

  // Same character set as PHP's trim().
  const s = input.replace(/^[ \t\n\r\0\v]+|[ \t\n\r\0\v]+$/g, '');
  const m = /^([+-]?)([\s\S]+)$/.exec(s);
  if (!m) {
    throw new TypeError('Invalid number: empty string');
  }
  const [, sign, body] = m;

  if (lang === 'en') {
    if (!/^(\d{1,3}(?:,\d{3})+|\d+)(\.\d+)?$/.test(body)) {
      throw new TypeError(`Invalid number: ${input}`);
    }
    return sign + body.replaceAll(',', '');
  }

  if (body.includes(',')) {
    const p = /^(\d{1,3}(?:\.\d{3})+|\d+),(\d+)$/.exec(body);
    if (!p) {
      throw new TypeError(`Invalid number: ${input}`);
    }
    return sign + p[1].replaceAll('.', '') + '.' + p[2];
  }
  if (body.split('.').length - 1 > 1) {
    if (!/^\d{1,3}(?:\.\d{3})+$/.test(body)) {
      throw new TypeError(`Invalid number: ${input}`);
    }
    return sign + body.replaceAll('.', '');
  }
  if (!/^\d+(?:\.\d+)?$/.test(body)) {
    throw new TypeError(`Invalid number: ${input}`);
  }
  return sign + body;
}

/** "1.5e+21" -> "1500000000000000000000", "1e-7" -> "0.0000001"; plain strings pass through. */
function expandExponent(repr) {
  const m = /^(-?)(\d+)(?:\.(\d*))?[eE]([+-]?\d+)$/.exec(repr);
  if (!m) {
    return repr;
  }
  const digits = m[2] + (m[3] ?? '');
  const point = m[2].length + Number(m[4]);
  if (point <= 0) {
    return m[1] + '0.' + '0'.repeat(-point) + digits;
  }
  if (point >= digits.length) {
    return m[1] + digits + '0'.repeat(point - digits.length);
  }
  return m[1] + digits.slice(0, point) + '.' + digits.slice(point);
}

/** apocope: trailing "uno" -> "un", "veintiuno" -> "veintiún" (before a masculine noun). */
function esInteger(n, apocope) {
  if (n === 0n) {
    return 'cero';
  }
  const billions = Number(n / 1_000_000_000_000n);
  const millions = Number((n % 1_000_000_000_000n) / 1_000_000n);
  const rest = Number(n % 1_000_000n);

  const parts = [];
  if (billions === 1) {
    parts.push('un billón');
  } else if (billions > 1) {
    parts.push(esBelowMillion(billions, true) + ' billones');
  }
  if (millions === 1) {
    parts.push('un millón');
  } else if (millions > 1) {
    parts.push(esBelowMillion(millions, true) + ' millones');
  }
  if (rest > 0) {
    parts.push(esBelowMillion(rest, apocope));
  }
  return parts.join(' ');
}

/** 1..999999 (Number) */
function esBelowMillion(n, apocope) {
  const thousands = Math.floor(n / 1000);
  const rest = n % 1000;
  const parts = [];
  if (thousands === 1) {
    parts.push('mil');
  } else if (thousands > 1) {
    parts.push(esBelowThousand(thousands, true) + ' mil');
  }
  if (rest > 0) {
    parts.push(esBelowThousand(rest, apocope));
  }
  return parts.join(' ');
}

/** 1..999 (Number) */
function esBelowThousand(n, apocope) {
  const hundreds = Math.floor(n / 100);
  const rest = n % 100;
  const parts = [];
  if (hundreds > 0) {
    parts.push(n === 100 ? 'cien' : ES_HUNDREDS[hundreds]);
  }
  if (rest > 0) {
    let word;
    if (rest < 30) {
      word = ES_UNITS[rest];
      if (apocope && rest === 1) {
        word = 'un';
      } else if (apocope && rest === 21) {
        word = 'veintiún';
      }
    } else {
      const unit = rest % 10;
      word = ES_TENS[Math.floor(rest / 10)];
      if (unit > 0) {
        word += ' y ' + (apocope && unit === 1 ? 'un' : ES_UNITS[unit]);
      }
    }
    parts.push(word);
  }
  return parts.join(' ');
}

function enInteger(n) {
  if (n === 0n) {
    return 'zero';
  }
  const parts = [];
  for (const [scale, name] of EN_SCALES) {
    if (n >= scale) {
      parts.push(enBelowThousand(Number(n / scale)) + ' ' + name);
      n %= scale;
    }
  }
  if (n > 0n) {
    parts.push(enBelowThousand(Number(n)));
  }
  return parts.join(' ');
}

/** 1..999 (Number) */
function enBelowThousand(n) {
  const parts = [];
  if (n >= 100) {
    parts.push(EN_ONES[Math.floor(n / 100)] + ' hundred');
    n %= 100;
  }
  if (n >= 20) {
    parts.push(EN_TENS[Math.floor(n / 10)] + (n % 10 > 0 ? '-' + EN_ONES[n % 10] : ''));
  } else if (n > 0) {
    parts.push(EN_ONES[n]);
  }
  return parts.join(' ');
}
