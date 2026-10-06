<?php

declare(strict_types=1);

// English versions of the payment gateway articles. Keys are the Spanish slugs.
return [
    'mercado-pago-pagos-rechazados-montos-altos' => [
        'slug' => 'mercado-pago-rejects-large-payments',
        'title' => 'Mercado Pago rejects large payments: my experience and what you should know before selling',
        'excerpt' => 'Payments of 600, 1,000 and 5,000 dollars rejected “for your security,” a suspicious-site warning shown to my customers, and support asking the buyer to open an account. Here’s what happened, why it happens, and when Mercado Pago does make sense for you.',
        'seo_title' => 'Mercado Pago rejects large payments: my real experience',
        'seo_description' => 'Mercado Pago rejected my payments of 600 to 5,000 dollars. What support said, why it happens and when this gateway does make sense for your online store.',
        'focus_keyword' => 'Mercado Pago rejects large payments',
        'cover' => '/assets/img/articulos/mercado-pago/mercado-pago-pagos-rechazados-en',
        'cover_alt' => 'Transactions panel with three charges of 600, 1,000 and 5,000 dollars marked as rejected',
        'content_html' => <<<'HTML'
<p>If you’re thinking about using <strong>Mercado Pago</strong> to take payments in your online store, this article is for you. It’s not a cheap shot or a sponsored review: it’s what happened to me when I tried to charge large amounts for software and services, what support told me, why I think it happens, and in which cases Mercado Pago can still be a good choice. At the end you’ll find a checklist so you don’t get the same surprises.</p>
<p>I’m writing it with the same intention I had a while ago when I shared <a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">everything you should know about Wompi Bancolombia</a> (in Spanish), the payment gateway of Colombia’s Bancolombia bank: so that anyone who is starting to sell online knows what to expect before putting their business—and their customers’ trust—in the hands of a payment gateway. And if you sell software to other countries, also read about my experience with <a href="/paddle-cuenta-cerrada-verificacion-dominio-software-ia/">Paddle, which ended up closing my account</a>.</p>

<h2>Why Mercado Pago looks like the obvious choice</h2>
<p>I completely understand why so many people start with Mercado Pago. I did too. On paper, it has very strong arguments:</p>
<ul>
<li><strong>Presence across Latin America.</strong> It operates in several countries in the region (Argentina, Brazil, Chile, Colombia, Mexico, Peru and Uruguay, among others), so the same brand works if you sell in more than one market.</li>
<li><strong>A brand the buyer already knows.</strong> Mercado Libre, Latin America’s big online marketplace, is behind it, and that makes many customers feel safe.</li>
<li><strong>Lots of local payment methods.</strong> Credit and debit cards and, depending on the country, bank transfers such as PSE in Colombia (the country’s online bank-transfer system) or cash payments at physical locations.</li>
<li><strong>Integration almost anywhere.</strong> It works with the most widely used e-commerce platforms and with many SaaS tools for invoicing, scheduling or memberships, plus payment links and QR codes that don’t require you to have a store.</li>
<li><strong>Opening an account is fast.</strong> In a few minutes you can have a working payment link.</li>
</ul>
<p>With all that, the conclusion seems simple: “I open the account, connect my site and start charging.” For many businesses, that’s exactly how it goes. For mine, it wasn’t.</p>

<h2>What happened to me: three charges, three rejections</h2>
<p>My business isn’t a T-shirt shop. Besides low-cost templates and tools, I sell <strong>software licenses, implementations and custom projects</strong> to schools and companies. That means some charges are 600 dollars, others 1,000, and some reach 5,000 dollars.</p>
<p>I created the account, set up payments and started receiving them. The small ones went through without a problem. But when the large charges came in, <strong>every single transaction was rejected</strong>. Not one: all of them. Different customers, different cards, different amounts, same result.</p>

<h3>First call: “you have to wait for the algorithm”</h3>
<p>I called customer service. The explanation was that the account had to wait for their <strong>heuristic algorithm</strong> to determine that payments could be made for those amounts. I asked whether there was a limit or a policy for large amounts, and they told me they <strong>have no policy at all on large amounts</strong>. In other words: there’s no cap I can know about, no requirement I can meet, and no date when that will change. Just wait.</p>

<h3>Second attempt: the message my customer saw</h3>
<p>Another customer came along, tried to pay me and, once again: rejected. This is where what I consider the most serious part of the whole experience came up, because there are two different messages for the same payment:</p>
<ul>
<li><strong>To me</strong>, in the dashboard, the payment showed as rejected <em>“for your security,”</em> as if they were protecting me from something.</li>
<li><strong>My customer</strong> was told the payment was being rejected because of a <strong>suspected fraudulent site</strong>.</li>
</ul>
<p>Think about what that means. A customer who has already decided to buy from you, who trusted you enough to take out their card, gets a warning from a company with Mercado Pago’s reputation that <strong>your business might be a fraud</strong>. No apology repairs that damage: many customers never try again, and some talk about it.</p>
<p>And on the other side, I wasn’t told the whole truth. “For your security” is not the same as “your business was flagged as possible fraud.” If the system suspects me, I want to know, so I can clear it up. Having different information on each side of the transaction is, quite simply, a lack of transparency.</p>

<h3>Third attempt and support’s “solution”</h3>
<p>I tried again with another payment and it was rejected again. On the next call, the answer was even harder to accept: for payments of that size to go through, <strong>the end customer must create a Mercado Pago account</strong> and link their credit or debit card to it. The goal, as they explained it, is for them to be able to verify that the card really belongs to the person paying.</p>
<p>I understand the intention of preventing fraud. What I can’t understand is that, with all the progress e-commerce has made, the way out is to <strong>force my customer to sign up on a platform they didn’t choose</strong> and where they may not want to have an account. Today there are mechanisms like 3-D Secure authentication, where the customer’s bank confirms the purchase with a notification or a code, without asking them to open accounts anywhere.</p>

<h3>Afterwards: verifying my “honesty”</h3>
<p>In the end, I didn’t get any positive answer. What did arrive was an email in which, in practice, they asked me to <strong>prove my honesty</strong>. The questions weren’t only about me or my business, but about third parties:</p>
<ul>
<li>what kind of relationship I have with a certain customer;</li>
<li>when, where and to whom I delivered the software I’m supposedly selling or have already sold.</li>
</ul>
<p>Besides how uncomfortable it is, there are deeper questions: how do they get that information about my customers? Why does the merchant have to expose third-party data in order to be allowed to get paid? And above all, how do you “deliver” software that is downloaded or installed remotely? With digital products there’s no shipping tracking number and no signed delivery receipt. For a business like mine, that kind of verification is a dead end.</p>

<h2>Why this happens (and why it’s not just bad luck)</h2>
<p>To be fair, it’s worth understanding the logic behind what I went through. I don’t agree with it, but it helps you make better decisions.</p>

<h3>Mercado Pago is an aggregator, not your bank</h3>
<p>When you charge with Mercado Pago, you don’t have your own merchant account with the card networks: you charge <strong>through Mercado Pago’s account</strong>. They take on the risk of chargebacks (when a customer disputes a purchase and the bank gives them their money back). That’s why their anti-fraud system is designed to protect <strong>Mercado Pago</strong> first. If a transaction looks risky, the cheapest way for them to protect themselves is to reject it, even if that costs the seller a sale.</p>

<h3>New account + large amount + digital product = maximum alert</h3>
<p>The risk models of this kind of platform usually look at signals like these:</p>
<ul>
<li><strong>Account history.</strong> A newly created account has no previous sales to show that it’s trustworthy.</li>
<li><strong>Amount versus average.</strong> If your first charges are a few dollars and suddenly one for 5,000 shows up, the jump looks anomalous.</li>
<li><strong>Product type.</strong> Digital goods are delivered instantly and have no shipment to track, which is why they’re a favorite for testing stolen cards.</li>
<li><strong>Buyer data.</strong> The less information the gateway receives about who is paying and what they’re buying, the harder it is for it to approve the payment.</li>
</ul>
<p>My case had every one of those signals at once. The problem is that <strong>nobody warns you about this when you open the account</strong>, and by the time you find out, some customers have already seen the fraudulent-site message.</p>

<h3>The system is built for two kinds of businesses</h3>
<p>After this experience, my conclusion is that Mercado Pago works very well at two extremes:</p>
<ul>
<li><strong>Large companies</strong>, with volume, history and a direct business relationship that lets them negotiate terms.</li>
<li><strong>Small businesses that charge small amounts</strong>: shops, small ventures, inexpensive courses, low-value products.</li>
</ul>
<p>In the middle are those of us—independent professionals and small companies—who make <strong>a few high-value transactions</strong>: consulting, software, implementations, corporate training. For that profile, the system behaves as if every large sale were suspicious.</p>

<h2>What Mercado Pago does well</h2>
<p>It’s not all negative, and it would be dishonest to say otherwise. If your business fits these cases, Mercado Pago can be an excellent option:</p>
<ul>
<li><strong>Small, frequent charges.</strong> Templates, low-cost courses, inexpensive subscriptions, physical products of moderate value. On my own site, the small charges went through without a problem.</li>
<li><strong>Several countries with a single integration.</strong> If you sell in different Latin American markets, sticking to one gateway makes operations much simpler.</li>
<li><strong>It connects to many platforms.</strong> It has ready-made integrations for online stores and SaaS tools, and if you don’t have a website you can charge with payment links or QR codes.</li>
<li><strong>Local payment methods.</strong> Your customers can pay with what they already use, without needing an international card.</li>
<li><strong>Trust from the average buyer.</strong> For the end customer, seeing the Mercado Pago logo is usually reassuring… as long as the payment isn’t rejected.</li>
</ul>

<h2>Pros and cons, side by side</h2>
<table>
<thead><tr><th>Aspect</th><th>Pros</th><th>Cons</th></tr></thead>
<tbody>
<tr><td>Small amounts</td><td>Smooth, fast approval.</td><td>—</td></tr>
<tr><td>Large amounts (hundreds or thousands of dollars)</td><td>—</td><td>Rejections with no known limit, especially on new accounts.</td></tr>
<tr><td>Coverage</td><td>Several Latin American countries.</td><td>Terms vary by country.</td></tr>
<tr><td>Integrations</td><td>E-commerce platforms, SaaS, payment links and QR codes.</td><td>Integration doesn’t prevent anti-fraud rejections.</td></tr>
<tr><td>Rejection messages</td><td>—</td><td>The seller sees “for your security”; the buyer sees suspected fraud.</td></tr>
<tr><td>Support</td><td>Easy to contact.</td><td>Generic answers, with no concrete solution for large amounts.</td></tr>
<tr><td>Verification</td><td>Aims to prevent fraud.</td><td>May ask you for information about your customers and about how you deliver digital products.</td></tr>
</tbody>
</table>

<h2>If you already have an account: how to reduce rejections</h2>
<p>If Mercado Pago is already your gateway, or you need it for its reach, these measures help give the anti-fraud system more information and fewer reasons to reject. They don’t work miracles with very large amounts, but they improve the approval rate:</p>
<ol>
<li><strong>Start with small amounts and build a history.</strong> A few weeks of small sales, with no chargebacks, give the account “normal” behavior before you charge large amounts.</li>
<li><strong>Send all the buyer and order data.</strong> The buyer’s full name, email, ID number and phone number, and a clear description of each product. If a developer integrated the gateway for you, ask them to review the payment approval guide in Mercado Pago’s developer documentation.</li>
<li><strong>Use a recognizable business name on the card statement.</strong> If customers see a name they don’t recognize on their card statement, disputed purchases go up, and with them the risk to your account.</li>
<li><strong>Keep your business compliant and documented.</strong> Electronic invoicing, terms and conditions, a refund policy and contact details visible on your site. If they ask for verification, you’ll have something to answer with.</li>
<li><strong>Keep evidence of every digital delivery.</strong> Emails with download links, download logs, installation or training sign-off records. For digital products, that’s your “shipping tracking number.”</li>
<li><strong>Give the customer a heads-up before a large charge.</strong> Explain that their bank or the gateway might ask them for additional verification, so they don’t panic if something fails.</li>
</ol>

<h2>Alternatives for charging large amounts</h2>
<p>What worked for me was <strong>splitting charges by size</strong>. For small sales in the store, an online gateway is practical. For large charges, which usually come from companies or institutions, a more direct channel is better:</p>
<ul>
<li><strong>Bank transfer or PSE to a business bank account</strong>, with an electronic invoice. That’s what many companies prefer for large payments, because it gives them complete accounting records.</li>
<li><strong>Payment in installments or milestones.</strong> Splitting a 5,000-dollar project into a deposit and progress payments reduces the amount of each transaction and the risk for both parties.</li>
<li><strong>Gateways with your own merchant account</strong>, or through your bank, if your volume justifies it. Before choosing any provider, ask in writing what the maximum amount per transaction and per day is, how long it takes to activate the account, and what the buyer sees when a payment is rejected. No gateway is perfect: I’ve also written about my problems with <a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">Wompi’s limits</a> (in Spanish) and with <a href="/paddle-cuenta-cerrada-verificacion-dominio-software-ia/">Paddle’s policies for software</a>.</li>
</ul>

<h2>Checklist before opening your account</h2>
<ul>
<li>What’s the typical value of your sales? If it’s more than a few hundred dollars, first test with a real charge for that amount.</li>
<li>Do you sell digital products or services? Get your proof of delivery ready from the start.</li>
<li>Are your customers companies? Many pay with corporate cards or prefer a bank transfer with an invoice; offer them that option.</li>
<li>What will your customer see if the payment is rejected? Ask support for the exact wording before launching.</li>
<li>Do you have a plan B? Always have a second payment method visible, so you don’t lose the sale if the first one fails.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does Mercado Pago have a per-transaction limit?</h3>
<p>According to what support told me, there’s no public policy on maximum amounts: approval depends on their anti-fraud system, which evaluates each payment. In practice, on a new account, charges of several hundred or several thousand dollars were systematically rejected.</p>
<h3>Why does Mercado Pago reject a payment “for your security”?</h3>
<p>It’s the message that appears when their fraud prevention system considers the transaction risky. Factors include the account’s history, the amount compared with your usual sales, the type of product and the information available about the buyer.</p>
<h3>Does my customer have to create a Mercado Pago account to pay me?</h3>
<p>Not for regular payments. In my case, for large amounts, support said the customer had to create an account and link their card so they could verify that they were the cardholder. It’s a requirement many customers won’t accept.</p>
<h3>Is Mercado Pago good for selling digital products?</h3>
<p>Yes, especially if they’re low-value. For expensive digital products, the risk of rejection is higher, because there’s no physical shipment to track. It’s a good idea to have an alternative such as a bank transfer with an invoice.</p>
<h3>What should I do if a customer saw the fraudulent-site message?</h3>
<p>Contact them right away, explain that the rejection was triggered by the gateway’s anti-fraud system and not by a problem with your business, and offer them another payment method with an invoice. The sooner you clear it up, the easier it is to keep both the sale and their trust.</p>

<h2>Conclusion</h2>
<p>Mercado Pago is a powerful tool for charging small amounts across Latin America, with lots of integrations and local payment methods. But if your business lives on a few high-value sales, especially of software or digital services, you should know from the outset that you may run into unexplained rejections, messages that make your business look suspicious, and a support team with no real solution.</p>
<p>My recommendation is simple: <strong>don’t put all your payments through a single gateway</strong>. Use it for what it does well, have a direct channel for large payments, and test with a real charge before announcing your store. And if you’ve been through something similar, share it: the more merchants share these experiences, the more pressure there will be on gateways to be transparent with those of us who bring them business.</p>
HTML,
    ],
    'paddle-cuenta-cerrada-verificacion-dominio-software-ia' => [
        'slug' => 'paddle-account-closed-domain-verification-ai-software',
        'title' => 'Paddle closed my account: what you should know before selling software from Latin America',
        'excerpt' => 'Strict domain verification, a ban on AI software and on services, everything in English, few payment methods for Latin America, almost no support, permanent account closure, and withdrawals by international wire transfer with bank fees. My full experience with Paddle.',
        'seo_title' => 'Paddle closed my account: my experience from Latin America',
        'seo_description' => 'Paddle closed my account after a domain validation: AI and services banned, English only, few payment methods for Latin America and costly withdrawals.',
        'focus_keyword' => 'Paddle',
        'cover' => '/assets/img/articulos/paddle/paddle-cuenta-cerrada-en',
        'cover_alt' => 'Account status panel with two domains rejected in verification and the account closed',
        'content_html' => <<<'HTML'
<p>If you sell software from Colombia or any other Latin American country and someone recommended <strong>Paddle</strong> to you as the solution for getting paid worldwide, read this before you create your account. Just as I did with <a href="/mercado-pago-pagos-rechazados-montos-altos/">Mercado Pago, which rejected my large payments</a>, and with <a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">Wompi, Bancolombia’s payment gateway, and its limits</a> (in Spanish), here I’ll tell you what I went through with Paddle, why I think it happens, what it does well and what you should ask before investing time in integrating it.</p>
<p>This isn’t a sponsored review or a cheap shot. It’s the experience of someone who creates educational software, tried to use Paddle to sell it and ended up with the account permanently closed, without a concrete explanation and with no possibility of trying again.</p>

<h2>Why Paddle seems like the perfect option for selling software</h2>
<p>Paddle isn’t a traditional payment gateway. It works as a <strong>“Merchant of Record”</strong>: technically, Paddle sells your product to the customer and then pays you. For an independent developer, that sounds great:</p>
<ul>
<li><strong>It handles international taxes.</strong> It calculates and files taxes such as European VAT or sales taxes in other countries, something very hard to manage on your own.</li>
<li><strong>Subscriptions, licenses and invoices</strong> taken care of for software products.</li>
<li><strong>Payments in multiple currencies</strong> with a single integration.</li>
<li><strong>Good technical documentation</strong> and a sign-up process that invites you to get started in minutes.</li>
</ul>
<p>On paper, it’s exactly what someone selling software to customers in several countries needs. In practice, for a Latin American seller, the road is full of conditions you don’t see at first.</p>

<h2>What happened to me with Paddle</h2>

<h3>Creating the account is easy; getting approved isn’t</h3>
<p>Sign-up is friendly and quick. You set up products and prices and start integrating the checkout. What isn’t clear at that point is that having the account <strong>doesn’t mean you can sell</strong>. Before you collect your first peso, you have to go through a fairly rigorous verification process for the account and for each website, and everything else depends on that process.</p>

<h3>Domain verification: each site separately</h3>
<p>With Paddle, verifying your company isn’t enough. <strong>Each domain you want to sell from has to be validated separately</strong>, and the sites must meet certain information requirements to be approved. Broadly speaking, they check that the site clearly shows:</p>
<ul>
<li>the software product you sell and what it does;</li>
<li>the prices;</li>
<li>terms and conditions, a refund policy and a privacy policy;</li>
<li>the business name and contact details, consistent with those on the account.</li>
</ul>
<p>And, on top of that, that what’s sold on that domain fits their policies. If the domain doesn’t pass, it isn’t approved for the payment gateway or for the integration, even if the account exists. If you have several products on different domains, you multiply the uncertainty by each one.</p>

<h3>They don’t allow selling software that uses artificial intelligence</h3>
<p>My software includes <strong>artificial intelligence</strong>, as almost any educational or productivity tool does today. For Paddle, that was a problem: according to their policies, that kind of software can’t be sold through them. In the middle of the AI era, running into this restriction after having done the integration is disconcerting, to say the least. And it’s not something they warn you about when they invite you to create an account.</p>

<h3>They don’t allow charging for services either</h3>
<p>Paddle <strong>doesn’t accept services</strong> being charged through its platform. If, in addition to your licenses, you offer implementation, training, personalized support, consulting or custom development, you can’t charge for that with them. Their model is built for standardized software and SaaS companies. In Latin America, where many of us sell software together with hands-on support—especially in education—that rule leaves a good part of the business with no way to get paid.</p>

<h3>Everything in English and almost no support</h3>
<p>The dashboard, the documentation, the emails, the policies and the support are <strong>only in English</strong>. For many Latin American entrepreneurs that’s already a barrier, and when what’s at stake is how a policy should be interpreted, the barrier becomes huge.</p>
<p>But the hardest part was support. <strong>There’s no way to talk directly to a person</strong> who will review your case with you. In my experience, replies came practically only when it was to deny something: a domain not approved, a request rejected. When I asked for guidance on what to change, there was no one to talk to.</p>

<h3>I tried to validate a domain that mattered to me… and they closed my account</h3>
<p>I had a domain with certain information that, for my business, was important to validate. It didn’t comply with their policies, so I did what any good-faith merchant would do: I adjusted the site and resubmitted it for review. And again. With no clear explanation of what was wrong, each attempt was made almost blindly.</p>
<p>The final answer was an email saying that <strong>they could not continue with my account or provide me with the service</strong>, because I had tried too many times to validate that domain. There were no concrete reasons and no review with anyone: just a flat rejection. And they were adamant about something else: that I <strong>should not try again</strong>, because the account has no way of being validated again, <strong>not even by creating a new account</strong>.</p>
<p>Think about the logic: the system rejects you, doesn’t tell you precisely what to fix, there’s no one to talk to, and when you try to comply, your attempts become the reason to shut the door on you forever.</p>

<h2>Getting paid isn’t the same as receiving the money</h2>
<p>Let’s assume your account does get approved. There’s another aspect few people mention when they recommend Paddle from Latin America: <strong>how the money gets to your account in Colombia</strong>.</p>

<h3>Few payment methods for your Latin American customers</h3>
<p>Paddle’s checkout is designed mainly for buyers in the United States and Europe: international cards and some digital wallets that are popular there. For a Latin American customer, the options are limited. You won’t find local methods like <strong>PSE, Nequi, Daviplata or cash payments</strong> (PSE is Colombia’s online bank-transfer system; Nequi and Daviplata are Colombian mobile wallets), which are precisely the ones many buyers in the region use every day. If your audience is in Latin America, a significant share of your customers simply won’t be able to pay you.</p>

<h3>Withdrawals: international wire transfers and their costs</h3>
<p>To get your funds out of the platform, the route is an <strong>international wire transfer</strong> or another withdrawal method available for your country. And this is where the deductions you don’t see on Paddle’s pricing page begin:</p>
<ul>
<li><strong>Your Colombian bank’s fee</strong> for receiving a transfer from abroad, which is usually charged on every transfer.</li>
<li><strong>Intermediary or correspondent banks</strong> that may deduct their own fee before the money arrives.</li>
<li><strong>The exchange rate</strong>: the bank converts the dollars to pesos at its own rate, which is usually less favorable than the official one.</li>
<li><strong>The “4 por mil” (GMF)</strong>, Colombia’s 0.4% tax on financial transactions, when you move the money, plus the foreign-exchange paperwork your bank may ask for to support the incoming foreign currency.</li>
</ul>
<p>Add Paddle’s fee on each sale, and the result is that <strong>you receive considerably less of every dollar you sell</strong>, and on small sales the fixed wire fee can eat up a good part of the income. Before deciding, ask your bank how much it charges to receive an international transfer and run the numbers with your real prices.</p>

<h2>Why Paddle works this way</h2>
<p>As with Mercado Pago, understanding the logic helps you decide better, even if it doesn’t justify how they go about it.</p>
<ul>
<li><strong>As Merchant of Record, the risk is theirs.</strong> Paddle sells your product in its own name, so it answers to customers, banks and tax authorities for everything you sell. That’s why it filters much more than a regular gateway.</li>
<li><strong>Services are hard to verify.</strong> A software license is delivered the same way to everyone; a service depends on people, timelines and agreements, and generates more complaints and chargebacks.</li>
<li><strong>AI is still uncertain territory</strong> when it comes to copyright, generated content and privacy, and some platforms prefer to exclude it rather than evaluate each case.</li>
<li><strong>Their main market isn’t Latin America.</strong> That explains the language, the payment methods and the type of support.</li>
<li><strong>Repeated attempts are read as risk.</strong> To an automated system, many submissions of the same domain look like someone trying to “sneak in,” not a merchant trying to comply.</li>
</ul>
<p>All of that is understandable from their side. What isn’t: that these conditions aren’t clearly presented before you invest time, that there’s no one to talk to, and that trying to comply ends in a permanent closure.</p>

<h2>What Paddle does well</h2>
<p>It would be unfair not to acknowledge it. Paddle can be a great option if:</p>
<ul>
<li>you have a <strong>SaaS company</strong> that sells standardized software, with no services and no AI features that clash with their policy;</li>
<li>your customers are mainly in the <strong>United States and Europe</strong> and pay by card;</li>
<li>you want someone else to take care of <strong>international taxes</strong>;</li>
<li>your team works comfortably in <strong>English</strong> and your site meets every verification requirement from day one.</li>
</ul>

<h2>Pros and cons, side by side</h2>
<table>
<thead><tr><th>Aspect</th><th>Pros</th><th>Cons</th></tr></thead>
<tbody>
<tr><td>International taxes</td><td>Paddle calculates and files them.</td><td>—</td></tr>
<tr><td>Verification</td><td>Aims to prevent fraud.</td><td>Rigorous, done per domain, with requirements that aren’t very explicit.</td></tr>
<tr><td>Product type</td><td>Standardized software and SaaS.</td><td>Doesn’t allow AI software or services.</td></tr>
<tr><td>Language</td><td>—</td><td>Dashboard, policies and support in English only.</td></tr>
<tr><td>Support</td><td>—</td><td>Almost nonexistent; no direct contact; replies mostly to say no.</td></tr>
<tr><td>Payment methods</td><td>Cards and wallets popular in the US and Europe.</td><td>No local Latin American methods (PSE, Nequi, cash).</td></tr>
<tr><td>Withdrawals</td><td>Pays out to bank accounts abroad.</td><td>International wire transfer with bank fees, intermediaries and exchange rate.</td></tr>
<tr><td>Account closure</td><td>—</td><td>Permanent, with no reasons given and no option to create another account.</td></tr>
</tbody>
</table>

<h2>Three gateways, three different problems</h2>
<p>After Wompi, Mercado Pago and Paddle, my conclusion is that there’s no universal payment gateway. Each one is designed for a certain type of business, and if yours doesn’t fit, you find out the hard way.</p>
<table>
<thead><tr><th>Gateway</th><th>Who it works well for</th><th>Where it failed me</th></tr></thead>
<tbody>
<tr><td><a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">Wompi</a> (in Spanish)</td><td>Businesses in Colombia with low- or mid-value sales.</td><td>Slow activation, low per-transaction and daily limits, in-person procedures to raise them.</td></tr>
<tr><td><a href="/mercado-pago-pagos-rechazados-montos-altos/">Mercado Pago</a></td><td>Small amounts, several Latin American countries, lots of integrations.</td><td>Large payments rejected, fraudulent-site warning shown to the customer, verification involving third-party data.</td></tr>
<tr><td>Paddle</td><td>SaaS companies with customers in the US and Europe.</td><td>AI and services banned, per-domain verification, everything in English, almost no support, permanent closure and costly withdrawals.</td></tr>
</tbody>
</table>

<h2>Before creating a Paddle account, check this</h2>
<ol>
<li><strong>Read their acceptable use policy in full</strong>, even though it’s in English. If your software uses AI, generates content or includes services, assume it may be rejected and ask in writing before integrating.</li>
<li><strong>Prepare each domain before submitting it for verification</strong>: a clearly described product, visible prices, terms and conditions, refunds, privacy and company details. The site must be finished, not under construction.</li>
<li><strong>Submit each domain only once, and get it right.</strong> Repeated attempts can end in the closure of your entire account, and that closure may be permanent.</li>
<li><strong>Check where your customers are.</strong> If most of them are in Latin America and pay with local methods, Paddle isn’t for you.</li>
<li><strong>Calculate how much you actually receive.</strong> Paddle’s fee, plus your bank’s fee for receiving the transfer, plus intermediaries, plus the exchange rate and the 4 por mil.</li>
<li><strong>Don’t announce your launch</strong> until the account and the domain are approved, and have a plan B ready.</li>
</ol>

<h2>What alternatives you have</h2>
<ul>
<li><strong>For customers in Latin America:</strong> local gateways with PSE and other regional methods, knowing their limits and timelines in advance (see my experience with <a href="/todo-lo-que-debes-saber-sobre-wompi-bancolombia/">Wompi</a> (in Spanish) and with <a href="/mercado-pago-pagos-rechazados-montos-altos/">Mercado Pago</a>).</li>
<li><strong>For customers abroad:</strong> PayPal or other international platforms, comparing fees, terms for services and the cost of withdrawing to Colombia.</li>
<li><strong>For large contracts with companies and institutions:</strong> bank transfer with an electronic invoice. It’s less automated, but it rarely fails.</li>
<li><strong>For software with AI or with bundled services:</strong> charge for the license and for the services separately, and choose providers that accept each type, always asking in writing.</li>
</ul>

<h2>Frequently asked questions</h2>
<h3>Does Paddle allow selling software with artificial intelligence?</h3>
<p>In my case, no: according to their policies, AI software couldn’t be sold through them. Since policies can change, read their acceptable use policy and, if your product uses AI, ask in writing before integrating.</p>
<h3>Can I charge for services with Paddle?</h3>
<p>No. Paddle is geared toward software and SaaS companies. Services such as training, implementation, consulting or custom development can’t be charged through their platform.</p>
<h3>Why does Paddle ask you to verify each domain?</h3>
<p>Because, as Merchant of Record, it sells your product in its own name and reviews every site where the product is offered: the product, the prices, the policies and the business details. If a domain doesn’t comply, it isn’t approved for payments, even if the account exists.</p>
<h3>Does Paddle offer support in Spanish?</h3>
<p>No. The platform, the policies and the support are in English. Also, in my experience there’s no way to talk directly to someone who will review the case, and replies come mostly when they’re denying something.</p>
<h3>If Paddle closes my account, can I create another one?</h3>
<p>In my case, I was told flatly not to try again: the account couldn’t be validated again, not even by creating a new one. That’s why it’s so important to submit each domain for verification only when it’s complete.</p>
<h3>How do I receive my Paddle money in Colombia?</h3>
<p>Through an international wire transfer or another withdrawal method available for your country. Keep in mind your bank’s fee for receiving transfers from abroad, possible intermediary banks, the exchange rate and the 4 por mil.</p>

<h2>Conclusion</h2>
<p>Paddle solves a real problem—taxes and international payments for software—but it’s designed for SaaS companies that sell to the United States and Europe, work in English and have a product that fits their policies without question. For a Latin American software creator, with AI in their product, services in their offering and customers who pay with PSE or Nequi, it’s an uphill road: rigorous verification for every domain, almost nonexistent support, withdrawals with bank costs and, if you insist on complying, a permanent closure with no explanation.</p>
<p>With Wompi, Mercado Pago and Paddle I learned the same lesson: <strong>ask in writing before integrating, test with a real charge, calculate how much you actually receive, and never depend on a single gateway</strong>. If something similar happened to you, share it; these experiences save time and money for whoever comes next.</p>
HTML,
    ],
];
