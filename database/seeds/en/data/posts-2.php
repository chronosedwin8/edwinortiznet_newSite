<?php

declare(strict_types=1);

// English translations of Spanish tutorials (imported with needs_review = 1). Keys are the WordPress IDs of the Spanish source.
return [
    41 => [
        'slug' => 'mail-merge-to-individual-pdf-files',
        'title' => 'Mail Merge to Individual PDF Files',
        'excerpt' => 'Word\'s Mail Merge puts every record into one single document. Here is how to merge from Excel and save each record as its own PDF file using a simple macro.',
        'seo_title' => 'Mail Merge to Individual PDF Files in Word with a Macro',
        'seo_description' => 'Learn how to mail merge from Excel into Word and save each record as its own PDF file with a simple VBA macro. Watch the video and get the code step by step.',
        'focus_keyword' => 'mail merge to individual PDF files',
        'content_html' => <<<'HTML'
<p> <strong>Mail merging to individual PDF files</strong> is one of the options that really should have been included in Word's <a href="https://www.youtube.com/watch?v=AstTPb-4vZw" target="_blank" rel="noopener">Mail Merge tool (Combinar correspondencia in Spanish Word) </a> </p>

<p> If you prefer, you can watch this whole post as a video below, and then keep reading to get the code you will need for the process. </p>

<figure class="lite-yt" data-yt="ZrDU8Ub2-yU"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=ZrDU8Ub2-yU" data-yt="ZrDU8Ub2-yU"><img src="https://i.ytimg.com/vi/ZrDU8Ub2-yU/hqdefault.jpg" alt="Video: Mail Merge to Individual PDF Files" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<p>At the moment, Microsoft Word runs mail merges between a Microsoft Excel list and a Microsoft Word document, and the result is one single document containing all the pages generated from the data in the Excel workbook.</p>

<p>This becomes a problem when we need those pages separately: each page is, in a sense, independent of the others, yet they are all tied together in one single document.</p>

<p>One reason to think about mail merging to individual PDF files would be, for example, generating payment receipts and sending each receipt as a PDF to a different recipient, as an email attachment, of course.</p>

<p>Merging and generating individual PDF files is a simple process if we use macros in our documents. Below I will describe the steps you need to follow to mail merge into separate documents.</p>

<h2>Run the Mail Merge and generate the merged document with individual pages</h2>

<p>This step is important for reaching our goal of mail merging to individual PDF files, because it gives us the first input we need before we can use the macros later on.</p>

<p>That said, I don't mean it is a mandatory step: if you already have a Word document and you want to split it into parts and convert the result to PDF, this mail merge to individual PDF files process will also work for you.</p>

<p>For this first step you need all your data in an Excel workbook, neatly organized and with column headers, as shown in the image.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133203/datos-1024x546.png" alt="Word mail merge: save as separate files" width="1024" height="546" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133203/datos-300x160.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133203/datos-600x320.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133203/datos-768x410.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133203/datos-1024x546.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133203/datos.png 1366w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>Next, we connect this Microsoft Excel workbook to our Microsoft Word document, which holds the base template, so that we get one single document with all the information ready to be split into individual documents and converted to PDF.</p>

<h2>The real trick to generating individual PDF files</h2>

<p>As I mentioned earlier, you need a base Word document to generate the individual PDF files, and now we have it. However, this document needs macros for this step, so your Microsoft Word must have macros enabled and allow you to add macro code. To do that, we first need to enable the following tab.</p>

<figure class="lite-yt" data-yt="dSOczB7xhTs"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=dSOczB7xhTs" data-yt="dSOczB7xhTs"><img src="https://i.ytimg.com/vi/dSOczB7xhTs/hqdefault.jpg" alt="Video: Mail Merge to Individual PDF Files" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<p>Then we add the following code to a module.</p>

<p><br>Add to cart<br><br><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133159/codigo-1024x643.png" sizes="(min-width: 760px) 720px, 100vw" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133159/codigo-300x188.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133159/codigo-600x377.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133159/codigo-768x482.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133159/codigo-1024x643.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/07/24133159/codigo.png 1064w" alt="Mail merge to individual PDF files" width="1024" height="643" loading="lazy" decoding="async"></p>

<p>Finally, we run the code and get the end result: the mail merge saved as individual PDF files in the folder of your choice, ready to be used however you like.</p>

<p>If you would rather not do all the work of copying the code, you can get this code and others in the shop.<br><strong>If you want to get the code quickly, click the Add to cart button</strong></p>

<p>{{productos:combinar-correspondencia-y-generar-pdf-individuales,combinar-correspondencia-y-guardar-documentos-independientes,enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco}}</p>

<h2>Post summary in images</h2>

<p class="embed-link"><a href="https://view.genial.ly/60fc813bdddb8a0d804a99f5" target="_blank" rel="noopener" class="btn-link">View the interactive presentation</a></p>
HTML,
    ],
    52 => [
        'slug' => 'mail-merge-and-save-as-separate-documents',
        'title' => 'Mail Merge and Save as Separate Documents',
        'excerpt' => 'If you have to generate 500 individual letters, creating and saving each document one by one by hand would be very tedious. Here is how to merge and save them as separate documents with a macro.',
        'seo_title' => 'Mail Merge and Save Each Record as a Separate Word File',
        'seo_description' => 'Word\'s Mail Merge only creates one big document. Learn how to use a VBA macro to merge from Excel and save each record as a separate Word or PDF document.',
        'focus_keyword' => 'mail merge and save as separate documents',
        'content_html' => <<<'HTML'
<p>Mail merging and saving the results as separate documents is a feature we would all love to have in Microsoft Word when we use <a href="https://www.youtube.com/watch?v=AstTPb-4vZw" target="_blank" rel="noreferrer noopener">Mail Merge (Combinar correspondencia in Spanish Word)</a>, but unfortunately Word only lets you merge into separate documents if, and only if, they are sent by<a href="/enviar-correos-masivos-con-adjuntos-desde-excel-y-outlook/"> email as a mass mailing</a>.</p>

<p>To mail merge and save into separate documents, we need to use the macro language, VBA (Visual Basic for Applications), to create a routine that takes the information from a master document and turns it into separate Word documents.</p>

<h2>What do we need to do to split one document into several separate ones?</h2>

<p>The first thing you need for this process is to know how to run a mail merge in Word and get a merged document from an Excel list and a Word document. For that, here is the following video.</p>

<figure class="lite-yt" data-yt="AstTPb-4vZw"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=AstTPb-4vZw" data-yt="AstTPb-4vZw"><img src="https://i.ytimg.com/vi/AstTPb-4vZw/hqdefault.jpg" alt="Video: Mail Merge and Save as Separate Documents" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<h2>Step 2: have the merged document ready and saved correctly</h2>

<p>This step matters, because how we save the document determines whether the next steps give us excellent results. I recommend saving that document either as .doc or as .docm (macro-enabled), but not as .docx. The reason is that we are going to include a macro in the document, and the .docx format does not allow you to save macros. In this example I will name it “DOCUMENTOS GENERADOS” (generated documents).</p>

<p>If you want to see the process in detail, I recommend watching the following video, which shows the complete procedure. After that, we will move on to getting the macro.</p>

<figure class="lite-yt" data-yt="1Tzt8V4supc"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=1Tzt8V4supc" data-yt="1Tzt8V4supc"><img src="https://i.ytimg.com/vi/1Tzt8V4supc/hqdefault.jpg" alt="Video: Mail Merge and Save as Separate Documents" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<p>Now that you know the procedure to merge and save as separate documents, you will need the macro code, so here it is for you to copy into your macro workbook following the steps explained.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133218/1.png" alt="Mail merge and save as separate documents" width="673" height="416" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133218/1-300x185.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133218/1-600x371.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133218/1.png 673w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133217/2.png" alt="Mail merge and save as separate documents" width="869" height="460" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133217/2-300x159.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133217/2-600x318.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133217/2-768x407.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133217/2.png 869w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/3.png" alt="Mail merge and save as separate documents" width="709" height="454" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/3-300x192.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/3-600x384.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/3.png 709w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/4.png" alt="Mail merge and save as separate documents" width="750" height="346" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/4-300x138.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/4-600x277.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133216/4.png 750w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133215/5.png" alt="Mail merge and save as separate documents" width="719" height="389" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133215/5-300x162.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133215/5-600x325.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133215/5.png 719w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/6.png" alt="Mail merge and save as separate documents" width="758" height="424" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/6-300x168.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/6-600x336.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/6.png 758w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/7.png" alt="Mail merge and save as separate documents" width="757" height="351" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/7-300x139.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/7-600x278.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133214/7.png 757w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/8.png" alt="Mail merge and save as separate documents" width="636" height="244" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/8-300x115.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/8-600x230.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/8.png 636w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h2>Want to save time when merging and saving to separate documents?</h2>

<p><strong>If you want to do this quickly instead of copying the macro line by line, I recommend getting the source code at the following link.</strong></p>

<p class="embed-link"><a href="/producto/combinar-correspondencia-y-guardar-documentos-independientes">https://www.edwinortiz.net/producto/combinar-correspondencia-y-guardar-documentos-independientes</a></p>

<p>Note: Purchasing the macro code does not include any support from the author of this page, since macro code can have errors that vary depending on the version of Office you are using.<br>This code was tested in Office 2016-2019 and Office 365</p>

<h2>I'm a designer: how do I merge into separate documents in Corel Draw?</h2>

<p>The interesting thing is that in Corel Draw you don't need macros, but you do need to follow the steps in the following video.</p>

<figure class="lite-yt" data-yt="9C9pGmHfxdk"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=9C9pGmHfxdk" data-yt="9C9pGmHfxdk"><img src="https://i.ytimg.com/vi/9C9pGmHfxdk/hqdefault.jpg" alt="Video: Mail Merge and Save as Separate Documents" width="480" height="360"><span class="lite-yt__play"></span></a></figure>

<h2>I want to merge into separate PDF documents</h2>

<p>For this, put the following code in your macro workbook and you will get each document separately in both Word and PDF format, one of each.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/9.png" alt="Mail merge and save as separate documents" width="761" height="356" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/9-300x140.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/9-600x281.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2021/03/24133213/9.png 761w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>
HTML,
    ],
    777 => [
        'slug' => 'merge-excel-data-into-separate-docx-and-pdf-documents',
        'title' => 'Merge Excel Data into Separate DOCX and PDF Documents',
        'excerpt' => 'Would you like to automate the creation of personalized Word documents? Learn how to combine an Excel list with a Word master document and generate separate DOCX or PDF files in bulk with a single click.',
        'seo_title' => 'Merge Excel Data into Separate DOCX and PDF Documents',
        'seo_description' => 'Automate personalized Word documents: merge the data from an Excel list into separate DOCX or PDF files, headers and footers included, in three simple steps.',
        'focus_keyword' => 'merge Excel data into separate documents',
        'content_html' => <<<'HTML'
<p>Merging Excel data into separate documents is a topic we have already covered on the blog, but with an approach based on Excel macros, <a href="/combinar-y-guardar-en-documentos-independientes/" target="_blank" rel="noreferrer noopener">which you can see here</a>, or <a href="/combinar-correspondencia-y-generar-pdf-individuales/" target="_blank" rel="noreferrer noopener">over here</a> as well</p>

<p>In this new post, we will focus on a software tool that makes our work easier when merging <a href="/excel/" target="_blank" rel="noreferrer noopener">Excel</a> data into separate documents, whether DOCX or PDF, and it even keeps your headers and footers.</p>

<figure class="lite-yt" data-yt="_m582hmlrk0"><a class="lite-yt__link" href="https://www.youtube.com/watch?v=_m582hmlrk0" data-yt="_m582hmlrk0"><img src="https://i.ytimg.com/vi/_m582hmlrk0/hqdefault.jpg" alt="Video: Merge Excel Data into Separate DOCX and PDF Documents" width="480" height="360" loading="lazy" decoding="async"><span class="lite-yt__play"></span></a></figure>

<p>Below, we will talk about a tool that lets you create hundreds of separate documents, in the format you want, in 3 simple steps, starting from a Word master document that pulls its information from an Excel table.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15131303/form.png" alt="Merge Excel data into separate documents" width="450" height="661" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15131303/form-204x300.png 204w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15131303/form.png 450w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h2>How to merge documents with an Excel list and a Word master file</h2>

<p>Merging documents may seem like a complicated task, especially if you are not a programmer or a technical person. However, with the right tools, it is a process anyone can do. In this article, I will guide you step by step so you can merge data from an Excel file with a Word master document, using a simple application.</p>

<h3>What do you need?</h3>

<h4>1. An Excel file with the information you want to merge.</h4>

<p>Create an Excel file containing the names of the columns you want to merge, and fill in this table as needed.</p>

<p>I suggest not using accented letters or words with the <strong>letter ñ</strong> in the column header names.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134100/excel-1-1024x568.png" alt="Merge Excel data into separate documents" width="1024" height="568" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134100/excel-1-300x167.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134100/excel-1-600x333.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134100/excel-1-768x426.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134100/excel-1-1024x568.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134100/excel-1.png 1497w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h4>2. A Word master document containing placeholders where the Excel data will be inserted.</h4>

<p>Before going any further, it helps to know what a placeholder is. A placeholder is simply a tag that tells the program where to insert the data from each column of the Excel file.</p>

<p>Placeholders are written inside the master document like this (the name of the Excel column between double curly braces):</p>

<p><strong>{{COLUMN}}</strong></p>

<p>In our example, placeholders would look like <strong>{{NOMBRE}}</strong> (name) or <strong>{{DIRECCION}}</strong> (address). This way, the program knows where to place each merged value taken from the Excel list.</p>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134245/word-1-1024x554.png" alt="Merge Excel data into separate DOCX and PDF documents" width="1024" height="554" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134245/word-1-300x162.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134245/word-1-600x325.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134245/word-1-768x415.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134245/word-1-1024x554.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134245/word-1-1536x831.png 1536w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15134245/word-1.png 1919w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<h4>3. Use the application to merge the documents</h4>

<p>Now we are going to use a special application called "Document Combiner" ("Combinador de Documentos" in the Spanish interface). Here is how it works, step by step:</p>

<ol>
<li><strong>Select the Excel file:</strong> Open the application and select your Excel file. The application will load the available columns.</li>

<li><strong>Select the Word file:</strong> Next, select your Word master document.</li>

<li><strong>Select the destination folder:</strong> Choose the folder where the merged documents will be saved.</li>

<li><strong>Select the column for file names:</strong> Choose the Excel column that will be used to name each merged file.</li>

<li><strong>Choose the output format:</strong> You can save the files as Word documents (DOCX) or as PDF.</li>

<li><strong>Start the merge:</strong> Click "Start merge" ("Iniciar combinación") and the application will process each row of the Excel file, creating an individual document for each one.</li>
</ol>

<figure><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15135416/Programa.gif" alt="Merge Excel data into separate DOCX and PDF documents" width="566" height="780" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15135416/Programa-218x300.gif 218w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/15135416/Programa.gif 566w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></figure>

<p>This application solves a shortcoming of Word's <a href="https://youtu.be/1Tzt8V4supc" target="_blank" rel="noreferrer noopener">Mail Merge (Combinar correspondencia in Spanish Word)</a>, which in Word only creates one single document with all the information. The "<strong>Document Combiner</strong>", on the other hand, creates the documents separately and adds extra value, such as the option to merge into separate Word or PDF documents. On top of that, the application uses a master document that includes all the Word features you want in your final merged documents.</p>

<h2>Option 1: Download the individual-document Mail Merge application - Free (7-day freemium)</h2>

<p>The <strong>Premium trial</strong> is fully functional and lets you create as many documents as you want, with no restrictions. You can download the 7-day freemium version at the following link: <a href="https://archivosedwin.s3.amazonaws.com/Combinacion_Installer_Free.zip" target="_blank" rel="noreferrer noopener">Download the mail merge tool for individual Word and PDF documents</a></p>

<figure><a href="https://archivosedwin.s3.amazonaws.com/Combinacion_Installer_Free.zip" target="_blank" rel="noreferrer noopener"><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/23161428/descargar.png" alt="Merge Excel data into separate DOCX and PDF documents" width="400" height="124" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/23161428/descargar-300x93.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2024/07/23161428/descargar.png 400w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></a></figure>

<h2>Option 2: Buy a one-year license</h2>

<p>I recommend getting the one-year license, so you can merge into separate documents whenever you need to.</p>

<p>If you need more than one license, contact me on WhatsApp and you will get a discount.</p>

<p>{{productos:aplicativo-para-combinar-datos-de-excel-en-documentos-separados-docx-y-pdf,soporte-plus-para-las-plantillas-de-excel}}</p>

<h2>How to start the Excel-to-separate-documents merge application after downloading it</h2>

<figure class="video"><video controls preload="none" playsinline src="https://archivosedwin.s3.amazonaws.com/Ver+antes+de+usar.mp4"></video></figure>

<h2>Requirements</h2>

<p>The application works without any installation. All you need is the Office suite installed (Word and Excel) and an internet connection</p>

<p>{{articulos:excel}}</p>

<p>{{productos:soporte-plus-para-las-plantillas-de-excel,enviar-correos-masivos-con-adjuntos-y-copias-cc-y-cco,generador-de-codigos-de-barras-masivos-a-png,generador-de-codigos-qr-masivos-a-imagenes-png,generador-de-etiquetas-para-inventario-de-activos-fijos-en-excel-con-qr-y-codigos-de-barras,combinar-correspondencia-y-guardar-documentos-independientes}}</p>
HTML,
    ],
    117 => [
        'slug' => 'qr-codes-in-excel-how-to-create-them',
        'title' => 'QR Codes in Excel: How to Create Them',
        'excerpt' => 'QR codes are becoming a key tool in the creative and entrepreneurial projects of many people around the world. Learn how to create them in Excel, with or without macros.',
        'seo_title' => 'QR Codes in Excel: How to Create Them With or Without Macros',
        'seo_description' => 'Learn how to create QR codes in Excel: without macros using a simple Google chart API URL, or in bulk with a macro function for product labels and ID cards.',
        'focus_keyword' => 'QR codes in Excel',
        'content_html' => <<<'HTML'
<p>QR codes in Excel are a solution and a tool that is gaining ground in the creative and entrepreneurial projects of many people around the world.</p>

<p>Today we see QR codes in many different areas of commerce, because they can store many types of information. A QR code can hold data such as links to websites, text, contact details, connection details and even information for bank payments.</p>

<p>For all these reasons, QR codes have become very popular across the commercial sector, and they will very likely replace the old barcodes in the near future.</p>

<h2>How do you make a QR code without macros?</h2>

<p>Excel is a very powerful tool, but it has no built-in feature for creating <a href="/realidad-aumentada/" target="_blank" rel="noreferrer noopener">QR</a> codes. That is why, below, we will show you a way to create a function that turns the information in Excel cells into a working QR graphic.</p>

<p>To create QR codes in Excel we need to use some Google tools that belong to the <a rel="noreferrer noopener" href="https://developers.google.com/chart/infographics/docs/qr_codes" target="_blank">chart API for developers</a>, but this time we will use it to generate the graphic inside Excel.</p>

<p>Using the API is very easy; all you need is the following URL:</p>

<pre>http://chart.apis.google.com/chart?cht=qr&amp;chs=300x300&amp;chl= Edwin Ortiz</pre>

<p><br>Replace the characters after the equals sign (=), paste it into any browser, and as if by magic you get a QR code ready to use. Here is a video (click the image) where I explain in detail how to use it.</p>

<figure><a href="https://youtu.be/3yIej7eCt3ghttps://youtu.be/3yIej7eCt3g" target="_blank" rel="noopener noreferrer"><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133324/QR-sin-macros.fw_-1024x576.png" alt="QR codes in Excel" width="1024" height="576" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133324/QR-sin-macros.fw_-300x169.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133324/QR-sin-macros.fw_-600x338.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133324/QR-sin-macros.fw_-768x432.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133324/QR-sin-macros.fw_-1024x576.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133324/QR-sin-macros.fw_.png 1280w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></a></figure>

<h2>QR codes in Excel using macros</h2>

<p>Sometimes we need to create <a href="/producto/generador-de-codigos-qr-masivos/" target="_blank" rel="noreferrer noopener">QR codes in bulk</a> to make product labels, ID cards and so on, which will later be scanned with a mobile phone and stored in another Excel sheet. For this, we can use the following function, which works together with other Excel functions and ultimately produces QR codes in Excel, as easily as using the most basic function.</p>

<p>Below you will find 3 templates from my shop, plus the explanatory video (click the image) on how to create QR codes in Excel in bulk, and the code used in the video.</p>

<p>{{productos:generador-codigos-qr-de-productos-individuales,generador-de-codigos-qr-masivos,soporte-plus-para-las-plantillas-de-excel}}</p>

<figure><a href="https://youtu.be/CQKqDyUGdm4" target="_blank" rel="noopener noreferrer"><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133323/QR-Code.fw_-1024x576.png" alt="QR code in Excel with macros" width="1024" height="576" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133323/QR-Code.fw_-300x169.png 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133323/QR-Code.fw_-600x338.png 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133323/QR-Code.fw_-768x432.png 768w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133323/QR-Code.fw_-1024x576.png 1024w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/07/24133323/QR-Code.fw_.png 1280w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></a></figure>

<figure><a href="/producto/generador-de-codigos-qr-masivos/" target="_blank" rel="noopener noreferrer"><img src="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/08/24133319/codqr.jpg" alt="QR Codes in Excel: How to Create Them" width="730" height="570" srcset="https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/08/24133319/codqr-300x234.jpg 300w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/08/24133319/codqr-600x468.jpg 600w, https://blogedwinortiznet.s3.amazonaws.com/wp-content/uploads/2020/08/24133319/codqr.jpg 730w" sizes="(min-width: 760px) 720px, 100vw" loading="lazy" decoding="async"></a></figure>
HTML,
    ],
];
