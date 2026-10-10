<?php

declare(strict_types=1);

// English version of "¿Comprar software, pagar una suscripción o desarrollar una aplicación propia? La…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/tco-comprar-suscribir-desarrollar/' . $name . '-en';
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
<p>When a company, school or office needs a new tool (billing, enrollment management, inventory), it almost always compares three things: the <strong>license price</strong>, the <strong>monthly fee</strong> or the <strong>development quote</strong>. It rarely compares what really matters: what that decision will cost over <strong>three years</strong>. That is where support, servers, training, integrations, price increases and the maintenance nobody budgeted for show up.</p>
<p>In this article I compare the three routes with a numeric case, <strong>with every assumption in plain sight</strong>, so you can replace them with your own. It includes a <a href="/descargas/matriz-costes/matriz-costes-3-anos.xlsx">downloadable Excel cost matrix</a>. Regulatory data verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> None of the three options is best in the abstract. In the example (12 users), the subscription and the license end up in a similar range and in-house development costs more than double; but at around 40 users, in-house development becomes the cheapest. What matters is that <strong>the break-even depends on your figures</strong>, and that cost is not the only criterion: vendor dependence, security and the ability to maintain what you build also count.</p>

<h2>The three routes and their hidden costs</h2>
<ul>
<li><strong>Buy a license</strong> (one-off payment, perpetual use): you pay most of it up front, but then come support and updates (usually charged as an annual percentage of the license), the server or machine it runs on, backups and whoever administers it.</li>
<li><strong>Pay a subscription</strong> (SaaS): the initial payment is low and the vendor handles servers and updates; in exchange you pay forever, the price may rise and if you stop paying you lose access. When the vendor is abroad, payment is usually in dollars and you must look at VAT and data protection (below).</li>
<li><strong>Build your own application</strong>: you get exactly what you need and the data and code are yours, but you take on development, hosting, security, support and maintenance that never ends. The cost of building is only the beginning.</li>
</ul>

<h2>The case: 12 users over 3 years</h2>
<p>Suppose an organization with 12 users. These are the assumptions, all <strong>illustrative</strong> (not the prices of any real brand) and editable in the matrix:</p>
<table>
<thead><tr><th>Item</th><th>Buy</th><th>Subscription</th><th>Build</th></tr></thead>
<tbody>
<tr><td><strong>Base price</strong></td><td>US$ 500 per user</td><td>US$ 25 per user per month</td><td>US$ 18,000 to build</td></tr>
<tr><td><strong>Recurring</strong></td><td>Support: 20% of the license per year</td><td>7% annual increase</td><td>Maintenance: 20% of development from year 2</td></tr>
<tr><td><strong>Other costs</strong></td><td>Implementation, training, server and security</td><td>Implementation, training, integrations and administration</td><td>Hosting, security, support and training</td></tr>
</tbody>
</table>
<p>With those assumptions, the three-year total cost is:</p>
<table>
<thead><tr><th>Option</th><th>Year 1</th><th>Year 2</th><th>Year 3</th><th>3-year total</th></tr></thead>
<tbody>
<tr><td><strong>Buy a license</strong></td><td>US$ 11,100</td><td>US$ 2,100</td><td>US$ 2,100</td><td>US$ 15,300</td></tr>
<tr><td><strong>Subscription</strong></td><td>US$ 5,700</td><td>US$ 4,152</td><td>US$ 4,422</td><td>US$ 14,274</td></tr>
<tr><td><strong>Build in-house</strong></td><td>US$ 22,180</td><td>US$ 7,180</td><td>US$ 7,180</td><td>US$ 36,540</td></tr>
</tbody>
</table>
{{img:total}}
<p>Notice three things. First, <strong>the license that is "cheap in the long run" is not that cheap</strong>: 73% of its cost falls in the first year, and years 2 and 3 still cost support, server and administration. Second, <strong>the subscription looks expensive month to month</strong> (US$ 300 a month in year 1) but avoids the initial blow. Third, <strong>in-house development is the most expensive with few users</strong>, because its cost is almost fixed.</p>

<h2>When users change, the answer changes</h2>
<p>Sensitivity with the same assumptions and only the number of users varying (computed in the "Sensibilidad" sheet of the matrix):</p>
<table>
<thead><tr><th>Users</th><th>Buy</th><th>Subscription</th><th>Build</th><th>Cheapest</th></tr></thead>
<tbody>
<tr><td>5</td><td>US$ 9,700</td><td>US$ 7,522</td><td>US$ 36,540</td><td>Subscription</td></tr>
<tr><td>15</td><td>US$ 17,700</td><td>US$ 17,167</td><td>US$ 36,540</td><td>Subscription</td></tr>
<tr><td>25</td><td>US$ 25,700</td><td>US$ 26,812</td><td>US$ 36,540</td><td>Buy</td></tr>
<tr><td>40</td><td>US$ 37,700</td><td>US$ 41,279</td><td>US$ 36,540</td><td>Build</td></tr>
<tr><td>60</td><td>US$ 53,700</td><td>US$ 60,568</td><td>US$ 36,540</td><td>Build</td></tr>
</tbody>
</table>
<p>The break-even points, with these assumptions: the license beats the subscription from about <strong>19 users</strong>, and in-house development beats both from about <strong>36 to 39 users</strong>. But beware: that is only valid <em>if development costs what was budgeted, if it solves the need and if someone maintains it</em>. Software projects often go over budget; that is why the matrix lets you test a development that costs 50% more and see how the break-even moves.</p>
{{img:cuando}}

<h2>What the spreadsheet does not show</h2>
<p>Cost is one criterion; these others can weigh more than a difference of a few thousand dollars:</p>
<ul>
<li><strong>Lock-in.</strong> Can you export your data in an open format if you change vendor? With a subscription, ask this <em>before</em> signing.</li>
<li><strong>Personal data.</strong> If the tool stores data on students, customers or employees on servers outside Colombia, Law 1581 of 2012 (Article 26) in principle prohibits transferring data to countries without an adequate level of protection under the Superintendence of Industry and Commerce standards, with exceptions such as the data subject's authorization. Check where the data is hosted and what clauses the vendor offers.</li>
<li><strong>VAT and currency.</strong> Digital services provided from abroad to consumers in Colombia are subject to 19% VAT (Tax Code), usually borne by the user, and a dollar price exposes you to the exchange rate. Confirm with your accountant; it is not included in the matrix.</li>
<li><strong>Legal software.</strong> Companies must report in their management report the state of compliance with intellectual property and copyright rules (Law 603 of 2000): your licenses should be in order.</li>
<li><strong>Ability to maintain.</strong> An in-house application nobody maintains becomes a risk. The question is not "can we build it?" but "who will look after it in year three?".</li>
</ul>

<h2>A checklist before deciding</h2>
<ol>
<li><strong>Define the process</strong> and how many users will use it today and in three years.</li>
<li><strong>Compute the 3-year cost</strong> of each route with the matrix, including implementation, training and support.</li>
<li><strong>Test the worst case:</strong> a 15% price rise, development costing 50% more, a higher exchange rate.</li>
<li><strong>Ask about the exit:</strong> how you export your data and what happens if the vendor disappears or changes the price.</li>
<li><strong>Review data handling</strong> and VAT with the right person.</li>
<li><strong>Start small:</strong> a pilot with a few users before committing three years.</li>
</ol>
<p>And a question almost always skipped: <strong>is there already a simple tool that solves 80% of the need?</strong> Sometimes a well-made Excel template, with support, avoids paying for features nobody will use (see <a href="/riesgo-oculto-excel-auditoria-control-versiones/">the hidden risk of Excel</a> to know when it is not enough).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, the subscription has become the norm: almost all office and management software is sold as a service. In Colombia and Latin America the model has its own nuance: you pay in dollars with income in pesos, so a devaluation raises the cost without the vendor changing the price, and public procurement and schools must also justify spending to boards and administrators. For <strong>managers</strong>, the question is the sustainability of the expense; for <strong>teachers and users</strong>, that the tool really saves them work (see <a href="/automatizar-excel-power-query-vba-office-scripts-python-comparacion/">how to automate with Excel</a>); for <strong>families</strong>, what happens to their children's data when the school hires a platform (see <a href="/colegio-datos-estudiantes-ia-personalizar-aprendizaje-privacidad/">student data</a>).</p>

<h2>Tools that already exist and you can try</h2>
<p>If your need is billing, sending documents or automating office tasks, you may need none of the three big routes. These Excel templates and applications are bought once, with optional support, and run on your own computer:</p>
{{productos:factura-con-envio-por-correo-al-cliente,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">the cloud is not a backup</a>, <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes in a company</a> and <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a>.</p>

<h2>Frequently asked questions</h2>
<h3>Is buying a license cheaper than paying a subscription?</h3>
<p>It depends on the number of users and the time horizon. In the example, the license only beats the subscription from about 19 users over three years; with few users, the subscription usually costs less.</p>
<h3>How much does it cost to maintain an in-house application?</h3>
<p>A rule of thumb used in the example is 20% of the development cost per year, plus hosting, security and support. It is an illustrative assumption: adjust it with a real quote.</p>
<h3>What is total cost of ownership (TCO)?</h3>
<p>It is the sum of everything a tool costs over a period (purchase, implementation, training, support, infrastructure and administration), not just the purchase price.</p>
<h3>Does a subscription pay VAT in Colombia?</h3>
<p>Digital services provided from abroad to consumers in Colombia are subject to 19% VAT. Confirm with your accountant how it applies to your case.</p>
<h3>How do I avoid being locked in with a vendor?</h3>
<p>Require the ability to export your data in open formats, keep your own copies and negotiate exit and price-increase terms before signing.</p>

<p class="notice"><strong>Do your own calculation.</strong> Download the <a href="/descargas/matriz-costes/matriz-costes-3-anos.xlsx">3-year cost matrix</a>, replace the yellow assumptions with your figures and see which route wins, and at how many users the answer changes.</p>

<h2>Food for thought</h2>
<p>Paying a subscription is renting; buying a license is owning a door someone else keeps locking; building is constructing a house you have to live in and repair. <strong>Is technological autonomy a luxury only large organizations can afford, or an investment small ones should make for sovereignty over their own data, even if it costs more at first? And who should decide: whoever pays, whoever uses it or whoever answers for the data?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:total}}' => $img('tco-comprar-suscribir-desarrollar-total', 392, 'Bars with the total three-year cost in the example case: buying a license US$ 15,300, subscription 14,274 and in-house development 36,540.', 'Total three-year cost in the illustrative 12-user case.'),
    '{{img:cuando}}' => $img('tco-comprar-suscribir-desarrollar-cuando', 444, 'Table summarizing each option\'s main risk and when it wins: the license with many users and stable use, the subscription with few users and no in-house IT, and in-house development when the process is unique.', 'When each option wins.'),
]);

return [
    'comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos' => [
        'slug' => 'buy-software-subscription-or-build-total-cost-3-years',
        'title' => 'Buy Software, Pay a Subscription or Build Your Own App? The Comparison Few Companies Make',
        'excerpt' => 'The real three-year cost of buying a license, subscribing or building your own application, with a numeric case, explicit assumptions, break-even points and an Excel cost matrix.',
        'seo_title' => 'Buy, Subscribe or Build: 3-Year Software Cost',
        'seo_description' => 'Compare the 3-year total cost of buying software, subscribing or building your own app, with a worked case, break-even points and an Excel matrix.',
        'focus_keyword' => 'buy vs build software cost',
        'cover' => '/assets/img/articulos/tco-comprar-suscribir-desarrollar/tco-comprar-suscribir-desarrollar-portada-en',
        'cover_alt' => 'Cover "Buy, subscribe or build your own app? The real cost over 3 years" with a card showing US$ 14,274 for the subscription, 15,300 for the license and 36,540 for in-house development in the example case.',
        'content_html' => $html,
    ],
];
