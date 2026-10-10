<?php

declare(strict_types=1);

// English version of "Las integraciones que fallan en silencio: API, webhooks, reintentos y alertas pa…". Key is the Spanish slug. Status and date come from the Spanish post via en/02_recent_posts.php.
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/integraciones-fallan-silencio/' . $name . '-en';
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
<p>The worst failure in an integration is not the noisy one: it is the one that <strong>does not warn you</strong>. A confirmed payment that never reaches accounting, an enrollment that does not move from a form to the spreadsheet, a report card that is not emailed. Nobody sees an error on screen; the problem shows up weeks later, when a family complains or when the month-end close does not add up.</p>
<p>Today almost everything is connected to everything: the payment gateway to billing, the form to the academic platform, the store to email. Each connection (an API, a webhook, a scheduled file) is a point where information can be lost, duplicated or arrive late. This article explains how to design integrations that <strong>fail visibly</strong>, with a code example I ran, an <a href="/descargas/integraciones/inventario-integraciones.xlsx">integration inventory in Excel</a> (in Spanish) and the <a href="/descargas/integraciones/integracion_resiliente.py">Python demo</a>. Sources verified on October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A reliable integration does five things: it <strong>verifies</strong> where the message comes from, <strong>confirms quickly</strong>, <strong>does not duplicate</strong> even if the message arrives twice, <strong>retries</strong> temporary failures and <strong>alerts a person</strong> when something could not be processed. The rest is inventorying and assigning owners.</p>

<h2>How they fail silently</h2>
<p>Six typical ways, none with a visible error message:</p>
<ul>
<li><strong>The destination was down for a while</strong> and the message was lost, because nobody retried.</li>
<li><strong>The message arrived twice</strong> and two payments or two enrollments were recorded.</li>
<li><strong>Messages arrived in a different order</strong> and a "paid" status was overwritten by an older one.</li>
<li><strong>A field changed in the provider's API</strong> and the integration keeps "working", but with empty data.</li>
<li><strong>A credential or certificate expired</strong> and from that day everything fails without warning.</li>
<li><strong>Whoever built it left</strong> and nobody knows it exists.</li>
</ul>

<h2>What a serious provider already warns you about</h2>
<p>Stripe's webhook documentation, which I cite as an example of good practice (other providers have their own rules), says several things that apply to almost any integration: in live mode it retries delivery <strong>for up to three days with exponential backoff</strong>; <strong>the same event may arrive more than once</strong> and it recommends logging the IDs of events already processed; it <strong>does not guarantee delivery order</strong>; the endpoint must <strong>return 2xx quickly, before heavy logic</strong>, and process in a queue; and you must <strong>verify the signature</strong> of every message to avoid fake events.</p>
{{img:stripe}}
<p>In plain terms: if your system depends on a message arriving only once, in order and without failures, it is badly designed, no matter who the provider is.</p>

<h2>The flow in five steps</h2>
{{img:flujo}}
<ol>
<li><strong>Verify.</strong> Check the signature, shared secret or origin before acting. Without this, anyone could send a fake "payment confirmed".</li>
<li><strong>Save and confirm.</strong> Record the event and return 2xx immediately; if you do the heavy work before responding, the provider may consider the delivery failed and resend it.</li>
<li><strong>Process without duplicating (idempotency).</strong> Use the event identifier: if you have seen it, do not apply it again.</li>
<li><strong>Retry what is temporary.</strong> With growing waits and a bit of randomness, so you do not hit the destination all at once. Do not retry permanent errors (an order that does not exist will not exist tomorrow).</li>
<li><strong>Alert and keep what failed.</strong> What could not be processed goes to a queue and alerts a named person.</li>
</ol>

<h2>An executed example</h2>
<p>I wrote a demo of about 90 lines in Python (standard library only) that simulates a provider sending six events: two repeated, one with a temporary accounting-system failure and one with a permanent error. These are the key parts:</p>
<pre><code>def recibir(evento):
    """Punto de entrada del webhook: idempotente."""
    try:
        db.execute("INSERT INTO procesados VALUES (?,?)", (evento["id"], time.time()))
    except sqlite3.IntegrityError:
        print(f"{evento['id']}: duplicado, se ignora (ya procesado)")
        return
    con_reintentos(evento)

def con_reintentos(evento, maximo=4, base=0.01):
    for n in range(1, maximo + 1):
        try:
            aplicar_pago(evento)
            return True
        except ConnectionError as e:          # temporal: reintentar
            espera = base * (2 ** (n - 1)) + random.uniform(0, base)
            time.sleep(espera)
        except ValueError as e:               # permanente: a la cola y alertar
            db.execute("INSERT INTO fallidos VALUES (?,?,?)", (evento["id"], str(e), n))
            alertar(f"evento {evento['id']} a cola de fallidos: {e}")
            return False
    alertar(f"evento {evento['id']} agotó {maximo} intentos")
    return False</code></pre>
<p>And this is the real output when running it:</p>
<pre><code>evt_1: nuevo, se procesa
evt_2: nuevo, se procesa
evt_1: duplicado, se ignora (ya procesado)
evt_3: nuevo, se procesa
  intento 1 falló (el sistema contable no respondió); espero 0.013 s
  intento 2 falló (el sistema contable no respondió); espero 0.022 s
evt_2: duplicado, se ignora (ya procesado)
evt_5: nuevo, se procesa
  ALERTA: evento evt_5 a cola de fallidos: pedido inexistente en el sistema (error permanente)

Pagos aplicados: (3, 250000)
Eventos fallidos: [('evt_5', 'pedido inexistente en el sistema (error permanente)')]
Alertas enviadas: 1</code></pre>
<p>The two repeated events were ignored; the one that failed twice temporarily was applied on the third attempt (the 3 payments add up to 250,000, not 450,000); and the permanent error ended in the failed queue with an alert. An honest caveat: <strong>this demo marks the event as processed on receipt</strong>, so idempotency is clearly visible. In production it is better to store a state per event (received, processed, failed) and mark it "processed" only when the work finishes, so you do not lose an event that failed halfway.</p>

<h2>Inventory your integrations</h2>
<p>Before improving the code, make a list. The downloadable workbook has an inventory with columns for the owner, whether there is an alert, whether it retries, whether it avoids duplicates, whether it verifies the origin and the date of the last review; it computes a risk per integration. With the sample data, <strong>3 of the 6 integrations end up high risk</strong>: one with no alert or retries, one with no controls at all and one with no owner. The "Plan_de_falla" sheet has nine questions for each critical integration, such as "how long would it take us to find out?" and "how do we reprocess what was lost?".</p>
<p>One detail: the days-since-review column uses today's date, so the risk changes over time; that is intentional, so an integration nobody reviews rises in risk by itself.</p>

<h2>What to monitor</h2>
<table>
<thead><tr><th>Signal</th><th>What it indicates</th><th>Action</th></tr></thead>
<tbody>
<tr><td><strong>Events received per day</strong></td><td>If it drops to zero or spikes, something changed</td><td>Alert on deviation from the average</td></tr>
<tr><td><strong>Events in the failed queue</strong></td><td>Work nobody has handled</td><td>Daily review and an owner</td></tr>
<tr><td><strong>Time since the last event</strong></td><td>A "mute" integration</td><td>Alert if it exceeds what is expected</td></tr>
<tr><td><strong>Credential expiry</strong></td><td>An announced outage</td><td>Renewal calendar</td></tr>
<tr><td><strong>Daily reconciliation</strong></td><td>Differences between source and destination</td><td>Compare totals on both sides</td></tr>
</tbody>
</table>
<p>Reconciliation is the final safety net: even if everything above fails, comparing every day the gateway's payment total with accounting's tells you whether something was lost (see the article on <a href="/riesgo-oculto-excel-auditoria-control-versiones/">controls in Excel</a> to do it with a formula).</p>

<h2>Colombia, Latin America and the world</h2>
<p>Worldwide, integrations between cloud services have become the backbone of almost any operation. In Colombia and Latin America the risk is worse for two common reasons: many integrations were built by an outside vendor or by someone who is no longer around, and there is no budget for monitoring, so failures are discovered when a customer complains. In a school, the failing integration is a report card that does not arrive, an enrollment that is not reflected or a charge that is not applied. For <strong>principals</strong>, the question is who answers for each integration; for <strong>administrative staff and teachers</strong>, having a manual fallback procedure; and for <strong>families</strong>, that a technical error does not become an improper charge or lost data (see <a href="/errores-basicos-seguridad-empresa-lista-comprobacion/">basic security mistakes</a> and <a href="/agentes-ia-acceso-sistemas-automatizacion-riesgo-seguridad/">AI agents with access to your systems</a>, which also connect systems to each other).</p>

<h2>Tools to start in an orderly way</h2>
<p>If your need is to invoice and email documents to customers without building a complex integration, this Excel template handles the whole process on your own computer. And if your school handles students' sensitive documents, <a href="/herramientas/piar/">PIAR con IA</a> keeps them in an account with controlled access, instead of moving them between emails and spreadsheets.</p>
{{productos:factura-con-envio-por-correo-al-cliente,soporte-plus-para-las-plantillas-de-excel}}
<p>Keep reading: <a href="/comprar-software-suscripcion-desarrollo-propio-costo-total-3-anos/">buy, subscribe or build</a>, <a href="/cuando-excel-deja-de-ser-solucion-siete-senales-necesitas-base-de-datos/">when Excel stops being the solution</a> and <a href="/archivos-en-la-nube-no-es-respaldo-siete-mitos-datos/">the cloud is not a backup</a>.</p>

<h2>Frequently asked questions</h2>
<h3>What is a webhook?</h3>
<p>It is a notice a service automatically sends to an address of yours when something happens (for example, a confirmed payment), instead of your system asking over and over.</p>
<h3>What does it mean for an operation to be idempotent?</h3>
<p>That repeating it does not change the result: applying the same event twice leaves the system the same as applying it once. It is achieved, for example, by recording the identifier of each processed event.</p>
<h3>How many times should I retry?</h3>
<p>It depends on the case; in the demo it is 4 attempts with growing waits. What matters is that temporary errors are retried, permanent ones are not, and exhausting the attempts triggers an alert.</p>
<h3>How do I know an integration stopped working?</h3>
<p>With inactivity alerts (time without events), a failed queue reviewed daily and a periodic reconciliation of totals between source and destination.</p>
<h3>Do I need to program for this?</h3>
<p>For the code, yes or with technical help; but the inventory, the owners and the failure plan require no programming, and they are what prevents the most surprises.</p>

<p class="notice"><strong>This week:</strong> download the <a href="/descargas/integraciones/inventario-integraciones.xlsx">integration inventory</a> (in Spanish), list yours, assign an owner to each and answer the "Plan_de_falla" sheet for the critical ones. If you want to see the defenses in code, run the <a href="/descargas/integraciones/integracion_resiliente.py">Python demo</a>.</p>

<h2>Food for thought</h2>
<p>An integration that works 99% of the time and fails silently the other 1% can be worse than one that fails loudly, because nobody knows they must fix it. <strong>Is it acceptable for a school or a company to depend on connections nobody watches, when payments, grades or people's data depend on them? And when a silent failure harms someone (a duplicated charge, a lost enrollment), who answers: whoever programmed the integration, whoever hired it or whoever was supposed to watch it?</strong></p>
HTML;

$html = $code($html);
$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:stripe}}' => $img('integraciones-fallan-silencio-stripe', 573, 'Four cards with what Stripe\'s webhook documentation says: retries for three days with exponential backoff, possible duplicate events, no guaranteed order and a fast 2xx response.', 'What a serious provider\'s documentation warns about.'),
    '{{img:flujo}}' => $img('integraciones-fallan-silencio-flujo', 467, 'Five steps so an integration does not fail silently: verify, save and confirm, process without duplicating, retry and alert.', 'The flow in five steps.'),
]);

return [
    'integraciones-fallan-en-silencio-api-webhooks-reintentos-alertas' => [
        'slug' => 'integrations-that-fail-silently-api-webhooks-retries-alerts',
        'title' => 'Integrations That Fail Silently: APIs, Webhooks, Retries and Alerts So a Payment or Enrollment Is Not Lost',
        'excerpt' => 'Six ways an integration fails without warning, five steps to prevent it, an executed Python demo (idempotency, retries and alerts) and an Excel integration inventory.',
        'seo_title' => 'Silent Integration Failures: Webhooks, Retries, Alerts',
        'seo_description' => 'How to stop an integration from failing silently: verification, idempotency, retries, alerts and a downloadable inventory with a Python demo.',
        'focus_keyword' => 'webhook retries idempotency',
        'cover' => '/assets/img/articulos/integraciones-fallan-silencio/integraciones-fallan-silencio-portada-en',
        'cover_alt' => 'Cover "Integrations that fail silently: APIs, webhooks, retries and alerts" with a card: 3 of 6 integrations in the example are high risk, a repeated event must not duplicate a payment and a permanent error alerts a person.',
        'content_html' => $html,
    ],
];
