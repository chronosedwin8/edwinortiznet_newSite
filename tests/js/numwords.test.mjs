// Run with: node tests/js/numwords.test.mjs
// Shares tests/fixtures/numwords_cases.json with tests/NumberToWordsTest.php (PHP/JS parity).
import { test } from 'node:test';
import assert from 'node:assert/strict';
import { readFileSync } from 'node:fs';
import { spanish, english } from '../../public/assets/js/tools/numwords.js';

const cases = JSON.parse(readFileSync(new URL('../fixtures/numwords_cases.json', import.meta.url), 'utf8'));

const convert = ({ lang, input, currency, decimals = 2 }) =>
  (lang === 'es' ? spanish : english)(input, { currency, decimals });

const label = (c, i) => `#${i} ${c.lang}${c.currency ? ' currency' : ''} ${JSON.stringify(c.input)}`
  + (c.decimals !== undefined ? ` decimals=${c.decimals}` : '');

cases.forEach((c, i) => {
  if (c.expected === null) {
    test(`rejects ${label(c, i)}`, () => {
      assert.throws(() => convert(c), (e) => e instanceof TypeError || e instanceof RangeError);
    });
  } else {
    test(`converts ${label(c, i)}`, () => {
      assert.equal(convert(c), c.expected);
    });
  }
});

test('fixture covers required cases', () => {
  for (const key of ['es', 'es$', 'en', 'en$']) {
    const inputs = cases
      .filter((c) => c.lang + (c.currency ? '$' : '') === key)
      .map((c) => c.input);
    for (const n of [0, 1, 21, 100, 101, 1000, 1000000, 1001001]) {
      assert.ok(inputs.includes(n), `${key} missing ${n}`);
    }
  }
});

test('rejects non-finite or huge numbers with RangeError', () => {
  for (const v of [Infinity, -Infinity, NaN, 1e20]) {
    assert.throws(() => spanish(v), RangeError);
  }
});

test('rejects wrong input types and malformed strings with TypeError', () => {
  for (const v of [null, undefined, {}, [], true]) {
    assert.throws(() => spanish(v), TypeError);
    assert.throws(() => english(v), TypeError);
  }
  assert.throws(() => spanish('abc'), TypeError);
  assert.throws(() => english(5, { currency: 'yes' }), TypeError);
});

test('rejects invalid decimals with RangeError', () => {
  assert.throws(() => spanish(5, { decimals: 1.5 }), RangeError);
  assert.throws(() => english(5, { decimals: -1 }), RangeError);
});

test('expands float exponents (same as PHP)', () => {
  assert.equal(spanish(1e-7), 'cero');
  assert.equal(spanish(1e12), 'un billón');
  assert.equal(english(1e14), 'one hundred trillion');
  assert.equal(english(1.005), 'one and 01/100');
});

test('accepts bigint and default options', () => {
  assert.equal(spanish(999_999_999_999_999n).endsWith('novecientos noventa y nueve'), true);
  assert.equal(english(21n, { currency: true }), 'Twenty-one dollars');
});
