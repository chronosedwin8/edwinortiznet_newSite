<?php

declare(strict_types=1);

// English version of «Me llamó mi jefe y parecía su voz»: AI voice-cloning scams and a verification protocol. Key is the Spanish slug.
// Figures (FBI IC3 2024, Arup case, UCL study, FTC, Colombian figures and Ley 2502 de 2025) checked on October 9, 2026, with linked sources.
// Status and publication date are carried over from the Spanish post by en/02_recent_posts.php (scheduled for Tuesday, October 13, 2026, 7:00 a.m. Bogotá time).
$img = static function (string $name, int $h960, string $alt, string $caption): string {
    $base = '/assets/img/articulos/estafas-voz-clonada-ia/' . $name . '-en';
    return '<figure><img src="' . $base . '-960.webp" srcset="' . $base . '-640.webp 640w, ' . $base . '-960.webp 960w, ' . $base . '-1440.webp 1440w" '
        . 'sizes="(min-width: 760px) 720px, 100vw" alt="' . $alt . '" width="960" height="' . $h960 . '" loading="lazy" decoding="async">'
        . '<figcaption>' . $caption . '</figcaption></figure>';
};

$html = <<<'HTML'
<p>The phone rings on a Tuesday at 4:40 p.m. It is your boss's voice, or the principal's, or your son's. It sounds agitated. They need a transfer "right now," a code you just received, or a favor you "must not mention to anyone." Everything about the call feels authentic, and that is exactly the problem: <strong>a familiar voice no longer proves anything</strong>.</p>
<p>In this article I explain how voice cloning works, what the data say (FBI, Hong Kong, Colombia), what the warning signs are and, above all, I give you a <strong>verification protocol</strong> ready to use at your company, school or home. Date of the last check of data and rules: October 9, 2026.</p>
<p class="notice"><strong>Summary.</strong> A few seconds of audio posted on social media can be enough to imitate a voice. Listeners spot fake voices only 73% of the time. What protects you is not a good ear but verifying through a second channel, using a number you already have, and requiring double approval for payments and bank-account changes.</p>

<h2>How voice cloning works and why it fools us</h2>
<p>A synthetic voice model is trained on recordings of a person and learns their timbre, rhythm and verbal tics. It can then "read" any text in that voice, even in real time during a call. The <a href="https://consumer.ftc.gov/scams/family-emergency-scams">US Federal Trade Commission (FTC)</a> warns that a scammer only needs a short clip of a relative's voice, which can come from content posted online, and a cloning program. WhatsApp voice notes, Instagram videos, recorded classes and conference talks are more than enough raw material.</p>
<p>Would we notice? A University College London study published in <em>PLOS ONE</em> in 2023 asked 529 people to tell real voices from fake ones: <a href="https://www.ucl.ac.uk/news/headlines/2023/aug/humans-can-detect-deepfake-speech-only-73-time-study-finds">they got it right 73% of the time</a>, and training them with examples barely helped. The authors themselves note they used relatively old algorithms, so with today's models the figure is probably worse. The practical conclusion is uncomfortable: <strong>you cannot trust your ear, you have to trust a procedure</strong>.</p>

<h2>What the data say: from the FBI to Colombia</h2>
<p>In 2024 the <a href="https://www.ic3.gov/AnnualReport/Reports/2024_IC3Report.pdf">FBI's Internet Crime Complaint Center (IC3)</a> received 859,531 complaints and recorded losses of US$16.6 billion, 33% more than in 2023. Business email compromise (BEC, where someone poses as a boss or supplier to divert a payment) alone caused US$2.77 billion in losses, with 21,442 complaints. It is the second-largest source of losses, and voice and video cloning are the new version of that same script.</p>
<p>The most cited case happened in Hong Kong. A finance employee at the engineering firm Arup joined a video call with who he believed was the chief financial officer and other colleagues; <a href="https://abc17news.com/money/cnn-business-consumer/2024/05/16/british-engineering-giant-arup-revealed-as-25-million-deepfake-scam-victim/">all of them were fake recreations</a>. He made 15 transfers totaling about HK$200 million (roughly US$25 million) to five accounts, and only found out a week later when he checked with headquarters. He had first doubted a "secret" email, but the video call dispelled his doubts: seeing and hearing "colleagues" who looked real was the false proof of authenticity.</p>
<p>And here? Colombia does not yet have a consolidated official statistic on voice-cloning scams. What exists are signals. A report from the Sound Engineering program at the Universidad de San Buenaventura, covered by <a href="https://www.portafolio.co/tecnologia/estafas-con-voces-clonadas-por-ia-crecieron-30-en-diciembre-y-alertan-a-expertos-en-colombia-486082">Portafolio</a>, speaks of a 30% increase in December 2025 (the article does not specify compared with which period). The National Police reported, as of December 2025, 64 extortion complaints in Bolívar, 24 of which involved digital methods such as cloned voices and AI-generated images, and the Gaula anti-extortion unit recorded 36 related arrests. And the National Digital Security Strategy places Colombia as the second most attacked country in Latin America in 2025, with 17% of the region's attempts.</p>
{{img:cifras}}

<h2>What a scam call sounds like: the pattern that repeats</h2>
<p>The voice and the technology change, but the script hardly varies. Look for this combination:</p>
<ul>
<li><strong>A voice of authority or affection:</strong> the manager, the principal, the accountant, your child, your mother.</li>
<li><strong>Urgency:</strong> "it's for today," "otherwise we lose the contract," "they're waiting for me."</li>
<li><strong>Secrecy:</strong> "don't tell anyone," "it's confidential," "I'm embarrassed."</li>
<li><strong>A payment that cannot be reversed:</strong> a transfer to a new account, digital wallets, cryptocurrency, gift cards, or a code that arrived by message.</li>
<li><strong>A channel that stops you from verifying:</strong> they call from an unknown number, tell you not to hang up, or say their phone is "broken."</li>
</ul>
<p>When two or more of these signs appear together, it stops mattering how real the voice sounds. At school the typical version is the "principal" asking the treasurer for an urgent payment to a new supplier; at home, the "detained" or injured child who needs money now. The FTC and the Universidad de San Buenaventura report give the same advice: <strong>don't trust the voice, verify through another channel</strong>.</p>

<h2>Verification protocol for companies, schools and families</h2>
<p>This is the resource I promised. It is designed to be applied in under two minutes and so that it does not depend on someone "noticing." Print it and stick it next to the treasury phone, or share it in the family group.</p>
{{img:protocolo}}
<table>
<thead><tr><th>Situation</th><th>Verification rule</th></tr></thead>
<tbody>
<tr><td>They ask for a new payment or a bank-account change</td><td>Confirm by calling the number that is <em>already on file</em> (not the one they give you). Two people approve it and it is written down.</td></tr>
<tr><td>They ask for a code, password or personal data</td><td>Never give them over the phone, even if the voice belongs to someone you know. Codes are personal and non-transferable.</td></tr>
<tr><td>"Urgent" call from an executive</td><td>Pause 20 seconds, hang up and call back through the official channel. Any real emergency survives that wait.</td></tr>
<tr><td>Video call asking for money</td><td>Ask the person to do something unexpected (a gesture, a question only they would know) and confirm by another means before acting.</td></tr>
<tr><td>A relative "in trouble" asks for money</td><td>Use the <strong>family code word</strong> agreed in advance, or call that person or another relative directly.</td></tr>
<tr><td>They ask you to keep it secret</td><td>Secrecy is a warning sign, not a reason to obey. Talk to someone you trust.</td></tr>
</tbody>
</table>
<p>Some recommendations from the Universidad de San Buenaventura report help adapt the protocol: pause at least 20 seconds before acting, ask a question only the real person could answer, listen to the audio with headphones to catch cuts or unnatural endings, save the recording and report it. As lecturer Marcelo Herrera puts it: "What protects you is not the technology, but the calm to verify."</p>

<h3>How to set up a family code word</h3>
<ul>
<li>Choose it in person, not by chat; make it a word or phrase nobody could guess that appears on no social network.</li>
<li>Use it only for money or safety emergencies so it keeps its value.</li>
<li>Explain it to grandparents and teenagers too: they are the most frequent targets of this kind of call.</li>
</ul>

<h3>How to protect yourself at work and at school</h3>
<p>For a small company or school, the cheapest and most effective change is to <strong>separate whoever requests the payment from whoever authorizes it</strong> and to standardize the document used to request it. A payment order with a fixed format, with the amount also written in words, the registered account and two signatures, makes it harder for an urgent voice to replace it. Checks had that logic; transfers lost it. If you use Excel for payment orders, the <a href="/producto/convertidor-de-numeros-a-letras-en-excel/">Number-to-words converter for Excel</a> writes the amount in words automatically (there is also a <a href="/herramientas/numero-a-letras/">free online version</a>), and the <a href="/producto/factura-con-envio-por-correo-al-cliente/">Invoice with email delivery to the customer</a> always keeps the same sender, format and bank details, so any change of account stands out as an anomaly.</p>
{{productos:convertidor-de-numeros-a-letras-en-excel,factura-con-envio-por-correo-al-cliente}}

<h2>What to do if you already made the transfer</h2>
<ol>
<li><strong>Call your bank immediately</strong> and ask them to try to block or reverse the operation. In business fraud every hour counts: according to <a href="https://www.proofpoint.com/us/blog/email-and-cloud-threats/email-attacks-drive-record-cybercrime-losses-2024">Proofpoint's summary</a> of the FBI report, its Recovery Asset Team froze 66% of the business email compromise transfers it handled in 2024.</li>
<li><strong>Save the evidence:</strong> the audio, the number they called from, the messages, the receipts.</li>
<li><strong>Report it.</strong> In Colombia you can do so at the National Police's <a href="https://caivirtual.policia.gov.co">CAI Virtual</a> and with the Attorney General's Office (Fiscalía). Elsewhere, use your national cybercrime reporting channel (in the US, IC3).</li>
<li><strong>Change passwords and turn on two-step verification</strong> on your email and online banking, in case the scammer also obtained credentials.</li>
</ol>

<h2>What the law says in Colombia</h2>
<p><a href="https://normograma.mintic.gov.co/mintic/compilacion/docs/ley_2502_2025.htm">Law 2502 of 2025</a>, enacted on July 28, 2025 and published in Diario Oficial 53.198, defined a <em>deepfake</em> as a fake audiovisual record (photos, videos or sound recordings) created or modified with AI, and added to the crime of personal forgery (article 296 of the Penal Code) an aggravating circumstance when the impersonation is done with artificial intelligence: according to the text, the fine increases by up to one third, provided the conduct does not constitute another crime. The law also orders a public policy on the use of AI to deceive or harm. Keep in mind that fraud and extortion have their own crimes and penalties; ask a lawyer or the Fiscalía how your case would be classified, and check the law's text for when the aggravating circumstance takes effect, because this article is not legal advice.</p>

<h2>How to talk about this with students and families</h2>
<p>Teenagers share their voices and their families' voices on social media all day, and their grandparents are frequent targets. A 15-minute exercise works better than a lecture: ask students to write, in pairs, a "fake call" script and have another pair identify the five signs of the pattern (authority, urgency, secrecy, irreversible payment, unverifiable channel). Then let each family agree on its code word. If you teach technology or computing, the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a> helps you prepare digital-literacy resources by subject without starting from scratch, and the <a href="/herramientas/generador-de-examenes/">AI Exam Generator</a> lets you turn this protocol into a comprehension quiz in minutes (<a href="/examenes/demo/">there is a free demo</a>).</p>
<p>To widen the picture of what AI can and cannot do, I recommend <a href="/la-ia-no-te-reemplazara-quien-la-domine-si/">"AI won't replace you, but whoever masters it will"</a> and <a href="/gran-mentira-ia-inteligencia-artificial-no-piensa/">"The Big Lie About AI"</a>, where I review what a machine really understands and which laws exist in Colombia, Latin America and the world.</p>

<h2>Frequently asked questions</h2>
<h3>How many seconds of audio does a scammer need to clone my voice?</h3>
<p>There is no single reliable figure: it depends on the tool and the audio quality. Official warnings speak of "a short clip." The prudent assumption is that any public audio (stories, videos, forwarded voice notes) is enough for a convincing imitation.</p>
<h3>Can a cloned voice be detected?</h3>
<p>Sometimes. Cuts, odd pauses, missing breathing or an overly flat tone can give it away, but studies show people get it right about 73% of the time and models improve every year. That is why the protocol does not depend on detecting the fake, but on verifying the request.</p>
<h3>What is a family code word and how is it used?</h3>
<p>It is a word or phrase agreed in person that only the family knows. If someone calls asking for money urgently, you ask for the word; if they don't know it, you hang up and call the person directly. It must not be posted or typed in chats.</p>
<h3>Does my company need special software against these scams?</h3>
<p>Not to start. The most effective controls are about process: double approval, call-backs to registered numbers, standardized payment templates and training. Detection software complements these rules but does not replace them.</p>
<h3>What do I do if my voice or my principal's was cloned and is circulating online?</h3>
<p>Save screenshots and links, report the content to the platform, warn your community through official channels and file a report with the CAI Virtual or the Fiscalía.</p>

<p class="notice"><strong>Turn information into action.</strong> Standardize your payment orders with the <a href="/producto/convertidor-de-numeros-a-letras-en-excel/">Number-to-words converter for Excel</a>, always send invoices in the same format with the <a href="/producto/factura-con-envio-por-correo-al-cliente/">Invoice with email delivery</a> and, if you teach, bring the topic into the classroom with the <a href="/producto/kit-de-ia-para-docentes/">AI Kit for teachers</a>. And share this article with whoever handles payments at your home or institution: it is free and could save a lot of money.</p>

<h2>Food for thought</h2>
<p>For centuries, recognizing someone's voice was the most intimate way of trusting them. If that proof no longer works, <strong>should we get used to distrusting by default the people we love most, or redesign our institutions so that trust does not depend on a voice?</strong> And who should bear the cost when a company, a school or a family is deceived: the victim, the bank, the platforms that host the audio or the people who develop these tools?</p>
HTML;

$html = (string) preg_replace('#<a href="(https?://[^"]+)">#', '<a href="$1" target="_blank" rel="noopener">', $html);
$html = strtr($html, [
    '{{img:cifras}}' => $img('estafas-voz-clonada-ia-cifras', 573, 'Four cards with figures: US$16.6 billion in cybercrime losses reported to the FBI in 2024, US$2.77 billion from business email compromise, US$25 million transferred by an Arup employee after a fake video call and 73% accuracy at spotting fake voices.', 'Losses and the limits of human detection. Sources: FBI IC3 2024, CNN on Arup (2024) and Mai et al., PLOS ONE (2023).'),
    '{{img:protocolo}}' => $img('estafas-voz-clonada-ia-protocolo', 600, 'Four-step verification protocol: pause, hang up, verify another way and confirm with two people.', 'Four-step verification protocol before paying or sharing data.'),
]);

return [
    'estafas-voz-clonada-ia-protocolo-verificacion' => [
        'slug' => 'ai-voice-cloning-scams-verification-protocol',
        'title' => '"My Boss Called and It Sounded Like His Voice": How AI Voice Scams Work and How to Avoid Them',
        'excerpt' => 'A few seconds of audio can clone a voice. What the FBI, the Arup case and Colombian figures say, the warning signs and a verification protocol for companies, schools and families.',
        'seo_title' => 'AI Voice Cloning Scams: How to Avoid Them',
        'seo_description' => 'How AI voice-cloning scams work, the warning signs and a verification protocol for payments, companies, schools and families, with data from the FBI and Colombia.',
        'focus_keyword' => 'AI voice cloning scams',
        'cover' => '/assets/img/articulos/estafas-voz-clonada-ia/estafas-voz-clonada-ia-portada-en',
        'cover_alt' => 'Phone screen showing an incoming call from "Boss / Principal", a voice waveform and the message "I need a transfer now. Don\'t tell anyone", with alerts for familiar voice, urgency and secrecy and the advice to hang up and call back.',
        'content_html' => $html,
    ],
];
