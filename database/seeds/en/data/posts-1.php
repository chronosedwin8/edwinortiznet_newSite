<?php

declare(strict_types=1);

// English translations of Spanish tutorials (imported with needs_review = 1). Keys are the WordPress IDs of the Spanish source.
return [
    46 => [
        'slug' => 'send-emails-from-excel-without-macros',
        'title' => 'Send Emails WITHOUT Macros from Excel 365 and 2019',
        'excerpt' => 'Learn how to send emails straight from Excel 365 and 2019 without writing a single macro, using the HYPERLINK function and Outlook. The recipient, CC, BCC, subject and body are all taken from your worksheet cells.',
        'seo_title' => 'Send Emails from Excel Without Macros (365 and 2019)',
        'seo_description' => 'Send emails from Excel without macros: combine the HYPERLINK function with mailto, subject, cc, bcc and body to open complete Outlook messages from your cells.',
        'focus_keyword' => 'send emails without macros',
        'content_html' => <<<'HTML'
<p>Sending emails without macros is something every Microsoft Excel user dreams of. Sometimes you simply need to send the information gathered in different cells, and we've always wished there were a function that could do it. Well, in this post you'll learn how. I'll start with the video, and then you can go through the formulas in detail in this article.</p>

<figure class="lite-yt" data-yt="AUkeYmcLxuI"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=AUkeYmcLxuI" data-yt="AUkeYmcLxuI"><img src="https://i.ytimg.com/vi/AUkeYmcLxuI/hqdefault.jpg" alt="Video: Send Emails WITHOUT Macros from Excel 365 and 2019" width="480" height="360"><span class="lite-yt__play"></span></a></figure>

<p>Before we go on: if you've already watched the video, you'll have noticed that we need both Excel and Outlook to send emails without macros, along with the connection we can set up between these two applications. This means you must have both tools installed and configured; without Outlook you won't be able to carry out this process.</p>

<figure><blockquote><p>Important</p>Outlook is an email client, and it can be configured with any type of account, for example Gmail, Hotmail or Outlook accounts, and even business accounts on any domain.</blockquote></figure>

<h2>Send Emails WITHOUT Macros with the HYPERLINK() Function</h2>

<p>Before we talk about how to send emails without macros, we need to be clear on how the HYPERLINK function (HIPERVINCULO in Spanish Excel) works and how it's used.</p>

<p>The HYPERLINK function will help us send emails without macros because it lets us connect any link to a friendly text. Its syntax is as follows:</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133209/1-1.png" alt="Send emails WITHOUT macros from Excel 365 and 2019" width="639" height="368" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133209/1-1-300x173.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133209/1-1-600x346.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133209/1-1.png 639w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>Unlike the post where we covered how to <a href="/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/" target="_blank" rel="noreferrer noopener">send bulk emails from Excel</a>, here we'll only use this function, adding a few parameters or commands to connect with Outlook.</p>

<h2>Parameters for Sending Emails Without Macros from Excel</h2>

<p>First, it's important to remember that we're going to connect Microsoft Excel and Outlook to send emails without macros using a few very basic parameters, which you can even get through the standard procedure for creating a hyperlink. However, that procedure is very limited: it can only send an email to a single recipient with a subject, leaving the body of the email for the user to type in afterwards.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133208/2.fw_.png" alt="send emails without macros" width="878" height="569" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133208/2.fw_-300x194.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133208/2.fw_-600x389.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133208/2.fw_-768x498.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133208/2.fw_.png 878w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>In the image above you can see that there are two commands for creating a link with a recipient address (<strong>mailto:</strong>) and a subject (<strong>?subject=</strong>). The problem is that this link can't pull information from cells, so every time you wanted to use it you'd have to copy the recipient address and the subject. It's better to send it directly, so what we'll do is use those commands to our advantage, combine them with the HYPERLINK function and shape them to fit our needs.</p>

<h2>The HYPERLINK Function for Sending Emails from Excel</h2>

<hr>

<p>Remember, if you'd like to get the Premium template for sending bulk emails with attachments, you can go straight to the store or to the recommended products below.</p>

<p>{{productos:enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco,factura-con-envio-por-correo-al-cliente,combinar-correspondencia-y-guardar-documentos-independientes}}</p>

<hr>

<p>Earlier we said we'd use the basic commands combined with the HYPERLINK function to send the email, but this time we'll make sure the information needed to send it is taken from the cells in our Excel sheets or workbooks.</p>

<p>Next, we'll build a small template for the example.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133207/3-1.png" alt="Send emails WITHOUT macros from Excel 365 and 2019" width="484" height="448" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133207/3-1-300x278.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133207/3-1.png 484w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>The idea is to use this template with our function so you can learn how it works.</p>

<figure class="table-wrap"><table><tbody><tr><td><strong>Field</strong></td><td><strong>Command</strong></td></tr><tr><td>To: (Para:)</td><td>"mailto:"&amp;<strong>Cell</strong>&amp;"</td></tr><tr><td>Subject: (Asunto:)</td><td>"?subject="&amp;<strong>Cell</strong>&amp;</td></tr><tr><td>CC (carbon copy)</td><td>"&amp;cc="&amp;<strong>Cell</strong>&amp;</td></tr><tr><td>BCC (blind carbon copy)</td><td>"&amp;bcc="&amp;<strong>Cell</strong>&amp;</td></tr><tr><td>Email body</td><td>"&amp;body="&amp;<strong>Cell</strong></td></tr></tbody></table></figure>

<p>Now that each command is clear, along with how it should be written, all that's left is to bring them together in the HYPERLINK function, which looks like this:</p>

<pre><code>=HYPERLINK("mailto:"&amp;B2&amp;"?subject="&amp;B5&amp;"&amp;cc="&amp;B3&amp;"&amp;bcc="&amp;B4&amp;"&amp;body="&amp;B7;"Enviar mail")</code></pre>

<p>Note that the text "Enviar mail" ("Send email") at the end of the function is the HYPERLINK function's friendly name, which is why the "&amp;body="&amp;<strong>Cell</strong> command doesn't end with the &amp; symbol like the others.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133207/4-1.png" alt="Send emails WITHOUT macros from Excel 365 and 2019" width="705" height="514" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133207/4-1-300x219.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133207/4-1-600x437.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133207/4-1.png 705w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>This approach is very handy when we need to combine cells, but there's one problem: this method can only concatenate 255 characters, formulas included. So keep in mind that if you don't need BCC or CC, it's better to leave those commands out, because using them spends characters on those extra addresses, characters you could use for the body of the email instead.</p>

<p>On the other hand, if you'd like to do something similar with Microsoft Word, I suggest watching the <a href="https://youtu.be/m04fHEJzDX4" target="_blank" rel="noreferrer noopener">following video</a>, which shows you how to connect Excel and Outlook with the editing power of Microsoft Word.</p>
HTML,
    ],
    66 => [
        'slug' => 'send-bulk-emails-with-attachments-from-excel-and-outlook',
        'title' => 'Send Bulk Emails with Attachments from Excel and Outlook',
        'excerpt' => 'Sending bulk emails with a different attachment for each recipient from Excel, VBA and Outlook is often a real need. This guide walks through a macro-powered template that handles multiple recipients, CC and BCC, custom subjects and several attachments per email.',
        'seo_title' => 'Send Bulk Emails with Attachments from Excel and Outlook',
        'seo_description' => 'Send bulk emails with attachments from Excel using VBA and Outlook: multiple recipients, CC and BCC, a custom subject per row and several files per email.',
        'focus_keyword' => 'send bulk emails',
        'content_html' => <<<'HTML'
<p>Sending bulk emails with different attachments from <a rel="noreferrer noopener" href="/como-funciona-excel-2016-2019-y-365/" target="_blank">Excel</a>, VBA and Outlook is sometimes a real need, and we wonder why Microsoft hasn't built it in. That's exactly why we've covered this topic here on the blog and on <a rel="noreferrer noopener" href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTJfRZ6Xy4RBt8NV2aQSEXnj" target="_blank">my YouTube channel</a>.</p>

<p>We previously published a post about this kind of tool combination (Word, Excel, Outlook) for sending bulk emails, which you can <a href="/enviar-correos-masivos-en-outlook-desde-excel-y-word/">see here</a>. Below, we'll go through a combination of Excel and Outlook using a macro that lets you send up to 500 emails every 24 hours, with attachments taken from a folder.</p>

<h4><strong><a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/" target="_blank" rel="noreferrer noopener">Get the template and the code in the store</a></strong></h4>

<h2>How Do You Send Emails from Excel?</h2>

<figure><a href="https://youtu.be/esO3r3CJb_U" target="_blank" rel="noopener noreferrer"><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133227/15.jpg" alt="Send bulk emails with attachments from Excel and Outlook" width="783" height="426" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133227/15-300x163.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133227/15-600x326.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133227/15-768x418.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133227/15.jpg 783w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></a></figure>

<p>Sending email from Excel requires communicating with other Microsoft tools, specifically from Office, including the <a href="https://www.youtube.com/watch?v=YSHzBI4q3pw&amp;list=PLNXKSKL0wyTJfRZ6Xy4RBt8NV2aQSEXnj&amp;index=1" target="_blank" rel="noreferrer noopener">Outlook email client</a> (not to be confused with the website).</p>

<p>To send emails from Excel with attachments to different accounts, we need to write code in the macro language better known as VBA.</p>

<p>Below, we'll give you a solution so you can send emails from a template containing the list of main recipients, the list of files you want to attach and the email accounts you want to send a copy or a blind copy to.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133239/1-1024x381.jpg" alt="Template for sending bulk emails in Excel" width="1024" height="381" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133239/1-300x112.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133239/1-600x223.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133239/1-768x286.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133239/1-1024x381.jpg 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133239/1.jpg 1348w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h2>How Does the Email Macro Work?</h2>

<p>The first thing to understand is that the template uses a macro that connects to <a rel="noreferrer noopener" href="https://www.youtube.com/watch?v=YSHzBI4q3pw&amp;list=PLNXKSKL0wyTJfRZ6Xy4RBt8NV2aQSEXnj&amp;index=1" target="_blank">Outlook</a> through a library, which lets us use all the features of the Outlook email client to send bulk emails.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133236/6.jpg" alt="Macro for sending bulk emails from Excel" width="443" height="362" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133236/6-300x245.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133236/6.jpg 443w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>The first thing to check is that the files you want to attach are in a folder defined beforehand. These files can be of any type.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133238/2-1024x547.jpg" alt="Send bulk emails from Excel" width="1024" height="547" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133238/2-300x160.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133238/2-600x321.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133238/2-768x410.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133238/2-1024x547.jpg 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133238/2.jpg 1366w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p><a rel="noreferrer noopener" href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTJrVbRNwE0tjLRxT9Mc_HUS" target="_blank">Learn how to mail merge into separate documents</a></p>

<p>Next, we need to add the following macro code to the template.</p>

<hr>

<p>{{productos:combinar-correspondencia-y-generar-pdf-individuales,combinar-correspondencia-y-guardar-documentos-independientes,soporte-plus-para-las-plantillas-de-excel}}</p>

<hr>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133237/3.jpg" alt="Macro to send email from Excel to multiple recipients" width="864" height="383" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133237/3-300x133.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133237/3-600x266.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133237/3-768x340.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133237/3.jpg 864w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122441/carpeta.png" alt="Send bulk emails with attachments from Excel and Outlook" width="763" height="784" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122441/carpeta-100x100.png 100w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122441/carpeta-150x150.png 150w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122441/carpeta-292x300.png 292w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122441/carpeta-300x300.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122441/carpeta-600x617.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122441/carpeta.png 763w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h4><strong><a rel="noreferrer noopener" href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/" target="_blank">Get the template and the code in the store</a></strong></h4>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122537/PermiteArchivo.png" alt="Send bulk emails with attachments from Excel and Outlook" width="586" height="217" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122537/PermiteArchivo-300x111.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01122537/PermiteArchivo.png 586w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>Finally, we add a button or a shape to run the macro and start sending the bulk emails.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133235/7-1024x489.jpg" alt="Macro to send mail from Excel" width="1024" height="489" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133235/7-300x143.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133235/7-600x287.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133235/7-768x367.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133235/7-1024x489.jpg 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133235/7.jpg 1128w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h2>More Features of the Email Template</h2>

<h3>1. Send the Email to More Than One Recipient</h3>

<p>To send an email to more than one recipient, use a semicolon ";" between each email address. This also works for CC and BCC (CCO in Spanish) recipients.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133234/8.jpg" alt="Send emails from Excel in Office 365" width="936" height="373" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133234/8-300x120.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133234/8-600x239.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133234/8-768x306.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133234/8.jpg 936w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h3><strong><a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/" target="_blank" rel="noreferrer noopener">Get the template and the code in the store</a></strong></h3>

<h3>2. Send Copies of the Emails to CC and BCC Recipients</h3>

<p>This feature makes it easier to verify and track the emails you send, since sometimes we need to send them to other people so they can follow up or keep a record of the work.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133233/9-1024x300.jpg" alt="Macro to send email from Excel to multiple recipients" width="1024" height="300" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133233/9-300x88.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133233/9-600x176.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133233/9-768x225.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133233/9-1024x300.jpg 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133233/9.jpg 1238w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h3>3. Customise the Subject of Each Email</h3>

<p>We know every email has its own purpose and even different underlying information, which is why the template lets you include a different subject for each recipient, using a column in the template.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/10-1024x375.jpg" alt="Send bulk emails with attachments from Excel and Outlook" width="1024" height="375" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/10-300x110.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/10-600x220.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/10-768x281.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/10-1024x375.jpg 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/10.jpg 1114w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h3>4. Attach More Than One File</h3>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01123116/separadorfuile-1024x341.png" alt="Send bulk emails with attachments from Excel and Outlook" width="1024" height="341" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01123116/separadorfuile-300x100.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01123116/separadorfuile-600x200.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01123116/separadorfuile-768x256.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01123116/separadorfuile-1024x341.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/05/01123116/separadorfuile.png 1442w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h4>1. <strong>Prepare the Excel sheet:</strong></h4>

<p>First of all, make sure your Excel sheet is well organised and contains all the information needed to send the emails. This includes:</p>

<ul>
<li><strong>Recipient email addresses</strong> in one column.</li>

<li><strong>Names of the files to attach</strong>, separated by a specific delimiter (such as a vertical bar <code>|</code>), in another column.</li>

<li><strong>Subject, message body, CC and BCC</strong> (optional), each in its own column.</li>
</ul>

<h4>2. <strong>Select the folder containing the files:</strong></h4>

<p>The macro should let the user select the folder where the files to attach are stored. This is typically done with a folder-picker dialog box.</p>

<h4>3. <strong>Read and process each row of the sheet:</strong></h4>

<p>The macro should loop through each row of the Excel sheet that contains email data. For each row:</p>

<ul>
<li>Create a new email.</li>

<li>Read the names of the files to attach from the corresponding cell and split them using the defined delimiter (<code>|</code>).</li>
</ul>

<h4>4. <strong>Find and attach the files:</strong></h4>

<p>For each file name listed in the sheet:</p>

<ul>
<li>Look for the file in the selected folder.</li>

<li>If the file exists, attach it to the email.</li>

<li>It's important to make sure the file name in the sheet matches the name of the file in the folder exactly.</li>
</ul>

<h3>5. Customise the Email Body</h3>

<p>You can use this feature in two ways. The first is simply from the VBA code of the bulk email macro.</p>

<p>You can even include HTML code to customise your message.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/11.jpg" alt="Free bulk emails" width="713" height="343" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/11-300x144.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/11-600x289.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133232/11.jpg 713w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>The second is to adjust the line of code above so you can customise the email body from a column.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/12.jpg" alt="Send bulk emails with attachments from Excel and Outlook" width="524" height="317" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/12-300x181.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/12.jpg 524w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/13-1024x244.jpg" alt="Send bulk emails with attachments from Excel and Outlook" width="1024" height="244" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/13-300x72.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/13-600x143.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/13-768x183.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/13-1024x244.jpg 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133231/13.jpg 1307w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133228/14-1024x544.jpg" alt="How to send bulk emails in Outlook from Excel with attachments" width="1024" height="544" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133228/14-300x159.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133228/14-600x319.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133228/14-768x408.jpg 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133228/14-1024x544.jpg 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/11/24133228/14.jpg 1362w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<hr>

<p>{{productos:soporte-plus-para-las-plantillas-de-excel,combinar-correspondencia-y-generar-pdf-individuales,combinar-correspondencia-y-guardar-documentos-independientes}}</p>
HTML,
    ],
    16 => [
        'slug' => 'send-bulk-emails-from-an-excel-list-with-macros-and-outlook',
        'title' => 'How to Send Bulk Emails from an Excel List Using Macros and Outlook',
        'excerpt' => 'Need to send bulk emails quickly and efficiently? This step-by-step guide shows you how to build an email list in Excel and use a VBA macro with Outlook to automate the sending, saving time on your daily tasks.',
        'seo_title' => 'Send Bulk Emails from an Excel List with VBA and Outlook',
        'seo_description' => 'How to send bulk emails from an Excel list: build your mailing list, write the VBA macro and run it with Outlook to automate sending and boost productivity.',
        'focus_keyword' => 'how to send bulk emails',
        'content_html' => <<<'HTML'
<p>If you regularly need to send bulk emails, you've probably wondered how to do it quickly and easily. In this article, we'll show you how to send bulk emails from an Excel list using macros and Outlook.</p>

<p>To do this, we'll use <a href="http://Excel" target="_blank" rel="noreferrer noopener">Excel</a>'s VBA programming language, which lets us automate the email-sending process and <a href="/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/" target="_blank" rel="noreferrer noopener">save a lot of time and effort</a>.</p>

<h2>How to Create an Email List in Excel</h2>

<p>Before we start sending emails, the first thing we need is an email list in Excel. To build it, follow these steps:</p>

<ol>
<li>Open a new Excel workbook and create a new worksheet.</li>

<li>In the first row, type the header for each column (name, email address, subject, email body, etc.).</li>

<li>From the second row onwards, enter the information for each email.</li>
</ol>

<p>Make sure every column has a header and that the information in each row belongs to the same email.</p>

<h2>How to Write the VBA Code</h2>

<p>Once you have your email list in Excel, it's time to <a href="https://www.youtube.com/playlist?list=PLNXKSKL0wyTJckWoIVQab84W5H6Ti5OJO" target="_blank" rel="noreferrer noopener">write the VBA code</a> that will let us send bulk emails from Outlook.</p>

<p>The first thing we need to do is <a href="https://www.youtube.com/watch?v=dSOczB7xhTs&amp;list=PLNXKSKL0wyTJckWoIVQab84W5H6Ti5OJO&amp;index=1&amp;t=2s&amp;pp=gAQBiAQB" target="_blank" rel="noreferrer noopener">open the VBA editor</a> in Excel. To do this, press "Alt" + "F11".</p>

<h3>Inside the VBA editor, follow these steps:</h3>

<figure class="lite-yt" data-yt="WgFUR8MhMAI"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=WgFUR8MhMAI" data-yt="WgFUR8MhMAI"><img src="https://i.ytimg.com/vi/WgFUR8MhMAI/hqdefault.jpg" alt="Video: How to Send Bulk Emails from an Excel List Using Macros and Outlook" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<ol>
<li>Click "Insert" ("Insertar" in Spanish Excel) on the menu bar and select "Module" ("Módulo").</li>

<li>In the new module that has been created, type the following code:</li>
</ol>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/05/24133109/codigo-de-masivos-1024x512.png" alt="How to send bulk emails" width="1024" height="512" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/05/24133109/codigo-de-masivos-300x150.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/05/24133109/codigo-de-masivos-600x300.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/05/24133109/codigo-de-masivos-768x384.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/05/24133109/codigo-de-masivos-1024x512.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/05/24133109/codigo-de-masivos.png 1091w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<ol start="3">
<li>Make sure the email list is in column B, the email subject is in cell C1, the email body in cell D1 and the <a href="/combinar-correspondencia-y-generar-pdf-individuales/" target="_blank" rel="noreferrer noopener">attachment</a> in cell E1.</li>
</ol>

<h2>How to Run the Email Macro</h2>

<p>Once you've written the VBA code, it's time to run it. To do this, follow these steps:</p>

<ol>
<li>Go back to the Excel sheet that contains the email list.</li>

<li>Press "Alt" + "F8" to open the Macro dialog box.</li>

<li>Select the "EnviarCorreosMasivos" macro and click "Run" ("Ejecutar").</li>

<li>Wait for the macro to finish sending all the emails.</li>
</ol>

<p>That's it! Now you know how to send bulk emails from an Excel list.</p>

<h2>Need a More Robust Solution?</h2>

<p class="embed-link"><a href="/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/">https://www.edwinortiz.net/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/</a></p>

<p>{{productos:destacados}}</p>
HTML,
    ],
    611 => [
        'slug' => 'send-bulk-emails-with-word-mail-merge',
        'title' => 'Send Bulk Emails with Word',
        'excerpt' => 'Sending bulk emails with Word is an essential tool for businesses and professionals who need to reach a large audience efficiently. Learn step by step how to do it with Microsoft Word\'s Mail Merge feature and an Excel list.',
        'seo_title' => 'Send Bulk Emails with Word Mail Merge: Step-by-Step Guide',
        'seo_description' => 'Learn how to send bulk emails with Microsoft Word\'s Mail Merge feature and an Excel list, personalising every message for each recipient. A step-by-step guide.',
        'focus_keyword' => 'send bulk emails with Word',
        'content_html' => <<<'HTML'
<p>Sending bulk emails with Word is an <strong><a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/" target="_blank" rel="noreferrer noopener">essential tool for businesses and professionals</a></strong> who want to communicate with a large audience efficiently. Fortunately, <a href="https://www.youtube.com/watch?v=YSHzBI4q3pw&amp;list=PLNXKSKL0wyTJfRZ6Xy4RBt8NV2aQSEXnj&amp;pp=gAQBiAQB" target="_blank" rel="noreferrer noopener">Microsoft Word</a>, part of the Office suite, offers a feature called "Mail Merge" ("Combinar correspondencia" in Spanish Word) that makes this process much easier. In this article, we'll show you how to send bulk emails using this tool and give you additional resources so you can master the technique.</p>

<h2><strong>What Is Mail Merge?</strong></h2>

<p>Mail Merge is a <a href="https://www.youtube.com/watch?v=sQWykwLdB6c&amp;list=PLNXKSKL0wyTKtZDdMKwGNXt5lYnXXCR5r&amp;pp=gAQBiAQB" target="_blank" rel="noreferrer noopener">Microsoft Word</a> feature that lets you create personalised documents using a database or an<a href="https://youtu.be/JncUBa3uihY?si=FRdm2KLFrScoaEaZ" target="_blank" rel="noreferrer noopener"> Excel list</a> as the data source. It's especially useful for sending bulk emails, because it lets you personalise each message for its recipient without having to write every email individually.</p>

<h2><strong>Steps to Send Bulk Emails with Word</strong></h2>

<figure class="lite-yt" data-yt="AstTPb-4vZw"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=AstTPb-4vZw" data-yt="AstTPb-4vZw"><img src="https://i.ytimg.com/vi/AstTPb-4vZw/hqdefault.jpg" alt="Video: Send Bulk Emails with Word" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<h3><strong>Prepare Your Database</strong> to Send Bulk Emails with Word</h3>

<p>Before you start, it's essential to have a list or <a href="/como-hacer-en-excel-una-tabla-de-porcentajes/" target="_blank" rel="noreferrer noopener">database in Excel</a> with all the information you want to include in your emails. This list can contain names, email addresses and any other details you'd like to personalise in each email.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13142109/1-1024x531.png" alt="Send bulk emails with Word" width="1024" height="531" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13142109/1-300x155.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13142109/1-600x311.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13142109/1-768x398.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13142109/1-1024x531.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13142109/1-1536x796.png 1536w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13142109/1.png 1916w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h3><strong>Open a New Document in Word</strong></h3>

<p>Launch Microsoft Word and open a new document. This will be the base document where you set up the mail merge.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13155030/word3.gif" alt="Send bulk emails with Word" width="1920" height="1080" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13155030/word3-300x169.gif 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13155030/word3-600x338.gif 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13155030/word3-768x432.gif 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13155030/word3-1024x576.gif 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13155030/word3-1536x864.gif 1536w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2023/10/13155030/word3.gif 1920w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h3><strong>Open the Mail Merge Tool</strong></h3>

<p>Go to the "Mailings" tab ("Correspondencia") on the ribbon and select "Start Mail Merge" ("Combinar correspondencia"). Here, choose the "E-mail Messages" option to begin the process.</p>

<figure><img src="https://www.edwinortiz.net/wp-content/uploads/2023/10/combinar.gif" alt="Send bulk emails with Word" width="1920" height="1080" loading="lazy" decoding="async"></figure>

<h3><strong>Select Recipients</strong></h3>

<p>Click "Select Recipients" ("Seleccionar destinatarios") and choose "Use an Existing List" ("Usar una lista existente"). Browse to and select the Excel file you prepared earlier.</p>

<h3><strong>Insert Merge Fields</strong></h3>

<p>In the Word document, decide where you want the personalised information to appear and use the "Insert Merge Field" option ("Insertar campo combinado") to choose the data you want to include.</p>

<h3><strong>Preview and Merge</strong></h3>

<p>Before sending the emails, use the "Preview Results" option ("Vista previa") to make sure everything is in order. Once you're happy with it, select "Finish &amp; Merge" ("Finalizar y combinar") and choose "Send Email Messages" ("Enviar mensajes de correo electrónico").</p>

<h2><strong>Additional Resources</strong></h2>

<p>If you'd like to learn more about this tool, we recommend checking out these links:</p>

<p class="embed-link"><a href="/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/">https://www.edwinortiz.net/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/</a></p>

<p>Sending bulk emails with Microsoft Word's Mail Merge is a <a href="/producto/enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco/" target="_blank" rel="noreferrer noopener"><strong>powerful technique that can save you time and effort</strong></a>, especially when you need to reach a large list of contacts. With practice and the right resources, you'll master this tool in no time. Good luck and happy sending!</p>

<figure class="lite-yt" data-yt="1Tzt8V4supc"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=1Tzt8V4supc" data-yt="1Tzt8V4supc"><img src="https://i.ytimg.com/vi/1Tzt8V4supc/hqdefault.jpg" alt="Video: Send Bulk Emails with Word" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<figure class="lite-yt" data-yt="esO3r3CJb_U"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=esO3r3CJb_U" data-yt="esO3r3CJb_U"><img src="https://i.ytimg.com/vi/esO3r3CJb_U/hqdefault.jpg" alt="Video: Send Bulk Emails with Word" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<p>{{articulos:excel}}</p>
HTML,
    ],
];
