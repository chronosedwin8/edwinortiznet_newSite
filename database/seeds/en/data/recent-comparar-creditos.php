<?php

declare(strict_types=1);

// English version of «Comparar dos ofertas de crédito en Excel: tasa real, costo total y preguntas ant…». Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/comparar-creditos/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};
$code = static fn (string $html): string => (string) preg_replace_callback(
    '#<pre><code>(.*?)</code></pre>#s',
    static fn (array $m): string => '<pre><code>' . htmlspecialchars($m[1], ENT_NOQUOTES, 'UTF-8') . '</code></pre>',
    $html
);

$html = <<<'HTML'
<p>Two banks offer you the same loan: $20 million over 36 months. The first advertises a rate of 20.0% effective annual; the second, 22.5%. The decision seems obvious, but it is not: <strong>the advertised rate does not include the insurance, the fee or other charges that also come out of your pocket</strong>. In this article's example, the offer with the lowest rate ends up costing $822,768 more.</p>
<p>Here we build a <a href="/descargas/comparar-creditos/comparador-ofertas-credito.xlsx">loan-offer comparator in Excel</a> (in Spanish) that calculates the payment, the total cost and the <strong>real effective annual rate</strong> (the one that includes insurance and fees), with an amortization table and a list of questions before signing. All results were verified in Microsoft Excel 16 with an independent calculation in Python, using fictional data. Rules and data reviewed on October 10, 2026.</p>
<p class="notice"><strong>Warnings.</strong> This is not financial, tax or legal advice. The comparator assumes a fixed rate, equal monthly payments and fixed charges; if your loan has a variable rate, grace periods or percentage charges on the balance, adjust the sheet or ask the lender for a projection. Always confirm the terms in the contract and with the lender. The example data are fictional.</p>

<h2>The example's result</h2>
{{img:ofertas}}
<p>Both loans are $20,000,000 over 36 months. Offer A advertises 20.0% E. A., with $45,000 monthly insurance and a $400,000 fee deducted from the disbursement (you receive $19,600,000). Offer B advertises 22.5% E. A., with $12,000 monthly insurance and no fee. Verified results:</p>
<ul>
<li><strong>Loan payment</strong> (capital and interest only): A $726,779; B $748,036. It looks like A wins.</li>
<li><strong>Total monthly payment</strong> (with insurance): A $771,779; B $760,036. The order has already changed.</li>
<li><strong>Total you will pay:</strong> A $28,184,053; B $27,361,286. <strong>B costs $822,768 less.</strong></li>
<li><strong>Real effective annual rate</strong> (including insurance and fee, on what you actually receive): A 27.16%; B 23.91%.</li>
</ul>
<p>A's real rate is 27.16%, seven points above the advertised one. That difference is what hides in the "additional costs".</p>

<h2>How it is calculated, formula by formula</h2>
<p>The yellow cells are each offer's data; the rest are formulas (here in English and in Spanish).</p>
<pre><code>' 1. Monthly rate equivalent to the effective annual rate (E. A.)
=(1+C7)^(1/12)-1

' 2. Loan payment (capital and interest): PMT(rate, term, -amount)
=PMT(B12,B6,-B5)             ' English
=PAGO(B12;B6;-B5)            ' Spanish

' 3. Total payment with insurance and other fixed charges
=B13+B8

' 4. Net disbursement: what you actually receive
=B5-B9

' 5. Total paid and total cost of the loan
=B14*B6+B9
=B16-B5

' 6. REAL monthly rate: the rate that equates what you receive with the total payments
=RATE(B6,-B14,B15)          ' English
=TASA(B6;-B14;B15)          ' Spanish

' 7. Real effective annual rate
=(1+B18)^12-1</code></pre>
<p><strong>Why step 6 works.</strong> The <code>RATE</code> function finds the monthly rate at which the present value of the total payments equals the money you receive. By putting the insurance and the fee into the cash flow, you get a rate that is comparable across offers even if they have different structures. It is, in essence, an internal rate of return of the loan seen from the borrower's side.</p>
<p><strong>Why the effective annual rate is converted to monthly with a power and not by dividing by 12.</strong> A 22.5% effective annual rate equals 1.7056% monthly, not 1.875% (22.5/12), because interest compounds. Dividing by 12 is only correct for a nominal annual rate, which is why the sheet always asks for the effective annual one.</p>

<h2>The amortization table</h2>
<p>The <em>Amortizacion_A</em> sheet shows, month by month, the opening balance, interest, principal repayment and closing balance, with up to 60 payments (extra rows stay empty depending on the term). In the example, offer A pays $6,164,053 in interest, the principal paid adds up to $20,000,000 and the closing balance is zero, as it should be. Seeing the table helps you understand something almost nobody notices: in the first months, most of the payment is interest, which is why early extra principal payments save more.</p>

<h2>Five steps to compare</h2>
{{img:pasos}}
<ol>
<li><strong>Ask both lenders for the same thing:</strong> same amount and same term. Without that, there is no comparison.</li>
<li><strong>Write everything down:</strong> effective annual rate (not nominal), insurance (life, debtor, unemployment), fees, account fees and any other charge, whether upfront or monthly.</li>
<li><strong>Calculate</strong> the payment, total cost and real rate with the comparator.</li>
<li><strong>Ask</strong> what the sheet does not know (there is a list of nine questions): early payment, late fees, variable rate, reporting to credit bureaus, what happens if you lose your job.</li>
<li><strong>Decide with your budget:</strong> the best offer by cost may not be the one that fits your month. The total payment must fit without touching the essentials.</li>
</ol>

<h2>What Colombian regulation says (verified)</h2>
<ul>
<li><strong>Transparency and total cost.</strong> Law 1328 of 2009 requires supervised institutions to give accurate, sufficient, clear and timely information about costs. Law 1748 of 2014 added that, besides the interest rate, the <strong>Unified Total Value (Valor Total Unificado, VTU)</strong> must be reported, which gathers all items actually paid or received, and that a VTU projection be delivered before signing when the nature of the product allows it. Ask for it: it is exactly the figure that compares offers.</li>
<li><strong>Early payment.</strong> Under the same law, lenders must report before granting the loan on the possibility of paying early (with exceptions for very large loans, over 880 minimum wages). Ask whether it reduces the payment or the term and whether there is a penalty.</li>
<li><strong>Usury cap.</strong> The Financial Superintendency periodically certifies the <strong>current bank interest rate (IBC)</strong> for each loan category; under Article 884 of the Commercial Code, remunerative and late-payment interest cannot exceed 1.5 times the IBC. For example, with a consumer and ordinary IBC of 16.24% E. A. (the one certified for January 2026), the cap would be close to 24.36% E. A. (an illustrative calculation; the current value for the month and category is verified on the Superfinanciera site). The sheet includes a cell for you to enter the current IBC and compares the advertised rate with the cap. Note: the cap applies to the agreed interest; insurance and fees have their own regulation, and the sheet's "real" rate is a comparison tool, not a ruling on usury.</li>
</ul>
<p>If you believe you were overcharged or not informed of what you should have been, you can file a complaint with the lender and, if it is not resolved, go to the Financial Superintendency and the financial consumer ombudsman, following the current procedure.</p>

<h2>When numbers are not enough</h2>
<p>A comparator does not know whether the loan is necessary. Before comparing offers, ask what it is for, whether there are alternatives (postponing the purchase, saving part of it, a smaller loan) and what happens if income falls. And if the loan is for education, look also at the specific lines available in your region and their real cost, calculated with this same sheet. For an institution's technology purchases, see <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">the total cost of a platform</a>.</p>

<h2>Colombia, Latin America and the world</h2>
<p>In Colombia, the financial system is supervised by the Financial Superintendency, which also certifies reference rates; in the region, many countries require reporting a "total cost" or an equivalent rate that includes charges (with different names, such as total annual cost in some countries), and worldwide the discussion about the real cost of consumer credit is broad. In every case the lesson is the same: compare by total cost, not by the advertised rate. For <strong>teachers</strong>, who often access payroll-deduction or cooperative loans, comparing the total cost between those options and banks is useful; for <strong>principals</strong> and <strong>cooperatives</strong>, reporting total cost clearly; for <strong>families</strong>, always asking for the VTU; and for <strong>young people</strong>, learning to read an offer before signing. This financial literacy is taught with concrete cases like this one.</p>

<h2>Templates and resources</h2>
<p>If you want to start from ready-made Excel templates, with support, look at these options. To ask an AI for help with your formulas (always verifying the result and without pasting personal data), there is a <a href="/descargas/excel-con-ia/excel-con-ia.zip">free Excel with AI guide</a>.</p>
{{productos:listado-de-asistencia-laboral-o-academica-en-excel,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/promedios-en-excel-para-docentes-siete-errores-que-cambian-una-nota/">averages in Excel: seven mistakes</a>, <a href="/errores-excel-na-spill-calc-value-que-significan-como-arreglarlos/">the #N/A, #SPILL! and #VALUE! errors</a> and <a href="/pronosticos-en-excel-tendencia-estacionalidad-cuando-no-confiar/">forecasting in Excel</a>. And to teach financial mathematics with real cases, see <a href="/herramientas/generador-de-examenes/">the AI Exam Generator</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is the difference between a nominal and an effective annual rate?</h3>
<p>The effective annual rate includes the effect of compounding interest during the year; the nominal one does not. To compare loans use the effective annual rate.</p>
<h3>How do I calculate a loan payment in Excel?</h3>
<p>With the PMT function: =PMT(monthly rate, number of payments, -amount). The monthly rate is obtained from the effective annual one with =(1+E.A.)^(1/12)-1.</p>
<h3>What is the Unified Total Value?</h3>
<p>A figure that, under Law 1748 of 2014, supervised institutions must report and that gathers all items actually paid or received by the customer, besides the interest rate. Ask for it before signing.</p>
<h3>Why is the real rate higher than the advertised one?</h3>
<p>Because it includes charges the advertised rate does not reflect (insurance, fees and others) and calculates them on what you actually receive.</p>
<h3>Does the comparator work for variable-rate loans?</h3>
<p>Only as an approximation with today's rate. Ask the lender for a projection or try the sheet with higher-rate scenarios.</p>

<p class="notice"><strong>Compare with your own data.</strong> Download the <a href="/descargas/comparar-creditos/comparador-ofertas-credito.xlsx">loan-offer comparator</a> (in Spanish), replace the yellow cells with your two offers and see which really costs less. Before signing, answer the list of questions on the last sheet.</p>

<h2>Food for thought</h2>
<p>Loan offers are advertised with the smallest possible rate, and the "additional" charges appear later. <strong>Is it enough for a rule to require reporting the total cost, or must people also learn to demand it and calculate it? And when the person who needs the loan is in a hurry, how is their decision protected from haste?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:ofertas}}' => $img('comparar-creditos-ofertas', 499, 'Table comparing two offers for a 20 million loan over 36 months: advertised rate 20.0% and 22.5%, total payment, total cost 8,184,053 and 7,361,286, and real rate 27.16% and 23.91%.', 'Two offers: the advertised rate misleads.'),
    '{{img:pasos}}' => $img('comparar-creditos-pasos', 467, 'Five steps to compare loans: ask for the same, write everything down, calculate, ask and decide with the budget.', 'Five steps before choosing.'),
]);

return [
    'comparar-dos-ofertas-de-credito-en-excel-tasa-real-costo-total-comparador' => [
        'slug' => 'compare-two-loan-offers-in-excel-real-rate-total-cost-comparator',
        'title' => 'Comparing Two Loan Offers in Excel: Real Rate, Total Cost and Questions Before Signing (Comparator)',
        'excerpt' => 'The lowest rate is not always the cheapest. An Excel comparator calculates the payment, total cost and the real effective annual rate including insurance and fees, with an amortization table and a question list.',
        'seo_title' => 'Compare Two Loan Offers in Excel: Comparator',
        'seo_description' => 'Compare two loans in Excel: payment, total cost and real rate with insurance and fees, amortization table and questions before signing. Free comparator.',
        'focus_keyword' => 'compare loan offers Excel',
        'cover' => '/assets/img/articulos/comparar-creditos/comparar-creditos-portada-en',
        'cover_alt' => 'Cover "Comparing two loan offers in Excel: the lowest rate is not always the cheapest" with a card: 822,768 pesos more is what the offer with the lowest advertised rate costs, 20.0% versus 22.5%.',
        'content_html' => $html,
    ],
];
